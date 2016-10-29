<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><?php include templates("index","headersy");?>

<script async="" src="<?php echo G_TEMPLATES_JS; ?>/analytics11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/common11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/jquery.lazyload.min11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/jquery.cookie11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/jquery.cookies.2.2.011.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/footer_header11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/jquery.flexslider-min.js"></script>
<span id="index" style="display:none">index</span>                                       
<!-- 导航   end  -->
<!-- banner   start -->
	
	<div class="w10000 center">
	    <div class="flexslider">
	            <ul class="slides">
		            <li style="background:url(<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/banner/banner1.jpg) 50% 0 no-repeat;"><a href="#" style="display:block;height:400px;"></a></li> 
                    <li style="background:url(<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/banner/banner2.jpg) 50% 0 no-repeat;"><a href="#" style="display:block;height:400px;"></a></li> 
  					<li style="background:url(<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/banner/banner3.jpg) 50% 0 no-repeat;"><a href="#" style="display:block;height:400px;"></a></li> 
					<li style="background:url(<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/banner/banner4.jpg) 50% 0 no-repeat;"><a href="#" style="display:block;height:400px;"></a></li> 
					<li style="background:url(<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/banner/banner5.jpg) 50% 0 no-repeat;"><a href="#" style="display:block;height:400px;"></a></li>   				
	           </ul>
        </div>
	</div>     
<!-- banner   end -->




<!-- 最新动态 -->
 	<div class="yscroll_list">
		<div class="yscroll_listin">
			<span><i></i><a href="javascript:;">最新动态：</a></span>
			<ul class="yscroll_list_left" style="margin-top: 0px;">
			<?php $ln=1;if(is_array($newslist)) foreach($newslist AS $v): ?>
			<li><p class="yscrollfont">
			<a href="javascript::" title="<?php echo $v['title']; ?>"> <?php  echo strip_tags($v[content]) ; ?></a></p><p class="yscrolltime"><?php  echo date('Y-m-d',$v[posttime]) ; ?></p></li>
			<?php  endforeach; $ln++; unset($ln); ?>
			</ul>
			<ul class="yscroll_list_right">
				<a href="javascript:;"><span></span><em style="color:#9B9B9B">更多</em></a>
			</ul>
		</div>
	</div>
	<div class="yContent">
		<!-- 最新揭晓  -->
		<div class="yConNew yCon">
			<h2>
			    <a href="javascript:;">最新揭晓</a>
				<span></span>
				<!--<a href="javascript:;" target="_blank" class="yMoreLink yMorenearby">
				    <img src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/999999.gif" style="position:relative;top:4px;">看看附近都有谁获得了商品？
				</a>-->
			</h2>
			<div class="yConulout" style="border:1px solid #dfdfdf">
				<div class="yConuloutLeft yConuloutbtn" style="display: none;"><i></i></div>
				<div class="yConuloutright yConuloutbtn" style="display: none;"><i></i></div>
				<ul>
				
				    
			    <?php 
				$shopqishub=$this->db->GetList("select qishu,id,sid,thumb,title,q_uid,q_user,q_user_code,zongrenshu  from `@#_shoplist` where `q_end_time` is not null and `q_showtime` = 'N' ORDER BY `q_end_time` DESC LIMIT 10");
				 ?>
				<?php $ln=1;if(is_array($shopqishub)) foreach($shopqishub AS $qishu): ?>
				<?php 
				$qishu['q_user'] = unserialize($qishu['q_user']);
				$user_shop_number = $this->db->GetOne("select sum(gonumber) as gonumber from `@#_member_go_record` where `uid`= '$qishu[q_uid]' and `shopid` = '$qishu[id]' and `shopqishu` = '$qishu[qishu]'");
				$user_shop_number = $user_shop_number['gonumber'];
				 ?>
				
				    <li class="yTimesLi goods46_2">
					    <dl class="yTimesDl">
						    <dd class="yddImg">
							    <a href="javascript:;" target="_blank">
								    <img class="lazyjxn" data-original="" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $qishu['thumb']; ?>" style="display: block;">
								</a>
							</dd>
							<dd class="yddName">
							    <a href="<?php echo WEB_PATH; ?>/dataserver/<?php echo $qishu['id']; ?>" target="_blank">(第<?php echo $qishu['qishu']; ?>期)<?php echo $qishu['title']; ?> </a>
							</dd>
							<dd class="yGray">
							    本期幸运号码：<?php echo $qishu['q_user_code']; ?>
							</dd>
							<dd class="yTimes">
							    <p>
								    获奖者：<a href="<?php echo WEB_PATH; ?>/uname/<?php echo idjia($qishu['q_uid']); ?>"><?php echo get_user_name($qishu['q_user']); ?></a>
								</p>
							</dd>
						</dl>
						<strong></strong>
					</li>
				<?php  endforeach; $ln++; unset($ln); ?>

				</ul>
			</div>
		</div>
		
	</div>	
		<!--商品分类列表-->
	
	</div>
	
	
	<!--商品 开始-->
