<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想单用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : index.php   FILE_PATH : \shopnc6\index.php
 * ....商城首页显示
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Sep 21 14:05:16 CST 2007
 */

require ("global.inc.php");
class ShowIndex extends CommonFrameWork{

	/**
	 * 产品对象
	 *
	 * @var obj
	 */
	private $obj_index;

	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	private $obj_goods_class;

	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	private $obj_product;

	/**
	 * 投票对象
	 *
	 * @var obj
	 */
	private $obj_vote;

	/**
	 * 文章对象
	 *
	 * @var obj
	 */
	private $obj_show_article;
	/**
	 * 广告对象
	 *
	 * @var obj
	 */
	private $obj_tool_ad;
	/**
	 * 商品品牌对象
	 *
	 * @var obj
	 */
	private $obj_brand;
	/**
	 * 商品主题对象
	 *
	 * @var obj
	 */
	private $obj_goods_subject;
	/**
	 * 访问对象
	 *
	 * @var obj
	 */
	private $obj_visit;
	/**
	 * 友情链接对象
	 *
	 * @var obj
	 */
	private $obj_link;

	function main(){
		if (!file_exists(BasePath."/share/install.lock")){
			header("location:install/index.php");
			exit;
		}
		/**
		 * 创建首页对象
		 */
		if(!is_object($this->obj_index)) {
			require_once("index.class.php");
			$this->obj_index = new IndexClass();
		}

		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_goods_class)) {
			require_once("goodsClass.class.php");
			$this->obj_goods_class = new GoodsClassClass();
		}
		/**
		 * 创建商品品牌对象
		 */
		if (!is_object($this->obj_brand)) {
			require_once("brand.class.php");
			$this->obj_brand = new BrandClass();
		}
		/**
		 * 创建商品对象
		 */
		if(!is_object($this->obj_product)) {
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建主题对象
		 */
		if (!is_object($this->obj_goods_subject)) {
			require_once("goodsSubject.class.php");
			$this->obj_goods_subject = new GoodsSubjectClass();
		}
		/**
		 * 创建投票对象
		 */
		if(!is_object($this->obj_vote)) {
			require_once("vote.class.php");
			$this->obj_vote = new VoteClass();
		}

		/**
		 * 创建投票对象
		 */
		if(!is_object($this->obj_show_article)) {
			require_once("indexArticle.class.php");
			$this->obj_show_article = new IndexArticleClass();
		}
		/**
		 * 创建广告对象
		 */
		if (!is_object($this->obj_tool_ad)) {
			require_once("toolAd.class.php");
			$this->obj_tool_ad = new ToolAdClass();
		}
		/**
		 * 创建友情链接对象
		 */
		if (!is_object($this->obj_link)) {
			require_once("link.class.php");
			$this->obj_link = new LinkClass();
		}
		/**
		 * 创建访问对象
		 */
		if (!is_object($this->obj_visit)) {
			require_once("visit.class.php");
			$this->obj_visit = new VisitClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("index,header_footer");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){

			default:
				$this->_showIndex();
		}

	}
	/**
	 * 首页显示
	 * 
	 */
	function _showIndex(){
		/*添加验证信息(登录时的csrf验证)*/
		include("seride.php");
		$Seride = new Seride();
		$this->output('seride_form',$Seride->seride_form());
		
		/*侧边商品分类显示*/
		$class_array	= $this->obj_goods_class->getClassSort();
		$this->output('class_array',$class_array);

		/*最新商品*/
		$new_product = $this->obj_product->getProductSpecific(array('goods_state'=>1),$this->_viewinfo['websit']['index_new_num']);
		$this->output('new_product',$new_product);
		/*推荐商品*/
		$commend_product = $this->obj_product->getProductSpecific(array('goods_state'=>1,'goods_commend'=>1),$this->_viewinfo['websit']['index_commend_num']);
		$this->output('commend_product',$commend_product);
		/*热卖商品*/
		$hot_product = $this->obj_product->getProductSpecific(array('goods_state'=>1,'goods_hot'=>1),$this->_viewinfo['websit']['index_hot_num']);
		$this->output('hot_product',$hot_product);
		/*特价商品*/
		$spe_product = $this->obj_product->getProductSpecific(array('goods_state'=>1,'goods_special'=>1),$this->_viewinfo['websit']['index_spe_num']);
		$this->output('spe_product',$spe_product);
		/*投票*/
		$vote_array[1]	= $this->obj_vote->getVote();
		$vote_array[0]	= array('title'=>$vote_array[1][0]['vote_title'],'vote_id'=>$vote_array[1][0]['vote_id'],'vote_type'=>$vote_array[1][0]['vote_type']);
		$this->output('vote_array',$vote_array);
		/*商品品牌*/
		$brand_array = $this->obj_brand->getBrandList(array('show_type'=>'class_show','limit_num'=>$this->_viewinfo['websit']['index_brand_num']));
		$this->output('brand_array',$brand_array);
		/*商品主题*/
		$subject_array = $this->obj_goods_subject->getSubjectAll(array('subject_state'=>'1','limit_num'=>$this->_viewinfo['websit']['index_subject_num']));
		$this->output("subject_array",$subject_array);
		/*公告*/
		$notice_array	= $this->obj_show_article->getArticle(array('notice'=>1,'class_id'=>1,'article_num'=>$this->_viewinfo['websit']['index_notice_num']));
		$this->output('notice_array',$notice_array);
		/*访问统计*/
		$ip_num = $this->obj_visit->getVisitList(array(),'*',"","ip");
		$this->output("ip_num",count($ip_num)?count($ip_num):'0');	/*ip总量*/
		/*广告*/
		$ad_array = $this->obj_tool_ad->getAdInfo(array('ad_id'=>1));
		$ad_array['ad_body']	= unserialize($ad_array['ad_body']);
		$pic_array = array();
		$i = 0;
		if(is_array($ad_array['ad_body']) and count($ad_array['ad_body'])>0) {
			foreach ($ad_array['ad_body'] as $ad) {
				/*大图片路径*/
				$big_pic = explode("/",$ad);
				$b_pic = explode(".",$big_pic[2]);
				$pic_array[$i]['big'] = $big_pic[1]."/".$b_pic[0];
				/*小图片路径*/
				$small_pic = explode(".",$ad);
				$pic_array[$i]['small']		= $small_pic[0]."_small.".$small_pic[1];
				$pic_array[$i]['ad_info']	= $ad_array['ad_body']['ad_info'][$i];
				$i++;
			}
		}
		unset($pic_array[5]);
		/*url*/
		$ad_array['ad_url'] = unserialize($ad_array['ad_url']);
		for ($j=0;$j<5;$j++){
			$pic_array[$j]['url'] = $ad_array['ad_url'][$j];
		}
		$this->output('pic_array',$pic_array);
		$this->output('ad_array',$ad_array);

		/*友情链接*/
		$link_image	= $this->obj_link->getLinkList(array('link_logo'=>1),'','link_web_name,link_url,link_logo,link_logo_width,link_logo_height');
		$this->output('link_image',$link_image);
		$link_text	= $this->obj_link->getLinkList(array('link_logo'=>2),'','link_web_name,link_url');
		$this->output('text_link_num',count($link_text));
		$this->output('link_text',$link_text);

		$this->showpage("index");
	}
}
$index = new ShowIndex();
$index->main();
unset($index);
?>