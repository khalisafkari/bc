<?php
	include 'controllers/cont.main.php';

	// Application
	$p = (isset($_GET['p']) ? $_GET['p'] : 'index');
	$ps = explode('-', $p);
	$file = $ps['0'];

	$app = (isset($_GET['app']) ? $_GET['app'] : $config['default_app']);
		if (file_exists(ROOT_DIR.'/app/'.$app.'/'.$file.'.php')) {
			include 'app/'.$app.'/'.$ps['0'].'.php';
		}else{
			echo '404, dude';
		}
?>