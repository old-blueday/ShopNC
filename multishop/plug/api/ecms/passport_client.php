<?php
require ("../../../global.inc.php");
require ("../../../cache/configini.cache.php");
$site_config = $cache_config;

require_once("passport.php");

if ($_GET['action'] == "login" || $_GET['action'] == "reg"){
	LoginEcms($_GET['username'],$site_config['cookie']['cookie_expire']);
}elseif ($_GET['action'] == "exit"){
	LoginOutEcms();
}
if ($_GET['forward'] == ""){
	$_GET['forward'] = $site_config['api']['ecms_path'];
}
header("location: " . $_GET['forward']);exit;
?>