/* 代码整理：懒人之家 www.lanrenzhijia.com */
$(function() {
//商品分类
//判断 一级页面
    
    $('.all-goods .item').hover(function() {
        $(this).addClass('active').find('s').hide();
        $(this).find('.product-wrap').show();
        $(this).find('.product-wrap').parents('.all-goods').show();
    }, function() {
        $(this).removeClass('active').find('s').show();
        $(this).find('.product-wrap').hide();
        $(this).find('.product-wrap').parents('.all-goods').hide();
    });

//    //判断调用二级页面

//    $('.all-goods .item').hover(function() {
//        $(this).addClass('active').find('s').hide();
//        $(this).find('.product-wrap').show();

//    }, function() {
//        $(this).removeClass('active').find('s').show();
//        $(this).find('.product-wrap').hide();

//    });

});

function yincang() {
//    $(this).addClass('active').find('s').hide();
//    $(this).find('.product-wrap').show();
    //    $(this).removeClass('active').find('s').show();
    
}
