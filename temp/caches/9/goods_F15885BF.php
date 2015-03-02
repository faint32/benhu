<?php exit;?>a:3:{s:8:"template";a:10:{i:0;s:52:"D:/wamp/www/benhushop1231/themes/yihaodian/goods.dwt";i:1;s:75:"D:/wamp/www/benhushop1231/themes/yihaodian/library/page_header_groupbuy.lbi";i:2;s:68:"D:/wamp/www/benhushop1231/themes/yihaodian/library/category_tree.lbi";i:3;s:63:"D:/wamp/www/benhushop1231/themes/yihaodian/library/ur_here1.lbi";i:4;s:77:"D:/wamp/www/benhushop1231/themes/yihaodian/library/goods_gallery_groupbuy.lbi";i:5;s:64:"D:/wamp/www/benhushop1231/themes/yihaodian/library/sale_info.lbi";i:6;s:66:"D:/wamp/www/benhushop1231/themes/yihaodian/library/cart_or_buy.lbi";i:7;s:66:"D:/wamp/www/benhushop1231/themes/yihaodian/library/goods_descr.lbi";i:8;s:66:"D:/wamp/www/benhushop1231/themes/yihaodian/library/page_footer.lbi";i:9;s:71:"D:/wamp/www/benhushop1231/themes/yihaodian/library/cart_goods_added.lbi";}s:7:"expires";i:1425290671;s:8:"maketime";i:1425287071;}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="笨虎 笨虎之家 母婴生活馆 网上购物 日康 日康奶瓶 日康PPSU奶瓶 日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001 奶瓶 哺乳喂养" />
<meta name="Description" content="笨虎之家母婴生活馆日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001产品，本商城提供日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001的最新报价、日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001的促销、日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001的评论、日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)R" />
<title>日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001_PPSU奶瓶_奶瓶_哺育喂养_笨虎之家</title>
  <link href="style/css/style_groupBuy.css" rel="stylesheet" type="text/css" />
  <link href="style/css/item.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="js/jquery.min.js"></script><script type="text/javascript" src="js/item_1.js"></script><script type="text/javascript" src="js/all_top_nav.js"></script><script type="text/javascript" src="js/item_2.js"></script><script type="text/javascript" src="js/item_hdm.js"></script><script type="text/javascript" src="js/top.js"></script><script type="text/javascript" src="js/common.js"></script><script type="text/javascript" src="js/lefttime.js"></script> <script type="text/javascript" src="js/jquery.json.js"></script>  
  <script type="text/javascript" src="js/transport.js"></script><script type="text/javascript" src="js/utils.js"></script>
  <script type="text/javascript" src="style/js/left_nav_2.js"></script>
  <script type="text/javascript" src="style/js/product_amount.js"></script>
  <script type="text/javascript" src="style/js/home_tab.js"></script>
