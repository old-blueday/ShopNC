<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : html.other.php   FILE_PATH : E:\www\multishop\trunk\home\html.other.php
 * ....生成静态 -- 其他静态（页脚，基本栏目等）
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Aug 28 16:53:46 CST 2008
 */

require ("../global.inc.php");

class HtmlOtherManage extends CommonFrameWork{
	/**
	 * 栏目对象
	 *
	 * @var obj
	 */
	var $obj_section;
	/**
	 * 友情链接对象
	 *
	 * @var obj
	 */
	var $obj_link;
	/**
	 * 关键词对象
	 *
	 * @var obj
	 */
	var $obj_key;
	/**
	 * 频道对象
	 *
	 * @var obj
	 */
	var $obj_channel;
	/**
	 * php5构造函数
	 */
	 
	function __construct(){
		$this->HtmlOtherManage();
	}
	/**
	 * php4构造函数
	 */
	function HtmlOtherManage(){
		/**
		 * 执行父类的构造函数
		 */
		parent::CommonFrameWork();
	}

	/**
	 * 主方法
	 */
	//	function main(){
	//		//操作类，模板路径和语言包在各个操作中创建
	//		switch($this->_input['action']){
	//			case "make_footer_html":
	//				$this->_make_footer_html();
	//				break;
	//			case "make_section_html":
	//				$this->_make_section_html();
	//				break;
	//			case "make_link_html":
	//				$this->_make_link_html();
	//				break;
	//			case "make_key_html":
	//				$this->_make_key_html();
	//				break;
	//		}
	//	}

