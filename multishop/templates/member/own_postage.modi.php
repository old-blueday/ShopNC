<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langPostageModi'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPostageModi'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
				<form action="own_postage.php?action=update" method="post" id="form_postage">
					<input type="hidden" name="postage_id" value="<?php echo $output['postage_array']['postage_id'];?>" />
					<input type="hidden" name="product_sel" value="<?php echo $output['product_sel'];?>" />
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langPostageTitle'];?>:</td>
							<td class="cr-2"><input type="text" name="postage_title" class="in-2" id="postage_title" value="<?php echo $output['postage_array']['postage_title'];?>" /></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPostageType'];?>:</td>
							<td class="cr-2">
								<input type="checkbox" name="postage_ordinary" id="postage_ordinary" value="1" onclick="show_ordinary();" /><label for="postage_ordinary"><?php echo $lang['langPostageOrdinary'];?></label>
								<div id="div_postage_ordinary" style="display:none">
									<?php echo $lang['langPostageSetDefault'];?>:<input class="input-120" type="text" name="default_ordinary" id="default_ordinary" value="10" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetDefaultUp'];?>:<input class="input-120" type="text" name="default_up_ordinary" id="default_up_ordinary" value="0.0" /><?php echo $lang['langCYuan'];?><br /><br />
									<div style="color:#ff6600; cursor:pointer;" onclick="show_area('ordinary',this);"><?php echo $lang['langPostageSetToArea'];?></div>
									<!---->
									<?php if(count($output['postage_array']['postage_ordinary']) > 1){?>
									<?php for($i=0;$i<(count($output['postage_array']['postage_ordinary'])-1);$i++){?>
										<div>
										<br />
											<input type="hidden" name="ordinary_area_name_<?php echo $i;?>" id="ordinary_area_name_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_ordinary'][$i][0];?>" />
											<?php echo $lang['langPostageTo'];?><input type="text" class="quantity" id="ordinary_area_text_<?php echo $i;?>" onclick='edit_show_area("ordinary",this,"<?php echo $i;?>");' value="<?php echo $output['postage_array']['postage_ordinary'][$i]['area_name'];?>" readonly /><?php echo $lang['langPostageToMoney'];?>:<input type="text" class="quantity_postage" name="ordinary_area_postage_<?php echo $i;?>" id="ordinary_area_postage_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_ordinary'][$i][1];?>" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetUp'];?>:<input class="quantity_postage_up" type="text" name="ordinary_area_postage_up_<?php echo $i;?>" id="ordinary_area_postage_up_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_ordinary'][$i][2];?>" /><?php echo $lang['langCYuan'];?> <a href="javascript:;" onclick="if(confirm('<?php echo $lang['langCConfirmDelete'];?>')){del_row(this);}else{return false;}"><?php echo $lang['langCdele'];?></a>
										</div>
									<?php } ?>
									<?php } ?>
								</div>
								<br />
								<input type="checkbox" name="postage_fast" id="postage_fast" value="1" onclick="show_fast();" /><label for="postage_fast"><?php echo $lang['langPostageFast'];?></label>
								<div id="div_postage_fast" style="display:none">
									<?php echo $lang['langPostageSetDefault'];?>:<input class="input-120" type="text" name="default_fast" id="default_fast" value="10" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetDefaultUp'];?>:<input class="input-120" type="text" name="default_up_fast" id="default_up_fast" value="0.0" /><?php echo $lang['langCYuan'];?><br /><br />
									<div style="color:#ff6600; cursor:pointer;" onclick="show_area('fast',this);"><?php echo $lang['langPostageSetToArea'];?></div>
									<!---->
									<?php if(count($output['postage_array']['postage_fast']) > 1){?>
									<?php for($i=0;$i<(count($output['postage_array']['postage_fast'])-1);$i++){?>
										<div>
											<input type="hidden" name="fast_area_name_<?php echo $i;?>" id="fast_area_name_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_fast'][$i][0];?>" />
											<?php echo $lang['langPostageTo'];?><input type="text" class="quantity" id="fast_area_text_<?php echo $i;?>" onclick='edit_show_area("fast",this,"<?php echo $i;?>");' value="<?php echo $output['postage_array']['postage_fast'][$i]['area_name'];?>" readonly />
											<?php echo $lang['langPostageToMoney'];?>:<input type="text" class="quantity_postage" name="fast_area_postage_<?php echo $i;?>" id="fast_area_postage_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_fast'][$i][1];?>" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetUp'];?>:<input class="quantity_postage_up" type="text" name="fast_area_postage_up_<?php echo $i;?>" id="fast_area_postage_up_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_fast'][$i][2];?>" /><?php echo $lang['langCYuan'];?> <a href="javascript:;" onclick="if(confirm('<?php echo $lang['langCConfirmDelete'];?>')){del_row(this);}else{return false;}"><?php echo $lang['langCdele'];?></a>
										</div>
									<?php } ?>
									<?php } ?>
								</div>
								<br />
								<input type="checkbox" name="postage_ems" id="postage_ems" value="1" onclick="show_ems();" /><label for="postage_ems"><?php echo $lang['langPostageEMS'];?></label>
								<div id="div_postage_ems" style="display:none">
									<?php echo $lang['langPostageSetDefault'];?>:<input class="input-120" type="text" name="default_ems" id="default_ems" value="10" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetDefaultUp'];?>:<input class="input-120" type="text" name="default_up_ems" id="default_up_ems" value="0.0" /><?php echo $lang['langCYuan'];?><br /><br />
									<div style="color:#ff6600; cursor:pointer;" onclick="show_area('ems',this);"><?php echo $lang['langPostageSetToArea'];?></div>
									<!---->
									<?php if(count($output['postage_array']['postage_ems']) > 1){?>
									<?php for($i=0;$i<(count($output['postage_array']['postage_ems'])-1);$i++){?>
										<div>
											<input type="hidden" name="ems_area_name_<?php echo $i;?>" id="ems_area_name_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_ems'][$i][0];?>" />
											<?php echo $lang['langPostageTo'];?><input type="text" class="quantity" id="ems_area_text_<?php echo $i;?>" onclick='edit_show_area("ems",this,"<?php echo $i;?>");' value="<?php echo $output['postage_array']['postage_ems'][$i]['area_name'];?>" readonly />
											<?php echo $lang['langPostageToMoney'];?>:<input type="text" class="quantity_postage" name="ems_area_postage_<?php echo $i;?>" id="ems_area_postage_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_ems'][$i][1];?>" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetUp'];?>:<input class="quantity_postage_up" type="text" name="ems_area_postage_up_<?php echo $i;?>" id="ems_area_postage_up_<?php echo $i;?>" value="<?php echo $output['postage_array']['postage_ems'][$i][2];?>" /><?php echo $lang['langCYuan'];?> <a href="javascript:;" onclick="if(confirm('<?php echo $lang['langCConfirmDelete'];?>')){del_row(this);}else{return false;}"><?php echo $lang['langCdele'];?></a>
										</div>
									<?php } ?>
									<?php } ?>
								</div>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langPostageContent'];?>:</td>
							<td class="cr-2"><textarea name="postage_content" id="postage_content" cols="50" rows="5"><?php echo $output['postage_array']['postage_content'];?></textarea></td>
						</tr>
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsave'];?>" />
						</span>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="area_location" style="display:none" itemid="">
