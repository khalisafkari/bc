<?php
	include ROOT_DIR."/app/manga/includes/rss.php";
 	if(!$user->isAdmin()){ header('Location: ../index.html'); }
	if($_POST && $_POST['token'] == $_SESSION['token']){
		
		$string = '<?php
			$c_manga[\'rss_title\'] = "'.$_POST['rss_title'].'";
			$c_manga[\'rss_description\'] = "'.$_POST['rss_description'].'";
			$c_manga[\'rss_url\'] = "'.$_POST['rss_url'].'";
			$c_manga[\'rss_item\'] = "'.$_POST['rss_item'].'";
			
		';
		$fp = fopen(ROOT_DIR."/app/manga/includes/rss.php", "w");
		fwrite($fp, $string);
		fclose($fp);
		header('Location: app=mangaview=manga_rss');
	}
?>
 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$lang['RSS_config']?></h3>
	  </div>
	  <?=$user->alert('info','Your rss url is: http://yoursite.com/manga-rss.rss')?>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<form role="form" method="POST" action="#">
	   		 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">	
		     <div class="form-group">
		     <label for="exampleInputEmail1">RSS Title</label> 
		      <input class="form-control" type="text" name="rss_title" value="<?=$c_manga['rss_title']?>">
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">RSS Description</label>
		      <textarea class="form-control" id="rss-description" name="rss_description"><?=$c_manga['rss_description']?></textarea>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Your site url (End with slash)</label>
		      <input class="form-control" type="text" name="rss_url" value="<?=$c_manga['rss_url']?>" placeholder="http://example.com/">
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Number of RSS item (15 to 30 is ideal)</label>
		      <input class="form-control" type="number" name="rss_item" value="<?=$c_manga['rss_item']?>">
		     </div>

			  <button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
			</form>

	   	</div>
	  </div>
	</div>
 </div>	

 	<script>
 	var options3 = {  
	    'maxCharacterSize': 150,  
	    'originalStyle': 'originalDisplayInfo',  
	    'warningStyle': 'warningDisplayInfo',    
	    'warningNumber': 40,  
	    'displayFormat': '#input/#max | #words Words'  
	};  
 		$('#rss-description').textareaCount(options3, function(data){    });  
 	</script>