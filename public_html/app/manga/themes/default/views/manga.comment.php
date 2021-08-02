<br /><br />
<div class="tab_Comment" role="tabpanel">
  <h3>Comment</h3>
  <ul id="myTab" class="nav nav-tabs" role="tablist">
    <? if(in_array('1', $c_manga['comment_type'])){ ?>
    <li role="presentation" class="active"><a href="#tab1" ria-controls="tab1" role="tab" data-toggle="tab">TRUYENTRANHAZ (<?=$h0manga->count_comment($thisManga['id']);?>)</a></li>
    <? } if(in_array('2', $c_manga['comment_type'])){ ?>
    <li role="presentation"><a href="#tab2" ria-controls="tab2"  role="tab" data-toggle="tab">Facebook (<fb:comments-count href="<?=$huy->thisPage()?>"></fb:comments-count>)</a></li>
    <? } ?>
  </ul>
  <div id="myTabContent" class="tab-content">
   <!--  TTAZ COMMENT  -->
   <div role="tabpanel" class="tab-pane fade active in" id="tab1">

    <div id="commentbox" class="row well well-sm">
      <?php
      if(in_array('1', $c_manga['comment_type'])){
        if ($user->isLoggedIn()) {
          ?>
          <div class="row">
            <div class="col-md-2 col-sm-2">
              <div class="avatar">
                <a href="/ucp" class="text-center">
                  <img class="avatar1" src="<?='/'.$avtFolder.$_SESSION['thisUser']['avatar']?>" alt="Avatar của bạn" title="Avatar của bạn">
                  <div class="user"><?=$_SESSION['userName']?></div>
                </a>
              </div>
            </div>
            <div class="col-md-10 col-sm-10">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="comment">
                    <form method="POST" role="form" class="formComment" id="formComment">
                      <div class="form-group">
                        <textarea id="txtcomment" class="form-control" rows="5"></textarea>
                        <input type="hidden" name="manga" value="<?=$thisManga['id']?>">
                      </div>
                      <div class="pull-right">
                        <div class="" id="loading"></div>
                        <button type="submit" id="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane" aria-hidden="true"></i> Post</button>
                        <button type="button" id="cancel" class="btn btn-default btn-sm">Cancel</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
        } else {
          echo '<div class="panel panel-default arrow left">
          <div class="panel-heading right text-center">
          Please <a data-toggle="modal" href="#register"> <b>Register</b></a> or <a data-toggle="modal" href="#login"> <b>Login</b></a> to comment!
          </div></div>
          ';
        }
        ?>
        <div class="list-comment">
          <script type="text/javascript">
            load_Comment(<?=$thisManga['id']?>);
          </script>
        </div>
        <?php 
      }
      ?>
    </div>
  </div>
  <!--  FACEBOOK COMMENT  -->
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '<?=$c_manga['fb_app']?>',
        xfbml      : true,
        version    : 'v2.9'
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
 <div role="tabpanel" class="tab-pane fade" id="tab2">
   <?php
   if(in_array('2', $c_manga['comment_type'])){
     ?>
     <div id="fb-root"></div>

     <div class="fb-comments" data-href="<?=$huy->thisPage()?>" data-width="100%" data-numposts="10"></div>

     <? 
   }
   ?>
 </div>
</div>
</div>