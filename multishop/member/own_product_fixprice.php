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
 * FILE_NAME : own_product_fixprice.php
 * 
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Tue Aug 28 15:51:41 CST 2010
 */
// 图片上传session传递
if (isset($_POST["PHPSESSID"]) && $_POST['action'] == 'pic_ajax') {
	session_id($_POST["PHPSESSID"]);
}
require_once("../global.inc.php");

class OwnProductManage extends memberFrameWork{
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
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	var $obj_product_brand;
	/**
	 * 店铺商品类别对象
	 *
	 * @var obj
	 */
	var $obj_shop_product_cate;

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
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建品牌对象
		 */
		if (!is_object($this->obj_product_brand)){
			require_once ("product_brand.class.php");
			$this->obj_product_brand = new ProductBrandClass();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 语言包
		 */
		$this->getlang("product,productsucc");//,productsucc

		switch ($this->_input['action']){
			case "add":
				//判断用户组权限
				CheckPermission::memberGroupPermission('sell',$_SESSION['s_login']['id']);
				//判断发布商品限制
				CheckPermission::outputProductPermission($_SESSION['s_login']['id']);
				//判断发布商品数量限制
				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','to_sale');
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
				$this->output('upload_ext',$upload_ext);//后缀
				$this->_add();
				break;
			case "save":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','to_sale');
				//判断发布商品数量限制
				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
				$this->_save();
				break;
			case "modi":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','to_sale');
				$this->output('PHPSESSID',session_id());
				/**
				 * 图片大小限制 KB 支持格式
				 */
				$this->output('upload_max_size',$this->_configinfo['file']['allowuploadmaxsize']);
				$this->output('upload_type',$this->_configinfo['file']['allowuploadimagetype']);
				$upload_ext = '*.'.implode(';*.',explode(',',trim($this->_configinfo['file']['allowuploadimagetype'],',')));
				$this->output('upload_ext',$upload_ext);//后缀
				$this->_modi();
				break;
			case "update":
				//判断发布商品数量限制
				//CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
				$this->_update();
				break;
			case "ajax_update_count":
				$this->_updateproductcount();
				break;
			case "ajax_update_price":
				$this->_updateproductprice();
				break;
			case "update_count_price":
				$this->_updateproductcountprice();
				break;
			case "del":
				$this->_delproduct();
				break;
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
			case 'operating_succ':
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','to_sale');
				$this->_operating_succ();
				break;
			default:
				exit;
				break;
		}
	}

	/**
	 * 出售商品第一步：选择商品分类
	 *
	 * @param 
	 * @return html
	 */
	function _sellproduct(){
		/**
		 * 语言包
		 */
		$this->getlang("productsell");

		/**
		 * 判断当前会员是否可以发布商品
		 */
		if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
			/**
			 * 取会员信息
			 */
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			$member_array['product_number'] = $member_array['product_number']?$member_array['product_number']:0;
			/**
			 * 取上架商品数量
			 */
			$obj_condition['member'] = $_SESSION['s_login']['id'];
			$product_array = $this->obj_product->getProductList($obj_condition, $page);
			if (count($product_array) >= $member_array['product_number']){
				unset($condition,$member_array);
				$this->redirectPath("error","../member/own_shop_pay.php?action=pay",$this->_lang['langPCanSaleNumberMax']);
			}
		}

		/**
		 * 商品类别
		 */
		if (!file_exists(BasePath.'/cache/ProductClass_show.php')){
			/**
			 * 实例化商品类别类
			 */
			if (!is_object($this->obj_product_cate)){
				require_once("productclass.class.php");
				$this->obj_product_cate = new ProductCategoryClass();
			}
			$this->obj_product_cate->restartClass();
		}
		require_once(BasePath.'/cache/ProductClass_show.php');
		if (is_array($node_cache)){
			$product_top_cate = array();
			foreach ($node_cache as $k => $v){
				/**
				 * 取根目录
				 */
				$tmp = array();
				$tmp['id'] = $v[0];
				$tmp['name'] = $v[2];
				$tmp['is_parent'] = empty($v[6])?'0':'1';
				$product_top_cate[] = $tmp;
				unset($tmp);
			}
		}

