    var lanrenzhijia=document.getElementById("channel_hdp");
    var oInner=document.getElementById("channel_inner");
    var oLis=oInner.getElementsByTagName("li");
    var oleft=document.getElementById("channel_right");
    var oright=document.getElementById("channel_left");
    var step=0;
    var timer=null;
    function buttur(ele,obj){
    	window.clearTimeout(ele.timer);
    	var end=null;
    	for(direc in obj){
    		var direc1=direc.toLowerCase();
    		var strOffset="offset"+direc1.substr(0,1).toUpperCase()+direc1.substring(1).toLowerCase();
    		var target=obj[direc];
    		var nSpeed=(target-ele[strOffset])/10;
    		nSpeed=nSpeed>=0?Math.ceil(nSpeed):Math.floor(nSpeed);
    		ele.style[direc1]=ele[strOffset]+nSpeed+"px";
    		end+=nSpeed;
    	}
    	if(end)
    		if(typeof fnCallback=="function"){
    			fnCallback.call(ele);
    		}else{
            ele.timer=window.setTimeout(function(){buttur(ele,obj)},30);
    		}
    }
    var divs=document.createElement("div");
    divs.setAttribute("id","channel_nav");
    for(var i=0; i<oLis.length;i++){
        var oa=document.createElement("em");
        oa.innerHTML=i+1;
        divs.appendChild(oa);
    }
    lanrenzhijia.appendChild(divs);
    var btn=document.getElementById("channel_nav").getElementsByTagName("em");
    for(var i=0; i<btn.length; i++){
        btn[i].indx=i;
        btn[0].className="ehover";
        btn[i].onclick=function(){
            //window.clearTimeout(timer);
            for(var i=0; i<btn.length; i++){
                btn[i].className="";
                btn[this.indx].className="ehover";
            }
            buttur(oInner,{left:-oLis[0].offsetWidth*this.indx}); 
        }    
    }
    function autoMove(){
     	step++;
    	if(step<btn.length){
             for(var i=0; i<btn.length; i++){
                btn[i].className="";
                btn[step].className="ehover";
                buttur(oInner,{left:step*-1200});
            }           
    	 }else{ 
                step=btn.length-7;        
         }
     	timer=window.setTimeout(autoMove,3500);
    }
    autoMove(); 
    oleft.onclick=function(){
    	window.clearTimeout(timer);
    	step++;
    	if(step<btn.length){
             for(var i=0; i<btn.length; i++){
                btn[i].className="";
                btn[step].className="ehover";
                buttur(oInner,{left:step*-1200});
            }           
         }else{ 
                step=btn.length-7;        
         }
     }
    oright.onclick=function(){
    	window.clearTimeout(timer);
    	step--;
    	if(step<0){
             step=btn.length;
         }else{ 
            for(var i=0; i<btn.length; i++){
                btn[i].className="";
                btn[step].className="ehover";
                buttur(oInner,{left:step*-1200}); 
            }
         }
    }
     
   oInner.onmouseover=function(){window.clearTimeout(timer);}
   oInner.onmouseout=function(){timer=window.setTimeout(autoMove,3500);}
   oleft.onmouseover=function(){window.clearTimeout(timer);}
   oleft.onmouseout=function(){timer=window.setTimeout(autoMove,3500);}
   oright.onmouseover=function(){window.clearTimeout(timer);}
   oright.onmouseout=function(){timer=window.setTimeout(autoMove,3500);} 