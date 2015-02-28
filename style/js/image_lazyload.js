$(function(){
	//console.profile()
	addBigrenderInfoToTextareaTag()
    addLazyLoadInfoToImgTag()
	window.onscroll()
	//console.profileEnd()
})

function addLazyLoadInfoToImgTag()
{
	 $('img').each(function(index){
		if(index >= 10)
		{
			if(!$(this).hasClass('lazyload') && !$(this).hasClass('loaded'))
			{
				var src = $(this).attr('src')
				
				$(this).attr('data-lazyload', src)
				$(this).attr('src','') //
				
				$(this).attr('id', 'lazyloadImage' + index)
				$(this).addClass('lazyload')
			}
		}
	})
}

function setImg(index)
{
	var $image = $(index)
	if(typeof( $image.attr("data-lazyload") ) == "undefined")
	{
	   
	   return;
	}
	var src = $image.attr('data-lazyload')
	$image.attr('src',src)
	$image.removeAttr('data-lazyload')
	$image.removeAttr('id')
}

        window.onscroll = function () {
        	 bigrender()
			 $('.lazyload').each(function(index){
					var $image = $(this)
				   if( $image.hasClass("lazyload") )
				   {	
						 var t = document.documentElement.clientHeight + (document.documentElement.scrollTop || document.body.scrollTop);
						var h = $image.offset().top
					
						if (h < t) {
								$image.removeClass('lazyload')
								$image.addClass('loaded')
								var id = $image.attr('id')
								setTimeout("setImg(" + id + ")",500)	
						}
				   }
			   })
        };



      
