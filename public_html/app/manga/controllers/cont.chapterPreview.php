<?php
include '../../../controllers/cont.main.php';

 	if(!$user->isLoggedIn()){ header('Location: ../index.html'); }
 	if ($_POST && MANGA) {
 		if ($_GET['type'] == 'chapter') {
 			$table = 'manga_chapters';
 		} elseif ($_GET['type'] == 'chapterq') {
 			$table = 'manga_chapters_q';
 		}
 		$result = $db->Query(APP_TABLES_PREFIX.$table, 'content', array('id'=>$_POST['id']));
 		$content = $result[0]['content'];
 		$content = str_replace('https://', 'http://', $content);
 		$arr = explode('http://', $content);
 		array_shift($arr);
 		$imgs = '';
 		foreach ($arr as $img) {
 			$url = 'http://'.$img;
 			$img = '<img class="list-img" src="'.$url.'"><br />';
 			$imgs .= $img;
 		}
 		echo $imgs;
 	}