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
		$(this).css("border-color","#ffa5b0");
		$(this).find('p > a').css('color','#323232');
	},function(){
		$(this).css("border-color","#e6e6e6");
		$(this).find('p > a').css('color','#787878');
	});
	});


