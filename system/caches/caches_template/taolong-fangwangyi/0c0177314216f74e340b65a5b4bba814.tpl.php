<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车 - <?php echo $webname; ?>触屏版</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    
    <link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/cartList.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/Cartindex.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">
    
<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->

    <!--<header class="g-header">
        <div class="head-l">
	        <a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>
        </div>
        <h2>购物车</h2>
        <div class="head-r">
	        
        </div>
    </header>-->

    <input name="hidLogined" type="hidden" id="hidLogined" value="1" />
    <section class="clearfix g-Cart">
	    <?php if($shop!=0): ?>
	        <article class="clearfix m-round g-Cart-list">
	            <ul id="cartBody">
				<?php $ln=1; if(is_array($yunList)) foreach($yunList AS $key => $val): ?>
				
					<li>		            
						<a class="fl u-Cart-img" href="<?php echo WEB_PATH; ?>/mobile/mobile/item/<?php echo $val['id']; ?>">
							<img src="<?php echo G_TEMPLATES_IMAGE; ?>/loading.gif" src2="<?php echo G_UPLOAD_PATH; ?>/<?php echo $val['thumb']; ?>" border="0" alt="<?php echo $val['title']; ?>"/>
						</a>
						<div class="u-Cart-r">
							<p class="z-Cart-tt"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/item/<?php echo $val['id']; ?>" class="gray6">(第<?php echo $val['qishu']; ?>期)<?php echo $val['title']; ?></a></p>
							<ins class="z-promo gray9">剩余<em class="arial"><?php echo $val['zongrenshu']-$val['canyurenshu']; ?></em>人次  </ins>
							<p class="gray9">总共<?php echo _cfg('web_name_two'); ?>：<em class="arial"><?php echo $Mcartlist['yun'][$val['id']]['num']; ?></em>人次/<em class="orange arial">￥<?php echo $Mcartlist['yun'][$val['id']]['money']; ?>.00</em></p>
							<p class="f-Cart-Other">
								<a href="javascript:;" class="fr z-del" name="delLink" cid="<?php echo $val['id']; ?>"></a>
								<a href="javascript:;" class="fl z-jian <?php if($Mcartlist['yun'][$val['id']]['num']==1): ?>z-jiandis<?php endif; ?>">-</a>
								
								<input id="txtNum<?php echo $val['id']; ?>" name="num" type="text" maxlength="7" yunjiage = "<?php echo $val['yunjiage']; ?>" value="<?php echo $Mcartlist['yun'][$val['id']]['num']; ?>" class="fl z-amount" />
								<a href="javascript:;" class="fl z-jia <?php if($Mcartlist['yun'][$val['id']]['num']==$val['zongrenshu']): ?>z-jiadis<?php endif; ?>">+</a>
								<input type="hidden" value="<?php echo $Mcartlist['yun'][$val['id']]['num']; ?>" />
								<input type="hidden" value="<?php echo $val['zongrenshu']-$val['canyurenshu']; ?>" />
							</p>
						</div>
					</li>
				<?php  endforeach; $ln++; unset($ln); ?>
				<?php $ln=1; if(is_array($generalList)) foreach($generalList AS $key => $val): ?>
				
					<li>		            
						<a class="fl u-Cart-img" href="<?php echo WEB_PATH; ?>/mobile/mobile/item/<?php echo $val['id']; ?>">
							<img src="<?php echo G_TEMPLATES_IMAGE; ?>/loading.gif" src2="<?php echo G_UPLOAD_PATH; ?>/<?php echo $val['thumb']; ?>" border="0" alt="<?php echo $val['title']; ?>"/>
						</a>
						<div class="u-Cart-r">
							<p class="z-Cart-tt"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/item/<?php echo $val['id']; ?>" class="gray6"><?php echo $val['title']; ?></a></p>
							<ins class="z-promo gray9">库存<em class="arial"><?php echo $val['inventory']; ?></em> </ins>
							<p class="gray9">单价：<em class="arial" style="padding-right:10px;"><?php echo $val['money']; ?> </em>数量：<em class="arial" style="padding-right:10px;"><?php echo $val['cart_gorenci']; ?></em>小计：<em class="orange arial">￥<?php echo $val['cart_xiaoji']; ?></em></p>
							<p class="f-Cart-Other">
								<a href="javascript:;" class="fr z-del" name="delLink" cid="<?php echo $val['id']; ?>"></a>
								<a href="javascript:;" class="fl z-jian <?php if($val['cart_gorenci']==1): ?>z-jiandis<?php endif; ?>">-</a>
								
								<input id="txtNum<?php echo $val['id']; ?>" name="g_num" type="text" maxlength="7" g_jiage = "<?php echo $val['money']; ?>" value="<?php echo $val['cart_gorenci']; ?>" class="fl z-amount" />
								<a href="javascript:;" class="fl z-jia <?php if($val['inventory'] == $val['cart_gorenci']): ?>z-jiadis<?php endif; ?>">+</a>
								<input type="hidden" value="<?php echo $val['cart_gorenci']; ?>" />
								<input type="hidden" value="<?php echo $val['inventory']; ?>" />
							</p>
						</div>
					</li>
				<?php  endforeach; $ln++; unset($ln); ?>
	            </ul>
	        </article>
	       
	    <div id="divBtmMoney" class="g-Total-bt"><p><!-- 总共<?php echo _cfg('web_name_two'); ?> -->总共购买<span class="orange arial z-user"><?php echo $numCount; ?></span>个商品  合计金额：<span class="orange arial"><?php echo $MoenyCount; ?></span> 元</p>
			<a href="javascript:;" class="orgBtn">结 算</a>
		</div>
	<?php endif; ?>
	    <div id="divNone" class="haveNot z-minheight" style="display:none"><s></s><p>抱歉，您的购物车没有商品记录！</p>
		</div>
		
    </section>

    
<?php include templates("mobile/index","footer");?>
<script language="javascript" type="text/javascript">
  var Path = new Object();
  Path.Skin="<?php echo G_TEMPLATES_STYLE; ?>";  
  Path.Webpath = "<?php echo WEB_PATH; ?>";
  
var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo G_TEMPLATES_JS; ?>/mobile/Bottom.js');
</script>

</div>
</body>
</html>