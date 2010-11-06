<?php 
if ( file_exists( BasePath . "/js/validate/member_shoptag.add.html" ) ) {
	include_once( BasePath . "/js/validate/member_shoptag.add.html" );
}
?>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3"><p><?php echo $lang['langShopTagExplain'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg-1"><b></b><span><p><a href="own_shoptag.php"><?php echo $lang['langShopTagManage']; ?></a></p></span></li>
						<li class="nav-bg nav-left"><b></b><span><p><?php echo $lang['langShopAddTag']; ?></p></span></li>
					</ul>
				</div>						
				<div class="cr-right">
    				<form id="tag_form" name="tag_form" action="<?php echo $output['action']; ?>" method="post">
					<input type="hidden" name="tag_id" id="tag_id" value="<?php echo $output['tag_array']['tag_id']; ?>" />				
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTagName']; ?>:</td>
							<td class="cr-2">
								<span><input name="txtTagname" id="txtTagname" value="<?php echo $output['tag_array']['tag_name']; ?>" class="in"></span>
								<span class="cr-5-span"><?php echo $lang['langShopFormTagname']; ?></span>
								<label style="display:none" for="txtTagname" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTagDisplay']; ?>:</td>
							<td class="cr-2"><label for="txtTagdisplay1"><input type="radio" name="txtTagdisplay" id="txtTagdisplay1" value="0" <?php if ( $output['tag_array']['tag_display'] == '0' || $output['tag_array']['tag_display'] == '' ) { ?> checked <?php } ?> /><?php echo $lang['langShopTagBlock']; ?></label><label for="txtTagdisplay2"><input type="radio" name="txtTagdisplay" id="txtTagdisplay2" value="1" <?php if ( $output['tag_array']['tag_display'] == '1' ) { ?> checked <?php } ?> /><?php echo $lang['langShopTagNone']; ?></label>
							</td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTagUrlType']; ?>:</td>
							<td class="cr-2"><label for="tag_type1"><input type="radio" name="tag_type" id="tag_type1" value="1" <?php if ( $output['tag_array']['tag_url'] == '' || $output['tag_array']['tag_content'] != '' ) { ?> checked <?php } ?> /><?php echo $lang['langShopTagMyShop']; ?></label><label for="tag_type2"><input type="radio" name="tag_type" id="tag_type2" value="2" <?php if ( $output['tag_array']['tag_url'] != '' ) { ?> checked <?php } ?> /><?php echo $lang['langShopTagGoto']; ?></label>
							</td>
						</tr>	
						<tr id="td_tagurl" <?php if ( $output['tag_array']['tag_url'] == '' ) { ?> style="display:none;" <?php } ?> >
							<td class="cr-1"><?php echo $lang['langShopTagUrl']; ?>:</td>
							<td class="cr-2">
								<span><input name="txtTagurl" id="txtTagurl" value="<?php echo $output['tag_array']['tag_url']; ?>" class="in"></span>
								<span class="cr-5-span"><?php echo $lang['langShopFormUrl']; ?></span>
								<label style="display:none" for="txtTagurl" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>		
						<tr id="td_tagcontent" <?php if ( $output['tag_array']['tag_url'] != '' ) { ?> style="display:none;" <?php } ?> >
							<td class="cr-1"><?php echo $lang['langShopTagContent']; ?>:</td>
							<td class="cr-2">
								<?php
									include_once('../classes/resource/editor/editor.class.php');
									$editor=new editor('txtTagcontent');
									$editor->Value=$output['tag_array']['tag_content'];
									$editor->BasePath='../classes/resource/editor';
									$editor->Height=460;
									$editor->Width=621;
									$editor->AutoSave=false;
									$editor->Create();
								?>
								<label style="display:none" id="errTagcontent" class="wrong"></label> 
							</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langShopTagSort']; ?>:</td>
							<td class="cr-2">
								<span><input name="txtTagsort" id="txtTagsort" value="<?php echo $output['tag_array']['tag_sort']; ?>" class="in"></span>
								<span class="cr-5-span"><?php echo $lang['langShopFormSort']; ?></span>
								<label style="display:none" for="txtTagsort" class="wrong" metaDone="true" generated="true"></label>
							</td>
						</tr>						
					</table>
					<div class="an-1">
						<span class="buttom-comm">
							<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
						</span>
					</div>		
					</form>			
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$().ready(function (){
	$("#tag_type1").click(function () {
		$("#td_tagurl").hide();
		$("#td_tagcontent").show();	
	});
	$("#tag_type2").click(function () {
		$("#td_tagurl").show();
		$("#td_tagcontent").hide();			
	});	
});
</script>
