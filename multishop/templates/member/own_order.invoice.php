<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langOInvoiceExplain']; ?></p>
				</div>
				<div class="clear-9"></div>			
				<div class="nav">
					<ul>			
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langOrderSellerShipment'];?></p></span></li>
					</ul>
				</div>
				<form name="form1" action="own_order.php?action=invoice_save" method="post">
				<input type="hidden" name="sp_code" id="sp_code" value="<?php echo $output['order_array']['sp_code']; ?>" />
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langOrderCode']; ?>:</td>
							<td class="cr-2"><?php echo $output['order_array']['sp_code']?>&nbsp;&nbsp;[<a href="<?php echo SITE_URL; ?>/member/own_order.php?action=show&sp_code=<?php echo $output['order_array']['sp_code']?>"><?php echo $lang['langOrderInfo']; ?></a>]</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langProName']; ?>:</td>
							<td class="cr-2"><?php echo $output['order_array']['p_name']?></td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langOrderPrice']; ?>:</td>
							<td class="cr-2"><?php echo $output['order_array']['unit_price']?></td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langOrderInvoiceContent']; ?>:</td>
							<td class="cr-2">
								<textarea name="invoice_info" cols="40" rows="7"></textarea>	
            				</td>
						</tr>																		
					</table>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input type="submit" class='submit' name="" value="<?php echo $lang['langOrderSubmit']; ?>" onclick="history.back()" />
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