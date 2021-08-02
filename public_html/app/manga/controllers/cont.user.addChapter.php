<?php

include '../../../controllers/cont.main.php';

if(!$user->isLoggedIn()){ header('Location: ../index.html'); } 

if($_POST && $_POST['token'] == $_SESSION['token'] && MANGA){
 		// ADDSLASHES TO ARRAY
	$_POST = $huy->addSlashes($huy->clearXss($_POST));

 		// CHAPTER TO SLUG
	$chapter = $_POST['chapter'];
	$thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', array('id','name','slug'), array('slug'=>$_POST['manga']),null,null,null,1);
	$mid = (int)$thisManga['0']['id'];
 		// Define info array
	$inputInfo = array('name'=>$_POST['name'],
		'manga'=>$_POST['manga'],
		'mid'=>$mid,
		'chapter'=>$chapter,
		'content'=>$_POST['content'],
		'submitter'=>$_SESSION['userId'],
		'last_update'=>$now);
	if($_POST['chapter'] == NULL || $_POST['manga'] == NULL || $_POST['content'] == NULL){
		$user->exitAlert('danger',$lang['chapter-manga-content-null']);
	}else if(isset($_COOKIE['post']) == 1){	
		$user->exitAlert('danger',$lang['Submit-limit']);
	}else{
		$isGroup = $db->Query(APP_TABLES_PREFIX.'user', 'group_uploader',array('id'=>$_SESSION['userId']));
		if ($isGroup[0]['group_uploader'] != 0) {
			$cid = $result = $db->Create(APP_TABLES_PREFIX . 'manga_chapters',$inputInfo);
			if ($result) {
				$thisChapter = $db->Query(APP_TABLES_PREFIX.'manga_chapters', 'max(chapter) as chapter', array('manga'=>$_POST['manga']),NULL,NULL,NULL,1);
				if ($chapter >= $thisChapter[0]['chapter']) {
					$db->Update(APP_TABLES_PREFIX . 'manga_mangas',array('slug'=>$_POST['manga']),array('last_update'=>$now,'last_chapter'=>$thisChapter[0]['chapter']));
					// WHO BOOKMARK THIS ?
					$whoBookmark = $db->Query(APP_TABLES_PREFIX. 'manga_bookmark', 'user', array('manga'=>$mid));
					$data = '';
					$url = '/'.$lang['read_slug'].'-'.$_POST['manga'].'-'.$lang['chapter_slug'].'-'.$thisChapter[0]['chapter'].'.html';
					$content = sprintf($lang['noti-new-chapter'], $thisManga[0]['name'], $thisChapter[0]['chapter']);
					foreach ($whoBookmark as $user) {
						$data .= '(2,'.$mid.','.$cid.',\''.$thisManga[0]['name'].'\',\''.$_POST['manga'].'\',\''.$url.'\','.$thisChapter[0]['chapter'].',0,\''.$content.'\','.$user['user'].',\''.$now.'\',0),';
					}
					mysqli_query($db->Connect(), 'INSERT INTO '.APP_TABLES_PREFIX.'manga_notification(type, mid, cid, name, slug, url, chapter, group_uploader, content, user, time, see) VALUES '.trim($data, ','));
				}
			}
		} else {
			$db->Create(APP_TABLES_PREFIX . 'manga_chapters_q',$inputInfo);
			setcookie("post",  '1',  time() + 60, '/', NULL, 0 );
		}
		$huy->cacheClear('chapter/chapterList-'.$mid);

		echo '...';
	}
}
