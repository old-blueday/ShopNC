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
* FILE_NAME : shop_footer.php D:\root\shopnc6_jh\shop_footer.php
* 聚合底部文件
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:50:02 CST 2009
*/
require("shop.global.inc.php");
class ShowShopFooter extends ShopCommonFrameWork {
	/**
	 * 底部信息对象
	 *
	 * @var obj
	 */
	private $obj_shopnc_info;
	/**
	 * 文章对象
	 *
	 */
	private $obj_article;		
	public function main() {
		/**
		 * 创建底部信息对象
		 */
		if (!is_object($this->obj_shopnc_info)) {
			require_once("shopSystem.class.php");
			$this->obj_shopnc_info = new ShopSystemClass();
		}
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
				$this->showFooter();
		}
	}
	/**
	 * 聚合底部文件
	 *
	 */
	private function showFooter() {

		/*店铺分类*/
		include(BasePath."/share/shop_class_show.php");
		if (is_array($node_cache)){
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
		}
		/*底部用户指南类文章*/
		$article_array	= $this->obj_article->getArticleList('','');
		foreach ($article_array as $k=>$v) {
			if (in_array($v['arc_class'],array(4,5,6))){
				if (count($class_array[$v['arc_class']])<3){
					$class_array[$v['arc_class']][] = $v;
				}	
			}
		}
		/*取文章*/
		$this->output('artclass_array',$class_array);		
		
		
		/*底部信息*/
		$info_array	= $this->obj_shopnc_info->getSystemList();
		$this->output('info_array',$info_array);
		$this->showpage("footer");
	}
}
$shop_footer = new ShowShopFooter();
$shop_footer->main();
unset($shop_footer);
?>