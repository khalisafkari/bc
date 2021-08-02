<?php
	include '../../../controllers/cont.main.php';

	$query = $db->Query(APP_TABLES_PREFIX.'manga_mangas','name, cover, last_chapter, id, other_name',array('hidden'=>0));
	foreach($query as $m){
		$manga[$m['name']] = array('image' => $m['cover'], 'description' => 'Last chapter: '.$m['last_chapter'], 'id' => $m['id'], 'other_name' => $m['other_name']); 
	}
?>