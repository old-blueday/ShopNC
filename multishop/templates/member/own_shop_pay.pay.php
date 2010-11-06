<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langShopPayDetailManage'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopPayDetailManage'];?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_shop_pay.php?action=detail_list"><?php echo $lang['langShopPayDetailList'];?></a></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
				<form action="own_shop_pay.php?action=pay_save" method="post" name="form_pay" id="form_pay">
					<table width="100%" style="*border-bottom:#deebfb 1px solid" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayState'];?>:</td>
							<td class="cr-2">
								<?php if($output['member_array']['shop_availability_time'] != ''){ ?>
									<?php echo $lang['langShopPayModeShopUseTimeTo'];?>:<?php echo $output['member_array']['shop_availability_time']; ?>
									<?php if($output['use_day_num'] != ''){ ?>
										<?php echo $lang['langShopPayShopUseRemark'];?>:<?php echo $output['use_day_num'];?><?php echo $lang['langDay'];?>
									<?php }else{ ?>
										<?php echo $lang['langShopPayShopClosed'];?>
									<?php } ?>
								<?php } ?>
								<?php echo $lang['langShopPayModeProductNumber'];?>:<?php echo $output['member_array']['product_number']?$output['member_array']['product_number']:'0'; ?>
								<?php echo $lang['langShopPayUsed'];?>:<?php echo $output['product_count']?$output['product_count']:'0'; ?><?php echo $lang['langShopPayModeProductNumberUnit'];?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailType'];?>:</td>
							<td class="cr-2">
								<?php if(!empty($output['mode_array']) && is_array($output['mode_array'])){ ?>
								<select name="pay_mode_id" id="pay_mode_id" onchange="change_mode(this.value);">
								<?php foreach($output['mode_array'] as $k => $v){ ?>
									<option value="<?php echo $v['mode_id'];?>"><?php echo $v['mode_name'];?></option>
								<?php } ?>
								</select>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"></td>
							<td class="cr-2">
								<?php if(!empty($output['mode_array']) && is_array($output['mode_array'])){ ?>
								<?php foreach($output['mode_array'] as $k => $v){ ?>
									<span id="span_mode_content_<?php echo $v['mode_id']; ?>" style="display:none">
										<?php echo $lang['langShopPayDetailModeMoney'];?>:<?php echo $v['mode_money']; ?>
										<?php echo $lang['langShopPayDetailModeName'];?>:<?php echo $lang['langShopPayModeShopUseTime'];?><?php echo $lang['langShopPayAdd'];?><?php echo $v['mode_shop_show_time'];?><?php echo $lang['langShopPayModeShopUseTimeUnit'];?><?php echo $lang['langShopPayModeProductNumber'];?><?php echo $lang['langShopPayAdd'];?><?php echo $v['mode_product_number'];?><?php echo $lang['langShopPayModeProductNumberUnit'];?>
									</span>
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"></td>
							<td class="cr-2">
								<input type="radio" id="pay_type_online" name="pay_type" checked="checked" value="online" onclick="$('#tr_online').css('display','');$('#tr_offline').css('display','none');" /><?php echo $lang['langShopPayDetailPayOnline'];?>
								<input type="radio" id="pay_type_offline" name="pay_type" value="offline" onclick="$('#tr_online').css('display','none');$('#tr_offline').css('display','');" /><?php echo $lang['langShopPayDetailPayOffline'];?>
							</td>
						</tr>
						<tr id="tr_online"><!-- 线上 -->
							<td class="cr-1"></td>
							<td class="cr-2">
								<input type="radio" name="online_type" id="online_type_alipay" value="alipay" checked="checked" /><label for="online_type_alipay"><?php echo $lang['langShopPayDetailPayAlipay'];?></label>
								<input type="radio" name="online_type" id="online_type_tenpay" value="tenpay" /><label for="online_type_tenpay"><?php echo $lang['langShopPayDetailPayTenpay'];?></label>
								<input type="radio" name="online_type" id="online_type_99bill" value="99bill" /><label for="online_type_99bill"><?php echo $lang['langShopPayDetailPayKqpay'];?></label>
							</td>
						</tr>
						<tr id="tr_offline" style="display:none"><!-- 线下 -->
							<td class="cr-1"></td>
							<td class="cr-2">
								<table width="100%" class="n-yang" border="0" cellpadding="0">
									<tr>
										<td><?php echo $lang['langShopPayDetailSel'];?></td>
										<td><?php echo $lang['langShopPayDetailOfflinePayName'];?></td>
										<td><?php echo $lang['langShopPayDetailOfflinePayAccount'];?></td>
										<td><?php echo $lang['langShopPayDetailOfflinePayConsignee'];?></td>
									</tr>
									<?php if(!empty($output['offline_pay']) && is_array($output['offline_pay'])){ ?>
									<?php foreach($output['offline_pay'] as $k => $v){ ?>
									<tr>
										<td>
											<input type="radio" name="offline_pay_id" <?php if($k == '1'){?>checked="checked"<?php } ?> value="<?php echo $v['pay_id'];?>" />
										</td>
										<td>
											<?php if($v['pay_ico'] !== ''){?>
												<img src="<?php echo $v['pay_ico'];?>" />
											<?php } ?>
											<?php echo $v['pay_name']; ?>
										</td>
										<td><?php echo $v['pay_account']; ?></td>
										<td><?php echo $v['pay_consignee']; ?></td>
									</tr>
									<?php } ?>
									<?php } ?>
									<tr class="tr-not">
										<td><?php echo $lang['langShopPayDetailOfflineSenderNumber'];?>:</td>
										<td colspan="3">
										<input class="input-150" type="text" name="sender_number" id="sender_number" />
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<div class="an-1"><span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsave'];?>" />
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
			sender_number:{required:function(){
					if($('#pay_type_offline').attr('checked') == true){
						return true;
					}else{
						return false;
					}
				}
			}
		},
		messages: {
			sender_number:{required:"<?php echo $lang['errShopPayDetailSenderNumberIsEmpty']; ?>"}
		}
	});
	//显示当前的缴费条目的内容
	$('#span_mode_content_'+$('#pay_mode_id').val()).css('display','');
});
function change_mode(mode_id){
	$('span').each(function(){
		if(this.id.indexOf('span_mode_content_') != -1){
			$('#'+this.id).css('display','none');
		}
	});
	$('#span_mode_content_'+mode_id).css('display','');
}
</script>