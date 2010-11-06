/* 
Copyright (c) 2007 - 2010 www.shopnc.net
	json{
		array://['di1','di2','id3']
		ev:// 'click'
	}
*/

jQuery.fn.extend({

		tab:function (json){
			$.each(json.array,function(i){
					$("#"+json.array[i]).children('ul').children('li').bind(json.ev,function(){
						$("#"+json.array[i]).children('ul').children('li').removeClass("current");
						$(this).addClass("current");
						
						var target =$("#"+json.array[i]).children('#' + $(this).attr("rel"));
						if (target.size() > 0) {
							$("#"+json.array[i]).children('dl').hide();
							target.show();
						} else {
							alert('There is no such container.');
						}
					});
				});
		}
})