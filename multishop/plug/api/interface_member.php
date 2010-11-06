<?php
class InterfaceMember extends FrameWork {

	/**
	 * 初始化
	 *
	 * @return InterfaceMember
	 */
	function InterfaceMember(){
		$this->setFrameWork();
	}

	/**
	 * 会员登陆
	 *
	 * @param string $member_id
	 * @param string $member_name
	 * @param string $member_password
	 * @param string $member_email
	 * @param string $refer_url
	 * @param string $forward
	 * @param string $action
	 */
	function loginInterface($member_id,$member_name,$member_password,$member_email,$refer_url,$forward,$action){
		/**
		 * 使用UC接口
		 */
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
			define('UC_API', $this->_configinfo['ucenter']['uc_api']);
			define('UC_CONNECT', $this->_configinfo['ucenter']['uc_connect']);
			define('UC_DBHOST', $this->_configinfo['ucenter']['uc_dbhost']);
			define('UC_DBUSER', $this->_configinfo['ucenter']['uc_dbuser']);
			define('UC_DBPW', $this->_configinfo['ucenter']['uc_dbpw']);
			define('UC_DBNAME', $this->_configinfo['ucenter']['uc_dbname']);
			define('UC_DBCHARSET', $this->_configinfo['ucenter']['uc_dbcharset']);
			define('UC_DBTABLEPRE', $this->_configinfo['ucenter']['uc_dbname'].'.'.$this->_configinfo['ucenter']['uc_dbtablepre']);
			define('UC_KEY', $this->_configinfo['ucenter']['uc_key']);
			define('UC_CHARSET', $this->_configinfo['ucenter']['uc_charset']);
			define('UC_IP', $this->_configinfo['ucenter']['uc_ip']);
			define('UC_APPID', $this->_configinfo['ucenter']['uc_appid']);
			define('UC_PPP', $this->_configinfo['ucenter']['uc_ppp']);
			define('UC_LINK', $this->_configinfo['ucenter']['uc_link']);
			require_once(BasePath . "/uc_client/client.php");
			if ($action == "reg"){
				uc_user_register($member_name,$member_password,$member_email);
			}else if ($action == "login"){
				$return = uc_user_login($member_name,$member_password);
				//echo $return[0];exit;
				$ucsynlogin = uc_user_synlogin($return[0]);
				echo $ucsynlogin;
				echo "<script>location.href='" . $forward . "';</script>";exit;
			}
			$this->redirectPath("refer",$forward);
		}

		if (trim($this->_configinfo['api']['api_charset']) == ""){
			$this->_configinfo['api']['api_charset'] = "utf-8";
		}
		if (function_exists('iconv') && (strtolower($this->_configinfo['api']['api_charset']) != strtoupper($this->_configinfo['websit']['ncharset']))){
			$member_name = iconv($this->_configinfo['websit']['ncharset'],$this->_configinfo['api']['api_charset'],$member_name);
		}

		require_once("api.class.php");
		$api = new Api();
		
		if($forward == ""){
			$forward = $refer_url;
		}else {
			$forward = $forward;
		}
		