<script type=text/javascript>
function turnoff(obj){
document.getElementById(obj).style.display="none";
}
$(function(){
    /* 鼠标移动小图，小图对应大图显示在大图上，并替换放大镜中的图*/
    $("#specList ul li img").livequery("mouseover",function(){ 
        var imgSrc = $(this).attr("src");
        var i = imgSrc.lastIndexOf(".");
        var unit = imgSrc.substring(i);
        imgSrc = imgSrc.substring(0,i);
        var imgSrc_small = $(this).attr("src_D");
        var imgSrc_big = $(this).attr("src_H");
        $("#bigImg").attr({"src": imgSrc_small ,"jqimg": imgSrc_big});
        $(this).css({"border":"2px solid #f13d6d","padding":"1px"});
    });
    
    $("#specList ul li img").livequery("mouseout",function(){ 
        $(this).css({"border":"1px solid #e6e6e6","padding":"2px"});
    });
    
    //使用jqzoom
    $(".jqzoom").jqueryzoom({
        xzoom: 350, //放大图的宽度(默认是 200)
        yzoom: 350, //放大图的高度(默认是 200)
        offset: 10, //离原图的距离(默认是 10)
        position: "right", //放大图的定位(默认是 "right")
        preload:1   
    });
    
    /*如果小图过多，则出现滚动条在一行展示*/
    var btnNext = $('#specRight');
    var btnPrev = $('#specLeft')
    var ul = btnPrev.next().find('ul');
    var len = ul.find('li').length;
    var i = 0 ;
    if (len > 4) {
        $("#specRight").addClass("specRightF").removeClass("specRightT");
        ul.css("width", 76 * len)
        btnNext.click(function(e) {
            if(i>=len-4){
                
                return;
            }
            i++;
            if(i == len-4){
                $("#specRight").addClass("specRightT").removeClass("specRightF");
            }
            $("#specLeft").addClass("specLeftF").removeClass("specLeftT");
            moveS(i);
        })
        btnPrev.click(function(e) {
            if(i<=0){
                return;
            }
            i--;
            if(i==0){
                $("#specLeft").addClass("specLeftT").removeClass("specLeftF");
            }
            $("#specRight").addClass("specRightF").removeClass("specRightT");
            moveS(i);
        })
    }
    function moveS(i) {
        ul.animate({left:-78 * i}, 500)
    }
    function picAuto(){
      if ($(".listImg li").size()<=4) {
        $("#specLeft,#specRight").hide();
      }
    }
    picAuto();
});
    
        
</script>
</head>
<body>
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
        <div class="item  btnone">
          <div class="product">
            <h3 class="mylistbj1">
                    孕妈专区            </h3>
            <div class="product_classify">
                
                                                                <a href="category.php?id=979"  target="_blank">妈妈配饰</a>
                                                                                        <a href="category.php?id=981"  target="_blank">外出用品</a>
                                                                                        <a href="category.php?id=468"  target="_blank">产后修复</a>
                                                                                        <a href="category.php?id=467"  target="_blank">孕妈内衣</a>
                                                                                        <a href="category.php?id=977"  target="_blank">母乳喂养用品</a>
                                                                                        <a href="category.php?id=1000"  target="_blank">妈妈洗护用品</a>
                                                                                                                                                                                            </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos1"> 
            
            <div class="cf">
              <div>
                                <h4><a href="category.php?id=979" target="_blank">妈妈配饰</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1042" target="_blank">毛巾/浴巾/干发巾</a>
                                  </p>
                                <h4><a href="category.php?id=981" target="_blank">外出用品</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1011" target="_blank">亲子带/学步带</a>
                                    <a href="category.php?id=1008" target="_blank">妈妈包</a>
                                    <a href="category.php?id=1070" target="_blank">婴儿背带</a>
                                    <a href="category.php?id=1071" target="_blank">抱婴腰凳</a>
                                    <a href="category.php?id=1075" target="_blank">防走失带</a>
                                  </p>
                                <h4><a href="category.php?id=468" target="_blank">产后修复</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1046" target="_blank">妊娠纹修复</a>
                                    <a href="category.php?id=1045" target="_blank">紧致肌肤</a>
                                    <a href="category.php?id=1043" target="_blank">束腹裤/带</a>
                                    <a href="category.php?id=1089" target="_blank">收腹带</a>
                                  </p>
                                <h4><a href="category.php?id=467" target="_blank">孕妈内衣</a></h4>
                <p class="cf">
                                    <a href="category.php?id=633" target="_blank">哺乳文胸</a>
                                    <a href="category.php?id=638" target="_blank">睡衣家居服/哺乳装</a>
                                    <a href="category.php?id=636" target="_blank">内裤/生理裤/产检裤</a>
                                  </p>
                                <h4><a href="category.php?id=977" target="_blank">母乳喂养用品</a></h4>
                <p class="cf">
                                    <a href="category.php?id=477" target="_blank">吸奶器</a>
                                    <a href="category.php?id=1053" target="_blank">母乳存储</a>
                                    <a href="category.php?id=1054" target="_blank">乳垫</a>
                                    <a href="category.php?id=1055" target="_blank">乳房护理</a>
                                  </p>
                                <h4><a href="category.php?id=1000" target="_blank">妈妈洗护用品</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1052" target="_blank">洁牙护齿</a>
                                    <a href="category.php?id=474" target="_blank">待产包</a>
                                    <a href="category.php?id=1048" target="_blank">产褥垫/护理垫</a>
                                    <a href="category.php?id=1047" target="_blank">湿巾/清洁棉</a>
                                    <a href="category.php?id=475" target="_blank">产妇卫生巾/护垫</a>
                                    <a href="category.php?id=1049" target="_blank">洁面</a>
                                    <a href="category.php?id=1051" target="_blank">洗发沐浴</a>
                                    <a href="category.php?id=1050" target="_blank">护肤</a>
                                  </p>
                                <h4><a href="category.php?id=983" target="_blank">孕妇枕/哺乳枕</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1058" target="_blank">靠枕/垫</a>
                                    <a href="category.php?id=1059" target="_blank">哺乳枕</a>
                                  </p>
                                <h4><a href="category.php?id=472" target="_blank">孕妇装</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1032" target="_blank">防辐射服</a>
                                  </p>
                                <h4><a href="category.php?id=1017" target="_blank">妈妈书籍</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1028" target="_blank">孕产妈妈</a>
                                    <a href="category.php?id=1031" target="_blank">美容瘦身</a>
                                    <a href="category.php?id=1029" target="_blank">育儿亲子</a>
                                    <a href="category.php?id=1030" target="_blank">饮食健康</a>
                                    <a href="category.php?id=1064" target="_blank">孕产育儿</a>
                                  </p>
                              </div>
            </div>
          </div>
        </div>
                 <div class="item  ">
          <div class="product">
            <h3 class="mylistbj2">
                    宝宝用品            </h3>
            <div class="product_classify">
                
                                                                <a href="category.php?id=664"  target="_blank">护理</a>
                                                                                        <a href="category.php?id=793"  target="_blank">纸尿裤/防尿用品</a>
                                                                                        <a href="category.php?id=665"  target="_blank">清洁用品</a>
                                                                                        <a href="category.php?id=667"  target="_blank">安全防护</a>
                                                                                        <a href="category.php?id=833"  target="_blank">如厕用品</a>
                                                                                        <a href="category.php?id=671"  target="_blank">礼盒套装</a>
                                                                                                                                                </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos2"> 
            
            <div class="cf">
              <div>
                                <h4><a href="category.php?id=664" target="_blank">护理</a></h4>
                <p class="cf">
                                    <a href="category.php?id=720" target="_blank">吸鼻器/清洁镊子</a>
                                    <a href="category.php?id=731" target="_blank">理发器</a>
                                    <a href="category.php?id=716" target="_blank">湿巾</a>
                                    <a href="category.php?id=725" target="_blank">口腔护理</a>
                                    <a href="category.php?id=739" target="_blank">家用医药</a>
                                    <a href="category.php?id=734" target="_blank">体温计</a>
                                    <a href="category.php?id=730" target="_blank">发梳组</a>
                                    <a href="category.php?id=728" target="_blank">指甲钳/剪刀</a>
                                    <a href="category.php?id=737" target="_blank">湿巾加热器</a>
                                    <a href="category.php?id=718" target="_blank">粉扑</a>
                                    <a href="category.php?id=723" target="_blank">耳部护理</a>
                                    <a href="category.php?id=722" target="_blank">棉棒/棉签</a>
                                  </p>
                                <h4><a href="category.php?id=793" target="_blank">纸尿裤/防尿用品</a></h4>
                <p class="cf">
                                    <a href="category.php?id=808" target="_blank">L</a>
                                    <a href="category.php?id=802" target="_blank">S</a>
                                    <a href="category.php?id=819" target="_blank">隔尿裤</a>
                                    <a href="category.php?id=809" target="_blank">XL</a>
                                    <a href="category.php?id=801" target="_blank">NB</a>
                                    <a href="category.php?id=805" target="_blank">M</a>
                                    <a href="category.php?id=810" target="_blank">XXL</a>
                                    <a href="category.php?id=823" target="_blank">尿布/尿片</a>
                                    <a href="category.php?id=815" target="_blank">隔尿垫</a>
                                  </p>
                                <h4><a href="category.php?id=665" target="_blank">清洁用品</a></h4>
                <p class="cf">
                                    <a href="category.php?id=748" target="_blank">柔顺剂</a>
                                    <a href="category.php?id=750" target="_blank">消毒液</a>
                                    <a href="category.php?id=746" target="_blank">洗衣液/粉</a>
                                    <a href="category.php?id=1084" target="_blank">洗衣皂</a>
                                    <a href="category.php?id=1091" target="_blank">奶瓶清洗剂</a>
                                  </p>
                                <h4><a href="category.php?id=667" target="_blank">安全防护</a></h4>
                <p class="cf">
                                    <a href="category.php?id=756" target="_blank">坐便垫</a>
                                    <a href="category.php?id=758" target="_blank">护脐</a>
                                    <a href="category.php?id=752" target="_blank">室内安全</a>
                                    <a href="category.php?id=1076" target="_blank">提醒/多功能防护</a>
                                  </p>
                                <h4><a href="category.php?id=833" target="_blank">如厕用品</a></h4>
                <p class="cf">
                                    <a href="category.php?id=834" target="_blank">坐便器</a>
                                  </p>
                                <h4><a href="category.php?id=671" target="_blank">礼盒套装</a></h4>
                <p class="cf">
                                    <a href="category.php?id=762" target="_blank">清洁套装/礼盒</a>
                                  </p>
                                <h4><a href="category.php?id=659" target="_blank">洗浴</a></h4>
                <p class="cf">
                                    <a href="category.php?id=674" target="_blank">香皂</a>
                                    <a href="category.php?id=687" target="_blank">水温计</a>
                                    <a href="category.php?id=684" target="_blank">浴擦/海绵</a>
                                    <a href="category.php?id=830" target="_blank">浴盆/浴床</a>
                                    <a href="category.php?id=678" target="_blank">洗手液</a>
                                    <a href="category.php?id=822" target="_blank">洗发精</a>
                                    <a href="category.php?id=816" target="_blank">沐浴露</a>
                                    <a href="category.php?id=824" target="_blank">浴帽</a>
                                    <a href="category.php?id=820" target="_blank">洗发沐浴二合一</a>
                                  </p>
                                <h4><a href="category.php?id=662" target="_blank">护肤</a></h4>
                <p class="cf">
                                    <a href="category.php?id=702" target="_blank">防冻/防裂</a>
                                    <a href="category.php?id=711" target="_blank">护唇</a>
                                    <a href="category.php?id=695" target="_blank">爽身</a>
                                    <a href="category.php?id=713" target="_blank">护手</a>
                                    <a href="category.php?id=699" target="_blank">护臀</a>
                                    <a href="category.php?id=693" target="_blank">润肤</a>
                                    <a href="category.php?id=701" target="_blank">止痒/防蚊虫</a>
                                    <a href="category.php?id=707" target="_blank">防痱</a>
                                    <a href="category.php?id=710" target="_blank">防晒</a>
                                  </p>
                              </div>
            </div>
          </div>
        </div>
                 <div class="item  ">
          <div class="product">
            <h3 class="mylistbj3">
                    宝宝服饰            </h3>
            <div class="product_classify">
                
                                                                <a href="category.php?id=784"  target="_blank">宝宝配饰</a>
                                                                                        <a href="category.php?id=779"  target="_blank">宝宝内衣</a>
                                                                                        <a href="category.php?id=782"  target="_blank">宝宝鞋</a>
                                                                                        <a href="category.php?id=787"  target="_blank">洗浴巾类</a>
                                                                                        <a href="category.php?id=789"  target="_blank">礼盒</a>
                                                                                        <a href="category.php?id=780"  target="_blank">宝宝外出服</a>
                                                        </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos3"> 
            
            <div class="cf">
              <div>
                                <h4><a href="category.php?id=784" target="_blank">宝宝配饰</a></h4>
                <p class="cf">
                                    <a href="category.php?id=868" target="_blank">围兜/口水巾/反穿衣</a>
                                    <a href="category.php?id=867" target="_blank">手脚套包</a>
                                    <a href="category.php?id=866" target="_blank">肚围/护脐带</a>
                                    <a href="category.php?id=865" target="_blank">口罩/护膝</a>
                                    <a href="category.php?id=863" target="_blank">宝宝袜</a>
                                    <a href="category.php?id=864" target="_blank">帽子/围巾/手套</a>
                                    <a href="category.php?id=1087" target="_blank">手帕</a>
                                  </p>
                                <h4><a href="category.php?id=779" target="_blank">宝宝内衣</a></h4>
                <p class="cf">
                                    <a href="category.php?id=800" target="_blank">哈衣/蝴蝶衣/连身服</a>
                                    <a href="category.php?id=835" target="_blank">内裤</a>
                                    <a href="category.php?id=797" target="_blank">套装</a>
                                    <a href="category.php?id=794" target="_blank">裤子</a>
                                    <a href="category.php?id=791" target="_blank">上衣</a>
                                    <a href="category.php?id=803" target="_blank">长袍</a>
                                  </p>
                                <h4><a href="category.php?id=782" target="_blank">宝宝鞋</a></h4>
                <p class="cf">
                                    <a href="category.php?id=859" target="_blank">凉鞋</a>
                                    <a href="category.php?id=860" target="_blank">棉鞋/棉靴</a>
                                    <a href="category.php?id=854" target="_blank">学步鞋</a>
                                  </p>
                                <h4><a href="category.php?id=787" target="_blank">洗浴巾类</a></h4>
                <p class="cf">
                                    <a href="category.php?id=870" target="_blank">方巾/面巾/手帕/垫背巾</a>
                                    <a href="category.php?id=872" target="_blank">毛巾/面巾/方巾</a>
                                    <a href="category.php?id=873" target="_blank">浴巾/浴衣</a>
                                  </p>
                                <h4><a href="category.php?id=789" target="_blank">礼盒</a></h4>
                <p class="cf">
                                    <a href="category.php?id=875" target="_blank">服装礼盒/毛巾礼盒</a>
                                  </p>
                                <h4><a href="category.php?id=780" target="_blank">宝宝外出服</a></h4>
                <p class="cf">
                                    <a href="category.php?id=847" target="_blank">裙子/洋装</a>
                                    <a href="category.php?id=850" target="_blank">羽绒服/棉服</a>
                                    <a href="category.php?id=846" target="_blank">外套</a>
                                    <a href="category.php?id=849" target="_blank">套装</a>
                                    <a href="category.php?id=841" target="_blank">衬衫/上衣</a>
                                    <a href="category.php?id=843" target="_blank">背心/t恤/卫衣</a>
                                    <a href="category.php?id=845" target="_blank">裤子/打底裤/PP裤</a>
                                    <a href="category.php?id=851" target="_blank">马夹/披风</a>
                                    <a href="category.php?id=1088" target="_blank">护手衣</a>
                                  </p>
                              </div>
            </div>
          </div>
        </div>
                 <div class="item  ">
          <div class="product">
            <h3 class="mylistbj4">
                    哺育喂养            </h3>
            <div class="product_classify">
                
                                                                <a href="category.php?id=887"  target="_blank">学饮杯</a>
                                                                                        <a href="category.php?id=888"  target="_blank">辅助工具</a>
                                                                                        <a href="category.php?id=881"  target="_blank">奶瓶</a>
                                                                                        <a href="category.php?id=894"  target="_blank">安抚奶嘴</a>
                                                                                        <a href="category.php?id=885"  target="_blank">餐具</a>
                                                                                        <a href="category.php?id=890"  target="_blank">消毒/加温</a>
                                                                                                                                                                                                                                        </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos4"> 
            
            <div class="cf">
              <div>
                                <h4><a href="category.php?id=887" target="_blank">学饮杯</a></h4>
                <p class="cf">
                                    <a href="category.php?id=933" target="_blank">奶嘴杯</a>
                                    <a href="category.php?id=940" target="_blank">鸭嘴杯</a>
                                    <a href="category.php?id=935" target="_blank">水壶</a>
                                    <a href="category.php?id=931" target="_blank">保温杯</a>
                                    <a href="category.php?id=943" target="_blank">配件</a>
                                    <a href="category.php?id=937" target="_blank">吸管杯</a>
                                    <a href="category.php?id=1077" target="_blank">喝水杯</a>
                                  </p>
                                <h4><a href="category.php?id=888" target="_blank">辅助工具</a></h4>
                <p class="cf">
                                    <a href="category.php?id=947" target="_blank">奶粉罐/盒</a>
                                    <a href="category.php?id=945" target="_blank">保温包</a>
                                    <a href="category.php?id=950" target="_blank">奶瓶刷/奶嘴刷</a>
                                    <a href="category.php?id=951" target="_blank">奶瓶夹</a>
                                    <a href="category.php?id=953" target="_blank">辅助配件</a>
                                  </p>
                                <h4><a href="category.php?id=881" target="_blank">奶瓶</a></h4>
                <p class="cf">
                                    <a href="category.php?id=904" target="_blank">PP奶瓶</a>
                                    <a href="category.php?id=902" target="_blank">PPSU奶瓶</a>
                                    <a href="category.php?id=901" target="_blank">PES奶瓶</a>
                                    <a href="category.php?id=896" target="_blank">玻璃奶瓶</a>
                                    <a href="category.php?id=906" target="_blank">硅胶奶瓶</a>
                                    <a href="category.php?id=908" target="_blank">奶瓶配件</a>
                                    <a href="category.php?id=1085" target="_blank">奶瓶清洗</a>
                                  </p>
                                <h4><a href="category.php?id=894" target="_blank">安抚奶嘴</a></h4>
                <p class="cf">
                                    <a href="category.php?id=962" target="_blank">硅胶安抚奶嘴</a>
                                    <a href="category.php?id=963" target="_blank">乳胶安抚奶嘴</a>
                                  </p>
                                <h4><a href="category.php?id=885" target="_blank">餐具</a></h4>
                <p class="cf">
                                    <a href="category.php?id=925" target="_blank">碗</a>
                                    <a href="category.php?id=929" target="_blank">餐具套装</a>
                                    <a href="category.php?id=1079" target="_blank">筷子</a>
                                    <a href="category.php?id=1080" target="_blank">叉</a>
                                    <a href="category.php?id=1081" target="_blank">勺</a>
                                    <a href="category.php?id=1082" target="_blank">其他</a>
                                  </p>
                                <h4><a href="category.php?id=890" target="_blank">消毒/加温</a></h4>
                <p class="cf">
                                    <a href="category.php?id=954" target="_blank">温（暖）奶器</a>
                                    <a href="category.php?id=955" target="_blank">消毒锅</a>
                                    <a href="category.php?id=957" target="_blank">消毒盒</a>
                                  </p>
                                <h4><a href="category.php?id=883" target="_blank">奶嘴</a></h4>
                <p class="cf">
                                    <a href="category.php?id=914" target="_blank">慢流量奶嘴</a>
                                    <a href="category.php?id=912" target="_blank">中流量奶嘴</a>
                                    <a href="category.php?id=910" target="_blank">快流量奶嘴</a>
                                    <a href="category.php?id=920" target="_blank">果汁奶嘴</a>
                                  </p>
                                <h4><a href="category.php?id=892" target="_blank">辅食喂养与制作</a></h4>
                <p class="cf">
                                    <a href="category.php?id=961" target="_blank">研磨盒/组</a>
                                    <a href="category.php?id=959" target="_blank">手动</a>
                                    <a href="category.php?id=958" target="_blank">电动</a>
                                    <a href="category.php?id=960" target="_blank">多功能</a>
                                  </p>
                                <h4><a href="category.php?id=1072" target="_blank">牙胶/吮食器</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1073" target="_blank">牙胶</a>
                                    <a href="category.php?id=1074" target="_blank">吮食器</a>
                                  </p>
                                <h4><a href="category.php?id=1078" target="_blank">婴儿礼盒</a></h4>
                <p class="cf">
                                  </p>
                              </div>
            </div>
          </div>
        </div>
                 <div class="item  ">
          <div class="product">
            <h3 class="mylistbj5">
                    车床寝具            </h3>
            <div class="product_classify">
                
                                                                <a href="category.php?id=978"  target="_blank">架类</a>
                                                                                        <a href="category.php?id=653"  target="_blank">寝具</a>
                                                                                        <a href="category.php?id=980"  target="_blank">收纳类</a>
                                                                                        <a href="category.php?id=685"  target="_blank">婴儿床</a>
                                                                                        <a href="category.php?id=811"  target="_blank">配件及其他</a>
                                                        </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos5"> 
            
            <div class="cf">
              <div>
                                <h4><a href="category.php?id=978" target="_blank">架类</a></h4>
                <p class="cf">
                                    <a href="category.php?id=995" target="_blank">衣帽架</a>
                                  </p>
                                <h4><a href="category.php?id=653" target="_blank">寝具</a></h4>
                <p class="cf">
                                    <a href="category.php?id=677" target="_blank">睡袋</a>
                                    <a href="category.php?id=681" target="_blank">礼盒</a>
                                    <a href="category.php?id=675" target="_blank">包巾/抱垫/抱毯</a>
                                    <a href="category.php?id=682" target="_blank">凉席蚊帐</a>
                                    <a href="category.php?id=679" target="_blank">毛毯</a>
                                    <a href="category.php?id=656" target="_blank">被子</a>
                                    <a href="category.php?id=654" target="_blank">婴儿枕</a>
                                    <a href="category.php?id=661" target="_blank">床垫</a>
                                  </p>
                                <h4><a href="category.php?id=980" target="_blank">收纳类</a></h4>
                <p class="cf">
                                    <a href="category.php?id=1006" target="_blank">收纳盒</a>
                                    <a href="category.php?id=1003" target="_blank">收纳袋</a>
                                  </p>
                                <h4><a href="category.php?id=685" target="_blank">婴儿床</a></h4>
                <p class="cf">
                                    <a href="category.php?id=688" target="_blank">标准经济型婴儿床</a>
                                  </p>
                                <h4><a href="category.php?id=811" target="_blank">配件及其他</a></h4>
                <p class="cf">
                                    <a href="category.php?id=817" target="_blank">床类配件</a>
                                    <a href="category.php?id=814" target="_blank">车类配件</a>
                                  </p>
                              </div>
            </div>
          </div>
        </div>
                 <div class="item  ">
          <div class="product">
            <h3 class="mylistbj6">
                    玩具图书            </h3>
            <div class="product_classify">
                
                                                                <a href="category.php?id=903"  target="_blank">动手能力</a>
                                                                                        <a href="category.php?id=880"  target="_blank">身体运动机能</a>
                                                                                        <a href="category.php?id=893"  target="_blank">认知/语言能力</a>
                                                                                        <a href="category.php?id=941"  target="_blank">图书</a>
                                                                                        <a href="category.php?id=930"  target="_blank">学习/音乐/绘画</a>
                                                                                        <a href="category.php?id=832"  target="_blank">早期感官发育</a>
                                                                                                    </div>
            <s style="display:block;"></s> 
          </div>
            
          <div class="product-wrap pos6"> 
            
            <div class="cf">
              <div>
                                <h4><a href="category.php?id=903" target="_blank">动手能力</a></h4>
                <p class="cf">
                                    <a href="category.php?id=916" target="_blank">拼图/拼板</a>
                                    <a href="category.php?id=907" target="_blank">敲打类</a>
                                    <a href="category.php?id=905" target="_blank">积木类</a>
                                    <a href="category.php?id=917" target="_blank">套塔类/叠叠乐</a>
                                    <a href="category.php?id=915" target="_blank">拆装类</a>
                                  </p>
                                <h4><a href="category.php?id=880" target="_blank">身体运动机能</a></h4>
                <p class="cf">
                                    <a href="category.php?id=882" target="_blank">游泳/洗澡/沙滩</a>
                                    <a href="category.php?id=886" target="_blank">健身架</a>
                                    <a href="category.php?id=889" target="_blank">推拉学步/学步车</a>
                                    <a href="category.php?id=891" target="_blank">户外/运动</a>
                                  </p>
                                <h4><a href="category.php?id=893" target="_blank">认知/语言能力</a></h4>
                <p class="cf">
                                    <a href="category.php?id=895" target="_blank">早教系列</a>
                                    <a href="category.php?id=900" target="_blank">数字形状配对</a>
                                  </p>
                                <h4><a href="category.php?id=941" target="_blank">图书</a></h4>
                <p class="cf">
                                    <a href="category.php?id=952" target="_blank">游戏/手工</a>
                                    <a href="category.php?id=944" target="_blank">幼儿启蒙</a>
                                    <a href="category.php?id=949" target="_blank">漫画/绘本</a>
                                  </p>
                                <h4><a href="category.php?id=930" target="_blank">学习/音乐/绘画</a></h4>
                <p class="cf">
                                    <a href="category.php?id=934" target="_blank">乐器</a>
                                    <a href="category.php?id=932" target="_blank">绘画</a>
                                  </p>
                                <h4><a href="category.php?id=832" target="_blank">早期感官发育</a></h4>
                <p class="cf">
                                    <a href="category.php?id=874" target="_blank">床铃</a>
                                    <a href="category.php?id=878" target="_blank">宝宝家居/摇椅/秋千</a>
                                    <a href="category.php?id=876" target="_blank">球类</a>
                                    <a href="category.php?id=877" target="_blank">不倒翁</a>
                                    <a href="category.php?id=869" target="_blank">摇铃</a>
                                  </p>
                                <h4><a href="category.php?id=919" target="_blank">逻辑思维/想象力</a></h4>
                <p class="cf">
                                    <a href="category.php?id=928" target="_blank">电子类</a>
                                    <a href="category.php?id=924" target="_blank">电动类</a>
                                    <a href="category.php?id=921" target="_blank">模型类</a>
                                    <a href="category.php?id=922" target="_blank">情景模拟</a>
                                  </p>
                              </div>
            </div>
          </div>
        </div>
             </div>
    </div>
    <ul class="nav-list cf nav-list-currenOrNot">
        <li><a href="index.php">首 页</a></li>
                 <li><a href="vip_goods.html" target="_blank" >VIP专区</a></li>
                <li><a href="exchange.html" target="_blank" >积分商城</a></li>
                <li><a href="category-894.html" target="_blank" >安抚奶嘴</a></li>
                <li><a href="category-793.html" target="_blank" >纸尿裤/防尿用品</a></li>
                <li><a href="category-828.html" target="_blank" >玩具图书</a></li>
                <li><a href="category-883.html" target="_blank" >奶嘴</a></li>
                <li><a href="category-881.html" target="_blank" >奶瓶</a></li>
                <li><a href="category-981.html" target="_blank" >外出用品</a></li>
                <li><a href="category-887.html" target="_blank" >学饮杯</a></li>
                <li><a href="category-653.html" target="_blank" >寝具</a></li>
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
    <div class="item_site">
        <ul><li  class="category_site"><a href=".">首 页</a>&nbsp;&gt;&nbsp;<a href="category.php?id=879">哺育喂养</a>&nbsp;&gt;&nbsp;<a href="category.php?id=881">奶瓶</a>&nbsp;&gt;&nbsp;<a href="category.php?id=902">PPSU奶瓶</a>&nbsp;&gt;<span>日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001</span><li><li class="category_right_1_tote">共件宝贝</li></ul>          
        </div>
