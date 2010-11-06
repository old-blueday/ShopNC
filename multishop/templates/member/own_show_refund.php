<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langRefundInfoView']; ?></p>		
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langRefundInfoAgreement']; ?></p></span></li>
					</ul>
				</div>		
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
									<a href="<?php echo SITE_URL; ?>/home/order.php?action=sp_html&sp_code=<?php echo $output['order_array']['p_code']; ?>" target="_blank"><?php echo $lang['langOViewProductInfo'];?></a>					    	
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
							<td class="cr-1"><?php echo $lang['langRefundBuyTime']; ?>:</td>
							<td class="cr-2">
								<?php echo date('Y-m-d H:i:s',$output['order_array']['sold_time']); ?>
							</td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langRefundAddTime']; ?>:</td>
							<td class="cr-2">
								<?php echo date('Y-m-d H:i:s',$output['order_array']['refund_time']); ?>
							</td>
						</tr>
						<?php if ($output['type'] == 'buyer' && !empty($output['order_array']['seller_refund_message'])) {?>
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundSellerNoAgree']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['order_array']['seller_refund_message']; ?>
								</td>
							</tr>						
						<?php } else { ?>
							<tr>
								<td class="cr-1"><?php echo $lang['langRefundReason']; ?>:</td>
								<td class="cr-2">
									<?php echo $output['order_array']['buyer_refund_message']; ?>
								</td>
							</tr>						
						<?php } ?>	
						<tr>
							<td class="cr-1"><?php echo $lang['langRefundState']; ?>:</td>
							<td class="cr-2">
								<?php echo $output['order_array']['refund_state_text']; ?>
							</td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langRefundAmount']; ?>:</td>
							<td class="cr-2">
								<?php echo $output['order_array']['total_price']; ?>
							</td>
						</tr>																																																																																									
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input type="button" class='submit' name="" value="<?php echo $lang['langCReturn']; ?>" onclick="javascript:history.go(-1);" />
						</span>							
					</div>		
					</form>			
				</div>
			</div>
		</div>
	</div>
</div>