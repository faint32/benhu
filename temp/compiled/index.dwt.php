<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta property="qc:admins" content="12240364526256056375" />
<meta property="wb:webmaster" content="609fcdee4c3f7d0b" />

<title><?php echo $this->_var['page_title']; ?>-最优质的母婴生活馆 最快乐的亲子购物行 正品 精品  良品   奶瓶、奶嘴、纸尿裤、学饮杯、睡袋、童装、图书</title>




</head>
<body>
    <?php echo $this->fetch('library/page_header.lbi'); ?>
<script type="text/javascript" src="style/js/combine/index.js"></script> 
   
    <div class="nav-wrap middle">
  <div class="nav">
    <div class="goods">
      <div>
      <script>
          function xianshi() {
              document.getElementById("dvtype").style.display = "";
          }
      </script>
        <h2> <a onclick="xianshi()">所有商品分类</a></h2>
      </div>

      <div id="dvtype" onmouseout="yincang()" class="all-goods" style="display:none;">
<?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cats']['iteration']++;
?>
        <div class="item  <?php if (($this->_foreach['cats']['iteration'] - 1) < 1): ?>btnone<?php endif; ?>">
          <div class="product">
            <h3 class="mylistbj<?php echo $this->_foreach['cats']['iteration']; ?>">
                    <?php echo htmlspecialchars($this->_var['cat']['name']); ?>
            </h3>
            <div class="product_classify">
                
                    <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['foo']['iteration']++;
?>
                        <?php if (($this->_foreach['foo']['iteration'] - 1) < 6): ?>
                    <a href="<?php echo $this->_var['child']['url']; ?>"  target="_blank"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos<?php echo $this->_foreach['cats']['iteration']; ?>"> 
            
            <div class="cf">
              <div>
                <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['foo']['iteration']++;
?>
                <h4><a href="<?php echo $this->_var['child']['url']; ?>"  target="_blank"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></h4>
                <p class="cf">
                  <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?>
                  <a href="<?php echo $this->_var['childer']['url']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </p>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </div>
            </div>
          </div>

        </div>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    </div>
    <ul class="nav-list cf">
        <li><a href="<?php echo $this->_var['staticPages']['index']; ?>" class="on"><?php echo $this->_var['lang']['home']; ?></a></li>
         <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
        <li><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>

  </div>
</div>

    
            <div id="focus">
    <ul><?php echo $this->fetch('library/ad.lbi'); ?></ul>
        
  </div>
  <div class="main over middle">
        <div class="main_1_left over">
        <div class="mytab">
        <div class="title cf">
          
          <ul class="title-list fr cf ">
          <li class="on" style="width:328px">精品推荐</li>
            <li style="width:328px">爆款新品</li>
            <!--<li>团购</li>-->
            <li style="width:328px">当季热卖</li>
          </ul>
        </div>

<div class="tabproduct-wrap">
    
    <div class="tabproduct show">
      
      <ul class="cf over">
            <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?>
      <div class="mytab_hoverbox <?php if ($this->_foreach['name']['iteration'] != 5 && $this->_foreach['name']['iteration'] != 10): ?>mr10<?php endif; ?>">
      <b class="tabproduct_price_3"><a href="<?php echo $this->_var['goods']['url']; ?>"  target="_blank"></a></b>
        <li class="mosaic-backdrop">
          <a href="<?php echo $this->_var['goods']['url']; ?>" class="imgwrap"><img src="" class="lazyload"  id="index_bestgoods_<?php echo ($this->_foreach['name']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['goods']['thumb']; ?>" width="165" height="198"  target="_blank"/></a>
          <p class="textwrap"> <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods']['name']); ?></a></p>
          <p class="jiagewrap">
          <span class="tabproduct_price_1">￥<?php echo $this->_var['goods']['shop_price']; ?></span>
          <span class="tabproduct_price_2">￥<?php echo $this->_var['goods']['market_price']; ?></span>
          </p>
        </li>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>
  
    <div class="tabproduct">
      
      <ul class="cf over">
            <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?>
      <div class="mytab_hoverbox <?php if ($this->_foreach['name']['iteration'] != 5 && $this->_foreach['name']['iteration'] != 10): ?>mr10<?php endif; ?>">
      <b class="tabproduct_price_3"><a href="<?php echo $this->_var['goods']['url']; ?>"  target="_blank"></a></b>
        <li class="mosaic-backdrop">
          <a href="<?php echo $this->_var['goods']['url']; ?>" class="imgwrap"><img src="" class="lazyload"  id="index_newgoods_<?php echo ($this->_foreach['name']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['goods']['thumb']; ?>" width="165" height="198"  target="_blank"/></a>
          <p class="textwrap"> <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods']['name']); ?></a></p>
          <p class="jiagewrap">
          <span class="tabproduct_price_1">￥<?php echo $this->_var['goods']['shop_price']; ?></span>
          <span class="tabproduct_price_2">￥<?php echo $this->_var['goods']['market_price']; ?></span>
          </p>
        </li>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>

    
    <div class="tabproduct">
      
      <ul class="cf over">
      <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['foo']['iteration']++;
