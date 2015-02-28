<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_var['page_title']; ?></title>
<!--
<link href="themes/yihaodian/new_style.css" rel="stylesheet" type="text/css" />
_get-->
<link href="style/css/integral.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <?php echo $this->fetch('library/page_header.lbi'); ?>
   <?php echo $this->fetch('library/jifen_category.lbi'); ?>
     <div class="integral_get">
   	  <div class="integral_get_a">
        <dl class="home_left_head integral_get_c">
            	<dt><span >
				<?php if ($this->_var['personal_pic'] != - 1): ?>
				<img src="<?php echo $this->_var['personal_pic']; ?>" width="62px;" height="62px;"/>
				
				<?php endif; ?>
				</span>
				
				</dt>
                <dd class="home_left_head_name"><a><?php if ($this->_var['info']['username']): ?><?php echo $this->_var['info']['username']; ?><?php else: ?>&nbsp;&nbsp;&nbsp;游客<?php endif; ?></a>
                <span class="home_left_head_class"><?php if ($this->_var['vip_name']): ?>
		<img src="style/images/<?php echo $this->_var['vip_pic']; ?>" width="52" height="27" /><?php else: ?>请登录<?php endif; ?></span>
                </dd>
          </dl>
       	<div class="integral_get_b">
            	<div class="number">
                <span>可用积分：<?php if ($this->_var['info']['pay_points']): ?><?php echo $this->_var['info']['pay_points']; ?><?php else: ?>0<?php endif; ?></span><a href="user.php?act=my_integral">查看积分明细</a>
                </div>
            </div>
   	  </div>
      <div class="integral_get_d">
      	<dl>
        	<dt><span>待解冻积分<strong><?php echo $this->_var['uncmpltOrdIntgr']; ?></strong></span></dt>
            <dd><span>完成购物</span>
您有<b><?php echo $this->_var['uncmpltOrdCnt']; ?></b>个订单未完成。每完成一个订单将给予积分返还，具体积分额度以订单提交时页面标的积分分数为准。		
			<a href="user.php?act=order_list" class="integral_get_botton">查看订单</a>
		</dd>
        </dl>
        <dl>
        	<dt><span>待解冻积分<strong><?php echo $this->_var['unCmmtOrdIntgr']; ?></strong></span></dt>
            <dd><span>发表评论</span>
您有<b><?php echo $this->_var['unCmmtOrdCnt']; ?></b>个订单未评论。每件商品评论后可获得<b><?php echo $this->_var['CFG_CmmtIntgr']; ?></b>积分；每个商品页面前5名被展示的评论，将额外获得<b><?php echo $this->_var['CFG_top5CmmtIntgr']; ?></b>积分。
			<a href="user.php?act=order_list&ctl=4" class="integral_get_botton">立即评论</a>
		</dd>
        </dl>
        <dl>
		<?php if ($this->_var['is_got_RgstPnt']): ?>
		  <dt><span>已解冻积分<strong><?php echo $this->_var['CFG_RgstPnt']; ?></strong></span></dt>
            <dd><span>邮箱验证</span>
您已经验证邮箱，已获得<?php echo $this->_var['CFG_RgstPnt']; ?>积分！
			<a href="javascript:void(0);" class="integral_get_botton">邮箱已验证</a>
		</dd>
		<?php else: ?>
        	<dt><span>待解冻积分<strong><?php echo $this->_var['CFG_RgstPnt']; ?></strong></span></dt>
            <dd><span>邮箱验证</span>
验证邮箱有利用帐户安全，并且可以通过邮箱找回密码，验证邮箱将获得<?php echo $this->_var['CFG_RgstPnt']; ?>积分！
			<a href="user.php?act=security_settings" class="integral_get_botton">邮箱验证</a>
		</dd>
		<?php endif; ?>
        </dl>
      </div>
</div>
  

<?php echo $this->fetch('library/page_footer.lbi'); ?>

</body>
</html>
