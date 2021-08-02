<?php 
	
		if(!$user->isAdmin()){ header('Location: ../index.html'); } 
		$file = isset($_GET['file']);
		if($file == NULL){ $file = 'main'; }
			if(isset($_POST) && isset($_POST['action']) == 'clear_cache'){
			$caches = scandir(ROOT_DIR.'/caches'); // get all file names
			foreach($caches as $cache){ // iterate files
			  if(is_file(ROOT_DIR.'/caches/'.$cache))
			    unlink(ROOT_DIR.'/caches/'.$cache); // delete file
			}
		}
		
?>

 <div class="col-lg-8">
 	<div class="well well-sm">
 		<blockquote>Visit <A href="https://lovehug.net">LoveHug.net</a> for more widgets (And how to add them in your site, too)</blockquote>
 		Make sure you delete cache after any changes.
 		<form method="POST" action="app=mangaview=themes_editor">
 			<input type="hidden" name="action" value="clear_cache">
 			<button type="submit" class="btn btn-xs btn-danger">Clear cache</button>
 		</form>
 	</div>
 </div>	
 <div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
		    <h3 class="panel-title"><a href="app=mangaview=themes_editor">Editor</a> / <strong><?php echo $file; ?></strong></h3>
		</div>
		<div class="panel-body">

		  <?php	//include ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/editor/'.$file.'.php'; ?>

		</div>
	</div>
</div>