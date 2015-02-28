function select_zzjs(showContent,selfObj){
var tag = document.getElementById("group_tags").getElementsByTagName("li");
var taglength = tag.length;
for(i=0; i<taglength; i++){
tag[i].className = "";
}
selfObj.parentNode.className = "grouptitle_tab";
for(i=0; j=document.getElementById("group_tab_main"+i); i++){
j.style.display = "none";
}
document.getElementById(showContent).style.display = "block";
}

/*团购第二项滑动*/
function select_zzjs_a(showContent_a,selfObj_a){
var tag = document.getElementById("group_tags_a").getElementsByTagName("li");
var taglength = tag.length;
for(i=0; i<taglength; i++){
tag[i].className = "";
}
selfObj_a.parentNode.className = "grouptitle_tab_a";
for(i=0; j=document.getElementById("group_tab_main_a"+i); i++){
j.style.display = "none";
}
document.getElementById(showContent_a).style.display = "block";
}

/*团购第三项滑动*/

function select_zzjs_b(showContent_b,selfObj_b){
var tag = document.getElementById("group_tags_b").getElementsByTagName("li");
var taglength = tag.length;
for(i=0; i<taglength; i++){
tag[i].className = "";
}
selfObj_b.parentNode.className = "grouptitle_tab_b";
for(i=0; j=document.getElementById("group_tab_main_b"+i); i++){
j.style.display = "none";
}
document.getElementById(showContent_b).style.display = "block";
}

/*支付页滑动*/

function select_zzjs_pay(showContent_pay,selfObj_pay){
var tag = document.getElementById("pay_5_title").getElementsByTagName("li");
var taglength = tag.length;
for(i=0; i<taglength; i++){
tag[i].className = "";
}
selfObj_pay.parentNode.className = "pay_5_tab";
for(i=0; j=document.getElementById("pay_5_main"+i); i++){
j.style.display = "none";
}
document.getElementById(showContent_pay).style.display = "block";
}


