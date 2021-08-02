<?php

 	include '../../../controllers/cont.main.php';

 	if(!$user->isLoggedIn()){ header('Location: ../index.html'); }
 	if($_POST && MANGA){
 		// ADDSLASHES TO ARRAY
 		$_POST['genres'] = $_POST['genres'] ? implode(',', $_POST['genres']) : $lang['Updating'];
 		$_POST['magazines'] = $_POST['magazines'] ? implode(',', $_POST['magazines']) : $lang['Updating'];
 		$_POST = $huy->addSlashes($huy->clearXss($_POST));

 		$other_name = !empty($_POST['other_name']) ? $_POST['other_name'] : $lang['Updating'];
	 	$authors = !empty($_POST['authors']) ? $_POST['authors'] : $lang['Updating'];
	 	$artists = !empty($_POST['artists']) ? $_POST['artists'] : $authors;
	 	$trans_group = !empty($_POST['trans_group']) ? $_POST['trans_group'] : $lang['Updating'];
	 	$genres = !empty($_POST['genres']) ? $_POST['genres'] : $lang['Updating'];
	 	$magazines = !empty($_POST['magazines']) ? $_POST['magazines'] : $lang['Updating'];
	 	$trans_group = !empty($_POST['trans_group']) ? $_POST['trans_group'] : $lang['Updating'];
	 	$description = !empty($_POST['description']) ? $_POST['description'] : $lang['Updating'];
	 	$group_uploader = !empty($_POST['group_uploader']) ? $_POST['group_uploader'] : 0;
		$released = !empty($_POST['released']) ? $_POST['released'] : 0;
 		
 		// Define info array
 		$inputInfo = array('name'=>$_POST['name'],
 						   'other_name'=>$other_name,
 						   'authors'=>$authors,
 						   'artists'=>$artists,
 						   'released'=>$released,
 						   'genres'=>$genres,
 						   'trans_group'=>$trans_group,
 						   'magazines'=>$magazines,
 						   'description'=>$description,
 						   'm_status'=>$_POST['status'],
 						   'last_chapter'=>$_POST['last_chapter'],
 						   'cover'=>$_POST['cover']);
 		$db->Update(APP_TABLES_PREFIX . 'manga_mangas',array('id'=>$_GET['mid']),$inputInfo);
 		echo '...';
 	}