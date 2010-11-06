<?php

/**
 * ShopNc 专用Model
 *
 * @author ShopNC Develop Team Cevin
 * @url www.shopnc.net
 * @copyright
 */

!defined('IN_UC') && exit('Access Denied');

class ncmodel {

	var $db;
	var $base;

	function __construct(&$base) {
		$this->ncmodel($base);
	}

	function ncmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function nc_uch_getgroup($id=0,$type='user',$isCount=false) {
		$id=intval($id);
		$type=$type?(in_array($type,array('user','group'),true) ? $type : 'user'):'user';

		$sql = array();
		$sql['user'] = "SELECT m.*,t.username,(SELECT fd.icon FROM ".NC_BBS_DBTABLEPRE."forumfield fd WHERE fd.fid=t.fid) AS pic FROM ".NC_BBS_DBTABLEPRE."forum m LEFT JOIN ".NC_BBS_DBTABLEPRE."groupuser t on m.fid=t.fid WHERE t.uid='{$id}'";
		$sql['group'] = "SELECT t.*,m.name FROM ".NC_BBS_DBTABLEPRE."groupuser t LEFT JOIN ".NC_BBS_DBTABLEPRE."forum m on t.fid=m.fid WHERE t.fid='{$id}'";

		if($id) {
			if($isCount) {
				$query = $this->db->query($sql[$type]);
				return $this->db->num_rows($query);
			}
			$sql = $sql[$type];
		} else {
			return false;
		}

		$data = $this->db->fetch_all($sql);
		return $data;
	}

	function nc_uch_group_send_topic($uid,$groupid,$subject,$content) {
	}

	function nc_uch_getapp_by_type($type) {
		$sql = "SELECT * FROM ".UC_DBTABLEPRE."applications WHERE type='{$type}'";
		$data = $this->db->fetch_first($sql);
		return $data;
	}

	function nc_uch_sharing($uid,$username,$type,$title_template,$body_template,$data,$body_general) {
		$sql = "INSERT INTO ".NC_UCH_DBTABLEPRE."share (sid,type,uid,username,dateline,title_template,body_template,body_data,body_general,image,image_link,hot,hotuser) VALUES (0,'$type',$uid,'$username',UNIX_TIMESTAMP(),'$title_template','$body_template','$data','$body_general','','',0,'')";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	function nc_uch_feed_get($uid,$friend,$limit,$isone) {
		$_friend=$_limit=10;

		if($uid) {
			if($friend)$_friend=$friend;
			if($limit)$_limit=$limit;
			if($isone === true) {//如果不是只获取只用用户的动态
				$frinds = array();
				$query = $this->db->query("select friendid from ".NC_UCH_DBTABLEPRE."friend WHERE uid={$uid} limit {$_friend}");
				while($row=$this->db->fetch_array($query)) {
					$friends[]=$row['friendid'];
				}
				$friends[]=0;

				$query = $this->db->query("select * from ".NC_UCH_DBTABLEPRE."feed where uid in (".implode(',',$friends).") order by feedid desc limit {$_limit}");
			} else {
				$query = $this->db->query("select * from ".NC_UCH_DBTABLEPRE."feed where uid = {$uid} order by feedid desc limit {$limit}");
			}

			$feeds = array();
			while($row=$this->db->fetch_array($query)) {
				$row['title_template'] = str_replace(array('{actor}','{mtag}'),array($row['username'],'群组'),$row['title_template']);
				$title_data = (array)@unserialize($row['title_data']);
				foreach($title_data as  $key=>$val) {
					$row['datas'] = str_replace('{'.$key.'}',$val,$row['title_template']);
					$row['title_template'] = $row['datas'];
				}
				if(!preg_match("/\/shop/i",$row['datas'])) {
					$row['datas'] =  preg_replace("/<img(.+?)src=([\'\"]?)([^>\s]+)\\2([^>]*)>/i", '<img \\1 src="../../home/\\3" \\4>', $row['datas']);
					$row['datas'] =  preg_replace("/<a(.+?)href=([\'\"]?)([^>\s]+)\\2([^>]*)>/i", '<a target="_blank" \\1 href="../../\\3" \\4>', $row['datas']);
				}
				
				$feeds[]=$row;
			}

			return $feeds;
		}
	}
}

?>