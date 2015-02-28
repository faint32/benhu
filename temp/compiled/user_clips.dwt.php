<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link href="style/home/css/home.css" rel="stylesheet" type="text/css" />
<link href="style/css/item.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<link href="style/home/css/other.css" rel="stylesheet" type="text/css" />
<link href="style/home/css/orders.css" rel="stylesheet" type="text/css" />
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.9.1.min.js,common.js,zxxFile.js,zxxHtml5UpLoad.js,left_nav_2.js,curvycorners.src.js,home_tab.js,lrtk.js')); ?>
<script type="text/javascript" src="style/js/ele_autoCenter.js"></script>
<script type="text/javascript" src="style/js/userClipsOnly.js"></script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/category_tree.lbi'); ?>
<div id="Lists"></div>
<div class="home">
	
    
        <?php echo $this->fetch('library/user_left.lbi'); ?>
     

       
    <?php if ($this->_var['action'] == 'default'): ?>   	
	   <div class="home_middle">
        	<div class="home_m_1">
            	<div class="home_m_1_p">
					<h3 class="home_column_title">交易提醒</h3>
					<a href="javascript:show_orders('#banner-slide')">待付款<span><?php echo $this->_var['unpaid_count']; ?></span></a>
					<a href="javascript:show_orders('#banner-slide1')">待收货<span><?php echo $this->_var['unrecieved_count']; ?></span></a>
					<a href="javascript:show_orders('#banner-slide2')">待评论<span><?php echo $this->_var['uncommented_count']; ?></span></a>
				</div>
                <div class="lunbo-recommend">
					<div class="slide-pics" id="banner-slide">
						<div class="scrollable">
								<ul class="items" >
								
								  <?php if (! $this->_var['unpaid_orders']): ?>
								    <li class="item"> 
											<div class="home_m_2 home_m_2_mr10">
												<span class="home_m_2_title"><a href="javascript:void(0)">您没有待付款的商品 </a></span>
											</div>
									 
											<div class="home_m_2">
												<span class="home_m_2_title"><a href="javascript:void(0)">您没有待付款的商品 </a></span>
											</div>
									</li>
								  <?php endif; ?>
								<?php $_from = $this->_var['unpaid_orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');$this->_foreach['unpaid'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['unpaid']['total'] > 0):
    foreach ($_from AS $this->_var['order']):
        $this->_foreach['unpaid']['iteration']++;
?>
									 <?php if (($this->_foreach['unpaid']['iteration'] - 1) % 2 == 0): ?>
									<li class="item"> 
											<div class="home_m_2 home_m_2_mr10">
												<span class="home_m_2_title"><a href="javascript:void(0)">待付款 </a></span>
												<dl>
													<dt><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><img src="<?php echo $this->_var['order']['one_goods_thumb']; ?>" /></a></dt>
													<dd><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><?php echo $this->_var['order']['one_goods_name']; ?></a><span>¥<?php echo $this->_var['order']['total_fee']; ?></span></dd>
												</dl>
												<a href="user.php?act=order_list&ctl=1" class="home_m_2_button">去付款</a>
											</div>
											 <?php if (($this->_foreach['unpaid']['iteration'] == $this->_foreach['unpaid']['total'])): ?> 
											 <div class="home_m_2">
												<span class="home_m_2_title"></span>												
											</div>
											 </li>
											 <?php endif; ?>
											<?php else: ?>
											<div class="home_m_2">
												<span class="home_m_2_title"><a href="javascript:void(0)">待付款 </a></span>
												<dl>
													<dt><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><img src="<?php echo $this->_var['order']['one_goods_thumb']; ?>" /></a></dt>
													<dd><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><?php echo $this->_var['order']['one_goods_name']; ?></a><span>¥<?php echo $this->_var['order']['total_fee']; ?></span></dd>
									            </dl>
												<a href="user.php?act=order_list&ctl=1" class="home_m_2_button">去付款</a>
											</div>
									</li>
								  <?php endif; ?>								
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								
								</ul>											
					    </div> 
					  <div class="prev prev-next s-index-icon"> 上一张</div>
					  <div class="next prev-next s-index-icon"> 下一张</div>
					</div>
					<div class="slide-pics" id="banner-slide1" style="display:none">
										<div class="scrollable" >
													<ul class="items" >
								  <?php if (! $this->_var['unrecieved_orders']): ?>
								    <li class="item"> 
											<div class="home_m_2 home_m_2_mr10">
												<span class="home_m_2_title"><a href="javascript:void(0)">您没有待收货的商品 </a></span>
											</div>
									 
											<div class="home_m_2">
												<span class="home_m_2_title"><a href="javascript:void(0)">您没有待收货的商品 </a></span>
											</div>
									</li>
								  <?php endif; ?>
								<?php $_from = $this->_var['unrecieved_orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');$this->_foreach['unrecieved'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['unrecieved']['total'] > 0):
    foreach ($_from AS $this->_var['order']):
        $this->_foreach['unrecieved']['iteration']++;
?>
									 <?php if (($this->_foreach['unrecieved']['iteration'] - 1) % 2 == 0): ?>
									<li class="item"> 
											<div class="home_m_2 home_m_2_mr10">
												<span class="home_m_2_title"><a href="javascript:void(0)">待收货 </a></span>
												<dl>
													<dt><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><img src="<?php echo $this->_var['order']['one_goods_thumb']; ?>" /></a></dt>
													<dd><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><?php echo $this->_var['order']['one_goods_name']; ?></a><span>¥<?php echo $this->_var['order']['total_fee']; ?></span></dd>
												</dl>
												<a href="user.php?act=order_list&ctl=3" class="home_m_2_button">去收货</a>
											</div>
											 <?php if (($this->_foreach['unrecieved']['iteration'] == $this->_foreach['unrecieved']['total'])): ?> 
											 <div class="home_m_2">
												<span class="home_m_2_title"></span>												
											</div>
											 </li>
											 <?php endif; ?>
											<?php else: ?>
											<div class="home_m_2">
												<span class="home_m_2_title"><a href="javascript:void(0)">待收货 </a></span>
												<dl>
													<dt><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><img src="<?php echo $this->_var['order']['one_goods_thumb']; ?>" /></a></dt>
													<dd><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><?php echo $this->_var['order']['one_goods_name']; ?></a><span>¥<?php echo $this->_var['order']['total_fee']; ?></span></dd>
									            </dl>
												<a href="user.php?act=order_list&ctl=3" class="home_m_2_button">去收货</a>
											</div>
									</li>
								  <?php endif; ?>								
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</ul>		
									  </div>
						  <div class="prev prev-next s-index-icon"> 上一张</div>
						  <div class="next prev-next s-index-icon"> 下一张</div>
			     	</div>   
                     <div class="slide-pics" id="banner-slide2" style="display:none">
										<div class="scrollable" >
													<ul class="items" >
								  <?php if (! $this->_var['uncommented_orders']): ?>
								    <li class="item"> 
											<div class="home_m_2 home_m_2_mr10">
												<span class="home_m_2_title"><a href="javascript:void(0)">您没有待评价的商品 </a></span>
											</div>
									 
											<div class="home_m_2">
												<span class="home_m_2_title"><a href="javascript:void(0)">您没有待评价的商品 </a></span>
											</div>
									</li>
								  <?php endif; ?>
								<?php $_from = $this->_var['uncommented_orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');$this->_foreach['uncommented'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['uncommented']['total'] > 0):
    foreach ($_from AS $this->_var['order']):
        $this->_foreach['uncommented']['iteration']++;
