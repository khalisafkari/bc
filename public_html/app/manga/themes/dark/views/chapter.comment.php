</div>
<br />
<div class="col-md-8 centered">
  <div id="commentbox" class="card card-dark">
    <div class="card-header">
      <h3 class="card-title"> Comment</h3>
    </div>
    <div class="card-body bg-dark">
      <?php
	  	$thisChapter['chapter'] = str_replace('onload','',$thisChapter['chapter']);
      if ($user->isLoggedIn()) {
        ?>
        <div class="panel panel-default bgc">
          <div class="panel-body body-cmt">
            <div class="comment">
              <form method="POST" role="form" class="formComment" id="formComment">
                <div class="form-group">
                  <textarea id="txtcomment" class="form-control" rows="5"></textarea>
                  <input type="hidden" name="manga" value="<?=$thisManga['id']?>">
                  <input type="hidden" name="chapter_id" value="<?=$thisChapter['id']?>">
                  <input type="hidden" name="cm_chapter" value="<?=$thisChapter['chapter']?>">
                </div>
                <div style="padding-right: 10px;" class="pull-right">
                  <div class="" id="loading"></div>
                  <button type="submit" id="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane" aria-hidden="true"></i> Post</button>
                  <button type="button" id="cancel" class="btn btn-default btn-sm">Cancel</button>
                </div>
              </form>
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
      <div id="cmt-chapters" class="list-comment">
        <div class="rows-cmt">
          <script type="text/javascript">
            load_Comment_Chapter(<?=$thisManga['id']?>, <?=$thisChapter['chapter']?>);
          </script>
        </div>
        <ul class="pagination-v4 pagination"></ul>
      </div>
    </div>
  </div>
</div>
</div>