<div style="float:right;"><a href="javascript:;" class="btn_hide_area cha"></a></div>
<div style=" float:left; width:425px;"><?php if(!empty($output['sel_area']) && is_array($output['sel_area'])){ ?>
<?php foreach($output['sel_area'] as $k => $v){ ?>
	<input class="area" type="checkbox" id="sel_area_<?php echo $v['0'];?>" value="<?php echo $v['0'];?>" /><label for="sel_area_<?php echo $v['0'];?>"><?php echo $v['2'];?></label>
<?php } ?>
<?php } ?></div>
<div style=" float:left; padding-left:380px; width:150px; padding-top:10px; clear:both;"><input type="button" value="<?php echo $lang['langCEnsure'];?>" class="btn_submit_area" /><input type="button" class="btn_hide_area" value="<?php echo $lang['langCcancel'];?>" /></div>
</div>
<!---->
<textarea style="display:none" id="area_input_template">
	<div>
		<input type="hidden" name="{1}_area_name_{2}" id="{1}_area_name_{2}" value="{3}" />
		<?php echo $lang['langPostageTo'];?><input type="text" class="quantity" id="{1}_area_text_{2}" onclick='edit_show_area("{1}",this,"{2}");' value="{0}" readonly /><?php echo $lang['langPostageToMoney'];?>:<input type="text" class="quantity_postage" name="{1}_area_postage_{2}" id="{1}_area_postage_{2}" value="" /><?php echo $lang['langCYuan'];?>,<?php echo $lang['langPostageSetUp'];?>:<input type="text" name="{1}_area_postage_up_{2}" id="{1}_area_postage_up_{2}" value="0.0" /><?php echo $lang['langCYuan'];?> <a href="javascript:;" onclick="if(confirm('<?php echo $lang['langCConfirmDelete'];?>')){del_row(this);}else{return false;}"><?php echo $lang['langCdele'];?></a>
	</div>
