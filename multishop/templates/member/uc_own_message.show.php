<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langSeeShopMsg'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
                        <li class="nav-bg-1"><b></b><span><p><a href="own_message.php?action=newpm"><?php echo $lang['langMsgNew'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=private"><?php echo $lang['langMsgPrivate'];?></a></p></span></li>
                        <li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=system"><?php echo $lang['langMsgSystem'];?></a></p></span></li>
                        <li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=common"><?php echo $lang['langMsgCommon']; ?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=add"><?php echo $lang['langShopSendMessage'];?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langSeeShopMsg'];?></p></span></li>
					</ul>
				</div>
                <!-- 消息显示开始 -->
				<div class="cr-right">
                <?php $show=false; foreach($output['message_array'] as $message_key=>$message): ?>
					<table <?php if($show){?>style="margin-top:10px;"<?php } $show=true;?> width="100%" class="cr-r-td" border="0" cellpadding="0" >
						<!--<tr>
							<td class="cr-1"><?php echo $lang['langShopTitle']; ?>:</td>
							<td class="cr-2"><?php echo $message['subject']; ?></td>
						</tr>-->
                        <?php if(!empty($message['msgfrom'])): ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langMsgSendMember']; ?>:</td>
							<td class="cr-2">
								<?php echo $message['msgfrom']; ?>
							</td>
						</tr>
                        <?php endif; ?>
                        <tr>
							<td class="cr-1"><?php echo $lang['langShopSendTime']; ?>:</td>
							<td class="cr-2">
								<?php
									echo @date('Y-m-d H:i',$message['dateline']);
								?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopContent']; ?>:</td>
							<td class="cr-2">
								<?php echo htmlspecialchars_decode($message['message']); ?>
							</td>
						</tr>
					</table>
				</div>
                <?php endforeach; ?>
                <!-- 消息显示结束 -->
                <!-- 回复短消息开始 -->
                <?php if(!empty($message['msgfrom'])): ?>
                <form action="own_message.php?action=reply" method="post" />
                    <table style="margin-top:10px;" width="100%" class="cr-r-td" border="0" cellpadding="0" >
						<tr>
							<td class="cr-1"><?php echo $lang['langMsgReply']; ?>:</td>
							<td class="cr-2">
                                <textarea name="txtContent"></textarea>
                                <input type="hidden" value="<?php echo $output['pmid']; ?>" name="pmid"/>
                            </td>
						</tr>
					</table>
                <div class="an-1 bg-an">
                    <span class="buttom-comm">
						<input  name="Submit" value="<?php echo $lang['langMsgReplaySure']; ?>" type="submit"/>
					</span>
					<span class="buttom-comm">
						<input  name="backFrontPage" value="<?php echo $lang['langCReturn']; ?>" type="button" onclick="history.back()" />
					</span>
				</div>
                </form>
                <?php endif; ?>
                <!-- 回复短消息结束 -->
                <!-- 短消息回复功能for uc结束 -->
			</div>
		</div>
	</div>
</div>