<form action="javascript:addToCart(1283)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
    <div class="main middle over item_bj">
      <div class="item_left">
            
 <div id="preview">
          <div class=jqzoom>
			  
				<img  id='bigImg' width='350' height='350' src="images/201410/goods_img/1283_P_1413312721345.jpg" jqimg="images/201409/source_img/1283_P_1411327340547.jpg">  			
			          </div>
          <div id='spec'>
			  <div id='specLeft' class="control specLeftT"></div>
			  <div id='specList'>
				<ul class='listImg' >
				     
											 <li><img src="images/201412/thumb_img/1283_thumb_P_1417557279797.jpg" src_H="images/201410/goods_img/1283_P_1413312721345.jpg" src_D="images/201409/source_img/1283_P_1411327340547.jpg">  </li>
											 <li><img src="images/201412/thumb_img/1283_thumb_P_1417557280811.jpg" src_H="images/201410/goods_img/1283_P_1413312722470.jpg" src_D="images/201409/source_img/1283_P_1411327341149.jpg">  </li>
					 
									</ul>
			  </div>
			  <div id='specRight' class="control specRightT"></div>
          </div>
  </div>
  
    <div class="item_collect">
    	<a class="a" href="javascript:collect('1283')">收藏该商品</a>
    
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
  
        </div>
      <div class="item_right">
          <h1>日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001</h1>
            <div class="tag">
              <!--
    <span class="tag_1">{rank_name}</span>
    -->
    <span class="tag_2" id="current_price">
      ￥ 124.2            </span>
    <span class="tag_3">原价：￥158.0</span>
                  </div>
                        <dl class="message">
              <dt>优惠信息：</dt>
                <dd>上海、北京、广东、江苏、浙江、安徽、天津、河北、重庆、湖北、四川、福建、山东单笔订单"满99包邮"，全国其他区域单笔订单"满199包邮"。 详情请参看<a title="配送范围及运费" style="color:#f13d6d;font-size:14px;" href="article-16.html">《配送范围及运费》</a></dd>
            </dl>
                                            
             
       
                    <dl id="tasteList" class="standard_1">
              <dt id="tasteAttrName">规格</dt>
                                        <dd  onclick="selPara(this,'spec_90','spec_value_22311'); changePrice();" 
            id="22311"  class="spec_90 options" >
            150ml                      <input id="spec_value_22311"  style="display:none;"  type="radio"  name="spec_90" 
            value="22311" checked />
                    </dd>
                                        <dd  onclick="selPara(this,'spec_90','spec_value_29870'); changePrice();" 
            id="29870" class="spec_90" >
            240ml                      <input id="spec_value_29870"  style="display:none;"  type="radio"  name="spec_90" 
            value="29870"  />
                    </dd>
                                </dl>
                  
            <input type="hidden" name="spec_list" value="1" />
             
            
            
            <dl class="standard_3">
                <dt>购买数量：</dt>
                <dd class="standard_3_2" data-sel="num" id="computing_item">
                 <input  value="1" type=text class="num" name="number" id="product_amount" />
         <div class="standard_3_1">
           <a onClick="funnum('up')"></a>
           <a onClick="funnum('down')"></a>
         </div>
