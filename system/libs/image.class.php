<?php
		//图片处理类
class Image{
	private $path;

	//构造方法 对图片所在位置进行初始化
	//路径
	// function __construct($path="./"){
	// 	//rtirm:删除用户输入的/  之后再加上/
	// 	$this->path=rtrim($path,'/').'/';
	// }

	//缩放方法    
	//返回值就是缩放后的图片名 失败则返回假
	//需要处理图片名 缩放后宽度 缩放高度 新图片前缀
	function thumb($name,$width,$height,$uid){
		//获取图片信息   宽 高 类型
		$imgInfo=$this->getInfo($name);

		//获取图片资源  各种类型图片都可创建资源 jpg gif png
		//传入原图片名  原图片信息  
		//返回原图片资源
		$srcImg=$this->getImg($name,$imgInfo);

		//获取图片计算后等比例大小
		//传入 原图片名 缩放后宽  缩放后高  原图片信息(宽高类型)
		//返回数组
		//$size["width"] $size["height"]
		$size=$this->getNewSize($name,$width,$height,$imgInfo);
		
		//获取图片新图片资源, 处理gif透明度问题
		//传入 原图片资源 缩放后图片信息 原图片信息
		$newImg=$this->kidOfImage($srcImg,$size,$imgInfo);
		$baseimg=basename($name);
			$newName=G_UPLOAD.'qrcode/'.$uid.'/'.$baseimg;
			if(!file_exists(G_UPLOAD.'qrcode/'.$uid.'/')){
				mkdir(G_UPLOAD.'qrcode/'.$uid.'/');
			}
		//imagejpeg($newImg);
	
		//另存为新图片  返回新缩放后图片名
		return $this->createNewImage($newImg,$newName,$imgInfo);
	}
	//获取图片信息方法  宽 高 类型
	private function getInfo($name){

		//获取信息 返回一个数组
		$date=getImageSize($name);
		$imageInfo["width"]=$date[0];//宽
		$imageInfo["height"]=$date[1];//高
		$imageInfo["type"]=$date[2];//类型 返回整数参数 依照php手册参数
		//返回数组  图片信息
		
		return $imageInfo;
	}
	//获取各种图片资源的私有方法
	private function getImg($name,$imgInfo){
		//得到图片全路径
		$srcPic=$name;
		//获取到原图片类型
		switch($imgInfo["type"]){
		case 1://gif
			$img=imagecreatefromgif($srcPic);
			break;
		case 2://jpg
			$img=imagecreatefromjpeg($srcPic);
			break;
		case 3://png
			$img=imagecreatefrompng($srcPic);
			break;
		default:
			return false;
		}
		//返回图片资源
		return $img;
	}
	//获取缩放后的宽 高
	private function getNewSize($name,$width,$height,$imgInfo){
		//原图片信息赋给$size
		$size["width"] = $imgInfo["width"];
		$size["height"] = $imgInfo["height"];
		//缩放的宽度如果比原图小才重新设设置
		if($width < $imgInfo["width"]){
			$size["width"]=$width;
		}
		//缩放高度小于原图高 则设置高度
		if($height < $imgInfo["height"]){
			$size["height"]=$height;
		}
		//等比例缩放算法  求出缩放后的宽高
		if($imgInfo["width"]*$size["width"] > $imgInfo["height"]*$size["height"]){
			$size["height"] = round($imgInfo["height"] * $size["width"] / $imgInfo["width"]);
		}else{
			$size["width"] = round($imgInfo["width"] * $size["height"] / $imgInfo["height"]);
		}
		return $size;
	}
	//处理透明色
	private function kidOfImage($srcImg,$size,$imgInfo){
		//创建新图片资源
		//传入  新图片宽  新图片高
		$newImg=imagecreatetruecolor($size["width"],$size["height"]);
		//处理透明色
		//取出原图透明色指数
		$otsc=imagecolortransparent($srcImg);
		//判断有没有透明色 判断透明色是否在调色板中
		if($otsc >=0 && $otsc <= imagecolorstotal($srcImg)){
			//取出原图片透明色索引颜色
			$tran=imagecolorsforindex($srcImg,$otsc);
			//创建一个新的颜色等于索引颜色 分配在新图片上
			$newt=imagecolorallocate($newImg,$tran["red"],$tran["green"],$tran["blue"]);
			//在新的图片中填充透明色索引颜色
			imagefill($newImg,0,0,$newt);
			//将新图片中的透明色索引颜色指定为透明色
			imagecolortransparent($newImg,$newt);
		}
		//拷贝图片
		//新图片资源 原图片资源  新图片x位置 新图片y位置 原图片x位置 原图片y位置 新图片宽 新图片高 原图片宽 原图片高
		imagecopyresized($newImg,$srcImg,0,0,0,0,$size["width"],$size["height"],$imgInfo["width"],$imgInfo["height"]);
		//销毁原图片资源
		imagedestroy($srcImg);
		//返回新图片资源
		return $newImg;
	}
	//保存新图片
	private function createNewImage($newImg,$newName,$imgInfo){

		switch($imgInfo["type"]){
		case 1://gif
				//保存新图片  
			//传入 新图片资源 保存路径
			$result=imageGif($newImg,$newName);
			break;
		case 2://jpg
			$result=imageJPEG($newImg,$newName);
			break;
		case 3://png
			$result=imagePNG($newImg,$newName);
			break;
		}

		//销毁新图片资源
		imagedestroy($newImg);
		return $newName;
	}

