<?php /* Smarty version 2.6.9, created on 2009-08-01 16:34:07
         compiled from index.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['shops_name']; ?>
</title>
<meta http-equiv="keywords" content="<?php echo $this->_tpl_vars['shops_keywords']; ?>
" />
<meta http-equiv="description" content="<?php echo $this->_tpl_vars['shops_description']; ?>
" />
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/pic.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/tab.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['site_url']; ?>
/js/jquery/jquery.js"></script>
<script src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/js/tab.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- 头部信息header -->
	<!--content-->
	<div id="content">
		<!--左上-->
		<div class="leftcon">
			<!--顶部小广告-->
			<div class="ltop_pic"><a target="_blank" href="<?php echo $this->_tpl_vars['other_ad_image']['0']['url']; ?>
" title="<?php echo $this->_tpl_vars['other_ad_image']['0']['title']; ?>
"><img src="<?php echo $this->_tpl_vars['other_ad_image']['0']['img_path']; ?>
" width="190" height="51" alt="about" /></a></div>
			<!--end 顶部小广告-->
			<div class="con_top"><span class="ctop_left"></span><span class="ctop_right"></span></div>
			<div class="con">
				<!--分类-->
				
				<!--店铺一级分类循环 开始-->
				<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['shop_class_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<h2><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_search.php?action=search&txt_class_top_id=<?php echo $this->_tpl_vars['shop_class_array'][$this->_sections['list']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['shop_class_array'][$this->_sections['list']['index']]['name']; ?>
</a></h2>
				<ul>
					<!--店铺二级分类循环 开始-->
					<?php $_from = $this->_tpl_vars['shop_class_array'][$this->_sections['list']['index']]['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sub_class']):
?>
						<li><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/shop_search.php?action=search&txt_class_top_id=<?php echo $this->_tpl_vars['sub_class']['id']; ?>
"><?php echo $this->_tpl_vars['sub_class']['name']; ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					<!--店铺二级分类循环 结束-->
				</ul>
				<div class="clear"></div>
				<?php endfor; endif; ?>
				<!--店铺一级分类循环 结束-->			
				<!--end 分类-->
				<div class="clear"></div>
				<div class="all_class"><a href="shop_list.php?action=all_list">全部分类&gt;&gt;</a></div>
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
		</div>
		<!--end 左上-->
		<!--中上-->
		<div class="centercon">
			<!-- 焦点图片轮换 -->
			<div id="mainbanner">
				<div class="pic_content">
					<div id="switchbanner">
						<div id="switchbanner_bg">&nbsp;</div>
						<div id="switchbanner_info">&nbsp;</div>
						<div id="switchbanner_text">
							<ul>
								<li>1</li>
								<li>2</li>
								<li>3</li>
								<li>4</li>
								<li>5</li>
							</ul>
						</div>
						<div id="switchbanner_list" class="switchbanner">
						<?php unset($this->_sections['list']);
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['ad_images']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['list']['name'] = 'list';
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
						<a href="<?php echo $this->_tpl_vars['ad_images'][$this->_sections['list']['index']]['url']; ?>
" target="_blank"> <img src="<?php echo $this->_tpl_vars['ad_images'][$this->_sections['list']['index']]['img_path']; ?>
" alt="<?php echo $this->_tpl_vars['ad_images'][$this->_sections['list']['index']]['title']; ?>
" /></a>
						<?php endfor; endif; ?>
						</div>
					</div>
					<script type="text/javascript">
		var t = n = 0, count = $("#switchbanner_list a").size();
		$(function(){	
			$("#switchbanner_list a:not(:first-child)").hide();
			$("#switchbanner_info").html($("#switchbanner_list a:first-child").find("img").attr('alt'));
			$("#switchbanner_text li:first-child").css({"background":"#fff",'color':'#000'});
			$("#switchbanner_info").click(function(){window.open($("#switchbanner_list a:first-child").attr('href'), "_blank")});
			$("#switchbanner_text li").click(function() {
				var i = $(this).text() - 1;
				n = i;
				if (i >= count) return;
				$("#switchbanner_info").html($("#switchbanner_list a").eq(i).find("img").attr('alt'));
				$("#switchbanner_info").unbind().click(function(){window.open($("#switchbannery_list a").eq(i).attr('href'), "_blank")})
				$("#switchbanner_list a").filter(":visible").fadeOut(800).parent().children().eq(i).fadeIn(1200);
				$(this).css({"background":"#fff",'color':'#000'}).siblings().css({"background":"#000",'color':'#fff'});
			});
			t = setInterval("showAuto()", 5000);
			$("#switchbanner").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 5000);});
		})
		
		function showAuto()
		{
			n = n >= (count - 1) ? 0 : ++n;
			$("#switchbanner_text li").eq(n).trigger('click');
		}
		</script>
				</div>
			</div>
			<!-- end 焦点图片轮换 -->
			<!-- 商品展示滑动门 -->
			<div class="tagcon">
				<!-- menu -->
				<div class="more" onclick="window.location.href='<?php echo $this->_tpl_vars['site_url']; ?>
/shop_list.php?action=index&shop_type=shop'"></div>
				<ul id="tags">
					<li class="selectTag"><a><?php echo $this->_tpl_vars['star_shop']; ?>
</a> <!--明星店铺--></li>
					<!--<li><a onclick="selectTag('tagContent1',this)" href="javascript:void(0)">疯狂抢购</a> </li>
					<li><a onclick="selectTag('tagContent2',this)" href="javascript:void(0)">热销商品</a> </li>
					<li><a onclick="selectTag('tagContent3',this)" href="javascript:void(0)">每周推荐</a> </li>
					<li><a onclick="selectTag('tagContent4',this)" href="javascript:void(0)">特价专区</a> </li>-->
				</ul>
				
				<!-- end menu -->
				<!-- 内容 -->
				<div id="tagContent">
					<!-- 第1标签内容 -->
					<div class="tagContent selectTag" id="tagContent0">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['index_shops_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
" target="_blank"><?php if ($this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['shoplogo'] != ''): ?><img src="<?php echo $this->_tpl_vars['Site_Url']; ?>
/<?php echo $this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['shoplogo']; ?>
" /><?php else: ?><img width="94" height="94" src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/shop_logo.gif" /><?php endif; ?></a><br/>
							<a href="http://<?php echo $this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" title="<?php echo $this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
" target="_blank"><span><?php echo $this->_tpl_vars['index_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
</span></a><br/>
							</li>
						<?php endfor; endif; ?>		
						</ul>
					</div>
					<!-- end 第1标签内容 -->
					<!-- 第2标签内容 -->
					<div class="tagContent" id="tagContent1">第二个标签的内容</div>
					<!-- end 第2标签内容 -->
					<!-- 第3标签内容 -->
					<div class="tagContent" id="tagContent2">第三个标签的内容</div>
					<!-- end 第3标签内容 -->
					<!-- 第4标签内容 -->
					<div class="tagContent" id="tagContent3">第4个标签的内容</div>
					<!-- end 第4标签内容 -->
					<!-- 第5标签内容 -->
					<div class="tagContent" id="tagContent4">第5个标签的内容</div>
					<!-- end 第5标签内容 -->
					<div class="clear"></div>
				</div>
				<!-- end 内容 -->
			</div>
			<!-- end 商品展示滑动门 -->
		</div>
		<!--end 中上-->
		<!--右上-->
		<div class="rightcon">
			<!-- 网店公告 -->
			<div class="rightcon_top">
				<h2 class="red"><?php echo $this->_tpl_vars['dynamic_free_site']; ?>
<!-- 网店公告--></h2>
				<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['article_array_gg']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<li><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['article_array_gg'][$this->_sections['list']['index']]['aid']; ?>
"><?php echo $this->_tpl_vars['article_array_gg'][$this->_sections['list']['index']]['title']; ?>
</a></li>
						<?php endfor; endif; ?>
				</ul>
			</div>
			<!-- end 网店公告 -->
			<div class="con">
				<!-- 热门网店 -->
				<div class="more" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_list.php?action=index'"></div>
				<h2><?php echo $this->_tpl_vars['hot_shops']; ?>
<!--热门网店--></h2>
				<div class="clear"></div>
				<ul>
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
				<!-- end 热门网店 -->
				<div class="clear"></div>
				<!-- 新开网店 -->
				<div class="more" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_list.php?action=index'"></div>
				<h2><?php echo $this->_tpl_vars['new_shops']; ?>
<!--新开网店--></h2>
				<div class="clear"></div>
				<ul>
					<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['new_shops_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?> <!--新开网店-->
					<li><a href="http://<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
"><?php echo $this->_tpl_vars['new_shops_array'][$this->_sections['list']['index']]['shopname']; ?>
</a></li>
					<?php endfor; endif; ?>
				</ul>
				<!-- end 新开网店 -->
				<div class="clear"></div>
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
		</div>
		<!--end 右上-->
		<div class="clear"></div>
		<!-- 中部横屏展示 热门专区 -->
		<div class="langcon">
			<div class="lcon_top"><span class="lctop_left"></span><span class="lctop_right"></span></div>
			<div class="con">
			<div class="clear"></div>
				<div class="item_title"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/hot.gif" width="74" height="34" alt="热门专区" /></div>
				<div class="more" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php'"></div>
				<ul id="tagstw"><li></li></ul>
<!--				<ul id="tagstw">
					<li class="selectTag"><a onclick="selectTagtw('tagContenttw0',this)" href="javascript:void(0)">新品上市</a> </li>
					<li><a onclick="selectTagtw('tagContenttw1',this)" href="javascript:void(0)">疯狂抢购</a> </li>
					<li><a onclick="selectTagtw('tagContenttw2',this)" href="javascript:void(0)">热销商品</a> </li>
					<li><a onclick="selectTagtw('tagContenttw3',this)" href="javascript:void(0)">每周推荐</a> </li>
					<li><a onclick="selectTagtw('tagContenttw4',this)" href="javascript:void(0)">特价专区</a> </li>
				</ul>-->

				<div id="tagContenttw">
					<!-- 推荐商品 -->
					<div class="tagContent selectTag" id="tagContenttw0">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['commend_product']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_small_image'] != '' && $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_small_image'] != 'default.jpg'): ?><img src="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_small_image']; ?>
"  width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.jpg" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a>
								<b class="fC">￥<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>
					</div>
					<!-- 疯狂抢购 -->
<!--					<div class="tagContent" id="tagContenttw1">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['click_product']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['click_product'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['click_product'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>
					</div>-->
					<!-- 热销商品 -->
<!--					<div class="tagContent" id="tagContenttw2">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['hot_product']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['hot_product'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>
					</div>-->
					<!-- 每周推荐 -->
<!--					<div class="tagContent" id="tagContenttw3">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['commend_product']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>
					</div>-->
					<!-- 特价专区 -->
<!--					<div class="tagContent" id="tagContenttw4">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['spe_product']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['commend_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['spe_product'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>
					</div>-->
					<div class="clear"></div>
				</div>
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
		</div>
		<!-- end 中部横屏展示 热门专区 -->
		<!-- 中下展示左 时尚潮流 -->
<!--		<div class="lcon_left">
			<div class="con_top"><span class="ctop_left"></span><span class="ctop_right"></span></div>
			<div class="con">
				<div class="item_title"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/fashion.gif" width="74" height="35" alt="热门专区" /></div>
				<div class="more" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php'"></div>
				<ul id="tagsth">
					<li class="selectTag"><a onclick="selectTagth('tagContentth0',this)" href="javascript:void(0)">新品上市</a> </li>
					<li><a onclick="selectTagth('tagContentth1',this)" href="javascript:void(0)">疯狂抢购</a> </li>
				</ul>
				<div id="tagContentth">
					新品上市
					<div class="tagContent selectTag" id="tagContentth0">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['new_product_s']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['new_product_s'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>
					</div>
					疯狂抢
					<div class="tagContent" id="tagContentth1">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['click_product_s']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['click_product_s'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>
						</ul>					
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
		</div>
		购-->
		<!-- end 中下展示左 时尚潮流 -->
		<!-- 中下展示右 新品速递 -->
<!--		<div class="lcon_right">
			<div class="con_top"><span class="ctop_left"></span><span class="ctop_right"></span></div>
			<div class="con">
				<div class="item_title"><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/new.gif" width="75" height="35" alt="热门专区" /></div>
				<div class="more" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_search.php'"></div>
				<ul id="tagsfo">
					<li class="selectTag"><a onclick="selectTagfo('tagContentfo0',this)" href="javascript:void(0)">新品上市</a> </li>
					<li><a onclick="selectTagfo('tagContentfo1',this)" href="javascript:void(0)">疯狂抢购</a> </li>
					<li><a onclick="selectTagfo('tagContentfo2',this)" href="javascript:void(0)">热销商品</a> </li>
				</ul>
				<div id="tagContentfo">
				新品上市
					<div class="tagContent selectTag" id="tagContentfo0">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['new_product_x']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['new_product_x'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>
						</ul>
					</div>
					疯狂抢购
					<div class="tagContent" id="tagContentfo1">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['click_product_x']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['click_product_x'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>
						</ul>					
					</div>
					热销商品
					<div class="tagContent" id="tagContentfo2">
						<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['hot_product_x']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<li><a href="http://<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['goods_id']; ?>
"><?php if ($this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['goods_small_image'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['goods_small_image']; ?>
" width="110" height="110"/><?php else: ?><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/img/default_product.gif" width="110" height="110"/><?php endif; ?></a><br/>
								<a href="http://<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['domainname'];  echo $this->_tpl_vars['domainname']; ?>
/product.php?id=<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['goods_id']; ?>
"><span><?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['goods_name']; ?>
</span></a><br/>
								<b class="fC">￥<?php echo $this->_tpl_vars['hot_product_x'][$this->_sections['list']['index']]['goods_pricedesc']; ?>
</b></li>
						<?php endfor; endif; ?>	
						</ul>					
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
		</div>
		-->
		<!-- end 中下展示右 新品速递 -->
		<div class="clear"></div>
		<!-- 文章部分 -->
		<div class="botcon_left">
			<div class="lcon_top"><span class="lctop_left"></span><span class="lctop_right"></span></div>
			<div class="con">
				<!-- 左 -->
				<div class="botconl_list">
					<div class="more2" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_list&id=2'"></div>
					<h2><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/electron.gif" width="127" height="17" /></h2>
					<div class="clear"></div>
					<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['article_array_zx']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<li><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['article_array_zx'][$this->_sections['list']['index']]['aid']; ?>
"><?php echo $this->_tpl_vars['article_array_zx'][$this->_sections['list']['index']]['title']; ?>
</a></li>
						<?php endfor; endif; ?>
					</ul>
				</div>
				<!-- end 左 -->
				<!-- 中AD -->
				<div class="botconl_ad"><a href="<?php echo $this->_tpl_vars['other_ad_image']['2']['url']; ?>
" title="<?php echo $this->_tpl_vars['other_ad_image']['2']['title']; ?>
"><img src="<?php echo $this->_tpl_vars['other_ad_image']['2']['img_path']; ?>
" width="220" height="285" /></a></div>
				<!-- end 中AD -->
				<!-- 右 -->
				<div class="botconl_list">
					<div class="more2" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_list&id=3'"></div>
					<h2><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/business.gif" width="96" height="17" /></h2>
					<div class="clear"></div>
					<ul>
					<ul>
						<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['article_array_xy']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<li><a href="<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_article.php?action=article_content&id=<?php echo $this->_tpl_vars['article_array_xy'][$this->_sections['list']['index']]['aid']; ?>
"><?php echo $this->_tpl_vars['article_array_xy'][$this->_sections['list']['index']]['title']; ?>
</a></li>
						<?php endfor; endif; ?>
					</ul>
					</ul>
				</div>
				<!-- end 右 -->
				<div class="clear"></div>
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
			<!-- 底部AD -->
			<div class="botcon_left_ad"><a href="<?php echo $this->_tpl_vars['other_ad_image']['1']['url']; ?>
" title="<?php echo $this->_tpl_vars['other_ad_image']['1']['title']; ?>
"><img src="<?php echo $this->_tpl_vars['other_ad_image']['1']['img_path']; ?>
" width="690" height="80" /></a></div>
			<!-- end 底部AD -->
		</div>
		<!-- end 文章部分 -->
		<!-- 品牌 -->
		<div class="botcon_right">
			<!-- AD 250X55 -->
			<div class="botcon_right_ad"><a href="<?php echo $this->_tpl_vars['other_ad_image']['3']['url']; ?>
" title="<?php echo $this->_tpl_vars['other_ad_image']['3']['title']; ?>
"><img src="<?php echo $this->_tpl_vars['other_ad_image']['3']['img_path']; ?>
" width="250" height="55" /></a></div>
			<!-- end AD -->
			<!-- AD 250X55 -->
			<div class="botcon_right_ad"<a href="<?php echo $this->_tpl_vars['other_ad_image']['4']['url']; ?>
" title="<?php echo $this->_tpl_vars['other_ad_image']['4']['title']; ?>
"><img src="<?php echo $this->_tpl_vars['other_ad_image']['4']['img_path']; ?>
" width="250" height="59" /></a></div>
			<!-- end AD -->
			<div class="con_top"><span class="ctop_left"></span><span class="ctop_right"></span></div>
			<div class="con">
				<!-- 友情链接 -->
				<div class="more2" onclick="window.location.href='<?php echo $this->_tpl_vars['Site_Url']; ?>
/shop_link.php'"></div>
				<h2><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/breed.gif" width="73" height="17" /></h2>
				<div class="clear"></div>
				<ul>
		<?php unset($this->_sections['list']);
$this->_sections['list']['name'] = 'list';
$this->_sections['list']['loop'] = is_array($_loop=$this->_tpl_vars['link_image']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
          <li>
<a href="<?php echo $this->_tpl_vars['link_image'][$this->_sections['list']['index']]['url']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['link_image'][$this->_sections['list']['index']]['webname']; ?>
" ><img src="<?php echo $this->_tpl_vars['link_image'][$this->_sections['list']['index']]['logo']; ?>
" width=88 height=30 /></a>
		  </li>
		<?php endfor; endif; ?>

				</ul>
				<!-- end 友情链接 -->
			</div>
			<div class="con_bot"><span class="cbot_left"></span><span class="cbot_right"></span></div>
		</div>
		<!-- end 友情链接 -->
		<div class="clear"></div>
	</div>
	<!--end content-->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'shop_footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<!-- end of footer -->

</div>
</body>
</html>