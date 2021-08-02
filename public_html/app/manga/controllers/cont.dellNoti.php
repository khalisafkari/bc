<?php
 	include '../../../controllers/cont.main.php';

 	if(isset($_POST) && $_POST['type'] == 'read'){
		$db->Update(APP_TABLES_PREFIX.'manga_notification',array('user'=>$_SESSION['userId'],'id'=>$_POST['id']), array('see'=>1));
		echo '...';
	}
	if (isset($_POST) && $_POST['type'] == 'read-all') {
		$db->Update(APP_TABLES_PREFIX.'manga_notification',array('user'=>$_SESSION['userId']), array('see'=>1));
		echo '...';
	}