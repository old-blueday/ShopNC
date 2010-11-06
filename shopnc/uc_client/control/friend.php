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
 * FILE_NAME : friend.php   FILE_PATH : uc_client\control\friend.php
 * ....uc_client
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 07 18:10:13 CST 2008
 */

!defined('IN_UC') && exit('Access Denied');

class friendcontrol extends ucbase {

	function friendcontrol() {
		$this->ucbase();
		$this->load('friend');
	}

	function ondelete($arr) {
		@extract($arr, EXTR_SKIP);//uid friendids
		$id = $_ENV['friend']->delete($uid, $friendids);
		return $id;
	}

	function onadd($arr) {
		@extract($arr, EXTR_SKIP);//uid friendid comment
		$id = $_ENV['friend']->add($uid, $friendid, $comment);
		return $id;
	}

	function ontotalnum($arr) {
		@extract($arr, EXTR_SKIP);//uid direction
		$totalnum = $_ENV['friend']->get_totalnum_by_uid($uid, $direction);
		return $totalnum;
	}

	function onls($arr) {
		@extract($arr, EXTR_SKIP);//uid page pagesize totalnum direction
		$totalnum = $totalnum ? $totalnum : $_ENV['friend']->get_totalnum_by_uid($uid);
		$data = $_ENV['friend']->get_list($uid, $page, $pagesize, $totalnum, $direction);
		return $data;
	}
}

?>