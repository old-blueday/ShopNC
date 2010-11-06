<?php /* Smarty version 2.6.9, created on 2009-08-01 16:58:21
         compiled from shop_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['shop_list_index']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- 头部信息header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft sl_index">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><?php echo $this->_tpl_vars['shop_list_all']; ?>

				</div>
			</div>
			<div class="con">
				<ul class="w_list">
				
				<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['hot_shops_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<li>
						<div class="div_h10px"></div>
						<div class="s_listimg"><a href="http://<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php if ($this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['shoplogo'] != ''): ?><img src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['shoplogo']; ?>
" /><?php else: ?><img width="94" height="94" src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/shop_logo.gif" /><?php endif; ?></a></div>
						<div class="s_listcon">
							<p><b><?php echo $this->_tpl_vars['shop_grade']; ?>
<!--等级：旗舰店--></b><a href="http://<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
</a></p>
							<div class="sl_con">
								<p><?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['shopinfo']; ?>
</p>
								<a href="http://<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
"><?php echo $this->_tpl_vars['shop_in']; ?>
<!--详情进入-->&gt;&gt;</a>
							</div>
						</div>
						<div class="div_h10px"></div>
					</li>
				<?php endfor; endif; ?>	
				</ul>
				<div class="clear"></div>
				<div class="shop_clist">
					<div class="shop_l_rightbg"></div>
					<div class="more3"><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_list.php?action=all_list"><?php echo $this->_tpl_vars['class_more']; ?>
&gt;&gt;</a></div>
					<div class="sclist_title"><?php echo $this->_tpl_vars['shop_class_list']; ?>
</div>
				</div>
				<ul class="sl_list">
				<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['node_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)0;
$this->_sections['i']['max'] = (int)4;
$this->_sections['i']['show'] = true;
if ($this->_sections['i']['max'] < 0)
    $this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
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
					<li>
						<h2><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_list.php?txt_class_top_id=<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['name']; ?>
</a></h2>
						<ul>
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
								<li><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_list.php?txt_class_top_id=<?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['node_array'][$this->_sections['i']['index']]['sub_array'][$this->_sections['j']['index']]['name']; ?>
</a></li>
							<?php endfor; endif; ?>
						</ul>
						<div class="clear"></div>
					</li>
				<?php endfor; endif; ?>	
				</ul>
				
				<div class="clear"></div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
		</div>
		<div class="w_conright shopl_right">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead new_shop">
				<strong><?php echo $this->_tpl_vars['new_shops']; ?>
</strong>
				</div>
			</div>
			<div class="con">
				<div class="w_crcon">
					<ul>
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['new_shops_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<li>
							<div class="div_h10px"></div>
							<div class="s_listimg"><a href="http://<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php if ($this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shoplogo'] != ''): ?><img height="70" width="70" src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shoplogo']; ?>
" /><?php else: ?><img height="70" width="70" src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/shop_logo.gif" /><?php endif; ?></a></div>
							<div class="s_listcon">
								<p><a href="http://<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
</a></p>
								<div class="sl_con">
									<p><?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopinfo']; ?>
</p>
									<a href="#"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/shop_go.gif" width="64" height="18" /></a>
								</div>
							</div>
							<div class="clear"></div>
							<div class="div_h10px"></div>
						</li>
					<?php endfor; endif; ?>
					</ul>
					<div class="s_join">
					
					<button class="" type="button" onclick="window.location.href='<?php echo $this->_tpl_vars['site_url']; ?>
/member/shop_user.php'"><?php echo $this->_tpl_vars['shop_reg']; ?>
<!--商 家 加 盟--></button>
					</div>
					<div class="clear"></div>
				</div>
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