/* $Id : user.js 4865 2007-01-31 14:04:10Z paulgao $ */
  var reg_email=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var reg_phone = /(13|14|15|18)\d{9}/; //来源:许配
	var reg_home_phone =/^\d{3}-\d{8}|\d{4}-\d{7}$/;   //来源：http://blog.csdn.net/abcjiecba/article/details/7005129
	var reg_qq = /^[1-9]{1}[0-9]{4,9}$/;   //来源：http://blog.sina.com.cn/s/blog_53e0c0440100090m.html
    //13\d{9}|15[0-3|5-9]\d{8}|18[0,5,6,7,8,9]\d{8}/;     // 号码来源http://tools.jb51.net/shouji/
/* *
 * 修改会员信息
 */
function userEdit()
{
  var frm = document.forms['formEdit'];
  var email = frm.elements['email'].value;
  var msg = '';
  var reg = null;
  var passwd_answer = frm.elements['passwd_answer'] ? Utils.trim(frm.elements['passwd_answer'].value) : '';
  var sel_question =  frm.elements['sel_question'] ? Utils.trim(frm.elements['sel_question'].value) : '';

  if (email.length == 0)
  {
    msg += email_empty + '\n';
  }
  else
  {
    if ( ! (Utils.isEmail(email)))
    {
      msg += email_error + '\n';
    }
  }

  if (passwd_answer.length > 0 && sel_question == 0 || document.getElementById('passwd_quesetion') && passwd_answer.length == 0)
  {
    msg += no_select_question + '\n';
  }

  for (i = 7; i < frm.elements.length - 2; i++)	// 从第七项开始循环检查是否为必填项
  {
	needinput = document.getElementById(frm.elements[i].name + 'i') ? document.getElementById(frm.elements[i].name + 'i') : '';

	if (needinput != '' && frm.elements[i].value.length == 0)
	{
	  msg += '- ' + needinput.innerHTML + msg_blank + '\n';
	}
  }

  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }
  else
  {
    return true;
  }
}

//修改会员信息 chen-0917
function new_userEdit()
{
 
  
  var frm = document.forms['formEdit'];
  var email = frm.elements['email'].value;
  var phone = frm.elements['mobile_phone'].value;
 
  var home_phone = frm.elements['home_phone'].value;
  var qq = frm.elements['qq'].value;
  var msn = frm.elements['msn'].value;
  var reg = null;
  var msg = '';
  
    if ( !(Utils.isEmail(email)) && email != '')
    {
      msg += "邮箱格式错误" + '\n';
    }
  if(!reg_phone.test(phone) && phone != '')
  {
    msg += "手机号格式错误" + '\n';
  }
    else if(phone.length > 11)
  {
  msg += "手机号格式错误" + '\n';
  }
  
  if(!reg_home_phone.test(home_phone) && home_phone!= '')
  {
    msg += "固定电话格式错误" + '\n';
  }

  if(!reg_qq.test(qq) && qq!= '')
  {
    msg += "QQ格式错误" + '\n';
  }
  if(!reg_email.test(msn) && msn!= '')
  {
    msg += "msn格式错误" + '\n';
  }
  
  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }
  else
  {
    return true;
  }
}


/* 会员修改密码 */
function editPassword()
{
  var frm              = document.forms['formPassword'];
  var old_password     = frm.elements['old_password'].value;
  var new_password     = frm.elements['new_password'].value;
  var confirm_password = frm.elements['comfirm_password'].value;

  var msg = '';
  var reg = null;

  if (old_password.length == 0)
  {
    msg += old_password_empty + '\n';
  }

  if (new_password.length == 0)
  {
    msg += new_password_empty + '\n';
  }

  if (confirm_password.length == 0)
  {
    msg += confirm_password_empty + '\n';
  }

  if (new_password.length > 0 && confirm_password.length > 0)
  {
    if (new_password != confirm_password)
    {
      msg += both_password_error + '\n';
    }
  }

  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }
  else
  {
    return true;
  }
}

/* *
 * 对会员的留言输入作处理
 */
