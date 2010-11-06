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
* FILE_NAME : shop_info.php D:\root\shopnc6_jh\shop_info.php
* 系统信息显示页面
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:51:24 CST 2009
*/
require ("shop.global.inc.php");
class ShowShopncInfo extends ShopCommonFrameWork {
	/**
	 * 底部信息对象
	 *
	 * @var obj
	 */
	private $obj_shopnc_info;

	function main(){
		/**
		 * 创建底部信息对象
		 */
		if (!is_object($this->obj_shopnc_info)) {
			require_once("shopSystem.class.php");
			$this->obj_shopnc_info = new ShopSystemClass();
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
			default:
				$this->showInfo();
		}

	}
	private function showInfo() {
		/*底部其他信息，侧边栏显示*/
		$info_id	= intval($this->_input['info_id']);
		if($info_id == 0) {
			header("Location:?info_id=1");
			exit;
		}

		$foot_array	= $this->obj_shopnc_info->getSystemList();
		$this->output('foot_array',$foot_array);

		$info_array	= $this->obj_shopnc_info->getSystemInfo(array('info_id'=>intval($this->_input['info_id'])));
		$this->output('article_array',$info_array);

		$this->shopshowpage("shop_info");
	}
}
$show_shopnc_info = new ShowShopncInfo();
$show_shopnc_info->main();
unset($show_shopnc_info);

?>