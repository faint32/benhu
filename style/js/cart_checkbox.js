//查看购物车页的js代码
$(document).ready(function(){

       bindSelectAllBtn('sc_all')
	   bindSelectAllBtn('sc_all_two')
	   bindSelectBtn()
       setSelectBtnDefaultChecked('.sc_good')	 
	   eventHappendAfterClickCheckBox()	   
});

function setSelectBtnDefaultChecked(eleClassName)
{
	$(eleClassName).prop("checked",true);
}

function bindSelectBtn()
{
  $('.sc_good').click(function(){
		  eventHappendAfterClickCheckBox()
		  eleRemoveAttr('checked',"#sc_all","#sc_all_two")
	  });
}

function eventHappendAfterClickCheckBox()
{
/****the function changeTotalFee is to calc the totalFee, and the reCalcTotalFee is the function that the totalFee minus the discount**/
    changeSelectNum()
    changeTotalFee()
	reCalcPackageDiscountMoney()
	reCalcTotalFee()
}

function bindSelectAllBtn(selectAllEleId)
{
  $('#' + selectAllEleId).click(function(){
       selectAllClicked(selectAllEleId)
	   eventHappendAfterClickCheckBox()
  });
}

function selectAllClicked(selectAllEleId)
{
   if( true == $("#" + selectAllEleId).prop("checked") ) 
	{
	    $('.sc_good').prop("checked",true);
	}
	else 
	{
	    eleRemoveAttr('checked','.sc_good',"#sc_all","#sc_all_two");
	}
}
function eleRemoveAttr()
{
       var removedAttr = arguments[0]
       for(var i = 1;i < arguments.length; i++) { 
		 $(arguments[i]).removeAttr(removedAttr)	
       } 
}

function reCalcPackageDiscountMoney()
{
  var discountMoney = 0.0;
  
  var discountRate = 1.0 - parseFloat($('#discountRate').html())/10
  
  if(isNaN(discountRate) || discountRate < 0.0 || discountRate > 1.0) //return ;
     discountRate = 0.0
  $('.sc_good').each(function(){
    if(true == $(this).prop("checked"))
	{
        if( typeof($(this).attr('goods-varieties')) != 'undefined' )
		{
		   var id = '#items_' + $(this).val();
          var sglAmountId =  '#total_items_' + $(this).val(); 
          var sglMoney = $(sglAmountId).html()			 
          sglMoney = sglMoney.substring(1) 
          discountMoney += parseFloat(sglMoney)
		}		   
	 }
  });
  
   discountMoney *= discountRate
   
   $('#discountMoney').html(discountMoney.toFixed(2))
}

function reCalcTotalFee()
{
	var amount = parseFloat( $('#amount').html().substring(1) )
	var discountMoney = 0.0
	if(typeof( $('#discountMoney').html()) != 'undefined')
		discountMoney = parseFloat( $('#discountMoney').html() )
		
	amount -= discountMoney
    $('#amount').html('￥' + amount.toFixed(2))	
}

function changeTotalFee()
{
var amount = 0.0;
  $('.sc_good').each(function(){
    if(true == $(this).prop("checked"))
	{	  
          var id = '#items_' + $(this).val();
          var sglAmountId =  '#total_items_' + $(this).val(); 
          var sglMoney = $(sglAmountId).html()			 
          sglMoney = sglMoney.substring(1) 
          amount += parseFloat(sglMoney)
	 }
  });
  
  $('#amount').html('¥'+amount.toFixed(2));
}
function changeSelectNum()    //amount total_items_
{
  var total = 0;
  $('.sc_good').each(function(){
    if(true == $(this).prop("checked"))
	{
	  var goodsVarieties = $(this).attr('goods-varieties'); 
		goodsVarieties =  (typeof(goodsVarieties) == "undefined") ? 1 : goodsVarieties; 
          var id = '#items_' + $(this).val(); 
		 total += parseInt($(id).val()) * parseInt(goodsVarieties);
	 }
  });
   $('#totalDifGoodsNumber').html(total.toString());
}

function changeMiniCartNum()
{
var total = 0;
  $('.sc_good').each(function(){
	  var goodsVarieties = $(this).attr('goods-varieties'); 
		goodsVarieties =  (typeof(goodsVarieties) == "undefined") ? 1 : goodsVarieties; 
          var id = '#items_' + $(this).val(); 
		 total += parseInt($(id).val()) * parseInt(goodsVarieties);
	 
  });
  $('#in_cart_num').html(total.toString());
} 

function beforeCartNumInput(goodsId, inputVal, buyType)
{
	var goodInfo = {'goodId' : goodsId, 'inputVal' : inputVal, 'buyType' : buyType};
	checkCartInputVal(goodInfo)	
	if(goodInfo.buyType == 'taocan')
	{
	   flowCartNumInput(goodInfo.goodId, goodInfo.inputVal, goodInfo.buyType)
	   return;
	}
	flowCartNumInput(goodInfo.goodId, goodInfo.inputVal)
}

function checkCartInputVal(goodInfo)
{
	var checkArr = new Array();
	var errInfoArr = new Array();	
	checkArr['inputVal'] = goodInfo.inputVal;
	errInfoArr['inputVal'] = '请输入正确的商品数量';
	checkType = '正整数';
	var keyFlag = checkArrValType(checkArr,checkType);
	if(keyFlag != 1)
	{
		  alert (errInfoArr[keyFlag]);
		  goodInfo.inputVal = 1;
		 $('#items_' + goodInfo.goodsId).val(1);
	}
	
	goodInfo.buyType = ("undefined" == typeof goodInfo.buyType) ? '' : goodInfo.buyType;
}
