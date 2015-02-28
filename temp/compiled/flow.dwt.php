<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>
<!-- 
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
-->
<link href="style/css/shoppingcart.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="style/js/jquery.min.js"></script>

<?php echo $this->smarty_insert_scripts(array('files'=>'yhd_flow.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,shopping_flow.js,region.js,')); ?>
<script type="text/javascript" src="style/js/cart_deliv_addr.js"></script>
<script type="text/javascript" src="style/js/ele_autoCenter.js"></script>
<script type="text/javascript" src="style/js/cart_checkbox.js"></script>

</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
	<?php if ($this->_var['step'] == "cart"): ?> 

     <p class="sc_step"></p>
     <?php if ($this->_var['goods_list']): ?>
     <form id="formCart" name="formCart" method="post" action="flow.php">
    <div class="sc_box">
        <div class="sc_title">
            <div class="sc_a"><input name="" type="checkbox" value="" id="sc_all" class="sc_all"/></div>
            <div class="sc_f">全选</div>
            <div class="sc_e">商品信息</div>
            <div class="sc_c">单价</div>
            <div class="sc_c">数量</div>
            <div class="sc_c">金额</div>
            <div class="sc_d">操作</div>
        </div>
	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
		<?php if ($this->_var['goods']['packageBuy_id'] == '0'): ?>
			<div class="sc_goods">
				<div class="sc_a"><input  type="checkbox" class="sc_good" value="<?php echo $this->_var['goods']['rec_id']; ?>" />&nbsp;&nbsp;</div>
				<div class="sc_b">
					<dl class="sc_goods_1">
						<dt><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="80" height="80" /></a></dt>
						<dd><a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a><span><?php echo nl2br($this->_var['goods']['goods_attr']); ?></span></dd>
					</dl>
				</div>
				<div class="sc_c">
					<ul class="sc_goods_2">
						<li class="sc_goods_2_1">¥<?php echo $this->_var['goods']['market_price']; ?> </li>
						<li class="sc_goods_2_2">¥<?php echo $this->_var['goods']['goods_price']; ?> </li>
						<!--<li class="sc_goods_2_3">会员折扣</li>-->
					</ul>
				</div>
				<div class="sc_c">
					<p class="sc_goods_3">					   
						<input id="items_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['goods_number']; ?>" type="text" style="text-align:center" 
						onblur="beforeCartNumInput('<?php echo $this->_var['goods']['rec_id']; ?>',document.getElementById('items_<?php echo $this->_var['goods']['rec_id']; ?>').value)"/>
						<div class="sc_goods_3_1"><a onClick="flowClickCartNum(<?php echo $this->_var['goods']['rec_id']; ?>,+1);"></a><a  onClick="flowClickCartNum(<?php echo $this->_var['goods']['rec_id']; ?>,-1);"></a></div>
					</p>
					</div>
					<div class="sc_c">
						<span class="sc_goods_4"  id="total_items_<?php echo $this->_var['goods']['rec_id']; ?>">¥<?php echo $this->_var['goods']['subtotal']; ?></span>
					</div>
					<div class="sc_d">
						<span class="sc_goods_5">
							<a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>)" id="addFavorite">加入收藏夹</a>
							<a class="sc_goods_5_1" href="flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>';">删除</a>
						</span>
					</div>
				</div>
		<?php else: ?>
	        <?php if ($this->_var['goods']['packageBuy'] == '1'): ?> 		
				<div class="shoppingcatr_taocan">
					<div class="shoppingcatr_taocan_title titleDiv">
							搭配套餐
					</div>
					<div class="sc_a_1 shoppingcatr_taocan_padding autoCenter">
						<input class="sc_good" goods-varieties="1" type="checkbox" value="<?php echo $this->_var['goods']['packageBuy_id']; ?>" />&nbsp;&nbsp;
					</div>		
			        <div class="shoppingcatr_taocan_goods">
			<?php endif; ?>
			    <div class="shoppingcatr_taocan_goods_box" data-goods-price="<?php echo $this->_var['goods']['goods_price']; ?>" data-rec-id="<?php echo $this->_var['goods']['rec_id']; ?>">
					<div class="sc_b">
						<dl class="sc_goods_1">
							<dt><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"/></a></dt>
							<dd><a href="<?php echo $this->_var['goods']['url']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a><span><?php echo nl2br($this->_var['goods']['goods_attr']); ?></span></dd>
						</dl>
					</div>
					<div class="sc_c">
						<ul class="sc_goods_2">
							<li class="sc_goods_2_1">¥<?php echo $this->_var['goods']['market_price']; ?> </li>
							<li class="sc_goods_2_2">¥<?php echo $this->_var['goods']['goods_price']; ?> </li>
							<!--<li class="sc_goods_2_3">+1000积分</li>-->
						</ul>
					</div>
				</div>
			<?php if ($this->_var['goods']['packageBuy'] == '3'): ?>
				</div>
				<div class="autoCenter">
					<div class="sc_c shoppingcatr_taocan_padding">
						<span class="sc_goods_3">
							<input id="items_<?php echo $this->_var['goods']['packageBuy_id']; ?>" class="taocan_num" value="<?php echo $this->_var['goods']['goods_number']; ?>" type="text" style="text-align:center" 
							onblur="beforeCartNumInput('<?php echo $this->_var['goods']['packageBuy_id']; ?>',document.getElementById('items_<?php echo $this->_var['goods']['packageBuy_id']; ?>').value,'taocan')"/>
							<div class="sc_goods_3_1">
								<a onClick="flowClickCartNum(<?php echo $this->_var['goods']['packageBuy_id']; ?>,+1,'taocan');"></a>
								<a  onClick="flowClickCartNum(<?php echo $this->_var['goods']['packageBuy_id']; ?>,-1,'taocan');"></a>
							</div>
						</span>
					</div>
					<div class="sc_c shoppingcatr_taocan_padding">
						<span class="sc_goods_4"  id="total_items_<?php echo $this->_var['goods']['packageBuy_id']; ?>">¥<?php echo $this->_var['goods']['subtotal']; ?></span>
						<br/><span class="sc_goods_2_3 packageBuyHY">优惠¥1000</span>
					</div>
					<div class="sc_d shoppingcatr_taocan_padding">
						<span class="sc_goods_5">
							<a class="sc_goods_5_1" href="flow.php?step=drop_goods&amp;buyType=taocan&amp;id=<?php echo $this->_var['goods']['packageBuy_id']; ?>'">删除</a>
						</span>
					</div>
				</div>
			</div>			
			<?php endif; ?>		 
		<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	
	<?php echo $this->fetch('library/packagebuydiscount.lbi'); ?>
		
        </div>

	<div class="sc_price">
            <div class="sc_a">
                <table width="50" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="50" align="right"><input name="" type="checkbox" value="" id="sc_all_two"/></td></tr>
                </table>
            </div>
            <div class="sc_f"><a href="javascript:void(0)" id="clearAllCart" onclick="checkAll('check')">全选</a></div>
            <div class="sc_c"><a href="javascript:if (confirm('<?php echo $this->_var['lang']['drop_goods_confirm']; ?>')) drop_selected_goods()">删除</a></div>
            <div class="sc_c"><a href="javascript:drop_collect_goods()">加入收藏夹</a></div>
	    <table class="sc_price_1" width="550" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="149">已选商品<span id="totalDifGoodsNumber"><?php if ($this->_var['total_goods_count']): ?><?php echo $this->_var['total_goods_count']; ?><?php else: ?><?php 
