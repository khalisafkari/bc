<?php

include '../../../controllers/cont.main.php';
if ($_POST && MANGA) {
	if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 
	if ($_POST['name_group'] == '') {
		$user->	exitAlert('danger','Translation group name cannot be empty');
	} elseif ($_POST['user'] == '') {
		$user->	exitAlert('danger','Please select at least one member');
	} elseif($_POST['name_group'] != '' && $_POST['user'] != ''){
		$thisGroup = mysqli_query($db->Connect(),"SELECT name FROM ".APP_TABLES_PREFIX."manga_groups WHERE id != $_POST[id]");
		while ($row = mysqli_fetch_assoc($thisGroup)) {
			if ($_POST['name_group'] == $row['name']) {
				$user->	exitAlert('danger','Translation group already exists');
				exit;
			}
		}
		
		$list_user = implode(',', $_POST['user']);
		$inputInfo = array('name'=>$_POST['name_group'],
			'user'=>$list_user);
		$result = $db->Update(APP_TABLES_PREFIX.'manga_groups',array('id'=>$_POST['id']),$inputInfo);

		if ($result) {
			$db->Update(APP_TABLES_PREFIX.'user',array('group_uploader'=>$_POST['id']),array('group_uploader'=>0));
			foreach ($_POST['user'] as $id_user) {
				$db->Update(APP_TABLES_PREFIX.'user', array('id'=>$id_user), array('group_uploader'=>$_POST['id']));
			}
			echo '...';
		}
	}
}
