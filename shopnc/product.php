<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : product.php D:\binzi\shopnc6\product.php
* 商品展示页面
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Mon Sep 15 17:44:27 CST 2008
*/
require ("global.inc.php");

class ShowProduct extends CommonFrameWork{

	/**
	 * 产品对象
	 *
	 * @var obj
	 */
	private $obj_product;
	/**
	 * 产品分类对象
	 *
	 * @var obj
	 */
	private $obj_product_class;
	/**
	 * 品牌对象
	 *
	 * @var obj
	 */
	private $obj_brand;
	/**
	 * 评论对象
	 *
	 * @var obj
	 */
	private $obj_comment;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	private $obj_goods;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	private $objvalidate;

	function main(){
		/**
		 * 创建产品对象
		 */
		if(!is_object($this->obj_product)) {
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_product_class)) {
			require_once("productClass.class.php");
			$this->obj_product_class = new ProductClassClass();
		}
		/**
		 * 创建商品品牌对象
		 */
		if (!is_object($this->obj_brand)) {
			require_once("brand.class.php");
			$this->obj_brand = new BrandClass();
		}
		/**
		 * 创建评论对象
		 */
		if (!is_object($this->obj_comment)) {
			require_once("goodsComments.class.php");
			$this->obj_comment = new GoodsCommentsClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_goods)) {
			require_once("goods.class.php");
			$this->obj_goods = new GoodsClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 语言包
		 */
		$this->getlang("product,header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'add_comment'://发表评论
			$this->addComment();
			break;
			default:
				$this->product();
		}

	}
	/**
	 * 发表评论
	 *
	 */
	private function addComment(){
		$input_param = array();

		$input_param['user_id']			= intval($_SESSION['userinfo']['user_id']);
		$input_param['goods_id']		= intval($this->_input['goods_id']);
		$input_param['comment_body'] 	= trim($this->_input['comment_body']);

		/*验证信息*/
		$this->objvalidate->setValidate(array('input'=>$input_param['user_id'],			'require'=>"true",'message'=>$this->_lang['product_good_comment_login']));
		$this->objvalidate->setValidate(array('input'=>$input_param['comment_body'],	'require'=>"true",'message'=>$this->_lang['product_good_comment_null']));
		/*判断验证码是否开启*/
		if($this->_viewinfo['websit']['view_comment_validate'] == '1') {
			$this->objvalidate->setValidate(array('input'=>strtoupper($this->_input['txt_comment_code']),	'require'=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),'message'=>$this->_lang['product_good_code_error']));
		}
		$error = $this->objvalidate->validate();
		if($error) {
			$this->showMessage($error,$this->refer_url,1);
		}

		if ($input_param['comment_body'] != "") {
			$result = $this->obj_comment->addGoodsComment($input_param);
			if ($result) {
				$this->showMessage($this->_lang['product_good_comment_succ'],$this->_configinfo['websit']['site_url']."/product.php?id=".$input_param['goods_id'],1,2000);
			}
			else {
				$this->showMessage($this->_lang['product_good_comment_error'],$this->_configinfo['websit']['site_url']."/product.php?id=".$input_param['goods_id'],1,2000);
			}
		}
		else {
			$this->showMessage($this->_lang['product_good_comment_null'],$this->_configinfo['websit']['site_url']."/product.php?id=".$input_param['goods_id'],1,2000);
		}
	}
	/**
	 * 产品显示页面
	 * 
	 */
	private function product(){

		/*当前产品信息*/
		$condition['goods_id']	= intval($this->_input['id']);
		if($condition['goods_id'] == 0) {
			header("Location:index.php");
			exit();
		}
		
		$condition['no_state']	= 1;
		$product_array	= $this->obj_product->getProductInfo($condition);
		/*产品颜色，产品规格*/
		$c_array		= @explode('|',$product_array['goods_color']);
		$s_array		= @explode('|',$product_array['goods_size']);
		$color_select	= $product_array['goods_color'] != '' ? Common::Select('goods_color',array_combine($c_array,$c_array)) : '' ;
		$size_select	= $product_array['goods_size']	!= '' ? Common::Select('goods_size',array_combine($s_array,$s_array))  : '' ;
		$this->output('color_select',$color_select);	//颜色输出
		$this->output('size_select',$size_select);		//规格输出

		/*产品多图*/
		require_once('goods.class.php');
		$goods	= new GoodsClass();
		$product_array['more_image'] = $goods->getGoodsImage($product_array['goods_id']);
		$this->output('more_image_num',count($product_array['more_image'])+1);

		$this->output('product_array',$product_array);

		/*浏览量*/
		$goods_click = intval($product_array['goods_click'])+1;
		$this->obj_goods->modifyGoods($goods_click,$condition['goods_id'],"goods_click");
		/*推荐产品*/
		$commend_array = $this->obj_product->getProductSpecific(array('goods_commend'=>1,'goods_state'=>1));
		$this->output('commend_array',$commend_array);

		/*产品属性*/
		$goods_attr_body	= @unserialize($product_array['goods_attr_body']);//商品内的属性
		include('goodsClass.class.php');	//载入产品分类文件
		$goods_class	= new GoodsClassClass();
		$goods_type_id	= $goods_class->getGoodsClassInfo(array('class_id'=>$product_array['class_id']),'goods_type_id,class_other_attr');

		if($goods_type_id[0] != '') {
			include('goodsType.class.php');
			$goods_type	= new GoodsTypeClass();
			$type_array	= $goods_type->getTypeInfo(array('goods_type_id'=>$goods_type_id[0]));
			/*判断商品类型状态，如果关闭则不执行*/
			if($type_array['goods_type_state'] == 1) {
				$attr_array	= $goods_type->goodsAttrArray(array('txt_goods_type_id'=>$type_array['goods_type_id']));
				$goods_attr	= array();
				$i	= 0;
				foreach ($attr_array as $val) {
					if(!empty($goods_attr_body['class_attr'][$val['attribute_id']])) {
						$goods_attr[$i]['title']	= $val['attribute_name'];
						$goods_attr[$i]['vaule']	= $goods_attr_body['class_attr'][$val['attribute_id']];
						$i++;
					}
				}
				$this->output('goods_attr',$goods_attr);
			}
		}
		/*产品所在分类独有属性*/
		if(is_array($goods_type_id['class_other_attr']) and count($goods_type_id['class_other_attr'])>0) {
			$goods_other_attr	= array();
			foreach ($goods_type_id['class_other_attr'] as $key => $value) {
				if(!empty($goods_attr_body['class_other_attr'][$key])) {
					$goods_other_attr[]		= array('attr_name'=>$value,'attr_value'=>$goods_attr_body['class_other_attr'][$key]);
				}
			}
		}
		$this->output('goods_other_attr',$goods_other_attr);

		/*相关商品*/
		if($product_array['goods_link_goods'] != '') {
			$goods_link_goods	= $this->obj_goods->ajaxGoodsSearch(array('goods_id_str'=>$product_array['goods_link_goods'],'other_action'=>'modify_link'),'*');
			$this->output('goods_link_goods',$goods_link_goods);
		}
		/*相关文章*/
		if($product_array['goods_link_article'] != '') {
			include('article.class.php');
			$article	= new ArticleClass();
			$goods_link_article	= $article->ajaxArticleSearch(array('article_id_str'=>$product_array['goods_link_article'],'other_action'=>'modify_link'));
			$this->output('goods_link_article',$goods_link_article);
		}
		/*产品导航条*/
		include(BasePath."/share/goods_class_show.php");
		$array	= array();
		foreach ($node_cache as $k => $v) {
			if($v[0] == intval($product_array['class_id'])) {
				$array['class_id']	= $v[0];
				$array['class_top_id']	= $v[1];
				$array['key_id']	= $k;
				break;
			}
		}
		$class_menu = $this->obj_product_class->prductClassMenu($array);
		$this->output('class_menu',$class_menu);
		/*评论列表*/
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(10);
		$conditon_array = array('goods_id'=>$condition['goods_id']);
		$comment_array = $this->obj_comment->getGoodsCommentList($conditon_array,$obj_page);
		$show_page = $obj_page->show(3);
		$this->output('comment_array',$comment_array);
		$this->output('show_page',$show_page);
		
		/*侧边商品分类显示*/
		$class_array = $goods_class->getClassSort();
		$this->output('class_array',$class_array);

		/*商品品牌*/
		$brand_array	= $this->obj_brand->getBrandList(array('show_type'=>'class_show'));
		$this->output('brand_array',$brand_array);
		/*当前类热卖商品*/
		$hot_array		= $this->obj_product_class->productClassList($array,'','goods.goods_name,goods.goods_id','',' order by goods.goods_click desc',8);
		$this->output('hot_array',$hot_array);
		/*浏览过的商品*/
		if($this->getCookies('c_product_viewed') != '') {
			$view_goods_array= $this->obj_product_class->productClassList(array('c_product_viewed'=>$this->getCookies('c_product_viewed')),'','goods.goods_name,goods.goods_id,goods.goods_small_image');
			$this->output('view_goods_array',$view_goods_array);
		}
		/*添加该商品到cookie，浏览商品*/
		$this->setReviewed(intval($this->_input['id']));

		$this->showpage("product");
	}
	/**
	 * 把浏览过的产品的产品号放到COOKIE中保存
	 *
	 */
	function setReviewed($pcode){

		$str = $this->getCookies('c_product_viewed');
		if("" != $str){
			$cookie_array = @explode("|", trim($str,'|'));
			if (count($cookie_array) >= 7){
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
}
$product = new ShowProduct();
$product->main();
unset($product);
?>