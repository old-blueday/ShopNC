<?php

/*
	[UCenter] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: user.php 916 2009-01-19 05:56:07Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

define('UC_USER_CHECK_USERNAME_FAILED', -1);
define('UC_USER_USERNAME_BADWORD', -2);
define('UC_USER_USERNAME_EXISTS', -3);
define('UC_USER_EMAIL_FORMAT_ILLEGAL', -4);
define('UC_USER_EMAIL_ACCESS_ILLEGAL', -5);
define('UC_USER_EMAIL_EXISTS', -6);

class nccontrol extends base {


	function __construct() {
		$this->nccontrol();
	}

	function nccontrol() {
		parent::__construct();
		$this->load('nc');
		$this->app = $this->cache['apps'][UC_APPID];
	}

	// NC
	function ongetgroup() {
		$this->init_input();
        $id=intval($this->input('id'));
        $type=$this->input('type');
        $isCount = $this->input('iscount');

		$data = $_ENV['nc']->nc_uch_getgroup($id,$type,$isCount);
		return $data;
	}

    function ongetapp_by_type($type) {
        $this->init_input();
        $type = trim($this->input('type'));

        $data = $_ENV['nc']->nc_uch_getapp_by_type($type);
        return $data;
    }

    function nc_uch_group_send_topic($uid,$groupid,$subject,$content) {
        $this->init_input();
        $uid = intval($this->input('uid'));
        $groupid = intval($this->input('groupid'));
        $subject = trim($this->input('subject'));
        $content = trim($this->input('content'));
    }

    function onsharing() {
        $this->init_input();
        $type = $this->input('type');
        $title_template = $this->input('title_template');
        $body_template = $this->input('body_template');
        $data = $this->input('data');
        $uid = $this->input('uid');
        $username = $this->input('username');
        $body_general = $this->input('body_general');

        return $_ENV['nc']->nc_uch_sharing($uid,$username,$type,$title_template,$body_template,$data,$body_general);
    }

    function onfeed_get() {
        $this->init_input();
        $friend=intval($this->input('friend'));
        $limit=intval($this->input('limit'));
        $uid=intval($this->input('uid'));
        $isone=(bool)$this->input('isone');

        return $_ENV['nc']->nc_uch_feed_get($uid,$friend,$limit,$isone);
    }
}

?>