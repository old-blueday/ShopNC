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
 * FILE_NAME : shop.php   FILE_PATH : \multishop\home\shop.php
 * ....商铺首页
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Sep 26 11:22:48 CST 2007
 */

require ("../global.inc.php");

class ShowShopIndex extends CommonFrameWork{
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 商铺分类对象
	 *
	 * @var obj
	 */
	var $obj_shopcategory;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	
	function main(){
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_shopcategory)){
			require_once("shopcategory.class.php");
			$this->obj_shopcategory = new ShopCategoryClass();
		}
		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
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
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 语言包
		 */
		$this->getlang("shop");

		switch ($this->_input['action']){
			case "list":
				$this->_shoplist();
				break;
			case "search":
				$this->_searchshop();
				break;
			default:
				$this->_shoplist();
		}

	}

	/**
	 * 商铺列表
	 *
	 */
	function _shoplist(){
		$this->_input['order'] = 1;
		if ($this->_input['lang'] == 'zh'){
			$this->_input['keyword'] = Common::unescape($this->_input['keyword'],$this->_configinfo['websit']['ncharset']);
		}
		$this->_input['txtShopName'] = $this->_input['keyword'];
		
		/*店铺分类*/
		$category_array = $this->obj_shopcategory->getLevelCategory(2,'');
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
		unset($category_array);
		$this->_input['slcShopClass'] = $this->_input['searchcate']?$this->_input['searchcate']:$this->_input['slcShopClass'];//店铺列表条件使用
		if ($this->_input['slcShopClass'] !== ''){
			$select_class_info = $this->obj_shopcategory->getOneCategory($this->_input['slcShopClass']);
		}
		//商店状态
		$this->_input['ischeck'] = '1';//正常
		//会员状态
		$this->_input['member_state'] = '1';//正常
		$this->obj_page->pagebarnum(15);
		$shop_array = $this->obj_shop->getShopList($this->_input,$this->obj_page);
		//主营项目截取
		if (is_array($shop_array)) {
			foreach ($shop_array as $k => $v) {
				$shop_array[$k]['sale_range'] = Common::cutstr($v['sale_range'],30);
			}
		}		
		/**
		 * 设置分页样式
		 */
		$this->obj_page->pagesize = 5;	
		$this->obj_page->new_style = true;
		switch ($this->_configinfo['websit']['templatesname']){
			case 'default':
				$page_list = $this->obj_page->show(6);
				break;
			case 'orange':
				$this->obj_page->orange_style = true;
				$page_list = $this->obj_page->show(8);
				break;
			case 'green':
				$this->obj_page->green_style = true;
				$page_list = $this->obj_page->show(10);
				break;				
			default:
				$page_list = $this->obj_page->show(6);
				break;
		}
		
		//店铺数量
		$shop_count = count($this->obj_shop->getShopList($this->_input,$page));
		
		//搜索中的商品类别
		if (file_exists(BasePath."/cache/ProductClass_show.php")){
			require_once(BasePath."/cache/ProductClass_show.php");
			$ProductCateArray = $node_cache;
		}
		//地区内容
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				//取当前搜索的地区内容
				if ($this->_input['shop_area_id'] != '' && $v[0] == $this->_input['shop_area_id']){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$sel_area = $v;
				}
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);
		/**
		 * 页面输出
		 */		
		if ($select_class_info['class_name'] != ''){
			$this->output('title_message',$select_class_info['class_name'].'-');//title
		}
		$this->output('area_array',$area_array);
		$this->output('select_class_info',$select_class_info);
		$this->output('shop_category_array',$shop_category_array);
		$this->output('shop_array',$shop_array);
		$this->output('shop_count',$shop_count);
		$this->output('shop_condition',$this->_input);
		$this->output('page_list',$page_list);
		$this->output("search_cate", $ProductCateArray);
		$this->output('sel_area',$sel_area);
		$this->showpage('shop.list');
	}

	/**
	 * 搜索商铺
	 */
	function _searchshop(){
		$array = array('class_id'=>'', 'class_name'=>$this->_lang['langCAll'],'class_state'=>1);
		$category_array = $this->obj_shopcategory->getCategory("0",false);
		array_unshift($category_array,$array);
		$select_category = Common::showForm_Select("slcShopClass","","",Common::getSelectArray($category_array,array('class_id','class_name')),$shop_array['shop_class']);
		//地区内容
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);
		//循环数组赋键值
		$area_array_json=array();
		$sel_area_json=array();
		if (is_array($area_array)) {
			foreach ($area_array as $k => $v){
				$area_array_json[$k]['id'] = $v[0];
				$area_array_json[$k]['name'] = $v[2];
				$area_array_json[$k]['is_parent'] = $v[5];
				if($this->_configinfo['websit']['ncharset']=="GBK")
				{
					$area_array_json[$k]['name']=Common::nc_change_charset($area_array_json[$k]['name'],'gbk_to_utf8');
				}
			}
		}
		//实例化 JSON 数据交换格式转换类
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$area_array_json= $obj_json->encode($area_array_json);
		//转换为 JSON 数据交换格式 
		$area_array_json=addslashes($area_array_json);
		/**
		 * 页面输出
		 */
		$this->output('area_array',$area_array_json);
		$this->output("shop_select_category", $select_category);    //输出商铺分类以下拉框
		$this->output('InfoSelectorTarget',Common::getTargetMenu("search"));
		$this->showpage("shop.search");
	}
}
$shop_index = new ShowShopIndex();
$shop_index->main();
unset($shop_index);
?>