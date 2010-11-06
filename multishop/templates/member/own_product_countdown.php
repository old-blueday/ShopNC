<link href="<?php echo SITE_URL; ?>/js/jquery/ui.theme.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/jquery/ui.datepicker.js"></script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langPProductCountdownAdd']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="cr-right">
				<div id="error_predeposit" style="color:red; width:732px; background:#FFFFE6; padding:8px; line-height:22px; border:1px solid #F90; display:none; margin:8px 0;"><?php echo $lang['langPMemberExa']; ?><span id="available_predeposit"></span><br/><?php echo $lang['langPMemberExb']; ?><a href="javascript:void(0);" name="blockUi" id="blockUi"><?php echo $lang['langPMemberExc']; ?></a><?php echo $lang['langPMemberExd']; ?></div>
				<form action="own_product_countdown.php?action=<?php if($output['product_array']['p_code'] == ''){ ?>save<?php }else{ ?>update<?php } ?>" enctype="multipart/form-data" method="post" onsubmit="updatapic()" name="ownaddproduct"  id="ownaddproduct">
					<input type="hidden" name="p_sell_type" value="3" />
					<input type="hidden" name="pc_id" id="pc_id" value="<?php echo $output['pc_id']; ?>" />
					<input type="hidden" name="p_id" value="<?php echo $output['product_array']['p_id']; ?>" />
					<input type="hidden" name="p_code" value="<?php echo $output['product_array']['p_code']; ?>" />
					<input type="hidden" name="p_old_price" value="<?php echo $output['product_countdown_array']['cp_price']; ?>" />
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-11"><?php echo $lang['langSelltype'];?>:</td>
							<td class="cr-2" style="width:200px;"><?php echo $lang['langPProductCountdown'];?></td>
							<td class="cr-11-1"><?php echo $lang['langProductAType'];?>:</td>
							<td class="cr-2">
							<input type="radio" name="p_type" id="p_type" value="0" <?php if($output['product_array']['p_type'] == '0' || $output['product_array']['p_type'] == ''){?>checked="checked"<?php } ?> /><label for="radioType1"><?php echo $lang['langProductTypeNew'];?></label>
								<input type="radio" name="p_type" id="p_type" value="1" <?php if($output['product_array']['p_type'] == '1'){?>checked="checked"<?php } ?> /><label for="radioType2"><?php echo $lang['langProductTypeSec'];?></label>
								<input type="radio" value="2" name="p_type" id="p_type" <?php if($output['product_array']['p_type'] == '2'){?>checked="checked"<?php } ?> /><label for="radioType3"><?php echo $lang['langProductTypePlace'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductCate'];?>:</td>
							<td class="cr-2" colspan="3">
								<?php if ($output['product_array']['p_code'] != '') { ?>
									<span id="text_pclass"><?php echo $output['select_pclass']; ?> <a href="javascript:void(0);" onclick="show_edit_pclass()"><?php echo $lang['langPModiCategory']; ?></a></span>
									<span id="edit_pclass" style="display:none;">
										<a href="javascript:void(0);" onclick="hide_edit_pclass()"><?php echo $lang['langPModiCancel']; ?></a>
										<select name="pc_c1" id="pc_c1" class="wd">
											<option value=""></option>
											<?php if(!empty($output['ProductCateArray']) && is_array($output['ProductCateArray'])){ ?>
											<?php foreach($output['ProductCateArray'] as $k => $v){ ?>
												<option value="<?php echo $v['id'];?>||<?php echo $v[5];?>" <?php if($v['id'] == $output['sel_pc'][0]['pc_id']){ ?>selected<?php } ?> ><?php echo $v['name'];?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<select name="pc_c2" id="pc_c2" class="wd">
											<?php if($output['sel_pc'][1]['pc_name'] != ''){ ?>
												<option value=""><?php echo	$output['sel_pc'][1]['pc_name'];?></option>
											<?php } ?>
										</select>
										<select name="pc_c3" id="pc_c3" class="wd">
											<?php if($output['sel_pc'][2]['pc_name'] != ''){ ?>
												<option value=""><?php echo	$output['sel_pc'][2]['pc_name'];?></option>
											<?php } ?>
										</select>
										<select name="pc_c4" id="pc_c4" class="wd">
											<?php if($output['sel_pc'][3]['pc_name'] != ''){ ?>
												<option value=""><?php echo	$output['sel_pc'][3]['pc_name'];?></option>
											<?php } ?>
										</select>										
									</span>
								<?php } else { ?>
									&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['select_pclass']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="own_product.php?action=sell"><?php echo $lang['langProductSelectClass']; ?></a>
								<?php }?>					
							</td>
						</tr>
						<?php 
							/**
							 * 店铺商品分类
							 */
								if(!empty($output['shop_product_cate_array']) && is_array($output['shop_product_cate_array'])){
						?>
						<tr>
							<td class="cr-11"><?php echo $lang['langPShopClassSelect'];?>:</td>
							<td class="cr-2" colspan="3">
								<select name="p_class_id" id="txtPclassid" class="wd">
									<option value="0"><?php echo $lang['langPPleaseSelect'];?></option>
									<?php foreach($output['shop_product_cate_array'] as $k => $v){?>
										<option value="<?php echo $v['class_id'];?>" <?php if($output['product_array']['p_class_id'] == $v['class_id']){ ?>selected<?php } ?>><?php echo $v['class_name'];?></option>
										<?php if(!empty($v['child']) && is_array($v['child'])){?>
										<?php foreach($v['child'] as $k2 => $v2){?>
											<option value="<?php echo $v2['class_id'];?>" <?php if($output['product_array']['p_class_id'] == $v['class_id']){ ?>selected<?php } ?>>&nbsp;&nbsp;<?php echo $v2['class_name'];?></option>
										<?php }?>
										<?php }?>
									<?php }?>
								</select>
							</td>
						</tr>
						<?php } ?>
						<!-- 属性 -->
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAttribute'];?>:</td>
							<td class="cr-2" colspan="3" id="td_attribute">
								<?php if(!empty($output['product_attribute']) && is_array($output['product_attribute'])){?>
								<?php foreach($output['product_attribute'] as $k => $v){ ?>
									<span class="td_attribute_span"><?php echo $v['a_name'];?>:
									<?php if($v['a_type'] == '0'){ ?>
										<select class="wd" name="attribute_content[]" style="display:inline;float:none;">
											<option value=""></option>
											<?php if(!empty($v['content']) && is_array($v['content'])){?>
											<?php foreach($v['content'] as $k2 => $v2){ ?>
												<option value="<?php echo $v2['ac_id'];?>|<?php echo $v2['a_id'];?>" <?php if($v2['ischecked'] == '1'){ ?>selected="selected"<?php }?>><?php echo $v2['ac_content'];?></option>
											<?php }?>
											<?php }?>
										</select><br />
									<?php }?>
									<?php if($v['a_type'] == '1'){ ?>
										<?php if(!empty($v['content']) && is_array($v['content'])){?>
										<?php foreach($v['content'] as $k2 => $v2){ ?>
											<input style="display:inline;float:none;" name="attribute_content[]" type="checkbox" value="<?php echo $v2['ac_id'];?>|<?php echo $v2['a_id'];?>" <?php if($v2['ischecked'] == '1'){ ?>checked<?php }?>><?php echo $v2['ac_content'];?>
										<?php }?>
										<?php }?>
									<?php }?>
									<br style="line-height:5px;" />
								<?php }?>
								<?php }else{ ?>
									<?php echo $lang['langProductClassHaveNotAttribute'];?>
								<?php }?>
							</td>
						</tr>
						<?php
							/**
							 * 品牌
							 */
							if(!empty($output['brand_list'])){ 
						?>
						<tr>
							<td class="cr-11"><?php echo $lang['langPBrand'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="hidden" name="p_pb_id" id="brand_id" value="<?php echo $output['product_array']['p_pb_id'];?>"/>
								<select class="wd" id="brand_c1" name="brand_c1">
									<option valus="" selected></option>
									<?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){?>
									<?php foreach($output['brand_list'] as $k => $v){ ?>
										<option <?php if($output['sel_brand'][0]['pb_id'] == $v['pb_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['pb_id']; ?>||<?php echo $v['is_parent']; ?>"><?php echo $v['pb_name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
								<select class="wd" id="brand_c2" name="brand_c2">
									<option valus="<?php echo $output['sel_brand'][1]['pb_id']; ?>" selected><?php echo $output['sel_brand'][1]['pb_name']; ?></option>
								</select>
								<select class="wd" id="brand_c3" name="brand_c3">
									<option valus="<?php echo $output['sel_brand'][2]['pb_id']; ?>" selected><?php echo $output['sel_brand'][2]['pb_name']; ?></option>
								</select>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductName'];?>:</td>
							<td class="cr-2" colspan="3"><input type="text" id="p_name" name="p_name" class="in-2" value="<?php echo $output['product_array']['p_name'];?>" /></td>
						</tr>
					</table>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-11"><?php echo $lang['langProductStorage'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="text" class="in" value="1" disabled />
								<input type="hidden" name="p_storage" id="txtPstorage" value="1" />
								<span class="p-span-5" style=" float:left; clear: both; width:100%;"><?php echo $lang['langPIsAuction']; ?><a href=""><?php echo $lang['langPAddAuction']; ?></a> </span>
							</td>
						</tr>					
						<tr>
							<td class="cr-11"><?php echo $lang['langProductABeginPrice'];?>:</td>
							<td class="cr-2">
								<input type="text" id="cp_price" class="in" name="cp_price" value="<?php echo $output['product_countdown_array']['cp_price']; ?>" onkeyup="price_to_exchange(this.value);" onblur="check_predeposit();" />
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAPriceAddScope'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="radio" name="cp_system_step" value="1" id="inc1" onclick="$('#price_step').attr('readonly',true).attr('disabled',true);$('#price_step').val('1');" <?php if ($output['product_countdown_array']['cp_system_step'] == '' || $output['product_countdown_array']['cp_system_step'] == '1') { ?> checked <?php } ?> />
								<label for="inc1"><?php echo $lang['langProductASystemAuto'];?>&nbsp;<a href="../home/up_price.php" target="_blank"><?php echo $lang['langPViewUpPrice'];?></a></label>
								<br />
								<br />
								<input type="radio"  name="cp_system_step" value="0" id="inc2" onclick="$('#price_step').attr('readonly',false).attr('disabled',false);" <?php if ($output['product_countdown_array']['cp_system_step'] == '0') { ?> checked <?php } ?> />
								<label for="inc2"><?php echo $lang['langProductAUserDefined'];?></label>
								<input name="cp_price_step" value="<?php echo $output['product_countdown_array']['cp_price_step']; ?>" id="price_step" class="in">
								<span class="p-span-5"><?php echo $lang['langProductACommendYouSelect'];?><?php echo $lang['langProductASystemAutoAddPrice'];?></span>
								<script type="text/javascript">
									if (document.getElementById('inc1').checked) {
										document.getElementById('price_step').disabled=true;
										document.getElementById('price_step').className='disabled';
										document.getElementById('price_step').value = 1;
									}
								</script>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPStartTime']; ?>:</td>
							<td class="cr-2">
							  <div class="timeSelectStyle"><span><label for="cp_start_time1"><input type="radio" name="cp_start_time" id="cp_start_time1" value="1" <?php if ($output['product_array']['p_code'] == '') {?> checked <?php } ?> /> <?php echo $lang['langPTimeNow']; ?></label></span></div>
								<div class="timeSelectStyle"><span><label for="cp_start_time2"><input type="radio" name="cp_start_time" id="cp_start_time2" value="2" <?php if ($output['product_array']['p_code'] != '') {?> checked <?php } ?> /> <?php echo $lang['langPTimeSet']; ?></label></span>
								<input class="in" name="cp_start_ymd" id="cp_start_ymd" readonly="true" type="text" value="<?php if ($output['product_array']['p_code'] != '') { echo date("Y-m-d",$output['product_countdown_array']['cp_start_time']); } else { echo date("Y-m-d",time()); } ?>" disabled style="width:100px; margin-right:6px;"/>
								<select name="cp_start_h" id="cp_start_h" disabled style="width:50px;">
									<?php 
										for ($i = $output['starttime_h']; $i<24; $i++) {
									?>
										<option value="<?php echo $i; ?>" <?php if (date("G",$output['product_countdown_array']['cp_start_time']) == $i) {?> selected <?php }?>><?php echo $i; ?></option>
									<?php
										}
									?>								
								</select> <?php echo $lang['langPTimeh']; ?>
								<?php if ($output['product_array']['p_code'] != '') {?>
									<select name="cp_start_i" id="cp_start_i" style="width:50px;">
										<?php 
											for ($i = 5; $i<60; $i=$i+5) {
										?>
											<option value="<?php echo $i; ?>" <?php if (intval(date("i",$output['product_countdown_array']['cp_start_time'])) == $i) {?> selected <?php }?>><?php echo $i; ?></option>
										<?php
											}
										?>									
									</select> <?php echo $lang['langPTimei']; ?>									
								<?php } else { ?>	
									<select name="cp_start_i" id="cp_start_i" style="width:50px;" disabled>
										<?php 
											for ($i = $output['starttime_i']; $i<60; $i=$i+5) {
										?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php
											}
										?>									
									</select> <?php echo $lang['langPTimei']; ?>
								<?php } ?>	</div>												
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPEndTime']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="cp_end_ymd" id="cp_end_ymd" readonly="true" type="text" value="<?php if ($output['product_array']['p_code'] != '') { echo date("Y-m-d",$output['product_countdown_array']['cp_end_time']); } else { echo date("Y-m-d",time()+24*60*60); } ?>" style="width:100px; margin-right:6px;"/>
								<select name="cp_end_h" id="cp_end_h" style="width:50px;">
									<?php 
										for ($i = 0; $i<24; $i++) {
									?>
										<option value="<?php echo $i; ?>" <?php if (date("G",$output['product_countdown_array']['cp_end_time']) == $i) { ?> selected <?php }?>><?php echo $i; ?></option>
									<?php
										}
									?>								
								</select> <?php echo $lang['langPTimeh']; ?>
								<select name="cp_end_i" id="cp_end_i" style="width:50px;">
									<?php 
										for ($i = 0; $i<60; $i=$i+5) {
									?>
										<option value="<?php echo $i; ?>" <?php if (intval(date("i",$output['product_countdown_array']['cp_end_time'])) == $i) {?> selected <?php }?>><?php echo $i; ?></option>
									<?php
										}
									?>									
								</select> <?php echo $lang['langPTimei']; ?>							
							</td>
						</tr>						
					</table>
					<table width="100%" class="cr-r-td wubian"  border="0" cellpadding="0">
						<tr>
							<td class="cr-11"><?php echo $lang['langUploadPic'];?>:</td>
							<td class="cr-2" colspan="3">
							<div class="up-img"><ul>
								<?php if(!empty($output['pic_array']) && is_array($output['pic_array'])){ ?>
                                
								<?php foreach($output['pic_array'] as $k => $v){ ?>
									<li><div class="box-2"><img src="<?php echo SITE_URL;?>/<?php echo $v['small_pic'];?>" style="width:105px; height:80px" /></div><p><a name="<?php echo $v['p_pic'];?>" class="a-1" href="javascript:;" onclick="CopyToClipboard('<?php echo SITE_URL;?>/<?php echo $v['p_pic'];?>');"><?php echo $lang['langPIntoEditor']; ?></a><a class="a-2" href='javascript:;' onclick=ajaxFileDel("<?php echo $v['small_pic'];?>",this);><?php echo $lang['langbtnProductDel'];?></a></p></li>
								<?php } ?>
                                
                               
								<?php } ?>
								</ul>
								 </div>
                                <div class="clear-5"></div>
								<input type="file" name="uploadify" id="uploadify" />
								<div id="fileQueue"></div>
								<input type="hidden" value="" name="pichidden" id="pichidden" />
								<a class="a-3" href="javascript:;" onclick="jQuery('#uploadify').uploadifyUpload();"><?php echo $lang['langSgartUploadPic']; ?></a>
								<div id="div_pic_upload" style=" padding-top:3px;"></div>
								<span class="cr-5-span"><?php echo $lang['langProductPicSize'];?></span>
							</td>
						</tr>
						<script>
							var num=0;
							function pic_add_tr(){
								// 如果图片数量超过3 则返回信息，不允许添加
								if($("#pic_num").val() > 4){
									alert("<?php echo $lang['langPPicNumOne'];?>5<?php echo $lang['langPPicNumTwo'];?>");
									return false;
								}
								$('#div_pic_upload').append('<input type=\'file\' name=\'txtPpic_'+num+'\' /><br />');
								num++;
								// 图片数量+1
								$("#pic_num").val(parseInt($("#pic_num").val())+1);
							}
						</script>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductInfo'];?>:</td>
							<td class="cr-2" colspan="3">
								<?php 
									include_once('../classes/resource/editor/editor.class.php');
									$editor=new editor('p_intro');
									$editor->Value=$output['product_array']['p_intro'];
									$editor->BasePath='../classes/resource/editor';
									$editor->Height=460;
									$editor->Width=621;
									$editor->AutoSave=false;
									$editor->Create();
								?>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductPayment'];?>:</td>
							<td class="cr-2" colspan="3">
								<?php 
									/**
									 * 支付方式
									 */
									if(!empty($output['payment_array']) && is_array($output['payment_array'])){
								?>
								<?php foreach($output['payment_array'] as $k => $v){ ?>
									<input onclick="if(this.checked == true){select_cur('<?php echo $v['currency_line']?>');}else{select_no_cur('<?php echo $v['currency_line']?>','<?php echo $k;?>');}" type="checkbox" <?php if($v['check'] == '1'){ ?>checked="checked"<?php } ?> value="<?php echo $k;?>" name="txtPayment[<?php echo $k;?>]" id="txtPayment_<?php echo $k;?>" /><label for="txtPayment_<?php echo $k;?>"><?php echo $v['name'];?></label>
									<input type="hidden" name="payment_cur_<?php echo $k;?>" id="payment_cur_<?php echo $k;?>" value="<?php echo $v['currency_line']?>" />
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-11"></td>
							<td class="cr-2" colspan="3"><?php echo $lang['langPPaymentDescription'];?>:
								<?php if(!empty($output['payment_description']) && is_array($output['payment_description'])){?>
								<?php foreach($output['payment_description'] as $k => $v){ ?>
								<?php echo $v['name'];?>
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductCurrency'];?>:</td>
							<td class="cr-2" colspan="3">
								<?php if(!empty($output['exchange_array']) && is_array($output['exchange_array'])){?>
								<?php foreach($output['exchange_array'] as $k => $v){ ?>
									<input type="hidden" name="exchange_rate_<?php echo $v['exchange_name'];?>" id="exchange_rate_<?php echo $v['exchange_name'];?>" value="<?php echo $v['exchange_rate'];?>" />
									<div id="div_cur_<?php echo $v['exchange_name'];?>" style="float:left;display:<?php echo $v['display'];?>">
									<input type="checkbox" 
										<?php if(!empty($output['product_currency']) && is_array($output['product_currency'])){?>
										<?php foreach($output['product_currency'] as $k2 => $v2){ ?>
											<?php if($v2 == $v['exchange_name']){ ?>checked="checked"<?php } ?>
										<?php } ?>
										<?php } ?>
									name="currency[<?php echo $v['exchange_name'];?>]" id="currency_<?php echo $v['exchange_name'];?>" value="<?php echo $v['exchange_name'];?>" /><label for="currency_<?php echo $v['exchange_name'];?>"><?php echo $v['exchange_remark'];?>(<?php echo $v['exchange_name'];?>)</label>&nbsp;&nbsp;&nbsp;
									<div id="price_rate_<?php echo $v['exchange_name'];?>">
										<?php if($output['product_array']['p_price'] != ''){?>
											<?php if(($output['product_array']['p_price']*100)/$v['exchange_rate'] < 0.01){?>
												0.01
											<?php }else{ ?>
												<?php echo @number_format(($output['product_array']['p_price']*100)/$v['exchange_rate'],2);?>
											<?php } ?>
										<?php } ?>
									</div>
									</div>
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductArea'];?>:</td>
							<td class="cr-2" colspan="3">
                            <div id="adddiv"></div>
								<label style="display:none" for="p_area_id" class="error" metaDone="true" generated="true"></label>
								<input type="hidden" name="p_area_id" id="p_area_id" value="<?php echo $output['product_array']['p_area_id'];?>" />
								
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langTranFee'];?>:</td>
							<td class="cr-2" colspan="3">
								 <p><input name="p_transfee_charge" type="radio" id="whopsSeller"  value="0" checked />
								<label for="whopsSeller"><?php echo $lang['langSelaTranFee'];?></label> </p>
								<p><input name="p_transfee_charge" type="radio" id="whopsBuyer" disabled />
								<label for="whopsBuyer"><?php echo $lang['langProductAListBear'];?></label></p>
								<p><span class="p-span-5"><?php echo $lang['langPFreightFree']; ?></span></p>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAInvoices'];?>:</td>
							<td class="cr-2" >
								<input type=radio  value="1" name="p_have_invoices" id="radioInvoices2" <?php if($output['product_array']['p_have_invoices'] == '1'){ ?>checked<?php } ?> /><label for="radioInvoices2"><?php echo $lang['langCHave'];?></label>
								<input type="radio" value="0" name="p_have_invoices" id="radioInvoices" <?php if($output['product_array']['p_have_invoices'] == '0' || $output['product_array']['p_have_invoices'] == ''){ ?>checked<?php } ?> /><label for="radioInvoices"><?php echo $lang['langCNot'];?></label>
							</td>
							<td class="cr-11-1"><?php echo $lang['langWarranty'];?>:</td>
							<td class="cr-2">
								<input type="radio"  value="1" name="p_have_warranty" id="warrantyY" <?php if($output['product_array']['p_have_warranty'] == '1'){ ?>checked<?php } ?> /><label for="warrantyY"><?php echo $lang['langCHave'];?></label>
								<input type="radio" value="0" name="p_have_warranty" id="warrantyN" <?php if($output['product_array']['p_have_warranty'] == '0' || $output['product_array']['p_have_warranty'] == ''){ ?>checked<?php } ?> /><label for="warrantyN"><?php echo $lang['langCNot'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPattestation'];?>:</td>
							<td class="cr-2">
								<input type="checkbox" name="p_genuine" id="txtPgenuine" value="1" <?php if($output['product_array']['p_genuine'] == '1'){ ?>checked<?php } ?> /><label for="txtPgenuine"><?php echo $lang['langPgenuine'];?></label>
								<input type="checkbox" name="p_7day_return" id="txtP7day" value="1" <?php if($output['product_array']['p_7day_return'] == '1'){ ?>checked<?php } ?> /><label for="txtP7day"><?php echo $lang['langP7dayreturn'];?></label>
							</td>
							<td class="cr-11-1"><?php echo $lang['langRecommended'];?>:</td>
							<td class="cr-2">
								<input type="checkbox" value="1" name="p_recommended" id="chxRecommended" <?php if($output['product_array']['p_recommended'] == '1'){ ?>checked<?php } ?> /><label for="chxRecommended"><?php echo $lang['langCYes'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAAutoPublish'];?>:</td>
							<td class="cr-2" colspan="3">
								<span class="cr-5-span"><input type="checkbox" value="1" name="p_auto_publish" id="chxAutopublish" <?php if($output['product_array']['p_auto_publish'] == '1'){ ?>checked<?php } ?> /><font color="#000000"><?php echo $lang['langCYes'];?></font>
								<?php echo $lang['langProductASystemHelpYouAuto'];?></span></label> 
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductARemark'];?>:</td>
							<td class="cr-2" colspan="3">
								<textarea id="txtRemark" name="p_remark" rows="10" cols="38"><?php echo $output['product_array']['p_remark'];?></textarea>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPKeywords'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="text" class="in-2" name="p_keywords" value="<?php echo $output['product_array']['p_keywords'];?>" /><span class="p-span-5" style=" float:left; clear: both; width:100%;"><?php echo $lang['langPKeywordsRemark'];?></span>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPDescription'];?>:</td>
							<td class="cr-2" colspan="3">
								<textarea name="p_description" rows="10" cols="38"><?php echo $output['product_array']['p_description'];?></textarea><span class="p-span-5"><?php echo $lang['langPDescriptionRemark'];?></span>
							</td>
						</tr>
					</table>
					<div class="an-1">
						<span class="buttom-comm">
						<input type="hidden" name="p_pic" id="p_pic" />
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
						</span>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="recharge_loading" style=" display:none; background:#FFF; padding:24px; width:450px;">
	<table>
		<tr>
			<td height="32" colspan="2"><?php echo $lang['langPMemberExe']; ?><a href="http://www.shopnc.net/forum/" target="_blank" onclick="$.unblockUI();" style="color:#F60;"><?php echo $lang['langPMemberExf']; ?></a></td>
		</tr>
		<tr>
			<td height="32"><input type="button" value="<?php echo $lang['langPMemberExg']; ?>" id="yes" /></td>
			<td height="32"><input type="button" value="<?php echo $lang['langPMemberExh']; ?>" id="colse" /></td>
		</tr>
	</table>
</div>
<link type="text/css"  href="<?php echo TPL_DIR;?>/css/uploadify.css" rel="stylesheet" />
<script type="text/javascript" src="../js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="../js/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo SITE_URL; ?>/js/jquery1.4/jquery.blockUI.js"></script>
<script src="<?php echo SITE_URL; ?>/js/addselect.js"></script>
<script language="javascript" type="text/javascript">
function updatapic()
{
	$("#p_pic").val($(".up-img").children("ul").children("li:first").children("p").children("a:first").attr('name'));
}
function CopyToClipboard(imgpath)
{
	var editor = window.frames['editor_iframe'].EDiaryEditor;
	var oRTE = editor.iframe.contentWindow;
	alert
	var html = "<img src='" + imgpath + "'>";
	if(window.isIE) {
		try{
			oRTE.focus();
			var oRng = oRTE.document.selection.createRange();
			oRng.pasteHTML(html);
			oRng.collapse(false);
			oRng.select();
		}
		catch(e){}
	}
	else {
		oRTE.focus();
		oRTE.document.execCommand('InsertImage', false, imgpath);
		oRTE.focus();
	}
		
	
  /* if(window.clipboardData) {        
              window.clipboardData.clearData();        
              window.clipboardData.setData("Text", txt);        
      } else if(navigator.userAgent.indexOf("Opera") != -1) {        
           window.location = txt;        
      } else if (window.netscape) {        
          try {        
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");        
           } catch (e) {
                alert("<?php echo $lang['errPCopyFail'];?>");
           }        
          var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);        
          if (!clip)        
               return;        
          var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);        
          if (!trans)        
              return;        
           trans.addDataFlavor('text/unicode');        
          var str = new Object();        
          var len = new Object();        
          var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);        
          var copytext = txt;        
           str.data = copytext;        
           trans.setTransferData("text/unicode",str,copytext.length*2);        
          var clipid = Components.interfaces.nsIClipboard;        
          if (!clip)        
               return false;        
           clip.setData(trans,null,clipid.kGlobalClipboard);        
           alert("<?php echo $lang['langPCopySucc'];?>")        
      }*/        
}
function upfile()
{
	jQuery('#uploadify').uploadifyUpload();
}
var picobj="";

$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : '../js/uploadify/uploadify.swf',
		'script'         : 'own_product_countdown.php?action=pic_ajax&PHPSESSID=<?php echo $output['PHPSESSID'];?>',
		'scriptData'	 :{'action':'pic_ajax','PHPSESSID':'<?php echo $output['PHPSESSID'];?>'},
		'fileDataName'   : 'fileData',
		'cancelImg'      : 'cancel.png',
		'folder'         : '../uploads',
		'queueID'        : 'fileQueue',
		'auto'           : false,
		'multi'          : true,
		'sizeLimit'      : <?php echo $output['upload_max_size']*1000;?>,
		'buttonText'	 : "select",
		'fileDesc'       : '<?php echo $lang['langPSupportFormat'];?>:<?php echo $output['upload_type'];?>', 
    	'fileExt'        : '<?php echo $output['upload_ext'];?>',
		
		'buttonImg'      : '<?php echo TPL_DIR;?>/images/zengjia.gif',
		'cancelImg'      : '<?php echo TPL_DIR;?>/images/cancel.png',
		'onComplete'     : function(e,queueId,fileObj,data){
							datas=data.split(".");
							$(".up-img").children("ul").append('<li><div class="box-2"><input type="hidden" value="'+data+'"><img src="<?php echo SITE_URL;?>/'+datas[0]+'_small.'+datas[1]+'" style="width:105px; height:80px" /></div><p><a class="a-1" name="'+data+'" href="javascript:;" onclick="CopyToClipboard(\'<?php echo SITE_URL;?>/'+data+'\');"><?php echo $lang['langPIntoEditor'];?></a><a class="a-2" href="javascript:;" onclick=\'ajaxFileDel("'+datas[0]+'_small.'+datas[1]+'",this);\'><?php echo $lang['langbtnProductDel'];?></a></p></li>');
					
						},
		'onQueueFull'	: function(e,q){
							alert("<?php echo $lang['langPPicNumOne'];?>5<?php echo $lang['langPPicNumTwo'];?>");
							return false;
						},
		'onAllComplete':function(){
							picobj="";
							$.each($(".up-img").children("ul").children("li").children("div").children("input"),function(){
								picobj+=$(this).val()+"|||";
							});
							$("#pichidden").val(picobj);
						},
		'onError':function(event,id,fileObj,errorObj){
			if(errorObj.type=="File Size")
			{
				$("#uploadify"+id).children(".percentage").html("<?php echo $lang['errPFileSizeNotBeyond'];?><?php echo $output['upload_max_size'];?>KB");
				$("#uploadify"+id).attr("class","uploadifyQueueItem uploadifyError");
				return false;
			}
		}
	});
	//选择商品所在地
	$('#adddiv').addSelect({
		ajaxUrl:'../home/tohtml.php',
		ajaxAction:'get_area',
		type:'modi',
		modi_id:'<?php echo $output['product_array']['p_area_id'];?>',
		hiddenId:'p_area_id'
	});	
	$("#ownaddproduct").validate({
		errorClass: "wrong",
		rules: {
			p_name:{required:true},
			cp_price:{required:true,digits:true,min:1},
			cp_price_step:{required:"#inc2:checked",digits:true,min:1},
			p_area_id:{required:true}
		},
		messages: {
			p_name:{required:"<?php echo $lang['langPChecka']; ?>"},
			cp_price:{required:"<?php echo $lang['langPCheckb']; ?>",digits:"<?php echo $lang['langPCheckc']; ?>",min:"<?php echo $lang['langPCheckd']; ?>"},
			cp_price_step:{required:"<?php echo $lang['langPChecke']; ?>",digits:"<?php echo $lang['langPCheckf']; ?>",min:"<?php echo $lang['langPCheckd']; ?>"},
			p_area_id:{required:"<?php echo $lang['langPCheckh']; ?>"}
		},
		submitHandler: function(form) {
			// submit button disabled
			$('#Submit').attr('disabled',true);
			var check_sign = false;// 货币选择状态标识
			var payment_check = false;// 支付方式选择状态标识
			var predeposit_check = false;// 预存款选择状态标识
			var payment_alert_sign = false;// 支付方式是否抛出错误信息标识
			
			// 判断预存款选择状态
			if($('#pay_predeposit').attr('checked') == true){
				predeposit_check = true;
			}
			// 验证支付方式的复选验证，是否全选，选中的支付方式是否选择了支付货币种类
			$("#ownaddproduct input").each(function(){
				if(this.name.indexOf('payment_cur_') == 0){
					// 判断支付方式是否被选择
					str = this.name.split('payment_cur_');// 取支付方式名称 str[1]
					if($('#txtPayment_'+str[1]).attr('checked') == true){
						// 取该支付方式的货币种类字符串
						str2 = $('#payment_cur_'+str[1]).val().split('|');
						payment_check = true;//标识有选择的支付方式
						// 判断该选中的支付方式起码有一个支持的货币种类被选择
						for(i=0;i<str2.length;i++){
							if($('#currency_'+str2[i]).attr('checked') == true){
								check_sign = true;
								break;
							}
						}
						if(check_sign == false){// 没有选择货币
							payment_alert_sign = true;
						}
					}
				}
				check_sign = false;
			});
			if (check_set_time() && check_predeposit()) {
				if(predeposit_check == true){// 选择预付款
					if(payment_alert_sign == false){// 判断是否有错误抛出:没有
						form.submit();
					}else{
						alert("<?php echo $lang['errPaymentSelCur'];?>");
						$('#Submit').attr('disabled',false);
						return false;
					}
				}else{// 没有选择预存款
					if(payment_alert_sign == false && payment_check == true){// 判断是否有错误抛出并且选择了起码一种支付方式:没有
						form.submit();
					}else{
						alert("<?php echo $lang['errPaymentSelCur'];?>");
						$('#Submit').attr('disabled',false);
						return false;
					}
				}				
			} else {
				$('#Submit').attr('disabled',false);
			}
		}
	});
	//初始化商品分类
	tonext_edit('#pc_c1');	
	//初始化地区
//	tonext('#c1');
	//初始化品牌
	tonext_brand('#brand_c1');
	$("#cp_start_time1").click(function(){
		setStartTime(true);
	});
	$("#cp_start_time2").click(function(){
		setStartTime(false);
	});
	if ($("#cp_start_time2").attr('checked')) {
		setStartTime(false);
	}
	//遮罩效果
	$("#blockUi").click(function(){
		window.open('../member/own_predeposit.php?action=pay');
		$.blockUI({ message: $('#recharge_loading'), css: {width:'500px'} });
	});
	$('#yes').click(function() {
		check_predeposit();
		$.unblockUI();
		return false;
	});
	$('#colse').click(function() {
		$.unblockUI();
	});	
	//日期控件
	$('#cp_start_ymd').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'<?php echo date("Y",time()); ?>:<?php echo date("Y",time()) + 10; ?>'		
	});	
	$('#cp_end_ymd').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'<?php echo date("Y",time()); ?>:<?php echo date("Y",time()) + 10; ?>'		
	});		
	//商品属性
	<?php if ($output['product_array']['p_code'] == '') { ?>
		show_attribute();
	<?php } ?>
	
});

// 选中支付方式的时候，显示对应的货币种类
function select_cur(str){
	if(str.indexOf('|') >= 0){
		line = str.split('|');
		for(i=0;i<line.length;i++){
			$("#div_cur_"+line[i]).css("display",'');
		}
	}else{
		$("#div_cur_"+str).css("display",'');
	}
}
// 取消支付方式的时候，隐藏对应的货币种类
function select_no_cur(str,payment_name){
	// 取该支付方式支持的货币种类str
	cur_array = str.split('|');
	for(i=0;i<cur_array.length;i++){
		// 取其他支付方式，判断是否有该种货币的信息，并且判断是否勾选，如果没有勾选，则隐藏并且取消够先该货币种类
		cur_sign = false;
		$('#ownaddproduct input').each(function(){//每种支付方式对应的货币字符
			// 判断其他的支付方式是否也存在该货币种类
			if('payment_cur_'+payment_name != this.name && this.name.indexOf('payment_cur_') >= 0){
				other_cur_array = this.value.split('|');
				payment_pro_name = this.name.replace('payment_cur_','txtPayment_');
				for(j=0;j<other_cur_array.length;j++){
					if(cur_array[i] == other_cur_array[j] && $('#'+payment_pro_name).attr('checked') == true){
						//存在
						cur_sign = true;
					}
				}
				payment_pro_name = '';
			}
		})
		// 说明其他支付方式没有该货币种类，则可以隐藏并且取消该货币的层和复选
		if(cur_sign == false){
			$("#div_cur_"+cur_array[i]).css("display",'none');
			$("#currency_"+cur_array[i]).attr("checked",false);
		}
	}
}
// 计算 单价和各货币种类换算的值
function price_to_exchange(price){
	if(price == ''){
		price = 0;
	}else{
		price = price*1;
	}
	// 取货币种类的汇率
	$('#ownaddproduct input').each(function(){
		if(this.name.indexOf('exchange_rate_') >= 0){
			var line = this.name.split('exchange_rate_');
			//alert(line[line.length-1]);
			// 在换算区域赋值 parseFloat()
			value = $("#exchange_rate_"+line[line.length-1]).val();
			one = accDiv(price,value);
			if(Math.round(one*10000)/100 < 0.01){
				$("#price_rate_"+line[line.length-1]).html(0.01);//Math.round(one*100)/100
			}else{
				$("#price_rate_"+line[line.length-1]).html(Math.round(one*10000)/100);
			}
		}
	});
}
function accDiv(arg1,arg2){
	var t1=0,t2=0,r1,r2;
	try{t1=arg1.toString().split(".")[1].length}catch(e){}
	try{t2=arg2.toString().split(".")[1].length}catch(e){}
	with(Math){
		r1=Number(arg1.toString().replace(".",""));
		r2=Number(arg2.toString().replace(".",""));
		return (r1/r2)*pow(10,t2-t1);
	}
}
// 删除图片 缩略图名称
function ajaxFileDel(pic_url,obj){
	$.ajax({
		url: "own_product.php",
		data: 'action=pic_del&pic_name='+pic_url,
		type:'post',
		dataType:"json",
		success: function(msg){
			if(msg.type == '0'){
				alert(msg.message);
			}else{
				$(obj).parents("li").remove();
				/*arr = $('#p_pic').val().split('|');
				for(i=0;i<arr.length;i++){
					if(arr[i] == pic_url){
						delete(arr[i]);
					}
				}
				$('#p_pic').val(arr.join('|'));*/
				// 图片数量-1
				
				$("#pic_num").val(parseInt($("#pic_num").val())-1);
			}
		}
	});
	return false;
}
// 品牌选择
function tonext_brand(whos) {
	$(whos).change(
		function(){
			var valarray=$(this).val().split('||');	
			$('#brand_id').val(valarray[0]);
			if (valarray[1]=='1') {
				$(this).next().attr('disabled','true').html('<option value="" selected="selected"><?php echo $lang['langCDataToLoading'];?></option>');
				$.get(
					'../home/tohtml.php',
					{action:'get_brand',id:valarray[0],random_number:Math.random()},
					function(data){
						DataArray = data.split("|||");
						var a='';
						for (var i = 0; i<DataArray.length-1; i++) {
							att=DataArray[i].split("||");
							id=att[0];
							cla=att[2];
							a+='<option value="'+id+'||'+cla+'">'+att[1]+((cla=='1')?' ->':'')+'</option>';
						}
						
					$(whos).next().removeAttr('disabled').html('<option value="'+valarray[0]+'" selected="selected"></option>'+a).nextAll().html('');
					tonext_brand($(whos).next());
					}
				)
			} else {
				$(whos).nextAll().html('').attr('disabled','true');
			};
		}
	)
};
//初始化开始时间
function setStartTime(b) {
	$("#cp_start_ymd").attr('disabled',b);	
	$("#cp_start_h").attr('disabled',b);	
	$("#cp_start_i").attr('disabled',b);	
}
//商品属性
function show_attribute(){
	var id=<?php echo $output['pc_id']; ?>;
	if(id != ''){
		$('#td_attribute').html('<img src="<?php echo TPL_DIR;?>/images/loading.gif" />');
		$.ajax({
			url: 'own_product_countdown.php?action=ajax_get_attribute&pc_id='+id,
			type:'post',
			dataType:"html",
			success: function(html){
				if(html == ''){
					$('#td_attribute').html('<?php echo $lang['langProductClassHaveNotAttribute'];?>');
				}else{
					$('#td_attribute').html(html);
				}
			},
			error :function(){
				$('#td_attribute').html('<?php echo $lang['langProductClassHaveNotAttribute'];?>');
			}
		});
	}else{
		$('#td_attribute').html('<?php echo $lang['langProductClassHaveNotAttribute'];?>');
	}
}
//检查预存款
function check_predeposit() {
	var bol = false;
	$.ajax({
		url: "own_product_countdown.php",
		data: 'action=ajax_check_predeposit&type=1&price='+$("#cp_price").val(),
		async:false,
		type:'post',
		success: function(msg){
			if (msg == 'yes') {
				$("#error_predeposit").hide();
				bol = true;
			} else {
				$("#available_predeposit").html(msg);
				$("#error_predeposit").show();
				bol = false;
			}
		}
	});	
	return bol;
}
// 商品类别
function tonext_edit(whos) {
	$(whos).change(
		function(){
			var valarray=$(this).val().split('||');
			$('#pc_id').val(valarray[0]);
			if (valarray[1]=='1') {
				$(this).next().attr('disabled','true').html('<option value="" selected="selected"><?php echo $lang['langCDataToLoading'];?></option>');
				$.get(
					'../member/own_productcate.php',
					{action:'list',id:valarray[0],random_number:Math.random()},
					function(data){
						DataArray = data.split("|||");
						var a='';
						for (var i = 0; i<DataArray.length-1; i++) 
						{
							att=DataArray[i].split("||");
							id=att[0];cla=att[2];
							a+='<option value="'+id+'||'+cla+'">'+att[1]+((cla=='1')?' ->':'')+'</option>';
						};
						$(whos).next().removeAttr('disabled').html('<option value="'+valarray[0]+'" selected="selected"></option>'+a).nextAll().html('');
						tonext_edit($(whos).next());
					}
				)
			}
			else {
				$(whos).nextAll().html('').attr('disabled','true');
				$('#cancel_edit_button').attr('disabled','');
			};	
			// 显示商品属性
			show_attribute();
	})
};
//显示编辑商品分类
function show_edit_pclass() {
	$("#text_pclass").hide();
	$("#edit_pclass").show();
}
//隐藏编辑商品分类
function hide_edit_pclass() {
	$("#text_pclass").show();
	$("#edit_pclass").hide();
}
//获取时间设置
function get_set_time(t) {
	var idDate = t == 's' ? 'cp_start_ymd' : 'cp_end_ymd';
	var idTimeH = t == 's' ? 'cp_start_h' : 'cp_end_h';
	var idTimeI = t == 's' ? 'cp_start_i' : 'cp_end_i';
	var setDate = $("#"+idDate).val();
	var setTime = $("#"+idTimeH).val() + ':' + $("#"+idTimeI).val();
	var year = setDate.substr(0,4);   
	var month = setDate.substr(5,2);   
	var day = setDate.substr(8,2);   
	var temDate = month+'/'+day+'/'+year+' '+setTime+":00";  
	return temDate;
}
//时间检查
function check_set_time() {
	if ($("#cp_start_time2").attr('checked')) {
		if (Date.parse(get_set_time()) <= Date.parse(get_set_time('s'))) {
			alert('<?php echo $output['langPtimeError']; ?>');
			return false;
		}		
	} else {
		var nowDate = '<?php echo date('Y-m-d', time()); ?>';
		var year = nowDate.substr(0,4);
		var month = nowDate.substr(5,2);;
		var day = nowDate.substr(8,2);
		var time = '<?php echo date('H:i:s'); ?>';
		var nowTime = month+'/'+day+'/'+year+' '+time
		if (Date.parse(get_set_time()) < Date.parse(nowTime)) {
			alert('<?php echo $output['langPtimeError']; ?>');
			return false;			
		}
	}
	return true;
}
</script>