?>
									 <?php if (($this->_foreach['uncommented']['iteration'] - 1) % 2 == 0): ?>
									<li class="item"> 
											<div class="home_m_2 home_m_2_mr10">
												<span class="home_m_2_title"><a href="javascript:void(0)">待评价 </a></span>
												<dl>
													<dt><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><img src="<?php echo $this->_var['order']['one_goods_thumb']; ?>" /></a></dt>
													<dd><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><?php echo $this->_var['order']['one_goods_name']; ?></a><span>¥<?php echo $this->_var['order']['total_fee']; ?></span></dd>
												</dl>
												<a href="user.php?act=order_list&ctl=4" class="home_m_2_button">去评价</a>
											</div>
											 <?php if (($this->_foreach['uncommented']['iteration'] == $this->_foreach['uncommented']['total'])): ?> 
											 <div class="home_m_2">
												<span class="home_m_2_title"></span>												
											</div>
											 </li>
											 <?php endif; ?>
											<?php else: ?>
											<div class="home_m_2">
												<span class="home_m_2_title"><a href="javascript:void(0)">待评价 </a></span>
												<dl>
													<dt><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><img src="<?php echo $this->_var['order']['one_goods_thumb']; ?>" /></a></dt>
													<dd><a href="goods.php?id=<?php echo $this->_var['order']['one_goods_id']; ?>"><?php echo $this->_var['order']['one_goods_name']; ?></a><span>¥<?php echo $this->_var['order']['total_fee']; ?></span></dd>
									            </dl>
												<a href="user.php?act=order_list&ctl=4" class="home_m_2_button">去评价</a>
											</div>
									</li>
								  <?php endif; ?>								
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</ul>		
									  </div>
						  <div class="prev prev-next s-index-icon"> 上一张</div>
						  <div class="next prev-next s-index-icon"> 下一张</div>
			     	</div> 
			   </div>		
            </div>
            <div class="home_m_3">
             	<div class="home_m_1_p">
					<h3 class="home_column_title">商品收藏</h3>
					<span class="home_m_3_a">
						<a href="#">全部商品<b><?php echo $this->_var['record_count']; ?></b></a>
					</span>
				</div>
                <div class="lunbo-recommend_1">
						<div class="slide-pics_1" id="banner-slide_1">
						  <div class="scrollable_1">
							<ul class="items_1 home_m_4">
							<?php if ($this->_var['collection_goods']): ?> 
								  <?php $_from = $this->_var['collection_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['loop']['iteration']++;
?> 
								   	<?php if (($this->_foreach['loop']['iteration'] - 1) % 4 == 0): ?><li class="item_1"><?php endif; ?>
										<?php if (($this->_foreach['loop']['iteration'] - 1) % 4 == 3): ?><dl><?php else: ?><dl class="home_m_2_mr10"> <?php endif; ?>
											<dt><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" /></a></dt>
											<dd><a href="<?php echo $this->_var['goods']['url']; ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
											    <span>¥<?php if ($this->_var['goods']['promote_price'] != ""): ?> 
												       <?php echo $this->_var['goods']['promote_price']; ?>
													   <?php else: ?> 
													   <?php echo $this->_var['goods']['shop_price']; ?>
													   <?php endif; ?>
											    </span>
											</dd>
										</dl>
									<?php if (($this->_foreach['loop']['iteration'] - 1) % 4 == 3 || ($this->_foreach['loop']['iteration'] == $this->_foreach['loop']['total'])): ?></li><?php endif; ?>				
								  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
								  <?php else: ?> 
								  <br/> &nbsp;&nbsp;&nbsp;您没有收藏过商品！<br/><br/><br/><br/><br/><br/>	<br/><br/>	<br/><br/>	<br/><br/>	<br/><br/>									
							<?php endif; ?> 
							</ul>
						  </div>
						  <div class="prev_1 prev-next_1 s-index-icon_1"> 上一张</div>
						  <div class="next_1 prev-next_1 s-index-icon_1"> 下一张</div>
						</div>
				</div>
            </div>
            <div class="home_m_3">
             	<div class="home_m_1_p">
				    <h3 class="home_column_title">猜你喜欢</h3>
					<span class="home_m_3_a">
					  <a href="javascript:void(0)" onclick="you_may_love();return false;"><img src="themes/yihaodian/images/main_2_left_title_b.png" width="65" height="20" /></a>
					</span>
				</div>
            	<div id="you_may_love" class="home_m_4">
				<?php if ($this->_var['you_may_favorite']): ?>
				     <?php $_from = $this->_var['you_may_favorite']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'fav');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['fav']):
        $this->_foreach['loop']['iteration']++;
