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

$packageBuyCorrosponding = packageBuyGoodsRelated();

//test();
function test()
{
$goodId = 1339;
     $sql = "SELECT  cat_id FROM ".$GLOBALS['ecs']->table('goods')." WHERE goods_id=1339";
    //echo $sql;
	$val = $GLOBALS['db']->getRow($sql);
	
	 $catId = $val['cat_id'];
	// echo '----catId=='.$catId.'----<br/>';
	 $packageBuyLinkedCatIds = getPackageBuyRelatedCatIds($catId);

	$linkedGoodsId = getLinkedGoodsId($packageBuyLinkedCatIds);
	setLinkedGoods(1339, $linkedGoodsId);
	exit;
}
     
	
	

$goodsList = getAllGoodsId(); 
foreach($goodsList as $val)
{
	$goodsId = $val['goods_id'];   $catId = $val['cat_id'];

	if(!isGoodCanSetPackageBuy($goodsId, $catId))
	   continue;
	
	if(isSetPackageBuyGoods($goodsId))
	{
	   var_dump("ID为'$goodsId'的商品已经设置过");
    	continue;
	}
	
	$packageBuyLinkedCatIds = getPackageBuyRelatedCatIds($catId);

	$linkedGoodsId = getLinkedGoodsId($packageBuyLinkedCatIds);
	
	setLinkedGoods($goodsId, $linkedGoodsId);
}

exit;

function setLinkedGoods($goodsId, $linkedGoodsId)
{
	foreach($linkedGoodsId as $val)
	{
	   $linkGoodsId = $val['goods_id'];
	   $sql = "INSERT INTO ".$GLOBALS['ecs']->table('link_goods')." values($goodsId, $linkGoodsId, 1, 0) ";
	         
	   if(!$GLOBALS['db']->query($sql))
	   {
		 echo "商品ID为$goodsId的货物，添加linkGooods失败<br/>";
	   }
	   $sql =  "INSERT INTO ".$GLOBALS['ecs']->table('link_goods')." values($linkGoodsId, $goodsId, 1, 0)";
	    if(!$GLOBALS['db']->query($sql))
	   {
		 echo "商品ID为$goodsId的货物，添加双向关联失败<br/>";
	   }
	}
}

function getLinkedGoodsId($packageBuyLinkedCatIds)
{
$sql = "SELECT goods_id FROM ".$GLOBALS['ecs']->table('goods')." as g WHERE cat_id ".db_create_in($packageBuyLinkedCatIds)." order by RAND() LIMIT 5";
	$linkedGoodsId = $GLOBALS['db']->getAll($sql);
	return $linkedGoodsId;
}

function isSetPackageBuyGoods($goodsId)
{
     $sql = "SELECT * FROM ".$GLOBALS['ecs']->table('link_goods')." WHERE goods_id = '$goodsId'";
	$flag = $GLOBALS['db']->getOne($sql);
	if(!empty($flag))
	{
	   return true;
	}
	return false;
}

function isGoodCanSetPackageBuy($goodId = 0,  $catId = 0)
{
Global $packageBuyCorrosponding;

$secondLeverCatId = getSencLeverCatId($catId);
if(in_array($secondLeverCatId, array_keys($packageBuyCorrosponding)))
{
  return true;
}
 return false;
}

function getPackageBuyRelatedCatIds($catId)
{
    Global $packageBuyCorrosponding;  
	$secondLeverCatId = getSencLeverCatId($catId);
	
	$directLinkedCatIds = $packageBuyCorrosponding[$secondLeverCatId];
	$linkedCatIds = array();
	foreach($directLinkedCatIds as $catId)
	{
		$linkedCatIds = array_merge( array_keys(cat_list($catId, 0, false)), $linkedCatIds);
	}
	
	return $linkedCatIds;
}

function getSencLeverCatId($catId)
{
	$parentCatIds = get_parent_cats($catId);
	//var_dump($parentCatIds);
	return $parentCatIds[1]['cat_id'];
}

function packageBuyGoodsRelated()
{
$tmp = array();

 $tmp[getCateId('纸尿裤/防尿用品')] = array(getCateId('护臀'));

 $tmp[getCateId('纸尿裤/防尿用品')] = array(getCateId('护臀'));
 $tmp[getCateId('寝具')] = array(getCateId('洗衣液/粉'));
 $tmp[getCateId('宝宝内衣')] = array(getCateId('消毒液'),getCateId('洗衣皂'),getCateId('收纳类'));
 $tmp[getCateId('宝宝外出服')] = array(getCateId('宝宝配饰'),getCateId('学饮杯'));
 $tmp[getCateId('护理')] = array(getCateId('护肤'),getCateId('洗浴'));
 $tmp[getCateId('婴儿床')] = array(getCateId('床类配件'));
 $tmp[getCateId('安抚奶嘴')] = array(getCateId('牙胶/吮食器'));


  $tmp[getCateId('产后修复')] = array(getCateId('妈妈洗护用品'));
 $tmp[getCateId('孕妈内衣')] = array(getCateId('妈妈洗护用品'),getCateId('母乳喂养用品'));
 $tmp[getCateId('餐具')] = array(getCateId('辅食喂养与制作'),getCateId('消毒/加温'));
 $tmp[getCateId('奶瓶')] = array(getCateId('辅助工具'),getCateId('消毒/加温'));
 
 return $tmp;
}

function getAllGoodsId()
{
	$sql = "SELECT goods_id, cat_id FROM ".$GLOBALS['ecs']->table('goods');
    $goodsList = $GLOBALS['db']->getAll($sql);
	return $goodsList;
}


function getCateId($catName)
{
   $sql = "SELECT cat_id FROM ".$GLOBALS['ecs']->table('category')." WHERE cat_name = '$catName'";
   $catId= $GLOBALS['db']->getOne($sql);
   return $catId;
}
?>