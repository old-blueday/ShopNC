<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : uc.php   FILE_PATH : E:\www\multishop_v25\api\uc.php
 * ....uc api
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 06 08:42:38 CST 2009
 */
require ("../global.inc.php");

define('UC_CLIENT_VERSION', '1.5.0');
define('UC_CLIENT_RELEASE', '20090121');

define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_GETCREDIT', 1);
define('API_UPDATECREDITSETTINGS', 1);

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

if(!defined('IN_UC')) {
	error_reporting(0);
	set_magic_quotes_runtime(0);
	//实例化 包括配置信息
	$common = new CommonFrameWork();
	define('UC_KEY',$common->_configinfo['api']['passport_key']);
	defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	
	define('UC_API',$common->_configinfo['ucenter']['uc_api']);
	$_DCACHE = $get = $post = array();
	
	$code = @$_GET['code'];
	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);
	if(MAGIC_QUOTES_GPC) {
		$get = _stripslashes($get);
	}

	$timestamp = time();
	if(empty($get)) {
		exit('Invalid Request');
	} elseif($timestamp - $get['time'] > 3600) {
		exit('Authracation has expiried');
	}
	$action = $get['action'];

	require_once BasePath.'/uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings'))) {
		require_once BasePath.'/api/db_mysql.class.php';
		$GLOBALS['uc_db'] = new dbstuff;
		//
		$dbhost = $common->_configinfo['database']['servername_read'];
		$dbuser = $common->_configinfo['database']['username_read'];
		$dbpw = $common->_configinfo['database']['password_read'];
		$dbname = $common->_configinfo['database']['databasename_read'];
		$pconnect = '0';
		$tablepre = $common->_configinfo['database']['dbprefix'];
		$GLOBALS['uc_db']->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, '');
		$GLOBALS['tablepre'] = $tablepre;
		unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
		$uc_note = new uc_note();
		$uc_note->common = $common;
		exit($uc_note->$get['action']($get, $post));
	} else {
		exit(API_RETURN_FAILED);
	}
} else {
	/*$uc_note = new uc_note('../', '../config.inc.php');
	$uc_note->deleteuser('3');*/
//	define('DISCUZ_ROOT', $app['extra']['apppath']);
//	include DISCUZ_ROOT.'./config.inc.php';
//	require_once DISCUZ_ROOT.'./include/db_'.$database.'.class.php';
//	$GLOBALS['db'] = new dbstuff;
//	$GLOBALS['db']->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, $dbcharset);
//	$GLOBALS['tablepre'] = $tablepre;
//	unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
}

class uc_note {

