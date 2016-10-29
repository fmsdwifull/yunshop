<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>购物车 - <?php echo _cfg("web_name"); ?></title>
<meta name="keywords" content="<?php if(isset($keywords)): ?><?php echo $keywords; ?><?php  else: ?><?php echo _cfg("web_key"); ?><?php endif; ?>" />
<meta name="description" content="<?php if(isset($description)): ?><?php echo $description; ?><?php  else: ?><?php echo _cfg("web_des"); ?><?php endif; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/Comm.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/CartList.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/footer_header.css">
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_CSS; ?>/index11.css">
<script type="text/javascript" src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_STYLE; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo G_TEMPLATES_STYLE; ?>/js/layer/layer.min.js"></script>
</head>
<body>
<div class="logo">
	<div class="float">
		<span class="logo_pic"><a href="<?php echo G_WEB_PATH; ?>" class="a" title="<?php echo _cfg("web_name"); ?>">
			<img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo Getlogo(); ?>"/>
		</a></span>
		<span class="tel"><a href="<?php echo G_WEB_PATH; ?>" style="color:#999;">返回首页</a></span>
	</div>
</div>
<div class="shop_process">
	<ul class="process">
		<li class="first_step">第一步：提交订单</li>
		<li class="arrow_1"></li>
		<li class="secend_step">第二步：订单支付</li>
		<li class="arrow_2"></li>
		<li class="third_step">第三步：支付成功 等待揭晓</li>
		<li class="arrow_2"></li>
		<li class="fourth_step">第四步：揭晓获得者</li>
		<!-- <li class="arrow_2"></li>
		<li class="fifth_step">第五步：晒单奖励</li> -->
	</ul>
	<div class="i_tips"></div>
	<?php if($yunlist): ?>
	<table class="cardlist_table">
		<thead>
			<tr><th colspan="8" class="good_title"><span style="padding-left:15px;">云购商品</span></th></tr>
			<tr>
				<th width="10%">商品</th>
				<th width="30%">名称</th>
				<th width="10%">价值</th>
				<th width="10%"><?php echo _cfg('web_name_two'); ?>价</th>
				<th width="15%"><?php echo _cfg('web_name_two'); ?>人次</th>
				<th width="10%">小计</th>
				<th width="10%">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php $ln=1;if(is_array($yunlist)) foreach($yunlist AS $shops): ?>
			<tr id="yunList<?php echo $shops['id']; ?>">
				<td>
					<a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shops['id']; ?>">
						<img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $shops['thumb']; ?>" width="70px;" height="70px" style="border:1px solid #ccc;" />
                    </a>  
				</td>
				<td>
					<p><a href="<?php echo WEB_PATH; ?>/go/index/item/<?php echo $shops['id']; ?>" ><?php echo $shops['title']; ?></a></p>
					<p>&nbsp;</p>
					<p>	
						总需 
						<span class="color"><?php echo $shops['zongrenshu']; ?></span>人次参与，还剩 
						<span style="color:red;"><?php echo $shops['cart_shenyu']; ?></span> 人次
                    </p>
				</td>
				<td>￥<?php echo $shops['money']; ?></td>
				<td>￥<?php echo $shops['yunjiage']; ?></td>
				<td>
					<dl class="add" style="padding:0;display:inline-block;">	
						<dd>
							<input type="type" val="<?php echo $shops['id']; ?>" onkeyup="value=value.replace(/\D/g,'')" value="<?php echo $shops['cart_gorenci']; ?>" name="yun_amount" class="amount" />
						</dd>
						<dd>
							<a href="JavaScript:;" val="<?php echo $shops['id']; ?>" class="jia"></a>
							<a href="JavaScript:;" val="<?php echo $shops['id']; ?>" class="jian"></a>
						</dd>                        
					</dl>
				</td>
				<td><i class="xj"><?php echo $shops['cart_xiaoji']; ?></i></td>
				<td><a href="javascript:;" onclick="delcart(<?php echo $shops['id']; ?>)"  class="delgood">删除</a></td>
			</tr>
		<?php  endforeach; $ln++; unset($ln); ?>
		</tbody>
	</table>
	<?php endif; ?>
	
	<?php if($generalList): ?>
	<table class="cardlist_table">
		<thead>
			<tr><th colspan="6" class="good_title"><span style="padding-left:15px;">普通商品</span></th></tr>
			<tr>
				<th width="10%">商品</th>
				<th width="40%">名称</th>
				<th width="10%">价格</th>
				<th width="15%">数量</th>
				<th width="10%">小计</th>
				<th width="10%">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php $ln=1;if(is_array($generalList)) foreach($generalList AS $shops): ?>
			<tr id="generalList<?php echo $shops['id']; ?>">
				<td>
					<a href="<?php echo WEB_PATH; ?>/goods/<?php echo $shops['id']; ?>">
						<img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $shops['thumb']; ?>" width="70px;" height="70px" style="border:1px solid #ccc;padding:2px;" />
                    </a>  
				</td>
				<td>
					<p><a href="<?php echo WEB_PATH; ?>/go/index/item/<?php echo $shops['id']; ?>" ><?php echo $shops['title']; ?></a></p>
					<p>&nbsp;</p>
					<p><span ><?php if($shops['inventory'] <= '5' ): ?>剩余<span style="color:red;"><?php echo $shops['inventory']; ?></span>件<?php endif; ?></span></p>	
				<td>￥<?php echo $shops['money']; ?></td>
				<td>
					<dl class="add" style="padding:0;display:inline-block;">					
						<dd>
							<input type="type" val="<?php echo $shops['id']; ?>" onkeyup="value=value.replace(/\D/g,'')" value="<?php echo $shops['cart_gorenci']; ?>" name="general_amount" class="g_amount" />
						</dd>
						<dd>
							<a href="JavaScript:;" val="<?php echo $shops['id']; ?>" class="g_jia"></a>
							<a href="JavaScript:;" val="<?php echo $shops['id']; ?>" class="g_jian"></a>
						</dd>
					</dl>
				</td>
				<td><i class="g_xj"><?php echo $shops['cart_xiaoji']; ?></i></td>
				<td><a href="javascript:;" onclick="delcart(<?php echo $shops['id']; ?>)"  class="delgood">删除</a></td>
			</tr>
		<?php  endforeach; $ln++; unset($ln); ?>
		</tbody>
	</table>
	<?php endif; ?>
	
	<?php if($generalList || $yunlist): ?>
	<table class="cardlist_table">
		<tbody>
			<tr>
				<td style="text-align:right;"><?php echo _cfg('web_name_two'); ?>金额总计:￥<span id="moenyCount" class="total_money"><?php echo $MoenyCount; ?></span></td>
			</tr>
			<tr style="line-height:90px;">
				<td class="operate" style="text-align:right;">
						<a href="<?php echo WEB_PATH; ?>" id="but_on"></a>
						<input id="but_ok" type="button" value=""  name="submit"/>
				</td>
			</tr>
		</tbody>
	</table>
	<?php endif; ?>
