<?php

 	include '../../../controllers/cont.main.php';

 	if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

 	if($_POST && MANGA){
 		$_POST = $huy->addSlashes($huy->clearXss($_POST));
		$cid = $_POST['chapterId'];
 		$mid = $_POST['mid'];
 		
 		// CHAPTER TO SLUG
 		$chapter = $_POST[chapter];
 		
 		// Define info array
 		$inputInfo = array('name'=>$_POST[name],
 						   'chapter'=>$chapter,
 						   'content'=>$_POST[content]);
 		$db->Update(APP_TABLES_PREFIX . 'manga_chapters',array('id'=>$_POST[chapterId]),$inputInfo);
 		$huy->cacheClear('chapter/chapterList-'.$mid);
 		$huy->cacheClear('chapter2/'.$mid.'-'.$cid);
 		echo '...';
 	}