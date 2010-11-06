<link href="<?php echo SITE_URL; ?>/js/jquery/ui.theme.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/jquery/ui.datepicker.js"></script>
<script type="text/javascript" language="javascript"> 
// JavaScript Document
$(function(){
	$('#start_time').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});	
	$('#end_time').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});		
});
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p>
						<?php 
							if($output['type'] == 'bought'){
								echo $lang['langHeadAlreadyBuyBaby'].$lang['langRefundOrderExplain']; 
							}
							if($output['type'] == 'sold'){
								echo $lang['langOAlreadySellBaby']; 
							}
						?>
					</p>
				</div>
				<div class="sos">
	<form action="own_order.php?action=<?php echo $output['order_case']; ?>" method="post">
					<input type="hidden" name="time" value="<?php echo $output['time']; ?>" />
					<ul>
					    <li class="depot-search" style="height:10px;"><?php echo $lang['langCSelect']; ?></li>
						<li class="zi-w"><?php echo $lang['langOrderBabyName']; ?>: </li>
						<li class="zi-w-8"><input class="input-100" name="p_name" type="text" value="<?php echo $output['input']['p_name']; ?>" /></li>
						<li class="zi-w">&nbsp;&nbsp;<?php echo $lang['langOrderBargainOnTime']; ?>: <?php echo $lang['langOrderFrom']; ?></li>
						<li class="zi-w-8"><input class="input-80" name="start_time" id="start_time" readonly="true" type="text" value="<?php echo $output['input']['start_time']; ?>" /></li>
						<li class="zi-w"><?php echo $lang['langOrderTo']; ?></li>
						<li class="zi-w-8"><input class="input-80" name="end_time" id="end_time" readonly="true" type="text" value="<?php echo $output['input']['end_time']; ?>" /></li>
						<li class="zi-w">&nbsp;&nbsp;<?php echo $lang['langOrderSaleNickname']; ?>: </li>
						<li class="zi-w-8"><input class="input-100" name="seller_nick" type="text" value="<?php echo $output['input']['seller_nick']; ?>" /></li>
						<li class="aan-1"><span class="buttom-comm-1"><input class="input-a" name="" value="<?php echo $lang['langCSelect']; ?>" type="submit" /></span></li>
					</ul>
					</form>
							
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p>
							<?php 
								if($output['type'] == 'bought'){
									echo $lang['langHeadAlreadyBuyBaby']; 
								}
								if($output['type'] == 'sold'){
									echo $lang['langOAlreadySellBaby']; 
								}
							?>
						</p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-1" style="width:17%"><?php echo $lang['langOrderBabyName'];?></td>
							<td class="td-bg-4" style="width:10%"><?php echo $lang['langOUnitPrice'];?></td>
							<td class="td-bg-2" style="width:10%"><?php echo $lang['langOBuyNumber'];?></td>
							<td class="td-bg-8" style="width:10%"><?php echo $lang['langOSoldType'];?></td>
							<td class="td-bg-4" style="width:12%"><?php 
								if($output['type'] == 'bought'){
									echo $lang['langOrderLiaisonSale'];
								}
								if($output['type'] == 'sold'){
									echo $lang['langOrderLiaisonBuy'];
								}?>
								</td>
							<td class="td-bg-3" style="width:12%"><?php echo $lang['langOrderBargainingEstate'];?></td>
							<td class="td-bg-6" style="width:12%"><?php echo $lang['langOTatalPrice'];?></td>
							<td class="td-bg-7" style="width:12%"><?php echo $lang['langCOperation'];?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="8"></td>
						</tr>
						<?php if(!empty($output['product_order_array']) && is_array($output['product_order_array'])){ ?>
						<?php foreach($output['product_order_array'] as $k => $goods){ ?>

						<tr class="tr-un-blue">
							<td colspan="8">
								<span class="dt-1"><?php echo $lang['langOCode'];?>: <?php echo $goods['sp_code']; ?> </span>
								<span class="dt-8"><a href="own_order.php?action=show&sp_code=<?php echo $goods['sp_code']; ?>" style="text-decoration:underline;"><?php echo $lang['langOrderViewDetail']; ?></a></span>
								<span class="dt-time"><?php echo $lang['langOrderBargainOnTime'];?>: <?php echo $goods['sold_date']; ?></span>
							</td>
						</tr>
						<tr class="tr-un-conter-1">
							<td class="left-border tr-img">
								<?php if ( $goods['sp_html'] != '' ) { ?>
									<span class="mi-6-left"><a href="<?php echo SITE_URL; ?>/home/order.php?action=sp_html&sp_code=<?php echo $goods['sp_code']?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo !empty( $goods['p_pic'] ) && $goods['p_pic'] != 'null' ? $goods['p_pic'] : 'templates/orange/images/noimgs.gif'; ?>" /></a></span>								
									<span class="mi-6-right"><a href="<?php echo SITE_URL; ?>/home/order.php?action=sp_html&sp_code=<?php echo $goods['sp_code']?>" target="_blank"><?php echo $goods['p_name']; ?></a></span>
								<?php } else { ?>
									<?php if ( $output['ifhtml'] == '1' && $goods['html_url'] != '' ) { ?>
										<span class="mi-6-left">
											<a target="_blank" href="<?php echo $goods['html_url']; ?>">
												<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $goods['p_pic'] ) && $goods['p_pic'] != 'null' ? $goods['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" />
											</a>	
										</span>	
										<span class="mi-6-right">
											<a target="_blank" href="<?php echo $goods['html_url']; ?>"><?php echo $goods['p_name']; ?></a>
										</span>							
									<?php } else { ?>
										<span class="mi-6-left">
											<a href="<?php echo $goods['product_href']; ?>" target="_blank">
												<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $goods['p_pic'] ) && $goods['p_pic'] != 'null' ? $goods['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $goods['p_name']; ?>" title="<?php echo $goods['p_name']; ?>"/>
											</a>	
										</span>	
										<span class="mi-6-right">
											<a href="<?php echo $goods['product_href']; ?>" target="_blank"><?php echo $goods['p_name']; ?></a>										
										</span>							
									<?php } ?>
								<?php } ?>
							</td>
							<td class="td-blod">
								<?php echo $goods['unit_price']; ?>
							</td>
							<td class="td-blod">
								<?php echo $goods['buy_num']; ?>
							</td>
							<td class="td-blod">
								<?php echo $goods['sell_type_name']; ?>
							</td>
							<td class="td-state left-right-bor">
								<?php if ($goods['member_id'] != '') { ?><a href="<?php echo SITE_URL; ?>/store/index.php?userid=<?php echo $goods['member_id']; ?>" target="_blank" alt="<?php echo $output['langSailAboutStore']; ?>"><?php echo $goods['member_nick']; ?></a><?php } else { ?><?php echo $goods['member_nick']; ?><?php } ?>
							</td>
							<td style="text-align:left;padding-left:7px;">
								<?php if($goods['is_complaint'] == '0'){ ?>
									<?php if($goods['state_info']['state_type'] !== 'all'){ ?>
										<?php 
											/**
											 * 买家操作
											 */
											if($goods['state_info']['state_type'] == 'buyer'){ 
										?>
											<?php if($output['order_case'] == 'bought'){ ?>
												<font color="#FF3300"><?php echo $goods['state_info']['state_title']; ?></font>		
												<?php if ($goods['is_operate'] == '0') {?>
													<p><img src="<?php echo TPL_DIR; ?>/images/icon_refund.gif" alt="<?php echo $lang['langRefundExistence']; ?>" /></p>
												<?php } ?>
											<?php }else{ ?>
												<?php echo $goods['state_info']['state_title']; ?>	
												<?php if ($goods['is_operate'] == '0') {?>
													<p><img src="<?php echo TPL_DIR; ?>/images/icon_refund.gif" alt="<?php echo $lang['langRefundExistence']; ?>" /></p>
												<?php } ?>
											<?php } ?>																						
										<?php } ?>


										<div id="show_modi_postage_location" style="display:none">
											<div style="float:right;"><a href="javascript:;" onclick="hide_postage();" >x</a></div>
											<input type="text" id="postage" value="" />
											<input type="hidden" id="postage_sp_code" value="" />
											<input type="button" id="submit_modi_postage" onclick="submit_modi_postage();" value="<?php echo $lang['langCsave'];?>" />
										</div>
										<script>
											function modi_postage(obj,sp_code){
												var tf_fee = $('#tf_fee_'+sp_code).html();
												var top = $(obj).offset().top+20;
												var left = $(obj).offset().left;
												$('#show_modi_postage_location').css({
													'display':'block',
													'left':left+'px',
													'top':top+'px',
													'position':'absolute',
													'background':'none repeat scroll 0 0 #FFFBE7',
													'border':'2px solid #9EBEEC',
													'padding':'5px',
													'width':'200px',
													'height':'30px'
												});
												$('#postage').val(tf_fee);
												$('#postage_sp_code').val(sp_code);
											}
											function hide_postage(){
												$('#show_modi_postage_location').css({
													'display':'none'
												});
											}
											function submit_modi_postage(){
												$('#submit_modi_postage').attr('disabled',true);
												//validate postage 0-999.99
												var tf_fee = $('#postage').val();
												if(!isNaN(tf_fee) && tf_fee >= 0 && tf_fee < 999.99){
													$.ajax({
														url: "./own_order.php",
														data: 'action=save_postage&tf_fee='+tf_fee+'&sp_code='+$('#postage_sp_code').val(),
														type:'get',
														dataType:"json",
														success: function(msg){
															if(msg.type == '1'){//succ
																//alert('<?php echo $lang['alertOrderOperatorOk'];?>');
															}else{//fail
																alert(msg.message);
															}
															//
															$('#submit_modi_postage').attr('disabled',false);
															$('#tf_fee_'+$('#postage_sp_code').val()).html(tf_fee);
															$('#total_price_'+$('#postage_sp_code').val()).html(msg.total_price);
															$('#postage').val('');
															$('#postage_sp_code').val('');
															hide_postage();
														}
													});
													return false;
												}else{
													alert('<?php echo $lang['errOModiPostageIsWrong'];?>');
													return false;
												}
											}
										</script>
										<?php 
											/**
											 * 卖家操作
											 */
											if($goods['state_info']['state_type'] == 'seller'){ 
										?>
											<?php if($output['order_case'] == 'sold'){ ?>
												<font color="#FF3300"><?php echo $goods['state_info']['state_title']; ?></font>		
												<?php if ($goods['is_operate'] == '0') {?>
													<p><img src="<?php echo TPL_DIR; ?>/images/icon_refund.gif" alt="<?php echo $lang['langRefundExistence']; ?>" /></p>
												<?php } ?>
											<?php }else{ ?>
												<?php echo $goods['state_info']['state_title']; ?>
												<?php if ($goods['is_operate'] == '0') {?>
													<p><img src="<?php echo TPL_DIR; ?>/images/icon_refund.gif" alt="<?php echo $lang['langRefundExistence']; ?>" /></p>
												<?php } ?>
											<?php } ?>
										<?php } ?>
										<?php if($goods['state_info']['state_type'] == ''){ ?>
											<?php echo $goods['state_info']['state_title']; ?>
										<?php } ?>
									<?php } else { ?>
										<?php echo $goods['state_info']['state_title']; ?>										
									<?php } ?>
								<?php } else { ?>
									<a href='own_complaint.php'><?php echo $lang['langOrderLockPleaseSeeComplaint']; ?></a>
								<?php } ?>
							</td>
							<td class="left-right-bor">
								<span id="total_price_<?php echo $goods['sp_code']; ?>"><?php echo $goods['total_price']; ?></span></p><p class="gray">(<?php echo $lang['langOIncludeTffee']; ?><span id="tf_fee_<?php echo $goods['sp_code']; ?>"><?php echo $goods['tf_fee']; ?></span><?php echo $lang['langCYuan']; ?>)
							</td>
							<td class="td-bg-4 right-border" style="padding-left:5px;"><!--操作开始2010/7/12-->
								<?php if($goods['is_complaint'] == '0'){ ?>
									<?php if($goods['state_info']['state_type'] !== 'all'){ ?>
										<?php 
											/**
											 * 买家操作
											 */
											if($goods['state_info']['state_type'] == 'buyer'){ 
										?>
											<?php if($output['order_case'] == 'bought'){ ?>
												<?php 
													/**
													 * 付款
													 */
													if($goods['sp_state'] == '0'){ 
												?>
													<p class="fukuanicon"><a href="<?php echo $goods['state_info']['state_url']; ?>" style="text-decoration:underline;"><?php echo $lang['langOrderPay']; ?></a></p>
												<?php } ?>
												<?php 
													/**
													 * 确认收货
													 */
													if($goods['sp_state'] == '2' && $goods['is_operate'] == '1'){ 
												?>
													<p class="qrshicon"><a href="<?php echo $goods['state_info']['state_url']; ?>" style="text-decoration:underline;"><?php echo $lang['langAffirmReceiptBale']; ?></a></p>
												<?php } ?>	
												<?php if ($goods['is_refund'] == '1') {?>
													<p class="tuikuanicon"><a style="text-decoration:underline;" href="own_order.php?action=refund_add&sp_code=<?php echo $goods['sp_code']; ?>"><?php echo $lang['langRefund']; ?></a></p>
												<?php } ?>
											<?php }else{ ?>
												<?php if ($goods['refund_state'] == '1') {?>
													<p class="fa-ba"><a href="own_order.php?action=refund_confirm&sp_code=<?php echo $goods['sp_code']; ?>"><?php echo $lang['langRefundConfirm']; ?></a></p>
												<?php } ?>																																				
												<?php 
													/**
													 * 未付款的情况下 卖家关闭交易和修改运费操作
													 */
													if($goods['sp_state'] == '0'){ ?>
													<p class="closeicon"><a href="own_order.php?action=close&sp_code=<?php echo $goods['sp_code']; ?>" style="text-decoration:underline;"><?php echo $lang['langOrderClose']; ?></a></p>
														<?php if($goods['tf_type'] !== '0' && $goods['tf_type'] !== '' && $goods['sell_type'] !== '0'){ ?>
															<p class="editpostageicon"><a href="javascript:;" onclick="modi_postage(this,'<?php echo $goods['sp_code']; ?>');" style="text-decoration:underline;"><?php echo $lang['langOModiPostage']; ?></a></p>
															<!--href="own_order.php?action=modi_postage&sp_code=<?php echo $goods['sp_code']; ?>"-->
														<?php } ?>
												<?php } ?>
											<?php } ?>																						
										<?php } ?>


										<div id="show_modi_postage_location" style="display:none">
											<div style="float:right;"><a href="javascript:;" onclick="hide_postage();" >x</a></div>
											<input type="text" id="postage" value="" />
											<input type="hidden" id="postage_sp_code" value="" />
											<input type="button" id="submit_modi_postage" onclick="submit_modi_postage();" value="<?php echo $lang['langCsave'];?>" />
										</div>
										<?php 
											/**
											 * 卖家操作
											 */
											if($goods['state_info']['state_type'] == 'seller'){ 
										?>
											<?php if($output['order_case'] == 'sold'){ ?>
												<?php if ($goods['refund_state'] == '1') {?>
													<p><a style="text-decoration:underline;" href="own_order.php?action=refund_confirm&sp_code=<?php echo $goods['sp_code']; ?>"><?php echo $lang['langRefundConfirm']; ?></a></p>
												<?php } ?>
											<?php }else{ ?>
												<?php if ($goods['is_refund'] == '1') {?>
													<p class="tuikuanicon"><a style="text-decoration:underline;" href="own_order.php?action=refund_add&sp_code=<?php echo $goods['sp_code']; ?>"><?php echo $lang['langRefund']; ?></a></p>
												<?php } ?>																																			
											<?php } ?>
										<?php } ?>
									<?php } ?>
									<?php if ($goods['refund_state'] != 0) {?>
										<p class="tkxqicon" style="padding-top:5px;">
											<a href="own_order.php?action=show_refund&sp_code=<?php echo $goods['sp_code']; ?>" style="text-decoration:underline;"><?php echo $lang['langRefundInfo']; ?></a>
										</p>
									<?php } ?>
								<?php } ?><!--操作结束2010/7/12-->
								<?php 
									if ($goods['score_say'] != '') { ?>
								<p class="<?php if ($goods['score_style'] == '2'){ echo 'scoreicon';}else{ echo 'scorecicon';} ?>"><?php echo $goods['score_say']; ?></p>
								<?php } ?>
								<?php 
									if ( $output['order_case'] == 'sold' ) { 
									/**
									 * 发货
									 */
									if($goods['sp_state'] == '1' && $goods['is_operate'] == '1'){ ?>
									<p class="fahuoicon"><a href="<?php echo $goods['state_info']['state_url']; ?>"><?php echo $lang['langOrderShipment']; ?></a></p>
								<?php } ?>
								<?php
										if ( $goods['sp_state'] != '1' && $goods['is_complaint'] == '0' && $goods['can_comp'] == '0' ) {
								?>
											<p class="tousuicon"><a href="own_complaint.php?action=complaint_buy&step=one&spid=<?php echo $goods['sp_id']; ?>" style="text-decoration:underline;"><?php echo $lang['langOrderComp']; ?></a></p>
								<?php
										}
									 } else if ( $output['order_case'] == 'bought' ) {
									 	if ( ($goods['sp_state'] == '1' || $goods['sp_state'] == '3') && $goods['is_complaint'] == '0' && $goods['can_comp'] == '0' ) {
								?>
											<p class="tousuicon"><a href="own_complaint.php?action=complaint_sell&step=one&spid=<?php echo $goods['sp_id']; ?>" style="text-decoration:underline;"><?php echo $lang['langOrderComp']; ?></a></p>
								<?php
									 	}
									 }
								?>
							</td>
						</tr>
						<tr class="tr-un-space-1">
							<td colspan="8"></td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="8">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php if($output['product_order_array'][0]['p_code'] != ''){ ?>
				<div class="page">
					<div class="pd-ck-right">
						<?php echo $output['page_list']; ?>
					</div>	
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>