<?php /* Smarty version 2.6.9, created on 2009-08-01 16:59:18
         compiled from reg_ok.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['reg_ok_title']; ?>
-<?php echo $this->_tpl_vars['shops_name']; ?>
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
				<div class="w_tithead"> <strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><?php echo $this->_tpl_vars['reg_ok_title']; ?>
 </div>
			</div>
			<div class="con">
				<div class="div_h10px"></div>
					<!-- 搜索店铺 -->
					<form action="?action=login" method="post" id="log_form" name="log_form">

					
				<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="s_selclass h_search">
				  <tr>
					<td>
						<?php echo $this->_tpl_vars['reg_ok_url']; ?>
:<a href="http://<?php echo $this->_tpl_vars['user_info']['txt_reg_domain'];  echo $this->_tpl_vars['domainname']; ?>
">http://<?php echo $this->_tpl_vars['user_info']['txt_reg_domain'];  echo $this->_tpl_vars['domainname']; ?>
</a>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo $this->_tpl_vars['reg_ok_adminurl']; ?>
:<a href="http://<?php echo $this->_tpl_vars['user_info']['txt_reg_domain'];  echo $this->_tpl_vars['domainname']; ?>
/admin">http://<?php echo $this->_tpl_vars['user_info']['txt_reg_domain'];  echo $this->_tpl_vars['domainname']; ?>
/admin</a>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo $this->_tpl_vars['reg_ok_user']; ?>
:<?php echo $this->_tpl_vars['user_info']['txt_reg_user']; ?>

					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo $this->_tpl_vars['reg_ok_pass']; ?>
:<?php echo $this->_tpl_vars['user_info']['txt_reg_pass']; ?>

					</td>
				  </tr>
				  <tr>
					<td class="alertBlue">
						<?php echo $this->_tpl_vars['reg_ok_info']; ?>

					</td>
				  </tr>
				</table>
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