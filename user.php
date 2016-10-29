<?php
require('basic.php');
$db_config['default']['tablepre']='tp_';

if($_COOKIE['uid']){
		if($_POST['id']){
			$m=new Mysql('vote_item',$db_config);
			$where['id']=2;
			$m->where($where)->setInc('vcount');
			
			$result['status']='success';
			$result['content']='投票成功';
			
		
			
		}else{
			$result['status']='error';
			$result['content']='投票失败';
		}
		
}else{
		$result['status']='login';
}







echo json_encode($result);

