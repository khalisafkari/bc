<?php 


function chapter_select($chapter){
	global $lang;
	global $db;
	echo '<select class="form-control" onchange="window.location=this.value;">';
	$result = $db->Query(APP_TABLES_PREFIX. "manga_chapters", 'chapter', array('manga'=> $chapter['manga'], 'hidden' => 0), null, null, 'chapter DESC', null);
	foreach ($result as $row) {
		$url = $lang['read_slug'].'-'.$chapter['manga'].'-'.$lang['chapter_slug'].'-'.$row['chapter'].'.html';
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
	echo ($page <> '1' ? "<a href='$lang[read_slug]-$thisChapter[manga]-$lang[chapter_slug]-$thisChapter[chapter]-$lang[page_slug]-$pre_page.html' class='label label-info'>$lang[Previous_page]</a>&nbsp;&nbsp;" : '');
	echo 'Page: <select onchange="window.location=this.value;">';
	for($i = 1; $i < count($imgs); $i++){
		if($page == $i){
			echo "<option value=\"$lang[read_slug]-$thisChapter[manga]-$lang[chapter_slug]-$thisChapter[chapter]-$lang[page_slug]-$i.html\" selected>$i</option>";
		}else{
			echo "<option value=\"$lang[read_slug]-$thisChapter[manga]-$lang[chapter_slug]-$thisChapter[chapter]-$lang[page_slug]-$i.html\">$i</option>";
		}
	}
	echo "<option value=\"$lang[read_slug]-$thisChapter[manga]-$lang[chapter_slug]-$thisChapter[chapter]-$lang[page_slug]-$count_imgs.html\">$lang[Comment]</option>"; 
	echo '</select>';
	echo ($page < count($imgs)-1 ? "&nbsp;&nbsp;<a href='$lang[read_slug]-$thisChapter[manga]-$lang[chapter_slug]-$thisChapter[chapter]-$lang[page_slug]-$next_page.html' class='label label-info'>$lang[Next_page]</a>" : ($page == count($imgs)-1 ? "&nbsp;&nbsp;<a href='$lang[read_slug]-$thisChapter[manga]-$lang[chapter_slug]-$thisChapter[chapter]-$lang[page_slug]-$next_page.html' class='label label-danger'>$lang[Comment]</a>" : ''));
	echo '<br /><br />';
}