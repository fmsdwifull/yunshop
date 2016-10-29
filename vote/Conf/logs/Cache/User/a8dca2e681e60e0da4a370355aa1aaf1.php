<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if($info['title'] == ''): ?>CDRBP微信数字投票系统<?php else: echo ($info["title"]); ?>在线报名<?php endif; ?></title>
	<meta name="keywords" content="CDRBP,微信第三方CMS,www.cdrbp.cn" />
	<meta name="description" content="CDRBP微信投票系统是一款落地式的微信公众平台管理系统，是国内最完善的移动网站及移动互联网技术解决方案。" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
<script>var SITEURL='';</script>
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/style_2_common.css?BPm" />
<link href="<?php echo RES;?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo RES;?>/css/stylet.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATICS;?>/simpleboot/themes/flat/theme.min.css" rel="stylesheet">

<script src="<?php echo RES;?>/js/common.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/global.js"></script>
  <link rel="stylesheet" href="<?php echo RES;?>/css/cymain.css" />
  <link rel="stylesheet" href="<?php echo STATICS;?>/kindeditor/themes/default/default.css" />
<script src="<?php echo STATICS;?>/upyun.js"></script>

<script src="<?php echo STATICS;?>/artDialog/jquery.artDialog.js?skin=default"></script>

<script src="<?php echo STATICS;?>/artDialog/plugins/iframeTools.js"></script>

<link rel="stylesheet" href="<?php echo STATICS;?>/kindeditor/plugins/code/prettify.css" />



<script src="<?php echo STATICS;?>/kindeditor/kindeditor.js" type="text/javascript"></script>



<script src="<?php echo STATICS;?>/kindeditor/lang/zh_CN.js" type="text/javascript"></script>



<script src="<?php echo STATICS;?>/kindeditor/plugins/code/prettify.js" type="text/javascript"></script>
<script type="text/javascript">
    // 对浏览器的UserAgent进行正则匹配，不含有微信独有标识的则为其他浏览器
    var useragent = navigator.userAgent;
    if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
        // 这里警告框会阻塞当前页面继续加载
        alert('已禁止本次访问：您必须使用微信内置浏览器访问本页面！');
        // 以下代码是用javascript强行关闭当前页面
        var opened = window.open('about:blank', '_self');
        opened.opener = null;
        opened.close();
    }
</script>

</head>

<body>

    
 

 <link href="<?php echo RES;?>/css/style.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo STATICS;?>/jquery-ui.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.theme.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.structure.css" />
	<style>
.img{
  width:80px;
  height:80px;
}
.img img{
	width:100%;
	display:block;
}
.countadd{
margin-top:-10px;
}
label{
display:inline;
}
.linkp{
list-style-type:none;
margin-right:30px;
text-align:right;
color:red;
letter-spacing:5px;
}
.linkp a{
color:#000;
}
.linkp li a{
letter-spacing:2px;
}
.linkp .total{
float:right;
}
</style>

		</div>

<div class="content">
         
          <div class="cLineB">
             <h5  style="text-align:center"><?php echo ($info["title"]); ?>在线报名<span class="FAQ"></span></h4>
              <div class="clr"></div>			 
             
			 
          </div>
     <div class="msgWrap bgfc">
        
		   
		   <table class="userinfoArea">
		   <tr>
			<div> 姓名：<input type="text" id="additem"  size="30" class="msgtext" style="width:70%;"></div>
			 <div>电话：<input type="text" id="addtourl"  size="30" class="msgtext" style="width:70%;"></div>
			<div>封面照片：<input type="text" id="addstartpicurl"  size="30" class="msgtext" style="width:30%;margin-top: 8px;" >
					<a href="#" onclick="upyunWapPicUpload('addstartpicurl',100,100,'')" class="btn btn-primary btn_submit  J_ajax_submit_btn" style="">上传</a> 
					</div>
			 <div>简介：<br/><br/>
			 <textarea id="introx" name="addintro" style="width: 87%; height: 100px; "></textarea>
			</div>
			   </tr>
			 
				<tr>
				<div style="align:left;text-align:left;"><br/>
			  <a href="javascript:;" onclick="additem()" class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="float:left;margin-right:10px">提交</a>
			  <a href="<?php echo ($myurl); ?>/index.php?g=Wap&m=Vote&a=index&token=<?php echo $_GET['token']; ?>&tid=<?php echo $_GET['tid']; ?>"  class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="float:left">回到活动首页</a>
				</div>
				 </tr>
		   </table>
		 
		   </div>
		   
		  
		<div style="clear:both"></div>
	<script type="text/javascript">
	$(document).ready(function(){

		});
	function additem(){
			var item = $("#additem").val();
			var tourl = $("#addtourl").val();
			var intro = $("#introx").val();
			var startpicurl = $("#addstartpicurl").val();
			
			var submitData={
				vid  : <?php echo ($info["id"]); ?>,
				item : item,
				tourl : tourl,
				intro : intro,
				startpicurl : startpicurl
			};
			$.post('index.php?g=User&m=Bm&a=add', submitData, function(bakcdata) 
			{
					var obj=eval('('+bakcdata+')');
						if(obj.success == 1)
							{
								alert(obj.msg);
								parent.location="javascript:location.reload()";
								return 0;
							}
						else
							{
								alert(obj.msg);
								return false;
							}  
				});
			$(this).dialog('close');
			
	}
	
	
	
 </script>
   </div> 
          <div class="cLine">
            <div class="pageNavigator right">
                 <div class="pages"></div>
              </div>
            <div class="clr"></div>
          </div>
  </div>
<div style="display:none">
<link href="tpl/static/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
</div>

</body>
</html>