<?php
class DedeCmsAip extends BaseInitialize{
	/*--------------------------------------
	本文件用于第三方系统反向整合DedeCms在相关程序调用的接口

	调用本文件的接口函数前必须不能输出任何字符，本API不需要导入被整合系统的数据

	使用本接口的系统必须支持 file_get_contents 函数
	--------------------------------------*/

	//这里请填写DedeCms系统的cookie加密码（通行证密钥）

	var $cfg_cookie_encode = "";

	//Cookie主域名(用 "abc.com" 形式，不要加主机名，本地域名留空)

	var $domain = "";

	//DedeCms通行证接口网址
	//如果程序装在根目录，一般为 http://localhost/member/passport/pp_dederemote_new.php
	//如果你不想让人知道dedecms这个接口(pp_dederemote.php)的真实网址，你也可以把它改其它名称

	var $DedeAPI_Url = "";


	function DedeCmsAip(){
		$this->_initialize();
		$this->cfg_cookie_encode = $this->_configinfo['api']['passport_key'];
		$this->domain = $this->_configinfo['cookie']['cookiedomain'];
		$this->DedeAPI_Url = $this->_configinfo['api']['dedecms_path'] . "/member/passport/pp_dederemote_new.php";
	}
	
	//----------------------------------
	//第三方系统与Dedecms系统同步注册、登录、更改密码、退出接口函数
	//SynchDedeCms($userid,$action,$exptime='36000')
	//参数说明
	/*-------------------------
	$userid          用户登录的用户名，必须
	$action          动作，必须，选项为：reg edit login exit test(测试用户ID是否存在)
	$exptime='36000' cookie保存时间，单位为秒
	返回值：
	返回字串前三位为OK!表示操作成功
	返回其它则是错误提示
	--------------------------*/
	function SynchDedeCms($userid,$action,$username="",$email="",$exptime='36000')
	{
		if($this->domain!='') $cpath = '';
		else $cpath = '/';

		$keys = Array('userid','username','email','action','exptime');
		$querystr = '';
		foreach($keys as $v){
			if(!empty($$v)) $querystr .= $v.'='.urlencode($$v).'&';
		}
		$signstr = substr(md5($userid.$this->cfg_cookie_encode),0,24);
		$querystr .= "signstr=$signstr";
		$this->DedeAPI_Url = $this->DedeAPI_Url."?rmdata=".base64_encode($querystr);

		if(function_exists("file_get_contents")){
			//echo $action . $this->DedeAPI_Url;
			$rcdata = file_get_contents($this->DedeAPI_Url) or die("远程通信错误！");
			//echo $rcdata;
			//exit;
		}else{
			require_once(dirname(__FILE__)."/pub_httpdown.php");
			$dhd = new DedeHttpDown();
			$dhd->OpenUrl($this->DedeAPI_Url);
			$rcdata = $dhd->GetHtml();
			$dhd->Close();
		}
		//echo substr($rcdata,0,3);exit;
		if(substr($rcdata,0,3)=='OK!'){
			$okdata = ereg_replace("^OK!","",$rcdata);
			if($okdata!=""){
				$headerStr = trim($okdata);
				//echo $headerStr;exit;
				$this->PutCookie("DedeUserID",$headerStr,$exptime,$cpath,$this->domain);
				$this->PutCookie("DedeUserIDckMd5",substr(md5($this->cfg_cookie_encode.$headerStr),0,16),$exptime,$cpath,$this->domain);
			//	print_r($_COOKIE);
				//echo "-----------------------";
			}
			return 'OK';
		}else{
			return $rcdata;
		}
	}

	//按默认参数设置一个Cookie
	function PutCookie($key,$value,$kptime,$pa='/',$dm=''){
		setcookie($key,$value,time()+$kptime,$pa,$dm);
		setcookie($key.'ckMd5',substr(md5($this->cfg_cookie_encode.$value),0,16),time()+$kptime,$pa,$dm);
	}
}
?>