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
 * FILE_NAME :product_countdown.php
 * 倒计时拍卖商品查看
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 11:00:29 CST 2010
 */
require ("../global.inc.php");

class ShowProduct extends CommonFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
     * 拍卖商品对象
     *
     * @var obj
     */
	var $obj_product_countdown;
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
	 * 拍卖商品出价对象
	 *
	 * @var obj
	 */
	var $obj_bid;
	/**
	 * 商品留言对象
	 *
	 * @var obj
	 */
	var $obj_product_message;
	/**
	 * 价格加价对象
	 *
	 * @var obj
	 */
	var $obj_up_price;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	/**
	 * 商品分类对象
	 *
	 * @var object
	 */
	var $objProductCate;

	function main(){
		/**
		 * 创建拍卖商品对象
		 */
		if (!is_object($this->obj_product_countdown)){
			require_once("product_countdown.class.php");
			$this->obj_product_countdown = new ProductCountdownClass();
		}
		/**
         * 创建商品对象
         */
		if(!is_object($this->obj_product)) {
			require_once 'product.class.php';
			$this->obj_product = new ProductClass();
		}
		/**
         * 创建竞价对象
         */
		if (!is_object($this->obj_bid)) {
			include_once("bid_countdown.class.php");
			$this->obj_bid = new BidCountdownClass();
		}
		/**
         * 创建地区对象
         */
		if (!is_object($this->obj_area)) {
			require_once ("area.class.php");
			$this->obj_area = new AreaClass();
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
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建商铺留言对象
		 */		
		if (!is_object($this->obj_product_message)) {
			require_once("productmessage.class.php");
			$this->obj_product_message = new ProductMessageClass();
		}
		/**
		 * 创建系统加价对象
		 */			
		if (!is_object($this->obj_up_price)) {
			require_once("up_price.class.php");
			$this->obj_up_price = new UpPriceClass();
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

		/**
		 * 语言包
		 */
		$this->getlang("product,product_countdown");

		switch ($this->_input['action']){
			case "view":
				$this->_viewproduct();
				break;
			default:
				$this->_viewproduct();
		}
	}

	/**
	 * 商品查看页面
	 *
	 */
	function _viewproduct(){
		$p_id = $this->_input['pid'];
		/**
		 * 检测商品编号
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$p_id,"require"=>"true","message"=>$this->_lang['errProductId']));
		$error = $this->objvalidate->validate();

		if($error != ""){
			$this->redirectPath ( "error", "", $error );
		}else{
			/**
			 * 获取主表信息
			 */
			$product_array = $this->obj_product->getProductRow($p_id);
			if ($product_array['p_state'] != '1' && empty($_SESSION['s_login']['id']) && $_SESSION['s_login']['id'] != $product_array['member_id']) {
				$this->redirectPath ( "error", "../index.php", $this->_lang['langPPstateEmpty'] );
			}
			/**
			 * 判断该商品是否存在
			 */
			if ($product_array['p_id'] == ''){
				$this->redirectPath ( "error", "", $this->_lang['errProductId'] );
			}
			/**
			 * 判断商品类型是否与访问类型一致
			 */
			if (!$this->checkSellType($product_array['p_sell_type'],3,$product_array['p_code'])) {
				$this->redirectPath ( "error", "../index.php", $this->_lang['errPProductIsEmpty'] );
			}
			/**
			 * 获取扩展表商品信息
			 */
			$product_countdown_array = $this->obj_product_countdown->getProductRow($p_id);
			/**
			 * 取得导航分类信息
			 */
			$navi_class_array = $this->objProductCate->getProductClassPathListAll($product_array['pc_id']);
			$navi_class_array = @array_reverse($navi_class_array);
			/**
			 * 图片列表
			 */
			$condition_pic['p_code'] = $p_id;
			$array = $this->obj_product->getProductPic($condition_pic,$page);
			if (is_array($array)){
				$pic_array = array();
				$j=0;
				for ($i=0;$i<count($array);$i++){
					if (file_exists(BasePath.'/'.$array[$i]['p_pic'])){
						$pic_array[$j]['p_pic'] = $array[$i]['p_pic'];
						$resize_pic = Common::resizePic($array[$i]['p_pic'],'96');
						$pic_array[$j]['resize_width'] = $resize_pic['width'];
						$pic_array[$j]['resize_height'] = $resize_pic['height'];
						$temp = @explode('.',$array[$i]['p_pic']);
						$pic_array[$j]['big_pic'] = $temp[0].'_big.'.$temp[1];
						$pic_array[$j]['mid_pic'] = $temp[0].'_mid.'.$temp[1];
						$pic_array[$j]['small_pic'] = $temp[0].'_small.'.$temp[1];
						$j++;
						unset($resize_pic,$temp);
					}
				}
			}
			unset($array);
			
			$title_p_name = $product_array['p_name'].' - ';
			$keyword_p_name = $product_array['p_keywords'];
			$description_p_name = $product_array['p_description'];
			/**
			 * 商品拍卖与倒计时计算
			 */
			$product_array['start_time'] = $product_array['end_time'] = 0;
			/**
			 * 开始时间
			 */
			$start_time = $product_countdown_array['cp_start_time'] - time();
			$product_array['start_time'] = $start_time > 0 ? $start_time : 0;
			/**
			 * 结束时间
			 */
			$end_time = $product_countdown_array['cp_end_time'] - time();
			$product_array['end_time'] = $end_time > 0 ? $end_time : 0;
			if ($product_countdown_array['cp_start_time'] > time()) {
				/**
				 * 还未开始
				 */
				$product_array['time_type'] = 'start';
			} else {
				/**
				 * 已经开始
				 */
				$product_array['time_type'] = 'end';
			}
			/**
			 * 交易类型
			 */
			$product_array['p_type_name'] = $this->_b_config['p_type'][$product_array['p_type']];
			/**
			 * 加价幅度
			 */
			if ($product_countdown_array['cp_system_step'] == '1') {
				/**
				 * 取商品加价幅度
				 */
				$increment = $this->obj_up_price->getIncrementUpprice($product_countdown_array['cp_cur_price']);
				$product_countdown_array['cp_price_step'] = $increment?$increment:1;
			}
			/**
			 * 更新商品浏览次数
			 */
			$update_product = array();
			$update_product['p_code'] = $p_id;
			$update_product['txtViewNum'] = 1;
			$this->obj_product->updateProductViewNum($update_product);
			/**
			 * 取地区内容
			 */
			if ($product_array['p_area_id'] !=''){
				$sel_area = $this->obj_area->getAreaPathList($product_array['p_area_id']);
			}
			/**
			 * 取得卖家资料
			 */
			$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_array['member_id']),'*','more');
			$seller_info['regist_time'] = date("Y-m-d",$seller_info['regist_time']);
			$seller_info['sms_name']	= urlencode($seller_info['login_name']);
			/**
			 * 得到卖家好评率
			 */
			require_once("score.class.php");
			$obj_score = new ScoreClass();
			$seller_info['s_rate'] = $obj_score->getScorePercent($product_array['member_id'],"s");
			$seller_info['b_rate'] = $obj_score->getScorePercent($product_array['member_id'],"b");
			unset($obj_score);
			/**
			 * 买卖家信用
			 */
			$buy_score = $this->obj_member->creditLevel($seller_info['buy_score']);
			$sale_score = $this->obj_member->creditLevel($seller_info['sale_score']);
			/**
			 * 店铺资料
			 */
			$shop_info = $this->obj_shop->getOneShopByMemeberId($product_array['member_id'],'1');
			/**
			 * 获得出价记录
			 */
			$condition = array();
			$condition['p_code'] = $p_id;
			$bid_array = $this->obj_bid->getProductBidList($condition, $obj_page);
			if (is_array($bid_array)) {
				foreach ($bid_array as $k => $v) {
					$bid_array[$k]['cb_time'] = date("Y-m-d H:i:s",$v['cb_time']);
					$bid_array[$k]['cb_time_top'] = date("H:i:s",$v['cb_time']);
					$bid_array[$k]['cb_state'] = $this->_b_config['bid_state'][$v['cb_state']];
				}
			}
			unset($condition);
			/**
			 * 商品留言信息
			 */
			$message_array = $this->obj_product_message->getMessage($page,$product_array['p_id']);
			if (is_array($message_array)){
				foreach ($message_array as $k => $v){
					$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
					$message_array[$k]['re_time'] = @date("Y-m-d H:i",$v['re_time']);
				}
			}
			/**
			 * 取得商品属性
			 */
			require_once("attribute.class.php");
			$obj_product_attribute = new AttributeClass();
			require_once("attribute_content.class.php");
			$obj_attribute_content = new AttributeContentClass();
			/**
			 * 得到商品的属性
			 */
			$condition = array();
			$condition = " and p_id = '" . $p_id . "'";
			$product_have_attribute = $this->obj_product->getProductAttribute($condition, $this->obj_page);
			unset($condition);
			if (is_array($product_have_attribute)) {
				$attribute_array = $attribute_content_array = array();
				foreach ($product_have_attribute as $ka => $va) {
					/**
					 * 获取属性值
					 */
					$condition = $product_attribute = array();
					$product_attribute = "";
					$condition['a_id'] = $va['a_id'];
					$product_attribute = $obj_product_attribute->getAttributeList($condition,$page);
					$attribute_array[] = $product_attribute[0];
					unset($condition);
					/**
					 * 获取属性内容值
					 */
					if (strstr($va['pac_content'],",")) {
						$pac_content_array = explode(",",$va['pac_content']);
						if (is_array($pac_content_array)) {
							for ($i=0; $i<count($pac_content_array); $i++) {
								$condition = $product_attribute_content = array();
								$product_attribute_content = "";
								$condition['ac_id'] = $pac_content_array[$i];
								$product_attribute_content=$obj_attribute_content->getAttributeContentList($condition,$page);
								$attribute_content_array[] = $product_attribute_content[0];
							}
						}
					} else {
						$condition = $product_attribute_content = array();
						$product_attribute_content = "";
						$condition['ac_id'] = $va['pac_content'];
						$product_attribute_content=$obj_attribute_content->getAttributeContentList($condition,$page);
						$attribute_content_array[] = $product_attribute_content[0];
					}
					unset($condition);
				}
			}
			/**
			 * 取品牌内容
			 */
			if ($product_array['p_pb_id'] !=''){
				require_once('product_brand.class.php');
				$obj_product_brand = new ProductBrandClass();
				$sel_brand = $obj_product_brand->getProductBrandPathList($product_array['p_pb_id']);
				unset($obj_product_brand);
			}
			/**
			 * 页面显示
			 */
			$seller_info['QQ']	= !empty($seller_info['QQ']) ? explode(",",$seller_info['QQ']) : $seller_info['QQ'];
			$seller_info['MSN']	= !empty($seller_info['MSN']) ? explode(",",$seller_info['MSN']) : $seller_info['MSN'];
			$seller_info['SKYPE']	= !empty($seller_info['SKYPE']) ? explode(",",$seller_info['SKYPE']) : $seller_info['SKYPE'];
			$seller_info['TAOBAO']	= !empty($seller_info['TAOBAO']) ? explode(",",$seller_info['TAOBAO']) : $seller_info['TAOBAO'];
			$this->output("title_message", $title_p_name);
			$this->output("keyword_message", $keyword_p_name);
			$this->output("meta_desc", $description_p_name);
			$this->output("product_array",$product_array);						// 主表商品信息
			$this->output("product_countdown_array",$product_countdown_array);	// 扩展表商品信息
			$this->output("sel_area",$sel_area);								// 地区
			$this->output("seller_info", $seller_info); 						// 卖家信息
			$this->output("buy_score", $buy_score);								// 买家信用
			$this->output("sale_score", $sale_score);							// 卖家信用
			$this->output("pic_array",$pic_array);								// 商品图片
			$this->output("shop_info",$shop_info);								// 店铺信息
			$this->output("bid_array",$bid_array);								// 竞拍记录
			$this->output("message_array",$message_array);						// 买家留言
			$this->output("navi_class_array",$navi_class_array);				// 导航分类
			$this->output("attribute_array",$attribute_array);					// 商品属性
			$this->output("end_time",$end_time);								// 结束时间
			$this->output("start_time",$start_time);							// 开始时间
			$this->output("attribute_content_array",$attribute_content_array);  // 商品属性内容
			$this->output("sel_brand", $sel_brand);								// 品牌
			$this->output("s_login_id",$_SESSION['s_login']['id']);				// 登录用户id
			$this->showpage('product_countdown.view');
		}
	}
	/**
	 * 把浏览过的产品的产品号放到COOKIE中保存
	 *
	 * @param string $pcode
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
}

$product = new ShowProduct();
$product->main();
unset($product);
?>
