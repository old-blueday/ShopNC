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
 * FILE_NAME : html.product.php   FILE_PATH : E:\www\multishop\trunk\home\html.product.php
 * ....生成静态 --- 商品
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Aug 28 14:10:02 CST 2008
 */

require ("../global.inc.php");

class HtmlProductManage extends CommonFrameWork{
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
	var $obj_product_cate;
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
	 * 商品属性对象
	 *
	 * @var obj
	 */
	var $obj_product_attribute;
	/**
	 * 商品属性内容对象
	 * 
	 * @var obj
	 */
	var $obj_attribute_content;
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
	var $obj_page_product;
	/**
	 * 会员评价对象
	 *
	 * @var obj
	 */
	var $obj_member_score;
	/**
	 * 商店对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 商品留言对象
	 *
	 * @var obj
	 */
	var $obj_message;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	var $obj_product_brand;
	/**
	 * 商铺宝贝分类对象
	 *
	 * @var obj
	 */
	var $obj_category;	
		
	/**
	 * php5构造函数
	 */
	function __construct(){
		$this->HtmlProductManage();
	}
	
	/**
	 * php4构造函数
	 */
	function HtmlProductManage(){
		/**
		 * 执行父类的构造函数
		 */
		parent::CommonFrameWork();
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}
		/**
		 * 创建商品类别对象
		 */
		if (!is_object($this->obj_product_cate)){
			require_once("productclass.class.php");
			$this->obj_product_cate = new ProductCategoryClass();
		}
		/**
		 * 创建商品属性对象
		 */
		if (!is_object($this->obj_product_attribute)){
			require_once("attribute.class.php");
			$this->obj_product_attribute = new AttributeClass();
		}
		/**
		 * 创建商品属性内容对象
		 */
		if (!is_object($this->obj_attribute_content)) {
			require_once('attribute_content.class.php');
			$this->obj_attribute_content = new AttributeContentClass();
		}
		/**
		 * 创建商品订单对象
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 创建分页对象
		 */
		if(!is_object($this->obj_page_product)){
			require_once("commonpage.class.php");
			$this->obj_page_product = new CommonPage();
		}
		/**
		 * 创建会员评价对象
		 */
		if (!is_object($this->obj_member_score)){
			require_once("score.class.php");
			$this->obj_member_score = new ScoreClass();
		}
		/**
		 * 创建商店对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建商品留言对象
		 */
		if (!is_object($this->obj_message)){
			require_once("productmessage.class.php");
			$this->obj_message = new ProductMessageClass();
		}
		/**
		 * 创建地区对象
		 */
		if (!is_object($this->obj_area)){
			require_once ("area.class.php");
			$this->obj_area = new AreaClass();
		}
		/**
		 * 创建品牌对象
		 */
		if (!is_object($this->obj_product_brand)){
			require_once ("product_brand.class.php");
			$this->obj_product_brand = new ProductBrandClass();
		}
		
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("product");
		$this->getlang("product_html");
	}
	
	/**
	 * 主方法
	 */
