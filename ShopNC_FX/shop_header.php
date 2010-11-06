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
* FILE_NAME : shop_header.php D:\root\shopnc6_jh\shop_header.php
* 聚合型多用户前台头部文件
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:50:15 CST 2009
*/
require("shop.global.inc.php");
class ShowShopHeader extends ShopCommonFrameWork {
	/**
	 * 文章分类对象
	 *
	 */
	private $obj_article;
	
	public function main() {
		/**
		 * 创建文章对象
		 */
		if (!is_object($this->obj_article)) {
			require_once("shopIndexArticle.class.php");
			$this->obj_article = new ShopIndexArticleClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("templates/new_shops");
		/**
		 * 语言包
		 */
		$this->getlang("shop_html,shop_common");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			default:
				$this->showHeader();
		}
	}
	/**
	 * 聚合头部文件
	 *
	 */
	private function showHeader() {
		/*导航处店铺分类*/
		if (is_file(BasePath."/share/shop_class_show.php")){
			include(BasePath."/share/shop_class_show.php");
		}else{
			require("shopClass.class.php");
			ShopClassClass::createShopClassFile();
			include(BasePath."/share/shop_class_show.php");
		}
		if (is_array($node_cache)){
			$header_menu_array1 = array();
			foreach ($node_cache as $node) {
				if ($node['ifmenu']==1) {
					$header_menu_array1[]=$node;
				}
			}
			$this->output('header_menu_array1',$header_menu_array1);
		}

		/*搜索店铺下拉列表*/
		$parent_array = array();
		if (is_array($node_cache)){
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
		}

		/*导航处文章分类*/
		$header_menu_array2	= $this->obj_article->getArticleClass(array('class_type'=>'top_menu'));
		$this->output('header_menu_array2',$header_menu_array2);
		/*搜索关键字*/
		include(BasePath.'/data/search_keywords.php');
		$this->output('search_keywords',$search_keywords);

		$this->showpage("header");
	}
}
$shop_header = new ShowShopHeader();
$shop_header->main();
unset($shop_header);
?>