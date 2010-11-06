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
 * FILE_NAME : product.php   FILE_PATH : /var/www/multishop/trunk/store/product.php
 * ....商铺标签列表
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Sat Jun 21 14:18:38 CST 2008
 */

require_once("../global.inc.php");

class StoreTagClass extends StoreFrameWork{
	/**
	 * 2级域名对象
	 *
	 * @var obj
	 */
	var $obj_domain;
	/**
	 * 店铺信息
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 店铺标签
	 *
	 * @var object
	 */
	var $obj_shoptag;

	function main(){
		/**
		 * 初始化域名解析类
		 */
		if (!is_object($this->obj_domain)){
			require_once("domain.class.php");
			$this->obj_domain = new Domain();
		}
		/**
		 * 实例化店铺类
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 实例化店铺标签类
		 */
		if (!is_object($this->obj_shoptag)) {
			include_once("shoptag.class.php");
			$this->obj_shoptag = new ShopTag ();
		}

		//获取店铺信息 $this->shop
		$this->check_shop();

		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("store");
		/**
		 * 语言包
		 */
		$this->getlang("store,store_control");

        /**
         * 将get值（tag）赋予模板变量get_tag_id
         */
        $this->output('get_tag_id',intval($this->_input['tag']));
        $this->_set_current_nav();

		$this->_list();
	}

	/**
	 * 商品列表显示
	 */
	function _list(){
		//获取店铺信息 $this->shop
		$this->check_shop();

		//店铺标签导航
		$tag_array = $this->obj_shoptag->getOneTag ($this->_input['tag'],'tag_content');
		$this->output('tag_array',$tag_array);
		$this->output('arrBlog',$arr);
		$this->output('member_id',$this->shop_array['member_id']);
		$this->output('shop_url',$shop_array['shop_link']);
		$this->output('view_type',$view_type);

		if ($this->shop['templates'] == '0'){//现有模板
			/**
			 * 页面输出
			 */
			$this->showpage('store_tag.default');
		}else {
			//自定义风格内容
			$this->_get_diy_style();
			/**
			 * 页面输出
			 */
			$this->showpage("store_tag");
		}
	}
}

$tag = new StoreTagClass();
$tag->main();
unset($tag);
?>