<html><head></head><body>
	<?php if(!$user->isAdmin()){ header('Location: ../index.html'); } ?>
	<div class="col-lg-8" id="show"></div>

	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="well">
				<!-- <h3 class="panel-title">Support pages: [loveheaven.net]</h3> -->
				<h3>Tool Leech</h3>
			</div>
			<div id="UserTableContainer" class="frG" style="width: 100%;">
				<form id="frGrab" class="bs-example form-horizontal" method="POST" action="app=mangaview=grab.chapter.Hamtruyen&action=grab_links&token=<?=$_SESSION['token']?>">
					<fieldset>
						<div class="form-group">
							<label class="col-lg-2 control-label">URL of manga</label>
							<div class="col-lg-10">
								<input type="text" id="inputManga_url" class="form-control" name="url" placeholder="http://lovehug.net/noblesse-1386.html">
							</div>
						</div>	  
						<div class="form-group">
							<label class="col-lg-2 control-label">Grab into:</label>
							<div class="col-lg-10">
								<select class="form-control" name="manga">
									<?PHP
									if (!isset($_GET['manga'])) {
										$select_manga = $db->Query(APP_TABLES_PREFIX.'manga_mangas',array('id', 'slug','name'),NULL,NULL,NULL,array('name'=>'ASC'),1);
										foreach ($select_manga as $row){
											echo "<option name ='manga' value='$row[slug]' data-name='$row[name]' data-id='$row[id]'>$row[name]</option>";
										}
									} else {
										$select_manga = $db->Query(APP_TABLES_PREFIX.'manga_mangas',array('id', 'slug','name'),array('slug'=>$_GET['manga']),NULL,NULL,array('name'=>'ASC'),null);
										foreach ($select_manga as $row){
											echo "<option name ='manga' value='$row[slug]' data-name='".$huy->stripSlashes($row[name])."' data-id='$row[id]'>$row[name]</option>";
										}
									}

									?>
								</select>
							</div>
						</div>  
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2"> 
								Please check carefully to see if it is correct and then "Submit", unless you will have to fix a lot<br /><br />
								<button type="submit" name ="submit" class="btn btn-primary"><?=$lang['Submit']?></button> 
							</div>
						</div>
					</fieldset>
				</form>
			</div></div>
		</div>      
	</div>
	<script>
		$(document).ready(function(e) {
			$('.frG').on('submit', '#frGrab', function(e) {
				e.preventDefault();
				$('#show').html('<div class="panel panel-default">\
					<div class="panel-heading">\
					<h3 class="panel-title">Result</h3>\
					</div>\
					<div class="panel-body">\
					<div id="UserTableContainer" style="width: 100%; max-height: 200px; overflow-y: scroll;">\
					<div class="loading"></div>\
					<div id="end"></div>\
					</div>\
					</div>\
					</div>');
				var unavailable = 'Please enter the link of manga!',
				img_load = '<img src="' + siteURL + '/app/manga/themes/default/assets/images/loading.gif" style="width:60%">',
				url = $('#inputManga_url').val(),
				slug = $('option').val(),
				manga = $('option').attr('data-name'),
				id = $('option').attr('data-id');
				if (url.indexOf('lhnovels.net') > 0) {
					var site = 'loveheaven';
				} else {
					var site = '';
				}
				if (site) {
					var token = '<?=$_SESSION[token]?>',
					re = new RegExp('https://', 'g'),
					url = url.replace(re, 'http://'),
					listURL = url.split('http://');
					listURL.shift();
					function ajax_chapters(index) {
						$.ajax({
							url: siteURL + '/app/manga/controllers/cont.Grab.Process.Chapter.php',
							type: 'POST',
							dataType: 'html',
							data: {
								url: 'http://'+listURL[index],
								slug: slug,
								token: token,
								name: manga,
								id: id,
								site: site,
							},
							beforeSend: function() {
								$('.loading').prepend(img_load);
							},
							success: function(data) {
								$('#end').prepend(data);
								$('#inputManga_url').val('');
								$(".loading").remove();
								if (index+1 < listURL.length) {
									ajax_chapters(index+1);
								}
							}
						})
						.done(function() {
							//console.log("success");
						})
						.fail(function() {
							console.log("error");
						});
					}
					ajax_chapters(0);
				} else {
					$('#end').html(unavailable);
				}
			});
		});
	</script>

</body></html>
