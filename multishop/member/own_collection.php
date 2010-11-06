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
 * FILE_NAME : own_collection.php   FILE_PATH : \multishop\member\own_collection.php
 * ....用户收藏管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Sat Sep 15 16:01:39 CST 2007
 */

require_once("../global.inc.php");

class OwnCollectionManage extends memberFrameWork{
	/**
	 * 收藏对象
	 *
	 * @var obj
	 */
	var $obj_collection;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;

	function main(){
		/**
		 * 创建收藏对象
		 */
		if (!is_object($this->obj_collection)){
			require_once("collection.class.php");
			$this->obj_collection = new CollectionClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("collection");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('buyer','my_buyer','my_collection');

		switch($this->_input['action']){
			case "new":
				$this->saveCollection();
				break;
			case "save":
				$this->saveCollection();
				break;
			case "aj_del":
				$this->_aj_delCollection();
				break;
			case "delete":
				$this->_delCollection();
				break;
			default:
				$this->_getCollectionList();
		}
	}

	/**
	 * 收藏商店显示页面
	 *
	 */
	function _storeCollection(){
		/**
		 * 页面输出
		 */
		$this->output('collection_genre',   $this->_input['genre']);
		$this->output('collection_id',   $this->_input['collection']);
		$this->showpage("own_collection.store");
	}

	/**
	 * 保存收藏
	 *	$this->_input['collection'] 会员ID
	 */
	function saveCollection(){
		//您尚未登陆
		if($_SESSION['s_login']['login'] != 1){
			echo "-1";
			exit;
		}

		/**
		 * genre==store collection为会员id
		 * genre==product seller_id为会员id collection为商品id
		 */
        if(!in_array($this->_input['genre'],array('store','product'))) {
            echo "0";exit;
        }

        //是否UC推送
        $isUc = $this->makeFeed('collection'.str_replace('product','goods',$this->_input['genre']));
        //组成feed推送数组
        $feed_param = array();
        if($isUc) {
            $subject_url = $this->_configinfo['websit']['site_url'].'/';

            define('UC_APPID',$this->_configinfo['ucenter']['uc_appid']);
            $feed_param['icon'] = 'profile';
            $feed_param['uid'] = $_SESSION['s_login']['id'];
            $feed_param['username'] = $_SESSION['s_login']['name'];
            $feed_param['title_template'] = '{actor} '.$this->_lang['langColled'.ucfirst(strtolower($this->_input['genre']))].' {subject}';
        }

		if ($this->_input['genre'] == 'store'){
			//自己不成收藏自己
			if ($_SESSION["s_login"]['id'] == $this->_input['collection']){
				echo "0";
				exit;
			}

            //获取店铺记录
            require_once('shop.class.php');
            $objShop = new ShopClass();
            $colledRow = $objShop->getOneShop($this->_input['collection'],1);
            unset($objShop);
		}
		if ($this->_input['genre'] == 'product'){
			//自己不成收藏自己
			if ($_SESSION["s_login"]['id'] == $this->_input['seller_id']){
				echo "0";
				exit;
			}

            //获取商品记录
            require_once('product.class.php');
            $objProduct = new ProductClass();
            $colledRow = $objProduct->getProductRowById($this->_input['collection']);
            unset($objProduct);
		}
		$this->_input['memberid'] = $_SESSION["s_login"]['id'];
		$result = $this->obj_collection->addCollection($this->_input);
		if ($result == false){
			echo "2";   //已经收藏过了
		}else{
			echo "1";   //收藏成功

            //推送到UC
            if($isUc) {
                require_once 'ucenter.class.php';
                if('product' == $this->_input['genre']) {
                    $pic = empty($colledRow['p_pic']) ? $this->_configinfo['websit']['site_url'].'/'.'templates/orange/images/noimgb.gif' : $subject_url.$colledRow['p_pic'];
                    $subject_url .= 'home/product.php?action=view&pid='.$colledRow['p_code'];
                    $name = $colledRow['p_name'];
                } else {
                    if(empty($colledRow['shop_pic'])) {
                        $pic = $subject_url.'templates/'.$this->_configinfo['websit']['templatesname'].'/home/images/images_new/storepic_default.gif';
                    } else {
                        $pic = $subject_url.$colledRow['shop_pic'];
                    }
                    $subject_url .= 'store/index.php?userid='.$this->_input['collection'];
                    $name = $colledRow['shop_name'];
                }

                $feed_param['title_data'] = array('subject'=>'&nbsp;<a href="'.$subject_url.'">'.$name.'</a>');
				$feed_param['images']	  = array(array('url'=>$pic,'link'=>$subject_url));

                unset($colledRow);
                $obj_ucenter = new ucenterClass();
                $obj_ucenter->uc_feed($feed_param);
                unset($obj_ucenter);
            }
		}
	}

	/**
	 * 收藏列表
	 *
	 */
	function _getCollectionList(){
		if ($this->_input['genre'] == "") {
			$this->_input['genre'] = "store";
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}

		$this->obj_page->pagebarnum(20);    //每页20条记录
		$collection_array = $this->obj_collection->getCollection($this->obj_page,$_SESSION["s_login"]['id'],$this->_input['genre']);
		$this->obj_page->new_style = true;
		$pagelist = $this->obj_page->show('member');      //分页显示
		switch ($this->_input['genre']){
			case 'product':
				/**
				 * 商品出售类别
				 */
				if (is_array($collection_array)){
					foreach ($collection_array as $k => $v){
						$collection_array[$k]['p_sell_type'] = $this->_b_config['p_sell_type'][$v['p_sell_type']];
					}
				}
				break;
		}
		/**
		 * 页面输出
		 */
		$this->output('collection_array',$collection_array);
		$this->output('pagelist', $pagelist);
		$this->output('genre', $this->_input['genre']);
		if ($this->_input['genre'] == 'store'){
			$this->showpage("own_collection.store");
		}else {
			$this->showpage("own_collection.product");
		}
	}

	/**
	 * 删除收藏
	 *
	 */
	function _delCollection(){
		if (intval($this->_input["collectionid"]) > 0){
			$resutl = $this->obj_collection->deleteOperateCollection(intval($this->_input["collectionid"]),$_SESSION["s_login"]['id']);
		}
		if ($resutl !== true){
			$this->redirectPath("succ","member/own_collection.php?genre=" . $this->_input['genre'],'删除收藏失败');
		}else {
			$this->redirectPath("succ","member/own_collection.php?genre=" . $this->_input['genre'],$this->_lang['langCollDelCollectionOk']);
		}
	}

	/**
	 * aj 删除收藏
	 */
	function _aj_delCollection(){
		if (intval($this->_input["collection"]) > 0){
			$this->obj_collection->deleteCollection(intval($this->_input["collection"]),$_SESSION["s_login"]['id'],$this->_input['genre']);
			echo '1';exit;
		}
	}
}
$collection_manage = new OwnCollectionManage();
$collection_manage->main();
unset($collection_manage);
?>