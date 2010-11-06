-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2009 年 11 月 08 日 16:49
-- 服务器版本: 5.1.30
-- PHP 版本: 5.2.6
-- 
-- 数据库: `shopnc6_0915`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_ad`
-- 

CREATE TABLE `shopnc_ad` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `ad_title` varchar(50) NOT NULL COMMENT '广告名称',
  `ad_type` varchar(10) NOT NULL COMMENT '广告类型id',
  `position_id` int(11) NOT NULL COMMENT '广告位置id',
  `ad_url` varchar(500) DEFAULT NULL COMMENT '广告url地址',
  `ad_body` varchar(500) NOT NULL COMMENT '广告内容',
  `ad_state` tinyint(1) NOT NULL COMMENT '广告状态，1开启，0关闭',
  `ad_starttime` varchar(20) DEFAULT NULL COMMENT '广告开始时间',
  `ad_endtime` varchar(20) DEFAULT NULL COMMENT '广告结束时间',
  `ad_user` varchar(50) DEFAULT NULL COMMENT '联系人',
  `ad_email` varchar(100) DEFAULT NULL COMMENT '联系人邮箱',
  `ad_call` varchar(100) DEFAULT NULL COMMENT '联系人电话',
  `ad_view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数',
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='广告数据表' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `shopnc_ad`
-- 

INSERT INTO `shopnc_ad` (`ad_id`, `ad_title`, `ad_type`, `position_id`, `ad_url`, `ad_body`, `ad_state`, `ad_starttime`, `ad_endtime`, `ad_user`, `ad_email`, `ad_call`, `ad_view`) VALUES 
(1, '首页广告', 'pic', 1, 'a:5:{i:0;s:21:"http://www.shopnc.net";i:1;s:21:"http://www.shopnc.net";i:2;s:21:"http://www.shopnc.net";i:3;s:21:"http://www.shopnc.net";i:4;s:21:"http://www.shopnc.net";}', 'a:6:{i:0;s:46:"attachments/adfile/12536119224ab8999235680.jpg";i:1;s:46:"attachments/adfile/123725428749bf008fc10df.jpg";i:2;s:46:"attachments/adfile/123725424549bf0065632ed.jpg";i:3;s:46:"attachments/adfile/123725424549bf006570b0a.jpg";i:4;s:46:"attachments/adfile/123725430549bf00a1c28cf.jpg";s:7:"ad_info";a:5:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;N;}}', 0, '', '', '', '', '', 0),
(2, '首页横幅', 'pic', 2, 'http://www.shopnc.net', 'attachments/adfile/123780255949c75e3f29f66.jpg', 1, '2009-3-23', '2009-12-24', '', '', '', 109);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_ad_position`
-- 

CREATE TABLE `shopnc_ad_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告位id',
  `position_name` varchar(100) NOT NULL COMMENT '广告位名称',
  `position_width` int(11) NOT NULL COMMENT '广告位宽度',
  `position_height` int(11) NOT NULL COMMENT '广告位高度',
  `position_info` varchar(100) NOT NULL COMMENT '广告位描述',
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='广告位数据表' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `shopnc_ad_position`
-- 

INSERT INTO `shopnc_ad_position` (`position_id`, `position_name`, `position_width`, `position_height`, `position_info`) VALUES 
(1, '首页广告', 500, 180, '首页广告'),
(2, '首页横幅广告', 670, 90, '首页横幅广告');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_admin`
-- 

CREATE TABLE `shopnc_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `admin_name` varchar(50) NOT NULL COMMENT '管理员名称',
  `admin_password` varchar(32) NOT NULL COMMENT '管理员密码',
  `admin_email` varchar(100) NOT NULL COMMENT '管理员邮箱',
  `admin_state` tinyint(1) NOT NULL COMMENT '管理员状态',
  `admin_cmpetence` text COMMENT '管理员权限',
  `admin_add_time` varchar(10) NOT NULL COMMENT '管理员添加时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_admin`
-- 

INSERT INTO `shopnc_admin` (`admin_id`, `admin_name`, `admin_password`, `admin_email`, `admin_state`, `admin_cmpetence`, `admin_add_time`) VALUES 
(1, 'admin', '21232f297a57a5a7', 'shopnc@shopnc.cn', 1, 'system_all', '1252986473');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_area`
-- 

CREATE TABLE `shopnc_area` (
  `area_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '地区id',
  `area_top_id` int(8) NOT NULL COMMENT '父级id',
  `area_name` varchar(50) NOT NULL COMMENT '地区名称',
  `area_sort` int(11) DEFAULT '0' COMMENT '地区排序',
  `area_info` varchar(100) DEFAULT NULL COMMENT '地区描述',
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='地区数据表' AUTO_INCREMENT=428 ;

-- 
-- 导出表中的数据 `shopnc_area`
-- 

