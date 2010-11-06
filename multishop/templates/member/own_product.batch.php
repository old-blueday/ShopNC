<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langBatchProduct'];?></p>
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
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langBatchProduct'];?></p></span></li>
						<li class="nav-bg-1 nav-left"><b></b><span><p><a href="own_product_batch.php?action=export"><?php echo $lang['langBatchProductExport'];?></a></p></span></li
					></ul>
				</div>
				<div class="cr-right">
				<form action="own_product_batch.php?action=upload" method="post" enctype="multipart/form-data" name="form_batch" id="form_batch">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchClass'];?>:</td>
							<td class="cr-2">
								
								<select name="c1" id="c1" class="wd">
									<option value=""></option>
									<?php if(!empty($output['ProductCateArray']) && is_array($output['ProductCateArray'])){ ?>
									<?php foreach($output['ProductCateArray'] as $k => $v){?>
										<option value="<?php echo $v[0];?>||<?php echo $v[5];?>"><?php echo $v[2];?></option>
									<?php } ?>
									<?php } ?>
								</select>
								<select name="c2" id="c2" class="wd">
								</select>
								<select name="c3" id="c3" class="wd">
								</select>
								<select name="c4" id="c4" class="wd">
								</select>
                                <input name="searchcate" type="hidden" id="searchcate" />
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchUploadFile'];?>:</td>
							<td class="cr-2"><input name="file" id="file" type="file" /></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchUploadCSV'];?>:</td>
							<td class="cr-2"><input type="radio" name="batch_type" id="batch_type" value="taobao" checked="checked" /><label for="batch_type"><?php echo $lang['langBatchTaobao'];?></label></td>
						</tr>
						<?php if(!empty($output['shop_product_cate_array']) && is_array($output['shop_product_cate_array'])){ ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchShopProductClass'];?>:</td>
							<td class="cr-2">
								<select name="shop_product_category" id="shop_product_category">
								<?php foreach($output['shop_product_cate_array'] as $k => $v){?>
									<option value="<?php echo $v['class_id'];?>"><?php echo $v['class_name'];?></option>
									<?php if(!empty($v['child']) && is_array($v['child'])){ ?>
									<?php foreach($v['child'] as $k2 => $v2){?>
										<option value="<?php echo $v2['class_id'];?>"><?php echo $v2['class_name'];?></option>
									<?php } ?>
									<?php } ?>
								<?php } ?>
								</select>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchCity'];?>:</td>
							<td class="cr-2">
								<div id="adddiv"></div>
                                <input type="hidden" name="area_id" id="area_id" value="" />
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchPayment'];?>:</td>
							<td class="cr-2">
								<?php
									/**
									 * 该支付方式支持的货币种类
									 */
									if(!empty($output['payment_array']) && is_array($output['payment_array'])){ ?>
								<?php foreach($output['payment_array'] as $k => $v){?>
									<input onclick="if(this.checked == true){select_cur('<?php echo $v['currency_line'];?>');}else{select_no_cur('<?php echo $v['currency_line'];?>','<?php echo $k;?>');}" type="checkbox" 
										<?php if($v['check'] == '1'){?>
											checked="checked"
										<?php }?>
										value="<?php echo $k;?>" 
										name="txtPayment[<?php echo $k;?>]" 
										id="txtPayment_<?php echo $k;?>" 
									/><label for="txtPayment_<?php echo $k;?>"><?php echo $v['name'];?></label>
									<input type="hidden" name="payment_cur_<?php echo $k;?>" id="payment_cur_<?php echo $k;?>" value="<?php echo $v['currency_line'];?>" />
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langBatchExchange'];?>:</td>
							<td class="cr-2">
								<?php
									/**
									 * 货币
									 */
									if(!empty($output['exchange_array']) && is_array($output['exchange_array'])){ ?>
								<?php foreach($output['exchange_array'] as $k => $v){?>
									<input type="hidden" name="exchange_rate_<?php echo $v['exchange_name'];?>" id="exchange_rate_<?php echo $v['exchange_name'];?>" value="<?php echo $v['exchange_rate'];?>" />
									<div id="div_cur_<?php echo $v['exchange_name'];?>" style="display:<?php echo $v['display'];?>">
										<input type="checkbox"
											<?php if($v['display'] !== 'none'){?>
												checked="checked"
											<?php } ?>
										name="currency[<?php echo $v['exchange_name'];?>]" id="currency_<?php echo $v['exchange_name'];?>" value="<?php echo $v['exchange_name'];?>" /><label for="currency_<?php echo $v['exchange_name'];?>"><?php echo $v['exchange_remark'];?>(<?php echo $v['exchange_name'];?>)</label>
									</div>
								<?php } ?>
								<?php } ?>
							</td>
						</tr>
					</table>
					<div class="an-1"><span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsave'];?>" />
						</span>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo SITE_URL; ?>/js/addselect.js"></script>
<script>
//选中支付方式的时候，显示对应的货币种类
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
//取消支付方式的时候，隐藏对应的货币种类
function select_no_cur(str,payment_name){
	//取该支付方式支持的货币种类str
	cur_array = str.split('|');
	for(i=0;i<cur_array.length;i++){
		//取其他支付方式，判断是否有该种货币的信息，并且判断是否勾选，如果没有勾选，则隐藏并且取消够先该货币种类
		cur_sign = false;
		$('#form_batch input[@type=hidden]').each(function(){//每种支付方式对应的货币字符串
			//判断其他的支付方式是否也存在该货币种类
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
		//说明其他支付方式没有该货币种类，则可以隐藏并且取消该货币的层和复选
		if(cur_sign == false){
			$("#div_cur_"+cur_array[i]).css("display",'none');
			$("#currency_"+cur_array[i]).attr("checked",false);
		}
	}
}
//调用商品类别
function tonext(whos) {
	$(whos).change(function(){
		var valarray=$(this).val().split('||');	
		$('#searchcate').val(valarray[0]);	
		if (valarray[1]=='1') {
			$(whos).nextAll('label').css('display','none');
			$(this).next().attr('disabled','true').html('<option value="" selected="selected"><?php echo $lang['langPDataToLoad'];?></option>');
			$.get('../member/own_productcate.php',{action:'list',id:valarray[0],random_number:Math.random()},function(data){
				DataArray = data.split("|||");var a='';for (var i = 0; i<DataArray.length-1; i++) {att=DataArray[i].split("||");id=att[0];cla=att[2];a+='<option value="'+id+'||'+cla+'">'+att[1]+((cla=='1')?' ->':'')+'</option>';};
				$(whos).next().removeAttr('disabled').html(a).nextAll().html('');
				tonext($(whos).next());
			})
		}else {
			$(whos).nextAll().html('selete').attr('disabled','true');
		};
	})
};

$(document).ready(function() {
	//商品类别
	tonext('#c1');
	//地区调用
	$('#adddiv').addSelect({
					ajaxUrl:'../home/tohtml.php',
					ajaxAction:'get_area',
					hiddenId:'area_id'
				});
	//表单验证
	$("#form_batch").validate({
		errorClass: "wrong",
		rules: {
			searchcate: {required: true},
			file: {required: true},
			area_id: {required: true}
		},
		messages: {
			searchcate: {required: "<?php echo $lang['errBatchProductClassIsEmpty'];?>"},
			file: {required: "<?php echo $lang['errBatchFileIsEmpty'];?>"},
			area_id: {required: "<?php echo $lang['errBatchAreaIsEmpty'];?>"}
		},
		submitHandler: function() {
			var check_sign = false;//货币选择状态标识
			var payment_check = false;//支付方式选择状态标识
			var payment_alert_sign = false;//支付方式是否抛出错误信息标识
			//验证支付方式的复选验证，是否全选，选中的支付方式是否选择了支付货币种类
			$("#form_batch input[@type=hidden]").each(function(){
				if(this.name.indexOf('payment_cur_') == 0){
					//判断支付方式是否被选择
					str = this.name.split('payment_cur_');//取支付方式名称 str[1]
					if($('#txtPayment_'+str[1]).attr('checked') == true){
						//取该支付方式的货币种类字符串
						str2 = $('#payment_cur_'+str[1]).val().split('|');
						payment_check = true;//标识有选择的支付方式
						//判断该选中的支付方式起码有一个支持的货币种类被选择
						for(i=0;i<str2.length;i++){
							if($('#currency_'+str2[i]).attr('checked') == true){
								check_sign = true;
								break;
							}
						}
						if(check_sign == false){//没有选择货币
							payment_alert_sign = true;
						}
					}
				}
				check_sign = false;
			});
			if(payment_alert_sign == false && payment_check == true){//判断是否有错误抛出并且选择了起码一种支付方式:没有
				document.getElementById('form_batch').submit();
			}else{
				alert("<?php echo $lang['errBatchPaymentIsEmpty'];?>");
				return false;
			}
		}
	});
});
</script>