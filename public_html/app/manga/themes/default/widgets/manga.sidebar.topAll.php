<?php
$yesterday = date('z') - 1;
$week = date('W');
$month = date('n');
$year = date('Y');

?>
<div class="topAll sidebar-topAll">
  <ul class="nav nav-tabs tabs-3 red" role="tablist">
    <li class="nav-item active">
      <a class="nav-link" data-toggle="tab" href="#yesterday" role="tab"><?=$lang['top-yesterday']?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#week" role="tab"><?=$lang['top-week']?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#month" role="tab"><?=$lang['top-month']?></a>
    </li>
  </ul>
  <div class="tab-content card">
    <div class="tab-pane fade in active" id="yesterday" role="tabpanel">
      <br>
      <?php
      $thisMangaYT = $db->Query(APP_TABLES_PREFIX.'manga_views', array('manga','views'),array('type'=>1,'day'=>$yesterday,'year'=>$year), NULL,NULL,array('views'=>'DESC'),10);
      foreach ($thisMangaYT as $manga_views) {

        $thisMangaYesterday = $db->Query(APP_TABLES_PREFIX.'manga_mangas',array('id','name','slug','last_chapter','cover','last_update'),array('id'=>$manga_views['manga'],'hidden'=>0),NULL,NULL,NULL,10);

        foreach ($thisMangaYesterday as $manga_views_yesterday) {

          $manga_views_yesterday = $huy->clearXss($huy->stripSlashes($manga_views_yesterday));

          $cover = !empty($manga_views_yesterday['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_yesterday['cover']) : '/app/manga/themes/default/assets/images/img-404.jpg';
          $name = !empty($manga_views_yesterday['name']) ? $manga_views_yesterday['name'] : NULL;
          $slug = !empty($manga_views_yesterday['slug']) ? $manga_views_yesterday['slug'] : NULL;
          $last_chapter = !empty($manga_views_yesterday['last_chapter']) ? $manga_views_yesterday['last_chapter'] : NULL;
          $last_update = $huy->ago($manga_views_yesterday['last_update']);

          ?>
          <div class="sidebar-content" onmouseleave="out_show()" onmouseenter="show(<?=$manga_views_yesterday['id']?>)">
            <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html">
              <img src="<?=$cover?>?imgmax=70" title="<?=$name?>" width="50" height="66"></a>
              <h2>
                <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a>
              </h2>
              <div>
                <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>">Chap <?=$last_chapter?></a>
              </div><i><?=$last_update?></i><span class="label label-important"></span>
            </div>

            <?php 
          }
        }
        ?>
      </div>
      <div class="tab-pane fade" id="week" role="tabpanel">
        <br>
        <?php
        $thisMangaW = $db->Query(APP_TABLES_PREFIX.'manga_views', array('manga','views'),array('type'=>2,'week'=>$week,'year'=>$year), NULL,NULL,array('views'=>'DESC'),10);

        foreach ($thisMangaW as $manga_views) {

          $thisMangaWeek = $db->Query(APP_TABLES_PREFIX.'manga_mangas',array('id','name','slug','last_chapter','cover','last_update'),array('id'=>$manga_views['manga'],'hidden'=>0),NULL,NULL,NULL,10);

          foreach ($thisMangaWeek as $manga_views_week) {

            $manga_views_week = $huy->clearXss($huy->stripSlashes($manga_views_week));

            $cover = !empty($manga_views_week['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_week['cover']) : '/app/manga/themes/default/assets/images/img-404.jpg';
            $name = !empty($manga_views_week['name']) ? $manga_views_week['name'] : NULL;
            $slug = !empty($manga_views_week['slug']) ? $manga_views_week['slug'] : NULL;
            $last_chapter = !empty($manga_views_week['last_chapter']) ? $manga_views_week['last_chapter'] : NULL;
            $last_update = $huy->ago($manga_views_week['last_update']);


            ?>
            <div class="sidebar-content" onmouseleave="out_show()" onmouseenter="show(<?=$manga_views_week['id']?>)">
              <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html">
                <img src="<?=$cover?>" title="<?=$name?>?imgmax=70" width="50" height="66"></a>
                <h2>
                  <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a>
                </h2>
                <div>
                  <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>">Chap <?=$last_chapter?></a>
                </div><i><?=$last_update?></i><span class="label label-important"></span>
              </div>

              <?php 
            }
          }
          ?>
        </div>
        <div class="tab-pane fade" id="month" role="tabpanel">
          <br>
          <?php
        $thisMangaM = $db->Query(APP_TABLES_PREFIX.'manga_views', array('manga','views'),array('type'=>3,'month'=>$month,'year'=>$year), NULL,NULL,array('views'=>'DESC'),10);

        foreach ($thisMangaM as $manga_views) {

          $thisMangaMonth = $db->Query(APP_TABLES_PREFIX.'manga_mangas',array('id','name','slug','last_chapter','cover','last_update'),array('id'=>$manga_views['manga'],'hidden'=>0),NULL,NULL,NULL,10);

          foreach ($thisMangaMonth as $manga_views_month) {
            $manga_views_month = $huy->clearXss($huy->stripSlashes($manga_views_month));
            
            $cover = !empty($manga_views_month['cover']) ? preg_replace('#\?imgmax=.*#is', '', $manga_views_month['cover']) : '/app/manga/themes/default/assets/images/img-404.jpg';
            $name = !empty($manga_views_month['name']) ? $manga_views_month['name'] : NULL;
            $slug = !empty($manga_views_month['slug']) ? $manga_views_month['slug'] : NULL;
            $last_chapter = !empty($manga_views_month['last_chapter']) ? $manga_views_month['last_chapter'] : NULL;
            $last_update = $huy->ago($manga_views_month['last_update']);


            ?>
            <div class="sidebar-content" onmouseleave="out_show()" onmouseenter="show(<?=$manga_views_month['id']?>)">
              <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html">
                <img src="<?=$cover?>" title="<?=$name?>?imgmax=70" width="50" height="66"></a>
                <h2>
                  <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a>
                </h2>
                <div>
                  <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>">Chap <?=$last_chapter?></a>
                </div><i><?=$last_update?></i><span class="label label-important"></span>
              </div>

              <?php 
            }
          }
          ?>
          </div>
        </div>
      </div>
      <div id="pop_manga"></div>