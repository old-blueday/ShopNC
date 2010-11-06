<link href="<?php echo SITE_URL; ?>/js/jquery/ui.theme.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITE_URL; ?>/js/jquery/ui.datepicker.js"></script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p>
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
					<form action="own_product_group.php?action=<?php if($output['product_array']['p_code'] == ''){ ?>save<?php }else{ ?>update<?php } ?>" enctype="multipart/form-data" method="post" onsubmit="updatapic()" name="ownaddproduct"  id="ownaddproduct">
						<input type="hidden" name="p_sell_type" value="2" />
						<input type="hidden" name="p_code" id="p_code" value="<?php echo $output['product_array']['p_code'];?>"/>
						<input type="hidden" name="pc_id" id="pc_id" value="<?php echo $output['pc_id'];?>"/>
						<input type="hidden" name="p_currency_category" id="p_currency_category" value="<?php echo $output['exchange_array']['exchange_name'];?>"/>
						<input type="hidden" name="pic_num" id="pic_num" value="<?php echo $output['pic_num']?$output['pic_num']:'0';?>"/>
						<table width="100%" class="cr-r-td" border="0" cellpadding="0">
							<tr>
								<td class="cr-11"><?php echo $lang['langSelltype'];?>:</td>
								<td class="cr-2" style="width:200px;" ><?php echo $lang['langPcamel'];?></td>
								<td class="cr-11-1"><?php echo $lang['langProductAType'];?>:</td>
								<td class="cr-2">
									<input type="radio" name="p_type" id="p_type" value="0" <?php if($output['product_array']['p_type'] == '0' || $output['product_array']['p_type'] == ''){?>checked="checked"<?php } ?> />
									<label for="radioType1"><?php echo $lang['langProductTypeNew'];?></label>
									<input type="radio" name="p_type" id="p_type" value="1" <?php if($output['product_array']['p_type'] == '1'){?>checked="checked"<?php } ?> />
									<label for="radioType2"><?php echo $lang['langProductTypeSec'];?></label>
									<input type="radio" value="2" name="p_type" id="p_type" <?php if($output['product_array']['p_type'] == '2'){?>checked="checked"<?php } ?> />
									<label for="radioType3"><?php echo $lang['langProductTypePlace'];?></label>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductCate'];?>:</td>
								<td class="cr-2" colspan="3"> <?php echo $output['product_class_string']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="own_product.php?action=sell<?php if($output['product_array']['p_code'] != ''){ ?>&p_code=<?php echo $output['product_array']['p_code'] ?><?php } ?>"><?php echo $lang['langProductSelectClass'];?></a></td>
							</tr>
							<?php 
							/**
							 * 店铺商品分类
							 */
							if(!empty($output['shop_product_category']) && is_array($output['shop_product_category'])){
						?>
							<tr>
								<td class="cr-11"><?php echo $lang['langPShopClassSelect'];?>:</td>
								<td class="cr-2" colspan="3">
									<select name="p_class_id" id="p_class_id" class="wd">
										<option value="0"><?php echo $lang['langPPleaseSelect'];?></option>
										<?php foreach($output['shop_product_category'] as $k => $v){?>
										<option value="<?php echo $v['class_id'];?>" <?php if($output['product_array']['p_class_id'] == $v['class_id']){ ?>selected<?php } ?>><?php echo $v['class_name'];?></option>
										<?php if(!empty($v['child']) && is_array($v['child'])){?>
										<?php foreach($v['child'] as $k2 => $v2){?>
										<option value="<?php echo $v2['class_id'];?>" <?php if($output['product_array']['p_class_id'] == $v2['class_id']){ ?>selected<?php } ?>>&nbsp;&nbsp;<?php echo $v2['class_name'];?></option>
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
									<span class="td_attribute_span"><?php echo $v['a_name'];?></span>:
									<?php if($v['a_type'] == '0'){ ?>
									<select class="wd" name="attribute_content[]" style="display:inline;float:none;">
										<option value=""></option>
										<?php if(!empty($v['content']) && is_array($v['content'])){?>
										<?php foreach($v['content'] as $k2 => $v2){ ?>
										<option value="<?php echo $v2['ac_id'];?>|<?php echo $v2['a_id'];?>" <?php if($v2['ischecked'] == '1'){ ?>selected="selected"<?php }?>><?php echo $v2['ac_content'];?></option>
										<?php }?>
										<?php }?>
									</select>
									<br />
									<?php }?>
									<?php if($v['a_type'] == '1'){ ?>
									<?php if(!empty($v['content']) && is_array($v['content'])){?>
									<?php foreach($v['content'] as $k2 => $v2){ ?>
									<input style="display:inline;float:none;" name="attribute_content[]" type="checkbox" value="<?php echo $v2['ac_id'];?>|<?php echo $v2['a_id'];?>" <?php if($v2['ischecked'] == '1'){ ?>checked<?php }?>>
									<?php echo $v2['ac_content'];?>
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
								<td class="cr-11"><?php echo $lang['langProductName'];?>
									<!-- 商品名称 -->
									:</td>
								<td class="cr-2" colspan="3" >
									<input type="text" id="txtPname" name="p_name" class="in-2" value="<?php echo $output['product_array']['p_name'];?>" />
								</td>
							</tr>
						</table>
						<table width="100%" class="cr-r-td" cellpadding="0" >
							<tr>
								<td class="cr-11" style="border-top:none;"><?php echo $lang['langProductGroupPrice']; ?>
									<!-- 团购原价 -->
									:</td>
								<td class="cr-2" style="border-top:none; border-right:#CCC 1px solid;">
									<input type="text" id="cp_price" class="in" name="cp_price" value="<?php echo $output['product_array']['p_price']; ?>" />
									&nbsp;<?php echo $lang['langYuan']; ?> </td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductAGroupPrice']; ?>
									<!-- 团购价 -->
									:</td>
								<td class="cr-2" colspan="3">
									<input type="text" id="cp_group_price" class="in" name="cp_group_price" value="<?php echo $output['product_array']['p_group_price']; ?>"  />
									&nbsp;<?php echo $lang['langYuan']; ?></td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductAGroupMaxCount']; ?>
									<!-- 最大团购数量 -->
									:</td>
								<td class="cr-2" colspan="3">
									<input type="text" name="cp_max_count" id="cp_max_count" class="in" value="<?php echo  ($output['product_group_array']['max_count']!= 0 ? $output['product_group_array']['max_count'] : 5 ); ?>" />
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductGroupMincount']; ?>
									<!-- 最小团购人数 -->
									:</td>
								<td class="cr-2">
									<input type="text" id="cp_min_count" class="in" name="cp_min_count" value="<?php echo  ($output['product_group_array']['min_count']!= 0 ? $output['product_group_array']['min_count'] : 5 ); ?>" />
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductStorage']; ?>
									<!-- 宝贝数量 -->
									:</td>
								<td class="cr-2">
									<input type="text" id="p_storage" class="in" name="p_storage" value="<?php echo  ($output['product_array']['p_storage']!= 0 ? $output['product_array']['p_storage'] : 5 ); ?>" />
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langGroupMoney']; ?>
									<!--  -->
									:</td>
								<td class="cr-2">
									<input type="text" id="cp_set_money" class="in" name="cp_set_money" value="<?php echo  ($output['product_group_array']['set_money']!= 0 ? $output['product_group_array']['set_money'] : 5 ); ?>" />
									&nbsp;<?php echo $lang['langYuan']; ?></td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductStartTime']; ?>:</td>
								<td class="cr-2">
									<input class="in" name="cp_start_ymd" id="cp_start_ymd" readonly="true" type="text" value="<?php if ($output['product_array']['p_code'] != '') { echo date("Y-m-d",$output['product_array']['p_start_time']); } else { echo date("Y-m-d",time()); } ?>" />
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductEndTime']; ?>:</td>
								<td class="cr-2">
									<input class="in" name="cp_end_ymd" id="cp_end_ymd" readonly="true" type="text" value="<?php if ($output['product_array']['p_code'] != '') { echo date("Y-m-d",$output['product_array']['p_end_time']); } else { echo date("Y-m-d",time()); } ?>" />
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductComments']; ?>:</td>
								<td class="cr-2">
									<textarea id="cp_product_comments" name="cp_product_comments" rows="10" cols="38"><?php echo $output['product_array']['p_remark'];?></textarea>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langWebComments']; ?>:</td>
								<td class="cr-2">
									<textarea id="cp_web_comments" name="cp_web_comments" rows="10" cols="38"><?php echo $output['product_array']['p_remark'];?></textarea>
								</td>
							</tr>
						</table>
						<table width="100%" class="cr-r-td wubian"  border="0" cellpadding="0">
							<tr>
								<td class="cr-11"><?php echo $lang['langUploadPic'];?>:</td>
								<td class="cr-2" colspan="3">
									<div class="up-img">
										<ul>
											<?php if(!empty($output['pic_array']) && is_array($output['pic_array'])){ ?>
											<?php foreach($output['pic_array'] as $k => $v){ ?>
											<li>
												<div class="box-2"><img src="<?php echo SITE_URL;?>/<?php echo $v['small_pic'];?>" style="width:105px; height:80px" /></div>
												<p><a name="<?php echo $v['p_pic'];?>" class="a-1" href="javascript:;" onclick="CopyToClipboard('<?php echo SITE_URL;?>/<?php echo $v['p_pic'];?>');"><?php echo $lang['langPIntoEditor']; ?></a><a class="a-2" href='javascript:;' onclick=ajaxFileDel("<?php echo $v['small_pic'];?>",this);><?php echo $lang['langbtnProductDel'];?></a></p>
											</li>
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
									<span class="cr-5-span"><?php echo $lang['langProductPicSize'];?></span> </td>
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
									<input onclick="if(this.checked == true){select_cur('<?php echo $v['currency_line']?>');}else{select_no_cur('<?php echo $v['currency_line']?>','<?php echo $k;?>');}" type="checkbox" <?php if($v['check'] == '1'){ ?>checked="checked"<?php } ?> value="<?php echo $k;?>" name="txtPayment[<?php echo $k;?>]" id="txtPayment_<?php echo $k;?>" />
									<label for="txtPayment_<?php echo $k;?>"><?php echo $v['name'];?></label>
									<input type="hidden" name="payment_cur_<?php echo $k;?>" id="payment_cur_<?php echo $k;?>" value="<?php echo $v['currency_line']?>" />
									<?php } ?>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductArea'];?>:</td>
								<td class="cr-2" colspan="3">
									<div id="adddiv"></div>
									<input type="hidden" name="p_area_id" id="p_area_id" value="<?php echo $output['product_array']['p_area_id'];?>"/>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langTranFee'];?>:</td>
								<td class="cr-2" colspan="3">
									<div style="display:block;">
										<input name="p_transfee_charge" type="radio" id="whopsSeller"  value="0" />
										<label for="whopsSeller"><?php echo $lang['langSelaTranFee'];?></label>
										<br />
										<input name="p_transfee_charge" type="radio" id="whopsBuyer" disabled />
										<label for="whopsBuyer"><?php echo $lang['langProductAListBear'];?></label>
									</div>
								</td>
							</tr>
							<tr>
								<td class="cr-11" ><?php echo $lang['langProductAInvoices'];?>:</td>
								<td class="cr-2" >
									<input type=radio  value="1" name="p_have_invoices" id="radioInvoices2" <?php if($output['product_array']['p_have_invoices'] == '1'){ ?>checked<?php } ?> />
									<label for="radioInvoices2"><?php echo $lang['langCHave'];?></label>
									<input type="radio" value="0" name="p_have_invoices" id="radioInvoices" <?php if($output['product_array']['p_have_invoices'] == '0' || $output['product_array']['p_have_invoices'] == ''){ ?>checked<?php } ?> />
									<label for="radioInvoices"><?php echo $lang['langCNot'];?></label>
								</td>
								<td class="cr-11-1"><?php echo $lang['langWarranty'];?>:</td>
								<td class="cr-2">
									<input type="radio"  value="1" name="p_have_warranty" id="warrantyY" <?php if($output['product_array']['p_have_warranty'] == '1'){ ?>checked<?php } ?> />
									<label for="warrantyY"><?php echo $lang['langCHave'];?></label>
									<input type="radio" value="0" name="p_have_warranty" id="warrantyN" <?php if($output['product_array']['p_have_warranty'] == '0' || $output['product_array']['p_have_warranty'] == ''){ ?>checked<?php } ?> />
									<label for="warrantyN"><?php echo $lang['langCNot'];?></label>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langPattestation'];?>:</td>
								<td class="cr-2">
									<input type="checkbox" name="p_genuine" id="txtPgenuine" value="1" <?php if($output['product_array']['p_genuine'] == '1'){ ?>checked<?php } ?> />
									<label for="txtPgenuine"><?php echo $lang['langPgenuine'];?></label>
									<input type="checkbox" name="p_7day_return" id="txtP7day" value="1" <?php if($output['product_array']['p_7day_return'] == '1'){ ?>checked<?php } ?> />
									<label for="txtP7day"><?php echo $lang['langP7dayreturn'];?></label>
								</td>
								<td class="cr-11-1"><?php echo $lang['langRecommended'];?>:</td>
								<td class="cr-2">
									<input type="checkbox" value="1" name="p_recommended" id="chxRecommended" <?php if($output['product_array']['p_recommended'] == '1'){ ?>checked<?php } ?> />
									<label for="chxRecommended"><?php echo $lang['langCYes'];?></label>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langProductARemark'];?>:</td>
								<td class="cr-2" colspan="3" >
									<textarea id="txtRemark" name="p_remark" rows="10" cols="38"><?php echo $output['product_array']['p_remark'];?></textarea>
								</td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langPKeywords'];?>:</td>
								<td class="cr-2" colspan="3">
									<input type="text" class="in-2" name="p_keywords" value="<?php echo $output['product_array']['p_keywords'];?>" />
									<span class="p-span-5" style=" float:left; clear: both; width:100%;"><?php echo $lang['langPKeywordsRemark'];?></span> </td>
							</tr>
							<tr>
								<td class="cr-11"><?php echo $lang['langPDescription'];?>:</td>
								<td class="cr-2" colspan="3">
									<textarea name="p_description" rows="10" cols="38"><?php echo $output['product_array']['p_description'];?></textarea>
									<span class="p-span-5"><?php echo $lang['langPDescriptionRemark'];?></span> </td>
							</tr>
						</table>
						<div class="an-1"> <span class="buttom-comm">
							<input type="hidden" name="p_pic" id="p_pic" />
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
							</span> </div>
					</form>
				</div>
			</div>
		</div>
	</div>
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
			pc_id:{required:true},
			p_name: {required:true},
			p_storage: {
				required:true,
				number:true,
				min: 2
			},
			cp_price: {
				required: true,
				number: true
			},
			cp_group_price: {
				required: true,
				number: true
			},
			cp_max_count: {
				required: true,
				number: true
			},
			cp_min_count: {
				required: true,
				number: true
			},
			cp_set_money: {
				required: true,
				number: true
			},
			p_area_id: {required: true}
		},
		messages: {
			pc_id:{required:"<?php echo $lang['errPcidEmpty'];?>"},
			p_name: {required: "<?php echo $lang['errProductNameEmpty'];?>"},
			p_storage: {
				required: "<?php echo $lang['errPstorage'];?>",
				number: "<?php echo $lang['errPstorage'];?>",
				min: "<?php echo $lang['errPstorage'];?>"
			},
			cp_price: {required: "<?php echo $lang['langPGroupCheckPrice']; ?>",number: "<?php echo $lang['langPGroupCheckPriceType'];?>"},
			cp_group_price: {required: "<?php echo $lang['langPGroupCheckGPrice'];?>",number: "<?php echo $lang['langPGroupCheckGPriceType'];?>"},
			cp_max_count: {required: "<?php echo $lang['langPGroupCheckMax'];?>",number: "<?php echo $lang['langPGroupCheckMaxType'];?>"},
			cp_min_count: {required: "<?php echo $lang['langPGroupCheckMin'];?>",number: "<?php echo $lang['langPGroupCheckMinType'];?>"},
			cp_set_money: {required: "<?php echo $lang['langPGroupCheckMoney'];?>",number: "<?php echo $lang['langPGroupCheckMoneyType'];?>"},
			p_area_id: {required:"<?php echo $lang['errProvince'];?>"}
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
	
	tonext_brand('#brand_c1');
	
	tonext_edit('#pc_c1');
	
	$("#cp_start_time1").click(function(){
		setStartTime(true);
	});
	$("#cp_start_time2").click(function(){
		setStartTime(false);
	});
	if ($("#cp_start_time2").attr('checked')) {
		setStartTime(false);
	}
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
		defaultDate:300000,
		yearRange:'<?php echo date("Y",time()); ?>:<?php echo date("Y",time()) + 10; ?>'		
	});	
	$('#cp_end_ymd').datepicker( 'setDate' , '+30d' );
});
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

function setStartTime(b) {
	$("#cp_start_ymd").attr('disabled',b);	
	$("#cp_start_h").attr('disabled',b);	
	$("#cp_start_i").attr('disabled',b);	
}
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
