<div class="topweek">
  <div class="title_doctruyen manga">
                  <div class="bg left_bar"></div>
          <div class="bg rightbar"></div>
                  <div class="centertext">
                      manga hot nhất tuần
                  </div>
              </div>

<?php
$week = date('W');
$year = date('Y');

$thisMangaWeek = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga','views'),array('type'=>2,'week'=>$week,'year'=>$year),NULL,NULL,array('views'=>'DESC'),15);
foreach ($thisMangaWeek as $manga_views) {
$thisMangaWeekViews = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('id'=>$manga_views['manga'],'hidden'=>0), NULL,NULL,NULL,10);
foreach ($thisMangaWeekViews as $manga_views_week) {
  
  $manga_views_week = $huy->clearXss($huy->stripSlashes($manga_views_week));

  $cover = !empty($manga_views_week['cover']) ? $manga_views_week['cover'] : NULL;
  $other_name = !empty($manga_views_week['other_name']) ? $manga_views_week['other_name'] : "Đang cập nhật";
  $slug = !empty($manga_views_week['slug']) ? $manga_views_week['slug'] : NULL;
  $name = !empty($manga_views_week['name']) ? $manga_views_week['name'] : NULL;
  $genres = !empty($manga_views_week['genres']) ? $manga_views_week['genres'] : "Đang cập nhật";
  $authors = !empty($manga_views_week['authors']) ? $manga_views_week['authors'] : "Đang cập nhật";
  $m_status = !empty($manga_views_week['m_status']) ? $manga_views_week['m_status'] : NULL; 
  $description = !empty($manga_views_week['description']) ? strip_tags(stripslashes(substr($manga_views_week['description'], 0, 290))).'....' : "Đang cập nhật";
  $released = !empty($manga_views_week['released']) ? $manga_views_week['released'] : "Đang cập nhật";
  $last_chapter = !empty($manga_views_week['last_chapter']) ? $manga_views_week['last_chapter'] : NULL;
  $views = !empty($manga_views['views']) ? $manga_views['views'] : NULL;


?>

  <div class="topweek-thumbnail">
    <img class="lazy thumbnail pull-left" src="/app/manga/themes/default/assets/images/lazy-load.gif" data-original="<?=$cover?>?imgmax=300" alt ="<?=$name?>">
  </div>
  <div class="content-topweek">
    <ul class="mangaW">
  <div class="topweek-name h2">
    <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html"><?=$name?></a>
  </div>
  <div class="topweek-othername">
    <blockquote style="margin: 0; padding: 0"><small><?=$other_name?></small></blockquote>
  </div>
  <div class="topweek-author">
    <li><b>Tác giả</b>: <?=$h0manga->splitAuthors($authors,$lang['author_slug'])?></li>
  </div>
  <div class="topweek-status">
    <li><b>Tình trạng</b>: <?=$h0manga->status($m_status)?></li>
  </div>
  <div class="topweek-genres">
  <small>
     <b>Thể Loại</b>: <?=$h0manga->splitGenres($genres,$lang)?><br />
  </small>
  </div>
  <div class="topweek-last_chapter">
    <li><b>Chap cuối</b>: <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>" type="button" class="btn btn-xs btn-warning"><?=$last_chapter?></a></li>
  </div>
  <div class="topweek-description">
    <li><b>Mô Tả</b>: <?=$description?><br /></li>
  </div>
  <br />
  <div class="topweek-btn">
     <div class="btn-group">
      <a href="<?php echo $lang['manga_slug'].'-'.$slug; ?>.html" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-list"></i> Tất cả Chap</a>
      <a href="<?php echo $lang['read_slug'].'-'.$slug.'-'.$lang['chapter_slug'].'-'.$last_chapter.'.html';?>" type="button" class="btn btn-success"><i class="glyphicon glyphicon-star-empty"></i>Chap Cuối: <?=$last_chapter?></a>
      <button type="button" class="btn btn-primary disabled"><i class="glyphicon glyphicon-eye-open"></i> Lượt xem trong tuần: <?=$views?></button>
    </div>
  </div>
    </ul>
  </div>
  <div class="clearfix"></div>
  <hr>
  
<?php }
}
?>
</div>