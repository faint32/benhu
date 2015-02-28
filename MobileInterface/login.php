<?php

define('IN_ECS', true);
require('D:/wamp/www/benhushop1231' . '/includes/init.php');

//$type = trim(compile_str($_REQUEST['type']));
$userName = trim(compile_str($_REQUEST['userName']));
$password = trim(compile_str($_REQUEST['password']));

   /*
  $ec_salt = -1;  $validate = 0;
  $result = array();

   switch($type)
   {
      case 'ec_salt':
        $result['ec_salt'] = getEcsaltByUserName($userName);  
      	break;
      case 'user_validate':
        $result['validate'] = isUserValidated($userName, $password);
        break;

   }
   */
  $result = array();
  $ec_salt = getEcsaltByUserName($userName); 
  $result['validate'] = isUserValidated($userName, $password, $ec_salt);
 die(urldecode(json_encode($result)));


function getEcsaltByUserName($userName)
{
    $sql = "SELECT ec_salt FROM ".$GLOBALS['ecs']->table('users')." WHERE user_name = '$userName'";
    $ec_salt = $GLOBALS['db']->getOne($sql);
    $ec_salt = empty($ec_salt) ? -1 : $ec_salt;
    return $ec_salt;
}

function isUserValidated($userName, $password, $ec_salt)
{
  $password = md5($password.$ec_salt);
  $sql = "SELECT user_id FROM ".$GLOBALS['ecs']->table('users')." WHERE user_name = '$userName' AND password='$password'";
  if($GLOBALS['db']->getOne($sql))
  {
     return 1;
  }
  return 0;
}

?>