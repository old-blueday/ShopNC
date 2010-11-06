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
* FILE_NAME : shop_article.php D:\root\shopnc6_jh\shop_article.php
* 文章列表
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:49:52 CST 2009
*/
require("shop.global.inc.php");
class ShowShopArticle extends ShopCommonFrameWork {
	/**
	 * 文章对象
	 *
	 */
	private $obj_article;
	/**
	 * 网店对象
	 *
	 * @var obj
	 */
	private $obj_shopuser;

	public function main() {
		/**
		 * 创建文章对象
		 */
		if (!is_object($this->obj_article)) {
			require_once("shopIndexArticle.class.php");
			$this->obj_article = new ShopIndexArticleClass();
		}
		/**
		 * 创建网店对象
		 */
		if (!is_object($this->obj_shopuser)){
			require_once("shopUser.class.php");
			$this->obj_shopuser = new ShopUserClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("templates/new_shops");
		/**
		 * 语言包
		 */
		$this->getlang("shop_article,shop_common");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'article_list':
				$this->showArticleList();		//文章列表
				break;
			case 'article_content':
				$this->showArticleContent();	//文章内容
				break;
			default:
				$this->showArticleList();
		}
	}
	/**
	 * 文章列表
	 *
	 */
	private function showArticleList() {
		/*右侧文章列表*/
		include("shopArticleClass.class.php");
		$article_class	= new ShopArticleClassClass();
		$class_array	= $article_class->getArticleClassList();
		$article_array		= $this->obj_article->getArticleList('','');
		foreach ($class_array as $k=>$v) {
			foreach ($article_array as $v1) {
				if ($v['cid'] == $v1['arc_class']){
					if (count($class_array[$k]['body'])<5){
						$class_array[$k]['body'][] = $v1;
					}
				}
			}
		}
		$this->output('artclass_array',$class_array);
		/*创建分页对象*/
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(10);
		$obj_page->pagesize=3;
		$condition_array	= array('article_state'=>1);
		$condition_array	= array('arc_class'=>intval($this->_input['id']));
		$article_array		= $this->obj_article->getArticleList($condition_array,$obj_page);
		$show_page = $obj_page->show(8);
		$this->output('article_array',$article_array);
		$this->output('show_page',$show_page);

		/*热门店铺*/
		$hot_shops_array	= $this->obj_shopuser->getShopListType(array('shop_type'=>'hot_shop'),5);
		$this->output('hot_shops_array',$hot_shops_array);

			$this->shopshowpage("article_list");
	}
	/**
	 * 文章内容
	 *
	 */
	private function showArticleContent() {
		/*右侧文章列表*/
		include("shopArticleClass.class.php");
		$article_class	= new ShopArticleClassClass();
		$class_array	= $article_class->getArticleClassList();
		$article_array		= $this->obj_article->getArticleList('','');
		foreach ($class_array as $k=>$v) {
			foreach ($article_array as $v1) {
				if ($v['cid'] == $v1['arc_class']){
					if (count($class_array[$k]['body'])<5){
						$class_array[$k]['body'][] = $v1;
					}
				}
			}
		}
		$this->output('artclass_array',$class_array);
		/*文章内容信息*/
		$content_array	= $this->obj_article->getArticleContent(array('aid'=>intval($this->_input['id'])));
		$this->output('article_array',$content_array[0]);

		/*相关内容*/


		/*热门店铺*/
		$hot_shops_array	= $this->obj_shopuser->getShopListType(array('shop_type'=>'hot_shop'),5);
		$this->output('hot_shops_array',$hot_shops_array);
		
		$this->shopshowpage('article');
	}
}
$shop_article = new ShowShopArticle();
$shop_article->main();
unset($shop_article);
?>