<?
include_once("tenpay_config.php");
$tenpay_conf = new tenpay_config();
	function ShowExitMsg($msg,$iodata = NULL)
	  {
	  	global  $tenpay_conf;
	  	echo $tenpay_conf->beta_switch;
		if ($tenpay_conf->beta_switch =="0")
			{
				$strMsg="<body><html><meta name=\"TENCENT_ONELINE_PAYMENT\" content=\"China TENCENT\">\n";
			    $strMsg.= "<script language=javascript>\n";
			    $strMsg.= "window.location.href='".$tenpay_conf->domain . $tenpay_conf->tenpay_dir ."/tenpay_show.php?msg=";
			    $strMsg.= $msg;
			    $strMsg.= "';\n";
			    $strMsg.= "</script></body></html>";
			    Exit($strMsg);
			 
			}
		else
			{
				
//				$tenpay_err = $iodata;
				echo  $msg,"<br/>";
				$htmlstring = "<html><body>".$iodata."</body></html>";
				echo $htmlstring,"<br/>";
			//	echo __file__,__line__;
			}
	  }

  import_request_variables("gpc", "frm_");
  /*取返回参数*/
  $strCmdno			= $frm_cmdno;
  $strPayResult		= $frm_pay_result;
  $strPayInfo		= $frm_pay_info;
  $strBillDate		= $frm_date;
  $strBargainorId	= $frm_bargainor_id;
  $strTransactionId	= $frm_transaction_id;
  $strSpBillno		= $frm_sp_billno;
  $strTotalFee		= $frm_total_fee;
  $strFeeType		= $frm_fee_type;
  $strAttach		= $frm_attach;
  $strMd5Sign		= $frm_sign;

$retcode = "0";
$retmsg ="支付成功";


//错误码信息
//retcode = "0"					 支付成功	
//retmsg = "支付成功"				

//retcode = "1"					 商户号错误
//retmsg = " 商户号错误"				

//retcode = "2"					签名错误
//retmsg = "签名错误"				

//retcode = "3"					 财付通返回支付失败	
//retmsg = "财付通返回支付失败"	  



  /*验签*/
  $strResponseText  = "cmdno=" . $strCmdno . "&pay_result=" . $strPayResult . 
		                  "&date=" . $strBillDate . "&transaction_id=" . $strTransactionId .
			                "&sp_billno=" . $strSpBillno . "&total_fee=" . $strTotalFee .
			                "&fee_type=" . $strFeeType . "&attach=" . $strAttach .
			                "&key=" . $tenpay_conf->sp_key;
  $strLocalSign = strtoupper(md5($strResponseText));     
  
  if( $strLocalSign  != $strMd5Sign)
  {
  	//验证MD5签名失败
	//植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理
	$retcode = "2";
	$retmsg = "验证MD5签名失败";
    ShowExitMsg( "验证MD5签名失败.",$strResponseText); 
  }  

  if($tenpay_conf->spid != $strBargainorId )
  {
  	//错误的商户号
    //植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理

	echo $strBargainorId,"<br/>";
	echo $tenpay_conf->spid;
	$retcode = "1";
	$retmsg = "错误的商户号";
    ShowExitMsg( "错误的商户号.",$strResponseText); 
  }

  if( $strPayResult != "0" )
  {
  	//支付失败，系统错误
    //植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理

	$retcode = "3";
	$retmsg = "支付失败，系统错误";
    ShowExitMsg( "支付失败，系统错误.",$strResponseText); 
  }
  
  if ($retcode == "0")
  {
  	//支付成功
    //植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理
	if($strSpBillno != ''){
		//取充值记录
		require_once("shop_pay.class.php");
		$obj_shop_pay = new shopPayClass();
		require_once ("member.class.php");
		$obj_member = new MemberClass();
		//取记录内容
		$detail_array = $obj_shop_pay->getShopPayDetail($strSpBillno);
		if($detail_array['pay_sign'] == '0'){//判断是否已经处理过
			//更新记录状态
			$value_array = array();
			$value_array['pay_detail_id'] = $detail_array['pay_detail_id'];
			$value_array['pay_sign'] = '2';
//			$value_array['online_amount'] = $strTotalFee/100;
			$obj_shop_pay->updateShopPayDetail($value_array);
			unset($value_array);
			//更新会员信息
			//取会员信息
			$condition_member['id'] = $detail_array['member_id'];
			$member_array = $obj_member->getMemberInfo($condition_member,'*','more');
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
			$obj_member->modifyMember($value_array,$detail_array['member_id'],"shoppay");
			unset($value_array);
		}
		unset($obj_predeposit,$obj_member);
		@header("Location: ../../member/own_shop_pay.php?action=detail_list");
		exit;
	}else{
		echo "支付失败,记录号为空";
	}


	//  ShowExitMsg( "支付成功.",$strResponseText); 
  }
  
  
?>
