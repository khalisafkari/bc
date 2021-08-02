<?php
include '../../../controllers/cont.main.php';
if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

try {

	//Getting records (listAction)
	if($_GET["action"] == "list") {

		//Get record count	
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_genres', 'COUNT(id) AS RecordCount');
		$recordCount = $result[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_genres', '*', null, null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);

		//Add all records to an array
		$rows = $result;

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);

	} else if($_GET["action"] == "delete") {
		//Delete from database
		$db->Delete(APP_TABLES_PREFIX. 'manga_genres', array('id'=>$_POST['id']));

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