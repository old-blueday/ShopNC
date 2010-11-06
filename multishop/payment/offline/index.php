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
 * FILE_NAME : index.php   FILE_PATH : E:\www\multishop\trunk\payment\offline\index.php
 * ....线下交易控制
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team
 * @package 
 * @subpackage 
 * @version Fri May 09 15:50:09 CST 2008
 */

include("../../global.inc.php");//加载信息

class offlineIndex extends CommonFrameWork{
	/**
	 *商品订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;

	function main(){

		//加载语言包
		$this->getlang("own_order");
		
		//设置模板路径
		$this->setsubtemplates("member");
		
		//创建订单对象
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		//会员后台菜单
		$this->memberMenuModule();

		switch ($this->_input['action']){
			case "update_state":
				$this->_update_state();
				break;
			default:
				$this->_show();
		}
	}
	
	/**
	 * 显示订单操作页面
	 */
	function _show(){
//		取订单信息
//		$order_array = $this->obj_product_order->getOneOrderBySpcode($this->_input["sp_code"]);
//		
//		取商品信息
//		$product_array = $this->obj_product->getProductRow($order_array['p_code']);
//		/**
//		 * 模板输出
//		 */
//		$this->output("member_id", $_SESSION['s_login']['id']);//会员ID
//		$this->output('param_array',$order_array);
//		$this->showpage('own_order.invoice_view');
		@header("location: ".$this->_configinfo['websit']['site_url'].'/member/own_main.php');
	}
	
	/**
	 * 更改订单状态
	 */
	function _update_state(){
		$sp_code = $this->_input['sp_code'];
		$state = $this->_input['state'];
		if($sp_code != '' && $status !== ''){
			$input['spcode'] = $sp_code;
			$input["txtSPstate"] = $status;
			$result = $obj_product_order->updateProductOrderState($input);
			return $result;
		}else{
			return false;
		}
	}
	
}

$offline_index = new offlineIndex();
$offline_index->main();
unset($offline_index);
?>