<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langShopMManageExplain']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopMManage']; ?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_shopmessage.php?action=add"><?php echo $lang['langShopMAppearManage']; ?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">		
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-6" style="width:30%;"><?php echo $lang['langShopMSpokesmanAndTime'];?></td>
							<td class="td-bg-1" style="width:50%;"><?php echo $lang['langShopMContent'];?></td>
							<td class="td-bg-7" style="width:20%;"><?php echo $lang['langCOperation'];?></td>
						</tr>
						<?php if( !empty($output['shop_message_array']) && is_array($output['shop_message_array']) ) { ?>	
							<?php foreach($output['shop_message_array'] as $list ){ ?>
								<tr class="tr-un-conter-1">
									<td><?php echo $list['member_name']; ?><br/><?php echo $list['message_time']; ?></td>
									<td style=" text-align:left;">
										<?php echo $list['message_content']; ?>
										<?php if ( $list['message_recontent'] != '' ) { ?>
											<br/>
											<span style="color:#FF9900; font-weight:700;">
												<?php echo $lang['langShopMShopkeeperRestore']; ?>:
											</span>
											<span style="color:#0000FF">
												<?php echo $list['message_recontent']; ?>
											</span>
										<?php } ?>
									</td>
									<td>
										<?php if ( $list['message_recontent'] == '' && $_SESSION['s_login']['name'] != $list['member_name'] ) { ?>
											<a href="own_shopmessage.php?action=re&messageid=<?php echo $list['message_id']; ?>"><?php echo $lang['langShopMRestore'];?></a>										
										<?php } ?>		  
			  							<a href="own_shopmessage.php?action=del&messageid=<?php echo $list['message_id']; ?>"><?php echo $lang['langCdele'];?></a>									
									</td>
								</tr>
							<?php } ?>		
						<?php } else { ?>
							<tr class="tr-not">
								<td colspan="3">
									<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
								</td>
							</tr>						
						<?php } ?>		
					</table>
				</div>
				<?php if( !empty($output['shop_message_array']) && is_array($output['shop_message_array']) ){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['shop_message_pagelist']; ?>
						</div>	
					</div>	
				<?php } ?>			
			</div>
		</div>
	</div>
</div>