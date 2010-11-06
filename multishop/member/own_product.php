<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_product.php   FILE_PATH : \multishop\member\own_product.php
 * ....商品管理功能
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Tue Aug 28 15:51:41 CST 2007
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
	 * 拍卖商品出价对象
	 *
	 * @var obj
	 */
	var $obj_product_bid;
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
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
	/**
	 * X整合类
	 *
	 * @var obj
	 */
	var $obj_x_class;

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
		 * 网站提醒操作
		 */
		if (!is_object($this->obj_remind)){
			require_once('remind.class.php');
			$this->obj_remind = new RemindClass();
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
		 * 语言包
		 */
		$this->getlang("product");//,productsucc
//		/**
//		 * 整合X语言包
//		 */
//		$this->getlang('own_product_x');
//		/**
//		 * 创建X整合对象
//		 */
//		if (!is_object($this->obj_x_class)){
//			require_once ("x.class.php");
//			$this->obj_x_class = new XClass();
//		}

		switch ($this->_input['action']){
			case "sell":
				//判断用户组权限
				CheckPermission::memberGroupPermission('sell',$_SESSION['s_login']['id']);
				//判断发布商品限制
				CheckPermission::outputProductPermission($_SESSION['s_login']['id']);
				//判断发布商品数量限制
				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
//				@header('location: own_product.php?action=add');
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','to_sale');
				$this->_sellproduct();
				break;
//			case "add":
//				//判断用户组权限
//				CheckPermission::memberGroupPermission('sell',$_SESSION['s_login']['id']);
//				//判断发布商品限制
//				CheckPermission::outputProductPermission($_SESSION['s_login']['id']);
//				//判断发布商品数量限制
//				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
//				/**
//				 * 菜单输出
//				 */
//				$this->memberMenu('seller','my_seller','to_sale');
//				/**
//				 * 用于图片的多文件上传flash验证身份传递
//				 */
//				$this->output('PHPSESSID',session_id());
//				/**
//				 * 图片大小限制 KB 支持格式
//				 */
//				$this->output('upload_max_size',$this->_configinfo['file']['allowuploadmaxsize']);
//				$this->output('upload_type',$this->_configinfo['file']['allowuploadimagetype']);
//				$upload_ext = '*.'.implode(';*.',explode(',',trim($this->_configinfo['file']['allowuploadimagetype'],',')));
//				$this->output('upload_ext',$upload_ext);//后缀
//				$this->_addproduct();
//				break;
//			case "save":
//				/**
//				 * 菜单输出
//				 */
//				$this->memberMenu('seller','my_seller','to_sale');
//				//判断发布商品数量限制
//				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
//				$this->_saveproduct();
//				break;
//			case "modi":
//				/**
//				 * 菜单输出
//				 */
//				$this->memberMenu('seller','my_seller','to_sale');
//				$this->output('PHPSESSID',session_id());
//				/**
//				 * 图片大小限制 KB 支持格式
//				 */
//				$this->output('upload_max_size',$this->_configinfo['file']['allowuploadmaxsize']);
//				$this->output('upload_type',$this->_configinfo['file']['allowuploadimagetype']);
//				$upload_ext = '*.'.implode(';*.',explode(',',trim($this->_configinfo['file']['allowuploadimagetype'],',')));
//				$this->output('upload_ext',$upload_ext);//后缀
//				$this->_modiproduct();
//				break;
//			case "update":
//				//判断发布商品数量限制
//				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
//				$this->_updateproduct();
//				break;
//			case "del":
//				$this->_delproduct();
//				break;
//			case "update_count":
//				$this->_updateproductcount();
//				break;
			case "pic_add":
				$this->_pic_add();
				break;
			case "pic_ajax":
				$this->_pic_ajax("fileData");
				break;
			case "pic_del":
				$this->_pic_del();
				break;
//			case 'ajax_get_attribute':
//				$this->_ajax_get_attribute();
//				break;
//			case 'operating_succ':
//				/**
//				 * 菜单输出
//				 */
//				$this->memberMenu('seller','my_seller','to_sale');
//				$this->_operating_succ();
//				break;
//			case 'sel_forum':
//				/**
//				 * 菜单输出
//				 */
//				$this->memberMenu('seller','my_seller','to_sale');
//				$this->_sel_forum();
//				break;
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
		$this->output("p_code", $this->_input['p_code']);//从修改页面 跳转 到选择类别页面 商品编号
		$this->output("top_cate", $product_top_cate);
		$this->showpage("own_product.sell");
	}

	/**
	 * 添加商品页面
	 *
	 */
	function _addproduct(){
		/**
		 * 整合X，判断该会员所在的X会员组是否允许发布商品
		 */
		$check_group = $this->_x_check_group();
		if($check_group !== true){
			$this->redirectPath("error","",$this->_lang['langProductXGroupDenySetProduct']);
		}
		/**
		 * 整合X，如果是，则判断是否有fid，没有则跳转模块选择页面
		 */
		$this->_x_forum_check();
		/**
		 * 整合X
		 */
		$this->_x_data();
		/**
		 * 整合X 输出版块路径内容
		 */
		$forum_list = $this->_x_get_forum_list($this->_input['fid']);
		/**
		 * 整合X 版块输出内容
		 */
		if(is_array($forum_list)){
			for($i=(count($forum_list)-1);$i>=0;$i--){
				$forum_list_string .= $forum_list[$i]['name'].'->';
			}
			/**
			 * 整合X 输出内容
			 */
			$this->output('forum_list_string',trim($forum_list_string,'->'));
		}
		/**
		 * 商品类别
		 */
		if (!is_object($this->objProductCate)){
			require_once("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
		$ProductClassArray = $this->objProductCate->listClassDetail('');
		if (is_array($ProductClassArray)){
			foreach ($ProductClassArray as $k => $v){
				if ($v[4] == '0') {
					$ProductCateArray[] = $v;
				}
			}
		}
		/**
		 * 如果是发布同类商品，那么取该分类内容
		 */
		$sel_pc = array();
		if ($this->_input['slPCId'] != ''){
			/**
			 * 选中类别
			 */
			$sel_pc = $this->objProductCate->getProductClassPathList($this->_input['slPCId']);
			$product_attribute = $this->_get_attribute($this->_input['slPCId']);
		}

		//取支付方式
		if (is_array($this->_configinfo['payment'])){
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
					}elseif ($param_array['type'] == 'offline'){//是线下的
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

		//地区调用
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
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

		//输出footer内容
//		$this->_show_footer();

		/**
		 * 页面输出
		 */
		$this->output("sel_pc", $sel_pc);
		$this->output("area_array", $area_array);
		$this->output("config_predeposit", $this->_configinfo['payment']['predeposit']);
		$this->output("payment_description", $payment_description);
		$this->output("exchange_array", $exchange_array);
		$this->output("payment_array", $payment_array);
		$this->output("shop_product_cate_array",   $shop_product_category);
		$this->output("selltype", 1);//一口价
		$this->output("product_code", $product_code);
		$this->output("cate_name", $cate_name);
		$this->output("have_attribute", $content_sign);
		$this->output("product_attribute", $product_attribute);
		$this->output("payment_array", $payment_array);
		$this->output("product_currency", $product_currency);
		$this->output("brand_list", $brand_list);
		$this->output("ProductCateArray", $ProductCateArray);
		$this->showpage("own_product.add");
	}

	/**
	 * 保存商品信息
	 *
	 */
	function _saveproduct(){
		/**
		 * 整合X，判断该会员所在的X会员组是否允许发布商品
		 */
		$check_group = $this->_x_check_group();
		if($check_group !== true){
			$this->redirectPath("error","",$this->_lang['langProductXGroupDenySetProduct']);
		}
		/**
		 * 整合X
		 */
		$this->_x_data();

		/**
		 * 验证表单信息
		 */
		if("2" == $this->_input["radioSelltype"]){//团购
			$this->_input["txtPprice"] = $this->_input["txtPoldprice"];
		}
		if("0" == $this->_input["radioSelltype"]){//拍卖
			$this->_input["txtPprice"] = $this->_input["minimumBid"];
		}

		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtPname"],"require"=>"true","message"=>$this->_lang['errPSNameEmpty']),
		array("input"=>$this->_input["slPCId"],"require"=>"true","message"=>$this->_lang['errPcidEmpty']),
		//array("input"=>$this->_input["txtPinfo"],"require"=>"true","message"=>$this->_lang['errPSInfoEmpty']),
		array("input"=>$this->_input["radioSelltype"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSSelltype']),
		array("input"=>$this->_input["radioType"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSType']),
		array("input"=>$this->_input["txtPstorage"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSstorage']),
		//array("input"=>$this->_input["txtPprice"],"validator"=>"Currency","message"=>$this->_lang['errPSprice']),
		array("input"=>$this->_input["txtGroupprice"],"validator"=>"Currency","message"=>$this->_lang['errPSGroupprice']),
		array("input"=>$this->_input["txtPoldprice"],"validator"=>"Currency","message"=>$this->_lang['errPsPoldprice']),
		array("input"=>$this->_input["txtPoldprice"],"validator"=>"Compare","operator"=>">=","to"=>$this->_input["txtGroupprice"],"message"=>$this->_lang['errPSPriceNoGroupPrice']),
		array("input"=>$this->_input["txtGroupmincount"],"validator"=>"Number","message"=>$this->_lang['errPSGroupmincount']),
		array("input"=>$this->_input["area_id"],"require"=>"true","message"=>$this->_lang['errPProductAreaIsEmpty']),
		array("input"=>$this->_input["radioTransfee"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSTransfee']),
		array("input"=>$this->_input["radioInvoices"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSInvoices']),
		array("input"=>$this->_input["radioWarranty"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSWarranty']),
		array("input"=>$this->_input["slValiddays"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSValiddays']),
		array("input"=>$this->_input["chxAutopublish"],"validator"=>"Integer","message"=>$this->_lang['errPSAutopublish']),
		array("input"=>$this->_input["chxRecommended"],"validator"=>"Integer","message"=>$this->_lang['errPSRecommended']));
		$error = $this->objvalidate->validate();

		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 使用运费模板
			 */
			if ($this->_input['radioTransfee'] == '1' && $this->_input['use_postage'] == '1'){
				/**
				 * 取运费模板内容
				 */
				require_once ("postage.class.php");
				$obj_postage = new PostageClass();
				$postage_array = $obj_postage->getOnePostage($this->_input['postage_id']);
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
				$this->_input['pyTF'] = '0';
				$this->_input['kdTF'] = '0';
				$this->_input['emsTF'] = '0';
			}
			$this->_input["txtPinfo"] = $this->_input["txtPinfo"];
			$this->_input["txtMemberid"] = $_SESSION['s_login']['id'];
			$this->_input["txtThemeid"] = 0;
			$this->_input["txtPpoint"] = 0;
			$this->_input["txtPviewnum"] = 0;
			if("" == $this->_input["chxAutopublish"]){
				$this->_input["chxAutopublish"] = 0;
			}
			if("" == $this->_input["chxRecommended"]){
				$this->_input["chxRecommended"]=0;
			}
			if(("0" == $this->_input["_now"])){
				$this->_input["txtPstate"] = 1;
				$this->_input["txtPstarttime"] = time();
				$this->_input["txtPendtime"] = Common::calculateDate("d",$this->_input["slValiddays"],time());
			}elseif ("1" == $this->_input["_now"]){
				$this->_input["txtPstate"] = 0;
				$start_time = split("-", $this->_input["_date"]);
				$this->_input["txtPstarttime"] = mktime($this->_input["_hour"],$this->_input["_minute"],0,$start_time[1],$start_time[2],$start_time[0]);
				$this->_input["txtPendtime"] = Common::calculateDate("d",$this->_input["slValiddays"],$this->_input["txtPstarttime"]);
				$this->_input["IfnoPub"] = 1;

			}elseif ("2" == $this->_input["_now"]){
				$this->_input["txtPstate"] = 0;
				$this->_input["txtPstarttime"] = "";
				$this->_input["txtPendtime"] = "";
			}

			//组合支付方式
			if (is_array($this->_input['txtPayment'])){
				$this->_input['payment'] = '';
				foreach ($this->_input['txtPayment'] as $k => $v){
					$this->_input['pay_method'] .= $v.'|';
				}
				$this->_input['pay_method'] = trim($this->_input['pay_method'],'|');
			}
			if ($this->_input['pay_method'] == '' &&  $this->_input['pay_predeposit'] == ''){//如果错误则返回
				$this->redirectPath("error","",$this->_lang['errPayment']);
			}else {
				$this->_input['pay_method'] = '|'.$this->_input['pay_method'].'|';
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
			$this->_input["txtPcode"] = md5($product_last_id.$random_string);

			//处理上传图片
			$pic_arr = array();//图片名数组
			for ($i=0;;$i++){
				if(!isset($_FILES['txtPpic_'.$i]['name']) || $_FILES['txtPpic_'.$i]['name'] == ''){
					break;
				}
				$pic_arr[] = $this->_pic_add('txtPpic_'.$i);
			}
			//			$pic_arr = @explode('|',$this->_input['p_pic']);
			
			$pic_arr=explode("|||",$this->_input["pichidden"]);
			if (is_array($pic_arr)){
				$pic_value = array();
				$j = 0;
				for ($i=0;$i<count($pic_arr);$i++){
					if ($pic_arr[$i] != ''){
						//$pic_arr[$i] 为缩略图文件名，更改为普通图片缩略图
						$arr = @explode('.',$pic_arr[$i]);
						$arr_two = @explode('_',$arr[0]);
						$pic_value[$j]['p_pic'] = $arr_two[0].'.'.$arr[1];
						$pic_value[$j]['p_code'] = $this->_input["txtPcode"];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}
			//默认取第一个作为商品列表展示使用的图片，存入商品信息表中
			$this->_input['txtPpic'] = $pic_value[0]['p_pic'];
			//预存款
			if($this->_configinfo['payment']['predeposit'] == '1'){//开启状态
				$this->_input['pay_predeposit'] = ($this->_input['pay_predeposit']=='0')?$this->_input['pay_predeposit']:'1';
			}
			//会员信息
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			//判断是否是推荐商品，如果没有剩余的推荐数量，那么将推荐属性清除
			if ($member_array['recommend_max_count']-$member_array['recommend_product_count'] <= 1){
				$this->_input['chxRecommended'] = '0';
			}
			//搜索引擎信息
			$this->_input['txtKeywords'] = str_replace('，',',',$this->_input['txtKeywords']);
			$this->_input['txtKeywords'] = $this->_input['txtKeywords']?$this->_input['txtKeywords']:$this->_input['txtPname'];
			$this->_input['txtDescription'] = str_replace('，',',',$this->_input['txtDescription']);
			$this->_input['txtDescription'] = $this->_input['txtDescription']?$this->_input['txtDescription']:$this->_input['txtPname'];

			/**
			 * 商品信息入库
			 */
			$result = $this->obj_product->addProduct($this->_input);

			/**
			 * 整合X
			 */
			$x_array = $this->obj_x_class->_x_insert($this->_input['fid'],$this->_input['tid'],$this->_input);

			/**
			 * UC推送
			 */
			if ($this->makeFeed('sendgoods')){
				//商品信息参数
				$subject_url = $this->_configinfo['websit']['site_url'].'/home/product.php?action=view&pid='.$this->_input["txtPcode"];
				define('UC_APPID',$this->_configinfo['ucenter']['uc_appid']);
				$feed_param = array(
				'icon'			=> 'goods',
				'uid'			=> $_SESSION['s_login']['id'],
				'username'		=> $_SESSION['s_login']['name'],
				'title_template'=> '{actor}'.$this->_lang['langProductAdd'].'{subject}',
				'title_data'	=> array('subject'=>'<a href="'.$subject_url.'">'.$this->_input['txtPname'].'</a>'),
				'body_template'	=> '<b>{subject}</b>',
				'body_data'		=> array('subject'=>"<a href='".$this->_configinfo['websit']['site_url']."/store/index.php?userid=".$_SESSION['s_login']['id']."' target='_blank'>".$_SESSION['s_login']['name'].$this->_lang['langProductShop']."</a>"),
				'images'		=> array(array('url'=>$this->_configinfo['websit']['site_url'].'/'.($this->_input['txtPpic']!='' ? $this->_input['txtPpic'] : 'templates/orange/images/noimgb.gif'),'link'=>$subject_url))
				);

				require_once('ucenter.class.php');
				$obj_ucenter = new ucenterClass();
				$obj_ucenter->uc_feed($feed_param);
				unset($obj_ucenter);
			}
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
					$result_attribute = $this->obj_product->addProductAttribute($this->_input["txtPcode"], $insert_ac);
				}
			}
			/**
			 * 更新商品发布数量的统计信息
			 */
			if($this->_input["txtPstate"] == "1"){
				$update_product_statis = $this->obj_product->updateProductStatistics($this->_input["txtMemberid"],'sell');
			}

			/**
			 * 生成静态页面
			 */
			$html = $this->make_product_html($this->_input["txtPcode"]);
			if(!$html){
				echo "faild to make html file";exit;
			}
			/*判断返回路径*/
			if (file_exists("../html/user/".$this->_input['slPCId']."/item_detail-".$this->_input["txtPcode"].'.html')){
				$url = "../html/user/".$this->_input['slPCId']."/item_detail-".$this->_input["txtPcode"].'.html';
			}else {
				$url = "../home/product.php?action=view&pid=".$this->_input["txtPcode"];
			}

			//成功发布商品
			CreditsClass::saveCreditsLog('succ_product_put',$_SESSION["s_login"]['id']);
			/**
			 * 返回链接
			 */
			$return_url = "own_product.php?action=operating_succ&url={$url}&slPCId={$this->_input['slPCId']}";
			/**
			 * 判断是否整合X
			 */
			if(DISCUZ_X === true && !empty($x_array)){
				$fid_tid_pid = implode('|||',$x_array);
				$return_url .= "&fid_tid_pid=".$fid_tid_pid;
			}
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
		if(DISCUZ_X === true && !empty($this->_input['fid_tid_pid'])){
			$array = explode('|||',$this->_input['fid_tid_pid']);
			$show_page = "own_product_x.succ";
		}else{
			$show_page = "own_product.succ";
		}
		/**
		 * 页面输出
		 */
		$this->output('fid',$array[0]);
		$this->output('tid',$array[1]);
		$this->output('pid',$array[2]);
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
	function _modiproduct(){
		/**
		 * 取商品信息
		 */
		if(DISCUZ_X == true && strlen($this->_input["pid"]) != 32){
			//验证会员和商品是否一致 
			$this->checkRightMemberToProductByPid($this->_input["pid"]);
		}else{
			//验证会员和商品是否一致
			$this->checkRightMemberToProduct($this->_input["pid"]);
		}
		/**
		 * 取商品信息
		 */
		$product_array = $this->obj_product->getProductRow($this->_input["pid"]);

		if ($product_array['p_sell_type'] != '1'){
			/**
			 * 实例化商品订单类
			 */
			if (!is_object($this->obj_product_order)){
				require_once("order.class.php");
				$this->obj_product_order = new ProductOrderClass();
			}
			if (!is_object($this->obj_product_bid)){
				require_once("bid.class.php");
				$this->obj_product_bid = new BidClass();
			}
			$condition['p_code'] = $this->_input["pid"];
			$condition['search_time'] = 1;
			$condition['start_time'] = $product_array['p_start_time'];
			$condition['end_time'] = $product_array['p_end_time'];
			$order = $this->obj_product_order->getProductOrderList($condition,$page);
			unset($condition);
			$condition['p_code'] = $product_array['p_code'];
			$bid = $this->obj_product_bid->getProductBidList($condition,$page);
			//判断条件
			//判断在这次发布时是否有商品的购买信息
			//判断在这次发布时是否有商品的拍卖
			if ((count($order) > 0 || count($bid) > 0) && $product_array['p_state'] == 1) {
				$error = $this->_lang['errPProductIsLocked'];
				$this->redirectPath("error","",$error);
			}
			unset($order,$bid,$condition);
		}
		/**
		 * 商品属性处理
		 */
		require_once("attribute.class.php");
		$obj_product_attribute = new AttributeClass();
		require_once("attribute_content.class.php");
		$obj_product_attribute_content = new AttributeContentClass();
		//取商品属性选中项
		$attribute_condition_str = " and p_id = '" . $this->_input["pid"] . "'";
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
		$pcid = $product_array['pc_id'];
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
			//判断商品属性是否有内容
			if ($content_sign == 1){//有内容
				$have_attribute = 1;
			}
			unset($content_sign);
		}
		/**
		 * 取商品所有类别
		 */
		if (!is_object($this->objProductCate)){
			require_once("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
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
		$sel_pc = $this->objProductCate->getProductClassPathList($product_array['pc_id']);

		if ($product_array['p_state'] == '1') {
			$checked_state = 1;
		}elseif ($product_array['p_state'] == '0' && $product_array['p_start_time'] != '0') {
			$checked_state = 2;
		}else {
			$checked_state = 3;
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
		$condition_pic['p_code'] = $this->_input["pid"];
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
		//地区调用
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);
		//取地区内容
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
		if (!empty($product_array) && $product_array['p_pb_id'] !=''){
			$sel_brand = $this->obj_product_brand->getProductBrandPathList($product_array['p_pb_id']);
		}
		//输出footer内容
//		$this->_show_footer();

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
		$this->output("x_return_sign", $x_return_sign);
		$this->output("postage_array", $postage_array);
		$this->output("sel_pc", $sel_pc);
		$this->output("sel_area", $sel_area);
		$this->output("area_array", $area_array);
		$this->output("config_predeposit", $this->_configinfo['payment']['predeposit']);
		$this->output("pic_array", $pic_array);
		$this->output("pic_num", count($pic_array));//图片数量
		$this->output("pic_line", $pic_line);
		$this->output("payment_description", $payment_description);
		$this->output("shop_product_cate_array",   $shop_product_category);
		$this->output("exchange_array", $exchange_array);
		$this->output("product_currency", $product_currency);
		$this->output("payment_array", $payment_array);
		$this->output("default_time",$product_array['p_start_time']);
		$this->output('checked_state',$checked_state);
		$this->output("slPCId", $slPCId);
		$this->output('ProductCateArray',$ProductCateArray);
		$this->output("selltype", $product_array['p_sell_type']);
		$this->output("site_url", $this->_configinfo['websit']['site_url']);
		$this->output("product_array", $product_array);
		$this->output("cate_name", $cate_name);
		$this->output("product_attribute", $product_attribute);
		$this->output("have_attribute", $have_attribute);
		$this->output("product_have_attribute", $pac_attribute);
		$this->output("sel_brand", $sel_brand);
		$this->output("brand_list", $brand_list);
		$this->showpage("own_product.add");
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
	function _updateproduct(){
		

		if("2" == $this->_input["radioSelltype"]){//团购
			$this->_input["txtPprice"] = $this->_input["txtPoldprice"];
		}
		if("0" == $this->_input["radioSelltype"]){//拍卖
			$this->_input["txtPprice"] = $this->_input["minimumBid"];
		}
		/**
		 * 验证表单信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtPname"],"require"=>"true","message"=>$this->_lang['errPSNameEmpty']),
		//array("input"=>$this->_input["txtPinfo"],"require"=>"true","message"=>$this->_lang['errPSInfoEmpty']),
		array("input"=>$this->_input["radioSelltype"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSSelltype']),
		array("input"=>$this->_input["slPCId"],"require"=>"true","validator"=>"Integer","message"=>$this->_lang['errPCId']),
		array("input"=>$this->_input["radioType"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSType']),
		array("input"=>$this->_input["txtPstorage"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSstorage']),
		//array("input"=>$this->_input["txtPprice"],"require"=>"true","validator"=>"Currency","message"=>$this->_lang['errPSprice']),
		array("input"=>$this->_input["txtGroupprice"],"validator"=>"Currency","message"=>$this->_lang['errPSGroupprice']),
		array("input"=>$this->_input["txtPoldprice"],"validator"=>"Currency","message"=>$this->_lang['errPSPoldprice']),
		array("input"=>$this->_input["txtGroupmincount"],"validator"=>"Number","message"=>$this->_lang['errPSGroupmincount']),
		array("input"=>$this->_input["area_id"],"require"=>"true","message"=>$this->_lang['errPProductAreaIsEmpty']),
		array("input"=>$this->_input["radioTransfee"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSTransfee']),
		array("input"=>$this->_input["radioInvoices"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSInvoices']),
		array("input"=>$this->_input["radioWarranty"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSWarranty']),
		array("input"=>$this->_input["slValiddays"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSValiddays']),
		array("input"=>$this->_input["chxAutopublish"],"validator"=>"Integer","message"=>$this->_lang['errPSAutopublish']),
		array("input"=>$this->_input["chxRecommended"],"validator"=>"Integer","message"=>$this->_lang['errPSRecommended']));

		$error = $this->objvalidate->validate();

		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			//取原来商品的信息
			$old_product = $this->obj_product->getProductRow($this->_input['txtPid']);
			//验证商品和会员是否一致
			$this->checkRightMemberToProduct($this->_input['txtPid']);
			/**
			 * 使用运费模板
			 */
			if ($this->_input['radioTransfee'] == '1' && $this->_input['use_postage'] == '1'){
				/**
				 * 取运费模板内容
				 */
				require_once ("postage.class.php");
				$obj_postage = new PostageClass();
				$postage_array = $obj_postage->getOnePostage($this->_input['postage_id']);
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
				$this->_input['pyTF'] = '0';
				$this->_input['kdTF'] = '0';
				$this->_input['emsTF'] = '0';
			}
			//组合支付方式
			if (is_array($this->_input['txtPayment'])){
				$this->_input['payment'] = '';
				foreach ($this->_input['txtPayment'] as $k => $v){
					$this->_input['pay_method'] .= $v.'|';
				}
				$this->_input['pay_method'] = trim($this->_input['pay_method'],'|');
			}
			if ($this->_input['pay_method'] == '' && $this->_input['pay_predeposit'] == ''){//如果错误则返回
				$this->redirectPath("error","",$this->_lang['errPayment']);
			}else {
				$this->_input['pay_method'] = '|'.$this->_input['pay_method'].'|';
			}
			//组合支持交易的货币种类
			if (is_array($this->_input['currency'])){
				$this->_input['p_currency_category'] = '|'.@implode('|',$this->_input['currency']).'|';
			}

			$this->_input["txtPinfo"] = $this->_input["txtPinfo"];
			$this->_input["txtMemberid"] = $_SESSION['s_login']['id'];
			$this->_input["txtThemeid"] = 0;
			$this->_input["txtPpoint"] = 0;
			if("" == $this->_input["chxAutopublish"]){
				$this->_input["chxAutopublish"] = 0;
			}
			if("" == $this->_input["chxRecommended"]){
				$this->_input["chxRecommended"] = 0;
			}
			if("2" == $this->_input["radioSelltype"]){
				$this->_input["txtPprice"] = $this->_input["txtPoldprice"];
			}

			if(("0" == $this->_input["_now"])){			/*宝贝发布时间立刻开始*/
				if("1" != $this->_input["txtPstate"]){
					$this->_input["txtPstate"] = '1';
					$this->_input["txtPstarttime"] = time();
					$this->_input["txtPendtime"] = Common::calculateDate("d",$this->_input["slValiddays"],$this->_input["txtPstarttime"]);
				}elseif("" != $this->_input["slValiddays"]){	/*宝贝出售结束时间随有效期更改*/
					$this->_input["txtPendtime"] = Common::calculateDate("d",$this->_input["slValiddays"],$this->_input["txtPstarttime"]);
				}

			}elseif ("1" == $this->_input["_now"]){		/*宝贝发布时间设定开始*/
				$this->_input["txtPstate"] = '0';
				$start_time = split("-", $this->_input["_date"]);
				$this->_input["txtPstarttime"] = mktime($this->_input["_hour"],$this->_input["_minute"],0,$start_time[1],$start_time[2],$start_time[0]);
				$this->_input["txtPendtime"] = Common::calculateDate("d",$this->_input["slValiddays"],$this->_input["txtPstarttime"]);
				$this->_input["IfnoPub"] = 1;

			}elseif ("2" == $this->_input["_now"]){		/*宝贝放入仓库*/
				$this->_input["txtPstate"] = '0';
				$this->_input["txtPstarttime"] = "0";
				$this->_input["txtPendtime"] = "0";
			}

			//将原来的PIC数据清空
			//			$this->obj_product->delProductPic($this->_input['txtPid']);
			//将图片字符串分割
			//处理上传图片
			$pic_arr = array();//图片名数组
			for ($i=0;;$i++){
				if(!isset($_FILES['txtPpic_'.$i]['name']) || $_FILES['txtPpic_'.$i]['name'] == ''){
					break;
				}
				$pic_arr[] = $this->_pic_add('txtPpic_'.$i);
			}
			
			//			$pic_arr = @explode('|',$this->_input['p_pic']);
			$pic_arr=explode("|||",$this->_input["pichidden"]);
			if (is_array($pic_arr)){
				$pic_value = array();
				$j = 0;
				for ($i=0;$i<count($pic_arr);$i++){
					if ($pic_arr[$i] != ''){
						//$pic_arr[$i] 为缩略图文件名，更改为普通图片缩略图
						$arr = @explode('.',$pic_arr[$i]);
						$arr_two = @explode('_',$arr[0]);
						$pic_value[$j]['p_pic'] = $arr_two[0].'.'.$arr[1];
						$pic_value[$j]['p_code'] = $this->_input['txtPid'];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}

			//提取第一个图片的缩略图
			$this->_input['txtPpic'] = $this->_input['p_pic'];

			//预存款
			if($this->_configinfo['payment']['predeposit'] == '1'){//开启状态
				$this->_input['pay_predeposit'] = ($this->_input['pay_predeposit']=='0')?$this->_input['pay_predeposit']:'1';
			}
			//会员信息
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			//判断是否是推荐商品，如果没有剩余的推荐数量，那么将推荐属性清除
			if ($member_array['recommend_max_count']-$member_array['recommend_product_count'] <= 1){
				$this->_input['chxRecommended'] = '0';
			}
			//搜索引擎信息
			$this->_input['txtKeywords'] = str_replace('，',',',$this->_input['txtKeywords']);
			$this->_input['txtKeywords'] = $this->_input['txtKeywords']?$this->_input['txtKeywords']:$this->_input['txtPname'];
			$this->_input['txtDescription'] = str_replace('，',',',$this->_input['txtDescription']);
			$this->_input['txtDescription'] = $this->_input['txtDescription']?$this->_input['txtDescription']:$this->_input['txtPname'];
			/**
			 * 商品入库
			 */
			$result = $this->obj_product->updateProduct($this->_input);
			
			/**
			 * 整合X
			 */
			$this->obj_x_class->_x_update($old_product,$this->_input);

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
					$result_attribute = $this->obj_product->updateProductAttribute($this->_input["txtPcode"], $insert_ac);
				}
			}
			/**
			 * 更新商品发布数量的统计信息
			 */
			$update_product_statis = $this->obj_product->updateProductStatistics($this->_input["txtMemberid"],'sell');

			/*删除原来旧的静态文件*/
			$old_file = "../html/user/".$old_product['pc_id']."/item_detail-".$old_product['p_code'].'.html';
			if (file_exists($old_file)){
				@unlink($old_file);
			}

			/**
			 * 生成静态页面
			 */
			$html = $this->make_product_html($this->_input["txtPid"]);
			if(!$html){
				$this->redirectPath('error','','faild to make html file');
			}

			/**
			 * 取商品新信息
			 */
			$product_row = $this->obj_product->getProductRow($this->_input["txtPid"]);
			if ($this->_configinfo['productinfo']['ifhtml'] == '1'){
				$url = "./html/user/".$product_row['pc_id']."/item_detail-".$product_row['p_code'].'.html';
			}else {
				$url = "./home/product.php?action=view&pid=".$product_row['p_code'];
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
		array("input"=>$this->_input["txtPcode"],"require"=>"true","message"=>$this->_lang['errPSCodeEmpty']),
		array("input"=>$this->_input["txtPcount"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPSstorage']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			$result = $this->obj_product->updateProductCount($this->_input);
			$html   = $this->make_product_html($this->_input["txtPcode"]);
			if(!$html){
				$this->redirectPath("error","",$error);
			}
			$this->redirectPath("succ","member/own_product_list.php?action=list",$this->_lang['langPSoperatorOk']);
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
			$this->redirectPath("succ","member/own_product_list.php?action=list",$this->_lang['langPSoperatorOk']);
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
				$this->redirectPath("succ","member/own_product_list.php?action=".$this->_input['list_type'],$this->_lang['langPSoperatorOk']);
			}else {
				$this->redirectPath("error","",$this->_lang['errProductId']);
			}
		}
	}

	/**
	 * 检查会员是否和商品所属会员相同
	 */
	function checkRightMemberToProduct($p_id){
		if ($p_id != ''){
			$product_array = $this->obj_product->getProductRow($p_id);
			if($this->_input['action'] == 'del'){
				/**
				 * 判断是否是删除操作，如果是，那么增加X整合的删除方法
				 */
				$this->obj_x_class->_x_del($product_array['x_pid']);
			}
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
		//		if(isset($_FILES['txtPpic']['name']) and $_FILES['txtPpic']['name'] != ''){
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

		//图片名称$filename["getfilename"]
		//		$arr = @explode('.',$filename["getfilename"]);
		//		$return_name = $arr[0].'_small.'.$arr[1];
		//		unset($arr);
		//图片缓存表中增加数据
		//		$this->obj_product->addProductPicCache(array('p_pic_cache'=>$filename["getfilename"]));
		//		return $filename["getfilename"];
		//		Common::outMessage("json",$return_name,1);
		//		}else {
		//			//输出信息
		//			Common::outMessage("json",$this->_lang['langPPicFormatIsWrong'],0);
		//		}
	}
	function _pic_ajax($input_file_name){
		//		if(isset($_FILES['txtPpic']['name']) and $_FILES['txtPpic']['name'] != ''){
		if (!is_object($this->obj_upload)){
			require_once("uploadfile.class.php");
			$this->obj_upload = new UploadFile();
			$this->obj_upload->max_size = $this->_configinfo['file']['allowuploadmaxsize'];
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
			if (intval($pic_param/288) >= 1){
				$obj_big = new resizeImage($filename['filename'],intval($width/($pic_param/288)),intval($height/($pic_param/288)),$cut,"_big.");
		
			}else {
				$obj_big = new resizeImage($filename['filename'],$width,$height,$cut,"_big.");
			}
			unset($obj_small,$obj_mid,$obj_big);
		}
		echo $filename["getfilename"];

		//图片名称$filename["getfilename"]
		//		$arr = @explode('.',$filename["getfilename"]);
		//		$return_name = $arr[0].'_small.'.$arr[1];
		//		unset($arr);
		//图片缓存表中增加数据
		//		$this->obj_product->addProductPicCache(array('p_pic_cache'=>$filename["getfilename"]));
		//		return $filename["getfilename"];
		//		Common::outMessage("json",$return_name,1);
		//		}else {
		//			//输出信息
		//			Common::outMessage("json",$this->_lang['langPPicFormatIsWrong'],0);
		//		}
	}


	/**
	 * AJAX删除图片
	 */
	function _pic_del(){
		if ($this->_input['pic_name'] != ''){
			//将传过来的图片名称分别整理为原有图片，中号和大号图片,全部删除
			$arr = @explode('.',$this->_input['pic_name']);
			$arr[0] = @str_replace('_small','',$arr[0]);
			@unlink(BasePath.'/'.$arr[0].'.'.$arr[1]);
			@unlink(BasePath.'/'.$arr[0].'_small.'.$arr[1]);
			@unlink(BasePath.'/'.$arr[0].'_big.'.$arr[1]);
			@unlink(BasePath.'/'.$arr[0].'_mid.'.$arr[1]);
			//将数据库中的图片信息，也删除
			$this->obj_product->delProductPicByPic($this->_input['pic_name']);
			//图片缓存表中删除数据
			$this->obj_product->delProductPicCache($arr[0].'.'.$arr[1]);
			unset($arr);
			//输出信息
			Common::outMessage("json",'SUCC',1);
		}else {
			//输出信息
			Common::outMessage("json",$this->_lang['langPPicFormatIsWrong'],0);
		}
	}

	/**
	 * 在商品添加修改页面 为了防止与im的js冲突，单独输出页脚内容
	 */
	function _show_footer(){
		/**
		 * 创建栏目对象
		 */
		if (!is_object($this->obj_section)){
			require_once("section.class.php");
			$this->obj_section = new SectionClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("sys_section.manage");
		/**
		 * 取得需要显示的通用栏目信息
		 */
		$array = $this->obj_section->getSectionList();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v['is_show'] == 1){
					$footer_array[] = $v;
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output('config_poweredby',$this->_configinfo['websit']['poweredby']);
		$this->output('config_icprecord',$this->_configinfo['websit']['icprecord']);
		$this->output('url',$this->_configinfo['websit']['site_url']);
		$this->output('footer_array',$footer_array);
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
					$html .= $v['a_name'].':';
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
	 * 对于X数据表的信息的验证和处理
	 * 数据库方法$GLOBALS['db']->Execute($sql)
	 */
	function _x_data(){
		if (DISCUZ_X !== true){
			return false;
		}
		/**
		 * 对于版块ID(fid)和帖子ID(tid)的判断
		 */
		$fid = intval($this->_input['fid']);
		if ($fid <= 0){
			/**
			 * 版块id不正确，返回错误
			 */
			$this->redirectPath('error','',$this->_lang['errProductXForumIDIsWrong']);
		}
		/**
		 * 取版块内容，判断版块是否有发布商品的权限
		 */
		$sql = "SELECT * FROM `".X_PRE."forum_forum` Where fid='". $fid ."'";
		$forum_array = $GLOBALS['db']->GetRow($sql);
		unset($sql);
		if (empty($forum_array)){
			/**
			 * 版块内容为空，返回错误
			 */
			$this->redirectPath('error','',$this->_lang['errProductXForumIsEmpty']);
		}else {
			/**
			 * 如果是群组的话，那么type需要是sub，status需要是3
			 */
			if($forum_array['status'] == '3' && $forum_array['type'] != 'sub'){
				$this->redirectPath('error','',$this->_lang['errProductXForumDenySetProduct']);
			}
			$allowpostspecial = $forum_array['allowpostspecial'];
			$tmp_string = bindec($allowpostspecial);
			$product_allow = $tmp_string[1];
			if ($product_allow == '0'){
				/**
				 * 不允许发布商品类型的帖子
				 */
				$this->redirectPath('error','',$this->_lang['errProductXForumDenySetProduct']);
			}
		}
		/**
		 * 模板输出
		 */
		$this->output('fid',$this->_input['fid']);
		$this->output('tid',$this->_input['tid']);
		$this->output('pid',$this->_input['pid']);
		return true;
	}

	/**
	 * 整合X情况下检查会员是否和商品所属会员相同
	 * $x_pid 
	 */
	function checkRightMemberToProductByPid($x_pid){
		if ($x_pid != ''){
			$product_array = $this->obj_product->getProductRowByXpid($x_pid);
			if ($product_array['member_id'] != $_SESSION["s_login"]['id']){
				$error = $this->_lang['langPProductMemberErrRestartLogin'];
				$this->redirectPath("error","",$error);
			}else{
				$this->_input['pid'] = $product_array['p_code'];
			}
		}else {
			$error = $this->_lang['langPProductMemberErrRestartLogin'];
			$this->redirectPath("error","",$error);
		}
	}

	/**
	 * 整合X情况下判断是否接收到fid版块id，如果没有，则跳转到版块选择页面，只能选择可以发布商品的页面
	 * $x_pid 
	 */
	function _x_forum_check(){
		if (DISCUZ_X !== true){
			return false;
		}
		if(empty($this->_input['fid'])){
			@header('location: ./own_product.php?action=sel_forum');
			exit;
		}else{
			return false;
		}
	}

	/**
	 * 选择模块页面
	 */
	function _sel_forum(){
		if (DISCUZ_X !== true){
			@header('location: ./own_product.php?action=add');
			exit;
		}else{
			/**
			 * 群组内容
			 */
			$uid = $_SESSION['s_login']['id'];
			$group_id_sql = "SELECT fid FROM `".X_PRE."forum_groupuser` WHERE uid = '". $uid ."'";
			$group_id_array = $GLOBALS['db']->GetArray($group_id_sql);
			if(!empty($group_id_array)){
				foreach($group_id_array as $k => $v){
					$group_id_list .= '\''.$v['fid'].'\''.',';
				}
				$group_id_list = trim($group_id_list,',');
				if(!empty($group_id_list)){
					$group_sql = "SELECT fid,fup,type,name,allowpostspecial FROM `".X_PRE."forum_forum` WHERE fid IN (".$group_id_list.") ORDER BY type, displayorder";
					$group_list = $GLOBALS['db']->GetArray($group_sql);
					if(is_array($group_list)){
						foreach($group_list as $k => $v){
							/**
							 * 判断模块是否允许发布商品
							 */
							//$allow_bin = strrev(decbin($v['allowpostspecial']));
							//$group_list[$k]['allow_product'] = $allow_bin[1]?$allow_bin[1]:'0';
							//目前默认为可以发布
							$group_list[$k]['allow_product'] = 1;
						}
					}
				}
			}
			/**
			 * 论坛内容
			 */
			$forum_sql = "SELECT fid,fup,type,name,allowpostspecial FROM `".X_PRE."forum_forum` WHERE status IN ('1','2') ORDER BY type, displayorder";
			$forum_array = $GLOBALS['db']->GetArray($forum_sql);
			if(is_array($forum_array)){
				foreach($forum_array as $k => $v){
					/**
					 * 判断模块是否允许发布商品
					 */
					$allow_bin = strrev(decbin($v['allowpostspecial']));
					$forum_array[$k]['allow_product'] = $allow_bin[1]?$allow_bin[1]:'0';
					/**
					 * 判断是否是根版块
					 */
					if($v['fup'] == '0'){
						/**
						 * 判断该版块是否有下级版块
						 */
						foreach($forum_array as $k2 => $v2){
							if($v['fid'] == $v2['fup']){
								$v['is_parent'] = '1';
							}
						}
						$first_forum[] = $v;
					}
				}
			}
			/**
			 * 模板输出
			 */
			$this->output('group_list',$group_list);
			$this->output('forum_array',$forum_array);
			$this->output('first_forum',$first_forum);
			$this->showpage('own_product.sel_forum');
		}
	}
	
	/**
	 * 整合X 取版块内容
	 * $fid 版块ID
	 */
	function _x_get_forum($fid){
		if(DISCUZ_X !== true){
			return true;
		}
		$forum_sql = "SELECT fid,fup,type,name,allowpostspecial FROM `".X_PRE."forum_forum` WHERE fid='$fid'";
		$forum_array = $GLOBALS['db']->GetRow($forum_sql);
		return $forum_array;
	}

	/**
	 * 整合X 取版块内容 递归
	 * $fid 版块ID
	 * $forum_list 版块列表
	 */
	function _x_get_forum_list($fid,$forum_list = array()){
		if(DISCUZ_X !== true){
			return true;
		}
		$forum_array = $this->_x_get_forum($fid);
		$forum_list[] = $forum_array;
		if($forum_array['fup'] > 0){
			$forum_list = $this->_x_get_forum_list($forum_array['fup'],$forum_list);
		}
		return $forum_list;
	}
	/**
	 * 整合X 检查会员组是否允许发帖（商品）
	 * 
	 * 
	 */
	function _x_check_group(){
		if(DISCUZ_X !== true){
			return true;
		}
		$group_array = $this->obj_x_class->getMemberGroup($_SESSION['s_login']['id']);
		if($group_array['allowpost'] == '1'){
			return true;
		}else {
			return false;
		}
	}
}

$product_manage = new OwnProductManage();
$product_manage->main();
unset($product_manage);
?>