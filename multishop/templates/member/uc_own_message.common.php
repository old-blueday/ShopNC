<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langMsgCommon'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
                        <li class="nav-bg-1"><b></b><span><p><a href="own_message.php?action=newpm"><?php echo $lang['langMsgNew'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=private"><?php echo $lang['langMsgPrivate'];?></a></p></span></li>
                        <li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=system"><?php echo $lang['langMsgSystem'];?></a></p></span></li>
                        <li class="nav-bg nav-left"><b></b><span><p><a href="own_message.php?action=common"><?php echo $lang['langMsgCommon']; ?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=add"><?php echo $lang['langShopSendMessage'];?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<form action="own_message.php?action=del&genre=<?php echo $output['message_genre']; ?>" method="post" onsubmit="return checkForm('<?php echo $lang['langCConfirmDelete']; ?>','<?php echo $lang['langCNoSelect']; ?>');">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-3"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-4"><?php echo $lang['langShopState'];?></td>
							<td class="td-bg-1"><?php echo $lang['langShopTitle'];?></td>
							<td class="td-bg-4">
								<?php
									if ( $output['action'] == 'uc_sendbox' ) {
										echo $lang['langShopReceiveMan'];
									} else {
										echo $lang['langShopMessageFrom'];
									}
								?>
							</td>
							<td class="td-bg-7"><?php echo $lang['langShopSendTime'];?></td>
						</tr>
						<?php if(!empty($output['message_array']) && is_array($output['message_array'])){ ?>
							<?php foreach($output['message_array'] as $list){ ?>
								<tr class="tr-un-conter-1">
									<td>
											<input name="messageid[]" type="checkbox" id="messageid" value="<?php echo $list['pmid']; ?>" />
									</td>
									<td>
										<?php
											if ( $list['new'] == '1' ) {
												echo $lang['langShopNotRead'];
											}
											if ( $list['new'] == '0' ) {
												echo $lang['langShopRead'];
											}
										?>
									</td>
									<td>
                                        <?php if($list['touid']){?>
										<a href="own_message.php?action=show&pmid=<?php echo $list['pmid']; ?>&touid=<?php echo $list['touid']; ?>&daterange=<?php echo $list['daterange']; ?>"><?php echo $list['subject'] ? $list['subject'] : $list['message']; ?></a>
                                        <?php }else{ ?>
                                        <a href="own_message.php?action=show&pmid=<?php echo $list['pmid']; ?>"><?php echo $list['subject'] ? $list['subject'] : $list['message']; ?></a>
                                        <?php } ?>
									</td>
									<td>
                                        <a href="own_message.php?action=system"><img src="../templates/member/images/systempm.gif" /><br/><?php echo $lang['langMsgSystem']; ?></a>
									</td>
									<td><?php echo $list['send_time'];?></td>
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
					<?php if(!empty($output['message_array']) && is_array($output['message_array'])){ ?>
						<div class="handle">
							<ul class="depot-ul depot-ul-li-2">
								<!-- 全选/反选 -->
								<li class="depot-li-te"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?></a></li>
								<!-- 删除 -->
								<li><span class="span-button"><input type="submit" name="Submit" value="<?php echo $lang['langCdele']; ?>" /></span></li>
								<!-- 清空 -->
						 	</ul>
						</div>
					<?php } ?>
					</form>
				</div>
				<?php

				?>
				<?php if(!empty($output['message_array']) && is_array($output['message_array'])){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['message_pagelist']; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>