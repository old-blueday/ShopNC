<script language='javascript'>
$(function(){
	$("#messageForm").validate({
		errorClass: "wrong",
		rules: {
			txtMessage: {required:true}
		},
		messages: {
			txtMessage: {required: "<?php echo $lang['langShopMFillInMessageContent']; ?>"}
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
						<li class="nav-bg-1"><b></b><span><p><a href="own_shopmessage.php"><?php echo $lang['langShopMManage']; ?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langShopMAppearManage']; ?></p></span></li>
					</ul>
				</div>						
				<div class="cr-right">
    				<form name="messageForm" id="messageForm" action="own_shopmessage.php?action=addsave" method="post">			
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopMContentAdd']; ?>:</td>
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
					</div>		
					</form>			
				</div>
			</div>
		</div>
	</div>
</div>