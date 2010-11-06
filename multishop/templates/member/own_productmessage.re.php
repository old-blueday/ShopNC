<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langProductAnswerMsg'];?></p></span></li>
					</ul>
				</div>
				
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
					<form action="own_productmessage.php?action=resave" method="POST" id="messageform">
						<tr>
							<td class="cr-1">
							<?php echo $lang['langProductMBuyName'];?>:	
							</td>
							<td class="cr-2">
							<?php if($output['message_array']['anonymous'] == '1'){ ?>
										<?php echo $lang['langProductMAnonymity']; ?>
									<?php }else{ ?>
										<?php echo $output['message_array']['member_name']; ?>
									<?php } ?>
							</td>
							<tr>
							<td class="cr-1"><?php echo $lang['langProductMContent']; ?>:</td>
							<td class="cr-2"><?php echo $output['message_array']['message_content']; ?></td>
							</tr>
							<tr>
							<td class="cr-1"><?php echo $lang['langProductAnswerMsgContent']; ?>:</td>
							<td class="cr-2">
								<textarea name="txtReMessage" cols="60" rows="10"></textarea>
								<input type="hidden" name="hideproductID" value="<?php echo $output['message_array']['product_id']; ?>">
									<input type="hidden" name="hideMessageID" value="<?php echo $output['message_array']['message_id']; ?>">
							</td>
							</tr>
					</table>
					<div class="an-1">
						<span class="buttom-comm"><input type="submit" name="submit" class="new_anniu" value="<?php echo $lang['langProductAnswerMsg']; ?>" /></span>
						<span class="buttom-comm">
							<input type="button" class="new_anniu" value="<?php echo $lang['langCReturn']; ?>" onclick="window.location.href='own_productmessage.php?action=sale'" />
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>