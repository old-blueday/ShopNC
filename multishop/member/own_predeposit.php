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
 * FILE_NAME : own_predeposit.php   FILE_PATH : E:\www\multishop\trunk\member\own_predeposit.php
 * ....会员预存款操作
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Sep 01 14:02:15 CST 2008
 */

require ("../global.inc.php");
class OwnPredeposit extends memberFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 分页对象
	 *
	 */
	var $obj_page;
	/**
	 * 预存款对象
	 *
	 */
	var $obj_predeposit;
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

	function main(){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 初始化预存款类
		 */
		if (!is_object($this->obj_predeposit)){
			require_once("predeposit.class.php");
			$this->obj_predeposit = new PredepositClass();
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
		 * 语言包
		 */
		$this->getlang("own_predeposit");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "list":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','pre_detail_view');

				$this->_list();
				break;
			case "pay":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','to_pre_pay');

				$this->_pay();
				break;
			case "pay_save":
				$this->_pay_save();
				break;
			case "detail_view":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','pre_detail_view');

				$this->_detail_view();
				break;
			case "record_list":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','pre_record_view');

				$this->_record_list();
				break;
			case "record_view":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','pre_record_view');

				$this->_record_view();
				break;
			case "record_online_pay":
				$this->_record_online_pay();
				break;
			case "ajax_get_predeposit":
				$this->_ajax_get_predeposit();
				break;
			case "cash_list":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','pre_cash_view');

				$this->_cash_list();
				break;
			case "cash_view":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','pre_cash_view');

				$this->_cash_view();
				break;
			case "cash_set":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('account','predeposit','to_pre_cash');

				$this->_cash_set();
				break;
			case "cash_save":
				$this->_cash_save();
				break;
		}
	}

	/**
	 * 预存款明细列表
	 */
	function _list(){
		//搜索条件
		if ($this->_input['search_start_date'] != '' || $this->_input['search_end_date'] != ''){//时间
			if ($this->_input['search_start_date'] != ''){//开始时间
				$time = explode('-',$this->_input['search_start_date']);
				$condition['start_create_time'] = mktime(0,0,0,$time[1],$time[2],$time[0]);
			}
			if ($this->_input['search_end_date'] != ''){//结束时间
				$time = explode('-',$this->_input['search_end_date']);
				$condition['end_create_time'] = mktime(0,0,0,$time[1],$time[2],$time[0]);
			}
			unset($time);
		}
		//明细类别
		if($this->_input['search_detail_type'] != ''){
			$condition['predeposit_type'] = $this->_input['search_detail_type'];
		}
		//明细状态
		if($this->_input['search_detail_state'] != ''){
			$condition['predeposit_state'] = $this->_input['search_detail_state'];
		}
		//取预存款明细
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$condition['order_by'] = " order by create_time desc";
		$this->obj_page->pagebarnum(15);
		$predeposit_array = $this->obj_predeposit->listPredopesit($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		//格式化时间
		if (is_array($predeposit_array)){
			for ($i=0;$i<count($predeposit_array);$i++){
				$predeposit_array[$i]['create_time'] = date("Y-m-d",$predeposit_array[$i]['create_time']);
				$predeposit_array[$i]['update_time'] = date("Y-m-d",$predeposit_array[$i]['update_time']);
			}
		}
		//取会员信息
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		/**
		 * 页面输出
		 */
		$this->output('detail_type',$this->_b_config['predeposit_detail_type']);
		$this->output('detail_state',$this->_b_config['predeposit_detail_state']);
		$this->output('member_array',$member_array);
		$this->output('predeposit_array',$predeposit_array);
		$this->output('page_list',$page_list);
		$this->showpage('own_predeposit.list');
	}

	/**
	 * 充值
	 */
	function _pay(){
		//线下支付方式列表
		$offline_pay = $this->obj_pay_mode->listLinePayMode($condition,$page);
		//取帐号配置文件信息
		$offline_array = $this->_getconfigini("payment.ini.php");
		/**
		 * 页面输出
		 */
		$this->output('offline_pay',$offline_pay);
		$this->output('offline_array',$offline_array);
		$this->showpage('own_predeposit.pay');
	}

	/**
	 * 线上跳转到支付平台，线下保存提交的表单
	 */
	function _pay_save(){
		if ($this->_input['pay_type'] == 'online'){//线上
			if ($this->_input['online_type'] != ''){
				if (file_exists(BasePath.'/predeposit_pay/'.$this->_input['online_type'].'/index.php')){
					//保存表单
					$value_array = array();
					$value_array['member_id'] = $_SESSION['s_login']['id'];
					$value_array['payment'] = $this->_input['online_type'];
					$value_array['payment_type'] = '0';
					$value_array['record_state'] = '0';
					$value_array['create_time'] = time();
					$value_array['online_amount'] = $this->_input['online_amount'];
					$result = $this->obj_predeposit->addPredepositRecord($value_array);
					if ($result === true){
						//取该条记录
						$condition['create_time'] = $value_array['create_time'];
						$record_array = $this->obj_predeposit->listPredepositRecord($condition,$obj_page);

						if ($record_array[0]['predeposit_r_id'] != ''){
							@header("Location: ../predeposit_pay/".$this->_input['online_type'].'/index.php?predeposit_r_id='.$record_array[0]['predeposit_r_id']);
						}else {
							$this->redirectPath('error','',$this->_lang['langPreInfoIsEmpty']);
						}
					}else {
						$this->redirectPath('error','',$this->_lang['langPreOparetIsFaild']);
					}
				}else {
					$this->redirectPath('error','',$this->_lang['langPrePaymentInterfaceIsEmpty']);
				}
			}
		}else if ($this->_input['pay_type'] == 'offline'){//线下
			/**
			 * 验证提交的数据
			 */
			$this->obj_validate->setValidate(array("input"=>$this->_input['txt_sender_name'],"require"=>"true","message"=>$this->_lang['langPreSenderNameIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input['txt_sender_bank'],"require"=>"true","message"=>$this->_lang['langPreSenderBankIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input['txt_sender_amount'],"require"=>"true","message"=>$this->_lang['langPreSenderAmountIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input['txt_sender_date'],"require"=>"true","message"=>$this->_lang['langPreSenderDateIsEmpty']));
			$error = $this->obj_validate->validate();
			if ($error != ""){
				$this->redirectPath('error','',$error);
			}else {
				//转换时间
				$time = explode('-',$this->_input['txt_sender_date']);
				$time = mktime(23,59,59,$time[1],$time[2],$time[0]);
				//保存表单
				$value_array = array();
				$value_array['member_id'] = $_SESSION['s_login']['id'];
				$value_array['payment'] = 'offline';
				$value_array['sender_name'] = $this->_input['txt_sender_name'];
				$value_array['sender_bank'] = $this->_input['txt_sender_bank'];
				$value_array['sender_amount'] = $this->_input['txt_sender_amount'];
				$value_array['sender_date'] = $time;
				$value_array['sender_remark'] = Common::replacebr($this->_input['txt_sender_remark']);
				$value_array['pay_name'] = $this->_input['pay_name_'.$this->_input['offline_pay_id']];
				$value_array['pay_account'] = $this->_input['pay_account_'.$this->_input['offline_pay_id']];
				$value_array['pay_consignee'] = $this->_input['pay_consignee_'.$this->_input['offline_pay_id']];
				$value_array['payment_type'] = '1';
				$value_array['create_time'] = time();
				$result = $this->obj_predeposit->addPredepositRecord($value_array);
				if ($result === true){
					$this->redirectPath('succ','',$this->_lang['langPreRecordIsSucc']);
				}else {
					$this->redirectPath('error','',$this->_lang['langPreRecordIsFail']);
				}
			}
		}
	}

	/**
	 * 明细详情
	 */
	function _detail_view(){
		if (intval($this->_input['id']) > 0){
			//明细信息
			$detail_array = $this->obj_predeposit->getOnePredepositDetailById($this->_input['id']);
			if ($detail_array['member_id'] != $_SESSION['s_login']['id']){
				$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
			}

			//时间格式化
			$detail_array['create_time'] = date("Y-m-d",$detail_array['create_time']);
			$detail_array['update_time'] = date("Y-m-d",$detail_array['update_time']);
			//取会员信息
			$condition_member['id'] = $detail_array['member_id'];
			$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
			unset($condition_member);
			//取交易对象的会员信息
			if ($detail_array['to_member_id'] != ''){
				$condition_member['id'] = $detail_array['to_member_id'];
				$to_member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
				unset($condition_member);
			}
			//充值信息
			if ($detail_array['predeposit_r_id'] != ''){
				//取记录内容
				$record_array = $this->obj_predeposit->getOnePredepositRecordById($detail_array['predeposit_r_id']);
				$record_array['create_time'] = date("Y-m-d",$record_array['create_time']);
				$record_array['sender_date'] = date("Y-m-d",$record_array['sender_date']);
			}
			//获取商品信息
			if ($detail_array['p_code'] != '') {
				include_once("product.class.php");
				$obj_product = new ProductClass();
				$product_array = $obj_product->getProductRow($detail_array['p_code']);
				$product_array['link'] = $this->_configinfo['websit']['site_url'] . "/home/product.php?action=view&pid=" . $product_array['p_code'];
				unset($obj_product);
			}
			/**
			 * 页面输出
			 */
			$this->output('detail_type',$this->_b_config['predeposit_detail_type']);
			$this->output('detail_state',$this->_b_config['predeposit_detail_state']);
			$this->output('predeposit_record_state',$this->_b_config['predeposit_record_state']);
			$this->output('detail_array',$detail_array);
			$this->output('member_array',$member_array);
			$this->output('record_array',$record_array);
			$this->output('to_member_array',$to_member_array);
			$this->output('product_array',$product_array);
			$this->showpage('own_predeposit.detail_view');
		}else {
			$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
		}
	}

	/**
	 * 申请记录
	 */
	function _record_list(){
		//搜索条件
		if ($this->_input['search_start_date'] != '' || $this->_input['search_end_date'] != ''){//时间
			if ($this->_input['search_start_date'] != ''){//开始时间
				$time = explode('-',$this->_input['search_start_date']);
				$condition['start_create_time'] = mktime(0,0,0,$time[1],$time[2],$time[0]);
			}
			if ($this->_input['search_end_date'] != ''){//结束时间
				$time = explode('-',$this->_input['search_end_date']);
				$condition['end_create_time'] = mktime(0,0,0,$time[1],$time[2],$time[0]);
			}
			unset($time);
		}
		//充值方式
		if($this->_input['search_record_type'] != ''){
			$condition['payment'] = $this->_input['search_record_type'];
		}
		//记录状态
		if($this->_input['search_record_state'] != ''){
			$condition['record_state'] = $this->_input['search_record_state'];
		}
		//信息列表
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$condition['order_by'] = " order by create_time desc";
		$this->obj_page->pagebarnum(15);
		$record_array = $this->obj_predeposit->listPredepositRecord($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		//格式化时间
		if (is_array($record_array)){
			for ($i=0;$i<count($record_array);$i++){
				$record_array[$i]['create_time'] = date("Y-m-d",$record_array[$i]['create_time']);
			}
		}
		//取会员信息
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		/**
		 * 页面输出
		 */
		$this->output('predeposit_record_state',$this->_b_config['predeposit_record_state']);
		$this->output('record_array',$record_array);
		$this->output('page_list',$page_list);
		$this->output('member_array',$member_array);
		$this->showpage("own_predeposit.record_list");
	}

	/**
	 * 充值信息查看
	 */
	function _record_view(){
		if (intval($this->_input['id']) > 0){
			//取记录内容
			$record_array = $this->obj_predeposit->getOnePredepositRecordById($this->_input['id']);
			if ($record_array['member_id'] != $_SESSION['s_login']['id']){
				$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
			}

			$record_array['create_time'] = date("Y-m-d",$record_array['create_time']);
			$record_array['sender_date'] = date("Y-m-d",$record_array['sender_date']);
			//取会员信息
			$condition['id'] = $record_array['member_id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			/**
			 * 页面输出
			 */
			$this->output('predeposit_record_state',$this->_b_config['predeposit_record_state']);
			$this->output('member_array',$member_array);
			$this->output('record_array',$record_array);
			$this->showpage('own_predeposit.record_view');
		}else {
			$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
		}
	}

	/**
	 * 线上支付方式支付
	 */
	function _record_online_pay(){
		if (intval($this->_input['id']) > 0){
			//取记录内容
			$record_array = $this->obj_predeposit->getOnePredepositRecordById($this->_input['id']);
			if (file_exists(BasePath.'/predeposit_pay/'.$record_array['payment'].'/index.php')){
				header("Location: ../predeposit_pay/".$record_array['payment'].'/index.php?predeposit_r_id='.$record_array['predeposit_r_id']);
			}else {
				$this->redirectPath('error','',$this->_lang['langPrePaymentInterfaceIsEmpty']);
			}
		}else {
			$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
		}
	}

	/**
	 * 购买商品时充值返回的可用资金查询
	 */
	function _ajax_get_predeposit(){
		//取会员可用资金
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		echo "{\"message\":\"". $member_array['available_predeposit'] ."\",\"type\":\"1\"}";
	}

	/**
	 * 提现明细列表
	 */
	function _cash_list(){
		//搜索条件
		if ($this->_input['search_start_date'] != '' || $this->_input['search_end_date'] != ''){//时间
			if ($this->_input['search_start_date'] != ''){//开始时间
				$time = explode('-',$this->_input['search_start_date']);
				$condition['start_create_time'] = mktime(0,0,0,$time[1],$time[2],$time[0]);
			}
			if ($this->_input['search_end_date'] != ''){//结束时间
				$time = explode('-',$this->_input['search_end_date']);
				$condition['end_create_time'] = mktime(0,0,0,$time[1],$time[2],$time[0]);
			}
			unset($time);
		}
		//提现方式
		if($this->_input['search_cash_type'] != ''){
			$condition['payment'] = $this->_input['search_cash_type'];
		}
		//状态
		if($this->_input['search_cash_state'] != ''){
			$condition['record_state'] = $this->_input['search_cash_state'];
		}
		//信息列表
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$condition['order_by'] = " order by create_time desc";
		$this->obj_page->pagebarnum(15);
		$cash_array = $this->obj_predeposit->listPredepositCash($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		//格式化时间
		if (is_array($cash_array)){
			for ($i=0;$i<count($cash_array);$i++){
				$cash_array[$i]['create_time'] = date("Y-m-d",$cash_array[$i]['create_time']);
			}
		}
		//取会员信息
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		/**
		 * 页面输出
		 */
		$this->output('predeposit_detail_state',$this->_b_config['predeposit_detail_state']);
		$this->output('cash_array',$cash_array);
		$this->output('page_list',$page_list);
		$this->output('member_array',$member_array);
		$this->showpage("own_predeposit.cash_list");
	}

	/**
	 * 提现记录查看
	 */
	function _cash_view(){
		if (intval($this->_input['id']) > 0){
			//取记录内容
			$cash_array = $this->obj_predeposit->getOnePredepositCashById($this->_input['id']);
			if ($cash_array['member_id'] != $_SESSION['s_login']['id']){
				$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
			}
			$cash_array['create_time'] = date("Y-m-d",$cash_array['create_time']);
			//取会员信息
			$condition['id'] = $cash_array['member_id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			/**
			 * 页面输出
			 */
			$this->output('predeposit_record_state',$this->_b_config['predeposit_record_state']);
			$this->output('member_array',$member_array);
			$this->output('cash_array',$cash_array);
			$this->showpage('own_predeposit.cash_view');
		}else {
			$this->redirectPath('error','',$this->_lang['langPreIdIsVoid']);
		}
	}


	/**
	 * 提交提现申请
	 */
	function _cash_set(){
		//取会员信息
		$condition_member['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
		/**
		 * 页面输出
		 */
		$this->output('member_array',$member_array);
		$this->showpage('own_predeposit.cash_set');
	}

	/**
	 * 保存提现记录
	 */
	function _cash_save(){
		/**
		 * 验证提交的数据
		 */
		$this->obj_validate->setValidate(array("input"=>$this->_input['amount'],"require"=>"true","message"=>$this->_lang['langPreAmountIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['pay_account'],"require"=>"true","message"=>$this->_lang['langPrePayAccountIsEmpty']));
		if ($this->_input['pay_type'] == 'offline'){
			$this->obj_validate->setValidate(array("input"=>$this->_input['txt_pay_consignee'],"require"=>"true","message"=>$this->_lang['langPrePayConsigneeIsEmpty']));
			$this->obj_validate->setValidate(array("input"=>$this->_input['txt_pay_bank'],"require"=>"true","message"=>$this->_lang['langPrePayBankIsEmpty']));
		}
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath('error','',$error);
		}else {
			if ($this->_input['pay_type'] == 'online'){//线上
				if ($this->_input['online_type'] != ''){
					//保存表单
					$value_array = array();
					$value_array['member_id'] = $_SESSION['s_login']['id'];
					$value_array['payment'] = $this->_input['online_type'];
					$value_array['payment_type'] = '0';
					$value_array['record_state'] = '0';
					$value_array['pay_account'] = $this->_input['pay_account'];
					$value_array['pay_remark'] = Common::replacebr($this->_input['txt_remark']);
					$value_array['amount'] = $this->_input['amount'];
					$value_array['create_time'] = time();
					$result = $this->obj_predeposit->addPredepositCash($value_array);
					if ($result === true){
						$this->redirectPath('succ','member/own_predeposit.php?action=cash_list',$this->_lang['langPreCashIsSucc']);
					}else {
						$this->redirectPath('error','',$this->_lang['langPreOparetIsFaild']);
					}
				}
			}else if ($this->_input['pay_type'] == 'offline'){//线下
				//保存表单
				$value_array = array();
				$value_array['member_id'] = $_SESSION['s_login']['id'];
				$value_array['payment'] = 'offline';
				$value_array['payment_type'] = '1';
				$value_array['record_state'] = '0';
				$value_array['pay_account'] = $this->_input['pay_account'];
				$value_array['pay_bank'] = $this->_input['txt_pay_bank'];
				$value_array['pay_consignee'] = $this->_input['txt_pay_consignee'];
				$value_array['pay_remark'] = Common::replacebr($this->_input['txt_remark']);
				$value_array['amount'] = $this->_input['amount'];
				$value_array['create_time'] = time();
				$result = $this->obj_predeposit->addPredepositCash($value_array);
				if ($result === true){
					$this->redirectPath('succ','member/own_predeposit.php?action=cash_list',$this->_lang['langPreCashIsSucc']);
				}else {
					$this->redirectPath('error','',$this->_lang['langPreCashIsFail']);
				}
			}
		}
	}
}
$predeposit = new OwnPredeposit();
$predeposit->main();
unset($predeposit);
?>