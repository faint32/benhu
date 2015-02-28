<?php

/**
 * ECSHOP 首页文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z liubo $
*/


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');



if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}



/*------------------------------------------------------ */
//-- Shopex系统地址转换
/*------------------------------------------------------ */
if (!empty($_GET['gOo']))
{
    if (!empty($_GET['gcat']))
    {
        /* 商品分类。*/
        $Loaction = 'category.php?id=' . $_GET['gcat'];
    }
    elseif (!empty($_GET['acat']))
    {
        /* 文章分类。*/
        $Loaction = 'article_cat.php?id=' . $_GET['acat'];
    }
    elseif (!empty($_GET['goodsid']))
    {
        /* 商品详情。*/
        $Loaction = 'goods.php?id=' . $_GET['goodsid'];
    }
    elseif (!empty($_GET['articleid']))
    {
        /* 文章详情。*/
        $Loaction = 'article.php?id=' . $_GET['articleid'];
    }

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }
}

//判断是否有ajax请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'cat_rec')
{
    $rec_array = array(1 => 'best', 2 => 'new', 3 => 'hot');
    $rec_type = !empty($_REQUEST['rec_type']) ? intval($_REQUEST['rec_type']) : '1';
    $cat_id = !empty($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '0';
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'content' => '', 'type' => $rec_type, 'cat_id' => $cat_id);

    $children = get_children($cat_id);
    $smarty->assign($rec_array[$rec_type] . '_goods',      get_category_recommend_goods($rec_array[$rec_type], $children));    // 推荐商品
    $smarty->assign('cat_rec_sign', 1);
    $result['content'] = $smarty->fetch('library/recommend_' . $rec_array[$rec_type] . '.lbi');
    die($json->encode($result));
}
else if($act == 'babyGrowth')
{    
   include_once('includes/cls_json.php');
   $json = new JSON;
  
   $arr_ages = get_arr_ages();
   
   $catId = $_REQUEST['cat_id'] ? $_REQUEST['cat_id'] : 0;
   $age_index = $_REQUEST['age_index'] ? $_REQUEST['age_index'] : 0;
   $age =  $arr_ages[$age_index];
   
   $ele_id = $_REQUEST['ele_id'] ? $_REQUEST['ele_id'] : '';
   $goods = get_cat_goods($catId, $age);	
	
die($json->encode(array('ele_id'=>$ele_id,'goods'=>$goods)));
}
function get_cat_goods($cat,$age){  //首页获取热销的商品
	
	
	//获取所有的商品 
			$age=($age==0)?'':' AND (is_age =0 OR is_age = '.$age.')';
		
		$cnt_children_goods=get_children_pro_goods_num($cat,$age);
		  $fen = array();
		foreach($cnt_children_goods as $proId => $queryNum)
		{
		if($queryNum == 0) continue;
		   $sql = 'SELECT goods_id, goods_name,market_price,shop_price,goods_thumb FROM ' .$GLOBALS['ecs']->table("goods") . 
		' WHERE '.'cat_id = '.$proId.$age.' order by rand() LIMIT 0, '.$queryNum;
		
		 $tmp = $GLOBALS['db']->getAll($sql);
	
		  foreach($tmp as $val)
		  {
		  $val['url'] = build_uri('goods', array('gid' => $val['goods_id']), $val['goods_name']);
		    $fen[] = $val;
		  }
		}
		return $fen;
}
/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('index.dwt', $cache_id))
{
    assign_template();
    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置


    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash轮播图片模板

    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL
	
	$smarty->assign('notice',      get_articles_cat_name('公告',3)); // 分类树

	$smarty->assign('news',      get_articles_cat_name('新闻',3)); // 分类树
	
    $smarty->assign('categories',      get_categories_tree_pro()); // 分类树
    $smarty->assign('helps',           get_shop_help());       // 网店帮助
    $smarty->assign('top_goods',       get_top10());           // 销售排行

    $smarty->assign('best_goods',      get_recommend_goods('best'));    // 推荐商品
    $smarty->assign('new_goods',       get_recommend_goods('new'));     // 最新商品
    $smarty->assign('hot_goods',       get_recommend_goods('hot'));     // 最热商品


    $smarty->assign('promotion_goods', get_promote_goods()); // 特价商品
   // print_r($promotion_goods);

    $smarty->assign('brand_list',      get_brands());
	
	$smarty->assign('brand_list_index',      get_brands_index());
	$smarty->assign('group_buy_list_index',      group_buy_list_index());

    $smarty->assign('promotion_info',  get_promotion_info()); // 增加一个动态显示所有促销信息的标签栏

    $smarty->assign('invoice_list',    index_get_invoice_query());  // 发货查询
		
    $smarty->assign('group_buy_goods',index_get_group_buy());      // 团购商品
    $smarty->assign('auction_list',    index_get_auction());        // 拍卖活动
    $smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	
	/*
	echo "<pre>";
    print_r(index_get_group_buy());
    echo "</pre>";
*/
	$smarty->assign('script_name', 'index');

	for($i=1;$i<=$_CFG['cat_ad'];$i++)
	{
		$ad_arr .= "'c".$i.",";
	}

	$smarty->assign('adarr',       $ad_arr); // 分类广告位

    /* links */
    $links = index_get_links();
    $smarty->assign('img_links',       $links['img']);
    $smarty->assign('txt_links',       $links['txt']);
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录

    /* 首页推荐分类 */
    $cat_recommend_res = $db->getAll("SELECT c.cat_id, c.cat_name, cr.recommend_type FROM " . $ecs->table("cat_recommend") . " AS cr INNER JOIN " . $ecs->table("category") . " AS c ON cr.cat_id=c.cat_id");
    if (!empty($cat_recommend_res))
    {
        $cat_rec_array = array();
        foreach($cat_recommend_res as $cat_recommend_data)
        {
            $cat_rec[$cat_recommend_data['recommend_type']][] = array('cat_id' => $cat_recommend_data['cat_id'], 'cat_name' => $cat_recommend_data['cat_name']);
        }
        $smarty->assign('cat_rec', $cat_rec);
    }
    
    /* 首页banner */
    $banner = $db->getAll('SELECT ad_code, ad_link FROM ' . $ecs->table("ad") . ' WHERE position_id = 1 ORDER BY ad_id DESC LIMIT 0,6 ');
   $smarty->assign('banner', $banner);
   
   /* 首页公告 */
    $gao = $db->getAll('SELECT article_id, title FROM ' . $ecs->table("article") . ' WHERE cat_id = 12 AND is_open = 1 ORDER BY add_time DESC LIMIT 0,5 ');
   // print_r($gao);
   foreach($gao as $gaoKey => $gaoval)
   {
   $gao[$gaoKey]['url'] = build_uri('article', array('aid' => $gaoval['article_id']), $gaoval['title']);
   }
   $smarty->assign('gao', $gao);
   
   /* 首页新闻 */
    $news = $db->getAll('SELECT article_id, title FROM ' . $ecs->table("article") . ' WHERE cat_id = 4 ORDER BY add_time DESC LIMIT 0,5 ');
   // print_r($news);
   $smarty->assign('news', $news);
   /* 育儿知识09-22*/
	$yus = $db->getAll('SELECT cat_id FROM ' . $ecs->table("article_cat") . ' WHERE parent_id = 22');
	foreach($yus as $a){
		$yu[]=$a[cat_id];
	}
	//print_r($yu);
	$yu=implode(',',$yu);
	$yu = $db->getAll('SELECT a.*,b.cat_name FROM ' . $ecs->table("article") . 'AS a LEFT JOIN'.$ecs->table("article_cat") .' AS b on a.cat_id=b.cat_id WHERE a.cat_id in('.$yu.') ORDER BY a.add_time DESC LIMIT 6');
	
	
	foreach($yu as $yuKey => $yuVal)
	{
		$yu[$yuKey]['content'] = strip_tags($yuVal['content']);
	 $yu[$yuKey]['url'] = build_uri('article', array('aid' => $yuVal['article_id']), $yuVal['title']);
	}
	
	$smarty->assign('yu', $yu);
	//echo $yu;
 

/*  
	age_0:孕前孕后---母乳喂养用品977、外出用品981、妈妈洗护用品1000
	age_1:0-3月---奶瓶881、宝宝配饰784、寝具653
	age_2:3-6月---（宝宝）护理664、寝具653、奶瓶881
	age_3:6-12月---学饮杯887、图书941、宝宝外出服780
	age_4:1-3岁---宝宝外出服780、餐具885、图书941
	age_5:3岁+ ---宝宝外出服780、哺育喂养879、玩具图书828
 */  
   $goods_baby = array();
   $arr_cartId = get_arr_cartId();
   $arr_ages = get_arr_ages();
  for($i = 0; $i < count($arr_cartId); $i++)
  {
   
    $goods_baby[$i] = get_goods($arr_cartId[$i], $arr_ages[$i]);	
	$goods_baby[$i][0]['age_index'] = $arr_ages[$i];
  }
 // var_dump($goods_baby[0]);
   $smarty->assign('goods_baby', $goods_baby);
   $smarty->assign('num', array(0,1,2,3,4,5));

   
    
	//猜你喜欢 随机出   标记有精品的商品is_best=1 guan
    $cai = $db->getALL('SELECT g.goods_id,g.goods_name,g.market_price,g.shop_price,g.goods_thumb,sum(o.goods_number) as num FROM ' . $ecs->table("goods") .'AS g,'. $ecs->table("order_goods") . ' AS o WHERE g.goods_id=o.goods_id AND g.is_best=1 ORDER BY RAND() LIMIT 1 ');
  foreach($cai as $caiKey => $caiVal)
{
  $cai[$caiKey]['url'] = build_uri('goods', array('gid' => $caiVal['goods_id']), $caiVal['goods_name']);
}  
   $smarty->assign('cai', $cai);

	/* 首页右一右二广告位 position_id=3,4 */
    $you = $db->getAll('SELECT ad_code,ad_link,position_id FROM ' . $ecs->table("ad") . ' WHERE position_id in(3,4) ORDER BY ad_id DESC LIMIT 2 ');
   $smarty->assign('you', $you);

    /* 页面中的动态内容 */
    assign_dynamic('index');
}
$smarty->display('index.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */
function get_arr_ages()
{
return array(0,1,2,3,4,5);
}
function get_arr_cartId()
{
	return array(array(390,657,879),array(657,879,776),array(776,828,879),array(828,879,657),array(657,776,879),array(776,828,657));
// return array(array(977,981,1000),array(881,784,653),array(664,653,881),array(887,941,780),array(780,885,941),array(780,879,828));
}
/**
 * 调用发货单查询
 *
 * @access  private
 * @return  array
 */
function index_get_invoice_query()
{
    $sql = 'SELECT o.order_sn, o.invoice_no, s.shipping_code FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o' .
            ' LEFT JOIN ' . $GLOBALS['ecs']->table('shipping') . ' AS s ON s.shipping_id = o.shipping_id' .
            " WHERE invoice_no > '' AND shipping_status = " . SS_SHIPPED .
            ' ORDER BY shipping_time DESC LIMIT 10';
    $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key => $row)
    {
        $plugin = ROOT_PATH . 'includes/modules/shipping/' . $row['shipping_code'] . '.php';

        if (file_exists($plugin))
        {
            include_once($plugin);

            $shipping = new $row['shipping_code'];
            $all[$key]['invoice_no'] = $shipping->query((string)$row['invoice_no']);
        }
    }

    clearstatcache();

    return $all;
}

