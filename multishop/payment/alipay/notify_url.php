<?php
/*
	*功能：支付宝主动通知调用的页面（通知页）
	*版本：3.0
	*日期：2010-05-21
	'说明：
	'以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/
///////////页面功能说明///////////////
//创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
//该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
//该页面调试工具请使用写文本函数log_result，该函数已被默认开启，见alipay_notify.php中的函数notify_verify
//WAIT_BUYER_PAY(表示买家已在支付宝交易管理中产生了交易记录，但没有付款);
//WAIT_SELLER_SEND_GOODS(表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货);
//WAIT_BUYER_CONFIRM_GOODS(表示卖家已经发了货，但买家还没有做确认收货的操作);
//TRADE_FINISHED(表示买家已经确认收货，这笔交易完成);
//该通知页面主要功能是：对于返回页面（return_url.php）做补单处理。如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
/////////////////////////////////////

require_once("class/alipay_notify.php");
require_once("alipay_config.php");

$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);    //构造通知函数信息
$verify_result = $alipay->notify_verify();  //计算得出通知验证结果

if($verify_result) {
    //验证成功
    //获取支付宝的反馈参数
    $dingdan           = $_POST['out_trade_no'];	//获取支付宝传递过来的订单号
    $total             = $_POST['price'];			//获取支付宝传递过来的总价格
   //$sOld_trade_status = 2;							//获取商户数据库中查询得到该笔交易当前的交易状态
    /*假设：
	sOld_trade_status="0"	表示订单未处理；
	sOld_trade_status="1"	表示买家已在支付宝交易管理中产生了交易记录，但没有付款
	sOld_trade_status="2"	表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
	sOld_trade_status="3"	表示卖家已经发了货，但买家还没有做确认收货的操作
	sOld_trade_status="4"	表示买家已经确认收货，这笔交易完成
    */
	$alipay_manage = new Alipay();
	$input = $_POST;
    if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
		//表示买家已在支付宝交易管理中产生了交易记录，但没有付款
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是订单未处理状态
		//注：该交易状态下，也可不做数据库更新程序，此时，建议把该状态的通知信息记录到商户通知日志数据库表中。
		$alipay_manage->update_order($input);
        echo "success";

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
	else if ($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){
		//表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是WAIT_BUYER_PAY状态
		$alipay_manage->update_order($input);
		echo "success";//请不要修改或删除
		
		//调试用，写文本函数记录程序运行情况是否正常
        log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
	}
	else if ($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS'){
		//表示卖家已经发了货，但买家还没有做确认收货的操作
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是WAIT_SELLER_SEND_GOODS状态
		$alipay_manage->update_order($input);
		echo "success";//请不要修改或删除
		
		//调试用，写文本函数记录程序运行情况是否正常
        log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
	}
	else if ($_POST['trade_status'] == 'TRADE_FINISHED'){
		//表示买家已经确认收货，这笔交易完成
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是WAIT_BUYER_CONFIRM_GOODS状态
		$alipay_manage->update_order($input);
		echo "success";//请不要修改或删除
		
		//调试用，写文本函数记录程序运行情况是否正常
        //log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
	}
    else {
        echo "success";		//其他状态判断。普通即时到帐中，其他状态不用判断，直接打印success。

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>