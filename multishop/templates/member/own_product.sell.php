<link href="<?php echo TPL_DIR; ?>/css/publish_category.css" rel="stylesheet" >
<div id=yui-main>
	<div class=yui-b>
		<div class=yui-g>
			<div class='y-middle' id="y-middle">
				<div class=io-3>
					<P><?php echo $lang['langPSellRemark']; ?></P>
				</div>
				<div class=clear-9></div>
				<div class="bg-sj bg-wu"></div>
				<div class=clear-9></div>
				<div id="services04">
					<ul >
						<li class="tu01"><a href='javascript:;' onclick='changeSellType("0");'></a></li>
						<li class="tu02"><a href='javascript:;' onclick='changeSellType("1");'></a></li>
						<li class="tu03"><a href='javascript:;' onclick='changeSellType("2");'></a></li>
						<li class="tu04"><a href='javascript:;' onclick='changeSellType("3");'></a></li>
					</ul>
				</div>
				<div class=cr-right>
					<div class="category-extra">
						<dl>
						<dt id="TradeTypespan"><span style="color:#FF0000;"><?php echo $lang['langPTradeTypeCheched'];?></span></dt>
								<dt id="TradeTypedt" style="display:none"><?php echo $lang['langPTradeType'];?>&nbsp;:&nbsp; </dt>
								<dt id="TradeTypedd" style="display:none;color:#FF0000; font:bold 14px/24px Verdana, Arial;">
								</dt>
							
						</dl>
					</div>
					<div id="class_div" class="cascading-container">
						<div id="class_div_1" class="part01">
							<ul>
								<?php if(!empty($output['top_cate']) && is_array($output['top_cate'])){ ?>
								<?php foreach($output['top_cate'] as $k => $v){ ?>
								<li <?php if($v['is_parent']== '1'){ ?>class="parent"<?php } ?>  onclick="selClass(this);" id="<?php echo $v['id'];?>|<?php echo $v['is_parent']; ?>|1"> <span ><a href="javascript:;"><?php echo $v['name'];?></a></span> </li>
								<?php } ?>
								<?php } ?>
							</ul>
						</div>
						<div id="class_div_2" class="part01">
							<ul>
							</ul>
						</div>
						<div id="class_div_3" class="part01">
							<ul>
							</ul>
						</div>
						<div id="class_div_4"  class="part01">
							<ul>
							</ul>
						</div>
					</div>
					<div class="category-extra">
						<dl>
							<dt  id="commodityspan" ><span style="color:#FF0000;"><?php echo $lang['langPCommodityCategoryCheched'];?></span></dt>
								<dt id="commoditydt" style="display:none"><?php echo $lang['langPSellChecked'];?>&nbsp;:&nbsp;</dt>
								<dt id="commoditydd" style="display:none; color:#FF0000; font:bold 14px/24px Verdana, Arial;"></dt>
					       </dl>
					</div>
					<div class="an-5 bg-an" style="width:200px;"> <span class="buttom-comm" >
						<form name="form_sel_class" id="form_sel_class" action="" method="post" >
							<input type="hidden" name="p_sell_type" id="p_sell_type" value="" />
							<input type="hidden" name="pc_id" id="pc_id" value="" />
							<input type="hidden" name="p_code" id="p_code" value="<?php echo $output['p_code'];?>" />
							<input type="submit" id='button_next_step' value="<?php echo $lang['langPNextStep']; ?>" />
						</form>
						</span> </div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div id=block_location style="display: none"><img style=" top:50px; left:100px;position:absolute; " src="<?php echo TPL_DIR; ?>/images/load_info.gif" /></div>
