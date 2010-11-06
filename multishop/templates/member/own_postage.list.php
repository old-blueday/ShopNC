<script src="<?php echo JS_DIR;?>/list_choose.js"></script>
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
					<form action="own_postage.php?action=del" method="post" name="form_postage" id="form_postage" onsubmit="return checkForm('<?php echo $lang['langCConfirmDelete']; ?>','<?php echo $lang['langCNoSelect']; ?>');" >
					<table class="unite-table-1"  border="0" cellspacing="0" cellpadding="0" >
						<tr class="tr-un-bg-2">
							<td class="td-bg-3"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?><!-- 全选 --></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?><!-- 反选 --></a></td>
							<td class="td-bg-11"><?php echo $lang['langPostageTitle']; ?></td>
							<td class="td-bg-4"><?php echo $lang['langPostageUpdateTime']; ?></td>
							<td class="td-bg-7"></td>
						</tr>
						<tr class="tr-un-space">
							<td colspan="7"></td>
						</tr>
						<?php if(!empty($output['postage_list']) && is_array($output['postage_list'])){?>
						<?php foreach($output['postage_list'] as $k => $v){ ?>
						<tr class="tr-un-conter-4">
							<td><input type="checkbox" name="postage_id[]" value="<?php echo $v['postage_id'];?>" /></td>
							<td><?php echo $v['postage_title'];?></td>
							<td><?php echo $v['postage_update_time'];?></td>
							<td><a href="own_postage.php?action=modi&postage_id=<?php echo $v['postage_id'];?>"><?php echo $lang['langCedit']; ?></a></td>
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
					<?php if(!empty($output['postage_list']) && is_array($output['postage_list'])){?>
						<div class="handle">
							<ul class="depot-ul depot-ul-li-2">
								<!-- 全选/反选 -->
								<li class="depot-li-te"><a href="javascript:;" onclick="selectall();"><?php echo $lang['langCAllSelect']; ?></a>/<a href="javascript:;" onclick="unselectall();"><?php echo $lang['langCAllNotSelect']; ?></a></li>		
								<li><span class="span-button"><input value="<?php echo $lang['langCdele'];?>" type="submit" /></span></li>
							</ul>
						</div>
					<?php } ?>
					</form>
				</div>
				<?php if(!empty($output['postage_list'])){ ?>
					<div class="page">
						<div class="pd-ck-right">
							<?php echo $output['page_list']; ?>
						</div>	
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>