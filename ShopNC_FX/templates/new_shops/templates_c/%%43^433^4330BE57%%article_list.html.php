<?php /* Smarty version 2.6.9, created on 2009-08-01 17:06:33
         compiled from article_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'article_list.html', 37, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['article_array']['0']['cname']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['article_class_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['article_class_description']; ?>
" />
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
		<div class="w_conleft">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a>
				<?php if ($this->_tpl_vars['article_array']['0']['cname']): ?>
					<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article&id=<?php echo $this->_tpl_vars['article_array']['0']['cid']; ?>
"><?php echo $this->_tpl_vars['article_array']['0']['cname']; ?>
</a>
				<?php endif; ?>
				<?php echo $this->_tpl_vars['artic_list']; ?>

				</div>
			</div>
			<div class="con">
			<div class="clear"></div>
				<h2><span><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_article.php"><?php echo $this->_tpl_vars['all_article']; ?>
<!--全部文章--></a></span><b></b></h2>
				<div class="pages">
				<?php echo $this->_tpl_vars['show_page']; ?>

				</div>
				<div class="clear"></div>
				<ul class="w_list">

                	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['article_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<li><span><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article&id=<?php echo $this->_tpl_vars['article_array'][$this->_sections['i']['index']]['cid']; ?>
">[<?php echo $this->_tpl_vars['article_array'][$this->_sections['i']['index']]['cname']; ?>
]</a></span><b><?php echo ((is_array($_tmp=$this->_tpl_vars['article_array'][$this->_sections['i']['index']]['atime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
</b><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['article_array'][$this->_sections['i']['index']]['aid']; ?>
" title="<?php echo $this->_tpl_vars['article_array'][$this->_sections['i']['index']]['title']; ?>
"><?php echo $this->_tpl_vars['article_array'][$this->_sections['i']['index']]['title']; ?>
</a></li>
                    <?php endfor; endif; ?>
				</ul>
				<div class="pages">
				<?php echo $this->_tpl_vars['show_page']; ?>

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
				<div class="w_tithead w_wlist">
				<strong><?php echo $this->_tpl_vars['artic_class']; ?>
</strong>
				</div>
			</div>
			<div class="con">
				<div class="w_crcon">

				<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['artclass_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<?php if ($this->_sections['i']['rownum'] < 4): ?>
					<!-- <div class="w_crconh2_r"></div> -->
					<h2><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_article.php?action=article&id=<?php echo $this->_tpl_vars['artclass_array'][$this->_sections['i']['index']]['cid']; ?>
"><?php echo $this->_tpl_vars['artclass_array'][$this->_sections['i']['index']]['cname']; ?>
</a></h2>
					<div class="clear"></div>
					<div class="w_list_con">
						<ul>
							<?php $_from = $this->_tpl_vars['artclass_array'][$this->_sections['i']['index']]['body']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub_class']):
?>
								<li><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['sub_class']['aid']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['sub_class']['title']; ?>
"><?php echo $this->_tpl_vars['sub_class']['title']; ?>
</a></li>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					</div>
					<div class="clear"></div>
				<?php endif; ?>	
				<?php endfor; endif; ?>

				</div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>

			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead w_shop">
				<strong><?php echo $this->_tpl_vars['hot_shops']; ?>
<!--热门店铺--></strong>
				</div>
			</div>
			<div class="con">
				<div class="w_crcon">
					<ul class="w_cr_hotshop">
					<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['hot_shops_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?> <!--热门商店-->
						<li><a href="http://<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
"><?php echo $this->_tpl_vars['hot_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
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

	<!--end content-->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of footer -->
</div>
</body>
</html>