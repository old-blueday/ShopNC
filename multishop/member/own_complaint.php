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
 * FILE_NAME : own_complaint.php   FILE_PATH : \multishop\member\own_complaint.php
 * 会员投诉举报操作页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Nov 06 15:27:22 CST 2007
 */

require ("../global.inc.php");

class ShowComplaint extends memberFrameWork {
	/**
	 * 投诉举报对象
	 *
	 * @var obj
	 */
	var $objcomplaint;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
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
	 * 商品交易对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	function main(){
		/**
		 * 创建投诉举报对象
		 */
		if (!is_object($this->objcomplaint)){
			require_once("complaint.class.php");
			$this->objcomplaint = new Complaint();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
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
		 * 创建商品订单对象
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
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
		$this->getlang("complaint");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('account','client_server','complaint_law');		
		
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "complaint_sell";
				$complaint_case = "sell";
				$this->_complaint($complaint_case);
				break;
			case "complaint_buy";
				$complaint_case = "buy";
				$this->_complaint($complaint_case);
				break;	
			case "report_product":
				$report_case = "product";
				$this->_report($report_case);
				break;
			case "report_member":
				$report_case = "member";
				$this->_report($report_case);
				break;
			case "view":
				$this->_view();
				break;
			case "set_answer":
				$this->_set_answer();
				break;
			case "del":
				$this->_del();
				break;
			default:
				$this->_complaint_index();
				break;
		}
	}
	
