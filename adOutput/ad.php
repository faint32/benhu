<?php

define('IN_ECS', true);
define('WEB_ROOT', 'D:/wamp/www/benhushop1231');
require(WEB_ROOT . '/includes/init.php');
require(WEB_ROOT . '/adOutput/includes/lib_ad.php');

   $smarty = new cls_template;
   set_smarty_parse_dir($smarty);

	
   $act = trim($_REQUEST['act']);
   $location = trim($_REQUEST['location']);
	 
	switch ($act) 
	{
		case 'popUp':
			$GOODS_NUM = 2; 
			$GOOD_NAME_LENGTH_LIMIT = 6;
			$content = getRandomGoods($GOODS_NUM, $GOOD_NAME_LENGTH_LIMIT);
			$goodsJsCode = convertToJsCode($content);
			
			die($goodsJsCode);
			break;
		case 'aiyu':
           	$content = getAiyuContent($location);
            $smarty->assign('goods_list', $content);
            $smarty->display('aiyu_list.dwt');
           	break;
        case 'jiankang':
        	$content = getJiankangContent($location);
        	$smarty->assign('goods_list', $content);

            $smarty->display('jiankang_list.dwt');
           	break;
        case 'tu6':
        	$content = getTu6Content($location);

        	$smarty->assign('act',$act);
        	$smarty->assign('location',$location);
        	$smarty->assign('goods_list', $content);
            $smarty->display('aiyu_list.dwt');
        	break;
        case 'v8090so':
       		$content = getV8090s0($location);
        	$smarty->assign('goods_list', $content);
            $smarty->display('v8090so.dwt');
        	break;
		default:
			$content = "empty";
			break;
	}
    die;

	function convertToJsCode($content)
	{
		$jsCode = "var goods= [";
		for ($i=0; $i < count($content); $i++) { 
			$jsCode .= "{goods_img:'".$content[$i]['goods_img']."',url:'".$content[$i]['url']."',goods_name:'".$content[$i]['goods_name']."'}";
			if( (count($content) - 1) != $i )
			{
				$jsCode .= ',';
			}
		}
		$jsCode .= "]";

		return $jsCode;
	}
	function getAiyuContent($location)
	{
		switch($location)
		{
			 case 'index':
               case 'defaultListTemplatePage':
               	$content = getRandomGoods(4);
                break;
               default:
               	break;
		}
		return $content;
	}

	function getJiankangContent($location)
	{
		switch($location)
		{
             case 'list':
               	$content = getRandomGoods(3);
                break;
               default:
               	break;
		}
		return $content;
	}

	function getTu6Content($location)
	{
		switch($location)
		{
             case 'list':
               	$content = getRandomGoods(3);
                break;
               default:
               	break;
		}
		return $content;
	}

   function getV8090s0($location)
   {
   		switch($location)
		{
             case 'index':
               	$content = getRandomGoods(20);
               	foreach ($content as $key => $value) {
               		$content[$key]['left'] = $key * 200;
               	}
                break;
               default:
               	break;
		}
		return $content;
   }

	function getRandomGoods($GOODS_NUM, $GOOD_NAME_LENGTH_LIMIT = 25)
	{
		$sql = "SELECT goods_id, goods_name, goods_thumb, original_img, goods_img FROM ".$GLOBALS['ecs']->table('goods')." ORDER BY RAND()  LIMIT $GOODS_NUM";
		
		$goods = $GLOBALS['db']->getAll($sql);

		foreach ($goods as $key => $row) {
			$goods[$key]['url'] = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']); 
			if(strlen($goods[$key]['goods_name']) > $GOOD_NAME_LENGTH_LIMIT)
			{
					$goods[$key]['goods_name'] = utf8Substr($goods[$key]['goods_name'], 0, $GOOD_NAME_LENGTH_LIMIT)."...";
			}
		
		}
		return $goods;
	}


	function utf8Substr($str, $from, $len)
	{
	    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
	                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
	                       '$1',$str);
	}

?>