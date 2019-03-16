/**
 * Created by chenweizhao on 2017/9/10.
 */
(function($){
    var TabElement = function(option){
        this.option = option;
    }
    TabElement.prototype = {
        'f': function(l){
            var k = 0;
            $(l).each(function() {
                k += $(this).outerWidth(true);
            });
            return k;
        },
        'prevTab': function(){
            var that = this;
            var o = Math.abs(parseInt($(that.option.tab_list).css("margin-left")));
            var l = that.f($(that.option.content_tab).children().not(that.option.nav_tab));
            var k = $(that.option.content_tab).outerWidth(true) - l;
            var p = 0;
            if ($(that.option.tab_list).width() < k) {
                return false
            } else {
                var m = $(that.option.tab_list).children().first();
                var n = 0;
                while ((n + $(m).outerWidth(true)) <= o) {
                    n += $(m).outerWidth(true);
                    m = $(m).next()
                }
                n = 0;
                if (that.f($(m).prevAll()) > k) {
                    while ((n + $(m).outerWidth(true)) < (k) && m.length > 0) {
                        n += $(m).outerWidth(true);
                        m = $(m).prev()
                    }
                    p = that.f($(m).prevAll())
                }
            }
            $(that.option.tab_list).animate({
                marginLeft: 0 - p + "px"
            }, "fast")
        },
        'nextTab': function(){
            var that = this;
            var o = Math.abs(parseInt($(that.option.tab_list).css("margin-left")));
            var l = that.f($(that.option.content_tab).children().not(that.option.nav_tab));
            var k = $(that.option.content_tab).outerWidth(true) - l;
            var p = 0;
            if ($(that.option.tab_list).width() < k) {
                return false
            } else {
                var m = $(that.option.tab_list).children().first();
                var n = 0;
                while ((n + $(m).outerWidth(true)) <= o) {
                    n += $(m).outerWidth(true);
                    m = $(m).next()
                }
                n = 0;
                while ((n + $(m).outerWidth(true)) < (k) && m.length > 0) {
                    n += $(m).outerWidth(true);
                    m = $(m).next()
                }
                p = that.f($(m).prevAll());
                if (p > 0) {
                    $(that.option.tab_list).animate({
                        marginLeft: 0 - p + "px"
                    }, "fast")
                }
            }
        },
        'goTab': function(n){
            var that = this;
            var o = that.f($(n).prevAll()), q = that.f($(n).nextAll());
            var l = that.f($(that.option.content_tab).children().not(that.option.nav_tab));
            var k = $(that.option.content_tab).outerWidth(true) - l;
            var p = 0;
            if ($(that.option.tab_list).outerWidth() < k) {
                p = 0
            } else {
                if (q <= (k - $(n).outerWidth(true) - $(n).next().outerWidth(true))) {
                    if ((k - $(n).next().outerWidth(true)) > q) {
                        p = o;
                        var m = n;
                        while ((p - $(m).outerWidth()) > ($(that.option.tab_list).outerWidth() - k)) {
                            p -= $(m).prev().outerWidth();
                            m = $(m).prev()
                        }
                    }
                } else {
                    if (o > (k - $(n).outerWidth(true) - $(n).prev().outerWidth(true))) {
                        p = o - $(n).prev().outerWidth(true)
                    }
                }
            }
            $(that.option.tab_list).animate({
                marginLeft: 0 - p + "px"
            }, "fast")
        },
        'goTab2': function(n){
            var that = this;
            var o = that.f($(n).prevAll()), q = that.f($(n).nextAll());
            var l = that.f($(that.option.content_tab).children().not(that.option.nav_tab));
            var k = $(that.option.content_tab).outerWidth(true) - l;
            var p = 0;
            if ($(that.option.tab_list).outerWidth() < k) {
                p = 0
            } else {
                if (q <= (k - $(n).outerWidth(true) - $(n).next().outerWidth(true))) {
                    if ((k - $(n).next().outerWidth(true)) > q) {
                        p = o;
                        var m = n;
                        while ((p - $(m).outerWidth()) > ($(that.option.tab_list).outerWidth() - k)) {
                            p -= $(m).prev().outerWidth();
                            m = $(m).prev()
                        }
                    }
                } else {
                    if (o > (k - $(n).outerWidth(true) - $(n).prev().outerWidth(true))) {
                        p = o - $(n).prev().outerWidth(true)
                    }
                }
            }
            $(that.option.tab_list).animate({
                marginLeft: 0 - p + "px"
            }, 0)
        }
    };
    $.fn.menuTab = function(option){
        var opt = $.extend({},option);
        return new TabElement(opt);
    }
})(jQuery)

var TabMenu = $('.content-tabs').menuTab({
    'content_tab':'.content-tabs',
    'nav_tab':'.page-tabs',
    'tab_list':'.page-tabs-content'
});
$('.J_tabRight').on('click',function(){
    TabMenu.nextTab();
})
$('.J_tabLeft').on('click',function(){
    TabMenu.prevTab();
})
$('.J_menuTab').on('click',function(){
    $('.J_menuTab.active').removeClass('active');
    $(this).addClass('active');
    TabMenu.goTab($(this));
})

function jumptab(currenttab) {
    var pcurrenttab = currenttab;
    if ('' == currenttab) {
        pcurrenttab = 0;
}
    $('.page-tabs-content').children(":eq(" + pcurrenttab + ")").first().addClass('active');
    TabMenu.goTab2($('.page-tabs-content').children(":eq(" + pcurrenttab + ")").first());
}


