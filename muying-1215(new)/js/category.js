 $(function() {
        //菜单隐藏展开
        var tabs_i = 0
        var vtest = 0;
        $('.vtitle').click(function() {
            var _self = $(this);
            var j = $('.vtitle').index(_self);
            if (tabs_i == j) {
                if (vtest == "0") {
                    vtest = "1";
                    $('.vtitle em').removeClass('v02').addClass('v01'); //清除选中样式
                    $('.vcon').slideUp().eq(tabs_i).slideUp();
                }
                else {
                    vtest = "0";
                    tabs_i = j;
                    $('.vtitle em').each(function(e) {
                        if (e == tabs_i) {
                            $('em', _self).removeClass('v01').addClass('v02'); //选中的样式
                        } else {
                            $(this).removeClass('v02').addClass('v01'); //清除选中样式
                        }
                    });
                    $('.vcon').slideUp().eq(tabs_i).slideDown(); //打开下拉 hide();
                }
            }
            else {
                vtest = "0";
                tabs_i = j;
                $('.vtitle em').each(function(e) {
                    if (e == tabs_i) {
                        $('em', _self).removeClass('v01').addClass('v02'); //选中的样式
                    } else {
                        $(this).removeClass('v02').addClass('v01'); //清除选中样式
                    }
                });
                $('.vcon').slideUp().eq(tabs_i).slideDown(); //打开下拉 hide();
            }
        });
    })