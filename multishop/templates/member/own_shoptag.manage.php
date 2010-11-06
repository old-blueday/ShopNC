<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langShopTagExplain']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopTagManage']; ?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_shoptag.php?action=add"><?php echo $lang['langShopAddTag']; ?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">		
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-6"><?php echo $lang['langShopTagName'];?></td>
							<td class="td-bg-6"><?php echo $lang['langShopTagSort'];?></td>
							<td class="td-bg-6"><?php echo $lang['langShopTagDisplay'];?></td>
							<td class="td-bg-6"><?php echo $lang['langShopTagUrlType'];?></td>
							<td class="td-bg-6"><?php echo $lang['langShopTagAddTime'];?></td>
							<td class="td-bg-7"><?php echo $lang['langShopTagOperation'];?></td>
						</tr>
						<?php if( !empty($output['tag_array']) && is_array($output['tag_array']) ) { ?>	
							<?php foreach($output['tag_array'] as $list ){ ?>
								<tr class="tr-un-conter-1">
									<td><a href="own_shoptag.php?action=edit&id=<?php echo $list['tag_id']; ?>"><?php echo $list['tag_name']; ?></a></td>
									<td><?php echo $list['tag_sort']; ?></td>
									<td><?php echo $list['tag_display']; ?></td>
									<td><?php echo $list['tag_link']; ?></td>
									<td><?php echo $list['tag_time']; ?></td>
									<td>
			  							<a href="own_shoptag.php?action=edit&id=<?php echo $list['tag_id']; ?>"><img src="<?php echo TPL_DIR; ?>/images/list-ck.gif" alt="<?php echo $lang['langCedit'];?>" title="<?php echo $lang['langCedit'];?>" border="0" /></a>			  
			  							<a href="javascript:void(null);" onclick=" if (confirm('<?php echo $lang['langShopTagDelConfirm'];?>')) window.location.href='own_shoptag.php?action=del&id=<?php echo $list['tag_id']; ?>'"><img src="<?php echo TPL_DIR; ?>/images/list-del.gif" alt="<?php echo $lang['langCdele'];?>" title="<?php echo $lang['langCdele'];?>" border="0" /></a>									
									</td>
								</tr>
							<?php } ?>		
						<?php } else { ?>
							<tr class="tr-not">
								<td colspan="6">
									<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
								</td>
							</tr>						
						<?php } ?>		
					</table>
				</div>
			</div>
		</div>
	</div>
</div>