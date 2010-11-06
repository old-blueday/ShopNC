<?php
/*
 *功能：设置商品有关信息（确认订单支付宝在线购买入口页）
 *详细：该页面是接口入口页面，生成支付时的URL
 *版本：3.0
 *修改日期：2010-06-29
 '说明：
 '以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 '该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/

////////////////////注意/////////////////////////
//该页面测试时出现“调试错误”请参考：http://club.alipay.com/read-htm-tid-8681712.html
//如果不想使用扩展功能请把扩展功能参数赋空值。
//总金额计算方式是：总金额=price*quantity+logistics_fee+discount。
//建议把price看作为总金额，是物流运费、折扣、购物车中购买商品总额等计算后的最终订单的应付总额。
//建议物流参数只使用一组，根据买家在商户网站中下单时选择的物流类型（快递、平邮、EMS），程序自动识别logistics_type被赋予三个中的一个值
//各家快递公司都属于EXPRESS（快递）的范畴
/////////////////////////////////////////////////
require_once("alipay_config.php");

require_once("class/alipay_service.php");

//发货
if ($array['order']['sp_state'] == '1' ) {
	echo "<script>window.location =\" https://www.alipay.com/trade/seller_send_goods.htm?trade_no=".$array['order']['alipay_id']."\";</script>"; exit;
} 

//收货
if ($array['order']['sp_state'] == '2') {
	echo "<script>window.location =\" https://www.alipay.com/trade/dealing_got_products.htm?trade_no=".$array['order']['alipay_id']."\";</script>"; exit;
}

/*以下参数是需要通过下单时的订单数据传入进来获得*/
//必填参数
$out_trade_no	= $array['order']['sp_code'];				//请与贵网站订单系统中的唯一订单号匹配
$subject		= $array['order']['p_name'];						//订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
$body			= $_POST['alibody'];							//订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
$price			= $array['order']['unit_price']*$array['order']['buy_num'];		//订单总金额，显示在支付宝收银台里的“应付总额”里

$logistics_fee		= $array['order']['tf_fee'];				//物流费用，即运费。
$logistics_type		= $array['order']['tf_type'];			//物流类型，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
$logistics_payment	= $array['transfee'];			//物流支付方式，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）

$quantity		= "1";						//商品数量，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品。

//扩展参数——买家收货信息（推荐作为必填）
//该功能作用在于买家已经在商户网站的下单流程中填过一次收货信息，而不需要买家在支付宝的付款流程中再次填写收货信息。
//若要使用该功能，请至少保证receive_name、receive_address有值
$receive_name		= $array['receive']['receive_name'];			//收货人姓名，如：张三
$receive_address	= $array['receive']['area'];			//收货人地址，如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
$receive_zip		= $array['receive']['zip'];			//收货人邮编，如：123456
$receive_phone		= $array['receive']['mobilephone'];		//收货人电话号码，如：0571-81234567
$receive_mobile		= $array['receive']['phone'];		//收货人手机号码，如：13312341234

//扩展参数——第二组物流方式
//物流方式是三个为一组成组出现。若要使用，三个参数都需要填上数据；若不使用，三个参数都需要为空
//有了第一组物流方式，才能有第二组物流方式，且不能与第一个物流方式中的物流类型相同，
//即logistics_type="EXPRESS"，那么logistics_type_1就必须在剩下的两个值（POST、EMS）中选择
$logistics_fee_1	= "";					//物流费用，即运费。
$logistics_type_1	= "";					//物流类型，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
$logistics_payment_1= "";					//物流支付方式，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）

//扩展参数——第三组物流方式
//物流方式是三个为一组成组出现。若要使用，三个参数都需要填上数据；若不使用，三个参数都需要为空
//有了第一组物流方式和第二组物流方式，才能有第三组物流方式，且不能与第一组物流方式和第二组物流方式中的物流类型相同，
//即logistics_type="EXPRESS"、logistics_type_1="EMS"，那么logistics_type_2就只能选择"POST"
$logistics_fee_2	= "";					//物流费用，即运费。
$logistics_type_2	= "";					//物流类型，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
$logistics_payment_2= "";					//物流支付方式，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）

//扩展功能参数——其他
$buyer_email		= '';					//默认买家支付宝账号
$discount	 		= '';					//折扣，是具体的金额，而不是百分比。若要使用打折，请使用负数，并保证小数点最多两位数

/////////////////////////////////////////////////

//构造要请求的参数数组
$parameter = array(
        "service"			=> "create_partner_trade_by_buyer",	//接口名称，不需要修改
        "payment_type"		=> "1",               				//交易类型，不需要修改

        //获取配置文件(alipay_config.php)中的值
        "partner"			=> $partner,
        "seller_email"		=> $seller_email,
        "return_url"		=> $return_url,
        "notify_url"		=> $notify_url,
        "_input_charset"	=> $_input_charset,
        "show_url"			=> $show_url,

        //从订单数据中动态获取到的必填参数
        "out_trade_no"		=> $out_trade_no,
        "subject"			=> $subject,
        "body"				=> $body,
        "price"				=> $price,
		"quantity"			=> $quantity,
		
		"logistics_fee"		=> $logistics_fee,
		"logistics_type"	=> $logistics_type,
		"logistics_payment"	=> $logistics_payment,
		
		//扩展功能参数——买家收货信息
		"receive_name"		=> $receive_name,
		"receive_address"	=> $receive_address,
		"receive_zip"		=> $receive_zip,
		"receive_phone"		=> $receive_phone,
		"receive_mobile"	=> $receive_mobile,
		
		//扩展功能参数——第二组物流方式
		"logistics_fee_1"	=> $logistics_fee_1,
		"logistics_type_1"	=> $logistics_type_1,
		"logistics_payment_1"=> $logistics_payment_1,
		
		//扩展功能参数——第三组物流方式
		"logistics_fee_2"	=> $logistics_fee_2,
		"logistics_type_2"	=> $logistics_type_2,
		"logistics_payment_2"=> $logistics_payment_2,

		//扩展功能参数——其他
		"discount"			=> $discount,
		"buyer_email"		=> $buyer_email
);
//构造请求函数
$alipay = new alipay_service($parameter,$security_code,$sign_type);
//若改成GET方式传递
$url = $alipay->create_url();
$sHtmlText = "<a href=".$url."><img border='0' src='images/alipay.gif' /></a>";
echo "<script>window.location =\"$url\";</script>"; 





//POST方式传递，得到加密结果字符串，请取消下面一行的注释
$sHtmlText = $alipay->build_postform();

?>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>支付宝即时支付</title>
        <style type="text/css">
            .font_content{
                font-family:"宋体";
                font-size:14px;
                color:#FF6600;
            }
            .font_title{
                font-family:"宋体";
                font-size:16px;
                color:#FF0000;
                font-weight:bold;
            }
            table{
                border: 1px solid #CCCCCC;
            }
        </style>
    </head>
    <body>

        <table align="center" width="350" cellpadding="5" cellspacing="0">
            <tr>
                <td align="center" class="font_title" colspan="2">订单确认</td>
            </tr>
            <tr>
                <td class="font_content" align="right">订单号：</td>
                <td class="font_content" align="left"><?php echo $out_trade_no; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">付款总金额：</td>
                <td class="font_content" align="left"><?php echo $price; ?></td>
            </tr>
            <tr>
                <td align="center" colspan="2"><?php echo $sHtmlText; ?></td>
            </tr>
        </table>
    </body>
</html>
