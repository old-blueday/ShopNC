<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : member.php   FILE_PATH : \multishop\home\member.php
 * ....会员表现层页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Aug 09 15:33:46 CST 2007
 */

require ("../global.inc.php");

class Register extends CommonFrameWork{
	function main(){
		header("Location: member.php?action=regist");
	}
}
$member = new Register();
$member->main();
unset($member);
?>