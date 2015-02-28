//left_nav_2.js
$(function() {
//商品分类
//判断 一级页面
    $('.all-goods .item').hover(function() {
        $(this).addClass('active').find('s').hide();
        $(this).find('.product-wrap').show();
        $(this).find('.product-wrap').parents('.all-goods').show();
    }, function() {
        $(this).removeClass('active').find('s').show();
        $(this).find('.product-wrap').hide();
        $(this).find('.product-wrap').parents('.all-goods').hide();
    });

});

//huandengpian.js
$(function() {
	var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
	var len = $("#focus ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明长条
	var btn = "<div class='btnBg'></div><div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span>" + (i+1) + "</span>";
	}
	btn += "</div>"
	$("#focus").append(btn);
	$("#focus .btnBg").css("opacity",0.5);
	
	//为数字按钮添加鼠标滑入事件，以显示相应的内容
	$("#focus .btn span").mouseenter(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");
	
	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	$("#focus ul").css("width",sWidth * (len + 1));
	
	//鼠标滑入某li中的某div里，调整其同辈div元素的透明度，由于li的背景为黑色，所以会有变暗的效果
	
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			if(index == len) { //如果索引值等于li元素个数，说明最后一张图播放完毕，接下来要显示第一张图，即调用showFirPic()，然后将索引值清零
				showFirPic();
				index = 0;
			} else { //如果索引值不等于li元素个数，按普通状态切换，调用showPics()
				showPics(index);
			}
			index++;
		},5000); //此5000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		$("#focus ul").stop(true,false).animate({"left":nowLeft},500); //通过animate()调整ul元素滚动到计算出的position
		$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
	}
	
	function showFirPic() { //最后一张图自动切换到第一张图时专用
		$("#focus ul").append($("#focus ul li:first").clone());
		var nowLeft = -len*sWidth; //通过li元素个数计算ul元素的left值，也就是最后一个li元素的右边
		$("#focus ul").stop(true,false).animate({"left":nowLeft},500,function() {
			//通过callback，在动画结束后把ul元素重新定位到起点，然后删除最后一个复制过去的元素
			$("#focus ul").css("left","0");
			$("#focus ul li:last").remove();
		}); 
		$("#focus .btn span").removeClass("on").eq(0).addClass("on"); //为第一个按钮添加选中的效果
	}
});

