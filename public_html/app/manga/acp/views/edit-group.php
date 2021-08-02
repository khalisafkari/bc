<?php
if(!($user->isAdmin() || $user->isMod()) || empty($_GET['id'])) {
	header('Location: ../index.html');
}
$id = (int)$_GET['id'];
$groupInfo = $db->Query(APP_TABLES_PREFIX.'manga_groups', 'user, name', array('id'=>$id));
$userInfo = $db->Query(APP_TABLES_PREFIX.'user', 'id, name', 'group_uploader != 0 AND group_uploader = '.$id);
$listUser = explode(',', $groupInfo[0]['user']);
?>
<div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?=$lang['Edit']?> <?=$lang['Group']?></h3>
		</div>
		<div class="panel-body">
			<div id="UserTableContainer" style="width: 100%;">
				<div id="editGroup_output"></div>
				<form id="editGroup_form" role="form" method="POST" action="../app/manga/controllers/cont.editGroup.php">
					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
						<input type="text" id="name_group" class="form-control" name="name_group" value ="<?=$groupInfo[0]['name']?>">
						<input type="hidden" name="id" id="inputId" class="form-control" value="<?=$_GET['id']?>">
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1"><?=$lang['member']?></label>
						<select name="user[]" data-placeholder="Choose the members of the group" class="js-example-basic-multiple form-control" multiple tabindex="4">
							<option value=""></option>
							<?php
							foreach ($userInfo as $key => $value) {
								if (in_array($value['id'], $listUser)) {
									echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
								} else {
									echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
								}
							}
							?>
						</select>
					</div>
					<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
				</form>

			</div>
		</div>
	</div>
</div>
<?=$user->ajaxForm('editGroup','app=mangaview=group_management')?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.js-example-basic-multiple').select2({
			with: '100%',
		});
	});
</script>
