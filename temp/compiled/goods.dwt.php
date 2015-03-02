<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



  <link href="style/css/style_groupBuy.css" rel="stylesheet" type="text/css" />
  <link href="style/css/item.css" rel="stylesheet" type="text/css" />
   <?php echo $this->smarty_insert_scripts(array('files'=>'jquery.min.js,item_1.js,all_top_nav.js,item_2.js,item_hdm.js,top.js,all_top_nav.js,common.js,lefttime.js')); ?>
 <?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js')); ?>  
  <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>

  <script type="text/javascript" src="style/js/left_nav_2.js"></script>
  <script type="text/javascript" src="style/js/product_amount.js"></script>
  <script type="text/javascript" src="style/js/home_tab.js"></script>

<script type=text/javascript>
function turnoff(obj){
document.getElementById(obj).style.display="none";
}
$(function(){
    /* 鼠标移动小图，小图对应大图显示在大图上，并替换放大镜中的图*/
    $("#specList ul li img").livequery("mouseover",function(){ 
        var imgSrc = $(this).attr("src");
        var i = imgSrc.lastIndexOf(".");
        var unit = imgSrc.substring(i);
        imgSrc = imgSrc.substring(0,i);
        var imgSrc_small = $(this).attr("src_D");
        var imgSrc_big = $(this).attr("src_H");
        $("#bigImg").attr({"src": imgSrc_small ,"jqimg": imgSrc_big});
        $(this).css({"border":"2px solid #f13d6d","padding":"1px"});
    });
    
    $("#specList ul li img").livequery("mouseout",function(){ 
        $(this).css({"border":"1px solid #e6e6e6","padding":"2px"});
    });
    
    //使用jqzoom
    $(".jqzoom").jqueryzoom({
        xzoom: 350, //放大图的宽度(默认是 200)
        yzoom: 350, //放大图的高度(默认是 200)
        offset: 10, //离原图的距离(默认是 10)
        position: "right", //放大图的定位(默认是 "right")
        preload:1   
    });
    
    /*如果小图过多，则出现滚动条在一行展示*/
    var btnNext = $('#specRight');
    var btnPrev = $('#specLeft')
    var ul = btnPrev.next().find('ul');

    var len = ul.find('li').length;
    var i = 0 ;
    if (len > 4) {
        $("#specRight").addClass("specRightF").removeClass("specRightT");
        ul.css("width", 76 * len)
        btnNext.click(function(e) {
            if(i>=len-4){
                
                return;
            }
            i++;
            if(i == len-4){
                $("#specRight").addClass("specRightT").removeClass("specRightF");
            }
            $("#specLeft").addClass("specLeftF").removeClass("specLeftT");
            moveS(i);
        })
        btnPrev.click(function(e) {
            if(i<=0){
                return;
            }
            i--;
            if(i==0){
                $("#specLeft").addClass("specLeftT").removeClass("specLeftF");
            }
            $("#specRight").addClass("specRightF").removeClass("specRightT");
            moveS(i);
        })
    }
    function moveS(i) {
        ul.animate({left:-78 * i}, 500)
    }
    function picAuto(){
      if ($(".listImg li").size()<=4) {
        $("#specLeft,#specRight").hide();
      }
    }
    picAuto();
});


    
        
</script>
</head>
<body>

<?php echo $this->fetch('library/page_header_groupbuy.lbi'); ?>
 <?php echo $this->fetch('library/category_tree.lbi'); ?>

    <div class="item_site">
        <?php echo $this->fetch('library/ur_here1.lbi'); ?>
          
        </div>
