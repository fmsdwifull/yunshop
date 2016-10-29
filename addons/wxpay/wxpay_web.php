<?php
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
*/
	error_reporting(E_ERROR);
	ini_set("display_errors","ON");

	if(!$_GET['key']){
		echo '交易错误：缺失支付参数!'; exit();
	}
	//========= 步骤1：参数配置 ============
	$filename = '../paytxt/'.$_GET['key'].'.txt';
	$config_json=file_get_contents($filename);
	$config = json_decode($config_json,true);

	include_once("WxPayPubHelper.php");
	WxPayConf_pub::$APPID = $config['pay_type_data']['APPID']['val'];
	WxPayConf_pub::$MCHID = $config['pay_type_data']['MCHID']['val'];
	WxPayConf_pub::$KEY = $config['pay_type_data']['KEY']['val'];
	WxPayConf_pub::$APPSECRET = $config['pay_type_data']['APPSECRET']['val'];

	WxPayConf_pub::$SSLCERT_PATH = 'cacert/apiclient_cert.pem';
	WxPayConf_pub::$SSLKEY_PATH = 'cacert/apiclient_key.pem';
	WxPayConf_pub::$NOTIFY_URL = $config['NotifyUrl'] ;

	//使用jsapi接口
	$jsApi = new JsApi_pub();
	$jsApi->setCode($config['wxcode']);
	$openid = $config['openid'] ;
	
	
	//=========步骤2：使用统一支付接口，获取prepay_id============
	//使用统一支付接口
	$unifiedOrder = new UnifiedOrder_pub();

	//设置统一支付接口参数
	//设置必填参数
	//appid已填,商户无需重复填写
	//mch_id已填,商户无需重复填写
	//noncestr已填,商户无需重复填写
	//spbill_create_ip已填,商户无需重复填写
	//sign已填,商户无需重复填写
	$unifiedOrder->setParameter("openid",$openid);
	$unifiedOrder->setParameter("body","购买商品");//商品描述
	$unifiedOrder->setParameter("out_trade_no",$config['code']);//商户订单号
	$unifiedOrder->setParameter("total_fee",$config['money']*100);//总金额
	$unifiedOrder->setParameter("notify_url",$config['NotifyUrl']);//通知地址
	$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型

	$prepay_id = $unifiedOrder->getPrepayId();


	//=========步骤3：使用jsapi调起支付============
	$jsApi->setPrepayId($prepay_id);

	$jsApiParameters = $jsApi->getParameters();
	
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>微信支付</title>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
	<style type="text/css">
		.paymainbox {
			background: #f4f4f4;
			text-align: center;
			overflow: hidden;
			zoom: 1;
		}

		.paymainbox .loading {
			border-top: none;
			box-shadow: none;
			margin-top: 70px;
		}

		* {
			margin: 0;
			padding: 0;
		}

		body,input,textarea {
			font-size: 12px;
			font-family: arial,微软雅黑;
		}

		div,input {
			font-size: 12px;
		}

		input,textarea {
			-webkit-tap-highlight-color: rgba(0,0,0,0);
			-webkit-appearance: none;
			border: 0;
			border-radius: 0;
		}

		a {
			color: #000;
			text-decoration: none;
			outline: medium none;
		}

		a:hover {
			color: #C00;
		}

		b {
			font-weight: normal;
		}

		.z-minheight {
			min-height: 200px;
		}

		.loading {
			clear: both;
			width: 100%;
			display: block;
			background: #f4f4f4;
			height: 40px;
			line-height: 40px;
			text-align: center;
			color: #999;
			font-size: 12px;
			box-shadow: 0 1px 1px #ddd inset;
		}

		.loading b {
			background: url(data:image/gif;base64,R0lGODlhEAAQAPIAAP///wCA/8Lg/kKg/gCA/2Kw/oLA/pLI/iH/C05FVFNDQVBFMi4wAwEAAAAh/h1CdWlsdCB3aXRoIEdJRiBNb3ZpZSBHZWFyIDQuMAAh/hVNYWRlIGJ5IEFqYXhMb2FkLmluZm8AIfkECQoAAAAsAAAAABAAEAAAAzMIutz+MMpJaxNjCDoIGZwHTphmCUWxMcK6FJnBti5gxMJx0C1bGDndpgc5GAwHSmvnSAAAIfkECQoAAAAsAAAAABAAEAAAAzQIutz+TowhIBuEDLuw5opEcUJRVGAxGSBgTEVbGqh8HLV13+1hGAeAINcY4oZDGbIlJCoSACH5BAkKAAAALAAAAAAQABAAAAM2CLoyIyvKQciQzJRWLwaFYxwO9BlO8UlCYZircBzwCsyzvRzGqCsCWe0X/AGDww8yqWQan78EACH5BAkKAAAALAAAAAAQABAAAAMzCLpiJSvKMoaR7JxWX4WLpgmFIQwEMUSHYRwRqkaCsNEfA2JSXfM9HzA4LBqPyKRyOUwAACH5BAkKAAAALAAAAAAQABAAAAMyCLpyJytK52QU8BjzTIEMJnbDYFxiVJSFhLkeaFlCKc/KQBADHuk8H8MmLBqPyKRSkgAAIfkECQoAAAAsAAAAABAAEAAAAzMIuiDCkDkX43TnvNqeMBnHHOAhLkK2ncpXrKIxDAYLFHNhu7A195UBgTCwCYm7n20pSgAAIfkECQoAAAAsAAAAABAAEAAAAzIIutz+8AkR2ZxVXZoB7tpxcJVgiN1hnN00loVBRsUwFJBgm7YBDQTCQBCbMYDC1s6RAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P4wykmrZULUnCnXHggIwyCOx3EOBDEwqcqwrlAYwmEYB1bapQIgdWIYgp5bEZAAADsAAAAAAAAAAAA=);
			background-size: 12px auto;
			background-repeat: no-repeat;
			width: 12px;
			height: 12px;
			display: inline-block;
			margin-right: 5px;
			position: relative;
			top: 2px;
		}
	</style>
	</head>
<body style="background: #f4f4f4;">
    <div class="h5-1yyg-v1">
        <div id="divPayBox" class="paymainbox z-minheight">
            <div class="loading"><b></b>正在提交支付请求，请稍后…</div>
        </div>
        <div id="divPayJS">
		<script type="text/javascript">
			var onBridgeReady = function() {
				WeixinJSBridge.invoke('getBrandWCPayRequest', <?php echo $jsApiParameters;?>,
				function(res) {
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						location.replace("<?php echo $config['web_path']; ?>/mobile/home/userbalance");
					} else if (res.err_msg == "get_brand_wcpay_request:cancel") {
						location.replace("<?php echo $config['web_path']; ?>/pay/wxpay_web_url/payinfo/cancel");
					} else if (res.err_msg == "get_brand_wcpay_request:fail") {
						location.replace("<?php echo $config['web_path']; ?>/pay/wxpay_web_url/payinfo/fail");
					} else {
						location.replace("<?php echo $config['web_path']; ?>/pay/wxpay_web_url/payinfo/" + encodeURIComponent(res.err_msg));
					}
				});
			};
			if (document.addEventListener) {
				document.addEventListener("WeixinJSBridgeReady", onBridgeReady, true);
			} else {
				document.attachEvent("onWeixinJSBridgeReady", onBridgeReady);
			}
		</script>
	</div>
    </div>
</body>
</html>



