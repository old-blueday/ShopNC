<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langOViewExplain']; ?></p>
				</div>
				<div class="clear-9"></div>			
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langOrderInfo'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
					  <tr>
					    <td colspan="6" class="cr-1"><strong><?php echo $lang['langOContent'];?></strong></td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langProName'];?>:</td>
					    <td colspan="5" class="cr-2">
					    	<?php echo $output['order_array']['p_name']; ?>
					    	[
					    	<!-- 过渡使用，如果没有快照，则查看相当商品详情 -->
					    	<?php if ( $output['order_array']['sp_html'] != '' ) { ?>
								<a href="<?php echo SITE_URL; ?>/home/order.php?action=sp_html&sp_code=<?php echo $output['order_array']['sp_code']; ?>" target="_blank"><?php echo $lang['langOViewProductInfo'];?></a>					    	
					    	<?php } else { ?>
					    		<?php if ( $output['ifhtml'] == '1' && $output['html_url'] != '' ) { ?>
									<a target="_blank" href="<?php echo $output['html_url']; ?>" title='<?php echo $lang['langOViewProductInfo'];?>'><?php echo $lang['langOViewProductInfo'];?></a>					    		
					    		<?php } else { ?>
									<a target="_blank" href="<?php echo $output['order_array']['product_href']; ?>" title='<?php echo $lang['langOViewProductInfo'];?>'><?php echo $lang['langOViewProductInfo'];?></a>					    		
					    		<?php } ?>
					    	<?php } ?>
					    	]
					    </td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOrderCode'];?>:</td>
					    <td colspan="5" class="cr-2"><?php echo $output['order_array']['sp_code']; ?></td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOrderPrice'];?>:</td>
					    <td class="cr-3"><?php echo $output['order_array']['unit_price']; ?></td>
					    <td class="cr-1"><?php echo $lang['langOBuyNumber'];?>:</td>
					    <td class="cr-4"><?php echo $output['order_array']['buy_num'].$lang['langOJian']; ?></td>
					    <td class="cr-1"><?php echo $lang['langOTatalPrice'];?>:</td>
					    <td class="cr-5"><?php echo $output['order_array']['total_price']; ?></td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOProductType'];?>:</td>
					    <td class="cr-3">
					    	<?php
					    		if ( $output['order_array']['sell_type'] == '0' ) {
					    			echo $lang['langOPaiMai'];
					    		}
					    		if ( $output['order_array']['sell_type'] == '1' ) {
					    			echo $lang['langOYiKouJia'];
					    		}	
					    		if ( $output['order_array']['sell_type'] == '2' ) {
					    			echo $lang['langOTuanGou'];
					    		}		
					    		if ( $output['order_array']['sell_type'] == '3' ) {
					    			echo $lang['langOCountdown'];
					    		}						    						    						    		
					    	?>
					    </td>
					    <td class="cr-1"><?php echo $lang['langOCarryFunction'];?>:</td>
					    <td class="cr-2">
					    	<?php 
					    		if ( $output['order_array']['tf_type'] == '1' ) {
					    			echo $lang['langOPingYou'];
					    			echo $lang['langOrderPrice'].":".$output['order_array']['tf_fee'];
					    		}
					    		if ( $output['order_array']['tf_type'] == '2' ) {
					    			echo $lang['langOKuaiDi'];
					    			echo $lang['langOrderPrice'].":".$output['order_array']['tf_fee'];
					    		}	
					    		if ( $output['order_array']['tf_type'] == '3' ) {
					    			echo "EMS ".$lang['langOrderPrice'].":".$output['order_array']['tf_fee'];
					    		}
					    		if ( $output['order_array']['tf_type'] == '' ) {
					    			echo $lang['langOSaleChengDanYunFei'];
					    		}					    								    						    		
					    	?>
					    </td>
					    <td class="cr-1"><?php echo $lang['langOrderCurrency'];?>:</td>
					    <td class="cr-2"><?php echo $output['order_array']['sp_currency_category']; ?></td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOState'];?>:</td>
					    <td colspan="3" class="cr-2">
					    	<?php 
					    		if ( $output['order_array']['sp_state'] == '1' ) {
					    			echo $lang['langOAlreadyPay'];
					    			echo !empty($output['order_array']['pay_time']) ? $lang['langOPayTime'].":".$output['order_array']['pay_time'] : '';
					    			echo "<br/>";
					    		}
					    		if ( $output['order_array']['sp_state'] == '2' ) {
					    			echo $lang['langOAlreadyDeliver'];
					    			echo !empty($output['order_array']['deliver_time']) ? $lang['langOAlreadyDeliverTime'].":".$output['order_array']['deliver_time'] : '';
					    			echo "<br/>";
					    		}			
					    		if ( $output['order_array']['sp_state'] == '3' ) {
					    			echo $lang['langOAlreadyReceive'];
					    			echo !empty($output['order_array']['receive_time']) ? $lang['langOAlreadyReceiveTime'].":".$output['order_array']['receive_time'] : '';
					    			echo "<br/>";
					    		}	
					    		if ( $output['order_array']['sp_state'] == '4' ) {
					    			echo $lang['langOGrouping'];
					    			echo "<br/>";
					    		}	
					    		if ( $output['order_array']['sp_state'] == '5' ) {
					    			echo $lang['langOGroupLost'];
					    			echo "<br/>";
					    		}	
					    		if ( $output['order_array']['sp_state'] == '6' ) {
					    			echo $lang['langOPayLost'];
					    			echo "<br/>";
					    		}	
					    		if ( $output['order_array']['sp_state'] == '7' ) {
					    			echo $lang['langOrderStateClose'];
					    			echo "<br/>";
					    		}	
					    		if ( $output['order_array']['sp_state'] == '0' ) {
					    			echo $lang['langOAlreadyBuy'];
					    			echo !empty($output['order_array']['sold_time']) ? $lang['langOSaleOutTime'].":".$output['order_array']['sold_time'] : '';
					    			echo "<br/>";
					    		}						    						    							    							    						    							    				    	
					    	?>
					    </td>
					    <td class="cr-1"><?php echo $lang['langOrderPayment'];?>:</td>
					    <td class="cr-2">
					    	<?php 
					    		if ( $output['order_array']['sp_pay_mechod'] == 'offline' ) {
					    			echo $lang['langOOffline'];
					    		}
					    		if ( $output['order_array']['sp_pay_mechod'] == 'alipay' ) {
					    			echo $lang['langOrderPaymentAlipay'];
					    		}	
					    		if ( $output['order_array']['sp_pay_mechod'] == 'tenpay' ) {
					    			echo $lang['langOrderPaymentTenpay'];
					    		}		
					    		if ( $output['order_array']['sp_pay_mechod'] == 'predeposit' ) {
					    			echo $lang['langOrderPaymentPredeposit'];
					    		}		
					    		if ( $output['order_array']['sp_pay_mechod'] == 'paypal' ) {
					    			echo $lang['langOrderPaymentPaypal'];
					    		}						    						    					    						    		
					    	?>
					    </td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOLeaveword'];?>:</td>
					    <td colspan="5" class="cr-2"><?php echo !empty( $output['order_array']['leaveword'] ) ? $output['order_array']['leaveword'] : $lang['langCNot']; ?></td>
					  </tr>																
					</table>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0" style="margin-top:5px;">
					  <tr>
					    <td colspan="6" class="cr-1"><strong><?php echo $lang['langOReceive'];?></strong></td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOReceiveAddress']; ?>:</td>
					    <td colspan="5" class="cr-2"><?php echo $output['receive_info']['area'] . '&nbsp;' .$output['receive_info']['address']; ?></td>
					  </tr>
					  <tr>
					    <td class="cr-1" ><?php echo $lang['langOReceiveName']; ?>:</td>
					    <td class="cr-3"  style="width:150px;" ><?php echo $output['receive_info']['receive_name']; ?></td>
					    <td class="cr-1" style="width:70px;" ><?php echo $lang['langOYouZhengBianMa']; ?>:</td>
					    <td class="cr-4" style="width:120px;"><?php echo $output['receive_info']['zip']; ?></td>
					    <td class="cr-1" style="width:60px;"  ><?php echo $lang['langOLianXiDianHua']; ?>:</td>
					    <td class="cr-5" style="width:180px; line-height:20px;" >
					    	<?php
					    		echo $lang['langOPhone'].":";
					    		echo !empty( $output['receive_info']['phone'] ) ? $output['receive_info']['phone'] : $lang['langCNot'];
					    		echo "<br/>";
					    		echo $lang['langOMobilePhone'].":";
					    		echo !empty( $output['receive_info']['mobilephone'] ) ? $output['receive_info']['mobilephone'] : $lang['langCNot'];
					    	?>
					    </td>
					  </tr>					
					</table>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0" style="margin-top:5px;">
					  <tr>
					    <td colspan="6" class="cr-1"><strong><?php echo $lang['langOMemberInfo']; ?></strong></td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOSaleName']; ?>:</td>
					    <td class="cr-3"><?php echo !empty( $output['seller_info']['login_name'] ) ? $output['seller_info']['login_name'] : $lang['langOMemberIsNotExit']; ?></td>
					    <td class="cr-1"><?php echo $lang['langOSaleLianXiFunction']; ?>:</td>
					    <td class="cr-4">
					    	<?php if ( $output['seller_info']['member_id'] != '' ) { ?>
					    		<a href="<?php echo SITE_URL; ?>/member/own_message.php?action=add&username=<?php echo $output['seller_info']['login_name']; ?>" target="_blank"><img src="<?php echo SITE_URL; ?>/templates/store/images/zhannei.gif" /></a>
						    	<?php if ( $output['seller_info']['TAOBAO'] != '' ) { ?>
									<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=1&uid=<?php echo $output['seller_info']['TAOBAO']; ?>&site=cntaobao&s=2" ><img border="0" src="http://amos1.taobao.com/online.ww?v=1&uid=<?php echo $output['seller_info']['TAOBAO']; ?>&site=cntaobao&s=2" alt="<?php echo $lang['langPOnClickMyMessage']; ?>" /></a>
						    	<?php } ?>		
						    	<?php if ( $output['seller_info']['QQ'] != '' ) { ?>
									<a href=tencent://message/?uin=<?php echo $output['seller_info']['QQ']; ?>&Site=<?php echo SITE_URL; ?>&Menu=yes><img border="0" SRC=http://wpa.qq.com/pa?p=1:<?php echo $output['seller_info']['QQ']; ?>:4 alt="<?php echo $lang['langPOnClickMyMessage']; ?>"></a>
						    	<?php } ?>		
						    	<?php if ( $output['seller_info']['MSN'] != '' ) { ?>
									<a href="msnim:chat?contact=<?php echo $output['seller_info']['MSN']; ?>"><IMG src="http://img8.cn.msn.com/images/msfp_008.gif" width="19" height="19" border="0"></a>
						    	<?php } ?>	
						    	<?php if ( $output['seller_info']['SKYPE'] != '' ) { ?>
									<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
									<a href="skype:<?php echo $output['seller_info']['SKYPE']; ?>?call"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_34x34.png" style="border: none;" width="20" height="20" alt="Skype Me™!" /></a>
						    	<?php } ?>							    	
					    	<?php 
					    		} else {
					    			echo $lang['langOMemberIsNotExit'];
					    		}
					    	?>					    					    				    	
					    </td>
					    <td class="cr-1"><?php echo $lang['langOShiFouPingJia']; ?>:</td>
					    <td class="cr-5">
					    	<?php 
					    		if ( $output['order_array']['sole_have_comment'] == '0' ) {
					    			echo $lang['langOSaleWeiPingJia'];
					    		}
					    		if ( $output['order_array']['sole_have_comment'] == '1' ) {
					    			echo $lang['langOSaleYiPingJia'];
					    		}					    		
					    	?>
					    </td>
					  </tr>
					  <tr>
					    <td class="cr-1"><?php echo $lang['langOBoughtName']; ?>:</td>
					    <td class="cr-3">
					    	<?php
					    		if ( $output['order_array']['anonymous'] == '0' ) {
					    			echo !empty( $output['buyer_info']['login_name'] ) ? $output['buyer_info']['login_name'] : $lang['langOMemberIsNotExit'];
					    		} else {
					    			echo $lang['langOrderAnonymityBuy'];
					    		}
					    	?>
					    </td>
					    <td class="cr-1"><?php echo $lang['langOBoughtLianXiFunction']; ?>:</td>
					    <td class="cr-4">
						    <?php if ( $output['order_array']['anonymous'] == '0' ) { ?>
						    	<?php if ( $output['buyer_info']['member_id'] != '' ) { ?>
						    		<a href="<?php echo SITE_URL; ?>/member/own_message.php?action=add&username=<?php echo $output['buyer_info']['login_name']; ?>" target="_blank"><img src="<?php echo SITE_URL; ?>/templates/store/images/zhannei.gif" /></a>
							    	<?php if ( $output['buyer_info']['TAOBAO'] != '' ) { ?>
										<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=1&uid=<?php echo $output['buyer_info']['TAOBAO']; ?>&site=cntaobao&s=2" ><img border="0" src="http://amos1.taobao.com/online.ww?v=1&uid=<?php echo $output['buyer_info']['TAOBAO']; ?>&site=cntaobao&s=2" alt="<?php echo $lang['langPOnClickMyMessage']; ?>" /></a>
							    	<?php } ?>		
							    	<?php if ( $output['buyer_info']['QQ'] != '' ) { ?>
										<a href=tencent://message/?uin=<?php echo $output['buyer_info']['QQ']; ?>&Site=<?php echo SITE_URL; ?>&Menu=yes><img border="0" SRC=http://wpa.qq.com/pa?p=1:<?php echo $output['buyer_info']['QQ']; ?>:4 alt="<?php echo $lang['langPOnClickMyMessage']; ?>"></a>
							    	<?php } ?>		
							    	<?php if ( $output['buyer_info']['MSN'] != '' ) { ?>
										<a href="msnim:chat?contact=<?php echo $output['buyer_info']['MSN']; ?>"><IMG src="http://img8.cn.msn.com/images/msfp_008.gif" width="19" height="19" border="0"></a>
							    	<?php } ?>	
							    	<?php if ( $output['buyer_info']['SKYPE'] != '' ) { ?>
										<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
										<a href="skype:<?php echo $output['buyer_info']['SKYPE']; ?>?call"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_34x34.png" style="border: none;" width="20" height="20" alt="Skype Me™!" /></a>
							    	<?php } ?>							    	
						    	<?php 
						    		} else {
						    			echo $lang['langOMemberIsNotExit'];
						    		}
						    	} else {
						    		echo $lang['langOrderAnonymityBuy'];
						    	}
						    	?>					    
					    </td>
					    <td class="cr-1"><?php echo $lang['langOShiFouPingJia']; ?>:</td>
					    <td class="cr-5">
					    	<?php
					    		if ( $output['order_array']['buy_have_comment'] == '0' ) {
					    			echo $lang['langOBuyWeiPingJia'];
					    		} 
					    		if ( $output['order_array']['buy_have_comment'] == '1' ) {
					    			echo $lang['langOBuyYiPingJia'];
					    		} 					    		
					    	?>					    
					    </td>
					  </tr>					
					</table>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input type="button" class='submit' name="" value="<?php echo $lang['langOrderBack']; ?>" onclick="history.back()" />
					</span>
				</div>
			</div>
		</div>
	</div>
</div>