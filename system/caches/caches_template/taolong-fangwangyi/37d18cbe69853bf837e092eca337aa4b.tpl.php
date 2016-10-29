<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><?php include templates("index","header");?>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/GoodsDetail.css"/>
<!--link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/header.css"/-->
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/js/cloud-zoom.css"/>
<script type="text/javascript" src="<?php echo G_TEMPLATES_STYLE; ?>/js/cloud-zoom.min.js"></script>
<script type="text/javascript">
$.fn.CloudZoom.defaults = {
	zoomWidth: '400',
	zoomHeight: '310',
	position: 'right',
	tint: false,
	tintOpacity: 0.5,
	lensOpacity: 0.5,
	softFocus: false,
	smoothMove: 7,
	showTitle: false,
	titleOpacity: 0.5,
	adjustX: 0,
	adjustY: 0
};
</script>
<style type="text/css">
.zoom-section{clear:both;margin-top:20px;}
.zoom-small-image{border:2px solid #dedede;float:left;margin-bottom:20px; width:400px; height:400px;}
.zoom-small-image img{ width:400px; height:400px;}
.zoom-desc{float:left;width:404px; height:52px;margin-bottom:20px; overflow:hidden;}
.zoom-desc p{ width:10000px; height:52px; float:left; display:block; position:absolute; top:0; z-index:3; overflow:hidden;}
.zoom-desc label{ width:50px; height:52px; margin:0 5px 0 0; _margin-right:4px; display:block; float:left; overflow:hidden;}
.zoom-tiny-image{border:1px solid #CCC;margin:0px; width:48px; height:50px;}
.zoom-tiny-image:hover{border:1px solid #C00;}
</style>
<div class="Current_nav">
	<a href="<?php echo WEB_PATH; ?>">首页</a> <span>&gt;</span> 
	<a href="<?php echo WEB_PATH; ?>/goods_list/<?php echo $item['cateid']; ?>">
	<?php echo $category['name']; ?>
	</a><span>&gt;</span> 
	<a href="<?php echo WEB_PATH; ?>/goods_list/<?php echo $item['cateid']; ?>e<?php echo $item['brandid']; ?>">
	<?php echo $brand['name']; ?>
	</a> <span>&gt;</span>商品详情
</div>
<div class="show_content">
	<!-- 商品信息 -->
	<div class="Pro_Details">
		<!-- <h1><span ><?php echo $item['title']; ?></span><span style="<?php echo $item['title_style']; ?>;color:#f08200"><?php echo $item['title2']; ?></span></h1> -->
		<div class="Pro_Detleft" style="margin-top:15px;">
			<div class="zoom-small-image">
				<span href="<?php echo G_UPLOAD_PATH; ?>/<?php echo $item['thumb']; ?>" class = 'cloud-zoom' id='zoom1' rel="adjustX:10, adjustY:-2">
					<img width="80px" height="80px" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $item['thumb']; ?>" />
				</span>
			</div>

			<div class="zoom-desc"> 
				<div class="jcarousel-prev jcarousel-prev-disabled"></div>
				<div class="jcarousel-clip" style="height:55px;width:384px;">
				<p>
					<label href="<?php echo G_UPLOAD_PATH; ?>/<?php echo $item['thumb']; ?>" class='cloud-zoom-gallery'  rel="useZoom: 'zoom1', smallImage: '<?php echo G_UPLOAD_PATH; ?>/<?php echo $item['thumb']; ?>'">
						<img class="zoom-tiny-image" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $item['thumb']; ?>" />
					</label>
					<?php $ln=1;if(is_array($item['picarr'])) foreach($item['picarr'] AS $imgtu): ?>                  
					<label href="<?php echo G_UPLOAD_PATH; ?>/<?php echo $imgtu; ?>" class='cloud-zoom-gallery'  rel="useZoom: 'zoom1', smallImage: '<?php echo G_UPLOAD_PATH; ?>/<?php echo $imgtu; ?>'">
						<img class="zoom-tiny-image" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $imgtu; ?>" />
					</label>			
					<?php  endforeach; $ln++; unset($ln); ?> 
				</p>
				</div>
				<div class="jcarousel-next jcarousel-next-disabled"></div>
			</div>
			<script>
				var si=$(".jcarousel-clip label").size();
				var label=si*55;
				$(".jcarousel-clip p").css({width:label,left:"0"});
				if(label>395){
					$(".jcarousel-prev,.jcarousel-next").show();
				}else{
					$(".jcarousel-prev,.jcarousel-next").hide();
				}
				$(".jcarousel-prev").click(function(){
					var le=$(".jcarousel-clip p").css("left");
					var le2=le.replace(/px/,"");
					if(le!='0px'){
						$(".jcarousel-clip p").css({left:le2*1+55});
					}						
				})
				$(".jcarousel-next").click(function(){
					var le=$(".jcarousel-clip p").css("left");
					var le2=le.replace(/px/,"");
					var max_next=-(si-7)*55+"px";
					if(le!=max_next){						
						$(".jcarousel-clip p").css({left:le2*1-55});
					}
				})
			</script>	
		</div>
		<div class="Pro_Detright">
			<h1><span ><?php echo $item['title']; ?></span><span style="<?php echo $item['title_style']; ?>;color:#f08200"><?php echo $item['title2']; ?></span></h1>
			<p class="Det_money">价格：<span class="rmbgray"><?php echo $item['money']; ?></span></p>
			 <!-- <p class="Pro_Detsingle" style="font-size:14px;">价格：<b style="color:#999;"><?php echo $item['money']; ?></b></p>  -->
			<div id="divNumber" class="Pro_number">
				数量： 
				<a href="javascript:;" class="num_del num_ban" id="shopsub">-</a>
				<input style="border:1px solid #CFCFCF" type="text" value="1" maxlength="7" onKeyUp="value=value.replace(/\D/g,'')" class="num_dig" id="num_dig"/>
				<a href="javascript:;" class="num_add" id="shopadd">+</a>个 
			</div>
			<div class="property">
				<?php $ln=1;if(is_array($property)) foreach($property AS $val): ?>
					<p>
					<?php echo $val['property']; ?>：
					<?php $ln=1;if(is_array($val['val'])) foreach($val['val'] AS $info): ?>
						<span><a href="javascript:void(0);"><?php echo $info; ?></a><i></i></span>
					<?php  endforeach; $ln++; unset($ln); ?>
					</p>
				<?php  endforeach; $ln++; unset($ln); ?>
			</div>
			<div style="display:none;" id="hqid"><?php echo $item['id']; ?></div>
			<div id="divBuy" class="Det_button">
            	<?php if($item['inventory'] == '0'): ?>
                <a href="javascript:;" class="Det_Shopbut_exit">已售完</a>
                <?php  else: ?>
				<a href="javascript:;" class="Det_Shopbut">立即购买</a>
                <?php endif; ?>
				<a href="javascript:;" class="Det_Cart">加入购物车</a>
			</div>
			<div class="Security">
				<ul>
					<li><a href="<?php echo WEB_PATH; ?>/help/4" target="_blank"><i></i>100%公平公正</a></li>
					<li><a href="<?php echo WEB_PATH; ?>/help/5" target="_blank"><s></s>100%正品保证</a></li>
					<li><a href="<?php echo WEB_PATH; ?>/help/7" target="_blank"><b></b>全国免费配送</a></li>
				</ul>
			</div>			
		</div>
	</div>
</div>

<!-- 商品信息导航 -->
<div class="ProductTabNav">
	<div id="divProductNav" class="DetailsT_Tit">
		<div class="DetailsT_TitP">
			<ul>
				<li class="Product_DetT DetailsTCur"><span class="DetailsTCur">商品详情</span></li>
				<li class="all_comment" style="width:98px;"><span class="">评价</span></li>
			</ul>
			<!-- <p><a id="btnAdd2Cart" href="javascript:;" class="white DetailsT_Cart"><s></s>加入购物车</a></p> -->
		</div>
	</div>
</div>

<!--补丁3.1.6_b.0.1-->
<div id="divContent" class="Product_Content">
	<!-- 商品内容 -->
	<div class="Product_Con"><?php echo $item['content']; ?></div>
    <!-- 商品内容 -->
    
    <!-- 评价20条 -->
	<div id="all_comment" class="AllRecordCon">
		<iframe id="iframea_bitem" g_src="<?php echo WEB_PATH; ?>/go/goods/go_record_ifram/<?php echo $itemid; ?>/20" style="width:978px; border:none;height:100%" frameborder="0" scrolling="no"></iframe>		
	</div>	
   <!-- /评价20条 -->

</div>


<script type="text/javascript">
<!--补丁3.1.6_b.0.2-->
function set_iframe_height(fid,did,height){	
	$("#"+fid).css("height",height);	
}

$(function(){
	$("#ulRecordTab li").click(function(){
		var add=$("#ulRecordTab li").index(this);
		$("#ulRecordTab li").removeClass("Record_titCur").eq(add).addClass("Record_titCur");
		$(".Pro_Record .hide").hide().eq(add).show();
	});
	
	var DetailsT_TitP = $(".DetailsT_TitP ul li");
	var divContent    = $("#divContent div");	
	DetailsT_TitP.click(function(){
		var index = $(this).index();
			DetailsT_TitP.removeClass("DetailsTCur").eq(index).addClass("DetailsTCur");
	
			var iframe = divContent.hide().eq(index).find("iframe");
			if (typeof(iframe.attr("g_src")) != "undefined") {
			  	 iframe.attr("src",iframe.attr("g_src"));
				 iframe.removeAttr("g_src");
			}
			divContent.hide().eq(index).show();
	});
	<!--补丁3.1.6_b.0.2-->
	
	
	$("#btnUserBuyMore").click(function(){
		$("#liUserBuyAll").click();
		$("html,body").animate({scrollTop:941},1500);
	});
	$(window).scroll(function(){
		if($(window).scrollTop()>=941){
			$("#divProductNav").addClass("nav-fixed");
		}else if($(window).scrollTop()<941){
			$("#divProductNav").removeClass("nav-fixed");
		}
	});
})
var shopinfo={'shopid':<?php echo $item['id']; ?>,'money':<?php echo $item['money']; ?>,'shenyu':<?php echo $syrs; ?>};
<!--补丁查看更多-->
	
$(function(){
	var shopnum = $("#num_dig");
	var max_num = parseInt(shopinfo['shenyu']);
	shopnum.keyup(function(){
		if(shopnum.val() >= max_num){
			shopnum.val(max_num);
		}
	});
	
	$("#shopadd").click(function(){
		var shopnum = $("#num_dig");
			var num = parseInt(shopnum.val());
			if(num >= max_num){
				shopnum.val(max_num);
			}else{
				shopnum.val(parseInt(shopnum.val())+1);
			}
	});
	$("#shopsub").click(function(){
		var shopnum = $("#num_dig");
		var num = parseInt(shopnum.val());
		if(num < 2){
			shopnum.val(1);			
		}else{
			shopnum.val(parseInt(shopnum.val())-1);
		}
	});
});

$(function(){
	$(".Det_Cart").click(function(){
		//添加到购物车动画
		var src=$("#zoom1 img").attr('src');  
		var $shadow = $('<img id="cart_dh" style="display: none; border:1px solid #aaa; z-index: 99999;" width="400" height="400" src="'+src+'" />').prependTo("body"); 
		var $img = $(".mousetrap").first("img");
		$shadow.css({ 
		   'width' : $img.css('width'), 
		   'height': $img.css('height'),
		   'position' : 'absolute',      
		   'top' : $img.offset().top,
		   'left' : $img.offset().left, 
		   'opacity' :1    
		}).show();
		var $cart =$("#btnMyCart");
		var numdig=$(".num_dig").val();
		$shadow.animate({   
			width: 1, 
			height: 1, 
			top: $cart.offset().top, 
			left: $cart.offset().left,
			opacity: 0
		},500,function(){
			Cartcookie(false);
		});		
	});
	$(".Det_Shopbut").click(function(){
		Cartcookie(true);
	});	
});

function Cartcookie(cook){
	var shopid = shopinfo['shopid'];
	var number=parseInt($("#num_dig").val());
	if(number<=1){number=1;}
	var Cartlist = $.cookie('Cartlist');
	if(!Cartlist){
		var info = {yun:{},general:{}};
	}else{
		var info = $.evalJSON(Cartlist);
		if((typeof info) !== 'object'){
			var info = {yun:{},general:{}};
		}
	}
	if(!info.general[shopid]){
		var CartTotal=$("#sCartTotal").text();
			$("#sCartTotal").text(parseInt(CartTotal)+1);
			$("#btnMyCart em").text(parseInt(CartTotal)+1);
	}	
	info.general[shopid]={};
	info.general[shopid]['num']=number;
	info.general[shopid]['shenyu']=shopinfo['shenyu'];
	info.general[shopid]['money']=shopinfo['money'];
	info.general[shopid]['sign']=1;
	info['MoenyCount']='0.00';	
	$.cookie('Cartlist',$.toJSON(info),{expires:7,path:'/'});
	if(cook){
		window.location.href="<?php echo WEB_PATH; ?>/member/cart/cartlist/"+new Date().getTime();//+new Date().getTime()
	}
}
$(function(){
	$("#num_dig").mousemove(function(){
	  $(this).css("border","1px solid #ca1b38");		 
	});
	 $("#num_dig").mouseout(function(){
	  $(this).css("border","1px solid #CFCFCF");		 
	});	
	$('.property p a').click(function(){
		$(this).parent().addClass('selected').siblings().removeClass('selected');
	})
});
</script> 

<?php include templates("index","footer");?>