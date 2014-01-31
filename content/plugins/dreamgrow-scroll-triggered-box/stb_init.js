if (typeof stb === "undefined")
    var stb = {};
jQuery(document).ready(function () {
    jQuery("#closebox").click(function () {
        jQuery('#scrolltriggered').stop(true, true).animate({ 'bottom':'-210px' }, 500, function () {
            jQuery('#scrolltriggered').hide();
            stb.hascolsed = true;
            jQuery.cookie('nopopup', 'true', { expires: stb.cookieLife, path: '/' });
        });
        return false;
    });

    stb.windowheight = jQuery(window).height();
    stb.totalheight = jQuery(document).height();
    stb.boxOffset = '';
    if (stb.stbElement != '') {
        stb.boxOffset = jQuery(stb.stbElement).offset().top;
    }
    jQuery(window).resize(function () {
        stb.windowheight = jQuery(window).height();
        stb.totalheight = jQuery(document).height();
    });

    jQuery(window).scroll(function () {
        stb.y = jQuery(window).scrollTop();
        stb.boxHeight = jQuery('#scrolltriggered').outerHeight();
        stb.scrolled = parseInt((stb.y + stb.windowheight) / stb.totalheight * 100);


        if (stb.showBox(stb.scrolled, stb.triggerHeight, stb.y) && jQuery('#scrolltriggered').is(":hidden") && stb.hascolsed != true) {
            jQuery('#scrolltriggered').show();
            jQuery('#scrolltriggered').stop(true, true).animate({ 'bottom':'10px' }, 500, function () {
            });
        }
        else if (!stb.showBox(stb.scrolled, stb.triggerHeight, stb.y) && jQuery('#scrolltriggered').is(":visible") && jQuery('#scrolltriggered:animated').length < 1) {
            jQuery('#scrolltriggered').stop(true, true).animate({ 'bottom':-stb.boxHeight }, 500, function () {
                jQuery('#scrolltriggered').hide();
            });
        }
    });

    jQuery('#stbContactForm').submit(function (e) {
        e.preventDefault();
        stb.data = jQuery('#stbContactForm').serialize();

        jQuery.ajax({
            url:stbAjax.ajaxurl,
            data:{
                action:'stb_form_process',
                stbNonce:stbAjax.stbNonce,
                data:stb.data
            },
            dataType:'html',
            type:'post'

        }).done(function (data) {
                jQuery('#stbMsgArea').html(data).show('fast');
            });

        return false;
    });
});

(function(stb_helpers) {
    stb_helpers.showBox = function(scrolled, triggerHeight, y) {
        if (stb.isMobile()) return false;
        if (stb.stbElement == '') {
            if (scrolled >= triggerHeight) {
                return true;
            }
        }
        else {
            if (stb.boxOffset < (stb.windowheight + y)) {
                return true;
            }
        }
        return false;
    };
    stb_helpers.isMobile = function(){
        if (navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            ) {
            return true;
        }
        else return false;
    }
})(stb);