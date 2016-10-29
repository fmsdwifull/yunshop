<?php

class LvyouAction extends UserAction{
	public function index(){	
		$token_open=M('token_open')->field('queryname')->where(array('token'=>$_SESSION['token']))->find();
		if(!strpos($token_open['queryname'],'Lvyou')){
        $this->error('您的VIP权限不够,请到升级会员VIP',U('Alipay/vip',array('token'=>$_SESSION['token'],'id'=>session('wxid'))));}
		$db=D('Lvyou');
		$where['token']=session('token');
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$info=$db->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('page',$page->show());
		$this->assign('info',$info);
		$this->display();
	}
	public function add(){
		$this->display();
	}
	
	public function edit(){
		$id=$this->_get('id','intval');
		$info=M('Lvyou')->find($id);
		$this->assign('info',$info);
		$this->display();
	}
	
	public function del(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		if(D(MODULE_NAME)->where($where)->delete()){
				M('Keyword')->where(array('pid'=>$where['id'],'token'=>session('token'),'module'=>'Lvyou'))->delete();
			$this->success('操作成功',U(MODULE_NAME.'/index'));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	public function insert(){
		$this->all_insert();
	}
	public function upsave(){
		$this->all_save();
	}
}
?>

