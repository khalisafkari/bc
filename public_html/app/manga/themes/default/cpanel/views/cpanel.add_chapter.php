<?php
$_GET['mslug'] = str_replace(array('\'', '\"'), '', $_GET['mslug']);
$thisGroup = $db->Query(APP_TABLES_PREFIX.'user','group_uploader',array('id'=>$_SESSION['userId']));
if($_GET['type'] == 'chapter' && $_SESSION['thisUser']['role'] == 2){ 
	header('Location: /acp/app=mangaview=add-chapter&manga='.$_GET['mslug']);
} elseif ($_GET['type'] == 'chapter') {
	if($_GET['mslug']) {
		$query = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('slug'=>$_GET['mslug']));
		if (!empty($thisGroup[0][group_uploader])) {
			$checkUserGroup = $huy->isExist(APP_TABLES_PREFIX. 'manga_mangas', 'id', array('slug'=>$_GET['mslug'], 'group_uploader' => $thisGroup[0][group_uploader]));
		}
		$checkSubmitter = $huy->isExist(APP_TABLES_PREFIX.'manga_mangas', 'id', array('slug'=>$_GET['mslug'], 'submitter'=>$_SESSION['userId']));
		if ($checkUserGroup || $checkSubmitter) {
			$thisManga = $query['0'];
			?>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?=$lang['Submit']?> <?=$lang['Chapter']?></h3>
					</div>
					<div class="panel-body">
						<div id="UserTableContainer" style="width: 100%;">
							<form id="addManga_form" role="form" method="POST" action="/app/manga/controllers/cont.user.addChapter.php">
								<input type="hidden" name="token" value="<?=$_SESSION['token']?>">
								<div class="form-group">
									<label for="exampleInputEmail1"><?=$lang['Manga']?></label>
									<select class="form-control" name="manga">
										<? 
										if(count($db->Query(APP_TABLES_PREFIX.'manga_mangas','id',array('slug'=>$_GET['mslug']),null,null,null,1)) > 0){
											echo "<option value='".$_GET['mslug']."'>".$_GET['mslug']."</option>";
										}else{
											header('Location: index.html');
										}
										?>
									</select> 
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1"><?=$lang['Chapter']?></label>
									<input type="text" id="chapterno" class="form-control" name="chapter" placeholder="VD: 78">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1"><?=$lang['Name']?></label>
									<input type="text" class="form-control" name="name" placeholder="VD: Trận chiến kết thúc">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1"><?=$lang['Content']?></label>
									<textarea class="form-control" name="content" id="content" cols="100%" rows="8" placeholder="http://example.com/images1.jpghttp://example.com/images2.jpghttp://example.com/images3.jpg"></textarea>
									<?=$lang['Content_ex']?>
								</div>
								<div id="addManga_output"></div>
								<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
							</form>
						</div>
					</div>
				</div>
			</div> 
			<?php
			$user->ajaxForm('addManga','/quan-ly/danh-sach-chuong/'.$_GET['mslug'].'.html');
		} else {
			$user->alert('danger', 'Bạn không có quyền thêm chương!');
		}
	}
}
echo '</div>';
?>