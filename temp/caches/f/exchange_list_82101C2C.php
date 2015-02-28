<?php exit;?>a:3:{s:8:"template";a:5:{i:0;s:60:"D:/wamp/www/benhushop1231/themes/yihaodian/exchange_list.dwt";i:1;s:66:"D:/wamp/www/benhushop1231/themes/yihaodian/library/page_header.lbi";i:2;s:69:"D:/wamp/www/benhushop1231/themes/yihaodian/library/jifen_category.lbi";i:3;s:66:"D:/wamp/www/benhushop1231/themes/yihaodian/library/ad_integral.lbi";i:4;s:66:"D:/wamp/www/benhushop1231/themes/yihaodian/library/page_footer.lbi";}s:7:"expires";i:1425020654;s:8:"maketime";i:1425017054;}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<title>积分商城_笨虎之家</title>
<script type="text/javascript" src="js/jquery.min.js"></script><script type="text/javascript" src="js/jquery.json.js"></script><script type="text/javascript" src="js/common.js"></script><script type="text/javascript" src="js/global.js"></script><script type="text/javascript" src="js/compare.js"></script><script type="text/javascript" src="js/top.js"></script><script type="text/javascript" src="js/curvycorners.src.js"></script><script type="text/javascript" src="js/all_top_nav.js"></script>
<link href="style/css/integral.css" rel="stylesheet" type="text/css" />
</head>
<script>				
   function daily_attendance()
   {
		 $.post("exchange.php",{act:'attent'},function(result){
		  var html="<a href=\"javascript:void(0)\">已签到</a> <span>&nbsp;&nbsp;明天可获得5积分</span>";
		   $('#sign').html(html);
		   html = "可用积分："+( 2611 + parseInt(result));
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
  <link href="style/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><script type="text/javascript" src="js/jquery.SuperSlide.js"></script><script type="text/javascript" src="js/transport.js"></script><script type="text/javascript" src="style/js/combine/page_header.js"></script>
<script type="text/javascript" src="style/js/big_render.js"></script>
<script type="text/javascript" src="style/js/image_lazyload.js"></script>
    
   
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
                                <a href="exchange.php">积分商城</a>
                                <a href="article-4.html">联系我们</a>
                                <a href="article-60.html">关于笨虎</a>
                            </div>
                        </li>
                        <li class="menu2" onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">客户服务
                            <div class="top_2_list">
                                <a href="article-9.html">常见问题</a>
                                <a href="user.php?act=return_goods">在线退换货</a>
                                
				<a href="http://wpa.qq.com/msgrd?v=3&uin=2237209139&site=qq&menu=yes">在线投诉</a>
                             
				<a href="article-16.html">配送范围</a>
                            </div>
                        </li>
                        <li class="top_2_menu_1"><a href="user.php?act=collection_list">我的收藏</a></li>
                        <li class="menu2" onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">个人中心	
                            <div class="top_2_list">
                                    <a href="user.php">我的笨虎</a>
                                        <a href="user.php?act=order_list">我的订单</a>
                                        <a href="user.php?act=my_integral">我的积分</a>
                                        <a href="user.php?act=comment_list">评价商品</a>
                                        <!--<a href="#">会员专享</a>-->
                            </div>
                        </li>
                        <li class="top_2_menu_1">&nbsp;&nbsp;&nbsp;<a href="user.php?act=logout">退出</a></li>
    <li class="top_2_menu_1"><a class="huanying" href="user.php" target="_blank">Hi,554fcae493e564ee0dc75bdf2ebf94canickname|a:1:{s:4:"name";s:8:"nickname";}554fcae493e564ee0dc75bdf2ebf94ca</a><a href="index.php">欢迎来到笨虎之家</a></li>
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
            alert("请输入搜索关键词！");
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
                        <input type="text" maxlength="100" style="color:#333333;" name="keywords" id="keyword" class="header_2_1"  value="" >
                        
                        <input class="header_2_2" type="submit" style="width:98px" value="" >
                        </input>
                   </form>
                </li>
                <li>
                    
                                      <a href="search?keyword=%E7%8E%A9%E5%85%B7" class="only" >玩具</a>
                                      <a href="search?keyword=%E7%AB%A5%E8%A3%85"  >童装</a>
                                      <a href="search?keyword=%E5%A9%B4%E5%84%BF%E8%A3%85"  >婴儿装</a>
                                      <a href="search?keyword=%E5%AD%95%E5%A6%87%E8%A3%85"  >孕妇装</a>
                                      <a href="search?keyword=%E5%A9%B4%E5%84%BF%E7%94%A8%E5%93%81"  >婴儿用品</a>
                                      <a href="search?keyword=%E6%AF%8D%E5%A9%B4%E7%94%A8%E5%93%81"  >母婴用品</a>
                                                          </li>
            </ul>
            <div class="header_3">
            	<div class="header_3_1"><a href="user.php?act=order_list">我的订单</a></div>
                <div class="header_3_2">
                    <div class="fixedBox">
                       <ul class="fixedBoxList">
                         <li style="display: block;"  class="fixeBoxLi cart_bd" id="ECS_CARTINFO">
                             554fcae493e564ee0dc75bdf2ebf94cacart_flow_content|a:1:{s:4:"name";s:17:"cart_flow_content";}554fcae493e564ee0dc75bdf2ebf94ca                         </li>
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
    <h2><a href="index.php">
    笨虎之家首页
    </a>
    </h2>
  <a href="exchange.php">积分商城</a>
  <a href="exchange.php?act=get">积分获取</a>
  <a href="user.php?act=my_integral">积分明细</a>
 </div>
    <div class="integral">
<div class="integral_l">
   	<div class="integral_l_nav">
	    		    <h3><a href="category.php?id=390">孕妈专区</a></h3>
			<div class="product_classify">
			    				   <a href="category.php?id=979" style="width:90px;overflow:hidden;">妈妈配饰&nbsp;</a>
								   <a href="category.php?id=981" style="width:90px;overflow:hidden;">外出用品&nbsp;</a>
								   <a href="category.php?id=468" style="width:90px;overflow:hidden;">产后修复&nbsp;</a>
								   <a href="category.php?id=467" style="width:90px;overflow:hidden;">孕妈内衣&nbsp;</a>
								   <a href="category.php?id=977" style="width:90px;overflow:hidden;">母乳喂养用品&nbsp;</a>
								   <a href="category.php?id=1000" style="width:90px;overflow:hidden;">妈妈洗护用品&nbsp;</a>
								   <a href="category.php?id=983" style="width:90px;overflow:hidden;">孕妇枕/哺乳枕&nbsp;</a>
								   <a href="category.php?id=472" style="width:90px;overflow:hidden;">孕妇装&nbsp;</a>
								   <a href="category.php?id=1017" style="width:90px;overflow:hidden;">妈妈书籍&nbsp;</a>
							</div>
				    <h3><a href="category.php?id=657">宝宝用品</a></h3>
			<div class="product_classify">
			    				   <a href="category.php?id=664" style="width:90px;overflow:hidden;">护理&nbsp;</a>
								   <a href="category.php?id=793" style="width:90px;overflow:hidden;">纸尿裤/防尿用品&nbsp;</a>
								   <a href="category.php?id=665" style="width:90px;overflow:hidden;">清洁用品&nbsp;</a>
								   <a href="category.php?id=667" style="width:90px;overflow:hidden;">安全防护&nbsp;</a>
								   <a href="category.php?id=833" style="width:90px;overflow:hidden;">如厕用品&nbsp;</a>
								   <a href="category.php?id=671" style="width:90px;overflow:hidden;">礼盒套装&nbsp;</a>
								   <a href="category.php?id=659" style="width:90px;overflow:hidden;">洗浴&nbsp;</a>
								   <a href="category.php?id=662" style="width:90px;overflow:hidden;">护肤&nbsp;</a>
							</div>
				    <h3><a href="category.php?id=776">宝宝服饰</a></h3>
			<div class="product_classify">
			    				   <a href="category.php?id=784" style="width:90px;overflow:hidden;">宝宝配饰&nbsp;</a>
								   <a href="category.php?id=779" style="width:90px;overflow:hidden;">宝宝内衣&nbsp;</a>
								   <a href="category.php?id=782" style="width:90px;overflow:hidden;">宝宝鞋&nbsp;</a>
								   <a href="category.php?id=787" style="width:90px;overflow:hidden;">洗浴巾类&nbsp;</a>
								   <a href="category.php?id=789" style="width:90px;overflow:hidden;">礼盒&nbsp;</a>
								   <a href="category.php?id=780" style="width:90px;overflow:hidden;">宝宝外出服&nbsp;</a>
							</div>
				    <h3><a href="category.php?id=879">哺育喂养</a></h3>
			<div class="product_classify">
			    				   <a href="category.php?id=887" style="width:90px;overflow:hidden;">学饮杯&nbsp;</a>
								   <a href="category.php?id=888" style="width:90px;overflow:hidden;">辅助工具&nbsp;</a>
								   <a href="category.php?id=881" style="width:90px;overflow:hidden;">奶瓶&nbsp;</a>
								   <a href="category.php?id=894" style="width:90px;overflow:hidden;">安抚奶嘴&nbsp;</a>
								   <a href="category.php?id=885" style="width:90px;overflow:hidden;">餐具&nbsp;</a>
								   <a href="category.php?id=890" style="width:90px;overflow:hidden;">消毒/加温&nbsp;</a>
								   <a href="category.php?id=883" style="width:90px;overflow:hidden;">奶嘴&nbsp;</a>
								   <a href="category.php?id=892" style="width:90px;overflow:hidden;">辅食喂养与制作&nbsp;</a>
								   <a href="category.php?id=1072" style="width:90px;overflow:hidden;">牙胶/吮食器&nbsp;</a>
								   <a href="category.php?id=1078" style="width:90px;overflow:hidden;">婴儿礼盒&nbsp;</a>
							</div>
				    <h3><a href="category.php?id=652">车床寝具</a></h3>
			<div class="product_classify">
			    				   <a href="category.php?id=978" style="width:90px;overflow:hidden;">架类&nbsp;</a>
								   <a href="category.php?id=653" style="width:90px;overflow:hidden;">寝具&nbsp;</a>
								   <a href="category.php?id=980" style="width:90px;overflow:hidden;">收纳类&nbsp;</a>
								   <a href="category.php?id=685" style="width:90px;overflow:hidden;">婴儿床&nbsp;</a>
								   <a href="category.php?id=811" style="width:90px;overflow:hidden;">配件及其他&nbsp;</a>
							</div>
				    <h3><a href="category.php?id=828">玩具图书</a></h3>
			<div class="product_classify">
			    				   <a href="category.php?id=903" style="width:90px;overflow:hidden;">动手能力&nbsp;</a>
								   <a href="category.php?id=880" style="width:90px;overflow:hidden;">身体运动机能&nbsp;</a>
								   <a href="category.php?id=893" style="width:90px;overflow:hidden;">认知/语言能力&nbsp;</a>
								   <a href="category.php?id=941" style="width:90px;overflow:hidden;">图书&nbsp;</a>
								   <a href="category.php?id=930" style="width:90px;overflow:hidden;">学习/音乐/绘画&nbsp;</a>
								   <a href="category.php?id=832" style="width:90px;overflow:hidden;">早期感官发育&nbsp;</a>
								   <a href="category.php?id=919" style="width:90px;overflow:hidden;">逻辑思维/想象力&nbsp;</a>
							</div>
		    </div>
         	<div id="outer">
    <ul id="tab">
        <li class="current">周排行</li>
        <li>月排行</li>
    </ul>
    <div id="content">
        <ul class="content_box" style="display:block;">
		        </ul>
        <ul class="content_box">
                   </ul>
    </div>
</div>
  </div>
  <div class="integral_r">
       	<div class="integral_r_1">
             	<p class="integral_r_1_a">
<a href="">
<img src="data/afficheimg/1413744708043866531.jpg" width="698" height="250" />
</a>
</p>	      <div class="integral_r_1_b">
                	<dl class="home_left_head">
            	<dt><span>		<img src="uploads/user_pic/28.jpg" style="width:62px;height:62px;"/>
		</span>
		</dt>
                <dd class="home_left_head_name">
		<a href="user.php">abc@163.com</a>
                <span class="home_left_head_class">
		<img src="style/images/vip_s0.png" width="52" height="27" />		</span>
                </dd>
            </dl>
            	<div class="sign" id="sign">
								    					<a href="javascript:daily_attendance()">签到赚积分</a>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;可获得5积分</span>
										                </div>
                <div class="number">
                <span id="available_integral">可用积分：2611</span><a href="user.php?act=my_integral">查看积分明细</a>
                </div>
                </div>
        </div>
            
            	<span class="integral_goods_title">
                	<h2>超值兑换</h2>
                	<a href="exchange.php?type=best&act=more">更多超值兑换&nbsp;&gt;</a>
                </span>
            <div class="integral_goods">
			            	<dl>
                	<dt><a href="exchange.php?act=view&id=1324"><img src="images/201412/thumb_img/1324_thumb_G_1417567229851.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=1324" title="爱得利电子体温计红外线屏幕数字显示耳温计一秒钟测体温TS601">爱得利电子体温计红外线屏幕数字显示耳温计一秒钟测体温TS601</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥283.1</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>2830</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=1470"><img src="images/201412/thumb_img/1470_thumb_G_1417567362724.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=1470" title="NUK 150ML 迪士尼米奇 PP喝水杯">NUK 150ML 迪士尼米奇 PP喝水杯</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥107.1</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>1070</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=311"><img src="images/201412/thumb_img/311_thumb_G_1417566434518.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=311" title="小白熊09115不锈钢多功能双头保温水瓶">小白熊09115不锈钢多功能双头保温水瓶</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥71.2</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>710</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=60"><img src="images/201412/thumb_img/60_thumb_G_1417566276309.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=60" title="良木 竹纤维超柔加厚健康尿垫 婴儿秋冬加厚隔尿垫 LMD023/LMD025">良木 竹纤维超柔加厚健康尿垫 婴儿秋冬加厚隔尿垫 LMD023/LMD025</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥69.0</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>690</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=1917"><img src="images/201412/thumb_img/1917_thumb_G_1417567805976.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=1917" title="正品爱得利 DT-118 IVORY BABY 长袖哈衣">正品爱得利 DT-118 IVORY BABY 长袖哈衣</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥66.5</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>670</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=1190"><img src="images/201412/thumb_img/1190_thumb_G_1417567103504.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=1190" title="贝亲PL156奶瓶清洗剂促销装(MA27+MA28)">贝亲PL156奶瓶清洗剂促销装(MA27+MA28)</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥64.8</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>650</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=223"><img src="images/201412/thumb_img/223_thumb_G_1417566266750.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=223" title="小白熊HL-0622变频式电子驱蚊器　　">小白熊HL-0622变频式电子驱蚊器　　</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥39.2</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>390</b>积分</li>
						</ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=2550"><img src="images/201412/thumb_img/2550_thumb_G_1417568390560.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=2550" title="爱得利 配备实感奶嘴 宽口径PP奶瓶Y1028婴儿pp宽口奶瓶120ml">爱得利 配备实感奶嘴 宽口径PP奶瓶Y1028婴儿pp宽口奶瓶120ml</a></dd>
					<div class="price">
						<ul class="price_1">
								<li class="price_1_a">原价：¥34.2</li>
								<li class="price_1_b"><span>¥0.0</span>+<b>340</b>积分</li>
						</ul>
                    </div>
                </dl>
                         
            </div>
        <span class="integral_goods_title">
                	<h2>精品上新</h2>
               	<a href="exchange.php?type=new&act=more">更多精品&nbsp;&gt;</a>
        </span>
        <div class="integral_goods">
		            	<dl>
                	<dt><a href="exchange.php?act=view&id=3144"><img src="images/201412/goods_img/3144_G_1417569010688.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=3144" title="为生双层银纤维肚兜wsjd-8025">为生双层银纤维肚兜wsjd-8025</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥286.4</li>
                            <li class="price_1_b"><span>¥179.0</span>+<b>1070</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=3127"><img src="images/201412/goods_img/3127_G_1417568998079.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=3127" title="舒雅贝贝 信封领葫芦睡袋AW001">舒雅贝贝 信封领葫芦睡袋AW001</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥288.0</li>
                            <li class="price_1_b"><span>¥160.0</span>+<b>1280</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=441"><img src="images/201412/goods_img/441_G_1417566326390.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=441" title="小白熊09257欢豆婴儿浴盆">小白熊09257欢豆婴儿浴盆</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥239.2</li>
                            <li class="price_1_b"><span>¥149.5</span>+<b>900</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=2318"><img src="images/201412/goods_img/2318_G_1417568181999.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=2318" title="艾妮宝贝莫代尔针织哺乳套装AQ924107">艾妮宝贝莫代尔针织哺乳套装AQ924107</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥171.0</li>
                            <li class="price_1_b"><span>¥114.0</span>+<b>570</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=3075"><img src="images/201412/goods_img/3075_G_1417568929446.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=3075" title="安宝儿 竹纤维夹丝素色圆领套A3143">安宝儿 竹纤维夹丝素色圆领套A3143</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥83.1</li>
                            <li class="price_1_b"><span>¥51.9</span>+<b>310</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=2585"><img src="images/201412/goods_img/2585_G_1417568422241.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=2585" title="Ampais恩贝氏产后修复去妊娠纹产后消除孕妇妊娠纹橄榄油30ML/100ML">Ampais恩贝氏产后修复去妊娠纹产后消除孕妇妊娠纹橄榄油30ML/100ML</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥64.6</li>
                            <li class="price_1_b"><span>¥34.0</span>+<b>310</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=375"><img src="images/201412/goods_img/375_G_1417566301937.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=375" title="专柜正品日康RK-3049标准口径防胀气液硅胶软体婴儿奶瓶120ml有柄">专柜正品日康RK-3049标准口径防胀气液硅胶软体婴儿奶瓶120ml有柄</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥61.2</li>
                            <li class="price_1_b"><span>¥34.0</span>+<b>270</b>积分</li>
                        </ul>
                    </div>
                </dl>
                        	<dl>
                	<dt><a href="exchange.php?act=view&id=671"><img src="images/201412/goods_img/671_G_1417566702696.jpg" /></a></dt>
                    <dd class="name"><a href="exchange.php?act=view&id=671" title="NUK 230ML 耐高温玻璃彩色奶瓶(带1号仿真通气奶嘴)40.745.703">NUK 230ML 耐高温玻璃彩色奶瓶(带1号仿真通气奶嘴)40.745.703</a></dd>
                  <div class="price">
                   	<ul class="price_1">
                        	<li class="price_1_a">原价：¥58.5</li>
                            <li class="price_1_b"><span>¥32.5</span>+<b>260</b>积分</li>
                        </ul>
                    </div>
                </dl>
                         
            </div>
    <span class="integral_goods_title">
   	<h2>下期预告</h2>
    </span>
   	<div class="notice">
		    </div>
      </div>
    </div>
 <div class="footer">
   <div>
      <textarea style="visibility:hidden;">
      <div class="footer_1">
          <ul class="main middle over">
              <li class="footer_1_a middle over">
                  <a class="one" href="article-16.html">全国包邮</a><a class="two" href="article-52.html">正品保障</a><a class="three" href="article-21.html">售后无忧</a>
                </li>
                <li class="footer_1_b">
                                                         <p class="footer_1_border_r"   >
                       新手上路                                            <a href="article.php?id=9" title="常见问题">常见问题</a>
                                           <a href="article.php?id=10" title="购物流程">购物流程</a>
                                           <a href="article.php?id=45" title="联系客服">联系客服</a>
                                           <a href="article.php?id=50" title="积分规则">积分规则</a>
                                        </p>
                      
                                                         <p class="footer_1_border_r"   >
                       配送方式                                            <a href="article.php?id=16" title="配送范围及运费">配送范围及运费</a>
                                           <a href="article.php?id=17" title="配送进度查询">配送进度查询</a>
                                        </p>
                      
                                                         <p class="footer_1_border_r"   >
                       支付方式                                           <a href="article.php?id=46" title="支付宝">支付宝</a>
                                           <a href="article.php?id=104" title="快钱支付">快钱支付</a>
                                        </p>
                      
                                                         <p class="footer_1_border_r"   >
                       售后服务                                           <a href="article.php?id=21" title="退换货原则">退换货原则</a>
                                           <a href="article.php?id=23" title="退款说明">退款说明</a>
                                           <a href="article.php?id=52" title="正品保障">正品保障</a>
                                        </p>
                      
                                                         <p class="footer_1_border_r"   >
                       自助服务                                           <a href="article.php?id=18" title="退换货申请">退换货申请</a>
                                           <a href="article.php?id=19" title="在线投诉">在线投诉</a>
                                           <a href="article.php?id=20" title="我的订单">我的订单</a>
                                        </p>
                      
                                                         <p   >
                       帮助信息                                           <a href="article.php?id=24" title="网站故障报告">网站故障报告</a>
                                           <a href="article.php?id=26" title="投诉与建议">投诉与建议</a>
                                        </p>
                      
                                       
                                  
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
        
               ICP备案证书号:浙ICP备14009263号-1<br />
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
</body>
</html>