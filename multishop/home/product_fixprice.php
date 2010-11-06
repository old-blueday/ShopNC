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
 * FILE_NAME : product_fixprice.php    FILE_PATH : \home\product_fixprice.php
 * ....一口价商品前台程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Jun 14 16:05:21 GMT 2010
 */
require ("../global.inc.php");

class ShowFixPriceProduct extends CommonFrameWork{
	/**
	 * 商铺宝贝分类对象
	 *
	 * @var obj
	 */
	var $obj_validate;
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
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	var $obj_product_brand;
	/**
	 * 商品属性对象
	 *
	 * @var obj
	 */
	var $obj_product_attribute;
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
	 * 外汇对象
	 *
	 * @var obj
	 */
	var $obj_exchange;
	/**
	 * 商品留言对象
	 *
	 * @var obj
	 */
	var $obj_product_message;
	/**
	 * 商品订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;

	function main(){
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
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
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化商品品牌类
		 */
		if (!is_object($this->obj_product_brand)){
			require_once("product_brand.class.php");
			$this->obj_product_brand = new ProductBrandClass();
		}
		/**
		 * 创建商品订单对象
		 */
		if (! is_object ( $this->obj_product_order )) {
			require_once ("order.class.php");
			$this->obj_product_order = new ProductOrderClass ( );
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
		$this->getlang("product");

		switch ($this->_input['action']){
			case "view":
				$this->_view();
				break;
			case "buy":
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
			case "check_code":
				/**
				 * 判断验证码填写是否正确
				 */
				$this->_ajax_check_code();
				break;
			default:
				$this->_view();
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
		if (!$this->checkSellType($product_row['p_sell_type'],1,$product_row['p_code'])) {
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
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}
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
		 * 买家信息 
		 */
		$member_array = $this->obj_member->getMemberInfo(array("id"=>$_SESSION['s_login']['id']),'available_predeposit','more');
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
		//去货币对应中文名称的数组
		$exchange_remark = $this->obj_exchange->getExchangeArray();
		/**
			 * 买家支付运费 在有收货地址的前提下
			 */
		if ($product_row['p_transfee_charge'] == '1'){
			/**
				 * 取运费模板内容
				 */
			if ($product_row['use_postage'] == '1'){
				$postage_content = $use_postage_content = unserialize($product_row['use_postage_content']);
			}
			if (is_array($postage_content)){
				/**
					 * 运费地区id
					 * 0为全国默认
					 */
				$postage_transfee = array(
				'ordinary'=>array(),
				'fast'=>array(),
				'ems'=>array(),
				);
				/**
					 * 不同的运费方式
					 */
				foreach ($postage_content as $k => $v){
					/**
						 * 判断是全国还是地区
						 */
					if ($receive_array[0]['sel_area'][0]['area_name'] != ''){//地区
						if (!empty($v)){
							/**
								 * 每种运费方式的内容
								 */
							foreach ($v as $k2 => $v2){
								/**
									 * 判断地区所属运费
									 */
								$tmp_array = explode(',',trim($v2[0]));
								/**
									 * 存在运费
									 */

								if (in_array($receive_array[0]['sel_area'][0]['area_id'],$tmp_array)){
									switch ($k){
										case 'postage_ordinary':
											$postage_transfee['ordinary'] = array('base'=>$v2[1],'up'=>$v2[2]);
											break;
										case 'postage_fast':
											$postage_transfee['fast'] = array('base'=>$v2[1],'up'=>$v2[2]);
											break;
										case 'postage_ems':
											$postage_transfee['ems'] = array('base'=>$v2[1],'up'=>$v2[2]);
											break;
									}
								}
								unset($tmp_array);
							}
							/**
								 * 不存在运费，使用默认运费
								 */
							switch ($k){
								case 'postage_ordinary':
									if (empty($postage_transfee['ordinary'])){
										$postage_transfee['ordinary'] = array('base'=>$v['default']['default'],'up'=>$v['default']['default_up']);
									}
									break;
								case 'postage_fast':
									if (empty($postage_transfee['fast'])){
										$postage_transfee['fast'] = array('base'=>$v['default']['default'],'up'=>$v['default']['default_up']);
									}
									break;
								case 'postage_ems':
									if (empty($postage_transfee['ems'])){
										$postage_transfee['ems'] = array('base'=>$v['default']['default'],'up'=>$v['default']['default_up']);
									}
									break;
							}

						}
					}else {//全国
						switch ($k){
							case 'postage_ordinary':
								$postage_transfee['ordinary'] = array('base'=>$v['default']['default'],'up'=>$v['default']['default_up']);
								break;
							case 'postage_fast':
								$postage_transfee['fast'] = array('base'=>$v['default']['default'],'up'=>$v['default']['default_up']);
								break;
							case 'postage_ems':
								$postage_transfee['ems'] = array('base'=>$v['default']['default'],'up'=>$v['default']['default_up']);
								break;
						}
					}
				}
			}
		}
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
		$this->output('use_postage_content',$use_postage_content);
		$this->output('postage_transfee',$postage_transfee);
		$this->output("exchange_remark", $exchange_remark);
		$this->output('payment_array',$payment_array);
		$this->output("currency_array", $currency_array);
		$this->output("product_row", $product_row);
		$this->output("member_array", $member_array);
		$this->output("receive_array", $receive_array);
		$this->output("receive_count", count($receive_array));
		$this->output("sel_area", $sel_area);
		$this->output("area_array", $area_array);
		$this->output("product_class_string", $product_class_string);
		$this->showpage("product_fixprice.buy");
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
		require(BasePath.'/cache/ProductClass_show_single.php');
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
	 * 商品展示页面
	 *
	 * @param 
	 * @return 
	 */
	function _view(){
		//检测
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductId']));
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath ( "error", "", $error );
		}else{
			$p_id = $this->_input['p_code'];
			/**
			 * 取得商品信息
			 */
			$product_row = $this->obj_product->getProductRow($p_id);
			/**
			 * 判断该商品是否存在
			 */
			if (empty($product_row)){
				$this->redirectPath ( "error", "", $this->_lang['errProductId'] );
			}
			/**
			 * 判断商品类型是否与访问类型一致
			 */
			if (!$this->checkSellType($product_row['p_sell_type'],1,$product_row['p_code'])) {
				$this->redirectPath ( "error", "../index.php", $this->_lang['errPProductIsEmpty'] );
			}
			/**
			 * 创建商品分类对象
			 */
			if (!is_object($this->objProductCate)){
				require_once ("productclass.class.php");
				$this->objProductCate = new ProductCategoryClass();
			}
			/**
			 * 取得商品属性
			 */
			if (!is_object($this->obj_product_attribute)){
				require_once("attribute.class.php");
				$this->obj_product_attribute = new AttributeClass();
			}
			/**
			 * 创建会员评价对象
			 */
			if (!is_object($this->obj_member_score)){
				require_once("score.class.php");
				$this->obj_member_score = new ScoreClass();
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
			 * 创建商品留言对象
			 */
			if (!is_object($this->obj_product_message)){
				require_once("productmessage.class.php");
				$this->obj_product_message = new ProductMessageClass();
			}
			/**
			 * 实例化分页类
			 */
			if(!is_object($this->obj_page)){
				require_once("commonpage.class.php");
				$this->obj_page = new CommonPage();
			}
			/**
			 * 语言包
			 */
			$this->getlang("productview");
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
			 * 获取商品类别路径
			 */
			$product_class_string = $this->_get_product_class_path($product_row['pc_id']);
			/**
			 * 取得商品分类树
			 */
			$ProductClassArray = $this->objProductCate->listClassDetail();
			if(!is_array($ProductClassArray)){
				$ProductClassArray = array();
			}
			$cate_path = $this->objProductCate->get_path($ProductClassArray, $product_row['pc_id']);
			/**
			 * 取得商品属性
			 */
			$condition_attribute['pc_id'] = $product_row['pc_id'];
			$product_attribute = $this->obj_product_attribute->getAttributeList($condition_attribute,$page);
			unset($condition_attribute);
			if(count($product_attribute)>0){
				$have_attribute = 1;
				$condition_attribut_content['pc_id'] = $product_row['pc_id'];
				$product_attribute_content = $this->obj_product_attribute->getAttributeWithContentList($condition_attribut_content,$page);
				unset($condition_attribut_content);
			}
			$attribute_condition_str = " and p_id = '" . $p_id . "'";
			$product_have_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $this->obj_page);

			$i=0;
			if(is_array($product_have_attribute)){
				foreach ($product_have_attribute as $key => $value){
					$ac_content = explode(',', $value[pac_content]);
					foreach ($ac_content as $k => $v){
						$pac_attribute[$i] = $v;
						$i++;
					}
				}
			}
			if(is_array($product_attribute_content)){
				foreach ($product_attribute_content as $key => $value){
					foreach ($value as $k => $v){
						if(is_array($pac_attribute) && in_array($v[ac_id], $pac_attribute)){
							$product_attribute_content[$key][$k][ischecked] = 1;
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
			 * 取得卖家好评率
			 */
			$seller_info['s_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"s");
			$seller_info['b_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"b");
			/**
			 * 取得买家/卖家信用
			 */
			$buy_score = $this->obj_member->creditLevel($seller_info['buy_score']);
			$sale_score = $this->obj_member->creditLevel($seller_info['sale_score']);
			/**
			 * 取得店铺资料
			 */
			$shop_info = $this->obj_shop->getOneShopByMemeberId($seller_info['member_id'],'1');
			/**
			 * 取店铺地区
			 */
			$array = Common::getAreaCache('');
			$area_array = array();
			if (is_array($array)){
				foreach ($array as $k => $v){
					//取当前搜索的地区内容
					if ($shop_info['shop_area_id'] != '' && $v[0] == $shop_info['shop_area_id']){
						$shop_info['shop_area_name'] = $v[2];
					}
				}
			}
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
			/**
			 * 判断是否开始
			 */
			if ($product_row['p_start_time'] > time()) {
				$text_left_time = $this->_lang['langPNotBagin'];
			}
			/**
			 * 取商品支付方式和支持货币种类，用于隐藏域使用
			 */
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
			/**
			 * 取支持的货币种类
			 */
			if (strstr($product_row['p_currency_category'],'|')){
				$currency = explode('|',trim($product_row['p_currency_category'],'|'));
			}else {
				$currency = array($product_row['p_currency_category']);
			}
			/**
			 * 商品价格通过汇率进行换算
			 */
			$condition = '';
			$condition['state'] = 1;
			$exchange_array = $this->obj_exchange->listExchange($condition,$page);
			if (is_array($exchange_array)){
				foreach ($currency as $k => $v){
					foreach ($exchange_array as $k2 => $v2){
						if ($v2['exchange_name'] == $v){
							$currency_array[$v] = $v2['exchange_rate']==0?'0':(number_format($product_row['p_price']*100/$v2['exchange_rate'],2)<=0.01?'0.01':number_format($product_row['p_price']*100/$v2['exchange_rate'],2));
						}
					}
				}
			}
			/**
			 * 去货币对应中文名称的数组
			 */
			$exchange_remark = $this->obj_exchange->getExchangeArray();
			/**
			 * 商品留言信息
			 */
			$this->obj_page->pagebarnum(4);
			$message_array = $this->obj_product_message->getMessage($this->obj_page,$product_row['p_id']);
			if (is_array($message_array)){
				foreach ($message_array as $k => $v){
					$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
					$message_array[$k]['re_time'] = @date("Y-m-d H:i",$v['re_time']);
				}
			}
			/**
			 * 交易类型
			 */
			$product_row['p_type_name'] = $this->_b_config['p_type'][$product_row['p_type']];
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
			if("0" != $product_row['p_sell_type']){//一口价和团购类型的
				$product_row['p_cur_price'] = $product_row['p_price'];
				/**
			 	  * 限定条件
			 	  */
				$obj_condition = array();
				$obj_condition['p_code'] = $p_id;
				$obj_condition['order'] = 1;
				$this->obj_page->pagebarnum(20);
				$product_order_array = $this->obj_product_order->getProductOrderList($obj_condition, $this->obj_page);
				/**
			 	 * 得到买家信息
				 */
				if (is_array($product_order_array)){
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
					}
				}
			}
			/**
			 * 更新商品浏览次数
			 */
			$update_product['p_code'] = $p_id;
			$update_product['txtViewNum'] = 1;
			$update_product_view_num = $this->obj_product->updateProductViewNum($update_product);
			//取地区内容
			if (!empty($product_row) && $product_row['p_area_id'] !=''){
				if (!is_object($this->obj_area)){
					require_once ("area.class.php");
					$this->obj_area = new AreaClass();
				}
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
			/**
			 * 写进 浏览过的宝贝 cookie名称 product_viewed
			 */
			$this->setReviewed($product_row['p_code']);
			/**
			 * 页面输出
			 */
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
			/**
			 * 商家信息时间处理
			 */
			$seller_info['regist_time'] = date("Y-m-d", $seller_info['regist_time']);
			/**
			 * 买过此商品的用户
			 */
			$member_count = 0;
			$member_id_old = array();
			$condition = array();
			$condition['p_code'] = $product_row['p_code'];
			$product_array = $this->obj_product_order->getProductOrderList($condition, $page, "buyer_id");
			foreach ($product_array as $v3) {
				if ($member_count > 11) {
					break;
				} else {
					$check = true;
					foreach ($member_id_old as $v4) {
						if ($v4 == $v3['buyer_id']) {
							$check = false;
						}
					}
					if ($check) {
						$member_id_old[] = $v3['buyer_id'];
						$condition_member = array();
						$condition_member[0]['member_id'] = $v3['buyer_id'];
						$buy_product_member_temp_array = $this->obj_member->getSomeMember($condition_member, "member_id", array("member_id,login_name","picture"), "in_member_id", "member_id", "more");
						$buy_product_member_array[] = $buy_product_member_temp_array[0];
						$member_count++;
					}
				}
			}
			//剩余时间计算
			$product_row['p_end_time'] = $product_row['p_end_time'] - time();
			unset($condition, $member_id_old, $condition_member, $product_array, $buy_product_member_temp_array);
			//卖家联系方式处理
			$seller_info['QQ']	= !empty($seller_info['QQ']) ? explode(",",$seller_info['QQ']) : $seller_info['QQ'];
			$seller_info['MSN']	= !empty($seller_info['MSN']) ? explode(",",$seller_info['MSN']) : $seller_info['MSN'];
			$seller_info['SKYPE']	= !empty($seller_info['SKYPE']) ? explode(",",$seller_info['SKYPE']) : $seller_info['SKYPE'];
			$seller_info['TAOBAO']	= !empty($seller_info['TAOBAO']) ? explode(",",$seller_info['TAOBAO']) : $seller_info['TAOBAO'];
			$this->output('default_postage',$default_postage);
			$this->output('postage_area',$postage_area);
			$this->output('pic_array',$pic_array);//商品图片列表
			$this->output('product_class_string',$product_class_string);
			$this->output("title_message"  , $title_p_name);     //TITLE内容
			$this->output("keyword_message", $keyword_p_name);     //关键字内容
			$this->output("Meta_desc", $description_p_name);     //内容描述
			$this->output("s_login_id",$_SESSION['s_login']['id']); //登录信息
			$this->output("shop_info", $shop_info);
			$this->output("product_row", $product_row);
			$this->output("PathLinks", $cate_path);
			$this->output("message_array", $message_array);   //商品留言
			$this->output("seller_info", $seller_info);		//商家信息
			$this->output("buy_score", $buy_score);//买家信用
			$this->output("sale_score", $sale_score);//卖家信用
			$this->output("category_array", $category_array);		//店铺分类
			$this->output("have_attribute", $have_attribute);
			$this->output("product_attribute", $product_attribute);
			$this->output("product_attribute_content", $product_attribute_content);
			$this->output("product_have_attribute", $pac_attribute);
			$this->output("payment_array", $payment_array);
			$this->output("currency_array", $currency_array);
			$this->output("product_order_array", $product_order_array);
			$this->output("lefttime", $text_left_time);
			$this->output("exchange_remark", $exchange_remark);
			$this->output("sel_area", $sel_area);
			$this->output("sel_brand", $sel_brand);
			$this->output("buy_product_member_array", $buy_product_member_array);
			$this->output("sp_html", $this->_input['sp_html']);//订单快照标识，用来判断模板登录内容
			if($this->_input['sp_html'] == '1'){
				$this->showpage("product.sp_order");
			}else{
				$this->showpage("product_fixprice.view");
			}
		}
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
	 * 一口价购买商品
	 *
	 * @param 页面传递表单内容
	 * @return 跳转链接
	 */
	function _bid() {
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
			$this->obj_validate->setValidate(array("input"=>$this->_input["checkaddr"],"require"=>"true","message"=>$this->_lang['errPSProvince']));
		}
		/**
			 * 取得商品信息
			 */
		$product_row = $this->obj_product->getProductRow($this->_input["p_code"]);
		/**
		 *  判断商品数量
		 */
		if (empty($this->_input['buy_num']) || $this->_input['buy_num'] > $product_row['p_storage']) {
			$this->obj_validate->setValidate(array("input"=>$this->_input["buy_num"],"require"=>"true","message"=>$this->_lang['alertProductBuyBabyNum']));
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
			if (!$this->checkSellType($product_row['p_sell_type'],1,$product_row['p_code'])) {
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
				$this->_input['receive_code'] = $this->_input["txtRcode"];
			} else {
				$this->_input['receive_code'] = $this->_input['checkaddr'];
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
			 * 商品所在分类id/订单交易类型
			 */
			$this->_input['txtPcode'] = $product_row['p_code'];
			$this->_input['txtSellerId'] = $product_row['member_id'];
			$this->_input['txtPname'] = $product_row['p_name'];
			$this->_input['txtPcid'] = $product_row['pc_id'];
			$this->_input['txtUnitPrice'] = $product_row['p_price'];
			$this->_input['txtBuyNum'] = $this->_input['buy_num'];
			$this->_input['txtTfFee'] = $this->_input['tf_fee'];
			$this->_input['txtReceiveId'] = $this->_input['receive_code'];
			$this->_input['photo_url'] = $product_row['p_pic'];
			$this->_input['sell_type'] = 1;
			/**
			 * 实例化一口价操作类
			 */
			require_once('order_process_fixprice.class.php');
			$obj_order_process = new OrderProcessFixprice();
			//生成订单
			$obj_order_process->_lang = $this->_lang;//语言包
			$result = $obj_order_process->order($this->_input);
			if ($result['error'] == '1'){
				$this->redirectPath('error','',$result['error_msg']);
			}else {
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
	/**
	 * Ajax 判断验证码是否正确
	 */
	function _ajax_check_code(){
		$code = $this->_input['checkcode'];
		if (strtoupper($code) == strtoupper($_SESSION['seccode'])){
			echo 1;/*正确*/
		}else {
			echo 2;/*错误*/
		}
	}
}
$product = new ShowFixPriceProduct();
$product->main();
unset($product);
?>