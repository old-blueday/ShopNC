//发出统计信息
function setStatics(){
	//取JS文件参数
	var jsFileName = "statics.js";
	var rName = new RegExp(jsFileName+"(\\?(.*))?$")
	var jss=document.getElementsByTagName('script');
	var param_array = Array();
	for (var i = 0;i < jss.length; i++){
	var j = jss[i];
	if (j.src&&j.src.match(rName)){
		var oo = j.src.match(rName)[2];
		if (oo&&(t = oo.match(/([^&=]+)=([^=&]+)/g))){
			for (var l = 0; l < t.length; l++){
				r = t[l];
				var tt = r.match(/([^&=]+)=([^=&]+)/);
				if (tt)
					param_array[tt[1]] = tt[2];
				}
			}
		}
	}
	//当前页面
	var url = window.location;
	//分辨率宽
	var screen_width = window.screen.width;
	//分辨率高
	var screen_height = window.screen.height;
	
	if(js_statics_sign == '1'){
		//向服务器发出统计请求,一般页面
		$.ajax({
			url: param_array['url']+"/home/statics.php",
			data: "user_ad="+escape(document.referrer)+"&filename2="+url+"&screen_width="+screen_width+"&screen_height="+screen_height,
			type:'post',
			dataType:"json"
		});
	}else if (js_statics_sign == '2'){
		//向服务器发出统计请求,商品静态页面
		$.ajax({
			url: param_array['url']+"/home/statics.php",
			data: "user_ad="+escape(document.referrer)+"&filename2="+url+"&screen_width="+screen_width+"&screen_height="+screen_height,
			type:'post',
			dataType:"json"
		});
	}else if (js_statics_sign == '3'){
		//向服务器发出统计请求,根目录下的静态首页
		$.ajax({
			url: param_array['url']+"/home/statics.php",
			data: "user_ad="+escape(document.referrer)+"&filename2="+url+"&screen_width="+screen_width+"&screen_height="+screen_height,
			type:'post',
			dataType:"json"
		});
	}else if (js_statics_sign == '4'){
		//向服务器发出统计请求,频道页面目录
		$.ajax({
			url: param_array['url']+"/home/statics.php",
			data: "user_ad="+escape(document.referrer)+"&filename2="+url+"&screen_width="+screen_width+"&screen_height="+screen_height,
			type:'post',
			dataType:"json"
		});
	}
}
setStatics();