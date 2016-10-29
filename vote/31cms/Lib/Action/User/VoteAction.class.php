<?php
class VoteAction extends UserAction{

    public function index(){
        //$this->canUseFunction('vote');
        $user=M('Users')->field('gid,activitynum')->where(array('id'=>session('uid')))->find();
        $group=M('User_group')->where(array('id'=>$user['gid']))->find();
        $this->assign('group',$group);
        $this->assign('activitynum',$user['activitynum']);

       // $type = isset($this->_get('type')) ? $this->_get('type') : 'text';
        $list=M('Vote')->where(array('token'=>session('token')))->order('id DESC')->select();
		$ltime = intval (date("Hi"));
		foreach ($list as $key=>$val)
		{
		   $now=time();
    		$list[$key]['limitedit'] = 1;
		   if($now<$list[$key]['statdate'])
				{
				  $list[$key]['show'] = '尚未开始';
				}
		   elseif($now>$list[$key]['enddate']){
				$list[$key]['show'] = '活动结束';
				$list[$key]['limitedit'] = 2;
		   }
		   else {
		   $list[$key]['show'] = '进行中';
			if ($ltime > "600" && $ltime < "2200") {
			$list[$key]['limitedit'] = 0;
		}
		   }
		}
        $count = M('Vote')->where(array('token'=>session('token')))->count();
       $this->assign('count',$count);
		if ($ltime > "600" && $ltime < "2200") {
		$limitedit= 0;
		}
		$this->assign('limitedit',$limitedit);
        $this->assign('list',$list);
        $this->display();
    }

