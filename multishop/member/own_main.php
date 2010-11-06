<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_main.php   FILE_PATH : E:\www\multishop\trunk\member\own_main.php
 * 会员后台首页
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Mar 01 02:28:56 GMT 2010
 */

require ("../global.inc.php");

class OwnMain extends memberFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;	
	/**
	 * 商铺留言对象
	 *
	 * @var obj
	 */
	var $obj_shopmessage;	
	/**
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;	
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;	
	/**
	 * 店铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;	
	/**
	 * 用户组对象
	 *
	 * @var obj
	 */
	var $obj_member_group;				
		
	function main()
	{
		/**
         * 创建会员对象
         */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_shopmessage)){
			require_once("shopmessage.class.php");
			$this->obj_shopmessage = new ShopMessageClass();
		}		
		/**
         * 创建商品订单对象
         */
		if (!is_object($this->obj_product_order)){
			require_once ("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
         * 创建商品对象
         */
		if (!is_object($this->obj_product)){
			require_once ("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
         * 创建商铺对象
         */
		if (!is_object($this->obj_shop)){
			require_once ("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
         * 创建用户组对象
         */
		if (!is_object($this->obj_member_group)){
			require_once('member_group.class.php');
			$this->obj_member_group = new MemberGroupClass();
		}
		/**
         * 语言包
         */
		$this->getlang("own_main");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('buyer');

		//得到会员资料
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition, '*', 'more');
		$member_array['last_login_time'] = @date("Y", $member_array['last_login_time']).$this->_lang['langMainYear'].@date("m", $member_array['last_login_time']).$this->_lang['langMainMonth'].@date("d", $member_array['last_login_time']).$this->_lang['langMainDate']."  ".@date("H:i:s", $member_array['last_login_time']);
		if ($member_array['mg_id'] != ''){
			//查找用户组
			$group_row = $this->obj_member_group->getMemberGroupRow($member_array['mg_id']);
			$member_array['group_name'] = $group_row['mg_name'];
			//星星数
			$line = '';
			for ($i=0;$i<$group_row['mg_stars'];$i++){
				$line .= "<img src='". $this->_configinfo['websit']['site_url'].'/templates/member/images/star.gif'."'>";
			}
			$member_array['group_star'] = $line;
		}
		//买卖家信用信息
		$buy_score_level = $this->obj_member->creditLevel($member_array['buy_score']);
		$sell_score_level = $this->obj_member->creditLevel($member_array['sale_score']);	
		//卖家缴费
		if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
			if (($member_array['shop_availability_time']-time()) > 0)
			{//取还可以使用的天数
				$use_day_num = intval(($member_array['shop_availability_time']-time())/(24*60*60));
			}
			//店铺使用时间
			$member_array['shop_availability_time'] = $member_array['shop_availability_time']?@date('Y-m-d', $member_array['shop_availability_time']):$this->_lang['langMainShopPayLess'];
			//取上架商品数量
			$obj_condition['member'] = $_SESSION['s_login']['id'];
			$product_array = $this->obj_product->getProductList($obj_condition, $obj_page);
			unset ($obj_condition);
		}
		
		/**
		 * 该会员的所有订单
		 */
		$obj_condition_order = array();
		$obj_condition_order['member_id'] = $_SESSION['s_login']['id'];
		$order_array = $this->obj_product_order->getProductOrderList($obj_condition_order, $obj_page, 'sp_id,sp_state,buyer_id,seller_id,sold_time');
		/**
		 * 买家提醒区
		 */		
		//统计待付款
		$buyer_awaiting_payment = $this->countOrderNumber ($order_array, array('0') , 'bought' );
		//统计确认待收货
		$buyer_confirm_receipt = $this->countOrderNumber ( $order_array, array('2') , 'bought' );
		//统计待评价
		$buyer_awaiting_evaluation = $this->countOrderNumber ( $order_array, array('3') , 'bought' );		
		//统计三个月买入
		$buyer_three_month = $this->countOrderNumber ( $order_array, array('0','1','3') , 'bought' , 90 );	
		/**
		 * 卖家提醒区
		 */
		//统计待发货
		$seller_awaiting_shipment = $this->countOrderNumber ( $order_array, array('1') , 'sold');	
		//统计未付款
		$seller_no_payment = $this->countOrderNumber ( $order_array, array('0') , 'sold' );
		//统计待评价
		$seller_awaiting_evaluation = $this->countOrderNumber ( $order_array, array('3') , 'sold' );
		/**
         * 更新商品数量，橱窗推荐数
         */
		$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'recommend');
		//店铺信息
		$shop_array = $this->obj_shop->getOneShopByMemeberId($_SESSION['s_login']['id'], '1','*');
		$shop_array['lang_audit_state'] = $this->_b_config['auditstate'][$shop_array['audit_state']];
		//店铺留言数量
		$message_number = 0;
		if ( $_SESSION['s_shop']['id'] != '' ) {
			$message_number = $this->obj_shopmessage->countMessageNumber( $_SESSION['s_shop']['id'] , $_SESSION['s_login']['name'] );
		}
		/**
         * 页面输出
         */
		$this->output('member_array', $member_array);
		$this->output("member_info", $_SESSION['s_login']);
		$this->output("seller_awaiting_shipment", $seller_awaiting_shipment);
		$this->output("seller_no_payment", $seller_no_payment);
		$this->output("seller_awaiting_evaluation", $seller_awaiting_evaluation);
		$this->output("message_number", $message_number);		
		$this->output("buyer_awaiting_payment", $buyer_awaiting_payment);
		$this->output("buyer_confirm_receipt", $buyer_confirm_receipt);
		$this->output("buyer_awaiting_evaluation", $buyer_awaiting_evaluation);
		$this->output("buyer_three_month", $buyer_three_month);
		$this->output('buy_score_level', $buy_score_level);
		$this->output('sell_score_level', $sell_score_level);
		$this->output('lang_audit_state', $shop_array['lang_audit_state']);
		$this->output('audit_state', $shop_array['audit_state']);
		$this->output('shop_ischeck', $shop_array['ischeck']);
		$this->output('shop_ifdel', $shop_array['if_del']);
		$this->output('nonce_pay_mode', $this->_configinfo['paymode']['shop_pay_mode']);
		$this->output('use_day_num', $use_day_num);
		$this->output('product_count', count($product_array));
		$this->output('now_time', date('Y-m-d'));
		$this->showpage("own_main");
	}
	
	/**
	 * 统计符合条件的订单数量
	 *
	 * @param array $order_array 该会员的订单列表
	 * @param array $order_state_type 订单状态
	 * @param string $member_type 会员类别 买家或卖家
	 * @param int/string $day_num 多少天之内的订单，no为不限制天数
	 * @return int 订单数量
	 */
	function countOrderNumber ($order_array, $order_state_type = array('0') , $member_type = 'sold', $day_num = 'no' ) {
		/**
		 * 符合要求的订单数量
		 */
		$num = 0;
		/**
		 * 订单会员类别
		 */
		switch ($member_type){
			case 'sold':
				$member_id_field = 'seller_id';
				break;
			case 'bought':
				$member_id_field = 'buyer_id';
				break;
		}
		/**
		 * 对于订单时间的要求
		 */
		if ($day_num != 'no'){
			$time = time()-$day_num*24*60*60;
		}
		if (is_array($order_array)){
			foreach ($order_array as $k => $v){
				/**
				 * 订单状态
				 */
				if (in_array($v['sp_state'],$order_state_type) && $v[$member_id_field] == $_SESSION['s_login']['id']){
					/**
					 * 有时间范围的
					 */
					if ($day_num != 'no'){
						if ($v['sold_time'] > $time){
							$num++;
						}
					}else {
						/**
						 * 没有时间范围的
						 */
						$num++;
					}
				}
			}
			return $num;
		}else {
			return false;
		}
	}
}
$o_main = new OwnMain();
$o_main->main();
unset ($o_main);
?>
