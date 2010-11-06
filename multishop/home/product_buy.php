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
 * FILE_NAME : product_buy.php   FILE_PATH : E:\www\multishop\trunk\home\product_buy.php
 * ....商品购买流程
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Tue Feb 24 15:15:23 CST 2009
 */
require ("../global.inc.php");

class ProductBuy extends CommonFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
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
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;

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

		//判断用户组权限
		CheckPermission::memberGroupPermission('buy',$_SESSION['s_login']['id']);

		/**
		 * 语言包
		 */
		$this->getlang("product");

		switch ($this->_input['action']){
			case "buy":
				$this->_buyproduct();
				break;
			case "order":
				$this->_orderproduct();
				break;
		}
	}

	/**
	 * 商品购买页面
	 *
	 */
	function _buyproduct(){
		/**
		 * 判断是否登陆
		 */
		$this->isMember();

		//判断会员是否和卖家相同
		if($_SESSION['s_login']['id'] == $this->_input["seller_id"]){
			$this->redirectPath("error","",$this->_lang['errBuyOwnProduct']);
		}
		//判断商品是否为空
		if ($this->_input['item_id'] == ''){
			$this->redirectPath("error","../index.html",$this->_lang['errProductInfoEmpty']);
		}
		//取商品信息
		$product_array = $this->obj_product->getProductRow($this->_input['item_id']);
		//判断商品上架状态
		if ($product_array['p_state'] == '0' || ($product_array['p_end_time'] - time()) < 0){
			$this->redirectPath("error","",$this->_lang['langProductStateIsZero']);
		}
		//交易类型
		$sell_type = $this->_input['auction_type'];

		//判断商品交易类别 调用对应的操作类
		switch ($sell_type){
			case '0'://拍卖
			require_once('order_process_auction.class.php');
			$obj_order_process = new OrderProcessAuction();
			break;
			case '1'://一口价
			require_once('order_process_fixprice.class.php');
			$obj_order_process = new OrderProcessFixprice();
			break;
			case '2'://团购
			require_once('order_process_group.class.php');
			$obj_order_process = new OrderProcessGroup();
			break;
			default:
				exit;
		}
		//需要输出的内容
		$obj_order_process->_lang = $this->_lang;//语言包
		$output = $obj_order_process->buy($this->_input);
		//判断抛出错误
		if ($output['error'] == '1'){
			$this->redirectPath ( "error", '', $output['error_msg']);
		}
		//地区内容
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
		//取收货地址 地区
		$receive_array = $this->obj_receive->getReceive($_SESSION['s_login']['id']);
		if (is_array($receive_array)){
			//取地区内容
			if (!is_object($this->obj_area)){
				require_once ("area.class.php");
				$this->obj_area = new AreaClass();
			}
			foreach ($receive_array as $k => $v){
				//取已选择的地区内容
				if ($v['receive_area_id'] !=''){
					$receive_array[$k]['sel_area'] = $this->obj_area->getAreaPathList($v['receive_area_id']);
				}
			}
		}

		//判断商品是否存在图片
		if (file_exists('../'.$this->_input['photo_url']) && $this->_input['photo_url'] !=''){
			//取商品缩略图
			if ($this->_input['photo_url'] != ""){
				$line = explode('.',$this->_input['photo_url']);
				if (file_exists('../'.$line[0].'_mid'.'.'.$line[1])){
					if (file_exists('../'.$line[0].'_mid'.'.'.$line[1])){
						$this->_input['photo_mid_url'] = $line[0].'_mid'.'.'.$line[1];
					}
				}
				unset($line);
			}
			//判断缩略图宽高，按比例缩小
			$image_array = @getimagesize('../'.$this->_input['photo_url']);
			if ($image_array[0] != 0 && $image_array[1] != 0){
				if ($image_array[0] >= $image_array[1]) {/*宽 > 高*/
					$p_pic_width = 150;
					$p_pic_height = @number_format($image_array[1]/($image_array[0]/150),0);
				}else if ($image_array[0] <= $image_array[1]) {
					$p_pic_width = @number_format($image_array[0]/($image_array[1]/150),0);
					$p_pic_height = 150;
				}
			}
		}
		/**
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}
		//去货币对应中文名称的数组
		$exchange_remark = $this->obj_exchange->getExchangeArray();

		//接页面传过来的支付方式和货币种类
		if (is_array($this->_input['payment'])){
			$i=0;
			foreach ($this->_input['payment'] as $k => $v){
				if (file_exists(BasePath.'/payment/'.$v."/payment_module.php") && $this->_configinfo['payment'][$v] == 1) {
					include_once (BasePath.'/payment/'.$v."/payment_module.php");
					$classname = $v."PaymentMethod";
					$obj_module = new $classname;
					$array = $obj_module->payment_param();
					//判断货币种类是否有值，如果没有
					if (!empty($array['currency'])){
						$j=0;
						$currency_array = "";
						foreach ($array['currency'] as $k2 => $v2){
							if ($this->_input['currency'][$v2] != ''){
								$currency_array[$v2] = $this->_input['currency'][$v2];
							}
						}
						$payment_array[$k]['name'] = $array['name'];
						$payment_array[$k]['currency'] = $currency_array;
						unset($currency_array);
						if ($i == '0'){
							$payment_array[$k]['check'] = 1;
						}
						$i++;
					}
					unset($obj_module,$array);
				}
			}
		}else {
			$this->redirectPath("error","",$this->_lang['errPPaymentIsEmpty']);
		}

		//如果支持预付款
		if ($this->_configinfo['payment']['predeposit'] == '1' && !empty($this->_input['payment']['predeposit'])){
			$payment_array['predeposit']['name'] = $this->_lang['langPPredeposit'];
			$payment_array['predeposit']['currency']['CNY'] = $this->_input['currency']['CNY'];
			if (count($payment_array) == 1){
				$payment_array['predeposit']['check'] = 1;
			}
			//取会员可用资金
			$condition_member['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');

			//用于预付款支付进行比较的价格
			if ($product_array['p_sell_type'] == '1'){//一口价
				$predeposit_price = $product_array['p_price'];
			}else if ($product_array['p_sell_type'] == '0') {//拍卖
				$predeposit_price = $product_array['p_cur_price'];
			}else if ($product_array['p_sell_type'] == '2') {//团购
				$predeposit_price = $product_array['p_group_price'];
			}
		}
		//卖家信息
		$seller_info = $this->obj_member->getMemberInfo(array("id"=>$this->_input['seller_id']),'login_name');
		/**
		 * 买家支付运费 在有收货地址的前提下
		 */
		if ($product_array['p_transfee_charge'] == '1'){
			/**
			 * 取运费模板内容
			 */
			if ($product_array['use_postage'] == '1'){
				$postage_content = $use_postage_content = unserialize($product_array['use_postage_content']);
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
								}else {
									/**
									 * 不存在运费，使用默认运费
									 */
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
								unset($tmp_array);
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
		 * 页面输出
		 */
		$this->output('use_postage_content',$use_postage_content);
		$this->output('postage_transfee',$postage_transfee);
		$this->output('exchange_remark',$exchange_remark);
		$this->output('predeposit_price',$predeposit_price);
		$this->output('member_array',$member_array);
		$this->output('payment_array',$payment_array);
		$this->output('receive_array',$receive_array);
		$this->output("p_code", $this->_input['item_id']);
		$this->output("pc_id", $this->_input['pc_id']);
		$this->output("sell_type", $this->_input['auction_type']);
		$this->output("p_name", $this->_input['title']);
		$this->output("member_id", $this->_input['seller_id']);
		$this->output("seller_nick", $seller_info['login_name']);
		$this->output("p_transfee_charge", $this->_input['who_pay_ship']);
		$this->output("buy_price", $output['buy_now']);
		$this->output("min_price", $output['min_price']);
		$this->output("step_price", $output['increment']);
		$this->output("p_group_mincount", $this->_input['min_count']);
		$this->output("p_sold_num", $this->_input['p_sold_num']);
		$this->output("p_storage", $product_array['p_storage']);
		$this->output("p_pic", $this->_input['photo_url']);
		$this->output("p_pic_width", $p_pic_width);
		$this->output("p_pic_height", $p_pic_height);
		$this->output("p_mid_pic", $this->_input['photo_mid_url']);
		$this->output("p_region", $this->_input['region']);
		$this->output("tf_py", $this->_input['tf_py']);
		$this->output("tf_kd", $this->_input['tf_kd']);
		$this->output("tf_ems", $this->_input['tf_ems']);
		$this->output("top_cate", $this->_input['chboxPid']);
		$this->output("area_array", $area_array);
		$this->showpage("product.buy");
	}
	/**
	 * 商品购买提交
	 *
	 */
	function _orderproduct(){
		/**
		 * 验证表单信息
		 */
		if("" == $this->_input["txtTfFee"]){
			$this->_input["txtTfFee"] = '0';
		}
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["txtSellerId"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errSellerId']),
		array("input"=>strtoupper($this->_input['checkcode']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['alertCodeErr']),
		array("input"=>$this->_input["txtPname"],"require"=>"true","message"=>$this->_lang['errPname']),
		array("input"=>$this->_input["txtPcode"],"require"=>"true","message"=>$this->_lang['errPcode']),
		array("input"=>$this->_input["txtBuyNum"],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errBuyNum']),
		array("input"=>$this->_input["txtTfFee"],"require"=>"true","message"=>$this->_lang['errTfFee']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			//收货地址
			if("" != $this->_input["checkaddr"]){//更新
				$this->_input["txtReceiveId"] = $this->_input["daddr"];
				if ($this->_input['txtAddress'] != ''){
					//更新收货地址
					//取收货地址ID
					$condition_receive['member_id'] = $_SESSION['s_login']['id'];
					$condition_receive['receive_code'] = $this->_input["daddr"];
					$receive_arr = $this->obj_receive->getAllReceive($condition_receive,$page);
					$this->_input['receive_id'] = $receive_arr[0]['receive_id'];
					$this->obj_receive->modiReceive($this->_input);
					unset($receive_arr);
				}
			}else{//新增
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
				$this->_input["txtRcode"] = md5($receive_last_id.$random_string);
				$this->_input["member_id"] = $_SESSION['s_login']['id'];
				$this->obj_receive->addReceive($this->_input);
				$this->_input["txtReceiveId"] = $this->_input["txtRcode"];
			}

			/**
			 * 取得商品信息
			 */
			$product_row = $this->obj_product->getProductRow($this->_input["txtPcode"]);

			//买家会员ID
			$this->_input["txtBuyerId"] = $_SESSION['s_login']['id'];
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
			$condition_member['id'] = $this->_input['txtSellerId'];
			$seller_array = $this->obj_member->getMemberInfo($condition_member,'login_name');
			$this->_input['seller_name'] = $seller_array['login_name'];
			unset($condition_member);
			//订单留言内容
			$this->_input['leaveword'] = Common::replacebr($this->_input['leaveword']);
			/**
			 * 判断商品出售类别执行分支流程
			 */
			switch ($this->_input["sell_type"]){
				case '0'://拍卖
				require_once('order_process_auction.class.php');
				$obj_order_process = new OrderProcessAuction();
				break;
				case '1'://一口价
				require_once('order_process_fixprice.class.php');
				$obj_order_process = new OrderProcessFixprice();
				break;
				case '2'://团购
				require_once('order_process_group.class.php');
				$obj_order_process = new OrderProcessGroup();
				break;
				default:
					exit;
			}
			//生成订单
			$obj_order_process->_lang = $this->_lang;//语言包
			$result = $obj_order_process->order($this->_input);
			if ($result['error'] == '1'){
				$this->redirectPath('error','',$result['error_msg']);
			}else {

				/**
				 * UC推送购买商品信息
				 */
				if ($this->makeFeed('buygoods')){
					//商品信息参数
					$subject_url = $this->_configinfo['websit']['site_url'].'/home/product.php?action=view&pid='.$this->_input["txtPcode"];
					define('UC_APPID',$this->_configinfo['ucenter']['uc_appid']);
					$feed_param = array(
					'icon'=>'profile',
					'uid'=>$_SESSION['s_login']['id'],
					'username'=>$_SESSION['s_login']['name'],
					'title_template'=>'{actor}'.$this->_lang['langProductBuy'].'{subject}',
					'title_data'	=> array('subject'=>'<a href="'.$subject_url.'">'.$this->_input['txtPname'].'</a>'),
					'images'		=> array(array('url'=>$this->_configinfo['websit']['site_url'].'/'.($product_row['p_pic']!='' ? $product_row['p_pic'] : 'templates/orange/images/noimgb.gif'),'link'=>$subject_url))
					);

					require_once('ucenter.class.php');
					$obj_ucenter = new ucenterClass();
					$obj_ucenter->uc_feed($feed_param);
					unset($obj_ucenter);
				}

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
}
$product_buy = new ProductBuy();
$product_buy->main();
unset($product_buy);
?>