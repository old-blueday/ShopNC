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
	 * 预存款对象
	 *
	 * @var obj
	 */
	var $obj_predeposit;
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
		 * 初始化预存款类
		 */
		if (!is_object($this->obj_predeposit)){
			require_once("predeposit.class.php");
			$this->obj_predeposit = new PredepositClass();
		}
		/**
		 * 取充值记录
		 */
		$predeposit_r_id = intval($this->_input['orderId']);
		$record_array = $this->obj_predeposit->getOnePredepositRecordById($predeposit_r_id);
		if (is_array($record_array)){
			//更新充值信息
			$value_array = array();
			$value_array['predeposit_r_id'] = $predeposit_r_id;
			$value_array['payment_trade'] = $this->_input['dealId'];
			$value_array['record_state'] = '1';
			$this->obj_predeposit->updatePredepositRecord($value_array);
			unset($value_array);
			//增加预付款明细
			$value_array = array();
			$value_array['predeposit_type'] = '0';//会员充值
			$value_array['predeposit_state'] = '1';
			$value_array['member_id'] = $record_array['member_id'];
			$value_array['available_amount'] = $record_array['online_amount'];
			$value_array['system_remark'] = $this->_lang['langKqpayOnlinePay'];
			$value_array['create_time'] = time();
			$value_array['update_time'] = time();
			$value_array['payment'] = $record_array['payment'];
			$value_array['predeposit_r_id'] = $predeposit_r_id;
			$this->obj_predeposit->addPredepositDetail($value_array);
			unset($value_array);
			//对会员帐户进行资金操作
			$value_array = array();
			$value_array['available_predeposit'] = $record_array['online_amount'];
			$this->obj_member->modifyMember($value_array,$record_array['member_id'],'predeposit');
			unset($value_array);
			@header("Location: ../../member/own_predeposit.php?action=record_list");
		}else {
			echo "ID非法";exit;
		}
	}
}
$obj_kqpay = new kqPayEnd();
$obj_kqpay->main();
unset($obj_kqpay);
?>