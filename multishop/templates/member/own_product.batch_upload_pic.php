<link href="<?php echo TPL_DIR?>/css/layout.css" rel="stylesheet" type="text/css" />
<link type="text/css"  href="<?php echo TPL_DIR;?>/css/uploadify.css" rel="stylesheet" />
<script type="text/javascript" src="../js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="../js/uploadify/jquery.uploadify.v2.1.0.min.js"></script>


<script language="javascript" type="text/javascript">
$(document).ready(function() {
		$("#uploadify").uploadify({
		'uploader'       : '../js/uploadify/uploadify.swf',
		'script'         : 'own_product_batch.php?',
		'scriptData'	 :{'action':'upload_pic_save','PHPSESSID':'<?php echo $output['session_id']; ?>'},
		'fileDataName'   : 'Filedata',
		'cancelImg'      : 'cancel.png',
		'folder'         : '../uploads',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'sizeLimit'      : <?php echo $output['upload_max_size']*1000;?>,
		'buttonText'	 : "select",
		'fileDesc'       : '支持格式*.tbi',
    	'fileExt'        : '*.tbi',
		'queueSizeLimit' : 999,
		'buttonImg'      : '<?php echo TPL_DIR;?>/images/zengjia.gif',
		'cancelImg'      : '<?php echo TPL_DIR;?>/images/cancel.png',
		'onComplete'     : function(e,　queueId,　fileObj,data){
							
						},
		
		'onAllComplete':function(){
							picobj="";
							$.each($(".up-img").children("ul").children("li").children('div').children("input"),function(){
								picobj+=$(this).val()+"|||";
							});
							$("#pichidden").val(picobj);
						},
		'onError':function(event,id,fileObj,errorObj){
			if(errorObj.type=="File Size")
			{
				$("#uploadify"+id).children(".percentage").html("<?php echo $lang['errPFileSizeNotBeyond'];?><?php echo $output['upload_max_size'];?>KB");
				$("#uploadify"+id).attr("class","uploadifyQueueItem uploadifyError");
				return false;
			}
		}
	});
});
</script>
<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langBatchImgUploadExplain'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langBatchImgUpload'];?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"></td>
							<td class="cr-2">
							<div id="fileQueue"></div>
								<input type="file" name="uploadify" id="uploadify" />
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>