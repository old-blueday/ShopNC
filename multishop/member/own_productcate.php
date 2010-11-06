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
 * FILE_NAME : own_productcate.php   FILE_PATH : \multishop\member\own_productcate.php
 * ....商品类别管理文件
 * 
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Wed Aug 08 13:42:53 CST 2007
 */

require ("../global.inc.php");

class OwnProductCategoryManage extends memberFrameWork{

	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	var $objProductCate;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;

	/**
     * 根据参数进行商品类别的操作
     *
     * 
     */
	function main(){
		/**
		 * 加载语言包
		 */
		$this->getlang("productClass");
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->objProductCate)){
			require_once ("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}

		switch ($this->_input['action']){
			case "list":
				$this->_listcate();
				break;
			default:
				$this->_listcate();
				break;
		}

	}

	/**
     * 商品类别列表页面
     * ajax调用地址举例：/member/own_productcate.php?action=list&id=4
     */
	function _listcate(){
		$id = $this->_input['id'];//父ID
		$deep = 1;
		$ProductCateArray = $this->objProductCate->listClassDetail('');
		$return_string = "";
		if(is_array($ProductCateArray)){
			foreach ($ProductCateArray as $value){
				if ($id == $value[1]) {
					$return_string .= $value['id']."||".trim($value['name'])."||".$value[5]."|||";
				}
			}
		}

		echo $return_string;
	}

}
$product_cate_manage = new OwnProductCategoryManage();
$product_cate_manage->main();
unset($product_cate_manage);
?>