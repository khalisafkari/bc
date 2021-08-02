<?php

include '../../../controllers/cont.main.php';

if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

if($_POST && MANGA){
 		// ADDSLASHES TO ARRAY
	$_POST = $huy->addSlashes($huy->clearXss($_POST));
 		// CHAPTER TO SLUG
	$chapter = (double)$_POST['chapter'];
 		// Define info array
 	$mid = (int)$_POST['mid'];
	$thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', array('name, slug'), array('id'=>$mid),null,null,null,null);

	$inputInfo = array('name'=>$_POST['name'],
		'manga'=>$thisManga[0]['slug'],
		'mid'=>$mid,
		'chapter'=>$chapter,
		'content'=>$_POST['content'],
		'submitter'=>$_SESSION['userId'],
		'last_update'=>$now);
	$cid = $result = $db->Create(APP_TABLES_PREFIX . 'manga_chapters',$inputInfo);
	if ($result) {
		$thisChapter = $db->Query(APP_TABLES_PREFIX.'manga_chapters', 'max(chapter) as chapter', array('mid'=>$mid),NULL,NULL,NULL,1);

		if ($chapter >= $thisChapter[0]['chapter']) {
			$db->Update(APP_TABLES_PREFIX . 'manga_mangas',array('id'=>$mid),array('last_update'=>$now,'last_chapter'=>$thisChapter[0]['chapter']));

			// WHO BOOKMARK THIS ?
			$whoBookmark = $db->Query(APP_TABLES_PREFIX. 'manga_bookmark', 'user', array('manga'=>$mid));
			$data = '';
			$url = '/'.$mid.'/'.$cid.'/';
			$content = sprintf($lang['noti-new-chapter'], $thisManga[0]['name'], $thisChapter[0]['chapter']);
			foreach ($whoBookmark as $user) {
				$data .= '(2,'.$mid.','.$cid.',\''.$thisManga[0]['name'].'\',\''.$thisManga[0]['slug'].'\',\''.$url.'\','.$thisChapter[0]['chapter'].',0,\''.$content.'\','.$user['user'].',\''.$now.'\',0),';
			}
			mysqli_query($db->Connect(), 'INSERT INTO '.APP_TABLES_PREFIX.'manga_notification(type, mid, cid, name, slug, url, chapter, group_uploader, content, user, time, see) VALUES '.trim($data, ','));
		}
		$huy->cacheClear('chapter/chapterList-'.$mid);
	}

	echo '...';
}