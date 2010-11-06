<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langMSetPay'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langMSetPay'];?></p></span></li>
					</ul>
				</div>

                <?php if(!empty($output['payment_array'])): ?>
				<div class="clear"></div>
				<div class="pay-zi"><?php echo $lang['langMPaymentInfo'];?></div>
                <?php endif; ?>

				<form action="own_payment.php?action=save" method="post" name="form_payment" id="form_payment">
				<div class="bg-book">
					<table class="pay-table" border="0" cellpadding="0">
						<?php if($output['sign']){ ?>
						<?php if(!empty($output['payment_array']) && is_array($output['payment_array'])){ ?>
						<?php foreach($output['payment_array'] as $k => $v){
							/**
							 * 判断前面图标样式
							 */
							switch($k){
								case 'alipay':
									$class = 'pay-td p-1';
									break;
								case 'tenpay':
									$class = 'pay-td p-2';
									break;
								case 'paypal':
									$class = 'pay-td p-3';
									break;
									default:
										$class = 'pay-td p-0';
							}
						?>
						<tr>
							
							
							<?php if ($k == 'alipay' && $output['payment_mode'] == 'seller') {?>
                            <td class="<?php echo $class;?>" style="background-position:45px -265px;"><?php echo $v['name'];?>:</td><td>
								<p style="clear:both; margin:8px 5px;"><?php echo $lang['langAlipayPartner']; ?>:&nbsp;<input class="in-1" name="<?php echo $k;?>_partner" type="text" value="<?php echo $output['member_array']['alipay_partner'];?>" style="width:200px; padding:2px; height:16px;" /></p>
								<p style="clear:both; margin:8px 5px;"><?php echo $lang['langAlipayKey']; ?>:&nbsp;<input class="in-1" name="<?php echo $k;?>_key" type="text" value="<?php echo $output['member_array']['alipay_key'];?>" style="width:200px; padding:2px; height:16px;" /></p>
								<p style="clear:both; margin:8px 5px;"><?php echo $lang['langAlipayEmail']; ?>:&nbsp;<input class="in-1" name="<?php echo $k;?>" type="text" value="<?php echo $output['member_array'][$k];?>" style="width:200px; padding:2px; height:16px;" /></p>
								<p style="clear:both; margin:10px 5px;"><?php echo $lang['langAlipayExplain1']; ?> <a href="https://www.alipay.com/himalayas/practicality_customer.htm?customer_external_id=C4335302344586475118&market_type=from_agent_contract&pro_codes=9951DA19E303A141" target="_blank" style="color:#f60;text-decoration:underline;"><?php echo $lang['langAlipayExplain2']; ?></a></p>
                             </td>
							<?php } else { ?>
                            <td class="<?php echo $class;?>"><?php echo $v['name'];?>:</td><td>
								<input class="in-1" name="<?php echo $k;?>" type="text" value="<?php echo $output['member_array'][$k];?>" />
							<?php } ?>
							</td>
						</tr>
						<?php }?>
						<?php }?>
						<?php }else{ ?>
						<tr class="tr-not">
							<td colspan="2"><?php echo $lang['langMNoPaymentInfo'];?></td>
						</tr>
						<?php }?>
					</table>
				</div>
                <?php if(!empty($output['payment_array'])): ?>
				<div class="an-1">
					<span class="buttom-comm"><input name="" value="<?php echo $lang['langCsave'];?>" type="submit" /></span>
				</div>
                <?php endif; ?>
				</form>
			</div>
		</div>
	</div>
</div>