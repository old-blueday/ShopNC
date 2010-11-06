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
	$(".buttom-comm").hover( function(){$(this).removeClass("buttom-comm").addClass("buttom-comm-se")},function(){$(this).removeClass("buttom-comm-se").addClass("buttom-comm")});
	$(".buttom-comm-1").hover( function(){$(this).removeClass("buttom-comm-1").addClass("buttom-comm-1-se")},function(){$(this).removeClass("buttom-comm-1-se").addClass("buttom-comm-1")})
});
//change language
function changeLang(langTypeValue){
	$.cookie("<?php echo $output['cookie_pre']; ?>commonlangType", langTypeValue);
	window.location.reload();
}
</script>
</head>
<body>
<div style="width:770px; margin:0 auto; clear:both; text-align:left;">
<?php
	/**
	 * 主体内容
	 */
	include($tpl_file);
?>
</div>
</body>
</html>