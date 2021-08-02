<div class="topAll sidebar-topAll">
  <ul class="nav nav-tabs tabs-3 red" role="tablist">
    <li class="nav-item active" style="width: 50%">
      <a class="nav-link" data-toggle="tab" href="#yesterday" role="tab"><?=$lang['List-genre']?></a>
    </li>
    <!--li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#week" role="tab"><?=$lang['top-month']?></a>
    </li-->
    <li class="nav-item" style="width: 50%">
      <a class="nav-link" data-toggle="tab" href="#month" role="tab">Magazines</a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade in active" id="yesterday" role="tabpanel">
		<ul class="filter-type unstyled clear row">
		  <?php 
		  $thisGenre = $db->Query(APP_TABLES_PREFIX.'manga_genres', 'name, slug');
		  foreach ($thisGenre as $key => $row) {
		   ?>
		   <li class="filter-type_item col-4 text-nowrap"><a href="<?=$lang['slug_genres']?>-<?=$row['slug']?>.html"><?=$row['name']?></a></li>
		 <?php } ?>
		</ul>
    </div>
    <div class="tab-pane fade" id="month" role="tabpanel">
		<ul class="filter-type unstyled clear row">
		  <?php 
		  $thisMagazine = $db->Query(APP_TABLES_PREFIX.'manga_magazines', 'name, slug');
		  sort($thisMagazine);
		  foreach ($thisMagazine as $key => $row) {
		   ?>
		   <li class="filter-type_item col-4 text-nowrap"><a href="<?=$lang['slug_magazines']?>-<?=$row['slug']?>.html"><?=$row['name']?></a></li>
		 <?php } ?>
		</ul>
    </div>
    <div class="tab-pane fade" id="yaer" role="tabpanel">
          
    </div>
    </div>
  </div>