/**
 * 获得最新的文章列表。
 *
 * @access  private
 * @return  array
 */
function index_get_new_articles($cat_id)
{
    $sql = 'SELECT a.article_id, a.title, ac.cat_name, a.add_time, a.file_url, a.open_type, ac.cat_id, ac.cat_name ' .
            ' FROM ' . $GLOBALS['ecs']->table('article') . ' AS a, ' .
                $GLOBALS['ecs']->table('article_cat') . ' AS ac' .
            ' WHERE a.is_open = 1 AND a.cat_id = ac.cat_id AND ac.cat_type = 1 AND ac.cat_id=' .$cat_id.
            ' ORDER BY a.article_type DESC, a.add_time DESC LIMIT ' . $GLOBALS['_CFG']['article_number'];
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($res AS $idx => $row)
    {
        $arr[$idx]['id']          = $row['article_id'];
        $arr[$idx]['title']       = $row['title'];
        $arr[$idx]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
                                        sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
        $arr[$idx]['cat_name']    = $row['cat_name'];
        $arr[$idx]['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $arr[$idx]['url']         = $row['open_type'] != 1 ?
                                        build_uri('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
        $arr[$idx]['cat_url']     = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
    }

    return $arr;
}

/**
 * 获得最新的团购活动
 *
 * @access  private
 * @return  array
 */
function index_get_group_buy()
{
    $time = gmtime();
    $limit = get_library_number('group_buy', 'index');

    $group_buy_list = array();
    if ($limit > 0)
    {
        $sql = 'SELECT gb.act_id AS group_buy_id, gb.goods_id, gb.ext_info, gb.goods_name, g.goods_thumb, g.goods_img,g.shop_price,g.market_price,gb.start_time AS start_date, gb.end_time AS end_date  ' .
                'FROM ' . $GLOBALS['ecs']->table('goods_activity') . ' AS gb, ' .
                    $GLOBALS['ecs']->table('goods') . ' AS g ' .
                "WHERE gb.act_type = '" . GAT_GROUP_BUY . "' " .
                "AND g.goods_id = gb.goods_id " .
                "AND gb.start_time <= '" . $time . "' " .
                "AND gb.end_time >= '" . $time . "' " .
                "AND g.is_delete = 0 " .
                "ORDER BY gb.act_id DESC " .
                "LIMIT $limit" ;
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            /* 如果缩略图为空，使用默认图片 */
            $row['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $row['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);

            /* 根据价格阶梯，计算最低价 */
            $ext_info = unserialize($row['ext_info']);
            // $price_ladder = $ext_info['price_ladder'];
            $group_buy = array_merge($row, $ext_info);
            $price_ladder = $group_buy['price_ladder'];

			/* 格式化时间 */
			$row['formated_start_date']   = local_date($GLOBALS['_CFG']['time_format'], $row['start_date']);
			$row['formated_end_date']     = local_date($GLOBALS['_CFG']['time_format'], $row['end_date']);


           /* if (!is_array($price_ladder) || empty($price_ladder))
            {
                $row['last_price'] = price_format(0);
            }
            else
            {
                foreach ($price_ladder AS $amount_price)
                {
                    $price_ladder[$amount_price['amount']] = $amount_price['price'];
                }
            }
			*/
			if (!is_array($price_ladder) || empty($price_ladder))
			{
				$price_ladder = array(array('amount' => 0, 'price' => 0));
			}
			else
			{
				foreach ($price_ladder as $key => $amount_price)
				{
					$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
				}
			}

            //ksort($price_ladder);
			/*商品原价*/
            $row['shop_price'] = price_format($group_buy['shop_price'], false);
			
			$row['price_ladder'] = $price_ladder;
            $row['url'] = build_uri('group_buy', array('gbid' => $row['group_buy_id']));
            $row['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $row['short_style_name']   = add_style($row['short_name'],'');
            $group_buy_list[] = $row;
        }
    }

    return $group_buy_list;
}

/**
 * 取得拍卖活动列表
 * @return  array
 */
function index_get_auction()
{
    $now = gmtime();
    $limit = get_library_number('auction', 'index');
    $sql = "SELECT a.act_id, a.goods_id, a.goods_name, a.ext_info, g.goods_thumb ".
            "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS a," .
                      $GLOBALS['ecs']->table('goods') . " AS g" .
            " WHERE a.goods_id = g.goods_id" .
            " AND a.act_type = '" . GAT_AUCTION . "'" .
            " AND a.is_finished = 0" .
            " AND a.start_time <= '$now'" .
            " AND a.end_time >= '$now'" .
            " AND g.is_delete = 0" .
            " ORDER BY a.start_time DESC" .
            " LIMIT $limit";
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($row['ext_info']);
        $arr = array_merge($row, $ext_info);
        $arr['formated_start_price'] = price_format($arr['start_price']);
        $arr['formated_end_price'] = price_format($arr['end_price']);
        $arr['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr['url'] = build_uri('auction', array('auid' => $arr['act_id']));
        $arr['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($arr['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $arr['goods_name'];
        $arr['short_style_name']   = add_style($arr['short_name'],'');
        $list[] = $arr;
    }

    return $list;
}

/**
 * 获得所有的友情链接
 *
 * @access  private
 * @return  array
 */
function index_get_links()
{
    $sql = 'SELECT link_logo, link_name, link_url FROM ' . $GLOBALS['ecs']->table('friend_link') . ' ORDER BY show_order';
    $res = $GLOBALS['db']->getAll($sql);

    $links['img'] = $links['txt'] = array();

    foreach ($res AS $row)
    {
        if (!empty($row['link_logo']))
        {
            $links['img'][] = array('name' => $row['link_name'],
                                    'url'  => $row['link_url'],
                                    'logo' => $row['link_logo']);
        }
        else
        {
            $links['txt'][] = array('name' => $row['link_name'],
                                    'url'  => $row['link_url']);
        }
    }

    return $links;
}

function group_buy_list_index()
{
    /* 取得团购活动 */
    $gb_list = array();
    $now = gmtime();
    $sql = "SELECT b.*, IFNULL(g.goods_thumb, '') AS goods_thumb, b.act_id AS group_buy_id, ".
                "b.start_time AS start_date, b.end_time AS end_date,g.shop_price " .
            "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS b " .
                "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id " .
            "WHERE b.act_type = '" . GAT_GROUP_BUY . "' " .
            "AND b.start_time <= '$now' AND b.is_finished < 3 ORDER BY b.act_id DESC LIMIT 1";
	$res = $GLOBALS['db']->getAll($sql);

    foreach ($res as $group_buy)
    {
        $ext_info = unserialize($group_buy['ext_info']);
        $group_buy = array_merge($group_buy, $ext_info);
 		$group_buy['cur_amount'] = group_buy_stat($group_buy['act_id'], $group_buy['deposit']);
        /* 格式化时间 */
        $group_buy['formated_start_date']   = local_date($GLOBALS['_CFG']['time_format'], $group_buy['start_date']);
        $group_buy['formated_end_date']     = local_date($GLOBALS['_CFG']['time_format'], $group_buy['end_date']);
		
        /* 格式化保证金 */
        $group_buy['formated_deposit'] = price_format($group_buy['deposit'], false);

        /* 处理价格阶梯 */
        $price_ladder = $group_buy['price_ladder'];
        if (!is_array($price_ladder) || empty($price_ladder))
        {
            $price_ladder = array(array('amount' => 0, 'price' => 0));
        }
        else
        {
            foreach ($price_ladder as $key => $amount_price)
            {
                $price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
            }
        }
        $group_buy['price_ladder'] = $price_ladder;

        /* 处理图片 */
        if (empty($group_buy['goods_thumb']))
        {
            $group_buy['goods_thumb'] = get_image_path($group_buy['goods_id'], $group_buy['goods_thumb'], true);
        }
        /* 处理链接 */
        $group_buy['url'] = build_uri('group_buy', array('gbid'=>$group_buy['group_buy_id']));
        /* 加入数组 */
    }

    return $group_buy;
}
/* 获取广告数据列表 */
function get_adslist()
{
    /* 过滤查询 */
    $pid = !empty($_REQUEST['pid']) ? intval($_REQUEST['pid']) : 0;

    $filter = array();
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'ad.ad_name' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $where = 'WHERE 1 ';
    if ($pid > 0)
    {
        $where .= " AND ad.position_id = '$pid' ";
    }

    /* 获得总记录数据 */
    $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('ad'). ' AS ad ' . $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* 获得广告数据 */
    $arr = array();
    $sql = 'SELECT ad.*, COUNT(o.order_id) AS ad_stats, p.position_name '.
            'FROM ' .$GLOBALS['ecs']->table('ad'). 'AS ad ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('ad_position'). ' AS p ON p.position_id = ad.position_id '.
            'LEFT JOIN ' . $GLOBALS['ecs']->table('order_info'). " AS o ON o.from_ad = ad.ad_id $where " .
            'GROUP BY ad.ad_id '.
            'ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
         /* 广告类型的名称 */
         $rows['type']  = ($rows['media_type'] == 0) ? $GLOBALS['_LANG']['ad_img']   : '';
         $rows['type'] .= ($rows['media_type'] == 1) ? $GLOBALS['_LANG']['ad_flash'] : '';
         $rows['type'] .= ($rows['media_type'] == 2) ? $GLOBALS['_LANG']['ad_html']  : '';
         $rows['type'] .= ($rows['media_type'] == 3) ? $GLOBALS['_LANG']['ad_text']  : '';

         /* 格式化日期 */
         $rows['start_date']    = local_date($GLOBALS['_CFG']['date_format'], $rows['start_time']);
         $rows['end_date']      = local_date($GLOBALS['_CFG']['date_format'], $rows['end_time']);

         $arr[] = $rows;
    }
//print_r($arr);
    return array('ads' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/*推荐品牌*/
function brand($cat_id){
     $sql = "SELECT b.brand_id, b.brand_name, COUNT(*) AS goods_num ".
            "FROM " . $GLOBALS['ecs']->table('brand') . "AS b, ".
                $GLOBALS['ecs']->table('goods') . " AS g LEFT JOIN ". $GLOBALS['ecs']->table('goods_cat') . " AS gc ON g.goods_id = gc.goods_id " .
            "WHERE g.brand_id = b.brand_id AND ($children OR " . 'gc.cat_id ' . db_create_in(array_unique(array_merge(array($cat_id), array_keys(cat_list($cat_id, 0, false))))) . ") AND b.is_show = 1 " .
            " AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".
            "GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY b.sort_order, b.brand_id ASC";

    $brands = $GLOBALS['db']->getAll($sql);
    return $brands;
}

function get_cat_brands($cat = 0, $app = 'category')
{ //查询有logo的品牌名称
    $children = ($cat > 0) ? ' AND ' . get_children($cat) : '';
    $sql = "SELECT b.brand_id, b.brand_name, b.brand_logo, COUNT(g.goods_id) AS goods_num, IF(b.brand_logo > '', '1', '0') AS tag ".
            "FROM " . $GLOBALS['ecs']->table('brand') . "AS b, ".
                $GLOBALS['ecs']->table('goods') . " AS g ".
            "WHERE b.brand_logo !='' AND g.brand_id = b.brand_id $children " .
            "GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY tag DESC, b.sort_order ASC LIMIT 0,6";
    $row = $GLOBALS['db']->getAll($sql);
    foreach ($row AS $key => $val)
    {
        $row[$key]['url'] = build_uri($app, array('cid' => $cat, 'bid' => $val['brand_id']), $val['brand_name']);
    }
      
   return $row;
    
}
function get_goods($catid,$ages){  //首页获取热销的商品
	$arr=array();
	$all=array();
	$name=array();
	$id=array();
	foreach($catid as $key=>$cat){//获取所有的商品 
	                                      //array(977,981,1000)
			$fen1=get_children1($cat);  //cat_id IN ('977','477','1053','1054','1055')
					 
			$all[$key]['name_id']=$GLOBALS['db']->getAll('select cat_id,cat_name from ' . $GLOBALS['ecs']->table("category") .' where cat_id='.$cat) ;
		/*
		array
		  'cat_id' => string '977' (length=3)
		  'cat_name' => string '母乳喂养用品' (length=18)
	   */
		//var_dump($all[$key]['name_id']);exit;
		
			$age=$ages;
			$age=($age==0)?'':' AND (is_age =0 OR is_age = '.$age.')';
		
		$cnt_children_goods=get_children_pro_goods_num($cat,$age);
		  $fen = array();
		foreach($cnt_children_goods as $proId => $queryNum)
		{
		if($queryNum == 0) continue;
		   $sql = 'SELECT goods_id, goods_name,market_price,shop_price,goods_thumb FROM ' .$GLOBALS['ecs']->table("goods") . 
		' WHERE '.'cat_id = '.$proId.$age.' LIMIT 0, '.$queryNum;
		 $tmp = $GLOBALS['db']->getAll($sql);
		
		  foreach($tmp as $val)
		  {
		    $val['url'] = build_uri('goods', array('gid' => $val['goods_id']), $val['goods_name']);
		    $fen[] = $val;
		  }
		}
	$goods_recommend = $GLOBALS['db']->getAll('select a.cat_id,a.cat_name,b.recommend_type from ' . $GLOBALS['ecs']->table("category") .' AS a LEFT JOIN '.$GLOBALS['ecs']->table("cat_recommend").' AS b on b.cat_id=a.cat_id  where a.parent_id='.$cat.' AND b.recommend_type = 3 LIMIT 0,8' ) ;//获取品牌推荐分类，recommended_type为3的  热门推荐 guan
	
	 foreach($goods_recommend as $grKey => $grVal)
       {
	     $goods_recommend[$grKey]['url'] = build_uri('category', array('cid' => $grVal['cat_id']),$grVal['cat_name']);
		  //build_uri('article', array('aid' => $val['article_id']), $val['title']);; 
	   }
        $all[$key]['moreUrl'] = build_uri('category', array('cid' => $cat));
		$all[$key]['recommend'] = $goods_recommend;
		$all[$key]['goods']=$fen;
		$all[$key]['brands']=get_cat_brands($cat);
	}
	
    return $all;
}
function get_children_pro_goods_num($cat,$age)
{
    	$children_proId_list = get_children_pro($cat);  
         $cnt = 0;	
        $per_cnt = 10;		 
		foreach($children_proId_list as $proId )
		{
		   $sql = 'select goods_id from '.$GLOBALS['ecs']->table('goods').' where cat_id = '.$proId.$age;
		  if($GLOBALS['db']->getOne($sql))
		   {
		    $cnt_children_goods[$proId] = 1;
			$cnt ++;
		   }
		   else $cnt_children_goods[$proId] = 0;
		}
		if($cnt > $per_cnt)
		{
			uksort($cnt_children_goods,"uksort_cmp");
			foreach($cnt_children_goods as $k => $v)
			{
			  if( $v == 1)
			  {
			  $cnt_children_goods[$k] = 0;
			  $cnt --;
			  if($cnt <= $per_cnt) break;
			  }
			}
		}
		else if($cnt < $per_cnt)
		{
			foreach($cnt_children_goods as $k=>$v)
			{
			$cnt_children_goods[$k] = 0;
			}
			$cnt = 0;
		  foreach($children_proId_list as $proId )
		 {
		   $sql = 'select count(goods_id) from '.$GLOBALS['ecs']->table('goods').' where cat_id = '.$proId.$age;
		   $tmpCnt=$GLOBALS['db']->getOne($sql);
		   $cnt += $tmpCnt;
	
		   $cnt_children_goods[$proId] = $tmpCnt;
		 
		   if($cnt >= $per_cnt)
		   {
		     $cnt_children_goods[$proId] -= ($cnt-$per_cnt);
	         
			 break;
		   }
		 }
		}
	return $cnt_children_goods;
}
function uksort_cmp($a, $b)
{
 $tmp = rand(0,1);
    return ($tmp==0) ? -1 : 1;
}


?>