<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : cache.php   FILE_PATH : uc_client\control\cache.php
 * ....uc_client
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 07 18:09:26 CST 2008
 */

!defined('IN_UC') && exit('Access Denied');

class cachecontrol extends ucbase {

	function cachecontrol() {
		$this->ucbase();
	}

	function onupdate($arr) {
		$this->load("cache");
		$_ENV['cache']->updatedata();
	}

}

?>