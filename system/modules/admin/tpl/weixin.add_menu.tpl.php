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
iframe{ font-size:36px;}
.con-tab{ margin:10px; color:#444}
.con-tab #tab-i{ margin-left:20px; overflow:hidden; height:27px; _height:28px; }
.con-tab #tab-i li{
	float:left;background:#eaeef4;
	padding:0 8px;border:1px solid #dce3ed;
	height:25px;_height:26px;line-height:26px;
	margin-right:5px;cursor: pointer; position:relative;z-index:0;
}
.con-tab div.con-tabv{
	clear:both; border:1px solid #dce3ed;
	width:100%;
	margin-top:-1px; padding-top:30px;
	background-color:#fff; position:relative; z-index:1;}

#tab-i li.on{ background-color:#fff;color:#444; font-weight:bold; border-bottom:1px solid #fff;  position:relative;z-index:2;}

table th{ border-bottom:1px solid #eee; font-size:12px; font-weight:100; text-align:right; width:200px;}
table td{ padding-left:10px;}
.con-tabv tr{ text-align:left}
input.button{ display:inline-block}
</style>



</head>
<body>
<div class="header lr10">
	<?php echo $this->headerment();?>
</div>
<div class="bk10"></div>

<div name='con-tabv' class="con-tabv">
 <form action="" id="form" method="post">
 <table width="100%" class="table_form">
 <tbody>
      <tr>
        <th width="200">上级菜单：</th>
        <td>
		<select name="pid" class="wid150">
        <option value="0">≡ 作为一级菜单 ≡</option>
       <?php foreach($categorys AS $v) { ?>
        <option value="<?php echo $v['id'] ?>"><?php echo $v['name']?></option>
       <?php }?>
        </select>
        </td>
      </tr>     
      <tr>
        <th>菜单名称：</th>
        <td><input type="text" name="name" class="input-text wid140" onKeyUp="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\_]/g,'')">
        	<span><font color="#0c0">※ </font>请输入菜单名称</span>
		</td>
      </tr>
	<tr>
        <th width="200">菜单类型：</th>
        <td>
    <select name="type" class="wid150">
        <option value="click">点击</option>
        <option value="view">链接</option>
        </select>
        </td>
      </tr>  
       <tr>
        <th>触发反应：</th>
        <td><input type="text" name="value" class="input-text wid140" >
          <span><font color="#0c0">※ </font>链接类型请填入URL地址</span>
    </td>
      </tr>
	
</tbody>
</table>
 <div class="table-button lr10">
  <input type="hidden" name="dosubmit" value="1">
        <input type="button" value=" 提交 "  onClick="checkform();" class="button">
      </form>
   </div>
  </div>
    




</body>
<script type="text/javascript">
  function checkform(){
  var form=document.getElementById('form');
  var error=null; 
  if(form.elements[1].value==''){error='请输入菜单名称!';}
  if(error!=null){window.parent.message(error,8,2);return false;}
    form.submit();  
  }
</script>
</html> 