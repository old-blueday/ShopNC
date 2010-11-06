<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langMyStow'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langMyStow'];?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href='own_collection.php?genre=store'><?php echo $lang['langCollShop'];?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td width="10%"><?php echo $output['langCollBabyIco']; ?></td>
							<td width="40%"><?php echo $output['langCollBabyName']; ?></td>
							<td width="20%"><?php echo $output['langCollBabyPrice']; ?></td>
							<td width="20%"><?php echo $output['langCollShopkeeper']; ?></td>
							<td width="10%"><?php echo $output['langCOperation']; ?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="5"></td>
						</tr>
						<?php if(!empty($output['collection_array']) && is_array($output['collection_array'])){ ?>
									<?php foreach($output['collection_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-3">
							<td class="td-bg-2" style="width:10px; text-align:left; padding-left:10px;">
								<a href="../home/product.php?action=view&pid=<?php echo $v['p_code'];?>" target="_blank"><img src="<?php echo empty($v['p_pic']) ? '../templates/'.$output['templatesname'].'/images/noimgb.gif' : '../'.$v['p_pic']; ?>" /></a>
							</td>
							<td class="td-bg-1" style="text-align:left; padding-left:10px;">
								<a href="../home/product.php?action=view&pid=<?php echo $v['p_code'];?>" target="_blank"><?php echo $v['p_name'];?></a>
							</td>
							<td class="td-bg-9" style="text-align:left; padding-left:10px;">
								<?php echo $v['p_sell_type'];?>&nbsp;<b><?php echo $v['p_price'];?></b><?php echo $lang['langCYuan'];?>
							</td>
							<td class="td-bg-9" style="text-align:left; padding-left:10px;">
								<?php echo $lang['langCollShopkeeper']; ?>&nbsp;<a href="../store/index.php?userid=<?php echo $v['member_id'];?>" target="_blank"><?php echo $v['login_name'];?></a>
							</td>
							<td class="td-bg-7" style="text-align:left; padding-left:15px;">
								<a href="?action=delete&genre=product&collectionid=<?php echo $v['collection_id']; ?>"><?php echo $lang['langCdele'] ?></a>
							</td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="5">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php if($output['collection_array'][0]['collection_id'] != ''){ ?>
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