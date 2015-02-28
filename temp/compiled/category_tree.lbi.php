
<div class="nav-wrap middle">
  <div class="nav">
    <div class="goods">
      <div>
       <script>
          function xianshi() {
              document.getElementById("dvtype").style.display = "";
          }
		  
$(function(){
var curUrl = window.location.href
var curPage = curUrl.split("/");
var lastPara = curPage[curPage.length-1];
   $('.nav-list-currenOrNot a').each(function(index){
    if($(this).attr('href') == lastPara)
	{
	   $(this).addClass('on');
	}
	else if( $(this).hasClass('on'))
	{
	  $(this).removeClass('on');
	}
   });
});
      </script>
        <h2> <a onmouseover="xianshi()">所有商品分类</a></h2>
      </div>

       <div id="dvtype" onmouseout="yincang()" class="all-goods" style="display:none;">
<?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cats']['iteration']++;
?>
        <div class="item  <?php if (($this->_foreach['cats']['iteration'] - 1) < 1): ?>btnone<?php endif; ?>">
          <div class="product">
            <h3 class="mylistbj<?php echo $this->_foreach['cats']['iteration']; ?>">
                    <?php echo htmlspecialchars($this->_var['cat']['name']); ?>
            </h3>
            <div class="product_classify">
                
                    <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['foo']['iteration']++;
?>
                        <?php if (($this->_foreach['foo']['iteration'] - 1) < 6): ?>
                    <a href="<?php echo $this->_var['child']['url']; ?>"  target="_blank"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos<?php echo $this->_foreach['cats']['iteration']; ?>"> 
            
            <div class="cf">
              <div>
                <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['foo']['iteration']++;
?>
                <h4><a href="<?php echo $this->_var['child']['url']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></h4>
                <p class="cf">
                  <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?>
                  <a href="<?php echo $this->_var['childer']['url']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </p>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </div>
            </div>
          </div>

        </div>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    </div>
    <ul class="nav-list cf nav-list-currenOrNot">
        <li><a href="index.php"><?php echo $this->_var['lang']['home']; ?></a></li>
         <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
        <li><a href="<?php echo $this->_var['nav']['url']; ?>" target="_blank" ><?php echo $this->_var['nav']['name']; ?></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>

  </div>
</div>

<script type="text/javascript">
function deleteCartGoods(rec_id)
{
	Ajax.call('delete_cart_goods.php', 'id='+rec_id, deleteCartGoodsResponse, 'POST', 'JSON');
}

/**
 * 接收返回的信息
 */
function deleteCartGoodsResponse(res)
{
  if (res.error)
  {
    alert(res.err_msg);
  }
  else
  {
      document.getElementById('ECS_CARTINFO').innerHTML = res.content;
  }
}
</script>
