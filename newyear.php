<?php
	define('IN_ECS', true);
	define('LIMIT_NUM',8);
	
	require(dirname(__FILE__) . '/includes/init.php');
	require_once(ROOT_PATH  . '/includes/lib_common.php');
	require_once(ROOT_PATH  . '/includes/cls_template.php');
	
	
	if ((DEBUG_MODE & 2) != 2)
	{
		//$smarty->caching = true;
	}
	
	$cache_id = sprintf('%X', crc32('newyear'. '-' . $_CFG['lang']));
	
	if (!$smarty->is_cached('newyear.dwt', $cache_id))
	{
		$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('favourable_activity')." where act_name like '周年庆%' ORDER BY sort_order DESC LIMIT 2";

		$newyearActivty = $GLOBALS['db']->getAll($sql);
	   
		foreach($newyearActivty as $key => $val)
		{
		   $goods = getGoods( array('firterType' => $val['act_range'], 'firterVal' => $val['act_range_ext'] ) );
		   setSomeGoodsValue($goods ,array('discountType' => $val['act_type'], 'discountVal' => $val['act_type_ext']));
		   $newyearActivty[$key]['goods'] = $goods;

		}
		 assign_template();
		    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
	    $smarty->assign('categories',         get_categories_tree(0));  // 分类树
      
		$smarty->assign('newyearActivty',$newyearActivty);
	}
	$smarty->display('newyear.dwt', $cache_id);
	
	
	function setSomeGoodsValue(&$goods,$dsct)
	{
	    $dsct['discountVal'] = floatval($dsct['discountVal']);
		if($dsct['discountType'] == 2)
		{
		   if( $dsct['discountVal'] > 100 || $dsct['discountVal'] < 0)
		   {
		      $dsct['discountVal'] = 100;
		   }
		}
		
	    foreach($goods as $k => $v)
		{
		   $goods[$k]['url'] = build_uri('goods', array('gid' => $goods[$k]['goods_id']), $goods[$k]['goods_name']); 
			switch($dsct['discountType'])
			{
				  case 1://现金减免
				     $goods[$k]['discountPrice'] = ($goods[$k]['market_price'] - $dsct['discountVal']) > 0 ? ($goods[$k]['market_price'] - $dsct['discountVal']) : 0;
					break;
				  case 2://打折
				    $goods[$k]['discountPrice'] =  $goods[$k]['market_price'] * $dsct['discountVal'] / 100.0;
					break;
			}
			$goods[$k]['shop_price'] = price_format($goods[$k]['shop_price']);
			$goods[$k]['market_price'] = price_format($goods[$k]['market_price']);
			$goods[$k]['discountPrice'] = price_format($goods[$k]['discountPrice']);
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
		   case 0:	
				$goods = getAllGoods();
				break;
		   case 1:	
				$goods = getGoodsByCategoryIds($frt['firterVal']);
				break;
		   case 2:
				$goods = getGoodsByBrandIds($frt['firterVal']);
				break;
		   case 3:
				$goods = getGoodsByGoodIds($frt['firterVal']);
				break;
		   default:
				break;
		}
		return $goods;
	}
	
	function getAllGoods()
	{
		$sql = "SELECT goods_id,goods_thumb,original_img,goods_name,shop_price,goods_number FROM ".$GLOBALS['ecs']->table('goods')." LIMIT ".LIMIT_NUM;
		$goods = $GLOBALS['db']->getAll($sql);
		return $goods;
	}
	
	function getGoodsByCategoryIds($categoryIds)
	{	
		$categorys = array();
	    foreach($categoryIds as $key => $val)
		{
			$categoryIds[$key] = array_keys(cat_list($categoryIds[$key], 0, false));
			$categorys = array_merge ($categorys,$categoryIds[$key]);
		}
			
		$sql = "SELECT goods_id,goods_thumb,original_img,goods_name,shop_price,market_price,goods_number FROM ".$GLOBALS['ecs']->table('goods')." WHERE ".db_create_in($categorys,'cat_id')." LIMIT ".LIMIT_NUM;
		$goods = $GLOBALS['db']->getAll($sql);
	
		return $goods;
	}
	
	function getGoodsByBrandIds($brandIds)
	{
		$sql = "SELECT goods_id,goods_thumb,original_img,goods_name,shop_price,market_price,goods_number FROM ".$GLOBALS['ecs']->table('goods')." WHERE ".db_create_in($brandIds,'brand_id')." LIMIT ".LIMIT_NUM;
		$goods = $GLOBALS['db']->getAll($sql);	
		return $goods;
	}
	
	function getGoodsByGoodIds($goodIds)
	{
		$sql = "SELECT goods_id,goods_thumb,original_img,goods_name,shop_price,market_price,goods_number FROM ".$GLOBALS['ecs']->table('goods')." WHERE ".db_create_in($goodIds,'goods_id')." LIMIT ".LIMIT_NUM;
		$goods = $GLOBALS['db']->getAll($sql);
		return $goods;	
	}
?>