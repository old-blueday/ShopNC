<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : error.php   FILE_PATH : \multishop\member\error.php
 * ....报错页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Sep 18 11:35:03 CST 2007
 */
require_once("../global.inc.php");

class Error extends CommonFrameWork{
	function main(){
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 页面输出
		 */
		$this->output('backurl',$this->_input['backurl']);
		$this->output('error_message', urldecode($this->_input['message']));
		$this->showpage('error');
	}
}

$error = new Error();
$error->main();
unset($error);
?>