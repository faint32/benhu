<?php

/**
 * ECSHOP 管理中心积分兑换商品程序文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author $
 * $Id $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(dirname(__FILE__) . '/includes/cls_vip_goods.php');
require_once(dirname(__FILE__) . '/includes/lib_goods.php');
/*初始化数据交换对象 */
$exc   = new vip_goods($ecs->table("vip_goods"), $db, 'goods_id', '');
//$image = new cls_image();

/*------------------------------------------------------ */
//-- 商品列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 权限判断 */
    admin_priv('vip_goods');

    /* 取得过滤条件 */
    $filter = array();
    $smarty->assign('ur_here',      $_LANG['16_vip_goods']);
    $smarty->assign('action_link',  array('text' => $_LANG['vip_goods_add'], 'href' => 'vip_goods.php?act=add'));
    $smarty->assign('full_page',    1);
    $smarty->assign('filter',       $filter);
    update_vip_goods(); //如果下期预告的时间已经到了，将其更新为精品上新。
    $goods_list = get_vip_goodslist();
  //var_dump($goods_list);
    $smarty->assign('goods_list',    $goods_list['arr']);
    $smarty->assign('filter',        $goods_list['filter']);
    $smarty->assign('record_count',  $goods_list['record_count']);
    $smarty->assign('page_count',    $goods_list['page_count']);
   
    $sort_flag  = sort_flag($goods_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('vip_goods_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('vip_goods');

    $goods_list = get_vip_goodslist();

    $smarty->assign('goods_list',    $goods_list['arr']);
    $smarty->assign('filter',        $goods_list['filter']);
    $smarty->assign('record_count',  $goods_list['record_count']);
    $smarty->assign('page_count',    $goods_list['page_count']);

    $sort_flag  = sort_flag($goods_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('vip_goods_list.htm'), '',
        array('filter' => $goods_list['filter'], 'page_count' => $goods_list['page_count']));
}

/*------------------------------------------------------ */
//-- 添加商品
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /* 权限判断 */
    admin_priv('vip_goods');

    /*初始化*/
    $goods = array();
    $goods['is_exchange'] = 1;
    $goods['is_hot']      = 0;
    $goods['option']      = '<option value="0">'.$_LANG['make_option'].'</option>';

    $smarty->assign('goods',       $goods);
    $smarty->assign('ur_here',     $_LANG['vip_goods_add']);
    $smarty->assign('action_link', array('text' => $_LANG['16_vip_goods'], 'href' => 'vip_goods.php?act=list'));
    $smarty->assign('form_action', 'insert');
    $smarty->assign('user_rank_list', get_user_rank_list());
    assign_query_info();
    $smarty->display('vip_goods_info.htm');
}

/*------------------------------------------------------ */
//-- 添加商品
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* 权限判断 */
    admin_priv('vip_goods');

    /*检查是否重复*/
    $is_only = $exc->is_only('goods_id', $_POST['goods_id'],0, " goods_id ='$_POST[goods_id]'");

    if (!$is_only)
    {
        sys_msg('商品已经存在', 1);
    }

    /*插入数据*/
    $add_time = gmtime();
    if (empty($_POST['goods_id']))
    {
        $_POST['goods_id'] = 0;
    }
	if(isset($_POST['start_time']) && $_POST['start_time']!= '' )
	{
	$bg_time = local_strtotime($_POST['start_time']);
	}
	else
	{
	$bg_time = 0;
	}
    $sql = "INSERT INTO ".$ecs->table('vip_goods')."(goods_id,  is_exchange,is_integral_buy, is_vip_only,is_next,begin_time,bought_number) ".
            "VALUES ('$_POST[goods_id]',  '$_POST[is_exchange]','$_POST[is_integral_buy]', '$_POST[is_vip_only]', '$_POST[is_next]', '$bg_time',0)";
			
    $db->query($sql);

	  handle_vip_member_price($_POST[goods_id], $_POST['user_rank'], $_POST['user_price'], $_POST['user_integral']);
	
	
    $link[0]['text'] = '继续添加VIP商品';
    $link[0]['href'] = 'vip_goods.php?act=add';

    $link[1]['text'] = '返回VIP商品列表';
    $link[1]['href'] = 'vip_goods.php?act=list';

    admin_log($_POST['goods_id'],'add','vip_goods');

    clear_cache_files(); // 清除相关的缓存文件

    sys_msg('VIP商品添加成功',0, $link);
}

