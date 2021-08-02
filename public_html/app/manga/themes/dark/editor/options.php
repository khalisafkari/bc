<?
	$filename = ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/includes/options.php';
	$handle = fopen($filename, "rb");
	$content_old = fread($handle, filesize($filename));
	fclose($handle);

  	if(!$user->isAdmin()){ header('Location: ../index.html'); } 

	if($_POST){
	$content = $_POST['content'];
	chmod (ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/includes/options.php', 0777);
	$fp = fopen(ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/includes/options.php', "w");
	fwrite($fp, stripslashes($content));
	fclose($fp);
	chmod (ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/includes/options.php', 0644);
	$huy->redirect('app=mangaview=themes_options');
	
	}
?>
<div class="col-lg-8">
	<div class="well">
	  <form class="bs-example form-horizontal" method="POST" action="#">
		<fieldset>
		  <legend><?=$lang['Theme-options'];?></legend>
		  Hãy cẩn thận với nội dung bạn chỉnh sửa trong, bất kỳ dấu phẩy còn thiếu sẽ gây ra vấn đề.<br />
		  <div class="form-group">
			<div class="col-lg-12">
			  <textarea class="form-control" rows="20" id="textArea" name="content"><?=$content_old?></textarea>
			</div>
		  </div>		 
		  <div class="form-group">
			<div class="col-lg-12">
			  <button type="submit" class="btn btn-primary"><?=$lang['Submit']?></button> 
			</div>
		  </div>
		</fieldset>
	  </form>
	</div>
  </div>
  