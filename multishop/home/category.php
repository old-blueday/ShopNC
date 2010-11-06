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
 * FILE_NAME : category.php   FILE_PATH : \multishop\home\category.php
 * ....商品类别管理文件
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Aug 08 13:42:53 CST 2007
 */

require ("../global.inc.php");

class ShowProductCateManage extends CommonFrameWork{
	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	var $objProductCate;
	/**
	 * 商铺分类对象
	 *
	 * @var obj
	 */
	var $obj_shop_category;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	
	/**
     * 根据参数进行商品类别的操作
     *
     * 
     */
	function main(){
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->objProductCate)){
			require_once ("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_shop_category)){
			require_once("shopcategory.class.php");
			$this->obj_shop_category = new ShopCategoryClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 加载语言包
		 */
		$this->getlang("productClass");
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		
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
     *
     */
	function _listcate(){		
		//搜索中的商品类别
		if (file_exists(BasePath."/cache/ProductClass_show.php")){
			require_once(BasePath."/cache/ProductClass_show.php");
			$ProductCateArray = $node_cache;
			if (is_array($node_cache)){
				foreach ($node_cache as $k => $v){
					if ($v[4] == '0') {
						$v['id'] = $v[0];
						$v['name'] = $v[2];
						$search_cate[] = $v;
					}
				}
			}
		}
		/**
		 * 取商店分类
		 */
		$category_array = $this->obj_shop_category->getLevelCategory(2,'');
		if (is_array($category_array)){
			foreach ($category_array as $k => $v){
				if ($v['parent_id'] == "0"){
					$num = count($shop_category_array);
					$shop_category_array[$num] = $v;
					foreach ($category_array as $k2 => $v2){
						if ($v['class_id'] == $v2['parent_id']){
							$shop_category_array[$num]['child'][] = $v2;
						}
					}
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output("search_cate", $ProductCateArray);
		$this->output("ProductCateArray", $ProductCateArray);
		$this->output("ShowShopCate", $this->_input['showsc']);
		$this->output("shop_category_array", $shop_category_array);
		$this->showpage("category.list");
	}
}
$product_cate = new ShowProductCateManage();
$product_cate->main();
unset($product_cate);
?>