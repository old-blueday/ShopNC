<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想单用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : user.php   FILE_PATH : \shopnc6\home\user.php
 * ....会员表现层页面
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Jun 17 10:55:46 CST 2008
 */

require ("../global.inc.php");

class ShowUser extends CommonFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	private $obj_user;
	/**
	 * uc对象
	 *
	 * @var obj
	 */
	private $objucenter;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	private $objvalidate;
	/**
	 * csrf对象
	 *
	 * @var obj
	 */
	private $obj_seride;
	
	function main(){

		/**
		 * 创建会员对象
		 */

		if (!is_object($this->obj_user)){
			require_once("users.class.php");
			$this->obj_user = new UsersClass();
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
		if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
			if (!is_object($this->objucenter)){
				require_once ("ucenter.class.php");
				$this->objucenter = new UcenterClass();
			}
		}
		/**
		 * 创建csrf对象
		 */
		if (!is_object($this->obj_seride)){
			require_once("seride.php");
			$this->obj_seride = new Seride();
		}
		/**
		 * 设置模板路径
		 */
		//		$this->setsubtemplates("");
		/**
		 * 语言包
		 */
		$this->getlang("forget_pw,register,header_footer,login");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "register":		//用户注册
			$this->doRegister();
			break;
			case "register_save":	//保存注册用户
			$this->addUser();
			break;
			case "check":			//验证用户名
			$this->checkUser();
			break;
			case "check_code":		//校验验证码
			$this->checkCode();
			break;
			case "login":			//登录
			$this->login();
			break;
			case "login_out":		//退出
			$this->loginOut();
			break;
			case'forgetpass':		//忘记密码页面
			$this->forgetPasswd();
			break;
			case 'get_passwd':		//获取密码
			$this->getPasswd();
			break;
			default:
				$this->loginPage();
				break;
		}

	}
	/**
	 * 注册页面
	 *
	 */
	private function doRegister(){
		if($_SESSION['userinfo']['user_name'] != '') {
			header("Location:user_center.php");
			exit;
		}
		/*添加验证信息*/
		$this->output('seride_form',$this->obj_seride->seride_form());

		$this->showpage("register");
	}
	/**
	 * 保存注册信息
	 *
	 */
	private function addUser(){
		/**
		 * 验证信息
		 */
		$this->obj_seride->seride_check($this->_charset);

		$input_param['txt_user_name']		= $this->_input['reg_user']; //会员名称
		$input_param['txt_user_password']	= $this->_input['reg_pass']; //会员密码
		$input_param['txt_user_email']		= $this->_input['reg_mail']; //会员邮箱
		/**
		 * 验证注册信息
		 */

		$this->objvalidate->setValidate(array("input"=>$input_param['txt_user_name'],"require"=>"true","validator"=>"Length","min"=>2,"max"=>20,"message"=>$this->_lang['username_note']));   //可以由英文、数字组成，长度为6-20位
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_user_password'],"require"=>"true","validator"=>"Length","min"=>6,"max"=>20,"message"=>$this->_lang['pwd_note']));    //可以由英文、数字组成，长度为6-20位字符，区分大小写
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_user_password'],"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>$this->_input['reg_rpass'],"message"=>$this->_lang['affirm_no_equal']));   //两次密码输入不一致!
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_user_email'],"require"=>"true","validator"=>"Email","message"=>$this->_lang['email_error']));    //邮件格式非法
		/*判断验证码是否开启*/
		if($this->_viewinfo['websit']['view_reg_validate'] == '1') {
			$this->objvalidate->setValidate(array("input"=>strtoupper($this->_input['reg_code']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['code_error']));  //您输入的验证码不对!
		}
		$error = $this->objvalidate->validate();
		if ($error != "" ){
			//返回错误信息
			$this->showMessage($error,$this->_configinfo['websit']['site_url']."/member/user.php?action=register",1,2000);
		}

		else {
			//判断用户名是否已注册
			$result = $this->obj_user->checkUserExist(array("user_name"=>$input_param['txt_user_name']),"1");
			if ($result == true) {
				$this->showMessage($this->_lang['exist_username'],$this->_configinfo['websit']['site_url']."/member/user.php?action=register",1,4000);
			}
			else {
				//ucenter会员校验
				if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
					if(file_exists(BasePath."/uc_client/data/config.php")) {
						include_once(BasePath."/uc_client/data/config.php");
					}
					if(API_SYNLOGIN == '1') {
						session_set_cookie_params('36000');
						if(!$this->objucenter->addUser(trim($this->_input['reg_user']),trim($this->_input['reg_pass']),trim($this->_input['reg_mail']))) {
							//$this->redirectPath("error","",$this->objucenter->error);
							$this->showMessage($this->objucenter->error,$this->refer_url,1);
						}else{
							$this->_input['add_member_id'] = $this->objucenter->adduid;
						}
					}

				}

				$user_info = $this->obj_user->addUser($input_param);
				//将用户信息放入session
				$_SESSION['userinfo']['user_id'] 	= $user_info['user_id'];
				$_SESSION['userinfo']['user_name'] 	= $user_info['user_name'];
				$_SESSION['userinfo']['user_email'] = $user_info['user_email'];
				$_SESSION['userinfo']['user_grade_name'] 		= $user_info['grade_name']==''?$this->_lang['login_grade_name']:$user_info['grade_name'];		//会员等级
				$_SESSION['userinfo']['user_grade_discount'] 	= $user_info['grade_discount'];	//会员折扣
				/*发送邮件*/
				if($this->_configinfo['websit']['new_user_mail'] == '1') {
					include_once("system.class.php");
					$email_template	= new SystemClass();
					$user_email_template	= $email_template->getEmailTemplate(array('mail_template_name'=>"'new_user_mail'"));
					$user_array				= array('user_name'		=> $user_info['user_name'],
					'shop_name'		=> $this->_configinfo['websit']['site_name'],
					'passwd'		=> $input_param['txt_user_password']);
					$email_body				= Common::replaceMailContent($user_array,$user_email_template['mail_template_body']);
					/*发送邮件*/
					Common::shopnc_send_mail($input_param['txt_user_email'],$this->_lang['register_user'],$email_body);
				}

				$this->showMessage($this->_lang['reg_succ'],$this->_configinfo['websit']['site_url']."/index.php",1,2000);
			}
		}
	}

	/**
	 * 验证用户名
	 *
	 */
	private function checkUser(){

		$this->objvalidate->setValidate(array("input"=>$this->_input['username'],"require"=>"true","message"=>$this->_lang['errMUserName_Blank']));   //5-20个字符(包括小写字母、数字、下划线、中文)，一个汉字为两个字符，推荐使用中文会员名。一旦注册成功会员名不能修改。
		$error = $this->objvalidate->validate();
		if ($error != '') {
			echo $error;exit;
		}

		//检查会员是否存在
		$exist_user = $this->obj_user->checkUserExist(array("user_name"=>trim($this->_input['username'])));

		if ($exist_user == true){
			$result = 1;
		}else{
			$result = 0;
		}
		echo $result;
	}

	/**
	 * 验证码验证
	 */
	private function checkCode(){
		if (strtoupper($this->_input['checkcode']) == strtoupper($_SESSION['seccode'])){
			echo  0;
		}else {
			echo  1;
		}
	}
	/**
	 * 用户登录
	 *
	 */
	private function login(){
		/**
		 * 验证信息(csrf)
		 */
		$this->obj_seride->seride_check($this->_charset);
		
		/*信息验证*/
		$this->objvalidate->setValidate(array('input'=>$this->_input['txt_username'],	'require'=>"true",'message'=>$this->_lang['login_name_null']));
		$this->objvalidate->setValidate(array('input'=>$this->_input['txt_pwd'],		'require'=>"true",'message'=>$this->_lang['login_passwd_null']));
		/*判断验证码是否开启*/
		if($this->_viewinfo['websit']['view_login_validate'] == '1') {
			$this->objvalidate->setValidate(array('input'=>strtoupper($this->_input['txt_login_code']),	'require'=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),'message'=>$this->_lang['login_code_error']));
		}
		$error = $this->objvalidate->validate();
		if($error) {
			$this->showMessage($error,$this->refer_url,1);
		}
		/**
		 * 判断ucenter是否整合，如果整合，这里进行第一次校验，当用户存在，不执行，不存在，则插入
		 */
		if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
			if(file_exists(BasePath."/uc_client/data/config.php")) {
				include_once(BasePath."/uc_client/data/config.php");
			}

			if(API_SYNLOGIN == '1') {

				$uc_login_result = $this->objucenter->check_user_exist($this->_input['txt_username'], $this->_input['txt_pwd']);
				if($uc_login_result == false){
					//$this->redirectPath("error","",$this->objucenter->error);//该用户被锁定，无法登录!
					$this->showMessage($this->objucenter->error,$this->refer_url,1);//该用户被锁定，无法登录!
				}
			}

		}

		$user_info = $this->obj_user->getUserInfo(array("user_name"=>$this->_input['txt_username'],"user_password"=>substr(md5($this->_input['txt_pwd']),0,16),"user_state"=>1),"*");
		if ($user_info != null) {
			//修改最后一次登录时间
			$flag = $this->obj_user->modifyUser("",$user_info['user_id'],"last_login_time");
			if ($flag) {
				$_SESSION['userinfo']['user_id']   				= $user_info['user_id'];		//会员id
				$_SESSION['userinfo']['user_name'] 				= $user_info['user_name'];		//会员名称
				$_SESSION['userinfo']['user_email'] 			= $user_info['user_email'];		//会员email
				$_SESSION['userinfo']['user_grade_name'] 		= $user_info['grade_name']==''?$this->_lang['login_grade_name']:$user_info['grade_name'];		//会员等级
				$_SESSION['userinfo']['user_grade_discount'] 	= $user_info['grade_discount'];	//会员折扣

				/*得到登录的来源地址*/
				if(!empty($this->_input['nc_refresh']) and strstr(trim($this->_input['nc_refresh']),$this->_configinfo['websit']['site_url'])) {
					$refresh_url	= trim($this->_input['nc_refresh']);
				} else {
					$refresh_url	= $this->_configinfo['websit']['site_url'];
				}

				/*ucenter会员登录部分*/
				if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
					if(file_exists(BasePath."/uc_client/data/config.php")) {
						include_once(BasePath."/uc_client/data/config.php");
					}
					if(API_SYNLOGIN == '1') {
						/*将用户的session值写入cookie*/
						Common::nc_uc_cookie_set('login');
						$this->objucenter->login($this->objucenter->exist_uid, $refresh_url);
					}
				}

				$this->showMessage($this->_lang['login_succ'],$refresh_url,1);
			}
			else {
				$this->showMessage($this->_lang['login_error'],$this->_configinfo['websit']['site_url']."/index.php",1);
			}
		}
		else {
			$this->showMessage($this->_lang['login_error'],$this->_configinfo['websit']['site_url']."/index.php",1);
		}
	}
	/**
	 * 会员退出
	 *
	 */
	private function loginOut(){
		$_SESSION["userinfo"] = array();
		session_unregister(userinfo);
		/*得到登录的来源地址*/
		if(!empty($_SERVER['HTTP_REFERER']) and strstr($_SERVER['HTTP_REFERER'],$this->_configinfo['websit']['site_url']) and $this->_input['back_url'] != 'index') {
			$refresh_url	= $_SERVER['HTTP_REFERER'];
		} else {
			$refresh_url	= $this->_configinfo['websit']['site_url'];
		}

		//ucenter会员退出
		if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
			if(file_exists(BasePath."/uc_client/data/config.php")) {
				include_once(BasePath."/uc_client/data/config.php");
			}
			if(API_SYNLOGOUT == '1') {
				/*将用户的session从cookie中取消*/
				Common::nc_uc_cookie_set('login_out');

				$this->objucenter->logout($refresh_url);
			}
		}

		$this->showMessage($this->_lang['login_out_succ'],$refresh_url,1);
	}
	/**
	 * 登录页面
	 *
	 */
	private function loginPage(){
		/*添加验证信息*/
		$this->output('seride_form',$this->obj_seride->seride_form());
		
		$this->showpage("login");
	}
	/**
	 * 忘记密码页面
	 *
	 */
	private function forgetPasswd() {
		$this->showpage('forgetpass');
	}
	/**
	 * 找回密码操作
	 *
	 */
	private function getPasswd() {
		$input_param['user_name']	= trim($this->_input['user_name']);
		$input_param['user_email']	= trim($this->_input['user_email']);

		$user_state		= $this->obj_user->getUserInfo($input_param);
		if(!$user_state) {
			$this->showMessage($this->_lang['forget_error'],$_SERVER['HTTP_REFERER'],1);
		}

		$new_passwd		= substr(md5('shopnc'.time()),0,10);
		$this->obj_user->modifyUser(array('txt_user_password'=>$new_passwd),$user_state['user_id'],'pwd');
		/*发送邮件*/
		Common::shopnc_send_mail($input_param['user_email'],$this->_lang['forget_passwd_modify'],$this->_lang['forget_new_passwd'].$this->_configinfo['websit']['site_name'].$this->_lang['forget_new_passwd1'].$new_passwd);

		$this->showMessage($this->_lang['forget_passwd_msg'],$this->_configinfo['websit']['site_url'],1);
	}
}
$user = new ShowUser();
$user->main();
unset($user);
?>