<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langPreCashSet'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPreCashSet'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
				<form action="own_predeposit.php?action=cash_save" method="post" name="form_pay" id="form_pay">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"></td>
							<td class="cr-2">
								<input type="radio" id="pay_type_online" name="pay_type" checked="checked" value="online" onclick="$('#tr_online').css('display','');$('#tr_online_amount').css('display','');$('#tr_offline').css('display','none');" /><label for="pay_type_online"><?php echo $lang['langPrePayOnline'];?></label>
								<input type="radio" name="pay_type" id="pay_type_offline" value="offline" onclick="$('#tr_offline').css('display','');$('#tr_online_amount').css('display','none');$('#tr_online').css('display','none');" /><label for="pay_type_offline"><?php echo $lang['langPreCashTypeOffline'];?></label>
							</td>
						</tr>
						<tr id="tr_online">
							<td class="cr-1"></td>
							<td class="cr-2">
								<input type="radio" checked="checked" name="online_type" id="online_type_a" value="alipay" /><label for="online_type_a"><?php echo $lang['langPreCashTypeAlipay'];?></label>
								<input type="radio" name="online_type" id="online_type_t" value="tenpay" /><label for="online_type_t"><?php echo $lang['langPreCashTypeTenpay'];?></label>
								<input type="radio" name="online_type" id="online_type_k" value="99bill" /><label for="online_type_k"><?php echo $lang['langPreCashTypeKqpay'];?></label>
							</td>
						</tr>
						<tr id="tr_offline" style="display:none">
							<td class="cr-1"></td>
							<td class="cr-2">
								<table width="90%" align="center" style=" margin-left:auto; margin-right:auto; clear:both;">
									<tr>
										<td class="cr-1"><?php echo $lang['langPrePayConsignee'];?>:</td>
										<td class="cr-2"><input type="text" class="in"  name="txt_pay_consignee" id="txt_pay_consignee" /></td>
									</tr>
									<tr>
										<td class="cr-1"><?php echo $lang['langPreCashPayBank'];?>:</td>
										<td class="cr-2"><input type="text" name="txt_pay_bank"  class="in" id="txt_pay_bank" /></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashAmount'];?>:</td>
							<td class="cr-2"><input type="text" name="amount" class="in" id="amount" value="0" /></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashPayAccount'];?>:</td>
							<td class="cr-2"><span><input type="text" name="pay_account" class="in" id="pay_account" /></span><span class="cr-5-span"><?php echo $lang['langPreCashPayAccountRemark'];?></span></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreCashRemark'];?>:</td>
							<td class="cr-2"><textarea name="txt_remark" id="txt_remark" cols="50" rows="5"></textarea></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPreMemberAvailable'];?>:</td>
							<td class="cr-2"><?php echo $output['member_array']['available_predeposit']?$output['member_array']['available_predeposit']:'0';?></td>
						</tr>
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langPreCashSubmit'];?>" />
						</span>
						<span class="buttom-comm">
							<input type="button" class='submit' name="" value="<?php echo $lang['langPreReturn'];?>" onclick="history.back();" />
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
	$('#form_pay').validate({
		errorClass: "wrong",
		rules: {
			amount: {required:true,number:true,min:0.01,max:<?php echo $output['member_array']['available_predeposit']?$output['member_array']['available_predeposit']:'0'; ?>},
			pay_account: {required:true},
			txt_pay_consignee: {required:"#pay_type_offline:checked"},
			txt_pay_bank: {required:"#pay_type_offline:checked"}
			
		},
		messages: {
			amount: {required:"<?php echo $lang['langPreAmountIsEmpty'];?>",number:"<?php echo $lang['langPreCashAmountIsNotNumber'];?>",min:"<?php echo $lang['langPreCashAmountIsNotNumber'];?>",max:"<?php echo $lang['langPreCashAmountIsTooBig'];?>"},
			pay_account: {required: "<?php echo $lang['langPrePayAccountIsEmpty'];?>"},
			txt_pay_consignee: {required: "<?php echo $lang['langPrePayConsigneeIsEmpty'];?>"},
			txt_pay_bank: {required:"<?php echo $lang['langPrePayBankIsEmpty'];?>"}
		}
	});
});
</script>