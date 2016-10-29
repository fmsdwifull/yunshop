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
					  
                    <th>回复类型</th>

                     <th>资源ID</th>
                    <th>添加时间</th>        
                    <th>管理</th>
				</tr>
        </thead>
        <tbody>				
        	<?php foreach($articlelist AS $v) { ?>
            <tr>
             
                <td><?php echo $v['id'];?></td>
            
                <td><?php if($v['table']=='text'){echo '文本';} if($v['table']=='news'){echo '图文';};?></td>
                <td><?php echo $v['rid']; ?></td>
                <td><?php echo date("Y-m-d H:i:s",$v['add_time']);?></td>
                <td class="action">
                <a href="javascript:window.parent.Del('<?php echo G_ADMIN_PATH.'/weixin/del_send_message/'.$v['id'];?>', '确认删除这条消息吗？');">删除</a>
				</td>
            </tr>
            <?php } ?>
        </tbody>
     </table>
     </form>
   <div class="btn_paixu">
  	<div>
         <button style="height:30px;padding:5px;cursor:pointer"><a href="<?php echo G_ADMIN_PATH; ?>/weixin/add_send_message">群发消息</a></button>
    </div>
  </div>
<div id="pages"><ul><li>共 <?php echo $total; ?> 条</li><?php echo $page->show('one','li'); ?></ul></div>
</div>

</body>
</html>