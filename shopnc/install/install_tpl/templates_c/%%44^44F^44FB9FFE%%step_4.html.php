<?php /* Smarty version 2.6.9, created on 2009-09-15 11:47:54
         compiled from step_4.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单用户ShopNC V6.0版安装程序--安装完成</title>
<link href="install_tpl/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.onetd {
	text-align:right;
	line-height:25px;
}
-->
</style>
</head>
<body>
<div id="head">
  <div class="top boxcenter">
    <div id="logo">&nbsp;</div>
    <ul class="stepbox">
      <li>许可协议</li>
      <li>环境检测</li>
      <li>参数设置</li>
      <li class="current">程序安装</li>
    </ul>
  </div>
</div>
<div class="main boxcenter">
  <h2 class="boxtitle">安装完成</h2>
  <div class="setupinfo">
    <?php if ($this->_tpl_vars['install_finish'] == '1'): ?>
    已经完成对ShopNC6.0网店系统的安装！<br />
    <a href="<?php echo $this->_tpl_vars['web_url']; ?>
" target="_blank"><img src="install_tpl/images/but_index.gif" border="0" /></a> <a href="<?php echo $this->_tpl_vars['web_url']; ?>
/admin/login.php" target="_blank"><img src="install_tpl/images/but_system.gif" width="90" height="30" border="0" /></a>
    <?php endif; ?>
  </div>
</div>
<div class="copyright"><a href="http://www.shopnc.net" target="_blank" style="text-decoration:none; color:#FFFFFF">ShopNC&#8482;天津网城科技有限公司</a> <br />
  <span>Copyright &copy; 2007-2009 ShopNC, Powered by <a href="http://www.shopnc.net" target="_blank" style="text-decoration:none; color:#FFFFFF">ShopNC</a> Team , All Rights Reserved</span></div>
</body>
</html>