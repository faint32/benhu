function select_zzjs(showContent,selfObj){
var tag = document.getElementById("item_tags").getElementsByTagName("li");
var taglength = tag.length;
for(i=0; i<taglength; i++){
tag[i].className = "";
}
selfObj.parentNode.className = "zzjs_net";
for(i=0; j=document.getElementById("wwwzzjsnet"+i); i++){
j.style.display = "none";
}
document.getElementById(showContent).style.display = "block";
}

