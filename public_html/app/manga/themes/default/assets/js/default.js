!function(a){a(function(){a(".nav").tooltip({selector:"[data-toggle=modal]",container:"body"}),a("[data-toggle=popover]").popover({trigger:"hover",placement:a(this).attr("data-placement"),html:!0}),a("[data-toggle=mangapop]").hover(function(){var b=a(this);if(0==a("div[manga-slug='"+a(this).attr("manga-slug")+"']").length){var c=a(this).attr("manga-slug");a.post("app/manga/controllers/cont.pop.php",{slug:c}).done(function(d){a("body").append("<div manga-slug='"+c+"' style='display: none'>"+d+"</strong>"),b.is(":hover")&&a(b).popover({trigger:"hover",content:function(){return a("div[manga-slug='"+a(this).attr("manga-slug")+"']").html()},placement:a(this).attr("data-placement"),html:!0}).popover("toggle")})}else a(b).popover({trigger:"hover",content:function(){return a("div[manga-slug='"+a(this).attr("manga-slug")+"']").html()},placement:a(this).attr("data-placement"),html:!0}).popover("toggle")})})}(window.jQuery);