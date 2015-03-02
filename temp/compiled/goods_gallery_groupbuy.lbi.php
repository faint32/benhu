
 <div id="preview">
          <div class=jqzoom>
			 <?php if ($this->_var['pictures']): ?> 
				<img  id='bigImg' width='350' height='350' src="<?php echo $this->_var['pictures']['0']['img_url']; ?>" jqimg="<?php echo $this->_var['pictures']['0']['img_original']; ?>">  			
			<?php endif; ?>
          </div>
          <div id='spec'>
			  <div id='specLeft' class="control specLeftT"></div>
			  <div id='specList'>
				<ul class='listImg' >
				    <?php if ($this->_var['pictures']): ?> 
					<?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');if (count($_from)):
    foreach ($_from AS $this->_var['picture']):
?>
						 <li><img src="<?php echo $this->_var['picture']['thumb_url']; ?>" src_H="<?php echo $this->_var['picture']['img_url']; ?>" src_D="<?php echo $this->_var['picture']['img_original']; ?>">  </li>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
					<?php endif; ?>
				</ul>
			  </div>
			  <div id='specRight' class="control specRightT"></div>
          </div>
  </div>
  
    <div class="item_collect">
    	<a class="a" href="javascript:collect('<?php echo $this->_var['goods']['goods_id']; ?>')">收藏该商品</a>
    
 <div  id="bdshare"  class="bdshare_t bds_tools get-codes-bdshare" >  
		<span class="bds_more">分享给朋友</span>
</div>
	

   <script type="text/javascript" id="bdshare_js" data="type=tools" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
    </script>
 </div>
 		<style type="text/css">
 .bdshare-button-style0-16 a, .bdshare-button-style0-16 .bds_more{
	background-image : url("");
	}
   

</style>
 