<?php
include 'cont.main.php';

	/**
	 * @var  LOGIN
	 */
	//sleep(2);
	if(!empty($_POST) && $_GET['action'] == 'login' && $_GET['token'] == $_SESSION['token']){
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$user->alert('danger', $l['email_not_exist']);
			die;
		}
		if (!$huy->isExist(APP_TABLES_PREFIX. 'user', 'id', array('email'=>$_POST['email']))) {
			$user->alert('danger',$l['email_not_exist']);
			die;
		} else {
			if(!$huy->isExist(APP_TABLES_PREFIX . 'user','id',array('email'=>$_POST['email'],'password'=>sha1($_POST['password'])))){
				$user->	alert('danger',$l['password_not_right']);
			} else {
				$result = $db->Query(APP_TABLES_PREFIX.'user', 'role', array('email'=>$_POST['email']),NULL,NULL,NULL,1);
				if($result[0]['role'] == 0) {
					$user->alert('danger', $l['email_not_confirmed']);
				} else {
					if(!empty($_POST["isRemember"]) == '1'){
						$user = $db->Query(APP_TABLES_PREFIX . 'user','*',array('email'=>$_POST['email'],'password'=>sha1($_POST['password'])));
						$db->Update(APP_TABLES_PREFIX . 'user',array('email'=>$_POST['email']),array('last_login'=>$now));
						$_SESSION['userId'] = $user['0']['id'];
						$_SESSION['userName'] = $$user['0']['name'];

						setcookie("userName",  $user['0']['name'],  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 ); 
						setcookie("userId",  $user['0']['id'],  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 );
						setcookie("hash",  md5($user['0']['id'].$user['0']['password']),  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 );
						echo '...';

					}else{
						$user = $db->Query(APP_TABLES_PREFIX . 'user','*',array('email'=>$_POST['email'],'password'=>sha1($_POST['password'])));
						$db->Update(APP_TABLES_PREFIX . 'user',array('email'=>$_POST['email']),array('last_login'=>$now));
						$_SESSION['userId'] = $user['0']['id'];
						$_SESSION['userName'] = $user['0']['name'];
						echo '...';
					}
				}
				
			}

		}
	}


		/**
	 * @var  REGISTER
	 */

		if(!empty($_POST) && $_GET['action'] == 'register' && $_GET['token'] == $_SESSION['token']){
			if ($huy->isExist(APP_TABLES_PREFIX. 'user', 'id', array('email'=>$_POST['email']))) {
				$user->alert('danger', $l['one_account_only'] );
				die;
			}
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$user->alert('danger', $l['invalid_email'] );
				die;
			}else if(empty($_POST['password'])){
				$user->alert('danger', $l['empty_pw'] );
			}else if($_POST['password'] != $_POST['password2']){
				$user->alert('danger', $l['pw_dont_match'] );
			} else if ($_POST['captcha'] != $_SESSION['captcha']) {
				$user->alert('danger', $l['invalid_captcha']);
			}else if(!$huy->isExist(APP_TABLES_PREFIX . 'user','id',array('email'=>$_POST['email']))){

			// does user need to activate
				$_POST['role'] = ($config['user_activate'] == '1') ? '0' : '1';
			// user name get from his email 
				$_POST['name'] = $user->nameFromEmail($_POST['email']);
			// Generate activate code
				$activate_code = md5(uniqid(rand(), true));

			// Insert into database: userInfo : userCode (for activation and password change) : userMeta (For fields..)
				$userInfo = array('name'=>$_POST['name'],
					'email'=>$_POST['email'],
					'password'=>sha1($_POST['password']),
					'role'=>$_POST['role'],
					'register_ip'=>$_SERVER['REMOTE_ADDR'],
					'register_date'=>$now
					);
				$userCode = array('email'=>$_POST['email'],
					'code'=>$activate_code
					);
				$user->Create(APP_TABLES_PREFIX . 'user',$userInfo);
				if ($huy->isExist(APP_TABLES_PREFIX.'user_code', 'code', array('email'=>$_POST['email']))) {
					$user->Delete(APP_TABLES_PREFIX.'user_code', array('email'=>$_POST['email']));
				}
				$user->Create(APP_TABLES_PREFIX . 'user_code',$userCode);
				$userId = $user->Query(APP_TABLES_PREFIX . 'user','id',array('email'=>$_POST['email']));
				$userMeta = array('user'=>$userId['0']['id'],
					'avatar'=>$config['default_avatar']
					);
				$user->Create(APP_TABLES_PREFIX . 'user_meta', $userMeta);
				$user->alert('success', $l['register_done'] );
			// MAIL SENDER 
				if($config['user_activate'] == '1'){
					$string = file_get_contents(ROOT_DIR.'/includes/template-active_account.php');
					$string = str_replace('{{user}}', $_POST['name'], $string);
					$string = str_replace('{{code}}', $activate_code, $string);
					$string = str_replace('{{email}}', $_POST['email'], $string);
					$mail = new PHPMailer();
				// $mail->SMTPDebug = 2;
				// $mail->Debugoutput = 'html';
				//is SMTP in use?
					if(SMTP == 1){

						$mail->isSMTP();
						$mail->Host = SMTP_HOST;
						$mail->Port = SMTP_PORT;
						$mail->SMTPSecure = SMTP_Secure;
						$mail->SMTPAuth = SMTP_Auth;
						$mail->Username = SMTP_Username;
						$mail->Password = SMTP_Password;
					}
					$mail->setFrom(email_from, 'LoveHug.net');
					$mail->addReplyTo(email_from, $config['siteTitle']);
					$mail->addAddress($_POST['email']);
					$mail->Subject = $l['Active_subject']. 'LoveHug.net';
					$mail->IsHTML(true);
					$mail->CharSet = "UTF-8";
					$mail->Body=$string;
					setcookie("isRegistered",  1,  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 ); 
					if (!$mail->send()) {
						echo "Mailer Error: " . $mail->ErrorInfo;
					} else {
						$user->alert('success', $l['Check_your_inbox']  );
					}
				}	
			// END MAIL SENDER	
			}else{
				$user->alert('danger', $l['Already_registered'] );
			}
		}


	/**
	 * @var  LOGOUT
	 */

	if($_GET['action'] == 'logout' && $_GET['token'] == $_SESSION['token']){
		session_unset();
		setcookie("userId",  NULL,  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 );
		setcookie("userName",  NULL,  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 );
		echo '...';
	}

	/** 
	* @var ACTIVATE ACCOUNT
	*/

	if($_GET['action'] == 'activate' && !empty($_GET['code'])){
		if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
			$user->alert('danger', $l['invalid_email'] );
			die;
		}
		$check_code = $db->Query(APP_TABLES_PREFIX . 'user_code','code',array('email'=>$_GET['email'],'code'=>$_GET['code']));
		if ($check_code[0]['code'] == $_GET['code']) {
			$db->Update(APP_TABLES_PREFIX . 'user',array('email'=>$_GET['email']),array('role'=>1));
			$db->Delete(APP_TABLES_PREFIX . 'user_code',array('email'=>$_GET['email']));
			echo $l['Active_successfully'];
			header( "Refresh:2; url=../ucp/login.html", true, 303);
		}else{
			echo '<script>alert("'.$l['Active_error'].'")</script>';
			header( "Refresh:0; url=../ucp/login.html", true, 303);
		}
	}

	/** 
	* @var UPDATE INFORMATION
	*/

	if(!empty($_POST) && $_GET['action'] == 'update_info' && $_GET['token'] == $_SESSION['token']){
		if (!preg_match('#^[a-zA-Z][a-zA-z0-9_\.\s]{4,31}$#', $_POST['name'])) {
			$user->alert('danger', $l['valid_name']);
			die;
		}
		$_POST['old_name'] = str_replace(array('\'','\"'), '', $_POST['old_name']);
		$_POST['name'] = str_replace(array('\'','\"'), '', $_POST['name']);
		$_POST['name'] = addslashes($_POST['name']);
		if ($_POST['old_name'] != $_POST['name']) {
			if ($huy->isExist(APP_TABLES_PREFIX. 'user', 'id', array('name'=>$_POST['name']))) {
				$user->alert('danger', $l['Error_name']);
			} else {
				$update = $db->Update(APP_TABLES_PREFIX . 'user',array('id'=>$_SESSION['userId']),array('name'=>$_POST['name']));
				if ($update) {
					$_SESSION['userName'] = $_POST['name'];
					$_COOKIE['userName'] = $_POST['name'];
					}
			// IF he change his pw
				if(!empty($_POST['password']) && $_POST['password'] != NULL){
					$db->Update(APP_TABLES_PREFIX . 'user',array('id'=>$_SESSION[userId]),array('password'=>sha1($_POST['password'])));
					setcookie("hash",  md5($_SESSION['userId'].$_POST['password']),  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 ); 
				}
				$user->alert('success',$l['Info_update_success']);
			}
		} else {
			$db->Update(APP_TABLES_PREFIX . 'user',array('id'=>$_SESSION['userId']),array('name'=>$_POST['name']));
			$_SESSION['thisUser']['name'] = $_POST['name'];
			$_SESSION['userName'] ? $_SESSION['userName'] = $_POST['name'] : '' ;
			$_COOKIE['userName'] ? $_COOKIE['userName'] = $_POST['name'] : '' ;
			// IF he change his pw
			if(!empty($_POST['password']) && $_POST['password'] != NULL){
				$db->Update(APP_TABLES_PREFIX . 'user',array('id'=>$_SESSION[userId]),array('password'=>sha1($_POST['password'])));
				setcookie("hash",  md5($_SESSION['userId'].$_POST['password']),  time() + (10 * 365 * 24 * 60 * 60), '/', NULL, 0 ); 
			}
			$user->alert('success',$l['Info_update_success']);
		}
		
	}


	/** 
	* @var RESET PW STEP 1
	*/

	if(!empty($_POST) && $_GET['action'] == 'forgot_password' && $_GET['token'] == $_SESSION['token']){
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$user->alert('danger', $l['email_not_exist']);
			die;
		}
		if (empty($_POST['email'])) {
			$user->alert('danger', $l['add_email']);
		}else {
			if (!$huy->isExist(APP_TABLES_PREFIX. 'user', 'id', array('email'=>$_POST['email']))) {
				$user->alert('danger',$l['email_not_exist']);
			} else {
				$code = md5(uniqid(rand(), true));
				$userCode = array('email'=>$_POST['email'],
					'code'=>$code
					);
				if($huy->isExist(APP_TABLES_PREFIX . 'user_code','code',array('email'=>$_POST['email']))){
					$db->Update(APP_TABLES_PREFIX . 'user_code', array('email'=>$_POST['email']), $userCode);
				}else{
					$db->Create(APP_TABLES_PREFIX . 'user_code', $userCode);
				}
				$string = file_get_contents(ROOT_DIR.'/includes/template-forgot_password.php');
				$string = str_replace('{{code}}', $code, $string);
				$string = str_replace('{{email}}', $_POST['email'], $string);
				$mail = new PHPMailer();
				// $mail->SMTPDebug = 2;
				// $mail->Debugoutput = 'html';
				// is SMTP in use?
				if(SMTP == 1){

					$mail->isSMTP();
					$mail->Host = SMTP_HOST;
					$mail->Port = SMTP_PORT;
					$mail->SMTPSecure = SMTP_Secure;
					$mail->SMTPAuth = SMTP_Auth;
					$mail->Username = SMTP_Username;
					$mail->Password = SMTP_Password;
				}
				$mail->setFrom(email_from, 'LoveHug.net');
				$mail->addReplyTo(email_from, $config['siteTitle'] );
				$mail->addAddress($_POST['email']);
				$mail->Subject = $l['Reset_subject']. 'lovehug.net';
				$mail->IsHTML(true);
				$mail->CharSet = "UTF-8";
				$mail->Body=$string;
				if (!$mail->send()) {
					$user->alert('danger',$l['not_send_email']);
				} else {
					$user->alert('success', $l['Check_your_inbox_2']  );
				}
			}
		}

		
	}

	/** 
	* @var RESET PW STEP 2
	*/

	if($_GET['action'] == 'reset_pw' && !empty($_GET['code']) && !empty($_GET['email'])){
		/*if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$user->alert('danger', $l['email_not_exist']);
			die;
		}*/
		$thisCode = $db->Query(APP_TABLES_PREFIX . 'user_code','code',array('email'=>$_GET['email']));
		if ($thisCode[0]['code'] == $_GET['code']) {
			$rand = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
			$db->UPDATE(APP_TABLES_PREFIX . 'user',array('email'=>$_GET['email']),array('password'=>sha1($rand)));
			$db->Delete(APP_TABLES_PREFIX . 'user_code',array('email'=>$_GET['email']));
			echo $l['Your_new_pw'].': <strong>'. $rand.'</strong><br />';
			echo '<a href="/ucp/login.html">'.$l['Back_UCP'].'<a/>';
		}else{
			echo '<script>alert("An error occurred, please try again!")</script>';
			header( "Refresh:0; url=../ucp/login.html", true, 303);
		}
	}