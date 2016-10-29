<?php defined('G_IN_ADMIN')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/uploadify/api-uploadify.js" type="text/javascript"></script> 
<style>
tr{height:40px;line-height:40px}
</style>
</head>
<body>
<div class="header lr10">
	<?php echo $this->headerment();?>
</div>
<div class="bk10"></div>
<div class="table-list lr10">
<!--start-->
<form name="myform" action="" method="post">
  <table width="100%" cellspacing="0">
  	<tr>
		<td width="220" align="right">触发词：</td>
		<td><input type="text" name="keyword"  class="input-text wid200" value="<?php echo $api_info['keyword'] ?>"></td>
	</tr>


     <tr>
			<td width="220" align="right">回复内容：</td>
			<td><textarea name="value"  id="text_v" class="wid300" style="height:80px;" disabled='true' ><?php echo $api_info['text']?></textarea><span><font color="#0c0">※ </font>回复文本请先点击 回复文本，回复图文则点击选择</span>
            </td>

	</tr>	
<tr>
		<td></td>			<td><a onclick='selectm("text")' style="cursor:pointer">回复文本</a>&nbsp;&nbsp; <a onclick='selectm("news")' id="resnews" style="cursor:pointer">回复图文</a></td>
				</tr>
  	
    <tr>
        	<td width="220" align="right"></td>
        	<input type='hidden' name='resp_type' id='resp_type' value=''/> 
             <input type='hidden' name='resp_rid' id='resp_rid' value=''/> 
            <td><input type="submit" class="button" name="dosubmit"  value=" 提交 " ></td>
   </tr>
</table>
</form>

</div><!--table-list end-->

<script>
function selectm(t){ 
    msgType = t ; 
    $("#resp_type").val( t ) ; 
    if(t == 'text'){
        $("#text_v").val('') ;  
        $("#text_v").attr('disabled',false) ;   return false ; 
    }
    $("#text_v").attr('disabled',true) ;
}
//弹出一个iframe层
$('#resnews').click(function(){
	layer.open({
	        type: 2,
	        title: '选择图文',
	        maxmin: true,
	        shadeClose: true, //点击遮罩关闭层
	        area : ['800px' , '520px'],
	        content: "{-url:option/news_select-}"
	    });

});


		

</script>
</body>
</html> 