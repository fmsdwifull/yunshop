<?php
class StoreAction extends WapAction{
	//public $token;
	//public $wecha_id = '';
	public $product_model;
	public $product_cat_model;
	public $session_cart_name;
	public $_cid = 0;
	public $_set;
	public $_isgroup = 0;
	
	public $mainCompany = null;
	
	public function _initialize() {
		parent::_initialize();
		
		$agent = $_SERVER['HTTP_USER_AGENT']; 
		if (!strpos($agent, "MicroMessenger")) {
			//	echo '此功能只能在微信浏览器中使用';exit;
		}
		
		//$this->token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';//$this->_get('token');
		//$this->assign('token', $this->token);
		
		//$this->wecha_id	= isset($_REQUEST['wecha_id']) ? $_REQUEST['wecha_id'] : '';
		//$this->assign('wecha_id', $this->wecha_id);
		
		$this->_cid = session("session_company_{$this->token}");
		$this->assign('cid', $this->_cid);
		$this->session_cart_name = "session_cart_products_{$this->token}_{$this->_cid}";//'session_cart_products_' . $this->token;
		if (!$this->wecha_id){
			//$this->wecha_id='';
			//exit('非法请求');
		}
		$this->product_model = M('Product');
		$this->product_cat_model = M('Product_cat');
		
		if (C('zhongshuai')) {
			$this->mainCompany = M('Company')->where("`token`='{$this->token}' AND `isbranch`=0")->find();
			$cid = $this->mainCompany['id'];
			$set = M('Product_setting')->where(array('token' => $this->token, 'cid' => $this->mainCompany['id']))->find();
			$this->_isgroup = isset($set['isgroup']) ? intval($set['isgroup']) : 0;
		}
			
		if ($this->_cid) {
			$this->_set = M('Product_setting')->where(array('token' => $this->token, 'cid' => $this->_cid))->find();
			$this->assign('productSet', $this->_set);
			$cid = $this->_isgroup ? $this->mainCompany['id'] : $this->_cid;
			$cats = $this->product_cat_model->where(array('token' => $this->token, 'cid' => $cid, 'parentid' => 0))->order("sort ASC, id DESC")->select();
			$this->assign('cats', $cats);
		}
		$this->assign('staticFilePath', str_replace('./','/',THEME_PATH.'common/css/store'));
		//购物车
		$calCartInfo = $this->calCartInfo();
		$this->assign('totalProductCount', $calCartInfo[0]);
		$this->assign('totalProductFee', $calCartInfo[1]);
	}
	
	public function select()
	{
		//session("session_company_{$this->token}", null);
		
		$company = M('Company')->where("`token`='{$this->token}' AND ((`isbranch`=1 AND `display`=1) OR `isbranch`=0)")->select();
		if (count($company) == 1) {
			$this->redirect(U('Store/cats',array('token' => $this->token, 'wecha_id' => $this->wecha_id, 'cid' => $company[0]['id'])));
		}
		
		$this->assign('company', $company);
		$this->assign('metaTitle', '商城分布');
		$this->display();
		
	}
	
	
	/**
	 * 商城首页
	 */
	public function index() 
	{
		$this->redirect(U('Store/cats',array('token' => $this->token, 'wecha_id' => $this->wecha_id)));
	}
	
	/**
	 * 商城首页
	 */
	public function cats() 
	{
		$company = M('Company')->where("`token`='{$this->token}' AND `isbranch`=0")->find();
		D("Product_cat")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		D("Attribute")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		D("Product")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		D("Product_cart")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		D("Product_cart_list")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		D("Product_comment")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		D("product_setting")->where(array('token' => $this->token, 'cid' => 0))->save(array('cid' => $company['id']));
		
		
		$cid = $this->_cid = isset($_GET['cid']) ? intval($_GET['cid']) : $company['id'];
		if ($this->_isgroup) {
			$cid = $company['id'];
			$relation = M("Product_relation")->where(array('token' => $this->token, 'cid' => $this->_cid))->select();
			if (empty($relation) && $this->_cid != $cid) {
				$this->error("该店铺暂时没有商品可卖，先逛逛别的", U('Store/select',array('token' => $this->token, 'wecha_id' => $this->wecha_id)));
			}
		}
		session("session_company_{$this->token}", $this->_cid);
		$this->assign('cid', $this->_cid);
		
		$parentid = isset($_GET['parentid']) ? intval($_GET['parentid']) : 0;
		$cats = $this->product_cat_model->where(array('token' => $this->token, 'cid' => $cid, 'parentid' => $parentid))->order("sort ASC, id DESC")->select();
		$info = array();
		foreach ($cats as &$row) {
			$row['info'] = $row['des'];
			$row['img'] = $row['logourl'];
			if ($row['isfinal'] == 1) {
				$row['url'] = U('Store/products', array('token' => $this->token, 'catid' => $row['id'], 'wecha_id' => $this->wecha_id));
			} else {
				$row['url'] = U('Store/cats', array('token' => $this->token, 'cid' => $this->_cid, 'parentid' => $row['id'], 'wecha_id' => $this->wecha_id));
			}
			
			$info[] = $row;
		}
		$this->assign('info', $info);
		
		$this->assign('metaTitle', '商品分类');
		
		include('./31cms/Lib/ORG/index.Tpl.php');
		include('./31cms/Lib/ORG/cont.Tpl.php');
		$catemenu[0] = array('id' => 0, 'name' => '所有商品', 'picurl' => '/tpl/static/store/m-act-cat.png', 'k' => 0, 'vo' => array(), 'url' => U('Store/cats', array('token'=> $this->token,'wecha_id'=> $this->wecha_id,'cid' => $this->_cid)));
		$catemenu[1] = array('id' => 1, 'name' => '购物车', 'picurl' => '/tpl/static/store/m-act-cart.png', 'k' => 1, 'vo' => array(), 'url' => U('Store/cart', array('token'=> $this->token,'wecha_id'=> $this->wecha_id,'cid' => $this->_cid)));
		$catemenu[2] = array('id' => 2, 'name' => '查物流', 'picurl' => '/tpl/static/store/m-act-wuliu.png', 'k' => 2, 'vo' => array(), 'url' => U('Store/my', array('token'=> $this->token,'wecha_id'=> $this->wecha_id,'cid' => $this->_cid)));
		$catemenu[3] = array('id' => 3, 'name' => '用户中心', 'picurl' => '/tpl/static/store/user2.png', 'k' => 3, 'vo' => array(), 'url' => U('Store/my', array('token'=> $this->token,'wecha_id'=> $this->wecha_id,'cid' => $this->_cid)));
		$this->assign('catemenu', $catemenu);
		$set = M("Product_setting")->where(array('token' => $this->token, 'cid' => $this->_cid))->find();
		if (isset($tpl[$set['tpid'] - 1]['tpltypename'])) {
			$t = $tpl[$set['tpid'] - 1]['tpltypename'];
			
			$cateMenuFileName = "tpl/Wap/default/Index_menuStyle{$set['footerid']}.html";
			$this->assign('cateMenuFileName', $cateMenuFileName);
			
			$allflash=M('Store_flash')->where(array('token' => $this->token, 'cid' => $this->_cid))->select();
			
			foreach ($allflash as &$f) {
				if ($f['url']) {
					$url = $f['url'];
					$link=str_replace(array('{wechat_id}','{siteUrl}','&amp;'),array($this->wecha_id,$this->siteUrl,'&'),$url);
					if (!!(strpos($url,'tel')===false)&&$url!='javascript:void(0)'&&!strpos($url,'wecha_id=')){
						if (strpos($url,'?')){
							$link=$link.'&wecha_id='.$this->wecha_id;
						}else {
							$link=$link.'?wecha_id='.$this->wecha_id;
						}
					}
					$f['url'] = $link;
				}
			}
		
			$flash = array();
			$flashbg = array();
			foreach ($allflash as $af){
				if ($af['url']=='') {
					$af['url']='javascript:void(0)';
				}
				if ($af['type'] == 1) {
					array_push($flash,$af);
				} elseif ($af['type'] == 0) {
					array_push($flashbg,$af);
				}
			}
			
			//$allflash=$this->convertLinks($allflash);
		
			$count = count($flash);
			$this->assign('flash', $flash);
			$this->assign('num', $count);
			$this->assign('flashbg', $flashbg);
			$this->assign('flashbgcount', count($flashbg));
			
			$this->display("Index:{$t}");
		} else {
			$this->assign('cats', $info);
			$this->display();
		}
	}
	
