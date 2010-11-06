<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : admin_tool.language.php D:\binzi\shopnc6\language\zh_cn\admin_tool.language.php
* 后台工具管理语言包
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Fri Jul 18 10:49:09 CST 2008
*/

/*=================================友情链接语言包============================*/
$language['admin_tool_link_list']			= "友情链接列表";
$language['admin_tool_link_add_url']		= "网站地址";
$language['admin_tool_link_add_name']		= "网站名称";
$language['admin_tool_link_add_sort']		= "排列顺序";
$language['admin_tool_link_add_email']		= "站长邮箱";
$language['admin_tool_link_add_type']		= "链接类型";
$language['admin_tool_link_add_logo']		= "网站logo";
$language['admin_tool_link_add_image']		= "图片";
$language['admin_tool_link_add_text']		= "文字";
$language['admin_tool_link_add_uplogo']		= "上传logo";
$language['admin_tool_link_add_state']		= "链接状态";
$language['admin_tool_link_add_state_open']	= "开启";
$language['admin_tool_link_add_state_close']= "关闭";
$language['admin_tool_link_add_submit']		= "点击保存";
$language['admin_tool_link_add_reset']		= "重置";
$language['admin_tool_link_add_url_null']	= "网站地址不能为空！";
$language['admin_tool_link_add_name_null']	= "网站名称不能为空！";
$language['admin_tool_link_add_succ']		= "添加友情链接操作成功";
$language['admin_tool_link_add_modify_succ']= "修改友情链接操作成功";
$language['admin_tool__link_add_add_fill']	= "添加友情链接操作失败";
$language['admin_tool__link_add_url_error']	= "网站地址前必须包含http://";

$language['admin_tool_link_add']			= "添加友情链接";
$language['admin_tool_link_list_name']		= "网站名称";
$language['admin_tool_link_list_logo']		= "网站logo";
$language['admin_tool_link_list_email']		= "站长邮箱";
$language['admin_tool_link_list_time']		= "时间";
$language['admin_tool_link_list_state']		= "状态";
$language['admin_tool_link_list_sort']		= "排序";
$language['admin_tool_link_list_text']		= "文字";
$language['admin_tool_link_list_oper']		= "操作";
$language['admin_tool_link_list_del']		= "删除";
$language['admin_tool_link_list_edit']		= "编辑友情链接";
$language['admin_tool_link_list_edit_state']= "修改状态";
$language['admin_tool_link_list_del_succ']	= "删除友情链接操作成功";
$language['admin_tool_link_list_del_info']	= "您确实要删除此友情链接吗？";
$language['admin_tool_link_add_add_fill']	= "删除友情链接操作失败";

/*=================================数据库管理语言包============================*/
$language['admin_tool_sql_backup']			= "数据备份";
$language['admin_tool_sql_revert']			= "数据还原";
$language['admin_tool_sql_backup_info']		= "为了您的数据库安全，建议您定期备份数据库";
$language['admin_tool_sql_backup_type']		= "备份类型";
$language['admin_tool_sql_backup_nc']		= "网店数据表";
$language['admin_tool_sql_backup_all']		= "所有数据表";
$language['admin_tool_sql_backup_size']		= "分卷大小";
$language['admin_tool_sql_backup_disc']		= "文件备注";
$language['admin_tool_sql_backup_size_null']= "分卷大小不能为空！";
$language['admin_tool_sql_backup_size_min'] = "分卷大小最小为10！";
$language['admin_tool_sql_backup_disc_null']= "文件备注不能为空！";
$language['admin_tool_sql_backup_submit']	= "开始备份";
$language['admin_tool_sql_backup_ok']		= "备份成功";
$language['admin_tool_sql_backup_false']	= "备份失败";

$language['admin_tool_sql_revert_info']		= "还原已备份的网店数据库，此操作会使用备份数据库的数据覆盖当前数据库所有数据。";
$language['admin_tool_sql_revert_sql']		= "还原";
$language['admin_tool_sql_revert_del']		= "删除";
$language['admin_tool_sql_revert_dir']		= "备份目录";
$language['admin_tool_sql_revert_time']		= "备份时间";
$language['admin_tool_sql_revert_zip']		= "压缩";
$language['admin_tool_sql_revert_size']		= "大小";
$language['admin_tool_sql_revert_oper']		= "操作";
$language['admin_tool_sql_revert_down']		= "下载";
$language['admin_tool_sql_revert_null']		= "无";
$language['admin_tool_sql_revert_ok']		= "数据库恢复成功";
$language['admin_tool_sql_revert_false']	= "数据库恢复失败";
$language['admin_tool_sql_zip_ok']			= "压缩成功";
$language['admin_tool_sql_zip_false']		= "压缩失败";
$language['admin_tool_sql_del_conf']		= "您确实要删除该备份目录吗？";
$language['admin_tool_sql_del_ok']			= "备份目录删除成功";
$language['admin_tool_sql_del_false']		= "备份目录删除失败";

