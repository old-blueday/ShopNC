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
 * FILE_NAME : news.php   FILE_PATH : E:\www\multishop\trunk\home\news.php
 * ....信息页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Jul 03 17:10:25 CST 2008
 */

require ("../global.inc.php");

class NewsManage extends CommonFrameWork{
	/**
	 * 信息对象对象
	 *
	 * @var obj
	 */
	var $objProductCate;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 新闻对象
	 *
	 * @var obj
	 */
	var $obj_news;

	function main(){
		/**
		 * 创建信息对象
		 */
		if (!is_object($this->obj_news)){
			require_once ("news.class.php");
			$this->obj_news = new NewsClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("news");

		switch($this->_input['action']){
			case "list":
				$this->_list_news();
				break;
			default:
				$this->_show_news();
		}


	}

	/**
	 * 信息详细页面
	 */
	function _show_news(){
		/**
		 * 信息验证
		 */
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["id"], "require"=>"true","validator"=>"Number", "message"=>$this->_lang['errNewsIdIsWrong']),
		);
		$error = $this->obj_validate->validate();
		if ($error != ''){
			$this->redirectPath("error","",$error);
		}else {
			//取信息内容
			$news_array = $this->obj_news->getNews($this->_input["id"],'more');
			$this->obj_page->pagebarnum(10);

			//取信息列表
			$condition = array();
			$condition['news_c_id'] = $news_array['news_c_id'];
			$condition['order_by'] = 'news_time_desc';
			$news_list = $this->obj_news->listNews($condition, $this->obj_page);
			if (is_array($news_list)){
				foreach ($news_list as $k => $v){
					//截取信息列表字数
					$news_list[$k]['news_title'] = Char_class::cut_str($news_list[$k]['news_title'],14,0,$this->_configinfo['websit']['ncharset']);
					//判断是否有跳转链接
					if ($news_list[$k]['news_jump_url'] != ''){
						$news_list[$k]['url'] = $news_list[$k]['news_jump_url'];
					}else {
						$news_list[$k]['url'] = $this->_configinfo['websit']['site_url']."/home/news.php?id=".$news_list[$k]['news_id'];
					}
				}
			}

			/**
			 * 页面输出
			 */
			$this->output('keyword_message',' '.$news_array['news_title']);
			$this->output('desc_message',' '.$news_array['news_title']);
			$this->output('message_date',@date('Y-m-d H:i',$news_array['news_date']));
			$this->output('news_array',$news_array);
			$this->output('news_list',$news_list);
			$this->showpage('news.detail');
		}
	}

	/**
	 * 信息列表
	 */
	function _list_news(){
		/**
		 * 信息验证
		 */
		$this->obj_validate->validateparam = array(
		array("input"=>$this->_input["cid"], "validator"=>"Number", "message"=>$this->_lang['errNewsCIdIsWrong']),
		);
		$error = $this->obj_validate->validate();
		if ($error != ''){
			$this->redirectPath("error","",$error);
		}else {
			//信息列表
			$obj_condition['news_c_id'] = $this->_input["cid"];
			$obj_condition['order_by'] = 'news_sort_asc';
			$this->obj_page->pagebarnum(15);
			$news_array = $this->obj_news->listNews($obj_condition,$this->obj_page);
			if (is_array($news_array)){
				foreach ($news_array as $k => $v){
					//截取信息列表字数
					$news_array[$k]['news_title'] = Char_class::cut_str($news_list[$k]['news_title'],14,0,$this->_configinfo['websit']['ncharset']);
					//判断是否有跳转链接
					if ($news_array[$k]['news_jump_url'] != ''){
						$news_array[$k]['url'] = $news_array[$k]['news_jump_url'];
					}else {
						$news_array[$k]['url'] = $this->_configinfo['websit']['site_url']."/home/news.php?id=".$news_array[$k]['news_id'];
					}
				}
			}
			$page_list = $this->obj_page->show(1);
			//类别列表
			$news_class_array = $this->obj_news->listNewsClass('',$page);
			//当前类别
			$class_array = $this->obj_news->getNewsClass($this->_input['cid']);
			/**
			 * 页面输出
			 */
			$this->output('class_array',$class_array);
			$this->output('news_array',$news_array);
			$this->output('news_class_array',$news_class_array);
			$this->output('page_list',$page_list);
			$this->showpage('news.list');
		}
	}
}
$news = new NewsManage();
$news->main();
unset($news);
?>