?>
					          <?php if (($this->_foreach['loop']['iteration'] == $this->_foreach['loop']['total'])): ?>
							    <dl>
								<?php else: ?>
								<dl class="home_m_2_mr10">
							  <?php endif; ?>
							  <dt><a href="goods.php?id=<?php echo $this->_var['fav']['goods_id']; ?>"><img src="<?php echo $this->_var['fav']['goods_thumb']; ?>" /></a></dt>
                              <dd><a href="goods.php?id=<?php echo $this->_var['fav']['goods_id']; ?>"><?php echo $this->_var['fav']['goods_name']; ?></a><span>¥<?php echo $this->_var['fav']['shop_price']; ?></span></dd>
							  </dl>
					  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
				<?php endif; ?>
                </div>
            </div>
        </div>
      
    	  <div class="home_right">
        	  <p class="home_right_1">
        	   <?php echo $this->fetch('library/ad_usercenter.lbi'); ?>
	  </p>
            <div class="home_right_2">
            	<h3>帐户安全：</h3>
                <dl>
                	<dt><?php if ($this->_var['info']['chat_validated'] == 3): ?>高<?php elseif ($this->_var['info']['chat_validated'] == 0): ?>低<?php else: ?>中<?php endif; ?></dt>
                    <dd class="a"><p style="width:<?php if ($this->_var['info']['chat_validated'] == 3): ?>100%<?php elseif ($this->_var['info']['chat_validated'] == 0): ?>20%<?php else: ?>60%<?php endif; ?>"></p></dd>
                    <dd><a href="user.php?act=security_settings">提升></a></dd>
                </dl>
                <div class="home_right_2_bangding">
                	<span>邮箱：<?php if ($this->_var['info']['chat_validated'] == 0 || $this->_var['info']['chat_validated'] == 2): ?><a href="user.php?act=security_edit_psd&type=email&email=<?php echo $this->_var['info']['email']; ?>&validate=2">立即绑定</a><?php else: ?><b>已绑定</b><?php endif; ?></span>
                    <span>手机：<?php if ($this->_var['info']['chat_validated'] == 0 || $this->_var['info']['chat_validated'] == 1): ?><a href="user.php?act=security_edit_psd&type=phone&phone=<?php echo $this->_var['info']['mobile_phone']; ?>&validate=0">立即绑定</a><?php else: ?><b>已绑定</b><?php endif; ?></span>
                </div>
            </div>
          <div class="home_right_3">
            	<div class="home_right_3_title">
                	<h3>购物车</h3><a href="flow.php">查看购物车详情</a>
                </div>
					<?php if ($this->_var['cart_goods']): ?> 
					   <?php $_from = $this->_var['cart_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['loop']['iteration']++;
?> 
                         			   
						 <dl>
							<dt><a href="javascript:void(0)"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" /></a></dt>
							<dd class="name"><a href="javascript:void(0)"><?php echo $this->_var['goods']['goods_name']; ?></a></dd>
							<dd class="price"><span>¥<?php echo $this->_var['goods']['goods_price']; ?></span><b>¥<?php echo $this->_var['goods']['market_price']; ?></b></dd>
						</dl>
             
					    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
						<?php else: ?>
						<br/>&nbsp;&nbsp;购物车是空的！赶紧去购物吧。
					<?php endif; ?> 
            </div>
            <div class="home_right_3">
            	<div class="home_right_3_title">
                	<h3>浏览记录</h3>
                </div>
                <div class="lunbo-recommend_2">
				<div class="slide-pics_2" id="banner-slide_2">
				  <div class="scrollable_2">
								<ul class="items_2 home_m_4">
								 <?php if ($this->_var['visit_history']): ?>
								     <?php echo $this->_var['visit_history']; ?>
									  <?php else: ?>
									    您最近没有浏览过商品！
								  <?php endif; ?>
								</ul>
				  </div>
				  <div class="qiehuanbox">
				  <div class="prev_2 prev-next_2 s-index-icon_2"> 上一张</div>
				  <div class="next_2 prev-next_2 s-index-icon_2"> 下一张</div>
				  </div>
				</div>
                </div>
                
            </div>
        </div>
    <?php endif; ?> 
     

 
        <?php if ($this->_var['action'] == 'security_settings'): ?>
			   <div class="orders">
       	  <div class="other_title">
            	<h3>安全中心</h3>
            </div>
            <dl class="safe_1">
            	<dt><img src="<?php if ($this->_var['personal_pic']): ?><?php echo $this->_var['personal_pic']; ?><?php else: ?>style/home/images/nonehead.jpg<?php endif; ?>" /></dt>
                <dd>
                	<span><?php echo $this->_var['info']['username']; ?></span>
                    <table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="122">您的安全评分为：</td>
    <td width="115"><div><p style="width:<?php if ($this->_var['info']['chat_validated'] == 3): ?>100%<?php elseif ($this->_var['info']['chat_validated'] == 0): ?>20%<?php else: ?>60%<?php endif; ?>"></p></div></td>
    <td width="463"><?php if ($this->_var['info']['chat_validated'] == 3): ?>100<?php elseif ($this->_var['info']['chat_validated'] == 0): ?>20<?php else: ?>60<?php endif; ?>分</td>
  </tr>
</table>
					<span><?php if ($this->_var['info']['chat_validated'] == 3): ?>您已启动全部安全设置！<?php else: ?>建议您启动全部安全设置，保障账户及资金安全！<?php endif; ?></span>

                </dd>
            </dl>
            <table width="900" border="0" align="center" cellpadding="0" cellspacing="0" class="safe_2">
  <tr>
    <td width="108"><p class="a"></p></td>
    <td width="110"><span>修改密码</span></td>
    <td width="480">安全性高的密码可以使帐号更安全。建议您定期更换密码，且设置一个包含数字和字母，总长度超过6位以上的密码。</td>
    <td width="200" align="center"><a class="other_botton" href="user.php?act=security_edit_psd&type=pwd">立即修改</a></td>
  </tr>
  <tr>
    <td><p <?php if ($this->_var['info_validate']['chat_validated'] == '0' || $this->_var['info_validate']['chat_validated'] == '2'): ?>class="b"<?php else: ?> class="a"<?php endif; ?>></p></td>
    <td><span>验证邮箱</span></td>
    <td>邮箱将是您的有效身份证，是您找回登录密码的方式之一。</td>
    <td align="center"><a class="other_botton" href="user.php?act=security_edit_psd&type=email&email=<?php echo $this->_var['info_validate']['email']; ?>&validate=<?php echo $this->_var['info_validate']['chat_validated']; ?>"><?php if ($this->_var['info_validate']['chat_validated'] == '0' || $this->_var['info_validate']['chat_validated'] == '2'): ?>立即绑定<?php else: ?> 解除绑定<?php endif; ?></a></td>
  </tr>
  <tr>
    <td><p <?php if ($this->_var['info_validate']['chat_validated'] == '0' || $this->_var['info_validate']['chat_validated'] == '1'): ?>class="b"<?php else: ?> class="a"<?php endif; ?>></p></td>
    <td><span>绑定手机</span></td>
    <td>绑定手机后，修改密码将必须通过手机验证，避免他人恶意修改您的密码。</td>
    <td align="center"><a class="other_botton" href="user.php?act=security_edit_psd&type=phone&phone=<?php echo $this->_var['info_validate']['mobile_phone']; ?>&validate=<?php echo $this->_var['info_validate']['chat_validated']; ?>"><?php if ($this->_var['info_validate']['chat_validated'] == '0' || $this->_var['info_validate']['chat_validated'] == '1'): ?>立即绑定<?php else: ?> 立即修改<?php endif; ?></a></td>
  </tr>
</table>
        </div>
		<?php endif; ?> 
     
	
	 
        <?php if ($this->_var['action'] == 'security_edit_psd'): ?>
		<?php echo $this->smarty_insert_scripts(array('files'=>'user.js')); ?>
		<script>
		   function send_verify_email(validate,eindex)
				{
				var email = $('#user_email'+eindex).val();
				  if(!reg_email.test(email))
                {
				  alert('邮箱格式不正确');
				  return false;
			   }		                                                               //is_validate=1 验证邮箱  =0 取消邮箱绑定
					$.post("user.php",{act:"set_user_contact",type:"email",value:email,is_validate:validate},function(result)
					{
						// alert(result);
						if(result=='0')
						{
						  alert("这个邮箱已经被其他人使用了");
						}
						else if(result=='1')
						{
						 alert("请先解除该验证邮箱的绑定");
						}
						else
						{
						 sendHashMail(validate);
						 $('#loginMail').show();
						 $("#goto_email"+eindex).attr('href',"javascript:window.location.href="+result);
						 }
					});
				}
			function send_verify_SMS(eindex,validate,id)
		   {
		    var phone = $('#mobilePhone'+eindex).val(); 
            if(!reg_phone.test(phone))
            {
			  alert('手机号码格式不正确');
			  return false;
			}	

		   	$.post("user.php",{act:"set_user_contact",type:"phone",value:phone,is_validate:validate},function(result)
					{
					
					if(result=='0')
						{
						  alert("这个手机已经被其他人使用了");
						}
						else if(result=='1')
						{
						 alert("请先解除该手机号的绑定");
						}
						else
						{
						
						 sendSMS(eindex,validate,<?php echo $this->_var['user_id']; ?>);
						 switch(id)
						 {
						   case 'send_SMS_CountDown':
							  countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_index0',1,'" + id + "')");
							  break;
						  case 'sendNewPhoneSMS':
						      countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_indexNew',2,'" + id + "')");
						     break;
						   case 'sendOldPhoneSMS':
						      countDown($('#'+id),60,'发送验证码','重新发送',"send_verify_SMS('_indexOld',1,'" + id + "')");
						     break;
						  }
						 }
						
					});	   
					
		   }
		   
				function before_edit_pwd()  //chen-0911
				{
								var new_pwd = $('#new_pwd').val();
								var confirm_pwd = $('#confirm_pwd').val();
								if(new_pwd != confirm_pwd || new_pwd.length < 6)
								{
								alert("修改密码失败！请检查密码是否大于6位，新密码和确认密码是否一致。");
								  return false;
								}
								$('#edit_pwd').submit();
				}
		</script>
		<?php if ($this->_var['type'] == "edit_pwd"): ?>
			<div class="orders">
			  <div class="other_title">
					<h3>修改密码</h3>
				</div> 
				<form id="edit_pwd" method="post" action="user.php?act=security_edit_psd&edit=1">
					<table class="safe_3" width="900" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td width="103" align="right">旧密码：</td>
							<td width="320">
							  <label for="textfield"></label>
							  <span class="select_b">
								   <input type="password" name="old_pwd" />
								</span></td>
							<td width="477">&nbsp;</td>
						</tr>
						<tr>
							<td width="103" align="right">新密码：</td>
							<td width="320">
							  <label for="textfield"></label>
							  <span class="select_b">
								<input type="password" name="new_pwd" id="new_pwd"/></span></td>
							<td width="477">不少于6位</td>
						</tr>
						  <tr>
							<td width="103" align="right">确认密码：</td>
							<td width="320">
							  <label for="textfield"></label>
							  <span class="select_b">
								<input type="password" name="confirm_pwd" id="confirm_pwd"/></span></td>
							<td width="477">&nbsp;</td>
						  </tr>
						  <tr>
							<td height="50" align="right">&nbsp;</td>
							<td><a class="select_c" href="javascript:before_edit_pwd();">提交</a><a class="select_d" href="javascript:document.getElementById('edit_pwd').reset()">重置</a></td>
							<td>&nbsp;</td>
						  </tr>
					</table>
				</form>
			</div>
		<?php endif; ?>
		<?php if ($this->_var['type'] == "validate_email"): ?>
		    <div class="orders">
       	  <div class="other_title">
            	<h3>绑定邮箱</h3>
            </div>
          <table width="900" align="center" cellspacing="0" cellpadding="0" border="0" class="safe_3">
  <tbody><tr>
    <td width="103" align="right"> Email： </td>
    <td width="320">
      <label for="textfield"></label>
      <span class="select_b"><input type="text" id="user_email_index0" name="email" value="<?php echo $this->_var['email']; ?>"></span></td>
    <td width="477">&nbsp;</td>
  </tr>
  <tr>
    <td width="103" align="right">&nbsp;</td>
    <td width="320"><a href="javascript:void(0)" onclick="send_verify_email(1,'_index0');" class="select_c">发送验证邮件</a>
      </td>
    <td width="477">&nbsp;</td>
  </tr>
  <tr id='loginMail' style="display:none;">
    <td width="103" align="right">&nbsp;</td>
    <td width="320"><a href="javascript:void(0)" id="goto_email_index0">登录邮箱查看</a>
     </td>
    <td width="477">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" align="right">&nbsp;</td>
    <td colspan="2"> <span class="tishi"><strong>提示:</strong>
      不同邮箱的收信方法可能不同，点击"发送认证"后登录您的邮箱，请注意查看"收件箱"或"垃圾箱"， 我们会发送电子邮件到您Email，请根据邮件内容提示进行E_mail认证！</span></td>
    </tr>
 
  </tbody></table>
        </div>
		<?php endif; ?>
		<?php if ($this->_var['type'] == "edit_email"): ?>
		<div class="orders">
       	  <div class="other_title">
            	<h3>解除绑定邮箱</h3>
            </div>
           
        <table width="900" align="center" cellspacing="0" cellpadding="0" border="0" class="safe_3">
  <tbody>
  <tr>
    <td width="158" align="right">原邮箱地址： </td>
    <td width="232">
      <label for="textfield"></label>
      <span class="select_b"><input type="text" id="user_email_index1"  name="old_email" value="<?php echo $this->_var['email']; ?>" readonly></span></td>
	  <td width="150"><a href="javascript:send_verify_email(0,'_index1');" class="select_c">解除绑定</a></td>
	   <td width="510"><a href="javascript:void(0)" id="goto_email_index1" class="select_c">登陆邮箱</a></td>
  </tr>

  </tbody></table>
        </div>   
		<?php endif; ?>
		<?php if ($this->_var['type'] == "validate_phone"): ?>
		   <div class="orders">
       	  <div class="other_title">
            	<h3>绑定手机</h3>
            </div>
			<form method="post" action="user.php" id="verify_phone">
			<input type="hidden" name="act" value="about_verify_phone">
			<input type="hidden" name="type" value="verify">
          <table width="900" align="center" cellspacing="0" cellpadding="0" border="0" class="safe_3">
  <tbody><tr>
    <td width="120" align="right"> 手机号码： </td>
    <td width="229">
      <label for="textfield"></label>
      <span class="select_b"><input type="text" name="phone" id="mobilePhone_index0" value="<?php echo $this->_var['phone']; ?>"></span></td>
    <td width="551"><a href="javascript:void(0)" onClick="send_verify_SMS('_index0',1,'send_SMS_CountDown')" class="select_c" id='send_SMS_CountDown' style="width:90px;">发送验证码</a></td>
  </tr>
  <tr>
    <td align="right">输入验证码：</td>
    <td><span class="select_b">
      <input type="text"  name="validator">
    </span></td>
    <td width="551"><span class="tishi"><strong>提示:</strong>
      若收不到请59秒后再次点击发送验证码！</span></td>
  </tr>
 
<tr>
    <td width="120" align="right">&nbsp;</td>
    <td width="229"><a href="javascript:document.getElementById('verify_phone').submit()" class="select_c">提交</a>
     </td>
    <td width="551">&nbsp;</td>
  </tr>
  </tbody></table>
  </form>
        </div>
		<?php endif; ?>
		<?php if ($this->_var['type'] == "edit_phone"): ?>
		   <div class="orders">
       	  <div class="other_title">
            	<h3>绑定新手机</h3>
            </div>
<form method="post" id="edit_phone_form" action="user.php">
	<input type="hidden" name="act" value="about_verify_phone">
			<input type="hidden" name="type" value="edit">
          <table width="900" align="center" cellspacing="0" cellpadding="0" border="0" class="safe_3">
  <tbody><tr>
    <td width="158" align="right">原手机号码： </td>
    <td width="232">
      <label for="textfield"></label>
      <span class="select_b"><input type="text" id="mobilePhone_indexOld" name="old_phone" value="<?php echo $this->_var['phone']; ?>" readonly></span></td>
    <td width="510"><a href="javascript:void(0)" onclick="send_verify_SMS('_indexOld',1,'sendOldPhoneSMS')" class="select_c" id="sendOldPhoneSMS"  style="width:90px">发送验证码</a></td>
  </tr>
  <tr>
    <td align="right">输入验证码：</td>
    <td><span class="select_b">
      <input type="text"  name="old_capthcha">
    </span></td>
    <td width="510"><span class="tishi"><strong>提示:</strong>
      若收不到请59秒后再次点击发送验证码！若手机丢失请拨打人工客服：0573-56885896</span></td>
  </tr>
  <tr>
    <td width="158" align="right">输入新手机号码：</td>
    <td width="232"><span class="select_b"><input type="text" id="mobilePhone_indexNew" name="new_phone"></span>
     </td>
    <td width="510"><a href="javascript:void(0)" onclick="send_verify_SMS('_indexNew',2,'sendNewPhoneSMS')" class="select_c" id="sendNewPhoneSMS" style="width:90px">发送验证码</a></td>
  </tr>
<tr>
    <td align="right">输入验证码：</td>
    <td><span class="select_b">
      <input type="text"  name="new_capthcha">
    </span></td>
    <td width="510"><span class="tishi"><strong>提示:</strong>
      若收不到请59秒后再次点击发送验证码！</span></td>
  </tr>
<tr>
    <td width="158" align="right">&nbsp;</td>
    <td width="232"><a href="javascript:document.getElementById('edit_phone_form').submit()" class="select_c">提交</a>
     </td>
    <td width="510">&nbsp;</td>
  </tr>
  </tbody></table>
  </form>
        </div>
		<?php endif; ?>
		<?php endif; ?> 
     
	

 
        <?php if ($this->_var['action'] == 'my_rank'): ?>
		    <div class="orders">
				<div class="other_title">
					<h3>我的等级</h3>
				</div>		
				<div class="dengji_1 dengji_1_<?php echo $this->_var['progress_bar']; ?>">
				</div>
				<div class="dengji_2">
					我当前的等级是：<span><?php echo $this->_var['vip_name']; ?></span>我目前的成长值是：<b><?php echo $this->_var['info']['rank_points']; ?></b>
				</div>
				<div class="dengji_3">
						<h2>1、什么是笨虎之家成长值？</h2>
							成长值是笨虎之家会员通过购物所获得的经验值，由累积金额计算获得，它标志着您在笨虎之家累积的网购经验值，成长值越高会员等级越高，享受更多的会员服务哦！<br /><br />
						<h2>2、成长值如何计算？</h2>
							会员成长值=累积购物金额(不含运费)
							成长值按照交易金额的个位数取整计算，如，购买88.2元的商品，则确认收货后可以得到88分。<br /><br />
						<h2>3、如何查看笨虎之家VIP成长值？</h2>
							会员可进入我的笨虎之家查看自己当前的会员成长值<br /><br />
						<h2>4、笨虎之家VIP成长值的获取来源？</h2>
							成长值只通过交易累积获得，购买越多累积的成长值越高，且确认收货后成长值才会增加，成长值不衰减。
				</div>
			</div>                                                    
		<?php endif; ?> 
     	
		
      
           <?php if ($this->_var['action'] == 'my_integral'): ?>
	    <div class="orders">
			<div class="other_title">
				<h3>我的积分</h3>
			</div>
                <table class="jifen_1" width="900" border="0" cellspacing="0" cellpadding="0">
				    <tr class="jifen_1_a">
						<td>积分明细</td>
						<td>&nbsp;</td>
						<td align="right"><a href="article.php?id=50">积分规则</a></td>
				    </tr>
				    <tr>
						<td>可用积分</td>
						<td>冻结积分</td>
						<td>即将过期的积分</td>
				    </tr>
				    <tr>
						<td><span class="jifen_1_c"><?php if ($this->_var['info']['pay_points']): ?><?php echo $this->_var['info']['pay_points']; ?><?php else: ?>0<?php endif; ?></span><a class="home_m_2_button" href="exchange.php">去兑换商品</a></td>
						<td> <?php echo $this->_var['frozen_integral']; ?><!--（<a href="#">何时冻结</a>）--></td>
						<td> 0<!--552（2014-9-30<a href="#">过期</a>）--></td>
				    </tr>
                </table>
            <div class="jifen_2">
				<span class="jifen_2_a">积分获取</span>
						
				<div id="outer">
					<ul id="tab">
						<li class="current">全部</li>		
						<li>订单相关</li>
						<li>商品评论</li>
						<li>积分签到</li>
						<li>冻结积分</li>
					</ul>
					<div id="content">
						 <?php $_from = array(0,新订单,评论,签到); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'tmp');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['tmp']):
        $this->_foreach['loop']['iteration']++;
