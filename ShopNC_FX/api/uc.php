<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想分销王系统 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : uc.php D:\root\shopnc6_jh\api\uc.php
* uc API
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 09:52:09 CST 2009
*/
include("../global.inc.php");
include(BasePath . '/uc_client/data/config.php');
include(BasePath . '/uc_client/model/base.php');
include(BasePath . '/uc_client/client.php');
include(BasePath . '/uc_client/lib/xml.class.php');

$code = $_GET['code'];
parse_str(authcode($code, 'DECODE', UC_KEY), $get);

if(time() - $get['time'] > 3600)
{
	exit('Authracation has expiried');
}

if(empty($get))
{
	exit('Invalid Request');
}

$action = $get['action'];
$timestamp = time();

if($action == 'test')
{
	exit(API_RETURN_SUCCEED);
}

/* 用户删除 API 接口 */
elseif($action == 'deleteuser')
{
	!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);
	$uids = $get['ids'];
	if (delete_user($uids))
	{
		exit(API_RETURN_SUCCEED);
	}
}

/* 同步登录 API 接口 */
elseif($action == 'synlogin' && $_GET['time'] == $get['time'])
{

	!API_SYNLOGIN && exit(API_RETURN_FORBIDDEN);
	$uid = intval($get['uid']);
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_login($uid, $get['username']);
}

/* 同步登出 API 接口 */
elseif($action == 'synlogout')
{

	!API_SYNLOGOUT && exit(API_RETURN_FORBIDDEN);

	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_cookie();
	set_session();
}

/* 更新客户端缓存 */
elseif($action == 'updateclient')
{
	!API_UPDATECLIENT && exit(API_RETURN_FORBIDDEN);

	$post = xml_unserialize(file_get_contents('php://input'));
	$cachefile = BasePath . '/uc_client/data/cache/settings.php';
	$fp = fopen($cachefile, 'w');
	$s = "<?php\r\n";
	$s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
	fwrite($fp, $s);
	fclose($fp);
	exit(API_RETURN_SUCCEED);
}

/* 更改用户密码 */
elseif($action == 'updatepw')
{
	!API_UPDATEPW && exit(API_RETURN_FORBIDDEN);

	$username = $get['username'];
	nc_mysql();
	mysql_query("UPDATE ".NC_DBTABLEPRE."users SET password='111111' WHERE user_name='".$username."'");
	nc_mysql(1);
	exit(API_RETURN_SUCCEED);
}

/* 更新关键字列表 */
elseif($action == 'updatebadwords')
{

	!API_UPDATEBADWORDS && exit(API_RETURN_FORBIDDEN);

	$post = xml_unserialize(file_get_contents('php://input'));
	$cachefile = BasePath .'/uc_client/data/cache/badwords.php';
	$fp = fopen($cachefile, 'w');
	$s = "<?php\r\n";
	$s .= '$_CACHE[\'badwords\'] = '.var_export($post, TRUE).";\r\n";
	fwrite($fp, $s);
	fclose($fp);
	exit(API_RETURN_SUCCEED);
}

/* 更新HOST文件 */
elseif($action == 'updatehosts')
{

	!API_UPDATEHOSTS && exit(API_RETURN_FORBIDDEN);

	$post = xml_unserialize(file_get_contents('php://input'));
	$cachefile = BasePath .'/uc_client/data/cache/hosts.php';
	$fp = fopen($cachefile, 'w');
	$s = "<?php\r\n";
	$s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
	fwrite($fp, $s);
	fclose($fp);
	exit(API_RETURN_SUCCEED);
}

/* 更新应用列表 */
elseif($action == 'updateapps')
{
	!API_UPDATEAPPS && exit(API_RETURN_FORBIDDEN);
	$applog_path = BasePath . '/uc_client/data/app.log';
	$post = uc_unserialize(file_get_contents('php://input'));
	unset($post['UC_API']);
	if (file_exists($applog_path))
	{
		$old_app = unserialize(file_get_contents($applog_path));
	}
	foreach ($post as $app_data)
	{
		if ($app_data['type'] != 'DISCUZ')
		{
			//检查老的APP是否存在
			if (!empty($old_app[$app_data['appid']]))
			{
				//检查应用名称是否变更
				if (($old_app[$app_data['appid']]['name'] != $app_data['name']) || ($old_app[$app_data['appid']]['url'] != $app_data['url']))
				{
					$change_app[] = $app_data['appid'];
				}
			}
			else
			{
				$add_app[] = $app_data['appid'];
			}
			$appid_list[] = $app_data['appid'];
			$app_list[$app_data['appid']]['type'] = $app_data['type'];
			$app_list[$app_data['appid']]['url'] = $app_data['url'];
			$app_list[$app_data['appid']]['name'] = $app_data['name'];
		}
	}

	//删除过期的应用
	if (!empty($old_app))
	{
		foreach ($old_app as $app_id => $tmp_data)
		{
			if (!in_array($app_id, $appid_list))
			{
				$del_app[] = $app_id;
			}
		}
	}
	//生成app缓存文件
	file_put_contents($applog_path, serialize($app_list));

	exit(API_RETURN_SUCCEED);
}


