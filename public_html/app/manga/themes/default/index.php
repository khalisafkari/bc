<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$c_manga['home_title']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="description" content="<?=$c_manga['home-meta-description']?>">
  <meta name="keywords" content="<?=$c_manga['home-meta-keyword']?>">
  <meta name="author" content="<?=$c_manga['rel_author']?>">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/owl.carousel.min.css">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/base.css" media="screen">

  <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="/favicon.ico" rel="icon" type="image/x-icon">
  
  <script src="/app/manga/themes/default/assets/js/jquery.min.js"></script>
  
  

  <?php include 'views/customJsCSS.php'; ?>
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
  include ROOT_DIR.'/app/manga/themes/default/views/navbar.php';
        // BODY

  echo '<div class="mCustomScrollbar" data-mcs-theme="dark">';
  echo '<div class="container">';

            // CONTENT
   // if(!$huy->cache('home_content')){

    include ROOT_DIR.'/app/manga/themes/default/views/home.content.top_day.php';
    echo '<div class="col-lg-8 col-sm-8">';
    include ROOT_DIR.'/app/manga/themes/default/views/home.content.php';
    echo '</div>';

            // SIDEBAR
    echo '<div class="col-lg-4 col-sm-4">';
    include ROOT_DIR.'/app/manga/themes/default/views/home.sidebar.php';
    
   //   $huy->cacheEnd('home_content');
   // }

  echo '</div>'; 
  echo '</div>';
  echo '<div class="end">'; 

  include ROOT_DIR.'/app/manga/themes/default/views/footer.php';

  echo '</div>';
  echo '</div>';
  ?>
  <script src="/app/manga/themes/default/assets/js/bootstrap.min.js" async></script>
  <script src="/app/manga/themes/default/assets/js/owl.carousel.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/function.js"></script>
</body>
</html>