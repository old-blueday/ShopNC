<script src="<?php echo SITE_URL; ?>/js/addselect.js"></script>
<script language='javascript'>
// JavaScript Document
$(function(){
	$('#receive').find('a.mobi').click(function(){
		receives=$(this).parent().parent().find('span').map(function(){return $(this).html();}).get().join("|||");
		receivearry=receives.split('|||');
		for(i=0;i<receivearry.length;i++){
			receivearry[i] = ltrim(receivearry[i]);
		}
		$('#txtReceiveName').val(receivearry[0]);
		$('#adddiv').empty();
		$('#adddiv').addSelect({
					ajaxUrl:'../home/tohtml.php',
					ajaxAction:'get_area',
					type:'modi',
					modi_id:receivearry[10],
					hiddenId:'area_id'
				});
		$('#txtAddress').val(receivearry[5]);
		$('#txtZip').val(receivearry[6]);
		$('#txtPhone').val(receivearry[7]);
		$('#txtMobilephone').val(receivearry[8]);
		$('#receive_id').val(receivearry[9]);
		$('#area_id').val(receivearry[10]);
		$('#formTitie').html('<?php echo $lang['langRAmendAddress']; ?>');
		$('#form_receive').attr('action','own_receive.php?action=modisave');
		$('#che').val('<?php echo $lang['langRSave']; ?>');
		$('#add').css('display','inline');
		
	});
	
	$("#form_receive").validate({
		errorClass: "error",								
		rules: {
			txtReceiveName: {required:true},
			area_id: {required:true},
			txtAddress: {required:true},
			txtZip: {required:true,number: true},
			txtPhone: {number: true},
			txtMobilephone: {number: true},
			txtPhoneOrtxtMobilephone:{required:txtPhoneOrtxtMobilephone}
		},
		messages: {
			txtReceiveName: {required: "<?php echo $lang['langRConsigneeNameNotNull']; ?>"},
			area_id: {required: "<?php echo $lang['langRLocalityNotNull']; ?>"},
			txtAddress: {required: "<?php echo $lang['langRParticularAddressNotNull']; ?>"},
			txtZip: {required: "<?php echo $lang['langRPostalcodeNotNull']; ?>",number: "<?php echo $lang['langRPostalcodeIsNumber']; ?>"},
			txtPhone: {number: "<?php echo $lang['langRPhoneIsNumber']; ?>"},
			txtMobilephone: {number: "<?php echo $lang['langRMobileTelephoneIsNumber']; ?>"},
			txtPhoneOrtxtMobilephone:{required:'<?php echo $lang['langRPhoneOrMobilephoneNotNull']; ?>'}
		}
	});
	//选择所在地
	$('#adddiv').addSelect({
					ajaxUrl:'../home/tohtml.php',
					ajaxAction:'get_area',
					hiddenId:'area_id'
				});
	
});
function txtPhoneOrtxtMobilephone()
	{
		$("#txtPhoneOrtxtMobilephone").val($("#txtPhone").val()+$("#txtMobilephone").val());
		return	true;
	}
