  <?php

  defined ('G_IN_SYSTEM') or exit ( 'No permission resources.' );

  System::load_app_class ( 'base', 'member', 'no' );

  System::load_app_fun ( 'user', 'go' );

  class cart extends base {

	 private $Cartlist;

	  

	  public function __construct() {

		  $this->Cartlist = _getcookie('Cartlist');

		
		  $this->db = System::load_sys_class("model");

  

	  }

  
	/* 
	*	获取购物车的商品id
	*	@return : string
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
  

	  //购物车商品列表

	  public function cartlist() {
		$webname = $this->_cfg ['web_name'];
		$Mcartlist = json_decode(stripslashes($this->Cartlist),true);
		$yun = $Mcartlist['yun'];
		$general = $Mcartlist['general'];
		$MoenyCount = 0;
		$numCount = 0;
		if(is_array($yun)){
			$yun_ids = $this->get_shopid($yun);
			if($yun_ids){
				$yunshop=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($yun_ids)",array("key"=>"id"));
				if(!empty($yunshop)){
					$yunList = array();
					foreach ($yunshop as $key => $val) {	
						if ($val['q_end_time'] == '' || $val['q_end_time'] == NULL) {
							$yunList[$key] = $val;
							$yun[$val['id']]['num'] = $yun[$val['id']]['num'];
							$yun[$val['id']]['shenyu'] = $val['shenyurenshu'];
							$yun[$val['id']]['money'] = $yun[$val['id']]['num']*$val['yunjiage'];
						}
					}
					$Mcartlist['yun'] = $yun;
					_setcookie('Cartlist',json_encode($Mcartlist),'');
					$Yunshopinfo = '';
					if(count($yunList) >= 1) {
				
						foreach($yun as $key => $val){
							$key=intval($key);					
							if(isset($yunList[$key])){			
								$yunList[$key]['cart_gorenci'] = $val['num'] ? $val['num'] : 1;
								$numCount += $yunList[$key]['cart_gorenci'];
								$MoenyCount+=$yunList[$key]['yunjiage']*$yunList[$key]['cart_gorenci'];
								$yunList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$yunList[$key]['yunjiage']*$val['num']),0,-1);					
								$yunList[$key]['cart_shenyu']=$yunList[$key]['zongrenshu']-$yunList[$key]['canyurenshu'];
								$Yunshopinfo .="'$key':{'shenyu':".$yunList[$key]['cart_shenyu'].",'num':".$val['num'].",'sign':'1','money':".$yunList[$key]['yunjiage']."},";
							}
						}
						$Yunshopinfo=trim($Yunshopinfo,',');
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
							$numCount += $generalList[$key]['cart_gorenci'];
							$MoenyCount+=$generalList[$key]['money']*$generalList[$key]['cart_gorenci'];
							$generalList[$key]['cart_xiaoji']=substr(sprintf("%.3f",$generalList[$key]['money']*$val['num']),0,-1);
							$Generalshopinfo.="'$key':{'num':".$val['num'].",'money':".$generalList[$key]['money'].",'sign':'1','inventory':".$generalList[$key]['inventory']."},";
						}
					}
					$Generalshopinfo=trim($Generalshopinfo,',');
				}
			}
		}
		$shop = 0;
		if (!empty($yunList) || !empty($generalList)){
			$shop = 1;
		}
		
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);	
		$Cartshopinfo='{';
		$Cartshopinfo.= 'yun:{'.$Yunshopinfo.'},general:{'.$Generalshopinfo.'},';
		$Cartshopinfo.='MoenyCount:'.$MoenyCount.'}';
		
		$key="购物车";
		include templates ( "mobile/cart", "cartlist" );

	  }

	  // 支付界面

	  public function pay() {

		  $webname = $this->_cfg ['web_name'];

		  parent::__construct ();

		  if (! $member = $this->userinfo) {

			  header ( "location: " . WEB_PATH . "/mobile/user/login" );

		  }

		  $Mcartlist = json_decode ( stripslashes ( $this->Cartlist ), true );
			
		$yun = $Mcartlist['yun'];
		$general = $Mcartlist['general'];
		$MoenyCount = 0;
		$numCount = 0;
		if(!empty($yun)){
			$result = array();
			foreach($yun as $k => $v){
				if($v['sign'] == 1)	$result[$k] = $yun[$k];
			}
			$yun_ids = $this->get_shopid($result);
			if($yun_ids){
				$yunList=$this->db->GetList("SELECT * FROM `@#_shoplist` where `id` in($yun_ids)",array("key"=>"id"));
				foreach($yunList as $key => $val){
					//if(intval($val['shenyurenshu']) < $result[$key]['num'])	_message("商品".$val['title']."没有足够的数量，请重新选择!",WEB_PATH.'/member/cart/cartlist');
					// 参与人次
					$cart_gorenci = $result[$key]['num'] ? $result[$key]['num'] : 1;
					// 小计
					$cart_xiaoji = substr(sprintf("%.3f",$val['yunjiage']*$cart_gorenci),0,-1);
					// 计算总和
					$MoenyCount += $cart_xiaoji;
					$numCount += $cart_gorenci;
					$yunList[$key]['cart_xiaoji'] = $cart_xiaoji;
					$yunList[$key]['cart_gorenci'] = $cart_gorenci;
					$yunList[$key]['cart_shenyu']=$yunList[$key]['zongrenshu']-$yunList[$key]['canyurenshu'];	
				}
			}
		}		
		if(!empty($general)){
			$result = array();
			foreach($general as $k => $v){
				if($v['sign'] == 1)	$result[$k] = $general[$k];
			}

			$general_ids = $this->get_shopid($result);
			if($general_ids){
				$generalList=$this->db->GetList("SELECT * FROM `@#_shop_general` where `id` in($general_ids)",array("key"=>"id"));
				foreach($generalList as $key => $val){
					//if($val['inventory'] < $result[$key]['num'])	_message("商品".$val['title']."没有足够的数量，请重新选择!",WEB_PATH.'/member/cart/cartlist');
					// 购买数量
					$cart_num = $result[$key]['num'] ? $result[$key]['num'] : 1;
					// 小计
					$cart_xiaoji = substr(sprintf("%.3f",$val['money']*$cart_num),0,-1);
					// 计算总和
					$MoenyCount += $cart_xiaoji;
					$numCount += $cart_num;
					$generalList[$key]['cart_xiaoji'] = $cart_xiaoji;	
					$generalList[$key]['cart_num'] = $cart_num;	
				}
			}
		}
		if($yunList || $generalList){
			$shopnum = 0; // 表示有商品
		}else{
			_setcookie('Cartlist',NULL);
			// _message("购物车没有商品!",WEB_PATH);
			$shopnum = 1; // 表示没有商品
		}
			
			
			
			
			
		 /*  $shopids = '';

		  if (is_array ( $Mcartlist )) {

			  foreach ( $Mcartlist as $key => $val ) {

				  $shopids .= intval ( $key ) . ',';

			  }

			  $shopids = str_replace ( ',0', '', $shopids );

			  $shopids = trim ( $shopids, ',' );

		

		  } */

		  

		 /*  $shoplist = array ();

		  if ($shopids != NULL) {

			  $shoplist = $this->db->GetList ( "SELECT * FROM `@#_shoplist` where `id` in($shopids)", array (

					  "key" => "id" 

			  ) );

		  }

		  $MoenyCount = 0;

		  if (count ( $shoplist ) >= 1) {

			  foreach ( $Mcartlist as $key => $val ) {

				  $key = intval ( $key );

				  if (isset ( $shoplist [$key] )) {

					  $shoplist [$key] ['cart_gorenci'] = $val ['num'] ? $val ['num'] : 1;

					  $MoenyCount += $shoplist [$key] ['yunjiage'] * $shoplist [$key] ['cart_gorenci'];

					  $shoplist [$key] ['cart_xiaoji'] = substr ( sprintf ( "%.3f", $shoplist [$key] ['yunjiage'] * $val ['num'] ), 0, - 1 );

					  $shoplist [$key] ['cart_shenyu'] = $shoplist [$key] ['zongrenshu'] - $shoplist [$key] ['canyurenshu'];

				  }

			  }

			  $shopnum = 0; // 表示有商品

		  } else {

			  _setcookie ( 'Cartlist', NULL );

			  // _message("购物车没有商品!",WEB_PATH);

			  $shopnum = 1; // 表示没有商品

		  } */

		  

		  // 总支付价格

		$MoenyCount = substr ( sprintf ( "%.3f", $MoenyCount ), 0, - 1 );

		  // 会员余额

		$Money = $member ['money'];

		  // 商品数量

		  //$shoplen = count ( $shoplist );
		$shoplen = $numCount;

		  

		$fufen = System::load_app_config ( "user_fufen", '', 'member' );

		if ($fufen ['fufen_yuan']) {
			$fufen_dikou = intval ( $member ['score'] / $fufen ['fufen_yuan'] );
		} else {
			$fufen_dikou = 0;
		}

		// 		$paylist = $this->db->GetList ( "select * from `@#_pay` where `pay_start` = '1'" );

		$paylist = $this->db->GetList("SELECT * FROM `@#_pay` where `pay_start` = '1' AND pay_mobile = 1");
		
		session_start ();
		$_SESSION ['submitcode'] = $submitcode = uniqid ();
		include templates ( "mobile/cart", "payment" );

	  }

	  
	  // 开始支付

	  public function paysubmit() {

		  $webname = $this->_cfg ['web_name'];

		  header ( "Cache-control: private" );

		  parent::__construct ();

		  if (! $this->userinfo) {

			  header ( "location: " . WEB_PATH . "/mobile/user/login" );

			  exit ();

		  }

		  

		  session_start ();

		  

		  

		  $checkpay = $this->segment ( 4 ); // 获取支付方式 fufen money bank

		  $banktype = $this->segment ( 5 ); // 获取选择的银行 CMBCHINA ICBC CCB

		  $money = $this->segment ( 6 ); // 获取需支付金额

		  $fufen = $this->segment ( 7 ); // 获取积分

		  $submitcode1 = $this->segment ( 8 ); // 获取SESSION

		  

		  $uid = $this->userinfo ['uid'];

		  

		  

		  if (! empty ( $submitcode1 )) {

			  if (isset ( $_SESSION ['submitcode'] )) {

				  $submitcode2 = $_SESSION ['submitcode'];

			  } else {

				  $submitcode2 = null;

			  }

			  if ($submitcode1 == $submitcode2) {

				  unset ( $_SESSION ["submitcode"] );

			  } else {

				  $WEB_PATH = WEB_PATH;

				  _messagemobile ( "请不要重复提交...<a href='{$WEB_PATH}/mobile/cart/cartlist' style='color:#22AAFF'>返回购物车</a>查看" );

				  exit ();

			  }

		  } else {

  // 			$WEB_PATH = WEB_PATH;

  // 			_messagemobile ( "正在返回购物车...<a href='{$WEB_PATH}/mobile/cart/cartlist' style='color:#22AAFF'>返回购物车</a>查看" );

		  }

		  

		

		  $zhifutype = $this->db->GetOne ( "select * from `@#_pay` where `pay_class` = 'alipay' " );

		  if (! $zhifutype) {

			  _messagemobile ( "手机支付只支持易宝,请联系站长开通！" );

		  }

		  

		  $pay_checkbox = false;

		  $pay_type_bank = false;

		  $pay_type_id = false;

		  

		  if ($checkpay == 'money') {

			  $pay_checkbox = true;

		  }

		  

		  if ($banktype != 'nobank') {

			  $pay_type_id = $banktype;

		  }

		  

		  if (! empty ( $zhifutype )) {

			  $pay_type_bank = $zhifutype ['pay_class'];

		  }

		  

		 
		  if (! $pay_type_id) {

			  if ($checkpay != 'fufen' && $checkpay != 'money')

				  _messagemobile ( "选择支付方式" );

		  }

		  

		 

		  

		  $pay = System::load_app_class ( 'pay', 'pay' );

		  $pay->fufen = $checkpay=='fufen'?$fufen:0;

		  $pay->pay_type_bank = $pay_type_bank;

		  $ok = $pay->init ( $uid, $pay_type_id, 'go_record' ); // 云购商品
		  
		  if ($ok != 'ok') {

			  // _setcookie ( 'Cartlist', NULL );

			  _messagemobile ( $ok."<a href='" . WEB_PATH . "/mobile/cart/cartlist' style='color:#22AAFF'>返回购物车</a>查看" );

		  }

		  

		  $check = $pay->go_pay ( $pay_checkbox );

		  if (! $check) {

			  _messagemobile ( "订单添加失败,请<a href='" . WEB_PATH . "/mobile/cart/cartlist' style='color:#22AAFF'>返回购物车</a>查看" );

		  }

		  if ($check) {

			  // 成功

			  header ( "location: " . WEB_PATH . "/mobile/cart/paysuccess" );

		  } else {

			  // 失败

			  _setcookie ( 'Cartlist', NULL );

			  header ( "location: " . WEB_PATH . "/mobile/mobile" );

		  }

		  exit ();

	  }

	  

	

	//成功页面

	public function paysuccess(){

	    $webname=$this->_cfg['web_name'];

		_setcookie('Cartlist',NULL);

		include templates("mobile/cart","paysuccess");

	}






	  

	  // 充值

	  public function addmoney() {

		  parent::__construct ();

		  $webname = $this->_cfg ['web_name'];

		  $money = $this->segment ( 4 ); // 获取充值金额

		  $pay_id = $this->segment ( 5 ); // 获取选择的支付方式

		

		  if (! $this->userinfo) {

			  header ( "location: " . WEB_PATH . "/mobile/user/login" );

			  exit ();

		  }

		  

		  $payment = $this->db->GetOne ( "select * from `@#_pay` where `pay_id` = ".$pay_id );

		  

		  

		  if (! $payment) {

			  _messagemobile ( "对不起，没有您所选择的支付方式！" );

		  }

		  

		  if (! empty ( $payment )) {

			  $pay_type_bank = $payment ['pay_class'];

		  }

		  $pay_type_id = $pay_id;

  // 		$pay_type_bank=isset($_POST['pay_bank']) ? $_POST['pay_bank'] : false;

  // 		$pay_type_id=isset($_POST['account']) ? $_POST['account'] : false;

  // 		$money=intval($_POST['money']);

		  $uid = $this->userinfo ['uid'];

		  $pay = System::load_app_class ( 'pay', 'pay' );

		  $pay->pay_type_bank = $pay_type_bank;

		  $ok = $pay->init ( $uid, $pay_type_id, 'addmoney_record', $money );

  

		  if ($ok === 'not_pay') {

			  _messagemobile ( "未选择支付平台" );

		  }

	  }

  }

  

  ?>

