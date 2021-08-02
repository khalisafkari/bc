<?php
 	if(!$user->isAdmin()){ header('Location: ../index.html'); }
	if($_POST && $_POST['token'] == $_SESSION['token']){
			
			// Handle comment type
			$comment_type = 'array(';
			foreach($_POST['comment_type'] as $key){
				$comment_type .= "'$key',";
			}
			$comment_type .= ')';
		
		$string = '<?php
			$c_manga[\'site_title\'] = "'.$_POST['site_title'].'";
			$c_manga[\'rel_author\'] = "'.$_POST['rel_author'].'";
			$c_manga[\'home_title\'] = "'.$_POST['home_title'].'";
			$c_manga[\'home-meta-keyword\'] = "'.$_POST['home-meta-keyword'].'";
			$c_manga[\'home-meta-description\'] = "'.$_POST['home-meta-description'].'";
			$c_manga[\'manga_title\'] = "'.$_POST['manga_title'].'";
			$c_manga[\'manga-meta-keyword\'] = "'.$_POST['manga-meta-keyword'].'";
			$c_manga[\'manga-meta-description\'] = "'.$_POST['manga-meta-description'].'";
			$c_manga[\'chapter_title\'] = "'.$_POST['chapter_title'].'";
			$c_manga[\'chapter-meta-keyword\'] = "'.$_POST['chapter-meta-keyword'].'";
			$c_manga[\'chapter-meta-description\'] = "'.$_POST['chapter-meta-description'].'";
			$c_manga[\'list_title\'] = "'.$_POST['list_title'].'";
			$c_manga[\'list-meta-keyword\'] = "'.$_POST['list-meta-keyword'].'";
			$c_manga[\'list-meta-description\'] = "'.$_POST['list-meta-description'].'";
		';
		$fp = fopen(ROOT_DIR."/app/manga/includes/seo.php", "w");
		fwrite($fp, $string);
		fclose($fp);
		header('Location: app=mangaview=manga_seo');
	}
?>
 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$lang['SEO_config']?></h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<form role="form" method="POST" action="#">
	   		 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">	
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Site_title']?></label>
		      <input class="form-control" type="text" name="site_title" value="<?=$c_manga['site_title']?>">
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Author rel (Link to your google+ account)</label>
		      <input class="form-control" type="text" name="rel_author" value="<?=$c_manga['rel_author']?>">
		     </div>

		     <hr>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Home_title']?></label> <?=$lang['Available']?>: {site_title}
		      <input class="form-control" type="text" name="home_title" value="<?=$c_manga['home_title']?>">
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Home page meta keyword</label>
		      <textarea class="form-control" id="home-meta-keyword" name="home-meta-keyword"><?=$c_manga['home-meta-keyword']?></textarea>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Home page meta description</label>
		      <textarea class="form-control" id="home-meta-description" name="home-meta-description"><?=$c_manga['home-meta-description']?></textarea>
		     </div>

		     <hr>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Manga_title']?></label> <?=$lang['Available']?>: {site_title}, {manga_name}, {manga_other_name}
		      <input class="form-control" type="text" name="manga_title" value="<?=$c_manga['manga_title']?>"> 
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Manga page meta keyword</label> <br /><?=$lang['Available']?>: {manga_name}, {manga_genre}, {manga_other_name}
		      <textarea class="form-control" id="manga-meta-keyword" name="manga-meta-keyword"><?=$c_manga['manga-meta-keyword']?></textarea>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Manga page meta description</label> <br /><?=$lang['Available']?>: {manga_name}, {manga_other_name}
		      <textarea class="form-control" id="manga-meta-description" name="manga-meta-description"><?=$c_manga['manga-meta-description']?></textarea>
		     </div>

		     <hr>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Chapter_title']?></label> <?=$lang['Available']?>: {site_title}, {manga_name}, {manga_other_name}, {chapter_number}, {chapter_name}, {next_chapter}, {prev_chapter}
		      <input class="form-control" type="text" name="chapter_title" value="<?=$c_manga['chapter_title']?>"> 
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Chapter page meta keyword</label> <br /><?=$lang['Available']?>: {manga_name}, {manga_genre},, {manga_other_name}, {chapter_number}, {chapter_name}, {next_chapter}, {prev_chapter}
		      <textarea class="form-control" id="chapter-meta-keyword" name="chapter-meta-keyword"><?=$c_manga['chapter-meta-keyword']?></textarea>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Chapter page meta description</label> <br /><?=$lang['Available']?>: {manga_name}, {manga_other_name}, {chapter_number}, {chapter_name}, {next_chapter}, {prev_chapter}
		      <textarea class="form-control" id="chapter-meta-description" name="chapter-meta-description"><?=$c_manga['chapter-meta-description']?></textarea>
		     </div>

		     <hr>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['List_title']?></label> <?=$lang['Available']?>: {site_title}
		      <input class="form-control" type="text" name="list_title" value="<?=$c_manga['list_title']?>"> 
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Manga list page meta keyword</label> <br />
		      <textarea class="form-control" id="list-meta-keyword" name="list-meta-keyword"><?=$c_manga['list-meta-keyword']?></textarea>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Manga list page meta description</label> <br />
		      <textarea class="form-control" id="list-meta-description" name="list-meta-description"><?=$c_manga['list-meta-description']?></textarea>
		     </div>
		     <hr>
			  <button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
			</form>

	   	</div>
	  </div>
	</div>
 </div>	

 	<script>
 	var options3 = {  
	    'maxCharacterSize': 160,  
	    'originalStyle': 'originalDisplayInfo',  
	    'warningStyle': 'warningDisplayInfo',    
	    'warningNumber': 40,  
	    'displayFormat': '#input/#max | #words Words'  
	};  
 		$('#home-meta-keyword').textareaCount(options3, function(data){    });  
		$('#home-meta-description').textareaCount(options3, function(data){    });  
 		$('#manga-meta-keyword').textareaCount(options3, function(data){    });  
		$('#manga-meta-description').textareaCount(options3, function(data){    });  
 		$('#chapter-meta-keyword').textareaCount(options3, function(data){    });  
		$('#chapter-meta-description').textareaCount(options3, function(data){    });  
 	</script>