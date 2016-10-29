<?php defined('G_IN_ADMIN')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/style.css" type="text/css">
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

<div class="bk10"></div>

<div class="bk10"></div>
<form action="#" method="post" name="myform">
<div class="table-list lr10">
	 <table width="100%" cellspacing="0">
     	<thead>
        		<tr>
			<th>选择</th>
					<th>ID</th>  
					<th>图文标题</th>  
                    <th>摘要</th>
                    <th>添加时间</th>        
                   
				</tr>
        </thead>
        <tbody>				
        	<?php foreach($articlelist AS $v) { ?>
            <tr>
             <td><input type="radio" name="xuanze" class="xuanze" value="<?php echo $v['id']; ?>"></td>
                <td><?php echo $v['id'];?></td>
				
                
                <td><?php echo $v['title']; ?></td>
                <td><?php echo _strcut($v['intro'],0,25);?></td>
                <td><?php echo date("Y-m-d H:i:s",$v['add_time']);?></td>
                
            </tr>
            <?php } ?>
        </tbody>
     </table>
     <div style="padding:5px;border:1px solid #ccc;width:60px;text-align:center;cursor:pointer;margin:10px 0 0 10px;" id="xuanzetuwen">确定</div>
     </form>
  

</div>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name);
var id=0;
$('.xuanze').click(function(){
    id=$(this).val();
});
    //给父页面传值
    $('#xuanzetuwen').on('click', function(){
      
        if(id==0){
            alert('请选择图文');
            return;
        }
        parent.$('#text_v').val('news#'+id);
        parent.$('#resp_rid').val(id);
        parent.layer.close(index);
        return false;
        
    });
</script>
</body>
</html>