/*=================================日志管理============================*/
$language['admin_tool_log_user']			= "执行人";
$language['admin_tool_log_group']			= "执行人级别";
$language['admin_tool_log_ip']				= "ip地址";
$language['admin_tool_log_time']			= "执行时间";
$language['admin_tool_log_info']			= "执行记录";
$language['admin_tool_log_del']				= "删除";
$language['admin_tool_log_clear']			= "清理日志";
$language['admin_tool_log_select']			= "请选择";
$language['admin_tool_log_search']			= "日志搜索";
$language['admin_tool_log_one_week']		= "一周前";
$language['admin_tool_log_one_month']		= "一个月前";
$language['admin_tool_log_three_month']		= "三个月前";
$language['admin_tool_log_six_month']		= "半年前";
$language['admin_tool_log_year']			= "一年前";
$language['admin_create_user']				= "超级管理员";
$language['admin_user']						= "一般管理员";
$language['admin_tool_log_all']				= "全部";
$language['admin_tool_log_del_select_time']	= "请选择清理时间";
$language['admin_tool_log_del_ok']			= "日志删除成功";
$language['admin_tool_log_del_false']		= "日志删除失败";

/*=================================投票管理============================*/ 
$language['admin_tool_vote_add']            = "添加投票";
$language['admin_tool_vote_name']           = "投票名称";
$language['admin_tool_vote_start']          = "开始时间";
$language['amdin_tool_vote_end']            = "结束时间";
$language['admin_tool_vote_repeat']         = "可重复投票";
$language['admin_tool_vote_member']         = "只可会员投票";
$language['admin_tool_vote_yes']            = "是";
$language['admin_tool_vote_no']             = "否";
$language['admin_tool_vote_type']           = "类型";
$language['admin_tool_vote_type_single']    = "单选";
$language['admin_tool_vote_type_multi']     = "多选";
$language['admin_tool_vote_state']          = "状态";
$language['admin_tool_vote_on']             = "开启";
$language['admin_tool_vote_off']            = "关闭";
$language['admin_tool_vote_select']         = "投票选项";
$language['admin_tool_vote_content']        = "内容";
$language['admin_tool_vote_num']            = "票数";
$language['admin_tool_vote_sort']           = "排序";
$language['admin_tool_vote_select_add']     = "增加选项";
$language['admin_tool_vote_add']         	= "增加投票";
$language['admin_tool_vote_del']         	= "取消";
$language['admin_tool_vote_submit']         = "点此保存";
$language['admin_tool_vote_reset']          = "重置";
$language['admin_tool_vote_name_null']      = "投票名称不能为空！";
$language['admin_tool_vote_option_max']     = "最大只允许20个选项";
$language['admin_tool_vote_state_time_null']= "请填写开始时间";
$language['admin_tool_vote_end_time_null']	= "请填写结束时间";
$language['admin_tool_vote_save_ok']     	= "投票添加成功";
$language['admin_tool_vote_save_false']     = "投票添加失败";
$language['admin_tool_vote_edit_ok']     	= "投票修改成功";
$language['admin_tool_vote_edit_false']     = "投票修改失败";
$language['admin_tool_vote_del_ok']    		= "投票删除成功";
$language['admin_tool_vote_del_false']     	= "投票删除失败";

$language['admin_tool_vote_list']           = "投票列表";
$language['admin_tool_vote_type']           = "投票类型";
$language['admin_tool_vote_oper']           = "操作";
$language['admin_tool_vote_edit']           = "编辑投票";
$language['admin_tool_vote_edit_state']     = "状态修改";
$language['admin_tool_vote_del']            = "删除";
$language['admin_tool_vote_del_conf']       = "您确实要删除该投票吗？";

