<?php
		//ͼƬ������
class Image{
	private $path;

	//���췽�� ��ͼƬ����λ�ý��г�ʼ��
	//·��
	// function __construct($path="./"){
	// 	//rtirm:ɾ���û������/  ֮���ټ���/
	// 	$this->path=rtrim($path,'/').'/';
	// }

	//���ŷ���    
	//����ֵ�������ź��ͼƬ�� ʧ���򷵻ؼ�
	//��Ҫ����ͼƬ�� ���ź��� ���Ÿ߶� ��ͼƬǰ׺
	function thumb($name,$width,$height,$uid){
		//��ȡͼƬ��Ϣ   �� �� ����
		$imgInfo=$this->getInfo($name);

		//��ȡͼƬ��Դ  ��������ͼƬ���ɴ�����Դ jpg gif png
		//����ԭͼƬ��  ԭͼƬ��Ϣ  
		//����ԭͼƬ��Դ
		$srcImg=$this->getImg($name,$imgInfo);

		//��ȡͼƬ�����ȱ�����С
		//���� ԭͼƬ�� ���ź��  ���ź��  ԭͼƬ��Ϣ(�������)
		//��������
		//$size["width"] $size["height"]
		$size=$this->getNewSize($name,$width,$height,$imgInfo);
		
		//��ȡͼƬ��ͼƬ��Դ, ����gif͸��������
		//���� ԭͼƬ��Դ ���ź�ͼƬ��Ϣ ԭͼƬ��Ϣ
		$newImg=$this->kidOfImage($srcImg,$size,$imgInfo);
		$baseimg=basename($name);
			$newName=G_UPLOAD.'qrcode/'.$uid.'/'.$baseimg;
			if(!file_exists(G_UPLOAD.'qrcode/'.$uid.'/')){
				mkdir(G_UPLOAD.'qrcode/'.$uid.'/');
			}
		//imagejpeg($newImg);
	
		//���Ϊ��ͼƬ  ���������ź�ͼƬ��
		return $this->createNewImage($newImg,$newName,$imgInfo);
	}
	//��ȡͼƬ��Ϣ����  �� �� ����
	private function getInfo($name){

		//��ȡ��Ϣ ����һ������
		$date=getImageSize($name);
		$imageInfo["width"]=$date[0];//��
		$imageInfo["height"]=$date[1];//��
		$imageInfo["type"]=$date[2];//���� ������������ ����php�ֲ����
		//��������  ͼƬ��Ϣ
		
		return $imageInfo;
	}
	//��ȡ����ͼƬ��Դ��˽�з���
	private function getImg($name,$imgInfo){
		//�õ�ͼƬȫ·��
		$srcPic=$name;
		//��ȡ��ԭͼƬ����
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
		//����ͼƬ��Դ
		return $img;
	}
	//��ȡ���ź�Ŀ� ��
	private function getNewSize($name,$width,$height,$imgInfo){
		//ԭͼƬ��Ϣ����$size
		$size["width"] = $imgInfo["width"];
		$size["height"] = $imgInfo["height"];
		//���ŵĿ�������ԭͼС������������
		if($width < $imgInfo["width"]){
			$size["width"]=$width;
		}
		//���Ÿ߶�С��ԭͼ�� �����ø߶�
		if($height < $imgInfo["height"]){
			$size["height"]=$height;
		}
		//�ȱ��������㷨  ������ź�Ŀ��
		if($imgInfo["width"]*$size["width"] > $imgInfo["height"]*$size["height"]){
			$size["height"] = round($imgInfo["height"] * $size["width"] / $imgInfo["width"]);
		}else{
			$size["width"] = round($imgInfo["width"] * $size["height"] / $imgInfo["height"]);
		}
		return $size;
	}
	//����͸��ɫ
	private function kidOfImage($srcImg,$size,$imgInfo){
		//������ͼƬ��Դ
		//����  ��ͼƬ��  ��ͼƬ��
		$newImg=imagecreatetruecolor($size["width"],$size["height"]);
		//����͸��ɫ
		//ȡ��ԭͼ͸��ɫָ��
		$otsc=imagecolortransparent($srcImg);
		//�ж���û��͸��ɫ �ж�͸��ɫ�Ƿ��ڵ�ɫ����
		if($otsc >=0 && $otsc <= imagecolorstotal($srcImg)){
			//ȡ��ԭͼƬ͸��ɫ������ɫ
			$tran=imagecolorsforindex($srcImg,$otsc);
			//����һ���µ���ɫ����������ɫ ��������ͼƬ��
			$newt=imagecolorallocate($newImg,$tran["red"],$tran["green"],$tran["blue"]);
			//���µ�ͼƬ�����͸��ɫ������ɫ
			imagefill($newImg,0,0,$newt);
			//����ͼƬ�е�͸��ɫ������ɫָ��Ϊ͸��ɫ
			imagecolortransparent($newImg,$newt);
		}
		//����ͼƬ
		//��ͼƬ��Դ ԭͼƬ��Դ  ��ͼƬxλ�� ��ͼƬyλ�� ԭͼƬxλ�� ԭͼƬyλ�� ��ͼƬ�� ��ͼƬ�� ԭͼƬ�� ԭͼƬ��
		imagecopyresized($newImg,$srcImg,0,0,0,0,$size["width"],$size["height"],$imgInfo["width"],$imgInfo["height"]);
		//����ԭͼƬ��Դ
		imagedestroy($srcImg);
		//������ͼƬ��Դ
		return $newImg;
	}
	//������ͼƬ
	private function createNewImage($newImg,$newName,$imgInfo){

		switch($imgInfo["type"]){
		case 1://gif
				//������ͼƬ  
			//���� ��ͼƬ��Դ ����·��
			$result=imageGif($newImg,$newName);
			break;
		case 2://jpg
			$result=imageJPEG($newImg,$newName);
			break;
		case 3://png
			$result=imagePNG($newImg,$newName);
			break;
		}

		//������ͼƬ��Դ
		imagedestroy($newImg);
		return $newName;
	}

