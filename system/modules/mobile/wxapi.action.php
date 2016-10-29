<?php
defined('G_IN_SYSTEM')or exit('No permission resources.');
System::load_app_class('base','member','no');
System::load_app_fun('my');
System::load_app_fun('user');
System::load_sys_fun('user');

class wxapi extends base {

	public $fu = '' ; //FromUserName
	public $tu = '' ; //toUserName
	public $postStr = '' ; 
	public $siteurl = '' ; 


	public function __construct() {
		parent::__construct();
		$this->db=System::load_sys_class('model');

	}

	//验证微信服务器
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = 'yungou20150723';
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function valid()
    {
        //执行首次验证接口
		if($_GET["echostr"]){ 
			if($this->checkSignature()){
	        	echo $_GET["echostr"];
	        	exit;
	        }
	        else {
	        	echo 'CheckSignature is not true!' ;
	        }
		}
        if(!$this->checkSignature()) exit; 

        if($this->postStr == ''){ 
			$postStr = file_get_contents("php://input"); 
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}else{
			$postObj = $this->postStr;
		} 

		$this->fu = (string)$postObj->FromUserName;
		$this->tu = (string)$postObj->ToUserName;
		$MsgType  = (string)$postObj->MsgType; 
		switch ($MsgType) {
			case 'text':
				$content = strtolower(trim($postObj->Content)); //转为小写字母
				$this->wx_find($MsgType,$content);
				break;
			case 'image':
				$picurl = (string)$postObj->PicUrl;
				$this->wx_find($MsgType,$picurl);
				break;
			case 'location':
				$data = array();
			  	$data['wm_latitude'] = $postObj->Location_X;
			  	$data['wm_longitude'] = $postObj->Location_Y;
			  	$this->wx_find($MsgType,$data);
				break;
			case 'event':
				$event    = (string)$postObj->Event;
				$eventKey = (string)$postObj->EventKey;

				if($event == 'subscribe'){ 
					//关注事件
					$this->wx_find('subscribe',$eventKey);
					
				}elseif($event == 'unsubscribe'){
					//取消关注事件
					$this->wx_find('unsubscribe',$eventKey);
					
				}elseif($event == 'CLICK'){
					//单击菜单事件
					$this->wx_find('click',$eventKey);
				}elseif($event == 'LOCATION'){
					//地理位置事件 
					$data = array();
				  	$data['wm_latitude'] = $postObj->Latitude;
				  	$data['wm_longitude'] = $postObj->Longitude;
				  	//file_put_contents('loc.txt', $data);
				  	$this->wx_find('location',$data);
				}elseif($event == 'VIEW'){
					//点击菜单跳转连接事件
				}
				break;
			
			default:
				
				break;
		}
    }

    


