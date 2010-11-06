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
 * FILE_NAME : pm.php   FILE_PATH : uc_client\model\pm.php
 * ....uc_client
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Tue Oct 07 18:13:40 CST 2008
 */

!defined('IN_UC') && exit('Access Denied');

class pmmodel {

	var $db;
	var $base;

	function pmmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function pmintval($pmid) {
		return @is_numeric($pmid) ? $pmid : 0;
	}

	function get_pm_by_pmid($uid, $pmid) {
		$arr = array();
		$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE related='$pmid' AND (msgtoid='$uid' OR msgfromid='$uid') ORDER BY dateline");
		if(!$arr) {
			$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE pmid='$pmid' AND (msgtoid IN ('$uid','0') OR msgfromid IN ('0', '$uid'))");
		}
		return $arr;
	}

	function get_pmnode_by_pmid($uid, $pmid, $type = 0) {
		$arr = array();
		if($type == 1) {
			$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$uid' and folder='inbox' ORDER BY dateline DESC LIMIT 1");
		} elseif($type == 2) {
			$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE msgtoid='$uid' and folder='inbox' ORDER BY dateline DESC LIMIT 1");
		} else {
			$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE pmid='$pmid'");
		}
		return $arr;
	}

	function set_pm_status($uid, $pmid) {
		$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET new='0' WHERE pmid='$pmid' AND (msgfromid='$uid' AND new='2' OR msgtoid='$uid' AND new='1')", 'UNBUFFERED');
		$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET new='0' WHERE msgtoid='$uid' AND related='$pmid'", 'UNBUFFERED');
	}

	function get_pm_num() {
	}

	function get_num($uid, $folder, $filter = '') {
		switch($folder) {
			case 'newbox':
				$sql = "SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$uid' AND msgtoid>0 AND new='2' AND related='0' AND folder='inbox' AND delstatus='0'";
				$num1 = $this->db->result_first($sql);
				$sql = "SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE msgtoid='$uid' AND new='1' AND related='0' AND folder='inbox' AND delstatus='0'";
				$num2 = $this->db->result_first($sql);
				return $num1 + $num2;
			case 'inbox':
				if($filter == 'newpm') {
					$filteradd = "msgtoid='$uid' AND folder='inbox' AND new='1' AND delstatus='0'";
				} elseif($filter == 'systempm') {
					$filteradd = "msgtoid='$uid' AND folder='inbox' AND msgfromid='0'";
				} elseif($filter == 'announcepm') {
					$filteradd = "msgtoid='0' AND folder='inbox' AND delstatus!='2'";
				} else {
					$filteradd = "msgtoid='$uid' AND folder='inbox' AND delstatus!='2'";
				}
				$sql = "SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE related='0' AND $filteradd";
				break;
			case 'outbox':
				if($filter == 'newpm') {
					$filteradd = "msgfromid='$uid' AND msgtoid>0 AND folder='inbox' AND new='2' AND delstatus='0'";
				} else {
					$filteradd = "msgfromid='$uid' AND msgtoid>0 AND folder='inbox' AND delstatus!='1'";
				}
				$sql = "SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE related='0' AND $filteradd";
				break;
			case 'savebox':
				break;
		}
		$num = $this->db->result_first($sql);
		return $num;
	}