<div id='block_location_2' style="display: none"></div>
<script language="javascript" type="text/javascript">
function changeSellType(type){
	$("#TradeTypespan").hide();
	$("#TradeTypedt").show();
	$("#TradeTypedd").show();
	if(type == '0' || type == '1' || type == '2' || type == '3'){
		$(".tu01").children('a').attr('class','');
		$(".tu02").children('a').attr('class','');
		$(".tu03").children('a').attr('class','');
		$(".tu04").children('a').attr('class','');
		switch(type){
			case '0':
				$('#TradeTypedd').html('<?php echo $lang['langPauction'];?>');
				$(".tu01").children('a').attr('class','click');
				if($('#p_code').val() != ''){
					var url = "own_product_auction.php?action=modi&p_code="+$('#p_code').val();
				}else {
					var url = "own_product_auction.php?action=add";
				}
				break;
			case '1':
				$('#TradeTypedd').html('<?php echo $lang['langPfixprice'];?>');
				$(".tu02").children('a').attr('class','click');
				if($('#p_code').val() != ''){
					var url = "own_product_fixprice.php?action=modi&p_code="+$('#p_code').val();
				}else {
					var url = "own_product_fixprice.php?action=add";
				}
				break;
			case '2':
				$('#TradeTypedd').html('<?php echo $lang['langPcamel'];?>');
				$(".tu03").children('a').attr('class','click');
				var url = "own_product_group.php?action=add";
				break;
			case '3':
				$('#TradeTypedd').html('<?php echo $lang['langPcountdown'];?>');
				$(".tu04").children('a').attr('class','click');
				var url = "own_product_countdown.php?action=add";
				break;				

		}
		$('#p_sell_type').val(type);
		$('#form_sel_class').attr('action',url);
		disabledButton();
		return true;
	}else {
		return false;
	}
}
function selClass(obj){
	$("#commodityspan").hide();
	$("#commoditydt").show();
	$("#commoditydd").show();
	$(obj).siblings('li').children('span').children('a').attr('class','');
	$(obj).children('span').children('a').attr('class','classDivClick')
	var tmp_array = obj.id.split('|');
	tonextClass(obj.id);
}
function showClassName(){

}
function tonextClass(text){
	//valarray[0] = id valarray[1] = is_parent(0=no 1=yes) valarray[2] = deep(1-4)
	var valarray = text.split('|');
	$('#pc_id').val(valarray[0]);
	disabledButton();
	if(valarray[1] == '1'){
		showBlock();
		$.get(
			'../member/own_productcate.php',
			{action:'list',id:valarray[0],random_number:Math.random()},
			function(data){
				DataArray = data.split("|||");
				var a='';
				var class_div_id = parseInt(valarray[2])+1;
				for (var i = 0; i<DataArray.length-1; i++) {
					att=DataArray[i].split("||");
					id=att[0];
					name=att[1];
					cla=att[2];
					a+='<li '+((cla=='0')?'':'class="parent"')+' onclick="selClass(this);" id="'+id+'|'+cla+'|'+class_div_id+'"><span><a href="javascript:;">'+name+'</a></span></li>';
				}
				$('#class_div_'+class_div_id).children('ul').empty();
				$('#class_div_'+class_div_id).children('ul').append(a);
				$('#class_div_'+class_div_id).nextAll('div').children('ul').empty();
				var str="";
				$.each($('a[class=classDivClick]'),function(i){
					str+=$(this).html()+"&nbsp;>>&nbsp;";
				});
				str=str.substring(0,str.length-14);
				$('#commoditydd').html(str);
				displayBlock();
			}
		)
		return true;
	}else {
		$('#class_div_'+parseInt(valarray[2])).nextAll('div').children('ul').empty();
		var str="";
		$.each($('a[class=classDivClick]'),function(i){
			str+=$(this).html()+"&nbsp;>>&nbsp;";
		});
		str=str.substring(0,str.length-14);
		$('#commoditydd').html(str);
		return false;
	}
}
function showBlock(){
var top = $('#class_div').offset().top;
	var left = $('#class_div').offset().left;
	var width = $('#class_div').css('width');
	var height = $('#class_div').css('height');
	$('#block_location').css({
		'display':'block',
		'left':left+'px',
		'top':top+'px',
		'position':'absolute',
		'width':width,
		'height':height,
		'z-index':9999
	});
	$('#block_location_2').css({
		'display':'block',
		'left':left+'px',
		'top':top+'px',
		'position':'absolute',
		'width':width,
		'height':height,
		'z-index':9999,
		'background-color': 'rgb(255, 255, 255)',
		'opacity':0
	})
}
//submit button
function displayBlock(){
	$('#block_location').css({
		'display':'none'
	})
	$('#block_location_2').css({
		'display':'none'
	})
}
function disabledButton(){
	if($('#p_sell_type').val() != '' && $('#pc_id').val() != ''){
		$('#button_next_step').attr('disabled',false);
	}else {
		$('#button_next_step').attr('disabled',true);
	}
}
</script>
