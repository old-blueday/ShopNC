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
* FILE_NAME : index.php D:\root\shopnc6_jh\install\index.php
* 安装文件
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:28:36 CST 2009
*/
require ("../shop.global.inc.php");
class showInstall extends ShopCommonFrameWork {
	/**
	 * 系统安装类
	 *
	 * @var obj
	 */
	private $obj_install;

	function main() {
		/*安装检查*/
		if($this->checkInstall()) exit();
		/**
		 * 创建系统安装对象
		 */
		if (!is_object($this->obj_install)) {
			require_once("install.class.php");
			$this->obj_install = new installClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("install/install_tpl");

		switch ($this->_input['action']) {
			case 'step_2':
				$this->installStep2();
				break;
			case 'step_3':
				$this->installStep3();
				break;
			case 'step_4':
				$this->installStep4();
				break;
			case 'check_mysql_ver':
				$this->check_mysql_version();
				break;
			case 'step_1':
			default:
				$this->installStep1();
				break;
		}
	}
	/**
	 * 安装页面1
	 *
	 */
	private function installStep1() {		
		$this->showpage('step_1');
	}
	/**
	 * 安装页面2
	 *
	 */
	private function installStep2() {
		$info = $this->obj_install->shopncInstallTwo();
		$this->output("info",$info);
		$this->showpage('step_2');
	}
	/**
	 * 安装页面3
	 *
	 */
	private function installStep3() {
		$HttpHost   = "http://".$_SERVER['HTTP_HOST'];
		/*得到网站根域名*/
		$Positon	= stripos($HttpHost,'.');
		$Domain_Name= substr($HttpHost,$Positon);
		$this->output('nc_domainname',$Domain_Name);
		/*得到网站完整网址*/
		$ScriptName = $_SERVER['SCRIPT_NAME'];
		$SubPath    = trim(str_replace(strstr($ScriptName, '/install'),"",$ScriptName));
		$HttpHost   .= $SubPath != "" ? $SubPath : "";
		$this->output('nc_url',$HttpHost);
		$this->showpage('step_3');
	}
	/**
	 * 安装页面4
	 *
	 */
	private function installStep4() {
		if(!$this->check_mysql_version('step4')) {
			$this->showMessage('数据库不匹配（必须为mysql5以上）或数据库信息填写错误','index.php?action=step_3',1);
		}
		$input_param['nc_dbhost']		= trim($this->_input['nc_dbhost']);		//数据库访问地址
		$input_param['nc_dbname']		= trim($this->_input['nc_dbname']);		//数据库名称
		$input_param['nc_dbuser']		= trim($this->_input['nc_dbuser']);		//数据库用户名
		$input_param['nc_dbpwd']		= trim($this->_input['nc_dbpwd']);		//数据库密码
		$input_param['nc_dbport']		= trim($this->_input['nc_dbport']);		//数据库端口
		$input_param['nc_dbprefix']		= trim($this->_input['nc_dbprefix']);	//数据表前缀
		$input_param['nc_add_test']		= trim($this->_input['nc_add_test']);	//是否添加测试数据
		$input_param['nc_adminuser']	= trim($this->_input['nc_adminuser']);	//管理员用户名
		$input_param['nc_adminpwd']		= trim($this->_input['nc_adminpwd']);	//管理员密码
		$input_param['nc_webname']		= trim($this->_input['nc_webname']);	//网站名称
		$input_param['nc_adminmail']	= trim($this->_input['nc_adminmail']);	//管理员邮箱
		$input_param['nc_weburl']		= trim($this->_input['nc_weburl']);		//网站网址
		$input_param['nc_pay_receive_type']	= trim($this->_input['nc_pay_receive_type']);	//网店模式
		$input_param['nc_domainname']	= trim($this->_input['nc_domainname']);	//网站根域名
		$input_param['nc_charset']		= trim($this->_input['nc_charset']);	//系统字符集，包括数据库字符集
		/*数据库操作*/
		$db_sql_insert	= $this->obj_install->siteMysql($input_param);
		$sql_error_array= array(2=>'数据库创建失败',3=>'数据库连接错误',4=>'没有数据库操作权限',5=>'原始数据库出错',6=>'测试数据出错');
		if(in_array($db_sql_insert,array(2,3,4,5,6))) {
			if($db_sql_insert != 1) {
				$this->showMessage($sql_error_array[$db_sql_insert],'index.php?action=step_3',1);
				exit();
			}
		}
		/*配置文件操作*/
		$config_site	= $this->obj_install->configSite($input_param);
		if (!$config_site) return false;

		$this->output('web_url',$input_param['nc_weburl']);
		$this->output('install_finish',1);
		$this->showpage('step_4');
	}
	private function checkInstall() {
		@header("Content-type: text/html; charset=utf-8");
		if(file_exists(BasePath."/share/install.lock")) {
			echo '您已经成功安装网城创想分销王系统！<a href="'.$this->_configinfo['websit']['site_url'].'" target="_blank">'.$this->_configinfo['websit']['site_url'].'</a>';
			return true;
		} else {
			return false;
		}
	}
	private function check_mysql_version($type='') {
		$step4_state	= false;
		$conn			= @mysql_connect(trim($_REQUEST['nc_dbhost']).":".intval($_REQUEST['nc_dbport']),trim($_REQUEST['nc_dbuser']),trim($_REQUEST['nc_dbpwd']));
		if($conn) {
			$check_result	= substr(@mysql_get_server_info(),0,1)>=5 ? true : false;
			if($type == 'step4') {
				$step4_state	= $check_result ? true : false;
			}
			$out_msg		= $check_result ? 'mysql数据库可用' : '<font color="red">mysql版本小于5.0，不可用</font>';
		} else {
			$out_msg		= '<font color="red">数据库连接错误，请从新输入连接信息</font>';
		}
		if($type == 'step4') {
			return $check_result;
		} else {
			echo $out_msg;
		}
	}
}
$install_index = new showInstall();
$install_index->main();
unset($install_index);
?>