    public function totals(){
        $token      = session('token');
        $id         = $this->_get('id');
        $t_vote     = M('Vote');
        $t_record  = M('Vote_record');
        $where      = array('id'=>$id,'token'=>session('token'));
        $vote   = $t_vote->where($where)->find();
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
        $this->display();
    }
	//推广页
	    public function share(){
         $token      = $this->_get('token');
        $id         = $this->_get('id');
        $t_vote     = M('Vote');
        $t_record  = M('Vote_record');
        $where      = array('id'=>$id,'token'=>$token);
        $vote   = $t_vote->where($where)->find();
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
        $this->display();
    }
    public function add(){
     $this->assign('type',$this->_get('type'));

        if(IS_POST){
         //var_dump($_REQUEST);exit;
            $picurl_guanggaos=$_REQUEST['picurl_guanggao'];
			$adds = $_REQUEST['add'];
           // dump($adds);exit;
            //if(empty($adds) || empty($_REQUEST['add']['item'][0]) && empty($_REQUEST['add']['startpicurl'][0])){
//                $this->error('投票选项你还没有填写');
//                exit;
//            }
            foreach ($adds as $ke => $value) {
                 foreach ($value as $k => $v) {
                    if($v != "")
                     $item_add[$k][$ke]=$v;
                 }
            }
			foreach ($picurl_guanggaos as $ke => $value) {
                 foreach ($value as $k => $v) {
                    if($v != "")
                     $guanggao_add[$k][$ke]=$v;
                 }
            }
            $data=D('Vote');
            //$_POST['id']=$this->_get('id');
            $_POST['token']=session('token');
            $_POST['type'] = $this->_get('type');
            $_POST['statdate']=strtotime($this->_post('statdate'));
            $_POST['enddate']=strtotime($this->_post('enddate'));
			$_POST['qtxinxi'] = strip_tags($this->_post("qtxinxi"));
			$_POST['jiangpin'] = strip_tags($this->_post("jiangpin"));
            $_POST['cknums'] = $this->_post('cknums');
			$_POST['votelimit'] = $this->_post('votelimit');
            //$_POST['display'] = $this->_post("display");
            $_POST['info'] = strip_tags($this->_post("info"));
            $_POST['picurl'] = $this->_post("picurl");
			$_POST['wappicurl'] = $this->_post("wappicurl");
			//$_POST['sl'] = $this->_post("sl");
            $_POST['title'] = $this->_post("title");
            $_POST['keyword'] = $this->_post('keyword');
			$_POST['status'] = 1;

            if($_POST['enddate']<$_POST['statdate']){
                $this->error('结束时间不能小于开始时间!');
                exit;
            }

            //$isset_keyword = $data->where(array('keyword' => $_POST['keyword'],'token'=>$_POST['token']))->field('keyword')->find();
            //if($isset_keyword != NULL){
             //   $this->error('关键词已经存在！');
              //  exit;
           // }
            $t_item = M('Vote_item');
			$g_item = M('Guanggao');
            if($data->create()!=false){
                if($id=$data->add()){
                    foreach ($item_add as $k => $v) {
                      if($v['item'] != ''){
                        $data2['vid'] = $id;
                        $data2['item']=$v['item'];
                        $data2['rank']=empty($v['rank']) ? "1" : $v['rank'];
                        $data2['vcount']=empty($v['vcount']) ? "0" : $v['vcount'];
						$data2['status']=1;
						$data2['intro'] = strip_tags($v['intr']);
                        if($_POST['type'] == 'img'){
                            $data2['startpicurl']=empty($v['startpicurl']) ? "#" : $v['startpicurl'];
                            $data2['tourl']=empty($v['tourl']) ? "#" : $v['tourl'];
                            $data2['description'] = empty($v['description']) ? "" : $v['description'];
                            $data2['weight'] = empty($v['weight']) ? "" : $v['weight'];
                            $data2['sex'] = empty($v['sex']) ? "" : $v['sex'];
                        }
                        $t_item->add($data2);
                      }

                    }
					foreach($guanggao_add as $v){
						 if($v['item'] != ''){
						$datag['vid'] = $id;
						$datag['ggurl'] = $v['url'];
						$g_item->add($datag);
						}
					}
                    $data1['pid']=$id;
                    $data1['module']='Vote';
                    $data1['token']=session('token');
                    $data1['keyword']=$_POST['keyword'];
                    M('keyword')->add($data1);
                    //$ukeywordser=M('Users')->where(array('id'=>session('uid')))->setInc('activitynum');
                    $this->success('添加成功',U('Vote/index',array('token'=>session('token'))));
                }else{
                    $this->error('服务器繁忙,请稍候再试');
                }
            }else{
                $this->error($data->getError());
            }
        }else{
            $this->display();
        }

    }

    public function del(){

        $type = $this->_get('type');
        $id = $this->_get('id');
        $vote = M('Vote');
        $find = array('id'=>$id,'type'=>$type);
        $result = $vote->where($find)->find();
         if($result){
            $vote->where('id='.$result['id'])->delete();
            M('Vote_item')->where('vid='.$result['id'])->delete();
            M('Vote_record')->where('vid='.$result['id'])->delete();
            $where = array('pid'=>$result['id'],'module'=>'Vote','token'=>session('token'));
            M('Keyword')->where($where)->delete();
            $this->success('删除成功',U('Vote/index',array('token'=>session('token'))));
         }else{
            $this->error('非法操作！');
         }

    }

    public function setinc(){
        $id=$this->_get('id');
        $where=array('id'=>$id,'token'=>session('token'));
        $check=M('Vote')->where($where)->find();
        if($check==NULL)$this->error('非法操作');
        $user=M('Users')->field('gid,activitynum')->where(array('id'=>session('uid')))->find();
        $group=M('User_group')->where(array('id'=>$user['gid']))->find();
        if($user['activitynum']>=$group['activitynum']){
           // $this->error('您的免费活动创建数已经全部使用完,请充值后再使用',U('Home/Index/price'));
        }
        if ($check['status']==0){
            $data=M('Vote')->where($where)->save(array('status'=>1));
            $tip='恭喜你,活动已经开始';
        }else {
            $data=M('Vote')->where($where)->save(array('status'=>0));
            $tip='设置成功,活动已经结束';
        }

        if($data!=NULL){
            $this->success($tip);
        }else{
            $this->error('设置失败');
        }

    }
    public function setdes(){
        $id=$this->_get('id');
        $where=array('id'=>$id,'token'=>session('token'));
        $check=M('Vote')->where($where)->find();
        if($check==NULL)$this->error('非法操作');
        $data=M('Vote')->where($where)->setDec('status');
        if($data!=NULL){
            $this->success('活动已经结束');
        }else{
            $this->error('服务器繁忙,请稍候再试');
        }

    }

