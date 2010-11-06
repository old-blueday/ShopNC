<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langProductAdd'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="cr-right">
					<div class="jixuf">
						<div class="jixuf-c">
							<ul>
								<?php if($output['url_sign'] == 'auction'){ ?>
									<li class="fa-1"><a href="own_product_auction.php?action=add&pc_id=<?php echo $output['slPCId'];?>"></a></li>
								<?php }elseif ($output['url_sign'] == 'group') { ?>
									<li class="fa-1"><a href="own_product_group.php?action=add&pc_id=<?php echo $output['slPCId'];?>"></a></li>
								<?php }elseif ($output['url_sign'] == 'countdown') { ?>
									<li class="fa-1"><a href="own_product_countdown.php?action=add&pc_id=<?php echo $output['slPCId'];?>"></a></li>
								<?php }else { ?>
									<li class="fa-1"><a href="own_product_fixprice.php?action=add&pc_id=<?php echo $output['slPCId'];?>"></a></li>
								<?php } ?>
								<li class="liu-1"><a href="<?php echo $output['url'];?>" target="_blank"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>