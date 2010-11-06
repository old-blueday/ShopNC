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
 * FILE_NAME : own_score.php   FILE_PATH : \multishop\member\own_score.php
 * ....评价管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Thu Oct 18 14:03:51 CST 2007
 */
require ("../global.inc.php");

class OwnScoreManage extends memberFrameWork {
	/**
	 * 评价对象
	 *
	 * @var obj
	 */
	var $obj_score;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 商品订单对象
	 *
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
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
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;

	function main() {
		/**
		 * 创建评价对象
		 */
		if (! is_object ( $this->obj_score )) {
			require_once ("score.class.php");
			$this->obj_score = new ScoreClass ( );
		}
		/**
		 * 创建验证对象
		 */
		if (! is_object ( $this->objvalidate )) {
			require_once ("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate ( );
		}
		/**
		 * 创建商品订单对象
		 */
		if (! is_object ( $this->obj_product_order )) {
			require_once ("order.class.php");
			$this->obj_product_order = new ProductOrderClass ( );
		}
		/**
		 * 创建会员对象
		 */
		if (! is_object ( $this->obj_member )) {
			require_once ("member.class.php");
			$this->obj_member = new MemberClass ( );
		}
		/**
		 * 创建商品对象
		 */
		if (! is_object ( $this->obj_product )) {
			require_once ("product.class.php");
			$this->obj_product = new ProductClass ( );
		}

		/**
		 * 语言包
		 */
		$this->getlang ( "score" );

		/**
		 * 菜单输出
		 */
		$this->memberMenu('account','appraise_manage','appraise_list');

		switch ($this->_input ['action']) {
			case "add" :
				$this->_addScore ();
				break;
			case "save" :
				$this->_saveScore ();
				break;
			default :
				$this->_getScore ();
		}
	}

	/**
	 * 进行评价
	 *
	 */
	function _addScore() {
		/**
		 * 验证参数
		 */
		$this->objvalidate->validateparam = array (array ("input" => $this->_input ["orderid"], "require" => "true", "message" => $this->_lang ['langSErrAddress'] ), array ("input" => $this->_input ["type"], "require" => "true", "message" => $this->_lang ['langSErrAddress'] ) );
		$error = $this->objvalidate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			/**
			 * 被评价的商品信息
			 */
			$product_order_array = $this->obj_product_order->getOneOrder ( $this->_input ["orderid"] );

			$member_array = array ();

			if ($this->_input ["type"] == "bought") { //买家对卖家进行评价
				$return_url = 'own_order.php?action=bought';
				if ($product_order_array ['buyer_id'] != $_SESSION ['s_login'] ['id']) { //判断会员是否属于该订单
					$this->redirectPath ( "error", $return_url, $this->_lang ['langScoreMemberNoPowerSet'] );
				}
				if ($product_order_array ['buy_have_comment'] == '1') {
					$this->redirectPath ( "error", $return_url, $this->_lang ['langScoreMemberHaveCommented'] );
				}
				$page_title = $this->_lang ['langSBuyScore'];
				$condition ['id'] = $product_order_array ['seller_id'];
				$member_array = $this->obj_member->getMemberInfo ( $condition );
				$score_genre = "b";
			} else if ($this->_input ["type"] == "sold") { //卖家对买家进行评价
				$return_url = 'own_order.php?action=sold';
				if ($product_order_array ['seller_id'] != $_SESSION ['s_login'] ['id']) { //判断会员是否属于该订单
					$this->redirectPath ( "error", $return_url, $this->_lang ['langScoreMemberNoPowerSet'] );
				}
				if ($product_order_array ['sole_have_comment'] == '1') {
					$this->redirectPath ( "error", $return_url, $this->_lang ['langScoreMemberHaveCommented'] );
				}
				$page_title = $this->_lang ['langSSaleScore'];
				$condition ['id'] = $product_order_array ['buyer_id'];
				$member_array = $this->obj_member->getMemberInfo ( $condition );
				$score_genre = "s";
			}

			$product_order_array ['member_name'] = $member_array ['login_name'];
			$product_order_array ['member_id'] = $member_array ['member_id'];
			$product_order_array ['genre'] = $score_genre;

			/*判断是否使用静态链接*/
			$product_order_array = $this->obj_product->checkOneProductIfHtml($product_order_array,$this->_configinfo['productinfo']['ifhtml']);

			/**
			 * 页面输出
			 */
			$this->output ( 'product_array', $product_order_array );
			$this->output ( 'orderid', $this->_input['orderid'] );
			$this->output ( 'rdoScore', Common::showForm_Radio ( "score", "", $this->_b_config ['grade_score'], '1' ) );
			$this->output ( 'page_title', $page_title );
			$this->showpage ( 'own_score.add' );
		}
	}

