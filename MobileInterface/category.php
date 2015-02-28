<?php

define('IN_ECS', true);
define('WEB_ROOT', 'D:/wamp/www/benhushop1231');
define('NEW_UESER_RANKNAME', 'VIP0');

require(WEB_ROOT . '/includes/init.php');
require(WEB_ROOT.'/MobileInterface/lib/lib_category.php');
$act = trim(compile_str($_REQUEST['act']));
$cateId = intval(trim(compile_str($_REQUEST['cateId'])));
switch($act)
{
  case 'categoryList':  
     $categoryList = getCategoryList($cateId);
    die(urldecode(json_encode($categoryList)));
    break;
  case 'test':
     $categoryList = getCategoryList($cateId);
     echo "<pre>";
     print_r($categoryList);
     echo "</pre>";
    
     die();
   // die(urldecode(json_encode($categoryList)));
    break;
  default:
    die(urldecode('参数不对'));
    break;
}

function getCategoryList($parent_id = 0)
{
   $sql = "SELECT cat_id,cat_name FROM ".$GLOBALS['ecs']->table('category')." WHERE parent_id='$parent_id' AND is_show=1 ORDER BY sort_order ASC";
   $categorys = $GLOBALS['db']->getAll($sql);

   if(!empty($categorys))
   {
     foreach ($categorys as $key => $category) {
       if(!isEndCategory($category['cat_id'])) ;   
       $categorys[$key]['childrenCategory'] = getCategoryList($category['cat_id']);
     } 
   }
   return $categorys;
}


?>