</div>  
<script type="text/javascript"> 
var info=<?php echo $Cartshopinfo; ?>;
var numberadd=$(".jia");
var numbersub=$(".jian");
var xiaoji=$(".xj");
var num=$(".amount");
var message=$(".message");
var moenyCount=$("#moenyCount");
var g_jia=$(".g_jia");
var g_jian=$(".g_jian");
var g_amount=$(".g_amount");
var g_xj=$(".g_xj");

$(function(){
	$("#but_ok").click(function(){
		var countmoney=parseInt(moenyCount.text());
		if(countmoney > 0){		
			//$.cookie('Cartlist','',{path:'/'});
			$.cookie('Cartlist',$.toJSON(info),{expires:7,path:'/'});
			document.location.href='<?php echo WEB_PATH; ?>/member/cart/pay/'+new Date().getTime();
		}else{
			alert("购物车为空!");
		}
	});
});
function UpdataMoney(shopid,number,zindex){		
		var number = parseInt(number);
		info['MoenyCount']=info['MoenyCount']-info.yun[shopid]['money']*info.yun[shopid]['num']+info.yun[shopid]['money']*number;
		info.yun[shopid]['num']=number;
		var xjmoney=xiaoji.eq(zindex);
			xjmoney.text(info.yun[shopid]['money']*number+'.00');
			moenyCount.text(info['MoenyCount']+'.00');
}


function delcart(id){
	info['MoenyCount'] = info['MoenyCount']-info.yun[id]['money']*info.yun[id]['num'];
	$("#yunList"+id).hide();
	$("#moenyCount").text(info['MoenyCount']+".00");
	delete info.yun[id];
	$.cookie('Cartlist',$.toJSON(info),{expires:30,path:'/'});
}

