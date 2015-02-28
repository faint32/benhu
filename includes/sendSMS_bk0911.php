<?php
define('IN_ECS', true);
///*
//include_once(ROOT_PATH . 'includes/lib_passport.php');
//include_once(ROOT_PATH . 'includes/init.php');
include_once( 'lib_passport.php');
 include_once( 'init.php');
 $moblie = !empty($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : ''; 
 $user_info = $user->get_user_info($moblie);
///*
//发送短信验证码
if($user_info){
	//echo "<br>号码正确：$moblie<br>";
	//随机生成六位数的验证码
	$num = rand(100000,999999);
	//保存验证码
	//echo $num;
     require('HttpSend.php');
	//发送短信

	$sender = new HttpSend();
	//以下为所需参数,测试时请修改,中文参数请转码
	$strReg = "101100-WEB-HUAX-458221";   //注册号(由华兴软通提供)101100-WEB-HUAX-458221
	$strPwd = "AAAAAAAA";                 //密码NIRGSEBM(由华兴软通提供)AAAAAAAA
	$strSourceAdd = "";                   //子通道号，可为空（预留参数一般为空）
	$strPhone = $moblie;//手机号码，多个手机号用半角逗号分开，最多1000个

	$strContent="您的验证码为：".$num."【笨虎科技】"; 

	//以下参数为服务器URL,以及发到服务器的参数，不用修改
	$strSmsUrl = "http://www.stongnet.com/sdkhttp/sendsms.aspx";
	$strSmsParam = "reg=" . $strReg . "&pwd=" . $strPwd . "&sourceadd=" . $strSourceAdd . "&phone=" . $strPhone . "&content=" . $strContent;
	//发送短信
	//$strRes = $sender->postSend($strSmsUrl,$strSmsParam); //测试发短信
	  
	    $user_id =  $user_info['user_id'];
      
        $sql = "SELECT user_id from ecs_verified_sms where user_id=$user_id";
       $row = $db->getRow($sql);      
        //echo "row==";var_dump($row);echo "<br>";
        $time= time();
        $flag='';
         if($row)
         {
         	  // echo "<br/>id1111==$user_id. time=$time. date==$date. code==$num";
         	  $sql = "select lastest_send_time from ecs_verified_sms where user_id=$user_id";
              $tm=$db->getOne($sql);  //上一次发送时间
               if($time-$tm>60)
               {
                 $sql = "update ecs_verified_sms set short_message=$num,lastest_send_time=$time where user_id=$user_id";
	             $flag=$db->query($sql);
	             //发送短信
	           $strRes = $sender->postSend($strSmsUrl,$strSmsParam);
			 
               }
              
               //	echo "<br>时间差为：".($time-$tm)."<br>";
              
         }else{
         	// echo "<br/>id2222==$user_id. time=$time. date==$date. code==$num";
              $sql = "insert into  ecs_verified_sms(user_id,short_message,lastest_send_time) values($user_id,$num,$time)";
	          $flag=$db->query($sql);
	           //发送短信
	           $strRes = $sender->postSend($strSmsUrl,$strSmsParam);
         }
	   
	  if($flag){
	  	echo "ok";
	  }else{
	  	echo "no";
	  }
	//echo "<br>flag：$flag <br>";
}
//*/
?>
