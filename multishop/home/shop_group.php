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
 * FILE_NAME : shop.php   FILE_PATH : \multishop\home\shop_group.php
 * ....商城团购首页显示程序
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Sep 26 11:22:48 CST 2010
 */

require ("../global.inc.php");

class ShowShopGroup extends CommonFrameWork {
	/**
	 * 创建商品对象
	 *
	 * @var obj
	 */
	var $obj_product;

	function main() {
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("shop_group");
		/**
		 * 执行操作
		 */
		switch ($this->_input['action']) {
			default:
				$this->_showshopgroup();
		}
	}
	/**
	 * 显示团购主题页面
	 *
	 * @param 
	 * @param 
	 * @return 
	 */
	function _showshopgroup() {
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 设置团购商品查询参数
		 */
		$obj_condition['sell_type'] = '2';
		$obj_condition['order'] = 1;
		$obj_condition['sorttype'] = 1;
		$this->obj_page->pagebarnum(4);
		/**
		 * 取得团购商品列表
		 */
		$product_group_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		unset($obj_condition);
		/**
		 * 设置即将结束商品查询参数
		 */
		$obj_condition['sell_type'] = "2";
		$obj_condition['order'] = 1;
		$obj_condition['sorttype'] = 1;
		$this->obj_page->pagebarnum(8);
		/**
		 * 取得即将结束商品列表
		 */
		$product_end_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		/**
		 * 即将结束商品
		 */
		foreach ($product_end_array as $k1 => $v1) {
			//剩余时间计算
			$left_time = $v1['p_end_time'] - time();
			if ($left_time > 0){
				$v1['left_days'] = intval($left_time / (24*60*60));
				$v1['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
				$v1['left_minutes'] = intval((($left_time % (60*60))) / 60);
				$v1['left_second'] = intval($left_time % 60);
				$product_end_array[$k1]['p_left_time'] = $v1['left_days'].$this->_lang['langPday'].$v1['left_hours'].$this->_lang['langPhour'].$v1['left_minutes'].$this->_lang['langPminute'].$v1['left_second'].$this->_lang['langPsecond'];
			}else {
				$product_end_array[$k1]['p_left_time'] = $this->_lang['langPGroupEnd'];
			}
		}
		unset($obj_condition);
		/**
		 * 设置活动资讯列表查询参数
		 */
		$obj_condition['sell_type'] = "2";
		$obj_condition['order'] = 5;//排序方式待定
		$this->obj_page->pagebarnum(8);
		/**
		 * 取得活动资讯商品列表
		 */
		$product_activity_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		unset($obj_condition);
		/**
		 * 右侧专题大图商品显示
		 */
		$obj_condition = array();
		$product_list = array();
		$obj_condition['sell_type'] = '2';
		$obj_condition['p_topics_show'] = '1';
		$product_list = $this->obj_product->getProductList($obj_condition, $page);
		$top_product = $product_list[0];
		unset($obj_condition,$product_list);
		/**
		 * 右侧专题商品扩展信息
		 */
		$ex_top_product = array();
		$ex_top_product = $this->obj_product->getProductGroupRow($top_product['p_code']);
		/**
		 * 调用大图设置
		 */
		require_once('settings.class.php');
		$obj_settings = new SettingsClass();
		/**
		 * 取配置信息中的竞拍专题大图
		 */
		$tmp = unserialize($obj_settings->getSettings('topics_group_pic'));
		$top_product['topics_pic'] = $tmp['pic'];
		/**
		 * 取模板广告图
		 */
		/**
		 * 第一横幅
		 */
		$topics_group_banner1 = unserialize($obj_settings->getSettings('topics_group_banner1'));
		/**
		 * 第二横幅
		 */
		$topics_group_banner2 = unserialize($obj_settings->getSettings('topics_group_banner2'));
		/**
		 * 第一右侧
		 */
		$topics_group_right1 = unserialize($obj_settings->getSettings('topics_group_right1'));
		/**
		 * 第二右侧
		 */
		$topics_group_right2 = unserialize($obj_settings->getSettings('topics_group_right2'));
		/**
		 * 广告幻灯片
		 */
		$topics_group_slide = unserialize($obj_settings->getSettings('topics_group_slide'));	
		/**
		 * 团购活动资讯
		 */
		include_once("news.class.php");
		$obj_news = new NewsClass();
		$news_array = array();
		$condition = array();
		$condition['news_c_id'] = '14';
		$condition['order_by'] = 'news_time_desc';
		$condition['line_num'] = '5';
		$news_array = $obj_news->listNews($condition,$obj_page);
		if (is_array($news_array)) {
			foreach ($news_array as $k => $v) {
				/**
				 * 标题截取
				 */
				$news_array[$k]['news_title_cut'] = Common::cutstr($v['news_title'],'30',$this->_configinfo['websit']['ncharset']);
				/**
				 * 链接判断
				 */
				if ($v['news_jump_url'] != '') {
					$news_array[$k]['news_href'] = $v['news_jump_url'];
				} else {
					$news_array[$k]['news_href'] = $this->_configinfo['websit']['site_url'] . "/home/news.php?id=" . $v['news_id'];
				}
			}
		}
		unset($condition);				
		/**
		 * 页面显示
		 */
		$this->output("title_message",$this->_lang['langCCamel'].' - ');
		$this->output('product_group_array', $product_group_array);
		$this->output('product_end_array', $product_end_array);
		$this->output('product_activity_array', $product_activity_array);
		$this->output("top_product", $top_product);
		$this->output("ex_top_product", $ex_top_product);
		$this->output('topics_group_banner1',$topics_group_banner1);
		$this->output('topics_group_banner2',$topics_group_banner2);
		$this->output('topics_group_right1',$topics_group_right1);
		$this->output('topics_group_right2',$topics_group_right2);
		$this->output('topics_group_slide',$topics_group_slide);		
		$this->output('sel_page','camel');
		$this->output("news_array", $news_array);
		$this->showpage('shop_group');
	}
}
$shop_group = new ShowShopGroup();
$shop_group->main();
unset($shop_group);
?>