<script language="javascript">
/* 验证表单 */
$(function(){
	$("#shopEntity").validate({
		event: "keyup",
		errorClass: "wrong",
		rules: {
			identity_card_copy_up   : {required:true},
			identity_card_copy_back : {required:true},
			license_copy            : {required:true}
		},
		messages: {
			identity_card_copy_up   : {required: "<?php echo $lang['langShopUpIDCardObverseScan']?>"},
			identity_card_copy_back : {required: "<?php echo $lang['langShopUpIDCardBackScan']?>"},
			license_copy            : {required: "<?php echo $lang['langShopUpLicence']?>"}
		}
	});
});
</script> 
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langShopEntityCheckRemark'];?></p>
				</div>
				<div class="clear-9"></div>			
				<div class="nav">
					<ul>			
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopEntityCheck'];?></p></span></li>
					</ul>
				</div>
				<form action="own_shop.php?action=save_shopentity" method="post" name="" id="shopEntity" enctype="multipart/form-data">
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-2" colspan="2">
								<?php
									if ( $output['isRefuse'] == 'yes' ) {
										echo "<font color='red'>".$lang['langShopAdminRefuse']."</font>";
									}								
								?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopUpIDCardObverse']; ?>:</td>
							<td class="cr-2">
								<span><input name="identity_card_copy_up" id="identity_card_copy_up" type="file" /></span>
								<label style="display:none" for="identity_card_copy_up" class="wrong" metaDone="true" generated="true"></label>							
							</td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langShopUpIDCardBack']; ?>:</td>
							<td class="cr-2">
								<span><input name="identity_card_copy_back" id="identity_card_copy_back" type="file" /></span>
								<label style="display:none" for="identity_card_copy_back" class="wrong" metaDone="true" generated="true"></label>							
							</td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langShopUpLicenceBack']; ?>:</td>
							<td class="cr-2">
								<span><input name="license_copy" id="license_copy" type="file" /></span>
								<label style="display:none" for="license_copy" class="wrong" metaDone="true" generated="true"></label>							
							</td>
						</tr>																																		
					</table>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input type="submit" class='submit' name="" value="<?php echo $lang['langCsave']; ?>" />
					</span>			
				</div>				
				</form>
			</div>
		</div>
	</div>
</div>