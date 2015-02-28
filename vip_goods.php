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
    $cache_id = sprintf('%X', crc32($cat_id . '-' . $display . '-' . $sort  .'-' . $order  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
        $_CFG['lang'] . '-' . $integral_max . '-' .$integral_min));

    if (!$smarty->is_cached('vip_goods_list.dwt', $cache_id))
    {
        /* 如果页面没有被缓存则重新获取页面的内容 */
        update_vip_goods();
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
		 
		
        $smarty->assign('page_title',       $position['title']);    // 页面标题
        $smarty->assign('ur_here',          $position['ur_here']);  // 当前位置

        $smarty->assign('categories',       get_categories_tree());        // 分类树
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

		$smarty->assign('vip_only_goods',    get_vip_goods_recommend('vip_only'));
        $smarty->assign('integral_buy_goods',       get_vip_goods_recommend('integral_buy'));

     
       
        $goods_trailer = vip_goods_get_goodsTrailer();
       
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

 $ad_vipGooods = $db->getRow('SELECT ad_code, ad_link FROM ' . $ecs->table("ad") . ' WHERE position_id = 15 ');
   $smarty->assign('ad_vipGooods', $ad_vipGooods);
        $smarty->assign('goods_trailer',       $goods_trailer);     
	    $smarty->assign('weekly_rank',         $weekly_rank);
	    $smarty->assign('monthly_rank',         $monthly_rank);
   
  	if($user_id)
		{
	$sql = "select personal_pic from ".$GLOBALS['ecs']->table('users')." where user_id=$user_id";
	$personal_pic = $GLOBALS['db']->getOne($sql);
   $smarty->assign('personal_pic',$personal_pic);
}

       
        assign_dynamic('vip_goods_list'); // 动态内容
    }
user_infomation($smarty,$user_id);   
   $smarty->display('vip_goods_list.dwt', $cache_id);

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
if(!$_SESSION['user_id'])
{
  show_message('您没有登录，不能购买商品',  '返回上一页', 'vip_goods.php' ,  'info', true);
}
    $goods_id = isset($_REQUEST['id'])  ? intval($_REQUEST['id']) : 0;
	
  $sql = "select price_id from ".$GLOBALS['ecs']->table('vip_member_price')." where goods_id = '$goods_id' and user_rank = ".$_SESSION['user_rank'];
 
  if(!$GLOBALS['db']->getOne($sql))
  {
   show_message('您对应的vip等级，没有该商品促销',  '返回上一页', 'vip_goods.php' ,  'info', true);
   
  }
   
        $smarty->assign('image_width',  $_CFG['image_width']);
        $smarty->assign('image_height', $_CFG['image_height']);
        $smarty->assign('helps',        get_shop_help()); // 网店帮助
        $smarty->assign('id',           $goods_id);
        $smarty->assign('type',         0);
        $smarty->assign('cfg',          $_CFG);

        /* 获得商品的信息 */
        $goods = get_vip_goods_info($goods_id);

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

            assign_dynamic('vip_goods_goods');
        }
   
    $smarty->display('vip_goods_goods.dwt');
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
    $goods = get_vip_goods_info($goods_id);

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
    /*if((!empty($specs)) && ($product_info['product_number'] == 0) && ($_CFG['use_storage'] == 1))
    {
		
        show_message($_LANG['eg_error_number'], array($_LANG['back_up_page']), array($back_act), 'error');
    }*/

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
    $_SESSION['extension_code'] = 'vip_goods';
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
				  
				  
				    $where_type=' and vg.is_integral_buy = 0 ';
                   if($type=='integral_buy') $where_type='  and vg.is_integral_buy = 1  ';
				   
				    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;	
                  $sql =  'SELECT COUNT(*)  FROM ' . $GLOBALS['ecs']->table('vip_goods') . ' AS vg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = vg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE vg.is_exchange = 1 AND g.is_delete = 0 AND begin_time < '.gmtime().$where_type;

				   $record_count = $db->getOne($sql);
					 $pager = get_pager('vip_goods.php', array('act' => 'more','type' => $type), $record_count, $page, 20);
					 
					
					 
    $vip_goods_more_goods=get_more_vip_goods_goods($type,$where_type, $pager['size'], $pager['start']);
