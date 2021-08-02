<?php 
$thisComment = $db->Query(APP_TABLES_PREFIX.'manga_comments', '*', array('delete_comment'=>0), NULL, NULL, array('time'=>'DESC'), 7);
?>
<!--/br><center>
	<!-- GPT AdSlot 1 for Ad unit '' ### Size: [[300,250],[336,280]] -->
	<!--div id='div-gpt-ad-8176806-1'>
	  <script>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-8176806-1'); });
	  </script>
	</div>
	<!-- End AdSlot 1 -->
<!--/center></br-->
<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fa fa-comment" aria-hidden="true"></i> &nbsp; 
      <?=$lang['New-comment']?>
    </h3>

  </div>
  <div class="card-body bg-dark">

    <?php 
    foreach ($thisComment as $Comment) {
      $thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'name', array('id'=>$Comment['manga']));
      $thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'chapter', array('id'=>$Comment['chapter']));
	  $Manga = $thisManga[0];
	  $Chapter = $thisChapter[0];
      $User = $user->info_user($Comment['user_id']);
	  $Comment['content'] = str_replace('onload','',$Comment['content']);
      ?>
      <div class="comment-item-at-index">
        <div class="comment-info">
          <div class="comment-top">
            <div class="comment-user_ava">
              <img src="<?=$avtFolder.$User['avatar']?>">
            </div>
            <a rel="nofollow" class="comment-user_name strong"><?=$User['name']?></a>
            <small class="comment-location">
			  <? if ($thisChapter = $Comment['chapter']) {
				  ?>
				    <time class="timeago btn btn-xs btn-warning" style="background-color: #5c2040; border-color: #5c2040" title="<?=$Manga['name']?> Chap <?=$Comment['chapter']?>"><a href="/<?=$Comment['manga']?>/<?=$Comment['chapter_id']?>/"><i style="color: white"> Chapter <?=$Comment['chapter']?></i></a></time> 
					</br></br>
				<? }
			  ?>
			  
			  <time class="timeago" title="<?=$huy->ago($Comment['time'])?>"><?=$huy->ago($Comment['time'])?></time>
			</small>
          </div>
          <div class="comment-content"><?=$Comment['content']?></div>
          <span class="series-name text-truncate">
            <a href="/<?=$Comment['manga']?>/" title="<?=$Manga['name']?>"><?=$Manga['name']?></a>
          </span>
        </div>
      </div>
      <?php 
    }
    ?>
  </div>
</div>
