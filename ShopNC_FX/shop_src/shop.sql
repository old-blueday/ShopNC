-- 
-- 导出表中的数据 `shopnc_config`
--

INSERT INTO `config` (config_id, config_valuename, config_value, config_other, config_type, shop_id) VALUES
(NULL, 'site_name', 'ShopNC单用户网店', NULL, 'base', ---shop_id---),
(NULL, 'shop_user', '斌子', NULL, 'base', ---shop_id---),
(NULL, 'admin_language', 'zh_cn', NULL, 'base', ---shop_id---),
(NULL, 'user_sex', '1', NULL, 'base', ---shop_id---),
(NULL, 'versionarea', 'zh_cn', NULL, 'base', ---shop_id---),
(NULL, 'shop_email', 'shopnc@shopnc.cn', NULL, 'base', ---shop_id---),
(NULL, 'shop_currency', '1', NULL, 'base', ---shop_id---),
(NULL, 'shop_call', '022-27260105', NULL, 'base', ---shop_id---),
(NULL, 'shop_state', '1', NULL, 'base', ---shop_id---),
(NULL, 'time_zone', '', NULL, 'base', ---shop_id---),
(NULL, 'shop_address', '天津市南开区西北角', NULL, 'base', ---shop_id---),
(NULL, 'shop_copyright', 'ShopNC?天津网城科技有限公司<br>Copyright? 2007-2009 ShopNC, Powered by <a href=http://www.shopnc.net>ShopNC</a> Team , All Rights Reserved', NULL, 'base', ---shop_id---),
(NULL, 'shop_post', '300120', NULL, 'base', ---shop_id---),
(NULL, 'shop_ipc', '津ICP备0******1号', NULL, 'base', ---shop_id---),
(NULL, 'shop_keywords', '网店，商店，商城，电子商务，网上购物', NULL, 'base', ---shop_id---),
(NULL, 'shop_description', '大家一起来购物，通过电子商务上网选择商品更方便，使您感受足不出户浏览天下商品的乐趣，这就是电子商务，网上商店给你带来的好处，快来加入网上商店的行列中来吧!', NULL, 'base', ---shop_id---),
(NULL, 'index_hot', '1', '8', 'view', ---shop_id---),
(NULL, 'index_commend', '1', '6', 'view', ---shop_id---),
(NULL, 'index_new', '1', '4', 'view', ---shop_id---),
(NULL, 'index_spe', '1', '3', 'view', ---shop_id---),
(NULL, 'index_brand', '1', '4', 'view', ---shop_id---),
(NULL, 'index_vote', '1', '4', 'view', ---shop_id---),
(NULL, 'index_notice', '1', '6', 'view', ---shop_id---),
(NULL, 'index_subject', '1', '6', 'view', ---shop_id---),
(NULL, 'view_language', '1', '6', 'view', ---shop_id---),
(NULL, 'view_state', '1', '6', 'view', ---shop_id---),
(NULL, 'view_price', '1', '6', 'view', ---shop_id---),
(NULL, 'view_than_price', '1', '6', 'view', ---shop_id---),
(NULL, 'view_buy', '0', '6', 'view', ---shop_id---),
(NULL, 'view_collection', '1', '6', 'view', ---shop_id---),
(NULL, 'view_than_goods', '', '6', 'view', ---shop_id---),
(NULL, 'view_remember', '', '6', 'view', ---shop_id---),
(NULL, 'view_goods_num', '', '6', 'view', ---shop_id---),
(NULL, 'other_goods_class', '1', '12', 'view', ---shop_id---),
(NULL, 'other_brand_class', '1', '12', 'view', ---shop_id---),
(NULL, 'other_subject_class', '1', '12', 'view', ---shop_id---),
(NULL, 'site_url', '---shop_url---', NULL, 'base', ---shop_id---),
(NULL, 'templatesname', 'default', NULL, 'base', ---shop_id---),
(NULL, 'currencies', '', NULL, 'base', ---shop_id---),
(NULL, 'shop_fax', '022-27260105', NULL, 'base', ---shop_id---),
(NULL, 'shop_logo_width', '160', NULL, 'base', ---shop_id---),
(NULL, 'shop_logo_height', '60', NULL, 'base', ---shop_id---),
(NULL, 'shop_logo_file', '', NULL, 'base', ---shop_id---),
(NULL, 'nc_charset', 'utf-8', NULL, 'base', ---shop_id---),
(NULL, 'view_reg_validate', '1', '12', 'view', ---shop_id---),
(NULL, 'view_login_validate', '1', '12', 'view', ---shop_id---),
(NULL, 'view_provider_validate', '1', '12', 'view', ---shop_id---),
(NULL, 'view_admin_login_validate', '1', '12', 'view', ---shop_id---),
(NULL, 'view_comment_validate', '1', '12', 'view', ---shop_id---);

