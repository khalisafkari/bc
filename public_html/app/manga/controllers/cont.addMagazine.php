<?php

include '../../../controllers/cont.main.php';

if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

if($_POST && MANGA){
	if ($_POST['name'] == '') {
		$user->exitAlert('danger','Name cannot be empty');
	} elseif ($_POST['slug'] == '') {
		$user->exitAlert('danger','Path cannot be empty');
	}
	
 		// ADDSLASHES TO ARRAY
	$_POST = $huy->addSlashes($huy->clearXss($_POST));

 		// Define info array
	$inputInfo = array('name'=>$_POST['name'],
		'slug'=>$_POST['slug'],
		'content'=>$_POST['content'],
		'time'=>$now);

	$result = $db->Create(APP_TABLES_PREFIX . 'manga_magazines', $inputInfo);

	echo '...';
}