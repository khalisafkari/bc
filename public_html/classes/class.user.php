<?
	/**
	 * This class is used to access a MySQL database
	 *
	 * @package Huy's
	 * @author  Huy
	 */

	class user extends huy {

		function isLoggedIn(){
			return (isset($_SESSION['userId']) ? true : false);
		}
		function isAdmin(){
			return ($_SESSION['thisUser']['role'] == 2 ? true : false);
		}
		function isUser() {
			return ($_SESSION['thisUser']['role'] == 1 ? true : false);
		}
		function isMod() {
			return ($_SESSION['thisUser']['role'] == 3 ? true : false);
		}
		function alert($alert,$text){
			 print('<div class="alert alert-'.$alert.'">'.$text.'</div>');
		}
		function exitAlert($alert,$text) {
			exit('<div class="alert alert-'.$alert.'">'.$text.'</div>');
		}
		function nameFromEmail($email){
			$parts = explode("@", $email);
			return $parts[0];
		}
		function ajaxForm($form, $redirect = NULL){
			echo	"<script> 
			$(document).ready(function() { 
				$('#".$form."_form').on('submit', function(e) {
					e.preventDefault();
					";
					echo			   "$('#".$form."_output').html(\"<div id='spinningSquaresG'><div id='spinningSquaresG_1' class='spinningSquaresG'></div><div id='spinningSquaresG_2' class='spinningSquaresG'></div><div id='spinningSquaresG_3' class='spinningSquaresG'></div><div id='spinningSquaresG_4' class='spinningSquaresG'></div><div id='spinningSquaresG_5' class='spinningSquaresG'></div><div id='spinningSquaresG_6' class='spinningSquaresG'></div><div id='spinningSquaresG_7' class='spinningSquaresG'></div><div id='spinningSquaresG_8' class='spinningSquaresG'></div></div>\");
					$(this).ajaxSubmit({
						beforeSubmit:  function(){
						},
						target: '#".$form."_output',
						success: function() {
							if( $('#".$form."_output').text() == '...' ){ window.location.href='".($redirect ? $redirect : '#')."'; }
						}
					});
				});
			});";
			echo "</script>";
		}
		function check_guest() {
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        	
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        	
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			if(!filter_var($ip, FILTER_VALIDATE_IP)) {
				return array();
			}
			$json = file_get_contents("http://ipinfo.io/{$ip}");
			$ip = json_decode($json);
			if ($ip->country === 'JP' || $ip->country === 'KR' || $ip->country === 'CN') {
				return true;
			}
			return false;
		}
		function info_user($value) {
			global $db;
			$query1 = $db->Query(APP_TABLES_PREFIX.'user', '*', array('id'=>$value));
			$query2 = $db->Query(APP_TABLES_PREFIX. 'user_meta', 'avatar', array('user'=>$value));
			return array_merge($query1[0], $query2[0]);
		}

	}
	
	?>
