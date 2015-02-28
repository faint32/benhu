<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<title><?php echo $this->_var['page_title']; ?></title>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.min.js,jquery.json.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js,top.js,curvycorners.src.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'all_top_nav.js,top.js,curvycorners.src.js')); ?>

<link href="style/css/integral.css" rel="stylesheet" type="text/css" />
</head>
<script>				
   function daily_attendance()
   {
		 $.post("exchange.php",{act:'attent'},function(result){
		  var html="<a href=\"javascript:void(0)\">已签到</a> <span>&nbsp;&nbsp;明天可获得5积分</span>";
		   $('#sign').html(html);
		   html = "可用积分："+( <?php echo $this->_var['info']['pay_points']; ?> + parseInt(result));
		   $('#available_integral').html(html);
	  });
   }

   $(function(){
			var $li = $('#tab li');
			var $ul = $('#content .content_box');
						
			$li.mouseover(function(){
				var $this = $(this);
				var $t = $this.index();
				$li.removeClass();
				$this.addClass('current');
				$ul.css('display','none');
				$ul.eq($t).css('display','block');
			})
	});	
</script>
<body>
  <?php echo $this->fetch('library/page_header.lbi'); ?>
   <?php echo $this->fetch('library/jifen_category.lbi'); ?>

    <div class="integral">
<div class="integral_l">
   	<div class="integral_l_nav">
	    <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category_0_15098500_1425017055');if (count($_from)):
    foreach ($_from AS $this->_var['category_0_15098500_1425017055']):
?>
		    <h3><a href="<?php echo $this->_var['category_0_15098500_1425017055']['url']; ?>"><?php echo $this->_var['category_0_15098500_1425017055']['name']; ?></a></h3>
			<div class="product_classify">
			    <?php $_from = $this->_var['category_0_15098500_1425017055']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child_category');if (count($_from)):
    foreach ($_from AS $this->_var['child_category']):
