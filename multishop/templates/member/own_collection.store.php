<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langCollShop'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href='own_collection.php?genre=product'><?php echo $lang['langMyStow'];?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langCollShop'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td width="10%"><?php echo $output['langCollShopIco']; ?></td>
							<td width="45%"><?php echo $output['langCollShopName']; ?></td>
							<td width="25%"><?php echo $output['langCollShopkeeper']; ?></td>
							<td width="15%"><?php echo $output['langCOperation']; ?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="4"></td>
						</tr>
						<?php if(!empty($output['collection_array']) && is_array($output['collection_array'])){ ?>
						<?php foreach($output['collection_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-3">
							<td class="td-bg-2">
								<a href="../store/index.php?userid=<?php echo $v['member_id'];?>" target="_blank"><img src="<?php echo empty($v['shop_pic'])? '../templates/'.$output['templatesname'].'/home/images/images_new/storepic_default.gif' : '../'.$v['shop_pic']; ?>" /></a>
							</td>
							<td class="td-bg-7" style="width:45%;text-align:left; padding-left:10px;">
								<a href="../store/index.php?userid=<?php echo $v['member_id'];?>" target="_blank"><?php echo $v['shop_name'];?></a>
							</td>
							<td class="td-bg-9" style="width:25%; text-align:left; padding-left:10px;">
								<?php echo $lang['langCollShopkeeper']; ?>:&nbsp;<a href="../store/index.php?userid=<?php echo $v['member_id'];?>" target="_blank"><?php echo $v['login_name'];?></a>
							</td>
							<td class="td-bg-6 "style="width:15%;">
								<a href="?action=delete&genre=store&collectionid=<?php echo $v['collection_id']; ?>"><?php echo $lang['langCdele'] ?></a>
							</td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="5">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div></td>
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