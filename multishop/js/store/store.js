<!--
function previewstyle() {
	var editStyle=document.getElementById('editStyle');
	var demoStyle=document.getElementById('demoStyle');
	var previewBtn=document.getElementById('preview');
	var parentTable=document.getElementById('parentTable');

	if(editStyle.media=='all'){
		editStyle.media='print';
		demoStyle.media='all';
		parentTable.cellSpacing='0';
		previewBtn.value='返回编辑状态 ';
	} else {
		editStyle.media='all';
		demoStyle.media='print';
		parentTable.cellSpacing='5';
		previewBtn.value='预览';
	}
	
}

function previewbg(src, op) {
	if(op == 'preview') {
		if(setid == 'side') {
			setStyle('layout_0', 'backgroundImage', 'url(' + src + ')');
			setStyle('layout_2', 'backgroundImage', 'url(' + src + ')');
		} else if(setid == 'main') {
			setStyle('layout_1', 'backgroundImage', 'url(' + src + ')');
		} else if(setid == 'block' || setid == 'title') {
			setblockStyle(setid, 'backgroundImage', 'url(' + src + ')');
		} else {
			setStyle(setid, 'backgroundImage', 'url(' + src + ')');
		}

	} else if(op == 'resume') {
		getId(bgid).focus();
		getId(bgid).blur();
	}
}
//-->
function getId(id){
	return document.getElementById(id);
}
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = (userAgent.indexOf('opera') != -1);
var is_saf = ((userAgent.indexOf('applewebkit') != -1) || (navigator.vendor == 'Apple Computer, Inc.'));
var is_webtv = (userAgent.indexOf('webtv') != -1);
var is_ie = ((userAgent.indexOf('msie') != -1) && (!is_opera) && (!is_saf) && (!is_webtv));
var is_ie4 = ((is_ie) && (userAgent.indexOf('msie 4.') != -1));
var is_moz = ((navigator.product == 'Gecko') && (!is_saf));
var is_kon = (userAgent.indexOf('konqueror') != -1);
var is_ns = ((userAgent.indexOf('compatible') == -1) && (userAgent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_saf));
var is_ns4 = ((is_ns) && (parseInt(navigator.appVersion) == 4));
var is_mac = (userAgent.indexOf('mac') != -1);
var is_ff = (userAgent.indexOf('firefox') != -1);

var _Event = new Moz_event();
var Drag = new Drag_Events();
is_moz = is_moz || is_opera;

var oldclassName = '';
function Moz_event() {
	this.srcElement = null,
	this.setEvent = function(e) {
		_Event.srcElement = e.target;
		_Event.clientX = e.clientX;
		_Event.clientY = e.clientY;
	}
}