//mytab.js
$(function(){		
	//设计案例切换
	$('.title-list li').mouseover(function(){
		var liindex = $('.title-list li').index(this);
		$(this).addClass('on').siblings().removeClass('on');
		$('.tabproduct-wrap div.tabproduct').eq(liindex).fadeIn(150).siblings('div.tabproduct').hide();
		var liWidth = $('.title-list li').width();
		$('.mytab .title-list p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
	});
	
	//设计案例hover效果
	$('.tabproduct-wrap .tabproduct li').hover(function(){
		$(this).css("border-color","#f13d6d");
		$(this).find('p > a').css('color','#323232');
	},function(){
		$(this).css("border-color","#e6e6e6");
		$(this).find('p > a').css('color','#787878');
	});
	});



//right_tab.js
;(function($){
	
$.fn.tabso=function( options ){

	var opts=$.extend({},$.fn.tabso.defaults,options );
	
	return this.each(function(i){
		var _this=$(this);
		var $menus=_this.children( opts.menuChildSel );
		var $container=$( opts.cntSelect ).eq(i);
		
		if( !$container) return;
		
		if( opts.tabStyle=="move"||opts.tabStyle=="move-fade"||opts.tabStyle=="move-animate" ){
			var step=0;
			if( opts.direction=="left"){
				step=$container.children().children( opts.cntChildSel ).outerWidth(true);
			}else{
				step=$container.children().children( opts.cntChildSel ).outerHeight(true);
			}
		}
		
		if( opts.tabStyle=="move-animate" ){ var animateArgu=new Object();	}
			
		$menus[ opts.tabEvent]( function(){
			var index=$menus.index( $(this) );
			$( this).addClass( opts.onStyle )
				.siblings().removeClass( opts.onStyle );
			switch( opts.tabStyle ){
				case "fade":
					if( !($container.children( opts.cntChildSel ).eq( index ).is(":animated")) ){
						$container.children( opts.cntChildSel ).eq( index ).siblings().css( "display", "none")
							.end().stop( true, true ).fadeIn( opts.aniSpeed );
					}
					break;
				case "move":
					$container.children( opts.cntChildSel ).css(opts.direction,-step*index+"px");
					break;
				case "move-fade":
					if( $container.children( opts.cntChildSel ).css(opts.direction)==-step*index+"px" ) break;
					$container.children( opts.cntChildSel ).stop(true).css("opacity",0).css(opts.direction,-step*index+"px").animate( {"opacity":1},opts.aniSpeed );
					break;
				case "move-animate":
					animateArgu[opts.direction]=-step*index+"px";
					$container.children( opts.cntChildSel ).stop(true).animate( animateArgu,opts.aniSpeed,opts.aniMethod );
					break;
				default:
					$container.children( opts.cntChildSel ).eq( index ).css( "display", "block")
						.siblings().css( "display","none" );
			}
	
		});
		
		$menus.eq(0)[ opts.tabEvent ]();
		
	});
};	

$.fn.tabso.defaults={
	cntSelect : ".content_wrap",
	tabEvent : "mouseover",
	tabStyle : "normal",
	direction : "top",
	aniMethod : "swing",
	aniSpeed : "fast",
	onStyle : "current",
	menuChildSel : "*",
	cntChildSel : "*"
};

})(jQuery);

$(document).ready(function($){
	//淡隐淡现选项卡切换
	$("#fadetab").tabso({
		cntSelect:"#fadecon",
		tabEvent:"mouseover",
		tabStyle:"fade"
	});
});


//mytab_1.js

(function($){

    if(!$.omr){
        $.omr = new Object();
    };
    
    $.omr.mosaic = function(el, options){
    
        var base = this;
        
        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;
        
        // Add a reverse reference to the DOM object
        base.$el.data("omr.mosaic", base);
        
        base.init = function(){
            base.options = $.extend({},$.omr.mosaic.defaultOptions, options);
            
            base.load_box();
        };
        
        // Preload Images
        base.load_box = function(){
        	// Hide until window loaded, then fade in
			if (base.options.preload){
				$(base.options.backdrop, base.el).hide();
				$(base.options.overlay, base.el).hide();
			
				$(window).load(function(){
					// IE transparency fade fix
					if(base.options.options.animation == 'fade' && $(base.options.overlay, base.el).css('opacity') == 0 ) $(base.options.overlay, base.el).css('filter', 'alpha(opacity=0)');
					
					$(base.options.overlay, base.el).fadeIn(200, function(){
						$(base.options.backdrop, base.el).fadeIn(200);
					});
					
					base.allow_hover();
				});
			}else{
				$(base.options.backdrop, base.el).show();
				$(base.options.overlay , base.el).show();
				base.allow_hover();
			}
        };
        
        // Initialize hover animations
        base.allow_hover = function(){
        	// Select animation
			switch(base.options.animation){
			
				// Handle fade animations
				case 'fade':
					$(base.el).hover(function () {
			        	$(base.options.overlay, base.el).stop().fadeTo(base.options.speed, base.options.opacity);
			        },function () {
			        	$(base.options.overlay, base.el).stop().fadeTo(base.options.speed, 0);
			      	});
			      	
			    	break;
			    
			    // Handle slide animations
	      		case 'slide':
	      			// Grab default overlay x,y position
					startX = $(base.options.overlay, base.el).css(base.options.anchor_x) != 'auto' ? $(base.options.overlay, base.el).css(base.options.anchor_x) : '0px';
					startY = $(base.options.overlay, base.el).css(base.options.anchor_y) != 'auto' ? $(base.options.overlay, base.el).css(base.options.anchor_y) : '0px';;
	      			
			      	var hoverState = {};
			      	hoverState[base.options.anchor_x] = base.options.hover_x;
			      	hoverState[base.options.anchor_y] = base.options.hover_y;
			      	
			      	var endState = {};
			      	endState[base.options.anchor_x] = startX;
			      	endState[base.options.anchor_y] = startY;
			      	
					$(base.el).hover(function () {
			        	$(base.options.overlay, base.el).stop().animate(hoverState, base.options.speed);
			        },function () {
			        	$(base.options.overlay, base.el).stop().animate(endState, base.options.speed);
			      	});
			      	
			      	break;
			};
        };
        
        // Make it go!
        base.init();
    };
    
    $.omr.mosaic.defaultOptions = {
        animation	: 'fade',
        speed		: 150,
        opacity		: 1,
        preload		: 0,
        anchor_x	: 'left',
        anchor_y	: 'bottom',
        hover_x		: '0px',
        hover_y		: '0px',
        overlay  	: '.tabproduct_price_3',	//Mosaic overlay
		backdrop 	: '.mosaic-backdrop'	//Mosaic backdrop
    };
    
    $.fn.mosaic = function(options){
        return this.each(function(){
            (new $.omr.mosaic(this, options));
        });
    };
    
})(jQuery);

jQuery(function($){

    $('.mytab_hoverbox').mosaic({
        opacity		:	1			//Opacity for overlay (0-1)
    });

});



//index_down_hdm.js
function select_zzjs(showContent,selfObj){
var tag = document.getElementById("tags").getElementsByTagName("li");
var taglength = tag.length;
for(i=0; i<taglength; i++){
tag[i].className = "";
}
selfObj.parentNode.className = "zzjs_net";
for(i=0; j=document.getElementById("wwwzzjsnet"+i); i++){
j.style.display = "none";
}
document.getElementById(showContent).style.display = "block";
}

 idTest=document.getElementById('gotopbtn');
 idTest.onclick=function (){
  document.documentElement.scrollTop=0;
  sb();
  }
 window.onscroll=sb;
 function sb(){
  if(document.documentElement.scrollTop==0){
   idTest.style.display="none";
   }else{
    idTest.style.display="block";
    }
  }


  //top.js
  function a(x,y){
	l = $('.footer_2').offset().left;
	w = $('.footer_2').width();
	$('#tbox').css('left',(l + w + x) + 'px');
	$('#tbox').css('bottom',y + 'px');
}
function b(){
	h = $(window).height();
	t = $(document).scrollTop();
	if(t > h){
		$('#gotop').fadeIn('slow');
	}else{
		$('#gotop').fadeOut('slow');
	}
}
$(document).ready(function(e) {		
	a(50,10);//#tbox的div距浏览器底部和页面内容区域右侧的距离
	b();
	$('#gotop').click(function(){
		$(document).scrollTop(0);	
	})
});
$(window).resize(function(){
	a(50,10);//#tbox的div距浏览器底部和页面内容区域右侧的距离
});

$(window).scroll(function(e){
	b();		
})

//another_batch.js
function another_batch(ele_id, extra_info)
{

  if(extra_info[0] == 'index_babyGrowth')
  {
  var age = extra_info[1];
  var cat_id = extra_info[2];
  
    Ajax.call( 'index.php?act=babyGrowth', 'ele_id=' + ele_id + '&age_index=' + age + '&cat_id=' + cat_id, anotherBatch_callback , 'GET', 'json', true, true );
  }
}
function anotherBatch_callback(result)
{
var ele_id = result.ele_id
var json = result.goods
var html = ''
for(var i=0; i<json.length; i++) 
{ 
html += '<dl><dt><a target="_blank" href="'+json[i].url+'"><img width="178" height="178" src="'+json[i].goods_thumb+'"></a></dt><dd><a title="'+json[i].goods_name+'" target="_blank" href="goods.php?id='+json[i].goods_id+'">'+json[i].goods_name+'</a><span class="main_2_left_price1">￥'+json[i].shop_price+'</span><span class="main_2_left_price2">￥'+json[i].market_price+'</span></dd></dl>'
} 
$('#'+ele_id).html(html)
}