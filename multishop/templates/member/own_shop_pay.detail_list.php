<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langShopPayDetailList'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="own_shop_pay.php?action=pay"><?php echo $lang['langShopPayDetailManage'];?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langShopPayDetailList'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-10"><?php echo $lang['langShopPayDetailModeName'];?></td>
							<td class="td-bg-4"><?php echo $lang['langShopPayDetailModeMoney'];?></td>
							<td class="td-bg-4"><?php echo $lang['langShopPayDetailPayType'];?></td>
							<td class="td-bg-4"><?php echo $lang['langShopPayDetailPayName'];?></td>
							<td class="td-bg-4"><?php echo $lang['langShopPayDetailPayDate'];?></td>
							<td class="td-bg-4"><?php echo $lang['langShopPayDetailPayState'];?></td>
							<td class="td-bg-7"><?php echo $lang['langCOperation'];?></td>
						</tr>
						<?php if(!empty($output['detail_array']) && is_array($output['detail_array'])){ ?>
						<?php foreach($output['detail_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-2">
							<td><?php echo $v['pay_mode_name'];?></td>
								<td><?php echo $v['pay_mode_money'];?></td>
								<td>
									<?php if($v['pay_type'] == '1'){?>
										<?php echo $lang['langShopPayDetailPayOnline'];?>
									<?php } ?>
									<?php if($v['pay_type'] == '2'){?>
									<?php echo $lang['langShopPayDetailPayOffline'];?>
									<?php } ?>
								</td>
								<td>
									<?php if($v['pay_type'] == '1'){ ?>
										<?php if($v['pay_type'] == 'alipay'){ ?>
											<?php echo $lang['langShopPayDetailPayAlipay'];?>
										<?php } ?>
										<?php if($v['pay_type'] == 'tenpay'){ ?>
											<?php echo $lang['langShopPayDetailPayTenpay'];?>
										<?php } ?>
										<?php if($v['pay_type'] == '99bill'){ ?>
											<?php echo $lang['langShopPayDetailPayKqpay'];?>
										<?php } ?>
									<?php } ?>
									<?php if($v['pay_type'] == '2'){ ?>
										<?php echo $v['pay_name'];?>
									<?php } ?>
								</td>
								<td><?php echo $v['date_line'];?></td>
								<td>
									<?php if($v['pay_sign'] == '0'){ ?>
										<?php echo $lang['langShopPayDetailPayStateZero'];?>
									<?php } ?>
									<?php if($v['pay_sign'] == '1'){ ?>
										<?php echo $lang['langShopPayDetailPayStateOne'];?>
									<?php } ?>
									<?php if($v['pay_sign'] == '2'){ ?>
										<?php echo $lang['langShopPayDetailPayStateTwo'];?>
									<?php } ?>
									<?php if($v['pay_sign'] == '3'){ ?>
										<?php echo $lang['langShopPayDetailPayStateThree'];?>
									<?php } ?>
								</td>
								<td>
									<a href="own_shop_pay.php?action=detail_show&pay_detail_id=<?php echo $v['pay_detail_id']; ?>"><?php echo $lang['langCview'];?></a>
									<?php if($v['pay_sign'] == '0'){ ?>
										<a href="own_shop_pay.php?action=online_continue_pay&pay_detail_id=<?php echo $v['pay_detail_id']; ?>"><?php echo $lang['langShopPayDetailPay'];?></a>
									<?php } ?>
								</td>
						</tr>
						<?php } ?>
						<?php } ?>
					</table>
				</div>
				<?php if(!empty($output['detail_array']) && is_array($output['detail_array'])){ ?>
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