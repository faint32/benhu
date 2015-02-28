<?php

/**
 * ECSHOP 团购商品前台文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: group_buy.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
 // $now = gmtime();
  //echo local_date("Y-m-d H:i:s",$now); exit();
/*------------------------------------------------------ */
//-- act 操作项的初始化
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
function addDate($arr)
{
    for($i=0;$i<count($arr);$i++)
    {
      $arr[$i]['groupStaDt']=local_date("Y-m-d H:i:s",$arr[$i]['start_date']);
     // echo local_date("Y-m-d H:i:s",$arr[$i]['start_date']);
   //   echo "<br>";
    }
  //  print_r($arr);exit();
  return $arr;
}
//换一批
if($_REQUEST['act'] == 'change')
{
   $group_type = $_REQUEST['group_type'];
   $now = gmtime();
    $comm = "SELECT b.*,g.market_price, IFNULL(g.goods_thumb, '') AS goods_thumb, g.shop_price,b.act_id AS group_buy_id, ". "b.start_time AS start_date, b.end_time AS end_date " . "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS b " ."LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id  WHERE b.act_type = '" . GAT_GROUP_BUY."'";
   $arr=array();
   if($group_type=='today')
   {
     $arr[0]="today";
     $sql_today_mather =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=0  and brand_buy=0 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
     $today_mather = group_buy_list($sql_today_mather);
     $sql_today_baby =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=1  and brand_buy=0 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
     $today_baby = group_buy_list($sql_today_baby);  
     $arr[1]=$today_mather;
     $arr[2]= $today_baby;
	
    // print_r($today_baby);
   }
   else if($group_type=='brand')
   {
       $arr[0]="brand";
     $sql_brand_mather =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=0  and brand_buy=1 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
     $brand_mather = group_buy_list($sql_brand_mather);
     $sql_brand_baby =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=1  and brand_buy=1 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
     $brand_baby = group_buy_list($sql_brand_baby);  
     $arr[1]=$brand_mather;
     $arr[2]= $brand_baby;
   }
   else if($group_type=='not_start')
   {
       $arr[0]="not_start";
     $sql_not_start_mather =  $comm . " AND b.start_time > '$now'  and group_buy_type=0   AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
     $not_start_mather = group_buy_list($sql_not_start_mather);
     $sql_not_start_baby =  $comm . " AND b.start_time > '$now'  and group_buy_type=1   AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
     $not_start_baby = group_buy_list($sql_not_start_baby);  
     $arr[1]=$not_start_mather;
     $arr[2]= $not_start_baby;
   }
  echo json_encode($arr);
  //exit();
//  echo  json_encode($arr[1]);
 // echo  json_encode($arr[2]);

	
}
/*------------------------------------------------------ */
//-- 团购商品 --> 团购活动商品列表
/*------------------------------------------------------ */
else if ($_REQUEST['act'] == 'list')
{

    /* 取得团购活动总数 */
    $count = group_buy_count();
    if ($count > 0)
    {
        /* 取得每页记录数 */
        $size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

        /* 计算总页数 */
        $page_count = ceil($count / $size);

        /* 取得当前页 */
        $page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
        $page = $page > $page_count ? $page_count : $page;

        /* 缓存id：语言 - 每页记录数 - 当前页 */
        $cache_id = $_CFG['lang'] . '-' . $size . '-' . $page;
        $cache_id = sprintf('%X', crc32($cache_id));
    }
    else
    {
        /* 缓存id：语言 */
        $cache_id = $_CFG['lang'];
        $cache_id = sprintf('%X', crc32($cache_id));
    }
    /* 如果没有缓存，生成缓存 */

    if (!$smarty->is_cached('group_buy_list.dwt', $cache_id))
    {
        if ($count > 0)
        {
            /* 取得当前页的团购活动 */
         $now = gmtime();
     
        $comm = "SELECT b.*,g.market_price, IFNULL(g.goods_thumb, '') AS goods_thumb, g.shop_price,b.act_id AS group_buy_id, ". "b.start_time AS start_date, b.end_time AS end_date " . "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS b " ."LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id  WHERE b.act_type = '" . GAT_GROUP_BUY."'";
         $sql_today_mather =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=0  and brand_buy=0 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
            $today_mather = group_buy_list($sql_today_mather);
           $sql_today_baby =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=1  and brand_buy=0 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
            $today_baby = group_buy_list($sql_today_baby);
            

            $sql_brand_mum =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=0  and brand_buy=1 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
            $brand_mum = group_buy_list($sql_brand_mum);
            $sql_brand_baby =  $comm . " AND b.start_time <= '$now' AND b.end_time > '$now' and group_buy_type=1 and brand_buy=1 AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
            $brand_baby = group_buy_list($sql_brand_baby);  
            

            $sql_notStart_mum =  $comm . " AND b.start_time > '$now' AND b.end_time > '$now' and group_buy_type=0  AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
            $notStart_mum = group_buy_list($sql_notStart_mum);
            $sql_notStart_baby =  $comm . " AND b.start_time > '$now' AND b.end_time > '$now' and group_buy_type=1  AND b.is_finished < 3 ORDER BY RAND() LIMIT 8";//
            $notStart_baby = group_buy_list($sql_notStart_baby);  
              $notStart_mum=addDate($notStart_mum);
              $notStart_baby=addDate($notStart_baby);
            $smarty->assign('today_mather',  $today_mather);
             $smarty->assign('today_baby',  $today_baby);
              $smarty->assign('brand_mum',  $brand_mum);
             $smarty->assign('brand_baby',  $brand_baby);
                $smarty->assign('notStart_mum',  $notStart_mum);
             $smarty->assign('notStart_baby',  $notStart_baby);
        }

        /* 模板赋值 */
        $smarty->assign('cfg', $_CFG);
        assign_template();
        $position = assign_ur_here();
        
        $smarty->assign('page_title', $position['title']);    // 页面标题
        $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置
        $smarty->assign('categories', get_categories_tree()); // 分类树
        $smarty->assign('helps',      get_shop_help());       // 网店帮助
        $smarty->assign('top_goods',  get_top10());           // 销售排行
        $smarty->assign('script_name',  'group');          
        $smarty->assign('promotion_info', get_promotion_info());
        $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typegroup_buy.xml" : 'feed.php?type=group_buy'); // RSS URL
        assign_dynamic('group_buy_list');
    }

    /* 显示模板 */
    $smarty->display('group_buy_list.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- 团购商品 --> 商品详情
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{

    /* 取得参数：团购活动id */
    $group_buy_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ($group_buy_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 取得团购活动信息 */
    $group_buy = group_buy_info($group_buy_id);
	

    if (empty($group_buy))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 缓存id：语言，团购活动id，状态，（如果是进行中）当前数量和是否登录 */
    $cache_id = $_CFG['lang'] . '-' . $group_buy_id . '-' . $group_buy['status'];
    if ($group_buy['status'] == GBS_UNDER_WAY)
    {
        $cache_id = $cache_id . '-' . $group_buy['valid_goods'] . '-' . intval($_SESSION['user_id'] > 0);
    }
    $cache_id = sprintf('%X', crc32($cache_id));
	
	
	////////////////////////
	//var_dump(get_goods_gallery($group_buy['goods_id']));
   //   $cache_id = rand();
	  

    /* 如果没有缓存，生成缓存 */
    if (!$smarty->is_cached('group_buy_goods.dwt', $cache_id))
    {
        $group_buy['gmt_end_date'] = $group_buy['end_date'];
        $smarty->assign('group_buy', $group_buy);

        /* 取得团购商品信息 */
        $goods_id = $group_buy['goods_id'];
        $goods = goods_info($goods_id);
		
		
        /* 读评论信息 */
        $smarty->assign('id',           $goods_id);
        $smarty->assign('type',         0);

        if (empty($goods))
        {
            ecs_header("Location: ./\n");
            exit;
        }
        $goods['url'] = build_uri('goods', array('gid' => $goods_id), $goods['goods_name']);
        $smarty->assign('gb_goods', $goods);
  
	   
        /* 取得商品的规格 */
        $properties = get_goods_properties($goods_id);
        $smarty->assign('specification', $properties['spe']); // 商品规格
		$smarty->assign('pictures',            get_goods_gallery($goods_id));                    // 商品相册
		
          $smarty->assign('properties',  $properties['pro']);    // 商品属性
        //模板赋值
        $smarty->assign('cfg', $_CFG);
        assign_template();
        $position = assign_ur_here(0, $goods['goods_name']);
		  $smarty->assign('goods_id',   $group_buy['goods_id']);
		  $smarty->assign('now_time',  gmtime());
		  $smarty->assign('end_date',   $group_buy['end_date']);
		  $smarty->assign('recently_buy', recently_buy());
		 $fuwu = $db->getOne("SELECT content FROM " . $ecs->table('article') . " WHERE article_id =52 " );//售后服务
        $smarty->assign('fuwu',          $fuwu);  
		$smarty->assign('goods_number', $group_buy['goods_number']);  //库存量 
        $smarty->assign('page_title', $position['title']);    // 页面标题
        $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置
		$smarty->assign('sale_history', getsales_history($goods_id));        //获取购买历史记录
        $smarty->assign('hot_goods',  get_recommend_goods('hot'));     // 最热商品
        $smarty->assign('script_name',  'group');
        $smarty->assign('categories', get_categories_tree()); // 分类树
        $smarty->assign('helps',      get_shop_help());       // 网店帮助
        $smarty->assign('top_goods',  get_top10());           // 销售排行
        $smarty->assign('promotion_info', get_promotion_info());
        $smarty->assign('comment_percent',     comment_percent($goods_id));  //获取评分
        assign_dynamic('group_buy_goods');
    }

    //更新商品点击次数
    $sql = 'UPDATE ' . $ecs->table('goods') . ' SET click_count = click_count + 1 '.
           "WHERE goods_id = '" . $group_buy['goods_id'] . "'";
    $db->query($sql);

    $smarty->assign('now_time',  gmtime());           // 当前系统时间
    $smarty->display('group_buy_goods.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- 团购商品 --> 购买
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'buy')
{
    /* 查询：判断是否登录 */
    if ($_SESSION['user_id'] <= 0)
    {
        show_message($_LANG['gb_error_login'], '', '', 'error');
    }

    /* 查询：取得参数：团购活动id */
    $group_buy_id = isset($_POST['group_buy_id']) ? intval($_POST['group_buy_id']) : 0;
    if ($group_buy_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 查询：取得数量 */
    $number = isset($_POST['number']) ? intval($_POST['number']) : 1;
    $number = $number < 1 ? 1 : $number;

    /* 查询：取得团购活动信息 */
    $group_buy = group_buy_info($group_buy_id, $number);
    if (empty($group_buy))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 查询：检查团购活动是否是进行中 */
    if ($group_buy['status'] != GBS_UNDER_WAY)
    {
        show_message($_LANG['gb_error_status'], '', '', 'error');
    }

    /* 查询：取得团购商品信息 */
    $goods = goods_info($group_buy['goods_id']);
    
    if (empty($goods))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 查询：判断数量是否足够 */
    if (($group_buy['restrict_amount'] > 0 && $number > ($group_buy['restrict_amount'] - $group_buy['valid_goods'])) || $number > $goods['goods_number'])
    {
        show_message($_LANG['gb_error_goods_lacking'], '', '', 'error');
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
    if ($specs)
    {
        $_specs = explode(',', $specs);
        $product_info = get_products_info($goods['goods_id'], $_specs);
    }

    empty($product_info) ? $product_info = array('product_number' => 0, 'product_id' => 0) : '';

    /* 查询：判断指定规格的货品数量是否足够 */
    if ($specs && $number > $product_info['product_number'])
    {
        show_message($_LANG['gb_error_goods_lacking'], '', '', 'error');
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
    include_once(ROOT_PATH . 'includes/lib_order.php');
    clear_cart(CART_GROUP_BUY_GOODS);

    /* 更新：加入购物车 */
    $goods_price = $group_buy['deposit'] > 0 ? $group_buy['deposit'] : $group_buy['cur_price'];
    $cart = array(
        'user_id'        => $_SESSION['user_id'],
        'session_id'     => SESS_ID,
        'goods_id'       => $group_buy['goods_id'],
        'product_id'     => $product_info['product_id'],
        'goods_sn'       => addslashes($goods['goods_sn']),
        'goods_name'     => addslashes($goods['goods_name']),
        'market_price'   => $goods['market_price'],
        'goods_price'    => $goods_price,
        'goods_number'   => $number,
        'goods_attr'     => addslashes($goods_attr),
        'goods_attr_id'  => $specs,
        'is_real'        => $goods['is_real'],
        'extension_code' => addslashes($goods['extension_code']),
        'parent_id'      => 0,
        'rec_type'       => CART_GROUP_BUY_GOODS,
        'is_gift'        => 0
    );
    $db->autoExecute($ecs->table('cart'), $cart, 'INSERT');

    /* 更新：记录购物流程类型：团购 */
    $_SESSION['flow_type'] = CART_GROUP_BUY_GOODS;
    $_SESSION['extension_code'] = 'group_buy';
    $_SESSION['extension_id'] = $group_buy_id;

    /* 进入收货人页面 */
    ecs_header("Location: ./flow.php?step=consignee\n");
    exit;
}
/*取得最近30天：购买的人数和交易中的人数*/
function recently_buy()
{
$mothBef = gmtime() - 60*60*24*30;
//$mothbef = strtotime("last month");
//echo "now == ".gmtime()."   mothbef==".$mothBef."<br/>";
//echo "一个月前:".date("Y-m-d",strtotime("last month"));   

$trading_sql = "SELECT COUNT(*) " .
            "FROM " . $GLOBALS['ecs']->table('order_info') .
            "WHERE order_status=0 and add_time >=".$mothBef;
$traded_sql = "SELECT COUNT(*) " .
            "FROM " . $GLOBALS['ecs']->table('order_info') .
            "WHERE order_status=1 and add_time >=".$mothBef;
			//echo $trading_sql.'<br/>';
			//echo $traded_sql;
			$recently_buy=array();
			$recently_buy['trading']=$GLOBALS['db']->getOne($trading_sql);
			$recently_buy['traded']=$GLOBALS['db']->getOne($traded_sql);
			return $recently_buy;
}
/* 取得团购活动总数 */
function group_buy_count()
{
    $sql = "SELECT COUNT(*) " .
            "FROM " . $GLOBALS['ecs']->table('goods_activity') .
            "WHERE act_type = '" . GAT_GROUP_BUY . "' " .
            " AND is_finished < 3";
    return $GLOBALS['db']->getOne($sql);
}

function getsales_history($goods_id){
$sql ='select f.consignee, f.pay_fee, g.goods_number, f.add_time,g.goods_attr FROM '. $GLOBALS['ecs']->table('order_goods') .' as g,'. $GLOBALS['ecs']->table('order_info') .' as f where g.order_id = f.order_id and g.goods_id='.$goods_id;
//echo $sql;
$res = $GLOBALS['db']->getAll($sql);
$sales_history = array();
foreach ($res AS $idx => $row){
   $sales_history[$idx]['consignee']       = $row['consignee'];
   $sales_history[$idx]['pay_fee']       = $row['pay_fee'];
   $sales_history[$idx]['goods_number']       = $row['goods_number'];
   $sales_history[$idx]['add_time']       =  local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
  // $sales_history[$idx]['add_time']       = local_date("Y-m-d", $row['add_time']);
   $sales_history[$idx]['goods_attr']       = $row['goods_attr'];
}
  return $sales_history;
}

/**
 * 根据sql语句获取团购活动列表
 * @param   string     $sql   sql查询语句
 * @return  array
 */
function group_buy_list($sql)
{
    /* 取得团购活动 */
    $gb_list = array();
   
          //  echo $sql;exit();
    $res = $GLOBALS['db']->query($sql);
    while ($group_buy = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($group_buy['ext_info']);
        $group_buy = array_merge($group_buy, $ext_info);

        /* 格式化时间 */
        $group_buy['formated_start_date']   = local_date($GLOBALS['_CFG']['time_format'], $group_buy['start_date']);
        $group_buy['formated_end_date']     = local_date($GLOBALS['_CFG']['time_format'], $group_buy['end_date']);

        /* 格式化保证金 */
        $group_buy['formated_deposit'] = price_format($group_buy['deposit'], false);
        
        /*商品原价*/
        $group_buy['shop_price'] = price_format($group_buy['shop_price'], false);

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
        
        /*团购节省和折扣计算 by ecmoban start*/
        $price    = $group_buy['market_price']; //原价 
        $nowprice = $group_buy['price_ladder'][0]['price']; //现价
        $group_buy['jiesheng'] = $price-$nowprice; //节省金额 
        if($nowprice > 0)
        {
            $group_buy['zhekou'] = round(10 / ($price / $nowprice), 1);
        }
        else 
        { 
            $group_buy['zhekou'] = 0;
        }
        $stat = group_buy_stat($group_buy['act_id'], $ext_info['deposit']);
        $group_buy['cur_amount'] = $stat['valid_goods'];         // 当前数量
        
        /* 处理图片 */
        if (empty($group_buy['goods_thumb']))
        {
            $group_buy['goods_thumb'] = get_image_path($group_buy['goods_id'], $group_buy['goods_thumb'], true);
        }
        /* 处理链接 */
        $group_buy['url'] = build_uri('group_buy', array('gbid'=>$group_buy['group_buy_id']));
        /* 加入数组 */
        $gb_list[] = $group_buy;
    }

    return $gb_list;
}

?>