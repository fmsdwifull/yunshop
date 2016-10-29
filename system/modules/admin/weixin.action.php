<?php 
defined('G_IN_SYSTEM')or exit('no');
System::load_app_class('admin',G_ADMIN_DIR,'no');
System::load_app_fun('global',G_ADMIN_DIR);

class weixin extends admin {
	public $appid='';
    	public $appsecret='';
    	public $token='';
	public function __construct(){
		parent::__construct();
		$this->db=System::load_sys_class("model");
		$this->ment=array(
						array("config","公众号参数",ROUTE_M.'/'.ROUTE_C."/config"),
						array("menu","自定义菜单",ROUTE_M.'/'.ROUTE_C."/menu"),
						array("rule","回复规则",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("material","素材管理",ROUTE_M.'/'.ROUTE_C."/material"),
						array("send_message","群发消息",ROUTE_M.'/'.ROUTE_C."/send_message")
						
						
		);
	
	}
	public function config(){
		if($_POST['dosubmit']){
			$user=htmlspecialchars($_POST['user']);
			$username=htmlspecialchars($_POST['username']);
			$avatar=htmlspecialchars($_POST['fileimage']);
			$nick=htmlspecialchars($_POST['nick']);
			$ghid=htmlspecialchars($_POST['ghid']);
			$appid=htmlspecialchars($_POST['appid']);
			$appsecret=htmlspecialchars($_POST['appsecret']);
			$this->db->Query("UPDATE `@#_1024_wx_mpset` SET `user`='$user',`username`='$username',`avatar`='$avatar',`nick`='$nick',`ghid`='$ghid',`appid`='$appid',`appsecret`='$appsecret' WHERE (`id`='6')");
			
			$html=<<<HTML
			<?php 
			return array (	
				'user' => '{$user}',	
				'username' => '{$username}',
				'avatar' => '{$avatar}',		
				'nick' => '{$nick}',				
				'ghid' => "{$ghid}",
				'appid' => "{$appid}",  		
				'appsecret' => "{$appsecret}"  	
			);
			?>
HTML;
			if(!is_writable(G_CONFIG.'weixin.inc.php')) _message('Please chmod  weixin  to 0777 !');
			$ok=file_put_contents(G_CONFIG.'weixin.inc.php',$html);
			if($this->db->affected_rows() && $ok){
				_message("修改成功");
			}else{
				_message("修改失败");
			}		
		}
		$web=System::load_sys_config('weixin');
		include $this->tpl(ROUTE_M,'weixin.config');
	}

	public function menu(){
		$this->ment=array(
						array("menu","菜单管理",ROUTE_M.'/'.ROUTE_C."/menu"),
						array("add_menu","添加菜单",ROUTE_M.'/'.ROUTE_C."/add_menu"),
		);
		
		$menulist=$this->db->GetList("SELECT * FROM `@#_1024_wx_menu` WHERE `pid`='0' order by `order` DESC");
		foreach($menulist as $k=>$v){
			$sonlist=$this->db->GetList("SELECT * FROM `@#_1024_wx_menu` WHERE `pid`=$v[id] order by `order` DESC");
			$menulist[$k]['son']=$sonlist;
		}

		include $this->tpl(ROUTE_M,'weixin.menu');
	}
	public function add_menu(){
		$this->ment=array(
						array("menu","菜单管理",ROUTE_M.'/'.ROUTE_C."/menu"),
						array("add_menu","添加菜单",ROUTE_M.'/'.ROUTE_C."/add_menu"),
		);
		if($_POST['dosubmit']){
			$pid=$_POST['pid'];
			$name=$_POST['name'];
			$type=$_POST['type'];
			$value=$_POST['value'];
			$time=time();
			$sql="INSERT INTO `@#_1024_wx_menu`  (`pid`,`type`,`name`,`value`, `add_time`) VALUES ('$pid','$type', '$name','$value', '$time')";
			$this->db->Query($sql);
			
			if($this->db->affected_rows()){
					_message("菜单添加成功!",WEB_PATH.'/'.ROUTE_M.'/weixin/menu');
			}else{
					_message("菜单添加失败!");
			}
		}
		$categorys=$this->db->GetList("SELECT * FROM `@#_1024_wx_menu` WHERE `pid`='0'");
		include $this->tpl(ROUTE_M,'weixin.add_menu');
	}
	public function edit_menu(){
		$this->ment=array(
						array("menu","菜单管理",ROUTE_M.'/'.ROUTE_C."/menu"),
						array("add_menu","添加菜单",ROUTE_M.'/'.ROUTE_C."/add_menu"),
		);
		$id=intval($this->segment(4));
		if($_POST['dosubmit']){
			$id=$_POST['id'];
			$pid=$_POST['pid'];
			$name=$_POST['name'];
			$type=$_POST['type'];
			$value=$_POST['value'];
			$time=time();
			$sql="UPDATE `@#_1024_wx_menu` SET `pid`='$pid',`name`='$name',`type`='$type',`value`='$value',`add_time`='$time' WHERE (`id`=$id)";
			$this->db->Query($sql);
			if($this->db->affected_rows()){
					_message("菜单修改成功!",WEB_PATH.'/'.ROUTE_M.'/weixin/menu');
			}else{
					_message("菜单修改失败!");
			}

		}
		$categorys=$this->db->GetList("SELECT * FROM `@#_1024_wx_menu` WHERE `pid`='0'");
		$menuinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_menu` WHERE `id`=$id ");
		include $this->tpl(ROUTE_M,'weixin.edit_menu');
	}


	public function del_menu(){
		$id=intval($this->segment(4));
		if(!intval($id)){echo "no";exit;}
		$list=$this->db->Query("SELECT * FROM  `@#_1024_wx_menu` WHERE `pid`='$id'");
		$r=$this->db->Query("DELETE FROM `@#_1024_wx_menu` WHERE (`id`='$id')");
		
		if($list){
			$this->db->Query("DELETE FROM `@#_1024_wx_menu` WHERE (`pid`='$id')");
		}
		
		if($r){			
				echo WEB_PATH.'/'.ROUTE_M.'/weixin/menu/';
			}else{
				echo "no";	
			}
	}
	public function material(){
		$this->ment=array(
						array("material","文字素材",ROUTE_M.'/'.ROUTE_C."/material"),
						array("news_material","图文素材",ROUTE_M.'/'.ROUTE_C."/news_material"),
						array("add_news","添加图文素材",ROUTE_M.'/'.ROUTE_C."/add_news"),
		);
		$cateid=intval($this->segment(4));
		$list_where = '';
		if(!$cateid){
			$list_where = "1";
		}else{
			$list_where = "`cateid` = '$cateid'";
		}
		$num=20;
		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_1024_wx_mate_text` WHERE $list_where");
		$page=System::load_sys_class('page');
		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	
		$page->config($total,$num,$pagenum,"0");
		$articlelist=$this->db->GetPage("SELECT * FROM `@#_1024_wx_mate_text` WHERE $list_where order by `id` DESC",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0));
		include $this->tpl(ROUTE_M,'weixin.material');
	}
	public function del_material(){
		$id=intval($this->segment(4));
		if(!intval($id)){echo "no";exit;}
		$this->db->Query("DELETE FROM `@#_1024_wx_mate_text` WHERE (`id`='$id')");
		if($this->db->affected_rows()){
					echo WEB_PATH.'/'.ROUTE_M.'/weixin/material/';
			}else{
					echo "no";
			}
	}
	public function news_material(){
		$this->ment=array(
						array("material","文字素材",ROUTE_M.'/'.ROUTE_C."/material"),
						array("news_material","图文素材",ROUTE_M.'/'.ROUTE_C."/news_material"),
						array("add_news","添加图文素材",ROUTE_M.'/'.ROUTE_C."/add_news"),
		);
		$num=20;
		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_1024_wx_mate_news`");
		$page=System::load_sys_class('page');
		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	
		$page->config($total,$num,$pagenum,"0");
		$articlelist=$this->db->GetPage("SELECT * FROM `@#_1024_wx_mate_news` order by `id` DESC",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0));
		include $this->tpl(ROUTE_M,'weixin.news_material');
	}
	public function edit_news(){
		$this->ment=array(
						array("material","文字素材",ROUTE_M.'/'.ROUTE_C."/material"),
						array("news_material","图文素材",ROUTE_M.'/'.ROUTE_C."/news_material"),
						array("add_news","添加图文素材",ROUTE_M.'/'.ROUTE_C."/add_news"),
		);
		$id=intval($this->segment(4));
		$newsinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_news` WHERE `id`=$id");
		if($_POST['dosubmit']){
			$title=$_POST['title'];
			$title_style_color=$_POST['title_style_color'];
			$title_style_bold=$_POST['title_style_bold'];
			$intro=$_POST['description'];
			$cover=$_POST['thumb'];
			$sub_text_des=$_POST['sub_text_des'];
			$sub_text_len=$_POST['sub_text_len'];
			$addtime=strtotime($_POST['posttime']);
			$content=$_POST['content'];
			$son=$_POST['selectin'];
			if(empty($title)){_message("标题不能为空");}
			if(empty($cover)){_message("封面不能为空");}
			if(empty($content)){_message("内容不能为空");}
			if($cover != $newsinfo['cover']){
				@unlink(G_UPLOAD.$newsinfo['cover']);
			}
			if($son){
				$multi=1;
			}else{
				$multi=0;
			}
			$this->db->Query("UPDATE `@#_1024_wx_mate_news` SET `title`='$title',`son`='$son',`multi`=$multi,`cover`='$cover',`intro`='$intro',`content`='$content',`add_time`='$addtime' WHERE `id`=$id");
			if($this->db->affected_rows()){
				_message("修改成功",WEB_PATH.'/'.ROUTE_M.'/weixin/news_material');
			}else{
				_message("修改失败");
			}
			
		}
		
		if($newsinfo['son']){
			$arr=explode(',',$newsinfo['son']);
			$arr=array_filter($arr);
			foreach ($arr as $k => $v) {
				$title=$this->db->GetOne("SELECT `title` FROM `@#_1024_wx_mate_news` WHERE `id`=$v");
				if($title){
					$return[]=$arr[$k].','.$title['title'];
				}
				
				
			}
			$newsinfo['sonlist']=$return;
		}

		include $this->tpl(ROUTE_M,'weixin.edit_news');
	}
	public function del_news(){
		$id=intval($this->segment(4));
		if(!intval($id)){echo "no";exit;}
		$sonlist=$this->db->GetList("SELECT `son`,`id` FROM `@#_1024_wx_mate_news`");
		foreach($sonlist as $v){
			$v['son']=str_replace($id.',','',$v['son']);
			
			if(!$v['son']){
				$this->db->Query("UPDATE `@#_1024_wx_mate_news` SET `son`='$v[son]',`multi`=0 WHERE `id`=$v[id]");
			}else{
				$this->db->Query("UPDATE `@#_1024_wx_mate_news` SET `son`='$v[son]' WHERE `id`=$v[id]");
			}
		}

		
		$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_news` WHERE `id`=$id");
		$this->db->Query("DELETE FROM `@#_1024_wx_mate_news` WHERE (`id`='$id')");
		if($info['cover']){
			@unlink(G_UPLOAD.$info['cover']);
		}

		if($this->db->affected_rows()){
					echo WEB_PATH.'/'.ROUTE_M.'/weixin/news_material/';
			}else{
					echo "no";
			}
	}
	public function add_news(){
		$this->ment=array(
						array("material","文字素材",ROUTE_M.'/'.ROUTE_C."/material"),
						array("news_material","图文素材",ROUTE_M.'/'.ROUTE_C."/news_material"),
						array("add_news","添加图文素材",ROUTE_M.'/'.ROUTE_C."/add_news"),
		);
		if($_POST['dosubmit']){

			$title=$_POST['title'];
			$title_style_color=$_POST['title_style_color'];
			$title_style_bold=$_POST['title_style_bold'];
			$intro=$_POST['description'];
			$cover=$_POST['thumb'];
			$sub_text_des=$_POST['sub_text_des'];
			$sub_text_len=$_POST['sub_text_len'];
			$addtime=strtotime($_POST['posttime']);
			$content=$_POST['content'];
			$link=$_POST['link'];
			$son=$_POST['selectin'];
			if(empty($title)){_message("标题不能为空");}
			if(empty($cover)){_message("封面不能为空");}
			if(empty($content)){_message("内容不能为空");}
			if($son){
				$multi=1;
			}else{
				$multi=0;
			}
			if($intro==''&&$sub_text_des=='off'){
				$intro=substr($content,0,$sub_text_len);
			}
			$this->db->Query("INSERT INTO `@#_1024_wx_mate_news` (`title`,`son`,`multi`,`cover`,`intro`,`link`,`content`,`add_time`) VALUES ('$title','$son','$multi','$cover','$intro','$link','$content','$addtime')");
			if($this->db->affected_rows()){
				_message("添加成功",WEB_PATH.'/'.ROUTE_M.'/weixin/news_material');
			}else{
				_message("添加失败");
			}
		}
		include $this->tpl(ROUTE_M,'weixin.add_news');
	}
	public function news_select(){
		$articlelist=$this->db->GetList("SELECT * FROM `@#_1024_wx_mate_news`");
		
		include $this->tpl(ROUTE_M,'weixin.news_select');
	}
	public function rule_news_select(){
		$articlelist=$this->db->GetList("SELECT * FROM `@#_1024_wx_mate_news`");
		include $this->tpl(ROUTE_M,'weixin.rule_news_select');
	}
	public function rule(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
	$num=20;
		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_1024_wx_api_text`");
		$page=System::load_sys_class('page');
		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	
		$page->config($total,$num,$pagenum,"0");
		$articlelist=$this->db->GetPage("SELECT * FROM `@#_1024_wx_api_text` order by `id` DESC",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0));
	include $this->tpl(ROUTE_M,'weixin.rule');
	}
	public function add_rule(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
		if($_POST['dosubmit']){
			$resp_type=$_POST['resp_type'];
			$keyword=$_POST['keyword'];
			$value=$_POST['value'];
			$resp_rid=$_POST['resp_rid'];
			$time=time();
			if(empty($keyword)){_message('关键词不能为空');}
			if($resp_type=='text'){
				$this->db->Query("INSERT INTO `@#_1024_wx_mate_text`  (`text`,`add_time`) VALUES ('$value','$time')");
				$r=$this->db->insert_id();
				$t=$this->db->Query("INSERT INTO `@#_1024_wx_api_text`  (`keyword`,`table`,`rid`,`add_time`) VALUES ('$keyword','$resp_type', '$r','$time')");
			}
			if($resp_type=='news'){
				$t=$this->db->Query("INSERT INTO `@#_1024_wx_api_text` (`keyword`,`table`,`rid`,`add_time`) VALUES ('$keyword','$resp_type',$resp_rid,'$time')");
			}
			if($t){
					_message("添加成功",WEB_PATH.'/'.ROUTE_M.'/weixin/rule');
			}else{
					_message("添加失败");
			}
			
			exit;
		}
		include $this->tpl(ROUTE_M,'weixin.add_rule');
	}
	public function edit_rule(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
		$id=intval($this->segment(4));
		if($_POST['dosubmit']){
			$keyword=$_POST['keyword'];
			if($_POST['value']){
				$value=$_POST['value'];
			}
			$resp_type=$_POST['resp_type'];
			$time=time();
			$this->db->Query("UPDATE `@#_1024_wx_api_text` SET `keyword`='$keyword',`add_time`=$time WHERE `id`=$id ");
			if($resp_type=='text'){
				if($value){
					$this->db->Query("INSERT INTO `@#_1024_wx_mate_text` (`text`,`add_time`) VALUES ('$value','$time')");
					$r=$this->db->insert_id();
					$this->db->Query("UPDATE `@#_1024_wx_api_text` SET `table`='$resp_type',`rid`=$r,`add_time`=$time WHERE `id`=$id");
				}
			}
			if($this->db->affected_rows()){
				_message("修改成功",WEB_PATH.'/'.ROUTE_M.'/weixin/rule');
			}else{
				_message("修改失败");
			}
		}
		$api_info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_text` WHERE `id`='$id'");
		if($api_info['table']=='text'){
			$text_info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_text`  WHERE `id`='$api_info[rid]'");
			$api_info['text']=$text_info['text'];
		}
		if($api_info['table']=='news'){
			$api_info['text']=$api_info['table'].'#'.$api_info['rid'];
		}
	
