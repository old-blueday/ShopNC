<?php
//---------------------------------------------------------
//财付通中介担保支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------
include("../../global.inc.php");
require_once ("classes/MediPayRequestHandler.class.php");
class tenpayIndex extends CommonFrameWork{
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
		
		//取商品信息
		$product_array = $this->obj_product->getProductRow($order_array['p_code']);
		
		//判断付款方式
		if ($product_array['p_transfee_charge'] == 1){//买家承担
			if($order_array['tf_type'] == '1'){//1平邮
				$transport_fee = $product_array['p_tf_py']?$product_array['p_tf_py']:'0';
			}else if($order_array['tf_type'] == '2'){//2快递
				$transport_fee = $product_array['p_tf_kd']?$product_array['p_tf_kd']:'0';
			}else if($order_array['tf_type'] == '3'){//3EMS
				$transport_fee = $product_array['p_tf_kd']?$product_array['p_tf_kd']:'0';
			}
		}else {
			$transport_fee = 0;
		}
		//取会员信息
		$member_array = $this->obj_member->getMemberInfo(array("id"=>$order_array['seller_id']),'*','more');
		
		//参数
		$array = array();
		$order_array['p_name'] = Char_class::cut_str($order_array['p_name'],32,0,$this->_configinfo['websit']['ncharset'],'');
		//判断如果是发货操作，那么直接跳转到财付通的网站，因为不能在本站点发送发货请求到财付通站点
		if($order_array['sp_state'] != '0'){
			@header('location: http://www.tenpay.com');exit;
		}
		$array['mch_name'] = $order_array['p_name'];//商品名称
		$array['mch_price'] = $order_array['buy_num']*$order_array['unit_price']*100;//商品价格,单位为分
		$array['transport_desc'] = $order_array['p_name'];//物流说明
		$array['transport_fee'] = $transport_fee*100;//买方需要支付的物流费用
		$array['mch_desc'] = $order_array['p_name'];//交易说明
		$array['mch_vno'] = $this->_input["sp_code"];//订单号
		$array['cft_tid'] = $order_array['alipay_id'];//外部交易流水号
		$array['seller'] = $member_array['tenpay'];//卖家tenpay帐号
		$array['site_url'] = $this->_configinfo['websit']['site_url'];
		
		//财付通平台 账号 密匙
		require_once(BasePath."/payment/tenpay/tenpay_config.php");
		$array['key'] = $key;
		$array['chnid'] = $chnid;
		$array['charset'] = $this->_configinfo['websit']['ncharset'];

		return $array;

	}
}
//创建 商城支付方式对象
$obj_payment = new tenpayIndex();
$payment_array = $obj_payment->main();
//date_default_timezone_set(PRC);
$curDateTime = date("YmdHis");
$randNum = rand(1000, 9999);

/* 平台商密钥 */
$key = $payment_array['key'];

/* 平台商帐号 */
$chnid = $payment_array['chnid'];

/* 卖家 */
$seller = $payment_array['seller'];

/* 交易说明 */
$mch_desc = $payment_array['mch_name'];

/* 商品名称 */
$mch_name = $payment_array['mch_name'];

/* 商品总价，单位为分 */
$mch_price = $payment_array['mch_price'];

/* 回调通知URL */
$mch_returl = $payment_array['site_url']."/payment/tenpay/mch_returl.php";

/* 商家的定单号 */
$mch_vno = $payment_array['mch_vno'];//

/* 支付后的商户支付结果展示页面 */
$show_url = $payment_array['site_url']."/payment/tenpay/mch_returl.php";//$payment_array['site_url']."/payment/tenpay/show_url.php";

/* 物流公司或物流方式说明 */
$transport_desc = $payment_array['mch_name'];

/* 需买方另支付的物流费用,以分为单位 */
$transport_fee = $payment_array['transport_fee']==0?"":$payment_array['transport_fee'];

/* 创建支付请求对象 */
$reqHandler = new MediPayRequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);

//----------------------------------------
//设置支付参数
//----------------------------------------
$reqHandler->setParameter("chnid", $chnid);						//平台商帐号
$reqHandler->setParameter("encode_type", strtoupper($payment->charset)=='GBK'?"1":"2");					//编码类型 1:gbk 2:utf-8
$reqHandler->setParameter("mch_desc", $mch_desc);				//交易说明
$reqHandler->setParameter("mch_name", $mch_name);				//商品名称
$reqHandler->setParameter("mch_price", $mch_price);				//商品总价，单位为分
$reqHandler->setParameter("mch_returl", $mch_returl);			//回调通知URL
$reqHandler->setParameter("mch_type", "1");						//交易类型：1、实物交易，2、虚拟交易
$reqHandler->setParameter("mch_vno", $mch_vno);					//商家的定单号
$reqHandler->setParameter("need_buyerinfo", "2");				//是否需要在财付通填定物流信息，1：需要，2：不需要。
$reqHandler->setParameter("seller", $seller);					//卖家财付通帐号
$reqHandler->setParameter("show_url",	$show_url);				//支付后的商户支付结果展示页面
$reqHandler->setParameter("transport_desc", $transport_desc);	//物流公司或物流方式说明
$reqHandler->setParameter("transport_fee", $transport_fee);		//需买方另支付的物流费用

//请求的URL
$reqUrl = $reqHandler->getRequestURL();

//debug信息
//$debugInfo = $reqHandler->getDebugInfo();

//echo "<br/>" . $reqUrl . "<br/>";
//echo "<br/>" . $debugInfo . "<br/>";

//重定向到财付通支付
//$reqHandler->doSend();

@header('Location: '.$reqUrl);exit;
?>
<!--<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk">
	<title>财付通中介担保程序演示</title>
</head>
<body>
<br/><a href="<?php echo $reqUrl ?>" target="_blank">财付通支付</a>
</body>
</html>-->