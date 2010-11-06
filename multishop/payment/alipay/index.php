<?php
require_once("alipay_config.php");
if ($_GET['action'] == 'refund') {
	/**
	 * 退款操作
	 */
	echo "<script>window.location =\"https://www.alipay.com/trade/refund_apply.htm?trade_no=".$array['order']['alipay_id']."\";</script>"; exit;
} else {
	/**
	 * 跳转到支付宝付款确认页面
	 */
	@header("Location: alipayto.php?sp_code=".$_GET['sp_code']);
}
?>