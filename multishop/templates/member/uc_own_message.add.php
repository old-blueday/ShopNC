<link href="../templates/member/css/ui.friendsuggest.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../templates/member/js/ui.friendsuggest.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
       <!-- 多选模式 -->
      var test = new giant.ui.friendsuggest();
    });
	function submitsave(){
		var obj=$("#ui-fs-resultclearfix").children("a");
		var hiddenval=""
		$.each(obj,function(){

			hiddenval+=$(this).attr('name')+",";
		});
		$("#hiddensave").val(hiddenval);
	}

</script>
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
                        <li class="nav-bg-1"><b></b><span><p><a href="own_message.php?action=newpm"><?php echo $lang['langMsgNew'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=private"><?php echo $lang['langMsgPrivate'];?></a></p></span></li>
                        <li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=system"><?php echo $lang['langMsgSystem'];?></a></p></span></li>
                        <li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_message.php?action=common"><?php echo $lang['langMsgCommon']; ?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><a href="own_message.php?action=add"><?php echo $lang['langShopSendMessage'];?></a></p></span></li>
					</ul>
				</div>
				<form action="own_message.php?action=save" onsubmit="submitsave()" method="post">
				<input type="hidden" value="" name="hiddensave" id="hiddensave" />
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopReceiveMan']; ?>:</td>
							<td class="cr-2">
                                <?php if($output['isuser'] == 0): ?>
                                <div id="ui-fs" class="ui-fs">
                                    <div class="ui-fs-result clearfix" id="ui-fs-resultclearfix">
                                    </div>
                                    <div class="ui-fs-input">
                                        <input name="txtReceive_name" type="text" value="<?php echo $lang['langUCMessageSearch']; ?>" maxlength="30" />
                                        <a class="ui-fs-icon" href="javascript:void(0)" title="<?php echo $lang['langUCMessageList']; ?>"><?php echo $lang['langUCMessageList']; ?></a>
                                    </div>
                                    <div class="ui-fs-list">
                                       <?php echo $lang['langUCMessageLoad']; ?>
                                    </div>
                                    <div class="ui-fs-all">

                                        <div class="top">
                                            <select name="sendtype" id="ui-fs-friendtype"><option value="1"><?php echo $lang['langUCMessageFriend']; ?></option><option value="2"><?php echo $lang['langUCMessageGroup']; ?></option></select>
                                            <div class="close" title="<?php echo $lang['langUCMessageClose']; ?>"><?php echo $lang['langUCMessageClose']; ?></div>
                                        </div>
                                        <div class="ui-fs-allinner">
                                            <div class="page clearfix">
                                                <div class="llight1"><?php echo $lang['langUCMessageSelect']; ?><b>20</b><?php echo $lang['langUCMessageX']; ?></div><div class="button"><span class="prev"><?php echo $lang['langUCMessagePrev']; ?></span><span class="next"><?php echo $lang['langUCMessageNext']; ?></span></div>
                                            </div>
                                            <div class="list clearfix" id="listclearfix">
                                               <?php echo $lang['langUCMessageLoad']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <input class="in" type="text" name="txtReceive_name" value="<?php echo $output['username']; ?>" />
                                <input type="hidden" name="sendtype" value="1" />
                                <?php endif; ?>
                                <input type="hidden" name="token" value="<?php echo $output['token']; ?>" />
                            </td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTitle']; ?>:</td>
							<td class="cr-2"><input class="in" size="50" name="txtTitle" id="txtTitle" type="text" value="" /></td>
                        </tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopContent']; ?>:</td>
							<td class="cr-2" colspan="2">
								<?php
									include_once('../classes/resource/editor/editor.class.php');
									$editor=new editor('txtContent');
									$editor->Value=$output['content'];
									$editor->BasePath='../classes/resource/editor';
									$editor->Height=460;
									$editor->Width=621;
									$editor->AutoSave=false;
									$editor->Create();
								?>
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
