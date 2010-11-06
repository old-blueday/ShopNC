<?php /* Smarty version 2.6.9, created on 2009-08-01 16:34:07
         compiled from header.html */ ?>
<script>
//提交表单，确定搜索路径
function search_submit(){
	if($('#search_type_nav').val() == 'product'){
		$('#form_search_nav').attr('action','<?php echo $this->_tpl_vars['site_url']; ?>
/shop_search.php');
	 }else{
	 	$('#form_search_nav').attr('action','<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php');
	 }
   	$('#form_search_nav').submit();
}
</script>
	<!--header-->
	<div id="header">
		<!--上半部分-->
		<div class="header_top">
			<div class="top_menu">
				<ul>
					<?php if ($_SESSION['shop_user_name'] == '' && $_SESSION['shop_user_id'] == ''): ?>
						<li><?php echo $this->_tpl_vars['hello1']; ?>
 </li>
						<li>[<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/member/shop_user.php?action=login"><?php echo $this->_tpl_vars['login']; ?>
</a>]</li>
						<li>[<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/member/shop_user.php"><?php echo $this->_tpl_vars['reg']; ?>
</a>]</li>
					<?php else: ?>
						<li><?php echo $this->_tpl_vars['hello'];  echo $_SESSION['shop_user_name']; ?>
</li>
						<li>[<a href="http://<?php echo $_SESSION['shop_domain'];  echo $this->_tpl_vars['domainname']; ?>
"><?php echo $this->_tpl_vars['myshop']; ?>
</a>]</li>
						<li>[<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/member/shop_center.php"><?php echo $this->_tpl_vars['user_center']; ?>
</a>]</li>
						<li>[<a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/member/shop_user.php?action=out"><?php echo $this->_tpl_vars['exit']; ?>
</a>]</li>
					<?php endif; ?>
					<li class="help"><a target="_blank" href="http://www.shopnc.net"><?php echo $this->_tpl_vars['help']; ?>
<!--帮助--></a></li>
					<li class="ropmenu_r"></li>
				</ul>
			</div>
			<div class="logo"><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><img src="<?php if ($this->_tpl_vars['shop_logo_file'] != ''):  echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['shop_logo_file'];  else:  echo $this->_tpl_vars['templates_subpath']; ?>
/images/logo.gif<?php endif; ?>" height="33" /></a></div>
			<div class="clear"></div>
		</div>
		<!--end 上半部分-->
		<!--导航及下半部分-->
		<div class="header_main">
			<div class="menu">
				<!--导航-->
				<ul class="menu_list1">
					<li <?php if ($_GET['shop_type'] == '' && $_GET['id'] == '' && $_GET['txt_class_top_id'] == ''): ?>class="menu_select"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
"><?php echo $this->_tpl_vars['home_name']; ?>
</a></li>
					<li <?php if ($_GET['shop_type'] == 'shop'): ?>class="menu_select"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php?action=index&shop_type=shop"><?php echo $this->_tpl_vars['search_index_shop']; ?>
<!--店铺--></a></li>
					<li <?php if ($_GET['shop_type'] == 'goods'): ?>class="menu_select"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_search.php?action=search&shop_type=goods"><?php echo $this->_tpl_vars['search_index_goods']; ?>
<!--商品--></a></li>
					<li class="menu_list1_r">
						<ul>

						<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['header_menu_array1']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li <?php if ($_GET['txt_class_top_id'] == $this->_tpl_vars['header_menu_array1'][$this->_sections['i']['index']]['id']): ?>class="menu_select"<?php elseif ($this->_sections['i']['rownum'] == 1): ?>class="menu_last"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php?txt_class_top_id=<?php echo $this->_tpl_vars['header_menu_array1'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['header_menu_array1'][$this->_sections['i']['index']]['name']; ?>
</a></li>
						<?php endfor; endif; ?>

						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['header_menu_array2']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<li <?php if ($_GET['id'] == $this->_tpl_vars['header_menu_array2'][$this->_sections['list']['index']]['cid']): ?>class="menu_select"<?php elseif ($this->_sections['list']['rownum'] == 1 && $this->_tpl_vars['header_menu_array1'] == null): ?>class="menu_last"<?php endif; ?>><a href="<?php if ($this->_tpl_vars['header_menu_array2'][$this->_sections['list']['index']]['urlstate'] == '0'):  echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_list&id=<?php echo $this->_tpl_vars['header_menu_array2'][$this->_sections['list']['index']]['cid'];  else:  echo $this->_tpl_vars['header_menu_array2'][$this->_sections['list']['index']]['url'];  endif; ?>" ><?php echo $this->_tpl_vars['header_menu_array2'][$this->_sections['list']['index']]['cname']; ?>
</a></li>
						<?php endfor; endif; ?>
							<!--<li class="menu_last"><a href="#">时尚女人</a></li>-->
						</ul>
					</li>
				</ul>
				<!--end 导航-->
				<!--热门搜索-->
				<ul class="menu_list2">
					<?php $_from = $this->_tpl_vars['search_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['keywords']):
?>
					<li><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_search.php?search_type=product&txt_keywords=<?php echo $this->_tpl_vars['keywords']; ?>
"><?php echo $this->_tpl_vars['keywords']; ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
				<!--end 热门搜索-->
				<!--search-->
				<div class="search">
					<div class="search_th">
					<form name="form_search_nav" id="form_search_nav" action="" method="get">
						<select name="search_type" id="search_type_nav">
							<option value="product"><?php echo $this->_tpl_vars['search_goods']; ?>
<!--搜索商品--></option>
							<option value="shop"><?php echo $this->_tpl_vars['search_shop']; ?>
<!--搜索店铺--></option>
						</select>
						<input type="text" value=""  name="txt_keywords" id="txt_keywords_nav" class="text"/>

					<select name="txt_class_top_id" id="txt_class_top_id_nav">
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
						<button class="" onclick="search_submit()" type="button"><?php echo $this->_tpl_vars['search']; ?>
<!--搜 索--></button>
					</form>
					</div>
				</div>
				<!--end search-->
				<div class="hs_indexbut"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_search.php?action=search_adv">[<?php echo $this->_tpl_vars['search_adv']; ?>
]</a></div>
				<!--快捷按钮-->
				<ul class="menu_list3">
					<li class="cart"><a href="#"><span>购物车</span></a></li>
					<li><a href="#">收藏夹</a></li>
					<li class="order"><a href="#"><span>我的订单</span></a></li>
					<li class="point"><a href="#">积分</a></li>
				</ul>
				<!--end 快捷按钮-->
				<div class="clear"></div>
			</div>
		</div>
		<!--end 导航及下半部分-->
	</div>
	<!--end header-->