<div class="title_doctruyen manhua">
                <div class="bg leftbar1"></div>
				<div class="bg rightbar1"></div>
                <div class="centertext">
                  manga hot nhất năm
                </div>
            </div>
<hr>
<?
$thisMangaTopList = $db->Query(APP_TABLES_PREFIX.'manga_mangas',array('*'),array('hidden'=>0),NULL,NULL,array('views'=>'DESC'),15);
$i = 0;
foreach ($thisMangaTopList as $row){
  $i += '1';
  $row = $huy->clearXss($huy->stripSlashes($row));
?> 
      	<div class="media">
		  <a class="pull-left" href="<?=$lang['manga_slug']?>-<?=$row['slug']?>.html">
		    <img class="lazy media-object img-thumb" src="/app/manga/themes/default/assets/images/lazy-load.gif" data-original="<?=$row['cover']?>?imgmax=200" alt="<?=$row['name']?>" width="100px" height="140px">
		  </a>
		  <div class="media-body">
		    <h3 class="media-heading" id="tables"><a href="<?=$lang['manga_slug']?>-<?=$row['slug']?>.html"><?=$row['name']?></a></h3>
		    <?=$lang['Views'] ?>: <?=$row['views']?> <br />
		    <?php if($row['last_chapter'] != 0){ ?><?=$lang['Last_chapter']?>: <a href="<?=$lang['read_slug']?>-<?=$row['slug']?>-<?=$lang['chapter_slug']?>-<?=$row['last_chapter']?>.html"><?=$row['last_chapter']?></a><?php } ?>
        <div class="h0rating" slug="<?=$row['slug']?>"></div>
		  </div>
		</div>
      </span>

<? }
?>