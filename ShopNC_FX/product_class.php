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
* FILE_NAME : product_class.php D:\root\shopnc6_jh\product_class.php
* 前台产品分类列表
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:47:00 CST 2009
*/
require ("global.inc.php");

class ShowProductClass extends CommonFrameWork {
	/**
	 * 产品分类对象
	 *
	 * @var obj
	 */
	private $obj_product_class;
	/**
	 * 品牌对象
	 *
	 * @var obj
	 */
	private $obj_brand;
	function main(){

		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_product_class)) {
			require_once("productClass.class.php");
			$this->obj_product_class = new ProductClassClass();
		}

		/**
		 * 创建商品品牌对象
		 */
		if (!is_object($this->obj_brand)) {
			require_once("brand.class.php");
			$this->obj_brand = new BrandClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("index,header_footer,product_class");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'other':			//其他显示形式（最新，热卖，推荐，特价）
			$this->showOtherClass();
			break;
			default:
				$this->showClass();
		}

	}
	/**
	 * 显示商品分类页面
	 *
	 */
	private function showClass() {
		if(intval($this->_input['classid']) == 0) {
			header("Location:index.php");
			exit();
		}
		include(BasePath."/share/".NC_SHOP_DIR."goods_class_show.php");
		$array	= array();
		foreach ($node_cache as $k => $v) {
			if($v[0] == intval($this->_input['classid'])) {
				$array['class_id']			= $v[0];
				$array['class_top_id']		= $v[1];
				$array['class_name']		= $v[2];
				$array['class_keywords']	= $v[6];
				$array['class_description']	= $v[7];
				$array['key_id']			= $k;
				break;
			}
		}
		/*当前分类信息*/
		$this->output('class_info',$array);
		/*分类导航*/
		$class_menu = $this->obj_product_class->prductClassMenu($array);
		$this->output('class_menu',$class_menu);
		/*下一级分类*/
		$sub_array	= $this->obj_product_class->getSpecificClass(array('sub_class_id'=>$array['class_id']));
		$this->output('sub_class',$sub_array);
		$this->output('sub_class_num',count($sub_array));
		/*创建分页对象*/
		$view_list_num	= $this->_viewinfo['websit']['other_goods_class'] == '1' ? (int)$this->_viewinfo['websit']['other_goods_class_num'] : 0;
		if(intval($this->_input['goods_nums']) != 0) {
			$view_list_num = intval($this->_input['goods_nums']);
		}

		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum($view_list_num);//每页显示商品数

		$product_array	= $this->obj_product_class->productClassList($array,$obj_page,'*',$this->_input['goods_show']);
		$product_class_page = $obj_page->show(6);
		$this->output('product_class_page',$product_class_page);
		$this->output('product_array',$product_array);
		/*商品品牌*/
		$brand_array	= $this->obj_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_array',$brand_array);
		/*当前类热卖商品*/
		$hot_array		= $this->obj_product_class->productClassList($array,'','goods.goods_name,goods.goods_id,goods.shop_goods_id','',' order by goods.goods_click desc',8);
		$this->output('hot_array',$hot_array);
		/*浏览过的商品*/
		if($this->getCookies('c_product_viewed') != '') {
			$view_goods_array= $this->obj_product_class->productClassList(array('c_product_viewed'=>$this->getCookies('c_product_viewed')),'','goods.goods_name,goods.goods_id,goods.goods_small_image,shop_goods_id');
			$this->output('view_goods_array',$view_goods_array);
		}

		$this->showpage('product_class');
	}
	/**
	 * 其他显示方式
	 *
	 */
	private function showOtherClass() {
		if(!in_array(trim($this->_input['type']),array('hot','new','commend','special'))) return false;

		/*分类导航*/
		$language	= 'product_class_'.trim($this->_input['type']);
		$class_menu[] = array('class_id'=>0,'class_name'=>$this->_lang[$language]);
		$this->output('class_menu',$class_menu);
		/*创建分页对象*/
		$view_list_num	= $this->_viewinfo['websit']['other_goods_class'] == '1' ? (int)$this->_viewinfo['websit']['other_goods_class_num'] : 0;
		if(intval($this->_input['goods_nums']) != 0) {
			$view_list_num = intval($this->_input['goods_nums']);
		}
		
		$condition	= array();
		$condition	= array('show_type'=>'other','type'=>trim($this->_input['type']));
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum($view_list_num);
		$product_array	= $this->obj_product_class->productClassList($condition,$obj_page,'*',$this->_input['goods_show']);
		$product_class_page = $obj_page->show(6);
		$this->output('product_class_page',$product_class_page);
		$this->output('product_array',$product_array);
		/*商品品牌*/
		$brand_array = $this->obj_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_array',$brand_array);
		/*当前类热卖商品*/
		$hot_array		= $this->obj_product_class->productClassList($array,'','goods.goods_name,goods.goods_id,goods.shop_goods_id','',' order by goods.goods_click desc',8);
		$this->output('hot_array',$hot_array);
		/*最近浏览*/
		/*浏览过的商品*/
		if($this->getCookies('c_product_viewed') != '') {
			$view_goods_array= $this->obj_product_class->productClassList(array('c_product_viewed'=>$this->getCookies('c_product_viewed')),'','goods.goods_name,goods.goods_id,goods.goods_small_image,shop_goods_id');
			$this->output('view_goods_array',$view_goods_array);
		}
		
		$this->showpage('product_class');
	}
}
$product_class = new ShowProductClass();
$product_class->main();
unset($product_class);
?>