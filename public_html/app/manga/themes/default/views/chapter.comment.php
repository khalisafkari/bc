<br /><br />
<h3>COMMENT</h3>
<style>
  .fb_iframe_widget, .fb_iframe_widget span, .fb_iframe_widget span iframe { 
    min-width: 100% !important;
    width: 100% !important;
  }
  div#facebook {
    background: #fff;
  }
</style>
<div style="margin: 0 auto;width: 80%;">
  <ul id="myTab" class="nav nav-tabs">
   <? if(in_array('2', $c_manga['comment_type'])){ ?>
   <li class="active"><a href="#facebook" data-toggle="tab">Facebook</a></li>
   <? } ?>
 </ul>
 <div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="facebook">
   <br /><br />
   <!--  FACEBOOK COMMENT  -->
   <? if(in_array('2', $c_manga['comment_type'])){ ?>
   <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '<?=$c_manga['fb_app']?>',
        xfbml      : true,
        version    : 'v2.8'
      });
    };

    (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/vi_VN/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
 </script>
 <div id="fb-root"></div>


 <div class="fb-comments" data-href="<?=$huy->thisPage()?>" data-width="100%" data-numposts="10"></div>

 <? } ?>

</div>
</div>
</div>
