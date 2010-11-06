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
 * FILE_NAME : own_shopproduct.php   FILE_PATH : \multishop\member\own_shopproduct.php
 * ....商铺留言管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Sep 12 10:44:51 CST 2007
 */

require_once("../global.inc.php");

class OwnShopMessageManage extends memberFrameWork{
	/**
	 * 商铺留言对象
	 *
	 * @var obj
	 */
	var $obj_shopmessage;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	
	function main(){

		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_shopmessage)){
			require_once("shopmessage.class.php");
			$this->obj_shopmessage = new ShopMessageClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}

		/**
		 * 语言包
		 */
		$this->getlang("shop");
		$this->getlang("shopmessage");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('my_shop','shop_manage','shop_message');			

		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "del":
				$this->_delMessage();
				break;
			case "addsave":
				$this->_saveAddMessage();
				break;
			case "re":
				$this->_reMessage();
				break;
			case "add":
				$this->_addMessage();
				break;
			case "resave";
				$this->_saveReMessage();
				break;
			default:
				$this->_getMessageList();
		}
	}

	/**
	 * 得到留言列表
	 *
	 */
	function _getMessageList(){
		$this->obj_page->pagebarnum(20);    //每页20条记录
		$message_array = $this->obj_shopmessage->getMessage($this->obj_page,$_SESSION['s_shop']['id']);     //得到留言列表
		$this->obj_page->new_style = true;
		$pagelist = $this->obj_page->show('member');      //分页显示
		
		if (is_array($message_array)){
			foreach ($message_array as $k => $v){
				$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
			}
		}
		/**
		 * 页面输出
		 */
		$this->output('shop_message_array',$message_array);    //输出商铺留言列表
		$this->output('shop_message_pagelist',$pagelist);      //输出商铺留言分页
		$this->showpage('own_shopmessage.manage');
	}

	/**
	 * 删除留言
	 *
	 */
	function _delMessage(){
		$this->obj_shopmessage->deleteOperateMessage($this->_input['messageid'],$_SESSION['s_shop']['id']);
		$this->redirectPath("succ","member/own_shopmessage.php",$this->_lang['langShopMDelMessageOk']);//您删除留言成功
	}

	/**
	 * 保存店主发表留言
	 *
	 */
	function _saveAddMessage(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtMessage"],"require"=>"true","message"=>$this->_lang['langShopMFillInMessageContent'])//请填写留言内容
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			$this->_input['MemberName'] = $_SESSION['s_login']['name'];
			$this->_input['hideShopID'] = $_SESSION['s_shop']['id'];
			$this->obj_shopmessage->addMessage($this->_input);   //将留言内容存放到数据库中
			$this->redirectPath("succ","member/own_shopmessage.php",$this->_lang['langShopMAppearMessageOk']);//您发表留言成功
		}
	}

	/**
	 * 发表留言
	 *
	 */
	function _addMessage(){
		$this->showpage('own_shopmessage.add');
	}

	/**
	 * 回复留言
	 *
	 */
	function _reMessage(){
		//得到某条留言内容
		$message_array = $this->obj_shopmessage->getOneMessage($this->_input['messageid'],$_SESSION['s_shop']['id']);
		//输出留言内容
		$this->output('shop_message_array',$message_array);
		$this->showpage('own_shopmessage.re');
	}

	/**
	 * 保存回复留言
	 *
	 */
	function _saveReMessage(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtReMessage"],"require"=>"true","message"=>$this->_lang['langShopMFillInRestoreContent'])//请填写回复内容
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			$this->_input['hideShopID'] = $_SESSION['s_shop']['id'];
			$this->obj_shopmessage->reMessage($this->_input);   //将留言内容存放到数据库中
						
			$message_array = $this->obj_shopmessage->getOneMessage($this->_input['hideMessageID'],$_SESSION['s_shop']['id']);   //得到留言内容
			$message_array = $message_array[0];
			/**
			 * 网站提醒操作
			 */
			if (!is_object($this->obj_remind)){
				require_once('remind.class.php');
				$this->obj_remind = new RemindClass();
			}
			$shop_array = $this->storeBaseInfo();    //店铺基本信息
			$value_array = array();
			$value_array['question'] = $message_array['message_content'];
			$value_array['messagetime'] = date('Y-m-d',$message_array['message_time']);
			$value_array['mastername'] = $_SESSION['s_login']['name'];
			$value_array['reply'] = $message_array['message_recontent'];
			$value_array['username'] = $message_array['member_name'];
			$value_array['shopname'] = $shop_array['shop_name'];
			$this->obj_remind->setMessageOrMail('buyer_message_seller_shop_answer','shopreply',$value_array,$message_array['member_name'],$this->_configinfo);
			
			$this->redirectPath("succ","member/own_shopmessage.php",$this->_lang['langShopMRestoreMessageOk']);//您回复留言成功
		}
	}
}
$message = new OwnShopMessageManage();
$message->main();
unset($message);
?>