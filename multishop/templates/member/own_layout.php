<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo NCharset; ?>" />
<title><?php echo $output['HtmlTitle']; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="<?php echo TPL_DIR;?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL_DIR;?>/css/menu.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL_DIR;?>/css/conter.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL_DIR;?>/css/reset-fonts-grids.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_URL; ?>/templates/orange/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<script src="<?php echo JS_DIR;?>/jquery1.4/jquery.js"></script>
<script src="<?php echo JS_DIR;?>/jquery1.4/jquery.form.js"></script>
<script src="<?php echo JS_DIR;?>/jquery1.4/jquery.validate.js"></script>
<script src="<?php echo JS_DIR;?>/jquery1.4/jquery.cookie.js"></script>
<script type="text/javascript">
//html style hover
$(document).ready(function(){
	$(".tabmenu").mouseover(function(){$(this).addClass("over");}).mouseout(function(){$(this).removeClass("over");})
	$(".tabmenu").hover(function(){$(this).next().css("display","block");},function(){$(this).next().css("display","none");});
	$(".downmenu").hover(function(){$(this).css("display","block");},function(){$(this).css("display","none");})
	$(".nav-bg-1").hover(function(){$(this).addClass("bianse");},function(){$(this).removeClass("bianse");})
	// Text Field Style
	$('input[type=text],textarea,input[type=password]').click(function(){
		$(this).addClass('fct-input-1').blur(function (){ $(this).removeClass('fct-input-1')} );
	});
	$('input[type=radio],input[type=checkbox]').addClass("radio");
	$(".buttom-comm").hover( function(){$(this).removeClass("buttom-comm").addClass("buttom-comm-se")},function(){$(this).removeClass("buttom-comm-se").addClass("buttom-comm")});
	$(".buttom-comm-1").hover( function(){$(this).removeClass("buttom-comm-1").addClass("buttom-comm-1-se")},function(){$(this).removeClass("buttom-comm-1-se").addClass("buttom-comm-1")});
	$(".span-button").hover( function(){$(this).removeClass("span-button").addClass("span-button-se")},function(){$(this).removeClass("span-button-se").addClass("span-button")})
});
//change language
function changeLang(langTypeValue){
	$.cookie("<?php echo $output['cookie_pre'];?>commonlangType", langTypeValue);
	window.location.reload();
}
</script>
</head>
<body>
<div id="doc2" class="yui-t1">
	<div id="hd">
		<div class="header">
    		<h1 class="logo"><a href="<?php echo SITE_URL;?>"><img src="<?php echo TPL_DIR;?>/images/logo.gif" /></a></h1>
    		<div class="topbar">
				<ul id="downmenu" class="tabs" >
        			<li style="padding-left:0px;" class="noline"><a href="<?php echo SITE_URL; ?>/home/category.php"><?php echo $lang['langWillBuy']; ?></a></li>
        			<li><a href="<?php echo SITE_URL; ?>/member/own_product.php?action=sell"><?php echo $lang['langWillSell']; ?></a></li>
        			<li class="gk">
          				<p class="tabmenu">
							<span class="myshop"><a href="JavaScript:void(0);"><?php echo $lang['langMyStore']; ?></a></span>
							<span class="arrow_down">&nbsp;</span>
						</p>
          				<ul class="downmenu">
            				<?php if ($output['shop_sign'] == '1' ){ ?>
            					<?php if ($output['shop_sign'] == '1' ){ ?>
		            				<li><a href="<?php echo SITE_URL; ?>/member/own_shop.php?action=view"><?php echo $lang['langSeeStore']; ?></a></li>
		            				<li><a href="<?php echo SITE_URL; ?>/member/own_shop.php?action=modi"><?php echo $lang['langManageStore']; ?></a></li>
            					<?php } ?>
            				<?php }else { ?>
            						<li><a href="<?php echo SITE_URL; ?>/member/own_shop.php?action=new"><?php echo $lang['langHeadFreeOpenShop']; ?></a></li>
            				<?php } ?>
          				</ul>
					</li>
        			<li><a href="<?php echo SITE_URL; ?>/home/shop.php?action=list"><?php echo $lang['langSailAboutStore']; ?></a></li>
        			<li><span class="help"><a href="../help/" target="_blank"><?php echo $lang['langClientHelp']; ?></a></span></li>
					<li><a href="../home/member.php?action=logout&refer_url=<?php echo $output['cur_url']; ?>"><?php echo $lang['langCMenuLogout'];?></a></li>
				</ul>
			</div>
    		<div class="clear-1"></div>
    		<div class="navpart">
      			<div class="sideleft"></div>
      			<div class="middle">
        			<ul class="menu">
        				<?php
        					/**
        					 * 头部菜单
        					 */
        					if (is_array($menu)){
        						foreach ($menu as $v){
		        					echo "<li ";
		        					if ($v['selected'] == 'current'){
		        						echo "class='current'";
		        					}
		        					echo ">";
		        					echo "<a href=".$v['url'].">".$v['name']."</a></li>";
		        				}
        					}
        				?>
<?php if (DISCUZ_X === true) { ?><li><a target="_blank" href="../../home.php"><?php echo $lang['langHomeUlr']; ?></a></li><?php } ?>
        			</ul>
        			<div class="search">
          				<form action="../home/product.php" method="get">
            				<input type="text" name="keyword" class="textinput" value="" />
            				<input type="submit" value="" title="<?php echo $lang['langCSearch']; ?>" class="btn"/>
          				</form>
          				<span><a href="<?php echo SITE_URL; ?>/home/product.php?action=search"><?php echo $lang['langCAllSearch']; ?></a></span>
					</div>
      				</div>
      				<div class="sideright"></div>
    			</div>
  		</div>
		<div class="clear-3"></div>
	</div>
	<div id="bd">
		<div class="yui-b">
			<div class="yui-g">
				<div id="my_menu" class="sdmenu">
					<?php
						/**
						 * 侧边菜单
						 */
						if (is_array($menu)){
							foreach ($menu as $v){
								if ($v['selected'] == 'current'){
									if (is_array($v['body'])){
										foreach ($v['body'] as $v2){
			        						echo "<ul>";
			        						echo "<span>".$v2['name']."</span>";
			        						if (is_array($v2['body'])){
			        							foreach ($v2['body'] as $v3){
			        								echo "<li>";
			        								echo "<a href='".$v3['url']."'";
			        								if ($v3['selected'] == 'current'){
			        									echo "class='current'";
			        								}
			        								/**
			        								 * 弹出窗口
			        								 */
			        								if ($v3['target'] == '1'){
			        									echo "target='_blank'";
			        								}
			        								echo '>';
			        								echo $v3['name'];
			        								echo "</a>";
			        								echo "</li>";
			        							}
			        						}
											echo "</ul>";
			        					}
									}
								}
							}
						}
        			?>
				</div>
			</div>
		</div>
		<?php
			/**
			 * 主体内容
			 */
			include($tpl_file);
		?>
	</div>
	<div id="ft">
	<?php
		/**
		 * 页脚
		 */
		include("../html/footer.html");
	?>
	</div>
	<div id="time-xl">
	Processed in <?php echo $debug_query_time; ?> second(s), <?php echo $debug_querynum; ?> queries.
	</div>
</div>
</body>
</html>