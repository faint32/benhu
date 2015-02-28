   function funnum(type) { //减少购买数量
        var vnum = Number(document.getElementById("product_amount").value);
		
		 if (vnum < 1 || isNaN(vnum) || !isInteger(vnum)) {
		 alert('商品数量不符合要求，请重新输入')
			     document.getElementById("product_amount").value = 1;
				 return ;
			 }
			
        if (type == "down") {
            if (vnum > 1) 
                document.getElementById("product_amount").value = vnum - 1;
            }
			
        if (type == "up") {
         //   var vbignum = 20;//这是库存数量
          //  if (vnum < vbignum) {
              //  if (vnum < 10) {//允许最大购买量
                    document.getElementById("product_amount").value = vnum + 1;
           //     }
            //    else {
            //        alert("每人每次最多可购买10件商品！");
             //   }
            }
                  /* else {不能展现给用户
                      alert("库存不足！");
                       }*/
        }
    $(document).ready(function(){
	        $('#product_amount').blur(function(){
			     var vnum = $('#product_amount').val();
				
				 if(isNaN(vnum)  || vnum < 1 || !isInteger(vnum))
				 {
				  alert('商品数量不符合要求，请重新输入')
				   $('#product_amount').val(1);
				   }
			});
	});