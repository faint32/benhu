function validate(){
    if(!$("#addr").val()){
     alert("您的收货地址还未填写，请填写收货地址！");
    }else{
		if( checkOrderForm($('#theForm')) )
		{     
	document.getElementById('theForm').submit();
		}
   }
}
function saveadd(){
  
   var province = $("#selProvinces_1").val(); 
   var city = $("#selCities_1").val();  
   var area = $("#selDistricts_1").val();  
   var address = $("#address").val();
   var zipcode = $("#zipcode").val();  
   var consignee =$("#consignee").val();  
   var tel = $("#tel").val();  
   var is_first = (true == $('#is_first').prop("checked")) ? 1 : 0 ;
   if (province <1)  
   {  
		alert('请选择省份');  
	return false;  
   }
   if (city < 1)  
   {  
		alert('请选择城市');  
	return false;  
   }
   if (area < 1)  
   {  
		alert('请选择区县');  
	return false;  
   }
   if (address.length == 0)  
   {  
		alert('请填写详细地址');  
	return false;   
   }
   if (consignee.length == 0)  
   {  
	alert('请填写收货人姓名');  
	return false;  
   }
   if (tel.length == 0)  
   {  
	alert('请填写手机号码');  
	return false; 
   }
  
Ajax.call( 'flow.php', 'step=saveadd&province=' + province+'&city='+city+'&district='+area+'&address='+address+'&zipcode='+zipcode+'&consignee='+consignee+'&tel='+tel+'&is_first='+is_first, save_callback , 'get', 'JSON', true,true );  

}
function  save_callback(result) {
	if(result == 1) { alert("添加成功");  clearAll();   location.reload() }  
	else alert("添加失败"); 
}
/*选择收货地址*/
function set_moren(addr_id)  
{
	if (confirm('确实要设置为收货地址吗？')) 
	{
		var Request = new Object();
		Request = GetRequest();
        var goodsList = Request['goods_list'];
		var buyType = (typeof(Request['buyType']) == 'undefined') ? '0' : Request['buyType'];
	Ajax.call( 'flow.php', 'step=checkout&act=moren&id='+addr_id + '&buyType='+buyType  + '&goods_list='+goodsList , set_moren_callback , 'get', 'JSON', true,true );  
	}
}
function set_moren_callback(result)
{
var consignee = result['consignee']
console.log(consignee)
if(consignee['address_id'] != 0) 
{ 
	changeSelectedStyle(consignee['address_id'])
	changeContatctAddress(consignee)
	reCacuOrderFee(result['shippingFee'])
	
}  
else alert('选择收货地址失败');
}
function changeSelectedStyle(consigneeId)
{
	$('.sc_order_address_choose').addClass('sc_order_address_1');
	$('.sc_order_address_choose').removeClass('sc_order_address_choose');

	$('#address_id' + consigneeId).removeClass('sc_order_address_1');
	$('#address_id' + consigneeId).addClass('sc_order_address_choose');
 
}

function changeContatctAddress(consignee)
{
	$('.sc_order_submit #from').html(consignee['address1'] + consignee['address'])
	$('.sc_order_submit #to').html(consignee['consignee'] + ' ' + consignee['tel'])
}

function reCacuOrderFee(shippingFee)
{
 $('#shipping_fee').html('¥' + shippingFee)
 
   var totalFee = 0.0 
   $('.sc_order_margin_1 .sc_order_submit span').each(function(){
		var price = $(this).html()
       if( $(this).hasClass('add') )
	   {
	     	price =  parseFloat(price.substring(1))
			totalFee += price
	   }
        if( $(this).hasClass('minus') )
	   {
	     	price =  parseFloat(price.substring(1))
			totalFee -= price
	   }
   })
   totalFee = totalFee.toFixed(2)
   $('#total_amount').html('¥' + totalFee)
}
	function show(){
		$("#container").toggle();
	}
	function hide(){
		$("#container").hide();
	}
function clearAll(){
    $("#is_first").prop('checked',false);
    $("#selProvinces_1").val(0);
    $("#selCities_1").val(0);
    $("#selDistricts_1").val(0);
    $("#address").val('');
    $("#zipcode").val('');
    $("#consignee").val('');
    $("#tel").val('');
    $("#gai").val('');
    $("#address_id").val('');
    $("#container").toggle();
}
//查看购物车页的js代码
