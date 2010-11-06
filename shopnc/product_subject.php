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
* FILE_NAME : product_brand.php D:\binzi\shopnc6\product_subject.php
* 前台主题列表页面
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Fri Sep 19 15:41:18 CST 2008
*/
require ("global.inc.php");

class ShowProductSubject extends CommonFrameWork {
	/**
	 * 商品主题对象
	 *
	 * @var obj
	 */
	private $obj_subject;
	/**
	 * 商品对象
	 *
	 * @var obj 
	 */
	private $obj_goods;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	private $obj_brand;
	/**
	 * 商品分类对象 
	 *
	 * @var obj
	 */
	private $obj_goods_class;
	function main(){
		/**
		 * 创建商品主题对象
		 */
		if(!is_object($this->obj_subject)){
			require_once("goodsSubject.class.php");
			$this->obj_subject = new GoodsSubjectClass();
		}
		/**
		 * 创建商品对象
		 */
		if(!is_object($this->obj_goods)) {
			require_once("goods.class.php");
			$this->obj_goods = new GoodsClass();
		}
		/**
		 * 创建商品品牌对象
		 */
		if (!is_object($this->obj_brand)) {
			require_once("brand.class.php");
			$this->obj_brand = new BrandClass();
		}
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_goods_class)) {
			require_once("goodsClass.class.php");
			$this->obj_goods_class = new GoodsClassClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("subject,index,header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'list':
				$this->showSubjectList();
				break;
			default:
				$this->showSubjectIndex();
				break;
		}

	}
	/**
	 * 主题馆首页
	 *
	 */
	private function showSubjectIndex() {
		/*商品品牌*/
		$brand_array = $this->obj_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_array',$brand_array);
		/*商品分类*/
		$conditon_array = array('class_top_id'=>'0','class_state'=>'1');
		$goods_class_array = $this->obj_goods_class->getGoodsClass($conditon_array,'');
		$this->output("goods_class_array",$goods_class_array);

		$subject_array = $this->obj_subject->getSubjectAll(array('subject_state'=>'1'));
		$this->output("subject_array",$subject_array);
		$this->showpage('product_subject_index');
	}
	/**
	 * 主题商品列表
	 *
	 */
	private function showSubjectList(){
		/*主题信息*/
		$subject_id = intval($this->_input['subject_id']);
		$subject_array = $this->obj_subject->getSubjectInfo(array('subject_id'=>$subject_id));
		$this->output("subject_array",$subject_array);
		/*主题商品*/
		$conditon_array = array('subject_id'=>$subject_id,'state'=>1);
		$product_array	= $this->obj_goods->getGoodsList($conditon_array,'');
		$this->output("product_array",$product_array);
		$this->showpage('product_subject_list');
	}
}
$subject_class = new ShowProductSubject();
$subject_class->main();
unset($subject_class);
?>