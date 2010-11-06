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
 * FILE_NAME : product.php   FILE_PATH : /var/www/multishop/trunk/store/product.php
 * ....商铺商品列表
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Sat Jun 21 14:18:38 CST 2008
 */

require_once("../global.inc.php");

class StoreProductClass extends StoreFrameWork{
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 2级域名对象
	 *
	 * @var obj
	 */
	var $obj_domain;
	/**
	 * 商品订单信息
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 店铺信息
	 *
	 * @var obj
	 */
	var $obj_shop;

	function main(){
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 初始化域名解析类
		 */
		if (!is_object($this->obj_domain)){
			require_once("domain.class.php");
			$this->obj_domain = new Domain();
		}
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 实例化店铺类
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("store");
		/**
		 * 语言包
		 */
		$this->getlang("store,store_control");

		//获取店铺信息 $this->shop
		$this->check_shop();

		$this->_list();
	}

	/**
	 * 商品列表显示
	 */
	function _list(){
		//更新到期团购商品订单状态
		$group_product_order_tobe_end_array = $this->obj_product_order->updateProductOrderInCondition();
		//更新到期商品状态
		$product_tobe_end_array = $this->obj_product->updateProductInCondition();
		//检索条件
		$obj_condition['key'] = trim($this->_input['keyword']);
		$obj_condition['keygenre'] = $this->_input['searchtype'];
		$obj_condition['member'] = $this->_input['userid'];
		$obj_condition['p_class_id'] = $this->_input['classid'];
		//推荐商品
		if ($this->_input['recommended'] == 1){
			$obj_condition['store_recommended'] = $this->_input['recommended'];
			//给页面赋推荐商品的标识
			$this->output('recommended',1);
		}
		switch ($this->_input['list']){
			case "end":
				$obj_condition['order'] = 1;
				$obj_condition['sorttype'] = 1;
				$obj_condition['state'] = 1;
				break;
			case "new":
				$obj_condition['order'] = 3;
				$obj_condition['state'] = 1;
				break;
			default:
				$obj_condition['order'] = 1;
				$obj_condition['sorttype'] = 1;
				$obj_condition['state'] = 1;
				break;
		}
		//按价格排序
		if($this->_input['price'] == "down"){
			$obj_condition['order'] = 2;
			$obj_condition['sorttype'] = 0;
		}elseif($this->_input['price'] == "up"){
			$obj_condition['order'] = 2;
			$obj_condition['sorttype'] = 1;
		}
		//商铺所有的商品
		$this->obj_page->pagebarnum(15);
		$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		$page_list = $this->obj_page->show(2);
		//商品剩余天数
		if(is_array($product_array)) {
			for($i=0;$i<count($product_array);$i++){
				$left_time = $product_array[$i]['p_end_time'] - time();
				$product_array[$i]['left_days'] = intval($left_time / (24*60*60));
				$product_array[$i]['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
				$product_array[$i]['left_minutes'] = intval((($left_time % (60*60))) / 60);
				$j = 0;
				//静态链接
				if ($v['html_url'] != ''){
					$product_array[$i]['html_url'] = $this->_configinfo['websit']['site_url'].str_replace('..','',$product_array[$i]['html_url']);
				}
				//切商品名
				$product_array[$i]['p_short_name'] = Char_class::cut_str($product_array[$i]['p_name'],10,0,$this->_configinfo['websit']['ncharset']);
			}
		}

		$this->output('member_id',$this->shop['member_id']);
		$this->output('shop_url',$this->shop['shop_link']);
		$this->output('page_list',$page_list);
		$this->output('product_array',$product_array);
		$this->output('view_type',$this->_input['view_type']);
		$this->output('shop_array',$this->shop);
		$this->output('condition',$this->_input);

		if ($this->shop['templates'] == '0'){//现有模板
			//设置导航css
			$this->_set_current_nav('index');
			/**
			 * 页面输出
			 */
			$this->showpage('store_product.default');
		}else{
			//自定义风格内容
			$this->_get_diy_style();
			/**
			 * 页面输出
			 */
			$this->showpage("store_product.list");
		}
	}
}

$product = new StoreProductClass();
$product->main();
unset($product);
?>