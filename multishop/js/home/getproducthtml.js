//取JS文件参数
var jsFileName = "getproducthtml.js";
var rName = new RegExp(jsFileName+"(\\?(.*))?$")
var jss=document.getElementsByTagName('script');
var param_array = Array();
for (var i = 0;i < jss.length; i++){
var j = jss[i];
if (j.src&&j.src.match(rName)){
	var oo = j.src.match(rName)[2];
	if (oo&&(t = oo.match(/([^&=]+)=([^=&]+)/g))){
		for (var l = 0; l < t.length; l++){
			r = t[l];
			var tt = r.match(/([^&=]+)=([^=&]+)/);
			if (tt)
				param_array[tt[1]] = tt[2];
			}
		}
	}
}
/*
* 静态文件头部调用
*/
function getproducthead(pid)
{
	$.ajax({
		url: param_array['url']+'/home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=head&pid=' + pid + '&ajax=1',
		success: function(html){
			$('#htmlhead').html(html);
			getproductinfo(pid);
		}
	});
}

/*
* 静态文件头部调用
*/
function getproductinfo(pid)
{
	$.ajax({
		url: param_array['url']+'/home/tohtml.php?action=product',
		type: 'post',
		dataType: 'xml',
		data: 'pid=' + pid + '&ajax=1',
		error: function(){
			//alert('wrong');
		},
		success: function(xml){
			selltype = $("selltype",xml).text();
			if(selltype=="0"){//拍卖
				$('#html_cur_price').html($("curprice",xml).text());
				$("#buy_now").val($("curprice",xml).text());
				$('#html_price_step').html($("pricestep",xml).text());
				$("#p_price_step").val($("pricestep",xml).text());
			}
			if(selltype=="2"){//团购
				less_count = $("less_count",xml).text();
				if(less_count > 0){
					$('#html_less_count').html($("lesscount",xml).text());
				}else{
					$('#html_less_count').html($("lesscountok",xml).text());
				}
				$('#html_group_price').html($("p_price",xml).text());
				$('#html_group_mincount').html($("group_mincount",xml).text());
			}

			if(selltype != "0"){
				$('#html_sold_sum').html($("soldsum",xml).text());
			}
			var temp_buy_img = $("buy_score_img",xml).text().replace(/@/g,"<");
			var buy_img = temp_buy_img.replace(/%/g,">");
			var temp_sale_img = $("sale_score_img",xml).text().replace(/@/g,"<");
			var sale_img = temp_sale_img.replace(/%/g,">");
			
			$("#p_sold_num").val($("soldnum",xml).text());
			$('#html_sold_num').html($("soldnum",xml).text());
			$('#html_view_num').html($("viewnum",xml).text());
			$('#html_sold_score').html($("soldscore",xml).text()+' '+sale_img);
			$('#html_buy_score').html($("buyscore",xml).text()+' '+buy_img);
			$('#html_sold_rate').html($("soldrate",xml).text());
			$('#html_buy_rate').html($("buyrate",xml).text());
			$('#html_shop_name').html($("shop_name",xml).text());
			$('#html_shop_area').html($("shop_area",xml).text());
			//店铺实体店认证
			if($("shop_audit_state",xml).text() == '2'){
				$('#html_audit_state').css('display','');
			}
			//个人实名认证
			
			if($("personal_certify",xml).text() == '2'){
				$('#html_personal_certify').css('display','');
			}
			if($("p_state",xml).text() == '0'){
				$('#html_p_storage').html('0');
				$('#leftTime1').html($("productclose",xml).text());
			}else{
				$('#html_p_storage').html($("p_storage",xml).text());
				$('#leftTime1').html($("lefttime",xml).text());
			}
		}
	});
}

/*
* 静态文件出价记录调用
*/
function getproductorder(pid)
{
	$.ajax({
		url: param_array['url']+'/home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=get_order&pid=' + pid + '&ajax=1',
		success: function(html){
			$('#bidrecord_list').html(html);
		}
	});
}

/*
* 静态文件商品留言调用
*/
function getproductmsg(pid)
{
	$.ajax({
		url: param_array['url']+'/home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=get_msg&pid=' + pid + '&ajax=1',
		success: function(html){
			$('#AjGuestBook').html(html);
		}
	});
}
/*写入曾经浏览的商品cookie*/
function setReviewCookie(str){
	$.ajax({
		url: param_array['url']+'/home/product.php',
		data: "action=setReview&p_code="+str,
		type:'get',
		dataType:"html",
		success: function(html){}
	});
}

/*调用卖家信用等级
function getSaleCredit(id){
	$.ajax({
		url: param_array['url']+'/home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=get_credit&id=' + id + '&ajax=1',
		success: function(html){
			$('#sale_credit').html(html);
		}
	});
}*/

//调用商品支持的货币种类对应的价格
function getproductcurrency(pid){
	$.ajax({
		url: param_array['url']+'/home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=get_currency&pid=' + pid + '&ajax=1',
		success: function(html){
			$('#ExchangeInfo').html(html);
		}
	});
}

//静态文件卖家联系方式
function getproductcontect(id){
	$.ajax({
		url: param_array['url']+'/home/tohtml.php',
		type: 'get',
		dataType: 'html',
		data: 'action=get_contect&id=' + id + '&ajax=1',
		success: function(html){
			$('#seller_contect').html(html);
		}
	});
}