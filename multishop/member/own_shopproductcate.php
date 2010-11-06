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
 * FILE_NAME : own_shopproductcate.php   FILE_PATH : \multishop\member\own_shopproductcate.php
 * ....商家管理宝贝分类
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Sep 11 12:42:43 CST 2007
 */

require_once("../global.inc.php");

class OwnProductCategoryManage extends memberFrameWork{
	/**
	 * 商铺宝贝分类对象
	 *
	 * @var obj
	 */
	var $obj_productcategory;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	
	function main(){

		/**
		 * 创建商铺宝贝分类对象
		 */
		if (!is_object($this->obj_productcategory)){
			require_once("shopproductcategory.class.php");
			$this->obj_productcategory = new ShopProductCategoryClass();
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
		$this->getlang("shopproduct");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('my_shop','shop_manage','baby_class');			
		
		$this->_input['hideShopId'] = $_SESSION["s_shop"]['id'];
		
		//判断店铺删除状态
		//$this->isShopDel();
		
		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "del":
				$this->_delCategory();
				break;
			case "save":
				$this->_saveCategory();
				break;
			case 'update':
				$this->_updateCategory();
				break;
			default:
				$this->_showCategory();
		}
	}
	
	/**
	 * 商铺宝贝分类
	 *
	 */
	function _showCategory(){
		/**
		 * 得到店铺宝贝分类
		 */
		$condition_shop_product_cate['shop_id'] = $_SESSION['s_shop']['id'];
		$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
		$product_category = $this->obj_productcategory->getCategory($condition_shop_product_cate,$page);
		//整理数组为多级
		$product_category = $this->obj_productcategory->_makeCategoryArray($product_category);
		
		//一级类别
		$sel_class = $this->_get_sel_class();
		/**
		 * 页面输出
		 */
		$this->output("sel_class",   $sel_class); 
		$this->output("shop_product_category_array",   $product_category);    //输出店铺宝贝分类
		$this->showpage("own_productcategory.manage");   //显示页面
	}
	
