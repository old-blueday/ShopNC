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
 * FILE_NAME : product.php   FILE_PATH : \multishop\home\product.php
 * ....商品展示功能
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Tue Aug 28 16:09:14 CST 2007
 */
require ("../global.inc.php");

class ShowProduct extends CommonFrameWork{
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	var $objProductCate;
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;
	/**
	 * 商品订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 拍卖商品出价对象
	 *
	 * @var obj
	 */
	var $obj_product_bid;
	/**
	 * 预存款对象对象
	 *
	 * @var obj
	 */
	var $obj_predeposit;
	/**
	 * 静态商品操作对象
	 *
	 * @var obj
	 */
	var $obj_html_product;
	/**
	 * 商品留言对象
	 *
	 * @var obj
	 */
	var $obj_product_message;
	/**
	 * 价格加价对象
	 *
	 * @var obj
	 */
	var $obj_up_price;
	/**
	 * 商品属性对象
	 *
	 * @var obj
	 */
	var $obj_product_attribute;
	/**
	 * 商品属性内容对象
	 *
	 * @var obj
	 */
	var $obj_product_attribute_content;
	/**
	 * 会员评价对象
	 *
	 * @var obj
	 */
	var $obj_member_score;
	/**
	 * 外汇对象
	 *
	 * @var obj
	 */
	var $obj_exchange;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	var $obj_product_brand;
	/**
	 * 商铺宝贝分类对象
	 *
	 * @var obj
	 */
	var $obj_category;

	function main(){
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化商品品牌类
		 */
		if (!is_object($this->obj_product_brand)){
			require_once("product_brand.class.php");
			$this->obj_product_brand = new ProductBrandClass();
		}

		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 语言包
		 */
		$this->getlang("product");

		switch ($this->_input['action']){
            case 'list_category':
                $this->_list_category();
                break;
			case 'sharing':
				$this->_sharing();
				break;
			case "valid_cer":
				$this->_valid_certification();
				break;
			case "list":
				$this->_listproduct();
				break;
			case "textlist":
				$this->_listproduct();
				break;
			case "view":
				$this->_viewproduct();
				break;
			case "search":
				$this->output('InfoSelectorTarget',Common::getTargetMenu("search"));
				$this->_searchproduct();
				break;
			case "compare":
				$this->_compareproduct();
				break;
			case "compareresult":
				$this->_compareproductresult();
				break;
			case "compare_remove":
				$this->_compareremove();
				break;
			case "clean_reviewed":
				$this->_cleanreviewedproduct();
				break;
			case "check_code":
				$this->_check_code();
				break;
			case 'recommend':
				$this->_recommend();
				break;
			case 'all':
				$this->_listproduct();
				break;
			case "setReview":
				$p_code = $this->_input['p_code'];
				$this->setReviewed($p_code);
				break;
			case "ajax_get_attribute":
				$this->_ajax_get_attribute();
				break;
			case "x_view":
				$this->_x_view();
				break;
			case 'get_view_member_list':
				$this->_getviewmember();
				break;
			default:
				$this->_listproduct();
				break;
		}
	}
    /**
     * 分类列表
     */
    function _list_category() {
        //初始化商品分类
        require_once 'productclass.class.php';
        $obj_productclass = new ProductCategoryClass();

        //父id
        $id = intval($this->_input['id']);

        $deep = 1;
		$ProductCateArray = $obj_productclass->listClassDetail('');
		$return_string = "";
		if(is_array($ProductCateArray)){
			foreach ($ProductCateArray as $value){
				if ($id == $value[1]) {
					$return_string .= $value['id']."||".trim($value['name'])."||".$value[5]."|||";
				}
			}
		}

		echo $return_string;
    }
	/**
	 * 整合X 查看
	 * $fid 版块ID
	 * $forum_list 版块列表
	 */
	function _x_view(){
		/**
		 * 整合X语言包
		 */
		if(DISCUZ_X === true){
			$this->getlang('own_product_x');
		}else{
			return false;
		}
		$pid = intval($this->_input['pid']);
		if($pid> 0){
			$product_array = $this->obj_product->getProductRowByXpid($pid);
			if(!empty($product_array)){
				@header('location: ../home/product.php?action=view&pid='.$product_array['p_code']);
				exit;
			}else{
				$this->redirectPath("error","../index.html",$this->_lang['errProductXPidProductIsEmpty']);
			}
		}else{
			$this->redirectPath("error","",$this->_lang['errProductXPidIsWrong']);
		}
	}

	/**
	 * 商品列表
	 *
	 */
	function _listproduct(){
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}

		//对搜索关键词转换编码
		if ($this->_input['keyword'] != "") {
			$this->_input['keyword'] = Common::unescape($this->_input['keyword'],$this->_configinfo['websit']['ncharset']);
		}
		
		//品牌内容的搜索
		if($this->_input['brand_name'] != ''){
			require_once('product_brand.class.php');
			$obj_brand = new ProductBrandClass();
			$condition_brand['pb_name'] = $this->_input['brand_name'];
			$brand_list = $obj_brand->getProductBrand($condition_brand,$page);
			if(!empty($brand_list)){
				foreach($brand_list as $k => $v){
					$obj_condition['in_pb_id'] = $v['pb_id'].',';
				}
				$obj_condition['in_pb_id'] = trim($obj_condition['in_pb_id'],',');
			}else {
				/**
				 * 不存在搜索的品牌内容
				 */
				$obj_condition['in_pb_id'] = '-1';
			}
		}

		/*商品列表选项卡*/
		if ($this->_input['action'] == 'all') {
			$url = 'product.php?action=all';//商品列表
		}else if ($this->_input['recommended'] == '1'){//橱窗推荐
			$obj_condition[recommended] = '1';
			$url = 'product.php?action=list';
		}else {
			$url = 'product.php?action=list';
		}
		//卖家会员名字
		if ($this->_input['shopname'] != ""){
			$condition_member['name'] = $this->_input['shopname'];
			$search_member = $this->obj_member->getMemberList($condition_member,$page);
			if (is_array($search_member)){
				if (count($search_member) > 1){
					foreach($search_member as $v){
						$obj_condition['shops'] .= $v['member_id'] . ",";
					}
					if (substr($obj_condition['shops'],strlen($obj_condition[shops])-1) == ","){
						$obj_condition[shops] = "(" . substr($obj_condition[shops],0,strlen($obj_condition[shops])-1) . ")";
					}
				}else {
					$this->_input['member'] = $search_member[0]['member_id'];
				}
			}
		}

		/**
		 * 取得查询参数
		 */
		if ($this->_input['lang'] == 'zh'){//分类频道中的关键字搜索
			$this->_input['searchtype'] = 1;
		}
		$obj_condition['key'] = $this->_input['keyword'];

		if("" != $this->_input['pcid']){
			$obj_condition['search_cate'] = $this->_input['pcid'];
			$this->_input['searchcate'] = $this->_input['pcid'];
		}else{
			$obj_condition['search_cate'] = $this->_input['searchcate'];
		}
		//品牌
		if(!empty($this->_input['pbid'])){
			$obj_condition['p_pb_id'] = $this->_input['pbid'];
		}
		$obj_condition['havetime'] = 1;
		if($this->_input['search_name'] != ""){//搜索栏中的搜索标识
			$this->_input['searchtype'] = 1;
		}
		$obj_condition['keygenre'] = $this->_input['searchtype'];
		$obj_condition['price_min'] = $this->_input['price_min'];
		$obj_condition['price_max'] = $this->_input['price_max'];
		$obj_condition['sell_type'] = $this->_input['sell_type'];

