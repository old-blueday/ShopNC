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
* FILE_NAME : login_windows.php D:\root\shopnc6_jh\includes\login_windows.php
* 嵌入页面的登录窗口
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:28:13 CST 2009
*/
require("global.inc.php");
class loginWindows extends CommonFrameWork {

	function main() {
		/**
		 * 语言包
		 */
		$this->getlang("index");
		/**
		 * 登录
		 */
		$this->showLoginWindows();
	}
	/**
	 * 登录窗口
	 *
	 */
	function showLoginWindows() {
		/*添加验证信息(登录时的csrf验证)*/
		include("seride.php");
		$Seride = new Seride();
		$this->output('seride_form',$Seride->seride_form());
		
		$this->showpage('login_windows');
	}
}
$login_windows	= new loginWindows();
$login_windows->main();
unset($login_windows);
?>