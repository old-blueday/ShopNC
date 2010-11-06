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
* FILE_NAME : shopnc_info.php D:\binzi\shopnc6\shopnc_info.php
* 系统信息显示页面
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Mon Nov 17 17:21:32 CST 2008
*/
require ("global.inc.php");
class ShowShopncInfo extends CommonFrameWork {
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
			require_once("system.class.php");
			$this->obj_shopnc_info = new SystemClass();
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
		
		require_once("system.class.php");
		$footer_shopnc_info = new SystemClass();
		$foot_array	= $footer_shopnc_info->getSystemList();
		$this->output('foot_array',$foot_array);

		$info_array	= $this->obj_shopnc_info->getSystemInfo(array('info_id'=>intval($this->_input['info_id'])));
		$this->output('info_array',$info_array);
		
		$this->showpage('shopnc_info');
	}
}
$show_shopnc_info = new ShowShopncInfo();
$show_shopnc_info->main();
unset($show_shopnc_info);

?>