		/*判断channel_p_type二手闲置类别是否为空*/
		if ($this->_input['channel_p_type'] != ''){
			$obj_condition['p_type'] = $this->_input['channel_p_type'];
		}else {
			$obj_condition['p_type'] = $this->_input['p_type'];
		}
		$obj_condition['search_place'] = $this->_input['search_place'];
		//		$obj_condition['province'] = $this->_input['txtProvince'];
		//		$obj_condition['city'] = $this->_input['txtCity'];
		$obj_condition['tf_charge'] = $this->_input['tf_charge'];
		$obj_condition['type'] = $this->_input['type'];
		$obj_condition['end_time'] = $this->_input['end_time'];
		$obj_condition['member'] = $this->_input['member'];
		$obj_condition['p_area_id'] = $this->_input['p_area_id'];
		/**
		 * 分页数量设置
		 */
		$this->_input['pagelimit'] = $this->_input['pagelimit']?$this->_input['pagelimit']:20;
		$obj_condition['page'] = intval($this->_input['pagelimit']);
		/**
		 * 橱窗图片模式分页数量设置
		 */
		if ($this->_input['showpage'] == '2'){
			if($obj_condition['page'] == 80){
				$obj_condition['page'] = 84;
			}elseif($obj_condition['page'] == 40){
				$obj_condition['page'] = 42;
			}else{
				$obj_condition['page'] = 21;
			}
		}

		if ($this->_input['order'] == ''){
			$obj_condition['order'] = 1;
			$this->_input['order'] = 1;
		}else{
			$obj_condition['order'] = $this->_input['order'];
		}
		if ($this->_input['sorttype'] == ""){
			$obj_condition['sorttype'] = 1;
		}else{
			$obj_condition['sorttype'] = $this->_input['sorttype'];
		}


