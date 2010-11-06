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
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langCredits'];?></p></span></li>
					</ul>
				</div>
				<div class="info-1">
					<?php echo $lang['langCreditsExplain'];?>
					<img src="<?php echo TPL_DIR; ?>/images/wh.gif" align="absmiddle" /><a href="own_credits.php?action=info"><?php echo $lang['langCreditsDescription'];?></a>			
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
						<td class="td-bg-11" style="width:30%;"><?php echo $lang['langCreditsContent'];?></td>
						<td class="td-bg-8" style="width:20%;"><?php echo $lang['langCreditsExp'];?></td>
						<td class="td-bg-9" style="width:20%;"><?php echo $lang['langCreditsPoints'];?></td>
						<td class="td-bg-7" style="width:20%;"><?php echo $lang['langCreditsTime'];?></td>
						</tr>
						<?php if(!empty($output['log_list']) && is_array($output['log_list'])){ ?>
						<?php foreach($output['log_list'] as $list){ ?>
						<tr class="tr-un-conter-2">
						<td style="width:30%;"><?php echo $list['cl_content'];?></td>
						<td style="width:20%;"><?php echo $list['cl_exp'];?></td>
						<td style="width:20%;"><?php echo $list['cl_points'];?></td>
						<td style="width:20%;"><?php echo $list['cl_time'];?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr><td><?php echo $lang['langCreditsNone']; ?></td></tr>
						<?php } ?>
					</table>
				</div>				
				<!--<div class="consie">
					<table class="consie-table" border="0" cellpadding="0">
						<tr class="consie-tr-1">
							<td class="consie-td-2 consie-se left-pd"><?php echo $lang['langCreditsContent'];?></td>
							<td class="consie-td-6 consie-se"><?php echo $lang['langCreditsExp'];?></td>
							<td class="consie-td-5 consie-se"><?php echo $lang['langCreditsPoints'];?></td>
							<td class="consie-td-7 consie-se"><?php echo $lang['langCreditsTime'];?></td>
						</tr>
						<?php if(!empty($output['log_list']) && is_array($output['log_list'])){ ?>
							<?php foreach($output['log_list'] as $list){ ?>
								<tr>
									<td class="consie-td-1"><?php echo $list['cl_content'];?></td>
									<td class="consie-td-6"><?php echo $list['cl_exp'];?></td>
									<td class="consie-td-5"><?php echo $list['cl_points'];?></td>
									<td class="consie-td-6"><?php echo $list['cl_time'];?></td>
								</tr>
							<?php } ?>
						<?php } else { ?>
							<tr><td colspan="4" style="text-align:center;"><?php echo $lang['langCreditsNone']; ?></td></tr>
						<?php } ?>
					</table>
				</div>-->
				<div class="page">
					<div style="float:left;padding-left:5px; margin-top:10px;">
						<b><?php echo $lang['langCreditsClass']; ?>:</b> <?php echo $output['member_array']['group_name']; ?> <span title="<?php echo $lang['langCreditsClass']; ?>"><?php echo $output['member_array']['group_star']; ?></span> <b><?php echo $lang['langCreditsExpAll']; ?>: </b><?php echo $output['member_array']['extcredits_exp']; ?> <b><?php echo $lang['langCreditsPointsAll']; ?>: </b><?php echo $output['member_array']['extcredits_points']; ?> 
					</div>
					<?php if(!empty($output['log_list']) && is_array($output['log_list'])){ ?>
						<div class="pd-ck-right">
							<?php echo $output['page_list']; ?>
						</div>	
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>