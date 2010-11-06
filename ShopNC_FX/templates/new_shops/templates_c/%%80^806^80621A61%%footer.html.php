<?php /* Smarty version 2.6.9, created on 2009-08-01 16:34:07
         compiled from footer.html */ ?>

		<div class="w_conbot">
			<div class="w_cbleft">
				<ul>
					<li>
						<span><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_article.php?action=article&id=<?php echo $this->_tpl_vars['artclass_array']['4']['0']['arc_class']; ?>
"><?php echo $this->_tpl_vars['artclass_array']['4']['0']['cname']; ?>
</a></span>
						<?php $_from = $this->_tpl_vars['artclass_array']['4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub_class']):
?>
							<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['sub_class']['aid']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['sub_class']['title']; ?>
"><?php echo $this->_tpl_vars['sub_class']['title']; ?>
</a>
						<?php endforeach; endif; unset($_from); ?>
					</li>
					<li>
						<span><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_article.php?action=article&id=<?php echo $this->_tpl_vars['artclass_array']['5']['0']['arc_class']; ?>
"><?php echo $this->_tpl_vars['artclass_array']['5']['0']['cname']; ?>
</a></span>
						<?php $_from = $this->_tpl_vars['artclass_array']['5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub_class']):
?>
							<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['sub_class']['aid']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['sub_class']['title']; ?>
"><?php echo $this->_tpl_vars['sub_class']['title']; ?>
</a>
						<?php endforeach; endif; unset($_from); ?>
					</li>
					<li>
						<span><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_article.php?action=article&id=<?php echo $this->_tpl_vars['artclass_array']['6']['0']['arc_class']; ?>
"><?php echo $this->_tpl_vars['artclass_array']['6']['0']['cname']; ?>
</a></span>
						<?php $_from = $this->_tpl_vars['artclass_array']['6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub_class']):
?>
							<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['sub_class']['aid']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['sub_class']['title']; ?>
"><?php echo $this->_tpl_vars['sub_class']['title']; ?>
</a>
						<?php endforeach; endif; unset($_from); ?>
					</li>											
				</ul>
			</div>
			<div class="w_cbright">
				<div class="search_th">
					<form name="form_search_foot" id="form_search_foot" method="get" action="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php">
					<select name="txt_class_top_id" id="txt_class_top_id_bottom">	
						<option selected="selected" value=""><?php echo $this->_tpl_vars['all_class']; ?>
<!--所有分类--></option>
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
					<input type="text" value=""  name="txt_keywords" id="txt_keywords_bottom" class="text"/>
					<div class="seach_but" onClick="$('#form_search_foot').submit();"></div>
					</form>
				</div>
				<div class="clear"></div>
				<p>客服电话：022-00000000</p>
				<p>客服热线不受理商品咨询！如需购买咨询，请直接联系出售该商品的商家。</p>
			</div>
			<div class="clear"></div>
		</div>

	<!--footer-->
	<div id="copyright">
		<!--底部导航-->
		<ul>
  <?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['info_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
  	<?php if ($this->_tpl_vars['info_array'][$this->_sections['list']['index']]['info_id'] != 8): ?>
    	<li><a href="<?php if ($this->_tpl_vars['info_array'][$this->_sections['list']['index']]['info_url'] == ''):  echo $this->_tpl_vars['Site_Url']; ?>
/shop_info.php?info_id=<?php echo $this->_tpl_vars['info_array'][$this->_sections['list']['index']]['info_id'];  else:  echo $this->_tpl_vars['info_array'][$this->_sections['list']['index']]['info_url'];  endif; ?>"><?php echo $this->_tpl_vars['info_array'][$this->_sections['list']['index']]['info_title']; ?>
</a></li>
	<?php endif; ?>
	<?php endfor; endif; ?>
		</ul>
		<!--end 底部导航-->
		<div class="clear"></div>
		    <p><?php echo $this->_tpl_vars['shop_copyright']; ?>
</p>
			<p><?php echo $this->_tpl_vars['shop_ipc']; ?>
</p>
	</div>
	<!--end footer-->