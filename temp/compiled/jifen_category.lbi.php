<script>
/*
var curUrl = window.location.href
var curPage = curUrl.split("/");
var lastPara = curPage[curPage.length-1];
$(function(){
   $('.group_nav a').each(function(index){
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
*/

</script>
 <div class="group_nav">
    <h2><a href="<?php echo $this->_var['staticPages']['index']; ?>">
    笨虎之家首页
    </a>
    </h2>
  <a href="<?php echo $this->_var['staticPages']['exchange']; ?>">积分商城</a>
  <a href="<?php echo $this->_var['staticPages']['exchange-get']; ?>">积分获取</a>
  <a href="<?php echo $this->_var['staticPages']['user-my_integral']; ?>">积分明细</a>
 </div>