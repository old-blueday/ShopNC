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
* FILE_NAME : article_class.php D:\binzi\shopnc6\article_class.php
* 前台文章分类
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Mon Sep 22 09:48:57 CST 2008
*/
require ("global.inc.php");
class ShowArticleClass extends CommonFrameWork {
	/**
	 * 文章分类对象
	 *
	 * @var obj
	 */
	private $obj_show_class;
	/**
	 * 文章对象
	 *
	 * @var obj
	 */
	private $obj_show_article;
	
	function main(){
		/**
		 * 创建文章分类对象
		 */
		if(!is_object($this->obj_show_class)) {
			require_once("indexArticleClass.class.php");
			$this->obj_show_class = new IndexArticleClassClass();
		}
		/**
		 * 创建文章对象
		 */
		if(!is_object($this->obj_show_article)) {
			require_once("indexArticle.class.php");
			$this->obj_show_article = new IndexArticleClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("article_list,index,header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){

			default:
				$this->articleList();
		}
	}
	/**
	 * 文章内容分类列表
	 *
	 */
	private function articleList() {
		$condition['article_class_id']	= intval($this->_input['id']);
		/*侧边文章分类*/
		$class_array	= $this->obj_show_class->getClass(array('article_class_topid'=>$condition['article_class_id']));
		$this->output('class_array',$class_array);
		
		/*创建分页对象*/
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(12);
		$article_array	= $this->obj_show_article->getArticleList($condition,$obj_page,array('article_commend desc,article_sort'));
		$show_page = $obj_page->show(6);
		$this->output('article_array',$article_array);
		$this->output('show_page',$show_page);
		/*当前分类信息*/
		$class_info	= $this->obj_show_class->getArticleClass(array('article_class_id'=>intval($this->_input['id'])));
		$article_class['title']			= $class_info[0]['article_class_name'];
		$article_class['keywords']		= $class_info[0]['article_class_keywords'];
		$article_class['description']	= $class_info[0]['article_class_description'];
		$this->output('article_class',$article_class);

		$this->showpage('article_list');
	}
}
$show_article_class	= new ShowArticleClass();
$show_article_class->main();
unset($show_article_class);
?>