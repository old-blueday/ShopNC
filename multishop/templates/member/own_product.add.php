<?php
/**
 * 对于整合X后 价格长度的修改
 */
if(DISCUZ_X === true){
	$price_maxlength = 6;
}else{
	$price_maxlength = 8;
}
/**
 * 对于整合X后 数量长度的修改
 */
if(DISCUZ_X === true){
	$storage_maxlength = 4;
}else{
	$storage_maxlength = 6;
}
?>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p>
					<?php if($output['product_array']['p_code'] != ''){ ?>
						<?php echo $lang['langProductEdit'];?>
					<?php }else{ ?>
						<?php echo $lang['langProductAdd'];?>
					<?php } ?>
					</p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="cr-right">
				<form action="own_product.php?action=<?php if($output['product_array']['p_code'] == ''){ ?>save<?php }else{ ?>update<?php } ?>" enctype="multipart/form-data" method="post" onsubmit="updatapic()" name="ownaddproduct"  id="ownaddproduct">
					<input type="hidden" name="txtPid" id="txtPid" value="<?php echo $output['product_array']['p_code'];?>"/>
					<input type="hidden" name="txtPcode" id="txtPcode" value="<?php echo $output['product_array']['p_code'];?>"/>
					<input type="hidden" name="txtPstarttime" id="txtPstarttime" value="<?php echo $output['product_array']['p_start_time'];?>"/>
					<input type="hidden" name="txtPendtime" id="txtPendtime" value="<?php echo $output['product_array']['p_end_time'];?>"/>
					<input type="hidden" name="txtPstate" id="txtPstate" value="<?php echo $output['product_array']['p_state'];?>"/>
					<input type="hidden" name="txtViewnum" id="txtViewnum" value="<?php echo $output['product_array']['p_view_num'];?>"/>
					<input type="hidden" name="pic_num" id="pic_num" value="<?php echo $output['pic_num']?$output['pic_num']:'0';?>"/>
					<!-- DISCUZ_X -->
					<input type="hidden" name="fid" value="<?php echo $output['fid'];?>" />
					<input type="hidden" name="tid" value="<?php echo $output['tid'];?>" />
					<input type="hidden" name="pid" value="<?php echo $output['pid'];?>" />
					<!-- DISCUZ_X -->
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<?php
							/**
							 * 整合X 显示
							 */
							if(DISCUZ_X === true && $output['product_array']['p_code'] == ''){
						?>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductXSetForumName'];?>:</td>
							<td class="cr-2" colspan='3'>
								<?php echo $output['forum_list_string'];?>
								<?php if($output['pid'] == ''){ ?>
									<a href="own_product.php?action=sel_forum"><?php echo $lang['langProductXSelForumAgain'];?></a>
								<?php } ?>
							</td>
						</tr>
						<?php
							}
						?>
						<tr>
							<td class="cr-11"><?php echo $lang['langSelltype'];?>:</td>
							<td class="cr-2">
								<input type="radio" id="radioSelltype1" name="radioSelltype" value="1" onclick="changeAuctionType('1');" <?php if($output['selltype'] == '1'){?>checked="checked"<?php } ?> /><label for="radioSelltype1"><?php echo $lang['langProductPrice'];?></label>
								<input type="radio" id="radioSelltype0" name="radioSelltype" value="0" onclick="changeAuctionType('0');" <?php if($output['selltype'] == '0'){?>checked="checked"<?php } ?> /><label for="radioSelltype0"><?php echo $lang['langProductAAuction'];?></label>
								<input type="radio" id="radioSelltype2" name="radioSelltype" value="2" onclick="changeAuctionType('2');" <?php if($output['selltype'] == '2'){?>checked="checked"<?php } ?> /><label for="radioSelltype2"><?php echo $lang['langPcamel'];?></label>
							</td>
							<td class="cr-11"><?php echo $lang['langProductAType'];?>:</td>
							<td class="cr-2">
								<input type="radio" name="radioType" id="radioType1" value="0" <?php if($output['product_array']['p_type'] == '0' || $output['product_array']['p_type'] == ''){?>checked="checked"<?php } ?> /><label for="radioType1"><?php echo $lang['langProductTypeNew'];?></label>
								<input type="radio" name="radioType" id="radioType2" value="1" <?php if($output['product_array']['p_type'] == '1'){?>checked="checked"<?php } ?> /><label for="radioType2"><?php echo $lang['langProductTypeSec'];?></label>
								<input type="radio" value="2" name="radioType" id="radioType3" <?php if($output['product_array']['p_type'] == '2'){?>checked="checked"<?php } ?> /><label for="radioType3"><?php echo $lang['langProductTypePlace'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductCate'];?>:</td>
							<td class="cr-2" colspan="3">
								<?php 
									/**
									 * 判断是否是该类重新发布
									 */
									if(!empty($output['sel_pc'])){
										$slPCId = $output['sel_pc'][count($output['sel_pc'])-1]['pc_id'];
								?>
									<input type="hidden" name="slPCId" id="slPCId" value="<?php echo $slPCId;?>" />
								<?php }else{ ?>
									<input type="hidden" name="slPCId" id="slPCId" value="<?php echo $output['product_array']['pc_id'];?>" />
								<?php } ?>
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
								<select name="txtPclassid" id="txtPclassid" class="wd">
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
									<?php echo $v['a_name'];?>:
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
								<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $output['product_array']['p_brand_id'];?>"/>
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
							<td class="cr-2" colspan="3"><input type="text" id="txtPname" name="txtPname" maxLength=30 class="in-2" value="<?php echo $output['product_array']['p_name'];?>" /></td>
						</tr>
					</table>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0" id="div_fixprice"><!-- 一口价 -->
						<tr>
							<td class="cr-11"><?php echo $lang['langProductPrice'];?>:</td>
							<td class="cr-2"><input type="text" id="txtPprice" name="txtPprice" maxLength="<?php echo $price_maxlength;?>" class="in" value="<?php echo $output['product_array']['p_price'];?>" onkeyup="price_to_exchange(this.value);" /></td>
						</tr>
					</table>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0" id="div_auction"><!-- 拍卖 -->
						<tr>
							<td class="cr-11"><?php echo $lang['langProductABeginPrice'];?>:</td>
							<td class="cr-2"><input type="text" maxLength="<?php echo $price_maxlength;?>" id="minimumBid" class="in" name="minimumBid" value="<?php echo $output['product_array']['p_price'];?>" onkeyup="price_to_exchange(this.value);" /></td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAPriceAddScope'];?>:</td>
							<td class="cr-2">
								<input type="radio" checked="checked" name="system_step" value="1" id="inc1" onclick="$('#price_step').attr('readonly',true).attr('disabled',true);$('#price_step').val('0');" />
								<label for="inc1"><?php echo $lang['langProductASystemAuto'];?><a href="../home/up_price.php" target="_blank"><?php echo $lang['langPViewUpPrice'];?></a></label>
								<br />
								<br />
								<input type="radio"  name="system_step" value="0" id="inc2" onclick="$('#price_step').attr('readonly',false).attr('disabled',false);" />
								<label for="inc2"><?php echo $lang['langProductAUserDefined'];?></label>
								<input maxLength="<?php echo $price_maxlength;?>" name="price_step" value="0.0" id="price_step" class="in">
								<span class="p-span-5"><?php echo $lang['langProductACommendYouSelect'];?><?php echo $lang['langProductASystemAutoAddPrice'];?></span>
								<script type="text/javascript">
									if (document.getElementById('inc1').checked) {
										document.getElementById('price_step').readOnley=true;
										document.getElementById('price_step').className='disabled';
										document.getElementById('price_step').value = 0;
									}
								</script>
							</td>
						</tr>
					</table>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0" id="div_camel"><!-- 拍卖 -->
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAGroupPrice'];?>:</td>
							<td class="cr-2"><input type="text" maxLength="<?php echo $price_maxlength;?>" id="txtGroupprice" class="in" name="txtGroupprice" value="<?php echo $output['product_array']['p_group_price'];?>" /></td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAddOldPrice'];?>:</td>
							<td class="cr-2"><input type="text" id="txtPoldprice" class="in" maxLength="<?php echo $price_maxlength;?>" name="txtPoldprice" value="<?php echo $output['product_array']['p_price'];?>" /></td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAGroupMinCount'];?>:</td>
							<td class="cr-2"><input type="text" id="txtGroupmincount" maxLength="<?php echo $price_maxlength;?>" class="in" name="txtGroupmincount" value="<?php echo $output['product_array']['p_group_mincount']?$output['product_array']['p_group_mincount']:'5';?>" /></td>
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
									$editor=new editor('txtPinfo');
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
							<td class="cr-11"><?php echo $lang['langProductStorage'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="text" maxLength="<?php echo $storage_maxlength;?>" class="in" name="txtPstorage" id="txtPstorage" value="<?php echo $output['product_array']['p_storage']?$output['product_array']['p_storage']:'1';?>" />
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
								<input type="hidden" name="area_id" id="area_id" value="<?php echo $output['product_array']['p_area_id'];?>"/>
								<select id="area_c1" name="area_c1" class="wd">
									<option valus="" selected></option>
									<?php if(!empty($output['area_array']) && is_array($output['area_array'])){?>
									<?php foreach($output['area_array'] as $k => $v){?>
										<option <?php if($output['sel_area'][0]['area_id'] == $v['area_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['area_id'];?>||<?php echo $v['is_parent'];?>"><?php echo $v['area_name'];?></option>
									<?php } ?>
									<?php } ?>
								</select>
								<select id="area_c2" name="area_c2" class="wd">
									<option valus="<?php echo $output['sel_area'][1]['area_id'];?>" selected><?php echo $output['sel_area'][1]['area_name'];?></option>
								</select>
								<select id="area_c3" name="area_c3" class="wd">
									<option valus="<?php echo $output['sel_area'][2]['area_id'];?>" selected><?php echo $output['sel_area'][2]['area_name'];?></option>
								</select>
								<select id="area_c4" name="area_c4" class="wd">
									<option valus="<?php echo $output['sel_area'][3]['area_id'];?>" selected><?php echo $output['sel_area'][3]['area_name'];?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langTranFee'];?>:</td>
							<td class="cr-2" colspan="3">
								<input name="radioTransfee" type="radio" id="whopsSeller" onclick="$('#ApplyPostage').css('display','none')" value="0" <?php if($output['product_array']['p_transfee_charge'] == '0' || $output['product_array']['p_transfee_charge'] == ''){ ?>checked="checked"<?php } ?> />
								<label for="whopsSeller"><?php echo $lang['langSelaTranFee'];?></label><br />
								<input name="radioTransfee" type="radio" id="whopsBuyer" onclick="$('#ApplyPostage').css('display','block');$('#use_postage_1').trigger('click');"  value="1" <?php if($output['product_array']['p_transfee_charge'] == '1'){ ?>checked="checked"<?php } ?> />
								<label for="whopsBuyer"><?php echo $lang['langProductAListBear'];?></label>
								<div style="padding-left:20px; width:460px; height:100px; padding-top:10px; background-color:#f8f8f8; border:#ececec 1px solid;" id="ApplyPostage" <?php if($output['product_array']['p_transfee_charge'] == '0' || $output['product_array']['p_transfee_charge'] == ''){ ?>style="display:none"<?php } ?>>
									<input type="radio" name="use_postage" id="use_postage_1" value='1' checked /><label for="use_postage_1"><?php echo $lang['langPUsePostage'];?></label>
									<br />
									<div id="postage_sel_div" style=" padding-left:21px; padding-top:7px;">
									<?php 
										/**
										 * 修改商品时 运费模板不为空的时候显示运费模板
										 */
										if(!empty($output['postage_array'])){ ?>
											<span id="postageName" style=" padding-left:3px; padding-top:5px; padding-right:3px;"><?php echo $output['postage_array']['postage_title']; ?></span> 
											<span class="buttom-comm-1"><input class="input-a" type="button" id="postageButton" value="<?php echo $lang['langPSelPostageRepeat'];?>" onclick="gotoSelectPostage();" /></span>
											<input type="hidden" id="postage_id" name="postage_id" value="<?php echo $output['product_array']['use_postage_id']; ?>" />
									<?php }else{ 
										/**
										 * 新增商品或者修改商品时运费模板为空的时候
										 */		
									?>
											<span id="postageName" style=" padding-left:3px; padding-top:5px; padding-right:3px;"><?php echo $lang['langPUsePostageClickButton'];?></span> 
											<span style=" margin-left:3px;" class="buttom-comm-1"><input class="input-a" type="button" id="postageButton" value="<?php echo $lang['langPSelPostage'];?>" onclick="gotoSelectPostage();" /></span>
											<input type="hidden" id="postage_id" name="postage_id" value="" />
									<?php } ?>
									</div>
									<div style=" clear:both; padding-top:5px;"><input type="radio" name="use_postage" id="use_postage_0" value='0' /><?php echo $lang['langPCommonlyPost'];?>:<input class="m-left" maxLength="<?php echo $price_maxlength;?>" size="8" id="pyTF" name="pyTF" value="<?php echo $output['product_array']['p_tf_py']?$output['product_array']['p_tf_py']:'0.0';?>" />
									<?php echo $lang['langPCelerityPost'];?>:<input  class="m-left" maxLength="<?php echo $price_maxlength;?>" size="8" id="kdTF" name="kdTF" value="<?php echo $output['product_array']['p_tf_kd']?$output['product_array']['p_tf_kd']:'0.0';?>" />
									EMS:<input  class="m-left" maxLength="<?php echo $price_maxlength;?>" size="8" id="emsTF" name="emsTF" value="<?php echo $output['product_array']['p_tf_ems']?$output['product_array']['p_tf_ems']:'0.0';?>" /></p>
								</div>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAInvoices'];?>:</td>
							<td class="cr-2">
								<input type=radio  value="1" name="radioInvoices" id="radioInvoices2" <?php if($output['product_array']['p_have_invoices'] == '1'){ ?>checked<?php } ?> /><label for="radioInvoices2"><?php echo $lang['langCHave'];?></label>
								<input type="radio" value="0" name="radioInvoices" id="radioInvoices" <?php if($output['product_array']['p_have_invoices'] == '0' || $output['product_array']['p_have_invoices'] == ''){ ?>checked<?php } ?> /><label for="radioInvoices"><?php echo $lang['langCNot'];?></label>
							</td>
							<td class="cr-11"><?php echo $lang['langWarranty'];?>:</td>
							<td class="cr-2">
								<input type="radio"  value="1" name="radioWarranty" id="warrantyY" <?php if($output['product_array']['p_have_warranty'] == '1'){ ?>checked<?php } ?> /><label for="warrantyY"><?php echo $lang['langCHave'];?></label>
								<input type="radio" value="0" name="radioWarranty" id="warrantyN" <?php if($output['product_array']['p_have_warranty'] == '0' || $output['product_array']['p_have_warranty'] == ''){ ?>checked<?php } ?> /><label for="warrantyN"><?php echo $lang['langCNot'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPattestation'];?>:</td>
							<td class="cr-2">
								<input type="checkbox" name="txtPgenuine" id="txtPgenuine" value="1" <?php if($output['product_array']['p_genuine'] == '1'){ ?>checked<?php } ?> /><label for="txtPgenuine"><?php echo $lang['langPgenuine'];?></label>
								<input type="checkbox" name="txtP7day" id="txtP7day" value="1" <?php if($output['product_array']['p_7day_return'] == '1'){ ?>checked<?php } ?> /><label for="txtP7day"><?php echo $lang['langP7dayreturn'];?></label>
							</td>
							<td class="cr-11"><?php echo $lang['langRecommended'];?>:</td>
							<td class="cr-2">
								<input type="checkbox" value="1" name="chxRecommended" id="chxRecommended" <?php if($output['product_array']['p_recommended'] == '1'){ ?>checked<?php } ?> /><label for="chxRecommended"><?php echo $lang['langCYes'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langValidDays'];?>:</td>
							<td class="cr-2" colspan="3">
								<span><input type="text" class="in" name="slValiddays" id="slValiddays" maxLength="3" value="<?php echo $output['product_array']['p_valid_days']?$output['product_array']['p_valid_days']:'30';?>" /></span><span class="cr-5-span"><font color="#000000"><?php echo $lang['langProductADay'];?></font>&nbsp;&nbsp;<?php echo $lang['langProductABabyInfoIssueTime'];?></span>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langStartTime'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="radio" name="_now" value="0" id="_now0" checked/>
								<label for="_now0"><?php echo $lang['langProductAOnce'];?></label>
								<input type="radio" name="_now" value="2" id="inStock"/>
								<label for="inStock"><?php echo $lang['langProductAPutDepot'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAAutoPublish'];?>:</td>
							<td class="cr-2" colspan="3">
								<span class="cr-5-span"><input type="checkbox" value="1" name="chxAutopublish" id="chxAutopublish" <?php if($output['product_array']['p_auto_publish'] == '1'){ ?>checked<?php } ?> /><font color="#000000"><?php echo $lang['langCYes'];?></font>
								<?php echo $lang['langProductASystemHelpYouAuto'];?></span></label> 
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductARemark'];?>:</td>
							<td class="cr-2" colspan="3">
								<textarea id="txtRemark" name="txtRemark" rows="10" cols="38"><?php echo $output['product_array']['p_remark'];?></textarea>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPKeywords'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="text" id="txtKeywords" class="in-2" maxlength="80" name="txtKeywords" value="<?php echo $output['product_array']['p_keywords'];?>" /><span class="p-span-5" style=" float:left; clear: both; width:100%;"><?php echo $lang['langPKeywordsRemark'];?></span>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPDescription'];?>:</td>
							<td class="cr-2" colspan="3">
								<textarea id="txtDescription" name="txtDescription" rows="10" cols="38"><?php echo $output['product_array']['p_description'];?></textarea><span class="p-span-5"><?php echo $lang['langPDescriptionRemark'];?></span>
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
<link type="text/css"  href="<?php echo TPL_DIR;?>/css/uploadify.css" rel="stylesheet" />
<script type="text/javascript" src="../js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="../js/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
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
		'script'         : 'own_product.php?action=pic_ajax&PHPSESSID=<?php echo $output['PHPSESSID'];?>',
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
		'queueSizeLimit' : 5-$(".up-img").children("ul").children("li").length,
		'buttonImg'      : '<?php echo TPL_DIR;?>/images/zengjia.gif',
		'cancelImg'      : '<?php echo TPL_DIR;?>/images/cancel.png',
		'onComplete'     : function(e,queueId,fileObj,data){
							datas=data.split(".");
							$(".up-img").children("ul").append('<li><div class="box-2"><input type="hidden" value="'+data+'"><img src="<?php echo SITE_URL;?>/'+datas[0]+'_small.'+datas[1]+'" style="width:105px; height:80px" /></div><p><a class="a-1" name="'+data+'" href="javascript:;" onclick="CopyToClipboard(\'<?php echo SITE_URL;?>/'+data+'\');"><?php echo $lang['langPIntoEditor'];?></a><a class="a-2" href="javascript:;" onclick=\'ajaxFileDel("'+datas[0]+'_small.'+datas[1]+'",this);\'><?php echo $lang['langbtnProductDel'];?></a></p></li>');
							$('#uploadify').uploadifySettings('queueSizeLimit',5-$(".up-img").children("ul").children("li").length);
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
	//use postage
	$('#use_postage_1').click(function(){
		$('#pyTF').attr('disabled',true);//.css({})
		$('#kdTF').attr('disabled',true);//.css({})
		$('#emsTF').attr('disabled',true);//.css({})
		$('#postage_sel_div').css('display','block');
		$('#pyTF').next('label').css('display','none');
		$('#kdTF').next('label').css('display','none');
		$('#emsTF').next('label').css('display','none');
	});
	//no use postage
	$('#use_postage_0').click(function(){
		$('#pyTF').attr('disabled',false);//.css({})
		$('#kdTF').attr('disabled',false);//.css({})
		$('#emsTF').attr('disabled',false);//.css({})
		$('#postage_sel_div').css('display','none');
	});
	//no use postage
	$('#whopsSeller').click(function(){
		$('#use_postage_1').attr('checked',true).trigger('click');
	});
	//document ready postage click
	<?php if($output['product_array']['p_transfee_charge'] == '1'){ ?>
		<?php if( $output['product_array']['use_postage'] == '0'){?>
			$('#use_postage_0').trigger('click');
		<?php } ?>
		<?php if( $output['product_array']['use_postage'] == '1'){?>
			$('#use_postage_1').trigger('click');
		<?php } ?>
	<?php }else{ ?>
		$('#whopsSeller').trigger('click');
	<?php } ?>
	//validate
	$("#ownaddproduct").validate({
		errorClass: "wrong",
		rules: {
			slPCId:{required:true},
			txtPname: {required:true},
			txtPstorage: {
				required:true,
				number:true,
				min: function(){
						if($("#radioSelltype2").attr('checked')==true){
							return 5;
						}else{
							return 1;
						}
					}
			},
			minimumBid: {
				required: "#radioSelltype0:checked",
				number: true,
				min: function(){
						if($("#radioSelltype0").attr('checked')==true){
							return 0.01;
						}else{
							return 0;
						}
					}
			},
			price_step: {
				required: "#radioSelltype0:checked",
				number: true,
				min: function(){
					if($("#radioSelltype0").attr('checked')==true && $("#inc2").attr('checked')==true){
						return 1;
					}else{
						return 0;
					}
				}
			},
			txtPprice: {required: "#radioSelltype1:checked",number: true,min: 0.01},
			txtGroupprice: {required:"#radioSelltype2:checked",number:true,min: function(){
					if($("#radioSelltype2").attr('checked')==true){
						return 0.1;
					}else{
						return 0;
					}
				}
			},
			txtPoldprice: {required: "#radioSelltype2:checked",number: true,min: function(){return $("#txtGroupprice").val();}},
			txtGroupmincount: {
				required: "#radioSelltype2:checked",
				number: true,
				min: function(){
					if($("#radioSelltype2").attr('checked')==true){
						return 5;
					}else{
						return 0;
					}
				},
				max:function(){
					if($("#radioSelltype2").attr('checked')==true){
						if($("#txtPstorage").val() >= 100){
							return 100;
						}else{
							return $("#txtPstorage").val();
						}
					}else{
						return 10000000;
					}
				}
			},
			area_id: {required: true},
			pyTF: {
				required: check_validate_pyTF_required,
				number: check_validate_pyTF_number,
				min: check_validate_pyTF_min,
				max: check_validate_pyTF_max
			},
			kdTF: {
				required: check_validate_kdTF_required,
				number: check_validate_kdTF_number,
				min: check_validate_kdTF_min,
				max: check_validate_kdTF_max
			},
			emsTF: {
				required: check_validate_emsTF_required,
				number: check_validate_emsTF_number,
				min: check_validate_emsTF_min,
				max: check_validate_emsTF_max
			},
			slValiddays: {
				required: true,
				number: true,
				min: 1,
				max: 90
			},
			postage_id:{
				required: check_validate_postage_required
			}
		},
		messages: {
			slPCId:{required:"<?php echo $lang['errPcidEmpty'];?>"},
			txtPname: {required: "<?php echo $lang['errProductNameEmpty'];?>"},
			txtPstorage: {
				required: "<?php echo $lang['errPstorage'];?>",
				number: "<?php echo $lang['errPstorage'];?>",
				min: function(){
					if($("#radioSelltype2").attr('checked')==true){
						return "<?php echo $lang['errPstorageByGroup'];?>";
					}else{
						return "<?php echo $lang['errPstorage'];?>";
					}
				}
			},
			minimumBid: {required: "<?php echo $lang['errMinimumbidWrong'];?>",number: "<?php echo $lang['errMinimumbidWrong'];?>",min: "<?php echo $lang['errMinimumbidWrong'];?>"},
			price_step: {required: "<?php echo $lang['langProductAUserDefinedUppriceIsEmpty'];?>",number: "<?php echo $lang['langProductAUserDefinedUppriceIsEmpty'];?>",min: "<?php echo $lang['langProductAUserDefinedUppriceIsEmpty'];?>"},
			txtPprice: {required: "<?php echo $lang['errPprice'];?>",number: "<?php echo $lang['errPprice'];?>",min: "<?php echo $lang['errPprice'];?>"},
			txtGroupprice: {required: "<?php echo $lang['errGroupprice'];?>",number: "<?php echo $lang['errGroupprice'];?>",min: "<?php echo $lang['errGroupprice'];?>"},
			txtPoldprice: {required: "<?php echo $lang['errPoldprice'];?>",number: "<?php echo $lang['errPoldprice'];?>",min: "<?php echo $lang['errPoldprice'];?>"},
			txtGroupmincount: {required: "<?php echo $lang['errGroupmincount'];?>",number: "<?php echo $lang['errGroupmincount'];?>",min:"<?php echo $lang['errGroupmincount'];?>",max:"<?php echo $lang['errGroupmincount'];?>"},
			area_id: {required:"<?php echo $lang['errProvince'];?>"},
			pyTF: {required: "<?php echo $lang['langProductPyTFIsEmpty'];?>",number: "<?php echo $lang['langProductPyTFIsEmpty'];?>",min: "<?php echo $lang['langProductPyTFIsEmpty'];?>",max:"<?php echo $lang['langProductPyTFIsEmpty'];?>"},
			kdTF: {required: "<?php echo $lang['langProductKdTFIsEmpty'];?>",number: "<?php echo $lang['langProductKdTFIsEmpty'];?>",min: "<?php echo $lang['langProductKdTFIsEmpty'];?>",max:"<?php echo $lang['langProductKdTFIsEmpty'];?>"},
			emsTF: {required: "<?php echo $lang['langProductEMSTFIsEmpty'];?>",number: "<?php echo $lang['langProductEMSTFIsEmpty'];?>",min: "<?php echo $lang['langProductEMSTFIsEmpty'];?>",max:"<?php echo $lang['langProductEMSTFIsEmpty'];?>"},
			slValiddays: {required: "<?php echo $lang['errPSValiddays'];?>",number: "<?php echo $lang['errPSValiddays'];?>",min: "<?php echo $lang['errPSValiddays'];?>",max: "<?php echo $lang['errPSValiddays'];?>(1-90)"},
			postage_id:{required: "<?php echo $lang['errPPostageTplIsEmpty'];?>"}
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
		}
	});
	//validate function
	function check_validate_postage_required(){
		if($('#use_postage_1').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_pyTF_required(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_pyTF_number(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_pyTF_min(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return 0;
		}else{
			return false;
		}
	}
	function check_validate_pyTF_max(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return 999.99;
		}else{
			return false;
		}
	}
	function check_validate_kdTF_required(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_kdTF_number(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_kdTF_min(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return 0;
		}else{
			return false;
		}
	}
	function check_validate_kdTF_max(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return 999.99;
		}else{
			return false;
		}
	}
	function check_validate_emsTF_required(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_emsTF_number(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return true;
		}else{
			return false;
		}
	}
	function check_validate_emsTF_min(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return 0;
		}else{
			return false;
		}
	}
	function check_validate_emsTF_max(){
		if($('#use_postage_0').attr('checked') == true && $('#whopsBuyer').attr('checked') == true){
			return 999.99;
		}else{
			return false;
		}
	}
});
function changeAuctionType(type){
	if(type == '0'){
		$('#whopsSeller').attr('checked','checked');
		$('#whopsBuyer').attr('disabled',true);
		$('#ApplyPostage').css('display','none');
		auction();
	}else{
		if (type == '1'){
			fixprice();
		}else{
			camel();
		}
		$('#whopsBuyer').attr('disabled',false);
		$('#tr_product_currency').css('display','');
	}
}
function fixprice() {
	$('#div_fixprice').css('display','');
	$('#div_auction').css('display','none');
	$('#div_camel').css('display','none');
	$('#republish').css('display','');
}
function auction() {
	$('#div_fixprice').css('display','none');
	$('#div_auction').css('display','');
	$('#div_camel').css('display','none');
	$('#republish').css('display','');

	$('#whopsSeller').trigger('click');
	$('#ApplyPostage').css('display','none');
}
function camel() {
	$('#div_fixprice').css('display','none');
	$('#div_auction').css('display','none');
	$('#div_camel').css('display','');
	$('#republish').css('display','none');
}

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
				$('#uploadify').uploadifySettings('queueSizeLimit',(5-$(".up-img").children("ul").children("li").length));
				$("#pic_num").val(parseInt($("#pic_num").val())-1);
			}
		}
	});
	return false;
}

// 地区选择
function tonext_area(whos) {
	$(whos).change(
		function(){
			var valarray=$(this).val().split('||');	
			$('#area_id').val(valarray[0]);
			if (valarray[1]=='1') {
				$(this).next().attr('disabled','true').html('<option value="" selected="selected"><?php echo $lang['langCDataToLoading'];?></option>');
				$.get(
					'../home/tohtml.php',
					{action:'get_area',id:valarray[0],random_number:Math.random()},
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
					tonext_area($(whos).next());
					}
				)
			} else {
				$(whos).nextAll().html('').attr('disabled','true');
			};
		}
	)
};

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
// 商品类别
function tonext_edit(whos) {
	$(whos).change(
		function(){
			var valarray=$(this).val().split('||');
			$('#slPCId').val(valarray[0]);
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

// 根据商品类别ID取商品属性
function ajax_get_attribute(pc_id){
	array=pc_id.split('||');
	if(array[1] == 0){// 没有下级分类
		$.get('../home/product.php',{action:'ajax_get_attribute',pc_id:array[0],random_number:Math.random()},function(data){
			if(data != ''){
				$('#attribute_baby').html(data);
			}else{
				$('#attribute_baby').html('');
			}
		})
	}else{
		return false;
	}
}

$(document).ready(function() {

	tonext_area('#area_c1');
	
	tonext_brand('#brand_c1');
	
	tonext_edit('#pc_c1');
	
	fixprice();

	<?php if($output['selltype'] != ''){ ?>
		changeAuctionType('<?php echo $output['selltype'];?>');
	<?php } ?>
});
//select postage
function gotoSelectPostage(){
	window.open("own_postage.php?action=sel_postage");
}
function afterSelectPostage(postage_id, postageName) {
	$('#postage_id').val(postage_id);
	$('#postageName').html(postageName);
	$('#postageButton').val("<?php echo $lang['langPSelPostageRepeat'];?>");
}
// 属性
function show_attribute(){
	var id=$('#slPCId').val();
	if(id != ''){
		$('#td_attribute').html('<img src="<?php echo TPL_DIR;?>/images/loading.gif" />');
		$.ajax({
			url: 'own_product.php?action=ajax_get_attribute&pc_id='+id,
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
</script>