<?php
  function isEndCategory($cateId)
  {
    $sql = "SELECT cat_id FROM ".$GLOBALS['ecs']->table('category')." WHERE parent_id='$cateId'";
    $category = $GLOBALS['db']->getOne($sql);

    if(empty($category))
      return true;

    return false;
  }

?>