?>
       <div class="mytab_hoverbox <?php if ($this->_foreach['foo']['iteration'] != 5 && $this->_foreach['foo']['iteration'] != 10): ?>mr10<?php endif; ?>">
      <b class="tabproduct_price_3"><a href="<?php echo $this->_var['goods']['url']; ?>"></a></b>
        <li class="mosaic-backdrop">
          <a href="<?php echo $this->_var['goods']['url']; ?>" class="imgwrap"><img src="" class="lazyload"  id="index_hotgoods_<?php echo ($this->_foreach['foo']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['goods']['thumb']; ?>" width="165" height="198"  target="_blank"/></a>
          <p class="textwrap"> <a href="<?php echo $this->_var['goods']['url']; ?>"  title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods']['name']); ?></a></p>
          <p class="jiagewrap">
          <span class="tabproduct_price_1">￥<?php echo $this->_var['goods']['shop_price']; ?></span>
          <span class="tabproduct_price_2">￥<?php echo $this->_var['goods']['market_price']; ?></span>
          </p>
        </li>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>
   

</div>
</div>
            </div>
            <div class="main_1_right">
              <div class="main_1_right_3">
                <span class="tabbtn_star"></span><ul class="tabbtn" id="fadetab">
                
    <li class="current">公告</li>
    
  </ul>
  
  <div class="tabcon" id="fadecon">
    <div class="sublist">
      <ul>
<?php $_from = $this->_var['gao']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cats']['iteration']++;
?>
        <li><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo $this->_var['cat']['title']; ?></a></li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
    </div>
  </div>
                </div>
                <div class="main_1_right_1">
                  <h3>猜你喜欢</h3>
                    <dl>
<?php $_from = $this->_var['cai']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai_0_44026900_1423706921');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cai_0_44026900_1423706921']):
        $this->_foreach['cats']['iteration']++;
?>
                      <dt><a href="<?php echo $this->_var['cai_0_44026900_1423706921']['url']; ?>"><img src="" class="lazyload"   id="index_cai_<?php echo ($this->_foreach['cats']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['cai_0_44026900_1423706921']['goods_thumb']; ?>" width="178" height="178" /></a></dt>
                        <dd><a class="main_1_right_1_a" href="<?php echo $this->_var['cai_0_44026900_1423706921']['url']; ?>"  target="_blank" title="<?php echo $this->_var['cai_0_44026900_1423706921']['goods_name']; ?>"><?php echo $this->_var['cai_0_44026900_1423706921']['goods_name']; ?></a><span class="main_1_right_1_b">¥<?php echo $this->_var['cai_0_44026900_1423706921']['shop_price']; ?></span><span class="main_1_right_1_c">已售<b><?php echo $this->_var['cai_0_44026900_1423706921']['num']; ?></b>件</span></dd>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </dl>
                </div>
                <div class="main_1_right_2">
<?php $_from = $this->_var['you']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'you_0_44223200_1423706921');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['you_0_44223200_1423706921']):
        $this->_foreach['cats']['iteration']++;
?>
        <?php if ($this->_var['you_0_44223200_1423706921']['position_id'] == 3): ?>
                <a href="<?php echo $this->_var['you_0_44223200_1423706921']['ad_link']; ?>"><img src="" class="lazyload"  id="index_you_<?php echo ($this->_foreach['cats']['iteration'] - 1); ?>" data-lazyload="data/afficheimg/<?php echo $this->_var['you_0_44223200_1423706921']['ad_code']; ?>" width="178" height="178" /></a>
        <?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>            
              
                
            </div>
        </div>
        
    </div>

