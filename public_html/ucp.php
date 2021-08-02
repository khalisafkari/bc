<?php

	include 'controllers/cont.main.php';
	include 'controllers/cont.user.php';

	$title = 'User CP'.(isset($subTitle) ? ' - '.$subTitle : '');

	$view = $_GET['view'];
	if(!isset($_GET['view'])){ $view = 'index'; }

	include 'ucp/index.php';
?>