</textarea>
<script>
// area array
var changeArea = new Array();
<?php if(!empty($output['sel_area']) && is_array($output['sel_area'])){?>
<?php foreach($output['sel_area'] as $k => $v){?>	
changeArea[<?php echo $v[0];?>] = '<?php echo $v[2];?>';
<?php } ?>
<?php } ?>
//
function show_ordinary(){
	display_sign = $('#postage_ordinary').attr('checked')?'':'none';
	$("#div_postage_ordinary").css('display',display_sign);
	delete(display_sign);
}
function show_fast(){
	display_sign = $('#postage_fast').attr('checked')?'':'none';
	$("#div_postage_fast").css('display',display_sign);
	delete(display_sign);
}
function show_ems(){
	display_sign = $('#postage_ems').attr('checked')?'':'none';
	$("#div_postage_ems").css('display',display_sign);
	delete(display_sign);
}
function show_area(type,obj){
	var top = $(obj).offset().top+20;
	var left = $(obj).offset().left;
	$('#area_location').css({
		'display':'block',
		'left':left+'px',
		'top':top+'px',
		'position':'absolute',
		'background':'none repeat scroll 0 0 #FFFBE7',
		'border':'2px solid #9EBEEC',
		'padding':'5px',
		'width':'450px'
	}).attr('itemid',type);
}
$(document).ready(function(){
	var ordinary_id = <?php echo (count($output['postage_array']['postage_ordinary'])=='0')?'1':count($output['postage_array']['postage_ordinary']); ?>;
	var fast_id = <?php echo (count($output['postage_array']['postage_fast'])=='0')?'1':count($output['postage_array']['postage_fast']); ?>;
	var ems_id = <?php echo (count($output['postage_array']['postage_ems'])=='0')?'1':count($output['postage_array']['postage_ems']); ?>;
	function submit_area(){
		var str = '';
		var str_id = '';
		var location_id = $('#area_location').attr('itemid');
		$(".area").each(function(){
			if($(this).attr('checked') == true){
				if(typeof(changeArea[$(this).val()]) !== "undefined"){
					str += changeArea[$(this).val()]+',';
					str_id += $(this).val()+',';
				}
			}
		});
		if(str == ''){
			alert('<?php echo $lang['errPostageSelArea']; ?>');
			return false;
		}
		hide_area();
		if(edit_id > 0){
			edit_area(location_id,str,str_id);
		}else{
			add_area(location_id,str,str_id);
		}
	}
	function hide_area(){
		$(".area").each(function(){
			$(this).attr('checked',false);
		});
		$('#area_location').css('display','none');
	}
	var template = jQuery.format($("#area_input_template").val());
	function add_area(location_id,str,str_id) {
		switch(location_id){
			case 'ordinary':
				index_id = ordinary_id++;
				break;
			case 'fast':
				index_id = fast_id++;
				break;
			case 'ems':
				index_id = ems_id++
				break;
		}
		$(template(str,location_id,index_id,str_id)).appendTo("#div_postage_"+location_id);
	}
	function edit_area(location_id,str,str_id) {
		$('#'+location_id+'_area_name_'+edit_id).val(str_id);
		$('#'+location_id+'_area_text_'+edit_id).val(str);
		edit_id = 0;
	}
	//area submit
	$(".btn_submit_area").click(submit_area);
	//area hide 
	$(".btn_hide_area").click(hide_area);
	
	//validate
	$("#form_postage").validate({
		rules: {
			postage_title:{required: true,maxlength:25},
			default_ordinary:{required: "#postage_ordinary:checked",number:"#postage_ordinary:checked",min:validate_ordingary_min,max:validate_ordingary_max},
			default_up_ordinary:{required: "#postage_ordinary:checked",number:"#postage_ordinary:checked",min:validate_ordingary_min,max:validate_ordingary_up_max},
			default_fast:{required: "#postage_fast:checked",number:"#postage_fast:checked",min:validate_fast_min,max:validate_fast_max},
			default_up_fast:{required: "#postage_fast:checked",number:"#postage_fast:checked",min:validate_fast_min,max:validate_fast_up_max},
			default_ems:{required: "#postage_ems:checked",number:"#postage_ems:checked",min:validate_ems_min,max:validate_ems_max},
			default_up_ems:{required: "#postage_ems:checked",number:"#postage_ems:checked",min:validate_ems_min,max:validate_ems_up_max},
			postage_content:{maxlength:200}
		},
		messages: {
			postage_title: {required: "<?php echo $lang['errPostageTitleIsEmpty'];?>",maxlength:"<?php echo $lang['errPostageTitleIsEmpty'];?>"},
			default_ordinary:{required: "<?php echo $lang['errPostageDefaultIsEmpty'];?>",number:"<?php echo $lang['errPostageDefaultIsEmpty'];?>",min:'<?php echo $lang['errPostageDefaultIsEmpty'];?>',max:'<?php echo $lang['errPostageDefaultIsEmpty'];?>'},
			default_up_ordinary:{required: "<?php echo $lang['errPostageDefaultUpIsEmpty'];?>",number:"<?php echo $lang['errPostageDefaultUpIsEmpty'];?>",min:'<?php echo $lang['errPostageDefaultUpIsEmpty'];?>',max:'<?php echo $lang['errPostageDefaultUpIsEmpty'];?>'},
			default_fast:{required: "<?php echo $lang['errPostageDefaultIsEmpty'];?>",number:"<?php echo $lang['errPostageDefaultIsEmpty'];?>",min:'<?php echo $lang['errPostageDefaultIsEmpty'];?>',max:'<?php echo $lang['errPostageDefaultIsEmpty'];?>'},
			default_up_fast:{required: "<?php echo $lang['errPostageDefaultUpIsEmpty'];?>",number:"<?php echo $lang['errPostageDefaultUpIsEmpty'];?>",min:'<?php echo $lang['errPostageDefaultUpIsEmpty'];?>',max:'<?php echo $lang['errPostageDefaultUpIsEmpty'];?>'},
			default_ems:{required: "<?php echo $lang['errPostageDefaultIsEmpty'];?>",number:"<?php echo $lang['errPostageDefaultIsEmpty'];?>",min:'<?php echo $lang['errPostageDefaultIsEmpty'];?>',max:'<?php echo $lang['errPostageDefaultIsEmpty'];?>'},
			default_up_ems:{required: "<?php echo $lang['errPostageDefaultUpIsEmpty'];?>",number:"<?php echo $lang['errPostageDefaultUpIsEmpty'];?>",min:'<?php echo $lang['errPostageDefaultUpIsEmpty'];?>',max:'<?php echo $lang['errPostageDefaultUpIsEmpty'];?>'},
			postage_content:{maxlength:"<?php echo $lang['errPostageContentIsLang'];?>"}	
		},
		submitHandler:function(form) { 
			if($('#postage_ordinary').attr('checked') == false && $('#postage_fast').attr('checked') == false && $('#postage_ems').attr('checked') == false){
				alert('<?php echo $lang['errPostageSelEmpty'];?>');//return false;
			}else{
				form.submit();
			}
		}
	});
	//
	$.validator.addMethod("quantity_postage", function(value, element) {
		if($.trim(value)){
			result = value*1 >= 0.01 && 999.99 >= value*1;
		}else{
			result = false;
		}
		return !this.optional(element) && result;
	}, "<?php echo $lang['errPostageDefaultIsEmpty'];?>");
	$.validator.addMethod("quantity_postage_up", function(value, element) {
		tmp_id = $(element).attr('id');
		replace_tmp_id = tmp_id.replace('area_postage_up','area_postage');
		if($.trim(value)){
			result = value*1 >= 0 && $('#'+replace_tmp_id).val()*1 >= value*1;
		}else{
			result = false;
		}
		return !this.optional(element) && result;
	}, "<?php echo $lang['errPostageDefaultUpIsEmpty'];?>");
	
	//validate function 
	function validate_ordingary_min(){
		if($('#postage_ordinary').attr('checked') == true){
			return 0;
		}else{
			false;
		}
	}
	function validate_ordingary_max(){
		if($('#postage_ordinary').attr('checked') == true){
			return 999.99;
		}else{
			false;
		}
	}
	function validate_ordingary_up_max(){
		if($('#postage_ordinary').attr('checked') == true){
			return $('#default_ordinary').val();
		}else{
			false;
		}
	}
	function validate_fast_min(){
		if($('#postage_fast').attr('checked') == true){
			return 0;
		}else{
			false;
		}
	}
	function validate_fast_max(){
		if($('#postage_fast').attr('checked') == true){
			return 999.99;
		}else{
			false;
		}
	}
	function validate_fast_up_max(){
		if($('#postage_fast').attr('checked') == true){
			return $('#default_fast').val();
		}else{
			false;
		}
	}
	function validate_ems_min(){
		if($('#postage_ems').attr('checked') == true){
			return 0;
		}else{
			false;
		}
	}
	function validate_ems_max(){
		if($('#postage_ems').attr('checked') == true){
			return 999.99;
		}else{
			false;
		}
	}
	function validate_ems_up_max(){
		if($('#postage_ems').attr('checked') == true){
			return $('#default_ems').val();
		}else{
			false;
		}
	}
})
//
var edit_id = 0;
function edit_show_area(type,obj,id){
	edit_id = id;
	//area checked
	checkbox_area_array = Array();
	checkbox_area_array = $('#'+type+'_area_name_'+id).val().split(',');
	for(i=0;i<checkbox_area_array.length;i++){
		if(checkbox_area_array[i]){
			$('#sel_area_'+checkbox_area_array[i]).attr('checked',true);
		}
	}
	show_area(type,obj);
}
function del_row(obj){
	$(obj).parent().remove();
}
//edit
$(document).ready(function(){
	<?php if(!empty($output['postage_array']['postage_ordinary'])){?>
		$('#postage_ordinary').trigger('click');
		$('#div_postage_ordinary').css('display','block');
		$('#default_ordinary').val('<?php echo $output['postage_array']['postage_ordinary']['default']['default']; ?>');
		$('#default_up_ordinary').val('<?php echo $output['postage_array']['postage_ordinary']['default']['default_up']; ?>');
	<?php } ?>
	<?php if(!empty($output['postage_array']['postage_fast'])){?>
		$('#postage_fast').trigger('click');
		$('#div_postage_fast').css('display','block');
		$('#default_fast').val('<?php echo $output['postage_array']['postage_fast']['default']['default']; ?>');
		$('#default_up_fast').val('<?php echo $output['postage_array']['postage_fast']['default']['default_up']; ?>');
	<?php } ?>
	<?php if(!empty($output['postage_array']['postage_ems'])){?>
		$('#postage_ems').trigger('click');
		$('#div_postage_ems').css('display','block');
		$('#default_ems').val('<?php echo $output['postage_array']['postage_ems']['default']['default']; ?>');
		$('#default_up_ems').val('<?php echo $output['postage_array']['postage_ems']['default']['default_up']; ?>');
	<?php } ?>
});
</script>