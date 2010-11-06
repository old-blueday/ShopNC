<?php

//---------------------------------------------------------
//财付通中介担保支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
include("../../global.inc.php");
require_once ("./classes/MediPayResponseHandler.class.php");

class tenpayIndex extends CommonFrameWork{
	
	var $site_url = '';

	function tenpayIndex(){
		parent::CommonFrameWork();
		$this->site_url = $this->_configinfo['websit']['site_url'];
	}

	function main(){
		//财付通平台 账号 密匙
		require_once(BasePath."/payment/tenpay/tenpay_config.php");
		$array['key'] = $key;
		$array['chnid'] = $chnid;
		return $array;
	}
}

//创建 商城支付方式对象
$obj_payment = new tenpayIndex();
$payment_array = $obj_payment->main();

/* 平台商密钥 */
$key = $payment_array['key'];

/* 创建支付应答对象 */
$resHandler = new MediPayResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//财付通交易单号
	$cft_tid = $resHandler->getParameter("cft_tid");
	
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	
	//返回码
	$retcode = $resHandler->getParameter("retcode");
	
	//状态
	$status = $resHandler->getParameter("status");	
		
	//------------------------------
	//处理业务开始
	//------------------------------
	
	//注意交易单不要重复处理
	//注意判断返回金额
	
	$url = $payment_array->site_url.'/member/own_main.php';
	@header("Location: $url");
	exit;

	//返回码判断
	if( "0" == $retcode ) {
		if( "3" == $status ) {
			
			echo "支付成功";
		}
	} else {
		echo "支付失败";
	}
	
	//------------------------------
	//处理业务完毕
	//------------------------------	
		
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
}

//echo $resHandler->getDebugInfo();

?>