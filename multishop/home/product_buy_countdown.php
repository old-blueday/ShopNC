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
 * FILE_NAME :product_buy_countdown.php
 * 倒计时拍卖商品购买
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 11:05:32 CST 2010
 */
require ("../global.inc.php");

class ProductBuyCountdown extends CommonFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 倒计时拍卖商品对象
	 *
	 * @var object
	 */
	var $obj_product_countdown;
	/**
	 * 倒计时拍卖类
	 *
	 * @var object
	 */
	var $obj_countdown;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;
	/**
	 * 外汇对象
	 *
	 * @var obj
	 */
	var $obj_exchange;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 商品分类对象
	 *
	 * @var object
	 */
	var $objProductCate;

	function main(){
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 实例化倒计时拍卖商品类对象
		 */
		if (!is_object($this->obj_product_countdown)) {
			include_once("product_countdown.class.php");
			$this->obj_product_countdown = new ProductCountdownClass();
		}
		/**
		 * 倒计时拍卖类
		 */
		if (!is_object($this->obj_countdown)) {
			include_once("order_process_countdown.class.php");
			$this->obj_countdown = new OrderProcessCountdown();
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
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 收货地址
		 */
		if (!is_object($this->obj_receive)){
			require_once("receive.class.php");
			$this->obj_receive = new ReceiveClass();
		}
		/**
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}
		/**
		 * 实例化商品类别对象
		 */
		if (!is_object($this->objProductCate)){
			require_once("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		//判断用户组权限
		CheckPermission::memberGroupPermission('buy',$_SESSION['s_login']['id']);

		/**
		 * 语言包
		 */
		$this->getlang("product,product_countdown");

		switch ($this->_input['action']){
			case "buy":
				$this->_buyproduct();
				break;
			case "order":
				$this->_orderproduct();
				break;
		}
	}
	/**
	 * 商品竞拍确认页面
	 *
	 */
	function _buyproduct() {
		/**
		 * 判断是否登陆
		 */
		$this->isMember();
		/**
		 * 判断竞拍是否开始
		 */
		if ($this->_input['cp_start_time'] > time()) {
			$this->redirectPath("error","",$this->_lang['langPBidBeginNo']);
		}
		/**
		 * 判断竞拍是否结束
		 */
		if ($this->_input['cp_end_time'] < time()) {
			$this->redirectPath("error","",$this->_lang['langPCountdownOver']);
		}
		/**
		 * 判断会员是否和卖家相同
		 */
		if($_SESSION['s_login']['id'] == $this->_input["seller_id"]){
			$this->redirectPath("error","",$this->_lang['errBuyOwnProduct']);
		}
		/**
		 * 判断商品是否为空
		 */
		if ($this->_input['item_id'] == ''){
			$this->redirectPath("error","../index.html",$this->_lang['errProductInfoEmpty']);
		}
		/**
		 * 取主表商品信息
		 */
		$product_array = $this->obj_product->getProductRow($this->_input['item_id']);

		/**
		* 判断商品类型是否与访问类型一致
		*/
		if (!$this->checkSellType($product_array['p_sell_type'],3,$product_array['p_code'])) {
			$this->redirectPath ( "error", "../index.php", $this->_lang['errPProductIsEmpty'] );
		}
		/**
		 * 取倒计时拍卖商品信息
		 */
		$product_countdown_array = $this->obj_product_countdown->getProductRow($product_array['p_code']);
		/**
		 * 取得导航分类信息
		 */
		$navi_class_array = $this->objProductCate->getProductClassPathListAll($product_array['pc_id']);
		$navi_class_array = @array_reverse($navi_class_array);
		/**
		 * 取得商品的竞拍信息(最低出价)
		 */
		$product_countdown_array = $this->obj_countdown->buy($product_countdown_array);
		if ($product_countdown_array['error'] == 1) {
			$this->redirectPath("error","",$product_countdown_array['error_msg']);
			exit;
		}
		/**
		 * 获取卖家所在地
		 */
		if (!is_object($this->obj_area)) {
			include_once("area.class.php");
			$this->obj_area = new AreaClass();
		}
		$seller_area_array = $this->obj_area->getAreaPathList($product_array['p_area_id']);
		/**
		 * 卖家信息
		 */
		$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_array['member_id']),'login_name');
		/**
		 * 买家信息
		 */
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		unset($condition_member);
		/**
		 * 取收货地址 地区
		 */
		$receive_array = $this->obj_receive->getReceive($_SESSION['s_login']['id']);
		if (is_array($receive_array)){
			foreach ($receive_array as $k => $v){
				/**
				 * 取已选择的地区内容
				 */
				if ($v['receive_area_id'] !=''){
					$receive_array[$k]['sel_area'] = $this->obj_area->getAreaPathList($v['receive_area_id']);
				}
			}
		}
		/**
		 * 地区内容
		 */
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					/**
					 * 1是父ID，0不是
					 */
					$v['is_parent'] = $v[5];
					$area_array[] = $v;
				}
			}
		}
		unset($array);

		/**
		 * 取支持的货币种类
		 */
		if (strstr($product_array['p_currency_category'],'|')){
			$currency = explode('|',trim($product_array['p_currency_category'],'|'));
		}else {
			$currency = array($product_array['p_currency_category']);
		}
		/**
		 * 去货币对应中文名称的数组
		 */
		$exchange_remark = array();
		$exchange_remark = $this->obj_exchange->getExchangeArray();
		/**
		 * 货币类型列表
		 */
		$condition = array();
		$condition['state'] = 1;
		$exchange_array = $this->obj_exchange->listExchange($condition,$page);
		/**
		 * 根据汇率计算商品的价格
		 */
		$exprice_array = array();
		$price = $product_countdown_array['bid_price'];
		$i = 0;
		if (is_array($exchange_array)) {
			foreach ($exchange_array as $kex => $vex) {
				/**
				 * 关闭除人民币外的货币类型
				 */
				if ($vex['exchange_name'] != 'CNY') {
					continue;
				}
				foreach ($currency as $kpay => $vpay) {
					if ($vex['exchange_name'] == $vpay){
						if ($i == 0) {
							/**
							 * 默认数组第一个选中
							 */
							$exchange_array[$kex]['is_checked'] = 1;
						}
						$exprice_array[$vpay] = $vex['exchange_rate']==0?'0':(number_format($price*100/$vex['exchange_rate'],2)<=0.01?'0.01':number_format($price*100/$vex['exchange_rate'],2));
						$i++;
					}
				}
			}
		}
		/**
		 * 取支持的货币种类
		 */
		if (strstr($product_array['p_pay_method'],'|')){
			$paymethod = explode('|',trim($product_array['p_pay_method'],'|'));
		}else {
			$paymethod = array($product_array['p_pay_method']);
		}
		/**
		 * 根据商品支持的支付方式查找支付模块对应支持的货币类型
		 */
		if (is_array($paymethod)){
			foreach ($paymethod as $k => $v){
				if (file_exists(BasePath.'/payment/'.$v."/payment_module.php") && $this->_configinfo['payment'][$v] == 1) {
					include_once (BasePath.'/payment/'.$v."/payment_module.php");
					$classname = $v."PaymentMethod";
					$obj_module = new $classname;
					$array = $obj_module->payment_param();
					/**
					 * 判断货币种类是否有值，如果没有
					 */
					if (!empty($array['currency'])){
						$currency_array = "";
						foreach ($array['currency'] as $k2 => $v2){
							if ($exchange_remark['CNY'] != ''){
								$currency_array[$v2] = $exchange_remark[$v2];
							}
						}
						/**
						 * 支付方式名称
						 */
						$payment_array[$k]['name'] = $array['name'];
						/**
						 * 支付方式模块名称
						 */
						$payment_array[$k]['field'] = $array['field'];
						/**
						 * 支持的货币类型
						 */
						$payment_array[$k]['currency'] = $currency_array;
						unset($currency_array);
					}
					unset($obj_module,$array);
				}
			}
		} else {
			$this->redirectPath("error","",$this->_lang['errPPaymentIsEmpty']);
		}
		/**
		* 提取商品中图名称
		*/
		if (!empty($product_array['p_pic'])) {
			$temp = @explode('.',$product_array['p_pic']);
			$product_array['mid_pic'] = $temp[0].'_mid.'.$temp[1];
		}
		/**
		 * 页面显示
		 */
		$this->output("product_array",$product_array); 						//主表商品信息
		$this->output("product_countdown_array",$product_countdown_array);	//倒计时拍卖商品信息
		$this->output("seller_area_array",$seller_area_array);				//卖家所在地区
		$this->output("seller_info",$seller_info);							//卖家所在地区
		$this->output("receive_array",$receive_array);						//收货地址
		$this->output("area_array",$area_array);							//地区内容
		$this->output("member_array",$member_array);						//买家信息
		$this->output("payment_array",$payment_array);						//支付方式
		$this->output("exchange_array",$exchange_array);					//货币类型
		$this->output("navi_class_array",$navi_class_array);				//导航分类
		$this->output("exprice_array",$exprice_array);						//商品支持的货币类型(类型=>价格)
		$this->showpage("product_countdown.buy");
	}
	/**
	 * 倒计时拍卖商品竞拍
	 *
	 */
	function _orderproduct() {
		$input_array = array();
		$input_array = $this->_input;
		/**
		 * 验证表单信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>strtoupper($input_array['checkcode']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['alertCodeErr']),
		array("input"=>$this->_input["need_margin"],"require"=>"true","message"=>$this->_lang['langPCountdownOrderChecka']),
		array("input"=>$input_array["p_code"],"require"=>"true","message"=>$this->_lang['errPcode']),
		array("input"=>$input_array["select_payment"],"require"=>"true","message"=>$this->_lang['langPCountdownOrderCheckb']),
		);
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 收货地址入库
			 */
			if ($input_array['receive'] == '0' || $input_array['receive'] == '')  {
				/**
			 	 * 添加收获地址
			 	 */
				$receive_last_id = $this->obj_receive->getReceiveLastId();
				if("" == $receive_last_id){
					$receive_last_id = 1;
				}else{
					$receive_last_id += 1;
				}
				$chars = array(
				"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
				"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
				"w", "x", "y", "z"
				);
				$random_string = Common::genRandomString($chars, 4);
				$input_array["txtRcode"] = md5($receive_last_id.$random_string);
				$input_array["member_id"] = $_SESSION['s_login']['id'];
				$this->obj_receive->addReceive($input_array);
				$input_array["checkaddr"] = $input_array["txtRcode"];
			} else {
				$input_array["checkaddr"] = $input_array['receive'];
			}
			/**
			 * 竞拍记录入库
			 */
			$result = $this->obj_countdown->order($input_array);
			$back_url = "product_countdown.php?action=view&pid={$input_array['p_code']}";
			if ($result['error'] == 1) {
				$this->redirectPath("error",$back_url,$result['error_msg']);
				exit;
			} else {
				$back_url = $result['retrun_info'];
			}
			/**
			 * 更新商品信息(竞拍次数、当前价格)
			 */
			$update_array = array();
			$update_array['p_code'] = $input_array['p_code'];
			$update_array['cp_cur_price'] = $input_array['cb_price'];
			$this->obj_product_countdown->bidUpdateProduct($update_array);
			/**
			 * 扣除过保证金则不再收取
			 */
			$condition = array();
			$condition['member_id'] = $_SESSION['s_login']['id'];
			$condition['p_code']	= $input_array['p_code'];
			$margin_array = $this->obj_product_countdown->getMargin($condition,'cm_id');
			unset($condition);
			if ($margin_array['cm_id'] == '') {
				/**
				 * 保证金收取
				 */
				$result = $this->obj_countdown->bondsBuyer($input_array['need_margin'],$input_array['p_code']);
				if ($result['error'] == 1) {
					$this->redirectPath("error","",$result['error_msg']);
					exit;
				}
				/**
				 * 保证金记录添加
				 */
				$add_array = array();
				/**
				 * 会员id
				 */
				$add_array['member_id'] 	= 	$_SESSION['s_login']['id'];
				/**
				 * 商品编号
				 */
				$add_array['p_code'] 		= 	$input_array['p_code'];
				/**
				 * 保证金金额
				 */
				$add_array['cm_margin'] 	= 	$input_array['need_margin'];
				/**
				 * 时间
				 */
				$add_array['cm_time'] 		= 	time();
				$this->obj_product_countdown->addMargin($add_array);
				unset($add_array);
			}
			$this->redirectPath('succ',$back_url,$this->_lang['langPBidSucc']);
		}
	}
}
$product_buy_countdown = new ProductBuyCountdown();
$product_buy_countdown->main();
unset($product_buy_countdown);
?>