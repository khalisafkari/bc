<?php
$week = date('W');
$month = date('n');
$year = date('Y');

?>
<style>
  img.owl-lazy.item.item-top-day {
    max-width: 100%;
    height: 185px;
    width: 130px;
  }
</style>
<div class="topAll">
  <ul class="nav nav-tabs tabs-3 red" role="tablist">
    <li class="nav-item active">
      <a class="nav-link" data-toggle="tab" href="#week" role="tab"><?=$lang['top-week']?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#month" role="tab"><?=$lang['top-month']?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#year" role="tab"><?=$lang['top-all']?></a>
    </li>
  </ul>
  <div class="tab-content card">
    <div class="tab-pane fade in active" id="week" role="tabpanel">

      <?php
      $thisMangaW = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga'),array('type' => 2,'week'=>$week,'year'=>$year),NULL,NULL,array('views'=>'DESC'),10);
      if (!empty($thisMangaW)) {
        $listManga = '';
        $listViews = array();
        for ($i=0; $i < count($thisMangaW); $i++) { 
          $listManga .= $thisMangaW[$i][manga].',';
        }
        $listManga = trim($listManga, ',');
        $thisMangaWeek = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'name, slug, last_chapter, cover, last_update', 'id IN ('.$listManga.') AND hidden = 0', null, null, null, null);

        foreach ($thisMangaWeek as $manga_views_week) {

          $manga_views_week = $huy->clearXss($huy->stripSlashes($manga_views_week));

          $cover = !empty($manga_views_week['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_week['cover']) : NULL;
          $name = !empty($manga_views_week['name']) ? $manga_views_week['name'] : NULL;
          $slug = !empty($manga_views_week['slug']) ? $manga_views_week['slug'] : NULL;
          $other_name = !empty($manga_views_week['other_name']) ? $manga_views_week['other_name'] : "Đang cập nhật";
          $last_chapter = !empty($manga_views_week['last_chapter']) ? $manga_views_week['last_chapter'] : NULL;
          $views = !empty($manga_views['views']) ? $manga_views['views'] : NULL;


          ?>
          <div class="topmonth-content">
            <img class="thumbnail pull-left lazy" src="<?=$cover?>?imgmax=150" alt="<?=$name?>" width="100" height="120" />
            <ul class="mangaW">
              <h3 class="title-h3"><a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a></h3>
              <li><p class="view"><?=$lang['View']?>: <a class="btn btn-xs btn-default"><?=$views?></a></p></li>
              <li><p class="last_update">Last Chapter: <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>" type="button" class="btn btn-xs btn-success"><?=$last_chapter?></a></p></li>
            </ul>
          </div>
          <div class="clearfix"></div>
          <hr class="hr">

          <?php 
        }
      }
      ?>
    </div>
    <div class="tab-pane fade" id="month" role="tabpanel">

      <?php
      $thisMangaM = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga'),array('type' => 3,'month'=>$month,'year'=>$year),NULL,NULL,array('views'=>'DESC'),10);
      if (!empty($thisMangaM)) {
        $listManga = '';
        for ($i=0; $i < count($thisMangaM); $i++) { 
          $listManga .= $thisMangaM[$i][manga].',';
        }
        $listManga = trim($listManga, ',');
        $thisMangaMonth = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'name, slug, last_chapter, cover, last_update', 'id IN ('.$listManga.') AND hidden = 0', null, null, null, null);

        foreach ($thisMangaMonth as $manga_views_month) {
          $manga_views_month = $huy->clearXss($huy->stripSlashes($manga_views_month));

          $cover = !empty($manga_views_month['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_month['cover']) : NULL;
          $name = !empty($manga_views_month['name']) ? $manga_views_month['name'] : NULL;
          $slug = !empty($manga_views_month['slug']) ? $manga_views_month['slug'] : NULL;
          $other_name = !empty($manga_views_month['other_name']) ? $manga_views_month['other_name'] : "Đang cập nhật";
          $last_chapter = !empty($manga_views_month['last_chapter']) ? $manga_views_month['last_chapter'] : NULL;
          $views = !empty($manga_views['views']) ? $manga_views['views'] : NULL;


          ?>
          <div class="topmonth-content">
            <img class="thumbnail pull-left lazy" src="<?=$cover?>?imgmax=150" alt="<?=$name?>" width="100" height="120" />
            <ul class="mangaW">
              <h3 class="title-h3"><a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a></h3>
              <li><p class="view"><?=$lang['View']?>: <a class="btn btn-xs btn-default"><?=$views?></a></p></li>
              <li><p class="last_update">Last chapter: <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>" type="button" class="btn btn-xs btn-success"><?=$last_chapter?></a></p></li>
            </ul>
          </div>
          <div class="clearfix"></div>
          <hr class="hr">

          <?php 
        }
      }
      ?>
    </div>
    <div class="tab-pane fade" id="year" role="tabpanel">
      <br>
      <?php

      $thisMangaYear = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('hidden'=>0),NULL,NULL,array('views'=>'DESC'),15);

      foreach ($thisMangaYear as $manga_views_year) {
        $manga_views_year = $huy->clearXss($huy->stripSlashes($manga_views_year));

        $cover = !empty($manga_views_year['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_year['cover']) : NULL;
        $name = !empty($manga_views_year['name']) ? $manga_views_year['name'] : NULL;
        $slug = !empty($manga_views_year['slug']) ? $manga_views_year['slug'] : NULL;
        $other_name = !empty($manga_views_year['other_name']) ? $manga_views_year['other_name'] : "Đang cập nhật";
        $last_chapter = !empty($manga_views_year['last_chapter']) ? $manga_views_year['last_chapter'] : NULL;
        $views = !empty($manga_views_year['views']) ? $manga_views_year['views'] : NULL;

        ?>

        <div class="topmonth-content">
          <img class="thumbnail pull-left lazy" src="<?=$cover?>?imgmax=150" alt="<?=$name?>" width="100" height="120" />
          <ul class="mangaW">
            <h3 class="title-h3"><a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a></h3>
            <li><p class="view"><?=$lang['View']?>: <a class="btn btn-xs btn-default"><?=$views?></a></p></li>
            <li><p class="last_update">Last chapter: <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>" type="button" class="btn btn-xs btn-success"><?=$last_chapter?></a></p></li>
          </ul>
        </div>
        <div class="clearfix"></div>
        <hr class="hr">

        <?php 
      }
      ?>
    </div>
  </div>
</div>