<?php /* Smarty version 2.6.9, created on 2009-08-01 19:57:17
         compiled from member_info.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['home_user'];  echo $this->_tpl_vars['home_pass']; ?>
-<?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/select_area_zh-cn.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
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
</a><?php echo $this->_tpl_vars['home_user']; ?>

				</div>
			</div>
			<div class="con">
				<h1><?php echo $this->_tpl_vars['home_user']; ?>
</h1>
				<form action="?action=member_info_save" method="post" name="member_form" id="member_form">
					<table class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="166" align="right"><?php echo $this->_tpl_vars['home_truename']; ?>
<!--真实姓名-->：</td>
							<td width="254"><input type="text"  name="truename" value="<?php echo $this->_tpl_vars['member_info']['truename']; ?>
" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_usersex']; ?>
<!--性别-->：</td>
							<td class="hsearch_ch"><?php echo $this->_tpl_vars['sex_select']; ?>
</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_userarea']; ?>
<!--地区-->：</td>
							<td class="uc_adde"><select name="txtProvince" id="txtProvince" onchange="javascript:iniCity(document.getElementById('txtProvince'),document.getElementById('txtCity'));">
				  </select>&nbsp;<?php echo $this->_tpl_vars['home_province']; ?>
<!--省-->
					  <select name="txtCity" id="txtCity">
			</select>&nbsp;<?php echo $this->_tpl_vars['home_city']; ?>
<!--市--></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_address']; ?>
<!--详细地址-->：</td>
							<td><input type="text" name="address" id="address" value="<?php echo $this->_tpl_vars['member_info']['address']; ?>
" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_call']; ?>
<!--联系电话-->：</td>
							<td><input name="call" type="text" id="call" value="<?php echo $this->_tpl_vars['member_info']['usercall']; ?>
" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_email']; ?>
<!--E-MAIL-->：</td>
							<td><input name="mail" type="text" id="mail"  value="<?php echo $this->_tpl_vars['member_info']['mail']; ?>
" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_qq']; ?>
<!--QQ-->：</td>
							<td><input name="qq" type="text" id="qq"  value="<?php echo $this->_tpl_vars['member_info']['qq']; ?>
" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_msn']; ?>
<!--MSN-->：</td>
							<td><input name="msn" type="text" id="msn"  value="<?php echo $this->_tpl_vars['member_info']['msn']; ?>
"  class="inputbg" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><div class="reg_but" onclick="$('#member_form').submit()"></div></td>
						</tr>
					</table>
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
<script language="javascript">
<!--
selectprovince = "<?php echo $this->_tpl_vars['member_info']['province']; ?>
";
selectcity = "<?php echo $this->_tpl_vars['member_info']['city']; ?>
";
iniProvince(document.getElementById('txtProvince'));
iniCity(document.getElementById('txtProvince'),document.getElementById('txtCity'));
-->
</script>