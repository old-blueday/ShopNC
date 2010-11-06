var ShowContentDiv = "show_list";
var pcid;
var question;
var content;
$(document).ready(function() {

	//显示列表的DIV名称
	//AJAX提交后会有提示
	//showLoad();

	$().ajaxStop($.unblockUI);

	var options_list = {
		success:       showResponse,  // 提交成功后执行的方法
		type:      'get'       // 'get' or 'post', 提交类型，重写form表单的method值
	};



	//选择下拉框触发的事件
	$("#slPCId").change(function(){
		pcid = this.options[this.selectedIndex].value;
		if (pcid > 0){
			//如果选种某个分类则显示添加部分，并且显示其分类下的属性列表
			$("#attribute_manage_type").show();
			//alert(pcid);
			$("#txtApcid").attr("value",pcid);
			//显示属性列表
			getAttribute('attribute.manage.php?action=ajax_show&pcid='+this.options[this.selectedIndex].value);
		}else{
			//如果没有选中某个类别则隐藏添加部分
			$("#attribute_manage_type").hide();
			$("#show_list").text("");
		}

	});


	//对添加表单做的验证定义
	$("#form_Attribute").validate({
		debug :true,
		errorClass: "wrong",
		rules: {
			txtAname: {required:true},
			txtAorder: {required:true}
		},
		messages: {
			txtAname: {required: "请填写属性名称"},
			txtAorder: {required: "请填写属性排序"}
		},
		submitHandler: function() {
			ShowDiv = "errormessage";
			ShowContentType = 2;
			ErrorMessageDiv = "errormessage";
			//提交表单操作
			$('#form_Attribute').ajaxSubmit({ beforeSubmit:AttrRequest,success: addAttr, type:'post', dataType:'json', resetForm: true});
		}
	});

	//修改属性
	function AttrRequest(formData, jqForm, options){
		ShowSaveDiv = "show_message";
		ErrorMessageDiv = "errormessage";
		ShowDiv = 'show_message';
		saveRequest(formData, jqForm, options)

	}




});
//定义提交添加表单后的操作
function addAttr(responseText,statusText){
	saveResponse(responseText,statusText);
	$("#txtApcid").attr("value",pcid);
	getAttribute('attribute.manage.php?action=ajax_show&pcid=' + pcid,1);
}
//显示属性列表
function getAttribute(address,type){
	if(type != 1){
		//alert('d');
		$.blockUI('<h1><img src="../templates/default/images/busy.gif" /> ' + showText + '...</h1>');
	}
	$.ajax({
		url: address,
		// ifModified:true,   使用这个属性firefox会有问题，无法成功响应
		success: function(msg){
			$("#" + ShowContentDiv).html(msg);
			$("#" + ShowContentDiv).css("display","block");
			question = $('#question')[0];
			//$("#question").css("display","block");
			content = $('#contentDIV')[0];
			//修改属性
			$('form','#attribute_manage_type2').submit(function(){
				//alert(this.name);
				myform = this.name;
				$("#" + myform).validate({
					//debug :true,
					errorClass: "wrong",
					rules: {
						txtAname: {required:true},
						txtAorder: {required:true}
					},
					messages: {
						txtAname: {required: "请填写属性名称"},
						txtAorder: {required: "请填写属性排序"}
					},
					submitHandler: function() {
						ShowSaveDiv = "show_message_modi";
						ErrorMessageDiv = "errormessage_modi";
						ShowDiv = 'show_message_modi';
						$('#' +  myform).ajaxSubmit({ beforeSubmit:saveRequest,success: addAttr, type:'post', dataType:'json', resetForm: true});
					}
				});
				//return false;
			});
		}



	});



}
//删除属性
function delResponse(responseText,statusText){
	//ShowSaveDiv = "show_message_modi";
	//ErrorMessageDiv = "errormessage_modi";
	//ShowDiv = 'show_message_modi';
	//saveResponse(responseText,statusText);
	//alert(pcid);

	$.blockUI("<h1>" + responseText.message + "</h1>" );
	getAttribute('attribute.manage.php?action=ajax_show&pcid=' + pcid,1);
	//$.unblockUI();
}
/*
* 删除商品分类属性
*/
function delAtt(){


	var del_aid = document.getElementsByName('txtAid');
	var array_aid = new Array();

	for(i=0;i<del_aid.length;i++){
		if(del_aid[i].checked==true){
			array_aid.push(del_aid[i].value);
		}
	}
	if (array_aid == ''){
		$('#errormessage_modi').text('请选择要删除的属性！');
		setTimeout('$("#errormessage_modi").css("display","none")',500);
	}else{
		$.blockUI(question, { width: '275px' });

		$('#yes').click(function() {
			//$.blockUI("<h1>Remote call in progress...</h1>" );
			$.ajax({
				success: delResponse,
				url: 'attribute.manage.php?action=del',
				type: 'post',
				dataType: 'json',
				data: 'txtAid=' + array_aid
			});
			return false;
		});
		$('#no').click($.unblockUI);

	}
	//alert(array_aid);

}
/*
* 调用div对话窗口
* 管理属性内容
*/
function manage_ac(aid,aname)
{
	$.ajax({
		url: 'attribute_content.manage.php?action=list',
		type: 'post',
		dataType: 'html',
		data: 'aname=' + aname +'&aid=' + aid,
		timeout: 1000,
		error: function(){
			alert('something wrong');
		},
		success: function(html){

				document.getElementById('contentDIV').innerHTML=html;
				var showData = document.getElementById('contentDIV').innerHTML;
				ScreenConvert();DialogShow(showData,500,400,520,600);
				
        }

	});

	//PostRequest(window.location.protocol + "//" + window.location.host + "/ajax_Comm.aspx", PostData);
	//$('#contentDIV').html('123');
	//ScreenConvert();DialogShow("<div id=\"DialogLoading\">正在读取,请稍候...</div>",110,10,124,20);
}

