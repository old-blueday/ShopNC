<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
<script type="text/javascript">
$().ready(function() {
	$('#icon_close_search_box').click(
		function(){ $('#filter').slideUp('slow',function(){$('#showcontr').slideDown('fast')})}
	);
	$('#showcontr').click(
		function(){ $('#showcontr').slideUp('fast',function(){$('#filter').slideDown('slow')})}
	);
	$(".tr_dotted").hover(function(){$(this).addClass("over")},function(){$(this).removeClass("over")});
	$('#delete').click(
		function(){
			if(checkFormIn('delete')){
				$('#form_product').attr("action", "own_product_group.php?action=del");
				$('#form_product').submit();
			}
	});
	$('#offsale').click(
		function(){
			if(checkFormIn('offsale')){
				$('#form_product').attr("action", "own_product_group.php?action=offsale");
				$('#form_product').submit();
			}
		}
	)
	$('#recommended').click(
		function(){
			if(checkFormIn('recommended')){
				$('#form_product').attr("action", "own_product_group.php?action=recommended");
				$('#form_product').submit();
			}
		}
	)
	$('#cancel_recommended').click(
		function(){
			if(checkFormIn('cancel_recommended')){
				$('#form_product').attr("action", "own_product_group.php?action=cancel_recommended");
				$('#form_product').submit();
			}
		}
	)
    $('#store_recommended').click(
        function(){
			if(checkFormIn('store_recommended')){
				$('#form_product').attr('action','own_product_group.php?action=store_recommended');
				$('#form_product').submit();
			}
        }
    )
    $('#cancel_store_recommended').click(
        function(){
			if(checkFormIn('cancel_store_recommended')){
				$('#form_product').attr('action','own_product_group.php?action=cancel_store_recommended');
				$('#form_product').submit();
			}
        }
    )
});

