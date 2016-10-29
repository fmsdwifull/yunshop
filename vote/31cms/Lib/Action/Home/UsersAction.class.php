<?php
class UsersAction extends BaseAction{
	public function index(){
		header("Location: /");
	}
	public function companylogin() {

		$dbcom = D('Company');
		$where['username'] = $this->_post('username','trim');
		$cid = $where['id'] = $this->_post('cid', 'intval');
		$k = $this->_post('k','trim, htmlspecialchars');
		if (empty($k) || $k != md5($where['id'] . $where['username'])) {
			$this->error('帐号密码错误',U('Home/Index/clogin', array('cid' => $cid, 'k' => $k)));
		}
		
		$pwd = $this->_post('password','trim,md5');
		$company = $dbcom->where($where)->find();
		if($company && ($pwd === $company['password'])){
			if ($wxuser = D('Wxuser')->where(array('token' => $company['token']))->find()) {
				$uid = $wxuser['uid'];
				$db = D('Users');
				$res = $db->where(array('id' => $uid))->find();
			} else {
				$this->error('帐号密码错误',U('Home/Index/clogin', array('cid' => $cid, 'k' => $k)));
			}
			session('companyk', $k);
			session('companyLogin', 1);
			session('companyid', $company['id']);
			session('token', $company['token']);
			session('uid',$res['id']);
			session('gid',$res['gid']);
			session('uname',$res['username']);
			$info=M('user_group')->find($res['gid']);
			session('diynum',$res['diynum']);
			session('connectnum',$res['connectnum']);
			session('activitynum',$res['activitynum']);
			session('viptime',$res['viptime']);
			session('gname',$info['name']);
			//每个月第一次登陆数据清零
			$now=time();
			$month=date('m',$now);
			if($month!=$res['lastloginmonth']&&$res['lastloginmonth']!=0){
				$data['id']=$res['id'];
				$data['imgcount']=0;
				$data['diynum']=0;
				$data['textcount']=0;
				$data['musiccount']=0;
				$data['connectnum']=0;
				$data['activitynum']=0;
				$db->save($data);
				//
				session('diynum',0);
				session('connectnum',0);
				session('activitynum',0);
			}
			//登陆成功，记录本月的值到数据库
			
			//
			$db->where(array('id'=>$res['id']))->save(array('lasttime'=>$now,'lastloginmonth'=>$month,'lastip'=>$_SERVER['REMOTE_ADDR']));//最后登录时间
			$this->success('登录成功',U('User/Repast/index',array('cid' => $cid)));
		} else{
			$this->error('帐号密码错误',U('Home/Index/clogin', array('cid' => $cid, 'k' => $k)));
		}
	}