		/*搜索中的商品类别*/
		if (file_exists(BasePath."/cache/ProductClass_show.php")){
			include("../cache/ProductClass_show.php");
		}
		$ProductCateArray = $node_cache;
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
		 * 创建商品分类对象
		 */
		if (!is_object($this->objProductCate)){
			require_once ("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}
		//所选分类
		$select_class = $this->objProductCate->getPClassRow($this->_input['searchcate']);
		if (is_array($select_class)){
			$condition_class['parent_id'] = $select_class['pc_id'];
			$condition_class['order'] = '1';
			$select_class_child = $this->objProductCate->getProductClass($condition_class);
			if (!empty($select_class['pc_brand_id'])) {
				$pc_brand_id = unserialize($select_class['pc_brand_id']);
				if (is_array($pc_brand_id)) {
					foreach ($pc_brand_id as $val){
						if (!empty($val)) {
							$brand_array[] = $this->obj_product_brand->getProductBrandRow(intval($val));
						}
					}
				}
			}
		}else {
			$condition['pb_u_id'] = '0';
			$brand_array = $this->obj_product_brand->getProductBrand($condition,$obj_page);
		}
		//获取商品品牌
		if (!empty($this->_input['pbid'])) {
			$condition['pb_u_id'] = $this->_input['pbid'];
			$select_brand = $this->obj_product_brand->getProductBrandRow($this->_input['pbid']);
			$brand_array = $this->obj_product_brand->getProductBrand($condition,$obj_page);
		}
		//整理商品品牌，分离所有存在图片的品牌
		if (!empty($brand_array)) {
			foreach ($brand_array as $v1) {
				if (!empty($v1['pb_image'])) {
					$brand_img_array[] = $v1;
				}else {
					$brand_word_array[] = $v1;
				}
			}
			$brand_num = count($brand_array);
			unset($brand_array);
		}
		/**
		 * 实例化商品订单类
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}

		/**
		 * 更新到期团购商品订单状态
		 */
		//$group_product_order_tobe_end_array = $this->obj_product_order->updateProductOrderInCondition();

		/**
		 * 更新到期商品状态
		 */
		//$product_tobe_end_array = $this->obj_product->updateProductInCondition();

		/**
		 * 取得商品列表,店主信息
		 */
		$this->obj_page->pagebarnum($obj_condition[page]);
		$this->obj_page->pagesize = 5;
		$product_array = $this->obj_product->getProductList($obj_condition, $this->obj_page,'member');
		//截字数量
		$char_num = 26;
		for($i=0;$i<count($product_array);$i++){
			$left_time = $product_array[$i]['p_end_time'] - time();
			$product_array[$i]['left_days'] = intval($left_time / (24*60*60));
			$product_array[$i]['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
			$product_array[$i]['left_minutes'] = intval((($left_time % (60*60))) / 60);
			$product_array[$i]['p_short_name'] = Char_class::cut_str($product_array[$i]['p_name'],$char_num,0,$this->_configinfo['websit']['ncharset']);
		}
		//判断商品是否存在图片
		$product_array = $this->obj_product->productPicRatio($product_array,'p_pic',96);
		//判断是否使用静态链接
		//$product_array = $this->obj_product->checkProductIfHtml($product_array,$this->_configinfo['productinfo']['ifhtml']);
		//价格分割，288*288图片路径存入数组
		if (is_array($product_array)){
			foreach ($product_array as $k => $v){
				//价格分割
				if($product_array[$k]['p_sell_type'] == '2'){//团购 使用团购价
					$temp = explode('.',$product_array[$k]['p_group_price']);
				}else {
					$temp = explode('.',$product_array[$k]['p_price']);
				}
				$product_array[$k]['p_price_int']   = $temp[0];
				$product_array[$k]['p_price_floot'] = $temp[1];
				//图片路径
				$temp_img = explode('.',$product_array[$k]['p_pic']);
				$product_array[$k]['big_pic'] = $temp_img[0].'_big.'.$temp_img[1];
				//图片属性
				$image_info = @getimagesize('../'.$product_array[$k]['big_pic']);
				$product_array[$k]['img_height'] = $image_info[1];
				$product_array[$k]['img_width']  = $image_info[0];
			}
		}
		//分页样式
		$this->obj_page->new_style = true;
		switch ($this->_configinfo['websit']['templatesname']){
			case 'default':
				$page_list = $this->obj_page->show(6);
				$page_list2 = $this->obj_page->show(7);
				break;
			case 'orange':
				$this->obj_page->orange_style = true;
				$page_list = $this->obj_page->show(8);
				$page_list2 = $this->obj_page->show(9);
				break;
			case 'green':
				$this->obj_page->green_style = true;
				$page_list = $this->obj_page->show(10);
				$page_list2 = $this->obj_page->show(11);
				break;
		}

		//浏览过的宝贝
		$this->_reviewedproduct();

		//根据列表方式选择模板
		switch ($this->_input['showpage']){
			case "1":
				$page = "product.list";
				break;
			case "2":
				$page = "product.list2";
				break;
			case "3":
				$page = "product.list";
				break;
			default:
				$page = "product.list";
				break;
		}
		/**
		 * 取分类频道中页头的类别
		 */
		if (is_array($array)){
			/**
			 * 商品分类
			 */
			require_once("productclass.class.php");
			$obj_search_cate = new ProductCategoryClass();
			$product_class = $obj_search_cate->listClassDetail();
			foreach ($array as $v){
				$param = array();
				if(is_array($product_class)){
					foreach ($product_class as $k => $v2){
						if ($v2[0] == $v){
							$v2['pc_id'] = $v2[0];
							$v2['pc_name'] = trim($v2['name'],'&nbsp;');
							$param = $v2;
							break;
						}
					}
				}
				$newarr = array();
				$i =0;
				if(is_array($product_class)){
					foreach ($product_class as $k2 => $v3){
						if ($v3[1] == $v && $i<6){
							$v3['pc_id'] = $v3[0];
							$v3['pc_name'] = trim($v3[name],'&nbsp;');
							$newarr[] = $v3;
							$i++;
						}

					}
				}
				$param['class_array'] = $newarr;
				$class_array[] = $param;
			}
			unset($obj_search_cate);
		}
		//地区内容
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				//取当前搜索的地区内容
				if ($this->_input['p_area_id'] != '' && $v[0] == $this->_input['p_area_id']){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$sel_area = $v;
				}
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);

		//地区
		if (!empty($product_array)){
			/**
			 * 创建地区对象
			 */
			if (!is_object($this->obj_area)){
				require_once ("area.class.php");
				$this->obj_area = new AreaClass();
			}
			foreach ($product_array as $k => $v){
				if ($v['p_area_id'] != ''){
					$tmp = $this->obj_area->getAreaPathList($v['p_area_id']);
					$product_array[$k]['area_name'] = $tmp[0]['area_name'];
					unset($tmp);
				}
			}
		}
		/**
		 * 输出到页面模板
		 */
		$this->getlang("product_list");
		if ($select_class['pc_name'] != ''){
			$this->output('title_message',$select_class['pc_name'].'-');//title
			$this->output('keyword_message', '-'.$select_class['pc_name']);//keyword
			$this->output('desc_message', '-'.$select_class['pc_name']);//desc
		}
		$this->output('select_class',$select_class);
		$this->output('select_brand',$select_brand);
		$this->output('select_class_child',$select_class_child);
		$this->output('class_array',$class_array);
		$this->output('site_url', $this->_configinfo['websit']['site_url']);
		$this->output('page_list', $page_list);
		$this->output('page_list2', $page_list2);
		$this->output('channel_p_type', $this->_input['channel_p_type']);
		$this->output('count_all_product_class',$count_all_product_class);//所有分类个数
		$this->output('search_cate', $SearchProductCateArray);
		$this->output('category_array',$search_cate);//分类列表
		$this->output('product_array', $product_array);//商品列表
		$this->output('brand_img_array', $brand_img_array);//包含图片的品牌
		$this->output('brand_word_array', $brand_word_array);//不包含图片的品牌
		$this->output('brand_num', $brand_num);//品牌数量
		$this->_input['sorttype'] = intval(1-$this->_input['sorttype']);
		$this->output('product_condition',$this->_input);
		$this->output('product_left_class',$product_left_class);
		$this->output('area_array',$area_array);
		$this->output('sel_area',$sel_area);
		$this->showpage($page);
	}
	/**
     * 将商品推送到UCHOME分享
     */
	function _sharing() {
		if(empty($this->_input['pid'])) {
			exit;
		}
		if(empty($_SESSION['s_login'])) {
			exit($this->_lang['errCMemberNoLogin']);
		}

		$pid = $this->_input['pid'];
		$product_array = $this->obj_product->getProductRow($pid);

		//如果商品不存在
		if(empty($product_array)) {
			exit($this->_lang['langSharingErr']);
		}
		//创建UC对象
		require_once 'ucenter.class.php';
		$obj_uc = new ucenterClass();

		//发布分享
		$share_data = array();
		$pic_url = empty($product_array['p_pic']) ? 'templates/'.$this->_configinfo['websit']['templatesname'].'/images/noimgs.gif' : $product_array['p_pic'];
		$share_data['pic'] = '<a href="'.$this->_configinfo['websit']['site_url'].'/home/product.php?action=view&pid='.$product_array['p_code'].'"><img src="'.$this->_configinfo['websit']['site_url'].'/'.$pic_url.'" width="330" height="200"/></a>';

		$sharing_rs = $obj_uc->nc_sharing($_SESSION['s_login']['id'],$_SESSION['s_login']['name'],'pic',$this->_lang['langSharingProductAdded'],'{pic}',serialize($share_data),$product_array['p_name'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->_lang['langSharingProductClickPicView']);

		if($sharing_rs) {
			echo 1;
		} else {
			echo 0;
		}
	}
	/**
     * 分享给好友
     */
	function _recommend() {
		require_once 'selectfriend.class.php';
		$obj_select = new SelectFriend();
		$obj_select->setAttr('width',100);
		$obj_select->create(array('ddddd'));
	}

	/**
	 * 商品查看页面
	 *
	 */
	function _viewproduct(){
		//检测
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["pid"],"require"=>"true","message"=>$this->_lang['errProductId']));
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath ( "error", "", $error );
		}else{
			$p_id = $this->_input['pid'];
			/**
			 * 取得商品信息
			 */
			$product_row = $this->obj_product->getProductRow($p_id);
			
			if($this->_input['sp_html'] != '1'){
				/**
				 * 对于商品的不同出售类别进行判断，
				 */
				switch($product_row['p_sell_type']){
					/**
					 * 竞拍
					 */
					case '0':
						@header('Location: '.$this->_configinfo['websit']['site_url'].'/home/product_auction.php?action=view&p_code='.$product_row['p_code']);
						exit;
						break;
					/**
					 * 一口价
					 */
					case '1':
						@header('Location: '.$this->_configinfo['websit']['site_url'].'/home/product_fixprice.php?action=view&p_code='.$product_row['p_code']);
						exit;
						break;
					/**
					 * 团购
					 */
					case '2':
						@header('Location: '.$this->_configinfo['websit']['site_url'].'/home/product_group.php?action=view&p_code='.$product_row['p_code']);
						exit;
						break;
					/**
					 * 一元拍
					 */
					case '3':
						@header('Location: '.$this->_configinfo['websit']['site_url'].'/home/product_countdown.php?action=view&pid='.$product_row['p_code']);
						exit;
						break;
				}
			}
			


			//判断是否开启了静态功能，如果开启了，自动转到静态页面链接,sp_html为取订单快照，如果有值，则需要访问动态商品页面
			if ($this->_configinfo['productinfo']['ifhtml'] == 1 && $this->_input['sp_html'] == ''){//开启的
				$this->make_product_html($p_id);
				$product_row = $this->obj_product->checkOneProductIfHtml($product_row,$this->_configinfo['productinfo']['ifhtml']);
				//如果没有静态页面则生成，并且跳转
				$go_url = $product_row['html_url'];
				@header('location: '.$go_url);exit;
			}
			/**
			 * 创建商品分类对象
			 */
			if (!is_object($this->objProductCate)){
				require_once ("productclass.class.php");
				$this->objProductCate = new ProductCategoryClass();
			}
			/**
			 * 取得商品属性
			 */
			if (!is_object($this->obj_product_attribute)){
				require_once("attribute.class.php");
				$this->obj_product_attribute = new AttributeClass();
			}
			/**
			 * 创建会员评价对象
			 */
			if (!is_object($this->obj_member_score)){
				require_once("score.class.php");
				$this->obj_member_score = new ScoreClass();
			}
			/**
			 * 创建商铺对象
			 */
			if (!is_object($this->obj_shop)){
				require_once("shop.class.php");
				$this->obj_shop = new ShopClass();
			}
			/**
			 * 创建汇率对象
			 */
			if (!is_object($this->obj_exchange)){
				require_once("exchange.class.php");
				$this->obj_exchange = new ExchangeClass();
			}
			/**
			 * 创建商品留言对象
			 */
			if (!is_object($this->obj_product_message)){
				require_once("productmessage.class.php");
				$this->obj_product_message = new ProductMessageClass();
			}
			/**
			 * 语言包
			 */
			$this->getlang("productview");

			//图片列表
			$condition_pic['p_code'] = $p_id;
			$array = $this->obj_product->getProductPic($condition_pic,$page);
			if (is_array($array)){
				$pic_array = array();
				$j=0;
				for ($i=0;$i<count($array);$i++){
					if (file_exists(BasePath.'/'.$array[$i]['p_pic'])){
						$pic_array[$j]['p_pic'] = $array[$i]['p_pic'];
						$resize_pic = Common::resizePic($array[$i]['p_pic'],'96');
						$pic_array[$j]['resize_width'] = $resize_pic['width'];
						$pic_array[$j]['resize_height'] = $resize_pic['height'];
						$temp = @explode('.',$array[$i]['p_pic']);
						$pic_array[$j]['big_pic'] = $temp[0].'_big.'.$temp[1];
						$pic_array[$j]['mid_pic'] = $temp[0].'_mid.'.$temp[1];
						$pic_array[$j]['small_pic'] = $temp[0].'_small.'.$temp[1];
						$j++;
						unset($resize_pic,$temp);
					}
				}
			}
			unset($array);
			/**
			 * 取得商品分类树
			 */
			$ProductClassArray = $this->objProductCate->listClassDetail();
			if(!is_array($ProductClassArray)){
				$ProductClassArray = array();
			}
			$cate_path = $this->objProductCate->get_path($ProductClassArray, $product_row['pc_id']);
			/**
			 * 取得商品属性
			 */
			$condition_attribute['pc_id'] = $product_row['pc_id'];
			$product_attribute = $this->obj_product_attribute->getAttributeList($condition_attribute,$page);
			unset($condition_attribute);
			if(count($product_attribute)>0){
				$have_attribute = 1;
				$condition_attribut_content['pc_id'] = $product_row['pc_id'];
				$product_attribute_content = $this->obj_product_attribute->getAttributeWithContentList($condition_attribut_content,$page);
				unset($condition_attribut_content);
			}
			$attribute_condition_str = " and p_id = '" . $p_id . "'";
			$product_have_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $this->obj_page);

