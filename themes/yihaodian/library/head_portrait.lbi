

<style type="text/css">
  *{
    margin:0px;
    padding:0px;
  }
  .zhezhao{

    width:100%;
    height:100%;
    background-color:#000;
    filter:alpha(opacity=50);
    -moz-opacity:0.5;
    opacity:0.5;
    position:absolute;
    left:0px;
    top:0px;
    display:none;
    z-index:1000;
  }
  .login{
    width:280px;
    height:180px;
    position:absolute;
    top:200px;
    left:30%;
    background-color:#fbfbfb;
    border:solid 1px #e1e1e1;
    margin-left:-140px;
    display:none;
    z-index:1500;
  }
  .content{
    margin-top:50px;
    color:red;
    line-height:200px;
    height:200px;
    text-align:center;
  }
</style>
<script type="text/javascript">
  window.onload=function(){
    var zhezhao=document.getElementById("zhezhao");
    var login=document.getElementById("login");
    var head_portrait=document.getElementById("head_portrait");
    var btclose=document.getElementById("btclose");
   
    head_portrait.onclick=function(){

      var h = $(document).height();  //浏览器高度
      //var h=document.documentElement.clientHeight;//可见区域高度
      zhezhao.style.height = h + "px";
      zhezhao.style.display="block";
      login.style.display="block";
    }
    btclose.onclick=function(){
      zhezhao.style.display="none";
      login.style.display="none"; 
    }
  }
</script>

<div class="zhezhao" id="zhezhao"></div>
  <div class="login" id="login"><button id="btclose">点击关闭</button>