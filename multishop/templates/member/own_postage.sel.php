<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langPostageList'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langPostageList'];?></p></span></li>
					</ul>
				</div>
				<div class="z-mai-unite">
					<table class="unite-table-1"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td colspan="2" class="td-bg-11"><?php echo $lang['langMyPostage'];?>:</td>
							<td colspan="2"><a href="own_postage.php?action=add&product_sel=1"><?php echo $lang['langPostageAdd'];?></a></td>
						</tr>
						<?php if(!empty($output['postage_list']) && is_array($output['postage_list'])){?>
						<?php foreach($output['postage_list'] as $k => $v){ ?>
		
									<tr class="tr-un-gray">
										<td>
											<?php echo $v['postage_title'];?>
											
										</td>
										<td colspan="2"><?php echo $lang['langPostageUpdateTime'];?><?php echo $v['postage_update_time'];?></td>
										<td><a href="own_postage.php?action=modi&postage_id=<?php echo $v['postage_id'];?>&product_sel=1"><?php echo $lang['langCedit']; ?></a>
											-
											<a href="own_postage.php?action=del&postage_id=<?php echo $v['postage_id'];?>&product_sel=1"><?php echo $lang['langCdele']; ?></a></td>
									</tr>
									<tr class="tr-un-conter-4">
										<td><?php echo $lang['langPostageWay'];?></td>
										<td><?php echo $lang['langPostageMoney'];?></td>
										<td><?php echo $lang['langPostageShipTo'];?></td>
										<td><?php echo $lang['langPostageSetUp'];?></td>
									</tr>
									<?php 
										/**
										 * 平邮
										 */
										if(!empty($v['postage_ordinary']) && is_array($v['postage_ordinary'])){
									?>
									<?php foreach($v['postage_ordinary'] as $k_ordinary => $v_ordinary){ ?>
										<?php if($k_ordinary !== 'default'){ ?>
										<tr class="tr-un-conter-4">
											<td><?php echo $lang['langPostageOrdinary'];?></td>
											<td><?php echo $v_ordinary[1];?></td>
											<td><div class="show_area"><?php echo $v_ordinary[0];?></div></td>
											<td><?php echo $v_ordinary[2];?></td>
										</tr>
										<?php } ?>
									<?php } ?>
										<tr class="tr-un-conter-4">
											<td><?php echo $lang['langPostageOrdinary'];?></td>
											<td><?php echo $v['postage_ordinary']['default']['default'];?></td>
											<td><?php echo $lang['langPostageAllArea'];?></td>
											<td><?php echo $v['postage_ordinary']['default']['default_up'];?></td>
										</tr>
									<?php } ?>
									<?php 
										/**
										 * 快递
										 */
										if(!empty($v['postage_fast']) && is_array($v['postage_fast'])){
									?>
									<?php foreach($v['postage_fast'] as $k_fast => $v_fast){ ?>
										<?php if($k_fast !== 'default'){ ?>
										<tr class="tr-un-conter-4">
											<td><?php echo $lang['langPostageFast'];?></td>
											<td><?php echo $v_fast[1];?></td>
											<td><div class="show_area"><?php echo $v_fast[0];?></div></td>
											<td><?php echo $v_fast[2];?></td>
										</tr>
										<?php } ?>
									<?php } ?>
										<tr class="tr-un-conter-4">
											<td><?php echo $lang['langPostageFast'];?></td>
											<td><?php echo $v['postage_fast']['default']['default'];?></td>
											<td><?php echo $lang['langPostageAllArea'];?></td>
											<td><?php echo $v['postage_fast']['default']['default_up'];?></td>
										</tr>
									<?php } ?>
									<?php 
										/**
										 * ems
										 */
										if(!empty($v['postage_ems']) && is_array($v['postage_ems'])){
									?>
									<?php foreach($v['postage_ems'] as $k_ems => $v_ems){?>
										<?php if($k_ems !== 'default'){ ?>
										<tr class="tr-un-conter-4">
											<td><?php echo $lang['langPostageEMS'];?></td>
											<td><?php echo $v_ems[1];?></td>
											<td><div class="show_area"><?php echo $v_ems[0];?></div></td>
											<td><?php echo $v_ems[2];?></td>
										</tr>
										<?php } ?>
									<?php } ?>
									<tr class="tr-un-conter-4">
										<td><?php echo $lang['langPostageEMS'];?></td>
										<td><?php echo $v['postage_ems']['default']['default'];?></td>
										<td><?php echo $lang['langPostageAllArea'];?></td>
										<td><?php echo $v['postage_ems']['default']['default_up'];?></td>
									</tr>
									<?php } ?>
									<tr class="tr-un-conter-4">
										<td colspan="3"><?php echo $lang['langPostageContent'];?>:<?php echo $v['postage_content'];?></td>
										<td><a href="javascript:;" onclick="selectPostageToPublish('<?php echo $v['postage_id']; ?>','<?php echo $v['postage_title']; ?>');"><?php echo $lang['langPostageUseThis'];?></a></td>
									</tr>
							
						
						<?php } ?>
						<?php }else { ?>
						<tr class="tr-not">
							<td colspan="4">
								<div class="tr_not_div"><?php echo $lang['langCNull']; ?></div>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
// area array
var changeArea = new Array();
<?php if(!empty($output['sel_area']) && is_array($output['sel_area'])){?>
<?php foreach($output['sel_area'] as $k => $v){?>	
changeArea[<?php echo $v[0];?>] = '<?php echo $v[2];?>';
<?php } ?>
<?php } ?>
//
$(document).ready(function(){
	$(".show_area").each(function(){
		temp = $(this).html();
		temp_array = Array();
		temp_array = temp.split(',');
		temp_str = '';
		for(i=0;i<temp_array.length;i++){
			if (typeof(changeArea[temp_array[i]]) !== 'undefined'){
				temp_str += changeArea[temp_array[i]]+',';
			}
		}
		$(this).html(temp_str);
	});	
});
function selectPostageToPublish(postageid, postageName) {
	try{
		window.opener.window.afterSelectPostage(postageid, postageName);
	} catch(e){
		//alert(e);
	}
	window.close();
}
</script>