	public function companyLogout()
	{
		$cid = session('companyid');
		$k = session('companyk');
		session(null);
		session_destroy();
		unset($_SESSION);
        if(session('?'.C('USER_AUTH_KEY'))) {
            session(C('USER_AUTH_KEY'),null);
           
            redirect(U('Home/Index/clogin', array('cid' => $cid, 'k' => $k)));
        } else {
            $this->success('已经登出！', U('Home/Index/clogin', array('cid' => $cid, 'k' => $k)));
        }
    
		
	}
	public function checklogin(){
		//isAu();
		$verifycode=$this->_post('verifycode2','intval,md5',0);
		if (isset($_POST['verifycode2'])){
			if($verifycode != $_SESSION['loginverify']){
				$this->error('验证码错误',U('Index/login'));
			}
		}
		$db=D('Users');
		$where['username']=$this->_post('username','trim');
		
		// if($db->create()==false)
			// $this->error($db->getError());
		$pwd=$this->_post('password','trim,md5');
		$res=$db->where($where)->find();
		if($res&&($pwd===$res['password'])){
			
			if($res['status']==0){
				$this->error('请联系在线客户，为你人工审核帐号');exit;
			}
		$token_where['uid'] = $res['id'];
		$tokendb = D('token_open');
		$token = $tokendb->where($token_where)->getField('token');
			session('uid',$res['id']);
			session('gid',$res['gid']);
			session('uname',$res['username']);
			$info=M('user_group')->find($res['gid']);
			session('diynum',$res['diynum']);
			session('connectnum',$res['connectnum']);
			session('activitynum',$res['activitynum']);
			session('viptime',$res['viptime']);
			session('gname',$info['name']);
			session('token',$token);
			//每个月第一次登陆数据清零
			$now=time();
			$month=date('m',$now);
			if($month!=$res['lastloginmonth']&&$res['lastloginmonth']!=0){
				$data['id']=$res['id'];
				$data['imgcount']=0;
				$data['diynum']=0;
				$data['textcount']=0;
				$data['musiccount']=0;
				$data['connectnum']=0;
				$data['activitynum']=0;
				$db->save($data);
				//
				session('diynum',0);
				session('connectnum',0);
				session('activitynum',0);
			}
			//登陆成功，记录本月的值到数据库
			
			//
			$db->where(array('id'=>$res['id']))->save(array('lasttime'=>$now,'lastloginmonth'=>$month,'lastip'=>htmlspecialchars(trim(get_client_ip()))));//最后登录时间
			$this->success('登录成功',U('User/Vote/index'));
		}else{
			$this->error('帐号密码错误',U('Index/login'));
		}
	}
	function randStr($randLength){
		$randLength=intval($randLength);
		$chars='abcdefghjkmnpqrstuvwxyz';
		$len=strlen($chars);
		$randStr='';
		for ($i=0;$i<$randLength;$i++){
			$randStr.=$chars[rand(0,$len-1)];
		}
		return $randStr;
	}
	public function checkreg(){

	}
	
//前台短信验证开始
 public function get_sms_auth_code() {           
    }

public function checkAuthCode(){

	if($_POST['tel_auth_code'] != '' && $_POST['tel_auth_code'] == session('smsAuthCode')){
		$this->ajaxReturn('1','json');
	}else{
		$this->ajaxReturn('2','json');
	}
}

protected function sendSMS($http,$uid,$pwd,$mobile,$content,$mobileids,$time='',$mid='')
{
}

protected function postSMS($url,$data='')
{
}    

//前台短信验证结束


	public function checkpwd(){

		$where['username']=$this->_post('username');
		$where['email']=$this->_post('email');
		$db=D('Users');
		$list=$db->where($where)->find();
		if($list==false) $this->error('邮箱和帐号不正确',U('Index/regpwd'));
		
		$smtpserver = C('email_server'); 
		$port = C('email_port');
		$smtpuser = C('email_user');
		$smtppwd = C('email_pwd');
		$mailtype = "TXT";
		$sender = C('email_user');
		$smtp = new Smtp($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
		$to = $list['email']; 
		$subject = C('pwd_email_title');
		$code = C('site_url').U('Index/resetpwd',array('uid'=>$list['id'],'code'=>md5($list['id'].$list['password'].$list['email']),'resettime'=>time()));
		$fetchcontent = C('pwd_email_content');
		$fetchcontent = str_replace('{username}',$where['username'],$fetchcontent);
		$fetchcontent = str_replace('{time}',date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']),$fetchcontent);
		$fetchcontent = str_replace('{code}',$code,$fetchcontent);
		$body=$fetchcontent;
		//$body = iconv('UTF-8','gb2312',$fetchcontent);inv
		$send=$smtp->sendmail($to,$sender,$subject,$body,$mailtype);
		$this->success('请访问你的邮箱 '.$list['email'].' 验证邮箱后登录!<br/>');
		
	}
	
	public function resetpwd(){
		$where['id']=$this->_post('uid','intval');
		$where['password']=$this->_post('password','md5');
		if(M('Users')->save($where)){
			$this->success('修改成功，请登录！',U('Index/login'));
		}else{
			$this->error('密码修改失败！',U('Index/index'));
		}
	}
	
}