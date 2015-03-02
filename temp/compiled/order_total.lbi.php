          累计商品金额：<span class="sc_order_submit_1 add">¥<?php if ($this->_var['is_exchange_goods'] != 1): ?><?php echo $this->_var['total']['goods_price_formated']; ?> <?php else: ?><?php echo $this->_var['total']['needed_money']; ?><?php endif; ?></span><br />
<?php if ($this->_var['is_exchange_goods'] == 1): ?>+累计需要积分：<span class="sc_order_submit_1" id="ECS_INTEGRAL" value="<?php echo $this->_var['total']['exchange_integral']; ?>"><?php echo $this->_var['total']['exchange_integral']; ?></span><br/><?php endif; ?>
      +&nbsp;累计配送费：<span id="shipping_fee" class="sc_order_submit_1 add">¥<?php echo $this->_var['total']['shipping_fee_formated']; ?></span><br />
      <span id="fapiao_dsp" style="display:none">+发票费用：<span class="sc_order_submit_1 add" id="tax_fee">¥0.0</span><br /></span>
      <?php if ($this->_var['total']['discount_formated'] != '0.00'): ?>
        -&nbsp;折扣: <span class="sc_order_submit_1 minus">¥<?php echo $this->_var['total']['discount_formated']; ?></span><br/>
        <?php endif; ?>
订单总金额：<span class="sc_order_submit_2" id="total_amount">¥<?php echo $this->_var['total']['amount_formated']; ?></span><br />