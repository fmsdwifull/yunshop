<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><div class="Left-fixed-divs" style="height: 933px;">
	<ul>
		<li class="shoppingCartRightFix Left-fixed-divs3">
			<a href="<?php echo WEB_PATH; ?>/member/cart/cartlist">
				<i></i>
				<em>购</em>
				<em>物</em>
				<em>车</em>
				<em id="cartCount"></em>
			</a>
		</li>
		<li class="YonlineService otherlifix"><a hidefocus="true" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo _cfg("qq"); ?>&site=qq&menu=yes" target="_blank"><i style="margin-left:12px;"></i><em>在线</em><em>客服</em></a></li>
		<li class="otherlifix otherlifixw">
			<a hidefocus="true" href="javascript:void 0">
				<i style="background-position:-168px -176px;"></i>
				<em>官方</em>
				<em>微信</em>
			</a>
			<img width="188" height="216" src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/cloud_kik.jpg">
			<s></s>
		</li>
		<!--<li class="otherlifix otherlifixw">
			<a hidefocus="true" href="javascript:void(0)">
				<i style="margin-left:12px;margin-top:0;background-position:-203px -172px;height: 27px;margin-bottom:0;"></i>
				<em>手机</em><em>App</em>
			</a>
			 <img width="188" height="188" src="/static/img/front/index/weixinlogo.png" style="border:1px solid #adadad;"> 
			
		</li>-->
		<li class="otherlifix">
			<a hidefocus="true" href="<?php echo WEB_PATH; ?>/member/home/userrecharge">
				<i style="margin-left:12px;background-position:-236px -176px;"></i>
				<em>快速</em><em>充值</em>
			</a>
		</li>
		<li class="otherlifix lifixTop">
			<i style="background-position:-276px -170px"></i>
			<em>置</em><em>顶</em>
		</li>
	</ul>
</div>
<!-- 右侧悬浮 end -->
<!-- 右侧悬浮 -->
<!-- 滑过右侧购物车时未登录时的登陆框 -->

<!-- 滑过右侧购物车时登录后的列表 -->
<div class="Left-fixed-divs2 Left-fixed-divs3" style="height: 933px; display: none;">
	<!-- 无商品时 -->
	 <p id="noCart" class="yNocommodity" style="line-height: 933px;">你的购物车还是空的赶紧行动吧！</p> 

	<!-- 购物袋有商品 start -->
	<dl id="carshoplist">
	</dl>
	<div class="fixed-divbottom">
		<p>已选<span id="row">0</span>件商品 <span class="yflr">￥<em id="hpriceTotal">0</em>元</span></p>
		<a href="<?php echo WEB_PATH; ?>/member/cart/cartlist">结 算</a>
	</div>
</div>
<!-- 购物袋有商品 end -->

<script type="text/javascript">
$(function(){
	$(window).resize(function(){
		$(".yungouworld_wx").click(function(){
			$("#y_modalWeixin").fadeIn(500);
			$(".y_modalWeixinBJ").fadeIn(500);
			$(".y_modalWeixinBJ").css({width:$(window).width()+"px",height:$(window).height()+"px"});
			$("#y_modalWeixin").css({left:($(window).width()-480)/2+"px",top:($(window).height()-520)/2+"px"});
		})	
		$(".ymodal-close").click(function(){	
			$("#y_modalWeixin").css({top:"0px"});
			$("#y_modalWeixin").fadeOut(500);
			$(".y_modalWeixinBJ").fadeOut(500);
		})
	});

	$.ajax({
		url:"<?php echo WEB_PATH; ?>/api/fund/get",
		success:function(msg){
			$("#spanFundTotal").text('￥'+msg);
		}
	});

	cartCount();

	$("#txtSearch").focus(function(){
		$("#txtSearch").css({background:"#FFFFCC"});
		var va1=$("#txtSearch").val();
		if(va1=='输入"红米手机"试一试'){
			$("#txtSearch").val("");
		}
	});
	$("#txtSearch").blur(function(){
		$("#txtSearch").css({background:"#FFF"});
		var va2=$("#txtSearch").val();
		if(va2==""){
			$("#txtSearch").val('输入"红米手机"试一试');
		}			
	});
	$("#butSearch").click(function(){
		if($.trim($("#txtSearch").val()).length >0 ){
			window.location.href="<?php echo WEB_PATH; ?>/s_tag/"+$("#txtSearch").val();
		}
	});

	var week = '日一二三四五六';
	var innerHtml = '{0}:{1}:{2}';
	var dateHtml = "{0}月{1}日 &nbsp;周{2}";
	var timer = 0;
	var beijingTimeZone = 8;				
	function format(str, json){
		return str.replace(/{(\d)}/g, function(a, key) {
			return json[key];
		});
	}				
	function p(s) {
		return s < 10 ? '0' + s : s;
	}			

	function showTime(time){
		var timeOffset = ((-1 * (new Date()).getTimezoneOffset()) - (beijingTimeZone * 60)) * 60000;
		var now = new Date(time - timeOffset);
		document.getElementById('sp_ServerTime').innerHTML = format(innerHtml, [p(now.getHours()), p(now.getMinutes()), p(now.getSeconds())]);				
		//document.getElementById('date').innerHTML = format(dateHtml, [ p((now.getMonth()+1)), p(now.getDate()), week.charAt(now.getDay())]);
	}				
	
	window.yungou_time = 	function(time){						
		showTime(time);
		timer = setInterval(function(){
			time += 1000;
			showTime(time);
		}, 1000);					
	}

	window.yungou_time(<?php echo time(); ?>*1000);
})
//计算购物袋数量
function cartCount(){
	$.get("<?php echo WEB_PATH; ?>/member/cart/getnumber/"+ new Date().getTime(),function(data){	
		$("#cartCount").html("("+data+")");
		$("#row").html(data);						
	});
}

