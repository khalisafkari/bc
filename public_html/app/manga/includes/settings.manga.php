<?php
			$c_manga['theme'] = "dark";
			$c_manga['read_type'] = "1";
			$c_manga['read_type_choose'] = "1";
			$c_manga['comment_type'] = array('1','2',);
			$c_manga['fb_app'] = "";
			$c_manga['disqus_shortname'] = "";

			include 'seo.php';
			include ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/functions.php';
			include ROOT_DIR.'/app/manga/themes/'.$c_manga['theme'].'/includes/options.php';
		