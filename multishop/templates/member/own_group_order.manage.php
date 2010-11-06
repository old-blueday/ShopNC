<link href="<?php echo SITE_URL; ?>/js/jquery/ui.theme.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/jquery/ui.datepicker.js"></script>
<script type="text/javascript" language="javascript"> 
// JavaScript Document
$(function(){
	$('#start_time').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});	
	$('#end_time').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	});		
});
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p>
						<?php echo $lang['langOrderGroupListRemark']; ?>
					</p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langGroupBuyWare']; ?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 resume"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-1"><?php echo $lang['langOrderImage'];?></td>
							<td class="td-bg-4"><?php echo $lang['langOrderBabyName'];?></td>
							<td class="td-bg-2"><?php echo $lang['langOrderGroupPrice'];?></td>
							<td class="td-bg-3"><?php echo $lang['langOrderPriceEstate'];?></td>
							<td class="td-bg-6"><?php echo $lang['langOrderResidualTime'];?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="7"></td>
						</tr>
						<?php if(!empty($output['product_order_array']) && is_array($output['product_order_array'])){ ?>
						<?php foreach($output['product_order_array'] as $k => $goods){ ?>
						<tr>
							<td class="tr-img">
								<?php if ( $output['ifhtml'] == '1' &&  $goods['html_url'] !='' ) {  ?>
									<a target="_blank" href="<?php echo $goods['html_url']; ?>">
									<img src="../<?php echo $goods['p_pic'] != '' ? $goods['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $goods['p_name']; ?>" class="p_pic50" /></a>
								<?php } else { ?>
									<a href="../home/product.php?action=view&pid=<?php echo $goods['p_code']; ?>" target="_blank"><img src="../<?php echo $goods['p_pic'] != '' ? $goods['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $goods['p_name']; ?>" class="p_pic50" /></a>
								<?php } ?>							
							</td>
							<td>
								<?php if ( $output['ifhtml'] == '1' &&  $goods['html_url'] !='' ) {  ?>
									<a target="_blank" href="<?php echo $goods['html_url']; ?>"><?php echo $goods['p_name']; ?></a>
								<?php } else { ?>
									<a href="../home/product.php?action=view&pid=<?php echo $goods['p_code']; ?>"><?php echo $goods['p_name']; ?></a>
								<?php } ?>								
							</td>
							<td><?php echo $goods['unit_price']; ?></td>
							<td>
								<?php echo $lang['langOrderDifference']; ?> <?php echo $goods['less_count']; ?> <?php echo $lang['langOrderUnit']; ?>
							</td>
							<td>
								<?php if ( $output['is_end'] == '1' ) { ?>
									<?php echo $lang['langOrderAlreadyEnd']; ?>
								<?php } else { ?>
									<?php echo $goods['left_days'].$lang['langOrderDate'].$goods['left_hours'].$lang['langOrderHour'].$goods['left_minutes'].$lang['langOrderMinute']; ?>
								<?php } ?>
							</td>
						</tr>
						<tr class="tr-un-space-1">
							<td colspan="7"></td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="7">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php if($output['product_order_array'][0]['p_code'] != ''){ ?>
				<div class="page">
					<div class="pd-ck-right">
						<?php echo $output['page_list']; ?>
					</div>	
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>