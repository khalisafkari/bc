 <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>
 <? $cid = $_GET['cid']; 
 	$query = $db->Query(APP_TABLES_PREFIX . 'manga_chapters_q','*',array('id'=>$cid));
 	$thisChapter = $query['0'];
 ?>
<div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$lang['Edit-accept']?> <?=$lang['Chapter']?> (<?=$thisChapter['chapter']?> / <a href="app=mangaview=chapter_management&mid=<?=$thisChapter['mid']?>"><strong><?=$thisChapter['manga']?></strong></a>)</h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<div id="addManga_output"></div>
	   		<form id="addManga_form" role="form" method="POST" action="../app/manga/controllers/cont.editChapterQ.php?cid=<?=$thisChapter['id']?>">
	   		  <input type="hidden" name="manga" value="<?=$thisChapter['manga']?>">
	   		  <input type="hidden" name="submitter" value="<?=$thisChapter['submitter']?>">
	   		  <input type="hidden" name="chapterId" value="<?=$thisChapter['id']?>">
			  <div class="form-group">
			    <label for="exampleInputEmail1"><?=$lang['Chapter']?></label>
			    <input type="text" id="chapterno" class="form-control" name="chapter" value="<?=$thisChapter['chapter']?>">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1"><?=$lang['Name']?></label>
			    <input type="text" class="form-control" name="name" value="<?=stripslashes($thisChapter['name'])?>">
			  </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$lang['Content']?></label>
		     	<div class="btn-group pull-right">
				     <button data-toggle="modal" href="#myModal" type="button" class="btn btn-sm btn-success" style="padding:2px"><i class="glyphicon glyphicon-upload"></i> <?=$lang['Content_upload_ex']?></button>
				     <a onclick="$('#images').val( $( '#content' ).val() ); $('#folder').val('manga/<?=$thisChapter['manga']?>/'+$( '#chapterno' ).val()); $('#save2host_form').submit()" class="btn btn-sm btn-danger" style="padding:2px"><i class="glyphicon glyphicon-download"></i> <?=$lang['Save-to-host']?></a>
		 		</div>
			    <textarea class="form-control" name="content" id="content" cols="100%" row="8" placeholder="http://example.com/images1.jpghttp://example.com/images2.jpghttp://example.com/images3.jpg"><?=$thisChapter['content']?></textarea>
		     	<?=$lang['Content_ex']?>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1" ><?=$lang['Group']?></label>
			    <select name="trans_group" class="form-control">
			    	<?=$h0manga->listGroup($thisChapter['trans_group'])?>
			    </select>
		     </div>
			  <button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
			</form>

	   	</div>
	  </div>
	</div>
 </div>	
 	<form id="save2host_form" method="POST" action="../app/manga/controllers/cont.storeImgs.php">
 	<div id="save2host_output" style="display:none"></div>
 		<input type="hidden" name="images" id="images" value="">
 		<input type="hidden" name="folder" id="folder">
 	</form>
 	<script> 
		$(document).ready(function() { 
			$('#save2host_form').on('submit', function(e) {
				e.preventDefault();
				alert('wait for \'success\' message appear, close me to process');
			$(this).ajaxSubmit({
					beforeSubmit:  function(){
					},
					target: '#save2host_output',
					success: function() {
						var img = $('#save2host_output').text();
						$( "#content" ).val( img );
						alert('success');
					}
				});
			});
		});
	</script>


 	<?=$user->ajaxForm('addManga','app=mangaview=chapter_management&manga='.$thisChapter['manga'])?>
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
						$( "#content" ).val( img );
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
	    
	     	var chapterno = $( "#chapterno" ).val();
			$( "#path" ).val( "<?=$thisChapter['manga']?>/"+chapterno );
			$( "#path2").text( "<?=$thisChapter['manga']?>/"+chapterno );

	     $("#chapterno").change(function (){
	     	var chapterno = $( "#chapterno" ).val();
			$( "#path" ).val( "<?=$thisChapter['manga']?>/"+chapterno );
			$( "#path2").text( "<?=$thisChapter['manga']?>/"+chapterno );
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
            	<form id="cover_form" action="../app/manga/controllers/cont.uploadChapter.php" method="POST" enctype="multipart/form-data">
            		<strong>PATH</strong>: app/manga/uploads/manga/<span id="path2"></span>/<br /><br />
            		<input type="hidden" name="manga" value="<?=$_GET['manga']?>">
            		<input type="hidden" name="path" id="path" class="form-control" style="display: inline; width: inherit;">
		    		<input name="ImageFile[]" type="file" multiple="">
		    	</form>
		    </p>
		  </div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>