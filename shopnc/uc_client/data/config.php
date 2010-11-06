<?php
require ("../global.inc.php");

define('UC_VERSION', '1.0.0');        	//UCenter 版本标识
define('API_DELETEUSER', 1);        	//用户删除 API 接口开关
define('API_GETTAG', 1);        		//获取标签 API 接口开关
define('API_SYNLOGIN', 1);        		//同步登录 API 接口开关
define('API_SYNLOGOUT', 1);        		//同步登出 API 接口开关
define('API_UPDATEPW', 1);        		//更改用户密码 开关
define('API_UPDATEBADWORDS', 1);    	//更新关键字列表 开关
define('API_UPDATEHOSTS', 1);        	//更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);        	//更新应用列表 开关
define('API_UPDATECLIENT', 1);        	//更新客户端缓存 开关
define('API_UPDATECREDIT', 1);        	//更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);    	//向 UCenter 提供积分设置 开关
define('API_UPDATECREDITSETTINGS', 1);  //更新应用积分设置 开关
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');
define('IN_UC', TRUE);

class UCApiConfig extends BaseInitialize{
	/**
	 * 初始化
	 *
	 * @return InterfaceMember
	 */
	function UCApiConfig(){
		$this->_initialize();
	}

	function main(){
		/*===============UCenter======================*/
		define('UC_API', 		$this->_configinfo['interface']['uc_api']);
		define('UC_CONNECT', 	'mysql');
		define('UC_DBHOST', 	$this->_configinfo['interface']['uc_dbhost']);
		define('UC_DBUSER', 	$this->_configinfo['interface']['uc_dbuser']);
		define('UC_DBPW', 		$this->_configinfo['interface']['uc_dbpw']);
		define('UC_DBNAME', 	$this->_configinfo['interface']['uc_dbname']);
		define('UC_DBCHARSET', 	$this->_configinfo['interface']['uc_dbcharset']);
		define('UC_DBTABLEPRE', $this->_configinfo['interface']['uc_dbtablepre']);
		define('UC_DBCONNECT', 	$this->_configinfo['interface']['uc_dbconnect']);
		define('UC_KEY', 		$this->_configinfo['interface']['passport_key']);
		define('UC_CHARSET', 	$this->_configinfo['interface']['uc_charset']);
		define('UC_IP', 		$this->_configinfo['interface']['uc_ip']);
		define('UC_APPID', 		$this->_configinfo['interface']['uc_appid']);
		define('UC_PPP', 		$this->_configinfo['interface']['uc_ppp']);
		define('UC_LINK', 		$this->_configinfo['interface']['uc_link']);

		/*===============ShopNC======================*/
		define('NC_CONNECT', 	$this->_dbconfiginfo['database']['engine_type']);
		define('NC_DBHOST', 	$this->_dbconfiginfo['database']['servername_write']);
		define('NC_DBUSER', 	$this->_dbconfiginfo['database']['username_write']);
		define('NC_DBPW', 		$this->_dbconfiginfo['database']['password_write']);
		define('NC_DBNAME', 	$this->_dbconfiginfo['database']['databasename_write']);
		define('NC_DBCHARSET', 	$this->_dbconfiginfo['database']['dbcharset']);
		define('NC_DBTABLEPRE', $this->_dbconfiginfo['database']['dbprefix']);
	}
}

$uc_api_config = new UCApiConfig();
$uc_api_config->main();
?>