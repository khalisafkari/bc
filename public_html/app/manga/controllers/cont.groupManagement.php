<?php
include '../../../controllers/cont.main.php';
if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

try {

	//Getting records (listAction)
	if($_GET["action"] == "list") {

		//Get record count	
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_groups', 'COUNT(id) AS RecordCount');
		$recordCount = $result[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_groups', '*', null, null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);

		//Add all records to an array
		$rows = $result;
		if ($rows) {
			foreach ($rows as &$cover_time) {
				$cover_time['time'] = $huy->ago($cover_time['time']);
			}
		}
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);

	} else if($_GET["action"] == "delete") {
		//Delete from database
		$thisUser = $db->Query(APP_TABLES_PREFIX.'manga_groups', 'user', array('id'=>$_POST['id']));
		$listUser = explode(',' ,$thisUser[0]['user']);
		foreach ($listUser as $idUser) {
			$db->Update(APP_TABLES_PREFIX.'user', array('id'=>$idUser), array('group_uploader'=>0));
		}
		$db->Delete(APP_TABLES_PREFIX. 'manga_groups', array('id'=>$_POST['id']));

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