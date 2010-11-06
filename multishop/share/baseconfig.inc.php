<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : baseconfig.inc.php   FILE_PATH : \multishop\share\baseconfig.inc.php
* ....字段值说明
*
* @copyright Copyright (c) 2007 - 2010 www.shopnc.net
* @author ShopNC Develop Team
* @package
* @subpackage
* @version Sat Sep 08 15:06:26 CST 2007
*/
/**
* 性别
*/
$b_config['gender'] = array('m' => 'langMmale','f' => 'langMfemale');
/**
* 开启状态
*/
$b_config['openstate'] = array('0' => 'langCClose','1' => 'langCOpen');
/**
* 商铺类目属性
*/
$b_config['shopproperty'] = array('0' => 'langCCommon','1' => 'langCNew','2' => 'langCCommend');
/**
* 审核状态
*/
$b_config['checkstate'] = array('0' => 'langCApply','1' => 'langCPass','2' => 'langCClose');
/**
* 实体认证审核状态
*/
$b_config['auditstate'] = array('0' => 'langCNotApply','1' => 'langCApplying','2' => 'langCApplyPass','3' => 'langCApplyRefuse' );
/**
* 邮件种类
*/
$b_config['mailgenre'] = array('forget' => 'langCForgetPass','regist' => 'langCRegist');
$b_config['advgenre'] = array('1'=>'langOtherAdvFloat','2'=>'langOtherAdvSwim','3'=>'langOtherAdvFlash','4'=>'langOtherAdvRun','5'=>'langOtherAdvAround');
$b_config['memberstate'] = array('0'=>'langSysMemLocked','1'=>'langSysMemSnuff');
/**
* 商品新旧程度
*/
$b_config['p_type'] = array('0' => 'langPnew','1' => 'langPold','2' => 'langPnouse');
/**
* 商品交易类型
*/
$b_config['p_sell_type'] = array('0' => 'langCAuction','1' => 'langCfixprice','2' => 'langCCamel');
/**
* 商品交易状态
*/
$b_config['sp_state'] = array('0'=>'langOrderBuyed','1'=>'langOrderPayed','2'=>'langOrderSended','3'=>'langOrderReceived','4'=>'langOrderTeaming','5'=>'langOrderTeamFailed','6'=>'langOrderBuyFailed','7'=>'langOrderBuyClose');

/**
* 评价分数
*/
$b_config['grade_score'] = array('1' => 'langPScoreGood','0' => 'langPScoreMid','-1' => 'langPScoreBad');

/**
* 评价类型
*/
$b_config['grade_genre'] = array('b' => 'langPGradeGenreBuy','s' => 'langPGradeGenreSale');

/**
* 投诉举报 类型
*/
$b_config['complaint_report_type'] = array('1'=>'langComplaintNoShipment','2'=>'langComplaintNoBuy','3'=>'langComplaintMalicious','4'=>'langComplaintNoPay','5'=>'langComplaintSpeculationCredit','6'=>'langComplaintRaisePrice','7'=>'langComplaintPicInfringement','8'=>'langComplaintSendAd','9'=>'langComplaintMethodAsProduct','10'=>'langComplaintSellProhibitedProduct','11'=>'langComplaintSetWrongMenu','12'=>'langComplaintRepeatShop','13'=>'langComplaintAdProduct','14'=>'langComplaintAbuseTag');

/**
* 投诉举报 处理状态
*/
$b_config['complaint_report_handling'] = array('0'=>'langComplaintNoHand','1'=>'langComplaintHandlingNoComplaint','2'=>'langComplaintHandlingHaveComplaint','3'=>'langComplaintHanded','4'=>'langComplaintRevocation');

/**
* 出售禁售品类型
*/
$b_config['complaint_report_prohibited_product'] = array('1'=>'langProhibitedProductOne','2'=>'langProhibitedProductTwo','3'=>'langProhibitedProductThree');

/**
* 系统短信群发 对象 类型
*/
$b_config['system_message_object'] = array('0'=>'langMessageAllMember','1'=>'langMessageSeller','2'=>'langMessageOneMember');

