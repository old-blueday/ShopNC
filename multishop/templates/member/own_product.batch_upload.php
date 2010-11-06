<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langProductMSaleBaby'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langProductMSaleBaby'];?></p></span></li>
					</ul>
				</div>
				
				<div class="z-mai-unite">
					<form action="own_product_batch.php?action=upload_in" method="post" name="form_product" id="form_product">
					<input type="hidden" name="pay_method" id="pay_method" value="<?php echo $output['condition']['pay_method'];?>" />
					<input type="hidden" name="p_currency_category" id="p_currency_category" value="<?php echo $output['condition']['p_currency_category'];?>" />
					<input type="hidden" name="searchcate" id="searchcate" value="<?php echo $output['condition']['searchcate'];?>" />
					<input type="hidden" name="shop_product_category" id="shop_product_category" value="<?php echo $output['condition']['shop_product_category']?$output['condition']['shop_product_category']:'0';?>" />
					<input type="hidden" name="area_id" id="area_id" value="<?php echo $output['condition']['area_id'];?>" />				
					<table class="unite-table-1"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-3"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-6"><?php echo $lang['langBatchProductName']; ?></td>
							<td class="td-bg-6"><?php echo $lang['langBatchProductInfo']; ?></td>
							<td class="td-bg-6"><?php echo $lang['langBatchProductStorage']; ?></td>
							<td class="td-bg-6"><?php echo $lang['langBatchProductPrice']; ?></td>
							<td class="td-bg-6"><?php echo $lang['langBatchProductType']; ?>/<?php echo $lang['langBatchProductSellType']; ?></td>
							<td class="td-bg-7"><?php echo $lang['langBatchProductOther']; ?></td>
						</tr>	
						<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
							<?php foreach($output['product_array'] as $k => $v){ ?>						
								<tr class="tr-un-conter-4">
									<td><input type="checkbox" name="chboxPid[<?php echo $k;?>]" checked="checked" value="<?php echo $k;?>" /></td>
									<td><input class="input-100" class="in" name="p_name[]" type="text" id="p_name_<?php echo $k;?>" value="<?php echo $v['p_name'];?>" /></td>
									<td><input class="input-100" class="in" name="p_info[]" type="text" id="p_info_<?php echo $k;?>" value="<?php echo $v['p_info'];?>" /></td>
									<td><input class="input-100" class="in" name="p_storage[]" type="text" id="p_storage_<?php echo $k;?>" value="<?php echo $v['p_storage'];?>" /></td>
									<td><input class="input-100" class="in" name="p_price[]" type="text" id="p_price_<?php echo $k;?>" value="<?php echo $v['p_price'];?>" /></td>
									<td>
										<?php if($v['radioType'] == '0'){?>
										<?php echo $lang['langBatchProductTypeZero'];?>
										<?php }?>
										<?php if($v['radioType'] == '1'){?>
										<?php echo $lang['langBatchProductTypeOne'];?>
										<?php }?>
										<?php if($v['radioType'] == '2'){?>
										<?php echo $lang['langBatchProductTypeTwo'];?>
										<?php }?>
										<br />
										<?php if($v['radioSelltype'] == '0'){?>
										<?php echo $lang['langBatchProductSellTypeZero'];?>
										<?php }?>
										<?php if($v['radioSelltype'] == '1'){?>
										<?php echo $lang['langBatchProductSellTypeOne'];?>
										<?php }?>
										<?php if($v['radioSelltype'] == '2'){?>
										<?php echo $lang['langBatchProductSellTypeTwo'];?>
										<?php }?>
									</td>
									<td>
										<?php if($v['radioTransfee'] == '0'){?>
											<?php echo $lang['langBatchProductTransfeeChargeOne'];?>
										<?php }else{?>
											<?php echo $lang['langBatchProductTransfeeChargeTwo'];?>
											<?php if($v['pyTF'] != '0'){?>
											<br />
											<?php echo $lang['langBatchProductTransfeePY'];?>:<?php echo $v['pyTF'];?>
											<?php }?>
											<?php if($v['emsTF'] != '0'){?>
											<br />
											<?php echo $lang['langBatchProductTransfeeEMS'];?>:<?php echo $v['emsTF'];?>
											<?php }?>
											<?php if($v['kdTF'] != '0'){?>
											<br />
											<?php echo $lang['langBatchProductTransfeeKD'];?>:<?php echo $v['kdTF'];?>
											<?php }?>
										<?php }?>
									</td>
								</tr>										
								<!--   start 商品参数  -->
								<input type="hidden" name="system_step[]" value="<?php echo $v['system_step'];?>" />
								<input type="hidden" name="price_step[]" value="<?php echo $v['price_step'];?>" />
								<input type="hidden" name="group_price[]" value="<?php echo $v['group_price'];?>" />
								<input type="hidden" name="group_mincount[]" value="<?php echo $v['group_mincount'];?>" />
								<input type="hidden" name="radioTransfee[]" value="<?php echo $v['radioTransfee'];?>" />
								<input type="hidden" name="pyTF[]" value="<?php echo $v['pyTF'];?>" />
								<input type="hidden" name="emsTF[]" value="<?php echo $v['emsTF'];?>" />
								<input type="hidden" name="kdTF[]" value="<?php echo $v['kdTF'];?>" />
								<input type="hidden" name="radioType[]" value="<?php echo $v['radioType'];?>" />
								<input type="hidden" name="radioSelltype[]" value="<?php echo $v['radioSelltype'];?>" />
								<input type="hidden" name="invoices[]" value="<?php echo $v['invoices'];?>" />
								<input type="hidden" name="warranty[]" value="<?php echo $v['warranty'];?>" />
								<input type="hidden" name="p_pic[]" value="<?php echo $v['p_pic'];?>" />
							<?php } ?>
							<?php } else{ ?>
								<tr class="tr-not">
									<td colspan="7">
										<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
									</td>
								</tr>
							<?php } ?>	
					</table>
					<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
						<div class="handle">
							<ul class="depot-ul depot-ul-li-2">
								<!-- 全选/反选 -->
								<li class="depot-li-te"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?></a></li>		
								<li><span class="span-button"><input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsave'];?>" /></span></li>
							</ul>
						</div>
					<?php } ?>					
					</form>					
				</div>
			</div>
		</div>
	</div>
</div>