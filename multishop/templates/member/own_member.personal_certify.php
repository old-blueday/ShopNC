<script language="javascript">
/* 验证表单 */$(function(){
	$("#shopEntity").validate({
		event: "keyup",
		errorClass: "wrong",
		rules: {
			identity_card_copy_up   : {required:true},
			identity_card_copy_back : {required:true}
		},
		messages: {
			identity_card_copy_up   : {required: "<?php echo $lang['errMPersonalCertifyCardUpIsEmpty']; ?>"},
			identity_card_copy_back : {required: "<?php echo $lang['errMPersonalCertifyCardBackIsEmpty']; ?>"}
		}
	});
});
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langMPersonalCertifyRemark'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langMPersonalCertify'];?></p></span></li>
					</ul>
				</div>
				<form action="own_member.php?action=personal_certify_save" method="post" name="" id="shopEntity" enctype="multipart/form-data">
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-2" colspan="2">
								<?php
									if ( $output['personal_certify'] == '0' ) {
										echo $lang['langMPersonalCertifyState'].":".$lang['langMPersonalCertifyStateZero'];
									}
									if ( $output['personal_certify'] == '3' ) {
										echo $lang['langMPersonalCertifyState'].":".$lang['langMPersonalCertifyStateThree'];
									}
								?>
							</td>
						</tr>
						<?php if ( $output['personal_certify'] == '3' ) { ?>
							<tr>
								<td class="cr-1"><?php echo $lang['langMPersonalCertifyDenyReason']; ?>:</td>
								<td class="cr-2"><?php echo $output['personal_certify_deny_reason']; ?></td>
							</tr>
							<tr>
								<td class="cr-1"><?php echo $lang['langMPersonalCertifyViewLast']; ?>:</td>
								<td class="cr-2">
									<a href="../<?php echo $output['member_array']['personal_certify_identitycard_up']; ?>"><?php echo $lang['langMPersonalCertifyCardUp']; ?></a>
									<a href="../<?php echo $output['member_array']['personal_certify_identitycard_back']; ?>"><?php echo $lang['langMPersonalCertifyCardBack']; ?></a>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langMPersonalCertifyCardUp']; ?>:</td>
							<td class="cr-2">
								<span><input name="identity_card_copy_up" id="identity_card_copy_up" type="file" /></span>
								<span class="cr-4-span"><?php echo $lang['langMPersonalCertifyAllowType'].":".$output['allowuploadimagetype']; ?></span>
								<label style="display:none" for="identity_card_copy_up" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMPersonalCertifyCardBack']; ?>:</td>
							<td class="cr-2">
								<span><input name="identity_card_copy_back" id="identity_card_copy_back" type="file" /></span>
								<span class="cr-4-span"><?php echo $lang['langMPersonalCertifyAllowType'].":".$output['allowuploadimagetype']; ?></span>
								<label style="display:none" for="identity_card_copy_back" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>
					</table>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input type="submit" class='submit' name="" value="<?php echo $lang['langMPersonalCertifySubmit']; ?>" />
					</span>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>