/**
* 系统短信群发 是否允许删除
*/
$b_config['system_message_delete'] = array('0'=>'langMessageNoAllowDel','1'=>'langMessageAllowDel');

/**
* 投票前台显示位置
*/
$b_config['vote_show_local'] = array('0'=>'langVoteIndex','1'=>'langVoteListPage');

/**
* 广告前台显示位置
*/
$b_config['adv_type'] = array('0'=>'langOtherImage','1'=>'langOtherWord','2'=>'langOtherLantern');//,'3'=>'对联','4'=>'漂浮'

/**
* JS调用排序方式
*/
$b_config['js_order_by'] = array('community_time_desc'=>'langJSSendTimeReverse','community_replynum_desc'=>'langJSNumReverse','community_hits_desc'=>'langJSOnClickNumReverse');

/**
* 支付类别
*/
$b_config['payment_type'] = array("0"=>"langPaymentAll","1"=>"langPaymentVouch","2"=>"langPaymentInstant","3"=>"langPaymentOffline");

/**
* JS调用排序方式
*/
$b_config['news_js_order_by'] = array('news_time_desc'=>'langSysNOrderByNewsTimeDesc','news_sort_asc'=>'langSysNOrderByNewsSortAsc','news_sort_desc'=>'langSysNOrderByNewsSortDesc');

/**
* 淘宝CSV文件字段名
*/
$b_config['csv_taobao'] = array('goods_name'=>'langBatchGoodsName','goods_class'=>'langBatchGoodsClass','shop_class'=>'langBatchShopClass','new_level'=>'langBatchNewLevel','province'=>'langBatchProvince','city'=>'langBatchCity','sell_type'=>'langBatchSellType','shop_price'=>'langBatchShopPrice','add_price'=>'langBatchAddPrice','goods_number'=>'langBatchGoodsNumber','die_day'=>'langBatchDieDay','load_type'=>'langBatchLoadType','post_express'=>'langBatchPostExpress','ems'=>'EMS','express'=>'langBatchExpress','pay_type'=>'langBatchPayType','allow_alipay'=>'langBatchAllowAlipay','invoice'=>'langBatchInvoice','repair'=>'langBatchRepair','resend'=>'langBatchResend','is_store'=>'langBatchIsStore','window'=>'langBatchWindow','add_time'=>'langBatchAddTime','story'=>'langBatchStory','goods_desc'=>'langBatchGoodsDesc','goods_img'=>'langBatchGoodsImg','goods_attr'=>'langBatchGoodsAttr','group_buy'=>'langBatchGroupBuy','group_buy_num'=>'langBatchGroupBuyNum','template'=>'langBatchTemplate','discount'=>'langBatchDiscount','modify_time'=>'langBatchModifyTime','upload_status'=>'langBatchUploadStatus','img_status'=>'langBatchImgStatus');

/**
* 预存款充值信息状态
*/
$b_config['predeposit_record_state'] = array('0'=>'langPreRecordStateZero','1'=>'langPreRecordStateOne','2'=>'langPreRecordStateTwo');

/**
* 预存款明细类别
*/
$b_config['predeposit_detail_type'] = array('0'=>'langPreDetailTypeZero','1'=>'langPreDetailTypeOne','2'=>'langPreDetailTypeTwo','3'=>'langPreDetailTypeThree','4'=>'langPreDetailTypeFour','5'=>'langPreDetailTypeFive','6'=>'langPreDetailTypeSix','8'=>'langPreDetailTypeEight','9'=>'langPreDetailTypeNine','10'=>'langPreDetailTypeTen','12'=>'langPreDetailTypeTwelve','13'=>'langPreDetailTypeThirteen');

/**
* 预存款明细状态
*/
$b_config['predeposit_detail_state'] = array('0'=>'langPreDetailStateZero','1'=>'langPreDetailStateOne','2'=>'langPreDetailStateTwo');

/**
* 商品拍卖状态
*/
$b_config['bid_state'] = array('0'=>'langPBidout','1'=>'langPBidfirst','2'=>'langPBidorder');

/**
* 支付方式
*/
$b_config['payment'] = array('offline'=>'线下支付',);
?>