//var_dump($more_exchange_goods);	
    $smarty->assign('pager',        $pager);
	$smarty->assign('vip_goods_more_goods',$vip_goods_more_goods);
	$smarty->assign('type',$type);
	$smarty->assign('helps',        get_shop_help()); // 网店帮助
	$smarty->assign('cfg',          $_CFG);
	assign_dynamic('vip_goods_more'); // 动态内容
   }
   $smarty->display('vip_goods_more.dwt');
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */



 
 
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
function vip_goods_get_goodsTrailer()
{
  $sql = 'SELECT g.goods_id, g.goods_name, g.shop_price, g.goods_name_style, ' .
                'g.goods_brief, g.goods_thumb, goods_img, vg.begin_time ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g '.
			'JOIN '.$GLOBALS['ecs']->table('vip_goods').' AS vg ON g.goods_id = vg.goods_id ' .
       
            'WHERE vg.is_exchange = 1 AND g.is_delete = 0 AND vg.is_next = 1 ';

			
			 $arr = $GLOBALS['db']->getAll($sql);
   foreach($arr as $k => $v)
   {
      $arr[$k]['begin_date']        = local_date('m-d',$v['begin_time']);
	  $arr[$k]['begin_hour']        = local_date('H:i',$v['begin_time']);
	  $arr[$k]['goods_style_name']  = add_style($v['goods_name'],$v['goods_name_style']);
   }
	return $arr;
}


/**
 * 获得积分兑换商品的详细信息
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_vip_goods_info($goods_id)
{
    $time = gmtime();
    $sql = 'SELECT g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand,vg.bought_number, vg.is_exchange ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('vip_goods') . ' AS vg ON g.goods_id = vg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('category') . ' AS c ON g.cat_id = c.cat_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id ' .
            "WHERE g.goods_id = '$goods_id' AND g.is_delete = 0 " .
            'GROUP BY g.goods_id';
//echo $sql;
    $row = $GLOBALS['db']->getRow($sql);
	
	$sql = "select user_price, user_integral from ".$GLOBALS['ecs']->table('vip_member_price')." where goods_id = '$goods_id' AND user_rank=".$_SESSION['user_rank'];
	$tmp = $GLOBALS['db']->getRow($sql);
	$row['user_price'] = $tmp['user_price'];
	$row['user_integral'] = $tmp['user_integral'];
//var_dump($row);
    if ($row !== false)
    {

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
	
	
  //  echo $sql;
  $res = $GLOBALS['db']->getAll($sql);
  $rank=array();
	foreach($res as $value)
	{
	if(!$value['goods_id'])
	  continue;
	   $sql =  'select ex.needed_money,ex.exchange_integral,g.goods_thumb,g.goods_name from ecs_exchange_goods as ex 
    join  ecs_goods as g  on ex.goods_id=g.goods_id where ex.goods_id='.$value['goods_id'];
	$row=$GLOBALS['db']->getRow($sql);
	$row['cnum']=$value['cnum'];
	$row['id']=$value['goods_id'];
	$rank[]=$row;
	}
	
return $rank;
}
/*取得用户等级，姓名 chen 0831*/
function user_infomation($smarty,$user_id='')
{
 include_once(ROOT_PATH .'includes/lib_clips.php');
    $rank = get_rank_info();
 // var_dump(get_user_default($user_id));
    $user_rank_list = get_user_rank_list();
    
	
	//var_dump($user_rank_list);
	
  $info = get_user_default($user_id);
  foreach($user_rank_list as $tKey => $tVal)  
	{
	     if($tVal['max_points'] > $info['rank_points']  && $tVal['min_points'] <= $info['rank_points'])
		 {
		       $info['current_lever'] = $tVal['rank_name'];	
               $info['next_lever'] = $user_rank_list[$tKey + 1]['rank_name'];				   
			   $info['overFlowPoints'] = $info['rank_points'] - $tVal['min_points'];
			   $info['baseLeverPoints'] = $tVal['max_points'] - $tVal['min_points'];
			   $info['leverRate'] = 100.0 * $info['overFlowPoints'] / $info['baseLeverPoints'];
			   
		 }
		 else if($tVal['max_points'] < $info['rank_points'])
		 {
		    $info['current_lever'] = $tVal['rank_name'];
			 $info['next_lever'] = $tVal['rank_name'];
            $info['leverRate'] = 100.0;			
		 }
	}
	
	$smarty->assign('info',     $info   ); 	//用户信息
	$smarty->assign('vip_name',  $rank['rank_name']);   // 用户名
}