<script type="text/javascript">
var goods_id = 1283;
var goodsattr_style = 1;
var gmt_end_time = 0;
var day = "天";
var hour = "小时";
var minute = "分钟";
var second = "秒";
var end = "结束";
var goodsId = 1283;
var now_time = 1425258272;
onload = function(){
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}
/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
 
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;
  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}
/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;
    $('#product_num').html( '库存' + res.stock + '件');
  document.getElementById('current_price').innerHTML = '¥'+res.result;
  }
}
</script> 
    
</dd>
  <dd id='product_num'>库存1000件</dd>
            </dl>
            <div class="item_buy">
        
                     
		   <script type="text/javascript">
				   function add_mark(val)
				   {
				   $('#mark_info').val(val);
			            }
				</script>
			<input type="hidden" value='null' id="mark_info"/>	      
              <a href="javascript:void(0)" onclick="add_mark(1);addToCart(1283);" >
    <input class="item_buy_a" name="" type="button" />
    </a>
                <a href="javascript:void(0)" onclick="add_mark(0);addToCart(1283);">
    <input class="item_buy_b" name="" type="button" />
    </a>
                </div>
        </div>
    </div>
</form>
 <link href="style/css/attr_mask.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="style/js/package_buy.js"></script>
 <div id="fixedLayer" ></div>
  <div id="attrSelect" style="display: none;">
  <div id="TB_window" style="margin-left: -465px; width: 1090px; margin-top: -220px; display: block;">
  <div id="TB_ajaxContent" class="TB_modal">
  
    <br/>
          <h1 id="attrSelectGoodName"  data-good-id=''></h1>
          <br/>
          <div class="tag">
                <!--
            <span class="tag_1">{rank_name}</span>
            -->
            <span class="tag_2" id="attrSelectGoodPrice">¥0.00</span>
            <span class="tag_3" id="attrSelectMarketPrice">原价：￥0.00</span>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;库存<b style="color:red" id="attrSelectGoodNum"></b>件
                    </div>  
              <div id="packageAttrList"></div>    
            <br/>
            <p>
            <a class="select_c" href="javascript:void(0)" onclick="confirm_attr_mask();elem_hide('attrSelect');">确定</a>
              
            <a class="select_d" href="javascript:void(0)" onclick="elem_hide('attrSelect')">取消</a>
              
            </p>
    
  </div>
  </div>          
  </div>
