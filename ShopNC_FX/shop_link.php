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
* FILE_NAME : shop_link.php D:\root\shopnc6_jh\shop_link.php
* 友情链接
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Mon Aug 24 13:07:59 CST 2009
*/
require("shop.global.inc.php");
class ShowShopIndex extends ShopCommonFrameWork {
	/**
	 * 友情链接对象
	 *
	 * @var obj
	 */
	private $obj_shop_link;

	public function main() {
		/**
		 * 创建友情链接对象
		 */
		if (!is_object($this->obj_shop_link)) {
			require_once("shopLink.class.php");
			$this->obj_shop_link = new ShopLinkClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("templates/new_shops");
		/**
		 * 语言包
		 */
		$this->getlang("shop_link,shop_common");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			default:
				$this->showIndex();
		}
	}
	/**
	 * 友情链接
	 *
	 */
	private function showIndex() {
		/*友情链接*/
		$link_image	= $this->obj_shop_link->getLinkList(array('logo'=>1),'');
		$this->output('link_image',$link_image);
		$link_text	= $this->obj_shop_link->getLinkList(array('logo'=>2),'');
		$this->output('text_link_num',count($link_text));
		$this->output('link_text',$link_text);

		$this->shopshowpage("links");
	}
}
$shop_index = new ShowShopIndex();
$shop_index->main();
unset($shop_index);
?>