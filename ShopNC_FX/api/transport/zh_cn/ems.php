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
* FILE_NAME : ems.php D:\binzi\shopnc6\api\transport\zh_cn\ems.php
* ems配送
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Thu Feb 05 10:47:08 CST 2009
*/
if(is_array($transport_module) and count($transport_module) > 0) {
	$i	= count($transport_module);
} else {
	$i	= 0;
}

$transport_module[$i]['file']		= "ems";
$transport_module[$i]['name']		= "ems配送";
$transport_module[$i]['info']		= "描述";
$transport_module[$i]['pay_type']	= "0";
$transport_module[$i]['web_site']	= "http://www.shopnc.net";
$transport_module[$i]['content']	= array(
array('name'=>'500克以内的费用',		'code' => 'base_money', 			'type' => 'text',   'value' => ''),
array('name'=>'每增加500克的费用',	'code' => 'add_money',             	'type' => 'text',   'value' => ''),
array('name'=>'免费额度',			'code' => 'free_money',         	'type' => 'text',   'value' => ''),
);
/*配送费用计算类*/
class emsTransportMoney {

	function __construct() {

	}

	function transportCount($weight,$amount,$transport_info) {
		$money	= $transport_info['base_money'];
		if(intval($transport_info['free_money'])>0 and intval($amount)>=intval($transport_info['free_money'])) {
			return 0;
		} else {
			if ($weight > 500)
			{
				$money = $transport_info['base_money']+(ceil(($weight - 500) / 500)) * $transport_info['add_money'];
			}
			return $money;
		}

	}
}
?>