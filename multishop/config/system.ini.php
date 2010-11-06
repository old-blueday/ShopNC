<?php 
##  [shopnc]系统配置文件
##  Date:2007/07/14
[global]
##  includepath=classes 设置网站包含路径
##  cachetime=60 * 60 * 24 缓存时间
##  ifcache=false 是否开启缓存
##  error_level=7 定义错误响应级别

includepath=config,classes,classes/application,classes/core,classes/libraries,classes/libraries/encode,classes/resource,classes/resource/Smarty/libs,share
cachetime=60 * 60 * 24
ifcache=false
[template]
left_delimiter=<tpl>
right_delimiter=</tpl>
[version]
version=v2.7
[install]
##  数据库表名，检测前缀名字是否与表名有重复
database_name=adv_theme,attribute,attribute_content,bid,collection,community,community_cate,community_reply,complaint_report,complaint_report_message,increments,javascript_cache,keyword,keyword_show,link,mailcontent,member,member_extend,message,message_system,product,product_attributes,product_class,product_message,product_sold,receive,remind,score,section,shop_class,shop_info,shop_link,shop_message,shop_product_class,system_group,system_log,system_member,theme,vote,vote_show
?>