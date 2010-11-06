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
 * FILE_NAME : index.php   FILE_PATH : \multishop\store\index.php
 * ....商铺首页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Sep 14 15:21:19 CST 2007
 */

require_once("../global.inc.php");

class Ajaxshow extends StoreFrameWork{

	var $obj_shop_module;
	function main(){
		
		if (!is_object($this->obj_shop_module)){
			require_once("shop_module.class.php");
			$this->obj_shop_module = new ShopModule();
		}
		/**
		 * 语言包
		 */
		 $this->setsubtemplates('store/store_drag');
		$this->getlang("store,store_control,shop");
		
	
		switch($this->_input['action']){			
			case "getQuickLinks":
				$this->_getQuickLinks();
				break;
			case 'showlistmod':
				$this->_show_list_mod();
				break;
			case "showproductmod":
				$this->_showproductmod();
				break;
			default:
		}


	}
	function _show_list_mod(){
		
		$array=$this->obj_shop_module->listShopModuleorder($this->_input['userid']);
		if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			if(is_array($array))
			{
				for($i=0;$i<count($array);$i++)
				{
					$array[$i]['module_name']=Common::nc_change_charset($array[$i]['module_name'],'gbk_to_utf8');
					$array[$i]['module_body']=Common::nc_change_charset($array[$i]['module_body'],'gbk_to_utf8');
					
				}
			}
		}
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$return_value= $obj_json->encode($array);
		echo $return_value;
		
	}
	function _showproductmod(){
		$id=$this->_input["mudole_id"];
		$array=$this->obj_shop_module->showproductmod($id);
		
		$this->output('product_array',$array);
		$this->showpage("control_product_module");
		
	}


}
$store = new Ajaxshow();
$store->main();
unset($store);
?>