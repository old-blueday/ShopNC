<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPreCashInfoView'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPreCashInfoView'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langPrePayment'];?>:</td>
							<td class="cr-2">
								<?php if($output['cash_array']['payment_type'] == '1'){?>
									<?php echo $lang['langPreCashTypeOffline'];?>
								<?php }else{ ?>
									<?php if($output['cash_array']['payment'] == 'alipay'){?>
										<?php echo $lang['langPreCashTypeAlipay'];?>
									<?php } ?>
									<?php if($output['cash_array']['payment'] == 'tenpay'){?>
										<?php echo $lang['langPreCashTypeTenpay'];?>
									<?php } ?>
									<?php if($output['cash_array']['payment'] == '99bill'){?>
										<?php echo $lang['langPreCashTypeKqpay'];?>
									<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashCreateTime'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['create_time'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreState'];?>:</td>
							<td class="cr-2"><?php echo $output['predeposit_record_state'][$output['cash_array']['record_state']];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashPaymentTrade'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['payment_trade'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashAmount'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['amount'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashPayAccount'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['pay_account'];?></td>
						</tr>
						<?php 
						/**
						 * 线下支付
						 */
							if($output['cash_array']['payment_type'] == '1'){
						?>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashPayBank'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['pay_bank'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashPayConsignee'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['pay_consignee'];?></td>
						</tr>
						<?php } ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['pay_remark'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashSystemRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['cash_array']['system_remark'];?></td>
						</tr>
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