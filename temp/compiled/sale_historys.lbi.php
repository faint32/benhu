    <table class="item_sales" width="960" border="0" cellspacing="0" cellpadding="0">
            <tr class="title">
              <td width="260">买家</td>
              <td width="130">购买价格</td>
              <td width="130">数量</td>
              <td>付款时间</td>
              <!--<td>款式和型号</td>-->
            </tr>
  <?php $_from = $this->_var['sale_historys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'saleItme');if (count($_from)):
    foreach ($_from AS $this->_var['saleItme']):
?>
            <tr>              
                      <td class="name" style="text-align:center"><?php echo $this->_var['saleItme']['consignee']; ?></td>
      <td class="price">¥<?php echo $this->_var['saleItme']['pay_fee']; ?></td>
      <td><?php echo $this->_var['saleItme']['goods_number']; ?></td>
      <td><?php echo $this->_var['saleItme']['pay_time']; ?></td>
      <!--<td>$saleItme.goods_attr</td>  -->            
            </tr>              
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>               
        </table>