<div class="dapeitaocan">
      <div class="dapeitaocan_title"><span>搭配套餐</span></div>
        <div class="dapeitaocan_main">
          <dl class="dapeitaocan_itself" id="good1283">
                      <dt class="xuanzhong" data-shop-price="124.2" data-good-id="1283" data-good-attr="">
              <a href="javascript:void(0)">
              <img src="images/201412/thumb_img/1283_thumb_G_1417567186206.jpg">
              <span><img width="20" height="20" src="style/images/hook.png"></span>
              </a>
            </dt>     
                        <dd>
              <a href="javascript:void(0)" class="show_full_name">日康防胀气宽口奶瓶(150ml.PPSU.弯口)RK-5002/(240ml)RK-5001</a>
              <div class="jiage_xz_1">
                <b>¥124.2</b>
                <input name="" type="button" value="修改属性" onclick="choose_attr('1283')"/>
              </div>
            </dd>
                    </dl>
                    <span class="dapeitaocan_jia">
                    </span>
                    <div class="dapeitaocan_box">
                    
                    <div class="lunbo-recommend_1">
    <div id="banner-slide_1" class="slide-pics_1">
      <div class="scrollable_1">
        <ul class="items_1">
                <li class="item_1"> 
        <dl class="dapeitaocan_itself" id="good217">
                      <dt class="related" data-shop-price="183.2" data-market-price="229.0" data-good-id="217" data-good-attr="">
              <a href="goods.php?id=217">
                <img src="images/201412/thumb_img/217_thumb_G_1417566366610.jpg">
                <span><img width="20" height="20" src="themes/yihaodian/images/hook.png"></span>
              </a>
            </dt>
                        <dd>
              <a class="show_full_name" href="goods.php?id=217">小白熊HL-0617恒温调奶器（蓝色）</a>
              <div class="jiage_xz">
                <b>¥183.2</b>
                <input name="" type="button" value="搭配" data-good-id="217"/>
              </div>
            </dd>
         </dl>
                    
                <span class="dapeitaocan_jia">
                    </span>   
                 <dl class="dapeitaocan_itself" id="good570">
                      <dt class="related" data-shop-price="8.9" data-market-price="9.9" data-good-id="570" data-good-attr="">
              <a href="goods.php?id=570">
                <img src="images/201412/thumb_img/570_thumb_G_1417566610781.jpg">
                <span><img width="20" height="20" src="themes/yihaodian/images/hook.png"></span>
              </a>
            </dt>
                        <dd>
              <a class="show_full_name" href="goods.php?id=570">日康正品 安抚奶嘴盒 防尘易携带婴儿童宝宝安抚奶嘴盒 RK-3387</a>
              <div class="jiage_xz">
                <b>¥8.9</b>
                <input name="" type="button" value="搭配" data-good-id="570"/>
              </div>
            </dd>
         </dl>
                    
                <span class="dapeitaocan_jia">
                    </span>   
                 <dl class="dapeitaocan_itself" id="good721">
                      <dt class="related" data-shop-price="30.5" data-market-price="33.9" data-good-id="721" data-good-attr="">
              <a href="goods.php?id=721">
                <img src="images/201412/thumb_img/721_thumb_G_1417566745704.jpg">
                <span><img width="20" height="20" src="themes/yihaodian/images/hook.png"></span>
              </a>
            </dt>
                        <dd>
              <a class="show_full_name" href="goods.php?id=721">日康海绵奶瓶刷奶嘴刷 RK-3513 海棉奶瓶刷清洗用品新生儿必备</a>
              <div class="jiage_xz">
                <b>¥30.5</b>
                <input name="" type="button" value="搭配" data-good-id="721"/>
              </div>
            </dd>
         </dl>
                    
                <span class="dapeitaocan_jia">
                    </span>   
                 <dl class="dapeitaocan_itself" id="good1120">
                      <dt class="related" data-shop-price="10.8" data-market-price="12.0" data-good-id="1120" data-good-attr="">
              <a href="goods.php?id=1120">
                <img src="images/201412/thumb_img/1120_thumb_G_1417567050842.jpg">
                <span><img width="20" height="20" src="themes/yihaodian/images/hook.png"></span>
              </a>
            </dt>
                        <dd>
              <a class="show_full_name" href="goods.php?id=1120">贝亲-宽口径奶瓶盖帽组BA78-BA81</a>
              <div class="jiage_xz">
                <b>¥10.8</b>
                <input name="" type="button" value="搭配" data-good-id="1120"/>
              </div>
            </dd>
         </dl>
                    
                <span class="dapeitaocan_jia">
                    </span>   
                 <dl class="dapeitaocan_itself" id="good1414">
                      <dt class="related" data-shop-price="34.2" data-market-price="38.0" data-good-id="1414" data-good-attr="">
              <a href="goods.php?id=1414">
                <img src="images/201412/thumb_img/1414_thumb_G_1417567309013.jpg">
                <span><img width="20" height="20" src="themes/yihaodian/images/hook.png"></span>
              </a>
            </dt>
                        <dd>
              <a class="show_full_name" href="goods.php?id=1414">贝亲-多功能吸管刷EA09</a>
              <div class="jiage_xz">
                <b>¥34.2</b>
                <input name="" type="button" value="搭配" data-good-id="1414"/>
              </div>
            </dd>
         </dl>
                    
              
          </li>
           </div>
      <div class="prev_1 prev-next_1 s-index-icon_1"> 上一张</div>
      <div class="next_1 prev-next_1 s-index-icon_1"> 下一张</div>
    </div>
