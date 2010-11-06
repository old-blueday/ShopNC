<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : admin_order.language.php D:\binzi\shopnc6\language\zh_cn\admin_order.language.php
* 订单管理语言包
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Wed Jul 09 16:16:15 CST 2008
*/
/*=================================通用语言包============================*/
$language['admin_order_submit']				= "提交";
$language['admin_order_delete']				= "删除";
$language['admin_order_confirm']			= "确认";
$language['admin_order_cancel']				= "取消";
$language['admin_order_ok']					= "确定";
$language['admin_order_operate']			= "操作";
$language['admin_order_be_confirmed']		= "已确认";
$language['admin_order_unconfirmed']		= "未确认";
$language['admin_order_guest']				= "游客";
$language['admin_order_del_conf']			= "您确实要删除该订单吗？";

/*=================================订单列表============================*/
$language['admin_order_list']				= "新订单列表";
$language['admin_order_search_choice']		= "选择搜索方式";
$language['admin_order_search_order']		= "按订单号搜索";
$language['admin_order_search_buyer']		= "按订货人搜索";
$language['admin_order_please_choice']		= "选择操作";
$language['admin_order_num']				= "订单编号";
$language['admin_order_book_time']			= "下单日期";
$language['admin_order_money_amount']		= "订单金额";
$language['admin_order_shipping_price']		= "配送费用";
$language['admin_order_type_of_payment']	= "付款方式";
$language['admin_order_orderer']			= "订货人";
$language['admin_order_consignee']			= "收货人";
$language['admin_order_state']				= "订单状态";
$language['admin_order_view']				= "查看订单";

$language['admin_order_del_ok']				= "订单删除成功";
$language['admin_order_del_no']				= "订单删除失败";

/*=================================已确认订单============================*/
$language['admin_order_confirmed']			= "已确认订单";
$language['admin_order_pay_for_it']			= "付款";

/*=================================已付款订单============================*/
$language['admin_order_paid']				= "已付款订单";
$language['admin_order_have_paid']			= "已付款";
$language['admin_order_send']				= "发货";
$language['admin_order_no_send']			= "未发货";
$language['admin_order_yes_send']			= "已发货";
$language['pay_ok']							= "您的订单已经付款";

/*=================================已发货订单============================*/
$language['admin_order_sent']			= "已发货订单";
$language['admin_order_fill']			= "归档";
$language['admin_order_not_paid']		= "未付款";
$language['admin_order_no_fill']		= "未归档";
$language['send_ok']					= "订单商品已经发出";

/*=================================已归档订单============================*/
$language['admin_order_filled']			= "已归档订单";
$language['admin_order_already_filled']	= "已归档";
$language['fill_ok']					= "交易成功完成";

/*=================================订单查看============================*/
$language['admin_order_view']			= "订单查看";
$language['admin_order_goods']			= "所购商品";
$language['admin_order_goods_price']	= "商品价格";
$language['admin_order_goods_name']		= "商品名称";
$language['admin_order_goods_num']		= "本次购买数量";
$language['admin_order_goods_sale_num']	= "已出货数量";
$language['admin_order_goods_color']	= "颜色";
$language['admin_order_goods_Spec']		= "规格";
$language['admin_order_goods_price_count']= "小计";
$language['admin_order_manage_info']	= "订单操作描述";
$language['admin_order_manage_info']	= "订单操作描述";
$language['admin_order_manage_body']	= "<p>1:若取消订单,则不能选取到款、出货、归档操作！ 但是可以选择重新启动订单状态！</p>
                							<p>2:若操作者身份确定为会员本人，则可开始处理新增修改管理数据动作！</p>
                							<p>3:一旦执行到款操作，则不能再选择订单取消！同样地，已取消、及未确定的定单将不能操作到款动作！</p>
               	 							<p>4: 一旦执行出货操作，则不能再选择订单取消！同样地，已取消、及未确定的定单将不能操作到款动作！</p>
                							<p>5:执行归档后，数据将不能再被更改！</p>";
$language['admin_order_number']			= "订单编号";
$language['admin_order_create_time']	= "下单日期";
$language['admin_order_info']			= "订单信息";
$language['admin_order_invoice']		= "发票信息";
$language['admin_order_invoice_null']	= "无";
$language['admin_order_count_price']	= "订单总金额";
$language['admin_order_send_type']		= "配送方式";
$language['admin_order_send_price']		= "配送金额";
$language['admin_order_pay_type']		= "付款方式";
$language['admin_order_pay_price']		= "支付手续费";
$language['admin_order_goods_price']	= "商品总金额";
$language['admin_order_state']			= "订单状态";

$language['admin_order_receiver_ino']	= "收货人信息";
$language['admin_order_receiver_user']	= "收货人姓名";
$language['admin_order_receiver_mobile']= "联系手机";
$language['admin_order_receiver_tele']	= "联系电话";
$language['admin_order_receiver_email']	= "电子邮件";
$language['admin_order_receiver_address']= "收货地址";
$language['admin_order_receiver_zip']	= "邮政编码";
$language['admin_order_receiver_remarks']= "备注";
$language['admin_order_buy_user_info']	= "购买人信息";
$language['admin_order_buy_user_name']= "购买人姓名";
$language['admin_order_no_set']			= "未设置";

$language['admin_order_state_modify_ok']	= "订单状态修改成功";
$language['admin_order_state_modify_false']= "订单状态修改失败";



















?>