function Drag_Events() {
	this.dragged = false; //是否移动
	this.obj = null;	  //被移动对象
	this.tdiv = null;	  
	this.rootTable = null;
	this.layout = null;   //布局数组,其中包括左边,中间和右边部分
	this.disable = null;  //是否可用 	
	this.stylediv = 0;    
	this.getEvent = function() {
		if(is_ie) {
			return event;
		} else if(is_moz) {
			return _Event;
		}
	}
	//开始元素移动函数
	this.dragStart = function(event, disable) {
		if(Drag.dragged) return;
		Drag.disable = disable;
		if(is_ie) {
			document.body.onselectstart = function() {
				return false;
			}
		}
		Drag.obj = Drag.getEvent().srcElement;
		if((Drag.obj.tagName == "TD") || (Drag.obj.tagName == "TR")) {
			Drag.obj = Drag.obj.offsetParent.parentNode;
			Drag.obj.style.zIndex = 100;
		} else if((Drag.obj.tagName == "DIV")) {
			Drag.obj.style.zIndex = 100;
		} else if((Drag.obj.tagName == "H3") || (Drag.obj.tagName == "TR")) {
			Drag.obj = Drag.obj.parentNode;
			Drag.obj.style.zIndex = 100;
		} else if((Drag.obj.tagName == "H2")) {
			Drag.obj = Drag.obj.parentNode.offsetParent.parentNode;
			Drag.obj.style.zIndex = 100;
		} else {
			return;
		}

		Drag.dragged = true;
		Drag.tdiv = document.createElement("div");
		Drag.tdiv.innerHTML = Drag.obj.innerHTML;
		oldclassName = Drag.obj.className;
		Drag.obj.className = Drag.obj.className + ' hidden';
		Drag.tdiv.className = "tempDIV";
		Drag.tdiv.style.filter = "alpha(opacity=50)";
		Drag.tdiv.style.opacity = 0.5;
		Drag.tdiv.style.width = Drag.obj.offsetWidth + "px";
		Drag.tdiv.style.Height = Drag.obj.offsetHeight + "px";
		Drag.tdiv.style.top = Drag.getInfo(Drag.obj).top + "px";
		Drag.tdiv.style.left = Drag.getInfo(Drag.obj).left + "px";
		Drag.tdiv.style.zIndex = Drag.obj.style.zIndex + 1;
		document.body.appendChild(Drag.tdiv);
		Drag.lastX = Drag.getEvent().clientX;
		Drag.lastY = Drag.getEvent().clientY;
		Drag.lastLeft = parseInt(Drag.tdiv.style.left);
		Drag.lastTop = parseInt(Drag.tdiv.style.top) - document.body.scrollTop;
		if(is_ie) {
			event.returnValue = false;
		} else {
			event.preventDefault();
		}
	}
	//移动中处理函数
	this.onDrag = function() {
		if((!Drag.dragged) || Drag.obj == null) {
			return;
		}
		var tX = Drag.getEvent().clientX;
		var tY = Drag.getEvent().clientY;
		Drag.tdiv.style.left = parseInt(Drag.lastLeft) + tX - Drag.lastX;
		Drag.tdiv.style.top = parseInt(Drag.lastTop) + tY - Drag.lastY + document.body.scrollTop;
		if(Drag.obj.id.indexOf('style') == -1) {
			tY = tY + document.body.scrollTop;
			for(var i = 0; i < Drag.rootTable.cells.length; i++) {
				var parentCell = Drag.getInfo(Drag.rootTable.cells[i]);
				if(tX >= parentCell.left && tX <= parentCell.right && tY >= parentCell.top && tY <= parentCell.bottom) {
					var lid = Drag.rootTable.cells[i].id.replace('layout_', '');
					if ((',' + Drag.disable + ',').indexOf(',' + lid + ',') != -1) {
						return;
					}
					var subTables = Drag.rootTable.cells[i].getElementsByTagName("DIV");
					if(subTables.length == 0) {
						if(tX >= parentCell.left && tX <= parentCell.right && tY >= parentCell.top && tY <= parentCell.bottom) {
							Drag.rootTable.cells[i].appendChild(Drag.obj);
							Drag.resize();
						}
						break;
					}
					Drag.layout = lid;
					for(var j = 0; j < subTables.length; j++) {
						var subTable = Drag.getInfo(subTables[j]);
						if(Drag.obj != subTables[j] && tX >= subTable.left && tX <= subTable.right && tY >= subTable.top && tY <= subTable.bottom) {
							try {
								Drag.rootTable.cells[i].insertBefore(Drag.obj, subTables[j]);
								Drag.resize();
							} catch(e) {}
							break;
						} else {
							Drag.rootTable.cells[i].appendChild(Drag.obj);
							Drag.resize();
						}
					}
				}
			}
		}
		var s_area = Drag.getInfo(Drag.tdiv);
		if(tX > s_area.right) {
			Drag.tdiv.style.left = tX - 20 + "px";
		}
		if(tY > s_area.bottom) {
			Drag.tdiv.style.top = tY - 10 + "px";
		}
	}
	//移动停止处理函数
	this.dragEnd = function() {
		if(is_ie) {
			document.body.onselectstart = function() {
				return true;
			}
		}
		if(!Drag.dragged) {
			return;
		}
		Drag.obj.className = oldclassName;
		Drag.dragged = false;
		var pid = Drag.obj.previousSibling ? Drag.obj.previousSibling.id : Drag.obj.parentNode.id;
		
		if(Drag.layout != null) {
			Drag.clearResult(Drag.obj);   //在元素数组总删除被移动的元素
			//两边显示模式右边序列有元素被拖动到第一个位置时候pid出现undefined现象的处理
			if(pid == undefined) {
				pid = "";
			}
			
			if(layout[Drag.layout].indexOf(pid) != -1) {
				
				//后期添加,解决拖拽丢失模块问题
				if(pid==""){
					layout[Drag.layout] = "["+Drag.obj.id+"]"+layout[Drag.layout];
				} else {
					layout[Drag.layout] = layout[Drag.layout].replace('[' + pid + ']', '[' + pid + '][' + Drag.obj.id + ']');//此句话为原始语句
				}
			} else if(Drag.obj.id.indexOf('style') == -1) {
				layout[Drag.layout] = '[' + Drag.obj.id + '][' + layout[Drag.layout] + ']';
			}
			Drag.trimResult();
		}
		Drag.obj.style.zIndex = 1;
		if(Drag.obj.id.indexOf('style') != -1) {
			Drag.obj.style.top = Drag.getInfo(Drag.tdiv).top + "px";
			Drag.obj.style.left = Drag.getInfo(Drag.tdiv).left + "px";
		}
		
		Drag.tdiv.parentNode.removeChild(Drag.tdiv);
		Drag.obj = null;
	}

	this.getInfo = function(o) {
		var to = new Object();
		to.left = to.right = to.top = to.bottom = 0;
		var twidth = o.offsetWidth;
		var theight = o.offsetHeight;
		while(o) {
			to.left += o.offsetLeft;
			to.top += o.offsetTop;
			o = o.offsetParent;
		}
		to.right = to.left + twidth;
		to.bottom = to.top + theight;
		return to;
	}

	this.resize = function() {
		Drag.tdiv.style.width = Drag.obj.offsetWidth + "px";
	}
	//删除元素
	this.del = function(obj) {
		getId('module'+obj.id).checked = false;
		Drag.clearResult(obj);
		Drag.trimResult();
		obj.parentNode.removeChild(obj);
	}
	/**
	 * 添加模块
	 * @param layoutn:区域编号
	 * @param layoutid:区域ID
	 * @param divid:模块ID
	 * @param title:模块标题
	 * @param disable:禁止区域编号用","分割
	 */
	this.add = function(layoutn, divid, title, disable) {
		if(layoutn == 1) {
			var clone = getId('dragCloneMain').innerHTML;
		} else {
			var clone = getId('dragClone').innerHTML;
		}
		layoutid = 'layout_' + layoutn;
		if(getId(layoutid).style.display == 'none') {
			if(layoutn == 2) {
				layoutn = 0;
			} else if(layoutn == 0) {
				layoutn = 2;
			}
			layoutid = 'layout_' + layoutn;
		}
		
		clone = clone.replace(/\[id\]/g, divid);
		clone = clone.replace(/\[title\]/g, title);
		clone = clone.replace('[disable]', disable);
		
		if(layoutn == 1) {
			clone = clone.replace('[editblock]', '');
		} else {
			clone = clone.replace('[editblock]', '[编辑]');
		}
		getId(layoutid).innerHTML += clone;
		layout[layoutn] += '[' + divid + ']';
		Drag.trimResult();
	}
	//添加侧边栏内容和添加主显示区内容功能总检查被选中项目是否存在执行相应的显示和删除功能
	this.check = function(layoutn, divid, title, disable) {
		var exist = 0;
		//在初始化数组中搜索
		for (var side in layout) {
			var s = ']' + layout[side] + '[';
			s = s.split('][');
		
			for (var i in s) {
				if(s[i] == divid) {
					exist = 1;
					break;
				}
			}
		}
		//存在则删除,不存在则添加
		if (exist) {
			Drag.del(getId(divid));
		} else {
			Drag.add(layoutn, divid, title, disable);
		}
	}
	//把被移动元素在数组总清除
	this.clearResult = function(o) {
		for(i = 0; i < layout.length; i++) {
			layout[i] = layout[i].replace('[' + o.id + ']', '');
		}
	}
	//整理初始化数组为
	this.trimResult = function() {
		for(i = 0; i < layout.length; i++) {
			layout[i] = layout[i].replace('[]', '');
			layout[i] = layout[i].replace('[[', '[');
			layout[i] = layout[i].replace(']]', ']');
		}
	}
	
	this.mozinit = function() {
		//如果是fire浏览器这执行
		if(is_moz) {
			Drag.rootTable.cells = new Array();
			var tcells = Drag.rootTable.getElementsByTagName("TD");
			for(var i = 0; i < tcells.length; i++) {
				if(tcells[i].offsetParent == Drag.rootTable) {
					Drag.rootTable.cells.push(tcells[i]);
				}
			}
		}
	}
	//初始化
	this.init = function() {
		Drag.rootTable = getId("parentTable");
		Drag.mozinit();
		if(is_ie) {
			document.onmousemove = Drag.onDrag;
			document.onmouseup = Drag.dragEnd;
		} else if(is_moz) {
			document.body.setAttribute("onMouseMove", "_Event.setEvent(event);Drag.onDrag();");
			document.body.setAttribute("onMouseUp", "_Event.setEvent(event);Drag.dragEnd();");
		}
	}
	//清空某个侧边栏目内的元素
	this.clearSide = function(side) {
		if(side == 0) {
			targetside = 2;
		} else if(side == 2) {
			targetside = 0;
		} else {
			return;
		}
		targetcellid = 'layout_' + targetside;
		layout[targetside] += layout[side];
		var s = ']' + layout[side] + '[';
		s = s.split('][');
		for (var i in s) {
			if(s[i] != '') {
				getId(targetcellid).appendChild(getId(s[i]));
			}
		}
		layout[side] = '';
	}
}
//保存拖拽后的元素数组
function saveLayout() {
	getId('spacelayout0').value = layout[0];
	getId('spacelayout1').value = layout[1];
	getId('spacelayout2').value = layout[2];
}
//板式选择-1两边,0右边,2左边
function hideSide(sideid) {
	var alltd = getId('parentTable').getElementsByTagName('td');
	for(i=0;i<3;i++) {
		getId('layout_'+i).style.display = '';
	}
	if(sideid != -1) {
		getId('layout_'+sideid).style.display = 'none';
		Drag.clearSide(sideid);
	}
	getId('layout').value = sideid == 2 ? 1 : sideid == 0 ? 2 : 3;
	getId('slayout').value = sideid;
	Drag.mozinit();
}
//隐藏元素
function setdisplay(id) {
	dobj = getId(id);
	if(dobj.style.display == 'none' || dobj.style.display == '') {
		dobj.style.display = 'block';
		dobj.style.left = (Drag.getInfo(Drag.getEvent().srcElement).left+5) + 'px';
		dobj.style.top = (Drag.getInfo(Drag.getEvent().srcElement).top+10) + 'px';
	} else {
		dobj.style.display = 'none';
	}
}
//根据侧边样式设定功能的设定分别添加或删除元素
function selmodule(obj, modname, layoutid, forbid) {
	
	var allmod = document.getElementsByName(modname);
	
	for(k=0; k<allmod.length; k++) {
		if(allmod[k].type == 'checkbox') {
			if(allmod[k].checked == true && getId(allmod[k].value) == null) {
				/*if(layoutid == 0)
				{
					showMessage('block',allmod[k].value);
				}
				else
				{
					showMessage('show_',allmod[k].value);
				}*/
				Drag.check(layoutid, allmod[k].value, allmod[k].nextSibling.innerHTML, forbid);
			} else if(allmod[k].checked == false && getId(allmod[k].value) != null) {
				Drag.del(getId(allmod[k].value));
			}
		}
	}
}
//保存修改
function saveset() {
	getId('layout0').value = replace(layout[0]);
	getId('layout1').value = replace(layout[1]);
	getId('layout2').value = replace(layout[2]);
	getId('layout3').value = replace(layout[3]);
	return true;
}
//元素数组处理
function replace(str) {
	str = str.replace(/\]\[+/g, ',');
	str = str.replace(/\]+/g, '');
	str = str.replace(/\[+/g, '');
	str = str.replace(/\[\]+/g, '');
	return str;
}
var ColorHex = new Array('00','33','66','99','CC','FF')
var SpColorHex = new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF')
var current = null
var btobj, outid, bgid, setid;