	function get_pm_list($uid, $pmnum, $folder, $filter, $start, $ppp = 10) {
		$ppp = $ppp ? $ppp : 10;
		switch($folder) {
			case 'newbox':
				$array = $this->get_pm_list($uid, $pmnum, 'inbox', 'newpm', 0, 10);
				$array1 = $this->get_pm_list($uid, $pmnum, 'outbox', 'newpm', 0, 10);
				$array = array_merge($array, $array1);
				$count = count($array);
				for($i = 0;$i < $count - 1;$i++) {
					for($j = 1;$j < $count;$j++) {
						if($array[$i]['dbdateline'] < $array[$j]['dbdateline']) {
							$tmp = $array[$i];
							$array[$i] = $array[$j];
							$array[$j] = $tmp;
						}
					}
				}
				return array_slice($array, 0, 10);
			case 'inbox':
				if($filter == 'newpm') {
					$filteradd = "msgtoid='$uid' AND folder='inbox' AND new='1' AND delstatus='0'";
				} elseif($filter == 'systempm') {
					$filteradd = "msgtoid='$uid' AND folder='inbox' AND msgfromid=0";
				} elseif($filter == 'announcepm') {
					$filteradd = "msgtoid='0' AND folder='inbox' AND delstatus!='2'";
				} else {
					$filteradd = "msgtoid='$uid' AND folder='inbox' AND delstatus!='2'";
				}
				$sql = "SELECT * FROM ".UC_DBTABLEPRE."pms
					WHERE related='0' AND $filteradd ORDER BY dateline DESC LIMIT $start, $ppp";
				break;
			case 'savebox':
				break;
			case 'outbox':
				if($filter == 'newpm') {
					$filteradd = "p.msgfromid='$uid' AND p.folder='inbox' AND p.new='2' AND p.delstatus='0'";
				} else {
					$filteradd = "p.msgfromid='$uid' AND p.msgtoid>0 AND p.folder='inbox' AND p.delstatus!='1'";
				}
				$sql = "SELECT p.*, m.username AS msgto FROM ".UC_DBTABLEPRE."pms p
					LEFT JOIN ".UC_DBTABLEPRE."members m ON m.uid=p.msgtoid
					WHERE p.related='0' AND $filteradd
					ORDER BY p.dateline DESC LIMIT $start, $ppp";
				break;
		}
		$query = $this->db->query($sql);
		$array = array();
		$today = $this->base->time - $this->base->time % 86400;
		while($data = $this->db->fetch_array($query)) {
			$daterange = 5;
			if($data['dateline'] >= $today) {
				$daterange = 1;
			} elseif($data['dateline'] >= $today - 86400) {
				$daterange = 2;
			} elseif($data['dateline'] >= $today - 172800) {
				$daterange = 3;
			} elseif($data['dateline'] >= $today - 604800) {
				$daterange = 4;
			}
			$data['daterange'] = $daterange;
			$data['subject'] = htmlspecialchars($data['subject']);
			if($filter == 'announcepm') {
				unset($data['msgfromid'], $data['msgfrom']);
			}
			$array[] = $data;
		}
		if($folder == 'inbox') {
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."newpm WHERE uid='$uid'", 'UNBUFFERED');
		}
		return $array;
	}

	function sendpm($subject, $message, $msgfrom, $msgto, $related = 0) {
		$_CACHE = $this->base->cache('badwords');
		if($_CACHE['badwords']['findpattern']) {
			$subject = @preg_replace($_CACHE['badwords']['findpattern'], $_CACHE['badwords']['replace'], $subject);
			$message = @preg_replace($_CACHE['badwords']['findpattern'], $_CACHE['badwords']['replace'], $message);
		}

		$subject = trim($subject);
		if($subject == '' && !$related) {
			$subject = $this->base->cutstr(trim($message), 50);
			if($subject == '') {
				return 0;
			}
		} else {
			$subject = $this->base->cutstr(trim($subject), 75, '');
		}
		$new = 1;
		if(!$related) {
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom,msgfromid,msgtoid,folder,new,subject,dateline,related,message) VALUES
				('".$msgfrom['username']."','".$msgfrom['uid']."','$msgto','inbox','$new','$subject','".$this->base->time."','0','$message')");
			$lastpmid = $related = $this->db->insert_id();
		} else {
			$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE pmid='$related' AND related='0'");
			$arr = $arr[0];
			if($arr['message']{0} != "\t") {
				$arr = uc_addslashes($arr, 1);
				$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET message='\t".$this->removecode($arr['message'], 200)."', related='0' WHERE pmid='$related'");
				$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom, msgfromid, msgtoid, folder, new, subject, dateline, message, delstatus, related)
					VALUES ('$arr[msgfrom]', '$arr[msgfromid]', '$arr[msgtoid]', '$arr[folder]', '$arr[new]', '$arr[subject]', '$arr[dateline]', '$arr[message]', '$arr[delstatus]', '$related')");
			}
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom,msgfromid,msgtoid,folder,new,subject,dateline,related,message) VALUES
				('".$msgfrom['username']."','".$msgfrom['uid']."','$msgto','inbox','$new','$subject','".$this->base->time."','$related','$message')");
			$lastpmid = $this->db->insert_id();
			$new = $arr['msgfromid'] == $msgfrom['uid'] ? 1 : 2;
		}
		$new = $msgto ? $new : 0;
		$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET delstatus='0', new='$new', dateline='".$this->base->time."' WHERE pmid='$related'", 'UNBUFFERED');
		$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."newpm (uid) VALUES ('$msgto')");
		return $lastpmid;
	}

	function set_ignore($uid) {
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."newpm WHERE uid='$uid'");
	}

	function check_newpm($uid) {
		$newpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."newpm WHERE uid='$uid'");
		return $newpm;
	}

	function deletepm($uid, $folder, $pmids) {
		$pmsadd = '';
		$delnum = 0;
		$pmsadd = "pmid IN (".$this->base->implode($pmids).")";
		$pmsradd = "related IN (".$this->base->implode($pmids).")";
		if($pmsadd) {
			if($folder == 'inbox') {
				$sql = "folder='inbox' AND msgtoid='$uid' AND $pmsadd AND (delstatus=1 OR msgfromid=0)";
				$msg_field = 'msgtoid';
				$deletestatus = 2;
			} elseif($folder == 'outbox') {
				$sql = "folder='inbox' AND msgfromid='$uid' AND $pmsadd AND delstatus=2";
				$msg_field = 'msgfromid';
				$deletestatus = 1;
			} elseif($folder == 'newbox') {
				$query = $this->db->query("SELECT pmid, new FROM ".UC_DBTABLEPRE."pms WHERE $pmsadd");
				$finbox = $foutbox = array();
				while($data = $this->db->fetch_array($query)) {
					if($data['new'] == 1) {
						$finbox[] = $data['pmid'];
					} else {
						$foutbox[] = $data['pmid'];
					}
				}
				$finboxnum = $this->deletepm($uid, 'inbox', $finbox);
				$foutboxnum = $this->deletepm($uid, 'outbox', $foutbox);
				$delnum = $finboxnum + $foutboxnum;
				return $delnum;
			}
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."pms WHERE $sql", 'UNBUFFERED');
			$delnum = $this->db->affected_rows();
			if($delnum) {
				$this->db->query("DELETE FROM ".UC_DBTABLEPRE."pms WHERE $pmsradd", 'UNBUFFERED');
			}
			if($deletestatus) {
				$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET delstatus='$deletestatus' WHERE $msg_field='$uid' AND $pmsadd", 'UNBUFFERED');
				$delnum += $this->db->affected_rows();
			}
		}
		return $delnum;
	}

	function get_blackls($uid, $uids = array()) {
		if(!$uids) {
			$blackls = $this->db->result_first("SELECT blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid='$uid'");
		} else {
			$uids = $this->base->implode($uids);
			$blackls = array();
			$query = $this->db->query("SELECT uid, blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid IN ($uids)");
			while($data = $this->db->fetch_array($query)) {
				$blackls[$data['uid']] = explode(',', $data['blacklist']);
			}
		}
		return $blackls;
	}

	function set_blackls($uid, $blackls) {
		$this->db->query("UPDATE ".UC_DBTABLEPRE."memberfields SET blacklist='$blackls' WHERE uid='$uid'");
		return $this->db->affected_rows();
	}

	function removecode($str, $length) {
		$bbcodes = 'b|i|u|color|size|font|align|list|indent|url|email|code|img|float';
		$str = $this->base->cutstr(strip_tags(preg_replace(array(
				"/\[quote].*\[\/quote]/siU",
				"/\[($bbcodes)=?.*\]/iU",
				"/\[\/($bbcodes)\]/i",
			), '', $str)), $length);
		return trim($str);
	}

}

?>