<div id=con>
  <div id=tags>
    <p class="tags_title"></p>
    <ul>
      <li class=zzjs_net><a class="index_m3_a" onmouseover="select_zzjs('wwwzzjsnet0',this)" href="javascript:void(0)"></a> </li>
      <li><a class="index_m3_b" onmouseover="select_zzjs('wwwzzjsnet1',this)" href="javascript:void(0)"></a> </li>
      <li><a class="index_m3_c" onmouseover="select_zzjs('wwwzzjsnet2',this)" href="javascript:void(0)"></a> </li>
      <li><a class="index_m3_d" onmouseover="select_zzjs('wwwzzjsnet3',this)" href="javascript:void(0)"></a> </li>
      <li><a class="index_m3_e" onmouseover="select_zzjs('wwwzzjsnet4',this)" href="javascript:void(0)"></a> </li>
      <li><a class="index_m3_f" onmouseover="select_zzjs('wwwzzjsnet5',this)" href="javascript:void(0)"></a> </li>
    </ul>
    </div>

<div id='wwwzzjsnet'>
 <script>
      function before_another_batch(ele_id, changeDetail, age , cat_id)
    {
       var extra_info = new Array();
     extra_info[0] = changeDetail;
     extra_info[1] = age;
     extra_info[2] = cat_id;
     
       another_batch(ele_id,extra_info);
    }
   </script>

   <?php $_from = $this->_var['goods_baby']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'per_goods');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['per_goods']):
        $this->_foreach['loop']['iteration']++;
?> 
    <div class="wwwzzjsnet <?php if ($this->_var['per_goods']['0']['age_index'] == 0): ?>zzjs_net<?php endif; ?>"  id='wwwzzjsnet<?php echo $this->_var['per_goods']['0']['age_index']; ?>'>
     <?php $_from = $this->_var['per_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['loop2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop2']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['loop2']['iteration']++;
?> 
      <div class="main_2 middle over">
        <p class="main_2_left_title">
          <span class="main_2_left_title_a"><?php echo $this->_var['goods']['name_id']['0']['cat_name']; ?></span>
          <span class="main_2_left_title_b">
            <a href="javascript:before_another_batch('aged_goods_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>_<?php echo ($this->_foreach['loop2']['iteration'] - 1); ?>','index_babyGrowth','<?php echo $this->_var['per_goods']['0']['age_index']; ?>','<?php echo $this->_var['goods']['name_id']['0']['cat_id']; ?>')">
            <img src="" class="lazyload"  id="index_goodsbaby<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>_pergoods<?php echo ($this->_foreach['loop2']['iteration'] - 1); ?>" data-lazyload="style/images/main_2_left_title_b.png" width="65" height="20" /></a>
          </span>
          <span class="main_2_left_title_c">
            <a href="<?php echo $this->_var['goods']['moreUrl']; ?>"  target="_blank">更多&gt;</a>
          </span>
        </p>
        <div>
        <textarea style="visibility:hidden;">
            <div class="main_2_left over" id="aged_goods_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>_<?php echo ($this->_foreach['loop2']['iteration'] - 1); ?>">
              <?php $_from = $this->_var['goods']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods1');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['goods1']):
        $this->_foreach['cats']['iteration']++;
?>
                    <dl>
                      <dt>
                        <a href="<?php echo $this->_var['goods1']['url']; ?>"  target="_blank">
                          <img src="" class="lazyload"  id="index_goodsbaby<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>_pergood<?php echo ($this->_foreach['loop2']['iteration'] - 1); ?>_goods<?php echo ($this->_foreach['cats']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['goods1']['goods_thumb']; ?>" width="178" height="178"/>
                        </a>
                      </dt>
                      <dd>
                        <a href="<?php echo $this->_var['goods1']['url']; ?>"  target="_blank" title="<?php echo $this->_var['goods1']['goods_name']; ?>"><?php echo $this->_var['goods1']['goods_name']; ?></a>
                        <span class="main_2_left_price1">￥<?php echo $this->_var['goods1']['shop_price']; ?></span>
                        <span class="main_2_left_price2">￥<?php echo $this->_var['goods1']['market_price']; ?></span>
                      </dd>
                    </dl>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
          <div class="main_2_right over">
            <h3>推荐分类</h3>
            <div class="main_2_right_a">
              <?php $_from = $this->_var['goods']['recommend']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'recommend');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['recommend']):
        $this->_foreach['foo']['iteration']++;
