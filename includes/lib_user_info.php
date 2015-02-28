<?php
//chen-0909
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
/*
ps：资料已完善达80%时，可获得50积分 
用户名,     昵称,           邮箱,        手机,          真实姓名,     姓别,   所在地区,   固定电话,       QQ,      MSN,宝宝生日,宝宝小名,宝宝性别
user_name,  nickname        email,      mobile_phone,   truename,     sex,    province,    home_phone,   qq,       msn,   bday,    bname,  bsex
*/
function get_userinfo_count()
{
 return 13;
}
function user_information_completed_percent($user_id)
{
  $sql = "select user_name,nickname,email,mobile_phone,truename,sex,province,home_phone,qq,msn,bday,bname,bsex from ".$GLOBALS['ecs']->table('users')." where user_id='$user_id'";
  $userInfo = $GLOBALS['db']->getRow($sql);
  $count = 0; 
  foreach($userInfo as $perInfo)
  {
  $perInfo = trim($perInfo);
     if($perInfo != '' && $perInfo != '0' )
	   $count++;
  }
  return round(100.0*$count/get_userinfo_count() , 2);
}

function is_got_information_completed_integral($user_id)
{
  $sql = "select id from ".$GLOBALS['ecs']->table('integral_record')." where type = 3 and user_id='$user_id'";
  if($GLOBALS['db']->getOne($sql))
    return 1;
  else return 0;
} 

?>