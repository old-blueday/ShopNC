<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<?php SITE_URL; ?>
				<div class="io-3">
					<p><?php echo $lang['langShopMapExplain']; ?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopMapLocality']; ?></p></span></li>
					</ul>
				</div>
				<form name="form1" action="own_shopmap.php?action=save" method="post" style="width:580px; float:left;">
				<div class="cr-right">
				   
				    <div id="placePath"></div>
					<div id="placeChildren"></div>
					<div id="myMap" style="position:relative; align:center; width:580px; height:300px;"></div>
					<div align="center">
						<input name="shopid" type="hidden" value="<?php echo $output['shopid']; ?>"/>
						<input name="userid" type="hidden" value="<?php echo $output['userid']; ?>"/>
						<input name="weizhiX" id="weizhiX" type="hidden" />
						<input name="weizhiY" id="weizhiY" type="hidden" />
						<input name="weizhiZ" id="weizhiZ" type="hidden" />
						<input name="weizhiC" id="weizhiC" type="hidden" />
					</div>
					<script language="javascript" src="http://api.51ditu.com/js/maps.js"></script>
					<script language="javascript">
					var maps = new LTMaps( "myMap" );
					var control = new LTStandMapControl();
					maps.addControl( control );
				
					var control = new LTMarkControl();
					control.setPointImage("<?php echo SITE_URL; ?>/templates/store/images/a.gif");
					maps.addControl( control );
				
					var icon = new LTIcon();
					icon.setImageUrl('<?php echo SITE_URL; ?>/templates/store/images/centerPoi.gif');
				
					function getPoi(){
						var poi = control.getMarkControlPoint();
						document.getElementById("weizhiX").value = poi.getLatitude();
						document.getElementById("weizhiY").value = poi.getLongitude();
						document.getElementById("weizhiZ").value = maps.getCurrentZoom();
					}
					LTEvent.addListener( control , "mouseup" , getPoi );
				
					placeList=LTPlaceList.getDefault();
					<?php if ( $output['city'] != '' ) { ?>
						changeMap("<?php echo $output['city']; ?>");
						maps.cityNameAndZoom( "<?php echo $output['city']; ?>" , <?php echo $output['positionZ']; ?> );
						//引导地图现在位置
						maps.centerAndZoom (       new LTPoint(   <?php echo $output['positionY']; ?> , <?php echo $output['positionX']; ?>  ) , <?php echo $output['positionZ']; ?> );
					<?php } else { ?>
						changeMap("tianjin");
						maps.cityNameAndZoom( "tianjin" , 2 );
					<?php } ?>
					function changeMap(name)
					{
						var place=placeList.searchPlace(name,1)[0];
						//获取该地名的坐标
						var point=place.getPoint();
						if(point)
						{//有些地名可能没有坐标信息
							maps.centerAndZoom(point,5);
						}
						//创建显示该地名路径的HTML
						var pathHtml=place.getName();
						var p=place.getParent();
						while(p)
						{
							pathHtml="<a href='javascript:changeMap(\""+p.getName()+"\")'>"+p.getName()+"</a>"+"->"+pathHtml;
							p=p.getParent();
						}
						document.getElementById("placePath").innerHTML=pathHtml;
				
						//创建显示下一级地名的HTML
						var childrenHtml="";
						var children=place.getChildren();
						for(var i=0;i<children.length;i++)
						{
							childrenHtml+="<a href='javascript:changeMap(\""+children[i].getName()+"\")'>"+children[i].getName()+"</a>&nbsp;";
						}
						document.getElementById("placeChildren").innerHTML=childrenHtml;
				
						document.getElementById("weizhiC").value = place.getPinyin();
					}
					<?php if ( $output['positionY'] != '0' && $output['positionX'] != '0' ) { ?>
						var marker1 = new LTMarker( new LTPoint(   <?php echo $output['positionY']; ?> ,  <?php echo $output['positionX']; ?>  ) , icon );
						var text = new LTMapText( marker1 );
						text.setLabel( "<?php echo $output['shopname']; ?>" );
						text.setBackgroundColor( "#f2f2f2" );
						maps.addOverLay( text );
						maps.addOverLay( marker1 );
					<?php } ?>
				</script>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input id="Submit" type="submit" class='submit' name="" value="<?php echo $lang['langCsubmit'];?>" />
					</span>
				</div>	
				</form>	
			</div>
		</div>
	</div>
</div>