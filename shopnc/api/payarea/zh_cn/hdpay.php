<?php

if(is_array($pay_module) and count(pay_module) > 0) {
	$i	= count($pay_module);
} else {
	$i	= 0;
}

$pay_module[$i]['name']		= "货到付款";
$pay_module[$i]['code']		= "hdpay";
$pay_module[$i]['info']		= "货物到达买家手中后付款";
$pay_module[$i]['online']	= "0";
$pay_module[$i]['pay_type']	= "1";
$pay_module[$i]['web_site']	= "";
$pay_module[$i]['content']	= array();

class hdpayPayClass {
	function __construct(){

	}
	function outForm($order_info,$pay_info,$shop_url) {
		return '';
	}

	function getParmentDo($order_info,$pay_info) {
		return '';
	}
}
