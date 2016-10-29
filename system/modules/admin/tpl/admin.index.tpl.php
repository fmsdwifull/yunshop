<?php defined('G_IN_ADMIN')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8"> 
<link rel="Shortcut Icon" href="<?php echo G_WEB_PATH;?>/favicon.ico">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/global.css" type="text/css">
<link rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/index.css" type="text/css">
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/layer/layer.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/global.js"></script>
<title>后台首页</title>
<script type="text/javascript">
var ready=1;
var kj_width;
var kj_height;
var header_height=100;
var R_label;
var R_label_one = "当前位置: 系统设置 >";


function left(init){
	var left = document.getElementById("left");
	var leftlist = left.getElementsByTagName("ul");
	
	for (var k=0; k<leftlist.length; k++){
		leftlist[k].style.display="none";
	}
	document.getElementById(init).style.display="block";
}

function secBoard(elementID,n,init,r_lable) {
			
	var elem = document.getElementById(elementID);
	var elemlist = elem.getElementsByTagName("li");
	for (var i=0; i<elemlist.length; i++) {
		elemlist[i].className = "normal";		
	}
	elemlist[n].className = "current";
	R_label_one="当前位置: "+r_lable+" >";
	R_label.text(R_label_one);
	left(init);
}


function set_div(){
		kj_width=$(window).width();
		kj_height=$(window).height();
		if(kj_width<1000){kj_width=1000;}
		if(kj_height<500){kj_height=500;}

		$("#header").css('width',kj_width); 
		$("#header").css('height',header_height);
		$("#left").css('height',kj_height-header_height); 
	    $("#right").css('height',kj_height-header_height); 
		$("#left").css('top',header_height); 
		$("#right").css('top',header_height);
		
		$("#left").css('width',180);		
		$("#right").css('width',kj_width-182); 
		$("#right").css('left',182);
		
		$("#right_iframe").css('width',kj_width-206); 
		$("#right_iframe").css('height',kj_height-148);
		 		
		$("#iframe_src").css('width',kj_width-208); 
		$("#iframe_src").css('height',kj_height-150); 	
		
		$("#off_on").css('height',kj_height-180);
		
		var nav=$("#nav");		
		nav.css("left",(kj_width-nav.get(0).offsetWidth)/2);
		nav.css("top",61);
		
}


$(document).ready(function(){	
		set_div();		
		$("#off_on").click(function(){
				if($(this).attr('val')=='open'){
					$(this).attr('val','exit');
					$("#right").css('width',kj_width);
					$("#right").css('left',1);
					$("#right_iframe").css('width',kj_width-25); 
					$("iframe").css('width',kj_width-27);
				}else{
					$(this).attr('val','open');
					$("#right").css('width',kj_width-182);
					$("#right").css('left',182);
					$("#right_iframe").css('width',kj_width-206); 
					$("iframe").css('width',kj_width-208);
				}
		});
		
		left('setting');
		$(".left_date a").click(function(){
				$(".left_date li").removeClass("set");						  
				$(this).parent().addClass("set");
				R_label.text(R_label_one+' '+$(this).text()+' >');
				$("#iframe_src").attr("src",$(this).attr("src"));
		});
		$("#iframe_src").attr("src","<?php echo G_MODULE_PATH; ?>/index/Tdefault");
		R_label=$("#R_label");
		$('body').bind('contextmenu',function(){return false;});
		$('body').bind("selectstart",function(){return false;});
				
});

function api_off_on_open(key){
	if(key=='open'){
				$("#off_on").attr('val','exit');
				$("#right").css('width',kj_width);
				$("#right").css('left',1);
				$("#right_iframe").css('width',kj_width-25); 
				$("iframe").css('width',kj_width-27);
	}else{
					$("#off_on").attr('val','open');
					$("#right").css('width',kj_width-182);
					$("#right").css('left',182);
					$("#right_iframe").css('width',kj_width-206); 
					$("iframe").css('width',kj_width-208);
	}
}
</script>