/*------------------------------------------------------ */
//-- 编辑
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    /* 权限判断 */
    admin_priv('vip_goods');

    /* 取商品数据  修改了SQL语句 chen 0901 */
    $sql = "SELECT eg.goods_id,eg.is_exchange,eg.is_next,eg.begin_time,eg.is_integral_buy,eg.is_vip_only, g.goods_name ".
           " FROM " . $ecs->table('vip_goods') . " AS eg ".
           "  LEFT JOIN " . $ecs->table('goods') . " AS g ON g.goods_id = eg.goods_id ".
           " WHERE eg.goods_id='$_REQUEST[id]'";
    $goods = $db->GetRow($sql);

    $goods['option']  = '<option value="'.$goods['goods_id'].'">'.$goods['goods_name'].'</option>';
    $goods['begin_time'] = local_date("Y-m-d H:i:s",$goods['begin_time']);
	
	$user_rank_list = get_user_rank_list();
	$sql = "select user_rank,user_price,user_integral from ".$ecs->table('vip_member_price')." where goods_id='$_REQUEST[id]'";
	$rank_price = $db->GetAll($sql);
	foreach($rank_price as  $rank_priceVal)
	{
	 // $user_rank_list[$rank_priceVal['']]
	 $rank_id = $rank_priceVal['user_rank'];
	 foreach($user_rank_list as $user_rank_listKey => $user_rank_listVal)
	 {
	    if($user_rank_listVal['rank_id'] == $rank_id)
		{
		  $user_rank_list[$user_rank_listKey]['user_price'] = $rank_priceVal['user_price'];
		  $user_rank_list[$user_rank_listKey]['user_integral'] = $rank_priceVal['user_integral'];
		  break;
		}
	 }
	}
	
    $smarty->assign('goods',       $goods);
    $smarty->assign('ur_here',     $_LANG['vip_goods_add']);
    $smarty->assign('action_link', array('text' => $_LANG['16_vip_goods'], 'href' => 'vip_goods.php?act=list&' . list_link_postfix()));
    $smarty->assign('form_action', 'update');
	
	
    $smarty->assign('user_rank_list', $user_rank_list );
	
    assign_query_info();
    $smarty->display('vip_goods_info.htm');
}

/*------------------------------------------------------ */
//-- 编辑
/*------------------------------------------------------ */
if ($_REQUEST['act'] =='update')
{
     /* 权限判断 */
    admin_priv('vip_goods');

    if (empty($_POST['goods_id']))
    {
        $_POST['goods_id'] = 0;
    }
    $bg_time=local_strtotime($_POST['start_time']);
    if ($exc->edit("is_exchange='$_POST[is_exchange]',is_integral_buy='$_POST[is_integral_buy]',is_vip_only='$_POST[is_vip_only]', is_next='$_POST[is_next]',begin_time='$bg_time' ", $_POST['goods_id']))
    {
	 handle_vip_member_price($_POST[goods_id], $_POST['user_rank'], $_POST['user_price'], $_POST['user_integral']);
        $link[0]['text'] = '返回VIP商品列表';
        $link[0]['href'] = 'vip_goods.php?act=list&' . list_link_postfix();

        admin_log($_POST['goods_id'], 'edit', 'vip_goods');

        clear_cache_files();
        sys_msg('修改成功', 0, $link);
    }
    else
    {
        die($db->error());
    }
}

