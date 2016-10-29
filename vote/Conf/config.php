<?php
/**
 *项目公共配置
 *@package Jhcms
 *@author Jhcms
 **/
return array(
	'LOAD_EXT_CONFIG' 		=> 'db,info,email,safe,upfile,cache,route,app,alipay,sms,rippleos_key',		
	'APP_AUTOLOAD_PATH'     =>'@.ORG',
	'OUTPUT_ENCODE'         =>  true, 			//页面压缩输出
	'PAGE_NUM'				=> 15,
	/*Cookie配置*/
	'COOKIE_PATH'           => '/',     		// Cookie路径
    'COOKIE_PREFIX'         => '',      		// Cookie前缀 避免冲突
	/*定义模版标签*/
	'TMPL_L_DELIM'   		=>'{31cms:',			//模板引擎普通标签开始标记
	'TMPL_R_DELIM'			=>'}',				//模板引擎普通标签结束标记
	'YZM'			=>'0',				//验证码开启开关，0为关闭，1位开启
	'SHXX'			=>'0',				//审核后发送审核通过消息到微信，0为关闭，1位开启（条件：认证号+单个审核通过+微信内报名用户）
);
?>