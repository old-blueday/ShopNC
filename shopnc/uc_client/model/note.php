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
 * FILE_NAME : note.php   FILE_PATH : uc_client\model\note.php
 * ....uc_client
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 07 18:13:29 CST 2008
 */

!defined('IN_UC') && exit('Access Denied');

define('UC_NOTE_REPEAT', 5);
define('UC_NOTE_TIMEOUT', 15);
define('UC_NOTE_GC', 10000);

class notemodel {

	var $db;
	var $base;
	var $apps;
	var $operations = array();

	function notemodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
		$_CACHE = $this->base->cache('apps');
		$this->apps = $_CACHE['apps'];
		$this->operations = array(
			'test'=>array('', 'action=test'),
			'deleteuser'=>array('', 'action=deleteuser'),
			'renameuser'=>array('', 'action=renameuser'),
			'deletefriend'=>array('', 'action=deletefriend'),
			'gettag'=>array('', 'action=gettag', 'tag', 'updatedata'),
			'getcreditsettings'=>array('', 'action=getcreditsettings'),
			'updatecreditsettings'=>array('', 'action=updatecreditsettings'),
			'updateclient'=>array('', 'action=updateclient'),
			'updatepw'=>array('', 'action=updatepw'),
			'updatebadwords'=>array('', 'action=updatebadwords'),
			'updatehosts'=>array('', 'action=updatehosts'),
			'updateapps'=>array('', 'action=updateapps'),
			'updatecredit'=>array('', 'action=updatecredit'),
		);
	}

	function add($operation, $getdata='', $postdata='', $appids=array(), $pri = 0) {
		$extra = '';
		if($appids) {
			$appadd = array();
			foreach((array)$this->apps as $appid=>$app) {
				$appid = $app['appid'];
				if(!in_array($appid, $appids)) {
					$appadd[] = 'app'.$appid."='1'";
				}
			}
			if($appadd) {
				$extra = ','.implode(',', $appadd);
			}
		}
		$getdata = addslashes($getdata);
		$postdata = addslashes($postdata);
		$this->db->query("INSERT INTO ".UC_DBTABLEPRE."notelist SET getdata='$getdata', operation='$operation', pri='$pri', postdata='$postdata'$extra");
		$insert_id = $this->db->insert_id();
		$insert_id && $this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='noteexists', value='1'");
		return $insert_id;
	}

	function send() {
		register_shutdown_function(array($this, '_send'));
	}

	function _send() {


		$note = $this->_get_note();
		if(empty($note)) {
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='noteexists', value='0'");
			return NULL;
		}

		$closenote = TRUE;
		foreach((array)$this->apps as $appid=>$app) {
			$appnotes = $note['app'.$appid];
			if($app['recvnote'] && $appnotes != 1 && $appnotes > -UC_NOTE_REPEAT) {
				$this->sendone($appid, 0, $note);
				$closenote = FALSE;
				break;
			}
		}
		if($closenote) {
			$this->db->query("UPDATE ".UC_DBTABLEPRE."notelist SET closed='1' WHERE noteid='$note[noteid]'");
		}

		$this->_gc();
	}

	function sendone($appid, $noteid = 0, $note = '') {
		$return = FALSE;
		$app = $this->apps[$appid];
		if($noteid) {
			$note = $this->_get_note_by_id($noteid);
		}
		$this->base->load('misc');
		$url = $this->get_url_code($note['operation'], $note['getdata'], $appid);
		$getcontent = trim(uc_fopen2($url, 500000, $note['postdata'], '', 1, $app['ip'], UC_NOTE_TIMEOUT));

		$returnsucceed = $getcontent != '' && $getcontent != '-1';

		$closedsqladd = $this->_close_note($note, $this->apps, $returnsucceed) ? ",closed='1'" : '';//

		if($returnsucceed) {
			if($this->operations[$note['operation']][2]) {
				$this->base->load($this->operations[$note['operation']][2]);
				$func = $this->operations[$note['operation']][3];
				$_ENV[$this->operations[$note['operation']][2]]->$func($appid, $getcontent);
			}
			$this->db->query("UPDATE ".UC_DBTABLEPRE."notelist SET app$appid='1', totalnum=totalnum+1, succeednum=succeednum+1, dateline='{$this->base->time}' $closedsqladd WHERE noteid='$note[noteid]'", 'SILENT');
			$return = TRUE;
		} else {
			$this->db->query("UPDATE ".UC_DBTABLEPRE."notelist SET app$appid = app$appid-'1', totalnum=totalnum+1, dateline='{$this->base->time}' $closedsqladd WHERE noteid='$note[noteid]'", 'SILENT');
			$return = FALSE;
		}
		return $return;
	}

	function _get_note() {
		$data = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."notelist WHERE closed='0' ORDER BY pri DESC, noteid ASC LIMIT 1");
		return $data;
	}

	function _gc() {
		rand(0, UC_NOTE_GC) == 0 && $this->db->query("DELETE FROM ".UC_DBTABLEPRE."notelist WHERE closed='1'");
	}

	function _close_note($note, $apps, $returnsucceed) {
		$note['app'.$appid] = $returnsucceed ? 1 : $note['app'.$appid] - 1;
		$appcount = count($apps);
		foreach($apps as $key => $app) {
			$appstatus = $note['app'.$app['appid']];
			if(!$app['recvnote'] || $appstatus == 1 || $appstatus <= -UC_NOTE_REPEAT) {
				$appcount--;
			}
		}
		if($appcount < 1) {
			return TRUE;
			//$closedsqladd = ",closed='1'";
		}
	}

	function _get_note_by_id($noteid) {
		$data = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."notelist WHERE noteid='$noteid'");
		return $data;
	}

	function get_url_code($operation, $getdata, $appid) {
		$app = $this->apps[$appid];
		$authkey = $this->db->result_first("SELECT authkey FROM ".UC_DBTABLEPRE."applications WHERE appid='$appid'");
		$url = $app['url'];
		$action = $this->operations[$operation][1];
		$code = urlencode(uc_authcode("$action&".($getdata ? "$getdata&" : '')."time=".$this->base->time, 'ENCODE', $authkey));
		return $url."/api/uc.php?code=$code";
	}

}

?>