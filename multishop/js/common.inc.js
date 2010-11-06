var clickelement;

// 保存后所放提示信息的DIV名称
var ShowSaveDiv = "message";
// 返回正确的提示信息
var showSuccess = "success!!";
// 返回错时的提示信息
var showError = "error!!";
//显示结果的DIV地ID
var ShowDiv = "mainshow";
//错误信息显示的位置
var ErrorMessageDiv = "errormessage";

//提交后在右上角有loading提示
function showLoad(){
	$(window).scroll(function () {
		scall();
	});
	$('<div id="loading"></div>').appendTo('body');

	//$('#loading').ajaxStart(function() {$('#loading').show();});
	//$('#loading').ajaxStop(function() {$('#loading').hide();});
}
//AJAX分页方法
function getPageContent(address){
	//$.blockUI('<h1><img src="../templates/default/images/busy.gif" /> ' + showText + '...</h1>');
	//alert(address);
	$.ajax({
		url: address,
		dataType:"javascript",
		// ifModified:true,   使用这个属性firefox会有问题，无法成功响应
		beforeSubmit:  showLoading(showText),   // 提交之前执行的方法
		success: function(msg){
			$("#" + ShowDiv).html(msg);
			//$("#" + ShowDiv).css("display","block");
			//alert(msg);
			hideLoading();
		}
	});
}

// 提交后执行的方法（作为保存）
function saveRequest(formData, jqForm, options){
	var queryString = $.param(formData);
	//alert(ShowSaveDiv);
	$("#" + ShowSaveDiv).text(showSaveText);
	$("#" + ShowSaveDiv).css("display","block");
	return true;
}

// 提交之前执行的方法（作为保存）
//responseText服务器端返回的值
//statusText AJAX的状态
//返回值类型是JSON，如果type:0是有错误1是成功，message:是要显示的内容
function  saveResponse(responseText,statusText){
	//alert("sss");
	//	$("#" + ShowSaveDiv).css("display","block");
	//如果没有返回信息，那么就显示默认的提示信息
	//alert(ShowSaveDiv);
	if (responseText.message == ""){
		if (responseText.type == "1"){
			$("#" + ShowSaveDiv).text(showSuccess);
		}else{
			$("#" + ShowSaveDiv).text(showError);
		}
	}else{
		if (responseText.type == "1"){
			showMessage(responseText.message);
			//$("#" + ShowDiv).text(responseText.message);
		}else{
			$("#" + ErrorMessageDiv).text(responseText.message);
		}
	}
	$("#" + ShowSaveDiv).show();
	//alert("sss");
	//setTimeout('$("#' + ShowSaveDiv + '").css("display","none")',250);
	//ShowSaveDiv = "show_message";
	return true;
}

// 直接根据内容返回列表
function showResponse(responseText,statusText)  {
	if (responseText.type == "1"){
		$("#" + ShowDiv).text(responseText.message);
	}else{
		$("#" + ErrorMessageDiv).text(responseText.message);
	}
}

// 得到也面内容，并更改菜单状态
function getContent(thiselement,address){
	clickelement = thiselement;
	$("#main0 span").each(function(i){this.style.color='#FFFFFF'});
	thiselement.style.color = '#E0F8E2';
	ShowDiv = 'mainshow';
	getPageContent(address);

}
//显示右上角ajax提示
function showLoading(msg){
	scall();
	//	$('#loading').html(msg).fadeIn("fast");
	$('#loading').text(msg);
	$('#loading').show();
}
//隐藏右上角ajax提示
function hideLoading(){
	$('#loading').hide();
}
//定位右上角ajax提示
function scall(){
	$('#loading').animate({
		//top:document.documentElement.scrollTop+42,//距顶端
		//right:4//距右
	},1);
}
//显示操作结果辅助导航type 0为错误，1为正确信息
function showMessage(msg,type){
	$("#product-help").css('top',119);
	if(type == 0){
		$('#message').html('<div class="no" onclick="hideMessage();"><span>'+msg+'</span></div>');
	}else{
		$('#message').html('<div class="yes" onclick="hideMessage();"><span>'+msg+'</span></div>');
	}
	$('#message').slideDown("slow");
}
//隐藏操作结果辅助导航
function hideMessage(){
	$("#product-help").css('top',88);
	$('#message').slideUp("fast");
}
function showHelp(){
	$.cookie('hideHelp','1');
	$('#main-left')[0].style.width="73%";
	if($("#message")[0]!=null){
		$('#message')[0].style.width="100%";
	}
	$('#main-right-help').fadeIn("slow");
	$("#openhelpbutton").hide();
	$("#closehelpbutton").show();
}
function hideHelp(){
	$.cookie('hideHelp','0');
	$('#main-right-help').fadeOut("slow");
	setTimeout("$('#main-left')[0].style.width='98%'",600);//不能动 这是隐藏帮助后整体宽度
	if($("#message")[0]!=null){
		setTimeout("$('#message')[0].style.width='100%'",600);
	}
	$("#openhelpbutton").show();
	$("#closehelpbutton").hide();
}

//到顶部的效果
var goto_top_type = -1;
var goto_top_itv = 0;
function goto_top_timer(){
	var y = goto_top_type == 1 ? document.documentElement.scrollTop : document.body.scrollTop;
	var moveby = 15;
	y -= Math.ceil(y * moveby / 50);
	if (y < 0) {
		y = 0;
	}
	if (goto_top_type == 1) {
		document.documentElement.scrollTop = y;
	}else {
		document.body.scrollTop = y;
	}
	if (y == 0) {
		clearInterval(goto_top_itv);
		goto_top_itv = 0;
	}
}
function goto_top(){
	if (goto_top_itv == 0) {
		if (document.documentElement && document.documentElement.scrollTop) {
			goto_top_type = 1;
		}else if (document.body && document.body.scrollTop) {
			goto_top_type = 2;
		}else {
			goto_top_type = 0;
		}
		if (goto_top_type > 0) {
			goto_top_itv = setInterval('goto_top_timer()', 50);
		}
	}
}
