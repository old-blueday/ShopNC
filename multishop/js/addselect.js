/* 
Copyright (c) 2007 - 2010 www.shopnc.net
	json{
		ajaxUrl://url
		ajaxAction://function name
		hiddenId://input name
		dataJson://parent data
		type://add modi
		modi_id://when type=modi ,use modi_id
	}
*/
jQuery.fn.extend({
	addSelect:function(json){
		var obj=this;
		$(obj).ready(
			function(){
				var str='';
				var selstr='';
				var url = json.ajaxUrl;
				json.type = json.type?json.type:'add';

				if(json.type == 'modi' && json.modi_id != ''){
					if(url.charAt(url.length-1) == '&'){
						url += '&modi_id='+json.modi_id;
					}else {
						url += '?modi_id='+json.modi_id;
					}
				}
				$.ajax({
					type:'GET',
					url:url,
					data:{action:json.ajaxAction},
					dataType:'json',
					cache: true,
					success:function(data){
							dataJson = data['add'];
							if(typeof(data['modi']) != 'undefined'){
								modiJson=data['modi'];
							}
							$.each(dataJson,function(i){
								var sel='';
								if(typeof(modiJson[0]) != 'undefined'){
									if(dataJson[i].id == modiJson[0].id){
										sel='selected="selected"';
									}
									str+='<option '+sel+' value="'+dataJson[i].id+'||'+dataJson[i].is_parent+'||0">'+dataJson[i].name+'</option>';
								}else{
									str+='<option '+sel+' value="'+dataJson[i].id+'||'+dataJson[i].is_parent+'||0">'+dataJson[i].name+'</option>';
								}
							});
							for(var i = 1;i < modiJson.length;i++){
								var display='';
								if(typeof(modiJson[i]) == 'undefined'){
									selstr+='<select style="display:none"></select>';
								}else{
									selstr+='<select><option value="'+modiJson[i].id+'" selected>'+modiJson[i].name+'</option></select>';
								}
							}
							var htmlstr='<select><option></option>'+str+'</select>'+selstr;
							
							$(obj).append(htmlstr);
							var objselected=$(obj).children('select:first');
							$(objselected).addSelectToNext(json);
					}
			   });
			});
	},
	addSelectToNext:function(json){
		$(this).change(
			function(){
				var obj = this;
				var valarray = $(this).val().split('||');
				var url = json.ajaxUrl;

				if(valarray[0] == '' && typeof($(obj).prev('select').val()) != 'undefined'){
					var valarray = $(obj).prev('select').val().split('||');
					$('#'+json.hiddenId).val(valarray[0]);
				}else{
					$('#'+json.hiddenId).val(valarray[0]);
					if (valarray[1] == '1') {

						$(obj).nextAll('label').css('display','none');
						$(obj).nextAll('select').remove();
						$(obj).after('<select id="tmp_select"><option value="" selected="selected"> loading... </option></select>');
						$.ajax({
							type:'GET',
							url:url,
							data:{action:json.ajaxAction,parent_id:valarray[0],deep:$(obj).index('select')+1},
							dataType:'json',
							cache: true,
							success:function(data){ 
								data = data['add'];
								var a='';
								$.each(data,function(i){
									a += '<option value="'+data[i].id+'||'+data[i].is_parent+'">'+data[i].name+((data[i].is_parent=='1')?' ->':'')+'</option>';
								});
								$('#tmp_select').remove();
								//$(obj).nextAll('select').hide().unbind('change');
								a = '<select><option value="" selected="selected"></option>'+a+'</select>';
								$(obj).after(a);
								//$(obj).next().show().html('<select><option value="" selected="selected"></option>'+a+'</select>').nextAll().html('');
								$(obj).next().addSelectToNext(json);
							}
						})
					} else {
						$(obj).nextAll('select').html('').hide();
					};
				}
			}
		);
	}
});
