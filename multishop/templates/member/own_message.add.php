<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langShopSendMessage'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="own_message.php"><?php echo $lang['langMsgReceive'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=send"><?php echo $lang['langMsgSend'];?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><a href="own_message.php?action=add"><?php echo $lang['langShopSendMessage'];?></a></p></span></li>
					</ul>
				</div>
				<form action="own_message.php?action=save" method="post">
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopReceiveMan']; ?>:</td>
							<td class="cr-2"><input class="in" name="txtReceive_name" id="txtReceive_name" type="text" value="<?php echo $output['message_array']['member_name']; ?>" />
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTitle']; ?>:</td>
							<td class="cr-2"><input class="in" name="txtTitle" id="txtTitle" type="text" value="" /></td>
                        </tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopContent']; ?>:</td>
							<td class="cr-2" colspan="2">
								<?php
									include_once('../classes/resource/editor/editor.class.php');
									$editor=new editor('txtContent');
									$editor->Value=$this->_tpl_vars['tag_array']['tag_content'];
									$editor->BasePath='../classes/resource/editor';
									$editor->Height=460;
									$editor->Width=621;
									$editor->AutoSave=false;
									$editor->Create();
								?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMsgSendSelect']; ?>:</td>
							<td class="cr-2" colspan="2">
								<label for="chkIssave"><input name="chkIssave" type="checkbox" id="chkIssave" value="1" /> <?php echo $lang['langShopSaveToSend']; ?></label>

            				</td>
						</tr>
					</table>
				</div>
				<div class="an-1 bg-an"><span class="buttom-comm"><input  name="" value="<?php echo $lang['langMessageSend']; ?>" type="submit" /></span></div>
				</form>
			</div>
		</div>
	</div>
</div>