function checkFormIn(type){
	if (type == 'delete') {
		return checkForm('<?php echo $lang['langProductMUpRackDeleteOk']; ?>','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'offsale') {
		return checkForm('<?php echo $lang['langProductMUpRackDetermine']; ?>','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'recommended') {
		return checkForm('1','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'cancel_recommended') {
		return checkForm('1','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'store_recommended') {
		return checkForm('1','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'cancel_store_recommended') {
		return checkForm('1','<?php echo $lang['langProductMPleaseSelect']; ?>');
	}
}
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langProductMSaleBaby'];?></p>
				</div>
				<div class="sos">
					<form action="own_product_list.php?action=list" method="post"  name="search_form">
						<ul>
							<li class="depot-search"><?php echo $lang['langProductMSeeBaby']; ?></li>
							<li class="zi-w"><?php echo $lang['langSelltype']; ?>:</li>
							<li class="zi-w-80">
								<select name="sellType">
									<option value="" selected="selected"><?php echo $lang['langProductMAll']; ?></option>
									<option value="1" <?php if ( $output['condition']['sell_type'] == '1' ) { ?> selected <?php } ?>><?php echo $lang['langPfixprice']; ?></option>
									<option value="0" <?php if ( $output['condition']['sell_type'] == '0' ) { ?> selected <?php } ?>><?php echo $lang['langPauction']; ?></option>
									<option value="2" <?php if ( $output['condition']['sell_type'] == '2' ) { ?> selected <?php } ?>><?php echo $lang['langPcamel']; ?></option>
								</select>
							</li>
							<li class="zi-w"><?php echo $lang['langProductAType']; ?>:</li>
							<li class="zi-w-80">
								<select name="pType">
									<option value="" selected="selected"><?php echo $lang['langProductMAll']; ?></option>
									<option value="0" <?php if ( $output['condition']['p_type'] == '0' ) { ?> selected <?php } ?>><?php echo $lang['langProductTypeNew']; ?></option>
									<option value="1" <?php if ( $output['condition']['p_type'] == '1' ) { ?> selected <?php } ?>><?php echo $lang['langProductTypeSec']; ?></option>
									<option value="2" <?php if ( $output['condition']['p_type'] == '2' ) { ?> selected <?php } ?>><?php echo $lang['langProductTypePlace']; ?></option>
								</select>
							</li>
							<li class="zi-w"><?php echo $lang['langProductKeyword']; ?>:</li>
							<li class="zi-w-80"><input class="input-100" name="keyword" type="text" value="<?php echo $output['condition']['key']; ?>" /></li>
							<li class="aan-1"><span class="buttom-comm-1"><input class="input-a" name="" value="<?php echo $lang['langProductMSeeBaby']; ?>" type="submit" /></span></li>
						</ul>
					</form>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_list.php?action=list"><?php echo $lang['langProductMSaleBaby'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_fixprice.php?action=list"><?php echo $lang['langPFixPriceList'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_auction.php?action=list"><?php echo $lang['langPAuctionList'];?></a></p></span></li>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPGroupBuyList'];?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_countdown_list.php?action=list"><?php echo $lang['langPCountdownList'];?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-3" style="width:10%;"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-1" style="width:30%;"><?php echo $lang['langProductMName']; ?></td>
							<td class="td-bg-3" style="width:10%;"><?php echo $lang['langProductMNum']; ?></td>
							<td class="td-bg-3" style="width:10%;"><?php echo $lang['langProductAddTime']; ?></td>
							<td class="td-bg-3" style="width:10%;"><?php echo $lang['langProductStartTime']; ?></td>
							<td class="td-bg-3" style="width:10%;"><?php echo $lang['langProductEndTime']; ?></td>
							<td class="td-bg-7" style="width:10%;"><?php echo $lang['langCedit']; ?></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="7"></td>
						</tr>
						<form name="form_product" id="form_product" method="post" >
						<input type="hidden" name="list_type" id="list_type" value="list" />
						<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
						<?php foreach($output['product_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-4">
							<td>
								<input class="checbox" name="chboxPid[]" type="checkbox" value="<?php echo $v['p_code'];?>" />
								<input type="hidden" name="recommended_sign_<?php echo $k;?>" id="recommended_sign_<?php echo $k;?>" value="<?php echo $v['p_recommended'];?>" />
								<input type="hidden" name="check_sign[<?php echo $v['p_code'];?>]" value="<?php echo $v['check_sign'];?>" />
								<?php
									/**
									 * 如果是拍卖商品，隐藏域包括商品价格，用来更新当前拍卖价格
									 */
									 if($v['p_sell_type'] == '0'){
								?>
								<input type="hidden" name="p_price[<?php echo $v['p_code'];?>]" value="<?php echo $v['p_price'];?>" />
								<?php } ?>
							</td>
							<td class="tr-img">
								<?php if ( $v['ifhtml'] == '1' && $v['html_url'] != '' ) { ?>
									<span class="depott-span-1">
										<a href="<?php echo SITE_URL; ?>/home/product_group.php?action=view&p_code=<?php echo $v['p_code'];?>" target="_blank">
											<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $v['p_pic'] ) && $v['p_pic'] != 'null' ? $v['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $v['p_name']; ?>" title="<?php echo $v['p_name']; ?>"/>
										</a>
									</span>
									<span class="depott-span-3">
										<p><a href="<?php echo SITE_URL; ?>/home/product_group.php?action=view&p_code=<?php echo $v['p_code'];?>" target="_blank"><?php echo $v['p_name'];?></a></p>
										<p class="depott-p-2">(<?php echo $lang['langPcamel'];?>)</p>
										<?php if ( $v['p_recommended'] == '1' ) { ?>
											<p style="color:#FF0000;"><?php echo $lang['langCCommend']; ?></p>
										<?php } ?>
									</span>
								<?php } else {?>
									<span class="depott-span-1">
										<a href="<?php echo SITE_URL; ?>/home/product_group.php?action=view&p_code=<?php echo $v['p_code'];?>" target="_blank">
											<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $v['p_pic'] ) && $v['p_pic'] != 'null' ? $v['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $v['p_name']; ?>" title="<?php echo $v['p_name']; ?>"/>
										</a>
									</span>
									<span class="depott-span-31">
										<p><a href="<?php echo SITE_URL; ?>/home/product_group.php?action=view&p_code=<?php echo $v['p_code'];?>" target="_blank"><?php echo $v['p_name'];?></a></p>
										<p class="depott-p-2">(<?php echo $lang['langPcamel'];?>)</p>
										<p style="color:#FF0000;">
                                        <?php if ( $v['p_recommended'] == '1' )  echo $lang['langRecommended']; ?>
                                        <?php if($v['p_store_recommended'] == 1) { ?>
                                            <?php if($v['p_recommended'] == 1) echo ','; ?>
                                            <?php echo $lang['langStoreRecommended']; ?>
                                        <?php } ?>
                                        </p>
									</span>
								<?php } ?>
							</td>
							<td >
								<?php echo $v['p_storage'];?>
							</td>
							<td>
								<?php echo $v['p_add_time_ymd'];?>
							</td>
							<td>
								<?php echo $v['p_start_time_ymd'];?>
							</td>
							<td>
								<?php echo $v['p_end_time_ymd'];?>
							</td>
							<td>
								<?php if($v['check_sign'] == ''){ ?>
									<p class="editiconTwo" ><a href="own_product_group.php?action=modi&p_code=<?php echo $v['p_code'];?>"><?php echo $lang['langCedit'];?></a></p>
								<?php } else { ?>
									<p class="no_editiconTwo"><?php echo $lang['langCedit'];?></p>
								<?php } ?>
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
					</table>
					<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
						<div class="handle">
							<ul class="depot-ul depot-ul-li-2">
								<!-- 全选/反选 -->
								<li class="depot-li-te"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?></a></li>
                                <!-- 店铺推荐 -->
                                <li><span class="span-button"><input name="store_recommended" id="store_recommended" value="<?php echo $lang['langStoreRecommended']; ?>" type="button"/></span></li>
                                <li><span class="span-button"><input name="cancel_store_recommended" id="cancel_store_recommended" value="<?php echo $lang['langCancelStoreRecommended']; ?>" type="button"/></span></li>
								<li><span class="span-button"><input name="recommended" id="recommended" value="<?php echo $lang['langRecommended'];?>" type="button" /></span></li>
								<li><span class="span-button"><input name="cancel_recommended" id="cancel_recommended" value="<?php echo $lang['langProductMCancelRecommended'];?>" type="button" /></span></li>
								<li><span class="span-button"><input id="delete" value="<?php echo $lang['langCdele'];?>" type="button" /></span></li>
								<li><span class="span-button"><input name="offsale" id="offsale" value="<?php echo $lang['langProductMDownRack'];?>" type="button" /></span></li>
								<input type="hidden" name="state" id="state" value="0">
							</ul>
						</div>
					<?php } ?>
				</div>
				<?php if($output['product_array'][0]['p_code'] != ''){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['page_list']; ?>
						</div>
					</div>
				<?php } ?>
				</form>
			</div>
		</div>
	</div>
</div>