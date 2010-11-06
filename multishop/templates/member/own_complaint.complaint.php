<script>
/* 验证表单 */$(function(){
	$("#form_complaint").validate({
		event: "keyup",
		errorClass: "error",
		rules: {
			evidence: {required:true,maxlength:500,minlength:10}
			<?php if ( $output['type'] == 2 ) { ?>,
			pic: {required:true}
			<?php } ?>
		},
		messages: {
			evidence: {required: "<?php echo $lang['errComplaintEvidenceNotNull']; ?>",maxlength:"<?php echo $lang['errComplaintEvidence']; ?>",minlength:"<?php echo $lang['errComplaintEvidence']; ?>"}	
			<?php if ( $output['type'] == 2 ) { ?>,
			pic: {required: "<?php echo $lang['errComplaintPicNotNull']; ?>"}	
			<?php } ?>		
		}
	});
});

function keyNumber()
{
	if($("#evidence").val().length<10)
	{
		$("#keynum").html("<?php echo $lang['langPShort']; ?>"+(10-$("#evidence").val().length)+"<?php echo $lang['langPWord']; ?>");
		$("#keynum").css('color','#FF0000');
	}else if($("#evidence").val().length<=500&&$("#evidence").val().length>=10)
	{
		$("#keynum").html("<?php echo $lang['langPResidual']; ?>"+(500-$("#evidence").val().length)+"<?php echo $lang['langPWord']; ?>");
		$("#keynum").css('color','#009900');
	}else{
		$("#keynum").html("<?php echo $lang['langPBeyond']; ?>"+($("#evidence").val().length-500)+"<?php echo $lang['langPWord']; ?>");
		$("#keynum").css('color','#FF0000');
	}
}










</script>

