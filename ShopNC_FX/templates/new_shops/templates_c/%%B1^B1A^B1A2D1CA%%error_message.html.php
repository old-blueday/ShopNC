<?php /* Smarty version 2.6.9, created on 2009-08-01 19:57:10
         compiled from error_message.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['nc_charset']; ?>
" />
<title><?php echo $this->_tpl_vars['msg_title']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body style="margin-top:40px">
<div id="container">
<?php 
include(BasePath.'/shop_header.php');
 ?>
<!-- 头部信息header -->
	<!--content-->
	<div id="content">
		<div class="w_conleft longer">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
			</div>
			<div class="con">
				<div class="div_h10px"></div>
					<!-- 搜索店铺 -->
					
					<table align="center" width="0" border="0" cellspacing="0" cellpadding="0">	
						<tr>
							<td><img src="<?php echo $this->_tpl_vars['templates_subpath']; ?>
/images/error.gif" width="114" height="98" />
							</td>
							<td style="line-height:30px">
								<?php echo $this->_tpl_vars['html_body']; ?>

							</td>
						</tr>
					</table>
				
					<!-- end 搜索店铺 -->
				<div class="clear"></div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!--end content-->
<?php 
include(BasePath.'/shop_footer.php');
 ?>
</div>
</body>
</html>