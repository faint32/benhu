

<?php $_from = $this->_var['banner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_0_48070200_1423706921');$this->_foreach['cats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cats']['total'] > 0):
    foreach ($_from AS $this->_var['cat_0_48070200_1423706921']):
        $this->_foreach['cats']['iteration']++;
?>
<li><div><a href="<?php echo $this->_var['cat_0_48070200_1423706921']['ad_link']; ?>" target="_blank"><img src="data/afficheimg/<?php echo $this->_var['cat_0_48070200_1423706921']['ad_code']; ?>" alt="" /></a></div></li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>