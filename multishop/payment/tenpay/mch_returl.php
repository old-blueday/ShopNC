<?php

//---------------------------------------------------------
//财付通中介担保支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
include("../../global.inc.php");
require_once ("./classes/MediPayResponseHandler.class.php");

class tenpayIndex extends CommonFrameWork{
	
	var $site_url = '';

	function tenpayIndex(){
		parent::CommonFrameWork();
		$this->site_url = $this->_configinfo['websit']['site_url'];
	}

	function main(){
		//财付通平台 账号 密匙
		require_once(BasePath."/payment/tenpay/tenpay_config.php");
		$array['key'] = $key;
		$array['chnid'] = $chnid;
		return $array;
	}

	//更改订单状态,$status 订单状态,$cft_tid 财付通订单流水号
	function updateOrderState($mch_vno,$status,$cft_tid){
		if(!is_object($obj_product_order)){
			require_once("order.class.php");
			$obj_product_order = new ProductOrderClass();
		}
		
		if($status != ''){
			$order_array = $obj_product_order->getOneOrderBySpcode ( $mch_vno );
			switch ($order_array['sell_type']){
				case '0'://拍卖
					require_once('order_process_auction.class.php');
					$obj_order_process = new OrderProcessAuction();
					break;
				case '1'://一口价
					require_once('order_process_fixprice.class.php');
					$obj_order_process = new OrderProcessFixprice();
					break;
				case '2'://团购
					require_once('order_process_group.class.php');
					$obj_order_process = new OrderProcessGroup();
					break;
				case '3'://倒计时拍卖
					require_once('order_process_countdown.class.php');
					$obj_order_process = new OrderProcessCountdown();
					break;
				default:
					exit;
			}
			$obj_order_process->alipay_id = $cft_tid;
			$result = $obj_order_process->changeOrderState($order_array['sp_code'],$status);
			return $result;
		}else{
			return false;
		}
	}
	//更新订单的退款状态
	function updateOrderRefundState($mch_vno,$status,$cft_tid){
		if(!is_object($obj_product_order)){
			require_once("order.class.php");
			$obj_product_order = new ProductOrderClass();
		}
		
		if($status != ''){
			$order_array = $obj_product_order->getOneOrderBySpcode ( $mch_vno );
			switch ($order_array['sell_type']){
				case '0'://拍卖
					require_once('order_process_auction.class.php');
					$obj_order_process = new OrderProcessAuction();
					break;
				case '1'://一口价
					require_once('order_process_fixprice.class.php');
					$obj_order_process = new OrderProcessFixprice();
					break;
				case '2'://团购
					require_once('order_process_group.class.php');
					$obj_order_process = new OrderProcessGroup();
					break;
				case '3'://倒计时拍卖
					require_once('order_process_countdown.class.php');
					$obj_order_process = new OrderProcessCountdown();
					break;
				default:
					exit;
			}
			$obj_order_process->alipay_id = $cft_tid;
			$obj_order_process->payment_mechod = 'tenpay';
			$result = $obj_order_process->changeOrderRefundState($order_array['sp_code'],$status);
			return $result;
		}else{
			return false;
		}
	}
	

	//根据外部订单流水号 取订单内容  $cft_tid 财付通订单流水号
	function getOrderInfo($cft_tid){
		if($cft_tid != ''){
			$order_array = $obj_product_order->getOneOrderByAlipayId ( $cft_tid );
			return $order_array;
		}else{
			return false;
		}
	}

}

//创建 商城支付方式对象
$obj_payment = new tenpayIndex();
$payment_array = $obj_payment->main();

/* 平台商密钥 */
$key = $payment_array['key'];

/* 创建支付应答对象 */
$resHandler = new MediPayResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//财付通交易单号
	$cft_tid = $resHandler->getParameter("cft_tid");
	
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	
	//返回码
	$retcode = $resHandler->getParameter("retcode");
	
	//状态
	$status = $resHandler->getParameter("status");	
	
	//商城订单号
	$mch_vno = $resHandler->getParameter("mch_vno");	

	//------------------------------
	//处理业务开始
	//------------------------------
	
	//注意交易单不要重复处理
	//注意判断返回金额
	
	//返回码判断
	if( "0" == $retcode ) {

		switch ($status) {
			case 1: 
				//log_result('交易创建'.$cft_tid);
				//交易创建
				$obj_payment->updateOrderState($mch_vno,'0',$cft_tid);
				$url =$obj_payment->site_url.'/member/own_main.php';
				@header("Location: $url");
				exit;
				break;
			case 2:
				//收获地址填写完毕
				break;
			case 3:
				//log_result('买家支付成功'.$cft_tid);
				//买家付款成功，注意判断订单是否重复的逻辑
				$obj_payment->updateOrderState($mch_vno,'1',$cft_tid);
				$url = $obj_payment->site_url.'/member/own_order.php?action=bought';
				@header("Location: $url");
				exit;
				break;
			case 4:
				//卖家发货成功
				//log_result('卖家发货成功'.$cft_tid);
				$obj_payment->updateOrderState($mch_vno,'2',$cft_tid);
				//$url = $obj_payment->site_url.'/member/own_main.php';
				//@header("Location: $url");
				exit;
				break;
			case 5:
				//买家收货确认，交易成功
				//log_result('买家确认收货'.$cft_tid);
				$obj_payment->updateOrderState($mch_vno,'3',$cft_tid);
				//跳转到买家评价页面
				//如果是状态3的话，则跳转到评价页面
				$order_array = $obj_payment->getOrderInfo($cft_tid);
				$url = $obj_payment->site_url.'/member/own_score.php?action=add&orderid='.$order_array['sp_id'].'&type=bought';
				@header("Location: $url");
				exit;
				break;
			case 6:
				//交易关闭，未完成超时关闭
				//log_result('交易关闭'.$cft_tid);
				$obj_payment->updateOrderState($mch_vno,'6',$cft_tid);
				break;
			case 7:
				//修改交易价格成功
				break;
			case 8:
				//买家发起退款
				$obj_payment->updateOrderRefundState($mch_vno,'1',$cft_tid);
				break;
			case 9:
				//退款成功
				$obj_payment->updateOrderRefundState($mch_vno,'2',$cft_tid);
				break;
			case 10:
				//退款关闭
				$obj_payment->updateOrderRefundState($mch_vno,'3',$cft_tid);
				break;
			default:
				//error
				break;
		}
		
	} else {
		echo "支付失败";
	}
	
	//------------------------------
	//处理业务完毕
	//------------------------------	
	
	//调用doShow
	$resHandler->doShow();
	
	
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
}

function log_result($log){
	$fp = @fopen('log.txt','wb+');
	@fwrite($fp,$log);
	@fclose($fp);
}
//echo $resHandler->getDebugInfo();

?>