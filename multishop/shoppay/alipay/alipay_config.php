<?php
/*
	*功能：设置帐户有关信息及返回路径
	*版本：2.0
	*日期：2008-08-01
	'说明：
	'以下代码只是方便商户测试，提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/
require ("../../global.inc.php");

class Alipay extends CommonFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 缴费对象
	 *
	 * @var obj
	 */
	var $obj_shop_pay;
	
	function main(){
		//加载语言包
		$this->getlang("own_shop_pay");
		
		if($_SESSION['s_login']['id'] == ''){
			$this->redirectPath("error","",$this->_lang['errShopPayMemberIsEmpty']);
		}
		if ($this->_input['pay_detail_id'] == '' && $this->_input['out_trade_no'] == ''){
			$this->redirectPath("error","",$this->_lang['errShopPayDetailInfoIsEmpty']);
		}
		if ($this->_input['pay_detail_id'] != ''){
			$out_trade_no = $this->_input['pay_detail_id'];
		}elseif ($this->_input['out_trade_no'] != ''){
			$out_trade_no = $this->_input['out_trade_no'];
		}
		
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化缴费类
		 */
		if (!is_object($this->obj_shop_pay)){
			require_once("shop_pay.class.php");
			$this->obj_shop_pay = new shopPayClass();
		}
		
		//取帐号配置文件信息
		$account_array = $this->_getconfigini("payment.ini.php");
		
		//验证信息是否与会员相符
		$detail_array = $this->obj_shop_pay->getShopPayDetail($out_trade_no);
		if ($detail_array['member_id'] != $_SESSION['s_login']['id']){
			$this->redirectPath("error","",$this->_lang['errShopPayDetailInfoIsEmpty']);
		}
		$array = array();
		$array['online_amount'] = $detail_array['pay_mode_money'];//金额
		$array['pay_detail_id'] = $detail_array['pay_detail_id'];//信息ID
		$array['url'] = $this->_configinfo['websit']['site_url'].'/member/own_shop_pay.php?action=detail_list';//查看链接
		$array['email'] = $account_array['online']['alipay'];//系统邮箱
		$array['payment_trade'] = $detail_array['payment_trade'];//交易流水号
		$array['site_url'] = $this->_configinfo['websit']['site_url'];//网站地址
		$array['alipay_partner'] = $account_array['online']['alipay_partner'];//合作伙伴ID
		$array['alipay_security_code'] = $account_array['online']['alipay_security_code'];//安全检验码
		$array['_input_charset'] = $this->_configinfo['websit']['ncharset'];
		if (strtoupper($this->_configinfo['websit']['ncharset']) == 'UTF-8'){
			$this->_lang['langShopPayDetailManage'] = Common::nc_change_charset($this->_lang['langShopPayDetailManage'],'utf8_to_gbk');
		}
		$array['subject'] = $this->_lang['langShopPayDetailManage'];//商品名称
		$array['body'] = $this->_lang['langShopPayDetailManage'];//商品描述
		return $array;
	}

	/**
	 * 接收支付宝的通知
	 */
	 function input_alipay(){
		return $this->_input;
	 }
	
	/**
	 * 更新充值记录交易状态
	 * $out_trade_no 交易编号
	 * $trade_status 交易状态,$out_trade_no,$trade_status
	 */
	function update_record($input){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化缴费类
		 */
		if (!is_object($this->obj_shop_pay)){
			require_once("shop_pay.class.php");
			$this->obj_shop_pay = new shopPayClass();
		}
		
		//充值记录
		$detail_array = $this->obj_shop_pay->getShopPayDetail($input['out_trade_no']);
		if (is_array($detail_array)){
			//更新充值信息
			$value_array = array();
			$value_array['pay_detail_id'] = $input['out_trade_no'];
			$value_array['payment_trade'] = $input['trade_no'];
			$value_array['pay_sign'] = '2';
			$this->obj_shop_pay->updateShopPayDetail($value_array);
			unset($value_array);
			//更新会员信息
			//取会员信息
			$condition_member['id'] = $detail_array['member_id'];
			$member_array = $this->obj_member->getMemberInfo($condition_member,'*','more');
			$value_array = array();
			//判断缴费类型
			switch ($detail_array['pay_mode_type']){
				case '0'://按照店铺使用时间缴费
					/**
					 * 如果会员资料中的店铺到期时间小于当前时间，则按照当前时间计算
					 * 如果时间大于当前时间，则累加会员资料中的到期时间
					 */
					if (time() >= $member_array['shop_availability_time']){
						$value_array['shop_availability_time'] = mktime(23,59,59,date('m'),date('d'),date('Y'))+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}else {
						$pay_time = mktime(23,59,59,date('m',$member_array['shop_availability_time']),date('d',$member_array['shop_availability_time']),date('Y',$member_array['shop_availability_time']));//时间为到期天数的最后一秒
						$value_array['shop_availability_time'] = $pay_time+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}
					break;
				case '1'://按照发布商品数量缴费
					$value_array['product_number'] = $member_array['product_number']+$detail_array['pay_mode_product_number'];
					break;
				case '2'://两者同时缴费
					/**
					 * 如果会员资料中的店铺到期时间小于当前时间，则按照当前时间计算
					 * 如果时间大于当前时间，则累加会员资料中的到期时间
					 */
					if (time() >= $member_array['shop_availability_time']){
						$value_array['shop_availability_time'] = mktime(23,59,59,date('m'),date('d'),date('Y'))+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}else {
						$pay_time = mktime(23,59,59,date('m',$member_array['shop_availability_time']),date('d',$member_array['shop_availability_time']),date('Y',$member_array['shop_availability_time']));//时间为到期天数的最后一秒
						$value_array['shop_availability_time'] = $pay_time+24*60*60*$detail_array['pay_mode_shop_show_time'];
					}
					$value_array['product_number'] = $member_array['product_number']+$detail_array['pay_mode_product_number'];
					break;
			}
			$this->obj_member->modifyMember($value_array,$detail_array['member_id'],"shoppay");
			unset($value_array);
			return true;
		}else {
			echo "ID is void";exit;
		}
	}
}

$alipay_manage = new Alipay();
$array = $alipay_manage->main();

$partner         = $array["alipay_partner"];        //合作伙伴ID
$security_code   = $array["alipay_security_code"];        //安全检验码
$seller_email    = $array['email'];        //卖家支付宝帐户
$_input_charset  = $array['_input_charset'];   //字符编码格式 目前支持 GBK 或 utf-8
$sign_type       = "MD5";     //加密方式 系统默认(不要修改)
$transport       = "https";   //访问模式,你可以根据自己的服务器是否支持ssl访问而选择http以及https访问模式(系统默认,不要修改)
$notify_url      = $array['site_url']."/predeposit_pay/alipay/notify_url.php"; //交易过程中服务器通知的页面 要用 http://格式的完整路径
$return_url      = $array['site_url']."/predeposit_pay/alipay/return_url.php"; //付完款后跳转的页面 要用 http://格式的完整路径
$show_url        = $array['site_url']; //你网站商品的展示地址

/** 提示：如何获取安全校验码和合作ID
1.访问 www.alipay.com，然后登陆您的帐户($seller_email).
2.点商家服务.导航栏的下面可以看到
*/
?>