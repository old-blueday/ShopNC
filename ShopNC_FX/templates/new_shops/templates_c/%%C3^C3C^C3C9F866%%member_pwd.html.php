<?php /* Smarty version 2.6.9, created on 2009-08-01 19:57:19
         compiled from member_pwd.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['home_pass']; ?>
-<?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/js/jquery/jquery.js"></script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => '../shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft uc_right">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><a href="?action=index"><?php echo $this->_tpl_vars['home_member']; ?>
</a><?php echo $this->_tpl_vars['home_pass']; ?>
<!--修改密码--></div>
			</div>
			<div class="con">
				<h1><?php echo $this->_tpl_vars['home_pass']; ?>
<!--修改密码--></h1>
				<form action="?action=change_passsave" method="post" id="pwd_form" name="pwd_form" onsubmit="return CheckPwd();">
					<table class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="166" align="right"><?php echo $this->_tpl_vars['home_userpass']; ?>
<!--原密码-->:</td>
							<td width="254"><input name="oldpass" type="password" id="oldpass" class="inputbg" />
							<span id="noWord2" style="display:none;"><?php echo $this->_tpl_vars['home_nopass']; ?>
</span></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_newpass']; ?>
<!--新密码-->：</td>
							<td><input name="newpass" type="password" id="newpass" class="inputbg" />
							<span id="noWord" style="display:none;"><?php echo $this->_tpl_vars['home_nopass']; ?>
</span>
					<span id="dataError" style="display:none;"><?php echo $this->_tpl_vars['home_wrongpwd']; ?>
</span></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_rnewpass']; ?>
<!--确认新密码-->：</td>
							<td><input name="rnewpass" type="password" id="rnewpass" class="inputbg" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><div class="enter_but" onclick="$('#pwd_form').submit()"></div></td>
						</tr>
					</table>
				</form>
				<div class="clear"></div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
		</div>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'member_left.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<div class="clear"></div>

	</div>
	<!--end content-->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => '../shop_footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of footer -->	
</div>
</body>
</html>