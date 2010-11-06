<script language='javascript'>
// JavaScript Document
$(function(){
	$("#form_email").validate({
		event: "keyup",
		errorClass: "error",
		rules: {
			txtemail: {required:true,email:true}
		},
		messages: {
			txtemail: {required: "<?php echo $lang['errMEmail_Blank']; ?>",email: "<?php echo $lang['errMEmail_Wrong']; ?>"}
		}
	});

})
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langNEditOwnEmail'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php"><?php echo $lang['langNEditOwnInfo']; ?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langNEditOwnEmail']; ?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=password"><?php echo $lang['langNEditOwnPassword']; ?></a></p></span></li>
						<?php if (DISCUZ_X === true) { ?><li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=feed"><?php echo $lang['langHeadMemberFeed']; ?></a></p></span></li><?php } ?>
					</ul>
				</div>
				<form action="own_member.php?action=emailsave" method="post" name="form_email" id="form_email">
				<div class="cr-right">

					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langMloginname']; ?>:</td>
							<td class="cr-2"><strong><?php echo $output['member_array']['login_name']; ?></strong></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMemail']; ?>:</td>
							<td class="cr-2"><?php echo $output['member_array']['email']; ?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMNewEmail']; ?>:</td>
							<td class="cr-2"><label for="txtemail"></label><input class="in" name="txtemail" id="txtemail" type="text" /></td>
						</tr>

					</table>
				</div>
				<div class="an-1 bg-an"><span class="buttom-comm"><input  name="" value="<?php echo $lang['langCsave']; ?>" type="submit" /></span></div>
				</form>
			</div>
		</div>
	</div>
</div>