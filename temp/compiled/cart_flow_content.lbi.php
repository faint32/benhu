<script type="text/javascript" src="js/yhd_common.js"></script>
<p class="good_cart" id="in_cart_num"><?php echo $this->_var['number']; ?></P>
      <span class="fixeBoxSpan">购物车</span> 
      <div class="cartBox">
        <div class="sc_message">
            <?php if ($this->_var['number'] > 0): ?>
            <div class="sc_main">
            	<dl class="sc_main_all">
                	<dt>总价：<span id="totalDesc">￥<?php echo $this->_var['amount']; ?></span></dt>
                    <dd>共<span id="totalNumber"><?php echo $this->_var['number']; ?></span>件商品</dd>
                </dl>
                <div class="sc_main_goods" data-discount_rate="<?php echo $this->_var['discount_rate']; ?>">
                   <?php $_from = $this->_var['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_86801100_1423625015');if (count($_from)):
    foreach ($_from AS $this->_var['goods_0_86801100_1423625015']):
?>
				        <?php if ($this->_var['goods_0_86801100_1423625015']['packageBuy'] == '0'): ?>
							<dl id="mini_cart_li_<?php echo $this->_var['goods_0_86801100_1423625015']['rec_id']; ?>">
								<dt><a href="<?php echo $this->_var['goods_0_86801100_1423625015']['url']; ?>"><img src="<?php echo $this->_var['goods_0_86801100_1423625015']['goods_thumb']; ?>" width="80" height="80" /></a></dt>
								<dd><a href="<?php echo $this->_var['goods_0_86801100_1423625015']['url']; ?>"><?php echo $this->_var['goods_0_86801100_1423625015']['short_name']; ?></a>
									<div><span class="price">¥<?php echo $this->_var['goods_0_86801100_1423625015']['goods_price']; ?></span>
										<span class="number">
											<input type="text" value="<?php echo $this->_var['goods_0_86801100_1423625015']['goods_number']; ?>" onKeyUp="keyUpCartNum(this,<?php echo $this->_var['goods_0_86801100_1423625015']['rec_id']; ?>);"  id="minicart_num_<?php echo $this->_var['goods_0_86801100_1423625015']['rec_id']; ?>" style="text-align:center;">
											<div class="standard_3_1"><a onClick="onClickCartNum(<?php echo $this->_var['goods_0_86801100_1423625015']['rec_id']; ?>,+1);"></a><a onClick="onClickCartNum(<?php echo $this->_var['goods_0_86801100_1423625015']['rec_id']; ?>,-1);"></a></div>
										</span>
										<span class="standard_3_2"><a href="javascript:void(0)" onclick="deleteCartGoods(<?php echo $this->_var['goods_0_86801100_1423625015']['rec_id']; ?>)">删除</a></span>
									</div>
								</dd>
							</dl>
						<?php else: ?>
							<?php if ($this->_var['goods_0_86801100_1423625015']['packageBuy'] == '1'): ?>
							    <div class="index_sc_taocan">
									<span class="index_sc_taocan_title">
										<h6>推荐搭配套餐</h6>
										<table border="0" cellspacing="0" cellpadding="0">
										    <tr>
												<td class="per_number" data-per-number="<?php echo $this->_var['goods_0_86801100_1423625015']['goods_number']; ?>"><?php echo $this->_var['goods_0_86801100_1423625015']['goods_number']; ?>套</td>
												<td class="per_amount">XXXX</td>
										    </tr>
										</table>
									</span>
							<?php endif; ?>
									<dl>
										<dt><a href="<?php echo $this->_var['goods_0_86801100_1423625015']['url']; ?>"><img src="<?php echo $this->_var['goods_0_86801100_1423625015']['goods_thumb']; ?>" width="80" height="80" /></a></dt>
										<dd>
											<a href="<?php echo $this->_var['goods_0_86801100_1423625015']['url']; ?>"><?php echo $this->_var['goods_0_86801100_1423625015']['short_name']; ?></a>
											<div><span class="price" data-shop-price="<?php echo $this->_var['goods_0_86801100_1423625015']['goods_price']; ?>">¥<?php echo $this->_var['goods_0_86801100_1423625015']['goods_price']; ?></span></div>
										</dd>
									</dl>
							<?php if ($this->_var['goods_0_86801100_1423625015']['packageBuy'] == '3'): ?>
							    </div>
							<?php endif; ?>
						<?php endif; ?>
                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
                <span class="sc_botton"><a href="./<?php echo $this->_var['staticPages']['flow']; ?>"></a></span>
            </div>
            <?php else: ?>
                <span style=" width:280px; text-align:center; padding:30px 0; display:block;">购物车内暂无商品，赶紧选购吧</span>
            <?php endif; ?>
        </div>
      </div>
