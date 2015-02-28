//star
$(document).ready(function(){
    var stepW = 24;
    var description = new Array("不满意，需要再努力！","还行，可以接受的范围！","一般，还过得去吧","很好，是我想要的东西","太完美了，还会再来买!");
	
    var star_lists = $('.star');
    var descriptionTemp;
    $(".showb").css("width",0);
	
	
	star_lists.each(function(index){
	   var stars = $(this).children("li");
	
		stars.each(function(i){
			$(stars[i]).click(function(e){
				var n = i+1;
				
				var showb="#showb"+index.toString();
				$(showb).css({"width":stepW*n});
				
				var comment_rate="#comment_rate"+index.toString();
				
				$(comment_rate).val(n);   //记录评分的值  chen 0903
				descriptionTemp = description[i];
				$(this).find('a').blur();
				return stopDefault(e);
				return descriptionTemp;
			});
		});
		
	    stars.each(function(i){
			var descript="#description"+index.toString();
			
			$(stars[i]).hover(
				function(){
					$(descript).text(description[i]);
				},
				function(){
					if(descriptionTemp != null)
						$(descript).text(descriptionTemp);
					else 
						$(descript).text(" ");
				}
			);
        });
	});
});
function stopDefault(e){
    if(e && e.preventDefault)
           e.preventDefault();
    else
           window.event.returnValue = false;
    return false;
};
