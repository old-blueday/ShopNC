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
 * FILE_NAME : own_statics.php   FILE_PATH : E:\www\multishop\trunk\member\own_statics.php
 * ....卖家统计
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Dec 22 14:42:41 CST 2008
 */

require_once("../global.inc.php");
class MemberStatics extends memberFrameWork {
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 商品订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	
	function main(){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("own_statics");

		switch ($this->_input['action']){
			case "member":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','seller_statics','seller_statics_member');
				
				$this->_member();
				break;
			case "order":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','seller_statics','seller_statics_order');
				
				$this->_order();
				break;
			case "product":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','seller_statics','seller_statics_product');
				
				$this->_product();
				break;
		}
	}
	
	/**
	 * 客户统计
	 * 
	 * 统计内容：
	 * 购买人数
	 * 购买次数最多的
	 * 完成购买次数最多的
	 * 
	 * 
	 */
	function _member(){
		/**
		 * 购买次数最多的，对于买家id的记录数组 键值为买家会员ID 值为array('login_name'=>'','num'=>'');
		 */
		$check_buyer_array = array();
		/**
		 * 完成购买次数最多的，对于买家id的记录数组 键值为买家会员ID 值为array('login_name'=>'','num'=>'');
		 */
		$check_achieve_buyer_array = array();
		/**
		 * 该卖家的所有订单
		 */
		$obj_condition['seller_id'] = $_SESSION['s_login']['id'];
		$order_array = $this->obj_product_order->getProductOrderList($obj_condition, $obj_page);
		//购买人数
		$buyer_num = count($order_array);
		if (is_array($order_array)){
			foreach ($order_array as $k => $v){
				/**
				 * 购买次数最多的
				 */
				/**
				 * 没有该买家，则新增进行记录
				 */
				if ($check_buyer_array[$v['buyer_id']] == ''){
					$check_buyer_array[$v['buyer_id']] = array(
																'login_name'=>$v['buyer_name'],
																'num'=>1
															);
				}else {
					$check_buyer_array[$v['buyer_id']]['num']++;
				}
				/**
				 * 完成购买次数最多的
				 */
				if ($v['state'] == '3'){
					/**
					 * 没有该买家，则新增进行记录
					 */
					if ($check_achieve_buyer_array[$v['buyer_id']] == ''){
						$check_achieve_buyer_array[$v['buyer_id']] = array(
																	'login_name'=>$v['buyer_name'],
																	'num'=>1
																);
					}else {
						$check_achieve_buyer_array[$v['buyer_id']]['num']++;
					}
				}
			}
		}
		/**
		 * 购买次数最多的
		 */
		$tmp = 0;
		$tmp_array = array();
		foreach ($check_buyer_array as $k => $v){
			if ($v['num'] > $tmp){
				$tmp = $v['num'];
				$tmp_array = $v;
				$tmp_array['member_id'] = $k;
			}
		}
		$most_buy_num = $tmp;
		if (!empty($tmp_array)){
			if ($tmp_array['login_name'] != ''){
				$most_buy_member = $tmp_array;
			}else {
				$condition_member ['id'] = $tmp_array['member_id'];
				$most_buy_member = $this->obj_member->getMemberInfo ( $condition_member );
				unset($condition_member);
			}
		}
		/**
		 * 完成购买次数最多的
		 */
		$tmp = 0;
		$tmp_array = array();
		foreach ($check_achieve_buyer_array as $k => $v){
			if ($v['num'] > $tmp){
				$tmp = $v['num'];
				$tmp_array = $v;
				$tmp_array['member_id'] = $k;
			}
		}
		$achieve_most_buy_num = $tmp;
		if (!empty($tmp_array)){
			if ($tmp_array['login_name'] != ''){
				$achieve_most_buy_member = $tmp_array;
			}else {
				$condition_member ['id'] = $tmp_array['member_id'];
				$achieve_most_buy_member = $this->obj_member->getMemberInfo ( $condition_member );
				unset($condition_member);
			}
		}
		/**
		 * 页面输出
		 */
		$this->output("buyer_num",$buyer_num);//购买人数
		$this->output("most_buy_member",$most_buy_member);//购买次数最多的
		$this->output("achieve_most_buy_member",$achieve_most_buy_member);//完成购买次数最多的
		$this->output("most_buy_num",$most_buy_num);//最多的次数
		$this->output("achieve_most_buy_num",$achieve_most_buy_num);//完成购买最多的次数
		$this->showpage("own_statics.member");
	}
	