	/**
	 * 将评价存放到数据库中
	 *
	 */
	function _saveScore() {
		/**
		 * 验证参数
		 */
		$this->objvalidate->validateparam = array (
		array ("input" => $this->_input ["orderid"], "require" => "true", "message" => $this->_lang ['langSErrAddress'] ),
		array ("input" => $this->_input ["genre"], "require" => "true", "message" => $this->_lang ['langSErrAddress'] )
		);
		$error = $this->objvalidate->validate ();
		if ($error != "") {
			$this->redirectPath ( "error", "", $error );
		} else {
			/**
			 * 被评价的商品信息
			 */
			$product_order_array = $this->obj_product_order->getOneOrder ( $this->_input ["orderid"] );
			if ($this->_input ["genre"] == "b") {
				$credits_member_id = $product_order_array ['seller_id'];
				$err_url = 'own_order.php?action=bought';
				$return_url = 'member/own_order.php?action=bought';
				if ($product_order_array ['buyer_id'] != $_SESSION ['s_login'] ['id']) { //判断会员是否属于该订单
					$this->redirectPath ( "error", $err_url, $this->_lang ['langScoreMemberNoPowerSet'] );
				}
				if ($product_order_array ['buy_have_comment'] == '1') {
					$this->redirectPath ( "error", $err_url, $this->_lang ['langScoreMemberHaveCommented'] );
				}
				$this->_input ['memberid'] = $product_order_array ['buyer_id'];
				$this->_input ['gradememberid'] = $product_order_array ['seller_id'];
				$this->_input ["genre"] = "s";
			} else if ($this->_input ["genre"] == "s") {
				$credits_member_id = $product_order_array ['buyer_id'];
				$err_url = 'member/own_order.php?action=sold';
				$return_url = 'member/own_order.php?action=sold';
				if ($product_order_array ['seller_id'] != $_SESSION ['s_login'] ['id']) { //判断会员是否属于该订单
					$this->redirectPath ( "error", $err_url, $this->_lang ['langScoreMemberNoPowerSet'] );
				}
				if ($product_order_array ['sole_have_comment'] == '1') {
					$this->redirectPath ( "error", $err_url, $this->_lang ['langScoreMemberHaveCommented'] );
				}
				$this->_input ['memberid'] = $product_order_array ['seller_id'];
				$this->_input ['gradememberid'] = $product_order_array ['buyer_id'];
				$this->_input ["genre"] = "b";
			}

			//判断支付方式类型
			if (file_exists ( BasePath . '/payment/' . $product_order_array ['sp_pay_mechod'] . '/payment_module.php' )) {
				require_once (BasePath . '/payment/' . $product_order_array ['sp_pay_mechod'] . '/payment_module.php');
				$class_name = $product_order_array ['sp_pay_mechod'] . 'PaymentMethod';
				$obj_payment = new $class_name ( );
				$param_array = $obj_payment->payment_param ();
				if ($param_array ['type'] == 'vouch') { //担保型
					$this->_input ['score_pay_type'] = 1;
				}
				if ($param_array ['type'] == 'instant') { //即时型
					$this->_input ['score_pay_type'] = 2;
				}
				if ($param_array ['type'] == 'offline') { //线下型
					$this->_input ['score_pay_type'] = 3;
				}
			}else {
				$this->_input ['score_pay_type'] = 1;
			}

			/**
			 * 存放评价并更改订单的评价状态
			 */
			if ($this->obj_score->addScore ( $this->_input ) == true) {
				$this->obj_product_order->updateProductOrderCommentState ( $this->_input ["orderid"], $this->_input ["genre"] );
				$this->obj_member->updateMemberScore ( $this->_input ["genre"], $this->_input ['score'], $this->_input ['gradememberid'] );
				switch ($this->_input['score']){
					case '1':
						CreditsClass::saveCreditsLog('good_score',$credits_member_id);
						break;
					case '0':
						CreditsClass::saveCreditsLog('normal_score',$credits_member_id);
						break;
					case '-1':
						CreditsClass::saveCreditsLog('bad_score',$credits_member_id);
						break;
				}

				//UC推送
				if($this->makeFeed('commentstore')) {
					//获取商铺信息
					require_once 'shop.class.php';
					$objShop = new ShopClass();
					$shop_array = $objShop->getOneShop($product_order_array['seller_id'],1);
					if(empty($shop_array['shop_pic'])) {
						$shop_array['shop_pic'] = '/templates/'.$this->_configinfo['website']['templatesname'].'/home/images/images_new/storepic_default.gif';
					}else {
						$shop_array['shop_pic'] = $this->_configinfo['websit']['site_url'].$shop_array['shop_pic'];
					}
					$subject_url = $this->_configinfo['websit']['site_url'].'/store/index.php?userid='.$product_order_array['seller_id'];

					$feed_param = array();
					$feed_param['icon'] = 'profile';
					$feed_param['uid'] = $_SESSION['s_login']['id'];
					$feed_param['username'] = $_SESSION['s_login']['name'];
					$feed_param['icon'] = 'profile';
					$feed_param['title_template'] = '{actor} '.$this->_lang['langPScoreUC'].' {subject}';
					$feed_param['title_data'] = array('subject'=>'&nbsp;<a href="'.$subject_url.'">'.$shop_array['shop_name'].'</a>');
					$feed_param['iamges']	= array(array('url'=>$shop_array['shop_pic'],'link'=>$subject_url));
					require_once('ucenter.class.php');
					$objUcenter = new ucenterClass();
					$objUcenter->uc_feed($feed_param);
					unset($objUcenter);unset($objShop);
				}
			}

			/**
			 * 网站提醒操作
			 */
			if (! is_object ( $this->obj_remind )) {
				require_once ('remind.class.php');
				$this->obj_remind = new RemindClass ( );
			}
			$condition ['id'] = $this->_input ['gradememberid'];
			$member_array = $this->obj_member->getMemberInfo ( $condition );

			$value_array = array ();
			$value_array ['username'] = $member_array ['login_name'];
			$value_array ['product_name'] = $product_order_array ['p_name'];
			$this->obj_remind->setMessageOrMail ( 'score_have_notice', 'score_have_notice', $value_array, $member_array ['login_name'], $this->_configinfo );


			/**
			 * 整合X 同步信用信息
			 */
			if(DISCUZ === true){
				require_once('x.class.php');
				$obj_x = new XClass();
				$obj_x->updateScore($this->_input["genre"], $this->_input['score'], $this->_input['gradememberid']);
				unset($obj_x);
			}


			$this->redirectPath ( "succ", $return_url, $this->_lang ['langScoreOk'] );
		}
	}

