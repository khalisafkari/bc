<?php
include '../../../controllers/cont.main.php';
if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

try
{
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{

		if ($_POST['type']) {
			if ($_POST['type'] == 1) {
				$check = 'AND hidden = 1';
			} else {
				$check = 'AND hidden = 0';
			}
		} else {
			$check = '';
		}
		$userPost = ($_POST['UserPost']) ? 'AND submitter != 1' : '';
		
		//Get record count
		$result = mysqli_query($db->Connect(),"SELECT COUNT(id) AS RecordCount FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE '%".$_POST['name']."%' ".$check." " .$userPost. ";");
		$row = mysqli_fetch_assoc($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
		$result = mysqli_query($db->Connect(),"SELECT * FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE '%".$_POST['name']."%' ".$check." " .$userPost. " ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_assoc($result))
		{
		    $rows[] = $huy->stripSlashes($row);
		}
		if ($rows) {
			foreach ($rows as &$cover_time) {
			$cover_time['last_update'] = $huy->ago($cover_time['last_update']);
		}
		}
		if ($rows) {
			foreach ($rows as &$cid) {
			$cid['released'] = $h0manga->chapter_id($cid['id'],$cid['last_chapter']);
		}
		}
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Update a record (hidden record)
	else if ($_GET["action"] == "hidden") {
		$id = $_POST['id'];
		$manga_info = $h0manga->manga_info('id', $id);
		$db->Update(APP_TABLES_PREFIX.'manga_mangas', array('id'=>$id), array('hidden'=>'1'));
		$db->Update(APP_TABLES_PREFIX.'manga_chapters', array('manga'=>$manga_info['slug']), array('hidden'=>'1'));
		$huy->cacheClear('home_content');
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}

	// Show a record
	else if ($_GET["action"] == "show") {
		$id = $_POST['id'];
		$manga_info = $h0manga->manga_info('id', $id);
		$db->Update(APP_TABLES_PREFIX.'manga_mangas', array('id'=>$id), array('hidden'=>'0'));
		$db->Update(APP_TABLES_PREFIX.'manga_chapters', array('manga'=>$manga_info['slug']), array('hidden'=>'0'));
		$huy->cacheClear('home_content');
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}

	// Update time and chapter
	else if ($_GET["action"] == "update") {
		$id = $_POST['id'];
		$manga_info = $h0manga->manga_info('id', $id);
		$thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'max(chapter) as chapter', array('manga'=>$manga_info['slug'], 'hidden' => 0));
		$db->Update(APP_TABLES_PREFIX. 'manga_mangas', array('id'=>$id), array('last_chapter'=>$thisChapter[0]['chapter'], 'last_update'=>$now));
		
		$huy->cacheClear('home_content');
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete" && $user->isAdmin())
	{
		//Delete from database
		$manga_info = $h0manga->manga_info('id',$_POST[id]);
		$db->Delete(APP_TABLES_PREFIX.'manga_chapters',array('manga'=>$manga_info[slug]));
		$db->Delete(APP_TABLES_PREFIX. 'manga_mangas', array('id' => $_POST['id']));
		if(is_dir('../uploads/manga/'.$manga_info[slug].'/')){ $huy->deleteDir('../uploads/manga/'.$manga_info[slug].'/'); }
		if(strpos($manga_info[cover],'pp/manga/uploads/covers/')){
			$path_parts = pathinfo($manga_info[cover]);
			unlink('../uploads/covers/'.$path_parts['filename'].'.'.$path_parts['extension']);
		}
		$huy->cacheClear('home_content');
		$huy->cacheClear('info-manga/'.$manga_info[slug]);
		$huy->cacheClear('chaplist/'.$manga_info[slug]);
		$huy->cacheClear('listcomment/'.$manga_info[slug]);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}

?>