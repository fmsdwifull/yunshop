<?php defined('G_IN_ADMIN')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar-blue.css" type="text/css"> 
<script type="text/javascript" charset="utf-8" src="<?php echo G_PLUGIN_PATH; ?>/calendar/calendar.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/layerV/layer.js" type="text/javascript"></script> 
<style>
body{ background-color:#fff}
.header-data{
	border: 1px solid #FFBE7A;
	zoom: 1;
	background: #FFFCED;
	padding: 8px 10px;
	line-height: 20px;
}
.table-list  tr {
	text-align:center;
}

</style>
</head>
<body>
<div class="header lr10">
	<?php echo $this->headerment();?>
</div>
<div class="bk10"></div>

<div class="bk10"></div>
<form action="#" method="post" name="myform">
<div class="table-list lr10">
	 <table width="100%" cellspacing="0">
     	<thead>
        		<tr>
					
					<th>ID</th>  
					<th>菜单名</th>  
                    <th>触发类型</th>
                    <th>触发反应</th>   
                    <th>管理</th>
				</tr>
        </thead>
        <tbody>				
        	<?php foreach($menulist AS $v) { ?>
            <tr>
             
                <td><?php echo $v['id'];?></td>
		   <td><?php echo $v['name'];?></td>
                <td><?php echo $v['type'];?></td>
                <td><?php echo $v['value']; ?></td>
                <td class="action">
                <a href="<?php echo G_ADMIN_PATH; ?>/weixin/edit_menu/<?php echo $v['id'];?>">修改</a>
                <span class='span_fenge lr5'>|</span>    
                <a href="javascript:window.parent.Del('<?php echo G_ADMIN_PATH.'/weixin/del_menu/'.$v['id'];?>', '确认删除此菜单吗？');">删除</a>
				</td>
            </tr>
            <?php foreach($v['son'] AS $c){?>
                <tr>
               
                  <td><?php echo $c['id'];?></td>
         <td ><span style="margin-left:50px">└─<?php echo $c['name'];?></span></td>
                  <td><?php echo $c['type'];?></td>
                  <td><?php echo $c['value']; ?></td>
                  <td class="action">
                  <a href="<?php echo G_ADMIN_PATH; ?>/weixin/edit_menu/<?php echo $c['id'];?>">修改</a>
                  <span class='span_fenge lr5'>|</span>    
                  <a href="javascript:window.parent.Del('<?php echo G_ADMIN_PATH.'/weixin/del_menu/'.$c['id'];?>', '确认删除此菜单吗？');">删除</a>
          </td>
              </tr>
            <?php }?>
            <?php } ?>
        </tbody>
     </table>
<div style="border:1px solid #ccc;padding:5px; width:100px;cursor:pointer;margin:10px 10px;text-align:center" onclick="syncmenu();">生成自定义菜单</div>
     </form>
 

</div>

</body>
<script type="text/javascript">
/*同步菜单*/
function syncmenu(){
//询问框
var index=layer.confirm('您确定要同步菜单？', {
    btn: ['是','否'], //按钮
    shade: [0.5, '#000']  //不显示遮罩
}, function(){
  layer.close(index);
  var load=layer.load();
  $.post("<?php echo G_ADMIN_PATH.'/weixin/menuSync';?>",{},function(data){
     layer.close(load) ;
    if(data.errcode=="0"){
         layer.msg('发布成功', {icon: 1});
    }else{
      layer.msg(data.errmsg, {icon: 5});
    }
  },"json");
 
}, function(){
    layer.msg('不发布了', {shift: 6});
});
}
</script>
</html>