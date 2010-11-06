<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : index.php
 * ....积分活动
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Jun 15 15:08:19 CST 2009
 */

require_once('../../global.inc.php');

class CreditsActManage extends CommonFrameWork{
	/**
	 * 活动对象
	 *
	 * @var obj
	 */
	var $obj_credits_act;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
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
	 * 应用内容
	 *
	 * @var obj
	 */
	var $default_app_array;
	
	function CreditsActManage(){
		$this->__construct();
	}
	function __construct(){
		//初始化信息
		$this->default_app_array = $this->constructAppModule('credits_act','home');
	}
	
	function main(){
		/**
		 * 创建活动对象
		 */
		if (!is_object($this->obj_credits_act)){
			require_once ("credits_act.class.php");
			$this->obj_credits_act = new CreditsActClass();
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
			$this->obj_page->format_left = '';
			$this->obj_page->format_right = '';
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		
		switch ($this->_input['action']){
			case "list":
				$this->_list();
				break;
			case 'view':
				$this->_view();
				break;
			case 'check_code':
				$this->_check_code();
				break;
			case 'convert_goods':
				//验证会员是否登录
				$this->isMember(0);
				//判断用户组权限
				CheckPermission::memberGroupPermission('use_credit',$_SESSION['s_login']['id']);
				$this->_convert_goods();
				break;
			case 'convert_goods_save':
				//验证会员是否登录
				$this->isMember(0);
				$this->_convert_goods_save();
				break;
			case 'msg_save':
				//验证会员是否登录
				$this->isMember(0);
				$this->_msg_save();
				break;
			default:
				$this->_index();
				break;
		}
	}
	
	/**
	 * 首页
	 */
	function _index(){
		/**
		 * 页面输出
		 */
		$this->showpage('credits_act.index');
	}
	/**
	 * 列表
	 */
	function _list(){
		//过滤过期活动
		$this->obj_credits_act->updateCreditsActEndTime();
		$condition['ca_state'] = '0';
		$condition['order_by'] = 'ca_end_time desc';
		$this->obj_page->pagebarnum(10);
		$act_list = $this->obj_credits_act->getCreditsActList($condition,$this->obj_page);
		$page_list = $this->obj_page->show(1);
		
		/**
		 * 页面输出
		 */
		$this->output('page_list',$page_list);
		$this->output('act_list',$act_list);
		$this->showpage('credits_act.list');
	}
	
	/**
	 * 查看
	 */
	function _view(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langCIdIsIllegal']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath('error','',$error);
		}else {
			$act_row = $this->obj_credits_act->getCreditsActRow($this->_input['ca_id']);
			if (empty($act_row)){
				$this->redirectPath('error','',$this->_lang['langCIdIsIllegal']);
			}
			$act_row['ca_title_small'] = Common::cutstr($act_row['ca_title'],15);
			$act_row['ca_add_time'] = date('Y-m-d',$act_row['ca_add_time']);
			$act_row['ca_end_time'] = $act_row['ca_end_time']>time()?date('Y-m-d',$act_row['ca_end_time']):$this->_lang['langCATimeIsEnd'];
			//兑换物品
			$condition_goods['ca_id'] = $this->_input['ca_id'];
			$obj_page = new CommonPage();
			$obj_page->pagebarnum(10);
			$obj_page->format_left = '';
			$obj_page->format_right = '';
			$act_goods_list = $this->obj_credits_act->getCreditsActGoodsList($condition_goods,$obj_page);
			$page_list = $obj_page->show(1);
			//活动留言
			$condition_msg['ca_id'] = $this->_input['ca_id'];
			$msg_pape = new CommonPage();
			$msg_pape->page_name = 'msgcurpage';
			$msg_pape->format_left = '';
			$msg_pape->format_right = '';
			$msg_pape->pagebarnum(10);
			$msg_list = $this->obj_credits_act->getCreditsActMsgList($condition_msg,$msg_pape);
			if (is_array($msg_list)) {
				foreach ($msg_list as $km => $vm) {
					$msg_list[$km]['cam_time'] = date('Y-m-d',$vm['cam_time']);
				}
			}
			$msg_page_list = $msg_pape->show(1);
			/**
			 * 页面输出
			 */
			$this->output('act_row',$act_row);
			$this->output('act_goods_list',$act_goods_list);
			$this->output('page_list',$page_list);
			$this->output('msg_list',$msg_list);
			$this->output('msg_page_list',$msg_page_list);
			$this->output('login',$_SESSION['s_login']['login']);
			$this->showpage('credits_act.view');
		}
	}
	
