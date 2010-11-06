<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langHeadAuctionBaby'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langHeadAuctionBaby'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-1" style="width:35%;"><?php echo $lang['langPABabyName'];?></td>
							<td class="td-bg-4" style="width:25%;"><?php echo $lang['langPAContestBid'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPANumber'];?></td>
							<td class="td-bg-4" style="width:15%;"><?php echo $lang['langPAState'];?></td>
							<td class="td-bg-6" style="width:15%;"><?php echo $lang['langCOperation'];?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="7"></td>
						</tr>
						<?php if(!empty($output['bid_array']) && is_array($output['bid_array'])){ ?>
						<?php foreach($output['bid_array'] as $k => $v){ ?>
						<tr class="tr-un-blue">
							<td colspan="7">
								<span class="dt-1"></span>
								<span class="dt-2"><?php echo $lang['langPABidTime'];?>: <?php echo $v['cb_time'];?> </span>
							</td>
						</tr>
						<tr class="tr-un-conter-1">
							<td class="left-border tr-img" style="width:35%;">
							<span class="depott-span-1" style="text-align:left; padding-left:10px;">
								<a href="../home/product_countdown.php?action=view&pid=<?php echo $v['p_code'];?>" target="_blank">
									<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $v['p_pic'] ) ? $v['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $v['p_name']; ?>" title="<?php echo $v['p_name']; ?>"/>
								</a>								
							</span>
							<span class="mi-6-right" style="text-align:left;"><a href="../home/product_countdown.php?action=view&pid=<?php echo $v['p_code'];?>" target="_blank"><?php echo $v['p_name'];?></a> </span>
							</td>
							<td class="td-blod" style="width:25%;"><?php echo $v['cb_price'];?></td>
							<td class="td-blod" style="width:10%;" ><?php echo $v['cb_buy_number'];?></td>
							<td class="td-state left-right-bor" style="width:15%;"><?php echo $v['cb_state'];?></td>
							<td class="right-border" style="width:15%;"><a href="../home/product_countdown.php?action=view&pid=<?php echo $v['p_code'];?>" target="_blank"><?php echo $lang['langPAViewProduct'];?></a></td>
						</tr>
						<tr class="tr-un-space-1">
							<td colspan="7"></td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="7">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php if($output['bid_array'][0]['p_code'] != ''){ ?>
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