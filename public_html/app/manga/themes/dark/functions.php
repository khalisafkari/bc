<?php 


function chapter_select($chapter, $mangaId = null){
	global $lang;
	global $db;
	global $huy;
	echo '<select class="form-control" onchange="window.location=this.value;">';
	if (!$huy->checkFile('chapter/chapterList-'.$mangaId)) {
		$result = $db->Query(APP_TABLES_PREFIX.'manga_chapters', array('id', 'chapter', 'name', 'mid', 'manga', 'views'), array('mid'=>$mangaId, 'hidden'=>0), null, null, 'chapter DESC', null);
		$data = serialize($result);
		$huy->cacheSqlEnd('chapter/chapterList-'.$mangaId, $data);
	} else {
		$result = unserialize($huy->cacheSqlEnd('chapter/chapterList-'.$mangaId));
	}
	foreach ($result as $row) {
		$url = '/'.$row['mid'].'/'.$row['id'].'/';
		echo "<option value='$url'".($chapter['chapter'] == $row['chapter'] ? 'selected' : '').">$lang[Chapter] $row[chapter]&nbsp;&nbsp;</option>";
	}
	echo '</select>';
}
function check_chapter($slug,$chapter){
	global $db;
	$pre_chap_info = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'chapter', array('chapter'=>$chapter, 'hidden' => 0, 'manga'=>$slug), null, null, null, 1);
	$pre_chap_num = count($pre_chap_info[0]);
	if($pre_chap_num > 0){ return true; }else{ return false; }

}
function next_chapter($thisChapter,$manga) {
	global $db;
	$result = mysqli_query($db->Connect(),"SELECT min(chapter) as chapter FROM ".APP_TABLES_PREFIX."manga_chapters WHERE manga = '$manga' AND chapter > '$thisChapter' AND hidden = 0 LIMIT 1");
	$next_chapter = mysqli_fetch_assoc($result);
	return $next_chapter['chapter'];

}
function pre_chapter($thisChapter,$manga) {
	global $db;
	$result = mysqli_query($db->Connect(),"SELECT max(chapter) as chapter FROM ".APP_TABLES_PREFIX."manga_chapters WHERE manga = '$manga' AND chapter < '$thisChapter' AND hidden = 0 LIMIT 1");
	$pre_chapter = mysqli_fetch_assoc($result);
	return $pre_chapter['chapter'];
}

function page_select($page,$imgs,$thisChapter){
	global $db;
	global $lang;
	
	$next_page = (int)$page+1;
	$pre_page = (int)$page-1;
	$count_imgs = count($imgs);
	echo ($page <> '1' ? "<a href='/$thisChapter[mid]/$thisChapter[id]/$pre_page/' class='label label-info'>$lang[Previous_page]</a>&nbsp;&nbsp;" : '');
	echo 'Page: <select onchange="window.location=this.value;">';
	for($i = 1; $i < count($imgs); $i++){
		if($page == $i){
			echo "<option value=\"/$thisChapter[mid]/$thisChapter[id]/$i/\" selected>$i</option>";
		}else{
			echo "<option value=\"/$thisChapter[mid]/$thisChapter[id]/$i/\">$i</option>";
		}
	}
	echo "<option value=\"/$thisChapter[mid]/$thisChapter[id]/$count_imgs/\">$lang[Comment]</option>"; 
	echo '</select>';
	echo ($page < count($imgs)-1 ? "&nbsp;&nbsp;<a href='/$thisChapter[mid]/$thisChapter[id]/$next_page/' class='label label-info'>$lang[Next_page]</a>" : ($page == count($imgs)-1 ? "&nbsp;&nbsp;<a href='/$thisChapter[mid]/$thisChapter[id]/$next_page/' class='label label-danger'>$lang[Comment]</a>" : ''));
	echo '<br /><br />';
}