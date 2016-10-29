<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>微信数字投票管理系统 - 微信投票系统源码,萌宝大赛投票源码,女神大赛投票源码,微信投票源码</title>
	<meta name="keywords" content="微信投票源码,萌宝大赛投票源码,女神大赛投票,微信投票系统" />
	<meta name="description" content="微信投票系统，又称微信投票管理系统，微信投票管理系统是一款可用于萌宝大赛投票、女神大赛投票、摄影大赛投票、宠物大赛投票的源码系统。" />
	<link href="<?php echo STATICS;?>/home/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo STATICS;?>/home/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo STATICS;?>/home/css/common.css" rel="stylesheet">
	<script type="text/javascript">
	if(navigator.appName == 'Microsoft Internet Explorer'){
		if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
			alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
		}
	}
	</script>
</head>
<body><style>
	@media screen and (max-width:767px){.login .panel.panel-default{width:90%; min-width:300px;}}
	@media screen and (min-width:768px){.login .panel.panel-default{width:70%;}}
	@media screen and (min-width:1200px){.login .panel.panel-default{width:50%;}}
</style>
<div class="login" style="background:#2ca3e9">
	<div class="logo">
		<a href="/" ></a>
	</div>
	<div class="clearfix" style="margin-bottom:4em;">
		<div class="panel panel-default container">
			<div class="panel-body">
				<form action="<?php echo U('Users/checklogin');?>" method="post" enctype="multipart/form-data" >
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="fa fa-user"></i></div>
						<input name="username" type="text" class="form-control input-lg" placeholder="请输入用户名登录">
					</div>
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="fa fa-unlock-alt"></i></div>
						<input name="password" type="password" class="form-control input-lg" placeholder="请输入登录密码">
					</div>
					<div class="form-group">
						<div class="pull-right">
						<input type="submit" name="submit" value="登录" class="btn btn-primary btn-lg" />
							<input name="token" value="4405cdbd" type="hidden" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="center-block footer" role="footer">
		<div class="text-center">
			<p><a href="http://tp.cdrbp.cn">微信数字投票【萌娃、摄影、微男/女神评选】</a> &nbsp;源码购买、投票系统包上线服务：&nbsp;<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=75943938&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:75943938:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a><script>
t="36164,28304,25552,20379,65306,60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25169,28304,30721,31038,21306,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></p>
		</div>
		<div class="text-center">
			</div>
	</div>
</div>
</body>
</html>