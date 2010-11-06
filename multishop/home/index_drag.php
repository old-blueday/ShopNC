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

class ShowIndex extends ChannelFrameWork {
	/**
	 * 频道对象
	 *
	 * @var obj
	 */
	var $obj_channel;
	/**
	 * 频道拖拽对象
	 *
	 * @var obj
	 */
	var $obj_channel_drag;
	/**
	 * 广告对象
	 *
	 * @var obj
	 */
	var $obj_adv;
	/**
	 * 投票对象
	 *
	 * @var obj
	 */
	var $obj_vote;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 商品类别对象
	 *
	 * @var obj
	 */
	var $obj_product_class;
	/**
	 * 店铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 店铺类别对象
	 *
	 * @var obj
	 */
	var $obj_shop_class;
	/**
	 * 新闻对象
	 *
	 * @var obj
	 */
	var $obj_news;

	function main(){
		/**
		 * 创建频道对象
		 */
		if (!is_object($this->obj_channel)){
			require_once ("channel.class.php");
			$this->obj_channel = new ChannelClass();
		}
		//设置系统后台模板路径
		$this->setsubtemplates('channel_drag');
	//	print_r($this->_configinfo['websit']['templatesname']."/home/index_tpl/index_drag");die();
		
		/**
		 * 语言包
		 */
		$this->getlang("channel");
		$this->getlang("store_style");

		switch ($this->_input['action']){
			case 'control':
				$this->_checkSysMember();
				$this->_control();
				break;
			case 'save':
				$this->_checkSysMember();
				$this->_save();
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
		//添加标示不显示flash
		$this->output('flash',"1");
		/**
		 * 页面输出
		 */
		$this->showpage('index_control');
	}
	function _control_ajax(){
		
		//取频道风格和模块内容
		$this->_get_diy_style($this->_input['id']);
				//添加标示不显示flash
		$this->output('flash',"1");
		/**
		 * 页面输出
		 */
		 
		$this->showpage('channel_control_ajax');
	}

	/**
	 * 频道模板拖拽样式保存
	 *
	 * @param int $channel_id 频道ID
	 * @param int $diyStyle 频道样式内容
	 * @return 频道显示页面
	 */
	function _save(){
		if ($this->_input['getBack'] == '0'){//保存
			$value_array = array();
			$value_array['channel_id'] = $this->_input['channel_id'];
			$value_array['channel_style'] = $this->_input['diyStyle'];
			$this->obj_channel->updateChannel($value_array);

			$this->redirectPath("error",'channel.php?id='.$this->_input['channel_id'],$this->_lang['langChannelStyleSaveSucc']);
		}
		if ($this->_input['getBack'] == '1'){//恢复
			@header('Location: channel.php?action=control&id='.$this->_input['channel_id']);
		}
	}

	/**
	 * 频道展示
	 */
	function _show(){
		$this->setsubtemplates($this->_configinfo['websit']['templatesname']);
			$this->_get_diy_style();
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
			 //设置系统后台模板路径

		//	$this->output('template_dir',BasePath."/templates/".$this->_configinfo['websit']['templatesname']);
			$this->output('app_list',$this->_menuAppList());
			$this->output('channel_id',$this->_input['id']);
			$this->output('search_cate',$SearchProductCateArray);
			$this->output('forward_url',urlencode($this->cur_url));
			$this->output('site_logo',$this->_configinfo['websit']['logo_url']);
		//	$this->showpage('home/index_tpl/index_drag/channel_index');
		$this->showpage('index_test');
		
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
	 * 广告内容
	 * 
	 * @param $module_array 该模块的参数内容
	 * @param $module_array['code'] 广告调用代码
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_module_adv($module_array){
		/**
		 * 创建广告对象
		 */
		if (!is_object($this->obj_adv)){
			require_once ("advertisement.class.php");
			$this->obj_adv = new AdvertisementClass();
		}
		//先按照分组 取输出的广告类型
		$obj_condition['code'] = $module_array['code'];
		$obj_condition['group_by'] = 'adv_code';
		$adv_array = $this->obj_adv->listAdv($obj_condition,$obj_page);
		if(empty($adv_array)){
			return false;
		}
		unset($obj_condition);
		//输出类别
		$output_array['type'] = $adv_array[0]['adv_type'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		//广告内容
		$obj_condition['code'] = $module_array['code'];
		$output_array['list'] = $this->obj_adv->listAdv($obj_condition,$obj_page);
		return $output_array;
	}

	/**
	 * 投票内容
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['select_id'] 投票信息id数组
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_module_vote($module_array){
		/**
		 * 创建投票对象
		 */
		if (!is_object($this->obj_vote)){
			require_once("vote.class.php");
			$this->obj_vote = new VoteClass();
		}
		if(empty($module_array['select_id'])){
			return false;
		}else{
			foreach($module_array['select_id'] as $k => $v){
				$output_array['list'][] = $this->obj_vote->getOneVote($v);
			}
			if (is_array($output_array['list'])){
				foreach ($output_array['list'] as $k => $v){
					$line = explode('|',trim($output_array['list'][$k]['vote_content'],'|'));
					$i = 0;
					foreach ($line as $k2 => $v2){
						if ($k2%2 == 0) {
							$output_array['list'][$k]['content'][$i]['option'] = $v2;
						}else {
							$output_array['list'][$k]['content'][$i]['num'] = $v2;
							$i++;
						}
					}
					unset($line,$i);
				}
			}
			$output_array['module_new_name'] = $module_array['module_new_name'];
			return $output_array;
		}
	}

	/**
	 * 商品内容p_id
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['p_id'] 商品id
	 * @param array $module_array['sort_value'] 排序
	 * @param array $module_array['show_type'] 显示类型
	 * 
	 * @return 数组形式的返回内容 
	 */
	function _get_module_product($module_array){
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}

		$p_id_array = $module_array['p_id'];
		$sort_array = $module_array['sort_value'];

		for ($i=0;$i<count($sort_array);$i++)
		{
			for ($j=count($sort_array)-2;$j>=$i;$j--)
			{
				if($sort_array[$j+1]<$sort_array[$j])
				{
					$tmp = $sort_array[$j+1];
					$sort_array[$j+1]=$sort_array[$j];
					$sort_array[$j]=$tmp;
					
					//重新排序group数组
					$p_id_tmp = $p_id_array[$j+1];
					$p_id_array[$j+1]=$p_id_array[$j];
					$p_id_array[$j]=$p_id_tmp;
				}
			}
		}
		//显示类别
		$output_array['type'] = $module_array['show_type'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		//取商品内容
		if(empty($p_id_array)){
			return false;
		}else{
			foreach($p_id_array as $k => $v){
				$array = $this->obj_product->getProductRowById($v);
				//切割字数
				$array['p_short_name'] = Char_class::cut_str($array['p_name'],30,0,$this->_configinfo['websit']['ncharset']);
				$product_array[] = $array;
			}
			$output_array['list'] = $product_array;
			return $output_array;
		}
	}
	
	
	/**
	 * 新闻内容news_id
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['news_id'] 新闻id
	 * @param array $module_array['sort_value'] 排序
	 * @param array $module_array['show_type'] 显示类型
	 * 
	 * @return 数组形式的返回内容 
	 */
	function _get_module_news($module_array){
		/**
		 * 创建新闻对象
		 */
		if (!is_object($this->obj_news)){
			require_once("news.class.php");
			$this->obj_news = new NewsClass();
		}

		$news_id_array = $module_array['news_id'];
		$sort_array = $module_array['sort_value'];

		for ($i=0;$i<count($sort_array);$i++)
		{
			for ($j=count($sort_array)-2;$j>=$i;$j--)
			{
				if($sort_array[$j+1]<$sort_array[$j])
				{
					$tmp = $sort_array[$j+1];
					$sort_array[$j+1]=$sort_array[$j];
					$sort_array[$j]=$tmp;
					
					//重新排序group数组
					$p_id_tmp = $p_id_array[$j+1];
					$p_id_array[$j+1]=$p_id_array[$j];
					$p_id_array[$j]=$p_id_tmp;
				}
			}
		}
		//显示类别
		$output_array['type'] = $module_array['show_type'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		//取新闻内容
		if(empty($news_id_array)){
			return false;
		}else{
			foreach($news_id_array as $k => $v){
				$array = $this->obj_news->getNews($v);
				//切割字数
				$array['news_title'] = Char_class::cut_str($array['news_title'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset']);
				$news_array[] = $array;
			}
			
			$output_array['list'] = $news_array;
			return $output_array;
		}
	}
	
	
	
	
	
	
	
	

	/**
	 * 商品类别内容
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['check_id'] 类别id
	 * @param array $module_array['sort_value'] 排序
	 * @param array $module_array['show_type'] 显示类型
	 * @param array $module_array['name_num'] 显示类型
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_module_pclass($module_array){
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_product_class)){
			require_once ("productclass.class.php");
			$this->obj_product_class = new ProductCategoryClass();
		}
		if(empty($module_array['sort_value'])){
			return false;
		}
		//显示类别
		$output_array['type'] = $module_array['show_type'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		//输出内容
		uasort($module_array['sort_value'], array("Common","cmp"));
		//根据序号把商品类别进行排序
		if (is_array($module_array['sort_value'])){
			$pclass_id_array = array();
			foreach ($module_array['sort_value'] as $k => $v){
				$pclass_id_array[] = $module_array['check_id'][$k];
			}
		}
		//取商品类别信息
		if ($module_array['show_type'] == '0'){//前台展现样式 ： 层次
			foreach ($module_array['check_id'] as $k => $v){
				//取商品类别
				$array = $this->obj_product_class->getPClassRow($v);
				if (is_array($array)){
					$array['pc_name'] = Char_class::cut_str($array['pc_name'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
					$pclass_array[] = $array;
				}
				unset($array);
			}
			//将类别整理为树形结构
			if (is_array($pclass_array)){
				$level_array = array();//类别层次数组
				foreach ($pclass_array as $k => $v){
					if ($v['pc_u_id'] == 0){
						//取该类别下的类别信息
						foreach ($pclass_array as $k2 => $v2){
							if ($v2['pc_u_id'] == $v['pc_id']){
								$v2['pc_name'] = Char_class::cut_str($v2['pc_name'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
								$v['child_class'][] = $v2;
							}
						}
						$level_array[] = $v;
					}
				}
				unset($pclass_array);
				$pclass_array = $level_array;
				unset($level_array);
			}
		}else if ($module_array['show_type'] == '1'){//前台展现样式 ： 单一
			foreach ($module_array['check_id'] as $k => $v){
				//取商品类别
				$array = $this->obj_product_class->getPClassRow($v);
				if (is_array($array)){
					$array['pc_name'] = Char_class::cut_str($array['pc_name'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
					$pclass_array[] = $array;
				}
				unset($array);
			}
		}
		$output_array['list'] = $pclass_array;
		return $output_array;
	}

	/**
	 * 店铺内容
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['shop_id'] 类别id
	 * @param array $module_array['sort_value'] 排序
	 * @param array $module_array['show_type'] 显示类型
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_module_shop($module_array){
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		if(empty($module_array['sort_value'])){
			return false;
		}
		//显示类别
		$output_array['type'] = $module_array['show_type'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		//输出内容
		uasort($module_array['sort_value'], array("Common","cmp"));
		//根据序号把商品类别进行排序
		if (is_array($module_array['sort_value'])){
			$shop_id_array = array();
			foreach ($module_array['sort_value'] as $k => $v){
				$shop_id_array[] = $module_array['shop_id'][$k];
			}
			//取店铺信息
			foreach ($shop_id_array as $k => $v){
				//取店铺信息
				$shop_row = $this->obj_shop->getOneShop($v,'0');
				if ($shop_row['ischeck'] == 1){//商铺审核标识
					$shop_row['shop_short_name'] = Char_class::cut_str($shop_row['shop_name'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
					$shop_array[] = $shop_row;
				}
			}
		}
		$output_array['list'] = $shop_array;
		return $output_array;
	}

	/**
	 * 店铺分类内容
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['check_id'] 类别id
	 * @param array $module_array['sort_value'] 排序
	 * @param array $module_array['show_type'] 显示类型
	 * @param array $module_array['name_num'] 显示类型
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_module_shopclass($module_array){
		/**
		 * 创建店铺类别对象
		 */
		if (!is_object($this->obj_shop_class)){
			require_once("shopcategory.class.php");
			$this->obj_shop_class = new ShopCategoryClass();
		}
		if(empty($module_array['sort_value'])){
			return false;
		}
		//显示类别
		$output_array['type'] = $module_array['show_type'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		//输出内容
		uasort($module_array['sort_value'], array("Common","cmp"));
		//根据序号把商品类别进行排序
		if (is_array($module_array['sort_value'])){
			$shopclass_id_array = array();
			foreach ($module_array['sort_value'] as $k => $v){
				$shopclass_id_array[] = $module_array['check_id'][$k];
			}
			//取商铺类别信息
			if ($module_array['show_type'] == '0'){
				foreach ($shopclass_id_array as $k => $v){
					$array = $this->obj_shop_class->getOneCategory($v);
					if (is_array($array)){
						$array['class_name'] = Char_class::cut_str($array['class_name'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
						$shopclass_array[] = $array;
					}
					unset($array);
				}
				//整理树形结构的类别信息
				if (is_array($shopclass_array)){
					$level_array = array();
					foreach ($shopclass_array as $k => $v){
						//取商铺类别
						if ($v['parent_id'] == 0){
							foreach ($shopclass_array as $k2 => $v2){
								if ($v['class_id'] == $v2['parent_id']){
									$v['child_class'][] = $v2;
								}
							}
							$level_array[] = $v;
						}
					}
				}
				unset($shopclass_array);
				$shopclass_array = $level_array;
				unset($level_array);
			}else if ($module_array['show_type'] == "1"){
				foreach ($shopclass_id_array as $k => $v){
					//取商铺类别
					$array = $this->obj_shop_class->getOneCategory($v);
					if (is_array($array)){
						$array['class_name'] = Char_class::cut_str($array['class_name'],$module_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
						$shopclass_array[] = $array;
					}
					unset($array);
				}
			}
		}
		$output_array['list'] = $shopclass_array;
		return $output_array;
	}

	/**
	 * 店铺分类内容
	 *
	 * @param $module_array 该模块的参数内容
	 * @param array $module_array['module_content'] 输出内容
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_module_customize($module_array){
		$output_array['list'] = $module_array['module_content'];
		$output_array['module_new_name'] = $module_array['module_new_name'];
		return $output_array;
	}
	
	/**
	 * 获取频道自定义风格内容
	 *
	 * @param $channel_id 频道ID
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_diy_style(){
		//取频道信息
		$channel_array = $this->obj_channel->getChannelByType(2);
		
		if (empty($channel_array)){
			$data=array();
			$data["channel_name"]='index';
			$data["channel_type"]=2;
			$this->obj_channel->addChannel($data);
			$channel_array = $this->obj_channel->getChannelByType(2);
		}
		//页面布局样式，判断是否有风格内容，如果没有，调用默认
		if ($channel_array['channel_style'] !== ''){
			$style_list = unserialize($channel_array['channel_style']);
		}
		//解析频道模块内容
		if ($channel_array['channel_block'] != ''){
			$block_list = unserialize($channel_array['channel_block']);
		}

		//如果没有样式，则使用默认样式
		if(empty($style_list)){
			$default_all_frame = array();
			$i=0;
			if(!empty($block_list)){
				foreach($block_list as $k => $v){
					if($i< count($block_list)/2){
						$default_all_frame['dleft'][] = $v['temp_name'];
					}else{
						$default_all_frame['dcontent'][] = $v['temp_name'];
					}
					$i++;
				}
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

		//模块 内容 判断 调用的小页面
		if(is_array($block_list)){
			//print_r($block_list);exit;
			foreach($block_list as $k => $v){
				switch($v['module_type']){
					case 'adv':
						$block_list[$k]['html'] = '../channel_drag/channel_control_adv.html';
						break;
					case 'vote':
						$block_list[$k]['html'] = '../channel_drag/channel_control_vote.html';
						break;
					case 'product':
						$block_list[$k]['html'] = '../channel_drag/channel_control_product.html';
						break;
					case 'pclass':
						$block_list[$k]['html'] = '../channel_drag/channel_control_product_class.html';
						break;
					case 'shop':
						$block_list[$k]['html'] = '../channel_drag/channel_control_shop.html';
						break;
					case 'shopclass':
						$block_list[$k]['html'] = '../channel_drag/channel_control_shop_class.html';
						break;
					case 'customize':
						$block_list[$k]['html'] = '../channel_drag/channel_control_customize.html';
						break;
					case 'news':
						$block_list[$k]['html'] = '../channel_drag/channel_control_news.html';
						break;
				}
				//
				if($v['show'] == ''){
					$block_list[$k]['show'] = '0';
					$v['show'] = '0';
				}
				$fun = '_get_module_'.$v['module_type'];
				//取内容模板内容
				$block_output_html[$v['temp_name']] = $this->$fun($v);
			}
			//print_r($block_output_html);exit;
		}

		/**
		 * 页面输出
		 */
		// $topurl=BasePath."/templates/".$this->_configinfo['websit']['templatesname']."/top.html";
	//	print_r($block_list);die();
		
		$this->output('block_list',$block_list);
		$this->output('block_css',$block_css);
		$this->output('style_list',$style_list);
		$this->output('frame_length',strlen($style_list['frame']));
		$this->output('control',$control);
		$this->output('channel_style',$channel_array['channel_style']);
		$this->output('channel_id',$channel_array['channel_id']);
		$this->output('channel_name',$channel_array['channel_name']);
		$this->output('block_output_html',$block_output_html);
		$this->output('channel_all',$this->_get_channel_list());
	}

	/**
	 * 获取频道列表
	 *
	 * 
	 * 
	 * @return 数组形式的返回内容
	 */
	function _get_channel_list(){
		//取导航频道
		$condition_channel["order_by"] = "channel_sort";
		$condition_channel["state"] = "0";
		$condition_channel["order_sort"] = "asc";
		$channel_all = $this->obj_channel->listChannel($condition_channel,$page);
		unset($condition_channel);
		return $channel_all;
	}
}
$showIndex = new ShowIndex();
$showIndex->main();
unset($showIndex);
?>