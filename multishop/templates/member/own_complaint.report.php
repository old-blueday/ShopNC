<script>
/* 验证表单 */$(function(){
	$("#form_report").validate({
		event: "keyup",
		errorClass: "error",
		rules: {
			c_r_login_name: {required:true}
			<?php if ( $output['type'] == '6' || $output['type'] == '7' ) { ?>
			,
			p_code: {required:true}
			<?php 
			}
			if ( $output['type'] == '7' || $output['type'] == '8' ) {
			?>
			,
			pic: {required:true}
			<?php
			}
			if ( $output['type'] != '12' ) {
			?>
			,
			evidence: {required:true,maxlength:500,minlength:10}
			<?php } else { ?>
			,
			related_product: {required:true}
			<?php } ?>
		},
		messages: {
			c_r_login_name: {required: "<?php echo $lang['errComplaintNameNotNull']; ?>"}
			<?php if ( $output['type'] == '6' || $output['type'] == '7' ) { ?>
			,
			p_code: {required: "<?php echo $lang['errComplaintProductCodeNotNull']; ?>"}
			<?php 
			}
			if ( $output['type'] == '7' || $output['type'] == '8' ) {
			?>
			,
			pic: {required: "<?php echo $lang['errComplaintPicNotNull']; ?>"}
			<?php
			}
			if ( $output['type'] != '12' ) {
			?>
			,
			evidence: {required: "<?php echo $lang['errComplaintEvidenceNotNull']; ?>",maxlength:"<?php echo $lang['errComplaintEvidence']; ?>",minlength:"<?php echo $lang['errComplaintEvidence']; ?>"}
			<?php } else { ?>
			,
			related_product: {required:"<?php echo $lang['errComplaintRepeatProductCodeNotNull']; ?>"}
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
						<li class="nav-bg-1 nav-left"><b></b><span>
							<p><a href="own_complaint.php?type=complaint&send_receive=receive&state=all"><?php echo $lang['langCompComp']; ?></a></p>
							</span></li>
						<li class="nav-bg nav-left"><b></b><span>
							<p><?php echo $lang['langCompLaw']; ?></p>
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
					<span><b>1.<?php echo $lang['langCompSelectLawType']; ?></b>&nbsp;&nbsp;2.<?php echo $lang['langCompMakeLawContent']; ?>&nbsp;&nbsp;3.<?php echo $lang['langCompLawComplete']; ?></span>
					<div class="jubaoInfo">
						<ul>
							<li><?php echo $lang['langCompProofOne']; ?></li>
							<li><?php echo $lang['langCompLawOnce']; ?></li>
							<li><?php echo $lang['langCompLawMerchandiseMembers']; ?></li>
							<?php if ( $output['report_case'] == 'product' ) { ?>
							<li  style=" background-image:none"><?php echo $lang['langCompLawTypeLook']; ?><a href="own_complaint.php?action=report_member&step=one"><?php echo $lang['langCompLawMember']; ?></a>。</li>
							<?php } ?>
						</ul>
					</div>
					<?php } else if ( $output['step'] == 'two' ) { ?>
					<span>1.<?php echo $lang['langCompSelectLawType']; ?><b>&nbsp;&nbsp;2.<?php echo $lang['langCompMakeLawContent']; ?></b>&nbsp;&nbsp;3.<?php echo $lang['langCompLawComplete']; ?></span>
					<div class="jubaoInfo">
						<ul>
							<li><?php echo $lang['langCompProofOne']; ?></li>
							<li><?php echo $lang['langCompLawMerchandiseMember']; ?></li>
							<li>3.<span class="cr-5-span"  style="color:#F00; font-size:12px;">*</span> <?php echo $lang['langCompMustMake']; ?></li>
						</ul>
					</div>
					<?php } else { ?>
					<span>1.<?php echo $lang['langCompSelectLawType']; ?> &nbsp;&nbsp;2.<?php echo $lang['langCompMakeLawContent']; ?><b>&nbsp;&nbsp;3.<?php echo $lang['langCompLawComplete']; ?></b></span>
					<?php } ?>
				</div>
				<div class="cr-right">
					<form name="form_report" id="form_report" action="own_complaint.php?action=report_<?php echo $output['report_case']; ?>&step=three" method="post" enctype="multipart/form-data">
						<?php if ( $output['step'] == 'one' ) { ?>
						<div id="reportInfo" >
							<h2><span><?php echo $lang['langCompSelectLawMotif']; ?></span></h2>
							<ul>
								<?php if ( $output['report_case'] == 'member' ) { ?>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintSpeculationCredit']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintSpeculationCreditInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_member&step=two&type=5"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintRaisePrice']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintRaisePriceInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_member&step=two&type=6"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintPicInfringement']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintPicInfringementInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_member&step=two&type=7"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintSendAd']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintSendAdInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_member&step=two&type=8"></a></div>
								</li>
								<?php } ?>
								<?php if ( $output['report_case'] == 'product' ) { ?>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintMethodAsProduct']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintMethodAsProductInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_product&step=two&type=9&code=<?php echo $output['product_row']['p_code']; ?>"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintSellProhibitedProduct']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintSellProhibitedProductInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_product&step=two&type=10&code=<?php echo $output['product_row']['p_code']; ?>"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintSetWrongMenu']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintSetWrongMenuInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_product&step=two&type=11&code=<?php echo $output['product_row']['p_code']; ?>"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintRepeatShop']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintRepeatShopInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_product&step=two&type=12&code=<?php echo $output['product_row']['p_code']; ?>"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintAdProduct']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintAdProductInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_product&step=two&type=13&code=<?php echo $output['product_row']['p_code']; ?>"></a></div>
								</li>
								<li>
									<div class="report_content">
										<dl>
											<dt><?php echo $lang['langComplaintAbuseTag']; ?></dt>
											<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['langComplaintAbuseTagInfo']; ?></dd>
										</dl>
									</div>
									<div class="report_button"><a href="own_complaint.php?action=report_product&step=two&type=14&code=<?php echo $output['product_row']['p_code']; ?>"></a></div>
								</li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
						<?php if ( $output['step'] == 'two' ) { ?>
						<table cellpadding="0" border="0" width="100%"  >
							<tr>
								<td class="reporttitle" ><span><?php echo $lang['langCompSelectLawMotif']; ?></span></td>
							</tr>
							<tr>
								<td>
									<input type="hidden" name="type" value="<?php echo $output['type']; ?>" />
									<?php if ( $output['report_case'] == 'product' ) { ?>
									<input type="hidden" name="code" value="<?php echo $output['product_row']['p_code']?>" />
									<?php } ?>
									<table cellpadding="0" class="cr-r-td" border="0" width="100%">
										<?php if ( $output['report_case'] == 'member' ) { ?>
										<tr>
											<td class="cr-1"><?php echo $lang['langCompLawType']; ?>:</td>
											<td class="cr-2" style="line-height:25px;"> <b><?php echo $output['complaint_report_type']; ?></b><br/>
												<span style="color:#999;">( <?php echo $lang['langCompTypeErr']; ?> <a href="<?php echo SITE_URL; ?>/member/own_complaint.php?action=report_member&step=one"><?php echo $lang['langCReturnUp']; ?></a> <?php echo $lang['langCompSelectOtherType']; ?> )</span> </td>
										</tr>
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00;padding:20px 5px;">*</span><?php echo $lang['langCompByLaw']; ?>:</td>
											<td class="cr-2"><span style="color:#999; line-height:20px;">
												<input name="c_r_login_name" id="c_r_login_name" class="in" type="text" />
												&nbsp;&nbsp;<?php echo $lang['langCompMakeMyLawNumber']; ?></span> </td>
										</tr>
										<?php if ( $output['type'] == '5' ) { ?>
										<tr>
											<td class="cr-1"><?php echo $lang['langComplaintSpeculationUsername']; ?>:</td>
											<td class="cr-2">
												<input name="speculation_member_name" class="in"  type="text" />
											</td>
										</tr>
										<tr>
											<td class="cr-1"><?php echo $lang['langComplaintSpeculationMerchandise']; ?>:</td>
											<td class="cr-2">
												<input name="p_code" class="in"  type="text" />
											</td>
										</tr>
										<?php } ?>
										<?php if ( $output['type'] == '6' || $output['type'] == '7' ) { ?>
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00;padding:20px 5px;"">*</span><?php echo $lang['langCompCorrelationMerchandiseNum']; ?>:</td>
											<td class="cr-2">
												<input name="p_code" id="p_code" class="in"  type="text" />
											</td>
										</tr>
										<?php } ?>
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00; padding:20px 5px;"">*</span><?php echo $lang['langCompProof']; ?>:</td>
											<td class="cr-2">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td style="border:none;">
															<textarea style=" width:580px;height:170px;float:left"  onkeyup="keyNumber()"  id="evidence" name="evidence" rows="5" cols="40"></textarea>
															<br />
														</td>
													</tr>
													<tr>
														<td style="border:none;"><span style="color:#999;"><?php echo $lang['langCompCompReason']; ?></span><span id="keynum" style="float:left;"></span></td>
													</tr>
												</table>
											</td>
										</tr>
										<?php if ( $output['type'] == '7' || $output['type'] == '8' ) { ?>
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00;padding:20px 5px;"">*</span><?php echo $lang['langCompUpdataImage']; ?>:</td>
											<td class="cr-2">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="border:none;"><input style=" float:left" name="pic" type="file" /></td>
	</tr>
	
	<tr>
		<td style="border:none;"><span style="color:#999999;"><?php echo $lang['langCompUpdataBarbarismImage']; ?></span></td>
	</tr>
</table>
</td>
										</tr>
										<?php } ?>
										<?php } ?>
										<?php if ( $output['report_case'] == 'product' ) { ?>
										<tr>
											<td class="cr-1"><?php echo $lang['langCompByLaw']; ?>:</td>
											<td class="cr-2"><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $output['report_member']['member_id']; ?>" target="_blank"><?php echo $output['report_member']['login_name']; ?></a></td>
										</tr>
										<tr>
											<td class="cr-1"><?php echo $lang['langCompCorrelationBaby']; ?>:</td>
											<td class="cr-2"><a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $output['product_row']['p_code']; ?>" target="_blank"><?php echo $output['product_row']['p_name']; ?></a></td>
										</tr>
										<tr>
											<td class="cr-1"><?php echo $lang['langCompLawType']; ?>:</td>
											<td class="cr-2" style="line-height:25px;" ><b><?php echo $output['complaint_report_type']; ?></b><br/>
												<?php if ( $output['type'] == '10' ) { ?>
												<?php foreach ( $output['embargo_id'] as $key => $list ) { ?>
												<input name="embargo_id" <?php if ( $key == '1' ) { ?> checked="checked" <?php } ?> type="radio" value="<?php echo $key; ?>" />
												<?php echo $list; ?><br />
												<?php } ?>
												<?php } ?>
												<span style="color:#999;">(
												<?php echo $lang['langCompTypeErr']; ?> <a href="<?php echo SITE_URL; ?>/member/own_complaint.php?action=report_product&step=one&code=<?php echo $output['product_row']['p_code']; ?>" ><?php echo $lang['langCReturnUp']; ?></a>&nbsp;<?php echo $lang['langCompSelectOtherType']; ?>)</span>  </td>
										</tr>
										<?php if ( $output['type'] != '12' ) { ?> 
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00;padding:20px 5px;"">*</span><?php echo $lang['langCompProof']; ?>:</td>
											<td class="cr-2">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td style="border:none;">
															<textarea style=" width:580px;height:170px;float:left"  onkeyup="keyNumber()"  id="evidence" name="evidence" rows="5" cols="40"></textarea>
															<br />
														</td>
													</tr>
													<tr>
														<td style="border:none;"><span>
												<?php 
															if ( $output['type'] == '11' ) {
																echo $lang['langComplaintRightKind'];
															} else if ( $output['type'] == '14' ) {
																echo $lang['langComplaintAbuseTags'];
															} else {
																echo $lang['langCompLawReason'];
															}
														?>
												</span><span id="keynum"></span></td>
													</tr>
												</table>
											 </td>
										</tr>
										<?php } else { ?>
										<tr>
											<td class="cr-1"><span class="cr-5-span" style="color:#F00;padding:20px 5px;"">*</span><?php echo $lang['langComplaintRepeatProductNum']; ?>:</td>
											<td class="cr-2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="border:none;"><input style=" float:left;" name="related_product" type="text" /></td>
	</tr>
</table>

											
											</td>
										</tr>
										<?php } ?>
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
