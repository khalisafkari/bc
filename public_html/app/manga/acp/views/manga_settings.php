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
			$c_manga[\'theme\'] = "'.$_POST['theme'].'";
			$c_manga[\'read_type\'] = "'.$_POST['read_type'].'";
			$c_manga[\'read_type_choose\'] = "'.$_POST['read_type_choose'].'";
			$c_manga[\'comment_type\'] = '.$comment_type.';
			$c_manga[\'fb_app\'] = "'.$_POST['fb_app'].'";
			$c_manga[\'disqus_shortname\'] = "'.$_POST['disqus_shortname'].'";

			include \'seo.php\';
			include ROOT_DIR.\'/app/manga/themes/\'.$c_manga[\'theme\'].\'/functions.php\';
			include ROOT_DIR.\'/app/manga/themes/\'.$c_manga[\'theme\'].\'/includes/options.php\';
		';
		$fp = fopen(ROOT_DIR."/app/manga/includes/settings.manga.php", "w");
		fwrite($fp, $string);
		fclose($fp);
		header('Location: app=mangaview=manga_settings');
	}
?>
 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$lang['Manga_config']?></h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<form role="form" method="POST" action="#">
	   		 <input type="hidden" name="token" value="<?=$_SESSION['token']?>">	
			 <h3><?=$lang['user-interface']?></h3>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Theme']?></label>
			  <select class="form-control" name="theme">
				<?=$h0manga->listThemes($c_manga['theme'])?>
			  </select>	
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['def_read_type']?></label>
			  <select class="form-control" name="read_type">
				<option value="1" <?=(($c_manga['read_type'] == '1') ? 'selected' : '')?>><?=$lang['Webtoon']?></option>
				<option value="2" <?=(($c_manga['read_type'] == '2') ? 'selected' : '')?>><?=$lang['Page_by_page']?></option>
				<option value="3" <?=(($c_manga['read_type'] == '3') ? 'selected' : '')?>><?=$lang['Page_by_page']?> (With touch support)</option>
			  </select>	
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['can_user_choose']?></label>
			  <select class="form-control" name="read_type_choose">
				<option value="0" <?=(($c_manga['read_type_choose'] == '0') ? 'selected' : '')?>><?=$l['No']?></option>
				<option value="1" <?=(($c_manga['read_type_choose'] == '1') ? 'selected' : '')?>><?=$l['Yes']?></option>
			  </select>	
		     </div>
			 <hr> 
			 <h3><?=$lang['comment_type']?></h3>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['comment_type']?></label> <?=$lang['Multiselect_yes']?>
			  <select class="form-control" name="comment_type[]" multiple>
				<option value="1" <?=(in_array('1', $c_manga['comment_type']) ? 'selected' : '')?>><?=$lang['Built_in']?></option>
				<option value="2" <?=(in_array('2', $c_manga['comment_type']) ? 'selected' : '')?>>Facebook</option>
			  </select>	
		     </div>
		     <div class="form-group">
			    <label for="exampleInputEmail1">Facebook APP ID</label>
			    <input type="text" class="form-control" name="fb_app" value="<?=$c_manga['fb_app']?>">
			 </div>
			  <button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
			</form>

	   	</div>
	  </div>
	</div>
 </div>	