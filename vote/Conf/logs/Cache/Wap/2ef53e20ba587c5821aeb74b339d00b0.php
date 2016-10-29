<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>我是<?php echo ($data["id"]); ?>号<?php echo ($data["item"]); ?>正在参加<?php echo ($vote["title"]); ?>活动呢，赶紧给我投一票吧</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<script src="<?php echo STATICS;?>/vote/wap/jquery.js"></script>
	<script src="<?php echo STATICS;?>/jquery-ui.js" type="text/javascript"></script>
	<script src="<?php echo STATICS;?>/vote/jquery.slides.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.theme.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.structure.css" />
	<link href="<?php echo STATICS;?>/vote/showindex.css" rel="stylesheet" media>
	<link href="<?php echo STATICS;?>/vote/voteshow.css" rel="stylesheet" media>
	<link href="<?php echo STATICS;?>/vote/wap/css/style.css" rel="stylesheet"  media="all">
		
	 <style>
      .cl{clear:both;}
      body{font-family:'Microsoft YaHei';}
	 .cc li{
	   text-align:center;
	 }
	 .cc img{
	 margin-right:auto;
	 margin-left:auto;
    
	 }
	.zhanshib .xinfob{
	}
	 </style>
	</head>
<body style="background-color:#fff;"><img src="<?php echo ($data["startpicurl"]); ?>" style="width:200px;height:200px;display: none">
    <div id="home-slides">
					<?php if($guanggao != ''): if(is_array($guanggao)): $i = 0; $__LIST__ = $guanggao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ivo): $mod = ($i % 2 );++$i;?><p><a href="javascript:;"><img style="width:100%;height:100%" src="<?php echo ($ivo["ggurl"]); ?>" alt="" /></a></p><?php endforeach; endif; else: echo "" ;endif; endif; ?>

   </div>
   <div class="wrap">
	<div class="main_wrap">
		<div class="news"></div>

		<div class="zhanshib">
            <div class="xuanshou">
           <dl><dt><?php echo ($data["item"]); ?></dt><dd>选手姓名</dd></dl>
            <dl><dt><?php echo ($data["id"]); ?></dt><dd>该选手编号</dd></dl>
                <dl><dt><?php echo ($data["vcount"]); ?></dt><dd>当前票数</dd></dl>
				 <dl><dt><?php echo ($data["pm"]); ?></dt><dd>当前排名</dd></dl>
            </div>
           <div class="cl"></div>
            <div class="tupian"><img style="" src="<?php echo ($data["startpicurl"]); ?>"></div>
            <div class="cl"></div>
            <ul>
                <li id="tou">为Ta投票</li><li id="bao">我要报名</li>
            </ul>
            <div class="cl"></div><h3 style="background:#2ebbc5;width: 96.5%;margin: 0 auto;margin-top: 18px;">选手资料</h3>
            <div class="xuanyan"><?php  echo html_entity_decode(htmlspecialchars_decode($data['intro']));?></div>
<!--			<ul class="cc">
			<li><img style="" src="<?php echo ($data["startpicurl"]); ?>"><p class="infob"><div class="xinfob"><b>姓名：</b><?php echo ($data["item"]); ?><br><b>编号：</b><?php echo ($data["id"]); ?><br><b>选手票数：</b><i class="vote_1"><?php echo ($data["vcount"]); ?></i><br><b>参赛宣言：</b><i class="vote_1"><?php  echo html_entity_decode(htmlspecialchars_decode($data['intro']));?></i><br></div>  </p></li>
			</ul>-->
		</div>


		<h3 style="background:#2ebbc5;width: 96%;margin: 0 auto;">活动介绍</h3>
		<div class="jiangxiang">
						<?php  echo html_entity_decode(htmlspecialchars_decode($vote['info'])); ?>
		</div>
	</div>
