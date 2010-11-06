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
		alert("<?php echo $lang['langShopPSelectMoveProduct']?>");
	}
	return false;
	
}
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langShopPManageInfo']; ?> <a class="fzhi" href="own_shopproduct.php?action=list&classid=0"><span><?php echo $lang['langShopPLookNotBobyClass']; ?></span></a></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo empty( $output['class_name'] ) ? $lang['langShopPNotBobyClass'] : $output['class_name'];?></p></span></li>
					</ul>
				</div><form action="own_shopproduct.php?action=move" name="form1" id="form1" method="post" onsubmit="return check();">
				<div class="z-mai-unite">
					
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-12"><?php echo $lang['langShopPSelect'];?></td>
							<td class="td-bg-8"></td>
							<td class="td-bg-8"><?php echo $lang['langShopPBabyName'];?></td>
							<td class="td-bg-7"><?php if ( $output['classid'] != '0' ) { ?><?php echo $lang['langShopPManageBaby'];?><?php } ?></td>
						</tr>
						<?php if( !empty($output['shop_product_array']) && is_array($output['shop_product_array']) ){ ?>
							<?php foreach($output['shop_product_array'] as $list ){ ?>
								<tr class="tr-un-conter-1">
									<td><input type="checkbox" value="<?php echo $list['p_code']; ?>" name="chboxPid[]"></td>
									<td>
										<?php if ( $output['ifhtml'] == '1' && $list['html_url'] != '' ) { ?>
				  							<a target="_blank" href="<?php echo $list['html_url']; ?>">
										<?php } else { ?>		
				  							<a target="_blank" href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['p_code']; ?>">															
										<?php } ?>
										<img src="<?php echo empty( $list['small_pic'] ) ? TPL_DIR . "/images/noimgs.gif" : '../' . $list['small_pic']; ?>" alt="<?php echo $output['goods']['p_name']; ?>" border="0" /></a>
									</td>
									<td>
										<?php if ( $output['ifhtml'] == '1' && $list['html_url'] != '' ) { ?>
				  							<a target="_blank" href="<?php echo $list['html_url']; ?>">
										<?php } else { ?>		
				  							<a target="_blank" href="<?php echo SITE_URL; ?>/home/product.php?action=view&pid=<?php echo $list['p_code']; ?>">															
										<?php } ?>
										<?php echo $list['p_name']; ?></a>
										<?php echo $list['p_price']; ?>								
									</td>
									<td>
										<?php if ( $output['classid'] != '0' ) { ?>
											<a href="javascript:;" onclick="if(confirm('<?php echo $lang['langShopPConfirmOperator']; ?>')){location.href='own_shopproduct.php?action=move&chboxPid=<?php echo $list['p_code']; ?>';}else{return false;}"><?php echo $lang['langShopPMoveOut']; ?></a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>						
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="4">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="page">
					<?php if(!empty($output['shop_product_array']) && is_array($output['shop_product_array'])){ ?>
						<div style=" float:left; margin:5px 0 0 5px;">
							<?php echo $lang['langShopPMoveBabyToClass']; ?>:
							<select name="shoppcid" id="shoppcid">
								<?php if ( is_array( $output['shop_product_category_array'] ) ) { ?>
									<?php foreach ( $output['shop_product_category_array'] as $list ) { ?>
										<option <?php if ( $list['class_id'] == $output['classid'] ) { ?> selected <?php } ?> value="<?php echo $list['class_id']; ?>"><?php echo $list['class_name']; ?></option>
										<?php if ( is_array( $list['child'] ) ) { ?>
											<?php foreach ( $list['child']  as $list_child ) { ?>
												<option <?php if ( $list_child['class_id'] == $output['classid'] ) { ?> selected <?php } ?>  value="<?php echo $list_child['class_id']; ?>">&nbsp;&nbsp;<?php echo $list_child['class_name']; ?></option>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</select>
	        	  			<input type="submit" name="submit"  value="<?php echo $lang['langShopPMove']; ?>" class="new_anniu" >
				  			<input type="button" name="button" value="<?php echo $lang['langCReturn']; ?>" onclick="location.href='own_shopproductcate.php'" />						
						</div>
						<div class="pd-ck-right">
							<?php echo $output['page_list']; ?>
						</div>	
					<?php } ?>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>