<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><?php include templates("index","header");?>
<div class="main-content clearfix">
<?php include templates("member","left");?>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/layout-setUp.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/layout-invitation.css"/>

<div class="R-content">
	<div class="subMenu">
		<a class="current2 current" href="<?php echo WEB_PATH; ?>/member/home/qiandao">签到</a>
	</div>

	<div class="total">
	<dt>
		</dt><dd>您已连续签到：<b class="orange"><?php echo $member['sign_in_time']; ?></b>天</dd>  <dd>总共签到：<b class="orange"><?php echo $member['sign_in_time_all']; ?></b>天</dd>  <dd>最后签到日期：<b class="orange"><?php echo $member['sign_in_date']; ?></b></dd>

   </div>
	<div class="info">
		<form class="registerform" method="post" action="<?php echo WEB_PATH; ?>/member/home/qiandao">
			<table border="0" cellpadding="0" cellspacing="8">
				<tr>
					<td><em>&nbsp;</em></td>
					<td><input name="submit" type="submit" class="bluebut" value="马上签到"></td>
				</tr>
			</table>
		</form>
	</div>
	<div class="divSQTX">
	<font size="+1" color="#FF0000">
		<span class = "gray02"><font size="+1" color="#f08200"><b>签到说明</font></b></span>
	</font><br>

	1.每天签到时间为<?php echo $time_start; ?>到<?php echo $time_stop; ?><br>
	2.每次签到可获得<?php echo $time_score; ?>福分（1000福分=1元）<br>

	<br><br>
	<br>
	<font size="+1" color="#FF0000">
		<span class = "gray02"><font size="+1" color="#f08200"><b>福分使用说明</font></b></span>
	</font><br>

	<img src="<?php echo G_TEMPLATES_STYLE; ?>/images/fufen.jpg" />
	<br><br><br>

	签到送福分<?php echo _cfg('web_name_two'); ?>将进行到底！！！
	</div>
</div>
</div>
<?php include templates("index","footer");?>