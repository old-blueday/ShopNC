<?php

/**
 * 中介担保请求类
 * ============================================================================
 * api说明：
 * init(),初始化函数，默认给一些参数赋值，如cmdno,date等。
 * getGateURL()/setGateURL(),获取/设置入口地址,不包含参数值
 * getKey()/setKey(),获取/设置密钥
 * getParameter()/setParameter(),获取/设置参数值
 * getAllParameters(),获取所有参数
 * getRequestURL(),获取带参数的请求URL
 * doSend(),重定向到财付通支付
 * getDebugInfo(),获取debug信息
 * 
 * ============================================================================
 *
 */

require ("RequestHandler.class.php");

class MediPayRequestHandler extends RequestHandler {
	
	function __construct() {
		$this->MediPayRequestHandler();
	}
	
	function MediPayRequestHandler() {
		//默认支付网关地址
		$this->setGateURL("https://www.tenpay.com/cgi-bin/med/show_opentrans.cgi");	
	}
	
	/**
	*@Override
	*初始化函数，默认给一些参数赋值。
	*/
	function init() {
		//自定参数，原样返回
		$this->setParameter("attach", "1");
		
		//平台商帐号
		$this->setParameter("chnid",  "");
		
		//任务代码
		$this->setParameter("cmdno", "12");
		
		//编码类型 1:gbk 2:utf-8
		$this->setParameter("encode_type", "1");
		
		//交易说明，不能包含<>’”%特殊字符
		$this->setParameter("mch_desc", "");
		
		//商品名称，不能包含<>’”%特殊字符
		$this->setParameter("mch_name", "");
		
		//商品总价，单位为分。
		$this->setParameter("mch_price",  "");
		
		//回调通知URL
		$this->setParameter("mch_returl",  "");
		
		//交易类型：1、实物交易，2、虚拟交易
		$this->setParameter("mch_type",  "");
		
		//商家的定单号
		$this->setParameter("mch_vno",  "");
		
		//是否需要在财付通填定物流信息，1：需要，2：不需要。
		$this->setParameter("need_buyerinfo",  "");
		
		//卖家财付通帐号
		$this->setParameter("seller",  "");
		
		//支付后的商户支付结果展示页面
		$this->setParameter("show_url",  "");
		
		//物流公司或物流方式说明
		$this->setParameter("transport_desc",  "");
		
		//需买方另支付的物流费用
		$this->setParameter("transport_fee",  "");
		
		//版本号
		$this->setParameter("version",  "2");
		
		//摘要
		$this->setParameter("sign",  "");
		
	}
	
}

?>