	//��ˮӡ���� 
	//λ��  10��״̬��
	//	0 Ϊ���
	//	1 ���˾���	2 ���˾���	3 Ϊ�Ͷ˾���	
	//	4 Ϊ�в�����	5 Ϊ�в�����	6 Ϊ�в�����
	//	7 �ײ�����	8 �ײ�����	9 �ײ�����
	//������ͼƬ��  ˮӡͼƬ λ�� ��ˮӡ��ͼƬǰ׺ǰ׺
	function waterMark($groundName,$waterName,$waterPos=0,$uid){
		//�ж�ͼƬ�Ƿ����
		
		if(file_exists($groundName) && file_exists($waterName)){

			//��ȡͼƬ��Ϣ
			$groundInfo=$this->getInfo($groundName);
			$waterInfo=$this->getInfo($waterName);
			//ˮӡ��λ��
			if(!$pos=$this->position($groundInfo,$waterInfo,$waterPos)){
				echo 'ˮӡλ�û�ȡʧ��';
				return;	
			}

			//��ȡ����ͼƬ��Դ
			$groundImg=$this->getImg($groundName,$groundInfo);
			//��ȡˮӡͼƬ��Դ
			$waterImg=$this->getImg($waterName,$waterInfo);
			//�������ˮӡ
			$groundImg=$this->copyImage($groundImg,$waterImg,$pos,$waterInfo);
			$baseimg=basename($groundName);
			$newGroundName=G_UPLOAD.'qrcode/'.$uid.'/'.$baseimg;
			if(!file_exists(G_UPLOAD.'qrcode/'.$uid.'/')){
				mkdir(G_UPLOAD.'qrcode/'.$uid.'/');
			}
			//����ͼƬ  �ɷ��������ļ���
			return $this->createNewImage($groundImg,$newGroundName,$groundInfo);
		}else{

			echo 'ͼƬ��ˮӡͼƬ������';
			return false;
		}
	}
	//���ˮӡ
	private function copyImage($groundImg,$waterImg,$pos,$waterInfo){
		imagecopy($groundImg,$waterImg,$pos["posX"],$pos["posY"],0,0,$waterInfo["width"],$waterInfo["height"]);
		imagedestroy($waterImg);
		return $groundImg;
	}
	//ȷ��ˮӡλ��
	private function position($groundInfo,$waterInfo,$waterPos){
		//��Ҫ����ͼƬ��ˮӡͼƬ��
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
