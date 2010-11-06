<?php /* Smarty version 2.6.9, created on 2009-08-01 16:41:41
         compiled from product_search_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['search_result']; ?>
 - <?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" />
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.cookie.js"></script>
<script language="javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/select_area_zh-cn.js"></script>
<script type="text/javascript">
$(document).ready(function() { 

	if ($.cookie('list_box_type')==1){
			$('#product_list_tab').addClass('s_typelist');
			$('#product_list_tab_bottom').addClass('s_typelist');
			$('#product_list_content').addClass('s_piclist');
	}else{
			$('#product_list_tab').removeClass('s_typelist');
			$('#product_list_tab_bottom').removeClass('s_typelist');
			$('#product_list_content').removeClass('s_piclist');
	}
	$("#product_list_tab,#product_list_tab_bottom").click(function(){
		if ($.cookie('list_box_type')==1){
			$.cookie('list_box_type', 2, { expires: 7 });
		}else{
			$.cookie('list_box_type', 1, { expires: 7 });
		}
		if ($('#product_list_tab')[0].className== 's_typesel')
		{
			$('#product_list_tab').addClass('s_typelist');
			$('#product_list_tab_bottom').addClass('s_typelist');
			$('#product_list_content').addClass('s_piclist');
		}else{
			$('#product_list_tab').removeClass('s_typelist');
			$('#product_list_tab_bottom').removeClass('s_typelist');
			$('#product_list_content').removeClass('s_piclist');
		}
	});
	iniProvince(document.getElementById('txtProvince_left'));
	document.getElementById('txt_class_top_id_left').value='<?php echo $_GET['txt_class_top_id']; ?>
';
	document.getElementById('txtProvince_left').value='<?php echo $_GET['txtProvince']; ?>
';
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
		<div class="w_conleft s_conright">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_location']; ?>
： </strong><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
"><?php echo $this->_tpl_vars['shops_name']; ?>
</a><span><?php echo $this->_tpl_vars['search_result']; ?>
</a></span><?php echo $this->_tpl_vars['keywords']; ?>

				</div>
			</div>
			<div class="con">
				<div class="s_listhline">
					<div class="s_listtitle">
						<table width="0" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?php echo $this->_tpl_vars['show_type']; ?>
：</td>
								<td width="90">
									<div id="product_list_tab" class="s_typesel s_typelist">
										<!--  切换追加s_typelist 反之删除   -->
										<div class="s_typel"></div>
										<div class="s_typer"></div>
									</div>
								</td>
								<td><?php echo $this->_tpl_vars['sort_type']; ?>
：</td>
								<td width="100"><select name="sort" onchange="javascript:location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php?<?php echo $this->_tpl_vars['query_string']; ?>
&num=<?php echo $this->_tpl_vars['num']; ?>
&sort='+this.value">
				  	<option value="new" <?php if ($this->_tpl_vars['sort'] == 'new'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['show_new_goods']; ?>
</option>
				  	<option value="pricedesc" <?php if ($this->_tpl_vars['sort'] == 'pricedesc'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['show_price_desc']; ?>
</option>
				  	<option value="price" <?php if ($this->_tpl_vars['sort'] == 'price'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['show_price']; ?>
</option>
			      </select></td>
								<!-- <td><?php echo $this->_tpl_vars['show_num']; ?>
：</td>
								<td width="100"><select name="num" onchange="javascript:location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php?<?php echo $this->_tpl_vars['query_string']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&num='+this.value">
				  	<option value="12" <?php if ($this->_tpl_vars['num'] == '12'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['perpage_show']; ?>
 12 <?php echo $this->_tpl_vars['item']; ?>
</option>
				  	<option value="24" <?php if ($this->_tpl_vars['num'] == '24'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['perpage_show']; ?>
 24 <?php echo $this->_tpl_vars['item']; ?>
</option>
				  	<option value="36" <?php if ($this->_tpl_vars['num'] == '36'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['perpage_show']; ?>
 36 <?php echo $this->_tpl_vars['item']; ?>
</option>
			      </select></td> -->
							</tr>
						</table>

					</div>
					<div class="pages">
					<?php echo $this->_tpl_vars['product_class_page']; ?>

					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<ul id="product_list_content" class="w_list"><!--  去掉s_piclist为列表显示  加上s_piclist则为图片显示  -->
					
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['product_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<div class="s_listimg"><a href="http://<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_id']; ?>
"><img src="<?php if ($this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_small_image'] != '' && $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_small_image'] != 'default.jpg'): ?> http://<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_small_image'];  else:  echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.jpg<?php endif; ?>" width="96" height="96" /></a></div>
						<div class="s_listcon">
							<p><a href="http://<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_id']; ?>
"><?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_name']; ?>
</a></p>
							<strong><?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_pricedesc']; ?>
</strong>
							<b><?php echo $this->_tpl_vars['price']; ?>
:￥<em><?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_price']; ?>
</em></b>
						</div>
						<div class="s_listright">
							<div class="s_shopabout">
								<b><?php echo $this->_tpl_vars['from_shop']; ?>
</b>
								<strong><a href="http://<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
"><?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['shopname']; ?>
</a></strong>
							</div>
							<div class="s_itemgo"><a href="http://<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/shopping.php?goods_id=<?php echo $this->_tpl_vars['product_array'][$this->_sections['i']['index']]['goods_id']; ?>
&goods_num=1"><?php echo $this->_tpl_vars['shop_click_buy']; ?>
<!--点击查看或购买--></a></div>
						</div>
						<div class="div_h10px"></div>
					</li>
					
					<?php endfor; endif; ?>
					
				</ul>
				<div class="clear"></div>
				<div class="s_listhline bottom">
					<div class="s_listtitle">
						<table width="0" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?php echo $this->_tpl_vars['show_type']; ?>
：</td>
								<td width="90">
									<div id="product_list_tab_bottom" class="s_typesel">
										<!--  切换追加s_typelist 反之删除   -->
										<div class="s_typel"></div>
										<div class="s_typer"></div>
									</div>
								</td>
								<td><?php echo $this->_tpl_vars['sort_type']; ?>
：</td>
								<td width="100"><select name="sort" onchange="javascript:location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php?<?php echo $this->_tpl_vars['query_string']; ?>
&num=<?php echo $this->_tpl_vars['num']; ?>
&sort='+this.value">
				  	<option value="new" <?php if ($this->_tpl_vars['sort'] == 'new'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['show_new_goods']; ?>
</option>
				  	<option value="pricedesc" <?php if ($this->_tpl_vars['sort'] == 'pricedesc'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['show_price_desc']; ?>
</option>
				  	<option value="price" <?php if ($this->_tpl_vars['sort'] == 'price'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['show_price']; ?>
</option>
			      </select></td>
								<!-- <td><?php echo $this->_tpl_vars['show_num']; ?>
：</td>
								<td width="100"><select name="num" onchange="javascript:location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php?<?php echo $this->_tpl_vars['query_string']; ?>
&sort=<?php echo $this->_tpl_vars['sort']; ?>
&num='+this.value">
				  	<option value="12" <?php if ($this->_tpl_vars['num'] == '12'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['perpage_show']; ?>
 12 <?php echo $this->_tpl_vars['item']; ?>
</option>
				  	<option value="24" <?php if ($this->_tpl_vars['num'] == '24'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['perpage_show']; ?>
 24 <?php echo $this->_tpl_vars['item']; ?>
</option>
				  	<option value="36" <?php if ($this->_tpl_vars['num'] == '36'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['perpage_show']; ?>
 36 <?php echo $this->_tpl_vars['item']; ?>
</option>
			      </select></td> -->
							</tr>
						</table>

					</div>
					<div class="pages">
					<?php echo $this->_tpl_vars['product_class_page']; ?>

				</div>
					<div class="clear"></div>
				</div>
				
				<div class="clear"></div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
		</div>
		<div class="w_conright s_conleft">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead w_wlist">
				<strong><?php echo $this->_tpl_vars['shop_select_area']; ?>
<!--筛选缩小范围--></strong>
				</div>
			</div>
			<div class="con">
				<div class="w_crcon">
					<div class="div_h10px"></div>
					<form action="" method="get" name="form_search_left" id="form_search_left">
					<input type="hidden" name="action" value="search" />
					<table class="s_selclass" width="0" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="50"><?php echo $this->_tpl_vars['shop_keywords']; ?>
<!--关键字--></td>
							<td width="130"><input type="text" id="txt_keywords_left" value="<?php echo $_GET['txt_keywords']; ?>
" name="txt_keywords" class="inputbg" size="17" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_tpl_vars['shop_class_select']; ?>
<!--分类选择--></td>
							<td><select name="txt_class_top_id" id="txt_class_top_id_left">
							<option value=""><?php echo $this->_tpl_vars['shop_all_class']; ?>
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
                    </select></td>
						</tr>
						<tr>
							<td><?php echo $this->_tpl_vars['shop_price_area']; ?>
<!--价格范围--></td>
							<td><input type="text" name="txt_start_price" id="txt_start_price" class="inputbg shortinput" size="6" /> <?php echo $this->_tpl_vars['shop_to']; ?>
<!--到--> <input type="text" name="txt_end_price" id="txt_end_price" class="inputbg shortinput" size="6" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_tpl_vars['shop_area']; ?>
<!--所在地--></td>
							<td><select name="txtProvince" id="txtProvince_left">
					</select></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><div class="sel_but" onclick="$('#form_search_left').submit();"></div></td>
						</tr>
					</table></form>
					<div class="clear"></div>
				</div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
			
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead w_shop">
				<strong><?php echo $this->_tpl_vars['hot_shop']; ?>
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
	</div>
	<!--end content-->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of footer -->	
</div>
</body>
</html>