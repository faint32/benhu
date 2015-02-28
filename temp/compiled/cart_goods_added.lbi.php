<div class="item_2_right_popup" id="cloes" style="display:none">
	<a class="item_2_right_popup_cloes" onclick="javascript:turnoff('cloes')"><img src="themes/yihaodian/images/item_cloes.gif" /></a>
   <script>
function turnoff(obj){
document.getElementById(obj).style.display="none";
}
function ajax_change_goods(goods_id)
{
   var param='act=ajax_change_goods&id='+goods_id;
     Ajax.call( 'goods.php',param,ajax_change_goods_callback , 'GET', 'json', true, true );
}
function ajax_change_goods_callback(result)
{
var json = result;
for(var i=0; i<json.length; i++)  
  {  
  var str=' <dt><a href="goods.php?id='+json[i].goods_id+'"><img src="'+json[i].goods_thumb+'" /></a></dt><dd>'+json[i].rank_price+'</dd>';
    $('#change_goods_'+i).html(str);
  } 
}
</script>
	<ul class="item_2_right_popup_1">
    	<li class="aa">添加成功！</li>
        <li class="bb">您可以<a href="#" id="view_cart">查看购物车</a></li>
    </ul>
    <ul class="item_2_right_popup_2">
    	<li>购买此商品的人还喜欢</li>
        <span><a href="javascript:ajax_change_goods('<?php echo $this->_var['goods']['goods_id']; ?>');"><img src="themes/yihaodian/images/main_2_left_title_b.png" width="65" height="20" /></a></span>
    </ul>
    <div class="item_2_right_popup_3" >
	<?php if ($this->_var['user_may_love']): ?>
	<?php $_from = $this->_var['user_may_love']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['loop']['iteration']++;
?>
    <dl id="change_goods_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>">
        <dt><a href="goods.php?id=<?php echo $this->_var['good']['goods_id']; ?>"><img src="<?php echo $this->_var['good']['goods_thumb']; ?>" /></a></dt>
        <dd>¥<?php echo $this->_var['good']['rank_price']; ?></dd>
    </dl>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php else: ?>
	<br/>&nbsp;&nbsp;&nbsp;<b>暂无商品</b>
	<?php endif; ?>
    </div>
</div>