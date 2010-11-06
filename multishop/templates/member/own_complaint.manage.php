<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langCompComplaintsLaw'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<?php if ( $output['type'] == '' ) { ?>
							<li class="nav-bg"><b></b><span><p><?php echo $lang['langCompComplaintsLaw']; ?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1"><b></b><span><p><a href="own_complaint.php" ><?php echo $lang['langCompComplaintsLaw']; ?></a></p></span></li>
						<?php } ?>
						<?php if ( $output['type'] == 'complaint' ) { ?>
							<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCompComp']; ?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_complaint.php?type=complaint&send_receive=receive&state=all"><?php echo $lang['langCompComp']; ?></a></p></span></li>
						<?php } ?>		
						<?php if ( $output['type'] == 'report' ) { ?>
							<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCompLaw']; ?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_complaint.php?type=report&send_receive=receive&state=all"><?php echo $lang['langCompLaw']; ?></a></p></span></li>
						<?php } ?>											
					</ul>
				</div>
				<div class="clear"></div>
				<div class="io-3-book"><p><?php echo $lang['langCompReflectCircs']; ?></p>
				</div>
				<div class="clear"></div>
				<div class="bg-sj bg-wu"></div>
				<!--投诉/举报-->
				<?php if ( $output['type'] == '' ) {?>
					<div class="bg-book">
					<table class="bg-book-table" border="0" cellpadding="0" >
						<tr>
							<td colspan="3" class="book-1-td"><span><?php echo $lang['langCompBothComplaints']; ?></span></td>
							<td colspan="3" class="book-2-td"><span><?php echo $lang['langCompByLawNotBusiness']; ?></span></td>
						</tr>
						<tr>
							<td class="book-3-td"><span></span></td>
							<td class="book-4-td"><?php echo $lang['langCompOperator']; ?></td>
							<td class="book-5-td"><?php echo $lang['langCompAlreadyEnd']; ?></td>
							<td class="book-3-td"><span></span></td>
							<td class="book-4-td"><?php echo $lang['langCompOperator']; ?></td>
							<td class="book-5-td"><?php echo $lang['langCompAlreadyEnd']; ?></td>
						</tr>
						<tr>
							<td class="book-3-td"><span><?php echo $lang['langCompReceiptComplaints']; ?></span></td>
							<td><a href="own_complaint.php?type=complaint&send_receive=receive&state=all"><?php echo $output['complaint_receive_handling']; ?></a></td>
							<td><a href="own_complaint.php?type=complaint&send_receive=receive&state=all&date_line=history"><?php echo $output['complaint_receive_handed']; ?></a></td>
							<td class="book-3-td"><span><?php echo $lang['langCompReceiptLaw']; ?></span></td>
							<td><a href="own_complaint.php?type=report&send_receive=receive&state=all"><?php echo $output['report_receive_handling']; ?></a></td>
							<td><a href="own_complaint.php?type=report&send_receive=receive&state=all&date_line=history"><?php echo $output['report_receive_handed']; ?></a></td>
						</tr>
						<tr>
							<td class="book-3-td"><span><?php echo $lang['langCompMakeComplaints']; ?></span></td>
							<td><a href="own_complaint.php?type=complaint&send_receive=send&state=all"><?php echo $output['complaint_send_handling']; ?></a></td>
							<td><a href="own_complaint.php?type=complaint&send_receive=send&state=all&date_line=history"><?php echo $output['complaint_send_handed']; ?></a></td>
							<td class="book-3-td"><span><?php echo $lang['langCompMakeLaw']; ?></span></td>
							<td><a href="own_complaint.php?type=report&send_receive=send&state=all"><?php echo $output['report_send_handling']; ?></a></td>
							<td><a href="own_complaint.php?type=report&send_receive=send&state=all&date_line=history"><?php echo $output['report_send_handed']; ?></a></td>
						</tr>
						<tr>
							<td colspan="3"><a class="mr-left" href="<?php echo SITE_URL; ?>/member/own_complaint.php?type=complaint&send_receive=receive&state=all"><?php echo $lang['langCompLookParticularInfo']; ?>>></a></td>
							<td colspan="3"><a class="mr-left" href="<?php echo SITE_URL; ?>/member/own_complaint.php?type=report&send_receive=receive&state=all"><?php echo $lang['langCompLookParticularInfo']; ?>>></a></td>
						</tr>
					</table>
					<div class="tousu-xia">
						<div class="tousu-xia-left">
							<dl>
								<dt><?php echo $lang['langCompInitiateComplaints']; ?>:</dt>
								<dd><?php echo $lang['langCompBusinessEntanglemant']; ?>:</dd>
								<dd><span>1.<?php echo $lang['langCompOn']; ?></span><a class="fzhi" href="<?php echo SITE_URL; ?>/member/own_order.php?action=bought"><span><?php echo $lang['langCompAlreadyBuyBaby']; ?></span></a><span><?php echo $lang['langCompComplaintsSale']; ?></span></dd>
								<dd><span>2.<?php echo $lang['langCompOn']; ?></span><a class="fzhi" href="<?php echo SITE_URL; ?>/member/own_order.php?action=sold"><span><?php echo $lang['langCompAlreadySaleBaby']; ?></span></a><span><?php echo $lang['langCompComplaintsBuy']; ?></span></dd>
							</dl>
						</div>
						<div class="tousu-xia-right">
							<dl>
								<dt><?php echo $lang['langCompInitiateLaw']; ?>:</dt>
								<dd><span>1.<?php echo $lang['langCompLawMerchandise']; ?></span><a class="fzhi" href=""><span><?php echo $lang['langCompHowLaw']; ?></span></a></dd>
								<dd><span><?php echo $lang['langCompLawMemberQuestion']; ?></span><a class="fzhi" href="<?php echo SITE_URL; ?>/member/own_complaint.php?action=report_member&step=one"><span><?php echo $lang['langCompLawMember']; ?></span></a></dd>
							</dl>
						</div>
					</div>
					<div class="xianxi-c">
						<p class="seze"><?php echo $lang['langComplaintExplainBottomOne']; ?></p>
						<p><?php echo $lang['langComplaintExplainBottomTwo']; ?></p>
					</div>
					</div>
				<?php } ?>
				<!--投诉-->
				<?php if ( $output['type'] == 'complaint' ) {?>
					<div class="info-1">
						<div class="jubaoInfo2"><?php echo $lang['langCompOneComplaints']; ?><br/>
						<span><?php echo $lang['langCompTwoComplaints']; ?></span> <a style=" " class="fzhi" href="own_order.php?action=bought"><span><?php echo $lang['langCompAlreadyBuyBaby']; ?></span></a><span class="top-span"><?php echo $lang['langCompComplaintsSaleOn']; ?></span> <a style="" class="fzhi" href="own_order.php?action=sold"><span><?php echo $lang['langCompAlreadySaleBaby']; ?></span></a>
						<?php echo $lang['langCompComplaintsBuy']; ?><br/>
						<?php echo $lang['langCompThreeComplaints']; ?><br/></div>
					</div>			
					<div class="nav">				
						<ul>
							<?php if ( $output['send_receive'] == 'receive' ) { ?>
								<li class="nav-bg"><b></b><span><p><?php echo $lang['langCompMyByComplaints'];?></p></span></li>
								<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_complaint.php?type=complaint&send_receive=send&state=all"><?php echo $lang['langCompMyComplaints'];?></a></p></span></li>
							<?php } else { ?>
								<li class="nav-bg-1"><b></b><span><p><a href="own_complaint.php?type=complaint&send_receive=receive&state=all"><?php echo $lang['langCompMyByComplaints'];?></a></p></span></li>
								<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCompMyComplaints'];?></p></span></li>
							<?php } ?>
						</ul>
						<div align="right">
							<select id="isarchive" name="isarchive" onchange="location.href='own_complaint.php?type=<?php echo $output['type']; ?>&send_receive=<?php echo $output['send_receive']; ?>&state=<?php echo $output['state']; ?>&date_line='+this.value">
							  <option <?php if ( $output['date_line'] == 'recent' || $output['date'] == '' ) { ?> selected="selected" <?php } ?> value="recent"><?php echo $lang['langCompLatelyNote']; ?></option>
							  <option <?php if ( $output['date_line'] == 'history' ) { ?> selected="selected" <?php } ?> value="history"><?php echo $lang['langCompLookHistory']; ?></option>
							</select>
						</div>							
					</div>								
					<div class="z-mai-unite">
						<!--我收到的投诉-->
						<?php if ( $output['send_receive'] == 'receive' ) {?>
							<table class="unite-table-1 unite-table-b" border="0" cellpadding="0" >
								<tr class="tr-un-bg-2">
									<td class="td-bg-2 p-left-rio" style="width:10%;"><?php echo $lang['langCompComplaintsNumber'];?></td>
									<td class="td-bg-1" style="width:15%;"><?php echo $lang['langCompCorrelationBargaining'];?></td>
									<td class="td-bg-2" style="width:10%;"><?php echo $lang['langCompComplaints'];?></td>
									<td class="td-bg-6" style="width:10%;"><?php echo $lang['langCompComplaintsCause'];?></td>
									<td class="td-bg-2" style="width:10%;">
										<select id="processStatus" name="processStatus" onchange="location.href='own_complaint.php?type=<?php echo $output['type']; ?>&send_receive=<?php echo $output['send_receive']; ?>&state='+this.value">
											<option <?php if ( $output['state'] == 'all' ) { ?> selected="selected" <?php } ?> value="all"><?php echo $lang['langCompEstate'];?></option>
											<option <?php if ( $output['state'] == 'handling' ) { ?> selected="selected" <?php } ?> value="handling"><?php echo $lang['langCompOperator'];?></option>
											<option <?php if ( $output['state'] == 'handed' ) { ?> selected="selected" <?php } ?> value="handed"><?php echo $lang['langCompAlreadyEnd'];?></option>
										</select>
									</td>
									<td class="td-bg-5" style="width:10%;"><?php echo $lang['langCompInitiateTime'];?></td>
									<td class="td-bg-7" style="width:10%;"><?php echo $lang['langCOperation'];?></td>
								</tr>
								<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>
									<?php foreach($output['complaint_receive_list'] as $list){ ?>
										<tr class="tr-un-conter-2">
											<td class="p-left-rio" style="width:10%;"><?php echo $list['complaint_report_id']; ?></td>
											<td style="width:15%; text-align:left;"><a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['p_code']; ?>" target="_blank"><?php echo $list['p_name']; ?></a></td>
											<td style="width:10%;" ><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $list['member_id']; ?>" target="_blank"><?php echo $list['login_name']; ?></a></td>
											<td style="width:10%;"><?php echo $output['baseconfig_type'][$list['c_r_type']]; ?></td>
											<td style="width:10%;"><?php echo $output['baseconfig_type'][$list['c_r_handling_state']]; ?></td>
											<td style="width:10%;"><?php echo $list['c_r_add_time']; ?></td>
											<td style="width:10%;"><p class="viewicon" style="margin-left:30px;"  ><a href="own_complaint.php?action=view&type=<?php echo $output['type']; ?>&complaint_report_id=<?php echo $list['complaint_report_id']; ?>"><?php echo $lang['langCview']; ?></a></p></td>
										</tr>								
									<?php } ?>
								<?php } else { ?>
									<tr class="tr-not">
										<td colspan="7"><div class="tr_not_div"><?php echo $lang['langCompTemporarilyNothingInfo']; ?></div></td>
									</tr>
								<?php } ?>
							</table>
						<?php } ?>
						<!--我作出的投诉-->
						<?php if ( $output['send_receive'] == 'send' ) { ?>
							<form action="own_complaint.php?action=del" method="post" onsubmit="if(confirm('<?php echo $lang['langCompConfirmDelComplaints']; ?>')){return true;}else{return false;}">
							<table class="unite-table-1 unite-table-b" border="0" cellpadding="0" >
								<tr class="tr-un-bg-2">
									<td class="td-bg-2 p-left-rio" style="width:5%;"><?php echo $lang['langCompSelect'];?></td>
									<td class="td-bg-2" style="width:10%;"><?php echo $lang['langCompComplaintsNumber'];?></td>
									<td class="td-bg-9" style="width:18%;" ><?php echo $lang['langCompCorrelationBargaining'];?></td>
									<td class="td-bg-2" style="width:10%;"><?php echo $lang['langCompByComplaints'];?></td>
									<td class="td-bg-3" style="width:10%;"><?php echo $lang['langCompComplaintsCause'];?></td>
									<td class="td-bg-6" style="width:10%;">
										<select id="processStatus" name="processStatus" onchange="location.href='own_complaint.php?type=<?php echo $output['type']; ?>&send_receive=<?php echo $output['send_receive']; ?>&state='+this.value">
											<option <?php if ( $output['state'] == 'self_all' ) { ?> selected="selected" <?php } ?> value="self_all"><?php echo $lang['langCompEstate'];?></option>
											<option <?php if ( $output['state'] == 'handling' ) { ?> selected="selected" <?php } ?> value="handling"><?php echo $lang['langCompOperator'];?></option>
											<option <?php if ( $output['state'] == 'handling_no' ) { ?> selected="selected" <?php } ?> value="handling_no">|-<?php echo $lang['langCompNotAppeal'];?></option>
											<option <?php if ( $output['state'] == 'handling_have' ) { ?> selected="selected" <?php } ?> value="handling_have">|-<?php echo $lang['langCompAlreadyAppeal'];?></option>
											<option <?php if ( $output['state'] == 'handed' ) { ?> selected="selected" <?php } ?> value="handed"><?php echo $lang['langCompAlreadyEnd'];?></option>
										</select>
									</td>
									<td class="td-bg-5" style="width:10%;"><?php echo $lang['langCompInitiateTime'];?></td>
									<td class="td-bg-7" style="width:10%;"><?php echo $lang['langCOperation'];?></td>
								</tr>
								<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>
									<?php foreach($output['complaint_receive_list'] as $list){ ?>
										<tr class="tr-un-conter-2">
											<td class="p-left-rio-fu" style="width:5%;" >
												<?php if ( $list['c_r_handling_state'] == '0' || $list['c_r_handling_state'] == '1' ) { ?>
													<?php $sign = '1'; ?>
												    <input name="complaint_report_id[]" type="checkbox" value="<?php echo $list['complaint_report_id']; ?>" />
												    <input name="sp_id[]" type="hidden" value="<?php echo $list['sp_id']; ?>" />													
												<?php } ?>
											</td>
											<td style="width:10%;"><?php echo $list['complaint_report_id']; ?></td>
											<td style="width:18%; text-align:left;"><a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['p_code']; ?>" target="_blank"><?php echo $list['p_name']; ?></a></td>
											<td style="width:10%;"><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $list['c_r_member_id']; ?>" target="_blank"><?php echo $list['c_r_login_name']; ?></a></td>
											<td style="width:10%;"><?php echo $output['baseconfig_type'][$list['c_r_type']]; ?></td>
											<td style="width:10%;"><?php echo $output['baseconfig_type'][$list['c_r_handling_state']]; ?></td>
											<td style="width:10%;"><?php echo $list['c_r_add_time']; ?></td>
											<td style="width:10%;"><p class="viewicon" style="margin-left:25px;" ><a href="own_complaint.php?action=view&type=<?php echo $output['type']; ?>&complaint_report_id=<?php echo $list['complaint_report_id']; ?>"><?php echo $lang['langCview']; ?></a></p></td>
										</tr>								
									<?php } ?>
								<?php } else { ?>
									<tr class="tr-not" >
										<td colspan="7"><div class="tr_not_div"><?php echo $lang['langCompTemporarilyNothingInfo']; ?></div></td>
									</tr>
								<?php } ?>
							</table>	
							<div class="page">
								<div style=" float:left; padding-left:5px; padding-top:5px;">
									<?php if ( $sign == '1' ) { ?>
                                    <span class="buttom-comm">
										<input type="submit" name="Submit2" class="new_anniu" value="<?php echo $lang['langCompDelLaw']; ?>" /></span>
									<?php } ?>
								</div>	
								<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>						
									<div class="pd-ck-right">
										<?php echo $output['page_list']; ?>
									</div>	
								<?php } ?>
							</div>	
							</form>											
						<?php } ?>
					</div>				
				<?php } ?>
				<!-- 举报 -->
				<?php if ( $output['type'] == 'report' ) { ?>
					<div class="info-1">
						<div class="jubaoInfo2"><?php echo $lang['langCompOneLaw']; ?><br/>
						<?php echo $lang['langCompTwoLaw']; ?>
						<a class="fzhi" style="" href="own_complaint.php?action=report_member&step=one" target="_blank"><span><?php echo $lang['langCompLawMember']; ?></span></a><br/></div>
					</div>	
					<div class="nav">				
						<ul>
							<?php if ( $output['send_receive'] == 'receive' ) { ?>
								<li class="nav-bg"><b></b><span><p><?php echo $lang['langCompMyByLaw'];?></p></span></li>
								<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_complaint.php?type=report&send_receive=send&state=all"><?php echo $lang['langCompMyLaw'];?></a></p></span></li>
							<?php } else { ?>
								<li class="nav-bg-1"><b></b><span><p><a href="own_complaint.php?type=report&send_receive=receive&state=all"><?php echo $lang['langCompMyByLaw'];?></a></p></span></li>
								<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCompMyLaw'];?></p></span></li>
							<?php } ?>
						</ul>
						<div align="right">
							<select id="isarchive" name="isarchive" onchange="location.href='own_complaint.php?type=report&send_receive=<?php echo $output['send_receive']; ?>&state=<?php echo $output['state']; ?>&date_line='+this.value">
							  <option <?php if ( $output['date_line'] == 'recent' || $output['date'] == '' ) { ?> selected="selected" <?php } ?> value="recent"><?php echo $lang['langCompLatelyNote']; ?></option>
							  <option <?php if ( $output['date_line'] == 'history' ) { ?> selected="selected" <?php } ?> value="history"><?php echo $lang['langCompLookHistory']; ?></option>
							</select>
						</div>							
					</div>	
					<div class="z-mai-unite">
						<!--我收到的举报-->
						<?php if ( $output['send_receive'] == 'receive' ) {?>
							<table class="unite-table-1 unite-table-b" border="0" cellpadding="0" >
								<tr class="tr-un-bg-2">
									<td class="td-bg-2 p-left-rio" style="width:8%" ><?php echo $lang['langCompLawNumber'];?></td>
									<td class="td-bg-11" style="width:30%"><?php echo $lang['langCompLawCause'];?></td>
									<td class="td-bg-6" style="width:10%">
										<select id="processStatus" name="processStatus" onchange="location.href='own_complaint.php?type=report&send_receive=receive&state='+this.value">
											<option <?php if ( $output['state'] == 'all' ) { ?> selected="selected" <?php } ?> value="all"><?php echo $lang['langCompEstate'];?></option>
											<option <?php if ( $output['state'] == 'handling' ) { ?> selected="selected" <?php } ?> value="handling"><?php echo $lang['langCompOperator'];?></option>
											<option <?php if ( $output['state'] == 'handed' ) { ?> selected="selected" <?php } ?> value="handed"><?php echo $lang['langCompAlreadyEnd'];?></option>
										</select>
									</td>
									<td class="td-bg-6" style="width:10%"><?php echo $lang['langComlInitiateTime'];?></td>
									<td class="td-bg-7" style="width:10%"><?php echo $lang['langCOperation'];?></td>
								</tr>
								<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>
									<?php foreach($output['complaint_receive_list'] as $list){ ?>
										<tr class="tr-un-conter-2">
											<td class="p-left-rio" style="width:8%"><?php echo $list['complaint_report_id']; ?></td>
											<td style="width:30%; text-align:left;">
												<?php echo $output['baseconfig_type'][$list['c_r_type']]; ?>
												<?php if ( $list['c_r_type'] == '12' ) { ?>
													-	<a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['c_r_related_product']; ?>" target="_blank"><?php echo $list['c_r_related_name']; ?></a>
												<?php } ?>
											</td>
											<td style="width:10%"><?php echo $output['baseconfig_type'][$list['c_r_handling_state']]; ?></td>
											<td style="width:10%"><?php echo $list['c_r_add_time']; ?></td>
											<td style="width:10%"><a href="own_complaint.php?action=view&type=<?php echo $output['type']; ?>&complaint_report_id=<?php echo $list['complaint_report_id']; ?>"><?php echo $lang['langCview']; ?></a></td>
										</tr>								
									<?php } ?>
								<?php } else { ?>
									<tr class="tr-not">
										<td colspan="7"><div class="tr_not_div"><?php echo $lang['langCompTemporarilyNothingInfo']; ?></div></td>
									</tr>
								<?php } ?>
							</table>
							<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>
								<div class="page">					
									<div class="pd-ck-right">
										<?php echo $output['page_list']; ?>
									</div>	
								</div>	
							<?php } ?>							
						<?php } ?>
						<!--我作出的举报-->
						<?php if ( $output['send_receive'] == 'send' ) { ?>
							<form action="own_complaint.php?action=del" method="post" onsubmit="if(confirm('<?php echo $lang['langCompConfirmDelComplaintsLaw']; ?>')){return true;}else{return false;}">
							<table class="unite-table-1 unite-table-b" border="0" cellpadding="0">
								<tr class="tr-un-bg-2">
								    <td class="td-bg-2 p-left-rio" style="width:5%"><?php echo $lang['langCompSelect'];?></td>
									<td class="td-bg-2" style="width:10%"><?php echo $lang['langCompLawNumber'];?></td>
									<td class="td-bg-9" style="width:18%"><?php echo $lang['langCompCorrelationBargaining'];?></td>
										<td class="td-bg-2" style="width:10%"><?php echo $lang['langCompByLaw'];?></td>
									<td class="td-bg-2" style="width:10%"><?php echo $lang['langCompLawCause'];?></td>
								
									<td class="td-bg-6" style="width:10%">
										<select id="processStatus" name="processStatus" onchange="location.href='own_complaint.php?type=report&send_receive=send&state='+this.value">
											<option <?php if ( $output['state'] == 'self_all' ) { ?> selected="selected" <?php } ?> value="self_all"><?php echo $lang['langCompEstate'];?></option>
											<option <?php if ( $output['state'] == 'handling' ) { ?> selected="selected" <?php } ?> value="handling"><?php echo $lang['langCompOperator'];?></option>
											<option <?php if ( $output['state'] == 'handling_no' ) { ?> selected="selected" <?php } ?> value="handling_no">|-<?php echo $lang['langCompNotAppeal'];?></option>
											<option <?php if ( $output['state'] == 'handling_have' ) { ?> selected="selected" <?php } ?> value="handling_have">|-<?php echo $lang['langCompAlreadyAppeal'];?></option>
											<option <?php if ( $output['state'] == 'handed' ) { ?> selected="selected" <?php } ?> value="handed"><?php echo $lang['langCompAlreadyEnd'];?></option>
										</select>
									</td>
									<td class="td-bg-5" style="width:10%"><?php echo $lang['langCompInitiateTime'];?></td>
									<td class="td-bg-7" style="width:10%"><?php echo $lang['langCOperation'];?></td>
								</tr>
								<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>
									<?php foreach($output['complaint_receive_list'] as $list){ ?>
										<tr class="tr-un-conter-2" >
											<td class="p-left-rio-fu" style="width:5%">
												<?php if ( $list['c_r_handling_state'] == '0' || $list['c_r_handling_state'] == '1' ) { ?>
													<?php $sign = '1'; ?>
												    <input name="complaint_report_id[]" type="checkbox" value="<?php echo $list['complaint_report_id']; ?>" />
												    <input name="sp_id[]" type="hidden" value="<?php echo $list['sp_id']; ?>" />													
												<?php } ?>
											</td>
											<td style="width:10%"><?php echo $list['complaint_report_id']; ?></td>
											<td style="width:18%; text-align:left;"><a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['p_code']; ?>" target="_blank"><?php echo $list['p_name']; ?></a></td>
											<td style="width:10%"><a href="<?php echo SITE_URL; ?>/store/userinfo.php?userid=<?php echo $list['c_r_member_id']; ?>" target="_blank"><?php echo $list['c_r_login_name']; ?></a></td>
											<td style="width:10%; text-align:left;"><?php echo $output['baseconfig_type'][$list['c_r_type']]; ?></td>
											<td style="width:10%"><?php echo $output['baseconfig_type'][$list['c_r_handling_state']]; ?></td>
											<td style="width:10%"><?php echo $list['c_r_add_time']; ?></td>
											<td style="width:10%"><a href="own_complaint.php?action=view&type=<?php echo $output['type']; ?>&complaint_report_id=<?php echo $list['complaint_report_id']; ?>"><?php echo $lang['langCview']; ?></a></td>
										</tr>								
									<?php } ?>
								<?php } else { ?>
									<tr class="tr-not">
										<td colspan="7"><div class="tr_not_div"><?php echo $lang['langCompTemporarilyNothingInfo']; ?></div></td>
									</tr>
								<?php } ?>
							</table>	
							<div class="page">
							<div style=" float:left; padding-left:5px; padding-top:5px;">
									<?php if ( $sign == '1' ) { ?>
                                    <span class="buttom-comm">
										<input type="submit" name="Submit2" class="new_anniu" value="<?php echo $lang['langCompDelMyLaw']; ?>" /></span>
									<?php } ?>
								</div>	
								<?php if(!empty($output['complaint_receive_list']) && is_array($output['complaint_receive_list'])){ ?>						
								<div class="pd-ck-right">
									<?php echo $output['page_list']; ?>
								</div>	
								<?php } ?>
							</div>	
							</form>											
						<?php } ?>
					</div>														
				<?php } ?>
			</div>
		</div>
	</div>
</div>