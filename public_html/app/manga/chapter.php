<?php

	// MAIN CONTROLLER
include '../../controllers/cont.main.php';

// For caching
session_cache_limiter('none');
header('Cache-control: max-age='.(60*60*24*365));
header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*365));
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
	header('HTTP/1.1 304 Not Modified');
	die();
}
		
	// CONTROLLERS OF MANGA PAGE
$mid = (int)$_GET['mid'];
$cid = (int)$_GET['cid'];
$query = $db->Query(APP_TABLES_PREFIX . 'manga_mangas','*',array('id'=>$mid,'hidden'=>0),NULL,NULL,NULL,null);
$thisManga = $huy->stripSlashes($query['0']);

	if(!$user->isLoggedIn()){
			header('Location: https:///');
		}
		else {
			header('Location: https://welovemanga.net/'.$mid.'/'.$cid.'/');
		}

//$cgens = $h0manga->splitGenres($thisManga['genres'],$lang);
	//$isAdult = strpos($cgens,'Adult');
	//$isEcchi = strpos($cgens,'Ecchi');
	//if($isAdult || $isEcchi) { 
				//if(!$user->isLoggedIn()){
					//header('Location: https://lovehug.net/'.$thisManga['id'].'/');
				//}
			//}
$genads = $h0manga->splitGenres($thisManga['genres'],$lang);

//manga hidden
//$numbers = array(1557, 1840, 1841, 1842, 1492, 1493, 1489, 1461, 1468, 1514, 1839, 1793, 1858);
//foreach ($numbers as $id_manga) {
	//if(!$user->isLoggedIn() &&
		//($mid == $id_manga))
	//{
		//header('Location: https://lovehug.net/');
	//}
//}

if(count($query) == 0) {
	header('Location: /index.html');
} else {
	if (!$huy->checkFile('chapter2/'.$mid.'-'.$cid)) {	
		$query2 = $db->Query(APP_TABLES_PREFIX . 'manga_chapters','*',array('id'=>$cid,'mid'=>$mid,'hidden'=>0),NULL,NULL,NULL,null);
		$data = serialize($query2);
		$huy->cacheSqlEnd('chapter2/'.$mid.'-'.$cid, $data);
	}else{
		$query2 = unserialize($huy->cacheSqlEnd('chapter2/'.$mid.'-'.$cid));
	}
	//$query2 = $db->Query(APP_TABLES_PREFIX . 'manga_chapters','*',array('id'=>$cid,'mid'=>$mid,'hidden'=>0),NULL,NULL,NULL,null);
	if (count($query2) == 0) {
		header('Location: /index.html');
	} else {
		$thisChapter = $query2['0'];
	}
}
		// READ TYPE
if($_POST && $_POST['token'] == $_SESSION['token'] && $_POST['action'] == 'type'){
	if($_POST['type'] == '1'){

		setcookie("read_type",  '1',  time() + (10 * 365 * 24 * 60 * 60)); 
		echo '...';
		exit();

	}elseif($_POST['type'] == '2'){

		setcookie("read_type",  '2',  time() + (10 * 365 * 24 * 60 * 60)); 
		echo '...';
		exit();

	}elseif ($_POST['type'] == '3'){
		setcookie("read_type",  '3',  time() + (10 * 365 * 24 * 60 * 60)); 
		echo '...';
		exit();
	}
}		

		// HANDLE READ TYPE

if(empty($_COOKIE['read_type'])){
		//setcookie("read_type",  $c_manga['read_type'],  time() + (10 * 365 * 24 * 60 * 60));
	$_COOKIE['read_type'] = $c_manga['read_type'];
}
$c_manga['read_type'] = ($c_manga['read_type_choose'] == '0') ? $c_manga['read_type'] : $_COOKIE['read_type'];

$page = isset($_GET['page']) ? (int)$_GET['page'] : NULL;

if(!isset($page)){ $page = '1'; }

	// REPLACE TITLE & META
$c_manga['chapter_title'] = preg_replace('/{site_title}/i', $c_manga['site_title'], $c_manga['chapter_title']);
$c_manga['chapter_title'] = preg_replace('/{manga_name}/i', $thisManga['name'], $c_manga['chapter_title']);
$c_manga['chapter_title'] = preg_replace('/{chapter_number}/i', $thisChapter['chapter'], $c_manga['chapter_title']);
$c_manga['chapter_title'] = preg_replace('/{chapter_name}/i', $thisChapter['name'], $c_manga['chapter_title']);
$c_manga['chapter_title'] = preg_replace('/{next_chapter}/i', ($thisChapter['chapter']+1), $c_manga['chapter_title']);
$c_manga['chapter_title'] = preg_replace('/{prev_chapter}/i', ($thisChapter['chapter']-1), $c_manga['chapter_title']);
$c_manga['chapter_title'] = preg_replace('/{manga_other_name}/i', $thisManga['other_name'], $c_manga['chapter_title']);

$c_manga['chapter-meta-description'] = preg_replace('/{manga_name}/i', $thisManga['name'], $c_manga['chapter-meta-description']);
$c_manga['chapter-meta-description'] = preg_replace('/{chapter_number}/i', $thisChapter['chapter'], $c_manga['chapter-meta-description']);
$c_manga['chapter-meta-description'] = preg_replace('/{chapter_name}/i', $thisChapter['name'], $c_manga['chapter-meta-description']);
$c_manga['chapter-meta-description'] = preg_replace('/{next_chapter}/i', ($thisChapter['chapter']+1), $c_manga['chapter-meta-description']);
$c_manga['chapter-meta-description'] = preg_replace('/{prev_chapter}/i', ($thisChapter['chapter']-1), $c_manga['chapter-meta-description']);
$c_manga['chapter-meta-description'] = preg_replace('/{manga_other_name}/i', $thisManga['other_name'], $c_manga['chapter-meta-description']);

$c_manga['chapter-meta-keyword'] = preg_replace('/{manga_name}/i', $thisManga['name'], $c_manga['chapter-meta-keyword']);
$c_manga['chapter-meta-keyword'] = preg_replace('/{manga_genre}/i', $thisManga['genres'], $c_manga['chapter-meta-keyword']);
$c_manga['chapter-meta-keyword'] = preg_replace('/{chapter_number}/i', $thisChapter['chapter'], $c_manga['chapter-meta-keyword']);
$c_manga['chapter-meta-keyword'] = preg_replace('/{chapter_name}/i', $thisChapter['name'], $c_manga['chapter-meta-keyword']);
$c_manga['chapter-meta-keyword'] = preg_replace('/{next_chapter}/i', ($thisChapter['chapter']+1), $c_manga['chapter-meta-keyword']);
$c_manga['chapter-meta-keyword'] = preg_replace('/{prev_chapter}/i', ($thisChapter['chapter']-1), $c_manga['chapter-meta-keyword']);
$c_manga['chapter-meta-keyword'] = preg_replace('/{manga_other_name}/i', $thisManga['other_name'], $c_manga['chapter-meta-keyword']);

	// INCLUDE INDEX IN [THEME] 

include 'themes/'.$c_manga['theme'].'/chapter.php';