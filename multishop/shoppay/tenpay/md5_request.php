

<?php  
include_once("tenpay_config.php");
$tenpay_conf = new tenpay_config();
class tenpay_online_payment  
{
		var  $tenpay_config;
	function tenpay_online_payment()
	{
		global $tenpay_conf;
		$this->tenpay_config = $tenpay_conf;
	}

	//输出结果函数
	function ShowExitMsg($msg)
	  {
	  	//parent::beta_switch =="0"
		if ($this->tenpay_config->beta_switch =="0")
			{
				$strMsg="<body><html><meta name=\"TENCENT_ONELINE_PAYMENT\" content=\"China TENCENT\">\n";
			    $strMsg.= "<script language=javascript>\n";
			    $strMsg.= "window.location.href='".$this->tenpay_config->domain . $this->tenpay_config>tenpay_dir ."/tenpay_show.php";
			    $strMsg.= $msg;
			    $strMsg.= "';\n";
			    $strMsg.= "</script></body></html>";
			    Exit($strMsg);
			}
		else
			{
				echo  "do something";
			}
	  }
	  
	  
	  
	function tenpay_check_config ()//检查配置文件项目
	{
			$retcode = "0";
		
		 if (empty($this->tenpay_config->spid))
			 {
			 	$retcode = "09001";
				$retmsg  = "缺少商户号spid";
				
			 }
			 
			 if (empty($this->tenpay_config->sp_key))
			 {
			 	$retcode = "090002";
				$retmsg  = "缺少密钥sp_key";
				
			 }
			 
			 if (empty($this->tenpay_config->domain))
			 {
			 	$retcode = "09003";
				$retmsg  = "缺少网站地址domain";
				
			 }
			 
			 if (empty($this->tenpay_config->tenpay_dir))
			 {
				$retcode = "09004";
				$retmsg  = "缺少财付通安装目录tenpay_dir";
			 }
			 
			 
			 
			 
			 if (empty($this->tenpay_config->site_name))
			 {
			 	$retcode = "09005";
				$retmsg = "缺少网站名称";
			 }
			 
			 if (empty($this->tenpay_config->attach))
			 {
				$retcode = "09006";
				$retmsg = "缺少附加信息，默认设置为空";
				$this->tenpay_config->attach = "";
			 }
			 
			 if (empty($this->tenpay_config->pay_url))
			 {
				$retcode = "09009";
				$retmsg = "缺少支付网关地址，将被设置为https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi";
				$this->tenpay_config->pay_url = "https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi";
			 }
				
			return $retcode;

	}

	

	
	
	
	//产生支付链接
	function tenpay_interface_pay ($bank_type,$desc,$purchaser_id,$sp_billno,$total_fee,$attach,$ip)
	{
		
		
		$config_retcode = $this->tenpay_check_config ();
		if ($config_retcode!="0")
			die("请检查配置文件tenpay_config.php中的各配置项是否正确配置");
			
		if (empty($sp_billno))
			 {
			 	$retcode = "09001";
				$retmsg  = "缺少sp_billno";
				
			 }
			 
			 if (empty($total_fee))
			 {
			 	$retcode = "090012";
				$retmsg  = "缺少total_fee";
				
			 }
			 
			 if ($bank_type=="")
			 {
			 	$retcode = "06001";
				$retmsg  = "缺少bank_type，将被默认设置为0";
				$bank_type = "0";
			 }
			 
			 if ($desc=="")
			 {

				$retcode = "06002";
				$retmsg  = "缺少商品名称desc，将被默认设置为".$this->tenpay_config->site_name."订单：" . $sp_billno;;
				$desc = $this->tenpay_config->site_name."" . $sp_billno;
				}
			 
			 
			 
			 
			 if (empty($purchaser_id))
			 {
			 	$retcode = "06003";
				$retmsg = "缺少买家帐号信息，将被默认设置为空";
				$purchaser_id = "";
			 }
			 
			 if (empty($attach))
			 {
				$retcode = "06004";
				$retmsg = "缺少附加信息，默认设置为空";
				$attach = "";
			 }
				
		
		 		  
		if ($retcode < "09000")//判断是否为严重错误，>09000为严重错误
		{
			if ($beta_switch == "1") //判断测试开关，如果开启测试，支付金额为1分 
			{
				$total_fee = "0";
					
				
				$sign_text ="cmdno=1" . "&date=" . date('Ymd') . "&bargainor_id=" . $this->tenpay_config->spid ."&transaction_id=" . $this->tenpay_config->spid . date('Ymd').time()."&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee . "&fee_type=1"  . "&return_url=" . $this->tenpay_config->domain . $this->tenpay_config->tenpay_dir ."tenpay/tenpay_notify.php".
"&attach=" . $attach ;
				if($ip != "")
				{
					$sign_text = $sign_text . "&spbill_create_ip=" . $ip;
				}
				$strSign = strtoupper(md5($sign_text."&key=".$this->tenpay_config->sp_key));
				$redurl = $this->tenpay_config->pay_url . "?".$sign_text . "&sign=" . $strSign."&desc=".$desc."&bank_type=".$bank_type;
				
				echo $retcode . "<br></br>".$retmsg."<br></br>";
				echo $redurl;
				
				return $redurl;
			}
			else
			{
				$sign_text ="cmdno=1" . "&date=" . date('Ymd') . "&bargainor_id=" . $this->tenpay_config->spid ."&transaction_id=" . $this->tenpay_config->spid . date('Ymd').time()."&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee . "&fee_type=1"  . "&return_url=" . $this->tenpay_config->domain . $this->tenpay_config->tenpay_dir ."tenpay/tenpay_notify.php".
"&attach=" . $attach ;
				if($ip != "")
				{
					$sign_text = $sign_text . "&spbill_create_ip=" . $ip;
				}
				$strSign = strtoupper(md5($sign_text."&key=".$this->tenpay_config->sp_key));
				$redurl = $this->tenpay_config->pay_url . "?".$sign_text . "&sign=" . $strSign."&desc=".$desc."&bank_type=".$bank_type;
				return $redurl;
			}
		}
		 
		
		
	}
	
}
  
  
?>
