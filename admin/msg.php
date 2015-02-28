<?php

/**
 * ECSHOP 客户留言
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user_msg.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
/* 权限判断 */
admin_priv('fankui_priv');
/*初始化数据交换对象 */
$exc = new exchange($ecs->table("fankui"), $db, 'msg_id', 'msg_title');


/*------------------------------------------------------ */
//-- 列出所有留言
/*------------------------------------------------------ */
if ($_REQUEST['act']=='list_all')
{
    assign_query_info();
    $msg_list = msg_list1();

    $smarty->assign('msg_list',     $msg_list['msg_list']);
    $smarty->assign('filter',       $msg_list['filter']);
    $smarty->assign('record_count', $msg_list['record_count']);
    $smarty->assign('page_count',   $msg_list['page_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('sort_msg_id', '<img src="images/sort_desc.gif">');

    $smarty->assign('ur_here',      $_LANG['msg']);
    $smarty->assign('full_page',    1);
    $smarty->display('msg.htm');
}

/*------------------------------------------------------ */
//-- ajax 删除留言
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    $msg_id = intval($_REQUEST['id']);

    /* 检查权限 */
   // check_authz_json('fankui_priv');

    $msg_title = $exc->get_name($msg_id);
    if ($exc->drop($msg_id))
    {
       
        $sql = "DELETE FROM " . $ecs->table('fankui') . " WHERE msg_id = '$msg_id' LIMIT 1";
        $db->query($sql, 'SILENT');

        admin_log(addslashes($msg_title), 'remove', 'message');
        $url = 'msg.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
        ecs_header("Location: $url\n");
        exit;
    }
    else
    {
        make_json_error($GLOBALS['db']->error());
    }
}



/**
 *
 *
 * @access  public
 * @param
 *
 * @return void
 */
function msg_list1()
{
   
    $sql = "SELECT count(*) FROM " .$GLOBALS['ecs']->table('fankui') ;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = "SELECT msg_id, msg_content,msg_time, COUNT(msg_id) AS reply " .
            "FROM " . $GLOBALS['ecs']->table('fankui').
            "GROUP BY msg_id ".
            "ORDER by msg_id DESC ".
            "LIMIT " . $filter['start'] . ', ' . $filter['page_size'];

    $msg_list = $GLOBALS['db']->getAll($sql);
    foreach ($msg_list AS $key => $value)
    {   if($value['order_id'] > 0)
        {
            $msg_list[$key]['order_sn'] = $GLOBALS['db']->getOne("SELECT order_sn FROM " . $GLOBALS['ecs']->table('order_info') ." WHERE order_id= " .$value['order_id']);
        }
        $msg_list[$key]['msg_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['msg_time']);
    }
    $filter['keywords'] = stripslashes($filter['keywords']);
    $arr = array('msg_list' => $msg_list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 获得留言的详细信息
 *
 * @param   integer $id
 *
 * @return  array
 */
function get_fankui_detail($id)
{
    global $ecs, $db, $_CFG;

    $sql = "SELECT T1.*, T2.msg_id AS reply_id, T2.user_name  AS reply_name, u.email AS reply_email, ".
                "T2.msg_content AS reply_content , T2.msg_time AS reply_time, T2.user_name AS reply_name ".
            "FROM ".$ecs->table('fankui'). " AS T1 ".
            "LEFT JOIN " .$ecs->table('admin_user'). " AS u ON u.user_id='" .$_SESSION['admin_id']. "' ".
            "LEFT JOIN ".$ecs->table('fankui'). " AS T2 ON T2.parent_id=T1.msg_id ".
            "WHERE T1.msg_id = '$id'";
    $msg = $db->GetRow($sql);

    if ($msg)
    {
        $msg['msg_time']   = local_date($_CFG['time_format'], $msg['msg_time']);
        $msg['reply_time'] = local_date($_CFG['time_format'], $msg['reply_time']);
    }

    return $msg;
}

?>