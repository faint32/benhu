<?php
/**
 * ECSHOP 会员中心
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'show';
if ($action == 'show'){
    $smarty->assign('helps',           get_shop_help());       // 网店帮助
    $smarty->display('msg.dwt');
}
/* 添加反馈 */
if ($action == 'add_message')
{
  
    $msg_content = isset($_POST['msg_content']) ? trim($_POST['msg_content']) : '';
    $time = gmtime();
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('fankui'). " (msg_content, msg_time)" .
                    "VALUES ( '$msg_content', '$time')";
   
    if ($GLOBALS['db']->query($sql))
    {
        show_message('提交成功！','返回首页', './index.php');
    }
    else
    {
        $err->show('提交失败！');
    }
}
/* 清除商品浏览历史 */
elseif ($action == 'clear_history')
{
    setcookie('ECS[history]',   '', 1);
}
?>