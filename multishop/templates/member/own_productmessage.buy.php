<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langProductSellMManage'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langProductSellMManage'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td style="width:15%;">
								<?php echo $lang['langProductMSellName'];?>
							</td>
							<td style="width:15%;">
								<?php echo $lang['langProductMTime'];?>
							</td>
							<td style="width:25%;">
								<?php echo $lang['langProductMContent'];?>
							</td>
							<td style="width:25%;">
								<?php echo $lang['langProductAnswerMsgContent']; ?>
							</td>
							<td style="width:15%;">
								<?php echo $lang['langProductMEstate']; ?>
							</td>							
							<td></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="5"></td>
						</tr>
						<?php if(!empty($output['message_array']) && is_array($output['message_array'])){ ?>
						<?php foreach($output['message_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-3">
							<td class="td-bg-6" style="width:15%; text-align:left; padding-left:10px;">
								<?php echo $v['seller_name'];?>
							</td>
							<td class="td-bg-9" style="width:15%;">
								<?php echo $v['message_time'];?>
							</td>
							<td class="td-bg-7" style="padding-left:10px;width:30%; text-align:left;">
								<?php echo $v['message_content'];?>
							</td>
							<td class="td-bg-6" style="padding-left:10px;width:25%; text-align:left;">
								<?php echo $v['message_recontent'];?>
							</td>
							<td class="td-bg-2" style="width:15%; text-align:left;padding-left:10px; ">
								<?php if($v['message_recontent']  != ''){ ?>
										<?php echo $lang['langProductMShopkeeperAlreadyRestore']; ?>
									<?php }else{ ?>
										<?php echo $lang['langProductMNotRestore']; ?>
									<?php } ?>
									 <a href="<?php echo $v['p_href'];?>#guestbook" target="_blank"><?php echo $lang['langCview']; ?></a>
							</td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="5">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php if($output['message_array'][0]['product_code'] != ''){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['message_pagelist']; ?>
						</div>	
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>