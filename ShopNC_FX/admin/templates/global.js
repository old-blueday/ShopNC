$(document).ready(function(){
	var boxs  = $('input[type=checkbox].cb'); // 获取多选框对象
	var box   = $('#all');						  // 获取全选框
	var art_boxs  = $('input[type=checkbox].art_cb'); // 获取多选框对象
	var art_box = $('#art_all');
	box.click(function(){
	  CheckAll(boxs , this);
	});//end of box.click
	
	boxs.click(function(){
	  isCheck(this , box , boxs);
	});//end of boxs.click
	
	box.click(function(){
		isEffect(this);
	});//end of box.click
	
	art_box.click(function(){
	  CheckAll(art_boxs , this);
	});//end of box.click
	
	art_box.click(function(){
	  isCheck(this , art_box , art_boxs);
	});//end of boxs.click
	
	art_box.click(function(){
		isEffect(this);
	});//end of box.click  
	
   // 下面的函数用来调用，可以不改变
   
   function isEffect(obj){
	  if(obj.checked){
		 $('table.stripeMe tr').addClass('onhover');
	  }else{
		 $('table.stripeMe tr').removeClass('onhover');
	  }
	}

   // 全选  全不选
   function CheckAll(obj1,obj2){
	  obj1.each(function(){
		 $(this).attr("checked" , obj2.checked);      // 循环选中多选框对象
		 //或者  this.checked = obj2.checked;
	  });
   }
   
   // 对多选框对象的选择进行控制
   function isCheck(obj1,obj2,obj3){
		 if(!obj1.checked){				 //如果当前点击的多选框未被选中
			obj2.attr("checked", false );
		}else{								
			if(checkboxAll(obj3)){
				obj2.attr("checked", true );
			}
		}
   }

   //判断多选框对象是否都被选中，
   //如果有一个未被选中，返回false，
   //如果都被选中，返回true
   function checkboxAll(obj){
       for(var i=0;i<obj.length;i++){
			if(!obj[i].checked){
                 return false;
			}
	   }
	   return true;
   }

   //判断多选框对象是否都无选中，
   //如果都被选中，返回false，
   //如果都无选中，返回true
   function checkBoxNoAll(obj){
       for(var i=0;i<obj.length;i++){
			if(obj[i].checked){
                 return false;
			}
	   }
	   return true;
   }
	//鼠标滑过表格时增加效果
	$('.stripeMe tr').hover(function(){
		$('.stripeMe tr').removeClass('mhover');
		$(this).addClass('mhover');
	}, function(){
		$('.stripeMe tr').removeClass('mhover');
	});
	
	//勾选复选框后的效果
	$("table.stripeMe input[type='checkbox']").click(function(){
		if($(this).attr("checked")){
			$(this).parents("tr").addClass("onhover");
			$(".delBtnInput").attr('disabled','');
		}else{
			if(checkBoxNoAll(boxs , this)) {
				$(".delBtnInput").attr('disabled','disabled');
			}
			$(this).parents("tr").removeClass("onhover");
		}
	});
$(".delBtnInput").attr('disabled','disabled');
});
