$(function(){
  //  addBigrenderInfoToTextareaTag()
	//window.onscroll()
})

function addBigrenderInfoToTextareaTag()
{
	 $('textarea').each(function(index){
			if(!$(this).hasClass('bigrender') && !$(this).hasClass('loaded'))
			{
				$(this).attr('id', 'bigrender' + index)
				$(this).addClass('bigrender')
			}	
	})
}

function setHtml(index)
{
	var $textarea = $(index)
	if( $textarea.html() == "")
	{
	   
	   return;
	}
   var html = HTMLDeCode($textarea.html())

   $textarea.parent().html(html)	
}
   function    HTMLDeCode(str)  
    {  
          var    s    =    "";  
          if    (str.length    ==    0)    return    "";  
         // s    =    str.replace(/&gt;/g,    "&");  
          s    =    str.replace(/&lt;/g,        " <");  
          s    =    s.replace(/&gt;/g,        ">");  
          s    =    s.replace(/&nbsp;/g,        "    ");  
          s    =    s.replace(/'/g,      "\'");  
          s    =    s.replace(/&quot;/g,      "\"");  
          s    =    s.replace(/ <br>/g,      "\n");  
          return    s;  
    }  

// window.onscroll = function () {
        function bigrender()
        {
        		$('.bigrender').each(function(index){

        			if($(this).attr('sureToReander') != 'no')
        			{
    				   var $textarea = $(this)
					   if( $textarea.hasClass("bigrender") )
					   {	
							 var t = document.documentElement.clientHeight + (document.documentElement.scrollTop || document.body.scrollTop);

							var h = $textarea.offset().top

							if (h < t) {
									$textarea.removeClass('bigrender')
									$textarea.addClass('loaded')
									var id = $textarea.attr('id')
									// console.log(id)
									setTimeout("setHtml(" + id + ")",500)	
							}
					   }
        			}
					
			   })
        }
// }
     



      
