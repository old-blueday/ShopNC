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
 * FILE_NAME : feed.php   FILE_PATH : uc_client\control\feed.php
 * ....uc_client
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 07 18:10:03 CST 2008
 */

!defined('IN_UC') && exit('Access Denied');

class feedcontrol extends ucbase {

	function feedcontrol() {
		$this->ucbase();
	}

	function onadd($arr) {
		$this->load('misc');
		@extract($arr, EXTR_SKIP);//$appid, $icon, $appid, $uid, $username, $title_template, $title_data, $body_template, $body_data, $body_general, $target_ids, $image_1, $image_1_link, $image_2, $image_2_link, $image_3, $image_3_link, $image_4, $image_4_link
		$title_template = $this->_parsetemplate($title_template);
		$body_template = $this->_parsetemplate($body_template);
		$hash_template = md5($title_template.$body_template);
		$body_data = $_ENV['misc']->array2string($body_data);
		$title_data = $_ENV['misc']->array2string($title_data);
		$hash_data = md5($title_template.$title_data.$body_template.$body_data);
		$dateline = $this->time;
		$this->db->query("INSERT INTO ".UC_DBTABLEPRE."feeds SET appid='$appid', icon='$icon', uid='$uid', username='$username',
			title_template='$title_template', title_data='$title_data', body_template='$body_template', body_data='$body_data', body_general='$body_general',
			image_1='$image_1', image_1_link='$image_1_link', image_2='$image_2', image_2_link='$image_2_link',
			image_3='$image_3', image_3_link='$image_3_link', image_4='$image_4', image_4_link='$image_4_link',
			hash_template='$hash_template', hash_data='$hash_data', target_ids='$target_ids', dateline='$dateline'");
		return $this->db->insert_id();
	}

	function onget($arr) {
		@extract($arr, EXTR_SKIP);//limit
		$this->load('misc');
		$feedlist = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."feeds ORDER BY feedid LIMIT $limit");
		if($feedlist) {
			foreach($feedlist as $key=>$feed) {
				$feed['body_data'] = $_ENV['misc']->string2array($feed['body_data']);
				$feed['title_data'] = $_ENV['misc']->string2array($feed['title_data']);
				$feedlist[$key] = $feed;
			}
		}
		if(!empty($feedlist)) {
			$maxfeed = array_pop($feedlist);
			$maxfeedid = $maxfeed['feedid'];
			$feedlist = array_merge($feedlist, array($maxfeed));
			$this->_delete(0, $maxfeedid);
		}
		return $feedlist;
	}

	function _delete($start, $end) {
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."feeds WHERE feedid>='$start' AND feedid<='$end'");
	}

	function _parsetemplate($template) {
		$template = str_replace(array("\r", "\n"), '', $template);
		$template = str_replace(array('<br>', '<br />', '<BR>', '<BR />'), "\n", $template);
		$template = str_replace(array('<b>', '<B>'), '[B]', $template);
		$template = str_replace(array('<i>', '<I>'), '[I]', $template);
		$template = str_replace(array('<u>', '<U>'), '[U]', $template);
		$template = str_replace(array('</b>', '</B>'), '[/B]', $template);
		$template = str_replace(array('</i>', '</I>'), '[/I]', $template);
		$template = str_replace(array('</u>', '</U>'), '[/U]', $template);
		$template = htmlspecialchars($template);
		$template = nl2br($template);
		$template = str_replace(array('[B]', '[I]', '[U]', '[/B]', '[/I]', '[/U]'), array('<b>', '<i>', '<u>', '</b>', '</i>', '</u>'), $template);
		return $template;
	}

}

?>