<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 网城创想多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME :countdown.php
 * 商城倒计时拍卖首页显示程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 08:28:58 CST 2010
 */

require ("../global.inc.php");

class ShowCountdownIndex extends CommonFrameWork{
	/**
	 * 倒计时拍卖商品对象
	 *
	 * @var obj
	 */
	var $obj_product_countdown;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;	

	function main() {
		/**
		 * 创建倒计时拍卖商品对象
		 */
		if (!is_object($this->obj_product_countdown)){
			require_once("product_countdown.class.php");
			$this->obj_product_countdown = new ProductCountdownClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}		
		/**
		 * 设置模版路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("product_countdown");
		/**
		 * 执行操作
		 */
		switch ($this->_input['action']) {
			default:
				$this->_show_countdown_index();
		}
	}
	/**
	 * 显示倒计时拍卖首页
	 */
	function _show_countdown_index() {
		/**
		 * 最新拍卖商品
		 */
		$condition = array();
		$condition['index_order'] = 'index_new';
		$condition['order'] = 'no';
		$condition['limit_num'] = 4;
		$product_new = $this->obj_product_countdown->getProductList($condition, $obj_page,'index');
		$product_new = $this->_deal_title($product_new);
		unset($condition);
		/**
		 * 即将结束商品
		 */
		$condition = array();
		$condition['index_order'] = 'index_end';
		$condition['order'] = 'no';
		$condition['limit_num'] = 8;
		$product_end = $this->obj_product_countdown->getProductList($condition, $obj_page,'index');
		$product_end = $this->_deal_title($product_end);
		if (is_array($product_end)) {
			foreach ($product_end as $k => $v) {
				$product_end[$k]['cp_end_time'] = $v['cp_end_time'] - time();
			}
		}
		unset($condition);
		/**
		 * 热拍商品
		 */
		$condition = array();
		$condition['index_order'] = 'index_hot';
		$condition['order'] = 'no';
		$condition['limit_num'] = 10;		
		$product_hot = $this->obj_product_countdown->getProductList($condition, $obj_page,'index');	
		$product_hot = $this->_deal_title($product_hot);
		unset($condition);	
		/**
		 * 右侧专题大图商品显示
		 */
		$condition = array();
		$product_list = array();
		$top_product = array();
		$condition['sell_type'] = '3';
		$condition['p_topics_show'] = '1';
		$product_list = $this->obj_product->getProductList($condition, $page);
		$top_product = $product_list[0];
		unset($condition,$product_list);
		/**
		 * 右侧专题商品扩展表信息
		 */
		$ex_top_product = array();
		$ex_top_product = $this->obj_product_countdown->getProductRow($top_product['p_code']);	
		/**
		 * 右侧专题商品结束时间
		 */
		$ex_top_product['cp_end_time'] = $ex_top_product['cp_end_time'] - time();
		/**
		 * 调用大图设置
		 */
		require_once('settings.class.php');
		$obj_settings = new SettingsClass();
		/**
		 * 取配置信息中的倒计时拍卖专题大图
		 */
		$tmp = unserialize($obj_settings->getSettings('topics_countdown_pic'));
		$top_product['topics_pic'] = $tmp['pic'];
		/**
		 * 取模板广告图
		 */
		/**
		 * 第一横幅
		 */
		$topics_countdown_banner1 = unserialize($obj_settings->getSettings('topics_countdown_banner1'));
		/**
		 * 第二横幅
		 */
		$topics_countdown_banner2 = unserialize($obj_settings->getSettings('topics_countdown_banner2'));
		/**
		 * 第一右侧
		 */
		$topics_countdown_right1 = unserialize($obj_settings->getSettings('topics_countdown_right1'));
		/**
		 * 第二右侧
		 */
		$topics_countdown_right2 = unserialize($obj_settings->getSettings('topics_countdown_right2'));
		/**
		 * 广告幻灯片
		 */
		$topics_countdown_slide = unserialize($obj_settings->getSettings('topics_countdown_slide'));	
		/**
		 * 倒计时拍卖活动资讯
		 */
		include_once("news.class.php");
		$obj_news = new NewsClass();
		$news_array = array();
		$condition = array();
		$condition['news_c_id'] = '15';
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
		 * 页面输出
		 */
		$this->output("title_message",$this->_lang['langCYiyuanPai'].' - ');
		$this->output("product_new",$product_new);
		$this->output("product_end",$product_end);
		$this->output("product_hot",$product_hot);
		$this->output("top_product", $top_product);
		$this->output("ex_top_product", $ex_top_product);
		$this->output('topics_countdown_banner1',$topics_countdown_banner1);
		$this->output('topics_countdown_banner2',$topics_countdown_banner2);
		$this->output('topics_countdown_right1',$topics_countdown_right1);
		$this->output('topics_countdown_right2',$topics_countdown_right2);
		$this->output('topics_countdown_slide',$topics_countdown_slide);		
		$this->output("sel_page", "countdown");
		$this->output("news_array", $news_array);
		$this->showpage("countdown.index");
	}
	/**
	 * 商品信息处理
	 *
	 * @param array $arr
	 * @return array
	 */
	function _deal_title($arr) {
		if (is_array($arr)) {
			foreach ($arr as $k => $v) {
				$arr[$k]['p_cur_name'] = Common::cutstr($v['p_name'],35);
			}
		}
		return $arr;
	}
}
$countdown = new ShowCountdownIndex();
$countdown->main();
unset($countdown);
?>