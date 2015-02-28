<?php

/**
 * ECSHOP 积分商城
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: exchange.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_order.php');
if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/*------------------------------------------------------ */
//-- act 操作项的初始化
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/*------------------------------------------------------ */
//-- 积分兑换商品列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    require(dirname(__FILE__) . '/includes/lib_integral.php');

    /* 初始化分页信息 */
    $page         = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size         = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
    $cat_id       = isset($_REQUEST['cat_id']) && intval($_REQUEST['cat_id']) > 0 ? intval($_REQUEST['cat_id']) : 0;
    $integral_max = isset($_REQUEST['integral_max']) && intval($_REQUEST['integral_max']) > 0 ? intval($_REQUEST['integral_max']) : 0;
    $integral_min = isset($_REQUEST['integral_min']) && intval($_REQUEST['integral_min']) > 0 ? intval($_REQUEST['integral_min']) : 0;

    /* 排序、显示方式以及类型 */
    $default_display_type      = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
    $default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
    $default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'exchange_integral' : 'last_update');

    $sort    = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'exchange_integral', 'last_update'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
    $order   = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC')))                              ? trim($_REQUEST['order']) : $default_sort_order_method;
    $display = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
    $display  = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
    setcookie('ECS[display]', $display, gmtime() + 86400 * 7);

    /* 页面的缓存ID */
    $cache_id = sprintf('%X', crc32( $_SESSION['user_name']));

    if (!$smarty->is_cached('exchange.dwt', $cache_id))
    {
        /* 如果页面没有被缓存则重新获取页面的内容 */

        $children = get_children($cat_id);

        $cat = get_cat_info($cat_id);   // 获得分类的相关信息

        if (!empty($cat))
        {
            $smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
            $smarty->assign('description', htmlspecialchars($cat['cat_desc']));
        }

        assign_template();

        $position = assign_ur_here('exchange');
		
		
		$user_id='';
		 if($_SESSION['user_name'])
		 {
			$sql="select user_id from ecs_users where user_name='".$_SESSION['user_name']."'";
			$user_id=$db->getOne($sql);
		
		 }
		 $user_attent=is_attent();  //chen-0909
		 $smarty->assign('user_attent',$user_attent);
		 
		user_infomation($smarty,$user_id);
        $smarty->assign('page_title',       $position['title']);    // 页面标题
        $smarty->assign('ur_here',          $position['ur_here']);  // 当前位置

        $smarty->assign('categories',       get_categories_tree());        // 分类树
		//var_dump(get_categories_tree());
        $smarty->assign('helps',            get_shop_help());              // 网店帮助
        $smarty->assign('top_goods',        get_top10());                  // 销售排行
        $smarty->assign('promotion_info',   get_promotion_info());         // 促销活动信息

        /* 调查 */
        $vote = get_vote();
        if (!empty($vote))
        {
            $smarty->assign('vote_id',     $vote['id']);
            $smarty->assign('vote',        $vote['content']);
        }

        $ext = ''; //商品查询条件扩展

		$smarty->assign('best_goods',      get_exchange_recommend_goods('best', $children, $integral_min, $integral_max)); // 获取超值兑换 chen 08 30
        $smarty->assign('new_goods',       get_exchange_recommend_goods('new',  $children, $integral_min, $integral_max)); // 获取精品上新 chen 08 30

        $count = get_exchange_goods_count($children, $integral_min, $integral_max);
        $max_page = ($count> 0) ? ceil($count / $size) : 1;
        if ($page > $max_page)
        {
            $page = $max_page;
        }
		
		$now=gmtime();
		$started="  $now > eg.begin_time "; $not_started="  $now < eg.begin_time ";
        $goods_trailer = exchange_get_goods($children, $integral_min, $integral_max, $ext, $size, $page, $sort, $order,$not_started);// 获取未开始的积分兑换 chen 08 30
        
		$in_week = gmtime() - 3600*24*7;
		$in_month = gmtime() - 3600*24*30;
        $weekly_rank = get_goods_rank(" oi.pay_time > $in_week");
        $monthly_rank = get_goods_rank(" oi.pay_time > $in_month");
        if($display == 'grid')
        {
            if(count($goodslist) % 2 != 0)
            {
                $goodslist[] = array();
            }
        }
		  /* 积分商城广告 */
    $ad_integral = $db->getRow('SELECT ad_code, ad_link FROM ' . $ecs->table("ad") . ' WHERE position_id = 2 ');
   $smarty->assign('ad_integral', $ad_integral);
        $smarty->assign('goods_trailer',       $goods_trailer);     
	    $smarty->assign('weekly_rank',         $weekly_rank);
	    $smarty->assign('monthly_rank',         $monthly_rank);
        $smarty->assign('category',         $cat_id);
        $smarty->assign('integral_max',     $integral_max);
        $smarty->assign('integral_min',     $integral_min);
  	if($user_id)
		{
			$sql = "select personal_pic from ".$GLOBALS['ecs']->table('users')." where user_id=$user_id";
			$personal_pic = $GLOBALS['db']->getOne($sql);
		   $smarty->assign('personal_pic',$personal_pic);
		}

        assign_pager('exchange',            $cat_id, $count, $size, $sort, $order, $page, '', '', $integral_min, $integral_max, $display); // 分页
        assign_dynamic('exchange_list'); // 动态内容
    }
	
    $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typeexchange.xml" : 'feed.php?type=exchange'); // RSS URL
    $smarty->display('exchange_list.dwt', $cache_id);

}
/*------------------------------------------------------ */
//-- 积分获取 chen 0901
/*------------------------------------------------------ */
else if($_REQUEST['act'] == 'get')
{
assign_template();

         $user_id='';
		 if($_SESSION['user_name'])
		 {
			$sql="select user_id from ecs_users where user_name='".$_SESSION['user_name']."'";
			$user_id=$db->getOne($sql);
		
		 }
		user_infomation($smarty,$user_id);
      //chen-1013
	 
	  require_once(ROOT_PATH . 'includes/lib_integral.php');
	 
	 $integral_type = ($user_id=='') ? 0 : get_integral_type();
	
	 $uncmpltOrdIntgr=$user_id=='' ? 0 :get_frozen_integral($user_id,$integral_type[0]); //未完成订单,被冻结的积分
     $uncmpltOrdCnt= $user_id=='' ? 0:get_frozen_integral_orderCount($user_id,$integral_type[0]); //未完成订单数
    	
	
		$unCmmtOrdIntgr=$user_id=='' ? 0 :get_frozen_integral($user_id,$integral_type[1]); //未评论订单,被冻结的积分
     $unCmmtOrdCnt=$user_id=='' ? 0 :get_frozen_integral_orderCount($user_id,$integral_type[1]); //未评论订单数
	 
		$smarty->assign('uncmpltOrdIntgr',        $uncmpltOrdIntgr); // 网店帮助
		$smarty->assign('uncmpltOrdCnt',        $uncmpltOrdCnt); // 网店帮助
		
		$smarty->assign('unCmmtOrdIntgr',        $unCmmtOrdIntgr); // 网店帮助
		$smarty->assign('unCmmtOrdCnt',        $unCmmtOrdCnt); // 网店帮助
		
		$smarty->assign('CFG_CmmtIntgr',        $_CFG['comment_integral']);
		$smarty->assign('CFG_top5CmmtIntgr',    $_CFG['top5_integral']);
		
		$is_got_RgstPnt = is_got_RgstPnt();
		$smarty->assign('is_got_RgstPnt',   $is_got_RgstPnt);
		$smarty->assign('CFG_RgstPnt',    $_CFG['register_points']);
		$smarty->assign('personal_pic',get_personalPic());
	  $fuwu = $db->getOne("SELECT content FROM " . $ecs->table('article') . " WHERE article_id =52 " );//售后服务
				  $smarty->assign('fuwu',          $fuwu); 

	$smarty->assign('helps',        get_shop_help()); // 网店帮助

$smarty->display('exchange_get.dwt');
}
/*------------------------------------------------------ */
//-- 积分兑换商品详情
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{
    $goods_id = isset($_REQUEST['id'])  ? intval($_REQUEST['id']) : 0;

    $cache_id = $goods_id . '-' . $_SESSION['user_rank'] . '-' . $_CFG['lang'] . '-exchange';
    $cache_id = sprintf('%X', crc32($cache_id));

    if (!$smarty->is_cached('exchange_goods.dwt', $cache_id))
    {
        $smarty->assign('image_width',  $_CFG['image_width']);
        $smarty->assign('image_height', $_CFG['image_height']);
        $smarty->assign('helps',        get_shop_help()); // 网店帮助
        $smarty->assign('id',           $goods_id);
        $smarty->assign('type',         0);
        $smarty->assign('cfg',          $_CFG);

        /* 获得商品的信息 */
        $goods = get_exchange_goods_info($goods_id);

        if ($goods === false)
        {
            /* 如果没有找到任何记录则跳回到首页 */
            ecs_header("Location: ./\n");
            exit;
        }
        else
        {
            if ($goods['brand_id'] > 0)
            {
                $goods['goods_brand_url'] = build_uri('brand', array('bid'=>$goods['brand_id']), $goods['goods_brand']);
            }
        //增加评论，历史记录等功能 chen 0831
            $goods['goods_style_name'] = add_style($goods['goods_name'], $goods['goods_name_style']);
       
	 
                $smarty->assign('recently_buy', recently_buy($goods_id)); 
			  $smarty->assign('sale_history', getsales_history($goods_id));        //获取购买历史记录
			  $fuwu = $db->getOne("SELECT content FROM " . $ecs->table('article') . " WHERE article_id =52 " );//售后服务
              $smarty->assign('fuwu',          $fuwu);  
			  $smarty->assign('comment_percent',     comment_percent($goods_id));  //获取评分
			
            $smarty->assign('goods',              $goods);
            $smarty->assign('goods_id',           $goods['goods_id']);
            $smarty->assign('categories',         get_categories_tree());  // 分类树

            /* meta */
            $smarty->assign('keywords',           htmlspecialchars($goods['keywords']));
            $smarty->assign('description',        htmlspecialchars($goods['goods_brief']));

            assign_template();

            /* 上一个商品下一个商品 */
            $sql = "SELECT eg.goods_id FROM " .$ecs->table('exchange_goods'). " AS eg," . $GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND eg.goods_id > " . $goods['goods_id'] . " AND eg.is_exchange = 1 AND g.is_delete = 0 LIMIT 1";
            $prev_gid = $db->getOne($sql);
            if (!empty($prev_gid))
            {
                $prev_good['url'] = build_uri('exchange_goods', array('gid' => $prev_gid), $goods['goods_name']);
                $smarty->assign('prev_good', $prev_good);//上一个商品
            }

            $sql = "SELECT max(eg.goods_id) FROM " . $ecs->table('exchange_goods') . " AS eg," . $GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND eg.goods_id < ".$goods['goods_id'] . " AND eg.is_exchange = 1 AND g.is_delete = 0";
            $next_gid = $db->getOne($sql);
            if (!empty($next_gid))
            {
                $next_good['url'] = build_uri('exchange_goods', array('gid' => $next_gid), $goods['goods_name']);
                $smarty->assign('next_good', $next_good);//下一个商品
            }

            /* current position */
            $position = assign_ur_here('exchange', $goods['goods_name']);
            $smarty->assign('page_title',          $position['title']);                    // 页面标题
            $smarty->assign('ur_here',             $position['ur_here']);                  // 当前位置

            $properties = get_goods_properties($goods_id);  // 获得商品的规格和属性
            $smarty->assign('properties',          $properties['pro']);                              // 商品属性
            $smarty->assign('specification',       $properties['spe']);                              // 商品规格
			
			$smarty->assign('new_comment', get_new_comment($goods_id,1)); //获取最新一条评论信息
			
            $smarty->assign('pictures',            get_goods_gallery($goods_id));                    // 商品相册

            assign_dynamic('exchange_goods');
        }
    }

    $smarty->display('exchange_goods.dwt',      $cache_id);
}

