<script language='javascript'>
$(function(){
	$("#messageForm").validate({
		errorClass: "wrong",
		rules: {
			txtReMessage: {required:true}
		},
		messages: {
			txtReMessage: {required: "<?php echo $lang['langShopMFillInRestoreContent']; ?>"}
		}
	});
})
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langShopMManageExplain']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopMessageRe']; ?></p></span></li>
					</ul>
				</div>						
				<div class="cr-right">
    				<form name="messageForm" id="messageForm" action="own_shopmessage.php?action=resave" method="post">
					<input name="hideMessageID" type="hidden" id="hideMessageID" value="<?php echo $output['shop_message_array'][0]['message_id']; ?>" />			
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopMContentRe']; ?>:</td>
							<td class="cr-2">
								<textarea name="txtReMessage" cols="60" rows="5" id="txtReMessage"><?php echo $output['shop_message_array'][0]['message_recontent']; ?></textarea>
								<label style="display:none" for="txtReMessage" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>						
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
						</span>
						<span class="buttom-comm">
							<input id="Submit" type="button" class='submit' name="" value="<?php echo $lang['langCReturn']; ?>" onclick="window.location.href='own_shopmessage.php'" />
						</span>
					</div>		
					</form>			
				</div>
			</div>
		</div>
	</div>
</div>