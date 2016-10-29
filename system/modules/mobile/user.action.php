<?php

defined('G_IN_SYSTEM')or exit('No permission resources.');
System::load_app_class('memberbase',null,'no');
System::load_app_fun('user','go');
System::load_app_fun('my','go');
System::load_sys_fun('send');
class user extends memberbase {
	public function __construct(){
		parent::__construct();
		$this->db = System::load_sys_class("model");
	}

	public function cook_end(){
		_setcookie("uid","",time()-3600);
		_setcookie("ushell","",time()-3600);
		//_message("退出成功",WEB_PATH."/mobile/mobile/");
		header("location: ".WEB_PATH."/mobile/mobile/");
	}
	//返回登录页面
	public function login(){
		$webname=$this->_cfg['web_name'];
		$user = $this->userinfo;
		
		if($user){
			header("Location:".WEB_PATH."/mobile/home/");exit;
		}

		
		
		
		
		
		
		
		



		if($this->is_wxbrow()){
			$cfg=System::load_sys_config('weixin');
		    	$appid = $cfg['appid'] ; 
		    	$appsecret = $cfg['appsecret'] ;

			    if (!isset($_GET['code'])) {
			        // $back = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			        $back = WEB_PATH."/mobile/user/login/" ;

			        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$back&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

			        Header("Location: $url");
			        exit();
			    } else {  
		            $formeat = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		            $code = $_GET['code']; 
			        
			        $openidurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code" ;
			        $ch = curl_init();
		            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		            curl_setopt($ch, CURLOPT_URL, $openidurl);
		            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		            curl_setopt($ch, CURLOPT_HEADER, FALSE);
		            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		            $res = curl_exec($ch);
		            curl_close($ch);
		            $opendata = json_decode($res,true);
		            $openid = $opendata['openid'];
		            $access_token = $opendata['access_token'];
		           
			$userinfo=$this->db->GetOne("SELECT * from `@#_member` where `openid` = '$openid'");
			        if($userinfo){
			            	//跟新session
			            	_setcookie("uid",_encrypt($userinfo['uid']),60*60*24*7);
					_setcookie("ushell",_encrypt(md5($userinfo['uid'].$userinfo['password'].$userinfo['mobile'].$userinfo['email'])),60*60*24*7);
					header("location: $formeat");
			        }else{
		            	//注册  
		            	//获取用户的详细信息
			                $userinfourl = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
			                $chr = curl_init();
			                curl_setopt($chr, CURLOPT_TIMEOUT, 30);
			                curl_setopt($chr, CURLOPT_URL, $userinfourl);
			                curl_setopt($chr,CURLOPT_SSL_VERIFYPEER,FALSE);
			                curl_setopt($chr,CURLOPT_SSL_VERIFYHOST,FALSE);
			                curl_setopt($chr, CURLOPT_HEADER, FALSE);
			                curl_setopt($chr, CURLOPT_RETURNTRANSFER, TRUE);
			                $userinfo = curl_exec($chr);
			                curl_close($chr);
			                $uinfo = json_decode($userinfo,true);
			                //插入用户数据

			                $username=$uinfo['nickname'];
			                $img=$uinfo['headimgurl'];
			                _setcookie('bd_nickname',$username);
				    _setcookie('bd_headimgurl',$img);
				    _setcookie('bd_openid',$openid);
				    include templates("mobile/user","bangding");
		       		    exit;   
		           	}
		        }
		}else {
			include templates("mobile/user","login");
		}
		

	}
	//返回注册页面
	public function register(){
	  $webname=$this->_cfg['web_name'];
		include templates("mobile/user","register");
	}

	//返回发送验证码页面
	public function mobilecode(){
	    $webname=$this->_cfg['web_name'];
	    $mobilename=$this->segment(4);

		include templates("mobile/user","mobilecheck");
	}

	public function mobilecheck(){
	    $webname=$this->_cfg['web_name'];
		$title="验证手机";
		$time=3000;
		$name=$this->segment(4);
		$member=$this->db->GetOne("SELECT * FROM `@#_member` WHERE `mobile` = '$name' LIMIT 1");
		 //var_dump($member);exit;
		if(!$member)_message("参数不正确!");
		if($member['mobilecode']==1){
			_message("该账号验证成功",WEB_PATH."/mobile/mobile/glist/");
		}
		if($member['mobilecode']==-1){
			$sendok = send_mobile_reg_code($name,$member['uid']);
			if($sendok[0]!=1){
					_message($sendok[1]);
			}
			header("location:".WEB_PATH."/mobile/user/mobilecheck/".$member['mobile']);
			exit;
		}


		$enname=substr($name,0,3).'****'.substr($name,7,10);
		$time=120;
		include templates("mobile/user","mobilecheck");
	}


	public function buyDetail(){
	 $webname=$this->_cfg['web_name'];
	 $member=$this->userinfo;
	 $itemid=intval($this->segment(4));

	 $itemlist=$this->db->GetList("select *,a.time as timego,sum(gonumber) as gonumber from `@#_member_go_record` a left join `@#_shoplist` b on a.shopid=b.id where a.uid='$member[uid]' and b.id='$itemid' group by a.id order by a.time" );

	 if(!empty($itemlist)){
		 if($itemlist[0]['q_end_time']!=''){
	   //商品已揭晓
			$itemlist[0]['codeState']='已揭晓...';
			$itemlist[0]['class']='z-ImgbgC02';
	    }elseif($itemlist[0]['shenyurenshu']==0){
		//商品购买次数已满
			$itemlist[0]['codeState']='已满员...';
			$itemlist[0]['class']='z-ImgbgC01';
		}else{
		//进行中
			$itemlist[0]['codeState']='进行中...';
			$itemlist[0]['class']='z-ImgbgC01';

		}
		$bl=($itemlist[0]['canyurenshu']/$itemlist[0]['zongrenshu'])*100;

		foreach ($itemlist as $k => $v) {
			$count += $v['gonumber'];
		}
	}
	$count = $count ? $count : 0;
     //echo "<pre>";
	 //print_r($itemlist);
	 include templates("mobile/user","userbuyDetail");
	}
	/** 判断请求来源是否是微信内置浏览器 
	*/
	private function is_wxbrow(){
	    $agent = strtolower($_SERVER['HTTP_USER_AGENT']); 
	    $fg  = strpos($agent , "micromessenger") ; 
	    if($fg === false ) return false ;
	    else return true ;
	}
	/**
	 * 微信接口  此步获取用户信息
	 */
	public function wx_login(){

	}
}
?>