?>
				   <a href="<?php echo $this->_var['child_category']['url']; ?>" style="width:90px;overflow:hidden;"><?php echo $this->_var['child_category']['name']; ?>&nbsp;</a>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
         	<div id="outer">
    <ul id="tab">
        <li class="current">周排行</li>
        <li>月排行</li>
    </ul>
    <div id="content">
        <ul class="content_box" style="display:block;">
		<?php $_from = $this->_var['weekly_rank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['loop']['iteration']++;
?>
       	  <div class="integral_hdm">
           	<ul class="integral_hdm_1">
           	  <li class="integral_hdm_1_a"><?php echo $this->_foreach['loop']['iteration']; ?></li>
              <li class="integral_hdm_1_b">已兑换<span><?php echo $this->_var['good']['cnum']; ?></span>件</li>
            </ul>
            <ul class="integral_hdm_2">
            	<li class="integral_hdm_2_a">
                	<a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['goods_thumb']; ?>" /></a>
                </li>
              <li class="integral_hdm_2_b"><a href="<?php echo $this->_var['good']['url']; ?>" title="<?php echo $this->_var['good']['goods_name']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a>
              	<span>¥<?php echo $this->_var['good']['needed_money']; ?>+<?php echo $this->_var['good']['exchange_integral']; ?>积分</span>
                </li>
            </ul>
           </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        <ul class="content_box">
           <?php $_from = $this->_var['monthly_rank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['loop']['iteration']++;
?>
       	  <div class="integral_hdm">
           	<ul class="integral_hdm_1">
           	  <li class="integral_hdm_1_a"><?php echo $this->_foreach['loop']['iteration']; ?></li>
              <li class="integral_hdm_1_b">已兑换<span><?php echo $this->_var['good']['cnum']; ?></span>件</li>
            </ul>
            <ul class="integral_hdm_2">
            	<li class="integral_hdm_2_a">
                	<a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['goods_thumb']; ?>" /></a>
                </li>
              <li class="integral_hdm_2_b"><a href="<?php echo $this->_var['good']['url']; ?>" title="<?php echo $this->_var['good']['goods_name']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a>
              	<span>¥<?php echo $this->_var['good']['needed_money']; ?>+<?php echo $this->_var['good']['exchange_integral']; ?>积分</span>
                </li>
            </ul>
           </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</div>

  </div>
  <div class="integral_r">
       	<div class="integral_r_1">
             	<?php echo $this->fetch('library/ad_integral.lbi'); ?>
	      <div class="integral_r_1_b">
                	<dl class="home_left_head">
            	<dt><span><?php if ($this->_var['personal_pic']): ?>
		<img src="<?php echo $this->_var['personal_pic']; ?>" style="width:62px;height:62px;"/>
		<?php else: ?>
		<img src="style/images/img/nonehead.jpg" style="width:62px;height:62px;"/><?php endif; ?></span>
		</dt>
                <dd class="home_left_head_name">
		<a href="<?php echo $this->_var['staticPages']['user']; ?>"><?php echo $this->_var['info']['username']; ?></a>
                <span class="home_left_head_class">
		<?php if ($this->_var['vip_name']): ?><img src="style/images/<?php echo $this->_var['vip_pic']; ?>" width="52" height="27" /><?php else: ?>游客<?php endif; ?>
		</span>
                </dd>
            </dl>
            	<div class="sign" id="sign">
				<?php if ($this->_var['info']['username']): ?>
				    <?php if ($this->_var['user_attent'] == 1): ?>
                	 <a href="javascript:void(0)">已签到</a>
                    <span>&nbsp;&nbsp;&nbsp;明天可获得5积分</span>  
					<?php else: ?>
					<a href="javascript:daily_attendance()">签到赚积分</a>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;可获得5积分</span>
					<?php endif; ?>
					<?php else: ?>
					<a href="<?php echo $this->_var['staticPages']['user']; ?>" target="_self">未登陆</a>
					<span>&nbsp;&nbsp;&nbsp;&nbsp;登陆可领积分</span>
				<?php endif; ?>
                </div>
                <div class="number">
                <span id="available_integral">可用积分：<?php if ($this->_var['info']['pay_points']): ?><?php echo $this->_var['info']['pay_points']; ?><?php else: ?>0<?php endif; ?></span><a href="<?php echo $this->_var['staticPages']['user-my_integral']; ?>">查看积分明细</a>
                </div>
                </div>
        </div>
            
            	<span class="integral_goods_title">
                	<h2>超值兑换</h2>
                	<a href="exchange.php?type=best&act=more">更多超值兑换&nbsp;&gt;</a>
                </span>
            <div class="integral_goods">
			<?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['foo']['iteration']++;
?>
            	<dl>
                	<dt><a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['thumb']; ?>" /></a></dt>
                    <dd class="name"><a href="<?php echo $this->_var['good']['url']; ?>" title="<?php echo $this->_var['good']['goods_style_name']; ?>"><?php echo $this->_var['good']['goods_style_name']; ?></a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥<?php echo $this->_var['good']['shop_price']; ?></li>
								<li class="price_1_b"><span>¥<?php echo $this->_var['good']['needed_money']; ?></span>+<b><?php echo $this->_var['good']['exchange_integral']; ?></b>积分</li>
						</ul>
                    </div>
                </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
             
            </div>
        <span class="integral_goods_title">
                	<h2>精品上新</h2>
               	<a href="exchange.php?type=new&act=more">更多精品&nbsp;&gt;</a>
        </span>
        <div class="integral_goods">
		<?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['foo']['iteration']++;
?>
            	<dl>
                	<dt><a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['goods_img']; ?>" /></a></dt>
                    <dd class="name"><a href="<?php echo $this->_var['good']['url']; ?>" title="<?php echo $this->_var['good']['goods_style_name']; ?>"><?php echo $this->_var['good']['goods_style_name']; ?></a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥<?php echo $this->_var['good']['shop_price']; ?></li>
                            <li class="price_1_b"><span>¥<?php echo $this->_var['good']['needed_money']; ?></span>+<b><?php echo $this->_var['good']['exchange_integral']; ?></b>积分</li>
                        </ul>
                    </div>
                </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
             
            </div>
    <span class="integral_goods_title">
   	<h2>下期预告</h2>
    </span>
   	<div class="notice">
		<?php $_from = $this->_var['goods_trailer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');if (count($_from)):
    foreach ($_from AS $this->_var['good']):
?>
		  <dl>
			<dt><?php echo $this->_var['good']['begin_date']; ?><br /><i><?php echo $this->_var['good']['begin_hour']; ?></i></dt>
			  <dd>
				 <a href="javascript:void(0)" class="img"><img src="<?php echo $this->_var['good']['goods_img']; ?>" /></a>
				 <a href="javascript:void(0)" class="name" title="<?php echo $this->_var['good']['goods_style_name']; ?>"><?php echo $this->_var['good']['goods_style_name']; ?></a>
			  </dd>
			</dl> 
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
      </div>
    </div>

<?php echo $this->fetch('library/page_footer.lbi'); ?>

</body>
</html>
