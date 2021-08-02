<?php
    error_reporting(0);
	include 'controllers/cont.main.php';
	include 'controllers/cont.user.php';

	// ADMIN CLASSES
	include 'classes/class.admin.php';
	$admin = new admin($config);

	$title = 'ADMIN CP'.(isset($subTitle) ? ' - '.$subTitle : '');

	$view = isset($_GET['view']) ? $_GET['view'] : NULL; 
	$app_view = isset($_GET['app_view']) ? $_GET['app_view'] : NULL;
	$app = isset($_GET['app']) ? $_GET['app'] : NULL;
	
	include 'acp/index.php';


?>