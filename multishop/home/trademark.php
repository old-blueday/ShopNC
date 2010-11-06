<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : trademark.php    FILE_PATH : \member\trademark.php
 * ....品牌空间页面显示程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version 2010-6-22 上午09:31:15 2010
 */

require ("../global.inc.php");

class ShowTrademark extends CommonFrameWork{
	
	function main() {
		/**
		 * 设置模版路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("trademark");
		/**
		 * 执行操作
		 */
		switch ($this->_input['action']) {
			default:
				$this->_showtrademark();
		}
	}
	/**
	 * 显示品牌空间
	 *
	 * @param 
	 * @param 
	 * @return 
	 */
	function _showtrademark() {
		/**
		 * 页面输出
		 */
		$this->output("title_message",$this->_lang['langCBrandSpace'].' - ');
		$this->output("sel_page", "trademark");
		$this->showpage("trademark");
	}
}
$trademark = new ShowTrademark();
$trademark->main();
unset($trademark);
?>