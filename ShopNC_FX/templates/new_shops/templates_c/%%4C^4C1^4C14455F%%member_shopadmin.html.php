<?php /* Smarty version 2.6.9, created on 2009-08-01 19:57:20
         compiled from member_shopadmin.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['home_shops']; ?>
-<?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	/* 对需要填写验证的信息，进行验证 */
	$("#msg_form").validate({
		errorClass: "wrong",
		rules: {
			shopname	: {required	:true},
			domainname	: {required	:true}
		},
		messages: {
			shopname	: {required	: "<?php echo $this->_tpl_vars['home_shop_shopname_is_not_null']; ?>
"},
			domainname	: {required	: "<?php echo $this->_tpl_vars['home_shop_domainname_is_not_null']; ?>
"}
		}
	});
});
</script>
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
</a><?php echo $this->_tpl_vars['home_shops']; ?>
<!--网店管理--></div>
			</div>
			<div class="con">
				<h1><?php echo $this->_tpl_vars['home_shopinfo']; ?>
<!--网店资料--></h1>
				<form action="?action=shop_info_save" method="post" name="msg_form" id="msg_form" enctype="multipart/form-data">
					<table class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="166" align="right"><?php echo $this->_tpl_vars['home_shopname']; ?>
<!--网店名称-->：</td>
							<td><input type="text" class="inputbg" name="shopname" id="shopname" value="<?php echo $this->_tpl_vars['shop_info']['shopname']; ?>
"  />
							<div class="check-error"><label style="display:none" for="shopname" class="wrong" metaDone="true" generated="true"></label></div></td>
						</tr>
						
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_shopurl']; ?>
<!--网店地址-->：</td>
							<td>http://
								<input name="domainname" type="text" id="domainname" readonly="readonly" value="<?php echo $this->_tpl_vars['shop_info']['domainname']; ?>
" class="inputbg shortinput"/><?php echo $this->_tpl_vars['domainname']; ?>

								<div class="check-error"><label style="display:none" for="domainname" class="wrong" metaDone="true" generated="true"></label></div>
								
								</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_shoplogo']; ?>
<!--网店LOGO-->：</td>
							<td>
							<?php if ($this->_tpl_vars['shop_info']['shoplogo'] != ''): ?><img src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['shop_info']['shoplogo']; ?>
" /><?php endif; ?><BR />
				    <input type="file" name="shoplogo" class="file_input" />
					<input type="hidden" name="old_logo" value="<?php echo $this->_tpl_vars['shop_info']['shoplogo']; ?>
" />
							</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_shopinfo']; ?>
<!--网店简介-->：</td>
							<td><textarea name="shopinfo" class="formtextarea" id="shopinfo"><?php echo $this->_tpl_vars['shop_info']['shopinfo']; ?>
</textarea></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_shoptype']; ?>
<!--网店类型-->：</td>
							<td><select name="shoptype" id="shoptype">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['node_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                        <option <?php if ($this->_tpl_vars['shop_info']['shoptype'] == $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['id']): ?>selected="selected"<?php endif; ?> value="<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['name']; ?>
</option>
						<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
						<option <?php if ($this->_tpl_vars['shop_info']['shoptype'] == $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['id']): ?>selected="selected"<?php endif; ?> value="<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['id']; ?>
">&nbsp;&nbsp;|--<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['name']; ?>
</option>
						<?php endfor; endif; ?>
					<?php endfor; endif; ?>	
                    </select></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['home_shopstate']; ?>
<!--网店状态-->：</td>
							<td class="hsearch_ch"><?php echo $this->_tpl_vars['shopstate']; ?>
</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><div class="reg_but" onclick="$('#msg_form').submit()"></div></td>
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