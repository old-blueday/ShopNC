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
 * FILE_NAME :own_countdown_bid.php
 * 倒计时拍卖竞拍中的宝贝管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 08:27:24 CST 2010
 */

require ("../global.inc.php");
class OwnCountdownBid extends memberFrameWork{
	/**
	 * 倒计时拍卖竞拍对象
	 *
	 * @var object
	 */
	var $obj_bid;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;	
	
	function main() {
		/**
		 * 实例化倒计时拍卖竞拍对象
		 */
		if (!is_object($this->obj_bid)) {
			include_once("bid_countdown.class.php");
			$this->obj_bid = new BidCountdownClass();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('buyer','my_buyer','countdown_buy_bid');		
		/**
		 * 加载语言包
		 */
		$this->getlang("product_countdown");
		switch ($this->_input['action']) {
			case 'list':
				$this->_list();
				break;
			default:
				$this->_list();
		}
	}
	/**
	 * 竞拍中的宝贝列表
	 *
	 */
	function _list() {
		/**
		 * 更新竞拍结束的商品(生成订单)
		 */
		include_once("order_process_countdown.class.php");
		$obj_process_countdown = new OrderProcessCountdown();
		$obj_process_countdown->updateProductOrderConutdown();			
		/**
		 * 获取竞拍数据
		 */
		$this->obj_page->pagebarnum(20);
		$bid_array = $this->obj_bid->getBidList($_SESSION['s_login']['id'],$this->obj_page);
		if (is_array($bid_array)) {
			foreach ($bid_array as $k => $v) {
				$bid_array[$k]['cb_state'] = $this->_b_config['bid_state'][$v['cb_state']];
				$bid_array[$k]['cb_time'] = @date("Y-m-d H:i",$v['cb_time']);
			}
		}
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');	
		/**
		 * 页面显示
		 */
		$this->output("bid_array",$bid_array);
		$this->output("page_list",$page_list);
		$this->showpage("own_countdown_bid");
	}
}
$countdown = new OwnCountdownBid();
$countdown->main();
unset($countdown);
?>