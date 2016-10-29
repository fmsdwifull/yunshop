<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>我是<?php echo ($data["item"]); ?>号<?php echo ($data["item"]); ?>，来给我投一票吧</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<script src="http://libs.baidu.com/jquery/1.9.1/jquery.js"></script>
	<script src="<?php echo STATICS;?>/jquery-ui.js" type="text/javascript"></script>
	<script src="<?php echo STATICS;?>/vote/jquery.zclip.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.theme.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.structure.css" />
	<link href="<?php echo STATICS;?>/vote/index.css" rel="stylesheet" media>
	<link href="<?php echo STATICS;?>/vote/voteshow.css" rel="stylesheet" media>
	</head>
<body>
	<header>
		<p class="name">我是<?php echo ($data["item"]); ?><strong><?php echo ($data["item"]); ?></strong></p>
	</header>
	<section>
	<a href="" ><img src="<?php echo ($data["startpicurl"]); ?>" alt=""></a>
	</section>
	<section>
	<div class="info">
			<?php  echo html_entity_decode(htmlspecialchars_decode($data['intro'])) ?>
	</div>
	 <div id="tishi" title="请关注公众号后投票" style="display: none">
        <div> 请关注微信公众号"<?php echo ($gzh["gongzhong;"]); ?>" 
		        <input type="text" value="<?php echo ($gzh["gongzhong;"]); ?>">
				<input type="hidden" id="copyit" value="复制">
				<input type="hidden" id="gzh" value="ssss">
		</div>
		<div>关注公众号后，请回复，投票+编号 例如 投票+001</div>
		<div class="red">给我投票 请在公众号内回复：投票+<?php echo ($data["id"]); ?></div>
    </div>	
	</section>
		<div style="width: 100%; text-align: center;margin-top:10px;">
		<!-- <a onclick="document.getElementById('mcover').style.display='block';">
		<img src="http://loupan.jyfw.cn/images/Baoming/xiantao/clsqyx/images/btn_2.png" 
		style="width:120px"></a> -->
		</div>
		<div class="skin skin-line">
		<?php
 if($vote['enddate'] < time()){ if($vote_record == 1){ ?>
                    您已投过票，投票项为: <p style="color: coral;"><?php if(is_array($hasitems)): $i = 0; $__LIST__ = $hasitems;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo['item']); ?>,<?php endforeach; endif; else: echo "" ;endif; ?></p>
                   <br/> 活动已经过结束<br/>
         <?php  }else{ echo "活动已经过结束"; } }elseif($vote['statdate'] > time()){ echo "活动还没正式开始"; }else{ ?>
         <input class="pxbtn" name="sub" id="sub" value="提交选票" type="hidden">
        <?php
 } ?>
         <br/><br/>
		 </div>
	<section>
	<div class="info">
	<?php  echo html_entity_decode(htmlspecialchars_decode($vote['qtxinxi'])) ?>
	</div>
	</section>
		<div id="mcover" onClick="">
		<img src="./images/tp/wx/img/guide.png"></div>
	<script type="text/javascript">
	$(document).ready(function(){	
	var wecha_id="<?php echo ($wecha_id); ?>";
	if(''==wecha_id||1==1){
	$("#tishi").dialog(
	 {
	 modal: true,
	 }
	);
	}
	$('#copyit').zclip({
        path:'<?php echo STATICS;?>/vote/ZeroClipboard.swf',
        copy:function(){return $('#gzh').val();}
    });
  $(".pxbtn").bind("click",function(){
     var self = $(this);
    var chid = "<?php echo ($id); ?>";
    var wecha_id = "<?php echo ($wecha_id); ?>";
    var token  = "<?php echo ($token); ?>";
    var tid = "<?php echo ($tid); ?>";
    if(wecha_id == ''){
        alert("请关注后再重新打开此页面。");
        return;
    }
        var submitData={
            wecha_id : wecha_id,
            tid      : tid,
            chid     : chid,
            token    : token,
            action   : "add_vote"
        };
        $.post('index.php?g=Wap&m=Vote&a=add_vote&token=<?php echo ($token); ?>&wecha_id=<?php echo ($wecha_id); ?>', submitData, function(bakcdata) {
          var obj=eval('('+bakcdata+')');
          if(obj.success == 1){
           alert('您已投票成功,您的剩余投票次数为'+obj.vleft+'次');
          setTimeout("window.location.href='index.php?g=Wap&m=Vote&a=index&token=<?php echo ($token); ?>&wecha_id=<?php echo ($wecha_id); ?>&id=<?php echo ($id); ?>'",2000);
              return
          }else{
            alert('您的投票次数已经用完');
            return false;
          }

        });


  });

});

