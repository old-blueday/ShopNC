<?php

//---------------------------------------------------------
//财付通即时到帐支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
include("../../global.inc.php");
require_once ("./classes/PayResponseHandler.class.php");

class tenpayIndex extends CommonFrameWork{
	function main(){
		//取帐号配置文件信息
		$pay_array = $this->_getconfigini("payment.ini.php");
		//参数
		$array = array();
		$array['key'] = $pay_array['online']['tenpay_key'];//密钥
		return $array;
	}

	//处理成功后的支付信息
	// $transaction_id 交易单流水号,$total_fee 金额,以分为单位
	function succPay($transaction_id,$total_fee){
		$this->getlang("own_predeposit");
		//取充值记录
		require_once("predeposit.class.php");
		$obj_predeposit = new PredepositClass();
		require_once ("member.class.php");
		$obj_member = new MemberClass();
		//取记录内容
		$record_array = $obj_predeposit->getOnePredepositRecordByTrade($transaction_id);
		if($record_array['record_state'] == '0'){//判断是否已经处理过
			//更新记录状态
			$value_array = array();
			$value_array['predeposit_r_id'] = $record_array['predeposit_r_id'];
			$value_array['record_state'] = '1';
			$value_array['system_remark'] = $this->_lang['langTenpayOnlinePay'];
			$value_array['online_amount'] = $total_fee/100;
			$obj_predeposit->updatePredepositRecord($value_array);
			unset($value_array);
			//增加预付款明细
			$value_array = array();
			$value_array['predeposit_type'] = '0';//会员充值
			$value_array['predeposit_state'] = '1';
			$value_array['member_id'] = $record_array['member_id'];
			$value_array['available_amount'] = $total_fee/100;
			$value_array['system_remark'] = $this->_lang['langTenpayOnlinePay'];
			$value_array['create_time'] = time();
			$value_array['update_time'] = time();
			$value_array['payment'] = $record_array['payment'];
			$value_array['predeposit_r_id'] = $record_array['predeposit_r_id'];
			$obj_predeposit->addPredepositDetail($value_array);
			unset($value_array);
			//对会员帐户进行资金操作
			$value_array = array();
			$value_array['available_predeposit'] = $total_fee/100;
			$obj_member->modifyMember($value_array,$record_array['member_id'],'predeposit');
			unset($value_array);
		}
		unset($obj_predeposit,$obj_member);

		//跳转
		$this->redirectPath("error","../member/own_predeposit.php?action=list",$this->_lang['langPreDetailStateOne']);
	}
}

//创建 商城支付方式对象
$obj_payment = new tenpayIndex();
$payment_array = $obj_payment->main();

/* 密钥 */
$key = $payment_array['key'];

/* 创建支付应答对象 */
$resHandler = new PayResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//交易单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	
	//支付结果
	$pay_result = $resHandler->getParameter("pay_result");
	
	if( "0" == $pay_result ) {
		//------------------------------
		//处理业务开始
		//------------------------------
		
		$obj_payment->succPay($transaction_id,$total_fee);

		//注意交易单不要重复处理
		//注意判断返回金额
		
		//------------------------------
		//处理业务完毕
		//------------------------------	
		
		//调用doShow, 打印meta值跟js代码,告诉财付通处理成功,并在用户浏览器显示$show页面.
		//$show = "http://localhost/tenpay/show.php";
		//$resHandler->doShow($show);
	
	} else {
		//当做不成功处理
		echo "<br/>" . "支付失败" . "<br/>";exit;
	}
	
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";exit;
}

//echo $resHandler->getDebugInfo();

?>