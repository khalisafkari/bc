<?php

include '../../../controllers/cont.main.php';

if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

if($_POST && MANGA){
	$_POST = $huy->addSlashes($huy->clearXss($_POST));
 		// CHAPTER TO SLUG
	$chapter = $_POST['chapter'];
 		// Define info array
	$thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', array('id','name','slug'), array('slug'=>$_POST['manga']),null,null,null,1);
	$mid = $thisManga['0']['id'];
	$inputInfo = array('name'=>$_POST['name'],
		'manga'=>$_POST['manga'],
		'mid'=>$mid,
		'chapter'=>$chapter,
		'content'=>$_POST['content'],
		'submitter'=>$_POST['submitter'],
		'last_update'=>$now);

	$cid = $result = $db->Create(APP_TABLES_PREFIX . 'manga_chapters',$inputInfo);
	$huy->cacheClear('chapter/chapterList-'.$mid);
	$db->Delete(APP_TABLES_PREFIX . 'manga_chapters_q', array('id'=>$_GET['cid']));
	$thisChapter = $db->Query(APP_TABLES_PREFIX.'manga_chapters', 'max(chapter) as chapter', array('manga'=>$_POST['manga']));
	if ($chapter >= $thisChapter[0]['chapter']) {
		$db->Update(APP_TABLES_PREFIX . 'manga_mangas',array('slug'=>$_POST['manga']),array('last_update'=>$now,'last_chapter'=>$chapter));
		$db->Create(APP_TABLES_PREFIX . 'manga_notification', array('type'=>3, 'name'=>$thisManga[0]['name'], 'mid'=>$mid, 'cid'=>$cid, 'slug'=>$_POST['manga'], 'url'=>'/'.$mid.'/'.$cid.'/','chapter'=>$chapter,'content'=>sprintf($lang['Chapter-accepted'], $chapter, $thisManga[0]['name']), 'user'=>$_POST['submitter'], 'time'=>$now));
	}
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
	}
	echo '...';
}