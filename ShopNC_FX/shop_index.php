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
* FILE_NAME : shop_index.php D:\root\shopnc6_jh\shop_index.php
* 聚合首页
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:50:56 CST 2009
*/
require("shop.global.inc.php");
class ShowShopIndex extends ShopCommonFrameWork {
	/**
	 * 网店对象
	 *
	 * @var obj
	 */
	private $obj_shop_user;
	/**
	 * 店铺分类对象
	 * 
	 * @var obj
	 */
	private $obj_shop_class;
	/**
	 * 产品对象
	 * 
	 * @var obj
	 */
	private $obj_product;
	/**
	 * 友情链接对象
	 *
	 * @var obj
	 */
	private $obj_shop_link;
	/**
	 * 文章对象
	 *
	 * @var obj
	 */
	private $obj_article;
	/**
	 * 文章分类对象
	 *
	 */
	private $obj_article_class;
	/**
	 * 品牌对象
	 *
	 * @var obj
	 */
	private $obj_brand;

	public function main() {

		$url_array	= false;
		/*php url路由开启*/
		if($this->_configinfo['websit']['open_url'] == '1') {
			$url_array	= Common::nc_html_url();
		}

		if($url_array == false) {
			/**
		 * 创建网店对象
		 */
			if (!is_object($this->obj_shop_user)){
				require_once("shopUser.class.php");
				$this->obj_shop_user = new ShopUserClass();
			}
			/**
		 * 创建店铺分类对象
		 */
			if (!is_object($this->obj_shop_class)){
				require_once("shopClass.class.php");
				$this->obj_shop_class = new ShopClassClass();
			}
			/**
		 * 创建商品对象
		 */
			if(!is_object($this->obj_product)) {
				require_once("product.class.php");
				$this->obj_product = new ProductClass();
			}
			/**
		 * 创建友情链接对象
		 */
			if (!is_object($this->obj_shop_link)) {
				require_once("shopLink.class.php");
				$this->obj_shop_link = new ShopLinkClass();
			}
			/**
		 * 创建文章对象
		 */
			if (!is_object($this->obj_article)) {
				require_once("shopArticle.class.php");
				$this->obj_article = new ShopArticleClass();
			}
			/**
		 * 创建文章类别对象
		 */
			if (!is_object($this->obj_article_class)) {
				require("shopArticleClass.class.php");
				$this->obj_article_class = new ShopArticleClassClass();
			}
			/**
		 * 创建商品品牌对象
		 */
			if (!is_object($this->obj_brand)) {
				require_once("brand.class.php");
				$this->obj_brand = new BrandClass();
			}
			/**
		 * 设置模板路径
		 */
			$this->setsubtemplates("templates/new_shops");
			/**
		 * 语言包
		 */
			$this->getlang("shop_index,shop_common");
			/**
		 * 执行操作
		 */
			switch($this->_input['action']){
				default:
					$this->showIndex();
			}
		} else {
			$_GET	= $url_array['input_array'];
			include($url_array['file_name']);
			exit();
		}
	}
	/**
	 * 聚合首页
	 *
	 */
	private function showIndex() {
		/*右侧店铺分类*/
		include(BasePath."/share/shop_class_show.php");
		if (is_array($node_cache)){
			$array = array();
			foreach ($node_cache as $v) {
				if ($v['parentId'] == 0){
					$array[$v['id']] = $v;
				}else{
					if (count($array[$v['parentId']]['child'])<7){
						$array[$v['parentId']]['child'][] = $v;
					}
				}
			}
			$shop_class_array = array();
			foreach ($array as $v) {
				if (count($shop_class_array) < 5){
					$shop_class_array[] = $v;
				}
			}
		}
		$this->output('shop_class_array',$shop_class_array);

		/*电子商务资讯中心*/
		$condition = array();
		$condition['astate'] = 1;
		$condition['ashow'] = 1;
		$condition['arc_class'] = 2;
		$article_array = $this->obj_article->getArticleType($condition,10);
		$this->output('article_array_zx',$article_array);

		/*电商学院*/
		$condition = array();
		$condition['astate'] = 1;
		$condition['ashow'] = 1;
		$condition['arc_class'] = 3;
		$article_array = $this->obj_article->getArticleType($condition,10);
		$this->output('article_array_xy',$article_array);

		/*网店公告*/
		$condition = array();
		$condition['astate'] = 1;
		$condition['ashow'] = 1;
		$condition['arc_class'] = 1;
		$article_array = $this->obj_article->getArticleType($condition,6);
		$this->output('article_array_gg',$article_array);

		/*热门专区*/
		/*新品上市*/
		//		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1),6);
		//		$this->output('new_product',$product_array);
		/*疯狂抢购,暂按点击量*/
		//		$product_array = $this->obj_product->getShopProductSpecific('',6,'goods_click desc');
		//		$this->output('click_product',$product_array);
		/*推荐商品*/
		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1,'goods_commend'=>1),12);
		$this->output('commend_product',$product_array);
		/*热卖商品*/
		//		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1,'goods_hot'=>1),6);
		//		$this->output('hot_product',$product_array);
		/*特价商品*/
		//		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1,'goods_special'=>1),6);
		//		$this->output('spe_product',$product_array);
		/*明星店铺*/
		$super_shops_array	= $this->obj_shop_user->getShopListType(array('shop_type'=>'super_shop'),6);
		$this->output('index_shops_array',$super_shops_array);

		/*时尚潮流*/
		/*新品上市*/
		//		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1),3);
		//		$this->output('new_product_s',$product_array);
		/*疯狂抢购,暂按点击量*/
		//		$product_array = $this->obj_product->getShopProductSpecific('',6,'goods_click desc');
		//		$this->output('click_product_s',$product_array);

		/*新品速递*/
		/*新品上市*/
		//		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1),3);
		//		$this->output('new_product_x',$product_array);
		/*疯狂抢购,暂按点击量*/
		//		$product_array = $this->obj_product->getShopProductSpecific('',3,'goods_click desc');
		//		$this->output('click_product_x',$product_array);
		/*热卖商品*/
		//		$product_array = $this->obj_product->getShopProductSpecific(array('goods_state'=>1,'goods_hot'=>1),3);
		//		$this->output('hot_product_x',$product_array);

		/*热门店铺*/
		$hot_shops_array	= $this->obj_shop_user->getShopListType(array('shop_type'=>'hot_shop'),5);
		$this->output('hot_shops_array',$hot_shops_array);


		/*新开网店*/
		$new_shops_array	= $this->obj_shop_user->getShopListType(array('shop_type'=>'new_shop'),6);
		$this->output('new_shops_array',$new_shops_array);

		/*热卖品牌*/
		//		$brand_array	= $this->obj_brand->getShopBrandList(array('brand_state'=>'1'),10);
		//		$this->output('brand_array',$brand_array);

		/*友情链接*/
		$link_image	= $this->obj_shop_link->getLinkList(array('logo'=>1),'');
		$this->output('link_image',$link_image);
		//		$link_text	= $this->obj_shop_link->getLinkList(array('logo'=>2),'');
		//		$this->output('text_link_num',count($link_text));
		//		$this->output('link_text',$link_text);
		/*首页广告*/
		include(BasePath.'/data/ad_image.php');
		$this->output('ad_images',$ad_images);				//幻灯片广告
		$this->output('other_ad_image',$other_ad_image);	//其他广告

		$this->shopshowpage("index");
	}
}
$shop_index = new ShowShopIndex();
$shop_index->main();
unset($shop_index);
?>