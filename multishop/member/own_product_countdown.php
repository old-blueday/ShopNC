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
 * FILE_NAME :own_product_countdown.php
 * 倒计时拍卖商品操作
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Jul 01 11:33:57 CST 2010
 */

/**
 * 图片上传session传递
 */
if (isset($_POST["PHPSESSID"]) && $_POST['action'] == 'pic_ajax') {
	session_id($_POST["PHPSESSID"]);
}
require_once("../global.inc.php");
class OwnProductCountdownManage extends memberFrameWork{
	/**
	 * 商品对象
	 *
	 * @var object
	 */
	var $obj_product;
	/**
	 * 倒计时拍卖商品对象
	 *
	 * @var object
	 */
	var $obj_product_countdown;
	/**
	 * 商品分类对象
	 *
	 * @var object
	 */
	var $objProductCate;
	/**
	 * 会员对象
	 *
	 * @var object
	 */
	var $obj_member;	
	/**
	 * 外汇对象
	 *
	 * @var object
	 */
	var $obj_exchange;		
	/**
	 * 店铺分类对象
	 *
	 * @var object
	 */
	var $obj_shop_product_cate;
	/**
	 * 商品静态化对象
	 *
	 * @var unknown_type
	 */
	var $obj_html_product;
	/**
	 * 地区对象
	 *
	 * @var object
	 */
	var $obj_area;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	var $obj_product_brand;	
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 倒计时拍卖处理对象
	 *
	 * @var object
	 */
	var $obj_process_countdown;
	/**
	 * 图片上传对象
	 *
	 * @var object
	 */
	var $obj_upload;
	