	/**
	 * 新增商铺宝贝分类
	 *
	 */
	function _saveCategory(){
		$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["hideShopId"],"require"=>"true","message"=>$this->_lang['langShopPNoMember']),
			array("input"=>$this->_input["txtCategory"],"require"=>"true","message"=>$this->_lang['langShopPEnterProClassName']),
			array("input"=>$this->_input["txtSort"],"require"=>"true",'validator'=>'Number',"message"=>$this->_input['errShopProCateSortIsNotNumber']),
		);
		$error = $this->objvalidate->validate();
		if ($error != ''){
			$this->redirectPath("error","",$error);
		}else {
			$value_array = array();
			$value_array['class_name'] = $this->_input['txtCategory'];
			$value_array['class_parent_id'] = $this->_input['class_parent_id']?$this->_input['class_parent_id']:'0';
			$value_array['class_pic'] = $this->_input['class_pic'];
			$value_array['class_if_open'] = $this->_input['class_if_open']?$this->_input['class_if_open']:'0';
			$value_array['class_sort'] = intval($this->_input['txtSort']);
			$value_array['shop_id'] = $this->_input["hideShopId"];
			
			$result = $this->obj_productcategory->_addProductCategory($value_array);
			
			if ($result !== true){
				$this->redirectPath("succ","member/own_shopproductcate.php",$this->_lang['errShopProCateAddIsFail']);
			}else {
				$this->redirectPath("succ","member/own_shopproductcate.php",$this->_lang['langShopPEnterProClassNameOk']);
			}
		}
	}
	
	/**
	 * 批量保存
	 */
	function _updateCategory(){
		//验证
		if (!empty($this->_input['txtCategory'])){
			foreach ($this->_input['txtCategory'] as $v){
				if (trim($v) == ''){
					$this->redirectPath("error","member/own_shopproductcate.php",$this->_lang['errShopProCateClassIsEmpty']);
				}
			}
		}else {
			$this->redirectPath("succ","member/own_shopproductcate.php",$this->_lang['errShopProCateClassIsEmpty']);
		}
		
		//更新
		foreach ($this->_input['txtCategory'] as $k => $v){
			$value_array = array();
			$value_array['class_id'] = $this->_input['class_id'][$k];
			$value_array['class_name'] = $v;
			$value_array['class_parent_id'] = $this->_input['class_parent_id'][$k]?$this->_input['class_parent_id'][$k]:'0';
			//如果父ID不是0，那么检查该ID是否有下级分类，如果有，则都更新到这个父ID下
			if ($value_array['class_parent_id'] != '0'){
				foreach ($this->_input['txtCategory'] as $k2 => $v2){
					if ($this->_input['class_parent_id'][$k2] == $value_array['class_id']){
						$this->_input['class_parent_id'][$k2] = $value_array['class_parent_id'];
					}
				}
			}
			$value_array['class_pic'] = $this->_input['class_pic'][$k];
			if ($this->_input['class_if_open'][$k] == '0'){
				$value_array['class_if_open'] = '0';
			}else {
				$value_array['class_if_open'] = '1';//1闭合子类别显示
			}
			$value_array['class_sort'] = intval($this->_input['txtSort'][$k]);
			
			$this->obj_productcategory->_updateProductCategory($value_array);
			unset($value_array);
		}
		
		$this->redirectPath("succ","member/own_shopproductcate.php",$this->_lang['langShopProCateAddIsSucc']);
	}
	
	
	/**
	 * 删除店铺宝贝分类
	 *
	 */
	function _delCategory(){
		//验证
		$this->_check_class(intval($this->_input['classid']));
		
		/**
		 * 创建商品对象
		 */
		require_once("product.class.php");
		$obj_product = new ProductClass();
		/*取被删除的商品列表，清除门店类别ID*/
		$condition['p_class_id'] = intval($this->_input['classid']);
		$product_array = $obj_product->getProductList($condition,$page);
		if (is_array($product_array)) {
			foreach ($product_array as $k => $v){
				$input['shoppcid'] = 0;
				$input['chboxPid'] = $v['p_code'];
				$obj_product->updateShopProductCategory($input);
			}
		}
		$this->obj_productcategory->delOperateCategory(intval($this->_input['classid']));
		$this->redirectPath("succ","member/own_shopproductcate.php",$this->_lang['langShopPDelProClassNameOk']);
	}
	
	
	/**
	 * 取一级分类
	 */
	function _get_sel_class(){
		//取一级分类
		$condition['shop_id'] = $_SESSION['s_shop']['id'];
		$condition['class_parent_id'] = '0';
		$condition['order_by'] = ' shop_product_class.class_sort asc,shop_product_class.class_id asc';
		$sel_class = $this->obj_productcategory->getCategory($condition,$page);
		return $sel_class;
	}
	
	/**
	 * 验证该分类是否是该会员的		验证是否有下级分类，如果有，也不能删除
	 */
	function _check_class($class_id){
		//验证 类别和会员是否相同
		$class_array = $this->obj_productcategory->getOneCategory(intval($class_id));
		if ($class_array['shop_id'] != $_SESSION['s_shop']['id']){
			$this->redirectPath("succ","member/own_shopproductcate.php",$this->_input['errShopProCateNotBelongYou']);
		}
		unset($class_array);
		//验证分类是否有下级
		$condition['shop_id'] = $_SESSION['s_shop']['id'];
		$condition['class_parent_id'] = intval($class_id);
		$class_array = $this->obj_productcategory->getCategory($condition,$page);
		if (!empty($class_array)){
			$this->redirectPath("succ","member/own_shopproductcate.php",$this->_lang['errShopProCateHaveChild']);
		}
		return true;
	}
}

$category_manage = new OwnProductCategoryManage();
$category_manage->main();
unset($category_manage);
?>