	//加水印方法 
	//位置  10中状态：
	//	0 为随机
	//	1 顶端居左	2 顶端居中	3 为低端居右	
	//	4 为中部居左	5 为中部居中	6 为中部居右
	//	7 底部居左	8 底部居中	9 底部居右
	//处理背景图片名  水印图片 位置 加水印后图片前缀前缀
	function waterMark($groundName,$waterName,$waterPos=0,$uid){
		//判断图片是否存在
		
		if(file_exists($groundName) && file_exists($waterName)){

			//获取图片信息
			$groundInfo=$this->getInfo($groundName);
			$waterInfo=$this->getInfo($waterName);
			//水印的位置
			if(!$pos=$this->position($groundInfo,$waterInfo,$waterPos)){
				echo '水印位置获取失败';
				return;	
			}

			//获取背景图片资源
			$groundImg=$this->getImg($groundName,$groundInfo);
			//获取水印图片资源
			$waterImg=$this->getImg($waterName,$waterInfo);
			//拷贝添加水印
			$groundImg=$this->copyImage($groundImg,$waterImg,$pos,$waterInfo);
			$baseimg=basename($groundName);
			$newGroundName=G_UPLOAD.'qrcode/'.$uid.'/'.$baseimg;
			if(!file_exists(G_UPLOAD.'qrcode/'.$uid.'/')){
				mkdir(G_UPLOAD.'qrcode/'.$uid.'/');
			}
			//保存图片  可返回生成文件名
			return $this->createNewImage($groundImg,$newGroundName,$groundInfo);
		}else{

			echo '图片或水印图片不存在';
			return false;
		}
	}
	//添加水印
	private function copyImage($groundImg,$waterImg,$pos,$waterInfo){
		imagecopy($groundImg,$waterImg,$pos["posX"],$pos["posY"],0,0,$waterInfo["width"],$waterInfo["height"]);
		imagedestroy($waterImg);
		return $groundImg;
	}
	//确定水印位置
	private function position($groundInfo,$waterInfo,$waterPos){
		//需要背景图片比水印图片大
	//	if($groundInfo["width"] < $waterInfo["width"] || $groundInfo["height"] < $waterInfo["height"]){
	//		return false;
	//	}
		switch($waterPos){
		case 1:
			$posX=0;
			$posY=0;
			break;
		case 2:
			$posX=($groundInfo["width"] - $waterInfo["width"]) / 2;
			$posY=0;
			break;
		case 3:
			$posX=$groundInfo["width"] - $waterInfo["width"];
			$posY=0;
			break;
		case 4:
			$posX=0;
			$posY=($groundInfo["height"] - $waterInfo["height"]) / 2;
			break;
		case 5:
			$posX=($groundInfo["width"] - $waterInfo["width"]) / 2;
			$posY=($groundInfo["height"] - $waterInfo["height"]) / 2;
			break;
		case 6:
			$posX=$groundInfo["width"] - $waterInfo["width"];
			$posY=($groundInfo["height"] - $waterInfo["height"]) / 2;
			break;
		case 7:
			$posX=0;
			$posY=$groundInfo["height"]-$waterInfo["height"];
			break;
		case 8:
			$posX=($groundInfo["width"] - $waterInfo["width"]) / 2;
			$posY=$groundInfo["height"] - $waterInfo["height"];
			break;
		case 9:
			$posX=$groundInfo["width"] - $waterInfo["width"];
			$posY=$groundInfo["height"] - $waterInfo["height"];
			break;
		case 10:
			$posX=($groundInfo["width"] - $waterInfo["width"]) / 2;
			$posY=550;
			break;
		case 11:
			$posX=($groundInfo["width"] - $waterInfo["width"]) / 2;
			$posY=269;
			break;
		case 0:
		default:
			$posX=rand(0,$groundInfo["width"] - $waterInfo["width"]);
			$posY=rand(0,$groundInfo["height"] - $waterInfo["height"]);
		}
		return array("posX"=>$posX,"posY"=>$posY);
	}

}