	public function products() 
	{
		//if (isset($_G['cid']))
		$where = array('token' => $this->token, 'cid' => $this->_cid, 'groupon' => 0, 'dining' => 0, 'status' => 0);
		if ($this->_isgroup) {
			$relation = M("Product_relation")->where(array('token' => $this->token, 'cid' => $this->_cid))->select();
			$gids = array();
			foreach ($relation as $r) {
				$gids[] = $r['gid'];
			}
			if ($gids) $where['gid'] = array('in', $gids);
			$where['cid'] = $this->mainCompany['id'];
		}
		
		$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
		if ($catid) {
			$where['catid'] = $catid;
			$thisCat = $this->product_cat_model->where(array('id'=>$catid))->find();
			$where['cid'] = $thisCat['cid'];
			if (empty($this->_cid) || $this->_cid != $thisCat['cid']) {
				$this->_cid = $thisCat['cid'];
				session("session_company_{$this->token}", $this->_cid);
			}
			$this->assign('thisCat', $thisCat);
		}
		if (IS_POST){
			$key = $this->_post('search_name');
            $this->redirect('/index.php?g=Wap&m=Store&a=products&token=' . $this->token . '&wecha_id=' . $this->wecha_id . '&keyword=' . $key);
		}
		if (isset($_GET['keyword'])){
            $where['name|intro|keyword'] = array('like', "%".$_GET['keyword']."%");
            $this->assign('isSearch', 1);
		}
		$count = $this->product_model->where($where)->count();
		$this->assign('count', $count); 
		//排序方式
		$method = isset($_GET['method']) && ($_GET['method']=='DESC' || $_GET['method']=='ASC') ? $_GET['method'] : 'DESC';
		$orders = array('time', 'discount', 'price', 'salecount');
		$order = isset($_GET['order']) && in_array($_GET['order'], $orders) ? $_GET['order'] : 'time';
		$this->assign('order', $order);
		$this->assign('method', $method);
        	
		$products = $this->product_model->where($where)->order("sort ASC, " . $order.' '.$method)->limit('0, 8')->select();
		$this->assign('products', $products);
		$name = isset($thisCat['name']) ? $thisCat['name'] . '列表' : "商品列表";
		$this->assign('metaTitle', $name);
		$this->display();
	}
	
	public function ajaxProducts()
	{
		$where = array('token' => $this->token, 'cid' => $this->_cid, 'groupon' => 0, 'dining' => 0, 'status' => 0);
		if ($this->_isgroup) {
			$relation = M("Product_relation")->where(array('token' => $this->token, 'cid' => $this->_cid))->select();
			$gids = array();
			foreach ($relation as $r) {
				$gids[] = $r['gid'];
			}
			if ($gids) $where['gid'] = array('in', $gids);
			$where['cid'] = $this->mainCompany['id'];
		}
		//$where = array('token' => $this->token, 'cid' => $this->_cid);
		if (isset($_GET['catid'])) {
			$catid = intval($_GET['catid']);
			$where['catid'] = $catid;
		}
		$page = isset($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) : 2;
		$pageSize = isset($_GET['pagesize']) && intval($_GET['pagesize']) > 1 ? intval($_GET['pagesize']) : 8;
		
		$method = isset($_GET['method']) && ($_GET['method']=='DESC' || $_GET['method']=='ASC') ? $_GET['method'] : 'DESC';
		$orders = array('time', 'discount', 'price', 'salecount');
		$order = isset($_GET['order']) && in_array($_GET['order'], $orders) ? $_GET['order'] : 'time';
		$start = ($page-1) * $pageSize;
		$products = $this->product_model->where($where)->order("sort ASC, " . $order.' '.$method)->limit($start . ',' . $pageSize)->select();
		exit(json_encode(array('products' => $products)));
	}
	
	public function product() 
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$where = array('token' => $this->token, 'id' => $id);
		$product = $this->product_model->where($where)->find();
		if (empty($product)) {
			$this->redirect(U('Store/products',array('token' => $this->token,'wecha_id' => $this->wecha_id)));
		}
		
		$cid = $this->_isgroup ? $this->mainCompany['id'] : $this->_cid;
		
