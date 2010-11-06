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
 * FILE_NAME : channel.php   FILE_PATH : E:\www\multishop\trunk\home\userinfo.php
 * ....用户信息页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Dec 18 10:08:14 CST 2008
 */
require ("../global.inc.php");

class ShowUserInfo extends CommonFrameWork {
	/**
	 * 店铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;

	function main(){
		if(intval($this->_input['userid']) <= 0){
			@header('Location: '.$this->_configinfo['websit']['site_url']);
			exit;
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
		 * 创建店铺类
		 */
		if (!is_object($this->obj_shop)){
			require_once ("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		$shop_array = $this->obj_shop->getOneShopByMemeberId($this->_input['userid']);
		/**
		 * 创建会员类
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		$member_array = $this->obj_member->getMemberInfo(array('id'=>$this->_input['userid']));
		$member_array['regist_time'] = date('Y-m-d H:i:s',$member_array['regist_time']);
		$member_array['last_login_time'] = date('Y-m-d H:i:s',$member_array['last_login_time']);
		/**
		 * 页面输出
		 */
		$this->output('shop_array',$shop_array);
		$this->output('member_array',$member_array);
		$this->showpage('userinfo');
	}
}
$userinfo = new ShowUserInfo();
$userinfo->main();
unset($userinfo);
 ?>