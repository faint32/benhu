lastScrollY=0;
function heartBeat(){ 
	var diffY;
	if (document.documentElement && document.documentElement.scrollTop)
	    diffY = document.documentElement.scrollTop;
	else if (document.body)
	    diffY = document.body.scrollTop
	else
	    {/*Netscape stuff*/}
		percent=.1*(diffY-lastScrollY); 
		if(percent>0)percent=Math.ceil(percent); 
		else percent=Math.floor(percent); 
		document.getElementById("lovexin12").style.top=parseInt(document.getElementById("lovexin12").style.top)+percent+"px";
		document.getElementById("lovexin14").style.top=parseInt(document.getElementById("lovexin12").style.top)+percent+"px";
		lastScrollY=lastScrollY+percent; 
		}
$(function(){
	  $('a').css('text-decoration','none').css('color','#646464'); 

	  $('a').hover(function(){
	  	$(this).css('color','#24a0f0');
	  },function(){
	  	$(this).css('color','#646464');
	  });
    
	  jQuery.getScript("http://www.benhu.com/adOutput/ad.php?act=popUp", 
        function(){  

           $('#image0').attr('src','http://www.benhu.com/' + goods[0].goods_img); 
           $('#image0').attr('alt', goods[0].goods_name); 
           $('.ad0').attr('href', 'http://www.benhu.com/' + goods[0].url);  
           $('#lovexin12 span a').html(goods[0].goods_name);

           $('#image1').attr('src','http://www.benhu.com/' + goods[1].goods_img);
           $('#image1').attr('alt', goods[1].goods_name);
           $('.ad1').attr('href', 'http://www.benhu.com/' + goods[1].url);   
           $('#lovexin14 span a').html(goods[1].goods_name);
        });     
});
  	var suspendcode12="<div  id=\"lovexin12\" style='left:22px;POSITION:absolute;TOP:69px;'><a class='ad0'  href='JavaScript:void(0)' target='_blank'><img id='image0' style='width:200px;height:200px;' alt='' border=0 src=''><br/></a> <span><a style='position:absolute;width: 115px;text-align: center;height:40px; overflow: hidden;' class='ad0' href=''></a></span><a href=JavaScript:; style='float: right;' onclick=\"lovexin12.style.visibility='hidden'\"><img border=0 src='http://www.benhu.com/adOutput/template/popUp/inc/close.gif'></a></div>"; 
    var suspendcode14="<div id=\"lovexin14\" style='right:22px;POSITION:absolute;TOP:69px;'><a class='ad1'  href='JavaScript:void(0)' target='_blank'><img id='image1'  style='width:200px;height:200px;'  border=0 src=''><br/></a> <span><a style='position:absolute;width: 115px;text-align: center;height:40px; overflow: hidden;' class='ad1' href=''></a></span><a href=JavaScript:; style='float: right;' onclick=\"lovexin14.style.display = 'none'\"><img border=0 src='http://www.benhu.com/adOutput/template/popUp/inc/close.gif'></a></div>";  

 	document.write(suspendcode12); 
	document.write(suspendcode14); 
	window.setInterval("heartBeat()",1);  