function get_vip_goods_recommend($type='vip_only')
{
  if($type == 'vip_only')
  {
   $user_rank_list = get_user_rank_list();
   //var_dump($user_rank_list);exit;
    foreach($user_rank_list as $useRanKey => $useRankVal)
	{
	  if($useRankVal['rank_name'] == '代销用户' || $useRankVal['rank_name'] == 'VIP0')
	    continue;
		$sql =  'SELECT ur.rank_name,vmp.user_price,g.goods_id, g.goods_name, vg.begin_time,g.market_price, g.shop_price, g.goods_name_style, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('vip_goods') . ' AS vg ' .
			'JOIN ' . $GLOBALS['ecs']->table('vip_member_price') . ' AS vmp on vmp.goods_id = vg.goods_id '.
			" join ".$GLOBALS['ecs']->table('user_rank')." as ur on vmp.user_rank = ur.rank_id ".
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = vg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE vmp.user_rank = "'.$useRankVal['rank_id'].'" AND vg.is_integral_buy = 0 AND vg.is_exchange = 1 AND g.is_delete = 0 AND is_next = 0 order by vg.goods_id asc limit 2 ;';
		//	ECHO $sql.'<br/>';
			$tmpGoods[]=$GLOBALS['db']->getAll($sql);  
		    
		
	}
		foreach($tmpGoods as $tmpGoodsVal) /*因为vip要上下一样。所以商品列表要以V1，V2，V3，V4,V1，V2，V3，V4组合*/
		{
			if(!$tmpGoodsVal[0]) continue;
			$tmpGoodsVal[0]['user_price'] = price_format($tmpGoodsVal[0]['user_price']);
			$tmpGoodsVal[0]['shop_price'] = price_format($tmpGoodsVal[0]['shop_price']);
			$tmpGoodsVal[0]['market_price'] = price_format($tmpGoodsVal[0]['market_price']);
			$tmpGoodsVal[0]['url'] = build_uri('vip_goods',array('act' => 'view', 'id' => $tmpGoodsVal[0]['goods_id']));
			$more_goods[] = $tmpGoodsVal[0];
		}
		foreach($tmpGoods as $tmpGoodsVal)
		{
			  if(!$tmpGoodsVal[1]) continue;
			  $tmpGoodsVal[1]['user_price'] = price_format($tmpGoodsVal[1]['user_price']);
			  $tmpGoodsVal[1]['shop_price'] = price_format($tmpGoodsVal[1]['shop_price']);
			$tmpGoodsVal[1]['market_price'] = price_format($tmpGoodsVal[1]['market_price']);
			$tmpGoodsVal[1]['url'] = build_uri('vip_goods',array('act' => 'view', 'id' => $tmpGoodsVal[1]['goods_id']));
			   $more_goods[] = $tmpGoodsVal[1];
		}
  }
  else if($type == 'integral_buy')
{
     $sql =  'SELECT g.goods_id, g.goods_name, vg.begin_time,g.market_price, g.shop_price, g.goods_name_style, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('vip_goods') . ' AS vg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = vg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE   vg.is_integral_buy = 1 AND vg.is_exchange = 1 AND g.is_delete = 0 AND is_next = 0 order by g.shop_price DESC limit 8;';
        $more_goods=$GLOBALS['db']->getAll($sql);
		foreach($more_goods as $more_goodsKey => $more_goodsVal)
		{
        $sql = "select rank_name,user_price,user_integral from ".$GLOBALS['ecs']->table('vip_member_price')." as vmp ".
		       " join ".$GLOBALS['ecs']->table('user_rank')." as ur on vmp.user_rank=ur.rank_id".
               " where goods_id=".$more_goodsVal['goods_id']." and ur.rank_id in(7,4,5,6)";
			   $vip_goods = $GLOBALS['db']->getAll($sql);
			
			   foreach($vip_goods as $k => $v)
			   {
			     $vip_goods[$k]['user_price'] = price_format($v['user_price']); 
			   }
		$more_goods[$more_goodsKey]['market_price'] =  price_format($more_goods[$more_goodsKey]['market_price']);
		$more_goods[$more_goodsKey]['shop_price'] =  price_format($more_goods[$more_goodsKey]['shop_price']);
        $more_goods[$more_goodsKey]['vip_goods'] = $vip_goods;	
		$more_goods[$more_goodsKey]['url'] = build_uri('vip_goods',array('act' => 'view', 'id' => $more_goods[$more_goodsKey]['goods_id']));			
		
		}
}  
	return $more_goods;
}


