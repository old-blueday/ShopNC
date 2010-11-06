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
 * FILE_NAME : productmessage.php   FILE_PATH : \multishop\home\productmessage.php
 * ....商品留言页面
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Fri Oct 12 18:40:01 CST 2007
 */

require ("../global.inc.php");

class ShowProductMessage extends CommonFrameWork{
	/**
	 * 留言对象
	 *
	 * @var obj
	 */
	var $obj_message;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 网站提醒对象
	 *
	 * @var obj
	 */
	var $obj_remind;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;

	function main(){
		/**
		 * 创建留言对象
		 */
		if (!is_object($this->obj_message)){
			require_once("productmessage.class.php");
			$this->obj_message = new ProductMessageClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}

		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 语言包
		 */
		$this->getlang("product");

		switch($this->_input['action']){
			case "save":
				$this->_saveMessage();
				break;
			case "re":
				$this->_reMessage();
				break;
			case "resave":
				$this->_saveReMessage();
				break;
			case "del":
				$this->_delMessage();
				break;
		}
	}

	/**
	 * 保存留言
	 *
	 */
	function _saveMessage(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
			array("input"=>strtoupper($this->_input['code']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['errProductMCode']),
			array("input"=>$this->_input["txtMessage"],"require"=>"true","message"=>$this->_lang['errMakeGuestBookContent']),
			array("input"=>$_SESSION['s_login']['name'],"require"=>"true","message"=>$this->_lang['errCNoLogin']),
			array("input"=>$this->_input['hideproductID'],"require"=>"true","message"=>$this->_lang['errProductId']),
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 网站提醒操作
			 */
			if (!is_object($this->obj_remind)){
				require_once('remind.class.php');
				$this->obj_remind = new RemindClass();
			}
			/**
			 * 创建商品对象
			 */
			if (!is_object($this->obj_product)){
				require_once("product.class.php");
				$this->obj_product = new ProductClass();
			}
			/**
			 * 创建会员对象
			 */
			if (!is_object($this->obj_member)){
				require_once("member.class.php");
				$this->obj_member = new MemberClass();
			}

			//取商品信息
			$product_array = $this->obj_product->getProductRowById($this->_input['hideproductID']);
			if (!empty($product_array)){
				if ($product_array['member_id'] == $_SESSION['s_login']['id']) {
					$this->redirectPath("error","",$this->_lang['langPMessageSelfError']);
				}
				//取会员信息
				$condition['id'] = $product_array['member_id'];
				$member_array = $this->obj_member->getMemberInfo($condition);
				$this->_input['seller_name'] = $member_array['login_name'];
				unset($condition);
				//提醒设置
				$value_array = array();
				$value_array['username'] = $member_array['login_name'];
				$value_array['product_name'] = $product_array['p_name'];
				$this->obj_remind->setMessageOrMail('sale_message_product','message_product',$value_array,$member_array['login_name'],$this->_configinfo);//买家给我的宝贝留言时，请通知我
				unset($value_array);
				//将留言内容存放到数据库中
				$this->_input['MemberName'] = $_SESSION['s_login']['name'];
				$this->obj_message->addMessage($this->_input);
				$this->redirectPath("succ","",$this->_lang['alertGuestBookOk']);
			}else {
				$this->redirectPath("error","",$this->_lang['errPProductIsEmpty']);
			}
		}
	}

	/**
	 * 回复留言
	 *
	 */
	function _reMessage(){

		$message_array = $this->obj_message->getOneMessage($this->_input['messageid'],$_SESSION['s_login']['id']);    //得到某条留言内容
		$message_array[0]['message_time'] = date("Y-m-d H:i",$message_array[0]['message_time']);
		$this->output('message_array',$message_array[0]);   //输出留言内容
		$this->showpage('productmessage.re');
	}

	/**
	 * 回复留言存放到数据库中
	 *
	 */
	function _saveReMessage(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["txtReMessage"],"require"=>"true","message"=>$this->_lang['errMakeRevertContent'])
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			$exist_array = array('messageid'=>$this->_input['hideMessageID'],'productid'=>$this->_input['hideproductID'],'memberid'=>$_SESSION['s_login']['id']);
			if ($this->obj_message->isExistMessage($exist_array)){
				$this->obj_message->reMessage($this->_input);   //将留言内容存放到数据库中

				/**
				 * 网站提醒操作
				 */
				if (!is_object($this->obj_remind)){
					require_once('remind.class.php');
					$this->obj_remind = new RemindClass();
				}
				/**
				 * 创建商品对象
				 */
				if (!is_object($this->obj_product)){
					require_once("product.class.php");
					$this->obj_product = new ProductClass();
				}
				/**
				 * 创建会员对象
				 */
				if (!is_object($this->obj_member)){
					require_once("member.class.php");
					$this->obj_member = new MemberClass();
				}

				/**
				 * 取商品信息
				 */
				$product_array = $this->obj_product->getProductRowById($this->_input['hideproductID']);
				if (!empty($product_array)){
					//留言信息
					$message_array = $this->obj_message->getOneMessage($this->_input['hideMessageID'],$_SESSION['s_login']['id']);
					$value_array = array();
					$value_array['username'] = $message_array['member_name'];
					$value_array['product_name'] = $product_array['p_name'];
					$this->obj_remind->setMessageOrMail('buyer_message_seller_product_answer','message_seller_product_answer',$value_array,$message_array['member_name'],$this->_configinfo);//我在宝贝上的留言被卖家回复时，请通知我

					/*判断是否使用静态链接*/
					$html_array[0]['pc_id'] = $product_array['pc_id'];
					$html_array[0]['p_code'] = $this->_input['pid'];
					$html_array = $this->obj_product->checkProductIfHtml($html_array,$this->_configinfo['productinfo']['ifhtml']);
					/**
					 * 判断跳转连接
					 */
					switch ($product_array['p_sell_type']){
						/**
						 * 拍卖
						 */
						case '0':
							$sell_type = "product_auction.php";
							break;
						/**
						 * 一口价
						 */
						case '1':
							$sell_type = "product_fixprice.php";
							break;
						/**
						 * 团购
						 */
						case '2':
							$sell_type = "product_group.php";
							break;
						/**
						 * 倒计时拍卖
						 */
						case '3':
							$sell_type = "product_countdown.php";
							break;
					}
					if ($html_array[0]['html_url'] != ""){
						$html_array[0]['html_url'] = str_replace("../","./",$html_array[0]['html_url']);
						$this->redirectPath("succ",$html_array[0]['html_url'],$this->_lang['alertRevertGuestBookOk']);
					}else {
						$this->redirectPath("succ","home/".$sell_type."?action=view&p_code=" . $this->_input['pid'],$this->_lang['alertRevertGuestBookOk']);
					}
				}else {
					$this->redirectPath("error","",$this->_lang['errPProductIsEmpty']);
				}
			}else{
				$this->redirectPath("error","",$this->_lang['errGuestBookNonentity']);
			}
		}
	}

	/**
	 * 删除留言
	 *
	 */
	function _delMessage(){
		$this->obj_message->deleteOperateMessage($this->_input['messageid'],$_SESSION['s_login']['id']);
		$this->redirectPath("error","",$this->_lang['alertDelGuestBookOk']);
	}
}

$productmessage = new ShowProductMessage();
$productmessage->main();
unset($productmessage);
?>