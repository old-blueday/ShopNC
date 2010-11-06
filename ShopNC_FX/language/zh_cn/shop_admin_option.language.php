<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : shop_admin_option.language.php D:\binzi\jh_shopnc6\language\zh_cn\shop_admin_option.language.php
* 后台工具管理语言包
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Wed Apr 22 15:38:54 CST 2009
*/
/*=================================通用语言包============================*/
$language['admin_system_submit']				= '点此保存';
$language['admin_system_reset']					= '重置';
$language['admin_system_choice_please']			= '请选择';
$language['shop_admin_header_system_manage']	= '系统管理';
/*=================================管理员设置============================*/
$language['admin_user_add']						= "添加管理员";
$language['admin_user_list']					= "管理员列表";

$language['admin_user_name']					= "用户名";
$language['admin_new_passwd']					= "新密码";
$language['admin_old_passwd']					= "原密码";
$language['admin_passwd']						= "密码";
$language['admin_new_passwd1']					= "确认密码";
$language['admin_user_state']					= "管理员当前状态";

$language['admin_user_del']						= "删除";
$language['admin_user_last_time']				= "最后登录时间";
$language['admin_user_edit']					= "编辑管理员";
$language['admin_user_log']						= "查看日志";
$language['admin_user_cmpetence']				= "分配权限";
$language['admin_user_oper']					= "操作";

$language['admin_cmpetence_all_select']			= "全选";
$language['admin_cmpetence_submit']				= "提交";

$language['admin_user_name_null']				= '管理员用户名不能为空';
$language['admin_user_email_null']				= '邮件地址不能为空';
$language['admin_user_email_error']				= '非法的邮件地址';
$language['admin_user_passwd_null']				= '密码不能为空';
$language['admin_user_passwd_conf']				= '确认密码不能为空';
$language['admin_two_passwd_same']				= '两次输入的密码不相同';
$language['admin_passwd_error']					= '密码输入错误';
$language['admin_user_modify_ok']				= '管理员信息修改成功';
$language['admin_user_modify_false']			= '管理员信息修改失败';
$language['admin_user_add_ok']					= '管理员添加成功';
$language['admin_user_add_false']				= '管理员添加失败';
$language['admin_user_del_conf']				= '您确实要删除该管理员吗？';
$language['admin_user_del_ok']					= '管理员删除成功';
$language['admin_user_del_false']				= '管理员删除失败';
$language['admin_cmpetence_ok']					= '权限修改成功';
$language['admin_cmpetence_false']				= '权限修改失败';

$language['admin_user_state_open']				= '开启';
$language['admin_user_state_close']				= '关闭';
$language['admin_user_save']					= '点此保存';
$language['admin_user_reset']					= '重置';
/*=================================邮件设置============================*/
$language['admin_system_email']			= '邮件设置';
$language['admin_system_email_config']			= '参数设置';
$language['admin_system_email_type']			= '邮件发送类型';
$language['admin_system_email_use_mail']		= '系统内置mail发送';
$language['admin_system_email_use_smtp']		= '系统内置smtp发送';
$language['admin_system_email_hosting']			= 'smtp服务器';
$language['admin_system_email_smtp_id']			= 'smtp邮箱帐户';
$language['admin_system_email_smtp_pw']			= 'smtp邮箱密码';
$language['admin_system_email_smtp_port']		= 'smtp服务端口';
$language['admin_system_email_smtp_validate']	= 'smtp身份验证';
$language['admin_system_email_smtp_yes']		= '是';
$language['admin_system_email_smtp_no']			= '否';
$language['admin_system_email_display_mail']	= '显示的邮箱';

$language['admin_system_email_send']			= '邮件发送';
$language['admin_system_email_new_user']		= '新商家入住';
$language['admin_system_virtual_card_send']		= '虚拟卡发货';

$language['admin_send_email']					= '发送邮件';
$language['admin_no_send_email']				= '不发送邮件';
$language['admin_send_template']				= '查看该邮件模板';