	/**
	 * 创建页脚footer模板
	 */
	function _make_footer_html(){
		/**
		 * 创建栏目对象
		 */
		if (!is_object($this->obj_section)){
			require_once("section.class.php");
			$this->obj_section = new SectionClass();
		}
		ob_start();
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates('');
		/**
		 * 语言包
		 */
		$this->getlang("sys_section.manage");

		/**
		 * 取得需要显示的通用栏目信息
		 */
		$array = $this->obj_section->getSectionList();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v['is_show'] == 1){
					$footer_array[] = $v;
				}
			}
		}
		
		/**
		 * ntalker 插件html内容输出
		 */
		require_once("app_module.class.php");
		$obj_app_class = new AppModuleClass();
		$app_output = $obj_app_class->getAppModuleHtmlCode('ntalker');
		unset($obj_app_class);
		/**
		 * 页面输出
		 */
		$this->output('config_poweredby',$this->_configinfo['websit']['poweredby']);
		$this->output('config_icprecord',$this->_configinfo['websit']['icprecord']);
		$this->output('url',$this->_configinfo['websit']['site_url']);
		$this->output('footer_array',$footer_array);
		$this->output('app_output',$app_output);
		$this->showpage('footer');

		$this_my_file = ob_get_contents();
		ob_end_clean();
		$file_name = BasePath.'/html/footer.html';
		require_once("makehtml.class.php");
		if(MakeHtml::tohtmlfile($file_name, $this_my_file)){
			return true;
		}else{
			return $this->_lang['langCOperatorFooterLost'];
		}
	}
	/**
	 * 创建键词列表模板
	 */
	function _make_keyword_html(){
		/**
		 * 创建栏目对象
		 */
		if (!is_object($this->obj_key)){
			require_once("keyword.class.php");
			$this->obj_key = new KeywordClass();
		}
		ob_start();
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates('home');
	
		/**
		 * 取得需要显示的通用栏目信息
		 */
		 $condition['keyword_display']=1;
		 $condition['order']=1;
		$array = $this->obj_key->getKeywordList($condition,$obj_page);
		
		
		
		/**
		 * 页面输出
		 */
		$this->output('show_array',$array);
		$this->showpage('keyword.tpl');

		$this_my_file = ob_get_contents();
		ob_end_clean();
		$file_name = BasePath.'/html/keyword.html';
		require_once("makehtml.class.php");
		if(MakeHtml::tohtmlfile($file_name, $this_my_file)){
			return true;
		}else{
			return $this->_lang['langCOperatorFooterLost'];
		}
	}
	/**
	 * 创建频道列表模板
	 */
	function _make_channel_html(){
		/**
		 * 创建栏目对象
		 */
		if (!is_object($this->obj_key)){
			require_once("keyword.class.php");
			$this->obj_key = new KeywordClass();
		}
		ob_start();
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates('home');
		/**
		 * 页面输出
		 */
		$this->output('channel_list',$this->_get_channel_list());
		$this->showpage('channel.tpl');

		$this_my_file = ob_get_contents();
		ob_end_clean();
		$file_name = BasePath.'/html/channel.html';
		require_once("makehtml.class.php");
		if(MakeHtml::tohtmlfile($file_name, $this_my_file)){
			return true;
		}else{
			return $this->_lang['langCOperatorFooterLost'];
		}
	}
	function _get_channel_list(){
		/**
		 * 创建频道对象
		 */
		if (!is_object($this->obj_channel)){
			require_once ("channel.class.php");
			$this->obj_channel = new ChannelClass();
		}
		//取导航频道
		$condition_channel["order_by"] = "channel_sort";
		$condition_channel["state"] = "0";
		$condition_channel["order_sort"] = "asc";
		$channel_all = $this->obj_channel->listChannel($condition_channel,$page);
		unset($condition_channel);
		return $channel_all;
	}
	/**
	 * 创建基本栏目静态
	 */
	function _make_section_html(){
		/**
		 * 创建栏目对象
		 */
		if (!is_object($this->obj_section)){
			require_once("section.class.php");
			$this->obj_section = new SectionClass();
		}
		//基本栏目列表
		$section_list = $this->obj_section->getSectionList();
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("sys_section.manage,news");
		/**
		 * 循环生成栏目静态
		 */
		if(!empty($section_list)){
			foreach($section_list as $k => $v){
				ob_start();
				/**
				 * 页面输出
				 */
				$this->output('url',$this->_configinfo['websit']['site_url']);
				$this->output('link_array',$section_list);
				$this->output('section_array',$v);
				$this->showpage('section.html');

				$this_my_file = ob_get_contents();
				ob_end_clean();
				if(!is_dir(BasePath."/html/section")){
					!mkdir(BasePath."/html/section", 0777);
				}
				$file_name = BasePath."/html/section/".$v['section_id'].'.html';
				require_once("makehtml.class.php");
				$result = MakeHtml::tohtmlfile($file_name, $this_my_file);
				if(!$result){
					return $this->_lang['langSysSecHtmlFail'];
				}
			}
		}
		return true;
	}

	/**
	 * 生成友情链接静态
	 */
	function _make_link_html(){
		/**
		 * 创建友情链接对象
		 */
		if (!is_object($this->obj_link)){
			require_once("link.class.php");
			$this->obj_link = new LinkClass();
		}
		ob_start();
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("sys_link_manage");
		//取得需要显示的信息
		$condition['close'] = '0';
		$condition['order'] = 'asc';
		$link_array = $this->obj_link->listLink($condition,$page);
		/*区分友情链接类型*/
		if (is_array($link_array)){
			foreach ($link_array as $k => $v){
				if (trim($v['link_title']) != ''){
					if ($v['link_type'] == '0'){//图片
						if (!file_exists("../".$v['link_pic'])){//判断图片是否存在
							$v['link_pic'] = '';
						}
						$pic_array[] = $v;
					}else {
						$char_array[] = $v;
					}
				}
			}
		}

		/**
		 * 页面输出
		 */
		$this->output('link_info',$this->_configinfo['link']);
		$this->output('url',$this->_configinfo['websit']['site_url']);
		$this->output('pic_array',$pic_array);
		$this->output('char_array',$char_array);
		$this->showpage('link.tpl');

		$this_my_file = ob_get_contents();
		ob_end_clean();

		$file_name = BasePath.'/html/link.html';
		require_once("makehtml.class.php");
		if(MakeHtml::tohtmlfile($file_name, $this_my_file)){
			return true;
		}else{
			return false;
		}
	}
}
?>