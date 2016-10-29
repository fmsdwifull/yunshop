<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>微信投票管理系统</title>
	<meta name="keywords" content="iMicms,微信第三方CMS,iMicms.com" />
	<meta name="description" content="（www.iMicms.com），简称iMicms，iMicms是一款落地式的微信公众平台管理系统，是国内最完善的移动网站及移动互联网技术解决方案。" />
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

<script src="<?php echo RES;?>/js/date/WdatePicker.js" type="text/javascript"></script>
<script src="<?php echo STATICS;?>/vote/common.js" type="text/javascript"></script>
<script src="<?php echo STATICS;?>/artDialog/jquery.artDialog.js?skin=default" type="text/javascript"></script>
<script src="<?php echo STATICS;?>/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<script src="<?php echo STATICS;?>/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo STATICS;?>/vote/switch.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.theme.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.structure.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/vote/switch.css" />
<?php if(($vo['type'] == 'img') OR ($type == 'img')): ?><input type="hidden" id="votetyp" value="img">
<?php else: ?>
<input type="hidden" id="votetyp" value="txt"><?php endif; ?>
<div class="content">
<div class="cLineB">
  <h4> <?php if($vo['type'] == 'img' OR ($type == 'img')): ?>图片<?php else: ?>文本<?php endif; ?>投票设置 </h4><a href="<?php echo U('Vote/index');?>" class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="margin-top:-27px">返回</a>
 </div>
