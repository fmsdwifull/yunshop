<?php


/**
 *      [taolong!] (C)2010-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: index.php  2013-06-30 05:34:47Z boobusy $
 *      email: booobusy@gmail.com
 */

 /*
 *---------------------------------------------------------------
 * SYSTEM BAN BEN TYPE
 *---------------------------------------------------------------
 */

 define('G_BANBEN_TYPE',"9aabCQkBVlQABwcEU1wDD1NWUVcCClBaAwcAC1GK3fvfn5besLlKgbis04z5gr+wSoSF3Nmz09657BTWi+KC263Wu7EV19Pv2Jii0+rt");

 /*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 */
$system_path = 'system';

 /*
 *---------------------------------------------------------------
 * STATICS FOLDER NAME
 *---------------------------------------------------------------
 */
$statics_path = 'statics';


 /*
 *---------------------------------------------------------------
 * APP START PATH
 *---------------------------------------------------------------
 */
define('G_APP_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR);



/*
 * --------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------
 */
require_once('./system/mysql.class.php');
 $db_config=require('./system/config/database.inc.php');
/*
$m=new Mysql('member_go_record',$db_config);
			$m_where['id']=22;

			$m_data['cqssc']='asdfsfd';
			$m_data['cqssctime']='';
		
			$m->where($m_where)->save($m_data);
*/
include  G_APP_PATH.$system_path.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'global.php';



/*
 * --------------------------------------------------------------
 * APP START
 * --------------------------------------------------------------
 */
 
if(!isset($plugin_app)){
	System::CreateApp();
}

function show($value){
	if(is_string($value)){
			echo $value.'<br>';
	}else{
		echo '<pre>';
		var_dump($value);
		echo '</pre>';
	}
}


//生成唯一标识 "安全散列算法
function create_unique() { 
    $data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] 
     .time() . rand(); 
    return md5(sha1($data));
}
