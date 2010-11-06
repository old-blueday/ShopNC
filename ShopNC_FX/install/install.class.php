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
* FILE_NAME : install.class.php D:\root\shopnc6_jh\install\install.class.php
* 安装类
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:28:46 CST 2009
*/
class installClass {
	/**
	 * 安装第二步需要显示的信息
	 */
	public function shopncInstallTwo() {
		$step3_state	= false;
		$info_array		= array();

		$info_array['server']	= array(
		'server_url'			=>$_SERVER['HTTP_HOST'],
		'php_ver'				=>@phpversion(),
		'os_ver'				=>@php_uname(),
		'web_os'				=>$_SERVER["SERVER_SOFTWARE"],
		'nc_path'				=>str_replace('/install','',dirname($_SERVER["SCRIPT_FILENAME"])));

		$info_array['php']		= array(
		'use_php'				=>(substr(phpversion(),0,1)>=5 ? true : false),
		'use_mysql'				=>function_exists('mysql_connect'),
		'use_gd2'				=>function_exists('imagegd2'));
		$info_array['dir']		= $this->siteDir();

		$step3_state	= ($info_array['php']['use_php'] and $info_array['php']['use_mysql'] and $info_array['php']['use_gd2']) ? 1 : 0;
		$info_array['step3_state'] = $step3_state;

		return $info_array;
	}
	/**
	 * 数据库操作
	 */
	public function siteMysql($db_array) {

		$db_array['nc_charset']	= !in_array($db_array['nc_charset'],array('utf8','gbk')) ? 'utf8' : $db_array['nc_charset'];

		/*数据库连接*/
		if(in_array($this->mysqlConn($db_array),array(2,3,4))) return  $this->mysqlConn($db_array);

		/*读取sql语句，创建原始数据库*/
		$sql_str	= @file_get_contents("sql/shopnc6_".$db_array['nc_charset'].".sql");
		$sql_str	= $this->nc_replace_sql($sql_str,$db_array);
		$sql_array	= $this->split_sql($sql_str);
		foreach ($sql_array as $v) {
			if(strpos($v,"@shopnc_url@") !== false) {
				$v	= str_replace('@shopnc_url@',$db_array['nc_weburl'],$v);
			}
			$insert_db = mysql_query($v);
			if(!$insert_db) {
				return 5;		//原始数据库出错
			}
		}
		/*导入测试数据*/
		$insert_test = true;
		if($db_array['nc_add_test'] == '1') {
			$test_sql_str	= @file_get_contents("sql/test_".$db_array['nc_charset'].".sql");
			$test_sql_str	= $this->nc_replace_sql($test_sql_str,$db_array);

			$test_sql_array	= $this->split_sql($test_sql_str);
			foreach ($test_sql_array as $k) {
				$insert_test = mysql_query($k);
				if(!$insert_test) {
					return 6;	//测试数据出错
				}
			}
		}
		mysql_close();

		if($insert_db and $insert_test) {
			return true;
		}
	}

	/**
 	* 将配置信息写入配置文件
 	*/
	public function configSite($conf_array) {
		/*写入数据库配置信息*/
		$db_info		= @file_get_contents("sql/database_sample.php");
		$db_info		= str_replace('---dbhost---',	$conf_array['nc_dbhost'],$db_info);
		$db_info		= str_replace('---dbname---',	$conf_array['nc_dbname'],$db_info);
		$db_info		= str_replace('---dbuser---',	$conf_array['nc_dbuser'],$db_info);
		$db_info		= str_replace('---dbpasswd---',	$conf_array['nc_dbpwd'],$db_info);
		$db_info		= str_replace('---dbprefix---',	$conf_array['nc_dbprefix'],$db_info);
		$db_info		= str_replace('---dbcharset---',$conf_array['nc_charset'],$db_info);
		$db_info		= str_replace('---dbport---',	$conf_array['nc_dbport'],$db_info);
		if(!file_put_contents(BasePath."/data/database.ini.php",$db_info)) {
			return false;
		}
		/*写入系统配置信息*/
		$config_info	= @file_get_contents("sql/config_sample.php");
		$config_info	= str_replace('---shops_name---',$conf_array['nc_webname'],$config_info);
		$config_info	= str_replace('---shop_email---',$conf_array['nc_adminmail'],$config_info);
		$config_info	= str_replace('---site_url---',$conf_array['nc_weburl'],$config_info);
		$config_info	= str_replace('---url---',$_SERVER['HTTP_HOST'],$config_info);
		$config_info	= str_replace('---domainname---',$conf_array['nc_domainname'],$config_info);
		$config_info	= str_replace('---pay_receive_type---',$conf_array['nc_pay_receive_type'],$config_info);
		$config_info	= str_replace('---nc_charset---',($conf_array['nc_charset'] == 'gbk' ? 'gbk' : 'utf-8'),$config_info);
		$config_info	= $conf_array['nc_charset'] == 'gbk' ? Common::nc_change_charset($config_info,'utf8_to_gbk') : $config_info;
		if(!file_put_contents(BasePath."/share/shop_config.ini.php",$config_info)) {
			return false;
		}
		/*修改数据库内的配置数据表*/
		$this->mysqlConn($conf_array);
		$site_array	= array(
		'shops_name'		=> $conf_array['nc_webname'],
		'shopemail'			=> $conf_array['nc_adminmail'],
		'site_url'			=> $conf_array['nc_weburl'],
		'url'				=> $_SERVER['HTTP_HOST'],
		'domainname'		=> $conf_array['nc_domainname'],
		'pay_receive_type'	=> $conf_array['nc_pay_receive_type'],
		'nc_charset'		=> ($conf_array['nc_charset'] == 'gbk' ? 'gbk' : 'utf-8'));
		foreach ($site_array as $k => $v) {
			mysql_query("UPDATE `".$conf_array['nc_dbprefix']."shop_config` SET value='".$v."' WHERE valuename='".$k."'");
		}

		/*修改管理员密码，用户名，邮箱*/
		mysql_query("UPDATE `".$conf_array['nc_dbprefix']."shop_admin` SET adminname='".$conf_array['nc_adminuser']."',adminpass='".substr(md5($conf_array['nc_adminpwd']),0,16)."',adminemail='".$conf_array['nc_adminmail']."' WHERE id=1");

		/*在share创建系统安装过的标记文件*/
		if(!@file_put_contents(BasePath."/share/install.lock",'shopnc is install')) {
			return false;
		}
		/*转换文件编码*/
		$this->change_file_charset('sql/share/','../share/',$conf_array['nc_charset']);
		$this->change_file_charset('sql/language/','../language/zh_cn/',$conf_array['nc_charset']);
		
		/*如果没有添加测试数据做如下处理*/
		if($conf_array['nc_add_test'] != '1') {
			
			@unlink(BasePath.'/share/goods_class_show.php');
			@unlink(BasePath.'/share/article_class_show.php');
		}
		
		return true;
	}
	/**
 	* 设置目录权限
 	*/

