<?php
defined('G_IN_SYSTEM')or exit('No permission resources.');

class wxpay_web_url extends SystemAction {
	public function __construct(){
		$this->db=System::load_sys_class('model');
	}

	public function payinfo(){
		$msg = $this->segment(4);
		if ( $msg == "cancel" ){
			$msg = '交易取消！';
		}else if ( $msg == "fail" ){
			$msg = '交易失败！';
		}else if ( $msg == "nowechat" ){
			$msg = '请关注微信公众号在微信中登录后进行支付操作！';
		} else {
			$msg = '交易错误：'.urldecode($msg);
		}

		_messagemobile($msg);

	}

	public function init() {
		if ( empty($_GET['money']) || empty($_GET['out_trade_no']) ) {
			header('Location: '.WEB_PATH.'/pay/wxpay_web_url/payinfo/fail');
			die;
		}

		$config=array();
		$config['money'] = $_GET['money'];
		$config['code'] = $_GET['out_trade_no'];
		$config['NotifyUrl']  = G_WEB_PATH.'/index.php/pay/'.__CLASS__.'/houtai/';

		$pay = System::load_app_class('wxpay_web','pay');
		$pay->config($config);
		$pay->send_pay();
	}

    public function houtai(){

		include_once dirname(__FILE__)."/lib/wxpay/WxPayPubHelper.php";

		$pay = $this->db->GetOne("SELECT * from `@#_pay` where `pay_class` = 'wxpay_web'");
		$config = array();
		$config['pay_type_data'] = unserialize($pay['pay_key']);

		WxPayConf_pub::$APPID = $config['pay_type_data']['APPID']['val'];
		WxPayConf_pub::$MCHID = $config['pay_type_data']['MCHID']['val'];
		WxPayConf_pub::$KEY = $config['pay_type_data']['KEY']['val'];
		WxPayConf_pub::$APPSECRET = $config['pay_type_data']['APPSECRET']['val'];

		$notify = new Notify_pub();

		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify->saveData($xml);

		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		echo $returnXml;
		$notify_urllog_name="addons/wxpay/notify_url.log";
		_log_result($notify_urllog_name,"【接收到的微信支付异步通知】:\n".$xml."\n");

		if( $notify->checkSign() == false ){
			_log_result($notify_urllog_name,"【签名失败】:\n".$xml."\n");
			die;
		}elseif ($notify->data["return_code"] == "FAIL") {
			_log_result($notify_urllog_name,"【通信出错】:\n".$xml."\n");
			die;
		}elseif($notify->data["result_code"] == "FAIL"){
			_log_result($notify_urllog_name,"【业务出错】:\n".$xml."\n");
			die;
		}

		$paylog_name = "addons/wxpay/paylog.log";
		$total_fee_t = $notify->data['total_fee']/100;
		$out_trade_no=$notify->data['out_trade_no'];

//     	$paylog_name = "addons/wxpay/paylog.log";
//     			$total_fee_t = 1;
//     			$out_trade_no='C14383276090373367';

		$this->db->Autocommit_start();
		$dingdaninfo = $this->db->GetOne("select * from `@#_member_addmoney_record` where `code` = '$out_trade_no' and `money` = '$total_fee_t' and `status` = '未付款' for update");
		if(!$dingdaninfo){
			_log_result($paylog_name,"【无法查询订单信息】:\n".$out_trade_no."\n");
			echo "fail";exit;
		}
		$uid = $dingdaninfo['uid'];
		$time = time();
		$up_q1 = $this->db->Query("UPDATE `@#_member_addmoney_record` SET `pay_type` = '微信支付微信端', `status` = '已付款' where `id` = '$dingdaninfo[id]' and `code` = '$dingdaninfo[code]'");
		$up_q2 = $this->db->Query("UPDATE `@#_member` SET `money` = `money` + $total_fee_t where (`uid` = '$dingdaninfo[uid]')");
		$up_q3 = $this->db->Query("INSERT INTO `@#_member_account` (`uid`, `type`, `pay`, `content`, `money`, `time`) VALUES ('$dingdaninfo[uid]', '1', '账户', '通过微信支付微信端充值', '$total_fee_t', '$time')");
		if($up_q1 && $up_q2 && $up_q3){
			$this->db->Autocommit_commit();
			echo 'addmoney success!<br/>';
		}else{
			$this->db->Autocommit_rollback();
			_log_result($paylog_name,"【修改充值记录失败】:\n".$out_trade_no."\n");
			echo "fail";exit;
		}
		
		if(empty($dingdaninfo['scookies'])){
			echo "success";exit;
		}
		$scookies = unserialize($dingdaninfo['scookies']);
		$pay = System::load_app_class('pay','pay');
		$pay->scookie = $scookies;
		$payname = $dingdaninfo['pay_type'];
		$payarr =$this->db->GetOne("SELECT * from `@#_pay` where `pay_name` = '$payname' ");
		$ok = $pay->init($uid,$payarr['pay_id'],'go_record');
		if($ok != 'ok'){
			echo "fail";exit;
		}
		$check = $pay->go_pay(1);
		if ( $check ) {
// 			$this->db->Query("UPDATE `@#_member_addmoney_record` SET `scookies` = '1' where `code` = '$out_trade_no' and `status` = '已付款'");
			echo "success";exit;
		} else {
			echo "fail";exit;
		}

		

	}


}
