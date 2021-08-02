<?php

include '../../../controllers/cont.main.php';
if ($_POST && MANGA) {
	if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 
	if ($_POST['name'] == '') {
		$user->	exitAlert('danger','Name cannot be empty');
	} elseif ($_POST['slug'] == '') {
		$user->	exitAlert('danger','Path cannot be empty');
	}
	 		// ADDSLASHES TO ARRAY
	$_POST = $huy->addSlashes($huy->clearXss($_POST));
	 		// Define info array
	$inputInfo = array('name'=>$_POST['name'],
		'slug'=>$_POST['slug'],
		'content'=>$_POST['content']);

	$result = $db->Update(APP_TABLES_PREFIX . 'manga_genres', array('id' => $_POST['id']), $inputInfo);
	
	if ($result) echo '...';
	 

}
