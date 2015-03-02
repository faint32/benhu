<link href="style/css/style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="style/js/shoppingcar.js"></script>

    
   

   <div class="top">
    	<div class="main middle">
            <ul class="top_1">
                <li onClick="javascript:window.external.AddFavorite('www.baidu.com','母婴')" title="母婴"><a href="javascript:bookmark();" title="加入收藏">加入收藏</a></li>
				<li><a href="http://weibo.com/benhukeji"  target="_blank">关注我们</a></li>
	    </ul>
        	<div class="top_2">
                   <ul>
                        <li class="menu2" onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">网站导航	
                            <div class="top_2_list">
                                <a href="article_cat-5.html">新手上路</a>
                                <!--<a href="group_buy.php">团&nbsp;&nbsp;&nbsp;&nbsp;购</a>-->
                                <a href="<?php echo $this->_var['staticPages']['exchange']; ?>">积分商城</a>
                                <a href="article-4.html">联系我们</a>
                                <a href="article-60.html">关于笨虎</a>
                            </div>
                        </li>
                        <li class="menu2" onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">客户服务
                            <div class="top_2_list">
                                <a href="article-9.html">常见问题</a>
                                <a href="<?php echo $this->_var['staticPages']['user-return_goods']; ?>">在线退换货</a>
                                
				<a href="http://wpa.qq.com/msgrd?v=3&uin=2237209139&site=qq&menu=yes">在线投诉</a>
                             
				<a href="article-16.html">配送范围</a>
                            </div>
                        </li>
                        <li class="top_2_menu_1"><a href="<?php echo $this->_var['staticPages']['user-collection_list']; ?>">我的收藏</a></li>
                        <li class="menu2" onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">个人中心	
                            <div class="top_2_list">
                                    <a href="<?php echo $this->_var['staticPages']['user']; ?>">我的笨虎</a>
                                        <a href="<?php echo $this->_var['staticPages']['user-order_list']; ?>">我的订单</a>
                                        <a href="<?php echo $this->_var['staticPages']['user-my_integral']; ?>">我的积分</a>
                                        <a href="<?php echo $this->_var['staticPages']['user-comment_list']; ?>">评价商品</a>
                                        <!--<a href="#">会员专享</a>-->
                            </div>
                        </li>
<?php if ($_SESSION['user_id'] > 0): ?>
                        <li class="top_2_menu_1">&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_var['staticPages']['user-logout']; ?>">退出</a></li>
<?php else: ?>
<?php if ($_SESSION['user_id'] <= 0): ?>
                        <li class="top_2_menu_1"><a href="<?php echo $this->_var['staticPages']['user-register']; ?>">注册</a></li>
                        <li  class="toplogin">
                            <div class="toplogin_menu"><a href="<?php echo $this->_var['staticPages']['user']; ?>" class="signin">登录</a> </div>
                            <div id="toplogin_main">
                              <ul class="sublist_1">
                                <form name="formLogin" action="<?php echo $this->_var['staticPages']['user']; ?>" method="post" onSubmit="return userLogin()">
                                <dl class="sublist_1_login" style=" *margin-top:20px!important;">
                                    <dt>用户名：</dt>
                                    <dd><input type="text" name="username" value="请输入邮箱或手机" onfocus="if(this.value=='请输入邮箱或手机'){this.value='';}"  onblur="if(this.value==''){this.value='请输入邮箱或手机';}" /></dd>
                                </dl>
                                <dl class="sublist_1_login">
                                    <dt>密&nbsp;&nbsp;码：</dt>
                                    <dd><input type="password" name="password" value="请输入密码" onfocus="if(this.value=='请输入密码'){this.value='';}"  onblur="if(this.value==''){this.value='请输入密码';}" /></dd>
                                </dl>

				<table width="180" height="20" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="remember" type="checkbox" value="" /></td>
                                      <td>七天内免登录</td>
                                      <td align="right"><a href="<?php echo $this->_var['staticPages']['user-get_password']; ?>">忘记密码？</a></td>
                                    </tr>
                                </table>
                                    <span><input type="submit" name="submit" value="登&nbsp;录" /></span>
				    <input type="hidden" name="act" value="act_login" />
					<input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
                                    </form>
                            </ul>
                          </div>
                        </li>
<?php endif; ?>
<?php endif; ?>
    <li class="top_2_menu_1"><a class="huanying" href="<?php echo $this->_var['staticPages']['user']; ?>" target="_blank">Hi,<?php 
$k = array (
  'name' => 'nickname',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></a><a href="<?php echo $this->_var['staticPages']['index']; ?>">欢迎来到笨虎之家</a></li>
	</ul>

</div>
<script type="text/javascript">
(function(){

	var time = null;
	var list = $("#top_2_navlist");
	var box = $("#top_2_navbox");
	var lista = list.find("a");
	
	for(var i=0,j=lista.length;i<j;i++){
		if(lista[i].className == "now"){
			var olda = i;
		}
	}
	
	var box_show = function(hei){
		box.stop().animate({
			height:hei,
			opacity:1
		},400);
	}
	
	var box_hide = function(){
		box.stop().animate({
			height:0,
			opacity:0
		},400);
	}
	
	lista.hover(function(){
		lista.removeClass("now");
		$(this).addClass("now");
		clearTimeout(time);
		var index = list.find("a").index($(this));
		box.find(".cont").hide().eq(index).show();
		var _height = box.find(".cont").eq(index).height()+54;
		box_show(_height)
	},function(){
		time = setTimeout(function(){	
			box.find(".cont").hide();
			box_hide();
		},50);
		lista.removeClass("now");
		lista.eq(olda).addClass("now");
	});
	
	box.find(".cont").hover(function(){
		var _index = box.find(".cont").index($(this));
		lista.removeClass("now");
		lista.eq(_index).addClass("now");
		clearTimeout(time);
		$(this).show();
		var _height = $(this).height()+54;
		box_show(_height);
	},function(){
		time = setTimeout(function(){		
			$(this).hide();
			box_hide();
		},50);
		lista.removeClass("now");
		lista.eq(olda).addClass("now");
	});

})();
</script>
        </div>

    </div>



  <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
            return false;
        }
    }
    -->
    
    </script>
 
    <div class="header middle over">
    	<a class="logo" href="/"><div style="margin-left: 243px;margin-top: 11px;"><img src="style/images/logo2.png"></div></a>
        <ul class="header_2 over">
            	<li>
                     <form name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" >
                        <input type="text" maxlength="100" style="color:#333333;" name="keywords" id="keyword" class="header_2_1"  value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" >
                        
                        <input class="header_2_2" type="submit" style="width:98px" value="" >
                        </input>
                   </form>
                </li>
                <li>
                   <?php if ($this->_var['searchkeywords']): ?> 
                      <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['foo']['iteration']++;
?>
                <a href="search?keyword=<?php echo urlencode($this->_var['val']); ?>" <?php if (($this->_foreach['foo']['iteration'] <= 1)): ?>class="only"<?php endif; ?> ><?php echo $this->_var['val']; ?></a>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                </li>
            </ul>
            <div class="header_3">
            	<div class="header_3_1"><a href="<?php echo $this->_var['staticPages']['user-order_list']; ?>">我的订单</a></div>
                <div class="header_3_2">
                    <div class="fixedBox">
                       <ul class="fixedBoxList">
                         <li style="display: block;"  class="fixeBoxLi cart_bd" id="ECS_CARTINFO">
                             <?php 
$k = array (
  'name' => 'cart_flow_content',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
                         </li>
                       </ul>
                     </div>
                </div>
         </div>
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