	/**
	 * 评价管理
	 */
	function _getScore() {
		/**
		 * 创建分页对象
		 */
		if (! is_object ( $this->obj_page )) {
			require_once ("commonpage.class.php");
			$this->obj_page = new CommonPage ( );
		}
		/**
		 * 取会员资料信息
		 */
		$condition_member ['id'] = $_SESSION ['s_login'] ['id'];
		$member_array = $this->obj_member->getMemberInfo ( $condition_member, '*', 'more' );
		/**
		 * 取该会员买家和卖家信用信息
		 */
		$condition = array();
		$condition['grade_member_id'] = $_SESSION ['s_login'] ['id'];
		$score_list =  $this->obj_score->getScore( $condition, $page );
		unset($condition);
		/**
		 * 区分买家和卖家信用
		 */
		$sell_score = array();
		$buy_score = array();
		if (is_array($score_list)){
			foreach ($score_list as $k => $v){
				switch ($v['genre']){
					case 's':
						$sell_score[] = $v;
						break;
					case 'b':
						$buy_score[] = $v;
						break;
				}
			}
		}
		//统计卖家信用
		$sell_sta = $this->obj_score->getCountUserScore($sell_score);
		//统计买家信用
		$buy_sta = $this->obj_score->getCountUserScore($buy_score);
		//得到会员等级
		$buy_score_level = $this->obj_member->creditLevel($member_array['buy_score']);
		$sell_score_level = $this->obj_member->creditLevel($member_array['sale_score']);
		$condition_list['score'] = $this->_input['score'];//评价等级
		$condition_list['time'] = $this->_input['time'];//评价时间
		switch ($this->_input['time']) {
			case 'week'://最近1周
			$time = $this->_lang['langScoreLatelyOneWeek'];
			break;
			case 'month'://最近1个月
			$time = $this->_lang['langScoreLatelyOneMonth'];
			break;
			case 'six_month'://最近6个月
			$time = $this->_lang['langScoreLatelySixMonth'];
			break;
			case 'former_six_month'://6个月前
			$time = $this->_lang['langScoreSixMonthFormer'];
			break;
		}
		switch ($this->_input['score']) {
			case '1':
				$score_type = $this->_lang['langScoreReputably'];
				break;
			case '0':
				$score_type = $this->_lang['langScoreMiddlingReputably'];
				break;
			case '-1':
				$score_type = $this->_lang['langScoreDifferenceReputably'];
				break;
			default:
				$score_type = $this->_lang['langScore'];
		}
		if ($this->_input['genre'] == 's') {
			$genre_type = $this->_lang['langSetScoreByBuyer'];
		} else {
			$genre_type = $this->_lang['langSetScoreBySeller'];
		}
		//评价列表
		$this->obj_page->pagebarnum ( 15 );
		if ($this->_input ['genre'] !== '' && $this->_input ['genre'] !== 'set') { //评价类型
			$condition_list ['genre'] = $this->_input ['genre'];
			$condition_list ['grade_member_id'] = $_SESSION ['s_login'] ['id']; //被评价人
		} else if ($this->_input ['genre'] == 'set') { //给他人的评价
			$condition_list ['member_id'] = $_SESSION ['s_login'] ['id']; //评价人
		} else {
			$condition_list ['grade_member_id'] = $_SESSION ['s_login'] ['id']; //被评价人
		}
		$condition_list ['score'] = $this->_input ['score']; //评价等级
		$condition_list['order_by'] = 'score.pubtime desc';//按照时间降序
		$score_array = $this->obj_score->getScore ( $condition_list, $this->obj_page );
		if (is_array ( $score_array )) {
			foreach ( $score_array as $k => $v ) {
				$score_array [$k] ['pubtime'] = @date ( "Y-m-d H:i", $v ['pubtime'] );
			}
		}
		$score_array = $this->obj_product->checkProductIfHtml ( $score_array, $this->_configinfo ['productinfo'] ['ifhtml'] );
		$this->obj_page->new_style = true;
		$pagelist = $this->obj_page->show ( 'member' ); //分页显示
		/**
		 * 页面输出
		 */
		$this->output ( 'sale_count', @array_sum ( $sell_sta ) ); /*卖家数量统计*/
		$this->output ( 'buy_count', @array_sum ( $buy_sta ) ); /*买家数量统计*/
		$this->output ( 'score_array', $score_array ); /*评价列表*/
		$this->output ( 'pagelist', $pagelist ); /*输出消息分页*/
		$this->output ( 'genre', $this->_input ['genre'] ); /*评价条件-买家或卖家*/
		$this->output ( 'score', $this->_input ['score'] ); /*评价条件-评价等级，好评-中评-差评*/
		$this->output ( 'member_array', $member_array ); //会员资料
		$this->output ( 'sell_sta', $sell_sta ); //卖家信誉统计
		$this->output ( 'buy_sta', $buy_sta ); //买家信誉统计
		$this->output('buy_score_level',$buy_score_level);//买家等级
		$this->output('sell_score_level',$sell_score_level);//卖家等级
		$this->output('time',$time);//选择时间
		$this->output('score_type',$score_type);//评价类型
		$this->output('genre_type',$genre_type);//买、卖家
		$this->showpage ( 'own_score.manage' );
	}

}
$score_manage = new OwnScoreManage ( );
$score_manage->main ();
unset ( $score_manage );
?>