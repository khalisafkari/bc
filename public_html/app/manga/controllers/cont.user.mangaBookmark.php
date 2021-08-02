<?php
include '../../../controllers/cont.main.php';
if(!$user->isLoggedIn()){ header('Location: ../index.html'); } 
$id = $_SESSION['userId'];
try
{

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		if ($_POST['type']) {
			if ($_POST['type'] == 1) {
				$check = 'AND m.hidden = 1';
			} else {
				$check = 'AND m.hidden = 0';
			}
		} else {
			$check = '';
		}

			//Get record count
		$result = mysqli_query($db->Connect(),"SELECT COUNT(m.id) AS RecordCount FROM ".APP_TABLES_PREFIX."manga_mangas m INNER JOIN ".APP_TABLES_PREFIX."manga_bookmark b ON m.id = b.manga WHERE user = ".$id." AND m.name LIKE '%".$_POST['name']."%' ".$check.";");
		$row = mysqli_fetch_assoc($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
		$result = mysqli_query($db->Connect(),"SELECT * FROM ".APP_TABLES_PREFIX."manga_mangas m INNER JOIN ".APP_TABLES_PREFIX."manga_bookmark b ON m.id = b.manga WHERE user = ".$id." AND m.name LIKE '%".$_POST['name']."%' ".$check." ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");

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
			$cid['released'] = $h0manga->chapter_id($cid['manga'],$cid['last_chapter']);
		}
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
		$manga_info = $h0manga->manga_info('id',$_POST[id]);
		$result = $db->Delete(APP_TABLES_PREFIX. 'manga_bookmark', array('user' => $id, 'manga' => $_POST['id']));
		$huy->cacheClear('home_content');
		$huy->cacheClear('manga-option-list');
		$huy->cacheClear('list_abc');
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