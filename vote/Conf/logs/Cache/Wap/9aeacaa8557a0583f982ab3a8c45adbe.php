<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo ($vote["title"]); ?> - 龙虎榜 - <?php echo ($info["gongzhong"]); ?></title>
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
		

	</head>

	
	
<body style="background-color:#eb4364;margin: 4%;">
<div class="wrap">
    <div class="phbtop">
        <img src="http://ad.gncm.com.cn/show/vote/CheShi/images/top.png" />
    </div>


    <div style="padding-bottom: 30px;">
    <table class="phblist">
        <tr><th width="10%">编号</th><th width="20%">姓名</th><th width="20%">取消关注数</th><th width="20%">最终票数</th><th width="30%">名次</th></tr>
    <?php if(is_array($vote_item)): $i = 0; $__LIST__ = $vote_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($li["id"]); ?></td>
                        <td><a  style="color:#229eb5;" href="<?php echo C('site_url');?>/index.php?g=Wap&m=Vote&a=show&token=<?php echo ($token); ?>&id=<?php echo ($li["id"]); ?>&wecha_id=<?php echo ($wecha_id); ?>&tid=<?php echo ($id); ?>"><?php echo ($li["item"]); ?></a></td>
						<td><?php echo ($li["prode"]); ?>票</td>
						<td><?php echo ($li['pro']); ?>票</td>
						<td class="order">第<b><?php echo ($li["mingci"]); ?></b>名</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>  <?php if(is_array($vote_item)): $i = 0; $__LIST__ = $vote_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($li["id"]); ?></td>
                        <td><a  style="color:#229eb5;" href="<?php echo C('site_url');?>/index.php?g=Wap&m=Vote&a=show&token=<?php echo ($token); ?>&id=<?php echo ($li["id"]); ?>&wecha_id=<?php echo ($wecha_id); ?>&tid=<?php echo ($id); ?>"><?php echo ($li["item"]); ?></a></td>
						<td><?php echo ($li["prode"]); ?>票</td>
						<td><?php echo ($li['pro']); ?>票</td>
						<td class="order">第<b><?php echo ($li["mingci"]); ?></b>名</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<tr>
						<td><?php echo ($li["id"]); ?></td>
                        <td><a  style="color:#229eb5;" href="<?php echo C('site_url');?>/index.php?g=Wap&m=Vote&a=show&token=<?php echo ($token); ?>&id=<?php echo ($li["id"]); ?>&wecha_id=<?php echo ($wecha_id); ?>&tid=<?php echo ($id); ?>"><?php echo ($li["item"]); ?></a></td>
						<td><?php echo ($li["prode"]); ?>票</td>
						<td><?php echo ($li['pro']); ?>票</td>
						<td class="order">第<b>222</b>名</td>
					</tr>
    </table>
    </div>

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
<style>
#gz_footer{display:none}
</style>
    ﻿


     <div style="width:100%;height:50px;position:fixed;bottom:0;background:#fd564a;font-family:'Microsoft YaHei';color:#fff;z-index:1000;left: 0;">
        <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/index',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/shouye.png" /></dt><dd>首 页</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/player',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/saishi.png" /></dt><dd>参赛选手</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo U('Vote/share',array('token'=>$_GET['token'],'tid'=>$_GET['tid']));?>"><dt><img width="28" height="28" src="images/paihang.png" /></dt><dd>排行榜</dd></a></dl>
         <dl style="width:24.2%;height:48px;padding-top:2px;text-align:center;float:left;border-left:1px solid #fe685e;border-right:1px solid #fa4034;"><a style="color:#fff;" href="<?php echo ($info["email"]); ?>"><dt><img width="28" height="28" src="images/guanzhu.png" /></dt><dd>关注我们</dd></a></dl>
     </div>

<div id="gz_footer">版权所有 Copyright 2015 <?php echo ($info["gongzhong"]); ?> </div>


</body></html>