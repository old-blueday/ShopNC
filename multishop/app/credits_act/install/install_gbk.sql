DROP TABLE IF EXISTS `credits_act`;
CREATE TABLE `credits_act` (
  ca_id int(11) NOT NULL auto_increment,
  ca_member_id int(11) NOT NULL default '0',
  ca_title varchar(100) NOT NULL,
  ca_content text NOT NULL,
  ca_add_time int(11) NOT NULL,
  ca_end_time int(11) NOT NULL,
  ca_state tinyint(1) NOT NULL default '0',
  ca_del tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ca_id)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `credits_act_apply`;
CREATE TABLE `credits_act_apply` (
  caa_id int(11) NOT NULL auto_increment,
  ca_id int(11) NOT NULL,
  cag_id int(11) NOT NULL,
  caa_member_id int(11) NOT NULL,
  caa_time int(11) NOT NULL,
  caa_num int(11) NOT NULL,
  caa_credits int(11) NOT NULL default '0',
  caa_state tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (caa_id)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `credits_act_goods`;
CREATE TABLE `credits_act_goods` (
  cag_id int(11) NOT NULL auto_increment,
  ca_id int(11) NOT NULL,
  cag_name varchar(100) NOT NULL,
  cag_pic varchar(100) default NULL,
  cag_num int(11) NOT NULL,
  cag_credits int(11) NOT NULL,
  PRIMARY KEY  (cag_id)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

DROP TABLE IF EXISTS `credits_act_msg`;
CREATE TABLE `credits_act_msg` (
  cam_id int(11) NOT NULL auto_increment,
  ca_id int(11) NOT NULL,
  cam_member_id int(11) NOT NULL,
  cam_content text NOT NULL,
  cam_time int(11) NOT NULL,
  cam_re varchar(255) default NULL,
  PRIMARY KEY  (cam_id)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;