    public function edit(){
        $this->assign('type',$this->_get('type'));
        if(IS_POST){
			$adds = $_REQUEST['add'];
			 $picurl_guanggaos=$_REQUEST['picurl_guanggao'];
            //dump($adds);exit;
            $data=D('Vote');
            $_POST['id']= (int)$this->_post('id');
            $_POST['token']=session('token');
            $_POST['type'] = $this->_get('type');
            $_POST['statdate']=strtotime($this->_post('statdate'));
            $_POST['enddate']=strtotime($this->_post('enddate'));
            $_POST['cknums'] = (int)$this->_post('cknums');
			$_POST['votelimit'] = $this->_post('votelimit');
            $_POST['display'] = $this->_post("display");
            $_POST['info'] = strip_tags($this->_post("info"));
            $_POST['picurl'] = $this->_post("picurl");
			$_POST['wappicurl'] = $this->_post("wappicurl");
            $_POST['title'] = $this->_post("title");

             if($_POST['enddate']<$_POST['statdate']){
                $this->error('结束时间不能小于开始时间!');
                exit;
            }
            $where=array('id'=>$_POST['id'],'token'=>session('token'));
            $check=$data->where($where)->find();

            if($check==NULL) exit($this->error('非法操作'));
            //if(empty($_REQUEST['add'])){
           //     $this->error('投票选项必须填写');
           //     exit;
           // }

            $t_item = M('Vote_item');
			$g_item = M('Guanggao');
            $datas = $_REQUEST['add'];
            //$datas = array_filter($datas);
             foreach ($datas as $ke => $value) {
                 foreach ($value as $k => $v) {
                    if( $v != ""){
                        $item_add[$k][$ke]=$v;
                    }
                 }
            }
			foreach ($picurl_guanggaos as $ke => $value) {
                 foreach ($value as $k => $v) {
                    if($v != "")
                     $guanggao_add[$k][$ke]=$v;
                 }
            }

            $isnull =  $t_item->where('vid='.$_POST['id'])->find();

            foreach ($item_add as $k => $v) {
                $a++;
                if($v['item'] !=""){
                    $i_id['id']=$v['id'];
                    if($i_id['id'] != ''){

                        $data2['item']=$v['item'];
                        $data2['rank']=empty($v['rank']) ? "1" : $v['rank'];
                        $data2['vcount']=empty($v['vcount']) ? "0" : $v['vcount'];
						$data2['status']=1;
						$data2['intro'] = strip_tags($v['intr']);
                        if($this->_get('type') == 'img'){
                            $data2['startpicurl']=$v['startpicurl'];
                            $data2['tourl']=empty($v['tourl']) ? "#" : $v['tourl'];
                            $data2['description'] = empty($v['description']) ? "" : $v['description'];
                            $data2['sex'] = empty($v['sex']) ? "" : $v['sex'];
                            $data2['weight'] = empty($v['weight']) ? "" : $v['weight'];

                        }
                        // dump($data2);exit;
                      $t_item->where(array('id'=>$i_id['id'],'vid'=>$_POST['id']))->save($data2);
                      // dump($t_item->getLastSql());exit;

                    }else{

                            $data2['vid'] = $_POST['id'];
                            $data2['item']=$v['item'];
                            $data2['rank']=empty($v['rank']) ? "1" : $v['rank'];
                            $data2['vcount']=empty($v['vcount']) ? "0" : $v['vcount'];
							$data2['status']=1;
                            if($_POST['type'] == 'img'){
                                $data2['startpicurl']=empty($v['startpicurl']) ? "#" : $v['startpicurl'];
                                $data2['tourl']=empty($v['tourl']) ? "#" : $v['tourl'];
                                $data2['description'] = empty($v['description']) ? "" : $v['description'];
                                $data2['sex'] = empty($v['sex']) ? "" : $v['sex'];
                                $data2['weight'] = empty($v['weight']) ? "" : $v['weight'];                                
                            }
                            $t_item->add($data2);

                    }
                }

            }
			  foreach ($guanggao_add as $k => $v) {
                $a++;
                if($v['url'] !=""){
                    $i_id['id']=$v['id'];
                    if($i_id['id'] != ''){

                        $datag['ggurl']=$v['url'];
                        // dump($data2);exit;
                      $g_item->where(array('id'=>$i_id['id'],'vid'=>$_POST['id']))->save($datag);
                      // dump($t_item->getLastSql());exit;

                    }else{

                            $datag['vid'] = $_POST['id'];
                            $datag['ggurl']=$v['url'];
                            $g_item->add($datag);
                    }
                }

            }

            if($data->create()){

                if($data->where($where)->save($_POST)){
                    $data1['pid']=$_POST['id'];
                    $data1['module']='Vote';
                    $data1['token']=session('token');

                    $da['keyword']=trim($_POST['keyword']);
                    $ok = M('keyword')->where($data1)->save($da);
                    $this->success('修改成功!',U('Vote/index',array('token'=>session('token'))));exit;
                }else{
                    //$this->error('没有做任何修改！');exit;
                    $this->success('修改成功',U('Vote/index',array('token'=>session('token'))));exit;
                }
            }else{
                $this->error($data->getError());
            }


        }else{
            $id=(int)$this->_get('id');
            $where=array('id'=>$id,'token'=>session('token'));
            $data=M('Vote');
            $check=$data->where($where)->find();
            if($check==NULL)$this->error('非法操作');
            $vo=$data->where($where)->find();
            $items = M('Vote_item')->where(array('vid'=>$id,'status'=>1))->order('rank DESC')->select();
			$ggwhere = array('vid'=>$id);
			$gdata = M('Guanggao')->where($ggwhere)->select();
			$this->assign('guanggao',$gdata);
			$this->assign('items',$items);
            $this->assign('vo',$vo);

            $this->display('add');
        }
    }

