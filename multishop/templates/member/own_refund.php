<script language='javascript'>
$(function(){
	$("#messageForm").validate({
		errorClass: "wrong",
		rules: {
			<?php if ($output['type'] == 'seller') {?>
				txtMessage: {required:"#refundConfirm2:checked"}
			<?php } ?>
			<?php if ($output['type'] == 'buyer') {?>
				txtMessage: {required:true}
			<?php } ?>
		},
		messages: {
			<?php if ($output['type'] == 'seller') {?>
				txtMessage: {required: "<?php echo $lang['langRefundSellerMessageNoEmpty']; ?>"}
			<?php } ?>
			<?php if ($output['type'] == 'buyer') {?>
				txtMessage: {required: "<?php echo $lang['langRefundBuyerMessageNoEmpty']; ?>"}
			<?php } ?>			
		}
	});
	$("input[name='refundConfirm']").click(function(){
		if ($(this).val() == 1) {
			$("#refundBack").hide();
		}
		if ($(this).val() == 2) {
			$("#refundBack").show();
		}		
	});
})
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<?php if ($output['type'] == 'buyer') {?>
						<p><?php echo $lang['langRefundAddExplain1']; ?></p>
					<?php } ?>
					<?php if ($output['type'] == 'seller') {?>
						<p><?php echo $lang['langRefundAddExplain2']; ?></p>
					<?php } ?>					
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<?php if ($output['type'] == 'buyer') {?>
							<li class="nav-bg"><b></b><span><p><?php echo $lang['langRefund']; ?></p></span></li>
						<?php } ?>
						<?php if ($output['type'] == 'seller') {?>
							<li class="nav-bg"><b></b><span><p><?php echo $lang['langRefundConfirm']; ?></p></span></li>
						<?php } ?>
					</ul>
				</div>		
				<?php if ($output['type'] == 'buyer') {?>				
					<div class="cr-right">
	    				<form name="messageForm" id="messageForm" action="own_order.php?action=refund_save" method="post">			
	    				<input type="hidden" name="sp_code" value="<?php echo $output['order_array']['sp_code']; ?>" />
						<table width="100%" class="cr-r-td" border="0" cellpadding="0">
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundOrderNumber']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['order_array']['sp_code']; ?> <a href="own_order.php?action=show&sp_code=<?php echo $output['order_array']['sp_code']; ?>" target="_blank">[<?php echo $lang['langOrderListDetail']; ?>]</a>
								</td>
							</tr>	
							<tr>
								<td class="cr-1"><?php echo $lang['langProName']; ?>:</td>
								<td class="cr-2">
					    			<?php echo $output['order_array']['p_name']; ?>
							    	[
							    	<!-- 过渡使用，如果没有快照，则查看相当商品详情 -->
							    	<?php if ( $output['order_array']['sp_html'] != '' ) { ?>
										<a href="<?php echo SITE_URL; ?>/home/order.php?action=sp_html&sp_code=<?php echo $output['order_array']['sp_code']; ?>" target="_blank"><?php echo $lang['langOViewProductInfo'];?></a>					    	
							    	<?php } else { ?>
							    		<?php if ( $output['ifhtml'] == '1' && $output['html_url'] != '' ) { ?>
											<a target="_blank" href="<?php echo $output['html_url']; ?>" title='<?php echo $lang['langOViewProductInfo'];?>'><?php echo $lang['langOViewProductInfo'];?></a>					    		
							    		<?php } else { ?>
											<a target="_blank" href="<?php echo $output['order_array']['product_href']; ?>" title='<?php echo $lang['langOViewProductInfo'];?>'><?php echo $lang['langOViewProductInfo'];?></a>					    		
							    		<?php } ?>
							    	<?php } ?>
							    	]
								</td>
							</tr>	
							<tr>
								<td class="cr-1"><?php echo $lang['langOrderPayment']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['payment'][$output['order_array']['sp_pay_mechod']]; ?>
								</td>
							</tr>																				
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundReason']; ?>:</td>
								<td class="cr-2">
									<textarea name="txtMessage" cols="60" rows="5" id="txtMessage"></textarea>
									<label style="display:none" for="txtMessage" class="error" metaDone="true" generated="true"></label>
								</td>
							</tr>																																		
						</table>
						<div class="an-1">
							<span class="buttom-comm">
								<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
							</span>
							<span class="buttom-comm">
								<input type="button" class='submit' name="" value="<?php echo $lang['langCReturn']; ?>" onclick="javascript:history.go(-1);" />
							</span>							
						</div>		
						</form>			
					</div>
				<?php } ?>
				<?php if ($output['type'] == 'seller') {?>
					<div class="cr-right">
	    				<form name="messageForm" id="messageForm" action="own_order.php?action=refund_confirm_save" method="post">			
	    				<input type="hidden" name="sp_code" value="<?php echo $output['order_array']['sp_code']; ?>" />
						<table width="100%" class="cr-r-td" border="0" cellpadding="0">
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundOrderNumber']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['order_array']['sp_code']; ?> <a href="own_order.php?action=show&sp_code=<?php echo $output['order_array']['sp_code']; ?>" target="_blank">[<?php echo $lang['langOrderListDetail']; ?>]</a>
								</td>
							</tr>	
							<tr>
								<td class="cr-1"><?php echo $lang['langProName']; ?>:</td>
								<td class="cr-2">
					    			<?php echo $output['order_array']['p_name']; ?>
							    	[
							    	<!-- 过渡使用，如果没有快照，则查看相当商品详情 -->
							    	<?php if ( $output['order_array']['sp_html'] != '' ) { ?>
										<a href="<?php echo SITE_URL; ?>/home/order.php?action=sp_html&sp_code=<?php echo $output['order_array']['p_code']; ?>" target="_blank"><?php echo $lang['langOViewProductInfo'];?></a>					    	
							    	<?php } else { ?>
							    		<?php if ( $output['ifhtml'] == '1' && $output['html_url'] != '' ) { ?>
											<a target="_blank" href="<?php echo $output['html_url']; ?>" title='<?php echo $lang['langOViewProductInfo'];?>'><?php echo $lang['langOViewProductInfo'];?></a>					    		
							    		<?php } else { ?>
											<a target="_blank" href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $output['order_array']['p_code']; ?>" title='<?php echo $lang['langOViewProductInfo'];?>'><?php echo $lang['langOViewProductInfo'];?></a>					    		
							    		<?php } ?>
							    	<?php } ?>
							    	]
								</td>
							</tr>	
							<tr>
								<td class="cr-1"><?php echo $lang['langOrderPayment']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['payment'][$output['order_array']['sp_pay_mechod']]; ?>
								</td>
							</tr>	
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundReason']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['order_array']['buyer_refund_message']; ?>
								</td>
							</tr>								
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundConfirm']; ?>:</td>
								<td class="cr-2">
									<label for="refundConfirm1"><input type="radio" name="refundConfirm" id="refundConfirm1" value="1" checked /><?php echo $lang['langRefundSellerAgree']; ?></label>
									<label for="refundConfirm2"><input type="radio" name="refundConfirm" id="refundConfirm2" value="2" /><?php echo $lang['langRefundSellerNoAgree']; ?></label>
								</td>
							</tr>																											
							<tr id="refundBack" style="display:none;">
								<td class="cr-1"><?php echo $lang['langRefundSellerNoAgreeReason']; ?>:</td>
								<td class="cr-2">
									<textarea name="txtMessage" cols="60" rows="5" id="txtMessage"></textarea>
									<label style="display:none" for="txtMessage" class="error" metaDone="true" generated="true"></label>
								</td>
							</tr>																																		
						</table>
						<div class="an-1">
							<span class="buttom-comm">
								<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
							</span>
							<span class="buttom-comm">
								<input type="button" class='submit' name="" value="<?php echo $lang['langCReturn']; ?>" onclick="javascript:history.go(-1);" />
							</span>							
						</div>		
						</form>			
					</div>				
				<?php } ?>
			</div>
		</div>
	</div>
</div>