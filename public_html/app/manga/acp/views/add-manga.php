 <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); }
 $thisGroup = $db->Query(APP_TABLES_PREFIX.'user', 'group_uploader', array('id'=>$_SESSION['userId']));
 ?>
 <div class="col-lg-8">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title"><?=$lang['Add_new']?> <?=$lang['Manga']?></h3>
 		</div>
 		<div class="panel-body">
 			<div id="UserTableContainer" style="width: 100%;">
 				<div id="addManga_output"></div>
 				<form id="addManga_form" role="form" method="POST" action="../app/manga/controllers/cont.addManga.php">
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
 						<input type="text" class="form-control" id="mangaName" name="name">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Slug']?></label>
 						<div class="input-group">
 							<span class="input-group-addon"><?php echo $lang['manga_slug']; ?>-</span>
 							<input type="text" class="form-control" id="mangaSlug" name="slug">
 							<span class="input-group-addon">.html</span>
 						</div>
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Other_name']?></label>
 						<input type="text" class="form-control" name="other_name">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Authors']?></label>
 						<input type="text" class="form-control" name="authors" placeholder="<?=$lang['Authors_ex']?>">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Artists']?></label>
 						<input type="text" class="form-control" name="artists" placeholder="<?=$lang['Artists_ex']?>">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Released']?></label>
 						<input type="text" class="form-control" name="released">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Genres']?></label>
 						<select name="genres[]" data-placeholder="<?=$lang['Genres_ex']?>" class="js-select2" multiple tabindex="4">
 							<option value=""></option>
 							<?php
 							foreach ($h0manga->listGenres() as $row) {
 								echo '<option value="'.$row['slug'].'">'.$row['name'].'</option>';
 							}
 							?>
 						</select>
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Description']?></label>
 						<textarea class="tiny form-control" name="description" cols="100%" rows="8"></textarea>
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1" >Magazine(s)</label>
						<select name="magazines[]" data-placeholder="Magazine(s) seperated by comma" class="js-select2" multiple tabindex="4">
 							<option value=""></option>
 							<?php
 							foreach ($h0manga->listMagazines() as $row) {
 								echo '<option value="'.$row['slug'].'">'.$row['name'].'</option>';
 							}
 							?>
 						</select>
 					</div>
 					<div class="form-group">
 						<input type="hidden" name="group_uploader" value="<?=$thisGroup[0]['group_uploader']?>"> 
 						<label for="exampleInputEmail1" ><?=$lang['Status']?></label>
 						<select name="status" class="form-control">
 							<option value="1"><?=$lang['Completed']?></option>
 							<option value="2"><?=$lang['On_going']?></option>
 							<option value="2"><?=$lang['Pause']?></option>
 						</select>
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Cover']?></label>
 						<div class="input-group">
 							<input type="text" id='cover' name='cover' class="form-control" placeholder="<?=$lang['Cover_ex']?>">
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
 <!-- AUTO SLUG -->
 <script>
 	$(document).ready(function() {
 	});
 	$( "#mangaName" ).change(function() {
 		$.post('../app/manga/controllers/cont.autoSlug.php', { slug: $( "#mangaName" ).val() },
 			function(data) {
 				$("#mangaSlug").val(data);
 			});
 	});
 </script>

 <!-- JAVASCRIPT AND UPLOAD COVER -->
 <?=$user->ajaxForm('addManga','app=mangaview=manga_management')?>
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