	public function siteDir() {
		$dir_list	= array(
		'/data',
		'/data/session',
		'/data/databack',
		'/share',
		'/cache',
		'/templates',
		'/templates/',
		'/admin/templates',
		'/admin/templates/templates_c',
		'/system/templates',
		'/system/templates/templates_c',		
		'/attachments',
		'/attachments/brandlogo',
		'/attachments/subjectimg',
		'/attachments/upimg',
		'/attachments/linklogo',
		'/attachments/adfile',
		'/attachments/languageimage',
		'/language'
		);

		include_once('fileoperate.class.php');
		$array	= array();
		foreach ($dir_list as $v) {
			FileOperate::WriteDirOrFile(BasePath.$v,'dir');
			$array[$v]	= $this->writeFile(BasePath.$v);
			//清除文件状态缓存
			clearstatcache();
		}
		return $array;
	}
	/**
	 * 测试目录是否有写入权限
	 */
	public function writeFile($dir_path,$test_file	= "nc_text.txt") {
		$fh	= @fopen($dir_path.'/'.$test_file,'w');
		if(!fh) {
			return false;
		} else {
			@fclose($fh);
			if(@unlink($dir_path.'/'.$test_file)) {
				return true;
			} else {
				return false;
			}
		}
	}
	/**
	 * 简易mysql连接
	 */	
	public function mysqlConn($db_array) {
		$connect	= @mysql_connect($db_array['nc_dbhost'].":".$db_array['nc_dbport'],$db_array['nc_dbuser'],$db_array['nc_dbpwd']);
		if(!$connect) {
			return 3;		//数据库连接错误
		}
		$select_db	= @mysql_select_db($db_array['nc_dbname'],$connect);
		if(!$select_db) {
			$create_db	= mysql_query("CREATE DATABASE `".$db_array['nc_dbname']."` DEFAULT CHARACTER SET ". $db_array['nc_charset']);
			if(!$create_db) {
				return 2;	//数据库创建失败
			} else {
				$select_db	= @mysql_select_db($db_array['nc_dbname'],$connect);
				if(!$select_db) {
					return 4;//没有数据库操作权限
				}
			}
		}
		@mysql_query("SET NAMES '".$db_array['nc_charset']."'");
	}
	/**
	 * 切割sql语句
	 */
	function split_sql($sql) {
		$sql = trim($sql);
		$sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);

		$buffer = array();
		$ret = array();
		$in_string = false;

		for($i=0; $i<strlen($sql)-1; $i++) {
			if($sql[$i] == ";" && !$in_string) {
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i + 1);
				$i = 0;
			}

			if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
				$in_string = false;
			}
			elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
				$in_string = $sql[$i];
			}
			if(isset($buffer[1])) {
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		if(!empty($sql)) {
			$ret[] = $sql;
		}
		return($ret);
	}
	/**
	 * 解析sql语句
	 */	
	function  nc_replace_sql($sql_str,$array) {
		$sql	= '';
		$sql	= str_replace('@shopnc@',$array['nc_dbprefix'],	$sql_str);
		$sql	= preg_replace('/^\s*(?:--|#).*/m', '', 		$sql);
		$sql	= preg_replace('/^\s*\/\*.*?\*\//ms', '', 		$sql);
		$sql	= str_replace("\r", '', 						$sql);
		return $sql;
	}
	/**
	 * 转换文件编码
	 */	
	function change_file_charset($path,$to_path,$charset) {
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				$body = '';
				if (!is_dir($file) && $file != "." && $file != "..") {
					$body	= file_get_contents($path.$file);
					if($charset == 'gbk') {
						$body =  Common::nc_change_charset($body,'utf8_to_gbk');
					}
					file_put_contents($to_path.$file,$body);
				}
			}
			closedir($handle);
		}
	}
}
?>