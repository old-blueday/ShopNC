-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2009 年 03 月 09 日 18:18
-- 服务器版本: 5.2.3
-- PHP 版本: 5.2.3
-- 
-- 数据库: 'shopnc60'
-- 

-- 
-- 导出表中的数据 'shopnc_article'
-- 

INSERT INTO @shopnc@article (article_id, article_class_id, article_title, article_author, article_keywords, article_description, article_body, article_hit, article_sort, article_state, article_url, article_type, article_commend, article_time, provider_id) VALUES 
(1, 1, 'ShopNC6.0网店系统发布啦', '', '', '', 'ShopNC6.0网店系统发布啦', 0, 0, 1, '', 0, '0', '1222047912', NULL);

-- 
-- 导出表中的数据 'shopnc_article_class'
-- 

INSERT INTO @shopnc@article_class (article_class_id, article_class_name, article_class_topid, article_class_state, article_class_keywords, article_class_description, article_class_sort, article_class_url, article_class_menu) VALUES 
(4, '最新新闻', 0, 1, 'sd', 'dddd', 0, '', 0),
(6, '网店行情', 0, 1, '', '', 0, '', 0),
(7, 'seo优化', 0, 1, '', '', 0, '', 0),
(8, '百度seo', 7, 1, '', '', 0, '', 0),
(9, 'google', 7, 1, '', '', 0, '', 0);

-- 
-- 导出表中的数据 'shopnc_ask_cate'
-- 

INSERT INTO @shopnc@ask_cate (ac_id, cate_name, if_issue, if_marked, reply_body, create_time) VALUES 
(2, '一般问题', '1', '1', '很好，很好', '1233566043');

-- 
-- 导出表中的数据 'shopnc_goods'
-- 

