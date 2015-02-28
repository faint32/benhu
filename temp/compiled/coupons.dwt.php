<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购物券</title>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/left_nav_2.js"></script>
<script type="text/javascript" src="style/js/time_count_down.js"></script>
</head>

<body>
  <?php echo $this->fetch('library/page_header.lbi'); ?>
   <link href="style/css/coupons.css" rel="stylesheet" type="text/css" />
   <?php echo $this->fetch('library/category_tree.lbi'); ?>

<script>
  function turnoff(obj)
  {
    document.getElementById(obj).style.display="none";
  }
  function gain_coupon(coupon_id)
  {
    Ajax.call( 'coupons.php?act=gain_coupon', 'coupon_id=' + coupon_id, gain_coupon_callback , 'GET', 'JSON', true, true );
  }
  function gain_coupon_callback(result)
  {
    if('0' == result.error)
    {
      $('#cloes .aa').html('领取成功');
      var sent_num = parseInt($('#coupon_' + result.coupon_id + ' .sent_num').html());
      var left_num = parseInt($('#coupon_' + result.coupon_id + ' .left_num').html());
      $('#coupon_' + result.coupon_id + ' .sent_num').html(sent_num + 1 );
      $('#coupon_' + result.coupon_id + ' .left_num').html(left_num - 1 );
    }
    else
    {
      $('#cloes .aa').html('领取失败');
    }

    $('#cloes .info').html(result.info);
    $('#cloes .action').html(result.action);
    $('#cloes').show();
  }
</script>
    <div class="youhuiquan" >
      <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['loop']['iteration']++;
?>
        <dl class="quan<?php echo $this->_var['coupon']['coupon_display_value']; ?>" id="coupon_<?php echo $this->_var['coupon']['coupon_id']; ?>">
          <dt><a href="javascript:gain_coupon('<?php echo $this->_var['coupon']['coupon_id']; ?>')">立即领取</a></dt>
            <dd>有效期：<?php echo $this->_var['coupon']['validate_time']; ?>止<br>

          优惠券数：已发放<span class="sent_num"><?php echo $this->_var['coupon']['today_sent']; ?></span>张，今日剩余<span class="left_num"><?php echo $this->_var['coupon']['today_left']; ?></span>张<br>

          使用条件：<?php echo $this->_var['coupon']['coupon_description']; ?>
          </dd>
        </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    
<div class="youhuiquan_1">
    </div>
<div class="item_2_right_popup" id="cloes" style="display:none;" >
  <a class="item_2_right_popup_cloes" onclick="javascript:turnoff('cloes')"><img src="themes/yihaodian/images/item_cloes.gif" /></a>
  <ul class="item_2_right_popup_1">
      <li class="aa">领取失败</li>
      <li class="bb info">您今天已经领取过了哦</li>
      <li class="bb action">
          您还可以<a href="#">查看我的购物券</a>&nbsp;&nbsp;&nbsp;<a href="#">现在去购物</a>
      </li>
  </ul>
  <a class="item_2_right_popup_queding" href="javascript:turnoff('cloes')">确定</a>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
