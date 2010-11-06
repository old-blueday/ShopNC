<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : zhongtong.php D:\binzi\shopnc6\api\transport\zh_cn\zhongtong.php
* 中通配送
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Thu Feb 05 10:48:03 CST 2009
*/
if(is_array($transport_module) and count($transport_module) > 0) {
	$i	= count($transport_module);
} else {
	$i	= 0;
}

$transport_module[$i]['file']		= "zhongtong";
$transport_module[$i]['name']		= "中通配送";
$transport_module[$i]['info']		= "中通配送说明";
$transport_module[$i]['pay_type']	= "0";
$transport_module[$i]['web_site']	= "http://www.shopnc.net";
$transport_module[$i]['content']	= array(
array('name'=>'1000克内的价格',		'code' => 'base_money', 			'type' => 'text',   'value' => '10'),
array('name'=>'每增加1000克的费用',	'code' => 'add_money',             	'type' => 'text',   'value' => '5'),
array('name'=>'免费额度',			'code' => 'free_money',         	'type' => 'text',   'value' => ''),
);
/*配送费用计算类*/
class zhongtongTransportMoney {

	function __construct() {

	}

	function transportCount($weight,$amount,$transport_info) {
		$money	= $transport_info['base_money'];
		if(intval($transport_info['free_money'])>0 and intval($amount)>=intval($transport_info['free_money'])) {
			return 0;
		} else {
			if ($weight > 500)
			{
				$money = $transport_info['base_money']+(ceil(($goods_weight - 1))) * $transport_info['add_money'];
			}
			return $money;
		}

	}
}
?>