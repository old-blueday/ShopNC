<?php
/*
	*功能：付款过程中服务器通知页面
	*版本：2.0
	*日期：2008-08-01
	'说明：
	'以下代码只是方便商户测试，提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/

require_once("alipay_notify.php");
require_once("alipay_config.php");
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->notify_verify();
if($verify_result) {   //认证合格
 //获取支付宝的反馈参数
    $dingdan  = $_POST['out_trade_no'];    //获取支付宝传递过来的订单号
    $total    = $_POST['total_fee'];       //获取支付宝传递过来的总价格
	
	/*
		获取支付宝反馈过来的状态,根据不同的状态来更新数据库 
		WAIT_BUYER_PAY(表示等待买家付款);
		TRADE_FINISHED(表示交易已经成功结束);
	*/

	$alipay_manage = new Alipay();
	$input = $_POST;
	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {         //等待买家付款
		//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
		//echo "success";
		//log_result("verify_success");
	}
	else if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') {    //交易成功结束
        //这里放入你自定义代码,比如根据不同的trade_status进行不同操作
		//echo "success";
		$alipay_manage->update_record($input);
//如果您申请了支付宝的购物卷功能，请在返回的信息里面不要做金额的判断，否则会出现校验通不过，出现调单。如果您需要获取买家所使用购物卷的金额,
//请获取返回信息的这个字段discount的值，取绝对值，就是买家付款优惠的金额。即 原订单的总金额=买家付款返回的金额total_fee +|discount|.

		//log_result("verify_success");
	}	
	else {
		@header("Location: ../../member/own_main.php");exit;
		//log_result ("verify_failed");
	}
}
else {    //认证不合格
	@header("Location: ../../member/own_main.php");exit;
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