function intocolor(divid,  obj, oid) {
	var colorTable = '';
	btobj = obj;
	outid = oid;
	for (i=0; i<2; i++) {
		for (j=0; j<6; j++) {
			colorTable = colorTable+'<tr height=12>'
			colorTable = colorTable+'<td width=11 style="cursor:pointer;background-color:#000000">'

			if (i == 0) {
				colorTable = colorTable+'<td width=11 style="cursor:pointer;background-color:#'+ColorHex[j]+ColorHex[j]+ColorHex[j]+'">';
			} else {
				colorTable = colorTable+'<td width=11 style="cursor:pointer;background-color:#'+SpColorHex[j]+'">'
			}
			colorTable = colorTable+'<td width=11 style="cursor:pointer;background-color:#000000">'
			for (k=0;k<3;k++) {
				for (l=0;l<6;l++) {
					colorTable=colorTable+'<td width=11 style="cursor:pointer;background-color:#'+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'">'
				}
			}
		}
	}
	colorTable='<table cellpadding="0" cellspacing="1" border="0" style="border-collapse: collapse;width:100%; background:#000;"><tr><td align="right" style="padding: 3px 2px 0 0;"><span style="cursor:pointer; color: #FFF;" onClick="setdisplay(\'selcolor\');">关闭</span></td></tr></table>'+'<table border="1" id="selcolortable" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="000000" onclick="doclick()" style="cursor:pointer;">'
				+colorTable+'</table><table cellpadding="0" cellspacing="0" width="100%" border="0" style="background: #666; border: 1px solid #000; border-top: none;"><tr><td style="text-align:center; padding-top: 2px;"><span style="cursor:pointer; color: #FFF; background: transparent;" onClick="doclick()">使用透明背景</span>&nbsp;&nbsp;<span style="cursor:pointer; color: #FFF;" onClick="doclick()">无色</span></td></tr></table>';
	getId(divid).innerHTML=colorTable
}

