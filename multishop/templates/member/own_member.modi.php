<link href="<?php echo SITE_URL; ?>/js/jquery/ui.theme.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/jquery/ui.datepicker.js"></script>
<script src="<?php echo SITE_URL; ?>/js/addselect.js"></script>
<script type="text/javascript" language="javascript">
// JavaScript Document
$(function(){
	$("#form_modi").validate({
		event: "keyup",
		errorClass: "error",
		rules: {
			rdoGender: {required:true},
			area_id: {required:true},
			txtAddress: {required:true},
			txtZip: {number: true, minlength:6,maxlength:6},
			txtMobilephone: {number: true,min:10000000000,max:19999999999}
		},
		messages: {
			rdoGender: {required: "<?php echo $lang['errMSelectSex']; ?>"},
			area_id: {required:"<?php echo $lang['errMAreaIsEmpty']; ?>"},
			txtAddress: {required: "<?php echo $lang['errMAddressNotNull']; ?>"},
			txtZip: {number: "<?php echo $lang['errMPostIsNum']; ?>",minlength:"<?php echo $lang['errMPostFormat']; ?>",maxlength:"<?php echo $lang['errMPostFormat']; ?>"},
			txtMobilephone: {number: "<?php echo $lang['errMMobileTelephoneIsNum']; ?>",min:"<?php echo $lang['errMMobileTelephoneFormat']; ?>",max:"<?php echo $lang['errMMobileTelephoneFormat']; ?>"}
		}
	});
	$('#txtBirthday').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'<?php echo date("Y",time()) - 100; ?>:<?php echo date("Y",time()); ?>'		
	});
	$('#adddiv').addSelect({
					ajaxUrl:'../home/tohtml.php',
					ajaxAction:'get_area',
					type:'modi',
					modi_id:'<?php echo $output['member_array']['area_id'];?>',
					hiddenId:'area_id'
				});
})

</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langNEditOwnInfo'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langNEditOwnInfo']; ?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=email"><?php echo $lang['langNEditOwnEmail']; ?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=password"><?php echo $lang['langNEditOwnPassword']; ?></a></p></span></li>
						<?php if (DISCUZ_X === true) { ?><li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=feed"><?php echo $lang['langHeadMemberFeed']; ?></a></p></span></li><?php } ?>
					</ul>
				</div>
				<form action="own_member.php?action=modifysave" method="post" name="form_modi" id="form_modi" enctype="multipart/form-data">
				<div class="cr-right">
					<input type="hidden" name="area_id" id="area_id" value="<?php echo $output['member_array']['area_id']; ?>" />
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langMloginname']; ?>:</td>
							<td class="cr-2"><strong><?php echo $output['member_array']['login_name']; ?></strong></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langNEditPicture']; ?>:</td>
							<td class="cr-2">
								<?php if ( $output['member_array']['picture'] != '' ) { ?>
									<img src="<?php echo SITE_URL; ?>/<?php echo $output['member_array']['picture']; ?>" width="80" height="80" />
									<a href="javascript:;" onclick="if (confirm('<?php echo $lang['langNEditPictureDel']; ?>')) {window.location.href='own_member.php?action=delpicture'}"><?php echo $lang['langCdele']; ?></a>
								<?php } else {?>
									<img src="<?php echo TPL_DIR; ?>/images/avatar.gif" /><br/><br/>
									<span><input type="file" name="memberPhoto" id="memberPhoto" /></span>
									<span class="cr-5-span"><?php echo $lang['langNEditPictureExplaina']; ?><?php echo $output['allowuploadmaxsize']; ?><?php echo $lang['langNEditPictureExplainb']; ?><?php echo $output['allowuploadimagetype']; ?><?php echo $lang['langNEditPictureExplainc']; ?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMtruename']; ?>:</td>
							<td class="cr-2">
								<?php if ( $output['member_array']['true_name'] != '' ) { ?>
									<?php echo $output['member_array']['true_name']; ?>
									<span><input type="hidden" name="txtTruename" id="txtTruename" value="<?php echo $output['member_array']['true_name']; ?>" /></span>
								<?php } else { ?>
									<span><input class="in" name="txtTruename" id="txtTruename" type="text" /></span><span class="cr-5-span"><?php echo $lang['langMNameNotAmend']; ?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMbirthday']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtBirthday" id="txtBirthday" readonly="true" type="text" value="<?php echo $output['member_array']['birthday']; ?>" />
								<label style="display:none;" for="f_date" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMgender']; ?>:</td>
							<td class="cr-2">
								<?php echo $output['gender']; ?>
								<label style="display:none" for="rdoGender" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMemail']; ?>:</td>
							<td class="cr-2"><?php echo $output['member_array']['email']; ?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMzip']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtZip" id="txtZip" type="text" value="<?php echo $output['member_array']['zip']; ?>" />
								<label style="display:none" for="txtZip" class="error" metaDone="true" generated="true">
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMmobilephone']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtMobilephone" id="txtMobilephone" type="text" value="<?php echo $output['member_array']['mobilephone']; ?>" />
								<label style="display:none" for="txtMobilephone" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMphone']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtPhone" id="txtPhone" type="text" value="<?php echo $output['member_array']['phone']; ?>" />
								<label style="display:none" for="txtPhone" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMotherphone']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtOtherphone" id="txtOtherphone" type="text" value="<?php echo $output['member_array']['otherphone']; ?>" />
								<label style="display:none" for="txtOtherphone" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMaddress']; ?>:</td>
							<td class="cr-2">
								<div id="adddiv"></div>
								<label style="display:none" for="area_id" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langParticularMaddress']; ?>:</td>
							<td class="cr-2">
								<span>
									<input class="in-2" name="txtAddress" id="txtAddress" type="text" value="<?php echo $output['member_array']['address']; ?>" />

								</span>
								<span class="cr-5-span"><?php echo $lang['errMAvailabilityInfo']; ?></span>
								<label style="display:none" for="txtAddress" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1">QQ:</td>
							<td class="cr-2">
								<span><input class="in-2" name="txtQQ" id="txtQQ" type="text" value="<?php echo $output['member_array']['QQ']; ?>" /></span>
								<span class="cr-5-span"><?php echo $lang['langContactExplain']; ?></span>
								<label style="display:none" for="txtQQ" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1">MSN:</td>
							<td class="cr-2">
								<span><input class="in-2" name="txtMSN" id="txtMSN" type="text" value="<?php echo $output['member_array']['MSN']; ?>" /></span>
								<span class="cr-5-span"><?php echo $lang['langContactExplain']; ?></span>
								<label style="display:none" for="txtMSN" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1">SKYPE:</td>
							<td class="cr-2">
								<span><input class="in-2" name="txtSKYPE" id="txtSKYPE" type="text" value="<?php echo $output['member_array']['SKYPE']; ?>" /></span>
								<span class="cr-5-span"><?php echo $lang['langContactExplain']; ?></span>
								<label style="display:none" for="txtSKYPE" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1">TAOBAO:</td>
							<td class="cr-2">
								<span><input class="in-2" name="txtTAOBAO" id="txtTAOBAO" type="text" value="<?php echo $output['member_array']['TAOBAO']; ?>" /></span>
								<span class="cr-5-span"><?php echo $lang['langContactExplain']; ?></span>
								<label style="display:none" for="txtTAOBAO" class="error" metaDone="true" generated="true"></label>
							</td>
							</tr>
					</table>
				</div>
				<div class="an-1 bg-an"><span class="buttom-comm"><input  name="" value="<?php echo $lang['langCsave']; ?>" type="submit" /></span></div>
				</form>
			</div>
		</div>
	</div>
</div>