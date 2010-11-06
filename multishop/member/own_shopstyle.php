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
 * FILE_NAME : own_shopstyle.php   FILE_PATH : E:\www\multishop\trunk\member\own_shopstyle.php
 * ....商店模板选择
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Fri Oct 03 10:05:31 CST 2008
 */

require_once("../global.inc.php");

class OwnShopStyleManage extends memberFrameWork{
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;

	function main(){
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("shop");
		$this->getlang("shopstyle");

		/**
		 * 菜单输出
		 */
		$this->memberMenu('my_shop','shop_manage','shop_style');

		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "save":
				$this->_saveStyle();
				break;
			default:
				$this->_getStyleList();
		}

	}

	/**
	 * 得到样式列表
	 *
	 */
	function _getStyleList(){
		$shop_array = $this->obj_shop->getOneShop($_SESSION['s_shop']['id']);//商店信息

		if (file_exists(BasePath . "/templates/storestyle/style.xml")){
			$hdc = new XmlParse(BasePath . "/templates/storestyle/style.xml");
			$data_count = $hdc->count_tag("root:style","1:?");
			for($i=1;$i<=$data_count;$i++){
				$file_name = $hdc->get_attribute("root:style","1:" . $i,"filename");
				$style_name = $hdc->get_tag_text("root:style:value","1:" . $i);
				$style_info = $hdc->get_attribute("root:style","1:" . $i,"info");
				$style_array[$i-1]['file'] = $file_name;
				//$style_array[$i-1]['name'] = $style_name;
				//对模板名称进行转码，转成设置的字符字符编码
//				$style_array[$i-1]['name'] = mb_convert_encoding($style_name,$this->_configinfo['websit']['ncharset'],"UTF-8");
				if ($this->_configinfo['websit']['ncharset'] == 'GBK'){
		        	$style_array[$i-1]['name'] = Common::nc_change_charset($style_name,'utf8_to_gbk');
		        }else {
		        	$style_array[$i-1]['name'] = $style_name;
		        }
				$style_array[$i-1]['info'] = $style_info;
			}
		}
		/**
		 * 页面输出
		 */
        $this->output('member_id', $_SESSION['s_login']['id']);
		$this->output('shop_array',   $shop_array);      //输出商店信息
		$this->output('style_array',   $style_array);      //输出样式列表列表
		$this->showpage('own_shopstyle.modi');
	}

	/**
	 * 修改样式
	 *
	 */
	function _saveStyle(){
		//模板路径
		$templates_path = $this->_configinfo['websit']['site_url'].'/tempates/'.$this->_configinfo['websit']['templatesname'];

		$this->_input['hideShopId'] = $_SESSION['s_shop']['id'];
		$this->_input['templates'] = $this->_input['sel_type'];
		$this->obj_shop->operateShop($this->_input);
		if ($this->_input['sel_type'] == '1'){//自定义模板
			$url = $this->_configinfo['websit']['site_url'].'/store/control.php';
			header("location: ".$url);
			exit;
		}else {
			$this->redirectPath("succ","member/own_shopstyle.php",$this->_lang['langSStyleSelectOk']);
		}

	}
}
$shop_style = new OwnShopStyleManage();
$shop_style->main();
unset($shop_style);
?>