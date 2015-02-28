<?php
  function calcPackageBuyVal($index, &$goodsList)
  {
	$goodsList[$index]['packageBuy'] = 0;
    if($index == 0 && $goodsList[$index]['packageBuy_id'] !=0)
    {
		$goodsList[$index]['packageBuy'] = 1;
    }
	elseif($index > 0 && $goodsList[$index]['packageBuy_id'] !=0 && $goodsList[$index]['packageBuy_id'] != $goodsList[$index-1]['packageBuy_id'] )
	{
		$goodsList[$index]['packageBuy'] = 1;
	}
	else if($goodsList[$index]['packageBuy_id'] !=0 && $goodsList[$index]['packageBuy_id'] == $goodsList[$index-1]['packageBuy_id'])
	{
						$goodsList[$index]['packageBuy'] = 3;
						if($goodsList[$index-1]['packageBuy'] == 3)
						$goodsList[$index-1]['packageBuy'] == 2;
	}
  }
	 
function checkPackageBuyValid($goodsArr, &$result)
{
	    if(count($goodsArr) < 2)
		{
		   $result['error'] = 1;
		   $result['message'] = "请选择搭配商品！";
		  die(json_encode($result));
		}   
}	
 
 
 function getStaticPage()
 {
    $dynamicPgs = getDynamicPages();
	$staticPgs = array();
	
	foreach($dynamicPgs as $pg)
	{
		if(!empty($pg[1]))
		{
			$staticPgs[$pg[0].'-'.$pg[1]] = buildUriWithOneParamOrLess($pg[0],$pg[1]);
		}
		else
		{
			$staticPgs[$pg[0]] = buildUriWithOneParamOrLess($pg[0]);
		}
	}
 return $staticPgs;
 }
 
 function getDynamicPages()
 {
   return array(
		array('user','profile'),
		array('user','security_settings'),
		array('user','my_integral'),
		array('user','my_rank'),
		array('user','order_list'),
		array('user','address_list'),
		array('user','collection_list'),
		array('user','comment_list'),
		array('user','coupons'),
		array('user','complain_list'),
		array('user','return_goods'),
		array('user','logout'),
		array('user','register'),
		array('user','default'),
		array('user',''),
		array('user','get_password'),
		array('exchange','get'),
		array('index',''),
		array('exchange',''),
		array('vip_goods',''),
		array('flow','')
		);
	
	/*user.php\?act=profile
	user.php\?act=security_settings
	user.php\?act=my_integral
	user.php\?act=my_rank
	user.php\?act=order_list
				  address_list
	user.php\?act=collection_list
	user.php\?act=comment_list
	user.php\?act=complain_list
	user.php\?act=return_goods
	user.php\?act=logout
	user.php\?act=register
	user.php\?act=default
	user.php\?act=get_password
	
	
	exchange.php
	exchange.php?act=get
	exchange.php?id=1470&act=view
	
	vip_goods.php
	vip_goods.php?id=377&act=view
	
	flow.php
	*/
 }
 
 ?>