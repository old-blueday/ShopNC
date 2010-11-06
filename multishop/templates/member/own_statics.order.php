<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langOwnStaticsOrder'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><span><b></b><p><?php echo $lang['langOwnStaticsOrder'];?></p></span></li>
					</ul>
				</div>
				<div class="st-1 publico">
				<table width="100%" border="0" cellpadding="0">
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderSum'];?>:</p></td>
						<td colspan="4"><?php echo $output['order_total']?$output['order_total']:'0';?></td>
						<td><a href="own_order.php?action=sold"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
					</tr>
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateZero'];?>:</p></td>
						<td><?php echo $output['order_state_zero']?$output['order_state_zero']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=0"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateOne'];?>:</p></td>
						<td><?php echo $output['order_state_one']?$output['order_state_one']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=1"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
					</tr>
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateTwo'];?>:</p></td>
						<td><?php echo $output['order_state_two']?$output['order_state_two']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=2"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateThree'];?>:</p></td>
						<td><?php echo $output['order_state_three']?$output['order_state_three']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=3"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
					</tr>
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateFour'];?>:</p></td>
						<td><?php echo $output['order_state_four']?$output['order_state_four']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=4"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateFive'];?>:</p></td>
						<td><?php echo $output['order_state_five']?$output['order_state_five']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=5"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
					</tr>
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsOrderStateSix'];?>:</p></td>
						<td><?php echo $output['order_state_six']?$output['order_state_six']:'0';?></td>
						<td><a href="own_order.php?action=sold&order_state=6"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a></td>
						<td class="p-180"></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>