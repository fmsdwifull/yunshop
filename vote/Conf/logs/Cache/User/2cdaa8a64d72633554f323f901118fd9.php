<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if($info['title'] == ''): ?>微信数字投票系统<?php else: echo ($info["title"]); endif; ?></title>
	<meta name="keywords" content="31cms,微信第三方CMS,31cms.com" />
	<meta name="description" content="（www.31cms.com），简称31cms，31cms是一款落地式的微信公众平台管理系统，是国内最完善的移动网站及移动互联网技术解决方案。" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
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

<script>
var editor;
KindEditor.ready(function(K) {
editor = K.create('#content2', {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : true,
uploadJson : '/index.php?g=User&m=Upyun&a=kindedtiropic',
items : [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
],
afterBlur: function(){this.sync();}
});
});
</script>
<script>
var editor;
KindEditor.ready(function(K) {
editor = K.create('#content1', {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : true,
uploadJson : '/index.php?g=User&m=Upyun&a=kindedtiropic',
items : [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
],
afterBlur: function(){this.sync();}
});
});
</script>
<script>
var editor;
KindEditor.ready(function(K) {
editor = K.create('#content', {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : true,
uploadJson : '/index.php?g=User&m=Upyun&a=kindedtiropic',
items :[
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
],
afterBlur: function(){this.sync();}
});
});
</script>
<script>
var editor;
KindEditor.ready(function(K) {
editor = K.create('#intro', {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : true,
uploadJson : '/index.php?g=User&m=Upyun&a=kindedtiropic',
items : [
'source','undo','clearhtml','hr',
'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
'insertunorderedlist', '|', 'emoticons','fontname', 'fontsize','forecolor','hilitecolor','bold','image','link', 'unlink','baidumap','lineheight','table','anchor','preview','print','template','code','cut', 'music', 'video','map'],
afterBlur: function(){this.sync();}
});
});
</script>
<script>
var editor;
KindEditor.ready(function(K) {
editor = K.create('#qtxinxi', {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : true,
uploadJson : '/index.php?g=User&m=Upyun&a=kindedtiropic',
items : [
'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'],
afterBlur: function(){this.sync();}
});
});
</script>


<style>
.content {
 background:none; margin-left:30px; margin-top:20px; border:none; margin-bottom:30px;
}
</style>
</head>

<body>


<div class="content">
         
          <div class="cLineB">
             <h4 class="left">您已创建微信投票活动 (<?php echo ($count); ?>) 个<span class="FAQ"></span></h4>
              <div class="clr"></div>
          </div>
          <div class="cLine">
            <div class="pageNavigator left">
            <?php if($ok == 1): ?><a href=""  title="发起文字投票" class="btn btn-primary btn_submit  J_ajax_submit_btn" style="display:none"><img src="<?php echo RES;?>/images/text.png" class="vm">发起文字投票</a>　
			<a href="" title="发起图片投票" class="btn btn-primary btn_submit  J_ajax_submit_btn"><img src="<?php echo RES;?>/images/pic.png" class="vm">发起图片投票</a>
			<a href="<?php echo U('./Home/Index/help',array('token'=>$_SESSION['token']));?>"   title="API接口" class="btn btn-primary btn_submit  J_ajax_submit_btn">API接口</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Diymen/index',array('token'=>$_SESSION['token']));?>"   title="底部菜单" class="btn btn-primary btn_submit  J_ajax_submit_btn">底部菜单</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Vote/gongzhong',array('id'=>$_SESSION['id']));?>"   title="信息绑定" class="btn btn-primary btn_submit  J_ajax_submit_btn">信息绑定</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Vote/check',array('id'=>$_SESSION['id']));?>"   title="审核信息" class="btn btn-primary btn_submit  J_ajax_submit_btn">审核信息</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Areply/index',array('id'=>$_SESSION['id'],'token'=>$_SESSION['token']));?>"   title="关注回复" class="btn btn-primary btn_submit  J_ajax_submit_btn">关注回复</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Index/useredit');?>"   title="修改密码" class="btn btn-primary btn_submit  J_ajax_submit_btn">修改密码</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Home/Index/logout');?>"   title="退出登陆" class="btn btn-primary btn_submit  J_ajax_submit_btn">退出登陆</a>&nbsp&nbsp&nbsp
            <?php else: ?>
            <a href="<?php echo U('Vote/add',array('type'=>'text'));?>"  title="发起文字投票" class="btn btn-primary btn_submit  J_ajax_submit_btn" style="display:none"><img src="<?php echo RES;?>/images/text.png" class="vm">发起文字投票</a>
			<a href="<?php echo U('Vote/add',array('type'=>'img'));?>"   title="发起图片投票" class="btn btn-primary btn_submit  J_ajax_submit_btn"><img src="<?php echo RES;?>/images/pic.png" class="vm">发起图片投票</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('./Home/Index/help',array('token'=>$_SESSION['token']));?>"   title="API接口" class="btn btn-primary btn_submit  J_ajax_submit_btn">API接口</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Diymen/index',array('token'=>$_SESSION['token']));?>"   title="底部菜单" class="btn btn-primary btn_submit  J_ajax_submit_btn">底部菜单</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Vote/gongzhong',array('id'=>$_SESSION['uid']));?>"   title="信息绑定" class="btn btn-primary btn_submit  J_ajax_submit_btn">信息绑定</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Vote/check',array('id'=>$_SESSION['uid']));?>"   title="审核信息" class="btn btn-primary btn_submit  J_ajax_submit_btn">审核信息</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Areply/index',array('id'=>$_SESSION['id'],'token'=>$_SESSION['token']));?>"   title="关注回复" class="btn btn-primary btn_submit  J_ajax_submit_btn">关注回复</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Index/useredit');?>"   title="修改密码" class="btn btn-primary btn_submit  J_ajax_submit_btn">修改密码</a>&nbsp&nbsp&nbsp
			<a href="<?php echo U('Home/Index/logout');?>"   title="退出登陆" class="btn btn-primary btn_submit  J_ajax_submit_btn">退出登陆</a><?php endif; ?>
            </div>
			 <div class="pageNavigator right">
			 
			<a href="<?php echo U('User/Vote/update');?>"  style="" title="退出登陆" class="btn btn-primary btn_submit  J_ajax_submit_btn">查看更新</a>&nbsp&nbsp&nbsp
			 </div>
            <div class="clr"></div>
          </div>
          <div class="msgWrap">
		  
        <iframe src="http://bbs.gope.cn/thread-2829-1-1.html" style="width:100%;height:100%;min-height:1000px"></iframe>
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