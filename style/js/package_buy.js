	/************************只适用于商品详情页*************************************/
	$(function(){
	reCaculatePackagePrice();
			 $('.jiage_xz input').click(function(){
			                   if($(this).val() == '搭配')
							   {							 
							     choose_attr($(this).attr('data-good-id'));
							   }
							   else if($(this).val() == '取消')
							   {
								 $(this).val('搭配')
								 
								 var goodId = $(this).attr('data-good-id');
								if(!isOriginalGood(goodId)) 
								 {
									 $('.xuanzhong').each(function(){
									    if(goodId == $(this).attr('data-good-id'))
										  $(this).removeClass('xuanzhong');
									 });
								 }
								reCaculatePackagePrice();
							   }
						  });								
							
						   $('.show_full_name').hover(
						        function(){ 
								$("#fixedLayer").html($(this).html());
								$("#fixedLayer").show(); 
								  var x = $(this).offset();
						
                                  $('#fixedLayer').offset({left:(x.left-20), top:(x.top + 80)});
								}, 
								function(){ 
								$("#fixedLayer").hide(); 
								
								});
	
		});
		

		function reCaculatePackagePrice()
		{
				  var discount = parseFloat($('#packageBuyNum').attr('data-discount'));
					 discount = (discount > 1.0 || discount < 0.0) ? 1.0 : discount;
				  var vnum = $('#packageBuyNum').val();
						 if(isNaN(vnum)  || vnum < 1 || !isInteger(vnum))
						 {
							alert('请输入正确的商品数量')
						   $('#packageBuyNum').val(1);  
						  }
				
				 var total = parseFloat(0);
				 var goodsIdArr = new Array();
				 
					$('.xuanzhong').each(function(){
					
					   var goodId = $(this).attr('data-good-id');
					   if(!in_array(goodId,goodsIdArr))
					   {
						 total += parseFloat($(this).attr('data-shop-price'));
						 goodsIdArr.push(goodId);
						}
						// 		alert($(this).attr('data-shop-price'))
					});
				
					total *= vnum;
					if(goodsIdArr.length <= 1 ) discount = 1.0;
					
					/*	alert('total==' + total)
					alert('vnum==' + vnum)
					alert('discount==' + discount)*/
					
				$('#initial_price').html('¥' + total.toFixed(2));
				$('#package_price').html('¥' + (total*discount).toFixed(2));
				$('#discount_price').html('¥' + ( total.toFixed(2) - (total*discount).toFixed(2)).toFixed(2));
		}
				
				 function choose_attr(good_id, originalGood)
				 {
                    Ajax.call( 'goods.php?act=choose_attr', 'good_id=' + good_id, choose_attr_callback , 'GET', 'json', false, true );   				 
				 }
				 function choose_attr_callback(result)
				 { 
					 if(result.attr)
					 {
						 $('#attrSelect').show();
						 $('#attrSelectGoodName').attr('data-good-id',result.goods_id);
						  $('#attrSelectGoodName').html(result.goods_name);
						  $('#attrSelectGoodPrice').html('¥' + result.shop_price);
						   $('#attrSelectMarketPrice').html('原价：￥' + result.market_price);
						    $('#attrSelectGoodNum').html(result.goods_number);
							
						
							var attrList = '<form id="attr_choose" name="attr_choose">';
						 for(var i = 0; i < (result.attr).length; i ++)
						 {
						//alert(result.attr[i])
						var first = '';
						   if(i == 0 || result.attr[i].attr_id != result.attr[i-1].attr_id)
						   {
						   attrList += '<dl  class="standard_1"> <dt id="tasteAttrName">'+ result.attr[i].attr_name +'</dt>'
						   first = 'options'
						   }
						   
						   
						  attrList += 	'<dd '  
						  + ' onclick="selPara(this,\'spec_'+result.attr[i].attr_id+'\',\'spec_value_'+result.attr[i].goods_attr_id+'\');'
						  + ' attrChangePrice(\''+result.goods_id+'\');"'
						  + ' id="'+result.attr[i].goods_attr_id+'" class="'+first+' spec_'+result.attr[i].attr_id+'">'
						  + result.attr[i].attr_value + '</dd>';
					  
						   if(i == (result.attr.length - 1) || result.attr[i].attr_id != result.attr[i+1].attr_id)
						   {
						      attrList += '</dl>';
						   }
						 }
					   attrList += '</form>';
					   $('#packageAttrList').html(attrList);
					    attrChangePrice(result.goods_id);
						
					}
				 }
                 
            
			function confirm_attr_mask()
			{
			
			 var curGoodPrice = $('#attrSelectGoodPrice').html();
             var chose_attr = '-----商品属性-----';			
				$('#attr_choose .standard_1').each(function(){
				  chose_attr += '<br/>' + $(this).children('dt').html() + '：';
				  chose_attr += $(this).children('.options').html() + '';
				 });
				 chose_attr = (chose_attr == '-----商品属性-----') ? '' : chose_attr;
			  var goodId =  $('#attrSelectGoodName').attr('data-good-id');		
			  var goodName = $('#attrSelectGoodName').html();
				$('#good' + goodId + ' dd a').html(goodName + '<br/>' + chose_attr);
				$('#good' + goodId + ' div b').html($('#attrSelectGoodPrice').html());
				
				$('#good' + goodId + ' dt').attr('data-shop-price',curGoodPrice.substring(1));
			  
			  if(!isOriginalGood(goodId))  //不是原配商品
			  {
				  $('#good' + goodId + ' dt').addClass('xuanzhong');
				 $('#good' + goodId + ' dd div input').val('取消');
			  }
			 reCaculatePackagePrice();
			}
			
			
			function getPackageSelectedAttributes(id)
			{
			var spec_arr = new Array();
			  $('#' + id + ' .options').each(function(index){
			    spec_arr[index] = $(this).attr('id')
			  });	
			
			  return spec_arr;
			}
			function attrChangePrice(goodsId)
			{
				var attr = getPackageSelectedAttributes('attr_choose');
				$('#good' + goodsId + ' dt').attr('data-good-attr',attr.join(','));
			  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=1', attrChangePriceResponse, 'GET', 'JSON');
			}
				
				function attrChangePriceResponse(result)
				{
				 $('#attrSelectGoodPrice').html('¥'+result.result);
				   $('#attrSelectGoodNum').html(result.stock);
				}

		function isOriginalGood(goodId)
		{
		  if(  $('.dapeitaocan_main .dapeitaocan_itself .xuanzhong').attr('data-good-id') == goodId )
		  return true;
		  else return false;
		}

				
						
 
		/* *
 * 添加商品到购物车 
 */
