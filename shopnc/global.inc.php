<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : global.inc.php   FILE_PATH : \multishop\global.inc.php
 * ....全局设置文件
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net
 * @author ShopNC Develop Team 
 * @package
 * @subpackage
 * @version Tue Aug 07 13:28:06 CST 2007
 */
error_reporting(7);

if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE){
	$system_folder = str_replace("\\", "/", realpath(dirname(__FILE__)));//realpath返回规范化的绝对路径名字
}else {
	$system_folder = str_replace("\\", "/", dirname(__FILE__));
}

define("BasePath",$system_folder);
/* 对php版本的判断,运行本程序需要php5以上的版本 */
if (!file_exists(BasePath."/share/install.lock")){
	if(substr(phpversion(),0,1)<5) {
		echo 'Please use the php5';
		exit();
	}
}

require_once(BasePath."/classes/module/commonframework.class.php");
require_once(BasePath."/classes/module/systemframework.class.php");

if(function_exists('date_default_timezone_set')){
	date_default_timezone_set('Asia/Shanghai');
}

?>