<?php

ob_start();
session_start();
error_reporting(E_WARNING);

/* ROOT DIR */
define( 'ROOT_DIR', realpath(dirname(__FILE__) . '/..') );

/* INCLUDE IMPORTANT FILES*/
include ROOT_DIR.'/includes/config.php';
include ROOT_DIR.'/includes/settings.php';
	include ROOT_DIR.'/includes/h0fw.php';	// H0FW
	include ROOT_DIR.'/includes/apps.php';	// H0FW


	/*	Include classes */

	include ROOT_DIR.'/classes/class.db.php';
	include ROOT_DIR.'/classes/class.huy.php';
	include ROOT_DIR.'/classes/class.user.php';
	include ROOT_DIR.'/classes/class.mobile_detech.php';
	include ROOT_DIR.'/classes/class.jsUnpacker.php';
	include ROOT_DIR.'/classes/class.pagination.php';

	/* Include locale */
	
	include ROOT_DIR.'/locales/'.$config['locale'].'.php';

	/* INCLUDE APP */
	
	foreach($apps as $key => $value){

		// INCLUDE CONTROLLERS
		include ROOT_DIR.'/app/'.$value.'/controllers/cont.'.$value.'.php';

		// INCLUDE SETTINGS
		include ROOT_DIR.'/app/'.$value.'/includes/settings.'.$value.'.php';

		// INCLUDE LOCALE
		include ROOT_DIR.'/app/'.$value.'/locales/'.$config['locale'].'.php';
	}

	/* Mailer class: PHPMailer */
	require ROOT_DIR.'/PHPMailer/PHPMailerAutoload.php';

	/*  Calling object */
	
	$db = MySQLIDatabase::GetInstance();
	$huy = new huy();
	$user = new user();
	$detech = new Mobile_Detect(); // System mobie detech
	$unpacker = new JavaScriptUnpacker(); // Unpacker javscript

	/* SOME Global & common function */
	$L = $huy->Cookie();
	
	date_default_timezone_set($config['timezone']);
	$timeint = time();
	@$now = date("Y-m-d H:i:s", $timeint);
	$avtFolder = 'uploads/avatars/';

	/* System  */
	$header_cheat = 'HTTP/1.1 503 Service Temporarily Unavailable';
	if (!MANGA) {
		@die(header($header_cheat));
	} else {
		/*  Generate TOKEN for whole FORM */
		if(!isset($_POST['token']) && !isset($_SESSION['token'])){
			$_SESSION['token'] = md5(uniqid(rand(), true));
		}
	}

	/* System Captcha */

	if (isset($_GET['type']) && $_GET['type'] == 'captcha') {

		function create_captcha() {
			$md5_hash = md5(rand(0,999));
			$captcha = substr($md5_hash, 15, 5);
			$_SESSION['captcha'] = $captcha;
			$width = 100;
			$height = 30;
			$image = ImageCreate($width, $height);
			$nen = ImageColorAllocate($image, 119, 41, 83);
			$chu = ImageColorAllocate($image, 255, 255, 255);
			ImageFill($image, 0, 0, $nen);
			ImageString($image, 5, 30, 6, $captcha, $chu);
			header("Content-Type: image/jpeg");
			ImageJpeg($image);
			$img = ImageDestroy($image);
			return $img;
		}
		echo create_captcha();
	}
	/* USER AUTO LOGIN IF THEY ARE REMEMBERED */

	if(isset($_COOKIE['userId']) && isset($_COOKIE['hash'])){
		$select = $db->Query(APP_TABLES_PREFIX . 'user','password',array('id'=>$_COOKIE['userId']));
		if($_COOKIE['hash'] == md5($_COOKIE['userId'].$select['0']['password'])){ // CHECK hash code
			$_SESSION['userId'] = $_COOKIE['userId'];
			$_SESSION['userName'] = $_COOKIE['userName'];
		}else{
			unset($_COOKIE['userId']); 
		}
	}
	
	/* USER initialize */
	if(isset($_SESSION['userId']) && !isset($_SESSION['thisUser'])){
		// If user logged in then..
		// This user information
		$thisUserInfo = $db->Query(APP_TABLES_PREFIX . 'user','*',array('id'=>$_SESSION['userId']),null,null,null,'1');
		$thisUserInfo = $thisUserInfo[0];
		//This user meta and fields
		$thisUserMeta = $db->Query(APP_TABLES_PREFIX . 'user_meta','*',array('user'=>$_SESSION['userId']),null,null,null,'1');
		$thisUserMeta = $thisUserMeta[0];
		//Unset some no-need fields
		unset($thisUserInfo['password']);
		unset($thisUserMeta['id']);
		unset($thisUserMeta['user']);

		$thisUser = array_merge($thisUserInfo, $thisUserMeta);
		$_SESSION['thisUser'] = $thisUser;	
	}

	function getRealIPAddress(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	if(getRealIPAddress()==="103.74.123.184"){
		@die(header('HTTP/1.1 503 Service Temporarily Unavailable'));
			//Do action if country is UK or not from Europe
	}