<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span>
							<p><a href="own_complaint.php" ><?php echo $lang['langCompComplaintsLaw']; ?></a></p>
							</span></li>
						<li class="nav-bg nav-left"><b></b><span>
							<p><?php echo $lang['langCompComp']; ?></p>
							</span></li>
						<li class="nav-bg-1 nav-left"><b></b><span>
							<p><a href="own_complaint.php?type=report&send_receive=receive&state=all"><?php echo $lang['langCompLaw']; ?></a></p>
							</span></li>
					</ul>
				</div>
				<div class="clear"></div>
				<div class="io-3-book">
					<p><strong><?php echo $lang['langCompReflectCircs']; ?></strong></p>
				</div>
				<div class="clear"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="info-1">
					<?php if ( $output['step'] == 'one' ) { ?>
					<span><b>1.<?php echo $lang['langCompSelectCompType']; ?></b>&nbsp;&nbsp;2.<?php echo $lang['langCompMakeCompContent']; ?> &nbsp;&nbsp;3.<?php echo $lang['langCompCompComplete']; ?></span>
					<div class="jubaoInfo">
						<ul style="height:44px;">
							<li><?php echo $lang['langCompOneCompType']; ?></li>
							<li><?php echo $lang['langCompTwoCompInfo']; ?></li>
						</ul>
					</div>
					<?php } else if ( $output['step'] == 'two' ) { ?>
					<span>1.<?php echo $lang['langCompSelectCompType']; ?><b>&nbsp;&nbsp;2.<?php echo $lang['langCompMakeCompContent']; ?></b>&nbsp;&nbsp;3.<?php echo $lang['langCompCompComplete']; ?></span>
					<div class="jubaoInfo">
						<ul style="height:44px;">
							<li><?php echo $lang['langCompOneCompRealityInfo']; ?></li>
							<li>2.<span style="color:#FF0000">*</span><?php echo $lang['langCompMustMake']; ?></li>
						</ul>
					</div>
					<?php } else if ( $output['step'] == 'three' ) { ?>
					<span>1.<?php echo $lang['langCompSelectCompType']; ?>&nbsp;&nbsp;2.<?php echo $lang['langCompMakeCompContent']; ?> <b>&nbsp;&nbsp;3.<?php echo $lang['langCompCompComplete']; ?></b></span>
					<?php } ?>
				</div>
				<div class="cr-right">
					<?php if ( $output['step'] == 'one' ) { ?>
					<div id="reportInfo" >
						<h2><span><?php echo $lang['langCompSelectCompMotif']; ?></span></h2>
						<ul>
							<?php if ( $output['complaint_case'] == 'sell' ) { ?>
							<?php if ( $output['sold_row']['sp_state'] == '1' ) { ?>
							<li>
								<div class="report_content">
									<dl>
										<dt><?php echo $lang['langComplaintNoShipment']; ?></dt>
										<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintNoShipmentInfo']; ?></dd>
									</dl>
								</div>
								<div class="report_button"><a href="own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=two&type=1&spid=<?php echo $output['spid']; ?>"></a></div>
							</li>
							<?php } else if ( $output['sold_row']['sp_state'] == '3' ) { ?>
							<li>
								<div class="report_content">
									<dl>
										<dt><?php echo $lang['langComplaintMalicious']; ?></dt>
										<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintMaliciousInfo']; ?></dd>
									</dl>
								</div>
								<div class="report_button"><a href="own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=two&type=3&spid=<?php echo $output['spid']; ?>"></a></div>
							</li>
							<?php } ?>
							<?php } ?>
							<?php if ( $output['complaint_case'] == 'buy' ) { ?>
							<?php if ( $output['sold_row']['sp_state'] == '0' ) { ?>
							<li>
								<div class="report_content">
									<dl>
										<dt><?php echo $lang['langComplaintNoBuy']; ?></dt>
										<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintNoBuyInfo']; ?></dd>
									</dl>
								</div>
								<div class="report_button"><a href="own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=two&type=2&spid=<?php echo $output['spid']; ?>"></a></div>
							</li>
							<?php } else if ( $output['sold_row']['sp_state'] == '2' ) { ?>
							<li>
								<div class="report_content">
									<dl>
										<dt><?php echo $lang['langComplaintNoPay']; ?></dt>
										<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintNoPayInfo']; ?></dd>
									</dl>
								</div>
								<div class="report_button"><a href="own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=two&type=4&spid=<?php echo $output['spid']; ?>"></a></div>
							</li>
							<?php } else if ( $output['sold_row']['sp_state'] == '3' ) { ?>
							<li>
								<div class="report_content">
									<dl>
										<dt><?php echo $lang['langComplaintMalicious']; ?></dt>
										<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintMaliciousInfo']; ?></dd>
									</dl>
								</div>
								<div class="report_button"><a href="own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=two&type=3&spid=<?php echo $output['spid']; ?>"></a></div>
							</li>
							<?php } ?>
							<?php } ?>
						</ul>
					</div>
					<?php } ?>
					<?php if ( $output['step'] == 'two' ) { ?>
					<form name="form_complaint" id="form_complaint" action="own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=three" method="post" enctype="multipart/form-data">
						<input type="hidden" name="type" value="<?php echo $output['type']; ?>" />
						<input type="hidden" name="spid" value="<?php echo $output['spid']; ?>" />
						<table cellpadding="0" border="0" width="100%">
							<tr>
								<td class="reporttitle"><span><?php echo $lang['langCompSelectCompMotif']; ?></span></td>
							</tr>
							<tr>
								<td>
									<table cellpadding="0" class="cr-r-td" border="0" width="100%">
										<tr>
											<td class="cr-1"><?php echo $lang['langCompByComplaints']; ?>:</td>
											<td class="cr-2">
												<?php if ( $output['complaint_case'] == 'buy' && $output['complaint_member']['anonymous'] == '1' ) { ?>
												<?php echo $lang['langCompAnonymityBuy']; ?>
												<?php } else { ?>
												<a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['complaint_member']['member_id']; ?>" target="_blank"><?php echo $output['complaint_member']['login_name']; ?></a>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td class="cr-1"><?php echo $lang['langCompCorrelationBargaining']; ?>:</td>
											<td class="cr-2"> <a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $output['sold_row']['p_code']; ?>" target="_blank"><?php echo $output['sold_row']['p_name']; ?></a> </td>
										</tr>
										<tr>
											<td class="cr-1"><?php echo $lang['langCompCompType']; ?>:</td>
											<td class="cr-2"> <strong style="line-height:25px;"><?php echo $output['complaint_report_type']; ?></strong><br/>
												<span style="color:#999;">(<?php echo $lang['langCompTypeErr']; ?> <a href="<?php echo SITE_URL; ?>/member/own_complaint.php?action=complaint_<?php echo $output['complaint_case']; ?>&step=one&spid=<?php echo $output['spid']; ?>" class="anniu"> <?php echo $lang['langCReturnUp']; ?> </a> <?php echo $lang['langCompSelectOtherType']; ?>)</a></span></td>
										</tr>
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00; padding:20px 5px;">*</span><?php echo $lang['langCompProof']; ?>:</td>
											<td class="cr-2">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" >
													<tr>
														<td style="border:none;">
															<textarea style=" width:580px;height:170px; float:left"  onkeyup="keyNumber()"  id="evidence" name="evidence" rows="5" cols="40"></textarea>
															<br />
														</td>
														
													</tr>
													<tr>
															<td style="border:none;"><span style="color:#999;"><?php echo $lang['langCompCompReason']; ?></span><span id="keynum" style="float:left;"></span></td>
													</tr>
													
												</table>
											</td>
										</tr>
										<?php if ( $output['type'] == '2' ) { ?>
										<tr>
											<td class="cr-1"><span class="cr-5-span" >*</span><?php echo $lang['langCompUpdataImage']; ?></td>
											<td class="cr-2">
												<input name="pic" style="float:left" type="file" />
												<?php echo $lang['langCompUpdataBarbarismImage']; ?> </td>
										</tr>
										<?php } ?>
									</table>
								</td>
							</tr>
						</table>
						<div class="an-1"> <span class="buttom-comm">
							<input name="che" id="che" value="<?php echo $lang['langCsubmit']; ?>" type="submit" />
							</span> <span class="buttom-comm">
							<input name="" value="<?php echo $lang['langCAfreshFillIn']; ?>" type="reset" />
							</span> </div>
					</form>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
