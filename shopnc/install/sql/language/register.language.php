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
 * FILE_NAME : register.language.php   FILE_PATH : \shopnc6\language\zh_cn\register.language.php
 * ....会员注册页面register.html中文语言包
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Jun 17 17:05:46 CST 2008
 */
	
	$language['register_user']        = "注册会员";
	$language['happy_buy']            = "准备好就来注册吧，祝您购物愉快！";
	$language['username']             = "用户名";
	$language['username_note']        = "可以由英文、汉字、数字组成，长度为2-20位";
	$language['username_useableness'] = "恭喜！该用户名可用。";
	$language['username_fall']        = "用户名不符合要求请重新输入";
	$language['pwd']                  = "密 码";
	$language['pwd_note']             = "可以由英文、数字组成，长度为6-20位字符，区分大小写";
	$language['pwd_affirm']           = "确认密码";
	$language['pwd_affirm_note']      = "请重新输入一遍密码确认";
	$language['email']                = "电子邮箱";
	$language['email_info']			  = "使用常用的电子邮箱进行注册，方便密码丢失后的找回";
	$language['identifying_code']     = "验证码";
	$language['read_and_agree']       = "已阅读并同意";
	$language['term_of_service']      = "服务条款";
	$language['langMClickReplacingCode']= "点击更换验证码";
	$language['cilck_register']       = "点 我 注 册";
	
	//错误信息
	$language['username_is_null']     = "用户名不能为空";
	$language['username_min']         = "用户名长度至少是2位";
	$language['username_max']         = "用户名长度最长是20位";
	$language['pwd_is_null']          = "密码不能为空";
	$language['pwd_min']              = "密码长度至少是6位";
	$language['pwd_max']              = "密码长度最长是20位";
	$language['affirm_is_null']       = "确认密码不能为空";
	$language['affirm_min']           = "确认密码长度至少是6位";
	$language['affirm_max']           = "确认密码长度最长是20位";
	$language['affirm_no_equal']      = "两次密码输入不一致";
	$language['email_is_null']        = "邮件地址不能为空";
	$language['email_error']          = "邮件格式非法";
	$language['code_is_null']         = "验证码不能为空";
	$language['username_use']         = "恭喜您，用户名可以使用";
	$language['exist_username']       = "用户名已被注册";
	$language['code_error']           = "验证码错误";
	$language['reg_succ']             = "注册成功";
	$language['login_succ']           = "登录成功";
	$language['login_error']          = "用户名或密码错误，请重新登录";
	$language['login_out_succ']       = "退出成功";
	
	/*找回密码*/
	$language['forget_get_passwd']	  = "找回忘记密码";
	$language['forget_usernmae']	  = "请输入注册时的用户名";
	$language['forget_email']	  	  = "请输入注册时的E-mail";
	$language['forget_submit']	  	  = "点我提交";
	
	/*提示信息*/
	$language['forget_error']		  = "填入的信息与原信息不符，请从新输入";
	$language['forget_passwd_modify'] = "您的密码修改成功";
	$language['forget_new_passwd'] 	  = "您在";
	$language['forget_new_passwd1']	  = "的新密码为：";
	$language['forget_passwd_msg']	  = "密码已经发入您的邮箱请注意查收";
	?>