		include $this->tpl(ROUTE_M,'weixin.edit_rule');
	}
	public function del_rule(){
		$id=intval($this->segment(4));
		if(!intval($id)){echo "no";exit;}
		$this->db->Query("DELETE FROM `@#_1024_wx_api_text` WHERE (`id`='$id')");
		if($this->db->affected_rows()){
					echo WEB_PATH.'/'.ROUTE_M.'/weixin/rule/';
			}else{
					echo "no";
			}
	}
	public function notfound(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
		$notinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_notfound`");
		include $this->tpl(ROUTE_M,'weixin.notfound');
	}
	public function edit_notfound(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
		$id=intval($this->segment(4));
		if($_POST['dosubmit']){
			$resp_type=$_POST['resp_type'];
			$resp_rid=$_POST['resp_rid'];
			$value=$_POST['value'];
			$time=time();
			if($resp_type==''||$resp_type=='text'){
				if($value){
					$this->db->Query("INSERT INTO `@#_1024_wx_mate_text` (`text`,`add_time`) VALUES ('$value','$time') ");
					$r=$this->db->insert_id();
					$this->db->Query("UPDATE `@#_1024_wx_api_notfound` SET `table`='$resp_type',`rid`=$r,`add_time`=$time WHERE `id`=$id");
				}
				
			}
			if($resp_type=='news'){
				$this->db->Query("UPDATE `@#_1024_wx_api_notfound` SET `table`='$resp_type',`rid`='$resp_rid',`add_time`='$time' WHERE `id`=$id");
			}
			if($this->db->affected_rows()){
				_message("修改成功",WEB_PATH.'/'.ROUTE_M.'/weixin/notfound');
			}else{
				_message("修改失败");
			}
		}
		$notinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_notfound` WHERE 	`id`='$id'");
		if($notinfo['table']=='text'){
			$text_info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_text` WHERE `id`=$notinfo[rid]");
			$notinfo['text']=$text_info['text'];
		}
		if($notinfo['table']=='news'){
			$notinfo['text']=$notinfo['table'].'#'.$notinfo['rid'];
		}
		include $this->tpl(ROUTE_M,'weixin.edit_notfound');

	}
	public function event_rule(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
		$eventinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_event` WHERE `event`='subscribe'");
		include $this->tpl(ROUTE_M,'weixin.event_rule');
	}
	public function edit_event(){
		$this->ment=array(
						array("rule","关键词回复",ROUTE_M.'/'.ROUTE_C."/rule"),
						array("notfound","默认回复",ROUTE_M.'/'.ROUTE_C."/notfound"),
						array("event_rule","事件规则",ROUTE_M.'/'.ROUTE_C."/event_rule"),
		);
		$id=intval($this->segment(4));
		if($_POST['dosubmit']){
			$resp_type=$_POST['resp_type'];
			$resp_rid=$_POST['resp_rid'];
			$value=$_POST['value'];
			$time=time();
			if($resp_type==''||$resp_type=='text'){
				if($value){
					$this->db->Query("INSERT INTO `@#_1024_wx_mate_text` (`text`,`add_time`) VALUES ('$value','$time') ");
					$r=$this->db->insert_id();
					$this->db->Query("UPDATE `@#_1024_wx_api_event` SET `table`='$resp_type',`rid`=$r,`add_time`=$time WHERE `id`=$id");
				}
				
			}
			if($resp_type=='news'){
				$this->db->Query("UPDATE `@#_1024_wx_api_event` SET `table`='$resp_type',`rid`=$resp_rid,`add_time`='$time' WHERE `id`=$id");
			}
			if($this->db->affected_rows()){
				_message("修改成功",WEB_PATH.'/'.ROUTE_M.'/weixin/event_rule');
			}else{
				_message("修改失败");
			}
		}
		$eventinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_api_event` WHERE `event`='subscribe'");
		if($eventinfo['table']=='text'){
			$text_info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_text` WHERE `id`=$eventinfo[rid]");
			$eventinfo['text']=$text_info['text'];
		}
		if($eventinfo['table']=='news'){
			$eventinfo['text']=$eventinfo['table'].'#'.$eventinfo['rid'];
		}
		include $this->tpl(ROUTE_M,'weixin.edit_event');
	}
    //获取所有关注着列表
    protected function get_all_openid(){
    		$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mpset` WHERE `id`=6");
	        $appid      = $info['appid']; 
	        $appsecret  = $info['appsecret']; 
	        if( !$appid || !$appsecret ){
	            $this->error('未填写AppId或AppSecret开发者凭据~');
	        }  
	 $this->appid=$appid ; 
        	$this->appsecret = $appsecret ; 
    	$this->gettoken(); //获取凭据 ;
    	 $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->token;
    	  $ch = curl_init(); // 启动一个CURL会话
        	curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        	 $output = curl_exec($ch); // 执行操作
        	   curl_close($ch); // 关闭CURL会话
    	$output=json_decode($output,1);
	return $output;

    }

	public function send_message(){
		$num=20;
		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_1024_wx_api_send_all`");
		$page=System::load_sys_class('page');
		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	
		$page->config($total,$num,$pagenum,"0");
		$articlelist=$this->db->GetPage("SELECT * FROM  `@#_1024_wx_api_send_all` order by `id` DESC",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0));
		include $this->tpl(ROUTE_M,'weixin.send_message');
	}
	public function add_send_message(){
		if($_POST['dosubmit']){
			if($_POST['resp_type']=='text'){
				$value=$_POST['value'];
				$time=time();
				$this->db->Query("INSERT INTO `@#_1024_wx_mate_text` (`text`,`add_time`) VALUES ('$value','$time')");
				$r=$this->db->insert_id();

				$openarr=$this->get_all_openid();
				$openidlist=$openarr[data][openid];
				$value=urlencode($value);
				$msg=array('touser'=>$openidlist,'msgtype'=>'text','text'=>array('content'=>$value));
				$msg=urldecode(json_encode($msg));
				$url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->token;
				$ch = curl_init(); // 启动一个CURL会话
			        	curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
			        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
			        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			    	curl_setopt($ch, CURLOPT_POST, 1);
	    			curl_setopt($ch, CURLOPT_POSTFIELDS,$msg);
			        	$output = curl_exec($ch); // 执行操作
			        	curl_close($ch); // 关闭CURL会话
			    	$output=json_decode($output,1);
			    	$msg_id=$output['msg_id'];
				$this->db->Query("INSERT INTO `@#_1024_wx_api_send_all` (`table`,`rid`,`add_time`,`msg_id`) VALUES ('text','$r','$time','$msg_id')");
				if($this->db->affected_rows() && $output['errcode']==0){
					_message('发送成功',WEB_PATH.'/'.ROUTE_M.'/weixin/send_message');
				}else{
					_message('发送失败');
				}
			}
			if($_POST['resp_type']=='news'){
				
				$info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mpset` WHERE `id`=6");
				$appid      = $info['appid']; 
				$appsecret  = $info['appsecret']; 
				if( !$appid || !$appsecret ){
				            $this->error('未填写AppId或AppSecret开发者凭据~');
				} 
				$postnews=array();
				$this->appid=$appid ; 
		        		$this->appsecret = $appsecret ; 
		    		$this->gettoken(); //获取凭据 ; 

		    		
				 $news_id=$_POST['resp_rid'];
				 $newsinfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_news` WHERE `id`=$news_id");
				$type="thumb";
				$uploadurl="http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->token."&type={$type}";
				if($newsinfo['thumb_media_id']==''){
					$newsinfo['cover']=str_replace('/','\\',$newsinfo['cover']);
					$filepath=dirname(dirname(dirname(dirname(__FILE__))))."\\statics\\uploads\\".$newsinfo['cover'];
					$filedata=array('media'=>'@'.$filepath);
					$result=$this->https_request($uploadurl,$filedata);
					$result=json_decode($result,1);
					$up['thumb_media_id']=$result['thumb_media_id'];
					$this->db->Query("UPDATE `@#_1024_wx_mate_news` SET `thumb_media_id`='$result[thumb_media_id]' WHERE `id`=$news_id");
				}
				
				if($newsinfo['media_id']==''){
					$newsinfo['title']=urlencode($newsinfo['title']);
					$newsinfo['content']=urlencode($newsinfo['content']);
					$newsinfo['intro']=urlencode($newsinfo['intro']);
					$postnews=array('articles'=>array(
						array('thumb_media_id'=>$newsinfo['thumb_media_id'],
							'author'=>'',
							'title'=>$newsinfo['title'],
						
							'content_source_url'=>G_WEB_PATH.'/?/mobile/mobile/wxpage/'.$newsinfo['id'],
							'content'=>$newsinfo['content'],
							'digest'=>$newsinfo['intro'])
						)
					);
					if($newsinfo['son']){
						$schedulelist=explode(',',$newsinfo['son']);
						$schedulelist=array_filter($schedulelist);
						foreach($schedulelist as $v){
							$soninfo=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mate_news` WHERE `id`=$v");
							

							if($soninfo['thumb_media_id']==''){
								$soninfo['cover']=str_replace('/','\\',$soninfo['cover']);
								$fpath=dirname(dirname(dirname(dirname(__FILE__))))."\\statics\\uploads\\".$soninfo['cover'];
								$fdata=array('media'=>'@'.$fpath);
								$res=$this->https_request($uploadurl,$fdata);
								$res=json_decode($res,1);
								$this->db->Query("UPDATE `@#_1024_wx_mate_news` SET `thumb_media_id`='$res[thumb_media_id]' WHERE `id`=$v");
							}
							
							$soninfo['title']=urlencode($soninfo['title']);
							
							$soninfo['content']=urlencode($soninfo['content']);
							$soninfo['intro']=urlencode($soninfo['intro']);
							$postnews['articles'][]=array(
								'thumb_media_id'=>$soninfo['thumb_media_id'],
								'author'=>'',
								'title'=>$soninfo['title'],
								'content_source_url'=>G_WEB_PATH.'/?/mobile/mobile/wxpage/'.$soninfo['id'],
								'content'=>$soninfo['content'],
								'digest'=>$soninfo['intro']
								);

						}
						
					}
					$postnews=urldecode(json_encode($postnews));

					$tuwenurl="https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=".$this->token;
					$uploadnews=$this->https_request($tuwenurl,$postnews);
					$uploadnews=json_decode($uploadnews,1);
					var_dump($uploadnews);
					
					$this->db->Query("UPDATE `@#_1024_wx_mate_news` SET `media_id`='$uploadnews[media_id]' WHERE `id`=$news_id");
				}

				$sendurl="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->token;
				$openarr=$this->get_all_openid();
				$openidlist=$openarr['data']['openid'];
				$msg=array('touser'=>$openidlist,'msgtype'=>'mpnews','mpnews'=>array('media_id'=>$newsinfo['media_id']));
				$msg=json_encode($msg);
				$out=$this->https_request($sendurl,$msg);
				$out=json_decode($out,1);

				$time=time();
				

				$this->db->Query("INSERT INTO `@#_1024_wx_api_send_all` (`table`,`rid`,`add_time`,`msg_id`) VALUES ('$_POST[resp_type]','$news_id','$time','$out[msg_id]')");
				if($out['errcode']==0 && $this->db->affected_rows()){
					_message('群发成功',WEB_PATH.'/'.ROUTE_M.'/weixin/send_message');
				}else{
					_message('群发失败');
				}
			}
			
		}
		include $this->tpl(ROUTE_M,'weixin.add_send_message');
	}
	public function del_send_message(){
		$id=intval($this->segment(4));
		if(!intval($id)){echo "no";exit;}
		$this->db->Query("DELETE FROM `@#_1024_wx_api_send_all` WHERE (`id`='$id')");
		
	
		
		if($this->db->affected_rows()){
					echo WEB_PATH.'/'.ROUTE_M.'/weixin/send_message/';
			}else{
					echo "no";
		}
	}
	/*
    * 菜单同步
    */
    public function menuSync(){ 
        $info=$this->db->GetOne("SELECT * FROM `@#_1024_wx_mpset` WHERE `id`=6");  //从数据库中取出AppID和AppSecrect 
        $appid      = $info['appid']  ; 
        $appsecret  = $info['appsecret']  ; 
        if( !$appid || !$appsecret ){
            $this->error('未填写AppId或AppSecret开发者凭据~');
        }  
        $this->appid     = $appid ; 
        $this->appsecret = $appsecret ; 
        $r = $this->menuMake();//提交创建
        echo $r; 
    }

    /*
    * 提交菜单更新到公众号 
    */
    protected function menuMake(){
        $button = $this->makejson(); //获取按钮提交json格式
        if($this->token == '') $this->gettoken(); //获取凭据  
        $url = "http://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->token;
        $r = file_get_contents($url) ; //删除公众号原有菜单
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->token; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POST, 1 ) ; 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$button) ;
        //取到的$info 即为拿到的script 信息 
        $info =  curl_exec($ch) ;
        curl_close($ch);    //close the handle
        return $info;
    }
    /*
    * 取得当次能用的开发者凭据 . 
    */
    protected function gettoken(){
        $AppId = $this->appid ;
        $AppSecret = $this->appsecret ;
        $gettoken = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$AppId.'&secret='.$AppSecret;
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $gettoken); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            // echo 'Errno'.curl_error($curl);//捕抓异常
            return false;
        }
        curl_close($curl); // 关闭CURL会话
        $js = json_decode($tmpInfo,true);
        $this->token = $js['access_token'];
        //return $js['access_token'];
    }
    /*
    * 拼凑提交菜单的json数据 
    */
    public function makejson(){
        $data = array();
        $data['button'] = array();
        $list = $this->db->GetList("SELECT * FROM `@#_1024_wx_menu` WHERE `pid`=0");  //从数据库中取出微信菜单menu列表
        krsort($list);
        for($i=0;$i<count($list);$i++){
          
            $son=$this->db->GetList("SELECT * FROM `@#_1024_wx_menu` WHERE `pid`=".$list[$i]['id']);
            krsort($son);
            if($son){
                $data['button'][$i]['name'] = urlencode($list[$i]['name']);
                $data['button'][$i]['sub_button'] = array();
                for($n=0;$n<count($son);$n++){
                    $data['button'][$i]['sub_button'][$n]['type'] = strtolower($son[$n]['type']);
                    $data['button'][$i]['sub_button'][$n]['name'] = urlencode($son[$n]['name']);
                    if(strtolower($son[$n]['type']) == "click"){
                        $data['button'][$i]['sub_button'][$n]['key'] = urlencode($son[$n]['value']);
                    }else{
                        $data['button'][$i]['sub_button'][$n]['url'] = urlencode($son[$n]['value']);
                    }
                }
            }else{
                $data['button'][$i]['type'] = strtolower($list[$i]['type']);
                $data['button'][$i]['name'] = urlencode($list[$i]['name']);
                if(strtolower($list[$i]['type']) == "click"){
                    $data['button'][$i]['key'] = urlencode($list[$i]['value']);
                }else{
                    $data['button'][$i]['url'] = urlencode($list[$i]['value']);
                } 
            }
        }  
        return urldecode(json_encode($data));
    }
    private function https_request($url, $data = null){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	    if (!empty($data)){
	        curl_setopt($curl, CURLOPT_POST, 1);
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    }
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $output = curl_exec($curl);
	    curl_close($curl);
	    return $output;
}	
}

?>