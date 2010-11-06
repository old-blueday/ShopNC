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