		$product['intro'] = isset($product['intro']) ? htmlspecialchars_decode($product['intro']) : '';
		$this->assign('product', $product);
		if ($product['endtime']){
			$leftSeconds = intval($product['endtime'] - time());
			$this->assign('leftSeconds', $leftSeconds);
		}
        $normsData = M("Norms")->where(array('catid' => $product['catid']))->select();
        foreach ($normsData as $row) {
        	$normsList[$row['id']] = $row['value'];
        }
        if($productCatData = M('Product_cat')->where(array('id' => $product['catid'], 'token' => $this->token, 'cid' => $cid))->find()) {
        	$this->assign('catData', $productCatData);
        }
		$colorDetail = $normsDeatail = $productDetail = array();
		$attributeData = M("Product_attribute")->where(array('pid' => $product['id']))->select();
		
		$productDetailData = M("Product_detail")->where(array('pid' => $product['id']))->select();
		foreach ($productDetailData as $p) {
			$p['formatName'] = $normsList[$p['format']];
			$p['colorName'] = $normsList[$p['color']];
			
			$formatData[$p['format']] = $colorData[$p['color']] = $productDetail[] = $p;
			
			$colorDetail[$p['color']][] = $p;
			$normsDetail[$p['format']][] = $p;
		}
		$productimage = M("Product_image")->where(array('pid' => $product['id']))->select();
		
		$this->assign('imageList', $productimage);
		$this->assign('productDetail', $productDetail);
		$this->assign('attributeData', $attributeData);
		$this->assign('normsDetail', $normsDetail);
		$this->assign('colorDetail', $colorDetail);
		$this->assign('formatData', $formatData);
		$this->assign('colorData', $colorData);
		$this->assign('metaTitle', $product['name']);
		
		$where = array('token' => $this->token, 'cid' => $cid, 'pid' => $id, 'isdelete' => 0);
		$product_model = M("Product_comment");
		$score      = $product_model->where($where)->sum('score');
		$count      = $product_model->where($where)->count();
		$comment = $product_model->where($where)->order('id desc')->limit("0, 10")->select();
		foreach ($comment as &$com) {
			$com['wecha_id'] = substr($com['wecha_id'], 0, 7) . "****";
		}
		
		$percent = "100%";
		if ($count) {
			$score = number_format($score / $count, 1);
			$percent =  number_format($score / 5, 2) * 100 . "%";
		}
		$totalPage = ceil($count / 10);
		$page = $totalPage > 1 ? 2 : 0;
		
