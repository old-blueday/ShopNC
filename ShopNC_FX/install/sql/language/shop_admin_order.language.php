<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : admin_order.language.php D:\binzi\shopnc6\language\zh_cn\admin_order.language.php
* 订单管理语言包
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Wed Jul 09 16:16:15 CST 2008
*/
/*=================================通用语言包============================*/
$language['system_order_submit']				= "提交";
$language['system_order_delete']				= "删除";
$language['system_order_confirm']			= "确认";
$language['system_order_cancel']				= "取消";
$language['system_order_ok']					= "确定";
$language['system_order_operate']			= "操作";
$language['system_order_be_confirmed']		= "已确认";
$language['system_order_unconfirmed']		= "未确认";
$language['system_order_del_conf']			= "您确实要删除该订单吗？";

/*=================================订单列表============================*/
$language['system_order_list']				= "订单列表";
$language['system_order_month_pay_list']	= "月度利润结算列表";
$language['system_order_search_choice']		= "选择搜索方式";
$language['system_order_search_order']		= "按订单号搜索";
$language['system_order_search_buyer']		= "按订货人搜索";
$language['system_order_search_shop']		= "按网店搜索";
$language['system_order_please_choice']		= "选择操作";
$language['system_order_num']				= "订单编号";
$language['system_order_book_time']			= "下单日期";
$language['system_order_money_amount']		= "订单金额";
$language['system_order_shipping_price']		= "配送费用";
$language['system_order_type_of_payment']	= "付款方式";
$language['system_order_orderer']			= "订货人";
$language['system_order_consignee']			= "收货人";
$language['system_order_shop_name']			= "网店";
$language['system_order_state']				= "订单状态";
$language['system_order_view']				= "查看订单";

$language['system_order_del_ok']				= "订单删除成功";
$language['system_order_del_no']				= "订单删除失败";

/*=================================已确认订单============================*/
$language['system_order_confirmed']			= "已确认订单";
$language['system_order_pay_for_it']			= "付款";

/*=================================已付款订单============================*/
$language['system_order_paid']				= "已付款订单";
$language['system_order_have_paid']			= "已付款";
$language['system_order_send']				= "发货";
$language['system_order_no_send']			= "未发货";
$language['system_order_yes_send']			= "已发货";
$language['pay_ok']							= "您的订单已经付款";

/*=================================已发货订单============================*/
$language['system_order_sent']			= "已发货订单";
$language['system_order_fill']			= "归档";
$language['system_order_not_paid']		= "未付款";
$language['system_order_no_fill']		= "未归档";
$language['send_ok']					= "订单商品已经发出";

/*=================================已归档订单============================*/
$language['system_order_filled']			= "已归档订单";
$language['system_order_already_filled']	= "已归档";
$language['fill_ok']					= "交易成功完成";
/*=================================利润结算============================*/
$language['system_order_month_pay_shop_name']		= "店铺名称";
$language['system_order_month_pay_search']			= "搜索";
$language['system_order_month_pay_shop_user']		= "店主";
$language['system_order_month_pay_sell_count']		= "销售量";
$language['system_order_month_pay_sub_sell_count']	= "子店销售额";
$language['system_order_month_pay_main_sell_count']	= "主店销售额";
$language['system_order_month_pay_cha_count']		= "利润分红";
$language['system_order_month_pay_state']			= "本月利润分红结算状态";
$language['system_order_month_pay_view']			= "查看";
$language['system_order_month_pay_yes']				= "否";
$language['system_order_month_pay_no']				= "是";
$language['system_order_month_pay_payed']			= "已付款";
$language['system_order_month_pay_payedcontent']	= "已支付，等待子店确认收款";
$language['system_order_month_pay_trade_ok']		= "已结款";
$language['system_order_month_pay_select_monty']	= "请选择月份";
$language['system_order_month_pay_operate_ok']		= "操作成功";
/*=================================订单查看============================*/
$language['system_order_view']			= "订单查看";
$language['system_order_goods']			= "所购商品";
$language['system_order_goods_price']	= "商品价格";
$language['system_order_goods_name']		= "商品名称";
$language['system_order_goods_num']		= "本次购买数量";
$language['system_order_goods_sale_num']	= "已出货数量";
$language['system_order_goods_color']	= "颜色";
$language['system_order_goods_Spec']		= "规格";
$language['system_order_goods_price_count']= "小计";
$language['system_order_manage_info']	= "订单操作描述";
$language['system_order_manage_info']	= "订单操作描述";
$language['system_order_manage_body']	= "<p>1:若取消订单,则不能选取到款、出货、归档操作！ 但是可以选择重新启动订单状态！</p>
                							<p>2:若操作者身份确定为会员本人，则可开始处理新增修改管理数据动作！</p>
                							<p>3:一旦执行到款操作，则不能再选择订单取消！同样地，已取消、及未确定的定单将不能操作到款动作！</p>
               	 							<p>4: 一旦执行出货操作，则不能再选择订单取消！同样地，已取消、及未确定的定单将不能操作到款动作！</p>
                							<p>5:执行归档后，数据将不能再被更改！</p>";
$language['system_order_number']			= "订单编号";
$language['system_order_create_time']	= "下单日期";
$language['system_order_info']			= "订单信息";
$language['system_order_invoice']		= "发票信息";
$language['system_order_invoice_null']	= "无";
$language['system_order_count_price']	= "订单总金额";
$language['system_order_send_type']		= "配送方式";
$language['system_order_send_price']		= "配送金额";
$language['system_order_pay_type']		= "付款方式";
$language['system_order_pay_price']		= "支付手续费";
$language['system_order_goods_price']	= "商品总金额";
$language['system_order_state']			= "订单状态";

$language['system_order_receiver_ino']	= "收货人信息";
$language['system_order_receiver_user']	= "收货人姓名";
$language['system_order_receiver_mobile']= "联系手机";
$language['system_order_receiver_tele']	= "联系电话";
$language['system_order_receiver_email']	= "电子邮件";
$language['system_order_receiver_address']= "收货地址";
$language['system_order_receiver_zip']	= "邮政编码";
$language['system_order_receiver_remarks']= "备注";

$language['system_order_state_modify_ok']	= "订单状态修改成功";
$language['system_order_state_modify_false']= "订单状态修改失败";

/*=================================虚拟卡发货============================*/
$language['admin_order_virtual_card_number']	   	 = "卡片序号:";
$language['admin_order_virtual_card_password']   	 = "卡片密码:";
$language['admin_order_virtual_card_end_time']   	 = "截止使用日期:";
$language['admin_order_virtual_card_storage_fail']   = "库存不足，需立即补货";

















?>