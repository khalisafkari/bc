<?php
 	include '../../../controllers/cont.main.php';

 	if(isset($_POST) && MANGA){
 		$slug = $huy->slug($_POST['slug']);
 		echo $slug;
 	}