<form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
    <div class="main middle over item_bj">
      <div class="item_left">

            <?php echo $this->fetch('library/goods_gallery_groupbuy.lbi'); ?> 
        </div>
      <div class="item_right">
          <h1><?php echo $this->_var['goods']['goods_style_name']; ?></h1>
            <div class="tag">
              <!--
    <span class="tag_1"><?php if (rank_name): ?>{rank_name}<?php else: ?>游客<?php endif; ?></span>
    -->
    <span class="tag_2" id="current_price">
      ￥ <?php if ($this->_var['goods']['activity_price']): ?><?php echo $this->_var['goods']['activity_price_formated']; ?>
        <?php elseif ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><?php echo $this->_var['goods']['promote_price']; ?>
        <?php else: ?><?php echo $this->_var['goods']['shop_price_formated']; ?>
        <?php endif; ?>
    </span>
    <span class="tag_3">原价：￥<?php echo $this->_var['goods']['market_price']; ?></span>
    <?php if ($this->_var['promotion']): ?><span style="float:right;"> 本商品正在进行<font color="#f13d6d"><a href="<?php echo $this->_var['promotion']['0']['url']; ?>" target="_blank" style="color:#f13d6d"><?php echo $this->_var['promotion']['0']['act_name']; ?></a></font>活动</span><?php endif; ?>
    <?php if ($this->_var['exchangePromotion']): ?>
    <span class="tag_4">
      <a href="exchange.php?id=<?php echo $this->_var['exchangePromotion']['goods_id']; ?>&act=view" target="_blank"></a><b>￥<?php echo $this->_var['exchangePromotion']['needed_money']; ?>+<?php echo $this->_var['exchangePromotion']['exchange_integral']; ?>积分</b>
    
    </span>
    <?php endif; ?>
    <?php if ($this->_var['vipPromotion']): ?>
           <span class="tag_4">
      <a style="background: url('style/images/buy_3.jpg')" href="vip_goods.php?id=<?php echo $this->_var['vipPromotion']['goods_id']; ?>&act=view" target="_blank"></a><b>￥<?php echo $this->_var['vipPromotion']['user_price']; ?>+<?php echo $this->_var['vipPromotion']['user_integral']; ?>积分</b>
    
    </span>
    <?php endif; ?>
      </div>
            <?php if ($this->_var['goodsyh']): ?>
            <dl class="message">
              <dt>优惠信息：</dt>
                <dd><?php echo $this->_var['goodsyh']; ?></dd>
            </dl>
          <?php endif; ?>
          <?php if ($this->_var['goods']['give_integral'] > 0): ?>
          <dl class="sku_unit mod_integral_buy clearfix" id="pointExchange" style="display: block;">
            <dt><strong><?php echo $this->_var['lang']['goods_give_integral']; ?></strong></dt>
            <dd class="options"><?php echo $this->_var['goods']['give_integral']; ?> <?php echo $this->_var['points_name']; ?></dd>
          </dl>
          <?php endif; ?>
           <?php echo $this->fetch('library/sale_info.lbi'); ?>
             
            <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');$this->_foreach['shu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shu']['total'] > 0):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
        $this->_foreach['shu']['iteration']++;
?> 
       
       <?php if ($this->_var['spec']['attr_type'] == 1): ?>
             <dl id="tasteList" class="standard_1">
              <dt id="tasteAttrName"><?php echo $this->_var['spec']['name']; ?></dt>
                    <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                    <dd  onclick="selPara(this,'spec_<?php echo $this->_var['spec_key']; ?>','spec_value_<?php echo $this->_var['value']['id']; ?>'); changePrice();" 
            id="<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?> class="spec_<?php echo $this->_var['spec_key']; ?> options" <?php else: ?>class="spec_<?php echo $this->_var['spec_key']; ?>" <?php endif; ?>>
            <?php echo $this->_var['value']['label']; ?>
                      <input id="spec_value_<?php echo $this->_var['value']['id']; ?>"  style="display:none;"  type="radio"  name="spec_<?php echo $this->_var['spec_key']; ?>" 
            value="<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> />
                    </dd>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </dl>
            <?php endif; ?>
      
            <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            
            
            <dl class="standard_3">
                <dt>购买数量：</dt>
                <dd class="standard_3_2" data-sel="num" id="computing_item">
                 <input  value="1" type=text class="num" name="number" id="product_amount" />
         <div class="standard_3_1">
           <a onClick="funnum('up')"></a>
           <a onClick="funnum('down')"></a>
         </div>
<script type="text/javascript">
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;


onload = function(){
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}

/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
 
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;
  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}
/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;
    $('#product_num').html( '库存' + res.stock + '件');
  document.getElementById('current_price').innerHTML = '¥'+res.result;
  }
}


</script> 
    

</dd>
  <dd id='product_num'>库存<?php echo $this->_var['nums']; ?>件</dd>
            </dl>
            <div class="item_buy">
        
          <?php echo $this->fetch('library/cart_or_buy.lbi'); ?>    
              <a href="javascript:void(0)" onclick="add_mark(1);addToCart(<?php echo $this->_var['goods']['goods_id']; ?>);" >
    <input class="item_buy_a" name="" type="button" />
    </a>
                <a href="javascript:void(0)" onclick="add_mark(0);addToCart(<?php echo $this->_var['goods']['goods_id']; ?>);">
    <input class="item_buy_b" name="" type="button" />
    </a>
                </div>
        </div>
    </div>
</form>

<?php if ($this->_var['related_goods']): ?>
 <link href="style/css/attr_mask.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="style/js/package_buy.js"></script>

 <div id="fixedLayer" ></div>
  <div id="attrSelect" style="display: none;">
  <div id="TB_window" style="margin-left: -465px; width: 1090px; margin-top: -220px; display: block;">
  <div id="TB_ajaxContent" class="TB_modal">
  
    <br/>
          <h1 id="attrSelectGoodName"  data-good-id=''></h1>
          <br/>
          <div class="tag">
                <!--
            <span class="tag_1">{rank_name}</span>
            -->
            <span class="tag_2" id="attrSelectGoodPrice">¥0.00</span>
            <span class="tag_3" id="attrSelectMarketPrice">原价：￥0.00</span>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;库存<b style="color:red" id="attrSelectGoodNum"></b>件
                    </div>  
              <div id="packageAttrList"></div>    
            <br/>
            <p>
            <a class="select_c" href="javascript:void(0)" onclick="confirm_attr_mask();elem_hide('attrSelect');">确定</a>
              
            <a class="select_d" href="javascript:void(0)" onclick="elem_hide('attrSelect')">取消</a>
              
            </p>
    
  </div>
  </div>          
  </div>

