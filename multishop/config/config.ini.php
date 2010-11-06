<?php
##  [shopnc]全局配置文件
##  Date:2007/07/12
[websit]
##  ncharset=UTF-8  商城页面编码UTF-8或GBK，注意此配置必须放在config.ini.php所有配置之前，否则会导致编码不正确等问题
##  site_url=http://localhost 设置网站地址
##  logo_url= 网站LOGL地址
##  versionarea=zh-cn 软件语言版本,简体中文
##  site_name=我的商店 网站名称
##  site_title=我的商店 网站标题
##  meta_desc=我的商店 网站META描述
##  meta_keyword=我的商店 网站META关键字
##  templatesname=default 所使用的模版
##  storetemplatename=storetemplate  商店模版路径
##  gzip=1   开启gzip功能，0为关闭,1为开启
##  index_html=1   开启首页静态功能，0为关闭,1为开启
##  channel_html=1   开启频道页静态功能，0为关闭,1为开启

ncharset=UTF-8
site_url=http://localhost/multishop(multishop)/trunk
logo_url=
site_name=ShopNC综合多用户商城演示系统
site_title=ShopNC综合多用户商城
meta_desc=ShopNC综合多用户商城系统
meta_keyword=多用户商城,开源商城,ShopNC
versionarea=zh-cn
templatesname=orange
storetemplatename=storetemplate
systemadmin=system
smtpserver=
smtpprot=
smtpuser=
smtppass=
smtpemail=
mailto=coolratcn@163.com
poweredby=版权所有 天津市网城创想科技有限责任公司
icprecord=津ICP备080001719号
gzip=1
index_html=0
channel_html=0
[contact]
companyname=网城创想科技有限责任公司
contactman=shopnc team
## genre=1 0是男1是女
genre=1
email=test_multishopnc@163.com
province=天津
city=南开区
address=富力城
fax=8602227260105
mobilephone=13888888888
contactphone=8602227260105
zip=300201
[database]
##  engine_type=adodb  使用ADODB操作数据库
##  engine_type=mysql  使用Mysql函数操作数据库，如果是一台服务器部署MYSQL4，推荐使用
##  engine_type=mysqli  使用Mysqli函数操作数据库，如果是一台PHP5服务器部署MYSQL5，推荐使用，效率比其他几种方式高
##  engine_type=pdo5  使用PDO来处理数据库，是PHP5中官方自带的扩展，PHP4不支持，可以支持多种数据库，效率比ADODB高，略比MYSQLI低
##  database_type=mysqlt  使用ADODB和PDO需要设置，例如使用ADODB,MYSQL数据库：database_type=mysqlt；使用POD,MYSQL数据库：database_type=mysql
##  设置数据库是否读写分离
##  database_read_write=0 读写不分离
##  database_read_write=1 读写分离
##  dbprefix=shopnc 数据库表前缀
##  ifdebug=false adodb 非debug模式
##  ifdebug=true adodb debug模式
##  database_charset=utf8   数据库编码，utf8或gbk
engine_type=mysql
database_type=mysqlt
database_read_write=1
dbprefix=shopnc_
ifdebug=false
database_charset=utf8
##  设置写数据库信息
##  servername_write=localhost 数据库服务器地址
##  databasename_write=shopnc 数据库名称
##  username_write=root 数据库用户名
##  password_write=root 数据库密码
servername_write=localhost
databasename_write=multishop_test
username_write=root
password_write=root
##  设置读数据库信息
##  servername_read=localhost 数据库服务器地址
##  databasename_read=shopnc 数据库名称
##  username_read=root 数据库用户名
##  password_read=root 数据库密码
servername_read=localhost
databasename_read=multishop_test
username_read=root
password_read=root
[cookie]
##  设置cookie
##  cookie_expire=36000000 cookie过期时间，单位是1/1000秒
##  session_expire=600 session过期时间，单位是分钟
##  cookiepre=CGr_ cookie名称前缀
##  cookiedomain=.yourdomain.com cookie作用域，可不填
##  cookiepath=/ cookie存放地址
cookie_expire=3600
session_expire=60
cookiepre=cdb_
cookiedomain=
cookiepath=/
[file]
##  attachmentspath=attachments 上传的附件存放地址
##  allowuploadmaxsize=4094 最大可以上传的尺寸，单位是KB
##  allowuploadimagetype=jpg,gif,png 允许上传的图片类型
##  allowuploadfiletype=doc,txt,jpg,gif,png,htm,pdf,xls 允许上传的文件类型
##  uploadsavetype=1 上传的文件存放模式：按文件类型存放，htm/a.jpg
##  uploadsavetype=2 上传的文件存放模式：按文件类型存放，再细化到年，htm/2007/a.jpg
##  uploadsavetype=3 上传的文件存放模式：按文件类型存放，再细化到月，htm/2007/07/a.jpg
##  uploadsavetype=4 上传的文件存放模式：按文件类型存放，再细化到日，htm/2007/07/12/a.jpg
attachmentspath=attachments
allowuploadmaxsize=4094
allowuploadimagetype=jpg,gif,png
allowuploadfiletype=doc,txt,jpg,gif,png,bmp,pdf,xls
uploadsavetype=4
[productinfo]
##  设置产品信息
##  imageresize_width=200 产品缩略图宽度
##  imageresize_height=200 产品缩略图高度
##  imageresize_ifcut=0 产品缩略图等比例缩小
##  imageresize_ifcut=1 产品缩略图按固定的宽和高缩小、裁剪，不变形
##  ifhtml=1 产品查看静态页，0为不使用静态页链接，1为使用静态页链接
imageresize_width=96
imageresize_height=96
imageresize_ifcut=0
ifhtml=0
output_condition=shop
[shopinfo]
##  设置商铺信息
##  ifcheck=0 开店不需要审核
##  ifcheck=1 开店需要审核
ifcheck=0
[api]
##  open_passport=1  是否开启通行证
##  passport_type=0  通行证类型，0多用户商城作为服务器端，1多用户商城作为客户端，2作为UCenter应用
##  passport_key=abcdefg123456 整合使用的KEY，在被整合的系统中要设置相应的一样的通行证密码
##  passport_url=http://localhost/multishop/bbs 整合服务器端地址
##  open_phpwind=1  整合PHPWIND论坛
##  open_dedecms=1  整合DEDECMS
##  open_discuz=1   整合discuz论坛
##  open_x-space=1  整合x-space论坛
##  open_phpcms=1   整合phpcms
##  open_ecms=1     整合帝国CMS
##  open_cmsware=1  整合cmsware
##  phpwind_path=   整合phpwind论坛路径
##  dedecms_path=   整合dedecms路径
##  phpcms_path=    整合phpcms路径
##  ecms_path=      帝国cms路径
##  cmsware_path=   cmsware路径
##  cmsware_path_absolut=  cmsware放置的文件夹路径。例如multishop/cmsware
##  ecms_path_absolut=     帝国放置的文件夹路径。例如multishop/ecms
##  cmsware_TransactionAccessKey=  CWPS访问密码
open_passport=0
passport_type=2
passport_key=abcdefg123456
passport_url=http://localhost/multishop/branches/multishop_phpwind6/bbs
passport_login=login.php
passport_logout=login.php?action=quit
passport_register=register.php
open_phpwind=0
open_dedecms=0
open_discuz=0
open_x-space=0
open_phpcms=0
open_ecms=0
open_cmsware=0
discuz_url=
xspace_url=
phpwind_path=http://localhost/multishop/branches/multishop_phpwind6/bbs
dedecms_path=
phpcms_path=
ecms_path=
cmsware_path=
cmsware_path_absolut=cmswarenew
ecms_path_absolut=ECMS
cmsware_TransactionAccessKey=a88efcccf068814b9a732ca0c13d0a5b
api_charset=utf-8
[ucenter]
##  uc_connect=mysql数据库连接类型
##  uc_dbhost=localhost数据库服务器地址
##  uc_dbuser=root数据库用户名
##  uc_dbpw=root数据库密码
##  uc_dbname=ucenter数据库名称
##  uc_dbcharset=utf8 UC数据库编码
##  uc_dbtablepre=uc_ 数据库表前缀
##  uc_dbconnect=0 用户中心数据库连接方式是否是持久连接,0为非持久连接,1为持久连接
##  uc_api=http://127.0.0.1/UCenter_1.0.0_SC_UTF8/upload UC地址
##  uc_charset=utf-8 UC的编码
##  uc_ip=127.0.0.1 UC的IP
##  uc_appid=1 UC系统接口的编号
##  uc_ppp=20
##  uc_link=true 与UC通讯正常
uc_connect=mysql
uc_dbhost=localhost
uc_dbuser=root
uc_dbpw=root
uc_dbname=ucenter
uc_dbcharset=utf8
uc_dbtablepre=uc_
uc_dbconnect=0
uc_api=http://127.0.0.1/UCenter
uc_charset=utf-8
uc_ip=127.0.0.1
uc_appid=1
uc_ppp=20
uc_link=true
[stats]
## 统计系统配置信息
##  datapath 统计文件路径
##  ippath IP数据文件路径
##  keywordpath 前台搜索关键词记录文档
##  ifsearch 搜索关键词时是否关联其他关键词，0为否，1为是
datapath=/share/statdata
ippath=/share/ipdata
keywordpath=/share/keyword
ifsearch=0
[subdomain]
## 店铺二级域名设置，注意此功能需开启服务器泛域名方能启用
##  ifsubdomain=0 是否开启店铺二级域名，0为关闭，1为开启此功能
##  domainprefix=shop 二级域名前缀
##  domainroot= 二级域名根域名
ifsubdomain=0
domainprefix=
domainroot=
[link]
## 友情链接 设置参数
##  pic_width 前台显示图片的宽度
##  pic_height 前台显示图片的高度
##  ifpic 前台显示模式，1为图片显示 0为文字显示
pic_width=88
pic_height=31
[gdimage]
## 水印 设置参数
## wm_image_sign 是否开启水印功能，0为不开启，1为开启
## wm_image_name 水印图片的文件名(必须包含路径名)
## wm_image_pos 水印图片放置的位置
## wm_image_transition 水印图片与原图片的融合度
wm_image_sign=0
wm_image_name=
wm_image_pos=1
wm_image_transition=22
[paymode]
## 店铺缴费模式0为关闭1为开启
shop_pay_mode=0
[countdown]
## 倒计时拍卖保证金比例设置
## seller_margin 卖家保证金比例
## buyer_margin  买家保证金比例
seller_margin=10
buyer_margin=10
[payment]
##  支付方式,该参数区域必须放在配置文件最后,切记！！！！
offline=1
?>