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
 * FILE_NAME : credits_act.class.php
 * ....积分活动管理
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Jun 08 09:22:06 CST 2009
 */

class CreditsActClass extends FrameWork {
	/**
	 * 删除兑换申请
	 *
	 * @param int $id
	 * @param int $member_id
	 * @return bool
	 */
	function delApply ( $id, $member_id=0 ) {
		if ( intval( $id ) > 0 ) {
			if ( intval( $member_id ) > 0 ){
				$condition = " and caa_member_id = '" . $member_id . "'";
			}
			$del_rs = $GLOBALS['db']->DelRow($id,'credits_act_apply','caa_id',$condition);
			return $del_rs;
		}		
	}
	/**
	 * 获取活动列表
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @param  $obj_page 分页
	 * @return array
	 */
	function getCreditsActList($condition,&$obj_page){
		$condition_str = $this->_conditionSearch($condition);
		$act_array = $GLOBALS['db']->GetList($condition_str,$obj_page,'credits_act');
		return $act_array;
	}
	
	/**
	 * 构造检索条件
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @return string
	 */
	function _conditionSearch($condition){
		$condition_str = '';
		
		if ($condition['ca_state'] != ''){
			$condition_str .= "and ca_state = '" . $condition['ca_state'] . "'";
		}
		if ($condition['ca_add_time'] != ''){
			$condition_str .= "and ca_add_time = '" . $condition['ca_add_time'] . "'";
		}
		if ($condition['ca_end_time'] != ''){
			$condition_str .= "and ca_end_time = '" . $condition['ca_end_time'] . "'";
		}
		if ($condition['ca_member_id'] != ''){
			$condition_str .= "and ca_member_id = '" . $condition['ca_member_id'] . "'";
		}
		
		$condition_str .= "and ca_del = '0'";
		
		if ($condition['order_by'] != ''){
			$condition_str .= "order by ".$condition['order_by'];
		}
		return $condition_str;
	}
	
