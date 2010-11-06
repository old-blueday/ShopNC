<?php

if(is_array($pay_module) and count(pay_module) > 0) {
	$i	= count($pay_module);
} else {
	$i	= 0;
}

$pay_module[$i]['name']		= "支付宝";
$pay_module[$i]['code']		= "alibab";
$pay_module[$i]['info']		= "描述";
$pay_module[$i]['online']	= "1";
$pay_module[$i]['pay_type']	= "0";
$pay_module[$i]['web_site']	= "http://www.shopnc.net";

$pay_module[$i]['content']	= array(
									array('name'=>'支付账户',	'code' => 'alipay_account', 		'type' => 'text',   'value' => ''),
									array('name'=>'交易验证码',	'code' => 'alipay_key',             'type' => 'text',   'value' => ''),
									array('name'=>'合作者身份id',	'code' => 'alipay_partner',         'type' => 'text',   'value' => ''),
									array('name'=>'实体商品接口',	'code' => 'alipay_real_method',     'type' => 'select', 'value' => '0','content'=>array(0=>'使用普通实物商品交易接口',1=>'使用即时到帐交易接口',2=>'使用担保交易接口')),
									array('name'=>'开启及时到帐',	'code' => 'is_instant',             'type' => 'select', 'value' => '0','content'=>array(0=>'未开通',1=>'已经开通'))
);

class alibabPayClass {

	function __construct() {

	}

	function outForm($order_info,$pay_info,$shop_url) {
		$pay_info	= $this->decodeArray($pay_info);	//将其中序列化的数组还原
		
		if(!empty($pay_info['pay_content']['alipay_real_method']) and $pay_info['pay_content']['alipay_real_method'] == 1 and $pay_info['pay_content']['is_instant'] == 1) {
			$service = 'create_direct_pay_by_user';
		} elseif ($pay_info['pay_content']['alipay_real_method'] == 2) {
			$service = 'create_partner_trade_by_buyer';
		} else {
			$service = 'trade_create_by_buyer';
		}

		$array = array(
		'service'           => $service,
		'partner'           => $pay_info['pay_content']['alipay_partner'],
		'_input_charset'    => 'utf-8',
		'return_url'        => $shop_url.'/shopping.php?action=shopnc_code&nc_order_serial='.$order_info['order_serial'].'&shopnccode='.intval($pay_info['pay_id']),//返回的url
		'subject'           => $order_info['order_serial'],
		'out_trade_no'      => $order_info['order_serial'],
		'price'             => $order_info['price_count'],
		'quantity'          => 1,
		'payment_type'      => 1,
		'logistics_type'    => 'EXPRESS',
		'logistics_fee'     => 0,
		'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',
		'seller_email'      => $pay_info['pay_content']['alipay_account']
		);
		ksort($array);
		reset($array);

		$param = '';
		$sign  = '';

		foreach ($array AS $key => $val)
		{
			$param .= "$key=" .urlencode($val)."&";
			$sign  .= "$key=$val&";
		}
		$param = substr($param, 0, -1);
		$sign  = substr($sign, 0, -1).$pay_info['pay_content']['alipay_key'];
		
		$button = '<input type="button" onclick="window.open(\'https://www.alipay.com/cooperate/gateway.do?'.$param.'&sign='.md5($sign).'&sign_type=MD5\',\'_blank\')" value="马上使用支付宝支付" />';

		return $button;
	}

	function decodeArray($array) {
		$array['pay_content']	= unserialize($array['pay_content']);
		return $array;
	}
	function getParmentDo($order_info,$pay_info) {
			$payment  = $this->decodeArray($pay_info);
			$order_sn = trim($_GET['out_trade_no']);
			
			if(intval($order_info['order_price']) != intval($_GET['total_fee'])) {
				return false;
			}

			ksort($_GET);
			reset($_GET);

			$sign = '';
			foreach ($_GET AS $key=>$val)
			{
				if ($key != 'sign' && $key != 'sign_type' && $key != 'shopnccode' && $key != 'action' && $key != 'nc_order_serial')
				{
					$sign .= "$key=$val&";
				}
			}
			$sign = substr($sign, 0, -1) . $payment['pay_content']['alipay_key'];

			if (md5($sign) != $_GET['sign'])
			{
				return false;
			}

			if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS')
			{


				return true;	//付款中
			}
			elseif ($_GET['trade_status'] == 'TRADE_FINISHED')
			{


				return true;	//已付款
			}
			else
			{
				return false;
			}

	}
}
?>