
/*-----------------------------------*/
    $(document).ready(function(){
        $('#word_1').focus();
    });
   
   $(document).ready(function() {
   (function($){
        $.fn.slider=function(arg){
            var me = $(this),opt = $.extend({inteval:5000,auto:true,loop:false,prev:me.find(".prev_1"),next:me.find(".next_1"),pageBtns:"",finish:function(){},start:function(){}}, arg),pageBtns,scrollable = me.find(".scrollable_1"),ori_items = me.find(".items_1"),total_num = me.find(".item_1").length,cur_page = 0,mov_w = me.find(".item_1").outerWidth(),move_left=0,interval;
            opt.start();
            if (opt.loop) {
                ori_items.append(ori_items.find(".item_1").clone());
                ori_items.prepend(ori_items.find(".item_1").clone());
                scrollable.scrollLeft(getCurScroLeft());
            }
           opt.prev.length&&opt.prev.bind("click",move).hover(function(){$(this).addClass("hover_1")},function(){$(this).removeClass("hover_1")});
           opt.next.length&&opt.next.bind("click",move).hover(function(){$(this).addClass("hover_1")},function(){$(this).removeClass("hover_1")});
           if(opt.auto){
               interval=setInterval(move,opt.inteval);
               me.hover(function(){clearInterval(interval)},function(){interval=setInterval(move,opt.inteval);move_left=0});
           }
           if(opt.pageBtns&&!opt.loop){
               pageBtns=opt.pageBtns;
               pageBtns.bind("click",moveTo);
           }
           function moveTo(e){
                pageBtns.unbind("click",moveTo);
                var cur_li=$(e.target).closest("li"),num=cur_li.index();
                pageBtns.removeClass("select_1");cur_li.addClass("select_1");
                var cur_scrollLeft=num*mov_w;
                scrollable.animate({scrollLeft:cur_scrollLeft},{duration:'normal',easing:'swing',complete:function(){pageBtns.bind("click",moveTo);opt.finish(num)},queue:false});
           }
           function move(e){
              opt.prev.length&&opt.prev.unbind("click",move);
              opt.next.length&&opt.next.unbind("click",move);
              if(e){
                  clearInterval(interval);
                  var cur_btn=$(e.target);
                  if(cur_btn.hasClass("prev_1")){move_left=1};
                  if(cur_btn.hasClass("next_1")){move_left=0};
              }
               var cur_scrollLeft=move_left ? getCurScroLeft()-mov_w:getCurScroLeft()+mov_w;
               scrollable.stop().animate({scrollLeft:cur_scrollLeft},{duration:'normal',easing:'swing',complete:complate,queue:false});
           }
           function complate(){
               cur_page=move_left?cur_page-1:cur_page+1;
               if(cur_page<= -total_num+2){cur_page+=total_num;resetscroll()}
               if(cur_page>=2*total_num-2){cur_page-=total_num;resetscroll()}
               opt.prev.length&&opt.prev.bind("click",move);
               opt.next.length&&opt.next.bind("click",move);
               opt.finish();
           }
           function resetscroll(){
               scrollable.scrollLeft(getCurScroLeft());
           }
           function getCurScroLeft(){
               return opt.loop?total_num * mov_w+cur_page*mov_w:cur_page*mov_w;
           }
        }
    })(jQuery);
    $("#banner-slide_1").slider({
        interval:5000,
        loop: true,
        auto:false
    });

});

/*-----------------------------------*/
  