function submitMsg()
{
  var frm         = document.forms['formMsg'];
  var msg_title   = frm.elements['msg_title'].value;
  var msg_content = frm.elements['msg_content'].value;
  var msg = '';

  if (msg_title.length == 0)
  {
    msg += msg_title_empty + '\n';
  }
  if (msg_content.length == 0)
  {
    msg += msg_content_empty + '\n'
  }

  if (msg_title.length > 200)
  {
    msg += msg_title_limit + '\n';
  }

  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }
  else
  {
    return true;
  }
}



/* *
 * 找回密码第一步。对用户的输入的手机号，邮箱做判断
 */
function judge_account()
{
  $('#account').hide();
  $('#captcha').hide();
   var account = $('#user_name').val();
   var cpt = $('#cpt').val();

   var flag_email= reg_email.test(account);     
   var flag_phone= reg_phone.test(account);                            //flag为true表示匹配到号码
       if (flag_email)
       {
           $('#get_pwd_step1').val('get_email_password');
       }
       else if(flag_phone)
       {
            $('#get_pwd_step1').val('get_phone_password');
       }
       else 
       {
          $('#account').show();
          return false;
        }  
        if(cpt=='')
        {
          $('#captcha').show();
          return false;
        }
   var param = 'user_name='+account +'&captcha='+cpt;
   var flag = Ajax.call('user.php?act=judge_usrNm',param , judge_account_callback , 'GET', 'TEXT', false, false );
    if(flag==0)return true;
 return false;
}
function judge_account_callback(result)
{
  if(result != 0)
  { 
     $('#account').show();
      $('#captcha').show();
      if(result==1){$('#account').hide();}
      else if(result==2){$('#captcha').hide();}
  }
  
}

/** 
 * 发送短信   新增typeValue chen-0912
 */
function sendSMS(eindex,typeValue,user_id){  
   var mobilePhone = $('#mobilePhone'+eindex).val(); 

    typeValue=(typeof(typeValue)=="undefined")?0:typeValue;

   var param = 'user_name='+mobilePhone;
 
  $.ajax({    
      url:'http://www.benhu.com/includes/sendSMS.php',    
      data:{    
               user_name:mobilePhone,type:typeValue,user_id:user_id
      },    
      type:'post',    
      cache:false,    
      dataType:'json',    
      success:function(data,textStatus) {    
         //alert(data);
		// if($('#send_SMS_CountDown'))
	
	 },
     error: function(XMLHttpRequest, textStatus, errorThrown){
		 // alert('发送失败');
		
		}	 
  });
}
function sendRegisterSMS(phone){
  $.ajax({    
      url:'http://www.benhu.com/includes/sendSMS.php',    
      data:{    
               user_name:phone,type:'register'
      },    
      type:'post',    
      cache:false,    
      dataType:'json',    
      success:function(data) {    
         alert(data);
		
       },
     error: function(XMLHttpRequest, textStatus, errorThrown){
		  //alert('发送失败');
		}	 
  }); 
}
/* *
 * 会员找回密码时，对输入作处理
 */
function submitPwdInfo()
{
  var frm = document.forms['getPassword'];
  var user_name = frm.elements['user_name'].value;
  var email     = frm.elements['email'].value;


  var errorMsg = '';
  if (user_name.length == 0)
  {
    errorMsg += user_name_empty + '\n';
  }

  if (email.length == 0)
  {
    errorMsg += email_address_empty + '\n';
  }
  else
  {
    if ( ! (Utils.isEmail(email)))
    {
      errorMsg += email_address_error + '\n';
    }
  }

  if (errorMsg.length > 0)
  {
    alert(errorMsg);
    return false;
  }

  return true;
}

/* *
 * 会员找回密码时，对输入作处理
 */
