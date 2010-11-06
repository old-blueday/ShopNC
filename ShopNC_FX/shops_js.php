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
* FILE_NAME : shops_js.php D:\root\shopnc6_jh\shops_js.php
* 商品外部调用
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:54:41 CST 2009
*/
require ("global.inc.php");
class ShowShopsJs extends CommonFrameWork {

	/**
	 * 产品对象
	 *
	 * @var obj
	 */
	private $obj_product_class;
	/**
	 * 产品对象
	 *
	 * @var obj
	 */
	private $obj_ad;
	
	function main(){

		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_product_class)) {
			require_once("productClass.class.php");
			$this->obj_product_class = new ProductClassClass();
		}
		/**
		 * 创建广告对象
		 */
		if (!is_object($this->obj_ad)) {
			require_once("toolAd.class.php");
			$this->obj_ad = new ToolAdClass();
		}
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'shops_ad':		//广告js调用
				$this->jsShopAd();
				break;
			case 'goods_js':		//商品js调用
				$this->jsGoods();
				break;
				
		}

	}
	private function jsShopAd() {
		$array		= array();
		
		if(intval($_GET['ad_id']) == 0) {
			exit();
		}
		$array['js_charset']= trim($this->_input['js_charset']);	//广告
		$array['ad_id']		= intval($this->_input['ad_id']);		//广告id
		
		$ad_js	= $this->obj_ad->getShopJs($array,$this->_charset,$this->_configinfo['websit']['site_url']);
		echo 'document.write("'.str_replace('"','\"',$ad_js).'")';
	}
	/**
	 * js调用商品函数
	 *
	 */
	private function jsGoods() {
		$array	= array();
		$array['condition']	= trim($this->_input['condition']);				//调用类型
		$array['bid']		= intval($this->_input['bid']);					//调用分类
		$array['num']		= intval($this->_input['num']);					//显示商品数量
		$array['show']		= intval($this->_input['show']);				//是否显示图片
		$array['arrange']	= trim($this->_input['arrange']);				//横排竖排
		$array['is_show']	= intval($this->_input['is_show']);				//多行显示
		$array['charset']	= trim($this->_input['charset']);				//字符编码
		$array['show_num']	= intval($this->_input['show_num']);			//每行显示数目
		$array['site_url']	= $this->_configinfo['websit']['site_url'];
		
		if(trim($this->_input['condition']) == 'type') {
			include(BasePath."/share/".NC_SHOP_DIR."goods_class_show.php");
			$array_type	= array();
			foreach ($node_cache as $k => $v) {
				if($v[0] == intval($this->_input['bid'])) {
					$array_type['class_id']	= $v[0];
					$array_type['class_top_id']	= $v[1];
					$array_type['key_id']	= $k;
					break;
				}
			}
			$array['class_array']	= $array_type;
		}
		$goods_js	= $this->obj_product_class->getGoodsJs($array,$this->_charset);
		echo 'document.write("'.$goods_js.'")';
	}
}
$show_shops_js	= new ShowShopsJs();
$show_shops_js->main();
unset($show_shops_js);
?>