$k = array (
  'name' => 'cart_info_number',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?><?php endif; ?></span>件</td>
                  <td width="42">合计：</td>
                  <td width="196"><b id="amount">¥<?php echo $this->_var['total_goods_price']; ?></b></td>
                  <td width="163">
		  <a href="javascript:void(0)" onclick="checkoutGoods()" 
		  class="settlementBt ctn_shopping" 
		  id="confirmToPay">
		  <input type="button" value="结&nbsp;&nbsp;算"  />
		  </a>
		  </td>
                </tr>
            </table>
	     <?php else: ?> 
	     <div class="main middle over">
		<p class="sc_nothing">您的购物车还是空的，赶快去逛逛吧！
		    <a href="./index.php">现在就去逛</a>
		    </p>
	     </div>
  <?php endif; ?>
	</div>
	<div class="sc_youlike">
        <p><span>猜你喜欢</span><a href="user.php?act=collection_list">去我的收藏夹&gt;&gt;</a></p>
        <div class="main over">
<?php $_from = $this->_var['cai']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai_0_76356100_1423625015');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cai_0_76356100_1423625015']):
        $this->_foreach['cats']['iteration']++;
?>
            <dl>
                <dt><a href="goods.php?id=<?php echo $this->_var['cai_0_76356100_1423625015']['goods_id']; ?>"><img src="<?php echo $this->_var['cai_0_76356100_1423625015']['goods_thumb']; ?>" /></a></dt>
                <dd><a href="goods.php?id=<?php echo $this->_var['cai_0_76356100_1423625015']['goods_id']; ?>"><?php echo $this->_var['cai_0_76356100_1423625015']['goods_name']; ?></a>
                    <span class="sc_youlike_price1">￥<?php echo $this->_var['cai_0_76356100_1423625015']['shop_price']; ?></span><span class="sc_youlike_price2">￥<?php echo $this->_var['cai_0_76356100_1423625015']['market_price']; ?></span>
                </dd>
            </dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <input type="hidden" name="step" value="update_cart" />
        </form>
    </div>   

