<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : search.php D:\binzi\shopnc6\search.php
* 后台工具管理语言包
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Tue Nov 18 15:07:37 CST 2008
*/
require ("global.inc.php");
class ShowSearch extends CommonFrameWork {

	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	private $obj_product;

	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	private $obj_goods_class;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	private $obj_goods_brand;

	function main() {
		if(!is_object($this->obj_product)) {
			require_once("product.class.php");
			$this->obj_product = new ProductClass();

		}
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_goods_class)) {
			require_once("goodsClass.class.php");
			$this->obj_goods_class = new GoodsClassClass();
		}
		/**
		 * 创建品牌对象
		 */
		if (!is_object($this->obj_goods_brand)) {
			require_once("goodsBrand.class.php");
			$this->obj_goods_brand = new GoodsBrandClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("index,header_footer,search");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'height_search':		//高级搜索页面
			$this->height_serach();
			break;
			default:
				$this->SearchList();
		}
	}
	/**
	 * 高级搜索页面
	 *
	 */
	private function height_serach() {
		
		$ProductClassArray = $this->obj_goods_class->listClassDetail();
		/*商品分类下拉菜单*/
		$class_value = $input_param['txt_class_top_id'] != '' ? $input_param['txt_class_top_id'] : '';
		$this->output("txt_class_top_id",Common::showForm_Select2("txt_class_top_id","","",$ProductClassArray,$class_value,$this->_lang['search_choice_cateory']));
		/*下拉商品品牌*/
		$brand_selected = $input_param['sel_goods_brand'] != '' ? $input_param['sel_goods_brand'] : '';
		$obj_page = '';
		$conditon_array = array();
		$brand = $this->obj_goods_brand->getBrandList($conditon_array,$obj_page);
		$brand_array = array();
		foreach ($brand as $array) {
			$brand_array[$array['brand_id']] = $array['brand_name'];
		}
		$this->output('goods_brand',Common::Select('sel_goods_brand',$brand_array,$this->_lang['search_choice_brand'],$brand_selected));
		
		$this->showpage('search');
	}
	/**
	 * 搜索结果列表
	 *
	 */
	private function SearchList() {
		$input_param	= array();
		$input_param['keywords']	= trim($this->_input['keywords']);				//关键字
		$input_param['start_price']	= intval($this->_input['start_price']);			//开始价格
		$input_param['end_price']	= intval($this->_input['end_price']);			//结束价格
		$input_param['all_sun']		= trim($this->_input['all_sun']);				//选择全部子类
		$input_param['txt_class_top_id'] = intval($this->_input['txt_class_top_id']);//商品分类
		$input_param['sel_goods_brand']	= intval($this->_input['sel_goods_brand']);	//商品品牌

		$sql	= '';
		if($input_param['start_price'] != 0 and $input_param['end_price'] != 0) {
			$sql	.= " and (goods.goods_pricedesc <=".$input_param['end_price']." and goods.goods_pricedesc >=".$input_param['start_price'].")";
		}
		if($input_param['sel_goods_brand'] != 0) {
			$sql	.= " and goods.brand_id=". $input_param['sel_goods_brand'];
		}

		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(20);//每页显示商品数

		include(BasePath."/share/goods_class_show.php");
		$array	= array();
		$i	= 0;
		foreach ($node_cache as $k => $v) {
			if($v[1] == 0) {
				$left_array[$i]['class_id']		= $v[0];
				$left_array[$i]['class_name']	= $v[2];
				$i++;
			}
			if($input_param['all_sun']	== 'all_sun') {
				if($v[0] == $input_param['txt_class_top_id']) {
					$array['class_id']	= $v[0];
					$array['class_top_id']	= $v[1];
					$array['class_name']	= $v[2];
					$array['class_keywords']= $v[6];
					$array['class_description']= $v[7];
					$array['key_id']	= $k;
				}
			}
		}
		$this->output('left_array',$left_array);	//左侧商品分类

		if($input_param['all_sun']	== 'all_sun') {
			require_once("productClass.class.php");
			$product_class = new ProductClassClass();
			$search_array	= $product_class->productClassList($array,$obj_page,'*',$this->_input['goods_show']);
		} else {
			$search_array	= $this->obj_product->searchGoods($input_param,$obj_page,'*','',$sql);
		}

		$search_page = $obj_page->show(6);

		$this->output('search_count',$obj_page->total_num);
		$this->output('product_class_page',$search_page);
		$this->output('product_array',$search_array);

		/*商品品牌*/
		$brand_array = $this->obj_goods_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_array',$brand_array);

		$this->showpage('search_list');
	}

}
$show_search	= new ShowSearch();
$show_search->main();
unset($show_search);
?>