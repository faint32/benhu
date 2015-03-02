$(function(){		
	//设计案例切换
	$('.title-list li').mouseover(function(){
		var liindex = $('.title-list li').index(this);
		$(this).addClass('on').siblings().removeClass('on');
		$('.register_box div.register_main').eq(liindex).fadeIn(150).siblings('div.register_main').hide();
		var liWidth = $('.title-list li').width();
		$('.register .title-list p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
	});
	

	});


