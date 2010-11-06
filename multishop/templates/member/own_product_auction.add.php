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
				<form action="own_product_auction.php?action=<?php if($output['product_array']['p_code'] == ''){ ?>save<?php }else{ ?>update<?php } ?>" enctype="multipart/form-data" method="post" onsubmit="updatapic()" name="ownaddproduct"  id="ownaddproduct">
					<input type="hidden" name="p_code" id="p_code" value="<?php echo $output['product_array']['p_code'];?>"/>
					<input type="hidden" name="pc_id" id="pc_id" value="<?php echo $output['pc_id'];?>"/>
					<input type="hidden" name="p_currency_category" id="p_currency_category" value="<?php echo $output['exchange_array']['exchange_name'];?>"/>
					<input type="hidden" name="pic_num" id="pic_num" value="<?php echo $output['pic_num']?$output['pic_num']:'0';?>"/>
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-11"><?php echo $lang['langSelltype'];?>:</td>
							<td class="cr-2" style="width:200px;" ><?php echo $lang['langProductAAuction'];?></td>
							<td class="cr-11-1"><span style="text-align:right;"><?php echo $lang['langProductAType'];?>:</span></td>
							<td class="cr-2">
								<input type="radio" name="p_type" id="p_type" value="0" <?php if($output['product_array']['p_type'] == '0' || $output['product_array']['p_type'] == ''){?>checked="checked"<?php } ?> /><label for="radioType1"><?php echo $lang['langProductTypeNew'];?></label>
								<input type="radio" name="p_type" id="p_type" value="1" <?php if($output['product_array']['p_type'] == '1'){?>checked="checked"<?php } ?> /><label for="radioType2"><?php echo $lang['langProductTypeSec'];?></label>
								<input type="radio" value="2" name="p_type" id="p_type" <?php if($output['product_array']['p_type'] == '2'){?>checked="checked"<?php } ?> /><label for="radioType3"><?php echo $lang['langProductTypePlace'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductCate'];?>:</td>
							<td class="cr-2" colspan="3"><?php echo $output['product_class_string']; ?>
								&nbsp;&nbsp;&nbsp;&nbsp;<a href="own_product.php?action=sell<?php if($output['product_array']['p_code'] != ''){ ?>&p_code=<?php echo $output['product_array']['p_code'] ?><?php } ?>"><?php echo $lang['langProductSelectClass'];?></a>
							</td>
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
								<input type="hidden" name="p_pb_id" id="p_pb_id" value="<?php echo $output['product_array']['p_pb_id'];?>"/>
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
						<tr>
							<td class="cr-11"><?php echo $lang['langProductABeginPrice'];?>:</td>
							<td class="cr-2" colspan="3"><input type="text" id="p_price" class="in" name="p_price" value="<?php echo $output['product_array']['p_price'];?>" />&nbsp;(<?php echo $output['exchange_array']['exchange_remark'];?>/<?php echo $lang['langCYuan'];?>)</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAPriceAddScope'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="radio" checked="checked" name="p_system_step" value="1" id="p_system_step_1" />
								<label for="p_system_step_1"><?php echo $lang['langProductASystemAuto'];?>&nbsp;&nbsp;<a href="../home/up_price.php" target="_blank"><?php echo $lang['langPViewUpPrice'];?></a></label>
								<br />
								<br />
								
								<div class="inputFloatLeft"><input type="radio"  name="p_system_step" value="0" id="p_system_step_0" />
								<label for="p_system_step_0"><?php echo $lang['langProductAUserDefined'];?></label></div><input name="p_price_step" id="p_price_step" value="1" class="in" style="margin-left:5px;">
								<span class="p-span-5 spanBlock"><?php echo $lang['langProductACommendYouSelect'];?><?php echo $lang['langProductASystemAutoAddPrice'];?></span>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductStorage'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="text" class="in" name="p_storage" id="p_storage" value="<?php echo $output['product_array']['p_storage']?$output['product_array']['p_storage']:'2';?>" />
								<span class="cr-5-span">
									<?php echo $lang['langPAuctionStorageRemark'];?><a href="own_product.php?action=sell"><?php echo $lang['langPcountdown'];?></a>
								</span>
							</td>
						</tr>
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
								// 如果图片数量超过5 则返回信息，不允许添加
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
							<td class="cr-11"><?php echo $lang['langProductArea'];?>:</td>
							<td class="cr-2" colspan="3">
								<div id="adddiv"></div>
								<input type="hidden" name="p_area_id" id="p_area_id" value="<?php echo $output['product_array']['p_area_id'];?>"/>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langTranFee'];?>:</td>
							<td class="cr-2" colspan="3">
								<input name="p_transfee_charge" type="radio" value="0" checked="checked" /><?php echo $lang['langSelaTranFee'];?><br />
								<input name="p_transfee_charge" type="radio" value="1" disabled="disabled" /><?php echo $lang['langProductAListBear'];?>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAInvoices'];?>:</td>
							<td class="cr-2">
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
								<input type="checkbox" name="p_genuine" id="p_genuine" value="1" <?php if($output['product_array']['p_genuine'] == '1'){ ?>checked<?php } ?> /><label for="p_genuine"><?php echo $lang['langPgenuine'];?></label>
								<input type="checkbox" name="p_7day_return" id="p_7day_return" value="1" <?php if($output['product_array']['p_7day_return'] == '1'){ ?>checked<?php } ?> /><label for="p_7day_return"><?php echo $lang['langP7dayreturn'];?></label>
							</td>
							<td class="cr-11-1" ><?php echo $lang['langRecommended'];?>:</td>
							<td class="cr-2">
								<input type="checkbox" value="1" name="p_recommended" id="p_recommended" <?php if($output['product_array']['p_recommended'] == '1'){ ?>checked<?php } ?> /><label for="p_recommended"><?php echo $lang['langCYes'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langValidDays'];?>:</td>
							<td class="cr-2" colspan="3">
								<span><input type="text" class="in" name="p_valid_days" id="p_valid_days" value="<?php echo $output['product_array']['p_valid_days']?$output['product_array']['p_valid_days']:'30';?>" /></span><span class="cr-5-span"><font color="#000000"><?php echo $lang['langProductADay'];?></font>&nbsp;&nbsp;<?php echo $lang['langProductABabyInfoIssueTime'];?></span>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langStartTime'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="radio" name="p_start_time" value="0" id="_now0" checked/>
								<label for="_now0"><?php echo $lang['langProductAOnce'];?></label>
								<input type="radio" name="p_start_time" value="2" id="inStock"/>
								<label for="inStock"><?php echo $lang['langProductAPutDepot'];?></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductAAutoPublish'];?>:</td>
							<td class="cr-2" colspan="3">
								<span class="cr-5-span"><input type="checkbox" value="1" name="p_auto_publish" id="p_auto_publish" <?php if($output['product_array']['p_auto_publish'] == '1'){ ?>checked<?php } ?> /><?php echo $lang['langProductASystemHelpYouAuto'];?></span></label>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langProductARemark'];?>:</td>
							<td class="cr-2" colspan="3">
								<textarea id="p_remark" name="p_remark" rows="10" cols="38"><?php echo $output['product_array']['p_remark'];?></textarea>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPKeywords'];?>:</td>
							<td class="cr-2" colspan="3">
								<input type="text" id="p_keywords" class="in-2" name="p_keywords" value="<?php echo $output['product_array']['p_keywords'];?>" /><span class="p-span-5 spanBlock"><?php echo $lang['langPKeywordsRemark'];?></span>
							</td>
						</tr>
						<tr>
							<td class="cr-11"><?php echo $lang['langPDescription'];?>:</td>
							<td class="cr-2" colspan="3">
								<textarea id="p_description" name="p_description" rows="10" cols="38"><?php echo $output['product_array']['p_description'];?></textarea><span class="p-span-5"><?php echo $lang['langPDescriptionRemark'];?></span>
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
			p_price: {
				required: true,
				number: true,
				min: 0.01
			},
			p_price_step: {
				required: "#p_system_step_0:checked",
				number: "#p_system_step_0:checked",
				min: function(){
					if($("#p_system_step_0").attr('checked')==true){
						return 1;
					}else{
						return 0;
					}
				}
			},
			p_area_id: {required: true},
			p_valid_days: {
				required: true,
				number: true,
				min: 1,
				max: 99
			}
		},
		messages: {
			pc_id:{required:"<?php echo $lang['errPcidEmpty'];?>"},
			p_name: {required: "<?php echo $lang['errProductNameEmpty'];?>"},
			p_storage: {
				required: "<?php echo $lang['errPstorage'];?>",
				number: "<?php echo $lang['errPstorage'];?>",
				min: "<?php echo $lang['errPstorage'];?>"
			},
			p_price: {required: "<?php echo $lang['errMinimumbidWrong'];?>",number: "<?php echo $lang['errMinimumbidWrong'];?>",min: "<?php echo $lang['errMinimumbidWrong'];?>"},
			p_price_step: {required: "<?php echo $lang['langProductAUserDefinedUppriceIsEmpty'];?>",number: "<?php echo $lang['langProductAUserDefinedUppriceIsEmpty'];?>",min: "<?php echo $lang['langProductAUserDefinedUppriceIsEmpty'];?>"},
			p_area_id: {required:"<?php echo $lang['errProvince'];?>"},
			p_valid_days: {required: "<?php echo $lang['errPSValiddays'];?>",number: "<?php echo $lang['errPSValiddays'];?>",min: "<?php echo $lang['errPSValiddays'];?>",max: "<?php echo $lang['errPSValiddays'];?>(1-99)"}
		}
	});
});
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
			$('#p_pb_id').val(valarray[0]);
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

$(document).ready(function() {

	//选择商品所在地
	$('#adddiv').addSelect({
					ajaxUrl:'../home/tohtml.php',
					ajaxAction:'get_area',
					type:'modi',
					modi_id:'<?php echo $output['product_array']['p_area_id'];?>',
					hiddenId:'p_area_id'
				});


	tonext_brand('#brand_c1');

	<?php if($output['selltype'] != ''){ ?>
		changeAuctionType('<?php echo $output['selltype'];?>');
	<?php } ?>

	$('#p_system_step_0').click(function(){
		$('#p_price_step').attr('readonly',false).attr('disabled',false);
	});
	$('#p_system_step_1').click(function(){
		$('#p_price_step').attr('readonly',true).attr('disabled',true);
	});

	<?php if($output['product_array']['p_system_step'] == '1' || $output['product_array']['p_system_step'] == ''){ ?>
		$('#p_system_step_1').trigger('click');
	<?php }else{ ?>
		$('#p_system_step_0').trigger('click');
	<?php } ?>
});
</script>