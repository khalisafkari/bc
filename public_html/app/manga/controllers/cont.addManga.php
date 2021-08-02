<?php

include '../../../controllers/cont.main.php';

if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

if($_POST && MANGA){
 		// ADDSLASHES TO ARRAY
	$genres = $_POST['genres'] = $_POST['genres'] ? implode(',', $_POST['genres']) : '';
	$magazines = $_POST['magazines'] = $_POST['magazines'] ? implode(',', $_POST['magazines']) : '';
	$_POST = $huy->addSlashes($huy->clearXss($_POST));

	if ($huy->isExist(APP_TABLES_PREFIX.'manga_mangas', 'id', array('slug'=>$_POST['slug']))) {
		$user->exitAlert('danger', 'This manga already exists!');
		die();
	}

	$other_name = !empty($_POST['other_name']) ? $_POST['other_name'] : $lang['Updating'];
	$authors = !empty($_POST['authors']) ? $_POST['authors'] : $lang['Updating'];
	$artists = !empty($_POST['artists']) ? $_POST['artists'] : $_POST['authors'];
	$trans_group = !empty($_POST['trans_group']) ? $_POST['trans_group'] : $lang['Updating'];
	$trans_group = !empty($_POST['trans_group']) ? $_POST['trans_group'] : $lang['Updating'];
	$released= !empty($_POST['released']) ? $_POST['released'] : 0;
	$group_uploader= !empty($_POST['group_uploader']) ? $_POST['group_uploader'] : 0;
	$description = !empty($_POST['description']) ? $_POST['description'] : $lang['Updating'];

 		// NAME TO SLUG
	$slug = $_POST['slug'];
 		// Define info array
	$inputInfo = array('name'=>$_POST['name'],
		'slug'=>$slug,
		'other_name'=>$other_name,
		'authors'=>$authors,
		'artists'=>$artists,
		'released'=>$released,
		'trans_group'=>$trans_group,
		'magazine'=>$trans_group,
		'magazines'=>$magazines,
		'genres'=>$genres,
		'description'=>$description,
		'm_status'=>$_POST['status'],
		'cover'=>$_POST['cover'],
		'post'=>$now,
		'submitter'=>$_SESSION['userId'],
		'group_uploader'=>$group_uploader);
	$db->Create(APP_TABLES_PREFIX . 'manga_mangas',$inputInfo);
	echo '...';
}