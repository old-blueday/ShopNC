<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : index.community.php   FILE_PATH : \multishop\home\index.community.php
 * 首页新闻调用
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Jan 30 11:02:09 CST 2008
 */

require ("../global.inc.php");

class communityIndex extends CommonFrameWork{
	/**
	 * 社区对象
	 *
	 * @var obj
	 */
	var $obj_community;
	
	function main(){
		/**
		 * 创建社区对象
		 */
		if (!is_object($this->obj_community)) {
			require_once("community.class.php");
			$this->obj_community = new CommunityClass();
		}
		/**
		 * 初始化分页类
		 */
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("member");

			
		$num = $this->_input['num'];/*信息数量*/
		$pic = $this->_input['pic'];/*图片设定*/
		$cate = $this->_input['cate'];/*类别*/
		$highlights = $this->_input['highlights'];/*是否精华*/
		/*取信息*/
		$obj_page->pagebarnum(intval($num));
		$array = $this->obj_community->_listcommunityhighlights($num,$pic,$highlights,$cate,$obj_page);
		/*整理信息*/
		$length = $this->_input['length'];/*信息字数*/
		$community_array = $this->obj_community->_cut_community($array,$length,$this->_configinfo['websit']['ncharset']);
		
		/**
		 * 页面输出
		 */
		if (is_array($community_array)){
			$line =  "document.write(\"";
			foreach ($community_array as $k => $v){
				$line .= "<li>";
				if ($pic == '1'){
					if (file_exists('../'.$v['community_pic'])){
						$line .= "<img width='80' height='80' src='../".$v['community_pic']."' /><br/>";
					}else {
						$line .= "<img width='80' height='80' src='../templates/default/home/images/default.jpg' /><br/>";
					}
				}
				$line .= "<a href='../community/community.php?tid=".$v['community_id']."' target='_blank'";
				if($v['community_title'] != $v['cut_title']){
					$v['community_title'] = str_replace("\"","\\\"",$v['community_title']);
					$line .= "title='".$v['community_title']."'";
				}
				$v['cut_title'] = str_replace("\"","\\\"",$v['cut_title']);
				$line .= ">".$v['cut_title']."</a></li>";
			}
			$line .= "\");";
		}
			echo $line;
		
	}
}
$community_index = new communityIndex();
$community_index->main();
unset($community_index);
?>