<?php
	define('IN_ECS', true);
	define('LIMIT_NUM',8);
	
	require(dirname(__FILE__) . '/includes/init.php');
	require_once(ROOT_PATH  . '/includes/lib_common.php');
	require_once(ROOT_PATH  . '/includes/cls_template.php');
	
	if ((DEBUG_MODE & 2) != 2)
	{
	//	$smarty->caching = true;
	}
	
	$cache_id = sprintf('%X', crc32('shangou'. '-' . $_CFG['lang']));
	
	if (!$smarty->is_cached('shangou.dwt', $cache_id))
	{
		$shangouActivty =  getShangouActivty();
	   
		foreach($shangouActivty as $key => $val)
		{
		   $goods = getGoods( array('firterType' => $val['act_range'], 'firterVal' => $val['act_range_ext'] ) );	 
			setSomeGoodsValue($goods ,array('discountType' => $val['act_type'], 'discountVal' => $val['act_type_ext']), $shangouActivty[$key]);
		    setActivtyDate($shangouActivty[$key]);
		   $shangouActivty[$key]['goods'] = $goods;

		}
		$smarty->assign('shangouActivty',$shangouActivty);
		assign_template();
		$smarty->assign('categories',      get_categories_tree_pro()); // 分类树
		$smarty->assign('helps',           get_shop_help());       // 网店帮助
		
	}
	$smarty->display('shangou.dwt', $cache_id);
	
	function getShangouActivty()
	{
		$yesterdayTwentyTwoClock = getSpecificTime(-2);
		$todayTwentyTwoClock = getSpecificTime(22);
	    if(isTodayHasShangouActivty())
		{
		    $sql = "SELECT * FROM ".$GLOBALS['ecs']->table('favourable_activity')." where act_name like '闪购%' AND start_time > '$yesterdayTwentyTwoClock' AND end_time < '$todayTwentyTwoClock' ORDER BY start_time ASC LIMIT 3";
			$activitys = $GLOBALS['db']->getAll($sql);  
		}
		else
		{
			$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('favourable_activity')." where act_name like '闪购%' AND end_time > '$todayTwentyTwoClock' ORDER BY start_time ASC LIMIT 3";
			$activitys = $GLOBALS['db']->getAll($sql);  
		}
	  return $activitys;
	}
	
	function isTodayHasShangouActivty()
	{
	    $yesterdayTwentyTwoClock = getSpecificTime(-2);
		$todayTwentyTwoClock = getSpecificTime(22);
		$sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('favourable_activity')." where act_name like '闪购%' AND start_time > '$yesterdayTwentyTwoClock' AND end_time < '$todayTwentyTwoClock' ORDER BY start_time ASC LIMIT 3";
	    $todayCount = $GLOBALS['db']->getOne($sql);
		if(!empty($todayCount))
		  return true;
		return false;
	}
	
	function setActivtyDate(&$activity)
	{
	   $activity['startDate'] = local_date('H:i', $activity['start_time']);
	   $activity['endDate'] = local_date('H:i', $activity['end_time']);
	}
		
	function setSomeGoodsValue(&$goods,$dsct,$shangouActivty)
	{
	    $dsct['discountVal'] = convertStringToIntegerArr($dsct['discountVal']);
	    foreach($goods as $k => $v)
		{
		   $goods[$k]['url'] = build_uri('goods', array('gid' => $goods[$k]['goods_id']), $goods[$k]['goods_name']); 
			switch($dsct['discountType'])
			{
				  case 1://现金减免
				     $goods[$k]['discountPrice'] = ($goods[$k]['market_price'] - $dsct['discountVal'][$k]) > 0 ? ($goods[$k]['market_price'] - $dsct['discountVal'][$k]) : 0;
					break;
				  case 2://打折
				    $goods[$k]['discountPrice'] =  $goods[$k]['market_price'] * floatval($dsct['discountVal'][$k]) / 100.0;
					break;
			}
			$goods[$k]['market_price'] = price_format($goods[$k]['market_price']);
			$goods[$k]['shop_price'] = price_format($goods[$k]['shop_price']);
			$goods[$k]['discountPrice'] = price_format($goods[$k]['discountPrice']);
			$goods[$k]['discount'] = intval($dsct['discountVal'][$k] / 10);
			$goods[$k]['begin_date'] = local_date("m月d日　H : i",$shangouActivty['start_time']);
			$goods[$k]['start_time'] = $shangouActivty['start_time'];
			$goods[$k]['end_time'] = $shangouActivty['end_time'];
		}
	}
	
	function convertStringToIntegerArr($str)
	{
		$str =  explode(',' , $str);
		foreach($str as $key => $val)
		{
		   $str[$key] = intval($val);
		}
		return $str;
	}
		
	function getGoods($frt)
	{
		$frt['firterVal'] =  convertStringToIntegerArr($frt['firterVal']);  
		$goods = array();
		switch($frt['firterType'])
		{
		 
		   case 3:
				$goods = getGoodsByGoodIds($frt['firterVal']);
				break;
		   default:
				break;
		}
		return $goods;
	}
	
	function getGoodsByGoodIds($goodIds)
	{
		$sql = "SELECT goods_id, goods_thumb, original_img, goods_name, shop_price, market_price, goods_number FROM ".$GLOBALS['ecs']->table('goods')." WHERE ".db_create_in($goodIds,'goods_id')." LIMIT ".LIMIT_NUM;
		$goods = $GLOBALS['db']->getAll($sql);
		return $goods;	
	}
?>