<?php
/*
	*功能：设置帐户有关信息及返回路径（基础配置页面）
	*版本：3.0
	*日期：2010-06-29
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
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 *商品订单对象
	 * 
	 * @var obj
	 */
	var $obj_product_order;
	/**
	 * 收货地址对象
	 *
	 * @var obj
	 */
	var $obj_receive;

	function main(){
		/**
		 * 加载语言包
		 */
		$this->getlang("product");
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建订单对象
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 创建收货地址对象
		 */
		if (!is_object($this->obj_receive)){
			require_once("receive.class.php");
			$this->obj_receive = new ReceiveClass();
		}
		//判断信息ID是否为空
		if ($this->_input['sp_code'] == '' && $this->_input['out_trade_no'] == ''){
			$this->redirectPath("error","",$this->_lang['errProductInfoEmpty']);
		}
		$out_trade_no = $this->_input['sp_code']?$this->_input['sp_code']:$this->_input['out_trade_no'];
		/**
		 * 取订单信息
		 */
		$order_array = $this->obj_product_order->getOneOrderBySpcode($out_trade_no);
		/**
		 * 取卖家会员信息
		 */
		$condition['id'] = $order_array['seller_id'];
		$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
		/**
		 * 取商品信息
		 */
		$product_array = $this->obj_product->getProductRow($order_array['p_code']);
		/**
		 * 取收货地址
		 */
		$receive_array = $this->obj_receive->getOneReceiveByCode($order_array['receive_code']);
		/**
		 * 取收货地址地区信息
		 */
		if ($receive_array['receive_area_id'] != ''){
			require_once ("area.class.php");
			$obj_area = new AreaClass();
			$sel_area = $obj_area->getAreaPathList($receive_array['receive_area_id']);
			if (is_array($sel_area)) {
				foreach ($sel_area as $kr => $vr) {
					$receive_area .= $vr['area_name']." ";
				}
			}
			$receive_area .= " ".$receive_array['address'];
			$receive_array['area'] = $receive_area;
			unset($sel_area,$receive_area);
		}else {
			//如果不存在则调用老的信息
			$receive_array['area'][0]['area_name'] = $receive_array['province'];
			$receive_array['area'][1]['area_name'] = $receive_array['city'];
		}
		if (strtoupper($this->_configinfo['websit']['ncharset']) == 'GB2312'){
			$order_array['p_name'] = Common::nc_change_charset($order_array['p_name'],'gbk_to_utf8');
		}
		$array = array();
		$array['order'] = $order_array;
		$array['member'] = $member_array;
		$array['product'] = $product_array;
		$array['receive'] = $receive_array;
		$array['site_url'] = $this->_configinfo['websit']['site_url'];
		$array['_input_charset'] = $this->_configinfo['websit']['ncharset'];
		/**
		 * 商品详细页链接地址
		 */
		if ($order_array['sp_html'] != ''){
			$array['url'] = $this->_configinfo['websit']['site_url'].'/home/order.php?action=sp_html&sp_code='.$order_array['sp_code'];
		}else {
			$array['url'] = $this->_configinfo['websit']['site_url'].'/home/product.php?action=view&pid='.$product_array['p_code'];
		}
		
		/*判断付款方式*/
		if ($product_array['p_transfee_charge'] == 0){
			$array['transfee'] = 'SELLER_PAY';/*卖家承担*/
			$array['order']['tf_type'] = "EXPRESS";
		}else {
			$array['transfee'] = 'BUYER_PAY';	/*买家承担*/
			$array['tf_type'] = $order_array['tf_type'];	/*运送方式*/
			switch($array['order']['tf_type']){
				case "1":
					$array['order']['tf_type'] = "POST";
					break;
				case "2":
					$array['order']['tf_type'] = "EXPRESS";
					break;
				case "3":
					$array['order']['tf_type'] = "EMS";
					break;
			}
		}
		
		return $array;
	}

	/**
	 * 更新商品订单交易状态
	 * $out_trade_no 交易编号
	 * $trade_status 交易状态,$out_trade_no,$trade_status
	 */
	function update_order($input){
		/**
		 * 创建订单对象
		 */
		if (!is_object($this->obj_product_order)){
			require_once("order.class.php");
			$this->obj_product_order = new ProductOrderClass();
		}
		/**
		 * 交易状态
		 */		
		if($input['trade_status'] == 'WAIT_BUYER_PAY'){//等待买家付款
			$status = 0;
		}elseif($input['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){//买家付款成功,等待卖家发货
			$status = 1;
			$alipay_id = $input['trade_no'];
		}else if($input['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS'){//卖家已经发货等待买家确认
			$status = 2;
		}else if($input['trade_status'] == 'TRADE_FINISHED'){//交易成功结束
			$status = 3;
		}else {/*退款成功*/
			$status = 6;
		}
		/**
		 * 退款状态
		 */	
		if($input['refund_status'] == 'WAIT_SELLER_AGREE') {//买家申请退款
			$rfstatus = 1;
		} else if($input['refund_status'] == 'REFUND_CLOSED') {//退款关闭
			$rfstatus = 2;
		} else if($input['refund_status'] == 'REFUND_SUCCESS') {//退款成功
			$rfstatus = 3;
		}

		if ($status != '' || $rfstatus != '') {
			/**
			 * 创建订单对象
			 */
			if (!is_object($this->obj_product_order)){
				require_once("order.class.php");
				$this->obj_product_order = new ProductOrderClass();
			}
			//取订单信息
			$order_array = $this->obj_product_order->getOneOrderBySpcode ($input['out_trade_no']);
			switch ($order_array['sell_type']){
				case '0'://拍卖
					require_once('order_process_auction.class.php');
					$obj_order_process = new OrderProcessAuction();
					$obj_order_process->order_info = $order_array;
					$obj_order_process->payment_mechod = 'alipay';
					break;
				case '1'://一口价
					require_once('order_process_fixprice.class.php');
					$obj_order_process = new OrderProcessFixprice($input['out_trade_no']);
					break;
				case '2'://团购
					require_once('order_process_group.class.php');
					$obj_order_process = new OrderProcessGroup($input['out_trade_no']);
					break;
				case '3'://倒计时拍卖
					require_once('order_process_countdown.class.php');
					$obj_order_process = new OrderProcessCountdown($input['out_trade_no']);
					break;
				default:
					exit;
			}		
		}

		/**
		 * 更改订单退款状态
		 */
		if ($rfstatus != '') {
			//更改订单退款状态
			$obj_order_process->alipay_id =$alipay_id;
			$obj_order_process->changeOrderRefundState($input['out_trade_no'],$rfstatus);
			//url跳转处理
			if ($rfstatus == '1'){
				$url = $this->_configinfo['websit']['site_url'].'/member/own_order.php?action=bought';
			}
			if ($rfstatus == '2' || $rfstatus == '3'){
				$url = $this->_configinfo['websit']['site_url'].'/member/own_order.php?action=sold';
			}
			@header("Location: $url");
		} else if($status != ''){
			/**
			 * 更改订单交易状态
			 */
			$obj_order_process->alipay_id =$alipay_id;
			$obj_order_process->changeOrderState($input['out_trade_no'],$status);
			
			//如果是状态3的话，则跳转到评价页面
			if ($status == '0' || $status == '1'){
				$url = $this->_configinfo['websit']['site_url'].'/member/own_order.php?action=bought';
			}
			if ($status == '2'){
				$url = $this->_configinfo['websit']['site_url'].'/member/own_order.php?action=sold';
			}
			if ($status == '3'){
				$url = $this->_configinfo['websit']['site_url'].'/member/own_score.php?action=add&orderid='.$input['spcode'].'&type=bought';
			}
			@header("Location: $url");
		} else {
			echo 2;
		}
	}
}

$alipay_manage = new Alipay();
$array = $alipay_manage->main();

$partner = "2088102708837750";							//合作身份者ID
$security_code = "ma0jqvhjbt6s2bsd1frg7hisaiaz5xjr";	//安全检验码
$seller_email    = $array['member']['alipay'];			//签约支付宝账号或卖家支付宝帐户

$_input_charset  = $array['_input_charset'];			//字符编码格式 目前支持 GBK 或 utf-8
$transport       = "http";						       //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

$notify_url      = $array['site_url']."/payment/alipay/notify_url.php";    //交易过程中服务器通知的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$return_url      = $array['site_url']."/payment/alipay/return_url.php";    //付完款后跳转的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$show_url        = $array['url'];			   //网站商品的展示地址，不允许加?id=123这类自定义参数

$sign_type       = "MD5";						       //加密方式 不需修改

$mainname		= $array['member']['alipay'];		//收款方名称，如：公司名称、网站名称、收款人姓名等

?>