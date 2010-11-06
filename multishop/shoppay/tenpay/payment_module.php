<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : install.php   FILE_PATH :payment\alipay\install.php
 * ....财付通支付方式插件
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Apr 28 10:39:22 CST 2008
 */
include(BasePath."/global.inc.php");//加载信息

class tenpayPaymentMethod{

	var $config_file;

	/**
	 * 构造函数
	 * @author ShopNC Develop Team     
	 * @param  
	 * @return int/bool/object/array
	 */
	function tenpayPaymentMethod(){
		$this->__construct();
	}
	
	function __construct(){
		parent::CommonFrameWork();
		//语言包
		$this->getlang('own_order');
		
		$this->config_file = 'tenpay_config.php';
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
		$payment['dir'] = 'tenpay';
		$payment['name'] = $this->_lang['langOrderPaymentTenpay'];
		$payment['config'] = 'payment_tenpay';
		$payment['type'] = 'vouch';
		$payment['field'] = 'tenpay';
		$payment['currency'] = array('CNY');

		return $payment;
	}

	/**
	 * 编辑页面参数说明
	 * $modi_array['filename'] = 配置文件名
	 * $modi_array['param'] = array('配置文件参数'=>'页面显示文字');  编辑页面参数说明
	 * 
	 */
	function modi_param(){
		$param = array('chnid'=>$this->_lang['langOTenpayChnid'],'sp_key'=>$this->_lang['langOTenpaySpKey']);
		return $param;
	}
	
	/**
	 * 支付方法
	 *
	 */
	function payment_function(){
		echo "2";
	}
}
?>