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
 * FILE_NAME : system.ini.php   FILE_PATH : \shopnc6\system.ini.php
 * ....配置文件
 * 数据库操作类及文件上传类继承此基类
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Jun 6 11:27:07 CST 2008
 */
##################
##  系统配置信息  ##
##################
##  设置网站包含路径
$system_config['global']['includepath']='classes,classes/application,classes/core,classes/libraries,classes/libraries/encode,classes/resource,classes/resource/Smarty/libs,share';

##  缓存时间
$system_config['global']['cachetime']='60 * 60 * 24';

##  是否开启缓存
$system_config['global']['ifcache']='false';

##  定义错误响应级别
$system_config['global']['error_level']='7';

###############
##  模板信息  ##
###############
## 模板左标记
$system_config['template']['left_delimiter']='<tpl>';

## 模板右标记
$system_config['template']['right_delimiter']='</tpl>';
?>