function ltrim(str) 
{ 
	return str.replace(/(^\s*)|(\s*$)/g, ""); 
}
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langRAddress']; ?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<h3><?php echo $lang['langRceiveSave']; ?></h3>
					<h2><?php echo $lang['langRMostSave5AvailabilityAddress']; ?></h2>
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" id="receive">
						<tr class="tr-un-bg-2">
							<td class="td-bg-5 p-left-rio"><?php echo $lang['langRConsignee']; ?></td>
							<td class="td-bg-8"><?php echo $lang['langRLocality']; ?></td>
							<td class="td-bg-10"><?php echo $lang['langRParticularAddress']; ?></td>
							<td class="td-bg-4"><?php echo $lang['langRPostalcode']; ?></td>
							<td class="td-bg-6"><?php echo $lang['langRPhoneOrMobileTelephone']; ?></td>
							<td class="td-bg-7"><?php echo $lang['langCOperation']; ?></td>
						</tr>
						<?php if ( !empty( $output['receive_array'] ) && is_array( $output['receive_array'] ) ) { ?>
							<?php foreach ( $output['receive_array'] as $receive ) { ?>
							<tr class="tr-un-conter-22">
								<td class="p-left-rio"><span><?php echo $receive['receive_name']; ?></span></td>
								<td>
									<span><?php echo $receive['area'][0]['area_name']; ?></span>
									<span><?php echo $receive['area'][1]['area_name']; ?></span>
									<span><?php echo $receive['area'][2]['area_name']; ?></span>
									<span><?php echo $receive['area'][3]['area_name']; ?></span>
								</td>
								<td>
									<span><?php echo $receive['address']; ?></span>
								</td>
								<td>
									<span><?php echo $receive['zip']; ?></span>
								</td>
								<td>
									<span><?php echo $receive['phone']; ?></span><br/><span><?php echo $receive['mobilephone']; ?></span>
								</td>
								<td>
									<span style="display:none"><?php echo $receive['receive_id']; ?></span>
									<span style="display:none"><?php echo $receive['receive_area_id']; ?></span>								
									<a href="javascript:;" class="mobi"><?php echo $lang['langCmodi']; ?></a> | <a href="javascript:;" onclick="if(confirm('<?php echo $lang['langRConfirmDel']; ?>')){window.location='own_receive.php?action=del&receiveid=<?php echo $receive['receive_id']; ?>';}else{return false;}"><?php echo $lang['langCdele']; ?></a>
								</td>
							</tr>
							<?php } ?>
						<?php } else {?>
							<tr class="tr-not">
								<td colspan="6">
									<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
				<!--<div class="consie">
					<h3><?php echo $lang['langRceiveSave']; ?></h3>
					<table class="consie-table" border="0" cellpadding="0" id="receive">
						<tr class="consie-tr-1">
							<td class="consie-td-1 consie-se"><?php echo $lang['langRConsignee']; ?></td>
							<td class="consie-td-2 consie-se"><?php echo $lang['langRLocality']; ?></td>
							<td class="consie-td-3 consie-se"><?php echo $lang['langRParticularAddress']; ?></td>
							<td class="consie-td-4 consie-se"><?php echo $lang['langRPostalcode']; ?></td>
							<td class="consie-td-5 consie-se"><?php echo $lang['langRPhoneOrMobileTelephone']; ?></td>
							<td class="consie-td-6 consie-se"><?php echo $lang['langCOperation']; ?></td>
						</tr>
						<?php foreach ( $output['receive_array'] as $receive ) { ?>
						<tr>
							<td class="consie-td-1"><span><?php echo $receive['receive_name']; ?></span></td>							
							<td class="consie-td-2">
								<span><?php echo $receive['area'][0]['area_name']; ?></span>
								<span><?php echo $receive['area'][1]['area_name']; ?></span>
								<span><?php echo $receive['area'][2]['area_name']; ?></span>
								<span><?php echo $receive['area'][3]['area_name']; ?></span>
							</td>
							<td class="consie-td-3"><span><?php echo $receive['address']; ?></span></td>
							<td class="consie-td-4"><span><?php echo $receive['zip']; ?></span></td>
							<td class="consie-td-5"><span><?php echo $receive['phone']; ?></span><br/><span><?php echo $receive['mobilephone']; ?></span></td>
							<td class="consie-td-6">
								<span style="display:none"><?php echo $receive['receive_id']; ?></span>
								<span style="display:none"><?php echo $receive['receive_area_id']; ?></span>								
								<a href="javascript:;" class="mobi"><?php echo $lang['langCmodi']; ?></a> | <a href="javascript:;" onclick="if(confirm('<?php echo $lang['langRConfirmDel']; ?>')){window.location='own_receive.php?action=del&receiveid=<?php echo $receive['receive_id']; ?>';}else{return false;}"><?php echo $lang['langCdele']; ?></a>
							</td>
						</tr>
						<?php } ?>
					</table>
					<h2><?php echo $lang['langRMostSave5AvailabilityAddress']; ?></h2>
				</div>-->
				<div class="cr-right">
					<h3 id="formTitie"><?php echo $lang['langRAddAddress']; ?></h3>
					<form action="own_receive.php?action=addsave" method="post" name="form_receive" id="form_receive">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langRConsigneeName']; ?>:</td>
							<td class="cr-2">
								<span><input class="in" name="txtReceiveName" id="txtReceiveName" maxlength="16" type="text" /></span><span class="cr-5-span" style="color:#F00;">*</span>
								<label style="display:none" for="txtReceiveName" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langRLocalityZone']; ?>:</td>
							<td class="cr-2">
								<span>
								<div id="adddiv"></div>
								</span>
								<span class="cr-5-span" style="color:#F00;">*</span>
								<input type="hidden" name="area_id" id="area_id" />
								<label style="display:none" for="area_id" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langRParticularAddress']; ?>:</td>
							<td class="cr-2"><span><input class="in" name="txtAddress" id="txtAddress" maxlength="80" type="text" /></span><span class="cr-5-span" style="color:#F00;">*</span><span class="cr-5-span"><?php echo $lang['langRNotNeedFillInProvinceTownZone']; ?></span><label style="display:none" for="txtAddress" class="error" metaDone="true" generated="true"></label></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langReceivePostalcode']; ?>:</td>
							<td class="cr-2">
								<span><input class="in" name="txtZip" id="txtZip" maxlength="8" type="text" />
								</span><span class="cr-5-span" style="color:#F00;">*</span>
								<label style="display:none" for="txtZip" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>							
						<tr>
							<td class="cr-1"><?php echo $lang['langRPhone']; ?>:</td>
							<td class="cr-2"><input class="in" name="txtPhone" id="txtPhone" maxlength="25" type="text" />
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langRMobileTelephone']; ?>:</td>
							<td class="cr-2"><input class="in" name="txtMobilephone" id="txtMobilephone" maxlength="12" type="text" /><input type="hidden" id="txtPhoneOrtxtMobilephone" name="txtPhoneOrtxtMobilephone" /></td>
						</tr>
					
					</table>
				
				<div class="an-1">
					<span class="buttom-comm"><input name="che" id="che" value="<?php echo $lang['langCsubmit']; ?>" type="submit" /></span>
					<a href="own_receive.php" id="add" style="display:none;"><span class="buttom-comm"><input name="" value="<?php echo $lang['langRAddAddress']; ?>" type="submit" /></span></a>
					<input name="receive_id" type="hidden" id="receive_id" />						
				</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>