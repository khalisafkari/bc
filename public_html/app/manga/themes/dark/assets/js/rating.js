$(document).ready(function(){$(".h0rating").each(function(){var a=$(this).attr("slug");$.post("/controllers/ratings.php",{action:"show",slug:a},function(b){$("div[slug='"+a+"']").html(b)})})}),$(document).on("click",".h0_ratings_active",function(){var a=$(this).attr("rel"),b=$(this).parent().attr("slug");$.post("/controllers/ratings.php",{action:"vote",rating:a,slug:b},function(a){$("div[slug='"+b+"']").html(a+"<span class='h0_ratings_thanks'>Thanks!</span>")})}),$(document).on("mouseenter",".h0_ratings_active",function(){$(this).addClass("h0_ratings_on").removeClass("h0_ratings_off"),$(this).prevAll().addClass("h0_ratings_on").removeClass("h0_ratings_off"),$(this).nextAll().addClass("h0_ratings_off").removeClass("h0_ratings_on")});