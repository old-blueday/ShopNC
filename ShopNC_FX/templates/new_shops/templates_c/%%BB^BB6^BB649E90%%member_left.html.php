<?php /* Smarty version 2.6.9, created on 2009-08-01 20:34:11
         compiled from member_left.html */ ?>
		<div class="w_conright uc_conleft">
			<div class="w_cl_title">
				<div class="w_cl_tright"></div>
				<div class="w_tithead">
				<strong><?php echo $this->_tpl_vars['home_user']; ?>
</strong>
				</div>
			</div>
			<div class="con">
				<div class="w_crcon">
					<div class="div_h10px"></div>
					<div  class="uc_leftcon">
						<ul>
							<li><a <?php if ($_GET['action'] == 'index'): ?>class="uc_act"<?php endif; ?> href="?action=index"><?php echo $this->_tpl_vars['home_index']; ?>
</a></li>
							<li><a <?php if ($_GET['action'] == 'member_info'): ?>class="uc_act"<?php endif; ?> href="?action=member_info"><?php echo $this->_tpl_vars['home_user']; ?>
</a></li>
							<li><a <?php if ($_GET['action'] == 'member_passwd'): ?>class="uc_act"<?php endif; ?> href="?action=member_passwd"><?php echo $this->_tpl_vars['home_pass']; ?>
</a></li>
							<li><a <?php if ($_GET['action'] == 'shop_info'): ?>class="uc_act"<?php endif; ?> href="?action=shop_info"><?php echo $this->_tpl_vars['home_shops']; ?>
</a></li>
							<li><a target="_blank" href="http://<?php echo $_SESSION['shop_domain'];  echo $this->_tpl_vars['domainname']; ?>
"><?php echo $this->_tpl_vars['home_myshop']; ?>
</a></li>
							<li><a target="_blank" href="http://<?php echo $_SESSION['shop_domain'];  echo $this->_tpl_vars['domainname']; ?>
/admin"><?php echo $this->_tpl_vars['home_shopadmin']; ?>
</a></li>
							<li><a href="shop_user.php?action=out"><?php echo $this->_tpl_vars['home_out']; ?>
</a></li>
						  <!--<li><a href="?action=member_defrayal"><?php echo $this->_tpl_vars['home_defrayal']; ?>
</a></li>
						  <li><a href="?action=member_defrayal_list"><?php echo $this->_tpl_vars['defrayal_list']; ?>
</a></li>
						  <li><a href="?action=member_sentmes"><?php echo $this->_tpl_vars['home_pmes']; ?>
</a></li>
						  <li><a href="?action=member_inmes"><?php echo $this->_tpl_vars['home_imes']; ?>
</a></li>-->	  							
						</ul>					
						<div class="uc_lico"></div>
						<div class="clear"></div>
					</div>
					<div class="div_h10px"></div>
				</div>
			</div>
			<div class="w_cl_foot">
				<div class="w_cl_fright"></div>
			</div>
</div>						