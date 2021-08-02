 <? if(!$user->isAdmin()){ header('Location: ../index.html'); } ?>
  <? $mid = isset($_GET['mid']) ? (int)$_GET['mid'] : NULL;
  if (empty($mid)) {
  	header('Location: ../index.html'); 
  }
 	?>
 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Delete Manga</h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<div id="editManga_output"></div>
	  <form action="../app/manga/controllers/cont.deleteManga.php?mid=<?=$mid?>" method="post">
		<button type="submit" name="delete" class="btn btn-primary" /><span class="glyphicon glyphicon-plus"></span> Comfirm</button>
		<a href="/" class="btn btn-primary"><span class="glyphicon glyphicon-minus"></span> Cancel</a>
		
	</form>
	</div>
	</div>
	</div>
	</div>
	
	  