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
 * FILE_NAME : order.php   FILE_PATH : E:\www\multishop\trunk\home\order.php
 * ....订单相关操作页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Dec 16 09:27:00 CST 2008
 */

require_once ("../global.inc.php");

class ShowOrder extends CommonFrameWork {
	/**
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_order;
	/**
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	
	function main(){
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		
		switch ($this->_input['action']){
			case "sp_html":
				$this->_show_sp_html();
				break;
		}
		
	}
	
	/**
	 * 查看订单商品快照
	 */
	function _show_sp_html(){
		if ($this->_input['sp_code'] != ''){
			//取订单信息
			$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		}
		/**
		 * 输出快照
		 */
		echo $order_array['sp_html'];
		exit;
	}
}
$order = new ShowOrder();
$order->main();
unset($order);
?>