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
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopSelectGrade']; ?></p></span></li>
					</ul>
				</div>
				<form id="addnews" action="own_shop.php?action=save" method="post">
				<div class="cr-right">

					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr >
							<td class="cr-1Title"><?php echo $lang['langGradeName']; ?></td>
							<td class="cr-1Title"><?php echo $lang['langGradeGoodsNum']; ?></td>
							<td class="cr-1Title"><?php echo $lang['langGradeConfirm']; ?></td>
							<td class="cr-1Title"><?php echo $lang['langGradeCost'] ?></td>
							<td class="cr-1Title"><?php echo $lang['langGradeDescription']; ?></td>
							<td class="cr-1Title">&nbsp;</td>
						</tr>
						<?php foreach ($output['grade_array'] as $key => $val) { ?>
						<tr>
							<td class="cr-1list"><?php echo $val['grade_name']; ?></td>
							<td class="cr-1list"><?php if ($val['goods_num'] == 0) echo $lang['langGradeFreeNum']; else echo $val['goods_num']; ?></td>
							<td class="cr-1list"><?php if ($val['shop_confirm'] == 1) echo $lang['langGradeYes']; else echo $lang['langGradeNo']; ?></td>
							<td class="cr-1list"><?php echo $val['cost']; ?></td>
							<td class="cr-1list" style="text-align:left; padding-left:5px;"><?php echo $val['grade_description']; ?></td>
							<td class="cr-1list" style=" padding-left:22px;"><span class="buttom-comm"><input type="button" name="submit1" value="<?php echo $lang['langShopCreateShop']; ?>" onclick="window.location.href='own_shop.php?action=new&shop_grade=<?php echo $val['grade_id']; ?>'" /></span></td>
						</tr>
						<?php } ?>
					</table>
					<table>
					</table>
				</div>
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