/*=================================广告管理============================*/ 
$language['admin_tool_ad']                  = "广告管理";
$language['admin_tool_ad_add']              = "添加广告";
$language['admin_tool_ad_edit1']            = "编辑广告";
$language['admin_tool_ad_name']             = "广告名称";
$language['admin_tool_ad_type']             = "广告类型";
$language['admin_tool_ad_select']           = "===请选择===";
$language['admin_tool_ad_type_pic']         = "图片";
$language['admin_tool_ad_type_flash']       = "Flash";
$language['admin_tool_ad_type_code']        = "代码";
$language['admin_tool_ad_type_tx']          = "文字";
$language['admin_tool_ad_position']         = "广告位置";
$language['admin_tool_ad_url']              = "广告URL";
$language['admin_tool_ad_info']              = "广告描述";
$language['admin_tool_ad_pic']              = "广告图片";
$language['admin_tool_ad_pic_good']         = "    (最佳图片 宽:500 高:180)";
$language['admin_tool_ad_pic_url']          = "图片网址";
$language['admin_tool_ad_flash']            = "上传Flash";
$language['admin_tool_ad_flash_url']        = "Flash网址";
$language['admin_tool_ad_code']             = "输入广告代码";
$language['admin_tool_ad_content']          = "广告内容";
$language['admin_tool_ad_state']            = "广告状态";
$language['admin_tool_ad_state_on']         = "开启";
$language['admin_tool_ad_state_off']        = "关闭";
$language['admin_tool_ad_start']            = "开始时间";
$language['admin_tool_ad_end']              = "结束时间";
$language['admin_tool_ad_contact']          = "联系人";
$language['admin_tool_ad_email']            = "联系邮箱";
$language['admin_tool_ad_tel']              = "联系电话";
$language['admin_tool_ad_submit']			= "点此保存";
$language['admin_tool_ad_reset']			= "重置";
$language['admin_tool_ad_name_null']        = "广告名称不能为空！";
$language['admin_tool_ad_type_null']        = "广告类型不能为空！";
$language['admin_tool_ad_position_null']    = "广告位置不能为空！";
$language['admin_tool_ad_save_ok']          = "广告保存成功";
$language['admin_tool_ad_save_false']       = "广告保存失败";
$language['admin_tool_ad_edit_ok']          = "广告修改成功";
$language['admin_tool_ad_edit_false']       = "广告修改失败";

$language['admin_tool_ad_list']             = "广告列表";
$language['admin_tool_ad_view']             = "浏览次数";
$language['admin_tool_ad_oper']             = "操作";
$language['admin_tool_ad_js']               = "JS调用";
$language['admin_tool_ad_edit']             = "编辑";
$language['admin_tool_ad_del']              = "删除";
$language['admin_tool_ad_del_info']       	= "你确实要删除该广告吗？";
$language['admin_tool_ad_del_ok']       	= "广告删除成功";
$language['admin_tool_ad_del_false']       	= "广告删除失败";

$language['admin_tool_ad_poster_add']       = "添加广告位";
$language['admin_tool_ad_poster_edit']      = "编辑广告位";
$language['admin_tool_ad_poster_name']      = "广告位名称";
$language['admin_tool_ad_poster_width']     = "广告位宽度";
$language['admin_tool_ad_poster_height']    = "广告位高度";
$language['admin_tool_ad_poster_desc']      = "广告位描述";
$language['admin_tool_ad_poster_code']      = "广告位代码";
$language['admin_tool_ad_poster_px']        = "px";
$language['admin_tool_ad_poster_name_null'] = "广告位名称不能为空！";
$language['admin_tool_ad_poster_width_null']= "广告位宽度不能为空！";
$language['admin_tool_ad_poster_number']	= "必须填写数字！";
$language['admin_tool_ad_poster_height_null']= "广告位高度不能为空！";
$language['admin_tool_ad_poster_desc_null'] = "广告位描述不能为空！";
$language['admin_tool_ad_poster_save_ok']   = "广告位添加成功";
$language['admin_tool_ad_poster_save_false']= "广告位添加失败";
$language['admin_tool_ad_poster_edit_ok']	= "广告位修改成功";
$language['admin_tool_ad_poster_edit_false']= "广告位修改失败";
$language['admin_tool_ad_poster_del_ok']	= "广告位删除成功";
$language['admin_tool_ad_poster_del_false']	= "广告位删除失败";
$language['admin_tool_ad_poster_del_conf']	= "您确实要删除该广告位吗？";

$language['admin_tool_ad_poster_list']      = "广告位列表";

$language['admin_tool_ad_code_type']        = "编码类型";
$language['admin_tool_ad_code_utf8']        = "UTF-8";
$language['admin_tool_ad_code_gb']          = "GB2312";
$language['admin_tool_ad_code_big']         = "BIG5";
$language['admin_tool_ad_js_text']          = "JS文本框";
$language['admin_tool_ad_js_copy']          = "复制JS代码";

