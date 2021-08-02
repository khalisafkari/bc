<div class="list-hover">
  <div class="page-header">
<div class="title_doctruyen moicapnhat">
                <div class="bg leftbar3"></div>
        <div class="bg rightbar3"></div>
                <div class="centertext">
                   100 Truyện Mới Cập Nhật
<a href="/danh-sach-truyen.html" class="link_right">Xem tất cả »</a>
                </div>
            </div>
</div>
<div>
<?php
  $thisMangaList100 = $db->Query(APP_TABLES_PREFIX.'manga_mangas', array('name','released','slug','last_chapter','last_update','m_status'), array('hidden'=>0), NULL, NULL, array('last_update'=>'DESC'),100);

foreach ($thisMangaList100 as $row) {
  $row = $huy->clearXss($huy->stripSlashes($row));
?> 
    <div>
      <span data-toggle="mangapop" manga-slug="<?=$row['slug']?>" data-placement="right" data-original-title="<?=$poptitle?>" class="manga-<?=$row['m_status']?>"><b><a href="<?=$lang['manga_slug']?>-<?=$row['slug']?>.html"><?=$row['name']?></a></b></span><span class="pull-right"><i><time class="timeago" datetime="<?=$row['last_update']?>"></time></i></span>
      <br />
      <? if($row['last_chapter'] != 0){ ?><span class="blur"><a href="<?=$lang['read_slug']?>-<?=$row['slug']?>-<?=$lang['chapter_slug']?>-<?=$row['last_chapter']?>.html"><?=$row['name']?> <?=$row['last_chapter']?></a></span><? } ?>
    </div>
<? } ?>
</div>
<center style="padding-top:20px;" /><b>
  <a href="/danh-sach-truyen.html">» Xem Tất Cả Truyện »</a>
</b>
</center>
</div>