</div>

    <div class="tanchuang" style="position:fixed;width:85%;height:30%;background:#fff;left:10%;top:30%;font-size:16px;box-shadow:0 0 8px #aaa;">
      <div class="tc_1" style="width:100%;height:24%;background:#fe785a;color:#fff;text-align:center;line-height:37px;float:left;position:relative;">请关注公众号后投票<span class="guanbi" style="width:15%;height:100%;display:block;cursor:pointer;text-align:center;line-height:37px;float:right;background:#fcf9b5;font-size:18px;color:#fe785a;">X</span></div>
        <div class="tc_2"style="width:100%;height:80%;background:#fff;color:#000;text-align:center;border-bottom:1px dashed #eee;font-size:14px;float:left;position:relative;padding-top:12px;"><?php if($info['qrimg'] != ''): ?><img height="60%" src="<?php echo ($info["qrimg"]); ?>"><br/><?php else: endif; ?>关注公众号"<span style="color:#fe785a"><?php echo ($gzh["gongzhong"]); ?></span>"后<br />直接在公众号内回复：<span style="color:#fe785a"><?php echo ($data["id"]); ?></span></div>
        <div class="tc_3" style="width:100%;height:27%;background:#fff;color:#000;text-align:center;text-align:center;float:left;position:relative;"><a style="width:40%;height:80%;background:#2ebbc5;color:#fff;text-align:center;display:block;margin:2px auto;line-height:26px;" href="<?php echo ($gzh["email"]); ?>">一键关注</a></div>
    </div>


        <div class="tanchuang2" style="position:fixed;width:85%;height:30%;background:#fff;left:10%;top:30%;font-size:16px;box-shadow:0 0 8px #aaa;">
      <div class="tc_1" style="width:100%;height:24%;background:#fe785a;color:#fff;text-align:center;line-height:37px;float:left;position:relative;">请关注公众号后报名<span class="guanbi" style="width:15%;height:100%;display:block;cursor:pointer;text-align:center;line-height:37px;float:right;background:#fcf9b5;font-size:18px;color:#fe785a;">X</span></div>
        <div class="tc_2"style="width:100%;height:90%;background:#fff;color:#000;text-align:center;border-bottom:1px dashed #eee;font-size:14px;float:left;position:relative;padding-top:5px;"><?php if($info['qrimg'] != ''): ?><img height="60%" src="<?php echo ($info["qrimg"]); ?>"><br/><?php else: endif; ?>关注公众号"<span style="color:#fe785a"><?php echo ($gzh["gongzhong"]); ?></span>"后<br />直接点击自定义菜单的“我要报名”<br />或者在公众号内回复：<span style="color:#fe785a">报名</span></div>
        <div class="tc_3" style="width:100%;height:27%;background:#fff;color:#000;text-align:center;text-align:center;float:left;position:relative;"><a style="width:40%;height:80%;background:#2ebbc5;color:#fff;text-align:center;display:block;margin:2px auto;line-height:26px;" href="<?php echo ($gzh["email"]); ?>">一键关注</a></div>
    </div>

<script>
    $(document).ready(function () {
        $(".tanchuang").hide();
        $(".tanchuang2").hide();

        $("#tou").click(function () {
            $(".tanchuang").show();
        });

        $("#bao").click(function () {
            $(".tanchuang2").show();
        });

        $(".guanbi").click(function () {
            $(".tanchuang").hide();
            $(".tanchuang2").hide();
        });
	//var wecha_id="<?php echo ($wecha_id); ?>";
	//if(''==wecha_id||1==1){
	//$("#tishi").dialog(
	// {
	// modal: false,
	// });
	//}
	



//huandeng
   var slidesCount = $('#home-slides').children('p').length;
    if(slidesCount > 1){
    $('#home-slides').slidesjs({
        width: 320,
        height: 148,
        navigation: false,
        play: {
            interval: 3000,
            auto: true
        },
        callback: {
            loaded: function(number) {
                var slidesCount = $('#home-slides .slidesjs-control').children().size(),
                    statusWidth = (parseFloat(1 / slidesCount) * 100) + '%';
                $('#home-slides > .slidesjs-pagination > li').width(statusWidth);
            }
        }
    });
	}
	else{
		
	
	}
});
</script>

