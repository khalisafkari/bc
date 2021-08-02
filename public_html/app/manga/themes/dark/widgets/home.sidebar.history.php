<?php
$data = json_decode($_COOKIE['history'], true);
?>
<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fa fa-clock-o" aria-hidden="true"></i>  &nbsp; 
      <?=$lang['Reading-history']?>
    </h3>
    <div class="tiny-text"><a href="/manga-list.html?history=1" class="link_right"><?=$lang['View_all']?> »</a></div>

  </div>
  <div class="row-last-update">
    <?php
    if ($_COOKIE['history']) {
      $i = 1;
      foreach ($data as $manga => $chapter) {
        $thisManga = $db->Query(APP_TABLES_PREFIX.'manga_mangas', 'id, name, cover', array('id'=>$manga), null, null, null, null);
        $thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'chapter', array('id'=>$chapter), null, null, null, null);
        ?>
        <div class="sidebar-content" style="display:inline-block;" id="<?=$manga?>">
          <a href="/<?=$thisManga[0]['id']?>/">
            <img src="<?=$thisManga[0]['cover']?>?imgmax=70" title="<?=$name?>" width="50" height="66"></a>
            <h2><a href="/<?=$thisManga[0]['id']?>/"><?=$thisManga[0]['name']?></a></h2>
            <button onclick="delete_manga(<?=$manga?>)" type="button" class="btn btn-default pull-right btn-xs"><i class="fa fa-times"></i> <i><?=$lang['Delete']?></i></button>
            <div>
              <a href="/<?=$thisManga[0]['id']?>/<?=$chapter?>/"><i class="fa fa-angle-double-right"></i> <i><?=$lang['continue']?> <?=$thisChapter[0]['chapter']?></i></a>
            </div><i></i><span class="label label-important"></span>
          </div>
          <?php
          $i++;
          if ($i > 5) {
            break;
          }
        }
      }
      ?>
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