		$this->assign('score', $score);
		$this->assign('num', $count);
		$this->assign('page', $page);
		$this->assign('comment', $comment);
		$this->assign('percent', $percent);
		$this->display();
	}
	
	public function getcomment()
	{
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$start = ($page - 1) * $offset;
		$offset = 10;
		$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
		$where = array('token' => $this->token, 'pid' => $pid, 'isdelete' => 0);
		$product_model = M("Product_comment");
		$count = $product_model->where($where)->count();
		
		$comment = $product_model->where($where)->order('id desc')->limit($start, $offset)->select();
		foreach ($comment as &$com) {
			$com['wecha_id'] = substr($com['wecha_id'], 0, 7) . "****";
			$com['dateline'] = date("Y-m-d H:i", $com['dateline']);//substr($com['wecha_id'], 0, 7) . "****";
		}
		$totalPage = ceil($count / $offset);
		$page = $totalPage > $page ? intval($page + 1) : 0;
		exit(json_encode(array('error_code' => false, 'data' => $comment, 'page' => $page)));
	}
	
	/**
	 * 添加购物车
	 */
	public function addProductToCart()
	{
		$count = isset($_GET['count']) ? intval($_GET['count']) : 1;
		$carts = $this->_getCart();
		$id = intval($_GET['id']);
		$did = isset($_GET['did']) ? intval($_GET['did']) : 0;//商品的详细id,即颜色与尺寸
		if (isset($carts[$id])) {
			if ($did) {
				if (isset($carts[$id][$did])) {
					$carts[$id][$did]['count'] += $count;
				} else {
					$carts[$id][$did]['count'] = $count;
				}
			} else {
				$carts[$id] += $count;
			}
		} else {
			if ($did) {
				$carts[$id][$did]['count'] = $count;
			} else {
				$carts[$id] = $count;
			}
		}
		$_SESSION[$this->session_cart_name] = serialize($carts);
		$calCartInfo = $this->calCartInfo();
		echo $calCartInfo[0].'|'.$calCartInfo[1];
	}
	
	private function calCartInfo($carts='')
	{
		$totalCount = $totalFee = 0;
		if (!$carts) {
			$carts = $this->_getCart();
		}
		$data = $this->getCat($carts);
		if (isset($data[1])) {
			foreach ($data[1] as $pid => $row) {
				$totalCount += $row['total'];
				$totalFee += $row['totalPrice'];
			}
		}
		
		return array($totalCount, $totalFee, $data[2]);
	}
	
	private function _getCart()
	{
		if (!isset($_SESSION[$this->session_cart_name])||!strlen($_SESSION[$this->session_cart_name])){
			$carts = array();
		} else {
			$carts=unserialize($_SESSION[$this->session_cart_name]);
		}
		return $carts;
	}
	
	/**
	 * 购物车列表
	 */
	public function cart()
	{
		if (empty($this->wecha_id)) {
			unset($_SESSION[$this->session_cart_name]);
		}
		$totalCount = $totalFee = 0;
		$data = $this->getCat($this->_getCart());
		if (isset($data[1])) {
			foreach ($data[1] as $pid => $row) {
				$totalCount += $row['total'];
				$totalFee += $row['totalPrice'];
			}
		}
		$list = $data[0];
		
		$this->assign('products', $list);
		$this->assign('totalFee', $totalFee);
		$this->assign('totalCount', $totalCount);
		$this->assign('metaTitle','购物车');
		$this->display();
	}
	
	
	
	/**
	 * 计算一次购物的总的价格与数量
	 * @param array $carts
	 */
	public function getCat($carts = '')
	{
		$carts = empty($carts) ? $this->_getCart() : $carts;
		//邮费
		$mailPrice = 0;
		//商品的IDS
		$pids = array_keys($carts);
		
		//商品分类IDS
		$productList = $cartIds = array();
		if (empty($pids)) {
			return array(array(), array(), array());
		}
		
		//获取分类ID
		$productdata = $this->product_model->where(array('id'=> array('in', $pids)))->select();
		foreach ($productdata as $p) {
			if (!in_array($p['catid'], $cartIds)) {
				$cartIds[] = $p['catid'];
			}
			$mailPrice = max($mailPrice, $p['mailprice']);
			$productList[$p['id']] = $p;
		}
		
		//商品规格参数值
		$catlist = $norms = array();
		if ($cartIds) {
			//产品规格列表
			$normsdata = M('norms')->where(array('catid' => array('in', $cartIds)))->select();
			foreach ($normsdata as $r) {
				$norms[$r['id']] = $r['value'];
			}
			//商品分类
			$catdata = M('Product_cat')-> where(array('id' => array('in', $cartIds)))->select();
			foreach ($catdata as $cat) {
				$catlist[$cat['id']] = $cat;
			}
		}
		$dids = array();
		foreach ($carts as $pid => $rowset) {
			if (is_array($rowset)) {
				$dids = array_merge($dids, array_keys($rowset));
			}
		}
		//商品的详细
		$totalprice = 0;
		$data = array();
		if ($dids) {
			$dids = array_unique($dids);
			$detail = M('Product_detail')->where(array('id'=> array('in', $dids)))->select();
			foreach ($detail as $row) {
				$row['colorName'] = isset($norms[$row['color']]) ? $norms[$row['color']] : '';
				$row['formatName'] = isset($norms[$row['format']]) ? $norms[$row['format']] : '';
				$row['count'] = isset($carts[$row['pid']][$row['id']]['count']) ? $carts[$row['pid']][$row['id']]['count'] : 0;
				if ($this->fans['getcardtime'] > 0) {
					$row['price'] = $row['vprice'] ? $row['vprice'] : $row['price'];
				}
				$productList[$row['pid']]['detail'][] = $row;
				$data[$row['pid']]['total'] = isset($data[$row['pid']]['total']) ? intval($data[$row['pid']]['total'] + $row['count']) : $row['count'];
				$data[$row['pid']]['totalPrice'] = isset($data[$row['pid']]['totalPrice']) ? intval($data[$row['pid']]['totalPrice'] + $row['count'] * $row['price']) : $row['count'] * $row['price'];//array('total' => $totalCount, 'totalPrice' => $totalFee);
				$totalprice += $data[$row['pid']]['totalPrice'];
			}
		}
		//商品的详细列表
		$list = array();
		foreach ($productList as $pid => $row) {
			if (!isset($data[$pid]['total'])) {
				$count = $price = 0;
				if (isset($carts[$pid]) && is_array($carts[$pid])) {
					$a = explode("|", $carts[$pid]['count']);
					$count = isset($a[0]) ? $a[0] : 0;
					$price = isset($a[1]) ? $a[1] : 0;
				} else {
					$a = explode("|", $carts[$pid]);
					$count = isset($a[0]) ? $a[0] : 0;
					$price = isset($a[1]) ? $a[1] : 0;
				}
				$data[$pid] = array();
				$row['price'] = $price ? $price : $row['price'];
				$row['count'] = $data[$pid]['total'] = $count;
				if (empty($count) && empty($price)) {
					$row['count'] = $data[$pid]['total'] = isset($carts[$pid]['count']) ? $carts[$pid]['count'] : (isset($carts[$pid]) && is_int($carts[$pid]) ? $carts[$pid] : 0);
					if ($this->fans['getcardtime'] > 0) {
						$row['price'] = $row['vprice'] ? $row['vprice'] : $row['price'];
					}
				}
				
				
				$data[$pid]['totalPrice'] = $data[$pid]['total'] * $row['price'];
				$totalprice += $data[$pid]['totalPrice'];
			}
			$row['formatTitle'] =  isset($catlist[$row['catid']]['norms']) ? $catlist[$row['catid']]['norms'] : '';
			$row['colorTitle'] =  isset($catlist[$row['catid']]['color']) ? $catlist[$row['catid']]['color'] : '';
			$list[] = $row;
		}
		if ($obj = M('Product_setting')->where(array('token' => $this->token, 'cid' => $this->_cid))->find()) {
			if ($totalprice >= $obj['price']) $mailPrice = 0;
		}
		return array($list, $data, $mailPrice);
	}
	
	public function deleteCart()
	{
		$products=array();
		$ids=array();
		$carts=$this->_getCart();
		$did = isset($_GET['did']) ? intval($_GET['did']) : 0;
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if ($did) {
			unset($carts[$id][$did]);
			if (empty($carts[$id])) {
				unset($carts[$id]);
			}
		} else {
			unset($carts[$id]);
		}
		$_SESSION[$this->session_cart_name] = serialize($carts);
		$this->redirect(U('Store/cart',array('token'=>$_GET['token'],'wecha_id'=>$_GET['wecha_id'])));
	}
	
	public function ajaxUpdateCart(){
		$count = isset($_GET['count']) ? intval($_GET['count']) : 1;
		$carts = $this->_getCart();
		$id = intval($_GET['id']);
		$did = isset($_GET['did']) ? intval($_GET['did']) : 0;
		if (isset($carts[$id])) {
			if ($did) {
				$carts[$id][$did]['count'] = $count;
			} else {
				$carts[$id] = $count;
			}
		} else {
			if ($did) {
				$carts[$id][$did]['count'] = $count;
			} else {
				$carts[$id] = $count;
			}
		}
		$_SESSION[$this->session_cart_name] = serialize($carts);
		$calCartInfo = $this->calCartInfo();
		echo $calCartInfo[0].'|'.$calCartInfo[1];
	}
	
	
	public function ordersave()
	{
		$row = array();
		$row['orderid'] = $orderid = substr($this->wecha_id, -1, 4) . date("YmdHis");
		$row['truename'] = $this->_post('truename');
		$row['tel'] = $this->_post('tel');
		$row['address'] = $this->_post('address');
		$row['token'] = $this->token;
		//$row['cid'] = $this->_cid;
		$row['wecha_id'] = $this->wecha_id;
		$row['time'] = $time = time();
		$row['paymode'] = isset($_POST['paymode']) ? intval($_POST['paymode']) : 0;
		
		$row['cid'] = $cid = $this->_isgroup ? $this->mainCompany['id'] : $this->_cid;
		
		//积分
		$score = isset($_POST['score']) ? intval($_POST['score']) : 0;
		$normal_rt = 0;
		$carts = $this->_getCart();
		$info = array();
		if ($carts){
			$calCartInfo = $this->calCartInfo($carts);
			foreach ($carts as $pid => $rowset) {
				$total = 0;
				$tmp = M('product')->where(array('id' => $pid))->find();//setDec('num', $total);
				if (is_array($rowset)) {
					foreach ($rowset as $did => $ro) {
						$temp = M('Product_detail')->where(array('id' => $did, 'pid' => $pid))->find();//setDec('num', $ro['count']);
						if ($temp['num'] < $ro['count']) {
							$this->error('购买的量超过了库存');
						}
						$total += $ro['count'];
						$price = $this->fans['getcardtime'] ? ($temp['vprice'] ? $temp['vprice'] : $temp['price']) : $temp['price'];
						$info[$pid][$did] = array('count' => $ro['count'], 'price' => $price);
					}
				} else {
					$total = $rowset;
					$price = $this->fans['getcardtime'] ? ($tmp['vprice'] ? $tmp['vprice'] : $tmp['price']) : $tmp['price'];
					$info[$pid] = $rowset . "|" . $price;
				}
				if ($tmp['num'] < $total) {
					$this->error('购买的量超过了库存');
				}
			}
			
			$setting = M('Product_setting')->where(array('token' => $this->token, 'cid' => $cid))->find();
			$totalprice = $calCartInfo[1] + $calCartInfo[2];
			if ($score && $setting && $setting['score'] > 0 && $this->fans['total_score'] >= $score) {
				$totalprice -= $score / $setting['score'];
				if ($totalprice < 0) {
					$score = ($calCartInfo[1] + $calCartInfo[2]) * $setting['score'];
					$totalprice = 0;
					$row['paid'] = 1;
				}
			}
			
			$row['total'] = $calCartInfo[0];
			$row['price'] = $totalprice;
			$row['diningtype'] = 0;
			$row['buytime'] = '';
			$row['tableid'] = 0;
			$row['info'] = serialize($info);
			$row['groupon']=0;
			$row['dining'] = 0;
			$row['score'] = $score;
			
			$product_cart_model = M('product_cart');
			$normal_rt = $product_cart_model->add($row);
			//TODO 发货的短信提醒
			if ($normal_rt) {
				$info=M('deliemail')->where(array('token'=>$this->_get('token')))->find();
			$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
			$emailstatus=$info['shangcheng'];
			$emailreceive=$info['receive'];
			$content = $this->sms1();
			if($info['type'] == 1){
			$emailsmtpserver=$info['smtpserver'];
			$emailport=$info['port'];
			$emailsend=$info['name'];
			$emailpassword=$info['password'];
			}else{
			$emailsmtpserver=C('email_server');
			$emailport=C('email_port');
			$emailsend=C('email_user');
			$emailpassword=C('email_pwd');
			}
			$emailuser=explode('@', $emailsend);
			$emailuser=$emailuser[0];
			if ($emailstatus == 1) {
				if ($content) {
					date_default_timezone_set('PRC');
					require("class.phpmailer.php");
					$mail = new PHPMailer();
					$mail->IsSMTP();                                      // set mailer to use SMTP
					$mail->Host = "$emailsmtpserver";  // specify main and backup server
					$mail->SMTPAuth = true;     // turn on SMTP authentication
					$mail->Username = "$emailuser"; // SMTP username
					$mail->Password = "$emailpassword"; // SMTP password
					$mail->From = $emailsend;
					$mail->FromName = C('site_name');
					$mail->AddAddress("$emailreceive", "商户");
					//$mail->AddAddress("ellen@example.com");                  // name is optional
					$mail->AddReplyTo($emailsend, "Information");

					$mail->WordWrap = 50;                                 // set word wrap to 50 characters
					//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
					//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
					$mail->IsHTML(false);                                  // set email format to HTML

					$mail->Subject = '有新的商城订单';
					$mail->Body    = $content;
					$mail->AltBody = "";

					if(!$mail->Send())
					{
					   echo "Message could not be sent. <p>";
					   echo "Mailer Error: " . $mail->ErrorInfo;
					   exit;
					}
					//echo "Message has been sent";    
				}
			}
				$tdata = $this->getCat($carts);
				$list = array();
				foreach ($tdata[0] as $va) {
					$t = array();
					if (!empty($va['detail'])) {
						foreach ($va['detail'] as $v) {
							$t = array('num' => $v['count'], 'colorName' => $v['colorName'], 'formatName' => $v['formatName'], 'price' => $v['price'], 'name' => $va['name']);
							$list[] = $t;
						}
					} else {
						$t = array('num' => $va['count'], 'price' => $va['price'], 'name' => $va['name']);
						$list[] = $t;
					}
				}
				$company = D('Company')->where(array('token' =>$this->token, 'id' => $cid))->find();
				$op = new orderPrint();
				$msg = array('companyname' => $company['name'], 'companytel' => $company['tel'], 'truename' => $row['truename'], 'tel' => $row['tel'], 'address' => $row['address'], 'buytime' => $row['time'], 'orderid' => $row['orderid'], 'sendtime' => '', 'price' => $row['price'], 'total' => $row['total'], 'list' => $list);
				$msg = ArrayToStr::array_to_str($msg);
				$op->printit($this->token, $this->_cid, 'Store', $msg, 0);
				
				$userInfo = D('Userinfo')->where(array('token' => $this->token, 'wecha_id' => $this->wecha_id))->find();
				Sms::sendSms($this->token, "您的顾客{$userInfo['truename']}刚刚下了一个订单，订单号：{$orderid}，请您注意查看并处理");
			}
		}
		if ($normal_rt){
			$product_model = M('product');
			$product_cart_list_model = M('product_cart_list');
			$crow = array();
			$tdata = $this->getCat($carts);
			foreach ($carts as $k => $c){
				$crow['cartid'] = $normal_rt;
				$crow['productid'] = $k;
				$crow['price'] = $tdata[1][$k]['totalPrice'];//$c['price'];
				$crow['total'] = $tdata[1][$k]['total'];
				$crow['wecha_id'] = $row['wecha_id'];
				$crow['token'] = $row['token'];
				$crow['cid'] = $row['cid'];
				$crow['time'] = $time;
				$product_cart_list_model->add($crow);
				
				//增加销量
				$product_model->where(array('id'=>$k))->setInc('salecount', $tdata[1][$k]['total']);
			}
			
			//删除库存
			foreach ($carts as $pid => $rowset) {
				$total = 0;
				if (is_array($rowset)) {
					foreach ($rowset as $did => $ro) {
						M('Product_detail')->where(array('id' => $did, 'pid' => $pid))->setDec('num', $ro['count']);
						$total += $ro['count'];
					}
				} else {
					$total = $rowset;
				}
				$product_model->where(array('id' => $pid))->setDec('num', $total);
			}
			$_SESSION[$this->session_cart_name] = null;
			unset($_SESSION[$this->session_cart_name]);
			//保存个人信息
			if ($_POST['saveinfo']){
				$userinfo_model = M('Userinfo');
				$thisUser = $userinfo_model->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id))->find();
				$this->assign('thisUser', $thisUser);
				$userRow=array('tel'=>$row['tel'],'truename'=>$row['truename'],'address'=>$row['address']);
				if ($thisUser) {
					$userinfo_model->where(array('id' => $thisUser['id']))->save($userRow);
					$userinfo_model->where(array('id' => $thisUser['id'], 'total_score' => array('egt', $score)))->setDec('total_score', $score);
					F('fans_token_wechaid', NULL);
				} else {
					$userRow['token']=$this->token;
					$userRow['wecha_id']=$this->wecha_id;
					$userRow['wechaname']='';
					$userRow['qq']=0;
					$userRow['sex']=-1;
					$userRow['age']=0;
					$userRow['birthday']='';
					$userRow['info']='';

					$userRow['total_score']=0;
					$userRow['sign_score']=0;
					$userRow['expend_score']=0;
					$userRow['continuous']=0;
					$userRow['add_expend']=0;
					$userRow['add_expend_time']=0;
					$userRow['live_time']=0;
					$userinfo_model->add($userRow);
				}
			}
			
			$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
			if ($totalprice) {
				if ($alipayConfig['open'] && $totalprice && $row['paymode'] == 1) {
					$this->success('正在提交中...', U('Alipay/pay', array('token' => $this->token, 'wecha_id' => $this->wecha_id, 'success' => 1, 'from'=> 'Store', 'orderName' => $orderid, 'single_orderid' => $orderid, 'price' => $totalprice)));
					die;
				} elseif ($this->fans['balance'] > 0 && $row['paymode'] == 4) {
					$this->success('正在提交中...', U('CardPay/pay', array('token' => $this->token, 'wecha_id' => $this->wecha_id, 'success' => 1, 'from'=> 'Store', 'orderName' => $orderid, 'single_orderid' => $orderid, 'price' => $totalprice)));
					die;
				}
			}
			
			$model = new templateNews();
			$model->sendTempMsg('TM00820', array('href' => U('Store/my',array('token' => $this->token, 'wecha_id' => $this->wecha_id)), 'wecha_id' => $this->wecha_id, 'first' => '购买商品提醒', 'keynote1' => '订单未支付', 'keynote2' => date("Y年m月d日H时i分s秒"), 'remark' => '购买成功，感谢您的光临，欢迎下次再次光临！'));
			$this->success('预定成功,进入您的订单页', U('Store/my',array('token'=>$_GET['token'],'wecha_id'=>$_GET['wecha_id'],'success'=>1)));
		} else {
			$this->error('订单生产失败');
		} 
	}
	public function sms1(){
		$where['token']=$this->token;
		$where['wecha_id']=$this->wecha_id;
		$where['printed']=0;
		$this->product_cart_model=M('product_cart');
		$count      = $this->product_cart_model->where($where)->count();
		$orders=$this->product_cart_model->where($where)->order('time DESC')->limit(0,1)->select();
		
		$now=time();
		if ($orders){
			$thisOrder=$orders[0];
			switch ($thisOrder['diningtype']){
				case 0:
					$orderType='购物';
					break;
				case 1:
					$orderType='点餐';
					break;
				case 2:
					$orderType='外卖';
					break;
				case 3:
					$orderType='预定餐桌';
					break;
			}
			
			//订餐信息
			$product_diningtable_model=M('product_diningtable');
			if ($thisOrder['tableid']) {
				$thisTable=$product_diningtable_model->where(array('id'=>$thisOrder['tableid']))->find();
				$thisOrder['tableName']=$thisTable['name'];
			}else{
				$thisOrder['tableName']='未指定';
			}
			$str="订单类型：".$orderType."\r\n订单编号：".$thisOrder['orderid']."\r\n姓名：".$thisOrder['truename']."\r\n电话：".$thisOrder['tel']."\r\n地址：".$thisOrder['address']."\r\n下单时间：".date('Y-m-d H:i:s',$thisOrder['time'])."\r\n";
			//
			$carts=unserialize($thisOrder['info']);

			//
			$totalFee=0;
			$totalCount=0;
			$products=array();
			$ids=array();
			foreach ($carts as $k=>$c){
				if (is_array($c)){
					$productid=$k;
					$price=$c['price'];
					$count=$c['count'];
					//
					if (!in_array($productid,$ids)){
						array_push($ids,$productid);
					}
					$totalFee+=$price*$count;
					$totalCount+=$count;
				}
			}
			if (count($ids)){
				$products=$this->product_model->where(array('id'=>array('in',$ids)))->select();
			}
			if ($products){
				$i=0;
				foreach ($products as $p){
					$products[$i]['count']=$carts[$p['id']]['count'];
					$str.=$p['name']."  ".$products[$i]['count']."份  单价：".$p['price']."元\r\n";
					$i++;
				}
			}
			$str.="合计：".$thisOrder['price']."元";
			return $str;
		}else {
			return '';
		}
	}

	
	
	public function orderCart()
	{
		if (empty($this->wecha_id)) {
			unset($_SESSION[$this->session_cart_name]);
		}
		
		$cid = $this->_isgroup ? $this->mainCompany['id'] : $this->_cid;
		
		$setting = M('Product_setting')->where(array('token' => $this->token, 'cid' => $cid))->find();
		$this->assign('setting', $setting);
		//是否要支付
		$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
		$this->assign('alipayConfig', $alipayConfig);

		$totalCount = $totalFee = 0;
		$data = $this->getCat($this->_getCart());
		if (empty($data[0])) {
			$this->redirect(U('Store/cart', array('token' => $this->token, 'wecha_id' => $this->wecha_id)));
		}
		if (isset($data[1])) {
			foreach ($data[1] as $pid => $row) {
				$totalCount += $row['total'];
				$totalFee += $row['totalPrice'];
			}
		}
		if (empty($totalCount)) {
			$this->error('没有购买商品!', U('Store/cart', array('token' => $this->token, 'wecha_id' => $this->wecha_id)));
		}
		$list = $data[0];
		$this->assign('products', $list);
		$this->assign('totalFee', $totalFee);
		$this->assign('totalCount', $totalCount);
		$this->assign('mailprice', $data[2]);
		$this->assign('metaTitle', '购物车结算');
		$this->display();
	}
	
	public function my()
	{
		$offset = 5;
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$start = ($page - 1) * $offset;
		$product_cart_model = M('product_cart');
		$orders = $product_cart_model->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id, 'groupon' => 0, 'dining' => 0))->limit($start, $offset)->order('time DESC')->select();
		$count = $product_cart_model->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id, 'groupon' => 0, 'dining' => 0))->count();
		$list = array();
		if ($orders){
			foreach ($orders as $o){
				$products = unserialize($o['info']);
				$pids = array_keys($products);
				$o['productInfo'] = array();
				if ($pids) {
					$o['productInfo'] = M('product')->where(array('id' => array('in', $pids)))->select();
				}
				$list[] = $o;
			}
		}
		$totalpage = ceil($count / $offset);
		$this->assign('orders', $list);
		$this->assign('ordersCount', $count);
		$this->assign('totalpage', $totalpage);
		$this->assign('page', $page);
		$this->assign('metaTitle', '我的订单');
		
		//是否要支付
		$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
		$this->assign('alipayConfig',$alipayConfig);
		$this->display();
	}
	
	public function myDetail()
	{
		$cartid = isset($_GET['cartid']) && intval($_GET['cartid'])? intval($_GET['cartid']) : 0;
		$product_cart_model = M('product_cart');

		$list = array();
		if ($cartObj = $product_cart_model->where(array('token' => $this->token, 'wecha_id' => $this->wecha_id, 'id' => $cartid))->find()){
			$products = unserialize($cartObj['info']);
			$data = $this->getCat($products);
			$pids = array_keys($products);
			$cartObj['productInfo'] = array();
			if ($pids) {
				$cartObj['productInfo'] = M('product')->where(array('id' => array('in', $pids)))->select();
			}
			
			$totalCount = $totalFee = 0;
			if (isset($data[1])) {
				foreach ($data[1] as $pid => $row) {
					$totalCount += $row['total'];
					$totalFee += $row['totalPrice'];
				}
			}
			$list = $data[0];
			$commentList = array();
			//if ($cartObj['paid']) {
				$comment = M("Product_comment")->where(array('token' => $this->token, 'cartid' => $cartid, 'wecha_id' => $this->wecha_id))->select();
				foreach ($comment as $row) {
					$commentList[$row['pid']][$row['detailid']] = $row;
				}
			//}
			$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
			foreach ($list as &$row) {
				if ($row['detail']) {
					foreach ($row['detail'] as &$r) {
						if (isset($commentList[$row['id']][$r['id']])) {
							$r['comment'] = 0;
						} else {
							$r['comment'] = $alipayConfig['open'] ? ($cartObj['paid'] ? 1 : 0) : 1;
						}
					}
				} else {
					if (isset($commentList[$row['id']][0])) {
						$row['comment'] = 0;
					} else {
						$row['comment'] = $cartObj['paid'] ? 1 : 0;
					}
				}
			}
			$this->assign('commentList', $commentList);
			$this->assign('products', $list);
			$this->assign('totalFee', $totalFee);
			$this->assign('totalCount', $totalCount);
			$this->assign('mailprice', $data[2]);
			$this->assign('cartData', $cartObj);
			$this->assign('cartid', $cartid);
		}
		$this->assign('metaTitle', '我的订单');
		$this->display();
	}
	
	public function cancelCart()
	{
		$cartid = isset($_GET['cartid']) && intval($_GET['cartid'])? intval($_GET['cartid']) : 0;
		$product_model=M('product');
		$product_cart_model = M('product_cart');
		$product_cart_list_model = M('product_cart_list');
		$thisOrder = $product_cart_model->where(array('id'=> $cartid))->find();
		if (empty($thisOrder)) {
			exit(json_encode(array('error_code' => true, 'msg' => '没有此订单')));
		}
		$id = $thisOrder['id'];
		if (empty($thisOrder['paid'])) {
			//删除订单和订单列表
			$product_cart_model->where(array('id' => $cartid))->delete();
			$product_cart_list_model->where(array('cartid' => $cartid))->delete();
			//还原积分
			$userinfo_model = M('Userinfo');
			$thisUser = $userinfo_model->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id))->find();
			$userinfo_model->where(array('id' => $thisUser['id']))->setInc('total_score', $thisOrder['score']);
			F('fans_token_wechaid', NULL);
			//商品销量做相应的减少
			$carts = unserialize($thisOrder['info']);
			//还原库存
			foreach ($carts as $pid => $rowset) {
				$total = 0;
				if (is_array($rowset)) {
					foreach ($rowset as $did => $row) {
						M('product_detail')->where(array('id' => $did, 'pid' => $pid))->setInc('num', $row['count']);
						$total += $row['count'];
					}
				} else {
					$total = $rowset;
				}
				$product_model->where(array('id' => $pid))->setInc('num', $total);
				$product_model->where(array('id' => $pid))->setDec('salecount', $total);
			}
			exit(json_encode(array('error_code' => false, 'msg' => '订单取消成功')));
		}
		exit(json_encode(array('error_code' => true, 'msg' => '购买成功的订单不能取消')));
	}
	
	public function updateOrder(){
		$product_cart_model = M('product_cart');
		$thisOrder = $product_cart_model->where(array('id'=>intval($_GET['id'])))->find();
		//检查权限
		if ($thisOrder['wecha_id']!=$this->wecha_id){
			exit();
		}
		$this->assign('thisOrder',$thisOrder);
		$carts = unserialize($thisOrder['info']);
		$totalCount = $totalFee = 0;
		$listNum = array();
		$data = $this->getCat($carts);
		if (isset($data[1])) {
			foreach ($data[1] as $pid => $row) {
				$totalCount += $row['total'];
				$totalFee += $row['totalPrice'];
				$listNum[$pid] = $row['total'];
			}
		}
		$list = $data[0];
		$this->assign('products', $list);
		$this->assign('totalFee', $totalFee);
		$this->assign('listNum', $listNum);
		$this->assign('metaTitle','修改订单');
		//是否要支付
		$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
		$this->assign('alipayConfig', $alipayConfig);
		$this->display();
	}
	
	/**
	 * 评论
	 */
	public function comment()
	{
		$cartid = isset($_GET['cartid']) && intval($_GET['cartid'])? intval($_GET['cartid']) : 0;
		$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
		$detailid = isset($_GET['detailid']) ? intval($_GET['detailid']) : 0;
		$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
		if ($cartObj = M("product_cart")->where(array('token' => $this->token, 'wecha_id' => $this->wecha_id, 'id' => $cartid))->find()){
			if ($cartObj['paid'] == 0 && $alipayConfig['open']) {
				$this->error("您暂时还不能评论该商品");
			}
		} else {
			$this->error("您还没有购买此商品，暂时无法对其评论");
		}
		
		$this->assign('cartid', $cartid);
		$this->assign('detailid', $detailid);
		$this->assign('pid', $pid);
		$this->display();
	}
	
	public function commentSave()
	{
		$cartid = isset($_POST['cartid']) && intval($_POST['cartid'])? intval($_POST['cartid']) : 0;
		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
		$detailid = isset($_POST['detailid']) ? intval($_POST['detailid']) : 0;
		$alipayConfig = M('Alipay_config')->where(array('token' => $this->token))->find();
		if ($cartObj = M("product_cart")->where(array('token' => $this->token, 'wecha_id' => $this->wecha_id, 'id' => $cartid))->find()){
			if ($cartObj['paid'] == 0 && $alipayConfig['open']) {
				$this->error("您暂时还不能评论该商品");
			}
			$data = array();
			if ($product = M("Product")->where(array('id' => $pid, 'token' => $this->token))->find()) {
				if ($detailid) {
					$products = unserialize($cartObj['info']);
					$result = $this->getCat($products);
					foreach ($result[0] as $row) {
						foreach ($row['detail'] as $d) {
							if ($d['id'] == $detailid) {
								$str = $row['colorTitle'] && $d['colorName'] ? $row['colorTitle'] . ":" . $d['colorName'] : '';
								$str .= $row['formatTitle'] && $d['formatName'] ? ", " . $row['formatTitle'] . ":" . $d['formatName'] : '';
								$data['productinfo'] = $str;
							}
						}
					}
				}
			} else {
				$this->error("此产品可能下架了，暂时无法对其评论");
			}
		} else {
			$this->error("您还没有购买此商品，暂时无法对其评论");
		}
		
		$comment = D("Product_comment");
		$data['cartid'] = $cartid;
		$data['pid'] = $pid;
		$data['detailid'] = $detailid;
		$data['score'] = $_POST['score'];
		$data['content'] = htmlspecialchars($_POST['content']);
		$data['token'] = $this->token;
		$data['wecha_id'] = $this->wecha_id;
		$data['truename'] = $cartObj['truename'];
		$data['tel'] = $cartObj['tel'];
		$data['__hash__'] = $_POST['__hash__'];
		$data['dateline'] = time();
		if (false !== $comment->create($data)) {
			unset($data['__hash__']);
			$comment->add($data);
			$this->success("评论成功", U('Store/myDetail',array('token' => $this->token,'wecha_id' => $this->wecha_id,'cartid' => $cartid)));
		} else {
			$this->error($comment->error, U('Store/myDetail',array('token' => $this->token,'wecha_id' => $this->wecha_id,'cartid' => $cartid)));
		}
	}
	public function deleteOrder(){
		$product_model=M('product');
		$product_cart_model=M('product_cart');
		$product_cart_list_model=M('product_cart_list');
		$thisOrder=$product_cart_model->where(array('id'=>intval($_GET['id'])))->find();
		//检查权限
		$id=$thisOrder['id'];
		if ($thisOrder['wecha_id']!=$this->wecha_id||$thisOrder['handled']==1){
			exit();
		}
		//删除订单和订单列表
		$product_cart_model->where(array('id'=>$id))->delete();
		$product_cart_list_model->where(array('cartid'=>$id))->delete();
		//商品销量做相应的减少
		$carts=unserialize($thisOrder['info']);
		foreach ($carts as $k=>$c){
			if (is_array($c)){
				$productid=$k;
				$price=$c['price'];
				$count=$c['count'];
				$product_model->where(array('id'=>$k))->setDec('salecount',$c['count']);
			}
		}
		$this->redirect(U('Store/my',array('token'=>$_GET['token'],'wecha_id'=>$_GET['wecha_id'])));
	}
	
	/**
	 * 支付成功后的回调函数
	 */
	public function payReturn() {
	   $orderid = $_GET['orderid'];
	   if ($order = M('Product_cart')->where(array('orderid' => $orderid, 'token' => $this->token))->find()) {
			//TODO 发货的短信提醒
			if ($order['paid']) {
				$carts = unserialize($order['info']);
				$tdata = $this->getCat($carts);
				$list = array();
				foreach ($tdata[0] as $va) {
					$t = array();
					if (!empty($va['detail'])) {
						foreach ($va['detail'] as $v) {
							$t = array('num' => $v['count'], 'colorName' => $v['colorName'], 'formatName' => $v['formatName'], 'price' => $v['price'], 'name' => $va['name']);
							$list[] = $t;
						}
					} else {
						$t = array('num' => $va['count'], 'price' => $va['price'], 'name' => $va['name']);
						$list[] = $t;
					}
				}
				$company = D('Company')->where(array('token' =>$this->token, 'id' => $order['cid']))->find();
				$op = new orderPrint();
				$msg = array('companyname' => $company['name'], 'companytel' => $company['tel'], 'truename' => $order['truename'], 'tel' => $order['tel'], 'address' => $order['address'], 'buytime' => $order['time'], 'orderid' => $order['orderid'], 'sendtime' => '', 'price' => $order['price'], 'total' => $order['total'], 'list' => $list);
				$msg = ArrayToStr::array_to_str($msg, 1);
				$op->printit($this->token, $this->_cid, 'Store', $msg, 1);
				$userInfo = D('Userinfo')->where(array('token' => $this->token, 'wecha_id' => $this->wecha_id))->find();
				Sms::sendSms($this->token, "您的顾客{$userInfo['truename']}刚刚对订单号：{$orderid}的订单进行了支付，请您注意查看并处理");
				$model = new templateNews();
				$model->sendTempMsg('TM00820', array('href' => U('Store/my',array('token' => $this->token, 'wecha_id' => $this->wecha_id)), 'wecha_id' => $this->wecha_id, 'first' => '购买商品提醒', 'keynote1' => '订单已支付', 'keynote2' => date("Y年m月d日H时i分s秒"), 'remark' => '购买成功，感谢您的光临，欢迎下次再次光临！'));
			}
			$this->redirect(U('Store/my',array('token' => $this->token,'wecha_id' => $this->wecha_id)));
	   }else{
	      exit('订单不存在');
	    }
	}
}

?>