$language['admin_email_tempalte']				= '邮件模板';
$language['admin_email_template_name']			= '模板名称';
$language['admin_email_template_body']			= '模板内容';
$language['admin_email_template_save']			= '点此保存';
$language['admin_email_template_save_ok']		= '邮件模板修改成功';
$language['admin_email_template_save_false']	= '邮件模板修改失败';

$language['admin_system_email_site_mail']		= '邮件设置成功';
$language['admin_system_email_string_min']		= '最少3位';
$language['admin_system_email_string_max']		= '最多30位';
$language['admin_system_email__mail_error']		= '邮箱格式不正确';
$language['admin_system_email_num']				= '需要填写数字';
$language['admin_system_email_hosting_null']	= 'smtp服务器不能为空';
$language['admin_system_email_smtp_id_null']	= 'smtp邮箱帐户不能为空';
$language['admin_system_email_smtp_pw_null']	= 'smtp邮箱密码不能为空';
$language['admin_system_email_smtp_port_null']		= 'smtp服务端口不能为空';
$language['admin_system_email_display_mail_null']	= '显示的邮箱不能为空';
/*=================================基本设置============================*/
$language['shop_admin_system_base_domain']		= '域名';
$language['shop_admin_system_base_website']		= '网站地址';
$language['shop_admin_system_base_shopname']	= '商城名称';
$language['shop_admin_system_shop_user']		= '店主名称';
$language['shop_admin_system_base_male']		= '男';
$language['shop_admin_system_base_female']		= '女';
$language['shop_admin_system_base_system_lan']	= '后台语言';
$language['shop_admin_system_base_money']		= '货币选择';
$language['shop_admin_system_base_money_add']	= '货币添加';
$language['shop_admin_system_base_fax']			= '传真';
$language['shop_admin_system_base_shop_state']	= '网店状态';
$language['shop_admin_system_base_phone']		= '电话';
$language['shop_admin_system_base_icp']			= 'icp备案';
$language['shop_admin_system_base_address']		= '详细地址';
$language['shop_admin_system_base_keyword']		= '关键字';
$language['shop_admin_system_base_post']		= '邮编';
$language['shop_admin_system_base_description']	= '描述';
$language['shop_admin_system_base_shop_logo']	= '网店LOGO';
$language['shop_admin_system_base_copyright']	= '版权信息';
$language['shop_admin_system_base_save']		= '点击保存';
$language['shop_admin_system_base_reset']		= '重置';
$language['shop_admin_system_base_save_ok']		= '设置成功';
$language['shop_admin_system_base_save_false']	= '设置失败';
$language['shop_admin_system_basic_front_lang']	= '前台语言';
$language['shop_admin_system_basic_width']		= '宽';
$language['shop_admin_system_basic_height']		= '高';
$language['shop_admin_system_basic_site_state_off']		= '关闭';
$language['shop_admin_system_basic_site_state_on']		= '开启';
$language['shop_admin_system_site']						= '基本设置';
$language['shop_admin_system_basic_lang_add']			= '语言管理';
$language['shop_admin_system_basic_search_sub']			= '搜索子店发布的商品';
$language['shop_admin_system_basic_search_main']		= '搜索子店选取主店的商品';
$language['shop_admin_system_basic_pay_receive_type']	= '收款模式';
$language['shop_admin_system_basic_pay_receive_main']	= '主店收款';
$language['shop_admin_system_basic_pay_receive_sub']	= '子店收款';

/*=================================系统信息============================*/
$language['admin_system_info_name']				= '系统信息';
$language['admin_system_info_title']			= '信息标题';
$language['admin_system_info_url']				= '是否外链';
$language['admin_system_info_oper']				= '操作';
$language['admin_system_info_edit']				= '编辑';
$language['admin_system_info_title_null']		= '信息标题不能为空！';
$language['admin_system_info_url_error']		= '外联开头必须包含http://';
/*=================================编辑系统信息============================*/
$language['admin_system_info_edit_head']		= '系统信息编辑';
$language['admin_system_info_edit_title']		= '信息标题';
$language['admin_system_info_edit_url']			= '外链地址';
$language['admin_system_info_edit_body']		= '信息内容';
$language['admin_system_info_list']				= '信息列表';
$language['admin_system_info_edit_save']		= '点此保存';

