<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想分销王系统 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : global.inc.php D:\root\shopnc6_jh\global.inc.php
* 全局设置文件
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:45:20 CST 2009
*/
error_reporting(7);

if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE){
	$system_folder = str_replace("\\", "/", realpath(dirname(__FILE__)));//realpath返回规范化的绝对路径名字
}else {
	$system_folder = str_replace("\\", "/", dirname(__FILE__));
}

define("BasePath",$system_folder);
require_once(BasePath."/classes/module/commonframework.class.php");
require_once(BasePath."/classes/module/systemframework.class.php");

if(function_exists('date_default_timezone_set')){
	date_default_timezone_set('Asia/Shanghai');
}

?>