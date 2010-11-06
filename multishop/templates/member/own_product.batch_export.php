<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langBatchProductExport'];?></p>
				</div>
				<div class="clear-12"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="own_product_batch.php"><?php echo $lang['langBatchProduct'];?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langBatchProductExport'];?></p></span></li>
					</ul>
				</div>
				<div class="rope-conter-1">
					<div class="sort">
						<h3><p>
						<a href="own_product_batch.php?action=export"><?php echo $lang['langBatchProductAllClass'];?></a>
						<?php if(!empty($output['cate_path']) && is_array($output['cate_path'])){?>
						<?php foreach($output['cate_path'] as $k => $v){?>
							- <a href="own_product_batch.php?action=export&parent_id=<?php echo $v['id'];?>"><?php echo $v['name'];?></a>
						<?php }?>
						<?php }?>
						</p></h3>
						<ul>
							<?php if(!empty($output['ProductCateArray']) && is_array($output['ProductCateArray'])){?>
							<?php foreach($output['ProductCateArray'] as $k => $v){?>
								<li><a href="own_product_batch.php?action=export&parent_id=<?php echo $v[0];?>"><?php echo $v[2];?></a></li>
							<?php }?>
							<?php }?>
						</ul>
					</div>
					<div class="clear">
					</div>
					<div class="sort-pivotal">
						<form action="own_product_batch.php" method="get" name="form_export_search" id="form_export_search">
							<input type="hidden" name="action" id="action" value="export" />
							<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $output['parent_id'];?>" />
							<input type="hidden" name="search_sort" id="search_sort" value="<?php echo $output['input_param']['search_sort'];?>" />
						<table class="sort-pivotal-table" border="0" cellpadding="0">
							<tr>
								<td class="sort-td-1"><?php echo $lang['langBatchProductSeachKey'];?>:</td>
								<td class="sort-td-2"><input class="input-150" name="search_key" id="search_key" type="text" value="<?php echo $output['input_param']['search_key'];?>" /> <?php echo $lang['langBatchProductSeachKeyRemark'];?></td>
								<td class="sort-td-1"><?php echo $lang['langBatchProductPrice'];?>:</td>
								<td class="sort-td-2">
									<input class="input-60" name="search_price_start" id="search_price_start" type="text" value="<?php echo $output['input_param']['search_price_start'];?>" />
									<input class="input-60" name="search_price_end" id="search_price_end" type="text" value="<?php echo $output['input_param']['search_price_end'];?>" /> <?php echo $lang['langBatchProductPriceYuan'];?></td>
								<td class="sort-td-4"><?php echo $lang['langBatchProductTransfeeCharge'];?>:</td>
								<td class="sort-td-3"><input class="checbox" name="search_transfee_charge" id="search_transfee_charge" type="checkbox" value="0" <?php if($output['input_param']['search_transfee_charge'] == '0'){?>checked="checked"<?php }?> /> <label for="search_transfee_charge"><?php echo $lang['langBatchProductTransfeeChargeOne'];?></label></td>
							</tr>
							<tr>
								<td class="sort-td-1"><?php echo $lang['langBatchProductSellType'];?>:</td>
								<td class="sort-td-2">
									<input class="rdio" name="search_sell_type" id="search_sell_type" type="radio" value="" <?php if($output['input_param']['search_sell_type'] == ''){?>checked="checked"<?php }?> /><label for="search_sell_type"><?php echo $lang['langBatchProductSellTypeNone'];?></label>
									<input class="rdio" name="search_sell_type" id="search_sell_type_1" type="radio" value="1" <?php if($output['input_param']['search_sell_type'] == '1'){?>checked="checked"<?php }?> /><label for="search_sell_type_1"><?php echo $lang['langBatchProductSellTypeOne'];?></label>
									<input class="rdio" name="search_sell_type" id="search_sell_type_2" type="radio" value="2" <?php if($output['input_param']['search_sell_type'] == '2'){?>checked="checked"<?php }?> /><label for="search_sell_type_2"><?php echo $lang['langBatchProductSellTypeTwo'];?></label>
									<input class="rdio" name="search_sell_type" id="search_sell_type_3" type="radio" value="0" <?php if($output['input_param']['search_sell_type'] == '0'){?>checked="checked"<?php }?> /><label for="search_sell_type_3"><?php echo $lang['langBatchProductSellTypeThree'];?></label>
								</td>
								<td class="sort-td-1"><?php echo $lang['langBatchProductCloseDay'];?>:</td>
								<td class="sort-td-2"><input class="input-100" name="search_close_day" id="search_close_day" type="text" value="<?php echo $output['input_param']['search_close_day'];?>" /> <?php echo $lang['langBatchProductDay'];?></td>
								<td class="sort-td-4"><?php echo $lang['langBatchProductState'];?>:</td>
								<td class="sort-td-3">
									<input class="rdio" name="search_state" id="search_state_0" type="radio" value="" /><label for="search_state_0"><?php echo $lang['langBatchProductStateUp'];?></label>
									<input class="rdio" name="search_state" id="search_state_1" type="radio" value="" /><label for="search_state_1"><?php echo $lang['langBatchProductStateDown'];?></label>
								</td>
							</tr>
						</table>
						</form>
					</div>
				<form action="own_product_batch.php?action=export_upload" method="post" name="form_modi" id="form_modi">
					<div class="sort-list">
						<ul class="sort-list-1">
							<li class="sort-li-1"><?php echo $lang['langProductMSelect'];?></li>
							<li class="sort-li-2"><?php echo $lang['langProductMName'];?></li>
							<li class="sort-li-3"><?php echo $lang['langBatchProductPrice'];?></li>
							<li class="sort-li-4"><?php echo $lang['langBatchProductStorage'];?></li>
							<li class="sort-li-5"><?php echo $lang['langBatchProductState'];?></li>
							<li class="sort-li-6"></li>
						</ul>
						<?php if(!empty($output['product_array']) && is_array($output['product_array'])){ ?>
						<?php foreach($output['product_array'] as $k => $v){ ?>
						<ul class="sort-list-2">
							<li class="sort-li-1"><input name="chboxPid[]" id="sel_<?php echo $v['p_code']; ?>" type="checkbox" value="<?php echo $v['p_code']; ?>" /></li>
							<li class="sort-li-2"><a href="../home/product.php?action=view&pid=<?php echo $v['p_code']; ?>" target="_blank"><?php echo $v['p_name']; ?></a></li>
							<li class="sort-li-3"><?php echo $v['p_price']; ?></li>
							<li class="sort-li-4"><?php echo $v['p_storage']; ?></li>
							<li class="sort-li-5">
								<?php if($v['p_state'] == '0'){ ?>
								<?php echo $lang['langBatchProductStateDown']; ?>
								<?php } ?>
								<?php if($v['p_state'] == '1'){ ?>
								<?php echo $lang['langBatchProductStateUp']; ?>
								<?php } ?>
							</li>
							<li class="sort-li-6"></li>
						</ul>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
				<div class="an-1"><span class="buttom-comm"><input name="" value="<?php echo $lang['langBatchExportByCSV'];?>" type="submit" /></span></div>
				</form>
				<?php if($output['product_array'][0]['p_code'] != ''){ ?>
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