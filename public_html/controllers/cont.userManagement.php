<?php
include 'cont.main.php';
if(!$user->isAdmin()){ header('Location: ../index.html'); } 

try
{
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{

		//Get record count
		$row = $db->Query(APP_TABLES_PREFIX. 'user', 'COUNT(*) AS RecordCount');
		$recordCount = $row[0]['RecordCount'];

		//Get records from database
		$result = $db->Query(APP_TABLES_PREFIX. 'user', '*', null, null, null, $_GET["jtSorting"], $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]);
		//Add all records to an array
		$rows = $result;

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{
		$pw = sha1($_POST[password]);
		//Insert record into database
		$id = $db->Create(APP_TABLES_PREFIX. 'user', array('name' => $_POST[name], 'email' => $_POST[email], 'password' => $pw, 'role' => $_POST['role'], 'register_ip' => '127.0.0.1', 'register_date' => $now));

		//insert user_meta
		$db->Create(APP_TABLES_PREFIX.'user_meta', array('user'=>$id,'avatar'=>'haha.png'));

		//Get last inserted record (to return to jTable)
		$result = array(
			'id' => $id,
			'name' => $_POST['name'],
			'password' => $pw,
			'role' => $_POST['role'],
			'register_ip' => '127.0.0.1',
			'register_date' => date('Y-m-d H:i:s')
		);
		$row = $result;

		//Return result to jTable
		$jTableResult = array();
		$jTableResult[Result] = "OK";
		$jTableResult[Record] = $row;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = mysqli_query($db->Connect(),"UPDATE ".APP_TABLES_PREFIX."user SET name = '$_POST[name]', email = '$_POST[email]', role = '$_POST[role]', register_ip = '$_POST[register_ip]', register_date = '$_POST[register_date]' WHERE id = '$_POST[id]'");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		mysqli_query($db->Connect(),"DELETE FROM ".APP_TABLES_PREFIX."user_meta WHERE user = ".$_POST['id'].";");
		
		$result = mysqli_query($db->Connect(),"DELETE FROM ".APP_TABLES_PREFIX."user WHERE id = " . $_POST["id"] . ";");

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