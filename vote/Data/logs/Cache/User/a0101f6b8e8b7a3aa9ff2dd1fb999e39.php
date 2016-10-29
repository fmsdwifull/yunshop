<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>我是<?php echo ($data["id"]); ?>号<?php echo ($data["item"]); ?>正在参加<?php echo ($vote["title"]); ?>活动呢，赶紧给我投一票吧</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<script src="<?php echo STATICS;?>/vote/wap/jquery.js"></script>
	<script src="<?php echo STATICS;?>/jquery-ui.js" type="text/javascript"></script>
	<script src="<?php echo STATICS;?>/vote/jquery.slides.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.theme.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/jquery-ui.structure.css" />
	<link href="<?php echo STATICS;?>/vote/showindex.css" rel="stylesheet" media>
	<link href="<?php echo STATICS;?>/vote/voteshow.css" rel="stylesheet" media>
	<link href="<?php echo STATICS;?>/vote/wap/css/style.css" rel="stylesheet"  media="all">
		
	 <style>
      .cl{clear:both;}
      body{font-family:'Microsoft YaHei';}

      table{width:96%;border-collapse:collapse;border:1px solid #fc9878;margin:20px auto;}
      tr{height:25px;}
      th{width:18%;border:1px solid #fc9878;}
      td{width:18%;border:1px solid #fc9878;text-align:center;}
	 </style>
	</head>
<body style="background-color:#fff;">
<div ><?php echo ($vote["title"]); ?></div>

    
    <table>
        <tr><th>编号</th><th>姓名</th><th>取消关注数</th><th>最终票数</th><th>名次</th></tr>
    <?php if(is_array($vote_item)): $i = 0; $__LIST__ = $vote_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($li["id"]); ?></td>
                        <td><?php echo ($li["item"]); ?></td>
						<td><?php echo ($li["prode"]); ?>票</td>
						<td><?php echo ($li['pro']); ?>票</td>
						<td>第<b><?php echo ($li["mingci"]); ?></b>名</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>


<!--      <div class="skin-section">
              <h4><?php echo ($vote["title"]); ?></h4>  
             <h3><a href="<?php echo U('Vote/index');?>" class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="margin-top:-27px">返回</a>
			 </h3><h3><a href="<?php echo U('Vote/outxls',array('id'=>$vote['id']));?>" class="right btn btn-primary btn_submit  J_ajax_submit_btn" style="margin-top:-27px;margin-right:5px;">导出EXCEL</a>
			 </h3>
              
             <p class="modus"> <?php if($vote['cknums'] == 1): ?>单选<?php else: ?>多选<?php endif; ?>投票，<span class="number">共有<?php echo ($count); ?>人参与投票</span></p>
		<section class="list" id="allplayer">
		<div id="main" role="main">
				<ul id="tiles">
				<?php if(is_array($vote_item)): $i = 0; $__LIST__ = $vote_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li>
						<img src="<?php echo ($li["startpicurl"]); ?>" width="150" height="178">
						<p class="tit">编号:<?php echo ($li["id"]); ?> <br /><?php echo ($li["item"]); ?></p>
						<p>取消关注：<b><?php echo ($li["prode"]); ?>个</b></p><p> 减去票数：<b><?php echo ($li['prode']); ?>个</b></p>
						<p>最终票数：<b><?php echo ($li['pro']); ?></b></p>
						<p style="color:#FF0000;">名次：<b><?php echo ($li["mingci"]); ?></b></p>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
		 </div>
		 <div style="clear:both"></div>
		<div class="linkp"><?php echo ($page); ?></div>
		 </section>        
     </div>-->





<div id="gz_footer">版权所有 Copyright 2015 <?php echo ($gzh["tel"]); ?></div>

</body></html>