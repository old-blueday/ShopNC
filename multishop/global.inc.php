<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : global.inc.php   FILE_PATH : .\global.inc.php
 * ....全局设置文件
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Tue Aug 07 13:28:06 CST 2007
 */
error_reporting(7);
ini_set ('memory_limit', '512M');
ini_set('magic_quotes_sybase','0');

if (!file_exists("install/lock") && file_exists("install/index.php")){
	@header("location: install/index.php");
	exit;
}
if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE){
	$system_folder = str_replace("\\", "/", realpath(dirname(__FILE__)));
}else {
	$system_folder = str_replace("\\", "/", dirname(__FILE__));
}
define("BasePath",$system_folder);
define("IN_SHOPNC",true);
require_once(BasePath."/classes/core/include.core.php");
?>