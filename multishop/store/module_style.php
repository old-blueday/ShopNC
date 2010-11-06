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
 * FILE_NAME : channel.php   FILE_PATH : E:\www\multishop\trunk\home\channel.php
 * ....频道展示页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Dec 18 10:08:14 CST 2008
 */

require ("../global.inc.php");

class ModuleStyle extends ChannelFrameWork {
		/**
	 * 店铺拖拽对象
	 *
	 * @var obj
	 */
	var $obj_shop_module_style;
	/**
	 * 频道拖拽对象
	 *
	 * @var obj
	 */
	var $obj_channel_drag;


	function main(){
		/**
		 * 实例化店铺风格类
		 */
		if (!is_object($this->obj_shop_module_style)){
			require_once("shop_module_style.class.php");
			$this->obj_shop_module_style = new ShopModuleStyle();
		}
		/**
		 * 语言包
		 */
		$this->getlang("channel");
		$this->getlang("store_style");
		$this->setsubtemplates('store/store_drag');
		
		
		switch ($this->_input['action']){
			case 'control':
				$this->_checkSysMember();
				$this->_control();
				break;
			
			case 'getSysPic':
				$this->_checkSysMember();
				$this->_get_sys_pic();
				break;
			case 'set_default':
				$this->_checkSysMember();
				$this->_set_default();
				break;
			case 'control_ajax':
				$this->_checkSysMember();
				$this->_control_ajax();
				break;
			default:
				$this->_show();
		}
	}
	
	/**
	 * 频道模板拖拽
	 *
	 * @param int $id 频道ID
	 * @return 模板输出
	 */
	function _control(){
		
		//取频道风格和模块内容
		$this->_get_diy_style($this->_input['id']);
		/**
		 * 页面输出
		 */
		$this->showpage('channel_control');
	}
	function _control_ajax(){
		
		//取频道风格和模块内容
		$this->_get_diy_style($this->_input['id']);
		/**
		 * 页面输出
		 */
		 
		$this->showpage('channel_control_ajax');
	}


