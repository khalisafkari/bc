 <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); }
 $cid = (int)$_GET['cid']; 
 $query = $db->Query(APP_TABLES_PREFIX . 'manga_chapters','*',array('id'=>$cid));
 $thisChapter = $query['0'];
 ?>
 <div class="col-lg-8">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title"><?=$lang['Edit']?> <?=$lang['Chapter']?> (<?=$thisChapter['chapter']?> / <a href="app=mangaview=chapter_management&manga=<?=$thisChapter['manga']?>"><strong><?=$thisChapter['manga']?></strong></a>)</h3>
 		</div>
 		<div class="panel-body">
 			<div id="UserTableContainer" style="width: 100%;">
 				<div id="addManga_output"></div>
 				<form id="addManga_form" role="form" method="POST" action="../app/manga/controllers/cont.editChapter.php">
 					<input type="hidden" name="manga" value="<?=$thisChapter['manga']?>">
 					<input type="hidden" name="chapterId" value="<?=$thisChapter['id']?>">
 					<input type="hidden" name="mid" value="<?=$thisChapter['mid']?>">
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Chapter']?></label>
 						<input type="text" id="chapter" class="form-control" name="chapter" value="<?=$thisChapter['chapter']?>">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
 						<input type="text" id="nameChapter" class="form-control" name="name" value = "<?=stripslashes($thisChapter['name'])?>">
 					</div>
 					<div class="form-group">
 						<div id="buttonUpload" style="position: absolute; width: 100%; height: 100%; z-index: 10000;"></div>
 						<div id="queue" style="max-width:400px; max-height: 250px; overflow: auto"></div>
 						<input id="file_upload" name="file_upload" type="file" multiple="true" multiple accept="image/*">
 					</div>
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Content']?></label>
 						<textarea class="form-control" name="content" id="content" cols="100%" rows="8" placeholder="http://example.com/images1.jpghttp://example.com/images2.jpghttp://example.com/images3.jpg"><?=$thisChapter['content']?></textarea>
 						<?=$lang['Content_ex']?>
 					</div>
 					<div class="form-group">
						<div id="previewImg"></div>
					</div>

 					<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
 				</form>

 			</div>
 		</div>
 	</div>
 </div>	
 <?=$user->ajaxForm('addManga','app=mangaview=chapter_management&mid='.$thisChapter['mid'])?>

 <script>
	$(document).ready(function($) {
		// $('#buttonUpload').click(function(event) {
		// 	var chapter = $('#chapter').val();
		// 	var	nameChapter = $('#nameChapter').val();
		// 	event.preventDefault();
		// 	if (chapter === '') {
		// 		alert('B???n ph???i ??i???n s??? ch????ng tr?????c khi upload. VD: 1, 2, 2.1, 2.2 vv');
		// 	}
		// });
		// $('#chapter').keyup(function() {
		// 	if ($.trim($(this).val())) {
		// 		$('#buttonUpload').hide();
		// 	} else {
		// 		$('#buttonUpload').show();
		// 	}
		// });
		$('#buttonUpload').hide();
		var uploadImg = function (img) {
			$('#content').val(function(key, content) {
				return content + img;
			});
		}
		var previewImages = function(img) {
			$("#previewImg").append("<img src='"+img+"' width='140'>");
		}
		var errorWhenUpload = false;	
		$('#file_upload').uploadifive({
			'auto' 				: true,
			'buttonText'		: '<?=$lang['Content_upload_ex']?>',
			'queueID' 			: 'queue',
			'uploadScript' 		: '/app/manga/controllers/cont.uploadChapter.php',
			'fileType' 			: 'image',
			'method'			: 'post',
			'fileObjName' 		: 'Filedata',
			'width'				: 250,
			'simUploadLimit' 	: 2, 
			'onUpload' : function() {
				var chapter = $("#chapter").val();
				var path = '<?=$thisChapter['mid']?>/' + chapter;
				$('#file_upload').data('uploadifive').settings.formData = {
					'token'	: '<?=$_SESSION['token']?>' ,
					'url'	: path,
					'mid'	: '<?=$thisChapter['mid']?>'
				}
			},
			'onUploadComplete'	: function(file, data) {
				var obj = jQuery.parseJSON( data );
				if (obj.success == 1) {
					try
					{
						var json = jQuery.parseJSON( obj.url ) ;
						if (json.error == false) {
							obj.url = json.url;
						}
					}
					catch(e)
					{
					}
					file.queueItem.attr('urldata',obj.url);
					file.queueItem.fadeOut();
					$("#previewImg").html('');
					$("#content").val('');
					$("div#queue").find('div.complete').each(function(index, value) { 
						var url = $(this).attr('urldata');
						var $url = siteURL + '/' + url;
						previewImages($url);
						uploadImg(url);
					}); 
				} else {
					var url = '/acp/assets/img/anhloi.jpg\n';
					var $url = siteURL + url;
					previewImages($url);
					uploadImg(url);
					errorWhenUpload = true;
				}
			},
			'onQueueComplete' 	: function(queueData) {
				setTimeout(
					function() 
					{
						if(errorWhenUpload == true) {
							BootstrapDialog.show({
								title		: 'There was an Error During Upload!!',
								message		: '<div class="alert alert-danger">Maybe due to some transmission line, some files could not be uploaded. <br/>Please try again!<br/>',
								buttons		: [{
									label	: 'Close',
									action	: function(dialogItself){
										dialogItself.close();
									}
								}]
							});

						}
					}, 1000);
			} 
		});
	});
</script>