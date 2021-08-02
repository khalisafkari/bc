<?php 
if ($_GET) {
	$id = (int) $_GET['id'];
	$data = json_decode($_COOKIE['history'], true);
	unset($data[$id]);
	$result = json_encode($data);
	setcookie('history', $result, time() + 60*60*24*365, '/');
}
