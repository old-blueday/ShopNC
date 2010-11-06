<?php
if (!file_exists(dirname(__FILE__)."/share/install.lock")){
	header("location:install/index.php");
	exit;
}
require(dirname(__FILE__)."/share/shop_config.ini.php");
if($INFO['websit']['url'] == $_SERVER['HTTP_HOST']) {		
	include("shop_index.php");
} else {
	include("single_index.php");
}
?>