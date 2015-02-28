
$(function(){
    payTypeChoose()
 
	setDepositPayBank()
	setCreditCardPayBank()
	
	bindBankChoosed()
});

function getDepositPayBanks()
{
 return new Array('ICBC','CCB','ABC','CMB',
						  'BOC','SPDB','BCOM','GDB',
						  'CMBC','CIB','CEB','CITIC',   
						  'PSBC','PAB','SHB','SDB', 
						  'POST','BJRCB','BOB','NBCB',
						  'HSB','HXB','NJCB','CBHB',
						  'HZB','BEA','SRCB','CZB') 
}

function getCreditCardPayBanks()
{
 return new Array('ICBC','CCB','CMB',
						  'BOC','SPDB','BCOM','GDB',
						  'CMBC','CIB','CEB','CITIC',   
						  'PSBC','PAB','SHB','SDB', 
						  'POST','NBCB',
						  'HSB',
						  'HZB','SRCB') 
}

function setDepositPayBank()
{			
var depositPayBanks = getDepositPayBanks()

	var $ul = $('#quickPayListDiv ul')
   for(var i = 0; i < depositPayBanks.length; i++)
   {
     var html = "<li class=\"pl-item\" data-paytype=\"10-1\" data-bankid=\"" + depositPayBanks[i] + "\"><span id=\"bank-" + depositPayBanks[i].toLowerCase() + "\" class=\"bank-logo tmp\"></span></li>";
      $ul.append(html)
   }
}

function setCreditCardPayBank()
{
var creditCardPayBanks = getCreditCardPayBanks()
						  
var $ul = $('#ebankPaymentListDiv ul')
   for(var i = 0; i < creditCardPayBanks.length; i++)
   {
     var html = "<li class=\"pl-item\" data-paytype=\"10-2\" data-bankid=\"" + creditCardPayBanks[i] + "\"><span id=\"bank-" + creditCardPayBanks[i].toLowerCase() + "\" class=\"bank-logo tmp\"></span></li>";
      $ul.append(html)
   }
}

function bindBankChoosed()
{
$('.pl-item').click(function(){                              /*li处，选择支付方式后进行ajax调用。*/
	   $('.hover').removeClass('hover');
	   $(this).addClass('hover');
	  
	 var payType = $(this).attr('data-payType');
	 var bankID = $(this).attr('data-bankID');
	
 Ajax.call( 'flow.php?step=ajax_check_pay', 'payment=6&order_id=' + orderId + '&payType=' + payType + '&bankID=' + bankID, bindBankChoosed_callback , 'GET', 'TEXT', false, true);
	//orderId来源于flow.dwt文件中的<script>里的声明
	});
}

function bindBankChoosed_callback(result)
   {
   
     $('#change_pay').html(result)
   }

function payTypeChoose()
{
	$(".ui-tab-item").click(function(){                                 /*ul处，不同支付方式选择切换。*/ 
	  $('.bw-tab-content').hide();   //隐藏全部
	   $('.ui-tab-item').removeClass('curr'); 
	   $(this).addClass('curr');
	   
	   var divId =  $(this).attr('date-div');//显示一个
       $('#'+divId).addClass('curr');
	   $('#'+divId).show();
	});
}

