<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langProductBuyMManage'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langProductBuyMManage'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td  style="width:15%;">
								<?php echo $lang['langProductMSellName'];?>
							</td>
							<td style="width:15%">
								<?php echo $lang['langProductMTime'];?>
							</td>
							<td style="width:25%;">
								<?php echo $lang['langProductMContent']; ?>
							</td>
							<td style="width:25%;">
								<?php echo $lang['langProductAnswerMsgContent']; ?>
							</td>
							<td style="width:15%;">
								<?php echo $lang['langCOperation']; ?>
							</td>
						</tr>
						<?php if(!empty($output['message_array']) && is_array($output['message_array'])){ ?>
						<?php foreach($output['message_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-3">
							<td class="td-bg-6" style="width:15%;">
								<?php echo $v['seller_name'];?>
							</td>
							<td class="td-bg-9" style="width:15%;">
								<?php echo $v['message_time'];?>
							</td>
							<td class="td-bg-7" style="width:25%; text-align:left;padding-left:10px;">
								<?php echo $v['message_content'];?>
							</td>
							<td class="td-bg-6" style="width:25%; text-align:left;padding-left:10px;">
								<?php 
									if ( $v['message_recontent'] != '' ) { 
										echo $v['message_recontent'];
									} else {
										echo $lang['langCNot'];
									}
								?>								
							</td>
							<td class="td-bg-5" style="width:15%; text-align:left; padding-left:20px;">
								<a href="<?php echo $v['p_href'];?>#guestbook" target="_blank"><?php echo $lang['langCview']; ?></a>
								<?php if ( $v['message_recontent'] == '' ) { ?>
									<a href="?action=re&id=<?php echo $v['message_id'];?>"><?php echo $lang['langCRevert']; ?></a>
								<?php } ?>
								<a href="javascript:;" onclick="if (confirm('<?php echo $lang['errMessageDelCofirm']; ?>')) window.location.href='<?php echo SITE_URL;?>/home/productmessage.php?action=del&messageid=<?php echo $v['message_id'];?>&pid=<?php echo $v['product_code'];?>' "><?php echo $lang['langCdele']; ?></a>
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