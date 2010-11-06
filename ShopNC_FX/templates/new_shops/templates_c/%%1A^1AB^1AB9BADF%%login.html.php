<?php /* Smarty version 2.6.9, created on 2009-08-01 16:58:47
         compiled from login.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['log_title']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.validate.js"></script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => '../shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft longer">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><?php echo $this->_tpl_vars['log_title']; ?>

				</div>
			</div>
			<div class="con">
				<div class="div_h10px"></div>
					<!-- 搜索店铺 -->
					<form action="?action=login" method="post" id="log_form" name="log_form">
					<table class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="120" align="right"><?php echo $this->_tpl_vars['log_name']; ?>
</td>
							<td colspan="2"><input type="text" name="username" id="username" class="inputbg" />
							<div class="check-error"><label style="display:none" for="username" class="wrong" metaDone="true" generated="true"></label></div>
							</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['log_password']; ?>
</td>
							<td colspan="2"><input type="password" class="inputbg" name="passwd" id="passwd"/>
							<div class="check-error"><label style="display:none" for="passwd" class="wrong" metaDone="true" generated="true"></label></div>
							</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['log_validate_card']; ?>
</td>
							<td width="97"><input type="text" name="txt_login_code" id="txt_login_code" class="inputbg shortinput" />
							<td width="203"><img src="../classes/libraries/code.php" name="codeimage" border="0" id="codeimage" style="vertical-align:middle;cursor: pointer" width="60" height="20" title="<?php echo $this->_tpl_vars['langMClickReplacingCode']; ?>
" onclick="this.src='<?php echo $this->_tpl_vars['Site_Url']; ?>
/classes/libraries/code.php?' + Math.random()" />
						</td>
						</tr>															
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><div class="login_but" onclick="$('#log_form').submit()"></div></td>
						</tr>
					</table>
					</form>
					<!-- end 搜索店铺 -->
				<div class="clear"></div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!--end content-->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => '../shop_footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of footer -->
</div>
</body>
</html>
<script language="javascript">
<!--
$(document).ready(function(){
	$('#log_form').validate({
		errorClass: "wrong",
		rules: {
			username		: {required:true},
			passwd			: {required:true},
			txt_login_code	: {required:true}
		},
		messages: {
			username		: {required:"<?php echo $this->_tpl_vars['check_user_null']; ?>
"},
			passwd			: {required:"<?php echo $this->_tpl_vars['check_pass_null']; ?>
"},
			txt_login_code	: {required:"<?php echo $this->_tpl_vars['check_code_null']; ?>
"}	
		}
	});
});
//-->
</script>