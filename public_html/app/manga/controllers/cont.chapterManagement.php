<?php

 	include '../../../controllers/cont.main.php';
 	if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

try {
	
	// Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$row = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'COUNT(id) AS RecordCount', array('mid'=>(int)$_GET['mid']));
		$recordCount = $row[0]['RecordCount'];

		//Get records from database

		$result = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', '*', array('mid'=>(int)$_GET['mid']), null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);
		
		//Add all records to an array
		$rows = $result;

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Update a record (hidden record)
	else if ($_GET["action"] == "hidden") {
		$id = (int)$_POST['id'];
		$db->Update(APP_TABLES_PREFIX.'manga_chapters', array('id'=>$id), array('hidden'=>'1'));
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	// Show a record
	else if ($_GET["action"] == "show") {
		$id = (int)$_POST['id'];
		$db->Update(APP_TABLES_PREFIX.'manga_chapters', array('id'=>$id), array('hidden'=>'0'));
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete" && $user->isAdmin())
	{
		//$cid = $_POST['id'];
		//Delete from database
		 $chapter_info = $h0manga->chapter_info('id',$_POST[id]);
		 $mid = $chapter_info['mid'];
		// if(is_dir('../uploads/manga/'.$chapter_info[manga].'/'.$chapter_info[chapter])) { 
		// 	$huy->deleteDir('../uploads/manga/'.$chapter_info[manga].'/'.$chapter_info[chapter]);
		// }
		$db->Delete(APP_TABLES_PREFIX. 'manga_chapters', array('id' => (int)$_POST['id']));
		$huy->cacheClear('home_content');
		$huy->cacheClear('info-manga/'.$manga_info[slug]);
		$huy->cacheClear('chaplist/'.$manga_info[slug]);
		$huy->cacheClear('listcomment/'.$manga_info[slug]);
		$huy->cacheClear('chapter/chapterList-'.$mid);
		$huy->cacheClear('chapter2/'.$mid.'-'.$_POST['id']);

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