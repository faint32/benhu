<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<title><?php echo $this->_var['page_title']; ?></title>
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<link href="style/css/user.css" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.min.js,common.js,user.js,transport.js,register.js')); ?>
  <body>
  <?php echo $this->fetch('library/page_header.lbi'); ?>
    <?php if ($this->_var['action'] == 'login'): ?> 
        <div class="login_box">
          <div class="login">
            <div class="login_left">
                <h1>用户登录</h1>
                   <div class="user_point">
                	<b>请输入正确的用户名！</b>
                    </div>
                <form name="formLogin" action="user.php" method="post"  onSubmit="return userLogin();">
                  <span class="login_left_a">
                    <input name="username" type="text" value="请输入邮箱或手机号码" onfocus="if(this.value=='请输入邮箱或手机号码'){this.value='';}"  onblur="if(this.value==''){this.value='请输入邮箱或手机号码';}" />
                  </span>
                   <div class="user_point">
                    <b>请输入密码！</b>
                  </div>
                  <span class="login_left_b">
                      <input  id="pwd" name="password" type="password" value="" />                  
                  </span>
                  <table width="310" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="24" height="70">
                        <input id="checkbox"  name="remember" value="1" type="checkbox">
                        <label for="checkbox"></label>
                      </td>
                      <td width="166">七天内免登录</td>
                      <td width="120" align="right">
                        <a href="user.php?act=get_password">忘记密码？</a>
                      </td>
                    </tr>
                  </table>
                  <input type="hidden" name="act" value="act_login" />
                  <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
                  <p class="login_left_c">
                    <input  type="submit" value=""/>
                  </p>
              </form>
            </div>
        
	    <div class="login_right">
                <h4>其他方式登录</h4>
                    <div class="login_right_a">
                        <a href="user.php?act=oath&type=weibo">新浪微薄账号登录</a>
                        <a href="user.php?act=oath&type=qq">QQ账号登录</a>
                       <!-- <a href="user.php?act=oath&type=taobao">淘宝账号登录</a>-->
                    </div>
            </div>
	
        </div>
        </div> 
    <?php endif; ?> 
     


             
    <?php if ($this->_var['action'] == 'register'): ?>               


      <?php if ($this->_var['shop_reg_closed'] == 1): ?>            
        <div class="usBox">
          <div class="usBox_2 clearfix">
            <div class="f1 f5" align="center"><?php echo $this->_var['lang']['shop_register_closed']; ?></div>
          </div>
        </div>
      <?php else: ?>                                
	  <script>
	    function send_verify_SMS(eindex,validate,id)
		   {
		    var phone = $('#mobilePhone'+eindex).val(); 
            if(!reg_phone.test(phone))
            {
			  alert('手机号码格式不正确');
			  return false;
			}	
			 is_registered('phone',phone);// == false
			if($('#usedphone').css('display') == 'block')//手机已经被注册了
			{
			  return ;
			}
 
		   	$.post("user.php",{act:"set_user_contact",type:"phone",value:phone,is_validate:validate},function(result)
					{
					
					if(result=='0')
						{
						  alert("这个手机已经被其他人使用了");
						}
						else if(result=='1')
						{
						 alert("请先解除该手机号的绑定");
						}
						else
						{
						
						
						 switch(id)
						 {
						   case 'send_SMS_CountDown':
						      sendSMS(eindex,validate,29);
							  countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_index0',1,'" + id + "')");
							  break;
						  case 'sendNewPhoneSMS':
						   sendSMS(eindex,validate,29);
						      countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_indexNew',2,'" + id + "')");
						     break;
						   case 'sendOldPhoneSMS':
						    sendSMS(eindex,validate,29);
						      countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_indexOld',1,'" + id + "')");
						     break;
							  case 'sendRegisterSMS':
							   sendRegisterSMS(phone);
						      countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_indexRegister',1,'" + id + "')");
						     break;
						  }
						 }
						
					});	   
					
		   }

	  </script>
      <div class="login_box">
          <div class="login">
            <div class="register">
              <div class="title cf">
                <ul class="title-list cf ">
                  <li class="on">邮箱注册</li>
                  <li>手机注册</li>
                  <p><b></b></p>
                </ul>
              </div> 
              <div class="register_box">
                  
                <form class="register_main show" action="user.php" method="post" name="emailUser" onsubmit="return register('email');">
                  <div class="register_main show">
				  
                    <span class="register_input_1">
                      <h4>邮箱：</h4>
                      <input type="text" name="email"
                      value="请输入邮箱地址" 
                      onfocus="if(this.value=='请输入邮箱地址'){this.value='';}"  
                      onblur="if(this.value==''){this.value='请输入邮箱地址';}else{is_registered('email',this.value);}"
                       />
                    </span>
                    <div class="user_point">
                    <b id="email" style="display:none;">请输入正确的邮箱地址！</b>
                    <b id="usedemail" style="display:none;">邮箱地址已经被注册！</b>
                   </div>
				   
				    <span class="register_input_1">
                      <h4>昵称：</h4>
                      <input  id="fkEmlNickName" type="text" value="请输入昵称" onfocus="chToPwd('fkEmlNickName','nickName');"  />
                      <input style="display:none;" id="nickName" name="email_nick_name" type="text" value=""   onblur="if(this.value==''){chToTxt('nickName','fkEmlNickName');}" />
                 
                    </span>
                    <div class="user_point">
                      <b  id="email_nick_name" style="display:none;">昵称不能为空！</b>
                    </div>
				   
				   
                    <span class="register_input_1">
                      <h4>设置密码：</h4>
                      <input  id="fkEmlPwd" type="text" value="6-20个大小写英文字母、符号或数字" onfocus="chToPwd('fkEmlPwd','emlPwd');"  />
                      <input style="display:none;" id="emlPwd" name="email_psd" type="password" value=""   onblur="if(this.value==''){chToTxt('emlPwd','fkEmlPwd');}" />
                 
                    </span>
                    <div class="user_point">
                      <b  id="email_psd" style="display:none;">密码应为：6-20个大小写英文字母、符号或数字</b>
                    </div>
					
					
                    <span class="register_input_1">
                      <h4>确认密码：</h4>
                      <input  id="fkEmlRptPwd" type="text" value="再次输入密码" onfocus="chToPwd('fkEmlRptPwd','emlRptPwd');"  />
                      <input style="display:none;" id="emlRptPwd" name="email_rep_psd" type="password" value=""   onblur="if(this.value==''){chToTxt('emlRptPwd','fkEmlRptPwd');}" />                  
                    </span>
                    <div class="user_point" >
                      <b id="email_rep_psd" style="display:none;">确认密码：两个密码应该一样！</b>
                    </div>
              <?php if ($this->_var['enabled_captcha']): ?>
                    <div class="register_input_2_box">
                      <span class="register_input_2">
                        <h4>验证码：</h4>
						 <input  id="fkEmlCaptcha" type="text" value="验证码" onfocus="chToPwd('fkEmlCaptcha','captcha');"  />
                      <input style="display:none;" id="captcha" name="captcha" type="text" value=""   onblur="if(this.value==''){chToTxt('captcha','fkEmlCaptcha');}" />
                       
                      </span>
                      <div class="register_input_3">
                        <img class="verify_pic" src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;"  />
                      </div>
                      <a href="javascript:void(0);" onclick="change_veriPic()" class="register_input_4">换一张</a>
                       <div class="user_point" >
                        <b id="email_verify" style="display:none;">请输入正确的验证码！</b>
                      </div>
                    </div>
              <?php endif; ?>

                    <table width="300" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="50">
                          <input name="email_agreement" type="checkbox" value="1" />
                        </td>
                        <td>我已阅读并同意<a href="article-148.html" class="only">《笨虎之家服务协议》</a></td>
                      </tr>
                    </table>
                    <p class="register_input_5">
                      <input id='emlSubmit' type="submit" value="注&nbsp;&nbsp;册" />
                      <input name="act" type="hidden" value="act_register" >
					  <input name='type' type='hidden' value='email' />
                      <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
                    </p>
                  </div>
                </form>
                                 
                <form class="register_main" action="user.php" method="post" name="phoneUser" onsubmit="return register('phone');">
                  <div class="register_main show">
                    <span class="register_input_1">
                      <h4>手机号：</h4>
                      <input type="text" name="phone"  id="mobilePhone_indexRegister"
                      value="请输入手机号" 
                      onfocus="if(this.value=='请输入手机号'){this.value='';}"  
                      onblur="if(this.value==''){this.value='请输入手机号';}else{is_registered('phone',this.value);}" />
                    </span>
                    <div class="user_point" >
                    <b id="phone" style="display:none;">请输入正确的手机号！</b>
                    <b id="usedphone" style="display:none;">手机号已经被注册！</b>
                   </div>
				   
				   
                    <div class="register_input_2_box">
					  <span class="register_input_2">
                        <h4>验证短信：</h4>
						 <input style="width:80px" id="fkPhoneCaptcha" type="text" value="输入短信" onfocus="chToPwd('fkPhoneCaptcha','phoneCaptcha');"  />
                         <input style="width:80px;display:none;" id="phoneCaptcha" name="captcha" type="text" value=""   onblur="if(this.value==''){chToTxt('phoneCaptcha','fkPhoneCaptcha');}" />
                      </span>
					 <a class="register_input_4" id='sendRegisterSMS' onclick="send_verify_SMS('_indexRegister',1,'sendRegisterSMS')" href="javascript:void(0);">发送短信</a>
                     
                       <div class="user_point" >
                        <b id="phone_verify" style="display:none;">请输入正确的验证短信！</b>
                      </div>
                    </div>
             
				   
				   
				   
				   <span class="register_input_1">
                      <h4>昵称：</h4>
                      <input  id="fkPhoneNickName" type="text" value="请输入昵称" onfocus="chToPwd('fkPhoneNickName','phoneNickName');"  />
                      <input style="display:none;" id="phoneNickName" name="phone_nick_name" type="text" value=""   onblur="if(this.value==''){chToTxt('phoneNickName','fkPhoneNickName');}" />
                    </span>
                    <div class="user_point">
                      <b  id="phone_nick_name" style="display:none;">昵称不能为空！</b>
                    </div>
				   
                    <span class="register_input_1">
                      <h4>设置密码：</h4>
                         <input  id="fkPhnPwd" type="text" value="6-20个大小写英文字母、符号或数字" onfocus="chToPwd('fkPhnPwd','phnPwd');"  />
                        <input style="display:none;" id="phnPwd" name="phone_psd" type="password" value=""   onblur="if(this.value==''){chToTxt('phnPwd','fkPhnPwd');}" />                  
                    </span>
                    <div class="user_point">
                      <b  id="phone_psd" style="display:none;">请输入符合要求的密码！</b>
                    </div>
					
					
                    <span class="register_input_1">
                      <h4>确认密码：</h4>
                        <input  id="fkPhnRptPwd" type="text" value="再次输入密码" onfocus="chToPwd('fkPhnRptPwd','phnRptPwd');"  />
                        <input style="display:none;" id="phnRptPwd" name="phone_rep_psd" type="password" value=""   onblur="if(this.value==''){chToTxt('phnRptPwd','fkPhnRptPwd');}" />                  
                    </span>
                    <div class="user_point" >
                      <b id="phone_rep_psd" style="display:none;">请输入符合要求的确认密码，它应该和你的密码一样！</b>
                    </div>
            

                    <table width="300" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="50">
                          <input name="phone_agreement" type="checkbox" value="1" />
                        </td>
                        <td>我已阅读并同意<a href="article-148.html" class="only">《笨虎之家服务协议》</a></td>
                      </tr>
                    </table>
                    <p class="register_input_5">
                      <input id="phoneSubmit" type="submit" value="注&nbsp;&nbsp;册" />
					  <input name='type' type='hidden' value='phone' />
                      <input name="act" type="hidden" value="act_register" >
                      <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
                    </p>
                  </div>
                </form>
                
                  
                </div>
              </div>
            </div>
          </div>
      <?php endif; ?> 
    <?php endif; ?> 
     

                   
    <?php if ($this->_var['action'] == 'get_password'): ?> 
      <form onsubmit="return judge_account();" action="user.php" method="post">
        <input type="hidden" id="get_pwd_step1" name="act" value="" />
        <div class="login_box">
          <div class="findpassword">
                <p class="findpassword_1"></p>
                <div class="findpassword_2">

                      <div class="user_point">
                          <b style="display:none;" id="account">输入的邮箱地址或手机号有误！</b>
                      </div>
                      <span class="register_input_1">
                        <h4>账户名：</h4>
                        <input type="text" name="user_name" id="user_name" value="账户名是你注册时用到的邮箱地址或手机号" onfocus="if(this.value=='账户名是你注册时用到的邮箱地址或手机号'){this.value='';}"  onblur="if(this.value==''){this.value='账户名是你注册时用到的邮箱地址或手机号';}" />
                      </span>
                      <div class="register_input_2_box">
                        <div class="user_point">
                          <b style="display:none;" id="captcha">请输入正确的验证码！</b>
                        </div>
                        <span class="register_input_2">
                          <h4>验证码：</h4>
                          <input id="cpt" type="text" value="验证码" onfocus="if(this.value=='验证码'){this.value='';}"  onblur="if(this.value==''){this.value='验证码';}"/>
                        </span>
                        <span class="register_input_3">
                          <img class="verify_pic" src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;"  />
                        </span>
                        <a href="javascript:void(0);" onclick="change_veriPic()" class="register_input_4">换一张</a>
                      </div>

                      <p class="register_input_5 mt">
                        <input type="submit"  value="下一步" />
                      </p>

                </div>
          </div>
        </div>
      </form>
    <?php endif; ?>
    <?php if ($this->_var['action'] == 'get_phone_password'): ?> 
      <form method="get" action="user.php">
         <input type="hidden" name="act" value="check_SMS_code" />
        <!--  <input type="hidden" name="code" id='code' value="111111"/> -->
        <script language="JavaScript">
          var cookie_value="<input type='hidden' name='cookie_value'  value='"+Math.random()+"'/>"
          document.write(cookie_value);
        </script>
          <div class="login_box">
            <div class="findpassword"> 
                <p class="findpassword_1_a">
                </p>
                <div class="findpassword_2">
                      <div class="user_point">
                          <b style="display:none">请输入正确的手机号！</b>
                      </div>
                      <div class="register_input_2_box">
                        <span class="findpassword_2_input_1">
                          <h4>您的手机号码：</h4>
                          <input type="text" id="mobilePhone0" name="mobilePhone" value="<?php echo $this->_var['phoneNum']; ?>" readonly="true"/>
                        </span>&nbsp;
                        <a href="javascript:void(0);"  onclick="sendSMS(0,1);" class="findpassword_2_input_2" >获取短信验证码</a>
                       <!--  <input type="button"  onclick="sendSMS(this,60);" class="findpassword_2_input_2" value="获取短信" style="height:30px;margin-top:10px;"/> -->
                      </div>
                      <div class="user_point">
                          <b style="display:none">请输入正确的验证码！</b>
                      </div>
                      <span class="register_input_1">
                        <h4>验证码：</h4>
                        <input id='verify_code' name='verify_code' type="text" value="请输入手机接收的验证码" onfocus="if(this.value=='请输入手机接收的验证码'){this.value='';}"  onblur="if(this.value==''){this.value='请输入手机接收的验证码';}" />
                      </span>
                      <p class="register_input_5 mt">
                        <input type="submit"  value="下一步" />
                      </p>
                </div>
            </div>
          </div>
      </form>   
    <?php endif; ?> 
    <?php if ($this->_var['action'] == 'get_email_password'): ?>  
      <div class="login_box">
          <div class="findpassword">
              <p class="findpassword_1_a"></p>
              <p class="findpassword_2_word">邮件已发送至<?php echo $this->_var['emailAddr']; ?>，请在2小时内登录您的邮箱重置密码！</p>
                <div class="findpassword_2">
                  <p class="register_input_5 mt">
                    <input type="button" value="立即登录邮箱" onclick="window.location.href='<?php echo $this->_var['emailLink']; ?>';"/>
                  </p>
                </div>
              <p class="findpassword_2_word_2">
                      如果长时间收不到邮件可以尝试：<br />
                    致电客服：400-0021-053<br />
                    发送邮件到客服邮箱：1664241325@qq.com
              </p>
          </div>
            
      </div>
    <?php endif; ?> 

    <?php if ($this->_var['action'] == 'reset2_password'): ?>   
      <META   HTTP-EQUIV="Cache-Control"   CONTENT="no-cache">
      <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
        <input type="hidden" name="act" value="act_edit_phone_password" />
        <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
        <input type="hidden" name="cookie_value" value="<?php echo $this->_var['cookie_value']; ?>" />
        <div class="login_box">
            <div class="findpassword">
                  <p class="findpassword_1_b"></p>
                  <div class="findpassword_2">
                      <div class="user_point"> 
                          <b id="shPwdInfo" style="display:none">密码格式：6-20个字母和数字</b>
                      </div>
                      <span class="register_input_1">
                        <h4>新密码：</h4>
                        <input  id="fkNewPwd" type="text" value="6-20个大小写英文字母、符号或数字" onfocus="chToPwd('fkNewPwd','newPwd');"  />
                        <input style="display:none;" id="newPwd" name="new_password" type="password" value=""   onblur="if(this.value==''){chToTxt('newPwd','fkNewPwd');}" />
                      </span>
                      <div class="user_point">
                          <b id="shRepPwdInfo" style="display:none">提示：确认密码要和新密码一样！</b>
                      </div>
                      <span class="register_input_1">
                        <h4>确认密码：</h4>
                        <input  id="fkNewConfPwd" type="text" value="6-20个大小写英文字母、符号或数字" onfocus="chToPwd('fkNewConfPwd','newConfPwd');"  />
                        <input style="display:none;" id="newConfPwd" name="confirm_password" type="password" value=""   onblur="if(this.value==''){chToTxt('newConfPwd','fkNewConfPwd');}" />            
                      </span>
                      <p class="register_input_5 mt">
                        <input type="submit" name="submit" value="下一步" />
                      </p>
                  </div>
            </div>
        </div>
       </form>
    <?php endif; ?> 
    <?php if ($this->_var['action'] == 'reset_password'): ?> 
      <META   HTTP-EQUIV="Cache-Control"   CONTENT="no-cache">
      <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
          <input type="hidden" name="act" value="act_edit_password" />
          <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
          <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
          <input type="hidden" name="cookie_value" value="<?php echo $this->_var['cookie_value']; ?>" />
          <div class="login_box">
              <div class="findpassword">
                    <p class="findpassword_1_b"></p>
                    <div class="findpassword_2">
                        <div class="user_point"> 
                            <b id="shPwdInfo" style="display:none">密码格式：6-20个字母和数字</b>
                        </div>
                        <span class="register_input_1">
                          <h4>新密码：</h4>
                          <input  id="fkNewPwd" type="text" value="6-20个大小写英文字母、符号或数字" onfocus="chToPwd('fkNewPwd','newPwd');"  />
                          <input style="display:none;" id="newPwd" name="new_password" type="password" value=""   onblur="if(this.value==''){chToTxt('newPwd','fkNewPwd');}" />
                        </span>
                        <div class="user_point">
                            <b id="shRepPwdInfo" style="display:none">提示：确认密码要和新密码一样！</b>
                        </div>
                        <span class="register_input_1">
                          <h4>确认密码：</h4>
                          <input  id="fkNewConfPwd" type="text" value="6-20个大小写英文字母、符号或数字" onfocus="chToPwd('fkNewConfPwd','newConfPwd');"  />
                          <input style="display:none;" id="newConfPwd" name="confirm_password" type="password" value=""   onblur="if(this.value==''){chToTxt('newConfPwd','fkNewConfPwd');}" />            
                        </span>
                        <p class="register_input_5 mt">
                          <input type="submit" name="submit" value="下一步" />
                        </p>
                    </div>
              </div>
          </div>
      </form> 
    <?php endif; ?>

    <?php if ($this->_var['action'] == 'pageRedirect'): ?>     
       <meta http-equiv="refresh" content="3;URL=<?php echo $this->_var['redrectUrl']; ?>" />
        <div class="login_box">
          <div class="findpassword">
              <span class="findpassword_2_four_1" style="background:url('')"><?php echo $this->_var['smalltext']; ?></span>
              <span class="register_1_tixing_2 mb">
                <?php echo $this->_var['content']; ?>
                <a class="only" href="<?php echo $this->_var['redrectUrl']; ?>">点击这里</a>。
              </span>
          </div>
        </div>
    <?php endif; ?>
    <?php if ($this->_var['action'] == 'editPwdScs'): ?>
       <meta http-equiv="refresh" content="3;URL='user.php?act=login'" />
        <div class="login_box">
          <div class="findpassword">
              <p class="findpassword_1_c"></p>
              <span class="findpassword_2_four_1">密码修改成功！</span>
              <span class="register_1_tixing_2 mb">
                您的密码已经修改成功，3秒后自动返回登陆页面，如果未返回请
                <a class="only" href="user.php?act=login">点击这里</a>。
              </span>
          </div>
        </div>     
    <?php endif; ?> 
     <!--  <div class="footer_2 main middle over">ICP备案证书号:沪ICP备10215750号<br />Tel: 400 E-mail: 1826280692@qq.com<br />1826280692  taoxiaoxiao2009<br />© 2005-2014 笨虎母婴之家 版权所有，并保留所有权利。
      </div> -->
	<?php echo $this->fetch('library/page_footer.lbi'); ?>
  </body>
</html>