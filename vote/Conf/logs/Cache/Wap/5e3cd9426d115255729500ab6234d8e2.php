<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML><html lang="en-US">
 <head>
   <meta charset="UTF-8">
   <title><?php echo ($vote["title"]); ?> - <?php echo ($info["gongzhong"]); ?></title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="black">
   <meta name="format-detection" content="telephone=no">
   <meta name="description" content="<?php echo ($vote["title"]); ?>">
   <link href="<?php echo STATICS;?>/vote/index.css" rel="stylesheet"  media="all">
   <link href="<?php echo RES;?>/css/style.css" rel="stylesheet"  media="all">
   <link href="<?php echo STATICS;?>/vote/wap/css/style.css" rel="stylesheet"  media="all">
   <link href="<?php echo STATICS;?>/vote/index/mobile-base.000.min.css" rel="stylesheet"  media="all">
   <link href="<?php echo STATICS;?>/vote/index/jquery.fancybox.css" rel="stylesheet"  media="all">
   <script src="<?php echo STATICS;?>/vote/wap/jquery.js" type="text/javascript"></script>
	<script src="<?php echo STATICS;?>/vote/index/jquery.fancybox.pack.js" type="text/javascript"></script>
   <link href="<?php echo STATICS;?>/vote/index/mobile-base.000.min.css" rel="stylesheet"  media="all">
   <link href="<?php echo STATICS;?>/vote/index/jquery.fancybox.css" rel="stylesheet"  media="all">
   <script src="<?php echo STATICS;?>/vote/wap/jquery.js" type="text/javascript"></script>
	<script src="<?php echo STATICS;?>/vote/index/jquery.fancybox.pack.js" type="text/javascript"></script>
   <style>
	.title{
		margin-top: 0px; margin-bottom: 0px; 
		white-space: normal; max-width: 100%; min-height: 1.5em; 
		padding: 5px 3px; line-height: 2em; color: rgb(255, 255, 255); font-family: 微软雅黑; 
		border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom-left-radius: 0px; 
		text-align: center; background-color: #f9cbb4; word-wrap: break-word !important; box-sizing: border-box !important;
		font-size:16px; !important; font-weight:bold !important;
		}
	.box{
		white-space: normal; max-width: 100%; color: rgb(62, 62, 62); margin: 0px; padding: 5px; 
		line-height: 24px; border: 3px dashed rgb(243, 173, 13); font-family: 微软雅黑; border-image-source: none; 
		background-color: rgb(255, 255, 255); word-wrap: break-word !important; box-sizing: border-box !important;
		<strong style="max-width: 100%; word-wrap: break-word !important; box-sizing: border-box !important;">
}
.loadmore{
	height: 40px;
	line-height: 30px;
	color: #999;
	text-align: center;
	display: block;
	clear: both;
	}
.loadmore .more a{color: #fff;
font-weight: bold;
font-size: 14px;
background: #FF6666;
border-radius: 5px;
display: block;
line-height: 30px;
text-align: center;}
.fancybox-margin{margin-right:17px;}
.pp{
	position: relative;
	float: left;
	width: 145px;
	height: 145px;
	margin: 0 10px 8px 0;
	}
.tit{
		background-color: rgba(0,0,0,0.25);
		width: 100%;
		position: absolute;
		bottom: 3px;
		font-weight: bold;
		color:rgba(255,255,255,0.6);
	}
.tit b{
color:red;
}
#outer {width:100%;}
#tab {width:100%;height:40px;padding:0;margin-top:3px;}
#tab dd {float:left;color:#fff;height:40px;	cursor:pointer;	line-height:40px;width:20%;font-family:"微软雅黑";font-size:13px;padding-left:9%;margin:0 2% 0 2%;}
#tab dd.current {color:#fbe80b;background:#00ccff;}
#content {border-top-width:0;}
#content dl {line-height:25px;display:none;}
</style>
<script language="javascript" type="text/javascript">
        function sizeImg(obj,width,height)
        {
            if((obj.width/width)>(obj.height/height)){obj.width=width;}
            else{obj.height=height;}
        }
        
        function sizeContainerImg(txtContainerID)
        {
            var container = document.getElementById(txtContainerID);
            var imgs = container.getElementsByTagName("img");
            for(var i=0;i<imgs.length;i++)
            {
                if(container.clientWidth<imgs[i].width)
                {
                    imgs[i].width = container.clientWidth - 2;
                }
            }
        }
    </script>
	
	<script type="text/javascript">
        if (localStorage.pagecount) {
            localStorage.pagecount = Number(localStorage.pagecount) + 1;
        } else {
            localStorage.pagecount = 1;
        }

        $(document).ready(function () {
            $("#lll").text(parseInt($("#lll").text()) + parseInt(localStorage.pagecount));
            $("#fxl").text(parseInt($("#fxl").text()) + Math.round(parseInt(localStorage.pagecount)/4));
        });
