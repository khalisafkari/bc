<!-- IF user LOGGED -->

<? if($user->isLoggedIn()){ 
	$isBookmark = $huy->isExist(APP_TABLES_PREFIX.'manga_bookmark','user',array('user'=>$_SESSION['userId'],'manga'=>$thisManga['id']));

	$thisGroup = $db->Query(APP_TABLES_PREFIX.'user','group_uploader',array('id'=>$_SESSION['userId']));

	$check_submiter = $huy->isExist(APP_TABLES_PREFIX. 'manga_mangas', 'id', array('slug'=>$_GET['slug'], 'submitter'=>$_SESSION['userId']));

	$check_group = $huy->isExist(APP_TABLES_PREFIX. 'manga_mangas', 'id', 'slug = "'.$_GET[slug].'" AND group_uploader = "'.$thisGroup[0]['group_uploader'].'" AND group_uploader != 0');
	?>
	<div id="user_action_hide">
		<div class="btn-group">
			<? if($user->isAdmin()){ ?>
				<a href="/acp/app=mangaview=add-chapter&manga=<?=$thisManga['slug']?>" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-upload"></i> <?=$lang['Upload-chapter']?></a>
				<button type="button" class="btn btn-primary" data-toggle="dropdown"><i class="glyphicon glyphicon-import"></i> Grab <span class="caret"></span></button>
				<ul class="dropdown-menu"><?php
				if ($handle = opendir(ROOT_DIR.'/app/manga/acp/views/')) {
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != ".." && strpos($entry, 'rab.chapter.')) {
							$entry = substr($entry, 0, -4);
							$name = ucfirst(str_replace('.',' ',str_replace('chapter','Chapter',$entry)));
							echo '<li><a href="/acp/app=mangaview='.$entry.'&manga='.$thisManga[slug].'">'.$name.'</a></li>';
						}
					}
					closedir($handle);
				}
				?></ul>
				<a href="/acp/app=mangaview=edit-manga&mid=<?=$thisManga['id']?>" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit']?></a>
				<a href="/index.html" id="hidden" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-eye-close"></i> <?=$lang['Hidden']?></a>
				<a href="/index.html" type="button" class="delete-manga btn btn-primary"><span class="glyphicon glyphicon-trash"></span> <?=$lang['Delete']?></a>
				<a href="/acp/app=mangaview=chapter_management&manga=<?=$thisManga['slug']?>" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-list"></i> <?=$lang['Chapter_List']?></a>
				<?php
			} elseif ($check_submiter || $check_group) {
				?>
				<a href="/quan-ly/dang-chuong/<?=$thisManga['slug']?>.html" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-upload"></i> <?=$lang['Upload-chapter']?></a>
				<a href="/quan-ly/sua-truyen/<?=$thisManga['id']?>/<?=$thisManga['slug']?>.html" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit']?></a>
				<a href="/index.html" id="hidden" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-eye-close"></i> Ẩn</a>
				<a href="/quan-ly/danh-sach-chuong/<?=$thisManga['slug']?>.html" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-list"></i> <?=$lang['Chapter_List']?></a>
				<?php
			}
			?>
			<a type="button" onclick="$('#bookmark_form').submit()" class="btn btn-primary" id="bookmark_btn" action="<?php echo ($isBookmark == 1 ? 'unbookmark' : 'bookmark'); ?>"><i class="fa fa-bell<?php echo ($isBookmark == 1 ? '-slash' : ''); ?>"></i> <?php echo ($isBookmark == 1 ? $lang['unBookmark'] : $lang['Bookmark']); ?></a>
		</div>
	</div>
	<input type="hidden" name="id_manga" id="id_manga" class="form-control" value="<?=$thisManga['id']?>">
	<div id="reportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
				</div>
				<div class="modal-body">
					<h4>Text in a modal</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
					<button type="button" class="btn btn-primary"><?=$lang['Submit']?></button>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<form id="bookmark_form" method="POST" action="/app/manga/controllers/cont.bookmark.php">
		<div id="bookmark_output" style="display:none"></div>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		<input type="hidden" name="mid" value="<?php echo $thisManga['id'];?>"> 
	</form>

<? } ?>

<script>
        // FORM 
        $(document).ready(function() { 
        	<?php
        	if ($user->isAdmin()) {
        		?>
        		$("#hidden").click(function(a){a.preventDefault();var n=$("#id_manga").val();confirm("Bạn có chắc không?")&&$.ajax({url:"/app/manga/controllers/cont.mangaManagement.php?action=hidden",type:"POST",dataType:"html",data:{id:n},success:function(){window.location.href=siteURL}})}),$(".delete-manga").click(function(a){a.preventDefault();var n=$("#id_manga").val();confirm("Bạn có chắc không?")&&$.ajax({url:"/app/manga/controllers/cont.mangaManagement.php?action=delete",type:"POST",dataType:"html",data:{id:n},success:function(){window.location.href=siteURL}})}),$("#update").click(function(a){a.preventDefault();var n=$("#id_manga").val();confirm("Bạn có chắc không?")&&$.ajax({url:"/app/manga/controllers/cont.mangaManagement.php?action=update",type:"POST",dataType:"html",data:{id:n},success:function(){window.location.href=siteURL}})});
        		$('#clear').on('click', function (e) {
        			e.preventDefault();
        			var slug = '<?=$thisManga[slug]?>';
        			confirm("Bạn có chắc không?") && $.ajax({
        				url: "/app/manga/controllers/cont.clearCache.php?action=cache",
        				type: "POST",
        				dataType: "html",
        				data: {
        					manga: slug
        				},
        				success: function() {
        					window.location.href = window.location.href;
        				}
        			});
        		})
        		<?php
        	} elseif($user->isUser()) {
        		?>
        		$("#hidden").click(function(a){a.preventDefault();var n=$("#id_manga").val();confirm("Bạn có chắc không?")&&$.ajax({url:"/app/manga/controllers/cont.user.mangaManagement.php?action=hidden",type:"POST",dataType:"html",data:{id:n},success:function(){window.location.href=siteURL}})}),$("#update").click(function(a){a.preventDefault();var n=$("#id_manga").val();confirm("Bạn có chắc không?")&&$.ajax({url:"/app/manga/controllers/cont.user.mangaManagement.php?action=update",type:"POST",dataType:"html",data:{id:n},success:function(){window.location.href=siteURL}})});
        		<?php
        	}
        	?>

        });


    </script>