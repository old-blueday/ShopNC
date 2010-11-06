<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////


/**
 * FILE_NAME : own_order.php   FILE_PATH : \multishop\member\own_order.php
 * ....商品订单管理功能
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Tue Aug 28 15:51:41 CST 2007
 */
require_once ("../global.inc.php");

class OwnProductOrderManage extends memberFrameWork {
	/**
	 * 商品订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
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
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 支付对象
	 *
	 * @var obj
	 */
	var $obj_payment;
	/**
	 * 收货地址
	 *
	 * @var obj
	 */
	var $obj_receive;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 预存款对象对象
	 *
	 * @var obj
	 */
	var $obj_predeposit;
	/**
	 * 外汇对象
	 *
	 * @var obj
	 */
	var $obj_exchange;

	function main() {
		/**
		 * 创建商品订单对象
		 */
		if (! is_object ( $this->obj_product_order )) {
			require_once ("order.class.php");
			$this->obj_product_order = new ProductOrderClass ( );
		}
		/**
		 * 创建验证对象
		 */
		if (! is_object ( $this->objvalidate )) {
			require_once ("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate ( );
		}

		/**
		 * 实例化商品类
		 */
		if (! is_object ( $this->obj_product )) {
			require_once ("product.class.php");
			$this->obj_product = new ProductClass ( );
		}

		/**
		 * 支付对象
		 */
		if (! is_object ( $this->obj_payment )) {
			require_once ("payment.class.php");
			$this->obj_payment = new PaymentClass ( );
		}

		/**
		 * 收货对象
		 */
		if (! is_object ( $this->obj_receive )) {
			require_once ("receive.class.php");
			$this->obj_receive = new ReceiveClass ( );
		}

		/**
		 * 分页对象
		 */
		if (! is_object ( $this->obj_page )) {
			require_once ("commonpage.class.php");
			$this->obj_page = new CommonPage ( );
		}

		/**
		 * 实例化用户类
		 */
		if (! is_object ( $this->obj_member )) {
			require_once ("member.class.php");
			$this->obj_member = new MemberClass ( );
		}
		/**
		 * 语言包
		 */
		$this->getlang ( "own_order" );
		/**
		 * 菜单输出
		 */
		$this->memberMenu('buyer','my_buyer','ready_buy');
		switch ($this->_input ['action']) {
			case "bought" :
				$order_case = "bought";
				$this->_listorder ( $order_case );
				break;
			case "group" :
				$group_state = "group_buying";
				$this->_listgroup ( $group_state );
				break;
			case "group_end" :
				$group_state = "group_end";
				$this->_listgroup ( $group_state );
				break;
			case "sold" :
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','ready_sale');

				$order_case = "sold";
				$this->_listorder ( $order_case );
				break;
			case "payed" :
				$this->_updateproductorderstate ( 1 );
				break;
			case "delived" :
				$this->_updateproductorderstate ( 2 );
				break;
			case "received" :
				$this->_updateproductorderstate ( 3 );
				break;
			case "invoice" :
				$this->_invoice ();
				break;
			case 'invoice_save' :
				$this->_invoice_save ();
				break;
			case "order_receive" :
				$this->_order_receive ();
				break;
			case "pay_success" :
				$this->_pay_success ();
				break;
			case "bid_sel_payment" :
				$this->_bid_sel_payment ();
				break;
			case "bid_sel_payment_save" :
				$this->_bid_sel_payment_save ();
				break;
			case 'show' :
				$this->_show_order_info ( $this->_input ['sp_code'] );
				break;
			case 'offline_pay':
				$this->_offline_pay ();
				break;
			case 'save_offline_pay':
				$this->_save_offline_pay ();
				break;
			case 'predeposit_pay':
				$this->_predeposit_pay ();
				break;
			case 'save_predeposit_pay':
				$this->_save_predeposit_pay ();
				break;
			case 'close':
				$this->_close();
				break;
			case 'close_save':
				$this->_close_save();
				break;
			case 'save_postage':
				$this->_save_postage();
				break;
			case 'refund_add':
				$this->_refund_add();
				break;
			case 'refund_save':
				$this->_refund_save();
				break;
			case 'refund_confirm':
				$type = 'seller';
				$this->_refund_add($type);
				break;
			case 'refund_confirm_save':
				$type = 'seller';
				$this->_refund_save($type);
				break;
			case 'show_refund':
				$this->_show_refund();
				break;
			default :
				$order_case = "bought";
				$this->_listorder ( $order_case );
				break;
		}
	}
	/**
	 * 显示退款详情
	 *
	 */
	function _show_refund() {
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		$refund_state_text = array();
		if ($order_array['seller_id'] == $_SESSION['s_login']['id']) {
			//卖家菜单显示
			$this->memberMenu('seller','my_seller','ready_sale');
			$refund_state_text = array(1=>$this->_lang['langRefundState1'],2=>$this->_lang['langRefundState2'],3=>$this->_lang['langRefundState3']);
			$type = 'seller';
		} else {
			$refund_state_text = array(1=>$this->_lang['langRefundStateBuyer1'],2=>$this->_lang['langRefundStateBuyer2'],3=>$this->_lang['langRefundState3']);
			$type = 'buyer';
		}
		$order_array['refund_state_text'] = $refund_state_text[$order_array['refund_state']];
		$site_url = "";
		$site_url = $this->_configinfo['websit']['site_url'];
		switch ($order_array['sell_type']) {
			case '0'://竞拍
			$order_array['product_href'] = $site_url . "/home/product_auction.php?action=view&p_code=" . $order_array['p_code'];
			break;
			case '1'://一口价
			$order_array['product_href'] = $site_url . "/home/product.php?action=view&pid=" . $order_array['p_code'];
			break;
			case '2'://团购
			$order_array['product_href'] = $site_url . "/home/product_group.php?action=view&pid=" . $order_array['p_code'];
			break;
			case '3'://倒计时拍卖
			$order_array['product_href'] = $site_url . "/home/product_countdown.php?action=view&pid=" . $order_array['p_code'];
			break;
		}
		unset($site_url);		
		/**
		 * 显示页面
		 */
		$this->output('order_array',$order_array);
		$this->output('type',$type);
		$this->output("payment",$this->_b_config['payment']);
		$this->showpage('own_show_refund');
	}

	/**
	 * 退款信息保存
	 *
	 * @param string $type
	 */
	function _refund_save($type='buyer') {
		//初始化买卖家不同的处理信息
		$info_array = array('error' => $this->_lang['langRefundBuyerMessageNoEmpty'],'back' => $this->_lang['langRefundBuyerBack']);
		if ($type == 'seller') {
			$info_array = array( 'error' => $this->_lang['langRefundSellerMessageNoEmpty'],'back' => $this->_lang['langRefundSellerBack']);
		}
		/**
		 * 验证提交信息
		 */
		if ($this->_input['refundConfirm'] == '1') {//同意退款
			$info_array = array( 'back' => $this->_lang['langRefundState3']);
			$this->obj_validate->validateparam = array (array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['langOrderSpcodeEmpty'] ));
		} else {
			$this->obj_validate->validateparam = array (array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['langOrderSpcodeEmpty'] ), array ("input" => $this->_input ["txtMessage"], "require" => "true", "message" => $info_array['error'] ));
		}
		$error = $this->obj_validate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			//取订单信息
			$order_array = $this->obj_product_order->getOneOrderBySpcode( $this->_input ["sp_code"] );
			//判断对应的支付接口文件是否存在 不是预存款的方式
			if ($order_array ['sp_pay_mechod'] != 'predeposit' && (!file_exists ( "../payment/" . $order_array ['sp_pay_mechod'] . "/index.php" ) || !file_exists ("../payment/" . $order_array ['sp_pay_mechod'] . "/payment_module.php"))) {
				$result = "(../payment/" . $order_array ['sp_pay_mechod'] . "/index.php or payment_module.php)" . " is not exists";
				$this->redirectPath ( "error", "", $result );
			}
			//退款(不同意退款)原因
			$value_array = array();
			$value_array['spcode'] = $order_array['sp_code'];
			if ($type == 'seller') {
				$value_array['seller_refund_message'] = $this->_input['txtMessage'];
			} else {
				$value_array['buyer_refund_message'] = $this->_input['txtMessage'];
				$value_array['refund_time']			 = time();
			}
			if ($order_array ['sp_pay_mechod'] == 'predeposit' || $order_array ['sp_pay_mechod'] == 'offline') {
				/**
				 * 非第三方支付
				 */
				//添加退款(不同意退款)原因并直接修改订单状态
				if ($type == 'seller') {
					//退款状态3-退款成功,2-不同意退款
					$value_array['txtRFstate'] = $this->_input['refundConfirm'] == 1 ? 3 : 2;
				} else {
					//买家申请退款
					$value_array['txtRFstate'] = 1;
				}
				//预存款退款(卖家同意退款)
				if ($order_array ['sp_pay_mechod'] == 'predeposit' && $this->_input['refundConfirm'] == '1') {
					/**
					 * 语言包
					 */
					$this->getlang ( "own_predeposit" );
					//对买家帐号进行操作
					$detail_array = array();
					$detail_array['available_predeposit'] = '+'.$order_array ['total_price']; //可用资金
					$detail_array['freeze_predeposit'] = '-'.$order_array ['total_price']; //冻结资金
					$this->obj_member->modifyMember($detail_array,$order_array ['buyer_id'],'predeposit');
					unset($detail_array,$obj_member);
					//记录预存款明细
					require_once ("predeposit.class.php");
					$obj_predeposit = new PredepositClass ( );
					$detail_array = array ();
					$detail_array ['predeposit_type'] = '8'; //卖家退款
					$detail_array ['predeposit_state'] = '1';
					$detail_array ['member_id'] = $order_array['buyer_id'];
					$detail_array ['sp_code'] = $order_array["sp_code"];
					$detail_array ['available_amount'] = '+' . $order_array['total_price'];//可用资金
					$detail_array ['freeze_amount'] = '-' . $order_array['total_price']; //冻结资金
					$detail_array ['system_remark'] = $this->_lang['langPreDetailTypeEight'];
					$detail_array ['create_time'] = time ();
					$detail_array ['update_time'] = time ();
					$detail_array ['payment'] = 'predeposit';
					$obj_predeposit->addPredepositDetail ( $detail_array );
					unset ( $detail_array );
				}
				//对订单操作
				$result = $this->obj_product_order->updateOrderRefundState($value_array);
				$url = $type == 'buyer'? 'member/own_order.php?action=bought' : 'member/own_order.php?action=sold';
				$this->redirectPath ( "succ", $url, $info_array['back'] );
			} else {
				/**
				 * 第三方支付
				 */
				//添加退款(不同意退款)原因
				if ($this->_input['refundConfirm'] == '2') {
					$result = $this->obj_product_order->updateOrderRefundState($value_array);
				}
				//跳转到对应的支付方式页面
				if ($order_array ['sp_pay_mechod'] == 'alipay') {
					$url = $this->_configinfo['websit']['site_url'].'/payment/' . $order_array ['sp_pay_mechod'] . '/index.php?action=refund&sp_code=' . $order_array ['sp_code'];
				} else {
					$url = $this->_configinfo['websit']['site_url'].'/payment/' . $order_array ['sp_pay_mechod'] . '/index.php?sp_code=' . $order_array ['sp_code'];
				}
				@header("Location: $url");
			}
		}
	}
	/**
	 * 退款信息填写
	 *
	 */
	function _refund_add($type='buyer') {
		//菜单选择
		if ($type == 'seller') {
			$this->memberMenu('seller','my_seller','ready_sale');
		}
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		$site_url = "";
		$site_url = $this->_configinfo['websit']['site_url'];
		switch ($order_array['sell_type']) {
			case '0'://竞拍
			$order_array['product_href'] = $site_url . "/home/product_auction.php?action=view&p_code=" . $order_array['p_code'];
			break;
			case '1'://一口价
			$order_array['product_href'] = $site_url . "/home/product.php?action=view&pid=" . $order_array['p_code'];
			break;
			case '2'://团购
			$order_array['product_href'] = $site_url . "/home/product_group.php?action=view&pid=" . $order_array['p_code'];
			break;
			case '3'://倒计时拍卖
			$order_array['product_href'] = $site_url . "/home/product_countdown.php?action=view&pid=" . $order_array['p_code'];
			break;
		}
		unset($site_url);			
		/**
		 * 页面显示
		 */
		$this->output("order_array",$order_array);
		$this->output("type",$type);
		$this->output("payment",$this->_b_config['payment']);
		$this->showpage("own_refund");
	}

	/**
	 * 取得订单列表
	 *
	 * @param string $order_case 
	 */
	function _listorder($order_case) {
		/**
		 * 关闭过期交易，默认为7天
		 */
		$this->obj_product_order->closeProductOrderByTime();
		/**
		 * 更新竞拍结束的商品(生成订单)
		 */
		include_once("order_process_countdown.class.php");
		$obj_process_countdown = new OrderProcessCountdown();
		$obj_process_countdown->updateProductOrderConutdown();			
		/**
		 * 取得查询参数
		 */
		$obj_condition ['key'] = $this->_input ['keyword'];
		$obj_condition ['keygenre'] = $this->_input ['searchtype'];
		$obj_condition ['time'] = $this->_input ['time'];
		$obj_condition ['p_name'] = $this->_input ['p_name'];
		//检索条件 卖家名称
		if ($this->_input ['seller_nick'] != "") {
			$condition ['member_name'] = $this->_input ['seller_nick'];
			$member_info = $this->obj_member->getMemberInfo ( $condition );
			if (! empty ( $member_info )) {
				$obj_condition ['seller_id'] = $member_info ['member_id'];
			}
			unset ( $condition,$member_info );
		}
		//检索条件 买家名称
		if ($this->_input ['buyer_nick'] != "") {
			$condition ['member_name'] = $this->_input ['buyer_nick'];
			$member_info = $this->obj_member->getMemberInfo ( $condition );
			if (! empty ( $member_info )) {
				$obj_condition ['buyer_id'] = $member_info ['member_id'];
			}
			unset ( $condition,$member_info );
		}
		//时间搜索
		if ($this->_input ['start_time'] != "" && $this->_input ['end_time'] != "") {
			$time = @explode ( '-', $this->_input ['start_time'] );
			$obj_condition['start_time'] = @mktime ( 0, 0, 0, $time [1], $time [2], $time [0] );
			$time = @explode ( '-', $this->_input ['end_time'] );
			$obj_condition['end_time'] = @mktime ( 0, 0, 0, $time [1], $time [2], $time [0] ) + 24*60*60;
			$obj_condition [search_time] = 1;
		}
		//其他限定条件
		if ($this->_input['order_state'] != ''){
			$obj_condition ['state'] = array($this->_input['order_state']);
		}else {
			$obj_condition ['state'] = array ("0", "1", "2", "3", "6" ,"7");
		}
		$obj_condition ['member_id'] = $_SESSION ['s_login'] ['id'];
		$obj_condition ['order_case'] = $order_case;
		$obj_condition ['order'] = 1;
		//取得订单列表
		$this->obj_page->pagebarnum ( 10 );
		$product_order_array = $this->obj_product_order->getProductOrderList ( $obj_condition, $this->obj_page );
		if (is_array ( $product_order_array )) {
			//分别初始化订单流程类
			require_once('order_process_auction.class.php');
			$obj_order_process_auction = new OrderProcessAuction();
			require_once('order_process_fixprice.class.php');
			$obj_order_process_fixprice = new OrderProcessFixprice();
			require_once('order_process_group.class.php');
			$obj_order_process_group = new OrderProcessGroup();
			require_once('order_process_countdown.class.php');
			$obj_order_process_countdown = new OrderProcessCountdown();
			//语言包
			$obj_order_process_auction->_lang = $this->_lang;
			$obj_order_process_fixprice->_lang = $this->_lang;
			$obj_order_process_group->_lang = $this->_lang;
			$site_url = "";
			$site_url = $this->_configinfo['websit']['site_url'];
			foreach ( $product_order_array as $key => $value ) {
				unset($obj_order_process_auction->order_info);
				unset($obj_order_process_fixprice->order_info);
				unset($obj_order_process_group->order_info);
				//取订单状态及商品链接
				switch ($value['sell_type']){
					case '0'://拍卖
					$obj_order_process_auction->order_info = $value;
					$product_order_array[$key]['state_info'] = $obj_order_process_auction->getOrderStateInfo($value['sp_code']);
					$product_order_array[$key]['product_href'] = $site_url . "/home/product_auction.php?action=view&p_code=" . $value['p_code'];
					break;
					case '1'://一口价
					$obj_order_process_fixprice->order_info = $value;
					$product_order_array[$key]['state_info'] = $obj_order_process_fixprice->getOrderStateInfo($value['sp_code']);
					$product_order_array[$key]['product_href'] = $site_url . "/home/product_fixprice.php?action=view&p_code=" . $value['p_code'];
					break;
					case '2'://团购
					$obj_order_process_group->order_info = $value;
					$product_order_array[$key]['state_info'] = $obj_order_process_group->getOrderStateInfo($value['sp_code']);
					$product_order_array[$key]['product_href'] = $site_url . "/home/product_group.php?action=view&p_code=" . $value['p_code'];
					break;
					case '3'://倒计时拍卖
					$obj_order_process_countdown->order_info = $value;
					$product_order_array[$key]['state_info'] = $obj_order_process_countdown->getOrderStateInfo($value['sp_code']);
					$product_order_array[$key]['product_href'] = $site_url . "/home/product_countdown.php?action=view&pid=" . $value['p_code'];
					break;
				}
				/**
				 * 在没有买家和卖家名的情况下取会员信息
				 */
				if ($order_case == "bought") {
					$member_id = $value ['seller_id'];
				} else {
					$member_id = $value ['buyer_id'];
				}
				if ($value['seller_name'] =='' || $value['buyer_name'] ==''){
					$condition = array();
					$condition ['id'] = $member_id;
					$member_info = $this->obj_member->getMemberInfo ( $condition,'login_name' );
					$member_nick = $member_info['login_name'];
				}else {
					/**
					 * 2.7版本更新内容
					 */
					if ($order_case == "bought") {
						$member_nick = $value ['seller_name'];
					} else {
						$member_nick = $value ['buyer_name'];
					}
				}
				$product_order_array [$key] ['member_nick'] = $member_nick;
				$product_order_array [$key] ['member_id'] = $member_id;

				//取成交时间
				$product_order_array [$key] ['sold_date'] = date ( "Y-m-d H:i:s", $value ['sold_time'] );
				/**
				 * 取得付款时间，并设置买家退款操作（付款后24小时可以退款）
				 */
				$product_order_array [$key]['is_refund'] = 0;//默认不能操作
				$time_order = $value ['pay_time']; //支付时间
				if ($value ['sp_pay_mechod'] == 'predeposit' || $value ['sp_pay_mechod'] == 'offline') {
					$time_order = $value ['sold_time'];//成交时间
				}
				if (!empty($time_order) && $time_order > 0 && $value ['sp_state'] > 0) {
					if ($time_order + 24*60*60 <= time() && $value ['refund_state'] == 0) {
						$product_order_array [$key]['is_refund'] = 1;
					}
				}
				/**
				 * 退款状态,屏蔽其他操作
				 * 0-未申请退款,1-退款中,2-不同意退款,3-退款成功
				 */
				$product_order_array [$key]['is_operate'] = 0;
				if ($value ['refund_state'] == '0' || $value ['refund_state'] == '2') {
					$product_order_array [$key]['is_operate'] = 1;
				}
				//退款成功
				if ($value ['refund_state'] == '3') {
					$product_order_array [$key]['state_info']['state_title'] = $this->_lang ['langRefundState3'];
					$product_order_array [$key]['state_info']['state_url'] = '';
					$product_order_array [$key]['state_info']['state_type'] = 'all';
				}
				//卖出的商品
				if ($this->_input ['action'] == "sold") {
					if ($product_order_array [$key] ['sole_have_comment'] == "0") {
						if ($product_order_array [$key] ['sp_state'] == "3") {
							$product_order_array [$key] ['score_say'] = '<a href="own_score.php?action=add&orderid=' . $product_order_array [$key] ['sp_id'] . '&type=' . $this->_input ['action'] . '" style="text-decoration:underline;">' . $this->_lang ['langOrderNotAppraise'] . '</a>';
							$product_order_array [$key] ['score_style'] = '1';
						}
					} else {
						$product_order_array [$key] ['score_say'] = '<span>'.$this->_lang ['langOrderAppraised'].'</span>';
							$product_order_array [$key] ['score_style'] = '2';
					}
					//买到的商品
				} else if ($this->_input ['action'] == "bought") {
					if ($product_order_array [$key] ['buy_have_comment'] == "0") {
						if ($product_order_array [$key] ['sp_state'] == "3") {
							$product_order_array [$key] ['score_say'] = '<a href="own_score.php?action=add&orderid=' . $product_order_array [$key] ['sp_id'] . '&type=' . $this->_input ['action'] . '" style="text-decoration:underline;">' . $this->_lang ['langOrderNotAppraise'] . '</a>';
							$product_order_array [$key] ['score_style'] = '1';
						}
					} else {
						$product_order_array [$key] ['score_say'] = '<span>'.$this->_lang ['langOrderAppraised'].'</span>';
							$product_order_array [$key] ['score_style'] = '2';
					}
				}
			}
		}
		unset($site_url);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show ( 'member' );
		//判断是否使用静态链接
		$product_order_array = $this->obj_product->checkProductIfHtml ( $product_order_array, $this->_configinfo ['productinfo'] ['ifhtml'] );

		//商品图片使用小图
		if (is_array ( $product_order_array )) {
			foreach ( $product_order_array as $k => $v ) {
				if ($product_order_array [$k] ['p_pic'] != '') {
					$temp = explode ( '.', $product_order_array [$k] ['p_pic'] );
					$temp_sub = explode ( '/', $temp [0] );
					if (is_array ( $temp_sub )) {
						for($i = 0; $i < count ( $temp_sub ) - 1; $i ++) {
							$temp_str .= $temp_sub [$i] . '/';
						}
						$product_order_array [$k] ['p_pic'] = $temp_str . substr ( $temp_sub [count ( $temp_sub ) - 1], 0, 23 ) . '_small.' . $temp [1];
						$temp_str = '';
					}
				}
			}
		}

		/**
		 * 投诉时间设置，超过订单生产后的可投诉天数则不允许进行投诉
		 */
		if (!is_object($obj_settings)){
			require_once('settings.class.php');
			$obj_settings = new SettingsClass();
		}
		//取可投诉天数
		$complaint_day = unserialize($obj_settings->getSettings('complaint_day'));
		//判断
		if (is_array($product_order_array)) {
			foreach ($product_order_array as $k1 => $v1){
				//允许投诉的时间段
				$can_comp_time = $v1['sold_time'] + $complaint_day*24*60*60;
				//当前时间戳
				$now_time = time();
				if ($can_comp_time > $now_time) {
					$product_order_array[$k1]['can_comp'] = 0;  //可投诉
				}else {
					$product_order_array[$k1]['can_comp'] = 1;  //超过可投诉时间段
				}
			}
			unset($complaint_day,$can_comp_time,$now_time);
		}
		/**
		 * 取售出类型
		 */
		if (is_array($product_order_array)) {
			foreach ($product_order_array as $k2 => $v2) {
				switch ($v2['sell_type']) {
					case 0://团购
						$product_order_array[$k2]['sell_type_name'] = $this->_lang['langOPaiMai'];
						break;
					case 1://一口价
						$product_order_array[$k2]['sell_type_name'] = $this->_lang['langOYiKouJia'];
						break;
					case 2://拍卖
						$product_order_array[$k2]['sell_type_name'] = $this->_lang['langOTuanGou'];
						break;
					case 3://倒计时拍卖
						$product_order_array[$k2]['sell_type_name'] = $this->_lang['langOCountdown'];
						break;
						default:
							break;
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output ( "member_id", $_SESSION ['s_login'] ['id'] );
		$this->output ( "order_case", $order_case );
		$this->output ( "page_list", $page_list );
		$this->output ( "time", $this->_input ['time'] );
		$this->output ( "type", $this->_input ['action'] );
		$this->output ( "input", $this->_input );
		$this->output ( "product_order_array", $product_order_array );

		$this->showpage ( "own_order.manage" );
	}

	/**
	 * 团购商品列表
	 *
	 */
	function _listgroup($group_state) {
		/**
		 * 取得查询参数
		 */
		$obj_condition ['key'] = $this->_input ['keyword'];
		$obj_condition ['keygenre'] = $this->_input ['searchtype'];

		/**
		 * 其他限定条件
		 */
		$obj_condition ['order_case'] = "bought";
		if ($group_state == "group_buying") {
			$obj_condition ['state'] = array ("4" );
			$obj_condition ['sell_type'] = "2";
		} elseif ($group_state == "group_end") {
			$obj_condition ['state'] = array ("5" );
			$obj_condition ['sell_type'] = "2";
		}

		$obj_condition ['buyer_id'] = $_SESSION ['s_login'] ['id'];
		$obj_condition ['order_case'] = $order_case;

		/**
		 * 更新到期团购商品订单状态
		 */
		$group_product_order_tobe_end_array = $this->obj_product_order->updateProductOrderInCondition ();
		/**
		 * 更新到期商品状态
		 */
		$product_tobe_end_array = $this->obj_product->updateProductInCondition ();
		/**
		 * 更新过期交易结束团购未成立的订单状态
		 */

		/**
		 * 取得订单列表
		 */
		$this->obj_page->pagebarnum ( 10 );
		$product_order_array = $this->obj_product_order->getProductOrderList ( $obj_condition, $this->obj_page );
		if (is_array ( $product_order_array )) {
			foreach ( $product_order_array as $key => $value ) {
				//取会员信息
				if ($order_case == "bought") {
					$member_id = $value ['seller_id'];
				} else {
					$member_id = $value ['buyer_id'];
				}
				/**
				 * 在没有买家和卖家名的情况下取会员信息
				 */
				if ($value['seller_name'] =='' || $value['buyer_name'] ==''){
					$condition ['id'] = $member_id;
					$member_info = $this->obj_member->getMemberInfo ( $condition,'login_name' );
					$member_nick = $member_info['login_name'];
					unset($condition);
				}else {
					/**
					 * 2.7版本更新内容
					 */
					if ($order_case == "bought") {
						$member_nick = $value ['seller_name'];
					} else {
						$member_nick = $value ['buyer_name'];
					}
				}
				$product_order_array [$key] ['member_nick'] = $member_nick;
				$product_order_array [$key] ['member_id'] = $member_id;
				$product_info = $this->obj_product->getProductRow ( $value ['p_code'] );
				if ($product_info ['p_sold_num'] < $product_info ['p_group_mincount']) {
					$product_order_array [$key] ['less_count'] = $product_info ['p_group_mincount'] - $product_info ['p_sold_num'];
				}
				$left_time = $product_info ['p_end_time'] - time ();
				if ($left_time < 0) {
					$is_end = "1";
				}
				$product_order_array [$key] ['left_days'] = intval ( $left_time / (24 * 60 * 60) );
				$product_order_array [$key] ['left_hours'] = intval ( ($left_time % (24 * 60 * 60)) / (60 * 60) );
				$product_order_array [$key] ['left_minutes'] = intval ( (($left_time % (60 * 60))) / 60 );

			}
		}
		if (count ( $product_order_array ) < 1) {
			$no_order = "no_order";
		}
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show ( 'member' );
		/*判断是否使用静态链接*/
		$product_order_array = $this->obj_product->checkProductIfHtml ( $product_order_array, $this->_configinfo ['productinfo'] ['ifhtml'] );
		/**
		 * 页面输出
		 */
		$this->output ( "member_id", $_SESSION ['s_login'] ['id'] );
		$this->output ( "order_case", $order_case );
		$this->output ( "no_order", $no_order );
		$this->output ( "is_end", $is_end );
		$this->output ( "page_list", $page_list );
		$this->output ( "group_state",  $group_state);
		$this->output ( "product_order_array", $product_order_array );
		$this->showpage ( "own_group_order.manage" );
	}

	/**
	 * 更改商品订单状态
	 *
	 * @param int $state 0:已成交 1:已支付 2:已发货 3:已收货
	 */
	function _updateproductorderstate($state) {
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array (array ("input" => $this->_input ["spcode"], "require" => "true", "message" => $this->_lang ['errOrderCodeEmpty'] ) );
		$error = $this->obj_validate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {

			$condition_order ['sp_code'] = $this->_input ["spcode"];
			$product_array = $this->obj_product_order->getProductOrderList ( $condition_order, $this->obj_page );
			switch ($state) {
				case 1 :
					$this->_input ['pay_time'] = time ();
					break;
				case 2 :
					$this->_input ['deliver_time'] = time ();
					break;
				case 3 : //买家已确认收货
				$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ["spcode"] );
				//更改订单状态
				switch ($order_array['sell_type']){
					case '0'://拍卖
					require_once('order_process_auction.class.php');
					$obj_order_process = new OrderProcessAuction($order_array['sp_code']);
					break;
					case '1'://一口价
					require_once('order_process_fixprice.class.php');
					$obj_order_process = new OrderProcessFixprice($order_array['sp_code']);
					break;
					case '2'://团购
					require_once('order_process_group.class.php');
					$obj_order_process = new OrderProcessGroup($order_array['sp_code']);
					break;
					case '3'://倒计时拍卖
					require_once('order_process_countdown.class.php');
					$obj_order_process = new OrderProcessCountdown($order_array['sp_code']);
					break;
					default:
						exit;
				}
				$obj_order_process->changeOrderState($order_array['sp_code'],3);
				$this->redirectPath ( "succ", "member/own_order.php?action=bought", $this->_lang ['langOrderState'] );
				break;
			}
			$this->_input ["txtSPstate"] = $state;

			$result = $this->obj_product_order->updateProductOrderState ( $this->_input );
			$this->redirectPath ( "succ", "member/own_order.php?action=bought", $this->_lang ['langOrderState'] );
		}
	}

	/**
	 * 发货
	 */
	function _invoice() {
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array (array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['langOrderSpcodeEmpty'] ), array ("input" => $this->_input ["receive_code"], "require" => "true", "message" => $this->_lang ['langOrderReceivepcodeEmpty'] ), array ("input" => $this->_input ["type"], "require" => "true", "message" => $this->_lang ['langOrderPaymentWrong'] ) );
		$error = $this->obj_validate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			//取订单信息判断订单编号是否与收货地址编号相同，不同则返回错误
			$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ["sp_code"] );
			if ($order_array ['receive_code'] != $this->_input ["receive_code"] || $order_array['seller_id'] != $_SESSION['s_login']['id']) {
				$this->redirectPath ( "error", "", $this->_lang ['langOrderSpcodeEmpty'] );
			}
			//判断订单状态，如果大于等于2，则报错
			if ($order_array ['sp_state'] > 1) {
				$this->redirectPath ( "error", "", $this->_lang ['langOrderStateChange'] );
			}

			/**
			 * 页面输出
			 */
			$this->output ( 'order_array', $order_array );
			$this->showpage ( "own_order.invoice" );
		}
	}

	/**
	 * 新增发货单
	 */
	function _invoice_save() {
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array (array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['langOrderSpcodeEmpty'] ), array ("input" => $this->_input ["invoice_info"], "require" => "true", "message" => $this->_lang ['langOrderInvoiceEmpty'] ) );

		$error = $this->obj_validate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			//判断是否已经有对应的发货单,如果有则返回错误
			$invoice_array = $this->obj_product_order->getInvoice ( $this->_input ["sp_code"] );
			if (! empty ( $invoice_array )) {
				$this->redirectPath ( "error", "", $this->_lang ['langOrderInvoiceWrong'] );
			}
			//取订单信息
			$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ["sp_code"] );
			//判断对应的支付接口文件是否存在 不是预存款的方式
			if ($order_array ['sp_pay_mechod'] != 'predeposit' && (!file_exists ( "../payment/" . $order_array ['sp_pay_mechod'] . "/index.php" ) || !file_exists ("../payment/" . $order_array ['sp_pay_mechod'] . "/payment_module.php"))) {
				$result = "(../payment/" . $order_array ['sp_pay_mechod'] . "/index.php or payment_module.php)" . " is not exists";
				$this->redirectPath ( "error", "", $result );
			}
			//新增发货单
			$param_array = array ();
			$param_array ['order_code'] = $order_array ['sp_code'];
			$param_array ['receive_code'] = $order_array ['receive_code'];
			$param_array ['invoice_info'] = Common::replacebr ( $this->_input ["invoice_info"] );
			$result = $this->obj_product_order->addInvoice ( $param_array );
			if ($result == true) {
				switch ($order_array['sell_type']){
					case '0'://拍卖
					require_once('order_process_auction.class.php');
					$obj_order_process = new OrderProcessAuction($order_array['sp_code']);
					break;
					case '1'://一口价
					require_once('order_process_fixprice.class.php');
					$obj_order_process = new OrderProcessFixprice($order_array['sp_code']);
					break;
					case '2'://团购
					require_once('order_process_group.class.php');
					$obj_order_process = new OrderProcessGroup($order_array['sp_code']);
					break;
					case '3'://倒计时拍卖
					require_once('order_process_countdown.class.php');
					$obj_order_process = new OrderProcessCountdown($order_array['sp_code']);
					break;
					default:
						exit;
				}

				//更改订单状态
				$obj_order_process->changeOrderState($order_array['sp_code'],2);

				if ($order_array ['sp_pay_mechod'] == 'predeposit' || $order_array ['sp_pay_mechod'] == 'offline') {
					$url = 'member/own_order.php?action=sold';
					$this->redirectPath ( "succ", $url, $this->_lang ['langOrderInvoiceAddIsSucc'] );
				} else {
					//跳转到对应的支付方式页面
					$url = 'payment/' . $order_array ['sp_pay_mechod'] . '/index.php?sp_code=' . $order_array ['sp_code'];
					$this->redirectPath ( "succ", $url, $this->_lang ['langOrderInvoiceAddIsSucc'] );
				}
			} else {
				$this->redirectPath ( "error", "", $this->_lang ['langOrderInvoiceIsFaild'] );
			}
		}
	}

	/**
	 * 买家确认收货单
	 */
	function _order_receive() {
		$sp_code = $this->_input ['sp_code'];
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $sp_code );
		if ($order_array ['buyer_id'] != $_SESSION ['s_login'] ['id']) {
			$this->redirectPath ( "error", "", $this->_lang ['langOrderReceiveIsFaild'] );
		}
		//取发货单内容
		$invoice_array = $this->obj_product_order->getInvoice($sp_code);
		$order_array['invoice_info'] = $invoice_array['invoice_info'];
		/**
		 * 页面输出
		 */
		$this->output ( 'order_array', $order_array );
		$this->showpage ( 'own_order.receive' );
	}

	/**
	 * 买家购买成功显示页面
	 */
	function _pay_success() {

		//取订单信息
		$sp_code = $this->_input ['sp_code'];
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $sp_code );

		//取收货地址
		$condition ['member_id'] = $order_array ['buyer_id'];
		$condition ['receive_code'] = $order_array ['receive_code'];
		$receive_info = $this->obj_receive->getAllReceive ( $condition, $this->obj_page );
		unset ( $condition );

		//取卖家信息
		$condition ['member_id'] = $order_array ['seller_id'];
		$seller_info = $this->obj_member->getMemberInfo ( $condition, '*', 'more' );
		$seller_info['sms_name']	= urlencode($seller_info['login_name']);

		//取商品信息
		$condition ['p_code'] = $order_array ['p_code'];
		$product_array = $this->obj_product->getProductList ( $condition, $this->obj_page );
		//判断商品是否有静态页
		$product_array = $this->obj_product->checkProductIfHtml ( $product_array, $this->_configinfo ['productinfo'] ['ifhtml'] );
		unset ( $condition );

		/**
		 * 页面输出
		 */
		$this->output ( 'order_array', $order_array );
		$this->output ( 'receive_info', $receive_info[0] );
		$this->output ( 'seller_info', $seller_info );
		$this->output ( 'product_array', $product_array );
		$this->showpage ( 'own_order.pay_success' );
	}

	/**
	 * 拍卖情况下订单选择支付方式和货币种类
	 */
	function _bid_sel_payment() {
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array (array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['langOrderSpcodeEmpty'] ) );

		$error = $this->obj_validate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			//取订单信息
			$sp_code = $this->_input ['sp_code'];
			$order_array = $this->obj_product_order->getOneOrderBySpcode ( $sp_code );
			//判断是否是该订单的会员
			if ($order_array ['buyer_id'] == $_SESSION ['s_login'] ['id']) {
				//取商品信息
				$product_info = $this->obj_product->getProductRow ( $order_array ['p_code'] );
				//商品的支持的支付方式
				$product_payment = @explode ( '|', trim ( $product_info ['p_pay_method'], '|' ) );
				//商品的支持的货币种类
				$product_currency = @explode ( '|', trim ( $product_info ['p_currency_category'], '|' ) );
				//汇率列表
				//创建汇率对象，取汇率信息
				if (! is_object ( $this->obj_exchange )) {
					require_once ("exchange.class.php");
					$this->obj_exchange = new ExchangeClass ( );
				}
				$exchange_array = $this->obj_exchange->listExchange ( $condition, $page );

				if (is_array ( $product_payment )) {
					$payment_array = array ();
					$i = 0;
					foreach ( $product_payment as $k => $v ) {
						if (file_exists ( BasePath . '/payment/' . $v . "/payment_module.php" )) {
							include_once (BasePath . '/payment/' . $v . "/payment_module.php");
							$classname = $v . "PaymentMethod";
							$obj_module = new $classname ( );
							//该支付方式参数
							$array = $obj_module->payment_param ();
							//判断货币种类是否有值，如果没有
							if (! empty ( $array ['currency'] )) {
								$j = 0;
								$currency_array = array ();
								foreach ( $array ['currency'] as $k2 => $v2 ) {
									//判断是否该货币种类是该商品支持的,下标为货币种类，值为价格
									if (in_array ( $v2, $product_currency )) {
										if (is_array ( $exchange_array )) {
											foreach ( $exchange_array as $k3 => $v3 ) {
												if ($v3 ['exchange_name'] == $v2) {
													$currency_array [$v2] = @number_format ( ($product_info ['p_price'] / $v3 ['exchange_rate']) * 100, 2 ) <= 0.01 ? '0.01' : @number_format ( ($product_info ['p_price'] / $v3 ['exchange_rate']) * 100, 2 );
												}
											}
										}
									}
								}
								$payment_array [$v] ['name'] = $array ['name'];
								$payment_array [$v] ['currency'] = $currency_array;
								unset ( $currency_array );
								if ($i == '0') {
									$payment_array [$v] ['check'] = 1;
								}
								$i ++;
							}
							unset ( $obj_module, $array );
						}
					}
				}

				/**
				 * 页面输出
				 */
				$this->output ( 'product_info', $product_info );
				$this->output ( 'order_array', $order_array );
				$this->output ( 'payment_array', $payment_array );
				$this->showpage ( "own_order.bid_select_payment" );
			} else {
				$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
			}
		}

	}

	/**
	 * 更新订单的支付方式
	 */
	function _bid_sel_payment_save() {
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array (array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['errOrderCodeEmpty'] ) );
		$error = $this->obj_validate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			//取订单信息
			$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ['sp_code'] );
			//判断状态，如果不是已购买（state=0），直接跳转，不更新状态
			if ($order_array ['sp_state'] != '0'){
				$this->redirectPath ( "error", "", $error );
			}

			//更新订单
			$param_array = array ();
			$param_array ['sp_code'] = $order_array['sp_code'];
			$param_array ['sp_pay_mechod'] = $this->_input ['txtPayment'];
			$param_array ['sp_currency_category'] = $this->_input [$this->_input ['txtPayment'] . '_currency'];
			//如果是线下交易，则状态变为已付款
			if ($this->_input ['txtPayment'] == 'offline'){
				$param_array['sp_state'] = '1';
			}
			$this->obj_product_order->updateProductOrder ( $param_array );

			switch ($order_array['sell_type']){
				case '0'://拍卖
				require_once('order_process_auction.class.php');
				$obj_order_process = new OrderProcessAuction();
				break;
				case '1'://一口价
				require_once('order_process_fixprice.class.php');
				$obj_order_process = new OrderProcessFixprice();
				break;
				case '2'://团购
				require_once('order_process_group.class.php');
				$obj_order_process = new OrderProcessGroup();
				break;
				default:
					exit;
			}
			$order_array['state_info'] = $obj_order_process->getOrderStateInfo($order_array['sp_code']);
			//线下方式
			if ($this->_input ['txtPayment'] == 'offline'){
				$this->redirectPath ( "succ", 'member/own_order.php?action=bought', $this->_lang ['langOrderBargainingOk'] );
			}else {
				@header ( "Location: " . $order_array['state_info']['state_url'] );
			}
		}
	}

	/**
	 * 订单查看
	 */
	function _show_order_info($sp_code) {

		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $sp_code );
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['seller_id'] && $_SESSION['s_login']['id'] != $order_array['buyer_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		//格式化时间
		if ($order_array['pay_time'] != ''){
			$order_array['pay_time'] = date("Y-m-d H:i:s",$order_array['pay_time']);
		}
		if ($order_array['deliver_time'] != ''){
			$order_array['deliver_time'] = date("Y-m-d H:i:s",$order_array['deliver_time']);
		}
		if ($order_array['receive_time'] != ''){
			$order_array['receive_time'] = date("Y-m-d H:i:s",$order_array['receive_time']);
		}
		if ($order_array['sold_time'] != ''){
			$order_array['sold_time'] = date("Y-m-d H:i:s",$order_array['sold_time']);
		}

		//取收货地址
		$condition ['member_id'] = $order_array ['buyer_id'];
		$condition ['receive_code'] = $order_array ['receive_code'];
		$array = $this->obj_receive->getAllReceive ( $condition, $this->obj_page );
		$receive_info = $array[0];
		/**
		 * 取地区信息
		 */
		if ($receive_info['receive_area_id'] !=''){
			/**
			 * 创建地区对象
			 */
			require_once ("area.class.php");
			$obj_area= new AreaClass();
			$receive_area_array = array();
			$receive_area_array = $obj_area->getAreaPathList($receive_info['receive_area_id']);
			if (is_array($receive_area_array)) {
				foreach ($receive_area_array as $area) {
					$receive_info['area'] .= " ".$area['area_name'];
				}
			}
		}		
		unset ( $condition ,$array,$receive_area_array,$obj_area );

		//取卖家信息
		$condition ['id'] = $order_array ['seller_id'];
		$condition ['member_state'] = 1;
		$seller_info = $this->obj_member->getMemberInfo ( $condition, '*', 'more' );
		$seller_info['sms_name']	= urlencode($seller_info['login_name']);
		unset ( $condition );

		//取买家信息
		$condition ['id'] = $order_array ['buyer_id'];
		$condition ['member_state'] = 1;
		$buyer_info = $this->obj_member->getMemberInfo ( $condition, '*', 'more' );
		unset ( $condition );
		//判断商品是否有静态页
		if (file_exists("../html/user/".$order_array['pc_id']."/item_detail-".$order_array['p_code'].".html")){
			$html_url = "../html/user/".$order_array['pc_id']."/item_detail-".$order_array['p_code'].".html";
		}
		//创建汇率对象，取汇率信息
		if (! is_object ( $this->obj_exchange )) {
			require_once ("exchange.class.php");
			$this->obj_exchange = new ExchangeClass ( );
		}
		//去货币对应中文名称的数组
		$exchange_remark = $this->obj_exchange->getExchangeArray();
		if (is_array($exchange_remark)){
			$order_array['sp_currency_category'] = $exchange_remark[$order_array['sp_currency_category']];
		}
		//设置商品详情链接地址
		$site_url = "";
		$site_url = $this->_configinfo['websit']['site_url'];
		switch ($order_array['sell_type']) {
			case '0'://竞拍
			$order_array['product_href'] = $site_url . "/home/product_auction.php?action=view&p_code=" . $order_array['p_code'];
			break;
			case '1'://一口价
			$order_array['product_href'] = $site_url . "/home/product.php?action=view&p_code=" . $order_array['p_code'];
			break;
			case '2'://团购
			$order_array['product_href'] = $site_url . "/home/product_group.php?action=view&p_code=" . $order_array['p_code'];
			break;
			case '3'://倒计时拍卖
			$order_array['product_href'] = $site_url . "/home/product_countdown.php?action=view&pid=" . $order_array['p_code'];
			break;
		}
		unset($site_url);
		/**
		 * 页面输出
		 */
		$this->output ( 'order_array', $order_array );
		$this->output ( 'receive_info', $receive_info );
		$this->output ( 'seller_info', $seller_info );
		$this->output ( 'buyer_info', $buyer_info );
		$this->output ( 'html_url', $html_url );
		$this->showpage ( 'own_order.show' );
	}

	/**
	 * 线下状态 修改订单状态付款
	 */
	function _offline_pay(){
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['buyer_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		/**
		 * 页面输出
		 */
		$this->output ( 'order_array', $order_array );
		$this->showpage ( 'own_order.offline_pay' );
	}

	/**
	 * 线下状态 修改订单状态付款
	 */
	function _save_offline_pay(){
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['buyer_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		//判断订单状态
		if($order_array['sp_state'] != '0'){
			$this->redirectPath ( "error", "../member/own_order.php?action=bought", $this->_lang ['langOrderCanNotPay'] );
		}
		switch ($order_array['sell_type']){
			case '0'://拍卖
			require_once('order_process_auction.class.php');
			$obj_order_process = new OrderProcessAuction();
			break;
			case '1'://一口价
			require_once('order_process_fixprice.class.php');
			$obj_order_process = new OrderProcessFixprice();
			break;
			case '2'://团购
			require_once('order_process_group.class.php');
			$obj_order_process = new OrderProcessGroup();
			break;
			default:
				exit;
		}
		//更改订单状态
		$result = $obj_order_process->changeOrderState($order_array['sp_code'],1);
		if ($result === true){
			$this->redirectPath ( "succ", "member/own_order.php?action=bought", $this->_lang ['alertOrderOperatorOk'] );
		}else {
			$this->redirectPath ( "error", "", $this->_lang ['langOrderInvoiceIsFaild'] );
		}
	}

	/**
	 * 预存款 付款操作 修改订单状态付款
	 */
	function _predeposit_pay(){
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['buyer_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		/**
		 * 页面输出
		 */
		$this->output ( 'order_array', $order_array );
		$this->showpage ( 'own_order.predeposit_pay' );
	}

	/**
	 * 预存款 付款操作 修改订单状态付款
	 */
	function _save_predeposit_pay(){
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input['sp_code'] );
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['buyer_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		//判断订单状态
		if($order_array['sp_state'] != '0'){
			$this->redirectPath ( "error", "../member/own_order.php?action=bought", $this->_lang ['langOrderCanNotPay'] );
		}
		switch ($order_array['sell_type']){
			case '0'://拍卖
			require_once('order_process_auction.class.php');
			$obj_order_process = new OrderProcessAuction();
			break;
			case '1'://一口价
			require_once('order_process_fixprice.class.php');
			$obj_order_process = new OrderProcessFixprice();
			break;
			case '2'://团购
			require_once('order_process_group.class.php');
			$obj_order_process = new OrderProcessGroup();
			case '3'://倒计时拍卖
			require_once('order_process_countdown.class.php');
			$obj_order_process = new OrderProcessCountdown();
			break;
			default:
				exit;
		}
		//更改订单状态
		$result = $obj_order_process->changeOrderState($order_array['sp_code'],1);
		if ($result === true){
			$this->redirectPath ( "succ", "member/own_order.php?action=bought", $this->_lang ['alertOrderOperatorOk'] );
		}else {
			$this->redirectPath ( "error", "", $this->_lang ['langOrderInvoiceIsFaild'] );
		}
	}

	/**
	 * 关闭交易
	 */
	function _close(){
		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ['sp_code'] );
		//判断状态，如果不是已购买（state=0），直接跳转，不更新状态
		if ($order_array ['sp_state'] != '0'){
			$this->redirectPath ( "error", "", $this->_lang['errOrderCloseIsNotAtState'] );
		}
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['seller_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		/**
		 * 页面输出
		 */
		$this->output('order_array',$order_array);
		$this->showpage('own_order.close');
	}

	/**
	 * 保存关闭信息
	 */
	function _close_save(){
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array (
		array ("input" => $this->_input ["sp_code"], "require" => "true", "message" => $this->_lang ['langOrderSpcodeEmpty'] ),
		array ("input" => $this->_input ["close_reason"], "require" => "true", "message" => $this->_lang['errOrderCloseReasonIsEmpty'] ) );

		//取订单信息
		$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ['sp_code'] );
		//判断状态，如果不是已购买（state=0），直接跳转，不更新状态
		if ($order_array ['sp_state'] != '0'){
			$this->redirectPath ( "error", "", $this->_lang['errOrderCloseIsNotAtState'] );
		}
		//判断订单是否和会员一致
		if ($_SESSION['s_login']['id'] != $order_array['seller_id']){
			$this->redirectPath ( "error", "", $this->_lang ['langOrderIsSameToMember'] );
		}
		$value_array = array();
		$value_array['sp_code'] = $order_array['sp_code'];
		$value_array['sp_state'] = 7;
		$value_array['close_reason'] = $this->_input['close_reason'];
		//更改订单状态
		$result = $this->obj_product_order->updateProductOrder($value_array);
		if ($result === true){
			/**
		 	* 团购时，当卖家关闭交易时，退还该购买者的保证金
		 	*/
			if($order_array['sell_type'] == 2) {
				$group_ext_array = $this->obj_product->getProductGroupRow($order_array['p_code']);
				if($group_ext_array['set_money'] > 0) {
					require_once("order_process_group.class.php");
					$order_process_group = new OrderProcessGroup($value_array['sp_code']);
					$order_process_group->marginBack($group_ext_array['set_money'],$order_array['buyer_id'],13,$this->_lang['langOrderGroupCloseh']);
				}
			}
			if($order_array['sp_pay_mechod'] == 'predeposit'){
				/**
				 * 语言包
				 */
				$this->getlang ( "own_predeposit" );

				//判断是否是预存款，如果是，则进行退款
				//关闭交易退款
				require_once ("predeposit.class.php");
				$obj_predeposit = new PredepositClass ( );
				require_once("member.class.php");
				$obj_member = new MemberClass();
				//买家
				$value_array = array ();
				$value_array ['predeposit_type'] = '7'; //卖家关闭交易
				$value_array ['predeposit_state'] = '1';
				$value_array ['member_id'] = $order_array['buyer_id'];
				$value_array ['sp_code'] = $order_array["sp_code"];
				$value_array ['available_amount'] = '+' . $order_array['total_price'];
				$value_array ['system_remark'] = $this->_lang['langPreDetailTypeSeven'];
				$value_array ['create_time'] = time ();
				$value_array ['update_time'] = time ();
				$value_array ['payment'] = 'predeposit';
				$obj_predeposit->addPredepositDetail ( $value_array );
				unset ( $value_array );
				//对买家帐号进行操作
				$value_array = array ();
				$value_array ['available_predeposit'] = '+' . $order_array['total_price'];
				$obj_member->modifyMember ( $value_array, $order_array['buyer_id'], 'predeposit' );
				unset ( $value_array );
				unset($obj_predeposit,$obj_member);
			}
			$this->redirectPath ( "succ", "member/own_order.php?action=sold", $this->_lang['langOrderCloseIsSucc'] );
		}else {
			$this->redirectPath ( "error", "", $this->_lang['errOrderCloseIsFail'] );
		}
	}
	/**
	 * 保存修改运费
	 */
	function _save_postage(){
		$this->obj_validate->validateparam = array (array ("input" => $this->_input ["tf_fee"], "require" => "true", "validator"=>"Range","min"=>'0',"max"=>'999.99',"message" => $this->_lang ['errOModiPostageIsWrong'] ) );
		$error = $this->obj_validate->validate ();
		if ($error != "") {
			Common::outMessage("json",$error,0);
		} else {
			//取订单信息
			$order_array = $this->obj_product_order->getOneOrderBySpcode ( $this->_input ['sp_code'] );
			//判断状态，如果不是已购买（state=0），直接跳转，不更新状态
			if ($order_array ['sp_state'] != '0'){
				Common::outMessage("json",$this->_lang['errOrderModiPostageIsNotAtStates'],0);
			}
			//判断订单是否和会员一致
			if ($_SESSION['s_login']['id'] != $order_array['seller_id']){
				Common::outMessage("json",$this->_lang['langOrderIsSameToMember'],0);
			}
			/**
			 * 更新订单 
			 */
			$value_array = array();
			$value_array['sp_code'] = $this->_input ['sp_code'];
			$value_array['tf_fee'] = $this->_input ['tf_fee'];//运费
			$value_array['total_price'] = sprintf("%01.2f",($order_array['total_price']-$order_array['tf_fee']+$this->_input ['tf_fee']));//更新后的总价
			$result = $this->obj_product_order->updateProductOrder($value_array);
			if ($result === true){
				echo  "{\"type\":1,\"message\":\"".$this->_lang['alertOrderOperatorOk']."\",\"total_price\":".$value_array['total_price']."}";exit;
			}else {
				Common::outMessage("json",$this->_lang['errOrderCloseIsFail'],0);
			}
		}
	}
}

$product_order_manage = new OwnProductOrderManage ( );
$product_order_manage->main ();
unset ( $product_order_manage );
?>