//加载购物袋信息
var row = 0;
var failure =  new Array();
function loadCart(){
	$.ajax({
		type:'get',
		url:"<?php echo WEB_PATH; ?>/member/cart/cartshop/" + (new Date()).getTime(),
		dataType:'json',
		success:function(headJosn){
			if(headJosn.li.length > 0){
				$('#noCart').hide();
				$("#carshoplist").html(headJosn.li);
				$("#hpriceTotal").html(headJosn.sum);
				$("#row").html(headJosn.num);
				$("#cartListDiv").css({height:$(window).height()-136+"px"});
			}
			
			
			//鼠标移到每条记录上
			$(".yfixed-divs-r").hover(function(){
		        if($(".yfixed-divs-rf")){
			        $(this).find(".yfixed-divs-rt").show();
			        $(this).find(".yfixed-divs-rf").hide();
		        }
		    },function(){
		        if($(".yfixed-divs-rt")){
		            $(this).find(".yfixed-divs-rt").hide();
		            $(this).find(".yfixed-divs-rf").show();
		        }
		    })
		}
	})
}
var showCart = true;
//鼠标移到购物袋上
$(".Left-fixed-divs3").hover(function(){
	var cart = $.cookie('Cartlist');
	if(cart!=null&& cart!=''&&cart != "undefined"){
	    $(".Left-fixed-divs2").show();
	    if(showCart){
	    	showCart = false;
	    	loadCart();
	    }
	}
},function(){
    $(".Left-fixed-divs2").hide();
})


//删除
function hdel(id){
	var Cartlist = $.cookie('Cartlist');
	var info = $.evalJSON(Cartlist);
	var row=parseInt($("#row").html())-1;
	var sum=parseInt($("#hpriceTotal").html());
	info['MoenyCount'] = sum-info.yun[id]['money']*info.yun[id]['num'];
	delete info.yun[id];
	$.cookie('Cartlist',$.toJSON(info),{expires:30,path:'/'});
	$("#hpriceTotal").html(info['MoenyCount']);
	$('#row').html(row);
	$("#shopdd_"+id).remove();
}

//删除
function ghdel(id){
	var Cartlist = $.cookie('Cartlist');
	var info = $.evalJSON(Cartlist);
	var row=parseInt($("#row").html())-1;
	var sum=parseInt($("#hpriceTotal").html());
	info['MoenyCount'] = sum-info.general[id]['money']*info.general[id]['num'];
		
	delete info.general[id];
	$.cookie('Cartlist',$.toJSON(info),{expires:30,path:'/'});
	$("#hpriceTotal").html(info['MoenyCount']);
	$('#row').html(row);
	$("#shopdd_"+id).remove();
}

</script>

