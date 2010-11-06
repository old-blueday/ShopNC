<?php
/*
	*功能：付完款后跳转的页面
	*版本：2.0
	*日期：2008-08-01
	'说明：
	'以下代码只是方便商户测试，提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/

require_once("alipay_notify.php");
require_once("alipay_config.php");
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->return_verify();

 //获取支付宝的反馈参数
   $dingdan    = $_GET['out_trade_no'];   //获取订单号
   $total_fee  = $_GET['total_fee'];      //获取总价格

if($verify_result) {    //认证合格
	//echo "success";
	$alipay_manage = new Alipay();
	$input = $_GET;
	$alipay_manage->update_record($input);
	//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
	//log_result("verify_success"); 
//如果您申请了支付宝的购物卷功能，请在返回的信息里面不要做金额的判断，否则会出现校验通不过，出现调单。如果您需要获取买家所使用购物卷的金额,
//请获取返回信息的这个字段discount的值，取绝对值，就是买家付款优惠的金额。即 原订单的总金额=买家付款返回的金额total_fee +|discount|.
	@header("Location: ../../member/own_shop_pay.php?action=detail_list");
	exit;

}
else {    //认证不合格
	@header("Location: ../../member/own_main.php");
	exit;
	//log_result ("verify_failed");
}

/*  日志消息,把支付宝反馈的参数记录下来
function  log_result($word) { 
	$fp = fopen("log.txt","a");	
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
	flock($fp, LOCK_UN); 
	fclose($fp);
}
*/
?>