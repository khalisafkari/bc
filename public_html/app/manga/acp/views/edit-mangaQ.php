 <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>
 <? $mid = $_GET[mid]; 
 	$query = $db->Query(APP_TABLES_PREFIX . 'manga_mangas_q','*',array('id'=>$mid));
 	$thisManga = $query[0];
 	?>
<div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$lang['Add_new']?> <?=$lang['Manga']?></h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<div id="editManga_output"></div>
	   		<form id="editManga_form" role="form" method="POST" action="../app/manga/controllers/cont.editMangaQ.php?mid=<?=$_GET['mid']?>">
			  <div class="form-group">
			    <label for="exampleInputEmail1"><?=$lang['Name']?></label>
			    <input type="text" class="form-control" id="mangaName" name="name" value="<?=stripslashes($thisManga['name'])?>">
			    <input type="hidden" class="form-control" name="submitter" value="<?=$thisManga['submitter']?>">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1"><?=$lang['Slug']?></label>
			    <div class="input-group">
			    <!--span class="input-group-addon"><!?php echo $lang['manga_slug']; ?>-</span-->
			    <input type="text" class="form-control" id="mangaSlug" name="slug">
			    <span class="input-group-addon">.html</span>
				</div>
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
		     <label for="exampleInputEmail1"><?=$lang['Description']?></label>
			    <textarea class="tiny form-control" name="description" cols="100%" row="8"><?=stripslashes($thisManga['description'])?></textarea>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1" ><?=$lang['Status']?></label>
			    <select name="status" class="form-control">
			    	<option value="1" <?=($thisManga['m_status'] == '1' ? 'selected' : '')?>><?=$lang['Completed']?></option>
			    	<option value="2" <?=($thisManga['m_status'] == '2' ? 'selected' : '')?>><?=$lang['On_going']?></option>
			    </select>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Cover']?></label>
			    <div class="input-group">
			      <input type="text" id='cover' name='cover' class="form-control" placeholder="<?=$lang['Cover_ex']?>" value="<?=$thisManga['cover']?>">
			      <span class="input-group-btn">
			        <button onclick="$('#image').val( $('#cover').val() ); $('#store_img_form').submit()" class="btn btn-default" type="button"><i class="glyphicon glyphicon-upload"></i> <?=$lang['Save-to-host']?></button>
			      </span>
			    </div><!-- /input-group -->
		     </div>
			  <button type="submit" class="btn btn-default"><?=$lang['Accept-save']?></button>
			</form>

	   	</div>
	  </div>
	</div>
 </div>	

	 <!-- AUTO SLUG-->
	 
 	<script>
	 	$(document).ready(function() {
			$.post('../app/manga/controllers/cont.autoSlug.php', { slug: $( "#mangaName" ).val() },
				function(data) {
				$("#mangaSlug").val(data);
			});
	 	});
	 	$( "#mangaName" ).change(function() {
			$.post('../app/manga/controllers/cont.autoSlug.php', { slug: $( "#mangaName" ).val() },
				function(data) {
				$("#mangaSlug").val(data);
			});
	 	});
 	</script>


 	<?=$user->ajaxForm('editManga','app=mangaview=manga_management')?>
 	<form id='store_img_form' action='../app/manga/controllers/cont.storeImg.php' method='POST'>
 		<div id='store_img_output' style="display: none"></div>
 		<input type='hidden' name='image' value='' id='image'>
 	</form>
 	<script> 
		$(document).ready(function() { 
			$('#store_img_form').on('submit', function(e) {
				e.preventDefault();
			$(this).ajaxSubmit({
					beforeSubmit:  function(){
					},
					target: '#store_img_output',
					success: function() {
						var img = $('#store_img_output').text();
						$( "#cover" ).val( img );
						alert('success');
					}
				});
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