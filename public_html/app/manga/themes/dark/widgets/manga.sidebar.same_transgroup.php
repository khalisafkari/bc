<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
     <i class="fa fa-book" aria-hidden="true"></i>  &nbsp; 
      Manga Same Magazine
    </h3>
  </div>
  <div class="card-body bg-dark">
    <ul class="others-list">
      <?php 
      $thisMangaSameTransgroup = $db->Query(APP_TABLES_PREFIX.'manga_mangas', 'id, name, description, cover', 'magazines LIKE \'%'.$thisManga['magazines'].'%\' ORDER BY RAND()', null, null, null, 3) ;
      foreach ($thisMangaSameTransgroup as $key => $row) {
        ?>
        <li>
          <div class="others-img no-padding">
            <div class="a6-ratio">
              <div class="content img-in-ratio" style="background-image: url('<?=$row['cover']?>')"></div>
            </div>
          </div>
          <div class="others-info">
            <h5 class="others-name">
              <a href="/<?=$row['id']?>/"><?=$row['name']?></a>
            </h5>
            <!--small class="series-summary"><--?=substr(strip_tags($row['description']),  0, 50).'...'?></small-->
          </div>
        </li>
        <?php
      }
      ?>
    </ul>
  </div>
</div>