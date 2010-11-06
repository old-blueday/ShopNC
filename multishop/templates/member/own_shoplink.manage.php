<script language='javascript'>
$(function(){
	$("#formaddlink").validate({
		errorClass: "wrong",
		rules: {
			txtMemberName: {required:true}
		},
		messages: {
			txtMemberName: {required: "<?php echo $lang['langShopUserNameNone']; ?>"}
		}
	});
})
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p>
			  			<?php echo $lang['langShopLLinkInfo']; ?>
					</p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopLFirendLink']; ?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">		
				<?php if( !empty($output['shop_link_array']) && is_array($output['shop_link_array']) ){ ?>	
					<table class="unite-table-1 unite-table-b"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-1">
							<td class="td-bg-1" style="width:20%; text-align:center; "><?php echo $lang['langShopLName'];?></td>
							<td class="td-bg-7"><?php echo $lang['langCOperation'];?></td>
						</tr>
						<?php foreach($output['shop_link_array'] as $list ){ ?>
							<tr class="tr-un-conter-1" >
								<td><?php echo $list['shop_name']; ?></td>
								<td><a href="own_shoplink.php?action=del&classid=<?php echo $list['link_id']; ?>" ><?php echo $lang['langCdele'];?></a></td>
							</tr>
						<?php } ?>				
					</table>
					<?php } ?>
				</div>
				<table cellpadding="0" border="0" width="100%" class="cr-r-td" style="margin-top:10px;">
					<form name="formaddlink" id="formaddlink" action="own_shoplink.php?action=save" method="post">
					<tr>
						<td class="cr-1"><?php echo $lang['langShopLMemberName']; ?>:</td>
						<td class="cr-2">
							<input name="txtMemberName" id="txtMemberName" type="text" class="in" />
							<label style="display:none" for="txtMemberName" class="error" metaDone="true" generated="true"></label>
						</td>
					</tr>
				</table>
				<div class="an-1 bg-an"><span class="buttom-comm"><input type="submit" value="<?php echo $lang['langShopLAdd']; ?>" name="" ></span></div>
				</form>	
			</div>
		</div>
	</div>
</div>