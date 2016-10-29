<?php
class VoteAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
		$getpagenumber  = 6;
		C('site_url','http://'.$_SERVER['HTTP_HOST']);
	}

	public function index(){
		$agent = $_SERVER['HTTP_USER_AGENT']; 
		if(!strpos($agent,"icroMessenger")) {
			// echo '此功能只能在微信浏览器中使用';exit;
		}
 
        if($this->_get('wecha_id')){
            $cover = 0;
        }else{
            $cover = 1;
        }
        $this->assign('cover',$cover);
		//排序条件
		$orderlimit = array('rank'=>'asc','id'=>'desc');
        if($this->_get('token') && $this->_get('tid')){
            $token      = $this->_get('token');
            $wecha_id   = $this->_get('wecha_id');
            $id         = $this->_get('tid');
            session('token',$token);
            session('wecha_id',$wecha_id);
            session('tid',$id);           
        }else{
            $token = session('token');
            $wecha_id = session('wecha_id');
            $id = session('tid');
        }

        $this->assign('token',$token);
        $this->assign('wecha_id',$wecha_id);
        $this->assign('id',$id);

		$t_vote		= M('Vote');
        $t_record  = M('Vote_record');
		$tokenopen = M('Token_open');
		$admininfo = M('Users');
		$tokenuid = $tokenopen->where(array('token'=>$token))->getField('uid');
		$where 		= array('token'=>$token,'id'=>$id);
		$vote 	= $t_vote->where($where)->find();
		$admininfo = $admininfo->find($tokenuid);
        if(empty($vote)){
            exit('非法操作');
        }
		$search = '';
        $condition['vid'] = $vote['id'];
		$condition['status'] = 1;
        if($_POST['search']!=null && is_numeric($_POST['search'])){
            $condition['id'] = intval(htmlspecialchars($_POST['search']));
        }

        if($_POST['search'] != null){
            if(is_numeric($_POST['search'])){
               $condition['id'] = array('like','%'.intval(htmlspecialchars($_POST['search'])).'%'); 
           }else{
                $condition['item'] = array('like','%'.htmlspecialchars($_POST['search']).'%');
           }
		  $search = $_POST['search'];
        }
		//统计参与人数
		$cyxs = M('Vote_item')->where($condition)->count();
		$vote['cyxs']=$cyxs;
		$vote['ljtp'] = M('vote_record')->count();
/*         import('./31cms/Lib/ORG/Page.class.php');
		//var_dump($condition);exit;
        $count = M('Vote_item')->where($condition)->count();
        $page = new Page($count,$getpagenumber);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
        $show = $page->show();
        
        //$vote_item = M('Vote_item')->where($condition)->order('vcount DESC')->limit($page->firstRow.','.$page->listRows)->select();
		$vote_item = M('Vote_item')->where($condition)->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  M('Vote_item')->where(array('vid'=>$vote['id']))->sum("vcount");
        $this->assign('count',$vcount); */
        //检查是否投票过
		$vote_item = M('Vote_item')->where($condition)->order($orderlimit)->limit('0,6')->select();
		//获取排行榜
		$rankcondition['vid'] = $vote['id'];
		$rankcondition['status'] = 1;
		$vote_rank = M('Vote_item')->where($rankcondition)->order('vcount desc')->limit('0,6')->select();
        $t_item = M('Vote_item');
        $where = array('wecha_id'=>$wecha_id,'vid'=>$id);
        $vote_record  = $t_record->where($where)->find();
        if($vote_record && $vote_record != NULL){
            $arritem = trim($vote_record['item_id'],',');
            $map['id'] = array('in',$arritem);
            $hasitems = $t_item->where($map)->field('item')->select();
            $this->assign('hasitems',$hasitems);
            $this->assign('vote_record',1);
        }else{
            $this->assign('vote_record',0);
        }

        $item_count = M('Vote_item')->where($condition)->order($orderlimit)->limit('0,6')->select();
        foreach ($item_count as $k=>$value) {
           $vote_item[$k]['per']=(number_format(($value['vcount'] / $vcount),2))*100;
           $vote_item[$k]['pro']=$value['vcount'];
		   $vote_item[$k]['xhid']=$value['id'];
        } 
		//统计浏览量代码
		$countfile = "num.txt";
		//定义计数器写入的文件是当前目录下count.txt，然后我们应当测试该文件能否打开
		if (($fp = fopen($countfile, "r+")) == false) { //用读写模式打开文件，若不能打开就退出
		 printf ("打开文件 %s 失败!",$countfile);
		 exit;
		}
		else
		{
		 //如果文件能够正常打开，就读入文件中的数据，假设是1
		 $count = fread ($fp,10);
		 //读取10位数据
		 $count = $count + 1;
		 fclose ($fp);
		 //关闭当前文件
		 $fp = fopen($countfile, "w+");
		 //以覆盖模式打开文件
		 fwrite ($fp,$count);
		 //写入加1后的新数据
		 fclose ($fp);
		 //并关闭文件
		}
		$vote['lll']=$count;
		//统计结束
        // dump($vote_item);
        $this->assign('page',$show);
		$this->assign('vote_rank',$vote_rank);
		$this->assign('search',$search);
        $this->assign('total',$total);
        $this->assign('vote_item', $vote_item);
        $this->assign('vote',$vote);
		$this->assign('info',$admininfo);
		$this->display();
	}

	
	public function player(){
		$agent = $_SERVER['HTTP_USER_AGENT']; 
		if(!strpos($agent,"icroMessenger")) {
			// echo '此功能只能在微信浏览器中使用';exit;
		}
 
        if($this->_get('wecha_id')){
            $cover = 0;
        }else{
            $cover = 1;
        }
        $this->assign('cover',$cover);
		//排序条件
		$orderlimit = array('rank'=>'asc','id'=>'desc');
        if($this->_get('token') && $this->_get('tid')){
            $token      = $this->_get('token');
            $wecha_id   = $this->_get('wecha_id');
            $id         = $this->_get('tid');
            session('token',$token);
            session('wecha_id',$wecha_id);
            session('id',$id);           
        }else{
            $token = session('token');
            $wecha_id = session('wecha_id');
            $id = session('id');
        }

        $this->assign('token',$token);
        $this->assign('wecha_id',$wecha_id);
        $this->assign('id',$id);

		$t_vote		= M('Vote');
        $t_record  = M('Vote_record');
		$tokenopen = M('Token_open');
		$admininfo = M('Users');
		$tokenuid = $tokenopen->where(array('token'=>$token))->getField('uid');
		
		$where 		= array('token'=>$token,'id'=>$id);
		$vote 	= $t_vote->where($where)->find();
		$admininfo = M('Users')->where(array('id'=>$tokenuid))->find();
        if(empty($vote)){
            exit('非法操作');
        }
		$search = '';
        $condition['vid'] = $vote['id'];
		$condition['status'] = 1;
        if($_POST['search']!=null && is_numeric($_POST['search'])){
            $condition['id'] = intval(htmlspecialchars($_POST['search']));
        }

        if($_POST['search'] != null){
            if(is_numeric($_POST['search'])){
               $condition['id'] = array('like','%'.intval(htmlspecialchars($_POST['search'])).'%'); 
           }else{
                $condition['item'] = array('like','%'.htmlspecialchars($_POST['search']).'%');
           }
		  $search = $_POST['search'];
        }
       
/*         import('./31cms/Lib/ORG/Page.class.php');
		//var_dump($condition);exit;
        $count = M('Vote_item')->where($condition)->count();
        $page = new Page($count,$getpagenumber);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
        $show = $page->show();
        
        //$vote_item = M('Vote_item')->where($condition)->order('vcount DESC')->limit($page->firstRow.','.$page->listRows)->select();
		$vote_item = M('Vote_item')->where($condition)->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  M('Vote_item')->where(array('vid'=>$vote['id']))->sum("vcount");
        $this->assign('count',$vcount); */
        //检查是否投票过
		$vote_item = M('Vote_item')->where($condition)->order($orderlimit)->limit('0,6')->select();
		//获取排行榜
		$rankcondition['vid'] = $vote['id'];
		$rankcondition['status'] = 1;
		$vote_rank = M('Vote_item')->where($rankcondition)->order('vcount desc')->limit('0,6')->select();
        $t_item = M('Vote_item');
        $where = array('wecha_id'=>$wecha_id,'vid'=>$id);
        $vote_record  = $t_record->where($where)->find();
        if($vote_record && $vote_record != NULL){
            $arritem = trim($vote_record['item_id'],',');
            $map['id'] = array('in',$arritem);
            $hasitems = $t_item->where($map)->field('item')->select();
            $this->assign('hasitems',$hasitems);
            $this->assign('vote_record',1);
        }else{
            $this->assign('vote_record',0);
        }

        $item_count = M('Vote_item')->where($condition)->order($orderlimit)->limit('0,6')->select();
        foreach ($item_count as $k=>$value) {
           $vote_item[$k]['per']=(number_format(($value['vcount'] / $vcount),2))*100;
           $vote_item[$k]['pro']=$value['vcount'];
		   $vote_item[$k]['xhid']=$value['id'];
        } 
        // dump($vote_item);
        $this->assign('page',$show);
		$this->assign('vote_rank',$vote_rank);
		$this->assign('search',$search);
        $this->assign('total',$total);
        $this->assign('vote_item', $vote_item);
        $this->assign('vote',$vote);
		$this->assign('info',$admininfo);
		$this->display();
	}
	
	public function add_vote(){	
	
		$token 		=	$this->_post('token');
		$wecha_id	=	$this->_post('wecha_id');
		$tid 		=	$this->_post('tid');
		$chid 		= 	rtrim($this->_post('chid'),',');	
		$recdata 	=	M('Vote_record');
		$votelimit  =   M('vote')->where(array('id'=>$tid))->field('votelimit')->find();//设定的投票数
        $where   = array('vid'=>$tid,'wecha_id'=>$wecha_id,'token'=>$token);  
        $recode =  $recdata->where($where)->select();//投票记录
		$voted = count($recode,COUNT_NORMAL);//已投票数
		//echo $voted.'--'.$votelimit['votelimit'];
		//var_dump($votelimit);var_dump($recode);exit;
        //if($recode != '' || $wecha_id ==''){
		if($voted >= (int)$votelimit['votelimit'] || $wecha_id ==''){
            $arr=array('success'=>0);
            echo json_encode($arr);
			
            exit;
        }else{
		$voteleft = (int)$votelimit['votelimit']-(int)$voted-1;
        $data = array('item_id'=>$chid,'token'=>$token,'vid'=>$tid,'wecha_id'=>$wecha_id,'touch_time'=>time(),'touched'=>1);     
		$ok = $recdata->add($data);
        $map['id'] = array('in',$chid);
        $t_item = M('Vote_item');
        $t_item->where($map)->setInc('vcount');       
        $arr=array('success'=>1,'token'=>$token,'wecha_id'=>$wecha_id,'tid'=>$tid,'chid'=>$chid,'arrpre'=>$per,'vleft'=>$voteleft);
        echo json_encode($arr); 
		       
       exit;}
	}

	//报名
	public function addplayer(){	
		$this->display();
	}
	
	
    public function show(){
        $agent = $_SERVER['HTTP_USER_AGENT']; 
        if(!strpos($agent,"icroMessenger")) {
          //   echo '此功能只能在微信浏览器中使用';exit;
        }
		    $token      = $this->_get('token');
            $wecha_id   = $this->_get('wecha_id');
            $tid         = $this->_get('tid');
			$id         = $this->_get('id');
		$this->assign('token',$token);
        $this->assign('wecha_id',$wecha_id);
        $this->assign('tid',$tid);
		$this->assign('mid',$id);
		
		$t_vote		= M('Vote');
		$where 		= array('token'=>$token,'id'=>$tid);
		$vote 	= $t_vote->where($where)->find();
        $vote_item = M('Vote_item');
        $condition['id'] = htmlspecialchars($this->_get('id'));
        $data = $vote_item->where($condition)->find();
		$condition = array('vid' => $tid,'status' => 1,'vcount' => array('gt',$data['vcount']));
		$pm = $vote_item->where($condition)->count();
		$data['pm'] = $pm+1;
		$gzh = M('Users')->where(array('username'=>'admin'))->find();
		$guanggao = M('Guanggao')->where(array('vid'=>$vote['id']))->select();
        if($_GET['wecha_id']){
            $cover = 0;
        }else{
            $cover = 1;
        }
		$tokenopen = M('Token_open');
		$admininfo = M('Users');
		$tokenuid = $tokenopen->where(array('token'=>$token))->getField('uid');
		$admininfo = M('Users')->where(array('id'=>$tokenuid))->find();
		
		$this->assign('info',$admininfo);
		$this->assign('guanggao',$guanggao);
        $this->assign('cover',$cover);
		$this->assign('gzh',$gzh);
        $this->assign('data',$data);
		$this->assign('vote',$vote);
        $this->display();
    }

	public function share(){
        $token      = $this->_get('token');
        $id         = $this->_get('tid');
        $t_vote     = M('Vote');
        $t_record  = M('Vote_record');
        $where      = array('id'=>$id,'token'=>$token);
        $vote   = $t_vote->where($where)->find();
		$user = M('Users');
		$tokenopen = M('Token_open');
		$tokenuid = $tokenopen->where(array('token'=>$token))->getField('uid');
		$admininfo = $user->find($tokenuid);
        if(empty($vote)){
            exit('非法操作');
        }
		$condition = array('vid' => $id,'status' => 1);
		import('./iMicms/Lib/ORG/Page.class.php');
        $count = M('Vote_item')->where($condition)->count();
        $page = new Page($count,60);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
		//$page->parameter =   "ar=100";
        $show = $page->show();
		
		$vote_item = M('Vote_item')->where($condition)->order('vcount DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  M('Vote_item')->where($condition)->sum("vcount");
		if(!$vcount){ $vcount = 0;}
        $this->assign('count',$vcount);

        $rank_count = M('Vote_item')->where($condition)->field('vcount')->group('vcount')->select();
		foreach($rank_count as $key =>$value){
			 $rank_countno[$key] = $rank_count[$key]['vcount'];
		}
		$rank_count = array_reverse($rank_countno);
		$item_count = M('Vote_item')->where($condition)->order('vcount desc')->limit($page->firstRow.','.$page->listRows)->select();
		$rwhere['vcount'] = array('gt',$item_count[0]['vcount']);
        foreach ($item_count as $k=>$value) {
            $vote_item[$k]['per']=(number_format(($value['vcount'] / $vcount),2))*100;
            $vote_item[$k]['pro']=$value['vcount'];
			$vote_item[$k]['prode']=$value['dcount'];
			$my_rank = array_keys($rank_count,$value['vcount']);
			$my_rank = intval($my_rank[0]) + 1;
			$vote_item[$k]['mingci']=$my_rank;
        }
		$this->assign('page',$show);
        $this->assign('total',$total);
        $this->assign('vote_item', $vote_item);
        $this->assign('vote',$vote);
		$this->assign('info',$admininfo);
        $this->display();
    }
	
    public function vote(){
        $data['item_id'] = htmlspecialchars($this->_post('id'));
        $data['vid'] = htmlspecialchars($this->_post('vid'));
        $data['token'] = htmlspecialchars($this->_post('token'));
        $data['wecha_id'] = htmlspecialchars($this->_post('wecha_id'));
        $data['touch_time'] = time();
        $data['touched'] = 1;
        $condition['vid'] = $data['vid'];
        $condition['wecha_id'] = $data['wecha_id'];

        $vote_record = M('Vote_record');
        if($vote_record->where($condition)->find()){
            //已经投过票了
            $this->ajaxReturn('','',1,'json');
        }else{
            //没有投过票
            $vote_record->add($data);
            $map['id'] = array('in',$data['item_id']);
            $t_item = M('Vote_item');
            $t_item->where($map)->setInc('vcount'); 
            $this->ajaxReturn('','',2,'json');            
        }
    }
	//下拉添加选项
	public function add_item(){
			$key      = $this->_get('key');
            $page     =  intval($this->_get('page'));
			$id         = $this->_get('tid');
		//set query condition	
		$condition['vid'] = $id;
		$condition['status'] = 1;
		//get 
		$getpagenumber = intval(6);
        $nowpagecount = $page*$getpagenumber;
        if($key != ''&&$key != NULL){
            if(is_numeric($key)){
               $condition['id'] = array('like','%'.intval(htmlspecialchars($key)).'%'); 
           }else{
                $condition['item'] = array('like','%'.htmlspecialchars($key).'%');
           }
        }		
		 $vote_item = M('Vote_item')->where($condition)->order(array('rank'=>'asc','id'=>'desc'))->limit($nowpagecount,$getpagenumber)->select();
		 //添加6项
		 $datastr='';
		 foreach ($vote_item as $k=>$value) {
			
			
		 
		$datastr =$datastr."  
						<li><a href=\"/index.php?g=Wap&m=Vote&a=show&token=".$_SESSION['token']."&id=".$value['id']."&wecha_id=".$_SESSION['wecha_id']."&tid=".$id."\"><img src=\"".$value['startpicurl']."\" style=\"width:100%; height:187px;\"></a>
						<p class=\"info\">".$value['item']."<br>选手编号：<i class=\"vote_1\">".$value['id']."</i><br>票数：<i class=\"vote_1\">".$value['vcount']."</i><br></p>
						<p class=\"vote\"><a href=\"/index.php?g=Wap&m=Vote&a=show&token=".$_SESSION['token']."&id=".$value['id']."&wecha_id=".$_SESSION['wecha_id']."&tid=".$id."\">详细资料</a></p></li>"	;
			}
		echo $datastr;
	}
		//下拉添加排行
	public function add_rank(){
            $page     =  intval($this->_get('page'));
			$id         = $this->_get('tid');
		//set query condition	
		$condition['vid'] = $id;
		$condition['status'] = 1;
		//get 
		$getpagenumber = intval(6);
        $nowpagecount = $page*$getpagenumber;	
		 $vote_item = M('Vote_item')->where($condition)->order('vcount desc')->limit($nowpagecount,$getpagenumber)->select();
		 //添加6项
		 $datastr='';
		 foreach ($vote_item as $k=>$value) {
		$datastr =$datastr."  <div class='pp'> 
						<a href=\"/index.php?g=Wap&m=Vote&a=show&token=".$_SESSION['token']."&id=".$value['id']."&wecha_id=".$_SESSION['wecha_id']."&tid=".$id."\">
						<img src=\"".$value['startpicurl']."\">
						
						<div class=\"tit\">".$value['id']."号 ".$value['item']."<br />人气：<b>".$value['vcount']."</b></div>
					</div></a>"	;
			}
		echo $datastr;
	}
	
}?>