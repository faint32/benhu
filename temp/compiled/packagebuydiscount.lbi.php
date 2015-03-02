<?php if ($this->_var['packageBuyDiscountMoney'] != '0.00'): ?>
	<p style="margin-top:15px;height:20px;" class="sc_order_title" id="packageBuyDiscountInfo">
            <span>套餐购的商品可享受<font color="red" id="discountRate"><?php echo $this->_var['packageBuyDiscount']; ?></font>折优惠，节省￥<font id="discountMoney"><?php echo $this->_var['packageBuyDiscountMoney']; ?></font>元</span>
        </p>
	<?php endif; ?>