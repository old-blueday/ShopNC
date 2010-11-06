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
 * FILE_NAME : view_image.php   FILE_PATH : \multishop\home\view_image.php
 * ....商品图片展示功能
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Aug 28 16:09:14 CST 2007
 */
require ("../global.inc.php");

class ShowPic extends CommonFrameWork{

	function main(){
		
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 语言包
		 */
		$this->getlang("product");

		switch ($this->_input['action']){
			default:
				$this->_viewpic();
				break;
		}
	}

	/**
	 * 图片查看页面
	 */
	function _viewpic(){
		$pURL = $this->_input['pic'];
		$key = "3irjklsd8432uisdklvr892348";
		$pURL = Common::decodeStr($pURL, $key);
		$pURL = preg_replace('/\.\.\/\.\.\//', '', $pURL);
		$pURL = Common::encodeStr($pURL, $key);
		$this->output('pURL',$pURL);
		$this->showpage("pic.view");
	}

}

$pic = new ShowPic();
$pic->main();
unset($pic);
?>