<script type="text/javascript">
    $(function(){
       var _BuyList=$("#buyList");
        var Trundle = function () {
            _BuyList.prepend(_BuyList.find("li:last")).css('marginTop','-85px');
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



<!-- 底部 -->
<div class="footer_change">
	<div class="footer">
		<ul class="footerIn">
			<li>
				<span style="background-position: -119px -70px;height: 46px;margin-top: 7px"></span>
				<p>100%公平公正公开</p>
			</li>
			<li>
				<span style="background-position: -119px -122px;margin-top: 4px;height: 48px;"></span>
				<p>100%品质保障</p>
			</li>
			<li>
				<span style="background-position: -193px -22px;height: 39px;margin-top: 13px;"></span>
				<p>全国免运费（港澳除外）</p>
			</li>
			<li>
				<span style="background-position: -193px -62px;"></span>
				<p>100%权益保障</p>
			</li>
		</ul>
		<div class="yFootSupport">
			<div class="yFootSupport_in">
			
			    <?php $category=$this->DB()->GetList("select * from `@#_category` where `parentid`='1'",array("type"=>1,"key"=>'',"cache"=>0)); ?>
			    <?php $ln=1;if(is_array($category)) foreach($category AS $help): ?>
				<dl class="ft-newbie">
   				<dt><?php echo $help['name']; ?></dt>
				<?php $article=$this->DB()->GetList("select * from `@#_article` where `cateid`='$help[cateid]'",array("type"=>1,"key"=>'',"cache"=>0)); ?>
				<?php 
					foreach($article as $art){
						echo "<dd><a href='".WEB_PATH.'/help/'.$art['id']."' target='_blank'>".$art['title'].'</a></dd>';
					}
				 ?>				
   			    </dl>   			
			    <?php  endforeach; $ln++; unset($ln); ?>
                <?php if(defined('G_IN_ADMIN')) {echo '<div style="padding:8px;background-color:#F93; color:#fff;border:1px solid #f60;text-align:center"><b>This Tag</b></div>';}?>
				
				<dl class="dl_Time" style="padding-left:30px;">
					<dd title="服务热线" class="fwrx"><?php echo _cfg("cell"); ?></dd>
					<dd title="服务器时间" class="sysTime fwsj" id="sp_ServerTime"></dd>
					<a href="<?php echo WEB_PATH; ?>/single/fund"><dd title="云购公益基金" class="fund yggjjj" style="text-align:left;" id="spanFundTotal">00000.00</dd></a>
				</dl>
				<dl class="dlLast">
					<a href="javascript:;">
						<dd class="dlLast-WeChat">
							<div class="y-popover">
								<span class="y-arrow"></span>
								<b>云购国际官方微信</b>
								<img src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/cloud_kik.jpg" alt="">
							</div>
						</dd>
					</a>
					<a href="javascript:;">
						<dd class="dlLast-Sina">
							<!-- <div class="y-popover">
								<span class="y-arrow"></span>
								<b>云购国际新浪微博</b>
								<img src="<?php echo G_WEB_PATH; ?>/statics/templates/taolong-fangwangyi/images/img/cloud_xx.jpg" alt="">
							</div> -->
						</dd>
					</a>
					<a href="javascript:void(0);">
						<dd class="dlLast-apple">
							<!-- <div class="y-popover">
								<span class="y-arrow"></span>
								<b>扫二维码下载</b>
								<img src="/static/img/front/cloud_global/fullPage/cloud_kik.png" alt="">
							</div> -->
						</dd>
					</a>
					<a href="javascript:void(0);">
						<dd class="dlLast-Android">
							<!-- <div class="y-popover">
								<span class="y-arrow"></span>
								<b>扫二维码下载</b>
								<img src="../../static/img/front/cloud_global/fullPage/cloud_kik.png" alt="">
							</div> -->
						</dd>
					</a>
				</dl>
			</div>
			<div class="footer-time-list">
				<div class="yFootBottomRight">
						<?php echo _cfg('web_copyright'); ?>
				</div>
				<div class="yFootBottomLeft">
					<a href="javascript:;" target="_blank" class="yFootBottomLeft1"></a>
					<a href="javascript:;" target="_blank" class="yFootBottomLeft2"></a>
					<a href="javascript:;" target="_blank" class="yFootBottomLeft3"></a>
					<a href="javascript:;" target="_blank" class="yFootBottomLeft4"></a>
				</div>
			</div>
		</div>
		<div class="yFootBottom">
			<div class="yFootBottomIn" style="clear: both;">
				<p>友情链接：
					<?php $link_size=$this->DB()->GetList("select * from `@#_link` where `type`='1'",array("type"=>1,"key"=>'',"cache"=>0)); ?>
					<?php $ln=1;if(is_array($link_size)) foreach($link_size AS $size): ?>	
					<a href="<?php echo $size['url']; ?>" target="_blank"><?php echo $size['name']; ?></a> 
					<?php  endforeach; $ln++; unset($ln); ?>	
				</p>
			</div>
		</div>
		
	</div>
</div>