/*------------------------------------------------------ */
//--  兑换
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'buy')
{
    /* 查询：判断是否登录 */
    if (!isset($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
    {
        $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'exchange') ? $GLOBALS['_SERVER']['HTTP_REFERER'] : './index.php';
    }

    /* 查询：判断是否登录 */
    if ($_SESSION['user_id'] <= 0)
    {
        show_message($_LANG['eg_error_login'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    /* 查询：取得参数：商品id */
    $goods_id = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
    if ($goods_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 查询：取得兑换商品信息 */
    $goods = get_exchange_goods_info($goods_id);
    if (empty($goods))
    {
        ecs_header("Location: ./\n");
        exit;
    }
    /* 查询：检查兑换商品是否有库存 */
    if($goods['goods_number'] == 0 && $_CFG['use_storage'] == 1)
    {
        show_message($_LANG['eg_error_number'], array($_LANG['back_up_page']), array($back_act), 'error');
    }
    /* 查询：检查兑换商品是否是取消 */
    if ($goods['is_exchange'] == 0)
    {
        show_message($_LANG['eg_error_status'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    $user_info   = get_user_info($_SESSION['user_id']);
    $user_points = $user_info['pay_points']; // 用户的积分总数
    $number = (int)$_REQUEST['number'];
  	
		if($goods['goods_number'] < $number)
		{
		show_message('你购买的商品数量超出了该商品的库存量', array($_LANG['back_up_page']), array($back_act), 'error');
		}
		
	
	if ( $number * $goods['exchange_integral'] > $user_points)
    {
        show_message($_LANG['eg_error_integral'], array($_LANG['back_up_page']), array($back_act), 'error');
    }
   
    /* 查询：取得规格 */
    $specs = '';
    foreach ($_POST as $key => $value)
    {
        if (strpos($key, 'spec_') !== false)
        {
            $specs .= ',' . intval($value);
        }
    }
    $specs = trim($specs, ',');

    /* 查询：如果商品有规格则取规格商品信息 配件除外 */
    if (!empty($specs))
    {
        $_specs = explode(',', $specs);

        $product_info = get_products_info($goods_id, $_specs);
    }
    if (empty($product_info))
    {
        $product_info = array('product_number' => '', 'product_id' => 0);
    }

    //查询：商品存在规格 是货品 检查该货品库存
    if((!empty($specs)) && ($product_info['product_number'] == 0) && ($_CFG['use_storage'] == 1))
    {
        show_message($_LANG['eg_error_number'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    /* 查询：查询规格名称和值，不考虑价格 */
    $attr_list = array();
    $sql = "SELECT a.attr_name, g.attr_value " .
            "FROM " . $ecs->table('goods_attr') . " AS g, " .
                $ecs->table('attribute') . " AS a " .
            "WHERE g.attr_id = a.attr_id " .
            "AND g.goods_attr_id " . db_create_in($specs);
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
    }
    $goods_attr = join(chr(13) . chr(10), $attr_list);

    /* 更新：清空购物车中所有团购商品 */
    
    clear_cart(CART_EXCHANGE_GOODS);

    /* 更新：加入购物车 */
		//chen-1013
   // $number = $_REQUEST['number'];
    $cart = array(
        'user_id'        => $_SESSION['user_id'],
        'session_id'     => SESS_ID,
        'goods_id'       => $goods['goods_id'],
        'product_id'     => $product_info['product_id'],
        'goods_sn'       => addslashes($goods['goods_sn']),
        'goods_name'     => addslashes($goods['goods_name']),
        'market_price'   => $goods['market_price'],
        'goods_price'    => 0,//$goods['exchange_integral']
        'goods_number'   => $number,
        'goods_attr'     => addslashes($goods_attr),
        'goods_attr_id'  => $specs,
        'is_real'        => $goods['is_real'],
        'extension_code' => addslashes($goods['extension_code']),
        'parent_id'      => 0,
        'rec_type'       => CART_EXCHANGE_GOODS,
        'is_gift'        => 0,
		'needed_money'   => $_REQUEST['needed_money'],
		'needed_integral'=> $_REQUEST['needed_integral']
    );
	
	
  $db->autoExecute($ecs->table('cart'), $cart, 'INSERT');
  $sql = "select rec_id from ".$ecs->table('cart')." order by rec_id desc limit 1 ";
  $rec_id = $db->getOne($sql);
	//echo $a;
	//print_r($cart);
    /* 记录购物流程类型：团购 */
    $_SESSION['flow_type'] = CART_EXCHANGE_GOODS;
    $_SESSION['extension_code'] = 'exchange_goods';
    $_SESSION['extension_id'] = $goods_id;

    /* 进入收货人页面 */

  ecs_header("Location: ./flow.php?step=checkout&goods_list=". $rec_id."\n");
    exit;
}


/*------------------------------------------------------ */
//--  更多兑换 chen 0831
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'more')
{
/* 页面的缓存ID */
    $type=$_REQUEST['type'];
    $cache_id = sprintf('%X', crc32('more'.'-'.$type));

    if (!$smarty->is_cached('exchange_more.dwt', $cache_id))
    {
	 assign_template();
	  $fuwu = $db->getOne("SELECT content FROM " . $ecs->table('article') . " WHERE article_id =52 " );//售后服务
				  $smarty->assign('fuwu',          $fuwu); 
				  
				  
				    $where_type=' and eg.is_best = 1 ';
					$order_method = ' ORDER BY eg.exchange_integral DESC';
                   if($type=='new') 
				   {
						$where_type='  and eg.is_new = 1  ';
						$order_method = ' ORDER BY eg.needed_money DESC';
				   }
				   
				    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;	
                  $sql =  'SELECT COUNT(*)  FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE eg.is_exchange = 1 AND g.is_delete = 0 AND begin_time < '.gmtime().$where_type.$order_method;

				   $record_count = $db->getOne($sql);
					 $pager = get_pager('exchange.php', array('act' => 'more','type' => $type), $record_count, $page, 20);
					 
					 
					 
    $more_exchange_goods=get_more_exchange_goods($type, $where_type, $pager['size'], $pager['start'], $order_method);
//var_dump($more_exchange_goods);	
    $smarty->assign('pager',        $pager);
	$smarty->assign('more_exchange_goods',$more_exchange_goods);
	$smarty->assign('type',$type);
	$smarty->assign('helps',        get_shop_help()); // 网店帮助
	$smarty->assign('cfg',          $_CFG);
	assign_dynamic('exchange_more'); // 动态内容
   }
   $smarty->display('exchange_more.dwt');
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */


/*------------------------------------------------------ */
//--  每日签到 chen-0909
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'attent')
{
 require(dirname(__FILE__) . '/includes/lib_integral.php');
 $gained_integral=$GLOBALS['_CFG']['daily_attent'];
$flag = user_attent($_SESSION['user_id'],$gained_integral);
  if($flag==1)
    echo $gained_integral;
  else echo "签到失败";
}


 
 
/**
 * 获得分类的信息
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_cat_info($cat_id)
{
    return $GLOBALS['db']->getRow('SELECT keywords, cat_desc, style, grade, filter_attr, parent_id FROM ' . $GLOBALS['ecs']->table('category') .
        " WHERE cat_id = '$cat_id'");
}

/**
 * 获得分类下的商品  超值兑换,精品上新 chen 0831
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function exchange_get_goods($children, $min, $max, $ext, $size, $page, $sort, $order, $started_or_not)
{
    $display = $GLOBALS['display'];
    $where = "eg.is_exchange = 1 AND g.is_delete = 0 AND ".
             "($children OR " . get_extension_goods($children) . ')';

    if ($min > 0)
    {
        $where .= " AND eg.exchange_integral >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND eg.exchange_integral <= $max ";
    }

    /* 获得商品列表 */
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style,g.shop_price,eg.begin_time, eg.exchange_integral, eg.needed_money, ' .
                'g.goods_type, g.goods_brief, g.goods_thumb , g.goods_img, eg.is_hot ' .
            'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .$GLOBALS['ecs']->table('goods') . ' AS g ' .
            "WHERE eg.goods_id = g.goods_id AND $started_or_not AND $where  $ext ORDER BY $sort $order";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        /* 处理商品水印图片 */
        $watermark_img = '';

//        if ($row['is_new'] != 0)
//        {
//            $watermark_img = "watermark_new_small";
//        }
//        elseif ($row['is_best'] != 0)
//        {
//            $watermark_img = "watermark_best_small";
//        }
//        else
        if ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot_small';
        }

        if ($watermark_img != '')
        {
            $arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
        }

        $arr[$row['goods_id']]['goods_id']          = $row['goods_id'];
        if($display == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']    = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
        }
		$properties = get_goods_properties($row['goods_id']);  // 获得商品的规格和属性
		$arr[$row['goods_id']]['properties_pro'] = $properties['pro']['商品属性'];
		$arr[$row['goods_id']]['soldnum'] = get_soldnum($row['goods_id']);
		$arr[$row['goods_id']]['comments_number'] = get_comments_number($row['goods_id']);
		$arr[$row['goods_id']]['brief'] = $row['goods_brief'];
        $arr[$row['goods_id']]['name']              = $row['goods_name'];
        $arr[$row['goods_id']]['goods_style_name']  = add_style($row['goods_name'],$row['goods_name_style']);
        $arr[$row['goods_id']]['exchange_integral'] = $row['exchange_integral'];
        $arr[$row['goods_id']]['type']              = $row['goods_type'];
		$arr[$row['goods_id']]['shop_price']        = $row['shop_price'];
	    $arr[$row['goods_id']]['needed_money']      = $row['needed_money'];
		$arr[$row['goods_id']]['begin_date']        = local_date('m-d',$row['begin_time']);
		$arr[$row['goods_id']]['begin_hour']        = local_date('H:i',$row['begin_time']);
		$arr[$row['goods_id']]['integral_integer']  = floor($row['shop_price']-$row['needed_money']);
		$arr[$row['goods_id']]['integral_decimal']  =   end(explode('.', number_format($row['shop_price']-$row['needed_money'],2)));  
        $arr[$row['goods_id']]['goods_thumb']       = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']         = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']               = build_uri('exchange_goods', array('gid'=>$row['goods_id']), $row['goods_name']);
    }

    return $arr;
}

/**
 * 获得分类下的商品总数
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_exchange_goods_count($children, $min = 0, $max = 0, $ext='')
{
    $where  = "eg.is_exchange = 1 AND g.is_delete = 0 AND ($children OR " . get_extension_goods($children) . ')';


    if ($min > 0)
    {
        $where .= " AND eg.exchange_integral >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND eg.exchange_integral <= $max ";
    }

    $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .
           $GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND $where $ext";

    /* 返回商品总数 */
    return $GLOBALS['db']->getOne($sql);
}

/**
 * 获得指定分类下的推荐商品
 *
 * @access  public
 * @param   string      $type       推荐类型，可以是 best, new, hot, promote
 * @param   string      $cats       分类的ID
 * @param   integer     $min        商品积分下限
 * @param   integer     $max        商品积分上限
 * @param   string      $ext        商品扩展查询
 * @return  array
 */
function get_exchange_recommend_goods($type = '', $cats = '', $min =0,  $max = 0, $ext='')
{
    $price_where = ($min > 0) ? " AND g.shop_price >= $min " : '';
    $price_where .= ($max > 0) ? " AND g.shop_price <= $max " : '';

    $sql =  'SELECT g.goods_id, g.goods_name, eg.needed_money,eg.begin_time, g.shop_price, g.goods_name_style, eg.exchange_integral, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE eg.is_exchange = 1 AND g.is_delete = 0 AND begin_time < '.gmtime().' ' . $price_where . $ext;
			
    $num = 0;
    $type2lib = array('best'=>'exchange_best', 'new'=>'exchange_new', 'hot'=>'exchange_hot');
    $num = get_library_number($type2lib[$type], 'exchange_list');

  

    if (!empty($cats))
    {
        $sql .= " AND (" . $cats . " OR " . get_extension_goods($cats) .")";
    }
	
	  switch ($type)
    {
        case 'best':
            $sql .= ' AND eg.is_best = 1 ORDER BY eg.exchange_integral DESC';
            break;
        case 'new':
            $sql .= ' AND eg.is_new = 1 ORDER BY eg.needed_money DESC';
            break;
        case 'hot':
            $sql .= ' AND eg.is_hot = 1';
            break;
    }

    $res = $GLOBALS['db']->selectLimit($sql, $num);

    $idx = 0;
    $goods = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $goods[$idx]['id']                = $row['goods_id'];
        $goods[$idx]['name']              = $row['goods_name'];
		$goods[$idx]['shop_price']        = price_format($row['shop_price']);
        $goods[$idx]['brief']             = $row['goods_brief'];
        $goods[$idx]['brand_name']        = $row['brand_name'];
        $goods[$idx]['short_name']        = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                                sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $goods[$idx]['exchange_integral'] = $row['exchange_integral'];
        $goods[$idx]['thumb']             = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $goods[$idx]['goods_img']         = get_image_path($row['goods_id'], $row['goods_img']);
        $goods[$idx]['url']               = build_uri('exchange', array('act' => 'view', 'id' => $row['goods_id']));
         $goods[$idx]['needed_money']      = price_format($row['needed_money']);
		 $goods[$idx]['begin_date']        = gmdate('m-d',$row['begin_time']);
		 $goods[$idx]['begin_hour']        = gmdate('h:i',$row['begin_time']);
		  $goods[$idx]['integral_integer']  = floor($row['shop_price']-$row['needed_money']);
		 $goods[$idx]['integral_decimal']  =   end(explode('.', number_format($row['shop_price']-$row['needed_money'],1))); 
		   $goods[$idx]['goods_style_name']  = add_style($row['goods_name'],$row['goods_name_style']);
        $goods[$idx]['short_style_name']  = add_style($goods[$idx]['short_name'], $row['goods_name_style']);
        $idx++;
    }

    return $goods;
}

/**
 * 获得积分兑换商品的详细信息
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_exchange_goods_info($goods_id)
{
    $time = gmtime();
    $sql = 'SELECT g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand,eg.bought_number,eg.needed_money, eg.exchange_integral, eg.is_exchange ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('category') . ' AS c ON g.cat_id = c.cat_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id ' .
            "WHERE g.goods_id = '$goods_id' AND g.is_delete = 0 " .
            'GROUP BY g.goods_id';
    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        /* 处理商品水印图片 */
        $watermark_img = '';

        if ($row['is_new'] != 0)
        {
            $watermark_img = "watermark_new";
        }
        elseif ($row['is_best'] != 0)
        {
            $watermark_img = "watermark_best";
        }
        elseif ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot';
        }

        if ($watermark_img != '')
        {
            $row['watermark_img'] =  $watermark_img;
        }

        /* 修正重量显示 */
        $row['goods_weight']  = (intval($row['goods_weight']) > 0) ?
            $row['goods_weight'] . $GLOBALS['_LANG']['kilogram'] :
            ($row['goods_weight'] * 1000) . $GLOBALS['_LANG']['gram'];

        /* 修正上架时间显示 */
        $row['add_time']      = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);

        /* 修正商品图片 */
        $row['goods_img']   = get_image_path($goods_id, $row['goods_img']);
        $row['goods_thumb'] = get_image_path($goods_id, $row['goods_thumb'], true);

        return $row;
    }
    else
    {
        return false;
    }
}

