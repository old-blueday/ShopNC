<?PHP
/*
 * @Description: 快钱人民币支付网关接口范例
 * @Copyright (c) 上海快钱信息服务有限公司
 * @version 2.0
 */

/*
在本文件中，商家应从数据库中，查询到订单的状态信息以及订单的处理结果。给出支付人响应的提示。

本范例采用最简单的模式，直接从receive页面获取支付状态提示给用户。
*/

//$orderId=trim($_REQUEST['orderId']);
//$orderAmount=trim($_REQUEST['orderAmount']);
//$msg=trim($_REQUEST['msg']);

include("../../global.inc.php");
class kqPayEnd extends CommonFrameWork{
	/**
	 * 缴费对象
	 *
	 * @var obj
	 */
	var $obj_shop_pay;
	/**
	 * 会员对象
	 * 
	 * @var obj
	 */
	var $obj_member;

	function main(){
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
		/**
		 * 取记录内容
		 */
		$pay_detail_id = intval($this->_input['orderId']);
		$detail_array = $this->obj_shop_pay->getShopPayDetail($pay_detail_id);
		if($detail_array['pay_sign'] == '0'){//判断是否已经处理过
			//更新记录状态
			$value_array = array();
			$value_array['pay_detail_id'] = $detail_array['pay_detail_id'];
			$value_array['pay_sign'] = '2';
			$this->obj_shop_pay->updateShopPayDetail($value_array);
			unset($value_array);
			//更新会员信息
			//取会员信息
			$condition_member['id'] = $detail_array['member_id'];
			$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
			$value_array = array();
			//判断缴费类型
			switch ($detail_array['pay_mode_type']){
				case '0'://按照店铺使用时间缴费
					/**
					 * 如果会员资料中的店铺到期时间小于当前时间，则按照当前时间计算
					 * 如果时间大于当前时间，则累加会员资料中的到期时间
					 */
					if (time() >= $member_array['shop_availability_time']){
						$value_array['shop_availability_time'] = mktime(23,59,59,date('m'),date('d'),date('Y'))+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}else {
						$pay_time = mktime(23,59,59,date('m',$member_array['shop_availability_time']),date('d',$member_array['shop_availability_time']),date('Y',$member_array['shop_availability_time']));//时间为到期天数的最后一秒
						$value_array['shop_availability_time'] = $pay_time+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}
					break;
				case '1'://按照发布商品数量缴费
					$value_array['product_number'] = $member_array['product_number']+$detail_array['pay_mode_product_number'];
					break;
				case '2'://两者同时缴费
					/**
					 * 如果会员资料中的店铺到期时间小于当前时间，则按照当前时间计算
					 * 如果时间大于当前时间，则累加会员资料中的到期时间
					 */
					if (time() >= $member_array['shop_availability_time']){
						$value_array['shop_availability_time'] = mktime(23,59,59,date('m'),date('d'),date('Y'))+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}else {
						$pay_time = mktime(23,59,59,date('m',$member_array['shop_availability_time']),date('d',$member_array['shop_availability_time']),date('Y',$member_array['shop_availability_time']));//时间为到期天数的最后一秒
						$value_array['shop_availability_time'] = $pay_time+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}
					$value_array['product_number'] = $member_array['product_number']+$detail_array['pay_mode_product_number'];
					break;
			}
			$this->obj_member->modifyMember($value_array,$detail_array['member_id'],"shoppay");
			unset($value_array);
			@header("Location: ../../member/own_shop_pay.php?action=detail_list");
		}else {
			echo "支付失败,记录号为空";
		}
	}
}
$obj_kqpay = new kqPayEnd();
$obj_kqpay->main();
unset($obj_kqpay);
?>