function submitPwd()
{
  
    $('#shPwdInfo').hide();
    $('#shRepPwdInfo').hide();

  var frm = document.forms['getPassword2'];
  var password = frm.elements['new_password'].value;
  var confirm_password = frm.elements['confirm_password'].value;


  if (password.length <= 0 || password.length > 20)
  {
    $('#shPwdInfo').show();
   return false;
  }
  if (confirm_password != password)
  {
    $('#shRepPwdInfo').show();
     return false;
  }
    return true;
}

/* *
 * 处理会员提交的缺货登记
 */
function addBooking()
{
  var frm  = document.forms['formBooking'];
  var goods_id = frm.elements['id'].value;
  var rec_id  = frm.elements['rec_id'].value;
  var number  = frm.elements['number'].value;
  var desc  = frm.elements['desc'].value;
  var linkman  = frm.elements['linkman'].value;
  var email  = frm.elements['email'].value;
  var tel  = frm.elements['tel'].value;
  var msg = "";

  if (number.length == 0)
  {
    msg += booking_amount_empty + '\n';
  }
  else
  {
    var reg = /^[0-9]+/;
    if ( ! reg.test(number))
    {
      msg += booking_amount_error + '\n';
    }
  }

  if (desc.length == 0)
  {
    msg += describe_empty + '\n';
  }

  if (linkman.length == 0)
  {
    msg += contact_username_empty + '\n';
  }

  if (email.length == 0)
  {
    msg += email_empty + '\n';
  }
  else
  {
    if ( ! (Utils.isEmail(email)))
    {
      msg += email_error + '\n';
    }
  }

  if (tel.length == 0)
  {
    msg += contact_phone_empty + '\n';
  }

  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }

  return true;
}

/* *
 * 会员登录
 */
function userLogin()
{
 // alert(1);

      $('#usrNm').hide();
  var frm      = document.forms['formLogin'];
  var usrNm = frm.elements['username'].value;
  var pwd = frm.elements['password'].value;
 // alert("usrNm=="+usrNm+" pwd=="+pwd);
  if (usrNm.length == 0 || pwd.length == 0 || usrNm=='请输入邮箱或手机号码')
  {
   $('#usrNm').show();
    return false;
  }
  else
  {
    //alert('true');
    return true;
  }
}

function chkstr(str)
{
  for (var i = 0; i < str.length; i++)
  {
    if (str.charCodeAt(i) < 127 && !str.substr(i,1).match(/^\w+$/ig))
    {
      return false;
    }
  }
  return true;
}

function check_password( password )
{
    if ( password.length < 6 )
    {
        document.getElementById('password_notice').innerHTML = password_shorter;
    }
    else
    {
        document.getElementById('password_notice').innerHTML = msg_can_rg;
    }
}

function check_conform_password( conform_password )
{
    password = document.getElementById('password1').value;
    
    if ( conform_password.length < 6 )
    {
        document.getElementById('conform_password_notice').innerHTML = password_shorter;
        return false;
    }
    if ( conform_password != password )
    {
        document.getElementById('conform_password_notice').innerHTML = confirm_password_invalid;
    }
    else
    {
        document.getElementById('conform_password_notice').innerHTML = msg_can_rg;
    }
}

function is_registered( register_way,emane )
{
  clear_dispOfBlk();
  var param = '';

   if(register_way=='email'){
    
      var flag= reg_email.test(emane);   
     if (!flag)
        {
          $('#email').css('display','block');
          return false;
        }  
  }
  else if(register_way=='phone'){
    
        var flag= reg_phone.test(emane);                            //flag为true表示匹配到号码
            if(!flag){
              $('#phone').css('display','block'); 
              return false;
            }
  }
 param='type='+register_way+'&username='+emane;

   Ajax.call( 'user.php?act=is_registered',param , registed_callback , 'GET', 'json', false, true );
}



function registed_callback(result)
{
if(result == 'register type isn\'t email or phone')
{
   alert('register type isn\'t email or phone');
   return ;
}

  if ( result.result == "true" )
  {
    switch(result.type)
	{
	  case 'email':
	  $('#emlSubmit').attr('disabled', false);
	  break;
	   case 'phone':
	   $('#phoneSubmit').attr('disabled', false);
	   break;
	}
  }
  else if( result.result == "false" )
  {
   switch(result.type)
	{
	  case 'email':
	     $('#usedemail').css('display','block'); 
        $('#emlSubmit').attr('disabled', 'disabled');
	  break;
	   case 'phone':
	  $('#phoneSubmit').attr('disabled', 'disabled');
	 $('#usedphone').css('display','block');
	   break;
	}
  }
  
}

