/*
* 静态文件头部调用
*/
function getsectionhead()
{
	$.ajax({
		url: '../../home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=head&ajax=1',
		success: function(html){
			$('#htmlhead').html(html);
		}
	});
}
