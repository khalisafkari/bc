  
<? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>
<div class="list-group">
   <?=($user->isAdmin() ? '
  <a href="index.html" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-briefcase"></i> FLAT MANGA</h4>
    <p class="list-group-item-text">
      <strong>'.$l["APP_NAME"].'</strong>:  Flat manga <br />
      <strong>'.$l["APP_VERSION"].'</strong>:  2.4 <br />
      <strong>'.$l["APP_HOMEPAGE"].'</strong>:  https://lovehug.net <br />
    </p>
  </a>
  <a href="app=mangaview=manga_settings" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-cog"></i> '.$lang["Manga_config"].'</h4>
    <p class="list-group-item-text"><?=$lang["Manga_config_ex"]?></p>
  </a>
  <a href="app=mangaview=manga_seo" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-list-alt"></i> '.$lang["SEO_config"].'</h4>
    <p class="list-group-item-text"><?=$lang["SEO_config_ex"]?></p>
  </a>
  <a href="app=mangaview=manga_rss" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-list-alt"></i> '.$lang["RSS_config"].'</h4>
    <p class="list-group-item-text"><?=$lang["RSS_config_ex"]?></p>
  </a>
 ' : '')?>
</div>
<div class="list-group">
  <a href="app=mangaview=manga_management" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-list"></i> <?=$lang['Manga_List']?></h4>
    <p class="list-group-item-text"><?=$lang['Manga_list_ex'] ?></p>
  </a>
  <a href="app=mangaview=group_management" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-user"></i><i class="glyphicon glyphicon-user"></i> <?=$lang['Group']?></h4>
    <p class="list-group-item-text">Customize groups of stories on the story reading page</p>
  </a>
  <a href="app=mangaview=genre_management" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i></i> <?=$lang['Genres']?></h4>
    <p class="list-group-item-text">Customize genres of stories on the reading page</p>
  </a>
  <a href="app=mangaview=magazine_management" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-book" aria-hidden="true"></i></i> Magazine(s)</h4>
    <p class="list-group-item-text">Customize magazines of stories on the reading page</p>
  </a>
  <a href="app=mangaview=manga_q_management" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-check"></i> <?=$lang['Manga_q_List']?></h4>
    <p class="list-group-item-text"><?=$lang['Manga_q_List_ex'] ?></p>
    <? $manga_q = count($db->Query(APP_TABLES_PREFIX . 'manga_mangas_q', '*'));
    if($manga_q > 0){ ?>
    <span class="label label-primary" style="position: relative; top: -40px; right: -320px;"><?=$manga_q?> NEW</span>
    <? } ?>
  </a>
  <a href="app=mangaview=chapter_q_management" class="list-group-item">
    <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-check"></i> <?=$lang['Chapter_q_List']?></h4>
    <p class="list-group-item-text"><?=$lang['Chapter_q_List_ex'] ?></p>
    <? $chapter_q = count($db->Query(APP_TABLES_PREFIX . 'manga_chapters_q', '*'));
    if($chapter_q > 0){ ?>
    <span class="label label-primary" style="position: relative; top: -40px; right: -320px;"><?=$chapter_q?> NEW</span>
    <? } ?>
    </a>
</div>

