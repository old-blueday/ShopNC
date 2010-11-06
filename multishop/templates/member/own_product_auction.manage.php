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
							<td class="td-bg-1" style="width:20%;"><?php echo $lang['langPABabyName'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPAContestBid'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPAMentalityPrice'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPANumber'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPAGetCount'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPATotalPrices'];?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPAState'];?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="7"></td>
						</tr>
						<?php if(!empty($output['auction_list']) && is_array($output['auction_list'])){ ?>
						<?php foreach($output['auction_list'] as $k => $v){ ?>
						<tr class="tr-un-blue">
							<td colspan="7">
								<span class="dt-1"></span>
								<span class="dt-2"><?php echo $lang['langPABidTime'];?>: <?php echo $v['bid_time'];?> </span>
							</td>
						</tr>
						<tr class="tr-un-conter-1">
							<td class="left-border tr-img" style=" width:20%;text-align:left; padding-left:10px;">
							<!--<span class="depott-span-1">
								<a href="../home/product.php?action=view&pid=<?php echo $v['product']['p_code'];?>" target="_blank">
									<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $v['product']['p_pic'] ) ? $v['product']['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $v['product']['p_name']; ?>" title="<?php echo $v['product']['p_name']; ?>"/>
								</a>								
							</span>-->
							<span class="mi-6-right"><a href="../home/product_auction.php?action=view&p_code=<?php echo $v['bid_p_code'];?>" target="_blank"><?php echo $v['bid_p_name'];?></a></span>
							</td>
							<td class="td-blod" width="10%"><?php echo $v['bid_price'];?></td>
							<td class="td-blod"width="10%"><?php echo $v['bid_max_price'];?></td>
							<td class="td-blod"width="10%"><?php echo $v['bid_count'];?></td>
							<td class="td-blod"width="10%"><?php echo $v['bid_get_count'];?></td>
							<td class="left-right-bor" style="width:10%"><?php echo $v['bid_total_price'];?></td>
							<td class="td-bg-4 right-border" style="width:10%"><?php echo $v['bid_state'];?></td>
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
				<?php if($output['auction_list'][0]['product']['p_code'] != ''){ ?>
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