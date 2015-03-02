$(function(){
	$('.notice').click(function(){
	   $(this).parent().parent().parent().find('.warning').toggle();
	})
});

function validOrderDiscount(orderLimit, discountMoney)
{
	var limitArr = orderLimit.split(",");
	var discountArr = discountMoney.split(",");
    if(limitArr.length  != discountArr.length || !floatArr(limitArr) || !floatArr(discountArr))
    {
    	setModalBody(orderLimit, discountMoney);
    
    	return false;
    }
    return true;
}
function setModalBody(orderLimit, discountMoney)
{
	var conent = '金额下限：' + orderLimit;
	conent += '<br/>减免金额为：' + discountMoney;
	conent += '<br/>请检查这两项填写是否合理。';
	conent += '<br/>正确填写方式。金额下限：50,100 减免金额：5,11（订单满50块，可减免5块。满100块可减11块）';
	$('#myModal .modal-body').html(conent);
}

function floatArr(fltArr)
{
  for (var i = fltArr.length - 1; i >= 0; i--) 
  {
  	if(!isfloat(fltArr[i]))
  	  return false; 
  };
  return true;
}

function isfloat(oNum)
{
     if(!oNum) return false;
     var strP=/^\d+(\.\d+)?$/;
     if(!strP.test(oNum)) return false;
      try{
        if(parseFloat(oNum)!=oNum) return false;
      }catch(ex){
        return false;
      }
      return true;
 }