<div class="msgWrap bgfc">
<form class="form" method="post" action=""   enctype="multipart/form-data">
<?php if($vo['id'] != ''): ?><input type="hidden" name="id" value="<?php echo ($vo['id']); ?>"><?php endif; ?>
<table class="userinfoArea" style=" margin:0;" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr>
<th width="83">关键词：</th>
<td width="1217"><input type="text" name="keyword" value="<?php if($vo['keyword'] == ''): ?>投票<?php else: echo ($vo["keyword"]); endif; ?>" class="px" style="width:550px;"><br><span class="red">只能写一个关键词</span></td>
</tr>
<tr>
<th width="83">投票标题：</th>
<td><input type="text" name="title" value="<?php echo ($vo["title"]); ?>" class="px" style="width:550px;"></td>
</tr>
<tr>
<th valign="top">投票简介：<br /><span style="color:red;font-weight:400;font-size:12px;">(显示在投票活动首页)</span></th>
<td valign="top"><textarea class="px" id="qtxinxi" name="qtxinxi" style="width: 550px; height: 270px; display:none ;"><?php echo html_entity_decode(htmlspecialchars_decode($vo['qtxinxi'])); ?></textarea>
</td>
</tr>
<!--<tr>
<th>投票图片：(PC)</th>
<td>
<?php if($reslist['picurl'] != ''): ?><img class="thumb_img" id="picurl_src" src="<?php echo ($reslist['picurl']); ?>" style="max-height:100px;"><?php endif; ?>
<input type="text" name="picurl" value="<?php echo ($vo["picurl"]); ?>" class="px" onclick="document.getElementById('picurl_src').src=this.value;" id="picurl" style="width:300px;">
<a href="#" onclick="upyunPicUpload('picurl',700,400,'<?php echo ($token); ?>')" class="btn btn-primary btn_submit  J_ajax_submit_btn">上传</a> <a href="#" onclick="viewImg('picurl')">预览</a>&nbsp;填写图片外链地址，大小为1600x430</td>
</tr>-->
<tr>
<th>投票图片：(WAP)<br /><span style="color:red;font-weight:400;font-size:12px;">（投票活动首页顶部图片）</span></th>
<td>
<?php if($reslist['wappicurl'] != ''): ?><img class="thumb_img" id="wappicurl_src" src="<?php echo ($reslist['wappicurl']); ?>" style="max-height:100px;"><?php endif; ?>
<input type="text" name="wappicurl" value="<?php echo ($vo["wappicurl"]); ?>" class="px" onclick="document.getElementById('picurl_src').src=this.value;" id="wappicurl" style="width:300px;">
<a href="#" onclick="upyunPicUpload('wappicurl',700,400,'<?php echo ($token); ?>')" class="btn btn-primary btn_submit  J_ajax_submit_btn">上传</a> <a href="#" onclick="viewImg('wappicurl')">预览</a>&nbsp;填写图片外链地址，大小为640X295</td>
</tr>
<tr>
<th>图片显示：</th>
<td><label>
<input type="radio" name="showpic" value="1" id="showpic2" <?php if($vo['showpic'] == 1){?> checked="checked" <?php }?> >
显示在投票页面</label>
<label>
<input name="showpic" type="radio" id="showpic1" value="0" <?php if($vo['showpic'] == 0){?> checked="checked"<?php }?>>
不显示在投票页面</label>
</td>
</tr>
<tr>
<th valign="top">投票说明：</th>
<td valign="top"><textarea class="px" id="content" name="info" style="width: 560px; height: 420px; display:none ;"><?php echo html_entity_decode(htmlspecialchars_decode($vo['info'])); ?></textarea>
</td>
</tr>
<tr>
<th valign="top">奖品说明：</th>
<td valign="top"><textarea class="px" id="content1" name="jiangpin" style="width: 550px; height: 270px; display:none ;"><?php echo html_entity_decode(htmlspecialchars_decode($vo['jiangpin'])); ?></textarea>
</td>
</tr>
<?php if($guanggao != ''): if(is_array($guanggao)): $i = 0; $__LIST__ = $guanggao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ivo): $mod = ($i % 2 );++$i;?><tr class="guang" id="guang_<?php echo ($ivo["id"]); ?>">
<th >广告图片：<br /><span style="color:red;font-weight:400;font-size:12px;">(显示在个人详情页面顶部图片)</span></th>
<td>
<input type='hidden' name="picurl_guanggao[id][]" value="<?php echo ($ivo["id"]); ?>"> 
<input type="text" name="picurl_guanggao[url][]" id="picurl_guanggao_<?php echo ($i+50); ?>" value="<?php echo ($ivo["ggurl"]); ?>" class="px" onclick="" style="width:300px;">
<a href="#" onclick="upyunPicUpload('picurl_guanggao_<?php echo ($i+50); ?>',700,400,'<?php echo ($token); ?>')" class="btn btn-primary btn_submit  J_ajax_submit_btn">上传</a> 
<a href="#" onclick="viewImg('picurl_guanggao_<?php echo ($i+50); ?>')">预览</a>
&nbsp;&nbsp;<a href="javascript:;" onclick="delgg(<?php echo ($ivo["id"]); ?>)">删除</a>&nbsp;填写图片外链地址，大小为640X295
</td>
</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
<tr class="guang">
<th >广告图片：<br /><span style="color:red;font-weight:400;font-size:12px;">(显示在个人详情页面顶部图片)</span></th>
<td>
<input type='hidden' name="picurl_guanggao[id][]"> 
<input type="text" name="picurl_guanggao[url][]" id="picurl_guanggao_1" value="<?php echo ($vo["picurl_guanggao"]); ?>" class="px" onclick="" style="width:300px;">
<a href="#" onclick="upyunPicUpload('picurl_guanggao_1',700,400,'<?php echo ($token); ?>')" class="btn btn-primary btn_submit  J_ajax_submit_btn">上传</a> 
<a href="#" onclick="viewImg('picurl_guanggao_1')">预览</a>
&nbsp;&nbsp;<a href="javascript:;" onclick="delguang(1)">删除</a>
&nbsp;&nbsp;<a href="javascript:;" id="addg2"  onclick="newguang(2)">添加</a>&nbsp;填写图片外链地址，大小为640X295
</td>
</tr>
<script type="text/javascript">
$(document).ready(function(){
});
//addguang
function newguang(id){
var newid=id+1;
 //  <input type="text" name="picurl_guanggao[]" value="<?php echo ($vo["picurl_guanggao"]); ?>" class="px" onclick="" id="picurl_guanggao" style="width:300px;">
//<a href="#" onclick="upyunPicUpload('picurl_guanggao',700,400,'<?php echo ($token); ?>')" class="btn btn-primary btn_submit  J_ajax_submit_btn">上传</a> 
//<a href="#" onclick="viewImg('picurl_guanggao')">预览</a>
//&nbsp;&nbsp;<a href="javascript:;" onclick="delguang(1)">删除</a>
//&nbsp;&nbsp;<a href="javascript:;" id="add2"  onclick="newguang(2)">添加</a>
var str ="<tr class='guang'><th>广告图片：</th><td>";
	str+="<input type='hidden' name='picurl_guanggao[id][]' value=''>"
	str+= "<input type=\"text\" name=\"picurl_guanggao[url][]\" id=\"picurl_guanggao_"+id+"\" value='' class='px' onclick='' style=\"width:300px;\">";
    str+=" <a href=\"#\" onclick=\"upyunPicUpload('picurl_guanggao_"+id+"',700,400,'<?php echo ($token); ?>')\" class='btn btn-primary btn_submit  J_ajax_submit_btn'>上传</a>";
	str+=" <a href=\"#\" onclick=\"viewImg('picurl_guanggao_"+id+"')\">预览</a>";
	str+="　<a href=\"javascript:;\" onclick=\"delguang("+id+")\">删除</a>";
	str+="　<a href=\"javascript:;\" id=\"addg"+newid+"\"  onclick=\"newguang("+newid+")\">添加</a>";
	str+="</td></tr>";
	  $('#addg' + id).hide();
	$(".guang:last").after(str);
	}