		if($this->_configinfo[api][open_passport] == '1'){
			//dedecms
			if ($this->_configinfo[api][open_dedecms] == '1'){
				require_once("../plug/api/dedecms/pp_dederemote_interface.php");
				require_once("../plug/api/dedecms/pub_httpdown.php");
				$dede_cms = new DedeCmsAip();
				$rcdata = $dede_cms->SynchDedeCms($member_id,$action,$member_name,$member_email);
//				$flag = @fopen($this->_configinfo[websit][site_url].'/plug/api/dedecms/pp_dederemote_interface.php','r');
//				$flag_two = @fopen($this->_configinfo[websit][site_url].'/plug/api/dedecms/pub_httpdown.php','r');
//				if ($flag == true && $flag_two == true){
//					require_once("../plug/api/dedecms/pp_dederemote_interface.php");
//					require_once("../plug/api/dedecms/pub_httpdown.php");
//					$dede_cms = new DedeCmsAip();
//					$rcdata = $dede_cms->SynchDedeCms($member_id,$action,$member_name,$member_email);
//				}else {
//					$this->redirectPath("error","","DEDEcms整合路径设置不正确");
//				}
			}

			/**
			 * phpcms
			 */
			if ($this->_configinfo[api][open_phpcms] == '1'){

				$passport_key = $this->_configinfo[api][passport_key];

				$autharray = array(
					'cookietime' => 3600,
					'time' => time(),
					'username' => $member_name,
					'password' => md5($member_password),
//					'email' => $member_email,
//					'answer' => $member_password
					'email' => $member_email
				);
				
				if ($action == "reg"){
					
					$action	= "login";
					$autharray['password'] = $member_password;
					
				}elseif ($action == "exit"){
					$action = "logout";
				}
				foreach ($autharray as $k => $v){
					$userdb_encode .= $userdb_encode ? "&$k=$v" : "$k=$v";
				}
				$phpcms_auth = $api->phpcms_passport_encrypt($userdb_encode, $passport_key);
				$verify = md5($action.$phpcms_auth.$forward.$passport_key);
				$phpcms_url = $this->_configinfo[api][phpcms_path] . "/member/api/passport_client.php".
				"?action=".$action.
				"&userdb=".rawurlencode($phpcms_auth).
				"&forward=".rawurlencode($forward).
				"&verify=".$verify;
			}

			/**
			 * phpwind passprot
			 */
			if ($this->_configinfo[api][open_phpwind] == '1'){
				global $db_hash;
				$passport_key = $this->_configinfo[api][passport_key];
				
				$userdb =  array(
					'uid' => $member_id,
					'username' => $member_name,
					'password' => md5($member_password),
					'email' => $member_email,
					'time' => time()
				);
				
				if ($action == "reg"){
					
					$action	= "login";
					$userdb['password'] = $member_password;
					
				}elseif ($action == "exit"){
					$action = "quit";
				}
				
				$userdb_encode='';
				foreach($userdb as $key=>$val){
					$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
				}
				$db_hash=$passport_key;

				$userdb_encode=str_replace('=','',$api->phpwindStrCode($userdb_encode));

				$verify = md5($action.$userdb_encode.$forward.$passport_key);
				$phpwind_url = $this->_configinfo[api][phpwind_path] . "/passport_client.php".
				"?action=$action".
				"&userdb=".rawurlencode($userdb_encode).
				"&forward=".rawurlencode($forward).
				"&verify=".rawurlencode($verify);
				
			}


			/**
			 * discuz
			 */
			if($this->_configinfo[api][open_discuz] == '1'){

				$passport_key = $this->_configinfo[api][passport_key];
				if ($action == "reg"){
					$action		= "login";
				}elseif ($action == "exit"){
					$action		= "logout";
				}
				$autharray =  array(
				'cookietime'	=> 3600,
				'time'		=> time(),
				'username'	=> $member_name,
				'password'	=> md5($member_password),
				'email'		=> $member_email
				);

				$auth		= $api->passport_encrypt($api->passport_encode($autharray), $passport_key);

				$verify		= md5($action.$auth.$forward.$passport_key);

				$discuz_url = $this->_configinfo[api][discuz_url] . "/api/passport.php".
				"?action=$action".
				"&auth=".rawurlencode($auth).
				"&forward=".rawurlencode($forward).
				"&verify=$verify";
			}

			/**
			 * 帝国CMS
			 */
			if($this->_configinfo[api][open_ecms] == '1'){
				$site_config = $this->_configinfo;
				$ecms_url = "../plug/api/ecms/passport_client.php?action=$action&forward=".rawurlencode($forward)."&username=$member_name";
				header("location:" . $ecms_url);
			}

			/**
			 * cmsware
			 */
			if($this->_configinfo[api][open_cmsware] == '1'){
				require_once("../plug/api/cmsware/oas.api.php");
				$cmsware = new OasApi();
				switch($action){
					case "login":
						$return = $cmsware->CwpsLogin($member_name,$member_password);//print_r($a);
						$_SESSION['cmsware_sid'] = $return['sId'];
						break;
					case "reg":
						$return = $cmsware->CwpsReg($member_name,$member_password,$member_email);
						break;
					case "exit":
						$return = $cmsware->CwpsLoginOut($_SESSION['cmsware_sid']);
						break;


				}
			}

			if ($this->_configinfo[api][open_phpcms] == '1' && $this->_configinfo[api][open_discuz] == '1'){
				$verify	= md5($action.$phpcms_auth.$discuz_url.$passport_key);
				@header("location: " . $phpcms_url . "&forward=" . rawurlencode($discuz_url) . "&verify=" . $verify);exit;
//				$flag = @fopen($phpcms_url . "&forward=" . rawurlencode($discuz_url) . "&verify=" . $verify,'r');
//				if ($flag == true){
//					$verify	= md5($action.$phpcms_auth.$discuz_url.$passport_key);
//					header("location:" . $phpcms_url . "&forward=" . rawurlencode($discuz_url) . "&verify=" . $verify);exit;
//				}else {
//					$this->redirectPath("error","","phpcms或Discuz整合路径设置不正确");
//				}
			}elseif ($this->_configinfo[api][open_phpcms] == '1' && $this->_configinfo[api][open_phpwind] == '1'){
				$verify	= md5($action.$phpcms_auth.$phpwind_url.$passport_key);
				@header("location: " . $phpcms_url . "&forward=" . rawurlencode($phpwind_url) . "&verify=" . $verify);exit;
//				$flag = @fopen($phpcms_url . "&forward=" . rawurlencode($phpwind_url) . "&verify=" . $verify,'r');
//				if ($flag == true){
//					$verify	= md5($action.$phpcms_auth.$phpwind_url.$passport_key);
//					header("location:" . $phpcms_url . "&forward=" . rawurlencode($phpwind_url) . "&verify=" . $verify);exit;
//				}else {
//					$this->redirectPath("error","","phpcms或PHPwind整合路径设置不正确");
//				}
			}elseif ($this->_configinfo[api][open_phpwind] == '1'){
//				print_r($phpwind_url);exit;
				@header("location: " . $phpwind_url);exit;
//				$flag = @fopen($phpwind_url,'r');
//				if ($flag == true) {
//					@header("location:" . $phpwind_url);exit;
//				}else {
//					$this->redirectPath("error","","PHPwind整合路径设置不正确");
//				}
				
			}elseif ($this->_configinfo[api][open_phpcms] == '1'){
//				print_r($phpcms_url);exit;
				@header("location: " . $phpcms_url);exit;
//				$flag = @fopen($phpcms_url . "&forward=" . rawurlencode($forward) . "&verify=" . $verify,'r');
//				if ($flag == true) {
//					header("location:" . $phpcms_url . "&forward=" . rawurlencode($forward) . "&verify=" . $verify);exit;
//				}else {
//					$this->redirectPath("error","","phpcms整合路径设置不正确");
//				}

			}elseif ($this->_configinfo[api][open_discuz] == '1'){
				@header("location: " . $discuz_url);exit;
//				$flag = @fopen($discuz_url,'r');
//				if ($flag == true) {
//					header("location:" . $discuz_url);exit;
//				}else {
//					$this->redirectPath("error","","Discuz整合路径设置不正确");
//				}
			}
		}

		if($forward==""){
			$forward = $refer_url;
		}else{
			$forward = $forward;
		}
		$this->redirectPath("refer",$forward);
	}
}
?>
