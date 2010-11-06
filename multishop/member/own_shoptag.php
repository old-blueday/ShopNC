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
 * FILE_NAME : own_shopproduct.php   FILE_PATH : \multishop\member\own_shoptag.php
 * ....商铺标签管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Jul 2 11:11:42 CST 2009
 */

require_once("../global.inc.php");

class OwnShopTagManage extends memberFrameWork{
	/**
	 * 商铺标签对象
	 *
	 * @var obj
	 */
	var $obj_shoptag;	
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
			
	function main() {
		/**
		 * 创建商铺标签对象
		 */
		if (!is_object($this->obj_shoptag)){
			require_once("shoptag.class.php");
			$this->obj_shoptag = new ShopTag();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}		
		/**
		 * 语言包
		 */
		$this->getlang("shop");
		$this->getlang("shoptag");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('my_shop','shop_manage','shop_tag');			
		
		switch ($this->_input['action']) {
			case 'del':
				$this->_del();
				break;
			case 'save_edit':
				$this->_save_edit();
				break;
			case 'edit':
				$this->_edit();
				break;
			case 'save_add':
				$this->_save_add();
				break;
			case 'add':
				$this->_add();
				break;
			default:
				$this->_list();
		}
	}
	/**
	 * 删除标签
	 *
	 */
	function _del() {
		if ($this->obj_shoptag->deleteTag($this->_input['id'],$_SESSION['s_shop']['id'])) {
			$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagDelSucc']);
		} else {
			$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagDelFalse']);
		}
	}
	/**
	 * 保存编辑标签
	 *
	 */
	function _save_edit() {
		//校验输入
		$error = $this->_check_input();	
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{	
			$this->_input['shop_id'] = $_SESSION['s_shop']['id'];
			if ($this->_input['tag_type'] == '1') {
				$this->_input['txtTagurl'] = "";
			} else {
				$this->_input['txtTagcontent'] = "";
			}
			//添加标签
			if ($this->obj_shoptag->updateTag($this->_input)) {
				$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagEditSucc']);
			} else {
				$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagEditFalse']);
			}
		}			
	}
	/**
	 * 编辑标签
	 *
	 */
	function _edit () {
		//获取标签信息
		$tag_array = $this->obj_shoptag->getOneTag($this->_input['id']);
		/**
		 * 页面输出
		 */
		$this->output("tag_array",$tag_array);
		$this->output("action","own_shoptag.php?action=save_edit");
		$this->showpage('own_shoptag.add');
	}
	/**
	 * 检验输入信息
	 *
	 * @return string
	 */
	function _check_input() {
		if ($this->_input['tag_type'] == '1') {	
			$tag_check_name = "txtTagcontent";
			$tag_check_msg = $this->_lang['langShopTagContentCheck'];
		} else {
			$tag_check_name = "txtTagurl";
			$tag_check_msg = $this->_lang['langShopTagLinkCheck'];			
		}
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtTagname"],"require"=>"true","message"=>$this->_lang['langShopTagNameCheck']),
		array("input"=>$this->_input["$tag_check_name"],"require"=>"true","message"=>$tag_check_msg)
		);	
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		return $error;				
	}
	/**
	 * 保存添加标签
	 *
	 */
	function _save_add () {
		//校验输入
		$error = $this->_check_input();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{	
			//统计标签
			$tag_num = $this->obj_shoptag->countTagNumber($_SESSION['s_shop']['id']);
			if ($tag_num >= 5) {
				$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagInputMaxFive']);
				exit();
			}
			$this->_input['shop_id'] = $_SESSION['s_shop']['id'];
			//添加标签
			if ($this->obj_shoptag->addTag($this->_input)) {
				$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagAddSucc']);
			} else {
				$this->redirectPath("succ",'member/own_shoptag.php',$this->_lang['langShopTagAddFalse']);
			}
		}	
	}
	/**
	 * 添加标签
	 *
	 */
	function _add(){
		$this->output("action","own_shoptag.php?action=save_add");	
		$this->showpage('own_shoptag.add');
	}
	/**
	 * 标签列表
	 *
	 */
	function _list () {
		$condition['shop_id'] = $_SESSION['s_shop']['id'];
		$condition['order_by'] = "tag_time desc";
		//获取标签列表
		$tag_array = $this->obj_shoptag->getTagList($condition,$obj_page); 
		//时间、状态、链接方式的处理
		if (is_array($tag_array)) {
			foreach ($tag_array as $k=>$v) {
				$tag_array[$k]['tag_time'] = date("Y-m-d",$tag_array[$k]['tag_time']);	
				if ($tag_array[$k]['tag_display'] == '0') {
					$tag_array[$k]['tag_display'] = $this->_lang['langShopTagBlock'];
				} else {
					$tag_array[$k]['tag_display'] = $this->_lang['langShopTagNone'];
				}
				if ($tag_array[$k]['tag_url'] != '') {
					$tag_array[$k]['tag_link'] = $this->_lang['langShopTagGoto'];
				} else {
					$tag_array[$k]['tag_link'] = $this->_lang['langShopTagMyShop'];
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output('tag_array',$tag_array); 	
		$this->showpage('own_shoptag.manage');
	}
}
$tag = new OwnShopTagManage();
$tag->main();
unset($tag);
?>