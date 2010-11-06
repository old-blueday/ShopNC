<?php /* Smarty version 2.6.9, created on 2009-08-01 17:57:20
         compiled from shop_info.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['atticle_content_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['atticle_content_description']; ?>
" /> 
<title><?php echo $this->_tpl_vars['article_array']['title']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><?php echo $this->_tpl_vars['article_array']['info_title']; ?>

				</div>
			</div>
			<div class="con">
			<div class="clear"></div>
				<div class="article">
					<h1><?php echo $this->_tpl_vars['article_array']['info_title']; ?>
</h1>
					<div class="article_con">
						<?php echo $this->_tpl_vars['article_array']['info_text']; ?>

					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
		</div>
		<div class="w_conright">
			
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead w_shop">
				<strong><?php echo $this->_tpl_vars['art_sys_info']; ?>
</strong>
				</div>
			</div>
			<div class="con">
				<div class="w_crcon">
					<ul class="w_cr_hotshop">
					<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['foot_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['list']['show'] = true;
$this->_sections['list']['max'] = $this->_sections['list']['loop'];
$this->_sections['list']['step'] = 1;
$this->_sections['list']['start'] = $this->_sections['list']['step'] > 0 ? 0 : $this->_sections['list']['loop']-1;
if ($this->_sections['list']['show']) {
    $this->_sections['list']['total'] = $this->_sections['list']['loop'];
    if ($this->_sections['list']['total'] == 0)
        $this->_sections['list']['show'] = false;
} else
    $this->_sections['list']['total'] = 0;
if ($this->_sections['list']['show']):

            for ($this->_sections['list']['index'] = $this->_sections['list']['start'], $this->_sections['list']['iteration'] = 1;
                 $this->_sections['list']['iteration'] <= $this->_sections['list']['total'];
                 $this->_sections['list']['index'] += $this->_sections['list']['step'], $this->_sections['list']['iteration']++):
$this->_sections['list']['rownum'] = $this->_sections['list']['iteration'];
$this->_sections['list']['index_prev'] = $this->_sections['list']['index'] - $this->_sections['list']['step'];
$this->_sections['list']['index_next'] = $this->_sections['list']['index'] + $this->_sections['list']['step'];
$this->_sections['list']['first']      = ($this->_sections['list']['iteration'] == 1);
$this->_sections['list']['last']       = ($this->_sections['list']['iteration'] == $this->_sections['list']['total']);
?> <!--系统信息列表-->
						<li><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_info.php?info_id=<?php echo $this->_tpl_vars['foot_array'][$this->_sections['list']['index']]['info_id']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['foot_array'][$this->_sections['list']['index']]['info_title']; ?>
"><?php echo $this->_tpl_vars['foot_array'][$this->_sections['list']['index']]['info_title']; ?>
</a></li>
					<?php endfor; endif; ?>
					</ul>
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