</div>
                    </div>
          <span class="dapeitaocan_deng">
                    </span>
          <div class="dapeitaocan_zongjia">
                   <span class="zongjia_4">购买<input type="text" id="packageBuyNum" data-discount="0.9" name="" value="1" onblur="reCaculatePackagePrice()">套</span>
                      <span class="zongjia_1">套餐价：<b id="package_price">¥124.2</b></span>
                        <span class="zongjia_2">原总价：<b id="initial_price">¥124.2</b></span>
            <span class="zongjia_1">优惠金额：<b id="discount_price">¥0.00</b></span>  
            <span class="zongjia_3"><input type="button" value="立即购买" name=""  onclick="add_mark(1);addToCart_packageBuy();"></span>
                       <span class="zongjia_5"><input type="button" value="加入购物车" name="" onclick="add_mark(0);addToCart_packageBuy();"></span>
            
          </div>
        </div>
    
    
    </div>
  
    <div class="main middle over item_pt20">
    <div class="main_1_right_1 item_2_left">
                  <h3>购买过该商品的人还购买过</h3>
                  
                   
      </div>
      <div class="item_2_right">
        <div id=item_con>
  <div id=item_tags>
    <ul>
      <li class=zzjs_net><a onClick="select_zzjs('wwwzzjsnet0',this)" href="javascript:void(0)">商品详情</a> </li>
      <li>
          <a onClick="select_zzjs('wwwzzjsnet1',this)" href="javascript:void(0)">
            购买评价(0)
          </a> 
      </li>                        
      <li> 
          <a onClick="select_zzjs('wwwzzjsnet2',this)" href="javascript:void(0)">
            销售记录(0)
          </a> 
      </li>
      <li><a onClick="select_zzjs('wwwzzjsnet3',this)" href="javascript:void(0)">服务承诺</a> </li>
    </ul>
    </div>
