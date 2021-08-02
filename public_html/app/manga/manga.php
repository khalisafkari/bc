<?php
	// MAIN CONTROLLER
include '../../controllers/cont.main.php';

	if(!$user->isLoggedIn()){
			header('Location: https:///');
		} else {
			header('Location: https://welovemanga.net/'.$mid.'/');
		}
	// CONTROLLERS OF MANGA PAGE
$mid = (int)$_GET['mid'];
$query = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('id'=>$mid,'hidden'=>0),NULL,NULL,NULL,null);
if(count($query) == 0) {
	header('Location: /index.html');
} else {
	$thisManga = $huy->clearXss($huy->stripSlashes($query['0']));
}


//manga hidden
//$numbers = array(1557, 1840, 1841, 1842, 1492, 1493, 1489, 1461, 1468, 1514, 1839, 1793, 1858);
//foreach ($numbers as $id_manga) {
	//if(!$user->isLoggedIn() &&
		//($mid == $id_manga))
			//{
				//header('Location: https://lovehug.net/');
			//}
//}
	// REPLACE TITLE
$c_manga['manga_title'] = preg_replace('/{site_title}/i', $c_manga['site_title'], $c_manga['manga_title']);
$c_manga['manga_title'] = preg_replace('/{manga_name}/i', $thisManga['name'], $c_manga['manga_title']);
$c_manga['manga_title'] = preg_replace('/{manga_other_name}/i', $thisManga['other_name'], $c_manga['manga_title']);

$c_manga['manga-meta-description'] = preg_replace('/{manga_name}/i', $thisManga['name'], $c_manga['manga-meta-description']);
$c_manga['manga-meta-description'] = preg_replace('/{manga_other_name}/i', $thisManga['other_name'], $c_manga['manga-meta-description']);

$c_manga['manga-meta-keyword'] = preg_replace('/{manga_name}/i', $thisManga['name'], $c_manga['manga-meta-keyword']);
$c_manga['manga-meta-keyword'] = preg_replace('/{manga_genre}/i', $thisManga['genres'], $c_manga['manga-meta-keyword']);
$c_manga['manga-meta-keyword'] = preg_replace('/{manga_other_name}/i', $thisManga['other_name'], $c_manga['manga-meta-keyword']);

	// INCLUDE INDEX IN [THEME] 

include 'themes/'.$c_manga['theme'].'/manga.php';