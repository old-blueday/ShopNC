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
 * FILE_NAME : remind_menu.php   FILE_PATH : E:\www\multishop\config\remind_menu.php
 * 网站提醒设置
 * 数组结构:
 * 
 * array(//大分类
 * 		'name'=>'分类名称',
 * 		'tag'=>'标签前缀',
 * 		'body'=array(
 * 			array(
 * 					'name'=>'操作名称',
 * 					'tag'=>'操作标识',
 * 					'mail_check'=>'邮件是否被选中，1为选中，0为不选中',
 * 					'mail_disabled'=>'邮件是否允许操作，1为不允许，0为允许',
 * 					'msg_check'=>'站内信',
 * 					'msg_disabled'=>'站内信',
 * 					'must'=>'是否必选 1为是，0为否'
 * 				),
 * 		)
 * )
 * 
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Mar 31 13:22:52 CST 2008
 */
$remind = array(
			array('name'=>$lang['langResumeSale'],'tag'=>'saler','body'=>array(
					array('name'=>$lang['langResumeBabyManage'],'tag'=>'sale_product','body'=>array(
						array('name'=>$lang['langResumeBabyMoveOther'],'tag'=>'sale_product_move','mail_check'=>'1','mail_disabled'=>'1','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
						array('name'=>$lang['langResumeBabyDelOther'],'tag'=>'sale_product_del','mail_check'=>'1','mail_disabled'=>'1','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
						array('name'=>$lang['langResumeBabyDownOther'],'tag'=>'sale_product_down','mail_check'=>'1','mail_disabled'=>'1','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
						),
					),
					array('name'=>$lang['langResumeBargainInform'],'tag'=>'sale_order','body'=>array(
						array('name'=>$lang['langResumePriceBabyByPi'],'tag'=>'sale_order_succ','mail_check'=>'0','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumePriceBabyAlreadyByPi'],'tag'=>'sale_order_bid_nosucc','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumeCountdownBabyAlreadyByPi'],'tag'=>'sale_product_countdown_succ','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumeGroupBabyEndNum'],'tag'=>'sale_order_team_insufficient','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						),
					),
					array('name'=>$lang['langResumeMessageInform'],'tag'=>'sale_message','body'=>array(
						array('name'=>$lang['langResumeBuyBabyMessageInform'],'tag'=>'sale_message_product','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumeBuyShopMessageInform'],'tag'=>'sale_message_shop','mail_check'=>'0','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						),
					),
					array('name'=>$lang['langResumeBuyRemindComplete'],'tag'=>'sale_buyer','body'=>array(
						array('name'=>$lang['langResumeBuyRemindCompleteInform'],'tag'=>'sale_buyer_to_succ','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
						),
					),
//					array('name'=>'店铺管理','tag'=>'sale_shop','body'=>array(
//						array('name'=>'店铺连续3周宝贝未达到10件，被系统提醒时，请通知我','tag'=>'sale_shop_3_month_unreach_10','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
//						array('name'=>'店铺连续5周宝贝未达到10件，被系统提醒时，请通知我','tag'=>'sale_shop_5_month_unreach_10','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
//						array('name'=>'店铺连续6周宝贝未达到10件，被系统提醒时，请通知我','tag'=>'sale_shop_6_month_unreach_10','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
//						),
//					),
				)
			),
			array('name'=>$lang['langResumeBuyRemind'],'tag'=>'buyer','body'=>array(
					array('name'=>$lang['langResumePriceByOverstep'],'tag'=>'buyer_bid_above','body'=>array(
						array('name'=>$lang['langResumeMyPriceOverstepInform'],'tag'=>'buyer_bid_above_notice','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumeBabyWantNumInform'],'tag'=>'buyer_bid_above_no_num','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						),
					),
					array('name'=>$lang['langResumePriceOk'],'tag'=>'buyer_bid_succ','body'=>array(
						array('name'=>$lang['langResumePriceEndInform'],'tag'=>'buyer_bid_succ_notice','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumePriceEndNumInform'],'tag'=>'buyer_bid_over_no_num','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						),
					),
					array('name'=>$lang['langResumeBabyBargain'],'tag'=>'buyer_buy_succ','body'=>array(
						array('name'=>$lang['langResumeOkBuyBabyInform'],'tag'=>'buyer_buy_succ_notice','mail_check'=>'0','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						),
					),
					array('name'=>$lang['langResumeMessageInform'],'tag'=>'buyer_message','body'=>array(
						array('name'=>$lang['langResumeBabyMessageBySaleInform'],'tag'=>'buyer_message_seller_product_answer','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						array('name'=>$lang['langResumeShopMessageBySaleInform'],'tag'=>'buyer_message_seller_shop_answer','mail_check'=>'0','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),					
						),
					),
					array('name'=>$lang['langResumeSaleRemindComplete'],'tag'=>'buyer_sale','body'=>array(
						array('name'=>$lang['langResumeSlaeRemindCompleteInform'],'tag'=>'buyer_sale_to_succ','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),				
						),
					),
//					array('name'=>'团购预订','tag'=>'buyer_team','body'=>array(
//						array('name'=>'当团购不成功，预订金退还给我时，请通知我','tag'=>'buyer_team_unsucc','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
//						array('name'=>'当我未付预订金的团购宝贝即将结束，请通知我','tag'=>'buyer_team_no_pay','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
//						),
//					),
				)
			),
			array('name'=>$lang['langResumeAppraiseRemind'],'tag'=>'score','body'=>array(
					array('name'=>$lang['langResumeAlreadyAppraise'],'tag'=>'score_have','body'=>array(
						array('name'=>$lang['langResumeMyAppraiseInform'],'tag'=>'score_have_notice','mail_check'=>'0','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'0'),
						),
					),
				)
			),
			array('name'=>$lang['langResumeComplaintLawRemind'],'tag'=>'complaint','body'=>array(
					array('name'=>$lang['langResumeComplaintLaw'],'tag'=>'complaint_receive','body'=>array(
						array('name'=>$lang['langResumeMyComplaintLawInform'],'tag'=>'complaint_receive_notice','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'1','msg_disabled'=>'0','must'=>'1'),
						),
					),
					array('name'=>$lang['langResumeComplaintLawComplete'],'tag'=>'complaint_handling','body'=>array(
						array('name'=>$lang['langResumeMySendComplaintLawCompleteInform'],'tag'=>'complaint_handling_notice','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'0','msg_disabled'=>'0','must'=>'1'),
						),
					),
					array('name'=>$lang['langResumeLaw'],'tag'=>'complaint_other_answer','body'=>array(
						array('name'=>$lang['langResumeMyComplaintLawSideInform'],'tag'=>'complaint_other_answer_notice','mail_check'=>'1','mail_disabled'=>'0','msg_check'=>'1','msg_disabled'=>'0','must'=>'1'),
						),
					),
				)
			),
		);
?>
