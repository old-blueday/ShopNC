<?php /* Smarty version 2.6.9, created on 2009-09-15 11:47:35
         compiled from step_2.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单用户ShopNC V6.0版安装程序--检查环境</title>
<link href="install_tpl/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.twbox * td{
	text-indent:20px;
}
.onetd{
	border-right:1px solid #96D5EB;
}
.STYLE2 {color: #339900}

-->
</style>
<script src="install_tpl/jquery.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
<!--
	$(document).ready(function(){
		//列表第一格CSS
		$(".twbox tr").each(function(){ $(this).children("td").eq(0).addClass("onetd");});

		//列表行鼠标悬停
		$(".twbox tr").mouseover(function(){ $(this).addClass("moncolor");}).mouseout(function(){$(this).removeClass("moncolor");	});

	});
-->
</script>
</head>
<body>
<div id="head">
  <div class="top boxcenter">
    <div id="logo">&nbsp;</div>
    <ul class="stepbox">
      <li>许可协议</li>
      <li class="current">环境检测</li>
      <li>参数设置</li>
      <li>程序安装</li>
    </ul>
  </div>
</div>
<div class="main boxcenter">
  <h2 class="boxtitle">服务器信息</h2>
  <table width="676" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
    <tr>
      <th width="230" align="center"><strong>参数</strong></th>
      <th width="446"><strong>值</strong></th>
    </tr>
    <tr>
      <td><strong>服务器域名/IP地址</strong></td>
      <td>http://<?php echo $this->_tpl_vars['info']['server']['server_url']; ?>
</td>
    </tr>
    <tr>
      <td><strong>服务器系统</strong></td>
      <td><?php echo $this->_tpl_vars['info']['server']['os_ver']; ?>
</td>
    </tr>
    <tr>
      <td><strong>服务器web支持</strong></td>
      <td><?php echo $this->_tpl_vars['info']['server']['web_os']; ?>
</td>
    </tr>
    <tr>
      <td><strong>PHP版本</strong></td>
      <td><?php echo $this->_tpl_vars['info']['server']['php_ver']; ?>
</td>
    </tr>
    <tr>
      <td><strong>ShopNC路径</strong></td>
      <td><?php echo $this->_tpl_vars['info']['server']['nc_path']; ?>
</td>
    </tr>
  </table>
  <h2 class="boxtitle">系统环境要求</h2>
  <div style="width:676px; margin:10px auto; color:#666;"> 系统环境要求必须满足下列所有条件，否则系统或系统部份功能将无法使用！. </div>
  <table width="676" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
    <tr>
      <th width="230"><strong>ShopNC运行需要的条件</strong></th>
      <th width="40">&nbsp;</th>
      <th><strong>状态描述</strong></th>
    </tr>
    <tr>
      <td>php版本>=5.0</td>
      <td><?php if ($this->_tpl_vars['info']['php']['use_php'] == '1'): ?> <font color=green>[√]</font> <?php else: ?> <font color=red>[×]</font> <?php endif; ?> </td>
      <td>(如果当前状态为<font color=red>[×]</font>，说明php版本过低)</td>
    </tr>
    <tr>
      <td>MySQL 支持</td>
      <td><?php if ($this->_tpl_vars['info']['php']['use_mysql'] == '1'): ?> <font color=green>[√]</font> <?php else: ?> <font color=red>[×]</font> <?php endif; ?> </td>
      <td><?php echo '<?php'; ?>
 echo $sp_allow_url_fopen; <?php echo '?>'; ?>
(如果当前状态为<font color=red>[×]</font>，说明mysql环境运行不正常)</td>
    </tr>
    <tr>
      <td>GD 支持</td>
      <td><?php if ($this->_tpl_vars['info']['php']['use_gd2'] == '1'): ?> <font color=green>[√]</font> <?php else: ?> <font color=red>[×]</font> <?php endif; ?> </td>
      <td><?php echo '<?php'; ?>
 echo $sp_safe_mode; <?php echo '?>'; ?>
(如果当前状态为<font color=red>[×]</font>，会对图片处理操作造成影响)</td>
    </tr>
  </table>
  <h2 class="boxtitle">目录权限检测</h2>
  <div style="width:676px; margin:10px auto; color:#666;"> 系统要求必须满足下列所有的目录权限全部可读写的需求才能使用，其它应用目录安装后自行在管理后台检测。</div>

 
  <table width="676" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
    <tr>
      <th width="222" align="center"><strong>目录名</strong></th>
      <th width="62">&nbsp;</th>
      <th width="392"><strong>状态描述</strong></th>
    </tr>
    <?php $_from = $this->_tpl_vars['info']['dir']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
      <td><?php echo $this->_tpl_vars['key']; ?>
</td>
      <td><?php if ($this->_tpl_vars['item'] == '1'): ?> <font color=green>[√]</font> <?php else: ?> <font color=red>[×]</font> <?php endif; ?> </td>
      <td>如果当前目录状态为<font color=red>[×]</font>，请设置该目录的读写权限</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
  <div class="butbox boxcenter">
  <input type="button" class="backbut" value="" onclick="history.back();" style="margin-right:20px" />
  <?php if ($this->_tpl_vars['info']['step3_state'] == '1'): ?><input type="button" class="nextbut" value="" onclick="window.location.href='index.php?action=step_3';" /><?php endif; ?>
</div>
</div>
<div class="copyright"><a href="http://www.shopnc.net" target="_blank" style="text-decoration:none; color:#FFFFFF">ShopNC&#8482;天津网城科技有限公司</a> <br />
  <span>Copyright &copy; 2007-2009 ShopNC, Powered by <a href="http://www.shopnc.net" target="_blank" style="text-decoration:none; color:#FFFFFF">ShopNC</a> Team , All Rights Reserved</span></div>
</body>
</html>