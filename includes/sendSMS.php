<?php
define('IN_ECS', true);

include_once( 'lib_passport.php');
 include_once( 'init.php');
    include_once('HttpSend.php');
	
 $mobile = !empty($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : '';
 $type =  !empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;
 $user_id = !empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

 $user_name=$mobile;
 
 if($type==1) //普通发送信息
 {
   $sql = "select user_name from ecs_users where mobile_phone=$mobile";
  
   $user_name=$GLOBALS['db']->getOne($sql); 
   
   // $user_info = $user->get_user_info($user_name);
	 $sql = "SELECT * FROM ".$GLOBALS['ecs']->table('users')." where mobile_phone=$mobile";
   $user_info = $GLOBALS['db']->getRow($sql); 
 }

 else if($type==2)  //更改手机号码，给新手机号发信息
 {
   $sql = "select user_name from ecs_users where user_id=$user_id";
   $user_name=$GLOBALS['db']->getOne($sql); 
    $user_info = $user->get_user_info($user_name);
 }
   else if($type == 'register')
   {
       $sql = "select phone from ecs_verified_register_SMS where phone = '$mobile'";
	   $flag = $GLOBALS['db']->getOne($sql);
	   	$sender = new HttpSend();
		$num = rand(100000,999999);
	   $send_sms = get_strSmsParam($mobile,$num);
	   $sms_url = get_strSmsUrl();
	  $time = time();
	   if($flag)
	   {
	     $sql = "update ecs_verified_register_SMS set short_msm='$num',send_time='$time' where phone='$mobile'";
		 $flag = $GLOBALS['db']->query($sql);
	   }
	   else 
	   {
	   $sql = "insert into ecs_verified_register_SMS(phone,short_msm,send_time) values('$mobile','$num','$time') ";
		 $flag = $GLOBALS['db']->query($sql);
	   }
	    if($flag)
	   {
		 $strRes = $sender->postSend($sms_url,$send_sms);
		 die(urldecode( json_encode( array('success'=>'短信已发送，请查收！') )) );
	   }
	   exit;
   }

//发送短信验证码
if($user_info){
	$num = rand(100000,999999);
	//保存验证码
	//echo $num;
     require_once('HttpSend.php');
	//发送短信

	$sender = new HttpSend();
	//以下为所需参数,测试时请修改,中文参数请转码
	$strReg = "101100-WEB-HUAX-458221";   //注册号(由华兴软通提供)101100-WEB-HUAX-458221
	$strPwd = "AAAAAAAA";                 //密码NIRGSEBM(由华兴软通提供)AAAAAAAA
	$strSourceAdd = "";                   //子通道号，可为空（预留参数一般为空）
	$strPhone = $mobile;//手机号码，多个手机号用半角逗号分开，最多1000个

	$strContent="您的验证码为：".$num."【笨虎科技】"; 

	//以下参数为服务器URL,以及发到服务器的参数，不用修改
	$strSmsUrl = "http://www.stongnet.com/sdkhttp/sendsms.aspx";
	$strSmsParam = "reg=" . $strReg . "&pwd=" . $strPwd . "&sourceadd=" . $strSourceAdd . "&phone=" . $strPhone . "&content=" . $strContent;

	    $user_id =  $user_info['user_id'];
      
        $sql = "SELECT user_id from ecs_verified_sms where user_id=$user_id";
		
       $row = $GLOBALS['db']->getRow($sql);      

		$time= time();
        $flag='';
         if($row)
         {
         	  $sql = "select lastest_send_time from ecs_verified_sms where user_id=$user_id";
              $tm=$GLOBALS['db']->getOne($sql);  //上一次发送时间
               if($time-$tm>60)
               {
                 $sql = "update ecs_verified_sms set short_message=$num,lastest_send_time=$time,type=$type where user_id=$user_id";
	             if($type==2)
				  {
					$sql = "update ecs_verified_sms set new_shot_msg=$num,lastest_send_time=$time,type=$type,new_phone=$mobile where user_id=$user_id";

				  }
				 $flag=$GLOBALS['db']->query($sql);
	             //发送短信
	           $strRes = $sender->postSend($strSmsUrl,$strSmsParam);
               }
         }else{
              $sql = "insert into  ecs_verified_sms(user_id,short_message,lastest_send_time,type) values($user_id,$num,$time,$type)";
			  if($type==2)
			  {
			    $sql = "insert into  ecs_verified_sms(user_id,new_shot_msg,lastest_send_time,type,new_phone) values($user_id,$num,$time,$type,$mobile)";
			  }
	          $flag=$GLOBALS['db']->query($sql);
	           $strRes = $sender->postSend($strSmsUrl,$strSmsParam);
         }
	   
	  if($flag){
	  	 die(urldecode( json_encode( array('success'=>'发送成功！') )) );
	  }else{
	  	 die(urldecode( json_encode( array('error'=>'发送失败！') )) );
	  }
	  exit;
}
else
{
	echo "0";
	exit;
}

function getUserIdFromMobile($mobile)
{
	return 1;
}
function get_strSmsUrl()
{
	return "http://www.stongnet.com/sdkhttp/sendsms.aspx";
}
function get_strSmsParam($mobile,$num)
{
	//以下为所需参数,测试时请修改,中文参数请转码
	$strReg = "101100-WEB-HUAX-458221";   //注册号(由华兴软通提供)101100-WEB-HUAX-458221
	$strPwd = "AAAAAAAA";                 //密码NIRGSEBM(由华兴软通提供)AAAAAAAA
	$strSourceAdd = "";                   //子通道号，可为空（预留参数一般为空）
	$strPhone = $mobile;//手机号码，多个手机号用半角逗号分开，最多1000个

	$strContent="您的验证码为：".$num."【笨虎科技】"; 

	//以下参数为服务器URL,以及发到服务器的参数，不用修改
	$strSmsUrl = "http://www.stongnet.com/sdkhttp/sendsms.aspx";
	$strSmsParam = "reg=" . $strReg . "&pwd=" . $strPwd . "&sourceadd=" . $strSourceAdd . "&phone=" . $strPhone . "&content=" . $strContent;
	return $strSmsParam;
}

?>