//resizeimage
function ResizeImage(F,D,G){
	if(F!=null){
		imageObject=F;
	}
	var E=imageObject.readyState;
	if(E!="complete"){
		setTimeout("ResizeImage(null,"+D+","+G+")",50);
		return
	}
	var B=new Image();
	B.src=imageObject.src;
	var A=B.width;
	var C=B.height;
	if(A>D||C>G){
		a=A/D;
		b=C/G;
		if(b>a){
			a=b;
		}
		A=A/a;
		C=C/a;
	}
	if(A>0&&C>0){
		imageObject.width=A;
		imageObject.height=C;
	}
}
//js调整图片大小保持比例，需要jquery。f是img组外框id或css属性接受'#list'或'.listcss'，w缩小的宽，h高
function resize(f,w,h){
$(f + " img").each(function(){   
    if($(this).width() > $(this).height()) {   
        $(this).width(w);
		$(this).height('');
    }else{
		$(this).width('');
		$(this).height(h);
	}
});
}
//打开新窗口
function OpenWindow(url, win_name, height, width){
	window.open(url,win_name,'height='+height+',width='+width+',top=0,left=0,toolbar=no,menubar=no,scrollbars=yes, resizable=no,location=no, status=no');
}
//滚动窗口
function roll(id,tag,step,delay) {
	this.it = null;
	this.init = function() {
		if ($('#'+id)[0].scrollHeight > $('#'+id)[0].offsetHeight+this.maxHeight()) {
			var its = this;
			this.it = setTimeout(function(){its.scroll();},delay);
			$('#'+id)[0].onmouseover = function(){clearTimeout(its.it);}
			$('#'+id)[0].onmouseout = function(){its.it=setTimeout(function(){its.scroll();},200);}
		}
	}
	this.scroll = function() {
		if ($('#'+id+" "+tag)[0].offsetHeight - $('#'+id)[0].scrollTop < step) {
			this.pause();
		} else {
			$('#'+id)[0].scrollTop += step;
			var its = this;
			this.it = setTimeout(function(){its.scroll();},10);
		}
	}
	this.pause = function() {
		clearInterval(this.it);
		$('#'+id)[0].appendChild($('#'+id+" "+tag)[0]);
		$('#'+id)[0].scrollTop = 0;
		var its = this;
		this.it = setTimeout(function(){its.scroll();},delay);
	}
	this.maxHeight = function() {
		var h = 0;
		var tags = $('#'+id+" "+tag);
		for (var i=0;i<tags.length;i++) {
			if (tags[i].offsetHeight > h) h = tags[i].offsetHeight;
		}
		return h;
	}
	this.init();
}