num.keyup(function(){
	var shopid=$(this).attr("val");
	var zindex=num.index(this);	
	//if(!$('.yun_check').eq(zindex).prop('checked'))  return false;
	if($(this).val() > info.yun[shopid]['shenyu']){
		layer.msg("购买次数不能超过"+info.yun[shopid]['shenyu']+"次");		
		$(this).val(info.yun[shopid]['shenyu']);
		UpdataMoney(shopid,$(this).val(),zindex);		
		return;
	}
	if($(this).val()<1){
		layer.msg("购买次数不能少于1次");
		$(this).val(1);
		UpdataMoney(shopid,$(this).val(),zindex);
		return;
	}	
	UpdataMoney(shopid,$(this).val(),zindex);	
});
numberadd.click(function(){
	var shopid=$(this).attr('val');		
	var zindex=numberadd.index(this);
	//if(!$('.yun_check').eq(zindex).prop('checked'))  return false;
	var thisnum=num.eq(zindex);	
		if(info.yun[shopid]['num'] >= info.yun[shopid]['shenyu']){
			layer.msg("购买次数不能超过"+info.yun[shopid]['shenyu']+"次");
			return;
		}
		var number=parseInt(info.yun[shopid]['num'])+1;			
			thisnum.val(number);
			UpdataMoney(shopid,number,zindex);
});
numbersub.click(function(){
	var shopid=$(this).attr('val');		
	var zindex=numbersub.index(this);
	//if(!$('.yun_check').eq(zindex).prop('checked'))  return false;
	var thisnum=num.eq(zindex);	
		if(info.yun[shopid]['num'] <=1){
			layer.msg("购买次数不能少于1次");
			return;
		}
		var number=parseInt(info.yun[shopid]['num'])-1;		
			thisnum.val(number);
			UpdataMoney(shopid,number,zindex);
});

/**
*	@普通商品
*/
function UpdataMoneys(shopid,number,zindex){		
		var number = parseInt(number);
		info['MoenyCount']=info['MoenyCount']-info.general[shopid]['money']*info.general[shopid]['num']+info.general[shopid]['money']*number;
		info.general[shopid]['num']=number;
		var xjmoney=g_xj.eq(zindex);
			xjmoney.text(info.general[shopid]['money']*number+'.00');
			moenyCount.text(info['MoenyCount']+'.00');
}


function delcarts(id){
	info['MoenyCount'] = info['MoenyCount']-info.general[id]['money']*info.general[id]['num'];
	$("#generalList"+id).hide();
	$("#moenyCount").text(info['MoenyCount']+".00");
	delete info.general[id];
	$.cookie('Cartlist',$.toJSON(info),{expires:30,path:'/'});
}

