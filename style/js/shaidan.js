
		    $(document).ready(function(){
			$('.shaidan_pic li').each(function(index){
			    $(this).click(function(){
					if($(this).hasClass('current'))
					{				
					$('.current img').css('cursor',"url(http://www.benhu.com/style/cursor/zoom_in.png),url(http://www.benhu.com/style/cursor/zoom_in.cur),auto");
					 $(this).removeClass('current');
					  $('.shaidan_a').hide();
					}
					 else
				    {
					$('.current img').css('cursor',"url(http://www.benhu.com/style/cursor/zoom_in.png),url(http://www.benhu.com/style/cursor/zoom_in.cur),auto");
					  $('.current').removeClass('current');
					  
					  
					  $(this).addClass('current');
					  $('.current img').css('cursor',"url(http://www.benhu.com/style/cursor/zoom_out.png),url(http://www.benhu.com/style/cursor/zoom_out.cur),auto");
				      $('.shaidan_a img').attr('src',$('.current img').attr('src'));
				      $('.shaidan_a').show();
					}
				});
			});
			});
	