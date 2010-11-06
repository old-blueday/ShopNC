<script language="javascript">
function getUserScore(t) {
	var h = '';
	if (t == '') {
		h = 'own_score.php?genre=<?php echo $output['genre']; ?>#genre';
	}
	if (t == '1') {
		h = 'own_score.php?genre=<?php echo $output['genre']; ?>&score=1';
	}
	if (t == '0') {
		h = 'own_score.php?genre=<?php echo $output['genre']; ?>&score=0';
	}
	if (t == '-1') {
		h = 'own_score.php?genre=<?php echo $output['genre']; ?>&score=-1';
	}
	window.location.href = h+'&time=<?php echo $output['time']; ?>#genre';
}
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langScoreSaleReputably']; ?>:<?php echo $output['sell_sta']['good_percent']; ?> <?php echo $lang['langScoreBuyReputably']; ?>:<?php echo $output['buy_sta']['good_percent']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langStoreManage']; ?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">		
					<!--卖家信用-->
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-conter-5 bg-bozhi">
							<td colspan="6">
								<span class="s-bg-zhi-1 "><?php echo $lang['langScoreSaleCredit'];?>:<?php echo empty($output['member_array']['sale_score']) ? 0 : $output['member_array']['sale_score']; ?>
								<?php if ( is_array( $output['sell_score_level']['median'] ) ) { ?>
									<?php foreach ( $output['sell_score_level']['median'] as $list ) { ?>
										<?php if ( $output['sell_score_level']['level'] == '0' ) { ?>
											<img title="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_1.gif" alt="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
										<?php } ?>
										<?php if ( $output['sell_score_level']['level'] == '1' ) { ?>
											<img title="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_2.gif" alt="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
										<?php } ?>	
										<?php if ( $output['sell_score_level']['level'] == '2' ) { ?>
											<img title="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_3.gif" alt="<?php echo $output['sell_score_level']['interval']['one']?>－<?php echo $output['sell_score_level']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
										<?php } ?>																				
									<?php } ?>
								<?php } ?></span>		
								<span class="s-bg-zhi-2"><?php echo $lang['langScoreSaleReputably']; ?>:<strong><?php echo $output['sell_sta']['good_percent']; ?></strong></span>							</td>
						</tr>
						<tr class="tr-un-conter-5 tr-td-color">
							<td></td>
							<td><?php echo $lang['langScoreLatelyOneWeek'];?></td>
							<td><?php echo $lang['langScoreLatelyOneMonth'];?></td>
							<td><?php echo $lang['langScoreLatelySixMonth'];?></td>
							<td><?php echo $lang['langScoreSixMonthFormer'];?></td>
							<td><?php echo $lang['langScoreTotalize'];?></td>
						</tr>
						<tr class="tr-un-conter-5">
							<td>
								<img src="<?php echo TPL_DIR; ?>/images/pj_040924_01.gif" align="absmiddle" />
								<?php echo $lang['langScoreReputably'];?>
							</td>
							<td><a href="own_score.php?genre=s&score=1&time=week"><?php echo $output['sell_sta']['one_week_good']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=1&time=month"><?php echo $output['sell_sta']['one_month_good']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=1&time=six_month"><?php echo $output['sell_sta']['six_month_good']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=1&time=former_six_month"><?php echo $output['sell_sta']['former_six_month_good']; ?></a></td>
							<td><?php echo $output['sell_sta']['six_month_good']+$output['sell_sta']['former_six_month_good']; ?></td>
						</tr>	
						<tr class="tr-un-conter-5">
							<td>
								<img src="<?php echo TPL_DIR; ?>/images/pj_040924_03.gif" align="absmiddle" />
								<?php echo $lang['langScoreMiddlingReputably'];?>
							</td>
							<td><a href="own_score.php?genre=s&score=0&time=week"><?php echo $output['sell_sta']['one_week_normal']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=0&time=month"><?php echo $output['sell_sta']['one_month_normal']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=0&time=six_month"><?php echo $output['sell_sta']['six_month_normal']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=0&time=former_six_month"><?php echo $output['sell_sta']['former_six_month_normal']; ?></a></td>
							<td><?php echo $output['sell_sta']['six_month_normal']+$output['sell_sta']['former_six_month_normal']; ?></td>							
						</tr>	
						<tr class="tr-un-conter-5">
							<td>
								<img src="<?php echo TPL_DIR; ?>/images/pj_040924_02.gif" align="absmiddle" />
								<?php echo $lang['langScoreDifferenceReputably'];?>
							</td>
							<td><a href="own_score.php?genre=s&score=-1&time=week"><?php echo $output['sell_sta']['one_week_bad']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=-1&time=month"><?php echo $output['sell_sta']['one_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=-1&time=six_month"><?php echo $output['sell_sta']['six_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=s&score=-1&time=former_six_month"><?php echo $output['sell_sta']['former_six_month_bad']; ?></a></td>
							<td><?php echo $output['sell_sta']['six_month_bad']+$output['sell_sta']['former_six_month_bad']; ?></td>									
						</tr>	
						<tr class="tr-un-conter-5">
							<td><?php echo $lang['langScoreTotalize'];?></td>
							<td><a href="own_score.php?genre=s&time=week"><?php echo $output['sell_sta']['one_week_good']+$output['sell_sta']['one_week_normal']+$output['sell_sta']['one_week_bad']; ?></a></td>
							<td><a href="own_score.php?genre=s&time=month"><?php echo $output['sell_sta']['one_month_good']+$output['sell_sta']['one_month_normal']+$output['sell_sta']['one_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=s&time=six_month"><?php echo $output['sell_sta']['six_month_good']+$output['sell_sta']['six_month_normal']+$output['sell_sta']['six_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=s&time=former_six_month"><?php echo $output['sell_sta']['former_six_month_good']+$output['sell_sta']['former_six_month_normal']+$output['sell_sta']['former_six_month_bad']; ?></a></td>
							<td><?php echo $output['sell_sta']['six_month_good']+$output['sell_sta']['former_six_month_good']+$output['sell_sta']['six_month_normal']+$output['sell_sta']['former_six_month_normal']+$output['sell_sta']['six_month_bad']+$output['sell_sta']['former_six_month_bad']; ?></td>								
						</tr>																			
					</table>
					<!--买家信用-->
					<table class="unite-table-1 unite-table-b" style=" margin-top:3px;"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-conter-5 bg-bozhi">
							<td colspan="6">
								<span class="s-bg-zhi-3"><?php echo $lang['langScoreBuyCredit'];?>:<?php echo empty($output['member_array']['buy_score']) ? 0 : $output['member_array']['buy_score']; ?>
								<?php if ( is_array( $output['buy_sale_score']['median'] ) ) { ?>
									<?php foreach ( $output['buy_sale_score']['median'] as $list ) { ?>
										<?php if ( $output['buy_sale_score']['level'] == '0' ) { ?>
											<img title="<?php echo $output['buy_sale_score']['interval']['one']?>－<?php echo $output['buy_sale_score']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_1.gif" alt="<?php echo $output['buy_sale_score']['interval']['one']?>－<?php echo $output['buy_sale_score']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
										<?php } ?>
										<?php if ( $output['buy_sale_score']['level'] == '1' ) { ?>
											<img title="<?php echo $output['buy_sale_score']['interval']['one']?>－<?php echo $output['buy_sale_score']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_2.gif" alt="<?php echo $output['buy_sale_score']['interval']['one']?>－<?php echo $output['buy_sale_score']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
										<?php } ?>	
										<?php if ( $output['buy_sale_score']['level'] == '2' ) { ?>
											<img title="<?php echo $output['buy_sale_score']['interval']['one']?>－<?php echo $output['buy_sale_score']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" src="<?php echo TPL_DIR; ?>/images/b_red_3.gif" alt="<?php echo $output['buy_sale_score']['interval']['one']?>－<?php echo $output['buy_sale_score']['interval']['two']?><?php echo $lang['langStoreIntegralLook']; ?>" align="absmiddle">
										<?php } ?>																				
									<?php } ?>
								<?php } ?></span>		
								<span class="s-bg-zhi-2"><?php echo $lang['langScoreBuyReputably']; ?>:<strong><?php echo $output['buy_sta']['good_percent']; ?></strong></span>							</td>
						</tr>
						<tr class="tr-un-conter-5 tr-td-color">
							<td></td>
							<td><?php echo $lang['langScoreLatelyOneWeek'];?></td>
							<td><?php echo $lang['langScoreLatelyOneMonth'];?></td>
							<td><?php echo $lang['langScoreLatelySixMonth'];?></td>
							<td><?php echo $lang['langScoreSixMonthFormer'];?></td>
							<td><?php echo $lang['langScoreTotalize'];?></td>
						</tr>
						<tr class="tr-un-conter-5">
							<td>
								<img src="<?php echo TPL_DIR; ?>/images/pj_040924_01.gif" align="absmiddle" />
								<?php echo $lang['langScoreReputably'];?>
							</td>
							<td><a href="own_score.php?genre=b&score=1&time=week"><?php echo $output['buy_sta']['one_week_good']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=1&time=month"><?php echo $output['buy_sta']['one_month_good']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=1&time=six_month"><?php echo $output['buy_sta']['six_month_good']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=1&time=former_six_month"><?php echo $output['buy_sta']['former_six_month_good']; ?></a></td>
							<td><?php echo $output['buy_sta']['six_month_good']+$output['buy_sta']['former_six_month_good']; ?></td>
						</tr>	
						<tr class="tr-un-conter-5">
							<td>
								<img src="<?php echo TPL_DIR; ?>/images/pj_040924_03.gif" align="absmiddle" />
								<?php echo $lang['langScoreMiddlingReputably'];?>
							</td>
							<td><a href="own_score.php?genre=b&score=0&time=week"><?php echo $output['buy_sta']['one_week_normal']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=0&time=month"><?php echo $output['buy_sta']['one_month_normal']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=0&time=six_month"><?php echo $output['buy_sta']['six_month_normal']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=0&time=former_six_month"><?php echo $output['buy_sta']['former_six_month_normal']; ?></a></td>
							<td><?php echo $output['buy_sta']['six_month_normal']+$output['buy_sta']['former_six_month_normal']; ?></td>							
						</tr>	
						<tr class="tr-un-conter-5">
							<td>
								<img src="<?php echo TPL_DIR; ?>/images/pj_040924_02.gif" align="absmiddle" />
								<?php echo $lang['langScoreDifferenceReputably'];?>
							</td>
							<td><a href="own_score.php?genre=b&score=-1&time=week"><?php echo $output['buy_sta']['one_week_bad']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=-1&time=month"><?php echo $output['buy_sta']['one_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=-1&time=six_month"><?php echo $output['buy_sta']['six_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=b&score=-1&time=former_six_month"><?php echo $output['buy_sta']['former_six_month_bad']; ?></a></td>
							<td><?php echo $output['buy_sta']['six_month_bad']+$output['buy_sta']['former_six_month_bad']; ?></td>									
						</tr>	
						<tr class="tr-un-conter-5">
							<td><?php echo $lang['langScoreTotalize'];?></td>
							<td><a href="own_score.php?genre=b&time=week"><?php echo $output['buy_sta']['one_week_good']+$output['buy_sta']['one_week_normal']+$output['buy_sta']['one_week_bad']; ?></a></td>
							<td><a href="own_score.php?genre=b&time=month"><?php echo $output['buy_sta']['one_month_good']+$output['buy_sta']['one_month_normal']+$output['buy_sta']['one_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=b&time=six_month"><?php echo $output['buy_sta']['six_month_good']+$output['buy_sta']['six_month_normal']+$output['buy_sta']['six_month_bad']; ?></a></td>
							<td><a href="own_score.php?genre=b&time=former_six_month"><?php echo $output['buy_sta']['former_six_month_good']+$output['buy_sta']['former_six_month_normal']+$output['buy_sta']['former_six_month_bad']; ?></a></td>
							<td><?php echo $output['buy_sta']['six_month_good']+$output['buy_sta']['former_six_month_good']+$output['buy_sta']['six_month_normal']+$output['buy_sta']['former_six_month_normal']+$output['buy_sta']['six_month_bad']+$output['buy_sta']['former_six_month_bad']; ?></td>								
						</tr>																			
					</table>		
				</div>
				<div class="nav" style=" margin-top:3px">
					<ul>
						<?php if ( $output['time'] != '' ) { ?>
							<li class="nav-bg"><b></b><span><p>
								<?php echo $output['time']; ?><?php echo $lang['langScoreFrom']; ?><?php echo $output['genre_type']; ?><?php echo $lang['langScoreText']; ?><?php echo $output['score_type']; ?>
							</p></span></li>
						<?php } ?>
						<!--来自买家的评价-->
						<?php if ( $output['genre'] == 's' && $output['time'] == '' ) { ?>
							<li class="nav-bg">
						<?php } else if ( $output['time'] == '' ) { ?>
							<li class="nav-bg-1">
						<?php } else {?>
							<li class="nav-bg-1 nav-left">
						<?php } ?>
							<b></b><span><p><a href="own_score.php?genre=s#genre"><?php echo $lang['langScoreBuyAppraise']; ?></a></p></span></li>
						<!--来自卖家的评价-->
						<?php if ( $output['genre'] == 'b' && $output['time'] == '' ) { ?>
							<li class="nav-bg nav-left">
						<?php } else { ?>
							<li class="nav-bg-1 nav-left">
						<?php } ?>
							<b></b><span><p><a href="own_score.php?genre=b#genre"><?php echo $lang['langScoreSaleAppraise']; ?></a></p></span></li>	
						<!--给他人的评价-->
						<?php if ( $output['genre'] == 'set' && $output['time'] == '' ) { ?>
							<li class="nav-bg nav-left">
						<?php } else { ?>
							<li class="nav-bg-1 nav-left">
						<?php } ?>
							<b></b><span><p><a href="own_score.php?genre=set#genre"><?php echo $lang['langScoreOtherAppraise']; ?></a></p></span></li>													
					</ul>
				</div>	
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-gray">
							<td class="right-p" colspan="4">
								<select name="score_act" id="score_act" onchange="return getUserScore(this.value)">
									<option value="" <?php if ( $output['score']  == '') { echo "selected"; }?>><?php echo $lang['langScore']; ?></option>
									<option value="1" <?php if ( $output['score']  == '1') { echo "selected"; }?>><?php echo $lang['langScoreReputably']; ?></option>
									<option value="0" <?php if ( $output['score']  == '0') { echo "selected"; }?>><?php echo $lang['langScoreMiddlingReputably']; ?></option>
									<option value="-1" <?php if ( $output['score']  == '-1') { echo "selected"; }?>><?php echo $lang['langScoreDifferenceReputably']; ?></option>
								</select>									
							</td>
						</tr>
						<tr class="tr-un-space"><td></td></tr>
						<tr class="tr-un-bg-1">
							<td class="td-bg-5"></td>
							<td class="td-bg-1"><?php echo $lang['langScoreContent']; ?></td>
							<td class="td-bg-5"><?php echo $lang['langSetScore']; ?></td>
							<td class="td-bg-7"><?php echo $lang['langScoreProductInfo']; ?></td>
						</tr>
						<?php if ( !empty( $output['score_array'] ) && is_array( $output['score_array'] ) ) { ?>
							<?php foreach ( $output['score_array'] as $list ) { ?>
								<tr class="tr-un-conter-1">
									<td>
										<?php if ( $list['score'] == '1' ) { ?>
											<span><img src="<?php echo TPL_DIR; ?>/images/pj_040924_01.gif" alt="<?php echo $lang['langScoreReputably']; ?>" /></span>
										<?php } ?>
										<?php if ( $list['score'] == '0' ) { ?>
											<span><img src="<?php echo TPL_DIR; ?>/images/pj_040924_03.gif" alt="<?php echo $lang['langScoreReputably']; ?>" /></span>
										<?php } ?>		
										<?php if ( $list['score'] == '-1' ) { ?>
											<span><img src="<?php echo TPL_DIR; ?>/images/pj_040924_02.gif" alt="<?php echo $lang['langScoreReputably']; ?>" /></span>
										<?php } ?>																			
									</td>
									<td><?php echo $list['content']; ?>&nbsp;&nbsp;&nbsp;<br />[<?php echo $list['pubtime']; ?>]</td>
									<td>
										<?php
											if ( $list['genre'] == 's' ) {
												echo $lang['langSetScoreByBuyer'];
											}
											if ( $list['genre'] == 'b' ) {
												echo $lang['langSetScoreBySeller'];
											}											
										?>:
										<a href="<?php echo SITE_URL; ?>/store/index.php?userid=<?php echo $list['member_id']; ?>" target="_blank"><?php echo $list['member_name']; ?></a>
									</td>
									<td>
										<?php if ( $list['html_url'] != '' ) { ?>
											<a href="<?php echo $list['html_url']; ?>" target="_blank"><?php echo $list['p_name']; ?></a>
										<?} else { ?>
											<a href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['p_code']; ?>" target="_blank"><?php echo $list['p_name']; ?></a>
										<?php } ?>	
										<br/>
										<?php echo $list['unit_price']; ?><?php echo $lang['langCYuan']; ?>
									</td>
								</tr>
							<?php } ?>
						<?php } else { ?>
							<tr class="tr-not">
								<td colspan="4">
									<div class="tr_not_div"><?php echo $lang['langScoreTransitorilyNotMessage']; ?></div>
								</td>
							</tr>						
						<?php } ?>
					</table>					
				<?php if( !empty( $output['score_array'] ) && is_array( $output['score_array'] ) ){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['pagelist']; ?>
						</div>	
					</div>	
				<?php } ?>						
			</div>
		</div>
	</div>
</div>