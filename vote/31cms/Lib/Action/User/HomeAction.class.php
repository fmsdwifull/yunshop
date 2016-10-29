<?php
class HomeAction extends UserAction{
	public $token;
	public $home_db;
	public function _initialize() {
		parent::_initialize();
		$this->token=$this->_session('token');
		$this->home_db=M('home');
		
		$this->canUseFunction('shouye');
	}
	//配置
	public function set(){
		$home=$this->home_db->where(array('token'=>session('token')))->find();
		if(IS_POST){
			
			$token = session('token');
			S("homeinfo_".$token,NULL);
			if($home==false){
				        $this->all_insert('Home','/set');
			}else{
				
				$_POST['id']=$home['id'];
				$this->all_save('Home','/set');				
			}
		}else{
			$this->assign('home',$home);
			$this->display();
		}
	}
	public function plugmenu(){
		$where=array('token'=>$this->token);
		$menuArr=array('tel','memberinfo','nav','message','share','home','album','email','shopping','membercard','activity','weibo','tencentweibo','qqzone','wechat','music','video','recommend','other');
		$home=$this->home_db->where(array('token'=>session('token')))->find();
		$plugmenu_db=M('site_plugmenu');
		if (!$home){
			$this->error('请先配置3g网站信息',U('Home/set',array('token'=>session('token'))));
		}else {
			S("homeinfo_".$this->token,NULL);
			if(IS_POST){
				//保存版权信息和菜单颜色
				$this->home_db->where($where)->save(array('plugmenucolor'=>$this->_post('plugmenucolor'),'copyright'=>$this->_post('copyright')));
				//保存各个菜单
				//先删除原来的
				$plugmenu_db->where($where)->delete();
				//添加
				foreach ($menuArr as $m){
					$row=array('token'=>$this->token);
					$row['name']=$m;
					$row['url']=$this->_post('url_'.$m);
					$row['taxis']=intval($_POST['sort_'.$m]);
					$row['display']=intval($_POST['display_'.$m]);
					//if (strlen(trim($row['url']))){
						$plugmenu_db->add($row);
					//}
				}
				$this->success('设置成功',U('Home/plugmenu',array('token'=>$this->token)));
			}else {
				$homeInfo=$this->home_db->where($where)->find();
				if (!$homeInfo['plugmenucolor']){
					$homeInfo['plugmenucolor']='#ff0000';
				}
				//
				$this->assign('userGroup',$this->userGroup);
				//
				$this->assign('homeInfo',$homeInfo);
				$menus=$plugmenu_db->where($where)->select();
				$menusArr=array();
				foreach ($menus as $m){
					$menusArr[$m['name']]=$m;
				}
				$this->assign('menus',$menusArr);
				$this->display();
			}
		}
	}
	
}



?>