<?php endif; ?> 

	<?php if ($this->_var['step'] == "checkout"): ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'add_address.js,')); ?>
<script type="text/javascript" src="/style/js/add_address.js"></script>
    <p class="sc_order_step"></p>
   <form action="flow.php" method="post" name="theForm" id="theForm" onSubmit="return checkOrderForm(this);">
 <div class="sc_box">
    	<p class="sc_order_title">
		<span>确认收货地址</span>
		<a href="user.php?act=address_list">管理收货地址</a>
		</p>
        <ul id="up_down" class="sc_order_address">
                
					<?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
        $this->_foreach['loop']['iteration']++;
?>
							<?php if ($this->_var['consignee']['consignee']): ?>
						<li id="address_id<?php echo $this->_var['consignee']['address_id']; ?>" class="<?php if ($this->_var['consignee']['is_first'] == 1): ?>sc_order_address_choose<?php else: ?>sc_order_address_1<?php endif; ?>"
						onclick=" set_moren('<?php echo $this->_var['consignee']['address_id']; ?>') "
					         style="cursor:pointer;"><b><?php echo htmlspecialchars($this->_var['consignee']['add']); ?><?php echo htmlspecialchars($this->_var['consignee']['address']); ?></b><span><?php echo $this->_var['consignee']['consignee']; ?>（收）</span><span><?php echo $this->_var['consignee']['tel']; ?></span><input type="hidden" name="addr" value="1" id="addr"></li> 				
							<?php elseif (($this->_foreach['loop']['iteration'] - 1) == 0): ?>
							  <li style="text-align: center;line-height:50px;font-size:25px;">请添加收货地址！
							  <input type="hidden" name="addr" value="" id="addr">
							  </li>			
							<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        </ul>
       
        <div class="sc_order_botton" style="margin:10px 0;">
        	<a href="#" class="sc_order_botton_1" onclick="elem_toggle('container')">使用新地址</a>
                <a href="javascript:void(0)" id="show"  onclick="document.getElementById('up_down').style.height='auto';document.getElementById('hidden').style.display='';document.getElementById('show').style.display='none';">查看全部收货地址</a>
                <a href="javascript:void(0)" id="hidden" style="display:none;" onclick="document.getElementById('up_down').style.height='148px';document.getElementById('hidden').style.display='none';document.getElementById('show').style.display='';">收起地址</a>
        </div>
  
    </div>
    </div>
      <table class="sc_order_express" width="1198" border="0" cellpadding="0" cellspacing="0">
        <tr><td colspan="5"><span>配送方式</span></td></tr>
        <tr class="title">
         <td width="200" align="center">名称</td><td width="363">收费规则</td>
        </tr>
      	<?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ship');if (count($_from)):
    foreach ($_from AS $this->_var['ship']):
