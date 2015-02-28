<?php
	define('IN_ECS', true);	
	require(dirname(__FILE__) . '/includes/init.php');
	require_once(ROOT_PATH  . '/includes/lib_common.php');
	require_once(ROOT_PATH  . '/includes/cls_template.php');

	$time = gmtime();
	echo $time."<br/>";
	$date = local_date("Y-m-01 00:00:00",$now);
	$time = local_strtotime($date);
	echo $time."<br/>";
	echo local_date("Y-m-d H:i:s",$time);
	
?>