	/**
	 * 投诉 举报 首页
	 * 
	 */
	function _complaint_index(){		
		//投诉举报列表: state处理状态,class类别投诉举报,send_receive作出或者收到
		if ($this->_input['type'] != ''){
			
			if ($this->_input['date_line'] == ''){
				$this->_input['date_line'] = 'recent';
			}
			$condition_array = array('state'=>$this->_input['state'],'class'=>$this->_input['type'],'send_receive'=>$this->_input['send_receive'],'member_id'=>$_SESSION['s_login']['id'],'date'=>$this->_input['date_line']);
			$this->obj_page->pagebarnum(10);
			$complaint_receive_list = $this->objcomplaint->getComplaintList($condition_array,$this->obj_page);
			if (is_array($complaint_receive_list)){
				foreach ($complaint_receive_list as $key => $value){
					if ($value['c_r_type'] == 12){
						$product_row = $this->obj_product->getProductRow($value['c_r_related_product']);
						$complaint_receive_list[$key]['c_r_related_name'] = $product_row['p_name'];
					}
					$complaint_receive_list[$key]['c_r_add_time'] = @date("Y/m/d",$value['c_r_add_time']);
				}
			}
			$page_list = $this->obj_page->show(1);
		}
		/**
		 * 所有的该会员的投诉举报信息，包括接受的和发起的
		 */
		$condition['send_receive'] = 'or';
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$complaint_list = $this->objcomplaint->getComplaintList($condition,$page);
		/**
		 * 统计内容
		 */
		$complaint_send_handling = 0;//作出的处理中的投诉
		$complaint_send_handed = 0;//作出的结束处理的投诉
		$complaint_receive_handling = 0;//收到的处理中的投诉
		$complaint_receive_handed = 0;//收到的结束处理的投诉
		$report_send_handling = 0;//作出的处理中的举报
		$report_send_handed = 0;//作出的结束处理的举报
		$report_receive_handling = 0;//收到的处理中的举报
		$report_receive_handed = 0;//收到的结束处理的举报
		if (is_array($complaint_list)) {
			foreach ($complaint_list as $k => $v){
				/**
				 * 1.作出的处理中的投诉
				 */
				if (
					($v['c_r_handling_state'] !== '3') && 
					($v['c_r_class'] == '1' || $v['c_r_class'] == '2') && 
					$v['member_id'] == $_SESSION['s_login']['id']
				){
					$complaint_send_handling++;
				}
				/**
				 * 2.作出的结束处理的投诉
				 */
				if (
					($v['c_r_handling_state'] == '3') && 
					($v['c_r_class'] == '1' || $v['c_r_class'] == '2') && 
					$v['member_id'] == $_SESSION['s_login']['id']
				){
					$complaint_send_handed++;
				}
				/**
				 * 3.收到的处理中的投诉
				 */
				if (
					($v['c_r_handling_state'] == '1' || $v['c_r_handling_state'] == '2') && 
					($v['c_r_class'] == '1' || $v['c_r_class'] == '2') && 
					$v['c_r_member_id'] == $_SESSION['s_login']['id']
				){
					$complaint_receive_handling++;
				}
				/**
				 * 4.收到的结束处理的投诉
				 */
				if (
					($v['c_r_handling_state'] == '3') && 
					($v['c_r_class'] == '1' || $v['c_r_class'] == '2') && 
					$v['c_r_member_id'] == $_SESSION['s_login']['id']
				){
					$complaint_receive_handed++;
				}
				/**
				 * 5.作出的处理中的举报
				 */
				if (
					($v['c_r_handling_state'] !== '3') && 
					($v['c_r_class'] == '3' || $v['c_r_class'] == '4') && 
					$v['member_id'] == $_SESSION['s_login']['id']
				){
					$report_send_handling++;
				}
				/**
				 * 6.作出的结束处理的举报
				 */
				if (
					($v['c_r_handling_state'] == '3') && 
					($v['c_r_class'] == '3' || $v['c_r_class'] == '4') && 
					$v['member_id'] == $_SESSION['s_login']['id']
				){
					$report_send_handed++;
				}
				/**
				 * 7.收到的处理中的举报
				 */
				if (
					($v['c_r_handling_state'] == '1' || $v['c_r_handling_state'] == '2') && 
					($v['c_r_class'] == '3' || $v['c_r_class'] == '4') && 
					$v['c_r_member_id'] == $_SESSION['s_login']['id']
				){
					$report_receive_handling++;
				}
				/**
				 * 8.收到的结束处理的举报
				 */
				if (
					($v['c_r_handling_state'] == '3') && 
					($v['c_r_class'] == '3' || $v['c_r_class'] == '4') && 
					$v['c_r_member_id'] == $_SESSION['s_login']['id']
				){
					$report_receive_handed++;
				}
			}
		}
		
		/**
		 * 输出到页面模板
		 */
		$this->output('complaint_receive_list', $complaint_receive_list);
		$this->output('complaint_send_handling',$complaint_send_handling);//作出的处理中的投诉
		$this->output('complaint_send_handed',$complaint_send_handed);//作出的结束处理的投诉
		$this->output('complaint_receive_handling',$complaint_receive_handling);//收到的处理中的投诉
		$this->output('complaint_receive_handed',$complaint_receive_handed);//收到的结束处理的投诉
		
		$this->output('report_send_handling',$report_send_handling);//作出的处理中的举报
		$this->output('report_send_handed',$report_send_handed);//作出的结束处理的举报
		$this->output('report_receive_handling',$report_receive_handling);//收到的处理中的举报
		$this->output('report_receive_handed',$report_receive_handed);//收到的结束处理的举报
		
		$this->output('type',$this->_input['type']);//显示页面类别
		$this->output('send_receive',$this->_input['send_receive']);//选择作出或收到的列表
		$this->output('state',$this->_input['state']);//处理状态
		$this->output('date_line',$this->_input['date_line']);//查看的时间范围
		$this->output("baseconfig_type", $this->_b_config['complaint_report_type']);//投诉举报类型
		$this->output("baseconfig_handling", $this->_b_config['complaint_report_handling']);//投诉举报处理状态
		$this->showpage('own_complaint.manage');
	}

