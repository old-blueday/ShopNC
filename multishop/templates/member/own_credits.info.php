<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langCredits'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langCreditsExplainTitle']; ?></p></span></li>
					</ul>
				</div>
				<div class="info-1">
					<?php echo $lang['langCreditsExplain'];?>
					<img src="<?php echo TPL_DIR; ?>/images/wh.gif" align="absmiddle" /><a href="own_credits.php"><?php echo $lang['langCredits'];?></a>			
				</div>				
				<div class="z-mai-unite">
					<table cellspacing="0" cellpadding="0" border="0" class="unite-table-1 consie-table">
						<?php if ( !empty( $output['group_array'] ) && is_array( $output['group_array'] ) ) { ?>
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsClass']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2"><?php echo $list['mg_name']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsScoreLower']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2"><?php echo $list['mg_score_lower']; ?></td>
								<?php } ?>
							</tr>	
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsScoreHigher']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2"><?php echo $list['mg_score_higher']; ?></td>
								<?php } ?>
							</tr>	
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsStarNumber']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2"><?php echo $list['group_star']; ?></td>
								<?php } ?>
							</tr>	
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsIfBuy']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2">
										<?php if ( $list['mg_ifbuy'] == '0' ) { ?>
											<div class="sign-1" title="<?php echo $lang['langCreditsDeny']; ?>"></div>
										<?php } else { ?>
											<div class="sign-2" title="<?php echo $lang['langCreditsAllow']; ?>"></div>
										<?php } ?>
									</td>
								<?php } ?>
							</tr>	
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsIfSell']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2">
										<?php if ( $list['mg_ifsell'] == '0' ) { ?>
											<div class="sign-1" title="<?php echo $lang['langCreditsDeny']; ?>"></div>
										<?php } else { ?>
											<div class="sign-2" title="<?php echo $lang['langCreditsAllow']; ?>"></div>
										<?php } ?>
									</td>
								<?php } ?>
							</tr>		
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsIfOpenShop']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2">
										<?php if ( $list['mg_ifopen'] == '0' ) { ?>
											<div class="sign-1" title="<?php echo $lang['langCreditsDeny']; ?>"></div>
										<?php } else { ?>
											<div class="sign-2" title="<?php echo $lang['langCreditsAllow']; ?>"></div>
										<?php } ?>
									</td>
								<?php } ?>
							</tr>	
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsIfUseCredit']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2">
										<?php if ( $list['mg_ifuse_credit'] == '0' ) { ?>
											<div class="sign-1" title="<?php echo $lang['langCreditsDeny']; ?>"></div>
										<?php } else { ?>
											<div class="sign-2" title="<?php echo $lang['langCreditsAllow']; ?>"></div>
										<?php } ?>
									</td>
								<?php } ?>
							</tr>		
							<tr>
								<td class="td-bg-2"><?php echo $lang['langCreditsSellNum']; ?></td>
								<?php foreach ( $output['group_array'] as $list ) { ?>
									<td class="td-bg-2">
										<?php
											if ( $list['mg_sell_num'] == '0' ) {
												echo $lang['langCreditsNotLimit'];
											} else {
												echo $list['mg_sell_num'];
											}
										?>
									</td>
								<?php } ?>
							</tr>																																																				
						<?php } else { ?>
							<tr class="tr-not">
								<td><?php echo $lang['langCreditsNone']; ?></td>
							</tr>
						<?php } ?>
					</table>
				</div>
				<div class="page">
					<div style="float:left;padding-left:5px; margin-top:10px;"><b><?php echo $lang['langCreditsClass']; ?>:</b><?php echo $output['member_array']['group_name']; ?><span title="<?php echo $lang['langCreditsClass']; ?>"><?php echo $output['member_array']['group_star']; ?></span> <b><?php echo $lang['langCreditsExpAll']; ?>:</b><?php echo $output['member_array']['extcredits_exp']; ?> <b><?php echo $lang['langCreditsPointsAll']; ?>:</b><?php echo $output['member_array']['extcredits_points']; ?> </div>
				</div>				
			</div>
		</div>
	</div>
</div>