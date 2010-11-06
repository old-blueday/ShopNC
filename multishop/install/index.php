<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : index.php
 * ....安装程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Jul 02 16:26:40 CST 2010
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set ('memory_limit', '512M');
@set_time_limit(1000);
set_magic_quotes_runtime(0);
//参数设置
define('ROOT_PATH', dirname(__FILE__).'/../');//网站根目录
define('SOFT_NAME', 'ShopNC多用户商城系统V2.7正式版');
define('SOFT_VERSION', '2.7正式版');
define('SOFT_RELEASE', '20100901');
//----------------------语言包
$GLOBALS['lang'] = array(
	'license'=>'<div class="license"><h1>ShopNC综合性多用户网上商城系统</h1>

<p>ShopNC综合性多用户网上商城管理系统是天津市网城创想科技责任有限公司自主开发，独立拥有版权的一套面向企业，行业的多用户网络商城系统。</p>
<p>本系统允许客户免费下载，使用。但是不得在本系统基础上进行再次开发后篡改版权或以其他名称销售，转让。</p>
<p>本系统提供免费客户完善的论坛帮助，对于寻求帮助的免费用户可以到官方论坛发贴寻求帮助，我公司将积极回复大家提出的问题。</p>
<p>对于购买商业服务的客户，我们将采取5×8小时的即时服务。并根据具体情况可以考虑驻点服务。具体服务内容以商业合作协议为准。</p>
<p>欢迎大家免费下载并使用，同时欢迎大家对于我们的不足提出您宝贵意见。谢谢！</p>
<p></p>
<p align=right>天津市网城创想科技有限责任公司 ShopNC多用户开发团队</p>
<p align=right>2010年9月01日</p>
</div>',
	'agreement_yes' => '我同意，继续安装',
	'agreement_no' => '我不同意',
	'title_install' => ' ShopNC综合多用户商城系统 V'.SOFT_VERSION.' 安装程序',
	'error_quit_msg' => '您必须解决以上问题，安装才可以继续',
	'click_to_back' => '点击返回上一步',
	
	'writeable' => '可写',
	'nodir' => '目录不存在',
	'nofile' => '文件不存在',
	'unwriteable' => '不可写',
	'env_check' => '环境检查',
	'ucenter_required' => '所需配置',
	'ucenter_best' => '推荐',
	'curr_server' => '当前服务器',
	'priv_check' => '权限检查',
	'step1_file' => '目录文件',
	'step1_need_status' => '所需状态',
	'step1_status' => '当前状态',
	'supportted' => '支持',
	'none' => '无',
	'unsupportted' => '不支持',
	'func_depend' => '函数检查',
	'check_result' => '',//检查结果
	'suggestion' => '',//建议
	'old_step' => '上一步',
	'new_step' => '下一步',
	'notset' => '不限制',
	'project' => '项目',
	'func_name' => '',//函数名称
	
	'advice_mysql' => '请检查 mysql 模块是否正确加载',
	'advice_fopen' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_file_get_contents' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_xml' => '该函数需要 PHP 支持 XML。请联系空间商，确定开启了此项功能',
	
	'advice_mysql_connect' => '请检查 mysql 模块是否正确加载',
	'advice_file_get_contents' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_mb_convert_encoding' => '该函数需要 php.ini 中 增加 mb_string 扩展。请联系空间商，确定开启了此项功能',
	
	'mysql_comment' => '请检查 mysql 模块是否正确加载',
	'fopen_comment' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'file_get_contents_comment' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'xml_comment' => '该函数需要 PHP 支持 XML。请联系空间商，确定开启了此项功能',
	'mysql_connect_comment' => '请检查 mysql 模块是否正确加载',
	'file_get_contents_comment' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'mb_convert_encoding_comment' => '该函数需要 php.ini 中 增加 mb_string 扩展。请联系空间商，确定开启了此项功能',	
	
	'step_env_check_title' => '开始安装',
	'step_env_check_desc' => '环境以及文件目录权限检查',
	'step_db_init_title' => '安装数据库',
	'step_db_init_desc' => '正在执行数据库安装',
	'step_app_reg_title' => '设置运行环境',
	'step_app_reg_desc' => '检测服务器环境',
	
	'os' => '操作系统',
	'php' => 'PHP 版本',
	'attachmentupload' => '附件上传',
	'unlimit' => '不限制',
	'version' => '版本',
	'gdversion' => 'GD 库',
	'allow' => '允许',
	'unix' => 'LINUX',
	'diskspace' => '磁盘空间',
	
	'tips_siteinfo' => '请填写站点信息',
	'sitename' => '站点名称',
	'siteurl' => '站点 URL',
	'error_message' => '错误信息',
	'siteinfo_sitename_invalid' => '站点名称为空，或者格式错误，请检查',
	'sel_charset' => '编码选择',
	
	'tips_ucenter' => '请填写 UCenter 相关信息',
	'ucurl' => 'UCenter 的 URL',
	'ucpw' => 'UCenter 创始人密码',
	'ucip' => 'UCenter 的IP地址',
	'ucenter_ucip_invalid' => '格式错误，请填写正确的 IP 地址',
	'ucip_comment' => '绝大多数情况下您可以不填',
	'ucenter_ucpw_invalid' => 'UCenter 的创始人密码为空，或者格式错误，请检查',
	'uc_url_invalid' => 'URL 格式错误',
	'uc_dns_error' => 'UCenter DNS解析错误，请返回填写一下 UCenter 的 IP地址',
	'uc_url_unreachable' => 'UCenter 的 URL 地址可能填写错误，请检查',
	'uc_version_incorrect' => '您的 UCenter 服务端版本过低，请升级 UCenter 服务端到最新版本，并且升级，下载地址：http://www.comsenz.com/ 。',
	'uc_dbcharset_incorrect' => 'UCenter 数据库字符集与当前应用字符集不一致',
	'uc_api_add_app_error' => '向 UCenter 添加应用错误',
	'uc_admin_invalid' => 'UCenter 创始人密码错误，请重新填写',
	'uc_data_invalid' => '通信失败，请检查 UCenter 的URL 地址是否正确 ',
	
	'database_errno_2003' => '无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确',
	'database_errno_1044' => '无法创建新的数据库，请检查数据库名称填写是否正确',
	'database_errno_1045' => '无法连接数据库，请检查数据库用户名或者密码是否正确',
	'database_errno_1064' => 'SQL 语法错误',
	'database_connect_error' => '数据库连接错误',
	'database_version_old' => '数据库版本过低，请使用4.1以上版本的数据库',
	
	'dbname_invalid' => '数据库名为空，请填写数据库名称',
	'tablepre_invalid' => '数据表前缀为空，或者格式错误，请检查',
	'admin_username_invalid' => '非法用户名，用户名长度不应当超过 15 个英文字符，且不能包含特殊字符，一般是中文，字母或者数字',
	'admin_password_invalid' => '密码和上面不一致，请重新输入',
	'admin_email_invalid' => 'Email 地址错误，此邮件地址已经被使用或者格式无效，请更换为其他地址',
	'admin_invalid' => '您的信息管理员信息没有填写完整，请仔细填写每个项目',
	'tips_dbinfo' => '数据库信息',
	'dbhost' => '数据库服务器',
	'dbuser' => '数据库用户名',
	'dbpw' => '数据库密码',
	'dbname' => '数据库名',
	'tablepre' => '数据表前缀',
	'tips_admininfo' => '管理员信息',
	'username' => '管理员账号',
	'email' => '管理员 Email',
	'password' => '管理员密码',
	'password_comment' => '管理员密码不能为空',
	'password2' => '重复密码',
	
	'dbinfo_dbhost_invalid' => '数据库服务器为空，或者格式错误，请检查',
	'dbinfo_dbname_invalid' => '数据库名为空，或者格式错误，请检查',
	'admininfo_username_invalid' => '管理员用户名为空，或者格式错误，请检查',
	'admininfo_email_invalid' => '管理员Email为空，或者格式错误，请检查',
	'admininfo_password_invalid' => '管理员密码为空，请填写',
	'admininfo_password2_invalid' => '两次密码不一致，请检查',
	'install_in_processed' => '正在安装...',
	'create_table' => '数据表',
	'succeed' => '建立成功',
	'install_succeed' => '安装成功，点击进入',
	'forceinstall' => '强制安装',
	'dbinfo_forceinstall_invalid' => '当前数据库当中已经含有同样表前缀的数据表，您可以修改“表名前缀”来避免删除旧的数据，或者选择强制安装。强制安装会删除旧数据，且无法恢复',
	'forceinstall_check_label' => '删除数据，重新安装',
	'insert_demo_data' => '演示数据',
	'database_nonexistence' => '数据库操作对象不存在',
	'method_undefined' => '未定义方法',
	'file_all_pass'=>'文件权限全部通过',
	'install_succ_remark'=>'<p class=\'nest\'>初次安装后要执行以下操作：</p>
		<p class=\'nes\'>1.进入系统后台->工具->静态化管理-><font color=\'FF0000\'>生成全部静态</font></p>
		<p class=\'nes\'>2.进入系统后台->系统->支付接口-><font color=\'FF0000\'>安装需要的支付方式</font></p>
		<p class=\'nes\'>3.如果安装了演示数据，<font color=\'FF0000\'>测试账号的密码为111111</font></p>',
	'config_ini_unwrite'=>'config/config.ini.php不可写，请检查文件权限是否正确',
	'config_ini_unopen'=>'config/config.ini.php不能打开，请检查文件权限是否正确',
	'config_ini_unwrite_to'=>'config/config.ini.php不能写入，请检查文件权限是否正确',
	'undefine_func'=>'环境不支持的函数',
	'php_version_too_low'=>'PHP版本过低，最低版本要求4.4.1，推荐版本5.0以上',
	'confirm_set_remark'=>'我已经仔细阅读了操作说明，可以进入后台进行网站设置了'
);
//-----------------------语言包end
//----------------------方法集
function getgpc($k, $t='GP') {
	$t = strtoupper($t);
	switch($t) {
		case 'GP' : isset($_POST[$k]) ? $var = &$_POST : $var = &$_GET; break;
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	return isset($var[$k]) ? $var[$k] : '';
}
//输出声明
function show_license() {
	global $self, $uchidden, $step;
	$next = $step + 1;
	show_header();

	$license = str_replace('  ', '&nbsp; ', lang('license'));
	$lang_agreement_yes = lang('agreement_yes');
	$lang_agreement_no = lang('agreement_no');
	echo <<<EOT
</div>
<div class="main">
	<div class="licenseblock">$license</div>
	<div class="btnbox marginbot">
		<form method="post" action="index.php">
		<input type="hidden" name="step" value="$next">
		<input type="hidden" name="uchidden" value="$uchidden">
		<input type="submit" name="submit" value="{$lang_agreement_yes}" style="padding: 2px">&nbsp;
		<input type="button" name="exit" value="{$lang_agreement_no}" style="padding: 2px" onclick="javascript: window.close(); return false;">
		</form>
	</div>
EOT;
	show_footer();
}
//输出页头
function show_header() {
	define('SHOW_HEADER', TRUE);
	global $step;
	$version = SOFT_VERSION;
	$release = SOFT_RELEASE;
	$title = lang('title_install');
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$title</title>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<meta content="ShopNC" name="Copyright" />
<script type="text/javascript">
	function $(id) {
		return document.getElementById(id);
	}

	function showmessage(message) {
		$('notice').value += message + "\\r\\n";
	}
</script>

</head>
<div class="container">
	<div class="header">
		<h1>$title</h1>
		<span>V$version $release</span>
EOT;

	$step > 0 && show_step($step);
}
//输出页脚
function show_footer($quit = true) {

	echo <<<EOT
		<div class="footer"><p>Powered by <a href="http://www.shopnc.net">ShopNC </a>© v2.7 2007-2010 <a href="http://www.shopnc.net">网城创想</a> Inc.</p>
<p>版权所有 天津市网城创想科技有限责任公司 津ICP备080001719号</p>
<p>软件著作权登记号: 2008SR07843</div></p>
	</div>
</div>
</body>
</html>
EOT;
	$quit && exit();
}
//语言包
function lang($lang_key, $force = true) {
	return isset($GLOBALS['lang'][$lang_key]) ? $GLOBALS['lang'][$lang_key] : ($force ? $lang_key : '');
}

//检测函数是否存在
function function_check(&$func_items) {
	foreach($func_items as $item) {
		function_exists($item) or show_msg('undefine_func', $item, 0);
	}
}
//抛出信息
function show_msg($error_no, $error_msg = 'ok', $success = 1, $quit = TRUE) {
	show_header();
	global $step;

	$title = lang($error_no);
	$comment = lang($error_no.'_comment', false);
	$errormsg = '';

	if($error_msg) {
		if(!empty($error_msg)) {
			foreach ((array)$error_msg as $k => $v) {
				if(is_numeric($k)) {
					$comment .= "<li><em class=\"red\">".lang($v)."</em></li>";
				}
			}
		}
	}

	if($step > 0) {
		echo "<div class=\"desc\"><b>$title</b><ul>$comment</ul>";
	} else {
		echo "</div><div class=\"main\" style=\"margin-top: -123px;\"><b>$title</b><ul style=\"line-height: 200%; margin-left: 30px;\">$comment</ul>";
	}

	if($quit) {
		echo '<br /><span class="red">'.lang('error_quit_msg').'</span><br /><br /><br />';
	}

	echo '<input type="button" onclick="history.back()" value="'.lang('click_to_back').'" /><br /><br /><br />';

	echo '</div>';

	$quit && show_footer();
}
//系统环境检查
function env_check(&$env_items) {
	foreach($env_items as $key => $item) {
		if($key == 'php') {
			$env_items[$key]['current'] = PHP_VERSION;
		} elseif($key == 'attachmentupload') {
			$env_items[$key]['current'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
		} elseif($key == 'gdversion') {
			$tmp = function_exists('gd_info') ? gd_info() : array();
			$env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
			unset($tmp);
		} elseif($key == 'diskspace') {
			if(function_exists('disk_free_space')) {
				$env_items[$key]['current'] = floor(disk_free_space(ROOT_PATH) / (1024*1024)).'M';
			} else {
				$env_items[$key]['current'] = 'unknow';
			}
		} elseif(isset($item['c'])) {
			$env_items[$key]['current'] = constant($item['c']);
		}

		$env_items[$key]['status'] = 1;
		if($item['r'] != 'notset' && strcmp($env_items[$key]['current'], $item['r']) < 0) {
			$env_items[$key]['status'] = 0;
		}
	}
}
//文件权限检查
function dirfile_check(&$dirfile_items) {
	foreach($dirfile_items as $key => $item) {
		$item_path = $item['path'];
		if($item['type'] == 'dir') {
			if(!dir_writeable(ROOT_PATH.$item_path)) {
				if(is_dir(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nodir';
				}
			} else {
				$dirfile_items[$key]['status'] = 1;
				$dirfile_items[$key]['current'] = '+r+w';
			}
		} else {
			if(file_exists(ROOT_PATH.$item_path)) {
				if(is_writable(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				}
			} else {
				if ($fp = @fopen(ROOT_PATH.$item_path,'wb+')){
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				}else {
					$dirfile_items[$key]['status'] = -2;
					$dirfile_items[$key]['current'] = 'nofile';
				}
			}
		}
	}
}
function dir_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0755);
	}else {
		@chmod($dir,0755);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

//环境检查输出
function show_env_result(&$env_items, &$dirfile_items, &$func_items) {

	$env_str = $file_str = $dir_str = $func_str = '';
	
	foreach($env_items as $key => $item) {
		if($key == 'php' && strcmp($item['current'], $item['r']) < 0) {
			show_msg('php_version_too_low', $item['current'], 0);
		}
		$status = 1;
		if($item['r'] != 'notset') {
			if(intval($item['current']) && intval($item['r'])) {
				if(intval($item['current']) < intval($item['r'])) {
					$status = 0;
					$env_wrong_sign = true;//是否进行下一步，这里为报错
				}
			} else {
				if(strcmp($item['current'], $item['r']) < 0) {
					$status = 0;
					$env_wrong_sign = true;//是否进行下一步，这里为报错
				}
			}
		}
		$env_str .= "<tr>\n";
		$env_str .= "<td>".lang($key)."</td>\n";
		$env_str .= "<td class=\"padleft\">".lang($item['r'])."</td>\n";
		$env_str .= "<td class=\"padleft\">".lang($item['b'])."</td>\n";
		$env_str .= ($status ? "<td class=\"w pdleft1\">" : "<td class=\"nw pdleft1\">").$item['current']."</td>\n";
		$env_str .= "</tr>\n";
	}

	foreach($dirfile_items as $key => $item) {
		$tagname = $item['type'] == 'file' ? 'File' : 'Dir';
		if ($item['status'] !== 1){
			$variable = $item['type'].'_str';
			$$variable .= "<tr>\n";
			$$variable .= "<td>$item[path]</td><td class=\"w pdleft1\">".lang('writeable')."</td>\n";
			if($item['status'] == 1) {
				$$variable .= "<td class=\"w pdleft1\">".lang('writeable')."</td>\n";
			} elseif($item['status'] == -1) {
				$dir_wrong_sign = true;//是否进行下一步，这里为报错
				$$variable .= "<td class=\"nw pdleft1\">".lang('nodir')."</td>\n";
			}  elseif($item['status'] == -2) {
				$dir_wrong_sign = true;//是否进行下一步，这里为报错
				$$variable .= "<td class=\"nw pdleft1\">".lang('nofile')."</td>\n";
			} else {
				$dir_wrong_sign = true;//是否进行下一步，这里为报错
				$$variable .= "<td class=\"nw pdleft1\">".lang('unwriteable')."</td>\n";
			}
			$$variable .= "</tr>\n";
		}
	}
	//通过检测
	if (empty($$variable)){
		$file_str .= "<tr>\n";
		$file_str .= "<td colspan='3' align='center'>".lang('file_all_pass')."</td>\n";
		$file_str .= "</tr>\n";
	}
	
	show_header();

	echo "<h2 class=\"title\">".lang('env_check')."</h2>\n";
	echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;\">\n";
	echo "<tr>\n";
	echo "\t<th>".lang('project')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('ucenter_required')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('ucenter_best')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('curr_server')."</th>\n";
	echo "</tr>\n";
	echo $env_str;
	echo "</table>\n";
	
	foreach($func_items as $item) {
		$status = function_exists($item);
		$func_str .= "<tr>\n";
		$func_str .= "<td>$item()</td>\n";
		if($status) {
			$func_str .= "<td class=\"w pdleft1\">".lang('supportted')."</td>\n";
			$func_str .= "<td class=\"padleft\">".lang('none')."</td>\n";
		} else {
			$fun_wrong_sign = true;//是否进行下一步，这里为报错
			$func_str .= "<td class=\"nw pdleft1\">".lang('unsupportted')."</td>\n";
			$func_str .= "<td><font color=\"red\">".lang('advice_'.$item)."</font></td>\n";
		}
	}
	echo "<h2 class=\"title\">".lang('func_depend')."</h2>\n";
	echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
	echo "<tr>\n";
	echo "\t<th>".lang('func_name')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('check_result')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('suggestion')."</th>\n";
	echo "</tr>\n";
	echo $func_str;
	echo "</table>\n";
	
	echo "<h2 class=\"title\">".lang('priv_check')."</h2>\n";
	echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
	echo "\t<tr>\n";
	echo "\t<th>".lang('step1_file')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('step1_need_status')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('step1_status')."</th>\n";
	echo "</tr>\n";
	echo $file_str;
	echo $dir_str;
	echo "</table>\n";

	
	if ($env_wrong_sign == true || $dir_wrong_sign == true || $fun_wrong_sign == true){
		show_next_step(1);
	}else {
		show_next_step(2);
	}
	show_footer();
}
//显示下一步
function show_next_step($step) {
	global $uchidden;
	echo "<form action=\"index.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"step\" value=\"$step\" />";
	if(isset($GLOBALS['hidden'])) {
		echo $GLOBALS['hidden'];
	}
	echo "<input type=\"hidden\" name=\"uchidden\" value=\"$uchidden\" />";
	$nextstep = "<input type=\"button\" onclick=\"history.back();\" value=\"".lang('old_step')."\"><input type=\"submit\" value=\"".lang('new_step')."\">\n";
	echo "<div class=\"btnbox marginbot\">".$nextstep."</div>\n";
	echo "</form>\n";
}
//当前步骤
function show_step($step) {

	global $method;

	$laststep = 4;
	$title = lang('step_'.$method.'_title');
	$comment = lang('step_'.$method.'_desc');

	$stepclass = array();
	for($i = 1; $i <= $laststep; $i++) {
		$stepclass[$i] = $i == $step ? 'current' : ($i < $step ? '' : 'unactivated');
	}
	$stepclass[$laststep] .= ' last';
	
	echo <<<EOT
	<div class='dress dress$step'><h3>$title</h3><p>$comment</p></div>
</div>
<div class="main">
EOT;
}
//输出表单
function show_form(&$form_items, $error_msg) {
	global $step, $uchidden;
	if(empty($form_items) || !is_array($form_items)) {
		return;
	}
	show_header();
	show_setting('start');
	show_setting('hidden', 'step', $step);
	$is_first = 1;
	if(!empty($uchidden)) {
		$uc_info_transfer = unserialize(urldecode($uchidden));
		echo "<input type=\"hidden\" name=\"uchidden\" value=\"$uchidden\" />";
	}else {
		if (!empty($form_items['ucenter'])){
			unset($form_items['ucenter']);
		}
	}
	
	foreach($form_items as $key => $items) {
		global ${'error_'.$key};
		if($is_first == 0) {
			echo '</table>';
		}

		if(!${'error_'.$key}) {
			show_tips('tips_'.$key);
		} else {
			show_error('tips_admin_config', ${'error_'.$key});
		}

		echo '<table class="tb2">';
		
		//当为环境配置的步骤时，单独输出编码选择内容
		if ($step == 3 && $key == 'dbinfo'){
			echo "\n".'<tr><th class="tbopt">&nbsp;'.lang('sel_charset').':'."</th>\n<td>";
			echo "<select name='charset'>\n";
			echo "<option value='utf8' selected='selected'>UTF-8</option>\n";
			echo "<option value='gbk'>GBK</option>\n";
			echo "</select>\n";
			echo "</td>\n<td>&nbsp;";
			if($error) {
				$comment = '<span class="red">'.(is_string($error) ? lang($error) : lang($setname.'_error')).'</span>';
			} else {
				$comment = lang($setname.'_comment', false);
			}
			echo "$comment</td>\n</tr>\n";
		}
		
		foreach($items as $k => $v) {
			global $$k;
			if(!empty($error_msg)) {
				$value = isset($_POST[$key][$k]) ? $_POST[$key][$k] : '';
			} else {
				if(isset($v['value']) && is_array($v['value'])) {
					if($v['value']['type'] == 'constant') {
						$value = defined($v['value']['var']) ? constant($v['value']['var']) : '';
					} else {
						$value = $GLOBALS[$v['value']['var']];
					}
				} else {
					$value = '';
				}
			}
			if($v['type'] == 'checkbox') {
				$value = '1';
			}
			
			if($k == 'ucurl' && isset($uc_info_transfer['ucapi'])) {
				$value = $uc_info_transfer['ucapi'];
			} elseif($k == 'ucpw' && isset($uc_info_transfer['ucfounderpw'])) {
//				$value = $uc_info_transfer['ucfounderpw'];
			}
			
			show_setting($k, $key.'['.$k.']', $value, $v['type'], isset($error_msg[$key][$k]) ? $key.'_'.$k.'_invalid' : '');
		}
		
		//当为环境配置的步骤时，单独输出是否增加演示数据
		if ($step == 3 && $key == 'dbinfo'){
			//验证是否整合UC，如果整合了，那么就不安转演示数据
			require_once("../classes/libraries/inifileoperate.class.php");
			$obj_config = new IniFileOperate("../config/config.ini.php");
			$uc_open_passport = $obj_config->getIniFile('api','open_passport',0);
			$uc_passport_type = $obj_config->getIniFile('api','passport_type',0);
			unset($obj_config);
			if ($uc_open_passport == '1' && $uc_passport_type == '2'){
				//空
			}else {
				if ($_POST['demo_date'] == '1'){
					$demo_check = "checked='checked'";
				}
				echo "\n".'<tr><th class="tbopt">&nbsp;'.lang('insert_demo_data').':'."</th>\n<td>";
				echo "<input type='checkbox' name='demo_date' id='demo_date' $demo_check value='1' checked='checked' /><label for='demo_date'>". lang('insert_demo_data') ."</label>\n";
				echo "</td>\n<td>&nbsp;";
				if($error) {
					$comment = '<span class="red">'.(is_string($error) ? lang($error) : lang($setname.'_error')).'</span>';
				} else {
					$comment = lang($setname.'_comment', false);
				}
				echo "$comment</td>\n</tr>\n";
			}
		}
		
		if($is_first) {
			$is_first = 0;
		}
	}
	show_setting('', 'submitname', 'new_step', 'submit');
	show_setting('end');
	show_footer();
}
//设置html内容样式
function show_setting($setname, $varname = '', $value = '', $type = 'text|password|checkbox', $error = '') {
	if($setname == 'start') {
		echo "<form method=\"post\" action=\"index.php\">\n";
		return;
	} elseif($setname == 'end') {
		echo "\n</table>\n</form>\n";
		return;
	} elseif($setname == 'hidden') {
		echo "<input type=\"hidden\" name=\"$varname\" value=\"$value\">\n";
		return;
	}

	echo "\n".'<tr><th class="tbopt'.($error ? ' red' : '').'">&nbsp;'.(empty($setname) ? '' : lang($setname).':')."</th>\n<td>";
	if($type == 'text' || $type == 'password') {
		$value = htmlspecialchars($value);
		echo "<input type=\"$type\" name=\"$varname\" value=\"$value\" size=\"35\" class=\"txt\">";
	} elseif($type == 'submit') {
		$value = empty($value) ? 'next_step' : $value;
		echo "<input type=\"submit\" name=\"$varname\" value=\"".lang($value)."\" class=\"btn\">\n";
	} elseif($type == 'checkbox') {
		if(!is_array($varname) && !is_array($value)) {
			echo'<label><input type="checkbox" name="'.$varname.'" value="'.$value."\" style=\"border: 0\">".lang($setname.'_check_label')."</label>\n";
		}
	} else {
		echo $value;
	}

	echo "</td>\n<td>&nbsp;";
	if($error) {
		$comment = '<span class="red">'.(is_string($error) ? lang($error) : lang($setname.'_error')).'</span>';
	} else {
		$comment = lang($setname.'_comment', false);
	}
	echo "$comment</td>\n</tr>\n";
	return true;
}

function show_tips($tip, $title = '', $comment = '', $style = 1) {
	global $lang;
	$title = empty($title) ? lang($tip) : $title;
	$comment = empty($comment) ? lang($tip.'_comment', FALSE) : $comment;
	if($style) {
		echo "<div class=\"desc\"><b>$title</b>";
	} else {
		echo "</div><div class=\"main\">$title<div class=\"desc1 marginbot\"><ul>";
	}
	$comment && print('<br>'.$comment);
	echo "</div>";
}
//检查数据库
function check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre) {
	if(!function_exists('mysql_connect')) {
		show_msg('undefine_func', 'mysql_connect', 0);
	}
	if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
		$errno = mysql_errno();
		$error = mysql_error();
		if($errno == 1045) {
			show_msg('database_errno_1045', $error, 0);
		} elseif($errno == 2003) {
			show_msg('database_errno_2003', $error, 0);
		} else {
			show_msg('database_connect_error', $error, 0);
		}
	} else {
		if($query = mysql_query("SHOW TABLES FROM $dbname")) {
			while($row = mysql_fetch_row($query)) {
				if(preg_match("/^$tablepre/", $row[0])) {
					return false;
				}
			}
		}
	}
	return true;
}
//写入config文件
function config_edit() {
	extract($GLOBALS, EXTR_SKIP);
	$config = '../config/config.ini.php';
	
	$configfile = @file_get_contents($config);
	$configfile = trim($configfile);
	$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
	
	if (strtoupper($_POST['charset']) == 'GBK'){
		$charset = 'GBK';
		$db_charset = 'gbk';
	}else {
		$charset = 'UTF-8';
		$db_charset = 'utf8';
	}
	$HttpHost   = "http://".$_SERVER['HTTP_HOST'];
	$ScriptName = $_SERVER['SCRIPT_NAME'];
	$SubPath    = trim(str_replace(strstr($ScriptName, '/install'),"",$ScriptName));
	$SubPath    = $SubPath != "" ? $SubPath : "";
	$url    = $HttpHost.$SubPath;

	$configfile = preg_replace("/ncharset\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"]*/is", "ncharset=$charset", $configfile);
	$configfile = preg_replace("/site_url\s*\=[a-zA-Z0-9-_\.\:\/\(\)]*/is", "site_url=$url", $configfile);
	$configfile = preg_replace("/dbprefix\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"]*/is", "dbprefix=$tablepre", $configfile);
	$configfile = preg_replace("/database_charset\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"]*/is", "database_charset=$db_charset", $configfile);
	$configfile = preg_replace("/servername_write\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "servername_write=$dbhost", $configfile);
	$configfile = preg_replace("/databasename_write\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "databasename_write=$dbname", $configfile);
	$configfile = preg_replace("/username_write\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "username_write=\"$dbuser\"", $configfile);
	$configfile = preg_replace("/password_write\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "password_write=\"$dbpw\"", $configfile);
	$configfile = preg_replace("/servername_read\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "servername_read=$dbhost", $configfile);
	$configfile = preg_replace("/databasename_read\s*\=[a-zA-Z0-9-_]*/is", "databasename_read=$dbname", $configfile);
	$configfile = preg_replace("/username_read\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "username_read=\"$dbuser\"", $configfile);
	$configfile = preg_replace("/password_read\s*\=[a-zA-Z0-9-_!@#$%^&*?~`\[\]\(\)\'\"\=]*/is", "password_read=\"$dbpw\"", $configfile);

	if (phpversion() > 5.0){
		$configfile .= "?>";
		@file_put_contents($config, $configfile);
	}else {
		if (!$handle = fopen($config, 'wb+')) {
			show_msg('config_ini_unopen', '', 0);
		}
		if (is_writable($config)) {
			$configfile .= "?>";
		    if (fwrite($handle, $configfile) === FALSE) {
		        show_msg('config_ini_unwrite_to', '', 0);
		    }
		    fclose($handle);
		} else {
			show_msg('config_ini_unwrite', '', 0);
		}
	}
}
//安装内容
function show_install() {
?>
<script type="text/javascript">
function showmessage(message) {
	document.getElementById('notice').value += message + "\r\n";
}
function initinput() {
	window.open('../system/');
}
function change_input(){
	if(document.getElementById("checkbox_install_succ").checked == true){
		document.getElementById("laststep").className = 'las-2';
		document.getElementById("laststep").disabled = false;
	}else{
		document.getElementById("laststep").className = 'las-1';
		document.getElementById("laststep").disabled = true;
	}
}
</script>
	<div class="main">
		<div class="btnbox"><textarea name="notice" class="shop-tex"  readonly="readonly" id="notice"></textarea></div>
		<div class="btnbox marginbot">
			<?php echo lang('install_succ_remark');?>
		</div>
		<div class="btnbox marginbot">
			<input type="checkbox" id="checkbox_install_succ" onclick="change_input();"><label class="ziti-c" for="checkbox_install_succ"><?php echo lang('confirm_set_remark');?></label>
		</div>
		<div class="btnbox marginbot">
	<input type="button" class="las-1" name="submit"  disabled style="height: 25" id="laststep" onclick="initinput()">
	</div>
	
<?php
}
//执行sql
function runquery($sql) {
	global $lang, $tablepre, $db;

	if(!isset($sql) || empty($sql)) return;

	$sql = str_replace("\r", "\n", str_replace('#__', $tablepre, $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);

	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$line = explode('`',$query);
				$data_name = $line[1];
				$name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
				showjsmessage(lang('create_table').' '.$data_name.' ... '.lang('succeed'));
				$db->query(droptable($data_name));
				$db->query(createtable($query));
				unset($line,$data_name);
			} else {
				$db->query($query);
			}
		}
	}
}
//抛出JS信息
function showjsmessage($message) {
	echo '<script type="text/javascript">showmessage(\''.addslashes($message).' \');</script>'."\r\n";
	flush();
	ob_flush();
}

function droptable($table_name){
	return "DROP TABLE IF EXISTS `". $table_name ."`;";
}

function createtable($sql) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
	(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=".DBCHARSET : " TYPE=$type");
}

//获取uc传递信息
function transfer_ucinfo(&$post) {
	global $uchidden;
	if(isset($post['ucapi']) && isset($post['ucfounderpw'])) {
		$arr = array(
			'ucapi' => $post['ucapi'],
			'ucfounderpw' => $post['ucfounderpw']
			);
		$uchidden = urlencode(serialize($arr));
	} else {
		$uchidden = '';
	}
}
function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].(isset($matches['query']) && $matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;

	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}
//---------------------方法集 end
//---------------------数据库操作类
class dbstuff {
	var $querynum = 0;
	var $link;
	var $histories;
	var $time;
	var $tablepre;

	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset, $pconnect = 0, $tablepre='', $time = 0) {
		$this->time = $time;
		$this->tablepre = $tablepre;
		if($pconnect) {
			if(!$this->link = mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$this->halt('Can not connect to MySQL server');
			}
		}

		if($this->version() > '4.1') {
			if($dbcharset) {
				mysql_query("SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if($dbname) {
			mysql_select_db($dbname, $this->link);
		}

	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function result_first($sql, &$data) {
		$query = $this->query($sql);
		$data = $this->result($query, 0);
	}

	function fetch_first($sql, &$arr) {
		$query = $this->query($sql);
		$arr = $this->fetch_array($query);
	}

	function fetch_all($sql, &$arr) {
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
	}

	function cache_gc() {
		$this->query("DELETE FROM {$this->tablepre}sqlcaches WHERE expiry<$this->time");
	}

	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {
//		echo mysql_error();echo "<br />";
	}
}
//----------------------数据库操作类 end
//-----------------------变量参数
$func_items = array(
	'mysql_connect', 
	'fsockopen', 
	'gethostbyname', 
	'file_get_contents', 
//	'xml_parser_create'
	'mb_convert_encoding'
);

$env_items = array
(
//	'os' => array('c' => 'PHP_OS', 'r' => 'notset', 'b' => 'unix'),
	'php' => array('c' => 'PHP_VERSION', 'r' => '4.4.1', 'b' => '5.0'),
//	'attachmentupload' => array('r' => 'notset', 'b' => '2M'),
	'gdversion' => array('r' => '1.0', 'b' => '2.0'),
	'diskspace' => array('r' => '100M', 'b' => 'notset'),
);

$dirfile_items = array
(
	'attach' => array('type' => 'dir', 'path' => './attachments'),
	'attach_gif' => array('type' => 'dir', 'path' => './attachments/gif'),
	'attach_gif_year' => array('type' => 'dir', 'path' => './attachments/gif/2009'),
	'attach_gif_month' => array('type' => 'dir', 'path' => './attachments/gif/2009/12'),
	'attach_jpg_day' => array('type' => 'dir', 'path' => './attachments/gif/2009/12/03'),
	'attach_jpg' => array('type' => 'dir', 'path' => './attachments/jpg'),
	'attach_jpg_year' => array('type' => 'dir', 'path' => './attachments/jpg/2009'),
	'attach_jpg_month' => array('type' => 'dir', 'path' => './attachments/jpg/2009/12'),
	'attach_jpg_day' => array('type' => 'dir', 'path' => './attachments/jpg/2010/07/22'),
	'attach_jpg_day' => array('type' => 'dir', 'path' => './attachments/jpg/2010/07/01'),
	'cache' => array('type' => 'dir', 'path' => './cache'),
	'cache_lang' => array('type' => 'dir', 'path' => './cache/lang'),
	'cache_menu' => array('type' => 'dir', 'path' => './cache/menu'),
	'config' => array('type' => 'dir', 'path' => './config'),
	'config_config' => array('type' => 'file', 'path' => './config/config.ini.php'),
	'config_system' => array('type' => 'file', 'path' => './config/system.ini.php'),
	'config_payment' => array('type' => 'file', 'path' => './config/payment.ini.php'),
	'html' => array('type' => 'dir', 'path' => './html'),
	'html_js' => array('type' => 'dir', 'path' => './html/js'),
	'html_section' => array('type' => 'dir', 'path' => './html/section'),
	'html_user' => array('type' => 'dir', 'path' => './html/user'),
	'install' => array('type' => 'dir', 'path' => './install'),
	'payment' => array('type' => 'dir', 'path' => './payment'),
	'payment_alipay' => array('type' => 'dir', 'path' => './payment/alipay'),
	'payment_paypal_includes' => array('type' => 'dir', 'path' => './payment/paypal/includes'),
	'payment_tenpay' => array('type' => 'dir', 'path' => './payment/tenpay'),
	'share' => array('type' => 'dir', 'path' => './share'),
	'share_indexparam' => array('type' => 'dir', 'path' => './share/indexparam'),
	'share_statdata' => array('type' => 'dir', 'path' => './share/statdata'),	
	'sqlback' => array('type' => 'dir', 'path' => './sqlback'),
	'templates_c' => array('type' => 'dir', 'path' => './templates/templates_c'),
	'channel_drag' => array('type' => 'dir', 'path' => './templates/channel_drag/picfile'),
	'store_drag' => array('type' => 'dir', 'path' => './templates/store/picfile'),
);

$form_app_reg_items = array
(
	'ucenter' => array
	(
		'ucurl' => array('type' => 'text', 'required' => 1, 'reg' => '/^https?:\/\//', 'value' => array('type' => 'var', 'var' => 'ucapi')),
		'ucip' => array('type' => 'text', 'required' => 0, 'reg' => '/^\d+\.\d+\.\d+\.\d+$/'),
		'ucpw' => array('type' => 'password', 'required' => 1, 'reg' => '/^.*$/')
	),
	'siteinfo' => array
	(
		'sitename' => array('type' => 'text', 'required' => 1, 'reg' => '/^.*$/', 'value' => array('type' => 'constant', 'var' => 'SOFT_NAME')),
	)
);

$form_db_init_items = array
(
	'dbinfo' => array
	(
		'dbhost' => array('type' => 'text', 'required' => 1, 'reg' => '/^.+$/', 'value' => array('type' => 'var', 'var' => 'dbhost')),
		'dbname' => array('type' => 'text', 'required' => 1, 'reg' => '/^.+$/', 'value' => array('type' => 'var', 'var' => 'dbname')),
		'dbuser' => array('type' => 'text', 'required' => 0, 'reg' => '/^.*$/', 'value' => array('type' => 'var', 'var' => 'dbuser')),
		'dbpw' => array('type' => 'password', 'required' => 0, 'reg' => '/^.*$/', 'value' => array('type' => 'var', 'var' => 'dbpw')),
		'tablepre' => array('type' => 'text', 'required' => 0, 'reg' => '/^.*+/', 'value' => array('type' => 'var', 'var' => 'tablepre')),
	),
	'admininfo' => array
	(
		'username' => array('type' => 'text', 'required' => 1, 'reg' => '/^.*$/'),
		'email' => array('type' => 'text', 'required' => 1, 'reg' => '/^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/'),
		'password' => array('type' => 'password', 'required' => 1, 'reg' => '/^.*$/'),
		'password2' => array('type' => 'password', 'required' => 1, 'reg' => '/^.*$/'),
	)
);

//---------------------------------安装部分

//步骤
$allow_method = array('show_license', 'env_check', 'app_reg', 'db_init', 'ext_info', 'install_check', 'tablepre_check');
$step = intval(getgpc('step', 'R')) ? intval(getgpc('step', 'R')) : 0;
$method = $_POST['method'];
if(empty($method) || !in_array($method, $allow_method)) {
	$method = isset($allow_method[$step]) ? $allow_method[$step] : '';
}

//检测标识文件是否存在，如果存在，那么停止安装
if (file_exists('lock')){
	@header("Content-type: text/html; charset=UTF-8");
	echo "系统已经安装过了，如果要重新安装，那么请删除install目录下的lock文件";
	exit;
}

if(empty($method)) {
	show_msg('method_undefined', $method, 0);
}
if(!class_exists('dbstuff')) {
	show_msg('database_nonexistence', '', 0);
}

$uchidden = getgpc('uchidden');

if($method == 'show_license') {//声明
	transfer_ucinfo($_POST);
	show_license();
} elseif($method == 'env_check') {//检测环境

	function_check($func_items);

	env_check($env_items);

	dirfile_check($dirfile_items);

	show_env_result($env_items, $dirfile_items, $func_items);

} elseif($method == 'app_reg') {//网站信息
	
	
//	@include CONFIG;
	if(!defined('UC_API')) {
		define('UC_API', '');
	}
	$submit = true;
	$error_msg = array();
	
	if (empty($uchidden)){
		unset($form_app_reg_items['ucenter']);
	}
	
	if(isset($form_app_reg_items) && is_array($form_app_reg_items)) {
		foreach($form_app_reg_items as $key => $items) {
			$$key = getgpc($key, 'p');
			if(!isset($$key) || !is_array($$key)) {
				$submit = false;
				break;
			}
			foreach($items as $k => $v) {
				$tmp = $$key;
				$$k = $tmp[$k];
				if(empty($$k) || !preg_match($v['reg'], $$k)) {
					if(empty($$k) && !$v['required']) {
						continue;
					}
					$submit = false;
					$error_msg[$key][$k] = 1;
				}
			}
		}
	} else {
		$submit = false;
	}

	$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$bbserver = 'http://'.preg_replace("/\:\d+/", '', $_SERVER['HTTP_HOST']).($_SERVER['SERVER_PORT'] && $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '');
	$default_appurl = $bbserver.substr($PHP_SELF, 0, strpos($PHP_SELF, 'install/') - 1);
	
	if (!empty($uchidden)){
		$default_ucapi = $bbserver.'/ucenter';
		$ucapi = defined('UC_API') && UC_API ? UC_API : $default_ucapi;
	}
	
	if($submit) {
		//写入配置文件
		require_once("../classes/libraries/inifileoperate.class.php");
		$obj_config = new IniFileOperate("../config/config.ini.php");
		$obj_config->setIniFile("websit","site_name",trim($_POST['siteinfo']['sitename']));
		$obj_config->setIniFile("websit","site_title",trim($_POST['siteinfo']['sitename']));
		$obj_config->setIniFile("api","open_passport",'0');
		//uc-----------------------------------------------------
		if (!empty($uchidden)){
			$app_type = 'ShopNC'; 
			$app_name = $sitename ? $sitename : SOFT_NAME;
			$app_url = $siteurl ? $siteurl : $default_appurl;
	
			$ucapi = $ucurl ? $ucurl : (defined('UC_API') && UC_API ? UC_API : $default_ucapi);
			$ucip = isset($ucip) ? $ucip : '';
			$ucfounderpw = $ucpw;
	//		$app_tagtemplates = 'apptagtemplates[template]='.urlencode('<a href="{url}" target="_blank">{subject}</a>').'&'.
	//		'apptagtemplates[fields][subject]='.urlencode($lang['tagtemplates_subject']).'&'.
	//		'apptagtemplates[fields][uid]='.urlencode($lang['tagtemplates_uid']).'&'.
	//		'apptagtemplates[fields][username]='.urlencode($lang['tagtemplates_username']).'&'.
	//		'apptagtemplates[fields][dateline]='.urlencode($lang['tagtemplates_dateline']).'&'.
	//		'apptagtemplates[fields][url]='.urlencode($lang['tagtemplates_url']);
	
			$ucapi = preg_replace("/\/$/", '', trim($ucapi));
			
			if(empty($ucapi) || !preg_match("/^(http:\/\/)/i", $ucapi)) {
				show_msg('uc_url_invalid', $ucapi, 0);
			} else {
				if(!$ucip) {
					$temp = @parse_url($ucapi);
					$ucip = gethostbyname($temp['host']);
					if(ip2long($ucip) == -1 || ip2long($ucip) === FALSE) {
						show_msg('uc_dns_error', $ucapi, 0);
					}
				}
			}
			include_once ROOT_PATH.'./uc_client/client.php';
			$ucinfo = dfopen($ucapi.'/index.php?m=app&a=ucinfo&release='.UC_CLIENT_RELEASE, 500, '', '', 1, $ucip);
			list($status, $ucversion, $ucrelease, $uccharset, $ucdbcharset, $apptypes) = explode('|', $ucinfo);
			if($status != 'UC_STATUS_OK') {
				show_msg('uc_url_unreachable', $ucapi, 0);
			} else {
				$dbcharset = strtolower($dbcharset ? str_replace('-', '', $dbcharset) : $dbcharset);
				$ucdbcharset = strtolower($ucdbcharset ? str_replace('-', '', $ucdbcharset) : $ucdbcharset);
				if(UC_CLIENT_VERSION > $ucversion) {
					show_msg('uc_version_incorrect', $ucversion, 0);
				} elseif($dbcharset && $ucdbcharset != $dbcharset) {
					show_msg('uc_dbcharset_incorrect', '', 0);
				}
				$postdata = "m=app&a=add&ucfounder=&ucfounderpw=".urlencode($ucpw)."&apptype=".urlencode($app_type)."&appname=".urlencode($app_name)."&appurl=".urlencode($app_url)."&appip=&appcharset=".CHARSET.'&appdbcharset='.DBCHARSET.'&'.$app_tagtemplates.'&release='.UC_CLIENT_RELEASE;
				$ucconfig = dfopen($ucapi.'/index.php', 500, $postdata, '', 1, $ucip);
				if(empty($ucconfig)) {
					show_msg('uc_api_add_app_error', $ucapi, 0);
				} elseif($ucconfig == '-1') {
					show_msg('uc_admin_invalid', '', 0);
				} else {
					list($appauthkey, $appid) = explode('|', $ucconfig);
					if(empty($appauthkey) || empty($appid)) {
						show_msg('uc_data_invalid', '', 0);
					}
				}
			}
			//-------写入配置UC部分内容
			list($appauthkey, $appid, $ucdbhost, $ucdbname, $ucdbuser, $ucdbpw, $ucdbcharset, $uctablepre, $uccharset, $ucapi_2, $ucip) = explode('|', $ucconfig);
			$obj_config->setIniFile("api","open_passport",1);
			$obj_config->setIniFile("api","passport_key",$appauthkey);
			$obj_config->setIniFile("ucenter","uc_dbhost",$ucdbhost);
			$obj_config->setIniFile("ucenter","uc_dbuser",$ucdbuser);
			$obj_config->setIniFile("ucenter","uc_dbpw",$ucdbpw);
			$obj_config->setIniFile("ucenter","uc_dbname",$ucdbname);
			$obj_config->setIniFile("ucenter","uc_dbcharset",$ucdbcharset);
			$obj_config->setIniFile("ucenter","uc_dbtablepre",$uctablepre);
			$obj_config->setIniFile("ucenter","uc_api",$ucapi);
			$obj_config->setIniFile("ucenter","uc_charset",$uccharset);
			$obj_config->setIniFile("ucenter","uc_appid",$appid);
			$obj_config->setIniFile("ucenter","uc_ppp",20);
	//		$obj_config->setIniFile("ucenter","uc_ip",$ucip);
			$obj_config->setIniFile("ucenter","uc_link",'true');
		}
		unset($obj_config);
		//跳转
		$step = $step + 1;
		@header("Location: index.php?step=$step");
		exit;
	}
	show_form($form_app_reg_items, $error_msg);
	
} elseif($method == 'db_init') {//数据库信息
	$submit = true;
	$error_msg = array();
	
	if(isset($form_db_init_items) && is_array($form_db_init_items)) {
		foreach($form_db_init_items as $key => $items) {
			$$key = getgpc($key, 'p');
			if(!isset($$key) || !is_array($$key)) {
				$submit = false;
				break;
			}
			foreach($items as $k => $v) {
				$tmp = $$key;
				$$k = $tmp[$k];
				if(empty($$k) || !preg_match($v['reg'], $$k)) {
					if(empty($$k) && !$v['required']) {
						continue;
					}
					$submit = false;
					$error_msg[$key][$k] = 1;
				}
			}
		}
	} else {
		$submit = false;
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if($password != $password2) {
			$error_msg['admininfo']['password2'] = 1;
			$submit = false;
		}
		$forceinstall = isset($_POST['dbinfo']['forceinstall']) ? $_POST['dbinfo']['forceinstall'] : '';
		$dbname_not_exists = true;
		if(!empty($dbhost) && empty($forceinstall)) {
			$dbname_not_exists = check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre);
			if(!$dbname_not_exists) {
				$form_db_init_items['dbinfo']['forceinstall'] = array('type' => 'checkbox', 'required' => 0, 'reg' => '/^.*+/');
				$error_msg['dbinfo']['forceinstall'] = 1;
				$submit = false;
				$dbname_not_exists = false;
			}
		}
	}

	if($submit) {
		//编码
		define('DBCHARSET',getgpc('charset', 'R')?getgpc('charset', 'R'):'UTF8');
		
		$step = $step + 1;
		if(empty($dbname)) {
			show_msg('dbname_invalid', $dbname, 0);
		} else {
			if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
				$errno = mysql_errno();
				$error = mysql_error();
				if($errno == 1045) {
					show_msg('database_errno_1045', $error, 0);
				} elseif($errno == 2003) {
					show_msg('database_errno_2003', $error, 0);
				} else {
					show_msg('database_connect_error', $error, 0);
				}
			}
			
			if(mysql_get_server_info() > '4.1') {
				mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET ".DBCHARSET);
			} else {
				show_msg('database_version_old', $error, 0);
			}

			if(mysql_errno()) {
				show_msg('database_errno_1044', mysql_error(), 0);
			}
			//mysql_close();
		}

		if(strpos($tablepre, '.') !== false) {
			show_msg('tablepre_invalid', $tablepre, 0);
		}

		if($username && $email && $password) {
			if(strlen($username) > 15 || preg_match("/^$|^c:\\con\\con$|　|[,\"\s\t\<\>&]|^游客|^Guest/is", $username)) {
				show_msg('admin_username_invalid', $username, 0);
			} elseif(!strstr($email, '@') || $email != stripslashes($email) || $email != htmlspecialchars($email)) {
				show_msg('admin_email_invalid', $email, 0);
			}
		} else {
			show_msg('admininfo_invalid', '', 0);
		}

		config_edit();
		//入库
		$db = new dbstuff;
		$db->connect($dbhost, $dbuser, $dbpw, $dbname, DBCHARSET);
		
		if (strtoupper($_POST['charset']) == 'GBK'){
			$sqlfile = 'sql/shopnc_gbk.sql';
			//演示数据
			if (getgpc('demo_date', 'R') == '1'){
				$demo_sqlfile = 'sql/sample_data_gbk.sql';
			}
		}else {
			$sqlfile = 'sql/shopnc_utf8.sql';
			//演示数据
			if (getgpc('demo_date', 'R') == '1'){
				$demo_sqlfile = 'sql/sample_data_utf8.sql';
			}
		}
		$sql = file_get_contents($sqlfile);
		$sql = str_replace("\r\n", "\n", $sql);

		show_header();
		show_install();

		runquery($sql);
		if (getgpc('demo_date', 'R') == '1'){
			$demo_sql = file_get_contents($demo_sqlfile);
			$demo_sql = str_replace("\r\n", "\n", $demo_sql);
			runquery($demo_sql);
		}
		//管理员帐号密码
		$db->query("INSERT INTO {$tablepre}system_member (sys_login_name, sys_password, sys_group_id, sys_email) VALUES ('$username', '". md5($password) ."', '1', '$email');");
//		echo '<iframe src="../" style="display:none"></iframe>'."\r\n";

		//对于开店协议的转码重新写入,默认是gbk的
		$shop_agreement = @file_get_contents('../html/shop_agreement.html');
		if (strtoupper($_POST['charset']) == 'GBK'){
			//转码 utf-8 to gbk
			@unlink('../html/shop_agreement.html');
			$shop_agreement = mb_convert_encoding($shop_agreement,'gb2312','utf-8');
			$fp = @fopen('../html/shop_agreement.html','wb+');
			@fwrite($fp,$shop_agreement);
			@fclose($fp);
		}else {
			//不变
		}
		
		
		//新增一个标识文件，用来屏蔽重新安装
		$fp = @fopen(ROOT_PATH.'install/lock','wb+');
		@fclose($fp);
		//删除缓存文件中的config
		@unlink(ROOT_PATH.'cache/configini.cache.php');
		show_footer();
	}
	$dbhost = 'localhost';
	$dbname = 'shopnc';
	$dbuser = 'root';
	$dbpw = 'root';
	$tablepre = 'shopnc_';
	$charset = getgpc('charset', 'p');
	show_form($form_db_init_items, $error_msg);
}
?>