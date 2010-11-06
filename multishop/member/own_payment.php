<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_payment.php   FILE_PATH : E:\www\multishop\trunk\member\own_payment.php
 * ....支付方式设置
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team
 * @version Mon May 12 09:50:21 CST 2008
 */

include_once('../global.inc.php');
class OwnPayment extends memberFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
	/**
	 * 支付对象
	 *
	 * @var obj
	 */
	var $obj_payment;
	
	function main(){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->objmember)){
			require_once ("member.class.php");
			$this->objmember = new MemberClass();
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
		$this->getlang("member");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('seller','my_seller','bind_payment');
		
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "manage":
				$this->_manage();
				break;
			case "save":
				$this->_save();
				break;
			default:
				$this->_manage();
				break;
		}
	}
	
	/**
	 * 支付页面 
	 */
	function _manage(){
		//得到会员资料
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->objmember->getMemberInfo($condition,'*',$operate_genre='more');
		
		//配置文件中的支付方式$this->_configinfo['payment'];
		//数组文件中的支付方式$this->_b_config['payment'];
		//整合支付方式数组
		if (is_array($this->_configinfo['payment'])){
			$payment_array = array();
			//线下支付和预存款将过滤
			unset($this->_configinfo['payment']['offline'],$this->_configinfo['payment']['predeposit']);
			$alipay_payment = array();
			foreach ($this->_configinfo['payment'] as $k => $v){
				//当支付模块开启的时候，排除线下交易的类型，线下交易在数据库中没有字段
				if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
					include_once(BasePath.'/payment/'.$k.'/payment_module.php');
					$class_name = $k.'PaymentMethod';
					$obj_p_module = new $class_name;
					$param_array = $obj_p_module->payment_param();
					$payment_array[$k]['name'] = $param_array['name'];
					if ($k == 'alipay') {
						$alipay_payment = $this->_get_payment_param($k);
					}
					unset($class_name,$obj_p_module,$param_array);
					//前台显示标识
					$sign = true;
				}
			}
		}
		//检查支付方式模式(支付宝独有)
		if (is_array($alipay_payment['value_array'])) {
			$payment_mode = 'system';
			foreach ($alipay_payment['value_array'] as $k => $v) {
				if (preg_match("/array/",$v['value'])) {
					$payment_mode = 'seller';
				}					
			}				
		}	
		unset($alipay_payment);
		/**
		 * 页面输出
		 */
		$this->output('sign',$sign);
		$this->output('payment_array',$payment_array);
		$this->output('member_array',$member_array);
		$this->output('payment_mode',$payment_mode);
		$this->showpage('own_payment.manage');
	}
	
	/**
	 * 保存记录
	 */
	function _save(){
		//按照配置文件中的支付字段来接值
		if (is_array($this->_configinfo['payment'])){
			$payment_array = array();
			foreach ($this->_configinfo['payment'] as $k => $v){
				//当支付模块开启的时候，排除线下交易的类型，线下交易在数据库中没有字段
				if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
					include_once(BasePath.'/payment/'.$k.'/payment_module.php');
					$class_name = $k.'PaymentMethod';
					$obj_p_module = new $class_name;
					$param_array = $obj_p_module->payment_param();
					if (!empty($param_array['field'])){
						$payment_array[$k] = $this->_input[$k];
						if ($k == 'alipay') {
							$payment_array["alipay_partner"] = $this->_input["alipay_partner"];
							$payment_array["alipay_key"] = $this->_input["alipay_key"];
						}
					}
					unset($class_name,$obj_p_module,$param_array);
				}
			}
			$this->objmember->modifyMember($payment_array,$_SESSION['s_login']['id'],'payment');
		}
		$this->redirectPath("succ","member/own_payment.php",$this->_lang['langMInfoAmendOk']);
	}
	
	/**
	 * 取支付方式参数
	 */
	function _get_payment_param($dir_name){
		require_once(BasePath . '/payment/'.$dir_name.'/payment_module.php');
		$classname = $dir_name."PaymentMethod";
		$obj_module = new $classname;
		//取需要的参数信息
		$param_array = $obj_module->modi_param();
		//读取参数文件
		if (file_exists(BasePath . '/payment/'.$dir_name.'/'.$obj_module->config_file)){
			if (is_array($param_array)){
				$file = @fopen(BasePath . '/payment/'.$dir_name.'/'.$obj_module->config_file,'rb');
				$i=0;
				while ($line=@fgets($file)) {
					$line = preg_replace("/\s+/",   "",$line);//去除所有空格
					$line = preg_replace("/'/i",   "\"",$line);//将单引号统一为双引号
					foreach ($param_array as $k => $v){
						//判断是否是该参数
						if (strstr($line,'$'.$k.'=')){
							$array = explode('=',$line);
							$array = explode(';',$array[1]);
							$value_array[$i]['name'] = $v['name'];//页面参数名称
							$value_array[$i]['type'] = $v['type'];//页面参数输出格式
							switch($v['type']){
								case 'select':
									$value_array[$i]['option'] = $v['option'];
									break;
							}
							$value_array[$i]['param'] = $k;
							$value_array[$i]['value'] = trim(trim($array[0]),'"');
							$param_line .= $k.'|||';
							unset($array);
							$i++;
						}
					}
					unset($line);
				}
				@fclose($file);
			}
			return array(
				'value_array'=>$value_array,
				'param_line'=>$param_line,
			);
		}else{
			return false;
		}
	}	
}

$payment = new OwnPayment();
$payment->main();
unset($payment);
?>