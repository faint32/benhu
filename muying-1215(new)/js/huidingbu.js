$(function(){
	//菜单隐藏展开
	var tabs_i=0
	$('.vtitle').mouseover(function(){
		var _self = $(this);
		var j = $('.vtitle').index(_self);
		if( tabs_i == j ) return false; tabs_i = j;
		$('.vtitle span').each(function(e){
			if(e==tabs_i){
				$('span',_self).removeClass('v01').addClass('v02');
			}else{
				$(this).removeClass('v02').addClass('v01');
			}
		});
		$('.vcon').slideUp().eq(tabs_i).slideDown();
	});
})