<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_shopmap.php   FILE_PATH : E:\www\multishop\trunk\member\own_shopmap.php
 * ....商店地图
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Feb 09 21:35:25 CST 2009
 */

require_once("../global.inc.php");

class OwnShopmap extends memberFrameWork{

	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;


	function main(){
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("shop");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('my_shop','shop_manage','shop_map');			
		
		//判断店铺删除状态
		//$this->isShopDel();
		
		$this->_input['hideShopId'] = $_SESSION["s_shop"]['id'];

		
		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "save":
				$this->_saveMap();
				break;
			default:
				$this->_showMap();
		}
	}

	/**
	 * 调用地图
	 *
	 */
	function _showMap(){
		
		/**
		 * 获取商铺信息
		 */
		$shop_array = array();
		$shop_array = $this->obj_shop->getOneShop($_SESSION["s_shop"]['id']);
		//设置地图城市,英文拼音
		$str_cityname = 'tianjin';
		
		if ($shop_array['positionC'] != "NULL") {
			$shop_city = $shop_array['positionC'];
		}else {
			$shop_city = $str_cityname;
		}
		
		$shop_array['positionZ'] = $shop_array['positionZ']!="0"?$shop_array['positionZ']:4;
		/**
		 * 页面输出
		 */
		$this->output("city",   $shop_city );    //输出城市
		$this->output("shopid",   $_SESSION["s_shop"]['id']);    //输出店铺id
		$this->output("userid",   $_SESSION["s_login"]['id']);    //输出店铺id
		$this->output("shopname",   $shop_array['shop_name']);    //店铺位置X坐标
		$this->output("positionX",   $shop_array['positionX']);    //店铺位置X坐标
		$this->output("positionY",   $shop_array['positionY']);    //店铺位置Y坐标
		$this->output("positionZ",   $shop_array['positionZ']);    //店铺位置地图缩放级别
		$this->showpage("own_shopmap.manage");   //显示页面
	}

	/**
	 * 保存地图坐标
	 *
	 */
	function _saveMap(){
		$array = array();
		$array['shop_id'] = $_SESSION['s_shop']['id'];
		$array['positionX'] = $this->_input['weizhiX'];
		$array['positionY'] = $this->_input['weizhiY'];
		$array['positionZ'] = $this->_input['weizhiZ'];
		$array['positionC'] = $this->_input['weizhiC'];
		$this->obj_shop->_updateShop($array);

		$this->redirectPath("succ","member/own_shopmap.php",$this->_lang['langShopLabelShopLocality']);

	}
}
$map_manage = new OwnShopMap();
$map_manage->main();
unset($map_manage);
?>