$language['admin_system_info_save_true']		= '信息保存成功';
$language['admin_system_info_save_false']		= '信息保存失败';
/*=================================图片设置语言包============================*/
$language['admin_system_upload']			= "图片上传设置";
$language['admin_system_upload_size']		= "最大上传尺寸";
$language['admin_system_upload_ext']		= "允许上传的图片扩展名";
$language['admin_system_upload_type']		= "图片存放类型";
$language['admin_system_upload_type_1']		= "按文件类型存放（如，htm/a.jpg）";
$language['admin_system_upload_type_2']		= "按年份存放（如，htm/2007/a.jpg)";
$language['admin_system_upload_type_3']		= "按月份存放（如，htm/2007/07/a.jpg）";
$language['admin_system_upload_type_4']		= "按日期存放（如，htm/2007/07/12/a.jpg）";
$language['admin_system_upload_image_width']= "图片缩微图宽度";
$language['admin_system_upload_type_height']= "图片缩微图高度";
$language['admin_system_upload_path']		= "产品图像存放路径";

$language['admin_goods_wm']					= "图片水印设置";
$language['admin_goods_wm_uploads']			= "上传的图片是否使用水印功能";
$language['admin_goods_wm_yes']				= "是";
$language['admin_goods_wm_no']				= "否";
$language['admin_goods_wm_type']			= "使用水印类型";
$language['admin_goods_wm_image']			= "水印图片";
$language['admin_goods_wm_text']			= "水印文字";
$language['admin_goods_wm_pic_control']		= "添加水印的图片大小控制";
$language['admin_goods_wm_width']			= "宽";
$language['admin_goods_wm_height']			= "高";
$language['admin_goods_wm_pic_name']		= "水印图片文件名";
$language['admin_goods_wm_upload_new_pic']	= "上传新图片";
$language['admin_goods_wm_pic_support']		= "你的系统支持的图片格式：GIF JPEG PNG";
$language['admin_goods_wm_pic_text']		= "水印文字(目前暂不支持<font color='red'>中文</font>)";
$language['admin_goods_wm_font_size']		= "水印文字字体大小";
$language['admin_goods_wm_font_color']		= "水印文字颜色（默认#FF0000为红色）";
$language['admin_goods_wm_trans']			= "水印透明度（0-100，值越小越透明）";
$language['admin_goods_wm_position']		= "水印位置";
$language['admin_goods_wm_top_center']		= "顶部居中";
$language['admin_goods_wm_top_left']		= "顶部居左";
$language['admin_goods_wm_top_right']		= "顶部居右";
$language['admin_goods_wm_center_left']		= "左边距中";
$language['admin_goods_wm_center_center']	= "图片中心";
$language['admin_goods_wm_center_right']	= "右边居中";
$language['admin_goods_wm_bottom_left']		= "底部居左";
$language['admin_goods_wm_bottom_center']	= "底部居中";
$language['admin_goods_wm_bottom_right']	= "底部居右";
$language['admin_system_wm_bottom_save']	= '点此保存';
$language['admin_system_wm_site_ok']		= '图片设置成功';

$language['admin_system_upload_size_null']		= "最大上传尺寸不能为空";
$language['admin_system_upload_image_width_null']= "图片缩微图宽度不能为空";
$language['admin_system_upload_type_height_null']= "图片缩微图高度不能为空";
$language['admin_goods_wm_width_null']			= "宽不能为空";
$language['admin_goods_wm_height_null']			= "高不能为空";
$language['admin_goods_wm_font_size_null']		= "水印文字字体大小不能为空";
$language['admin_goods_wm_trans_null']			= "水印透明度不能为空";
$language['admin_goods_wm_num']					= "必须填入数字";
$language['admin_goods_wm_num_min']				= "最小值为10";
$language['admin_goods_wm_font_size_min']		= "字体大小最小值为1";
$language['admin_goods_wm_trans_min']			= "最小值为0";
$language['admin_goods_wm_trans_max']			= "最大值为100";
?>