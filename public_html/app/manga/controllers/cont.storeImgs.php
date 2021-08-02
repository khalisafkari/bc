<?php
 	include '../../../controllers/cont.main.php';

	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);


	/**
	 * @var  CHANGE PROFILE PICTURE
	 */
	 if(!$user->isAdmin()){ header('Location: ../index.html'); } 
 	 if(isset($_POST)){
 	 	$folders = explode('/',$_POST['folder']);
		$folder = '../uploads/manga/'.$folders['1'].'/';
		$folder2 = '../uploads/manga/'.$folders['1'].'/'.$folders['2'].'/';
		if ( ! is_dir($folder)) {mkdir($folder); }
		if ( ! is_dir($folder2)) {mkdir($folder2); }
		echo $h0manga->save_images($_POST['images'],$_POST['folder']);
	}