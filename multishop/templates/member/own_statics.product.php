<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langOwnStaticsProduct'];?></p>
				</div>
				<!--<div class="sos">
					<ul>
						<li class="depot-150"></li>
						<li class="depot-search">查询</li>
						<li class="zi-w-184"><select name=""></select></li>
						<li class="aan-1"><span class="buttom-comm-1"><input class="input-a" name="" value="搜索结果" type="button" /></span></li>
					</ul>
				</div>-->
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langOwnStaticsProduct'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-10" style="width:25%;"><?php echo $lang['langOwnStaticsProductName']; ?></td>
							<td class="td-bg-2"  style="width:10%;"><?php echo $lang['langOwnStaticsProductSellType']; ?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langOwnStaticsProductStorageNum']; ?></td>
							<td class="td-bg-4" style="width:10%;" ><?php echo $lang['langOwnStaticsPrice']; ?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langOwnStaticsViewNum']; ?></td>
							<td class="td-bg-5" style="width:10%;"><?php echo $lang['langOwnStaticsSoldNum']; ?></td>
							<td class="td-bg-7" style="width:10%;"><?php echo $lang['langOwnStaticsSoldSum']; ?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="7"></td>
						</tr>
						<form action="own_statics.php?action=product" method="post">
						<tr class="tr-un-gray">
							<td class="p-left-rio"><!--<input class="checbox" name="" type="checkbox" value="" /> <?php echo $lang['langCAllSelect']; ?>-->
								</td>
							<td class="right-p" colspan="6">
							<select name="sel_type" id="sel_type" onchange="form.submit();">
									<option value="end_time_desc" <?php if($output['condition']['sel_type'] == 'end_time_desc'){ ?>selected="selected"<?php } ?>><?php echo $lang['langOwnStaticsProductEndTime']; ?></option>
									<option value="storage_asc" <?php if($output['condition']['sel_type'] == 'storage_asc'){ ?>selected="selected"<?php } ?>><?php echo $lang['langOwnStaticsProductStorage']; ?></option>
									<option value="price_asc" <?php if($output['condition']['sel_type'] == 'price_asc'){ ?>selected="selected"<?php } ?>><?php echo $lang['langOwnStaticsProductPrice']; ?></option>
									<option value="view_num_asc" <?php if($output['condition']['sel_type'] == 'view_num_asc'){ ?>selected="selected"<?php } ?>><?php echo $lang['langOwnStaticsProductViewNum']; ?></option>
									<option value="sold_num_asc" <?php if($output['condition']['sel_type'] == 'sold_num_asc'){ ?>selected="selected"<?php } ?>><?php echo $lang['langOwnStaticsProductSoldNum']; ?></option>
									<option value="sold_sum_asc" <?php if($output['condition']['sel_type'] == 'sold_sum_asc'){ ?>selected="selected"<?php } ?>><?php echo $lang['langOwnStaticsProductSoldSum']; ?></option>
								</select>
							</td>
						</tr>
						<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
							<?php foreach($output['product_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-4">
							<td style="width:25%; text-align:left; padding-left:5px;"><a href="<?php echo $v['product_url'];?>"><?php echo $v['p_name'];?></a></td>
							<td style="width:10%;text-align:left; padding-left:25px;">
								<?php if($v['p_sell_type'] == '0'){?>
									<?php echo $lang['langOwnStaticsSellTypeZero'];?>
								<?php }?>
								<?php if($v['p_sell_type'] == '1'){?>
									<?php echo $lang['langOwnStaticsSellTypeOne'];?>
								<?php }?>
								<?php if($v['p_sell_type'] == '2'){?>
									<?php echo $lang['langOwnStaticsSellTypeTwo'];?>
								<?php }?>
								<?php if($v['p_sell_type'] == '3'){?>
									<?php echo $lang['langOwnStaticsSellTypeThree'];?>
								<?php }?>								
							</td>
							<td style="width:10%;">
								<?php echo $v['p_storage'];?>
							</td>
							<td style="width:10%;text-align:left; padding-left:10px;">
								<?php echo $v['p_price'];?><?php echo $lang['langCYuan'];?>
							</td>
							<td style="width:10%;">
								<?php echo $v['p_view_num'];?>
							</td>
							<td style="width:10%;">
								<?php echo $v['p_sold_num'];?>
							</td>
							<td style="width:10%;">
								<?php echo $v['p_sold_sum'];?>
							</td>
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="7">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
						</form>
					</table>
				</div>
				<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
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