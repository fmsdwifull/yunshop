<?php
class FunctionAction extends UserAction{
	function index(){
		$id=$this->_get('id','intval');

		if (!$id){
			//$token=$this->token;
			$info=M('Wxuser')->find(array('where'=>array('token'=>$this->token)));
		}else {
			$info=M('Wxuser')->find($id);
		}
		
		$token=$this->_get('token','trim');	
		if($info==false||$info['token']!=$token){
			$this->error('非法操作',U('Home/Index/index'));
		}
		session('token',$token);
		session('wxid',$info['id']);
		//第一次登陆　创建　功能所有权
		$token_open=M('Token_open');
		
		$toback=$token_open->field('id,queryname')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		//echo "token:".session('token')."<br>";
		//echo "uid:".session('uid')."<br>";
		//var_dump($toback);
		//die();
		
		$open['uid']=session('uid');
		$open['token']=session('token');
		//遍历功能列表
		if (!C('agent_version') || !$this->agentid ){
			$group=M('User_group')->field('id,name,func')->where('status=1 AND id = '.session('gid'))->order('id ASC')->find();
			$where['gid'] = array('elt', session('gid'));
			$funcs = M('Function')->where($where)->select();

			
			
		}else {
			$group=M('User_group')->field('id,name,func')->where('status=1 AND agentid='.$this->agentid.' AND id = '.session('gid'))->order('id ASC')->find();
			$funcs = M('Agent_function')->where(array('agentid'=>$this->agentid))->select();
			//echo "456";
			//die();

		}

		$check=explode(',',trim($toback['queryname'],','));

		foreach ($check as $ck => $cv){
			if(strpos($group['func'],$cv) === false){
				$group['func'] .= ','.$cv;
			}
		
		}

		$group['func'] = explode(',',$group['func']);
		
			foreach ($group['func'] as $gk=>$gv){
				
					$open_func = M('Token_open')->where(array('token'=>session('token'),'uid'=>session('uid')))->getField('queryname');

					if(strpos($open_func,$gv) === false){
						$where = array('funname'=>$gv,'status'=>1);
					}else{
						$where = array('funname'=>$gv);
					}
					
					if (C('agent_version')&&$this->agentid){
						$where['agentid'] = $this->agentid;
						$group['func'][$gk] = M('Agent_function')->where($where)->field('id,funname,name,info')->find();
					}else{
						$group['func'][$gk] = M('Function')->where($where)->field('id,funname,name,info')->find();
					}
					
				if($group['func'][$gk] == NULL){
					unset($group['func'][$gk]);
				}
			}
			
			
		$this->assign('fun',$group);
		
		$this->assign('funcs',$funcs);
	
		
		//
		$wecha=M('Wxuser')->field('wxname,wxid,headerpic,weixin')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('wecha',$wecha);
		$this->assign('token',session('token'));
		$this->assign('check',$check);
		$this->display();
	}



function info(){
		$qx=M('Users')->where(array('id'=>session('uid')))->find();
		
		//微信统计数
		$where=array('token'=>$this->token,'year'=>date('Y'),'month'=>date('m'),'day'=>date('d'));
		$list=M('Requestdata')->where($where)->find();
		$this->assign('list',$list);

		$id=$this->_get('id','intval');
		if (!$id){
			$token=$this->token;
			$info=M('Wxuser')->find(array('token'=>$this->token));
		}else {
			$info=M('Wxuser')->find($id);
		}
		$token=$this->_get('token','trim');	
		if($info==false||$info['token']!=$token){
			$this->error('非法操作',U('Home/Index/index'));
		}
		session('token',$token);
		session('wxid',$info['id']);
		//第一次登陆　创建　功能所有权
		$token_open=M('Token_open');
		$toback=$token_open->field('id,queryname')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$open['uid']=session('uid');
		$open['token']=session('token');
		//遍历功能列表
		if (!C('agent_version')){
			$group=M('User_group')->field('id,name')->where('status=1')->select();
		}else {
			$group=M('User_group')->field('id,name')->where('status=1 AND agentid='.$this->agentid)->select();
		}
		$check=explode(',',$toback['queryname']);
		$this->assign('check',$check);
		foreach($group as $key=>$vo){
			if (C('agent_version')&&$this->agentid){
				$fun=M('Agent_function')->where(array('status'=>1,'gid'=>$vo['id']))->select();
			}else {
				$fun=M('Function')->where(array('status'=>1,'gid'=>$vo['id']))->select();
			}
			foreach($fun as $vkey=>$vo){
				$function[$key][$vkey]=$vo;
			}
		}
		$this->assign('fun',$function);
		//
		$wecha=M('Wxuser')->field('wxname,wxid,headerpic,weixin')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('wecha',$wecha);
		$this->assign('token',session('token'));
		$this->assign('qx',$qx);
		//
		$this->display();
	}




}

?>