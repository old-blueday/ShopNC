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
 * FILE_NAME : html.channel.php   FILE_PATH : E:\www\multishop\trunk\home\html.channel.php
 * ....生成静态 --- 首页 频道 
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Aug 27 15:02:44 CST 2008
 */
if ( !defined( "NC_GLOBAL_PATH" ) ) {
    define( "NC_GLOBAL_PATH", substr( dirname(__FILE__), 0, strrpos( dirname(__FILE__), "home" ) ) );
}
require ( NC_GLOBAL_PATH."global.inc.php" );

class HtmlChannelManage extends CommonFrameWork{
	/**
	 * 频道对象
	 *
	 * @var obj
	 */
	var $obj_channel;
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
	var $obj_page_channel;
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
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 商铺分类对象
	 *
	 * @var obj
	 */
	var $obj_shop_category;
	/**
	 * 多语言对象
	 *
	 * @var obj
	 */
	var $obj_language;
	/**
	 * 评价对象
	 *
	 * @var obj
	 */
	var $obj_score;
	/**
	 * 参数对象
	 *
	 * @var obj
	 */
	var $obj_settings;
	/**
	 * 帮助对象
	 *
	 * @var obj
	 */
	var $obj_help;
	
	/**
	 * php5构造函数
	 */
	function __construct(){
		$this->HtmlChannelManage();
	}
	
