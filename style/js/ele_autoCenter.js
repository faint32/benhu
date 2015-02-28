 $(document).ready(function(){
	 var orderCenterFlag = getOrderCenterFlag();
	   
	  eleAutoCenter(orderCenterFlag);
	  reCacuTaocaoPrice();
	   
	   /****购物车详情页调用时，设置商品种类数***/
	  if(orderCenterFlag == 0) 
	  { 
	   setGoodsVarieties();
	  }
	 
  });
  
  function eleAutoCenter(orderCenterFlag)
  {
    $('.autoCenter').each(function(){
		var $parentDiv = $(this).parent()
		if(orderCenterFlag == 1)
			$(this).css('margin-top',  $parentDiv.height() / 2 - $(this).height() + 12 /*已成功订单会出现bug*/) 
		else
			$(this).css('margin-top', ( $parentDiv.height()- 4*$('.titleDiv').height() )/2)
	  });
  }
  
  function getOrderCenterFlag() //orderCenterFlag为1时，表示订单中心的页面调用这个js代码
  {
     var orderCenterFlag = 0;
     if( $('.titleDiv').length <= 0 )
		   orderCenterFlag = 1;
    return orderCenterFlag; 
 }
  
  
  function setGoodsVarieties()
  {
    $('.shoppingcatr_taocan').each(function(){ //给搭配套餐的复选框，的goods-varieties对应的商品数量
		 var goodsVarieties = $(this).children('.shoppingcatr_taocan_goods').children('div').length;
		
		 $(this).children('.shoppingcatr_taocan_padding').children('.sc_good').attr('goods-varieties',goodsVarieties);
	  });
  }
  
  //套餐购的小计金额(单个套餐的总价) 和 订单中心页的每个套餐的商品总价
  function reCacuTaocaoPrice() 
  {
	var orderCenterFlag = getOrderCenterFlag();
	if(orderCenterFlag == 0)  //购物车详情页
	{
	    $('.shoppingcatr_taocan').each(function(){
			var taocan_price = parseFloat(0); 
			var $taocan_goods_list = $(this).children('.shoppingcatr_taocan_goods').children('.shoppingcatr_taocan_goods_box');	   
			
			$taocan_goods_list.each(function(index){
				taocan_price += parseFloat( $(this).attr('data-goods-price') );	
			});
			var num = $(this).find('.taocan_num').val();
			$(this).find('.sc_goods_4').html('¥'+(num * taocan_price).toFixed(2)); 
	  });
	}
	else if(orderCenterFlag == 1) //订单详情页
	{
	     $('.allorders_taocan').each(function(){
			var taocan_price =  parseFloat(0)
			var $taocan_goods_list = $(this).find('.allorders_main_a  .price span')
			$taocan_goods_list.each(function(){
				taocan_price += parseFloat($(this).html().substring(1))
			})
			
			var num = $(this).find('.allorders_taocan_title span').html() 
			num = parseInt( num.substring(0 , num.length - 1) )
			$(this).find('.allorders_taocan_title p').html('¥'+(num * taocan_price).toFixed(2))
		 })
	}
     
  }