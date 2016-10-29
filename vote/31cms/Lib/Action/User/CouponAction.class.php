<?php
class CouponAction extends LotteryBaseAction {
	public function _initialize() {
		parent::_initialize();
		$function=M('Function')->where(array('funname'=>'choujiang'))->find();
		if (intval($this->user['gid'])<intval($function['gid'])){
			$this->error('您的VIP权限不够,请到升级会员VIP',U('Alipay/vip',array('token'=>$this->token)));
		}
	}
	public function index(){
		parent::index(3);
		$this->display();
	}
	public function sn(){
		parent::sn(3);
		$this->display('Lottery:sn');
	}
	public function add(){
		parent::add(3);
	}
	public function edit(){
		parent::edit(3);
	}
}


?>