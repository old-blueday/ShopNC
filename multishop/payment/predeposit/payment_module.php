<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : payment_module.php   FILE_PATH : E:\www\multishop\trunk\payment\predeposit\payment_module.php
 * ....预存款支付方式
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Mar 03 11:14:26 CST 2009
 */

include(BasePath."/global.inc.php");//加载信息

class predepositPaymentMethod extends CommonFrameWork{
	/*配置文件名*/
	var $config_file;

	/**
	 * 构造函数
	 * @author ShopNC Develop Team     
	 * @param  
	 * @return int/bool/object/array
	 */
	function predepositPaymentMethod(){
		$this->__construct();
	}
	
	function __construct(){
		//初始化变量
		$this->_getConfiginfo();
		//语言包
		$this->getlang('own_order');
		
		$this->config_file = '';
	}

	/**
	 * 支付方式参数
	 * 参数说明：	$payment['dir'] 支付接口目录，也作为支付方式英文名
	 * 			$payment['name'] 支付接口名称
	 * 			$payment['config'] 支付接口配置名
	 * 			$payment['type'] 支付接口类型：vouch担保型 instant即时型 offline线下型
	 * 			$payment['field'] 会员扩展表数据库字段
	 * 			$payment['currency'] 该支付方式支持的货币种类
	 */
	function payment_param(){
		$payment['dir'] = 'predeposit';
		$payment['name'] = $this->_lang['langOrderPaymentPredeposit'];
		$payment['config'] = 'payment_predeposit';
		$payment['type'] = 'offline';
		$payment['field'] = 'predeposit';
		$payment['currency'] = array("CNY");

		return $payment;
	}

	/**
	 * 编辑页面参数说明
	 * 参数格式
	 * 
	 * 
	 * 
	 */
	function modi_param(){

		$param = array();
		
		return $param;
	}


	/**
	 * 支付方法
	 *
	 */
	function payment_function($case){
		//if()
		echo "1";
		
	}
	
	/**
	 * 获取操作链接
	 * @author ShopNC Develop Team     
	 * @param  $param 参数数组
	 * $param['dir_name']	支付路径
	 * $param['sp_code']	订单号
	 * $param['receive_code']	收货地址
	 * $param['order_state']	订单状态
	 * 
	 * @return string
	 */
	function payment_url($param){
		switch ($param['order_state']){
			case '0'://已购买，初始状态,等待买家付款
				return array(
					'state_title'=>$this->_lang['langOrderWaitBuyPayment'],
					'state_url'=>$this->_configinfo['websit']['site_url'].'/member/own_order.php?action=predeposit_pay&sp_code='.$param['sp_code'],
					'state_type'=>'buyer',
				);
				break;
			case '1'://买家已付款,等待卖家发货
				return array(
					'state_title'=>$this->_lang['langOrderBuyWaitSaleConsignment'],
					'state_url'=>$this->_configinfo['websit']['site_url'].'/member/own_order.php?action=invoice&sp_code='.$param['sp_code'].'&receive_code='.$param['receive_code'].'&type=instant',
					'state_type'=>'seller',
				);
				break;
			case '2'://卖家已发货，等待买家确认收货
				return array(
					'state_title'=>$this->_lang['langOrderSaleWaitBuyAffirm'],
					'state_url'=>$this->_configinfo['websit']['site_url'].'/member/own_order.php?action=order_receive&sp_code='.$param['sp_code'],
					'state_type'=>'buyer',
				);
				break;
			case '3'://买家确认收货，交易完成
				return array(
					'state_title'=>$this->_lang['langOrderBargainingOk'],
					'state_url'=>'',
					'state_type'=>'all',
				);
				break;
			case '4'://团购中
//				return "member/own_main.php";
				break;
			case '5'://团购失败
//				return "member/own_main.php";
				break;
			case '6'://交易失败
				return array(
					'state_title'=>$this->_lang['langOPayLost'],
					'state_url'=>'',
					'state_type'=>'all',
				);
				break;
			case '7':
				return array(
					'state_title'=>$this->_lang['langOrderStateClose'],
					'state_url'=>'',
					'state_type'=>'all',
				);
				break;
			default:
				exit;
		}
	}
}
?>