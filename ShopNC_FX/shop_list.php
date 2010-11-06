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
* FILE_NAME : shop_list.php D:\root\shopnc6_jh\shop_list.php
* 商户列表
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:51:55 CST 2009
*/
require("shop.global.inc.php");
class ShowShopList extends ShopCommonFrameWork {
	/**
	 * 网店对象
	 *
	 * @var obj
	 */
	private $obj_shopuser;
	/**
	 * 网店对象
	 *
	 * @var obj
	 */
	private $obj_shop_class;

	public function main() {

		/**
		 * 创建网店对象
		 */
		if (!is_object($this->obj_shopuser)){
			require_once("shopUser.class.php");
			$this->obj_shopuser = new ShopUserClass();
		}
		/**
		 * 创建网店类型对象
		 */
		if (!is_object($this->obj_shop_class)){
			require_once("shopClass.class.php");
			$this->obj_shop_class = new ShopClassClass();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("templates/new_shops");
		/**
		 * 语言包
		 */
		$this->getlang("shop_list,shop_common");
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'all_list':			//全部分类
			$this->showAllClass();
			break;
			//			case 'type_all_list':		//分类下的商店列表
			//			$this->showClassShopList();
			break;
			case 'index':				//店铺分类首页
			$this->showClassIndex();
			break;
			default:					//搜索列表
			$this->showSearchShopList();
		}
	}
	/**
	 * 店铺分类
	 *
	 */
	private function showClassIndex() {
		/*热门网店*/
		$hot_shops_array		= $this->obj_shopuser->getShopListType(array('shop_type'=>'hot_shop'),6);
		$this->output('hot_shops_array',$hot_shops_array);

		/*新开网店*/
		$new_shops_array	= $this->obj_shopuser->getShopListType(array('shop_type'=>'new_shop'),6);
		$this->output('new_shops_array',$new_shops_array);

		/*店铺分类列表*/
		include(BasePath."/share/shop_class_show.php");
		$parent_array = array();
		foreach ($node_cache as $node) {
			if ($node['parentId']==0&&$node['iffb']==1) {
				$parent_array[]=$node;
			}
		}
		$i=0;
		$node_array = array();
		foreach ($parent_array as $parent) {
			$node_array[$i]=$parent;
			foreach ($node_cache as $node) {
				if ($parent['id']==$node['parentId']&&$node['iffb']==1) {
					$node_array[$i]['sub_array'][]=$node;
				}
			}
			$i++;
		}
		$this->output('node_array',$node_array);

		$this->shopshowpage("shop_list");
	}
	/**
	 * 店铺全部分类
	 *
	 */
	private function showAllClass() {
		/*店铺分类列表*/
		include(BasePath."/share/shop_class_show.php");
		$parent_array = array();
		foreach ($node_cache as $node) {
			if ($node['parentId']==0&&$node['iffb']==1) {
				$parent_array[]=$node;
			}
		}
		$i=0;
		$node_array = array();
		foreach ($parent_array as $parent) {
			$node_array[$i]=$parent;
			foreach ($node_cache as $node) {
				if ($parent['id']==$node['parentId']&&$node['iffb']==1) {
					$node_array[$i]['sub_array'][]=$node;
				}
			}
			$i++;
		}
		$this->output('node_array',$node_array);

		$this->shopshowpage("shop_all_class_list");

	}
	/**
	 * 分类下的商店列表
	 *
	 */
	//	private function showClassShopList() {
	//		/*得到网店类别信息*/
	//		$tid		= intval($this->_input['id']);
	//		$class_info	= $this->obj_shop_class->getShopClassInfo(array('class_id'=>$tid));
	//		if(count($class_info)<1) {
	//			header("Location:".$this->refer_url);
	//			exit();
	//		}
	//		$this->output('class_info',$class_info);
	//
	//		/*查找下一级分类*/
	//		include(BasePath."/share/shop_class_show.php");
	//		$node_str = "";
	//		foreach ($node_cache as $node) {
	//			if ($node['parentId'] == $tid and $node['iffb']==1) {
	//				$node_str .= $node['id'].",";
	//			}
	//		}
	//		$node_str .= $tid;
	//		/*创建分页对象*/
	//		require_once("commonpage.class.php");
	//		$obj_page = new CommonPage();
	//		$obj_page->pagebarnum(10);
	//		$condition_array	= array('class_id_str'=>$node_str);
	//		$shop_array			= $this->obj_shopuser->getShopList($condition_array,$obj_page);
	//		$show_page			= $obj_page->show(2);
	//		$this->output('shop_array',$shop_array);
	//		$this->output('show_page',$show_page);
	//
	//		/*新开网店*/
	//		$new_shops_array	= $this->obj_shopuser->getShopListType(array('shop_type'=>'new_shop'),6);
	//		$this->output('new_shops_array',$new_shops_array);
	//
	//		$this->showpage("shop_category");
	//	}
	/**
	 * 店铺搜索列表
	 * 
	 */
	/**
	 * 分类下的商店列表
	 *
	 */
	private function showSearchShopList() {
		$condition_array = array();
		if (intval($this->_input['txt_class_top_id']) !=0){		//店铺分类
			$tid	= intval($this->_input['txt_class_top_id']);
		}
		if (trim($this->_input['txt_keywords']) != ''){			//关键字
			$condition_array['shopname']= trim($this->_input['txt_keywords']);
		}
		if (trim($this->_input['txtProvince']) != ''){			//商品在地
			$condition_array['txt_address']		= trim($this->_input['txtProvince']);
		}
		$condition_array['shopstate'] = 1;						//状态

		/*得到网店类别信息*/
		if ($tid != ''){
			$class_info	= $this->obj_shop_class->getShopClassInfo(array('class_id'=>$tid));
			$this->output('class_info',$class_info);
		}
		if ($tid != ''){
			/*查找下一级分类*/
			include(BasePath."/share/shop_class_show.php");
			$node_str = "";
			foreach ($node_cache as $node) {
				if ($node['parentId'] == $tid and $node['iffb']==1) {
					$node_str .= $node['id'].",";
				}
			}
			$node_str .= $tid;
			$condition_array['class_id_str'] = trim($node_str,',');
		}

		/*创建分页对象*/
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(10);
		$obj_page->pagesize=3;
		$shop_array			= $this->obj_shopuser->getShopList($condition_array,$obj_page);

		/*取得店铺发布商品数量*/
		$shop_id_str = '';
		foreach ($shop_array as $v) {
			$shop_id_str .= $v['userid'].',';
		}
		if ($shop_id_str != ''){
			$shop_id_str = trim($shop_id_str,',');
			$shop_array_count = $this->obj_shopuser->getShopGoodsCount($shop_id_str);
			foreach ($shop_array as $k=>$v) {
				foreach ($shop_array_count as $v1) {
					if ($v['userid'] == $v1['shop_id']){
						$shop_array[$k]['goods_count'] = $v1['goods_count'];
					}
				}
			}
		}

		$show_page			= $obj_page->show(8);
		$this->output('shop_array',$shop_array);
		$this->output('shop_count',count($shop_array));
		$this->output('page_list',$show_page);
		/*新开网店*/
		$new_shops_array	= $this->obj_shopuser->getShopListType(array('shop_type'=>'new_shop'),6);
		$this->output('new_shops_array',$new_shops_array);
		$this->output('query_string',$_SERVER["QUERY_STRING"]);

		$this->shopshowpage("shop_search_list");
	}
}
$shop_list = new ShowShopList();
$shop_list->main();
unset($shop_list);
?>