<? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>
<div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Add Magazine</h3>
		</div>
		<div class="panel-body">
			<div id="UserTableContainer" style="width: 100%;">
				<div id="addManga_output"></div>
				<form id="addManga_form" role="form" method="POST" action="../app/manga/controllers/cont.addMagazine.php">
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
						<input type="text" class="form-control" id="name" name="name">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Slug']?></label>
						<div class="form-group">
							<input type="text" class="form-control" id="magazineSlug" name="slug">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Content']?></label>
						<textarea class="form-control" name="content" id="content" cols="100%" rows="8" placeholder="Description"></textarea>
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
				$("#magazineSlug").val(data);
			});
	});
</script>
<?=$user->ajaxForm('addManga','app=mangaview=magazine_management')?>