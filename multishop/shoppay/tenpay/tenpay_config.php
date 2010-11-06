<?
require ("../../global.inc.php");
//此文件为财付通支付配置文件
//☆★☆★☆★☆★☆★☆★财付通测试开关   0 关闭测试    1 开启测试☆★☆★☆★☆★☆★☆★

class tenpay_config extends CommonFrameWork
{
var $beta_switch		="0";

//☆★☆★☆★☆★☆★☆★财付通支付配置项。☆★☆★☆★☆★☆★☆★

//以下每一项都必须要配置，并准确
var $spid ;																	//卖家帐号
var $sp_key;																		//密钥
var $domain;															//商户网站域名
var $tenpay_dir;																			//财付通安装目录
var $site_name;																			//商户网站名称
var $attach				="tencent_magichu";																	//支付附加数据，非中文标准字符
var $pay_url			="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi"; 						//财付通支付网关地址

	function tenpay_config()
	{
		//调用父类构造函数
		parent::CommonFrameWork();

		//取卖家帐号
		//取帐号配置文件信息
		$pay_array = $this->_getconfigini("payment.ini.php");
		
		if($pay_array['online']['tenpay'] != ''){
			$this->spid = $pay_array['online']['tenpay'];//卖家帐号
			$this->sp_key = $pay_array['online']['tenpay_key'];//密钥
			$this->domain = $this->_configinfo['websit']['site_url'];//商户网站域名
			$this->tenpay_dir = '/shoppay/';//财付通安装目录
			$this->site_name = $this->_configinfo['websit']['site_name'];//商户网站名称
		}else{
			$this->redirectPath('error','','支付接口系统未设置');
		}
	}
}



?>
