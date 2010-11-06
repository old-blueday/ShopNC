<?php /* Smarty version 2.6.9, created on 2009-08-01 16:34:14
         compiled from reg.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['reg_title']; ?>
-<?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.validate.js"></script>
<script language="javascript">
function reg(){
	if (!$('#xieyi').attr('checked')){
		alert('<?php echo $this->_tpl_vars['reg_info_no']; ?>
');
	}else{
		$('#reg_form').submit();
	}
}
$(document).ready(function(){
	$("#reg_form").validate({
		errorClass: "wrong",
		rules: {
			reg_domain:	{required:true,Nozhcn:true},
			reg_user:	{required:true,minLength:2,maxLength:20},
			reg_pass:	{required:true,minLength:6,maxLength:20},
			reg_rpass:	{required:true,minLength:6,maxLength:20,equalTo:'#reg_pass'},
			reg_mail:	{required:true,email:true},
			reg_shopname:{required:true},
			reg_code:	{required:true}
		},
		messages: {
			reg_domain:	{required: "<?php echo $this->_tpl_vars['check_domain_null']; ?>
",Nozhcn: "不能输入中文"},
			reg_user:	{required: "<?php echo $this->_tpl_vars['check_user_null']; ?>
",minLength: "<?php echo $this->_tpl_vars['check_user_min']; ?>
",maxLength: "<?php echo $this->_tpl_vars['check_user_max']; ?>
"},
			reg_pass:	{required: "<?php echo $this->_tpl_vars['check_pass_null']; ?>
",minLength: "<?php echo $this->_tpl_vars['check_pass_min']; ?>
",maxLength: "<?php echo $this->_tpl_vars['check_pass_max']; ?>
"},
			reg_rpass:	{required: "<?php echo $this->_tpl_vars['check_repass_null']; ?>
",minLength: "<?php echo $this->_tpl_vars['check_repass_min']; ?>
",maxLength: "<?php echo $this->_tpl_vars['check_repass_max']; ?>
",equalTo:"<?php echo $this->_tpl_vars['check_double_pass']; ?>
"},
			reg_mail:	{required:"<?php echo $this->_tpl_vars['check_mail_null']; ?>
",email:"<?php echo $this->_tpl_vars['check_mail_error']; ?>
"},
			reg_shopname:	{required:"<?php echo $this->_tpl_vars['check_shopname_null']; ?>
"},
			reg_code:	{required:"<?php echo $this->_tpl_vars['check_code_null']; ?>
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
<!-- 头部信息header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft longer">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead"> <strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><?php echo $this->_tpl_vars['reg_title']; ?>
 </div>
			</div>
			<div class="con">
				<div class="reg_left">
					<h1><?php echo $this->_tpl_vars['reg_info']; ?>
<!--用户协议--></h1>
					<div class="agree">
						<?php echo $this->_tpl_vars['info_array']['info_text']; ?>

					</div>
					<div class="accept">
						<input name="xieyi" id="xieyi" type="checkbox" checked="checked" value="1" />
						<strong><?php echo $this->_tpl_vars['reg_info_ok']; ?>
<!--阅读并认可上述用户协议--></strong></div>
				</div>
				<div class="reg_right"><form id="reg_form" name="reg_form" method="post" action="?action=save">
					<table class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="166" align="right"><?php echo $this->_tpl_vars['reg_domain']; ?>
<!--子店域名-->：</td>
							<td colspan="2">http://
								<input type="text" name="reg_domain" id="reg_domain" class="inputbg shortinput" style="ime-mode:Disabled;" />
								<?php echo $this->_tpl_vars['domainname']; ?>

								<span>*</span>
				<div class="check-error">
                	<label style="display:none" for="reg_domain" class="wrong" metaDone="true" generated="true"></label>
              	</div>
								</td>
						</tr>
						<tr>
							<td colspan="3"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/hsearch_line.gif" width="407" height="6" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_user']; ?>
：</td>
							<td colspan="2"><input type="text" class="inputbg" name="reg_user" id="reg_user" />
								<span>*</span>
								<div class="check-error">
                	<label style="display:none" for="reg_user" class="wrong" metaDone="true" generated="true"></label>
              	</div></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_pass']; ?>
：</td>
							<td colspan="2"><input name="reg_pass" type="password" id="reg_pass"  class="inputbg" />
								<span>*</span>
						<div class="check-error">
                	<label style="display:none" for="reg_pass" class="wrong" metaDone="true" generated="true"></label>
              	</div>		
								</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_rpass']; ?>
：</td>
							<td colspan="2"><input name="reg_rpass" type="password" id="reg_rpass" class="inputbg" />
								<span>*</span>
						<div class="check-error">
                	<label style="display:none" for="reg_rpass" class="wrong" metaDone="true" generated="true"></label>
              	</div>		
								</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_mail']; ?>
：</td>
							<td colspan="2"><input type="text" id="reg_mail" name="reg_mail" class="inputbg" />
								<span>*</span>
							<div class="check-error">
                	<label style="display:none" for="reg_mail" class="wrong" metaDone="true" generated="true"></label>
              	</div>
								</td>
						</tr>
						<tr>
							<td colspan="3"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/hsearch_line.gif" width="407" height="6" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_shopname']; ?>
：</td>
							<td colspan="2"><input type="text" id="reg_shopname" name="reg_shopname" class="inputbg" />
								<span>*</span>
							<div class="check-error">
                	<label style="display:none" for="reg_shopname" class="wrong" metaDone="true" generated="true"></label>
              	</div>	
								</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_shoptype']; ?>
：</td>
							<td colspan="2"><select name="shoptype" id="shoptype">
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
                        <option value="<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['id']; ?>
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
						<option value="<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['id']; ?>
">&nbsp;&nbsp;|--<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['name']; ?>
</option>
						<?php endfor; endif; ?>
					<?php endfor; endif; ?>	
                    </select>
								<span>*</span></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['select_template']; ?>
：</td>
							<td colspan="2"><select name="templates" id="templates">
                        	<option value="default"><?php echo $this->_tpl_vars['default_template']; ?>
</option>
                    </select>
					<div class="check-error">
                	<label style="display:none" for="templates" class="wrong" metaDone="true" generated="true"></label>
              	</div>
					</td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_shopinfo']; ?>
：</td>
							<td colspan="2"><textarea name="reg_shopinfo" id="reg_shopinfo" cols="40" rows="5"></textarea></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['reg_code']; ?>
:</td>
							<td width="97"><input name="reg_code" type="text" id="reg_code" size="8"  class="inputbg shortinput" /></td>
							<td width="157" valign="middle"><img src="../classes/libraries/code.php" name="codeimage" border="0" id="codeimage" style="vertical-align:middle;cursor: pointer" title="<?php echo $this->_tpl_vars['langMClickReplacingCode']; ?>
" onclick="this.src='<?php echo $this->_tpl_vars['Site_Url']; ?>
/classes/libraries/code.php?' + Math.random()" />
							<span>*</span>
							 <div class="check-error">
                	<label style="display:none" for="reg_code" class="wrong" metaDone="true" generated="true"></label>
              	</div>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><div class="reg_but" onclick="reg()"></div></td>
						</tr>
					</table></form>
				</div>
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