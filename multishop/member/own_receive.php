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
 * FILE_NAME : own_recieve.php   FILE_PATH : \multishop\member\own_recieve.php
 * ....收货地址管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Sep 21 16:25:13 CST 2007
 */

require ("../global.inc.php");

class OwnReceiveManage extends memberFrameWork{
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	
	function main(){
		/**
		 * 创建文章对象
		 */
		if (!is_object($this->obj_receive)){
			require_once("receive.class.php");
			$this->obj_receive = new ReceiveClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 创建地区对象
		 */
		if (!is_object($this->obj_area)){
			require_once ("area.class.php");
			$this->obj_area = new AreaClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("receive");
		
		/**
		 * 菜单输出
		 */
		$this->memberMenu('account','basic_set','consignee_address');		

		switch($this->_input['action']){
			case "addsave":
				$this->_addsaveReceive();
				break;
			case "del":
				$this->_deleReceive();
				break;
			case "modisave":
				$this->_modisaveReceive();
				break;
			default:
				$this->_getReceive();
		}
	}

	/**
	 * 得到收货地址列表
	 *
	 */
	function _getReceive(){
		//收货地址信息
		$receive_array = $this->obj_receive->getReceive($_SESSION['s_login']['id']);
		//取收货地址的地区信息
		if (is_array($receive_array)){
			foreach ($receive_array as $k => $v){
				if ($v['receive_area_id'] != ''){
					$sel_area = $this->obj_area->getAreaPathList($v['receive_area_id']);
					$receive_array[$k]['area'] = $sel_area;
					unset($sel_area);
				}else {//如果不存在则调用老的信息
					$receive_array[$k]['area'][0]['area_name'] = $v['province'];
					$receive_array[$k]['area'][1]['area_name'] = $v['city'];
				}
			}
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
		/**
		 * 页面输出
		 */
		$this->output('area_array',$area_array);
		$this->output('receive_array',$receive_array);
		$this->showpage("own_receive.manage");
	}

	/**
	 * 保存新增收货地址
	 *
	 */
	function _addsaveReceive(){
		/**
		 * 验证信息
		 */
		$error = $this->_Validate($this->_input);
		if ($error != "" ){
			$this->redirectPath("error","",$error);
		}else{
			//判断地址个数，如果超过5个，则报错
			$receive_array = $this->obj_receive->getReceive($_SESSION['s_login']['id']);
			if (count($receive_array) >= 5 ){
				$this->redirectPath("error","",$this->_lang['langRBeyondNum']);
			}
			/**
			 * 获得随机的唯一编码
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

			$this->_input['member_id'] = $_SESSION['s_login']['id'];
			$this->obj_receive->addReceive($this->_input);
			$this->redirectPath("succ","member/own_receive.php",$this->_lang['langRAddAddressSucceed']);
		}
	}
	
	/**
	 * 删除收货地址
	 *
	 */
	function _deleReceive(){
		if ($this->_input['receiveid'] != ''){
			$this->obj_receive->delReceive($this->_input['receiveid'],$_SESSION['s_login']['id']);
			$this->redirectPath("succ","member/own_receive.php",$this->_lang['langRDelAddressSucceed']);
		}else {
			$this->redirectPath("error","member/own_receive.php",$this->_lang['errRDelIsFaild']);
		}
	}
	
	/**
	 * 保存修改信息
	 *
	 */
	function _modisaveReceive(){
		$error = $this->_Validate($this->_input);
		if ($error != "" ){
			$this->redirectPath("error","",$error);
		}else{
			$exist = $this->obj_receive->isExistReceive($this->_input['receive_id'],'receive_id',$_SESSION['s_login']['id']);
			if ($exist == true){
				$this->obj_receive->modiReceive($this->_input);
				$this->redirectPath("succ","member/own_receive.php",$this->_lang['langRAmendAddressSucceed']);exit;
			}
			$this->redirectPath("error","",$this->_lang['langRAddressNonentity'].$exist);
		}
	}
	
	/**
	 * 验证修改新增收货地址
	 *
	 * @return unknown
	 */
	function _Validate($line){
		/**
		 * 验证信息
		 */
		$this->objvalidate->setValidate(array("input"=>$line['txtReceiveName'],"require"=>"true","message"=>$this->_lang['langRFillInConsigneeName']));
		$this->objvalidate->setValidate(array("input"=>$line['area_id'],"require"=>"true","message"=>$this->_lang['langRFillInLocality']));
		$this->objvalidate->setValidate(array("input"=>$line['txtAddress'],"require"=>"true","message"=>$this->_lang['langRFillInParticularAddress']));
		$this->objvalidate->setValidate(array("input"=>$line['txtZip'],"require"=>"true","message"=>$this->_lang['langRFillInPostalcode']));
		$error = $this->objvalidate->validate();
		return $error;
	}
}

$receive_manage = new OwnReceiveManage();
$receive_manage->main();
unset($receive_manage);
?>