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
 * FILE_NAME : index.php   FILE_PATH : index.php
 * ....商城首页显示
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Sep 21 14:05:16 CST 2010
 */

require ("global.inc.php");

class ShowIndex extends CommonFrameWork{
	/**
	 * 首页和频道静态页面对象
	 *
	 * @var obj
	 */
	var $obj_html_channel;
	
		
	function main(){
		/**
		 * 创建首页和频道静态页面对象
		 */
		if (!is_object($this->obj_html_channel)){
			require_once("home/html.channel.php");
			$this->obj_html_channel = new HtmlChannelManage();
		}
						
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			default:
				$this->_showindex();
		}
	}
	/**
	 * 首页显示
	 * 
	 */
	function _showindex(){
		$this->obj_html_channel->_index_html();
	}
}
$index = new ShowIndex();
$index->main();
unset($index);
?>