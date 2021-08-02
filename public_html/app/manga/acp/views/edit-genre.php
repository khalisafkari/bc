<?php if(!($user->isAdmin() || $user->isMod()) || empty($_GET['id'])){ header('Location: ../index.html'); }

$id = (int)$_GET['id'];
$thisGenre = $db->Query(APP_TABLES_PREFIX.'manga_genres', '*', array('id' => $id));

?>
<div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?=$lang['Edit_genre']?></h3>
		</div>
		<div class="panel-body">
			<div id="UserTableContainer" style="width: 100%;">
				<div id="addManga_output"></div>
				<form id="addManga_form" role="form" method="POST" action="../app/manga/controllers/cont.editGenre.php">
					<input type="hidden" name="id" id="inputId" class="form-control" value="<?=$_GET['id']?>">
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
						<input type="text" class="form-control" id="name" name="name" value="<?=$thisGenre[0]['name']?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Slug']?></label>
						<div class="form-group">
							<input type="text" class="form-control" id="genreSlug" name="slug" value="<?=$thisGenre[0]['slug']?>">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Content']?></label>
						<textarea class="form-control" name="content" id="content" cols="100%" rows="8" placeholder="Description" value="<?=$thisGenre[0]['content']?>"></textarea>
						<?=$lang['Content_ex']?>
					</div>
					<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
				</form>

			</div>
		</div>
	</div>
</div>	
<!-- AUTO SLUG -->
<script>
	$(document).ready(function() {
	});
	$( "#name" ).change(function() {
		$.post('../app/manga/controllers/cont.autoSlug.php', { slug: $( "#name" ).val() },
			function(data) {
				$("#genreSlug").val(data);
			});
	});
</script>
<?=$user->ajaxForm('addManga','app=mangaview=genre_management')?>
