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
 * FILE_NAME : product_auction.php
 * 竞拍商品前台程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Jun 14 01:05:38 GMT 2010
 */
require ("../global.inc.php");
class ShowAuctionProduct extends CommonFrameWork{
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
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("product");

		switch ($this->_input['action']){
			case 'view':
				$this->_view();
				break;
			case 'buy':
				/**
				 * 判断是否登陆
				 */
				$this->isMember();
				$this->_buy();
				break;
			case 'bid':
				/**
				 * 判断是否登陆
				 */
				$this->isMember();
				$this->_bid();
				break;
			default:
				$this->_view();
		}
	}

	/**
	 * 商品展示页面
	 *
	 * @param $this->_input["p_code"] 商品编号
	 * @return 输出模板
	 */
	function _view(){
		//检测
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductId'])
		);
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath ( "error", "", $error );
		}else{
			/**
			 * 取商品信息
			 */
			$product_row = $this->obj_product->getProductRow($this->_input["p_code"]);
			/**
			 * 判断该商品是否存在
			 */
			if (empty($product_row)){
				$this->redirectPath ( "error", "", $this->_lang['errProductId'] );
			}
			/**
			 * 判断商品类型是否与访问类型一致
			 */
			if (!$this->checkSellType($product_row['p_sell_type'],0,$product_row['p_code'])) {
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
			$attribute_condition_str = " and p_id = '" . $product_row['p_code'] . "'";
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
					$message_array[$k]['re_time'] = $v['re_time']?date("Y-m-d H:i",$v['re_time']):$v['re_time'];
				}
			}
			unset($obj_product_message);
			/**
			 * 拍卖出价记录
			 */
			require_once("bid.class.php");
			$obj_product_bid = new BidClass();
			/**
			 * 取得竞拍出价列表
			 */
			$obj_bid_condition['p_code'] = $product_row['p_code'];
			$obj_bid_condition['order'] = 2;
			$product_bid_array = $obj_product_bid->getProductBidList($obj_bid_condition, $obj_bid_page);
			unset($obj_product_bid,$obj_bid_condition);
			/**
			 * 得到买家信息
			 */
			$product_bid_array = $this->obj_member->getSomeMember($product_bid_array,'bid_member_id','member_id,login_name as buyer_nick');
			/**
			 * 格式化时间，处理显示数据
			 */
			if(is_array($product_bid_array)){
				foreach ($product_bid_array as $key => $value){
					$product_bid_array[$key]['sold_time_1'] = @date("H:i:s",$value['bid_time']);
					$product_bid_array[$key]['sold_time'] = @date("Y-m-d H:i:s",$value['bid_time']);
				}
			}
			/**
			 * 更新商品浏览次数
			 */
			$update_product['p_code'] = $product_row['p_code'];
			$update_product['txtViewNum'] = 1;
			$this->obj_product->updateProductViewNum($update_product);
			/**
			 * 拍卖的加价幅度,系统自动加价
			 */
			if($product_row['p_system_step'] == '1'){
				require_once("up_price.class.php");
				$obj_up_price = new UpPriceClass();
				/**
				 * 取商品加价幅度
				 */
				$increment = $obj_up_price->getIncrementUpprice($product_row['p_cur_price']);
				$product_row['p_price_step'] = $increment?$increment:1;
			}
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
			$this->output('product_class_string',$product_class_string);
			$this->output('pic_array',$pic_array);
			$this->output("have_attribute", $have_attribute);
			$this->output("product_attribute", $product_attribute);
			$this->output("product_attribute_content", $product_attribute_content);
			$this->output("product_have_attribute", $pac_attribute);
			$this->output("product_bid_array", $product_bid_array);
			$this->output("message_array", $message_array);
			$this->output("seller_info", $seller_info);
			$this->output("sel_area", $sel_area);
			$this->output("sel_brand", $sel_brand);
			$this->output("lefttime", $left_time);
			$this->output("shop_info", $shop_info);
			$this->output("s_login_id",$_SESSION['s_login']['id']);
			$this->showpage("product_auction.view");
		}
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

	/**
	 * 商品购买页面
	 *
	 * @param string $this->_input['p_code'] 商品编号
	 * @return 输出模板
	 */
	function _buy(){
		/**
		 * 判断用户组权限
		 */
		CheckPermission::memberGroupPermission('buy',$_SESSION['s_login']['id']);
		/**
		 * 取商品信息
		 */
		$product_row = $this->obj_product->getProductRow($this->_input['p_code']);
		/**
		* 判断商品类型是否与访问类型一致
		*/
		if (!$this->checkSellType($product_row['p_sell_type'],0,$product_row['p_code'])) {
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
		 * 取该会员在该商品竞拍领先的数量
		 */
		require_once('bid.class.php');
		$obj_bid = new BidClass();
		/**
		 * 取该商品的所有领先状态的竞拍信息
		 */
		$condition['p_code'] = $product_row['p_code'];
		$condition['bid_member_id'] = $_SESSION['s_login']['id'];
		$condition['bid_state'] = 1;
		$bid_list = $obj_bid->getProductBidList($condition,$page);
		/**
		 * 取该商品该会员已经取得领先的商品数量
		 */
		if (!empty($bid_list)){
			$get_count = 0;
			foreach ($bid_list as $k => $v){
				$get_count += $v['bid_get_count'];
			}
			/**
			 * 如果获得商品数量和库存相同，那么返回信息，说明该次竞拍的所有商品都属于该会员
			 */
			if ($get_count >= $product_row['p_storage']){
				$this->redirectPath("error","",$this->_lang['errPAuctionBidCountIsFull']);
			}
			/**
			 * 取目前该会员可以参与竞拍的商品数量 商品库存数量 减 该会员领先商品数量
			 */
			$bid_now_number = $product_row['p_storage'] - $get_count;
		}else {
			/**
			 * 取目前该会员可以参与竞拍的商品数量
			 */
			$bid_now_number = $product_row['p_storage'];
		}
		/**
		 * 获取商品类别路径
		 */
		$product_class_string = $this->_get_product_class_path($product_row['pc_id']);
		/**
		 * 实例化拍卖类
		 */
		require_once('order_process_auction.class.php');
		$obj_order_process = new OrderProcessAuction();
		/**
		 * 取得输出到模板上的内容
		 */
		$obj_order_process->_lang = $this->_lang;
		$obj_order_process->buy($product_row);
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
		 * 买家信息 预存款信息
		 */
		$member_array = $this->obj_member->getMemberInfo(array("id"=>$_SESSION['s_login']['id']),'*','more');
		/**
		 * 判断该会员是否对于该商品的该次竞拍缴纳过保证金
		 */
		require_once ("predeposit.class.php");
		$obj_predeposit = new PredepositClass ( );
		$condition_predeposit['member_id'] = $_SESSION['s_login']['id'];
		$condition_predeposit['p_code'] = $product_row['p_code'];
		$condition_predeposit['predeposit_type'] = 10;
		$condition_predeposit['predeposit_state'] = 1;
		$margin_array = $obj_predeposit->listPredopesit($condition_predeposit,$page);

		if(!empty($margin_array)){
			/**
			 * 已经缴纳过保证金
			 */
			$margin_sign = 1;
		}else {
			/**
			 * 没有缴纳过保证金
			 */
			$margin_sign = 0;
		}
		unset($obj_predeposit);
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
		$this->output("margin_percent", ($this->_configinfo['countdown']['buyer_margin']/100)?($this->_configinfo['countdown']['buyer_margin']/100):'1');
		$this->output("margin_sign", $margin_sign);
		$this->output("product_row", $product_row);
		$this->output("receive_array", $receive_array);
		$this->output("receive_count", count($receive_array));
		$this->output("sel_area", $sel_area);
		$this->output("area_array", $area_array);
		$this->output("product_class_string", $product_class_string);
		$this->output("bid_now_number", $bid_now_number);
		$this->output("member_array", $member_array);
		$this->showpage("product_auction.buy");
	}

	/**
	 * 竞拍商品
	 *
	 * @param 页面传递表单内容
	 * @return 跳转连接
	 */
	function _bid(){
		$this->obj_validate->setValidate(array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductId']));
		/**
		 * 判断收货地址是否是新增还是选择已有的
		 */
		if ($this->_input['bid_receive_code'] == 'new'){
			/**
			 * 新增
			 */
			$this->obj_validate->setValidate(array("input"=>$this->_input["receive_area_id"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPReceiveIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input["address"],"require"=>"true","message"=>$this->_lang['langPReceiveAddressIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input["zip"],"require"=>"true","message"=>$this->_lang['langPReceiveZipIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input["receive_name"],"require"=>"true","message"=>$this->_lang['langPReceiveNameIsEmpty']));
			/**
			 * 判断手机和电话要二选一
			 */
			if ($this->_input['phone'] == '' && $this->_input['mobilephone'] == ''){
				$this->obj_validate->setValidate(array("input"=>$this->_input["phone"],"require"=>"true","message"=>$this->_lang['langPContactInputOne']));
			}
		}else {
			/**
			 * 已有
			 */
			$this->obj_validate->setValidate(array("input"=>$this->_input["bid_receive_code"],"require"=>"true","message"=>$this->_lang['errPReceiveIsEmpty']));
		}
		$this->obj_validate->setValidate(array("input"=>$this->_input["bid_count"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errBuyNum']));
		$this->obj_validate->setValidate(array("input"=>$this->_input["bid_max_price"],"require"=>"true","validator"=>"Currency","message"=>$this->_lang['errPAuctionBidPriceIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>strtoupper($this->_input['checkcode']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['errProductMCode']));

		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath ( "error", "", $error );
		}else{
			/**
			 * 判断用户组权限
			 */
			CheckPermission::memberGroupPermission('buy',$_SESSION['s_login']['id']);
			/**
			 * 取商品信息
			 */
			$product_row = $this->obj_product->getProductRow($this->_input['p_code']);
			/**
			 * 判断商品类型是否与访问类型一致
			 */
			if (!$this->checkSellType($product_row['p_sell_type'],0,$product_row['p_code'])) {
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
			 * 验证bid_max_price 是否高于最低出价
			 */
			if ($this->_input['bid_max_price'] < $product_row['p_cur_price']){
				$this->redirectPath("error","",$this->_lang['errPAuctionBidMaxPriceIsLow']);
			}
			/**
			 * 处理收货地址
			 */
			if ($this->_input['bid_receive_code'] == 'new'){
				/**
			 	 * 获得随机的唯一收货地址编码
			 	 */
				require_once("receive.class.php");
				$obj_receive = new ReceiveClass();
				$receive_last_id = $obj_receive->getReceiveLastId();
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
				$this->_input["txtRcode"] = md5($receive_last_id.$random_string);
				$this->_input["member_id"] = $_SESSION['s_login']['id'];
				/**
			 	 * 暂时做入库字段与接收字段转换，等修正地址类后删除
			 	 */
				$recerive_insert = array();
				$recerive_insert['member_id'] = $_SESSION['s_login']['id'];
				$recerive_insert['txtRcode'] = $this->_input["txtRcode"];
				$recerive_insert['receive_name'] = $this->_input["receive_name"];
				$recerive_insert['txtAddress'] = $this->_input["address"];
				$recerive_insert['txtMobilephone'] = $this->_input["mobilephone"];
				$recerive_insert['txtPhone'] = $this->_input["phone"];
				$recerive_insert['txtZip'] = $this->_input["zip"];
				$recerive_insert['area_id'] = $this->_input["receive_area_id"];
				$obj_receive->addReceive($recerive_insert);

				$this->_input["bid_receive_code"] = $this->_input["txtRcode"];
			}

			/**
			 * 卖家名
			 */
			if ($product_row['login_name'] == ''){
				$condition_member['id'] = $product_row['seller_id'];
				$seller_array = $this->obj_member->getMemberInfo($condition_member,'login_name');
				$product_row['login_name'] = $seller_array['login_name'];
				unset($condition_member);
			}

			/**
			 * 判断该会员是否对于该商品的该次竞拍缴纳过保证金
			 */
			require_once ("predeposit.class.php");
			$obj_predeposit = new PredepositClass ( );
			$condition_predeposit['member_id'] = $_SESSION['s_login']['id'];
			$condition_predeposit['p_code'] = $product_row['p_code'];
			$condition_predeposit['predeposit_type'] = 10;
			$condition_predeposit['predeposit_state'] = 1;
			$margin_array = $obj_predeposit->listPredopesit($condition_predeposit,$page);

			if(empty($margin_array)){
				/**
				 * 判断买家预存款是否满足保证金支付
				 */
				$condition_member['id'] = $_SESSION['s_login']['id'];
				$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
				if($member_array['available_predeposit'] < $this->_input['hidden_auction_margin']){
					$this->redirectPath("error","",$this->_lang['errPAuctionPredepositIsEmpty']);
				}
			}

			/**
			 * 增加竞拍信息
			 */
			require_once('bid.class.php');
			$obj_bid = new BidClass();
			$obj_bid->_lang = $this->_lang;
			$insert_array = array();
			$insert_array['bid_member_id'] = $_SESSION['s_login']['id'];
			$insert_array['bid_p_code'] = $product_row['p_code'];
			$insert_array['bid_p_name'] = $product_row['p_name'];
			$insert_array['bid_max_price'] = $this->_input['bid_max_price'];
			$insert_array['bid_count'] = $this->_input['bid_count'];
			$insert_array['bid_receive_code'] = $this->_input["bid_receive_code"];
			$insert_array['bid_time'] = time();
			$insert_array['bid_anonymous'] = $this->_input["bid_anonymous"];
			$insert_array['bid_buyer_name'] = $_SESSION['s_login']['name'];
			$insert_array['bid_seller_id'] = $product_row['member_id'];
			$insert_array['bid_seller_name'] = $product_row['login_name'];

			$result = $obj_bid->handleBid($insert_array,$product_row);

			if ($result === true){
				/**
				 * 判断竞拍信息是否有入库的部分，如果有，那么则扣除保证金
				 */
				if ($obj_bid->have_insert_sign === true){
					/**
					 * 判断该会员是否对于该商品的该次竞拍缴纳过保证金
					 */					
					if(empty($margin_array)){
						/**
						 * 没有缴纳过保证金，从预存款中扣除保证金
						 */
						$value_array = array ();
						$value_array ['predeposit_type'] = '10';
						$value_array ['predeposit_state'] = '1';
						$value_array ['member_id'] = $_SESSION['s_login']['id'];
						$value_array ['available_amount'] = '-'.$this->_input['hidden_auction_margin'];
						$value_array ['to_member_id'] = $product_row['member_id'];
						$value_array ['sp_code'] = '';
						$value_array ['system_remark'] = $this->_lang['langPAuctionBail'];
						$value_array ['create_time'] = time ();
						$value_array ['update_time'] = time ();
						$value_array ['payment'] = 'predeposit';
						$value_array ['p_code'] = $product_row['p_code'];
						$result = $obj_predeposit->addPredepositDetail ( $value_array );
						unset ( $value_array);
						/**
						 * 更新会员预存款帐号 可用金额和冻结金额数量
						 */
						$value_array = array ();
						$value_array ['available_predeposit'] = '-'.$this->_input['hidden_auction_margin'];
						$value_array ['freeze_predeposit'] = '+'.$this->_input['hidden_auction_margin'];
						$this->obj_member->modifyMember ( $value_array, $_SESSION['s_login']['id'], 'predeposit' );
						unset ( $value_array );
					}
					unset($obj_predeposit);
				}
				/**
				 * 竞拍完成，增加该商品的竞拍次数 和 商品竞拍当前价格(取新的竞拍列表，取最低的竞拍领先者价格+该价格所在区间的加价幅度)
				 */
				/**
				 * 更新竞拍价格
				 */
				/**
				 * 取该商品的所有领先状态的竞拍信息
				 */
				$condition_bid['p_code'] = $product_row['p_code'];
				$condition_bid['bid_state'] = 1;
				$bid_list = $obj_bid->getProductBidList($condition_bid,$page);
				/**
				 * 判断竞拍商品数量是否等于商品数量，如果等于，那么就更新商品竞拍价格
				 */
				if(is_array($bid_list)){
					foreach($bid_list as $k => $v){
						$count += $v['bid_get_count'];
					}
					if($count < $product_row['p_storage']){
						/**
						 * 还有未竞拍的商品，不用更新竞拍价格
						 */
					}else {
						/**
						 * 判断加价类型
						 */
						if($product_row['p_system_step'] == '0'){
							/**
							 * 自定义加价
							 */
							$up_price = $product_row['p_price_step'];
						}else {
							/**
							 * 系统加价
							 */
							/**
							 * 加价幅度列表
							 */
							require_once('up_price.class.php');
							$obj_upprice = new UpPriceClass();
							$up_price_list = $obj_upprice->getUpPriceList($page);
							$up_price = $obj_bid->getPriceMargin($product_row['p_cur_price'],$up_price_list);
						}
						/**
						 * 排序取最低的领先价格
						 * 更新竞拍当前价
						 */
						$bid_list = $obj_bid->sortBidList($bid_list,'bid_price');
						/**
						 * 没有剩余商品，更新竞拍价格
						 */
						$product_row['p_cur_price'] = $bid_list[0]['bid_price']+$up_price;
					}
				}
				/**
				 * 更新商品竞拍信息
				 */
				$update_bid = array();
				$update_bid['p_code'] = $product_row['p_code'];
				$update_bid['p_bid_num'] = $product_row['p_bid_num']+1;
				$update_bid['p_cur_price'] = $product_row['p_cur_price'];
				$this->obj_product->updateProduct($update_bid);
				$this->redirectPath("error","product_auction.php?action=view&p_code=".$product_row['p_code'],$this->_lang['langPAuctionOperateIsSucc']);
			}else {
				$this->redirectPath("error","",$this->_lang['errPProductBuyFail']);
			}
		}
	}
}
$product = new ShowAuctionProduct();
$product->main();
unset($product);
?>