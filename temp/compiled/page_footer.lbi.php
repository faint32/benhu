
 <div class="footer">
   <div>
      <textarea style="visibility:hidden;">
      <div class="footer_1">
          <ul class="main middle over">
              <li class="footer_1_a middle over">
                  <a class="one" href="article-16.html">全国包邮</a><a class="two" href="article-52.html">正品保障</a><a class="three" href="article-21.html">售后无忧</a>
                </li>
                <li class="footer_1_b">
                  <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['foo']['iteration']++;
?>
                   <?php if (($this->_foreach['foo']['iteration'] - 1) < 6): ?>
                    <p <?php if (($this->_foreach['foo']['iteration'] - 1) < 5): ?>class="footer_1_border_r" <?php endif; ?>  >
                       <?php echo $this->_var['help_cat']['cat_name']; ?>
                    <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                       <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['item']['title']); ?>"><?php echo $this->_var['item']['short_title']; ?></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </p>
                    <?php endif; ?>  
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                
                </li>
            </ul>
        </div>
      </textarea>
 </div>
    <div class="footer_2 middle over">
          <div class="footer_2_main">
            <span></span>
            <div class="footer_2_main_1">
              <p><a href="/">首页</a>|<a href="article-60.html">关于笨虎</a>|<a href="article-5.html">公司介绍</a>|<a href="article-4.html">联系我们</a>|
                <a href="article_cat-3.html">帮助中心</a>|<a href="http://www.ickd.cn" target="_blank">快递查询</a></p>
        
             <?php if ($this->_var['icp_number']): ?>
  <?php echo $this->_var['lang']['icp_number']; ?>:<?php echo $this->_var['icp_number']; ?><br />
    <?php endif; ?>
        <!--ICP备案证书号:沪ICP备10215750号<br />-->
  Copyright <font size="4">©</font> 2014 笨虎之家 www.Benhu.com All rights reserved.  
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F7872c6ecc8120415e07001685cb6d9f3' type='text/javascript'%3E%3C/script%3E"));
</script>

</div></div>
        </div>
</div>

  <div class="huidingbu">
      <span class="huidingbu_title"></span>
      <ul id="nav_dot">
      <li>
          <h4 class=""><span class="hdb_title_1"></span></h4>
          <div class="list-item none" style="">
            <ul class="gototop_b">
          <li><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2271472670&amp;site=qq&amp;menu=yes" target="_blank">在线客服一</a></li>
                <li><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=3072969429&amp;site=qq&amp;menu=yes" target="_blank">在线客服二</a></li>
                <li><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=1793367166&amp;site=qq&amp;menu=yes" target="_blank">在线客服三</a></li>
    <li><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=3073216725&amp;site=qq&amp;menu=yes" target="_blank">在线客服四</a></li>
          
      </ul>
          </div>
        </li>
        <li class="">
          <h4 class=""><span class="hdb_title_2"></span></h4>
          <div class="list-item none" style="display: none;">
            <span class="hdb_main_1">敬请期待
            </span>
          </div>
        </li>
        <li>
          <a href="fankui.php?act=show" target="_blank" class="hdb_title_3"></a>
          <a href="javascript:scroll(0,0)" class="hdb_title_4"></a>
        </li>
  </ul>
</div>
<script type="text/javascript" src="style/js/combine/page_footer.js"></script>
