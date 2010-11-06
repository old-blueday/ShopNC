<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langSeeShopMsg'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langSeeShopMsg'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTitle']; ?>:</td>
							<td class="cr-2"><?php echo $output['message_array']['title']; ?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMsgSendMember']; ?>:</td>
							<td class="cr-2">
								<?php
									if ( $output['message_array']['member_name'] == '0' ) {
										echo $lang['langShopSystem'];
									} else {
										echo $output['message_array']['member_name'];
									}
								?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopContent']; ?>:</td>
							<td class="cr-2">
								<?php echo $output['message_array']['content']; ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="an-1 bg-an">
					<?php if ( $output['message_genre'] == 'receive' && $output['message_array']['member_name'] != '0' ) { ?>
						<span class="buttom-comm">
							<input  name="" value="<?php echo $lang['langMsgReply']; ?>" type="button" onclick="window.location.href='own_message.php?action=re&messageid=<?php echo $output['message_array']['message_id']; ?>'" />
						</span>
					<?php } ?>
					<span class="buttom-comm">
						<input  name="" value="<?php echo $lang['langCReturn']; ?>" type="button" onclick="history.back()" />
					</span>
				</div>
			</div>
		</div>
	</div>
</div>