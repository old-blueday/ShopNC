<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="inx-info">
					<div class="inx-info-left">
						<?php if ( $output['member_array']['picture'] != '' ) {?>
							<img src="<?php echo SITE_URL; ?>/<?php echo $output['member_array']['picture']; ?>" width="80" height="80" />
						<?php } else {?>
							<img src="<?php echo TPL_DIR; ?>/images/avatar.gif" />
						<?php } ?>
					</div>
					<div class="inx-info-right">
						<div class="inx-info-right-1"><strong><?php echo $lang['langMainWelcome']; ?><?php echo $output['member_info']['name']; ?>,</strong><span><?php echo $lang['langMainXiao2Reception']; ?></span></div>
						<div class="inx-info-right-2">
						<?php echo $lang['langMainSaleCredit']; ?>: <a href="<?php echo SITE_URL; ?>/member/own_score.php"><?php echo $output['member_array']['sale_score'];?></a> 
							<?php if ( is_array( $output['sell_score_level']['median'] ) ) { ?>
								<?php foreach ( $output['sell_score_level']['median'] as $list ) { ?>
									<?php if ( $output['sell_score_level']['level'] == '0' ) { ?>
										<img title="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_1.gif" alt="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
									<?php } ?>
									<?php if ( $output['sell_score_level']['level'] == '1' ) { ?>
										<img title="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_2.gif" alt="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
									<?php } ?>	
									<?php if ( $output['sell_score_level']['level'] == '2' ) { ?>
										<img title="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_3.gif" alt="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
									<?php } ?>																				
								<?php } ?>
							<?php } ?>
							&nbsp;&nbsp;
							<?php echo $lang['langMainBuyCredit']; ?>: <a href="<?php echo SITE_URL; ?>/member/own_score.php"><?php echo $output['member_array']['buy_score'];?></a>
								<?php if ( is_array( $output['buy_score_level']['median'] ) ) { ?>
									<?php foreach ( $output['buy_score_level']['median'] as $list ) { ?>
										<?php if ( $output['buy_score_level']['level'] == '0' ) { ?>
											<img title="<?php echo $output['buy_score_level']['interval']['one']?>－<?php echo $output['buy_score_level']['interval']['two']?><?php echo $lang['langMemberIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_1.gif" alt="<?php echo $output['buy_score_level']['interval']['one']?>－<?php echo $output['buy_score_level']['interval']['two']?><?php echo $lang['langMemberIntegralLook']; ?>" align="absmiddle">
										<?php } ?>
										<?php if ( $output['buy_score_level']['level'] == '1' ) { ?>
											<img title="<?php echo $output['buy_score_level']['interval']['one']?>－<?php echo $output['buy_score_level']['interval']['two']?><?php echo $lang['langMemberIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_2.gif" alt="<?php echo $output['buy_score_level']['interval']['one']?>－<?php echo $output['buy_score_level']['interval']['two']?><?php echo $lang['langMemberIntegralLook']; ?>" align="absmiddle">
										<?php } ?>	
										<?php if ( $output['buy_score_level']['level'] == '2' ) { ?>
											<img title="<?php echo $output['buy_score_level']['interval']['one']?>－<?php echo $output['buy_score_level']['interval']['two']?><?php echo $lang['langMemberIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_3.gif" alt="<?php echo $output['buy_score_level']['interval']['one']?>－<?php echo $output['buy_score_level']['interval']['two']?><?php echo $lang['langMemberIntegralLook']; ?>" align="absmiddle">
										<?php } ?>																				
									<?php } ?>
								<?php } ?>							 
						</div>
						<div class="inx-info-right-3"><?php echo $lang['langMainMemberClass']; ?>: <?php echo $output['member_array']['group_name'];?><span><?php echo $output['member_array']['group_star'];?></span> <?php echo $lang['langMainMemberExp']; ?>: <strong><?php echo $output['member_array']['extcredits_exp'];?></strong>   <?php echo $lang['langMainMemberPoint']; ?>: <strong><?php echo $output['member_array']['extcredits_points'];?></strong>    <a href="own_credits.php"><?php echo $lang['langMainInfoMore']; ?></a> <a href="own_credits.php?action=info"><?php echo $lang['langMainDescription']; ?></a></div>
					</div>
					<div class="inx-info-right-34">
						<div class="inx-sort">
							<div class="inx-sort-1">
								<strong><?php echo $lang['langMainSaleRemindTitle']; ?>:</strong>
								<ul>
									<?php if ( $output['seller_awaiting_shipment'] == '0' ) { ?>
										<li class="s-li-1"><?php echo $lang['langMainSellerAwaitingShipment']; ?>(<?php echo $output['seller_awaiting_shipment']; ?>)</li>
									<?php } else {?>
										<li class="s-li-1-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=sold"><?php echo $lang['langMainSellerAwaitingShipment']; ?>(<?php echo $output['seller_awaiting_shipment']; ?>)</a></li>
									<?php } ?>
									<?php if ( $output['seller_no_payment'] == '0' ) { ?>
										<li class="s-li-2"><?php echo $lang['langMainSellerNoPayment']; ?>(<?php echo $output['seller_no_payment']; ?>)</li>
									<?php } else {?>
										<li class="s-li-2-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=sold"><?php echo $lang['langMainSellerNoPayment']; ?>(<?php echo $output['seller_no_payment']; ?>)</a></li>
									<?php } ?>		
									<?php if ( $output['seller_awaiting_evaluation'] == '0' ) { ?>
										<li class="s-li-3"><?php echo $lang['langMainAwaitingEvaluation']; ?>(<?php echo $output['seller_awaiting_evaluation']; ?>)</li>
									<?php } else {?>
										<li class="s-li-3-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=sold"><?php echo $lang['langMainAwaitingEvaluation']; ?>(<?php echo $output['seller_awaiting_evaluation']; ?>)</a></li>
									<?php } ?>		
									<?php if ( $output['message_number'] == '0' ) { ?>
										<li class="s-li-4"><?php echo $lang['langMainMessageNumber']; ?>(<?php echo $output['message_number']; ?>)</li>
									<?php } else {?>
										<li class="s-li-4-1"><a href="<?php echo SITE_URL; ?>/member/own_shopmessage.php"><?php echo $lang['langMainMessageNumber']; ?>(<?php echo $output['message_number']; ?>)</a></li>
									<?php } ?>		
									<?php if ( $output['member_array']['recommend_product_count'] == '0' ) { ?>
										<li class="s-li-5"><?php echo $lang['langMainShopwindowCommend'];?>(<?php echo $output['member_array']['recommend_product_count'];?>/<?php echo $output['member_array']['recommend_max_count'];?>)</li>
									<?php } else {?>
										<li class="s-li-5-1"><a href="<?php echo SITE_URL; ?>/member/own_product_list.php?action=list"><?php echo $lang['langMainShopwindowCommend'];?>(<?php echo $output['member_array']['recommend_product_count'];?>/<?php echo $output['member_array']['recommend_max_count'];?>)</a></li>
									<?php } ?>																																	
								</ul>
							</div>
							<div class="inx-sort-2">
								<strong><?php echo $lang['langMainBuyRemindTitle']; ?>:</strong>
								<ul>
									<?php if ( $output['buyer_awaiting_payment'] == '0' ) { ?>
										<li class="s-li-1"><?php echo $lang['langMainBuyerAwaitingPayment']; ?>(<?php echo $output['buyer_awaiting_payment']; ?>)</li>
									<?php } else {?>
										<li class="s-li-1-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=bought"><?php echo $lang['langMainBuyerAwaitingPayment']; ?>(<?php echo $output['buyer_awaiting_payment']; ?>)</a></li>
									<?php } ?>								
									<?php if ( $output['buyer_confirm_receipt'] == '0' ) { ?>
										<li class="s-li-2"><?php echo $lang['langMainBuyerConfirmReceipt']; ?>(<?php echo $output['buyer_confirm_receipt']; ?>)</li>
									<?php } else {?>
										<li class="s-li-2-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=bought"><?php echo $lang['langMainBuyerConfirmReceipt']; ?>(<?php echo $output['buyer_confirm_receipt']; ?>)</a></li>
									<?php } ?>										
									<?php if ( $output['buyer_awaiting_evaluation'] == '0' ) { ?>
										<li class="s-li-3"><?php echo $lang['langMainAwaitingEvaluation']; ?>(<?php echo $output['buyer_awaiting_evaluation']; ?>)</li>
									<?php } else {?>
										<li class="s-li-3-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=bought"><?php echo $lang['langMainAwaitingEvaluation']; ?>(<?php echo $output['buyer_awaiting_evaluation']; ?>)</a></li>
									<?php } ?>	
									<?php if ( $output['buyer_three_month'] == '0' ) { ?>
										<li class="s-li-4"><?php echo $lang['langMainBuyerThreeMonth']; ?>(<?php echo $output['buyer_three_month']; ?>)</li>
									<?php } else {?>
										<li class="s-li-4-1"><a href="<?php echo SITE_URL; ?>/member/own_order.php?action=bought"><?php echo $lang['langMainBuyerThreeMonth']; ?>(<?php echo $output['buyer_three_month']; ?>)</a></li>
									<?php } ?>																			
								</ul>
							</div>
							<div class="inx-sort-3">
								<ul>
									<li style="margin-left:12px;">
										<?php echo $lang['langMainPersonalCertify'];?>:
										<?php if($output['member_array']['personal_certify'] == '0'){ ?>
											<strong><?php echo $lang['langMainPersonalCertifyStateZero'];?></strong>
											<a href="<?php echo SITE_URL; ?>/member/own_member.php?action=personal_certify"><?php echo $lang['langMainClickToCertify'];?></a>
										<?php } ?>
										<?php if($output['member_array']['personal_certify'] == '1'){ ?>
											<strong><?php echo $lang['langMainPersonalCertifyStateOne'];?></strong>
										<?php } ?>
										<?php if($output['member_array']['personal_certify'] == '2'){ ?>
											<strong><?php echo $lang['langMainPersonalCertifyStateTwo'];?></strong>
										<?php } ?>
										<?php if($output['member_array']['personal_certify'] == '3'){ ?>
											<strong><?php echo $lang['langMainPersonalCertifyStateThree'];?></strong>
											<a href="<?php echo SITE_URL; ?>/member/own_member.php?action=personal_certify"><?php echo $lang['langMainClickToCertifyReturn'];?></a>
										<?php } ?>										
									</li>
									<li>
										<?php echo $lang['langMainShopAttestationEstate'];?>: <strong><?php echo $output['lang_audit_state'];?></strong> 
										<?php if($output['audit_state'] !== '2'){ ?>
											<?php echo $lang['langMainShopAttestationPlease'];?>
											<a href="<?php echo SITE_URL; ?>/member/own_shop.php?action=entity_check"><?php echo $lang['langMainOnClickThis'];?></a>.
										<?php } ?>										
									</li>
									<?php 
										/**
										 * 卖家缴费状态
										 */
										if($output['nonce_pay_mode'] == '1'){ 
									?>
									<li><?php echo $lang['langMainShopPayMemberState'];?>:<a href="own_shop_pay.php?action=pay" target="_blank"><?php echo $lang['langMainShopPay'];?></a></li>
									<li>
										<?php echo $lang['langMainShopPayModeShopUseTime'];?>:
										<?php if($output['shop_ischeck'] !== ''){?>
											<?php if($output['shop_ischeck'] == '0' || $output['shop_ischeck'] == '2'){ ?>
												<?php if($output['shop_ischeck'] == '0'){ ?>
													<?php echo $lang['langMainShopCheckIsZero'];?>
												<?php } ?>
												<?php if($output['shop_ischeck'] == '2'){ ?>
													<?php echo $lang['langMainShopCheckIsTwo'];?>
												<?php } ?>
											<?php } ?>
											<?php if($output['shop_ifdel'] == '1'){ ?>
												<?php echo $lang['langMainShopIsDel'];?>
											<?php } ?>
											<?php if($output['shop_ifdel'] == '0' && $output['shop_ischeck'] == '1'){ ?>
												<?php if($output['member_array']['shop_availability_time'] !== ''){ ?>
													<?php echo $output['member_array']['shop_availability_time'];?>
													<?php if($output['use_day_num'] > 0){ ?>
														<?php echo $lang['langMainShopPayShopUseRemark'];?><?php echo $output['use_day_num']; ?><?php echo $lang['langMainDay'];?>
													<?php }else { ?>
														<?php if($output['member_array']['shop_availability_time'] == $output['now_time']){ ?>
															<?php echo $lang['langMainShopPayShopBecomeClosed'];?>
														<?php }else { ?>
															<?php echo $lang['langMainShopPayShopClosed'];?>
														<?php } ?>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										<?php }else{ ?>
											<?php echo $lang['langMainNotHaveShop'];?>
										<?php } ?>
									</li>
									<li><?php echo $lang['langMainShopPayModeProductNumber'];?>:<?php echo $output['member_array']['product_number']?$output['member_array']['product_number']:'0';?> (<?php echo $lang['langMainShopPayUsed'];?><?php echo $output['product_count']?$output['product_count']:'0';?><?php echo $lang['langMainUnit'];?>)</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>