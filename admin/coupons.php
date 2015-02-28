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

if ($_REQUEST['act'] == 'list')
{
    $coupons = get_coupons_list();
     // var_dump($coupons['filter']);
    $smarty->assign('coupons',  $coupons['coupons']);
    $smarty->assign('filter',       $coupons['filter']);
    $smarty->assign('record_count', $coupons['record_count']);
    $smarty->assign('page_count',   $coupons['page_count']);
    $smarty->assign('full_page',   1);
    assign_query_info();

     /* 排序标记 */
    $sort_flag  = sort_flag_bootstrap($coupons['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    
    /*分页html代码*/
    $smarty->assign('pagination',bootstrap_pagination($coupons['filter']));

    $smarty->display('coupons_list.htm');
}

if ($_REQUEST['act'] == 'add')//添加和修改用的同一个
{  
    assign_query_info();
    $featureName = "添加购物券";
    if(!empty($_REQUEST['id']))
    {
      $coupon_id = intval(trim($_REQUEST['id']));
      $row = $GLOBALS['db']->getRow('SELECT * FROM '.$GLOBALS['ecs']->table('coupons')." WHERE coupon_id='$coupon_id'");

      $row['start_time'] = local_date("Y-m-d H:i:s",$row['start_time']);
      $row['end_time'] = local_date("Y-m-d H:i:s",$row['end_time']);
      $row['validate_time'] = local_date("Y-m-d H:i:s",$row['validate_time']);
      $smarty->assign('coupon',$row);
      $featureName = "修改购物券";
      unset($_REQUEST['id']);
    }
    $smarty->assign('featureName', $featureName);
    $smarty->display('coupons_add.htm');
}
elseif ($_REQUEST['act'] == 'view')//添加和修改用的同一个
{
  $coupon_id = $_REQUEST['id'];
  if(empty($coupon_id))
  {
    die('传人的购物券id为空');
  }
  
  $usrGotCoupons =  get_usrGotCoupons_list($coupon_id);
  
  assign_query_info();
  $smarty->assign('coupons',  $usrGotCoupons['coupons']);
  $smarty->assign('filter',       $usrGotCoupons['filter']);
  $smarty->assign('record_count', $usrGotCoupons['record_count']);
  $smarty->assign('page_count',   $usrGotCoupons['page_count']);
  $smarty->assign('full_page',   1);
  

   /* 排序标记 */
  $sort_flag  = sort_flag_bootstrap($usrGotCoupons['filter']);
  $smarty->assign($sort_flag['tag'], $sort_flag['img']);

  /*分页html代码*/
  $smarty->assign('pagination',bootstrap_pagination($usrGotCoupons['filter']));
  $smarty->display('coupons_view.htm');
}
elseif ($_REQUEST['act'] == 'add_coupon')//添加和修改用的同一个
{
    foreach ($_REQUEST as $key => $value) {
        $_REQUEST[$key] = trim($_REQUEST[$key]);
    }

    $will_insert = true;
    if(exists_coupon($_REQUEST['coupon_id']))
    {
        $will_insert = false;
    }

    $coupon_name =   $_REQUEST['coupon_name'];
    $coupon_description = $_REQUEST['coupon_description'];
    $coupon_value = floatval($_REQUEST['coupon_value']);
    $restriction_ext = $_REQUEST['restriction_ext'];
    $total_num_restriction = intval($_REQUEST['total_num_restriction']);
    $validate_time = local_strtotime($_REQUEST['validate_time']);

    $start_time = local_strtotime($_REQUEST['start_time']);
    $end_time = local_strtotime($_REQUEST['end_time']);
    $daily_total = intval($_REQUEST['daily_total']);
    $is_display = intval($_REQUEST['is_display']);
    
    if($will_insert)
    {
      $sql = "INSERT INTO ".$GLOBALS['ecs']->table('coupons')."(coupon_name,coupon_description,coupon_value,restriction_ext,total_num_restriction,daily_total,validate_time,start_time,end_time,is_display) values('$coupon_name','$coupon_description','$coupon_value','$restriction_ext','$total_num_restriction','$daily_total','$validate_time','$start_time','$end_time','$is_display' )";
    }
    else
    {
      $coupon_id = $_REQUEST['coupon_id'];
      $sql = "UPDATE ".$GLOBALS['ecs']->table('coupons')." SET coupon_name='$coupon_name',coupon_description='$coupon_description',coupon_value='$coupon_value',restriction_ext='$restriction_ext',total_num_restriction='$total_num_restriction',daily_total='$daily_total',validate_time='$validate_time',start_time='$start_time',end_time='$end_time',is_display='$is_display' WHERE coupon_id='$coupon_id'";
    }

   if($GLOBALS['db']->query($sql)) 
   {
       sys_msg('操作成功！',0,array(array('text'=>'返回购物券列表页','href'=>'coupons.php?act=list')),true);
   }
   else
   {
     sys_msg('操作失败！',0,array(array('text'=>'返回购物券列表页','href'=>'coupons.php?act=list')),true);
   }

   exit;
}
elseif ($_REQUEST['act'] == 'query')//分页代码
{
    //获取信息列表
    if(empty($_REQUEST['key_url_para']))
      $_REQUEST['key_url_para'] = 'coupons_list';

    switch ($_REQUEST['key_url_para']) {
      case 'coupons_list':
         $coupons = get_coupons_list();
        break;
      case 'coupons_view':
         $coupons = get_usrGotCoupons_list($_REQUEST['coupon_id']);
        break;
      default:
        die('非法访问！');
        break;
    } 

    $smarty->assign('coupons',  $coupons['coupons']);
    $smarty->assign('filter',       $coupons['filter']);
    $smarty->assign('record_count', $coupons['record_count']);
    $smarty->assign('page_count',   $coupons['page_count']);
   
       /* 排序标记 */
    $sort_flag  = sort_flag_bootstrap($coupons['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /*分页html代码*/
   $smarty->assign('pagination',bootstrap_pagination($coupons['filter']));

    //跳转页面
    make_json_result($smarty->fetch( $_REQUEST['key_url_para'].'.htm' ),'',array('filter' => $coupons['filter'],'page_count' => $coupons['page_count']));
}
/*修改*/
elseif(strstr($_REQUEST['act'], 'edit_'))
{
     $val = trim($_REQUEST['val']);
     $id = trim($_REQUEST['id']);

     /**对修改的值进行格式处理**/
     $field = str_replace('edit_','',$_REQUEST['act']);   
     switch($field){
        case 'coupon_value':
        case 'restriction_ext':
            $val = floatval($val);
            break;
        case 'today_sent':
        case 'daily_total':
        case 'total_num_restriction':
            $val = intval($val);
            break;
        default:
            break;
     }

     $sql = "UPDATE ".$GLOBALS['ecs']->table('coupons')." SET $field='$val' WHERE coupon_id='$id'";

     $GLOBALS['db']->query($sql);

     clear_cache_files();
     make_json_result(stripslashes($val));
}
/*展示*/
elseif($_REQUEST['act'] == 'toggle_display')
{
    $coupon_id       = intval($_POST['id']);
    $is_display        = intval($_POST['val']);

    $sql = "UPDATE ".$GLOBALS['ecs']->table('coupons')." SET is_display = '$is_display' WHERE coupon_id='$coupon_id'";
    if ($GLOBALS['db']->query($sql))
    {
        clear_cache_files();
        make_json_result($is_display);
    }
}
/*删除*/
elseif ($_REQUEST['act'] == 'remove')
{
  //默认：购物券列表页删除记录
  $coupon_id = intval($_REQUEST['id']);
  $tableName = 'coupons';
  $primaryField = 'coupon_id';
  if($_REQUEST['key_url_para'] == 'coupons_view') //用户购物券获得页删除记录
  {
    $tableName = 'coupons_sent';
    $primaryField = 'sent_coupon_id';
  }
  
    $coupon_id = intval($_REQUEST['id']);

    $sql = "DELETE FROM  ".$GLOBALS['ecs']->table($tableName)." WHERE $primaryField='$coupon_id'";

    if ($GLOBALS['db']->query($sql))
    {
        clear_cache_files();
       
       $url = 'coupons.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

        ecs_header("Location: $url\n");
        exit;
    }
}


function get_usrGotCoupons_list($coupon_id)
{
    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('coupons_sent')." WHERE coupon_id='$coupon_id'";

    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
   // $_REQUEST['page_size'] = 10;
    $filter = page_and_size($filter);
  

   $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'sent_coupon_id' : $_REQUEST['sort_by'];
   $filter['sort_order'] = ($_REQUEST['sort_order'] == 'ASC') ? 'ASC' : 'DESC';

   $filter['key_url_para'] = 'coupons_view';
   $filter['coupon_id'] = $coupon_id;
    /* 获活动数据 */
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('coupons_sent')." WHERE coupon_id='$coupon_id' ORDER BY ".$filter['sort_by']. " " .$filter['sort_order']." LIMIT ". $filter['start'] .", " . $filter['page_size'];

    $filter['keywords'] = stripslashes($filter['keywords']);
    set_filter($filter, $sql);
    $row = $GLOBALS['db']->getAll($sql);
    foreach ($row as $key => $value)
    {
        $row[$key]['used_time'] = empty($value['used_time'])? '未使用' : local_date("Y-m-d H:i:s",$value['used_time']);
        $row[$key]['user_got_time'] = local_date("Y-m-d H:i:s",$value['user_got_time']);
        $row[$key]['validate_time'] = local_date("Y-m-d H:i:s",$value['validate_time']);
        $row[$key]['is_used'] = ($value['is_used'] == '1') ? '是' : '否';
    }
    $arr = array('coupons' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    return $arr;
}

function get_coupons_list()
{
    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('coupons');

    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
   // $_REQUEST['page_size'] = 10;
    $filter = page_and_size($filter);
  

   $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'coupon_id' : $_REQUEST['sort_by'];
   $filter['sort_order'] = ($_REQUEST['sort_order'] == 'ASC') ? 'ASC' : 'DESC';
 
    /* 获活动数据 */
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('coupons')." ORDER BY ".$filter['sort_by']. " " .$filter['sort_order']." LIMIT ". $filter['start'] .", " . $filter['page_size'];

    $filter['keywords'] = stripslashes($filter['keywords']);
    set_filter($filter, $sql);
    $row = $GLOBALS['db']->getAll($sql);
    foreach ($row as $key => $value)
    {
        $row[$key]['start_time'] = local_date("Y-m-d H:i:s",$value['start_time']);
        $row[$key]['end_time'] = local_date("Y-m-d H:i:s",$value['end_time']);
        $row[$key]['validate_time'] = local_date("Y-m-d H:i:s",$value['validate_time']);
       // $row[$key]['is_display'] = ($value['is_display'] == '1') ? '是' : '否';
    }

    $arr = array('coupons' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    return $arr;
}

function exists_coupon($coupon_id)
{
    $sql = "SELECT coupon_id FROM ".$GLOBALS['ecs']->table('coupons')." WHERE coupon_id='$coupon_id' ";
    if($GLOBALS['db']->getOne($sql))
        return true;
    return false;
}

function get_coupon_id($coupon_name,$coupon_description)
{
    $sql = "SELECT coupon_id FROM ".$GLOBALS['ecs']->table('coupons')." WHERE coupon_name='$coupon_name' AND coupon_description='$coupon_description'";
    return $GLOBALS['db']->getOne($sql);
}

?>