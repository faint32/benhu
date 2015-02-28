<?php


if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

function set_smarty_parse_dir(&$smarty)
{
        $smarty->cache_lifetime = $_CFG['cache_time'];
    $smarty->template_dir   = ROOT_PATH . 'adOutput/themes';
    $smarty->cache_dir      = ROOT_PATH . 'temp/caches';
    $smarty->compile_dir    = ROOT_PATH . 'temp/compiled';
    if ((DEBUG_MODE & 2) == 2)
    {
        $smarty->direct_output = true;
        $smarty->force_compile = true;
    }
    else
    {
        $smarty->direct_output = false;
        $smarty->force_compile = false;
    }
    $smarty->assign('lang', $_LANG);
    $smarty->assign('ecs_charset', EC_CHARSET);
}
?>