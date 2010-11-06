/*
 * 
 * ImageScroller - a Image Horizental Scroll Viewer 
 * Version 0.1
 * @requires jQuery v1.2.1
 * 
 * Copyright (c) 2007 Luan
 * Email verycss-ok@yahoo.com.cn 
 * 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * 
 * Example:
 *   #viewer {height:100px; width:300px; clear:both; overflow:hidden; border:3px solid #e5e5e5;}
 *   #viewerFrame {width:505px; clear:both; padding:0;}
 *   #viewer img {width:90px; height:90px; margin:5px; display:inline; border:0;}
 *   #viewer a {display:block; float:left; width:100px; height:100px;}
 *   <script type="text/javascript">
 *   $(function(){
 *   	$("#viewer").imageScroller({
 *   	next:"btn1",
 *   	prev:"btn2",
 *   	frame:"viewerFrame",
 *   	child:"a",
 *   	auto:true
 *   	});	 
 *   });
 *   </script>
 *   <div id="viewer"><div id="viewerFrame">
 *   <a href=""><img src="pre1.jpg"></a>
 *   <a href=""><img src="pre2.jpg"></a>
 *   <a href=""><img src="pre3.jpg"></a>
 *   <a href=""><img src="pre4.jpg"></a>
 *   <a href=""><img src="pre5.jpg"></a>
 *   </div></div>
 *   <span id="btn1">prev</span><br/><span id="btn2">next</span>   
*/

jQuery.fn.imageScroller = function(params){
	var p = params || {
		next:"buttonNext",
		prev:"buttonPrev",
		frame:"viewerFrame",
		child:"a",
		auto:true
	}; 
	var _btnNext = $("#"+ p.next);
	var _btnPrev = $("#"+ p.prev);
	var _imgFrame = $("#"+ p.frame);
	var _child = p.child;
	var _auto = p.auto;
	var _itv;
	
	var turnLeft = function(){
		_btnPrev.unbind("click",turnLeft);
		if(_auto) autoStop();
		_imgFrame.animate( {marginLeft:-100}, 'fast', '', function(){
			_imgFrame.find(_child+":first").appendTo( _imgFrame );
			_imgFrame.css("marginLeft",0);
			_btnPrev.bind("click",turnLeft);
			if(_auto) autoPlay();
		});
	};
	
	var turnRight = function(){
		_btnNext.unbind("click",turnRight);
		if(_auto) autoStop();
		_imgFrame.find(_child+":last").clone().show().prependTo( _imgFrame );
		_imgFrame.css("marginLeft",-100);
		_imgFrame.animate( {marginLeft:0}, 'fast' ,'', function(){
			_imgFrame.find(_child+":last").remove();
			_btnNext.bind("click",turnRight);
			if(_auto) autoPlay(); 
		});
	};
	
	_btnNext.css("cursor","hand").click( turnRight );
	_btnPrev.css("cursor","hand").click( turnLeft );
	
	var autoPlay = function(){
	  _itv = window.setInterval(turnRight, 3000);
	};
	var autoStop = function(){
		window.clearInterval(_itv);
	};
	if(_auto)	autoPlay();
};
