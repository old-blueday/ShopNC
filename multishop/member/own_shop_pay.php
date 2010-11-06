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
 * FILE_NAME : own_shop_pay.php   FILE_PATH : E:\www\multishop\trunk\member\own_shop_pay.php
 * ....卖家缴费
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Sun Jan 04 11:19:43 CST 2009
 */

require_once("../global.inc.php");

class OwnShopPay extends memberFrameWork{
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 卖家缴费对象
	 *
	 * @var obj
	 */
	var $obj_shop_pay;
	/**
	 * 商城支付方式对象
	 *
	 */
	var $obj_pay_mode;
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
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	
	function main(){
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 初始化缴费类
		 */
		if (!is_object($this->obj_shop_pay)){
			require_once("shop_pay.class.php");
			$this->obj_shop_pay = new shopPayClass();
		}
		/**
		 * 初始化支付方式类
		 */
		if (!is_object($this->obj_pay_mode)){
			require_once ("pay_accounts.class.php");
			$this->obj_pay_mode = new payAccountsClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("own_shop_pay");
		/**
		 * 判断是否开启店铺缴费模式，如果没开启，则不让访问
		 */
		if ($this->_configinfo['paymode']['shop_pay_mode'] == '0'){
			$this->redirectPath('error','',$this->_lang['langShopPayDetailFreeNotice']);
		}
		/**
		 * 菜单输出
		 */
		$this->memberMenu('seller','shop_pay','shop_pay_detail');
		
		switch ($this->_input['action']){
			case "pay":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','shop_pay','to_shop_pay');
				
				$this->_pay();
				break;
			case "pay_save":
				$this->_pay_save();
				break;
			case "detail_list":
				$this->_detail_list();
				break;
			case "online_continue_pay":
				$this->_online_continue_pay();
				break;
			case "detail_show":
				$this->_detail_show();
				break;
		}
	}
	
	/**
	 * 缴费充值
	 */
	function _pay(){
		//缴费条目列表
		//根据系统配置信息，取缴费类别
		$mode_array = $this->obj_shop_pay->listShopMode($condition,$page);
		unset($condition);
		//线下支付方式列表
		$condition['pay_type'] = 2;//线下类别
		$offline_pay = $this->obj_pay_mode->listLinePayMode($condition,$page);
		//取帐号配置文件信息
		$offline_array = $this->_getconfigini("payment.ini.php");
		unset($condition);
		//得到会员资料
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
		//店铺缴费
		if ($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
			if (($member_array['shop_availability_time']-time()) > 0){//取还可以使用的天数
				$use_day_num = intval(($member_array['shop_availability_time']-time())/(24*60*60));
			}
			if ($_SESSION["s_login"]['type'] == '1'){//是店铺的情况
				//店铺使用时间
				$member_array['shop_availability_time'] = $member_array['shop_availability_time']?@date('Y-m-d',$member_array['shop_availability_time']):@date('Y-m-d');
			}
			//取上架商品数量
			$obj_condition['member'] = $_SESSION['s_login']['id'];
			$product_array = $this->obj_product->getProductList($obj_condition, $obj_page);
			unset($obj_condition);
		}
		/**
		 * 页面输出
		 */
		$this->output('shop_pay_mode',$this->_configinfo['paymode']['shop_pay_mode']);
		$this->output('offline_pay',$offline_pay);
		$this->output('offline_array',$offline_array);
		$this->output('mode_array',$mode_array);
		$this->output('member_array',$member_array);
		$this->output('use_day_num',$use_day_num);
		$this->output('product_count',count($product_array));
		$this->showpage("own_shop_pay.pay");
	}
	
	/**
	 * 缴费充值
	 */
	function _pay_save(){
		//判断会员是否开店，如果没开，则不能按照店铺缴费
		$mode_array = $this->obj_shop_pay->getShopMode(intval($this->_input['pay_mode_id']));
		//店铺缴费方面的判断
		if (intval($mode_array['mode_shop_show_time']) > 0){
			//取店铺信息
			require_once('shop.class.php');
			$obj_shop = new ShopClass();
			$shop_array = $obj_shop->getOneShopByMemeberId($_SESSION["s_login"]['id']);
			if(empty($shop_array)){//没有店铺
				$this->redirectPath('error','',$this->_lang['errShopPayMemberIsNotShop']);
			}else{
				//判断店铺是否被删除
				if ($shop_array['if_del'] == '1'){
					$this->redirectPath('error','',$this->_lang['errShopPayShopIsDel']);
				}
				//判断是否关闭
				if($shop_array['ischeck'] == '0'){//审核
					$this->redirectPath('error','',$this->_lang['errShopPayShopCheckIsZero']);
				}
				if($shop_array['ischeck'] == '2'){//关闭
					$this->redirectPath('error','',$this->_lang['errShopPayShopCheckIsTwo']);
				}
			}
		}
		
		switch ($this->_input['pay_type']){
			case "online"://线上充值
				$this->_pay_save_online();
				break;
			case "offline"://线下充值
				$this->_pay_save_offline();
				break;
		}
	}
	
	/**
	 * 线上充值缴费操作
	 */
	function _pay_save_online(){
		/**
		 * 验证信息
		 */
		$this->obj_validate->setValidate(array("input"=>$this->_input["pay_mode_id"], "require"=>"true","validator"=>"Number","message"=>$this->_lang['errShopPayIdIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ''){
			$this->redirectPath('error','',$error);
		}else {
			if ($this->_input['online_type'] != ''){
				if (file_exists(BasePath.'/shoppay/'.$this->_input['online_type'].'/index.php')){
					//保存表单
					//取缴费条目内容
					$mode_array = $this->obj_shop_pay->getShopMode($this->_input['pay_mode_id']);
					if (empty($mode_array)){
						$this->redirectPath('error','',$this->_lang['errShopPayIdIsEmpty']);
					}
					//入库
					$value_array = array();
					$value_array['member_id'] = $_SESSION['s_login']['id'];//会员ID
					$value_array['pay_sign'] = '0';//充值状态，0未完成充值
					$value_array['pay_name'] = $this->_input['online_type'];//支付方式名称
					$value_array['pay_type'] = '1';//支付方式类型（1为在线支付方式，2为线下支付方式）
					$value_array['date_line'] = time();//提交时间
					$value_array['pay_mode_id'] = $mode_array['mode_id'];//缴费条目ID
					$value_array['pay_mode_name'] = $mode_array['mode_name'];//缴费名称
					$value_array['pay_mode_type'] = $mode_array['mode_type'];//缴费种类
					$value_array['pay_mode_money'] = $mode_array['mode_money'];//缴费金额
					
					$value_array['pay_mode_product_number'] = $mode_array['mode_product_number'];
					$value_array['pay_mode_shop_show_time'] = $mode_array['mode_shop_show_time'];
					
					$value_array['pay_mode_remark'] = $mode_array['mode_remark'];//缴费内容备注说明
					$result = $this->obj_shop_pay->addShopPayDetail($value_array);
					if ($result === true){
						//调用线上支付方式接口
						$this->_pay_to_online($value_array);
					}else {
						$this->redirectPath('error','',$this->_lang['errShopPayDetailAddFail']);
					}
				}else {
					$this->redirectPath('error','',$this->_lang['errShopPayDetailInterfaceIsEmpty']);
				}
			}else {
				$this->redirectPath('error','',$this->_lang['errShopPayDetailPaymentIsEmpty']);
			}
		}
	}
	
	/**
	 * 调用线上支付方式接口
	 */
	function _pay_to_online($value_array){
		//取该条记录
		$condition['date_line'] = $value_array['date_line'];
		$detail_array = $this->obj_shop_pay->listShopPayDetail($condition,$obj_page);
		if ($detail_array[0]['pay_detail_id'] != ''){
			header("Location: ../shoppay/".$detail_array[0]['pay_name'].'/index.php?pay_detail_id='.$detail_array[0]['pay_detail_id']);
		}else {
			$this->redirectPath('error','',$this->_lang['errShopPayDetailInfoIsEmpty']);
		}
	}
	
	/**
	 * 线下充值缴费操作
	 */
	function _pay_save_offline(){
		/**
		 * 验证信息
		 */
		$this->obj_validate->setValidate(array("input"=>$this->_input["offline_pay_id"], "require"=>"true","validator"=>"Number","message"=>$this->_lang['errShopPayDetailOfflinePayIdIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input["sender_number"], "require"=>"true","message"=>$this->_lang['errShopPayDetailSenderNumberIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input["pay_mode_id"], "require"=>"true","validator"=>"Number","message"=>$this->_lang['errShopPayIdIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ''){
			$this->redirectPath('error','',$error);
		}else {
			//取缴费条目内容
			$mode_array = $this->obj_shop_pay->getShopMode($this->_input['pay_mode_id']);
			if (empty($mode_array)){
				$this->redirectPath('error','',$this->_lang['errShopPayIdIsEmpty']);
			}
			//取线下充值帐号信息
			$offline_pay = $this->obj_pay_mode->getOneLinePay($this->_input['offline_pay_id']);
			if (empty($offline_pay)){
				$this->redirectPath('error','',$this->_lang['errShopPayDetailOfflinePayAccountIsEmpty']);
			}
			//入库
			$value_array = array();
			$value_array['member_id'] = $_SESSION['s_login']['id'];//会员ID
			$value_array['pay_sign'] = '1';//充值状态，1等待系统后台审核
			$value_array['pay_id'] = $this->_input['offline_pay_id'];//线下支付方式信息ID
			$value_array['pay_name'] = $offline_pay['pay_name'];//支付方式名称
			$value_array['pay_account'] = $offline_pay['pay_account'];//线下支付方式帐号
			$value_array['pay_consignee'] = $offline_pay['pay_consignee'];//线下接收人名称
			$value_array['pay_type'] = '2';//支付方式类型（1为在线支付方式，2为线下支付方式）
			$value_array['date_line'] = time();//提交时间
			$value_array['pay_mode_id'] = $mode_array['mode_id'];//缴费条目ID
			$value_array['pay_mode_name'] = $mode_array['mode_name'];//缴费名称
			$value_array['pay_mode_type'] = $mode_array['mode_type'];//缴费种类
			$value_array['pay_mode_money'] = $mode_array['mode_money'];//缴费金额
			$value_array['sender_number'] = $this->_input['sender_number'];//线下充值提交单据号
			
			$value_array['pay_mode_product_number'] = $mode_array['mode_product_number'];
			$value_array['pay_mode_shop_show_time'] = $mode_array['mode_shop_show_time'];
			
			$value_array['pay_mode_remark'] = $mode_array['mode_remark'];//缴费内容备注说明
			$result = $this->obj_shop_pay->addShopPayDetail($value_array);
			if ($result === true){
				$this->redirectPath('succ','./member/own_shop_pay.php?action=detail_list',$this->_lang['langShopPayDetailOfflinePaySucc']);
			}else {
				$this->redirectPath('error','',$this->_lang['errShopPayDetailAddFail']);
			}
		}
	}
	
	/**
	 * 缴费明细列表
	 */
	function _detail_list(){
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$condition['order_by'] = 'order by date_line desc';
		$this->obj_page->pagebarnum(15);
		$detail_array = $this->obj_shop_pay->listShopPayDetail($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		//格式化时间
		if (is_array($detail_array)){
			foreach ($detail_array as $k => $v){
				if ($v['date_line'] != ''){
					$detail_array[$k]['date_line'] = date('Y-m-d H:i:s',$v['date_line']);
				}
			}
		}
		
		/**
		 * 页面输出
		 */
		$this->output('page_list',$page_list);
		$this->output('detail_array',$detail_array);
		$this->showpage('own_shop_pay.detail_list');
	}
	
	/**
	 * 继续完成支付操作
	 */
	function _online_continue_pay(){
		$this->obj_validate->setValidate(array("input"=>$this->_input["pay_detail_id"], "require"=>"true","validator"=>"Number","message"=>$this->_lang['errShopPayDetailIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ''){
			$this->redirectPath('error','',$error);
		}else {
			$detail_array = $this->obj_shop_pay->getShopPayDetail($this->_input['pay_detail_id']);
			if ($detail_array['member_id'] != $_SESSION['s_login']['id']){
				$this->redirectPath("error","",$this->_lang['errShopPayDetailInfoIsEmpty']);
			}
			//调用线上支付方式接口
			$this->_pay_to_online($detail_array);
		}
	}
	
	/**
	 * 查看缴费明细详情
	 */
	function _detail_show(){
		$this->obj_validate->setValidate(array("input"=>$this->_input["pay_detail_id"], "require"=>"true","validator"=>"Number","message"=>$this->_lang['errShopPayDetailIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ''){
			$this->redirectPath('error','',$error);
		}else {
			$detail_array = $this->obj_shop_pay->getShopPayDetail($this->_input['pay_detail_id']);
			if ($detail_array['member_id'] != $_SESSION['s_login']['id']){
				$this->redirectPath("error","",$this->_lang['errShopPayDetailInfoIsEmpty']);
			}
			//格式化时间
			if ($detail_array['date_line'] != ''){
				$detail_array['date_line'] = date('Y-m-d H:i:s',$detail_array['date_line']);
			}
			/**
			 * 页面输出
			 */
			$this->output('detail_array',$detail_array);
			$this->showpage('own_shop_pay.detail_show');
		}
	}
}
$shop_pay_manage = new OwnShopPay();
$shop_pay_manage->main();
unset($shop_pay_manage);
?>