g_amount.keyup(function(){
	var shopid=$(this).attr("val");
	var zindex=g_amount.index(this);
	//if(!$('.general_check').eq(zindex).prop('checked'))  return false;
	if($(this).val() > info.general[shopid]['inventory']){
		layer.msg("购买个数不能超过"+info.general[shopid]['inventory']+"次");		
		$(this).val(info.general[shopid]['inventory']);
		UpdataMoneys(shopid,$(this).val(),zindex);		
		return;
	}
	if($(this).val()<1){
		layer.msg("购买个数不能少于1次");
		$(this).val(1);
		UpdataMoneys(shopid,$(this).val(),zindex);
		return;
	}	
	UpdataMoneys(shopid,$(this).val(),zindex);	
});
g_jia.click(function(){
	var shopid=$(this).attr('val');		
	var zindex=g_jia.index(this);
	//if(!$('.general_check').eq(zindex).prop('checked'))  return false;
	var thisnum=g_amount.eq(zindex);	
		if(info.general[shopid]['num'] >= info.general[shopid]['inventory']){
			layer.msg("购买个数不能超过"+info.general[shopid]['inventory']+"次");
			return false;
		}	
		var number=parseInt(info.general[shopid]['num'])+1;				
			thisnum.val(number);
			UpdataMoneys(shopid,number,zindex);
});
g_jian.click(function(){
	var shopid=$(this).attr('val');		
	var zindex=g_jian.index(this);
	//if(!$('.general_check').eq(zindex).prop('checked'))  return false;
	var thisnum=g_amount.eq(zindex);	
		if(info.general[shopid]['num'] <=1){
			layer.msg("购买个数不能少于1次");
			return false;
		}
		var number=parseInt(info.general[shopid]['num'])-1;			
			thisnum.val(number);
			UpdataMoneys(shopid,number,zindex);
});
/*
$('#card_check').click(function(){
	var checked = $("input[id='card_check']").prop('checked');
	$('.yun_check').each(function(){
		var checkeds = $(this).prop('checked');
		if(checked != checkeds) {
			var thisnum = num.eq($('.general_check').index(this));
			var check_num = thisnum.val();
			var shopid = $(this).val();
			var thismoney = info.yun[shopid]['money'] * check_num;
			var new_money_count;
			if(checked){
				info.yun[shopid]['sign']='1';
				info.yun[shopid]['num'] = check_num;
				info['MoenyCount'] += thismoney;
			}else{
				info.yun[shopid]['sign']='0';
				info.yun[shopid]['num']='0';
				info['MoenyCount'] -= thismoney;
			}
		}
	});
	$('.general_check').each(function(){
		var checkeds = $(this).prop('checked');
		if(checked != checkeds) {
			var thisnum = g_amount.eq($('.general_check').index(this));
			var check_num = thisnum.val();
			var shopid = $(this).val();
			var thismoney = info.general[shopid]['money'] * check_num;
			if(checked){
				info.general[shopid]['sign']='1';
				info.general[shopid]['num'] = check_num;
				info['MoenyCount'] += thismoney;
			}else{
				info.general[shopid]['sign']='0';
				info.general[shopid]['num']='0';
				info['MoenyCount'] -= thismoney;
			}
		}
	});
	moenyCount.text(info['MoenyCount']+'.00');
	$("input[id='yun_check']").prop('checked', $(this).prop("checked"));
	$("input[class='yun_check']").prop('checked', $(this).prop("checked"));
	$("input[id='general_check']").prop('checked', $(this).prop("checked"));
	$("input[class='general_check']").prop('checked', $(this).prop("checked"));
});

$('#yun_check').click(function(){
	var checked = $("input[id='yun_check']").prop('checked');
	$('.yun_check').each(function(){
		var checkeds = $(this).prop('checked');
		if(checked != checkeds) {
			var thisnum = num.eq($('.general_check').index(this));
			var check_num = thisnum.val();
			var shopid = $(this).val();
			var thismoney = info.yun[shopid]['money'] * check_num;
			var new_money_count;
			if(checked){
				info.yun[shopid]['sign']='1';
				info.yun[shopid]['num'] = check_num;
				info['MoenyCount'] += thismoney;
			}else{
				info.yun[shopid]['sign']='0';
				info.yun[shopid]['num']='0';
				info['MoenyCount'] -= thismoney;
			}
		}
	});
	$("input[class='yun_check']").prop('checked', $(this).prop("checked"));
	moenyCount.text(info['MoenyCount']+'.00');
});

$('.yun_check').click(function(){
	var checked = $(this).prop('checked');
	var moneyCount = parseInt(moenyCount.text());
	var thisnum = num.eq($('.yun_check').index(this));
	var check_num = thisnum.val();
	var shopid = $(this).val();
	var thismoney = info.yun[shopid]['money'] * check_num;
	var new_money_count;
	if(checked){
		info.yun[shopid]['sign']='1';
		info.yun[shopid]['num'] = check_num;
		info['MoenyCount'] += thismoney;
	}else{
		info.yun[shopid]['sign']='0';
		info.yun[shopid]['num'] = '0';
		info['MoenyCount'] -= thismoney;
	}
	moenyCount.text(info['MoenyCount']+'.00');
});

$('#general_check').click(function(){
	var checked = $("input[id='general_check']").prop('checked');	
	$('.general_check').each(function(){
		var checkeds = $(this).prop('checked');
		if(checked != checkeds) {
			var thisnum = g_amount.eq($('.general_check').index(this));
			var check_num = thisnum.val();
			var shopid = $(this).val();
			var thismoney = info.general[shopid]['money'] * check_num;
			if(checked){
				info.general[shopid]['sign']='1';
				info.general[shopid]['num'] = check_num;
				info['MoenyCount'] += thismoney;
			}else{
				info.general[shopid]['sign']='0';
				info.general[shopid]['num']='0';
				info['MoenyCount'] -= thismoney;
			}
		}
	});
	$("input[class='general_check']").prop('checked', $(this).prop("checked"));
	moenyCount.text(info['MoenyCount']+'.00');
});

$('.general_check').click(function(){
	var checked = $(this).prop('checked');
	var moneyCount = parseInt(moenyCount.text());
	var thisnum = g_amount.eq($('.general_check').index(this));
	var check_num = parseInt(thisnum.val());
	var shopid = $(this).val();
	var thismoney = info.general[shopid]['money'] * check_num;
	if(checked){
		info.general[shopid]['sign']='1';
		info.general[shopid]['num'] = check_num;
		info['MoenyCount'] += thismoney;
	}else{
		info.general[shopid]['sign']='0';
		info.general[shopid]['num'] = '0';
		info['MoenyCount'] -= thismoney;
	}
	moenyCount.text(info['MoenyCount']+'.00');
});*/
</script> 
<!--footer 开始-->
<?php include templates("index","footer");?>