-- 
-- 导出表中的数据 `shopnc_currencies`
-- 

INSERT INTO `currencies` (currencies_id, currencies_name, currencies_code, currencies_symbol, currencies_units, currencies_rate, currencies_long, currencies_state, language_id, shop_id) VALUES 
(NULL, '人民币', 'CNY', '￥', '元', '1.0000', 2, 1, 1, ---shop_id---);

INSERT INTO `language` (language_id, language_name, language_directory, language_code, language_sort, language_image, language_state,shop_id) VALUES 
(NULL, '中文（简体）', 'zh_cn', 'zh', 0, '', 1,---shop_id---);

INSERT INTO `info` (info_id, info_title, info_url, info_text, shop_id) VALUES 
(1, '常见问题', '', '<p><br />\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">1.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请问一定要会员才可以购买吗</span><span lang="EN-US"><font face="Times New Roman"> ?</font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">我们提供会员以及非会员购买，您可以不需要加入会员便可以购买。当然我们基于保护消费者立场，绝对尊重您个人资料，您可以放心加入会员，我们会适时回馈给会员超值的优惠和福利。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">2.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请发票抬头错误怎么办</span><span lang="EN-US"><font face="Times New Roman">? </font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">若是因为我们作业的疏失造成您的困扰我们深感抱歉，请您将发票寄回，我们尽快为您办理更换。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">3.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请问贵站卖的商品价格怎么便宜市价这么多</span><span lang="EN-US"><font face="Times New Roman">?是快要过期的吗?</font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">我们除了具实体店铺外并自己代理进口各项商品，在网站直接销售当然可以回馈给消费者最合理的价格，绝对不是快过期的商品，请您安心购买。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style="width: 500px; height: 92px" cellspacing="0" cellpadding="0" width="500" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">\r\n            <p align="left"><span lang="EN-US" style="mso-fareast-font-family: Times New Roman"><span style="mso-list: Ignore"><font face=" Times New Roman"><font size="3">4.</font><span style="font: 7pt Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span></font></span></span><font size="3"><span style="font-family: 新细明体; mso-hansi-font-family: Times New Roman; mso-ascii-font: Times New Roman">请问可以退换货吗</span><span lang="EN-US"><font face="Times New Roman">?</font></span></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td width="15">&nbsp;</td>\r\n            <td class="word1" width="490">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>\r\n            <p align="left">依据消基法规定您有7天之鉴赏期，在这期间您若对于商品不满意可以退货，但请维持商品包装之完整性，否则我们无法为您办理退换货手续。若非商品瑕疵之因素，商品之运费将由您支付，于退款时我们会扣除运费之损失。</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td><hr />\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</p>\r\n<p>&nbsp;</p>', ---shop_id---),
(2, '安全交易', '', '<p class="MsoNormal" style="margin: 0cm 0cm 0pt">ShopNC秉持保护您的个人资料，并符合个人资料保护法各项规定，绝不会泄露给非业务相关的第三者。</p>\r\n<p class="MsoNormal" style="margin: 0cm 0cm 0pt">&nbsp;</p>\r\n<p class="MsoNormal" style="margin: 0cm 0cm 0pt">关于线上订购现阶段我们采用银行转帐方式，您在订单确认后可以直接至ATM转帐，我们在收到汇款后会立刻为您出货，若您有任何需要我们服务的地方可以直接和我们联系。</p>', ---shop_id---),
(3, '购买流程', '', '<p>\r\n<table cellspacing="0" cellpadding="0" width="90%" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td><strong><span style="font-weight: bold; font-size: 14px; color: rgb(255,84,0)"><font color="#ff6600">选择商品</font></span></strong></td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;当您在本店选购商品时若看到属意的商品可以将商品放入购物车，若您已是会员身分建议可以先登入，如此您可使用收藏功能，当您暂时还没有决定要购买时，可以将属意商品先做收藏，待下次上线可以进入会员中心快速找到您收藏的商品。</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="10">&nbsp; <hr />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align="right">&nbsp;&nbsp;<a href="#aa1"><font color="#95601e">回TOP</font></a></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table cellspacing="0" cellpadding="0" width="90%" border="0">\r\n    <tbody>\r\n        <tr>\r\n            <td><span style="font-weight: bold; font-size: 14px; color: rgb(255,84,0)">结帐步骤</span></td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">1.购物资讯确认，当商品放入购物车时会出现购买商品的清单以及金额和运费，此时您可以修改商品数量。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">2.选择付款方式，目前提供银行汇款。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">3.选择购买身分，若您已登入会员便会直接进入下一步骤，若您尚未登入可于此步骤登入，若您还不是会员您以两种选择，一是注册会员；一是选择直接以非会员身份购买。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">4.收货人资讯确认，请确认或填写您的收货资讯以确保商品可以准确迅速送达您手上。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">5.订单资讯确认，请再次确认您的订单内容，并选择发票形式。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">6.订单完成，你可列印此订单，或是至首页<a href="../member/NoMember_View.php"><font color="#0000ff"><u>订单查询</u></font></a>中继续追踪您的订单，有任何需要可直接<a href="mailto:service@shopnc.cn"><font color="#0000ff">service@shopnc.cn</font></a>或电话022-27260105和我们联系!我们会尽速为您解决问题。</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="5">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td height="10"><hr />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td align="right">&nbsp;&nbsp;<a href="#aa1"><font color="#95601e">回TOP</font></a></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</p>', ---shop_id---),
(4, '如何付款', '', '<p>为方便会员的缴款，我们提供下列几种付款方式</p>', ---shop_id---),
(5, '联系我们', '', '<p style="text-align: left"><br />\r\n<font size="3">天津网城科技有限公司</font></p>\r\n<blockquote dir="ltr" style="margin-right: 0px">\r\n<p style="text-align: left"><br />\r\n您有任何问题欢迎与我们联络</p>\r\n<p style="text-align: left">请于上班时间来电或email给我们</p>\r\n<p style="text-align: left"><font color="#339966">电话：022-27260105</font></p>\r\n<p style="text-align: left"><font color="#339966">信箱：</font><a href="mailto:service@shopnc.cn"><font face="Verdana" color="#339966">service@ shopnc.cn</font></a></p>\r\n</blockquote>\r\n<p style="text-align: left">&nbsp;</p>', ---shop_id---),
(6, '合作提案', NULL, NULL, ---shop_id---);

