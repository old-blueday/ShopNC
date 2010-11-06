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
* FILE_NAME : footer.php D:\root\shopnc6_jh\footer.php
* 前台底部文件
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:45:08 CST 2009
*/
require ("global.inc.php");
class ShowFooter extends CommonFrameWork {
	/**
	 * 底部信息对象
	 *
	 * @var obj
	 */
	private $obj_shopnc_info;
	
	/**
	 * 统计对象
	 *
	 * @var obj
	 */
	private $obj_shop_visit;

	function main(){
		/**
		 * 创建底部信息对象
		 */
		if (!is_object($this->obj_shopnc_info)) {
			require_once("system.class.php");
			$this->obj_shopnc_info = new SystemClass();
		}
		/**
		 * 创建统计对象
		 */
		if (!is_object($this->obj_shop_visit)) {
			require_once("visit.class.php");
			$this->obj_shop_visit = new VisitClass();
		}
		
		/**
		 * 语言包
		 */
		$this->getlang("header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			default:
				$this->footer();
		}

	}
	private function footer() {
		$info_array	= $this->obj_shopnc_info->getSystemList();
		$this->output('info_array',$info_array);
		$this->showpage('footer');
		/*访问记录*/
		//$input_param['ip'] = $this->agent_ip; 			//ip
		//$input_param['ip_area'] = "null";      			//来源地区
		//$input_param['visit_url'] = $this->cur_url;		//访问地址
		//$input_param['source_url'] = $this->refer_url;	//来源地址
		//$input_param['visit_system'] = $this->obj_shop_visit->getOS($_SERVER['HTTP_USER_AGENT']);//访问系统
		//$this->obj_shop_visit->addVisit($input_param);
	}
}
$show_footer = new Showfooter();
$show_footer->main();
unset($show_footer);
?>