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
 * FILE_NAME : own_credits.php
 * ....会员积分
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Fri Jun 19 09:44:49 CST 2009
 */

require_once('../global.inc.php');

class OwnCreditsManage extends memberFrameWork{
	/**
     * 积分对象
     *
     * @var obj
     */
    var $obj_credits;
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
     * 用户组对象
     *
     * @var obj
     */
	var $obj_member_group;
	
    function main(){
    	/**
		 * 创建积分对象
		 */
		if (!is_object($this->obj_credits)){
			require_once("credits.class.php");
			$this->obj_credits = new CreditsClass();
		}
    	/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}		
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
         * 创建用户组对象
         */
		if (!is_object($this->obj_member_group))
		{
			require_once('member_group.class.php');
			$this->obj_member_group = new MemberGroupClass();
		}
			
		/**
         * 语言包
         */
        $this->getlang("own_credits");
        
		/**
		 * 菜单输出
		 */
		$this->memberMenu('account','client_server','credits_log');	        
        
        switch ($this->_input['action']){
        	case 'info':
        		$this->_info();
        		break;
        	default:
        		$this->_log_list();
        }
    }    
    /**
     * 日志列表
     */
    function _log_list(){
    	$condition_l['member_id'] = $_SESSION['s_login']['id'];
    	$condition_l['order_by'] = 'cl_id desc';
		$this->obj_page->pagebarnum(10);
		$log_list = $this->obj_credits->getCreditsLogList($condition_l,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		if (!empty($log_list)) {
			foreach ($log_list as $k => $v){
				$log_list[$k]['cl_time'] = date('Y-m-d',$v['cl_time']);
			}
		}
		//会员信息
		$member_array = $this->_get_member_info();
		/**
		 * 页面输出
		 */
		$this->output('member_array',$member_array);
		$this->output('log_list',$log_list);
		$this->output('page_list',$page_list);
		$this->showpage('own_credits.log_list');
    }
    
    /**
     * 用户组说明
     */
    function _info(){
    	//会员组
		$condition['order_by'] = 'mg_score_lower asc';
		$group_array = $this->obj_member_group->getMemberGroupList($condition,$page);
		if (is_array($group_array)){
			//计算会员组星星数
			foreach ($group_array as $k => $v){
				$line = '';
				for ($i=0;$i<$v['mg_stars'];$i++){
					$line .= "<img src='". $this->_configinfo['websit']['site_url'].'/templates/member/images/star.gif'."'>";
				}
				$group_array[$k]['group_star'] = $line;
			}
				
		}
		//会员信息
		$member_array = $this->_get_member_info();
		/**
		 * 页面输出
		 */
		$this->output('group_count',count($group_array));
		$this->output('group_array',$group_array);
		$this->output('member_array',$member_array);
    	$this->showpage('own_credits.info');
    }
    
    /**
     * 取会员信息
     */
    function _get_member_info(){
		$condition_m['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->obj_member->getMemberInfo($condition_m,'extcredits_exp,extcredits_points','more');
		if ($member_array['mg_id'] != ''){
			//查找用户组
			$group_row = $this->obj_member_group->getMemberGroupRow($member_array['mg_id']);
			$member_array['group_name'] = $group_row['mg_name'];
			//星星数
			$line = '';
			for ($i=0;$i<$group_row['mg_stars'];$i++){
				$line .= "<img src='". $this->_configinfo['websit']['site_url'].'/templates/member/images/star.gif'."' align='absmiddle' />";
			}
			$member_array['group_star'] = $line;
		}
		return $member_array;
    }
}
$credits_manage = new OwnCreditsManage();
$credits_manage->main();
unset ($credits_manage);
?>