/**
 * 获取月排行和周排行
 *
 * @access  public
 * @param   string     $where:时间限制条件，某个时间段内(一周内或是一个月内)
 * @return  void
 */
function get_goods_rank($where)
{
 
$sql= ' select ex.goods_id,count(*) as cnum from ecs_exchange_goods as ex 
    join  ecs_order_goods as og  on ex.goods_id=og.goods_id
    join  ecs_order_info as oi on oi.order_id=og.order_id where oi.integral > 0 and is_exchange=1 and '.$where .' order by cnum desc limit 4 ';
	$res = $GLOBALS['db']->getAll($sql);

  $res = $GLOBALS['db']->getAll($sql);
  $rank=array();
	foreach($res as $value)
	{
		if(!$value['goods_id'])
		  continue;
		   $sql =  'select ex.needed_money,ex.exchange_integral,g.goods_thumb,g.goods_name from ecs_exchange_goods as ex 
		join  ecs_goods as g  on ex.goods_id=g.goods_id where ex.goods_id='.$value['goods_id'];
		$row=$GLOBALS['db']->getRow($sql);
		$row['needed_money'] = price_format($row['needed_money']);
		$row['cnum']=$value['cnum'];
		$row['id']=$value['goods_id'];
		$row['url'] = build_uri('exchange',array('act' => 'view', 'id' => $row['id']));
		$rank[]=$row;
	}
return $rank;
}
/*取得用户等级，姓名 chen 0831*/
function user_infomation($smarty,$user_id='')
{
 include_once(ROOT_PATH .'includes/lib_clips.php');
    $rank = get_rank_info();
	$smarty->assign('info',        get_user_default($user_id)); 	//用户信息
	$smarty->assign('vip_name',  $rank['rank_name']);   // 用户名

	$vip_pic = '';
	switch($rank['rank_name'])
	{
	  case 'VIP0':$vip_pic ='vip_s0.png';break;
	  case 'VIP1':$vip_pic ='vip_s1.png';break;
	  case 'VIP2':$vip_pic ='vip_s2.png';break;
	  case 'VIP3':$vip_pic ='vip_s3.png';break;
	  case 'VIP4':$vip_pic ='vip_s4.png';break;
	  default:$vip_pic ='vip_s0.png';break;
	}
	$smarty->assign('vip_pic',$vip_pic);
}

function get_more_exchange_goods($type='best',$where_type, $page_size, $start, $order_method)
{

   $sql =  'SELECT g.goods_id, g.goods_name, eg.needed_money,eg.begin_time, g.shop_price, g.goods_name_style, eg.exchange_integral, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE eg.is_exchange = 1 AND g.is_delete = 0 AND begin_time < '.gmtime().$where_type.$order_method;
	
			 $res = $GLOBALS['db']->SelectLimit($sql, $page_size, $start);
			
			$more_goods=array();
			while ($row = $GLOBALS['db']->fetchRow($res))
    {
	
		$row['integral_integer']  = floor($row['shop_price']-$row['needed_money']);
		$row['integral_decimal']  =   end(explode('.', number_format($row['shop_price']-$row['needed_money'],1))); 
		$row['shop_price'] = price_format($row['shop_price']);
		$row['needed_money'] = price_format($row['needed_money']);
		$row['url']   = build_uri('exchange', array('act' => 'view', 'id' => $row['goods_id']));
		
		  $more_goods[]=$row;
		 

	}
	return $more_goods;
}
?>
