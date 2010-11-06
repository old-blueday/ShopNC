/*    06/2/2010
		PikaChoose
	Jquery plugin for photo galleries
    Copyright (C) 2010 Jeremy Fry

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

(function (jQuery) {
	jQuery.fn.PikaChoose = function (user_options) {
		var defaults = {
			show_captions: true,
			auto_play: false,
			show_prev_next: true,
			slide_speed: 5000,
			thumb_width: 90,
			thumb_height: 60,
			buttons_text: { play: "", stop: "", previous: "Previous", next: "Next" },
			delay_caption: true,
			user_thumbs: false,
			transition:[-1],
			IESafe: false
		};
				
		return jQuery(this).each(
			function() 
			{
				function CreateThumbnail()
				{
					var image = jQuery(this);
					var aParent = jQuery(this).parent('a');
					if(aParent.length == 0){ aParent = jQuery(this); }
					aParent.hide();
					jQuery(this).attr('pikaLink', aParent.attr('href'));
					//pull it out of the a tag
					image = jQuery(this).clone(true).insertAfter(aParent);
					jQuery(this).removeClass('pika_first');
					//wait for load to remove previous or ie will never see the page loaded
					jQuery(this).bind("load",function(){ aParent.remove(); });
					jQuery('<img />').load(function()
					{
						var w = image.width();
						var h = image.height();
						if(w===0){w = image.attr("width");}
						if(h===0){h = image.attr("height");}
						//grab a ratio for image to user defined settings
						var rw = options.thumb_width/w;
						var rh = options.thumb_height/h;
						
						//determine which has the smallest ratio (thus needing
						//to be the side we use to scale so our whole thumb is filled)
						var ratio;
						if(rw<rh){
							//we'll use ratio later to scale and not distort
							ratio = rh;
							var left = ((w*ratio-options.thumb_width)/2)*-1;
							left = Math.round(left);
							//set images left offset to match
							image.css({left:0});
						}else{
							ratio = rw;
							var top = 0;
							image.css({top:0});
						}
						//use those ratios to calculate scale
						var width = Math.round(w*ratio);
						var height = Math.round(h*ratio);
						image.css("position","relative");
						image.width(width).height(height);
						var imgcss={
							width: options.thumb_width+"px",
							height: options.thumb_height+"px"
						};
						image.css(imgcss);					
						image.hover(
							function(){jQuery(this).fadeTo(250,1);},
							function(){if(!jQuery(this).hasClass("pika_selected")){jQuery(this).fadeTo(250,0.4);}}
						);
						if(ulist.children('li').find('img:last').index(image)==0){
							image.fadeTo(250,1);	
						}else{
							image.fadeTo(250,0.4);	
						}
						jQuery(this).show();
					}).attr('src',image.attr('src'));
					//reset images to the clones
					
					images = ulist.children('li').find('img:last');
				}
				//bring in options
				var tranStep = 0;
				var options = jQuery.extend(defaults, user_options);
				var images = jQuery(this).children('li').find('img');
				images.hide();
				//save our list for future ref
				var ulist = jQuery(this);
				ulist.children("li:last").children("img").addClass("pika_last");
				images.each(CreateThumbnail);
				//start building structure
				jQuery(this).before("<div class='pika_main'></div>");
				// houses eveything about the UL
				var main_div = jQuery(this).prev(".pika_main");
				
				//add in slideshow elements when appropriate
				main_div.append("<div class='pika_play'></div>");
				var play_div = jQuery(this).prev(".pika_main").children(".pika_play");
				play_div.html("<a class='pika_play_button'>" + options.buttons_text.play + "</a><a class='pika_stop_button'>" + options.buttons_text.stop + "</a>");
				play_div.fadeOut(1);
				var play_anchor = play_div.children('a:first');
				var stop_anchor = play_div.children('a:last');
				//this div is used to make image and caption fade together
				main_div.append("<div class='pika_subdiv' id='pika_subdiv'></div>");
				var sub_div = main_div.children(".pika_subdiv");
				//the main image we'll be using to load
				var firstImage = ulist.find("img:first");
				if(options.user_thumbs)
				{		
					firstImage = firstImage.attr('ref');
				}else
				{
					firstImage = firstImage.attr('src');
				}
				
				
				sub_div.append("<img class='pika_main_img' src='"+firstImage+"' />");
				sub_div.append("<div class='pika_animationDivs'>");
				var ani_divs = sub_div.find(".pika_animationDivs");
				ani_divs.css({'position':'absolute','width':'100%','height':'100%'});
			
				var y = 0;
				var x = 0;
				for(var t = 0; t<25;t++)
				{
					var a = '<div col="'+y+'" row="'+x+'"></div>';
					ani_divs.append(a);
					y++
					if(y == 5)
					{
						x++;
						y=0;
					}
				}
				ani_divs.children(':last').addClass("pikaLastAni");
				var main_img = sub_div.children("img");
				//build custom overlays. These will use navigation div
				sub_div.append("<div class='pika_prev_hover'></div><div class='pika_next_hover'></div>");
				var prevHover = sub_div.find('.pika_prev_hover');
				var nextHover = sub_div.find('.pika_next_hover');
				prevHover.hide();
				nextHover.hide();
				//create the caption div when appropriate
				if(options.show_captions){
					main_div.append("<div class='pika_caption'></div>");
					var caption_div = main_div.children(".pika_caption");
				}
				
				//navigation div ALWAYS gets created, its refrenced a lot				
				ulist.after("<div class='pika_navigation'></div>");
				var navigation_div = jQuery(this).next(".pika_navigation");
				//fill in sub elements
				navigation_div.append("<a>" + options.buttons_text.previous + "</a> :: <a>" + options.buttons_text.next + "</a>");
				var previous_image_anchor = navigation_div.children('a:first');
				var next_image_anchor = navigation_div.children('a:last');
				
				//hide the navigation if the user doesn't want it
				if(!options.show_prev_next){
					navigation_div.css("display","none");
				}
				
				//playing triggers the loop for the slideshow
				var playing = options.auto_play;
				var animating = false;
				main_img.wrap("<a id='main_img_a'></a>");
				var main_link = main_img.parent("a");
				$('body').append('<img style="display:none" id="disimg" />')

				
			function activate()
			{
				//sets the intial phase for everything
				
				//image_click is controls the fading
				images.bind("click",image_click);
				//hiding refrence to slide elements if slide is disabled
				
				if(options.auto_play){
					playing = true;
					play_anchor.hide();
					stop_anchor.show();
				}else{
					play_anchor.show();
					stop_anchor.hide();
				}
			
				
				ulist.children("li:last").children("img").addClass("pika_last");
				ulist.children("li:first").children("img").addClass("pika_first");
				ulist.children("li").each(function(){ jQuery(this).children("span").hide(); });
				//css for the list
				var divcss = {
					width: options.thumb_width+"px",
					height: options.thumb_height+"px",
					"list-style": "none",
					overflow: "hidden"
				};
				var licss = {
					"list-style": "none",
					overflow: "hidden"
				};
				images.each(function(){
					jQuery(this).parent('li').css(licss);
					jQuery(this).wrap(document.createElement("div"));
					jQuery(this).parent('div').css(divcss);
				});
				//previous link to go back an image
				previous_image_anchor.bind("click",previous_image);
				prevHover.bind("click",previous_image);
				//ditto for forward, also the item that gets auto clicked for slideshow
				next_image_anchor.bind("click",next_image);
				nextHover.bind("click",next_image);	
				
				//enable mouse tracking for the hover
				sub_div.mousemove(function(e){
					var w = sub_div.width();
					var x = e.pageX - sub_div.offset().left;
      			if(x<w*0.3)
      			{
      				prevHover.fadeIn('fast');
      			}else{
     					prevHover.fadeOut('fast');
     				}
      			if(x>w*0.7)
      			{
      				nextHover.fadeIn('fast');	
      			}else{
      				nextHover.fadeOut('fast');	
      			}
   			});
   			sub_div.mouseleave(function(){ prevHover.fadeOut('fast');nextHover.fadeOut('fast'); });

			}//end activate function
			
			function Gapper(ele, aHeight)
			{
				if(ele.attr('row') == 9 && ele.attr('col') == 0)
				{
					//last row, check the gap and fix it!
					var gap = ani_divs.height()-(aHeight*9);
					return gap;
				}
				return aHeight;
			}
			
			
			function AnimateImage(image_source, image_link,how)
			{
				
				//main_img.hide();
				jQuery('<img />').load(function()
				{
					ani_divs.show();
					ani_divs.children('div').css({'width':'20%','height':'20%','float':'left'});

					var aWidth = ani_divs.children('div:first').width();
					var aHeight = ani_divs.children('div:first').height();
					if(how!="autoFirst"){
						ani_divs.children().each(function()
						{
							//position myself absolutely
							var div = jQuery(this);
							var xOffset = Math.floor(div.parent().width()/5)*div.attr('col');
							var yOffset = Math.floor(div.parent().height()/5)*div.attr('row');
							div.css({
								'background':'url('+image_source+') -'+xOffset+'px -'+yOffset+'px',
								'width':'0px',
								'height':'0px',
								'position':'absolute',
								'top':yOffset+'px',
								'left':xOffset+'px',
								'float':'none'
							});
						});//end ani_divs.children.each
					}

					//decide our transition
					var n = 0;
					if(options.transition[0] == -1)
					{	//random
						n = Math.floor(Math.random()*6);
					}else{
						n = options.transition[tranStep];
						tranStep++;
						if(tranStep >= options.transition.length){tranStep=0;}
					}
					if(options.IESafe == true)
					{
						if(jQuery.browser.msie)
						{
							n = 0;
						}
					
					}
					
					switch(n)
					{
						case 0:
							//full frame fade
							ani_divs.height(main_img.height()).hide().css({'background':'url('+image_source+') top left no-repeat'});
							ani_divs.children('div').hide();
							ani_divs.fadeIn('slow',function(){
								FinishedAnimating(image_source,image_link);
								ani_divs.css({'background':'transparent'});
							});

							break;
						case 1:
							ani_divs.children().hide().each(function(index)
							{  
								//animate out as blocks 
								var delay = index*10;
								jQuery(this).delay(delay).animate({"width":aWidth,"height":aHeight},800,'linear',function()
								{
									if(jQuery(this).hasClass('pikaLastAni'))
									{
										FinishedAnimating(image_source,image_link);
									}
								});
							});
							break;
						case 2:
							ani_divs.children().hide().each(function(index)
							{
								var delay = jQuery(this).attr('row')*10;
								jQuery(this).css({"width":aWidth}).delay(delay).animate({"height":aHeight},800,'linear',function()
								{
									if(jQuery(this).hasClass('pikaLastAni'))
									{
										FinishedAnimating(image_source,image_link);
									}
								});
							});
							break;						
						case 3:
							ani_divs.children().hide().each(function(index)
							{
								var delay = jQuery(this).attr('col')*10;
								aHeight = Gapper(jQuery(this), aHeight);
								jQuery(this).css({"height":aHeight}).delay(delay).animate({"width":aWidth},800,'linear',function()
								{
									if(jQuery(this).hasClass('pikaLastAni'))
									{
										FinishedAnimating(image_source,image_link);
									}
								});
							});
							break;
						case 4:
							ani_divs.children().show().each(function(index)
							{
								var delay = index*Math.floor(Math.random()*5)*10;
								aHeight = Gapper(jQuery(this), aHeight);
								
								if(jQuery(this).hasClass('pikaLastAni'))
								{
									delay = 800;
								}
								jQuery(this).css({"height":aHeight,"width":aWidth,"opacity":.01}).delay(delay).animate({"opacity":1},800,function()
								{
									if(jQuery(this).hasClass('pikaLastAni'))
									{
										FinishedAnimating(image_source,image_link);
									}
								});
							});
							break;
						case 5:
							//full frame slide
							ani_divs.height(main_img.height()).hide().css({'background':'url('+image_source+') top left no-repeat'});
							ani_divs.children('div').hide();
							ani_divs.css({width:0}).animate({width:main_img.width()},'slow',function(){
								FinishedAnimating(image_source,image_link);
								ani_divs.css({'background':'transparent'});
							});

							break;
					}
				}).attr('src',image_source);//end image preload
			
			}// end animate images
			
			function FinishedAnimating(image_source,image_link)
			{
					
				animating = false;
				main_img.attr("src", image_source);
				if(image_link == null){image_link = "#"}
				main_link.attr("href", image_link);
				ani_divs.children().css({"background":"transparent"});
				ani_divs.hide();
				if(playing)
				{
					main_img.animate({opacity:1},options.slide_speed, function()
					{
						//redudency needed here to catch the user clicking on an image during a change.
						if(playing){next_image_anchor.trigger("click",["auto"]);}
					});
				}
				
				var ph=$('.pika_main').height();
				var ih=$('#disimg').height();
				var pw=$('.pika_main').width();
				var iw=$('#disimg').width();
				var mainh=(ph-ih)/2;
				var mainw=(pw-iw)/2;
			
				$('#main_img_a').css({
				'top':mainh+'px'
				});
				ani_divs.css({
				'left':mainw+'px',
				'top':mainh+'px'
				});

			}
			function image_click(event, how){
					//catch when user clicks on an image Then cancel current slideshow
					if(jQuery(this).hasClass('pika_selected') || animating){ return; }
					if(how!="auto" && how!="autoFirst"){
						animating = true;
						stop_anchor.hide();
						play_anchor.show();
						playing=false;
					
						main_img.stop().dequeue();
						if(options.show_captions)
						{
							caption_div.stop().dequeue();
						}
					}
					//all our image variables
					var image_source = "";
					if(options.user_thumbs)
					{		
						image_source = jQuery(this).attr("ref");
					}else
					{
						image_source = this.src;
					}
					$('#disimg').attr('src',image_source);
					var ph=$('.pika_main').height();
					var ih=$('#disimg').height();
					var pw=$('.pika_main').width();
					var iw=$('#disimg').width();
					var mainh=(ph-ih)/2;
					var mainw=(pw-iw)/2;
					if(document.all){
						mainw=mainw+2;
					}
				
					ani_divs.css({
					'left':mainw+'px',
					'top':mainh+'px',
					'width':iw+'px',
					'height':ih+'px'
					});
					
					//thumbnail animations
					var image_link = jQuery(this).attr("pikalink");
					var image_caption = jQuery(this).parent().next("span").html();
					//fade out the old thumb
					images.filter(".pika_selected").fadeTo(250,0.4); 
					images.filter(".pika_selected").removeClass("pika_selected"); 
					//fade in the new thumb
					jQuery(this).fadeTo(250,1);
					jQuery(this).addClass("pika_selected");
					//fade the caption out
					if(options.show_captions)
					{
						if(options.delay_caption)
						{
							caption_div.fadeTo(800,0);
						}
						caption_div.fadeTo(500,0,function(){
							caption_div.html(image_caption);
							caption_div.fadeTo(800,1);
						});
					}
					AnimateImage(image_source, image_link, how);
					
			}//end image_click function
			
			function next_image(event, how){
				if(images.filter(".pika_selected").hasClass("pika_last")){
					images.filter(":first").trigger("click",how);
				}else{
					images.filter(".pika_selected").parents('li').next('li').find('img').trigger("click",how);
				}
				
			}//end next image function
			
			function previous_image(event, how){
				if(images.filter(".pika_selected").hasClass("pika_first")){
					images.filter(":last").trigger("click",how);
				}else{
					images.filter(".pika_selected").parents('li').prev('li').find('img').trigger("click",how);
				}
				
			}//end previous image function
			
			function play_button(){
				main_div.hover(
					function(){play_div.fadeIn(400);},
					function(){play_div.fadeOut(400);}
				);
				play_anchor.bind("click", function(){
					main_img.stop();
					main_img.dequeue();
					if(options.show_captions)
					{
						caption_div.stop();
						caption_div.dequeue();
					}
					playing = true;
					next_image_anchor.trigger("click",["auto"]);
					jQuery(this).hide();
					stop_anchor.show();
				});
				stop_anchor.bind("click", function(){
					playing = false;
					jQuery(this).hide();
					play_anchor.show();
				});
			}
			play_button();
			activate();
			ulist.children('li:first').find('img:last').trigger("click",["autoFirst"]);
			
		});//end return this.each
	}//end build function
	
	//activate applies the appropriate actions to all the different parts of the structure.
	//and loads the sets the first image
})(jQuery);