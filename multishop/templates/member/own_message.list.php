<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
<style>
#SpaceStatusChart_wai{
width:270px;height:25px;
margin-left:5px;
margin-top:6px;
float:left;
position:relative;
}
#SpaceStatusChart{
	height:20px;
	border:1px solid #AAA;
	float:right;
	background-color:#fff;
	display:block;
	width:100%;
	position:absolute;
	left:0px;
	top:0px;
}#SpaceStatusChart1{
	height:20px;
	float:right;
	background-color:#43BCDE;
	display:block;
	width:<?php echo $output['message_percent']; ?>%;
	position:absolute;
	left:0px;
	top:0px;
}
</style>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p style=" display:block; float:left; clear:both;">
						<?php echo $lang['langShopSpaceUse']; ?>：
					      <div  id="SpaceStatusChart_wai">
					          <div id="SpaceStatusChart"></div>
					        <div id="SpaceStatusChart1"></div>
					      </div>
				        <?php if ( $output['message_genre'] == 'receive' ) { ?>
				        	<span style="float:right; padding-top:10px; padding-right:5px;"><?php echo $lang['langShopSpaceUse']; echo !empty($output['message_num']) ? $output['message_num'] : 0; ?>/200</span>
				        <?php } else { ?>
				        	<span style="float:right; padding-top:10px; padding-right:5px;"><?php echo $lang['langShopSendSpaceUse']; echo !empty($output['message_num']) ? $output['message_num'] : 0; ?>/100</span>
				        <?php } ?>
					</p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<?php if ( $output['action'] == '' ) { ?>
							<li class="nav-bg"><b></b><span><p><?php echo $lang['langMsgReceive'];?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1"><b></b><span><p><a href="own_message.php"><?php echo $lang['langMsgReceive'];?></a></p></span></li>
						<?php } ?>
						<?php if ( $output['action'] == 'send' ) { ?>
							<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langMsgSend'];?></p></span></li>
						<?php } else { ?>
							<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=send"><?php echo $lang['langMsgSend'];?></a></p></span></li>
						<?php } ?>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=add"><?php echo $lang['langShopSendMessage'];?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<form action="own_message.php?action=del&genre=<?php echo $output['message_genre']; ?>" method="post" onsubmit="return checkForm('<?php echo $lang['langCConfirmDelete']; ?>','<?php echo $lang['langCNoSelect']; ?>');">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-3" style="width:8%;"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langShopState'];?></td>
							<td class="td-bg-1" style="width:25%;"><?php echo $lang['langShopTitle'];?></td>
							<td class="td-bg-4" style="width:10%;">
								<?php
									if ( $output['action'] == 'send' ) {
										echo $lang['langShopReceiveMan'];
									} else {
										echo $lang['langShopMessageFrom'];
									}
								?>
							</td>
							<td class="td-bg-7" style="width:12%;"><?php echo $lang['langShopSendTime'];?></td>
						</tr>
						<?php if(!empty($output['message_array']) && is_array($output['message_array'])){ ?>
							<?php foreach($output['message_array'] as $list){ ?>
								<tr class="tr-un-conter-1">
									<td style="width:8%;">
										<?php if ( $list['isallowdel'] == '1' ) { ?>
											<input name="messageid[]" type="checkbox" id="messageid" value="<?php echo $list['message_id']; ?>" />
										<?php } ?>
									</td>
									<td style="width:10%;">
										<?php
											if ( $list['member_name'] == '0' ) {
												echo $lang['langShopSeries'];
											}
											if ( $list['isnew'] == '0' ) {
												echo $lang['langShopNotRead'];
											}
											if ( $list['isnew'] == '1' ) {
												echo $lang['langShopRead'];
											}
										?>
									</td>
									<td style="width:25%; text-align:left;">
										<a href="own_message.php?action=show&messageid=<?php echo $list['message_id']; ?>&genre=<?php echo $output['message_genre']; ?>">
											<?php echo $list['title']; ?>
										</a>
									</td>
									<td style="width:10%;">
										<?php
											if ( $list['send_name'] == '0' ) {
												echo $lang['langShopSystem'];
											} else {
												echo $list['send_name'];
											}
										?>
									</td>
									<td style="width:10%;"><?php echo $list['send_time'];?></td>
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
								<li><span class="span-button"><input type="button" name="Submit" value="<?php echo $lang['langShopEmptied']; ?>" onclick="if (confirm('<?php echo $lang['langShopEmptiedConfirm']; ?>')) { location.href='own_message.php?action=clean&genre=<?php echo $output['message_genre']; ?>'; }" /></span></li>
								<!-- 导出 -->
								<li><span class="span-button"><input onclick="javascript:location.href='own_message.php?action=derived&genre=<?php echo $output['message_genre']; ?>'" type="button" value="<?php echo $lang['langShopDerived']; ?>" /></span></li>
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