function doclick() {
	var bgcolor = Drag.getEvent().srcElement.style.backgroundColor;
	if(bgcolor.indexOf('rgb(') != -1) {
		re = /reg\((.*)\)+$/ig
		bgcolor = bgcolor.replace(/rgb\(/ig,'');
		bgcolor = bgcolor.replace(/\)/ig,'');
		var colorarr = bgcolor.split(',');
		bgcolor = "#" +toHex(colorarr[0]) + toHex(colorarr[1]) + toHex(colorarr[2]);
	}
	btobj.style.backgroundColor = bgcolor;
	getId(outid).focus();
	getId(outid).value = bgcolor;
	getId(outid).blur();
	setdisplay('selcolor');
}
function toHex(d) {
	if (isNaN(d)) {
		d = 0;
	}
	var n = new Number(d).toString(16);
	return (n.length==1?"0"+n:n);
}
function setStyle (item, style, value) {
    var e = document.getElementById(item);
    if (!e) return;
    try{
		e.style[style] = value;
	}catch(e){}
}
function setblockStyle(item, style, value) {
	var stylearr = replace(layout[0]+layout[2]).split(',');
	for(i=0; i < stylearr.length; i++) {
		setStyle(item+stylearr[i], style, value);
	}
	if(item == 'title') {
		setStyle('title[id]', style, value);
	} else {
		setStyle('block[id]', style, value);
	}
}

