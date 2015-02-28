//  style/js/left_nav.js
/* 代码整理：懒人之家 www.lanrenzhijia.com */
$(function() {
//商品分类
//判断 一级页面
    
    $('.all-goods .item').hover(function() {
        $(this).addClass('active').find('s').hide();
        $(this).find('.product-wrap').show();
    }, function() {
        $(this).removeClass('active').find('s').show();
        $(this).find('.product-wrap').hide();
    });

});


//  style/js/shoppingcar.js
/* 代码整理：懒人之家 www.lanrenzhijia.com */
jQuery(function(){
  jQuery(".fixedBox ul.fixedBoxList li.fixeBoxLi").hover(
	function (){
	  jQuery(this).find('span.fixeBoxSpan').addClass("hover");
	  jQuery(this).addClass("hover");
	},
	function () {
	 jQuery(this).find('span.fixeBoxSpan').removeClass("hover");
	  jQuery(this).removeClass("hover");
	}
  );
  jQuery('.BackToTop').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
  var oDate=new Date();
  var iHour=oDate.getHours();
  if(iHour>8 && iHour<22){
    jQuery(".Service").addClass("startWork");
    jQuery(".Service").removeClass("Commuting");
  }else{
    jQuery(".Service").addClass("Commuting");
    jQuery(".Service").removeClass("startWork");
  };
});

jQuery(function(){
  jQuery('.listLeftMenu dl dt').click(function(){
    var but_list=jQuery(this).attr('rel');
    if(but_list=='off'){
      jQuery(this).attr('rel','on');
	  jQuery('.listLeftMenu dl').removeClass('off');
	  jQuery(this).parent().addClass('on');
    }else{
      jQuery(this).attr('rel','off');
	  jQuery(this).parent().removeClass('on');
	  jQuery(this).parent().addClass('off');
    }
  });
});
/* 代码整理：懒人之家 www.lanrenzhijia.com */



// jquery.json.js
(function($) {   
    function toIntegersAtLease(n) 
    {    
        return n < 10 ? '0' + n : n;
    }

    Date.prototype.toJSON = function(date)
    {
        return this.getUTCFullYear()   + '-' +
             toIntegersAtLease(this.getUTCMonth()) + '-' +
             toIntegersAtLease(this.getUTCDate());
    };

    var escapeable = /["\\\x00-\x1f\x7f-\x9f]/g;
    var meta = {   
            '\b': '\\b',
            '\t': '\\t',
            '\n': '\\n',
            '\f': '\\f',
            '\r': '\\r',
            '"' : '\\"',
            '\\': '\\\\'
        };
        
    $.quoteString = function(string)
    {
        if (escapeable.test(string))
        {
            return '"' + string.replace(escapeable, function (a) 
            {
                var c = meta[a];
                if (typeof c === 'string') {
                    return c;
                }
                c = a.charCodeAt();
                return '\\u00' + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
            }) + '"';
        }
        return '"' + string + '"';
    };
    
    $.toJSON = function(o)
    {
        var type = typeof(o);
		
        if (type == "undefined")
            return "undefined";
        else if (type == "number" || type == "boolean")
            return o + "";
        else if (o === null)
            return "null";
        
        // Is it a string?
        if (type == "string") 
        {
            return $.quoteString(o);
        }
        
        // Does it have a .toJSON function?
        if (type == "object" && typeof o.toJSON == "function") 
            return o.toJSON();
        
        // Is it an array?
        if (type != "function" && typeof(o.length) == "number") 
        {
            var ret = [];
            for (var i = 0; i < o.length; i++) {
                ret.push( $.toJSON(o[i]) );
            }
            return "[" + ret.join(",") + "]";
        }
        
        // If it's a function, we have to warn somebody!
        if (type == "function") {
            throw new TypeError("Unable to convert object of type 'function' to json.");
        }
        
        // It's probably an object, then.
        var ret = [];
        for (var k in o) {
            var name;
            type = typeof(k);
            
            if (type == "number")
                name = '"' + k + '"';
            else if (type == "string")
                name = $.quoteString(k);
            else
                continue;  //skip non-string or number keys
            
            var val = $.toJSON(o[k]);
            if (typeof(val) != "string") {
                // skip non-serializable values
                continue;
            }
            
            ret.push(name + ":" + val);
        }
        return "{" + ret.join(",") + "}";
    };
    
    $.compactJSON = function(o)
    {
        return $.toJSON(o, true);
    };
    
    $.evalJSON = function(src)
    // Evals JSON that we know to be safe.
    {
        return eval("(" + src + ")");
    };
    
    $.secureEvalJSON = function(src)
    // Evals JSON in a way that is *more* secure.
    {
        var filtered = src;
        filtered = filtered.replace(/\\["\\\/bfnrtu]/g, '@');
        filtered = filtered.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']');
        filtered = filtered.replace(/(?:^|:|,)(?:\s*\[)+/g, '');
        
        if (/^[\],:{}\s]*$/.test(filtered))
            return eval("(" + src + ")");
        else
            throw new SyntaxError("Error parsing JSON, source is not valid.");
    };
})(jQuery);
