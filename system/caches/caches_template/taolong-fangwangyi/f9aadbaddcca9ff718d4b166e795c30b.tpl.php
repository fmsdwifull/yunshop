<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php if(isset($title)): ?><?php echo $title; ?><?php  else: ?><?php echo _cfg("web_name"); ?><?php endif; ?></title>
<meta name="keywords" content="<?php if(isset($keywords)): ?><?php echo $keywords; ?><?php  else: ?><?php echo _cfg("web_key"); ?><?php endif; ?>" />
<meta name="description" content="<?php if(isset($description)): ?><?php echo $description; ?><?php  else: ?><?php echo _cfg("web_des"); ?><?php endif; ?>" />
<meta http-equiv = "X-UA-Compatible" content = "IE = edge" />
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/Comm.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/register.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/goods1.css">
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/Home.css"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">    
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/comm1.css">
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/footer_header.css">
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/index11.css">
<script type="text/javascript" src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_JS; ?>/jquery.cookie.js"></script>

</head>

<body >
<input type="hidden" id="mid" value="">
<input type="hidden" id="signTime" value="">
<input type="hidden" id="signDays" value="">
<!-- 2015-5-22 -修改 start  .header增加header_fixed类 -->
<div class="header header_fixed">
	<div class="header1">
		<div class="header1in">
			<ul class="headerul1">
				<li><a style="padding-left:40px;font-size: 14px;"><i class="header-tel"></i><?php echo _cfg("cell"); ?></a></li>
				<li class="hreder-hover" style="border-right:none;"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo _cfg("qq"); ?>&site=qq&menu=yes" target="_blank">在线客服</a></li>
				<li class="phoneli header-WeChatli">
					<a href="<?php echo WEB_PATH; ?>/go/index/weixin" style=" padding-bottom: 0px;">关注我们<i class="i-header-WeChat"></i></a>
					<img src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/cloud_kik.png">
				</li>
				
			</ul>
			<ul class="headerul2">
				<li><a href="<?php echo WEB_PATH; ?>/member/home/qiandao" id="sign" onclick="sign()">签到</a></li>
				
				<?php if(get_user_arr()): ?>
				<li>
				   <a href="<?php echo WEB_PATH; ?>/member/home" class="gray01" >									
						<?php echo get_user_name(get_user_arr(),'username'); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo WEB_PATH; ?>/member/user/cook_end" class="gray01">[退出]</a>
				</li>
				<?php  else: ?>
				<li><a href="<?php echo WEB_PATH; ?>/login">登录</a></li>
				<li><a href="<?php echo WEB_PATH; ?>/register">免费注册</a></li>
				<?php endif; ?>
				<li class="MyzhLi">
					<a href="javascript:;">我的云购<i class="top"></i></a>
					<dl class="Myzh" style="display: none;">
						<dd><a href="<?php echo WEB_PATH; ?>/member/home/userbuylist">购买记录</a></dd>
						<dd><a href="<?php echo WEB_PATH; ?>/member/home/orderlist">获得的商品</a></dd>
						<dd><a href="<?php echo WEB_PATH; ?>/member/home/modify">个人设置</a></dd>
					</dl>
				</li>
				<li><a href="<?php echo WEB_PATH; ?>/member/home/userrecharge">充值</a></li>	
				<li><a href="<?php echo WEB_PATH; ?>/help/1">帮助</a></li>	
				<li><a style="border-right:none;" href="<?php echo WEB_PATH; ?>/group_qq">官方QQ群</a></li>
			</ul>
		</div>
	</div>
	<div class="header2">
		<a href="<?php echo WEB_PATH; ?>" class="header_logo"><img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo Getlogo(); ?>" style="width:210px;height:auto;"></a>
		<div class="leijinumber">
		   
			<?php 
				$renci = go_count_renci() ; 
				$strarr = str_split($renci);
				$strlen = count($strarr);
				$yushu = $strlen%3 ;
			 ?>
			<center>
			<a href="<?php echo WEB_PATH; ?>/buyrecord/" target="_blank">
              <ul id="ulHTotalBuy">
                  <li class="nobor gray6">累计参与</li>
                  <?php 
					for($i=0;$i<$yushu;$i++){ 
						echo '<li class="num" >'.$strarr[$i].'</li>';
					}
				   ?>
                  <li class="nobor">,</li>
                  <?php 
                  	$k = 1;
					for($i=$yushu;$i<$strlen;$i++){ 
						echo '<li class="num" >'.$strarr[$i].'</li>';
						if($k%3==0 && $i+1 != $strlen) {
							echo '<li class="nobor" >,</li>';
						}
						$k++;
					}
				   ?>
                  
                  <li class="nobor gray6">人次</li>
              </ul>
          </a>
          </center>

		</div>
		<div class="search_header2">
			<s></s>
			<input type="text" placeholder="搜索您需要的商品" value="" id="txtSearch" class="init" style="color: rgb(169, 169, 169);">
			<a href="javascript:;" class="btnHSearch_ss " id="butSearch">搜索</a>
			<span class="search_span_a">
			  <a href="<?php echo WEB_PATH; ?>/s_tag/苹果" target="_blank">苹果</a>
			  <a href="<?php echo WEB_PATH; ?>/s_tag/iPhone" target="_blank">iPhone</a>
			  <a href="<?php echo WEB_PATH; ?>/s_tag/智能手机" target="_blank">智能手机</a>
			  <a href="<?php echo WEB_PATH; ?>/s_tag/3G手机" target="_blank">3G手机</a>
			</span>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