INSERT INTO `mail_template` (mail_template_id, mail_template_name, mail_template_body, shop_id) VALUES 
(1, 'new_user_mail', '<p>亲爱的{user_name}您好：</p>\r\n<p>感谢您注册{shop_name}会员</p>\r\n<p>您的帐号：{user_name}</p>\r\n<p>您的密码：{passwd}</p>', ---shop_id---),
(2, 'buy_goods_mail', '<p>亲爱的{user_name}会员您好：</p>\r\n<p>感谢您订购{shop_name}的商品</p>\r\n<p>您的订单号为{order_sn},目前您订购的商品订单还未确认。</p>', ---shop_id---),
(3, 'del_goods_mail', '<p>亲爱的{user_name}：您好！</p>\r\n<p>您的编号为：{order_sn}的订单已取消。</p>\r\n<p>{shop_name}</p>\r\n<p>{send_date}</p>', ---shop_id---),
(4, 'pay_mail', '<p>亲爱的{user_name}会员您好：</p>\r\n<p>您订单号码是：{order_sn}</p>\r\n<p>目前您订购的商品订单已完成付款。</p>\r\n<p>客服专线：04-2381-5417</p>\r\n<p>传真电话：04-2381-5410</p>\r\n<p>再次感谢您的惠顾，<a target="_blank" href="{site_url}">{shop_name}</a>客服中心敬上</p>', ---shop_id---),
(5, 'send_goods_mail', '<p>亲爱的{user_name}你好！</p>\r\n<p>您的订单{order_sn}已于{send_time}按照您预定的配送方式给您发货了。 <br />\r\n<br />\r\n如果您还没有收到货物可以直接联系我们的在线客服。<br />\r\n再次感谢您对我们的支持。欢迎您的再次光临。 <br />\r\n<br />\r\n{shop_name} <br />\r\n{send_date}</p>', ---shop_id---),
(6, 'end_goods_mail', '<p>亲爱的{user_name}会员您好：</p>\r\n<p>您订单号码是：{order_sn} 您已经成功完成本次交易活动。<br />\r\n谢谢您的支持，欢迎再次光临本店。<br />\r\n{shop_name} <br />\r\n{send_date}</p>', ---shop_id---);


