<?php
//chen-0909
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
/*返回积分类型*/
function get_integral_type()
{
/* 
     case 0: $str='新订单'; break;
	 case 1: $str='评论'; break;
	 case 2: $str='晒单'; break;
	 case 3: $str='注册'; break;
	 case 4: $str='邮箱验证'; break;
	 case 5: $str='签到'; break;
*/
  return array(0,1,2,3,4,5);
}
/**
 * 是否已经签到过 chen-0909
 * @return  bool
 */
 function is_attent()
 {
  $user_id=$_SESSION['user_id'];

 $sql = " select last_attent_time,continuity_times from " . $GLOBALS['ecs']->table('daily_attendance')." where user_id=$user_id order by last_attent_time desc";
 $row=$GLOBALS['db']->getRow($sql);
 
 $now=gmtime();$date = local_date('Y-m-d 0:0:0',$now);$now=local_strtotime($date);
 
 if(( $now == $row['last_attent_time']   ))
   {
    return 1;
   }
   else
   {
     return 0;
   }
 }
 function user_has_got_integral($type, $user_id,  $ever_validated = 0)
 {
  
    switch($type)
	{
	  case 'phone':
	  {
		  if($ever_validated == '0' || $ever_validated == 0)
			 $ever_validated = 2;
		  if($ever_validated == '1' || $ever_validated == 1)
		  $ever_validated = 3;
      }	   
	   break;
	  case 'email':
	  {
	    if($ever_validated == '0' || $ever_validated == 0)
			 $ever_validated = 1;
		  if($ever_validated == '2' || $ever_validated == 2)
		  $ever_validated = 3;
	     break;
	   }
	  default:break;
	}
	$sql = "UPDATE " . $GLOBALS['ecs']->table('users') . " SET ever_validated = '$ever_validated' WHERE user_id='$user_id'";
   if(!$GLOBALS['db']->query($sql))
   {
   show_message('标记用户验证手机/邮箱失败',$_LANG['profile_lnk'],'user.php');
   }
 }
 
 function is_got_RgstPnt()
 {
 return 1;
 }
 /**
 * 用户获得积分，写入users表,并在integral_record表里记录 chen-0909
 *
 * @param   $integral_point(获得的积分) $user_id(用户的id)  $type(积分类型)  $detail(积分详情)  $is_frozen(是否被冰冻)
 *
 * @return  void
 */
 function user_get_point($integral_point,$user_id,$type,$detail,$is_frozen)
 {
   if($is_frozen == 0 )
   {
   $sql = "update ". $GLOBALS['ecs']->table('users')." set pay_points = pay_points + $integral_point where user_id=$user_id";
    $GLOBALS['db']->query($sql);
   }
    $time = gmtime(); 
   $sql = "insert into ".$GLOBALS['ecs']->table('integral_record')." (user_id,integral,type,detail,got_time,is_frozen) values($user_id,$integral_point,$type,'$detail',$time,$is_frozen)";
   $GLOBALS['db']->query($sql);
 }
 /*冻结积分chen-1011*/
 function freeze_integral($integral_point,$user_id,$type,$detail,$freeze_type='order',$order_sn='')
 {
    $sql = '';
	 $time = gmtime();
   switch($freeze_type)
   {
    case 'order':
       $sql = "insert into ".$GLOBALS['ecs']->table('integral_record')." (user_id,integral,type,detail,got_time,is_frozen,order_sn) 
	   values('$user_id','$integral_point',$type,'$detail','$time',1,'$order_sn')";
       break;
	default:
	   break;
	}
	$GLOBALS['db']->query($sql);
 }
 /*解冻积分*/
 function unfreeze_integral($unfreeze_type='order',$order_sn='')
 {
    $sql = '';
   switch($unfreeze_type)
   {
    case 'order':
       $sql = "update ".$GLOBALS['ecs']->table('integral_record')." set is_frozen = 0 where order_sn = $order_sn";  
       break;
	default:
	   break;
	}
	$GLOBALS['db']->query($sql);
 }
 
 
 
  /**
 * 获得被冻结的积分总数 chen-0909
 *
 * @param   $user_id(用户的id)
 * @param   $type(积分类型)
 * @return  int
 */
 function get_frozen_integral($user_id,$type='')
 {
 $con =   ($type=='')? "" :  " and type=$type ";
 $sql = "select sum(integral) from ".$GLOBALS['ecs']->table('integral_record')." where user_id=$user_id $con and is_frozen=1" ;
 $flag=$GLOBALS['db']->getOne($sql);
 if(!$flag) $flag=0;
 return $flag;
 }
 
  /**
 * 获得被冻结的订单数 chen-0909
 *
 * @param   $user_id(用户的id)
 * @param   $type(积分类型)
 * @return  int
 */
 function get_frozen_integral_orderCount($user_id,$type='')
 {
 $con =   ($type=='')? "" :  " and type=$type ";
 $sql = "select count(id) from ".$GLOBALS['ecs']->table('integral_record')." where user_id=$user_id $con and is_frozen=1" ;
 $flag=$GLOBALS['db']->getOne($sql);
 if(!$flag) $flag=0;
 return $flag;
 }
  /**
 * 获得未冻结的积分记录 chen-0909
 *
 * @param   $user_id(用户的id)
 *
 * @return  array
 */
