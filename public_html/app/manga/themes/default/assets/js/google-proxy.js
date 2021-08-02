(function($) {

    var $contents = $(".chapter-content img");

    $contents.length && $contents.each(function(i, v) {
        var $this = $(v),
        image = $this.attr('src');
        image = image.trim(image);
        if (image.indexOf('fbcdn.net') !== -1) return;

        image = decodeURIComponent(image);
        image = $.trim(image);
        image = image.replace(/^.+(&|\?)url=/, '');
        image = image.replace(/(https?:\/\/)lh(\d)(\.bp\.blogspot\.com)/, '$1$2$3');
        image = image.replace(/(https?:\/\/)lh\d\.(googleusercontent|ggpht)\.com/, '$14.bp.blogspot.com');
        image = image.replace(/\?.+$/, '');
        if (image.indexOf('blogspot.com') !== -1) {
            image = image.replace(/\/(((s|w|h)\d+|(w|h)\d+\-(w|h)\d+))?\-?(c|d|g)?\/(?=[^\/]+$)/, '/');
            image += '?imgmax=0';
        }
        if (image.indexOf('i.imgur.com') !== -1) {
            image = image.replace(/(\/)(\w{5}|\w{7})(s|b|t|m|l|h)(\.(jpe?g|png|gif))$/, '$1$2$4');
        }
        if (image.indexOf('beeng.net') !== -1) {
          image = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=' + encodeURIComponent(image);
        }
      image = image.replace(/^https:\/\//, 'http://');

      $this.attr('src', image);
  });
    function trim(str) {
        return str.replace(/\s+/g,"");
    }
    // Image process
    $('a.loadchapter').click(function () {
        var server = $(this).data('server');
        ChangeProxyServer(server, false);

        return false;
    });

    if ($(".chapter-content img").length > 1 && $(".chapter-content img").eq(1).attr('data-original').search("bp.blogspot.com") > 0)
        $('a.loadchapter[data-server=3]').removeClass('hidden');

    var proxyServer = "https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=";
    var proxyServerTT8 = "https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=";
    //ProcessImageNotShow();
    // function ProcessImageNotShow() {
    //     $(".chapter-content img").each(function () {
    //         var imgSrc = $(this).attr('data-original');
    //         if (imgSrc.search(".truyentranh8.net") > 0) {
    //             imgSrc = imgSrc.split('&url=').pop();
    //             imgSrc = proxyServerTT8 + decodeURIComponent(imgSrc).replace("manga.truyentranh8.net", "shounen.truyentranh8.net").replace("s1205.truyentranh8.net", "shounen.truyentranh8.net");
    //             $(this).attr("data-original", imgSrc);
    //             $(this).attr("src", imgSrc);
    //         } else if (imgSrc.search(".hentai2read.com") > 0) {
    //             imgSrc = imgSrc.split('&url=').pop();
    //             mgSrc = proxyServer + decodeURIComponent(imgSrc);
    //             $(this).attr("data-original", imgSrc);
    //             $(this).attr("src", imgSrc);
    //         }
    //     });
    // }
    // ProcessImageNotShow();
    function ChangeProxyServer(server, setCookie) {
        $('a.loadchapter').removeClass('btn-success').addClass('btn-primary');

        if (server == 1) {
            $(".chapter-content img").each(function () {
                $(this).attr("src", $(this).attr('data-original'));

                if ($(this).parent().hasClass('fancybox'))
                    $(this).parent().attr('href', $(this).attr('src'));
            });

            $('a.loadchapter[data-server=1]').removeClass('btn-primary').addClass('btn-success');
        }
        else if (server == 2) {
            $(".chapter-content img").each(function () {
                var imgSrc = $(this).attr('data-original');
                if (imgSrc.search("focus-opensocial.googleusercontent") > 0) {
                    var imageUrl = imgSrc.split('&url=').pop();
                    imgSrc = imgSrc.replace('?imgmax=0', '');
                    imgSrc = imgSrc.replace('%3Fimgmax%3D0%0A', '');
                    imgSrc = imgSrc.replace(/%0A/gi, '');

                    imgSrc = decodeURIComponent(imageUrl);
                } else {
                    if (imgSrc.search(".truyentranh8.net") > 0)
                        imgSrc = proxyServerTT8 + decodeURIComponent(imgSrc);
                    else {
                        imgSrc = proxyServer + encodeURIComponent(imgSrc);
                        imgSrc = imgSrc.replace('?imgmax=0', '');
                        imgSrc = imgSrc.replace('%3Fimgmax%3D0%0A', '');
                        imgSrc = imgSrc.replace(/%0A/gi, '');
                    }
                }
                $(this).attr("src", imgSrc);

                if ($(this).parent().hasClass('fancybox'))
                    $(this).parent().attr('href', imgSrc);
            });

            $('a.loadchapter[data-server=2]').removeClass('btn-primary').addClass('btn-success');
        }
        else if (server == 3) {
            $(".chapter-content img").each(function () {
                var imgSrc = $(this).attr('data-original');
                if (imgSrc.search("bp.blogspot.com") > 0) {
                    $(this).attr("src", imgSrc.replace(/1.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/2.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/3.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/4.bp.blogspot.com/g, 'lh3.googleusercontent.com'));
                }

                if ($(this).parent().hasClass('fancybox'))
                    $(this).parent().attr('href', $(this).attr('src'));
            });

            $('a.loadchapter[data-server=3]').removeClass('btn-primary').addClass('btn-success');
        }

        if (setCookie) {
            changedProxyServer = Get_Cookie(changedProxyCookieName);
            if (changedProxyServer != null && server == 1)
                Delete_Cookie('ttaz.changedproxy', '/');
            if (server != 1) {
                Set_Cookie('ttaz.changedproxy', server, 1, '/'); //1 day = 24h
            }
        }
    }
})(jQuery);