?>
        <tr>
          <td align="center"><input type="radio"  name="shipping" value="<?php echo $this->_var['ship']['shipping_id']; ?>" checked="true" />&nbsp;<?php echo $this->_var['ship']['shipping_name']; ?>
           </td>
           <td align="left">
             <?php echo $this->_var['ship']['shipping_desc']; ?>          
		  </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
<table class="sc_order_express" width="1198" border="0" cellpadding="0" cellspacing="0" style="display:none;">
        <tr><td colspan="5"><span>支付方式</span></td></tr>
        <tr class="title">
          <td width="200" align="center">名称</td><td width="363">订购描述</td><td width="200" align="center">手续费</td>
        </tr>
<?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
        <tr>
          <td align="center"><input type="radio" name="payment" value="<?php echo $this->_var['payment']['pay_id']; ?>" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id'] || $this->_var['order']['pay_id'] == 0): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" onclick="selectPayment(this)" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?>/>
            <?php echo $this->_var['payment']['pay_name']; ?></td>
          <td><?php echo $this->_var['payment']['pay_desc']; ?></td>
          <td align="center"><?php echo $this->_var['payment']['format_pay_fee']; ?>元</td>
        </tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       
    </table>

 <?php if ($this->_var['is_exchange_goods'] != 1): ?>
    <table width="1198" border="0" cellspacing="0" cellpadding="0" class="sc_order_fapiao" style="display:none;">   
	  <tr>
        <td width="100"><span>发票信息</span></td>
        <td width="116">&nbsp;</td>
        <td width="110">&nbsp;</td>
        <td width="138">&nbsp;</td>
        <td width="110">&nbsp;</td>
        <td width="138">&nbsp;</td>
        <td width="111">&nbsp;</td>
        <td width="67">&nbsp;</td>
        <td width="306">&nbsp;</td>
      </tr>
	 
      <tr class="sc_order_fapiao_1">
        <td align="right">开发票：</td>
        <td><label for="select"></label>
          <select name="need_inv" id="ECS_NEEDINV" onchange="changeNeedInv()"><option value="0">不需要</option><option value="1" >需要</option></select>
        </td>
        <td align="right">发票类型：</td>
        <td><label for="select2"></label>
          <select name="inv_type" id="ECS_INVTYPE"  onchange="changeNeedInv()" disabled>
            <?php echo $this->html_options(array('options'=>$this->_var['inv_type_list'],'selected'=>$this->_var['order']['inv_type'])); ?>
          </select>
        </td>
        <td align="right">发票内容：</td>
        <td><label for="select3"></label>
          <select name="inv_content" id="ECS_INVCONTENT"   onchange="changeNeedInv()" disabled>
            <?php echo $this->html_options(array('values'=>$this->_var['inv_content_list'],'output'=>$this->_var['inv_content_list'],'selected'=>$this->_var['order']['inv_content'])); ?>
          </select>
        </td>
        <td align="right">发票抬头：</td>
        <td><label for="textfield"></label><input name="inv_payee" type="text"  id="ECS_INVPAYEE"  value="<?php echo $this->_var['order']['inv_payee']; ?>" onblur="changeNeedInv()" disabled/></td>
      </tr>
    </table>
	  <?php endif; ?>
    <div class="sc_box sc_order_margin_1">
    	<p class="sc_order_title"><span>确认订单信息</span></p>
        <div class="sc_title">
          <div class="sc_f"></div>
          <div class="sc_e sc_order_mr_1">商品信息</div>
          <div class="sc_c sc_order_mr_1">单价</div>
          <div class="sc_c sc_order_mr_1">数量</div>
          <div class="sc_c">小计</div>
        </div>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
        <?php if ($this->_var['goods']['packageBuy_id'] == '0'): ?>
			<div class="sc_goods">
			    <div class="sc_b sc_order_mr_1">
					<dl class="sc_goods_1">
					    <dt>
							<a href="<?php echo $this->_var['goods']['url']; ?>">
								<img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="80" height="80" />
							</a>
						</dt>
						<dd>
							<a href="<?php echo $this->_var['goods']['url']; ?>">
								<?php echo $this->_var['goods']['goods_name']; ?>
							</a>
							<span>规格：<?php echo nl2br($this->_var['goods']['goods_attr']); ?></span>
						</dd>
					</dl>
			    </div>
				<div class="sc_c sc_order_mr_1">
				    <ul class="sc_goods_2">
					   <li class="sc_goods_2_2">¥<?php if ($this->_var['is_exchange_goods'] != 1): ?><?php echo $this->_var['goods']['formated_goods_price']; ?> <?php else: ?><?php echo $this->_var['goods']['needed_money']; ?><?php endif; ?></li>
				    </ul>
				</div>
				<div class="sc_c sc_order_mr_1">
					<?php echo $this->_var['goods']['goods_number']; ?>
				</div>
				<div class="sc_c">
					<span class="sc_goods_4">
						¥<?php if ($this->_var['is_exchange_goods'] != 1): ?><?php echo $this->_var['goods']['formated_subtotal']; ?> <?php else: ?><?php echo $this->_var['total']['needed_money']; ?><?php endif; ?>
					</span>
				</div>
			</div>
		<?php else: ?>
			<?php if ($this->_var['goods']['packageBuy'] == '1'): ?>
				<div class="shoppingcatr_taocan">
					<div class="shoppingcatr_taocan_title titleDiv">
						搭配套餐
					</div>
					<div class="sc_a_1 shoppingcatr_taocan_padding">&nbsp;&nbsp;</div>
					<div class="shoppingcatr_taocan_goods">
			<?php endif; ?>
						<div class="shoppingcatr_taocan_goods_box" data-goods-price="<?php echo $this->_var['goods']['goods_price']; ?>">
							<div class="sc_b">
							<dl class="sc_goods_1">
								<dt><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="80" height="80" /></a></dt>
								<dd><a href="<?php echo $this->_var['goods']['url']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a><span><?php echo $this->_var['goods']['goods_attr']; ?></span></dd>
							</dl>
							</div>
							<div class="sc_c">
								<ul class="sc_goods_2">
									<li class="sc_goods_2_1">¥<?php echo $this->_var['goods']['market_price']; ?> </li>
									<li class="sc_goods_2_2">¥<?php echo $this->_var['goods']['goods_price']; ?> </li>
									<!--<li class="sc_goods_2_3">+1000积分</li>-->
								</ul>
							</div>
						</div>
			<?php if ($this->_var['goods']['packageBuy'] == '3'): ?>
			        </div> 
					
						<div class="autoCenter" style="margin-left:65px;">
						
							<div class="sc_c shoppingcatr_taocan_padding">
								<span class="sc_goods_3" ><?php echo $this->_var['goods']['goods_number']; ?></span>
								<input type="hidden" class="taocan_num" value="<?php echo $this->_var['goods']['goods_number']; ?>"/>
							</div>
							<div class="sc_c shoppingcatr_taocan_padding" style="margin-left:80px;">
								<span class="sc_goods_4"></span>
								<!-- <span class="huiyuan"><img src="themes/yihaodian/images/huiyuan_1.png" /></span>-->
							</div>
							
						</div>
						<div class="sc_d shoppingcatr_taocan_padding"></div>
					
				</div>
			<?php endif; ?>
		<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php echo $this->fetch('library/packagebuydiscount.lbi'); ?>
			
    </div>
    <div class="sc_box sc_order_margin_1">
    	<p class="sc_order_title">
            <span>其他信息</span>
        </p>
        <table width="800" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		  </tr>
		</table>
    	<dl class="sc_order_other">
        	<dt>使用优惠券：</dt>
            <dd>
            	<select id="ECS_COUPONS" style="border:1px solid #ccc;" onchange="changeCoupons(this.value)" name="coupons">
	              <option value="0" selected="selected">不使用优惠券</option>
	              <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');if (count($_from)):
    foreach ($_from AS $this->_var['coupon']):
