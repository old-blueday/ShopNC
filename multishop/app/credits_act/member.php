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
 * FILE_NAME : member.php
 * ....积分活动，会员后台列表
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Jun 19 13:29:58 CST 2009
 */

require_once('../../global.inc.php');

class ShowCreditsActManage extends CommonFrameWork {
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
	 * 应用内容
	 *
	 * @var obj
	 */
	var $default_app_array;
	
	function ShowCreditsActManage(){
		$this->__construct();
	}
	function __construct(){
		//初始化信息
		$this->default_app_array = $this->constructAppModule('credits_act','member');
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
		}
		
		$this->memberMenuModule ();
		
		switch ($this->_input['action']){
			case 'list':
				$this->_list();
				break;
			case 'del_apply':
				$this->_del_apply ();
				break;
			case 'apply_view':
				$this->_apply_view ();
				break;
			case 'apply_list':
				$this->_apply_list ();
				break;
			default:
				$this->_apply_list ();
		}
	}
	/**
	 * 查看兑换申请
	 *
	 */
	function _apply_view () {
		if ( $this->_input['id'] != '' ) {
			//获取兑换申请详细信息
			$apply_array = $this->obj_credits_act->getCreditsActApplyRow ( $this->_input['id'] );
			//对时间、状态进行处理
			if ( is_array( $apply_array ) ) {
				$apply_array['caa_time'] = date( "Y-m-d", $apply_array['caa_time'] );
				//状态
				switch ( $apply_array['caa_state'] ){
					case '0'://申请中
						$apply_array['state'] = $this->_lang['langSysCAApplyStateZero'];
						break;
					case '1'://已通过
						$apply_array['state'] = $this->_lang['langSysCAApplyStateOne'];
						break;
					case '2'://拒绝
						$apply_array['state'] = $this->_lang['langSysCAApplyStateTwo'];
						break;
				}	
				if ( $apply_array['cag_pic'] != '' ) {
					$ex_picture = explode( ".",$apply_array['cag_pic'] );
					$apply_array['picture_big'] = $ex_picture[0]."_big.".$ex_picture[1];			
					$apply_array['picture_small'] = $ex_picture[0]."_mid.".$ex_picture[1];			
				}
				$apply_array['total_credits']	= $apply_array['caa_num']*$apply_array['cag_credits'];						
			}
			/**
			 * 页面输出
			 */
			$this->output ( "apply_array", $apply_array );
			$this->showpage ( "own_credits_apply.view" );
		}
	}
	/**
	 * 删除兑换申请
	 *
	 */
	function _del_apply () {
		if ( is_array($this->_input['caa_id']) ){
			foreach ($this->_input['caa_id'] as $k => $v){
				$this->obj_credits_act->delApply( intval($v), $_SESSION['s_login']['id'] );
			}
			$this->redirectPath('succ','app/'.$this->default_app_array['app_module_path'].'/member.php?action=apply_list',$this->_lang['langSysCAApplyDelSucc']);
		} else {
			$this->redirectPath('error','../app/'.$this->default_app_array['app_module_path'].'/member.php?action=apply_list',$this->_lang['langSysCAApplyDelNoSelect']);
		}		
	}
	/**
	 * 兑换申请列表
	 *
	 */
	function _apply_list () {
		//获取兑换申请列表
		$condition['caa_member_id'] = $_SESSION['s_login']['id'];
		$this->obj_page->pagebarnum(10);
		$apply_list = $this->obj_credits_act->getCreditsActApplyList ( $condition, $this->obj_page );
		//对时间、状态进行处理
		if ( is_array( $apply_list ) ) {
			foreach ( $apply_list as $k => $v ) {
				$apply_list[$k]['caa_time'] = date( "Y-m-d", $v['caa_time'] );
				//状态
				switch ( $v['caa_state'] ){
					case '0'://申请中
						$apply_list[$k]['state'] = $this->_lang['langSysCAApplyStateZero'];
						break;
					case '1'://已通过
						$apply_list[$k]['state'] = $this->_lang['langSysCAApplyStateOne'];
						break;
					case '2'://拒绝
						$apply_list[$k]['state'] = $this->_lang['langSysCAApplyStateTwo'];
						break;
				}				
			}
		}
		$page_list = $this->obj_page->show(1);
		/**
		 * 页面输出
		 */
		$this->output ( 'apply_list', $apply_list );
		$this->output ( 'page_list', $page_list );		
		$this->showpage ( "own_credits_apply.list" );
	}
	/**
	 * 活动列表
	 */
	function _list(){
		$condition['caa_member_id'] = $_SESSION['s_login']['id'];
		$this->obj_page->pagebarnum(10);
		$act_list = $this->obj_credits_act->getCreditsActApplyList($condition,$this->obj_page);
		$page_list = $this->obj_page->show(1);		
		/**
		 * 页面输出
		 */
		$this->output('act_list',$act_list);
		$this->output('page_list',$page_list);
		$this->showpage('own_credits_act.list');
	}
}
$credits_act_manage = new ShowCreditsActManage();
$credits_act_manage->main();
unset($credits_act_manage);
?>