?>
                      <a href="<?php echo $this->_var['recommend']['url']; ?>" <?php if ( recommend.recommend_type == 1): ?>class="main_2_right_a_only"<?php endif; ?> target="_blank"><?php echo $this->_var['recommend']['cat_name']; ?></a>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <h3>推荐品牌</h3>
            <div class="main_2_right_b">
              <?php $_from = $this->_var['goods']['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['foo']['iteration']++;
?>
                    <a href="<?php echo $this->_var['brand']['url']; ?>"  target="_blank"><img src="" class="lazyload"  id="index_goodsbaby<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>_pergood<?php echo ($this->_foreach['loop2']['iteration'] - 1); ?>_foo<?php echo ($this->_foreach['foo']['iteration'] - 1); ?>" data-lazyload="data/brandlogo/<?php echo $this->_var['brand']['brand_logo']; ?>"  title="<?php echo $this->_var['brand']['brand_name']; ?>"/></a>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
            </div> 
          </div>
        </textarea>
      </div>
      </div>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
   </div> 
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   

</div>
   </div>
   <div class="child_know main over middle">
     <textarea style="visibility:hidden;">
      <p class="main_2_left_title"><span class="main_2_left_title_a">育儿知识</span><span class="main_2_left_title_c"><a href="article_cat-22.html" target="_blank">更多&gt;</a></span></p>
  <?php $_from = $this->_var['yu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'yu_0_45285900_1423706921');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['yu_0_45285900_1423706921']):
        $this->_foreach['foo']['iteration']++;
?>
  <?php if (($this->_foreach['foo']['iteration'] - 1) == 0): ?>
        <div class="child_know_a">
              <a href="<?php echo $this->_var['yu_0_45285900_1423706921']['url']; ?>" target="_blank"><img src="" class="lazyload"  id="index_yu_<?php echo ($this->_foreach['foo']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['yu_0_45285900_1423706921']['file_url']; ?>" width="280" height="350" /><p><?php echo $this->_var['yu_0_45285900_1423706921']['title']; ?></p></a>
        </div>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
        <div class="child_know_b">
      <ul class="child_know_b_1">
        <?php $_from = $this->_var['yu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'yu_0_45666900_1423706921');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['yu_0_45666900_1423706921']):
        $this->_foreach['foo']['iteration']++;
?>
       <?php if (($this->_foreach['foo']['iteration'] - 1) > 0 && ($this->_foreach['foo']['iteration'] - 1) < 4): ?>
              <li><a href="<?php echo $this->_var['yu_0_45666900_1423706921']['url']; ?>" target="_blank"><img src="" class="lazyload"  id="index_yu2_<?php echo ($this->_foreach['foo']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['yu_0_45666900_1423706921']['file_url']; ?>" width="280" height="350" /><p><?php echo $this->_var['yu_0_45666900_1423706921']['title']; ?></p></a></li>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <ul class="child_know_b_2">
              <?php $_from = $this->_var['yu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'yu_0_45903100_1423706921');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['yu_0_45903100_1423706921']):
        $this->_foreach['foo']['iteration']++;
?>
  <?php if (($this->_foreach['foo']['iteration'] - 1) > 3): ?>
              <li>
                  <a class="child_know_b_2_title" href="<?php echo $this->_var['yu_0_45903100_1423706921']['url']; ?>"><?php echo $this->_var['yu_0_45903100_1423706921']['cat_name']; ?></a>
                    <dl>
                      <dt><a href="<?php echo $this->_var['yu_0_45903100_1423706921']['url']; ?>" target="_blank"><img src="" class="lazyload"  id="index_yu3_<?php echo ($this->_foreach['foo']['iteration'] - 1); ?>" data-lazyload="<?php echo $this->_var['yu_0_45903100_1423706921']['file_url']; ?>" /></a></dt>
                        <dd>
              <a href="<?php echo $this->_var['yu_0_45903100_1423706921']['url']; ?>" target="_blank">
              <?php echo $this->_var['yu_0_45903100_1423706921']['title']; ?>
              </a>
              <br/>
              <?php echo $this->_var['yu_0_45903100_1423706921']['content']; ?>
                         </dd>
                    </dl>
                </li>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
   </textarea>
    </div>


<?php echo $this->fetch('library/page_footer.lbi'); ?>

</body>
</html>
