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
 * FILE_NAME : product_group.php
 * 团购商品前台程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Jun 14 01:05:38 GMT 2010
 */
require ("../global.inc.php");
class ShowGroupProduct extends CommonFrameWork {
	/**
	 * 频道对象
	 *
	 * @var obj
	 */
	var $obj_channel;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 团购对象
	 *
	 * @var obj
	 */
	var $obj_product_group;
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
	 * 外汇对象
	 *
	 * @var obj
	 */
	var $obj_exchange;
	/**
	 * 会员评价对象
	 *
	 * @var obj
	 */
	var $obj_member_score;
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;

	function main() {
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建团购对象
		 */	
		if(!is_object($this->obj_product_group)) {
			require_once("product_group.class.php");
			$this->obj_product_group = new ProductGroupClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
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
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("product,product_group");

		switch ($this->_input['action']) {
			case "buy":
				/**
				 * 判断是否登陆
				 */
				$this->isMember();
				$this->_buy();
				break;
			case "order":
				/**
				 * 判断是否登陆
				 */
				$this->isMember();
				$this->_orderproduct();
				break;
			default:
				$this->_view();
		}
	}
	/**
	 * 团购商品展示页面
	 */	
	function _view() {
		//检测
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductId'])
		);
		$error = $this->obj_validate->validate();

		if($error != ""){
			$this->redirectPath ( "error", "", $error );
		}else{
			$p_id = $this->_input['p_code'];
			/**
			 * 取团购商品信息
			 */
			$product_row = $this->obj_product->getProductRow($this->_input["p_code"]);
			/**
			 * 取团购商品扩展信息
			 */			
			$group_product = $this->obj_product->getProductGroupRow($this->_input['p_code']);
			/**
			 * 判断该商品是否存在
			 */
			if (empty($product_row)){
				$this->redirectPath ( "error", "", $this->_lang['errProductId'] );
			}
			/**
			 * 判断商品类型是否与访问类型一致
			 */
			if (!$this->checkSellType($product_row['p_sell_type'],2,$product_row['p_code'])) {
				$this->redirectPath ( "error", "../index.php", $this->_lang['errPProductIsEmpty'] );
			}
			/**
			 * 获取商品类别路径
			 */
			$product_class_string = $this->_get_product_class_path($product_row['pc_id']);
			/**
			 * 语言包
			 */
			$this->getlang("productview");
			/**
			 * 图片列表
			 */
			$condition_pic['p_code'] = $product_row['p_code'];
			$array = $this->obj_product->getProductPic($condition_pic,$page);
			if (is_array($array)){
				$pic_array = array();
				$j=0;
				for ($i=0;$i<count($array);$i++){
					if (file_exists(BasePath.'/'.$array[$i]['p_pic'])){
						$pic_array[$j]['p_pic'] = $array[$i]['p_pic'];
						$temp = @explode('.',$array[$i]['p_pic']);
						$pic_array[$j]['big_pic'] = $temp[0].'_big.'.$temp[1];
						$pic_array[$j]['mid_pic'] = $temp[0].'_mid.'.$temp[1];
						$pic_array[$j]['small_pic'] = $temp[0].'_small.'.$temp[1];
						$j++;
						unset($temp);
					}
				}
			}

			/**
			 * 取得商品属性
			 */
			require_once("attribute.class.php");
			$obj_product_attribute = new AttributeClass();
			$condition_attribute['pc_id'] = $product_row['pc_id'];
			$product_attribute = $obj_product_attribute->getAttributeList($condition_attribute,$page);
			unset($condition_attribute);
			if(count($product_attribute)>0){
				$have_attribute = 1;
				$condition_attribut_content['pc_id'] = $product_row['pc_id'];
				$product_attribute_content = $obj_product_attribute->getAttributeWithContentList($condition_attribut_content,$page);
				unset($condition_attribut_content);
			}
			$attribute_condition_str = " and p_id = '" . $p_id . "'";
			$product_have_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $this->obj_page);

			unset($obj_product_attribute);
			$i=0;
			if(is_array($product_have_attribute)){
				foreach ($product_have_attribute as $key => $value){
					$ac_content = explode(',', $value['pac_content']);
					foreach ($ac_content as $k => $v){
						$pac_attribute[$i] = $v;
						$i++;
					}
				}
			}
			if(is_array($product_attribute_content)){
				foreach ($product_attribute_content as $key => $value){
					foreach ($value as $k => $v){
						if(is_array($pac_attribute) && in_array($v['ac_id'], $pac_attribute)){
							$product_attribute_content[$key][$k]['ischecked'] = 1;
						}
					}
				}
			}
			/**
			 * 取得卖家资料
			 */
			$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'*','more');
			$seller_info['regist_time'] = date("Y-m-d",$seller_info['regist_time']);
			$seller_info['sms_name']	= urlencode($seller_info['login_name']);
			/**
			 * 得到卖家好评率
			 */
			require_once("score.class.php");
			$obj_score = new ScoreClass();
			$seller_info['s_rate'] = $obj_score->getScorePercent($product_row['member_id'],"s");
			$seller_info['b_rate'] = $obj_score->getScorePercent($product_row['member_id'],"b");
			unset($obj_score);
			/**
			 * 买卖家信用
			 */
			$buy_score = $this->obj_member->creditLevel($seller_info['buy_score']);
			$sale_score = $this->obj_member->creditLevel($seller_info['sale_score']);
			/**
			 * 店铺资料
			 */
			$shop_info = $this->obj_shop->getOneShopByMemeberId($product_row['member_id'],'1');