INSERT INTO `shopnc_area` (`area_id`, `area_top_id`, `area_name`, `area_sort`, `area_info`) VALUES 
(1, 0, '中国', 0, NULL),
(2, 1, '北京', 1, NULL),
(3, 1, '天津', 1, NULL),
(4, 1, '河北省', 1, NULL),
(5, 1, '山西', 1, NULL),
(6, 1, '内蒙古', 1, NULL),
(7, 1, '辽宁', 1, NULL),
(8, 1, '吉林', 1, NULL),
(9, 1, '黑龙江', 1, NULL),
(10, 1, '上海', 1, NULL),
(11, 1, '江苏', 1, NULL),
(12, 1, '浙江', 1, NULL),
(13, 1, '安徽', 1, NULL),
(14, 1, '福建', 1, NULL),
(15, 1, '江西', 1, NULL),
(16, 1, '山东', 1, NULL),
(17, 1, '河南', 1, NULL),
(18, 1, '湖北', 1, NULL),
(19, 1, '湖南', 1, NULL),
(20, 1, '广东', 1, NULL),
(21, 1, '广西', 1, NULL),
(22, 1, '海南', 1, NULL),
(23, 1, '重庆', 1, NULL),
(24, 1, '四川', 1, NULL),
(25, 1, '贵州', 1, NULL),
(26, 1, '云南', 1, NULL),
(27, 1, '西藏', 1, NULL),
(28, 1, '陕西', 1, NULL),
(29, 1, '甘肃', 1, NULL),
(30, 1, '青海', 1, NULL),
(31, 1, '宁夏', 1, NULL),
(32, 1, '新疆', 1, NULL),
(33, 1, '香港', 1, NULL),
(34, 1, '台湾', 1, NULL),
(35, 2, '北京', 2, NULL),
(36, 3, '天津市', 2, NULL),
(37, 4, '石家庄', 2, NULL),
(38, 4, '唐山', 2, NULL),
(39, 4, '秦皇岛', 2, NULL),
(40, 4, '邯郸', 2, NULL),
(41, 4, '邢台', 2, NULL),
(42, 4, '保定', 2, NULL),
(43, 4, '张家口', 2, NULL),
(44, 4, '承德', 2, NULL),
(45, 4, '沧州', 2, NULL),
(46, 4, '廊坊', 2, NULL),
(47, 4, '衡水', 2, NULL),
(48, 5, '太原', 2, NULL),
(49, 5, '大同', 2, NULL),
(50, 5, '阳泉', 2, NULL),
(51, 5, '长治', 2, NULL),
(52, 5, '晋城', 2, NULL),
(53, 5, '朔州', 2, NULL),
(54, 5, '晋中', 2, NULL),
(55, 5, '运城', 2, NULL),
(56, 5, '忻州', 2, NULL),
(57, 5, '临汾', 2, NULL),
(58, 5, '吕梁', 2, NULL),
(59, 5, '侯马', 2, NULL),
(60, 5, '五台山', 2, NULL),
(61, 5, '离石', 2, NULL),
(62, 6, '呼和浩特', 2, NULL),
(63, 6, '包头', 2, NULL),
(64, 6, '乌海', 2, NULL),
(65, 6, '赤峰', 2, NULL),
(66, 6, '通辽', 2, NULL),
(67, 6, '鄂尔多斯', 2, NULL),
(68, 6, '呼伦贝尔', 2, NULL),
(69, 6, '巴彦淖尔市', 2, NULL),
(70, 6, '乌兰察布市', 2, NULL),
(71, 6, '兴安盟', 2, NULL),
(72, 6, '锡林郭勒盟', 2, NULL),
(73, 6, '阿拉善盟', 2, NULL),
(74, 7, '沈阳', 2, NULL),
(75, 7, '大连', 2, NULL),
(76, 7, '鞍山', 2, NULL),
(77, 7, '抚顺', 2, NULL),
(78, 7, '本溪', 2, NULL),
(79, 7, '丹东', 2, NULL),
(80, 7, '锦州', 2, NULL),
(81, 7, '营口', 2, NULL),
(82, 7, '阜新', 2, NULL),
(83, 7, '辽阳', 2, NULL),
(84, 7, '盘锦', 2, NULL),
(85, 7, '铁岭', 2, NULL),
(86, 7, '朝阳', 2, NULL),
(87, 7, '葫芦岛市', 2, NULL),
(88, 8, '长春', 2, NULL),
(89, 8, '吉林', 2, NULL),
(90, 8, '四平', 2, NULL),
(91, 8, '辽源', 2, NULL),
(92, 8, '通化', 2, NULL),
(93, 8, '白山', 2, NULL),
(94, 8, '松原', 2, NULL),
(95, 8, '白城', 2, NULL),
(96, 8, '延边', 2, NULL),
(97, 9, '哈尔滨', 2, NULL),
(98, 9, '齐齐哈尔', 2, NULL),
(99, 9, '鸡西', 2, NULL),
(100, 9, '鹤岗', 2, NULL),
(101, 9, '双鸭山', 2, NULL),
(102, 9, '大庆', 2, NULL),
(103, 9, '伊春', 2, NULL),
(104, 9, '佳木斯', 2, NULL),
(105, 9, '七台河', 2, NULL),
(106, 9, '牡丹江', 2, NULL),
(107, 9, '黑河', 2, NULL),
(108, 9, '绥化', 2, NULL),
(109, 9, '大兴安岭', 2, NULL),
(110, 10, '上海', 2, NULL),
(111, 11, '南京', 2, NULL),
(112, 11, '无锡', 2, NULL),
(113, 11, '徐州', 2, NULL),
(114, 11, '常州', 2, NULL),
(115, 11, '苏州', 2, NULL),
(116, 11, '南通', 2, NULL),
(117, 11, '连云港', 2, NULL),
(118, 11, '淮安', 2, NULL),
(119, 11, '盐城', 2, NULL),
(120, 11, '扬州', 2, NULL),
(121, 11, '镇江', 2, NULL),
(122, 11, '泰州', 2, NULL),
(123, 11, '宿迁', 2, NULL),
(124, 12, '杭州', 2, NULL),
(125, 12, '宁波', 2, NULL),
(126, 12, '温州', 2, NULL),
(127, 12, '嘉兴', 2, NULL),
(128, 12, '湖州', 2, NULL),
(129, 12, '绍兴', 2, NULL),
(130, 12, '金华', 2, NULL),
(131, 12, '衢州', 2, NULL),
(132, 12, '舟山', 2, NULL),
(133, 12, '台州', 2, NULL),
(134, 12, '丽水', 2, NULL),
(135, 13, '合肥', 2, NULL),
(136, 13, '芜湖', 2, NULL),
(137, 13, '蚌埠', 2, NULL),
(138, 13, '淮南', 2, NULL),
(139, 13, '马鞍山', 2, NULL),
(140, 13, '淮北', 2, NULL),
(141, 13, '铜陵', 2, NULL),
(142, 13, '安庆', 2, NULL),
(143, 13, '黄山', 2, NULL),
(144, 13, '滁州', 2, NULL),
(145, 13, '阜阳', 2, NULL),
(146, 13, '宿州', 2, NULL),
(147, 13, '巢湖', 2, NULL),
(148, 13, '六安', 2, NULL),
(149, 13, '亳州', 2, NULL),
(150, 13, '池州', 2, NULL),
(151, 13, '宣城', 2, NULL),
(152, 14, '福州', 2, NULL),
(153, 14, '厦门', 2, NULL),
(154, 14, '莆田', 2, NULL),
(155, 14, '三明', 2, NULL),
(156, 14, '泉州', 2, NULL),
(157, 14, '漳州', 2, NULL),
(158, 14, '南平', 2, NULL),
(159, 14, '龙岩', 2, NULL),
(160, 14, '宁德', 2, NULL),
(161, 15, '南昌', 2, NULL),
(162, 15, '景德镇', 2, NULL),
(163, 15, '萍乡', 2, NULL),
(164, 15, '九江', 2, NULL),
(165, 15, '新余', 2, NULL),
(166, 15, '鹰潭', 2, NULL),
(167, 15, '赣州', 2, NULL),
(168, 15, '吉安', 2, NULL),
(169, 15, '宜春', 2, NULL),
(170, 15, '抚州', 2, NULL),
(171, 15, '上饶', 2, NULL),
(172, 16, '济南', 2, NULL),
(173, 16, '青岛', 2, NULL),
(174, 16, '淄博', 2, NULL),
(175, 16, '枣庄', 2, NULL),
(176, 16, '东营', 2, NULL),
(177, 16, '烟台', 2, NULL),
(178, 16, '潍坊', 2, NULL),
(179, 16, '济宁', 2, NULL),
(180, 16, '泰安', 2, NULL),
(181, 16, '威海', 2, NULL),
(182, 16, '日照', 2, NULL),
(183, 16, '莱芜', 2, NULL),
(184, 16, '临沂', 2, NULL),
(185, 16, '德州', 2, NULL),
(186, 16, '聊城', 2, NULL),
(187, 16, '滨州', 2, NULL),
(188, 16, '荷泽', 2, NULL),
(189, 17, '郑州', 2, NULL),
(190, 17, '开封', 2, NULL),
(191, 17, '洛阳', 2, NULL),
(192, 17, '平顶山', 2, NULL),
(193, 17, '焦作', 2, NULL),
(194, 17, '鹤壁', 2, NULL),
(195, 17, '新乡', 2, NULL),
(196, 17, '安阳', 2, NULL),
(197, 17, '濮阳', 2, NULL),
(198, 17, '许昌', 2, NULL),
(199, 17, '漯河', 2, NULL),
(200, 17, '三门峡', 2, NULL),
(201, 17, '南阳', 2, NULL),
(202, 17, '商丘', 2, NULL),
(203, 17, '信阳', 2, NULL),
(204, 17, '周口', 2, NULL),
(205, 17, '驻马店', 2, NULL),
(206, 18, '武汉', 2, NULL),
(207, 18, '黄石', 2, NULL),
(208, 18, '襄樊', 2, NULL),
(209, 18, '十堰', 2, NULL),
(210, 18, '荆州', 2, NULL),
(211, 18, '宜昌', 2, NULL),
(212, 18, '荆门', 2, NULL),
(213, 18, '鄂州', 2, NULL),
(214, 18, '孝感', 2, NULL),
(215, 18, '黄冈', 2, NULL),
(216, 18, '咸宁', 2, NULL),
(217, 18, '随州', 2, NULL),
(218, 18, '恩施', 2, NULL),
(219, 19, '长沙', 2, NULL),
(220, 19, '株洲', 2, NULL),
(221, 19, '湘潭', 2, NULL),
(222, 19, '衡阳', 2, NULL),
(223, 19, '邵阳', 2, NULL),
(224, 19, '岳阳', 2, NULL),
(225, 19, '常德', 2, NULL),
(226, 19, '张家界', 2, NULL),
(227, 19, '益阳', 2, NULL),
(228, 19, '郴州', 2, NULL),
(229, 19, '永州', 2, NULL),
(230, 19, '怀化', 2, NULL),
(231, 19, '娄底', 2, NULL),
(232, 19, '湘西', 2, NULL),
(233, 20, '广州', 2, NULL),
(234, 20, '深圳', 2, NULL),
(235, 20, '珠海', 2, NULL),
(236, 20, '汕头', 2, NULL),
(237, 20, '韶关', 2, NULL),
(238, 20, '佛山', 2, NULL),
(239, 20, '江门', 2, NULL),
(240, 20, '湛江', 2, NULL),
(241, 20, '茂名', 2, NULL),
(242, 20, '肇庆', 2, NULL),
(243, 20, '惠州', 2, NULL),
(244, 20, '梅州', 2, NULL),
(245, 20, '汕尾', 2, NULL),
(246, 20, '河源', 2, NULL),
(247, 20, '阳江', 2, NULL),
(248, 20, '清远', 2, NULL),
(249, 20, '东莞', 2, NULL),
(250, 20, '中山', 2, NULL),
(251, 20, '潮州', 2, NULL),
(252, 20, '揭阳', 2, NULL),
(253, 20, '云浮', 2, NULL),
(254, 21, '南宁', 2, NULL),
(255, 21, '柳州', 2, NULL),
(256, 21, '桂林', 2, NULL),
(257, 21, '梧州', 2, NULL),
(258, 21, '北海', 2, NULL),
(259, 21, '防城港', 2, NULL),
(260, 21, '钦州', 2, NULL),
(261, 21, '贵港', 2, NULL),
(262, 21, '玉林', 2, NULL),
(263, 21, '百色', 2, NULL),
(264, 21, '贺州', 2, NULL),
(265, 21, '河池', 2, NULL),
(266, 21, '来宾', 2, NULL),
(267, 21, '崇左', 2, NULL),
(268, 22, '海口', 2, NULL),
(269, 22, '三亚', 2, NULL),
(270, 22, '其他', 2, NULL),
(271, 23, '重庆', 2, NULL),
(272, 24, '成都', 2, NULL),
(273, 24, '自贡', 2, NULL),
(274, 24, '攀枝花', 2, NULL),
(275, 24, '泸州', 2, NULL),
(276, 24, '德阳', 2, NULL),
(277, 24, '绵阳', 2, NULL),
(278, 24, '广元', 2, NULL),
(279, 24, '遂宁', 2, NULL),
(280, 24, '内江', 2, NULL),
(281, 24, '乐山', 2, NULL),
(282, 24, '南充', 2, NULL),
(283, 24, '宜宾', 2, NULL),
(284, 24, '广安', 2, NULL),
(285, 24, '达州', 2, NULL),
(286, 24, '眉山', 2, NULL),
(287, 24, '雅安', 2, NULL),
(288, 24, '巴中', 2, NULL),
(289, 24, '资阳', 2, NULL),
(290, 24, '阿坝', 2, NULL),
(291, 24, '甘孜', 2, NULL),
(292, 24, '凉山', 2, NULL),
(293, 25, '贵阳', 2, NULL),
(294, 25, '六盘水', 2, NULL),
(295, 25, '遵义', 2, NULL),
(296, 25, '安顺', 2, NULL),
(297, 25, '铜仁', 2, NULL),
(298, 25, '毕节', 2, NULL),
(299, 25, '黔西南', 2, NULL),
(300, 25, '黔东南', 2, NULL),
(301, 25, '黔南', 2, NULL),
(302, 26, '昆明', 2, NULL),
(303, 26, '曲靖', 2, NULL),
(304, 26, '玉溪', 2, NULL),
(305, 26, '保山', 2, NULL),
(306, 26, '昭通', 2, NULL),
(307, 26, '丽江', 2, NULL),
(308, 26, '思茅', 2, NULL),
(309, 26, '临沧', 2, NULL),
(310, 26, '文山', 2, NULL),
(311, 26, '红河', 2, NULL),
(312, 26, '西双版纳', 2, NULL),
(313, 26, '楚雄', 2, NULL),
(314, 26, '大理', 2, NULL),
(315, 26, '德宏', 2, NULL),
(316, 26, '怒江', 2, NULL),
(317, 26, '迪庆', 2, NULL),
(318, 27, '拉萨', 2, NULL),
(319, 27, '昌都', 2, NULL),
(320, 27, '山南', 2, NULL),
(321, 27, '日喀则', 2, NULL),
(322, 27, '那曲', 2, NULL),
(323, 27, '阿里', 2, NULL),
(324, 27, '林芝', 2, NULL),
(325, 28, '西安', 2, NULL),
(326, 28, '铜川', 2, NULL),
(327, 28, '宝鸡', 2, NULL),
(328, 28, '咸阳', 2, NULL),
(329, 28, '渭南', 2, NULL),
(330, 28, '延安', 2, NULL),
(331, 28, '汉中', 2, NULL),
(332, 28, '榆林', 2, NULL),
(333, 28, '安康', 2, NULL),
(334, 28, '商洛', 2, NULL),
(335, 29, '兰州', 2, NULL),
(336, 29, '嘉峪关', 2, NULL),
(337, 29, '金昌', 2, NULL),
(338, 29, '白银', 2, NULL),
(339, 29, '天水', 2, NULL),
(340, 29, '武威', 2, NULL),
(341, 29, '张掖', 2, NULL),
(342, 29, '平凉', 2, NULL),
(343, 29, '酒泉', 2, NULL),
(344, 29, '庆阳', 2, NULL),
(345, 29, '定西', 2, NULL),
(346, 29, '陇南', 2, NULL),
(347, 29, '临夏', 2, NULL),
(348, 29, '甘南', 2, NULL),
(349, 30, '西宁', 2, NULL),
(350, 30, '海东', 2, NULL),
(351, 30, '海北', 2, NULL),
(352, 30, '黄南', 2, NULL),
(353, 30, '海南', 2, NULL),
(354, 30, '果洛', 2, NULL),
(355, 30, '玉树', 2, NULL),
(356, 30, '海西', 2, NULL),
(357, 31, '银川', 2, NULL),
(358, 31, '石嘴山', 2, NULL),
(359, 31, '吴忠', 2, NULL),
(360, 31, '固原', 2, NULL),
(361, 31, '中卫市', 2, NULL),
(362, 32, '乌鲁木齐', 2, NULL),
(363, 32, '克拉玛依', 2, NULL),
(364, 32, '吐露番', 2, NULL),
(365, 32, '哈密', 2, NULL),
(366, 32, '和田', 2, NULL),
(367, 32, '阿克苏地区', 2, NULL),
(368, 32, '喀什', 2, NULL),
(369, 32, '克孜勒苏', 2, NULL),
(370, 32, '巴音郭楞', 2, NULL),
(371, 32, '昌吉', 2, NULL),
(372, 32, '博尔塔拉', 2, NULL),
(373, 32, '伊犁', 2, NULL),
(374, 32, '塔城', 2, NULL),
(375, 32, '阿勒泰', 2, NULL),
(376, 33, '中西区', 2, NULL),
(377, 33, '东区', 2, NULL),
(378, 33, '九龙城区', 2, NULL),
(379, 33, '观塘区', 2, NULL),
(380, 33, '南区', 2, NULL),
(381, 33, '深水埗区', 2, NULL),
(382, 33, '黄大仙区', 2, NULL),
(383, 33, '湾仔区', 2, NULL),
(384, 33, '油尖旺区', 2, NULL),
(385, 33, '离岛区', 2, NULL),
(386, 33, '葵青区', 2, NULL),
(387, 33, '北区', 2, NULL),
(388, 33, '西贡区', 2, NULL),
(389, 33, '沙田区', 2, NULL),
(390, 33, '屯门区', 2, NULL),
(391, 33, '大埔区', 2, NULL),
(392, 33, '荃湾区', 2, NULL),
(393, 33, '元朗区', 2, NULL),
(394, 34, '台北市', 2, NULL),
(395, 34, '高雄市', 2, NULL),
(396, 34, '基隆市', 2, NULL),
(397, 34, '台中市', 2, NULL),
(398, 34, '台南市', 2, NULL),
(399, 34, '新竹市', 2, NULL),
(400, 34, '嘉义市', 2, NULL),
(401, 34, '台北县', 2, NULL),
(402, 34, '宜兰县', 2, NULL),
(403, 34, '桃园县', 2, NULL),
(404, 34, '新竹县', 2, NULL),
(405, 34, '苗栗县', 2, NULL),
(406, 34, '台中县', 2, NULL),
(407, 34, '彰化县', 2, NULL),
(408, 34, '南投县', 2, NULL),
(409, 34, '云林县', 2, NULL),
(410, 34, '嘉义县', 2, NULL),
(411, 34, '台南县', 2, NULL),
(412, 34, '高雄县', 2, NULL),
(413, 34, '屏东县', 2, NULL),
(414, 34, '澎湖县', 2, NULL),
(415, 34, '台东县', 2, NULL),
(416, 34, '花莲县', 2, NULL),
(417, 35, '三环以内包括亚运村', 3, NULL),
(418, 35, '三环外四环内', 3, NULL),
(427, 46, '香河', 0, NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_article`
-- 

CREATE TABLE `shopnc_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `article_class_id` int(11) NOT NULL COMMENT '文章类别id',
  `article_title` varchar(100) NOT NULL COMMENT '文章标题',
  `article_author` varchar(50) NOT NULL COMMENT '文章作者',
  `article_keywords` varchar(100) DEFAULT NULL COMMENT '文章关键字',
  `article_description` varchar(200) DEFAULT NULL COMMENT '文章描述',
  `article_body` text NOT NULL COMMENT '文章内容',
  `article_hit` int(11) NOT NULL DEFAULT '0' COMMENT '文章浏览',
  `article_sort` int(11) NOT NULL DEFAULT '0' COMMENT '文章排序',
  `article_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '文章状态1、发布0、未发布',
  `article_url` varchar(255) DEFAULT NULL COMMENT '文章外部链接',
  `article_type` tinyint(4) NOT NULL COMMENT '文章类型，发布人类型',
  `article_commend` enum('0','1') NOT NULL COMMENT '是否推荐',
  `article_time` char(10) NOT NULL COMMENT '文章发布时间',
  `provider_id` int(8) DEFAULT NULL COMMENT '供应商id',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_article`
-- 

INSERT INTO `shopnc_article` (`article_id`, `article_class_id`, `article_title`, `article_author`, `article_keywords`, `article_description`, `article_body`, `article_hit`, `article_sort`, `article_state`, `article_url`, `article_type`, `article_commend`, `article_time`, `provider_id`) VALUES 
(1, 1, 'ShopNC6.0网店系统发布啦', '', '', '', 'ShopNC6.0网店系统发布啦', 0, 0, 1, '', 0, '0', '1222047912', NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_article_class`
-- 

CREATE TABLE `shopnc_article_class` (
  `article_class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章类别id',
  `article_class_name` varchar(50) NOT NULL COMMENT '类别名称',
  `article_class_topid` int(11) DEFAULT '0' COMMENT '顶级类别id',
  `article_class_state` tinyint(4) DEFAULT '0' COMMENT '文章类别状态1、发布0、未发布',
  `article_class_keywords` varchar(100) DEFAULT NULL COMMENT '文章类别关键字',
  `article_class_description` varchar(200) DEFAULT NULL COMMENT '文章类别描述',
  `article_class_sort` int(11) DEFAULT '0' COMMENT '文章类别排序',
  `article_class_url` varchar(255) DEFAULT NULL COMMENT '文章类别外部链接',
  `article_class_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页导航显示，0不显示，1显示',
  PRIMARY KEY (`article_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章类别数据表' AUTO_INCREMENT=10 ;

-- 
-- 导出表中的数据 `shopnc_article_class`
-- 

INSERT INTO `shopnc_article_class` (`article_class_id`, `article_class_name`, `article_class_topid`, `article_class_state`, `article_class_keywords`, `article_class_description`, `article_class_sort`, `article_class_url`, `article_class_menu`) VALUES 
(1, '商店公告', 0, 1, 'sdfsd', 'sdfsdf', 0, '', 1),
(4, '最新新闻', 0, 1, 'sd', 'dddd', 0, '', 0),
(6, '网店行情', 0, 1, '', '', 0, '', 0),
(7, 'seo优化', 0, 1, '', '', 0, '', 0),
(8, '百度seo', 7, 1, '', '', 0, '', 0),
(9, 'google', 7, 1, '', '', 0, '', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_ask`
-- 

CREATE TABLE `shopnc_ask` (
  `ask_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客服id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `ac_id` int(11) NOT NULL COMMENT '问题类别id',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `ask_subject` varchar(100) NOT NULL COMMENT '留言主题',
  `ask_body` text NOT NULL COMMENT '留言内容',
  `ask_num` varchar(13) NOT NULL COMMENT '问题编号',
  `ask_reply` text COMMENT '问题回复',
  `if_reply` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否回复0、未回复1、已回复',
  `ask_time` char(10) NOT NULL COMMENT '提问时间',
  PRIMARY KEY (`ask_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_ask`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_ask_cate`
-- 

CREATE TABLE `shopnc_ask_cate` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '问题类别id',
  `cate_name` varchar(50) NOT NULL COMMENT '问题分类名称',
  `if_issue` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否发布0、未发布1、已发布',
  `if_marked` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否内定0、否1、是',
  `reply_body` varchar(500) DEFAULT NULL COMMENT '回复内容',
  `create_time` char(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`ac_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='在线客服-问题类别' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `shopnc_ask_cate`
-- 

INSERT INTO `shopnc_ask_cate` (`ac_id`, `cate_name`, `if_issue`, `if_marked`, `reply_body`, `create_time`) VALUES 
(2, '一般问题', '1', '1', '很好，很好', '1233566043');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_brand`
-- 

CREATE TABLE `shopnc_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品品牌id',
  `brand_name` varchar(50) NOT NULL COMMENT '品牌名称',
  `brand_image` varchar(100) NOT NULL COMMENT '品牌图片',
  `brand_image_width` int(11) DEFAULT '0' COMMENT '品牌图片宽度',
  `brand_image_height` int(11) DEFAULT '0' COMMENT '品牌图片高度',
  `brand_sort` int(11) DEFAULT '0' COMMENT '品牌排序',
  `brand_state` tinyint(4) DEFAULT '0' COMMENT '品牌状态1、发布0、未发布',
  `brand_url` varchar(100) DEFAULT NULL COMMENT 'url外联',
  `brand_keywords` varchar(100) DEFAULT NULL COMMENT '关键字',
  `brand_description` varchar(200) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品品牌数据表' AUTO_INCREMENT=7 ;

-- 
-- 导出表中的数据 `shopnc_brand`
-- 

INSERT INTO `shopnc_brand` (`brand_id`, `brand_name`, `brand_image`, `brand_image_width`, `brand_image_height`, `brand_sort`, `brand_state`, `brand_url`, `brand_keywords`, `brand_description`) VALUES 
(6, 'sdfdssd', '', 260, 60, 0, 1, '', '', '');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_collection`
-- 

CREATE TABLE `shopnc_collection` (
  `collection_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `user_id` int(11) NOT NULL COMMENT '会员id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `collection_time` varchar(10) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`collection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏数据表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_collection`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_comment`
-- 

CREATE TABLE `shopnc_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品评论id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `comment_body` varchar(255) NOT NULL COMMENT '评论内容',
  `comment_repost` varchar(255) DEFAULT NULL COMMENT '管理人员回复内容',
  `comment_view_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '查看状态，0未查看，1查看',
  `comment_repost_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回复状态，0未回复，1回复',
  `comment_time` varchar(10) NOT NULL COMMENT '商品评论时间',
  `repost_time` varchar(10) DEFAULT NULL COMMENT '管理员回复时间',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评论数据表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_comment`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_config`
-- 

CREATE TABLE `shopnc_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id值',
  `config_valuename` varchar(50) NOT NULL COMMENT '值得名字',
  `config_value` varchar(255) NOT NULL COMMENT '变量值',
  `config_other` varchar(50) DEFAULT NULL COMMENT '其他值',
  `config_type` varchar(20) NOT NULL COMMENT '类型',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统设置数据表' AUTO_INCREMENT=55 ;

-- 
-- 导出表中的数据 `shopnc_config`
-- 

INSERT INTO `shopnc_config` (`config_id`, `config_valuename`, `config_value`, `config_other`, `config_type`) VALUES 
(1, 'site_name', 'ShopNC单用户网店', NULL, 'base'),
(2, 'shop_user', '斌子', NULL, 'base'),
(3, 'admin_language', 'zh_cn', NULL, 'base'),
(4, 'user_sex', '1', NULL, 'base'),
(5, 'versionarea', 'zh_cn', NULL, 'base'),
(6, 'shop_email', 'shopnc@shopnc.cn', NULL, 'base'),
(7, 'shop_currency', '1', NULL, 'base'),
(8, 'shop_call', '022-27260105', NULL, 'base'),
(9, 'shop_state', '1', NULL, 'base'),
(11, 'time_zone', '', NULL, 'base'),
(14, 'shop_address', '天津市南开区西北角', NULL, 'base'),
(15, 'shop_copyright', 'ShopNC&reg;天津网城科技有限公司<br>Copyright&copy; 2007-2009 ShopNC, Powered by <a href=http://www.shopnc.net>ShopNC</a> Team , All Rights Reserved', NULL, 'base'),
(16, 'shop_post', '300120', NULL, 'base'),
(17, 'shop_ipc', '津ICP备0******1号', NULL, 'base'),
(18, 'shop_keywords', '网店，商店，商城，电子商务，网上购物', NULL, 'base'),
(19, 'shop_description', '大家一起来购物，通过电子商务上网选择商品更方便，使您感受足不出户浏览天下商品的乐趣，这就是电子商务，网上商店给你带来的好处，快来加入网上商店的行列中来吧！         ', NULL, 'base'),
(20, 'index_hot', '1', '8', 'view'),
(21, 'index_commend', '1', '6', 'view'),
(22, 'index_new', '1', '4', 'view'),
(23, 'index_spe', '1', '3', 'view'),
(24, 'index_brand', '1', '4', 'view'),
(25, 'index_vote', '1', '4', 'view'),
(26, 'index_notice', '1', '6', 'view'),
(27, 'index_subject', '1', '6', 'view'),
(28, 'view_language', '1', '6', 'view'),
(29, 'view_state', '1', '6', 'view'),
(30, 'view_price', '1', '6', 'view'),
(31, 'view_than_price', '1', '6', 'view'),
(32, 'view_buy', '0', '6', 'view'),
(33, 'view_collection', '1', '6', 'view'),
(34, 'view_than_goods', '', '6', 'view'),
(35, 'view_remember', '', '6', 'view'),
(36, 'view_goods_num', '', '6', 'view'),
(37, 'other_goods_class', '1', '12', 'view'),
(38, 'other_brand_class', '1', '12', 'view'),
(39, 'other_subject_class', '1', '12', 'view'),
(40, 'site_url', 'http://127.0.0.1/shopnc_wending/shopnc6_0915', NULL, 'base'),
(41, 'templatesname', 'et', NULL, 'base'),
(42, 'currencies', '', NULL, 'base'),
(43, 'shop_fax', '022-27260105', NULL, 'base'),
(44, 'shop_logo_width', '280', NULL, 'base'),
(45, 'shop_logo_height', '100', NULL, 'base'),
(46, 'shop_logo_file', '', NULL, 'base'),
(47, 'nc_charset', 'utf-8', NULL, 'base'),
(48, 'view_reg_validate', '1', '12', 'view'),
(49, 'view_login_validate', '1', '12', 'view'),
(50, 'view_provider_validate', '1', '12', 'view'),
(51, 'view_admin_login_validate', '1', '12', 'view'),
(52, 'view_comment_validate', '1', '12', 'view'),
(53, 'shop_qq', '', NULL, 'base'),
(54, 'shop_msn', '', NULL, 'base');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_currencies`
-- 

CREATE TABLE `shopnc_currencies` (
  `currencies_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '货币id',
  `currencies_name` varchar(20) NOT NULL COMMENT '货币名称',
  `currencies_code` varchar(10) DEFAULT NULL COMMENT '货币代码',
  `currencies_symbol` varchar(5) DEFAULT NULL COMMENT '货币符号',
  `currencies_units` varchar(10) DEFAULT NULL COMMENT '货币单位',
  `currencies_rate` varchar(10) DEFAULT NULL COMMENT '货币比率',
  `currencies_long` tinyint(4) DEFAULT NULL COMMENT '保留位数',
  `currencies_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当前状态，1默认，0非默认',
  `language_id` int(11) NOT NULL COMMENT '对应语言',
  PRIMARY KEY (`currencies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='货币数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_currencies`
-- 

INSERT INTO `shopnc_currencies` (`currencies_id`, `currencies_name`, `currencies_code`, `currencies_symbol`, `currencies_units`, `currencies_rate`, `currencies_long`, `currencies_state`, `language_id`) VALUES 
(1, '人民币', 'CNY', '￥', '元', '1.0000', 2, 1, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_goods`
-- 

CREATE TABLE `shopnc_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_bn` varchar(20) NOT NULL COMMENT '商品编号',
  `class_id` int(11) NOT NULL COMMENT '商品类别id',
  `brand_id` int(11) DEFAULT NULL COMMENT '商品品牌id',
  `subject_id` int(11) DEFAULT '0' COMMENT '商品主题id',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `goods_pricedesc` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '网店价格',
  `goods_provider_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '供应商供货价格',
  `goods_storage` int(11) DEFAULT '0' COMMENT '商品库存',
  `goods_alarm_num` int(11) DEFAULT NULL COMMENT '库存警告数量',
  `goods_alarm_text` varchar(50) DEFAULT NULL COMMENT '库存警告内容',
  `goods_weight` int(11) DEFAULT NULL COMMENT '商品重量',
  `goods_unit` varchar(10) DEFAULT NULL COMMENT '重量单位',
  `goods_color` varchar(255) DEFAULT NULL,
  `goods_size` varchar(255) DEFAULT NULL,
  `goods_click` int(11) DEFAULT '0' COMMENT '商品浏览量',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
  `goods_image` varchar(100) DEFAULT NULL COMMENT '商品图片',
  `goods_small_image` varchar(100) DEFAULT NULL COMMENT '缩微图',
  `goods_keywords` varchar(100) DEFAULT NULL COMMENT '商品关键字',
  `goods_description` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `goods_body` text COMMENT '商品详细介绍',
  `goods_add_time` char(10) DEFAULT NULL COMMENT '商品添加时间',
  `goods_state` tinyint(4) DEFAULT '1' COMMENT '商品状态1、发布0、未发布2、删除',
  `goods_hot` enum('1','0') DEFAULT NULL COMMENT '是否热卖',
  `goods_commend` enum('1','0') DEFAULT NULL COMMENT '是否推荐',
  `goods_special` enum('1','0') DEFAULT NULL COMMENT '是否特价',
  `goods_attr_body` text COMMENT '多属性',
  `goods_link_goods` text COMMENT '关联商品',
  `goods_link_article` text COMMENT '关联文章',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品信息数据表' AUTO_INCREMENT=64 ;

-- 
-- 导出表中的数据 `shopnc_goods`
-- 

INSERT INTO `shopnc_goods` (`goods_id`, `goods_name`, `goods_bn`, `class_id`, `brand_id`, `subject_id`, `goods_price`, `goods_pricedesc`, `goods_provider_price`, `goods_storage`, `goods_alarm_num`, `goods_alarm_text`, `goods_weight`, `goods_unit`, `goods_color`, `goods_size`, `goods_click`, `provider_id`, `goods_image`, `goods_small_image`, `goods_keywords`, `goods_description`, `goods_body`, `goods_add_time`, `goods_state`, `goods_hot`, `goods_commend`, `goods_special`, `goods_attr_body`, `goods_link_goods`, `goods_link_article`) VALUES 
(58, '粒按扣VIVI时尚连帽瑞丽中袖百搭外套送吊带', 'nc0001', 22, 0, 0, 58.00, 46.00, 0.00, 10, 0, '库存不足', 0, '件', '白色|黑色', '', 0, 0, 'attachments/upimg/2009/03/123797216349c9f4c3445a6.jpg', 'attachments/upimg/2009/03/123797216349c9f4c3445a6_small.jpg', '', '', '<!-- shopnc -->\r\n<p>舒适柔顺的面料，十分百搭又耐看的款式，简洁的一颗钮扣款式设计，无论是休闲写意的风格，还是斯文大方的风格，都能让你从容面对，利用率是相当高的。这款YY的修身效果也是一流的哦，穿上后除了很显气质的同时~也是非常显瘦的。所以既适合与裤子搭配~也适合与裙子搭配在一起，效果都是让人意想不到的好呢～</p>', '1237972163', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(60, '清新款式的双排扣短上衣短外套', 'nc0003', 22, 0, 0, 120.00, 100.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797260349c9f67b8beca.jpg', 'attachments/upimg/2009/03/123797260349c9f67b8beca_small.jpg', '', '', '<!-- shopnc -->\r\n<p>款式简洁大方 穿着舒适利落 清新的款式富有视觉吸引效果~（含里衬）袖子中间有皮质的材质，更显帅气．</p>\r\n<p>&nbsp;</p>', '1237972603', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(61, '韩版时尚百搭休闲长袖上衣', 'nc0004', 22, 0, 0, 120.00, 100.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797290149c9f7a5df92b.jpg', 'attachments/upimg/2009/03/123797290149c9f7a5df92b_small.jpg', '', '', '<!-- shopnc -->\r\n<p><br />\r\n&nbsp;</p>', '1237972902', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(62, '伊自尚92016天丝印花束领绳蝙蝠式长袖上衣', 'nc0005', 22, 0, 0, 260.00, 240.00, 0.00, 8, 0, '库存不足', 0, '件', '', '', 0, 0, 'attachments/upimg/2009/03/123797301349c9f81509f77.jpg', 'attachments/upimg/2009/03/123797301349c9f81509f77_small.jpg', '', '', '<!-- shopnc -->', '1237973013', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', ''),
(63, 'Mi-9007#韩版波浪边压褶开领小衫', 'nc0006', 22, 0, 0, 50.00, 40.00, 0.00, 10, 0, '库存不足', 0, '件', '', '', 3, 0, '', '', '', '', '', '1237973103', 1, '1', '1', '1', 'a:2:{s:10:"class_attr";N;s:16:"class_other_attr";N;}', '', '');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_goods_attribute`
-- 

CREATE TABLE `shopnc_goods_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性id',
  `attribute_name` varchar(50) NOT NULL COMMENT '属性名称',
  `goods_type_id` int(11) NOT NULL COMMENT '商品类型',
  `attribute_select` tinyint(1) DEFAULT NULL COMMENT '商品是否可选',
  `attribute_type` tinyint(1) NOT NULL COMMENT '录入方式',
  `attribute_select_body` varchar(200) DEFAULT NULL COMMENT '可选值内容',
  `attribute_sort` int(8) DEFAULT '0' COMMENT '属性排序',
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性数据表（对应商品类型表）' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_goods_attribute`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_goods_class`
-- 

CREATE TABLE `shopnc_goods_class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `class_top_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类id',
  `class_name` varchar(50) NOT NULL COMMENT '分类名称',
  `goods_type_id` int(11) NOT NULL COMMENT '商品类型id',
  `class_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分类状态1、开启0、关闭',
  `class_keywords` varchar(255) DEFAULT NULL COMMENT '分类关键字',
  `class_description` varchar(255) DEFAULT NULL COMMENT '分类描述',
  `class_sort` int(11) DEFAULT '0' COMMENT '分类排序',
  `class_language` int(11) DEFAULT '0' COMMENT '分类语言显示',
  `class_url` varchar(100) DEFAULT NULL COMMENT '分类指向的url外联',
  `class_other_attr` text COMMENT '独有属性',
  `class_menu` enum('1','0') DEFAULT NULL COMMENT '是否导航显示',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品分类数据表' AUTO_INCREMENT=25 ;

-- 
-- 导出表中的数据 `shopnc_goods_class`
-- 

INSERT INTO `shopnc_goods_class` (`class_id`, `class_top_id`, `class_name`, `goods_type_id`, `class_state`, `class_keywords`, `class_description`, `class_sort`, `class_language`, `class_url`, `class_other_attr`, `class_menu`) VALUES 
(20, 0, '女装', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(21, 20, '外套', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(22, 20, 'T恤', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(23, 20, '裙子', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0'),
(24, 20, '裤子', 0, 1, '', '', 0, 0, '', 'a:0:{}', '0');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_goods_image`
-- 

CREATE TABLE `shopnc_goods_image` (
  `goods_image_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `goods_id` int(8) NOT NULL COMMENT '商品id',
  `goods_image_title` varchar(50) DEFAULT NULL COMMENT '图片标题',
  `goods_image` varchar(100) NOT NULL COMMENT '图片地址',
  `goods_image_small` varchar(100) NOT NULL COMMENT '缩微图地址',
  PRIMARY KEY (`goods_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品多图表' AUTO_INCREMENT=61 ;

-- 
-- 导出表中的数据 `shopnc_goods_image`
-- 

INSERT INTO `shopnc_goods_image` (`goods_image_id`, `goods_id`, `goods_image_title`, `goods_image`, `goods_image_small`) VALUES 
(49, 58, '', 'attachments/upimg/2009/03/123797216249c9f4c29c674.jpg', 'attachments/upimg/2009/03/123797216249c9f4c29c674_small.jpg'),
(50, 58, '', 'attachments/upimg/2009/03/123797216249c9f4c2efc3e.jpg', 'attachments/upimg/2009/03/123797216249c9f4c2efc3e_small.jpg'),
(53, 60, '', 'attachments/upimg/2009/03/123797260249c9f67ab71b3.jpg', 'attachments/upimg/2009/03/123797260249c9f67ab71b3_small.jpg'),
(54, 60, '', 'attachments/upimg/2009/03/123797260349c9f67b26ed5.jpg', 'attachments/upimg/2009/03/123797260349c9f67b26ed5_small.jpg'),
(55, 61, '', 'attachments/upimg/2009/03/123797290149c9f7a53938a.jpg', 'attachments/upimg/2009/03/123797290149c9f7a53938a_small.jpg'),
(56, 61, '', 'attachments/upimg/2009/03/123797290149c9f7a58e184.jpg', 'attachments/upimg/2009/03/123797290149c9f7a58e184_small.jpg'),
(57, 62, '', 'attachments/upimg/2009/03/123797301249c9f81440d9c.jpg', 'attachments/upimg/2009/03/123797301249c9f81440d9c_small.jpg'),
(58, 62, '', 'attachments/upimg/2009/03/123797301249c9f814a19ba.jpg', 'attachments/upimg/2009/03/123797301249c9f814a19ba_small.jpg'),
(59, 63, '', 'attachments/upimg/2009/03/123797310249c9f86e7641a.jpg', 'attachments/upimg/2009/03/123797310249c9f86e7641a_small.jpg'),
(60, 63, '', 'attachments/upimg/2009/03/123797310249c9f86ec8f95.jpg', 'attachments/upimg/2009/03/123797310249c9f86ec8f95_small.jpg');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_goods_more_class`
-- 

CREATE TABLE `shopnc_goods_more_class` (
  `goods_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品扩展分类数据表';

-- 
-- 导出表中的数据 `shopnc_goods_more_class`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_goods_type`
-- 

CREATE TABLE `shopnc_goods_type` (
  `goods_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '类型id',
  `goods_type_name` varchar(50) NOT NULL COMMENT '类型名称',
  `goods_type_state` tinyint(1) NOT NULL COMMENT '类型状态',
  `goods_type_group` varchar(200) DEFAULT NULL COMMENT '类型分组',
  PRIMARY KEY (`goods_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品类型数据表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_goods_type`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_info`
-- 

CREATE TABLE `shopnc_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '系统信息id',
  `info_title` varchar(100) NOT NULL COMMENT '信息标题',
  `info_url` varchar(200) DEFAULT NULL COMMENT '外部url',
  `info_text` text COMMENT '系统信息内容',
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统信息，前台首页底部链接显示内容' AUTO_INCREMENT=8 ;

-- 
-- 导出表中的数据 `shopnc_info`
-- 

INSERT INTO `shopnc_info` (`info_id`, `info_title`, `info_url`, `info_text`) VALUES 
(1, '常见问题', '', '<p><br />\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">1.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请问一定要会员才可以购买吗</span><span lang="EN-US"><font face="Times New Roman"> ?</font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">我们提供会员以及非会员购买，您可以不需要加入会员便可以购买。当然我们基于保护消费者立场，绝对尊重您个人资料，您可以放心加入会员，我们会适时回馈给会员超值的优惠和福利。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">2.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请发票抬头错误怎么办</span><span lang="EN-US"><font face="Times New Roman">? </font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">若是因为我们作业的疏失造成您的困扰我们深感抱歉，请您将发票寄回，我们尽快为您办理更换。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">3.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请问贵站卖的商品价格怎么便宜市价这么多</span><span lang="EN-US"><font face="Times New Roman">?是快要过期的吗?</font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">我们除了具实体店铺外并自己代理进口各项商品，在网站直接销售当然可以回馈给消费者最合理的价格，绝对不是快过期的商品，请您安心购买。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">4.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请问可以退换货吗</span><span lang="EN-US"><font face="Times New Roman">?</font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">依据消基法规定您有7天之鉴赏期，在这期间您若对于商品不满意可以退货，但请维持商品包装之完整性，否则我们无法为您办理退换货手续。若非商品瑕疵之因素，商品之运费将由您支付，于退款时我们会扣除运费之损失。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</p>\r\n<p>&nbsp;</p>'),
(2, '安全交易', '', '<p class="MsoNormal" style="margin: 0cm 0cm 0pt">ShopNC秉持保护您的个人资料，并符合个人资料保护法各项规定，绝不会泄露给非业务相关的第三者。</p>\r\n<p class="MsoNormal" style="margin: 0cm 0cm 0pt">&nbsp;</p>\r\n<p class="MsoNormal" style="margin: 0cm 0cm 0pt">关于线上订购现阶段我们采用银行转帐方式，您在订单确认后可以直接至ATM转帐，我们在收到汇款后会立刻为您出货，若您有任何需要我们服务的地方可以直接和我们联系。</p>'),
(3, '购买流程', '', '<p>\r\n<table cellspacing="0" cellpadding="0" width="90%" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td><strong><span style="font-weight: bold; font-size: 14px; color: rgb(255,84,0)"><font color="#ff6600">选择商品</font></span></strong></td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;当您在本店选购商品时若看到属意的商品可以将商品放入购物车，若您已是会员身分建议可以先登入，如此您可使用收藏功能，当您暂时还没有决定要购买时，可以将属意商品先做收藏，待下次上线可以进入会员中心快速找到您收藏的商品。</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="10">&nbsp; <hr />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="right">&nbsp;&nbsp;<a href="#aa1"><font color="#95601e">回TOP</font></a></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table cellspacing="0" cellpadding="0" width="90%" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td><span style="font-weight: bold; font-size: 14px; color: rgb(255,84,0)">结帐步骤</span></td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">1.购物资讯确认，当商品放入购物车时会出现购买商品的清单以及金额和运费，此时您可以修改商品数量。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">2.选择付款方式，目前提供银行汇款。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">3.选择购买身分，若您已登入会员便会直接进入下一步骤，若您尚未登入可于此步骤登入，若您还不是会员您以两种选择，一是注册会员；一是选择直接以非会员身份购买。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">4.收货人资讯确认，请确认或填写您的收货资讯以确保商品可以准确迅速送达您手上。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">5.订单资讯确认，请再次确认您的订单内容，并选择发票形式。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">6.订单完成，你可列印此订单，或是至首页<a href="../member/NoMember_View.php"><font color="#0000ff"><u>订单查询</u></font></a>中继续追踪您的订单，有任何需要可直接<a href="mailto:service@shopnc.cn"><font color="#0000ff">service@shopnc.cn</font></a>或电话022-27260105和我们联系!我们会尽速为您解决问题。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="10"><hr />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td align="right">&nbsp;&nbsp;<a href="#aa1"><font color="#95601e">回TOP</font></a></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</p>'),
(4, '如何付款', '', '<p>为方便会员的缴款，我们提供下列几种付款方式</p>'),
(5, '联系我们', '', '<p style="text-align: left"><br />\r\n<font size="3">天津网城科技有限公司</font></p>\r\n<blockquote dir="ltr" style="margin-right: 0px">\r\n<p style="text-align: left"><br />\r\n您有任何问题欢迎与我们联络</p>\r\n<p style="text-align: left">请于上班时间来电或email给我们</p>\r\n<p style="text-align: left"><font color="#339966">电话：022-27260105</font></p>\r\n<p style="text-align: left"><font color="#339966">信箱：</font><a href="mailto:service@shopnc.cn"><font face="Verdana" color="#339966">service@ shopnc.cn</font></a></p>\r\n</blockquote>\r\n<p style="text-align: left">&nbsp;</p>'),
(6, '合作提案', NULL, NULL),
(7, '网站地图', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/map.html', '');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_language`
-- 

CREATE TABLE `shopnc_language` (
  `language_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '语言id',
  `language_name` varchar(50) NOT NULL COMMENT '语言名称',
  `language_directory` varchar(20) NOT NULL COMMENT '语言文件目录',
  `language_code` varchar(10) NOT NULL COMMENT '语言代码',
  `language_sort` int(11) DEFAULT '0' COMMENT '语言排序',
  `language_image` varchar(100) NOT NULL COMMENT '语言图片',
  `language_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '语言状态',
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_language`
-- 

INSERT INTO `shopnc_language` (`language_id`, `language_name`, `language_directory`, `language_code`, `language_sort`, `language_image`, `language_state`) VALUES 
(1, '中文（简体）', 'zh_cn', 'zh', 0, '', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_link`
-- 

CREATE TABLE `shopnc_link` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '友情链接id',
  `link_url` varchar(100) NOT NULL COMMENT '友情链接地址',
  `link_web_name` varchar(50) NOT NULL COMMENT '友情链接网站名称',
  `link_logo` varchar(100) DEFAULT NULL COMMENT '友情链接logo地址',
  `link_logo_width` int(11) DEFAULT '0' COMMENT 'logo宽度',
  `link_logo_height` int(11) DEFAULT '0' COMMENT 'logo高度',
  `link_email` varchar(100) DEFAULT NULL COMMENT '站长邮箱',
  `link_sort` int(11) DEFAULT '0' COMMENT '友情链接排序',
  `link_state` tinyint(4) DEFAULT '0' COMMENT '状态1、发布0、未发布',
  `link_time` char(10) DEFAULT NULL COMMENT '友情链接添加时间',
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接数据表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_link`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_log`
-- 

CREATE TABLE `shopnc_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `log_user` varchar(50) NOT NULL COMMENT '执行人',
  `admin_group` tinyint(4) NOT NULL COMMENT '执行人所在管理组',
  `log_ip` varchar(20) NOT NULL COMMENT 'ip地址',
  `log_time` varchar(10) NOT NULL COMMENT '执行时间',
  `log_info` varchar(100) NOT NULL COMMENT '执行描述',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台管理日志' AUTO_INCREMENT=50 ;

-- 
-- 导出表中的数据 `shopnc_log`
-- 

INSERT INTO `shopnc_log` (`log_id`, `log_user`, `admin_group`, `log_ip`, `log_time`, `log_info`) VALUES 
(39, 'admin', 1, '127.0.0.1', '1253266251', '广告修改成功'),
(40, 'admin', 1, '127.0.0.1', '1253589140', '模板选取成功'),
(41, 'admin', 1, '127.0.0.1', '1253600861', '地图生成完毕'),
(42, 'admin', 1, '127.0.0.1', '1253601856', '供应商保存成功'),
(43, 'admin', 1, '127.0.0.1', '1253602092', '支付方式保存成功'),
(44, 'admin', 1, '127.0.0.1', '1253602129', '配送方式区域添加成功'),
(45, 'admin', 1, '127.0.0.1', '1253609717', '模板选取成功'),
(46, 'admin', 1, '127.0.0.1', '1253609739', '模板选取成功'),
(47, 'admin', 1, '127.0.0.1', '1253611922', '广告修改成功'),
(48, 'admin', 1, '127.0.0.1', '1253611986', '商品保存成功'),
(49, 'admin', 1, '127.0.0.1', '1253612134', '商品保存成功');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_mail_template`
-- 

CREATE TABLE `shopnc_mail_template` (
  `mail_template_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '邮件模板id',
  `mail_template_name` varchar(100) NOT NULL COMMENT '模板名称',
  `mail_template_body` text NOT NULL COMMENT '模板内容',
  PRIMARY KEY (`mail_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='邮件模板数据表' AUTO_INCREMENT=7 ;

-- 
-- 导出表中的数据 `shopnc_mail_template`
-- 

INSERT INTO `shopnc_mail_template` (`mail_template_id`, `mail_template_name`, `mail_template_body`) VALUES 
(1, 'new_user_mail', '<p>亲爱的{user_name}您好：</p>\r\n<p>感谢您注册{shop_name}会员</p>\r\n<p>您的帐号：{user_name}</p>\r\n<p>您的密码：{passwd}</p>'),
(2, 'buy_goods_mail', '<p>亲爱的{user_name}会员您好：</p>\r\n<p>感谢您订购{shop_name}的商品</p>\r\n<p>您的订单号为{order_sn},目前您订购的商品订单还未确认。</p>'),
(3, 'del_goods_mail', '<p>亲爱的{user_name}：您好！</p>\r\n<p>您的编号为：{order_sn}的订单已取消。</p>\r\n<p>{shop_name}</p>\r\n<p>{send_date}</p>'),
(4, 'pay_mail', '<p>亲爱的{user_name}会员您好：</p>\r\n<p>您订单号码是：{order_sn}</p>\r\n<p>目前您订购的商品订单已完成付款。</p>\r\n<p>客服专线：04-2381-5417</p>\r\n<p>传真电话：04-2381-5410</p>\r\n<p>再次感谢您的惠顾，<a target="_blank" href="{site_url}">{shop_name}</a>客服中心敬上</p>'),
(5, 'send_goods_mail', '<p>亲爱的{user_name}你好！</p>\r\n<p>您的订单{order_sn}已于{send_time}按照您预定的配送方式给您发货了。 <br />\r\n<br />\r\n如果您还没有收到货物可以直接联系我们的在线客服。<br />\r\n再次感谢您对我们的支持。欢迎您的再次光临。 <br />\r\n<br />\r\n{shop_name} <br />\r\n{send_date}</p>'),
(6, 'end_goods_mail', '<p>亲爱的{user_name}会员您好：</p>\r\n<p>您订单号码是：{order_sn} 您已经成功完成本次交易活动。<br />\r\n谢谢您的支持，欢迎再次光临本店。<br />\r\n{shop_name} <br />\r\n{send_date}</p>');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_order_detail`
-- 

CREATE TABLE `shopnc_order_detail` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单商品表id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  `goods_bn` varchar(20) NOT NULL COMMENT '商品编号',
  `goods_unit` varchar(10) DEFAULT NULL COMMENT '商品单位',
  `goods_count` int(11) NOT NULL COMMENT '商品数量',
  `goods_size` varchar(10) DEFAULT NULL COMMENT '商品尺寸',
  `goods_color` varchar(10) DEFAULT NULL COMMENT '商品颜色',
  `goods_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `goods_pricedesc` decimal(10,2) NOT NULL COMMENT '商品价格',
  `provider_id` int(11) NOT NULL COMMENT '供应商id',
  PRIMARY KEY (`order_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单商品数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_order_detail`
-- 

INSERT INTO `shopnc_order_detail` (`order_detail_id`, `order_id`, `goods_id`, `goods_name`, `goods_bn`, `goods_unit`, `goods_count`, `goods_size`, `goods_color`, `goods_price`, `goods_pricedesc`, `provider_id`) VALUES 
(1, 3, 62, '伊自尚92016天丝印花束领绳蝙蝠式长袖上衣', 'nc0005', '件', 1, '', '', 260.00, 240.00, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_order_table`
-- 

CREATE TABLE `shopnc_order_table` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `user_id` int(11) NOT NULL COMMENT '会员id',
  `order_serial` varchar(50) NOT NULL COMMENT '订单编号',
  `receiver_name` varchar(50) NOT NULL COMMENT '送货人姓名',
  `receiver_address` varchar(200) NOT NULL COMMENT '送货人地址',
  `receiver_email` varchar(50) NOT NULL COMMENT '送货人email',
  `receiver_post` varchar(20) NOT NULL COMMENT '送货人邮编',
  `receiver_tele` varchar(20) NOT NULL COMMENT '送货人电话',
  `receiver_mobile` varchar(20) NOT NULL COMMENT '送货人手机',
  `receiver_tele_other` varchar(20) DEFAULT NULL COMMENT '送货人其他联系方式',
  `transport_id` int(11) NOT NULL COMMENT '配送id',
  `transport_name` varchar(50) NOT NULL COMMENT '配送名称',
  `transport_price` decimal(10,2) NOT NULL COMMENT '配送价格',
  `transport_content` varchar(200) NOT NULL COMMENT '配送描述内容',
  `pay_id` int(11) DEFAULT NULL COMMENT '支付id',
  `pay_name` varchar(50) NOT NULL COMMENT '支付名称',
  `pay_state` tinyint(1) NOT NULL COMMENT '支付状态',
  `pay_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付手续费用',
  `pay_content` varchar(200) NOT NULL COMMENT '支付内容',
  `order_invoice` tinyint(1) NOT NULL COMMENT '是否需要发票，0为不需要，1为需要',
  `order_invoice_top` varchar(255) DEFAULT NULL COMMENT '发票头内容',
  `order_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '确定状态',
  `order_state1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '付款状态，0未付，1已付',
  `order_state2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发货状态',
  `order_state3` tinyint(1) NOT NULL DEFAULT '0' COMMENT '归档状态',
  `send_time` varchar(10) DEFAULT NULL COMMENT '发送时间',
  `create_time` varchar(10) NOT NULL COMMENT '创建时间',
  `order_price` decimal(10,2) NOT NULL COMMENT '订单总价',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单数据表' AUTO_INCREMENT=4 ;

-- 
-- 导出表中的数据 `shopnc_order_table`
-- 

INSERT INTO `shopnc_order_table` (`order_id`, `user_id`, `order_serial`, `receiver_name`, `receiver_address`, `receiver_email`, `receiver_post`, `receiver_tele`, `receiver_mobile`, `receiver_tele_other`, `transport_id`, `transport_name`, `transport_price`, `transport_content`, `pay_id`, `pay_name`, `pay_state`, `pay_price`, `pay_content`, `order_invoice`, `order_invoice_top`, `order_state`, `order_state1`, `order_state2`, `order_state3`, `send_time`, `create_time`, `order_price`) VALUES 
(3, 1, '20090922150452', 'www', '', 'adfad@dfd.com', '', '12121212', '13223232233', '', 0, '', 0.00, '', 1, '货到付款', 0, 10.00, '', 0, '', 0, 0, 0, 0, NULL, '1253603092', 260.00);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_pay`
-- 

CREATE TABLE `shopnc_pay` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '支付方式id',
  `pay_name` varchar(20) NOT NULL COMMENT '支付名称',
  `pay_info` varchar(255) NOT NULL COMMENT '支付描述',
  `pay_code` varchar(20) NOT NULL COMMENT '支付方式代码',
  `pay_content` text NOT NULL COMMENT '核心内容',
  `pay_type` tinyint(1) NOT NULL COMMENT '支付类型，货到付款，非货到付款',
  `pay_online` tinyint(1) NOT NULL COMMENT '在线支付，1在线支付，0非在线支付',
  `pay_fee` varchar(10) NOT NULL DEFAULT '0' COMMENT '支付费用',
  `pay_state` tinyint(1) NOT NULL COMMENT '状态，1开启，0关闭',
  `pay_selected` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认选取，0为不选取，1为选取',
  `pay_sort` int(11) NOT NULL DEFAULT '0' COMMENT '支付类型排序',
  `pay_area_directory` varchar(50) NOT NULL COMMENT '支付目录',
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='支付方式数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_pay`
-- 

INSERT INTO `shopnc_pay` (`pay_id`, `pay_name`, `pay_info`, `pay_code`, `pay_content`, `pay_type`, `pay_online`, `pay_fee`, `pay_state`, `pay_selected`, `pay_sort`, `pay_area_directory`) VALUES 
(1, '货到付款', '货物到达买家手中后付款', 'hdpay', 'N;', 1, 0, '10', 1, 0, 0, 'zh_cn');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_pay_area`
-- 

CREATE TABLE `shopnc_pay_area` (
  `pay_area_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '支付区域id',
  `pay_area_name` varchar(50) NOT NULL COMMENT '支付区域名称',
  `pay_area_info` varchar(255) DEFAULT NULL COMMENT '支付区域描述',
  `pay_area_directory` varchar(50) NOT NULL COMMENT '支付目录',
  `pay_area_state` tinyint(1) NOT NULL COMMENT '状态，0为关闭，1为开启',
  `pay_area_sort` int(11) NOT NULL DEFAULT '0' COMMENT '支付区域排序',
  PRIMARY KEY (`pay_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='支付区域数据表' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `shopnc_pay_area`
-- 

INSERT INTO `shopnc_pay_area` (`pay_area_id`, `pay_area_name`, `pay_area_info`, `pay_area_directory`, `pay_area_state`, `pay_area_sort`) VALUES 
(1, '中国', '这里是中国地区的支付接口', 'zh_cn', 1, 3),
(2, '国际支付', '', 'usa', 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_provider`
-- 

CREATE TABLE `shopnc_provider` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '供应商id',
  `provider_pname` varchar(50) NOT NULL COMMENT '供应商名称',
  `provider_name` varchar(50) NOT NULL COMMENT '供应商帐号',
  `provider_passwd` varchar(16) NOT NULL COMMENT '供应商密码',
  `provider_contacts` varchar(50) NOT NULL COMMENT '联系人',
  `provider_state` tinyint(1) NOT NULL COMMENT '状态0为关闭，1为开启',
  `provider_call` varchar(30) DEFAULT NULL COMMENT '电话',
  `provider_address` varchar(100) DEFAULT NULL COMMENT '地址',
  `provider_email` varchar(50) DEFAULT NULL COMMENT '电子邮件',
  `provider_qq` varchar(50) DEFAULT NULL COMMENT 'qq',
  `provider_msn` varchar(50) DEFAULT NULL COMMENT 'msn',
  `privider_description` varchar(255) DEFAULT NULL COMMENT '描述',
  `provider_time` varchar(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='供应商数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_provider`
-- 

INSERT INTO `shopnc_provider` (`provider_id`, `provider_pname`, `provider_name`, `provider_passwd`, `provider_contacts`, `provider_state`, `provider_call`, `provider_address`, `provider_email`, `provider_qq`, `provider_msn`, `privider_description`, `provider_time`) VALUES 
(1, 'binzi', 'binzi', '96e79218965eb72c', '', 1, '', '', '', '', '', '', '1253601856');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_send`
-- 

CREATE TABLE `shopnc_send` (
  `send_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配送id',
  `send_name` varchar(50) NOT NULL COMMENT '配送名称',
  `send_path` int(11) NOT NULL COMMENT '配送的文件夹路径',
  `send_file` varchar(20) NOT NULL COMMENT '相关的配送文件',
  `send_pay_type` tinyint(1) NOT NULL COMMENT '是否货到付款，1是，0否',
  PRIMARY KEY (`send_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='配送种类表' AUTO_INCREMENT=12 ;

-- 
-- 导出表中的数据 `shopnc_send`
-- 

INSERT INTO `shopnc_send` (`send_id`, `send_name`, `send_path`, `send_file`, `send_pay_type`) VALUES 
(8, 'ems配送', 4, 'ems', 0),
(9, '货到付款', 4, 'hdfk', 0),
(10, '中通配送', 4, 'zhongtong', 0),
(11, '圆通配送', 4, 'yuantong', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_send_area`
-- 

CREATE TABLE `shopnc_send_area` (
  `send_area_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配送区域id（这里是大的区域）',
  `send_area_name` varchar(50) NOT NULL COMMENT '区域名称',
  `send_area_info` varchar(255) DEFAULT NULL COMMENT '区域简介',
  `send_area_directory` varchar(50) NOT NULL COMMENT '配送目录',
  `send_area_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '配送状态，1开启，0关闭',
  `send_area_sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '配送区域排序',
  PRIMARY KEY (`send_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='配送区域数据表' AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `shopnc_send_area`
-- 

INSERT INTO `shopnc_send_area` (`send_area_id`, `send_area_name`, `send_area_info`, `send_area_directory`, `send_area_state`, `send_area_sort`) VALUES 
(4, '中国', '中国地区的配送方式', 'zh_cn', 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_send_buy_area`
-- 

CREATE TABLE `shopnc_send_buy_area` (
  `buy_area_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购买区域id',
  `buy_area_name` varchar(50) NOT NULL COMMENT '区域名称',
  `buy_area` text COMMENT '地区，用逗号分隔',
  `buy_body` text NOT NULL COMMENT '相关费用，数组序列化',
  `send_id` int(11) NOT NULL COMMENT '所属配送方式',
  PRIMARY KEY (`buy_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='配送购买商品的不同区域' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_send_buy_area`
-- 

INSERT INTO `shopnc_send_buy_area` (`buy_area_id`, `buy_area_name`, `buy_area`, `buy_body`, `send_id`) VALUES 
(1, '货到付款', '天津市', 'a:1:{s:10:"send_money";s:2:"10";}', 9);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_subject`
-- 

CREATE TABLE `shopnc_subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主题类别id',
  `subject_name` varchar(50) NOT NULL COMMENT '主题名称',
  `subject_image` varchar(100) DEFAULT NULL COMMENT '主题图片',
  `subject_image_width` int(11) DEFAULT NULL COMMENT '图片显示宽度',
  `subject_image_height` int(11) DEFAULT NULL COMMENT '图片显示高度',
  `subject_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '主题状态1、发布0、未发布',
  `subject_url` varchar(100) DEFAULT NULL COMMENT '主题外部链接',
  `subject_sort` int(11) DEFAULT '0' COMMENT '主题排序',
  `subject_body` text COMMENT '主题内容',
  `subject_keywords` varchar(100) DEFAULT NULL COMMENT '主题关键字',
  `subject_description` varchar(200) DEFAULT NULL COMMENT '主题描述',
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品主题类别表' AUTO_INCREMENT=7 ;

-- 
-- 导出表中的数据 `shopnc_subject`
-- 

INSERT INTO `shopnc_subject` (`subject_id`, `subject_name`, `subject_image`, `subject_image_width`, `subject_image_height`, `subject_state`, `subject_url`, `subject_sort`, `subject_body`, `subject_keywords`, `subject_description`) VALUES 
(6, 'adsfasd', '', 875, 180, 1, '', 0, '', '', '');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_user_grade`
-- 

CREATE TABLE `shopnc_user_grade` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '等级id',
  `grade_name` varchar(50) NOT NULL COMMENT '等级名称',
  `grade_time` int(11) DEFAULT NULL COMMENT '优惠时长',
  `grade_discount` varchar(10) DEFAULT NULL COMMENT '优惠折扣',
  `grade_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '等级状态0为关闭，1为开启',
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员等级表' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `shopnc_user_grade`
-- 

INSERT INTO `shopnc_user_grade` (`grade_id`, `grade_name`, `grade_time`, `grade_discount`, `grade_state`) VALUES 
(2, '超级新星', 2, '9', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_users`
-- 

CREATE TABLE `shopnc_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `user_name` varchar(50) NOT NULL COMMENT '会员名称',
  `user_sex` tinyint(4) DEFAULT '0' COMMENT '会员性别 0、男1、女',
  `user_true_name` varchar(50) DEFAULT NULL COMMENT '会员真实姓名',
  `user_password` char(16) NOT NULL COMMENT '会员密码',
  `user_email` varchar(50) NOT NULL COMMENT '会员邮箱',
  `user_country` int(11) DEFAULT NULL COMMENT '会员所属国家',
  `user_province` int(11) DEFAULT NULL COMMENT '会员所在省',
  `user_city` int(11) DEFAULT NULL COMMENT '会员所在市',
  `user_county` int(11) DEFAULT NULL COMMENT '县',
  `user_address` varchar(100) DEFAULT NULL COMMENT '会员所在具体地区',
  `user_zip` varchar(10) DEFAULT NULL COMMENT '邮政编码',
  `user_phone` varchar(20) DEFAULT NULL COMMENT '电话，一般指座机',
  `user_mobilephone` varchar(20) DEFAULT NULL COMMENT '移动电话',
  `user_otherphone` varchar(20) DEFAULT NULL COMMENT '其他电话',
  `user_qq` varchar(50) DEFAULT NULL COMMENT '会员qq号',
  `user_msn` varchar(50) DEFAULT NULL COMMENT '会员msn号',
  `grade_id` tinyint(4) DEFAULT NULL COMMENT '会员等级id',
  `user_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态1、开启0、关闭',
  `user_register_time` char(10) NOT NULL COMMENT '注册时间',
  `user_login_time` char(10) NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_users`
-- 

INSERT INTO `shopnc_users` (`user_id`, `user_name`, `user_sex`, `user_true_name`, `user_password`, `user_email`, `user_country`, `user_province`, `user_city`, `user_county`, `user_address`, `user_zip`, `user_phone`, `user_mobilephone`, `user_otherphone`, `user_qq`, `user_msn`, `grade_id`, `user_state`, `user_register_time`, `user_login_time`) VALUES 
(1, '111111', 0, '', '96e79218965eb72c', '12121@1212.com', 0, 0, 0, 0, '', '0', '', '', '', '', '', 0, 1, '1253602204', '1253607563');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_users_other`
-- 

CREATE TABLE `shopnc_users_other` (
  `other_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收获址id',
  `user_uid` int(11) NOT NULL COMMENT '会员id',
  `other_true_name` varchar(50) NOT NULL COMMENT '收货人真是姓名',
  `other_email` varchar(50) NOT NULL COMMENT '收货人email',
  `other_country` int(11) NOT NULL COMMENT '收货人所在国家',
  `other_province` int(11) NOT NULL COMMENT '收货人所在省',
  `other_city` int(11) DEFAULT NULL COMMENT '收货人所在市',
  `other_county` int(11) DEFAULT NULL COMMENT '县',
  `other_address` varchar(50) NOT NULL COMMENT '收货人具体地区',
  `other_zip` varchar(10) NOT NULL COMMENT '收货人邮编',
  `other_phone` varchar(20) DEFAULT NULL COMMENT '收货人固定电话',
  `other_mobilephone` varchar(20) DEFAULT NULL COMMENT '收货人移动电话',
  `other_otherphone` varchar(20) DEFAULT NULL COMMENT '收货人其它电话',
  `other_flag` enum('yes','no') DEFAULT NULL COMMENT '是否是默认收货地址',
  PRIMARY KEY (`other_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='和会员相关的收货人' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `shopnc_users_other`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_visit`
-- 

CREATE TABLE `shopnc_visit` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '访问统计id',
  `ip` varchar(500) NOT NULL COMMENT '访问ip',
  `ip_area` varchar(100) NOT NULL COMMENT '来源地区',
  `visit_url` varchar(500) NOT NULL COMMENT '访问地址',
  `source_url` varchar(500) NOT NULL COMMENT '来源地址',
  `visit_time` char(10) NOT NULL COMMENT '访问时间',
  `visit_system` varchar(100) NOT NULL COMMENT '访问系统',
  PRIMARY KEY (`visit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='访问统计表' AUTO_INCREMENT=232 ;

-- 
-- 导出表中的数据 `shopnc_visit`
-- 

INSERT INTO `shopnc_visit` (`visit_id`, `ip`, `ip_area`, `visit_url`, `source_url`, `visit_time`, `visit_system`) VALUES 
(1, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253587234', 'Windows XP'),
(2, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253589115', 'Windows XP'),
(3, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/index.php?action=top', '1253591407', 'Windows XP'),
(4, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253591423', 'Windows XP'),
(5, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253591427', 'Windows XP'),
(6, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', '1253591431', 'Windows XP'),
(7, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', '1253591433', 'Windows XP'),
(8, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', '1253591435', 'Windows XP'),
(9, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=21', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', '1253591442', 'Windows XP'),
(10, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=21', '1253591444', 'Windows XP'),
(11, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253591445', 'Windows XP'),
(12, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253591447', 'Windows XP'),
(13, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253591449', 'Windows XP'),
(14, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', '1253591453', 'Windows XP'),
(15, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=class_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', '1253591454', 'Windows XP'),
(16, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253600322', 'Windows XP'),
(17, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253600326', 'Windows XP'),
(18, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253600328', 'Windows XP'),
(19, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', '1253600334', 'Windows XP'),
(20, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=text_list&type=&curpage=', '1253600335', 'Windows XP'),
(21, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=class_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', '1253600336', 'Windows XP'),
(22, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product.php?id=61', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=class_list&type=&curpage=', '1253600341', 'Windows XP'),
(23, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product.php?id=61', '1253600344', 'Windows XP'),
(24, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253600378', 'Windows XP'),
(25, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253600385', 'Windows XP'),
(26, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253600400', 'Windows XP'),
(27, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=&classid=20&goods_nums=&goods_show=&list_type=pic_list&type=&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253600403', 'Windows XP'),
(28, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253600469', 'Windows XP'),
(29, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?goods_id=63&goods_num=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253600472', 'Windows XP'),
(30, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?goods_id=63&goods_num=1', '1253600481', 'Windows XP'),
(31, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', '', '1253600493', 'Windows XP'),
(32, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', '1253600495', 'Windows XP'),
(33, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?goods_id=63&goods_num=1', '1253600512', 'Windows XP'),
(34, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?goods_id=63&goods_num=1', '1253600513', 'Windows XP'),
(35, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=commend', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253600743', 'Windows XP'),
(36, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&classid=&goods_nums=&goods_show=&list_type=pic_list&type=commend&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=commend', '1253600747', 'Windows XP'),
(37, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&classid=&goods_nums=&goods_show=&list_type=text_list&type=commend&curpage=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&classid=&goods_nums=&goods_show=&list_type=pic_list&type=commend&curpage=', '1253600749', 'Windows XP'),
(38, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&classid=&goods_nums=&goods_show=&list_type=text_list&type=commend&curpage=', '1253600787', 'Windows XP'),
(39, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253600817', 'Windows XP'),
(40, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', '1253600821', 'Windows XP'),
(41, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253600823', 'Windows XP'),
(42, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', '1253600824', 'Windows XP'),
(43, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=6', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253600825', 'Windows XP'),
(44, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=6', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253600830', 'Windows XP'),
(45, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shop.php?action=web_map', '', '1253600861', 'Unknow'),
(46, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253600869', 'Windows XP'),
(47, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/map.html', '1253600879', 'Windows XP'),
(48, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=commend', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253600991', 'Windows XP'),
(49, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/map.html', '1253600993', 'Windows XP'),
(50, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article.php?id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253601008', 'Windows XP'),
(51, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=4', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article.php?id=1', '1253601012', 'Windows XP'),
(52, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=7', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=4', '1253601014', 'Windows XP'),
(53, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=7', '1253601066', 'Windows XP'),
(54, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253601066', 'Windows XP'),
(55, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253601068', 'Windows XP'),
(56, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253601069', 'Windows XP'),
(57, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253601069', 'Windows XP'),
(58, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_brand.php?action=index', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253601072', 'Windows XP'),
(59, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_brand.php?action=index', '1253601077', 'Windows XP'),
(60, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253601960', 'Windows XP'),
(61, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253601962', 'Windows XP'),
(62, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253602013', 'Windows XP'),
(63, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253602071', 'Windows XP'),
(64, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253602149', 'Windows XP'),
(65, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253602150', 'Windows XP'),
(66, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1253602160', 'Windows XP'),
(67, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253602161', 'Windows XP'),
(68, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1253602163', 'Windows XP'),
(69, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', '1253602172', 'Windows XP'),
(70, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253602173', 'Windows XP'),
(71, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1253602175', 'Windows XP'),
(72, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', '1253602184', 'Windows XP'),
(73, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253602185', 'Windows XP'),
(74, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1253602186', 'Windows XP'),
(75, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register_save', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', '1253602204', 'Windows XP'),
(76, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253602206', 'Windows XP'),
(77, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product.php?id=62', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1253602217', 'Windows XP'),
(78, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product.php?id=62', '1253602219', 'Windows XP'),
(79, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?action=step_1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php', '1253602222', 'Windows XP'),
(80, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?action=step_2', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?action=step_1', '1253602302', 'Windows XP'),
(81, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?action=step_3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?action=step_2', '1253603092', 'Windows XP'),
(82, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?action=step_3', '1253603098', 'Windows XP'),
(83, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php', '1253603101', 'Windows XP'),
(84, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=del_my_order&order_id=1&order_sn=20090922145856', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253603105', 'Windows XP'),
(85, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '', '1253603108', 'Windows XP'),
(86, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=del_my_order&order_id=2&order_sn=20090922150337', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253603110', 'Windows XP'),
(87, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '', '1253603112', 'Windows XP'),
(88, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253604352', 'Windows XP'),
(89, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253604356', 'Windows XP'),
(90, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253604359', 'Windows XP'),
(91, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253604488', 'Windows XP'),
(92, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shop.php?vote_id=1', '', '1253604932', 'Windows XP'),
(93, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shop.php?vote_id=1', '1253604934', 'Windows XP'),
(94, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shop.php?vote_id=1', '1253605395', 'Windows XP'),
(95, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253605396', 'Windows XP'),
(96, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253606086', 'Windows XP'),
(97, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253606094', 'Windows XP'),
(98, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253606104', 'Windows XP'),
(99, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253606358', 'Windows XP'),
(100, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253606365', 'Windows XP'),
(101, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/map.html', '1253606374', 'Windows XP'),
(102, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253606376', 'Windows XP'),
(103, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=6', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253606378', 'Windows XP'),
(104, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=5', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=6', '1253606380', 'Windows XP'),
(105, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=4', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=5', '1253606381', 'Windows XP'),
(106, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=4', '1253606382', 'Windows XP'),
(107, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253606383', 'Windows XP'),
(108, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', '1253606384', 'Windows XP'),
(109, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', '1253606387', 'Windows XP'),
(110, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253606390', 'Windows XP'),
(111, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253606401', 'Windows XP'),
(112, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253606409', 'Windows XP'),
(113, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253606411', 'Windows XP'),
(114, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253606413', 'Windows XP'),
(115, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', '1253606416', 'Windows XP'),
(116, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=4', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253606416', 'Windows XP'),
(117, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=4', '1253606449', 'Windows XP'),
(118, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_out', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253606452', 'Windows XP'),
(119, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253606453', 'Windows XP'),
(120, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shop.php?vote_id=1', '', '1253606460', 'Windows XP'),
(121, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shop.php?vote_id=1', '1253606463', 'Windows XP'),
(122, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253606793', 'Windows XP'),
(123, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253606803', 'Windows XP'),
(124, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253606918', 'Windows XP'),
(125, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253606919', 'Windows XP'),
(126, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_brand.php?action=index', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253606920', 'Windows XP'),
(127, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_brand.php?action=index', '1253606921', 'Windows XP'),
(128, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', '1253606922', 'Windows XP'),
(129, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', '1253606924', 'Windows XP'),
(130, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', '1253606925', 'Windows XP'),
(131, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', '1253606926', 'Windows XP'),
(132, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', '1253606928', 'Windows XP'),
(133, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=6', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', '1253606929', 'Windows XP'),
(134, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=7', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=6', '1253606930', 'Windows XP'),
(135, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=6', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=7', '1253606986', 'Windows XP'),
(136, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=5', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=6', '1253606988', 'Windows XP'),
(137, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=4', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=5', '1253606990', 'Windows XP'),
(138, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=4', '1253606991', 'Windows XP'),
(139, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=3', '1253606994', 'Windows XP'),
(140, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=2', '1253606996', 'Windows XP'),
(141, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopnc_info.php?info_id=1', '1253607000', 'Windows XP'),
(142, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607002', 'Windows XP'),
(143, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253607003', 'Windows XP'),
(144, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_brand.php?action=index', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_subject.php', '1253607004', 'Windows XP'),
(145, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_brand.php?action=index', '1253607005', 'Windows XP'),
(146, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php', '1253607006', 'Windows XP'),
(147, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/article_class.php?id=1', '1253607007', 'Windows XP'),
(148, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/search.php?keywords=%E8%BE%93%E5%85%A5%E5%85%B3%E9%94%AE%E5%AD%97&submit=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607034', 'Windows XP'),
(149, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/search.php?keywords=%E8%BE%93%E5%85%A5%E5%85%B3%E9%94%AE%E5%AD%97&submit=', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/search.php?keywords=%E8%BE%93%E5%85%A5%E5%85%B3%E9%94%AE%E5%AD%97&submit=', '1253607037', 'Windows XP'),
(150, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/search.php?keywords=%E8%BE%93%E5%85%A5%E5%85%B3%E9%94%AE%E5%AD%97&submit=', '1253607040', 'Windows XP'),
(151, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=new', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607173', 'Windows XP'),
(152, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253607189', 'Windows XP'),
(153, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607206', 'Windows XP'),
(154, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', '1253607236', 'Windows XP'),
(155, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607239', 'Windows XP'),
(156, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=special', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1253607535', 'Windows XP'),
(157, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=special', '1253607545', 'Windows XP'),
(158, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607554', 'Windows XP'),
(159, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_page', '1253607563', 'Windows XP'),
(160, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253607564', 'Windows XP'),
(161, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253607568', 'Windows XP'),
(162, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php', '1253607570', 'Windows XP'),
(163, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253607571', 'Windows XP'),
(164, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253607572', 'Windows XP'),
(165, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253607572', 'Windows XP'),
(166, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253607574', 'Windows XP'),
(167, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253607826', 'Windows XP'),
(168, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253607827', 'Windows XP'),
(169, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253607829', 'Windows XP'),
(170, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=online', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253607830', 'Windows XP'),
(171, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=change_pw', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=online', '1253607833', 'Windows XP'),
(172, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=online', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=change_pw', '1253607834', 'Windows XP'),
(173, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=online', '1253607835', 'Windows XP'),
(174, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253607837', 'Windows XP'),
(175, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253607838', 'Windows XP'),
(176, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253607838', 'Windows XP'),
(177, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253607839', 'Windows XP'),
(178, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', '1253607840', 'Windows XP'),
(179, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', '1253607842', 'Windows XP'),
(180, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253607843', 'Windows XP'),
(181, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253607844', 'Windows XP'),
(182, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253607845', 'Windows XP'),
(183, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253607846', 'Windows XP'),
(184, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253607850', 'Windows XP'),
(185, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253607850', 'Windows XP'),
(186, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253608080', 'Windows XP'),
(187, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253608081', 'Windows XP'),
(188, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253608082', 'Windows XP'),
(189, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=online', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253608083', 'Windows XP'),
(190, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=change_pw', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=online', '1253608101', 'Windows XP'),
(191, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=change_pw', '1253608104', 'Windows XP'),
(192, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253608106', 'Windows XP'),
(193, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=message', '1253608107', 'Windows XP'),
(194, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=collection', '1253608108', 'Windows XP'),
(195, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=my_order', '1253608108', 'Windows XP'),
(196, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', '1253608109', 'Windows XP'),
(197, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php', '1253608114', 'Windows XP'),
(198, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=shopping_add', '1253608120', 'Windows XP'),
(199, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user_center.php?action=modify_userinfo', '1253608131', 'Windows XP'),
(200, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=login_out', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253608282', 'Windows XP'),
(201, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253608284', 'Windows XP'),
(202, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=new', '1253608380', 'Windows XP'),
(203, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?action=other&type=new', '1253608408', 'Windows XP'),
(204, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253608409', 'Windows XP'),
(205, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253608410', 'Windows XP'),
(206, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253608411', 'Windows XP'),
(207, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253608428', 'Windows XP'),
(208, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253609123', 'Windows XP'),
(209, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253609156', 'Windows XP'),
(210, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/', '1253609169', 'Windows XP'),
(211, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/member/user.php?action=register', '1253609273', 'Windows XP'),
(212, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1253609370', 'Windows XP'),
(213, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/index.php?action=top', '1253609733', 'Windows XP'),
(214, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/index.php?action=top', '1253609751', 'Windows XP'),
(215, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253609771', 'Windows XP'),
(216, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product.php?id=63', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253609780', 'Windows XP'),
(217, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product.php?id=63', '1253609793', 'Windows XP'),
(218, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '', '1253610719', 'Windows XP'),
(219, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?goods_id=63&goods_num=1', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/product_class.php?classid=20', '1253610724', 'Windows XP'),
(220, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/shopping.php?goods_id=63&goods_num=1', '1253610734', 'Windows XP'),
(221, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/index.php?action=top', '1253611934', 'Windows XP'),
(222, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253611982', 'Windows XP'),
(223, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253611987', 'Windows XP'),
(224, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253612136', 'Windows XP'),
(225, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253612153', 'Windows XP'),
(226, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253612329', 'Windows XP'),
(227, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253612335', 'Windows XP'),
(228, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253612425', 'Windows XP'),
(229, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/admin/admin_goods.php?action=list', '1253612427', 'Windows XP'),
(230, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '', '1257693325', 'Windows NT'),
(231, '127.0.0.1', 'null', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', 'http://127.0.0.1/shopnc_wending/shopnc6_0915/index.php', '1257693327', 'Windows NT');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_vote`
-- 

CREATE TABLE `shopnc_vote` (
  `vote_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '投票id',
  `vote_title` varchar(50) NOT NULL COMMENT '投票题目',
  `vote_start_time` varchar(10) DEFAULT NULL COMMENT '开始时间',
  `vote_end_time` varchar(10) DEFAULT NULL COMMENT '结束时间',
  `vote_type` enum('0','1') NOT NULL COMMENT '投票类型',
  `vote_member` enum('0','1') NOT NULL COMMENT '是否可以会员投票',
  `vote_refresh` enum('0','1') NOT NULL COMMENT '是否可以重复投票',
  `vote_state` enum('0','1') NOT NULL COMMENT '状态，0关闭，1开启',
  `vote_time` varchar(10) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投票数据表' AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `shopnc_vote`
-- 

INSERT INTO `shopnc_vote` (`vote_id`, `vote_title`, `vote_start_time`, `vote_end_time`, `vote_type`, `vote_member`, `vote_refresh`, `vote_state`, `vote_time`) VALUES 
(1, '您是从什么地方知道本站的？', '2009-2-15', '2009-12-17', '0', '1', '0', '1', '1221893376');

-- --------------------------------------------------------

-- 
-- 表的结构 `shopnc_vote_option`
-- 

CREATE TABLE `shopnc_vote_option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投票选项id',
  `vote_id` int(11) NOT NULL COMMENT '投票标题id',
  `option_tile` varchar(100) NOT NULL COMMENT '投票选项内容',
  `option_num` int(11) NOT NULL COMMENT '投票数',
  `option_sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='投票选项数据表' AUTO_INCREMENT=6 ;

-- 
-- 导出表中的数据 `shopnc_vote_option`
-- 

INSERT INTO `shopnc_vote_option` (`option_id`, `vote_id`, `option_tile`, `option_num`, `option_sort`) VALUES 
(1, 1, '百度', 2, 0),
(2, 1, 'google', 5, 0),
(3, 1, '朋友介绍', 9, 0),
(4, 1, '其他', 4, 0),
(5, 1, '还有什么', 1, 0);
