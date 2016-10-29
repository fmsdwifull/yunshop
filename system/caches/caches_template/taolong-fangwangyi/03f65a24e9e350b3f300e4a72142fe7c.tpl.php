<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><?php include templates("index","header");?>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/Home.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/GoodsList.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/Comm.css"/>
<!--<link rel="stylesheet" type="text/css" href="<?php echo G_TEMPLATES_STYLE; ?>/css/header.css"/>-->

<script>
function showh(){
var height=$("#ddBrandList_brand").innerHeight();	
	if(height==78){
		$("#ddBrandList_brand").css("height","auto");
		$(".list_classMore").addClass("MoreClick");
		$(".list_classMore").html("收起<i></i>");
	}else{
		$("#ddBrandList_brand").css("height","78px");
		$(".list_classMore").removeClass("MoreClick");
		$(".list_classMore").html("展开<i></i>");
	};
}
$(function(){	
	$(".list_classMore").click(showh);
});
</script>
<div class="wrap" id="loadingPicBlock">
	<div class="Current_nav"><a  style="padding:15px;padding-right:15px;" href="<?php echo WEB_PATH; ?>">首页</a> &gt; <?php echo $daohang_title; ?></div>
	<div id="current" class="list_Curtit">
		<h1 class="fl" style="color:#f08200"><?php echo $daohang_title; ?></h1>
		<span id="spTotalCount">(共<em class="orange" style="color:#f08200"><?php echo $total; ?></em>件相关商品)</span>
	</div>	
	<?php 
		if($cid){
			$two_cate_list = $this->db->GetList("select cateid,parentid,name from `@#_category` where `parentid` = '$cid' order by `order` DESC");
			if(!$two_cate_list && $daohang['parentid'])
			$two_cate_list = $this->db->GetList("select cateid,parentid,name from `@#_category` where `parentid` = '$daohang[parentid]' order by `order` DESC");
		}else{
			$two_cate_list = $this->db->GetList("select cateid,parentid,name from `@#_category` where `model` = '1' and `parentid` = '0' order by `order` DESC");
		}
	 ?>
	<?php if(!empty($two_cate_list)): ?>
	<div class="list_class">
	<dl>
		<dt>分类</dt>
		<dd id="ddBrandList">
			<ul>            
				<?php if(isset($daohang['parentid'])): ?>
				<li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $daohang['parentid']; ?>_0_0">全部</a></li>
                <?php  else: ?>
                <li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_0_0" class="ClassCur" >全部</a></li>
                <?php endif; ?>
		
				<?php $ln=1;if(is_array($two_cate_list)) foreach($two_cate_list AS $two_cate): ?>
					<?php if($cid == $two_cate['cateid']): ?>
					<li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $two_cate['cateid']; ?>_0_0" class="ClassCur"><?php echo $two_cate['name']; ?></a></li>
					<?php  else: ?>
					<li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $two_cate['cateid']; ?>_0_0"><?php echo $two_cate['name']; ?></a></li>
					<?php endif; ?>
				<?php  endforeach; $ln++; unset($ln); ?>
			</ul>
		</dd>
	</dl>
	</div>	
	<?php endif; ?>
	
	<div class="list_class">
	<dl>
		<dt>品牌</dt>
		<?php if(count($brand)>17): ?>
		<dd id="ddBrandList_brand" style="height:78px">
		<?php  else: ?>
		<dd id="ddBrandList_brand">
		<?php endif; ?>
			<ul>
            	<?php if(!$bid): ?>
				<li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_0_<?php echo $order; ?>" class="ClassCur" style="background:#f08200">全部</a></li> 
                <?php  else: ?>
                <li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_0_<?php echo $order; ?>" style="color:#f08200">全部</a></li>
                <?php endif; ?>				
				<?php $ln=1;if(is_array($brand)) foreach($brand AS $brands): ?>             
				<?php if($brands['id'] == $bid): ?>
				<li><a class="ClassCur" href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $brands['id']; ?>_<?php echo $order; ?>"><?php echo $brands['name']; ?></a></li>   
				<?php  else: ?>
				<li><a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $brands['id']; ?>_<?php echo $order; ?>"><?php echo $brands['name']; ?></a></li>   
				<?php endif; ?>
				<?php  endforeach; $ln++; unset($ln); ?>
			</ul>
		</dd>
	</dl>

	<?php if(count($brand)>17): ?>	
	<a class="list_classMore" href="javascript:;">展开<i></i></a>
	<?php endif; ?>	
	</div>
	    <div class="list_Sort">
		    <dl>
			    <dt>排序</dt>
			    <dd>
                <a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $bid; ?>_2" <?php if($order=='2'): ?>class="SortCur"<?php endif; ?>>人气</a>
                <a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $bid; ?>_4" <?php if($order=='4'): ?>class="SortCur"<?php endif; ?>>最新</a>
                <?php if($order=='5'): ?>
                <a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $bid; ?>_6" class="Price_Sort SortCur">价格 <i></i></a>
                <?php  else: ?>
                    <?php if($order=='6'): ?>
                   		<a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $bid; ?>_5" class="Price_Sort SortCur">价格 <s></s></a>
                    <?php  else: ?>
                    	<a href="<?php echo WEB_PATH; ?>/general_glist/<?php echo $cid; ?>_<?php echo $bid; ?>_5" class="Price_Sort">价格 <s></s></a>
                    <?php endif; ?>
                <?php endif; ?>
                </dd>
		    </dl>
	    </div>
	
	<?php if($shoplist): ?>
	<!--商品列表-->
	<div class="listContent">
		<ul class="item" id="ulGoodsList">		
			<?php $ln=1;if(is_array($shoplist)) foreach($shoplist AS $shop): ?>
			<li class="goods-iten" >
				<div class="pic">
					<a href="<?php echo WEB_PATH; ?>/g_goods/<?php echo $shop['id']; ?>" target="_blank" title="<?php echo $shop['title']; ?> ">
                    	<!--补丁3.1.5_b.0.1-->                    	 
                    	<?php $i_googd_bj = null; ?>        
                        <!--补丁3.1.5_b.0.1-->
                        <?php if($shop['pos'] =='1' && !isset($i_googd_bj)): ?>						
                       	 	<?php $i_googd_bj = '<i class="goods_tj"></i>'; ?>	
						<?php endif; ?>
						<?php if($shop['renqi']=='1' && !isset($i_googd_bj)): ?>						
                                <?php $i_googd_bj = '<i class="goods_rq"></i>'; ?>				
						<?php endif; ?>	
						<?php echo $i_googd_bj; ?>
										
						<img alt="<?php echo $shop['title']; ?>" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $shop['thumb']; ?>">
					</a>
					<p name="buyCount" style="display:none;"></p>
				</div>
				<p class="name">
					<a href="<?php echo WEB_PATH; ?>/g_goods/<?php echo $shop['id']; ?>" target="_blank" title="<?php echo $shop['title']; ?> "><?php echo $shop['title']; ?></a>
				</p>
				<p class="money">价格：<span class="rmbgray"><?php echo $shop['money']; ?></span></p>
				<div class="gl_buybtn">
					<div class="go_buy">
						<a href="javascript:;" title="立即购买" class="go_Shopping fl">立即购买</a>
						<a href="javascript:;" title="购物车" class="go_cart fr">加入购物车</a>
					</div>
				</div>
				
				<div class="Curbor_id" style="display:none;"><?php echo $shop['id']; ?></div>
				<div class="Curbor_money" style="display:none;"><?php echo $shop['money']; ?></div>
			</li>
			<?php  endforeach; $ln++; unset($ln); ?>
		</ul>
	<?php if($total>$num): ?>
	<div class="pagesx"><?php echo $page->show('two'); ?></div>
	<?php endif; ?>
	</div>
	<!--商品列表完-->
	<?php  else: ?>
	<!--未找到商品-->
	<div class="NoConMsg"><span>无相关商品记录哦~！</span></div>
	<!--未找到商品-->
	<?php endif; ?>
	