</script>

</head>
<body style="background-color:#eee;">
<header>
			<?php if(($vote['wappicurl'] != '') AND ($vote['showpic'] == 1) ): ?><img src="<?php echo ($vote["wappicurl"]); ?>" title="<?php echo ($vote["title"]); ?>"><?php endif; ?></header>
			
<div class="wrap">
	<div class="main_wrap">
		
<!-- html代码begin -->
<div id="outer">

    <div class="tpjianjie">
        <?php  echo html_entity_decode(htmlspecialchars_decode($vote['qtxinxi'])) ?>
	
    </div>
	
	<div class="tj">
 
  <table>
	<tr>
	<td><img src="images/cyxs.png" width="60px"><span class="cyxs"></span><br>参与选手<br><?php if($vote['cyxs'] != ''): echo ($vote["cyxs"]); else: ?>0<?php endif; ?></a></td>
	<td><img src="images/ljtp.png" width="60px"><span class="cyxs"></span><br>累计投票<br><?php if($vote['ljtp'] != ''): echo ($vote["ljtp"]); else: ?>0<?php endif; ?></a></td>
	<td><img src="images/fwl.png" width="60px"><span class="cyxs"></span><br>访问量<br><?php if($vote['lll'] != ''): echo ($vote["lll"]); else: ?>0<?php endif; ?></a></td>
	</tr>
  </table>
  </div>
<hr class="xt">
    <dl id="tab">
	<dd class="current"  style=" background:url(images/nav_bg1.png) no-repeat #44b6c9;"><?php if($vote['zdyname'] != ''): echo ($vote["zdyname"]); else: ?>参赛选手<?php endif; ?></dd>
    <dd style="background:url(images/nav_bg2.png) no-repeat #f59f46;">投票说明</dd>
    <dd style="background:url(images/nav_bg3.png) no-repeat #ff4b3f;">活动奖品</dd>
    </dl>
    <div id="content">
        <dl style="display:block;">
        <div class="zhanshi">


			<div class="xinfo">
				<form id="search_mini_form" action="" method="post"  class="search-mini">
    <label for="search-input">&nbsp;</label>
    <input type="search" name="search" id="key" value="<?php echo ($search); ?>" placeholder="请输入查找编号或姓名" maxlength="128" width="140px" class="search-input">
    <button type="submit" title="搜索" class="button"><span><span>搜索</span></span></button>
	</form>
		</div>
		<ul class="cc">
			<?php if(is_array($vote_item)): $i = 0; $__LIST__ = $vote_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li><a href="<?php echo C('site_url');?>/index.php?g=Wap&m=Vote&a=show&token=<?php echo ($token); ?>&id=<?php echo ($li["id"]); ?>&wecha_id=<?php echo ($wecha_id); ?>&tid=<?php echo ($id); ?>"><img src="<?php echo ($li["startpicurl"]); ?>" style="width:100%; height:187px;"></a>
			<p class="info"><?php echo ($li["item"]); ?>   <br>选手编号：<i class="vote_1"><?php echo ($li["id"]); ?></i><br>票数：<i class="vote_1"><?php echo ($li["vcount"]); ?></i><br></p>
			<p class="vote"><a href="<?php echo C('site_url');?>/index.php?g=Wap&m=Vote&a=show&token=<?php echo ($token); ?>&id=<?php echo ($li["id"]); ?>&wecha_id=<?php echo ($wecha_id); ?>&tid=<?php echo ($id); ?>">详细资料</a></p></li><?php endforeach; endif; else: echo "" ;endif; ?>
		  </ul>
		</div>
		<div id='loadmore' class="loadmore" ><p class="more"><a class=" draginner">上拉自动加载更多</a></p></div>
				 <div class="draginner1 fblu" align="center" style="display:none;font-size:16px;width:100%;height:14px;clear: both;">
				上拉自动加载更多
		</div>
        </dl>
        <dl>
		 <div class="jiangxiang">
		<?php  echo html_entity_decode(htmlspecialchars_decode($vote['info'])) ?>
		</div>
		</dl>
		<dl>
		<div class="jiangxiang">
		<?php  echo html_entity_decode(htmlspecialchars_decode($vote['jiangpin'])) ?>
		</div>
		
		
            
        </dl>
       
    </div>
