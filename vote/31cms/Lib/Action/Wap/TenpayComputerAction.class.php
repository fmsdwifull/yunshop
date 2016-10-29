<?php
class TenpayComputerAction extends BaseAction{
	public $token;
	public $wecha_id;
	public $payConfig;
	public function __construct(){
		$this->token = $this->_get('token');
		$this->wecha_id	= $this->_get('wecha_id');
		if (!$this->token){
			//
			$product_cart_model=M('product_cart');
			$out_trade_no = $this->_get('out_trade_no');
			$order=$product_cart_model->where(array('orderid'=>$out_trade_no))->find();
			if (!$order){
				$order=$product_cart_model->where(array('id'=>intval($this->_get('out_trade_no'))))->find();
			}
			$this->token=$order['token'];
		}
		//读取支付宝配置
		$pay_config_db=M('Alipay_config');
		$this->payConfig=$pay_config_db->where(array('token'=>$this->token))->find();
	}
	public function pay(){
		
		////////////////////////////////////
		//参数数据
		$price=$_GET['price'];
		$orderName=$_GET['orderName'];
		$orderid=$_GET['orderid'];
		if (!$orderid){
			$orderid=$_GET['single_orderid'];//单个订单
		}
		$notify_url = C('site_url').'/index.php?g=Wap&m=TenpayComputer&a=notify_url';
		//需http://格式的完整路径，不能加?id=123这类自定义参数
		//页面跳转同步通知页面路径
		$return_url = C('site_url').'/index.php?g=Wap&m=TenpayComputer&a=return_url&token='.$_GET['token'].'&wecha_id='.$_GET['wecha_id'].'&from='.$_GET['from'];
		//
		if(!$price)exit('必须有价格才能支付');
		$total_fee =floatval($price)*100;
		import("@.ORG.TenpayComputer.RequestHandler");
		$out_trade_no = $orderid;
		
		$reqHandler = new RequestHandler();
		$reqHandler->init();
		$key=$this->payConfig['partnerkey'];
		$partner=$this->payConfig['partnerid'];
		$reqHandler->setKey($key);
		$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

		//----------------------------------------
		//设置支付参数
		//----------------------------------------
		$reqHandler->setParameter("partner", $partner);
		$reqHandler->setParameter("out_trade_no", $out_trade_no);
		$reqHandler->setParameter("total_fee", $total_fee);  //总金额
		$reqHandler->setParameter("return_url", $return_url);
		$reqHandler->setParameter("notify_url", $notify_url);
		$reqHandler->setParameter("body", '财付通在线支付');
		$reqHandler->setParameter("bank_type", "DEFAULT");  	  //银行类型，默认为财付通
		//用户ip
		$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
		$reqHandler->setParameter("fee_type", "1");               //币种
		$reqHandler->setParameter("subject",'weixin');          //商品名称，（中介交易时必填）

		//系统可选参数
		$reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
		$reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
		$reqHandler->setParameter("input_charset", "utf-8");   	  //字符集
		$reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号

		//业务可选参数
		$reqHandler->setParameter("attach", "");             	  //附件数据，原样返回就可以了
		$reqHandler->setParameter("product_fee", "");        	  //商品费用
		$reqHandler->setParameter("transport_fee", "0");      	  //物流费用
		$reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
		$reqHandler->setParameter("time_expire", "");             //订单失效时间
		$reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
		$reqHandler->setParameter("goods_tag", "");               //商品标记
		$reqHandler->setParameter("trade_mode",1);              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
		$reqHandler->setParameter("transport_desc","");              //物流说明
		$reqHandler->setParameter("trans_type","1");              //交易类型
		$reqHandler->setParameter("agentid","");                  //平台ID
		$reqHandler->setParameter("agent_type","");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
		$reqHandler->setParameter("seller_id","");                //卖家的商户号



		//请求的URL
		$reqUrl = $reqHandler->getRequestURL();

		//获取debug信息,建议把请求和debug信息写入日志，方便定位问题
		/**/
		$debugInfo = $reqHandler->getDebugInfo();
		header('Location:'.$reqUrl);
		//echo "<br/>" . $reqUrl . "<br/>";
		//echo "<br/>" . $debugInfo . "<br/>";
	}
	//同步数据处理
	public function return_url (){
		import("@.ORG.TenpayComputer.ResponseHandler");
		$resHandler = new ResponseHandler();
		$key=$this->payConfig['partnerkey'];
		$resHandler->setKey($key);
		$out_trade_no = $this->_get('out_trade_no');
		//if($resHandler->isTenpaySign()) {
			$notify_id = $resHandler->getParameter("notify_id");
			//商户订单号
			$out_trade_no = $resHandler->getParameter("out_trade_no");
			//财付通订单号
			$transaction_id = $resHandler->getParameter("transaction_id");
			//金额,以分为单位
			$total_fee = $resHandler->getParameter("total_fee");
			//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
			$discount = $resHandler->getParameter("discount");
			//支付结果
			$trade_state = $resHandler->getParameter("trade_state");
			//交易模式,1即时到账
			$trade_mode = $resHandler->getParameter("trade_mode");
			
			if("0" == $trade_state) {
				$member_card_create_db=M('Member_card_create');
				$userCard=$member_card_create_db->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id))->find();
				$member_card_set_db=M('Member_card_set');
				$thisCard=$member_card_set_db->where(array('id'=>intval($userCard['cardid'])))->find();
				$set_exchange = M('Member_card_exchange')->where(array('cardid'=>intval($thisCard['id'])))->find();
				//
				$arr['token']=$this->token;
				$arr['wecha_id']=$this->wecha_id;
				$arr['expense']=intval($total_fee/100);
				$arr['time']=time();
				$arr['cat']=99;
				$arr['staffid']=0;
				$arr['score']=intval($set_exchange['reward'])*$order['price'];
				M('Member_card_use_record')->add($arr);
				$userinfo_db=M('Userinfo');
				$thisUser = $userinfo_db->where(array('token'=>$thisCard['token'],'wecha_id'=>$arr['wecha_id']))->find();
				$userArr=array();
				$userArr['total_score']=$thisUser['total_score']+$arr['score'];
				$userArr['expensetotal']=$thisUser['expensetotal']+$arr['expense'];
				$userinfo_db->where(array('token'=>$thisCard['token'],'wecha_id'=>$arr['wecha_id']))->save($userArr);
				//
				$from=$_GET['from'];
				$from=$from?$from:'Groupon';
				$from=$from!='groupon'?$from:'Groupon';
				switch (strtolower($from)){
					default:
					case 'groupon':
					case 'store':
						$order_model=M('product_cart');
						break;
					case 'repast':
						$order_model=M('Dish_order');
						break;
					case 'hotels':
						$order_model=M('Hotels_order');
						break;
					case 'business':
						$order_model=M('Reservebook');
						break;
				}
				$order_model->where(array('orderid'=>$out_trade_no))->setField('paid',1);
				$this->redirect('/index.php?g=Wap&m='.$from.'&a=payReturn&token='.$_GET['token'].'&wecha_id='.$_GET['wecha_id'].'&orderid='.$out_trade_no);
			}else {
				exit('付款失败');
			}
		//}else {
			//exit('sign error');
	//	}
	}
	public function notify_url(){
		echo "success"; 
		eixt();
	}
}
?>