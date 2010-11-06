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
 * FILE_NAME :own_product_list.php
 * 会员商品列表及列表操作
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 15:59:46 CST 2010
 */

require_once("../global.inc.php");

class OwnProductListManage extends memberFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 拍卖商品出价对象
	 *
	 * @var obj
	 */
	var $obj_product_bid;
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_product_order;

	function main(){
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 网站提醒操作
		 */
		if (!is_object($this->obj_remind)){
			require_once('remind.class.php');
			$this->obj_remind = new RemindClass();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		if (!is_object($this->obj_product_bid)){
			require_once("bid.class.php");
			$this->obj_product_bid = new BidClass();
		}
		/**
		 * 创建X整合对象
		 */
		if (!is_object($this->obj_x_class)){
			require_once ("x.class.php");
			$this->obj_x_class = new XClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("product,productsucc");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('buyer','my_buyer','auctioning_buy');

		switch ($this->_input['action']){
			case "list":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','selling');

				$this->_listproduct();
				break;
			case "list_instock":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','storage');

				$state = '0';
				$this->_listproduct($state);
				break;
			case "recommended_list":
				$state = "2";
				$this->_listproduct($state);
				break;
			case "update_state":
				$this->_updateproductstate();
				break;
			case "recommended":
				$recommended = "1";
				$this->_updateproductrecommended($recommended);
				break;
			case "cancel_recommended":
				$recommended = "0";
				$this->_updateproductrecommended($recommended);
				break;
				//添加到店铺推荐商品列表
			case "store_recommended":
				$recommended = "1";
				$this->_updateproductstorerecommended($recommended);
				break;
				//从已添加到店铺推荐商品列表中删除
			case "cancel_store_recommended":
				$recommended = "0";
				$this->_updateproductstorerecommended($recommended);
				break;
			case "auction":
				$this->_auction_product();
				break;
		}
	}

	/**
	 * 出售中的商品列表页面
	 *
	 */
	function _listproduct($state='1'){
		/**
		 * 语言包
		 */
		$this->getlang("product_manage");
		/**
		 * 取得查询参数
		 */
		$obj_condition['key'] = $this->_input['keyword'];
		$obj_condition['p_type'] = $this->_input['pType'];
		$obj_condition['sell_type'] = $this->_input['sellType'];
		$obj_condition['keygenre'] = 1;
		$obj_condition['member'] = $_SESSION['s_login']['id'];
		if($state == "2"){
			$obj_condition['recommended'] = 1;
			$state = 1;
		}
		/**
		 * 更新到期团购商品订单状态
		 */
		$group_product_order_tobe_end_array = $this->obj_product_order->updateProductOrderInCondition();
		/**
		 * 更新竞拍结束的商品(生成订单)
		 */
		include_once("order_process_countdown.class.php");
		$obj_process_countdown = new OrderProcessCountdown();
		$obj_process_countdown->updateProductOrderConutdown();		
		/**
		 * 更新拍卖商品，到期则生成订单
		 */
		$condition['sell_type'] = 0;
		$condition['now_end'] = 1;
		$product_out_time_array = $this->obj_product->getProductList($condition,$page);
		if (is_array($product_out_time_array) && !empty($product_out_time_array)){
			foreach ($product_out_time_array as $k => $v){
				/**
				 * 取该商品拍卖状态为领先的竞拍信息，并且把信息状态变为成交
				 */
				$condition_bid['p_code'] = $v['p_code'];
				$condition_bid['bid_state'] = 1;
				$condition_bid['order'] = 2;
				$bid_array = $this->obj_product_bid->getProductBidList($condition_bid,$page);

				$input_param = array();
				$input_param['bid_state'] = 2;
				$input_param['p_code'] = $v['p_code'];
				$this->obj_product_bid->updateProductBidStateInCondition($input_param);

				unset($condition_bid);
				if (is_array($bid_array) && !empty($bid_array)){
					foreach ($bid_array as $k2 => $v2){
						/**
					 	 * 获得随机的唯一商品订单编码
						 */
						$product_order_last_id = $this->obj_product->getProductOrderLastId();
						if("" == $product_order_last_id){
							$product_order_last_id = 1;
						}else{
							$product_order_last_id += 1;
						}
						$value_array = array();
						$value_array["txtSPcode"] = $this->obj_product_order->getOrderNumber($product_order_last_id);//订单编码
						$value_array["txtPcid"] = $v['pc_id'];//类别ID
						$value_array['txtSellerId'] = $v['member_id'];//卖家ID
						$value_array['txtBuyerId'] = $v2['bid_member_id'];//买家ID
						$value_array['txtPname'] = $v['p_name'];//商品名称
						$value_array['txtPcode'] = $v['p_code'];//商品编号
						$value_array['txtUnitPrice'] = $v2['bid_price'];//单价
						if ($product_num<$v2['bid_count'] && $product_num != ''){//如果剩余商品数量不足购买数量时
							$value_array['txtBuyNum'] = $product_num;//购买数量
							//网站提醒
							$condition['id'] = $v['member_id'];
							$bid_member = $this->obj_member->getMemberInfo($condition);
							$value_remind = array();
							$value_remind['username'] = $bid_member['login_name'];
							$value_remind['product_name'] = $v['p_name'];
							$this->obj_remind->setMessageOrMail('buyer_bid_above_no_num','bid_above_no_num',$value_remind,$bid_member['login_name'],$this->_configinfo);//竞拍的宝贝不足我想要的数量时，请通知我
						}else {
							$value_array['txtBuyNum'] = $v2['bid_count'];//购买数量
						}
						$value_array['sell_type'] = $v['p_sell_type'];//订单交易类型
						$value_array['txtTfFee'] = 0;//运费
						$value_array['txtReceiveId'] = $v2['bid_receive_code'];//收货地址编号
						if ($v['p_pic'] != ''){
							$value_array['photo_url'] = $v['p_pic'];//图片路径
						}
						$value_array['sp_state'] = 0;//订单状态
						$value_array['anonymous'] = $v['bid_anonymous'];//是否匿名
						//生成订单
						$this->obj_product_order->saveProductOrder($value_array);
						$product_num = $v['p_storage']-$v2['bid_count'] ;//剩余商品数量
					}
					unset($product_num);
				}
			}
		}
		/**
		 * 更新商品上下架状态
		 */
		$product_tobe_end_array = $this->obj_product->updateProductInCondition();
		/**
		 * 更新设定上架时间的商品
		 */
		$product_tobe_pub_array = $this->obj_product->updatePubTimeProduct();
		/**
		 * 取得产品列表
		 */
		$obj_condition[state] = $state;
		if ($this->_input['sold_num'] != ""){
			$obj_condition[order] = 4;/*出价次数排序*/
			$obj_condition[sorttype] = $this->_input['sold_num'];
		}
		$this->obj_page->pagebarnum(20);
		$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		/**
		 * 创建倒计时竞拍类
		 */
		include_once("product_countdown.class.php");
		$obj_countdown = new ProductCountdownClass();
		
		/*判断列表中哪些商品已有人购买了*/
		if ($state == 1) {
			if (is_array($product_array)) {
				foreach ($product_array as $k => $v){
					//
					if ($v['p_sell_type'] == '1'){
						continue;
					}
					/**
					 * 判断团购商品
					 */
					if ($v['p_sell_type'] == '2'){
						unset($condition);
						$condition['p_code'] = $v['p_code'];
						$condition['search_time'] = 1;
						$condition['start_time'] = $v['p_start_time'];
						$condition['end_time'] = $v['p_end_time'];
						$order = $this->obj_product_order->getProductOrderList($condition,$page);
					}
					/**
					 * 判断拍卖的商品
					 */
					if ($v['p_sell_type'] == '0'){
						unset($condition);
						$condition['p_code'] = $v['p_code'];
						$bid = $this->obj_product_bid->getProductBidList($condition,$page);
					}
					/**
					 * 判断倒计时拍卖商品
					 */
					if ($v['p_sell_type'] == '3') {
						$product_countdown_array = array();
						$countdown_bid = '';
						$product_countdown_array = $obj_countdown->getProductRow($v['p_code']);
						$countdown_bid = (int)$product_countdown_array['cp_bid_num'];
					}
					//判断条件
					//判断在这次发布时是否有商品的购买信息
					//判断在这次发布时是否有商品的拍卖
					if ((count($order) > 0 || count($bid) > 0) || $countdown_bid > 0 && $v['p_state'] == 1) {
						$product_array[$k]['check_sign'] = 1;
					}
					unset($order,$bid,$condition,$product_countdown_array,$countdown_bid);
				}
			}
		}

		/**
		 * 输出到页面模板
		 */
		for($i=0;$i<count($product_array);$i++){
			$left_time = $product_array[$i]['p_end_time'] - time();
			$product_array[$i]['left_days'] = intval($left_time / (24*60*60));
			$product_array[$i]['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
			$product_array[$i]['left_minutes'] = intval((($left_time % (60*60))) / 60);
			/**
			 * 创建时间
			 */
			$product_array[$i]['p_add_time_ymd'] = date("Y-m-d",$product_array[$i]['p_add_time']);
			$product_array[$i]['p_add_time_his'] = date("H:i:s",$product_array[$i]['p_add_time']);
			/**
			 * 开始时间
			 */
			$product_array[$i]['p_start_time_ymd'] = date("Y-m-d",$product_array[$i]['p_start_time']);
			$product_array[$i]['p_start_time_his'] = date("H:i:s",$product_array[$i]['p_start_time']);
			/**
			 * 结束时间
			 */
			$product_array[$i]['p_end_time_ymd'] = date("Y-m-d",$product_array[$i]['p_end_time']);
			$product_array[$i]['p_end_time_his'] = date("H:i:s",$product_array[$i]['p_end_time']);
			/**
			 * 商品类别
			 */
			switch ($product_array[$i]['p_sell_type']){
				case "0":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langPMAuction'];
					$product_array[$i]['p_sold_num'] = $product_array[$i]['p_bid_num'];
					break;
				case "1":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langProductPrice'];
					break;
				case "2":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langPcamel'];
					break;
				case "3":
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langPcountdown'];
					break;					
				default:
					$product_array[$i]['p_sell_type_name'] = $this->_lang['langProductPrice'];
					break;
			}

			/**
			 * 当前价格
			 */
			if($product_array[$i]['p_sell_type']=="0"){
				if($product_array[$i]['p_cur_price'] == $product_array[$i]['p_price']){
					$product_array[$i]['p_cur_price'] = "";
				}
			}else{
				if($product_array[$i]['p_sold_num'] == "0"){
					$product_array[$i]['p_cur_price'] = "";
				}else{
					if($product_array[$i]['p_sell_type']=="1"){
						$product_array[$i]['p_cur_price'] = $product_array[$i]['p_price'];
					}elseif($product_array[$i]['p_sell_type']=="2"){
						$product_array[$i]['p_cur_price'] = $product_array[$i]['p_group_price'];
					}
				}
			}
			
			/**
			 * 判断修改操作连接
			 */
			switch ($product_array[$i]['p_sell_type']){
				/**
				 * 拍卖
				 */
				case '0':
					$product_array[$i]['product_url'] = "/home/product_auction.php?action=view&p_code=".$product_array[$i]['p_code'];
					$product_array[$i]['modi_url'] = "own_product_auction.php?action=modi&p_code=".$product_array[$i]['p_code'];
					break;
				/**
				 * 一口价
				 */
				case '1':
					$product_array[$i]['product_url'] = "/home/product_fixprice.php?action=view&p_code=".$product_array[$i]['p_code'];
					$product_array[$i]['modi_url'] = "own_product_fixprice.php?action=modi&p_code=".$product_array[$i]['p_code'];
					break;
				/**
				 * 团购
				 */
				case '2':
					$product_array[$i]['product_url'] = "/home/product_group.php?action=view&p_code=".$product_array[$i]['p_code'];
					$product_array[$i]['modi_url'] = "own_product_group.php?action=modi&p_code=".$product_array[$i]['p_code'];
					break;
				/**
				 * 倒计时拍卖
				 */
				case '3':
					$product_array[$i]['product_url'] = "/home/product_countdown.php?action=view&pid=".$product_array[$i]['p_code'];
					$product_array[$i]['modi_url'] = "own_product_countdown.php?action=modi&pid=".$product_array[$i]['p_code'];
					break;
			}
		}

		/*判断商品是否存在图片*/
		//$product_array = $this->obj_product->productPicRatio($product_array,'p_pic',100);
		/*判断是否使用静态链接*/
		$product_array = $this->obj_product->checkProductIfHtml($product_array,$this->_configinfo['productinfo']['ifhtml']);
		
		/**
		 * 页面输出
		 */
		$this->output("sold_num", 1-$this->_input['sold_num']);
		$this->output("state", $state);
		$this->output("page_list", $page_list);
		$this->output("product_array", $product_array);
		$this->output("action", $this->_input['action']);
		$this->output("condition", $obj_condition);
		/**
		 * 仓库中的商品
		 */
		if ($this->_input['action'] == 'list_instock'){
			$this->showpage("own_product.list_instock");
		}
		/**
		 * 出售中的商品
		 */
		if ($this->_input['action'] == 'list'){
			$this->showpage("own_product.manage");
		}
	}
	/**
	 * 更新商品状态
	 *
	 */
	function _updateproductstate(){
		/**
		 * 语言包
		 */
		$this->getlang("product_manage");

		//判断是否允许下架
		if (is_array($this->_input['chboxPid'])){
			foreach ($this->_input['chboxPid'] as $k => $value){
				if ($this->_input['check_sign'][$value] != ''){//不允许下架
					unset($this->_input['chboxPid'][$k]);
				}
			}
		}
		if($this->_input['state'] == "1"){//上架
			$this->_input["p_valid_days"] =  7;
			$this->_input["p_start_time"] = time();
			$this->_input["p_end_time"] =  Common::calculateDate("d", $this->_input["p_valid_days"], time());
			$this->_input["p_sold_num"] =  0;
			$this->_input["p_irregularities"] =  0;
		}else{//下架
			$this->_input["p_recommended"] = '0';
			$this->_input["p_auto_publish"] = '0';
		}
		//商品数量为空
		if (count($this->_input['chboxPid']) == 0){
			$this->redirectPath("succ", '', $this->_lang['langPNotSelectProduct']);
		}

		//取当前会员信息
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition,'*','more');

		if($this->_input['state'] == "1"){//上架
			//判断发布商品数量限制
			CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id'],array('sell_num'=>count($this->_input['chboxPid'])+$member_array['sell_product_count']));
		}

		//取当前会员所卖商品信息
		$condition['member'] = $_SESSION['s_login']['id'];
		$member_product = $this->obj_product->getProductList($condition, $page);

		if($this->_input['state'] == "1"){//上架商品操作
			if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){		//按商品数量收费
				$member_array['product_number'] = $member_array['product_number']?$member_array['product_number']:0;
				$count_onsale = count($this->_input['chboxPid']);
				//如果上架商品和已商家商品数量相加大于 限制数量，则报错
				if ($member_array['product_number'] <= (count($member_product)+$count_onsale)){
					$this->redirectPath("error", './own_shop_pay.php?action=pay', $this->_lang['langPCanSaleNumberMax']);
				}
			}
			//更新商品上架状态
			$update_product_rs = $this->obj_product->changeProductState($this->_input, $this->_input['state']);
			//更新商品库存信息
			if (is_array($this->_input['chboxPid'])) {
				foreach ($this->_input['chboxPid'] as $pcode) {
					$update_array = array();
					$update_array['txtPcode'] = $pcode;
					//判断商品出售类别，如果是团购的话，那么库存不能少于5
					if(is_array($member_product)){
						foreach($member_product as $k => $v){
							if($pcode == $v['p_code']){
								$p_sell_type = $v['p_sell_type'];
							}
						}
					}
					//团购
					if($p_sell_type == '2'){
						$update_array['txtPcount'] = $this->_input['txtPstorage'][$pcode] >= 5 ? $this->_input['txtPstorage'][$pcode] : 5;
					}else {
						$update_array['txtPcount'] = $this->_input['txtPstorage'][$pcode] > 0 ? $this->_input['txtPstorage'][$pcode] : 1;
					}
					$this->obj_product->updateProductCount($update_array);
				}
			}
			//更新商品发布数量的统计信息
			$update_product_statis = $this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'sell');
			//删除以往的该商品的竞拍信息
			if (!is_object($this->obj_product_bid)){
				require_once("bid.class.php");
				$this->obj_product_bid = new BidClass();
			}
			$this->obj_product_bid->delBid($this->_input['chboxPid']);
			//			$info = $this->_lang['langProductMUpRackOk'];
			//			$url = "member/own_product_list.php?action=listinstock";

			/**
			 * 判断是否整合X，同步X中商品表的上架状态
			 */
			if(DISCUZ_X === true){
				$condition['member'] = $_SESSION['s_login']['id'];
				$condition['state'] = 'none';
				$member_product = $this->obj_product->getProductList($condition, $page);
				if(is_array($member_product)){
					foreach($member_product as $k => $v){
						if(in_array($v['p_code'],$this->_input['chboxPid']) && $v['x_pid'] != ''){
							$param_array = array();
							//上架
							$param_array['closed'] = '0';
							//库存数量
							//判断是否是团购
							if($v['p_sell_type'] == '2'){
								$param_array['amount'] = ($this->_input['txtPstorage'][$v['p_code']] >= 5) ? $this->_input['txtPstorage'][$v['p_code']] : 5;
							}else{
								$param_array['amount'] = ($this->_input['txtPstorage'][$v['p_code']] != 0) ? $this->_input['txtPstorage'][$v['p_code']] : 1;
							}

							$this->obj_x_class->updateTrade($param_array,$v['x_pid']);
							unset($param_array);
						}
					}
				}
			}
			$this->redirectPath("succ", '', $this->_lang['langProductMUpRackOk']);
		}else{
			/**
			 * 更新商品下架状态
			 */
			$update_product_rs = $this->obj_product->changeProductState($this->_input, $this->_input['state']);

			/**
			 * 下架商品取消橱窗推荐状态
			 */
			$recommended = "0";
			$this->_updateproductrecommended($recommended,true);

			/**
			 * 更新商品发布数量、推荐商品数量的统计信息
			 */
			$update_product_statis = $this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'both');

			/**
			 * 判断是否整合X，同步X中商品表的上架状态
			 */
			if(is_array($member_product)){
				foreach($member_product as $k => $v){
					if(in_array($v['p_code'],$this->_input['chboxPid']) && $v['x_pid'] != ''){
						$param_array = array();
						$param_array['closed'] = '1';
						$this->obj_x_class->updateTrade($param_array,$v['x_pid']);
						unset($param_array);
					}
				}
			}
			$this->redirectPath("succ", '', $this->_lang['langProductMDownRackOk']);
		}


	}
	/**
	 * 更新商品推荐状态
	 *
	 * @param unknown_type $recommended
	 */
	function _updateproductrecommended($recommended,$return=''){

		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['errPSNotSelectBaby']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 判断推荐商品数量是否超过商店橱窗位的数量
			 */
			if ($recommended == 1){
				$condition_member['id'] = $_SESSION['s_login']['id'];
				$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
				if (count($this->_input["chboxPid"])>($member_array['recommend_max_count']-$member_array['recommend_product_count'])){
					$this->redirectPath("succ","member/own_product_list.php?action=list", $this->_lang['errPSCommendExceedShopwindowNum']);
				}
			}
			$this->_input['recommended'] = $recommended;
			$result = $this->obj_product->updateProductRecommended($this->_input);

			/**
			 * 更新推荐商品数量的统计信息
			 */
			$update_product_statis = $this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'recommend');
			if ($return != true){
				if($recommended == "1"){
					$info = $this->_lang['langPScommendedOk'];
				}else {
					$info = $this->_lang['langPSCommendedDelOk'];
				}
				$this->redirectPath("succ","", $info);
			}else {
				return true;
			}
		}
	}


	/**
     * 更新商品推荐状态(在店铺推荐的商品列表中)
     *
     */
	function _updateproductstorerecommended($recommended) {
		/**
		 * 判断会员是否已有店铺，没有则返回错误
		 */
		if($_SESSION["s_shop"]['id'] == ''){
			$this->redirectPath('succ',"member/own_shop.php?action=new",$this->_lang['errPHaveNotShop']);
		}
		$this->objvalidate->validateparam = array(array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['errPSNotSelectBaby']));
		$error = $this->objvalidate->validate();
		if(!empty($error)) {
			$this->redirectPath('error','',$error);
		} else {
			$this->_input['recommended']=$recommended;
			$update_rs = $this->obj_product->updateProductShopRecommended($this->_input);

			if($recommended == "1"){
				$info = $this->_lang['langPScommendedOk'];
			}else {
				$info = $this->_lang['langPSCommendedDelOk'];
			}

			$this->redirectPath('error','',$info);
		}
	}
	/**
	 * 拍卖中的宝贝
	 */
	function _auction_product(){
		/**
		 * 更新到期竞拍商品，生成订单
		 */
		$this->obj_product_order->createOrderByAuction();
		/**
		 * 更新到期竞拍商品，下架
		 */
		$this->obj_product->updateProductInCondition();
		/**
		 * 语言包
		 */
		$this->getlang("product_auction");

		$obj_condition['bid_member_id'] = $_SESSION['s_login']['id'];
		$obj_condition['order'] = 1;
		/**
		 * 产品列表
		 */
		require_once('bid.class.php');
		$obj_bid = new BidClass();
		$this->obj_page->pagebarnum(20);
		$auction_list = $obj_bid->getProductBidList($obj_condition, $this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		/**
		 * 格式化时间
		 */
		$bid_start = array('0'=>$this->_lang['langProductOut'],'1'=>$this->_lang['langPLead'],'2'=>$this->_lang['langPBargainOn']);
		if(is_array($auction_list)){
			foreach($auction_list as $k => $v){
				$auction_list[$k]['bid_time'] = date('Y-m-d H:i:s',$v['bid_time']);
				$auction_list[$k]['bid_state'] = $bid_start[$v['bid_state']];
			}
		}
		/**
		 * 页面输出
		 */
		$this->output("page_list", $page_list);
		$this->output("auction_list", $auction_list);
		$this->showpage('own_product_auction.manage');
	}
}
$product_list_manage = new OwnProductListManage();
$product_list_manage->main();
unset($product_list_manage);
?>