<div class="card card-dark">
  <div class="card-header"><h3 class="card-title"><?=$lang['List-genre']?></h3></div>
  <div class="card-body bg-dark">
    <ul class="filter-type unstyled clear row">
      <?php 
      $thisGenre = $db->Query(APP_TABLES_PREFIX.'manga_genres', 'name, slug');
      foreach ($thisGenre as $key => $row) {
       ?>
       <li class="filter-type_item col-4 text-nowrap"><a href="<?=$lang['slug_genres']?>-<?=$row['slug']?>.html"><?=$row['name']?></a></li>
     <?php } ?>
   </ul>
 </div>
</div>
