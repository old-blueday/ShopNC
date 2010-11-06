<?php
//---------------------------------------------------------
//财付通即时到帐支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------

include("../../global.inc.php");
require_once ("classes/PayRequestHandler.class.php");

class tenpayIndex extends CommonFrameWork{
	/**
	 * 预存款对象
	 *
	 */
	var $obj_predeposit;

	function main(){
		if($_SESSION['s_login']['id'] == ''){
			$this->redirectPath("error","",$this->_lang['langCMemberIsEmpty']);
		}
		if ($this->_input['predeposit_r_id'] == ''){
			$this->redirectPath("error","",$this->_lang['langCIdIsIllegal']);
		}
		/**
		 * 加载语言包
		 */
		$this->getlang('own_predeposit');
		/**
		 * 初始化预存款类
		 */
		if (!is_object($this->obj_predeposit)){
			require_once("predeposit.class.php");
			$this->obj_predeposit = new PredepositClass();
		}
		//验证信息是否与会员相符
		$record_array = $this->obj_predeposit->getOnePredepositRecordById($this->_input['predeposit_r_id']);
		if ($record_array['member_id'] != $_SESSION['s_login']['id']){
			$this->redirectPath("error","",$this->_lang['langCIdIsIllegal']);
		}
		if (strtoupper($this->_configinfo['websit']['ncharset']) == 'UTF-8'){
			$this->_lang['langPredepositPay'] = Common::nc_change_charset($this->_lang['langPredepositPay'],'utf8_to_gbk');
		}
		//取帐号配置文件信息
		$pay_array = $this->_getconfigini("payment.ini.php");
		//参数
		$array = array();
		$array['desc'] = $this->_lang['langPredepositPay'];//商品名称
		$array['sp_billno'] = $record_array['predeposit_r_id'];//订单号
		$array['total_fee'] = $record_array['online_amount']*100;//商品价格,单位为分
		$array['transport_desc'] = $this->_lang['langPredepositPay'];//物流说明
		$array['bargainor_id'] = $pay_array['online']['tenpay'];//卖家帐号
		$array['key'] = $pay_array['online']['tenpay_key'];//密钥
		$array['return_url'] = $this->_configinfo['websit']['site_url'];
		return $array;
	}
	

	// 更新 预存款 交易流水号 $predeposit_r_id 预存款ID,$transaction_id 生成的交易流水号
	function updatePredepositTrade($predeposit_r_id,$transaction_id){
		$array = array();
		$array['predeposit_r_id'] = $predeposit_r_id;
		$array['payment_trade'] = $transaction_id;
		require_once("predeposit.class.php");
		$obj_predeposit = new PredepositClass();
		$obj_predeposit->updatePredepositRecord($array);
		unset($obj_predeposit);
	}


}
//创建 商城支付方式对象
$obj_payment = new tenpayIndex();
$payment_array = $obj_payment->main();

/* 商户号 */
$bargainor_id = $payment_array['bargainor_id'];

/* 密钥 */
$key = $payment_array['key'];

/* 返回处理地址 */
$return_url = $payment_array['return_url']."/predeposit_pay/tenpay/return_url.php";

//date_default_timezone_set(PRC);
$strDate = date("Ymd");
$strTime = date("His");

//4位随机数
$randNum = rand(1000, 9999);

//10位序列号,可以自行调整。
$strReq = $strTime . $randNum;

/* 商家订单号,长度若超过32位，取前32位。财付通只记录商家订单号，不保证唯一。 */
$sp_billno = $payment_array['sp_billno'];//$strReq;

/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
$transaction_id = $bargainor_id . $strDate . $strReq;

// 更新预存款充值信息的线上交易流水号
$obj_payment->updatePredepositTrade($payment_array['sp_billno'],$transaction_id);


/* 商品价格（包含运费），以分为单位 */
$total_fee = $payment_array['total_fee'];//"1";

/* 商品名称 */
$desc = $payment_array['desc'];//"订单号：" . $transaction_id;

/* 创建支付请求对象 */
$reqHandler = new PayRequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);

//----------------------------------------
//设置支付参数
//----------------------------------------
$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
$reqHandler->setParameter("total_fee", $total_fee);					//商品总金额,以分为单位
$reqHandler->setParameter("return_url", $return_url);				//返回处理地址
$reqHandler->setParameter("desc", $desc);	//商品名称 "订单号：" . $transaction_id

//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
//$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);

//请求的URL
$reqUrl = $reqHandler->getRequestURL();

//debug信息
//$debugInfo = $reqHandler->getDebugInfo();

//echo "<br/>" . $reqUrl . "<br/>";
//echo "<br/>" . $debugInfo . "<br/>";

//重定向到财付通支付
//$reqHandler->doSend();

header("location: ".$reqUrl);
?>
<!--<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk">
	<title>财付通即时到帐程序演示</title>
</head>
<body>
<br/><a href="<?php echo $reqUrl ?>" target="_blank">财付通支付</a>
</body>
</html>-->