<?php
	define('IN_ECS', true);
	define('LIMIT_NUM',8);
	define('MONTH_GAIN_COUPONS_NUM', 10);
	require(dirname(__FILE__) . '/includes/init.php');
	require_once(ROOT_PATH  . '/includes/lib_common.php');
	require_once(ROOT_PATH  . '/includes/cls_template.php');
	
   if ((DEBUG_MODE & 2) != 2)
	{
		//$smarty->caching = true;
	}

    $act =  empty($_REQUEST['act']) ? 'default' : $_REQUEST['act'];


	if('default' == $act)
	{
		$cache_id = sprintf('%X', crc32('coupons'. '-' . $_CFG['lang']));
		if (!$smarty->is_cached('coupons.dwt', $cache_id))
		{
			update_coupon_today_sent_num();
			$coupons = get_coupons();
			$smarty->assign('coupons', $coupons);

			assign_template();
			$smarty->assign('categories',      get_categories_tree_pro()); // 分类树
			$smarty->assign('helps',           get_shop_help());       // 网店帮助
		}
		$smarty->display('coupons.dwt', $cache_id);
	}
	elseif('gain_coupon' == $act)
	{
		$staticPages = getStaticPage();
		$result = array('error'=>0);
        if(empty($_SESSION['user_id']))
        {
 			$result['error'] = 1;
 			$result['info'] = '您还没有登陆,请登陆后领取。';
 			$result['action'] = '登陆后可领取丰厚的购物券哦！立即<a href="'.$staticPages['user'].'">登陆</a>！';
        }
        elseif(is_restricted_coupon_num($_REQUEST['coupon_id']))
        {
        	$result['error'] = 1;
 			$result['info'] = '购物券已经发光了!';
 			$result['action'] = '您还可以<a href="#">查看我的购物券</a>&nbsp;&nbsp;&nbsp;<a href="'.$staticPages['index'].'">现在去购物</a>';
        }
        elseif(is_restricted_gain_coupon($_SESSION['user_id']))
        {
            $result['error'] = 1;
 			$result['info'] = '今天已领取过了或者这个月已领完10张!';
 			$result['action'] = '您还可以<a href="#">查看我的购物券</a>&nbsp;&nbsp;&nbsp;<a href="'.$staticPages['index'].'">现在去购物</a>';
        }
        else
        {
        	$coupon_id = $_REQUEST['coupon_id'];
        	$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('coupons')." WHERE coupon_id='$coupon_id'";
        	$coupon = $GLOBALS['db']->getRow($sql);


        	$sql = "INSERT INTO ".$GLOBALS['ecs']->table('coupons_sent')." (is_used,user_id,user_got_time,coupon_id,coupon_value,restriction_type,restriction_ext,validate_time,coupon_name,coupon_description) VALUES(0,'".$_SESSION['user_id']."','".gmtime()."', '$coupon_id', '".$coupon['coupon_value']."','".$coupon['restriction_type']."','".$coupon['restriction_ext']."','".$coupon['validate_time']."','".$coupon['coupon_name']."','".$coupon['coupon_description']."')";

          if($GLOBALS['db']->query($sql))
          {
          	$sql = "UPDATE ".$GLOBALS['ecs']->table('coupons')." SET today_sent = today_sent + 1 WHERE coupon_id = '$coupon_id'";
          	$GLOBALS['db']->query($sql);


          	$result['error'] = 0;
          	$result['coupon_id'] = $coupon_id;

 			$result['info'] = '您已经成功领取。';
 			$result['action'] = ' 您还可以<a href="#">查看我的购物券</a>&nbsp;&nbsp;&nbsp;<a href="'.$staticPages['index'].'">现在去购物</a>';
          }
          else
          {
          	$result['error'] = 1;
 			$result['info'] = '未知错误。';
 			$result['action'] = ' 您可以尝试再次领取，或者联系客服!';
          }
     
        }
        die(json_encode($result));
	}
	elseif('userCenterGotoPage' == $act)
	{
		require_once('includes/cls_coupon.php');
		require_once('includes/lib_clips.php');

		$type = trim($_REQUEST['type']);
		$page = intval(trim($_REQUEST['page']));

		
  		$couponCon = coupon::getCouponsConditions($type);

  		$coupons = get_coupons_list($_SESSION['user_id'], $type, $couponCon, $page);

  		$result = array('location'=>'coupons', 'type'=>$type, 'coupons'=>$coupons);
  		die(json_encode($result));
	}
	
	function get_coupons_sql()
	{
 		$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('coupons')." WHERE is_display = 1 ORDER BY coupon_id DESC LIMIT 9";
 		return $sql;
	}

	function get_coupons()
	{
		$sql = get_coupons_sql();
		$coupons = $GLOBALS['db']->getAll($sql);

		foreach ($coupons as $key => $value) {

			$coupons[$key]['validate_time'] = local_date("Y年m月d日", $value['validate_time']);
			$coupons[$key]['coupon_display_value'] = intval($value['coupon_value']);
			$coupons[$key]['today_left'] = intval($value['daily_total']) - intval($value['today_sent']);
		}
		return $coupons;
	}
    

	function update_coupon_today_sent_num()
	{
		$sql = get_coupons_sql();
		$coupons = $GLOBALS['db']->getAll($sql);
		$dawn_time = get_beginning_day_time(gmtime());


		foreach ($coupons as $key => $value)
		{
			$coupon_id = $value['coupon_id'];
			$sql = "SELECT COUNT(sent_coupon_id) FROM ".$GLOBALS['ecs']->table('coupons_sent')." WHERE coupon_id='$coupon_id' AND user_got_time>='$dawn_time'";
		
			$coupon_today_sent_num = $GLOBALS['db']->getOne($sql);

			$sql = "UPDATE ".$GLOBALS['ecs']->table('coupons')." SET today_sent='$coupon_today_sent_num' WHERE coupon_id='$coupon_id'";
			$GLOBALS['db']->query($sql);
		}
	}

	function is_restricted_gain_coupon($user_id)
	{
		if(is_day_restricted($user_id))
		{
			return false;
		}
		if(is_month_restricted($user_id))
		{
			return false;
		}
		return true;
	}
    
    function is_restricted_coupon_num($coupon_id)
    {
    	$sql = "SELECT daily_total,today_sent FROM ".$GLOBALS['ecs']->table('coupons')." WHERE coupon_id='$coupon_id'";
    	$row = $GLOBALS['db']->getRow($sql);
    	if(intval($row['daily_total']) > intval($row['today_sent']))
    		return false;
    	return true;
    }

    function is_day_restricted($user_id)
    {
    	$dawn_time = get_beginning_day_time(gmtime());

    	$sql = "SELECT user_got_time FROM ".$GLOBALS['ecs']->table('coupons_sent')." WHERE  user_id = '$user_id' ORDER BY user_got_time DESC";
    	$user_got_time = $GLOBALS['db']->getOne($sql);

    	if(!empty($user_got_time) && $user_got_time >= $dawn_time)
    	{
    		return false;
    	}
    	return true;
    }
    function is_month_restricted($user_id)
    {
    	$month_began_time = get_beginning_month_time(gmtime());

    	$sql = "SELECT COUNT(sent_coupon_id) FROM ".$GLOBALS['ecs']->table('coupons_sent')." WHERE user_id = '$user_id' AND user_got_time >= '$month_began_time'";
    	$count = $GLOBALS['db']->getOne($sql);

    	if(MONTH_GAIN_COUPONS_NUM < $count)
    		return true;
    	else
    		return false;
    }

	function get_beginning_month_time($time)
	{
		$date = local_date("Y-m-01 00:00:00",$time);
	    $time = local_strtotime($date);
	    return $time;
	}
	function get_beginning_day_time($time)
	{
		$date = local_date("Y-m-d 00:00:00",$time);
	    $time = local_strtotime($date);
	    return $time;
	}
?>