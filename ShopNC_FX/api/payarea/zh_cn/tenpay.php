<?php

if(is_array($pay_module) and count(pay_module) > 0) {
	$i	= count($pay_module);
} else {
	$i	= 0;
}

$pay_module[$i]['name']		= "财付通";
$pay_module[$i]['code']		= "tenpay";
$pay_module[$i]['info']		= "描述";
$pay_module[$i]['online']	= "1";
$pay_module[$i]['pay_type']	= "0";
$pay_module[$i]['web_site']	= "http://www.tenpay.com";
$pay_module[$i]['content']	= array(
array('name'=>'财付通帐号',	'code' => 'tenpay_account', 		'type' => 'text',   'value' => ''),
array('name'=>'财付通密钥',	'code' => 'tenpay_key',             'type' => 'text',   'value' => ''),
array('name'=>'自定义签名',	'code' => 'magic_string',         	'type' => 'text',   'value' => ''),
);
class tenpayPayClass {

	function __construct() {

	}
	function outForm($order_info,$pay_info,$shop_url) {
		$pay_info	= $this->decodeArray($pay_info);	//将其中序列化的数组还

		$cmd_no = '1';

		/* 获得订单的流水号，补零到10位 */

		$bill_no = substr(str_pad($order_info['order_serial'], 14, "0", STR_PAD_LEFT),4);

		/* 交易日期 */
		$today = date('Ymd');

		/* 将商户号+年月日+流水号 */
		$transaction_id = $pay_info['pay_content']['tenpay_account'].$today.$bill_no;

		/* 银行类型:支持纯网关和财付通 */
		$bank_type = '0';

		/* 订单描述，用订单号替代 */
		$desc = $order_info['order_serial'];

		/* 返回的路径 */
		$return_url = $shop_url.'/shopping.php?action=shopnc_code&nc_order_serial='.$order_info['order_serial'].'&shopnccode='.intval($pay_info['pay_id']);//返回的url;

		/* 总金额 */
		$total_fee = $order_info['price_count']*100;

		/* 货币类型 */
		$fee_type = '1';

		/* 数字签名 */
		$sign_text = "cmdno=" . $cmd_no . "&date=" . $today . "&bargainor_id=" . $pay_info['pay_content']['tenpay_account'] .
		"&transaction_id=" . $transaction_id . "&sp_billno=" . $bill_no .
		"&total_fee=" . $total_fee . "&fee_type=" . $fee_type . "&return_url=" . $return_url .
		"&attach=" . $pay_info['pay_content']['magic_string'] . "&key=" . $pay_info['pay_content']['tenpay_key'];
		$sign = strtoupper(md5($sign_text));

		/* 交易参数 */
		$parameter = array(
		'cmdno'             => $cmd_no,                     				// 业务代码, 财付通支付支付接口填
		'date'              => $today,                      				// 商户日期：如20051212
		'bank_type'         => $bank_type,                  				// 银行类型:支持纯网关和财付通
		'desc'              => $desc,                       				// 交易的商品名称
		'purchaser_id'      => '',                          				// 用户(买方)的财付通帐户,可以为空
		'bargainor_id'      => $pay_info['pay_content']['tenpay_account'],	// 商家的财付通商户号
		'transaction_id'    => $transaction_id,             				// 交易号(订单号)，由商户网站产生(建议顺序累加)
		'sp_billno'         => $bill_no,                    				// 商户系统内部的定单号,最多10位
		'total_fee'         => $total_fee,                  				// 订单金额
		'fee_type'          => $fee_type,                   				// 现金支付币种
		'return_url'        => $return_url,                 				// 接收财付通返回结果的URL
		'attach'            => $pay_info['pay_content']['magic_string'],	// 用户自定义签名
		'sign'              => $sign                        				// MD5签名
		);

		$button  = '<br /><form style="text-align:center;" action="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi" target="_blank" style="margin:0px;padding:0px" >';
		foreach ($parameter AS $key=>$val)
		{
			$button  .= "<input type='hidden' name='$key' value='$val' />";
		}
		$button  .= '<input type="submit" value="财付通支付" /></form><br />';

		return $button;
	}
	function decodeArray($array) {
		$array['pay_content']	= unserialize($array['pay_content']);
		return $array;
	}
	function getParmentDo($order_info,$pay_info) {
		$payment  = $this->decodeArray($pay_info);				//将其中序列化的数组还
	
		$cmd_no         = $_GET['cmdno'];
		$pay_result     = $_GET['pay_result'];
		$pay_info       = $_GET['pay_info'];
		$bill_date      = $_GET['date'];
		$bargainor_id   = $_GET['bargainor_id'];
		$transaction_id = $_GET['transaction_id'];
		$sp_billno      = $_GET['sp_billno'];
		$total_fee      = $_GET['total_fee'];
		$fee_type       = $_GET['fee_type'];
		$attach         = $_GET['attach'];
		$sign           = $_GET['sign'];
		
		if($pay_result >0) {
			return false;
		}
		
		if($order_info['order_price'] != ($total_fee / 100)) {
			return false;
		}

		/* 检查数字签名是否正确 */
		$sign_text  = "cmdno=" . $cmd_no . "&pay_result=" . $pay_result .
		"&date=" . $bill_date . "&transaction_id=" . $transaction_id .
		"&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee .
		"&fee_type=" . $fee_type . "&attach=" . $attach .
		"&key=" . $payment['pay_content']['tenpay_key'];
		$sign_md5 = strtoupper(md5($sign_text));
		if ($sign_md5 != $sign)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>