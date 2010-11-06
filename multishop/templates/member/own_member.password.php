<STYLE type=text/css>
.pwd-strength {
padding: 2px;
padding-left: 5px;
padding-right: 5px;
width: 180px;
}
.pwd-strength-box,
.pwd-strength-box-low,
.pwd-strength-box-med,
.pwd-strength-box-hi
{
color: #464646;
text-align: center;
width: 23%;
}
.pwd-strength-box-low
{
color: #FF0000;
background-color:#FFECEC;
}
.pwd-strength-box-med
{
color: #fff;
background-color: #FF7070;
}
.pwd-strength-box-hi
{
color:#fff;
background-color: #FF3D3D;
}
</STYLE>
<script language='javascript'>
// JavaScript Document
$(function(){
	$("#form_pass").validate({
		rules: {
			txtoldpassword: {required:true},
			txtPassword: {required:true,minlength:6,maxlength:16},
			txtrePassword: {required:true,minlength:6,maxlength:16,equalTo:'#txtPassword'}
		},
		messages: {
			txtoldpassword: {required: "<?php echo $lang['errMEnterOldPassword']; ?>"},  //请填写原密码!
			txtPassword: {required: "<?php echo $lang['errMpassword']; ?>",minlength: "<?php echo $lang['errMPassword_MinLength']; ?>",maxlength: "<?php echo $lang['errMPassword_MaxLength']; ?>"}, //请输入密码 密码长度至少是6!  密码长度最长是16位!
			txtrePassword: {required: "<?php echo $lang['errMRePassword_Blank']; ?>",minlength: "<?php echo $lang['errMRePassword_MinLength']; ?>",maxlength: "<?php echo $lang['errMPassword_MaxLength']; ?>",equalTo:"<?php echo $lang['errMRePassword_Wrong']; ?>"}
		}
	});
})
//检测密码安全等级
function checkPassword(pwd){

	var sRe=[/[a-zA-Z]/g,/\d/g,/[^a-zA-Z0-9]/g];
    	var sLe=[1,2,5];
    	var sFa=[0,0,10,20];
    	var iKn=0;
    	var iSt=0;
    	for(i=0;i<sRe.length;i++) {
    		var cMa=pwd.match(sRe[i]);
    		if(cMa!=null) {
    			iSt+=cMa.length*sLe[i];
    			iKn++;
    		}
    	}
    	iSt+=sFa[iKn];

		if(iSt == 0){
			$('#pwdLow').removeClass('pwd-strength-box-low');
			$('#pwdMed').removeClass('pwd-strength-box-med');
			$('#pwdHi').removeClass('pwd-strength-box-hi');
		}else if(iSt>20 && iSt<30){
			$('#pwdMed').addClass('pwd-strength-box-med');
		}else if(iSt>30){
			$('#pwdHi').addClass('pwd-strength-box-hi');
		}else{
			$('#pwdLow').addClass('pwd-strength-box-low');
		}
}
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langNEditOwnPassword'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php"><?php echo $lang['langNEditOwnInfo']; ?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=email"><?php echo $lang['langNEditOwnEmail']; ?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langNEditOwnPassword']; ?></p></span></li>
						<?php if (DISCUZ_X === true) { ?><li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=feed"><?php echo $lang['langHeadMemberFeed']; ?></a></p></span></li><?php } ?>
					</ul>
				</div>
				 <form action="own_member.php?action=passwordsave" method="post" name="form_pass" id="form_pass">
				<div class="cr-right">

					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langMloginname']; ?>:</td>
							<td class="cr-2"><strong><?php echo $output['ses_login_name']; ?></strong></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMOldPassword']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtoldpassword" id="txtoldpassword" value="" type="password" />
								<label style="display:none" for="txtoldpassword" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMNewPassword']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtPassword" type="password" id="txtPassword" onkeyup='checkPassword(this.value);' />
								<label style="display:none" for="txtPassword" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMReNewPassword']; ?>:</td>
							<td class="cr-2"><div class="password password" id="pwdLow"><?php echo $lang['langPasswordLow']; ?></div><div class="password" id="pwdMed"><?php echo $lang['langPasswordMiddle']; ?></div><div class="password" id="pwdHi"><?php echo $lang['langPasswordHigh']; ?></div></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langMReNewPassword']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtrePassword" type="password" id="txtrePassword" value="" />
								<label style="display:none" for="txtrePassword" class="error" metaDone="true" generated="true"></label>
							</td>
						</tr>

					</table>

				</div>


				<div class="an-1 bg-an"><span class="buttom-comm"><input  name="" value="<?php echo $lang['langCsave']; ?>" type="submit" /></span></div>
				</form>
			</div>
		</div>
	</div>
</div>