<!--<div class="skin skin-line" style="display:none">
	<section>
	 <div id="tishi" title="请关注公众号后投票" style="display: none">
        <div> 请关注微信公众号"<?php echo ($gzh["gongzhong"]); ?>" 
		      <a href="<?php echo ($gzh["email"]); ?>">  <input type="button" id="copyit" value="一键关注"></a>

		</div>
		</br>
		<div class="red">给我投票 请在公众号内回复：<?php echo ($data["id"]); ?></div>
    </div>	
	</section>
	</div>-->

		<div id="mcover" onClick="">
		<img src="<?php echo STATICS;?>/vote/guide.png"></div>
		<div style="text-align:center;margin-top:30px;margin-bottom:20px;display:none"><a id="tishi" onClick="document.getElementById('mcover').style.display='block';">
		<input type="button" id="copyit" style="width:100px;text-align:center;margin-left:auto;height:30px;line-height:28px;" value="分享给朋友">
		</a></div>
	<script type="text/javascript">
//for 
var img_url="<?php echo ($data["startpicurl"]); ?>";
var url = "<?php echo C('site_url'); echo U('Vote/show',array('token'=>$token,'id'=>$mid,'tid'=>$tid));?>";
var content = "我是<?php echo ($data["id"]); ?>号<?php echo ($data["item"]); ?>正参加\"<?php echo ($vote["title"]); ?>\"活动呢，赶紧给我投一票吧";
var title = "我是<?php echo ($data["id"]); ?>号<?php echo ($data["item"]); ?>正在参加<?php echo ($vote["title"]); ?>活动呢，赶紧给我投一票吧,";



	   var imgUrl = "<?php echo ($data["startpicurl"]); ?>";  //注意必须是绝对路径 
       var lineLink = "<?php echo C('site_url'); echo U('Vote/show',array('token'=>$token,'id'=>$mid,'tid'=>$tid));?>";   //同样，必须是绝对路径
       var descContent = "我是<?php echo ($data["id"]); ?>号<?php echo ($data["item"]); ?>正参加\"<?php echo ($vote["title"]); ?>\"活动呢，赶紧给我投一票吧"; //分享给朋友或朋友圈时的文字简介
       var shareTitle = "我是<?php echo ($data["id"]); ?>号<?php echo ($data["item"]); ?>正在参加<?php echo ($vote["title"]); ?>活动呢，赶紧给我投一票吧";  //分享title
       var appid = ''; //apiID，可留空
        
       function shareFriend() {
           WeixinJSBridge.invoke('sendAppMessage',{
               "appid": appid,
               "img_url": imgUrl,
               "img_width": "200",
               "img_height": "200",
               "link": lineLink,
               "desc": descContent,
               "title": shareTitle
           }, function(res) {
               //_report('send_msg', res.err_msg);
           })
       }
       function shareTimeline() {
           WeixinJSBridge.invoke('shareTimeline',{
               "img_url": imgUrl,
               "img_width": "200",
               "img_height": "200",
               "link": lineLink,
               "desc": descContent,
               "title": descContent
           }, function(res) {
                  //_report('timeline', res.err_msg);
           });
       }
       function shareWeibo() {
           WeixinJSBridge.invoke('shareWeibo',{
               "content": descContent,
               "url": lineLink,
           }, function(res) {
               //_report('weibo', res.err_msg);
           });
       }
       // 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
       document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
           // 发送给好友
           WeixinJSBridge.on('menu:share:appmessage', function(argv){
               shareFriend();
           });
           // 分享到朋友圈
           WeixinJSBridge.on('menu:share:timeline', function(argv){
               shareTimeline();
           });
           // 分享到微博
           WeixinJSBridge.on('menu:share:weibo', function(argv){
               shareWeibo();
           });
       }, false);
</script>
<script type="text/javascript">function lp(){
	//document.getElementById('mcover').style.display='block';
}
    </script>


     ﻿


     <div style="width:100%;height:50px;position:fixed;bottom:0;background:#fd564a;font-family:'Microsoft YaHei';color:#fff;z-index:1000;left: 0;">
        <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/index',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/shouye.png" /></dt><dd>首 页</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/player',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/saishi.png" /></dt><dd>参赛选手</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/share',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/paihang.png" /></dt><dd>排行榜</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo ($info["email"]); ?>"><dt><img width="28" height="28" src="images/guanzhu.png" /></dt><dd>关注我们</dd></a></dl>
     </div>

<div id="gz_footer">版权所有 Copyright 2015 <?php echo ($info["gongzhong"]); ?> </div>

</body></html>