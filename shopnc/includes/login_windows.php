<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : login_windows.php D:\binzi\shopnc6\includes\login_windows.php
* 嵌入页面的登录窗口
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Wed Dec 17 11:27:59 CST 2008
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