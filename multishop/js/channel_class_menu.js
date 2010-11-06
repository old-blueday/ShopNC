
/*startList = function() {
	if (document.all&&document.getElementById) {
		navRoot = document.getElementById("channel_class_nav");
		for (i=0; i<navRoot.childNodes.length; i++) {
			node = navRoot.childNodes[i];
			if (node.nodeName=="LI") {
				node.onmouseover=function() {
					this.className+=" over";
					}
					node.onmouseout=function() {
						this.className=this.className.replace(" over", "");
					}
			 }
		 }
	 }
}
window.onload=startList;*/

function startList(){
 //alert(1);
  try{
      var navRoot = document.getElementById("channel_class_nav");

      for(i=0; i<navRoot.childNodes.length; i++)
      {
       node = navRoot.childNodes[i];

       if(node.nodeName == "li" || node.nodeName=="LI"){
        node.onmouseover = function(){
         this.className+="over";
        }
        
        node.onmouseout=function(){
         this.className=this.className.replace("over", "");
        }
       }
      }
    }catch(e){
      alert(e.message)
    }
     
 }
 window.onload=startList;
 //startList()