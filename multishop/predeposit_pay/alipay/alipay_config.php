<?php
/*
	*功能：设置帐户有关信息及返回路径（基础配置页面）
	*版本：3.0
	*日期：2010-06-22
	'说明：
	'以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	'该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

*/

/** 提示：如何获取安全校验码和合作身份者ID
1.访问支付宝首页(www.alipay.com)，然后用您的签约支付宝账号登陆.
2.点击导航栏中的“商家服务”，即可查看

安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
解决方法：
1、检查浏览器配置，不让浏览器做弹框屏蔽设置
2、更换浏览器或电脑，重新登录查询。
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
	 * 预存款对象
	 *
	 */
	var $obj_predeposit;
	/**
	 * 商城账户对象
	 *
	 * @var obj
	 */
	var $obj_pay;
	
	function main(){
		if($_SESSION['s_login']['id'] == ''){
			$this->redirectPath("error","",$this->_lang['langCMemberIsEmpty']);
		}
		if ($this->_input['predeposit_r_id'] == '' && $this->_input['out_trade_no'] == ''){
			$this->redirectPath("error","",$this->_lang['langCIdIsIllegal']);
		}
		if ($this->_input['predeposit_r_id'] != ''){
			$out_trade_no = $this->_input['predeposit_r_id'];
		}elseif ($this->_input['out_trade_no'] != ''){
			$out_trade_no = $this->_input['out_trade_no'];
		}
		
		/**
		 * 加载语言包
		 */
		$this->getlang('own_predeposit');
		
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 初始化预存款类
		 */
		if (!is_object($this->obj_predeposit)){
			require_once("predeposit.class.php");
			$this->obj_predeposit = new PredepositClass();
		}
		
		//取帐号配置文件信息
		$account_array = $this->_getconfigini("payment.ini.php");
		//验证信息是否与会员相符
		$record_array = $this->obj_predeposit->getOnePredepositRecordById($out_trade_no);
		if ($record_array['member_id'] != $_SESSION['s_login']['id']){
			$this->redirectPath("error","",$this->_lang['langCIdIsIllegal']);
		}
		$array = array();
		$array['online_amount'] = $record_array['online_amount'];//金额
		$array['predeposit_r_id'] = $record_array['predeposit_r_id'];//信息ID
		$array['url'] = $this->_configinfo['websit']['site_url'].'/member/own_predeposit.php?action=record_list';//查看链接
		$array['email'] = $account_array['online']['alipay'];//系统邮箱
		$array['payment_trade'] = $record_array['payment_trade'];//交易流水号
		$array['site_url'] = $this->_configinfo['websit']['site_url'];//网站地址
		$array['alipay_partner'] = $account_array['online']['alipay_partner'];//合作伙伴ID
		$array['alipay_security_code'] = $account_array['online']['alipay_security_code'];//安全检验码
		$array['_input_charset'] = $this->_configinfo['websit']['ncharset'];
		if (strtoupper($this->_configinfo['websit']['ncharset']) == 'GB2312'){
			$this->_lang['langPredepositPay'] = Common::nc_change_charset($this->_lang['langPredepositPay'],'gbk_to_utf8');
		}
		$array['subject'] = $this->_lang['langPredepositPay'];
		$array['body'] = $this->_lang['langPredepositPay'];
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
		 * 初始化预存款类
		 */
		if (!is_object($this->obj_predeposit)){
			require_once("predeposit.class.php");
			$this->obj_predeposit = new PredepositClass();
		}
		
		$predeposit_r_id = $input['out_trade_no'];//充值记录
		$record_array = $this->obj_predeposit->getOnePredepositRecordById($predeposit_r_id);
		if (is_array($record_array)){
			//更新充值信息
			$value_array = array();
			$value_array['predeposit_r_id'] = $predeposit_r_id;
			$value_array['payment_trade'] = $input['trade_no'];
			$value_array['record_state'] = '1';
			$this->obj_predeposit->updatePredepositRecord($value_array);
			unset($value_array);
			//增加预付款明细
			$value_array = array();
			$value_array['predeposit_type'] = '0';//会员充值
			$value_array['predeposit_state'] = '1';
			$value_array['member_id'] = $record_array['member_id'];
			$value_array['available_amount'] = $record_array['online_amount'];
			$value_array['system_remark'] = $this->_lang['langAlipayOnlinePay'];
			$value_array['create_time'] = time();
			$value_array['update_time'] = time();
			$value_array['payment'] = $record_array['payment'];
			$value_array['predeposit_r_id'] = $predeposit_r_id;
			$this->obj_predeposit->addPredepositDetail($value_array);
			unset($value_array);
			//对会员帐户进行资金操作
			$value_array = array();
			$value_array['available_predeposit'] = $record_array['online_amount'];
			$this->obj_member->modifyMember($value_array,$record_array['member_id'],'predeposit');
			unset($value_array);
			return true;
		}else {
			echo "ID非法";exit;
		}
	}
}

$alipay_manage = new Alipay();
$array = $alipay_manage->main();

$partner         = $array["alipay_partner"];					//合作身份者ID
$security_code   = $array["alipay_security_code"];	//安全检验码
$seller_email    = $array['email'];				//签约支付宝账号或卖家支付宝帐户

$_input_charset  = $array['_input_charset'];						       //字符编码格式 目前支持 GBK 或 utf-8
$transport       = "http";						       //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

$notify_url      = $array['site_url']."/predeposit_pay/alipay/notify_url.php";    //交易过程中服务器通知的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$return_url      = $array['site_url']."/predeposit_pay/alipay/return_url.php";    //付完款后跳转的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$show_url        = $array['url'];			   //网站商品的展示地址，不允许加?id=123这类自定义参数

$sign_type       = "MD5";						       //加密方式 不需修改
$antiphishing    = "0";                                //防钓鱼功能开关，'0'表示该功能关闭，'1'表示该功能开启。默认为关闭
//一旦开启，就无法关闭，根据商家自身网站情况请慎重选择是否开启。
//申请开通方法：联系我们的客户经理或拨打商户服务电话0571-88158090，帮忙申请开通。
//开启防钓鱼功能后，服务器、本机电脑必须支持远程XML解析，请配置好该环境。
//若要使用防钓鱼功能，建议使用POST方式请求数据，且请打开class文件夹中alipay_function.php文件，找到该文件最下方的query_timestamp函数

$mainname		= $array['email'];							//收款方名称，如：公司名称、网站名称、收款人姓名等
?>