    public function del_tab(){
         $da['tid']      = strval($this->_post('id'));
         M('Vote_item')->where(array('id'=>$da['tid']))->delete();
         //$arr=array('errno'=>0,'tid'=>$da['tid']);
         //echo json_encode($arr);
         exit;
    }
	public function del_item(){
         $da['tid']      = strval($this->_post('id'));
         M('Vote_item')->where(array('id'=>$da['tid']))->delete();
         $arr=array('errno'=>0,'tid'=>$da['tid']);
         echo json_encode($arr);
         exit;
    }
	    public function del_gg(){
         $da['tid']      = strval($this->_post('id'));
         M('Guanggao')->where(array('id'=>$da['tid']))->delete();
         //$arr=array('errno'=>0,'tid'=>$da['tid']);
         //echo json_encode($arr);
         exit;
    }
	//审核页面
	public function check(){
		$list_vote = M('Vote');
		$list_item = M('Vote_item');
		$lvwhere['token'] = session('token');
		$liwhere['status'] = 0;
		$lvinfo = $list_vote->where($lvwhere)->order('id desc')->select();
		
		import('./iMicms/Lib/ORG/Page.class.php');
        $count = M('Vote_item')->where($liwhere)->count();
        $page = new Page($count,60);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
        $show = $page->show();
		
		$liinfo = $list_item->where($liwhere)->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  $list_item->where(array('vid'=>$vote['id']))->sum("vcount");
        $this->assign('count',$vcount);
		
		//$liinfo = $list_item->where($liwhere)->order('id desc')->select();
		
		$this->assign('page',$show);
		//var_dump($liinfo);exit;
	
		$this->assign('lvinfo',$lvinfo);
		$this->assign('liinfo',$liinfo);
		
		$this->display();
	}
	//审核信息
	public function check_vote(){
		$vid 		=	$this->_post('vid');
		$id 		= 	$this->_post('id');
		$checkvote = M("Vote_item");
		$where['id'] 	= $id;
		$data['vid'] 	= $vid;
		$data['status'] = 1;
		
		
		
		$ok = $checkvote->where($where)->save($data);
		
		if(false === $ok){
            $arr=array('success'=>0);
            echo json_encode($arr);
            exit;
        }
		
		else
		{
        $arr=array('success'=>1);
        echo json_encode($arr); 
		if(C('SHXX') == '1')
		{
			//发送消息给用户，审核成功，认证号可用
			$mdata=$checkvote->where($where)->find();
			$wid=$mdata["wechat_id"];
			$vecontent = "恭喜，您报名编号为".$mdata['id']."的报名申请已审核通过，赶快去活动页面分享为自己拉票吧！";
			$vedata='{
					"touser": "'.$wid.'", 
					"msgtype": "text", 
					"text": {
						"content": "'.$vecontent.'"
					}
				}';
			
			$wherex=array('token'=>$this->token);
			$this->thisWxUser=M('Wxuser')->where($wherex)->find();
			if (!$this->thisWxUser['appid']||!$this->thisWxUser['appsecret']){
				$diyApiConfig=M('Diymen_set')->where($wherex)->find();
			{
					$this->thisWxUser['appid']=$diyApiConfig['appid'];
					$this->thisWxUser['appsecret']=$diyApiConfig['appsecret'];
				}
			}
			
			$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->thisWxUser['appid'].'&secret='.$this->thisWxUser['appsecret'];
			
			$json=json_decode($this->curlGet($url_get));
			
			if (!$json->errmsg){
					//return array('rt'=>true,'errorno'=>0);
				}else {
					$this->error('获取access_token发生错误：错误代码'.$json->errcode.',微信返回错误信息：'.$json->errmsg);
			}
			$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$json->access_token;
			
			$res=$this->https_request($url,$vedata);
		}
		exit;
	   }
	}
	//发送审核的成功消息给客户函数
	
	
	 protected function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
	function api_notice_increment($url, $data){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		$errorno=curl_errno($ch);
		if ($errorno) {
			return array('rt'=>false,'errorno'=>$errorno);
		}else{
			$js=json_decode($tmpInfo,1);
			if ($js['errcode']=='0'){
				return array('rt'=>true,'errorno'=>0);
			}else {
				$errmsg=GetErrorMsg::wx_error_msg($js['errcode']);
				$this->error('发生错误：错误代码'.$js['errcode'].',微信返回错误信息：'.$errmsg);
			}
		}
	}
	function curlGet($url){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
		//审核全部信息
	public function check_avote(){
		$vid 		=	$this->_post('vid');
		$aid 		= 	$this->_post('aid');
		$typ        =   $this->_post('typ');
		$s=0;
		$aid =	explode(',', $aid);
		$checkvote = M("Vote_item");
		if('del' == $typ){
					foreach ($aid as $id)
		{
			$where['id'] 	= $id;
			$ok = $checkvote->where($where)->delete();
			if(false === $ok){
				$s=1;
				}
	   }
		 if(1 == $s){
            $arr=array('success'=>0);
            echo json_encode($arr);
            exit;
        }else{   
        $arr=array('success'=>2);
        echo json_encode($arr);  
       exit;
	   }	
		}
		else{
		$data['vid'] 	= $vid;
		$data['status'] = 1;
		foreach ($aid as $id)
		{
			$where['id'] 	= $id;
			$ok = $checkvote->where($where)->save($data);
			if(false === $ok){
				$s=1;
				}
	   }
	  if(1 == $s){
            $arr=array('success'=>0);
            echo json_encode($arr);
            exit;
        }else{   
        $arr=array('success'=>1);
        echo json_encode($arr);  
       exit;
	   }
		}
	}
	
	public function gongzhong(){
	     $bind = M('Users');
		 $rbind = M('Areply');
		 $id = session('uid');
	   if($_POST)
	   {
	      $data['tel'] = trim($_POST['tel']);
		  $data['email'] = trim($_POST['email']);
		  $data['gongzhong'] = trim($_POST['gongzhong']);
		  $data['qrimg']	= trim($_POST['picurl']);
		  $content['content'] = trim($_POST['content']);
		 $ok=$bind->where('id='.$id)->save($data);
		 $o=$rbind->where('uid='.$id)->save($content);
		// echo $ok.'----'.$o;exit;
		 if($ok !== false &&$o !== false){
		   echo "<script>alert(\"成功绑定信息\");</script>";
		 }
		 else 
		 {
		 echo "<script>alert(\"信息绑定失败，请重试\");</script>";
		 }
	   }
	  $info=$bind->where("id=".$id)->find();
	  $rep = $rbind->where('uid='.$id)->find();
	  $this->assign('info',$info);
	  $this->assign('rep',$rep);
	  $this->display();
	
	}
		//投票管理
	public function lock(){
		$id=(int)$this->_get('id');
		$liwhere=array('vid'=>$id);
		$list_item = M('Vote_item');
		$liwhere['status'] = array('gt',0);
		
		import('./iMicms/Lib/ORG/Page.class.php');
        $count = M('Vote_item')->where($liwhere)->count();
        $page = new Page($count,60);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
        $show = $page->show();
		
		$liinfo = $list_item->where($liwhere)->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  $list_item->where(array('vid'=>$vote['id']))->sum("vcount");
        $this->assign('count',$vcount);
		
		//$liinfo = $list_item->where($liwhere)->order('id desc')->select();
		
		$this->assign('page',$show);
		
		$this->assign('lvinfo',$lvinfo);
		$this->assign('vid',$id);
		$this->assign('liinfo',$liinfo);
		
		$this->display();
	}
	
			//投票管理
	public function lockall(){
		$id=(int)$this->_post('id');
		$lockmsg     =   trim($this->_post('msg'));
		$liwhere=array('vid'=>$id);
		$list_item = M('Vote_item');
		$liwhere['status'] = array('gt',0);
		$data['status']   = 2;
		$data['lockinfo'] = $lockmsg;

		$ok = $list_item->where($liwhere)->save($data);	
		  if(false === $ok){
            $arr=array('success'=>0,'msg'=>"操作失败，请重新尝试");
            echo json_encode($arr);
            exit;
        }else{   
        $arr=array('success'=>1,'msg'=> "锁定成功");
        echo json_encode($arr);  
       exit;
	   }

	}
			//投票管理
	public function lock_vote(){
		$vid 		=	(int)$this->_post('vid');
		$id 		= 	(int)$this->_post('id');
		$status     =   $this->_post('s');
		$msg = '';
		$checkvote = M("Vote_item");
		$where['id'] 	= $id;
		$where['vid'] 	= $vid;
		if(1== $status)
		{$status=2;
		  $msg="锁定成功";  
		}
		elseif(2 == $status)
		{
		$status=1;
		$msg = "解锁成功";
		}
		else{ 
		   $msg = "参数错误";
			$arr=array('success'=>0,'msg' =>$msg);
            echo json_encode($arr);
            exit;
			}
		$data['status'] = $status;
		$ok = $checkvote->where($where)->save($data);	
		  if(false === $ok){
            $arr=array('success'=>0,'msg'=>"操作失败，请重新尝试");
            echo json_encode($arr);
            exit;
        }else{   
        $arr=array('success'=>1,'msg'=> $msg);
        echo json_encode($arr);  
       exit;
	   }
	}
// 锁定后投票回复信息
	public function lock_msg(){
		$id 		= 	(int)$this->_post('id');
		$lockmsg     =   $this->_post('msg');
		$checkvote = M("Vote_item");
		$where['id'] 	= $id;
		$data['lockinfo'] = $lockmsg;
		$ok = $checkvote->where($where)->save($data);	
		  if(false === $ok){
            $arr=array('success'=>0,''=>"操作失败，请重新尝试");
            echo json_encode($arr);
            exit;
        }else{   
        $arr=array('success'=>1,'msg'=> "回复信息添加成功！");
        echo json_encode($arr);  
       exit;
	   }
	}
		//选项管理
	public function eitem(){
		$id=(int)$this->_get('id');
		$liwhere=array('vid'=>$id);
		$list_item = M('Vote_item');
		$liwhere['status'] = 1;

		import('./iMicms/Lib/ORG/Page.class.php');
        $count = M('Vote_item')->where($liwhere)->count();
        $page = new Page($count,60);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
        $show = $page->show();
		
		$liinfo = $list_item->where($liwhere)->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  M('Vote_item')->where(array('vid'=>$vote['id']))->sum("vcount");
        $this->assign('count',$vcount);
		
		//$liinfo = $list_item->where($liwhere)->order('id desc')->select();
		
		$this->assign('page',$show);
		$this->assign('vid',$id);
		$this->assign('liinfo',$liinfo);	
		$this->display();
	}
	//选项修改
	public function eitem_vote(){
		$id 		= 	intval($this->_post('id'));
		$item     =   $this->_post('item');
		$rank     =   intval($this->_post('rank'));
		$vcount     =   intval($this->_post('vcount'));
		$vtype     =    $this->_post('vtype');
		$dcount     =   intval($this->_post('dcount'));
		$dtype     =    $this->_post('dtype');
		$tourl     =   $this->_post('tourl');
		$intro     =   $this->_post('intro');
		$startpicurl     =   $this->_post('startpicurl');
		$msg = '选项信息更改成功';
		$checkvote = M("Vote_item");
		$where['id'] 	= $id;
		$data['item'] = $item;
		$data['rank'] = $rank;
		$data['tourl'] = $tourl;
		$data['intro'] = $intro;
		$data['startpicurl'] = $startpicurl;
		$ok = $checkvote->where($where)->save($data);
		//修改投票数量
		if('up' == $vtype){
		$oo = $checkvote->where($where)->setInc('vcount',$vcount);
		}elseif('down' == $vtype)
		{
		$oo = $checkvote->where($where)->setDec('vcount',$vcount);
		}
		$checkvalue = $checkvote->where($where)->getField('vcount');
		if($checkvalue<0){
		    $checkvote->where($where)->save(array('vcount'=>0));
		}
		//修改取消票数数量
		if('up' == $dtype){
		$oo = $checkvote->where($where)->setInc('dcount',$dcount);
		}elseif('down' == $dtype)
		{
		$oo = $checkvote->where($where)->setDec('dcount',$dcount);
		}
		$checkvalue = $checkvote->where($where)->getField('dcount');
		if($checkvalue<0){
		    $checkvote->where($where)->save(array('dcount'=>0));
		}
		if(false === $ok){
            //$arr=array('success'=>0,'msg'=>"操作失败，请重新尝试");
            echo json_encode($arr);
            exit;
        }
		else
		{   
        $arr=array('success'=>1,'msg'=> $msg);
        echo json_encode($arr);  
       exit;
	   }
	}
	//增加选手信息
	public function addplayer(){
		$id=(int)$this->_get('id');
		
		$this->assign('vid',$id);	
		$this->display();
	}
	
	//编辑选手信息
	public function editplayer(){
		$id=(int)$this->_get('id');
		$uid=(int)$this->_get('uid');
		$liwhere=array('vid'=>$id);
		$list_item = M('Vote_item');
		$liwhere['status'] = 1;

		import('./iMicms/Lib/ORG/Page.class.php');
		$userinfo=M('Vote_item')->where(array('id'=>$uid))->find();
        $count = M('Vote_item')->where($liwhere)->count();
        $page = new Page($count,60);
        $page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage%  %linkPage% %downPage% ');
        $show = $page->show();
		
		$liinfo = $list_item->where($liwhere)->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
        // dump(M('Vote_item')->getLastSql()); 
        $vcount =  M('Vote_item')->where(array('vid'=>$vote['id']))->sum("vcount");
        $this->assign('count',$vcount);
		
		//$liinfo = $list_item->where($liwhere)->order('id desc')->select();
		
		$this->assign('page',$show);
		$this->assign('vid',$id);
		$this->assign('liinfo',$liinfo);
		$this->assign('userinfo',$userinfo);		
		$this->display();
	}
		//选项添加
	public function eitem_add(){
		$vid 		= 	intval($this->_post('vid'));
		$item     	=  	 $this->_post('item');
		$rank    	=   intval($this->_post('rank'));
		$vcount     =   intval($this->_post('vcount'));
		$tourl      =   $this->_post('tourl');
		$intro      =   $this->_post('intro');
		$startpicurl     =   $this->_post('startpicurl');
		$msg = '选项信息添加成功';
		$checkvote = M("Vote_item");
		$data['vid'] 	= $vid;
		$data['item'] = $item;
		$data['rank'] = $rank;
		$data['vcount'] = $vcount;
		$data['tourl'] = $tourl;
		$data['intro'] = $intro;
		$data['status'] = 1;
		$data['addtime'] = time();
		$data['startpicurl'] = $startpicurl;
		
		$ok = M("Vote_item")->add($data);
		 if(false === $ok){
            $arr=array('success'=>0,'msg'=>"操作失败，请重新尝试");
            echo json_encode($arr);
            exit;
        }
		else{
			$arr=array('success'=>1,'msg'=> $msg);
			echo json_encode($arr);  
		   exit;
	   }
	}
	//export excel
 	public function outxls(){
		$id=(int)$this->_get('id');
		$liwhere=array('vid'=>$id,'status'=>1);
		$list_item = M('Vote_item');
		
		$rank_count = M('Vote_item')->where($liwhere)->field('vcount')->group('vcount')->select();
		foreach($rank_count as $key =>$value){
			 $rank_countno[$key] = $rank_count[$key]['vcount'];
		}
		$rank_count = array_reverse($rank_countno);
		$data = array(  
				1 => array ('编号','排名','选手姓名', '手机号',  '选手简介', '取消关注人数','最终票数','报名时间','图片地址')					 
				); 
		$alldata = $list_item->where($liwhere)->order('vcount desc')->select();
		foreach($alldata as $key=>$info){
		$my_rank = array_keys($rank_count,$info['vcount']);
		$my_rank = intval($my_rank[0]) + 1;
		$info['addtime'] = date('Y-m-d H:i:s',$info['addtime']);
		$data[]= array($info['id'],$my_rank,$info['item'],$info['tourl'],$info['intro'],$info['dcount'],$info['vcount'],$info['addtime'],$info['startpicurl']);
		}
		import('./iMicms/Lib/ORG/Exp_excel.class.php');
		$xls = new Exp_excel();		 
		$xls->addArray($data);  
		echo $xls->generateXML(time()); 		
	} 
}



?>