	/**
	 * 频道展示
	 */
	function _show(){
		if (intval($this->_input['id']) > 0){
			//取频道风格和模块内容
			$this->_get_diy_style($this->_input['id']);
			//判断是否登录
			if ($_SESSION["s_login"]['login'] == 1){
				$this->output('login_sign',1);
				//判断是否有店铺
				if ($_SESSION["s_login"]['type'] == '1'){
					$this->output('shop_sign',1);
				}
				//输出会员信息
				$this->output('login_name',$_SESSION['s_login']['name']);
				$this->output('login_id',$_SESSION['s_login']['id']);
			}
			//搜索中的商品类别
			require(BasePath."/cache/ProductClass_show.php");
			if (is_array($node_cache)){
				foreach ($node_cache as $k => $v){
					if ($v[4] == '0') {
						$v['id'] = $v[0];
						$v['name'] = $v[2];
						$SearchProductCateArray[] = $v;
					}
				}
			}
			/**
			 * 页面输出
			 */
			$this->output('app_list',$this->_menuAppList());
			$this->output('channel_id',$this->_input['id']);
			$this->output('search_cate',$SearchProductCateArray);
			$this->output('forward_url',urlencode($this->cur_url));
			$this->output('site_logo',$this->_configinfo['websit']['logo_url']);
			$this->showpage('channel_index');
		}else {
			$this->redirectPath("error",'../index.php',$this->_lang['langChannelIdNonlicet']);
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
		 * 实例化频道拖拽类
		 */
		if (!is_object($this->obj_channel_drag)){
			require_once("channel_drag.class.php");
			$this->obj_channel_drag = new ChannelDragClass();
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
			$obj_condition['cd_style'] = $this->_input['category'];
		}
		//颜色
		if($this->_input['color'] != ''){//color
			$obj_condition['cd_color'] = $this->_input['category'];
		}
		//类别 //默认图算第一个 (大背景，标题背景，尾部 12个)（头部， 6个）
		$this->_input['type'] = $this->_input['type']?$this->_input['type']:'1';
		if($this->_input['type'] == 2){//头部
			$obj_page->pagebarnum(5);
		}else{
			$obj_page->pagebarnum(11);
		}
		$obj_condition['cd_type'] = $this->_input['type'];
		$cd_array = $this->obj_channel_drag->listChannelDragPic($obj_condition,$obj_page);
		$page_list = $obj_page->show(6);
		@header('Content-type: text/xml');
		echo '<?xml version="1.0" encoding="'.$this->_configinfo['websit']['ncharset'].'"?><root><![CDATA[';
		if($this->_input['type'] == 2){
			echo '<ul class="imglist imgmax"><li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/templates/channel_drag/default/images/pic_nobgmax.gif" onclick="javascript:changeBackground(this, \'system\', 1);"/></a></li>';
		}else{
			echo '<ul class="imglist"><li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/templates/channel_drag/default/images/pic_nobg.gif" onclick="javascript:changeBackground(this, \'system\', 1);"/></a></li>';
		}
		if(is_array($cd_array)){
			foreach($cd_array as $k => $v){
				echo '<li><a href="javascript:void(0);" ><img src="'.$this->_configinfo['websit']['site_url'].'/'.$v['cd_pic'].'" onclick="javascript:changeBackground(this, \'system\');"/></a></li>';
			}
			if(!empty($cd_array)){
				echo '</ul><div class="floatpage"><div class="pages">'.$page_list.'</div></div>';
			}
		}
		echo "]]></root>";
		exit;
	}
	

	/**
	 * 恢复默认风格
	 *
	 * @param $channel_id 频道ID
	 * @return 返回bool类型的提示信息
	 */
	function _set_default(){
		$value_array = array();
		$value_array['channel_id'] = $this->_input['channel_id'];
		$value_array['channel_style'] = '';
		$this->obj_channel->updateChannel($value_array);
		@header('Location: channel.php?action=control&id='.$this->_input['channel_id']);
	}

	//===================================自定义模块内容=============================================




	

	/**
	 * 模块内容
	 *
	 * @param $this->shop 店铺内容
	 * @return 模板输出
	 */
	function _get_diy_style($style_id){
		
		//模块内容
		$block_list = array();
	$block_list['style_module'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockShopInfo']);
			$block_list['notice'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockNotice']);
/*		$block_list['link'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockLink']);
		$block_list['category'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockCategory']);
		$block_list['message'] =array('module_new_name'=> $this->_lang['langStoreStyleBlockMessage']);
		$block_list['product'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockProduct']);
		$block_list['recommend_product'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockRecommendProduct']);
		$block_list['product_search'] = array('module_new_name'=>$this->_lang['langStoreStyleBlockProductSearch']);*/
		$shop_array=$sd_array = $this->obj_shop_module_style->getOneStyle($style_id);
		//店铺风格
		if($shop_array['style_body'] != ''){
			$style_list = unserialize($shop_array['style_body']);
		}
		//print_r($style_list);die();
		//判断是否是现在使用的风格格式，如果不是，就用默认的样式载入
		if(empty($style_list) || $style_list['frame'] == ''){
			$default_all_frame = array();
			$i=0;
			foreach($block_list as $k => $v){
				if($i< count($block_list)/2){
					$default_all_frame['dleft'][] = $k;
				}else{
					$default_all_frame['dcontent'][] = $k;
				}
				$i++;
			}
			unset($i);
			$style_list = array(
				'frame' => 'LC', 	
				'allFrame' => $default_all_frame,
			);
		}
		//判断模板列数
		$control['wrap'] = strlen($style_list['frame']) === 3?'wrap':'wraptwo';
		//每列的内容
		for ($i=0;$i<strlen($style_list['frame']);$i++){
			switch (strtoupper($style_list['frame'][$i])){
				case 'L'://左边
					$control['allFrame']['dleft'] = $style_list['allFrame']['dleft'];
					break;
				case 'C'://中间
					$control['allFrame']['dcontent'] = $style_list['allFrame']['dcontent'];
					break;
				case 'R'://右边
					$control['allFrame']['dright'] = $style_list['allFrame']['dright'];
					break;
			}
		}
		//根据每列内容和样式表中存在的内容对比，判断哪些内容是要显示的，哪些是隐藏的
		if(!empty($block_list)){
			foreach($style_list['allFrame'] as $k2 =>$v2){
				if(is_array($v2)){
					foreach($v2 as $k3 => $v3){
						foreach($block_list as $k => $v){
							if($k == $v3){
								//显示的内容
								$block_list[$k]['show'] = '1';
							}
						}
					}
				}
			}
		}
		
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
	//	print_r($block_css);die();
		//模块 内容 判断 调用的小页面
		if(is_array($block_list)){
			foreach($block_list as $k => $v){
				switch($k){
					case 'style_module':
						$block_list[$k]['html'] = 'style_module.html';
						break;
						case 'notice':
						$block_list[$k]['html'] = 'style_module.html';
						break;
				}
			}
		}
	
		//风格输出
		$this->output('block_list',$block_list);
		$this->output('block_css',$block_css);
		$this->output('style_list',$style_list);
		$this->output('frame_length',strlen($style_list['frame']));
		$this->output('control',$control);
		$this->output('shop_style',strlen($shop_array['style_body'])<=2?serialize($style_list):$shop_array['style_body']);
		$this->showpage('style_control');
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

}
$showchannel = new ModuleStyle();
$showchannel->main();
unset($showchannel);
?>