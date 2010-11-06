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
				<div class="io-1"><p><?php echo $lang['langMUserFeed'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php"><?php echo $lang['langNEditOwnInfo']; ?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=email"><?php echo $lang['langNEditOwnEmail']; ?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=password"><?php echo $lang['langNEditOwnPassword']; ?></a></p></span></li>
                        <li class="nav-bg nav-left"><b></b><span><p><a href="<?php echo SITE_URL; ?>/member/own_member.php?action=feed"><?php echo $lang['langMUserFeed']; ?></a></p></span></li>
					</ul>
				</div>
                <?php if($this->_configinfo['api']['open_passport'] ==1 && $this->_configinfo['api']['passport_type'] == 2) { ?>
				<form action="own_member.php?action=feedsave" method="post" name="form_feed" id="form_feed">
                    <div class="cr-right">
                        <table width="100%" class="cr-r-td" border="0" cellpadding="0">
                            <tr>
                                <td class="cr-1"></td>
                                <td class="cr-2"><?php echo $lang['langMUserFeedInfomations']; ?></td>
                            </tr>
                            <tr>
                                <td class="cr-1"><?php echo $lang['langMUserFeedSelect']; ?></td>
                                <td class="cr-2">
                                    <input type="checkbox" name="feed[buygoods]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['buygoods'] ==1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedBuyGoods']; ?>
                                    <input type="checkbox" name="feed[commentgoods]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['commentgoods'] == 1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedCommentGoods']; ?>
                                    <input type="checkbox" name="feed[commentstore]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['commentstore'] ==1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedCommentStore']; ?>
                                    <input type="checkbox" name="feed[collectiongoods]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['collectiongoods'] ==1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedCollectionGoods']; ?>
                                    <input type="checkbox" name="feed[collectionstore]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['collectionstore'] ==1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedCollectionStore']; ?>
                                    <input type="checkbox" name="feed[sendgoods]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['sendgoods'] ==1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedSendGoods']; ?>
                                    <input type="checkbox" name="feed[createstore]" <?php if(empty($_SESSION['s_login']['feed']) or $_SESSION['s_login']['feed']['createstore'] ==1) echo 'checked="checked"'; ?> value="1"/><?php echo $lang['langMUserFeedCreateStore']; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
				    <div class="an-1 bg-an"><span class="buttom-comm"><input  name="" value="<?php echo $lang['langCsave']; ?>" type="submit" /></span></div>
				</form>
                <?php } else { ?>
                    <div class="cr-right">
                        <table width="100%" class="cr-r-td" border="0" cellpadding="0">
                            <tr>
                                <td align="center"><?php echo $lang['langMUserFeedOff']; ?></td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
			</div>
		</div>
	</div>
</div>