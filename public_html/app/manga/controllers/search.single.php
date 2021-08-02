<?php
	include '../../../controllers/cont.main.php';

	$q = $huy->addSlashes($_GET['q']);
	$sql = "SELECT name, cover, id, last_chapter, slug, other_name FROM ".APP_TABLES_PREFIX. "manga_mangas WHERE hidden = 0 AND name LIKE '%".$q."%' OR hidden = 0 AND other_name LIKE '%".$q."%' LIMIT 10";
	$query = mysqli_query($db->Connect(), $sql);
	$results = array();
	while ($m = mysqli_fetch_assoc($query)) {
		$results["$m[name]"] = array('image' => $m['cover'], 'description' => 'Last chapter: '.$m['last_chapter'], 'id' => $m['id'], 'other_name' => $m['other_name']); 
	}
	$final = array('header' => array(), 'data' => array());
	$final['header'] = array(
		'title' => $lang['Manga'],
		'num' => count($results),
		'limit' => 10
	);
	foreach ($results as $name => $data)
	{
		$numbers = array(1557, 332, 333, 331, 1492, 1493, 309, 1489, 1461, 1468, 1514, 37, 1793);
		foreach ($numbers as $id_manga) {
			if(!$user->isLoggedIn() &&
				($data['id'] == $id_manga))
					{
						header('Location: https://lovehug.net/');
					}
				}
		$final['data'][] = array(
			'primary' => $name,
			'secondary' => $data['description'],
			'image' => $data['image'],
			'onclick' => 'window.location=\'/'.$data['id'].'/\''
		);
	}
	header('Content-type: application/json');
	echo json_encode(array($final));
	die();
?>