function unselectall() {
	$("table input[type=checkbox]").each(function(){
		$(this).attr('checked',!$(this).attr('checked'))
	})	
}
function selectall() {
	$("table input[type=checkbox]").attr('checked',true);
}
function checkForm (c,n) {
	var is_select;
	$('table input[type=checkbox]').each(function(){
		if ($(this).attr('checked')) {
			is_select = true;
		}
	})
	if (is_select) {
		if (c != '1') {
			if (confirm(c)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	} else {
		alert(n);
		return false;
	}
	return false;
}