	/**
	 * 订单统计
	 */
	function _order(){
		//会员名
		if ($this->_input['search_buyer_name'] != ''){
			$condition ['member_name'] = $this->_input ['search_buyer_name'];
			$member_info = $this->obj_member->getMemberInfo ( $condition );
			if (! empty ( $member_info )) {
				$obj_condition['buyer_id'] = $member_info['member_id'];
			}else {
				$obj_condition['buyer_id'] = '0';
			}
			unset ( $condition );
		}
		//时间段
		if ($this->_input ['start_time'] != "") {
			$time = @explode ( '-', $this->_input ['start_time'] );
			$obj_condition['start_time'] = @mktime ( 0, 0, 0, $time [1], $time [2], $time [0] );
			unset($time);
			$obj_condition['search_time'] = 1;
		}else {
			$obj_condition['start_time'] = @mktime ( 0, 0, 0, 1, 1, 1970 );
		}
		if ($this->_input ['end_time'] != "") {
			$time = @explode ( '-', $this->_input ['end_time'] );
			$obj_condition['end_time'] = @mktime ( 0, 0, 0, $time [1], $time [2], $time [0] );
			unset($time);
			$obj_condition['search_time'] = 1;
		}else {
			$obj_condition['end_time'] = time();
		}
		//订单列表
		$obj_condition['seller_id'] = $_SESSION['s_login']['id'];
		$order_array = $this->obj_product_order->getProductOrderList($obj_condition, $obj_page);
		//订单总数
		$order_total = count($order_array);
		//每种状态的订单数量
		$order_state_zero = 0;//0已购买
		$order_state_one = 0;//1已支付
		$order_state_two = 0;//2已发货
		$order_state_three = 0;//3已收货
		$order_state_four = 0;//4团购中
		$order_state_five = 0;//5团购失败
		$order_state_six = 0;//6交易失败
		if (is_array($order_array)){
			foreach ($order_array as $k => $v){
				switch ($v['sp_state']){
					case '0':
						$order_state_zero++;
						break;
					case '1':
						$order_state_one++;
						break;
					case '2':
						$order_state_two++;
						break;
					case '3':
						$order_state_three++;
						break;
					case '4':
						$order_state_four++;
						break;
					case '5':
						$order_state_five++;
						break;
					case '6':
						$order_state_six++;
						break;
				}
			}
		}
		
		/**
		 * 页面输出
		 */
		$this->output("order_total",$order_total);//订单总数
		$this->output("order_state_zero",$order_state_zero);
		$this->output("order_state_one",$order_state_one);
		$this->output("order_state_two",$order_state_two);
		$this->output("order_state_three",$order_state_three);
		$this->output("order_state_four",$order_state_four);
		$this->output("order_state_five",$order_state_five);
		$this->output("order_state_six",$order_state_six);
		$this->output("condition",$this->_input);
		$this->showpage("own_statics.order");
	}
	
	/**
	 * 商品统计
	 */
	function _product(){
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		//检索条件
		$obj_condition['member'] = $_SESSION['s_login']['id'];
		$obj_condition['state'] = 'none';//所有商品，包括上架和下架的
		//排序
		if ($this->_input['sel_type'] != ''){
			switch ($this->_input['sel_type']){
				case "end_time_desc":
					$obj_condition['order'] = '1';
					$obj_condition['sorttype'] = '';
					break;
				case "storage_asc":
					$obj_condition['order'] = 'p_storage';
					$obj_condition['sorttype'] = '1';
					break;
				case "price_asc":
					$obj_condition['order'] = '2';
					$obj_condition['sorttype'] = '1';
					break;
				case "view_num_asc":
					$obj_condition['order'] = 'p_view_num';
					$obj_condition['sorttype'] = '1';
					break;
				case "sold_num_asc":
					$obj_condition['order'] = '4';
					$obj_condition['sorttype'] = '1';
					break;
				case "sold_sum_asc":
					$obj_condition['order'] = 'p_sold_sum';
					$obj_condition['sorttype'] = '1';
					break;
			}
		}
		$this->obj_page->pagebarnum(20);
		$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		if (is_array($product_array)) {
			foreach ($product_array as $k => $v) {
				$site_url = "";
				$site_url = $this->_configinfo['websit']['site_url'];
				switch ($v['p_sell_type']) {
					case '0':
						$product_array[$k]['product_url'] = $site_url . "/home/product_auction.php?action=view&p_code=" . $v['p_code'];
						break;
					case '1':
						$product_array[$k]['product_url'] = $site_url . "/home/product_fixprice.php?action=view&p_code=" . $v['p_code'];
						break;	
					case '2':
						$product_array[$k]['product_url'] = $site_url . "/home/product_group.php?action=view&p_code=" . $v['p_code'];
						break;		
					case '3':
						$product_array[$k]['product_url'] = $site_url . "/home/product_countdown.php?action=view&pid=" . $v['p_code'];
						break;																	
				}
			}
		}
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		/**
		 * 页面输出
		 */
		$this->output("product_array",$product_array);
		$this->output("page_list",$page_list);
		$this->output("condition",$this->_input);
		$this->showpage("own_statics.product");
	}
}
$member_statics = new MemberStatics();
$member_statics->main();
unset($member_statics);
?>