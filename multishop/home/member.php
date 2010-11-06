<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : member.php   FILE_PATH : \multishop\home\member.php
 * ....会员表现层页面
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Thu Aug 09 15:33:46 CST 2007
 */

require ("../global.inc.php");


class ShowMember extends CommonFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $objmember;
	/**
	 * uc整合对象
	 *
	 * @var obj
	 */
	var $objucenter;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 商店对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;

	function main(){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->objmember)){
			require_once ("member.class.php");
			$this->objmember = new MemberClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 创建ucenter会员对象
		 */
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
			if (!is_object($this->objucenter)){
				require_once ("ucenter.class.php");
				$this->objucenter = new ucenterClass();
			}
		}

		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("member");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "check":
				$this->_checkUser();
				break;
			case "login":
				$this->isMember(true);
				$this->_login();
				break;
			case "regist":
				$this->isMember(true);
				$this->_regist();
				break;
			case "loginsave":
				$this->_dologin();
				break;
			case "registsave":
				$this->_doregist();
				break;
			case "registsuccess":
				$this->_registsuccess();
				break;
			case "logout":
				$this->_dologout();
				break;
			case "forget":
				$this->isMember(true);
				$this->_forget();
				break;
			case "check_code":
				$this->check_code();
				break;
			default:
				$this->isMember(true);
				$this->_login();
		}

	}
	/**
	 * 会员登陆
	 *
	 */
	function _login(){
		/**
		 * 通行证设置多用户为客户端，替换登录注册退出链接地址为通行证服务器端地址
		 */
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '1'){
			$passport_url = $this->_configinfo['api']['passport_url'];
			$passport_loginurl = $this->_configinfo['api']['passport_login'];

			if($_SESSION["s_login"]['login'] != 1){
				header("location: ".$passport_url."/".$passport_loginurl);

			}
		}

		/**
		 * 通行证设置多用户为服务器端，如果客户端已填写登陆信息则进行登陆处理操作
		 */
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '0'){
			$username = strstr($this->_input['action'],'username=');
			if ($username != '' && $this->_input['password'] != '') {
				$username = substr($username,9);
				$this->_input['txtloginname'] = $username;
				$this->_input['txtPassword'] = $this->_input['password'];
				$this->_input['forward'] = $this->_input['forward'] ? $this->_input['forward'] : $_SERVER['HTTP_REFERER'];
				$this->_dologin();
			}
		}

		if($this->_input['forward'] != ""){
			$this->output('refer_url',substr(strstr($_SERVER['REQUEST_URI'],'forward='),strlen('forward=')));
		}elseif($this->_input['refer_url'] != ""){
			$this->output('refer_url',substr(strstr($_SERVER['REQUEST_URI'],'refer_url='),strlen('refer_url=')));
		}elseif(preg_match("/member\/error.php/i",$_SERVER['HTTP_REFERER'])){
			$this->output('refer_url','');
		}else{
			$this->output('refer_url',$_SERVER['HTTP_REFERER']);
		}
		$this->showpage("member.login");
	}


	/**
	 * 会员登陆处理
	 *
	 */
	function _dologin(){
		//AJAX验证 转化用户名
		if($this->_input['login_ajax'] == 1){
			$this->_input["txtloginname"] = Common::unescape($this->_input["txtloginname"],strtoupper($this->_configinfo['websit']['ncharset']));
		}

		/**
		 * 信息验证
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtloginname"], "require"=>"true", "message"=>$this->_lang['errMloginnameIsEmpty']),
		array("input"=>$this->_input["txtPassword"], "require"=>"true", "message"=>$this->_lang['errMPasswordIsEmpty'])
		);
		$error = $this->objvalidate->validate();
		if ($error != "" ){
			if($this->_input['login_ajax'] == 1){
				Common::outMessage('json',str_replace('<br />',' ',$error),0);
			}else{
				$this->redirectPath("error","",$error);
			}
		}
		//ucenter会员登录部分 ucenter部分
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
			if(API_SYNLOGIN == '1') {
				$uc_uid = $this->objucenter->login($this->_input['txtloginname'], trim($this->_input['txtPassword']));
				if(!$uc_uid) {
					$this->redirectPath("error","",$this->_lang['errMLoginError']);
				}
			}
		}
		/**
		 * 会员登录，得到会员信息
		 */
		$member_array = $this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtloginname'],"password"=>md5($this->_input['txtPassword'])),"3");
		//登录成功
		if (is_array($member_array)){
			//判断是否被锁定
			if ($member_array['member_state'] == 0) {
				if($this->_input['login_ajax'] == 1){
					Common::outMessage('json',$this->_lang['errMNotLockedMember'],0);
				}else{
					$this->redirectPath("error","",$this->_lang['errMNotLockedMember']);
				}
			}
			//判断是否是删除状态
			if ($member_array['member_state'] == 2) {
				if($this->_input['login_ajax'] == 1){
					Common::outMessage('json',$this->_lang['errMLoginError'],0);
				}else{
					$this->redirectPath("error","",$this->_lang['errMLoginError']);
				}
			}
			//创建商铺对象
			if (!is_object($this->obj_shop)){
				require_once("shop.class.php");
				$this->obj_shop = new ShopClass();
			}
			//更新会员用户组
			$member_array = $this->objmember->updateMemberToGroup($member_array['member_id']);
			//判断用户组权限
			CheckPermission::memberGroupPermission('login',$member_array['member_id'],'',$this->_input['login_ajax']);
			//店铺信息
			$shop_array = $this->obj_shop->getOneShopByMemeberId($member_array['member_id'],'1','*');
			if ($shop_array['shop_id'] > 0){
				$_SESSION["s_shop"]['id'] = $shop_array['shop_id'];
				$_SESSION['s_shop']['shop_grade_state'] = $shop_array['grade_state'];
				$_SESSION["s_shop"]['audit_state'] = $shop_array['audit_state'];
				$_SESSION["s_shop"]['if_del'] = $shop_array['if_del'];
				$this->shopid = $_SESSION["s_shop"]['id'];
			}
			$_SESSION["s_login"]['login'] = 1;
			$_SESSION["s_login"]['id'] = $member_array['member_id'];       //会员ID
			$_SESSION["s_login"]['name'] = $member_array['login_name'];    //登陆名称
			$_SESSION["s_login"]['type'] = $member_array['member_type'];  //会员类型
			$_SESSION['s_login']['feed'] = @unserialize($member_array['feedsetting']);

			//更新最后登录时间
			$this->objmember->modifyMember($input_param,$_SESSION["s_login"]['id'],"last_login_time");
			//设置cookie信息
			$this->_set_login_token();
			$this->_update_login_state();


			if($this->_input['forward']==""){
				$forward = substr(strstr($_SERVER['REQUEST_URI'],'refer_url='),strlen('refer_url='));
			}else{
				$forward = substr(strstr($_SERVER['REQUEST_URI'],'forward='),strlen('forward='));
			}
			//ucenter会员登录部分 通知部分
			if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
				if(API_SYNLOGIN == '1') {
					$uc_output = $this->objucenter->output_login($uc_uid);
					/**
					 * 输出
					 */
					$this->output('uc_output',$uc_output);
					$this->output('backurl',urldecode($forward));
					$this->output('error_message', $this->_lang['langMLoginSucc']);
					$this->showpage('error');
					exit;
				}
			}
			if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '0'){
				/*===========================================================================
				商城作为服务器端登陆接口部分  开始
				===========================================================================*/
				require_once("../plug/api/interface_member.php");
				$interface = new InterfaceMember;
				$this->_input['forward'] = $_SESSION['api_refer'] ? $_SESSION['api_refer'] : $this->_input['forward'];
				$interface->loginInterface($member_array['member_id'],$member_array['login_name'],$this->_input['txtPassword'],$member_array['email'],$this->_input['refer_url'],$this->_input['forward'],"login");
				/*===========================================================================
				登陆接口部分  结束
				===========================================================================*/
			}else{
				if($this->_input['login_ajax'] == 1){
					Common::outMessage('json','',1);
				}else{
					$this->redirectPath("refer",$forward);
				}
			}
		}else{
			if($this->_input['login_ajax'] == 1){
				Common::outMessage('json',$this->_lang['errMLoginError'],0);
			}else{
				$this->redirectPath("error","",$this->_lang['errMLoginError']);
			}
		}
	}


	/**
	 * 会员注册
	 *
	 */
	function _regist(){
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '0'){
			$_SESSION['api_refer'] = $_SERVER['HTTP_REFERER'];
		}
		//地区内容
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		//csrf
		$this->csrf_seride('output');
		$this->output('area_array',$area_array);
		$this->output('refer_url',"home/member.php?action=registsuccess");
		$this->showpage("member.regist");
	}


	/**
	 * 保存注册信息
	 *
	 */
	function _doregist(){
		/**
		 * 验证注册信息
		 */
		//csrf
		$this->csrf_seride('check');

		$this->objvalidate->setValidate(array("input"=>$this->_input['txtloginname'],"require"=>"true","validator"=>"Length","min"=>3,"max"=>15,"message"=>$this->_lang['alertEnterUserName']));
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtPassword'],"require"=>"true","validator"=>"Length","min"=>6,"max"=>16,"message"=>$this->_lang['alertEnterPassword']));
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtPassword'],"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>$this->_input['txtrePassword'],"message"=>$this->_lang['errMRePassword_Wrong']));
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtemail'],"require"=>"true","validator"=>"Email","message"=>$this->_lang['errMEmail_Wrong']));
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtemail'],"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>$this->_input['txtecheckmail'],"message"=>$this->_lang['errMReEmail_Wrong']));
		$this->objvalidate->setValidate(array("input"=>strtoupper($this->_input['code']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['errMValidateCode']));
		$error = $this->objvalidate->validate();
		if ($error != "" ){
			//返回错误信息
			$this->redirectPath("error","",$error);
		}else{
			//检查是否存在删除状态的相同会员名的信息，有则删除
			$check_id = $this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtloginname'],"member_state"=>2),2);
			if ($check_id != ''){
				$input['id'] = $check_id;/*通过ID删除*/
				$this->objmember->delMember($input);
				//删除改会员的店铺，商品
				//删除商店
				if (!is_object($this->obj_shop)){
					require_once("shop.class.php");
					$this->obj_shop = new ShopClass();
				}
				$this->obj_shop->delShopByMemberId($check_id);
				//删除商品
				if (!is_object($this->obj_product)){
					require_once("product.class.php");
					$this->obj_product = new ProductClass();
				}

				$condition_product['member'] = $check_id;
				$condition_product['state'] = 'none';
				$prodcut_array = $this->obj_product->getProductList($condition_product,$page);
				if (is_array($prodcut_array)){
					foreach ($prodcut_array as $k => $v){
						$this->obj_product->delProduct($v['p_code']);
					}
				}
			}
			//检查会员名称是否存在
			if ($this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtloginname'])) == true){
				//如果存在返回错误信息
				$this->redirectPath("error","",$this->_lang['errExistloginname']);  //登录名称已经存在
				//检查邮件是否已经注册过
			}else if($this->objmember->checkMemberExist(array("email"=>$this->_input['txtemail'])) == true){
				//如果存在返回错误信息
				$this->redirectPath("error","",$this->_lang['errMEmailExist']);   //邮箱已经被注册，请更换其他邮箱。
			}else{
				//ucenter会员校验
				if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
					if(API_SYNLOGIN == '1') {
						$result = $this->objucenter->addUser(trim($this->_input['txtloginname']),trim($this->_input['txtPassword']),trim($this->_input['txtemail']));
						if($result === false) {
							$uc_error = $this->objucenter->uc_error;
							$this->redirectPath("error","",$this->_lang[$uc_error]);
						}else{
							//UC返回的会员ID
							$this->_input['add_member_id'] = $this->objucenter->adduid;
						}
					}
				}
				//将会员信息放入数据库中
				$member_id = $this->objmember->addMember($this->_input);

				//会员登录，得到会员信息
				$member_array = $this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtloginname']),"3");
				//注册后登陆
				$_SESSION["s_login"]['login'] = 1;
				$_SESSION["s_login"]['id'] = $member_array['member_id'];       //会员ID
				$_SESSION["s_login"]['name'] = $member_array['login_name'];    //登陆名称
				$_SESSION["s_login"]['type'] = $member_array['member_type'];  //会员类型
				//注册加分，必须在session后面
				CreditsClass::saveCreditsLog('regist',$_SESSION["s_login"]['id'],false);
				//更新最后登录时间
				$this->objmember->modifyMember($input_param,$_SESSION["s_login"]['id'],"last_login_time");
				//设置cookie信息
				$this->_set_login_token();
				$this->_update_login_state();
				//增加该用户的提醒设置信息
				//创建提醒对象
				if (!is_object($this->obj_remind)){
					require_once("remind.class.php");
					$this->obj_remind = new RemindClass();
				}
				$remind_array = array();
				$remind_array = $this->obj_remind->defaultRemindArray('2',$this->_lang);//默认设置
				$remind_array['member_id'] = $_SESSION['s_login']['id'];
				$remind_array['login_name'] = $_SESSION['s_login']['name'];
				$remind_array['date_line'] = time();
				$this->obj_remind->addRemind($remind_array);
				unset($remind_array);
				/**
				 * 注册后发信
				 */
				require_once("sendsitemail.class.php");
				$obj_sendmail = new SendSiteMail();
				$obj_sendmail->smtpconfig = $this->_configinfo;
				$param_array = array(
				'username'=>$this->_input['txtloginname'],
				'passwd'=>$this->_input['txtPassword']
				);
				$obj_sendmail->SendMail("regist",$param_array,$this->_input['txtemail']);
				unset($obj_sendmail);

				//如果开启缴费，则增加会员的试用期内容
				if($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
					require_once('settings.class.php');
					$obj_settings = new SettingsClass();
					$array = array();
					$array['product_number'] = $obj_settings->getSettings('shoppay_product_num');
					//$array['shop_availability_time'] = time()+$obj_settings->getSettings('shoppay_shop_time')*24*60*60;
					$this->objmember->modifyMember($array,$_SESSION['s_login']['id'],'shoppay');
					unset($obj_settings,$array);
				}

				//ucenter会员登录部分
				if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
					if(API_SYNLOGIN == '1') {
						$uid = $this->objucenter->login($this->_input['txtloginname'],$this->_input['txtPassword']);
						$uc_output = $this->objucenter->output_login($uid);
						/**
						 * 输出
						 */
						$this->output('uc_output',$uc_output);
						$this->output('backurl','member.php?action=login');
						$this->output('error_message', $this->_lang['langMRegSucceed']);
						$this->showpage('error');
						exit;
					}
				}
				if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '0'){
					/*===========================================================================
					登陆接口部分  开始
					===========================================================================*/
					require_once("../plug/api/interface_member.php");
					$interface = new InterfaceMember;
					$interface->loginInterface($member_id,$this->_input['txtloginname'],$this->_input['txtPassword'],$this->_input['txtemail'],"",$this->_configinfo[websit][site_url]."/home/member.php?action=registsuccess","reg");
					/*===========================================================================
					登陆接口部分  结束
					===========================================================================*/
				}else{
					$this->redirectPath("refer",$this->_configinfo[websit][site_url]."/home/member.php?action=registsuccess");
				}
			}
		}
	}

	function _registsuccess(){
		//注册成功后跳转到登陆页面
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '0'){
			unset($_SESSION['s_login']);
		}
		$this->redirectPath("succ","home/member.php?action=login",$this->_lang['langMRegSucceed']);
	}
	/**
	 * 检查会员名是否已被注册
	 *
	 */
	function _checkUser(){
		$this->objvalidate->setValidate(array("input"=>$this->_input['username'],"require"=>"true","message"=>$this->_lang['errMUserName_Blank']));
		$error = $this->objvalidate->validate();
		if ($error != '') {
			echo $error;exit;
		}
		//解密
		$this->_input['username'] = Common::unescape($this->_input['username'],$this->_configinfo['websit']['ncharset']);

		//判断是否整合UC
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
			$uc_result = $this->objucenter->check_user_exist($this->_input['username']);
			if ($uc_result !== true){
				echo 1;exit;
			}
		}

		//检查会员是否存在
		$exist_user = $this->objmember->checkMemberExist(array("member_name"=>trim($this->_input['username']),"no_member_state"=>2));

		if ($exist_user == true){
			$result = 1;
		}else{
			$result = 0;
		}
		echo $result;
	}

	/**
	 * 退出登陆
	 *
	 */
	function _dologout(){
		/**
		 * 通行证开启，多用户商城为客户端
		 */
		if ($this->_configinfo['api']['open_passport']=='1' && $this->_configinfo['api']['passport_type']=='1'){
			if($this->_input['forward']==""){
				$passport_forwardurl = $this->_input['refer_url'];
			}else{
				$passport_forwardurl = $this->_input['forward'];
			}

			$passport_url = $this->_configinfo['api']['passport_url'];
			$passport_logouturl = $this->_configinfo['api']['passport_logout'];
			$userdb['username'] = $_SESSION["s_login"]['name'];
			if (strpos($passport_logouturl,'?')===false) {
				$passport_logouturl .= '?';
			} elseif (substr($passport_logouturl,-1)!='&') {
				$passport_logouturl .= '&';
			}
			/**
			 * 创建会员对象
			 */
			require_once('member.class.php');
			$obj_member = new MemberClass();
			/*取出会员信息*/
			$rs_array = $obj_member->checkMemberExist(array("member_name"=>$userdb[username]),3);
			$userdb['uid'] = $_SESSION["s_login"]['ppt_uid'];
			$userdb['password'] = $rs_array['password'];
			$userdb['email'] = $rs_array['email'];
			$userdb['time'] = time();
			foreach($userdb as $key=>$val){
				$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
			}
			$passport_key = $this->_configinfo['api']['passport_key'];
			require_once('api.class.php');
			$userdb_encode=str_replace('=','',Api::phpwindStrCode($userdb_encode));

			//			$passport_verify = md5("quit$userdb_encode$passport_forwardurl$passport_key");
			//			$passport_verify = substr(md5($userdb['uid'].$passport_key),0,8);
			$passport_verify = substr(md5($_SERVER['REMOTE_ADDR'].$passport_key.$_SERVER['HTTP_USER_AGENT']),8,8);
			$logout_url = $passport_url."/".$passport_logouturl."verify=".$passport_verify;
			@header("Location: ".$logout_url);exit;
		}


		setcookie("c_login_name","");
		setcookie("sys_sid","");
		$_SESSION["s_login"] = array();
		$_SESSION["s_shop"] = array();
		session_unregister("s_login");
		session_unregister("s_shop");

		//ucenter会员退出
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
			if(API_SYNLOGOUT == '1') {
				$forward = $this->_input['forward']?$this->_input['forward']:$this->_input['refer_url'];
				$uc_output = $this->objucenter->logout();
				/**
				 * 输出
				 */
				$this->output('uc_output',$uc_output);
				$this->output('backurl',urldecode($forward));
				$this->output('error_message', $this->_lang['langMLogoutSucc']);
				$this->showpage('error');
				exit;
			}
		}
		if ($this->_configinfo['api']['open_passport']=='1' && $this->_configinfo['api']['passport_type']=='0'){

			/*===========================================================================
			登陆接口部分  开始
			===========================================================================*/
			require_once("../plug/api/interface_member.php");
			$interface = new InterfaceMember;
			$this->_input['forward'] = $this->_input['forward'] ? $this->_input['forward'] : $_SERVER['HTTP_REFERER'];
			$interface->loginInterface('','','','',$this->_input['refer_url'],$this->_input['forward'],"exit");
			/*===========================================================================
			登陆接口部分  结束
			===========================================================================*/
		}else{
			if($this->_input['forward']==""){
				$forward = $this->_input['refer_url'];
			}else{
				$forward = $this->_input['forward'];
			}
			$this->redirectPath("refer",$forward);
		}
	}

	/**
	 * 忘记密码
	 *
	 */
	function _forget(){
		//是否开启找回密码的邮件模板
		include_once("mailcontent.class.php");
		$obj_mailcontent = new MailContentClass();
		$mailcontent_array = $obj_mailcontent->getMailContent("forget");
		if ($mailcontent_array['ifopen'] != '1') {
			$this->redirectPath("error","",$this->_lang['langMForgetSystemIfOpen']);
			exit;
		}
		//忘记密码第一步
		if ($this->_input['step'] == '1'){
			//检查会员是否存在
			$exist = $this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtloginname']));
			//抛出会员名称到页面
			$this->output('forget_login_name',$this->_input['txtloginname']);
			if ($exist == true){
				//存在的话显示忘记密码第二步页面
				$this->showpage("member.forget_two");
			}else{
				//会员不存在跳转到错误页面
				$this->redirectPath("error","",$this->_lang['errMNotExistMember']);        //会员并不存在!
			}
			//忘记密码第二步
		}else if($this->_input['step'] == '2'){
			//检查会员是否存在
			$member_exist = $this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtloginname']));
			if ($member_exist !== true){
				//会员不存在跳转到错误页面
				$this->redirectPath("error","",$this->_lang['errMNotExistMember']);        //会员并不存在!
			}
			//获取新的随机密码
			$exist = $this->objmember->getMemberNewPassword($this->_input);
			if ($exist == false){
				$this->redirectPath("error","",$this->_lang['errMGetNewPassword']);     //获得密码错误!
			}else{

				/**整合UC后修改新密码**/
				if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
					$result_edit_ucuser = $this->objucenter->edit_user(array('login_name'=>$this->_input['txtloginname'],'password'=>$exist),1);
					if($result_edit_ucuser == false){
						$this->redirectPath("error","",$this->objucenter->error);
					}
				}
				/**
				 * 获取新的密码后发信
				 */
				require_once("sendsitemail.class.php");
				$obj_sendmail = new SendSiteMail();
				$obj_sendmail->smtpconfig = $this->_configinfo;
				$param_array = array(
				'username'=>$this->_input['txtloginname'],
				'newpass'=>$exist
				);
				$result = $obj_sendmail->SendMail("forget",$param_array,$this->_input['txtemail']);
				unset($obj_sendmail);
				if ($result === true){
					$this->redirectPath("succ","index.php",$this->_lang['langMThird']);
				}else {
					$this->redirectPath("error","../index.php",$this->_lang['errMThird']);
				}
			}
		}else{
			//显示找回密码第一步页面
			$this->showpage("member.forget_one");
		}
	}


	/**
	 * 验证码验证
	 */
	function check_code(){

		if (strtoupper($this->_input['checkcode']) == strtoupper($_SESSION['seccode'])){
			echo  0;
		}else {
			echo  1;
		}
	}
}
$member = new ShowMember();
$member->main();
unset($member);
?>