<div id=wwwzzjsnet>
    <div class="wwwzzjsnet zzjs_net" id=wwwzzjsnet0>
         
                    <div class="description_1" style="display:none">
            <dt>规格参数 </dt>
                        <span>：</span>
                        
          </div>
           
          
  <div class="item_2_right_img"><p><img src="/images/upload/fckautosave/201409/1411355992-0.jpg" alt="" /><img src="/images/upload/fckautosave/201409/1411355992-1.jpg" alt="" /><img src="/images/upload/fckautosave/201409/1411355993-2.jpg" alt="" /></p>  <p><br class="Apple-interchange-newline" />  <img src="/images/upload/fckautosave/201409/1411355993-3.jpg" alt="" /><img src="/images/upload/fckautosave/201409/1411355993-4.jpg" alt="" /></p></div>
    </div>
    <div class=wwwzzjsnet id=wwwzzjsnet1>
    
      <div class="description_2">
          <div class="description_2_a"><span>100%</span>&nbsp;&nbsp;<b>用户满意</b><br />共有0人参与评价
            </div>
            <div class="description_2_b">
              <dl>
                  <dt>满意</dt>
                    <div class="a"><p  style="width:100%;"></p></div>
                    <dd>100%</dd>
                </dl>
                <dl>
                  <dt>一般</dt>
                    <div class="b"><p style="width:0%;"></p></div>
                    <dd>0%</dd>
                </dl>
                <dl>
                  <dt>不满意</dt>
                    <div class="c"><p style="width:0%;"></p></div>
                    <dd>0%</dd>
                </dl>
            </div>
        </div>
     
          
          554fcae493e564ee0dc75bdf2ebf94cacomments|a:3:{s:4:"name";s:8:"comments";s:4:"type";i:0;s:2:"id";i:1283;}554fcae493e564ee0dc75bdf2ebf94ca    
    </div>
    <div class='wwwzzjsnet' id='wwwzzjsnet2'>
      <div class="description_1">
        30天内：交易中0笔，交易成功0笔！
      </div>
      <div id="ECS_BOUGHT">
          554fcae493e564ee0dc75bdf2ebf94casale_history|a:3:{s:4:"name";s:12:"sale_history";s:4:"type";i:0;s:2:"id";i:1283;}554fcae493e564ee0dc75bdf2ebf94ca      </div>
    </div>
    <div class=wwwzzjsnet id=wwwzzjsnet3>
      <p><span style="font-size: medium;"><span style="margin: 0px; padding: 0px; color: rgb(245, 90, 110); font-family: 微软雅黑,sans-serif; display: block; line-height: 40px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; background-color: rgb(255, 255, 255);">服务承诺</span></span><span style="font-size: medium;"><span style="color: rgb(85, 85, 85); font-family: Simsun; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 36px; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; background-color: rgb(255, 255, 255); display: inline ! important; float: none;">网站所售产品均为厂商正品，如有任何问题可与我们客服人员联系，我们会在第一时间跟您沟通处理。我们将争取以最低的价格、最优的服务来满足您最大的需求。 开箱验货：签收时在付款后与配送人员当面核对：商品及配件、应付金额、商品数量及发货清单、发票（如有）、赠品（如有）等；如存在包装破损、商品错误、商品短缺、商品 存在质量问题等影响签收的因素，请您可以拒收全部或部分商品，相关的赠品，配件或捆绑商品应一起当场拒收；为了保护您的权益，建议您尽量不要委托他人代为签收；如由他 人代为签收商品而没有在配送人员在场的情况下验货，则视为您所订购商品 的包装无任何问题。</span></span><span style="font-size: medium;"><span style="margin: 0px; padding: 0px; color: rgb(245, 90, 110); font-family: 微软雅黑,sans-serif; display: block; line-height: 40px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; background-color: rgb(255, 255, 255);">温馨提示</span></span><span style="font-size: medium;"><span style="color: rgb(85, 85, 85); font-family: Simsun; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 36px; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; background-color: rgb(255, 255, 255); display: inline ! important; float: none;">由于部分商品包装更换较为频繁，因此您收到的货品有可能与图片不完全一致，请您以收到的商品实物为准，同时我们会尽量做到及时更新，由此给您带来不便多多谅解，谢谢！</span></span></p>    </div>
    </div>
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
        <span><a href="javascript:ajax_change_goods('1283');"><img src="themes/yihaodian/images/main_2_left_title_b.png" width="65" height="20" /></a></span>
    </ul>
    <div class="item_2_right_popup_3" >
		<br/>&nbsp;&nbsp;&nbsp;<b>暂无商品</b>
	    </div>
</div></body>
</html>
