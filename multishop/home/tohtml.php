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
 * FILE_NAME : tohtml.php   FILE_PATH : E:\www\multishop\trunk\home\tohtml.php
 * ....商品静态页AJAX调用部分
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Sep 05 13:46:41 CST 2008
 */

require ("../global.inc.php");

class ToHtml extends CommonFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	var $objProductCate;
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
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
	 * 商品订单对象
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
	 * 价格加价对象
	 *
	 * @var obj
	 */
	var $obj_up_price;
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
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("product");

		switch ($this->_input['action']){
			case "head":
				$this->_gethead();
				break;
			case "product":
				$this->_getproduct();
				break;
			case "get_order":
				$this->_getorder();
				break;
			case "get_msg":
				$this->_getmsg();
				break;
			case "get_credit":
				$this->_get_credit();
				break;
			case "get_currency":
				$this->_get_currency();
				break;
			case "get_contect":
				$this->_get_contect();
				break;
			case "get_area":
				$this->_get_area();
				break;
			case "get_brand":
				$this->_get_brand();
				break;
			case "check_login":
				$this->_check_login();
				break;
			default:
				$this->_viewproduct();
				break;
		}
	}

	function _gethead(){
		/**
		 * 设置模板路径 
		 */
		$this->setsubtemplates("");
		$this->showpage("header");
	}


	function _getproduct(){

		$p_id = $this->_input['pid'];
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["pid"],"require"=>"true","message"=>$this->_lang['errProductId']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			echo $error;
		}else{
			/**
			 * 取得商品信息
			 */
			$product_row = $this->obj_product->getProductRow($p_id);
			/**
			 * 取得出价记录
			 */
			if (!is_object($this->obj_product_order)){
				require_once("order.class.php");
				$this->obj_product_order = new ProductOrderClass();
			}
			/**
			 * 取得卖家资料
			 */
			$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'member_id,login_name,sale_score,buy_score,regist_time','more');
			/**
			 * 得到卖家好评率
			 */
			if (!is_object($this->obj_member_score)){
				require_once("score.class.php");
				$this->obj_member_score = new ScoreClass();
			}
			$seller_info['s_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"s");
			$seller_info['b_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"b");
			//买卖家信用
			$buy_score = $this->obj_member->creditLevel($seller_info['buy_score']);
			$sale_score = $this->obj_member->creditLevel($seller_info['sale_score']);			
			$buy_score_img = $this->_get_score_img($buy_score,$product_row['member_id'],'b');
			$sale_score_img = $this->_get_score_img($sale_score,$product_row['member_id'],'s');
			/**
			 * 剩余时间计算
			 */
			$left_time = $product_row['p_end_time'] - time();
			if ($left_time > 0){
				$product_row['left_days'] = intval($left_time / (24*60*60));
				$product_row['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
				$product_row['left_minutes'] = intval((($left_time % (60*60))) / 60);
				$text_left_time = $product_row['left_days'].$this->_lang['langPday'].$product_row['left_hours'].$this->_lang['langPhour'].$product_row['left_minutes'].$this->_lang['langPminute'];

			}else {
				$text_left_time = '0';
			}
			if("2" == $product_row['p_sell_type']){
				$product_row['less_count'] = $product_row['p_group_mincount'] - $product_row['p_sold_num'];
			}
			/**
			 * 判断是否开始
			 */
			if ($product_row['p_start_time'] > time()) {
				$text_left_time = $this->_lang['langPNotBagin'];
			}

			/**
			 * 拍卖的加价幅度
			 */
			if("0" == $product_row['p_sell_type']){
				if (!is_object($this->obj_up_price)){
					require_once("up_price.class.php");
					$this->obj_up_price = new UpPriceClass();
				}
				if("1" == $product_row['p_system_step']){
					//拍卖当前价格
					$cur_price = ($product_row['p_cur_price']=="0")?$product_row['p_price']:$product_row['p_cur_price'];
					//取商品加价幅度
					$increment = $this->obj_up_price->getIncrementUpprice($cur_price);
					$product_row['p_price_step'] = $increment?$increment:1;
				}
			}
			/**
			 * 更新商品浏览次数
			 */
			$update_product['p_code'] = $p_id;
			$update_product['txtViewNum'] = 1;
			$update_product_view_num = $this->obj_product->updateProductViewNum($update_product);

			/**
			 * 写进 浏览过的宝贝 cookie名称 product_viewed
			 */
			$this->setReviewed($product_row['p_code']);
		}
		//取店铺实名认证内容
		if (!is_object($this->obj_shop)){
			require_once('shop.class.php');
			$this->obj_shop = new ShopClass();
		}
		$shop_array = $this->obj_shop->getOneShopByMemeberId($product_row['member_id'],'1');

		require_once("xmlwrite.class.php");
		$XML=new XML("1.0",$this->_configinfo['websit']['ncharset']);
		$Attribute['date']=date('Y-m-d');
		$Attribute['time']=date('H:i:s');
		$XML->CreateNode('root',$Attribute);
		$XML->AppendNode('selltype',null,$product_row['p_sell_type'],false);
		$XML->AppendNode('lesscountok',null,$this->_lang['langProductGroupOk'],false);
		$XML->AppendNode('productclose',null,$this->_lang['langProductClose'],false);
		$XML->AppendNode('soldnum',null,$product_row['p_sold_num'],false);
		$XML->AppendNode('soldsum',null,$product_row['p_sold_sum'],false);
		$XML->AppendNode('lefttime',null,$text_left_time,false);
		$XML->AppendNode('viewnum',null,$product_row['p_view_num'],false);
		$XML->AppendNode('soldscore',null,$seller_info['sale_score'],false);
		$XML->AppendNode('buyscore',null,$seller_info['buy_score'],false);
		$XML->AppendNode('buy_score_img',null,$buy_score_img,false);
		$XML->AppendNode('sale_score_img',null,$sale_score_img,false);
		$XML->AppendNode('soldrate',null,$seller_info['s_rate'],false);
		$XML->AppendNode('buyrate',null,$seller_info['b_rate'],false);
		$XML->AppendNode('p_storage',null,$product_row['p_storage'],false);//库存
		$XML->AppendNode('p_state',null,$product_row['p_state'],false);
		//拍卖
		if("0" == $product_row['p_sell_type']){
			$XML->AppendNode('curprice',null,$product_row['p_cur_price'],false);
			$XML->AppendNode('pricestep',null,$product_row['p_price_step'],false);
		}
		//团购
		if("2" == $product_row['p_sell_type']){
			$XML->AppendNode('less_count',null,$product_row['less_count'],false);
			$XML->AppendNode('lesscount',null,$this->_lang['langProductGroupLess'].$product_row['less_count'].$this->_lang['langProductGroupLessProduct'],false);
			$XML->AppendNode('p_price',null,$product_row['p_price'],false);//团购原价
			$XML->AppendNode('group_mincount',null,$product_row['p_group_mincount'],false);//团购最小数量
		}
		//店铺实名认证标识
		$XML->AppendNode('shop_audit_state',null,$shop_array['audit_state'],false);
		//实名认证
		$XML->AppendNode('personal_certify',null,$seller_info['personal_certify'],false);
		//店铺名称和地区
		$XML->AppendNode('shop_name',null,$shop_array['shop_name'],false);
		//地区
		if (!is_object($this->obj_area)){
			require_once('area.class.php');
			$this->obj_area = new AreaClass();
		}
		$area_array = $this->obj_area->getAreaPathList($shop_array['shop_area_id']);
		$XML->AppendNode('shop_area',null,$area_array[0]['area_name'],false);
		$XML->Display();
	}
	
	/**
	 * 获取积分信用图片
	 *
	 * @param array $score_array
	 * @param int $uid
	 * @param string $type
	 * @return string
	 */
	function _get_score_img ($score_array,$uid,$type) {
		$img_str = "";		
		$img_str .= "@a href=".$this->_configinfo['websit']['site_url']."/store/user_rate.php?userid={$uid}%";
		$explain_txt = $type == 'b' ? $this->_lang['langStoreIntegralLookBuy'] : $this->_lang['langStoreIntegralLook'] ;
		$img_title = $score_array[interval][one]."-".$score_array[interval][two].$explain_txt;
		$img_path = $this->_configinfo['websit']['site_url'] ."/templates/". $this->_configinfo['websit']['templatesname'];
		if (is_array($score_array)) {
			foreach ($score_array['median'] as $v) {
				switch ($score_array['level']) {
					case '0':
						$img_str .= "@img title={$img_title} src={$img_path}/images/b_red_1.gif alt={$img_title} align=absmiddle %";
						break;
					case '1':
						$img_str .= "@img title={$img_title} src={$img_path}/images/b_red_2.gif alt={$img_title} align=absmiddle %"; 
						break;
					case '2':
						$img_str .= "@img title={$img_title} src={$img_path}/images/b_red_3.gif alt={$img_title}% align=absmiddle "; 
						break;														
				}
			}				
		}
		$img_str .= "@/a%";
		return $img_str;	
	}	

	/**
	 * 把浏览过的产品的产品号放到COOKIE中保存
	 *
	 * @param var[] $pcode
	 * @return boolean
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

		if (!@in_array($pcode,$cookie_array)){/*如果产品在cookie里已有，则不记录*/
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
	 * 取得出价记录
	 */
	function _getorder(){
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		$p_id = $this->_input['pid'];
		/*取商品信息*/
		$product_row = $this->obj_product->getProductRow($p_id);

		/**
		 * 取得出价记录
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 实例化分页类
		 */
		if(!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}

		/**
		 * 取得卖家资料
		 */
		$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'member_id,login_name,sale_score,buy_score,regist_time','more');
		/**
		 * 得到卖家好评率
		 */
		if (!is_object($this->obj_member_score)){
			require_once("score.class.php");
			$this->obj_member_score = new ScoreClass();
		}
		$seller_info['s_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"s");
		$seller_info['b_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"b");

		/**
		 * 商品购买记录
		 */
		if("0" != $product_row['p_sell_type']){
			$product_row['p_cur_price'] = $product_row['p_price'];
			/**
		 	 * 限定条件
		 	 */
			$obj_condition['p_code'] = $p_id;
			$obj_condition['order'] = 1;
			/**
			 * 取得订单列表
			 */
			$product_order_array = $this->obj_product_order->getProductOrderList($obj_condition, $this->obj_page);

			if(is_array($product_order_array)){
				foreach ($product_order_array as $key => $value){
					/**
					 * 如果没有买家姓名
					 */
					if ($value['buyer_name'] == ''){
						$product_order_array = $this->obj_member->getSomeMember($product_order_array,'buyer_id','member_id,login_name as buyer_nick');
					}else {
						$product_order_array[$key]['member_id'] = $value['buyer_id'];
						$product_order_array[$key]['buyer_nick'] = $value['buyer_name'];
					}
					$product_order_array[$key]['state'] = "2";
					$product_order_array[$key]['sold_time'] = @date("Y-m-d H:i:s",$value['sold_time']);
					$product_order_array[$key]['bid_anonymous'] = $value['anonymous'];
				}
			}
		}
		/**
		 * 拍卖出价记录
		 */
		if("0" == $product_row['p_sell_type']){

			if (!is_object($this->obj_product_bid)){
				require_once("bid.class.php");
				$this->obj_product_bid = new BidClass();
			}
			$obj_bid_condition['p_code'] = $p_id;
			$obj_bid_condition['order'] = 2;
			/**
			 * 如果当前还未有人出价，显示底价
			 */
			if("0" == $product_row['p_cur_price'] || "" == $product_row['p_cur_price']){
				$product_row['p_cur_price'] = $product_row['p_price'];
			}

			/**
			 * 取得竞拍出价列表
			 */
			$product_bid_array = $this->obj_product_bid->getProductBidList($obj_bid_condition, $obj_bid_page);

			/**
		 	 * 得到买家信息
			 */
			$product_order_array = $this->obj_member->getSomeMember($product_bid_array,'bid_member_id','member_id,login_name as buyer_nick');

			if(is_array($product_bid_array)){
				foreach ($product_bid_array as $key => $value){
					$product_order_array[$key]['bid_anonymous'] = $value['bid_anonymous'];
					$product_order_array[$key]['unit_price'] = $value['bid_price'];
					$product_order_array[$key]['buy_num'] = $value['bid_count'];
					$product_order_array[$key]['sold_time'] = @date("Y-m-d H:i:s",$value['bid_time']);
					$product_order_array[$key]['state'] = $value['bid_state'];
				}
			}
		}

		/**
		 * 页面输出
		 */
		$this->output("product_order_array", $product_order_array);
		$this->showpage('product.html_order');
	}


	/**
	 * 取商品留言
	 */
	function _getmsg(){
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 商品留言信息
		 */
		require_once("productmessage.class.php");
		$obj_message = new ProductMessageClass();
		$message_array = $obj_message->getMessage($page,$this->_input['pid']);
		if (is_array($message_array)){
			foreach ($message_array as $k => $v){
				$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
			}
		}

		/**
		 * 取商品信息
		 */
		$condition['p_id'] = $this->_input['pid'];
		$product_row = $this->obj_product->getProductList($condition,$page);
		
		if(empty($product_row)){//下架商品不能留言
			exit;
		}

		$this->output("ses_login", $_SESSION['s_login']);   //登陆信息
		$this->output("message_array", $message_array);   //商品留言
		$this->output("product_row", $product_row[0]);
		$this->showpage('product.html_msg');

	}
	/**
	 * 取卖家信用等级
	 */
	function _get_credit(){
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/*取店铺信用度*/
		$condition_member['id'] = $this->_input['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,"*","more");
		$sale_score = $this->obj_member->creditLevel($member_array['sale_score']);

		/**
		 * 页面输出
		 */
		$this->output("seller_info", $member_array);
		$this->output("sale_score", $sale_score);
		$this->showpage('product.html_credit');
	}

	/**
	 * 取商品支持的货币种类经过汇率换算后的价格
	 */
	function _get_currency(){
		$p_id = $this->_input['pid'];
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["pid"],"require"=>"true","message"=>$this->_lang['errProductId']));
		$error = $this->objvalidate->validate();
		if($error == ""){
			//设置模板路径
			$this->setsubtemplates("home");
			//取得商品信息
			$product_row = $this->obj_product->getProductRow($p_id);
			//价格
			if ($product_row['p_sell_type'] == '2'){//团购
				$price = $product_row['p_group_price'];
			}else {
				$price = $product_row['p_price'];
			}
			
			//取支持的支付方式
			if (is_array($this->_configinfo['payment'])){
				$i=0;
				foreach ($this->_configinfo['payment'] as $k => $v){
					if ($v == 1){
						//判断该商品的支付方式
						if (strstr($product_row['p_pay_method'],'|'.$k.'|')){
							$payment_array[$k]['name']	= $this->_b_config['payment'][$k];;
							if ($i == '0'){
								$payment_array[$k]['check'] = 1;
							}
							$i++;
						}
					}
				}
			}
			//判断是否支持预付款支付
			if ($this->_configinfo['payment']['predeposit'] == '1'){
				if ($product_row['p_predeposit_state'] == '0'){
					$payment_array[count($payment_array)]['name'] = $this->_lang['langPPredeposit'];
				}
			}
			
			//取支持的货币种类
			if (strstr($product_row['p_currency_category'],'|')){
				$currency = explode('|',trim($product_row['p_currency_category'],'|'));
			}else {
				$currency = array($product_row['p_currency_category']);
			}
			//创建汇率对象，取汇率信息
			if (!is_object($this->obj_exchange)) {
				require_once("exchange.class.php");
				$this->obj_exchange = new ExchangeClass();
			}
			$condition['state'] = 1;
			$exchange_array = $this->obj_exchange->listExchange($condition,$page);
			//商品价格通过汇率进行换算
			if (is_array($exchange_array)){
				$array = array();
				foreach ($currency as $k => $v){
					foreach ($exchange_array as $k2 => $v2){
						if ($v == $v2['exchange_name']) {
							$array[$v2['exchange_name']] = @number_format($price*100/$v2['exchange_rate'],2)<=0.01?'0.01':@number_format($price*100/$v2['exchange_rate'],2);
						}
					}
				}
			}
			//去货币对应中文名称的数组
			$exchange_remark = $this->obj_exchange->getExchangeArray();
			/**
			 * 页面输出
			 */
			$this->output('payment_array',$payment_array);
			$this->output('currency_array',$array);
			$this->output('exchange_remark',$exchange_remark);
			$this->showpage('product.html_currency');
		}
	}
	
	/**
	 * 卖家联系方式
	 */
	function _get_contect(){
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/*取店铺信用度*/
		$condition_member['id'] = $this->_input['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,"*","more");
		/**
		 * 页面输出
		 */
		$this->output("seller_info", $member_array);
		$this->showpage('product.html_contect');
	}
	
	/**
	 * 地区联动AJAX
	 */
	function _get_area(){
		/**
		 * html的缓存声明头
		 */
		Common::cacheheader();
		
		/**
		 * 父ID
		 */
		$id = $this->_input['parent_id']?$this->_input['parent_id']:'0';
		/**
		 * 缓存信息
		 */
		$array = Common::getAreaCache('');

		$area_array_json = array();
		$sel_area_json = array();
		/**
		 * 判断是否有修改id，如果有，则递归取出该id的内容
		 */
		if($this->_input['modi_id'] != ''){
			if (!is_object($this->obj_area)){
				require_once ("area.class.php");
				$this->obj_area = new AreaClass();
			}
			$sel_area = $this->obj_area->getAreaPathList($this->_input['modi_id']);
			if(!empty($sel_area)){
				foreach ($sel_area as $k => $v){
					$sel_area_json[$k]['id'] = $v[0];
					$sel_area_json[$k]['name'] = $v[1];	
					if($this->_configinfo['websit']['ncharset']=="GBK"){
						$sel_area_json[$k]['name']=Common::nc_change_charset($sel_area_json[$k]['name'],'gbk_to_utf8');
					}
				}
			}
		}

		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == $id){
					$area_array_json[$k]['id'] = $v[0];
					$area_array_json[$k]['name'] = $v[2];
					$area_array_json[$k]['is_parent'] = $v[5];
					if($this->_configinfo['websit']['ncharset']=="GBK"){
						$area_array_json[$k]['name'] = Common::nc_change_charset($area_array_json[$k]['name'],'gbk_to_utf8');
					}
				}
			}
		}

		$data = array('add' => $area_array_json,'modi' => $sel_area_json);
		/**
		 * 转换成json
		 */
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$data= $obj_json->encode($data);
		echo $data;
	}
	
	/**
	 * 品牌联动AJAX
	 */
	function _get_brand(){
		$id = $this->_input['id'];//父ID
		//地区内容
		$array = Common::getProductBrandCache('');
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == $id){
					$v['pb_id'] = $v[0];
					$v['pb_u_id'] = $v[1];
					$v['pb_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$return_string .= $v['pb_id']."||".trim($v['pb_name'])."||".$v['is_parent']."|||";
				}
			}
		}
		echo $return_string;
	}

	/**
	 * ajax检测会员是否是登陆状态
	 *
	 */
	function _check_login(){
		if($_SESSION['s_login']['login'] == '1'){//登陆
			echo 1;exit;
		}else{
			echo 0;exit;
		}
	}
}
$tohtml = new ToHtml();
$tohtml->main();
unset($tohtml);
?>