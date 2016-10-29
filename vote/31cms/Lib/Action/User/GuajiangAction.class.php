<?php
class GuajiangAction extends LotteryBaseAction{
	public function _initialize() {
		parent::_initialize();
		$function=M('Function')->where(array('funname'=>'gua2'))->find();
		if (intval($this->user['gid'])<intval($function['gid'])){
			$this->error('您的VIP权限不够,请到升级会员VIP',U('Alipay/vip',array('token'=>$this->token)));
		}
	}
	public function cheat(){
		parent::cheat();
		$this->display();
	}
	public function index(){
		parent::index(2);
		$this->display();
	
	}
	public function sn(){
		parent::sn(2);
		$this->display('Lottery:sn');
	}
	public function add(){
		parent::add(2);
	}
	
	public function edit(){
		parent::edit(2);
	}
}


?>