<div class="get_ready">
	<h3 style="margin-bottom:5px;"><span style="color:#000">最新上架</span><a rel="nofollow" href="<?php echo WEB_PATH; ?>/goods_list">更多新品，点击查看&gt;&gt;</a></h3>
	<ul id="readyLotteryItems" class="hot-list">
		<?php $shoplistnew=$this->DB()->GetList("select * from `@#_shoplist` where `scene` != '1' and `q_end_time` is  null  and `q_showtime` = 'N' and `shenyurenshu`!='0'    LIMIT 0,10",array("type"=>1,"key"=>'',"cache"=>0)); ?>
		<?php $ln=1;if(is_array($shoplistnew)) foreach($shoplistnew AS $shop): ?>
		<li class="list-block">
			<div class="pic"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shop['id']; ?>" target="_blank" title="<?php echo $shop['title']; ?>">
				<!--补丁3.1.5_b.0.1-->
				<?php $i_googd_bj = null; ?>
				<!--补丁3.1.5_b.0.1-->
				<?php if(($this_time - $shop['time']) < 86400): ?>
						<?php $i_googd_bj = '<i class="goods_xp"></i>'; ?>
				<?php endif; ?>
				<?php echo $i_googd_bj; ?>
			    <img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $shop['thumb']; ?>" alt="<?php echo $shop['title']; ?>"></a>
			</div>
			<p class="name"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shop['id']; ?>" target="_blank" title="<?php echo $shop['title']; ?>"><?php echo $shop['title']; ?></a></p>
			<p class="money">价值：<span class="rmb"><?php echo $shop['money']; ?></span></p>
			<div class="Progress-bar" style="">
				<p title="已完成<?php echo percent($shop['canyurenshu'],$shop['zongrenshu']); ?>"><span style="width:<?php echo width($shop['canyurenshu'],$shop['zongrenshu'],221); ?>px;"></span></p>
				<ul class="Pro-bar-li">
					<li class="P-bar01"><em><?php echo $shop['canyurenshu']; ?></em>已参与人次</li>
					<li class="P-bar02"><em><?php echo $shop['zongrenshu']; ?></em>总需人次</li>
					<li class="P-bar03"><em><?php echo $shop['zongrenshu']-$shop['canyurenshu']; ?></em>剩余人次</li>
				</ul>
			</div>
			<div class="shop_buttom"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shop['id']; ?>" target="_blank" class="shop_but" title="立即购买"></a></div>
		</li>
		<?php  endforeach; $ln++; unset($ln); ?>
	</ul>
</div>

<!--商品 结束-->

	
	
	
	<div class="goods_hot">
	<div class="goods_left">
	<div class="hot" style="">
			<h3><span>即将揭晓</span><a rel="nofollow" href="<?php echo WEB_PATH; ?>/goods_list/0_0_1">更多即将揭晓，点击查看&gt;&gt;</a></h3>
			<ul id="hostGoodsItems" class="hot-list">
				<?php 
				$shoplist=$this->db->GetList("select * from `@#_shoplist` where `q_uid` is null ORDER BY `shenyurenshu` ASC LIMIT 8");
				 ?>
				<?php $ln=1;if(is_array($shoplist)) foreach($shoplist AS $shop): ?>
				<li class="list-block">
					<div class="pic"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shop['id']; ?>" target="_blank" title="<?php echo $shop['title']; ?>"><img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $shop['thumb']; ?>" alt="<?php echo $shop['title']; ?>"></a></div>
					<p class="name"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shop['id']; ?>" target="_blank" title="<?php echo $shop['title']; ?>"><?php echo $shop['title']; ?></a></p>
					<p class="money">价值：<span class="rmb"><?php echo $shop['money']; ?></span></p>
					<div class="Progress-bar" style="">
						<p title="已完成<?php echo percent($shop['canyurenshu'],$shop['zongrenshu']); ?>"><span style="width:<?php echo width($shop['canyurenshu'],$shop['zongrenshu'],221); ?>px;"></span></p>
						<ul class="Pro-bar-li">
							<li class="P-bar01"><em><?php echo $shop['canyurenshu']; ?></em>已参与人次</li>
							<li class="P-bar02"><em><?php echo $shop['zongrenshu']; ?></em>总需人次</li>
							<li class="P-bar03"><em><?php echo $shop['zongrenshu']-$shop['canyurenshu']; ?></em>剩余人次</li>
						</ul>
					</div>
					<div class="shop_buttom"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shop['id']; ?>" target="_blank" class="shop_but" title="立即购买"></a></div>
				</li>
				<?php  endforeach; $ln++; unset($ln); ?>
			</ul>
		</div>
	</div>
	<div class="goods_right">

		<?php if(defined('G_IN_ADMIN')) {echo '<div style="padding:8px;background-color:#F93; color:#fff;border:1px solid #f60;text-align:center"><b>This Tag</b></div>';}?>
		<div class="share">
			<h3>最新参与记录</h3>
			<div class="buyList">
                <ul id="buyList" style="margin-top: 0px;">

				<?php 
				$go_recordb=$this->db->GetList("select `@#_member`.uid,`@#_member`.username,`@#_member`.email,`@#_member`.mobile,`@#_member`.img,`@#_member_go_record`.shopname,`@#_member_go_record`.shopid from `@#_member_go_record`,`@#_member` where `@#_member`.uid = `@#_member_go_record`.uid and `@#_member_go_record`.`status` LIKE '%已付款%'  ORDER BY `@#_member_go_record`.time DESC LIMIT 0,15");
				 ?>
					<?php $ln=1;if(is_array($go_recordb)) foreach($go_recordb AS $gorecord): ?>
					<li>
						<a href="<?php echo WEB_PATH; ?>/goods/<?php echo $gorecord['shopid']; ?>" class="pic" target="_blank">
                        <img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo shopimg($gorecord['shopid']); ?>"></a>
						<span class="who"><p style="display: inline;"><a class="blue" href="<?php echo WEB_PATH; ?>/uname/<?php echo idjia($gorecord['uid']); ?>"><?php echo get_user_name($gorecord); ?></a></p>刚刚<?php echo _cfg('web_name_two'); ?>了</span>
						<span><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $gorecord['shopid']; ?>" class="name" target="_blank"><?php echo $gorecord['shopname']; ?></a></span>
					</li>
					<?php  endforeach; $ln++; unset($ln); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!--即将揭晓 结束-->

	
	<div class="clear"></div>
	
	
	<!--晒单分享-->