	/**
	 * 增加活动
	 * @author ShopNC Develop Team     
	 * @param  $input_param 参数
	 * @return bool
	 */
	function addCreditsAct($input_param){
		$arr = array();
		if (is_array($input_param)){
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$result = $GLOBALS['db']->InsertRow($arr,"credits_act","ca_id");
		return $result;
	}
	
	/**
	 * 取指定ID的活动信息
	 * @author ShopNC Develop Team     
	 * @param  $id 活动ID
	 * @return array
	 */
	function getCreditsActRow($id){
		$act_row = $GLOBALS['db']->GetOneRow($id,'credits_act','ca_id');
		return $act_row;
	}
	
	/**
	 * 更新活动信息
	 * @author ShopNC Develop Team     
	 * @param  $input_param 信息内容
	 * @return bool
	 */
	function updateCreditsAct($input_param){
		if (is_array($input_param)){
			$arr = array();
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$update_rs = $GLOBALS['db']->UpdateRow($arr['ca_id'],$arr, 'credits_act', 'ca_id');
		return $update_rs;
	}
	
	/**
	 * 更新过期的活动，将过期的活动状态修改为已过期
	 * @author ShopNC Develop Team     
	 * @param  
	 * @return bool
	 */
	function updateCreditsActEndTime(){
		$condition = " ca_end_time < '" . time() . "'";
		$value_array = array();
		$value_array['ca_state'] = 1;
		$update_rs = $GLOBALS['db']->UpdateRows('credits_act', $value_array, $condition);
		return $update_rs;
	}
	
	
	/**
	 * 增加活动商品
	 * @author ShopNC Develop Team     
	 * @param  $input_param 参数
	 * @return bool
	 */
	function addCreditsActGoods($input_param){
		$arr = array();
		if (is_array($input_param)){
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$result = $GLOBALS['db']->InsertRow($arr,"credits_act_goods","cag_id");
		return $result;
	}
	
	/**
	 * 获取兑换商品列表
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @param  $obj_page 分页
	 * @return array
	 */
	function getCreditsActGoodsList($condition,&$obj_page){
		$condition_str = $this->_conditionGoodsSearch($condition);
		$act_array = $GLOBALS['db']->GetList($condition_str,$obj_page,'credits_act_goods');
		return $act_array;
	}
	
	/**
	 * 构造检索条件
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @return string
	 */
	function _conditionGoodsSearch($condition){
		$condition_str = '';
		
		if ($condition['ca_id'] != ''){
			$condition_str .= "and ca_id = '" . $condition['ca_id'] . "'";
		}
		
		return $condition_str;
	}
	
	/**
	 * 删除商品
	 * @author ShopNC Develop Team     
	 * @param  $id 商品ID
	 * @return bool
	 */
	function delCreditsActGoods($id){
		if (intval($id) > 0) {
			return $GLOBALS['db']->DeleOneRow(intval($id),'credits_act_goods','cag_id');
		}else {
			return false;
		}
	}
	
	/**
	 * 取指定ID的商品信息
	 * @author ShopNC Develop Team     
	 * @param  $id 活动ID
	 * @param  $type 类型
	 * @return array
	 */
	function getCreditsActGoodsRow($id,$type='simple'){
		if ($type == 'simple'){
			$act_row = $GLOBALS['db']->GetOneRow($id,'credits_act_goods','cag_id');
		}else {
			$condition_str = "and credits_act_goods.cag_id='" . $id . "'";
			$act_row = $GLOBALS['db']->GetOneJoinArray(array('credits_act_goods','credits_act'),"left join",array("credits_act_goods.ca_id=credits_act.ca_id"),array('*','ca_id,ca_end_time'),$condition_str);
		}
		return $act_row;
	}
	
	/**
	 * 修改商品信息
	 * @author ShopNC Develop Team     
	 * @param  $input_param 内容
	 * @return bool
	 */
	function updateCreditsActGoods($input_param){
		if (is_array($input_param)){
			$arr = array();
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$update_rs = $GLOBALS['db']->UpdateRow($arr['cag_id'],$arr, 'credits_act_goods', 'cag_id');
		return $update_rs;
	}
	
	/**
	 * 获取活动留言列表
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @param  $obj_page 分页
	 * @return array
	 */
	function getCreditsActMsgList($condition,&$obj_page){
		$condition_str = $this->_conditionMsgSearch($condition);
		$msg_list = $GLOBALS['db']->GetJoinList($obj_page,array('credits_act_msg','member'),"left join",array("credits_act_msg.cam_member_id=member.member_id"),array('*','login_name'),$condition_str,0,array(" cam_time desc"));
		return $msg_list;
	}
	
	/**
	 * 构造检索条件
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @return string
	 */
	function _conditionMsgSearch($condition){
		$condition_str = '';
		
		if ($condition['ca_id'] != ''){
			$condition_str .= "and credits_act_msg.ca_id = '" . $condition['ca_id'] . "'";
		}
		
		return $condition_str;
	}
	
	
	/**
	 * 增加活动留言
	 * @author ShopNC Develop Team     
	 * @param  $input_param 参数
	 * @return bool
	 */
	function addCreditsActMsg($input_param){
		$arr = array();
		if (is_array($input_param)){
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$result = $GLOBALS['db']->InsertRow($arr,"credits_act_msg","cam_id");
		return $result;
	}
	
	/**
	 * 取指定ID的活动留言
	 * @author ShopNC Develop Team     
	 * @param  $id 留言内容ID
	 * @return array
	 */
	function getCreditsActMsg($id){
		$msg_arr = $GLOBALS['db']->GetOneRow($id,'credits_act_msg','cam_id');
		return $msg_arr;
	}
	
	/**
	 * 修改活动留言
	 * @author ShopNC Develop Team     
	 * @param  $input_param 参数
	 * @return bool
	 */
	function updateCreditsActMsg($input_param){
		if (is_array($input_param)){
			$arr = array();
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$update_rs = $GLOBALS['db']->UpdateRow($arr['cam_id'],$arr, 'credits_act_msg', 'cam_id');
		return $update_rs;
	}
	
	/**
	 * 删除留言信息
	 * @author ShopNC Develop Team     
	 * @param  $id 信息ID
	 * @return bool
	 */
	function delCreditsMsg($id){
		if (intval($id) > 0) {
			return $GLOBALS['db']->DeleOneRow(intval($id),'credits_act_msg','cam_id');
		}else {
			return false;
		}
	}
	
	/**
	 * 增加兑换商品申请
	 * @author ShopNC Develop Team     
	 * @param  $input_param 参数
	 * @return bool
	 */
	function addCreditsActApply($input_param){
		$arr = array();
		if (is_array($input_param)){
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$result = $GLOBALS['db']->InsertRow($arr,"credits_act_apply","caa_id");
		return $result;
	}
	
	/**
	 * 获取活动兑换申请列表
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @param  $obj_page 分页
	 * @return array
	 */
	function getCreditsActApplyList($condition,&$obj_page){
		$condition_str = $this->_conditionApplySearch($condition);
		$msg_list = $GLOBALS['db']->GetJoinList($obj_page,array('credits_act_apply','member','credits_act_goods'),"left join",array("credits_act_apply.caa_member_id=member.member_id","credits_act_apply.cag_id=credits_act_goods.cag_id"),array('*','login_name','cag_name'),$condition_str,0,array(" caa_time desc"));
		return $msg_list;
	}
	
	/**
	 * 构造检索条件
	 * @author ShopNC Develop Team     
	 * @param  $condition 检索条件
	 * @return string
	 */
	function _conditionApplySearch($condition){
		$condition_str = '';
		
		if ($condition['ca_id'] != ''){
			$condition_str .= "and credits_act_apply.ca_id = '" . $condition['ca_id'] . "'";
		}
		if ($condition['caa_member_id'] != ''){
			$condition_str .= "and credits_act_apply.caa_member_id = '" . $condition['caa_member_id'] . "'";
		}
		
		return $condition_str;
	}
	
	/**
	 * 取指定ID的申请兑换信息
	 * @author ShopNC Develop Team     
	 * @param  $id 活动ID
	 * @return array
	 */
	function getCreditsActApplyRow($id){
		$condition_str = "and credits_act_apply.caa_id='" . $id . "'";
		$act_apply_row = $GLOBALS['db']->GetOneJoinArray(array('credits_act_apply','member','credits_act_goods'),"left join",array("credits_act_apply.caa_member_id=member.member_id","credits_act_apply.cag_id=credits_act_goods.cag_id"),array('*','login_name','cag_name,cag_pic,cag_credits'),$condition_str);
		return $act_apply_row;
	}
	
	/**
	 * 修改活动申请
	 * @author ShopNC Develop Team     
	 * @param  $input_param 参数
	 * @return bool
	 */
	function updateCreditsActApply($input_param){
		if (is_array($input_param)){
			$arr = array();
			foreach ($input_param as $k => $v){
				$arr[$k] = $v;
			}
		}
		$update_rs = $GLOBALS['db']->UpdateRow($arr['caa_id'],$arr, 'credits_act_apply', 'caa_id');
		return $update_rs;
	}
}
?>