//for 
var img_url="<?php echo ($vote["picurl"]); ?>";
var url = "<?php echo C('site_url'); echo U('Vote/index',array('token'=>$token,'id'=>$tid));?>";
var content = "我是<?php echo ($data["item"]); echo ($data["item"]); ?>正参加\"<?php echo ($vote["title"]); ?>\"活动呢，赶紧给我投一票吧";
var title = "我是<?php echo ($data["item"]); echo ($data["item"]); ?>";
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
<script type="text/javascript">function lp(){
	//document.getElementById('mcover').style.display='block';
}
    </script><!--[if gte IE 7]><style type="text/css">
	body{box-shadow:0 0 5px 2px #E4E4E4;background:#fff;border-radius:3px 3px 3px 3px;padding:5px 0;margin-bottom:10px;}
     body span{display:block;width:80%;height:20px;line-height:20px;margin:0 auto;margin-bottom:15px;margin-top:10px;
				text-align:center;background-color:#F9CAB4;background-image: -moz-linear-gradient(center bottom , #ce9479 0%, #dbb29f 100%);
				border-radius: 5px;box-shadow: 0 1px 0 #e5b097, 0 1px 2px rgba(9, 105, 181, 0.5);color: #FD605F;display: block;font-size: 18px;
				font-weight:bold;padding: 10px 20px;text-align: center;text-decoration: none;text-shadow: 3px 3px rgba(225, 200, 189, 0.8);
			}

/* ????? */
body .sm{padding:10px;}
body .sm .f14{font-size:14px;}
body .sm p{font-size:12px;color:#666;line-height:24px;}

/* ???? */
body p.name{padding:10px;font-size:20px;text-align:center}/*???????*/
body p.name strong{color:#FD605F}
body p.xuanyan{text-indent:28px;color:#444;padding:0 10px 10px ;}/*???????*/
body p.pic {margin:0 auto;padding:10px;padding-bottom:0;text-align:center;}/*??????*/
body p.pic img{width:100%;float:left;margin:0 auto;margin-bottom:10px;}
body p.zhichi{text-align:center;line-height:30px;}/*????????*/
body p.zhichi b{color:#CD181E}

/* ??????? */
body p.lp{text-indent:24px;padding:0 10px 10px ;}
body p.lp img{width:auto;}

body .search{width:75%;margin:0 auto;height:30px;padding:10px;text-align:center;margin-top:-20px;padding-bottom:20px;}
body .search input[type="text"] {width:72%;height:28px;border:1px solid #ccc;-webkit-appearance:none;
								-moz-appearance:none;-webkit-border-radius: 6em;-moz-border-radius: 3px;border-radius:3px 3px 3px 3px;text-indent:5px;}
body .search input[type="submit"] {width:45px;height:30px;background:#ECECEC;cursor:pointer;-webkit-appearance:none;-moz-appearance:none;}
/* ????б? */
body.list{width:96%;overflow:hidden;}
body.list ul{padding-left:4%;}
body.list ul li{width:30%;margin-right:3%;margin-bottom:8px;float:left;text-align:center;font-size:12px;}
body.list ul li img{width:100%}
body.list ul li strong{font-size:14px;font-weight:bold;color:#EA5334}
body.list ul li b{color:#F7376A}

body img{width:100%;}
body input{width:auto;margin:0 auto;}

body.list ul li img{float:left;}
body.list .come{width:100%;height:20px;line-height:24px;text-align:center;white-space:nowrap;text-overflow:ellipsis;
overflow:hidden;-webkit-text-overflow:ellipsis;}
</style><![endif]-->
</body></html>