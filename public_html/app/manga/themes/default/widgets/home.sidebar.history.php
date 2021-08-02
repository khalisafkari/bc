<?php
$data = json_decode($_COOKIE['history'], true);
?>
<div class="list-genres">
  <div class="panel panel-default">
    <div class="title_doctruyen manga">
      <div class="centertext"><?=$lang['history']?>
      <a href="/manga-list.html?history=1" class="link_right"><?=$lang['View_all']?> »</a></div>
    </div>
    <div class="tab-pane fade in">
      <?php
      if ($_COOKIE['history']) {
        $i = 1;
        foreach ($data as $manga => $chapter) {
          $thisManga = $db->Query(APP_TABLES_PREFIX.'manga_mangas', 'name, slug, cover', array('id'=>$manga), null, null, null, null);
          $thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'chapter', array('id'=>$chapter), null, null, null, null);
          ?>
          <div class="sidebar-content" style="display:inline-block;" id="<?=$manga?>">
            <a href="<?php echo $lang['manga_slug'].'-'.$thisManga[0]['slug']; ?>.html">
              <img src="<?=$thisManga[0]['cover']?>?imgmax=70" title="<?=$name?>" width="50" height="66"></a>

              <h2><a href="<?php echo $lang['manga_slug'].'-'.$thisManga[0]['slug']; ?>.html"><?=$thisManga[0]['name']?></a><button onclick="delete_manga(<?=$manga?>)" type="button" class="btn btn-danger pull-right btn-xs"><i class="fa fa-times"></i> <i><?=$lang['Delete']?></i></button></h2>
              <div>
                <a href="<?php echo $lang['read_slug'].'-'.$thisManga[0]['slug'].'-'.$lang['chapter_slug'].'-'.$thisChapter[0]['chapter'].'.html';?>"><i class="fa fa-angle-double-right"></i> <i><?=$lang['continue']?> <?=$thisChapter[0]['chapter']?></i></a>
              </div><i></i><span class="label label-important"></span>
            </div>
            <?php
            $i++;
            if ($i > 10) {
              break;
            }
          }
        }
        ?>
      </div>
    </div>
  </div>
  <script>
    function delete_manga(manga) {
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", "/app/manga/controllers/cont.deleteManga.php?id=" + manga, true);
      xhttp.send();
      var el = document.getElementById(manga);
      el.parentNode.removeChild(el);
    }
  </script>
  <style>
  .manga .centertext {
    padding-left: 10px;
  }
</style>