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
 * FILE_NAME : intro.php   FILE_PATH : \multishop\store\intro.php
 * ....店铺介绍
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Sat Sep 15 10:18:10 CST 2007
 */

require_once("../global.inc.php");

class StoreIntro extends StoreFrameWork{
	/**
	 * 地区信息
	 *
	 * @var obj
	 */
	var $obj_area;

	function main(){
		/**
		 * 实例化地区类
		 */
		if (!is_object($this->obj_area)){
			require_once("area.class.php");
			$this->obj_area = new AreaClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("store");

		/**
		 * 语言包
		 */
		$this->getlang("store,store_intro");

        //如果是现有模板
        if($this->shop['templates'] == 0)
            //设置导航css
            $this->_set_current_nav('intro');

		//获取店铺信息 $this->shop
		$this->check_shop();

		if ($this->shop['shop_area_id'] != ''){
			$sel_area = $this->obj_area->getAreaPathList($this->shop['shop_area_id']);
		}

		/**
		 * 页面输出
		 */
		$this->output('shop_array',$this->shop);
		$this->output('sel_area',$sel_area);

		if ($this->shop['templates'] == '0'){//现有模板
			$this->showpage("store_intro.default");
		}else{
			//自定义风格内容
			$this->_get_diy_style();
			$this->showpage("store_intro");
		}
	}
}
$intro = new StoreIntro();
$intro->main();
unset($intro);
?>