			$i=0;
			if(is_array($product_have_attribute)){
				foreach ($product_have_attribute as $key => $value){
					$ac_content = explode(',', $value[pac_content]);
					foreach ($ac_content as $k => $v){
						$pac_attribute[$i] = $v;
						$i++;
					}
				}
			}
			if(is_array($product_attribute_content)){
				foreach ($product_attribute_content as $key => $value){
					foreach ($value as $k => $v){
						if(is_array($pac_attribute) && in_array($v[ac_id], $pac_attribute)){
							$product_attribute_content[$key][$k][ischecked] = 1;
						}
					}
				}
			}

			/**
			 * 取得出价记录
			 */
			//取得卖家资料
			$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'*','more');
			$seller_info['regist_time'] = date("Y-m-d",$seller_info['regist_time']);
			$seller_info['sms_name']	= urlencode($seller_info['login_name']);

			//得到卖家好评率
			$seller_info['s_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"s");
			$seller_info['b_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"b");
			//买卖家信用
			$buy_score = $this->obj_member->creditLevel($seller_info['buy_score']);
			$sale_score = $this->obj_member->creditLevel($seller_info['sale_score']);

			//店铺资料
			$shop_info = $this->obj_shop->getOneShopByMemeberId($seller_info['member_id'],'1');

			//剩余时间计算
			$left_time = $product_row['p_end_time'] - time();
			if ($left_time > 0){
				$product_row['left_days'] = intval($left_time / (24*60*60));
				$product_row['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
				$product_row['left_minutes'] = intval((($left_time % (60*60))) / 60);
				$text_left_time = $product_row['left_days'].$this->_lang['langPday'].$product_row['left_hours'].$this->_lang['langPhour'].$product_row['left_minutes'].$this->_lang['langPminute'];
			}else {
				$text_left_time = '0';
			}
			if("2" == $product_row['p_sell_type']){//交易类型：团购
				$product_row['less_count'] = $product_row['p_group_mincount'] - $product_row['p_sold_num'];
				if ($product_row['less_count'] <= 0){
					$product_row['less_count'] = $this->_lang['langProductGroupOk'];
				}
			}
			/**
			 * 判断是否开始
			 */
			if ($product_row['p_start_time'] > time()) {
				$text_left_time = $this->_lang['langPNotBagin'];
			}
			//取商品支付方式和支持货币种类，用于隐藏域使用
			if (is_array($this->_configinfo['payment'])){
				$i=0;
				foreach ($this->_configinfo['payment'] as $k => $v){
					if ($v == 1){
						//判断该商品的支付方式
						if (strstr($product_row['p_pay_method'],'|'.$k.'|')){
							$payment_array[$k]['name']	= $this->_b_config['payment'][$k];
							if ($i == '0'){
								$payment_array[$k]['check'] = 1;
							}
							$i++;
						}
					}
				}
			}
			//取支持的货币种类
			if (strstr($product_row['p_currency_category'],'|')){
				$currency = explode('|',trim($product_row['p_currency_category'],'|'));
			}else {
				$currency = array($product_row['p_currency_category']);
			}
			//商品价格通过汇率进行换算
			$condition = '';
			$condition['state'] = 1;
			$exchange_array = $this->obj_exchange->listExchange($condition,$page);
			//判断出售商品的价格，团购和其他的不同
			if ($product_row['p_sell_type'] == '2'){//团购
				$price = $product_row['p_group_price'];
			}else {
				$price = $product_row['p_price'];
			}
			if (is_array($exchange_array)){
				foreach ($currency as $k => $v){
					foreach ($exchange_array as $k2 => $v2){
						if ($v2['exchange_name'] == $v){
							$currency_array[$v] = $v2['exchange_rate']==0?'0':(number_format($price*100/$v2['exchange_rate'],2)<=0.01?'0.01':number_format($price*100/$v2['exchange_rate'],2));
						}
					}
				}
			}
			//去货币对应中文名称的数组
			$exchange_remark = $this->obj_exchange->getExchangeArray();

			//商品留言信息
			$message_array = $this->obj_product_message->getMessage($page,$product_row['p_id']);
			if (is_array($message_array)){
				foreach ($message_array as $k => $v){
					$message_array[$k]['message_time'] = @date("Y-m-d H:i",$v['message_time']);
				}
			}
			//交易类型
			$product_row['p_type_name'] = $this->_b_config['p_type'][$product_row['p_type']];
			/**
			 * 取商品所属子分类
			 */
			$product_class[0] = $this->objProductCate->getPcateRow($product_row['pc_id']);
			if ($product_class[0][1] == 0){	//1级分类
				$product_row['pc_onelevel_name'] = $product_class[0]['name'];
				$product_row['pc_onelevel_id']   = $product_class[0][0];
				$class_level = 1;
			}else {
				$product_class[1] = $this->objProductCate->getPcateRow($product_class[0][1]);
				if ($product_class[1][1] == 0){  //2级分类
					$product_row['pc_onelevel_name'] = $product_class[1]['name'];
					$product_row['pc_onelevel_id']   = $product_class[1][0];
					$temp = explode('nbsp;',$product_class[0]['name']);
					$product_row['pc_twolevel_name'] = $temp[count($temp)-1];
					$product_row['pc_twolevel_id']   = $product_class[0][0];
					$class_level = 2;
				}else {
					$product_class[2] = $this->objProductCate->getPcateRow($product_class[1][1]);
					if ($product_class[2][1] == 0){  //3级分类
						$product_row['pc_onelevel_name'] = $product_class[2]['name'];
						$product_row['pc_onelevel_id']   = $product_class[2][0];
						$temp1 = explode('nbsp;',$product_class[1]['name']);
						$product_row['pc_twolevel_name'] = $temp1[count($temp1)-1];
						$product_row['pc_twolevel_id']   = $product_class[1][0];
						$temp = explode('nbsp;',$product_class[0]['name']);
						$product_row['pc_threelevel_name'] = $temp[count($temp)-1];
						$product_row['pc_threelevel_id']   = $product_class[0][0];
						$class_level = 3;
					}else {
						$product_class[3] = $this->objProductCate->getPcateRow($product_class[2][1]);
						if ($product_class[3][1] == 0){  //4级分类
							$product_row['pc_onelevel_name'] = $product_class[3]['name'];
							$product_row['pc_onelevel_id']   = $product_class[3][0];
							$temp2 = explode('nbsp;',$product_class[2]['name']);
							$product_row['pc_twolevel_name'] = $temp1[count($temp2)-1];
							$product_row['pc_twolevel_id']   = $product_class[2][0];
							$temp1 = explode('nbsp;',$product_class[1]['name']);
							$product_row['pc_threelevel_name'] = $temp[count($temp1)-1];
							$product_row['pc_threelevel_id']   = $product_class[1][0];
							$temp = explode('nbsp;',$product_class[0]['name']);
							$product_row['pc_fourlevel_name'] = $temp[count($temp)-1];
							$product_row['pc_fourlevel_id']   = $product_class[0][0];
							$class_level = 4;
						}
					}
				}
			}
			unset($product_class,$temp,$temp1,$temp2);

			/**
			 * 取得出价记录
			 */
			if (!is_object($this->obj_product_order)){
				require_once("order.class.php");
				$this->obj_product_order = new ProductOrderClass();
			}
			/**
			 * 实例化分页类
			 */
			if(!is_object($this->obj_page)){
				require_once("commonpage.class.php");
				$this->obj_page = new CommonPage();
			}
			/**
			 * 取得卖家资料
			 */
			$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_row['member_id']),'member_id,login_name,sale_score,buy_score,regist_time','more');
			/**
			 * 得到卖家好评率
			 */
			if (!is_object($this->obj_member_score)){
				require_once("score.class.php");
				$this->obj_member_score = new ScoreClass();
			}
			$seller_info['s_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"s");
			$seller_info['b_rate'] = $this->obj_member_score->getScorePercent($product_row['member_id'],"b");

			/**
			 * 商品购买记录
			 */
			if("0" != $product_row['p_sell_type']){//一口价和团购类型的
				$product_row['p_cur_price'] = $product_row['p_price'];
				/**
			 	  * 限定条件
			 	  */
				$obj_condition = array();
				$obj_condition['p_code'] = $p_id;
				$obj_condition['order'] = 1;
				$product_order_array = $this->obj_product_order->getProductOrderList($obj_condition, $page);
				/**
			 	 * 得到买家信息
				 */
				if (is_array($product_order_array)){
					foreach ($product_order_array as $key => $value){
						/**
						 * 如果没有买家姓名
						 */
						if ($value['buyer_name'] == ''){
							$product_order_array = $this->obj_member->getSomeMember($product_order_array,'buyer_id','member_id,login_name as buyer_nick');
						}else {
							$product_order_array[$key]['member_id'] = $value['buyer_id'];
							$product_order_array[$key]['buyer_nick'] = $value['buyer_name'];
						}
						$product_order_array[$key]['state'] = "2";
						$product_order_array[$key]['sold_time'] = @date("Y-m-d H:i:s",$value['sold_time']);
					}
				}
			}
			/**
			 * 拍卖出价记录
			 */
			if("0" == $product_row['p_sell_type']){//拍卖类型的
				if (!is_object($this->obj_product_bid)){
					require_once("bid.class.php");
					$this->obj_product_bid = new BidClass();
				}
				$obj_bid_condition['p_code'] = $p_id;
				$obj_bid_condition['order'] = 2;
				/**
				 * 如果当前还未有人出价，显示底价
				 */
				if("0" == $product_row['p_cur_price'] || "" == $product_row['p_cur_price']){
					$product_row['p_cur_price'] = $product_row['p_price'];
				}

				//取得竞拍出价列表
				$product_bid_array = $this->obj_product_bid->getProductBidList($obj_bid_condition, $obj_bid_page);

				//得到买家信息
				$product_order_array = $this->obj_member->getSomeMember($product_bid_array,'bid_member_id','member_id,login_name as buyer_nick');
				//格式化时间，处理显示数据
				if(is_array($product_bid_array)){
					foreach ($product_bid_array as $key => $value){
						$product_order_array[$key]['unit_price'] = $value['bid_price'];
						$product_order_array[$key]['buy_num'] = $value['bid_count'];
						$product_order_array[$key]['sold_time'] = @date("Y-m-d H:i:s",$value['bid_time']);
						$product_order_array[$key]['state'] = $value['bid_state'];
					}
				}
			}
			/**
			 * 更新商品浏览次数
			 */
			$update_product['p_code'] = $p_id;
			$update_product['txtViewNum'] = 1;
			$update_product_view_num = $this->obj_product->updateProductViewNum($update_product);
			/**
			 * 拍卖的加价幅度
			 */
			if("0" == $product_row['p_sell_type']){
				if (!is_object($this->obj_up_price)){
					require_once("up_price.class.php");
					$this->obj_up_price = new UpPriceClass();
				}
				if("1" == $product_row['p_system_step']){
					//拍卖当前价格
					$cur_price = ($product_row['p_cur_price']=="0")?$product_row['p_price']:$product_row['p_cur_price'];
					//取商品加价幅度
					$increment = $this->obj_up_price->getIncrementUpprice($cur_price);
					$product_row['p_price_step'] = $increment?$increment:1;
				}
			}
			//取地区内容
			if (!empty($product_row) && $product_row['p_area_id'] !=''){
				if (!is_object($this->obj_area)){
					require_once ("area.class.php");
					$this->obj_area = new AreaClass();
				}
				$sel_area = $this->obj_area->getAreaPathList($product_row['p_area_id']);
			}

			//取品牌内容
			if (!empty($product_row) && $product_row['p_pb_id'] !=''){
				$sel_brand = $this->obj_product_brand->getProductBrandPathList($product_row['p_pb_id']);
			}

			/**
			 * 创建商铺宝贝分类对象
			 */
			if (!is_object($this->obj_category)){
				require_once("shopproductcategory.class.php");
				$this->obj_category = new ShopProductCategoryClass();
			}
			//店铺商品分类
			$condition_shop_product_cate['shop_id'] = $shop_info['shop_id'];
			$condition_shop_product_cate['class_parent_id'] = '0'; //获取一级分类
			$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
			$category_array = $this->obj_category->getCategory($condition_shop_product_cate,$page);

			//插件
			$this->appModuleSignOutput('ntalker','ntalker_sign');

			/**
			 * 写进 浏览过的宝贝 cookie名称 product_viewed
			 */
			$this->setReviewed($product_row['p_code']);
			/**
			 * 页面输出
			 */
			//页面title keyword description
			$title_p_name = $product_row['p_name'].' - ';
			$keyword_p_name =
			($product_row['pc_onelevel_name']?','.$product_row['pc_onelevel_name']:'').
			($product_row['pc_twolevel_name']?','.$product_row['pc_twolevel_name']:'').
			($product_row['pc_threelevel_name']?','.$product_row['pc_threelevel_name']:'').
			($product_row['pc_fourlevel_name']?','.$product_row['pc_fourlevel_name']:'').
			','.$product_row['p_keywords'];
			$description_p_name = $product_row['p_description'];

			/**
			 * 全国默认输出运费内容
			 */
			$product_row['use_postage_content'] = unserialize($product_row['use_postage_content']);
			if (!empty($product_row['use_postage_content']['postage_ordinary'])){
				$default_postage['ordinary'] = $product_row['use_postage_content']['postage_ordinary']['default']['default'];
			}
			if (!empty($product_row['use_postage_content']['postage_fast'])){
				$default_postage['fast'] = $product_row['use_postage_content']['postage_fast']['default']['default'];
			}
			if (!empty($product_row['use_postage_content']['postage_ems'])){
				$default_postage['ems'] = $product_row['use_postage_content']['postage_ems']['default']['default'];
			}
			/**
			 * 一级地区，用来运费模板显示
			 */
			$postage_area_tmp = Common::getAreaCache('');
			$postage_area = array();
			if (is_array($postage_area_tmp)){
				foreach ($postage_area_tmp as $k => $v){
					if($v[1] == '0'){
						$postage_area[] = $v;
					}
				}
			}
			unset($postage_area_tmp);
			
			//卖家联系方式处理
			$seller_info['QQ']	= !empty($seller_info['QQ']) ? explode(",",$seller_info['QQ']) : $seller_info['QQ'];
			$seller_info['MSN']	= !empty($seller_info['MSN']) ? explode(",",$seller_info['MSN']) : $seller_info['MSN'];
			$seller_info['SKYPE']	= !empty($seller_info['SKYPE']) ? explode(",",$seller_info['SKYPE']) : $seller_info['SKYPE'];
			$seller_info['TAOBAO']	= !empty($seller_info['TAOBAO']) ? explode(",",$seller_info['TAOBAO']) : $seller_info['TAOBAO'];
						
			//图片链接
			//			$p_url = "../".$product_row['p_pic'];
			//			$key = "3irjklsd8432uisdklvr892348";
			//			$pURL = Common::encodeStr($p_url,$key);
			//			$this->output('pURL',$pURL);
			$this->output('default_postage',$default_postage);
			$this->output('postage_area',$postage_area);
			$this->output('pic_array',$pic_array);//商品图片列表
			$this->output('class_level',$class_level);
			$this->output("title_message"  , $title_p_name);     //TITLE内容
			$this->output("keyword_message", $keyword_p_name);     //关键字内容
			$this->output("Meta_desc", $description_p_name);     //内容描述
			$this->output("ses_login", $_SESSION['s_login']);   //登陆信息
			$this->output("shop_info", $shop_info);
			$this->output("product_row", $product_row);
			$this->output("PathLinks", $cate_path);
			$this->output("ses_login", $_SESSION['s_login']);   //登陆信息
			$this->output("message_array", $message_array);   //商品留言
			$this->output("seller_info", $seller_info);		//商家信息
			$this->output("buy_score", $buy_score);//买家信用
			$this->output("sale_score", $sale_score);//卖家信用
			$this->output("category_array", $category_array);		//店铺分类
			$this->output("have_attribute", $have_attribute);
			$this->output("product_attribute", $product_attribute);
			$this->output("product_attribute_content", $product_attribute_content);
			$this->output("product_have_attribute", $pac_attribute);
			$this->output("payment_array", $payment_array);
			$this->output("currency_array", $currency_array);
			$this->output("product_order_array", $product_order_array);
			$this->output("lefttime", $text_left_time);
			$this->output("exchange_remark", $exchange_remark);
			$this->output("sel_area", $sel_area);
			$this->output("sel_brand", $sel_brand);
			$this->output("sp_html", $this->_input['sp_html']);//订单快照标识，用来判断模板登录内容
			if($this->_input['sp_html'] == '1'){
				$this->showpage("product.sp_order");
			}else{
				if(DISCUZ_X === true) {
					$this->showpage("product_x.view");
				} else {
					$this->showpage("product.view");
				}
			}
		}
	}
	/**
	 * 商品搜索页面
	 *
	 */
	function _searchproduct(){
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->objProductCate)){
			require_once ("productclass.class.php");
			$this->objProductCate = new ProductCategoryClass();
		}

		$array = $this->objProductCate->listClassDetail();

		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[4] == '0') {
					$ProductCateArray[] = $v;
				}
			}
		}
		//地区内容
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);
		//商品品牌内容
		$array = Common::getProductBrandCache('');
		$brand_list = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['pb_id'] = $v[0];
					$v['pb_u_id'] = $v[1];
					$v['pb_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$brand_list[] = $v;
				}
			}
		}
		unset($array);
		//循环数组赋键值
		$area_array_json=array();
		$sel_area_json=array();
		if (is_array($area_array)) {
			foreach ($area_array as $k => $v){
				$area_array_json[$k]['id'] = $v[0];
				$area_array_json[$k]['name'] = $v[2];
				$area_array_json[$k]['is_parent'] = $v[5];
				if($this->_configinfo['websit']['ncharset']=="GBK")
				{
					$area_array_json[$k]['name']=Common::nc_change_charset($area_array_json[$k]['name'],'gbk_to_utf8');
				}
			}
		}
		//实例化 JSON 数据交换格式转换类
		require_once('json.class.php');
		$obj_json = new Services_JSON();
		$area_array_json= $obj_json->encode($area_array_json);
		//转换为 JSON 数据交换格式 
		$area_array_json=addslashes($area_array_json);
		/**
		 * 页面输出
		 */
		$this->output('area_array',$area_array_json);
		$this->output('brand_list',$brand_list);
		$this->output('ProductCateArray',$ProductCateArray);
		$this->showpage("product.search");
	}

	/**
	 * 比较产品
	 *
	 */
	function _compareproduct(){
		$pcode_array = explode("_",$this->_input['pcode']);
		$this->setCompare($pcode_array);
		header("location: product.php?action=compareresult");
	}

	/**
	 * 产品比较显示页面
	 */
	function _compareproductresult(){
		$compare_cookie = $this->getCookies('compare');
		if("" != $compare_cookie){
			$cookie_array = explode("|", $compare_cookie);
			foreach ($cookie_array as $key => $value){
				$obj_condition['pcodes'][$key] = $value;
			}
			$product_array = $this->obj_product->getProductList($obj_condition, $obj_page);
			/**
			 * 取得商品属性
			 */
			if (!is_object($this->obj_product_attribute)){
				require_once("attribute.class.php");
				$this->obj_product_attribute = new AttributeClass();
			}
			if (!is_object($this->obj_product_attribute_content)){
				require_once("attribute_content.class.php");
				$this->obj_product_attribute_content = new AttributeContentClass();
			}
			$product_attribute_compare = array();//一维数组，属性名称为下标，用来不重复匹配商品属性

			/**
		 	* 得到店主信息
			*/
			$product_array = $this->obj_member->getSomeMember($product_array,'member_id','member_id,login_name as shopmaster');

			for($i=0;$i<count($product_array);$i++){
				//取商品属性集合，整理为名称作为下标,ID作为值的数组，有多个对应值的组合为数组形式
				$condition['pc_id'] = $product_array[$i]['pc_id'];
				$product_attribute = $this->obj_product_attribute->getAttributeList($condition,$page);
				if(is_array($product_attribute_compare)){
					//取商品属性名称
					foreach ($product_attribute as $v =>$k){
						if(!in_array($k['a_name'],$product_attribute_compare)){
							//判断是否在对比属性集合中存在，如果没存在，则新增，名称作为下标
							$product_attribute_compare[$k['a_name']] = array($k['a_id']);
						}else if (!in_array($k['a_id'],$product_attribute_compare[$k['a_name']])){
							//已经存在属性集合中，判断ID是否在数组的值中
							$product_attribute_compare[$k['a_name']][] = $k['a_id'];
						}
					}
				}
				unset($product_attribute,$condition);
				//取每个商品的属性
				$attribute_condition_str = " and p_id = '" . $product_array[$i]['p_code'] . "'";
				$every_attribute = $this->obj_product->getProductAttribute($attribute_condition_str, $obj_page);
				foreach ($product_attribute_compare as $k => $v){//k 属性名称，v 属性id数组
					foreach ($every_attribute as $k2 => $v2){//k2 数组下标 v2 商品属性信息
						if (in_array($v2['a_id'],$v)){
							//增加到每种商品的信息中,属性名称是下标，属性内容是值
							$product_array[$i][$k] = $v2['pac_content'];//$v2['pac_content'] 以逗号间隔的属性内容ID
						}
					}
				}
				unset($every_attribute);
				//常用信息
				$left_time = $product_array[$i]['p_end_time'] - time();
				$product_array[$i]['left_days'] = intval($left_time / (24*60*60));
				$product_array[$i]['left_hours'] = intval(($left_time % (24*60*60)) / (60*60));
				$product_array[$i]['left_minutes'] = intval((($left_time % (60*60))) / 60);
				$product_array[$i]['product_type'] = $this->_b_config['p_type'][$product_array[$i]['p_type']];
			}
			//取商品属性的具体内容值
			foreach ($product_attribute_compare as $k => $v){//k 属性名称，v 属性id数组
				//每种商品
				for($i=0;$i<count($product_array);$i++){
					if ($product_array[$i][$k] != ''){
						//判断对应ID 是单一还是多个
						if (strstr($product_array[$i][$k],',')){
							$condition['in_ac_id'] = $product_array[$i][$k];//该商品的商品属性内容对应值的ID	以逗号间隔
						}else {
							$condition['ac_id'] = $product_array[$i][$k];
						}
						//二维数组
						$ac_content = $this->obj_product_attribute_content->getAttributeContentList($condition,$page);
						//将属性内容值替换为文字
						if (is_array($ac_content)){
							$product_array[$i][$k] = '';
							foreach ($ac_content as $v2 => $k2){
								$product_array[$i][$k] .= $k2['ac_content'];
							}
						}
						unset($condition);
					}
				}
			}
		}
		//判断是否使用静态链接
		$product_array = $this->obj_product->checkProductIfHtml($product_array,$this->_configinfo['productinfo']['ifhtml']);
		//取地区内容
		if (!empty($product_array)){
			/**
			 * 创建地区对象
			 */
			if (!is_object($this->obj_area)){
				require_once ("area.class.php");
				$this->obj_area = new AreaClass();
			}
			foreach ($product_array as $k => $v){
				if ($v['p_area_id'] != ''){
					$product_array[$k]['sel_area'] = $this->obj_area->getAreaPathList($v['p_area_id']);
				}
			}
		}
		/**
		 * 页面输出
		 */
		$this->output("product_compare", $product_array);
		$this->output("product_number", count($product_array));
		$this->output("product_attribute_compare", $product_attribute_compare);
		$this->showpage("product.compare");
	}
	/**
	 * 移除对比商品
	 *
	 */
	function _compareremove(){
		$pcode = $this->_input['pid'];
		$this->unsetCompare($pcode);
		header("location: product.php?action=compareresult");
	}
	/**
	 * 列出 浏览过的宝贝中的 商品
	 *
	 */
	function _reviewedproduct()
	{
		$str = $this->getCookies('c_product_viewed');
		if ("" != $str) {
			$reviewed_product = $this->getReveiwedProduct($str);
		}
		$reviewed_product = $this->obj_product->productPicRatio($reviewed_product,'p_pic',96);
		$i = 0;
		if(is_array($reviewed_product)){
			foreach ($reviewed_product as $k => $v){
				if (!empty($v['p_code'])){
					$image_array = @getimagesize('../'.$reviewed_product[$i]['small_pic']);
					$reviewed1_product[$i]['img_height'] = $image_array[0];
					$reviewed1_product[$i]['img_width']  = $image_array[1];
					$reviewed1_product[$i]['p_code']  = $v['p_code'];
					$reviewed1_product[$i]['p_id']  = $v['p_id'];
					$reviewed1_product[$i]['p_price']  = $v['p_price'];
					$reviewed1_product[$i]['p_name']  = $v['p_name'];
					$reviewed1_product[$i]['html_url']  = $v['html_url'];
					$reviewed1_product[$i]['small_pic']  = $v['small_pic'];
					$i++;
				}
			}
		}


		$line = $str;
		$line = str_replace('|','_',$line);
		$this->output("reviewed_code", $line);
		$this->output("reviewed_product", $reviewed1_product);
	}
	/**
	 * 获得 cookie 中的浏览过的商品信息列表
	 * @param  str $str 商品货号
	 * @return array 返回商品信息列表
	 */
	function getReveiwedProduct($str)
	{
		$array = array();
		$array = @explode('|',$str);
		if(is_array($array)){
			foreach ($array as $key => $value){
				$product_arr[$key] = $this->obj_product->getProductRow($value);
				//截字
				$product_arr[$key]['p_name'] = Char_class::cut_str($product_arr[$key]['p_name'],32,0,$this->_configinfo['websit']['ncharset']);
				if ($key == 3){ break; }
			}
			/*判断是否使用静态链接*/
			$product_arr = $this->obj_product->checkProductIfHtml($product_arr,$this->_configinfo['productinfo']['ifhtml']);
		}
		return $product_arr;
	}
	/**
	 * 清除 浏览过的宝贝中的 记录
	 *
	 */
	function _cleanreviewedproduct()
	{
		$this->setCookies("c_product_viewed", '');
		$this->redirectPath("refer","","");
	}
	/**
	 * 把要进行对比的产品的产品号放到COOKIE中保存
	 *
	 * @param var[] $pcode
	 * @return boolean
	 */
	function setCompare($pcode){
		$new_pcode = "";
		$compare_cookie = $this->getCookies('compare');
		if("" != $compare_cookie){
			$cookie_pcode = $compare_cookie;
			$cookie_array = explode("|", $compare_cookie);
		}else{
			$cookie_array=array();
		}

		if (is_array($pcode)){
			foreach ($pcode as $k=>$v){
				if(!in_array($v, $cookie_array)){
					$cookie_pcode .= "|" . $v;
				}
			}
		}else{
			if(!in_array($pcode, $cookie_array)){
				$cookie_pcode .= "|" . $pcode;
			}
		}
		$this->setCookies("compare", $cookie_pcode);
		return true;
	}
	/**
	 * 在COOKIE中移除对比中的商品
	 *
	 * @param string $pcode
	 * @return boolean
	 */
	function unsetCompare($pcode){
		$new_pcode = "";
		$compare_cookie = $this->getCookies('compare');
		if("" != $compare_cookie){
			$cookie_pcode = $compare_cookie;
			$cookie_array = explode("|", $compare_cookie);
		}else{
			$cookie_array=array();
		}

		if ("" != $pcode){
			foreach ($cookie_array as $k=>$v){
				if($pcode == $v){
					array_splice($cookie_array, $k, 1);
				}else{
					$cookie_new_pcode .= "|" . $v;
				}

			}
		}
		$this->setCookies("compare", $cookie_new_pcode);
		return true;
	}

	/**
	 * 把浏览过的产品的产品号放到COOKIE中保存
	 *
	 * @param var[] $pcode
	 * @return boolean
	 */
	function setReviewed($pcode){

		$str = $this->getCookies('c_product_viewed');
		if("" != $str){
			$cookie_array = @explode("|", trim($str,'|'));
			if (count($cookie_array) >= 4){
				array_pop($cookie_array);
				$cookie_pcode = @implode('|',$cookie_array);
			}else{
				$cookie_pcode = @implode('|',$cookie_array);
			}
		}else{
			$cookie_array=array();
		}

		if (!@in_array($pcode,$cookie_array)){/*如果产品在cookie里已有，则不记录*/
			if (count($cookie_array) == 0) {
				$cookie_pcode = $pcode;
			}else {
				$cookie_pcode =  $pcode."|".$cookie_pcode;
			}
		}
		$this->setCookies("c_product_viewed", $cookie_pcode);
		return true;
	}

	/**
	 * AJ 判断验证码是否正确
	 */
	function _check_code(){
		$code = $this->_input['checkcode'];
		if (strtoupper($code) == strtoupper($_SESSION['seccode'])){
			echo 1;/*正确*/
		}else {
			echo 2;/*错误*/
		}
	}

	/**
	 * 生成静态文件
	 */
	function make_product_html($p_id){
		/**
		 * 创建商品静态页面对象
		 */
		if (!is_object($this->obj_html_product)){
			require_once("../home/html.product.php");
			$this->obj_html_product = new HtmlProductManage();
		}
		$result = $this->obj_html_product->_make_product_html($p_id);
		return $result;
	}

	/**
	 * 取指定商品类别的属性以及属性内容
	 */
	function _ajax_get_attribute(){
		if ($this->_input['pc_id'] != ''){
			if (!is_object($this->obj_product_attribute)){
				require_once("attribute.class.php");
				$this->obj_product_attribute = new AttributeClass();
			}
			if (!is_object($this->obj_product_attribute_content)){
				require_once("attribute_content.class.php");
				$this->obj_product_attribute_content = new AttributeContentClass();
			}
			$condition_attribute['pc_id'] = $this->_input['pc_id'];
			$product_attribute = $this->obj_product_attribute->getAttributeList($condition_attribute,$page);
			unset($condition_attribute);
			if(count($product_attribute)>0){
				//取商品属性内容
				foreach ($product_attribute as $k => $v){
					$condition_attribut_content['a_id'] = $v['a_id'];
					$product_attribute[$k]['content'] = $this->obj_product_attribute_content->getAttributeContentList($condition_attribut_content,$page);
					unset($condition_attribut_content);
					if (count($product_attribute[$k]['content']) > 0){
						$content_sign = 1;
					}else {
						unset($product_attribute[$k]);
					}
				}
				//判断商品属性是否有内容
				if ($content_sign == 1){//有内容
					$have_attribute = 1;
				}
				unset($content_sign);
			}
			/**
			 * 页面输出
			 */
			$this->output('product_attribute',$product_attribute);
			$this->output('have_attribute',$have_attribute);
			$this->showpage('ajax_get_attribute');
		}else {
			return false;
		}
	}
	/**
     * 获取指定商品的感兴趣的会员列表
     */
	function _getviewmember($product_id=0) {
		$pid = $this->_input['pid'];

		include_once("collection.class.php");

		$obj_collection = new CollectionClass();

		$collection_member_array = $obj_collection->getCollectionMember($product_id ? $product_id : $pid);

		if (is_array($collection_member_array)) {
			if($product_id) {
				foreach ($collection_member_array as $kc => $vc) {
					$collection_member_array[$kc]['member_pic'] = $this->_configinfo['ucenter']['uc_api'] . "/avatar.php?uid={$vc['member_id']}&size=small";
				}
				return $collection_member_array;
			} else {
				$view_member_html = '';
				foreach ($collection_member_array as $kc => $vc) {
					$view_member_html .= '<li><a href="'.$this->_configinfo['websit']['site_url'].'/../?'.$vc['member_id'].'" title="'.$vc['login_name'].'" target="_blank"><img src="'.$this->_configinfo['ucenter']['uc_api'] . "/avatar.php?uid={$vc['member_id']}&size=small".'" alt="'.$vc['login_name'].'"/></a></li>';
				}
				echo $view_member_html;
			}
		} else {
			return false;
		}
		return false;
	}
	/**
     * 验证指定用户是否通过实名认证
     */
	function _valid_certification() {
		if(!intval($this->_input['member_id'])) {
			echo 0;exit;
		}
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		$shop_info = $this->obj_shop->getOneShopByMemeberId(intval($this->_input['member_id']),'1');;
		if(!empty($shop_info)) {
			if($shop_info['audit_state'] !=2 ) {
				echo 0;exit;
			} else {
				echo 1;exit;
			}
		} else {
			echo 0;exit;
		}
	}
}

$product = new ShowProduct();
$product->main();
unset($product);
?>
