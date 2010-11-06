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
 * FILE_NAME : index.php   FILE_PATH : \multishop\store\index.php
 * ....商铺首页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Fri Sep 14 15:21:19 CST 2007
 */

require_once("../global.inc.php");

class StoreIndex extends StoreFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 2级域名对象
	 *
	 * @var obj
	 */
	var $obj_domain;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 商品订单信息
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 商店信息
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 地区信息
	 *
	 * @var obj
	 */
	var $obj_area;

	function main(){
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
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
		 * 实例化商店类
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 实例化地区类
		 */
		if (!is_object($this->obj_area)){
			require_once("area.class.php");
			$this->obj_area = new AreaClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("store,store_control,shop");
		$this->check_shop();

		//如果是现有模板
		if($this->shop['templates'] == 0) {
			$this->_set_current_nav('index');
		}
		$this->judgeShopAvailabilityTime();

		switch($this->_input['action']){
			case "getQuickLinks":
				$this->_getQuickLinks();
				break;
			default:
		}
	}

	/**
	 * 判断店铺的有效期限   按店铺有效期限收费ontime
	 *
	 */
	function judgeShopAvailabilityTime()
	{
		//判断店铺使用时间
		if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
			$condition['id'] = $this->_input['userid'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			if (time() > $member_array['shop_availability_time']){//过期
				unset($condition,$member_array);
				$this->redirectPath("error",'',$this->_lang['langSetShopOverdue']);
			}
		}
		//添加标示 判断是否是预览店铺
		if($this->_input['templates_show']!='')
		{
			$this->shop['templates'] =$this->_input['templates_show'];
		}
		//判断模板形式
		if ($this->shop['templates'] == '0' || $this->_input['templates_show']=='0'){//现有模板
			//更新到期团购商品订单状态

			$this->obj_product_order->updateProductOrderInCondition();
			//更新到期商品状态
			$this->obj_product->updateProductInCondition();
			/**
			 * 宝贝查询条件
			 */
			$obj_condition['key'] = $this->_input['keyword'];
			$obj_condition['keygenre'] = $this->_input['searchtype'];
			$obj_condition['member'] = $this->_input['userid'];
			$obj_condition['p_class_id'] = $this->_input['classid'];
			switch ($this->_input['list']){
				case "new":
					break;
				case "end":
					break;
				default:
					break;
			}
			//商品状态
			$obj_condition['state'] = 1;
			/**
			 * 按价格排序
			 */
			if($this->_input['price'] == "down"){
				$obj_condition['order'] = 2;
				$obj_condition['sorttype'] = 0;
			}elseif($this->_input['price'] == "up"){
				$obj_condition['order'] = 2;
				$obj_condition['sorttype'] = 1;
			}
			//商铺所有的商品
			$this->obj_page->pagebarnum(12);
			$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
			$page_list = $this->obj_page->show(2);
			//判断商品是否使用静态链接
			$product_array = $this->obj_product->checkProductIfHtml($product_array,$this->_configinfo['productinfo']['ifhtml']);
			//对商品图片进行缩放
			$product_array = $this->obj_product->productPicRatio($product_array,'p_pic',"100");
			if(is_array($product_array)) {
				for($i=0;$i<count($product_array);$i++){
					//剩余时间
					$left_time = $product_array[$i]['p_end_time'] - time();
					$product_array[$i]['left_days'] = intval($left_time / (24*60*60));
					$product_array[$i]['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
					$product_array[$i]['left_minutes'] = intval((($left_time % (60*60))) / 60);
					//切商品名
					$product_array[$i]['p_short_name'] = Char_class::cut_str($product_array[$i]['p_name'],10,0,$this->_configinfo['websit']['ncharset']);
				}
			}
			//商品地址 开启二级域名的情况
			if ($this->_configinfo['subdomain']['ifsubdomain'] == 1){
				foreach ($product_array as $v => $k){
					$product_array[$v]['html_url'] = str_replace('..',$this->_configinfo['websit']['site_url'],$v['html_url']);
				}
			}
			//插件
			$this->get_app();
			/**
			 * 页面输出
			 */
			$this->output('product_array',$product_array);//输出商铺所有的商品
			$this->output('product_count',$member_array['sell_product_count']);
			$this->output("page_list", $page_list);
			$this->output('condition',$this->_input);
			$this->showpage("store_index.default");
		}else {//自定义模板
			$this->_get_diy_style();
			//输出内容
			$this->output('title_message',$this->shop['shop_name']);
			$this->output('Meta_keyword',$this->shop['sale_range']);
			$this->output('Meta_desc',$this->shop['sale_range']);
			$this->showpage('store_index');
		}
	}

	/**
	 * 插件输出
	 */
	function get_app(){
		//插件
		$this->appModuleSignOutput('ntalker','ntalker_sign');
	}
}
$store = new StoreIndex();
$store->main();
unset($store);
?>