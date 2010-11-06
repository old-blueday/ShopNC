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
 * FILE_NAME : message.php   FILE_PATH : \multishop\store\message.php
 * ....商铺留言显示
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Sat Sep 15 13:36:23 CST 2007
 */

require_once("../global.inc.php");

class StoreMessage extends StoreFrameWork{
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
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
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 商店对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	
	function main(){
		/**
		 * 创建商铺留言对象
		 */
		if (!is_object($this->obj_shopmessage)){
			require_once("shopmessage.class.php");
			$this->obj_shopmessage = new ShopMessageClass();
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 初始化店铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("store");
		
		/**
		 * 语言包
		 */
		$this->getlang("store,store_message,store_control");
		
		switch($this->_input['action']){
			case "new":
				$this->_addMessage();
				break;
			case "save":
				$this->_saveAddMessage();
				break;
			default:
				$this->_getMessageList();
		}
	}

	/**
	 * 留言列表
	 */
	function _getMessageList(){
		//获取店铺信息 $this->shop
		$this->check_shop();

		$this->obj_page->pagebarnum(20);
		$message_array = $this->obj_shopmessage->getMessage($this->obj_page,$this->shop['shop_id'],true);
		$pagelist = $this->obj_page->show(2);
		if (is_array($message_array)){
			foreach ($message_array as $k => $v){
				$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
			}
		}

		if ($this->shop['templates'] == '0'){//现有模板
			/**
			 * 模板输出
			 */
			$this->output('shop_message_array',$message_array);
			$this->output('shop_message_pagelist',$pagelist);
			$this->showpage("store_message.list_default");
		}else {
			//自定义风格内容
			$this->_get_diy_style();
			/**
			 * 页面输出
			 */
			$this->output('shop_message',$message_array);
			$this->output('page_list',$pagelist);
			$this->showpage("store_message.list");
		}
	}
	
	/**
	 * 发表留言
	 *
	 */
	function _addMessage(){
		$this->isMember();
		//获取店铺信息 $this->shop
		$this->check_shop();
		if ($this->shop['templates'] == '0'){//现有模板
			/**
			 * 页面输出
			 */
			$this->showpage('store_message.add_default');
		}else {
			//自定义风格内容
			$this->_get_diy_style();
			/**
			 * 页面输出
			 */
			$this->output('shop_message',$message_array);
			$this->output('page_list',$pagelist);
			$this->showpage("store_message.add");
		}
	}
	
	/**
	 * 保存留言
	 *
	 */
	function _saveAddMessage(){
		$this->isMember();
		//获取店铺信息 $this->shop
		$this->check_shop();
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtMessage"],"require"=>"true","message"=>$this->_lang['errSMessageMakeLeaveWord']),
		array("input"=>strtoupper($this->_input['code']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['errSMessageInputCode'])
		); 
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","","$error");
		}else{
			/**
			 * 网站提醒操作
			 */
			if (!is_object($this->obj_remind)){
				require_once('remind.class.php');
				$this->obj_remind = new RemindClass();
			}
			
			$condition['id'] = $this->_input['userid'];
			$member_array = $this->obj_member->getMemberInfo($condition);
	
			$value_array = array();
			$value_array['username'] = $member_array['login_name'];
			$this->obj_remind->setMessageOrMail('sale_message_shop','message_shop',$value_array,$member_array['login_name'],$this->_configinfo);

			$this->_input['MemberName'] = $_SESSION['s_login']['name'];
			$this->_input['hideShopID'] = $this->shop['shop_id'];
			$this->obj_shopmessage->addMessage($this->_input);   //将留言内容存放到数据库中
			$this->redirectPath("succ","store/message.php?userid=" . $this->_input['userid'],$this->_lang['langSMessageLeaveWordSucceed']);//您已经成功给店家留言
		}
	}
	
	/**
	 * 输出店铺商品类别
	 */
	function _output_shop_product_category(){
		/**
		 * 页面输出
		 */
		$this->output('category_array',$this->_get_shop_category());
	}
	/**
	 * 输出店铺友情链接
	 */
	function _output_shop_link(){
		$this->output('link_array',$this->_get_shop_link());
	}
	/**
	 * 地区内容
	 */
	function _output_shop_area(){
		$this->output('sel_area',$this->_get_area()); 
	}
	/**
	 * 会员内容
	 */
	function _output_member(){
		//会员
		$condition['id'] = $this->_input['userid'];
		$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
		/**
		 * 页面输出
		 */
		$this->output('member_array',$member_array); 
	}
	
}
$message = new StoreMessage();
$message->main();
unset($message);
?>