<!-- 导航   start  -->
<div class="yNavIndexOut">
	<div class="yNavIndex">
		<div class="pullDown" style="z-index:999">
			<h4 class="pullDownTitle">
				<a href="javascript:;" target="">所有商品分类</a>
			</h4>
			<ul class="pullDownList" style="display:none;">
			<?php $data=$this->DB()->GetList("select * from `@#_category` where `model`='1' and `parentid` = '0' order by `order` DESC",array("type"=>1,"key"=>'',"cache"=>0)); ?>
				<?php $catenum = 1 ; ?>
				<?php $ln=1;if(is_array($data)) foreach($data AS $categoryx): ?>
					<li><i class="listi<?php echo $catenum; ?>"></i><a href="<?php echo WEB_PATH; ?>/goods_list/<?php echo $categoryx['cateid']; ?>"><?php echo $categoryx['name']; ?></a><span></span></li>
					<?php $catenum++ ; ?>
				<?php  endforeach; $ln++; unset($ln); ?>
			<?php if(defined('G_IN_ADMIN')) {echo '<div style="padding:8px;background-color:#F93; color:#fff;border:1px solid #f60;text-align:center"><b>This Tag</b></div>';}?>
			<li><i class="listi7"></i><a href="<?php echo WEB_PATH; ?>/group">云购社区</a><span></span></li>
			</ul>
		</div>
		<ul class="yMenuIndex">
			<li><a href="<?php echo WEB_PATH; ?>"  <?php if($key == '首页'): ?> class="yMenua" <?php endif; ?>>首页</a></li>
			<li><a href="<?php echo WEB_PATH; ?>/general_glist/" <?php if($key == '国际购'): ?> class="yMenua" <?php endif; ?>>国际购</a></li>
			<li class="hide-menu-nav" ><span></span>
				<a href="javascript:" class="hide-menu-nava <?php if($key == '云购专区'): ?> yMenua <?php endif; ?>" >云购专区</a>
				<dl>
					<dd><a href="<?php echo WEB_PATH; ?>/goods_list/0/5">五元专区</a></dd>
					<dd><a href="<?php echo WEB_PATH; ?>/goods_list/0/10">十元专区</a></dd>
				</dl>
			</li>
			<li style="width:120px;"><a href="<?php echo WEB_PATH; ?>/goods_lottery/"  <?php if($key == '最新揭晓'): ?> class="yMenua" <?php endif; ?>>最新揭晓<img src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/hot.gif" style="position:absolute;top:-6px;right:3px;width:25px;"></a></li>
			<li style="padding:0 0px 0px 12px;width:108px;"><a href="<?php echo WEB_PATH; ?>/go/shaidan/"  <?php if($key == '惊喜晒单'): ?> class="yMenua" <?php endif; ?> style="padding-right:10px;"><img src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/gif_qq.gif" style="position:absolute;top:12px;left:0px;width:20px;">惊喜晒单</a></li>

			<li><a href="<?php echo WEB_PATH; ?>/group/"  <?php if($key == '国际圈'): ?> class="yMenua" <?php endif; ?>>国际圈</a></li>
			<li class="hide-menu-nav" style="padding: 0 13px 0px 15px;"><span></span>
				<a href="javascript:void(0)" class="hide-menu-nava">国际大发现</a>
				<dl>
					<dd style="border-top:1px solid #ddd;"><a href="<?php echo WEB_PATH; ?>/zhuanti/yaoqing" target="_blank">邀请好友赚佣金</a></dd>
					<dd style="border-top:1px solid #ddd;"><a href="<?php echo WEB_PATH; ?>/zhuanti/hezuo" target="_blank">云购供应商招募</a></dd>
				</dl>
			</li>
			
		</ul>
	</div>
</div>
<script>
 $(function(){
    $(".pullDown").mouseover(function(){
      $(".pullDownList").show();
    })
	$(".pullDown").mouseout(function(){
      $(".pullDownList").hide();
    })
    $(".MyzhLi").mouseover(function(){
      $(".Myzh").show();
    })
	$(".MyzhLi").mouseout(function(){
      $(".Myzh").hide();
    })
 })
  
</script>

                                          
<!-- 导航   end  -->


	
    
    

    
    
	






