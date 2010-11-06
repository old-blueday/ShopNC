<?php
/*
	*功能：设置商品有关信息
	*版本：2.0
	*日期：2008-08-01
	'说明：
	'以下代码只是方便商户测试，提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/

require_once("alipay_service.php");
require_once("alipay_config.php");
$parameter = array(
	"service"         => "create_direct_pay_by_user",  //交易类型
	"partner"         => $partner,          //合作商户号
	"return_url"      => $return_url,       //同步返回
	"notify_url"      => $notify_url,       //异步返回
	"_input_charset"  => $_input_charset,   //字符集，默认为GBK
	"subject"         => $array['subject'],        //商品名称，必填
	"body"            => $array['body'],        //商品描述，必填
	"out_trade_no"    => $array['pay_detail_id'],      //商品外部交易号，必填（保证唯一性）
	"total_fee"       => $array['online_amount'],            //商品单价，必填（价格不能为0）
	"payment_type"    => "1",               //默认为1,不需要修改

	"show_url"        => $show_url,         //商品相关网站
	"seller_email"    => $array['email']      //卖家邮箱，必填
);
$alipay = new alipay_service($parameter,$security_code,$sign_type);
$link=$alipay->create_url();
echo "<script>window.location =\"$link\";</script>"; 
?>

