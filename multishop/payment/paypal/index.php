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
 * FILE_NAME : index.php   FILE_PATH : E:\www\multishop\trunk\payment\paypal\index.php
 * ....paypal支付方式
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team
 * @package 
 * @subpackage 
 * @version Thu May 08 10:17:37 CST 2008
 */
//加载系统信息
include("../../global.inc.php");

class paypalIndex extends CommonFrameWork{
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
	
	function main(){

		//加载语言包
		$this->getlang("product");

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

		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode($this->_input["sp_code"]);
		//判断订单状态，如果状态是2则跳会页面
		if ($order_array['sp_state'] >1){
			header("loaction: ".$this->_configinfo['websit']['site_url'].'/member/own_order.php?action=sold');
			exit;
//			$this->redirectPath("succ","member/own_order.php?action=sold", $this->_lang['langOrderState']);
		}
		//取商品信息
		$product_array = $this->obj_product->getProductRow($order_array['p_code']);
		
		//判断付款方式
		if ($product_array['p_transfee_charge'] == 1){//买家承担
			if($order_array['tf_type'] == '1'){//1平邮
				$transport_fee = $product_array['p_tf_py'];
			}else if($order_array['tf_type'] == '2'){//2快递
				$transport_fee = $product_array['p_tf_kd'];
			}else if($order_array['tf_type'] == '3'){//3EMS
				$transport_fee = $product_array['p_tf_kd'];
			}
		}else {
			$transport_fee = 0;
		}
		
		//取会员信息
		$member_array = $this->obj_member->getMemberInfo(array("id"=>$order_array['seller_id']),'*','more');
		
		//Configuration File
		include_once('includes/config.inc.php');

		//判断帐号是否存在
		if($member_array['paypal'] == ''){
			echo 'This paypal ID is empty!';exit;
		}
		//换算汇率
		require_once("exchange.class.php");
		$obj_exchange = new ExchangeClass();
		$condition['exchange_name'] = $order_array['sp_currency_category'];
		$array = $obj_exchange->listExchange($condition,$page);
		$exchange_array = $array[0];
		if (empty($exchange_array)){
			echo 'This exchange is empty!';exit;
		}else {
			$product_array['p_price'] = @number_format($product_array['p_price']*100/$exchange_array['exchange_rate'],2)<=0.01?'0.01':@number_format($product_array['p_price']*100/$exchange_array['exchange_rate'],2);//价格
			if ($order_array['tf_fee'] != ""){
				$order_array['tf_fee'] = @number_format($order_array['tf_fee']*100/$exchange_array['exchange_rate'],2)<=0.01?'0.01':@number_format($order_array['tf_fee']*100/$exchange_array['exchange_rate'],2);
			}//运费
		}
		//参数
		$paypal['business'] = $member_array['paypal'];
		$paypal['site_url'] = $this->_configinfo['websit']['site_url'];
		$paypal['currency_code'] = $order_array['sp_currency_category'];
		$paypal['item_name'] = $product_array['p_name'];
		$paypal['item_number'] = $this->_input["sp_code"];
		$paypal['amount'] = $product_array['p_price']+$order_array['tf_fee'];
		$paypal['charset'] = $this->_configinfo['websit']['ncharset'];
		return $paypal;
	}
}

$paypal_index = new paypalIndex();
$paypal = $paypal_index->main();

//Global Configuration File
include_once('includes/global_config.inc.php');


?>
<html>
<head><title>::PHP PayPal::</title></head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$paypal[charset]?>" />
<body onLoad="document.paypal_form.submit();">
<form method="post" name="paypal_form" action="<?=$paypal[url]?>">
<?php 
//show paypal hidden variables
showVariables(); 
?>
<center><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="333333">Processing Transaction . . . </font></center>

</form>
</body>
</html>