<?php
 	include '../../../controllers/cont.main.php';
 	if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } 

try
{
	
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$row = $db->Query(APP_TABLES_PREFIX. 'manga_chapters_q', 'COUNT(id) AS RecordCount');
		$recordCount = $row[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'manga_chapters_q', '*', null, null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);
		
		//Add all records to an array
		$rows = $result;

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
		$chapter_info = $db->Query(APP_TABLES_PREFIX.'manga_chapters_q', 'chapter,manga,submitter', array('id'=>$_POST['id']));
		$chapter_info = $chapter_info['0'];
		$mid = $chapter_info['mid'];
		$db->Delete(APP_TABLES_PREFIX. 'manga_chapters_q', array('id' => $_POST['id']));
		
 		$db->Create(APP_TABLES_PREFIX . 'manga_notification', array('type'=>4, 'content'=>'Chap '.$chapter_info['chapter'].' of manga '.$chapter_info['manga'].' that you uploaded has been declined!', 'user'=>$chapter_info['submitter'], 'time'=>$now));
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