		/**
		 * 页面输出
		 */
		$this->output("top_cate", $product_top_cate);
		$this->showpage("own_product.sell");
	}

	/**
	 * 添加商品页面
	 *
	 */
	function _add(){
		/**
		 * 取商品类别内容
		 */
		$product_class_string = $this->_get_product_class_path($this->_input["pc_id"]);
		/**
		 * 取商品属性内容
		 */
		$product_attribute = $this->_get_attribute($this->_input['pc_id']);
		//取支付方式
		if (is_array($this->_configinfo['payment'])) {
			//会员信息
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			//取会员信息,用来验证显示的支付方式
			foreach ($this->_configinfo['payment'] as $k => $v){
				if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
					include_once(BasePath.'/payment/'.$k.'/payment_module.php');
					$class_name = $k.'PaymentMethod';
					$obj_p_module = new $class_name;
					$param_array = $obj_p_module->payment_param();
					//不是线下的，并且在会员信息中有值的
					if ($param_array['type'] != 'offline' && $member_array[$k] != ''){
						$payment_array[$k]['name'] = $param_array['name'];
						//支持的货币种类
						$payment_array[$k]['currency'] = $param_array['currency'];//数组形式
						$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);//数组形式
					} elseif ($param_array['type'] == 'offline') {//是线下的
						$payment_array[$k]['name'] = $param_array['name'];
						//支持的货币种类
						$payment_array[$k]['currency'] = $param_array['currency'];//数组形式
						$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);//数组形式
					}
					//默认为显示的支付方式全部选中
					if ($payment_array[$k]['name'] != ''){
						$payment_array[$k]['check'] = 1;
					}
					$payment_description[] = $param_array;
					//销毁变量
					unset($class_name,$obj_p_module,$param_array);
				}
			}
		}
		if (!is_array($payment_array)){
			$this->redirectPath("error","../member/own_payment.php",$this->_lang['errMPaymentEmpty']);
		}
		//获得店铺宝贝分类
		if ($_SESSION['s_shop']['id'] != ''){
			$shop_product_category = $this->_getshopclass($_SESSION['s_shop']['id']);
		}
		//取货币种类
		$condition_exchange['state'] = 1;
		$exchange_array = $this->obj_exchange->listExchange($condition_exchange,$page);
		if (is_array($exchange_array)){
			foreach ($exchange_array as $k => $v){
				$exchange_array[$k]['display'] = 'block';//前台显示标识
			}
		}
		//控制货币前台显示
		if (is_array($payment_array)){
			$array = array();
			$product_currency = array();
			foreach ($payment_array as $k => $v){
				if ($v['check'] == 1){//选中的支付方式
					if (is_array($v['currency'])){
						foreach ($v['currency'] as $k2 => $v2){
							$array[]= $v2;
						}
					}
				}
				//默认取所有货币为支持的货币
				$product_currency = array_merge($product_currency,$v['currency']);
			}
			$array = array_unique($array);
			sort($array);
			if (is_array($exchange_array)){
				foreach ($exchange_array as $k => $v){
					if (!in_array($v['exchange_name'],$array)){
						$exchange_array[$k]['display'] = 'none';//前台显示标识
					}
				}
				sort($exchange_array);
			}
		}
		//去除重复的货币种类
		$product_currency = @array_unique($product_currency);
		unset($array);
		//商品品牌内容
		$array = Common::getProductBrandCache('');
		$brand_list = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['pb_id'] = $v[0];
					$v['pb_u_id'] = $v[1];
					$v['pb_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$brand_list[] = $v;
				}
			}
		}
		unset($array);

		/**
		 * 页面输出
		 */
		$this->output("config_predeposit", $this->_configinfo['payment']['predeposit']);
		$this->output("payment_description", $payment_description);
		$this->output("exchange_array", $exchange_array);
		$this->output("payment_array", $payment_array);
		$this->output("shop_product_cate_array",   $shop_product_category);
		$this->output("selltype", 1);//一口价
		$this->output("product_attribute", $product_attribute);
		$this->output("product_currency", $product_currency);
		$this->output("brand_list", $brand_list);
		$this->output("product_class_string", $product_class_string);
		$this->output("pc_id", $this->_input['pc_id']);
		$this->showpage("own_product_fixprice.add");
	}

	/**
	 * 保存商品信息
	 *
	 */
	function _save(){
		/**
		 * 验证表单信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["p_name"],"require"=>"true","message"=>$this->_lang['errPSNameEmpty']),
		array("input"=>$this->_input["pc_id"],"require"=>"true","message"=>$this->_lang['errPcidEmpty']),
		array("input"=>$this->_input["p_sell_type"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSSelltype']),
		array("input"=>$this->_input["p_type"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSType']),
		array("input"=>$this->_input["p_storage"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSstorage']),
		array("input"=>$this->_input["p_area_id"],"require"=>"true","message"=>$this->_lang['errPProductAreaIsEmpty']),
		array("input"=>$this->_input["p_transfee_charge"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSTransfee']),
		array("input"=>$this->_input["p_have_invoices"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSInvoices']),
		array("input"=>$this->_input["p_have_warranty"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSWarranty']),
		array("input"=>$this->_input["p_valid_days"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSValiddays']),
		array("input"=>$this->_input["p_auto_publish"],"validator"=>"Integer","message"=>$this->_lang['errPSAutopublish']),
		array("input"=>$this->_input["p_recommended"],"validator"=>"Integer","message"=>$this->_lang['errPSRecommended']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 使用运费模板
			 */
			if ($this->_input['p_transfee_charge'] == '1' && $this->_input['use_postage'] == '1'){
				/**
				 * 取运费模板内容
				 */
				require_once ("postage.class.php");
				$obj_postage = new PostageClass();
				$postage_array = $obj_postage->getOnePostage($this->_input['use_postage_id']);
				if (empty($postage_array)){
					$this->redirectPath("error","",$this->_lang['errPPostageTplIsEmpty']);
				}
				$this->_input["use_postage_id"] = $postage_array['postage_id'];
				$this->_input["use_postage_content"] = serialize(array(
											'postage_ordinary'=>unserialize($postage_array['postage_ordinary']),
											'postage_fast'=>unserialize($postage_array['postage_fast']),
											'postage_ems'=>unserialize($postage_array['postage_ems']),
										)
									);
				unset($obj_postage);
				/**
				 * 标准运费都设置为0
				 */
				$this->_input['p_tf_py'] = '0';
				$this->_input['p_tf_kd'] = '0';
				$this->_input['p_tf_ems'] = '0';
			}
			$this->_input["member_id"] = $_SESSION['s_login']['id'];
			$this->_input["theme_id"] = 0;
			$this->_input["p_point"] = 0;
			$this->_input["p_view_num"] = 0;
			if("" == $this->_input["p_auto_publish"]){
				$this->_input["p_auto_publish"] = 0;
			}
			if("" == $this->_input["p_recommended"]){
				$this->_input["p_recommended"]=0;
			}
			$this->_input["p_state"] = 1;
			$this->_input["p_start_time"] = time();
			$this->_input["p_end_time"] = Common::calculateDate("d",$this->_input["p_valid_days"],time());
			//组合支付方式
			if (is_array($this->_input['txtPayment'])){
				$this->_input['payment'] = '';
				foreach ($this->_input['txtPayment'] as $k => $v){
					$this->_input['p_pay_method'] .= $v.'|';
				}
				$this->_input['p_pay_method'] = trim($this->_input['p_pay_method'],'|');
			}
			if ($this->_input['p_pay_method'] == '' &&  $this->_input['pay_predeposit'] == ''){//如果错误则返回
				$this->redirectPath("error","",$this->_lang['errPayment']);
			}else {
				$this->_input['p_pay_method'] = '|'.$this->_input['p_pay_method'].'|';
			}
			//组合支持交易的货币种类
			if (is_array($this->_input['currency'])){
				$this->_input['p_currency_category'] = '|'.@implode('|',$this->_input['currency']).'|';
			}
			/*生成商品编号*/
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
			$this->_input["p_code"] = md5($product_last_id.$random_string);
			//处理上传图片
			$pic_arr = array();//图片名数组
			for ($i=0;;$i++){
				if(!isset($_FILES['txtPpic_'.$i]['name']) || $_FILES['txtPpic_'.$i]['name'] == ''){
					break;
				}
				$pic_arr[] = $this->_pic_add('txtPpic_'.$i);
			}
			$pic_arr = explode("|||",$this->_input["pichidden"]);
			if (is_array($pic_arr)){
				$pic_value = array();
				$j = 0;
				for ($i=0;$i<count($pic_arr);$i++){
					if ($pic_arr[$i] != ''){
						//$pic_arr[$i] 为缩略图文件名，更改为普通图片缩略图
						$arr = @explode('.',$pic_arr[$i]);
						$arr_two = @explode('_',$arr[0]);
						$pic_value[$j]['p_pic'] = $arr_two[0].'.'.$arr[1];
						$pic_value[$j]['p_code'] = $this->_input["p_code"];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}
			//默认取第一个作为商品列表展示使用的图片，存入商品信息表中
			$this->_input['p_pic'] = $pic_value[0]['p_pic'];
			//预存款
			if($this->_configinfo['payment']['predeposit'] == '1'){//开启状态
				$this->_input['p_predeposit_state'] = ($this->_input['pay_predeposit']=='0')?$this->_input['pay_predeposit']:'1';
			}
			//会员信息
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			//判断是否是推荐商品，如果没有剩余的推荐数量，那么将推荐属性清除
			if ($member_array['recommend_max_count']-$member_array['recommend_product_count'] <= 1){
				$this->_input['p_recommended'] = '0';
			}
			//搜索引擎信息
			$this->_input['p_keywords'] = str_replace('，',',',$this->_input['p_keywords']);
			$this->_input['p_keywords'] = $this->_input['p_keywords']?$this->_input['p_keywords']:$this->_input['p_name'];
			$this->_input['p_description'] = str_replace('，',',',$this->_input['p_description']);
			$this->_input['p_description'] = $this->_input['p_description']?$this->_input['p_description']:$this->_input['p_name'];
			//商品发布时间
			$this->_input['p_add_time'] = time();
			$this->_input['p_update_time'] = time();
			//格式化商品信息入库数组
			$insert_array = array();
			$insert_array['p_name'] = $this->_input['p_name'];
			$insert_array['pc_id'] = $this->_input['pc_id'];
			$insert_array['theme_id'] = $this->_input['theme_id'];
			$insert_array['member_id'] = $this->_input['member_id'];
			$insert_array['p_code'] = $this->_input['p_code'];
			$insert_array['p_price'] = $this->_input['p_price'];
			$insert_array['p_original_price'] = $this->_input['p_original_price'];
			$insert_array['p_point'] = $this->_input['p_point'];
			$insert_array['p_view_num'] = $this->_input['p_view_num'];
			$insert_array['p_start_time'] = $this->_input['p_start_time'];
			$insert_array['p_end_time'] = $this->_input['p_end_time'];
			$insert_array['p_valid_days'] = $this->_input['p_valid_days'];
			$insert_array['p_storage'] = $this->_input['p_storage'];
			$insert_array['p_state'] = $this->_input['p_state'];
			$insert_array['p_pic'] = $this->_input['p_pic'];
			$insert_array['p_intro'] = $this->_input['p_intro'];
			$insert_array['p_add_time'] = $this->_input['p_add_time'];
			$insert_array['p_update_time'] = $this->_input['p_update_time'];
			$insert_array['p_auto_publish'] = $this->_input['p_auto_publish'];
			$insert_array['p_sell_type'] = $this->_input['p_sell_type'];
			$insert_array['p_type'] = $this->_input['p_type'];
			$insert_array['p_transfee_charge'] = $this->_input['p_transfee_charge'];
			$insert_array['p_have_invoices'] = $this->_input['p_have_invoices'];
			$insert_array['p_have_warranty'] = $this->_input['p_have_warranty'];
			$insert_array['p_tf_py'] = $this->_input['p_tf_py'];
			$insert_array['p_tf_kd'] = $this->_input['p_tf_kd'];
			$insert_array['p_tf_ems'] = $this->_input['p_tf_ems'];
			$insert_array['p_recommended'] = $this->_input['p_recommended'];
			$insert_array['p_remark'] = $this->_input['p_remark'];
			$insert_array['p_class_id'] = $this->_input['p_class_id'];
			$insert_array['p_pay_method'] = $this->_input['p_pay_method'];
			$insert_array['p_currency_category'] = $this->_input['p_currency_category'];
			$insert_array['p_predeposit_state'] = $this->_input['p_predeposit_state'];
			$insert_array['p_area_id'] = $this->_input['p_area_id'];
			$insert_array['p_ifnopub'] = $this->_input['p_ifnopub'];
			$insert_array['p_pb_id'] = $this->_input['p_pb_id'];
			$insert_array['p_genuine'] = $this->_input['p_genuine'];
			$insert_array['p_7day_return'] = $this->_input['p_7day_return'];
			$insert_array['p_keywords'] = $this->_input['p_keywords'];
			$insert_array['p_description'] = $this->_input['p_description'];
			$insert_array['use_postage'] = $this->_input['use_postage'];
			$insert_array['use_postage_content'] = $this->_input['use_postage_content'];
			$insert_array['use_postage_id'] = $this->_input['use_postage_id'];

			/**
			 * 商品信息入库
			 */
			$result = $this->obj_product->addProduct($insert_array);
			unset($insert_array);

			/**
			 * 商品图片入库
			 */
			if (is_array($pic_value)){
				for ($i=0;$i<count($pic_value);$i++){
					$this->obj_product->addProductPic($pic_value[$i]);
				}
				unset($pic_value);
			}

			/**
		 	 * 商品属性及属性内容ID处理
		 	 */
			if(is_array($this->_input["attribute_content"])){
				$i = 0;
				foreach ($this->_input["attribute_content"] as $k => $v){
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
					$result_attribute = $this->obj_product->addProductAttribute($this->_input["p_code"], $insert_ac);
				}
			}

			/**
			 * 更新商品发布数量的统计信息
			 */
			if($this->_input["p_state"] == "1"){
				$update_product_statis = $this->obj_product->updateProductStatistics($this->_input["member_id"],'sell');
			}

			/**
			 * 生成静态页面
			 */
			$html = $this->make_product_html($this->_input["p_code"]);
			if(!$html){
				echo "faild to make html file";exit;
			}
			/**
			 * 返回路径
			 */
			$url = urlencode("../home/product_fixprice.php?action=view&p_code=".$this->_input["p_code"]);
			/**
			 * 成功发布商品
			 */
			CreditsClass::saveCreditsLog('succ_product_put',$_SESSION["s_login"]['id']);
			/**
			 * 返回链接
			 */
			$return_url = "own_product_fixprice.php?action=operating_succ&url={$url}&slPCId={$this->_input['pc_id']}";
			/**
			 * 页面输出
			 */
			@header("Location: ".$return_url);
			exit;
		}
	}

	/**
	 * 商品操作成功
	 *
	 */
	function _operating_succ() {
		$show_page = "own_product.succ";
		/**
		 * 页面输出
		 */
		$this->output('slPCId',$this->_input['slPCId']);
		$this->output('url',$this->_input['url']);
		$this->showpage($show_page);
	}

	/**
	 * 生成静态文件
	 *
	 */
	function make_product_html($p_id){
		/**
		 * 创建商品静态页面对象
		 */
		if (!is_object($obj_html_product)){
			require_once("../home/html.product.php");
			$obj_html_product = new HtmlProductManage();
		}
		$result = $obj_html_product->_make_product_html($p_id);
		return $result;
	}

	/**
	 * 修改产品信息
	 *
	 */
	function _modi(){
		//验证会员和商品是否一致
		$this->checkRightMemberToProduct($this->_input["p_code"]);

		/**
		 * 取商品信息
		 */
		$product_array = $this->obj_product->getProductRow($this->_input["p_code"]);

		if ($product_array['p_sell_type'] != '1'){
			/**
			 * 实例化商品订单类
			 */
			if (!is_object($this->obj_product_order)){
				require_once("order.class.php");
				$this->obj_product_order = new ProductOrderClass();
			}
			$condition['p_code'] = $this->_input["p_code"];
			$condition['search_time'] = 1;
			$condition['start_time'] = $product_array['p_start_time'];
			$condition['end_time'] = $product_array['p_end_time'];
			$order = $this->obj_product_order->getProductOrderList($condition,$page);
			unset($condition,$order);
		}
		/**
		 * 取商品类别内容
		 */
		if ($this->_input['pc_id'] != '') {
			$pcid = $this->_input['pc_id'];
			$product_class_string = $this->_get_product_class_path($pcid);
		} else {
			$pcid = $product_array['pc_id'];
			$product_class_string = $this->_get_product_class_path($pcid);
		}

		/**
		 * 商品属性处理
		 */
		require_once("attribute.class.php");
		$obj_product_attribute = new AttributeClass();
		require_once("attribute_content.class.php");
		$obj_product_attribute_content = new AttributeContentClass();
		//取商品属性选中项
		$attribute_condition_str = " and p_id = '" . $this->_input["p_code"] . "'";
		$product_have_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $page);
		//将商品属性id组成一个数组
		if(is_array($product_have_attribute)){
			foreach ($product_have_attribute as $key => $value){
				$ac_content = explode(',', $value[pac_content]);
				foreach ($ac_content as $k => $v){
					$pac_attribute[] = $v;
				}
			}
		}
		//取属性
		$product_attribute = $obj_product_attribute->getParentAttributeContent($pcid);
		if (!empty($product_attribute)) {
			//去除无内容的属性
			foreach ($product_attribute as $k => $v){
				if (count($product_attribute[$k]['content']) > 0){
					$content_sign = 1;
					//判断选中
					foreach ($product_attribute[$k]['content'] as $k2 => $v2){
						if(is_array($pac_attribute) && in_array($v2['ac_id'], $pac_attribute)){
							$product_attribute[$k]['content'][$k2]['ischecked'] = 1;
						}
					}
				}else {
					unset($product_attribute[$k]);
				}
			}
			unset($content_sign);
		}
		//处理商品支持的货币种类
		if (strstr($product_array['p_currency_category'],'|')) {
			$product_currency = @explode('|',trim($product_array['p_currency_category'],'|'));
		}else {
			$product_currency = $product_array['p_currency_category'];
		}
		//取货币种类
		$condition_exchange['state'] = 1;
		$exchange_array = $this->obj_exchange->listExchange($condition_exchange,$page);
		if (is_array($exchange_array)){
			foreach ($exchange_array as $k => $v){
				$exchange_array[$k]['display'] = 'block';//前台显示标识
			}
		}
		//取支付方式
		if (is_array($this->_configinfo['payment'])){
			//取会员信息,用来验证显示的支付方式
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*',$operate_genre='more');
			foreach ($this->_configinfo['payment'] as $k => $v){
				if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
					include_once(BasePath.'/payment/'.$k.'/payment_module.php');
					$class_name = $k.'PaymentMethod';
					$obj_p_module = new $class_name;
					$param_array = $obj_p_module->payment_param();
					if ($param_array['type'] != 'offline' && $member_array[$k] != ''){//不是线下的，并且在会员信息中有值的
						$payment_array[$k]['name'] = $param_array['name'];
						//支持的货币种类
						$payment_array[$k]['currency'] = $param_array['currency'];//数组形式
						$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);//数组形式
					}elseif ($param_array['type'] == 'offline'){//是线下的 并且是开启状态的（值为1）
						$payment_array[$k]['name'] = $param_array['name'];
						//支持的货币种类
						$payment_array[$k]['currency'] = $param_array['currency'];//数组形式
						$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);//数组形式
					}
					//判断是否选中
					if (strstr($product_array['p_pay_method'],'|'.$k.'|') && $payment_array[$k]['name'] != ''){
						$payment_array[$k]['check'] = 1;
					}
					//支付说明是使用的数组
					$payment_description[] = $param_array;
					unset($class_name,$obj_p_module,$param_array);
				}
			}
		}
		//获得店铺宝贝分类
		if ($_SESSION['s_shop']['id'] != ''){
			$shop_product_category = $this->_getshopclass($_SESSION['s_shop']['id']);
		}
		//控制货币前台显示
		if (is_array($payment_array)){
			$array = array();
			foreach ($payment_array as $k => $v){
				if ($v['check'] == 1){//选中的支付方式
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
						$exchange_array[$k]['display'] = 'none';//前台显示标识
					}
				}
				sort($exchange_array);
			}
		}
		unset($array);
		//图片列表	商品编辑页调用小图
		$condition_pic['p_code'] = $this->_input["p_code"];
		$array = $this->obj_product->getProductPic($condition_pic,$page);
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
		//商品品牌内容
		$array = Common::getProductBrandCache('');
		$brand_list = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['pb_id'] = $v[0];
					$v['pb_u_id'] = $v[1];
					$v['pb_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$brand_list[] = $v;
				}
			}
		}
		unset($array);
		//取品牌内容
		$sel_brand = array();
		if (!empty($product_array['p_pb_id']) && $product_array['p_pb_id'] != '0'){
			$sel_brand = $this->obj_product_brand->getProductBrandPathList($product_array['p_pb_id']);
		}
		//价格取整
		$product_array['p_price'] = intval($product_array['p_price'])==$product_array['p_price']?intval($product_array['p_price']):$product_array['p_price'];
		$product_array['p_group_price'] = intval($product_array['p_group_price'])==$product_array['p_group_price']?intval($product_array['p_group_price']):$product_array['p_group_price'];
		$product_array['p_tf_py'] = intval($product_array['p_tf_py'])==$product_array['p_tf_py']?intval($product_array['p_tf_py']):$product_array['p_tf_py'];
		$product_array['p_tf_kd'] = intval($product_array['p_tf_kd'])==$product_array['p_tf_kd']?intval($product_array['p_tf_kd']):$product_array['p_tf_kd'];
		$product_array['p_tf_ems'] = intval($product_array['p_tf_ems'])==$product_array['p_tf_ems']?intval($product_array['p_tf_ems']):$product_array['p_tf_ems'];

		/**
		 * 运费模板
		 */
		if ($product_array['use_postage'] == '1'){
			/**
			 * 取运费信息
			 */
			require_once ("postage.class.php");
			$obj_postage = new PostageClass();
			$postage_array = $obj_postage->getOnePostage($product_array['use_postage_id']);
			unset($obj_postage);
		}

		/**
		 * 页面输出
		 */
		$this->output("postage_array", $postage_array);
		$this->output('pc_id', $this->_input['pc_id']);
		$this->output("config_predeposit", $this->_configinfo['payment']['predeposit']);
		$this->output("pic_array", $pic_array);
		$this->output("pic_num", count($pic_array));//图片数量
		$this->output("pic_line", $pic_line);
		$this->output("payment_description", $payment_description);
		$this->output("shop_product_cate_array", $shop_product_category);
		$this->output("exchange_array", $exchange_array);
		$this->output("product_currency", $product_currency);
		$this->output("payment_array", $payment_array);
		$this->output("selltype", $product_array['p_sell_type']);
		$this->output("site_url", $this->_configinfo['websit']['site_url']);
		$this->output("product_array", $product_array);
		$this->output("product_attribute", $product_attribute);
		$this->output("product_have_attribute", $pac_attribute);
		$this->output("sel_brand", $sel_brand);
		$this->output("brand_list", $brand_list);
		$this->output("product_class_string", $product_class_string);
		$this->showpage("own_product_fixprice.add");
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
		//得到店铺宝贝分类
		$condition_shop_product_cate['shop_id'] = $shop_id;
		$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
		$shop_product_category = $this->obj_shop_product_cate->getCategory($condition_shop_product_cate,$page);
		//整理数组为多级
		$shop_product_category = $this->obj_shop_product_cate->_makeCategoryArray($shop_product_category);
		return 	$shop_product_category;
	}

	/**
	 * 更新产品信息
	 *
	 */
	function _update(){
		/**
		 * 验证表单信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["p_name"],"require"=>"true","message"=>$this->_lang['errPSNameEmpty']),
		array("input"=>$this->_input["pc_id"],"require"=>"true","message"=>$this->_lang['errPcidEmpty']),
		array("input"=>$this->_input["p_sell_type"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSSelltype']),
		array("input"=>$this->_input["p_type"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSType']),
		array("input"=>$this->_input["p_storage"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSstorage']),
		array("input"=>$this->_input["p_area_id"],"require"=>"true","message"=>$this->_lang['errPProductAreaIsEmpty']),
		array("input"=>$this->_input["p_transfee_charge"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSTransfee']),
		array("input"=>$this->_input["p_have_invoices"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSInvoices']),
		array("input"=>$this->_input["p_have_warranty"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSWarranty']),
		array("input"=>$this->_input["p_valid_days"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSValiddays']),
		array("input"=>$this->_input["p_auto_publish"],"validator"=>"Integer","message"=>$this->_lang['errPSAutopublish']),
		array("input"=>$this->_input["p_recommended"],"validator"=>"Integer","message"=>$this->_lang['errPSRecommended']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			//取原来商品的信息
			$old_product = $this->obj_product->getProductRow($this->_input['p_code']);
			//验证商品和会员是否一致
			$this->checkRightMemberToProduct($this->_input['p_code']);
			/**
			 * 使用运费模板
			 */
			if ($this->_input['p_transfee_charge'] == '1' && $this->_input['use_postage'] == '1'){
				/**
				 * 取运费模板内容
				 */
				require_once ("postage.class.php");
				$obj_postage = new PostageClass();
				$postage_array = $obj_postage->getOnePostage($this->_input['use_postage_id']);
				if (empty($postage_array)){
					$this->redirectPath("error","",$this->_lang['errPPostageTplIsEmpty']);
				}
				$this->_input["use_postage_id"] = $postage_array['postage_id'];
				$this->_input["use_postage_content"] = serialize(array(
											'postage_ordinary'=>unserialize($postage_array['postage_ordinary']),
											'postage_fast'=>unserialize($postage_array['postage_fast']),
											'postage_ems'=>unserialize($postage_array['postage_ems']),
										)
									);
				unset($obj_postage);
				/**
				 * 标准运费都设置为0
				 */
				$this->_input['p_tf_py'] = '0';
				$this->_input['p_tf_kd'] = '0';
				$this->_input['p_tf_ems'] = '0';
			}
			//组合支付方式
			if (is_array($this->_input['txtPayment'])){
				$this->_input['payment'] = '';
				foreach ($this->_input['txtPayment'] as $k => $v){
					$this->_input['p_pay_method'] .= $v.'|';
				}
				$this->_input['p_pay_method'] = trim($this->_input['p_pay_method'],'|');
			}
			if ($this->_input['p_pay_method'] == '' &&  $this->_input['pay_predeposit'] == ''){//如果错误则返回
				$this->redirectPath("error","",$this->_lang['errPayment']);
			}else {
				$this->_input['p_pay_method'] = '|'.$this->_input['p_pay_method'].'|';
			}
			//组合支持交易的货币种类
			if (is_array($this->_input['currency'])){
				$this->_input['p_currency_category'] = '|'.@implode('|',$this->_input['currency']).'|';
			}
			$this->_input["member_id"] = $_SESSION['s_login']['id'];
			$this->_input["theme_id"] = 0;
			$this->_input["p_point"] = 0;
			if("" == $this->_input["p_auto_publish"]){
				$this->_input["p_auto_publish"] = 0;
			}
			if("" == $this->_input["p_recommended"]){
				$this->_input["p_recommended"]=0;
			}
			if("2" == $this->_input["radioSelltype"]){
				$this->_input["txtPprice"] = $this->_input["txtPoldprice"];
			}
			//处理上传图片
			$pic_arr = array();//图片名数组
			for ($i=0;;$i++){
				if(!isset($_FILES['txtPpic_'.$i]['name']) || $_FILES['txtPpic_'.$i]['name'] == ''){
					break;
				}
				$pic_arr[] = $this->_pic_add('txtPpic_'.$i);
			}
			$pic_arr=explode("|||",$this->_input["pichidden"]);
			if (is_array($pic_arr)){
				$pic_value = array();
				$j = 0;
				for ($i=0;$i<count($pic_arr);$i++){
					if ($pic_arr[$i] != ''){
						$arr = @explode('.',$pic_arr[$i]);
						$arr_two = @explode('_',$arr[0]);
						$pic_value[$j]['p_pic'] = $arr_two[0].'.'.$arr[1];
						$pic_value[$j]['p_code'] = $this->_input['p_code'];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}
			//默认取第一个作为商品列表展示使用的图片，存入商品信息表中
			if ($pic_value[0]['p_pic'] != ''){
				$this->_input['p_pic'] = $pic_value[0]['p_pic'];
			}
			//预存款
			if($this->_configinfo['payment']['predeposit'] == '1'){//开启状态
				$this->_input['p_predeposit_state'] = ($this->_input['pay_predeposit']=='0')?$this->_input['pay_predeposit']:'1';
			}
			//会员信息
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			//判断是否是推荐商品，如果没有剩余的推荐数量，那么将推荐属性清除
			if ($member_array['recommend_max_count']-$member_array['recommend_product_count'] <= 1){
				$this->_input['p_recommended'] = '0';
			}
			//搜索引擎信息
			$this->_input['p_keywords'] = str_replace('，',',',$this->_input['p_keywords']);
			$this->_input['p_keywords'] = $this->_input['p_keywords']?$this->_input['p_keywords']:$this->_input['p_name'];
			$this->_input['p_description'] = str_replace('，',',',$this->_input['p_description']);
			$this->_input['p_description'] = $this->_input['p_description']?$this->_input['p_description']:$this->_input['p_name'];
			//商品更新时间
			$this->_input['p_update_time'] = time();
			//格式化商品信息数组
			$insert_array = array();
			$insert_array['p_name'] = $this->_input['p_name'];
			$insert_array['pc_id'] = $this->_input['pc_id'];
			$insert_array['theme_id'] = $this->_input['theme_id'];
			$insert_array['member_id'] = $this->_input['member_id'];
			$insert_array['p_code'] = $this->_input['p_code'];
			$insert_array['p_price'] = $this->_input['p_price'];
			$insert_array['p_original_price'] = $this->_input['p_original_price'];
			$insert_array['p_point'] = $this->_input['p_point'];
			$insert_array['p_view_num'] = $this->_input['p_view_num'];
			$insert_array['p_start_time'] = $this->_input['p_start_time'];
			$insert_array['p_end_time'] = $this->_input['p_end_time'];
			$insert_array['p_valid_days'] = $this->_input['p_valid_days'];
			$insert_array['p_storage'] = $this->_input['p_storage'];
			$insert_array['p_state'] = $this->_input['p_state'];
			$insert_array['p_pic'] = $this->_input['p_pic'];
			$insert_array['p_intro'] = $this->_input['p_intro'];
			$insert_array['p_update_time'] = $this->_input['p_update_time'];
			$insert_array['p_auto_publish'] = $this->_input['p_auto_publish'];
			$insert_array['p_type'] = $this->_input['p_type'];
			$insert_array['p_transfee_charge'] = $this->_input['p_transfee_charge'];
			$insert_array['p_have_invoices'] = $this->_input['p_have_invoices'];
			$insert_array['p_have_warranty'] = $this->_input['p_have_warranty'];
			$insert_array['p_tf_py'] = $this->_input['p_tf_py'];
			$insert_array['p_tf_kd'] = $this->_input['p_tf_kd'];
			$insert_array['p_tf_ems'] = $this->_input['p_tf_ems'];
			$insert_array['p_recommended'] = $this->_input['p_recommended'];
			$insert_array['p_remark'] = $this->_input['p_remark'];
			$insert_array['p_class_id'] = $this->_input['p_class_id'];
			$insert_array['p_pay_method'] = $this->_input['p_pay_method'];
			$insert_array['p_currency_category'] = $this->_input['p_currency_category'];
			$insert_array['p_predeposit_state'] = $this->_input['p_predeposit_state'];
			$insert_array['p_area_id'] = $this->_input['p_area_id'];
			$insert_array['p_pb_id'] = $this->_input['p_pb_id'];
			$insert_array['p_genuine'] = $this->_input['p_genuine'];
			$insert_array['p_7day_return'] = $this->_input['p_7day_return'];
			$insert_array['p_keywords'] = $this->_input['p_keywords'];
			$insert_array['p_description'] = $this->_input['p_description'];
			$insert_array['use_postage'] = $this->_input['use_postage'];
			$insert_array['use_postage_content'] = $this->_input['use_postage_content'];
			$insert_array['use_postage_id'] = $this->_input['use_postage_id'];
			/**
			 * 商品入库
			 */
			$result = $this->obj_product->updateProduct($insert_array);
			unset($insert_array);
			//图片入库
			if (is_array($pic_value)){
				for ($i=0;$i<count($pic_value);$i++){
					$this->obj_product->addProductPic($pic_value[$i]);
				}
				unset($pic_value);
			}
			/**
		 	 * 商品属性及属性内容ID处理
		 	 */
			if(is_array($this->_input["attribute_content"])){
				$i = 0;
				foreach ($this->_input["attribute_content"] as $k => $v){
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
					$result_attribute = $this->obj_product->updateProductAttribute($this->_input["p_code"], $insert_ac);
				}
			}
			/**
			 * 更新商品发布数量的统计信息
			 */
			$update_product_statis = $this->obj_product->updateProductStatistics($this->_input["member_id"],'sell');

			/*删除原来旧的静态文件*/
			$old_file = "../html/user/".$old_product['pc_id']."/item_detail-".$old_product['p_code'].'.html';
			if (file_exists($old_file)){
				@unlink($old_file);
			}
			/**
			 * 生成静态页面
			 */
			$html = $this->make_product_html($this->_input["p_code"]);
			if(!$html){
				$this->redirectPath('error','','faild to make html file');
			}
			/**
			 * 取商品新信息
			 */
			$product_row = $this->obj_product->getProductRow($this->_input["p_code"]);
			if ($this->_configinfo['productinfo']['ifhtml'] == '1'){
				$url = "./html/user/".$product_row['pc_id']."/item_detail-".$product_row['p_code'].'.html';
			}else {
				$url = "./home/product_fixprice.php?action=view&p_code=".$product_row['p_code'];
			}
			$this->redirectPath("succ",$url,$this->_lang['langPSMerchandiseInfoAmendOk']);
		}
	}
	/**
	 * 更新商品数量
	 *
	 */
	function _updateproductcount(){
		/**
		 * 验证提交信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductMUpdateCountFail']),
		array("input"=>$this->_input["p_storage"],"require"=>"true","message"=>$this->_lang['errProductMUpdateCountFail']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			echo $error;
		}else{
			$update_array = array();
			$update_array['p_code'] = $this->_input['p_code'];
			$update_array['p_storage'] = $this->_input['p_storage'];
			$result = $this->obj_product->updateProductFixCount($update_array);
			$html   = $this->make_product_html($update_array['p_code']);
			unset($update_array);
			if(!$result || !$html){
				echo $this->_lang['errProductMUpdateCountFail'];
			}
			echo $this->_lang['langProductMUpdateCountOk'];
		}
	}
	/**
	 * 更新商品价格
	 * 
	 */
	function _updateproductprice(){
		/**
		 * 验证提交信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductMUpdateCountFail']),
		array("input"=>$this->_input["p_price"],"require"=>"true","message"=>$this->_lang['errProductMUpdatePriceFail']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			echo $error;
		}else{
			$update_array = array();
			$update_array['p_code'] = $this->_input['p_code'];
			$update_array['p_price'] = $this->_input['p_price'];
			$result = $this->obj_product->updateProductFixPrice($update_array);
			$html   = $this->make_product_html($update_array['p_code']);
			unset($update_array);
			if(!$result || !$html){
				echo $this->_lang['errProductMUpdatePriceFail'];
			}
			echo $this->_lang['langProductMUpdatePriceOk'];
		}
	}
	/**
	 * 更新商品数量和价格
	 * 
	 */
	function _updateproductcountprice(){
		/**
		 * 验证提交信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['errPSNotSelectBaby']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			if (is_array($this->_input['chboxPid'])) {
				foreach ($this->_input['chboxPid'] as $p_code) {
					$update_array = array();
					$update_array['p_code'] = $p_code;
					$update_array['p_price'] = $this->_input['p_price'][$p_code];
					$result = $this->obj_product->updateProductFixPrice($update_array);
					if(!$result){
						$this->redirectPath("error","",$this->_lang['errProductMUpdateCountFail']);
					}
					unset($update_array);
					$update_array = array();
					$update_array['p_code'] = $p_code;
					$update_array['p_storage'] = $this->_input['p_storage'][$p_code];
					$result = $this->obj_product->updateProductFixCount($update_array);
					$html   = $this->make_product_html($update_array['p_code']);
					if(!$result || !$html){
						$this->redirectPath("error","",$this->_lang['errProductMUpdatePriceFail']);
					}
					unset($update_array);
				}
			} else {
				$this->redirectPath("error","",$this->_lang['langCOperatorLost']);
			}
			$this->redirectPath("succ","",$this->_lang['langCOperateSucc']);
		}
	}
	/**
	 * 更改商品订单状态
	 *
	 * @param int $state 0:已成交 1:已支付 2:已发货 3:已收货 4:已好评
	 */
	function _updateproductorderstate($state){
		/**
		 * 验证提交信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtSPcode"],"require"=>"true","message"=>$this->_lang['errPSCodeEmpty']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			$this->_input["txtSPstate"] = $state;
			$result = $this->obj_product->updateProductOrderState($this->_input);
			$this->redirectPath("succ","member/own_product_list.php?action=list",$this->_lang['errPDelOk']);
		}
	}
	/**
	 * 删除商品
	 *
	 */
	function _delproduct(){
		if (is_array($this->_input['chboxPid'])){
			foreach ($this->_input['chboxPid'] as $value){
				$this->objvalidate->setValidate(array("input"=>$value,"require"=>"true","message"=>$this->_lang['errPDelFail']));
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
					}else {//允许删除
						$this->checkRightMemberToProduct($value);
						//判断商品是否存在属性
						$att = $this->obj_product->getProductAttribute(" and p_id = '" . $value . "'", $page);
						if (!empty($att)) {
							$have_attribute = 1;
						}
					}
				}
			}
			$result = $this->obj_product->delProduct($this->_input['chboxPid']);
			if($result){
				//删除product_attribute表中对应信息
				if ($have_attribute == 1) {
					$this->obj_product->delProductAttribute($this->_input['chboxPid']);
					unset($have_attribute);
				}
				//更新会员的发布商品数量
				$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'],'sell');
				//返回链接的action标识
				$this->_input['list_type'] = $this->_input['list_type']?$this->_input['list_type']:'list';
				$this->redirectPath("succ","member/own_product_fixprice.php?action=".$this->_input['list_type'],$this->_lang['errPDelOk']);
			}else {
				$this->redirectPath("error","",$this->_lang['errPDelFail']);
			}
		}
	}
	/**
	 * 一口价的商品列表页面
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
		$obj_condition['sell_type'] = 1;
		$obj_condition['keygenre'] = 1;
		$obj_condition['member'] = $_SESSION['s_login']['id'];
		if($state == "2"){
			$obj_condition['recommended'] = 1;
			$state = 1;
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
		$obj_condition['state'] = $state;
		if ($this->_input['sold_num'] != ""){
			$obj_condition['sorttype'] = $this->_input['sold_num'];
		}
		$this->obj_page->pagebarnum(20);
		$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');

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
			 * 一口价商品,商品链接/修改链接
			 */
			$product_array[$i]['product_url'] = "/home/product_fixprice.php?action=view&p_code=".$product_array[$i]['p_code'];
			$product_array[$i]['modi_url'] = "own_product_fixprice.php?action=modi&p_code=".$product_array[$i]['p_code'];
		}

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
			$this->showpage("own_product_fixprice.list_instock");
		}
		/**
		 * 出售中的商品
		 */
		if ($this->_input['action'] == 'list'){
			$this->showpage("own_product_fixprice.manage");
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
					$update_array['txtPcount'] = $this->_input['txtPstorage'][$pcode] > 0 ? $this->_input['txtPstorage'][$pcode] : 1;
				}
			}
			//更新商品发布数量的统计信息
			$update_product_statis = $this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'sell');
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
					$this->redirectPath("succ","member/own_product_fixprice.php?action=list", $this->_lang['errPSCommendExceedShopwindowNum']);
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
					$info = $this->_lang['langPScommendedIsFail'];
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
				$info = $this->_lang['langPScommendedIsFail'];
			}

			$this->redirectPath('error','',$info);
		}
	}

	/**
	 * 检查会员是否和商品所属会员相同
	 */
	function checkRightMemberToProduct($p_id){
		if ($p_id != ''){
			$product_array = $this->obj_product->getProductRow($p_id);
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
	 * 商品图片上传
	 */
	function _pic_add($input_file_name){
		if (!is_object($this->obj_upload)){
			require_once("uploadfile.class.php");
			$this->obj_upload = new UploadFile();
			$this->obj_upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
		}
		//上传商品图片
		$filename = $this->obj_upload->upfile($input_file_name);
		/*按比例生成图片*/
		$cut = $this->_configinfo['productinfo']['imageresize_ifcut'];
		if ($filename !== false){
			//加水印
			if ($this->_configinfo['gdimage']['wm_image_sign'] == 1 && file_exists(BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'])) {
				//图片名
				$return_name = $filename["getfilename"];
				require_once ("gdimage.class.php");
				$img = new GDImage();
				$img->wm_image_transition = $this->_configinfo['gdimage']['wm_image_transition'];//透明度
				$img->wm_image_pos = $this->_configinfo['gdimage']['wm_image_pos'];//位置
				$img->save_file = BasePath.'/'.$return_name;//返回文件名称
				$img->wm_image_name = BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'];//水印图片
				$img->create(BasePath.'/'.$return_name);
				unset($img);
			}
			include_once ('resizeImage.class.php');
			//判断图片大小
			$image_info = @getimagesize($filename['filename']);
			$width = $image_info[0];
			$height = $image_info[1];
			if ($width > $height){//用宽度
				$pic_param = $width;
				$small_percent = number_format($pic_param/$this->_configinfo['productinfo']['imageresize_width'],2);
			}else {//用高度
				$pic_param = $height;
				$small_percent = number_format($pic_param/$this->_configinfo['productinfo']['imageresize_height'],2);
			}
			//小图
			if (intval($small_percent) > 1){
				$obj_small = new resizeImage($filename['filename'],intval($width/$small_percent),intval($height/$small_percent),$cut);
			}elseif (intval($small_percent) == 1){
				//取与标准尺寸的差值
				$pic_percent = $small_percent;
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$small_width = intval($width*($pic_percent));
				$small_height = intval($height*($pic_percent));
				$obj_small = new resizeImage($filename['filename'],$small_width,$small_height,$cut);
			}else {
				$obj_small = new resizeImage($filename['filename'],$width,$height,$cut);
			}
			//中图
			if (intval($pic_param/192) > 1){
				$obj_mid = new resizeImage($filename['filename'],intval($width/($pic_param/192)),intval($height/($pic_param/192)),$cut,"_mid.");
			}elseif (intval($pic_param/192) == 1){
				//取与标准尺寸的差值
				$pic_percent = number_format($pic_param/192,2);
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$mid_width = intval($width*($pic_percent));
				$mid_height = intval($height*($pic_percent));
				$obj_mid = new resizeImage($filename['filename'],$mid_width,$mid_height,$cut,"_mid.");
			}else {
				$obj_mid = new resizeImage($filename['filename'],$width,$height,$cut,"_mid.");
			}
			//大图
			if (intval($pic_param/288) > 1){
				$obj_big = new resizeImage($filename['filename'],intval($width/($pic_param/288)),intval($height/($pic_param/288)),$cut,"_big.");
			}elseif (intval($pic_param/288) == 1){
				//取与标准尺寸的差值
				$pic_percent = number_format($pic_param/288,2);
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$big_width = intval($width*($pic_percent));
				$big_height = intval($height*($pic_percent));
				$obj_big = new resizeImage($filename['filename'],$big_width,$big_height,$cut,"_big.");
			}else {
				$obj_big = new resizeImage($filename['filename'],$width,$height,$cut,"_big.");
			}
			unset($obj_small,$obj_mid,$obj_big);
		}
		return $filename["getfilename"];
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
		//商品属性
		require_once("attribute.class.php");
		$obj_product_attribute = new AttributeClass();
		require_once("attribute_content.class.php");
		$obj_product_attribute_content = new AttributeContentClass();

		//取商品属性及属性内容
		$product_attribute = $obj_product_attribute->getParentAttributeContent($pc_id);
		if (!empty($product_attribute)) {
			//去除无内容的属性
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
			$this->redirectPath("error","../member/own_product_fixprice.php?action=sell&p_code=".$this->_input['p_code'],$this->_lang['errPClassIdIsNotExist']);
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
			$product_class_string = $temp[2];
			/**
			 * 判断是否具有父类，如果有，那么递归获取
			 */
			if ($v[1] != '0'){
				$parent_class_string = $this->_recursive_product_class($pc_array,$v[1]);
			}
			return trim($parent_class_string.'>>'.$product_class_string, '>>');
		}
	}
}

$product_manage = new OwnProductManage();
$product_manage->main();
unset($product_manage);
?>