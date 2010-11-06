<?php
if ( file_exists( BasePath . "/js/validate/member_shop.modi.html" ) ) {
	include_once( BasePath . "/js/validate/member_shop.modi.html" );
}
?>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langShopBaseInfo'];?></p></div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopBaseInfo']; ?></p></span></li>
					</ul>
				</div>
				<form id="modishop" name="modishop" action="own_shop.php?action=save_modi" method="post" enctype="multipart/form-data">
				<div class="cr-right">

					<input type="hidden" name="area_id" id="area_id" value="<?php echo $output['shop_info']['shop_area_id']; ?>" />
					<input type="hidden" name="now_check" id="now_check" value="<?php echo $output['shop_info']['ischeck']; ?>" />
					<input type="hidden" name="shop_grade" value="<?php echo $output['shop_info']['shop_grade']; ?>" />
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<?php if ( $output['shop_info']['ischeck'] == '0' ) { ?>
							<tr>
								<td height="39" colspan="2"><?php echo $lang['langShopAuditingPleaseWait']; ?></td>
							</tr>
						<?php } ?>
						<?php if ( $output['shop_info']['ischeck'] == '2' ) { ?>
							<tr>
								<td height="39" colspan="2"><?php echo $lang['langShopAuditingClose']; ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopName']; ?>:</td>
							<td class="cr-2">
								<input class="in" name="txtShopName" id="txtShopName" type="text" value="<?php echo $output['shop_info']['shop_name']; ?>" />
								<label style="display:none" for="txtShopName" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
						  <td class="cr-1"><?php echo $lang['langShopGrade']; ?>:</td>
						  <td class="cr-2" style="padding-top:20px; line-height:18px;"><?php echo $output['grade_info']['grade_name']; ?>&nbsp;<a href="own_shop.php?action=update_shop_grade"><?php echo $output['langShopGradeUpdate']; ?></a><span style="color:#999;"> <?php echo $output['grade_info']['grade_description']; ?>&nbsp;&nbsp;</span></td>
					  </tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopClass']; ?>:</td>
							<td class="cr-2">
								<select name="slcShopClass">
									<?php if ( is_array( $output['shop_select_category'] ) ) { ?>
										<?php foreach ( $output['shop_select_category'] as $list ) { ?>
											<option <?php if ( $list['class_id'] == $output['shop_info']['shop_class'] ) { ?> selected <?php } ?> value="<?php echo $list['class_id']; ?>"><?php echo $list['class_name']; ?></option>
											<?php if ( is_array( $list['child'] ) ) { ?>
												<?php foreach ( $list['child'] as $list2 ) { ?>
													<option <?php if ( $list2['class_id'] == $output['shop_info']['shop_class'] ) { ?> selected <?php } ?> value="<?php echo $list2['class_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $list2['class_name']; ?></option>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopSaleRange']; ?>:</td>
							<td class="cr-2"><textarea class="in" name="txtSaleRange" id="txtSaleRange" type="text"><?php echo $output['shop_info']['sale_range']; ?></textarea></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopAreaSet']; ?>:</td>
							<td class="cr-2">
								<div id="adddiv"></div>
								<label style="display:none" for="area_id" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopProclamation']; ?>:</td>
							<td class="cr-2"><span style=" float:left; clear:both"><textarea name="txtProclamation" cols="50" rows="5"><?php echo $output['shop_info']['proclamation']; ?></textarea></span></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopLogo']; ?>:</td>
							<td class="cr-2">
								<?php if ( $output['shop_info']['shop_pic'] != '' ) { ?>
									<li id="logo_li"><img height="100" width="100" src="<?php echo empty( $output['shop_info']['shop_pic'] ) ? TPL_DIR . '/images/storepic_default.gif' : SITE_URL . '/' . $output['shop_info']['shop_pic']; ?>" /></li>
								<?php } else { ?>
									<li id="logo_li"></li>
                                    
								<?php } ?><li class="mr-top"><span class="buttom-comm"><input type="button"  value="<?php echo $lang['langShopLogoEditor']; ?>" onclick="thumbnail_show();"/><input  type="hidden" value="" name="loge_hidden" id="loge_hidden" /></span></li>
								 <span class="buttom-comm"><input type="button"  value="<?php echo $lang['langCdele']; ?>" onclick="location.href='<?php echo SITE_URL; ?>/member/own_shop.php?action=dellogo'" /></span>
								<input type="hidden" name="hideShopId" value="2" />
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopBanner']; ?>:</td>
							<td class="cr-2">
								<?php if ( $output['shop_info']['shop_banner_pic'] != '' ) { ?>
								<li id="banner_li"><img height="62" width="478" src="<?php echo empty( $output['shop_info']['shop_banner_pic'] ) ? TPL_DIR . '/images/storepic_default.gif' : SITE_URL . '/' . $output['shop_info']['shop_banner_pic']; ?>" /></li>
								<?php } else { ?>
									<li id="banner_li"></li>
								<?php } ?><li class="mr-top"><span class="buttom-comm"><input type="button"  value="<?php echo $lang['langShopBannerEditor']; ?>" onclick="thumbnail_banner_show();"/><input  type="hidden" value="" name="banner_hidden" id="banner_hidden" /></span></li>
								 <span class="buttom-comm"><input type="button"  value="<?php echo $lang['langCdele']; ?>" onclick="location.href='<?php echo SITE_URL; ?>/member/own_shop.php?action=delbanner'" /></span>
					
								<input type="hidden" name="hideShopId" value="2" />
							</td>
						</tr>
					</table>
				</div>
				<div class="an-1"><span class="buttom-comm"><input name="" value="<?php echo $lang['langCsave']; ?>" type="submit" /></span></div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="../js/jquery1.4/jquery.imgareaselect.min.js"></script>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = 100 / selection.width; 
	var scaleY = 100 / selection.height; 
	
	$('#show_img').css({ 
		width: Math.round(scaleX * 500) + 'px', 
		height: Math.round(scaleY * 375) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 
 
$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
	


	$("form[name='photo']").ajaxForm();
	$("form[name='thumbnail']").ajaxForm();
}); 
function thumbnail_show()
{
	$('#logo_div').fadeIn();
	$('#thumbnail').imgAreaSelect({ onSelectChange: preview,x1: 200, y1: 150, x2: 300, y2: 250}); 
	$('#x1').val(200);
	$('#y1').val(150);

	$('#w').val(100);
	$('#h').val(100);
	
}
function thumbnail_banner_show()
{
	$('#banner_div').fadeIn();
	$('#thumbnail_banner').imgAreaSelect({ onSelectChange: preview_banner,x1: 10, y1:100 , x2: 490, y2:162 }); 
	$('#x1_b').val(10);
	$('#y1_b').val(100);

	$('#w_b').val(478);
	$('#h_b').val(62);
	
}
$(window).load(function () { 
	
	
	$(".imgareaselect-border2").live("dblclick",function(){submit_thumbnail();});
});
 function submit_photo()
 {
 	var option = {
		success: function(data) {
		
			$('#thumbnail').attr("src","<?php echo SITE_URL;?>/"+data);
			$('#show_img').attr("src","<?php echo SITE_URL;?>/"+data);
			$('#img_name').val(data)
			
		} 
	};
 	$("form[name='photo']").ajaxSubmit(option);
 	
 }
 function submit_thumbnail()
 {
	 if($('#img_name').val()!='')
	 {
			var option = {
				success: function(data) {
					$(".imgareaselect-selection").hide();
					$(".imgareaselect-border2").hide();
					$(".imgareaselect-border1").hide();
					$(".imgareaselect-outer").hide();
					$('#img_name').val("");
					$("#thumbnail").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
					$("#show_img").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
					$("#logo_div").fadeOut();
					$("#loge_hidden").val(data);
					$("#logo_li").html('<img height="100" width="100" src="<?php echo SITE_URL;?>/'+data+'">')
				} 
			};
			$("form[name='thumbnail']").ajaxSubmit(option);
	 }
	  if($('#img_name_banner').val()!='')
	 {
			var option = {
				success: function(data) {
					$(".imgareaselect-selection").hide();
					$(".imgareaselect-border2").hide();
					$(".imgareaselect-border1").hide();
					$(".imgareaselect-outer").hide();
					$('#img_name_banner').val("");
					$("#thumbnail_banner").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
					$("#show_img_banner").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
					$("#banner_div").fadeOut();
					$("#banner_hidden").val(data);
					$("#banner_li").html('<img height="62" width="478"  src="<?php echo SITE_URL;?>/'+data+'">')
				} 
			};
			$("form[name='thumbnail_banner']").ajaxSubmit(option);
	 }
 }
function close_pic()
{
	$(".imgareaselect-selection").hide();
	$(".imgareaselect-border2").hide();
	$(".imgareaselect-border1").hide();
	$(".imgareaselect-outer").hide();
	$("#logo_div").fadeOut();
	$("#banner_div").fadeOut();
	$('#img_name_banner').val("");
	$("#thumbnail_banner").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
	$("#show_img_banner").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
	$('#img_name').val("");
	$("#thumbnail").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
	$("#show_img").attr("src",'<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif');
}
</script>
<div  id="logo_div" style="display:none;position:fixed; top:100px; left:300px; background-color:#FFFFCC; width:700px">
		<div class="qi-z" align="center">
			<h2><?php echo $lang['langShopLogoEditor']; ?><span><img onclick="close_pic()" src="<?php echo SITE_URL;?>/templates/member/images/green_r3_close.gif"/></span></h2>
             <div class="clear-10"></div>
	<form name="photo" enctype="multipart/form-data" action="own_shop.php?action=pic_upload" method="post">
	<?php echo $lang['langShopLogoSelect']; ?> <input id="image" type="file" name="image" size="30" onchange="submit_photo()" />
	</form>
     <div class="clear-10"></div>
     
     	<div class="img-dv">
			<img src="<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif" id="thumbnail" alt="<?php echo $lang['langShopLogoOld']; ?>" />
            </div>
			<div class="t-s">
				<img style="width:500px; height:375px; margin-left: -200px; margin-top: -150px;" id="show_img" src="<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif" style="position: relative;" alt="<?php echo $lang['langShopLogoNew']; ?>" />
			</div>
			<div class="t-ss">
				<span style="color:#FF0000"><?php echo $lang['langShopLogoMessage']; ?></span>
			</div>
			<br style="clear:both;"/>
          
			<form name="thumbnail" action="own_shop.php?action=resizeThumbnailImage" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="hidden" name="img_name" value="" id="img_name" />
			</form>
           
		</div>
	
	

</div>
<script type="text/javascript"> 
function preview_banner(img, selection) { 
	var scaleX = 478 / selection.width; 
	var scaleY = 62 / selection.height; 
	
	$('#show_img_banner').css({ 
		width: Math.round(scaleX * 500) + 'px', 
		height: Math.round(scaleY * 375) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1_b').val(selection.x1);
	$('#y1_b').val(selection.y1);
	$('#x2_b').val(selection.x2);
	$('#y2_b').val(selection.y2);
	$('#w_b').val(selection.width);
	$('#h_b').val(selection.height);
} 

 function submit_photo_banner()
 {
 	var option = {
		success: function(data) {
		
			$('#thumbnail_banner').attr("src","<?php echo SITE_URL;?>/"+data);
			$('#show_img_banner').attr("src","<?php echo SITE_URL;?>/"+data);
			$('#img_name_banner').val(data)
			
		} 
	};
 	$("form[name='photo_banner']").ajaxSubmit(option);
 	
 }

</script>

<div  id="banner_div" style="display:none;position:fixed; top:10px; left:300px; background-color:#FFFFCC; width:700px">
		<div class="qi-z-1" align="center">
			<h2><?php echo $lang['langShopBannerEditor']; ?><span><img onclick="close_pic()" src="<?php echo SITE_URL;?>/templates/member/images/green_r3_close.gif"/></span></h2>
             <div class="clear-10"></div>
	<form name="photo_banner" enctype="multipart/form-data" action="own_shop.php?action=pic_upload" method="post">
	<?php echo $lang['langShopLogoSelect']; ?> <input id="image" type="file" name="image" size="30" onchange="submit_photo_banner()" />
	</form>
     <div class="clear-10"></div>
     
     	<div class="img-dv-1">
			<img src="<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif" id="thumbnail_banner" alt="<?php echo $lang['langShopLogoOld']; ?>" />
            </div>
			<div class="t-s-1">
				<img style="width: 498px; height: 375px; margin-left: -12px; margin-top: -100px;" id="show_img_banner" src="<?php echo SITE_URL;?>/templates/orange/images/noimgb.gif" style="position: relative;" alt="<?php echo $lang['langShopLogoNew']; ?>" />
			</div>
			<div class="t-ss-1">
				<span style="color:#FF0000"><?php echo $lang['langShopLogoMessage']; ?></span>
			</div>
			<br style="clear:both;"/>
          
			<form name="thumbnail_banner" action="own_shop.php?action=resizeThumbnailImageBanner" method="post">
				<input type="hidden" name="x1_b" value="" id="x1_b" />
				<input type="hidden" name="y1_b" value="" id="y1_b" />
				<input type="hidden" name="x2_b" value="" id="x2_b" />
				<input type="hidden" name="y2_b" value="" id="y2_b" />
				<input type="hidden" name="w_b" value="" id="w_b" />
				<input type="hidden" name="h_b" value="" id="h_b" />
				<input type="hidden" name="img_name_banner" value="" id="img_name_banner" />
			</form>
           
		</div>
	
	

</div>