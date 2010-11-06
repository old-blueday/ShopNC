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
* FILE_NAME : header.php D:\root\shopnc6_jh\header.php
* 前台头部文件
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:45:30 CST 2009
*/
require ("global.inc.php");
class ShowHeader extends CommonFrameWork {
	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	private $obj_product_class;
	/**
	 * 文章类别对象
	 *
	 * @var obj
	 */
	private $obj_article_class;
	/**
	 * 访问对象 
	 *
	 * @var unknown_type
	 */
	private $obj_visit;
	function main(){
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_product_class)) {
			require_once("productClass.class.php");
			$this->obj_product_class = new ProductClassClass();
		}
		/**
		 * 创建文章类别对象
		 */
		if (!is_object($this->obj_article_class)) {
			require_once("articleClass.class.php");
			$this->obj_article_class = new ArticleClassClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			default:
				$this->nc_header();
		}

	}
	private function nc_header() {
		/*在导航的商品分类*/
		$header_product_class	= $this->obj_product_class->getSpecificClass(array('show_type'=>'header'));
		$this->output('header_product_class',$header_product_class);
		/*在导航的文章分类*/
		$header_article_class	= $this->obj_article_class->getArticleClass(array('article_class_menu'=>1));
		$this->output('header_article_class',$header_article_class);
		/*语言包选择*/
		require_once("moduleLanguage.class.php");
		$module_language = new ModuleLanguageClass();
		$conditon_array = array();
		$language_array	= $module_language->getLanguageList($conditon_array);
		$this->output('language_array',$language_array);
		/*判断选中的语言包类型*/
		if($_SESSION['language'] != '') {
			$language_ver	= $_SESSION['language'];
		} else {
			$language_ver	= $this->_configinfo['websit']['versionarea'];
		}
		$this->output('language_ver',$language_ver);

		/*购物车*/
		require_once("shopCart.class.php");
		$shop_cart = new ShopCartClass();
		$this->output('cart_count',$shop_cart->GoodsCount());
		
		/*导航菜单选中*/
		$show_menu			= '';
		$show_product_menu	= '';
		$show_article_menu	= '';
		
		$menu_name	= basename($_SERVER['PHP_SELF']);
		if($menu_name == 'index.php') {
			$show_menu		= 'index';
		} elseif ($menu_name == 'product_subject.php') {
			$show_menu		= 'subject';
		} elseif ($menu_name == 'product_brand.php') {
			$show_menu		= 'brand';
		}elseif ($menu_name == 'article_class.php') {
			$show_article_menu		= $this->_input['id'];
			if($show_article_menu == '') {
				$show_article_menu	= 'article';
			}
		}elseif ($menu_name == 'product_class.php') {
			$show_product_menu		= $this->_input['classid'];
		}
		$this->output('show_menu',$show_menu);
		$this->output('show_product_menu',$show_product_menu);
		$this->output('show_article_menu',$show_article_menu);
		
		$this->showpage('header');
	}
}
$show_header = new ShowHeader();
$show_header->main();
unset($show_header);
?>