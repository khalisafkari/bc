<div class="topmonth">
  <div class="title_doctruyen manhua" style="margin-top: 10px;">
                  <div class="bg leftbar1"></div>
  				<div class="bg rightbar1"></div>
                  <div class="centertext">
                    manga hot nhất tháng
                  </div>
              </div>

<?php
$month = date('n');
$year = date('Y');
$thisManga = $db->Query(APP_TABLES_PREFIX.'manga_views', array('manga','views'),array('type'=>3,'month'=>$month,'year'=>$year), NULL,NULL,array('views'=>'DESC'),15);

foreach ($thisManga as $manga_views) {

  $thisMangaMonth = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('id'=>$manga_views['manga'],'hidden'=>0),NULL,NULL,NULL,15);

  foreach ($thisMangaMonth as $manga_views_month) {
    $manga_views_month = $huy->clearXss($huy->stripSlashes($manga_views_month));
    
    $cover = !empty($manga_views_month['cover']) ? $manga_views_month['cover'] : NULL;
    $name = !empty($manga_views_month['name']) ? $manga_views_month['name'] : NULL;
    $slug = !empty($manga_views_month['slug']) ? $manga_views_month['slug'] : NULL;
    $other_name = !empty($manga_views_month['other_name']) ? $manga_views_month['other_name'] : "Đang cập nhật";
    $last_chapter = !empty($manga_views_month['last_chapter']) ? $manga_views_month['last_chapter'] : NULL;
    $views = !empty($manga_views['views']) ? $manga_views['views'] : NULL;


?>
  <div class="topmonth-thumbnail">
    <img class="lazy thumbnail pull-left" src="/app/manga/themes/default/assets/images/lazy-load.gif" data-original="<?=$cover?>?imgmax=200" alt="<?=$name?>" width="100" height="140" />
  </div>
  <div class="topmonth-content">
  <ul class="mangaW">
      <h3 class="title-h3"><a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a></h3>
      <blockquote style="margin: 0; padding: 0"><small><?=$other_name?></small></blockquote>
      <li><p class="view">Lượt xem: <a class="btn btn-xs btn-default"><?=$views?></a></p></li>
      <li><p class="last_update">Chap cuối: <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>" type="button" class="btn btn-xs btn-success"><?=$last_chapter?></a></p></li>
  </ul>
  </div>
<div class="clearfix"></div>
<hr>

<?php 
  }
}
?>
</div>