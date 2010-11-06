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
 * FILE_NAME :own_product_countdown_list.php
 * ....
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 11:55:05 CST 2010
 */
require_once("../global.inc.php");

class OwnProductListManage extends memberFrameWork{
	/**
	 * 倒计时拍卖商品对象
	 *
	 * @var obj
	 */
	var $obj_product_countdown;
    /**
     * 商品对象
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
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;	
	/**
	 * 拍卖商品出价对象
	 *
	 * @var obj
	 */
	var $obj_product_bid;	
	/**
	 * 倒计时拍卖操作对象
	 *
	 * @var object
	 */
	var $obj_process_countdown;

	function main(){
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
        if (!is_object($this->obj_product))
        {
            require_once 'product.class.php';
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
		/**
		 * 实例化商品出价类
		 */
		if (!is_object($this->obj_product_bid)){
			require_once("bid_countdown.class.php");
			$this->obj_product_bid = new BidCountdownClass();
		}	
		/**
		 * 实例化倒计时拍卖处理对象
		 */
		if (!is_object($this->obj_process_countdown)) {
			require_once("order_process_countdown.class.php");
			$this->obj_process_countdown = new OrderProcessCountdown();			
		}			
		/**
		 * 语言包
		 */
		$this->getlang("product");
		$this->getlang("product_countdown");
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
				/**
				 * 添加到店铺推荐商品列表
				 */
			case "store_recommended":
				$recommended = "1";
				$this->_updateproductstorerecommended($recommended);
				break;
				/**
				 * 从已添加到店铺推荐商品列表中删除
				 */
			case "cancel_store_recommended":
				$recommended = "0";
				$this->_updateproductstorerecommended($recommended);
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
		 * 更新竞拍结束的商品(生成订单)
		 */
		$this->obj_process_countdown->updateProductOrderConutdown();
		/**
		 * 更新需要下架和上架的倒计时拍卖商品
		 */
		$this->obj_product_countdown->updateOfflineOrOnlineProduct();
        /**
         * 初始化查询条件
         */
		$condition = array();
		$condition['member'] = $_SESSION['s_login']['id']; 
		$condition['sell_type'] = '3'; 
		$condition['state'] = $state; 
		$condition['order'] = '3';
		$this->obj_page->pagebarnum(20);
		$product_array = $this->obj_product_countdown->getProductList($condition, $this->obj_page,'member_list');
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		unset($condition);	
		for($i=0;$i<count($product_array);$i++){
			/**
			 * 创建时间
			 */
			$product_array[$i]['p_add_time'] = date("Y-m-d",$product_array[$i]['p_add_time']);
			/**
			 * 开始时间
			 */
			$product_array[$i]['cp_start_time'] = date("Y-m-d H:i:s",$product_array[$i]['cp_start_time']);
			/**
			 * 结束时间
			 */
			$product_array[$i]['cp_end_time'] = date("Y-m-d H:i:s",$product_array[$i]['cp_end_time']);
			/**
			 * 商品类别
			 */
            $product_array[$i]['p_sell_type_name'] = $this->_lang['langPProductCountdown'];
			$product_array[$i]['p_sold_num'] = $product_array[$i]['p_bid_num'];

			/**
			 * 当前价格
			 */
            if ($product_array[$i]['p_cur_price'] == $product_array[$i]['p_price'])
            {
                $product_array[$i]['p_cur_price'] = '';
            }
			/**
			 * 判断修改操作连接(是否存在买家竞拍)
			 */
			if ($product_array[$i]['cp_bid_num'] > 0) {
				$product_array[$i]['check_sign'] = 1;
			}
        }

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
		 * 模板判断(出售中/仓库里)
		 */
		$page = $this->_input['action'] == "list_instock" ? "own_product_countdown.list_instock" : "own_product_countdown.manage";
		$this->showpage($page);
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
		/**
		 * 判断是否允许下架
		 */
		if (is_array($this->_input['chboxPid'])){
			foreach ($this->_input['chboxPid'] as $k => $value){
				/**
				 * 不允许下架
				 */
				if ($this->_input['check_sign'][$value] != ''){
					unset($this->_input['chboxPid'][$k]);
				}
			}
		}
		/**
		 * 商品数量为空
		 */
		if (count($this->_input['chboxPid']) == 0){
			$this->redirectPath("succ", '', $this->_lang['langPNotSelectProduct']);
		}
		/**
		 * 取当前会员信息
		 */
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
		/**
		 * 上架
		 */
		if($this->_input['state'] == "1"){
			/**
			 * 判断发布商品数量限制
			 */
			CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id'],array('sell_num'=>count($this->_input['chboxPid'])+$member_array['sell_product_count']));
		}
		/**
		 * 取当前会员所卖商品信息
		 */
		$condition['member'] = $_SESSION['s_login']['id'];
		$member_product = $this->obj_product_countdown->getProductList($condition, $page, 'member_list');
		/**
		 * 上架商品操作
		 */
		if($this->_input['state'] == "1"){
			if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){		
				/**
				 * 按商品数量收费
				 */
				$member_array['product_number'] = $member_array['product_number']?$member_array['product_number']:0;
				$count_onsale = count($this->_input['chboxPid']);
				/**
				 * 如果上架商品和已商家商品数量相加大于 限制数量，则报错
				 */
				if ($member_array['product_number'] <= (count($member_product)+$count_onsale)){
					$this->redirectPath("error", './own_shop_pay.php?action=pay', $this->_lang['langPCanSaleNumberMax']);
				}
			}
			if (is_array($this->_input['chboxPid'])) {
				/**
				 * 卖家保证金比例
				 */
				$seller_margin = '';
				$seller_margin = empty($this->_configinfo['countdown']['seller_margin']) ? 0 : $this->_configinfo['countdown']['seller_margin'];				
				foreach ($this->_input['chboxPid'] as $p_code) {
					/**
					 * 更新主表上架状态
					 */
					$update_array = array();
					$update_array["p_state"] = "'1'";
					$update_array["p_auto_publish"] = "'0'";	
					$update_array["p_start_time"] = "p_end_time";
					$update_array["p_end_time"] = "p_end_time+7*24*60*60";					
					$this->obj_product_countdown->updateProductState($p_code,$update_array,"product");
					unset($update_array);
					/**
					 * 更新扩展表
					 */
					$update_array = array();				
					$update_array["cp_start_time"] = "cp_end_time";	
					$update_array["cp_end_time"] = "cp_end_time+7*24*60*60";	
					$this->obj_product_countdown->updateProductState($p_code,$update_array,"countdown_product");
					unset($update_array);	
					/**
					 * 获取商品价格
					 */
					$product_array = array();
					$product_array = $this->obj_product_countdown->getProductRow($p_code);
					$margin = @round($product_array['cp_price']*$seller_margin/100);
					/**
					 * 不足5元按照5元计算
					 */
					$margin = $margin < 5 ? 5 : $margin;	
					/**
					 * 收取保证金
					 */
					$this->_bonds($margin,$p_code);
					unset($product_array,$margin);									
				}
			}	
			/**
			 * 更新商品发布数量的统计信息
			 */
			$update_product_statis = $this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'sell');
			/**
			 * 删除以往的该商品的竞拍信息
			 */
			if (is_array($this->_input['chboxPid'])) {
				foreach ($this->_input['chboxPid'] as $p_code) {
					$this->obj_product_bid->delBid($p_code);
				}
			}						
			$this->redirectPath("succ", '', $this->_lang['langProductMUpRackOk']);
		}else{
			/**
			 * 下架商品操作
			 */
			if (is_array($this->_input['chboxPid'])) {
				foreach ($this->_input['chboxPid'] as $p_code) {
					/**
					 * 更新主表下架状态
					 */
					$update_array = array();
					$update_array["p_state"] = "'0'";
					$update_array["p_recommended"] = "'0'";
					$update_array["p_store_recommended"] = "'0'";		
					$this->obj_product_countdown->updateProductState($p_code,$update_array,"product");
					unset($update_array);
					/**
					 * 更新扩展表
					 */
					$update_array = array();
					$update_array["cp_bid_num"] = "'0'";
					$update_array["cp_price_step"] = "NULL";
					$update_array["seller_margin"] = "'0'";					
					$update_array["buyer_margin"] = "'0'";					
					$update_array["cp_cur_price"] = "cp_price";	
					$this->obj_product_countdown->updateProductState($p_code,$update_array,"countdown_product");
					unset($update_array);	
					/**
					 * 退还卖家保证金
					 */
					$this->backMargin($p_code,$this->_lang['langPOffBackSellerMargin']);									
				}
			}						
			/**
			 * 更新商品发布数量、推荐商品数量的统计信息
			 */
			$update_product_statis = $this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'both');
			$this->redirectPath("succ", '', $this->_lang['langProductMDownRackOk']);
		}
	}
	
	/**
	 * 退还卖家已交商品保证金
	 *
	 * @param string $p_code
	 * @param string $remark
	 * @return boolean
	 */
	function backMargin($p_code,$remark) {
		if ($p_code != '') {
			/**
			 * 计算已经收取的保证金
			 */
			$condition = array();
			$condition['member_id'] = $_SESSION['s_login']['id'];
			$condition['p_code'] = $p_code;
			$condition['cm_state'] = '0';
			$condition['cm_type'] = '0';
			$condition['cm_member_type'] = '1';
			$margin_array = $this->obj_product_countdown->getMargin($condition);
			unset($condition);	
			/**
			 * 退还已交保证金
			 */
			if ($margin_array['cm_id'] != '') {		
				$this->obj_process_countdown->marginBack($margin_array['cm_margin'],$_SESSION['s_login']['id'],'9',$remark,$p_code);
			}	
			return true;			
		} else {
			return false;
		}
	}	
	
	/**
	 * 卖家发布商品收取保证金
	 *
	 * @param int $margin
	 * @param string $sp_code
	 */
	function _bonds($margin,$sp_code) {
		if ($margin != '' && $sp_code != '') {
			/**
			 * 保证金扣除
			 */
			$result = $this->obj_process_countdown->bondsSeller($margin,$sp_code,$this->_lang['langPOnBackSellerMargin']);
			if ($result['error'] == 1) {
				$this->redirectPath("error","../member/own_product.php?action=sell",$result['error_msg']);
			}
			/**
			 * 记录扣除保证金
			 */
			$value_array = array();
			$value_array['member_id'] = $_SESSION['s_login']['id'];
			$value_array['p_code'] = $sp_code;
			$value_array['cm_margin'] = $margin;
			/**
			 * 卖家保证金
			 */
			$value_array['cm_member_type'] = 1; 
			$value_array['cm_time'] = time();
			$this->obj_product_countdown->addMargin($value_array);
			unset($value_array);			
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
}
$product_list_manage = new OwnProductListManage();
$product_list_manage->main();
unset($product_list_manage);
?>