//delguang
function delguang(id){
  if(1 != id){
   $("#picurl_guanggao_"+id).parent().parent().remove();
 }
 }
function delgg(id){
   var obj = {id:id}
        $.post("<?php echo U('Vote/del_gg');?>", obj,
            function(data) {
            },
        "json");
 $("#guang_"+id).remove();
}
//add intro
function addintr(index){
		$("#add_"+index+"").dialog({
		     modal: true,             // 创建模式对话框
			autoOpen:true,
			width:"600",
			height:"350",
			title : '选项简介',
			buttons: { "确定": function() { $(this).dialog("close");}},
			open : function(event, ui) {
				// 打开Dialog后创建编辑器
				$("#add_"+index+"").hide();
                 addeditor("add_"+index+"");
			},
			beforeClose : function(event, ui) {
				// 关闭Dialog前移除编辑器
                
				$("#add_intr_"+index+"").val($("#add_"+index+"").val());
				KindEditor.remove("add_"+index+"");
			}
		});
}
	//add new sub
 function newsub(next){
 var votetyp = $('#votetyp').val();
 var str=addnewsub(next,votetyp);
     nowindex= next-1;
	 nowid = "#div_add_del_"+nowindex;
  $('#add' + next).hide();
  $(nowid).after(str);
 
 }
 //del sub
 function delsub(index){
  if(1 != index){
   $("#div_add_del_"+index).remove();
 }
 }
 
