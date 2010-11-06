<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPreRecordView'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPreRecordView'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-6 p-left-rio" style="width:10%;"><?php echo $lang['langPreDetailCreateTime'];?></td>
							<td class="td-bg-11" style="width:10%;"><?php echo $lang['langPrePayment'];?></td>
							<td class="td-bg-8" style="width:10%;"><?php echo $lang['langPrePayAmount'];?></td>
							<td class="td-bg-5" style="width:10%;"><?php echo $lang['langPreState'];?></td>
							<td class="td-bg-7" style="width:10%;"><?php echo $lang['langPreAction'];?></td>
						</tr>
						<?php if(!empty($output['record_array']) && is_array($output['record_array'])){ ?>
						<?php foreach($output['record_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-2">
							<td class="p-left-rio" style="width:10%;"><?php echo $v['create_time'];?></td>
							<td style="width:10%;">
								<?php if($v['payment_type'] == '1'){ ?>
									<?php echo $lang['langPreCashTypeOffline']; ?>
									<?php }else { ?>
										<?php if($v['payment'] == 'alipay'){ ?>
										<?php echo $lang['langPreCashTypeAlipay']; ?>
										<?php } ?>
										<?php if($v['payment'] == 'tenpay'){ ?>
										<?php echo $lang['langPreCashTypeTenpay']; ?>
										<?php } ?>
										<?php if($v['payment'] == '99bill'){ ?>
										<?php echo $lang['langPreCashTypeKqpay']; ?>
										<?php } ?>
									<?php } ?>
							</td>
							<td style="width:5%;">
								<?php if($v['payment_type'] == '1'){ ?>
									<?php echo $v['sender_amount']; ?>
									<?php }else{ ?>
									<?php echo $v['online_amount']; ?>
									<?php } ?>
							</td>
							<td style="width:10%;">
								<?php echo $output['predeposit_record_state'][$v['record_state']];?>
							</td>
							<td style="width:10%;">
							<a href="own_predeposit.php?action=record_view&id=<?php echo $v['predeposit_r_id']; ?>"><?php echo $lang['langPreView']; ?></a></p>
							<?php if($v['payment_type'] == '0' && $v['record_state'] == '0'){?>
							<a target="_blank" href="own_predeposit.php?action=record_online_pay&id=<?php echo $v['predeposit_r_id']; ?>"><?php echo $lang['langPrePay']; ?></a>
									<?php } ?>
							</td>
						</tr>
						<?php } ?>
						<?php } ?>
						<tr class="tr-not">
							<td colspan="5"><?php echo $lang['langPreMemberAvailable'];?>:<?php echo $output['member_array']['available_predeposit']?$output['member_array']['available_predeposit']:'0';?></td>
						</tr>
					</table>
				</div>
				<?php if(!empty($output['record_array']) && is_array($output['record_array'])){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['page_list']; ?>
						</div>	
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>