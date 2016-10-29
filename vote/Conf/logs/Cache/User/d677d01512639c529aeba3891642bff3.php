<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div class="content">
         
          <div class="cLineB">
             <h4 class="left">您正在修改【<?php echo ($userinfo["item"]); ?>】的信息<span class="FAQ"></span></h4>
              <div class="clr"></div>			 
              <a href="<?php echo U('Vote/eitem',array('token'=>$_GET['token'],'id'=>$_GET['id']));?>" class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="margin-top:-27px;margin-right:40px">返回选手列表</a>
			 
          </div>
     <div class="msgWrap bgfc">
        
		   
		   <table class="userinfoArea">
		   <tr>
			 <input type="hidden" id="itemid" size="30" class="msgtext" style="width:80%;" value="<?php echo ($userinfo["id"]); ?>">
			<div> 姓名：<input type="text" id="itemitem" name="itemitem" size="30" class="msgtext" style="width:70%;" value="<?php echo ($userinfo["item"]); ?>"></div>
			<div> 排序：<input type="text" id="itemrank" name="itemrank" size="30" class="msgtext" style="width:70%;" value="<?php echo ($userinfo["rank"]); ?>"></div>
			<div>票数：当前票数为：<?php echo ($userinfo["vcount"]); ?>	&nbsp;&nbsp;<input type="radio" name="countadd" checked="checked" id="countadd" value="up" value=""/><label style="display:inline" for="countadd"> 加票</label>
						<input type="radio" name="countadd"  id="countzz" value="down" /><label style = "display:inline" for="countzz">减票</label>
						<input type="text" id="itemvcount" value="0" name="itemvcount" size="30" class="msgtext" style="width:40%;" value="">
			</div>
			<div>取消关注失去票数：当前数量为：<?php echo ($userinfo["dcount"]); ?>	&nbsp;&nbsp;<input type="radio" name="dcountadd" checked="checked" id="dcountadd" value="up" value=""/><label style="display:inline" for="countadd"> 增加</label>
						<input type="radio" name="dcountadd"  id="dcountzz" value="down" /><label style = "display:inline" for="countzz">减少</label>
						<input type="text" id="itemdcount" value="0" name="itemdcount" size="30" class="msgtext" style="width:40%;" value="">
			</div>
			 <div>电话：<input type="text" id="itemtourl" name="itemtourl" size="30" class="msgtext" style="width:70%;" value="<?php echo ($userinfo["tourl"]); ?>"></div>
			 <div>简介：<br/><br/>
			 <textarea id="content1" name="itemintro" style="width: 70%; height: 300px; "><?php echo html_entity_decode(htmlspecialchars_decode($userinfo['intro'])); ?></textarea>
			</div><br/>
			<div> 照片：<input type="text" id="itemstartpicurl" name="itemstartpicurl" size="30" class="msgtext" style="width:50%;" value="<?php echo ($userinfo["startpicurl"]); ?>">
					<a href="#" onclick="upyunPicUpload('itemstartpicurl',700,400,'<?php echo ($token); ?>')" class="btn btn-primary btn_submit  J_ajax_submit_btn">上传</a> 
					<a href="#" onclick="viewImg('itemstartpicurl')">预览</a></div>
			   </tr>
			 
				<tr>
				<div style="align:left;text-align:left;">
			  <a href="javascript:;" onclick="thisedit(<?php echo ($userinfo["id"]); ?>)" class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="float:left">提交</a>
				</div>
				 </tr>
		   </table>
		 
		   </div>
		   
		  
		<div style="clear:both"></div>
	<script type="text/javascript">
	$(document).ready(function(){

		});
	function thisedit(id){
	var thisitem = $("#item_"+id);
	$("#itemid").val();
	$("#itemitem").val();
	$("#itemrank").val();
	$("#itemtourl").val();
	$("#content1").val();
	$("#itemstartpicurl").val();
	
			var id = $("#itemid").val();
			var item = $("#itemitem").val();
			var rank = $("#itemrank").val();
			var vcount = $("#itemvcount").val();
			var vtype  =$('input[name="countadd"]:checked').val();
			var dcount = $("#itemdcount").val();
			var dtype  =$('input[name="dcountadd"]:checked').val();
			var tourl = $("#itemtourl").val();
			var intro = $("#content1").val();
			var startpicurl = $("#itemstartpicurl").val();
			
			var submitData={
				id  : id,
				item : item,
				rank : rank,
				vcount : vcount,
				vtype : vtype,
				dcount : dcount,
				dtype : dtype,
				tourl : tourl,
				intro :intro,
				startpicurl : startpicurl
			};		
			$.post('index.php?g=User&m=Vote&a=eitem_vote', submitData, function(bakcdata) 
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
			
	function dooow(objsp) {
   var obj = {id:objsp}
   var statu = confirm("确定要删除该选项么?");
     if(statu){
        $.post("<?php echo U('Vote/del_tab');?>", obj,function(data) {
		parent.location="javascript:location.reload()";
		},"json");
}
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