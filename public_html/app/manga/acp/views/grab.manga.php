<?php if(!$user->isAdmin()){ header('Location: ../index.html'); }?>

<div class="col-lg-8" id="show">
</div>

<div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Support pages: [loveheaven.net]</h3>
		</div>
		<div class="panel-body">
			<div id="UserTableContainer" style="width: 100%;">
				<form id="frGrab" action="#" role="form" method="POST" />
				<div class="form-group">
					<label for="exampleInputEmail1">Paste the link of the stories you want to grab here. Note that if you grab multiple stories at the same time, you can only grab stories on the same page, not grab stories from 2 pages or more.</label><br />
					<textarea name="manga_url" id="inputManga_url" class="form-control" rows="5" required="required" placeholder="Ex: https://loveheaven.net/one-piece.htmlhttps://loveheaven.net/gabriel-dropout-0.html"></textarea>
				</div>
				<input type="submit" id="grab" name="submit" class="btn btn-default">
			</form>

		</div>
	</div>
</div>
</div>
<script>
	$(document).ready(function(){
		$('#UserTableContainer').on('submit',  '#frGrab', function(e){
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
			var manga = $('#inputManga_url').val();
			var unavailable = 'Please enter the link of manga!';
			var img_load = '<img src="' + siteURL + '/app/manga/themes/default/assets/images/loading.gif" style="width:60%">';
			if (manga.indexOf('lhnovels.net') > 0) {
				var site = 'loveheaven';
			} else {
				var site = '';
			}
			if (site) {
				var token = '<?=$_SESSION[token]?>',
				re = new RegExp('https://', 'g'),
				manga = manga.replace(re, 'http://'),
				listURL = manga.split('http://');
				listURL.shift();
				function ajax_manga(index) {
					$.ajax({
						url: siteURL + '/app/manga/controllers/cont.Grab.Manga.php',
						type: 'POST',
						dataType: 'html',
						data: {
							site: site,
							manga: 'http://'+listURL[index],
							token: token,
						},
						beforeSend: function() {
							$('.loading').prepend(img_load);
						},
						success: function(data) {
							$('#end').prepend(data);
							$('#inputManga_url').val('');
							$(".loading").remove();
							if (index+1 < listURL.length) {
								ajax_manga(index+1);
							}
						},
					})
					.done(function() {
						console.log("success");
					})
					.fail(function() {
						console.log("error");
					});
				}
				ajax_manga(0);
			} else {
				$('#end').html(unavailable);
			}

		});
	});
</script>