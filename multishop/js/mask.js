$(document).ready(function(){
	//$(window).scroll(resscrEvt(block_id));
	//$(window).resize(resscrEvt(block_id));
	//resscrEvt(block_id);
});

function showWin(id){
	var bH=document.body.clientHeight;
	var bW=document.body.offsetWidth;
	$("#"+id).after("<div id='mask_fullBg' style='background-color: Gray;display:none;z-index:3;position:absolute;left:0px;top:0px;filter:Alpha(Opacity=30);-moz-opacity:0.4; opacity: 0.4; '></div>");
	$("#mask_fullBg").css({'width':bW+"px",'height':bH+"px","display":"block"});
	$("#"+id).fadeIn("fast");
}

function closeWin(id){
	$("#mask_fullBg").fadeOut('slow');
	$("#"+id).css("display","none");
}

function objValue(obj){
	var st=document.documentElement.scrollTop;
	var sl=document.documentElement.scrollLeft;
	var ch=document.documentElement.clientHeight;
	var cw=document.documentElement.clientWidth;
	var objH=$("#"+obj).height();
	var objW=$("#"+obj).width();
	var objT=Number(st)+(Number(ch)-Number(objH))/2;
	var objL=Number(sl)+(Number(cw)-Number(objW))/2;
	return objT+"|"+objL;
}

function resscrEvt(id){
	var bjCss=$("#mask_fullBg").css("display");
	if(bjCss=="block"){
	var bH2=$(window).height() + $(window).scrollTop();
	var bW2=$(window).width() +$(window).scrollLeft();
	$("#mask_fullBg").css({width:bW2,height:bH2});
	var objV=objValue(id);
	var tbT=objV.split("|")[0]+"px";
	var tbL=objV.split("|")[1]+"px";
	$("#"+id).css({top:tbT,left:tbL});
	}
}