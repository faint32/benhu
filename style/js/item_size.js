var tds = document.getElementById('options').getElementsByTagName('li');
   window.onload = function(){
    for( var i=0; i<tds.length; i++ ){
     tds[i].onclick = function(){
      tdonclick(this);
     }
    }
   }
   function tdonclick(obj){
    for( var o=0; o<tds.length; o++ ){
     if( tds[o] == obj ){
      tds[o].className = 'tdcolor';
     }
     else{
      tds[o].className = '';
     }
    }
   }