<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPreRecordView'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPreRecordView'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayment'];?>:</td>
							<td class="cr-2">
								<?php if($output['record_array']['payment_type'] == '1'){?>
									<?php echo $lang['langPreCashTypeOffline'];?>
								<?php }else{ ?>
									<?php if($output['record_array']['payment'] == 'alipay'){?>
										<?php echo $lang['langPreCashTypeAlipay'];?>
									<?php } ?>
									<?php if($output['record_array']['payment'] == 'tenpay'){?>
										<?php echo $lang['langPreCashTypeTenpay'];?>
									<?php } ?>
									<?php if($output['record_array']['payment'] == '99bill'){?>
										<?php echo $lang['langPreCashTypeKqpay'];?>
									<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashCreateTime'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['create_time'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreState'];?>:</td>
							<td class="cr-2"><?php echo $output['predeposit_record_state'][$output['record_array']['record_state']];?></td>
						</tr>
						<?php 
						/**
						 * 线下支付
						 */
							if($output['record_array']['payment_type'] == '1'){
						?>
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
						<?php }else { ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayAmount'];?>:</td>
							<td class="cr-2"><?php echo $output['record_array']['online_amount'];?></td>
						</tr>
						<?php } ?>
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