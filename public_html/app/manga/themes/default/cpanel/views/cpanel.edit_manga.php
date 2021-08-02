<?php
if (!$user->isLoggedIn()) {
	header('Location: ../index.html');
}
$mid = isset($_GET['mid']) ? (int)$_GET['mid'] : NULL;
$thisGroup = $db->Query(APP_TABLES_PREFIX.'user','group_uploader',array('id'=>$_SESSION['userId']));
$check_submitter = $huy->isExist(APP_TABLES_PREFIX.'manga_mangas', 'id', array('id'=>$mid, 'submitter'=>$_SESSION['userId']));
if (!empty($thisGroup[0]['group_uploader'])) {
	$checkUserGroup = $huy->isExist(APP_TABLES_PREFIX. 'manga_mangas', 'id', array('id'=>$mid, 'group_uploader' => $thisGroup[0][group_uploader]));
}
if ($checkUserGroup || $check_submitter) {
	$query = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('id'=>$mid));
	$thisManga = $query[0];
	?>
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Sửu truyện</h3>
			</div>
			<div class="panel-body">
				<div id="UserTableContainer" style="width: 100%;">
					<div id="editManga_output"></div>
					<form id="editManga_form" role="form" method="POST" action="/app/manga/controllers/cont.user.editManga.php?mid=<?=$mid?>">
						<div class="form-group">
							<label for="exampleInputEmail1"><?=$lang['Name']?></label>
							<input type="text" class="form-control" name="name" value="<?=stripslashes($thisManga['name'])?>">
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
							<input type="text" class="form-control" name="genres" placeholder="<?=$lang['Genres_ex']?>" value="<?=$thisManga['genres']?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1"><?=$lang['Description']?></label>
							<textarea id="description" class="tiny form-control" name="description" cols="100%" row="8"><?=stripslashes($thisManga['description'])?></textarea>
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
							<label for="exampleInputEmail1"><?=$lang['Cover']?></label>
							<input type="text" class="form-control" name="cover" placeholder="<?=$lang['Cover_ex']?>" value="<?=$thisManga['cover']?>">
						</div>
						<input type="hidden" name="slug" value="<?=$thisManga['slug']?>">
						<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
					</form>

				</div>
			</div>
		</div>
	</div>	
	<?=$user->ajaxForm('editManga','/quan-ly/danh-sach-truyen.html')?>
	<?php
} else {
	$user->alert('danger', 'Bạn không thể sửa truyện này!');
}
?>