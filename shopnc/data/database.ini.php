<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想单用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : database.ini.php   FILE_PATH : \shopnc\classes\core\database.ini.php
 * 数据库配置信息
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri May 13 14:27:07 CST 2008
 */	

##  engine_type=adodb  使用ADODB操作数据库
##  engine_type=mysql  使用Mysql函数操作数据库，如果是一台服务器部署MYSQL4，推荐使用
##  engine_type=mysqli  使用Mysqli函数操作数据库，如果是一台PHP5服务器部署MYSQL5，推荐使用，效率比其他几种方式高
##  engine_type=pdo5  使用PDO来处理数据库，是PHP5中官方自带的扩展，PHP4不支持，可以支持多种数据库，效率比ADODB高，略比MYSQLI低
$database_config['engine_type']= 'mysql';

##  database_type=mysqlt  使用ADODB和PDO需要设置，例如使用ADODB,MYSQL数据库：database_type=mysqlt；使用POD,MYSQL数据库：database_type=mysql
$database_config['database_type'] = 'mysqlt';

##  设置数据库是否读写分离
##  database_read_write=0 读写不分离
##  database_read_write=1 读写分离
$database_config['database_read_write'] = '1';

##  dbprefix=shopnc 数据库表前缀
$database_config['dbprefix'] = 'shopnc_';

##  ifdebug=false adodb 非debug模式
##  ifdebug=true adodb debug模式
$database_config['ifdebug'] = 'false';

##  dbcharset 数据库字符集
$database_config['dbcharset'] = 'utf8';

##  dbcharset 数据库端口
$database_config['dbport'] 	  = '3306';
#####################
## 设置写数据库信息  ##
#####################
##  servername_write=localhost 数据库服务器地址
$database_config['servername_write'] = 'localhost';

##  databasename_write=shopnc 数据库名称
$database_config['databasename_write'] = 'shopnc61';

##  username_write=root 数据库用户名
$database_config['username_write'] = 'root';

##  password_write=root 数据库密码
$database_config['password_write'] = 'root';

#####################
## 设置读数据库信息  ##
#####################
##  servername_read=localhost 数据库服务器地址
$database_config['servername_read'] = 'localhost';

##  databasename_read=shopnc 数据库名称
$database_config['databasename_read'] = 'shopnc61';

##  username_read=root 数据库用户名
$database_config['username_read'] = 'root';

##  password_read=root 数据库密
$database_config['password_read'] = 'root';
?>