	/**
	 * 举报操作
	 * 
	 */
	function _report($report_case){

		if ($report_case == 'product'){//当是举报商品时
			$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["code"],"require"=>"true","message"=>$this->_lang['errComplaintProductCode']));
			$error = $this->objvalidate->validate();
			if($error != ""){
				$this->redirectPath("error","",$error);
			}else{
				/**
				 * 取得商品信息
				 */
				$product_row = $this->obj_product->getProductRow($this->_input['code']);
				if (empty($product_row)){
					$this->redirectPath("error","",$this->_lang['errComplaintProductCode']);
				}
				//判断会员是否和卖家相同
				if($_SESSION['s_login']['id'] == $product_row['member_id']){
					$this->redirectPath("error","",$this->_lang['langComplaintNoOwn']);
				}
				/**
				 * 取得卖家资料
				 */
				$report_member = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']));
			}
		}
		/*step one，选择举报类型*/
		/*step two，提交举报内容*/
		if ($this->_input['step'] == 'two') {
			if ($this->_input['type'] == 10){
				$this->output('embargo_id',$this->_b_config['complaint_report_prohibited_product']);/*禁售品列表*/
			}
		}
		/*step three，提交完成*/
		if ($this->_input['step'] == 'three') {
			
			if ($report_case == 'member'){/*当是举报会员时*/
				$this->objvalidate->validateparam = array(
				array("input"=>$this->_input["c_r_login_name"],"require"=>"true","validator"=>"Length","min"=>"0","max"=>"1500","message"=>$this->_lang['errComplaintReportMember']));/*被举报人*/
				/*验证用户名是否存在*/
				$condition['member_name'] = $this->_input["c_r_login_name"];
				$report_member = $this->obj_member->getMemberList($condition,$this->obj_page);
				$report_member = $report_member[0];
				if (empty($report_member) || $_SESSION['s_login']['name'] == $this->_input["c_r_login_name"]){
					$this->redirectPath("error","",$this->_lang['errComplaintReportMember']);
				}
			}

			if ($this->_input['type'] != 12){/*重复铺货的类型下没有证据字段, 其他类型都有*/
				$this->objvalidate->validateparam = array(
				array("input"=>$this->_input["evidence"],"require"=>"true","validator"=>"Length","min"=>"0","max"=>"1500","message"=>$this->_lang['errComplaintEvidence']));/*证据*/
				$error = $this->objvalidate->validate();
				
				if($error != ""){
					$this->redirectPath("error","",$error);
				}
			}
			
			if ($this->_input['type'] == 5){
				/*炒作会员信息*/
				if ($this->_input['speculation_member_name'] != ""){
					/*验证用户名是否存在*/
					$condition['member_name'] = $this->_input["speculation_member_name"];
					$speculation_member = $this->obj_member->getMemberList($condition,$this->obj_page);
					$speculation_member = $report_member[0];	
					if (empty($speculation_member)){
						$this->redirectPath("error","",$this->_lang['errComplaintSpeculationMember']);
					}
				}
				/*炒作商品信息*/
				if ($this->_input['p_code'] != ""){
					/*验证举报商品*/
					$product_row = $this->obj_product->getProductRow($this->_input['p_code']);
					if (empty($product_row)){
						$this->redirectPath("error","",$this->_lang['errComplaintProductCode']);
					}
				}
			}
			
			if ($this->_input['type'] == 6 || $this->_input['type'] == 7){
				
				/*验证举报商品*/
				$this->objvalidate->validateparam = array(
				array("input"=>$this->_input["p_code"],"require"=>"true","message"=>$this->_lang['errComplaintProductCode']));
				$error = $this->objvalidate->validate();
				if($error != ""){
					$this->redirectPath("error","",$error);
				}else{
					/**
					 * 取得商品信息
					 */
					$product_row = $this->obj_product->getProductRow($this->_input["p_code"]);
					if (empty($product_row)){
						$this->redirectPath("error","",$this->_lang['errComplaintProductCode']);
					}
				}
			}
			
			if ($this->_input['type'] == 8 || $this->_input['type'] == 7){
				if(isset($_FILES['pic']['name']) and $_FILES['pic']['name'] != ''){
					require_once("uploadfile.class.php");
					$upload = new UploadFile();
					$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
					$upload->ifresize = false;
					$filename = $upload->upfile("pic");
					$this->_input["c_r_pic"] = $filename["getfilename"];//上传图片
					unset($upload);
				}else {
					$this->redirectPath("error","",$this->_lang['errComplaintPic']);
				}
			}
			
			
			if ($this->_input['type'] == 12){
				$this->objvalidate->validateparam = array(
				array("input"=>$this->_input["related_product"],"require"=>"true","validator"=>"Length","min"=>"0","max"=>"1500","message"=>$this->_lang['errComplaintEvidence']));
				$error = $this->objvalidate->validate();
				
				if($error != ""){
					$this->redirectPath("error","",$error);
				}
				
				/*判断是否和举报商品相同*/
				if ($this->_input["related_product"] == $product_row['p_code']){
					$this->redirectPath("error","",$this->_lang['errComplaintRepeatProduct']);
				}
			}

			/*添加举报信息*/
			$value_array = array();
			$value_array['member_id'] = $_SESSION['s_login']['id'];/*作出举报的会员ID*/
			$value_array['login_name'] = $_SESSION['s_login']['name'];/*作出举报的会员名*/
			$value_array['c_r_member_id'] = $report_member['member_id'];/*被举报的会员ID*/
			$value_array['c_r_login_name'] = $report_member['login_name'];/*被举报的会员名*/
			$value_array['p_code'] = $product_row['p_code'];/*举报商品的编号*/
			$value_array['p_name'] = $product_row['p_name'];/*举报商品的名称*/
			if ($report_case == 'product'){/*当是举报商品时*/
				$value_array['c_r_class'] = 3;/*举报商品*/
			}elseif ($report_case == 'member'){/*当是举报会员时*/
				$value_array['c_r_class'] = 4;/*举报会员*/
			}
			$value_array['c_r_type'] = $this->_input['type'];/*举报类型*/
			$value_array['c_r_evidence'] = $this->_input['evidence'];/*举报证据*/
			$value_array['c_r_add_time'] = time();/*作出举报的时间*/
			$value_array['c_r_pic'] = $this->_input["c_r_pic"];/*上传图片*/
			if($speculation_member['member_id'] != '') $value_array['c_r_speculation_member_id'] = $speculation_member['member_id'];/*相关炒作的用户ID（c_r_type=5）*/
			$value_array['c_r_speculation_member_name'] = $speculation_member['login_name'];/*相关炒作的用户名（c_r_type=5）*/
			if($this->_input['embargo_id'] != '') $value_array['embargo_id'] = $this->_input['embargo_id'];/*禁售商品类别 当c_r_type=10*/
			$value_array['c_r_related_product'] = $this->_input['related_product'];/*重复商品编号 当c_r_type=12*/
			$value_array['c_r_handling_state'] = 0;/*处理状态*/

			$this->objcomplaint->addComplaint($value_array);/*添加信息*/
			
			
			/**
			 * 网站提醒操作
			 */
			if (!is_object($this->obj_remind)){
				require_once('remind.class.php');
				$this->obj_remind = new RemindClass();
			}
			$value_array = array();
			$value_array['username'] = $report_member['login_name'];
			$this->obj_remind->setMessageOrMail('complaint_receive_notice','complaint_receive_notice',$value_array,$report_member['login_name'],$this->_configinfo);
			
			
			$this->redirectPath("succ","member/own_complaint.php",$this->_lang['langComplaintSubmitSucceed']);//提交成功
		}
		
		/**
		 * 输出模板
		 */
		$this->output('report_case',$report_case);/*举报参数，商品或会员*/
		$this->output('step',$this->_input['step']);/*提交举报步骤*/
		$this->output('type',$this->_input['type']);/*举报类型*/
		$this->output('complaint_report_type',$this->_b_config['complaint_report_type'][$this->_input['type']]);/*举报信息类型*/
		$this->output('product_row',$product_row);/*举报商品信息*/
		$this->output('report_member',$report_member);/*卖家信息*/
		$this->showpage('own_complaint.report');
	}
	
	
	/**
	 * 投诉 卖家 或 买家
	 */
	function _complaint($complaint_case){
		
		/*step one，选择投诉类型*/
		/*step two，提交投诉内容*/
		/*step three，提交完成*/
		/**
		 * 取订单信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["spid"],"require"=>"true","message"=>$this->_lang['errComplaintSpcode']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else {
			$sold_row = $this->obj_product_order->getOneOrder($this->_input["spid"]);
			if (empty($sold_row)){
				$this->redirectPath("error","",$this->_lang['errComplaintSpcode']);
			}
		}
		/**
	     * 取被投诉人信息
		 */
		if ($complaint_case == 'sell'){
			$condition['id'] = $sold_row['seller_id'];
			$complaint_member = $this->obj_member->getMemberInfo($condition);
		}elseif ($complaint_case == 'buy') {
			$condition['id'] = $sold_row['buyer_id'];
			$complaint_member = $this->obj_member->getMemberInfo($condition);
		}

		$complaint_member['anonymous'] = $sold_row['anonymous'];/*是否匿名*/
		
		if ($this->_input['step'] == 'three'){
			/*验证提交信息*/
			$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["evidence"],"require"=>"true","validator"=>"Length","min"=>"0","max"=>"1500","message"=>$this->_lang['errComplaintEvidence']));/*证据*/
			$error = $this->objvalidate->validate();

			if($error != ""){
				$this->redirectPath("error","",$error);
			}
			if ($this->_input['type'] == 2){
				if(isset($_FILES['pic']['name']) and $_FILES['pic']['name'] != ''){
					require_once("uploadfile.class.php");
					$upload = new UploadFile();
					$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
					$upload->ifresize = false;
					$filename = $upload->upfile("pic");
					$this->_input["c_r_pic"] = $filename["getfilename"];//上传图片
					unset($upload);
				}else {
					$this->redirectPath("error","",$this->_lang['errComplaintPic']);
				}
			}
			
			/*添加举报信息*/
			$value_array = array();
			$value_array['member_id'] = $_SESSION['s_login']['id'];/*作出投诉的会员ID*/
			$value_array['login_name'] = $_SESSION['s_login']['name'];/*作出投诉的会员名*/
			$value_array['c_r_member_id'] = $complaint_member['member_id'];/*被投诉的会员ID*/
			$value_array['c_r_login_name'] = $complaint_member['login_name'];/*被投诉的会员名*/
			$value_array['p_code'] = $sold_row['p_code'];/*投诉商品的编号*/
			$value_array['p_name'] = $sold_row['p_name'];/*投诉商品的名称*/
			$value_array['sp_id'] = $this->_input['spid'];/*交易ID*/
			if ($complaint_case == 'sell'){/*当是投诉卖家时*/
				$value_array['c_r_class'] = 1;
			}elseif ($complaint_case == 'buy'){/*当是投诉买家时*/
				$value_array['c_r_class'] = 2;
			}
			$value_array['c_r_type'] = $this->_input['type'];/*投诉类型*/
			$value_array['c_r_evidence'] = $this->_input['evidence'];/*投诉证据*/
			$value_array['c_r_add_time'] = time();/*作出投诉的时间*/
			$value_array['c_r_pic'] = $this->_input["c_r_pic"];/*上传图片*/
			$value_array['c_r_handling_state'] = 0;/*处理状态*/
			
			$this->objcomplaint->addComplaint($value_array);/*添加信息*/
			
			/**
			 * 网站提醒操作
			 */
			if (!is_object($this->obj_remind)){
				require_once('remind.class.php');
				$this->obj_remind = new RemindClass();
			}

			$value_array = array();
			$value_array['username'] = $complaint_member['login_name'];
			$this->obj_remind->setMessageOrMail('complaint_receive_notice','complaint_receive_notice',$value_array,$complaint_member['login_name'],$this->_configinfo);
			
			/**
			 * 完成投诉申请操作后，修改被投诉交易订单状态，is_complaint=1，不允许对该订单进行操作
			 */
			$update_order['spcode'] = $sold_row['sp_code'];
			$update_order['txtSPstate'] = $sold_row['sp_state'];
			$update_order['is_complaint'] = 1;
			$result = $this->obj_product_order->updateProductOrderState($update_order);
			if ($result !== true) {
				$this->redirectPath("succ","member/own_complaint.php",$this->_lang['langComplaintModiOrderStateLost']);
			}
			$this->redirectPath("succ","member/own_complaint.php",$this->_lang['langComplaintSubmitSucceed']);
		}

		/**
		 * 输出模板
		 */
		$this->output('spid',$this->_input['spid']);/*交易ID*/
		$this->output('step',$this->_input['step']);/*投诉步骤*/
		$this->output('type',$this->_input['type']);/*投诉类型*/
		$this->output('complaint_case',$complaint_case);/*投诉类型,买家或者卖家*/
		$this->output('complaint_report_type',$this->_b_config['complaint_report_type'][$this->_input['type']]);/*投诉信息类型*/
		$this->output('complaint_member',$complaint_member);/*被投诉人信息*/
		$this->output('sold_row',$sold_row);/*相关交易信息*/
		$this->showpage('own_complaint.complaint');
	}
	
	/**
	 * 查看投诉/举报信息
	 */
	function _view(){
		/**
		 * 取信息
		 */
		$array = $this->objcomplaint->getComplaintById($this->_input['complaint_report_id']);
		
		if ($array['c_r_type'] == 10){
			$this->output('embargo_id',$this->_b_config['complaint_report_prohibited_product'][$array['embargo_id']]);/*禁售品*/
		}
		if ($array['c_r_type'] == 12){
			/**
			 * 取重复铺货商品信息
			 */
			$product_row = $this->obj_product->getProductRow($array['c_r_related_product']);
			$array['c_r_related_product_name'] = $product_row['p_name']; 
		}

		if ($array['c_r_add_time'] != ""){
			$array['c_r_add_time'] = @date("Y/m/d H:i:s",$array['c_r_add_time']);
		}
		if ($array['c_r_end_time'] != ""){
			$array['c_r_end_time'] = @date("Y/m/d H:i:s",$array['c_r_end_time']);
		}
		
		/*取系统回复留言内容*/
		$this->obj_page->pagebarnum(10);
		$msg_array = $this->objcomplaint->getComplaintMsgById($this->_input['complaint_report_id'],$array['c_r_class'],$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		
		if (is_array($msg_array)){
			foreach ($msg_array as $k => $v){
				$msg_array[$k]['r_c_msg_add'] = @date("Y/m/d H:i:s",$v['r_c_msg_add']);
			}
		}

		/**
		 * 模板输出
		 */
		$this->output('type',$this->_input['type']);/*投诉举报类型*/
		$this->output('complaint_report_id',$this->_input['complaint_report_id']);
		$this->output('complaint_array',$array);
		$this->output('msg_array',$msg_array);
		$this->output("page_list", $page_list);/*分页*/
		$this->output("complaint_report_type", $this->_b_config['complaint_report_type']);/*投诉举报类别*/
		$this->output("baseconfig_handling", $this->_b_config['complaint_report_handling']);/*投诉举报处理状态*/
		$this->output('login_name',$_SESSION['s_login']['name']);
		$this->showpage('own_complaint.view');
	}
	
	/**
	 * 提出申诉
	 */
	function _set_answer(){
		
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["c_r_answer"],"require"=>"true","message"=>$this->_lang['errMsgNoContent']));/*申述内容*/
		$error = $this->objvalidate->validate();

		if($error != ""){
			$this->redirectPath("error","",$error);
		}
		
		/**
		 * 取信息内容
		 */
		$array = $this->objcomplaint->getComplaintById($this->_input['complaint_report_id']);
		
		$value_array = array();
		$value_array['complaint_report_id'] = $this->_input['complaint_report_id'];/*信息ID*/
		$value_array['c_r_answer'] = $this->_input['c_r_answer'];/*申述内容*/
		$value_array['c_r_handling_state'] = 2;/*处理状态*/
		$this->objcomplaint->updateComplaintById($value_array);
		
		/**
		 * 网站提醒操作
		 */
		if (!is_object($this->obj_remind)){
			require_once('remind.class.php');
			$this->obj_remind = new RemindClass();
		}
		$value_array = array();
		$value_array['username'] = $array['login_name'];
		$this->obj_remind->setMessageOrMail('complaint_other_answer_notice','complaint_other_answer_notice',$value_array,$member_array['login_name'],$this->_configinfo);

		$this->redirectPath("succ","member/own_complaint.php?action=view&type=" . $this->_input['type'] . "&complaint_report_id=".$this->_input['complaint_report_id'],$this->_lang['langComplaintSubmitSucceed']);
	}
	
	/**
	 * 撤销投诉
	 */
	function _del(){

		$id = $this->_input['complaint_report_id'];
		$this->objcomplaint->delComplaintById($id);

		/**
		 * 更改订单状态，取消被投诉时的订单锁定
		 */
		if (is_array($this->_input['sp_id'])) {
			foreach ($this->_input['sp_id'] as $k => $v){
				$order_arr = $this->obj_product_order->getOneOrder(intval($v));
				$update_order = array();
				$update_order['spcode'] = $order_arr['sp_code'];
				$update_order['txtSPstate'] = $order_arr['sp_state'];
				$update_order['is_complaint'] = 0;
				$result = $this->obj_product_order->updateProductOrderState($update_order);
				if ($result !== true) {
					$this->redirectPath("succ","",$this->_lang['langComplaintModiOrderStateLost']);
				}
			}
			unset($order_arr,$update_order);
		}
		
		$this->redirectPath("refer","",$this->_lang['langComplaintSubmitSucceed']);
	}
	
	
}
$complaint = new ShowComplaint();
$complaint->main();
unset($complaint);
?>