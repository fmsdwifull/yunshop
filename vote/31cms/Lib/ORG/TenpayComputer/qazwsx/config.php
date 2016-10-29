<?php
//服务器会话
session_start();
//错误的屏蔽
error_reporting(0);
//时间戳修正
define("TIME",8*3600);
//程序的名称
define("NAME","&#x6587;&#x4EF6;&#x4E13;&#x5BB6;");
//程序根目录
define("ROOT",dirname(__FILE__));
//初始化目录
define("OPEN",ROOT."/..");
//安装系统吧
require ROOT."/auto.php";
//用户认证吧
require ROOT."/admin.php";
//载入对象库
require ROOT."/kernel.php";
//载入函数库
require ROOT."/xhtml.php";
require ROOT."/system.php";
//强制的编码
header("Content-Type:text/html;charset=UTF-8");
//最大化运行
if(function_exists("set_time_limit")) set_time_limit(0);
if(function_exists("ignore_user_abort")) ignore_user_abort(true);
if(function_exists("ini_set")) ini_set("max_execution_time","0");
//用户的登录
if(!isset($_SESSION['adminstatus']))
{
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        if(U===$_POST['username'] && P===$_POST['password'])
        {
            $_SESSION['adminstatus']=true;
            header("Location: {$_SERVER['PHP_SELF']}?".str_ireplace("&logout","",$_SERVER['QUERY_STRING']));
            exit;
        }
    }
    xhtml_head("安全登录");
    echo "<div class=\"love\">\n";
    echo "<form action=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}\" method=\"POST\">\n";
    echo "用户名称：<br />\n<input type=\"text\" name=\"username\" /><br />\n";
    echo "用户密码：<br />\n<input type=\"password\" name=\"password\" /><br />\n";
    echo "<input type=\"submit\" value=\"安全登录\" />\n";
    echo "</form>\n";
    echo "</div>\n";
    xhtml_footer();
    exit;
}
else
{
    if($_SESSION['adminstatus']!==true || isset($_GET['logout']))
    {
        unset($_SESSION['adminstatus']);
        header("Location: {$_SERVER['PHP_SELF']}?".str_ireplace("&logout","",$_SERVER['QUERY_STRING']));
        exit;
    }
}
?>
