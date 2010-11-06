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
 * FILE_NAME : recommend.php   FILE_PATH : \multishop\home\recommend.php
 * ....书写本页代码的说明
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Nov 27 16:00:00 CST 2007
 */

require ("../global.inc.php");

class ShowRecommend extends CommonFrameWork{
	/**
	 * 邮件对象
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
			case "send":
				$this->_sendRecommendMail();
				break;
			default:
				$this->_displayRecommendForm();
				break;
		}
	}

	/**
	 * 推荐页面
	 *
	 */
	function _displayRecommendForm(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>strtoupper($this->_input['pid']),"require"=>"true","message"=>$this->_lang['langPScommendedIsFail'])
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 获得用户信息
			 */
			if (!is_object($this->obj_member)){
				require_once ("member.class.php");
				$this->obj_member = new MemberClass();
			}
			$member_info = $this->obj_member->getMemberInfo(array("id"=>$_SESSION['s_login']['id']),'member_id,login_name,email');
			/**
			 * 取得商品信息
			 */
			if (!is_object($this->obj_product)){
				require_once("product.class.php");
				$this->obj_product = new ProductClass();
			}
			$product_row = $this->obj_product->getProductRow($this->_input['pid']);

			$this->output("product_info", $product_row);
			$this->output("member_info", $member_info);
			$this->showpage('recommend.mail');
		}

	}


	/**
	 * 发送推荐邮件
	 */
	function _sendRecommendMail(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["reciemail1"],"require"=>"true","message"=>$this->_lang['errMakeEmail'])
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
		    	 * 创建网站邮件发送内容信息对象
		    	 */
			if (!is_object($this->obj_content)){
				require_once("mailcontent.class.php");
				$this->obj_content = new MailContentClass();
			}
			$content = $this->obj_content->getMailContent("recommendmail");
			
			if ($content['mail_id']){
				/**
					 * 获得商品信息
					 */
				if (!is_object($this->obj_product)){
					require_once("product.class.php");
					$this->obj_product = new ProductClass();
				}
				$product_array = $this->obj_product->getProductRow($this->_input['pcode']);

				/**
					 * 获得用户信息
					 */
				if (!is_object($this->obj_member)){
					require_once ("member.class.php");
					$this->obj_member = new MemberClass();
				}
				$seller_info = $this->obj_member->getMemberInfo(array("id"=>$product_array['member_id']),'member_id,login_name,buy_score,sale_score','more');

				/**
		         * 创建发送邮件对象
		         */
				if (!is_object($this->obj_sendmail)){
					require_once("sendmailer.class.php");
					$this->obj_sendmail = new SendMailer($this->_configinfo['websit']['site_title'], $this->_configinfo['websit']['smtpemail'], 1, $this->_configinfo['websit']['smtpserver'], '25', $this->_configinfo['websit']['smtpuser'], $this->_configinfo['websit']['smtppass']);
				}

				if($this->_input['reciemail1'] != ""){
					$param = array(
					'receive_name'=>$this->_input['reciname1'],
					'product_name'=>$product_array['p_name'],
					'product_price'=>$product_array['p_price'],
					'product_url'=>$this->_configinfo['websit']['site_url'] . "/home/product.php?action=view&pid=" . $product_array['p_code'],
					'product_pic'=>$this->_configinfo['websit']['site_url'] . "/" . $product_array['p_pic'],
					'website'=>$this->_configinfo['websit']['site_title'],
					'site_url'=>$this->_configinfo['websit']['site_url'],
					'user_info'=>$this->_configinfo['websit']['site_url'] . "/store/userinfo.php?userid=" . $product_array['member_id'],
					'seller_name'=>$seller_info['login_name'],
					'seller_score'=>$seller_info['sale_score'],
					'buyer_score'=>$seller_info['buy_score'],
					'content'=>$this->_input['content']
					);
					$mailcontent['content'] = Common::replaceMailContent($param,$content['content']);   //将发信内容的变量换为值
					$content['title'] = $this->_input['title'];       //将发信标题的变量换为值
					$this->obj_sendmail->send($this->_input['reciemail1'].",".$this->_configinfo['websit']['smtpemail'],$content['title'],$mailcontent['content'], $this->_configinfo['websit']['ncharset'], 1);//发信
				}
				if($this->_input['reciemail2'] != ""){
					$param2 = array(
					'receive_name'=>$this->_input['reciname2'],
					'product_name'=>$product_array['p_name'],
					'product_price'=>$product_array['p_price'],
					'product_url'=>$this->_configinfo['websit']['site_url'] . "/home/product.php?action=view&pid=" . $product_array['p_code'],
					'product_pic'=>$this->_configinfo['websit']['site_url'] . "/" . $product_array['p_pic'],
					'website'=>$this->_configinfo['websit']['site_title'],
					'site_url'=>$this->_configinfo['websit']['site_url'],
					'user_info'=>$this->_configinfo['websit']['site_url'] . "/store/userinfo.php?userid=" . $product_array['member_id'],
					'seller_name'=>$seller_info['login_name'],
					'seller_score'=>$seller_info['sale_score'],
					'buyer_score'=>$seller_info['buy_score'],
					'content'=>$this->_input['content']
					);
					$mailcontent['content'] = Common::replaceMailContent($param2,$content['content']);   //将发信内容的变量换为值
					$content['title'] = $this->_input['title'];       //发信标题
					$this->obj_sendmail->send($this->_input['reciemail2'].",".$this->_configinfo['websit']['smtpemail'],$content['title'],$mailcontent['content'], $this->_configinfo['websit']['ncharset'], 1);//发信
				}
				if($this->_input['reciemail3'] != ""){
					$param3 = array(
					'receive_name'=>$this->_input['reciname3'],
					'product_name'=>$product_array['p_name'],
					'product_price'=>$product_array['p_price'],
					'product_url'=>$this->_configinfo['websit']['site_url'] . "/home/product.php?action=view&pid=" . $product_array['p_code'],
					'product_pic'=>$this->_configinfo['websit']['site_url'] . "/" . $product_array['p_pic'],
					'website'=>$this->_configinfo['websit']['site_title'],
					'site_url'=>$this->_configinfo['websit']['site_url'],
					'user_info'=>$this->_configinfo['websit']['site_url'] . "/store/userinfo.php?userid=" . $product_array['member_id'],
					'seller_name'=>$seller_info['login_name'],
					'seller_score'=>$seller_info['sale_score'],
					'buyer_score'=>$seller_info['buy_score'],
					'content'=>$this->_input['content']
					);
					$mailcontent['content'] = Common::replaceMailContent($param3,$content['content']);   //将发信内容的变量换为值
					$content['title'] = $this->_input['title'];       //发信标题
					$this->obj_sendmail->send($this->_input['reciemail3'].",".$this->_configinfo['websit']['smtpemail'],$content['title'],$mailcontent['content'], $this->_configinfo['websit']['ncharset'], 1);//发信
				}
			}
			$this->redirectPath("succ","home/product.php?action=view&pid=" . $this->_input['pcode'], $this->_lang['alertCommendOk']);

		}
	}

}

$recommend = new ShowRecommend();
$recommend->main();
unset($recommend);
?>