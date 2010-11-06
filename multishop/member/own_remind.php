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
 * FILE_NAME : own_remind.php   FILE_PATH : \multishop\member\own_remind.php
 * 网站提醒设置
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author 
 * @package 
 * @subpackage 
 * @version Thu Nov 29 11:36:21 CST 2007
 */

require ("../global.inc.php");

class OwnRemind extends memberFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	
	
	function main(){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建提醒对象
		 */
		if (!is_object($this->obj_remind)){
			require_once("remind.class.php");
			$this->obj_remind = new RemindClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("remind");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('account','basic_set','remind_set');	
				
		switch ($this->_input['action']){
			case "save":
				$this->_save();
				break;
			case "default_value":
				$this->_default_value();
				break;
			default:
				$this->_list();
				break;
		}
	}
	
	/**
	 * 提醒列表
	 */
	function _list(){
		$condition['id'] = $_SESSION['s_login']['id'];
		$array = $this->obj_remind->checkRemindExist($condition,'3');
		if (false == $array){
			$remind_array = $this->obj_remind->defaultRemindArray('1',$this->_lang);
		}else {
			$remind_array = $this->obj_remind->memberRemindMenu('return',$this->_lang);
			if (is_array($remind_array)){
				foreach ($remind_array as $k => $v){
					if (is_array($v['body'])){
						foreach ($v['body'] as $k2 => $v2){
							if (is_array($v2['body'])){
								foreach ($v2['body'] as $k3 => $v3){
									$line = @explode('|',$array[$v3['tag']]);
									$remind_array[$k]['body'][$k2]['body'][$k3][$v3['tag']] = array('mail_check'=>$line[0],'msg_check'=>$line[1]);
								}
							}
						}
					}
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output('remind_array',$remind_array);
		$this->showpage('own_remind.manage');
	}
	
	/**
	 * 保存提醒信息
	 */
	function _save(){
		$value_array = array();
		$value_array['member_id'] = $_SESSION['s_login']['id'];
		$value_array['login_name'] = $_SESSION['s_login']['name'];
		$value_array['date_line'] = time();
		$remind_array = $this->obj_remind->memberRemindMenu('return',$this->_lang);
		if (is_array($remind_array)){
			foreach ($remind_array as $v){
				if (is_array($v['body'])){
					foreach ($v['body'] as $v2){
						if (is_array($v2['body'])){
							foreach ($v2['body'] as $v3){
								if ($this->_input[$v3['tag'].'_mail'] == "" && $v3['mail_disabled'] == '0'){
									$this->_input[$v3['tag'].'_mail'] = 0;
								}elseif ($v3['mail_disabled'] == '1'){
									$this->_input[$v3['tag'].'_mail'] = $v3['mail_check'];
								}
								if ($this->_input[$v3['tag'].'_msg'] == "" && $v3['msg_disabled'] == '0'){
									$this->_input[$v3['tag'].'_msg'] = 0;
								}elseif ($v3['msg_disabled'] == '1'){
									$this->_input[$v3['tag'].'_msg'] = $v3['msg_check'];
								}
								$value_array[$v3['tag']] = $this->_input[$v3['tag'].'_mail'].'|'.$this->_input[$v3['tag'].'_msg'];
							}
						}
					}
				}
			}
		}
		
		$condition['id'] = $_SESSION['s_login']['id'];
		$array = $this->obj_remind->checkRemindExist($condition,'3');
		if (false == $array){
			$this->obj_remind->addRemind($value_array);
		}else {
			$this->obj_remind->modifyRemind($value_array,$array['remind_id']);
		}
		
		$url = "./member/own_remind.php";
		$this->redirectPath("succ",$url,$this->_lang['langRemindSetupSaveOk']);
	}
	
	/**
	 * 恢复默认值
	 */
	function _default_value(){
		$remind_array = array();
		$remind_array = $this->obj_remind->defaultRemindArray('2',$this->_lang);/*默认设置*/
		
		$remind_array['member_id'] = $_SESSION['s_login']['id'];
		$remind_array['date_line'] = time();
		
		
		$condition['id'] = $_SESSION['s_login']['id'];
		$array = $this->obj_remind->checkRemindExist($condition,'3');
		if (false == $array){
			$this->obj_remind->addRemind($remind_array);
		}else {
			$this->obj_remind->modifyRemind($remind_array,$array['remind_id']);
		}
		
		$url = "./member/own_remind.php";
		$this->redirectPath("succ",$url,$this->_lang['langResumeSetupSaveOk']);
	}
	
}

$remind_main = new OwnRemind();
$remind_main->main();
unset($remind_main);
?>