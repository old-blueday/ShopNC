<?php 
if ( file_exists( BasePath . "/js/validate/member_productcategory.manage.html" ) ) {
	include_once( BasePath . "/js/validate/member_productcategory.manage.html" );
}
?>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1">
					<p><?php echo $lang['langShopPClassManageInfo']; ?>  <span><a href="own_shopproduct.php?action=list&classid=0"><?php echo $lang['langShopPLookNotBobyClass']; ?></a></span></p>
				</div>
				<div class="bg-sj"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopPBobyClass']; ?></p></span></li>
					</ul>
				</div>
				<div class="baby-1">
					<ul>
						<li class="by-1"><?php echo $lang['langShopPClassName']; ?></p></li>
						<li class="by-2"><?php echo $lang['langShopProCateParentClass']; ?></li>
						<li class="by-3"><?php echo $lang['langShopProCateAddPic']; ?></li>
						<li class="by-4"><?php echo $lang['langShopProCateAddChild']; ?></li>
						<li class="by-5"><?php echo $lang['langShopProCateOpen']; ?></li>
						<li class="by-6"><?php echo $lang['langCChangeOrder']; ?></li>
						<li class="by-7"><?php echo $lang['langShopProCateDel']; ?></li>
						<li class="by-8"><?php echo $lang['langShopPSeeProduct']; ?></li>
					</ul>
				</div>
				<form name="form_modi_category" id="form_modi_category" method="post" action="own_shopproductcate.php?action=update">
				<div style="float:left; width:100%; margin-top:2px;*margin-top:-3px; clear:both;"><div class="an-3"><span class="buttom-comm-1"><input type="submit" class="input-a" value="<?php echo $lang['langShopProCateSave']; ?>" /></span></div></div>
				<div class="baby-ct">
					
					<?php if ( !empty( $output['shop_product_category_array'] ) && is_array( $output['shop_product_category_array'] ) ) { ?>
						<?php foreach ( $output['shop_product_category_array'] as $list ) { ?>
							<input name="class_id[<?php echo $list['class_id']; ?>]" type="hidden" value="<?php echo $list['class_id']; ?>" />
							<dl>
								<dd class="by-1"><p><input class="dd-1" name="txtCategory[<?php echo $list['class_id']; ?>]" type="text" maxlength="80" value="<?php echo $list['class_name']; ?>" /></p></dd>
								<dd class="by-2">
									<p>
										<select name="class_parent_id[<?php echo $list['class_id']; ?>]">
											<option value="0"><?php echo $lang['langShopProCateRootClass']; ?></option>
											<?php if ( is_array( $output['sel_class'] ) ) { ?>
												<?php foreach ( $output['sel_class'] as $list_sel ) { ?>
													<?php if ( $list['class_id'] != $list_sel['class_id'] ) { ?>
														<option value="<?php echo $list_sel['class_id']; ?>"><?php echo $list_sel['class_name']; ?></option>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</select>
									</p>
								</dd>
								<dd class="by-3">
									<p>
										<input class="dd-2" name="class_pic[<?php echo $list['class_id']; ?>]" type="text" value="<?php echo empty($list['class_pic']) ? 'http://' : $list['class_pic']; ?>" />
										<?php if ( $list['class_pic'] != '' and $list['class_pic'] != 'http://' ) { ?>
											<a title="<?php echo $lang['langShopProCateViewPic']; ?>" href="<?php echo $list['class_pic']; ?>" target="_blank"><img src="<?php echo TPL_DIR; ?>/images/see1.gif" alt="<?php echo $lang['langShopProCateViewPic']; ?>" title="<?php echo $lang['langShopProCateViewPic']; ?>" /></a>
										<?php } ?>
									</p>
								</dd>
								<dd class="by-4">
									<p>
										<?php if ( $list['class_parent_id'] == '0' ) { ?>
											<a href="javascript:;" onclick="$('#class_parent_id').attr('value','<?php echo $list['class_id']; ?>');$('#txtCategory').focus();"><img src="<?php echo TPL_DIR; ?>/images/list-add.gif" /></a>
										<?php } ?>
									</p>
								</dd>
								<dd class="by-5">
									<p>
										<?php if ( $list['class_parent_id'] == '0' ) { ?>
											<input name="class_if_open[<?php echo $list['class_id']; ?>]" <?php if ( $list['class_if_open'] == '0' ) { ?> checked <?php } ?> type="checkbox" value="0" title="<?php echo $lang['langShopProCateOpen']; ?>" />
										<?php } ?>
									</p>
								</dd>
								<dd class="by-6"><p><input class="dd-3" name="txtSort[<?php echo $list['class_id']; ?>]" type="text" value="<?php echo $list['class_sort']; ?>" size="5" maxlength="5" /></p></dd>
								<dd class="by-7"><p><img src="<?php echo TPL_DIR; ?>/images/list-del.gif" style="cursor:pointer;" alt="<?php echo $lang['langCdele']; ?>" title="<?php echo $lang['langCdele']; ?>" onclick="javascript:if(confirm('<?php echo $lang['langShopProCateConfirmDel']; ?>')){location.href='own_shopproductcate.php?action=del&classid=<?php echo $list['class_id']; ?>';}else{return false;}" /></p></dd>
								<dd class="by-8"><p><a href="own_shopproduct.php?action=list&classid=<?php echo $list['class_id']; ?>" target="_blank"><img src="<?php echo TPL_DIR; ?>/images/list-ck.gif" alt="<?php echo $lang['langShopProCateViewPic']; ?>" title="<?php echo $lang['langShopProCateViewPic']; ?>"  /></a></p></dd>
								</dl>	
								<?php if ( is_array( $list['child'] ) ) { ?>
									<dl>
									<?php foreach ( $list['child'] as $list_child ) { ?>
										<input name="class_id[<?php echo $list_child['class_id']; ?>]" type="hidden" value="<?php echo $list_child['class_id']; ?>" />
										<dd class="by-1"><p class="zilei"><input class="dd-1" name="txtCategory[<?php echo $list_child['class_id']; ?>]" type="text" maxlength="80" value="<?php echo $list_child['class_name']; ?>" /></p></dd>
										<dd class="by-2">
											<p>
												<select name="class_parent_id[<?php echo $list_child['class_id']; ?>]">
													<option value="0"><?php echo $lang['langShopProCateRootClass']; ?></option>
													<?php if ( is_array( $output['sel_class'] ) ) { ?>
														<?php foreach ( $output['sel_class'] as $list_sel ) { ?>
															<option <?php if ( $list_child['class_parent_id'] == $list_sel['class_id'] ) { ?> selected <?php } ?> value="<?php echo $list_sel['class_id']; ?>"><?php echo $list_sel['class_name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select>
											</p>
										</dd>
										<dd class="by-3">
											<p>
												<input class="dd-2" name="class_pic[<?php echo $list_child['class_id']; ?>]" type="text" value="<?php echo $list_child['class_pic'] != '' ? $list_child['class_pic'] : 'http://' ; ?>" />
												<?php if ( $list_child['class_pic'] != '' and $list_child['class_pic'] != "http://" ) { ?>
													<a title="<?php echo $lang['langShopProCateViewPic']; ?>" href="<?php echo $list_child['class_pic']; ?>" target="_blank"><img src="<?php echo TPL_DIR; ?>/images/see1.gif" alt="<?php echo $lang['langShopProCateViewPic']; ?>" title="<?php echo $lang['langShopProCateViewPic']; ?>" /></a>
												<?php } ?>
											</p>
										</dd>	
										<dd class="by-4"><p></p></dd>																													
										<dd class="by-5"><p></p></dd>	
										<dd class="by-6"><p><input class="dd-3" name="txtSort[<?php echo $list_child['class_id']; ?>]" type="text" value="<?php echo $list_child['class_sort']; ?>" size="5" maxlength="5" /></p></dd>																												
										<dd class="by-7"><p><img src="<?php echo TPL_DIR; ?>/images/list-del.gif" style="cursor:pointer;" alt="<?php echo $lang['langCdele']; ?>" title="<?php echo $lang['langCdele']; ?>" onclick="javascript:if(confirm('<?php echo $lang['langShopProCateConfirmDel']; ?>')){location.href='own_shopproductcate.php?action=del&classid=<?php echo $list_child['class_id']; ?>';}else{return false;}" /></p></dd>
										<dd class="by-8"><p><a href="own_shopproduct.php?action=list&classid=<?php echo $list_child['class_id']; ?>" target="_blank"><img src="<?php echo TPL_DIR; ?>/images/list-ck.gif" alt="<?php echo $lang['langShopProCateViewPic']; ?>" title="<?php echo $lang['langShopProCateViewPic']; ?>"  /></a></p></dd>
									<?php } ?>
									</dl>
								<?php } ?>
						<?php } ?>	
						
					<?php } else { ?>
						<div style=" width:100%; text-align:center; line-height:25px; border-bottom:#deebfb 1px solid; border-right:#deebfb 1px solid; clear:both; line-height:20px;"><?php echo $lang['langShopProCateNothing']; ?></div>
					<?php } ?>
				</div>
				<div style="float:left; width:100%; clear:both; margin-top:5px;"><div class="an-3"><span class="buttom-comm-1"><input type="submit" class="input-a" value="<?php echo $lang['langShopProCateSave']; ?>" /></span></div></div>
				</form>
				<form action="own_shopproductcate.php?action=save" method="post" name="formaddcategory" id="formaddcategory">
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopProCateAdd']; ?></p></span></li>
					</ul>
				</div>
				<div class="baby-1">
					<ul>
						<li class="by-1"><?php echo $lang['langShopPNewClassName']; ?></p></li>
						<li class="by-2"><?php echo $lang['langShopProCateParentClass']; ?></li>
						<li class="by-3"><?php echo $lang['langShopProCatePic']; ?></li>
						<li class="by-4"><?php echo $lang['langCSort']; ?></li>
					</ul>
				</div>		
				<div class="baby-ct">
					<dl>
						<dd class="by-1">
			      			<p><input name="txtCategory" type="text" id="txtCategory" maxlength="80" class="dd-1" /></p>
							<label style="display:none" for="txtCategory" class="wrong" metaDone="true" generated="true"></label>						
						</dd>
						<dd class="by-2">
							<p>
								<select name="class_parent_id" id="class_parent_id">
									<option value="0"><?php echo $lang['langShopProCateRootClass']; ?></option>
								<?php if ( is_array( $output['sel_class'] ) ) { ?>
									<?php foreach ( $output['sel_class'] as $list ) { ?>
										<option value="<?php echo $list['class_id']; ?>"><?php echo $list['class_name']; ?></option>
									<?php } ?>
								<?php } ?>		
								</select>	
							</p>	
						</dd>
						<dd class="by-3"><p><input name="class_pic" type="text" id="class_pic" maxlength="80" class="dd-1" value="http://" /></p></dd>						
						<dd class="by-9">
							<p><input name="txtSort" type="text" id="txtSort" value="0" size="5" maxlength="5" class="dd-1" /></p>
		  					<label style="display:none" for="txtSort" class="wrong" metaDone="true" generated="true"></label>
		  				</dd>						
					</dl>
				</div>
				<div style="float:left; width:100%; margin-top:5px; clear:both;"><div class="an-3"><span class="buttom-comm-1"><input class="input-a" type="submit" name="" value="<?php echo $lang['langShopPAddClass']; ?>" /></span></div></div>		
				</form>
			</div>
		</div>
	</div>
</div>