function addToCart_packageBuy( parentId)
{
	var num = $('#packageBuyNum').val();
	if(!isInteger(num) )
	{
	  alert('请输入正确的商品数量');
	}
	var goodsObjArr = new Array();
	 var goodsIdArr = new Array();
		    $('.xuanzhong').each(function(index){
			   var goodId = $(this).attr('data-good-id');
			   if(!in_array(goodId,goodsIdArr))
			   {
		         var goods = new Object();
				  goods.quick    = 1;
                  goods.spec     = $(this).attr('data-good-attr').split(",");//spec_arr;
				  goods.goods_id = goodId;
				  goods.number   = num;
                  goods.parent   = 0 ;
				 goodsIdArr.push(goodId);
				 goodsObjArr[index] = goods;
				}
		    });
		  if(goodsIdArr.length < 2)
		  {
		  alert("请选择搭配商品！")
			return ;
		  }
          var val = document.getElementById('mark_info').value;
		
		  if(val=='1')  // mark_info的值为1时，立即购买
		   {
		  Ajax.call('flow.php?step=buy_now_packageBuy', 'goodsArr=' + $.toJSON(goodsObjArr), addToCartResponse, 'POST', 'JSON');
		   return ;
		   }
  Ajax.call('flow.php?step=add_to_cart_packageBuy', 'goodsArr=' + $.toJSON(goodsObjArr), addToCartResponse, 'POST', 'JSON');
}		

function addToCart_packageBuy_Response(result)
{

  if (result.error > 0)
  {
    // 如果需要缺货登记，跳转
    if (result.error == 2)
    {
      if (confirm(result.message))
      {
        location.href = 'user.php?act=add_booking&id=' + result.goods_id + '&spec=' + result.product_spec;
      }
    }
    // 没选规格，弹出属性选择框
    else if (result.error == 6)
    {
      openSpeDiv(result.message, result.goods_id, result.parent);
    }
    else
    {
      alert(result.message);
    }
  }
  else
  {
    var cartInfo = document.getElementById('ECS_CARTINFO');
    var cart_url = 'flow.php?step=cart';
    if (cartInfo)
    {
      cartInfo.innerHTML = result.content;
	  //弹出
		
		$("#ECS_CARTINFO").html(result.flow_content);

		$("#showMiniCart").show().delay(2000).animate({width:0,height:0,opacity: 'hide'},1000);
    }

    if (result.one_step_buy == '1')
    {
      location.href = cart_url;
    }
    else
    {
      switch(result.confirm_type)
      {
        case '1' :  //套餐购
            var val = document.getElementById('mark_info').value;
		   if(val=='1')
		   {
		   location.href = 'flow.php?step=checkout&buyType=buy_now&goods_list='+result.goods_id;
		   }
		   else if(val=='0')
		   {
		   $('#cloes').css('top','800px')
		   document.getElementById('cloes').style.display="block";
		   document.getElementById('view_cart').href=cart_url;
		   }
          break;
        case '2' : //普通购
           var val = document.getElementById('mark_info').value;
		   if(val=='1')
		   {
		   location.href = cart_url;
		   }
		   else if(val=='0')
		   {
		   $('#cloes').css('top','350px')
		   document.getElementById('cloes').style.display="block";
		   document.getElementById('view_cart').href=cart_url;
		   }
          break;
        case '3' :
          location.href = cart_url;
          break;
        default :
          break;
      }
    }
	/*zhouhuan*/

	if($("#goods_id_"+result.goods_id).length != 0)
	{
		goods_offset = $("#goods_id_"+result.goods_id).offset();
		goods_thumb = $("#goods_id_"+result.goods_id+" .pimg img").attr('src');
		cart_offset = $(".head-shopcart").offset();
		scrollTop = $(document).scrollTop();
		$("#flyBuy").css({top:(goods_offset.top)+'px',left:(goods_offset.left)+'px'}).attr('src',goods_thumb).show().animate({width:0,left:cart_offset.left,top:cart_offset.top+'px'},800,function(){
			$("#flyBuy").replaceWith('<img id="flyBuy"/>');																																																					})
	}
  }

}	
						  