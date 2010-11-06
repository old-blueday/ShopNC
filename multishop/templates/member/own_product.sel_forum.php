<script>
//forum array
var forum_array = new Array;
<?php if(!empty($output['forum_array']) && is_array($output['forum_array'])){ ?>
<?php foreach($output['forum_array'] as $k => $v){ ?>
	forum_array['<?php echo $k;?>'] = '<?php echo $v['fid'].'|||'.$v['fup'].'|||'.$v['allow_product'].'|||'.$v['name'];?>'
<?php } ?>
<?php } ?>
//group array
var group_array = new Array;
<?php if(!empty($output['group_list']) && is_array($output['group_list'])){ ?>
<?php foreach($output['group_list'] as $k => $v){ ?>
	group_array['<?php echo $k;?>'] = '<?php echo $v['fid'].'|||'.$v['fup'].'|||'.$v['allow_product'].'|||'.$v['name'];?>'
<?php } ?>
<?php } ?>
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langProductXSelForum']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langProductXSelForum']; ?></p></span></li>
					</ul>
				</div>
				<script>
					// fid:forum_id deep:forum_deep obj:selected div
					function show_next_forum(fid,deep,obj){
						//set hidden input 
						$('#fid').val(fid);
						//change style
						//$('.cssname').removeClass('.cssname');
						//$(obj).addClass('cssname');
						//deep
						deep = parseInt(deep)+1;
						// html show
						var html_line = '';
						//search forum_array
						for(v in forum_array){
							var tmp_str = forum_array[v].split('|||');
							//true
							if(tmp_str[1] == fid){
								html_line += "<div class=\"c2_class\" style=\"cursor:pointer\"";
								html_line += "onclick=\"show_next_forum("+ tmp_str[0]+",'"+deep+"');\">";
								html_line += tmp_str[3];
								html_line += '(';
								html_line += (tmp_str[2]=='1')?'<?php echo $lang['langProductXAllowSerProduct'];?>':'<?php echo $lang['langProductXDenySerProduct'];?>';
								html_line += ')';
								//check this fid has child
								parent_sign = forum_check_parent(tmp_str[0]);
								if(parent_sign == true){
									html_line += '>';
								}
								html_line += "</div>";
								delete(parent_sign);
							}
							//Judge this allow_product OR change style
							if(tmp_str[0] == fid){
								if(tmp_str[2] == '1'){
									//submit_button
									$('#forum_submit_button').attr('disabled',false);
								}else{
									$('#forum_submit_button').attr('disabled',true);
								}
							}
							delete(tmp_str);
						}
						if(deep == '1'){
							//clean div
							$('#second_td').html('');
							$('#third_td').html('');
						}
						if(deep == '2'){
							$('#second_td').html(html_line);
							$('#third_td').html('');
						}
						if(deep == '3'){
							$('#third_td').html(html_line);
						}
						delete(html_line);
					}
					function set_group(fid,obj){
						//set hidden input 
						$('#fid').val(fid);
						//change style
						//$('.cssname').removeClass('.cssname');
						//$(obj).addClass('cssname');
						for(v in group_array){
							var tmp_str = group_array[v].split('|||');
							//Judge this allow_product OR change style
							if(tmp_str[0] == fid){
								if(tmp_str[2] == '1'){
									//submit_button
									$('#group_submit_button').attr('disabled',false);
								}else{
									$('#group_submit_button').attr('disabled',true);
								}
							}
							delete(tmp_str);
						}
					}
					function forum_check_parent(fup){
						for(v in forum_array){
							var tmp_str = forum_array[v].split('|||');
							if(fup == tmp_str[1]){
								return true;
							}
							delete(tmp_str);
						}
						return false;
					}
				</script>
				<div class="cr-right">
    				<form action="own_product.php?action=add" method="post" name="">
						<input type="hidden" name="fid" id="fid" value="" />
						<table width="100%" class="cr-r-td" border="0" cellpadding="0">					
							<tr>
								<td class="cr-1"></td>
								<td class="cr-2">
									<input type="radio" name="type" id="type_forum" value="forum" onclick="show_forum();" /><?php echo $lang['langProductXForum'];?>
									<input type="radio" name="type" id="type_group" value="group" onclick="show_group();" /><?php echo $lang['langProductXGroup'];?>
								</td>
							</tr>
						</table>
<script type="text/javascript" src="<?php echo JS_DIR;?>/jquery.livequery.js"></script>
						<script type="text/javascript">
							$(document).ready(function(){
								$('.c1_classtd .c1_class').click(function(){
									$(this).addClass("active_n").siblings(".c1_classtd .c1_class").removeClass("active_n");
									$('.c2_class').removeClass("active_n");
									$('.c3_classtd .c2_class').removeClass("active_n");
								});
								$('.c2_classtd .c2_class').livequery('click', function(event) { 
									$(this).addClass("active_n").siblings(".c2_classtd .c2_class").removeClass("active_n");
									$('.c3_classtd .c2_class').removeClass("active_n")
								});
								$('.c3_classtd .c2_class').livequery('click', function(event) {
									$(this).addClass("active_n").siblings(".c3_classtd .c2_class").removeClass("active_n");
								});
								
							});
							</script>
						<table width="100%" class="cr-r-td" border="0" cellpadding="0" id="forum_table">					
							<tr>
								<td class="cr-1 c1_classtd">
									<?php if(!empty($output['first_forum']) && is_array($output['first_forum'])){ ?>
									<?php foreach($output['first_forum'] as $k => $v){ ?>
										<div class="c1_class" style="cursor:pointer" onclick="show_next_forum('<?php echo $v['fid'];?>','1',this);"><?php echo $v['name'];?>
										<?php echo $v['is_parent']?'>':''?>
										</div>
									<?php } ?>
									<?php } ?>
								</td>
								<td class="cr-2 c2_classtd" id="second_td" style=" width:305px;"></td>
								<td class="cr-2 c3_classtd" id="third_td"></td>
							</tr>
						</table>
						<table width="100%" class="cr-r-td" border="0" cellpadding="0" id="group_table" style="display:none;">
							<tr>
								<td class="cr-1 c1_classtd"></td>
								<td class="cr-2 c2_classtd" style=" width:305px;">
									<?php if(!empty($output['group_list']) && is_array($output['group_list'])){ ?>
									<?php foreach($output['group_list'] as $k => $v){ ?>
										<div class="c2_class" style="cursor:pointer" onclick="set_group('<?php echo $v['fid'];?>',this);"><?php echo $v['name'];?>
											(<?php echo ($v['allow_product']=='1')?$lang['langProductXAllowSerProduct']:$lang['langProductXDenySerProduct'];?>)
										</div>
									<?php } ?>
									<?php } ?>
								</td>
								<td class="cr-2 c3_classtd"></td>
							</tr>
						</table>
						<div class="an-1">
							<span class="buttom-comm" id="forum_button">
								<input disabled="disabled" id="forum_submit_button" type="submit" class='submit' name="" value="<?php echo $lang['langCNext'];?>" />
							</span>
							<span class="buttom-comm" id="group_button">
								<input disabled="disabled" id="group_submit_button" type="submit" class='submit' name="" value="<?php echo $lang['langCNext'];?>" />
							</span>
						</div>	
					</form>			
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#type_forum').trigger('click');
});
function show_forum(){
	$('#forum_table').css('display','');
	$('#group_table').css('display','none');
	$('#forum_button').css('display','');
	$('#group_button').css('display','none');
}
function show_group(){
	$('#forum_table').css('display','none');
	$('#group_table').css('display','');
	$('#forum_button').css('display','none');
	$('#group_button').css('display','');
}
</script>