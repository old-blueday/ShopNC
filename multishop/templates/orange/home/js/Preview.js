var maxWidth=250;var maxHeight=250;function getPosXY(a,offset){var p=offset?offset.slice(0):[0,0],tn;while(a){tn=a.tagName.toUpperCase();if(tn=='IMG'){a=a.offsetParent;continue;}
p[0]+=a.offsetLeft-(tn=="DIV"&&a.scrollLeft?a.scrollLeft:0);p[1]+=a.offsetTop-(tn=="DIV"&&a.scrollTop?a.scrollTop:0);if(tn=="BODY")break;a=a.offsetParent;}
return p;}
function checkComplete(){if(checkComplete.__img&&checkComplete.__img.complete)
checkComplete.__onload();}
checkComplete.__onload=function(){clearInterval(checkComplete.__timeId);var w=checkComplete.__img.width;var h=checkComplete.__img.height;if(w>=h&&w>maxWidth){previewImage.style.width=maxWidth+'px';}
else if(h>=w&&h>maxHeight){previewImage.style.height=maxHeight+'px';}
else{previewImage.style.width=previewImage.style.height='';}
previewImage.src=checkComplete.__img.src;previewUrl.href=checkComplete.href;checkComplete.__img=null;}
function showPreview(e){hidePreview();previewFrom=e.target||e.srcElement;previewImage.src=loadingImg;previewImage.style.width=previewImage.style.height='';previewTimeoutId=setTimeout('_showPreview()',500);checkComplete.__img=null;}
function hidePreview(e){if(e){var toElement=e.relatedTarget||e.toElement;while(toElement){if(toElement.id=='PreviewBox')
return;toElement=toElement.parentNode;}}
try{clearInterval(checkComplete.__timeId);checkComplete.__img=null;previewImage.src=null;}
catch(e){}
clearTimeout(previewTimeoutId);previewBox.style.display='none';}
function _showPreview(){checkComplete.__img=new Image();if(previewFrom.tagName.toUpperCase()=='A')
previewFrom=previewFrom.getElementsByTagName('img')[0];var largeSrc=previewFrom.getAttribute("large-src");var picLink=previewFrom.getAttribute("pic-link");if(!largeSrc)return;else{checkComplete.__img.src=largeSrc;checkComplete.href=picLink;checkComplete.__timeId=setInterval("checkComplete()",20);var pos=getPosXY(previewFrom,[75,-2]);previewBox.style.left=pos[0]+'px';previewBox.style.top=pos[1]+'px';previewBox.style.display='block';}}