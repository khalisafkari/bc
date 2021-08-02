<?php 
$thisComment = $db->Query(APP_TABLES_PREFIX.'manga_comments', '*', array('delete_comment'=>0), NULL, NULL, array('time'=>'DESC'), 10);
?>

<div class="list-comment">
  <div class="panel panel-default panel-genres">
    <div class="title_doctruyen manga">
      <div class="title-genres">New Comments</div>
    </div>
    <div id="show_new_comment" class="show_comment">
    
      <?php 
      foreach ($thisComment as $Comment) {
        $thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', array('name', 'slug'), array('id'=>$Comment['manga']));
        $Manga = $thisManga[0];
        $User = $user->info_user($Comment['user_id']);
       ?>
       <article>
          <img src="<?=$avtFolder.$User['avatar']?>">
        <span class="name_user"><?=$User['name']?></span>
        <div class="content"><?=$Comment['content']?></div>
        <div class="chan">
        <span class="time"><?=$huy->ago($Comment['time'])?></span>
          <a class="pull-right" target="_blank" href="/<?=$lang['manga_slug'].'-'.$Manga['slug']?>.html"><?=$Manga['name']?></a>
        </div>
        
      </article>
      <div class="clearfix"></div>
      <hr>
      <?php 
    }
    ?>
  </div>
</div>
</div>