function addeditor(textid){
textid="#"+textid;
var editor;
editor = KindEditor.create(textid, {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : true,
uploadJson : '/wevote/index.php?g=User&m=Upyun&a=kindedtiropic',
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
}
//
function addnewsub(index,votetyp){
var newindex= index+1;
var str= "<tbody id='div_add_del_"+index+"' name='div_add_del'>";
    str+="<tr>";
	str+="<input type='hidden' name='add[id][]' readonly='readonly' disabled='disabled'  value='' style='width:20px;' >";
	str+="<td width='120'>";
	str+="<input type='text' name='add[item][]' value='' placeholder='请填写选项标题' class='px' style=width:120px;'>";
	str+="&nbsp&nbsp<a href='javascript:;' id='item"+index+"' name='' onclick='addintr("+index+")'>添加选项简介</a>";
    str+="</td>"; 
	str+="<td>";
    str+="<input type='text' name='add[rank][]' value='' style='width:20px;' class='px'>";
	str+="</td>";
    str+="<td>";
    str+="<input type='text' name='add[vcount][]' value='' style='width:20px;' class='px'>";
	str+="</td>";
	str+="<td style='display:none'><textarea  id='add_intr_"+index+"' name='add[intr][]' style='width: 700px; height: 120px;display:none'></textarea></td>";
    str+="<td style='display:none'><textarea  id='add_"+index+"' name='add[intr1][]' style='width: 700px; height: 120px;display:none'></textarea></td>";
	if('img'==votetyp)
	 {
	   str += "<td width='200'>";
       str += "   <img class='thumb_img' id='startpicurl_"+index+"_src' src='' style='max-height:100px;display: none;'>"; 
	   str += "	  <input type='text' name='add[startpicurl][]' placeholder='图片[http://]' value='' class='px'";
	   str += "   onclick=\"document.getElementById('startpicurl_"+index+"_src').src=this.value;\" id='startpicurl_"+index+"' style='width:130px;'>";
	   str += "   <a href='###' onclick=\"upyunPicUpload('startpicurl_"+index+"',700,400,'<?php echo ($token); ?>')\" class='btn btn-primary btn_submit  J_ajax_submit_btn'>上传</a>";
	   str += "   <a href='###' onclick='viewImg('startpicurl_"+index+"')'>预览</a>";
	   str += "</td>";
       str += "<td width='100'><input type='text' name='add[tourl][]' value='' class='px' style='width:100px;'></td>";
	 }
     str += "<td width='50' class='norightborder'><a href='javascript:;' onclick='delsub("+index+")'>删除</a> ";
	 str += "<a href='javascript:;' id='add"+newindex+"' onclick='newsub("+newindex+")'>添加</a></td>";
	 str += "/tr";
	 str += "</tbody>";
  return str;
}

  </script>
<tr >
<th>单选/多选：<br /><span style="color:red;font-weight:400;font-size:12px;">（意思是只能帮单个人投 还是可以帮多人投）</span></th>
<td>
  <p style="width: 120px; float: left; display: block; line-height: 32px; height: 32px;">
    <select name="cknums" class="input-medium">
      <option value="1" <?php if($vo['cknums'] == 1): ?>selected<?php endif; ?>>单选</option>
      <option value="2" <?php if($vo['cknums'] == 2): ?>selected<?php endif; ?>>多选</option>
    </select>
</p>
     
</td>
</tr>
<th width="83">投票选择：</th>
	<td>
  <div class="list">   
     <div class="fun_title">   
        <span rel="" <?php if($vo['votelimit'] == 1) {?> class="ad_on" title="点击关闭"<?php } else {?>class="ad_off" title="点击开启"<?php }?>></span><p> (想要每天可以投一票请点开启)</p>
     </div>   
   </div>  
  </td>
<input type="hidden" name="votelimit" id="votelimit" value='<?php echo ($vo["votelimit"]); ?>'>
<tr>
<th>截至时间：</th>
<td><input type="text" class="px" id="statdate" value="<?php if($vo['statdate'] != ''): echo (date("Y-m-d H:i",$vo["statdate"])); endif; ?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" name="statdate">
到
<input type="text" class="px" id="enddate" value="<?php if($vo['enddate'] != ''): echo (date("Y-m-d H:i",$vo["enddate"])); endif; ?>" name="enddate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"></td>
</tr>
<tr>
<th>&nbsp;</th>
<td><button type="submit" name="button1" class="btn btn-primary btn_submit  J_ajax_submit_btn">保存</button>
<a href="<?php echo U('Vote/index');?>" class="btn">取消</a>
</td>
</tr>
</tbody>
</table>

  </div>
        </div></form>
<script type="text/javascript">
function delrow(obj, tbody,objid) {
  $$(tbody).removeChild(obj.parentNode.parentNode);
   var obj = {id:objid}
        $.post("<?php echo U('Vote/del_tab');?>", obj,
            function(data) {
            },
        "json");
}
</script>
<div style="display:none">
<link href="tpl/static/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
</div>