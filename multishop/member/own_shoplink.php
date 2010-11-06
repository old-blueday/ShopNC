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
 * FILE_NAME : own_shoplink.php   FILE_PATH : \multishop\member\own_shoplink.php
 * ....店铺友情连接
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Sep 11 16:40:39 CST 2007
 */

require_once("../global.inc.php");

class OwnShopLinkManage extends memberFrameWork{
	/**
	 * 商铺连接对象
	 *
	 * @var obj
	 */
	var $obj_shoplink;
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	
	function main(){
		/**
		 * 创建商铺连接对象
		 */
		if (!is_object($this->obj_shoplink)){
			require_once("shoplink.class.php");
			$this->obj_shoplink = new ShopLinkClass();
		}
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("shop");
		$this->getlang("shoplink");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('my_shop','shop_manage','firend_link');			

		$this->_input['hideShopId'] = $_SESSION["s_shop"]['id'];
		//判断店铺删除状态
		//$this->isShopDel();
		
		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "del":
				$this->_delLink();
				break;
			case "save":
				$this->_saveLink();
				break;
			default:
				$this->_showLink();
		}
	}

	/**
	 * 商铺友情连接查看
	 *
	 */
	function _showLink(){
		/**
		 * 得到商铺友情连接
		 */
		$condition['shop_id'] = $_SESSION['s_shop']['id'];
		$link_array = $this->obj_shoplink->getLink($condition,$page);
		$this->output("shop_link_array",   $link_array);    //输出店铺友情连接
		$this->showpage("own_shoplink.manage");   //显示页面
	}

	/**
	 * 保存商铺友情链接
	 *
	 */
	function _saveLink(){
		/**
		 * 验证注册信息
		 */
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtMemberName'],"require"=>"true","message"=>$this->_lang['langShopLFillInMemberName']));//请填写会员名称
		if ($error != "" ){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 根据会员名称得到店铺ID
			 */
			$member_array = $this->obj_member->getMemberList(array('member_name' => $this->_input['txtMemberName']),$page,"member_id");
			
			$this->_input['txtLinkShop'] = $member_array[0]['member_id'];
			if ($this->obj_shop->isHaveShop($this->_input['txtLinkShop']) == false){
				$this->redirectPath("error","",$this->_lang['langShopLThisMemberHaveNotShop']);//此会员并不拥有商铺
			}else if ($this->_input['txtLinkShop'] == $_SESSION['s_login']['id']){
				$this->redirectPath("error","",$this->_lang['langShopLNotAddSelf']);//您不能加自己为友情连接
			}else if ($this->obj_shoplink->addLink($this->_input) == false){
				$this->redirectPath("error","",$this->_lang['langShopLMayAddThisMember']);//您已经加过此会员为友情连接了
			}else{
				$this->redirectPath("succ","member/own_shoplink.php",$this->_lang['langShopLAddThisMemberOk']);//您已经成功加会员为友情连接！
			}
		}
	}

	/**
	 * 删除一条或多条友情链接
	 *
	 */
	function _delLink(){
		$this->objvalidate->setValidate(array("input"=>$_SESSION['s_shop']['id'], "require"=>"true","validator"=>"Number","message"=>$this->_lang['langShopMemberIsNotShop']));
		$error = $this->objvalidate->validate();
		if ($error != ''){
			$this->redirectPath('error','',$error);
		}else {
			$result = $this->obj_shoplink->deleteOperateLink($this->_input["classid"],$_SESSION['s_shop']['id']);
			if ($result === true){
				$this->redirectPath("succ","member/own_shoplink.php",$this->_lang['langShopLDelOk']);
			}else {
				$this->redirectPath("error","member/own_shoplink.php",$this->_lang['errShopLDelFaild']);
			}
		}
	}

}
$link_manage = new OwnShopLinkManage();
$link_manage->main();
unset($link_manage);
?>