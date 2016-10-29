<?php
function show($value){
	if(is_string($value)){
			echo $value.'<br>';
	}else{
		echo '<pre>';
		var_dump($value);
		echo '</pre>';
	}
}
require_once('./system/mysql.class.php');
$db_config=require('./system/config/database.inc.php');
/*
 *	cookie设置 获取 删除
 *
 */
function cookie($name='',$value='',$option=null){
	// 默认设置
	/*
    	$config = array(
        	'prefix'    =>  C('COOKIE_PREFIX'), 	// cookie 名称前缀
        	'expire'    =>  C('COOKIE_EXPIRE'), 	// cookie 保存时间
        	'path'      =>  C('COOKIE_PATH'), 	// cookie 保存路径
        	'domain'    =>  C('COOKIE_DOMAIN'), 	// cookie 有效域名
        	'httponly'  =>  C('COOKIE_HTTPONLY'), 	// httponly设置
	);
	*/

	//参数设置 会覆盖默认设置
	if (!is_null($option)) {
		//检查数据是否是字符串或数字
        	if (is_numeric($option))
            		$option = array('expire' => $option);
        	elseif (is_string($option))
            		parse_str($option, $option);
        	$config     = array_merge($config, array_change_key_case($option));
	}
	if(!empty($config['httponly'])){
        	ini_set("session.cookie_httponly", 1);
    	}
    	// 清除指定前缀的所有cookie
    	if (is_null($name)) {
        	if (empty($_COOKIE))
            		return;
        	// 要删除的cookie前缀，不指定则删除config设置的指定前缀
        	$prefix = empty($value) ? $config['prefix'] : $value;
        	if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
            		foreach ($_COOKIE as $key => $val) {
                		if (0 === stripos($key, $prefix)) {
                    			setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                    			unset($_COOKIE[$key]);
                		}
            		}
        	}
        	return;
    	}elseif('' === $name){
        	// 获取全部的cookie
        	return $_COOKIE;
    	}
    	$name = $config['prefix'] . str_replace('.', '_', $name);
    	if ('' === $value) {
        	if(isset($_COOKIE[$name])){
            		$value =    $_COOKIE[$name];
            		if(0===strpos($value,'think:')){
                		$value  =   substr($value,6);
                		return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
            		}else{
                		return $value;
            		}
        	}else{
            		return null;
        	}
    	} else {
        	if (is_null($value)) {
            		setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            		unset($_COOKIE[$name]); // 删除指定cookie
        	} else {
            		// 设置cookie
            		if(is_array($value)){
                		$value  = 'think:'.json_encode(array_map('urlencode',$value));
            		}
            		$expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            		setcookie($name, $value, $expire, $config['path'], $config['domain']);
            		$_COOKIE[$name] = $value;
       		}
    	}

}

/*
 *	session管理函数
 */
function session($name=null,$value=''){
	$prefix   =  '';	//获取session前缀
	
	if(is_array($name)){
		if(isset($name['prefix'])) session_id($name['prefix']);	//设置session_id		
	}

	if(@$name['expire'] > 0){
		$SESSION_EXPIRE=$name['expire'];
	}else{
		$SESSION_EXPIRE='';
	}
	
	ini_set('session.gc_maxlifetime', $SESSION_EXPIRE);	//设置session有效时间

	//如果session在未开启状态 并且session自动开启时
	if(!isset($_SESSION)){
		session_start();
	}
	//如果值没填或者为空
	if((!is_array($name)) && $value === ''){
		//获取全部session
		if($name === ''){
			return $prefix ? @$_SESSION[$prefix] : $_SESSION;
		//操作
		}elseif(strpos($name,'[') === 0){
			if('[pause]'==$name){ // 暂停session
                		session_write_close();
            		}elseif('[start]'==$name){ // 启动session
                		session_start();
            		}elseif('[destroy]'==$name){ // 销毁session
                		$_SESSION =  array();
                		session_unset();
                		session_destroy();
            		}elseif('[regenerate]'==$name){ // 重新生成id
                		session_regenerate_id();
			}elseif('[session_id]'==$name){	//获取session_id
				return session_id();
			}
		//检查session
		}elseif(strpos($name,'?') === 0){
			$name   =  substr($name,1);
            		if(strpos($name,'.')){ // 支持数组
            			list($name1,$name2) =   explode('.',$name);
                		return $prefix?isset($_SESSION[$prefix][$name1][$name2]):isset($_SESSION[$name1][$name2]);
            		}else{
                		return $prefix?isset($_SESSION[$prefix][$name]):isset($_SESSION[$name]);
			}
		//清空session
		}elseif(is_null($name)){
			if($prefix) {
                		unset($_SESSION[$prefix]);
            		}else{
                		$_SESSION = array();
            		}
		}elseif($prefix){ // 获取session
            		if(strpos($name,'.')){
                		list($name1,$name2) =   explode('.',$name);
                		return isset($_SESSION[$prefix][$name1][$name2])?$_SESSION[$prefix][$name1][$name2]:null;  
            		}else{
                		return isset($_SESSION[$prefix][$name])?$_SESSION[$prefix][$name]:null;                
            		}            
        	}else{
            		if(strpos($name,'.')){
                		list($name1,$name2) =   explode('.',$name);
                		return isset($_SESSION[$name1][$name2])?$_SESSION[$name1][$name2]:null;  
            		}else{
                		return isset($_SESSION[$name])?$_SESSION[$name]:null;
            		}            
       		}
	}elseif(is_null($value)){
		if($prefix){
            		unset($_SESSION[$prefix][$name]);
        	}else{
            		unset($_SESSION[$name]);
        	}
	}else{
		if($prefix){
            		if (!isset($_SESSION[$prefix])) {
                		$_SESSION[$prefix] = array();
            		}
            		$_SESSION[$prefix][$name]   =  $value;
        	}else{
            		$_SESSION[$name]  =  $value;
        	}
	}
}