function checkEmail(email)
{
  var submit_disabled = false;
  
  if (email == '')
  {
    document.getElementById('email_notice').innerHTML = msg_email_blank;
    submit_disabled = true;
  }
  else if (!Utils.isEmail(email))
  {
    document.getElementById('email_notice').innerHTML = msg_email_format;
    submit_disabled = true;
  }
 
  if( submit_disabled )
  {
    document.forms['formUser'].elements['Submit'].disabled = 'disabled';
    return false;
  }
  Ajax.call( 'user.php?act=check_email', 'email=' + email, check_email_callback , 'GET', 'TEXT', true, true );
}

function check_email_callback(result)
{
  if ( result == 'ok' )
  {
    document.getElementById('email_notice').innerHTML = msg_can_rg;
    document.forms['formUser'].elements['Submit'].disabled = '';
  }
  else
  {
    document.getElementById('email_notice').innerHTML = msg_email_registered;
    document.forms['formUser'].elements['Submit'].disabled = 'disabled';
  }
}


/* *
 * 更换验证码图片
 */
function change_veriPic()
{
$(".verify_pic").attr('src','captcha.php?'+Math.random());
}
/* *
 * 清除block的元素，让其display为none
 */
function clear_dispOfBlk()
{
 $('#usedemail').css('display','none'); 
   $('#usedphone').css('display','none');
  $('#email').css('display','none');
  $('#email_psd').css('display','none');
  $('#email_rep_psd').css('display','none');
  $('#email_verify').css('display','none');
  $('#phone').css('display','none');
  $('#phone_psd').css('display','none');
  $('#phone_rep_psd').css('display','none');
  $('#phone_verify').css('display','none');
   $('#email_nick_name').css('display','none');
      $('#phone_nick_name').css('display','none');
}

function chToTxt(neededHid,neededSh)
{
  $('#'+neededHid).hide();
  $('#'+neededSh).show();
}
function chToPwd(neededHid,neededSh)
{
    $('#'+neededHid).hide();
   $('#'+neededSh).show().focus();
}
/* *
 * 处理注册用户
 */
function register(register_way) //没判断email,电话号码，密码有没有符合要求
{
 
    //  return false;

    clear_dispOfBlk();
   var frm  = document.forms[register_way+'User'];
   var emane  = frm.elements[register_way].value;

  //  alert(1);
   //  alert(register_way+'_psd');
     //alert(frm.elements[register_way+'_psd'].value);
     var pwd  = frm.elements[register_way+'_psd'].value;
     //alert(2);
     var confirm_password = frm.elements[register_way+'_rep_psd'].value;
    //alert(3);
   var checked_agreement = frm.elements[register_way+'_agreement'].checked;
   
   var nick_name = frm.elements[register_way + '_nick_name'].value;
 
  // alert('checked_agreement=='+checked_agreement);
      //alert(4);
    emane=$.trim(emane);


   if(register_way=='email')
   {
    
      var flag= reg_email.test(emane);   
     if (!flag)
        {
          $('#email').css('display','block');
          return false;
        }  
		
  }
  else if(register_way=='phone')
   {
       
        var flag= reg_phone.test(emane);                            //flag为true表示匹配到号码
            if(!flag)
            {
              $('#phone').css('display','block'); 
              return false;
            }
			
			var captcha = $('#phoneCaptcha').val();
			
			var  checkArr = new Array();
			checkArr['register_sms'] = captcha;
			var msmKey = checkArrValType(checkArr,'正整数');
			if(msmKey == 'register_sms' || captcha.length != 6)
			{
			  alert('短信验证码的格式错误。');
			  return false;
			}
   }
   
   var checkArr = new Array();
   var errInfoArr = new Array();
   checkArr['nick_name'] = nick_name;
   errInfoArr['nick_name'] = '昵称为空';
  var nickKey = checkArrEpt(checkArr,errInfoArr);
 
     if(nickKey == 'nick_name')
   {
   $('#'+register_way + '_nick_name').css('display','block');
     return false;
   }
    var psd_reg = /.{6,20}/;
  if (pwd.length == 0 || !psd_reg.test(pwd) || pwd=='6-20个大小写英文字母、符号或数字')
  {
      $('#'+register_way+'_psd').css('display','block'); 
       return false;
  }

  
  if (confirm_password != pwd )
  {
   $('#'+register_way+'_rep_psd').css('display','block'); 
       return false;
  }

  if(checked_agreement != true)
  {
     
    alert("请先阅读《笨虎之家服务协议》！");
       return false;
  }
    return true;

}

