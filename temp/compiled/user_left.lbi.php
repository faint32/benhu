
    <div class="home_left">
        <h3>个人中心</h3>
        <dl class="home_left_head">
            <dt><span>
	    <a href="<?php echo $this->_var['staticPages']['user']; ?>">
		<img style='width:88px;height:88px' 
			<?php if ($this->_var['personal_pic']): ?> src="<?php echo $this->_var['personal_pic']; ?>" 
			<?php else: ?> src="style/home/images/nonehead.jpg" 
			<?php endif; ?>>
	    </a>
	    </span></dt>
            <dd class="home_left_head_name"><?php echo $this->_var['info']['username']; ?></dd>
            <dd class="home_left_head_class"><img src="style/images/<?php echo $this->_var['vip_pic']; ?>" width="52" height="27" /></dd>
        </dl>
        <div class="home_nav">
            <p>帐户信息</p>
            <a href="<?php echo $this->_var['staticPages']['user-profile']; ?>" <?php if ($this->_var['action'] == 'profile'): ?>class="selected"<?php endif; ?>>个人资料</a>
            <a href="<?php echo $this->_var['staticPages']['user-address_list']; ?>" <?php if ($this->_var['action'] == 'address_list'): ?>class="selected"<?php endif; ?>>收货地址</a>
            <a href="<?php echo $this->_var['staticPages']['user-security_settings']; ?>" <?php if ($this->_var['action'] == 'security_settings'): ?>class="selected"<?php endif; ?>>安全设置</a>
            <a href="<?php echo $this->_var['staticPages']['user-my_integral']; ?>" <?php if ($this->_var['action'] == 'my_integral'): ?>class="selected"<?php endif; ?>>我的积分</a> 
            <a href="<?php echo $this->_var['staticPages']['user-my_rank']; ?>" <?php if ($this->_var['action'] == 'my_rank'): ?>class="selected"<?php endif; ?>>我的等级</a>  

            <p>订单中心</p>
            <a href="<?php echo $this->_var['staticPages']['user-order_list']; ?>" <?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'order_detail'): ?>class="selected"<?php endif; ?>>我的订单</a>
            <a href="<?php echo $this->_var['staticPages']['user-collection_list']; ?>" <?php if ($this->_var['action'] == 'collection_list'): ?>class="selected"<?php endif; ?>>我的收藏</a>
            <a href="<?php echo $this->_var['staticPages']['user-comment_list']; ?>" <?php if ($this->_var['action'] == 'comment_list'): ?>class="selected"<?php endif; ?>>我的评论</a>
            <a href="<?php echo $this->_var['staticPages']['user-coupons']; ?>" <?php if ($this->_var['action'] == 'coupons'): ?>class="selected"<?php endif; ?>>我的购物券</a>


            <p>客户服务</p>
            <a href="<?php echo $this->_var['staticPages']['user-complain_list']; ?>" <?php if ($this->_var['action'] == 'complain_list'): ?>class="selected"<?php endif; ?>>我的投诉/建议</a>
            <a href="<?php echo $this->_var['staticPages']['user-return_goods']; ?>" <?php if ($this->_var['action'] == 'return_goods'): ?> class="selected"<?php endif; ?>>退换货</a>


        </div>
    </div>