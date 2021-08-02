<?php
 	include '../../../controllers/cont.main.php';

	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);


	/**
	 * @var  CHANGE PROFILE PICTURE
	 */
	 if(!$user->isAdmin()){ header('Location: ../index.html'); } 
 	 if(isset($_POST)){
		echo $h0manga->save_image($_POST['image']);
	}