<style>
.header_case{  position:absolute; right:10px; top:10px; color:#fff}
.header_case a{ padding-left:5px}
.header_case a:hover{ color:#fff;}

.left_date a{color:#444;}
.left_date{overflow:hidden;}
.left_date ul{ margin:0px;padding:0px;border:1px solid #f00;}
.left_date li{line-height:30px; height:30px; margin:0px 10px; margin-left:15px; overflow:hidden;border:1px solid #000;border-top:none;}
.left_date li a{ display:block;text-indent:5px;  overflow:hidden;}
.left_date li a:hover{ background-color:#d3e8f2;text-decoration:none;border-radius:3px;}
.left_date .set a{background-color:#d3e8f2;border-radius:3px; font-weight:bold}
.head{color:#2a8bbb; font-weight:bold; margin-bottom:10px;color:#fff;}

</style>

</head>
<body onResize="set_div();">

<div id="header">
	<div class="logo" style="width:550px;"></div>
    <div class="header_case" style="color:#fff;" style="border:1px solid #000">
    欢迎您：<a href="javascript:;" title="<?php echo $info['username']; ?>" style="color:#f08200;"><?php echo $info['username']; ?> [超级管理员]</a>
    <a href="<?php echo G_MODULE_PATH; ?>/user/out" title="退出" style="color:#f08200;">[退出]</a>
    <a href="<?php echo G_WEB_PATH; ?>" title="网站首页" target="_blank" style="color:#f08200;">网站首页</a>
    <a href="<?php echo G_MODULE_PATH; ?>/index/map" title="地图" style="color:#f08200;">地图</a>

    <button  style="width:0px;height:0px;" onClick="document.location.hash='hello'"></button>
    </div>
    <div class="nav" id="nav">    
    	<ul>	
            <li class="current"><a href="#" onClick="secBoard('nav',0,'setting','系统设置');">系统设置</a></li>
            <li class="normal"><a href="#" onClick="secBoard('nav',1,'content','内容管理');">内容管理</a></li>
            <li class="normal"><a href="#" onClick="secBoard('nav',2,'shop','云购管理');">云购管理</a></li>
            <li class="normal"><a href="#" onClick="secBoard('nav',3,'genshop','国际购管理');">国际购管理</a></li>
            <li class="normal"><a href="#" onClick="secBoard('nav',4,'user','用户管理');">用户管理</a></li>
            <li class="normal"><a href="#" onClick="secBoard('nav',5,'template','界面管理');">界面管理</a></li>
            <li class="normal"><a href="#" onClick="secBoard('nav',6,'vote','投票管理');">投票管理</a></li>
            <!-- <li class="normal"><a href="#" onClick="secBoard('nav',5,'yunapp','云应用');">云应用</a></li> -->
        </ul>
    </div>
</div><!--header end-->

<!--left begin-->
<div id="left">
    <ul class="left_date" id="setting" style="margin-top:15px;">   
    	<li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">站点设置</li>
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/webcfg">SEO设置</a></li> 
    	<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/config">基本设置</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/upload">上传设置</a></li> 
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/watermark">水印设置</a></li>	
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/email">邮箱配置</a></li> 
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/mobile">短信配置</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/template/temp">通知模板配置</a></li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/pay/pay/pay_list">支付方式</a></li>        
       
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/setting/domain">模块域名绑定</a></li>	
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/qq_admin">官方QQ群</a></li>

	  <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">微信公众号管理</li>
	  <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/weixin/config">公众号参数</a></li> 
    	<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/weixin/menu">自定义菜单</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/weixin/rule">回复规则</a></li> 
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/weixin/material">素材管理</a></li>	
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/weixin/send_message">群发消息</a></li> 

        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">管理员管理</li>		
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/user/lists">管理员管理</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/user/reg">添加管理员</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/user/edit/<?php echo $info['uid']; ?>">修改密码</a></li>
		<li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">站长运营</li>
        <li><a href="javascript:void(0);" src="<?php echo G_ADMIN_PATH; ?>/yunwei/websitemap">站点地图</a></li>
		<li><a href="javascript:void(0);" src="<?php echo G_ADMIN_PATH; ?>/yunwei/websubmit">网站提交</a></li>
		<li><a href="javascript:void(0);" src="<?php echo G_ADMIN_PATH; ?>/yunwei/webtongji">站长统计</a></li>
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">后台首页</li>
        <li><a href="javascript:void(0);" src="<?php echo G_ADMIN_PATH; ?>/index/Tdefault">后台首页</a></li>
		<li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;">其他</li>
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/cache/init">清空缓存</a></li>
    </ul>
     <ul class="left_date" id="content" style="margin-top:15px;">
        <li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">文章管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/article_add">添加文章</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/article_list">文章列表</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/category/lists/article">文章分类</a></li>
  

        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">新闻管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/news_add">添加新闻</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/news_list">新闻列表</a></li>

        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">单页管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/category/addcate/danweb">添加单页</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/category/lists/single">单页列表</a></li>
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">附件管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/upload/lists">上传文件管理</a></li>
        <!--<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/lists">管理内容</a></li>-->	
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">其他</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/model">内容模型</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/category/lists">栏目管理</a></li>
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">模块管理</li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/group/quanzi">圈子模块</a></li>  
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/link/lists">友情链接</a></li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/admanage/admanage_admin">广告模块</a></li>
         <!--
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/vote/vote_admin/">投票模块</a></li>
         -->
    </ul>

     <ul class="left_date" id="shop" style="margin-top:15px;">   
     	<li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">云购商品管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/goods_add">添加新商品</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/goods_list">商品列表</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/category/lists/goods">商品分类</a></li> 
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/brand/lists">品牌管理</a></li>    	
    	<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/brand/insert">添加品牌</a></li> 
		<!--<li class="head">普通商品管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/general_goods_add">添加新商品</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/general_goods_list">商品列表</a></li>    
       -->
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">商品其他</li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/api/position/lists">推荐位管理</a></li>     
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">订单管理</li>
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/dingdan/lists">订单列表</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/dingdan/select">订单查询</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/dingdan/lists/zj">中奖订单</a></li> 
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/dingdan/lists/notsend">未发货订单</a></li> 		
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">促销管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/goods_list/xianshi">限时揭晓商品</a></li>
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">其他</li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/go/shaidan_admin/init">晒单查看</a></li>
    </ul>
    <ul class="left_date" id="genshop" style="margin-top:15px;">   
     	<li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">商品管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/general_goods_add">添加新商品</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/general_goods_list">商品列表</a></li>

        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/category/lists/goods">商品分类</a></li> 
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/brand/lists">品牌管理</a></li>    	
    	<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/brand/insert">添加品牌</a></li> 
        
		  
       <!--
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">商品其他</li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/api/position/lists">推荐位管理</a></li>  
        -->   
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">订单管理</li>
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/order/lists">订单列表</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/order/select">订单查询</a></li>
        <!--<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/dingdan/lists/zj">中奖订单</a></li> -->
		<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/order/lists/notsend">未发货订单</a></li> 
        <!--		
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">促销管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/content/goods_list/xianshi">限时揭晓商品</a></li>
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">其他</li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/go/shaidan_admin/init">晒单查看</a></li>
        -->
    </ul>
     <ul class="left_date" id="user" style="margin-top:15px;">   
     	<li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">用户管理</li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/lists">会员列表</a></li> 	
		 <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/select">查找会员</a></li> 	
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/insert">添加会员</a></li> 	
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/config">会员配置</a></li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/recharge">充值记录</a></li>
        <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/pay_list">消费记录</a></li>
		<li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/member_group">会员组</a></li>
		<li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/member/member/commissions">佣金申请提现管理</a></li>
        
    </ul>
    <ul class="left_date" id="template" style="margin-top:15px;">   
     	<li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">界面管理</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/ments/navigation">导航条管理</a></li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/slide">幻灯管理</a></li>
        <!--<li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/recom">推荐位图片</a></li>-->
		<li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/mobile/wap">手机幻灯片</a></li>
        <!-- <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">模板风格</li> -->
        <!-- <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/template">模板设置</a></li>        -->
		<!-- <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/template/see">查看模板</a></li> -->
		<!-- <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/htmlcustom/lists">模板TAG标签</a></li> -->
        <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">后台界面</li>
        <li><a href="javascript:void(0);" src="<?php echo G_MODULE_PATH; ?>/index/map">后台地图</a></li>   
        
    </ul>    
     <ul class="left_date" id="yunapp" style="margin-top:15px;">
        <li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">插件管理</li>
         <!--<li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/api/upfile">在线升级</a></li>-->
        <!--<li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/api/plugin/get/bom">BOM检测</a></li>-->
         <!--<li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/api/plugin/admin/egglotter/listlotter">游戏设置</a></li> -->
		<!-- <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/api/qqlogin/qq_set_config">QQ登陆</a></li>  -->
		<!-- <li><a href="javascript:void(0);" src="<?php echo G_ADMIN_PATH; ?>/fund/fundset">公益基金</a></li> -->
		 <!-- <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/auto/auto_p/show">自动购买</a></li> -->
	<!-- <li><a href="javascript:void(0);" src="<?php echo G_ADMIN_PATH; ?>/auto_register/show">批量注册</a></li> -->
	
	 <!-- <li class="head" style="height:35px;line-height:35px;border:none;margin-top:10px;text-indent:5px;">充值卡管理</li> -->
        <!-- <li><a href="javascript:void(0);" src="<?php echo WEB_PATH; ?>/czk/vote_admin/">充值卡管理</a></li> -->
		
    </ul>
    <ul class="left_date" id="vote" style="margin-top:15px;">
        <li class="head" style="height:35px;line-height:35px;border:none;text-indent:5px;">投票管理</li>
        
        <li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Vote&a=index">管理</a></li>
        <li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Vote&a=add&type=text">发起文字投票</a></li>
        <li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Vote&a=add&type=img">发起图片投票</a></li>
        <!--<li><a href="javascript:void(0);" src="/vote/index.php?g=Home&m=Index&a=help&token=vjcbgt1414375209">API接口</a></li>-->
        <!--<li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Diymen&a=index&token=vjcbgt1414375209">底部菜单</a></li>-->
        <li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Vote&a=gongzhong&id=1">信息绑定</a></li>
        <li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Vote&a=check&id=1">审核信息</a></li>
        <!--<li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Areply&a=index&token=vjcbgt1414375209">关注回复</a></li>-->
        <li><a href="javascript:void(0);" src="/vote/index.php?g=User&m=Index&a=useredit">修改密码</a></li>
        <li><a href="javascript:void(0);" src="/vote/index.php?g=Home&m=Index&a=logout">退出登录</a></li>
        
    </ul>
	 <div style="padding:30px 10px; color:#ccc">
     	<p>
        <br>
			
        </p>
     </div>

</div>
<!--left end-->


<div id="right">
	<div class="right_top">
    	<ul class="R_label" id="R_label">
        	当前位置: 系统设置 >  后台主页 >
        </ul>
    	<ul class="R_btn">
    	<a href="javascript:;" onClick="btn_iframef5();" class="system_button"><span>刷新框架</span></a>
        <!--<a href="javascript:;" onClick="btn_checkbom('<?php echo WEB_PATH; ?>/api/plugin/get/bom');" class="system_button"><span>检查BOM</span></a>-->
      
        <a href="javascript:;" onClick="btn_map('<?php echo G_MODULE_PATH; ?>/index/map');" class="system_button"><span>后台地图</span></a>
        </ul>
    </div>
    <div class="right_left">
    	<a href="#" val="open" title="全屏" id="off_on">全屏</a>
    </div>
    <div id="right_iframe">
        
         <iframe id="iframe_src" name="iframe" class="iframe"
         frameborder="no" border="1" marginwidth="0" marginheight="0" 
         src="" 
         scrolling="auto" allowtransparency="yes" style="width:100%; height:100%">
         </iframe>
        
    </div>
</div><!--right end-->


</body>
</html>