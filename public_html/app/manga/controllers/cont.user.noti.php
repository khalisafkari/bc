<?php
include '../../../controllers/cont.main.php';
if(!$user->isLoggedIn()){ header('Location: ../index.html'); }
$id = $_SESSION['userId'];
try
{

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$row = $db->Query(APP_TABLES_PREFIX. 'manga_notification', 'COUNT(id) AS RecordCount', array('user' => $id));
		$recordCount = $row[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_notification', '*', array('user' => $id), null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);
		
		//Add all records to an array
		$rows = $result;
		foreach ($rows as &$cover_time) {
			$cover_time['time'] = $huy->ago($cover_time['time']);
		}
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$isGroup = $db->Query(APP_TABLES_PREFIX.'manga_notification', array('mid', 'cid', 'group_uploader', 'content', 'chapter'), array('id'=>$_POST['id']));
		foreach ($isGroup as $noti) {
			$db->Delete(APP_TABLES_PREFIX.'manga_notification', array('mid'=>$noti['mid'], 'cid'=>$noti['cid'], 'group_uploader'=>$noti['group_uploader'], 'content'=>$noti['content'], 'chapter'=>$noti['chapter']));
		}
		
		$result = mysqli_query($db->Connect(),"DELETE FROM ".APP_TABLES_PREFIX."manga_notification WHERE id = " . $_POST["id"] . ";");
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