//	function main(){
//		switch ($this->_input['action']){
//			case "make_product_html":
//				$this->_make_product_html();
//				break;
//		}
//	}
	
	/**
	 * 生成商品静态页面
	 */
	function _make_product_html($p_id=''){
		
		$p_id = $p_id?$p_id:$this->_input['p_id'];
		if ($p_id == ''){
			return false;
		}
		ob_start();
		//取得商品信息
		$product_row = $this->obj_product->getProductRow($p_id);
		if (empty($product_row)){
			return false;
		}
		//图片列表	
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
		/**
		 * 取得商品分类树
		 */
		$ProductClassArray = $this->obj_product_cate->listClassDetail();
		if(!is_array($ProductClassArray)){
			$ProductClassArray = array();
		}
		$cate_path = $this->obj_product_cate->get_path($ProductClassArray, $product_row['pc_id']);

		/**
		 * 取得商品属性
		 */
		$attribute_condition_str = " and p_id = '" . $p_id . "'";
		$product_have_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $obj_page);
		if (is_array($product_have_attribute)) {
			foreach ($product_have_attribute as $k => $v){
				$product_attribute_content[] = $this->obj_product_attribute->getAttributeRow($v['a_id']);
				$ac_content = explode(',', $v['pac_content']);
				if (is_array($ac_content)) {
					foreach ($ac_content as $v1){
						$product_attribute_content[count($product_attribute_content)-1]['content'][] = $this->obj_attribute_content->getAttributeContentRow(intval($v1));
					}
				}
			}
		}
		unset($product_have_attribute);
		if (!empty($product_attribute_content)) {
			$have_attribute = 1;
		}

		/**
		 * 取得出价记录
		 */
		//取得卖家资料
		$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'*','more');
		$seller_info['regist_time'] = date("Y-m-d",$seller_info['regist_time']);
		$seller_info['sms_name']	= urlencode($seller_info['login_name']);

		//得到卖家好评率
		$seller_info['s_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"s");
		$seller_info['b_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"b");
		
		//店铺资料
		$shop_info = $this->obj_shop->getOneShopByMemeberId($seller_info['member_id'],'1');
		
		//店铺地址
		if ($shop_info['shop_area_id'] !=''){
			$shop_info['shop_area'] = $this->obj_area->getAreaPathList($shop_info['shop_area_id']);
		}
		
		//剩余时间计算
		$left_time = $product_row['p_end_time'] - time();
		$product_row['left_days'] = intval($left_time / (24*60*60));
		$product_row['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
		$product_row['left_minutes'] = intval((($left_time % (60*60))) / 60);

		if("2" == $product_row['p_sell_type']){//交易类型：团购
			$product_row['less_count'] = $product_row['p_group_mincount'] - $product_row['p_sold_num'];
		}
		//取商品支付方式和支持货币种类，用于隐藏域使用
		if (is_array($this->_configinfo['payment'])){
			$i=0;
			foreach ($this->_configinfo['payment'] as $k => $v){
				if ($v == 1){
					//判断该商品的支付方式
					if (strstr($product_row['p_pay_method'],'|'.$k.'|')){
						$payment_array[$k]['name']	= $this->_b_config['payment'][$k];
						if ($i == '0'){
							$payment_array[$k]['check'] = 1;
						}
						$i++;
					}
				}
			}
		}
		//取支持的货币种类
		if (strstr($product_row['p_currency_category'],'|')){
			$currency = explode('|',trim($product_row['p_currency_category'],'|'));
		}else {
			$currency = array($product_row['p_currency_category']);
		}
		//商品价格通过汇率进行换算
		$condition = '';
		$condition['state'] = 1;
		$exchange_array = $this->obj_exchange->listExchange($condition,$page);
		//判断出售商品的价格，团购和其他的不同
		if ($product_row['p_sell_type'] == '2'){//团购
			$price = $product_row['p_group_price'];
		}else {
			$price = $product_row['p_price'];
		}
		if (is_array($exchange_array)){
			foreach ($currency as $k => $v){
				foreach ($exchange_array as $k2 => $v2){
					if ($v2['exchange_name'] == $v){
						$currency_array[$v] = $v2['exchange_rate']==0?'0':(number_format($price*100/$v2['exchange_rate'],2)<=0.01?'0.01':number_format($price*100/$v2['exchange_rate'],2));
					}
				}
			}
		}
		
		//商品留言信息
		$message_array = $this->obj_message->getMessage($page,$product_row['p_id']);
		$product_row['p_type_name'] = $this->_b_config['p_type'][$product_row['p_type']];
		/**
		 * 取商品所属子分类
		 */
		$product_class[0] = $this->obj_product_cate->getPcateRow($product_row['pc_id']);
		if ($product_class[0][1] == 0){	//1级分类
			$product_row['pc_onelevel_name'] = $product_class[0]['name'];
			$product_row['pc_onelevel_id']   = $product_class[0][0];
			$class_level = 1;
		}else {
			$product_class[1] = $this->obj_product_cate->getPcateRow($product_class[0][1]);
			if ($product_class[1][1] == 0){  //2级分类
				$product_row['pc_onelevel_name'] = $product_class[1]['name'];
				$product_row['pc_onelevel_id']   = $product_class[1][0];
				$temp = explode('nbsp;',$product_class[0]['name']);
				$product_row['pc_twolevel_name'] = $temp[count($temp)-1];
				$product_row['pc_twolevel_id']   = $product_class[0][0];
				$class_level = 2;
			}else {
				$product_class[2] = $this->obj_product_cate->getPcateRow($product_class[1][1]);
				if ($product_class[2][1] == 0){  //3级分类
					$product_row['pc_onelevel_name'] = $product_class[2]['name'];
					$product_row['pc_onelevel_id']   = $product_class[2][0];
					$temp1 = explode('nbsp;',$product_class[1]['name']);
					$product_row['pc_twolevel_name'] = $temp1[count($temp1)-1];
					$product_row['pc_twolevel_id']   = $product_class[1][0];
					$temp = explode('nbsp;',$product_class[0]['name']);
					$product_row['pc_threelevel_name'] = $temp[count($temp)-1];
					$product_row['pc_threelevel_id']   = $product_class[0][0];
					$class_level = 3;
				}else {
					$product_class[3] = $this->obj_product_cate->getPcateRow($product_class[2][1]);
					if ($product_class[3][1] == 0){  //4级分类
						$product_row['pc_onelevel_name'] = $product_class[3]['name'];
						$product_row['pc_onelevel_id']   = $product_class[3][0];
						$temp2 = explode('nbsp;',$product_class[2]['name']);
						$product_row['pc_twolevel_name'] = $temp1[count($temp2)-1];
						$product_row['pc_twolevel_id']   = $product_class[2][0];
						$temp1 = explode('nbsp;',$product_class[1]['name']);
						$product_row['pc_threelevel_name'] = $temp[count($temp1)-1];
						$product_row['pc_threelevel_id']   = $product_class[1][0];
						$temp = explode('nbsp;',$product_class[0]['name']);
						$product_row['pc_fourlevel_name'] = $temp[count($temp)-1];
						$product_row['pc_fourlevel_id']   = $product_class[0][0];
						$class_level = 4;
					}
				}
			}
		}
		unset($product_class,$temp,$temp1,$temp2);
		
		//取地区内容
		if (!empty($product_row) && $product_row['p_area_id'] !=''){
			$sel_area = $this->obj_area->getAreaPathList($product_row['p_area_id']);
		}
		
		//取品牌内容
		if (!empty($product_row) && $product_row['p_pb_id'] !=''){
			$sel_brand = $this->obj_product_brand->getProductBrandPathList($product_row['p_pb_id']);
		}
		
		/**
		 * 创建商铺宝贝分类对象
		 */
		if (!is_object($this->obj_category)){
			require_once("shopproductcategory.class.php");
			$this->obj_category = new ShopProductCategoryClass();
		}			
		//店铺商品分类
		$condition_shop_product_cate['shop_id'] = $shop_info['shop_id'];
		$condition_shop_product_cate['class_parent_id'] = '0'; //获取一级分类
		$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
		$category_array = $this->obj_category->getCategory($condition_shop_product_cate,$page);		
		
		//插件
		$this->appModuleSignOutput('ntalker','ntalker_sign');
		
		//页面title keyword description
		$title_p_name = $product_row['p_name'].' - ';
		$keyword_p_name = 
			($product_row['pc_onelevel_name']?','.$product_row['pc_onelevel_name']:'').
			($product_row['pc_twolevel_name']?','.$product_row['pc_twolevel_name']:'').
			($product_row['pc_threelevel_name']?','.$product_row['pc_threelevel_name']:'').
			($product_row['pc_fourlevel_name']?','.$product_row['pc_fourlevel_name']:'').
			','.$product_row['p_keywords'];
		$description_p_name = $product_row['p_description'];
		/**
		 * 全国默认输出运费内容
		 */
		$product_row['use_postage_content'] = unserialize($product_row['use_postage_content']);
		if (!empty($product_row['use_postage_content']['postage_ordinary'])){
			$default_postage['ordinary'] = $product_row['use_postage_content']['postage_ordinary']['default']['default'];
		}
		if (!empty($product_row['use_postage_content']['postage_fast'])){
			$default_postage['fast'] = $product_row['use_postage_content']['postage_fast']['default']['default'];
		}
		if (!empty($product_row['use_postage_content']['postage_ems'])){
			$default_postage['ems'] = $product_row['use_postage_content']['postage_ems']['default']['default'];
		}
		/**
		 * 一级地区，用来运费模板显示
		 */
		$postage_area_tmp = Common::getAreaCache('');
		$postage_area = array();
		if (is_array($postage_area_tmp)){
			foreach ($postage_area_tmp as $k => $v){
				if($v[1] == '0'){
					$postage_area[] = $v;
				}
			}
		}
		unset($postage_area_tmp);
		//卖家联系方式处理
		$seller_info['QQ']	= !empty($seller_info['QQ']) ? explode(",",$seller_info['QQ']) : $seller_info['QQ'];
		$seller_info['MSN']	= !empty($seller_info['MSN']) ? explode(",",$seller_info['MSN']) : $seller_info['MSN'];
		$seller_info['SKYPE']	= !empty($seller_info['SKYPE']) ? explode(",",$seller_info['SKYPE']) : $seller_info['SKYPE'];
		$seller_info['TAOBAO']	= !empty($seller_info['TAOBAO']) ? explode(",",$seller_info['TAOBAO']) : $seller_info['TAOBAO'];		
		/**
		 * 页面输出
		 */
//		$p_url = "../".$product_row['p_pic'];
//		$key = "3irjklsd8432uisdklvr892348";
//		$pURL = Common::encodeStr($p_url,$key);
//		$this->output('pURL',$pURL);
		$this->output('default_postage',$default_postage);
		$this->output('postage_area',$postage_area);
		$this->output('pic_array',$pic_array);//商品图片列表
		$this->output('class_level',$class_level);
		$this->output("title_message"  , $title_p_name);     //TITLE内容
		$this->output("keyword_message", $keyword_p_name);     //关键字内容
		$this->output("Meta_desc", $description_p_name);     //内容描述
		$this->output("ses_login", $_SESSION['s_login']);   //登陆信息
		$this->output("page_list", $page_list);
		$this->output("shop_info", $shop_info);
		$this->output("product_row", $product_row);
		$this->output("PathLinks", $cate_path);
		$this->output("message_array", $message_array);   //商品留言
		$this->output("seller_info", $seller_info);		//商家信息
		$this->output("category_array", $category_array);		//店铺分类		
		$this->output("have_attribute", $have_attribute);
//		$this->output("product_attribute", $product_attribute);
		$this->output("product_attribute_content", $product_attribute_content);
//		$this->output("product_have_attribute", $pac_attribute);
		$this->output("payment_array", $payment_array);
		$this->output("currency_array", $currency_array);
		$this->output("sel_area", $sel_area);
		$this->output("sel_brand", $sel_brand);
		$this->showpage("product.html");
		$this_my_file = ob_get_contents();
		ob_end_clean();

		if(!is_dir(BasePath."/html/user/".$product_row['pc_id'])){
			mkdir(BasePath."/html/user/".$product_row['pc_id'], 0777);
		}

		$html_name = BasePath."/html/user/".$product_row['pc_id']."/item_detail-".$product_row['p_code'];
		$file_name = $html_name.".html";
		require_once("makehtml.class.php");
		if(MakeHtml::tohtmlfile($file_name, $this_my_file)){
			return true;
		}else{
			return $this->_lang['langPHtmlFail'];
		}
	}
}
?>