function test(item, style, value) {
	var stylearr = replace(layout[0]+layout[2]).split(',');
	for(i=0; i < stylearr.length; i++) {
		setStyle(item+stylearr[i], style, value);
	}
	if(item == 'title') {
		setStyle('title[id]', style, value);
	} else {
		setStyle('block[id]', style, value);
	}
}

//设置链界样式
function setHyperlinkStyle (style, value) {
	var hyperlinks = document.getElementById("wrap").getElementsByTagName("a");
	for (var i = 0; i < hyperlinks.length; i++) {
		if(hyperlinks[i].className != "editbtn")
			try{
				hyperlinks[i].style[style] = value;
			}catch(e){}
	}
}

//设置背景样式
function setbg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setselbgstyle');
}

//设置 页面整体 样式 对应的背景动作为setselallbgstyle
function setallbg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setselallbgstyle');
}

//设置 头部样式 样式 对应的背景动作为setseltopbgstyle
function settopbg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setseltopbgstyle');
}

//设置 主体样式 对应的背景动作为setseltopbgstyle
function setmainbg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setselmainbgstyle');
}

//设置 侧边栏样式 对应的背景动作为setselsidebgstyle
function setsidebg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setselsidebgstyle');
}

//设置 主显示区样式 对应的背景动作为setselmainshowbgstyle
function setmainshowbg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setselmainshowbgstyle');
}

//设置 侧边栏每个栏目的头样式 对应的背景动作为setselsidemodulebgstyle
function setsidemodulebg(value) {
	getId(bgid).focus();
	if(value != '') {
		getId(bgid).value = value;
	} else {
		getId(bgid).value = '';
	}
	getId(bgid).blur();
	setdisplay('setselsidemodulebgstyle');
}

//设置鼠标样式
function setcursor(str) {
	getId('cursor').focus();
	getId('cursor').value = str;
	getId('cursor').blur();
	setdisplay('setmousestyle');
}