/* 解密函数 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
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
	for($i = 0; $i <= 255; $i++)
	{
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++)
	{
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++)
	{
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE')
	{
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16))
		{
			return substr($result, 26);
		}
		else
		{
			return '';
		}
	}
	else
	{
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

/**
 * 设置用户登陆
 *
 * @access  public
 * @param int $uid
 * @return void
 */
function set_login($user_id = '', $user_name = '')
{
	if (empty($user_id))
	{
		return ;
	}
	else
	{
		nc_mysql();
		$sql = "SELECT users.user_name, users.user_email, users.member_type,grade.grade_name,grade.grade_discount FROM ".NC_DBTABLEPRE."users AS users LEFT JOIN ".NC_DBTABLEPRE."user_grade AS grade ON users.grade_id=grade.grade_id WHERE users.user_id='$user_id' LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		nc_mysql(1);
		if ($row['login_name'] != ''){
			set_cookie($user_id, $row['login_name'], $row['user_email']);
			set_session($user_id, $row['login_name'], $row['user_email'],$row['grade_name'],$row['grade_discount']);
		}else{
			nc_mysql('','uc');
			$uc_query	= mysql_query("select username,email,regdate from ".UC_DBTABLEPRE."members where uid=".$user_id);
			$uc_row	= mysql_fetch_array($uc_query);
			nc_mysql(1);
			if ($uc_row['username'] != '')
			{
				nc_mysql();
				mysql_query("REPLACE INTO ".NC_DBTABLEPRE."users (user_id,user_email,user_password,user_name,user_register_time,user_login_time) VALUES ('".$user_id."','".$uc_row['email']."','111111','".$uc_row['username']."','".$uc_row['regdate']."','".$uc_row['regdate']."')");
				nc_mysql(1);

				set_cookie($user_id, $uc_row['username'], '0');
				set_session($user_id, $uc_row['username'], '0');
			}else{
				return false;
			}
		}

	}
}


/**
 *  设置cookie
 *
 * @access  public
 * @param
 * @return void
 */
function set_cookie($user_id='', $user_name = '', $email = '', $domain='')
{
	/*获取cookie作用域域名配置信息*/
	include_once('../cache/configini.cache.php');
	$domain=$cache_config['cookie']['cookiedomain'];

	if (empty($user_id))
	{
		/* 摧毁cookie */
		$time = time() - 3600;
		setcookie('c_login_name',  '', $time);
		setcookie('c_session_id', '', $time);
	}
	else
	{
		/* 设置cookie */
		setcookie("c_login_name",$user_name,time()+3600*24*30,'/',$domain);
		//sessionID
		setcookie("c_session_id",session_id(),time()+3600*24,'/',$domain);
	}
}

/**
 *  设置指定用户SESSION
 *
 * @access  public
 * @param
 * @return void
 */
function set_session ($user_id = '', $user_name = '', $user_type = '',$grade_name ='',$grade_discount='')
{
	if (empty($user_id))
	{
		$_SESSION["userinfo"] = array();
		session_unregister(userinfo);
		/*销毁cookie*/
		Common::nc_uc_cookie_set("login_out");
	}
	else
	{
		$front_framework = new CommonFrameWork();
		$front_framework->getlang('login');
		$_SESSION['userinfo']['user_id']   			= $user_id;
		$_SESSION['userinfo']['user_name'] 			= $user_name;
		$_SESSION['userinfo']['user_email'] 		= $user_type;
		$_SESSION['userinfo']['user_grade_name'] 	= $grade_name==''?$front_framework->_lang['login_grade_name']:$grade_name;		//会员等级
		$_SESSION['userinfo']['user_grade_discount'] = $grade_discount;	//会员折扣
		/*将session写入cookie*/
		Common::nc_uc_cookie_set("login");
	}
}

/**
 *  删除用户接口函数
 *
 * @access  public
 * @param   int $uids
 * @return  void
 */
function delete_user($uids = '')
{
	if (empty($uids))
	{
		return;
	}
	else
	{
		nc_mysql();
		$uids = stripslashes($uids);
		$sql = "DELETE FROM ".NC_DBTABLEPRE."users WHERE user_id IN ($uids)";
		mysql_query($sql);
		nc_mysql(1);
		return true;
	}
}
function nc_mysql($close_type='',$conn_type='nc') {
	if($close_type == '') {
		if($conn_type == 'nc'){
			$nc_connect = mysql_connect(NC_DBHOST,NC_DBUSER,NC_DBPW);
			mysql_select_db(NC_DBNAME,$nc_connect);
			mysql_query("set NAMES '".NC_DBCHARSET."'");
		}else {
			$nc_connect = mysql_connect(UC_DBHOST,UC_DBUSER,UC_DBPW);
			mysql_select_db(UC_DBNAME,$nc_connect);
			mysql_query("set NAMES '".UC_DBCHARSET."'");
		}
	}
	else {
		mysql_close($nc_connect);
	}
}
?>