	//根据不同类型请求回复
	private function wx_find($type,$data){

		$plus = 1 ; //是否添加openid参数
		switch ($type) {
			case 'text':
				if($data=='K_GET_USER_FXIMG'){
					$uid=_getcookie('uid');
					//如果用户未登录，提示登陆后操作
					if(!$uid){
						$res="<a href='{WEB_PATH}/mobile/user/login'>请登录后再试！</a>"
						$this->txt_tpl($res);
					}
					$imgmedia_id = fun_get_fx_img($this->fu,$uid);
					$this->image_tpl($imgmedia_id);
					exit;
				}
				$keyword= $data;  
				$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_text` WHERE `keyword`='$keyword'");
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'image': 
				$keyword= $data;
				$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_pic` ");
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'location':
				$map['wm_openid'] =$this->fu;
				$filename=$data['wm_latitude'].'|'.$data['wm_longitude'];
				// file_put_contents($this->fu.'.txt',$filename);
				break;
			case 'subscribe':
				$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_event` WHERE `event`='subscribe'");
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'unsubscribe':
				$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_event` WHERE `event`='unsubscribe'");
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'click':
				$keyword= $data;  
				$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_text` WHERE `keyword`='$keyword'");
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			default:
				$this->notfound();
				break;
		}
	}

	/*
	*  返回回复资源 
	*/
	protected function resouce($table,$rid,$plus = 1,$istype=0){
		$tablename = 'go_1024_wx_mate_'.$table ;
		if($table == 'text'){ 
			$arr=$this->db->GetOne("SELECT `text` FROM `$tablename` WHERE `id`=$rid");
			$text = $arr['text'];
			//处理转义
			$text = htmlspecialchars_decode($text);
			$text = str_replace('\n',"\n",$text);
			$text = str_replace('<br/>',"\n",$text);
			$text = str_replace('<br>',"\n",$text); 
			if($plus == 1) $text = $this->parseUrl($text) ; //替换标签为openid
			if($istype){
				$MsgType = 'transfer_customer_service';
				$this->txt_tpl($text,$MsgType);
			}else {

				$this->txt_tpl($text);
			}
			
		}elseif($table == 'news'){ 
			$data = array();
			
			$info=$this->db->GetOne("SELECT * FROM `$tablename` WHERE `id`=$rid");
			// $newsarr = M('1024_wx_mate_news_schedule')->where(array('mpid'=>$info['id']))->select();  //xiugai
			// $newsarr = $this->db->GetList("SELECT * FROM `@#_1024_wx_mate_news_schedule` WHERE `mpid`=".$info['id']);
			//图文素材资源拼凑
			//第一张图片
			$data[0]['title'] = $info['title'];
			$data[0]['intro'] = $info['intro'];
			$data[0]['pic'] = $this->parseNewsPic($info['cover']); 
			$data[0]['url'] = $this->parseNewsLink($info['link'],$info['id'],0);  
			$sonarr = array_filter(explode(',', $info['son'])) ;
			if(is_array($sonarr)){
				foreach ($sonarr as $k => $v) {
					$soninfo=$this->db->GetOne("SELECT * FROM `$tablename` WHERE `id`=$v");
					$data[$k+1]['title'] = $soninfo['title'];
					$data[$k+1]['intro'] = $soninfo['intro'];
					if($soninfo['cover']) {
						$data[$k+1]['pic'] = $this->parseNewsPic($soninfo['cover']); 
					}
					//统一调配出相关图文链接 
					$data[$k+1]['url'] = $this->parseNewsLink($soninfo['link'],$soninfo['id'],$k+1);  
				}
					
			}
			
			
			$this->news_tpl($data);
		}elseif($table == 'audio'){
			$info=$this->db->GetOne("SELECT * FROM `$tablename` WHERE `id`=$rid");
			$this->audio_tpl($info);
		}else{
			$this->notfound();
		}
	}
	/*
	* 未找到资源调用方法 
	*/
	protected function notfound(){
		$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_notfound` ");
		if($info){
			$this->resouce($info['table'],$info['rid']);
			exit();
		}
	}  
	/*
	* 格式化 回复的链接
	*/
	protected function parseUrl($url){
		$url = str_replace('{openid}',$this->fu,$url); //替换标签为openid
		$url = str_replace('{site}',$this->pathurl,$url); //替换站点路径
		return $url ; 
	}
	/**
	*  格式化 图文资源链接
	*　@param $link 链接地址 
	*　@param $id 图文素材ID   
	*  @param $offset 多图文偏移量 
	*/
	protected function parseNewsLink($link,$id='',$offset=0,$mpid=0){
		if(is_string($link) && strpos($link,'http://') === 0 ){
			return $this->parseUrl($link) ; //处理系统链接调换 
		}else{
			//返回系统链接 
			if(empty($this->siteurl)){
				$confarr =System::load_sys_config('system');
				$siteurl = $confarr['web_path'];
				$this->siteurl = $siteurl ;
			}
			else {
				$siteurl = $this->siteurl ;
			}
			return  $siteurl.'/?/mobile/mobile/wxpage/'.$id;
		} 
	}
	/**
	*  格式化 图文资源图片
	*　@param $link 链接地址   
	*/
	protected function parseNewsPic($link){
		if(is_string($link) && strpos($link,'http://') === 0 ){
			return $this->parseUrl($link) ; //处理系统链接调换 
		}else{
			
			return  G_UPLOAD_PATH.'/'.$link; 
		} 
	}

	/**
	* 文本回复 
	*/
	private function txt_tpl($content,$msgtype='text',$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$tpl	=	"<xml> 
				<ToUserName><![CDATA[".$fu."]]></ToUserName> 
				<FromUserName><![CDATA[".$tu."]]></FromUserName> 
				<CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
				<MsgType><![CDATA[".$msgtype."]]></MsgType> 
				<Content><![CDATA[".$content."]]></Content> 
				<FuncFlag>".$flag."</FuncFlag>
				</xml>";
		echo $tpl;
	} 
	private function image_tpl($content,$msgtype='image',$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$tpl	=	"<xml> 
				<ToUserName><![CDATA[".$fu."]]></ToUserName> 
				<FromUserName><![CDATA[".$tu."]]></FromUserName> 
				<CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
				<MsgType><![CDATA[".$msgtype."]]></MsgType> 
				<Image>
				<MediaId><![CDATA[".$content."]]></MediaId>
				</Image>
				</xml>";
		echo $tpl;
	} 
	/**
	* 图文回复 
	*/
	private function news_tpl($data,$msgtype='news',$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$num	=	count($data);
		if($num > 1){
			$add = $this->news_add($data);
			$tpl = " <xml>
					 <ToUserName><![CDATA[".$fu."]]></ToUserName>
					 <FromUserName><![CDATA[".$tu."]]></FromUserName>
					 <CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
					 <MsgType><![CDATA[".$msgtype."]]></MsgType> 
					 <Content><![CDATA[%s]]></Content> 
					 <ArticleCount>".$num."</ArticleCount> 
					 <Articles> 
					 ".$add."
					 </Articles> 
					 <FuncFlag>".$flag."</FuncFlag> 
					 </xml> ";
					 file_put_contents('tpl.txt', $tpl) ;
			echo $tpl;
		}else{
			$tpl = " <xml>
					 <ToUserName><![CDATA[".$fu."]]></ToUserName>
					 <FromUserName><![CDATA[".$tu."]]></FromUserName>
					 <CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
					 <MsgType><![CDATA[news]]></MsgType> 
					 <Content><![CDATA[%s]]></Content> 
					 <ArticleCount>1</ArticleCount> 
					 <Articles> 
					 <item> 
					 <Title><![CDATA[".$data[0]['title']."]]></Title> 
					 <Description><![CDATA[".$data[0]['intro']."]]></Description> 
					 <PicUrl><![CDATA[".$data[0]['pic']."]]></PicUrl> 
					 <Url><![CDATA[".$data[0]['url']."]]></Url> 
					 </item>
					 </Articles> 
					 <FuncFlag>".$flag."</FuncFlag> 
					 </xml> ";
					 file_put_contents('tpl.txt', $tpl) ;
			echo $tpl;
		}
	}
	
	protected function news_add($data){
		$add	=	"";
			foreach ($data as $k){
			$add	.= "<item> 
				 <Title><![CDATA[".$k['title']."]]></Title> 
				 <Description><![CDATA[".$k['intro']."]]></Description> 
				 <PicUrl><![CDATA[".$k['pic']."]]></PicUrl> 
				 <Url><![CDATA[".$k['url']."]]></Url> 
				 </item>  ";
			}
			return $add;
	}
	/**
	* 音频回复 
	*/
	private function audio_tpl($data,$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$tpl	=	"<xml>
					 <ToUserName><![CDATA[".$fu."]]></ToUserName>
					 <FromUserName><![CDATA[".$tu."]]></FromUserName>
					 <CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime>
					 <MsgType><![CDATA[music]]></MsgType>
					 <Music>
					 <Title><![CDATA[".$data['title']."]]></Title>
					 <Description><![CDATA[".$data['intro']."]]></Description>
					 <MusicUrl><![CDATA[".$data['nlink']."]]></MusicUrl>
					 <HQMusicUrl><![CDATA[".$data['wlink']."]]></HQMusicUrl>
					 </Music>
					 <FuncFlag>".$flag."</FuncFlag>
					 </xml>";
		echo $tpl;
	}

	
}
?>