/*
* 添加属性内容
*/
function add_ac()
{
	var uaid = document.getElementById('txtaddAid').value;
	var uaccontent = document.getElementById('txtaddACcontent').value;
	var uacorder = document.getElementById('txtaddACorder').value;
	var uaname = document.getElementById('txtaddAname').value;
	//alert(uaccontent);
	$.ajax({
		url: 'attribute_content.manage.php?action=add',
		type: 'post',
		dataType: 'html',
		data: 'accontent=' + uaccontent +'&acorder=' + uacorder + '&aid=' + uaid,
		timeout: 1000,
		error: function(){
			alert('something wrong');
		},
		success: function(){
			//alert(msg);
			manage_ac(uaid, uaname);
		}
	});
}

/*
* 编辑属性内容
*/
function update_ac(acid)
{
	var uaid = document.getElementById('txtaddAid').value;
	var uaccontent = document.getElementById('txtupdateACcontent' + acid).value;
	var uacorder = document.getElementById('txtupdateACorder' + acid).value;
	var uaname = document.getElementById('txtaddAname').value;
	//alert(uaccontent);
	$.ajax({
		url: 'attribute_content.manage.php?action=update',
		type: 'post',
		dataType: 'html',
		data: 'accontent=' + uaccontent +'&acorder=' + uacorder + '&acid=' + acid,
		timeout: 1000,
		error: function(){
			alert('something wrong');
		},
		success: function(){
			//alert(msg);
			manage_ac(uaid, uaname);
		}
	});
}

/*
* 删除属性内容
*/
function del_ac()
{
	var uaid = document.getElementById('txtaddAid').value;
	var uaname = document.getElementById('txtaddAname').value;
	var delacid = document.getElementsByName('txtupdateAcid');
	var array_aid = new Array();
	for(i=0;i<delacid.length;i++){
		if(delacid[i].checked==true){
			array_aid.push(delacid[i].value);
		}
	}
	//alert(uaccontent);
	$.ajax({
		url: 'attribute_content.manage.php?action=del',
		type: 'post',
		dataType: 'html',
		data: 'acid=' + array_aid,
		timeout: 1000,
		error: function(){
			alert('something wrong');
		},
		success: function(){
			//alert(msg);
			manage_ac(uaid, uaname);
		}
	});
}