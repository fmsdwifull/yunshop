<?php
class WeixinAction extends Action
{
    private $token;
    private $fun;
    private $data = array();
    public $mykey;
	public $chatkey;
    private $my = 'CDRBP微信投票';
    public function index()
    {
        if (!class_exists('SimpleXMLElement')) {
            die('SimpleXMLElement class not exist');
        }
        if (!function_exists('dom_import_simplexml')) {
            die('dom_import_simplexml function not exist');
        }
        $this->token = $this->_get('token', 'htmlspecialchars');
        if (!preg_match('/^[0-9a-zA-Z]{3,42}$/', $this->token)) {
            die('error token');
        }
		$myurl=$this->_server('HTTP_HOST');
        C('site_url',$myurl);
        $this->mykey = trim(C('server_key'));
		$this->chatkey = trim(C('site_chatkey'));
        $weixin = new Wechat($this->token);
        $data = $weixin->request();//获取数据 并转化为数组
        $this->data = $weixin->request();
        if ($this->data) {
            $this->my = C('site_my');
            $open = M('Token_open')->where(array('token' => $this->_get('token')))->find();//获取该公众平台所有权限
            $this->fun = $open['queryname'];
            list($content, $type) = $this->reply($data);
            $weixin->response($content, $type);//回复数据
        }
    }
    private function reply($data)
    {
		$myurl=$this->_server('HTTP_HOST');
        C('site_url',$myurl);
		if (isset($data['Event'])) {
            if ('CLICK' == $data['Event']) {
                $data['Content'] = $data['EventKey'];
                $this->data['Content'] = $data['EventKey'];
            }
			if ('subscribe' == $data['Event']) {//关注
                $follow_data = M('Areply')->field('home,keyword,content')->where(array('token' => $this->token))->find();
                //用户未关注时，进行关注后的事件推送 事件KEY值，qrscene_为前缀，后面为二维码的参数值
                    return array(html_entity_decode($follow_data['content']), 'text');
            }
			elseif('unsubscribe' == $data['Event']){
				$deletelist = M('Vote_record')->where(array('wecha_id' => $data['FromUserName']))->select();
				foreach($deletelist as $key => $value){
					M('Vote_item')->where(array('id' => $deletelist[$key]['item_id']))->setDec('vcount');
					M('Vote_item')->where(array('id' => $deletelist[$key]['item_id']))->setInc('dcount');
					M('Vote_record')->where(array('id' => $deletelist[$key]['id']))->delete();
				}		
				}
			}
		//登记报名信息
		 if(S('bmstep_' . $data['FromUserName']) != '' && S('bmstep_' . $data['FromUserName'])!=NULL){
		$bmstep = S('bmstep_' . $data['FromUserName']);
		 if('bbname' == $bmstep)
			{	if('取消报名' == trim($data['Content']))
				{
					$echostr = "已成功取消报名！您可以再次回复'报名'继续报名或回复选手编号进行投票";S('bbname_' . $data['FromUserName'],NULL);S('bbphone_' . $data['FromUserName'],NULL);S('bbimg_' . $data['FromUserName'],NULL);S('bmother_' . $data['FromUserName'],NULL);S('bmstep_' . $data['FromUserName'],NULL);$bmstep = '';return array($echostr,'text');
				}
				if($data['MsgType'] != 'text'||'' == trim($data['Content']))
				{
				  return array("欢迎您参加本次活动，报名过程中您可以随时输入 '取消报名' 退出报名系统！下面请输入选手姓名：","text");
				}
				S('bbname_' . $data['FromUserName'],$data['Content'],1800);
				S('bmstep_' . $data['FromUserName'],'bbphone',1800);
				return array('请输入手机号码，方便我们同您进行联系：','text');
			}
		 if('bbphone' == $bmstep)
			{
				if('取消报名' == trim($data['Content']))
				{
					$echostr = "已成功取消报名！您可以再次回复'报名'继续报名或回复选手编号进行投票";S('bbname_' . $data['FromUserName'],NULL);S('bbphone_' . $data['FromUserName'],NULL);S('bbimg_' . $data['FromUserName'],NULL);S('bmother_' . $data['FromUserName'],NULL);S('bmstep_' . $data['FromUserName'],NULL);$bmstep = '';return array($echostr,'text');
				}
			    $tel = trim($data['Content']);//手机号码
				if($data['MsgType'] != 'text'||0 == preg_match("/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/",$tel))
				{	
				return array('请输入正确的手机号码，方便我们同您进行联系：','text');
				}
				else 
					{ 
						S('bbphone_' . $data['FromUserName'],$data['Content'],1800);
						S('bmstep_' . $data['FromUserName'],'bbimg',1800);
						return array('请上传选手推荐靓照：','text');
					}				
			}
		if('bbimg' == $bmstep)
			{
				if('取消报名' == trim($data['Content']))
				{
					$echostr = "已成功取消报名！您可以再次回复'报名'继续报名或回复选手编号进行投票";S('bbname_' . $data['FromUserName'],NULL);S('bbphone_' . $data['FromUserName'],NULL);S('bbimg_' . $data['FromUserName'],NULL);S('bmother_' . $data['FromUserName'],NULL);S('bmstep_' . $data['FromUserName'],NULL);$bmstep = '';return array($echostr,'text');
				}
			  if($data['MsgType'] != 'image')
			   {
					return array("请上传选手靓照","text");
			   }
			   $sub_dir = date('Ymd');//获取时间
                if (!file_exists(($_SERVER['DOCUMENT_ROOT'] . '/uploads')) || !is_dir(($_SERVER['DOCUMENT_ROOT'] . '/uploads'))) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads', 511);
                }//创建uploads
                $firstLetterDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/vote';
                if (!file_exists($firstLetterDir) || !is_dir($firstLetterDir)) {
                    mkdir($firstLetterDir, 511);
                }//创建投票文件夹
                $firstLetterDir = ($_SERVER['DOCUMENT_ROOT'] . '/uploads/vote/') . $sub_dir;
                if (!file_exists($firstLetterDir) || !is_dir($firstLetterDir)) {
                    mkdir($firstLetterDir, 511);
                }//创建当天文件夹
                $file_name = ((date('YmdHis') . '_') . rand(10000, 99999)) . '.jpg';//命名图片
                $vote_save_path = ((($_SERVER['DOCUMENT_ROOT'] . '/uploads/vote/') . $sub_dir) . '/') . $file_name;
                $file_web_path = 'http://'.(((C('site_url') . '/uploads/vote/') . $sub_dir) . '/') . $file_name;
                $PicUrl = $data['PicUrl'];//公众平台上传图片的地址
                $imgdata = $this->curlGet($PicUrl);
                $fp = fopen($vote_save_path, 'w');
                fwrite($fp, $imgdata);
                fclose($fp);
                //将照片的路径放入到 缓存中
				S('bbimg_' . $data['FromUserName'],$file_web_path,1800);
				S('bmstep_' . $data['FromUserName'],'bmother',1800);
				return array('请填写简要介绍','text');
			}
			
		if('bmother' == $bmstep)
			{
				if('取消报名' == trim($data['Content']))
				{
					$echostr = "已成功取消报名！您可以再次回复'报名'继续报名或回复选手编号进行投票";S('bbname_' . $data['FromUserName'],NULL);S('bbphone_' . $data['FromUserName'],NULL);S('bbimg_' . $data['FromUserName'],NULL);S('bmother_' . $data['FromUserName'],NULL);S('bmstep_' . $data['FromUserName'],NULL);$bmstep = '';return array($echostr,'text');
				}
			    if($data['MsgType'] != 'text'||''==trim($data['Content']))
					{
						return array("请填写简要介绍","text");
					}
				S('bmother_' . $data['FromUserName'],$data['Content'],1800);
				S('bmstep_' . $data['FromUserName'],'bmzz',1800);
				
				return array("是否还需要增加更多靓照，需要请回复是，不需要则回复任意内容提交上述报名信息","text");
				
			}
			
			if('bmzz' == $bmstep)
			{
				if('取消报名' == trim($data['Content']))
				{
					$echostr = "已成功取消报名！您可以再次回复'报名'继续报名或回复选手编号进行投票";S('bbname_' . $data['FromUserName'],NULL);S('bbphone_' . $data['FromUserName'],NULL);S('bbimg_' . $data['FromUserName'],NULL);S('bmother_' . $data['FromUserName'],NULL);S('bmstep_' . $data['FromUserName'],NULL);$bmstep = '';return array($echostr,'text');
				}
				if(trim($data['Content']) == '是')
					{
						S('bmstep_' . $data['FromUserName'],'bmbc',1800);
						return array('请上传一张图片','text');
					}
				else{
		  //将获得的信息存入数据库
					$pt_voteitem = M("vote_item");
					$ntime = time();
					$pt_data = array(
						'vid' 			=> 	0,
						'item' 			=>	S('bbname_' . $data['FromUserName']),
						'vcount'		=> 	0,
						'startpicurl'   =>  S('bbimg_' . $data['FromUserName']),
						'tourl' 		=>  S('bbphone_' . $data['FromUserName']),
						'rank' 			=>  1,
						'intro' 		=>  S('bmother_' . $data['FromUserName']),
						'status' 		=>  0,
						'wechat_id' 	=>  $data['FromUserName'],
						'addtime'		=>  $ntime
					);
					$pt_ok = $pt_voteitem->add($pt_data);
					S('bbname_' . $data['FromUserName'],NULL);
					S('bbphone_' . $data['FromUserName'],NULL);
					S('bbimg_' . $data['FromUserName'],NULL);
					S('bmother_' . $data['FromUserName'],NULL);
					S('bmstep_' . $data['FromUserName'],NULL);
					$bmstep = '';
					if($pt_ok){
					return array('您已报名成功，您的编号为'.$pt_ok.'，请耐心等待审核','text');
					//$vetitle ='恭喜您已经成功报名';
					//$vecontent = "恭喜您已成功报名参加活动";
					//$echonews=array(array($vetitle, $vecontent, $pt_data['startpicurl'], ((((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=show&token=') . $this->token) . '&wecha_id=') . $data['FromUserName']) . '&id=') . $pt_ok) .'&tid=0')). '&sgssz=mp.weixin.qq.com'));
					//return array($echonews,'news');
					}else
					{
					  return array('报名信息提交失败，请稍后重试！','text');
					  }
				  
				 }
			}
			//补充
			if('bmbc' == $bmstep)
			{
				if('取消报名' == trim($data['Content']))
				{
					$echostr = "已成功取消报名！您可以再次回复'报名'继续报名或回复选手编号进行投票";S('bbname_' . $data['FromUserName'],NULL);S('bbphone_' . $data['FromUserName'],NULL);S('bbimg_' . $data['FromUserName'],NULL);S('bmother_' . $data['FromUserName'],NULL);S('bmstep_' . $data['FromUserName'],NULL);$bmstep = '';return array($echostr,'text');
				}
				for($i = 0; $i <= 10; $i++)
				{
					if(trim($data['Content']) != '结束')
					{
						if($data['MsgType'] != 'image')
					   {
							return array("请补充正确的靓照","text");
					   }
					   $sub_dir = date('Ymd');//获取时间
						if (!file_exists(($_SERVER['DOCUMENT_ROOT'] . '/uploads')) || !is_dir(($_SERVER['DOCUMENT_ROOT'] . '/uploads'))) {
							mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads', 511);
						}//创建uploads
						$firstLetterDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/vote';
						if (!file_exists($firstLetterDir) || !is_dir($firstLetterDir)) {
							mkdir($firstLetterDir, 511);
						}//创建投票文件夹
						$firstLetterDir = ($_SERVER['DOCUMENT_ROOT'] . '/uploads/vote/') . $sub_dir;
						if (!file_exists($firstLetterDir) || !is_dir($firstLetterDir)) {
							mkdir($firstLetterDir, 511);
						}//创建当天文件夹
						$file_name = ((date('YmdHis') . '_') . rand(10000, 99999)) . '.jpg';//命名图片
						$vote_save_path = ((($_SERVER['DOCUMENT_ROOT'] . '/uploads/vote/') . $sub_dir) . '/') . $file_name;
						$file_web_path = 'http://'.(((C('site_url') . '/uploads/vote/') . $sub_dir) . '/') . $file_name;
						$PicUrl = $data['PicUrl'];//公众平台上传图片的地址
						$imgdata = $this->curlGet($PicUrl);
						$fp = fopen($vote_save_path, 'w');
						fwrite($fp, $imgdata);
						fclose($fp);
						//将照片的路径放入到 缓存中
						//S('bmother_' . $data['FromUserName'],$file_web_path,1800);
						$pic=S('bmother_' . $data['FromUserName'])."<br/><img src=".$file_web_path.">";
						S('bmother_' . $data['FromUserName'],$pic,1800);
						S('bmstep_' . $data['FromUserName'],'bmbc',1800);
						return array("上传成功，若需要继续补充靓照请直接上传照片，完毕请回复'结束'","text");
					}
					
					else{
						
						break;
					}
				}
				
				
					//将获得的信息存入数据库
				$pt_voteitem = M("vote_item");
				$ntime = time();
				$pt_data = array(
					'vid' 			=> 	0,
					'item' 			=>	S('bbname_' . $data['FromUserName']),
					'vcount'		=> 	0,
					'startpicurl'   =>  S('bbimg_' . $data['FromUserName']),
					'tourl' 		=>  S('bbphone_' . $data['FromUserName']),
					'rank' 			=>  1,
					'intro' 		=>  S('bmother_' . $data['FromUserName']),
					'status' 		=>  0,
					'wechat_id' 	=>  $data['FromUserName'],
					'addtime'		=>  $ntime
				);
				$pt_ok = $pt_voteitem->add($pt_data);
				S('bbname_' . $data['FromUserName'],NULL);
				S('bbphone_' . $data['FromUserName'],NULL);
				S('bbimg_' . $data['FromUserName'],NULL);
				S('bmother_' . $data['FromUserName'],NULL);
				S('bmstep_' . $data['FromUserName'],NULL);
				$bmstep = '';
				if($pt_ok){
				return array('您已报名成功，您的编号为'.$pt_ok.'，请耐心等待审核','text');
				//$vetitle ='恭喜您已经成功报名';
				//$vecontent = "恭喜您已成功报名参加活动";
				//$echonews=array(array($vetitle, $vecontent, $pt_data['startpicurl'], ((((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=show&token=') . $this->token) . '&wecha_id=') . $data['FromUserName']) . '&id=') . $pt_ok) .'&tid=0')). '&sgssz=mp.weixin.qq.com'));
				//return array($echonews,'news');
				}else
			  {
			  return array('报名信息提交失败，请稍后重试！','text');
			  }
			}
		
		}  
		if(C('YZM') == '1')
				  {
						//屏蔽验证码开始
				 		if(S('vrand'.$data['FromUserName']) != '' && S('vrand'.$data['FromUserName']) != NULL){
								   if(S('vrand'.$data['FromUserName']) == $data['Content']){
											//return array("恭喜验证码输入正确","text");
											S('vrand'.$data['FromUserName'],NULL);
											return $this->vote(S('vnum'.$data['FromUserName']));
								   }
									else{
									   return array("验证码输入错误，请重新输入","text");
									}
									//return $this->vote($num);
							}
						//结束
				  }
            $key = $data['Content'];
            switch ($key) {
			 case '报名':
				 S('bmstep_' . $this->data['FromUserName'],'bbname',1800);
			    return array("欢迎您参加本次活动，报名过程中您可以随时输入 '取消报名' 退出报名系统！下面请输入选手姓名： ","text");
				 break; 
            default:
			   //设置投票
			   if (is_numeric($key)){
			    $num = trim($key);
				  if(!is_numeric($num))
				  {
				  return array('对不起，请您输入直接输入数字编号进行投票','text');
				  }
				  else
				  {
				   $num  = intval($num);
				  //屏蔽验证码开始
				  if(C('YZM') == 1)
				  {
					   $ran = rand(10000,99999);
					   S('vrand'.$this->data['FromUserName'],$ran,60);
					   S('vnum'.$this->data['FromUserName'],$num,61);
					   return array("请输入本验证码(".$ran.")，一分钟之内有效!","text");
					   //屏蔽验证码结束 去掉下面一行//
				   }
					else
					{
					return $this->vote($num);
					}
			      }
			   }
                    return $this->keyword($key);
            }
    }
	private function vote($id){
	//选项
	$man = M('Vote_item')->where(array('id'=>$id,'status'=>array('gt',0)))->find();
	if(!$man){
				return array('您所投票的编号不在正确范围内，请检查后再投票','text');     
	}else {
			$recdata 	=	M('Vote_record');
			$t_item = M('Vote_item');
			$vote  =   M('vote')->where(array('id'=>$man['vid']))->find();//设定的投票次数
			//活动已经结束 此处加上时间对比
			$now=time();
			if( 0== $vote['status'] || $now>$vote['enddate']){
			return array("本次活动已经停止，谢谢您的支持",'text');
			}
			if($now<$vote['statdate']){
			$betime = date('Y-m-d H:i:s',$vote['statdate']);
			return array("本次投票活动将在".$betime."开始,活动开始后才能投票,谢谢您的支持",'text');
			}
			//用户被锁定
			if(2== $man['status']){
					if(''==$man['lockinfo'] || NULL == $man['lockinfo']){
						$str="目前该选项被锁定，不能投票!";
					}else{
						$str=$man['lockinfo'];
					}
			return array($str,'text');
			}
			//设定查询条件
		if(1 == $vote['cknums']){
			$where = array('vid'=>$vote['id'],'wecha_id' => $this->data['FromUserName']);
			}
			else{ 
			$where = array('item_id'=>$id,'wecha_id' => $this->data['FromUserName']);
		 	}
			//return array($id.'---'.$this->data['FromUserName'],'text');
			$map['id'] = $id;
			$vote_count = $t_item->where($map)->find();
			if(!(strpos($vote_count['startpicurl'], 'http://') === FALSE)){}else{
			$vote_count['startpicurl'] = 'http://'.C('site_url') .'/'. $vote_count['startpicurl'];
			}
			$recode =  $recdata->where($where)->order('id desc')->limit(1)->select();//投票记录
			//设置查询条件 每个投票选项下比较
			$where_rank = array('vid' =>$vote_count['vid'],'vcount'=>array('gt',$vote_count['vcount']));
			$vemaxrank  = $t_item->where($where_rank)->order('vcount desc')->max('vcount')-$vote_count['vcount'];
			$veminrank  = $t_item->where($where_rank)->order('vcount desc')->min('vcount')-$vote_count['vcount'];
			$myrank     = $t_item->where($where_rank)->count('id');
			//只限投一次票
			if(!$vote['votelimit'])
				{
					if($recode)
						{
							//$echostr = "你已经投过票了，不能重复投票;目前".$man['id']."号".$man['item']."共得到".$vote_count['vcount']."票";
							//return array($echostr,'text');
							$vetitle = "您已为".$recode[0]['item_id']."号选手投票";
							if(!$myrank){
							$vecontent = "目前".$man['id']."号".$man['item']."排名第1，共得".$vote_count['vcount']."票。您可以点此进入分享为TA拉票。";
							}
							else{
								$myrank= $myrank+1;
							$vecontent = "目前".$man['id']."号".$man['item']."排名第".$myrank."，共得".$vote_count['vcount']."票。与第一名还差".$vemaxrank."张票，离上一名还差".$veminrank."票。您可以点此进入分享为TA拉票。";
							}
							$echonews=array(array($vetitle, $vecontent, $vote_count['startpicurl'], ((((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=show&token=') . $this->token) . '&wecha_id=') . $this->data['FromUserName']) . '&id=') . $vote_count['id']) .'&tid=').$vote_count['vid']). '&sgssz=mp.weixin.qq.com'));
							return array($echonews,'news');
						}
					else 
						{
							$data = array('item_id'=>$id,'token'=>$vote['token'],'vid'=>$vote['id'],'wecha_id'=>$this->data['FromUserName'],'touch_time'=>time(),'touched'=>1);     
							$ok = $recdata->add($data);
							//投票成功
							if($ok){ 
									$vote_count['vcount'] +=1;
									$t_item->where($map)->setInc('vcount');
									$where_rank = array('vid' =>$vote_count['vid'],'vcount'=>array('gt',$vote_count['vcount']));
									$vemaxrank  = $t_item->where($where_rank)->order('vcount desc')->max('vcount')-$vote_count['vcount'];
									$veminrank  = $t_item->where($where_rank)->order('vcount desc')->min('vcount')-$vote_count['vcount'];
									$myrank     = $t_item->where($where_rank)->count('id');
									$vetitle = "恭喜您为".$man['id']."号".$man['item']."投票成功";
									if(!$myrank){
									$vecontent = "目前".$man['id']."号".$man['item']."排名第1，共得".$vote_count['vcount']."票。您可以点此进入分享为TA拉票。";
									}
									else{
										$myrank= $myrank+1;
									$vecontent = "目前".$man['id']."号".$man['item']."排名第".$myrank."，共得".$vote_count['vcount']."票。与第一名还差".$vemaxrank."张票，离上一名还差".$veminrank."票。您可以点此进入分享为TA拉票。";
									}
									$echonews=array(array($vetitle, $vecontent, $vote_count['startpicurl'], ((((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=show&token=') . $this->token) . '&wecha_id=') . $this->data['FromUserName']) . '&id=') . $vote_count['id']) .'&tid=').$vote_count['vid']). '&sgssz=mp.weixin.qq.com'));
									return array($echonews,'news');
									}
							else{ //投票失败
									$echostr = "投票失败，请重新投票";
									return array($echostr,'text');
								}
	  
						}		
				}
			//每日可投一次票
			else
			{
				$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
				//$where['vid'] = $id;
				//$where['wecha_id'] = &this->data['FromUserName'];
				//$where['touch_time'] = array('egt',$beginToday);
				//return array('item_id='.$recode[0]['touch_time'].$beginToday,text);
				if($beginToday<$recode[0]['touch_time'])
					{
						//$echostr = "您今天已经投票，目前".$man['id']."号".$man['item']."共得到".$vote_count['vcount']."票";
						//return array($echostr,'text');
						$vetitle = "今天您已为".$recode[0]['item_id']."号选手投票,请明天再投票";
					if(!$myrank){
							$vecontent = "目前".$man['id']."号".$man['item']."排名第1，共得".$vote_count['vcount']."票。您可以点此进入分享为TA拉票。";
							}
							else{
								$myrank= $myrank+1;
						$vecontent = "目前".$man['id']."号".$man['item']."排名第".$myrank."，共得".$vote_count['vcount']."票。与第一名还差".$vemaxrank."张票，离上一名还差".$veminrank."票。您可以点此进入分享为TA拉票。";
						}
						$echonews=array(array($vetitle, $vecontent, $vote_count['startpicurl'], ((((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=show&token=') . $this->token) . '&wecha_id=') . $this->data['FromUserName']) . '&id=') . $vote_count['id']) .'&tid=').$vote_count['vid']). '&sgssz=mp.weixin.qq.com'));
						return array($echonews,'news');
					}
				else
					{
						$data = array('item_id'=>$id,'token'=>$vote['token'],'vid'=>$vote['id'],'wecha_id'=>$this->data['FromUserName'],'touch_time'=>time(),'touched'=>1); 
						$ok = $recdata->add($data);
						//投票成功
						if($ok)
						{
						$vote_count['vcount'] = $vote_count['vcount']+1;
						$t_item->where($map)->setInc('vcount');
						$where_rank = array('vid' =>$vote_count['vid'],'vcount'=>array('gt',$vote_count['vcount']));
						$vemaxrank  = $t_item->where($where_rank)->order('vcount desc')->max('vcount')-$vote_count['vcount'];
						$veminrank  = $t_item->where($where_rank)->order('vcount desc')->min('vcount')-$vote_count['vcount'];
						$myrank     = $t_item->where($where_rank)->count('id');
						$vetitle = "恭喜您为".$man['id']."号".$man['item']."投票成功";
							if(!$myrank){
							$vecontent = "目前".$man['id']."号".$man['item']."排名第1，共得".$vote_count['vcount']."票。您可以点此进入分享为TA拉票。";
							}
							else{
								$myrank= $myrank+1;
						$vecontent = "目前".$man['id']."号".$man['item']."排名第".$myrank."，共得".$vote_count['vcount']."票。与第一名还差".$vemaxrank."张票，离上一名还差".$veminrank."票。您可以点此进入分享为TA拉票。";
						}
						$echonews=array(array($vetitle, $vecontent, $vote_count['startpicurl'], ((((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=show&token=') . $this->token) . '&wecha_id=') . $this->data['FromUserName']) . '&id=') . $vote_count['id']) .'&tid=').$vote_count['vid']). '&sgssz=mp.weixin.qq.com'));
						return array($echonews,'news');
						}
						else
						{ //投票失败
							$echostr = "投票失败，请重新投票";
							return array($echostr,'text');
						}
					}
			}
		}
	}
    private function keyword($key)//判断关键词
    {
        $key = trim($key);
        $like['keyword'] = array('like', ('%' . $key) . '%');
        $like['token'] = $this->token;
        $data = M('keyword')->where($like)->order('id desc')->find();
        if ($data != false) {
                $Vote = M('Vote')->where(array('id' => $data['pid']))->order('id DESC')->find();
                return array(array(array($Vote['title'], mb_substr($this->handleIntro($Vote['qtxinxi']),0,58,'utf-8').'......', $Vote['wappicurl'], ((((((C('site_url') . '/index.php?g=Wap&m=Vote&a=index&token=') . $this->token) . '&wecha_id=') . $this->data['FromUserName']) . '&tid=') . $data['pid']) . '&31cms=mp.weixin.qq.com')), 'news');
            }
         else {
            return array('请直接填写要投票选项的数字编号', 'text');
        }
    }
	
    private function curlGet($url, $method = 'get', $data = '')
    {
        $ch = curl_init();
        $headers = array('Accept-Charset: utf-8');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible;MSIE 5.01;Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return $temp;
    }
    public function handleIntro($str)
    {
        $str = html_entity_decode(htmlspecialchars_decode($str));
        $search = array('&amp;', '&quot;', '&nbsp;', '&gt;', '&lt;');
        $replace = array('&', '"', ' ', '>', '<');
        return strip_tags(str_replace($search, $replace, $str));
    }
}