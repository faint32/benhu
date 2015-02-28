<?php
define('IN_ECS', true);
define ('WEB_ROOT','D:/wamp/www/benhushop1231/');
set_time_limit(0); 
  
  require_once WEB_ROOT.'includes/simple_html_dom.php';

  require_once WEB_ROOT.'/data/config.php';
  require_once WEB_ROOT.'/includes/cls_mysql.php';
  $db = new cls_mysql($db_host, $db_user, $db_pass , $db_name, EC_CHARSET,0,1);
 

/*
 $sql = "SELECT goods_id,goods_desc FROM ecs_goods WHERE goods_id = '2676' ORDER BY goods_id ASC";
    $goods = $db->getAll($sql);
    foreach ($goods as $key => $good) {

    	$html = str_get_html($good['goods_desc']);

		foreach($html->find('img') as $element)
		{
		    $element->style = null;
		    $element->align = null;
	        $element->class = null;

		}
		$str = $html;
		$str = addslashes($str);
		$sql = "UPDATE ecs_goods SET goods_desc = '$str' WHERE goods_id = ".$good['goods_id'];
		$db->query($sql);

		$html->clear(); 
		unset($html);	
    }
exit;
*/

  /*
  $str = "<img src='http://www.benhu.com/images/upload/fckautosave/201409/1410747983-2.jpg' data-cls='fdsf'>" ;	
  $str = addslashes($str);

$sql = "UPDATE ecs_goods SET goods_desc = '$str' WHERE goods_id = 1";  // .$good['goods_id'];
		$db->query($sql);

exit;
*/


    $sql = "SELECT goods_id,goods_desc FROM ecs_goods WHERE goods_id >= 2676  ORDER BY goods_id ASC";
    $goods = $db->getAll($sql);
    foreach ($goods as $key => $good) {

    	$html = str_get_html($good['goods_desc']);

		foreach($html->find('img') as $element)
		{
		    $element->style = null;
		    $element->align = null;
	        $element->class = null;

		}
		  //     echo $element->src . '<br>';

		//$str = $html->innertext ;


		$str = $html;
		$str = addslashes($str);
		$sql = "UPDATE ecs_goods SET goods_desc = '$str' WHERE goods_id = ".$good['goods_id'];
		$db->query($sql);

		$html->clear(); 
		unset($html);	
    }

?>