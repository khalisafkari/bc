<? if(!$user->isLoggedIn()){ header('Location: ../index.html'); }

$cid = (int)$_GET['cid'];
$_GET['manga'] = str_replace(array('\'', '\"'), '', $_GET['manga']);

$thisGroup = $db->Query(APP_TABLES_PREFIX.'user','group_uploader',array('id'=>$_SESSION['userId']));
if (!empty($thisGroup[0][group_uploader])) {
	$checkUserGroup = $huy->isExist(APP_TABLES_PREFIX. 'manga_mangas', 'id', array('slug'=>$_GET['manga'], 'group_uploader' => $thisGroup[0][group_uploader]));
}
$check_submitter = $huy->isExist(APP_TABLES_PREFIX.'manga_mangas', 'id', array('slug'=>$_GET['manga'], 'submitter'=>$_SESSION['userId']));
if (!empty($checkUserGroup) || $check_submitter) {
	$query = $db->Query(APP_TABLES_PREFIX.'manga_chapters','*',array('id'=>$cid, 'manga'=>$_GET['manga']));
	if ($query[0]) {
		$thisChapter = $query['0'];
	} else {
		header('Location: /index.html');
	}
	?>
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$lang['Edit']?> <?=$lang['Chapter']?> (<?=$thisChapter['chapter']?> / <a href="/quan-ly/danh-sach-chuong/truyen-<?=$thisChapter['manga']?>.html"><strong><?=$thisChapter['manga']?></strong></a>)</h3>
			</div>
			<div class="panel-body">
				<div id="UserTableContainer" style="width: 100%;">
					<div id="addManga_output"></div>
					<form id="addManga_form" role="form" method="POST" action="/app/manga/controllers/cont.user.editChapter.php">
						<input type="hidden" name="manga" value="<?=$thisChapter['manga']?>">
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
							<textarea class="form-control" name="content" id="content" cols="100%" rows="8" placeholder="http://example.com/images1.jpghttp://example.com/images2.jpghttp://example.com/images3.jpg"><?=$thisChapter['content']?></textarea>
							<?=$lang['Content_ex']?>
						</div>

						<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
					</form>

				</div>
			</div>
		</div>
	</div>	
	<?=$user->ajaxForm('addManga','/quan-ly/danh-sach-chuong/'.$thisChapter['manga'].'.html')?>
	<?php
} else {
	$user->alert('danger', 'Bạn không thể sửa chapter này!');
}
?>
