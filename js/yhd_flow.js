$(function(){
	$("#pms_choice_box li").mouseenter(function(){
		$(this).addClass("graybg");
	})
	
	$("#pms_choice_box li").mouseleave(function(){
		$(this).removeClass("graybg");
	})
	
})
/********迷你购物车,商品输入******
*****parameter a:商品在购物车表里的rec_id。如果是套餐购则是套餐购的id
               b:输入的数量
*********/
function flowCartNumInput(a,b,buyType)
{
    var b = parseInt(b);
	flow_change_goods_number(a,b,buyType);
}

/********迷你购物车加减********/
function flowClickCartNum(a,b,buyType)
{
	var b = parseInt(b);
	var c = $("#items_"+a);
	var d = parseInt(c.val());
	if(d < 1 || !$.isNumeric(d))
	{
		alert("请输入正确的商品数量");	
		e = 1;
	}
	
	if(b == -1)		
	{
		if(d == 1)
		{
			alert("购买数量不能小于1件");	
		}
		else
		{
			e = d + b;
		}
	}
	else
	{
		e = d + b;
	}
	 buyType = ("undefined" == typeof buyType) ? '' : buyType;
	
	flow_change_goods_number(a,e,buyType);
}

function flowkeyUpCartNum(a,b)
{
	var c = parseInt($(a).val());
	if(c < 1 || !$.isNumeric(c))
	{
		alert("请输入正确的商品数量");	
		d = $(a).val(1);
	}

	flow_change_goods_number(b,d);

}


function flow_change_goods_number(rec_id, goods_number,buyType)
{     
	if(buyType == 'taocan')
	{
	Ajax.call('flow.php?step=ajax_taocan_update_cart', 'packageBuy_id=' + rec_id +'&goods_number=' + goods_number, PB_flow_change_goods_number_response, 'POST','JSON');
	 return;
	}
	Ajax.call('flow.php?step=ajax_update_cart', 'rec_id=' + rec_id +'&goods_number=' + goods_number, flow_change_goods_number_response, 'POST','JSON');
}
function PB_flow_change_goods_number_response(result)
{
if (result.error == 0)
	{
		var packageBuy_id = result.packageBuy_id;
		
		$('#items_' +packageBuy_id).val(result.goods_number);//更新数量	
		$('#total_items_' +packageBuy_id).html('¥'+result.goods_subtotal.toFixed(2));//更新小计	
		$('#amount').html('¥'+result.total_price); //更新合计
		$('#totalNumber').html(result.total_goods_count);//更新购物车数量
		$('.bag_total_info_box').html(result.total_info); 
		
		changeMiniCartNum()
		eventHappendAfterClickCheckBox()
	
	}
	else if (result.message != '')
	{
		alert(result.message);                
	}
}
function flow_change_goods_number_response(result)
{              

	if (result.error == 0)
	{
		var rec_id = result.rec_id;
		
		$('#items_' +rec_id).val(result.goods_number);//更新数量	
		$('#total_items_' +rec_id).html('¥'+result.goods_subtotal);//更新小计	
		$('#amount').html('¥'+result.total_price); //更新合计
		$('#totalNumber').html(result.total_goods_count);//更新购物车数量
		$('.bag_total_info_box').html(result.total_info); 
			eventHappendAfterClickCheckBox()
		changeMiniCartNum()
	}
	else if (result.message != '')
	{
		alert(result.message);                
	}
}

/****************查看购物车页面，获取选中的商品**********************/
function getSelectedGoods()
{
	var goods_list = '';
	$('.sc_good').each(function(){
		if( true == $(this).prop("checked") )
		{
			var tmp='';
		    if(typeof( $(this).attr("goods-varieties") ) != "undefined")  //这件物品是套餐购里的
			{
			   var $taocanGoods = $(this).parent().parent().children('.shoppingcatr_taocan_goods').children('.shoppingcatr_taocan_goods_box')
			  
			   $taocanGoods.each(function(index){
				 var recId = $(this).attr('data-rec-id')
			     tmp +=  (index == 0) ? recId :  (',' + recId) ;
			   })
			 
			}
			else
			{
					tmp = $(this).val(); 
			}
					
		goods_list += ( (goods_list == '') ? tmp : (',' + tmp) );
		}
	});
	return goods_list;
}

function drop_selected_goods()
{
     var goods_list = getSelectedGoods();
   location.href='flow.php?step=drop_goods&id=' + goods_list;
}

function drop_collect_goods()
{
 var goods_list = getSelectedGoods();
   location.href='flow.php?step=drop_to_collect&id=' + goods_list;
}

function checkoutGoods()
{
	var goods_list = getSelectedGoods();
	if(goods_list == '')
		alert('您没有选择要购买的物品');
	else
	   location.href='flow.php?step=checkout&goods_list=' + goods_list;
}



