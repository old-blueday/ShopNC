<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_product.php   FILE_PATH : \multishop\member\own_product_group.php
 * ....团购
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Tue Aug 28 15:51:41 CST 2007
 */
require_once("../global.inc.php");

class OwnProductGroupManage extends memberFrameWork{
	/**
	 * 商品对象
	 *
	 * @var object
	 */
	var $obj_product;
	/**
	 * 团购商品对象
	 *
	 * @var object
	 */
	var $obj_product_group;
	/**
	 * 商品分类对象
	 *
	 * @var object
	 */
	var $objProductCate;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
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
	 * 订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;

	function main() {
		/**
		 * 实例化商品类对象
		 */
		if (!is_object($this->obj_product)) {
			include_once("product.class.php");
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
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		//语言包
		$this->getlang("product,product_group,productsucc");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('seller','my_seller','to_sale');

		switch ($this->_input['action']) {
			case 'update':
				//判断发布商品数量限制
				//CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);

				$this->_updategroupproduct();
				break;
			case 'modi':
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
				/**
				 * 上传图片后缀名
				 */
				$this->output('upload_ext',$upload_ext);
				$this->_modigroupproduct();
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
				/**
				 * 上传图片后缀名
				 */
				$this->output('upload_ext',$upload_ext);

				$this->_addgroupproduct();
				break;
			case 'save':
				//判断发布商品数量限制
				CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id']);
				$this->_savegroupproduct();
				break;
			case 'operating_succ':
				$this->_operating_succ();
				break;
			case 'ajax_check_predeposit':
				$this->_check_predeposit();
				break;
			case 'list':
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','selling');
				$this->_list();
				break;
			case 'list_instock'://仓库里的团购商品
			/**
				 * 菜单输出
				 */
			$this->memberMenu('seller','my_seller','storage');

			$this->_list_instock();
			break;
			case 'offsale':		//商品下架
			$this->_offsale();
			break;
			case 'onsale':		//商品上架
			$this->_onsale();
			break;
			case 'del':
				$this->_del();
				break;
			case 'recommended':
			case 'cancel_recommended':
				$this->_set_recommended();
				break;
			case 'store_recommended':
			case 'cancel_store_recommended':
				$this->_set_store_recommended();
				break;
			case "ajax_update_count":
				$this->_updateproductcount();
				break;
			case "update_pinfo":
				$this->_updateproductinfo();
				break;
			default:
				$this->_list();
		}

	}
	/**
	 * 显示团购商品添加
	 *
	 */
	function _addgroupproduct() {
		/**
		 * 出售类别为拍卖的商品
		 */
		if ($this->_input['p_sell_type'] != '' && $this->_input["p_sell_type"] !== '2'){
			$this->redirectPath("error","../member/own_product.php?action=sell",'1');
		}
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["pc_id"],"validator"=>"Number","message"=>'2'),
		);
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 取商品类别内容
			 */
			$product_class_string = $this->_get_product_class_path($this->_input["pc_id"]);
			/**
			 * 商品属性
			 */
			$product_attribute = $this->_get_attribute($this->_input['pc_id']);
			/**
			 * 获得店铺宝贝分类
			 */
			if ($_SESSION['s_shop']['id'] != ''){
				$shop_product_category = $this->_getShopClass($_SESSION['s_shop']['id']);
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
			//如果没有填写支付帐号
			if (!is_array($payment_array)){
				$this->redirectPath("error","../member/own_payment.php",$this->_lang['errMPaymentEmpty']);
			}
			/**
			 * 取货币种类
			 */
			$condition_exchange['state'] = 1;
			$exchange_list = $this->obj_exchange->listExchange($condition_exchange,$page);
			if (is_array($exchange_list)){
				foreach ($exchange_list as $k => $v){
					/**
					 * 取默认货币
					 */
					if ($v['exchange_default'] == '1'){
						$exchange_array = $v;
					}

				}
			}
		}
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
		* 页面输出
		*/
		$this->output('pc_id',$this->_input["pc_id"]);
		$this->output('product_class_string',$product_class_string);
		$this->output('product_attribute',$product_attribute);
		$this->output("payment_array", $payment_array);						//支付方式
		$this->output('shop_product_category',$shop_product_category);
		$this->output('brand_list',$brand_list);
		$this->output('area_array',$area_array);
		$this->output('exchange_array',$exchange_array);
		$this->showpage('own_product_group.add');
	}
	/**
	 * 保存团购商品信息
	 *
	 */
	function _savegroupproduct() {
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["p_name"],"require"=>"true","message"=>$this->_lang['errPname']),
		array("input"=>$this->_input["pc_id"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPcidEmpty']),
		array("input"=>$this->_input["p_storage"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPstorage']),
		array("input"=>$this->_input["p_area_id"],"require"=>"true","message"=>$this->_lang['errPProductAreaIsEmpty'])
		);
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 生成商品编号
			 */
			$product_last_id = $this->obj_product->getProductLastId();
			$product_last_id += 1;
			$chars = array(
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
			"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
			"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
			"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
			"S", "T", "U", "V", "W", "X", "Y", "Z"
			);
			$random_string = Common::genRandomString($chars, 4);
			$this->_input["p_code"] = md5($product_last_id.$random_string);
			/**
			 * 上传图片
			 */
			$pic_arr = explode("|||",$this->_input["pichidden"]);
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
						$pic_value[$j]['p_code'] = $this->_input["p_code"];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}
			$this->_input['p_pic'] = $pic_value[0]['p_pic'];
			/**
			 * 会员信息
			 */
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			/**
			 * 判断是否是推荐商品，如果没有剩余的推荐数量，那么将推荐属性清除
			 */
			if ($member_array['recommend_max_count']-$member_array['recommend_product_count'] <= 1){
				$this->_input['p_recommended'] = '0';
			}

			$group_start_time	= explode("-",$this->_input['cp_start_ymd']);	//将团购开始时间用数组切分
			$group_end_time		= explode("-",$this->_input['cp_end_ymd']);		//将团购结束时间用数组切分

			$insert_array = array();
			$insert_array['p_name'] 		= $this->_input['p_name'];			//商品名称
			$insert_array['pc_id'] 			= $this->_input['pc_id'];
			$insert_array['member_id']		= $_SESSION['s_login']['id'];		//会员id
			$insert_array['login_name']		= $_SESSION['s_login']['name'];		//会员名称
			$insert_array['p_code']			= $this->_input["p_code"];
			$insert_array['p_price']		= $this->_input['cp_price'];		//原价
			$insert_array['p_group_price']	= $this->_input['cp_group_price'];	//团购价
			$insert_array['p_start_time'] = mktime(0,0,0,$group_start_time[1],$group_start_time[2],$group_start_time[0]);		//开始时间
			$insert_array['p_end_time'] = mktime(0,0,0,$group_end_time[1],$group_end_time[2],$group_end_time[0]);			//结束时间
			$insert_array['p_valid_days'] = $this->_input['p_valid_days'];
			$insert_array['p_storage'] = $this->_input['p_storage'];			//库存
			$insert_array['p_state'] = 1;										//状态
			$insert_array['p_pic'] = $this->_input['p_pic'];					//图片
			$insert_array['p_intro'] = $this->_input['p_intro'];				//商品内容描述
			$insert_array['p_add_time'] = time();								//商品添加时间
			$insert_array['p_update_time'] = time();							//商品更新时间
			if ($this->_input['txtPayment'] != '') {								//支付方式
				$insert_array["p_pay_method"] = "|".@implode("|",$this->_input['txtPayment'])."|"; //支付方式
			}
			$insert_array['p_sell_type'] = '2';
			$insert_array['p_type'] = $this->_input['p_type'];
			$insert_array['p_cur_price'] = $this->_input['p_price'];
			$insert_array['p_system_step'] = $this->_input['p_system_step'];
			$insert_array['p_price_step'] = ($this->_input['p_system_step']=='1')?$this->_input['p_price_step']:'0';
			$insert_array['p_transfee_charge'] = '0';
			$insert_array['p_have_invoices'] = $this->_input['p_have_invoices'];
			$insert_array['p_have_warranty'] = $this->_input['p_have_warranty'];
			$insert_array['p_recommended'] = $this->_input['p_recommended'];
			$insert_array['p_remark'] = $this->_input['p_remark'];
			$insert_array['p_class_id'] = $this->_input['p_class_id'];
			$insert_array['p_currency_category'] = $this->_input['p_currency_category'];
			$insert_array['p_area_id'] = $this->_input['p_area_id'];
			$insert_array['p_pb_id'] = $this->_input['p_pb_id'];
			$insert_array['p_genuine'] = $this->_input['p_genuine'];
			$insert_array['p_7day_return'] = $this->_input['p_7day_return'];
			$insert_array['p_keywords'] = $this->_input['p_keywords']?$this->_input['p_keywords']:$this->_input['p_name'];			//关键字
			$insert_array['p_description'] = $this->_input['p_description']?$this->_input['p_description']:$this->_input['p_name'];	//描述

			/**
			 * 商品信息入库
			 */
			$result = $this->obj_product->addProduct($insert_array);
			/**
			 * 团购扩展信息插入
			 */
			$group_array			= array();
			$group_array['p_code']			= $insert_array['p_code'];				//商品code
			$group_array['set_money']		= $this->_input['cp_set_money'];		//定金
			$group_array['min_count']		= $this->_input['cp_min_count'];		//最小购买人数
			$group_array['max_count']		= $this->_input['cp_max_count'];		//最大购买数量
			$group_array['product_comments']= $this->_input['cp_product_comments'];	//商品介绍
			$group_array['web_comments']	= $this->_input['cp_web_comments'];		//网站介绍
			$group_result = $this->obj_product->addProductGroup($group_array);
			unset($group_array);

			if ($result === true and $group_result === true){
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
						$result_attribute = $this->obj_product->addProductAttribute($insert_array['p_code'], $insert_ac);
					}
				}
				/**
				 * 更新商品发布数量的统计信息
				 */
				if($insert_array['p_state'] == '1'){
					$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'],'sell');
				}
				/**
				 * 判断返回路径
				 */
				$url = urlencode("../home/product_group.php?action=view&p_code=".$insert_array['p_code']);

				/**
				 * 成功发布商品 更新 积分内容
				 */
				CreditsClass::saveCreditsLog('succ_product_put',$_SESSION["s_login"]['id']);

				/**
				 * 返回链接
				 */
				$return_url = "own_product_group.php?action=operating_succ&url_sign=group&url={$url}&slPCId={$this->_input['pc_id']}";
				@header("Location: ".$return_url);
				exit;
			}else {
				$this->redirectPath("error","",$this->_lang['errPAddFail']);
			}
		}


	}
	/**
	 * 商品发布成功页面
	 *
	 * @param 
	 * @param 
	 * @return 
	 */
	function _operating_succ(){
		$show_page = "own_product.succ";
		/**
		 * 页面输出
		 */
		$this->output('url_sign',$this->_input['url_sign']);
		$this->output('slPCId',$this->_input['slPCId']);
		$this->output('url',$this->_input['url']);
		$this->showpage($show_page);
	}
	/**
	 * 拍卖商品列表
	 *
	 * @param 
	 * @return 
	 */
	function _list(){
		/**
		 * 语言包
		 */
		$this->getlang("product_manage");

		/**
		 * 更新商品上下架状态
		 */
		$this->obj_product->updateProductInCondition();
		/**
		 * 更新设定上架时间的商品
		 */
		$this->obj_product->updatePubTimeProduct();
		/**
		 * 设置查询参数
		 */
		$obj_condition['key'] = $this->_input['keyword'];
		$obj_condition['sell_type'] = '2';
		$obj_condition['member'] = $_SESSION['s_login']['id'];
		/**
		 * 取得产品列表
		 */
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		$this->obj_page->pagebarnum(20);
		$product_list = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');

		/**
		 * 判断列表中哪些商品已有人购买了
		 */
		if (is_array($product_list)) {
			foreach ($product_list as $k => $v){
				unset($condition);
				$condition['p_code'] = $v['p_code'];
				$condition['search_time'] = 1;
				$condition['start_time'] = $v['p_start_time'];
				$condition['end_time'] = $v['p_end_time'];
				$order = $this->obj_product_order->getProductOrderList($condition,$page);
				/**
				 * 判断在这次发布时是否有商品的竞拍信息，有则不允许修改和操作
				 */
				if (count($order) > 0) {
					$product_list[$k]['check_sign'] = 1;
				}
				unset($order,$condition);
				/**
				 * 输出到页面模板上的内容
				 */
				$product_list[$k]['p_add_time_ymd'] = date("Y-m-d",$v['p_add_time']);
				$product_list[$k]['p_start_time_ymd'] = date("Y-m-d",$v['p_start_time']);
				$product_list[$k]['p_end_time_ymd'] = date("Y-m-d",$v['p_end_time']);
			}
			unset($obj_product_bid);
		}

		/**
		 * 页面输出
		 */
		$this->output('product_array',$product_list);
		$this->output('page_list',$page_list);

		$this->showpage("own_product_group.list");
	}
	/**
	 * 仓库中的宝贝
	 *
	 * @param 
	 * @return 
	 */
	function _list_instock(){
		/**
		 * 设置查询参数
		 */
		$obj_condition['key'] = $this->_input['keyword'];
		$obj_condition['sell_type'] = '2';
		$obj_condition['state'] = '0';
		$obj_condition['member'] = $_SESSION['s_login']['id'];
		/**
		 * 取得产品列表
		 */
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		$this->obj_page->pagebarnum(20);
		$product_list = $this->obj_product->getProductList($obj_condition, $this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		/**
		 * 页面输出
		 */
		$this->output('product_array',$product_list);
		$this->output('page_list',$page_list);
		$this->showpage("own_product_group.list_instock");
	}
	/**
	 * 修改团购商品页面
	 *
	 */
	function _modigroupproduct() {
		/**
		 * 取商品信息
		 */
		$product_array = $this->obj_product->getProductRow($this->_input["p_code"]);
		/**
		 * 取团购商品扩展信息
		 */	
		$product_group_array = $this->obj_product->getProductGroupRow($this->_input['p_code']);
		/**
		 * 判断是否属于该会员
		 */
		if ($product_array['member_id'] != $_SESSION['s_login']['id']){
			$this->redirectPath("error","",$this->_lang['langPProductMemberErrRestartLogin']);
		}
		/**
		 * 判断是否有团购记录，如果有，则不允许修改 ====目前这里用的是竞拍的随后修改====
		 */
		if ($product_array['p_bid_num'] > 0){
			$this->redirectPath("error","",$this->_lang['errPProductIsLocked']);
		}
		/**
		 * 判断是否修改了类别，有类别ID传递过来，如果有，那么默认传递过来的类别ID为商品ID
		 */
		if ($this->_input['pc_id'] != ''){
			$product_array['pc_id'] = $this->_input['pc_id'];
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
		 * 这里p_id 为p_code
		 */
		$attribute_condition_str = " and p_id = '" . $this->_input["p_code"] . "'";
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
		$product_attribute = $obj_product_attribute->getParentAttributeContent($product_array['pc_id']);
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
			if ($content_sign == 1){//有内容
				$have_attribute = 1;
			}
			unset($content_sign);
		}
		unset($obj_product_attribute,$obj_product_attribute_content);

		/**
		 * 取商品类别内容
		 */
		$product_class_string = $this->_get_product_class_path($product_array["pc_id"]);

		/**
		 * 取货币种类
		 */
		$condition_exchange['exchange_name'] = $product_array['p_currency_category'];;
		$exchange_list = $this->obj_exchange->listExchange($condition_exchange,$page);
		$exchange_array = $exchange_list[0];

		/**
		 * 获得店铺宝贝分类
		 */
		if ($_SESSION['s_shop']['id'] != ''){
			$shop_product_category = $this->_getshopclass($_SESSION['s_shop']['id']);
		}

		//取支付方式
		if (is_array($this->_configinfo['payment'])){
			//取会员信息,用来验证显示的支付方式
			$condition['id'] = $product_array['member_id'];
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
					unset($class_name,$obj_p_module,$param_array);
				}
			}
		}
		/**
		 * 图片列表	商品编辑页调用小图
		 */
		$condition_pic['p_code'] = $product_array['p_code'];
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
		if ($product_array['p_area_id'] !=''){
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
		if (!empty($product_array['p_pb_id'])){
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
		 * 价格取整
		 */
		$product_array['p_price']		= (intval($product_array['p_price']) == $product_array['p_price']) ? intval($product_array['p_price']) : $product_array['p_price'];
		$product_array['p_group_price']	= (intval($product_array['p_group_price']) == $product_array['p_group_price']) ? intval($product_array['p_group_price']) : $product_array['p_group_price'];

		/**
		 * 页面输出
		 */
		$this->output("product_class_string", $product_class_string);
		$this->output("pc_id", $product_array['pc_id']);
		$this->output("product_array", $product_array);
		$this->output('product_group_array',$product_group_array);
		$this->output("sel_area", $sel_area);
		$this->output("area_array", $area_array);
		$this->output("pic_array", $pic_array);
		$this->output("pic_num", count($pic_array));//图片数量
		$this->output("payment_array", $payment_array);						//支付方式
		$this->output("pic_line", $pic_line);
		$this->output("shop_product_category",   $shop_product_category);
		$this->output("exchange_array", $exchange_array);
		$this->output("product_attribute", $product_attribute);
		$this->output("have_attribute", $have_attribute);
		$this->output("product_have_attribute", $pac_attribute);
		$this->output("sel_brand", $sel_brand);
		$this->output("brand_list", $brand_list);
		$this->showpage('own_product_group.add');
	}
	/**
	 * 更新团购商品信息
	 *
	 */
	function _updategroupproduct() {
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errPProductIsEmpty']),
		array("input"=>$this->_input["p_name"],"require"=>"true","message"=>$this->_lang['errPname']),
		array("input"=>$this->_input["pc_id"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPcidEmpty']),
		array("input"=>$this->_input["p_storage"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errPstorage']),
		array("input"=>$this->_input["p_area_id"],"require"=>"true","message"=>$this->_lang['errPProductAreaIsEmpty'])
		);
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 取原来商品的信息
			 */
			$old_product = $this->obj_product->getProductRow($this->_input['p_code']);
			/**
			 * 验证商品和会员是否一致
			 */
			if (($old_product['member_id'] != $_SESSION["s_login"]['id']) || empty($old_product)){
				$this->redirectPath("error","",$this->_lang['langPProductMemberErrRestartLogin']);
			}
			/**
			 * 处理上传图片
			 */
			/**
			 * 图片名数组
			 */
			$pic_arr=explode("|||",$this->_input["pichidden"]);
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
						$pic_value[$j]['p_code'] = $this->_input['p_code'];
						unset($arr,$arr_two);
						$j++;
					}
				}
			}
			/**
			 * 会员信息
			 */
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			/**
			 * 判断是否是推荐商品，如果没有剩余的推荐数量，那么将推荐属性清除
			 */
			if ($member_array['recommend_max_count']-$member_array['recommend_product_count'] <= 1){
				$this->_input['p_recommended'] = '0';
			}


			$group_start_time	= explode("-",$this->_input['cp_start_ymd']);	//将团购开始时间用数组切分
			$group_end_time		= explode("-",$this->_input['cp_end_ymd']);		//将团购结束时间用数组切分

			$update_array = array();
			$update_array['p_name'] 		= $this->_input['p_name'];			//商品名称
			$update_array['pc_id'] 			= $this->_input['pc_id'];
			$update_array['member_id']		= $_SESSION['s_login']['id'];		//会员id
			$update_array['login_name']		= $_SESSION['s_login']['name'];		//会员名称
			$update_array['p_code']			= $this->_input["p_code"];
			$update_array['p_price']		= $this->_input['cp_price'];		//原价
			$update_array['p_group_price']	= $this->_input['cp_group_price'];	//团购价
			$update_array['p_start_time'] = mktime(0,0,0,$group_start_time[1],$group_start_time[2],$group_start_time[0]);		//开始时间
			$update_array['p_end_time'] = mktime(0,0,0,$group_end_time[1],$group_end_time[2],$group_end_time[0]);			//结束时间
			$update_array['p_storage'] = $this->_input['p_storage'];			//库存
			$update_array['p_state'] = 1;										//状态
			$update_array['p_pic'] = $this->_input['p_pic'];					//图片
			$update_array['p_intro'] = $this->_input['p_intro'];				//商品内容描述
			$update_array['p_add_time'] = time();								//商品添加时间
			$update_array['p_update_time'] = time();							//商品更新时间
			if ($this->_input['txtPayment'] != '') {							//支付方式
				$update_array["p_pay_method"] = "|".@implode("|",$this->_input['txtPayment'])."|"; //支付方式
			}
			$update_array['p_sell_type'] = '2';
			$update_array['p_type'] = $this->_input['p_type'];
			$update_array['p_cur_price'] = $this->_input['p_price'];
			$update_array['p_system_step'] = $this->_input['p_system_step'];
			$update_array['p_price_step'] = ($this->_input['p_system_step']=='1')?$this->_input['p_price_step']:'0';
			$update_array['p_transfee_charge'] = '0';
			$update_array['p_have_invoices'] = $this->_input['p_have_invoices'];
			$update_array['p_have_warranty'] = $this->_input['p_have_warranty'];
			$update_array['p_recommended'] = $this->_input['p_recommended'];
			$update_array['p_remark'] = $this->_input['p_remark'];
			$update_array['p_class_id'] = $this->_input['p_class_id'];
			$update_array['p_currency_category'] = $this->_input['p_currency_category'];
			$update_array['p_area_id'] = $this->_input['p_area_id'];
			$update_array['p_pb_id'] = $this->_input['p_pb_id'];
			$update_array['p_genuine'] = $this->_input['p_genuine'];
			$update_array['p_7day_return'] = $this->_input['p_7day_return'];
			$update_array['p_keywords'] = $this->_input['p_keywords']?$this->_input['p_keywords']:$this->_input['p_name'];			//关键字
			$update_array['p_description'] = $this->_input['p_description']?$this->_input['p_description']:$this->_input['p_name'];	//描述
			/**
			 * 商品信息入库
			 */
			$result = $this->obj_product->updateProduct($update_array);

			/**
			 * 团购扩展信息插入
			 */
			$group_array			= array();
			$group_array['p_code']			= $update_array['p_code'];				//商品code
			$group_array['set_money']		= $this->_input['cp_set_money'];		//定金
			$group_array['min_count']		= $this->_input['cp_min_count'];		//最小购买人数
			$group_array['max_count']		= $this->_input['cp_max_count'];		//最大购买数量
			$group_array['product_comments']= $this->_input['cp_product_comments'];	//商品介绍
			$group_array['web_comments']	= $this->_input['cp_web_comments'];		//网站介绍

			$group_result = $this->obj_product->updateGroupProduct($group_array);
			unset($group_array);

			if ($result === true and $group_result === true){
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
				if($insert_array['p_state'] == '1'){
					$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'],'sell');
				}
				/**
				 * 判断返回路径
				 */
				$url = urlencode("../home/product_group.php?action=view&p_code=".$this->_input["p_code"]);

				/**
				 * 返回链接
				 */
				$return_url = "own_product_group.php?action=operating_succ&url={$url}&slPCId={$this->_input['pc_id']}";
				@header("Location: ".$return_url);
				exit;
			}else {
				$this->redirectPath("error","",$this->_lang['errPAddFail']);
			}
		}
	}
	/**
	 * 商品上架操作
	 *
	 * @param 
	 * @param 
	 * @return 
	 */
	function _onsale(){
		$this->_input["p_valid_days"] =  7;
		$this->_input["p_start_time"] = time();
		$this->_input["p_end_time"] =  Common::calculateDate("d", $this->_input["p_valid_days"], time());
		$this->_input["p_sold_num"] =  0;
		$this->_input["p_irregularities"] =  0;
		/**
		 * 如果商品数量为空，则返回错误
		 */
		if (count($this->_input['chboxPid']) == 0){
			$this->redirectPath("succ", '', $this->_lang['langPNotSelectProduct']);
		}

		/**
		 * 判断发布商品数量限制
		 */
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
		CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id'],array('sell_num'=>count($this->_input['chboxPid'])+$member_array['sell_product_count']));

		/**
		 * 如果开启了收费模式：按商品数量收费 则进行判断
		 */
		if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
			$member_array['product_number'] = $member_array['product_number']?$member_array['product_number']:0;
			$count_onsale = count($this->_input['chboxPid']);
			/**
			 * 如果上架商品和已商家商品数量相加大于 限制数量，则报错
			 */
			if ($member_array['product_number'] <= (count($member_product)+$count_onsale)){
				$this->redirectPath("error", './own_shop_pay.php?action=pay', $this->_lang['langPCanSaleNumberMax']);
			}
		}
		/**
		 * 更新商品上架状态以及参数内容
		 */
		$this->obj_product->changeProductState($this->_input, 1);
		//更新商品库存信息
		if (is_array($this->_input['chboxPid'])) {
			foreach ($this->_input['chboxPid'] as $pcode) {
				$update_array = array();
				$update_array['p_code'] = $pcode;
				/**
				 * 出售数量 拍卖 最少数量为2
				 */
				$update_array['p_storage'] = $this->_input['p_storage'][$pcode] > 0 ? $this->_input['p_storage'][$pcode] : 2;
				$update_array['p_price'] = $this->_input['p_price'][$pcode];
				/**
				 * 竞拍有效期
				 */
				$update_array['p_valid_days'] = $this->_input['p_valid_days'][$pcode];
				/**
				 * 更新商品
				 */
				$this->obj_product->updateProduct($update_array);
			}
		}
		/**
		 * 更新商品发布数量的统计信息
		 */
		$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'sell');
		/**
		 * 删除以往的该商品的竞拍信息
		 */
		if (!is_object($this->obj_product_bid)){
			require_once("bid.class.php");
			$this->obj_product_bid = new BidClass();
		}
		$this->obj_product_bid->delBid($this->_input['chboxPid']);

		$this->redirectPath("succ", '', $this->_lang['langProductMUpRackOk']);
	}
	/**
	 * 商品下架
	 *
	 * @param 
	 * @return 
	 */
	function _offsale(){
		/**
		 * 判断是否允许下架
		 */
		if (is_array($this->_input['chboxPid'])){
			foreach ($this->_input['chboxPid'] as $k => $value){
				/**
				 * 不允许下架
				 */
				if ($this->_input['check_sign'][$value] != ''){
					unset($this->_input['chboxPid'][$k]);
				}
			}
		}
		/**
		 * 当商品数量为空
		 */
		if (count($this->_input['chboxPid']) == 0){
			$this->redirectPath("error", '', $this->_lang['langPNotSelectProduct']);
		}
		/**
		 * 更新商品下架状态
		 */
		$this->obj_product->changeProductState($this->_input, '0');
		/**
		 * 更新商品发布数量、推荐商品数量的统计信息
		 */
		$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'both');

		$this->redirectPath("succ", '', $this->_lang['langProductMDownRackOk']);
	}
	/**
	 * 删除商品
	 *
	 * @param 
	 * @return 
	 */
	function _del(){
		if (is_array($this->_input['chboxPid'])){
			foreach ($this->_input['chboxPid'] as $value){
				$this->obj_validate->setValidate(array("input"=>$value,"require"=>"true","message"=>$this->_lang['errProductId']));
			}
		}
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			if (is_array($this->_input['chboxPid'])){
				foreach ($this->_input['chboxPid'] as $k => $value){
					if ($this->_input['check_sign'][$value] != ''){
						unset($this->_input['chboxPid'][$k]);
					}
				}
			}
			/**
			 * 判断是否为空
			 */
			if (empty($this->_input['chboxPid'])){
				$this->redirectPath("error","",$this->_lang['langPNotSelectProduct']);
			}
			$result = $this->obj_product->delProduct($this->_input['chboxPid'],$_SESSION['s_login']['id']);
			$group_result = $this->obj_product->delProductGroupExt($this->_input['chboxPid']);
			
			if($result and $group_result){
				/**
				 * 更新会员的发布商品数量
				 */
				$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'],'sell');
				$this->redirectPath("succ","member/own_product_group.php?action=".$this->_input['list_type'],$this->_lang['errPDelOk']);
			}else {
				$this->redirectPath("error","",$this->_lang['errPDelFail']);
			}
		}
	}
	/**
	 * 推荐和取消推荐操作
	 *
	 * @param 
	 * @return 
	 */
	function _set_recommended(){
		/**
		 * 推荐
		 */
		if ($this->_input['action'] == 'recommended'){
			$recommended = 1;
		}else {
			/**
			 * 取消推荐
			 */
			$recommended = 0;
		}

		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['errPSNotSelectBaby'])
		);
		$error = $this->obj_validate->validate();
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
					$this->redirectPath("succ","member/own_product_auction.php?action=list", $this->_lang['errPSCommendExceedShopwindowNum']);
				}
			}
			$this->_input['recommended'] = $recommended;
			$result = $this->obj_product->updateProductRecommended($this->_input);
			/**
			 * 更新推荐商品数量的统计信息
			 */
			$this->obj_product->updateProductStatistics($_SESSION['s_login']['id'], 'recommend');
			if($recommended == "1"){
				$info = $this->_lang['langPScommendedOk'];
			}else {
				$info = $this->_lang['langPScommendedIsFail'];
			}
			$this->redirectPath("succ","", $info);
		}
	}
	/**
	 * 店铺推荐操作
	 *
	 * @param 
	 * @return 
	 */
	function _set_store_recommended(){
		/**
		 * 推荐
		 */
		if ($this->_input['action'] == 'store_recommended'){
			$recommended = 1;
		}else {
			/**
			 * 取消推荐
			 */
			$recommended = 0;
		}
		/**
		 * 判断会员是否已有店铺，没有则返回错误
		 */
		if($_SESSION["s_shop"]['id'] == ''){
			$this->redirectPath('succ',"member/own_shop.php?action=new",$this->_lang['errPHaveNotShop']);
		}
		$this->obj_validate->validateparam = array(array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['errPSNotSelectBaby']));
		$error = $this->obj_validate->validate();
		if($error != '') {
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
			$this->redirectPath("error","../member/own_product.php?action=sell&p_code=".$this->_input['p_code'],$this->_lang['errPClassIdIsNotExist']);
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
			return trim($parent_class_string.'>>'.$product_class_string,'>>');
		}
	}
	/**
	 * 获取店铺商品分类
	 *
	 * @param int $shop_id 店铺ID
	 * @return 
	 */
	function _getShopClass($shop_id){
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
	 * 取商品属性
	 *
	 * @param $pc_id 商品类别ID
	 * @return 
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
	 * 更新商品数量
	 *
	 */
	function _updateproductcount(){
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errProductMUpdateCountFail']),
		array("input"=>$this->_input["p_storage"],"require"=>"true","message"=>$this->_lang['errProductMUpdateCountFail']));
		$error = $this->obj_validate->validate();
		if($error != ""){
			echo $error;
		}else{
			$update_array = array();
			$update_array['p_code'] = $this->_input['p_code'];
			$update_array['p_storage'] = $this->_input['p_storage'];
			$result = $this->obj_product->updateProduct($update_array);
			unset($update_array);
			if(!$result){
				echo $this->_lang['errProductMUpdateCountFail'];
			}
			echo $this->_lang['langProductMUpdateCountOk'];
		}
	}
	/**
	 * 批量更新商品数量
	 * 
	 */
	function _updateproductinfo() {
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["chboxPid"],"require"=>"true","message"=>$this->_lang['errPSNotSelectBaby']));
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			if (is_array($this->_input['chboxPid'])) {
				foreach ($this->_input['chboxPid'] as $p_code) {
					$update_array = array();
					$update_array['p_code'] = $p_code;
					$update_array['p_storage'] = $this->_input['p_storage'][$p_code];
					$result = $this->obj_product->updateProduct($update_array);
					unset($update_array);
					if(!$result){
						$this->redirectPath("error","",$this->_lang['errProductMUpdateInfoFail']);
					}
				}
			}
			$this->redirectPath("succ","member/own_product_group.php?action=list_instock",$this->_lang['langProductMUpdateInfoOk']);
		}
	}
}
$product_group = new OwnProductGroupManage();
$product_group->main();
unset($product_group);
?>