</div>
<!-- html代码end -->

       



<script>
	$(function(){
		window.onload = function()
		{
			var $dd = $('#tab dd');
			var $dl = $('#content dl');
						
			$dd.mouseover(function(){
				var $this = $(this);
				var $t = $this.index();
				$dd.removeClass();
				$this.addClass('current');
				$dl.css('display','none');
				$dl.eq($t).css('display', 'block');
			})
		}
	});
</script>
		
	</div>
</div>

		
		<input name="page" id="page" type="hidden" value="1" />
		<input name="flash" id="flash" type="hidden" value="1" />
		<input name="rankpage" id="rankpage" type="hidden" value="1" />
		<input name="rankflash" id="rankflash" type="hidden" value="1" />
		<script type="text/javascript">
            $("#page").val(1);
			var draginner=$('.draginner')[0];
			 $("#rankpage").val(1);
            function loadData(){
                var page = $("#page").val();
				var newpage = parseInt(page);
                totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 				
				if ($(document).height() <= totalheight) { 
                    draginner.innerHTML="正在加载请稍候";
						var flash = $("#flash").val();
						if(flash=="2"){
							return;
						}else{
							$("#flash").val("2");
						}
                    $.get("index.php?g=Wap&m=Vote&a=add_item&tid=<?php echo ($vote["id"]); ?>&key=<?php echo ($search); ?>&page="+newpage,
                        function(data){
                            if(data == ''){
                                 draginner.innerHTML="没有更多数据了";
                            }else{
                                $('.cc').append(data)
							   $("#page").val(newpage+1);
							    draginner.innerHTML="上拉自动加载更多";
                            }
							$("#flash").val("1");
                    });
            }
			}
			            $(window).scroll( function() { 
                loadData();
            }); 
            function loadRank(){
                var page = $("#rankpage").val();
				var newpage = parseInt(page);
						var flash = $("#rankflash").val();
						if(flash=="2"){
							return;
						}else{
							$("#rankflash").val("2");
						}
                    $.get("index.php?g=Wap&m=Vote&a=add_rank&tid=<?php echo ($vote["id"]); ?>&key=<?php echo ($search); ?>&page="+newpage,
                        function(data){
                            if(data == ''){
                                $("#loadmore").text("没有更多数据了");
                            }else{
                                $('.user-panel').append(data)
							   $("#rankpage").val(newpage+1);
                            }
							$("#rankflash").val("1");
                    });
            } 
          </script>

  </section>
 <script>
/*	$("#loadmore").click(function() {
				loadData();
}); */
</script> 
<script type="text/javascript">

var img_url="<?php echo ($vote["picurl"]); ?>";
var url = "<?php echo C('site_url'); echo U('Vote/index',array('token'=>$token,'tid'=>$id));?>";
var content = "<?php echo ($info["tel"]); ?>\n<?php echo ($vote["title"]); ?>";
var title = "<?php echo ($vote["title"]); ?>";
var imgUrl = img_url;

var lineLink = url;

var descContent = content;

var shareTitle = title;

var appid = '';


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

"title": shareTitle

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


﻿


     <div style="width:100%;height:50px;position:fixed;bottom:0;background:#fd564a;font-family:'Microsoft YaHei';color:#fff;z-index:1000;left: 0;">
        <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/index',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/shouye.png" /></dt><dd>首 页</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/player',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/saishi.png" /></dt><dd>参赛选手</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/share',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/paihang.png" /></dt><dd>排行榜</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo ($info["email"]); ?>"><dt><img width="28" height="28" src="images/guanzhu.png" /></dt><dd>关注我们</dd></a></dl>
     </div>

<div id="gz_footer">版权所有 Copyright 2015 <?php echo ($info["gongzhong"]); ?> </div>

</body>
</html>