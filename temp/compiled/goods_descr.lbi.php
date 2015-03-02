    <div class="main middle over item_pt20">
    <div class="main_1_right_1 item_2_left">
                  <h3>购买过该商品的人还购买过</h3>
<?php $_from = $this->_var['bought_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bought_goods_data');if (count($_from)):
    foreach ($_from AS $this->_var['bought_goods_data']):
?>
                    <dl>
                      <dt><a href="<?php echo $this->_var['bought_goods_data']['url']; ?>"><img class="disable_hover_attr" src="<?php echo $this->_var['bought_goods_data']['goods_thumb']; ?>" width="178" height="178" /></a></dt>
                        <dd><a class="main_1_right_1_a" href="<?php echo $this->_var['bought_goods_data']['url']; ?>"><?php echo $this->_var['bought_goods_data']['goods_name']; ?></a><span class="main_1_right_1_b">￥<?php echo $this->_var['bought_goods_data']['shop_price']; ?></span><span class="main_1_right_1_c" style="width:100px">已售<b><?php echo $this->_var['bought_goods_data']['goods_num']; ?></b>件</span></dd>
                    </dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                  
                   
      </div>
      <div class="item_2_right">
        <div id=item_con>
  <div id=item_tags>
    <ul>
      <li class=zzjs_net><a onClick="select_zzjs('wwwzzjsnet0',this)" href="javascript:void(0)">商品详情</a> </li>
      <li>
          <a onClick="select_zzjs('wwwzzjsnet1',this)" href="javascript:void(0)">
            购买评价(<?php if ($this->_var['comment_percent']['count']): ?><?php echo $this->_var['comment_percent']['count']; ?><?php else: ?>0<?php endif; ?>)
          </a> 
      </li>                        
      <li> 
          <a onClick="select_zzjs('wwwzzjsnet2',this)" href="javascript:void(0)">
            销售记录(<?php if ($this->_var['sale_history']): ?><?php echo $this->_var['count_sale_history']; ?><?php else: ?>0<?php endif; ?>)
          </a> 
      </li>
      <li><a onClick="select_zzjs('wwwzzjsnet3',this)" href="javascript:void(0)">服务承诺</a> </li>
    </ul>
    </div>
<div id=wwwzzjsnet>
    <div class="wwwzzjsnet zzjs_net" id=wwwzzjsnet0>
         
          <?php if ($this->_var['properties']): ?>
          <div class="description_1" style="display:none">
            <dt>规格参数 </dt>
            <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property']):
?>
            <span><?php echo htmlspecialchars($this->_var['property']['name']); ?>：<?php echo $this->_var['property']['value']; ?></span>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            
          </div>
          <?php endif; ?> 
          

  <div class="item_2_right_img"><?php echo $this->_var['goods']['goods_desc']; ?></div>
    </div>
    <div class=wwwzzjsnet id=wwwzzjsnet1>
    
      <div class="description_2">
          <div class="description_2_a"><span><?php echo $this->_var['comment_percent']['haoping_percent']; ?>%</span>&nbsp;&nbsp;<b>用户满意</b><br />共有<?php if ($this->_var['comment_percent']['count']): ?><?php echo $this->_var['comment_percent']['count']; ?><?php else: ?>0<?php endif; ?>人参与评价
            </div>
            <div class="description_2_b">
              <dl>
                  <dt>满意</dt>
                    <div class="a"><p  style="width:<?php echo $this->_var['comment_percent']['haoping_percent']; ?>%;"></p></div>
                    <dd><?php echo $this->_var['comment_percent']['haoping_percent']; ?>%</dd>
                </dl>
                <dl>
                  <dt>一般</dt>
                    <div class="b"><p style="width:<?php echo $this->_var['comment_percent']['zhongping_percent']; ?>%;"></p></div>
                    <dd><?php echo $this->_var['comment_percent']['zhongping_percent']; ?>%</dd>
                </dl>
                <dl>
                  <dt>不满意</dt>
                    <div class="c"><p style="width:<?php echo $this->_var['comment_percent']['chaping_percent']; ?>%;"></p></div>
                    <dd><?php echo $this->_var['comment_percent']['chaping_percent']; ?>%</dd>
                </dl>
            </div>
        </div>

     
          
          <?php 
$k = array (
  'name' => 'comments',
  'type' => $this->_var['type'],
  'id' => $this->_var['id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
    
    </div>

    <div class='wwwzzjsnet' id='wwwzzjsnet2'>
      <div class="description_1">
        30天内：交易中<?php echo $this->_var['recently_buy']['trading']; ?>笔，交易成功<?php echo $this->_var['recently_buy']['traded']; ?>笔！
      </div>
      <div id="ECS_BOUGHT">
          <?php 
$k = array (
  'name' => 'sale_history',
  'type' => $this->_var['type'],
  'id' => $this->_var['id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
      </div>
    </div>
    <div class=wwwzzjsnet id=wwwzzjsnet3>
      <?php echo $this->_var['fuwu']; ?>
    </div>
    </div>
</div>
      </div>
    </div>