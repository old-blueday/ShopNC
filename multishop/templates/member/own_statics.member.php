<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-2"><p><?php echo $lang['langOwnStaticsMember'];?></p>
				</div>
				<div class="bg-sj"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langOwnStaticsMember'];?></p></span></li>
					</ul>
				</div>
				<div class="st-1 publico">
				<table width="100%" border="0" cellpadding="0">
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsSellerSum'];?>:</p></td><td colspan="3"><?php echo $output['buyer_num']?$output['buyer_num']:'0';?><?php echo $lang['langOwnStaticsRen'];?></td>
					</tr>
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsMemberMostBuy'];?>:</p></td>
						<td>
							<?php echo $output['most_buy_member']['login_name']?$output['most_buy_member']['login_name']:$lang['langCNot'];?>
						</td>
						<td>
							<?php echo $output['most_buy_num']?$output['most_buy_num']:'0';?><?php echo $lang['langOwnStaticsCi'];?>
						</td>
						<td>
							<?php if($output['most_buy_member']['login_name'] != ''){?>
							<a href="own_order.php?action=sold&buyer_nick=<?php echo $output['most_buy_member']['login_name'];?>"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td class="p-180"><p><?php echo $lang['langOwnStaticsMemberAachieveMostBuy'];?>:</p></td>
						<td>
							<?php echo $output['achieve_most_buy_member']['login_name']?$output['achieve_most_buy_member']['login_name']:$lang['langCNot'];?>
						</td>
						<td>
							<?php echo $output['achieve_most_buy_num']?$output['achieve_most_buy_num']:'0';?><?php echo $lang['langOwnStaticsCi'];?>
						</td>
						<td width="10%;">
							<?php if($output['achieve_most_buy_member']['login_name'] != ''){?>
							<a href="own_order.php?action=sold&buyer_nick=<?php echo $output['achieve_most_buy_member']['login_name'];?>"><img src="<?php echo TPL_DIR;?>/images/st-1.gif" /></a>
							<?php }?>
						</td>
					</tr>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>