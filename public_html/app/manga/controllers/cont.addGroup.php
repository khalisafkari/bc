<?php

include '../../../controllers/cont.main.php';
if ($_POST && MANGA) {
	if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 
	if ($_POST['name_group'] == '') {
		$user->exitAlert('danger','Translation group name cannot be empty');
	} elseif ($_POST['user'] == '') {
		$user->exitAlert('danger','Please select at least one member');
	} elseif($_POST['name_group'] != '' && $_POST['user'] != ''){
		$thisGroup = $db->Query(APP_TABLES_PREFIX.'manga_groups','name');
		foreach ($thisGroup as $group) {
			if ($_POST['name_group'] == $group['name']) {
				$user->exitAlert('danger','Translation group already exists');
				exit;
			}
		}
 		// ADDSLASHES TO ARRAY
		$list_user = implode(',', $_POST['user']);
		$inputInfo = array('name'=>addSlashes($_POST['name_group']),
			'user'=>$list_user,
			'time'=>$now);
		$result = $db->Create(APP_TABLES_PREFIX . 'manga_groups',$inputInfo);

		if ($result) {
			$thisId = $db->Query(APP_TABLES_PREFIX.'manga_groups','max(id) as id', array('user'=>$list_user));
			$id = $thisId[0]['id'];
			$user = $_POST['user'];
			foreach ($user as $id_user) {
				$db->Update(APP_TABLES_PREFIX.'user', array('id'=>$id_user), array('group_uploader'=>$id));
			}
			echo '...';
		}
	}
}