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
 * FILE_NAME : osa.api.php   FILE_PATH : \multishop\plug\api\cmsware\oas.api.php
 * ....cwps的接口文件
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Sat March 03 15:46:58 CST 2008
 */

class OasApi extends BaseInitialize{
	//CWPS地址
	var $CmsWareAPI_Url = ""; 
	//设置CWPS访问密码
	var $TransactionAccessKey = "";
	//ip地址
	var $domain = "";
	//初始化OAS客户端
	var $oas = "";
	
	
	function OasApi(){
		$this->_initialize();
		//主机域名
		$this->domain = $this->agent_ip;
		//CWPS地址
		$this->CmsWareAPI_Url = $this->_configinfo['api']['cmsware_path'] . "/cwps/soap.php" ; 
		//CWPS访问密码 
		//md5加密 例如：d6d06739ab77c69b7d1d76a2f15421cf
		$this->TransactionAccessKey = $this->_configinfo['api']['cmsware_TransactionAccessKey']; 
		//此路径为绝对路径,引入文件SoapOAS.class.php(url形式)
		require_once(BasePath . "/" . $this->_configinfo['api']['cmsware_path_absolut']."/cwps/OAS/SoapOAS.class.php");  
		//初始化OAS客户端
		$this->oas = new SoapOAS($this->CmsWareAPI_Url); 
		//设置CWPS访问密码
		$this->oas->setTransactionAccessKey($this->TransactionAccessKey); 
		//print_r($this->oas);
		//是否对SOAP数据包进行记录
		$this->oas->doLog = true;   
		//log文件名
		$this->oas->logFile = BasePath . "/" . $this->_configinfo['api']['cmsware_path_absolut']."/cwps/tmp/oas.log.".date("Y-m-d").".txt"; 
		//设置事务消息ID
		$this->oas->setTransactionID(time());
	}
	
	/**
	 * cwps用户登录
	 *
	 * @param string $userName
	 * @param string $password
	 * @param string $action
	 * @return bool
	 */
	function CwpsLogin($userName,$password,$action='Login'){
		//传递给接口的参数
		$params = array( 
			"UserName" => $userName,
			"Password" => $password,
			"Ip"       => $this->domain
			); 
		
		//默认所有params数据都进行base64编码
		//设为false的话，开发人员需要自行处理OAS端与CWPS端的数据编码与解码
		$this->oas->DataEncode = true; 
		//执行调用
		//print_r($params);
		$return = $this->oas->call($action, $params); 
		//echo $this->oas->errorCode;
		//print_r($this->oas->Response);
		//exit;
		if($return === false) { 
			return '';
		} else { 
			//执行成功，$return包含返回的数据,session_id
			return $return;
		}
	}
	
	/**
	 * cwps用户登出
	 *
	 * @param string $sId     会员登陆的Session ID
	 * @param string $action  请求参数
	 * @return void           无
	 */
	function CwpsLoginOut($sId,$action = 'Logout'){
		//传递给接口的参数
		$params = array( 
			"sId"=>$sId
		);
	    //传递给接口的参数
		//默认所有params数据都进行base64编码
		//设为false的话，开发人员需要自行处理OAS端与CWPS端的数据编码与解码
		$this->oas->DataEncode = true; 
		//执行调用
		//返回值为bool
		if($this->oas->call($action, $params))
		{
			return true;
		} 
		return false;
	}
	
	/**
	 * cwps注册
	 *
	 * @param string $userName     注册用户名(必须)
	 * @param string $password     注册密码，不用加密，直接传明码(必须)
	 * @param string $email        注册Email(必须)
	 * @param int    $gender       性别0-保密,1-男,2-女
	 * @param string $birthday     生日,格式:2005-10-01
	 * @param string $QQ           QQ号码
	 * @param string $nickName     昵称
	 * @param string $description  个人介绍
	 * @param string $user_Extra   所有自定义的额外用户属性都需要在Extra字段中包含
	 * 							   例如<User-Extra><Phone>13767666656</Phone><Money>10</Money><User-Extra>
	 * 							   包含子元素,可为空
	 * @param string $action       请求参数
	 * @return void                无
	 */
	function CwpsReg($userName,$password,$email = "",$gender=0,$birthday='',$QQ='',$nickName='',$description='',$user_Extra='',$action = 'Register'){
		//传递给接口的参数
		$params = array( 
			"UserName"    => $userName,
			"Password"    => $password,
			"Email"       => $email,
			"Gender"      => $gender,
			"Birthday"    => $birthday,
			"QQ"          => $QQ,
			"NickName"    => $nickName,
			"Description" => $description,
			"User-Extra"  => $user_Extra
		); 
			
		//默认所有params数据都进行base64编码
		//设为false的话，开发人员需要自行处理OAS端与CWPS端的数据编码与解码
		$this->oas->DataEncode = true; 
		//执行调用
		//返回值为bool
		$return = $this->oas->call($action, $params);
		//print_r($this->oas);
		return $return;
		if($this->oas->call($Action, $params)) 
		{	
			return true;
		}
		return false;
	}
	
	/**
	 * cwps修改密码
	 *
	 * @param string $userName 注册用户名(必须)
	 * @param string $password 注册密码，不用加密，直接传明码(必须)
	 * @param string $action   请求参数
	 * @return bool
	 */
	function CwpsChangePass($userName,$password,$action = 'ChangePass'){
		//传递给接口的参数
		$params = array( 
			"UserName"    => $userName,
			"Password"    => $password
		); 
		//默认所有params数据都进行base64编码
		//设为false的话，开发人员需要自行处理OAS端与CWPS端的数据编码与解码
		$this->oas->DataEncode = true; 
		//执行调用
		//返回值为bool
		if($this->oas->call($Action, $params)) 
		{	
			return true;
		}
		return false;
	}

	function CwpsDelUser($userName){
		//传递给接口的参数
		$params = array( 
			"UserName"    => $userName
		); 
		//默认所有params数据都进行base64编码
		//设为false的话，开发人员需要自行处理OAS端与CWPS端的数据编码与解码
		$this->oas->DataEncode = true; 
		//执行调用
		//返回值为bool
		if($this->oas->call($Action, $params)) 
		{	
			return true;
		}
		return false;
	}
}

?>