function get_integral_records($user_id, $whereAdition = ' 1 ', $is_frozen = ' is_frozen=0 ', $num = '', $start = 0)
 {
 if($num == '' && $start == 0)
 {
   $limit = ' and 1 ';
 }
 else
 {
   $limit = " LIMIT $start,$num ";
 }
  $sql = "select integral,type,detail,got_time,is_frozen,order_sn from ".
  $GLOBALS['ecs']->table('integral_record')." where user_id=$user_id and $is_frozen and $whereAdition   order by got_time desc" ;
 return get_integral_record($sql, $num, $start );
 }
function get_integral_records_count($user_id, $whereAdition = ' 1 ', $is_frozen = ' is_frozen=0 ')
{
     $sql = "select count(id) from ".
  $GLOBALS['ecs']->table('integral_record')." where user_id=$user_id and $is_frozen and $whereAdition order by got_time desc" ;
 return $GLOBALS['db']->getOne($sql);
}
  /**
 * 获得积分记录 chen-0909
 *
 * @param   $user_id(用户的id)
 *
 * @return  array
 */
 function get_all_integral_records($user_id)
 {
 $sql = "select integral,type,detail,got_time,is_frozen from ".$GLOBALS['ecs']->table('integral_record')." where user_id=$user_id" ;
 return get_integral_record($sql);
 }
 
 /**
 * 根据sql语句获得积分记录 chen-1011
 *
 * @param   $sql
 *
 * @return  array
 */
 function get_integral_record($sql, $num = '', $start = 0)
 {
 if($num == '' && $start == 0)
 {
 $res=$GLOBALS['db']->query($sql);
 }
 else
 {
  $res=$GLOBALS['db']->SelectLimit($sql, $num, $start);
 }
 $arr=array();
 
 while($row=$GLOBALS['db']->fetchRow($res))
 {
   $str='未知';
   switch($row['type'])
   {
     case 0: $str='新订单'; break;
	 case 1: $str='评论'; break;
	 case 2: $str='晒单'; break;
	 case 3: $str='注册'; break;
	 case 4: $str='邮箱验证'; break;
	 case 5: $str='签到'; break;
	 default: $str='未知'; 
   }
   $row['type']=$str;
   $row['got_time']=local_date('Y-m-d',$row['got_time']);
   
  $arr[]=$row;

 }
 return $arr;
 }
 
  /**
 * 用户签到函数 chen-0909
 *
 * @param   user_id gained_integral   用户的id，和签到获得积分
 *
 * @return  bool  签到是否成功
 */
 function user_attent($user_id,$gained_integral)
 {
 $type=5; //类型5：表示每日签到获取的积分
 $detail="每日签到获得$gained_integral"; $is_frozen=0;
 
 
 $sql = " select id,last_attent_time,continuity_times from " . $GLOBALS['ecs']->table('daily_attendance')." where user_id=$user_id order by last_attent_time desc";
 $row=$GLOBALS['db']->getRow($sql);
 
 $now=gmtime();
 $date = local_date('Y-m-d 0:0:0',$now);
 $now=local_strtotime($date);
 
  if(!$row || ( $now - $row['last_attent_time']  > 60*60*24 ))
   {
  user_get_point($gained_integral,$user_id,$type,$detail,$is_frozen);
    $sql = "insert into " . $GLOBALS['ecs']->table('daily_attendance')."(user_id,integral,last_attent_time,continuity_times) values($user_id,$gained_integral,$now,1)";
     $GLOBALS['db']->query($sql);
   }
   
  else if( ( $now - $row['last_attent_time']  == 60*60*24 )   ) 
   {
   user_get_point($gained_integral,$user_id,$type,$detail,$is_frozen);
   $continuity_times=$row['continuity_times']+1;
     $sql = "insert into " . $GLOBALS['ecs']->table('daily_attendance')."(user_id,integral,last_attent_time,continuity_times) values($user_id,$gained_integral,$now,$continuity_times)";
     $GLOBALS['db']->query($sql);
   }
   else //if(( $now == $row['last_attent_time']   ))
   {
    return 0;
   }
   return 1;
 }

?>