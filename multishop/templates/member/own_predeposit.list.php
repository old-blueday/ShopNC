<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPreList'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPreList'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-8 p-left-rio" style="width:10%"><?php echo $lang['langPreDetailUpdateTime'];?></td>
							<td class="td-bg-2" style="width:10%;"><?php echo $lang['langPreType'];?></td>
							<td class="td-bg-6" style="width:10%;"><?php echo $lang['langPreAvailableUpdate'];?></td>
							<td class="td-bg-6" style="width:10%;"><?php echo $lang['langPreFreezeUpdate'];?></td>
							<td class="td-bg-6" style="width:10%;"><?php echo $lang['langPreState'];?></td>
							<td class="td-bg-7" style="width:10%;"><?php echo $lang['langPreAction'];?></td>
						</tr>
						<?php if(!empty($output['predeposit_array']) && is_array($output['predeposit_array'])){ ?>
						<?php foreach($output['predeposit_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-2">
							<td class="p-left-rio" style="width:10%;"><?php echo $v['update_time'];?></td>
							<td style="width:10%;"><?php echo $output['detail_type'][$v['predeposit_type']];?></td>
							<td style="width:10%;"><?php echo $v['available_amount'];?></td>
							<td style="width:10%;"><?php echo $v['freeze_amount'];?></td>
							<td style="width:10%;"><?php echo $output['detail_state'][$v['predeposit_state']];?></td>
							<td style="width:10%;"><p class="viewicon" style="margin-left:40px;"><a href="own_predeposit.php?action=detail_view&id=<?php echo $v['predeposit_id'];?>"><?php echo $lang['langPreView'];?></a></p></td>
						</tr>
						<?php } ?>
						<?php } ?>
						<tr class="tr-not">
							<td colspan="7"><?php echo $lang['langPreMemberAvailable'];?>: <?php echo $output['member_array']['available_predeposit']?$output['member_array']['available_predeposit']:'0';?></td>
						</tr>
					</table>
				</div>
				<?php if(!empty($output['predeposit_array']) && is_array($output['predeposit_array'])){ ?>
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