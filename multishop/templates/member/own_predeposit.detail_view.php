<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPreDetailInfoView'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPreDetailInfoView'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langPreDetailType'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_type'][$output['detail_array']['predeposit_type']];?></td>
						</tr>
						<?php if ( $output['product_array']['p_code'] != '' ) { ?>
							<tr>
								<td class="cr-1"><?php echo $lang['langPProduct']; ?>:</td>
								<td class="cr-2"><?php echo $output['product_array']['p_name'];?> [<a href="<?php echo $output['product_array']['link']; ?>" target="_blank"><?php echo $lang['langPProductInfo']; ?></a>]</td>
							</tr>						
						<?php } ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreDetailState'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_state'][$output['detail_array']['predeposit_state']];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreDetailCreateTime'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['create_time'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreDetailUpdateTime'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['update_time'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayment'];?>:</td>
							<td class="cr-2">
								<?php if($output['detail_array']['payment'] == '99bill'){?>
								<?php echo $lang['langPreCashTypeKqpay'];?>
								<?php }elseif ($output['detail_array']['payment'] == 'predeposit') { ?>
								<?php echo $lang['langBPredeposit']; ?>
								<?php } else { ?>
								<?php echo $output['detail_array']['payment'];?>
								<?php }?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreAvailableUpdate'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['available_amount'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreFreezeUpdate'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['freeze_amount'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreMemberRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['member_remark'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashSystemRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['system_remark'];?></td>
						</tr>
						<?php if($output['detail_array']['to_member_id'] !== ''){?>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreDetailToMemberName'];?>:</td>
							<td class="cr-2"><?php echo $output['to_member_array']['login_name'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreDetailSpcode'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['sp_code'];?></td>
						</tr>
						<?php }?>
						<?php if($output['detail_array']['predeposit_r_id'] !== ''){?>
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayInfo'];?><?php echo $lang['langPreDetailCreateTime'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['create_time'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayInfo'];?><?php echo $lang['langPreState'];?>:</td>
							<td class="cr-2"><?php echo $output['predeposit_record_state'][$output['record_array']['record_state']];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayInfo'];?><?php echo $lang['langPrePayment'];?>:</td>
							<td class="cr-2">
								<?php if($output['record_array']['payment'] == '99bill'){?>
								<?php echo $lang['langPreCashTypeKqpay'];?>
								<?php }else { ?>
								<?php echo $output['record_array']['payment'];?>
								<?php }?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreReceptPayName'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['pay_name'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreReceptPayAccount'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['pay_account'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreReceptPayConsignee'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['pay_consignee'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreSenderName'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['sender_name'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreSenderBank'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['sender_bank'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreSenderAmount'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['sender_amount'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreSenderDate'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['sender_date'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreSenderRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['sender_remark'];?></td>
						</tr>
						<?php }?>
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input type="button" class='submit' name="" value="<?php echo $lang['langPreReturn'];?>" onclick="history.back();" />
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>