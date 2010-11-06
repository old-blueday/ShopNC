<?php /* Smarty version 2.6.9, created on 2009-08-02 14:46:51
         compiled from search_adv.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<title><?php echo $this->_tpl_vars['search_adv']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
<script language="javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/select_area_zh-cn.js"></script>
<script>
function search_pannel(type){
	if (type == 1){
		$('#search_type1').css('display','');
		$('#search_type2').css('display','none');
	}else{
		$('#search_type2').css('display','');
		$('#search_type1').css('display','none');	
	}
}
$(document).ready(function() { 
	iniProvince(document.getElementById('txtProvince'));
	iniProvince(document.getElementById('txtProvince2'));
}); 
</script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- 头部信息header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft longer">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><?php echo $this->_tpl_vars['search_adv']; ?>

				</div>
			</div>
			<div class="con">
				<!-- 选择部分 -->
				<table class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="60">&nbsp;</td>
						<td width="156" align="center" class="hsearch_ch"><input type="radio" name="search_type" onclick="search_pannel(1)" checked="checked"/><?php echo $this->_tpl_vars['search_product']; ?>
</td>
						<td width="140" align="center" class="hsearch_ch">
						<input type="radio" name="search_type" onclick="search_pannel(2)"/><?php echo $this->_tpl_vars['search_shop']; ?>

						</td>
						<td width="60">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/hsearch_line.gif" width="407" height="6" /></td>
					</tr>
				</table>
				<!-- end 选择部分 -->
				<!-- 搜索商品 -->
				<form id="adv_search" method="get" action="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php">
            	<input type="hidden" name="action" value="search" />
				<table id="search_type1" class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="110" align="right"><?php echo $this->_tpl_vars['keywords']; ?>
</td>
							<td><input type="text" name="txt_keywords" id="txt_keywords" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['type']; ?>
</td>
							<td><select name="txt_class_top_id" id="txt_class_top_id">
							<option value=""><?php echo $this->_tpl_vars['search_select']; ?>
</option>
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
                    </select></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['price_group']; ?>
</td>
							<td><input type="text" name="txt_start_price" id="start_price" class="inputbg shortinput" /> <?php echo $this->_tpl_vars['to']; ?>
 <input type="text" name="txt_end_price" id="end_price" class="inputbg shortinput" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['goods_location']; ?>
</td>
							<td>
							<select name="txtProvince" id="txtProvince" >
							</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><div class="seach_but" onclick="$('#adv_search').submit()"></div></td>
						</tr>
					</table>
					</form>
					<!-- end 搜索商品 -->
					<!-- 搜索店铺 -->
					<form id="adv_search2" method="get" action="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_list.php">					
<table style="display:none" id="search_type2"  class="s_selclass h_search" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="110" align="right"><?php echo $this->_tpl_vars['keywords']; ?>
</td>
							<td><input type="text" class="inputbg" /></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['type']; ?>
</td>
							<td><select name="txt_class_top_id">
							<option value=""><?php echo $this->_tpl_vars['search_select']; ?>
</option>
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
                    </select></td>
						</tr>
						<tr>
							<td align="right"><?php echo $this->_tpl_vars['goods_location']; ?>
</td>
							<td><select name="txtProvince" id="txtProvince2" >
							</select></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><div class="seach_but" onclick="$('#adv_search2').submit()"></div></td>
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
smarty_core_smarty_include_php(array('smarty_file' => 'shop_footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of footer -->
</div>
</body>
</html>