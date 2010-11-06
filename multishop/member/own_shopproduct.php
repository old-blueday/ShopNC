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
 * ....商家管理宝贝分类
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Sep 11 12:42:43 CST 2007
 */

require_once("../global.inc.php");

class OwnShopProduct extends memberFrameWork{
	/**
	 * 商铺宝贝分类对象
	 *
	 * @var obj
	 */
	var $obj_product;
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
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	
	function main(){
		//判断店铺删除状态
		//$this->isShopDel();
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
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
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 语言包
		 */
		$this->getlang("shop");
		$this->getlang("shopproduct,product");
		
		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "list":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('my_shop','shop_manage','baby_class');					
				$this->_listproduct();
				break;
			case "move":
				$this->_moveproduct();
				break;
			case "recommended_list":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('my_shop','shop_manage','commend_baby');					
				$this->_listrecommendedproduct();
				break;
			case "recommended":
				$recommended = '1';
				$this->_updateproductrecommended($recommended);
				break;
			case "cancel_recommended":
				$recommended = '0';
				$this->_updateproductrecommended($recommended);
				break;
			default:
				$this->_listproduct();
		}

	}

	/**
	 * 商铺宝贝分类
	 *
	 */
	function _listproduct(){
		//得到店铺宝贝分类
		$product_category = $this->get_shop_product_category();
		//指定分类内容
		if (intval($this->_input['classid']) > 0){
			$class_array = $this->obj_productcategory->getOneCategory(intval($this->_input['classid']));
		}
		//更新订单和商品状态
		$this->updateProductAndOrderState();
		//商品列表，数组 product_array page_list
		$product_array = $this->get_product();
		/**
		 * 页面输出
		 */
		$this->output("page_list", $product_array['page_list']);
		$this->output("shop_product_array", $product_array['product_array']);
		$this->output("shop_product_category_array", $product_category);
		$this->output("classid", $this->_input['classid']);
		$this->output("class_name", $class_array['class_name']);
		$this->showpage("own_shopproduct.list");   //显示页面
	}

	/**
	 * 保存商铺宝贝分类
	 *
	 */
	function _moveproduct(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['langShopPProductNoSelected']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			if ($this->_input['shoppcid'] == '') {
				$this->_input['shoppcid'] = '0';
			}
			$this->obj_product->updateShopProductCategory($this->_input); //把信息放入数据库中
			$this->redirectPath("succ","member/own_shopproduct.php?action=list&classid=".$this->_input['shoppcid'],$this->_lang['langShopPBabyClassMoveOk']);
		}
	}

	/**
	 * 商铺宝贝推荐列表
	 *
	 */
	function _listrecommendedproduct(){
		//更新订单和商品状态
		$this->updateProductAndOrderState();
		//商品列表，数组 product_array page_list
		$product_array = $this->get_product();
		//店铺推荐商品
		$product_store_recommended = $this->get_recommended_product();
		$product_array['product_array'] = $this->getProductUrl($product_array['product_array']);
		$product_store_recommended = $this->getProductUrl($product_store_recommended);
		/**
		 * 页面输出
		 */
		$this->output("page_list", $product_array['page_list']);
		$this->output("shop_product_array", $product_array['product_array']);
		$this->output("shop_recommended_product_array", $product_store_recommended);
		$this->showpage("own_shopproduct.recommended");
	}
	/**
	 * 获取不同类型商品的链接地址
	 *
	 * @param unknown_type $arr
	 * @return unknown
	 */
	function getProductUrl($arr) {
		if (is_array($arr)) {
			foreach ($arr as $k => $v) {
				$site_url = "";
				$site_url = $this->_configinfo['websit']['site_url'];
				switch ($v['p_sell_type']) {
					case '0':
						$arr[$k]['product_url'] = $site_url . "/home/product_auction.php?action=view&p_code=" . $v['p_code'];
						break;
					case '1':
						$arr[$k]['product_url'] = $site_url . "/home/product_fixprice.php?action=view&p_code=" . $v['p_code'];
						break;	
					case '2':
						$arr[$k]['product_url'] = $site_url . "/home/product_group.php?action=view&p_code=" . $v['p_code'];
						break;		
					case '3':
						$arr[$k]['product_url'] = $site_url . "/home/product_countdown.php?action=view&pid=" . $v['p_code'];
						break;																	
				}				
			}
		}	
		return $arr;	
	}

	/**
	 * 更新商品店铺推荐状态
	 *
	 * @param unknown_type $recommended
	 */
	function _updateproductrecommended($recommended){
		$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['langShopPProductCodeEmpty'])
		);
		$error = $this->objvalidate->validate();
		if($error != ''){
			$this->redirectPath("error","own_shopproduct.php?action=recommended_list", $error);
		}else {
			if(is_array($this->_input["chboxPid"])){
				$condition['pcodes'] = $this->_input["chboxPid"];
			}else{
				$condition['p_code'] = $this->_input["chboxPid"];
			}
			$condition['member'] = $_SESSION['s_login']['id'];
			
			$product_array = $this->obj_product->getProductList($condition,$page);
			
			if (is_array($product_array)){
					$this->_input["chboxPid"] = array();
					foreach ($product_array as $k => $v){
						$this->_input["chboxPid"][] = $v['p_code'];
					}
			}
			$recommended_count = count($product_array);
			if($recommended_count == 0){
				$this->redirectPath("error","own_shopproduct.php?action=recommended_list", $error);
			}
			$this->_input['recommended'] = $recommended;
			$result = $this->obj_product->updateProductShopRecommended($this->_input);
			if($recommended == '1'){
				$info = $this->_lang['langShopPBabyCommendOk'];
			}else{
				$info = $this->_lang['langShopPBabyCancelCommend'];
			}
			$this->redirectPath("succ","member/own_shopproduct.php?action=recommended_list", $info);
		}
	}
	
	/**
	 * 取商品类别 二维
	 */
	function get_shop_product_category(){
		$condition_shop_product_cate['shop_id'] = $_SESSION['s_shop']['id'];
		$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
		$product_category = $this->obj_productcategory->getCategory($condition_shop_product_cate,$page);
		//整理数组为多级
		$product_category = $this->obj_productcategory->_makeCategoryArray($product_category);
		return $product_category;
	}
	
	/**
	 * 更新订单和商品状态
	 */
	function updateProductAndOrderState(){
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		//更新到期团购商品订单状态
		$this->obj_product_order->updateProductOrderInCondition();
		//更新到期商品状态
		$this->obj_product->updateProductInCondition();
		return true;
	}
	
	/**
	 * 商品列表
	 */
	function get_product(){
		//取得查询参数
		$obj_condition['p_class_id'] = $this->_input['classid'];
		$obj_condition['member'] = $_SESSION['s_login']['id'];
		//取得产品列表
		$this->obj_page->pagebarnum(10);
		$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		//判断是否使用静态链接
		$product_array = $this->obj_product->checkProductIfHtml($product_array,$this->_configinfo['productinfo']['ifhtml']);
		//判断商品是否存在图片
		$product_array = $this->obj_product->productPicRatio($product_array,'p_pic',100);
		//剩余时间
		for($i=0;$i<count($product_array);$i++){
			$left_time = $product_array[$i]['p_end_time'] - time();
			$product_array[$i]['left_days'] = intval($left_time / (24*60*60));
			$product_array[$i]['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
			$product_array[$i]['left_minutes'] = intval((($left_time % (60*60))) / 60);
			$product_array[$i]['p_add_time_ymd'] = date("Y-m-d",$product_array[$i]['p_add_time']);
			switch ($product_array[$i]['p_sell_type']){
				case "0":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langPauction'];
					$product_array[$i]['p_sold_num'] = $product_array[$i]['p_bid_num'];
					break;
				case "1":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langProductPrice'];
					break;
				case "2":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langPcamel'];
					break;
				case "3":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langPcountdown'];
					break;					
				default:
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langProductPrice'];
					break;
			}			
		}
		
		return array(
			'product_array' => $product_array,
			'page_list' => $page_list 
		);
	}
	
	/**
	 * 推荐商品
	 */
	function get_recommended_product(){
		//店铺推荐商品
		$obj_recommended_condition['member'] = $_SESSION['s_login']['id'];
		$obj_recommended_condition['store_recommended'] = 1;
		$product_store_recommended = $this->obj_product->getProductList($obj_recommended_condition, $obj_recommended_page);
		//判断是否使用静态链接
		$product_store_recommended = $this->obj_product->checkProductIfHtml($product_store_recommended,$this->_configinfo['productinfo']['ifhtml']);
		//判断商品是否存在图片
		$product_store_recommended = $this->obj_product->productPicRatio($product_store_recommended,'p_pic',100);
		return $product_store_recommended;
	}
	
}

$shop_product_manage = new OwnShopProduct();
$shop_product_manage->main();
unset($shop_product_manage);
?>