?>
		              <option value="<?php echo $this->_var['coupon']['sent_coupon_id']; ?>">
		              	<?php echo $this->_var['coupon']['coupon_value']; ?>元优惠券(满<?php echo $this->_var['coupon']['restriction_ext']; ?>可用)
		              </option>
	              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            	</select>
        	</dd>
        </dl>
        <dl class="sc_order_other">
            <dt>留言：</dt>
            <dd><textarea name="postscript" cols="80" rows="3" id="postscript"><?php echo htmlspecialchars($this->_var['order']['postscript']); ?></textarea></dd>
        </dl>
<?php if ($this->_var['how_oos_list']): ?>
        <dl class="sc_order_other">
            <dt>缺货处理：</dt>
            <dd>
                <?php $_from = $this->_var['how_oos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('how_oos_id', 'how_oos_name');if (count($_from)):
    foreach ($_from AS $this->_var['how_oos_id'] => $this->_var['how_oos_name']):
?>
                    <input name="how_oos" type="radio" value="<?php echo $this->_var['how_oos_id']; ?>" <?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?>checked<?php endif; ?> onclick="changeOOS(this)" /><?php echo $this->_var['how_oos_name']; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
            </dd>
        </dl>
<?php endif; ?>
    </div>
    <div class="sc_box sc_order_margin_1">
        <p class="sc_order_submit" >

        	<span id="ECS_ORDERTOTAL">
        	<?php echo $this->fetch('library/order_total.lbi'); ?>
        	</span>
<strong>寄送至：</strong><span id="from"><?php echo htmlspecialchars($this->_var['consignee1']['address1']); ?><?php echo htmlspecialchars($this->_var['consignee1']['address']); ?></span><br />
<strong>收货人：</strong><span id="to"><?php echo htmlspecialchars($this->_var['consignee1']['consignee']); ?>&nbsp;<?php echo $this->_var['consignee1']['tel']; ?></span>
        </p>
        <p class="sc_order_submit_3">
            <a href="./flow.php" class="sc_order_submit_3_a">返回购物车</a>
            <a href="javascript:validate()" class="sc_order_submit_3_b">提交订单</a>
				<input type="hidden" value="<?php echo $this->_var['buyType']; ?>" name="buyType">
            <input type="hidden" name="step" value="done" />
        </p>
    </div>
    </form>
    <div class="sc_youlike">
       	<p><span>猜你喜欢</span><a href="./user.php?act=collection_list">去我的收藏夹</a></p>
            <div class="main over">
<?php $_from = $this->_var['cai']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai_0_78685200_1423625015');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cai_0_78685200_1423625015']):
        $this->_foreach['cats']['iteration']++;
