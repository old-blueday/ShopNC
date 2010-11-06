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
* FILE_NAME : shop_map.php   FILE_PATH : \store\shop_map.php
* ....店铺地图
*
* @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
* @author ShopNC Develop Team 
* @package 
* @subpackage 
* @version Fri Mar 14 18:14:57 CST 2008
*/

require_once("../global.inc.php");

class StoreIntro extends StoreFrameWork{
	function main(){
		//获取店铺信息 $this->shop
		$this->check_shop();
        //设置导航css
        $this->_set_current_nav('map');
//		if ($this->shop['audit_state'] != 2){
//			//如果不是商铺是会员的话跳转到会员信息页面
//			$this->redirectPath("common","store/userinfo.php?userid=" . $this->_input['userid'],"");
//		}
		
		/**
		 * 设置店铺模板路径
		 */
		$this->setsubtemplates("store");
		
		/**
		 * 语言包
		 */
		$this->getlang("store,store_control");
		
		/**
		 * 页面输出
		 */
		$shop_array = $this->shop;
		//设置地图城市,英文拼音
		$str_cityname = 'tianjin';
		
		if ($shop_array['positionC'] != "NULL") {
			$shop_city = $shop_array['positionC'];
		}else {
			$shop_city = $str_cityname;
		}	
		if($shop_array['shop_pic'] == ''){
			$shop_array['shop_pic'] = 'templates/'.$this->_configinfo['websit']['templatesname'].'/home/images/images_new/storepic_default.gif';
		}
		$this->output("shop_map_array",$shop_array);
		$this->output("shop_city",$shop_city);
		if($this->shop['templates'] == '0'){
			/**
			 * 页面输出
			 */
			$this->showpage("store_map.default");
		}else{
			//自定义风格内容
			$this->_get_diy_style();
			$this->showpage("store_map");
		}
	}
}
$intro = new StoreIntro();
$intro->main();
unset($intro);
?>