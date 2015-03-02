<?php

/**
 * ECSHOP 管理中心帐户变动记录
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: account_log.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS',true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'includes/lib_main.php');

  if(empty($_REQUEST['act']))
  {
    $sql = "SELECT code,value FROM ".$GLOBALS['ecs']->table('shop_config')." WHERE parent_id=(SELECT id FROM ".$GLOBALS['ecs']->table('shop_config')." WHERE code='order_discount')";
    $orderDis = $GLOBALS['db']->getAll($sql);
    foreach ($orderDis as $k => $v) 
    {
        if(strpos($v['code'],'time') && !empty($v['code']))
        {
          $v['value'] = local_date("Y-m-d H:i:s",$v['value']);;
        }
       $v['value'] = empty($v['value']) ? 0 : $v['value'];  
       $smarty->assign($v['code'],$v['value']);
    }
    assign_query_info();
    $smarty->display('order_discount.htm');
  }
  elseif($_REQUEST['act'] == 'eidtOrderDis')
  {
    // echo "<pre>";
    // print_r($_REQUEST);
    // echo "</pre>";
    // exit;
    foreach ($_REQUEST as $k => $v) 
    {
      if(strpos($k,'time') && !empty($v))
        {
          $v = local_strtotime($v);
        }
        if($GLOBALS['db']->getOne("SELECT id FROM ".$GLOBALS['ecs']->table('shop_config')." WHERE code='$k'"))
        {
            $sql = "UPDATE ".$GLOBALS['ecs']->table('shop_config')." set value='$v' WHERE code='$k' AND parent_id='10'";
            $GLOBALS['db']->query($sql);
        }
    }
     sys_msg('修改成功',0, array(array('text'=>'返回上一页','href'=>'order_discount.php')) ); 
  }


?>