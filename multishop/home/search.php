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
 * FILE_NAME : product_auction.php
 * 竞拍商品前台程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Jun 14 01:05:38 GMT 2010
 */
require ("../global.inc.php");
class Search extends CommonFrameWork{
		function main(){
		
		
		if($this->_configinfo['websit']['ncharset']=="UTF-8")
		{
			$this->_input['q']=Common::nc_change_charset($this->_input['q'],'utf8_to_gbk');
		}
		/**
		 *进行转码
		 */
		$this->_input['q']=urlencode($this->_input['q']);
		Header("Location: http://www.shopnc.net/help/search/?q=".$this->_input['q']); 

	}
}
$search = new Search();
$search->main();
unset($search);
?>