	var $db = '';
	var $tablepre = '';
	var $appdir = '';
	var $common;
	
	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once BasePath.'./uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	function uc_note() {
		$this->appdir = BasePath;
		$this->db = $GLOBALS['uc_db'];
		$this->tablepre = $GLOBALS['tablepre'];
	}

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}
	
	/**
	 * 删除会员
	 */
	function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);
		$this->db->query("DELETE FROM ".$this->tablepre."member WHERE member_id IN ($uids)");
		$this->db->query("DELETE FROM ".$this->tablepre."member_extend WHERE member_id IN ($uids)");
		$this->db->query("DELETE FROM ".$this->tablepre."product WHERE member_id IN ($uids)");
		$this->db->query("DELETE FROM ".$this->tablepre."product_sold WHERE seller_id IN ($uids)");
		$this->db->query("DELETE FROM ".$this->tablepre."product_sold WHERE buyer_id IN ($uids)");
		$this->db->query("DELETE FROM ".$this->tablepre."shop_info WHERE member_id IN ($uids)");

		return API_RETURN_SUCCEED;
	}
	
	/**
	 * 重命名
	 */
	function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		if ($usernameold != '' && $usernamenew != ''){
			$this->db->query("UPDATE ".$this->tablepre."member SET login_name='$usernamenew' WHERE login_name='$usernameold'");
		}
		return API_RETURN_SUCCEED;
	}
	
	function gettag($get, $post) {
//		$name = $get['id'];
//		if(!API_GETTAG) {
//			return API_RETURN_FORBIDDEN;
//		}
//
//		$name = trim($name);
//		if(empty($name) || !preg_match('/^([\x7f-\xff_-]|\w|\s)+$/', $name) || strlen($name) > 20) {
//			return API_RETURN_FAILED;
//		}
//
//		require_once $this->appdir.'./include/misc.func.php';
//
//		$tag = $this->db->fetch_first("SELECT * FROM ".$this->tablepre."tags WHERE tagname='$name'");
//		if($tag['closed']) {
//			return API_RETURN_FAILED;
//		}
//
//		$tpp = 10;
//		$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
//		$boardurl = 'http://'.$_SERVER['HTTP_HOST'].preg_replace("/\/+(api)?\/*$/i", '', substr($PHP_SELF, 0, strrpos($PHP_SELF, '/'))).'/';
//		$query = $this->db->query("SELECT t.* FROM ".$this->tablepre."threadtags tt LEFT JOIN ".$this->tablepre."threads t ON t.tid=tt.tid AND t.displayorder>='0' WHERE tt.tagname='$name' ORDER BY tt.tid DESC LIMIT $tpp");
//		$threadlist = array();
//		while($tagthread = $this->db->fetch_array($query)) {
//			if($tagthread['tid']) {
//				$threadlist[] = array(
//					'subject' => $tagthread['subject'],
//					'uid' => $tagthread['authorid'],
//					'username' => $tagthread['author'],
//					'dateline' => $tagthread['dateline'],
//					'url' => $boardurl.'viewthread.php?tid='.$tagthread['tid'],
//				);
//			}
//		}
//
//		$return = array($name, $threadlist);
//		return $this->_serialize($return, 1);
	}
	
	/**
	 * 登录
	 */
	function synlogin($get, $post) {
		require BasePath.'/uc_client/client.php';
		$uid = $get['uid'];
		$username = $get['username'];
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		require("member.class.php");
		$obj_member = new MemberClass();
		require("shop.class.php");
		$obj_shop = new ShopClass();
		$condition['id'] = $uid;
		$member_array = $obj_member->getMemberInfo($condition);
		
//		$fp = fopen('text.txt','w');
//		fwrite($fp,implode('|',$user_array));
//		fclose($fp);
		//email为空
		if(empty($member_array['email']) && !empty($member_array)){
			//取该会员具体信息
			$db = new dbstuff;
			//
			$dbhost = $this->common->_configinfo['ucenter']['uc_dbhost'];
			$dbuser = $this->common->_configinfo['ucenter']['uc_dbuser'];
			$dbpw = $this->common->_configinfo['ucenter']['uc_dbpw'];
			$dbname = $this->common->_configinfo['ucenter']['uc_dbname'];
			$pconnect = '0';
			$tablepre = $this->common->_configinfo['ucenter']['uc_dbtablepre'];
			$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, '');
			unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
			$sql = "SELECT email FROM `".$tablepre."members` WHERE uid='".$uid."'";
			$user_array = $db->fetch_first($sql);
			unset($db);
			if(empty($user_array)){
				return false;
			}
			$email = $user_array['email'];
			$member_array['email'] = $email;
			//更新最后登录时间
			$obj_member->modifyMember(array('txtemail'=>$email),$uid,"email");

		}elseif(empty($member_array)){
			return false;
		}

		$_SESSION["s_login"]['login'] = 1;
		$_SESSION["s_login"]['id'] = $member_array['member_id'];
		$_SESSION["s_login"]['name'] = $member_array['login_name'];
		$_SESSION["s_login"]['type'] = $member_array['member_type'];
		//更新最后登录时间
		$obj_member->modifyMember($input_param,$_SESSION["s_login"]['id'],"last_login_time");
		//设置cookie信息
		setcookie("c_login_name",$_SESSION["s_login"]['name'],time()+$this->common->cookie_expire_time,'/',$this->common->_configinfo['cookie']['cookiedomain']);
		setcookie("c_session_id",session_id(),time()+$this->commom->cookie_expire_time,'/',$this->common->_configinfo['cookie']['cookiedomain']);
		//更新会员用户组
		$member_array = $obj_member->updateMemberToGroup($member_array['member_id']);
		$shop_array = $obj_shop->getOneShopByMemeberId($member_array['member_id'],'1','*');
		if ($shop_array['shop_id'] > 0){
			$_SESSION["s_shop"]['id'] = $shop_array['shop_id'];
			$_SESSION["s_shop"]['audit_state'] = $shop_array['audit_state'];
			$_SESSION["s_shop"]['if_del'] = $shop_array['if_del'];
		}

		return API_RETURN_SUCCEED;
	}
	
	/**
	 * 退出
	 */
	function synlogout($get, $post) {
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}
		setcookie("c_login_name","");
		setcookie("sys_sid","");
		$_SESSION["s_login"] = array();
		$_SESSION["s_shop"] = array();
		session_unregister("s_login");
		session_unregister("s_shop");
	}
	
	/**
	 * 更新密码
	 */
	function updatepw($get, $post) {
		if(!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		}
		$username = $get['username'];
		$password = md5($get['password']);

//		$newpw = md5(time().rand(100000, 999999));
		$this->db->query("UPDATE ".$this->tablepre."member SET password='$password' WHERE username='$username'");
		return API_RETURN_SUCCEED;
	}

	function updatebadwords($get, $post) {
//		if(!API_UPDATEBADWORDS) {
//			return API_RETURN_FORBIDDEN;
//		}
//		$cachefile = $this->appdir.'./uc_client/data/cache/badwords.php';
//		$fp = fopen($cachefile, 'w');
//		$data = array();
//		if(is_array($post)) {
//			foreach($post as $k => $v) {
//				$data['findpattern'][$k] = $v['findpattern'];
//				$data['replace'][$k] = $v['replacement'];
//			}
//		}
//		$s = "<?php\r\n";
//		$s .= '$_CACHE[\'badwords\'] = '.var_export($data, TRUE).";\r\n";
//		fwrite($fp, $s);
//		fclose($fp);
//		return API_RETURN_SUCCEED;
	}

	function updatehosts($get, $post) {
//		if(!API_UPDATEHOSTS) {
//			return API_RETURN_FORBIDDEN;
//		}
//		$cachefile = $this->appdir.'./uc_client/data/cache/hosts.php';
//		$fp = fopen($cachefile, 'w');
//		$s = "<?php\r\n";
//		$s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
//		fwrite($fp, $s);
//		fclose($fp);
//		return API_RETURN_SUCCEED;
	}

	function updateapps($get, $post) {
//		global $_DCACHE;
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		$UC_API = $post['UC_API'];

		if(empty($post) || empty($UC_API)) {
			return API_RETURN_SUCCEED;
		}

		$cachefile = $this->appdir.'./uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		/*if(is_writeable($this->appdir.'./config.inc.php')) {
			$configfile = trim(file_get_contents($this->appdir.'./config.inc.php'));
			$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
			$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
			if($fp = @fopen($this->appdir.'./config.inc.php', 'w')) {
				@fwrite($fp, trim($configfile));
				@fclose($fp);
			}
		}

		global $_DCACHE;
		require_once $this->appdir.'./forumdata/cache/cache_settings.php';
		require_once $this->appdir.'./include/cache.func.php';
		foreach($post as $appid => $app) {
			$_DCACHE['settings']['ucapp'][$appid]['viewprourl'] = $app['url'].$app['viewprourl'];
		}
		updatesettings();
