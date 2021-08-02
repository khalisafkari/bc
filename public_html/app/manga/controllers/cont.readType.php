<?
include '../../../controllers/cont.main.php';

if($_POST && $_POST['token'] == $_SESSION['token']){
	if($_POST['type'] == '1'){

		setcookie("read_type",  '1',  time() + (10 * 365 * 24 * 60 * 60)); 
		echo '...';
		exit();

	}elseif($_POST['type'] == '2'){

		setcookie("read_type",  '2',  time() + (10 * 365 * 24 * 60 * 60)); 
		echo '...';
		exit();

	}elseif ($_POST['type'] == '3'){
		setcookie("read_type",  '3',  time() + (10 * 365 * 24 * 60 * 60)); 
		echo '...';
		exit();
	}
}		