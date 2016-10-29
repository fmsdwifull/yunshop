<?php 
defined('G_IN_SYSTEM')or exit('No permission resources.');
System::load_app_class('base','member','no');
System::load_app_fun('user','go');
class cart extends base {
	private $Cartlist;
	public function __construct() {			
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
		header("Cache-Control: no-cache, must-revalidate" ); 
		header("Pragma:no-cache");
		/*
		$carlist=_getcookie('Cartlist');
		foreach($carlist as $k=>$v){
			$v['sign']=1;
			$this->Cartlist[]=$v;
			
		}*/
		$this->Cartlist = _getcookie('Cartlist');
		
	
		$this->db = System::load_sys_class("model");
	}
	//充值卡充值
	public function card_addmoney() {
		$czknum = htmlspecialchars($_POST['czknum']);
		$password = htmlspecialchars($_POST['password']);
		if (empty($czknum) or empty($password)) {
		_message("您尚未填写卡密信息");
		}
		$czkdata = $this->db->GetList("select * from `@#_czk` where `status` = '1'  AND czknum='{$czknum}' AND password='{$password}'");
		if (!$czkdata) {
		_message("卡号或卡密不正确");
		}
		$czkdata = $czkdata[0];
		$uid = intval(_encrypt(_getcookie("uid"), 'DECODE'));
		//查询用户信息
		if($czkdata['type']==1){
			$members = $this->db->GetList("select * from `@#_member` where uid='{$uid}'");
			$money = $czkdata['mianzhi'] + $members[0]['money'];
			$this->db->Query("UPDATE `@#_member` SET money='{$money}' where `uid`='{$uid}' ");
		}else{
			$members = $this->db->GetList("select * from `@#_member` where uid='{$uid}' and tyczk='0'");
			if(empty($members)){
				_message("卡密不存在或者已经参与此活动!");die;
			}
			$money = $czkdata['mianzhi'] + $members[0]['money'];
			$this->db->Query("UPDATE `@#_member` SET money='{$money}',tyczk='1' where `uid`='{$uid}' ");
		}
		$this->db->Query("UPDATE `@#_czk` SET status='0' where czknum='{$czknum}' AND password='{$password}' ");


		$time = time();
		$this->db->Query("INSERT INTO `@#_member_account`(uid,type,pay,content,money,time)VALUES('{$uid}','1','账户','充值卡','{$czkdata['mianzhi']}','{$time}')");
		_message("充值成功!");
	}

