<?php

include '../../../controllers/cont.main.php';

if(!$user->isLoggedIn()){ header('Location: ../index.html'); } 

if($_POST && $_POST['token'] == $_SESSION['token'] && MANGA){
    //$genres = $_POST['genres'] = $_POST['genres'] ? implode(',', $_POST['genres']) : '';
	// ADDSLASHES TO ARRAY
	$genres = $_POST['genres'] = $_POST['genres'] ? implode(',', $_POST['genres']) : '';
	$magazines = $_POST['magazines'] = $_POST['magazines'] ? implode(',', $_POST['magazines']) : '';
	$_POST = $huy->addSlashes($huy->clearXss($_POST));
	
	// NAME TO SLUG
	$slug = $huy->slug($_POST['name']);
	
	if ($huy->isExist(APP_TABLES_PREFIX.'manga_mangas', 'id', array('slug'=>$slug))) {
		$user->alert('danger', 'This manga already exists!');
		exit();
	}
	$other_name = !empty($_POST['other_name']) ? $_POST['other_name'] : 'Updating';
	$authors = !empty($_POST['authors']) ? $_POST['authors'] : 'Updating';
	$artists = !empty($_POST['artists']) ? $_POST['artists'] : $authors;
	$trans_group = !empty($_POST['trans_group']) ? $_POST['trans_group'] : 'Updating';
	$genres = !empty($genres) ? $genres : 'Updating';
	$magazines = !empty($magazines) ? $magazines : 'Updating';
	$description = !empty($_POST['description']) ? $_POST['description'] : 'Updating';
	$group_uploader = !empty($_POST['id_group']) ? $_POST['id_group'] : 0;

 		// Define info array
	$inputInfo = array('name'=>$_POST['name'],
		'slug'=>$slug,
		'other_name'=>$other_name,
		'authors'=>$authors,
		'artists'=>$artists,
		'released'=>$_POST['released'],
		'genres'=>$genres,
		'trans_group'=>$trans_group,
		'magazines'=>$magazines,
		'description'=>$description,
		'm_status'=>$_POST['status'],
		'cover'=>$_POST['cover'],
		'last_update'=>$now,
		'submitter'=>$_SESSION['userId'],
		'group_uploader'=>$_POST['id_group']
		);
	if($_POST['name'] == NULL || $_POST['description'] == NULL || $_POST['cover'] == NULL){
		$user->alert('danger',$lang['Name-des-cover-null']);
	}else if($_COOKIE['post'] == 1){	
		$user->alert('danger',$lang['Submit-limit']);
	}else{
		$isGroup = $db->Query(APP_TABLES_PREFIX.'user', 'group_uploader',array('id'=>$_SESSION['userId']));
		if ($isGroup[0]['group_uploader'] != 0) {
			$db->Create(APP_TABLES_PREFIX . 'manga_mangas',$inputInfo);
		} else {
			$db->Create(APP_TABLES_PREFIX . 'manga_mangas_q',$inputInfo);
			setcookie("post",  '1',  time() + 60, '/', NULL, 0 );
		}
		$huy->cacheClear('home_content');
		$huy->cacheClear('manga-option-list');
 		$huy->cacheClear('list_abc');
		echo '...';
	}
}