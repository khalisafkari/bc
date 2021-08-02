<?php

 	include '../../../controllers/cont.main.php';
 	if(!$user->isLoggedIn()) {
 		header('Location: /index.html');
 	}

try
{
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'COUNT(id) AS RecordCount', array('manga'=>$_GET['manga']), null, null, null);
		$recordCount = $row[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', '*', array('manga' => $_GET['manga']), null, null , $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);
		//Add all records to an array
		$rows = $result;
		foreach ($rows as &$time) {
			$time['last_update'] = $huy->ago($time['last_update']);
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
		$db->Update(APP_TABLES_PREFIX.'manga_chapters', array('id'=>$id), array('hidden'=>'1'));
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	// Show a record
	else if ($_GET["action"] == "show") {
		$id = $_POST['id'];
		$db->Update(APP_TABLES_PREFIX.'manga_chapters', array('id'=>$id), array('hidden'=>'0'));
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	// //Deleting a record (deleteAction)
	// else if($_GET["action"] == "delete")
	// {
	// 	//Delete from database
	// 	$chapter_info = $h0manga->chapter_info('id',$_POST[id]);
	// 	if(is_dir('../uploads/manga/'.$chapter_info[manga].'/'.$chapter_info[chapter])) { 
	// 		$huy->deleteDir('../uploads/manga/'.$chapter_info[manga].'/'.$chapter_info[chapter]);
	// 	}
	// 	$sql = "DELETE FROM ".APP_TABLES_PREFIX."manga_chapters WHERE id = ".$_POST[id];
	// 	$result = mysqli_query($connection,$sql);

	// 	//Return result to jTable
	// 	$jTableResult = array();
	// 	$jTableResult['Result'] = "OK";
	// 	print json_encode($jTableResult);
	// }
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