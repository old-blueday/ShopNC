<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langSStyleShopkeeperHello']; ?><?php echo $lang['langSStyleDiffer']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langSStyleShopCyclostyle']; ?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
    				<form action="own_shopstyle.php?action=save" method="post" name="formstyle">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-2">
								<span style="margin-right:5px;">
								<input type="radio" name="sel_type"  id="sel_type_1" style="vertical-align:middle" value="1" onclick="$('#div_sel_type').css('display','none');$('#div_custom').css('display','');" <?php if ( $output['shop_array']['templates'] == '1' ) { ?> checked="checked" <?php } ?> /><label for="sel_type_1"><?php echo $lang['langSStyleCustom']; ?></label>
								<input type="radio" name="sel_type" id="sel_type_0" style="vertical-align:middle"  value="0" onclick="$('#div_sel_type').css('display','');$('#div_custom').css('display','none');" <?php if ( $output['shop_array']['templates'] == '0' ) { ?> checked="checked" <?php } ?> /><label for="sel_type_0"><?php echo $lang['langSStyleDefault']; ?></label>
								</span>
								<span class="buttom-comm"><input id="view_my_store" type="button" onclick="window.open('<?php echo SITE_URL; ?>/store/?userid=<?php echo $_SESSION['s_login']['id']; ?>','_blank')" value="<?php echo $lang['langSStyleViewMyShop']; ?>"/></span>
							</td>
						</tr>
					</table>
					<div id="div_sel_type" <?php if ( $output['shop_array']['templates'] == '1' ) { ?> style="display:none" <?php } ?>>
						<div style="background-color:#FCFEFE; border:1px solid #DEEBEF; padding-bottom:10px">
						<div class="clear-10"></div>
							<div class="box_style">
                            	<h1 style=" float:left; padding-left:30px; *padding-left:60px; padding-top:1px; margin-right:5px;">
									<?php echo $lang['langSStyleSelectCyclostyle']; ?>
									<select id='current_template_option' name="rdoStyle" onchange="$('#displaystyle').attr('src','../templates/storestyle/'+this.value.split('|||')[0]+'/thumb_preview.gif');">
									<?php if ( !empty( $output['style_array'] ) && is_array( $output['style_array'] ) ) { ?>
										<?php foreach ( $output['style_array'] as $list ) { ?>
											<option value="<?php echo $list['file']; ?>|||<?php echo $list['info']; ?>" <?php if ( $output['shop_array']['shop_style'] == $list['file'] ) { ?> selected <?php } ?>><?php echo $list['name']; ?></option>
										<?php } ?>
									<?php } ?>
									</select></h1><span class="buttom-comm-1" style=" float:left;"><input class="input-a" type="button" onclick="window.open('<?php echo $output['site_url']; ?>/store/index.php?templates_show=0&userid=<?php echo $output['member_id']; ?>&ispreview=1&shop_style='+$('#current_template_option').val().split('|||')[0],'_blank')" class="submit" value="<?php echo $lang['langSStylePreview']; ?>" /></span> <span class="buttom-comm-1" style=" float:left; margin-left:3px;"><input class="input-a" id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsave'];?>" /></span>
                                    <div class="clear-10"></div>
								<div style=" border:1px solid #10A3D2; display:block; width:300px; padding:3px clear:both;">
									<?php if ( $output['shop_array']['templates'] == '0' ) { ?>
										<img src="../templates/storestyle/<?php echo $output['shop_array']['shop_style']; ?>/thumb_preview.gif" name="displaystyle" id="displaystyle" />
									<?php } else { ?>
										<img src="../templates/storestyle/04/thumb_preview.gif" name="displaystyle" id="displaystyle" />
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div id="div_custom" <?php if ( $output['shop_array']['templates'] != '1' ) { ?> style="display:none" <?php } ?>>
						<div style="background-color:#FCFEFE; border:1px solid #DEEBEF; padding-bottom:10px">
						<div class="clear-10"></div>
							<div class="box_style">
								<h1 style=" float:left; padding-left:70px; *padding-left:100px; padding-top:5px; margin-right:5px;"><?php echo $lang['langSStyleCustom']; ?></h1><span class="buttom-comm-1" style=" float:left;"><input class="input-a" type="button" onclick="window.open('<?php echo $output['site_url']; ?>/store/index.php?templates_show=1&userid=<?php echo $output['member_id']; ?>&ispreview=1&shop_style='+$('#current_template_option').val().split('|||')[0],'_blank')" class="submit" value="<?php echo $lang['langSStylePreview']; ?>" /></span><span style=" float:left; margin-left:3px;" class="buttom-comm-1"> <input class="input-a" id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCedit'];?>" /></span>
                                <div class="clear-10"></div>
								<div style=" border:1px solid #10A3D2; display:block; width:300px; padding:3px; clear:both;">
									<img src="../templates/storestyle/custom_preview.gif" />
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>