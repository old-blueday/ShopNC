<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="nav">
					<ul>
						<?php if ( $output['type'] == '' ) { ?>
							<li class="nav-bg"><b></b><span><p><?php echo $lang['langCompComplaintsLaw']; ?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1"><b></b><span><p><a href="own_complaint.php" ><?php echo $lang['langCompComplaintsLaw']; ?></a></p></span></li>
						<?php } ?>
						<?php if ( $output['type'] == 'complaint' ) { ?>
							<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCompComp']; ?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_complaint.php?type=complaint&send_receive=receive&state=all"><?php echo $lang['langCompComp']; ?></a></p></span></li>
						<?php } ?>		
						<?php if ( $output['type'] == 'report' ) { ?>
							<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCompLaw']; ?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_complaint.php?type=report&send_receive=receive&state=all"><?php echo $lang['langCompLaw']; ?></a></p></span></li>
						<?php } ?>											
					</ul>
				</div>
				<div class="clear"></div>
				<div class="io-3-book"><p><strong><?php echo $lang['langCompReflectCircs']; ?></strong></p>
				</div>
				<div class="clear"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="st-1 publico">
					<table cellpadding="0" border="0" width="100%">
						<tr>
							<td colspan="6" align="left">
								<?php if ( $output['complaint_array']['login_name'] == 'login_name' ) { ?>
									<?php echo $lang['langCompYou']; ?>
								<?php } else { ?>
								<b><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['complaint_array']['member_id']; ?>" target="_blank"><?php echo $output['complaint_array']['login_name']; ?></a></b>
								<?php } ?>
								<?php echo $lang['langCompVs']; ?>
								<?php if ( $output['complaint_array']['c_r_login_name'] == 'login_name' ) { ?>
									<?php echo $lang['langCompYou']; ?>
								<?php } else { ?>
									<b><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['complaint_array']['c_r_member_id']; ?>" target="_blank"><?php echo $output['complaint_array']['c_r_login_name']; ?></a></b>
								<?php } ?>	
								<?php echo $lang['langCompOf'].$lang['langCompComplaintsLaw']; ?>:							
							</td>
						</tr>
						<tr>
							<td class="p-180" style="width:15%;text-align:right;"><?php echo $lang['langCompCorrelationBaby']; ?>:</td>
							<td style="width:25%;text-align:left; line-height:20px; padding-left:5px;"><a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $output['complaint_array']['p_code']; ?>" target="_blank"><?php echo $output['complaint_array']['p_name']; ?></a></td>
							<td class="p-180" style="width:15%;text-align:right;"><?php echo $lang['langCompComplaintsLawMan']; ?>:</td>
							<td style="width:15%;text-align:left; line-height:20px; padding-left:5px;"><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['complaint_array']['member_id']; ?>" target="_blank"><?php echo $output['complaint_array']['login_name']; ?></a></td>
							<td class="p-180" style="width:15%;text-align:right;" ><?php echo $lang['langCompByComplaintsLawMan']; ?>:</td>
							<td style="width:15%;text-align:left; line-height:20px; padding-left:5px;"><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['complaint_array']['c_r_member_id']; ?>" target="_blank"><?php echo $output['complaint_array']['c_r_login_name']; ?></a></td>							
						</tr>
						<tr>
							<td class="p-180" style="width:15%;text-align:right;" ><?php echo $lang['langCompComplaintsLawType']; ?>:</td>
							<td colspan="5" style="text-align:left;padding-left:5px;"><?php echo $output['complaint_report_type'][$output['complaint_array']['c_r_type']]; ?></td>
						</tr>
						<tr>
							<td class="p-180" style="width:15%;text-align:right;" ><?php echo $lang['langCompComplaintsLawNumber']; ?>:</td>
							<td style="text-align:left;padding-left:5px;"><?php echo $output['complaint_array']['complaint_report_id']; ?></td>
							<td class="p-180" style="width:15%;text-align:right;" ><?php echo $lang['langCompComplaintsLawTime']; ?>:</td>
							<td style="text-align:left;padding-left:5px;"><?php echo empty( $output['complaint_array']['c_r_add_time'] ) ? $lang['langCNot'] : $output['complaint_array']['c_r_add_time']; ?></td>
							<td class="p-180" style="width:15%;text-align:right;"  ><?php echo $lang['langCompEndTime']; ?>:</td>
							<td style="text-align:left;padding-left:5px;"><?php echo empty( $output['complaint_array']['c_r_end_time'] ) ? $lang['langCNot'] : $output['complaint_array']['c_r_end_time']; ?></td>							
						</tr>						
					</table>
					<br/>
					<table cellpadding="0" border="0" width="100%">
						<?php if ( $output['complaint_array']['c_r_evidence'] != '' ) { ?>
							<tr>
								<td class="p-180" style="width:15%;text-align:right;" ><?php echo $lang['langCompProof']; ?>:</td>
								<td style="text-align:left;padding-left:5px; line-height:20px;"><?php echo $output['complaint_array']['c_r_evidence']; ?></td>
							</tr>
						<?php } ?>
						<?php if ( $output['complaint_array']['c_r_pic'] != '' ) { ?>
							<tr>
								<td class="p-180" style="width:15%;text-align:right;"><?php echo $lang['langCompCorrelationImage']; ?>:</td>
								<td style="text-align:left;padding-left:5px;"><a href="<?php echo SITE_URL; ?>/<?php echo $output['complaint_array']['c_r_pic']; ?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo $output['complaint_array']['c_r_pic']; ?>" width="100" height="100" border="0" /></a></td>
							</tr>
						<?php } ?>		
						<?php if ( $output['complaint_array']['c_r_pic_two'] != '' ) { ?>
							<tr>
								<td class="p-180" style="width:15%;text-align:right;" ><?php echo $lang['langCompCorrelationImage']; ?>:</td>
								<td style="text-align:left;padding-left:5px;"><a href="<?php echo SITE_URL; ?>/<?php echo $output['complaint_array']['c_r_pic_two']; ?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo $output['complaint_array']['c_r_pic_two']; ?>" width="100" height="100" border="0" /></a></td>
							</tr>
						<?php } ?>	
						<?php if ( $output['complaint_array']['c_r_type'] == '10' ) { ?>
							<tr>
								<td class="p-180" style="width:15%;text-align:right;"><?php echo $lang['langComplaintSellProhibitedProductKind']; ?>:</td>
								<td style="text-align:left;padding-left:5px;"><?php echo $output['embargo_id']; ?></td>
							</tr>
						<?php } ?>	
						<?php if ( $output['complaint_array']['c_r_type'] == '12' ) { ?>
							<tr>
								<td class="p-180" style="width:15%;text-align:right;"><?php echo $lang['langComplaintRepeatShopMerchandise']; ?>:</td>
								<td style="text-align:left;padding-left:5px;"><a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $output['complaint_array']['c_r_related_product']; ?>" target="_blank"><?php echo $output['complaint_array']['c_r_related_product_name']; ?></a></td>
							</tr>
						<?php } ?>	
						<?php if ( $output['complaint_array']['c_r_type'] == '5' ) { ?>
							<tr>
								<td class="p-180" style="width:15%;text-align:right;"><?php echo $lang['langComplaintSpeculationMember']; ?>:</td>
								<td style="text-align:left;padding-left:5px;"><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['complaint_array']['c_r_speculation_member_id']; ?>" target="_blank"><?php echo $output['complaint_array']['c_r_speculation_member_name']; ?></a></td>
							</tr>
						<?php } ?>																												
					</table>
					<br/>
					<table cellpadding="0" border="0" width="100%">
						<tr>
							<td class="p-180" style="width:25%;text-align:right;" ><?php echo $lang['langCompComplaintsLawContent']; ?>:</td>
							<td style="text-align:left;padding-left:5px;">
								<?php if ( $output['complaint_array']['c_r_login_name'] == $output['login_name'] && $output['complaint_array']['c_r_answer'] == '' ) { ?>
									<?php if ( $output['complaint_array']['c_r_handling_state'] != '0' ) { ?>
										<form action="own_complaint.php?action=set_answer" method="post">
											<input type="hidden" name="complaint_report_id" value="<?php echo $output['complaint_array']['complaint_report_id']; ?>" />
											<input type="hidden" name="type" value="<?php echo $output['type']; ?>" />
											<?php echo $lang['langCompSumitAppeal']; ?>:<textarea style="height:70px" name="c_r_answer" cols="40" rows="5"></textarea>
											<input type="submit" name="Submit" class="new_anniu" style="width:50px; padding:0 10px"  value="<?php echo $lang['langCsubmit']; ?>" />
										</form>										
									<?php } else { ?>
										<?php echo $lang['langComplaintSysNotAuditing']; ?>
									<?php } ?>
								<?php } else { ?>
									<?php echo empty( $output['complaint_array']['c_r_answer'] ) ? $lang['langCompNotAppeal'] : $output['complaint_array']['c_r_answer']; ?>
								<?php } ?>
							</td>
						</tr>
					</table>
					<br/>
					<table cellpadding="0" border="0" width="100%">
						<tr>
							<td class="p-180" style="text-align:center;"><?php echo $lang['langCompLeaveWordInfo']; ?></td>
						</tr>
						<tr>
							<td>
								<table cellpadding="0" border="0" width="100%">
									<?php if ( !empty( $output['msg_array'] ) && is_array( $output['msg_array'] ) ) { ?>
										<?php foreach ( $output['msg_array'] as $list ) { ?>
											<tr>
												<td class="p-180" style=" width:15%;text-align:right; padding-left:5px;  border:none;border-right:1px solid #DEEBFB;" ><?php echo $lang['langCompTaobaoLeaveWord']; ?>:</td>
													<td style="text-align:left; padding-left:5px; border:none;">
													<?php echo $list['r_c_content']; ?></td></tr>
													<tr>
													<td colspan="2"  style="height:23px; text-align:right; padding-right:5px; border-right:none; border-bottom:none;"><?php echo $lang['langComplaintDealTime']; ?>：<?php echo $list['r_c_msg_add']; ?></td></tr>
												</td>
											</tr>
										<?php } ?>
										<tr>
											<td style="text-align:left; padding-left:5px; border:none; padding-bottom:10px;"><?php echo $page_list; ?></td>
										</tr>
									<?php } else { ?>
										<tr class="tr-not">
											<td colspan="6"><?php echo $lang['langComplaintNoMsg']; ?></td>
										</tr>										
									<?php } ?>
								</table>
							</td>
						</tr>
					</table>					
				</div>
			</div>
		</div>
	</div>
</div>