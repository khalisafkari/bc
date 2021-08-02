<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$c_manga['home_title']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="description" content="<?=$c_manga['home-meta-description']?>">
  <meta name="keywords" content="<?=$c_manga['home-meta-keyword']?>">
  <meta name="author" content="<?=$c_manga['rel_author']?>">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/owl.carousel.min.css">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
  <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/base.css?v=1.5" media="screen">

  <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="/favicon.ico" rel="icon" type="image/x-icon">

  <script src="/app/manga/themes/dark/assets/js/jquery.min.js"></script>
  
      <!-- Insert in <HEAD> TAG Tri-table-->
     <script async src="https://a.spolecznosci.net/core/399f019c46e791a270e583325f93ac74/main.js"></script>
      
	<?php 
		include 'views/customJsCSS.php'; 
		//include ROOT_DIR.'/app/manga/themes/dark/views/head.tag.php'; 
	?>
  <script type="text/javascript">
        var siteURL = "<?=DOMAIN?>";
        var ttazPage = "index";
        var userName = "<?=$_SESSION['userName']?>";
        var userId = "<?=$_SESSION['userId']?>";
    </script>
</head>
<body>

  <?php 

        // NAVBAR
  include ROOT_DIR.'/app/manga/themes/dark/views/navbar.php';
        // BODY

  echo '<div class="mCustomScrollbar" data-mcs-theme="dark">';
  echo '<div class="container">';
    include ROOT_DIR.'/app/manga/themes/dark/ads/home/header.php';

            // CONTENT
   // if(!$huy->cache('home_content')){
	echo '</br>';
    include ROOT_DIR.'/app/manga/themes/dark/views/home.content.top_day.php';
    echo '<div class="col-lg-8 col-sm-8">';
    include ROOT_DIR.'/app/manga/themes/dark/views/home.content.php';
    echo '</div>';

            // SIDEBAR
    echo '<div class="col-lg-4 col-sm-4">';
    include ROOT_DIR.'/app/manga/themes/dark/views/home.sidebar.php';
    
   //   $huy->cacheEnd('home_content');
   // }
			//Ads Video
	//include ROOT_DIR.'/app/manga/themes/dark/ads/home/videoads.php';

  echo '</div>'; 
  echo '</div>';
  echo '<div class="end">'; 

  include ROOT_DIR.'/app/manga/themes/dark/views/footer.php';

  echo '</div>';
  echo '</div>';
  //include ROOT_DIR.'/app/manga/themes/dark/ads/home/sticky.php';
  ?>
  <script src="/app/manga/themes/dark/assets/js/bootstrap.min.js" async></script>
  <script src="/app/manga/themes/dark/assets/js/owl.carousel.min.js"></script>
  <script src="/app/manga/themes/dark/assets/js/function.js?v=1.4"></script>
</body>
</html>