/*------------------------------------------------------ */
//-- 编辑使用积分值
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_exchange_integral')
{
    check_authz_json('vip_goods');

    $id                = intval($_POST['id']);
    $exchange_integral = floatval($_POST['val']);

    /* 检查文章标题是否重复 */
    if ($exchange_integral < 0 || $exchange_integral == 0 && $_POST['val'] != "$goods_price")
    {
        make_json_error($_LANG['exchange_integral_invalid']);
    }
    else
    {
        if ($exc->edit("exchange_integral = '$exchange_integral'", $id))
        {
            clear_cache_files();
            admin_log($id, 'edit', 'vip_goods');
            make_json_result(stripslashes($exchange_integral));
        }
        else
        {
            make_json_error($db->error());
        }
    }
}
/*------------------------------------------------------ */
//-- 编辑还需多少钱 chen 0901
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_needed_money')
{
    check_authz_json('vip_goods');

    $id                = intval($_POST['id']);
    $needed_money = floatval($_POST['val']);

    /* 检查文章标题是否重复 */
    if ($needed_money < 0 || $needed_money == 0 && $_POST['val'] != "$goods_price")
    {
        make_json_error($_LANG['exchange_integral_invalid']);
    }
    else
    {
        if ($exc->edit("needed_money = '$needed_money'", $id))
        {
            clear_cache_files();
            admin_log($id, 'edit', 'vip_goods');
            make_json_result(stripslashes($needed_money));
        }
        else
        {
            make_json_error($db->error());
        }
    }
}
/*------------------------------------------------------ */
//-- 切换是否兑换
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_exchange')
{
    check_authz_json('vip_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_exchange = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}

/*------------------------------------------------------ */
//-- 切换是否兑换
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_vip_only')
{
    check_authz_json('vip_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_vip_only = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}
/*------------------------------------------------------ */
//--ajax处理是否为new chen 0901
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_integral_buy')
{
    check_authz_json('vip_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_integral_buy = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}
/*------------------------------------------------------ */
//--ajax处理是否为best chen 0901
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_best')
{
    check_authz_json('vip_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_best = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}
/*------------------------------------------------------ */
//--ajax处理是否为best chen 0901
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_next')
{
    check_authz_json('vip_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_next = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}
/*------------------------------------------------------ */
//-- 批量删除商品
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_remove')
{
    admin_priv('vip_goods');

    if (!isset($_POST['checkboxes']) || !is_array($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_select_goods'], 1);
    }

    $count = 0;
    foreach ($_POST['checkboxes'] AS $key => $id)
    {
        if ($exc->drop($id))
        {
            admin_log($id,'remove','vip_goods');
            $count++;
        }
    }

    $lnk[] = array('text' => $_LANG['back_list'], 'href' => 'vip_goods.php?act=list');
    sys_msg(sprintf($_LANG['batch_remove_succeed'], $count), 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除商品
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('vip_goods');

    $id = intval($_GET['id']);
    if ($exc->drop($id))
    {
        admin_log($id,'remove','article');
		$sql = "delete from ".$GLOBALS['ecs']->table('vip_member_price')." where goods_id='$id'";
		$GLOBALS['db']->query($sql);
        clear_cache_files();
    }

    $url = 'vip_goods.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 搜索商品
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    $filters = $json->decode($_GET['JSON']);

    $arr = get_goods_list($filters);

    make_json_result($arr);
}

/* 获得商品列表 */
function get_vip_goodslist()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'vp.goods_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = '';
        if (!empty($filter['keyword']))
        {
            $where = " AND g.goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }

        /* 文章总数 */
        $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('vip_goods'). ' AS vp '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('goods'). ' AS g ON g.goods_id = vp.goods_id '.
               'WHERE 1 ' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 获取文章数据 */
        $sql = 'SELECT vp.* , g.goods_name '.
               'FROM ' .$GLOBALS['ecs']->table('vip_goods'). ' AS vp '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('goods'). ' AS g ON g.goods_id = vp.goods_id '.
               'WHERE 1 ' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}
/*如果下期预告的时间已经到了，将其更新*/
function update_vip_goods()
{
$now = gmtime();
$sql = "update ".$GLOBALS['ecs']->table('vip_goods')." set is_next=0 where begin_time < $now and is_next=1";
if(!$GLOBALS['db']->query($sql))
{
  echo '更新下期预告出错';
  die;
}
}
?>