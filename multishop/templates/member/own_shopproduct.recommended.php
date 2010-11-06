<script>
function check(){
	var r = document.getElementsByTagName("input") ;
	var sign=0;
	for(i=0;i<r.length;i++){
		if(r[i].type == "checkbox" && r[i].checked == true){
			sign=1;
		}
	}
	if(sign==1){
		return true;
	}else{
		alert("<?php echo $lang['langChoiseVouchWare']?>");
	}
	return false;

}
</script>
<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langShopPManageInfo']; ?> <a class="fzhi" href="<?php echo SITE_URL; ?>/member/own_shopproduct.php?action=list&classid=0"><span><?php echo $lang['langShopPLookNotBobyClass']; ?></span></a></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopPCommendBaby']; ?></p></span></li>
					</ul>
				</div>
				<form action="own_shopproduct.php?action=recommended" name="form1" method="post" onsubmit="return check();">
				<div class="z-mai-unite">
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-1" colspan="4"><?php echo $lang['langShopPMayCommendBaby'];?></td>
						</tr>
						<?php if( !empty($output['shop_recommended_product_array']) && is_array($output['shop_recommended_product_array']) ){ ?>
								<tr>
							<?php foreach ( $output['shop_recommended_product_array'] as $key => $list ) { ?>
								<td valign="top" class="tr-imgs">
									<?php if ( $output['ifhtml'] == '1' && $list['html_url'] != '' ) { ?>
										<div style="float:left; width:80px">
                                        <a href="<?php echo $list['html_url']; ?>" target="_blank" style="float:left; display:inline; margin:0 10px;"><img src="<?php echo empty( $list['small_pic'] ) ? TPL_DIR . "/images/noimgs.gif" : '../' . $list['small_pic']; ?>" style="border:1px solid #CCC; padding:3px;" /></a>
                                        <ul style="width:78px; display:block; padding:7px 0 10px; margin-left:3px; clear:both;" class="depot-ul depot-ul-li-2">		
											<li class="p-left-100"><span class="span-button"><input type="button" value="<?php echo $lang['langShopPCancelCommend']; ?>" name="cancel_recommended" onclick="location.href='own_shopproduct.php?action=cancel_recommended&chboxPid=<?php echo $list['p_code']; ?>'"></span></li>
									 	</ul>
                                        </div>
										<div style="float:left; display:inline; width:100px; text-align:left;">
										<a href="<?php echo $list['html_url']; ?>" target="_blank" style=" color:#FF9900;"><?php echo $list['p_name']; ?></a><br />
										
										<span style="color:#404040; display:block; font-weight:bold; padding:5px 0;"><?php echo $list['p_price']; ?></span>
										
										  	</div>									
									<?php } else { ?>
										<div style="float:left; width:80px">
                                        <a href="<?php echo $list['product_url']; ?>" target="_blank" style="float:left; display:inline; margin:0 10px;"><img src="<?php echo empty( $list['small_pic'] ) ? TPL_DIR . "/images/noimgs.gif" : '../' . $list['small_pic']; ?>"  style="border:1px solid #CCC; padding:3px;" /></a>
                                        <ul style="width:78px; display:block; padding:7px 0 10px; margin-left:3px; clear:both;" class="depot-ul depot-ul-li-2">	
											<li><span class="span-button"><input type="button" value="<?php echo $lang['langShopPCancelCommend']; ?>" name="cancel_recommended" onclick="location.href='own_shopproduct.php?action=cancel_recommended&chboxPid=<?php echo $list['p_code']; ?>'"></span></li>
									 	</ul>
                                        </div>
										<div style="float:left; display:inline; width:100px; text-align:left;">
										<a href="<?php echo $list['product_url']; ?>" target="_blank" style=" color:#FF9900; "><?php echo $list['p_name']; ?></a>
										
										<span style="color:#404040; display:block; font-weight:bold; padding:5px 0;"><?php echo $list['p_price']; ?></span>
										
										 </div>								
									<?php } ?>
								</td>
								<?php if ( ($key+1) % 4 == 0 ) { ?>
									</tr>
									<tr>
								<?php } ?>
							<?php } ?>
							</tr>
						<?php } else { ?>
							<tr class="tr-not">
								<td colspan="4">
									<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
								</td>
							</tr>
						<?php } ?>
					</table>
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-3"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-5"><?php echo $lang['langShopPCommend']; ?></td>
							<td class="td-bg-8"><?php echo $lang['langShopPBabyName'];?></td>
							<td class="td-bg-3"><?php echo $lang['langProductMNum']; ?></td>
							<td class="td-bg-3"><?php echo $lang['langProductAddTime']; ?></td>
							<td class="td-bg-7"><?php echo $lang['langShopPPrice'];?></td>
						</tr>
						<?php if( !empty($output['shop_product_array']) && is_array($output['shop_product_array']) ){ ?>
							<?php foreach($output['shop_product_array'] as $list ){ ?>
								<tr class="tr-un-conter-1">
									<td><input type="checkbox" value="<?php echo $list['p_code']; ?>" name="chboxPid[]"></td>
									<td>
										<?php
											if ( $list['p_store_recommended'] == '1' ) {
												echo $lang['langShopPMayCommend'];
											} else {
												echo $lang['langShopPMayCommendNo'];
											}
										?>
									</td>
									<td class="tr-imgs">
										<?php if ( $list['ifhtml'] == '1' && $list['html_url'] != '' ) { ?>
											<span class="depott-span-1">
												<a href="<?php echo $list['html_url']; ?>" target="_blank">
													<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $list['p_pic'] ) ? $list['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $list['p_name']; ?>" title="<?php echo $list['p_name']; ?>"/>
												</a>										
											</span>
											<span class="depott-span-3">
												<p><a href="<?php echo $list['html_url']; ?>" target="_blank"><?php echo $list['p_name'];?></a></p>
												<p class="depott-p-2">(<?php echo $list['p_sell_type_name'];?>)</p>
												<?php if ( $list['p_recommended'] == '1' ) { ?>
													<p style="color:#FF0000;"><?php echo $lang['langCCommend']; ?></p>
												<?php } ?>
											</span>									
										<?php } else {?>
											<span class="depott-span-1">
												<a href="<?php echo $list['product_url']; ?>" target="_blank">
													<img src="<?php echo SITE_URL; ?>/<?php echo !empty( $list['p_pic'] ) ? $list['p_pic'] : 'templates/member/images/noimgs.gif'; ?>" alt="<?php echo $list['p_name']; ?>" title="<?php echo $list['p_name']; ?>"/>
												</a>										
											</span>
											<span class="depott-span-3">
												<p><a href="<?php echo $list['product_url']; ?>" target="_blank"><?php echo $list['p_name'];?></a></p>
												<p class="depott-p-2">(<?php echo $list['p_sell_type_name'];?>)</p>
												<?php if ( $list['p_recommended'] == '1' ) { ?>
													<p style="color:#FF0000;"><?php echo $lang['langCCommend']; ?></p>
												<?php } ?>
											</span>								
										<?php } ?>									
									
									</td>
									<td><?php echo $list['p_storage'];?></td>
									<td><?php echo $list['p_add_time_ymd'];?></td>
									<td><?php echo $list['p_price']; ?></td>
								</tr>
							<?php } ?>						
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="6">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
					<div class="handle">
						<ul class="depot-ul depot-ul-li-2">		
							<!-- 全选/反选 -->
							<li class="depot-li-te"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?></a></li>
							<li><span class="span-button"><input type="submit" name="recommended" class="new_anniu"  value="<?php echo $lang['langShopCommend']; ?>" /></span></li>
					 	</ul>  
					</div>									
				</div>
				<?php if(!empty($output['shop_product_array']) && is_array($output['shop_product_array'])){ ?>
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