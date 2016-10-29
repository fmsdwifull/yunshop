<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><?php include templates("index","header");?>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/Lottery.css"/>
<div class="Current_nav"><a href="<?php echo WEB_PATH; ?>">首页</a> &gt; 最新揭晓</div>
<!--开奖列表开始-->
<div class="Newpublish">
	<div class="NewpublishL">
		<div id="current" class="publish_Curtit">
			<h1 class="fl" style="52c3f1">最新揭晓</h1>
			<span id="spTotalCount">(到目前为止共揭晓商品<em class="orange" style="color:#52c3f1"><?php echo $total; ?></em>件)</span>
		</div>
		<div class="publishBor">
			<div class="publishCen" id="listDivTitle">
				<ul id="ProductList">
					<?php $ln=1;if(is_array($shopqishu)) foreach($shopqishu AS $qishu): ?>
                    <?php 
                    	$qishu['q_user'] = unserialize($qishu['q_user']);
                     ?>
					<li class="Cursor">
						<a class="fl goodsimg" href="<?php echo WEB_PATH; ?>/dataserver/<?php echo $qishu['id']; ?>" target="_blank" >
						<img alt="" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $qishu['thumb']; ?>">
						</a>
						<div class="publishC-Member gray02"><a class="fl headimg" href="<?php echo WEB_PATH; ?>/uname/<?php echo idjia($qishu['q_uid']); ?>" target="_blank" >
							
							<img id="imgUserPhoto" src="<?php echo replaceimg($qishu['q_user']['img']); ?>" width="50" height="50" border="0"/>
							
							</a>
							<p>获得者：<a class="blue Fb" href="<?php echo WEB_PATH; ?>/uname/<?php echo idjia($qishu['q_uid']); ?>" target="_blank"><?php echo get_user_name($qishu['q_user']); ?></a></p>
							<p><?php echo _cfg('web_name_two'); ?>：<em class="orange Fb"><?php echo get_user_goods_num($qishu['q_uid'],$qishu['id']); ?></em>人次</p>							
						</div>
						<div class="publishC-tit">
							<h3><a href="<?php echo WEB_PATH; ?>/dataserver/<?php echo $qishu['id']; ?>" target="_blank" class="gray01">(第<?php echo $qishu['qishu']; ?>期)<?php echo $qishu['title']; ?></a></h3>
							<p class="money">商品价值：<span class="rmb"><?php echo $qishu['money']; ?></span></p>
							<p class="Announced-time gray02">揭晓时间：<?php echo microt($qishu['q_end_time'],'r'); ?></p>
						</div>
						<div class="details">
							<p class="fl details-Code">幸运<?php echo _cfg('web_name_two'); ?>码：<em class="orange Fb"><?php echo $qishu['q_user_code']; ?></em></p>
							<a class="fl details-A" href="<?php echo WEB_PATH; ?>/dataserver/<?php echo $qishu['id']; ?>" rel="nofollow" target="_blank">查看详情</a>
							
						</div>
					</li>	
					<?php  endforeach; $ln++; unset($ln); ?>
				</ul>
			</div>
			<?php if($total>$num): ?>
					<div class="pagesx"><?php echo $page->show('two'); ?></div>
			<?php endif; ?>
		</div>
	</div>
	<div class="NewpublishR">
		<div class="Newpublishbor">
			<div class="Rtitle gray01">TA们正在<?php echo _cfg('web_name_two'); ?> </div>
			<div class="Rcenter buylistH">
				<ul id="buyList" style="margin-top: 0px;">
					<?php $ln=1;if(is_array($member_record)) foreach($member_record AS $record): ?>
					<li><a href="<?php echo WEB_PATH; ?>/uname/<?php echo idjia($record['uid']); ?>" target="_blank" class="pic">						
						<?php if(userid($record['uid'],'img')==null): ?>
						<img src="<?php echo G_TEMPLATES_STYLE; ?>/images/prmimg.jpg" width="50" height="50" />
						<?php  else: ?>
						<img id="imgUserPhoto" src="<?php echo replaceimg(userid($record['uid'],'img')); ?>" width="50" height="50" border="0"/>
						<?php endif; ?>	
						</a>
						<p class="Rtagou"><a class="blue" href="<?php echo WEB_PATH; ?>/uname/<?php echo idjia($record['uid']); ?>" target="_blank"><?php echo userid($record['uid'],'username'); ?></a>刚刚<?php echo _cfg('web_name_two'); ?>了</p>
						<p class="Rintro"><a class="gray01" href="<?php echo WEB_PATH; ?>/goods/<?php echo $record['shopid']; ?>" target="_blank"><?php echo $record['shopname']; ?></a></p>
					</li>
					<?php  endforeach; $ln++; unset($ln); ?>
				</ul>
			</div>
		</div>
		<div class="blank10"></div>
		<div class="Newpublishbor">
			<div class="Rtitle gray01">人气排行 </div>
			<div class="Rcenter RcenterPH">
				<ul class="RcenterH" id="RcenterH">						
					<?php $ln=1;if(is_array($shoplist)) foreach($shoplist AS $list): ?>
					<li>
						<div name="simpleinfo">
							<span class="pic"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $list['id']; ?>" target="_blank">
							<?php if(shopimg($list['id'])!=''): ?>
								<img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo shopimg($list['id']); ?>">
							<?php  else: ?>
								<img src="<?php echo G_UPLOAD_PATH; ?>/photo/member.jpg_30.jpg">
							<?php endif; ?>
							</a></span>
							<p class="Rintro gray01"><a href="<?php echo WEB_PATH; ?>/goods/<?php echo $list['id']; ?>" target="_blank"><?php echo $list['title']; ?></a></p>
							<p><i>剩余人次</i><em><?php echo $list['zongrenshu']-$list['canyurenshu']; ?></em></p>
						</div>
					</li>
					<?php  endforeach; $ln++; unset($ln); ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
    $(function(){
       var _BuyList=$("#buyList");
        var Trundle = function () {
            _BuyList.prepend(_BuyList.find("li:last")).css('marginTop', '-85px');
            _BuyList.animate({ 'marginTop': '0px' }, 800);
        }
        var setTrundle = setInterval(Trundle, 3000);
        _BuyList.hover(function () {
            clearInterval(setTrundle);
            setTrundle = null;
        },function () {
            setTrundle = setInterval(Trundle, 3000);
        });
    });
    </script>
<?php include templates("index","footer");?>