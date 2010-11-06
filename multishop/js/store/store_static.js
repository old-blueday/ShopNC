

//板式选择-1两边,0右边,2左边
function hideSide(sideid) {
	
	if(sideid == 0) {
		document.getElementById('layout_0').style.display = 'none';
	}
	if(sideid == 2) {

		document.getElementById('layout_2').style.display = 'none';
	}
}