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
 * FILE_NAME : index.php   FILE_PATH : E:\www\multishop\trunk\payment\tenpay\index.php
 * ....财付通支付方式链接跳转
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team
 * @package 
 * @subpackage 
 * @version Thu May 08 10:17:14 CST 2008
 */

include("../../global.inc.php");//加载信息

class tenpayIndex extends CommonFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 缴费对象
	 *
	 * @var obj
	 */
	var $obj_shop_pay;

	function main(){
		if($_SESSION['s_login']['id'] == ''){
			$this->redirectPath("error","",$this->_lang['langCMemberIsEmpty']);
		}
//		if ($this->_input['predeposit_r_id'] == ''){
//			$this->redirectPath("error","",'信息ID非法');
//		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化缴费类
		 */
		if (!is_object($this->obj_shop_pay)){
			require_once("shop_pay.class.php");
			$this->obj_shop_pay = new shopPayClass();
		}
		
		//验证信息是否与会员相符
		$detail_array = $this->obj_shop_pay->getShopPayDetail($this->_input['pay_detail_id']);
		if ($detail_array['member_id'] != $_SESSION['s_login']['id']){
			$this->redirectPath("error","",$this->_lang['langCIdIsIllegal']);
		}
		
		//参数
		$array = array();
		$array['desc'] = 'shop_pay';
		$array['sp_billno'] = $detail_array['pay_detail_id'];//订单号
		$array['total_fee'] = $detail_array['pay_mode_money']*100;//商品价格,单位为分
		$array['transport_desc'] = 'transport_desc';//物流说明

		return $array;
	}
}

$tenpay_index = new tenpayIndex();
$tenpay_param = $tenpay_index->main();
//路径输出
	require_once("md5_request.php");
	$tenpay = new tenpay_online_payment;
	$url = $tenpay->tenpay_interface_pay ("0","$tenpay_param[desc]","",$tenpay_param['sp_billno'],$tenpay_param['total_fee'],"",$_SERVER["REMOTE_ADDR"]);
//if($tenpay_param['sp_billno'] !== ''){
//	$url = 'https://www.tenpay.com/med/tradeDetail.shtml?b=1&trans_id='.$tenpay_param['sp_billno'];
//}else{
//	
//}

header("location: $url");exit;
?>
