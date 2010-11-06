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
 * FILE_NAME : control.php   FILE_PATH : E:\www\multishop\trunk\store\control.php
 * ....店铺模板拖拽
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Jun 19 10:07:47 CST 2008
 */

require_once("../global.inc.php");

class StoreControlClass extends  StoreFrameWork{
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 店铺信息
	 *
	 * @var array
	 */
	var $shop;
	/**
	 * 商铺拖拽图片对象
	 *
	 * @var obj
	 */
	var $obj_shop_drag;
	/**
	 * 商铺模块对象
	 *
	 * @var obj
	 */
	var $obj_shop_module;
	
	/**
	 * 店铺风格
	 *
	 * @var obj
	 */
	var $obj_shop_module_style;
	

	function main(){
		/**
		 * 实例化商店类
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 实例模块类
		 */
		if (!is_object($this->obj_shop_module)){
			require_once("shop_module.class.php");
			$this->obj_shop_module = new ShopModule();
		}
		
		
		
		$this->setsubtemplates('store/store_drag');
		
		$this->getlang("store,store_style");
		if($this->_input['action']!="getSysPic")
		{
			//判断是否登陆
			$this->isMember();
	
			//判断是否是店铺，取店铺信息
			if(!empty($_SESSION['s_shop']['id'])){
				$this->shop = $this->obj_shop->getOneShop($_SESSION['s_shop']['id'],'1');
				if(empty($this->shop)){
					$this->redirectPath("error",'','shop is empty');
				} // else ok
			}else{
				$this->redirectPath("error",'','no shop');
			}
		}
		
			
		

		switch($this->_input['action']){
			case "show":
				$this->_show();
				break;
			case "save":
				$this->_save();
				break;
			case 'getSysPic':
				$this->_get_sys_pic();
				break;
			case 'getlistmod':
				$this->_get_list_mod();
				break;
			case 'getlistmodorder':
				$this->_get_list_mod_order();
				break;
			case 'delmod':
				$this->_del_mod();
				break;
			case 'addmod':
				$this->_add_mod();
				break;
			case 'updatemod':
				$this->_updata_mod();
				break;
			case 'savestyle':
				$this->_savestyle();
				break;
			case 'showlistmod':
				$this->_show_list_mod();
				break;
			case 'getonemod':
				$this->_getonemod();
				break;
			case "product_search":
				$this->_product_search();
				break;
			case "product_search_info":
				$this->_product_search_info();
				break;
			case "addmodpid":
				$this->_addmodpid();
				break;
			case "updateproduct":
				$this->_updateproduct();
				break;
			case "updateproductmod":
				$this->_updateproductmod();
				break;
			case "showproductmod":
				$this->_showproductmod();
				break;
			case "getonestyle":
				$this->_getonestyle();
				break;
			case "getmp3":
				$this->_getmp3();
				break;
			case "mp3updata":
				$this->_mp3update();
				break;
				case "getvideo":
				$this->_get_video();
				break;
				case "videoupdate":
				$this->_video_update();
				break;
			default:
				$this->_show();
		}
	}
    function _video_update(){
		$data=array();
		$data['shop_id']=$this->shop['shop_id'];
		$data['video']=$this->_input["videohtml"];
		$array=$this->obj_shop_module->video_updata($data);
	}
	function _get_video(){
		$array=$this->obj_shop_module->get_video($this->shop['shop_id']);
		echo $array;
		
	}
	//更新音乐
	function _mp3update(){
		$data=array();
		$data['shop_id']=$this->shop['shop_id'];
		$data['mp3']=$this->_input["mp3html"];
		if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			$data['mp3']=Common::nc_change_charset($data['mp3'],'utf8_to_gbk');
		}
		$array=$this->obj_shop_module->mp3_updata($data);
	}
	//获得音乐
	function _getmp3(){
		$array=$this->obj_shop_module->mp3_list($this->shop['shop_id']);
		if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			$array['mp3']=Common::nc_change_charset($array['mp3'],'gbk_to_utf8');
		}
		echo $array;
		
	}
	function _getonestyle(){
			/**
		 * 实例模块类
		 */
		if (!is_object($this->obj_shop_module_style)){
			require_once("shop_module_style.class.php");
			$this->obj_shop_module_style = new ShopModuleStyle();
		}
		$id=$this->_input["id"];
		$module_array=$this->obj_shop_module->listShopModuleorder($_SESSION['s_login']['id']);
		$style_array=$this->obj_shop_module_style->getOneStyle($id);
		
		
		$block_list = array();
		

		//店铺风格
		if($style_array['style_body'] != ''){
			$style_list = unserialize($style_array['style_body']);
		}
	
		
	
		$module_array_name=array();
		for($i=0;$i<count($module_array);$i++)
		{
			$module_array_name[$i]='newmodule'.$module_array[$i]['module_id'];
		}
	
		
		for($i=0;$i<count($module_array_name);$i++)
		{
			$s=$module_array_name[$i];
			
			$style_list['block'][$s]=$style_list['block']["style_module"];
		}
		//die();
		
		//输出自定义的css样式表内容
		$block_css = '';
		if (is_array($style_list['block'])){
			//模块内部样式
			$block_css = '';
			foreach ($style_list['block'] as $k => $v){
				foreach($v as $k2 => $v2){
					if($k == 'body'){
						$block_css .= $k.' '.$k2.'{';
					}else{
						$block_css .= '#'.$k.' '.$k2.'{';
					}
					foreach($v2 as $k3 => $v3){
						$block_css .= $v3.';';
					}
					$block_css .= '}'."\n";
				}
			}
		}
		//print_r($style_list);die();
		// $block_css=str_replace('#style_module','.block',$block_css);
		echo $block_css."|||||".serialize($style_list);
	
	
		//页面内容 输出到模板
		/*$this->output('shop_info',$this->_get_shop_info());
		$this->output('shop_category',$this->_get_shop_category());
		$this->output('proclamation',$this->_get_shop_proclamation());
		$this->output('shop_link',$this->_get_shop_link());
		$this->output('shop_product',$this->_get_shop_product());
		$this->output('shop_message',$this->_get_shop_message());
		$this->output('recommended_product',$this->_get_shop_recommended_product());
		$this->output('shop_tag',$this->_get_shop_tag());*/
	}

	//展示商品
	
	function _showproductmod(){
		$id=$this->_input["mudole_id"];
		$array=$this->obj_shop_module->showproductmod($id);
		
		$this->output('product_array',$array);
		$this->showpage("control_product_module");
	}
	
	
	//更新商品列表
	function _updateproductmod(){
		$data=array();
		$pid=$this->_input["pid"];
		$list=explode("|.",$pid);
		$data["module_id"]=$this->_input["module_id"];
		$data["module_name"]=$this->_input["module_name"];
		$data["module_type"]=$this->_input["module_type"];
		$array=$this->obj_shop_module->updateproductmod($data,$list);
		
	}
	/******更新商品模块******/
	function _updateproduct(){
		$data=array();
		$data=$this->_input["mid"];
		$array=$this->obj_shop_module->updateproduct($data);
		$this->output('product_array',$array);
		$this->showpage("control_module_product_search_info");
	}
	/******商品模块添加********/
	function _addmodpid(){
		$data=array();
		$pid=$this->_input["pid"];
		$list=explode("|.",$pid);
		$data['module_name']=$this->_input["module_name"];
		$data['module_user_id']=$_SESSION['s_login']['id'];
		$data['module_type']=2;
		$array=$this->obj_shop_module->addmodpid($list,$data);
		echo $array;
	}
	
	/**
	 * 查找AJAX指定ID的商品内容
	 */
	function _product_search_info(){
		
		//取商品信息
		$condition = "";
		$product_row = "";
		$conditions['p_id'] = intval($this->_input['p_id']);
		$conditions['member_id']=intval($_SESSION['s_login']['id']);
		$product_row = $this->obj_shop_module->getProductList($conditions,$page);
		if ($product_row[0] != ""){
			$product_array[0] = $product_row[0];
		}

		/**
		 * 页面输出
		 */
		// print_r($product_array);die();
		$this->output('product_array',$product_array);
		$this->showpage("control_module_product_search_info");
	}
	/***查找商品*******/
	
	function _product_search(){

		/**
		 * 创建商品对象
		 */
	
		if (!is_object($obj_ajax_page)) {
			require_once("ajaxcommonpage.class.php");
			$obj_ajax_page = new ajaxCommonPage();
		}

		$obj_ajax_page->pagebarnum(12);
		$obj_condition['member_id']=intval($_SESSION['s_login']['id']);
		$obj_condition[search_cate] = $this->_input['search_cate'];//商品类别
		$obj_condition[keygenre] = 1;//商品名称
	    
		
		$obj_condition[key] = Common::unescape($this->_input['keyword'],$this->_configinfo['websit']['ncharset']);
		$product_array = $this->obj_shop_module->getProductList($obj_condition,$obj_ajax_page);
		$page_list = $obj_ajax_page->show(2);

		/**
		 * 页面输出
		 */
		// echo 1;die();
		$this->output('page_list',$page_list);
		$this->output('product_array',$product_array);
		$this->showpage('control_module_product_search_result');
	}
	
	
	/*****获得一个模块的信息*******/
	function _getonemod(){
		
		$array=$this->obj_shop_module->getonemod($this->_input['module_id']);
		
		if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			
					$array['module_name']=Common::nc_change_charset($array['module_name'],'gbk_to_utf8');
					$array['module_body']=Common::nc_change_charset($array['module_body'],'gbk_to_utf8');
			
		}
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$return_value= $obj_json->encode($array);
		
		echo $return_value;
	}
	
	/***获得模块列表********/
	function _get_list_mod_order(){
		$array=$this->obj_shop_module->listShopModuleorder($_SESSION['s_login']['id']);
		if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			if(is_array($array))
			{
				for($i=0;$i<count($array);$i++)
				{
					$array[$i]['module_name']=Common::nc_change_charset($array[$i]['module_name'],'gbk_to_utf8');
					$array[$i]['module_body']=Common::nc_change_charset($array[$i]['module_body'],'gbk_to_utf8');
					
				}
			}
		}
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$return_value= $obj_json->encode($array);
		
		echo $return_value;
	}
	/***获得模块列表********/
	function _get_list_mod(){
		
		$array=$this->obj_shop_module->listShopModule($_SESSION['s_login']['id']);
	
				if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			if(is_array($array))
			{
				for($i=0;$i<count($array);$i++)
				{
					$array[$i]['module_name']=Common::nc_change_charset($array[$i]['module_name'],'gbk_to_utf8');
					$array[$i]['module_body']=Common::nc_change_charset($array[$i]['module_body'],'gbk_to_utf8');
					
				}
			}
		}
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$return_value= $obj_json->encode($array);
		
		echo $return_value;
	}
	/**显示布局**/
	function _show_list_mod(){
		
		$array=$this->obj_shop_module->listShopModule($this->_input['userid']);
				if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			if(is_array($array))
			{
				for($i=0;$i<count($array);$i++)
				{
					$array[$i]['module_name']=Common::nc_change_charset($array[$i]['module_name'],'gbk_to_utf8');
					$array[$i]['module_body']=Common::nc_change_charset($array[$i]['module_body'],'gbk_to_utf8');
					
				}
			}
		}
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$return_value= $obj_json->encode($array);
		
		echo $return_value;
	}
	/**删除模块**/
	function _del_mod(){
		$array=$this->obj_shop_module->delShopModule($this->_input['id']);
	}
	/****添加普通模块***/
	function _add_mod(){
		$list=array();
		if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			$list['module_name']=Common::nc_change_charset($this->_input['module_name'],'utf8_to_gbk');
			$list['module_body']=Common::nc_change_charset($this->_input['module_body'],'utf8_to_gbk');
		}else{
			$list['module_name']=$this->_input['module_name'];
			$list['module_body']=$this->_input['module_body'];
			
		}
		$list['module_user_id']=$_SESSION['s_login']['id'];
		$array=$this->obj_shop_module->addShopModule($list);
	    echo $array;
	}
	/***更新普通模块*****/
	function _updata_mod(){
		$list=array();
		$list['module_id']=$this->_input['module_id'];
			if($this->_configinfo['websit']['ncharset']=="GBK")
		{
			$list['module_name']=Common::nc_change_charset($this->_input['module_name'],'utf8_to_gbk');
			$list['module_body']=Common::nc_change_charset($this->_input['module_body'],'utf8_to_gbk');
		}else{
			$list['module_name']=$this->_input['module_name'];
			$list['module_body']=$this->_input['module_body'];
			
		}
		$list['module_type']=$this->_input['module_type'];
		
		$array=$this->obj_shop_module->_updateShop($list);
	}
	/***保存布局******/
	function _savestyle(){
		$list=array();
		$str=$this->_input["str"];
		$data1=explode("|.",$str);
		for($i=0;$i<count($data1);$i++)
		{
			$data2=explode("|,",$data1[$i]);
			
			$list[$i]['module_parent']=$data2[0];
			$list[$i]['module_id']=$data2[1];
			$list[$i]['module_bodystyle']=$data2[2];
			$list[$i]['module_order']=$data2[3];
		}
		
		$array=$this->obj_shop_module->_updatastyle($list);
	}

	/**
	 * 模板拖拽
	 *
	 * @param int $id 记录ID
	 * @return 模板输出
	 */
	function _show(){
		//自定义风格内容
		$this->_get_diy_style();
		$this->showpage('store_control');
	}
	
	/**
	 * 保存内容
	 *
	 * @param $this->_input 表单内容
	 * @return 模板输出
	 */
	function _save() {
		if ($this->_input['getBack'] == '1'){ // 恢复原状
			$this->_show();
		}
		if ($this->_input['getBack'] == '0'){//保存
			$array = array();
			$array['shop_id'] = $this->shop['shop_id'];
			$array['shop_style'] = $this->_input['diyStyle'];
			$result = $this->obj_shop->updateShopStyle($array);
			if($result === true){
				$this->redirectPath("error",'../member/own_shopstyle.php',$this->_lang['langStoreStyleSaveSucc']);
			}else{
				$this->redirectPath("error",'',$this->_lang['errStoreStyleSaveFail']);
			}
		}
	}
	
	/**
	 * AJAX取图片内容
	 *
	 * @param $this->_input 表单内容
	 * @return string XML格式内容
	 */
	function _get_sys_pic(){
		/**
		 * 实例化商店类
		 */
		if (!is_object($this->obj_shop_drag)){
			require_once("shop_drag.class.php");
			$this->obj_shop_drag = new ShopDragClass();
		}
		/**
		 * 初始化分页类
		 */
		require_once("ajaxcommonpage.class.php");
		$obj_page = new ajaxCommonPage();
		$obj_page->ajax_action_name = 'getpage';
		$obj_page->style = 'last';
		$obj_page->is_drag = true;
		
		//检索条件
		//样式
		if($this->_input['category'] != ''){//style
			$obj_condition['sd_style'] = $this->_input['category'];
		}
		//颜色
		if($this->_input['color'] != ''){//color
			$obj_condition['sd_color'] = $this->_input['category'];
		}
		//类别 //默认图算第一个 (大背景，标题背景，尾部 12个)（头部， 6个）
		$this->_input['type'] = $this->_input['type']?$this->_input['type']:'1';
		if($this->_input['type'] == 2){//头部
			if($this->shop['shop_banner_pic'] != ''){//有banner的情况
				$obj_page->pagebarnum(4);
			}else{
				$obj_page->pagebarnum(5);
			}
		}else{
			$obj_page->pagebarnum(11);
		}
		$obj_condition['sd_type'] = $this->_input['type'];
		$sd_array = $this->obj_shop_drag->listShopDragPic($obj_condition,$obj_page);
		$page_list = $obj_page->show(6);
		@header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="'.$this->_configinfo['websit']['ncharset'].'"?><root><![CDATA[';
		if($this->_input['type'] == 2){
			echo '<ul class="imglist imgmax"><li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/templates/store/store_drag/default/images/pic_nobgmax.gif" onclick="javascript:changeBackground(this, \'system\', 1);"/></a></li>';
			//banner
			if($this->shop['shop_banner_pic'] != ''){//有banner的情况
				echo '<li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/'.$this->shop['shop_banner_pic'].'" onclick="javascript:changeBackground(this, \'system\');"/></a></li>';
			}
		}else{
			echo '<ul class="imglist"><li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/templates/store/store_drag/default/images/pic_nobg.gif" onclick="javascript:changeBackground(this, \'system\', 1);"/></a></li>';
		}
		if(is_array($sd_array)){
			foreach($sd_array as $k => $v){
				echo '<li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/'.$v['sd_pic'].'" onclick="javascript:changeBackground(this, \'system\');"/></a></li>';
			}
			if(!empty($sd_array)){
				echo '</ul><div class="floatpage"><div class="pages">'.$page_list.'</div></div>';
			}
		}
		echo "]]></root>";
		exit;
	}
}

$control = new StoreControlClass();
$control->main();
unset($control);
?>