<div class="dapeitaocan">
      <div class="dapeitaocan_title"><span>搭配套餐</span></div>
        <div class="dapeitaocan_main">
          <dl class="dapeitaocan_itself" id="good<?php echo $this->_var['goods']['goods_id']; ?>">
                      <dt class="xuanzhong" data-shop-price="<?php echo $this->_var['goods']['shop_price_formated']; ?>" data-good-id="<?php echo $this->_var['goods']['goods_id']; ?>" data-good-attr="">
              <a href="javascript:void(0)">
              <img src="<?php echo $this->_var['goods']['goods_thumb']; ?>">
              <span><img width="20" height="20" src="style/images/hook.png"></span>
              </a>
            </dt>     
                        <dd>
              <a href="javascript:void(0)" class="show_full_name"><?php echo $this->_var['goods']['goods_style_name']; ?></a>
              <div class="jiage_xz_1">
                <b>¥<?php echo $this->_var['goods']['shop_price_formated']; ?></b>
                <input name="" type="button" value="修改属性" onclick="choose_attr('<?php echo $this->_var['goods']['goods_id']; ?>')"/>
              </div>
            </dd>
                    </dl>
                    <span class="dapeitaocan_jia">
                    </span>
                    <div class="dapeitaocan_box">
                    
                    <div class="lunbo-recommend_1">
    <div id="banner-slide_1" class="slide-pics_1">
      <div class="scrollable_1">
        <ul class="items_1">
      <?php $_from = $this->_var['related_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['loop']['iteration']++;
?>
      <?php if (($this->_foreach['loop']['iteration'] - 1) % 5 == 0): ?>
    <li class="item_1"> 
    <?php endif; ?>
    <dl class="dapeitaocan_itself" id="good<?php echo $this->_var['good']['goods_id']; ?>">
                      <dt class="related" data-shop-price="<?php echo $this->_var['good']['shop_price']; ?>" data-market-price="<?php echo $this->_var['good']['market_price']; ?>" data-good-id="<?php echo $this->_var['good']['goods_id']; ?>" data-good-attr="<?php echo $this->_var['good']['attrList']; ?>">
              <a href="<?php echo $this->_var['good']['url']; ?>">
                <img src="<?php echo $this->_var['good']['goods_thumb']; ?>">
                <span><img width="20" height="20" src="themes/yihaodian/images/hook.png"></span>
              </a>
            </dt>
                        <dd>
              <a class="show_full_name" href="<?php echo $this->_var['good']['url']; ?>"><?php echo $this->_var['good']['goods_name']; ?><?php if ($this->_var['good']['attr']): ?>(<?php $_from = $this->_var['good']['attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?><?php if (! ($this->_foreach['loop']['iteration'] == $this->_foreach['loop']['total'])): ?> <?php echo $this->_var['attr']['attr_value']; ?>,<?php else: ?><?php echo $this->_var['attr']['attr_value']; ?> <?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>)<?php endif; ?></a>
              <div class="jiage_xz">
                <b>¥<?php echo $this->_var['good']['shop_price']; ?></b>
                <input name="" type="button" value="搭配" data-good-id="<?php echo $this->_var['good']['goods_id']; ?>"/>
              </div>
            </dd>
         </dl>
                    
         <?php if (($this->_foreach['loop']['iteration'] - 1) % 5 == 4 || ($this->_foreach['loop']['iteration'] == $this->_foreach['loop']['total'])): ?>     
          </li>
      <?php else: ?>
       <span class="dapeitaocan_jia">
                    </span>   
     <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </div>
      <div class="prev_1 prev-next_1 s-index-icon_1"> 上一张</div>
      <div class="next_1 prev-next_1 s-index-icon_1"> 下一张</div>
    </div>
</div>
                    </div>
          <span class="dapeitaocan_deng">
                    </span>
          <div class="dapeitaocan_zongjia">
                   <span class="zongjia_4">购买<input type="text" id="packageBuyNum" data-discount="<?php echo $this->_var['package_buy_discount']; ?>" name="" value="1" onblur="reCaculatePackagePrice()">套</span>
                      <span class="zongjia_1">套餐价：<b id="package_price">¥<?php echo $this->_var['goods']['shop_price_formated']; ?></b></span>
                        <span class="zongjia_2">原总价：<b id="initial_price">¥<?php echo $this->_var['goods']['shop_price_formated']; ?></b></span>
            <span class="zongjia_1">优惠金额：<b id="discount_price">¥0.00</b></span>  
            <span class="zongjia_3"><input type="button" value="立即购买" name=""  onclick="add_mark(1);addToCart_packageBuy();"></span>
                       <span class="zongjia_5"><input type="button" value="加入购物车" name="" onclick="add_mark(0);addToCart_packageBuy();"></span>
            
          </div>
        </div>
    
    
    </div>
  
<?php endif; ?>
<?php echo $this->fetch('library/goods_descr.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>


<?php echo $this->fetch('library/cart_goods_added.lbi'); ?>
</body>
</html>