	/**
	 * 兑换物品
	 */
	function _convert_goods(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['cag_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langCIdIsIllegal']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath('error','',$error);
		}else {
			//检查商品是否有效
			$act_goods_row = $this->_check_goods();
			//会员积分
			$member_info = $this->obj_member->getMemberInfo(array('id'=>$_SESSION['s_login']['id']),'*','more');
			/**
			 * 页面输出
			 */
			$this->output('member_info',$member_info);
			$this->output('act_goods_row',$act_goods_row);
			$this->showpage('credits_act.convert_goods');
		}
	}
	
	/**
	 * 保存兑换物品申请记录
	 */
	function _convert_goods_save(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['cag_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langCIdIsIllegal']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['caa_num'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errCACaaNumIsNotNumber']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath('error','',$error);
		}else {
			//检查商品是否有效
			$act_goods_row = $this->_check_goods('save');
			//提交申请
			$value_array = array();
			$value_array['ca_id'] = $act_goods_row['ca_id'];
			$value_array['cag_id'] = $act_goods_row['cag_id'];
			$value_array['caa_member_id'] = $_SESSION['s_login']['id'];
			$value_array['caa_time'] = time();
			$value_array['caa_num'] = $this->_input['caa_num'];
			$value_array['caa_credits'] = $act_goods_row['cag_credits'];
			$value_array['caa_state'] = '0';
			$result = $this->obj_credits_act->addCreditsActApply($value_array);
			if ($result === true){
				//扣除会员积分
				$value_array = array();
				$value_array['extcredits_exp'] = 0;
				$value_array['extcredits_points'] = -$act_goods_row['cag_credits'];
				$this->obj_member->modifyMember($value_array,$_SESSION['s_login']['id'],'credits');
				unset($value_array);
				//写入日志
				$value_array = array();
				$value_array['cl_member_id'] = $_SESSION['s_login']['id'];
				$value_array['cl_time'] = time();
				$value_array['cl_type'] = 'credits_convert';
				$value_array['cl_content'] = $this->_lang['langCACaaLog'];
				$value_array['cl_exp'] = 0;
				$value_array['cl_points'] = -$act_goods_row['cag_credits'];
				CreditsClass::addCreditsLog($value_array);
				unset($value_array);
				//减少兑换商品数量
				$value_array = array();
				$value_array['cag_id'] = $act_goods_row['cag_id'];
				$value_array['cag_num'] = $act_goods_row['cag_num']-$this->_input['caa_num'];
				$this->obj_credits_act->updateCreditsActGoods($value_array);
				unset($value_array);
				//
				$this->redirectPath('error','',$this->_lang['langCASubmitSucc']);
			}else {
				$this->redirectPath('error','',$this->_lang['errCASubmitFail']);
			}
		}
	}
	
	/**
	 * 检查 兑换商品是否符合兑换要求
	 * $type add 提交页面 save 保存
	 */
	function _check_goods($type='add'){
		$act_goods_row = $this->obj_credits_act->getCreditsActGoodsRow($this->_input['cag_id'],'more');
		if (empty($act_goods_row)){
			$this->redirectPath('error','',$this->_lang['langCIdIsIllegal']);
		}
		if ($act_goods_row['ca_end_time'] < time()){
			$this->redirectPath('error','',$this->_lang['errCAEnd']);
		}
		if ($act_goods_row['cag_num'] <= 0){
			$this->redirectPath('error','',$this->_lang['errCAGoodsNumIsEmpty']);
		}
		
		if ($type == 'save'){
			//兑换数量
			if ($act_goods_row['cag_num'] < $this->_input['caa_num']){
				$this->redirectPath('error','',$this->_lang['errCAGoodsNumIsAbove']);
			}
			//与会员积分进行对比
			//会员积分
			$member_info = $this->obj_member->getMemberInfo(array('id'=>$_SESSION['s_login']['id']),'*','more');
			if ($this->_input['caa_num']*$act_goods_row['cag_credits'] > $member_info['extcredits_points']){
				$this->redirectPath('error','',$this->_lang['errCACaaMyCreditsNotEnough']);
			}
		}
		return $act_goods_row;
	}
	
	/**
	 * 验证码
	 */
	function _check_code(){
		$code = $this->_input['checkcode'];
		if (strtoupper($code) == strtoupper($_SESSION['seccode'])){
			echo 1;//正确
		}else {
			echo 2;//错误
		}
	}
	
	/**
	 * 保存留言
	 */
	function _msg_save(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langCIdIsIllegal']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['cam_content'],"require"=>"true","message"=>$this->_lang['errCACamContentIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath('error','',$error);
		}else {
			$act_row = $this->obj_credits_act->getCreditsActRow($this->_input['ca_id']);
			if (empty($act_row)){
				$this->redirectPath('error','',$this->_lang['langCIdIsIllegal']);
			}
			if ($act_row['ca_end_time'] < time()){
				$this->redirectPath('error','',$this->_lang['errCAEndToMsg']);
			}
			//
			$value_array = array();
			$value_array['ca_id'] = $this->_input['ca_id'];
			$value_array['cam_member_id'] = $_SESSION['s_login']['id'];
			$value_array['cam_content'] = $this->_input['cam_content'];
			$value_array['cam_time'] = time();
			$result = $this->obj_credits_act->addCreditsActMsg($value_array);
			if ($result === true){
				$this->redirectPath('error','',$this->_lang['langCAMsgSubmitSucc']);
			}else {
				$this->redirectPath('error','',$this->_lang['errCAMsgSubmitFail']);
			}
		}
	}
}
$credits_act = new CreditsActManage();
$credits_act->main();
unset($credits_act);
?>