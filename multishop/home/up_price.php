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
 * FILE_NAME : channel.php   FILE_PATH : E:\www\multishop\trunk\home\userinfo.php
 * ....竞拍 系统加价
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Dec 18 10:08:14 CST 2008
 */
require ("../global.inc.php");

class ShowUpPrice extends CommonFrameWork {
	/**
	 * 店铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;

	function main(){
		/**
		 * 创建加价操作对象
		 */
		if (!is_object($this->obj_up_price)){
			require_once("up_price.class.php");
			$this->obj_up_price = new UpPriceClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("upprice");

		/**
		 * 取得加价列表
		 */
		$price_list = $this->obj_up_price->getUpPriceList($page);
		/**
		 * 输出到页面模板
		 */
		$this->output('price_list',$price_list);
		$this->showpage('up_price');
	}
}
$up_price = new ShowUpPrice();
$up_price->main();
unset($up_price);
 ?>