</div>
<script type="text/javascript">

$(function(){
//商品购物车
	$("#ulGoodsList li a.go_cart").click(function(){ 
		var sw = $("#ulGoodsList li a.go_cart").index(this);	
		var src = $("#ulGoodsList li .pic a img").eq(sw).attr('src');				
		var $shadow = $('<img id="cart_dh" style="display:none; border:1px solid #aaa; z-index:99999;" width="200" height="200" src="'+src+'" />').prependTo("body");  			
		var $img = $("#ulGoodsList li .pic").eq(sw);
		$shadow.css({ 
			'width' : 200, 
			'height': 200, 
			'position' : 'absolute',      
			"left":$img.offset().left+16, 
			"top":$img.offset().top+9,
			'opacity' : 1    
		}).show();
		
		//顶部购物车显示数目
		var $cart = $("#cartCount");

		$shadow.animate({   
			width: 1, 
			height: 1, 
			top: $cart.offset().top,    
			left: $cart.offset().left, 
			opacity: 0
		},500,function(){
			Cartcookie(sw,false);
		});	
		
	});
	$("#ulGoodsList li a.go_Shopping").click(function(){	
		var sw = $("#ulGoodsList li a.go_Shopping").index(this);
		Cartcookie(sw,true); 
	});	
});
//存到COOKIE
function Cartcookie(sw,cook){

//$.cookie('Cartlist',null,{expires:-30,path:'/'});
	var shopid = $(".Curbor_id").eq(sw).text(),
		money = $(".Curbor_money").eq(sw).text();
	var Cartlist = $.cookie('Cartlist');
//console.log(Cartlist);
	if(!Cartlist){
		var info = {yun:{},general:{}};
	}else{
		var info = $.evalJSON(Cartlist);
	}
	if(!info.general[shopid]){
		var CartTotal=$("#sCartTotal").text();			
		$("#sCartTotal").text(parseInt(CartTotal)+1);			
		$("a#btnMyCart em").text(parseInt(CartTotal)+1);
	}
	info.general[shopid]={};
	info.general[shopid]['num']=1;
	info.general[shopid]['sign']=1;
	info.general[shopid]['money']=money;
	info['MoenyCount']='0.00';
//console.log(info);	// return false;
cartCount();
	$.cookie('Cartlist',$.toJSON(info),{expires:30,path:'/'});
	if(cook){
		window.location.href="<?php echo WEB_PATH; ?>/member/cart/cartlist";
	}
} 
</script>
<?php include templates("index","footer");?>