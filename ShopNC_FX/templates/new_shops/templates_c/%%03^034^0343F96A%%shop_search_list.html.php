<?php /* Smarty version 2.6.9, created on 2009-08-01 16:40:41
         compiled from shop_search_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'shop_search_list.html', 31, false),array('modifier', 'date_format', 'shop_search_list.html', 58, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['class_info']['classname']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
<script language="javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/select_area_zh-cn.js"></script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft sl_list">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a>
				<?php if ($this->_tpl_vars['class_info']['classname'] != ''): ?>
				<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php?txt_class_top_id=<?php echo $this->_tpl_vars['class_info']['tid']; ?>
"><?php echo $this->_tpl_vars['class_info']['classname']; ?>
</a>
				<?php endif; ?>
				<?php echo $this->_tpl_vars['shop_list_all']; ?>

				</div>
			</div>
			<div class="con">
				<div class="s_listhline">
					<div class="sl_listtitle">
						<?php echo $this->_tpl_vars['shop_goods_count']; ?>
<!--共有--> <strong><?php echo ((is_array($_tmp=@$this->_tpl_vars['shop_count'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</strong> <?php echo $this->_tpl_vars['shop_goods_count1']; ?>
<!--家店铺--> </div>
					<div class="pages">
						<?php echo $this->_tpl_vars['page_list']; ?>

					</div>
					<div class="clear"></div>
				</div>
					<table width="730" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<th width="100"><?php echo $this->_tpl_vars['shop_pic']; ?>
<!--店铺标志--></th>
							<th width="250"><strong><?php echo $this->_tpl_vars['shop_name']; ?>
</strong></th>
							<th width="120"><?php echo $this->_tpl_vars['shop_goods_num']; ?>
<!--商品数量--></th>
							<th width="160"><?php echo $this->_tpl_vars['shop_reg_time']; ?>
<!--开店时间--></th>
							<th><?php echo $this->_tpl_vars['shop_address']; ?>
<!--所在地--></th>
						</tr>
						<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['shop_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<tr>
							<td><a href="http://<?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php if ($this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['shoplogo'] != ''): ?><img width="94" height="94" src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['shoplogo']; ?>
" class="picintab" /><?php else: ?><img width="94" height="94" src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/shop_logo.gif"  class="picintab"/><?php endif; ?></a></td>
							<td>
								<div class="s_listcon">
									<p><a href="http://<?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['shopname']; ?>
</a></p>
									<div class="sl_con">
										<p><?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['shopinfo']; ?>
</p>
										<b><?php echo $this->_tpl_vars['shop_list_class']; ?>
<!--分类-->：</b><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php?txt_class_top_id=<?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['tid']; ?>
"><?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['classname']; ?>
</a>
									</div>
								</div>
							</td>
							<td><?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['goods_count']; ?>
</td>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['createtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
							<td><?php echo $this->_tpl_vars['shop_array'][$this->_sections['i']['index']]['province']; ?>
</td>
						</tr>
						<?php endfor; endif; ?>
					</table>
				<div class="pages">
					<?php echo $this->_tpl_vars['page_list']; ?>

				</div>
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
" target="_blank"><?php if ($this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shoplogo'] != ''): ?><img width="70" height="70" src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shoplogo']; ?>
" /><?php else: ?><img width="70" height="70" src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/shop_logo.gif" /><?php endif; ?></a></div>
							<div class="s_listcon">
								<p><a href="http://<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
" target="_blank"><?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopname']; ?>
</a></p>
								<div class="sl_con">
									<p><?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['shopinfo']; ?>
</p>
									<a href="http://<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
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