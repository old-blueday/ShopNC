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
 * FILE_NAME : success.php   FILE_PATH : E:\www\multishop\trunk\payment\paypal\success.php
 * ....paypal支付返回成功页面
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team
 * @package 
 * @subpackage 
 * @version Wed May 14 09:45:04 CST 2008
 */

include_once('../../global.inc.php');

class paypalSuccess extends CommonFrameWork{
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
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;
	
	function main(){
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
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建收货地址对象
		 */
		if (!is_object($this->obj_receive)){
			require_once("receive.class.php");
			$this->obj_receive = new ReceiveClass();
		}
		
		//设置模板路径
		$this->setsubtemplates("member");
		//加载语言包
		$this->getlang("own_order");
		
		//网站内部订单交易编号
		$sp_code = $this->_input['item_number'];
		if (trim($sp_code) == ''){
			echo "This order code isn't valid" ;exit;
		}
		
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode($sp_code);
		//确认订单是否是该会员的
		if (!is_array($order_array) || $order_array['sp_state'] != '0') {
			echo "This order code isn't valid" ;exit;
		}
		
		//更改订单状态,变成已付款
		$this->_input['spcode'] = $sp_code;
		$this->_input['txtSPstate'] = 1;
		$this->obj_product_order->updateProductOrderState($this->_input);
		
		/**
		 * 取卖家会员信息
		 */
		$condition['id'] = $order_array['seller_id'];
		$seller_info = $this->obj_member->getMemberInfo($condition,'*','more');
		$seller_info['sms_name']	= urlencode($seller_info['login_name']);
		/**
		 * 收货地址
		 */
		$condition_receive['receive_code'] = $order_array['receive_code'];
		$receive_array = $this->obj_receive->getAllReceive($condition_receive,$page);
		/**
		 * 页面输出
		 */
		$this->output('sp_code',$sp_code);
		$this->output('order_array',$order_array);
		$this->output('seller_info',$seller_info);
		$this->output('receive_info',$receive_array[0]);
		$this->showpage('own_order.pay_success');
	}
	
}

$paypal_success = new paypalSuccess();
$paypal_success->main();
unset($paypal_success);
?>