/* *
 * 用户中心订单保存地址信息
 */
function saveOrderAddress(id)
{
  var frm           = document.forms['formAddress'];
  var consignee     = frm.elements['consignee'].value;
  var email         = frm.elements['email'].value;
  var address       = frm.elements['address'].value;
  var zipcode       = frm.elements['zipcode'].value;
  var tel           = frm.elements['tel'].value;
  var mobile        = frm.elements['mobile'].value;
  var sign_building = frm.elements['sign_building'].value;
  var best_time     = frm.elements['best_time'].value;

  if (id == 0)
  {
    alert(current_ss_not_unshipped);
    return false;
  }
  var msg = '';
  if (address.length == 0)
  {
    msg += address_name_not_null + "\n";
  }
  if (consignee.length == 0)
  {
    msg += consignee_not_null + "\n";
  }

  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }
  else
  {
    return true;
  }
}

/* *
 * 会员余额申请
 */
function submitSurplus()
{
  var frm            = document.forms['formSurplus'];
  var surplus_type   = frm.elements['surplus_type'].value;
  var surplus_amount = frm.elements['amount'].value;
  var process_notic  = frm.elements['user_note'].value;
  var payment_id     = 0;
  var msg = '';

  if (surplus_amount.length == 0 )
  {
    msg += surplus_amount_empty + "\n";
  }
  else
  {
    var reg = /^[\.0-9]+/;
    if ( ! reg.test(surplus_amount))
    {
      msg += surplus_amount_error + '\n';
    }
  }

  if (process_notic.length == 0)
  {
    msg += process_desc + "\n";
  }

  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }

  if (surplus_type == 0)
  {
    for (i = 0; i < frm.elements.length ; i ++)
    {
      if (frm.elements[i].name=="payment_id" && frm.elements[i].checked)
      {
        payment_id = frm.elements[i].value;
        break;
      }
    }

    if (payment_id == 0)
    {
      alert(payment_empty);
      return false;
    }
  }

  return true;
}

/* *
 *  处理用户添加一个红包
 */
function addBonus()
{
  var frm      = document.forms['addBouns'];
  var bonus_sn = frm.elements['bonus_sn'].value;

  if (bonus_sn.length == 0)
  {
    alert(bonus_sn_empty);
    return false;
  }
  else
  {
    var reg = /^[0-9]{10}$/;
    if ( ! reg.test(bonus_sn))
    {
      alert(bonus_sn_error);
      return false;
    }
  }

  return true;
}

/* *
 *  合并订单检查
 */
function mergeOrder()
{
  if (!confirm(confirm_merge))
  {
    return false;
  }

  var frm        = document.forms['formOrder'];
  var from_order = frm.elements['from_order'].value;
  var to_order   = frm.elements['to_order'].value;
  var msg = '';

  if (from_order == 0)
  {
    msg += from_order_empty + '\n';
  }
  if (to_order == 0)
  {
    msg += to_order_empty + '\n';
  }
  else if (to_order == from_order)
  {
    msg += order_same + '\n';
  }
  if (msg.length > 0)
  {
    alert(msg);
    return false;
  }
  else
  {
    return true;
  }
}

