<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想分销王系统 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : shop_search.php D:\root\shopnc6_jh\shop_search.php
* 聚合商品与店铺搜索
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:53:32 CST 2009
*/
require("shop.global.inc.php");
class ShowShopSearch extends ShopCommonFrameWork {
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	private $obj_product;

	/**
	 * 商品对象
	 * 
	 * @var obj
	 */
	private $obj_goods;

	/**
	 * 网店对象
	 * 
	 * @var obj
	 */	
	private $obj_shop_user;

	public function main() {
		if(!is_object($this->obj_product)) {
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_goods)){
			require_once('goods.class.php');
			$this->obj_goods = new GoodsClass();
		}
		/**
		 * 创建网店对象
		 */
		if (!is_object($this->obj_shop_user)){
			require_once("shopUser.class.php");
			$this->obj_shop_user = new ShopUserClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("templates/new_shops");
		/**
		 * 语言包
		 */
		$this->getlang("shop_html,shop_list,shop_common");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'search_adv':
				$this->showHeightSerach();		//高级搜索页面
				break;
			default:
				$this->productSearchList();		//搜索商品结果列表
		}
	}
	/**
	 * 商品搜索结果列表
	 *
	 */
	private function productSearchList() {
		$input_param	= array();
		$input_param['txt_start_price']	= intval($this->_input['txt_start_price']);			//开始价格
		$input_param['txt_end_price']	= intval($this->_input['txt_end_price']);			//结束价格
		$input_param['txt_class_top_id']= intval($this->_input['txt_class_top_id']);		//店铺分类
		$input_param['txt_address']		= trim($this->_input['txtProvince']);				//商品在地
		$input_param['state']			= 1;												//发布状态
		$input_param['shop_goods_state']= 1;

		/*店铺下拉列表*/
		include(BasePath."/share/shop_class_show.php");
		$parent_array = array();
		foreach ($node_cache as $node) {
			if ($node['parentId']==0&&$node['iffb']==1) {
				$parent_array[]=$node;
			}
		}
		$i=0;
		$node_array = array();
		foreach ($parent_array as $parent) {
			$node_array[$i]=$parent;
			foreach ($node_cache as $node) {
				if ($parent['id']==$node['parentId']&&$node['iffb']==1) {
					$node_array[$i]['sub_array'][]=$node;
				}
			}
			$i++;
		}
		$this->output('node_array',$node_array);

		/*热门店铺*/
		$hot_shops_array	= $this->obj_shop_user->getShopListType(array('shop_type'=>'hot_shop'),5);
		$this->output('hot_shops_array',$hot_shops_array);

		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		if (in_array($this->_input['num'],array(12,24,36))){
			$obj_page->pagebarnum(intval($this->_input['num']));	//每页显示商品数
		}else{
			$obj_page->pagebarnum(12);	//每页显示商品数

		}
		$obj_page->pagesize=3;

		if ($this->_configinfo['websit']['pay_receive_type'] == 1){		//搜索子店发布的商品
			$input_param['goods_name']		= trim($this->_input['txt_keywords']);				//关键字
			if ($this->_input['sort'] == 'pricedesc'){
				$order_array = array('goods_pricedesc desc','');
			}else{
				$order_array = array('goods_pricedesc','');
			}
			$search_array	= $this->obj_product->searchShopGoods($input_param,$obj_page,'*');
		}else{														//搜索子店领取的主店商品
			if ($this->_input['sort'] == 'pricedesc'){
				$order_array = array('','goods_pricedesc desc');
			}else{
				$order_array = array('','goods_pricedesc');
			}

			$input_param['shop_goods_name']		= trim($this->_input['txt_keywords']);			//关键字
			$search_array = $this->obj_goods->getChooseGoodsList($input_param,$obj_page,$order_array);
		}

		$search_page = $obj_page->show(8);
		$this->output('search_count',$obj_page->total_num);
		$this->output('product_class_page',$search_page);
		$this->output('product_array',$search_array);
		$this->output('query_string',$_SERVER["QUERY_STRING"]);

		$this->shopshowpage("product_search_list");
	}
	/**
	 * 高级搜索页面
	 *
	 */
	private function showHeightSerach() {

		/*店铺分类*/
		include(BasePath."/share/shop_class_show.php");
		$parent_array = array();
		foreach ($node_cache as $node) {
			if ($node['parentId']==0&&$node['iffb']==1) {
				$parent_array[]=$node;
			}
		}
		$i=0;
		$node_array = array();
		foreach ($parent_array as $parent) {
			$node_array[$i]=$parent;
			foreach ($node_cache as $node) {
				if ($parent['id']==$node['parentId']&&$node['iffb']==1) {
					$node_array[$i]['sub_array'][]=$node;
				}
			}
			$i++;
		}
		$this->output('node_array',$node_array);

		$this->shopshowpage("search_adv");
	}
}
$shop_search = new ShowShopSearch();
$shop_search->main();
unset($shop_search);
?>