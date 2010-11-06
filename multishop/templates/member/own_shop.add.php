<?php
if ( file_exists( BasePath . "/js/validate/member_shop.add.html" ) ) {
	include_once( BasePath . "/js/validate/member_shop.add.html" );
}
?>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langShopOpenSay']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopFreeSetUpShop']; ?></p></span></li>
					</ul>
				</div>
				<form id="addnews" action="own_shop.php?action=save" method="post">
				<input type="hidden" name="shop_grade" value="<?php echo intval($_GET['shop_grade']); ?>" />
				<div class="cr-right">

					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShoploginName']; ?>:</td>
							<td class="cr-2"><?php echo $_SESSION['s_login']['name']; ?></td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopName']; ?>:</td>
							<td class="cr-2">
								<span class="cr-5-span"><input class="in" name="txtShopName" id="txtShopName" type="text" value="<?php echo $output['shop_info']['shop_name']; ?>" />
								&nbsp;&nbsp;<?php echo $lang['langShopNameInfo']; ?></span>							</td>
						</tr>
						<tr>
						  <td class="cr-1"><?php echo $lang['langShopGrade']; ?>:</td>
						  <td class="cr-2"><?php echo $output['grade_info']['grade_name']; ?></td>
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
								</select>							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopAreaSet']; ?>:</td>
							<td class="cr-2">
								<input type="hidden" name="area_id" id="area_id" />
								<div id="adddiv"></div>
								<label style="display:none" for="area_id" class="wrong" metaDone="true" generated="true"></label>							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopIntro']; ?>:</td>
							<td class="cr-2">
							<?php
								include_once('../classes/resource/editor/editor.class.php');
								$editor=new editor('txtShopIntro');
								$editor->Value=$this->_tpl_vars['product_array']['p_intro'];
								$editor->BasePath='../classes/resource/editor';
								$editor->Height=460;
								$editor->Width=621;
								$editor->AutoSave=false;
								$editor->Create();
							?>							</td>
						</tr>
						<tr>
							<td class="cr-1"></td>
							<td class="cr-2">
								<input name="chkShopRule" type="checkbox" id="chkShopRule" onclick="changeSubmit();" value="1" />
								<label for="chkShopRule"><?php echo $lang['langShopAgreeAndComply']; ?></label>
							<a href="javascript:ShopAgreeshow();" ><?php echo $lang['langShopShowAgreeAndComply']; ?></a></td>
						</tr>
						<tr>
							<td id="ShopAgree" style="display:none" class="cr-1"><?php echo $lang['langShopAgree']; ?>:</td>
							<td id="ShopAgree" style="display:none" class="cr-2">
								<?php
								if ( file_exists( BasePath . "/html/shop_agreement.html" ) ) {
									include_once( BasePath . "/html/shop_agreement.html" );
								}
								?>							</td>
						</tr>
					</table>
					<table>
					</table>
				</div>
				<div class="an-1"><span class="buttom-comm"><input name="submit1" id="submit1" value="<?php echo $lang['langCsubmit']; ?>" type="submit" disabled="disabled" /></span></div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo SITE_URL; ?>/js/addselect.js"></script>
<script type="text/javascript">
function ShopAgreeshow()
{

	if($("#ShopAgree").css('display')=='none')
	{
		$("td[id='ShopAgree']").show();
	}else{
		$("td[id='ShopAgree']").hide();
	}
}
$(document).ready(function(){
	$('#adddiv').addSelect({
					ajaxUrl:'../home/tohtml.php',
					ajaxAction:'get_area',
					type:'modi',
					modi_id:'<?php echo $output['member_array']['area_id'];?>',
					hiddenId:'area_id'
				});
});
</script>