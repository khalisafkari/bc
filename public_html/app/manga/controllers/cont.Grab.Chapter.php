<?php 
include '../../../controllers/cont.main.php';
if(!$user->isAdmin()){ header('Location: ../index.html'); }
if ($_POST && MANGA && $_POST['token'] == $_SESSION['token']) {

	if ($_POST['site'] === 'loveheaven') {
		$url_chapter = 'https://lhnovels.net/'.$_POST['url'];
		$name_chapter = $_POST['name'];
		$html = $huy->curl(trim($url_chapter));
		preg_match('#Chapter ([\d.]+)#si', $name_chapter, $so_chapter);
		$chapter = abs($so_chapter[1]);
		$other_name = 'Chapter '.$chapter;
		//preg_match('#id="image".*</div>#imsU', $html, $img);
		$img_full = null;
		preg_match_all('#data-src=\'(.*)\'#imsU', $html, $img2);
		//$img_full = $huy->base64Decode($img2[1]);
		$img_full = implode(chr(13), $img2[1]);
		//$img_full = preg_replace('#https://images2.*\&url=#imsU', '', $img_full);
		$cid = $result = $db->Create(APP_TABLES_PREFIX.'manga_chapters',array('chapter'=>$chapter,'manga'=>$_POST['slug'],'mid'=>(int)$_POST['mid'],'name'=>$other_name, 'content'=>$img_full,'last_update'=>$now));
		$mid = $_POST['mid'];
		$name = $_POST['name_manga'];
		if ($result) {
			$message = 'Chap '.$chapter.' <b>'.$_POST['name_manga'].'</b> done! <br />';
			echo $message;
			$whoBookmark = $db->Query(APP_TABLES_PREFIX. 'manga_bookmark', 'user', array('manga'=>$mid));
			foreach($whoBookmark as $one){	
			$db->Create(APP_TABLES_PREFIX . 'manga_notification', array('type'=>2,'mid'=>$mid, 'name'=>$name, 'slug'=>$manga, 'url'=>'/'.$mid.'/'.$cid.'/','chapter'=>$chapter,'content'=>'The manga '.$name.'  you are following has a new chapter '.$chapter, 'user'=>$one['user'], 'time'=>$now));
			}
		}
	}
}

?>