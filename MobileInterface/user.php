<?php

define('IN_ECS', true);
define('WEB_ROOT', 'D:/wamp/www/benhushop1231');
define('NEW_UESER_RANKNAME', 'VIP0');

define('MOBILE_PHONE_ERROR','2');
define('SMS_ERROR',3);
define('SYSTEM_ERROR',4);
require(WEB_ROOT . '/includes/init.php');
require(WEB_ROOT.'/MobileInterface/lib/lib_user.php');


$act = trim(compile_str($_REQUEST['act']));

switch($act)
{
  case 'login':  
    $userName = trim(compile_str($_REQUEST['userName']));
    $md5Password = trim($_REQUEST['pwd']);
    userLogin($userName, $md5Password);
    break;
  case 'SMS':
    $mobileNum = trim(compile_str($_REQUEST['userName']));
    generateSMS($mobileNum);
    break;
  case 'register':
    $mobileNum = trim(compile_str($_REQUEST['userName']));
    $SMS = trim(compile_str($_REQUEST['SMS']));
    $md5Password = trim($_REQUEST['pwd']);
    userRegister($mobileNum, $SMS, $md5Password);
    break;
  case 'send_find_pwd_SMS':
    generateSMS('','send_find_pwd_SMS');
    break;
  case 'check_find_pwd_SMS':
    $mobile_phone = trim(compile_str($_REQUEST['mobile_phone']));
    $SMS = trim(compile_str($_REQUEST['SMS'])); 
    $md5Password = trim($_REQUEST['pwd']);

    $rtVal = check_find_pwd_SMS($mobile_phone, $SMS, $md5Password);
  
    if(SYSTEM_ERROR == $rtVal)
    {
       die(urldecode(json_encode(array('error'=>'系统错误'))));
    }
    elseif(MOBILE_PHONE_ERROR == $rtVal)
    {
       die(urldecode(json_encode(array('error'=>'手机号码有误'))));
    }
    elseif(SMS_ERROR == $rtVal)
    {
       die(urldecode(json_encode(array('error'=>'验证码错误'))));
    }
    else
    {
       die(urldecode(json_encode(array('success'=>'修改成功'))));
    }
    break;
  default:
    die(urldecode(json_encode(array('error'=>'参数不对'))));
    break;
}


function userLogin($userName, $md5Password)
{
  $result = array();
  $ec_salt = getEcsaltByUserName($userName); 
  $result['validate'] = isUserValidated($userName, $md5Password, $ec_salt);
  die(urldecode(json_encode($result)));
}



function generateSMS($mobileNum, $type = '')
{
  switch($type)
  {
    case 'send_find_pwd_SMS':
    {
      $_REQUEST['type'] = 1;
      $_REQUEST['user_name'] = $_REQUEST['mobile_phone']; 
      require(WEB_ROOT . '/includes/sendSMS.php');
      break;
    }

    case '':
    {
      if(isValidMobileNum($mobileNum))
      {
          if(!isUserNameRegister($mobileNum))
          {
            $_REQUEST['type'] = 'register';
            $_REQUEST['user_name'] = $mobileNum;
            require(WEB_ROOT . '/includes/sendSMS.php');
          }
          else
          {
            die(urldecode(json_encode( array('error'=>'号码已经被注册') )));
            //the mobilePhone number has already registered
          }
      }
      else
      {
         die(urldecode(json_encode( array('error'=>'手机号码有误') )));
      } 
      break;
    }
  } 
}
function check_find_pwd_SMS($mobile_phone, $SMS, $md5Password)
{
    $sql = "SELECT user_id from ecs_users where mobile_phone=$mobile_phone";
    $user_id = $GLOBALS['db']->getOne($sql);  
    if(empty($user_id))
      return MOBILE_PHONE_ERROR;

    $sql = "SELECT short_message from ecs_verified_sms where user_id=$user_id";
    $short_message = $GLOBALS['db']->getOne($sql);
  
    if($SMS== $short_message)
    { 
      if(changeUserPassword($user_id, $md5Password))
      {
         return 1;
      }
      return SYSTEM_ERROR;
    }
    else
    {
      return SMS_ERROR;
    }
}

function userRegister($mobileNum, $SMS, $md5Password)
{
  if(isValidMobileNum($mobileNum))
  {
      if(!isUserNameRegister($mobileNum))
      {
         if(isSMSCorrect($mobileNum, $SMS))
         {
            if(registerUser($mobileNum, $md5Password))
            {
              die(urldecode(json_encode( array('success'=>'注册成功') )));
              //registered
            }
              die(urldecode(json_encode( array('error'=>'验证码错误') )));
              //wrong SMS
         }       
            die(urldecode(json_encode( array('error'=>'验证码错误') )));
      }
        die(urldecode(json_encode( array('error'=>'号码已经被注册') )));
  }
    die(urldecode(json_encode( array('error'=>'号码已经被注册') ))); 

}
?>