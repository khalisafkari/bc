<?php
include '../../../controllers/cont.main.php';
if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

try
{

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_mangas_q', 'COUNT(id) AS RecordCount', null, null, null, null);
		$recordCount = $row[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_mangas_q', '*', null, null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);
		
		//Add all records to an array
		$rows = $result;
		foreach ($rows as &$cover_time) {
			$cover_time['last_update'] = $huy->ago($cover_time['last_update']);
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
		$manga_info = $db->Query(APP_TABLES_PREFIX.'manga_mangas_q', 'id,name,submitter', array('id'=>$_POST['id']));
		$manga_info = $manga_info['0'];
		$result = $db->Delete(APP_TABLES_PREFIX. 'manga_mangas_q', array('id'=>$_POST['id']));
		$db->Create(APP_TABLES_PREFIX . 'manga_notification', array('type'=>4,'content'=>'Sorry! Manga '.$manga_info['name'].' has been declined!', 'user'=>$manga_info['submitter'], 'time'=>$now));
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