	function main() {
		/**
		 * 实例化商品类对象
		 */
		if (!is_object($this->obj_product)) {
			include_once("product.class.php");
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
		 * 实例化商品类别对象
		 */
		if (!is_object($this->objProductCate)){
			require_once("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}	
		/**
		 * 实例化会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}		
		/**
		 * 实例化汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}			
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
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
		$this->getlang("product,product_countdown");	
		/**
		 * 菜单输出
		 */
		$this->memberMenu('seller','my_seller','to_sale');		
		
		switch ($this->_input['action']) {
			case 'update':
				$this->_update();
				break;
			case 'modi':
				$this->_modi();
				break;
			case 'add':
				/**
				 * 判断用户组权限
				 */
				CheckPermission::memberGroupPermission('sell',$_SESSION['s_login']['id']);
				/**
				 * 判断发布商品限制
				 */
				CheckPermission::outputProductPermission($_SESSION['s_login']['id']);
				/**
				 * 判断发布商品数量限制
				 */
				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
				/**
				 * 用于图片的多文件上传flash验证身份传递
				 */
				$this->output('PHPSESSID',session_id());
				/**
				 * 图片大小限制 KB 支持格式
				 */
				$this->output('upload_max_size',$this->_configinfo['file']['allowuploadmaxsize']);
				$this->output('upload_type',$this->_configinfo['file']['allowuploadimagetype']);
				$upload_ext = '*.'.implode(';*.',explode(',',trim($this->_configinfo['file']['allowuploadimagetype'],',')));
				/**
				 * 上传图片后缀名
				 */
				$this->output('upload_ext',$upload_ext);				
				$this->_add();
				break;
			case 'save':
				$this->_save();
				break;
			case "del":
				$this->_delproduct();
				break;				
			case 'operating_succ':
				$this->_operating_succ();
				break;	
			case 'ajax_check_predeposit':
				$this->_check_predeposit();
				break;	
			case 'ajax_get_attribute':
				$this->_ajax_get_attribute();
				break;	
			case "pic_ajax":
				$this->_pic_ajax("fileData");
				break;	
			case 'operating_succ':
				$this->_operating_succ();
				break;								
			default:
				$this->_add();
		}
	}
	/**
	 * 更新商品
	 *
	 */
	function _update() {
		$input_array = array();
		$input_array = $this->_input;
		$this->objvalidate->validateparam = array(
			array("input"=>$input_array['p_code'],"require"=>"true","message"=>$this->_lang['langPAddChecka']),
			array("input"=>$input_array['pc_id'],"require"=>"true","message"=>$this->_lang['langPAddCheckb']),
			array("input"=>$input_array['cp_price'],"require"=>"true","message"=>$this->_lang['langPAddCheckc']),
			array("input"=>$input_array['p_intro'],"require"=>"true","message"=>$this->_lang['langPAddCheckd']),
			array("input"=>$input_array['txtPayment'],"require"=>"true","message"=>$this->_lang['langPAddChecke']),
			array("input"=>$input_array['p_area_id'],"require"=>"true","message"=>$this->_lang['langPAddCheckf'])
		);
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 价格修改状态标识
			 */
			$price_state = $input_array['p_old_price'] != $input_array['cp_price'] ? true : false;
			/**
			 * 保证金比例
			 */
			$input_array['seller_margin'] = empty($this->_configinfo['countdown']['seller_margin']) ? 0 : $this->_configinfo['countdown']['seller_margin'];
			$input_array['buyer_margin'] = empty($this->_configinfo['countdown']['buyer_margin']) ? 0 : $this->_configinfo['countdown']['buyer_margin'];			
			/**
			 * 检查预存款
			 */
			if ($price_state) {
				$margin = '';
				$margin = @round($input_array['cp_price']*$input_array['seller_margin']/100);
				/**
				 * 不足5元按照5元计算
				 */
				$margin = $margin < 5 ? 5 : $margin;				
				if ($this->_check_predeposit(2,$margin) == false) {
					$this->redirectPath("error","../member/own_predeposit.php?action=pay",$this->_lang['langPAddRechargNo']);
				}					
			}	
			/**
			 * 更新主表商品
			 */
			$input_array["p_price"] = $input_array['cp_price'];
			if ($input_array['txtPayment'] != '') {
				$input_array["p_pay_method"] = "|".@implode("|",$input_array['txtPayment'])."|"; //支付方式
			}
			$input_array["p_currency_category"] = $input_array['currency']['CNY']; //货币类型		
			$input_array["p_update_time"] = time();
			/**
			 * 处理上传图片
			 */
			$pic_arr = array();
			for ($i=0;;$i++){
				if(!isset($_FILES['txtPpic_'.$i]['name']) || $_FILES['txtPpic_'.$i]['name'] == ''){
					break;
				}
				$pic_arr[] = $this->_pic_add('txtPpic_'.$i);
			}
			$pic_arr=explode("|||",$input_array["pichidden"]);
			if (is_array($pic_arr)){
				$pic_value = array();
				$j = 0;
				for ($i=0;$i<count($pic_arr);$i++){
					if ($pic_arr[$i] != ''){
						$arr = @explode('.',$pic_arr[$i]);
						$arr_two = @explode('_',$arr[0]);
						$pic_value[$j]['p_pic'] = $arr_two[0].'.'.$arr[1];
						$pic_value[$j]['p_code'] = $input_array["p_code"];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}		
			/**
			 * 默认取第一个作为商品列表展示使用的图片，存入商品信息表中
			 */
			$input_array['p_pic '] = $pic_value[0]['p_pic'];			
			$this->obj_product->updateProduct($input_array);
			/**
			 * 商品图片入库
			 */
			if (is_array($pic_value)){
				for ($i=0;$i<count($pic_value);$i++){
					$this->obj_product_countdown->addProductPic($pic_value[$i]);
				}
				unset($pic_value);
			}					
			/**
			 * 更新商品属性
			 */
			if(is_array($input_array["attribute_content"])){
				$i = 0;
				foreach ($input_array["attribute_content"] as $k => $v){
					if("" != $v){
						$attribute_array[$i] = explode('|', $v);
						list($ac_id[$i], $aid[$i]) = $attribute_array[$i];
						$i++;
					}
				}
				if(is_array($aid)){
					$new_aid = array_unique($aid);
					$i=0;
					foreach ($new_aid as $k => $v){
						$insert_aid[$i] = $v;
						$insert_acid[$i] = "";
						foreach($attribute_array as $key => $value){
							if($value[1] == $v){
								$insert_acid[$i] .= ",".$value[0];
							}
						}
						$insert_acid[$i] = preg_replace("/^,/", "", $insert_acid[$i]);
						$insert_ac[$i] = $insert_aid[$i]."|".$insert_acid[$i];
						$i++;
					}
					$result_attribute = $this->obj_product_countdown->updateProductAttribute($input_array["p_code"], $insert_ac);
				}
			}
			/**
			 * 更新商品发布数量的统计信息
			 */
			$update_product_statis = $this->obj_product_countdown->updateProductStatistics($_SESSION['s_login']['id'],'sell');				
			/**
			 * 更新倒计时拍卖商品
			 */
			if ($input_array['cp_start_time'] == 1) {
				/**
				 * 立刻
				 */
				$input_array['cp_start_time'] = time();
			} else {
				/**
				 * 设定
				 */
				$input_array['cp_start_time'] = strtotime($input_array['cp_start_ymd']." ".$input_array['cp_start_h'].":".$input_array['cp_start_i'].":00");	
			}		
			$input_array['cp_end_time'] = strtotime($input_array['cp_end_ymd']." ".$input_array['cp_end_h'].":".$input_array['cp_end_i'].":00");
			$input_array['cp_cur_price'] = $input_array['cp_price'];
			$input_array['member_id'] = $_SESSION['s_login']['id'];
			$result = $this->obj_product_countdown->updateProduct($input_array);
			/**
			 * 保证金重新计算(价格如更改)
			 */
			if ($price_state) {
				/**
				 * 计算已经收取的保证金
				 */
				$condition = array();
				$condition['member_id'] = $_SESSION['s_login']['id'];
				$condition['p_code'] = $input_array['p_code'];
				$condition['cm_state'] = '0';
				$condition['cm_type'] = '0';
				$condition['cm_member_type'] = '1';
				$margin_array = $this->obj_product_countdown->getMargin($condition);
				unset($condition);
				if ($margin_array['cm_id'] != '') {
					/**
					 * 退还已交保证金
					 */
					$result_1 = $this->obj_process_countdown->marginBack($margin_array['cm_margin'],$_SESSION['s_login']['id'],'9',$this->_lang['langPEditMarginBack'],$input_array["p_code"]);
					if ($result_1['error'] == 1) {
						$this->redirectPath("error","",$result_1['error_msg']);
					}
					/**
					 * 重新收取保证金
					 */
					if ($margin > 0) {
						$this->_bonds($margin,$input_array["p_code"]);	
					}		
					/**
					 * 更新保证金记录状态(已退还)
					 */
					$condition = array();
					$condition['cm_id'] = $margin_array['cm_id'];
					$condition['state'] = 1; 
					$result_2 = $this->obj_product_countdown->updateMarginState($condition);
					if (!$result_2) {
						$this->redirectPath("error","",$this->_lang['langPMarginBackFalse']);
					}
				}
			}
			if ($result) {
				/**
				 * 商品链接地址
				 */
				$url = urlencode($this->_configinfo['websit']['site_url'] . "/home/product_countdown.php?action=view&pid=" . $input_array["p_code"]);
				/**
				 * 返回链接
				 */
				$return_url = "own_product_countdown.php?action=operating_succ&url={$url}&pc_id={$input_array['pc_id']}";
				/**
				 * 页面输出
				 */
				@header("Location: ".$return_url);
				exit;				
			}			
		}
	}
	/**
	 * 商品编辑
	 *
	 */
	function _modi() {
		$input_array = array();
		$input_array = $this->_input;	
		$this->objvalidate->validateparam = array(
			array("input"=>$input_array["pid"],"require"=>"true","message"=>$this->_lang['langPAddChecka'])
		);
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 验证会员和商品是否一致
			 */
			$this->checkRightMemberToProduct($input_array["pid"]);
			/**
			 * 取主表商品信息
			 */
			$product_array = $this->obj_product->getProductRow($input_array["pid"]);	
			/**
			 * 获取倒计时拍卖商品
			 */
			$product_countdown_array = $this->obj_product_countdown->getProductRow($product_array['p_code']);
			/**
			 * 商品存在买家竞拍,不允许操作
			 */
			if ((int)$product_countdown_array['cp_bid_num'] > 0) {
				$this->redirectPath("error","../member/own_product_countdown_list.php?action=list",$this->_lang['langPListModiNo']);
			}
			/**
			 * 商品属性处理
			 */
			require_once("attribute.class.php");
			$obj_product_attribute = new AttributeClass();
			require_once("attribute_content.class.php");
			$obj_product_attribute_content = new AttributeContentClass();
			/**
			 * 取商品属性选中项
			 */
			$attribute_condition_str = " and p_id = '" . $input_array["pid"] . "'";
			$product_have_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $page);
			/**
			 * 将商品属性id组成一个数组
			 */
			if(is_array($product_have_attribute)){
				foreach ($product_have_attribute as $key => $value){
					$ac_content = explode(',', $value[pac_content]);
					foreach ($ac_content as $k => $v){
						$pac_attribute[] = $v;
					}
				}
			}
			/**
			 * 取属性
			 */
			$pcid = $product_array['pc_id'];
			$product_attribute = $obj_product_attribute->getParentAttributeContent($pcid);
			if (!empty($product_attribute)) {
				/**
				 * 去除无内容的属性
				 */
				foreach ($product_attribute as $k => $v){
					if (count($product_attribute[$k]['content']) > 0){
						$content_sign = 1;
						/**
						 * 判断选中
						 */
						foreach ($product_attribute[$k]['content'] as $k2 => $v2){
							if(is_array($pac_attribute) && in_array($v2['ac_id'], $pac_attribute)){
								$product_attribute[$k]['content'][$k2]['ischecked'] = 1;
							}
						}
					}else {
						unset($product_attribute[$k]);
					}
				}
				/**
				 * 判断商品属性是否有内容
				 */
				if ($content_sign == 1){
					/**
					 * 有内容
					 */
					$have_attribute = 1;
				}
				unset($content_sign);
			}
			/**
			 * 取商品所有类别
			 */
			$ProductClassArray = $this->objProductCate->listClassDetail('');
			if (is_array($ProductClassArray)){
				foreach ($ProductClassArray as $k => $v){
					if ($v[4] == '0') {
						$ProductCateArray[] = $v;
					}
				}
			}
			/**
			 * 该商品类别
			 */
			$sel_pc = $this->objProductCate->getProductClassPathListAll($product_array['pc_id']);
			$sel_pc = @array_reverse($sel_pc);
			$select_pclass = '';
			if (is_array($sel_pc)) {
				foreach ($sel_pc as $k => $v) {
					$select_pclass .= $v['pc_name'] . " >> ";
				}
			}
			$select_pclass = $select_pclass != '' ? substr($select_pclass,0,-3) : $select_pclass;			
		
			if ($product_array['p_state'] == '1') {
				$checked_state = 1;
			}elseif ($product_array['p_state'] == '0' && $product_array['p_start_time'] != '0') {
				$checked_state = 2;
			}else {
				$checked_state = 3;
			}
			/**
			 * 处理商品支持的货币种类
			 */
			if (strstr($product_array['p_currency_category'],'|')) {
				$product_currency = @explode('|',trim($product_array['p_currency_category'],'|'));
			}else {
				$product_currency = array();
				$product_currency[] = $product_array['p_currency_category'];
			}
			/**
			 * 取货币种类
			 */
			$condition_exchange['state'] = 1;
			$exchange_array = $this->obj_exchange->listExchange($condition_exchange,$page);
			if (is_array($exchange_array)){
				foreach ($exchange_array as $k => $v){
					if ($v['exchange_name'] != 'CNY') {
						unset($exchange_array[$k]);
					} else {
						/**
						 * 前台显示标识
						 */
						$exchange_array[$k]['display'] = 'block';
					}
				}
			}
			/**
			 * 取支付方式
			 */
			if (is_array($this->_configinfo['payment'])){
				/**
				 * 取会员信息,用来验证显示的支付方式
				 */
				$condition['id'] = $_SESSION['s_login']['id'];
				$member_array = $this->obj_member->getMemberInfo($condition,'*',$operate_genre='more');
				foreach ($this->_configinfo['payment'] as $k => $v){
					if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
						include_once(BasePath.'/payment/'.$k.'/payment_module.php');
						$class_name = $k.'PaymentMethod';
						$obj_p_module = new $class_name;
						$param_array = $obj_p_module->payment_param();
						/**
						 * 不是线下的，并且在会员信息中有值的
						 */
						if ($param_array['type'] != 'offline' && $member_array[$k] != ''){
							$payment_array[$k]['name'] = $param_array['name'];
							/**
							 * 支持的货币种类
							 */
							$payment_array[$k]['currency'] = $param_array['currency'];
							/**
							 * 数组形式
							 */
							$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);
						}elseif ($param_array['type'] == 'offline'){
							/**
							 * 是线下的 并且是开启状态的（值为1）
							 */
							$payment_array[$k]['name'] = $param_array['name'];
							/**
							 * 支持的货币种类
							 */
							$payment_array[$k]['currency'] = $param_array['currency'];
							/**
							 * 数组形式
							 */
							$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);
						}
						/**
						 * 判断是否选中
						 */
						if (strstr($product_array['p_pay_method'],'|'.$k.'|') && $payment_array[$k]['name'] != ''){
							$payment_array[$k]['check'] = 1;
						}
						/**
						 * 支付说明是使用的数组
						 */
						$payment_description[] = $param_array;
						unset($class_name,$obj_p_module,$param_array);
					}
				}
			}
			/**
			 * 获得店铺宝贝分类
			 */
			if ($_SESSION['s_shop']['id'] != ''){
				$shop_product_category = $this->_getshopclass($_SESSION['s_shop']['id']);
			}
			/**
			 * 控制货币前台显示
			 */
			if (is_array($payment_array)){
				$array = array();
				foreach ($payment_array as $k => $v){
					/**
					 * 选中的支付方式
					 */
					if ($v['check'] == 1){
						if (is_array($v['currency'])){
							foreach ($v['currency'] as $k2 => $v2){
								$array[]= $v2;
							}
						}
					}
				}
				$array = array_unique($array);
				sort($array);
				if (is_array($exchange_array)){
					foreach ($exchange_array as $k => $v){
						if (!in_array($v['exchange_name'],$array)){
							/**
							 * 前台显示标识
							 */
							$exchange_array[$k]['display'] = 'none';
						}
					}
					sort($exchange_array);
				}
			}
			unset($array);		
			/**
			 * 地区调用
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
			if (!empty($product_array) && $product_array['p_area_id'] !=''){
				/**
				 * 创建地区对象
				 */
				if (!is_object($this->obj_area)){
					require_once ("area.class.php");
					$this->obj_area = new AreaClass();
				}
				$sel_area = $this->obj_area->getAreaPathList($product_array['p_area_id']);
			}	
			/**
			 * 商品编辑图片回显
			 */
			$condition_pic['p_code'] = $input_array["pid"];
			$array = $this->obj_product_countdown->getProductPic($condition_pic,$page);
			if (is_array($array)){
				$pic_array = array();
				$j=0;
				for ($i=0;$i<count($array);$i++){
					if (file_exists(BasePath.'/'.$array[$i]['p_pic'])){
						$pic_array[$j]['p_pic'] = $array[$i]['p_pic'];
						$temp = @explode('.',$array[$i]['p_pic']);
						$pic_array[$j]['small_pic'] = $temp[0].'_small.'.$temp[1];
						$pic_line .= '|'.$pic_array[$j]['small_pic'];
						$j++;
						unset($temp);
					}
				}
				$pic_line = trim($pic_line,'|');
			}
			unset($array);	
			/**
			 * 商品品牌内容
			 */
			$array = Common::getProductBrandCache('');
			$brand_list = array();
			if (is_array($array)){
				foreach ($array as $k => $v){
					if ($v[1] == '0'){
						$v['pb_id'] = $v[0];
						$v['pb_u_id'] = $v[1];
						$v['pb_name'] = $v[2];
						/**
						 * 1是父ID，0不是
						 */
						$v['is_parent'] = $v[5];
						$brand_list[] = $v;
					}
				}
			}
			unset($array);	
			/**
			 * 取品牌内容
			 */
			$sel_brand = array();
			if (!empty($product_array) && !empty($product_array['p_pb_id'])){
				/**
				 * 创建品牌对象
				 */
				if (!is_object($this->obj_product_brand)){
					require_once ("product_brand.class.php");
					$this->obj_product_brand = new ProductBrandClass();
				}				
				$sel_brand = $this->obj_product_brand->getProductBrandPathList($product_array['p_pb_id']);
			}	
			