			/**
			 * 剩余时间计算
			 */
			$left_time = $product_row['p_end_time'] - time();
			if ($left_time > 0){
				$product_row['left_days'] = intval($left_time / (24*60*60));
				$product_row['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
				$product_row['left_minutes'] = intval((($left_time % (60*60))) / 60);
				$left_time = $product_row['left_days'].$this->_lang['langPday'].$product_row['left_hours'].$this->_lang['langPhour'].$product_row['left_minutes'].$this->_lang['langPminute'];
			}else {
				$left_time = '0';
			}

			/**
			 * 商品留言信息
			 */
			require_once("productmessage.class.php");
			$obj_product_message = new ProductMessageClass();
			$message_array = $obj_product_message->getMessage($page,$product_row['p_id']);
			if (is_array($message_array)){
				foreach ($message_array as $k => $v){
					$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
					$message_array[$k]['re_time'] = @date("Y-m-d H:i",$v['re_time']);
				}
			}
			unset($obj_product_message);
			/**
			 * 更新商品浏览次数
			 */
			$update_product['p_code'] = $product_row['p_code'];
			$update_product['txtViewNum'] = 1;
			$this->obj_product->updateProductViewNum($update_product);

			/**
			 * 取地区内容
			 */
			if ($product_row['p_area_id'] !=''){
				require_once ("area.class.php");
				$obj_area = new AreaClass();
				$sel_area = $obj_area->getAreaPathList($product_row['p_area_id']);
				unset($obj_area);
			}
			/**
			 * 取品牌内容
			 */
			if ($product_row['p_pb_id'] !=''){
				require_once('product_brand.class.php');
				$obj_product_brand = new ProductBrandClass();
				$sel_brand = $obj_product_brand->getProductBrandPathList($product_row['p_pb_id']);
				unset($obj_product_brand);
			}
			/**
			 * 交易类型
			 */
			$product_row['p_type_name'] = $this->_b_config['p_type'][$product_row['p_type']];
			/**
			 * 写进 浏览过的宝贝 cookie名称 product_viewed
			 */
			$this->setReviewed($product_row['p_code']);
			/**
			 * 模板页头内容
			 */
			//剩余时间计算
			$product_row['p_end_time'] = $product_row['p_end_time'] - time();

			$title_p_name = $product_row['p_name'].' - ';
			$keyword_p_name = $product_row['p_keywords'];
			$description_p_name = $product_row['p_description'];

			//判断是否登录
			if ($_SESSION["s_login"]['login'] == 1){
				$this->output('login_sign',1);
				//判断是否有店铺
				if ($_SESSION["s_login"]['type'] == '1'){
					$this->output('shop_sign',1);
					$this->output('shop_del',$_SESSION["s_shop"]['if_del']);//删除状态
				}
			}

			//插件列表
			$app_list = $this->menuAppList();
			/**
			 * 页面输出
			 */
			$quickLinks = $this->getQuickLinks();
			$this->output('QuickLinks',$quickLinks[0]);
			$this->output('app_list',$app_list);
			$this->output('channel_list',$this->_get_channel_list());

			/**
			 * 页面输出
			 */
			$seller_info['QQ']	= !empty($seller_info['QQ']) ? explode(",",$seller_info['QQ']) : $seller_info['QQ'];
			$seller_info['MSN']	= !empty($seller_info['MSN']) ? explode(",",$seller_info['MSN']) : $seller_info['MSN'];
			$seller_info['SKYPE']	= !empty($seller_info['SKYPE']) ? explode(",",$seller_info['SKYPE']) : $seller_info['SKYPE'];
			$seller_info['TAOBAO']	= !empty($seller_info['TAOBAO']) ? explode(",",$seller_info['TAOBAO']) : $seller_info['TAOBAO'];
			$this->output("title_message", $title_p_name);
			$this->output("keyword_message", $keyword_p_name);
			$this->output("meta_desc", $description_p_name);
			$this->output("buy_score", $buy_score);
			$this->output("sale_score", $sale_score);
			$this->output('product_row',$product_row);
			$this->output('group_product',$group_product);
			$this->output('product_class_string',$product_class_string);
			$this->output('pic_array',$pic_array);
			$this->output("have_attribute", $have_attribute);
			$this->output("product_attribute", $product_attribute);
			$this->output("product_attribute_content", $product_attribute_content);
			$this->output("product_have_attribute", $pac_attribute);
			$this->output("message_array", $message_array);
			$this->output("seller_info", $seller_info);
			$this->output("sel_area", $sel_area);
			$this->output("sel_brand", $sel_brand);
			$this->output("lefttime", $left_time);
			$this->output("shop_info", $shop_info);
			$this->output("s_login_id",$_SESSION['s_login']['id']);
			$this->showpage("product_group.view");
		}
	}
	/**
	 * 团购商品购买页面
	 */	
	function _buy() {
		/**
		 * 判断用户组权限
		 */
		CheckPermission::memberGroupPermission('buy',$_SESSION['s_login']['id']);
		/**
		 * 取商品信息
		 */
		$product_row = $this->obj_product->getProductRow($this->_input['p_code']);
		/**
		* 取团购商品扩展信息
		*/			
		$group_product = $this->obj_product->getProductGroupRow($this->_input['p_code']);
		/**
		* 判断商品类型是否与访问类型一致
		*/
		if (!$this->checkSellType($product_row['p_sell_type'],2,$product_row['p_code'])) {
			$this->redirectPath ( "error", "../index.php", $this->_lang['errPProductIsEmpty'] );
		}
		/**
		 * 判断会员是否和卖家相同
		 */
		if($_SESSION['s_login']['id'] == $product_row['member_id']){
			$this->redirectPath("error","",$this->_lang['errBuyOwnProduct']);
		}
		/**
		 * 判断商品是否为空
		 */
		if (empty($product_row)){
			$this->redirectPath("error",'',$this->_lang['errProductInfoEmpty']);
		}
		/**
		 * 判断商品是否上架
		 */
		if ($product_row['p_state'] == '0' || ($product_row['p_end_time'] - time()) < 0){
			$this->redirectPath("error","",$this->_lang['langProductStateIsZero']);
		}
		/**
		 * 获取商品类别路径
		 */
		$product_class_string = $this->_get_product_class_path($product_row['pc_id']);

		/**
		 * 判断抛出错误
		 */
		if ($output['error'] == '1'){
			$this->redirectPath ( "error", '', $output['error_msg']);
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

		//取支持的货币种类
		if (strstr($product_row['p_currency_category'],'|')){
			$currency = explode('|',trim($product_row['p_currency_category'],'|'));
		}else {
			$currency = array($product_row['p_currency_category']);
		}
		//去货币对应中文名称的数组
		$exchange_remark = array();
		$exchange_remark = $this->obj_exchange->getExchangeArray();
		//货币类型列表
		$condition = array();
		$condition['state'] = 1;
		$exchange_array = $this->obj_exchange->listExchange($condition,$page);
		//根据汇率计算商品的价格
		$exprice_array = array();
		$price = $product_row['p_group_price'];
		$i = 0;
		if (is_array($exchange_array)) {
			foreach ($exchange_array as $kex => $vex) {
				//关闭除人民币外的货币类型
				if ($vex['exchange_name'] != 'CNY') {
					continue;
				}
				foreach ($currency as $kpay => $vpay) {
					if ($vex['exchange_name'] == $vpay){
						if ($i == 0) {
							$exchange_array[$kex]['is_checked'] = 1;//默认数组第一个选中
						}
						$exprice_array[$vpay] = $vex['exchange_rate']==0?'0':(number_format($price*100/$vex['exchange_rate'],2)<=0.01?'0.01':number_format($price*100/$vex['exchange_rate'],2));
						$i++;
					}
				}
			}
		}
		//取支持的货币种类
		if (strstr($product_row['p_pay_method'],'|')){
			$paymethod = explode('|',trim($product_row['p_pay_method'],'|'));
		} else {
			$paymethod = array($product_row['p_pay_method']);
		}
		//根据商品支持的支付方式查找支付模块对应支持的货币类型
		if (is_array($paymethod)){
			foreach ($paymethod as $k => $v){
				if (file_exists(BasePath.'/payment/'.$v."/payment_module.php") && $this->_configinfo['payment'][$v] == 1) {
					include_once (BasePath.'/payment/'.$v."/payment_module.php");
					$classname = $v."PaymentMethod";
					$obj_module = new $classname;
					$array = $obj_module->payment_param();
					//判断货币种类是否有值，如果没有
					if (!empty($array['currency'])){
						$currency_array = "";
						foreach ($array['currency'] as $k2 => $v2){
							if ($exchange_remark['CNY'] != ''){
								$currency_array[$v2] = $exchange_remark[$v2];
							}
						}
						if ($k == '0'){
							$payment_array[$k]['check'] = 1;
						}
						$payment_array[$k]['name'] = $array['name'];	//支付方式名称
						$payment_array[$k]['field'] = $array['field'];	//支付方式模块名称
						$payment_array[$k]['currency'] = $currency_array;	//支持的货币类型
						unset($currency_array);
					}
					unset($obj_module,$array);
				}
			}
		} else {
			$this->redirectPath("error","",$this->_lang['errPPaymentIsEmpty']);
		}
		//买家信息
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		unset($condition_member);
		/**
		 * 取地区内容
		 */
		require_once ("area.class.php");
		$obj_area = new AreaClass();
		$sel_area = $obj_area->getAreaPathList($product_row['p_area_id']);
		/**
		 * 取收货地址 地区
		 */
		require_once("receive.class.php");
		$obj_receive = new ReceiveClass();
		$receive_array = $obj_receive->getReceive($_SESSION['s_login']['id']);
		if (is_array($receive_array)){
			foreach ($receive_array as $k => $v){
				/**
				 * 第一个为选中内容
				 */
				if ($k == '0'){
					$receive_array[$k]['checked'] = '1';
				}
				/**
				 * 取已选择的地区内容
				 */
				if ($v['receive_area_id'] !=''){
					$receive_array[$k]['sel_area'] = $obj_area->getAreaPathList($v['receive_area_id']);
				}
			}
		}
		/**
		 * 卖家信息
		 */
		$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'login_name');
		$product_row['login_name'] = $seller_info['login_name'];
		/**
		* 提取商品中图名称
		*/
		if (!empty($product_row['p_pic'])) {
			$temp = @explode('.',$product_row['p_pic']);
			$product_row['mid_pic'] = $temp[0].'_mid.'.$temp[1];
		}
		/**
		 * 页面输出
		 */
		$this->output("product_row", $product_row);
		$this->output("group_product",$group_product);
		$this->output("receive_array", $receive_array);
		$this->output("payment_array",$payment_array);						//支付方式
		$this->output("exchange_array",$exchange_array);					//货币类型
		$this->output("member_array",$member_array);						//会员信息
		$this->output("receive_count", count($receive_array));
		$this->output("sel_area", $sel_area);
		$this->output("area_array", $area_array);
		$this->output("product_class_string", $product_class_string);
		$this->output("bid_now_number", $bid_now_number);

		$this->showpage("product_group.buy");
	}
	/**
	 * 团购商品购买操作
	 */	
	function _orderproduct() {
		/**
		 * 验证表单信息
		 */
		$this->obj_validate->setValidate(array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductId']));
		/**
		 * 判断收货地址是否是新增还是选择已有的
		 */
		if ($this->_input['bid_receive_code'] == 'new'){
			/**
			 * 新增
			 */
			$this->obj_validate->setValidate(array("input"=>$this->_input["receive_area_id"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langGroupBuyAreaFalse']));
			$this->obj_validate->setValidate(array("input"=>$this->_input["address"],"require"=>"true","message"=>$this->_lang['langGroupBuyAreaInfoFalse']));
			$this->obj_validate->setValidate(array("input"=>$this->_input["zip"],"require"=>"true","message"=>$this->_lang['langGroupBuyZipFalse']));
			$this->obj_validate->setValidate(array("input"=>$this->_input["receive_name"],"require"=>"true","message"=>$this->_lang['langGroupBuyrReceivenameFalse']));
			/**
			 * 判断手机和电话要二选一
			 */
			if ($this->_input['phone'] == '' && $this->_input['mobilephone'] == ''){
				$this->obj_validate->setValidate(array("input"=>$this->_input["phone"],"require"=>"true","message"=>$this->_lang['langGroupBuyrPhoneFalse']));
			}
		}else {
			/**
			 * 已有
			 */
			$this->obj_validate->setValidate(array("input"=>$this->_input["bid_receive_code"],"require"=>"true","message"=>$this->_lang['langGroupBuyrBidreceiveFalse']));
		}
		/**
			 * 取得商品信息
			 */
		$product_row = $this->obj_product->getProductRow($this->_input["p_code"]);
		/**
		 *  判断商品数量
		 */
		if (empty($this->_input['buy_num']) || $this->_input['buy_num'] > $product_row['p_storage']) {
			$this->obj_validate->setValidate(array("input"=>$this->_input["buy_num"],"require"=>"true","message"=>$this->_lang['langGroupBuyrPstorageFalse']));
		}
		/**
		 * 判断预付款余额
		 */
		if ($this->_input['txtPayment'] == 'predeposit') {
			if ($this->_input['available_predeposit'] < ($product_row['p_price']*$this->_input['buy_num']+$this->_input['tf_fee'])) {
				$this->obj_validate->setValidate(array("require"=>"true","message"=>$this->_lang['errPPredepositLessRemark']));
			}
		}
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 判断运费是否为空
			 */
			if("" == $this->_input["txtTfFee"]){
				$this->_input["txtTfFee"] = '0';
			}
			/**
			 * 判断商品类型是否与访问类型一致
			 */
			if (!$this->checkSellType($product_row['p_sell_type'],2,$product_row['p_code'])) {
				$this->redirectPath ( "error", "../index.php", $this->_lang['errPProductIsEmpty'] );
			}
			/**
			 * 判断会员是否和卖家相同
			 */
			if($_SESSION['s_login']['id'] == $product_row['member_id']){
				$this->redirectPath("error","",$this->_lang['errBuyOwnProduct']);
			}
			/**
			 * 判断商品是否为空
			 */
			if (empty($product_row)){
				$this->redirectPath("error",'',$this->_lang['errProductInfoEmpty']);
			}
			/**
			 * 判断商品是否上架
			 */
			if ($product_row['p_state'] == '0' || ($product_row['p_end_time'] - time()) < 0){
				$this->redirectPath("error","",$this->_lang['langProductStateIsZero']);
			}
			/**
			 * 新增收货地址
			 */
			if($this->_input["bid_receive_code"] == "new"){
				/**
				 * 新增收货地址
				 */
				/**
			 	 * 获得随机的唯一收货地址编码
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
				$this->_input['txtRcode'] = md5($receive_last_id.$random_string);
				$this->_input['member_id'] = $_SESSION['s_login']['id'];
				$this->_input['txtReceiveName'] = $this->_input['receive_name'];
				$this->_input['txtAddress'] = $this->_input['address'];
				$this->_input['txtMobilephone'] = $this->_input['mobilephone'];
				$this->_input['txtPhone'] = $this->_input['phone'];
				$this->_input['txtZip'] = $this->_input['zip'];
				$this->_input['area_id'] = $this->_input['receive_area_id'];
				$this->obj_receive->addReceive($this->_input);
				$this->_input["receive_code"] = $this->_input["txtRcode"];
			} else {
				$this->_input['receive_code'] = $this->_input['bid_receive_code'];
			}
			//买家会员ID
			$this->_input['txtBuyerId'] = $_SESSION['s_login']['id'];
			/**
			 * 买家名称
			 */
			$condition_member['id'] = $_SESSION['s_login']['id'];
			$buyer_array = $this->obj_member->getMemberInfo($condition_member,'login_name');
			$this->_input['buyer_name'] = $buyer_array['login_name'];
			unset($condition_member);
			/**
			 * 卖家名称
			 */
			$condition_member['id'] = $product_row['member_id'];
			$seller_array = $this->obj_member->getMemberInfo($condition_member,'login_name');
			$this->_input['seller_name'] = $seller_array['login_name'];
			unset($condition_member);

			/**
			 * 实例化团购操作类
			 */
			require_once('order_process_group.class.php');
			$obj_order_process = new OrderProcessGroup();

			//保证金收取
			$result = $obj_order_process->bondsBuyer($this->_input['need_margin']);
			if ($result['error'] == 1) {
				$this->redirectPath("error","",$result['error_msg']);
				exit;
			}
			//保证金记录添加
			$add_array = array();
			$add_array['member_id'] 	= $_SESSION['s_login']['id'];		//会员id
			$add_array['p_code'] 		= $product_row['p_code'];			//商品编号
			$add_array['cm_margin'] 	= $this->_input['need_margin'];		//保证金金额
			$add_array['cm_type']		= 2;								//保证金类型，2为团购
			$add_array['cm_time'] 		= time();							//时间
			$this->obj_product_group->addMargin($add_array);
			unset($add_array);

			/**
			 * 商品所在分类id/订单交易类型
			 */
			$this->_input['txtPcode'] = $product_row['p_code'];
			$this->_input['txtSellerId'] = $product_row['member_id'];
			$this->_input['txtPname'] = $product_row['p_name'];
			$this->_input['txtPcid'] = $product_row['pc_id'];
			$this->_input['txtUnitPrice'] = $this->_input['p_group_price'];
			$this->_input['txtBuyNum'] = $this->_input['buy_num'];
			$this->_input['txtTfFee'] = $this->_input['tf_fee'];
			$this->_input['txtReceiveId'] = $this->_input['receive_code'];
			$this->_input['photo_url'] = $product_row['p_pic'];
			$this->_input['sp_pay_mechod'] = $this->_input['txtPayment'];
			$this->_input['sell_type'] = 2;

			//生成订单
			$obj_order_process->_lang = $this->_lang;//语言包
			$result = $obj_order_process->order($this->_input);
			if ($result['error'] == '1'){
				$this->redirectPath('error','',$result['error_msg']);
			}else {
				$this->obj_product_group->updateGroupNum($product_row['p_code']);//团购购买人数统计
				if ($result['retrun_type'] == 'url'){
					if ($result['url_type'] == 'location'){
						header('location: '.$result['retrun_info']);
					}elseif ($result['url_type'] == 'redirect'){
						$this->redirectPath('succ',$result['retrun_info'],$result['url_message']);
					}
				}elseif ($result['retrun_type'] == 'showpage'){
					$this->showpage($result['retrun_info']);
				}
			}
		}
	}
	function _get_channel_list(){
		/**
		 * 创建频道对象
		 */
		if (!is_object($this->obj_channel)){
			require_once ("channel.class.php");
			$this->obj_channel = new ChannelClass();
		}
		//取导航频道
		$condition_channel["order_by"] = "channel_sort";
		$condition_channel["state"] = "0";
		$condition_channel["order_sort"] = "asc";
		$channel_all = $this->obj_channel->listChannel($condition_channel,$page);
		unset($condition_channel);
		return $channel_all;
	}
	/**
	 * 把浏览过的产品的产品号放到COOKIE中保存
	 *
	 * @param $pcode 商品编号
	 * @return boolean 布尔类型的返回结果
	 */
	function setReviewed($pcode){

		$str = $this->getCookies('c_product_viewed');
		if("" != $str){
			$cookie_array = @explode("|", trim($str,'|'));
			if (count($cookie_array) >= 4){
				array_pop($cookie_array);
				$cookie_pcode = @implode('|',$cookie_array);
			}else{
				$cookie_pcode = @implode('|',$cookie_array);
			}
		}else{
			$cookie_array=array();
		}
		/**
		 * 如果产品在cookie里已有，则不记录
		 */
		if (!@in_array($pcode,$cookie_array)){
			if (count($cookie_array) == 0) {
				$cookie_pcode = $pcode;
			}else {
				$cookie_pcode =  $pcode."|".$cookie_pcode;
			}
		}
		$this->setCookies("c_product_viewed", $cookie_pcode);
		return true;
	}
	/**
	 * 通过商品类别ID取商品类别路径
	 *
	 * @param int $pc_id 商品类别ID
	 * @return string $product_class_string 字符串形式的返回结果
	 */
	function _get_product_class_path($pc_id){
		/**
		 * 商品类别
		 */
		if (!file_exists(BasePath.'/cache/ProductClass_show_single.php')){
			/**
			 * 实例化商品类别类
			 */
			if (!is_object($this->obj_product_cate)){
				require_once("productclass.class.php");
				$this->obj_product_cate = new ProductCategoryClass();
			}
			$this->obj_product_cate->restartClass();
		}
		/**
		 * 缓存数组名为$node_cache
		 */
		require_once(BasePath.'/cache/ProductClass_show_single.php');
		/**
		 * 判断是否存在该商品类别ID
		 */
		$exist_sign = false;
		foreach ($node_cache as $k => $v){
			if ($v[0] == $pc_id){
				$exist_sign = true;
				break;
			}
		}
		if ($exist_sign === false){
			return false;
		}
		$product_class_string = $this->_recursive_product_class($node_cache,$pc_id);
		return $product_class_string;
	}
	/**
	 * 递归去取商品类别路径
	 *
	 * @param array $pc_array 商品类别缓存数组
	 * @param  int $pc_id 商品类别ID
	 * @return  string 字符串形式的返回结果
	 */
	function _recursive_product_class($pc_array,$pc_id){
		if (is_array($pc_array)){
			$temp = '';
			foreach ($pc_array as $k => $v){
				/**
				 * 判断是否是该类别
				 */
				if ($v[0] == $pc_id){
					$temp = $v;
					break;
				}
			}
			$product_class_string .= '<a href="'.$this->_configinfo['websit']['site_url'].'/home/product.php?action=list&searchcate='.$temp[0].'" target="_blank">';
			$product_class_string .= $temp[2];
			$product_class_string .= '</a>';
			/**
			 * 判断是否具有父类，如果有，那么递归获取
			 */
			if ($v[1] != '0'){
				$parent_class_string = $this->_recursive_product_class($pc_array,$v[1]);
			}
			return $parent_class_string.' > '.$product_class_string;
		}
	}
}
$product_group = new ShowGroupProduct();
$product_group->main();
unset($product_group);
?>