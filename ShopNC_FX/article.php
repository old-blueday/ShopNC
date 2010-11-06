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
* FILE_NAME : article.php D:\root\shopnc6_jh\article.php
* 前台文章内容
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:44:26 CST 2009
*/
require ("global.inc.php");
class ShowArticle extends CommonFrameWork {
	/**
	 * 文章对象
	 *
	 * @var obj
	 */
	private $obj_show_article;
	/**
	 * 文章列表对象
	 *
	 * @var obj
	 */
	private $obj_show_class;

	function main(){
		/**
		 * 创建文章对象
		 */
		if(!is_object($this->obj_show_article)) {
			require_once("indexArticle.class.php");
			$this->obj_show_article = new IndexArticleClass();
		}
		/**
		 * 创建文章分类对象
		 */
		if(!is_object($this->obj_show_class)) {
			require_once("indexArticleClass.class.php");
			$this->obj_show_class = new IndexArticleClassClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("article,index,header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){

			default:
				$this->article();
		}
	}
	/**
	 * 文章内容显示页面
	 *
	 */
	private function article() {
		/*文章内容*/
		$article_id	= intval($this->_input['id']);
		if($article_id == 0) {
			header("Location:article_class.php");
			exit;
		}
		/*文章内容*/
		$article_info	= $this->obj_show_article->getArticleInfo(array('article_id'=>$article_id));
		$this->output('article_info',$article_info);
		/*文章列表*/
		$article_array = $this->obj_show_article->getArticle(array('article'=>1,'article_num'=>10));
		$this->output('article_array',$article_array);
		/*侧边文章分类*/
		$class_array	= $this->obj_show_class->getClass(array('article_class_topid'=>$article_info['article_class_id']));
		$this->output('class_array',$class_array);
		$this->showpage('article');
	}
}
$show_article	= new ShowArticle();
$show_article->main();
unset($show_article);
?>