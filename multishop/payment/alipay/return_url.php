<?php
/*
	*功能：付完款后跳转的页面（返回页）
	*版本：3.0
	*日期：2010-06-29
	'说明：
	'以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	
*/
///////////页面功能说明///////////////
//该页面可在本机电脑测试
//该页面称作“返回页”，是由支付宝服务器同步调用，可当作是支付完成后的提示信息页，如“您的某某某订单，多少金额已支付成功”。
//可放入HTML等美化页面的代码和订单交易完成后的数据库更新程序代码
//该页面可以使用PHP开发工具调试，也可以使用写文本函数log_result进行调试，该函数已被默认关闭，见alipay_notify.php中的函数return_verify
//WAIT_SELLER_SEND_GOODS(表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货);
///////////////////////////////////

require_once("class/alipay_notify.php");
require_once("alipay_config.php");

//构造通知函数信息
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
//计算得出通知验证结果
$verify_result = $alipay->return_verify();

if($verify_result) {

    //验证成功
    //获取支付宝的通知返回参数
    $dingdan           = $_GET['out_trade_no'];		//获取订单号
    $total_fee         = $_GET['price'];			//获取总价格
    $sOld_trade_status = 0;							//获取商户数据库中查询得到该笔交易当前的交易状态
	$verify_resultShow = "验证成功";

    /*假设：
	sOld_trade_status="0"	表示订单未处理；
	sOld_trade_status="1"	表示买家已在支付宝交易管理中产生了交易记录，但没有付款
	sOld_trade_status="2"	表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
	sOld_trade_status="3"	表示卖家已经发了货，但买家还没有做确认收货的操作
	sOld_trade_status="4"	表示买家已经确认收货，这笔交易完成
    */

    if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
		$alipay_manage = new Alipay();
		$input = $_GET;
		$alipay_manage->update_order($input);	
		@header("Location: ../../member/own_order.php?action=bought");
		exit;
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的return_verify函数，比对sign和mysign的值是否相等，或者检查$veryfy_result有没有返回true
    echo "fail";
	//$verify_resultShow = "验证失败";
}
?>
