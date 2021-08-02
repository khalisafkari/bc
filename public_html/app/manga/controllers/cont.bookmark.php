<?php
 	include '../../../controllers/cont.main.php';
 	if(!$user->isLoggedIn()){ header('Location: ../index.html'); } 

 	sleep(1);
 	if($_POST && $_POST['token'] == $_SESSION['token'] && MANGA){
 		if(count($db->Query(APP_TABLES_PREFIX.'manga_bookmark','user',array('user'=>$_SESSION['userId'],'manga'=>$_POST['mid']))) > 0){
 			$db->Delete(APP_TABLES_PREFIX.'manga_bookmark',array('user'=>$_SESSION['userId'],'manga'=>$_POST['mid']));
 		}else{
 			$db->Create(APP_TABLES_PREFIX.'manga_bookmark',array('user'=>$_SESSION['userId'],'manga'=>$_POST['mid']));
 		}
 	}