<div class="lottery_show">
    <div class="share_show">
        <h3><span style="color:#000;font-family:微软雅黑,宋体">晒单分享</span><a href="<?php echo WEB_PATH; ?>/go/shaidan/" target="_blank">更多分享，点击查看&gt;&gt;</a></h3>
        <div class="show">
			<?php $ln=1;if(is_array($shaidan)) foreach($shaidan AS $sd): ?>
			<dl>
				<dt><a rel="nofollow" href="<?php echo WEB_PATH; ?>/go/shaidan/detail/<?php echo $sd['sd_id']; ?>" target="_blank"><img alt="" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $sd['sd_thumbs']; ?>"></a></dt>
				<dd class="bg">
					<ul>
						<li class="name"><span><a href="<?php echo WEB_PATH; ?>/go/shaidan/detail/<?php echo $sd['sd_id']; ?>" target="_blank"><?php echo $sd['sd_title']; ?></a></span> 获得者：<a rel="nofollow" class="blue" href="<?php echo WEB_PATH; ?>/uname/<?php echo $sd['sd_userid']; ?>" target="_blank"><?php echo get_user_name($sd['sd_userid']); ?></a></li>
						<li class="content"><?php echo _strcut($sd['sd_content'],100); ?></li>
					</ul>
				</dd>
			</dl>
			<?php  endforeach; $ln++; unset($ln); ?>
			<div class="show_list">
				<?php $ln=1;if(is_array($shaidan_two)) foreach($shaidan_two AS $sd): ?>
				<ul>
					<li class="pic"><a rel="nofollow" href="<?php echo WEB_PATH; ?>/go/shaidan/detail/<?php echo $sd['sd_id']; ?>"><img alt="" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $sd['sd_thumbs']; ?>"></a></li>
					<li class="show_tit"><a href="<?php echo WEB_PATH; ?>/go/shaidan/detail/<?php echo $sd['sd_id']; ?>" target="_blank"><?php echo $sd['sd_title']; ?></a></li>
					<li>获得者：<a rel="nofollow" class="blue" href="<?php echo WEB_PATH; ?>/uname/<?php echo $sd['sd_userid']; ?>" target="_blank"><?php echo get_user_name($sd['sd_userid']); ?></a></li>
					<li>揭晓时间：<?php echo date("Y-m-d",$sd['sd_time']); ?></li>
				</ul>
				<?php  endforeach; $ln++; unset($ln); ?>
				<div class="arrow_left"></div>
				<div class="arrow_right"></div>
			</div>
        </div>
    </div>
</div>
<!--晒单分享end-->

	<input type="hidden" id="yg_sq" value="">




                             


<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/index11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/indexExt11.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/layer/layer.min.js"></script>
<script type="text/javascript">
$(function(){

	$(".pullDownList").show();
	$('.flexslider').flexslider({

	    directionNav: true,
	    pauseOnAction: false
    });
});
</script>



<?php include templates("index","footer");?>