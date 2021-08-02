<?php
	// MAIN CONTROLLER
 	// Include already 

	// CONTROLLERS OF INDEX

		// REPLACE TITLE
	 $c_manga['home_title'] = preg_replace('/{site_title}/i', $c_manga['site_title'], $c_manga['home_title']);

	// INCLUDE INDEX IN [THEME] 
	
	if(!$user->isLoggedIn()){
			header('Location: https:///');
		}
		else {
			header('Location: https://welovemanga.net/');
		}
       
    include 'themes/'.$c_manga['theme'].'/index.php';
        