<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!-- 栏目页面顶部 -->

     <header class="header">
        <h1 class="fl"><span><?php echo $webname; ?></span><a id="btnCart" href="<?php echo WEB_PATH; ?>/mobile/cart/cartlist" class="z-shop"></a></h1>
        <div class="fl head-s">
		<form>
		<input type="text" placeholder="请输入您要搜索的内容" class="h-search"></input>
		</form>
		</div>
        <div class="fr head-r">
            <a href="<?php echo WEB_PATH; ?>/mobile/user/login" class="z-Member"></a>
            </div>
    </header> 
    <!-- 栏目导航 -->
     <nav class="g-snav u-nav">
	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/" <?php if($key=="首页" ): ?>class="nav-crt"<?php endif; ?>>首页</a> <?php if($key=="首页" ): ?><s class="z-arrowh"></s><?php endif; ?></div>
		
	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/glist" <?php if($key=="所有商品" ): ?>class="nav-crt"<?php endif; ?>>所有商品</a><?php if($key=="所有商品" ): ?><s class="z-arrowh"></s><?php endif; ?></div>
		
	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/lottery" <?php if($key=="最新揭晓" ): ?>class="nav-crt"<?php endif; ?>>最新揭晓</a><?php if($key=="最新揭晓" ): ?><s class="z-arrowh"></s><?php endif; ?></div>
		
	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/shaidan/" <?php if($key=="晒单" ): ?>class="nav-crt"<?php endif; ?>>晒单</a><?php if($key=="晒单" ): ?><s class="z-arrowh"></s><?php endif; ?></div>
		
	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/autolottery" <?php if($key=="限时" ): ?>class="nav-crt"<?php endif; ?>>限时</a><?php if($key=="限时" ): ?><s class="z-arrowh"></s><?php endif; ?></div>
    </nav> 