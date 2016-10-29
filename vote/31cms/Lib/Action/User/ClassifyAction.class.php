<?php
/**
 *语音回复
**/
class ClassifyAction extends UserAction{
	public $fid;
	public function _initialize() {
		parent::_initialize();
		$this->fid=intval($_GET['fid']);
		$this->assign('fid',$this->fid);
		if ($this->fid){
			$thisClassify=M('Classify')->find($this->fid);
			$this->assign('thisClassify',$thisClassify);
		}
	}
	public function index(){
		$db=D('Classify');
		$where['token']=session('token');
		$where['fid']=intval($_GET['fid']);
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$info=$db->where($where)->order('sorts desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('page',$page->show());
		$this->assign('info',$info);
		$this->display();
	}
	//	
	public function add(){
		include('./31cms/Lib/ORG/index.Tpl.php');
		include('./31cms/Lib/ORG/cont.Tpl.php');

		$this->assign('tpl',$tpl);
		$this->assign('contTpl',$contTpl);
		$this->display();
	}
	//
	public function edit(){
		$id=$this->_get('id','intval');
		$info=M('Classify')->find($id);
		include('./31cms/Lib/ORG/index.Tpl.php');
		include('./31cms/Lib/ORG/cont.Tpl.php');
		
		foreach($tpl as $k=>$v){
			if($v['tpltypeid'] == $info['tpid']){
				$info['tplview'] = $v['tplview'];
			}
		}

				
		foreach($contTpl as $key=>$val){
			if($val['tpltypeid'] == $info['conttpid']){
				$info['tplview2'] = $val['tplview'];
			}
		}

		$this->assign('contTpl',$contTpl);
		$this->assign('tpl',$tpl);
		$this->assign('info',$info);
		$this->display();
	}
	
	public function del(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		if(D(MODULE_NAME)->where($where)->delete()){
			$fidwhere['fid']=intval($where['id']);
			D(MODULE_NAME)->where($fidwhere)->delete();
			$this->success('操作成功',U(MODULE_NAME.'/index',array('fid'=>$_GET['fid'])));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index',array('fid'=>$_GET['fid'])));
		}
	}
	//
	public function insert(){
	     $name='Classify';
		$db=D($name);
		$fid = $this->_post('fid','intval');
		$_POST['info'] = str_replace('&quot;','',$_POST['info']);
		if($fid != ''){
			$f = $db->field('path')->where("id = $fid")->find();
			$_POST['path'] = $f['path'].'-'.$fid;
				
		}
		if($db->create()===false){
			$this->error($db->getError());
		}else{
			$id=$db->add();
			if($id){
				$this->success('操作成功',U(MODULE_NAME.'/index',array('fid'=>$_POST['fid'])));
			}else{
				$this->error('操作失败',U(MODULE_NAME.'/index',array('fid'=>$_POST['fid'])));
			}
		}
	}
	public function upsave(){
		$_POST['info'] = str_replace('&quot;','',$_POST['info']);
		$fid = $this->_post('fid','intval');
		if($fid == ''){
			$this->all_save();
		}else{
			$this->all_save('','/index?fid='.$fid);
		}
	}
	
	
	public function chooseTpl(){
	
		include('./31cms/Lib/ORG/index.Tpl.php');
		include('./31cms/Lib/ORG/cont.Tpl.php');
		$tpl = array_reverse($tpl);
		$contTpl = array_reverse($contTpl);
		$tpid = $this->_get('tpid','intval');

				foreach($tpl as $k=>$v){
					$sort[$k] = $v['sort'];
					$tpltypeid[$k] = $v['tpltypeid'];
					
					if($v['tpltypeid'] == $tpid){
						$info['tplview'] = $v['tplview'];
					}
				}
			//array_multisort($sort, SORT_DESC , $tpltypeid , SORT_DESC ,$tpl);
				
			foreach($contTpl as $key=>$val){
				if($val['tpltypeid'] == $tpid){
					$info['tplview2'] = $val['tplview'];
				}
			}
				$this->assign('info',$info);
		

		
		
		$this->assign('contTpl',$contTpl);
		$this->assign('tpl',$tpl);

		$this->display();
	}
	
	public function changeClassifyTpl(){
	
		$tid = $this->_post('tid','intval');
		$cid = $this->_post('cid','intval');
		M('Classify')->where(array('token'=>$this->token,'id'=>$cid))->setField('tpid',$tid);
		echo 200;
	}
	
	public function changeClassifyContTpl(){
	
		$tid = $this->_post('tid','intval');
		$cid = $this->_post('cid','intval');
		M('Classify')->where(array('token'=>$this->token,'id'=>$cid))->setField('conttpid',$tid);
		echo 200;
	
	}
	
	
	
}
?>