?>
							<ul <?php if (($this->_foreach['loop']['iteration'] - 1) == 0): ?>style="display:block;"<?php endif; ?>>
												<table width="880" border="0" cellspacing="0" cellpadding="0">
													  <tr class="title">
														<td width="150">获取积分</td>
														<td width="200">积分类型</td>
														<td width="200">积分详情</td>
														<td>日期</td>
													  </tr>
													 <?php $_from = $this->_var['unfreezed_integral_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'record');if (count($_from)):
    foreach ($_from AS $this->_var['record']):
?>	
													<?php if ($this->_var['record']['type'] == $this->_var['tmp'] || ($this->_foreach['loop']['iteration'] - 1) == 0): ?>									 
												  <tr>
														<td><?php echo $this->_var['record']['integral']; ?></td>
														<td><?php echo $this->_var['record']['type']; ?></td>
														<?php if ($this->_var['record']['type'] == '新订单'): ?>
														 <td>订单<?php echo $this->_var['record']['order_sn']; ?>完成，获得积分</td>
														<?php else: ?>
														<td><?php echo $this->_var['record']['detail']; ?></td>
														<?php endif; ?>					
														<td><?php echo $this->_var['record']['got_time']; ?></td>
													  </tr>
													  <?php endif; ?>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											
												</table>
							</ul>
						 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							<ul>
								<table width="880" border="0" cellspacing="0" cellpadding="0">
								    <tr class="title">
										<td width="150">冻结积分</td>
											<td width="200">积分类型</td>
											<td width="200">积分详情</td>
											<td>日期</td>
									</tr>
									<?php $_from = $this->_var['frozen_integral_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'record');if (count($_from)):
    foreach ($_from AS $this->_var['record']):
?>								 
												  <tr>
														<td><?php echo $this->_var['record']['integral']; ?></td>
														<td><?php echo $this->_var['record']['type']; ?></td>
														<td>订单<?php echo $this->_var['record']['order_sn']; ?>未完成,积分冻结</td>
														<td><?php echo $this->_var['record']['got_time']; ?></td>
													  </tr>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</table>
							</ul>
					</div>				
						
				</div>
            </div>
        </div>
	   <?php endif; ?> 
     

     
        <?php if ($this->_var['action'] == 'comment_goods'): ?>
		<div class="orders">
		<form action="comment.php" method="post" id="comment_form">
		   <input type="hidden" name="order_id" id="order_id" value="<?php echo $this->_var['order_id']; ?>">
		   <input type="hidden" name="goods_num" value="<?php echo $this->_var['goods_num']; ?>">
		   <input type="hidden" name="type" value="comment">
			<div class="other_title">
				<h3>商品评论</h3>
			</div>
          <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['loop']['iteration']++;
?>
		    <div class="pinglun_1_box">
			    <input type="hidden"  name="goods_id<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" id="goods_id<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" value='<?php echo $this->_var['good']['goods_id']; ?>'/>
				<input type="hidden" id='comment_rate<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>' name="comment_rate<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" value=''/>
				<dl class="pinglun_1_shangpin">
					<dt><img src="<?php echo $this->_var['good']['goods_thumb']; ?>" /></dt>
					<dd class="datum_l_a_pinglun"><a href="goods.php?id=<?php echo $this->_var['good']['goods_id']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a></dd>
					<dd class="datum_l_b_pinglun">价格：<?php echo $this->_var['good']['shop_price']; ?></dd>
				</dl>
				<div class="pingjia_sp">
					<div id="xzw_starSys">
						<h3>满意程度：</h3>
							<div id="xzw_starBox">
								<ul class="star">
									<li><a href="javascript:void(0)" class="one-star">1</a></li>
									<li><a href="javascript:void(0)" class="two-stars">2</a></li>
									<li><a href="javascript:void(0)" class="three-stars">3</a></li>
									<li><a href="javascript:void(0)" class="four-stars">4</a></li>
									<li><a href="javascript:void(0)" class="five-stars">5</a></li>
								</ul>
								<div class="current-rating" id="showb<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>"></div>
							</div>
						<div id="description<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>"></div>
					</div>
					<div class="orders_review_a">
						<span>评论内容：</span>
						<textarea class="orders_review_a_textarea" name="comment_content<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" cols="" rows=""></textarea>
					</div>
					<div class="shaidan">
						<ul id="preview<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>">
						</ul>
						<input type="file" value="上传买家秀…" class="shaidan_botton" id="fileImage<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" multiple name="saidan<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>[]"/>
					</div>
				</div>
		    </div> 
		  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

			<div class="pingjia_sp_bottom">
				<table width="95" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="22"><input type="checkbox" name="anonymity" />
						  <label for="checkbox"></label></td>
						<td width="53">是否匿名</td>
						<!--<td width="60" align="right">验证码：</td>
						<td width="168"><label  for="textfield"></label>
						  <input class="orders_review_a_input" type="text" name="captcha" id="textfield" size='5'/>
						</td>
						<td width="147">
							<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" onClick="this.src='captcha.php?'+Math.random()" class="captcha" height="30px" width="80px">
						</td>-->
					</tr>
				</table>
				<p class="orders_review_b"><a class="home_m_2_button" href="javascript:is_commented();">提交评论</a></p>
			</div>
		</form>
        </div>
	    <?php endif; ?> 
     

      
        <?php if ($this->_var['action'] == 'comment_list'): ?>
			  <div class="orders">
				  <div class="other_title">
						<h3><?php echo $this->_var['lang']['label_comment']; ?></h3>
				  </div>
			
			  <div class="pinglun">
				<?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
						<dl>
							<dt><a href="goods.php?id=<?php echo $this->_var['comment']['goods_id']; ?>"> <img src="<?php echo $this->_var['comment']['goods_thumb']; ?>" /></a></dt>
							<dd class="pinglunmain"><?php echo $this->_var['comment']['content']; ?></dd>
							<dd class="pingluntime"><?php echo $this->_var['comment']['formated_add_time']; ?></dd>
						</dl>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
			  </div>
			  <?php if ($this->_var['comment_list']): ?> 
			     <?php echo $this->fetch('library/pages_new.lbi'); ?> 
			  <?php else: ?> 
				<br/>&nbsp;&nbsp;&nbsp;您没有对商品进行过评价！
			  <?php endif; ?> 
			</div>		
		<?php endif; ?> 
     
	
	 
   		<?php if ($this->_var['action'] == 'coupons'): ?>
		  	<div class="orders">
			  	<div class="other_title">
				    <h3>
				      我的优惠券
				    </h3>
			  	</div>
	 	 	<div id="outer">
			    <ul id="tab">
			      <li class="current">未使用的优惠券</li>
			      <li>已使用的优惠券</li>
			      <li>已过期的优惠券</li>
			    </ul>
    <div id="content">
    	<?php $_from = $this->_var['coupons_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'coupons');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['coupons']):
        $this->_foreach['loop']['iteration']++;
?>
    	 	<ul id="coupons_<?php echo $this->_var['key']; ?>" <?php if (($this->_foreach['loop']['iteration'] - 1) == 0): ?>style="display:block;"<?php endif; ?>>
		        <table width="880" border="0" cellspacing="0" cellpadding="0">
		          <tr class="title">
		            <td width="150">编号</td>
		            <td width="150">类别</td>
		            <td width="200">面值</td>
		            <td width="200">所需要消费金额</td>
		            <td>有效期</td>
         	 	</tr>
		    		<?php $_from = $this->_var['coupons']['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');if (count($_from)):
    foreach ($_from AS $this->_var['coupon']):
?>
			         	<tr>
				            <td><?php echo $this->_var['coupon']['sent_coupon_id']; ?></td>
				            <td><?php echo $this->_var['coupon']['coupon_description']; ?></td>
				            <td><?php echo $this->_var['coupon']['coupon_value']; ?></td>
				            <td><?php echo $this->_var['coupon']['restriction_ext']; ?></td>
				            <td><?php echo $this->_var['coupon']['validate_time']; ?></td>
		         	 	</tr>
		    		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			    </table>
			    
		    	<?php if ($this->_var['coupons']['pager']): ?>
		    		<div class="page_box">
						<div class="page">
							<?php if ($this->_var['coupons']['pager']['page'] != 1): ?>
								<a href="<?php echo $this->_var['coupons']['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a>
							<?php endif; ?>
							<?php $_from = $this->_var['coupons']['pager']['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
								<?php if ($this->_var['key'] == $this->_var['coupons']['pager']['page']): ?>
									<span class="current"><?php echo $this->_var['key']; ?></span>
								<?php else: ?>
									<a href="<?php echo $this->_var['item']; ?>"><?php echo $this->_var['key']; ?></a>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							<?php if ($this->_var['coupons']['pager']['page'] != $this->_var['coupons']['pager']['page_count'] && $this->_var['coupons']['pager']['page_count'] != 0): ?>
								<a href="<?php echo $this->_var['coupons']['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a>
							<?php endif; ?>
						</div>
					</div>
		    	<?php endif; ?>
			    
			</ul>
    	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
  </div>
        <?php endif; ?> 
     
	
	 
       <?php if ($this->_var['action'] == 'complain_list'): ?>
			 <div class="orders">
				<div class="other_title">
						<h3>我的投诉/建议</h3>
				</div>			
					<table class="jianyi" width="1000" border="0" cellspacing="0" cellpadding="0">
						  <tr class="jianyi_1">
						    <td width="337">内容</td>
							<td width="72">类型</td>
							<td width="115">发表时间</td>
							<td width="360">状态</td>
							<td width="55">操作</td>
							</tr>
					  <?php $_from = $this->_var['complain_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'complain');if (count($_from)):
    foreach ($_from AS $this->_var['complain']):
?>
						  <tr id="complain<?php echo $this->_var['complain']['id']; ?>">
							<td><?php echo $this->_var['complain']['content']; ?></td>
							<td><?php echo $this->_var['complain']['type']; ?></td>
							<td><?php echo $this->_var['complain']['complain_time']; ?></td>
							<td><span><?php echo $this->_var['complain']['state']; ?></span></td>
							<td><a href="javascript:void(0)" onclick="delete_complain(<?php echo $this->_var['complain']['id']; ?>);return false;">删除</a></td>
						  </tr>
					    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
		            </table>
			  <?php if ($this->_var['complain_list']): ?> 
			     <?php echo $this->fetch('library/pages_new.lbi'); ?> 
			  <?php else: ?> 
				<br/>&nbsp;&nbsp;&nbsp;您没有对商品进行过建议或投诉！
			  <?php endif; ?> 
		    </div>
	   <?php endif; ?> 
    
	
	
	 
	<?php if ($this->_var['action'] == 'order_list'): ?>
	    <div class="orders">
			<div class="orders_tab">
				<div class="title cf">
					<ul class="title-list cf ">
					  <li>所有订单</li>
					  <li>待付款</li>
					  <li>待发货</li>
					  <li>待收货</li>
					  <li>待评价</li>
					  <li>已完成</li>
					 <!-- <li>已取消</li>-->
					  <p style="left:<?php echo $this->_var['left']; ?>px"><b></b></p>
					</ul>
				</div>
				<div class="orders_tab_box">		
					<?php $_from = $this->_var['all_orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'orders');$this->_foreach['all'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['all']['total'] > 0):
    foreach ($_from AS $this->_var['orders']):
        $this->_foreach['all']['iteration']++;
?>
						<div class="orders_tab_main show" <?php if ($this->_var['ctl'] == ($this->_foreach['all']['iteration'] - 1)): ?> class="on" style="display:block" <?php else: ?> style="display:none"<?php endif; ?>>
							<?php if ($this->_var['orders']): ?>
								<?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
									 <?php echo $this->fetch('library/order_list_com.lbi'); ?> 
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
								<div class="page_box">
									 <?php echo $this->fetch('library/pages_new.lbi'); ?> 
								</div>
							<?php else: ?>
								您没有<?php echo $this->_var['all_infos'][($this->_foreach['all']['iteration'] - 1)]; ?>的订单！
							<?php endif; ?>
						</div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>		
			    </div>
			</div>
        </div> 
	<?php endif; ?> 
    
	
	
	
	
	 
	<?php if ($this->_var['action'] == 'collection_list'): ?>
	
		<div class="orders">
			<div class="other_title">
				<h3>我的收藏</h3>
			</div>
			<?php if ($this->_var['goods_list']): ?>  
				<div class="favorite">
					<table width="926" border="0" align="center" cellpadding="0" cellspacing="0" class="favorite_1">
						<tr>
							<td width="21">
							  <input type="checkbox" name="select_all"  id="select_all" onclick="select_all_goods(this.checked)">
							  <label for="checkbox"></label>
							</td>
							<td width="57">
								全选
						    </td>
							<td width="396">
								<a class="operate_2" href="javascript:void(0)" onclick="delete_select();return false;">删除</a>
							</td>
							<td width="472" align="right" class="favorite_1_a">
							    <?php echo $this->fetch('library/pages_pre_next.lbi'); ?>  
							</td>
						</tr>
		            </table>
					<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');if (count($_from)):
    foreach ($_from AS $this->_var['good']):
?>
						<dl id='goodslist_<?php echo $this->_var['good']['rec_id']; ?>' class="goods_list" value='0'>
							<dt>
							    <a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['goods_thumb']; ?>" /></a>
							</dt>
							<dd>
							    <span class="name_1">
								    <input id="good_<?php echo $this->_var['good']['rec_id']; ?>" class="collection_goods_list" name="input"  type="checkbox" value="" onclick="select_one(this.checked,<?php echo $this->_var['good']['rec_id']; ?>)"/>
							    </span>
								<span class="name_2">
								     <a href="<?php echo $this->_var['good']['url']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a>
							    </span>
							</dd>
							<dd class="price">¥<?php echo $this->_var['good']['shop_price']; ?></dd>
							<dd>
							    <?php echo $this->fetch('library/cart_or_buy.lbi'); ?>	
							    <a class="operate_1" href="javascript:add_mark(0);addToCart(<?php echo $this->_var['good']['goods_id']; ?>)">加入购物车</a>
								<a class="operate_2" href="javascript:void(0)" onclick="delete_one(<?php echo $this->_var['good']['rec_id']; ?>)">删除</a>
							</dd>
						</dl>
				    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</div>		
				 <?php echo $this->fetch('library/pages_new.lbi'); ?> 
			<?php else: ?>
			    <table class="address_2" width="900" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td height="100" align="center">暂无收藏的商品</td>
				  </tr>
				  <tr>
					<td><a href="index.php" class="other_botton">现在就去逛</a></td>
				  </tr>
				</table> 
			<?php endif; ?> 
		</div>
		<script language="JavaScript">	
		  $('.collection_goods_list').attr('checked',false);$('#select_all').attr('checked',false);
		  var url = '<?php echo $this->_var['url']; ?>';
		  var u   = '<?php echo $this->_var['user_id']; ?>';
		  var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
		  var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
		  var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
		  var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
	    </script> 
       <?php endif; ?> 
    	
	
	 
        <?php if ($this->_var['action'] == 'return_goods'): ?>
	   <div class="orders">
			<div class="orders_tab">
				
			<div class="title cf">
				<ul class="title-list cf ">
				  <li class="on">申请退换货</li>
				  <li>我的退换货记录</li>
				  <p><b></b></p>
				</ul>
			</div>
			<div class="orders_tab_box">
				
				<div class="orders_tab_main show">
				    <form name="return_goods_form" enctype="multipart/form-data" method="post" id="return_goods_form" action="user.php" >
					    <input type="hidden" name="act" value="sub_return_goods" />
						<input type="hidden" name="current_time" value="<?php echo $this->_var['current_time']; ?>" id="rand_num"/>
						<table class="return_main" width="946" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td>申请退/换货的订单：</td>
							<td>
							 <?php if ($this->_var['user_order_list']): ?>
								   <select class="return_select_1" id="order_id" name="wanted_return_order"  > 
										 <option style="width:100px" value="0">请选择...</option>		
										  <?php $_from = $this->_var['user_order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');$this->_foreach['order_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['order_list']['total'] > 0):
    foreach ($_from AS $this->_var['order']):
        $this->_foreach['order_list']['iteration']++;
?>
										     <option value="<?php echo $this->_var['order']['order_id']; ?>">
											    订单编号：<?php echo $this->_var['order']['order_sn']; ?>
												   <?php $_from = $this->_var['order']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');if (count($_from)):
    foreach ($_from AS $this->_var['good']):
?>
												      	   &nbsp;&nbsp; <?php echo $this->_var['good']['goods_name']; ?>
												   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
											 </option>
										  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    										  
								  </select>
							  <?php else: ?>
								    您最近没买过东西，无法进行退换货!
							  <?php endif; ?>
							</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td width="81">申请理由：</td>
							<td width="682">
							  <select class="return_select_1" name="back_reason" id="select">
							    <option value="0">请选择...</option>
								<option value="1">7天无理由退换货</option>
								<option value="2">商品存在质量问题</option>
								<option value="3">商品与实际不符</option>
								<option value="4">因物流导致商品损坏，残缺，无法正常使用</option>
							  </select>
							</td>
							<td width="183">&nbsp;</td>
						  </tr>
						  <tr>
							<td>申请类型：</td>
							<td>
							   <select class="return_select_1" name="back_type"  id="select2" onchange="choose_type(this.options[this.options.selectedIndex].value)">
							    <option value="0">请选择...</option>
								<option value="1">退货</option>
								<option value="2">换货</option>
							  </select>
							</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr id='return_money' style="display:none">
						     <td align="right">退款金额：</td>
							 <td>
							    ¥<input type='text' name="return_money" value='0'/>
							 </td>
							 <td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>问题描述：</td>
							<td>
							   <label for="textarea"></label>
							   <textarea class="return_select_2" name="pro_descrip" id="pro_descrip" cols="45" rows="5"  maxlength="200" onpropertychange="textCounter()" oninput="textCounter()">						   
							   </textarea>
							 </td>
							<td valign="bottom" id="limit_count">还可以写200个字。</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td>上传凭证：每张图片大小不超过5M，支持JPG、GIF、PNG格式，最多上传5张。</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td >
								<input type="file" multiple name="fileselect[]" size="5" id="fileImage" />
							</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>	
						     <td align="right">&nbsp;</td>
							 <td id="preview">
							 </td>
							 <td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>退回方式：</td>
							<td>自行寄回</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td><span class="return_select_3">由您自行寄回仓库，然后为您退款，申请核实后会告知您退货地址，仓库无法接收平邮与到付件，寄回产生的费用处理可查看帮助中心。</span></td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td align="right"><input type="checkbox" name="return_principle" id="checkbox2" />
							  <label for="checkbox2"></label>
							</td>
							<td class="return_select_4">已阅读<a href="article.php?id=21">《退换货原则》</a></td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td><a class="common_botton" id="return_goods_sub" href="javascript:return_goods_before_submit()">提交申请</a></td>
							<td>&nbsp;</td>
						  </tr>
					</table>
                   </form>
                </div>
                 
				<div class="orders_tab_main">
					<table class="return_main_1" width="940" border="0" cellspacing="0" cellpadding="0">					 
						 <tr class="return_main_1_a">
							<td width="382">订单信息</td>
							<td width="110">交易金额</td>
							<td width="110">退款金额</td>
							<td width="110">申请时间</td>
							<td width="110">处理时间</td>
							<td width="110">处理结果</td>
							<td width="110">操作</td>
						  </tr>			   
							<?php $_from = $this->_var['return_goods_history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good_history');if (count($_from)):
    foreach ($_from AS $this->_var['good_history']):
?>
								<tr id="return_goods_<?php echo $this->_var['good_history']['back_id']; ?>">
									<td class="return_main_1_b">
									   <?php $_from = $this->_var['good_history']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');if (count($_from)):
    foreach ($_from AS $this->_var['good']):
?>
										<a href="goods.php?id=<?php echo $this->_var['good']['goods_id']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
									</td>
									<td> <?php if ($this->_var['good_history']['goods_amount']): ?>¥<?php echo $this->_var['good_history']['goods_amount']; ?><?php else: ?>---<?php endif; ?> </td>
									<td> <?php if ($this->_var['good_history']['return_money']): ?>¥<?php echo $this->_var['good_history']['return_money']; ?><?php else: ?>---<?php endif; ?> </td>
									<td><?php echo $this->_var['good_history']['return_time']; ?></td>
									<td><?php if ($this->_var['good_history']['reply']): ?><?php echo $this->_var['good_history']['reply']['reply_time']; ?><?php else: ?>---<?php endif; ?></td>
									<td>
									<?php if ($this->_var['good_history']['reply']): ?>
									    <?php if ($this->_var['good_history']['reply']['action_type'] == '0'): ?>
										   不同意
									    <?php elseif ($this->_var['good_history']['reply']['action_type'] == '1'): ?>
									      同意退/换货
									    <?php endif; ?>
									<?php else: ?>
									   未处理
									<?php endif; ?>
									</td>
									<td class="return_main_1_c"><a href="javascript:void(0)" onclick="cancle_back_order(<?php echo $this->_var['good_history']['back_id']; ?>);return false;">取消申请</a></td>
								</tr>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
						
					</table>
					  <?php if ($this->_var['return_goods_history']): ?> 
							 <?php echo $this->fetch('library/pages_new.lbi'); ?> 
						  <?php else: ?> 
							<br/>&nbsp;&nbsp;&nbsp;没有退/换货记录！
						  <?php endif; ?> 
				</div>
    
            </div>
		</div>
	</div>
	   	<?php endif; ?> 
    
</div>


  <?php echo $this->fetch('library/cart_goods_added.lbi'); ?>
  
	<div class="deleteorder_pop" style="display:none" id="delete_order">
	        <input type="hidden" id='del_order_id' value=''/>
			<span>确定要删除订单吗？<br />
					删除后无法找回！
			</span>
			<p><a class="select_c" href="javascript:delete_order();turnoff('delete_order');">确定</a><a class="select_d" href="javascript:turnoff('delete_order')">取消</a></p>
	</div>
    <div class="orders_review" id="comment" style="display:none">
	    <form action="comment.php" method="post" name="comment_form">
			<div class="title">
				<h3>发表评论</h3>
				<a onclick="javascript:turnoff('comment')"><img src="themes/yihaodian/images/cloes.gif" /></a>
				 <input type="hidden" id='comment_order_id' name="order_id" value=''/>
				 <input type="hidden" id='comment_rate' name="comment_rate" value=''/>
			</div>
			
			<div id="xzw_starSys">
				<h3>满意程度：</h3>
				<div id="xzw_starBox">
					<ul class="star" id="star">
						<li><a href="javascript:void(0)" class="one-star">1</a></li>
						<li><a href="javascript:void(0)" class="two-stars">2</a></li>
						<li><a href="javascript:void(0)" class="three-stars">3</a></li>
						<li><a href="javascript:void(0)" class="four-stars">4</a></li>
						<li><a href="javascript:void(0)" class="five-stars">5</a></li>
					</ul>
					<div class="current-rating" id="showb"></div>
				</div>
				
				<div class="description"></div>
			</div>
			<div class="orders_review_a">
				<span>评论内容：</span>
				<textarea sureToReander="no" class="orders_review_a_textarea" name="comment_content" cols="" rows=""></textarea>
				<table width="450" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				  
					<td width="24">
						<input type="checkbox" name="checkbox" id="checkbox" />
						<label for="checkbox"></label>
					</td>
					<td width="64">是否匿名</td>
					
					<td width="93" align="right">验证码：</td>
					<td width="69">
						<label  for="textfield"></label>
						<input class="orders_review_a_input" type="text" name="captcha" id="textfield" /></td>
					<td width="200"><img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" onClick="this.src='captcha.php?'+Math.random()" class="captcha" height="30px" width="80px"></td> 
				 </tr>
				</table>
				<p class="orders_review_b"><a class="home_m_2_button" href="javascript:comment_form.submit()">提交评论</a></p>
			</div>
		</form>
    </div>


  
	 <div class="orders_review" id="complain" style="display:none;height:330px" >
		<form action="user.php" method="post" name="complain_form">
			<input id='complain_order_id' type='hidden' name='order_id' value=''/>
			<input type='hidden' name='act' value='user_complain'/>
			<div class="title">
				<h3>投诉/建议</h3>
				<a onclick="javascript:turnoff('complain')"><img src="themes/yihaodian/images/cloes.gif" /></a>
			</div>
			<div class="orders_review_a" style="height:320px">
				<table width="450" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="24" height="30"><input type="radio" name="type"  value="0" checked="checked"/></td>
					<td width="64">投诉</td>
					<td width="24">            <input type="radio" name="type"  value="1" /></td>
					<td width="130"><label  for="textfield">建议</label></td>
					<td width="200">&nbsp;</td>
				  </tr>
				</table>
				<span>订单号：<label id="complain_order_sn"></label></span>
				<span>投诉原因：</span>
				<textarea  sureToReander="no"  class="orders_review_a_textarea" name="content" cols="" rows=""></textarea>
				<table width="450" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="24"><input type="checkbox" name="checkbox" id="checkbox" />
					  <label for="checkbox"></label></td>
					<td width="64">是否匿名</td>
					<td width="93" align="right">验证码：</td>
					<td width="69"><label  for="textfield"></label>
					  <input class="orders_review_a_input" type="text" name="captcha"/></td>
					 <td width="200"><img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" onClick="this.src='captcha.php?'+Math.random()" class="captcha" height="30px" width="80px"></td>
				  </tr>
				</table>
				<p class="orders_review_b"><a class="home_m_2_button" href="javascript:complain_form.submit()">提交</a></p>
			</div>
		</form>
	</div>
	<?php echo $this->fetch('library/page_footer.lbi'); ?>

</body>
</html>
