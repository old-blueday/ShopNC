// show dialog window
var t_DiglogX,t_DiglogY,t_DiglogW,t_DiglogH;
var pageWidth,pageHeight;

function gid(id) {
	return document.getElementById?document.getElementById(id):null;
}

function gname(name) {
	return document.getElementsByTagName?document.getElementsByTagName(name):new Array()
}

function Browser() {
	var ua, s, i;
	this.isIE = false;
	this.isNS = false;
	this.isOP = false;
	this.isSF = false;
	ua = navigator.userAgent.toLowerCase();
	s = "opera";
	if ((i = ua.indexOf(s)) >= 0) {
		this.isOP = true;return;
	}
	s = "msie";
	if ((i = ua.indexOf(s)) >= 0) {
		this.isIE = true;return;
	}
	s = "netscape6/";
	if ((i = ua.indexOf(s)) >= 0) {
		this.isNS = true;return;
	}
	s = "gecko";
	if ((i = ua.indexOf(s)) >= 0) {
		this.isNS = true;return;
	}
	s = "safari";
	if ((i = ua.indexOf(s)) >= 0) {
		this.isSF = true;return;
	}
}

function DialogLoc() {
	var dde = document.documentElement;
	if (window.innerWidth) {
		var ww = window.innerWidth;
		var wh = window.innerHeight;
		var bgX = window.pageXOffset;
		var bgY = window.pageYOffset;
	} else {
		var ww = dde.offsetWidth;
		var wh = dde.offsetHeight;
		var bgX = dde.scrollLeft;
		var bgY = dde.scrollTop;
	}
	t_DiglogX = (bgX + ((ww - t_DiglogW)/2));
	t_DiglogY = (bgY + ((wh - t_DiglogH)/2));
}

function DialogShow(showdata,ow,oh,w,h) {
	var objDialog = document.getElementById("DialogMove");
	if (!objDialog) objDialog = document.createElement("div");
	t_DiglogW = ow;
	t_DiglogH = oh;
	DialogLoc();
	objDialog.id = "DialogMove";
	var oS = objDialog.style;
	oS.display = "block";
	oS.top = t_DiglogY + "px";
	oS.left = t_DiglogX + "px";
	oS.margin = "0px";
	oS.padding = "0px";
	oS.width = w + "px";
	oS.height = h + "px";
	oS.position = "absolute";
	oS.zIndex = "5";
	oS.background = "#FFF";
	oS.border = "solid #000 3px";
	objDialog.innerHTML = showdata;
	document.body.appendChild(objDialog);
}

function DialogHide() {
	ScreenClean();
	var objDialog = document.getElementById("DialogMove");
	if (objDialog) objDialog.style.display = "none";
	//window.location.reload();
	getAttribute('attribute.manage.php?action=ajax_show&pcid=' + pcid);
}

function ScreenConvert() {
	var browser = new Browser();
	var objScreen = gid("ScreenOver");
	var psize = getPageSize();
	if (!objScreen) var objScreen = document.createElement("div");
	var oS = objScreen.style;
	objScreen.id = "ScreenOver";
	oS.display = "block";
	oS.top = oS.left = oS.margin = oS.padding = "0px";
	/*
	if (document.body.clientHeight) {
	var wh = document.body.clientHeight + "px";
	} else if (window.innerHeight) {
	var wh = window.innerHeight + "px";
	} else {
	var wh = "100%";
	}
	oS.width = "100%";
	oS.height = wh;
	*/
	var pageWidth = psize[0];
	var pageHeight = psize[1];
	oS.width = pageWidth+"px";
	oS.height = pageHeight+"px";
	oS.position = "absolute";
	oS.zIndex = "3";
	if ((!browser.isSF) && (!browser.isOP)) {
		oS.background = "#686868";
	} else {
		oS.background = "#F0F0F0";
	}
	oS.filter = "alpha(opacity=40)";
	oS.opacity = 40/100;
	oS.MozOpacity = 40/100;
	document.body.appendChild(objScreen);
	var allselect = gname("select");
	for (var i=0; i<allselect.length; i++) allselect[i].style.visibility = "hidden";
}

function ScreenClean() {
	var objScreen = document.getElementById("ScreenOver");
	if (objScreen) objScreen.style.display = "none";
	var allselect = gname("select");
	for (var i=0; i<allselect.length; i++) allselect[i].style.visibility = "visible";
}

function getPageSize(){

	var xScroll, yScroll;

	if (window.innerHeight && window.scrollMaxY) {
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}

	var windowWidth, windowHeight;
	if (self.innerHeight) { // all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}

	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else {
		pageHeight = yScroll;
	}
	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}


	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight)
	return arrayPageSize;
}

