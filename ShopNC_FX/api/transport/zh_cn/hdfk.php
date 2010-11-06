<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : hdfk.php D:\binzi\shopnc6\api\transport\zh_cn\hdfk.php
* 货到付款配送
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Thu Feb 05 10:47:39 CST 2009
*/
if(is_array($transport_module) and count($transport_module) > 0) {
	$i	= count($transport_module);
} else {
	$i	= 0;
}

$transport_module[$i]['file']		= "hdfk";
$transport_module[$i]['name']		= "货到付款";
$transport_module[$i]['info']		= "描述";
$transport_module[$i]['pay_type']	= "0";
$transport_module[$i]['web_site']	= "http://www.shopnc.net";
$transport_module[$i]['content']	= array(
        array('name'=>'配送费用',		'code' => 'send_money', 		'type' => 'text',   'value' => ''),
		);

/*配送费用计算类*/
class hdfkTransportMoney {

	function __construct() {

	}

	function transportCount($weight,$amount,$transport_info) {
		$money	= '';

		$money	= intval($transport_info['send_money']);

		return $money;

	}
}
?>