*/
		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
//		if(!API_UPDATECREDIT) {
//			return API_RETURN_FORBIDDEN;
//		}
//		$credit = $get['credit'];
//		$amount = $get['amount'];
//		$uid = $get['uid'];
//
//		require_once $this->appdir.'./forumdata/cache/cache_settings.php';
//
//		$this->db->query("UPDATE ".$this->tablepre."members SET extcredits$credit=extcredits$credit+'$amount' WHERE uid='$uid'");
//
//		$discuz_user = $this->db->result_first("SELECT username FROM ".$this->tablepre."members WHERE uid='$uid'");
//
//		$this->db->query("INSERT INTO ".$this->tablepre."creditslog (uid, fromto, sendcredits, receivecredits, send, receive, dateline, operation)
//				VALUES ('$uid', '$discuz_user', '0', '$credit', '0', '$amount', '$timestamp', 'EXC')");
//		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
//		if(!API_GETCREDIT) {
//			return API_RETURN_FORBIDDEN;
//		}
//
//		$uid = intval($get['uid']);
//		$credit = intval($get['credit']);
//		return $credit >= 1 && $credit <= 8 ? $this->db->result_first("SELECT extcredits$credit FROM ".$this->tablepre."members WHERE uid='$uid'") : 0;
	}

	function getcreditsettings($get, $post) {
//		if(!API_GETCREDITSETTINGS) {
//			return API_RETURN_FORBIDDEN;
//		}
//		require_once $this->appdir.'./forumdata/cache/cache_settings.php';
//		$credits = array();
//		foreach($_DCACHE['settings']['extcredits'] as $id => $extcredits) {
//			$credits[$id] = array(strip_tags($extcredits['title']), $extcredits['unit']);
//		}
//		return $this->_serialize($credits);
	}

	function updatecreditsettings($get, $post) {
//		global $_DCACHE;
//		if(!API_UPDATECREDITSETTINGS) {
//			return API_RETURN_FORBIDDEN;
//		}
//		$credit = $get['credit'];
//		$outextcredits = array();
//		if($credit) {
//			foreach($credit as $appid => $credititems) {
//				if($appid == UC_APPID) {
//					foreach($credititems as $value) {
//						$outextcredits[] = array(
//							'appiddesc' => $value['appiddesc'],
//							'creditdesc' => $value['creditdesc'],
//							'creditsrc' => $value['creditsrc'],
//							'title' => $value['title'],
//							'unit' => $value['unit'],
//							'ratiosrc' => $value['ratiosrc'],
//							'ratiodesc' => $value['ratiodesc'],
//							'ratio' => $value['ratio']
//						);
//					}
//				}
//			}
//		}
//
//		require_once $this->appdir.'./forumdata/cache/cache_settings.php';
//		require_once $this->appdir.'./include/cache.func.php';
//
//		$this->db->query("REPLACE INTO ".$this->tablepre."settings (variable, value) VALUES ('outextcredits', '".addslashes(serialize($outextcredits))."');", 'UNBUFFERED');
//
//		$tmp = array();
//		foreach($outextcredits as $value) {
//			$key = $value['appiddesc'].'|'.$value['creditdesc'];
//			if(!isset($tmp[$key])) {
//				$tmp[$key] = array('title' => $value['title'], 'unit' => $value['unit']);
//			}
//			$tmp[$key]['ratiosrc'][$value['creditsrc']] = $value['ratiosrc'];
//			$tmp[$key]['ratiodesc'][$value['creditsrc']] = $value['ratiodesc'];
//			$tmp[$key]['creditsrc'][$value['creditsrc']] = $value['ratio'];
//		}
//		$_DCACHE['settings']['outextcredits'] = $tmp;
//		updatesettings();
//
//		return API_RETURN_SUCCEED;

	}
}

function _setcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function _stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}