?>
                <dl>
                    <dt><a href="goods.php?id=<?php echo $this->_var['cai_0_78685200_1423625015']['goods_id']; ?>"><img src="<?php echo $this->_var['cai_0_78685200_1423625015']['goods_thumb']; ?>" /></a></dt>
                    <dd><a href="goods.php?id=<?php echo $this->_var['cai_0_78685200_1423625015']['goods_id']; ?>"><?php echo $this->_var['cai_0_78685200_1423625015']['goods_name']; ?></a>
                        <span class="sc_youlike_price1">￥<?php echo $this->_var['cai_0_78685200_1423625015']['shop_price']; ?></span><span class="sc_youlike_price2">￥<?php echo $this->_var['cai_0_78685200_1423625015']['market_price']; ?></span>
                    </dd>
                </dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
    </div>
    
<form action="user.php" method="post" name="newForm" onsubmit="return checkAdd()" id="newForm">
            <div class="newaddress_box"  id="container" style="display:none;">
	    <table class="newaddress" width="700" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="151" align="right"><b>*</b>所在地区：</td>
                <td width="549"><label for="select5"></label>
                  <span class="select_a">
                        <select name="country" id="selCountries_1" onchange="region.changed(this, 1, 'selProvinces_1')" style="display:none;">
                      <option value="1" selected>中国</option>
                    </select>
                        <select name="province" id="selProvinces_1" onchange="region.changed(this, 2, 'selCities_1')">
                            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                            <?php $_from = $this->_var['province_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                            <option value="<?php echo $this->_var['province']['region_id']; ?>" ><?php echo $this->_var['province']['region_name']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                 </span>
                  <span class="select_a">
                        <select name="city" id="selCities_1" onchange="region.changed(this, 3, 'selDistricts_1')">
                            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
                            <?php $_from = $this->_var['city_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                            <option value="<?php echo $this->_var['city']['region_id']; ?>" ><?php echo $this->_var['city']['region_name']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                   </span>
                   <span class="select_a">
                        <select name="district" id="selDistricts_1" >    
                            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
                            <?php $_from = $this->_var['district_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                            <option value="<?php echo $this->_var['district']['region_id']; ?>" ><?php echo $this->_var['district']['region_name']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                   </span>
                </td>
              </tr>
              <tr>
                <td align="right"><b>*</b>详细地址：</td>
                <td><label for="textfield2"></label>
                  <span class="select_b"><input type="text" name="address" id="address" /></span></td>
              </tr>
              <tr>
                <td align="right">邮编：</td>
                <td><span class="select_b"><input type="text" name="zipcode" id="zipcode" /></span></td>
              </tr>
              <tr>
                <td align="right"><b>*</b>收货人姓名：</td>
                <td><span class="select_b"><input type="text" name="consignee" id="consignee"/></span></td>
              </tr>
              <tr>
                <td align="right"><b>*</b>手机：</td>
                <td><span class="select_b"><input type="text" name="tel" id="tel"/></span></td>
              </tr>
              <tr>
                <td align="right"><input type="checkbox" name="is_first" id="is_first" value="1" checked="checked"/>
                  <label for="checkbox2"></label></td>
                <td>设为默认收货地址</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                    <a class="select_c" href="#" onclick="check_format('check_out'); ">保存收货地址</a>
                    <a class="select_d" href="#xiugai" onclick="clearAll(); " id="clearAll">取消</a>
                    <input type="hidden" value="act_edit_address" name="act">
				
                    <input type="hidden" value="" name="address_id" id="address_id">
                </td>
              </tr>
            </table>
	    </div>
 </form>

     <?php endif; ?>


    <?php if ($this->_var['step'] == "done"): ?> 
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<link href="style/css/pay.css" rel="stylesheet" type="text/css" />
<link href="style/css/shoppingcart.css" rel="stylesheet" type="text/css" />
        <div class="pay">
  <div class="pay_1">
        	<span></span>
            <p><?php if ($this->_var['immediate_pay']): ?>请确认支付方式后付款！<?php else: ?>您的订单信息已提交！<?php endif; ?></p>
            
<b class="payok_1">支付金额共计：<?php if ($this->_var['immediate_pay']): ?><?php echo $this->_var['order']['total_fee']; ?><?php else: ?><?php echo $this->_var['total']['amount_formated']; ?><?php endif; ?>元<br />
订单号：<?php echo $this->_var['order']['order_sn']; ?><br>
<div style="position: absolute; opacity: 0; filter:Alpha(opacity=0);" id="change_pay">
<?php echo $this->_var['pay_online']; ?>
</div>
</b>
<table cellspacing="0" cellpadding="0" border="0" width="350" class="payok_2">
<script>
    $(document).ready(function(){
    var pay_code = '<?php echo $this->_var['pay_code']; ?>';
	switch(pay_code)
	{
	  case 'alipay'://支付宝
	   $('.payment').hide();
	  break;
	   case 'kuaiqian'://快钱
	  $('.payment').show();
	   break;
	}
	
     $('.payok_2 input').change(function(){
		 if($(this).val()=='6') //kuaiqian
		 {
		  $('.payment').show();
		 }
		 else
		 {
		 $('.payment').hide();
		 }
	   Ajax.call( 'flow.php?step=ajax_check_pay', 'payment=' + $(this).val() + '&order_id=' + '<?php echo $this->_var['order']['order_id']; ?>', paymentChange_callback , 'GET', 'TEXT', false, true);
		
	 });
   });
   function paymentChange_callback(result)
   {
     $('#change_pay').html(result)
   }
</script>
  <tbody>
  <tr>
    <td width="92">支付方式：</td>
    <td width="28">
		<input type="radio" value="4"  name="payment" <?php if ($this->_var['pay_code'] == 'alipay'): ?>checked<?php endif; ?>>
	</td>
    <td width="127">
		<a href="#"><img width="91" height="30"  src="style/images/pay_1.gif"></a>
	</td>
    <td width="31">
		<input type="radio" value="6"  name="payment" <?php if ($this->_var['pay_code'] == 'kuaiqian'): ?>checked<?php endif; ?>>
	</td>
    <td width="122">
		<a href="#"><img width="91" height="30" src="style/images/pay_2.gif"></a>
	</td>
  </tr>
</tbody>
</table>

        <?php echo $this->fetch('library/kuaiqian_bank_select.lbi'); ?>
		
	<b class="payok_1">
		<a class="common_botton" href="javascript:document.getElementById('pay_btn').click()">立即支付</a>
		<a class="payok_1_a" href="user.php?act=order_list">查看订单</a>
	</b>
        </div>
</div>
<div class="sc_youlike">
       	<p>
            	<span>精品推荐</span><a href="./user.php?act=collection_list">去我的收藏夹</a>
            </p>
            <div class="main over">
<?php $_from = $this->_var['cai']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cai_0_79558600_1423625015');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cai_0_79558600_1423625015']):
        $this->_foreach['cats']['iteration']++;
?>
                <dl>
                    <dt><a href="goods.php?id=<?php echo $this->_var['cai_0_79558600_1423625015']['goods_id']; ?>"><img src="<?php echo $this->_var['cai_0_79558600_1423625015']['goods_thumb']; ?>" /></a></dt>
                    <dd><a href="goods.php?id=<?php echo $this->_var['cai_0_79558600_1423625015']['goods_id']; ?>"><?php echo $this->_var['cai_0_79558600_1423625015']['goods_name']; ?></a>
                        <span class="sc_youlike_price1">￥<?php echo $this->_var['cai_0_79558600_1423625015']['shop_price']; ?></span><span class="sc_youlike_price2">￥<?php echo $this->_var['cai_0_79558600_1423625015']['market_price']; ?></span>
                    </dd>
                </dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>

<?php endif; ?>



<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var orderId = "<?php echo $this->_var['order']['order_id']; ?>"; 
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
</html>