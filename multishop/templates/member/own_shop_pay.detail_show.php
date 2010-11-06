<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langShopPayDetailInfo'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="own_shop_pay.php?action=pay"><?php echo $lang['langShopPayDetailManage'];?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langShopPayDetailList'];?></p></span></li>

					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td"  border="0" cellpadding="0" >
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailPayType'];?>:</td>
							<td class="cr-2">
								<?php if($output['detail_array']['pay_type'] == '1'){ ?>
									<?php echo $lang['langShopPayDetailPayOnline'];?>
								<?php } ?>
								<?php if($output['detail_array']['pay_type'] == '2'){ ?>
									<?php echo $lang['langShopPayDetailPayOffline'];?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailPayName'];?>:</td>
							<td class="cr-2">
								<?php if($output['detail_array']['pay_type'] == '1'){ ?>
									<?php if($output['detail_array']['pay_name'] == 'alipay'){ ?>
										<?php echo $lang['langShopPayDetailPayAlipay'];?>
									<?php } ?>
									<?php if($output['detail_array']['pay_name'] == 'tenpay'){ ?>
										<?php echo $lang['langShopPayDetailPayTenpay'];?>
									<?php } ?>
									<?php if($output['detail_array']['pay_name'] == '99bill'){ ?>
										<?php echo $lang['langShopPayDetailPayKqpay'];?>
									<?php } ?>
								<?php } ?>
								<?php if($output['detail_array']['pay_type'] == '2'){ ?>
									<?php echo $output['detail_array']['pay_name'];?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailPayState'];?>:</td>
							<td class="cr-2">
								<?php if($output['detail_array']['pay_sign'] == '0'){ ?>
									<?php echo $lang['langShopPayDetailPayStateZero'];?>
								<?php } ?>
								<?php if($output['detail_array']['pay_sign'] == '1'){ ?>
									<?php echo $lang['langShopPayDetailPayStateOne'];?>
								<?php } ?>
								<?php if($output['detail_array']['pay_sign'] == '2'){ ?>
									<?php echo $lang['langShopPayDetailPayStateTwo'];?>
								<?php } ?>
								<?php if($output['detail_array']['pay_sign'] == '3'){ ?>
									<?php echo $lang['langShopPayDetailPayStateThree'];?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailPayDate'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['date_line'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailOfflineSenderNumber'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['sender_number'];?></td>
						</tr>
						<?php
						/**
						 * 页面输出
						 */
						if($output['detail_array']['pay_type'] == '2'){
						?>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailPayAccount'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_account'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailPayConsignee'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_consignee'];?></td>
						</tr>
						<?php } ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailModeName'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_mode_name'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailType'];?>:</td>
							<td class="cr-2">
								<?php if($output['detail_array']['pay_mode_type'] == '0'){ ?>
									<?php echo $lang['langShopPayTypeOnTime'];?>
								<?php } ?>
								<?php if($output['detail_array']['pay_mode_type'] == '1'){ ?>
									<?php echo $lang['langShopPayTypeOnNumber'];?>
								<?php } ?>
								<?php if($output['detail_array']['pay_mode_type'] == '2'){ ?>
									<?php echo $lang['langShopPayTypeAll'];?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayDetailModeMoney'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_mode_money'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayModeShopUseTime'];?><?php echo $lang['langShopPayAdd'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_mode_shop_show_time']?$output['detail_array']['pay_mode_shop_show_time']:'0';?><?php echo $lang['langShopPayModeShopUseTimeUnit'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayModeProductNumber'];?><?php echo $lang['langShopPayAdd'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_mode_product_number']?$output['detail_array']['pay_mode_product_number']:'0';?><?php echo $lang['langShopPayModeProductNumberUnit'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayModeRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['pay_mode_remark']?$output['detail_array']['pay_mode_remark']:$lang['langCNot'];?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopPayModeSystemRemark'];?>:</td>
							<td class="cr-2"><?php echo $output['detail_array']['system_remark']?$output['detail_array']['system_remark']:$lang['langCNot'];?></td>
						</tr>
					</table>
					<div class="an-1">
						
							<?php if($output['detail_array']['pay_sign'] == '0'){?>
                            <span class="buttom-comm">
							<input type="button" class='submit' name="" value="<?php echo $lang['langShopPayAchieve'];?>" onclick="window.location.href='own_shop_pay.php?action=online_continue_pay&pay_detail_id=<?php echo $output['detail_array']['pay_detail_id'];?>'" /> </span>
							<?php } ?>
                           
							<span class="buttom-comm"><input type="button" class='submit' name="" value="<?php echo $lang['langCReturn'];?>" onclick="history.back();" /></span>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>