/* *
 * 订单中的商品返回购物车
 * @param       int     orderId     订单号
 */
function returnToCart(orderId)
{
  Ajax.call('user.php?act=return_to_cart', 'order_id=' + orderId, returnToCartResponse, 'POST', 'JSON');
}

function returnToCartResponse(result)
{
  alert(result.message);
}

/* *
 * 检测密码强度
 * @param       string     pwd     密码
 */
function checkIntensity(pwd)
{
  var Mcolor = "#FFF",Lcolor = "#FFF",Hcolor = "#FFF";
  var m=0;

  var Modes = 0;
  for (i=0; i<pwd.length; i++)
  {
    var charType = 0;
    var t = pwd.charCodeAt(i);
    if (t>=48 && t <=57)
    {
      charType = 1;
    }
    else if (t>=65 && t <=90)
    {
      charType = 2;
    }
    else if (t>=97 && t <=122)
      charType = 4;
    else
      charType = 4;
    Modes |= charType;
  }

  for (i=0;i<4;i++)
  {
    if (Modes & 1) m++;
      Modes>>>=1;
  }

  if (pwd.length<=4)
  {
    m = 1;
  }

  switch(m)
  {
    case 1 :
      Lcolor = "2px solid red";
      Mcolor = Hcolor = "2px solid #DADADA";
    break;
    case 2 :
      Mcolor = "2px solid #f90";
      Lcolor = Hcolor = "2px solid #DADADA";
    break;
    case 3 :
      Hcolor = "2px solid #3c0";
      Lcolor = Mcolor = "2px solid #DADADA";
    break;
    case 4 :
      Hcolor = "2px solid #3c0";
      Lcolor = Mcolor = "2px solid #DADADA";
    break;
    default :
      Hcolor = Mcolor = Lcolor = "";
    break;
  }
  if (document.getElementById("pwd_lower"))
  {
    document.getElementById("pwd_lower").style.borderBottom  = Lcolor;
    document.getElementById("pwd_middle").style.borderBottom = Mcolor;
    document.getElementById("pwd_high").style.borderBottom   = Hcolor;
  }


}

function changeType(obj)
{
  if (obj.getAttribute("min") && document.getElementById("ECS_AMOUNT"))
  {
    document.getElementById("ECS_AMOUNT").disabled = false;
    document.getElementById("ECS_AMOUNT").value = obj.getAttribute("min");
    if (document.getElementById("ECS_NOTICE") && obj.getAttribute("to") && obj.getAttribute('fee'))
    {
      var fee = parseInt(obj.getAttribute("fee"));
      var to = parseInt(obj.getAttribute("to"));
      if (fee < 0)
      {
        to = to + fee * 2;
      }
      document.getElementById("ECS_NOTICE").innerHTML = notice_result + to;
    }
  }
}

function calResult()
{
  var amount = document.getElementById("ECS_AMOUNT").value;
  var notice = document.getElementById("ECS_NOTICE");

  reg = /^\d+$/;
  if (!reg.test(amount))
  {
    notice.innerHTML = notice_not_int;
    return;
  }
  amount = parseInt(amount);
  var frm = document.forms['transform'];
  for(i=0; i < frm.elements['type'].length; i++)
  {
    if (frm.elements['type'][i].checked)
    {
      var min = parseInt(frm.elements['type'][i].getAttribute("min"));
      var to = parseInt(frm.elements['type'][i].getAttribute("to"));
      var fee = parseInt(frm.elements['type'][i].getAttribute("fee"));
      var result = 0;
      if (amount < min)
      {
        notice.innerHTML = notice_overflow + min;
        return;
      }

      if (fee > 0)
      {
        result = (amount - fee) * to / (min -fee);
      }
      else
      {
        //result = (amount + fee* min /(to+fee)) * (to + fee) / min ;
        result = amount * (to + fee) / min + fee;
      }

      notice.innerHTML = notice_result + parseInt(result + 0.5);
    }
  }
}
