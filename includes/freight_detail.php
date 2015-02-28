<?php


define('IN_ECS', true);

 
  $freightType = !empty($_REQUEST['freightType']) ? trim($_REQUEST['freightType']) : '';
 $freightCom =  !empty($_REQUEST['freightCom']) ? trim($_REQUEST['freightCom']) : '';
$freightNo = !empty($_REQUEST['freightNo']) ? trim($_REQUEST['freightNo']) : '';
 
 switch($freightType)
 {
 case "'aicha'":

 //*
 $visitUrl = "http://api.ickd.cn/?id=106958&secret=d99b83f6a3b376f8ff74dc78f2ff4060&com=$freightCom&nu=$freightNo&type=json&ord=asc&encode=utf8"; 

  $visitUrl = str_replace('\'','',$visitUrl);
 
 $ch = curl_init($visitUrl); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_HEADER, 1);

$output = curl_exec($ch);
echo $output;
curl_close($ch);
//*/
break;
}


exit;

 ?>
