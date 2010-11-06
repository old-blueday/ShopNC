<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langOrderAuctionPay']; ?></p>
				</div>
				<div class="clear-9"></div>			
				<div class="nav">
					<ul>			
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langOrderAuctionPay'];?></p></span></li>
					</ul>
				</div>
				<form name="form_pay_save" id="form_pay_save" action="own_product_auction.php?action=pay_confirm_save" method="post" onsubmit="return checkPay();">
				<input type="hidden" name="sp_code" id="sp_code" value="<?php echo $output['order_array']['sp_code']; ?>" />
				<input type="hidden" name="member_predeposit" id="member_predeposit" value="<?php echo $output['member_predeposit']; ?>" />
				<input type="hidden" name="total_price" id="total_price" value="<?php echo $output['order_array']['total_price']; ?>" />
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langOrderCode']; ?>:</td>
							<td class="cr-2"><?php echo $output['order_array']['sp_code']?>[<a href="<?php echo SITE_URL; ?>/member/own_order.php?action=show&sp_code=<?php echo $output['order_array']['sp_code']?>"><?php echo $lang['langOrderInfo']; ?></a>]</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langOrderPayment']; ?>:</td>
							<td class="cr-2">
								<?php if(!empty($output['payment_array']) && is_array($output['payment_array'])){ ?>
									<?php foreach($output['payment_array'] as $k => $v){ ?>
										<input type="radio" name="sp_pay_mechod" value="<?php echo $k;?>" />
										<?php echo $v['name'];?>
									<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPAvailablePredeposit']; ?>:</td>
							<td class="cr-2">
								<?php echo $output['member_predeposit']; ?>
								<?php if($output['member_predeposit'] < $output['order_array']['total_price']){ ?>
									<?php echo $lang['errOrderPredepositIsNotEnough']; ?>
									<span class="buttom-comm">
										<input type="button" class='submit' name="" value="<?php echo $lang['langProductPredepositPay']; ?>" onclick="alert('1');" />
									</span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langOrderAuctionPrice']; ?>:</td>
							<td class="cr-2">
								<?php echo $output['order_array']['total_price']; ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input type="submit" class='submit' name="" value="<?php echo $lang['langOrderConfirmPay']; ?>" />
					</span>
					<span class="buttom-comm">
						<input type="button" class='submit' name="" value="<?php echo $lang['langOrderBack']; ?>" onclick="history.back()" />
					</span>					
				</div>				
				</form>
			</div>
		</div>
	</div>
</div>
<script>
function checkPay(){
	if(typeof($('input[name=sp_pay_mechod][type=radio]:checked').val()) == 'undefined'){
		alert('<?php echo $lang['langOSelectPaymentToPay'];?>');
		return false;
	}else {
		if(typeof($('input[name=sp_pay_mechod][type=radio]:checked').val()) == 'predeposit'){
			if(parseFloat($('#member_predeposit').val()) > parseFloat($('#total_price').val())){
				return true;
			}else {
				alert('<?php echo $lang['errOrderPredepositIsNotEnough']; ?>');
				return false;
			}
		}else {
			return true;
		}
	}
}
</script>