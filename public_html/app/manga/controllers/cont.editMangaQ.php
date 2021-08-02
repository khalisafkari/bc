<?php

include '../../../controllers/cont.main.php';

if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 



if($_POST && MANGA){
	 		// ADDSLASHES TO ARRAY
	$genres = $_POST['genres'] = $_POST['genres'] ? implode(',', $_POST['genres']) : '';
	$_POST = $huy->addSlashes($huy->clearXss($_POST));
	
	$other_name = !empty($_POST['other_name']) ? $_POST['other_name'] : $lang['Updating'];
	$authors = !empty($_POST['authors']) ? $_POST['authors'] : $lang['Updating'];
	$artists = !empty($_POST['artists']) ? $_POST['artists'] : $_POST['authors'];
	$trans_group = !empty($_POST['trans_group']) ? $_POST['trans_group'] : $lang['Updating'];
	$genres = !empty($genres) ? $genres : $lang['Updating'];
	$magazine = !empty($_POST['trans_group']) ? $_POST['trans_group'] : $lang['Updating'];
	$description = !empty($_POST['description']) ? $_POST['description'] : $lang['Updating'];


 		// NAME TO SLUG
	$slug = $huy->slug($_POST['name']);
 		// Define info array
	$inputInfo = array('name'=>$_POST['name'],
		'slug'=>$slug,
		'other_name'=>$other_name,
		'authors'=>$authors,
		'artists'=>$artists,
		'released'=>$_POST['released'],
		'genres'=>$_POST['genres'],
		'trans_group'=>$trans_group,
		'magazine'=>$magazine,
		'description'=>$description,
		'm_status'=>$_POST['status'],
		'cover'=>$_POST['cover'],
		'submitter'=>$_POST['submitter'],
		'post'=>$now);


	$result = $db->Create(APP_TABLES_PREFIX . 'manga_mangas', $inputInfo);
	$db->Delete(APP_TABLES_PREFIX . 'manga_mangas_q', array('id'=>$_GET['mid']));
	if ($result) {
		$thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas',array('id','name'), array('slug'=>$slug),null,null,null,1);
		$thisManga[0] = $huy->addSlashes($thisManga[0]);
		$mid = $thisManga['0']['id'];
		$db->Create(APP_TABLES_PREFIX . 'manga_notification', array('type'=>'3.5','name'=>$_POST['name'], 'mid'=>$mid, 'slug'=>$slug, 'url'=>'/'.$mid.'/','content'=>sprintf($lang['Manga-accepted'], $_POST['name']), 'user'=>$_POST['submitter'], 'time'=>$now));
	}
	echo '...';
}