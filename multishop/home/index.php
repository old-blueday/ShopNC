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
 * FILE_NAME : index.php   FILE_PATH : \multishop\home\index.php
 * ....商城首页显示
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Sep 21 14:05:16 CST 2007
 */

require ("../global.inc.php");

class ShowIndex extends CommonFrameWork{
	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	var $objProductCate;
	/**
	 * 商铺分类对象
	 *
	 * @var obj
	 */
	var $obj_shop_category;
	/**
	 * 首页和频道静态页面对象
	 *
	 * @var obj
	 */
	var $obj_html_channel;
	
	function main(){
		/**
		 * 创建首页和频道静态页面对象
		 */
		if (!is_object($this->obj_html_channel)){
			require_once("../home/html.channel.php");
			$this->obj_html_channel = new HtmlChannelManage();
		}
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->objProductCate)){
			require_once ("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_shop_category)){
			require_once("shopcategory.class.php");
			$this->obj_shop_category = new ShopCategoryClass();
		}
		
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("index_show");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "aj_get_class":
				$this->_aj_get_class();
				break;
			case "getQuickLinks":
				$this->_getQuickLinks();
				break;
			case "index_html":
				$this->_index_html();
				break;
			default:
				$this->_showindex();
		}

	}
	/**
	 * 首页显示
	 * 
	 */
	function _showindex(){
		if ($this->_configinfo['websit']['index_html'] == '0'){
			$this->_index_html();
		}else {
			if (file_exists('../index.html')){
				header("location: ../index.html");
			}else {
				$this->_index_html();
				header("location: ../index.html");
			}
		}
	}
	
	/**
	 * 取商品或商户的类别
	 */
	function _aj_get_class(){
		$this->_langType = "";
		$search_type = $this->_input['search_type'];//搜索类别
		if ($search_type == 'shop'){//商户
			/**
			 * 获取商铺的2级分类
			 */
			$category_array = $this->obj_shop_category->getLevelCategory(2,'','','',1);
			/**
		     * 将商铺分类以下拉框的形式出现
		     */
			$this->output("search_cate", Common::getSelectArray($category_array,array('class_id','class_name')));
		}elseif ($search_type == 'product'){//商品
			$array = $this->objProductCate->listClassDetail();
			if (is_array($array)){
				foreach ($array as $k => $v){
					if ($v[4] == 0) {
						$search_cate[] = $v;
					}
				}
			}
			$this->output("search_cate", $search_cate);
		}
		$this->output("search_type", $search_type);
		$this->showpage('aj.index_search');
	}
	
	/**
	 * 取会员快速链接导航
	 */
	function _getQuickLinks(){
		//设置模板路径
		$this->setsubtemplates("");
		$array = $this->getQuickLinks();
		//判断是否登录
		if ($_SESSION["s_login"]['login'] == 1){
			$this->output('login_sign',1);
			//判断是否有店铺
			if ($_SESSION["s_login"]['type'] == '1'){
				$this->output('shop_sign',1);
				$this->output('shop_del',$_SESSION["s_shop"]['if_del']);//删除状态
			}
		}
		
		//插件列表
		$app_list = $this->menuAppList();
		/**
		 * 页面输出
		 */
		$this->output('QuickLinks',$array);
		$this->output('app_list',$app_list);
		$this->showpage("quick_links");
	}
	
	/**
	 * 生成首页静态
	 */
	function _index_html(){
		$this->obj_html_channel->_index_html();
	}

}
$index = new ShowIndex();
$index->main();
unset($index);
?>