INSERT INTO @shopnc@goods (`goods_id`, `goods_name`, `goods_bn`, `class_id`, `brand_id`, `subject_id`, `goods_price`, `goods_pricedesc`, `goods_provider_price`, `goods_storage`, `goods_alarm_num`, `goods_alarm_text`, `goods_weight`, `goods_unit`, `goods_color`, `goods_size`, `goods_click`, `provider_id`, `goods_image`, `goods_small_image`, `goods_keywords`, `goods_description`, `goods_body`, `goods_add_time`, `goods_state`, `goods_hot`, `goods_commend`, `goods_special`, `goods_attr_body`, `goods_link_goods`, `goods_link_article`) VALUES 
(58, '粒按扣VIVI时尚连帽瑞丽中袖百搭外套送吊带', 'nc0001', 21, 0, 0, 58.00, 46.00, 0.00, 10, 0, '库存不足', 0, '件', '白色|黑色', '', 0, 0, 'attachments/upimg/2009/03/123797216349c9f4c3445a6.jpg', 'attachments/upimg/2009/03/123797216349c9f4c3445a6_small.jpg', '', '', '<!-- shopnc -->\r\n<p>舒适柔顺的面料，十分百搭又耐看的款式，简洁的一颗钮扣款式设计，无论是休闲写意的风格，还是斯文大方的风格，都能让你从容面对，利用率是相当高的。这款YY的修身效果也是一流的哦，穿上后除了很显气质的同时~也是非常显瘦的。所以既适合与裤子搭配~也适合与裙子搭配在一起，效果都是让人意想不到的好呢～</p>', '1237972163', 1, '0', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(59, '韩版时尚泡泡袖休闲束身短外套', 'nc0002', 21, 0, 0, 122.00, 100.00, 0.00, 10, 0, '库存不足', 0, '件', '白色|黑色', '', 0, 0, 'attachments/upimg/2009/03/123797242649c9f5cacc637.jpg', 'attachments/upimg/2009/03/123797242649c9f5cacc637_small.jpg', '', '', '<!-- shopnc -->\r\n<p>&nbsp;</p>', '1237972427', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(60, '清新款式的双排扣短上衣短外套', 'nc0003', 21, 0, 0, 120.00, 100.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797260349c9f67b8beca.jpg', 'attachments/upimg/2009/03/123797260349c9f67b8beca_small.jpg', '', '', '<!-- shopnc -->\r\n<p>款式简洁大方 穿着舒适利落 清新的款式富有视觉吸引效果~（含里衬）袖子中间有皮质的材质，更显帅气．</p>\r\n<p>&nbsp;</p>', '1237972603', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(61, '韩版时尚百搭休闲长袖上衣', 'nc0004', 21, 0, 0, 120.00, 100.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797290149c9f7a5df92b.jpg', 'attachments/upimg/2009/03/123797290149c9f7a5df92b_small.jpg', '', '', '<!-- shopnc -->\r\n<p><br />\r\n&nbsp;</p>', '1237972902', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(62, '伊自尚92016天丝印花束领绳蝙蝠式长袖上衣', 'nc0005', 21, 0, 0, 260.00, 240.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797301349c9f81509f77.jpg', 'attachments/upimg/2009/03/123797301349c9f81509f77_small.jpg', '', '', '<!-- shopnc -->', '1237973013', 1, '0', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(63, 'Mi-9007#韩版波浪边压褶开领小衫', 'nc0006', 21, 0, 0, 50.00, 40.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797310349c9f86f2532e.jpg', 'attachments/upimg/2009/03/123797310349c9f86f2532e_small.jpg', '', '', '', '1237973103', 1, '0', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', '');

-- 
-- 导出表中的数据 'shopnc_goods_class'
-- 

INSERT INTO @shopnc@goods_class  (`class_id`, `class_top_id`, `class_name`, `goods_type_id`, `class_state`, `class_keywords`, `class_description`, `class_sort`, `class_language`, `class_url`, `class_other_attr`, `class_menu`) VALUES 
(20, 0, '女装', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(21, 20, '外套', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(22, 20, 'T恤', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(23, 20, '裙子', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(24, 20, '裤子', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(25, 20, '针织衫', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(26, 20, '毛衣', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0');


-- 
-- 导出表中的数据 'shopnc_goods_image'
-- 

INSERT INTO @shopnc@goods_image (`goods_image_id`, `goods_id`, `goods_image_title`, `goods_image`, `goods_image_small`) VALUES 
(49, 58, '', 'attachments/upimg/2009/03/123797216249c9f4c29c674.jpg', 'attachments/upimg/2009/03/123797216249c9f4c29c674_small.jpg'),
(50, 58, '', 'attachments/upimg/2009/03/123797216249c9f4c2efc3e.jpg', 'attachments/upimg/2009/03/123797216249c9f4c2efc3e_small.jpg'),
(51, 59, '', 'attachments/upimg/2009/03/123797242649c9f5ca16e39.jpg', 'attachments/upimg/2009/03/123797242649c9f5ca16e39_small.jpg'),
(52, 59, '', 'attachments/upimg/2009/03/123797242649c9f5ca7817f.jpg', 'attachments/upimg/2009/03/123797242649c9f5ca7817f_small.jpg'),
(53, 60, '', 'attachments/upimg/2009/03/123797260249c9f67ab71b3.jpg', 'attachments/upimg/2009/03/123797260249c9f67ab71b3_small.jpg'),
(54, 60, '', 'attachments/upimg/2009/03/123797260349c9f67b26ed5.jpg', 'attachments/upimg/2009/03/123797260349c9f67b26ed5_small.jpg'),
(55, 61, '', 'attachments/upimg/2009/03/123797290149c9f7a53938a.jpg', 'attachments/upimg/2009/03/123797290149c9f7a53938a_small.jpg'),
(56, 61, '', 'attachments/upimg/2009/03/123797290149c9f7a58e184.jpg', 'attachments/upimg/2009/03/123797290149c9f7a58e184_small.jpg'),
(57, 62, '', 'attachments/upimg/2009/03/123797301249c9f81440d9c.jpg', 'attachments/upimg/2009/03/123797301249c9f81440d9c_small.jpg'),
(58, 62, '', 'attachments/upimg/2009/03/123797301249c9f814a19ba.jpg', 'attachments/upimg/2009/03/123797301249c9f814a19ba_small.jpg'),
(59, 63, '', 'attachments/upimg/2009/03/123797310249c9f86e7641a.jpg', 'attachments/upimg/2009/03/123797310249c9f86e7641a_small.jpg'),
(60, 63, '', 'attachments/upimg/2009/03/123797310249c9f86ec8f95.jpg', 'attachments/upimg/2009/03/123797310249c9f86ec8f95_small.jpg');


-- 
-- 导出表中的数据 'shopnc_link'
-- 

INSERT INTO @shopnc@link (link_id, link_url, link_web_name, link_logo, link_logo_width, link_logo_height, link_email, link_sort, link_state, link_time) VALUES 
(1, 'http://www.shopnc.net/', '网城创想', 'attachments/linklogo/122940542449473cf00b71e.gif', 0, 0, NULL, 0, 1, '1229405424');

-- 
-- 导出表中的数据 'shopnc_subject'
-- 

INSERT INTO @shopnc@subject (subject_id, subject_name, subject_image, subject_image_width, subject_image_height, subject_state, subject_url, subject_sort, subject_body, subject_keywords, subject_description) VALUES 
(1, '情人节', 'attachments/subjectimg/123658856849b4d818d1cf2.jpg', 640, 132, 1, '', 2, '', '', '');

-- 
-- 导出表中的数据 'shopnc_user_grade'
-- 

INSERT INTO @shopnc@user_grade (grade_id, grade_name, grade_time, grade_discount, grade_state) VALUES 
(2, '超级新星', 2, '9', 1);

-- 
-- 导出表中的数据 'shopnc_vote'
-- 

INSERT INTO @shopnc@vote (vote_id, vote_title, vote_start_time, vote_end_time, vote_type, vote_member, vote_refresh, vote_state, vote_time) VALUES 
(1, '您是从什么地方知道本站的？', '2009-2-15', '2009-12-17', '0', '1', '1', '1', '1221893376');

-- 
-- 导出表中的数据 'shopnc_vote_option'
-- 

INSERT INTO @shopnc@vote_option (option_id, vote_id, option_tile, option_num, option_sort) VALUES 
(1, 1, '百度', 2, 0),
(2, 1, 'google', 5, 0),
(3, 1, '朋友介绍', 9, 0),
(4, 1, '其他', 4, 0),
(5, 1, '还有什么', 1, 0);
