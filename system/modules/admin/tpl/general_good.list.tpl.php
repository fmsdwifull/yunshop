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
<style>
body{ background-color:#fff}
tr{ text-align:center}
</style>
</head>
<body>
<div class="header lr10">
	<?php echo $this->headerment();?>
</div>

<div class="bk10"></div>


<div class="header-data lr10">
<form action="#" method="post">
 添加时间: <input name="posttime1" type="text" id="posttime1" class="input-text posttime"  readonly="readonly" /> -  
 		  <input name="posttime2" type="text" id="posttime2" class="input-text posttime"  readonly="readonly" />
<script type="text/javascript">
	date = new Date();
	Calendar.setup({
		inputField     :    "posttime1",
		ifFormat       :    "%Y-%m-%d %H:%M:%S",
		showsTime      :    true,
		timeFormat     :    "24"
	});
	Calendar.setup({
		inputField     :    "posttime2",
		ifFormat       :    "%Y-%m-%d %H:%M:%S",
		showsTime      :    true,
		timeFormat     :    "24"
	});		
</script>

<select name="sotype">
<option value="title">商品标题</option>
<option value="id">商品id</option>
<option value="cateid">栏目id</option>
<option value="catename">栏目名称</option>
<option value="brandid">品牌id</option>
<option value="brandname">品牌名称</option>
</select>
<input type="text" name="sosotext" class="input-text wid100"/>
<input class="button" type="submit" name="sososubmit" value="搜索">
</form>
</div>
<div class="bk10"></div>
<form action="#" method="post" name="myform">
<div class="table-list lr10">
	<table width="100%" cellspacing="0">
     	<thead>
        		<tr>
                	<th width="5%">排序</th>
                    <th width="5%">ID</th>                          
                    <th width="25%">商品标题</th>  
                    <th width="10%">所属栏目</th>   
                    <th width="10%">商品价格/元</th>
                    <th width="10%">库存</th>
                    <th width="10%">人气/推荐</th>
                    <th width="10%">添加时间</th>
                    <th width="10%">管理</th>
				</tr>
        </thead>
        <tbody>				
        	<?php foreach($shoplist as $v) { ?>
            <tr>
				<td align='center'><input name='listorders[<?php echo $v['id']; ?>]' type='text' size='3' value='<?php echo $v['listorder']; ?>' class='input-text-c'></td>  
                <td><?php echo $v['id'];?></td>
                <td><span><?php echo _strcut($v['title'],30);?></span>
                <td><?php echo $this->categorys[$v['cateid']]['name']; ?></td>
				<td><span><?php echo $v['money'];?></span></td>
				<td><span><?php echo $v['inventory'];?></span></td>
				<td>
					<?php if($v['renqi']) :?>
						<span style="color:red;">【是】</span>
					<?php else :?>
						<span>【否】</span>
					<?php endif;?>
					<?php if($v['pos']) :?>
						<span style="color:red;">【是】</span>
					<?php else :?>
						<span>【否】</span>
					<?php endif;?>
				</td>
                <td><span><?php echo date('Y-m-d H:i:s',$v['addtime']);?></span></td>
                <td class="action">
					[<a href="<?php echo G_ADMIN_PATH; ?>/content/general_goods_edit/<?php echo $v['id'];?>">修改</a>]
					[<a href="javascript:;"  shopid="<?php echo $v['id'];?>" class="del_good">删除</a>]
				</td>
            </tr>
            <?php } ?>
        </tbody>
	</table>

</div>
</form>
	
   <div class="btn_paixu">
  	<div style="width:80px; text-align:center;">
          <input type="button" class="button" value=" 排序 " onclick="myform.action='<?php echo G_MODULE_PATH; ?>/content/general_good_listorder/dosubmit'; myform.submit();"/>
    </div>
  </div>
    	<div id="pages"><ul><li>共 <?php echo $total; ?> 条</li><?php echo $page->show('one','li'); ?></ul></div>
</div>


<script>
$(function(){
	$("a.del_good").click(function(){
		var id = $(this).attr("shopid");
		var str = "<?php echo G_ADMIN_PATH; ?>/content/general_goods_delete/"+id;
		var o = confirm("确认删除该商品的所有期数.不可恢复");
		if(o){
			window.parent.btn_map(str);
		}	
	});
});
</script>
</body>
</html> 