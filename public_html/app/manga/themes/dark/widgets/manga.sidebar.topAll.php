<?php
$day = date('z');
$week = date('W');
$month = date('n');
$year = date('Y');

?>

<center><a href="https://canthooto.com/hyundai-can-tho" target="_blank">
	<img src="https://s4.ihlv1.xyz/images2/20210627/ads_60d806390070a.jpg"></img>
</a></center>
</br>
<div class="topAll sidebar-topAll">
  <ul class="nav nav-tabs tabs-3 red" role="tablist">
    <li class="nav-item active" style="width: 50%">
      <a class="nav-link" data-toggle="tab" href="#yesterday" role="tab"><?=$lang['top-day']?></a>
    </li>
    <!--li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#week" role="tab"><?=$lang['top-month']?></a>
    </li-->
    <li class="nav-item" style="width: 50%">
      <a class="nav-link" data-toggle="tab" href="#month" role="tab"><?=$lang['top-all']?></a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade in active" id="yesterday" role="tabpanel">
      <?php
      $thisMangaD = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga'),array('type' => 1,'day'=>$day,'year'=>$year),NULL,NULL,array('views'=>'DESC'),5);
      if (!empty($thisMangaD)) {
        $listManga = '';
        for ($i=0; $i < count($thisMangaD); $i++) { 
          $listManga .= $thisMangaD[$i][manga].',';
        }
        $listManga = trim($listManga, ',');
        $thisMangaDay = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'name, id, last_chapter, cover, last_update', 'id IN ('.$listManga.') AND hidden = 0', null, null, null, null);

        foreach ($thisMangaDay as $manga_views_yesterday) {

          $manga_views_yesterday = $huy->clearXss($huy->stripSlashes($manga_views_yesterday));

          $cover = !empty($manga_views_yesterday['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_yesterday['cover']) : '/app/manga/themes/dark/assets/images/img-404.jpg';
          $name = !empty($manga_views_yesterday['name']) ? $manga_views_yesterday['name'] : NULL;
          $slug = !empty($manga_views_yesterday['slug']) ? $manga_views_yesterday['slug'] : NULL;
          $last_chapter = !empty($manga_views_yesterday['last_chapter']) ? $manga_views_yesterday['last_chapter'] : NULL;
          $last_update = $huy->ago($manga_views_yesterday['last_update']);

          ?>
          <div class="sidebar-content">
            <a href="/<?=$manga_views_yesterday['id']?>/">
              <img src="<?=$cover?>?imgmax=70" title="<?=$name?>" width="50" height="66"></a>
              <h2>
                <a href="/<?=$manga_views_yesterday['id']?>/"><?=$name?></a>
              </h2>
              <div>
                <a href="/<?=$manga_views_yesterday['id']?>/<?=$h0manga->chapter_id($manga_views_yesterday['id'], $last_chapter)?>/">Chap <?=$last_chapter?></a>
              </div><i><?=$last_update?></i><span class="label label-important"></span>
            </div>

            <?php 
          }
        }
        ?>
      </div>
      <div class="tab-pane fade" id="month" role="tabpanel">
        <?php
        $thisMangaM = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga'),array('type' => 3,'month'=>$month,'year'=>$year),NULL,NULL,array('views'=>'DESC'),5);
        if (!empty($thisMangaM)) {
          $listManga = '';
          for ($i=0; $i < count($thisMangaM); $i++) { 
            $listManga .= $thisMangaM[$i][manga].',';
          }
          $listManga = trim($listManga, ',');
          $thisMangaMonth = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'name, id, last_chapter, cover, last_update', 'id IN ('.$listManga.') AND hidden = 0', null, null, null, null);

          foreach ($thisMangaMonth as $manga_views_month) {
            $manga_views_month = $huy->clearXss($huy->stripSlashes($manga_views_month));

            $cover = !empty($manga_views_month['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_month['cover']) : '/app/manga/themes/dark/assets/images/img-404.jpg';
            $name = !empty($manga_views_month['name']) ? $manga_views_month['name'] : NULL;
            $slug = !empty($manga_views_month['slug']) ? $manga_views_month['slug'] : NULL;
            $last_chapter = !empty($manga_views_month['last_chapter']) ? $manga_views_month['last_chapter'] : NULL;
            $last_update = $huy->ago($manga_views_month['last_update']);


            ?>
            <div class="sidebar-content">
              <a href="/<?=$manga_views_month['id']?>/">
                <img src="<?=$cover?>" title="<?=$name?>?imgmax=70" width="50" height="66"></a>
                <h2>
                  <a href="/<?=$manga_views_month['id']?>/"><?=$name?></a>
                </h2>
                <div>
                  <a href="/<?=$manga_views_month['id']?>/<?=$h0manga->chapter_id($manga_views_month['id'], $last_chapter)?>/">Chap <?=$last_chapter?></a>
                </div><i><?=$last_update?></i><span class="label label-important"></span>
              </div>

              <?php 
            }
          }
          ?>
        </div>
        <div class="tab-pane fade" id="yaer" role="tabpanel">
          <?php
          $thisMangaYear = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('hidden'=>0),NULL,NULL,array('views'=>'DESC'),5);

          foreach ($thisMangaYear as $manga_views_year) {
            $manga_views_year = $huy->clearXss($huy->stripSlashes($manga_views_year));

            $cover = !empty($manga_views_year['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_year['cover']) : '/app/manga/themes/dark/assets/images/img-404.jpg';
            $name = !empty($manga_views_year['name']) ? $manga_views_year['name'] : NULL;
            $slug = !empty($manga_views_year['slug']) ? $manga_views_year['slug'] : NULL;
            $last_chapter = !empty($manga_views_year['last_chapter']) ? $manga_views_year['last_chapter'] : NULL;
            $last_update = $huy->ago($manga_views_year['last_update']);


            ?>
            <div class="sidebar-content">
              <a href="/<?=$manga_views_year['id']?>/">
                <img src="<?=$cover?>" title="<?=$name?>?imgmax=70" width="50" height="66"></a>
                <h2>
                  <a href="/<?=$manga_views_year['id']?>/"><?=$name?></a>
                </h2>
                <div>
                  <a href="/<?=$manga_views_year['id']?>/<?=$h0manga->chapter_id($manga_views_year['id'], $last_chapter)?>/">Chap <?=$last_chapter?></a>
                </div><i><?=$last_update?></i><span class="label label-important"></span>
              </div>

              <?php
            }
            ?>
          </div>
        </div>
      </div>