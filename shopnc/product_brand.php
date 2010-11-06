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
* FILE_NAME : product_brand.php D:\binzi\shopnc6\product_brand.php
* 前台品牌列表页面
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Fri Sep 19 15:41:18 CST 2008
*/
require ("global.inc.php");

class ShowProductBrand extends CommonFrameWork {
	/**
	 * 品牌对象
	 *
	 * @var obj
	 */
	private $obj_brand;
	function main(){

		/**
		 * 创建品牌对象
		 */
		if (!is_object($this->obj_brand)) {
			require_once("brand.class.php");
			$this->obj_brand = new BrandClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("brand,index,header_footer,brand_list");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'index':
				$this->showBrandIndex();
				break;
			default:
				$this->showBrand();
		}

	}
	/**
	 * 商品品牌首页
	 *
	 */
	private function showBrandIndex() {
		$brand_array	= $this->obj_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_array',$brand_array);
		$this->showpage('product_brand_index');
	}
	/**
	 * 单一品牌商品列表
	 *
	 */
	private function showBrand() {
		$brand_id	= intval($this->_input['brandid']);
		if($brand_id == 0) {
			header("Location:?action=index");
			exit;
		}
		/*品牌信息*/
		$brand_info	= $this->obj_brand->getBrandInfo(array('brand_id'=>$brand_id));
		$this->output('brand_info',$brand_info);

		/*创建分页对象*/
		$view_list_num	= $this->_viewinfo['websit']['other_brand_class'] == '1' ? (int)$this->_viewinfo['websit']['other_brand_class_num'] : 0;
		if(intval($this->_input['goods_nums']) != 0) {
			$view_list_num = intval($this->_input['goods_nums']);
		}
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum($view_list_num);
		$brand_product	= $this->obj_brand->productBrandList(array('brand_id'=>intval($this->_input['brandid'])),$obj_page,'*',$this->_input['goods_show']);
		$product_brand_page = $obj_page->show(6);
		$this->output('product_brand_page',$product_brand_page);
		$this->output('brand_product',$brand_product);
		/*该品牌热门商品*/
		$hot_array	= array();
		$hot_array= array('brand_id' => intval($this->_input['brandid']),'order_value'=>'goods_click','limit_num'=>8);
		$brand_hot	= $this->obj_brand->getBrandProduct($hot_array);
		$this->output('brand_hot',$brand_hot);
		/*推荐品牌,暂时无此字段*/
		$brand_commend = $this->obj_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_commend',$brand_commend);

		$this->showpage('product_brand_list');
	}
}
$brand_class = new ShowProductBrand();
$brand_class->main();
unset($brand_class);
?>