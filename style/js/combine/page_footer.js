/**soufengqin_nav.js**/
function navList(id) {
    var $obj = $("#nav_dot"), $item = $("#J_nav_" + id);
    $item.addClass("on").parent().removeClass("none").parent().addClass("selected");
    $obj.find("h4").hover(function () {
        $(this).addClass("hover");
    }, function () {
        $(this).removeClass("hover");
    });
    $obj.find("p").hover(function () {
        if ($(this).hasClass("on")) { return; }
        $(this).addClass("hover");
    }, function () {
        if ($(this).hasClass("on")) { return; }
        $(this).removeClass("hover");
    });
    $obj.find("h4").click(function () {
        var $div = $(this).siblings(".list-item");
        if ($(this).parent().hasClass("selected")) {
            $div.slideUp(600);
            $(this).parent().removeClass("selected");
        }
        if ($div.is(":hidden")) {
            $("#nav_dot li").find(".list-item").slideUp(600);
            $("#nav_dot li").removeClass("selected");
            $(this).parent().addClass("selected");
            $div.slideDown(600);

        } else {
            $div.slideUp(600);
        }
    });
}

/**直接写在了原page_footer页，现移动到这里**/
    navList(12);
$(function(){
  $(".slides .kefu").mouseenter(function(){
    $(this).find(".kefulist").fadeIn();
  });
  $(".slides .kefu").mouseleave(function(){
    $(this).find(".kefulist").fadeOut();
  });
});


/***all_top_nav.js**/
$('.signin').hover(function() {
$("div#toplogin_main").show();
}, function() {
$('div#toplogin_main').hover(function() {
}, function() {
    $("div#toplogin_main").hide();
});
});

$('.shoppingcar_menu').hover(function() {
$("div#shoppingcar").show();
}, function() {
$('div#shoppingcar').hover(function() {
}, function() {
    $("div#shoppingcar").hide();
});
});
