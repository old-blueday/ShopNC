<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="nav">
					<ul>
						<li class="nav-bg"><span><b></b><p><?php echo $lang['langResumeSet']; ?></p></span></li>
					</ul>
				</div>
				<div class="info-1">
					 <?php echo $lang['langResumeMessageRemind']; ?><br/> 
	                 <?php echo $lang['langResumeThereinto']; ?>
	                 <span style="color:#FF0000">*</span>
	                 <?php echo $lang['langResumeInformIsMust']; ?>
	                 <input type="checkbox" checked name="hoar" value="hoar" disabled />
	                 <?php echo $lang['langResumeMessageFashionIsMust']; ?>
	                 <input type="checkbox" name="hoar2" value="hoar" disabled />
	                 <?php echo $lang['langResumeMessageNotSustain']; ?>
				</div>
				<form name="mainform" id="mainform" action="own_remind.php?action=save" method="post" onsubmit="return checkform();" >
				<div class="an-4"><span class="buttom-comm"><input type="submit" value="<?php echo $lang['langCsave']; ?>" /></span><span class="buttom-comm"><input type="button" onclick="if(confirm('<?php echo $lang['langConfirmResumeDefaultSetup']; ?>')){location.href='own_remind.php?action=default_value'}else{return false;}" value="<?php echo $lang['langResumeDefaultSetup']; ?>" /></span></div>
				<div class="clear-5"></div>
				<div class="info-conter">
					<div class="info-conter-1">
						<ul>
							<li class="info-li-1"><?php echo $lang['langResumeMessageContent']; ?></li>
							<li class="info-li-2"><?php echo $lang['langResumeEmail']; ?></li>
							<li class="info-li-3"><?php echo $lang['langResumeStationInnerMessage']; ?></li>
						</ul>
					</div>			
					<?php foreach ( $output['remind_array'] as $key => $remind ) { ?>
						<div class="info-conter-2">
							<h3 class="h3-1"><?php echo $remind['name']; ?></h3>
							<?php foreach ( $remind['body'] as $body_one ) {?>
								<dl>
									<dt><?php echo $body_one['name']; ?></dt>
									<?php foreach ( $body_one['body'] as $body_two ) { ?>
										<dd>
											<li class="info-dd-li-1">
												<?php if ( $body_two['must'] == '1' ) { ?>
													<font style="color:#ff0000; vertical-align:-2px;">*</font> 
													<input type="hidden" name="<?php echo $body_two['tag']; ?>_must" id="<?php echo $body_two['tag']; ?>_must" value="true" />
												<?php } else { ?>
													<input type="hidden" name="<?php echo $body_two['tag']; ?>_must" id="<?php echo $body_two['tag']; ?>_must" value="false" />
												<?php } ?>
												<?php echo $body_two['name']; ?>
											</li>
											<li class="info-dd-li-2">
												<?php if ( $body_two['mail_disabled'] == '1' ) { ?>
													<input class="checbox" <?php if ( $body_two[$body_two['tag']]['mail_check'] == '1' ) { ?> checked="checked" <?php } ?> type="checkbox" disabled="disabled" />
													<input type="hidden" id="<?php echo $body_two['tag']; ?>_mail" name="<?php echo $body_two['tag']; ?>_mail" value="<?php echo $body_two[$body_two['tag']]['mail_check']; ?>" />
												<?php } else { ?>
													<input type="checkbox" <?php if ( $body_two[$body_two['tag']]['mail_check'] == '1' ) { ?> checked="checked" <?php } ?> id="<?php echo $body_two['tag']; ?>_mail" name="<?php echo $body_two['tag']; ?>_mail" value="1"/>
												<?php } ?>
											</li>
											<li class="info-dd-li-3">
												<?php if ( $body_two['msg_disabled'] == '1' ) { ?>
													<input class="checbox" <?php if ( $body_two[$body_two['tag']]['msg_check'] == '1' ) { ?> checked="checked" <?php } ?> type="checkbox" disabled="disabled" />
													<input type="hidden" id="<?php echo $body_two['tag']; ?>_msg" name="<?php echo $body_two['tag']; ?>_msg" value="<?php echo $body_two[$body_two['tag']]['msg_check']; ?>" />
												<?php } else { ?>
													<input type="checkbox" <?php if ( $body_two[$body_two['tag']]['msg_check'] == '1' ) { ?> checked="checked" <?php } ?> id="<?php echo $body_two['tag']; ?>_msg" name="<?php echo $body_two['tag']; ?>_msg" value="1"/>
												<?php } ?>												
											</li>
										</dd>
										<input type="hidden" name="tag" value="<?php echo $body_two['tag']; ?>">																				
									<?php } ?>							
								</dl>
							<?php } ?>
						</div>
						<?php if ( $key != '3' ) { ?>
							<div class="clear-1"></div>
							<div class="info-conter-1">
								<ul>
									<li class="info-li-1"><?php echo $lang['langResumeMessageContent']; ?></li>
									<li class="info-li-2"><?php echo $lang['langResumeEmail']; ?></li>
									<li class="info-li-3"><?php echo $lang['langResumeStationInnerMessage']; ?></li>
								</ul>
							</div>		
						<?php } ?>				
					<?php } ?>
					<div class="an-4"><span class="buttom-comm"><input type="submit" value="<?php echo $lang['langCsave']; ?>" /></span><span class="buttom-comm"><input type="button" onclick="if(confirm('<?php echo $lang['langConfirmResumeDefaultSetup']; ?>')){location.href='own_remind.php?action=default_value'}else{return false;}" value="<?php echo $lang['langResumeDefaultSetup']; ?>" /></span></div>
					</form>
				<div class="clear-5"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function checkform()
	{
		//检查必选的，是否已选
		var es = document.forms['mainform'].elements['tag'];
		for( var i = 0; i<es.length; ++i ){
			var e = es[i];
			var msg_necessary = document.forms['mainform'].elements[e.value+'_must'];
			if( msg_necessary.value == 'true' )
			{
				var checked = "false";
				
				var ns = document.forms['mainform'].elements[e.value+'_mail'];
				var ms = document.forms['mainform'].elements[e.value+'_msg'];
    			if( (ns.checked || ms.checked) || ns.type=="hidden")
				{
					checked = "true";
				}
				if( checked == "false" )
				{
					alert("<?php echo $lang['langRSelectSendFashion']; ?>");
					window.location = "#" + e.value + '_mail';
					return false;
				}
			}
		}
		return true;
	}
</script>