<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
<script type="text/javascript">
$().ready(function() {
	$('#negative').click(
		function(){
			$(".tr-un-conter-4 input[type='checkbox']").each(function(){
				$(this).attr('checked',!$(this).attr('checked'))
			})
		}
	);
	$('#delete').click(
		function(){
			if(checkFormIn('delete')){
				$('#form_product').attr("action", "own_product_fixprice.php?action=del");
				$('#form_product').submit();
			}
	});
	$('#onsale').click(
		function(){ 
			if(checkFormIn('onsale')){
				$('#form_product').attr("action", "own_product_fixprice.php?action=update_state");
				$('#form_product').submit();
			}
		}
	);	
	$('#update_count_price').click(
		function(){
			if(checkFormIn('update')){
				$('#form_product').attr("action", "own_product_fixprice.php?action=update_count_price");
				$('#form_product').submit();
			}
		}
	);
	$(".td-blod input").keyup(function(){
		reg = /^(0|[1-9][0-9]*)$/
		if (!reg.test($(this).val())) {
			alert('<?php echo $lang['errPstorage']; ?>');
			$(this).val('1');
		}
	});
});

function checkFormIn(type){
	if (type == 'delete') {
		return checkForm('<?php echo $lang['langProductMUpRackDeleteOk']; ?>','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'onsale') {
		return checkForm('<?php echo $lang['langProductMUpRackDetermineOk']; ?>','<?php echo $lang['langProductMPleaseSelect']; ?>');
	} else if (type == 'update') {
		return checkForm('<?php echo $lang['langProductMUpRackSaveOk']; ?>','<?php echo $lang['langProductMPleaseSelect']; ?>');
	}
}

function update_count(obj)
{
	$.post('own_product_fixprice.php?action=ajax_update_count','p_storage='+$(obj).parent().children('input[type="text"]').val()+'&p_code='+$(obj).parent().children('input[type="hidden"]').val(),function(data){alert(data)});
}
function update_price(obj)
{
	$.post('own_product_fixprice.php?action=ajax_update_price','p_price='+$(obj).parent().children('input[type="text"]').val()+'&p_code='+$(obj).parent().children('input[type="hidden"]').val(),function(data){alert(data)});
}
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPFixPriceList'];?></p>
				</div>
				<div class="sos">
					<form action="own_product_list.php?action=listinstock" method="post" name="search_form">
						<ul>
							<li class="depot-search"><?php echo $lang['langProductMSeeBaby']; ?></li>
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
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_list.php?action=list_instock"><?php echo $lang['langProductMDepotBaby'];?></a></p></span></li>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPFixPriceList'];?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_auction.php?action=list_instock"><?php echo $lang['langPAuctionList'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_group.php?action=list_instock"><?php echo $lang['langPGroupBuyList'];?></a></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_countdown_list.php?action=list_instock"><?php echo $lang['langPCountdownList'];?></a></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-3" style="width:10%;"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-11" style="width:25%;"><?php echo $lang['langProductMName']; ?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langProductMNum']; ?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langPfixprice']; ?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langProductStartTime']; ?></td>
							<td class="td-bg-4" style="width:10%;"><?php echo $lang['langProductEndTime']; ?></td>
							<td class="td-bg-7" style="width:10%;"><?php echo $lang['langCedit']; ?></td>
						</tr>
						<form method="post" name="form_product" id="form_product">
						<input type="hidden" name="list_type" id="list_type" value="list_instock" />
						<?php if(!empty($output['product_array']) && is_array($output['product_array'])){?>
						<?php foreach($output['product_array'] as $k => $v){ ?>
						<tr class="tr-un-conter-4">
							<td>
								<input class="checbox" name="chboxPid[]" type="checkbox" value="<?php echo $v['p_code'];?>" />
								<input type="hidden" name="recommended_sign_<?php echo $k;?>" id="recommended_sign_<?php echo $k;?>" value="<?php echo $v['p_recommended'];?>" />
								<input type="hidden" name="check_sign[<?php echo $v['p_code'];?>]" value="<?php echo $v['check_sign'];?>" />
							</td>
							<td  class="tr-img" style="text-align:left;">
								<?php if ( $v['ifhtml'] == '1' && $v['html_url'] != '' ) { ?>
									<span class="depott-span-1">
										<a href="<?php echo $v['html_url']; ?>" target="_blank">
											<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $v['p_pic'] ) ? $v['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $v['p_name']; ?>" title="<?php echo $v['p_name']; ?>"/>
										</a>										
									</span>
									<span class="depott-span-3">
										<p><a href="<?php echo $v['html_url']; ?>" target="_blank"><?php echo $v['p_name'];?></a></p>
									</span>									
								<?php } else {?>
									<span class="depott-span-1">
										<a href="<?php echo SITE_URL.$v['product_url']; ?>" target="_blank">
											<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $v['p_pic'] ) ? $v['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $v['p_name']; ?>" title="<?php echo $v['p_name']; ?>"/>
										</a>										
									</span>
									<span class="depott-span-31" >
										<p><a href="<?php echo SITE_URL.$v['product_url']; ?>" target="_blank"><?php echo $v['p_name'];?></a></p>
									</span>								
								<?php } ?>
							</td>
							<td>
								<input type="hidden" value="<?php echo $v['p_code'];?>"/>
								<input type="text" class="in" name="p_storage[<?php echo $v['p_code'];?>]" id="p_storage" value="<?php echo $v['p_storage'] != 0 ? $v['p_storage'] : 1 ; ?>" size="3" maxlength="6" />&nbsp;<a href="javascript:void(0);" onclick="update_count(this)"><?php echo $lang['langCsave'];?></a>
							</td>
							<td>
								<input type="hidden" value="<?php echo $v['p_code'];?>"/>
								<input type="text" class="in" name="p_price[<?php echo $v['p_code'];?>]" id="p_price" value="<?php echo $v['p_price']; ?>" size="3" maxlength="6" />&nbsp;<a href="javascript:void(0);" onclick="update_price(this)"> <?php echo $lang['langCsave'];?></a>
							</td>
							<td>
								<?php echo $v['p_start_time_ymd'];?>
							</td>
							<td>
								<?php echo $v['p_end_time_ymd'];?>
							</td>
							<td>
								<p class="editiconTwo"><a href="<?php echo $v['modi_url'];?>"><?php echo $lang['langCedit'];?></a></p>
							</td>			
						</tr>
						<?php } ?>
						<?php }else { ?>
						<tr>
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
								<li><span class="span-button"><input id="delete" value="<?php echo $lang['langCdele'];?>" type="button" /></span></li>
								<li><span class="span-button"><input name="onsale" id="onsale" value="<?php echo $lang['langProductMUpRack'];?>" type="button" /></span></li>
								<li><span class="span-button"><input name="update_count_price" id="update_count_price" value="<?php echo $lang['langProductMSave'];?>" type="button" /></span></li>
								<input type="hidden" name="state" id="state" value="1">	
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