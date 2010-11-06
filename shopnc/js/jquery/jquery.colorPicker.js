(function($) {

	var loc={Top:-1,Left:-1,Width:-1,Height:-1};
	var isOn=false;

	$.fn.colorPicker=function(vIn) {

		var obj=this;


		if (vIn) {
			if (vIn.constructor != Object) {
				vIn = { setBackground : vIn }
			}
		}
		else {
			vIn = {};
		}
		var opt=setDefaults();

		$.extend(opt,vIn);

		$.each(opt,function(n,v) {
			if(v!=false&&n!='align') {

				if (typeof v=='string' || isDOM(v))
					opt[n] = $(v);
				else if (v==true) {
					opt[n] = obj;
				}
				else if (!isJQuery(v))
					opt[n] = false;
			}
		});
		if (opt.align.toLowerCase()!='left') opt.align='right';


		var cp = $('#fy_ColorPicker');
		var cf=$('#fy_CP_Frame');
		if (cp.length==0) {
			cp = $('<div id="fy_ColorPicker"></div>');
			cp.css({"position":"absolute","z-index":"100","background-color":"#FFFFFF","border":"1px solid #CCCCCC","padding":"1px","cursor":"pointer","display":"none"});
			var hc = ["FF","CC","99","66","33","00"];
			var i=0,j=0;
			var r,g,b,c;
			var s = new Array();
			s[0] = '<table cellspacing="1" cellpadding="0" style="table-layout:fixed"><tr>';
			for(r=0;r<6;r++) {
				for(g=0;g<6;g++) {
					for(b=0;b<6;b++) {
						c = hc[r] + hc[g] + hc[b];
						if (i%18==0 && i>0) {
							s[j+1] = "</tr><tr>";
							j++;
						}
						s[j+1] = '<td class="color" bgcolor="#'+c+'" height="10" width="10" style="width:10px"></td>';
						i++;
						j++;
					}
				}
			}
			s[j+1] = '</tr><tr><td height="10" colspan="16" id="fy_ColorPicker_Select" style="font-family:Tamoha;font-size:10px;text-align:center;cursor:default;"></td><td class="color" bgcolor="" height="10" colspan="1" title="Empty" align="center" style="font-family:Tamoha;font-size:10px">E</td><td class="color" bgcolor="transparent" height="10" colspan="1" title="Transparent" align="center" style="font-family:Tamoha;font-size:10px">T</td></tr></table>';
			cp.html(s.join(''));
			cp.prependTo('.rc_con');

			if($.browser.msie&&cf.length==0) {
				cf=$('<iframe scrolling="no" frameborder="0" style="position:absolute;z-index:99;display:none" id="fy_CP_Frame"></iframe>');
				cf.prependTo('.rc_con');
			}
		}


		var tl=GetLoc(obj[0]);

		if (cp.is(':visible')&&tl.Top==loc.Top&&tl.Left==loc.Left) {
			cp.hide();
			if($.browser.msie) cf.hide();
		}
		else {
			loc = tl;

			cp.css({"left":(tl.Left)+(opt.align.toLowerCase()!='left'?tl.Width:0)+"px","*left":(tl.Left)+(opt.align.toLowerCase()!='left'?tl.Width:0+30)+"px","top":(tl.Top+tl.Height-40)+"px","*top":(tl.Top+tl.Height-10)+"px"});
			tl = GetLoc(cp[0]);
			cf.css({"left":tl.Left,"top":tl.Top,"width":tl.Width,"height":tl.Height});
			cp.show();
			if($.browser.msie) cf.show();


			$(document).click(function(e) {
				var t=$.browser.msie?window.event.srcElement:e.target;
				if(!compareObj(t) && $('#fy_ColorPicker').is(':visible') && t.id!="fy_ColorPicker" && $(t).parents("#fy_ColorPicker").length==0) {
					$("#fy_ColorPicker").hide();
					if($.browser.msie) cf.hide();
				}
			});

			$('.color',cp).unbind("mouseover").unbind("click").mouseover(function() {
				setSelect(this.bgColor.toUpperCase());
			}).click(function() {
				setColorValue(this.bgColor.toUpperCase(),opt);
			});
		}
	};

	function compareObj(obj) {
		//$(obj[0].nodeName).index(obj[0])==$(obj[0].nodeName).index(t)
		var oloc=GetLoc(obj);
		return loc.Top==oloc.Top&&loc.Left==oloc.Left&&loc.Width==oloc.Width&&loc.Height==oloc.Height;
	}

	function setDefaults() {
		return {
		setBackground: true,
		setValue: false,
		setColor: false,
		setText: false,
		align: 'left'
		}
	}

	function setColorValue(v,vIn) {
		var v=v=='TRANSPARENT'?'transparent':v;
		$('#fy_ColorPicker').hide();
		if(vIn.setBackground!=false) {
			vIn.setBackground.css('background-color',v);
		}
		if(vIn.setColor!=false) {
			vIn.setColor.css('color',v);
		}
		if(vIn.setValue!=false) {
			vIn.setValue.val(v);
		}
		if(vIn.setText!=false) {
			vIn.setText.text(v);
		}
	}

	function GetLoc(element) {
		if ( arguments.length != 1 || element == null ) { 
			return null;
		} 
		var offsetTop = element.offsetTop; 
		var offsetLeft = element.offsetLeft; 
		var offsetWidth = element.offsetWidth; 
		var offsetHeight = element.offsetHeight; 
		while( element = element.offsetParent ) { 
			offsetTop += element.offsetTop;
			offsetLeft += element.offsetLeft;
		}
		return { Top: offsetTop, Left: offsetLeft, Width: offsetWidth, Height: offsetHeight };
	}

	function setSelect(v) {
		var v=v=='TRANSPARENT'?'transparent':v;
		$("#fy_ColorPicker_Select").css('background-color',v).text(v);
	}

	function isDOM(vIn) {
		return (typeof vIn=='object' && !!vIn.nodeName);
	}

	function isJQuery(vIn) {
		return (typeof vIn=='object' && !!vIn.attr);
	}
})(jQuery);
