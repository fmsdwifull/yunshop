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
		<td width="220" align="right">登录邮箱：</td>
		<td><input type="text" name="user" value="<?php echo $web['user']; ?>"  class="input-text wid200"></td>
	</tr>
	 <tr>
			<td width="220" align="right">名称：</td>
			<td><input type="text" value="<?php echo $web['username']; ?>" name="username" class="input-text wid200"></td>
	</tr>
	<tr>
	<td width="220" align="right"></td>
	<td ><img src="<?php echo G_UPLOAD_PATH.'/'.$web['avatar'] ?>" /></td>

	</tr>
    <tr>
		<td width="220" align="right">头像：</td>
		<td>

           	<input type="text" id="imagetext" value="<?php echo $web['avatar']; ?>" name="fileimage" class="input-text wid300">
			<input type="button" class="button"
             onClick="GetUploadify('<?php echo WEB_PATH; ?>','uploadify','LOGO上传','image','banner',1,500000,'imagetext')" 
             value="上传LOGO"/>
			图片大小：105*63
        </td>
	</tr>
  	
	<tr>
			<td width="220" align="right">原始ID：</td>
			<td><input type="text" value="<?php echo $web['ghid']; ?>" name="ghid" class="input-text wid200"></td>
	</tr>
     <tr>
			<td width="220" align="right">微信号：</td>
			<td><input type="text" value="<?php echo $web['nick']; ?>" name="nick" class="input-text wid300"></td>
	</tr>
     <tr>
			<td width="220" align="right">AppID(应用ID)：</td>
			<td><input name="appid" class="input-text wid200"  value="<?php echo $web['appid']; ?>" />
            </td>
	</tr>	

     <tr>
			<td width="220" align="right">AppSecret(应用密钥)：</td>
			<td><input name="appsecret" class="input-text wid200"  value="<?php echo $web['appsecret']; ?>" />
            </td>
	</tr>	
    <tr>
        	<td width="220" align="right"></td>
            <td><input type="submit" class="button" name="dosubmit"  value=" 提交 " ></td>
   </tr>
</table>
</form>

</div><!--table-list end-->

<script>
	
</script>
</body>
</html> 