/*=================================地图管理============================*/ 
$language['admin_tool_map']                 = "地图管理";
$language['admin_tool_map_info']            = "Sitemaps 服务旨在使用 Feed 文件 sitemap.xml 通知 Google、Yahoo! 以及 Microsoft 等  Cra                                               wler(爬虫)网站上哪些文件需要索引、这些文件的最后修订时间、更改频度、文件位置、相对优先索引权，                                                这些信息将帮助他们建立索引范围和索引的  行为习惯。详细信息请查看 <a href='http://www.sitema                                               ps.org/' target='_blank'>sitemaps.org</a> 网站上的说明。";
$language['admin_tool_map_type']            = "地图类型";
$language['admin_tool_map_type_bisic']      = "普通地图";
$language['admin_tool_map_type_sitemap']    = "Sitemaps地图";
$language['admin_tool_map_home']            = "首页更新";
$language['admin_tool_map_cate']            = "分类更新";
$language['admin_tool_map_content']         = "内容更新";
$language['admin_tool_map_frequency']		= "频率";
$language['admin_tool_map_frequency_select']= "随时更新";
$language['admin_tool_map_frequency_hour']	= "小时";
$language['admin_tool_map_frequency_day']	= "天";
$language['admin_tool_map_frequency_week']	= "周";
$language['admin_tool_map_frequency_month']	= "月";
$language['admin_tool_map_frequency_year']	= "年";
$language['admin_tool_map_frequency_no']	= "不更新";
$language['admin_tool_map_priority']		= "优先级";
$language['admin_tool_map_ok']              = "生成地图";
$language['admin_tool_map_reset']           = "重置";
$language['admin_tool_map_create_ok']       = "地图生成完毕";

$language['admin_tool_map_other']       	= "网店其他";
$language['admin_tool_map_subject']       	= "主题馆";
$language['admin_tool_map_brand']       	= "品牌展示";
$language['admin_tool_map_article']       	= "网店文章";

/*=================================语言包管理============================*/
$language['admin_tool_language_manage']		= "语言包管理";
$language['admin_tool_language_file']		= "语言包文件";
$language['admin_tool_language_save']		= "保存修改";
$language['admin_tool_language_body']		= "语言包内容";

$language['admin_tool_language_select']		= "请选择语言包文件";
$language['admin_tool_language_edit_true']	= "语言包编辑成功";
$language['admin_tool_language_edit_false']	= "语言包编辑失败";

/*=================================模板管理============================*/
$language['admin_tool_templates_manage']	= "模板管理";
$language['admin_tool_templates_file']		= "模板文件";
$language['admin_tool_templates_path']		= "模板路径";
$language['admin_tool_templates_body']		= "模板文件内容";
$language['admin_tool_templates_save']		= "保存修改";

$language['admin_tool_templates_select']	= "请选择模板文件";
$language['admin_tool_templates_edit_true']	= "模板编辑成功";
$language['admin_tool_templates_edit_false']= "模板编辑失败";

/*=================================邮件发送============================*/
$language['admin_tool_mail_user']			= "用户";
$language['admin_tool_mail_title']			= "标题";
$language['admin_tool_mail_centent']		= "内容";
$language['admin_tool_mail_select']			= "请选择";
$language['admin_tool_mail_reg_user']		= "全部注册用户";
$language['admin_tool_mail_book_user']		= "电子订阅全部用户";
$language['admin_tool_mail_month_user']		= "最近一个月的注册用户";
$language['admin_tool_mail_no_shopping']	= "从未购物的注册用户";
$language['admin_tool_mail_all_provider']	= "所有供应商";
$language['admin_tool_mail_send']			= "发送邮件";
$language['admin_tool_mail_reset']			= "重置";
$language['admin_tool_mail_user_null']		= "用户不能为空！";
$language['admin_tool_mail_title_null']		= "标题不能为空！";
$language['admin_tool_mail_centent_null']	= "内容不能为空！";
$language['admin_tool_mail_send_ok']		= "邮件发送成功";
$language['admin_tool_mail_send_false']		= "邮件发送失败";

/*=================================合作提案============================*/
$language['admin_tool_proposal_list']		= "合作提案列表";
$language['admin_tool_proposal_view_title']	= "查看合作提案";
$language['admin_tool_proposal_co_name']	= "公司名称";
$language['admin_tool_proposal_co_man']		= "联系人";
$language['admin_tool_proposal_co_posi']	= "职称";
$language['admin_tool_proposal_co_addr']	= "联系地址";
$language['admin_tool_proposal_co_tel']		= "联系电话";
$language['admin_tool_proposal_co_fax']		= "传真";
$language['admin_tool_proposal_co_mail']	= "E-mail";
$language['admin_tool_proposal_co_site']	= "网址";
$language['admin_tool_proposal_co_type']	= "合作方式";
$language['admin_tool_proposal_co_memo']	= "备注";
$language['admin_tool_proposal_time']		= "时间";
$language['admin_tool_proposal_oper']		= "操作";
$language['admin_tool_proposal_view']		= "查看";
$language['admin_tool_proposal_delete']		= "删除";

?>