	/**
	 * php4构造函数
	 */
	function HtmlChannelManage(){
		/**
		 * 执行父类的构造函数
		 */
		parent::CommonFrameWork();
		/**
		 * 创建参数对象
		 */
		if (!is_object($this->obj_settings)){
			require_once ("settings.class.php");
			$this->obj_settings = new SettingsClass();
		}
		/**
		 * 创建频道对象
		 */
		if (!is_object($this->obj_channel)){
			require_once ("channel.class.php");
			$this->obj_channel = new ChannelClass();
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
		if (!is_object($this->obj_page_channel)){
			require_once("commonpage.class.php");
			$this->obj_page_channel = new CommonPage();
		}
		/**
		 * 创建评价对象
		 */
		if (!is_object($this->obj_score)){
			require_once("score.class.php");
			$this->obj_score = new ScoreClass();
		}
		/**
		 * 创建多语言对象
		 */
		if (!is_object($this->obj_language)){
			require_once("language.class.php");
			$this->obj_language = new LanguageClass();
		}
		/**
		 * 创建帮助对象
		 */
		if (!is_object($this->obj_help)){
			require_once("help.class.php");
			$this->obj_help = new Help();
		}
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");
		/**
		 * 语言包
		 */
		$this->getlang("channel,index_show");
	}
	
	/**
	 * 主方法
	 */
	function main(){
		switch($this->_input['action']){
			case "all_channel_html":
				$this->_all_channel_html();
				break;
			case "index_html":
				$this->_index_html();
				break;
			case "vote":
				$this->_vote_datecall();
				break;
		}
	}
	
	/**
	 * 生成全部频道静态
	 */
	function _all_channel_html(){
		$condition["state"] = "0";
		$channel_array = $this->obj_channel->listChannel($condition,$obj_page);
		if (is_array($channel_array)){
			foreach ($channel_array as $k => $v){
				//自定义模板频道
				if ($v['channel_type'] == '3') {
					$result = $this->_make_channel_html(intval($v['channel_id']));
					if ($result !== true){
						return $result;
					}					
				}
			}
		}
		return true;
	}
	
	/**
	 * 生成频道静态页面 $channel_id 频道ID
	 * 所有模板都是基于li标识的
	 */
	function _make_channel_html($channel_id=''){
		$channel_id = $channel_id?$channel_id:$this->_input['id'];
		if (intval($channel_id) <= 0){
			return $this->_lang['langChannelIdNonlicet'];
		}
		//取频道信息
		$channel_array = $this->obj_channel->getChannelById($channel_id);
		//频道页面需要加载的内容
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
		//取所有频道
		$condition["order_by"] = "channel_sort";
		$condition["state"] = "0";
		$condition["order_sort"] = "asc";
		$channel_all = $this->obj_channel->listChannel($condition,$page);
		unset($condition);

		//取模块参数配置文件
		if (file_exists(BasePath."/share/channelparam/".md5($channel_array['channel_name']).".php")){
			require_once(BasePath."/share/channelparam/".md5($channel_array['channel_name']).".php");
			//参数数组 $ChannelParamArray
			if (is_array($ChannelParamArray)){
				$module = array();//模块页面代码
				//取各模块的参数 $k 为模块名称 下划线前两个单词为模块类型
				foreach ($ChannelParamArray as $k => $v){
					/*判断模块类型*/
					$line = explode("_",$k);
					$module_name = $line[0].'_'.$line[1];
					switch ($module_name){
						//广告模块
						case "adv_module":
							//判断是否是flash广告，如果不是则调用JS文件，是则调用模块模板
							//创建广告对象
							if (!is_object($this->obj_adv)){
								require_once ("advertisement.class.php");
								$this->obj_adv = new AdvertisementClass();
							}
							$condition_adv['code'] = $v['code'];
							$condition_adv['start_date'] = time();
							$condition_adv['end_date'] = time();							
							$condition_adv['state'] = 0;
							$condition_adv['order_by'] = 'adv_sort asc';
							$adv_list = $this->obj_adv->listAdv($condition_adv,$page);
							if ($adv_list[0]['adv_type'] == 2){//如果是flash
								$module[$k] = $this->advFlashHtmlCode($v['code']);
							}else {//其他广告类型，调用的是JS文件
								//判断广告的JS文件是否存在
								if (file_exists(BasePath."/html/js/".$v['code'].'.js')){
									$module[$k] = "<script src='".$this->_configinfo['websit']['site_url'].'/html/js/'.$v['code'].'.js'."'></script>";
								}
							}
							$module_new_name[$k] = $v['module_new_name'];
							break;
						//投票模块
						case "vote_module":
							$module[$k] = $this->voteHtmlCode($v);
							$module_new_name[$k] = $v['module_new_name'];
							break;
						//商品模块
						case "product_module":
							$module[$k] = $this->productHtmlCode($v);
							$module_new_name[$k] = $v['module_new_name'];
							break;
						//商铺模块
						case "shop_module":
							$module[$k] = $this->shopHtmlCode($v);
							$module_new_name[$k] = $v['module_new_name'];
							break;
						//商品类别模块
						case "pclass_module":
							$module[$k] = $this->pclassHtmlCode($v);
							$module_new_name[$k] = $v['module_new_name'];
							break;
						//商铺类别模块
						case "shopclass_module":
							$module[$k] = $this->shopclassHtmlCode($v);
							$module_new_name[$k] = $v['module_new_name'];
							break;
					}
				}

				//关键词模板名称
				$keyword_html_name = BasePath.'/html/keyword/index.html';
				//重新设置模板路径和语言包
				$this->setsubtemplates("home/channel_tpl");
				
				//切模板名称
				$temp_name = substr($channel_array['channel_temp_name'],0,strlen($channel_array['channel_temp_name'])-5);
				/*对模板上的模块标识符进行替换*/
				$this->output("keyword_html_name",$keyword_html_name);
				$this->output("search_cate",$SearchProductCateArray);//搜索中的商品类别
				$this->output('channel_all',   $channel_all);   //导航菜单频道
				$this->output('channel_id',   $channel_id);   //频道该频道的ID
				$this->output('channel_sign' ,$channel_array['channel_name']);
				$default_code = $this->fetchpage($temp_name);//取输出到模板上的内容

				if (is_array($module)){
					foreach ($module as $k => $v){
						$templates_module_name = "";
						$line = "";
						$module_name_ex = explode("_",$k);
						$templates_module_name = $module_name_ex[0]."_".$module_name_ex[1]."_".$module_new_name[$k];
						$line = '<module>'.$templates_module_name.'</module>';
						$replacements = $v;
						$default_code = @str_replace($line,$replacements,$default_code);
					}
				}
				$this_my_file = preg_replace('/<module>.*?<\\/module>/is',"",$default_code);

				//写入文件
				//先判断文件夹是否存在，不存在则建立
				if (!is_dir(BasePath."/html/".$channel_array['channel_sign'])){
					$result = $this->_check_dir_exists($channel_array['channel_sign']);
					if ($result !== true){
						return $result;
					}else {
						unset($result);
					}
				}

				//判断频道状态，来确定将内容写入哪个文件
				if ($channel_array['channel_state'] == 1){/*关闭，写入 lock_index.html*/
					$file_name = BasePath."/html/".$channel_array['channel_sign']."/lock_index.html";
				}else {//开启，写入 index.html
					$file_name = BasePath."/html/".$channel_array['channel_sign']."/index.html";
				}

				//替换内容
				$patterns = array (
					'/js_statics_sign=1/is',
				);
				$replacements = array (
					'js_statics_sign=4',
				);
				$this_my_file = preg_replace($patterns,$replacements,$this_my_file);
				//引入静态类
				require_once("makehtml.class.php");
				//如果使用动态访问，则不生成静态页
				if ($this->_configinfo['websit']['channel_html'] == '0'){
					echo $this_my_file;exit;
				} else if (strstr($_SERVER['SCRIPT_URI'],'/channel.php')) {
					//频道的动态访问
					$html_url = $this->_configinfo['websit']['site_url']."/html/".$channel_array['channel_sign']."/";
					if (file_exists(BasePath."/html/".$channel_array['channel_sign']."/index.html")) {
						@header("Location: {$html_url}");
						exit;						
					} else {
						//生成频道静态
						if (MakeHtml::tohtmlfile($file_name, $this_my_file)) {
							echo $this->_lang['langChannelView'];
							exit;
						}
					}
				}
				if (MakeHtml::tohtmlfile($file_name, $this_my_file)){
					return true;
				}else {
					return $this->_lang['langChannelCreateLostFile'];
				}
			}else{
				return $this->_lang['langChannelCreateLostConfigFile'];				
			}
		}else {
			return $this->_lang['langChannelCreateLostConfigFile'];
		}
	}
	
	/**
	 * 广告FLASH页面代码
	 */
	function advFlashHtmlCode($code){
		//设置模板路径
		$this->setsubtemplates("home/channel/adv_module");
		//创建广告对象
		if (!is_object($this->obj_adv)){
			require_once ("advertisement.class.php");
			$this->obj_adv = new AdvertisementClass();
		}
		$condition_adv['code'] = $code;
		$condition_adv['state'] = '0';
		$condition_adv['order_by'] = 'adv_sort asc';
		$adv_list = $this->obj_adv->listAdv($condition_adv,$page);
		$this->output('adv_list',$adv_list);
		$result = $this->fetchpage("flash");//取输出到模板上的内容
		return $result;
	}
	
	/**
	 * 投票页面代码
	 */
	function voteHtmlCode($param_array){
		//设置模板路径
		$this->setsubtemplates("home/channel/vote_module");
		/**
		 * 创建投票对象
		 */
		if (!is_object($this->obj_vote)){
			require_once("vote.class.php");
			$this->obj_vote = new VoteClass();
		}
		//切割参数的ID值
		$id = explode('|',$param_array['select_id']);
		if (!empty($id)){
			/*取投票信息*/
			$vote_array = array();
			foreach ($id as $k => $v){
				$vote_array[] = $this->obj_vote->getOneVote(intval($v));
			}
			/*分割投票选项*/
			if (is_array($vote_array)){
				foreach ($vote_array as $k => $v){
					$line = explode('|',trim($vote_array[$k]['vote_content'],'|'));
					$i = 0;
					foreach ($line as $k2 => $v2){
						if ($k2%2 == 0) {
							$vote_array[$k]['content'][$i]['option'] = $v2;
						}else {
							$vote_array[$k]['content'][$i]['num'] = $v2;
							$i++;
						}
					}
					unset($line,$i);
				}
			}

			/*输出，接输出的内容*/
			$this->output('vote_array',$vote_array);
			$result = $this->fetchpage("vote");/*取输出到模板上的内容*/
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 商品模块页面代码
	 */
	function productHtmlCode($param_array){
		/*设置模板路径*/
		$this->setsubtemplates("home/channel/product_module");
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		//切割参数的ID值
		$id = explode('|',$param_array['p_id']);
		if (!empty($id)){
			//正序排序
			$sort = explode('|',$param_array['sort_value']);
			uasort($sort, array("Common","cmp"));
			//根据序号把商品进行排序
			if (is_array($sort)){
				$array = array();
				foreach ($sort as $k => $v){
					$array[] = $id[$k];
				}
				unset($id);
				$id = $array;
				unset($array);
			}
			
			//取商品信息
			foreach ($id as $k => $v){
				//取商品信息
				$condition = "";
				$product_row = "";
				$conditions['p_id'] = intval($v);

				$product_row = $this->obj_product->getProductList($conditions,$page);
				if ($product_row[0] != ""){
					//判断是否使用静态链接
					$product_row = $this->obj_product->checkProductIfHtml($product_row,$this->_configinfo['productinfo']['ifhtml']);
					if ($product_row[0]['html_url'] != ""){
						$product_row[0]['html_url'] = str_replace('..','',$product_row[0]['html_url']);
					}

					//根据参数中的字数设置，切商品名称
					$product_row[0]['p_short_name'] = Char_class::cut_str($product_row[0]['p_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
					$temp = explode('.',$product_row[0]['p_price']);
					$product_row[0]['p_price_int']   = $temp[0];
					$product_row[0]['p_price_floot'] = $temp[1];
					$product_array[] = $product_row[0];
				}
			}

			if (is_array($product_array)){
				foreach ($product_array as $k => $v){
					if (file_exists(BasePath.'/'.$product_array[$k]['small_pic']) && $product_array[$k]['small_pic'] != ''){
						list($product_array[$k]['img_width'],$product_array[$k]['img_height']) = getimagesize(BasePath.'/'.$product_array[$k]['small_pic']);
					}
				}
			}			
			
			//判断展现形式
			if ($param_array['show_type'] == '1'){
				//输出，接输出的内容
				$this->output('product_array',$product_array);
				$result = $this->fetchpage("product_pic");//图片
			}elseif ($param_array['show_type'] == '0') {
				//首页商品模块文字长度截取
				if ($param_array['name_num'] > 20){
					if (is_array($product_array)){
						foreach ($product_array as $k => $v){
							$product_array[$k]['p_short_name'] = Char_class::cut_str($product_array[$k]['p_name'],20,0,$this->_configinfo['websit']['ncharset'],'');
						}
					}
				}
				//输出，接输出的内容
				$this->output('product_array',$product_array);
				$result = $this->fetchpage("product");//文字
			}elseif ($param_array['show_type'] == '2') {
				//输出，接输出的内容
				$this->output('product_array',$product_array);
				$result = $this->fetchpage("pop_product");//商品排行
			}elseif ($param_array['show_type'] == '3'){
				$this->output('product_array',$product_array);
				$result = $this->fetchpage("product_commend_pic");//推荐商品
			}
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 商铺模块页面代码
	 */
	function shopHtmlCode($param_array){
		//设置模板路径
		$this->setsubtemplates("home/channel/shop_module");
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		//切割参数的ID值
		$id = explode('|',$param_array['shop_id']);
		if (!empty($id)){
			//正序排序
			$sort = explode('|',$param_array['sort_value']);
			uasort($sort, array("Common","cmp"));
			//根据序号把商品进行排序
			if (is_array($sort)){
				$array = array();
				foreach ($sort as $k => $v){
					$array[] = $id[$k];
				}
				unset($id);
				$id = $array;
				unset($array);
			}
			//取店铺信息
			foreach ($id as $k => $v){
				/**
				 * 评价数字统计
				 */

				//统计数组
				$sell_sta = array('vouch_good'=>0,'vouch_normal'=>0,'vouch_bad'=>0,'instant_good'=>0,'instant_normal'=>0,'instant_bad'=>0,'offline_good'=>0,'offline_normal'=>0,'offline_bad'=>0);
				//卖家
				$sel_condition['grade_member_id'] = $v;
				$sel_condition['genre'] = 's';
				$sell_score = $this->obj_score->getScore($sel_condition,$page);
				if (is_array($sell_score)){
					foreach ($sell_score as $k => $v){
						//评价等级
						if ($v['score'] == 1){//好评
							//支付方式类别
							if ($v['score_pay_type'] == 1){//担保型
								$sell_sta['vouch_good'] = ++$sell_sta['vouch_good'];
							}
							if ($v['score_pay_type'] == 2){//即时支付型
								$sell_sta['instant_good'] = ++$sell_sta['instant_good'];
							}
							if ($v['score_pay_type'] == 3){//线下交易型
								$sell_sta['offline_good'] = ++$sell_sta['offline_good'];
							}
						}
						if ($v['score'] == 0){//中评
							//支付方式类别
							if ($v['score_pay_type'] == 1){//担保型
								$sell_sta['vouch_normal'] = ++$sell_sta['vouch_good'];
							}
							if ($v['score_pay_type'] == 2){//即时支付型
								$sell_sta['instant_normal'] = ++$sell_sta['instant_good'];
							}
							if ($v['score_pay_type'] == 3){//线下交易型
								$sell_sta['offline_normal'] = ++$sell_sta['offline_good'];
							}
						}
						if ($v['score'] == '-1'){//坏评
							//支付方式类别
							if ($v['score_pay_type'] == 1){//担保型
								$sell_sta['vouch_bad'] = ++$sell_sta['vouch_good'];
							}
							if ($v['score_pay_type'] == 2){//即时支付型
								$sell_sta['instant_bad'] = ++$sell_sta['instant_good'];
							}
							if ($v['score_pay_type'] == 3){//线下交易型
								$sell_sta['offline_bad'] = ++$sell_sta['offline_good'];
							}
						}
					}
				}

				$buy_sta = array('vouch_good'=>0,'vouch_normal'=>0,'vouch_bad'=>0,'instant_good'=>0,'instant_normal'=>0,'instant_bad'=>0,'offline_good'=>0,'offline_normal'=>0,'offline_bad'=>0);
				//买家
				$buy_condition['grade_member_id'] = $v;
				$buy_condition['genre'] = 'b';
				$buy_score = $this->obj_score->getScore($buy_condition,$page);
				if (is_array($buy_score)){
					foreach ($buy_score as $k => $v){
						//评价等级
						if ($v['score'] == 1){//好评
							//支付方式类别
							if ($v['score_pay_type'] == 1){//担保型
								$buy_sta['vouch_good'] = ++$buy_sta['vouch_good'];
							}
							if ($v['score_pay_type'] == 2){//即时支付型
								$buy_sta['instant_good'] = ++$buy_sta['instant_good'];
							}
							if ($v['score_pay_type'] == 3){//线下交易型
								$buy_sta['offline_good'] = ++$buy_sta['offline_good'];
							}
						}
						if ($v['score'] == 0){//中评
							//支付方式类别
							if ($v['score_pay_type'] == 1){//担保型
								$buy_sta['vouch_normal'] = ++$buy_sta['vouch_good'];
							}
							if ($v['score_pay_type'] == 2){//即时支付型
								$buy_sta['instant_normal'] = ++$buy_sta['instant_good'];
							}
							if ($v['score_pay_type'] == 3){//线下交易型
								$buy_sta['offline_normal'] = ++$buy_sta['offline_good'];
							}
						}
						if ($v['score'] == '-1'){//坏评
							//支付方式类别
							if ($v['score_pay_type'] == 1){//担保型
								$buy_sta['vouch_bad'] = ++$buy_sta['vouch_good'];
							}
							if ($v['score_pay_type'] == 2){//即时支付型
								$buy_sta['instant_bad'] = ++$buy_sta['instant_good'];
							}
							if ($v['score_pay_type'] == 3){//线下交易型
								$buy_sta['offline_bad'] = ++$buy_sta['offline_good'];
							}
						}
					}
				}

				//统计好评率
				$sale_percent = array_sum($sell_sta)==0?'0':number_format(($sell_sta['vouch_good']+$sell_sta['instant_good']+$sell_sta['offline_good'])/array_sum($sell_sta),1)*100;
				$buy_percent = array_sum($buy_sta)==0?'0':number_format(($buy_sta['vouch_good']+$buy_sta['instant_good']+$buy_sta['offline_good'])/array_sum($buy_sta),1)*100;

				//取店铺信息
				$shop_row = $this->obj_shop->getOneShop($v,"0");
				if ($shop_row['ischeck'] == 1){//商铺审核标识
					$shop_row['shop_short_name'] = Char_class::cut_str($shop_row['shop_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
					$shop_row['sale_percent'] = $sale_percent;
					$shop_row['buy_percent'] = $buy_percent;
					$shop_row['sale_range'] = Char_class::cut_str($shop_row['sale_range'],6,0,$this->_configinfo['websit']['ncharset'],'');
					$shop_array[] = $shop_row;
				}
			}

			//输出，接输出的内容
			$this->output('shop_array',$shop_array);
			if ($param_array['show_type'] == '1'){//图片
				$result = $this->fetchpage("shop_pic");
			}else if ($param_array['show_type'] == '0') {
				$result = $this->fetchpage("shop");//文字
			}else if ($param_array['show_type'] == '2'){
				$result = $this->fetchpage("shop_new_pic");//新加入的店铺
			}
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 商品类别模块页面代码
	 */
	function pclassHtmlCode($param_array){
		//设置模板路径
		$this->setsubtemplates("home/channel/pclass_module");
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_product_class)){
			require_once ("productclass.class.php");
			$this->obj_product_class = new ProductCategoryClass();
		}
		//切割参数的ID值
		$id = explode('|',$param_array['check_id']);
		if (!empty($id)){
			//正序排序
			$sort = explode('|',$param_array['sort_value']);
			uasort($sort, array("Common","cmp"));
			//根据序号把商品进行排序
			if (is_array($sort)){
				$array = array();
				foreach ($sort as $k => $v){
					$array[] = $id[$k];
				}
				unset($id);
				$id = $array;
				unset($array);
			}
			//取商品类别信息
			if ($param_array['show_type'] == "0"){//前台展现样式 ： 层次
				foreach ($id as $k => $v){
					/*取商品类别*/
					$array = $this->obj_product_class->getPClassRow($v);
					if (is_array($array)){
						$array['pc_name'] = Char_class::cut_str($array['pc_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
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
									$v2['pc_name'] = Char_class::cut_str($v2['pc_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
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
			}else if ($param_array['show_type'] == "1"){//前台展现样式 ： 单一
				foreach ($id as $k => $v){
					//取商品类别
					$array = $this->obj_product_class->getPClassRow($v);
					if (is_array($array)){
						$array['pc_name'] = Char_class::cut_str($array['pc_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
						$pclass_array[] = $array;
					}
					unset($array);
				}
			}else {
				foreach ($id as $k => $v){
					//取商品类别
					$array = $this->obj_product_class->getPClassRow($v);
					if (is_array($array)){
						$array['pc_name'] = Char_class::cut_str($array['pc_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
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
									$v2['pc_name'] = Char_class::cut_str($v2['pc_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
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
			}
			//输出，接输出的内容
			$this->output('pclass_array',$pclass_array);
			$this->output('show_type',$param_array['show_type']);
			$result = $this->fetchpage("pclass");//取输出到模板上的内容
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 商铺类别模块页面代码
	 */
	function shopclassHtmlCode($param_array){
		//设置模板路径
		$this->setsubtemplates("home/channel/shopclass_module");
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_shop_category)){
			require_once("shopcategory.class.php");
			$this->obj_shop_category = new ShopCategoryClass();
		}
		//切割参数的ID值
		$id = explode('|',$param_array['check_id']);
		if (!empty($id)){
			//正序排序
			$sort = explode('|',$param_array['sort_value']);
			uasort($sort, array("Common","cmp"));
			//根据序号把商品进行排序
			if (is_array($sort)){
				$array = array();
				foreach ($sort as $k => $v){
					$array[] = $id[$k];
				}
				unset($id);
				$id = $array;
				unset($array);
			}

			//取商铺类别信息
			if ($param_array['show_type'] == "0" || $param_array['show_type'] == '2'){
				foreach ($id as $k => $v){
					$array = $this->obj_shop_category->getOneCategory($v);
					if (is_array($array)){
						$array['class_name'] = Char_class::cut_str($array['class_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
						if($array['class_name'] != ''){
							$shopclass_array[] = $array;
						}
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
			}else if ($param_array['show_type'] == "1"){
				foreach ($id as $k => $v){
					//取商铺类别
					$array = $this->obj_shop_category->getOneCategory($v);
					if (is_array($array)){
						$array['class_name'] = Char_class::cut_str($array['class_name'],$param_array['name_num'],0,$this->_configinfo['websit']['ncharset'],'');
						if($array['class_name'] != ''){
							$shopclass_array[] = $array;
						}
					}
					unset($array);
				}
			}

			//输出，接输出的内容
			$this->output('shopclass_array',$shopclass_array);
			$this->output('show_type',$param_array['show_type']);
			$result = $this->fetchpage("shopclass");//取输出到模板上的内容
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 判断文件夹是否存在
	 */
	function _check_dir_exists($dirname){
		if (is_dir("../html/".$dirname)){/*存在*/
			$report = "This dir (".$dirname.") is exists ,please change this dirname";
			return $report;
		}else {/*不存在*/
			require_once("fileoperate.class.php");
			FileOperate::WriteDirOrFile("../html/".$dirname,"dir");
			return true;
		}
	}
	
	/**
	 * 生成首页静态
	 */
	function _index_html(){
		//取多语言信息
		$language_array = $this->obj_language->listLanguage($obj_condition,$obj_page);
		//模板输出
		$this->output('sel_language',$language_array);
		if (is_array($language_array)){
			for ($i=0;$i<count($language_array);$i++){
				if (is_dir(BasePath.'/lang/'.$language_array[$i]['language_path']) && file_exists((BasePath.'/lang/'.$language_array[$i]['language_path'].'/common.php')) && file_exists((BasePath.'/lang/'.$language_array[$i]['language_path'].'/sys_common.php'))){
			
					if($this->obj_settings->getSettings('index_templates_type')==0){
						$result = $this->_make_language_htmls($language_array[$i]);
					}
					if($this->obj_settings->getSettings('index_templates_type')==1){
						$result = $this->_make_language_html($language_array[$i]);
					}
					if ($result !== true){
						return $result;
					}
				}
			}
		}
		return true;
	}
	/**
	 * 多语言静态首页
	 */
	function _make_language_htmls($language){
				$default_code =file_get_contents($this->_configinfo['websit']['site_url'].'/home/index_drag.php');
				if (is_array($module)){
					foreach ($module as $k => $v){
						$line = "";
						$line = '<module>'.$k.'</module>';
						$replacements = $v;
						$default_code = @str_replace($line,$replacements,$default_code);
					}
				}

				$this_my_file = @preg_replace('/<module>.*?<\\/module>/is',"",$default_code);

				require_once("makehtml.class.php");
				/*根目录下生成文件*/
				//判断是否是默认语言，如果是则用
				if ($language['language_state'] == '1'){
					if (file_exists('../index.html')){
						@unlink('../index.html');
					}
					$file_name = '../index.html';
				}else {
					if (file_exists('../index_'.$language['language_path'].'.html')){
						@unlink('../index_'.$language['language_path'].'.html');
					}
					$file_name = '../index_'.$language['language_path'].'.html';
				}

				$this_my_file = str_replace("../","",$this_my_file);
				$patterns = array (
				'/home\\/home\\/category.php/is',
				'/href=\\"category.php/is',
				'/home\\/home\\/member.php/is',
				'/href=\\"member.php/is',
				'/home\\/home\\/channel.php/is',
				'/href=\\"channel.php/is',
				'/home\\/home\\/shop.php/is',
				'/href=\\"shop.php/is',
				'/home\\/home\\/shop_brand.php/is',
				'/href=\\"shop_brand.php/is',
				'/home\\/home\\/vote.php/is',
				'/=\\"vote.php/is',
				"/\\('vote.php/is",
				'/home\\/home\\/product.php/is',
				'/href=\\"product.php/is',
				'/home\\/home\\/productmessage.php/is',
				'/href=\\"productmessage.php/is',
				'/switcher.swf/is',
				'/js_statics_sign=1/is',
				"/\\'shop.php/is",
				"/\\'product.php/is",
				);
				$replacements = array (
				'home/category.php',
				'href="home/category.php',
				'home/member.php',
				'href="home/member.php',
				'home/channel.php',
				'href="home/channel.php',
				'home/shop.php',
				'href="home/shop.php',
				'home/shop_brand.php',
				'href="home/shop_brand.php',
				'home/vote.php',
				'="home/vote.php',
				"('home/vote.php",
				'home/product.php',
				'href="home/product.php',
				'home/productmessage.php',
				'href="home/productmessage.php',
				'switcher_html.swf',
				'js_statics_sign=3',
				"'home/shop.php",
				"'home/product.php",
				);
				$this_my_file = preg_replace($patterns,$replacements,$this_my_file);
				//如果使用动态访问，则不生成静态页
				$commonlangType = $this->getCookies('commonlangType');
				$commonlangType = $commonlangType?$commonlangType:($language['language_state']==1?$language['language_path']:'');
				if ($this->_configinfo['websit']['index_html'] == '0' && $commonlangType == $language['language_path']){
					echo $this_my_file;exit;
				}
				
				if (!MakeHtml::tohtmlfile($file_name, $this_my_file)){
					return $this->_lang['langChannelIndexCreateLostFile'];
				}else {
					return true;
				}
	}
	/**
	 * 多语言静态首页
	 */
	function _make_language_html($language){
		//重新加载语言包
		unset($this->_lang);
		$this->_langType = $language['language_path'];
		$this->getlang("common");
		$this->getlang("index_show");
		$this->getlang("channel");
		//频道页面需要加载的内容
		//搜索中的商品类别
		if (!file_exists(BasePath."/cache/ProductClass_show.php")) {
			return $this->_lang['langChannelIndexTempDirWrong'];
		}
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
		/*取所有频道*/
		$condition["order_by"] = "channel_sort";
		$condition["state"] = "0";
		$condition["order_sort"] = "asc";
		$channel_all = $this->obj_channel->listChannel($condition,$page);
		unset($condition);

		//取模块参数配置文件 default
		$path = BasePath."/share/indexparam/";
		//模板参数
		$tpl_path = BasePath."/templates/".$this->_configinfo['websit']['templatesname'].'/home/index_tpl/';
		//判断改文件夹是否存在，如果不存在，则报错
		if (!is_dir($path)){
			return $this->_lang['langChannelIndexTempDirWrong'];
		}

		//通过LOCK标识，取模板文件名
		require_once("fileoperate.class.php");
		$file_array = FileOperate::listDir($tpl_path);
		//如果有LOCK后缀的文件，则表示文件名为模板当前使用名称
		if (is_array($file_array)){
			foreach ($file_array as $k => $v){
				if (strstr($v['name'],'.LOCK')){
					$template_name = substr($v['name'],0,strlen($v['name'])-5);
					if (!file_exists($tpl_path.$template_name)) {
						return $this->_lang['langChannelIndexHmtlTempIsNotExists'];
					}
					$template_name = substr($template_name,0,strlen($template_name)-5);
					break;
				}
			}
		}
		//判断是否为空，如果为空，则默认
		if($template_name == ''){
			if (file_exists($tpl_path.'index.html')){
				$template_name = 'index';
			}
			if (file_exists($tpl_path.'default.html')){
				$template_name = 'default';
			}
		}
		if (file_exists($path.$this->_configinfo['websit']['templatesname'].".php")){
			require($path.$this->_configinfo['websit']['templatesname'].".php");
			//参数数组 $ChannelParamArray
			if (is_array($ChannelParamArray)){
				$module = array();/*模块页面代码*/
				//取各模块的参数 $k 为模块名称 下划线前两个单词为模块类型
				foreach ($ChannelParamArray as $k => $v){
					//判断模块类型
					//$line = @explode("_",$k);
					//$module_name = $line[0].'_'.$line[1];
					switch ($v['module_type']){
						case "adv"://广告模块
						//判断是否是flash广告，如果不是则调用JS文件，是则调用模块模板
						//创建广告对象
						if (!is_object($this->obj_adv)){
							require_once ("advertisement.class.php");
							$this->obj_adv = new AdvertisementClass();
						}
						$condition_adv['code'] = $v['code'];
						$condition_adv['state'] = 0;
						$adv_list = $this->obj_adv->listAdv($condition_adv,$page);
						if ($adv_list[0]['adv_type'] == 2){//如果是flash
							$module[$v['module_new_name']] = $this->advFlashHtmlCode($v['code']);
						}else {//其他广告类型，调用的是JS文件
							//判断广告的JS文件是否存在
							if (file_exists(BasePath."/html/js/".$v['code'].'.js')){
								$module[$v['module_new_name']] = "<script src='".$this->_configinfo['websit']['site_url'].'/html/js/'.$v['code'].'.js'."'></script>";
							}else {
								return $this->_lang['langChannelAdvCreaLostPleaseAdvManageCreateFile'];
							}
						}
						break;
						case "vote"://投票模块
						$module[$v['module_new_name']] = $this->voteHtmlCode($v);
						break;
						case "product"://商品模块
						$module[$v['module_new_name']] = $this->productHtmlCode($v);
						break;
						case "shop"://商铺模块
						$module[$v['module_new_name']] = $this->shopHtmlCode($v);
						break;
						case "pclass"://商品类别模块
						$module[$v['module_new_name']] = $this->pclassHtmlCode($v);
						break;
						case "shopclass"://商铺类别模块
						$module[$v['module_new_name']] = $this->shopclassHtmlCode($v);
						break;
					}
				}
				//关键词模板名称
				$keyword_html_name = BasePath.'/html/keyword/index.html';
				/**
				 * 取得最新成交订单列表
				 */
				if (!is_object($this->obj_product_order)){
					require_once("order.class.php");
					$this->obj_product_order = new ProductOrderClass();
				}
				$obj_order_condition[order] = "1";
				$this->obj_page_channel->pagebarnum(10);
				$product_order_array = $this->obj_product_order->getProductOrderList($obj_order_condition, $this->obj_page);
				/**
				 * 取得使用帮助列表
				 */
				$this->obj_page_channel->pagebarnum(4);
				$condition['order_by'] = 'h_id';
				$help_array = $this->obj_help->listHelp($condition, $this->obj_page_channel);
				unset($condition);
				
				//重新设置模板路径和语言包
				$this->setsubtemplates("home/index_tpl");

				$obj_condition['sell_type'] = '2';
				$obj_condition['limit_num'] = 1;
				$page	= '';
				$group_product = $this->obj_product->getProductList($obj_condition,$page);
				$group_ext = $this->obj_product->getProductGroupRow($group_product[0]['p_code']);
				$group_product[0]['num'] = $group_ext['min_count'];
				$obj_condition['sell_type'] = '3';
				$obj_condition['limit_num'] = 2;
				$page	= '';
				$countdown_product = $this->obj_product->getProductList($obj_condition,$page);
				
				$obj_condition['sell_type'] = '0';
				$obj_condition['limit_num'] = 2;
				$page	= '';
				$auction_product = $this->obj_product->getProductList($obj_condition,$page);
				
				$this->output("group_product",$group_product[0]);
				$this->output("countdown_product",$countdown_product);
				$this->output("auction_product",$auction_product);
				
							
				/**
				 * 页面输出
				 */
				/*页头导航的样式判断*/
				$this->output('search_header_sign','1');
				//对模板上的模块标识符进行替换
				$this->output("config_index_html",$this->_configinfo['websit']['index_html']);
				$this->output("product_order_array",$product_order_array);
				$this->output("keyword_html_name",$keyword_html_name);
				$this->output("search_cate",$SearchProductCateArray);//搜索中的商品类别
				$this->output('channel_all',   $channel_all);   //导航菜单频道
				$this->output('language_array',   $language);   //该语言种类
				$this->output('help_array', $help_array);//帮助列表
				$this->output("sel_page", "index");
				$default_code = $this->fetchpage($template_name);//取输出到模板上的内容
				if (is_array($module)){
					foreach ($module as $k => $v){
						$line = "";
						$line = '<module>'.$k.'</module>';
						$replacements = $v;
						$default_code = @str_replace($line,$replacements,$default_code);
					}
				}

				$this_my_file = @preg_replace('/<module>.*?<\\/module>/is',"",$default_code);

				require_once("makehtml.class.php");
				/*根目录下生成文件*/
				//判断是否是默认语言，如果是则用
				if ($language['language_state'] == '1'){
					if (file_exists(NC_GLOBAL_PATH.'index.html')){
						@unlink(NC_GLOBAL_PATH.'index.html');
					}
					$file_name = NC_GLOBAL_PATH.'index.html';
				}else {
					if (file_exists(NC_GLOBAL_PATH.'index_'.$language['language_path'].'.html')){
						@unlink(NC_GLOBAL_PATH.'index_'.$language['language_path'].'.html');
					}
					$file_name = NC_GLOBAL_PATH.'index_'.$language['language_path'].'.html';
				}

				$this_my_file = str_replace("../","",$this_my_file);
				$patterns = array (
				'/home\\/home\\/category.php/is',
				'/href=\\"category.php/is',
				'/home\\/home\\/member.php/is',
				'/href=\\"member.php/is',
				'/home\\/home\\/channel.php/is',
				'/href=\\"channel.php/is',
				'/home\\/home\\/shop.php/is',
				'/href=\\"shop.php/is',
				'/home\\/home\\/shop_brand.php/is',
				'/href=\\"shop_brand.php/is',
				'/home\\/home\\/vote.php/is',
				'/=\\"vote.php/is',
				"/\\('vote.php/is",
				'/home\\/home\\/product.php/is',
				'/href=\\"product.php/is',
				'/home\\/home\\/productmessage.php/is',
				'/href=\\"productmessage.php/is',
				'/switcher.swf/is',
				'/js_statics_sign=1/is',
				"/\\'shop.php/is",
				"/\\'product.php/is",
				);
				$replacements = array (
				'home/category.php',
				'href="home/category.php',
				'home/member.php',
				'href="home/member.php',
				'home/channel.php',
				'href="home/channel.php',
				'home/shop.php',
				'href="home/shop.php',
				'home/shop_brand.php',
				'href="home/shop_brand.php',
				'home/vote.php',
				'="home/vote.php',
				"('home/vote.php",
				'home/product.php',
				'href="home/product.php',
				'home/productmessage.php',
				'href="home/productmessage.php',
				'switcher_html.swf',
				'js_statics_sign=3',
				"'home/shop.php",
				"'home/product.php",
				);
				$this_my_file = preg_replace($patterns,$replacements,$this_my_file);

				//如果使用动态访问，则不生成静态页
				$commonlangType = $this->getCookies('commonlangType');
				$commonlangType = $commonlangType?$commonlangType:($language['language_state']==1?$language['language_path']:'');
				if ($this->_configinfo['websit']['index_html'] == '0' && $commonlangType == $language['language_path']){
					echo $this_my_file;exit;
				}
				
				if (!MakeHtml::tohtmlfile($file_name, $this_my_file)){
					return $this->_lang['langChannelIndexCreateLostFile'];
				}else {
					return true;
				}
			}
		}else {
			return $this->_lang['langChannelIndexCreateLostParamFile'];
		}
	}
	
	/**
	 * 投票调用
	 */
	function _vote_datecall(){
		/**
		 * 创建投票对象
		 */
		if (!is_object($this->obj_vote)) {
			require_once('vote.class.php');
			$this->obj_vote = new VoteClass();
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($obj_page)) {
			require_once('commonpage.class.php');
			$obj_page = new CommonPage();
		}
		/**
		 * 取投票调查列表
		 */
		$condition['order'] = 'sort';
		$vote_list = $this->obj_vote->listVote($condition,$obj_page);
		/**
		 * 分割投票选项
		 */
		if (is_array($vote_list)) {
			foreach ($vote_list as $k => $v){
				$array = explode('|',trim($v['vote_content'],'|'));
				if (is_array($array)){
					$i = 0;
					foreach ($array as $k1 => $v1){
						if ($k1 % 2 == 0) {
							$vote_list[$k]['content'][$i]['option'] = $v1;
						}else {
							$vote_list[$k]['content'][$i]['num'] = $v1;
							$i++;
						}
					}
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output('vote_list',$vote_list);
	}
}
?>