			/**
			 * 拍卖开始时间初始化
			 */
			/**
			 * 小时
			 */
			$starttime_h = date("G",time());
			/**
			 * 分钟(5分为间隔)
			 */
			$starttime_i = intval(date("i",time()));
			$starttime_i = $starttime_i + (5-$starttime_i%5);	
			$starttime_i = $starttime_i == 60 ? $starttime_i - 1 : 	$starttime_i;		
			/**
			 * 页面显示
			 */
			$this->output("product_array",$product_array); 						//主表商品信息
			$this->output("product_countdown_array",$product_countdown_array); 	//倒计时拍卖商品信息
			$this->output("select_pclass", $select_pclass);						//商品类别	
			$this->output("pc_id", $product_array['pc_id']);					//商品类别id		
			$this->output("sel_area", $sel_area);								//选择的地区
			$this->output("area_array", $area_array);							//地区列表信息
			$this->output("sel_pc", $sel_pc);									//商品分类
			$this->output('ProductCateArray',$ProductCateArray);				//商品分类列表	
			$this->output("product_attribute", $product_attribute);				//商品属性
			$this->output("shop_product_cate_array",  $shop_product_category);	//店铺分类
			$this->output("sel_brand", $sel_brand);								//品牌	
			$this->output("pic_array", $pic_array);								//商品图片
			$this->output("brand_list", $brand_list);							//品牌列表
			$this->output("starttime_h", $starttime_h);							//拍卖开始小时
			$this->output("starttime_i", $starttime_i);							//拍卖开始分钟	
			$this->output("payment_array", $payment_array);						//支付方式			
			$this->output("payment_description", $payment_description);			//支付说明	
			$this->output("exchange_array", $exchange_array);					//货币类型	
			$this->output("product_currency", $product_currency);				//商品支持的货币类型	
			$this->showpage("own_product_countdown");			
		}
	}
	/**
	 * 保存添加商品
	 *
	 */
	function _save() {
		$input_array = array();
		$input_array = $this->_input;
		$this->objvalidate->validateparam = array(
			array("input"=>$input_array['pc_id'],"require"=>"true","message"=>$this->_lang['langPAddCheckb']),
			array("input"=>$input_array['cp_price'],"require"=>"true","message"=>$this->_lang['langPAddCheckc']),
			array("input"=>$input_array['p_intro'],"require"=>"true","message"=>$this->_lang['langPAddCheckd']),
			array("input"=>$input_array['txtPayment'],"require"=>"true","message"=>$this->_lang['langPAddChecke']),
			array("input"=>$input_array['p_area_id'],"require"=>"true","message"=>$this->_lang['langPAddCheckf'])
		);
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","../member/own_product.php?action=sell",$error);
		}else{
			/**
			 * 保证金比例
			 */
			$input_array['seller_margin'] = empty($this->_configinfo['countdown']['seller_margin']) ? 0 : $this->_configinfo['countdown']['seller_margin'];
			$input_array['buyer_margin'] = empty($this->_configinfo['countdown']['buyer_margin']) ? 0 : $this->_configinfo['countdown']['buyer_margin'];				
			/**
			 * 保证金计算
			 */
			$margin = "";
			$margin = @round($input_array['cp_price']*$input_array['seller_margin']/100);
			/**
			 * 不足5元按照5元计算
			 */
			$margin = $margin < 5 ? 5 : $margin;		
			/**
			 * 检查预存款
			 */				
			if ($this->_check_predeposit(2,$margin) == false) {
				$this->redirectPath("error","../member/own_predeposit.php?action=pay",$this->_lang['langPAddRechargNo']);
			}
			/**
			 * 添加主要商品表
			 */
			$product_last_id = $this->obj_product->getProductLastId();
			if("" == $product_last_id){
				$product_last_id = 1;
			}else{
				$product_last_id += 1;
			}
			$chars = array(
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
			"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
			"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
			"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
			"S", "T", "U", "V", "W", "X", "Y", "Z"
			);
			$random_string = Common::genRandomString($chars, 4);
			/**
			 * 商品编号
			 */
			$input_array["p_code"] = md5($product_last_id.$random_string);
			/**
			 * 商品价格
			 */
			$input_array["p_price"] = $input_array['cp_price'];
			/**
			 * 商品上架状态
			 */
			$input_array["p_state"] = 1;
			/**
			 * 卖家id
			 */
			$input_array["member_id"] = $_SESSION['s_login']['id'];
			/**
			 * 支付方式
			 */			
			if ($input_array['txtPayment'] != '') {
				$input_array["p_pay_method"] = "|".@implode("|",$input_array['txtPayment'])."|";
			}
			/**
			 * 货币类型
			 */
			$input_array["p_currency_category"] = $input_array['currency']['CNY']; 
			if($input_array["p_auto_publish"] == ""){
				$input_array["p_auto_publish"] = 0;
			}			
			$input_array["p_add_time"] = time();
			$input_array["p_update_time"] = time();
			/**
			 * 处理上传图片
			 */
			$pic_arr = array();
			for ($i=0;;$i++){
				if(!isset($_FILES['txtPpic_'.$i]['name']) || $_FILES['txtPpic_'.$i]['name'] == ''){
					break;
				}
				$pic_arr[] = $this->_pic_add('txtPpic_'.$i);
			}
			$pic_arr=explode("|||",$input_array["pichidden"]);
			if (is_array($pic_arr)){
				$pic_value = array();
				$j = 0;
				for ($i=0;$i<count($pic_arr);$i++){
					if ($pic_arr[$i] != ''){
						/**
						 * $pic_arr[$i] 为缩略图文件名，更改为普通图片缩略图
						 */
						$arr = @explode('.',$pic_arr[$i]);
						$arr_two = @explode('_',$arr[0]);
						$pic_value[$j]['p_pic'] = $arr_two[0].'.'.$arr[1];
						$pic_value[$j]['p_code'] = $input_array["p_code"];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}
			/**
			 * 拍卖开始时间
			 */
			$start_time = "";
			$end_time = "";
			if ($input_array['cp_start_time'] == 1) {
				/**
				 * 立刻
				 */
				$start_time = time();
			} else {
				/**
				 * 设定
				 */
				$start_time = strtotime($input_array['cp_start_ymd']." ".$input_array['cp_start_h'].":".$input_array['cp_start_i'].":00");	
			}	
			/**
			 * 拍卖结束时间
			 */
			$end_time = strtotime($input_array['cp_end_ymd']." ".$input_array['cp_end_h'].":".$input_array['cp_end_i'].":00");							
			/**
			 * 默认取第一个作为商品列表展示使用的图片，存入商品信息表中
			 */
			$input_array['p_pic '] = $pic_value[0]['p_pic'];
			$input_array['p_start_time'] = $start_time;						
			$input_array['p_end_time'] = $end_time;		
			/**
			 * 添加主商品表
			 */
			$insert_id = $this->obj_product->addProduct($input_array);	
			/**
			 * 商品图片入库
			 */
			if (is_array($pic_value)){
				for ($i=0;$i<count($pic_value);$i++){
					$this->obj_product_countdown->addProductPic($pic_value[$i]);
				}
				unset($pic_value);
			}					
			/**
			 * 商品属性及属性内容ID处理
			 */
			if(is_array($input_array["attribute_content"])){
				$i = 0;
				foreach ($input_array["attribute_content"] as $k => $v){
					if("" != $v){
						$attribute_array[$i] = explode('|', $v);
						list($ac_id[$i], $aid[$i]) = $attribute_array[$i];
						$i++;
					}
				}
				if(is_array($aid)){
					$new_aid = array_unique($aid);
					$i=0;
					foreach ($new_aid as $k => $v){
						$insert_aid[$i] = $v;
						$insert_acid[$i] = "";
						foreach($attribute_array as $key => $value){
							if($value[1] == $v){
								$insert_acid[$i] .= ",".$value[0];
							}
						}
						$insert_acid[$i] = preg_replace("/^,/", "", $insert_acid[$i]);
						$insert_ac[$i] = $insert_aid[$i]."|".$insert_acid[$i];
						$i++;
					}
					$result_attribute = $this->obj_product_countdown->updateProductAttribute($input_array["p_code"], $insert_ac);
				}
			}		
			/**
			 * 添加倒计时拍卖商品表
			 */
			$input_array['p_id'] = $insert_id;
			$input_array['cp_start_time'] = $start_time;
			$input_array['cp_end_time'] = $end_time;
			$result = $this->obj_product_countdown->addProduct($input_array);
			if ($result) {
				/**
				 * 收取保证金
				 */
				$this->_bonds($margin,$input_array["p_code"]);
				/**
				 * 更新用户积分
				 */
				CreditsClass::saveCreditsLog('succ_product_put',$_SESSION["s_login"]['id']);			
				/**
				 * 更新商品发布数量的统计信息
				 */
				$update_product_statis = $this->obj_product_countdown->updateProductStatistics($_SESSION['s_login']['id'],'sell');
				/**
				 * 商品链接地址
				 */
				$url = urlencode($this->_configinfo['websit']['site_url'] . "/home/product_countdown.php?action=view&pid=" . $input_array["p_code"]);
				/**
				 * 返回链接
				 */
				$return_url = "own_product_countdown.php?action=operating_succ&url={$url}&pc_id={$input_array['pc_id']}";
				/**
				 * 页面输出
				 */
				@header("Location: ".$return_url);
				exit;				
			}			
		}
	}
	/**
	 * 商品发布成功
	 *
	 */
	function _operating_succ() {
		/**
		 * 页面输出
		 */
		$this->output('slPCId',$this->_input['pc_id']);
		$this->output('url',$this->_input['url']);
		$this->output('url_sign','countdown');
		$this->showpage("own_product.succ");
	}	
	/**
	 * 显示商品添加
	 *
	 */
	function _add() {
		$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["pc_id"],"require"=>"true","message"=>$this->_lang['langPAddCheckg']),
		);
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","../member/own_product.php?action=sell",$error);
		}else{
			/**
			 * 预存款可用金额检查
			 */
			if (!$this->_check_predeposit()) {
				$this->redirectPath("error","../member/own_predeposit.php?action=pay",$this->_lang['langPAddCheckh']);
				exit;
			}
			/**
			 * 发布的商品类别
			 */
			$sel_pc = $this->objProductCate->getProductClassPathListAll($this->_input['pc_id']);
			$sel_pc = @array_reverse($sel_pc);
			$select_pclass = '';
			if (is_array($sel_pc)) {
				foreach ($sel_pc as $k => $v) {
					$select_pclass .= $v['pc_name'] . " >> ";
				}
			}
			$select_pclass = $select_pclass != '' ? substr($select_pclass,0,-3) : $select_pclass;
			/**
			 * 取支付方式
			 */
			if (is_array($this->_configinfo['payment'])){
				/**
				 * 会员信息
				 */
				$condition['id'] = $_SESSION['s_login']['id'];
				$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
				/**
				 * 取会员信息,用来验证显示的支付方式
				 */
				foreach ($this->_configinfo['payment'] as $k => $v){
					if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
						include_once(BasePath.'/payment/'.$k.'/payment_module.php');
						$class_name = $k.'PaymentMethod';
						$obj_p_module = new $class_name;
						$param_array = $obj_p_module->payment_param();
						/**
						 * 不是线下的，并且在会员信息中有值的
						 */
						if ($param_array['type'] != 'offline' && $member_array[$k] != ''){
							$payment_array[$k]['name'] = $param_array['name'];
							/**
							 * 支持的货币种类
							 */
							$payment_array[$k]['currency'] = $param_array['currency'];
							$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);
							
						}elseif ($param_array['type'] == 'offline'){
							/**
							 * 是线下的
							 */
							$payment_array[$k]['name'] = $param_array['name'];
							/**
							 * 支持的货币种类
							 */
							$payment_array[$k]['currency'] = $param_array['currency'];
							$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);
						}
						/**
						 * 默认为显示的支付方式全部选中
						 */
						if ($payment_array[$k]['name'] != ''){
							$payment_array[$k]['check'] = 1;
						}
						$payment_description[] = $param_array;
						/**
						 * 销毁变量
						 */
						unset($class_name,$obj_p_module,$param_array);
					}
				}
			}
			/**
			 * 如果没有填写支付帐号
			 */
			if (!is_array($payment_array)){
				$this->redirectPath("error","../member/own_payment.php",$this->_lang['errMPaymentEmpty']);
			}	
			/**
			 * 取货币种类
			 */
			$condition_exchange['state'] = 1;
			$exchange_array = $this->obj_exchange->listExchange($condition_exchange,$page);
			if (is_array($exchange_array)){
				foreach ($exchange_array as $k => $v){
					/**
					 * 去除除人民币外的货币类型
					 */
					if ($v['exchange_name'] != 'CNY') {
						unset($exchange_array[$k]);
					} else {
						/**
						 * 前台显示标识
						 */
						$exchange_array[$k]['display'] = 'block';
					}
				}
			}		
			/**
			 * 控制货币前台显示
			 */
			if (is_array($payment_array)){
				$array = array();
				$product_currency = array();
				foreach ($payment_array as $k => $v){
					/**
					 * 选中的支付方式
					 */
					if ($v['check'] == 1){
						if (is_array($v['currency'])){
							foreach ($v['currency'] as $k2 => $v2){
								$array[]= $v2;
							}
						}
					}
					/**
					 * 默认取所有货币为支持的货币
					 */
					$product_currency = array_merge($product_currency,$v['currency']);
				}
				$array = array_unique($array);
				sort($array);
				if (is_array($exchange_array)){
					foreach ($exchange_array as $k => $v){
						if (!in_array($v['exchange_name'],$array)){
							/**
							 * 前台显示标识
							 */
							$exchange_array[$k]['display'] = 'none';
						}
					}
					sort($exchange_array);
				}
			}
			/**
			 * 去除重复的货币种类
			 */
			$product_currency = @array_unique($product_currency);
			unset($array);	
			/**
			 * 地区调用
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
			 * 商品品牌内容
			 */
			$array = Common::getProductBrandCache('');
			$brand_list = array();
			if (is_array($array)){
				foreach ($array as $k => $v){
					if ($v[1] == '0'){
						$v['pb_id'] = $v[0];
						$v['pb_u_id'] = $v[1];
						$v['pb_name'] = $v[2];
						/**
						 * 1是父ID，0不是
						 */
						$v['is_parent'] = $v[5];
						$brand_list[] = $v;
					}
				}
			}
			unset($array);
			/**
			 * 获得店铺宝贝分类
			 */
			if ($_SESSION['s_shop']['id'] != ''){
				$shop_product_category = $this->_getshopclass($_SESSION['s_shop']['id']);
			}	
			/**
			 * 拍卖开始时间初始化
			 */
			/**
			 * 小时
			 */
			$starttime_h = date("G",time());
			/**
			 * 分钟(5分为间隔)
			 */
			$starttime_i = intval(date("i",time()));
			$starttime_i = $starttime_i + (5-$starttime_i%5);	
			$starttime_i = $starttime_i == 60 ? $starttime_i - 1 : 	$starttime_i;
			
			/**
			 * 页面显示
			 */
			$this->output("ProductCateArray", $ProductCateArray);				//商品分类
			$this->output("select_pclass", $select_pclass);						//商品类别
			$this->output("pc_id", $this->_input['pc_id']);						//商品类别id
			$this->output("exchange_array", $exchange_array);					//货币选择
			$this->output("payment_array", $payment_array);						//支付方式
			$this->output("payment_description", $payment_description);			//支付方式描述
			$this->output("area_array", $area_array);							//地区选择
			$this->output("brand_list", $brand_list);							//品牌内容
			$this->output("shop_product_cate_array", $shop_product_category);	//店铺类别
			$this->output("starttime_h", $starttime_h);							//拍卖开始小时
			$this->output("starttime_i", $starttime_i);							//拍卖开始分钟
			$this->output("product_currency", $product_currency);				//系统支持的货币类型
			$this->showpage('own_product_countdown');			
		}
	}
	/**
	 * 删除商品
	 *
	 */
	function _delproduct(){
		if (is_array($this->_input['chboxPid'])){
			foreach ($this->_input['chboxPid'] as $value){
				$this->objvalidate->setValidate(array("input"=>$value,"require"=>"true","message"=>$this->_lang['errProductId']));
			}
		}
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			if (is_array($this->_input['chboxPid'])){
				foreach ($this->_input['chboxPid'] as $k => $value){
					if ($this->_input['check_sign'][$value] != ''){
						unset($this->_input['chboxPid'][$k]);
					} else {
						/**
						 * 允许删除	
						 */
						$this->checkRightMemberToProduct($value);				
						/**
						 * 删除主商品表商品
						 */
						$result = $this->obj_product->delProduct($value);
						/**
						 * 删除扩展表商品
						 */
						$condition = array();
						$condition['p_code'] = $value;
						$condition['member_id'] = $_SESSION['s_login']['id'];
						$this->obj_product_countdown->delProduct($condition);
						unset($condition);							
						/**
						 * 退还商品保证金
						 */
						$this->backMargin($value,$this->_lang['langPDelBackSellerMargin']);
						/**
						 * 判断商品是否存在属性
						 */
						$att = $this->obj_product->getProductAttribute(" and p_id = '" . $value . "'", $page);
						/**
						 * 删除商品属性
						 */
						if (!empty($att)) {
							$this->obj_product->delProductAttribute($value);
							unset($have_attribute);
						}							
					}
				}
				/**
				 * 更新会员的发布商品数量
				 */
				$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'],'sell');
				/**
				 * 返回链接的action标识
				 */
				$this->_input['list_type'] = $this->_input['list_type']?$this->_input['list_type']:'list';
				$this->redirectPath("succ","member/own_product_countdown_list.php?action=".$this->_input['list_type'],$this->_lang['langPSoperatorOk']);				
			} else {
				$this->redirectPath("error","",$this->_lang['errProductId']);
			}
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
	 * 预存款可用金额检查
	 *
	 * @return boolean
	 */
	function _check_predeposit($type = '',$margin = '') {
		$type = !empty($this->_input['type']) ? $this->_input['type'] : $type;
		if ($_SESSION['s_login']['id'] != '') {
			/**
			 * 获取与存款可用金额
			 */
			$member_array = $conditon = array();
			$conditon["id"] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($conditon,"*","more");	
			if ($type == 1) {
				$margin = @round($this->_input['price']*$this->_configinfo['countdown']['seller_margin']/100);
				/**
				 * 不足5元按照5元计算
				 */
				$margin = $margin < 5 ? 5 : $margin;
				if ($member_array['available_predeposit'] - $margin >= 0) {
					echo "yes";
				} else {
					echo $member_array['available_predeposit'];
				}
				exit;
			} else if ($type == 2) {
				/**
				 * 检查预存款是否足够支付保证金
				 */
				if (($member_array['available_predeposit'] != '') && ($member_array['available_predeposit'] > $margin)) {
					return true;
				} else {
					return false;
				}
			} else {
				/**
				 * 检查是否有预存款
				 */
				if (($member_array['available_predeposit'] != '') && ($member_array['available_predeposit'] > 0)) {
					return true;
				} else {
					return false;
				}				
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 获取店铺商品分类
	 *
	 * @param int $shop_id
	 * @return array
	 */
	function _getshopclass ($shop_id) {
		/**
		 * 创建商铺宝贝分类对象
		 */
		if (!is_object($this->obj_shop_product_cate)){
			require_once("shopproductcategory.class.php");
			$this->obj_shop_product_cate = new ShopProductCategoryClass();
		}
		/**
		 * 得到店铺宝贝分类
		 */
		$condition_shop_product_cate['shop_id'] = $shop_id;
		$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
		$shop_product_category = $this->obj_shop_product_cate->getCategory($condition_shop_product_cate,$page);
		/**
		 * 整理数组为多级
		 */
		$shop_product_category = $this->obj_shop_product_cate->_makeCategoryArray($shop_product_category);
		return 	$shop_product_category;
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
			$result = $this->obj_process_countdown->bondsSeller($margin,$sp_code);
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
	 * 检查会员是否和商品所属会员相同
	 */
	function checkRightMemberToProduct($p_id){
		if ($p_id != ''){
			$product_array = $this->obj_product_countdown->getProductRow($p_id);
			if ($product_array['member_id'] != $_SESSION["s_login"]['id']){
				$error = $this->_lang['langPProductMemberErrRestartLogin'];
				$this->redirectPath("error","../index.html",$error);
			}
		}else {
			$error = $this->_lang['langPProductMemberErrRestartLogin'];
			$this->redirectPath("error","../index.html",$error);
		}
	}	
	/**
	 * 商品编辑页面 ajax取商品属性
	 */
	function _ajax_get_attribute(){
		$pc_id = intval($this->_input['pc_id']);
		if ($pc_id > 0){
			$product_attribute = $this->_get_attribute($pc_id);
			/**
			 * 输出内容
			 */
			$html = '';
			if (is_array($product_attribute)){
				foreach ($product_attribute as $k => $v){
					$html .= '<span class="td_attribute_span">'.$v['a_name'].'</span>:';
					$html .= "&nbsp;";
					/**
					 * 单选
					 */
					if ($v['a_type'] == '0'){
						$html .= '<select class="wd" name="attribute_content[]" style="float: none; display: inline;">';
						$html .= '<option value=""></option>';
						if (is_array($v['content'])){
							/**
							 * 内容
							 */
							foreach($v['content'] as $k2 => $v2){
								$html .= '<option value="'.$v2['ac_id'].'|'.$v2['a_id'].'">';
								$html .= $v2['ac_content'];
								$html .= '</option>';
							}
						}
						$html .= "</select>";
					}
					/**
					 * 复选
					 */
					if ($v['a_type'] == '1'){
						if (is_array($v['content'])){
							/**
							 * 内容
							 */
							foreach($v['content'] as $k2 => $v2){
								$html .= '<input name="attribute_content[]" type="checkbox" value="'.$v2['ac_id'].'|'.$v2['a_id'].'">';
								$html .= $v2['ac_content'];
								$html .= "&emsp;";
							}
						}
					}
					/**
					 * 折行
					 */
					$html .= "<br /><br style=\"line-height:5px;\" />";
					if ($k%4 == '0' && $k != '0'){
						
					}
				}
				echo $html;
				exit;
			}
		}
	}	
	/**
	 * 取属性内容
	 * $pc_id 属性id
	 */
	function _get_attribute($pc_id){
		$pc_id = intval($pc_id);
		if (intval($pc_id) <= 0){
			return false;
		}
		/**
		 * 商品属性
		 */
		require_once("attribute.class.php");
		$obj_product_attribute = new AttributeClass();
		require_once("attribute_content.class.php");
		$obj_product_attribute_content = new AttributeContentClass();

		/**
		 * 取商品属性及属性内容
		 */
		$product_attribute = $obj_product_attribute->getParentAttributeContent($pc_id);
		if (!empty($product_attribute)) {
			/**
			 * 去除无内容的属性
			 */
			foreach ($product_attribute as $k => $v){
				if (count($product_attribute[$k]['content']) > 0){
					$content_sign = 1;
				}else {
					unset($product_attribute[$k]);
				}
			}
		}
		unset($obj_product_attribute,$obj_product_attribute_content);
		return $product_attribute;
	}
	/**
	 * ajax图片上传
	 *
	 * @param  $input_file_name
	 */
	function _pic_ajax($input_file_name){
		if (!is_object($this->obj_upload)){
			require_once("uploadfile.class.php");
			$this->obj_upload = new UploadFile();
			$this->obj_upload->max_size = $this->_configinfo['file']['allowuploadmaxsize'];
			$this->obj_upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
		}
		/**
		 * 上传商品图片
		 */
		$filename = $this->obj_upload->upfile($input_file_name);
		/**
		 * 按比例生成图片
		 */
		$cut = $this->_configinfo['productinfo']['imageresize_ifcut'];
		if ($filename !== false){
			/**
			 * 加水印
			 */
			if ($this->_configinfo['gdimage']['wm_image_sign'] == 1 && file_exists(BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'])) {
				/**
				 * 图片名
				 */
				$return_name = $filename["getfilename"];
				require_once ("gdimage.class.php");
				$img = new GDImage();
				/**
				 * 透明度
				 */
				$img->wm_image_transition = $this->_configinfo['gdimage']['wm_image_transition'];
				/**
				 * 位置
				 */
				$img->wm_image_pos = $this->_configinfo['gdimage']['wm_image_pos'];
				/**
				 * 返回文件名称
				 */
				$img->save_file = BasePath.'/'.$return_name;
				/**
				 * 水印图片
				 */
				$img->wm_image_name = BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'];
				$img->create(BasePath.'/'.$return_name);
				unset($img);
			}
			include_once ('resizeImage.class.php');
			/**
			 * 判断图片大小
			 */
			$image_info = @getimagesize($filename['filename']);
			$width = $image_info[0];
			$height = $image_info[1];
			/**
			 * 用宽度
			 */
			if ($width > $height){
				$pic_param = $width;
				$small_percent = number_format($pic_param/$this->_configinfo['productinfo']['imageresize_width'],2);
			}else {
				/**
				 * 用高度
				 */
				$pic_param = $height;
				$small_percent = number_format($pic_param/$this->_configinfo['productinfo']['imageresize_height'],2);
			}
			/**
			 * 小图
			 */
			if (intval($small_percent) > 1){
				$obj_small = new resizeImage($filename['filename'],intval($width/$small_percent),intval($height/$small_percent),$cut);
			}elseif (intval($small_percent) == 1){
				/**
				 * 取与标准尺寸的差值
				 */
				$pic_percent = $small_percent;
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$small_width = intval($width*($pic_percent));
				$small_height = intval($height*($pic_percent));
				$obj_small = new resizeImage($filename['filename'],$small_width,$small_height,$cut);
			}else {
				$obj_small = new resizeImage($filename['filename'],$width,$height,$cut);
			}
			/**
			 * 中图
			 */
			if (intval($pic_param/192) > 1){
				$obj_mid = new resizeImage($filename['filename'],intval($width/($pic_param/192)),intval($height/($pic_param/192)),$cut,"_mid.");
			}elseif (intval($pic_param/192) == 1){
				/**
				 * 取与标准尺寸的差值
				 */
				$pic_percent = number_format($pic_param/192,2);
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$mid_width = intval($width*($pic_percent));
				$mid_height = intval($height*($pic_percent));
				$obj_mid = new resizeImage($filename['filename'],$mid_width,$mid_height,$cut,"_mid.");
			}else {
				$obj_mid = new resizeImage($filename['filename'],$width,$height,$cut,"_mid.");
			}
			/**
			 * 大图
			 */
			if (intval($pic_param/288) >= 1){
				$obj_big = new resizeImage($filename['filename'],intval($width/($pic_param/288)),intval($height/($pic_param/288)),$cut,"_big.");
			}else {
				$obj_big = new resizeImage($filename['filename'],$width,$height,$cut,"_big.");
			}
			unset($obj_small,$obj_mid,$obj_big);
		}
		echo $filename["getfilename"];
	}	
}
$product_countdown = new OwnProductCountdownManage();
$product_countdown->main();
unset($product_countdown);
?>