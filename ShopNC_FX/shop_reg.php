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
* FILE_NAME : shop_reg.php D:\root\shopnc6_jh\shop_reg.php
* 网店注册
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:52:14 CST 2009
*/
require("shop.global.inc.php");
class ShowShopReg extends ShopCommonFrameWork {
	public function main() {
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("templates/shops");
		/**
		 * 语言包
		 */
		$this->getlang("shop_user,shop_common");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'login':
				$this->showLogin();		//网店店主登录
				break;
			default:
				$this->showReg();		//网店注册
		}
	}
	/**
	 * 网店注册页面
	 *
	 */
	private function showReg() {
		$this->shopshowpage("reg");
	}
	/**
	 * 网店登录页面
	 *
	 */
	private function showLogin() {
		$this->shopshowpage("login");
	}
}
$shop_reg = new ShowShopReg();
$shop_reg->main();
unset($shop_reg);
?>