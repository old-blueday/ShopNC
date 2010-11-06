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
* FILE_NAME : cart_windows.php D:\root\shopnc6_jh\includes\cart_windows.php
* 前台购物车窗口
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:28:02 CST 2009
*/
require("global.inc.php");
class ShowCartWindows extends CommonFrameWork {
	/**
	 * 购物车对象
	 *
	 * @var obj
	 */
	private $obj_shop_cart;
	
	function main() {
		/**
		 * 创建购物车对象
		 */
		if (!is_object($this->obj_shop_cart)) {
			require_once("shopCart.class.php");
			$this->obj_shop_cart = new ShopCartClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("index");
		/**
		 * 购物车输出
		 */
		$this->showCart();
	}
	/**
	 * 购物车信息
	 *
	 */
	function showCart() {
		$goods_count	= $this->obj_shop_cart->GoodsCount();
		$this->output('goods_count',$goods_count);//购买商品数量
		$this->showpage('cart_window');
	}
}
$cart_windows	= new ShowCartWindows();
$cart_windows->main();
unset($cart_windows);
?>