function get_more_vip_goods_goods($type='vip_only',$where_type, $page_size, $start)
{


 if($type == 'vip_only')
  {
  
$sql =  'SELECT ur.rank_name,vmp.user_price,g.goods_id, g.goods_name, vg.begin_time,g.market_price, g.shop_price, g.goods_name_style, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('vip_goods') . ' AS vg ' .
			'JOIN ' . $GLOBALS['ecs']->table('vip_member_price') . ' AS vmp on vmp.goods_id = vg.goods_id '.
			" join ".$GLOBALS['ecs']->table('user_rank')." as ur on vmp.user_rank = ur.rank_id ".
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = vg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE  vg.is_integral_buy = 0 AND vg.is_exchange = 1 AND g.is_delete = 0 AND is_next = 0 ';
	
       
		
		 $res = $GLOBALS['db']->SelectLimit($sql, $page_size, $start);
			
			$more_goods=array();
		while ($row = $GLOBALS['db']->fetchRow($res))
		{
			$row['user_price'] = price_format($row['user_price']);
			$row['shop_price'] = price_format($row['shop_price']);
			$row['market_price'] = price_format($row['market_price']);
			$row['url'] = build_uri('vip_goods',array('act' => 'view', 'id' => $row['goods_id']));			
		
			$more_goods[]=$row;

		}   



  }
  else if($type == 'integral_buy')
{
     $sql =  'SELECT g.goods_id, g.goods_name, vg.begin_time,g.market_price, g.shop_price, g.goods_name_style, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('vip_goods') . ' AS vg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = vg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE   vg.is_integral_buy = 1 AND vg.is_exchange = 1 AND g.is_delete = 0 AND is_next = 0 ORDER BY g.shop_price DESC';
       
		
		 $res = $GLOBALS['db']->SelectLimit($sql, $page_size, $start);
			
			$more_goods=array();
			while ($row = $GLOBALS['db']->fetchRow($res))
    {
			$row['shop_price'] = price_format($row['shop_price']);
			$row['market_price'] = price_format($row['market_price']);
			
		 $sql = "select rank_name,user_price,user_integral from ".$GLOBALS['ecs']->table('vip_member_price')." as vmp ".
		       " join ".$GLOBALS['ecs']->table('user_rank')." as ur on vmp.user_rank=ur.rank_id".
               " where goods_id=".$row['goods_id']." and ur.rank_id in(7,4,5,6)";
			   $vip_goods = $GLOBALS['db']->getAll($sql);
			
			  foreach($vip_goods as $k => $v)
			   {
			     $vip_goods[$k]['user_price'] = price_format($v['user_price']); 
			   }
			$row['vip_goods'] = $vip_goods;	
			$row['url'] = build_uri('vip_goods',array('act' => 'view', 'id' => $row['goods_id']));	
			$more_goods[]=$row;
		 

	}    
}  
 
	return $more_goods;
}

function get_user_rank_list()
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('user_rank') .
           " where special_rank != 1 ORDER BY min_points";

    return $GLOBALS['db']->getAll($sql);
}
/*如果下期预告的时间已经到了，将其更新。*/
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
