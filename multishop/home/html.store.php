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
 * FILE_NAME : html.store.php   FILE_PATH : E:\www\multishop\trunk\home\html.store.php
 * ....生成静态 --- 商店
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Aug 28 15:47:22 CST 2008
 */

require ("../global.inc.php");

class HtmlStoreManage extends CommonFrameWork{
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	
	/**
	 * php5构造函数
	 */
	function __construct(){
		$this->HtmlStoreManage();
	}
	
	/**
	 * php4构造函数
	 */
	function HtmlStoreManage(){
		/**
		 * 执行父类的构造函数
		 */
		parent::CommonFrameWork();
		/**
		 * 初始化商铺类
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("store");
		/**
		 * 语言包
		 */
		$this->getlang("store_control");
	}
	
	/**
	 * 主方法
	 */
	function main(){
		switch($this->_input['action']){
			case "make_store_html":
				$this->_make_store_html();
				break;
		}
	}
	
	/**
	 * 生成商店静态页面
	 */
	function _make_store_html($shop_id=''){
		$shop_id = $shop_id?$shop_id:$this->_input['shop_id'];
		if (intval($shop_id) <= 0){
			return $this->_lang['langStoreIDIsVoid'];
		}
		//商铺信息
		$shop_array = $this->obj_shop->getOneShop($shop_id,'1');
		$arr = unserialize($shop_array['shop_style']);
		
		//左边显示
		if ($arr['slayout'] == '2') {
			//页面显示的版区
			$side_template = explode(',',$arr['choiceblockleft']);
			$main_template = explode(',',$arr['choiceblockmain']);
			//抛出左边版区
			$this->output('side_template',$side_template);
			$this->output('main_template',$main_template);
		}else if ($arr['slayout'] == '0') {//右边显示
			//初始化页面内容
			$side_template  = explode(',',$arr['choiceblockright']);
			$main_template  = explode(',',$arr['choiceblockmain']);
			//抛出右边版区
			$this->output('side_template',$side_template);
			$this->output('main_template',$main_template);
		}else if ($arr['slayout'] == '-1') {//两端显示
			//页面显示的版区
			$left_template = explode(',',$arr['choiceblockleft']);
			$right_template = explode(',',$arr['choiceblockright']);
			$main_template = explode(',',$arr['choiceblockmain']);
			//合并左右两边数组
			$side_template_merge = array_merge($left_template,$right_template);
			$side_template = array();
			if (is_array($side_template_merge)){
				foreach ($side_template_merge as $value) {
					$side_template[] = $value;
				}
			}
			//抛出左边版区
			$this->output('left_template',$left_template);
			$this->output('right_template',$right_template);
			$this->output('main_template',$main_template);
			$this->output('side_template',$side_template);
		}else {
			$arr['slayout'] = 2;
		}
		/**
		 * 页面输出
		 */
		//添加title,keyword信息
		$this->output('title_message', $shop_array['shop_name'].' - ');
		$this->output('keyword_message', ','.$shop_array['shop_name']);
		$this->output('arrBlog',$arr);
		$this->output('shop_array', $shop_array);
		$this->output('member_id',$shop_array['member_id']);
		$this->output('shop_url',$shop_array['shop_link']);
		$html = $this->fetchpage('store_index_temp');
		$file_name = BasePath.'/html/store/'.$shop_array['member_id'].'.html';
		//删除原来的店铺模板
		@unlink($file_name);
		//生成静态
		require_once("makehtml.class.php");
		if (MakeHtml::tohtmlfile($file_name, $html)){
			return true;
		}else {
			return $this->_lang['langStoreControlCreateLostFile'];
		}
	}
}
?>