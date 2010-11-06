<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : tag.php   FILE_PATH : uc_client\model\tag.php
 * ....uc_client
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 07 18:13:51 CST 2008
 */

!defined('IN_UC') && exit('Access Denied');

class tagmodel {

	var $db;
	var $base;

	function tagmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function get_tag_by_name($tagname) {
		$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."tags WHERE tagname='$tagname'");
		return $arr;
	}

	function get_template($appid) {
		$result = $this->db->result_first("SELECT tagtemplates FROM ".UC_DBTABLEPRE."applications WHERE appid='$appid'");
		return $result;
	}

	function updatedata($appid, $data) {
		$appid = intval($appid);
		$data = uc_unserialize($data);
		$this->base->load('app');
		$data[0] = addslashes($data[0]);
		$datanew = array();
		if(is_array($data[1])) {
			foreach($data[1] as $r) {
				$datanew[] = $_ENV['misc']->array2string($r);
			}
		}
		$tmp = $_ENV['app']->get_apps('type', "appid='$appid'");
		$datanew = addslashes($tmp[0]['type']."\t".implode("\t", $datanew));
		if(!empty($data[0])) {
			$return = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."tags WHERE tagname='$data[0]' AND appid='$appid'");
			if($return) {
				$this->db->query("UPDATE ".UC_DBTABLEPRE."tags SET data='$datanew', expiration='".$this->base->time."' WHERE tagname='$data[0]' AND appid='$appid'");
			} else {
				$this->db->query("INSERT INTO ".UC_DBTABLEPRE."tags (tagname, appid, data, expiration) VALUES ('$data[0]', '$appid', '$datanew', '".$this->base->time."')");
			}
		}
	}

	function formatcache($appid, $tagname) {
		$return = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."tags WHERE tagname='$tagname' AND appid='$appid'");
		if($return) {
			$this->db->query("UPDATE ".UC_DBTABLEPRE."tags SET expiration='0' WHERE tagname='$tagname' AND appid='$appid'");
		} else {
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."tags (tagname, appid, expiration) VALUES ('$tagname', '$appid', '0')");
		}
	}

}

?>