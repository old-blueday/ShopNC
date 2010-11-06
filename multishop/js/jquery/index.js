// 表格排序函数
function sorttable(thetable){
	$(function() {
		$(thetable).tableSorter({
			sortColumn: 'Date',					
			stripingRowClass: ['even','odd'],
			stripeRowsOnStartUp: true,
			sortClassAsc: 'headerSortUp',
			sortClassDesc: 'headerSortDown',
			headerClass: 'table_header'	
		});
	});
}

// 登录检测函数
function loads(){
	$.ajax({
	url:'loadcheck.php',
	type:'post',
	data:'username='+username.value+'&password='+password.value,
	ifModified:'true',
	dataType:'html',
	success:function(msg){
		msg_array=msg.split('|||');
		$('#load_massage span').html(msg_array[0]);
		if (msg_array[1] == 'true') {$('#load').hide('slow');$('#middle').show('slow');} else {$('#load_wrong_message').show('fast')};
		
		
		  }
		  })
;}

// 显示登录框函数
function showload(){
$('#middle').hide('slow');
$.ajax({url:'login.php',ifModified:'true',dataType:'html',success:function(msg){$('#load').html(msg);css3()
}})
;
$('#load').show('slow')
}



//以下是jquery结合css3应用的一些样式，每次加载ajax都需要重新激活，所以单独立了一个函数
function css3(){
	Nifty("div.navtop","small transparent top");//圆角矩形
	$(".border2 li,.table1 tr").mouseover(function() {$(this).addClass("over");}).mouseout(function() {$(this).removeClass("over");});//增加鼠标经过样式伪类
	$(".border2 li:last-child").css("border-bottom-width","0");
	$(".nav .sortableitem .border1").css("border-top-width","0");
	$(".nav .border2 li:odd").addClass("odd");//偶数阵列添加odd
	$(".nav .border2 li:even").addClass("even");//偶数阵列添加even
}

//把当前nav排序保存到cookie中
function paixu() {
    var paixu_id = '';
for(var i=0;i < $('.sortableitem').size();i++){
	paixu_id=paixu_id+$('.sortableitem').eq(i).attr('id')+'|||'
		 };
		$.cookie('navsort', paixu_id); 
	 }


//从cookie读取nav排序规则
function cookietonav(){
	if ($.cookie('navsort') == null){$.cookie('navsort','nav_a|||nav_b|||nav_c|||nav_d|||')};
	navsort_array=$.cookie('navsort').split('|||');
	for ( var i=0;i < $('.sortableitem').size();i++){
		$('.nav').append($('#'+navsort_array[i]));
	}
	;
}

//新闻列表点击后展示新闻
function showonenews(){
				$('.table1 tr a').click(function() {
				$.ajax({
					type:'post',
					url:$(this).attr('rel'),
					dataType:'html',
					ifModified:'true',
					success:function(msg){
							$('#newsview').show('fast');$('#newsview').html(msg)
					}
				});
				});

	}