	//获取购物车的商品信息到头部
	public function cartheader(){
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);	
		$yun = $Cartlist['yun'];
		$general = $Cartlist['general'];
		$MoenyCount=0;
		//	购物车 云类型
		$Yunshopinfo = '';
		$li="";
		$ii = 0;
		if(is_array($yun)){
			$yun_ids = $this->get_shopid($yun);
			if($yun_ids){
				$yunList=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($yun_ids)",array("key"=>"id"));
				if(count($yunList)>=1){
					foreach($yun as $key => $val){
						$key=intval($key);
						if(isset($yunList[$key])){			
							$yunList[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;						
							$MoenyCount+=$yunList[$key]['yunjiage']*$yunList[$key]['cart_gorenci'];
							$yunList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$yunList[$key]['yunjiage']*$val['num']),0,-1);					
							$yunList[$key]['cart_shenyu']=$yunList[$key]['zongrenshu']-$yunList[$key]['canyurenshu'];
							$Yunshopinfo .="'$key':{'shenyu':".$yunList[$key]['cart_shenyu'].",'num':".$val['num'].",'sign':'1','money':".$yunList[$key]['yunjiage']."},";
						}
					}
					$Yunshopinfo=trim($Yunshopinfo,',');
					
					foreach($yunList as $st){
						$ii++;
						if($ii <= 5) {
							$li.='<dl class="mycartcur" id="mycartcur'.$st['id'].'">';
							$li.='<dt class="img"><a href="#"><img src="'.G_UPLOAD_PATH.'/'.$st['thumb'].'"></a></dt>';
							$li.='<dd class="title"><a href="'.WEB_PATH.'/goods/'.$st['id'].'">'.$st['title'].'</a>';
							$li.='<span class="rmbred">'.$st['yunjiage'].'×'.$st['cart_gorenci'].'</span>';
							$li.='</dd>';
							$li.='<dd class="del"><a class="delGood" onclick="delheader('.$st['id'].')" href="javascript:;">删除</a></dd>';
							$li.='</dl>';
						}
						
					}
				}
			}
		}
		// 购物车 普通类型
		$Generalshopinfo = '';
		if(is_array($general)){
			$general_ids = $this->get_shopid($general);
			if($general_ids){
				$generalList=$this->db->GetList("SELECT * FROM `@#_shop_general` where `id` in($general_ids)",array("key"=>"id"));
				if(count($generalList)>=1){
					foreach($general as $key => $val){
						$key=intval($key);					
						if(isset($generalList[$key])){
							$generalList[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;
							$MoenyCount+=$generalList[$key]['money']*$generalList[$key]['cart_gorenci'];
							$generalList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$generalList[$key]['money']*$val['num']),0,-1);
							$Generalshopinfo.="'$key':{'num':".$val['num'].",'money':".$generalList[$key]['money'].",'sign':'1','inventory':".$generalList[$key]['inventory']."},";
						}
					}
					$Generalshopinfo=trim($Generalshopinfo,',');
					foreach($generalList as $st){
						$ii++;
						if($ii <= 5) {
							$li.='<dl class="mycartcur" id="mycartcur'.$st['id'].'">';
							$li.='<dt class="img"><a href="#"><img src="'.G_UPLOAD_PATH.'/'.$st['thumb'].'"></a></dt>';
							$li.='<dd class="title"><a href="'.WEB_PATH.'/g_goods/'.$st['id'].'">'.$st['title'].'</a>';
							$li.='<span class="rmbred">'.$st['money'].'×'.$st['cart_gorenci'].'</span>';
							$li.='</dd>';
							$li.='<dd class="del"><a class="delGood" onclick="g_delheader('.$st['id'].')" href="javascript:;">删除</a></dd>';
							$li.='</dl>';
						}
					}
				}
			}
		}
		$num_count = count($yunList) + count($generalList);
		if( $num_count >= 5 ){
			$li.='<dl class="mycartcur" style=" background:#fff;height:20px; text-align:right;"><a style=" color:#777;" target="_blank" href="'.WEB_PATH.'/member/cart/cartlist">查看更多<i>&gt;</i></a></dl>';
		}
		
		$Cartshopinfo='{';
		$Cartshopinfo.= 'yun:{'.$Yunshopinfo.'},general:{'.$Generalshopinfo.'},';
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);	
		$Cartshopinfo.='MoenyCount:'.$MoenyCount.'}';

		$shop['li']=$li;
		if(!$num_count){
			$shop['num']=0;
		}else{
			$shop['num'] = $num_count;		
		}	
	
		$shop['sum']=$MoenyCount;
		echo json_encode($shop);
	}
	
	//获取购物车的商品信息
	public function cartshop(){
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);	
		$yun = $Cartlist['yun'];
		$general = $Cartlist['general'];
		$MoenyCount=0;
		//	购物车 云类型
		$Yunshopinfo = '';
		$li="";
		$ii = 0;
		if(is_array($yun)){
			$yun_ids = $this->get_shopid($yun);
			if($yun_ids){
				$yunList=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($yun_ids)",array("key"=>"id"));
				if(count($yunList)>=1){
					foreach($yun as $key => $val){
						$key=intval($key);
						if(isset($yunList[$key])){			
							$yunList[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;						
							$MoenyCount+=$yunList[$key]['yunjiage']*$yunList[$key]['cart_gorenci'];
							$yunList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$yunList[$key]['yunjiage']*$val['num']),0,-1);					
							$yunList[$key]['cart_shenyu']=$yunList[$key]['zongrenshu']-$yunList[$key]['canyurenshu'];
							$Yunshopinfo .="'$key':{'shenyu':".$yunList[$key]['cart_shenyu'].",'num':".$val['num'].",'sign':'1','money':".$yunList[$key]['yunjiage']."},";
						}
					}
					$Yunshopinfo=trim($Yunshopinfo,',');
					
					// foreach($yunList as $st){
					// 	$ii++;
					// 	if($ii <= 7) {
					// 		$li.='<li id="shopid'.$st['id'].'">';
					// 		$li.='<a href="javascript:;" onclick="delshop('.$st['id'].')" title="删除" class="Close"></a>';
					// 		$li.='<a href="'.WEB_PATH.'/goods/'.$st['id'].'"><img src="'.G_UPLOAD_PATH.'/'.$st['thumb'].'" title="'.$st['title'].'"></a>';
					// 		$li.='<span class="orange">'.$st['cart_gorenci'].'</span>人次';
					// 		$li.='</li>';
					// 	}
						
					// }
				}
			}
		}
		// 购物车 普通类型
		$Generalshopinfo = '';
		if(is_array($general)){
			$general_ids = $this->get_shopid($general);
			if($general_ids){
				$generalList=$this->db->GetList("SELECT * FROM `@#_shop_general` where `id` in($general_ids)",array("key"=>"id"));
				if(count($generalList)>=1){
					foreach($general as $key => $val){
						$key=intval($key);					
						if(isset($generalList[$key])){
							$generalList[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;
							$MoenyCount+=$generalList[$key]['money']*$generalList[$key]['cart_gorenci'];
							$generalList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$generalList[$key]['money']*$val['num']),0,-1);
							$Generalshopinfo.="'$key':{'num':".$val['num'].",'money':".$generalList[$key]['money'].",'sign':'1','inventory':".$generalList[$key]['inventory']."},";
						}
					}
					$Generalshopinfo=trim($Generalshopinfo,',');
					// foreach($generalList as $st){
					// 	$ii++;
					// 	if($ii <= 7) {
					// 		$li.='<li id="shopid'.$st['id'].'">';
					// 		$li.='<a href="javascript:;" onclick="g_delshop('.$st['id'].')" title="删除" class="Close"></a>';
					// 		$li.='<a href="'.WEB_PATH.'/g_goods/'.$st['id'].'"><img src="'.G_UPLOAD_PATH.'/'.$st['thumb'].'" title="'.$st['title'].'"></a>';
					// 		$li.='<span class="orange">'.$st['cart_gorenci'].'</span>个';
					// 		$li.='</li>';
					// 	}
					// }
				}
			}
		}

		$str ='<dt><b>购物车</b><a href="'.WEB_PATH.'/member/cart/cartlist">全屏查看</a></dt><div id="cartListDiv" class="right-hide-scroll">';
		foreach ($yunList as $k => $v) {
			$str .= '<dd id="shopdd_'.$k.'">';
			$str .= '<a href="javascript:;"><img width="60" height="60" src="'.G_UPLOAD_PATH.'/'.$v['thumb'].'"/></a>';  
			$str .= '<div class="yfixed-divs-r">';
			$str .= '<input  type="hidden" id="htimes_'.$k.'" value="'.$v['cart_gorenci'].'"/>'; 
			$str .= '<p>云购人次 <em id="htimes_'.$k.'">'.$v['cart_gorenci'].'</em></p>';  
			$str .= '<p>小计 <em id="hprice_'.$k.'">￥'.$v['cart_gorenci']*$v['yunjiage'].'</em></p><i onclick="hdel('.$v['id'].')"></i></div>';  
			$str .= '<input  type="hidden" id="harea_'.$k.'" value="'.$v['cart_gorenci'].'"/>';     
			$str .= '<input  type="hidden" id="gid_'.$k.'" value="'.$v['id'].'"/>'; 
			$str .= '<input  type="hidden" id="hbuyPeriod_'.$k.'" value="'.$v['cart_gorenci'].'"/>'; 
			$str .= '<input  type="hidden" id="id_'.$k.'" value="'.$v['id'].'"/></dd>';     
		}
		foreach ($generalList as $k => $v) {
			$str .= '<dd id="shopdd_'.$k.'">';
			$str .= '<a href="javascript:;"><img width="60" height="60" src="'.G_UPLOAD_PATH.'/'.$v['thumb'].'"/></a>';  
			$str .= '<div class="yfixed-divs-r">';
			$str .= '<input  type="hidden" id="htimes_'.$k.'" value="'.$v['cart_gorenci'].'"/>'; 
			$str .= '<p>购买数量 <em id="htimes_'.$k.'">'.$v['cart_gorenci'].'</em></p>';  
			$str .= '<p>小计 <em id="hprice_'.$k.'">￥'.$v['cart_gorenci']*$v['money'].'</em></p><i onclick="ghdel('.$v['id'].')"></i></div>';  
			$str .= '<input  type="hidden" id="harea_'.$k.'" value="'.$v['cart_gorenci'].'"/>';     
			$str .= '<input  type="hidden" id="gid_'.$k.'" value="'.$v['id'].'"/>'; 
			$str .= '<input  type="hidden" id="hbuyPeriod_'.$k.'" value="'.$v['cart_gorenci'].'"/>'; 
			$str .= '<input  type="hidden" id="id_'.$k.'" value="'.$v['id'].'"/></dd>';     
		}
		$str .='</div>';


		$num_count = count($yunList) + count($generalList);
		
		$Cartshopinfo='{';
		$Cartshopinfo.= 'yun:{'.$Yunshopinfo.'},general:{'.$Generalshopinfo.'},';
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);	
		$Cartshopinfo.='MoenyCount:'.$MoenyCount.'}';

		$shop['li']=$str;
		if(!$num_count){
			$shop['num']=0;
		}else{
			$shop['num'] = $num_count;		
		}	
		$shop['sum']=$MoenyCount;
		echo json_encode($shop);
	}
	
	//获取购物车的商品数量ajax
	public function getnumber(){
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);
		$yun = $Cartlist['yun'];
		$general = $Cartlist['general'];
		$num_count = 0;
		if(!empty($yun)){
			$num_count += count($yun);
		}
		if(!empty($general)){
			$num_count += count($general);
		}
		echo json_encode($num_count);
		
	}
	
	//购物车商品列表
	public function cartlist1(){
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);	
	
		$shopids='';	
		if(is_array($Cartlist)){			
			foreach($Cartlist as $key => $val){
				$shopids.=intval($key).',';				
			}
			$shopids=str_replace(',0','',$shopids);
			$shopids=trim($shopids,',');
	
		}
		$shoplist=array();
		if($shopids!=NULL){
			$shoplist=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($shopids)",array("key"=>"id"));
		}
		$MoenyCount=0;
		$Cartshopinfo='{';
		if(count($shoplist)>=1){
			foreach($Cartlist as $key => $val){
					$key=intval($key);					
					if(isset($shoplist[$key])){									
						$shoplist[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;						
						$MoenyCount+=$shoplist[$key]['yunjiage']*$shoplist[$key]['cart_gorenci'];
						$shoplist[$key]['cart_xiaoji']=substr(sprintf("%.3f",$shoplist[$key]['yunjiage']*$val['num']),0,-1);					
						$shoplist[$key]['cart_shenyu']=$shoplist[$key]['zongrenshu']-$shoplist[$key]['canyurenshu'];
						$Cartshopinfo.="'$key':{'shenyu':".$shoplist[$key]['cart_shenyu'].",'num':".$val['num'].",'sign':'1','money':".$shoplist[$key]['yunjiage']."},";
					}
			}
		}
		
		
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);	
		$Cartshopinfo.="'MoenyCount':$MoenyCount}";		
		include templates("cart","cartlist");
	}
	
	/* 
	*	获取购物车的所有分类商品id
	*/
	public function get_shopid($arr = array()){
		$shopids='';	
		foreach($arr as $key => $val){
			$shopids .= intval($key).',';		
		}	
		$shopids=str_replace(',0','',$shopids);
		$shopids=trim($shopids,',');
		return $shopids;
	}
	
	public function cartlist(){	
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);
		$yun = $Cartlist['yun'];
		$general = $Cartlist['general'];
		$MoenyCount=0;
		//	购物车 云类型
		$Yunshopinfo = '';
		if(is_array($yun)){
			$yun_ids = $this->get_shopid($yun);
			if($yun_ids){
				$yunlist=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($yun_ids)",array("key"=>"id"));
				if(count($yunlist)>=1){
					foreach($yun as $key => $val){
						$key=intval($key);					
						if(isset($yunlist[$key])){			
							$yunlist[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;						
							$MoenyCount+=$yunlist[$key]['yunjiage']*$yunlist[$key]['cart_gorenci'];
							$yunlist[$key]['cart_xiaoji']=substr(sprintf("%.3f",$yunlist[$key]['yunjiage']*$val['num']),0,-1);					
							$yunlist[$key]['cart_shenyu']=$yunlist[$key]['zongrenshu']-$yunlist[$key]['canyurenshu'];
							$Yunshopinfo .="'$key':{'shenyu':".$yunlist[$key]['cart_shenyu'].",'num':".$val['num'].",'sign':'1','money':".$yunlist[$key]['yunjiage']."},";
						}
					}
					$Yunshopinfo=trim($Yunshopinfo,',');
				}
			}
		}
		// 购物车 普通类型
		$Generalshopinfo = '';
		if(is_array($general)){
			$general_ids = $this->get_shopid($general);
			if($general_ids){
				$generalList=$this->db->GetList("SELECT * FROM `@#_shop_general` where `id` in($general_ids)",array("key"=>"id"));
				if(count($generalList)>=1){
					foreach($general as $key => $val){
						$key=intval($key);					
						if(isset($generalList[$key])){
							$generalList[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;
							$MoenyCount+=$generalList[$key]['money']*$generalList[$key]['cart_gorenci'];
							$generalList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$generalList[$key]['money']*$val['num']),0,-1);
							$Generalshopinfo.="'$key':{'num':".$val['num'].",'money':".$generalList[$key]['money'].",'sign':'1','inventory':".$generalList[$key]['inventory']."},";
						}
					}
					$Generalshopinfo=trim($Generalshopinfo,',');
				}
			}
		}
	
		$Cartshopinfo='{';
		$Cartshopinfo.= 'yun:{'.$Yunshopinfo.'},general:{'.$Generalshopinfo.'},';
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);	
		$Cartshopinfo.='MoenyCount:'.$MoenyCount.'}';	
		include templates("cart","cartlist");
	}
	//支付界面
	public function pay(){
		parent::__construct();
		if(!$member=$this->userinfo)$this->HeaderLogin();
		
		$Cartlist=(json_decode(stripslashes($this->Cartlist),true));
		$yun = $Cartlist['yun'];
		$general = $Cartlist['general'];
		$MoenyCount = 0;
		if(is_array($yun)){
			$result = array();
			foreach($yun as $k => $v){
				if($v['sign'] == 1)	$result[$k] = $yun[$k];
			}
			$yun_ids = $this->get_shopid($result);
			if($yun_ids){
				$yunlist=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($yun_ids)",array("key"=>"id"));
				foreach($yunlist as $key => $val){
					if(intval($val['shenyurenshu']) < $result[$key]['num'])	_message("商品".$val['title']."没有足够的数量，请重新选择!",WEB_PATH.'/member/cart/cartlist');
					// 参与人次
					$cart_gorenci = $result[$key]['num'] ? $result[$key]['num'] : 1;
					// 小计
					$cart_xiaoji = substr(sprintf("%.3f",$val['yunjiage']*$cart_gorenci),0,-1);
					// 计算总和
					$MoenyCount += $cart_xiaoji;
					$yunlist[$key]['cart_xiaoji'] = $cart_xiaoji;
					$yunlist[$key]['cart_gorenci'] = $cart_gorenci;
					$yunlist[$key]['cart_shenyu']=$yunlist[$key]['zongrenshu']-$yunlist[$key]['canyurenshu'];	
				}
			}
		}		
		if(is_array($general)){
			$result = array();
			foreach($general as $k => $v){
				if($v['sign'] == 1)	$result[$k] = $general[$k];
			}

			$general_ids = $this->get_shopid($result);
			if($general_ids){
				$generallist=$this->db->GetList("SELECT * FROM `@#_shop_general` where `id` in($general_ids)",array("key"=>"id"));
				foreach($generallist as $key => $val){
					if($val['inventory'] < $result[$key]['num'])	_message("商品".$val['title']."没有足够的数量，请重新选择!",WEB_PATH.'/member/cart/cartlist');
					// 购买数量
					$cart_num = $result[$key]['num'] ? $result[$key]['num'] : 1;
					// 小计
					$cart_xiaoji = substr(sprintf("%.3f",$val['money']*$cart_num),0,-1);
					// 计算总和
					$MoenyCount += $cart_xiaoji;
					$generallist[$key]['cart_xiaoji'] = $cart_xiaoji;	
					$generallist[$key]['cart_num'] = $cart_num;	
				}
			}
		}
		
		if(!is_array($yunlist) && !is_array($generallist)){
			_setcookie('Cartlist',NULL);
			_message("购物车没有商品!",WEB_PATH);
		}

		//总支付价格
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);
		//会员余额
		$Money=$member['money'];
		//商品数量
		$shoplen=count($generallist)+count($yunlist);		
		
		$fufen = System::load_app_config("user_fufen");
		if($fufen['fufen_yuan']){
			$fufen_dikou = intval($member['score'] / $fufen['fufen_yuan']);
		}else{
			$fufen_dikou = 0;
		}
		$paylist = $this->db->GetList("select * from `@#_pay` where `pay_start` = '1'and `pay_class`!='wapalipay'and `pay_class`!='chinabankwap'and `pay_class`!='wxpay_web'and `pay_class`!='unionpay_web'");
		$cookies = base64_encode($this->Cartlist);
		
		session_start();
		$_SESSION['submitcode'] = $submitcode = uniqid();
		
		include templates("cart","pay");
	}
	
	//开始支付
	public function paysubmit(){
		
		if(!isset($_POST['submit'])){	
			_message("正在返回购物车...",WEB_PATH.'/member/cart/cartlist');
			exit;
		}	
		

		session_start();		
		if(isset($_POST['submitcode'])) {
			if(isset($_SESSION['submitcode'])){
				$submitcode = $_SESSION['submitcode'];
			}else{
				$submitcode = null;
			}		
			if($_POST['submitcode'] == $submitcode){			
				unset($_SESSION["submitcode"]);      
			}else{				
				_message("请不要重复提交...",WEB_PATH.'/member/cart/cartlist');
			}	
		}else{
			_message("正在返回购物车...",WEB_PATH.'/member/cart/cartlist');
		}
	
	
		parent::__construct();	
		if(!$this->userinfo)$this->HeaderLogin();
		$uid = $this->userinfo['uid'];
		
		$pay_checkbox=isset($_POST['moneycheckbox']) ? true : false;	
		$pay_type_bank=isset($_POST['pay_bank']) ? $_POST['pay_bank'] : false;
		$pay_type_id=isset($_POST['account']) ? $_POST['account'] : false;		
		
		
		if(isset($_POST['shop_score'])){
			$fufen_cfg = System::load_app_config("user_fufen",'','member');	
			$fufen = intval($_POST['shop_score_num']);			
			if($fufen_cfg['fufen_yuan']){				
				$fufen = intval($fufen / $fufen_cfg['fufen_yuan']);
				$fufen = $fufen * $fufen_cfg['fufen_yuan'];
			}			
		}else{
			$fufen = 0;
		}		
		/*************
			start
		*************/
		
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);
		
		$pay=System::load_app_class('pay','pay');
		//$pay->scookie = json_decode(base64_decode($_POST['cookies']));
			
		$pay->fufen = $fufen;
		$pay->pay_type_bank = $pay_type_bank;
		$ok = $pay->init($uid,$pay_type_id,'go_record');	//云购商品	
		if($ok !== 'ok'){
			_message($ok,G_WEB_PATH);
		}
		
		$check = $pay->go_pay($pay_checkbox);
		if($check === 'not_pay'){
			_message('未选择支付平台!',WEB_PATH.'/member/cart/cartlist');
		}
		if(!$check){
			_message("商品支付失败!",WEB_PATH.'/member/cart/cartlist');
		}
		if($check){
			//成功
			header("location: ".WEB_PATH."/member/cart/paysuccess");
		}else{
			//失败	
			$_COOKIE['Cartlist'] = NULL;
			_setcookie("Cartlist",null);
			header("location: ".WEB_PATH);
		}		
		exit;
	}
	
	//成功页面
	public function paysuccess(){	
		$_COOKIE['Cartlist'] = NULL;
		_setcookie("Cartlist",null);
		include templates("cart","paysuccess");		
	}
	
	//充值
	public function addmoney(){
		parent::__construct();	
		if(!isset($_POST['submit'])){	
			_message("正在返回充值页面...",WEB_PATH.'/member/member/home/userrecharge');
			exit;
		}	
		if(!$this->userinfo)$this->HeaderLogin();		
		$pay_type_bank=isset($_POST['pay_bank']) ? $_POST['pay_bank'] : false;
		$pay_type_id=isset($_POST['account']) ? $_POST['account'] : false;		
		$money=intval($_POST['money']);		
		$uid = $this->userinfo['uid'];
		$pay=System::load_app_class('pay','pay');
		$pay->pay_type_bank = $pay_type_bank;
		$ok = $pay->init($uid,$pay_type_id,'addmoney_record',$money);
		if($ok === 'not_pay'){
			_message("未选择支付平台");
		}
	}
}


?>