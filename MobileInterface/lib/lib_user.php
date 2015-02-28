<?php

function getEcsaltByUserName($userName)
{
    $sql = "SELECT ec_salt FROM ".$GLOBALS['ecs']->table('users')." WHERE user_name = '$userName'";
    $ec_salt = $GLOBALS['db']->getOne($sql);
    $ec_salt = empty($ec_salt) ? -1 : $ec_salt;
    return $ec_salt;
}

function isUserValidated($userName, $md5Password, $ec_salt)
{
  $password = md5($md5Password.$ec_salt);
  $sql = "SELECT user_id FROM ".$GLOBALS['ecs']->table('users')." WHERE user_name = '$userName' AND password='$password'";
  if($GLOBALS['db']->getOne($sql))
  {
     return 1;
  }
  return 0;
}

function isValidMobileNum($mobileNum)
{
  if(preg_match("/^(13|14|15|18)[0-9]{9}$/",$mobileNum)) //var reg_phone = /(13|14|15|18)\d{9}/; //来源:许配
  {        
    return true;
  }
  else
  {    
     return false;
  }
}

function isUserNameRegister($userName)
{
  $sql = "SELECT user_id FROM ".$GLOBALS['ecs']->table('users')." WHERE user_name = '$userName'";
  if($GLOBALS['db']->getOne($sql))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function isSMSCorrect($mobileNum, $SMS)
{
   $sql = "select short_msm from ".$GLOBALS['ecs']->table('verified_register_SMS')." where phone = '$mobileNum'";
   $sent_sms = $GLOBALS['db']->getOne($sql);
   if($SMS != $sent_sms)
   {
     return false;
   }
   return true;
}


function changeUserPassword($user_id, $md5Password)
{
  $sql = "SELECT  ec_salt FROM ".$GLOBALS['ecs']->table('users')." WHERE user_id='$user_id'";
  $ec_salt = $GLOBALS['db']->getOne($sql);

  $password = md5($md5Password.$ec_salt);
  $sql = "UPDATE ".$GLOBALS['ecs']->table('users')." SET password='$password' WHERE user_id='$user_id'";
  if($GLOBALS['db']->query($sql))
    return true;
  return fasle;
}

function registerUser($mobileNum, $md5Password)
{
   $ec_salt = rand(1000,9999);
   $password = md5($md5Password.$ec_salt);

   $rankId = getNewUserRankId();
   $sql = "INSERT INTO ".$GLOBALS['ecs']->table('users')."(user_name, ec_salt, mobile_phone, chat_validated, password, user_rank) VALUES('$mobileNum', '$ec_salt', '$mobileNum', 2, '$password', $rankId)";

   if($GLOBALS['db']->query($sql))
   {
     require_once(WEB_ROOT . '/includes/lib_integral.php');
     $userId = $GLOBALS['db']->insert_id();
     user_get_point($GLOBALS['_CFG']['validated_integral'], $userId, 4, '手机验证获得积分', 0);
     user_has_got_integral('phone', $userId);
     return true;
   }
   return false;
}




function getNewUserRankId()
{
   $sql = "SELECT rank_id FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_name = '".NEW_UESER_RANKNAME."'";
   $rank_id = $GLOBALS['db']->getOne($sql);
   return $rank_id;
}
?>