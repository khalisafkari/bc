<? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); }
$mid = isset($_GET['mid']) ? (int)$_GET['mid'] : NULL; 
$query = $db->Query(APP_TABLES_PREFIX . 'manga_mangas','*',array('id'=>$mid));
$thisManga = $query[0];
$thisGroup = $db->Query(APP_TABLES_PREFIX. 'manga_groups', array('id', 'name'));
$count = count($thisGroup);
$thisGroup[$count][id] = '';
$thisGroup[$count]['name'] = 'Emty group';
$group_uploader = array_reverse($thisGroup);
?>
<div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Manga</h3>
		</div>
		<div class="panel-body">
			<div id="UserTableContainer" style="width: 100%;">
				<div id="editManga_output"></div>
				<form id="editManga_form" role="form" method="POST" action="../app/manga/controllers/cont.editManga.php?mid=<?=$mid?>">
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
						<input type="text" class="form-control" name="name" value="<?=stripslashes($thisManga['name'])?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['manga_name_ex']?></label>
						<input type="text" class="form-control" name="slug" value="<?=stripslashes($thisManga['slug'])?>" readonly>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Other_name']?></label>
						<input type="text" class="form-control" name="other_name" value="<?=stripslashes($thisManga['other_name'])?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Authors']?></label>
						<input type="text" class="form-control" name="authors" placeholder="<?=$lang['Authors_ex']?>" value="<?=$thisManga['authors']?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Artists']?></label>
						<input type="text" class="form-control" name="artists" placeholder="<?=$lang['Artists_ex']?>" value="<?=$thisManga['artists']?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Released']?></label>
						<input type="text" class="form-control" name="released" value="<?=$thisManga['released']?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Genres']?></label>
						<select name="genres[]" data-placeholder="<?=$lang['Genres_ex']?>" class="js-select2" multiple tabindex="4">
							<option value=""></option>
							<?php
							$genresArray = explode(',', $thisManga['genres']);
							foreach ($genresArray as $key => &$value) {
								$value = strtolower($value);
							}
							foreach ($h0manga->listGenres() as $row) {
								if (in_array($row['slug'], $genresArray)) {
									echo '<option value="'.$row['slug'].'" selected>'.$row['name'].'</option>';
								} else {
									echo '<option value="'.$row['slug'].'">'.$row['name'].'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Magazine</label>
						<select name="magazines[]" data-placeholder="Magazine(s) seperated by comma" class="js-select2" multiple tabindex="4">
							<option value=""></option>
							<?php
							$magazinesArray = explode(',', $thisManga['magazines']);
							foreach ($h0manga->listMagazines() as $row) {
								if (in_array($row['slug'], $magazinesArray)) {
									echo '<option value="'.$row['slug'].'" selected>'.$row['name'].'</option>';
								} else {
									echo '<option value="'.$row['slug'].'">'.$row['name'].'</option>';
								}
							}
							?>
						</select>
						<input readonly type="text" class="form-control" name="trans_group" placeholder="<?=$lang['Group_ex']?>" value="<?=$thisManga['trans_group']?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Description']?></label>
						<textarea class="tiny form-control" name="description" cols="100%" rows="8"><?=stripslashes($thisManga['description'])?></textarea>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1" ><?=$lang['Status']?></label>
						<select name="status" class="form-control">
							<option value="1" <?=($thisManga['m_status'] == '1' ? 'selected' : '')?>><?=$lang['Completed']?></option>
							<option value="2" <?=($thisManga['m_status'] == '2' ? 'selected' : '')?>><?=$lang['On_going']?></option>
							<option value="3" <?=($thisManga['m_status'] == '3' ? 'selected' : '')?>><?=$lang['Pause']?></option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Last_chapter']?></label>
						<input type="text" class="form-control" name="last_chapter" value="<?=$thisManga['last_chapter']?>">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1" ><?=$lang['Group']?></label>
						<select name="group_uploader" class="form-control">
							<?php
							foreach ($group_uploader as $group) {
								?>
								<option value = "<?=$group['id']?>" <?=($thisManga['group_uploader'] == $group['id'] ? 'selected' : '')?>><?=$group['name']?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Cover']?></label>
						<div class="input-group">
							<input type="text" id='cover' name='cover' class="form-control" placeholder="<?=$lang['Cover_ex']?>" value="<?=$thisManga['cover']?>">
							<span class="input-group-btn">
								<button data-toggle="modal" href="#myModal" class="btn btn-default" type="button"><i class="glyphicon glyphicon-upload"></i> <?=$lang['or']?> <?=$lang['Upload']?></button>
							</span>
						</div><!-- /input-group -->
					</div>
					<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
				</form>

			</div>
		</div>
	</div>
</div>	
<?=$user->ajaxForm('editManga','app=mangaview=manga_management')?>
<script> 
	$(document).ready(function() { 
		$('#cover_form').on('submit', function(e) {
			e.preventDefault();
			$('#cover_info_output').html("Waiting..");
			$(this).ajaxSubmit({
				beforeSubmit:  function(){
				},
				target: '#cover_output',
				success: function() {
					var img = $('#cover_output').text();
					$( "#cover" ).val( img );
					$('#myModal').modal('hide');
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(function() {
		$("input:file").change(function (){
			$( "#cover_form" ).submit();
		});
	});
</script>
 <script>
 	$(document).ready(function() {
 		$('.js-select2').select2({
 			placeholder: 'Select an option',
 			width: '100%',
 			closeOnSelect: false,

 		});
 	});
 </script>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel"><?=$lang['Upload']?> <?=$lang['Cover']?></h4>
			</div>
			<div class="modal-body">
				<h4><?=$lang['Select_file']?></h4>
				<p>
					<div id="cover_info_output"></div>
					<div id="cover_output"></div>
					<form id="cover_form" action="../app/manga/controllers/cont.changeCover.php" method="POST" enctype="multipart/form-data">
						<input name="ImageFile" type="file">
					</form>
				</p>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>