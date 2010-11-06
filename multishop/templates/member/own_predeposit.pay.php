<link href="<?php echo SITE_URL; ?>/js/jquery/ui.theme.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/jquery/ui.datepicker.js"></script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langPredepositPay'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPredepositPay'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
				<form action="own_predeposit.php?action=pay_save" method="post" name="form_pay" id="form_pay">
					<table width="100%" class="cr-r-td" style=" border-bottom:#deebfb 1px solid;" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"></td>
							<td class="cr-2">
								<input type="radio" id="pay_type_online" name="pay_type" checked="checked" value="online" onclick="$('#tr_online').css('display','');$('#tr_online_amount').css('display','');$('#tr_offline').css('display','none');$('#line_explain').show();" /><label for="pay_type_online"><?php echo $lang['langPrePayOnline'];?></label>
								<input type="radio" name="pay_type" id="pay_type_offline" value="offline" onclick="$('#tr_offline').css('display','');$('#tr_online_amount').css('display','none');$('#tr_online').css('display','none');$('#line_explain').hide();" /><label for="pay_type_offline"><?php echo $lang['langPreCashTypeOffline'];?></label>
							</td>
						</tr>
						<tr id="tr_online">
							<td class="cr-1"></td>
							<td class="cr-2">
								<?php if(!empty($output['offline_array']['online']) && is_array($output['offline_array']['online'])){?>
								<?php $i = 0;?>
								<?php foreach($output['offline_array']['online'] as $k => $v){?>
									<?php if(($k == 'alipay' || $k == 'tenpay' || $k == '99bill') && $v != ''){ ?>
									<input type="radio" <?php if($i == '0'){ ?>checked="checked"<?php } ?> name="online_type" id="online_type_<?php echo $k;?>" value="<?php echo $k;?>" />
									<label for="online_type_<?php echo $k;?>">
										<?php if($k == 'alipay'){ ?><?php echo $lang['langPreCashTypeAlipay'];?><?php } ?>
										<?php if($k == 'tenpay'){ ?><?php echo $lang['langPreCashTypeTenpay'];?><?php } ?>
										<?php if($k == '99bill'){ ?><?php echo $lang['langPreCashTypeKqpay'];?><?php } ?>
									</label>
									<?php $i++; ?>
									<?php } ?>
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr id="tr_online_amount">
							<td class="cr-1"><?php echo $lang['langPrePayAmount'];?>:</td>
							<td width="615" class="cr-2"><input type="text" name="online_amount" class="in" id="online_amount" /></td>
						</tr>
						<tr id="line_explain">
							<td colspan="2"><span style="padding-top:4px; padding-left:5px; color:#808080;"><?php echo $lang['langLineExplain']; ?></span></td>						
						</tr>							
						<tr style="display:none" id="tr_offline">
							<td class="cr-1"></td>
							<td class="cr-2">
								<table width="95%">
									<?php if(!empty($output['offline_pay']) && is_array($output['offline_pay'])){?>
									<?php foreach($output['offline_pay'] as $k => $v){?>
									<tr>
										<td>
											<input type="radio" name="offline_pay_id" <?php if($k == '0'){ ?>checked="checked"<?php } ?> value="<?php echo $v['pay_id'];?>" />
										</td>
										<td>
											<?php if($v['pay_ico'] !== ''){ ?>
												<img src="<?php echo $v['pay_ico'];?>" width="60px;" height="40px;" />
											<?php } ?> 
											<?php echo $lang['langPreReceptPayName'];?>:<?php echo $v['pay_name'];?>
											<input type="hidden" name="pay_name_<?php echo $v['pay_id'];?>" id="pay_name_<?php echo $v['pay_id'];?>" value="<?php echo $v['pay_name'];?>" />
											<?php echo $lang['langPreReceptPayAccount'];?>:<?php echo $v['pay_account'];?>
											<input type="hidden" name="pay_account_<?php echo $v['pay_id'];?>" id="pay_account_<?php echo $v['pay_id'];?>" value="<?php echo $v['pay_account'];?>" />
											<?php echo $lang['langPreReceptPayConsignee'];?>:<?php echo $v['pay_consignee'];?>
											<input type="hidden" name="pay_consignee_<?php echo $v['pay_id'];?>" id="pay_consignee_<?php echo $v['pay_id'];?>" value="<?php echo $v['pay_consignee'];?>" />
										</td>
									</tr>
									<?php } ?>
									<?php } ?>
									<tr>
									
										<td colspan="2">
											<table width="90%" align="center" style=" margin-left:auto; margin-right:auto;">
												<tr>
													<td class="cr-1"><?php echo $lang['langPreSenderName'];?>:</td>
													<td class="cr-2"><input type="text" name="txt_sender_name" class="in" id="txt_sender_name" /></td>
												</tr>
												<tr>
													<td class="cr-1"><?php echo $lang['langPreSenderBank'];?>:</td>
													<td class="cr-2"><input type="text" name="txt_sender_bank" class="in" id="txt_sender_bank" /></td>
												</tr>
												<tr>
													<td class="cr-1"><?php echo $lang['langPreSenderAmount'];?>:</td>
													<td class="cr-2"><input type="text" name="txt_sender_amount" class="in" id="txt_sender_amount" /></td>
												</tr>
												<tr>
													<td class="cr-1"><?php echo $lang['langPreSenderDate'];?>:</td>
													<td class="cr-2"><input type="text" name="txt_sender_date" id="txt_sender_date" class="in" readonly="readonly" /></td>
												</tr>
												<tr>
													<td class="cr-1"><?php echo $lang['langPreMemberRemark'];?>:</td>
													<td class="cr-2"><textarea name="txt_sender_remark" id="txt_sender_remark" cols="50" rows="5"></textarea></td>
												</tr>
											</table>
										</td>
									</tr>								
								</table>
							</td>
						</tr>
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langPrePay'];?>" />
						</span>
						<span class="buttom-comm">
							<input type="button" class='submit' name="" value="<?php echo $lang['langPreReturn'];?>" onclick="location.href='own_predeposit.php?action=list'" />
						</span>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#txt_sender_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});
	//对添加表单做的验证定义
	$('#form_pay').validate({
		errorClass: "wrong",
		rules: {
			txt_sender_name: {required:"#pay_type_offline:checked"},
			txt_sender_bank: {required:"#pay_type_offline:checked"},
			txt_sender_amount: {required:"#pay_type_offline:checked",number:"#pay_type_offline:checked"},
			txt_sender_date: {required:"#pay_type_offline:checked"},
			online_amount: {required:"#pay_type_online:checked",number:"#pay_type_online:checked",min:0.1}
		},
		messages: {
			txt_sender_name: {required: "<?php echo $lang['langPreSenderNameIsEmpty'];?>"},
			txt_sender_bank: {required: "<?php echo $lang['langPreSenderBankIsEmpty'];?>"},
			txt_sender_amount: {required:"<?php echo $lang['langPreSenderAmountIsEmpty'];?>",number:"<?php echo $lang['langPrePayAmountIsNotVoid'];?>"},
			txt_sender_date: {required:"<?php echo $lang['langPreSenderDateIsEmpty'];?>"},
			online_amount: {required:"<?php echo $lang['langPrePayAmountIsNotVoid'];?>",number:"<?php echo $lang['langPrePayAmountIsNotVoid'];?>",min:"<?php echo $lang['langPrePayAmountIsNotVoid'];?>"}
		}
	});
});
</script>