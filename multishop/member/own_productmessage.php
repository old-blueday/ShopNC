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
 * FILE_NAME : own_productmessage.php   FILE_PATH : \multishop\member\own_productmessage.php
 * ....商品留言管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Oct 15 15:03:16 CST 2007
 */

require ("../global.inc.php");
class OwnProductMessage extends memberFrameWork{
	/**
	 * 留言对象
	 *
	 * @var obj
	 */
	var $obj_message;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
	
	function main(){
		/**
		 * 创建留言对象
		 */
		if (!is_object($this->obj_message)){
			require_once("productmessage.class.php");
			$this->obj_message = new ProductMessageClass();
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 语言包
		 */
		$this->getlang("productmessage");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('buyer','my_buyer','sale_revert');
		
		switch($this->_input['action']){
			case "buy":
				$this->_listMessage("buy");
				break;
			case "sale":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','buy_revert');
				
				$this->_listMessage("sale");
				break;
			case "re":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','buy_revert');
				
				$this->_reMessage();
				break;
			case "resave":
				$this->_resave();
				break;
			default:
				$this->_listMessage();
		}
	}
	
	/**
	 * 留言
	 *
	 */
	function _listMessage($genre = "sale"){
		$this->obj_page->pagebarnum(20);    //每页20条记录
		if ($genre == "sale"){//我是卖家，买家回复/留言
			$message_array = $this->obj_message->getProductMessage($this->obj_page,$_SESSION['s_login']['id'],false,"sale");
		}else if($genre == "buy"){//我是买家，卖家回复/留言
			$message_array = $this->obj_message->getProductMessage($this->obj_page,$_SESSION['s_login']['name'],false,"buy");
		}
		$this->obj_page->new_style = true;
		$pagelist = $this->obj_page->show('member');      //分页显示
		
		if (is_array($message_array)){
			foreach ($message_array as $k => $v){
				$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
				//当我是买家，取卖家会员信息
				if ($genre == "buy" && $v['seller_name'] == ''){
					$condition['id'] = $v['member_id'];//卖家ID
					$member_array = $this->obj_member->getMemberInfo($condition,'login_name');
					$message_array[$k]['seller_name'] = $member_array['login_name'];
					unset($condition,$member_array);
				}
				/**
				 * 商品链接判断
				 */
				switch ($v['p_sell_type']) {
					case '0':
						$message_array[$k]['p_href'] = $this->_configinfo['websit']['site_url'] . "/home/product_auction.php?action=view&p_code=" . $v['product_code'];
						break;
					case '1':
						$message_array[$k]['p_href'] = $this->_configinfo['websit']['site_url'] . "/home/product_fixprice.php?action=view&p_code=" . $v['product_code'];
						break;	
					case '2':
						$message_array[$k]['p_href'] = $this->_configinfo['websit']['site_url'] . "/home/product_group.php?action=view&p_code=" . $v['product_code'];
						break;		
					case '3':
						$message_array[$k]['p_href'] = $this->_configinfo['websit']['site_url'] . "/home/product_countdown.php?action=view&pid=" . $v['product_code'];
						break;															
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output('message_array',$message_array);    //输出留言列表
		$this->output('message_pagelist',$pagelist);      //输出留言分页
		$this->output('genre',$genre);      //留言类别
		if ($genre == "buy"){
			$this->showpage('own_productmessage.buy');
		}else {
			$this->showpage('own_productmessage.sell');
		}
	}
	
	/**
	 * 回复留言
	 */
	function _reMessage(){
		$message_array = $this->obj_message->getOneMessage($this->_input['id'],$_SESSION['s_login']['id']);    //得到某条留言内容
		$message_array['message_time'] = date("Y-m-d H:i",$message_array['message_time']);
		$this->output('message_array',$message_array[0]);   //输出留言内容
		$this->showpage('own_productmessage.re');
	}
	
	/**
	 * 保存回复内容
	 */
	function _resave(){
		/**
		 * 检验输入信息
		 */
		$this->obj_validate->validateparam = array(
			array("input"=>$this->_input["txtReMessage"],"require"=>"true","message"=>$this->_lang['errMakeRevertContent'])
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			$exist_array = array('messageid'=>$this->_input['hideMessageID'],'productid'=>$this->_input['hideproductID'],'memberid'=>$_SESSION['s_login']['id']);
			if ($this->obj_message->isExistMessage($exist_array)){
				//将留言内容存放到数据库中
				$this->obj_message->reMessage($this->_input); 
				/**
				 * 网站提醒操作
				 */
				if (!is_object($this->obj_remind)){
					require_once('remind.class.php');
					$this->obj_remind = new RemindClass();
				}
				/**
				 * 创建商品对象
				 */
				if (!is_object($this->obj_product)){
					require_once("product.class.php");
					$this->obj_product = new ProductClass();
				}
				//取商品信息
				$product_array = $this->obj_product->getProductRowById($this->_input['hideproductID']);
				if (!empty($product_array)){
					//留言信息
					$message_array = $this->obj_message->getOneMessage($this->_input['hideMessageID'],$_SESSION['s_login']['id']);
					$message_array = $message_array[0];
					//提醒操作
					$value_array = array();
					$value_array['username'] = $message_array['member_name'];
					$value_array['product_name'] = $product_array['p_name'];
					$this->obj_remind->setMessageOrMail('buyer_message_seller_product_answer','message_seller_product_answer',$value_array,$message_array['member_name'],$this->_configinfo);//我在宝贝上的留言被卖家回复时，请通知我
					$this->redirectPath("succ","member/own_productmessage.php?action=sale",$this->_lang['alertRevertGuestBookOk']);
				}else {
					$this->redirectPath("succ","member/own_productmessage.php?action=sale",$this->_lang['errProductMInfoIsEmpty']);
				}
			}else{
				$this->redirectPath("error","",$this->_lang['errGuestBookNonentity']);
			}
		}
	}
}
$productmessage = new OwnProductMessage();
$productmessage->main();
unset($productmessage);
?>